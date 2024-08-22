<?php

class ServiceTextHelper extends BaseHelper {

    /* @var \models\ServiceText */
    private $text;

    /* @var \models\Services */
    private $service;


    /** Constructor */
    public function __construct(array $params = [])
    {
        parent::__construct($params);

        if (isset($params['field'])){
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
     * @return \models\ServiceText
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param \models\ServiceText $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }


    /**
     *  Add a new Service Text
     */
    public function add()
    {
        if ($this->input->post('addTextText')) {
            $text = new \models\ServiceText();
            $text->setService($this->getService()->getServiceId());
            $text->setCompany($this->getAccount()->getCompany()->getCompanyId());
            $text->setOrd(99);
            $text->setText($this->input->post('addTextText'));
            $this->em->persist($text);
            $this->em->flush();

            $this->setAlertClass('success');
            $this->setAlertMessage('Text Added!');

            $this->logManager->add('service_text_add', 'User added text "' . $text->getText() . '"');
        } else {
            $this->setAlertClass('error');
            $this->setAlertMessage('Please enter some text');
        }
    }

    /**
     *  Edit a Service Text
     */
    public function edit()
    {
        $text = $this->em->find('models\ServiceText', $this->input->post('editTextId'));
        /* @var $text \models\ServiceText */
        if (!$text) {
            $this->setAlertClass('error');
            $this->setAlertMessage('Text not found!');
        } else {
            if ($this->input->post('editServiceText')) {
                //echo '<pre>';
                //echo $this->input->post('editServiceText');die;
                // Just update the text if it belongs to the company
                if ($text->getCompany() == $this->getAccount()->getCompany()->getCompanyId()) {
                    $text->setText($this->input->post('editServiceText'));
                    $this->em->persist($text);
                    $this->em->flush();
                }
                else {
                    // Editing a default - create new one and mark old one as deleted

                    // Retrieve the order of the old text
                    $sto = $this->em->getRepository('\models\ServiceTextOrder')
                        ->findOneBy(array(
                            'company' => $this->getAccount()->getCompany()->getCompanyId(),
                            'textId' => $text->getTextId()
                        ));

                    $ord = $sto ? $sto->getOrd() : null;

                    // Create new text
                    $newText = new \models\ServiceText();
                    $newText->setService($this->getService()->getServiceId());
                    $newText->setCompany($this->getAccount()->getCompany()->getCompanyId());
                    $newText->setText($this->input->post('editServiceText'));
                    $this->em->persist($newText);
                    $this->em->flush();

                    // Update the service Order
                    $sto = new \models\ServiceTextOrder();
                    $sto->setCompany($this->getAccount()->getCompany()->getCompanyId());
                    $sto->setService($this->getService()->getServiceId());
                    $sto->setTextId($newText->getTextId());
                    $sto->setOrd($ord);
                    $this->em->persist($sto);

                    // Mark previous one as deleted
                    $deletedText = new \models\Service_deleted_texts();
                    $deletedText->setCompany($this->getAccount()->getCompany()->getCompanyId());
                    $deletedText->setTextId($text->getTextId());
                    $deletedText->setReplacedBy($newText->getTextId());
                    $this->em->persist($deletedText);

                    // Save changes
                    $this->em->flush();
                }

                $this->setAlertClass('success');
                $this->setAlertMessage('Text Edited');

                $this->logManager->add('service_text_edit', 'User edited text "' . $text->getText() . '"');
            } else {
                $this->setAlertClass('error');
                $this->setAlertMessage('Please enter some text');
            }
        }
    }

    public function delete() {

        $text = $this->getText();
        /* @var $text \models\ServiceText*/
        $serviceId = $text->getService();

        if (!$text){
            $this->setAlertClass('error');
            $this->setAlertMessage('Text could not be loaded');
        }
        else if ($text->deleteAuth($this->getAccount())){

            // Record as deleted
            $sdt = new \models\Service_deleted_texts();
            $sdt->setCompany($this->getAccount()->getCompany()->getCompanyId());
            $sdt->setTextId($text->getTextId());

            $this->em->persist($sdt);
            $this->em->flush();

            $this->setAlertClass('success');
            $this->setAlertMessage('Service Text Deleted!');

            $this->logManager->add('service_text_delete', 'User deleted text "' . $text->getText() . '"');
        }
        else {
            $this->setAlertClass('error');
            $this->setAlertMessage('You do not have permission to delete this text!');
        }

        $this->setRedirect($this->getRedirectBase() . $serviceId);
    }
}