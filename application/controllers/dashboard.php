<?php

use \Carbon\Carbon;
 
class Dashboard extends MY_Controller
{
   
    
    function __construct()
    {
        $this->login_restricted = true;
        parent::__construct();
    }

    function index()
    {

    

        $data = array();
        $data['account'] = $this->account();
        $data['psaError'] = false;

        /*
        if ($this->account()->getCompany()->hasPSA()) {

            if ($this->account()->hasPsaCreds() && !$this->session->userdata('psaAlertShown')) {
                $this->load->library('psa_client', ['account' => $this->account()]);
                $responseObj = $this->psa_client->checkCredentials();

                if ($responseObj->error) {
                    $data['psaError'] = true;
                    $this->session->set_userdata('psaAlertShown', 1);
                }
            }
        }
        */

        $this->load->database();
        //Get and Set Leads for the dashboard
        if ($this->account()->getUserClass() >= 2) {
            $sql = "select * from leads where leads.company = " . $this->account()->getCompany()->getCompanyId();
        } elseif ($this->account()->getUserClass() == 1) {
            $sql = "select * from leads left join accounts on accounts.accountId = leads.account where leads.company = " . $this->account()->getCompany()->getCompanyId() . ' and accounts.branch = ' . $this->account()->getBranch();
        } else {
            $sql = "select * from leads where leads.company = " . $this->account()->getCompany()->getCompanyId() . ' and leads.account=' . $this->account()->getAccountId();
        }
        $sql .= " and (leads.status = 'Working' or leads.status='Waiting for Subs') order by leads.dueDate desc";
        $this->leads = $this->db->query($sql)->result();
        /*New top 10 proposals code*/
        if (($this->account()->getUserClass() >= 2)) { //full access+
            $sql = "SELECT proposals.proposalId, proposals.created, proposals.projectName, proposals.price, clients.firstName, clients.lastName, clients.cellPhone, clients.businessPhone, cc.name as companyName
            FROM `proposals`
            LEFT JOIN clients ON proposals.client = clients.clientId
            LEFT JOIN client_companies cc ON clients.client_account = cc.id
            WHERE clients.company = ?
            AND proposalStatus = ?
            AND duplicateOf IS NULL
            ORDER BY price DESC LIMIT 10";
        } elseif (($this->account()->getUserClass() == 1)) { //branch manager
            $branch = $this->account()->getBranch();
            $sql = "SELECT proposals.proposalId, proposals.created, proposals.projectName, proposals.price, clients.firstName, clients.lastName, clients.cellPhone, clients.businessPhone, cc.name as companyName
            FROM `proposals`
            LEFT JOIN clients ON proposals.client = clients.clientId
            LEFT JOIN accounts ON clients.account = accounts.accountId
            LEFT JOIN client_companies cc ON clients.client_account = cc.id
            WHERE clients.company = ?
            AND proposalStatus = ?
            AND accounts.branch = {$branch}
            AND duplicateOf IS NULL
            ORDER BY price DESC LIMIT 10";
        } else { //regular user
            $sql = "SELECT proposals.proposalId, proposals.created, proposals.projectName, proposals.price, clients.firstName, clients.lastName, clients.cellPhone, clients.businessPhone, cc.name as companyName
            FROM `proposals`
            LEFT JOIN clients ON proposals.client = clients.clientId
            LEFT JOIN client_companies cc ON clients.client_account = cc.id
            WHERE clients.company = ?
            AND proposalStatus = ?
            AND proposals.owner = ?
            AND duplicateOf IS NULL ORDER BY price DESC LIMIT 10";
        }
 

        $top_ten = $this->db->query($sql, array($this->account()->getCompany()->getCompanyId(),
                $this->account()->getCompany()->getOpenStatus()->getStatusId(),
                $this->account()->getAccountId())
        )->result();

 
        //New Dynamic datePicker pre-set
        if (count($top_ten) && 0) {
            $minDate = $this->em->createQuery('select p.created from models\Proposals p inner join p.client c inner join c.company cmp where (cmp.companyId = c.company) and (cmp.companyId = ' . $this->account()->getCompany()->getCompanyId() . ') order by p.created')->setMaxResults(1)->getSingleScalarResult();
            $firstWonDate = $this->em->createQuery("select p.created from models\Proposals p inner join p.client c inner join c.company cmp where (p.status = 'Open') and (cmp.companyId = c.company) and (cmp.companyId = " . $this->account()->getCompany()->getCompanyId() . ') order by p.created')->setMaxResults(1)->getSingleScalarResult();
        } else {
            $minDate = $this->account()->getCompany()->getCreated();
            $firstWonDate = $minDate;
        }
        
        $this->load->model('branchesapi');
        $data['deleteRequests'] = ($this->account()->isAdministrator()) ? $this->account()->getCompany()->numDeleteRequests() : 0;
        $data['unassignedLeads'] = ($this->account()->isAdministrator()) ? $this->getDashboardStatsRepository()->leadsActive($this->account()->getCompany()->getCompanyId(), 0, time(), null, null, true) : 0;

        $data['branches'] = $this->branchesapi->getBranches($this->account()->getCompany()->getCompanyId());
        
        $data['top_ten'] = $top_ten;
        $data['account'] = $this->account();
        $data['minDate'] = $minDate;
        $data['firstWonDate'] = $firstWonDate;
        $data['leads'] = $this->leads;
        $data['sortedAccounts'] = array();
        $data['sortedAccounts'] = $this->account()->getCompany()->getActiveSortedAccounts();
        $data['statBranches'] = array();

        $companyRepo = $this->getCompanyRepository();

        // Admin - all the accounts are belong to us
        if ($this->account()->hasFullAccess()) {
            $data['accounts'] = $this->getCompanyAccounts();
            $data['sortedAccounts'] = $companyRepo->getSalesAccounts($this->account()->getCompanyId());
            $data['statBranches'] = $this->account()->getCompany()->getBranches();
        }

        // Branch Manager - get Branch users
        if ($this->account()->getUserClass() == 1) {
            $data['sortedAccounts'] = $companyRepo->getSalesAccounts($this->account()->getCompanyId(), $this->account()->getBranch());
            $data['branch'] = $this->em->find('\models\Branches', $this->account()->getBranch());
        }

        // Statuses
        $data['openStatus'] = $this->account()->getCompany()->getDefaultStatus(\models\Status::OPEN);
        $data['wonStatus'] = $this->account()->getCompany()->getDefaultStatus(\models\Status::WON);
        $data['lostStatus'] = $this->account()->getCompany()->getDefaultStatus(\models\Status::LOST);
        $data['completeStatus'] = $this->account()->getCompany()->getDefaultStatus(\models\Status::COMPLETED);
        $data['defaultCustomFrom'] = $this->session->userdata('pStatusFilterFrom') ?: $this->account()->getCompany()->getCreated(false);
        $data['defaultCustomTo'] = $this->session->userdata('pStatusFilterTo') ?: date('m/d/Y');
        $data['upcomingEventsCounter'] = $this->getEventRepository()->getUpcomingEventsCount($this->account());
        $data['events'] = $this->getEventRepository()->getCalendarEventObjects($this->account(), Carbon::now()->timestamp, Carbon::now()->addWeek()->timestamp);
        // Permitted Accounts for filter
        $data['filterAccounts'] = $this->getCompanyRepository()->getPermittedAccounts($this->account());
        // Announcements
        $data['announcements'] = $this->getAnnouncementRepository()->getUserAnnouncements($this->account());
        $Statuses = $this->account()->getCompany()->getStatuses();
        $statusObject = [];
        $i=0;
        foreach ($Statuses as $status) { 
            
            $statusObject[$i]['status_name'] = $status->getText();
            $statusObject[$i]['status_color'] = $status->getColor();
            $i++;
        }
        $data['statusObject']  = $statusObject;                 
        $this->html->addScript('googleAjax');
        $this->html->addScript('dataTables');
        $this->html->addScript('scheduler');
        $this->html->addScript('select2');
        // check for permission sales manager
        $salesManagerDeactive = $this->account()->getCompany()->getSalesManager();
        $modifyPriceDeactive = $this->account()->getCompany()->getModifyPrice();
        $proposalCampaignsDeactive = $this->account()->getCompany()->getProposalCampaigns();
        if ($salesManagerDeactive==0 ) {
            // If salesManagerDeactive is true, push 3 into the array
            $tabDeactivearr = 0; //inactive
        }else{
            $tabDeactivearr = 1; //active
        }        

       
        $data['checkTabActive'] = $tabDeactivearr;
//         echo '<pre>';
// print_r($this->session->all_userdata());
// echo '</pre>';die;

         $this->load->view('dashboard/new-dashboard', $data);
    }

