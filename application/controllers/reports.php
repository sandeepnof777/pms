<?php

use Carbon\Carbon;

class Reports extends MY_Controller
{
    function __construct()
    {
        $this->login_restricted = true;
        parent::__construct();
    }

    function index()
    {
        //check privileges
        $data = array();
        if (!$this->account()->isAdministrator()) {
            $this->session->set_flashdata('error', 'Only Company Administrators can view this page!');
            redirect('account/my_account');
        }
        $accs = array();
        $accounts = $this->account()->getCompany()->getAccounts();
        foreach ($accounts as $acc) {
            $accs[] = $acc->getAccountId();
        }
        //$categories = $this->em->createQuery('SELECT c FROM models\Services c where c.parent = 0 order by c.serviceName')->getResult();
        $categories = $this->account()->getCompany()->getCategories();
        $data['categories'] = $categories;
        //$services = array();
        //$servs = $this->em->createQuery('select s from models\Services s where s.parent <> 0 order by s.ord')->getResult();
        //foreach ($servs as $service) {
        //    $services[$service->getParent()][] = $service;
        //}
        $services = $this->account()->getCompany()->getServices(true);
        $data['services'] = $services;
        $data['account'] = $this->account();
        $data['statuses'] = $this->account()->getStatuses(true);
        $data['defaultStartDate'] = Carbon::create()->startOfYear()->format('m/d/Y');
        $data['defaultEndDate'] = Carbon::now()->format('m/d/Y');
        $this->html->addScript('flot');
        $this->load->view('reports/index', $data);
    }

    function download_report()
    {
        $this->new_download_report();
        return;
    }

