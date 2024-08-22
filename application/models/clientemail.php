<?php

use Doctrine\ORM\Query\ResultSetMapping;

class ClientEmail extends MY_Model {
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    var $em;
    /**
     * @var CI_DB_driver
     */
    var $db;
    /**
     * @var Settings
     */
    var $ci;


    function __construct() {
        parent::__construct();
        $this->ci =& get_instance();
    }

    /**
     * @param bool $hidden
     * @return array
     */
    function getTemplateTypes($hidden = false) {
        //default call of the function only grabs the ones that aren't hidden - calling with true as a parameter grabs all - LMK if that's ok or you want it otherwise
        return \models\ClientEmailTemplateType::getAllTypes($hidden);
    }

    /**
     * @param int $companyId - set to null to get only admin templates
     * @param int $templateType required template type ID
     * @param bool (optional) $enabledOnly - set to true to return only enabled templates
     * @param bool (optional) $disabledOnly - set to true to return only disabled templates
     * @return Array
     */
    function getTemplates($companyId, $templateType, $enabledOnly = false, $disabledOnly = false) {
        $this->ci->load->database();
        //$query = 'select distinct(cet.templateId) from client_email_templates cet';
        if (!$companyId) {
            $dql = "SELECT cet
            FROM \models\ClientEmailTemplate cet
           
            WHERE cet.company is null
            AND cet.template_type = :templateType
            GROUP BY cet.templateId
            ORDER BY cet.ord";
            $query = $this->em->createQuery($dql);
            $query->setParameter(':templateType', $templateType);
            //Cache It
            //$query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_TYPE_ADMIN_PROPOSAL_PAGE_TEMPLATE_LIST.$templateType);

            
        } else {

            $rsm = new ResultSetMapping();
            $rsm->addEntityResult('\models\ClientEmailTemplate', 'cet');
            $rsm->addFieldResult('cet', 'templateId', 'templateId');
            $rsm->addFieldResult('cet', 'templateName', 'templateName');
            $rsm->addFieldResult('cet', 'templateBody', 'templateBody');
            $rsm->addFieldResult('cet', 'templateSubject', 'templateSubject');
            $rsm->addFieldResult('cet', 'templateDescription', 'templateDescription');
            $rsm->addMetaResult('cet', 'company', 'company');
            $rsm->addMetaResult('cet', 'template_type', 'template_type'); 
            //$rsm->addMetaResult('u', 'address_id', 'address_id');
    
            $sql = "select cet.templateId,cet.templateName,cet.templateBody,cet.templateSubject,cet.templateDescription,cet.company,cet.template_type
            from client_email_templates cet 
            left join client_email_order ceo on cet.templateId = ceo.templateId AND ceo.company = :companyId
            left join client_email_disabled ced on cet.templateId = ced.templateId AND ced.company = :companyId
            where (cet.company is null or cet.company = :companyId) and (cet.template_type = :templateType)
            
                    ";

                    if ($enabledOnly) {
                        $sql .= " AND ced.templateId IS NULL";
                    }
                    if ($disabledOnly) {
                        $sql .= " AND ced.templateID IS NOT NULL";
                    }
                    $sql .= " GROUP BY cet.templateId order by -ceo.ord desc, -cet.ord desc";


            $query = $this->em->createNativeQuery($sql, $rsm);
            $query->setParameter(':companyId', $companyId);
            $query->setParameter(':templateType', $templateType);
    
            // Emable cache with id - company_business_type_$companyId
            // Cache it
            $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_TYPE_USER_PROPOSAL_PAGE_TEMPLATE_LIST . $companyId.'_'. $templateType);


        }

        //$templatesRaw = $this->ci->db->query($query);
        $templatesRaw = $query->getResult();

        // $templates = array();
        // foreach ($templatesRaw as $template) {
        //     $test = $this->em->find('\models\ClientEmailTemplate', $template->getTemplateId());
          //   var_dump($template->getTemplateName());die;
        //     $templates[] = $this->em->find('\models\ClientEmailTemplate', $template->getTemplateId());
         //}
        
