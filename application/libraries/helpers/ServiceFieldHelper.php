<?php


class ServiceFieldHelper extends BaseHelper {

    /* @var \models\ServiceField */
    private $field;

    /* @var \models\Services */
    private $service;


    public function __construct(array $params = [])
    {
        parent::__construct($params);

        if (isset($params['field'])){
            $this->setField($params['field']);
        }
    }

    /**
     * @return \models\ServiceField
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param \models\ServiceField $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    /**
     * @return \models\Services
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param \models\Services $service
     */
    public function setService($service)
    {
        $this->service = $service;
    }

    /**
     *  Process adding a new service text
     */
    public function add()
    {
        // Check fieldcode for uniqueness
        $fieldCode = str_replace(' ', '_', preg_replace("/[^ \w]+/", "", strtolower($this->input->post('fieldCode'))));
        if (\models\ServiceField::isUnique(
            $fieldCode,
            $this->getService()->getServiceId(),
            $this->getAccount()->getCompany()->getCompanyId())
        ){
            $field = new \models\ServiceField();
            $field->setOrd(99);
            $field->setService($this->getService()->getServiceid());
            $field->setFieldName($this->input->post('fieldName'));
            $field->setFieldCode($fieldCode);
            $field->setFieldType($this->input->post('fieldType'));
            $field->setFieldValue($this->input->post('fieldValue'));
            $field->setCompany($this->getAccount()->getCompany()->getCompanyId());
            $this->em->persist($field);
            $this->em->flush();
            $this->em->clear();

            if ($field->getFieldId()){
                $this->setAlertClass('success');
                $this->setAlertMessage('Service Field Added!');

                $this->logManager->add('service_field_add', 'User added field "' . $field->getFieldName() . '"');
            }
            else {
                $this->setAlertClass('error');
                $this->setAlertMessage('There was a problem saving the field');
            }
        }
        else {
            $this->setAlertClass('error');
            $this->setAlertMessage('Please choose a new field code. The code entered is already in use.');
        }


    }

    /**
     *  Process editing a new service text
     */
    public function edit()
    {
        $field = $this->em->find('models\ServiceField', $this->input->post('fId'));
        if (!$field) {
            $this->session->set_flashdata('error', 'Field does not exist!');
        } else {
            $field->setFieldName($this->input->post('editFieldName'));
            $field->setFieldCode(str_replace(' ', '_', preg_replace("/[^ \w]+/", "", strtolower($this->input->post('editFieldCode')))));
            $field->setFieldType($this->input->post('editFieldType'));
            $field->setFieldValue($this->input->post('editFieldValue'));
            $this->em->persist($field);
            $this->em->flush();

            $this->setAlertClass('success');
            $this->setAlertMessage('Service Field Edited!');

            $this->logManager->add('service_field_edit', 'User edited field "' . $field->getFieldName() . '"');
        }
    }

    /**
     * Process deleting a service field
     */
    public function delete()
    {
        $field = $this->getField();
        /* @var $field \models\ServiceField */
        $serviceId = $field->getService();

        if (!$field){
            $this->setAlertClass('error');
            $this->setAlertMessage('Field could not be loaded');
        }
        else if ($field->deleteAuth($this->getAccount())){

            // Delete if belongs to this company
            if ($field->getCompany() == $this->getAccount()->getCompany()->getCompanyId()) {
                $this->em->remove($field);
            }
            else {
                //Default, so disable
                $sfd = new \models\ServiceFieldDisabled();
                $sfd->setCompanyId($this->getAccount()->getCompany()->getCompanyId());
                $sfd->setFieldId($this->getField()->getFieldId());

                $this->em->persist($sfd);
                $this->em->flush();
            }
            $this->em->flush();

            $this->setAlertClass('success');
            $this->setAlertMessage('Service Field Deleted!');

            $this->logManager->add('service_field_delete', 'User deleted field "' . $field->getFieldName() . '"');
        }
        else {
            $this->setAlertClass('error');
            $this->setAlertMessage('You do not have permission to delete this field!');
        }

        $this->setRedirect($this->getRedirectBase() . $serviceId);
    }

    function disable() {

        $field = $this->getField();

        if($field->deleteAuth($this->getAccount())){

            $sfd = new \models\ServiceFieldDisabled();
            $sfd->setCompanyId($this->getAccount()->getCompany()->getCompanyId());
            $sfd->setFieldId($this->getField()->getFieldId());

            $this->em->persist($sfd);
            $this->em->flush();

            $this->setAlertClass('success');
            $this->setAlertMessage('Service Field Disabled!');

            $this->logManager->add('service_field_disabled', 'User disabled field "' . $field->getFieldName() . '"');
        }
        else {
            $this->setAlertClass('error');
            $this->setAlertMessage('You do not have permission to delete this field!');
        }
    }

    function enable() {

        $field = $this->getField();

        if($field->deleteAuth($this->getAccount())){

            $dql = "DELETE \modelsServiceFieldDisabled sfd
                    WHERE sfd.companyId = :companyId
                    AND sfd.fieldId : :fieldId";

            $query = $this->em->createQuery($dql);
            $query->setParameter('companyId', $this->getAccount()->getCompany()->getCompanyId());
            $query->setParameter('fieldId', $this->getField()->getFieldId());
            $query->execute();

            $this->setAlertClass('success');
            $this->setAlertMessage('Service Field Enabled!');

            $this->logManager->add('service_field_enabled', 'User enabled field "' . $field->getFieldName() . '"');
        }
        else {
            $this->setAlertClass('error');
            $this->setAlertMessage('You do not have permission to delete this field!');
        }
    }

}