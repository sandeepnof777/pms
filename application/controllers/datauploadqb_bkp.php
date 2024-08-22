<?php

class Datauploadqb extends MY_Controller
{
    var $html;

    function __construct()
    {
        $this->login_restricted = true;
        parent::__construct();
    }

    public function clientPlQb()
    {
        $companyId = 3;
        $dataUploadQb = new models\Datauploadqbmdl();
        $result = $dataUploadQb->clientData($companyId);
    }

    public function servicePlQb()
    {
        //$dataUploadQb = new account\Datauploadqbmdl();
        //$companyId=$this->account()->getCompanyId();
        //echo $companyId;die;
        $companyId = 3;
        $dataUploadQb = new models\Datauploadqbmdl();
        $result = $dataUploadQb->servicesData($companyId);
    }

    public function proposalPlQb()
    {
        $companyId = 3;
        $dataUploadQb = new models\Datauploadqbmdl();
        $result = $dataUploadQb->proposalData($companyId);
    }

    public function proposalservicesPlQb()
    {
        $companyId = 3;
        $dataUploadQb = new models\Datauploadqbmdl();
        $result = $dataUploadQb->proposalservicesPlQbData($companyId);
    }

    public function insertQbLogin()
    {
        //echo"<pre>";print_r($this->session->userdata); die;
        $companyId = 3;
        $access_token = $this->uri->segment(3);
        $refresh_token = $this->uri->segment(4);
        $error = '';
        //echo $access_token.'---'.$refresh_token;die;
        $dataUploadQb = new models\Datauploadqbmdl();
        $result = $dataUploadQb->insertQbLoginMdl($companyId, $access_token, $refresh_token, $error);
        redirect('/account/qbsettings/qblogin', 'refresh');
    }

    public function logoutQbLogin()
    {
        //echo"<pre>";print_r($this->session->userdata); die;
        $companyId = 3;

        //echo $access_token.'---'.$refresh_token;die;
        $dataUploadQb = new models\Datauploadqbmdl();
        $result = $dataUploadQb->logoutQbLoginMdl($companyId);
        redirect('/account/qbsettings/', 'refresh');
    }
    //

}