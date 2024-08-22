<?php

class Datauploadqb extends MY_Controller
{
    var $html;

    function __construct()
    {
        $this->login_restricted = true;
        parent::__construct();
    }

    public function insertQbLogin()
    {
        session_start();
        $companyId = $this->account()->getCompanyId();
        $access_token = $this->uri->segment(3);
        $refresh_token = $this->uri->segment(4);
        $realmId = $_SESSION['realmId'];
        $error = '';
        $this->getQuickbooksRepository()->connect($companyId, $access_token, $refresh_token, $realmId, $error);
        $this->session->set_flashdata('success', 'QuickBooks Connection Details Saved');
        $this->log_manager->add('qb_connect', 'Company Connected to Quickbooks', null, null,
            $this->account()->getCompany());
        $_SESSION['connected'] = true;
        // Migrate the services to CQS table
        $this->getQuickbooksRepository()->migrateQbServices($this->account()->getCompany());
        redirect('/account/qbsettings');
    }

    public function logoutQbLogin()
    {
        $companyId = $this->account()->getCompanyId();
        $this->getQuickbooksRepository()->disconnect($companyId);
        $this->session->set_flashdata('success', 'Disconnected from QuickBooks!');
        $this->log_manager->add('qb_connect', 'Company disconnected from Quickbooks', null, null,
            $this->account()->getCompany());
        redirect('/account/qbsettings/', 'refresh');
    }
}