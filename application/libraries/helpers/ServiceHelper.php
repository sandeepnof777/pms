<?php

class ServiceHelper extends BaseHelper
{


    /* @var \models\Services */
    private $service;

    /**
     * @param array $params
     */
    public function __construct(array $params = [])
    {
        parent::__construct($params);

        if (isset($params['field'])) {
            $this->setField($params['field']);
        }
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
     *  Disable a service
     */
    public function disable()
    {

        $service = $this->getService();

        if ($service->editAuth($this->getAccount())) {

            $cds = new \models\CompanyDisabledService();
            $cds->setServiceId($service->getServiceId());
            $cds->setCompanyId($this->getAccount()->getCompany()->getCompanyId());

            $this->em->persist($cds);
            $this->em->flush();

            $this->setAlertClass('success');
            $this->setAlertMessage('Service Disabled!');

        } else {
            $this->setAlertClass('error');
            $this->setAlertMessage('You do not have permission to edit this service!');
        }

    }

    /**
     * Enable the service
     * @return void The message class and text are updated
     */
    public function enable()
    {

        $service = $this->getService();

        if ($service->editAuth($this->getAccount())) {

            // Load the disabled record
            $cds = $this->em->getRepository('\models\CompanyDisabledService')->findOneBy(
                array(
                    'service' => $service->getServiceId(),
                    'company' => $this->getAccount()->getCompany()->getCompanyId()
                )
            );

            if ($cds) {
                $this->em->remove($cds);
                $this->em->flush();

                $this->setAlertClass('success');
                $this->setAlertMessage('Service Enabled!');

                $this->logManager->add('service_enable', "User enabled service '" . $service->getServiceName() . "'");
            } else {
                $this->setAlertClass('error');
                $this->setAlertMessage('There was a problem enabling the service');
            }
        } else {
            $this->setAlertClass('error');
            $this->setAlertMessage('You do not have permission to edit this service!');
        }
    }

    /**
     *  Add a new service
     * @return void The message of this object is updated
     */
    public function add()
    {
        $service = new \models\Services();
        $service->setServiceName($this->input->post('serviceName'));
        $service->setOrd(99);
        $service->setParent($this->input->post('parent'));
        $service->setCompany($this->getAccount()->getCompany()->getCompanyId());
        $this->em->persist($service);
        $this->em->flush();

        // Check it saved
        if ($service->getServiceId()) {
            $this->logManager->add('service_delete', "User added service '" . $service->getServiceName() . "''");
            $this->setAlertClass('success');
            $this->setAlertMessage('Service Added!');
        } else {
            $this->setAlertClass('error');
            $this->setAlertMessage('There was a problem saving the service.');
        }
    }

    /**
     *  Delete the service
     * @return void The message class of the object is updated
     */
    public function delete()
    {
        $service = $this->getService();

        if ($service->editAuth($this->getAccount())) {

            // Load the record in case already disabled
            $cds = $this->em->getRepository('\models\CompanyDisabledService')->findOneBy(
                array(
                    'service' => $service->getServiceId(),
                    'company' => $this->getAccount()->getCompany()->getCompanyId()
                )
            );

            // Add deleted flag if it exists
            if ($cds) {
                $cds->setDeleted(1);
                // Save it
                $this->em->persist($cds);
                $this->em->flush();
            } else {

                // If company owns this, and it's not used, remove completely
                if (
                    ($service->getCompany() == $this->getAccount()->getCompany()->getCompanyId())
                    && !$service->hasUsages()
                ) {
                    $this->em->remove($service);
                    $this->em->flush();
                } else {
                    // Create new disabled record otherwise
                    $cds = new \models\CompanyDisabledService();
                    $cds->setServiceId($service->getServiceId());
                    $cds->setCompanyId($this->getAccount()->getCompany()->getCompanyId());
                    $cds->setDeleted(1);
                    // Save it
                    $this->em->persist($cds);
                    $this->em->flush();
                }
            }

            // Log it
            $this->logManager->add('service_delete', "User deleted service '" . $service->getServiceName() . "''");
            // Feedback
            $this->setAlertClass('success');
            $this->setAlertMessage('Service Deleted');
        } else {
            $this->setAlertClass('error');
            $this->setAlertMessage('You do not have permission to delete this service!');
        }
    }

    /**
     *  Duplicate a service for this company
     */
    function duplicate()
    {
        // Wee'll be needing this
        $company = $this->getAccount()->getCompany();

        // Duplicate the service
        $service = $this->getService();

        $newService = new \models\Services();
        $newService->setCompany($this->getAccount()->getCompany()->getCompanyId());
        $newService->setParent($service->getParent());
        $newService->setTax($service->getTax());
        $newService->setOrd(999);
        $serviceName = $service->hasCustomTitle($this->getAccount()->getCompany()->getCompanyId())
            ? $service->getCustomTitle($this->getAccount()->getCompany()->getCompanyId())->getTitle()
            : $service->getServiceName();
        $newService->setServiceName('Copy of ' . $serviceName);
        $this->em->persist($newService);
        $this->em->flush();

        if (!$newService->getServiceId()) {
            $this->setAlertClass('error');
            $this->setAlertMessage('There was a problem duplicating the service');
            return;
        }

        // Retrieve the texts and duplicate
        $serviceTexts = $this->getAccount()->getCompany()->getOrderedServiceTexts($service->getServiceId());

        foreach ($serviceTexts as $serviceText) {
            /* @var $serviceText \models\ServiceText */

            $newText = new \models\ServiceText();
            $newText->setService($newService->getServiceId());
            $newText->setCompany($serviceText->getCompany());
            $newText->setText($serviceText->getText());
            $this->em->persist($newText);
        }

        // Retrieve the Field Codes and Duplicate
        $serviceCodes = $service->getFieldCodes($this->getAccount()->getCompany()->getCompanyId());

        foreach ($serviceCodes as $serviceCode) {
            /* @var $serviceCode \models\ServiceField */
            $newField = new \models\ServiceField();
            $newField->setService($newService->getServiceId());
            $newField->setCompany($newService->getCompany());
            $newField->setFieldCode($serviceCode->getFieldCode());
            $newField->setFieldName($serviceCode->getFieldName());
            $newField->setFieldType($serviceCode->getFieldType());
            $newField->setFieldValue($serviceCode->getFieldValue());
            $this->em->persist($newField);
            $this->em->flush();

            // Duplicate any CESFs
            $cesf = $this->getEstimationRepository()->getEstimateServiceField($company, $serviceCode);
            if($cesf){
                $newCesf = clone $cesf;
                $newCesf->setFieldId($newField->getFieldId());
                $newCesf->setCompanyId($company->getCompanyId());
                $newCesf->setServiceId($newService->getServiceId());
                //print_r($newCesf);die;
                $this->em->persist($newCesf);
                $this->em->flush();
            }
           
        }
        $this->em->flush();

        if ($this->getAccount()->getCompany()->hasQb()) {

            switch($this->getAccount()->getCompany()->getQbType()) {

                case 'online':
                    // Add a record to the relevant table for quickbooks if needed
                    $cqs = new \models\CompanyQbService();
                    $cqs->setCompanyId($this->getAccount()->getCompanyId());
                    $cqs->setServiceId($newService->getServiceId());
                    $cqs->setQBSyncFlag(1);
                    $cqs->setTitle($newService->getServiceName());
                    $this->em->persist($cqs);
                    $this->em->flush();
                    break;

                case 'desktop':
                    $user = md5($this->getAccount()->getCompanyId());
                    $this->getQbdRepository()->enqueue(QUICKBOOKS_ADD_SERVICEITEM, $newService->getServiceId() , 0, '' , $user);
                    break;
            }
        }

        $this->logManager->add('service_duplicate', "User duplicated service '" . $service->getServiceName() . "''");
        $this->setAlertClass('success');
        $this->setAlertMessage('Service Duplicated!');
		
		return $newService->getServiceId();
    }
}