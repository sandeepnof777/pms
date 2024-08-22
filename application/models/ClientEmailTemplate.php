<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="client_email_templates")
 */
class ClientEmailTemplate
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $templateId;
    /**
     * @ORM\ManyToOne(targetEntity="Companies", cascade={"persist"}, inversedBy="clientEmails")
     * @ORM\JoinColumn (name="company", referencedColumnName="companyId")
     */
    private $company;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $templateName;
    /**
     * @ORM\Column(type="string", length=2048, nullable=true)
     */
    private $templateDescription;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $templateSubject;
    /**
      * @ORM\Column(type="text", nullable=true)
     */
    private $templateBody;
    /**
     * @ORM\OneToMany(targetEntity="Email_templates_fields", mappedBy="template", cascade={"remove"})
     **/
    private $fields;
    /**
     * @ORM\ManyToOne(targetEntity="ClientEmailTemplateType", cascade={"persist"})
     * @ORM\JoinColumn (name="template_type", referencedColumnName="id")
     */
    private $template_type;
    /**
     * @ORM\Column(type="integer")
     */
    private $ord;
    /**
     * @ORM\Column(type="integer")
     */
    private $default_template;
    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    public function getTemplateId()
    {
        return $this->templateId;
    }

    public function setTemplateId($templateId)
    {
        $this->templateId = $templateId;
    }

    /**
     * @param \models\Companies $company
     */
    public function setCompany(\models\Companies $company)
    {
        $this->company = $company;
    }

    /**
     * @return \models\Companies
     */
    public function getCompany()
    {
        return $this->company;
    }

    public function getTemplateName()
    {
        return $this->templateName;
    }

    public function setTemplateName($templateName)
    {
        $this->templateName = $templateName;
    }

    public function getTemplateBody()
    {
        return $this->templateBody;
    }

    public function setTemplateBody($templateBody)
    {
        $this->templateBody = $templateBody;
    }

    public function getFields()
    {
        return $this->fields;
    }

    public function getTemplateSubject()
    {
        return $this->templateSubject;
    }

    public function setTemplateSubject($templateSubject)
    {
        $this->templateSubject = $templateSubject;
    }

    public function getTemplateDescription()
    {
        return $this->templateDescription;
    }

    public function setTemplateDescription($templateDescription)
    {
        $this->templateDescription = $templateDescription;
    }

    public function setOrder($order)
    {
        $this->ord = $order;
    }

    public function getOrder()
    {
        return $this->ord;
    }

    public function setDefaultTemplate($defaultTemplate)
    {
        $this->default_template = $defaultTemplate;
    }

    public function getDefaultTemplate()
    {
        return $this->default_template;
    }

    /**
     * @return mixed
     */
    public function getUpdateAt()
    {
        return $this->updated_at;
    }


    /**
     * @param mixed $updated_at
     */
    public function setUpdateAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @param ClientEmailTemplateType $templateType
     */
    public function setTemplateType(\models\ClientEmailTemplateType $templateType)
    {
        $this->template_type = $templateType;
    }

    /**
     * @return \models\ClientEmailTemplateType
     */
    public function getTemplateType()
    {
        return $this->template_type;
    }

    /**
     * @return bool true if disabled, false if not
     */
    public function isDisabled($companyId)
    {
        $CI =& get_instance();
        $CI->load->database();
        return $CI->db->query("select id from client_email_disabled where company = " . $companyId . " and templateId = " . $this->templateId)->num_rows();
    }

    public static function getAdminTemplates($typeId = null)
    {
        $CI =& get_instance();

        $dql = "SELECT cet
                FROM \models\ClientEmailTemplate cet
                WHERE cet.company IS NULL";

        if ($typeId) {
            $dql .= " AND cet.template_type = :templateType";
        }

        $dql .= " ORDER BY cet.ord ASC";

        $query = $CI->em->createQuery($dql);

        if ($typeId) {
            $query->setParameter('templateType', $typeId);
        }

        return $query->getResult();
    }

}