    function new_download_report()
    {
        ini_set('memory_limit', '512M');

        // Set up CSV File
        $writer = \League\Csv\Writer::createFromFileObject(new SplTempFileObject());
        $fileName = 'report.csv';
        //set up data
        $data = [];

        // Use carbon for getting start and end times
        $fromDate = Carbon::createFromFormat('m/d/Y', $this->input->post('from'))->startOfDay();
        $toDate = Carbon::createFromFormat('m/d/Y', $this->input->post('to'))->endOfDay();

        $start = $fromDate->timestamp;
        $end = $toDate->timestamp;

        // Status change dates
        if ($this->input->post('statusApply')) {
            $statusFromDate = Carbon::createFromFormat('m/d/Y', $this->input->post('statusFrom'))->startOfDay();
            $statusToDate = Carbon::createFromFormat('m/d/Y', $this->input->post('statusTo'))->endOfDay();

            $statusStart = $statusFromDate->timestamp;
            $statusEnd = $statusToDate->timestamp;
        }

        $service = $this->input->post('service');
        $users = (is_array(@$_POST['accounts'])) ? $_POST['accounts'] : array();

        //format users array
        $uk = 0;
        foreach ($users as $uid => $val) {
            $users[$uid] = $uid;
            $usersArray[$uk] = $uid;
            $uk++;
        }

        switch ($this->input->post('reportType')) {

            case 'leadconversion':
                //Client List Export
                $columns = array(
                    "Lead Date",
                    'Converted Date',
                    'Days to Convert',
                    'Lead Source',
                    'First Name',
                    'Last Name',
                    'Company',
                    'Project Name',
                    'Contact Email',
                    'Lead Status',
                    'Owner',
                    'Proposal Status',
                    'Price',
                    'Services',
                    'Last Activity',
                    'Lead Notes',
                    'Proposal Notes',
                );
                $data[] = $columns;
                $leads = $this->getLeadRepository()->getLeadsByCreatedDate($this->account(), $usersArray, $fromDate, $toDate);

                $k = 0;

                foreach ($leads as $lead) {
                    /* @var \models\Leads $lead */
                    $convertedProposal = null;
                    $proposalServices = [];
                    $proposalNotes = [];
                    $leadNotes = $this->getLeadRepository()->getLeadNotes($lead);
                    $proposalNotesContent = '';
                    $proposalServicesContent = '';
                    $leadNotesContent = '';

                    // Check for converted proposal
                    if ($lead->getConvertedTo()) {
                        $proposal = $this->em->findProposal($lead->getConvertedTo());
                        if ($proposal) {
                            $convertedProposal = $proposal;
                            $proposalNotes = $this->getProposalRepository()->getNotes($convertedProposal);
                            $proposalServices = $convertedProposal->getServices();
                        }
                    }

                    foreach ($leadNotes as $note) {
                        /* @var \models\Notes $note */
                        $leadNotesContent .= date('m/d/Y g:i a', $note->getAdded()) . ': ' . $note->getNoteText() . "  |  ";
                    }

                    foreach ($proposalNotes as $note) {
                        /* @var \models\Notes $note */
                        $proposalNotesContent .= date('m/d/Y g:i a', $note->getAdded()) . ': ' . $note->getNoteText() . "  |  ";
                    }

                    foreach ($proposalServices as $proposalService) {
                        /* @var \models\Proposal_services $proposalService */
                        $proposalServicesContent .= $proposalService->getServiceName() . ': ' . $proposalService->getPrice();
                        $proposalServicesContent .= ($proposalService->isOptional()) ? ' [Optional]' : '';
                        $proposalServicesContent .= "  |  ";
                    }

                    // Use some Carbon objects for dates
                    $createdDate = Carbon::createFromTimestamp($lead->getCreated(true));

                    // Converted Date
                    $convertedDate = null;
                    if ($lead->getConverted(true)) {
                        $convertedDate = Carbon::createFromTimestamp($lead->getConverted(true));
                    }

                    // Conversion Days
                    $conversionDays = 'n/a';
                    if ($convertedDate) {
                        $conversionDays = $convertedDate->diffInDays($createdDate);
                    }

                    // Owner
                    $owner = $this->em->findAccount($lead->getAccount());

                    // Last Activity
                    $lastActivity = Carbon::createFromTimestamp($lead->getLastActivity());

                    // Data Array
                    $row = array();
                    $k++;
                    // Lead Date
                    $row[] = $createdDate->format('m/d/Y');
                    // Converted Date
                    $row[] = $convertedDate ? $convertedDate->format('m/d/y') : '';
                    // Days to convert
                    $row[] = $conversionDays;
                    // Lead Source
                    $row[] = $lead->getSource();
                    // First Name
                    $row[] = $lead->getFirstName();
                    // Last Name
                    $row[] = $lead->getLastName();
                    // Company
                    $row[] = $lead->getCompanyName();
                    // Project Name
                    $row[] = $lead->getProjectName();
                    // Contact Email
                    $row[] = $lead->getEmail();
                    // Lead Status
                    $row[] = $lead->getStatus();
                    // Owner
                    $row[] = $owner ? $owner->getFullName() : 'Deleted';
                    // Proposal Status
                    $row[] = $convertedProposal ? $convertedProposal->getProposalStatus()->getText() : 'n/a';
                    // Price
                    $row[] = $convertedProposal ? $convertedProposal->getTotalPrice() : '-';
                    // Services
                    $row[] = $proposalServicesContent;
                    // Last Activity
                    $row[] = $lastActivity->format('m/d/Y g:i a');
                    // Proposal Notes
                    $row[] = $proposalNotesContent;

                    // Add to array
                    $data[] = $row;
                }
                $fileName = 'lead-conversion.csv';
                break;
            case 'clientlist':
                //Client List Export
                $columns = array(
                    "#",
                    'Contact Name',
                    'Title',
                    'Company',
                    'Email',
                    'Cell Phone',
                    'Business Phone',
                    'Fax',
                    'Address',
                    'City',
                    'State',
                    'Zip',
                    'User Account',
                    'Date Added'
                );
                $data[] = $columns;
                $clients = $this->account()->getCompany()->getUserClients($usersArray);
                $k = 0;

                foreach ($clients as $client) {
                    $row = array();
                    $k++;
                    $row[] = $k;
                    $row[] = $client->getFirstName() . ' ' . $client->getLastName();
                    $row[] = $client->getTitle();
                    $row[] = $client->getClientAccount()->getName();
                    $row[] = $client->getEmail();
                    $row[] = $client->getCellPhone();
                    $row[] = $client->getBusinessPhone();
                    $row[] = $client->getFax();
                    $row[] = $client->getAddress();
                    $row[] = $client->getCity();
                    $row[] = $client->getState();
                    $row[] = $client->getZip();
                    $row[] = $client->getAccount()->getFullName();
                    $row[] = $client->getCreated();
                    $data[] = $row;
                }
                $fileName = 'client-list.csv';
                break;

            case 'topten':
                //Top Ten Export
                //prepare the data
                $top_proposals = $this->account()->getCompany()->getTopTenProposals($start, $end, $usersArray,
                    $service);
                //set up columns
                $columns = array(
                    "#",
                    'Job #',
                    'Date Issued',
                    'Jobsite',
                    'Amount',
                    'Lead Source',
                    'Contact Name',
                    'Title',
                    'Company',
                    'Email',
                    'Cell Phone',
                    'Business Phone',
                    'Fax',
                    'Address',
                    'City',
                    'State',
                    'Zip',
                    'Proposal Owner'
                );
                $data[] = $columns;
                //add data
                $k = 0;

                foreach ($top_proposals as $proposal) {
                    $k++;
                    $row = array();
                    $row[] = $k;
                    $row[] = $proposal->getJobNumber();
                    $row[] = $proposal->getCreated();
                    $row[] = $proposal->getProjectName();
                    $row[] = '$' . $proposal->getTotalPrice();
                    $row[] = $proposal->getLeadSource();
                    $client = $proposal->getClient();
                    $row[] = $client->getFirstName() . ' ' . $client->getLastName();
                    $row[] = $client->getTitle();
                    $row[] = $client->getClientAccount()->getName();
                    $row[] = $client->getEmail();
                    $row[] = $client->getCellPhone();
                    $row[] = $client->getBusinessPhone();
                    $row[] = $client->getFax();
                    $row[] = $client->getAddress();
                    $row[] = $client->getCity();
                    $row[] = $client->getState();
                    $row[] = $client->getZip();
                    $row[] = $proposal->getOwner()->getFullName();
                    $data[] = $row;
                }
                $fileName = 'top-ten.csv';
                break;

            case 'activity':


                $columns = array(
                    "#",
                    'Job #',
                    'Date Issued',
                    'Status Change Date',
                    'Jobsite',
                    'Amount',
                    'Status',
                    'Lead Source',
                    'Contact Name',
                    'Title',
                    'Company',
                    'Email',
                    'Cell Phone',
                    'Business Phone',
                    'Fax',
                    'Address',
                    'City',
                    'State',
                    'Zip',
                    'User Account'
                );
                $data[] = $columns;
                //$proposals = $this->em->createQuery('SELECT p FROM models\Proposals p inner join p.client c inner join c.company cmp where (cmp.companyId = c.company) and (cmp.companyId = ' . $this->account()->getCompany()->getCompanyId() . ') and (p.created>=' . $start . ') and (p.created<=' . $end . ')')->getResult();
                $k = 0;

                // Base query - Set up proposals for company and users
                $baseQueryDQL = '
                SELECT p FROM models\Proposals p
                INNER JOIN p.client c
                INNER JOIN c.company cmp WHERE ((cmp.companyId = c.company AND cmp.companyId = :companyId))
                AND (p.created >= :startTime AND p.created <= :endTime)
                AND p.owner IN (:userIds)';

                // Apply Status chage if requested
                if ($this->input->post('statusApply')) {
                    $baseQueryDQL .= 'AND (p.statusChangeDate >= :statusStart AND p.statusChangeDate <= :statusEnd)';
                }

                $baseQuery = $this->em->createQuery($baseQueryDQL);
                $baseQuery->setParameter('companyId', $this->account()->getCompany()->getCompanyId());
                $baseQuery->setParameter('startTime', $start);
                $baseQuery->setParameter('endTime', $end);
                if ($this->input->post('statusApply')) {
                    $baseQuery->setParameter('statusStart', $statusStart);
                    $baseQuery->setParameter('statusEnd', $statusEnd);
                }
                $baseQuery->setParameter('userIds', $usersArray);
                $proposals = $baseQuery->getResult();

                foreach ($proposals as $proposal) {
                    $statusDateChangeText = '';
                    if ($proposal->getStatusChangeDate()) {
                        $statusDateChangeText = date('d/M/Y', $proposal->getStatusChangeDate());
                    }
                    //do magic here
                    $k++;
                    $row = array();
                    $row[] = $k;
                    $row[] = $proposal->getJobNUmber();
                    $row[] = $proposal->getCreated();
                    $row[] = $statusDateChangeText;
                    $row[] = $proposal->getProjectName();
                    $row[] = '$' . $proposal->getTotalPrice();
                    $row[] = $proposal->getProposalStatus()->getText();
                    $row[] = $proposal->getLeadSource();
                    $client = $proposal->getClient();
                    $row[] = $client->getFirstName() . ' ' . $client->getLastName();
                    $row[] = $client->getTitle();
                    $row[] = $client->getClientAccount()->getName();
                    $row[] = $client->getEmail();
                    //                            $row[] = $client->getWebsite();
                    $row[] = $client->getCellPhone();
                    $row[] = $client->getBusinessPhone();
                    $row[] = $client->getFax();
                    $row[] = $client->getAddress();
                    $row[] = $client->getCity();
                    $row[] = $client->getState();
                    $row[] = $client->getZip();
                    $row[] = substr(trim($proposal->getOwner()->getFirstName()), 0,
                            1) . ' ' . $proposal->getOwner()->getLastName();
                    $data[] = $row;
                }
                $fileName = 'pipeline.csv';
                break;

            default:
                $selectedStatus = $this->input->post('reportType');

                $status = $this->em->find('\models\Status', $selectedStatus);

                $users = (is_array(@$_POST['accounts'])) ? $_POST['accounts'] : array();

                //format users array
                $uk = 0;
                foreach ($users as $uid => $val) {
                    $users[$uid] = $uid;
                    $usersArray[$uk] = $uid;
                    $uk++;
                }

                $columns = array(
                    "#",
                    'Job #',
                    'Date Issued',
                    'Status Change Date',
                    'Jobsite',
                    'Amount',
                    'Status',
                    'Lead Source',
                    'Contact Name',
                    'Title',
                    'Company',
                    'Email',
                    'Cell Phone',
                    'Business Phone',
                    'Fax',
                    'Address',
                    'City',
                    'State',
                    'Zip',
                    'User Account'
                );
                $data[] = $columns;
                //$proposals = $this->em->createQuery('SELECT p FROM models\Proposals p inner join p.client c inner join c.company cmp where (cmp.companyId = c.company) and (cmp.companyId = ' . $this->account()->getCompany()->getCompanyId() . ') and (p.created>=' . $start . ') and (p.created<=' . $end . ')')->getResult();
                $k = 0;

                // Base query - Set up proposals for company and users
                $baseQueryDQL = '
                SELECT p FROM models\Proposals p
                INNER JOIN p.client c
                INNER JOIN c.company cmp WHERE (cmp.companyId = c.company AND cmp.companyId = :companyId)
                AND (p.created >= :startTime AND p.created <= :endTime)
                AND p.owner IN (:userIds)
                AND p.proposalStatus = :statusId';

                // Apply Status chage if requested
                if ($this->input->post('statusApply')) {
                    $baseQueryDQL .= ' AND (p.statusChangeDate >= :statusStart AND p.statusChangeDate <= :statusEnd)';
                }

                $baseQuery = $this->em->createQuery($baseQueryDQL);
                $baseQuery->setParameter('companyId', $this->account()->getCompany()->getCompanyId());
                $baseQuery->setParameter('startTime', $start);
                $baseQuery->setParameter('endTime', $end);
                $baseQuery->setParameter('statusId', $selectedStatus);
                if ($this->input->post('statusApply')) {
                    $baseQuery->setParameter('statusStart', $statusStart);
                    $baseQuery->setParameter('statusEnd', $statusEnd);
                }
                $baseQuery->setParameter('userIds', $usersArray);
                $proposals = $baseQuery->getResult();

                foreach ($proposals as $proposal) {
                    $statusDateChangeText = '';
                    if ($proposal->getStatusChangeDate()) {
                        $statusDateChangeText = date('d/M/Y', $proposal->getStatusChangeDate());
                    }
//do magic here
                    $k++;
                    $row = array();
                    $row[] = $k;
                    $row[] = $proposal->getJobNumber();
                    $row[] = $proposal->getCreated();
                    $row[] = $statusDateChangeText;
                    $row[] = $proposal->getProjectName();
                    $row[] = '$' . $proposal->getTotalPrice();
                    $row[] = $proposal->getProposalStatus()->getText();
                    $row[] = $proposal->getLeadSource();
                    $client = $proposal->getClient();
                    $row[] = $client->getFirstName() . ' ' . $client->getLastName();
                    $row[] = $client->getTitle();
                    $row[] = $client->getClientAccount()->getName();
                    $row[] = $client->getEmail();
                    $row[] = $client->getCellPhone();
                    $row[] = $client->getBusinessPhone();
                    $row[] = $client->getFax();
                    $row[] = $client->getAddress();
                    $row[] = $client->getCity();
                    $row[] = $client->getState();
                    $row[] = $client->getZip();
                    $row[] = substr(trim($proposal->getOwner()->getFirstName()), 0,
                            1) . ' ' . $proposal->getOwner()->getLastName();
                    $data[] = $row;
                }
                $fileName = $status->getText() . '-proposals.csv';
        }

//CSV File Output
        $writer->insertAll($data);
        $writer->output($fileName);
        return;

    }