    function super_user(){

        
        $data = array();
        $data['account'] = $this->account();
        $data['psaError'] = false;

        $this->load->database();

        if($this->account()->getParentCompanyId()){
            
            $masterCompany = $this->em->findCompany($this->account()->getParentCompanyId());
        }else{
            
            $masterCompany = $this->account()->getCompany();
        }

        $data['childCompanies'] =  $this->getCompanyRepository()->getParentChildCompanies($masterCompany->getCompanyId());

        $companyRepo = $this->getCompanyRepository();

        $childCompanyIds = [];
        $data['masterBranches'] = array();

       
        $statusObject = [];
        $i=0;

        
        
        foreach($data['childCompanies'] as $childCompany){
            $mainBrachUsers = $companyRepo->getMainBranchAccounts($childCompany->companyId,true);
            $childCompanyIds[] = $childCompany->companyId;
            $branchCompany = $this->em->findCompany($childCompany->companyId);
            $data['masterBranches'][$childCompany->companyId][] = array(
                'Id' => 0,
                'Name' => 'Main Branch',
                'Users' => $mainBrachUsers,
                'companyName' =>$branchCompany->getCompanyName(),
            );
           
            
            $Statuses = $branchCompany->getStatuses();

            foreach ($Statuses as $status) { 


            if (!in_array($status->getText(), array_column($statusObject, 'status_name'))) {
               
                    $statusObject[$i]['status_name'] = $status->getText();
                    $statusObject[$i]['status_color'] = $status->getColor();
                    $i++;
              }

               
            }


        }
     

 
        //Get and Set Leads for the dashboard
        if ($this->account()->getUserClass() >= 2) {
            $sql = "select * from leads where leads.company = " . $this->account()->getCompany()->getCompanyId();
        } elseif ($this->account()->getUserClass() == 1) {
            $sql = "select * from leads left join accounts on accounts.accountId = leads.account where leads.company = " . $this->account()->getCompany()->getCompanyId() . ' and accounts.branch = ' . $this->account()->getBranch();
        } else {
            $sql = "select * from leads where leads.company = " . $this->account()->getCompany()->getCompanyId() . ' and leads.account=' . $this->account()->getAccountId();
        }
        $sql .= " and (leads.status = 'Working' or leads.status='Waiting for Subs') order by leads.dueDate desc";
        $this->leads = $this->db->query($sql)->result();
        /*New top 10 proposals code*/
        //if (($this->account()->getUserClass() >= 2)) { //full access+
            // $sql = "SELECT proposals.proposalId, proposals.created, proposals.projectName, proposals.price, clients.firstName, clients.lastName, clients.cellPhone, clients.businessPhone, cc.name as companyName,companies.companyName as p_company_name
            // FROM `proposals`
            // LEFT JOIN clients ON proposals.client = clients.clientId
            // LEFT JOIN companies ON proposals.company_id = companies.companyId
            // LEFT JOIN client_companies cc ON clients.client_account = cc.id
            // WHERE clients.company IN(".implode(',',$childCompanyIds).") 
            // AND proposalStatus = 1
            // AND duplicateOf IS NULL
            // ORDER BY price DESC LIMIT 10";

        $sql="SELECT 
        proposals.proposalId, 
        proposals.created, 
        proposals.projectName, 
        proposals.price, 
        clients.firstName, 
        clients.lastName, 
        clients.cellPhone, 
        clients.businessPhone, 
        cc.name as companyName, 
        companies.companyName as p_company_name 
    FROM 
        `proposals` 
    LEFT JOIN 
        clients ON proposals.client = clients.clientId 
    LEFT JOIN 
        companies ON proposals.company_id = companies.companyId 
    LEFT JOIN 
        client_companies cc ON clients.client_account = cc.id 
    WHERE 
        proposalStatus = 1 
        AND duplicateOf IS NULL 
    ORDER BY 
        price DESC 
    LIMIT 10
    ";

 
        // } elseif (($this->account()->getUserClass() == 1)) { //branch manager
        //     $branch = $this->account()->getBranch();
        //     $sql = "SELECT proposals.proposalId, proposals.created, proposals.projectName, proposals.price, clients.firstName, clients.lastName, clients.cellPhone, clients.businessPhone, cc.name as companyName
        //     FROM `proposals`
        //     LEFT JOIN clients ON proposals.client = clients.clientId
        //     LEFT JOIN accounts ON clients.account = accounts.accountId
        //     LEFT JOIN client_companies cc ON clients.client_account = cc.id
        //     WHERE clients.company = ?
        //     AND proposalStatus = ?
        //     AND accounts.branch = {$branch}
        //     AND duplicateOf IS NULL
        //     ORDER BY price DESC LIMIT 10";
        // } else { //regular user
        //     $sql = "SELECT proposals.proposalId, proposals.created, proposals.projectName, proposals.price, clients.firstName, clients.lastName, clients.cellPhone, clients.businessPhone, cc.name as companyName
        //     FROM `proposals`
        //     LEFT JOIN clients ON proposals.client = clients.clientId
        //     LEFT JOIN client_companies cc ON clients.client_account = cc.id
        //     WHERE clients.company = ?
        //     AND proposalStatus = ?
        //     AND proposals.owner = ?
        //     AND duplicateOf IS NULL ORDER BY price DESC LIMIT 10";
        // }

        $top_ten = $this->db->query($sql)->result();


        //New Dynamic datePicker pre-set
        if (count($top_ten) && 0) {
            $minDate = $this->em->createQuery('select p.created from models\Proposals p inner join p.client c inner join c.company cmp where (cmp.companyId = c.company) and (cmp.companyId = ' . $this->account()->getCompany()->getCompanyId() . ') order by p.created')->setMaxResults(1)->getSingleScalarResult();
            $firstWonDate = $this->em->createQuery("select p.created from models\Proposals p inner join p.client c inner join c.company cmp where (p.status = 'Open') and (cmp.companyId = c.company) and (cmp.companyId = " . $this->account()->getCompany()->getCompanyId() . ') order by p.created')->setMaxResults(1)->getSingleScalarResult();
        } else {
            $minDate = $this->account()->getCompany()->getCreated();
            $firstWonDate = $minDate;
        }
        
        $this->load->model('branchesapi');
        $data['deleteRequests'] = ($this->account()->isAdministrator()) ? $this->account()->getCompany()->numDeleteRequests() : 0;
        $data['unassignedLeads'] = ($this->account()->isAdministrator()) ? $this->getDashboardStatsRepository()->leadsActive($this->account()->getCompany()->getCompanyId(), 0, time(), null, null, true) : 0;

        $data['branches'] = $this->branchesapi->getBranches($this->account()->getCompany()->getCompanyId());

        
        
        $data['top_ten'] = $top_ten;
        $data['account'] = $this->account();
        $data['minDate'] = $minDate;
        $data['firstWonDate'] = $firstWonDate;
        $data['leads'] = $this->leads;
        $data['sortedAccounts'] = array();
        $data['sortedAccounts'] = $this->account()->getCompany()->getActiveSortedAccounts();
        $data['statBranches'] = array();


        // Admin - all the accounts are belong to us
        //if ($this->account()->hasFullAccess()) {
            $data['accounts'] = $this->getCompanyAccounts();
            $data['sortedAccounts'] = $companyRepo->getSalesAccounts($this->account()->getCompanyId());
            $data['statBranches'] = $this->account()->getCompany()->getMultipleCompanyBranches($masterCompany->getChildCompanyIds());
             
            foreach($data['statBranches'] as $branches){
                $brachUsers = $companyRepo->getAccounts($branches->getCompany(),$branches->getBranchId(),true);
                $branchCompany = $this->em->findCompany($branches->getCompany());
                $data['masterBranches'][$branches->getCompany()][] = array(
                    'Id' => $branches->getBranchId(),
                    'Name' => $branches->getBranchName(),
                    'Users' => $brachUsers,
                    'companyName' =>$branchCompany->getCompanyName(),
                );

            }
            
//echo "<pre>";print_r($data['masterBranches']);die;

       // }

        // Branch Manager - get Branch users
        if ($this->account()->getUserClass() == 1) {
            $data['sortedAccounts'] = $companyRepo->getSalesAccounts($this->account()->getCompanyId(), $this->account()->getBranch());
            $data['branch'] = $this->em->find('\models\Branches', $this->account()->getBranch());
        }

        // Statuses
        $data['openStatus'] = $this->account()->getCompany()->getDefaultStatus(\models\Status::OPEN);
        $data['wonStatus'] = $this->account()->getCompany()->getDefaultStatus(\models\Status::WON);
        $data['lostStatus'] = $this->account()->getCompany()->getDefaultStatus(\models\Status::LOST);
        $data['completeStatus'] = $this->account()->getCompany()->getDefaultStatus(\models\Status::COMPLETED);
        $data['defaultCustomFrom'] = $this->session->userdata('pStatusFilterFrom') ?: $this->account()->getCompany()->getCreated(false);
        $data['defaultCustomTo'] = $this->session->userdata('pStatusFilterTo') ?: date('m/d/Y');
        $data['upcomingEventsCounter'] = $this->getEventRepository()->getUpcomingEventsCount($this->account());
        $data['events'] = $this->getEventRepository()->getCalendarEventObjects($this->account(), Carbon::now()->timestamp, Carbon::now()->addWeek()->timestamp);
        // Permitted Accounts for filter
        $data['filterAccounts'] = $this->getCompanyRepository()->getPermittedAccounts($this->account());
        // Announcements
        $data['announcements'] = $this->getAnnouncementRepository()->getUserAnnouncements($this->account());
        
        $data['statusObject']  = $statusObject;                 
        $this->html->addScript('googleAjax');
        $this->html->addScript('dataTables');
        $this->html->addScript('scheduler');
        $this->html->addScript('select2');

         

        $this->load->view('dashboard/super-user-dashboard', $data);
    }


