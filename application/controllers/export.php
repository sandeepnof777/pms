<?php

class Export extends MY_Controller
{
    function __construct()
    {
        $this->login_restricted = true;
        parent::__construct();
    }

    function index()
    {
        if (!$this->account()->isAdministrator()) {
            $this->session->set_flashdata('error', 'You have no privileges to access this page.');
            redirect('account');
        }

        $data = array();
        $data['account'] = $this->account();
        $data['accounts'] = $this->account()->getCompany()->getAccounts();
        //$categories = $this->em->createQuery('SELECT c FROM models\Services c where c.parent = 0 order by c.serviceName')->getResult();
        $data['categories'] = $this->account()->getCompany()->getCategories();
        $data['statuses'] = $this->account()->getStatuses();
        //$services = array();
        //$servs = $this->em->createQuery('select s from models\Services s where s.parent <> 0 order by s.ord')->getResult();
        //foreach ($servs as $service) {
        //    $services[$service->getParent()][] = $service;
        //}
        $data['services'] = $this->account()->getCompany()->getServices(true);
        $startY = date('Y', $this->account()->getCompany()->getCreated(true));
        $data['startY'] = $startY;

        $data['savedExports'] = $this->account()->getCompany()->getSavedExports();
        $data['reportType'] = $this->em->find('\models\ReportType', 1);

        $data['tab'] = $this->session->flashdata('tab');

        $this->html->addScript('dataTables');
        $this->load->view('export/index', $data);
    }

    /**
     *  Delete a saved export
     */
    function delete_export()
    {
        $exportId = $this->uri->segment(3);

        $export = $this->em->find('\models\SavedReport', $exportId);
        /* @var $export \models\SavedReport */

        // Check user permission
        if (!$this->account()->isAdministrator()) {
            $this->session->set_flashdata('error', 'You do not have the required privileges to access this page');
            redirect('exports');
        }

        // Check the export loaded
        if (!$export) {
            $this->session->set_flashdata('error', 'The Export could not be loaded!');
            redirect('exports');
        }

        // Check the company permission
        if ($export->getCompany()->getCompanyId() !== $this->account()->getCompany()->getCompanyId()) {
            $this->session->set_flashdata('error', 'You do not have permission to view this export!');
            redirect('exports');
        }

        $this->em->remove($export);
        $this->em->flush();

        // Log it
        $this->log_manager->add(\models\ActivityAction::COMPANY_EXPORT_DELETED, "Saved Export '" . $export->getReportName() . "' deleted", null,
            null, $export->getCompany());
        $this->session->set_flashdata('tab', 'savedExports');

        $this->session->set_flashdata('success', 'The export was deleted');
        redirect('export');
    }

    /**
     *  Edit a saved export
     */
    function edit_export()
    {
        $exportId = $this->uri->segment(3);

        $export = $this->em->find('\models\SavedReport', $exportId);
        /* @var $export \models\SavedReport */

        // Check user permission
        if (!$this->account()->isAdministrator()) {
            $this->session->set_flashdata('error', 'You do not have the required priviliges to access this page');
            redirect('exports');
        }

        // Check the export loaded
        if (!$export) {
            $this->session->set_flashdata('error', 'The Export could not be loaded!');
            redirect('exports');
        }

        // Check the company permission
        if ($export->getCompany()->getCompanyId() !== $this->account()->getCompany()->getCompanyId()) {
            $this->session->set_flashdata('error', 'You do not have permission to view this export!');
            redirect('exports');
        }


        if ($this->input->post('saveExport')) {

            $export->setParams(json_encode($_POST));
            $export->setReportName($this->input->post('saveExportName'));
            $this->em->persist($export);
            $this->em->flush();

            // Log it
            $this->log_manager->add(\models\ActivityAction::COMPANY_EXPORT_EDITED, "Saved Export '" . $export->getReportName() . "' edited",
                null, null, $export->getCompany());

            $this->session->set_flashdata('success', 'Your export has been saved!');
            $this->session->set_flashdata('tab', 'savedExports');
            redirect('export');

        } else {
            $data = array();
            $data['export'] = $export;
            $data['params'] = $export->getParams();
            $data['account'] = $this->account();
            $data['accounts'] = $this->account()->getCompany()->getAccounts();
            $categories = $this->em->createQuery('SELECT c FROM models\Services c where c.parent = 0 order by c.serviceName')->getResult();
            $data['categories'] = $categories;
            $data['statuses'] = $this->account()->getStatuses();
            //$services = array();
            //$servs = $this->em->createQuery('select s from models\Services s where s.parent <> 0 order by s.ord')->getResult();
            //foreach ($servs as $service) {
            //    $services[$service->getParent()][] = $service;
            //}
            $data['services'] = $this->account()->getCompany()->getServices(true);
            $startY = date('Y', $this->account()->getCompany()->getCreated(true));
            $data['startY'] = $startY;

            $this->load->view('export/saved-exports/index', $data);
        }


    }
}