        return $templatesRaw;
    }

    function getAllTemplates($companyId, $templateTypeId) {
        return array_merge($this->getTemplates($companyId, $templateTypeId, true), $this->getTemplates($companyId, $templateTypeId, false, true));
    }

    /**
     * @param $companyId
     * @param $templateTypeId
     * @return int
     */
    function countEnabledTemplatesOfType($companyId, $templateTypeId) {
        return count($this->getTemplates($companyId, $templateTypeId, true));
    }

    /**
     * @param $templateId
     * @return \models\ClientEmailTemplate
     */
    function getTemplate($templateId) {
        $template = $this->ci->doctrine->em->find('\models\ClientEmailTemplate', $templateId);
        return $template;
    }

    /*
     *  I set this up as per your suggestion, but there is already the function ClientTemplateType->getFields() which gets the collection. I've used it in this function
     */
    function getTemplateFields($templateTypeId) {
        //returns an associative array of the template fields Array{'{field.code}' => 'Field Name'}
        $templateType = $this->ci->doctrine->em->find('\models\ClientEmailTemplateType', $templateTypeId);
        /* @var $templateType \models\ClientEmailTemplateType */
        $fields = $templateType->getFields();

        $fieldsArray = [];

        if (count($fields)) {
            foreach ($fields as $field) {
                /* @var $field \models\ClientEmailTemplateTypeField */
                $fieldsArray['{' . $field->getFieldCode() . '}'] = $field->getFieldName();
            }
        }

        return $fieldsArray;
    }

    function clearCompanyOrder($companyId, $templateTypeId) {
        $this->ci->load->database();

        $sql = "DELETE ceo FROM client_email_order ceo
                INNER JOIN client_email_templates cet ON ceo.templateId = cet.templateId
                AND cet.template_type = {$templateTypeId}
                AND ceo.company = {$companyId}";

        $this->ci->db->query($sql);
    }


    function setCompanyOrder($company, array $templates) {

        if (count($templates)) {
            $counter = 1;
            foreach ($templates as $templateId) {
                $ceo = new \models\ClientEmailOrder();
                $ceo->setCompany($company);
                $ceo->setTemplateId($templateId);
                $ceo->setOrd($counter);
                $this->doctrine->em->persist($ceo);
                $counter++;
            }
            $this->doctrine->em->flush();
        }
    }

    /**
     * @return models\ClientEmailTemplate
     * @param $companyId
     * @param $templateTypeId
     * @return mixed
     */
    function getDefaultTemplate($companyId, $templateTypeId) {
        $d = $this->getTemplates($companyId, $templateTypeId, true);
        return array_shift($d);
    }

    function enable($companyId, $templateId) {

        $this->ci->load->database();

        // Remove the disabled record
        $sql = "DELETE ced FROM client_email_disabled ced
                WHERE ced.templateId = {$templateId}
                AND ced.company = {$companyId}";

        $this->ci->db->query($sql);
    }


    /**
     * @param $companyId
     * @param $templateId
     */
    function disable($companyId, $templateId) {

        // Save the disable
        $ced = new \models\ClientEmailDisabled();
        $ced->setTemplateId($templateId);
        $ced->setCompany($companyId);
        $this->ci->doctrine->em->persist($ced);
        $this->ci->doctrine->em->flush();
    }

    /**
     * @param $companyId
     * @param $templateId
     */
    function deleteDisabled($companyId, $templateId) {
        $this->ci->load->database();

        $sql = "DELETE ced FROM client_email_disabled ced
                WHERE ced.templateId = {$templateId}
                AND ced.company = {$companyId}";

        $this->ci->db->query($sql);
    }

    /**
     * @param $companyId
     * @param $templateId
     */
    function deleteOrdered($companyId, $templateId) {
        $this->ci->load->database();

        $sql = "DELETE ceo FROM client_email_order ceo
                WHERE ceo.templateId = {$templateId}
                AND ceo.company = {$companyId}";

        $this->ci->db->query($sql);
    }

    /**
     * @param $companyId
     * @param $templateId
     */
    function delete($companyId, $templateId) {

        $template = $this->ci->doctrine->em->find('\models\ClientEmailTemplate', $templateId);
        $this->ci->doctrine->em->remove($template);
        $this->ci->doctrine->em->flush();

        $this->deleteDisabled($companyId, $templateId);
    }

    function sendEmail($to, $subject, $message, $templateId, Array $data) {
        //load template info
        $this->getTemplate($templateId);

    }
}