    function parent_company()
    {
        //check privileges
        $data = array();
        // if (!$this->account()->isAdministrator()) {
        //     $this->session->set_flashdata('error', 'Only Company Administrators can view this page!');
        //     redirect('account/my_account');
        // }
        $accs = array();
        $accounts = $this->account()->getCompany()->getAccounts();
        foreach ($accounts as $acc) {
            $accs[] = $acc->getAccountId();
        }

        $companyRepo = $this->getCompanyRepository();
        $data['childCompanies'] =  $this->getCompanyRepository()->getParentChildCompanies($this->account()->getParentCompany()->getCompanyId());

         foreach($data['childCompanies'] as $childCompany){
            
             $childCompanyIds[] = $childCompany->companyId;
           

         }

        $data['childAccounts'] = $companyRepo->getMasterSalesAccounts($childCompanyIds);
        //$categories = $this->em->createQuery('SELECT c FROM models\Services c where c.parent = 0 order by c.serviceName')->getResult();
        $categories = $this->account()->getCompany()->getCategories();
        $data['categories'] = $categories;
        //$services = array();
        //$servs = $this->em->createQuery('select s from models\Services s where s.parent <> 0 order by s.ord')->getResult();
        //foreach ($servs as $service) {
        //    $services[$service->getParent()][] = $service;
        //}
        $services = $this->account()->getCompany()->getServices(true);
        $data['services'] = $services;
        $data['account'] = $this->account();
        $data['statuses'] = $this->account()->getStatuses(true);
        $data['defaultStartDate'] = Carbon::create()->startOfYear()->format('m/d/Y');
        $data['defaultEndDate'] = Carbon::now()->format('m/d/Y');
        $this->html->addScript('flot');
        $this->load->view('reports/parent_company', $data);
    }