    function sublogin()
    {
        if(!$this->input->post('companyId')){
            $this->session->set_flashdata('error', 'Invalid Company!');
            redirect('dashboard/super_user');
        }
        if($this->account()->getCompany()->getCompanyId() == $this->input->post('companyId')){
            redirect('dashboard');
        }

        $userId = $this->getCompanyRepository()->getChildSubloginAccount($this->account(),$this->input->post('companyId'));
        if(!$userId){
            $this->session->set_flashdata('error', 'Invalid account ID!');
            redirect('dashboard/super_user');

        }
        $account = $this->em->find('models\Accounts', $userId);
        if (!$account) {
            $this->session->set_flashdata('error', 'Invalid account ID!');
            redirect('dashboard/super_user');
        }

        if($this->session->userdata('sublogin')){
            //set the current session old sublogin id
            $this->session->set_userdata('oldsublogin', $this->account()->getAccountId());
        }

        //set the session sublogin id
        $this->session->set_userdata('sublogin', $userId);
        $this->session->set_flashdata('success', 'Logged in successfully ' . $account->getFullName());

        
        // Clear the proposal filters
        $this->session->set_userdata(array(
            'pFilter' => '',
            'pFilterUser' => '',
            'pFilterBranch' => '',
            'pFilterStatus' => '',
            'pFilterService' => '',
            'pFilterFrom' => '',
            'pFilterTo' => '',
            'pFilterQueue' => '',
            'pFilterEmailStatus' => '',
            'pFilterClientAccount' => '',
            'pFilterMinBid' => '',
            'pFilterMaxBid' => '',
            'psaAlertShown' => ''
        ));

        redirect('account');
    }
// proposal export data for superadmin 
 
 


public function proposal_data_extract() {
    $data = [];
    $proposals = [];
    $time['start'] = 0;
    $time['finish'] = Carbon::create()->endOfDay()->timestamp;
    $range = $this->input->post('range'); 
     if ($range != 'custom') {
        $time = getRangeStartFinish($range);
    } else {
        $customFrom = $this->input->post('customFrom');
        $customTo = $this->input->post('customTo');
        if ($customFrom == '' && $customTo == '') {
            $time['start'] = 0;
            $time['finish'] = Carbon::create()->endOfDay()->timestamp;
        } else {
            $time['start'] = Carbon::parse($customFrom)->startOfDay()->timestamp;
            $time['finish'] = Carbon::parse($customTo)->endOfDay()->timestamp;
        }
    }
    if ($this->input->post('filterIds')) {
        $filterIds = explode(",", $this->input->post('filterIds'));
        $filterType = $this->input->post('filterType');
        switch ($filterType) {
            case 'company':
            case 'all':
                $sqlQuery1 = "SELECT 
                    proposals.proposalId AS proposal_id,
                    companies.companyId AS company_id,
                    companies.companyName AS companyName,
                    IFNULL(proposals.price, 0) AS proposal_total_amount,
                    IFNULL(proposals.price, 0) AS total_bid_amount,
                    proposal_services.serviceId AS proposal_details_row_id,
                    CASE 
                        WHEN branches.branchName IS NULL OR branches.branchName = '0' OR branches.branchName = '' THEN 'Main' 
                        ELSE branches.branchName 
                    END AS branch,
                    proposal_services.serviceName AS proposal_details_job_service_name,
                    IFNULL(proposal_services.price, 0) AS proposal_details_amount,
                    accounts.accountId AS account_id,
                    DATE_FORMAT(FROM_UNIXTIME(proposals.created), '%m-%d-%y') AS proposal_date,
                    proposals.projectName AS project,
                    CONCAT(accounts.firstName, ' ', accounts.lastName) AS account_manager,
                    COALESCE(clients.companyName, 'Residential') AS company,
                    proposals.status AS proposal_status 
                FROM proposals 
                LEFT JOIN clients ON proposals.client = clients.clientId 
                LEFT JOIN companies ON clients.company = companies.companyId
                LEFT JOIN proposal_services ON proposals.proposalId = proposal_services.proposal
                LEFT JOIN accounts ON proposals.owner = accounts.accountId
                LEFT JOIN branches ON branches.branchId = accounts.branch 
                WHERE companies.companyId IN (" . implode(",", array_map('intval', $filterIds)) . ")
                AND proposals.created BETWEEN ? AND ? 
                ORDER BY accounts.firstName ASC";
                $proposals = $this->db->query($sqlQuery1, [$time['start'], $time['finish']])->result();
                break;
            case 'branch':
                $filterBranches = array_map(function ($filterId) {
                    $tempArr = explode("_", $filterId);
                    return ['companyId' => intval($tempArr[0]), 'branchId' => intval($tempArr[1])];
                }, $filterIds);
                
                $allProposals = [];
                foreach ($filterBranches as $filterBranch) {
                    if ($filterBranch['branchId'] > 0) {
                        $branchQuery = "SELECT accountId
                                        FROM accounts 
                                        WHERE company = ? 
                                        AND branch = ?";

                        $branchQueryResult = $this->db->query($branchQuery, [$filterBranch['companyId'], $filterBranch['branchId']])->result();
                        $accountIds = array_map(function ($row) {
                            return $row->accountId;
                        }, $branchQueryResult);
                        if (!empty($accountIds)) {
                                $branchQueryProposal = "SELECT 
                                proposals.proposalId AS proposal_id,
                                companies.companyId AS company_id,
                                companies.companyName AS companyName,
                                IFNULL(proposals.price, 0) AS proposal_total_amount,
                                IFNULL(proposals.price, 0) AS total_bid_amount,
                                proposal_services.serviceId AS proposal_details_row_id,
                                proposal_services.serviceName AS proposal_details_job_service_name,
                                IFNULL(proposal_services.price, 0) AS proposal_details_amount,
                                accounts.accountId AS account_id,
                                branches.branchName AS branch,
                                DATE_FORMAT(FROM_UNIXTIME(proposals.created), '%m-%d-%y') AS proposal_date,
                                proposals.projectName AS project,
                                CONCAT(accounts.firstName, ' ', accounts.lastName) AS account_manager,
                                COALESCE(clients.companyName, 'Residential') AS company,
                                proposals.status AS proposal_status 
                                FROM proposals 
                               JOIN clients ON proposals.client = clients.clientId 
                               JOIN companies ON clients.company = companies.companyId
                               JOIN proposal_services ON proposals.proposalId = proposal_services.proposal
                               JOIN accounts ON proposals.owner = accounts.accountId
                               JOIN branches ON branches.branchId = accounts.branch  
                                WHERE
                                branches.branchId = ".$filterBranch['branchId']."
                                AND proposals.created BETWEEN ? AND ?
                                GROUP BY proposals.proposalId
                                ORDER BY accounts.firstName ASC";
                                $branchProposals = $this->db->query($branchQueryProposal, [$time['start'], $time['finish']])->result();
                                $allProposals = array_merge($allProposals, $branchProposals);
                        }
                    } else {
                        $branchQuery2 = "SELECT accountId, company
                                        FROM accounts 
                                        WHERE company = ? 
                                        AND branch = 0";

                        $branchResult = $this->db->query($branchQuery2, [$filterBranch['companyId']])->result();
                        $accountIds = array_map(function ($row) {
                            return $row->accountId;
                        }, $branchResult);

                        if (!empty($accountIds)) {
                            $branchQueryZero = "SELECT 
                                proposals.proposalId AS proposal_id,
                                companies.companyId AS company_id,
                                companies.companyName AS companyName,
                                IFNULL(proposals.price, 0) AS proposal_total_amount,
                                IFNULL(proposals.price, 0) AS total_bid_amount,
                                proposal_services.serviceId AS proposal_details_row_id,
                                proposal_services.serviceName AS proposal_details_job_service_name,
                                IFNULL(proposal_services.price, 0) AS proposal_details_amount,
                                accounts.accountId AS account_id,
                                branches.branchName AS branch,
                                DATE_FORMAT(FROM_UNIXTIME(proposals.created), '%m-%d-%y') AS proposal_date,
                                proposals.projectName AS project,
                                CONCAT(accounts.firstName, ' ', accounts.lastName) AS account_manager,
                                COALESCE(clients.companyName, 'Residential') AS company,
                                proposals.status AS proposal_status 
                            FROM proposals 
                            LEFT JOIN clients ON proposals.client = clients.clientId 
                            LEFT JOIN companies ON clients.company = companies.companyId
                            LEFT JOIN proposal_services ON proposals.proposalId = proposal_services.proposal
                            LEFT JOIN accounts ON proposals.owner = accounts.accountId
                            LEFT JOIN branches ON branches.branchId = accounts.branch  
                            WHERE accounts.accountId IN (" . implode(",", $accountIds) . ")
                            AND proposals.created BETWEEN ? AND ?
                             ORDER BY accounts.firstName ASC";
                            $branchProposalsZero = $this->db->query($branchQueryZero, [$time['start'], $time['finish']])->result();
                            $allProposals = array_merge($allProposals, $branchProposalsZero);
                        }
                    }
                }

                $proposals = $allProposals;
                 break;

            case 'user':
                $proposalUserQuery = "SELECT 
                    proposals.proposalId AS proposal_id,
                    companies.companyId AS company_id,
                    companies.companyName AS companyName,
                    IFNULL(proposals.price, 0) AS proposal_total_amount,
                    IFNULL(proposals.price, 0) AS total_bid_amount,
                    proposal_services.serviceId AS proposal_details_row_id,
                    CASE 
                    WHEN branches.branchName IS NULL OR branches.branchName = '0' OR branches.branchName = '' THEN 'Main' 
                    ELSE branches.branchName 
                    END AS branch,
                    proposal_services.serviceName AS proposal_details_job_service_name,
                    IFNULL(proposal_services.price, 0) AS proposal_details_amount,
                    accounts.accountId AS account_id,
                    DATE_FORMAT(FROM_UNIXTIME(proposals.created), '%m-%d-%y') AS proposal_date,
                    proposals.projectName AS project,
                    CONCAT(accounts.firstName, ' ', accounts.lastName) AS account_manager,
                    COALESCE(clients.companyName, 'Residential') AS company,
                    proposals.status AS proposal_status 
                FROM proposals 
                LEFT JOIN clients ON proposals.client = clients.clientId 
                LEFT JOIN companies ON clients.company = companies.companyId
                LEFT JOIN proposal_services ON proposals.proposalId = proposal_services.proposal
                LEFT JOIN accounts ON proposals.owner = accounts.accountId
                LEFT JOIN branches ON branches.branchId = accounts.branch 
                WHERE accounts.accountId IN (" . implode(",", array_map('intval', $filterIds)) . ")
                AND proposals.created BETWEEN ? AND ?
                  ORDER BY accounts.firstName ASC";
                $proposals = $this->db->query($proposalUserQuery, [$time['start'], $time['finish']])->result();
                break;
        }
    }
    $fields = ["Proposal ID", "Proposal Total Amount", "Total Bid Amount", "Proposal Date", "Project", "Account manager","Branch", "Company","Proposal Status","Proposal Detail Row ID", "Proposal Detail Job", "Proposal Detail Amount"];
    if (is_array($fields)) {
        $labels = $fields;
        $data[] = $labels;
    } 
              foreach ($proposals as $record) {
            $p = [];
            foreach ($fields as $value) {
                switch ($value) {
                    case 'Proposal ID':
                        $p[] = $record->proposal_id;
                        break;
                    case 'Proposal Total Amount':
                        $p[] = "$" . number_format($record->proposal_total_amount, 2);
                        break;
                    case 'Total Bid Amount':
                        $p[] = "$0.00";
                        break;
                    case 'Proposal Date':
                        $p[] = $record->proposal_date;
                        break;
                    case 'Project':
                        $p[] = $record->project;
                        break;
                    case 'Account manager':
                        $p[] = $record->account_manager;
                        break;
                    case 'Branch':
                        $p[] =  $record->branch ?? 'Main';
                        break;
                    case 'Company':
                        $p[] = $record->company;
                        break; 
                    case 'Proposal Status':
                        $p[] = $record->proposal_status;
                        break;
                    case 'Proposal Detail Row ID':
                        $p[] = $record->proposal_details_row_id;
                        break;                            
                    case 'Proposal Detail Job':
                        $p[] = $record->proposal_details_job_service_name;
                        break;                            
                    case 'Proposal Detail Amount':                            
                        $amount = $record->proposal_details_amount;
                        if (empty($amount) || $amount == 0) {
                            $p[] = "$" . number_format(0);
                        } else {
                            $p[] = $amount;
                        }
                        break;  
                    default:
                        $p[] = $value . ' undefined.';
                        break;
                }
            }
            $data[] = $p;
        }
    
        $fileName = 'proposals -' . $this->account()->getCompany()->getCompanyId() . '-' . time() . '.csv';
        $subject = 'Your Dashboard Summary Export is Done!';
        $content = 'Hello! The requested export is done and ready to download! You can get it here: ' . site_url('uploads/exports/' . $fileName);
        if($this->account()->getParentUserId()){
            $account = $this->em->findAccount($this->account()->getParentUserId());
            $toEmail = $account->getEmail();
        }else{
            $toEmail = $this->account()->getEmail();
        }
        $emailData = [
            'to' => $toEmail,
            'fromName' => SITE_NAME,
            'fromEmail' => 'no-reply@' . SITE_EMAIL_DOMAIN,
            'subject' => $subject,
            'body' => $content,
            'categories' => ['Export'],
        ];
        $this->getEmailRepository()->send($emailData);

    export($data, 'csv', $fileName, false);
}

    
    
}