    function download_parent_company_report()
    {
        ini_set('memory_limit', '512M');
        session_start();
        $_SESSION['downloadstatus'] = array("status" =>"pending");

        // Set up CSV File
        $writer = \League\Csv\Writer::createFromFileObject(new SplTempFileObject());
        $fileName = 'report.csv';
        //set up data
        $data = [];

        // Use carbon for getting start and end times
        $fromDate = Carbon::createFromFormat('m/d/Y', $this->input->post('from'))->startOfDay();
        $toDate = Carbon::createFromFormat('m/d/Y', $this->input->post('to'))->endOfDay();

        $start = $fromDate->timestamp;
        $end = $toDate->timestamp;

        // Status change dates
        if ($this->input->post('statusApply')) {
            $statusFromDate = Carbon::createFromFormat('m/d/Y', $this->input->post('statusFrom'))->startOfDay();
            $statusToDate = Carbon::createFromFormat('m/d/Y', $this->input->post('statusTo'))->endOfDay();

            $statusStart = $statusFromDate->timestamp;
            $statusEnd = $statusToDate->timestamp;
        }

        $service = $this->input->post('service');
        $users = (is_array(@$_POST['accounts'])) ? $_POST['accounts'] : array();

        //format users array
        $uk = 0;
        foreach ($users as $uid => $val) {
            $users[$uid] = $uid;
            $usersArray[$uk] = $uid;
            $uk++;
        }

        switch ($this->input->post('reportType')) {

            case 'leadconversion':
                //Client List Export
                $columns = array(
                    "Lead Date",
                    'Converted Date',
                    'Days to Convert',
                    'Lead Source',
                    'First Name',
                    'Last Name',
                    'Company',
                    'Project Name',
                    'Contact Email',
                    'Lead Status',
                    'Owner',
                    'Proposal Status',
                    'Price',
                    'Services',
                    'Last Activity',
                    'Lead Notes',
                    'Proposal Notes',
                );
                $data[] = $columns;
                $leads = $this->getLeadRepository()->getParentLeadsByCreatedDate($usersArray, $fromDate, $toDate);

                $k = 0;

                foreach ($leads as $lead) {
                    /* @var \models\Leads $lead */
                    $convertedProposal = null;
                    $proposalServices = [];
                    $proposalNotes = [];
                    $leadNotes = $this->getLeadRepository()->getLeadNotes($lead);
                    $proposalNotesContent = '';
                    $proposalServicesContent = '';
                    $leadNotesContent = '';

                    // Check for converted proposal
                    if ($lead->getConvertedTo()) {
                        $proposal = $this->em->findProposal($lead->getConvertedTo());
                        if ($proposal) {
                            $convertedProposal = $proposal;
                            $proposalNotes = $this->getProposalRepository()->getNotes($convertedProposal);
                            $proposalServices = $convertedProposal->getServices();
                        }
                    }

                    foreach ($leadNotes as $note) {
                        /* @var \models\Notes $note */
                        $leadNotesContent .= date('m/d/Y g:i a', $note->getAdded()) . ': ' . $note->getNoteText() . "  |  ";
                    }

                    foreach ($proposalNotes as $note) {
                        /* @var \models\Notes $note */
                        $proposalNotesContent .= date('m/d/Y g:i a', $note->getAdded()) . ': ' . $note->getNoteText() . "  |  ";
                    }

                    foreach ($proposalServices as $proposalService) {
                        /* @var \models\Proposal_services $proposalService */
                        $proposalServicesContent .= $proposalService->getServiceName() . ': ' . $proposalService->getPrice();
                        $proposalServicesContent .= ($proposalService->isOptional()) ? ' [Optional]' : '';
                        $proposalServicesContent .= "  |  ";
                    }

                    // Use some Carbon objects for dates
                    $createdDate = Carbon::createFromTimestamp($lead->getCreated(true));

                    // Converted Date
                    $convertedDate = null;
                    if ($lead->getConverted(true)) {
                        $convertedDate = Carbon::createFromTimestamp($lead->getConverted(true));
                    }

                    // Conversion Days
                    $conversionDays = 'n/a';
                    if ($convertedDate) {
                        $conversionDays = $convertedDate->diffInDays($createdDate);
                    }

                    // Owner
                    $owner = $this->em->findAccount($lead->getAccount());

                    // Last Activity
                    $lastActivity = Carbon::createFromTimestamp($lead->getLastActivity());

                    // Data Array
                    $row = array();
                    $k++;
                    // Lead Date
                    $row[] = $createdDate->format('m/d/Y');
                    // Converted Date
                    $row[] = $convertedDate ? $convertedDate->format('m/d/y') : '';
                    // Days to convert
                    $row[] = $conversionDays;
                    // Lead Source
                    $row[] = $lead->getSource();
                    // First Name
                    $row[] = $lead->getFirstName();
                    // Last Name
                    $row[] = $lead->getLastName();
                    // Company
                    $row[] = $lead->getCompanyName();
                    // Project Name
                    $row[] = $lead->getProjectName();
                    // Contact Email
                    $row[] = $lead->getEmail();
                    // Lead Status
                    $row[] = $lead->getStatus();
                    // Owner
                    $row[] = $owner ? $owner->getFullName() : 'Deleted';
                    // Proposal Status
                    $row[] = $convertedProposal ? $convertedProposal->getProposalStatus()->getText() : 'n/a';
                    // Price
                    $row[] = $convertedProposal ? $convertedProposal->getTotalPrice() : '-';
                    // Services
                    $row[] = $proposalServicesContent;
                    // Last Activity
                    $row[] = $lastActivity->format('m/d/Y g:i a');
                    // Proposal Notes
                    $row[] = $proposalNotesContent;

                    // Add to array
                    $data[] = $row;
                }
                $fileName = 'lead-conversion.csv';
                break;
            case 'clientlist':
                //Client List Export
                $columns = array(
                    "#",
                    'Contact Name',
                    'Title',
                    'Company',
                    'Email',
                    'Cell Phone',
                    'Business Phone',
                    'Fax',
                    'Address',
                    'City',
                    'State',
                    'Zip',
                    'User Account',
                    'Date Added'
                );
                $data[] = $columns;

                $childCompanies =  $this->getCompanyRepository()->getParentChildCompanies($this->account()->getParentCompany()->getCompanyId());

                $clients = new \Doctrine\Common\Collections\ArrayCollection();

                foreach($childCompanies as $childCompany){
                    
                    
                    $branchCompany = $this->em->findCompany($childCompany->companyId);
                    $temp_clients = $branchCompany->getUserClients($usersArray);
                    
                    foreach ($temp_clients as $client) {
                        $clients->add($client);
                    }
                
                    
                }

                
               
                $k = 0;

                foreach ($clients as $client) {
                    $row = array();
                    $k++;
                    $row[] = $k;
                    $row[] = $client->getFirstName() . ' ' . $client->getLastName();
                    $row[] = $client->getTitle();
                    $row[] = $client->getClientAccount()->getName();
                    $row[] = $client->getEmail();
                    $row[] = $client->getCellPhone();
                    $row[] = $client->getBusinessPhone();
                    $row[] = $client->getFax();
                    $row[] = $client->getAddress();
                    $row[] = $client->getCity();
                    $row[] = $client->getState();
                    $row[] = $client->getZip();
                    $row[] = $client->getAccount()->getFullName();
                    $row[] = $client->getCreated();
                    $data[] = $row;
                }
                $fileName = 'client-list.csv';
                break;

            case 'topten':
                //Top Ten Export
                //prepare the data
                $top_proposals = $this->getProposalRepository()->getTopTenProposals($start, $end, $usersArray,
                    $service);
                //set up columns
                $columns = array(
                    "#",
                    'Job #',
                    'Date Issued',
                    'Jobsite',
                    'Amount',
                    'Lead Source',
                    'Contact Name',
                    'Title',
                    'Company',
                    'Email',
                    'Cell Phone',
                    'Business Phone',
                    'Fax',
                    'Address',
                    'City',
                    'State',
                    'Zip',
                    'Proposal Owner'
                );
                $data[] = $columns;
                //add data
                $k = 0;

                foreach ($top_proposals as $proposal) {
                    $k++;
                    $row = array();
                    $row[] = $k;
                    $row[] = $proposal->getJobNumber();
                    $row[] = $proposal->getCreated();
                    $row[] = $proposal->getProjectName();
                    $row[] = '$' . $proposal->getTotalPrice();
                    $row[] = $proposal->getLeadSource();
                    $client = $proposal->getClient();
                    $row[] = $client->getFirstName() . ' ' . $client->getLastName();
                    $row[] = $client->getTitle();
                    $row[] = $client->getClientAccount()->getName();
                    $row[] = $client->getEmail();
                    $row[] = $client->getCellPhone();
                    $row[] = $client->getBusinessPhone();
                    $row[] = $client->getFax();
                    $row[] = $client->getAddress();
                    $row[] = $client->getCity();
                    $row[] = $client->getState();
                    $row[] = $client->getZip();
                    $row[] = $proposal->getOwner()->getFullName();
                    $data[] = $row;
                }
                $fileName = 'top-ten.csv';
                break;

            case 'activity':


                $columns = array(
                    "#",
                    'Job #',
                    'Date Issued',
                    'Status Change Date',
                    'Jobsite',
                    'Amount',
                    'Status',
                    'Lead Source',
                    'Contact Name',
                    'Title',
                    'Company',
                    'Email',
                    'Cell Phone',
                    'Business Phone',
                    'Fax',
                    'Address',
                    'City',
                    'State',
                    'Zip',
                    'User Account'
                );
                $data[] = $columns;
                //$proposals = $this->em->createQuery('SELECT p FROM models\Proposals p inner join p.client c inner join c.company cmp where (cmp.companyId = c.company) and (cmp.companyId = ' . $this->account()->getCompany()->getCompanyId() . ') and (p.created>=' . $start . ') and (p.created<=' . $end . ')')->getResult();
                $k = 0;

                // Base query - Set up proposals for company and users
                $baseQueryDQL = '
                SELECT p FROM models\Proposals p
               
                WHERE (p.created >= :startTime AND p.created <= :endTime)
                AND p.owner IN (:userIds)';

                // Apply Status chage if requested
                if ($this->input->post('statusApply')) {
                    $baseQueryDQL .= 'AND (p.statusChangeDate >= :statusStart AND p.statusChangeDate <= :statusEnd)';
                }

                $baseQuery = $this->em->createQuery($baseQueryDQL);
                //$baseQuery->setParameter('companyId', $this->account()->getCompany()->getCompanyId());
                $baseQuery->setParameter('startTime', $start);
                $baseQuery->setParameter('endTime', $end);
                if ($this->input->post('statusApply')) {
                    $baseQuery->setParameter('statusStart', $statusStart);
                    $baseQuery->setParameter('statusEnd', $statusEnd);
                }
                $baseQuery->setParameter('userIds', $usersArray);


                $proposals = $baseQuery->getResult();

                foreach ($proposals as $proposal) {
                    $statusDateChangeText = '';
                    if ($proposal->getStatusChangeDate()) {
                        $statusDateChangeText = date('d/M/Y', $proposal->getStatusChangeDate());
                    }
                    //do magic here
                    $k++;
                    $row = array();
                    $row[] = $k;
                    $row[] = $proposal->getJobNUmber();
                    $row[] = $proposal->getCreated();
                    $row[] = $statusDateChangeText;
                    $row[] = $proposal->getProjectName();
                    $row[] = '$' . $proposal->getTotalPrice();
                    $row[] = $proposal->getProposalStatus()->getText();
                    $row[] = $proposal->getLeadSource();
                    $client = $proposal->getClient();
                    $row[] = $client->getFirstName() . ' ' . $client->getLastName();
                    $row[] = $client->getTitle();
                    $row[] = $client->getClientAccount()->getName();
                    $row[] = $client->getEmail();
                    //                            $row[] = $client->getWebsite();
                    $row[] = $client->getCellPhone();
                    $row[] = $client->getBusinessPhone();
                    $row[] = $client->getFax();
                    $row[] = $client->getAddress();
                    $row[] = $client->getCity();
                    $row[] = $client->getState();
                    $row[] = $client->getZip();
                    $row[] = substr(trim($proposal->getOwner()->getFirstName()), 0,
                            1) . ' ' . $proposal->getOwner()->getLastName();
                    $data[] = $row;
                }
                $fileName = 'pipeline.csv';
                break;

            default:
                $selectedStatus = $this->input->post('reportType');

                $status = $this->em->find('\models\Status', $selectedStatus);

                $users = (is_array(@$_POST['accounts'])) ? $_POST['accounts'] : array();

                //format users array
                $uk = 0;
                foreach ($users as $uid => $val) {
                    $users[$uid] = $uid;
                    $usersArray[$uk] = $uid;
                    $uk++;
                }

                $columns = array(
                    "#",
                    'Job #',
                    'Date Issued',
                    'Status Change Date',
                    'Jobsite',
                    'Amount',
                    'Status',
                    'Lead Source',
                    'Contact Name',
                    'Title',
                    'Company',
                    'Email',
                    'Cell Phone',
                    'Business Phone',
                    'Fax',
                    'Address',
                    'City',
                    'State',
                    'Zip',
                    'User Account'
                );
                $data[] = $columns;
                //$proposals = $this->em->createQuery('SELECT p FROM models\Proposals p inner join p.client c inner join c.company cmp where (cmp.companyId = c.company) and (cmp.companyId = ' . $this->account()->getCompany()->getCompanyId() . ') and (p.created>=' . $start . ') and (p.created<=' . $end . ')')->getResult();
                $k = 0;

                // Base query - Set up proposals for company and users
                $baseQueryDQL = '
                SELECT p FROM models\Proposals p
               
                WHERE (p.created >= :startTime AND p.created <= :endTime)
                AND p.owner IN (:userIds)
                AND p.proposalStatus = :statusId';

                // Apply Status chage if requested
                if ($this->input->post('statusApply')) {
                    $baseQueryDQL .= ' AND (p.statusChangeDate >= :statusStart AND p.statusChangeDate <= :statusEnd)';
                }

                $baseQuery = $this->em->createQuery($baseQueryDQL);
               
                $baseQuery->setParameter('startTime', $start);
                $baseQuery->setParameter('endTime', $end);
                $baseQuery->setParameter('statusId', $selectedStatus);
                if ($this->input->post('statusApply')) {
                    $baseQuery->setParameter('statusStart', $statusStart);
                    $baseQuery->setParameter('statusEnd', $statusEnd);
                }
                $baseQuery->setParameter('userIds', $usersArray);
                $proposals = $baseQuery->getResult();

                foreach ($proposals as $proposal) {
                    $statusDateChangeText = '';
                    if ($proposal->getStatusChangeDate()) {
                        $statusDateChangeText = date('d/M/Y', $proposal->getStatusChangeDate());
                    }
//do magic here
                    $k++;
                    $row = array();
                    $row[] = $k;
                    $row[] = $proposal->getJobNumber();
                    $row[] = $proposal->getCreated();
                    $row[] = $statusDateChangeText;
                    $row[] = $proposal->getProjectName();
                    $row[] = '$' . $proposal->getTotalPrice();
                    $row[] = $proposal->getProposalStatus()->getText();
                    $row[] = $proposal->getLeadSource();
                    $client = $proposal->getClient();
                    $row[] = $client->getFirstName() . ' ' . $client->getLastName();
                    $row[] = $client->getTitle();
                    $row[] = $client->getClientAccount()->getName();
                    $row[] = $client->getEmail();
                    $row[] = $client->getCellPhone();
                    $row[] = $client->getBusinessPhone();
                    $row[] = $client->getFax();
                    $row[] = $client->getAddress();
                    $row[] = $client->getCity();
                    $row[] = $client->getState();
                    $row[] = $client->getZip();
                    $row[] = substr(trim($proposal->getOwner()->getFirstName()), 0,
                            1) . ' ' . $proposal->getOwner()->getLastName();
                    $data[] = $row;
                }
                $fileName = $status->getText() . '-proposals.csv';
        }

//CSV File Output
        $writer->insertAll($data);
        $writer->output($fileName);
        $_SESSION['downloadstatus'] = array("status" => "finished", "message" => "Done");
        return;

    }

    function getDownloadStatus(){
        session_start();
        echo json_encode($_SESSION['downloadstatus']);
    }
}
