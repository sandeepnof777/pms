<?php

// import the Intervention Image Manager Class
use Intervention\Image\ImageManager;
use Carbon\Carbon;

class Proposals extends MY_Controller
{
    public ClientEmail $clientEmail;
    public ProposalHelper $proposalhelper;

    public function __construct()
    {
        $this->login_restricted = true;
        parent::__construct();

        // Configure the model
        $this->load->database();
    }

    public function group()
    {
        $this->index();
    }

    public function index()
    {
        // Handle old format filter data //

        // Status
        if ($this->session->userdata('pFilterStatus') && !is_array($this->session->userdata('pFilterStatus'))) {
            $value = $this->session->userdata('pFilterStatus');
            $this->session->set_userdata('pFilterStatus', [$value]);
        }

        // User
        if ($this->session->userdata('pFilterUser') && !is_array($this->session->userdata('pFilterUser'))) {
            $value = $this->session->userdata('pFilterUser');
            $this->session->set_userdata('pFilterUser', [$value]);
        }

        // Account
        if (
            $this->session->userdata('pFilterClientAccount')
            && !is_array($this->session->userdata('pFilterClientAccount'))
        ) {
            $value = $this->session->userdata('pFilterClientAccount');
            $this->session->set_userdata('pFilterClientAccount', [$value]);
        } else {
            if ($this->session->userdata('pFilterClientAccount') == '') {
                $this->session->set_userdata('pFilterClientAccount', []);
            }
        }

        $filteredClientAccounts = [];
        if (count($this->session->userdata('pFilterClientAccount')) > 0) {
            foreach ($this->session->userdata('pFilterClientAccount') as $ccid) {
                $filteredClientAccounts[] = $this->em->find('models\ClientCompany', $ccid);
            }
        }

        // Service
        if ($this->session->userdata('pFilterService') && !is_array($this->session->userdata('pFilterService'))) {
            $value = $this->session->userdata('pFilterService');
            $this->session->set_userdata('pFilterService', [$value]);
        }


        // Queue
        if ($this->session->userdata('pFilterQueue') && !is_array($this->session->userdata('pFilterQueue'))) {
            $value = $this->session->userdata('pFilterQueue');
            $this->session->set_userdata('pFilterQueue', [$value]);
        }

        // Email
        if ($this->session->userdata('pFilterEmailStatus') && !is_array($this->session->userdata('pFilterEmailStatus'))) {
            $value = $this->session->userdata('pFilterEmailStatus');
            $this->session->set_userdata('pFilterEmailStatus', [$value]);
        }
        //$this->session->set_userdata('pFilterMaxBid',0);

        $allStatuses = $this->account()->getStatuses();
        $statusCollection = [];
        $wonStatusCollection = [];
        $prospectStatusCollection = [];
        foreach ($allStatuses as $allStatus) {
            if ($allStatus->isProspect()) {
                $prospectStatusCollection[] = $allStatus;
            }else if ($allStatus->getStatusId() ==2) {
                foreach ($allStatuses as $allWonStatus) {
                    if ($allWonStatus->isSales() ) {
                        if ($allWonStatus->getStatusId() !=2) {
                        $wonStatusCollection[] = $allWonStatus;
                        }
                    }
                }
                $allStatus->WonChilds = $wonStatusCollection;
                $statusCollection[] = $allStatus;
            } else {
                if (!$allStatus->isSales()) {
                    $statusCollection[] = $allStatus;
                }
            }
        }


        // End old filter fixes

        $data['categories'] = $this->account()->getCompany()->getCategories();
        $data['userAccount'] = $this->account();
        $data['statusCollection'] = $statusCollection;
        $data['prospectStatusCollection'] = $prospectStatusCollection;
        $data['statuses'] = $allStatuses;
        $data['services'] = $this->account()->getCompany()->getServices(true);

        $data['estimateStatuses'] = $this->getEstimationRepository()->getStatuses();
        $data['estimateJobCostStatuses'] = $this->getEstimationRepository()->getJobCostStatuses();

        //$data['numMappedProposals'] = $this->getCompanyRepository()->getMappedProposalsCount($this->account());
        $data['numMappedProposals'] = 0;
        $data['account'] = $this->account();
        $data['approvalUser'] = ($this->account()->requiresApproval());
                 
        $data['filteredClientAccounts'] = $filteredClientAccounts;
        $data['action'] = '';
        $data['group'] = '';
        $data['search'] = '';
        $data['client'] = '';
        $data['clientCompany'] = '';
        $proposalResendSettings = $this->getProposalNotificationsRepository()->getProposalResendSettings($this->account()->getCompany()->getCompanyId());
        $data['automatic_reminders_template'] = $proposalResendSettings->template;
        $data['automatic_reminders_enabled'] = $proposalResendSettings->enabled;
        $data['proposal_resend_frequency'] = ($proposalResendSettings->frequency) ?: 86400;
        $this->load->model('clientEmail');
        // $data['proposal_email_templates'] = $this->clientEmail->getTemplates($this->account()->getCompany()->getCompanyId(),
        //     1, true);
        $data['minBid'] = 0;
        $data['resends'] = $this->getEstimationRepository()->getCompanyResendList($this->account()->getCompany(), $this->account());

        $data['maxBid'] = $this->account()->getCompany()->getHighestBid();
        $data['filterMinBid'] = $this->session->userdata('pFilterMinBid') ?: 0;
        $data['filterMaxBid'] = $this->session->userdata('pFilterMaxBid') ?: $this->account()->getCompany()->getHighestBid();
        $data['foremans'] = $this->getEstimationRepository()->getCompanyForemenList($this->account()->getCompany());
        $data['proposal_event_types'] = $this->getProposalRepository()->getProposalEventTypes();
        $data['save_filters'] = $this->getProposalRepository()->getProposalSavedFilters($this->account());
        $data['proposal_event_email_types'] = $this->getProposalRepository()->getProposalEventEmailTypes();
        $data['proposal_email_template_fields'] = $this->getProposalRepository()->get_proposal_email_template_fields();
        $data['businessTypes'] = $this->getCompanyRepository()->getCompanyBusinessTypes($this->account()->getCompany());
        $data['userAccounts'] = $this->account()->getCompany()->getActiveSortedAccounts();
        
        $type = $this->uri->segment(3);
        $this->load->model('branchesapi');
        $this->load->database();

        $queryData = array(
            $this->account()->getBranch(),
            $this->account()->getCompany()->getAdministrator()->getAccountId(),
            $this->account()->getCompany()->getCompanyId(),
            $this->account()->getAccountId()
        );

        // for Permission of campaigns
        $proposalCampaignsDeactive = $this->account()->getCompany()->getProposalCampaigns();

        if ($proposalCampaignsDeactive==0) {
            $campaignsPermission = 0; //inactive
         }else{
             $campaignsPermission = 1; //active
         } 
         $data['checkActiveCampaigns']=$campaignsPermission; 

                 //In Group action disable Modify Price start
        $modifyPriceDeactive = $this->account()->getCompany()->getModifyPrice();

        if ($modifyPriceDeactive==0) {
             $modifyPricePermission = 0; //inactive
        }else{
             $modifyPricePermission = 1; //active
        } 
        $data['checkActiveModify']=$modifyPricePermission; 
        //In Group action disable Modify Price end

        //End Permission
        $recipients = $this->db->query(
            'select * from accounts where ((userClass > 1) or (userClass=1 and branch=?) or (accountId=?)) and (company=?) and (accountId!=?) and (requiresApproval = 0)',
            $queryData
        )->result();
        $data['recipients'] = $recipients;

        // Work Order Recipients Query
        $workOrderRecipientsQuery = $this->em->createQuery('select r from models\Work_order_recipients r where r.company=' . $this->account()->getCompany()->getCompanyId() . ' order by r.name');
        // Cache it
        $workOrderRecipientsQuery->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_WORK_ORDER_RECIP . $this->account()->getCompanyId());
        // Apply result
        $data['workOrderRecipients'] = $workOrderRecipientsQuery->getResult();
        $workOrderRecipientsQuery->disableResultCache();

        $data['branches'] = [];
        // Branches based on permission level
        if ($this->account()->hasFullAccess()) {
            $data['accounts'] = $this->account()->getCompany()->getAccounts();
            $data['branches'] = $this->branchesapi->getBranches($this->account()->getCompany()->getCompanyId());
        } else {
            if ($this->account()->isBranchAdmin()) {
                if ($this->account()->getBranch() > 0) {
                    $data['branches'][] = $this->em->findBranch($this->account()->getBranch());
                    $data['accounts'] = $this->branchesapi->getBranchAccounts(
                        $this->account()->getCompany()->getCompanyId(),
                        $this->account()->getBranch()
                    );
                } else {
                    $data['accounts'] = $this->branchesapi->getBranchAccounts(
                        $this->account()->getCompany()->getCompanyId(),
                        $this->account()->getBranch()
                    );
                }
            } else {
                $data['branches'] = [];
                $data['accounts'][] = $this->account();
            }
        }

        $this->html->addScript('dataTables');
        $this->html->addScript('scheduler');
        $this->html->addScript('select2');
        $this->html->addScript('proposalTracking');
        $action = $this->uri->segment(2);

        $this->html->addScript('ckeditor4');
        $this->load->model('clientEmail');
        $data['clientTemplates'] = $this->clientEmail->getTemplates(
            $this->account()->getCompany()->getCompanyId(),
            \models\ClientEmailTemplateType::PROPOSAL,
            true
        );
        $data['proposal_email_templates'] = $data['clientTemplates'];
        $data['createdFilter'] = false;

        if ($this->uri->segment(7) == 'sf' || $this->uri->segment(6) == 'sf' || $this->uri->segment(5) == 'sf' || $this->uri->segment(4) == 'sf') {
            $data['createdFilter'] = true;
        }

        $data['resendId'] = $this->uri->segment(3) ?: '';
        $data['campaignEmailFilter'] = $this->uri->segment(4) ?: '';
        switch ($action) {
            case 'status':
                $data['tableStatus'] = true;
                $data['groupUri'] = false;
                $data['statusUri'] = false;

                // Do we want to use the created date filter?
                if ($type == 'all' || $type == 'rollover' || $type == 'open' || $type == 'other') {
                    $data['createdFilter'] = true;
                }

                if ($this->uri->segment(3) == 'group') {
                    $data['statusUri'] = $groupUri = str_replace('/status/group/', '/status/', current_url());
                    $data['statusAction'] = 'group';
                    $data['group'] = 'group';
                } else {
                    $data['groupUri'] = str_replace('/status/', '/status/group/', current_url());
                    $data['statusAction'] = false;
                }

                if ($data['createdFilter']) {
                    $this->session->set_userdata('pStatusFilterCreate', '1');
                } else {
                    $this->session->set_userdata('pStatusFilterCreate', '');
                }
                $filteredClientAccounts = [];
                if ($this->session->userdata('pstsFilterClientAccount') && count($this->session->userdata('pstsFilterClientAccount')) > 0) {
                    foreach ($this->session->userdata('pstsFilterClientAccount') as $ccid) {
                        $filteredClientAccounts[] = $this->em->find('models\ClientCompany', $ccid);
                    }
                }
                $data['filteredClientAccounts'] = $filteredClientAccounts;
                $data['created_preset'] = false;
                $data['sold_preset'] = false;
                if ($this->session->userdata('pStatusFilterFrom')) {
                    $data['created_preset'] = $this->get_preset_from_dates($this->session->userdata('pStatusFilterFrom'), $this->session->userdata('pStatusFilterTo'));
                }

                if ($this->session->userdata('pStatusFilterChangeFrom')) {
                    $data['sold_preset'] = $this->get_preset_from_dates($this->session->userdata('pStatusFilterChangeFrom'), $this->session->userdata('pStatusFilterChangeTo'));
                }

                $filteredClientAccounts = [];
                if ($this->session->userdata('pstsFilterClientAccount') && count($this->session->userdata('pstsFilterClientAccount')) > 0) {
                    foreach ($this->session->userdata('pstsFilterClientAccount') as $ccid) {
                        $filteredClientAccounts[] = $this->em->find('models\ClientCompany', $ccid);
                    }
                }
                $data['filteredClientAccounts'] = $filteredClientAccounts;

                $this->load->view('proposals/index-status', $data);
                break;
            case 'stats':
                if ($this->session->userdata('pStatsFilterClientAccount')) {
                    $data['client_account'] = $this->em->findClientAccount($this->uri->segment(3));
                } elseif ($this->session->userdata('pStatsFilterBusinessType')) {
                    $data['business'] = $this->em->find('models\BusinessType', $this->session->userdata('pStatsFilterBusinessType'));
                }
                $data['tableStats'] = true;
                $data['created_preset'] = false;

                if ($this->session->userdata('pStatsFilterFrom')) {
                    $data['created_preset'] = $this->get_preset_from_dates($this->session->userdata('pStatsFilterFrom'), $this->session->userdata('pStatsFilterTo'));
                }
                $filteredClientAccounts = [];
                if ($this->session->userdata('psttFilterClientAccount') && count($this->session->userdata('psttFilterClientAccount')) > 0) {
                    foreach ($this->session->userdata('psttFilterClientAccount') as $ccid) {
                        $filteredClientAccounts[] = $this->em->find('models\ClientCompany', $ccid);
                    }
                }
                $data['filteredClientAccounts'] = $filteredClientAccounts;

                $this->load->view('proposals/index-stats', $data);
                break;
            case 'account_stats':
                $data['client_account'] = $this->em->findClientAccount($this->uri->segment(3));
                $data['tableAccStats'] = true;
                $data['created_preset'] = false;
                if ($this->session->userdata('accFilterFrom')) {
                    $data['created_preset'] = $this->get_preset_from_dates($this->session->userdata('accFilterFrom'), $this->session->userdata('accFilterTo'));
                }
                $filteredClientAccounts = [];
                if ($this->session->userdata('pastFilterClientAccount') && count($this->session->userdata('pastFilterClientAccount')) > 0) {
                    foreach ($this->session->userdata('pastFilterClientAccount') as $ccid) {
                        $filteredClientAccounts[] = $this->em->find('models\ClientCompany', $ccid);
                    }
                }
                $data['filteredClientAccounts'] = $filteredClientAccounts;
                $this->load->view('proposals/index-account-stats', $data);
                break;
            case 'resend':
                $data['filterResend'] = true;
                $data['resend'] = $this->em->find('models\ProposalGroupResend', $data['resendId']);
                $data['resendStats'] = $this->getProposalRepository()->getResendStats($data['resend'], $this->account());
                $data['child_resends'] = $this->getProposalRepository()->getChildResend($data['resendId']);
                //print_r($data['child_resends']);die;
                $this->load->view('proposals/index-resend', $data);
                break;

            case 'group':
                $data['group'] = 'group';
                $this->load->view('proposals/index', $data);
                break;

            case 'search':
                $data['action'] = 'search';
                $data['search'] = $this->input->post('searchProposal');
                $this->load->view('proposals/index', $data);
                break;

            case 'clientProposals':
                $data['client'] = $this->uri->segment(3);
                $data['clientCompany'] = $this->em->find('\models\Clients', $data['client'])->getFullName();
                $this->load->view('proposals/index', $data);
                break;

            default:
                $this->load->view('proposals/index', $data);
                break;
        }
    }

    public function status()
    {
        // Auth checks
        // echo $this->uri->segment(4);die;
        if ($this->uri->segment(4) == 'user') {
            
            $userId = $this->uri->segment(5);

            $statsUser = $this->em->find('\models\Accounts', $userId);
            $statsCompanyId = $statsUser->getCompany()->getCompanyId();

            // Don't let anyone view another company
            if ($this->account()->getCompany()->getCompanyId() !== $statsCompanyId) {
                $this->session->set_flashdata('error', 'You do not have access to view this user data');
                redirect('dashboard');
            }

            // Let admins & full access view other users from same company
            if ($this->account()->getUserClass() < 2) {
                if ($this->account()->getAccountId() != $statsUser->getAccountId()) {
                    if ($this->account()->getUserClass() == 1) {
                        if (!$this->account()->getBranch() || ($this->account()->getBranch() != $statsUser->getBranch())) {
                            $this->session->set_flashdata('error', 'You do not have access to view this user data');
                            redirect('dashboard');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'You do not have access to view this user data');
                        redirect('dashboard');
                    }
                }
            }
        }

        // Auth checks
        if ($this->uri->segment(5) == 'user') {
            $userId = $this->uri->segment(6);

            $statsUser = $this->em->find('\models\Accounts', $userId);
            $statsCompanyId = $statsUser->getCompany()->getCompanyId();

            // Don't let anyone view another company
            if ($this->account()->getCompany()->getCompanyId() !== $statsCompanyId) {
                $this->session->set_flashdata('error', 'You do not have access to view this user data');
                redirect('dashboard');
            }

            // Let admins & full access view other users from same company
            if ($this->account()->getUserClass() < 2) {
                if ($this->account()->getAccountId() != $statsUser->getAccountId()) {
                    if ($this->account()->getUserClass() == 1) {
                        if (!$this->account()->getBranch() || ($this->account()->getBranch() != $statsUser->getBranch())) {
                            $this->session->set_flashdata('error', 'You do not have access to view this user data');
                            redirect('dashboard');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'You do not have access to view this user data');
                        redirect('dashboard');
                    }
                }
            }
        }

        $this->session->set_userdata('pStatusFilter', 1);

        // Clear any status change filters (will be applied when needed
        $this->session->set_userdata('pStatusRolloverFilter', '');
        $this->session->set_userdata('pStatusFilterUser', '');
        $this->session->set_userdata('pStatusFilterBranch', '');
        $this->session->set_userdata('pSold', '');
        $this->session->set_userdata('pOpen', '');
        $this->session->set_userdata('pOther', '');
        $this->session->set_userdata('pWon', '');
        $this->session->set_userdata('pEmailOff', '');

        $groupStatus = false;
        $statusId = $this->uri->segment(3);

        switch ($statusId) {
            case 'group':
                $groupStatus = true;
                break;

            case 'all':
                $this->session->set_userdata('pStatusFilterStatus', '');
                $this->session->set_userdata('pStatusFilterStatusName', '');
                break;

            case 'rollover':
                // Get the status
                $openStatus = $this->account()->getCompany()->getOpenStatus();
                // Apply to filter
                $this->session->set_userdata('pStatusFilterStatus', $openStatus->getStatusId());
                $this->session->set_userdata('pStatusFilterStatusName', $openStatus->getText());

                $this->session->set_userdata('pStatusFilterChangeFrom', '');
                $this->session->set_userdata('pStatusFilterChangeTo', '');
                $this->session->set_userdata('pStatusFilterUser', '');


                // get the start & finish
                $start = date(
                    'm/d/Y',
                    $this->account()->getCompany()->getFirstProposalTime()
                );  // Company Creation Date

                $to = explode('/', $this->session->userdata('pStatusFilterFrom'));
                $toTime = (mktime(0, 0, 0, $to[0], $to[1], $to[2]) - 1);
                $finish = date('m/d/Y', $toTime);

                // Apply to filter
                $this->session->set_userdata('pStatusRolloverFilter', 1);
                $this->session->set_userdata('pStatusFilterFrom', $start);
                $this->session->set_userdata('pStatusFilterTo', $finish);
                break;

            case 'magicnumber':
                // Get the status
                $compStatus = $this->account()->getCompany()->getDefaultStatus(\models\Status::COMPLETED);
                // Apply to filter
                $this->session->set_userdata('pStatusFilterStatus', $compStatus->getStatusId());
                $this->session->set_userdata('pStatusFilterStatusName', $compStatus->getText());

                // Remove the date filter so that it doesn't restrict proposal creation dates
                $this->session->set_userdata('pStatusFilterFrom', '');
                $this->session->set_userdata('pStatusFilterTo', '');
                $this->session->set_userdata('pStatusFilterUser', '');

                break;

            case 'delete-requests':
                if (!$this->account()->isAdministrator(true)) {
                    $this->session->set_flashdata('error', 'You do not have permission to edit this account');
                    redirect('proposals');
                }
                // Get the status
                $deleteStatus = $this->account()->getCompany()->getDefaultStatus(\models\Status::DELETE_REQUEST);
                // Apply to filter
                $this->session->set_userdata('pStatusFilterStatus', $deleteStatus->getStatusId());
                $this->session->set_userdata('pStatusFilterStatusName', $deleteStatus->getText());

                // Remove the date filter so that it doesn't restrict proposal creation dates
                $this->session->set_userdata('pStatusFilterFrom', '');
                $this->session->set_userdata('pStatusFilterTo', '');
                // No user filter
                $this->session->set_userdata('pStatusFilterUser', '');
                // No status change filter
                $this->session->set_userdata('pStatusFilterChangeFrom', '');
                $this->session->set_userdata('pStatusFilterChangeTo', '');

                break;

            case 'sold':
                // Apply to filter
                $this->session->set_userdata('pSold', 1);
                $this->session->set_userdata('pStatusFilterStatus', '');
                $this->session->set_userdata('pOpen', '');
                $this->session->set_userdata('pOther', '');
                // Remove the date filter so that it doesn't restrict proposal creation dates
                $this->session->set_userdata('pStatusFilterFrom', '');
                $this->session->set_userdata('pStatusFilterTo', '');
                // No user filter
                $this->session->set_userdata('pStatusFilterStatusName', ucfirst($statusId));
                $this->session->set_userdata('pStatusFilterUser', '');
                break;
            case 'won':
                $this->session->set_userdata('pWon', 1);
                $this->session->set_userdata('pSold', '');
                $this->session->set_userdata('pOther', '');
                $this->session->set_userdata('pStatusFilterStatus', '');
                $this->session->set_userdata('pStatusFilterStatusName', ucfirst($statusId));
                break;
            case 'open':
                $this->session->set_userdata('pOpen', 1);
                $this->session->set_userdata('pSold', '');
                $this->session->set_userdata('pOther', '');
                $this->session->set_userdata('pStatusFilterStatus', 1);
                $this->session->set_userdata('pStatusFilterStatusName', ucfirst($statusId));
                break;
            case 'other':
                $this->session->set_userdata('pOther', 1);
                $this->session->set_userdata('pSold', '');
                $this->session->set_userdata('pOpen', '');
                $this->session->set_userdata('pStatusFilterStatus', '');
                $this->session->set_userdata('pStatusFilterStatusName', ucfirst($statusId));
                break;
            case 'emailoff':
                $this->session->set_userdata('pEmailOff', 1);
                $this->session->set_userdata('pOther', '');
                $this->session->set_userdata('pSold', '');
                $this->session->set_userdata('pOpen', '');
                $this->session->set_userdata('pStatusFilterStatus', '');
                $this->session->set_userdata('pStatusFilterStatusName', 'Email Off');
                break;
            case '2':
                $status = $this->em->find('\models\Status', $statusId);
                $this->session->set_userdata('pWon', 1);
                $this->session->set_userdata('pSold', '');
                $this->session->set_userdata('pOther', '');
                $this->session->set_userdata('pOpen', '');
                $this->session->set_userdata('pStatusFilterStatus', '');
                $this->session->set_userdata('pStatusFilterStatusName',  $status->getText());
                break;    
            default:
                $status = $this->em->find('\models\Status', $statusId);
                $this->session->set_userdata('pSold', '');
                $this->session->set_userdata('pStatusFilterStatus', $statusId);
                $this->session->set_userdata('pStatusFilterStatusName', $status->getText());
                break;
        }

        $filter2 = $this->uri->segment(4);
        $keepUserFilter = false;

        switch ($filter2) {
            case 'user';

                $userId = $this->uri->segment(5);

                if ($userId) {
                    // Apply The filter
                    $user = $this->em->find('\models\Accounts', $userId);
                    $this->session->set_userdata('pStatusFilterUser', $userId);
                    $this->session->set_userdata('pStatusFilterUserName', $user->getFullName());
                    $keepUserFilter = true;
                }
                break;

            case 'branch';

                $branchId = $this->uri->segment(5);

                if ($branchId) {
                    $branch = $this->em->find('models\Branches', $branchId);

                    // Apply The filter
                    $this->session->set_userdata('pStatusFilterBranch', $branchId);
                    $this->session->set_userdata('pStatusFilterBranchName', $branch->getBranchName());
                } else {
                    $this->session->set_userdata('pStatusFilterBranch', '0');
                    $this->session->set_userdata('pStatusFilterBranchName', 'Main');
                }

                break;

            case 'delete-requests':
                if (!$this->account()->isAdministrator(true)) {
                    $this->session->set_flashdata('error', 'You do not have permission to edit this account');
                    redirect('proposals');
                }
                // Get the status
                $deleteStatus = $this->account()->getCompany()->getDefaultStatus(\models\Status::DELETE_REQUEST);
                // Apply to filter
                $this->session->set_userdata('pStatusFilterStatus', $deleteStatus->getStatusId());
                $this->session->set_userdata('pStatusFilterStatusName', $deleteStatus->getText());

                // Remove the date filter so that it doesn't restrict proposal creation dates
                $this->session->set_userdata('pStatusFilterFrom', '');
                $this->session->set_userdata('pStatusFilterTo', '');
                // No user filter
                $this->session->set_userdata('pStatusFilterUser', '');
                // No status change filter
                $this->session->set_userdata('pStatusFilterChangeFrom', '');
                $this->session->set_userdata('pStatusFilterChangeTo', '');

                break;

            default:
                // Reset filters listed above
                if (!$keepUserFilter) {
                    $this->session->set_userdata('pStatusFilterUser', '');
                }
                $this->session->set_userdata('pStatusFilterBranch', '');
                break;
        }

        $filter3 = $this->uri->segment(5);
        $keepUserFilter = false;

        switch ($filter3) {
            case 'user';
                $userId = $this->uri->segment(6);

                if ($userId) {
                    // Apply The filter
                    $user = $this->em->find('\models\Accounts', $userId);
                    $this->session->set_userdata('pStatusFilterUser', $userId);
                    $this->session->set_userdata('pStatusFilterUserName', $user->getFullName());
                    $keepUserFilter = true;
                }
                break;

            case 'branch';
                $branchId = $this->uri->segment(5);

                if ($branchId) {
                    // Apply The filter
                    $branch = $this->em->find('\models\Branches', $branchId);

                    if ($branch) {
                        $this->session->set_userdata('pStatusFilterBranch', $branchId);
                        $this->session->set_userdata('pStatusFilterBranchName', $branch->getBranchName());
                    }
                } else {
                    $this->session->set_userdata('pStatusFilterBranch', '0');
                    $this->session->set_userdata('pStatusFilterBranchName', 'Main');
                }
                break;

            case 'delete-requests':
                if (!$this->account()->isAdministrator(true)) {
                    $this->session->set_flashdata('error', 'You do not have permission to edit this account');
                    redirect('proposals');
                }
                // Get the status
                $deleteStatus = $this->account()->getCompany()->getDefaultStatus(\models\Status::DELETE_REQUEST);
                // Apply to filter
                $this->session->set_userdata('pStatusFilterStatus', $deleteStatus->getStatusId());
                $this->session->set_userdata('pStatusFilterStatusName', $deleteStatus->getText());

                // Remove the date filter so that it doesn't restrict proposal creation dates
                $this->session->set_userdata('pStatusFilterFrom', '');
                $this->session->set_userdata('pStatusFilterTo', '');
                // No user filter
                $this->session->set_userdata('pStatusFilterUser', '');
                // No status change filter
                $this->session->set_userdata('pStatusFilterChangeFrom', '');
                $this->session->set_userdata('pStatusFilterChangeTo', '');

                break;

            default:
                // Reset filters listed above
                //$this->session->set_userdata('pStatusFilterUser', '');
                if ($filter2 != 'branch') {
                    $this->session->set_userdata('pStatusFilterBranch', '');
                }
                break;
        }
        //print_r($this->session->userdata('pStatusFilterFrom'));die;

        $this->index();
    }

    public function resend()
    {
        // Auth checks

        $filter = $this->uri->segment(3);
        $resend_from_status_id = $this->uri->segment(4);
        $resend_to_status_id = $this->uri->segment(5);

        if ($this->session->userdata('pResendFromStatusId') || $resend_from_status_id) {
            $this->session->set_userdata(
                array(
                    'prFilter_' . $filter => '',
                    'prFilterUser_' . $filter => '',
                    'prFilterBranch_' . $filter => '',
                    'prFilterStatus_' . $filter => '',
                    'prFilterEstimateStatus_' . $filter => '',
                    'prFilterJobCostStatus_' . $filter => '',
                    'prFilterService_' . $filter => '',
                    'prFilterFrom_' . $filter => '',
                    'prFilterTo_' . $filter => '',
                    'prFilterQueue_' . $filter => '',
                    'prFilterEmailStatus_' . $filter => '',
                    'prFilterClientAccount_' . $filter => '',
                    'prFilterBusinessType_' . $filter => '',
                    'prFromFilterStatus_' . $filter => '',
                    'prFilterNotesAdded_' . $filter => '',
                )
            );
        }

        $this->session->set_userdata('pResendFilter', 1);

        // Clear any status change filters (will be applied when needed
        $this->session->set_userdata('pStatusRolloverFilter', '');
        $this->session->set_userdata('pStatusFilterUser', '');
        $this->session->set_userdata('pStatusFilterBranch', '');
        $this->session->set_userdata('pSold', '');
        $this->session->set_userdata('pResendFromStatusId', '');
        $this->session->set_userdata('pResendToStatusId', '');
        $this->session->set_userdata('pResendNotesAddedFilter', '');

        if ($resend_from_status_id == 'notes_added') {
            $this->session->set_userdata('pResendNotesAddedFilter', 1);
            $this->session->set_userdata('prFilterNotesAdded_' . $filter, 1);
        } elseif ($resend_from_status_id && $resend_to_status_id) {
            $this->session->set_userdata('pResendFromStatusId', $resend_from_status_id);
            $this->session->set_userdata('pResendToStatusId', $resend_to_status_id);
        }

        $this->session->set_userdata('pResendFilterId', $filter);


        $this->index();
    }

    public function search()
    {
        $this->index();
    }

    public function add()
    {
        $this->load->helper('string');

        $data = array();
        $data['account'] = $this->account();
        if ($this->uri->segment(3)) {
            $client = $this->em->find('models\Clients', $this->uri->segment(3));
            if (!$client) {
                $this->session->set_flashdata('error', 'Client does not exist!');
                redirect('clients');
            }
            $data['client'] = $client;
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('projectName', 'Project Name', 'required');
        $this->form_validation->set_rules('proposalTitle', 'Proposal Title', 'required');
        if ($this->form_validation->run()) {
            // The 'OPEN' status for this company
            $openStatus = $client->getCompany()->getDefaultStatus(\models\Status::OPEN);
            $ownerAccount = $this->em->find('models\Accounts', $this->input->post('owner'));

            $proposal = $this->getProposalRepository()->create($this->account()->getCompany()->getCompanyId());
            $proposal->setProjectAddress($this->input->post('projectAddress'));
            $proposal->setProjectCity($this->input->post('projectCity'));
            $proposal->setProjectState($this->input->post('projectState'));
            $proposal->setProjectZip($this->input->post('projectZip'));
            $proposal->setProjectName($this->input->post('projectName'));
            $proposal->setProposalTitle($this->input->post('proposalTitle'));
            $proposal->setBusinessTypeId($this->input->post('business_type'));
            $proposal->setPaymentTerm($this->account()->getCompany()->getPaymentTerm());
            $proposal->setClient($client);
            $proposal->setProposalStatus($openStatus);
            $proposal->setResendExcluded($client->getResendExcluded());
            $proposal->setEmailStatus(\models\Proposals::EMAIL_UNSENT);
            $proposal->setOwner($ownerAccount);
            $proposal->setActualCreatedDate(date("Y-m-d H:i:s"));
            $proposal->setProposalUuid('');
            $proposal->setCompanyId($this->account()->getCompany()->getCompanyId());
            // Geocode
            $this->getProposalRepository()->setLatLng($proposal);
                 // add a code to handle workorder setting start
                 $workOrderLayout = $this->account()->getCompany()->getWorkOrderSetting();
                 $proposal->setWorkOrderSetting($workOrderLayout);                 
                 $this->em->persist($proposal);
                 $this->em->flush();
                 // add a code to handle workorder setting End 
            
            //set the default texts selected in my account -> custom texts
            $this->load->library('Repositories/CustomtextRepository');
            $proposal->setTextsCategories($this->customtextrepository->getDefaultCategories($this->account()->getCompany()->getCompanyId()));

            // Set the job number if set
            if ($this->account()->getCompany()->getUseAutoNum()) {
                $proposal->setJobNumber($this->account()->getCompany()->getProposalAutoNum());
            }

            //set up the default texts
            $texts = $this->customtexts->getTexts($proposal->getClient()->getCompany()->getCompanyId());
            $txts = '';
            $k = 0;
            foreach ($texts as $textId => $text) {
                $k++;
                if ($text->getChecked() == 'yes') {
                    $txts .= $textId;
                    if ($k < count($texts)) {
                        $txts .= ',';
                    }
                }
            }
            $proposal->setTexts($txts);
            $this->em->persist($proposal);
            $this->em->flush();

            //Create Proposal preview Client Link
            $this->getProposalRepository()->createClientProposalLink($proposal->getProposalId());

            //Copy All default Video
            $this->getProposalRepository()->copyDefaultCompanyVideo($this->account()->getCompany()->getCompanyId(), $proposal->getProposalId());

            //Delete user query Cache
            $this->getQueryCacheRepository()->deleteCompanyHeaderProposalCache($this->account()->getCompanyId());

            $this->getClientRepository()->updateProposalCount($client->getClientId());

            //Check business type assignment in account
            if ($proposal->getBusinessTypeId()) {
                $this->getProposalRepository()->checkNewBusinessTypeProposalAssignment($proposal, $this->input->post('business_type'), $this->account()->getCompany()->getCompanyId());
            }

            //Event Log
            $this->getProposalEventRepository()->createProposal($proposal, $this->account());

            //link the selected attachments to be included automatically
            $this->load->library('Repositories/AttachmentRepository.php');
            $this->attachmentrepository->linkCheckedAttachments(
                $this->account()->getCompany()->getCompanyId(),
                $proposal->getProposalId()
            );

            $this->log_manager->add(\models\ActivityAction::ADD_PROPOSAL, 'Added proposal', $client, $proposal);
            $this->log_manager->add(
                \models\ActivityAction::SET_PROPOSAL_STATUS,
                "Proposal status set to '" . $openStatus->getText() . "'",
                $client,
                $proposal,
                null,
                null,
                null,
                $openStatus->getStatusId()
            );
            //            $this->session->set_flashdata('success', 'Proposal added successfully!');

            if ($client->getAccount()->getAccountId() != $proposal->getOwner()->getAccountId()) {
                // Email the owner of th client if different from the proposal owner
                $emailData = [
                    'clientOwnerFirstName' => $client->getAccount()->getFirstName(),
                    'proposalProjectTitle' => $proposal->getProjectName(),
                    'proposalOwnerFullName' => $proposal->getOwner()->getFullName(),
                    'clientName' => $proposal->getClient()->getFullName(),
                    'accountName' => $proposal->getClient()->getClientAccount() ? $proposal->getClient()->getClientAccount()->getName() : 'Unspecified Account',
                ];
                $this->load->model('system_email');
                $this->system_email->sendEmail(20, $client->getAccount()->getEmail(), $emailData);
            }
            redirect('proposals/edit/' . $proposal->getProposalId() . '/items');
        }
        // Users for owner dropdown. If user, only show self
        if ($this->account()->isUser() && !$this->account()->isSecretary() && !$this->account()->hasFullAccess()) {
            $data['userAccounts'] = [$this->account()];
        } else {
            $data['userAccounts'] = $this->account()->getCompany()->getActiveSortedAccounts();
        }
        $data['businessTypes'] = $this->getCompanyRepository()->getCompanyBusinessTypes($this->account()->getCompany());
        // Default Business Type
        // Start At false
        $data['defaultBusinessTypeId'] = false;
        // Retrieve the types
        $contactBusinessTypes = $this->getCompanyRepository()
            ->getCompanyBusinessTypeAssignments(
                $this->account()->getCompany(),
                'client',
                $client->getClientId(),
                true
            );
        // If only one type, this is the default
        if (count($contactBusinessTypes) === 1) {
            $data['defaultBusinessTypeId'] = $contactBusinessTypes[0];
        }
       
        $this->load->view('proposals/add', $data);
    }

    public function delete()
    {

        $proposalId = $this->uri->segment(3);
        $proposal = $this->em->findProposal($proposalId);

        if ($proposal) {
            $this->load->library('helpers/ProposalHelper', array('account' => $this->account()));
            $this->proposalhelper->setProposal($proposal);

            // Delete if user has permission
            if ($this->account()->hasDeleteProposalPermission()) {
                $this->proposalhelper->delete();
                $this->getClientRepository()->updateProposalCount($proposal->getClient()->getClientId());
            } else {
                // Otherwise request delete
                $this->proposalhelper->requestDelete();
            }
        }
    }

    public function rebuild()
    {
        //hack, so rebuild flag works for adding new items --- doctrine issue
        $proposal = $this->em->find('models\Proposals', $this->uri->segment(3));
        if (!$proposal) {
            $this->session->set_flashdata('error', 'Proposal does not exist!');
            redirect('proposals');
        }
        $proposal->setRebuildFlag(1, false, false);
        $this->em->persist($proposal);
        $this->em->flush();
        redirect('proposals/edit/' . $this->uri->segment(3) . '/items');
    }

    public function edit()
    {
        //check if proposal exists
        // Turn off error reporting
 

        $proposal = $this->em->findProposal($this->uri->segment(3));


        // Work out if we're on a page other than the main edit page for popup purposes
        $additional = $this->uri->segment(4);

        if ($additional == 'items' || !strlen($additional)) {
            $additional = false;
        }

        if (!$proposal) {
            $this->session->set_flashdata('error', 'Proposal does not exist!');
            redirect('proposals');
        } 

        // Make sure proposal has an access code
        if (!$proposal->getAccessKey()) {
            $proposal->setAccessKey();
            $this->em->persist($proposal);
            $this->em->flush();
        }

        // //check if current account can edit proposal
        // if (!$this->account()->isAdministrator() && ($this->account()->getFullAccess() == 'no')) { //check if user is not an admin
        //     //if user is branch manager and the proposal is in a differnet branch
        //     if (($this->account() != $proposal->getClient()->getAccount()) && ($this->account() != $proposal->getOwner()) && ($this->account()->getUserClass() == 1) && ($this->account()->getBranch() != $proposal->getClient()->getAccount()->getBranch())) {
        //         $this->session->set_flashdata('error', 'You do not have enough privileges to edit this proposal!');
        //         redirect('proposals');
        //     }
        // }
        // //check if the proposal is in the same company as the user who is editing
        // if (!$this->account()->isGlobalAdministrator()) {
        //     if ($this->account()->getCompany() != $proposal->getClient()->getCompany()) {
        //         $this->session->set_flashdata('error', 'You do not have enough privileges to edit this proposal!');
        //         redirect('proposals');
        //     }
        // }
        

        if(!$this->account()->hasSendPermission($proposal)){
            if(!$this->getProposalRepository()->getUserProposalPermission($proposal->getProposalId(),$this->account()->getAccountId())){
                $this->session->set_flashdata('error', 'You do not have enough privileges to edit this proposal!');
                redirect('proposals');
            }
        }

        //lock user out if he is not allowed to send proposals and the proposal is in the queue
        if (($this->account()->requiresApproval())
            && ($proposal->inApprovalQueue())
        ) {
            $this->session->set_flashdata(
                'error',
                'Hey There! Your proposal is in the approval process. After approval, you will regain access to the proposal.'
            );
            redirect('proposals');
        }
        if (($proposal->getOwner() == $this->account()) && ($this->account()->isSecretary() && $this->uri->segment(4) == 'send')) { //if owner is a secretary, GTFO Bitch
            $this->session->set_flashdata(
                'error',
                'Oops! Based on your type of account with ' . SITE_NAME . ', you are not able to email proposals. <br><br> Please assign the contact to an authorized user and then you can send the proposal.  If you wish to send proposals, contact your company admin to purchase that option.'
            );
            redirect('proposals/edit/' . $this->uri->segment(3));
        }
        //redirect user to send for approval if he's not allowed to send

        // Do estimate check
        $estimateCheck = $this->getProposalRepository()->okToSend($proposal, $this->account());

        /*
        if ($estimateCheck['error']) {
            $this->session->set_flashdata('error',
                'Cannot send proposal - Estimate has not been completed!');
            redirect('proposals/edit/' . $this->uri->segment(3));
        }
        */

        if ($this->uri->segment(4) == 'send') {
            // Check the user type and that approval is required
            if ($this->account()->requiresApproval()) {
                // Check if we're above the approval limit
                if ($this->account()->getApprovalLimit() <= $proposal->getTotalPrice(true)) {
                    // Has it been approved already
                    if (!$proposal->hasBeenApproved()) {
                        redirect('proposals/sendForApproval/' . $this->uri->segment(3));
                    }
                }
            }
        }
 
        // Handle custom cover image upload
        if ($this->input->post('headerBgColor')) {
            // print_r($this->input->post('gradientOpacity'));die;
            $this->load->library('jobs');
            $opacity = $this->input->post('imageOpacity');
            $pct = floor($opacity * 100);
            $manager = new ImageManager();
            $folder = $proposal->getUploadDir();
            if (!is_dir($folder)) {
                mkdir($folder, 0755, true);
            }

            $originalFileName = $proposal->getUploadDir() . '/cover-orig.png';

            $fileName = $proposal->getUploadDir() . '/cover.png';


            // Save the image original
            if ($this->input->post('select_background_image') == '0') {
                if (!$_FILES['gradientImage']['error']) {
                    $img = $manager->make($_FILES['gradientImage']['tmp_name']);
                    $img->save($originalFileName);
                }
            } else {
                $base_path = STATIC_PATH . '\images\b' . $this->input->post('select_background_image') . '.jpg';

                $img = $manager->make($base_path);
                $img->save($originalFileName);
            }

            // Check to see if we have a proposal image
            if (file_exists($originalFileName)) {
                $theFile = $originalFileName;
            } else {
                // If not, check if there's a company image
                $theFile = UPLOADPATH . '/clients/logos/bg-' . $proposal->getClient()->getCompany()->getCompanyId() . '-orig.png';
            }



            $params = [$proposal->getClient()->getCompany()->getCompanyId(), $proposal->getProposalId(), $this->input->post('imageOpacity')];
            // Save the opaque image
            $this->jobs->create($_ENV['QUEUE_HIGH'], 'jobs', 'proposal_image_process', $params, 'test job');
            // If there's an image, apply opacity
            // if (file_exists($theFile)) {
            //     // Save the opaque image
            //     $img = $manager->make($theFile);
            //     $img->opacity($pct);
            //     $img->save($fileName);
            // }

            $proposal->setGradientOpacity($this->input->post('imageOpacity'));
            $proposal->setHeaderBgColor($this->input->post('headerBgColor'));
            $proposal->setHeaderFontColor($this->input->post('headerFontColor'));
            $proposal->setProposalBackground($this->input->post('background_image'));
            $proposal->setIsShowProposalLogo($this->input->post('is_show_logo'));
            $proposal->setRebuildFlag(1);
            $this->em->persist($proposal);
            $this->em->flush();


            $this->log_manager->add(\models\ActivityAction::EDIT_PROPOSAL, 'Updated Custom Layout');
            $this->session->set_flashdata('success', 'Custom Layout Settings Saved');
            redirect('proposals/edit/' . $this->uri->segment(3) . '/items');
        }


        // Handle deleting custom background
        if ($this->input->post('removeCustomImage')) {
            $proposal->removeCustomImage();
            $this->log_manager->add(\models\ActivityAction::EDIT_PROPOSAL, 'Custom Layout Image Removed!');
            $this->session->set_flashdata('success', 'Custom Layout Image Deleted');
            redirect('proposals/edit/' . $this->uri->segment(3) . '/items');
        }


        // Handle resetting to default
        if ($this->input->post('useCustomDefaults')) {
            // Remove the image
            $proposal->removeCustomImage();
            $proposal->setGradientOpacity(null);
            $proposal->setHeaderBgColor(null);
            $proposal->setHeaderFontColor(null);
            $this->em->persist($proposal);
            $this->em->flush();
            $this->log_manager->add(\models\ActivityAction::EDIT_PROPOSAL, 'Custom Layout Settings Set to Default');
            $this->session->set_flashdata('success', 'Custom Layout Settings Saved');
            redirect('proposals/edit/' . $this->uri->segment(3) . '/items');
        }


        //preselect page
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 'items';
        if (($page == 'addAttatchment') || ($page == 'removeAttatchment')) {
            $attachment = $this->em->find('models\Attatchments', $this->uri->segment(5));
            if ($attachment) {
                $proposal->$page($attachment);
                //create a history log for attachment add or remove start
                   $attachmentName = $attachment->getFileName();
                   $attachmentAddRemove = ($page=="addAttatchment") ? "add": "remove";
                    $this->getLogRepository()->add([
                        'action' => \models\ActivityAction::UPDATE_PROPOSAL_SETTING,
                        'details' => "$attachmentName Attachment is $attachmentAddRemove for Proposal",
                        'proposal' => $proposal->getProposalId(),
                        'account' => $this->account()->getAccountId(),
                        'company' => $this->account()->getCompanyId(),
                    ]);
                //create a history log for attchement add or remove end 

                $proposal->setRebuildFlag(1);
                $this->em->persist($proposal);
                $this->em->flush();
            }
            $page = 'items';
            return;
        }
        //get items
        $query = $this->em->createQuery('SELECT i FROM models\Items i order by i.ord');
        $items = $query->getResult();
        //get images
        $query = $this->em->createQuery('SELECT i FROM models\Proposals_images i  where i.proposal=' . $this->uri->segment(3) . ' AND i.map = 0 AND i.proposal_service_id IS NULL order by i.ord');
        $images = $query->getResult();

        //get Map images
        $query = $this->em->createQuery('SELECT i FROM models\Proposals_images i  where i.proposal=' . $this->uri->segment(3) . ' AND i.map = 1 AND i.proposal_service_id IS NULL order by i.ord');
        $mapImages = $query->getResult();

        //get Map Services
        $mapServices = $this->db->query('SELECT GROUP_CONCAT(i.proposal_service_id) as service_ids FROM proposals_images i  where i.proposal=' . $this->uri->segment(3) . ' AND i.map = 1 AND i.proposal_service_id IS NOT NULL order by i.ord')->result();
        if($mapServices[0]){
            $mapServicesIds = explode(',',$mapServices[0]->service_ids);
        }else{
            $mapServicesIds = array();
        }

        // Get attached files
        $proposal_attachments = $proposal->getAttachedFiles();
        //load form validation
        $this->load->library('form_validation');
        //magic starts here
        switch ($page) {
            case 'basic_info':
                $this->form_validation->set_rules('projectName', 'Project Name', 'required');
                //                $this->form_validation->set_rules('projectAddress', 'Project Address', 'required');
                if ($this->form_validation->run()) {
                    //update proposal's basic info
                    $proposal->setProjectName($this->input->post('projectName'));
                    $proposal->setProposalTitle($this->input->post('proposalTitle'));
                    $proposal->setProjectAddress($this->input->post('projectAddress'));
                    $proposal->setProjectCity($this->input->post('projectCity'));
                    $proposal->setProjectState($this->input->post('projectState'));
                    $proposal->setProjectZip($this->input->post('projectZip'));
                    $proposal->setJobNumber($this->input->post('jobNumber'));
                    $proposal->setRebuildFlag(1);
                    $proposal = $this->em->merge($proposal);
                    $this->em->persist($proposal);
                    $this->em->flush();

                    // Geocode it
                    $this->getProposalRepository()->setLatLng($proposal);

                    $this->log_manager->add(
                        \models\ActivityAction::EDIT_PROPOSAL,
                        'Updated project info.',
                        $proposal->getClient(),
                        $proposal
                    );
                    $this->em->detach($proposal);
                    $this->session->set_flashdata('success', 'Proposal Info Updated');
                    redirect('proposals/edit/' . $proposal->getProposalId());
                }
                break;
            case 'items':
                //if you are here and you want to debug or add something, i am sorry for you.
                /////////////////////////////////////well comented line
                //add a code to handle workorder setting
                //  $companyLayout=$proposal->getWorkOrderSetting();
                //  $proposal->setWorkOrderSetting($companyLayout);
                // $this->em->persist($proposal);
                // $this->em->flush();
                //add a code to handle workorder setting

                $attatchedFiles = array();
                $attatchements = $proposal->getAttatchments();
                foreach ($attatchements as $att) {
                    $attatchedFiles[] = $att->getAttatchmentId();
                }
                $data['attatchedFiles'] = $attatchedFiles;
                if ($this->uri->segment(5) == 'delete') {
                    $item = $this->em->find('models\Proposals_items', $this->uri->segment(6));
                    $proposal = $item->getProposal();
                    $this->log_manager->add(
                        \models\ActivityAction::DELETE_PROPOSAL_SERVICE,
                        'Deleted ' . $item->getItem()->getItemName() . '" to the proposal.',
                        $proposal->getClient(),
                        $proposal
                    );
                    $item = $this->em->merge($item);
                    $this->em->remove($item);
                    $proposal->setRebuildFlag(1);
                    $proposal = $this->em->merge($proposal);
                    $this->em->persist($proposal);
                    $this->em->flush();
                    $this->em->clear();
                    redirect('proposals/edit/' . $this->uri->segment(3));
                }
                if ($this->input->post('action') == 'add_item') {
                    $item = $this->em->find('models\Items', $this->input->post('itemId'));
                    $fields = $item->getFields();
                    foreach ($fields as $field) {
                        if ($field->getfieldLabel() != 'area') {
                            $this->form_validation->set_rules(
                                $field->getFieldLabel(),
                                $field->getFieldName(),
                                'required'
                            );
                        }
                    }
                    if ($this->form_validation->run()) {
                        $proposal_item = new models\Proposals_items();
                        $proposal_item->setItem($item);
                        $proposal_item->setProposal($proposal);
                        $proposal_item->setOrder(100);
                        $this->em->persist($proposal_item);
                        $this->em->flush();
                        $this->load->database();
                        if ($this->input->post('itemId') == 1) {
                            $this->db->query("update calculators_values set itemId=" . $proposal_item->getLinkId() . ' where itemId=' . $this->input->post('calculatorRequestToken'));
                        }
                        //                        mail('chris@rapidinjection.com', 'Testing calculator stuff debug', "update calculators_values set itemId=" . $proposal_item->getLinkId() . ' where itemId=' . $this->input->post('calculatorRequestToken'));
                        $fields = $item->getFields();
                        $fieldObjects = array();
                        foreach ($fields as $field) {
                            $fieldObj = new models\Fields_values();
                            $fieldObj->setField($field);
                            $fieldObj->setProposalItem($proposal_item);
                            $fieldObj->setFieldValue($this->input->post($field->getFieldLabel()));
                            $fieldObjects[] = $fieldObj;
                        }
                        foreach ($fieldObjects as $key => $fieldObj) {
                            $this->em->persist($fieldObjects[$key]);
                        }

                        $this->em->flush();
                        $this->session->set_flashdata('activeItem', $item->getItemId());
                        $this->log_manager->add(
                            \models\ActivityAction::ADD_PROPOSAL_SERVICE,
                            'Added "' . $item->getItemName() . '" to the proposal.',
                            $proposal->getClient(),
                            $proposal
                        );
                        //                        $this->session->set_flashdata('success', 'Item Added Successfully to the database!');
                        //                        redirect('proposals/edit/' . $this->uri->segment(3) . '/' . $this->uri->segment(4));
                        redirect('proposals/rebuild/' . $this->uri->segment(3));
                    }
                }

                if ($this->input->post('action') == 'edit_item') {

                    ob_implicit_flush(true);
                    $proposal_item = $this->em->find('models\Proposals_items', $this->input->post('linkId'));
                    $field_values = $proposal_item->getFieldsValues();
                    foreach ($field_values as $fv) {
                        $field = $fv->getField();
                        if ($field->getfieldLabel() != 'area') {
                            $this->form_validation->set_rules(
                                $field->getFieldLabel(),
                                $field->getFieldName(),
                                'required'
                            );
                        }
                    }
                    if ($this->form_validation->run()) {
                        foreach ($field_values as $key => $fv) {
                            $field_values[$key]->setFieldValue($this->input->post($fv->getField()->getFieldLabel()));
                            $this->em->persist($field_values[$key]);
                        }
                        $proposal->setRebuildFlag(1);
                        $proposal = $this->em->merge($proposal);
                        $this->em->persist($proposal);
                        $this->em->flush();
                        //                    $this->session->set_flashdata('success', 'Item updated succesfully!');
                        $this->log_manager->add(
                            'proposal_add_item',
                            'Edited "' . $proposal_item->getItem()->getItemName() . '" within the proposal.',
                            $proposal->getClient(),
                            $proposal
                        );
                        $this->session->set_flashdata('activeSelectedItem', $proposal_item->getLinkId());
                        redirect('proposals/edit/' . $this->uri->segment(3) . '/' . $this->uri->segment(4));
                    }
                }
                if ($this->input->post('action') == 'updatePaymentTerm') {
                    if ((is_numeric($this->input->post('paymentTerm'))) && (is_int($this->input->post('paymentTerm') + 0)) && ($this->input->post('paymentTerm') >= 0)) {
                        $proposal->setPaymentTerm($this->input->post('paymentTerm'));
                        $proposal->setRebuildFlag(1);
                        $this->em->persist($proposal);
                        $this->em->flush();
                        $this->session->set_flashdata('success', 'Payment Term updated succesfully!');
                        redirect('proposals/edit/' . $this->uri->segment(3) . '/' . $this->uri->segment(4));
                    } else {
                        $this->session->set_flashdata('error', 'The value selected must be an number!');
                        redirect('proposals/edit/' . $this->uri->segment(3) . '/' . $this->uri->segment(4));
                    }
                }

                // Update Win Date
                if ($this->input->post('action') == 'updateWinDate') {
                    try {
                        $this->getProposalRepository()->updateWinDate(
                            $proposal,
                            $this->input->post('proposalSettingWinDate'),
                            $this->account()
                        );
                        $this->session->set_flashdata('success', 'Proposal Win Date updated');
                        redirect('proposals/edit/' . $this->uri->segment(3) . '/' . $this->uri->segment(4));
                    } catch (\Exception $e) {
                        $this->session->set_flashdata('error', 'There was a problem saving the date change');
                        redirect('proposals/edit/' . $this->uri->segment(3) . '/' . $this->uri->segment(4));
                    }
                }

                if ($this->input->post('addAudit')) {
                    $parsed = parse_url($this->input->post('auditLinkUrl'));
                    $path = $parsed['path'];
                    if ($path) {
                        $paths = explode('/', $path);
                        if (isset($paths[2])) {
                            $proposal->setAuditKey($paths[2]);
                            $proposal->setRebuildFlag(1);
                            $this->em->persist($proposal);
                            $this->em->flush();
                            //$this->log_manager->add(\models\ActivityAction::PROPOSAL_AUDIT_ADD, 'Proposal Audit Added');
                            $this->getLogRepository()->add([
                                'action' => \models\ActivityAction::PROPOSAL_AUDIT_ADD,
                                'details' => "Proposal Audit Added",
                                'proposal' => $proposal->getProposalId(),
                                'account' => $this->account()->getAccountId(),
                                'company' => $this->account()->getCompanyId(),
                            ]);
                            $this->session->set_flashdata('success', 'Proposal Audit Linked');
                            redirect('proposals/edit/' . $this->uri->segment(3) . '/' . $this->uri->segment(4));
                        }
                    }
                }


                if ($this->input->post('removeAudit')) {
                    $proposal->setAuditKey(null);
                    $proposal->setAuditViewTime(null);
                    $proposal->setRebuildFlag(1);
                    $this->em->persist($proposal);
                    $this->em->flush();
                    $this->log_manager->add(\models\ActivityAction::PROPOSAL_AUDIT_REMOVED, 'Proposal Audit Removed');
                    $this->session->set_flashdata('success', 'Proposal Audit Removed');
                    redirect('proposals/edit/' . $this->uri->segment(3) . '/' . $this->uri->segment(4));
                }

                if ($this->input->post('addInventory')) {
                    $proposal->setInventoryReportUrl($this->input->post('inventoryLinkUrl'));
                    $proposal->setRebuildFlag(1);
                    $this->em->persist($proposal);
                    $this->em->flush();
                    $this->log_manager->add(\models\ActivityAction::PROPOSAL_AUDIT_ADD, 'Proposal Inventory Linked');
                    $this->session->set_flashdata('success', 'Proposal Inventory Linked');
                    redirect('proposals/edit/' . $this->uri->segment(3) . '/' . $this->uri->segment(4));
                }
                if ($this->input->post('removeInventory')) {
                    $proposal->setInventoryReportUrl(null);
                    $proposal->setRebuildFlag(1);
                    $this->em->persist($proposal);
                    $this->em->flush();
                    $this->log_manager->add(\models\ActivityAction::PROPOSAL_AUDIT_REMOVED, 'Proposal Inventory Link Removed');
                    $this->session->set_flashdata('success', 'Proposal Inventory Removed');
                    redirect('proposals/edit/' . $this->uri->segment(3) . '/' . $this->uri->segment(4));
                }


                break;
            case 'preview':
                break;
            case 'approve':
                $this->getProposalRepository()->approve($proposal);
                $proposal->setUnapprovedServices(0);
                $proposal->setApprovalQueue(0);
                $proposal->setApproved(1);
                $this->em->persist($proposal);
                $this->em->flush();

                $this->getProposalRepository()->sendProposalApprovedEmail($this->account(), $proposal);
                $this->log_manager->add(
                    \models\ActivityAction::PROPOSAL_APPROVAL_QUEUE,
                    'Proposal Approved By: ' . $this->account()->getFirstName() . ' ' . $this->account()->getLastName(),
                    $proposal->getClient(),
                    $proposal
                );
                $this->session->set_flashdata('success', 'Proposal Approved');

                redirect('proposals');
                break;
            case 'send':
                if ($this->input->post('send_email')) {
                    $mails = array();
                    /*
                    if ($this->account() != $proposal->getClient()->getAccount()) {
                    $mails[] = $this->account()->getEmail();
                    }
                    */
                    $additional_mails = explode(",", trim($_POST['to']));
                    foreach ($additional_mails as $mail) {
                        if ($mail) {
                            $mails[] = $mail;
                        }
                    }
                    //bcc
                    $bccs = explode(',', trim($_POST['bcc']));
                    foreach ($bccs as $bcc) {
                        if ($bcc) {
                            $mails[] = $bcc;
                        }
                    }

                    $emailData = [
                        'fromName' => $proposal->getOwner()->getFullName() . ' via ' . SITE_NAME,
                        'fromEmail' => 'proposals@' . SITE_EMAIL_DOMAIN,
                        'subject' => $this->input->post('subject') ?: 'Proposal for ' . $proposal->getProjectName(),
                        'body' => $this->input->post('message'),
                        'replyTo' => $proposal->getOwner()->getEmail(),
                        'bcc' => $mails,
                        'emailCC' => true, //this is to reflect the checkbox in group actions
                        'emailClient' => false, //to not automatically email client
                    ];


                    $this->getProposalRepository()->individualSend($proposal->getProposalId(), $emailData, $this->account());

                    $this->getProposalEventRepository()->createEmailEvent('Proposal', $proposal->getProposalId(), $this->account(), $_POST['to'], $this->input->post('message'), $this->input->post('subject'), '1', $emailData['fromName'], $emailData['fromEmail']);

                    //Event Log
                    //$this->getProposalEventRepository()->sendProposalIndividual($proposal,$this->account());

                    //approve proposal if in approval Queue
                    if ($proposal->inApprovalQueue()) {
                        $proposal->setApprovalQueue(0);
                        $proposal->setUnapprovedServices(0);
                        $proposal->setApproved(1);
                        $this->getProposalRepository()->approve($proposal);
                        $this->em->persist($proposal);
                        $this->em->flush();
                        $this->load->model('system_email');
                        $emailData = array(
                            'firstName' => $this->account()->getFirstName(),
                            'lastName' => $this->account()->getLastName(),
                            'userFirstName' => $proposal->getClient()->getAccount()->getFirstName(),
                            'userLastName' => $proposal->getClient()->getAccount()->getLastName(),
                            'projectName' => $proposal->getProjectName(),
                        );
                        $this->system_email->sendEmail(13, $proposal->getOwner()->getEmail(), $emailData);
                        $this->log_manager->add(
                            \models\ActivityAction::PROPOSAL_EMAIL_SEND,
                            'Proposal Approved & Sent By: ' . $this->account()->getFirstName() . ' ' . $this->account()->getLastName(),
                            $proposal->getClient(),
                            $proposal
                        );
                        $this->log_manager->add(
                            \models\ActivityAction::PROPOSAL_EMAIL_SEND,
                            'Proposal Sent to: ' . str_replace(',', ', ', $this->input->post('to')),
                            $proposal->getClient(),
                            $proposal
                        );
                    }
                    $this->session->set_flashdata(
                        'success',
                        'Emails sent succesfully! A copy has been sent to your email address as well!'
                    );
                    redirect('proposals/edit/' . $this->uri->segment(3) . '/items');
                }
                break;
        }

        $this->load->library('user_agent');
        $proposalLinkRepository = new \Pms\Repositories\ProposalLinks();
        $data['is_ie'] = ($this->agent->is_browser('MSIE') || $this->agent->is_browser('Internet Explorer'));
        $data['items'] = $items;
        $data['images'] = $images;
        $data['mapImages'] = $mapImages;
        $data['mapServicesIds'] = $mapServicesIds;
        $data['proposal'] = $proposal;
        $data['additional'] = $additional;
        $data['resend_frequencies'] = $this->system_setting('proposal_resend_frequencies');
        $this->load->model('clientEmail');
        $data['proposal_email_templates'] = $this->clientEmail->getTemplates(
            $this->account()->getCompany()->getCompanyId(),
            1,
            true
        );
        $data['proposalLinks'] = $proposalLinkRepository->getProposalLinks(
            $this->uri->segment(3),
            $this->account()->getCompany()->getCompanyId()
        );
        $data['proposal_attachments'] = $proposal_attachments;
        $data['account'] = $this->account();
        $query = $this->em->createQuery('SELECT p FROM models\Proposals_items p where p.proposal=' . $proposal->getProposalId() . ' order by p.ord');
        $data['proposalItems'] = $query->getResult();
        $data['disabledServices'] = $this->account()->getCompany()->getDisabledServices();
        $data['automatic_reminders_enabled'] = $this->getProposalNotificationsRepository()->getProposalResendSettings($this->account()->getCompany()->getCompanyId())->enabled;
        $data['page'] = $page;
        $data['enableProposalImages'] = 1;


        //customtexts
        /**
         *
         *
         * @var \models\Companies $company
         */
        $company = $this->account()->getCompany()->getCompanyId();
        $cats = $this->customtexts->getCategories($company);
        $orderedcats = $proposal->getTextsCategories();
        $categories = array();
        foreach ($cats as $cat) {
            $categories[$cat->getCategoryId()] = $cat;
        }
        $categories_final = array();
        foreach ($orderedcats as $catId => $on) {
            if (isset($categories[$catId])) {
                $categories_final[$catId] = $categories[$catId];
                unset($categories[$catId]);
            }
        }
 
        foreach ($categories as $catId => $cat) {
            $categories_final[$catId] = $cat;
        }
        $data['orderedcats'] = $orderedcats;
        $data['texts_categories'] = $categories_final;
        $data['texts'] = $this->customtexts->getTexts($company);
        //   !!!!   New Services Stuff   !!!!   \\
        $data['services'] = $this->account()->getCompany()->getAllEnabledServices();
        $data['service_titles'] = $this->account()->getCompany()->getServiceTitles();
        $categories = $this->account()->getCompany()->getCategories();
        $data['categories_count'] = count($categories);
        $proposalServices = $this->em->createQuery('select ps from models\Proposal_services ps where ps.proposal=' . $proposal->getProposalId() . ' order by ps.ord, ps.serviceId')->getResult();
          $data['proposal_services'] = $proposalServices;
        $data['estimatedProposalServices'] = [];
        $data['estimatesInProgress'] = [];

        foreach ($proposalServices as $proposalService) {
            
            // echo "<pre>proposalService";
            // print_r($proposalService);
            // die;

            $estimate = $this->getEstimationRepository()->getProposalServiceEstimate($proposalService);

            
        

            if ($estimate->getCompleted()) {
                $data['estimatedProposalServices'][] = $proposalService->getServiceId();
            } else {
                $numEstimatedServices = $this->getEstimationRepository()->getProposalServiceLineItemsCount($proposalService->getServiceId());
                if ($numEstimatedServices > 0) {
                    $data['estimatesInProgress'][] = $proposalService->getServiceId();
                }
            }
        }
 
        //Delete user query Cache
 
        $this->getQueryCacheRepository()->deleteCompanyHeaderProposalCache($this->account()->getCompanyId());

        $data['events'] = $this->getEventRepository()->getProposalEvents($proposal->getProposalId());
        $data['filterAccounts'] = $this->getAccountRepository()->getAllAccountsByPermission(
            $this->account()->getAccountId(),
            true
        );
        //        $this->html->addScript('fancybox');
        $this->html->addJS(site_url('3rdparty/jquery.scrollTo-1.4.2-min.js'));
        $this->html->addScript('ckeditor4');
        $this->html->addScript('colorpicker');
        $this->html->addScript('dataTables');
        $this->html->addScript('scheduler');
        $this->html->addScript('select2');
        $this->html->addScript('proposalTracking');
        
        // Email Recipients
        $workOrderRecipients = $this->em->createQuery('select r from models\Work_order_recipients r where r.company=' . $this->account()->getCompany()->getCompanyId() . ' order by r.name')->getResult();
        $data['workOrderRecipients'] = $workOrderRecipients;
        $queryData = array(
            $this->account()->getBranch(),
            $this->account()->getCompany()->getAdministrator()->getAccountId(),
            $this->account()->getCompany()->getCompanyId(),
            $this->account()->getAccountId()
        );
        $recipients = $this->db->query(
            'select * from accounts where ((userClass > 1) or (userClass=1 and branch=?) or (accountId=?)) and (company=?) and (accountId!=?) ',
            $queryData
        )->result();
        $data['recipients'] = $recipients;


        // Proposal Statuses
        $data['statuses'] = $this->account()->getStatuses(true);
        // Proposal Templates
        $this->load->model('clientEmail');
    
        $defaultTemplate = $this->clientEmail->getDefaultTemplate(
            $this->account()->getCompany()->getCompanyId(),
            \models\ClientEmailTemplateType::PROPOSAL
        );
        $data['defaultTemplate'] = $defaultTemplate;
        $this->load->library('EmailTemplateParser');
        $ctp = new EmailTemplateParser();
        $ctp->setProposal($proposal);
 
      
        $data['defaultSubject'] = $ctp->parse($defaultTemplate->getTemplateSubject());
        $data['defaultBody'] = $ctp->parse($defaultTemplate->getTemplateBody());
         $data['clientTemplates'] = $this->clientEmail->getTemplates(
            $this->account()->getCompany()->getCompanyId(),
            \models\ClientEmailTemplateType::PROPOSAL,
            true
        );
        if ($proposal->getDuplicateOf()) {
            $data['duplicate'] = $this->em->find('\models\Proposals', $proposal->getDuplicateOf());
        } else {
            $data['duplicate'] = false;
        }
        $data['web_layouts'] = $this->account()->getCompany()->getWebLayouts();
        $data['proposal_videos'] = $this->getProposalRepository()->getProposalVideos($proposal->getProposalId());
        $data['company_videos'] = $this->getCompanyRepository()->getCompanyVideos($this->account()->getCompany()->getCompanyId());
        $data['layoutOption'] = $proposal->getLayout();
        $data['workOrderOption']=$proposal->getWorkOrderSetting();
        $data['optionDigit'] = '';
        $data['optionDigit'] = substr($proposal->getLayout(), -1);
        if (is_numeric(substr($proposal->getLayout(), -1))) {
             $data['layoutOption'] = substr($proposal->getLayout(), 0, -1);
            $data['optionDigit'] = substr($proposal->getLayout(), -1);
        }
        if (new_system($proposal->getCreated(false))) {
            $data['layouts'] = $this->account()->getCompany()->getLayouts();
            $data['theLayout'] = $proposal->getOwner()->getLayout();
            //for get all work order option 
            $data['allWorkOrder'] = $this->account()->getCompany()->getAllWorkOrderSetting();

        } else {
            $data['layouts'] = $this->system_setting('proposal_old_layouts');
            $data['theLayout'] = 'html_1';
        }

           $section_layout_id = 1;

        if($data['layoutOption'] == 'standard'){
            $section_layout_id = 2;
        }else if($data['layoutOption'] == 'gradient'){
            $section_layout_id = 3;
        } 


        $data['proposal_events'] = $this->getProposalRepository()->getProposalEvents($proposal->getProposalId());
        $data['user_permissions'] = $this->getProposalRepository()->getProposalUserPermissions($proposal->getProposalId());
        $data['proposal_event_types'] = $this->getProposalRepository()->getProposalEventTypes();
        $data['userAccounts'] = $this->account()->getCompany()->getActiveSortedAccounts();
        $data['permissionUserAccounts'] = $this->account()->getCompany()->getActiveSortedUsersAndBranchAdminAccounts();
        $data['web_layout_enable'] = $this->account()->getCompany()->getCompanySettings()->getWebLayout();
        $data['proposalPreviewUrl'] =  $this->getProposalRepository()->getDefaultProposalLink($proposal->getProposalId());
        $data['proposalCoolSections'] = $this->getCompanyRepository()->getIndividualProposalSections($proposal,$section_layout_id);
        
        // Signees
        $data['clientSignee'] = $this->getProposalRepository()->getClientSignee($proposal) ?: new \models\ProposalSignee();
        $data['companySignee'] = $this->getProposalRepository()->getCompanySignee($proposal) ?: new \models\ProposalSignee();

        $this->load->view('proposals/edit', $data);
    }

    public function saveResendSettings($proposalId)
    {
        $proposal = $this->em->findProposal($proposalId);
        $frequency = (($this->input->post('frequency') * 86400) >= 86400) ? round($this->input->post('frequency') * 86400) : 86400;
        $this->setProposalResendSettings(
            $proposalId,
            $this->input->post('enabled'),
            $frequency,
            $this->input->post('template')
        );
        $this->log_manager->add(
            'proposal_resend_settings',
            'Proposal resend settings changed',
            $proposal->getClient(),
            $proposal
        );
    }

    private function setProposalResendSettings($proposalId, $enabled, $frequency, $template)
    {
        /**
         *
         *
         * @var $proposal \models\Proposals
         */
        $proposal = $this->em->find('models\Proposals', $proposalId);
        $proposal->setResendFrequency($frequency);
        $proposal->setResendTemplate($template);
        $proposal->setResendEnabled($enabled);
        $this->em->persist($proposal);
        $this->em->flush();
    }

    public function saveResendSettingsGroup()
    {
        $frequency = (($this->input->post('frequency') * 86400) >= 86400) ? round($this->input->post('frequency') * 86400) : 86400;
        if (is_array($this->input->post('ids'))) {
            foreach ($this->input->post('ids') as $proposalId) {
                $this->setProposalResendSettings(
                    $proposalId,
                    $this->input->post('enabled'),
                    $frequency,
                    $this->input->post('template')
                );
                $proposal = $this->em->findProposal($proposalId);
                $this->log_manager->add(
                    'proposal_resend_settings',
                    'Proposal resend settings changed [Group Action]',
                    $proposal->getClient(),
                    $proposal
                );
            }
        }
    }

    public function delete_proposal_attachment($id, $proposalId)
    {
        $attachment = $this->em->find('\models\Proposal_attachments', $id);
        if ($attachment) {
            $this->em->remove($attachment);
            $this->em->flush();
            $this->session->set_flashdata('success', 'Proposal attachment deleted!');
        } else {
            $this->session->set_flashdata('error', 'Proposal attachment not found!');
        }
        redirect('proposals/edit/' . $proposalId);
    }

    public function activity()
    {
        //check if proposal exists
        $proposal = $this->em->find('models\Proposals', $this->uri->segment(3));
        if (!$proposal) {
            $this->session->set_flashdata('error', 'Proposal does not exist!');
            redirect('proposals');
        }
        //check if current account can edit
        if (!$this->account()->isAdministrator() && ($this->account()->getFullAccess() == 'no')) {
            if ($this->account() != $proposal->getClient()->getAccount()) {
                $this->session->set_flashdata('error', 'You do not have enough privileges to edit this proposal!');
                redirect('proposals');
            }
        }
        $data = array();

        $companyId = $this->account()->getCompany()->getCompanyId();
        $q = "SELECT log.timeAdded, log.userName, log.ip, log.client, log.account, log.proposal, log.details, log.logId,
        accounts.firstName as accountFirstName, accounts.lastName as accountLastName,
        proposals.projectName
        FROM log
        left join accounts on log.account = accounts.accountId
        left join proposals on log.proposal = proposals.proposalId
        where log.proposal = " . $this->uri->segment(3) . "
        order by log.timeAdded DESC";

        $this->load->database();
        $logs = $this->db->query($q)->result();

        $data['proposal'] = $proposal;
        $data['logs'] = $logs;
        $this->html->addScript('dataTables');
        $this->load->view('proposals/activity', $data);
    }

    public function sendForApproval($proposalId)
    {
        //print_r($_POST);die;
        //check if proposal exists
        $proposal = $this->em->find('models\Proposals', $this->uri->segment(3));
        if (!$proposal) {
            $this->session->set_flashdata('error', 'Proposal does not exist!');
            redirect('proposals');
        }
        //check post data
        if ($this->input->post('send')) {
            $recipients = (is_array($this->input->post('recipients'))) ? $this->input->post('recipients') : array();
            if (!count($recipients)) {
                $this->session->set_flashdata('error', 'You must choose one or more people from the list!');
                redirect('proposals/sendForApproval/' . $proposalId);
            } else {
                //this is where the magic's at!
                //send emails
                $this->load->model('system_email');
                $emailData = array(
                    'firstName' => '',
                    'lastName' => '',
                    'userFirstName' => $proposal->getClient()->getAccount()->getFirstName(),
                    'userLastName' => $proposal->getClient()->getAccount()->getLastName(),
                    'projectName' => $proposal->getProjectName(),
                    'projectEditLink' => '<a href="' . site_url('proposals/edit/' . $proposalId) . '">' . $proposal->getProjectName() . '</a>',
                );
                $names = '';
                $recipientCount = 0;
                foreach ($recipients as $recipient => $email) {
                    $user = $this->em->find('models\Accounts', $recipient);
                    if ($user) {
                        if ($recipientCount > 0) {
                            $names .= ', ';
                        }
                        $names .= $user->getFirstName() . ' ' . $user->getLastName();
                        $recipientCount++;
                        //mail
                        $emailData['firstName'] = $user->getFirstName();
                        $emailData['lastName'] = $user->getLastName();
                        $emailData['message'] = nl2br($this->input->post('message'));
                        $this->system_email->sendEmail(12, $email, $emailData);
                    }
                }
                //flag proposal
                $proposal->setApprovalQueue(1);
                $this->em->persist($proposal);
                $this->em->flush();
                //add history item
                $this->log_manager->add(
                    \models\ActivityAction::PROPOSAL_APPROVAL_QUEUE,
                    'Proposal approval sent to ' . $names . '.',
                    $proposal->getClient(),
                    $proposal
                );
                //redirect
                $this->session->set_flashdata(
                    'success',
                    'The proposal has been sent for approval and the selected people were notified. <br><br> You will receive an email when it is either approved or declined.'
                );
                redirect('proposals');
            }
        }
        //load page
        $data = array();
        $this->load->database();
        $queryData = array(
            $this->account()->getBranch(),
            $this->account()->getCompany()->getAdministrator()->getAccountId(),
            $this->account()->getCompany()->getCompanyId()
        );
        $recipients = $this->db->query(
            'select * from accounts where ((userClass > 1) or (userClass=1 and branch=?) or (accountId=?)) and (company=?)',
            $queryData
        )->result();
        $data['recipients'] = $recipients;
        $this->load->view('proposals/sendForApproval', $data);
    }

    public function declineProposal($proposalId)
    {
        //check if proposal exists
        $proposal = $this->em->find('models\Proposals', $this->uri->segment(3));
        if (!$proposal) {
            $this->session->set_flashdata('error', 'Proposal does not exist!');
            redirect('proposals');
        }
        if ($this->input->post('send')) {
            $proposal->setApprovalQueue(0);
            $proposal->setDeclined(1);
            $this->em->persist($proposal);
            $this->em->flush();
            $this->load->model('system_email');
            $emailData = array(
                'firstName' => $this->account()->getFirstName(),
                'lastName' => $this->account()->getLastName(),
                'userFirstName' => $proposal->getClient()->getAccount()->getFirstName(),
                'userLastName' => $proposal->getClient()->getAccount()->getLastName(),
                'projectName' => $proposal->getProjectName(),
                'reason' => nl2br($this->input->post('reason')),
            );
            $this->system_email->sendEmail(14, $proposal->getClient()->getAccount()->getEmail(), $emailData);
            $this->log_manager->add(
                'send_email',
                'Proposal Declined By: ' . $this->account()->getFirstName() . ' ' . $this->account()->getLastName(),
                $proposal->getClient(),
                $proposal
            );
            $this->session->set_flashdata('error', 'Proposal Declined!');
            redirect('proposals');
        }
        $data = array();
        $data['proposal'] = $proposal;
        $this->load->view('proposals/declineProposal', $data);
    }

    public function clientProposals()
    {

        $clientId = $this->uri->segment(3);
        $client = $this->em->findClient($clientId);

        // Check the client loaded
        if (!$client) {
            $this->session->set_flashdata('error', 'Client could not be found!');
            redirect('clients');
        }

        // Check that the client belongs to this company
        if ($client->getCompany()->getCompanyId() != $this->account()->getCompany()->getCompanyId()) {
            $this->session->set_flashdata('error', 'You do not have permission to view those client details!');
            redirect('clients');
        }

        $this->index();
    }

    public function resetFilter($redir = 0)
    {
        $this->session->set_userdata(
            array(
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
            )
        );
        if ($redir) {
            redirect('proposals');
        }
    }

    public function send_work_order()
    {
        $proposal = $this->em->find('models\Proposals', $this->uri->segment(3));
        if (!$proposal) {
            $this->session->set_flashdata('error', 'Proposal not found!');
            redirect('proposals');
        }
        $recipients = ($this->input->post('recipients')) ? $this->input->post('recipients') : array();
        $mails = array_merge($recipients, explode(',', str_replace(' ', '', $this->input->post('additional_emails'))));

        foreach ($mails as $id => $email) {
            if (!$email) {
                unset($mails[$id]);
            }
        }
        $to = $proposal->getProjectAddress();
        if ($proposal->getProjectCity()) {
            $to .= ', ' . $proposal->getProjectCity();
        }
        if ($proposal->getProjectState()) {
            $to .= ', ' . $proposal->getProjectState();
        }
        if ($proposal->getProjectZip()) {
            $to .= ', ' . $proposal->getProjectZip();
        }
        $to = urlencode(trim(str_replace(',', ' ', $to)));

        if (count($mails)) {
            $subject = 'Work order for ' . $proposal->getClient()->getClientAccount()->getName() . ' | ' . $proposal->getProjectName();
            $message = '
            <p>Hello!</p>
            <p><a style="border-radius: 5px;padding: 5px;color: #fff;background: #25AAE1;text-decoration: none;" href="https://maps.google.com/maps?q=' . $to . '">Click here for directions using google maps.</a></p>
            <p><a style="border-radius: 5px;padding: 5px;color: #fff;background: #25AAE1;text-decoration: none;" href="' . site_url('proposals/live/view/work_order/' . $proposal->getAccessKey() . '.pdf') . '">Click here for Work Order PDF.</a></p>
            <p>Please do not reply to this email. It is an automated message sent out from ' . SITE_NAME . '.</p>
            ';
            $headers = "Content-Type: text/html\r\n";
            //$headers .= "From: " . $this->account()->getFullName() .  " <" . $this->account()->getEmail() . ">\r\n";
            $headers .= "From: " . $this->account()->getFullName() . " <no-reply@" . SITE_EMAIL_DOMAIN . ">\r\n";
            $mailString = '';
            $k = 0;
            foreach ($mails as $mail) {
                // echo '<pre>';
                // print_r($mail);
                // die;
                $k++;
                //mail($mail, $subject, $message, $headers);
                $emailData = [
                    'to' => $mail,
                    'fromName' => SITE_NAME,
                    'fromEmail' => 'no-reply@' . SITE_EMAIL_DOMAIN,
                    'subject' => $subject,
                    'body' => $message,
                    'header' => $headers,
                ];
                $this->getEmailRepository()->send($emailData);
                $mailString .= $mail;
                $mailString .= ($k < count($mails)) ? ', ' : '';
            }
            $this->log_manager->add(
                \models\ActivityAction::PROPOSAL_EMAIL_SEND_WORKORDER,
                'Sent work order for project ' . $proposal->getProjectName() . ' to: ' . $mailString,
                $proposal->getClient(),
                $proposal
            );
            $this->session->set_flashdata('success', 'Work order email sent to all valid emails entered!');
        } else {
            $this->session->set_flashdata('error', 'Work order not sent! No valid emails found!');
        }
        redirect('proposals/edit/' . $this->uri->segment(3) . '/preview_workorder');
    }

    /**
     * @description Copy proposal function. Calls the duplicate function with a copy flag
     * @param null $proposalId
     * @param null $clientId
     */
    public function copy($proposalId = null, $clientId = null, $duplicate_estimate = false, $business_type = null)
    {
        $this->duplicate_proposal($proposalId, $clientId, true, $duplicate_estimate, false, null, $business_type);
    }

    public function duplicate_proposal($proposalId = null, $clientId = null, $copy = false, $duplicate_estimate = false, $sameClient = false, $statusId = null, $business_type = null)
    {

        //check if proposal exists
        $proposal = $this->em->find('models\Proposals', $proposalId);
        if (!$proposal) {
            $this->session->set_flashdata('error', 'Proposal does not exist!');
            redirect('proposals');
        }

        if ($sameClient) {
            $client = $proposal->getClient();
        } else {
            $client = $this->em->find('models\Clients', $clientId);
            if (!$client) {
                $this->session->set_flashdata('error', 'Client does not exist!');
                redirect('clients');
            }
        }
        //if everything is good, carry on
        $this->load->database();

        // The 'OPEN' status for this company
        if (!$statusId) {
            $status = $client->getCompany()->getDefaultStatus(\models\Status::OPEN);
        } else {
            $status = $this->em->findStatus($statusId);
        }

        //create new proposal
        $new_proposal = $this->getProposalRepository()->create($this->account()->getCompany()->getCompanyId());
        $new_proposal->setAccessKey();
        $new_proposal->setClient($client);
        $new_proposal->setResendExcluded($client->getResendExcluded());
        $new_proposal->setProjectName($proposal->getProjectName());
        $new_proposal->setProposalTitle($proposal->getProposalTitle());
        $new_proposal->setPaymentTerm($proposal->getPaymentTerm());
        $new_proposal->setTexts($proposal->getTexts('plain'));
        $new_proposal->setContractCopy($proposal->getContractCopy());
        $new_proposal->setCompanyId($this->account()->getCompany()->getCompanyId());
        if ($copy) {
            // Set the job number if set
            if ($this->account()->getCompany()->getUseAutoNum()) {
                $new_proposal->setJobNumber($this->account()->getCompany()->getProposalAutoNum());
            }
        } else {
            $new_proposal->setJobNumber($proposal->getJobNumber());
        }
        $new_proposal->setLayout($proposal->getLayout());
        $new_proposal->setPaymentTermText($proposal->getPaymentTermText());
        //$new_proposal->setStatus($proposal->getStatus());
        $new_proposal->setProposalStatus($status);
        $new_proposal->setTextsCategories($proposal->getTextsCategories('plain'));
        $new_proposal->setVideoURL($proposal->getVideoURL());
        $new_proposal->setRebuildFlag(1);
        $new_proposal->setProjectAddress($proposal->getProjectAddress());
        $new_proposal->setProjectCity($proposal->getProjectCity());
        $new_proposal->setProjectState($proposal->getProjectState());
        $new_proposal->setProjectZip($proposal->getProjectZip());
        $new_proposal->setConvertedFrom($proposal->getConvertedFrom());
        $new_proposal->setLat($proposal->getLat());
        $new_proposal->setLng($proposal->getLng());
        $new_proposal->setOwner($proposal->getOwner());
        $new_proposal->setImageCount($proposal->getImageCount());

        if ($business_type) {
            //echo $business_type;die;
            $business_type_id = $business_type;
        } else {
            $business_type_id = $proposal->getBusinessTypeId();
        }
        $new_proposal->setBusinessTypeId($business_type_id);


        // Only set the duplicate if we aren't copying
        if (!$copy) {
            $new_proposal->setDuplicateOf($proposal->getProposalId());
        }
        $this->em->persist($new_proposal);
        $this->em->flush();
        
        //Create Proposal preview Client Link
        $this->getProposalRepository()->createClientProposalLink($new_proposal->getProposalId());
        //Copy All default Video
        //$this->getProposalRepository()->copyDefaultCompanyVideo($this->account()->getCompany()->getCompanyId(),$proposal->getProposalId());


        if (!$copy) {
            $duplicat_event_log_string = $proposal->getProjectName() . 'Proposal has Duplicated as ' . $new_proposal->getProjectName();
            $new_duplicat_event_log_string = ' Proposal Duplicated  and Create new proposal';
        } else {
            $duplicat_event_log_string = $proposal->getProjectName() . ' has Copied as ' . $new_proposal->getProjectName();
            $new_duplicat_event_log_string = ' Proposal Copied  and Create new proposal';
        }

        //Check business type assignment in account
        if ($new_proposal->getBusinessTypeId()) {
            $this->getProposalRepository()->checkNewBusinessTypeProposalAssignment($new_proposal, $business_type_id, $this->account()->getCompany()->getCompanyId());
        }

        //Event Log

        $this->getProposalEventRepository()->proposalsDuplicateTo($new_proposal, $this->account(), $duplicat_event_log_string);


        //Event Log

        $this->getProposalEventRepository()->proposalsDuplicateTo($proposal, $this->account(), $new_duplicat_event_log_string);
        //migrate proposal services
        $services_router = array();
        $serviceIdMigrations = [];
        $services = $this->db->query("select * from proposal_services where proposal=" . $proposal->getProposalId());
        foreach ($services->result() as $service) {
            //get texts
            $texts = $this->db->query("select * from proposal_services_texts where serviceId =" . $service->serviceId);
            //get fields
            $fields = $this->db->query("select * from proposal_services_fields where serviceId =" . $service->serviceId);
            $old_service_id = $service->serviceId;

            $service->serviceId = null;
            $service->proposal = $new_proposal->getProposalId();
            $this->db->insert('proposal_services', $service);
            $newServiceId = $this->db->insert_id();

            // Update the migrated service for later
            $serviceIdMigrations[$old_service_id] = $newServiceId;

            //migrate proposal services texts
            foreach ($texts->result() as $text) {
                $text->textId = null;
                $text->serviceId = $newServiceId;
                $this->db->insert('proposal_services_texts', $text);
            }
            //migrate proposal services fields
            foreach ($fields->result() as $field) {
                $field->fieldId = null;
                $field->serviceId = $newServiceId;
                $this->db->insert('proposal_services_fields', $field);
            }

            if ($duplicate_estimate) {
                $Phases = $this->db->query("select * from estimation_phases where proposal_service_id =" . $old_service_id);
                $proposalEstimates = $this->db->query("select * from proposal_estimates where proposal_id =" . $proposal->getProposalId());
                $Estimates = $this->db->query("select * from estimates where proposal_service_id =" . $old_service_id);
                //migrate proposal services fields
                foreach ($Phases->result() as $Phase) {
                    $EstimateLineItems = $this->db->query("select * from estimate_line_items where parent_line_item_id IS NULL AND phase_id =" . $Phase->id);
                    $Phase->id = null;
                    $Phase->proposal_service_id = $newServiceId;
                    $Phase->proposal_id = $new_proposal->getProposalId();;
                    $this->db->insert('estimation_phases', $Phase);
                    $newPhaseId = $this->db->insert_id();

                    foreach ($EstimateLineItems->result() as $EstimateLineItem) {
                        $EstimateCalculatorValues = $this->db->query("select * from estimate_calculator_values where line_item_id =" . $EstimateLineItem->id);
                        $EstimateLineChildItems = $this->db->query("select * from estimate_line_items where parent_line_item_id =" . $EstimateLineItem->id);
                        $EstimateLineItem->id = null;
                        $EstimateLineItem->phase_id = $newPhaseId;
                        $EstimateLineItem->proposal_service_id = $newServiceId;
                        $EstimateLineItem->proposal_id = $new_proposal->getProposalId();
                        $this->db->insert('estimate_line_items', $EstimateLineItem);
                        $newEstimateLineItem = $this->db->insert_id();

                        foreach ($EstimateCalculatorValues->result() as $EstimateCalculatorValue) {
                            //print_r($EstimateCalculatorValue->line_item_id);die;
                            $EstimateCalculatorValue->id = null;
                            $EstimateCalculatorValue->line_item_id = $newEstimateLineItem;
                            $EstimateCalculatorValue->proposal_service_id = $newServiceId;
                            $this->db->insert('estimate_calculator_values', $EstimateCalculatorValue);
                        }

                        foreach ($EstimateLineChildItems->result() as $EstimateLineChildItem) {
                            $EstimateChildCalculatorValues = $this->db->query("select * from estimate_calculator_values where line_item_id =" . $EstimateLineChildItem->id);
                            $EstimateLineChildItem->id = null;
                            $EstimateLineChildItem->phase_id = $newPhaseId;
                            $EstimateLineChildItem->proposal_service_id = $newServiceId;
                            $EstimateLineChildItem->proposal_id = $new_proposal->getProposalId();
                            $EstimateLineChildItem->parent_line_item_id = $newEstimateLineItem;
                            $this->db->insert('estimate_line_items', $EstimateLineChildItem);
                            $newEstimateLineChildItem = $this->db->insert_id();

                            foreach ($EstimateChildCalculatorValues->result() as $EstimateChildCalculatorValue) {
                                //print_r($EstimateCalculatorValue->line_item_id);die;
                                $EstimateChildCalculatorValue->id = null;
                                $EstimateChildCalculatorValue->line_item_id = $newEstimateLineChildItem;
                                $EstimateChildCalculatorValue->proposal_service_id = $newServiceId;
                                $this->db->insert('estimate_calculator_values', $EstimateChildCalculatorValue);
                            }
                        }
                    }
                }

                $Estimate = $Estimates->row();
                $Estimate->id = null;
                $Estimate->proposal_id = $new_proposal->getProposalId();
                $Estimate->proposal_service_id = $newServiceId;
                $this->db->insert('estimates', $Estimate);

                $proposalEstimate = $proposalEstimates->row();
                $proposalEstimate->id = null;
                $proposalEstimate->proposal_id = $new_proposal->getProposalId();
                $this->db->insert('proposal_estimates', $proposalEstimate);

                //Event Log
                $this->getProposalEventRepository()->startEstimation($new_proposal, $this->account());
            }
        }
        //migrate proposal attachments
        $attachments = $this->db->query("select * from proposals_attatchments where proposal=" . $proposal->getProposalId());
        foreach ($attachments->result() as $attachment) {
            $attachment->attatchId = null;
            $attachment->proposal = $new_proposal->getProposalId();
            $this->db->insert('proposals_attatchments', $attachment);
        }
        //migrate proposal images
        $images = $this->db->query("select * from proposals_images where proposal=" . $proposal->getProposalId());
        $folder_old = $proposal->getUploadDir();
        $folder = $new_proposal->getUploadDir();
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }
        foreach ($images->result() as $image) {
            $image->imageId = null;
            if (file_exists($folder_old . '/' . $image->image)) {
                $image->proposal = $new_proposal->getProposalId();
                if ($image->proposal_service_id) {
                    if (isset($serviceIdMigrations[$image->proposal_service_id])) {
                        $image->proposal_service_id = $serviceIdMigrations[$image->proposal_service_id];
                    }
                }
                $this->db->insert('proposals_images', $image);
                copy($folder_old . '/' . $image->image, $folder . '/' . $image->image);
            }
        }

        $proposal_videos = $this->db->query("select * from proposal_videos where proposal_id=" . $proposal->getProposalId());

        foreach ($proposal_videos->result() as $proposal_video) {
            $proposal_video->id = null;
            $proposal_video->proposal_id = $new_proposal->getProposalId();
            $this->db->insert('proposal_videos', $proposal_video);
        }

        updateProposalPrice($new_proposal->getProposalId());

        if ($copy) {
            $this->session->set_flashdata('success', 'Proposal Copied Successfully!');
            // Log the copy
            $this->log_manager->add(
                \models\ActivityAction::COPY_PROPOSAL,
                'Created copy proposal from #' . $proposal->getProposalId(),
                $new_proposal->getClient(),
                $new_proposal
            );
        } else {
            $this->session->set_flashdata('success', 'Proposal Duplicated!');
            // Log the duplication
            $this->log_manager->add(
                \models\ActivityAction::DUPLICATE_PROPOSAL,
                'Created duplicate proposal from #' . $proposal->getProposalId(),
                $new_proposal->getClient(),
                $new_proposal
            );
        }
        //Delete user query Cache
        $this->getQueryCacheRepository()->deleteCompanyHeaderProposalCache($this->account()->getCompanyId());

        // Log the status setting
        $this->log_manager->add(
            \models\ActivityAction::CHANGE_PROPOSAL_STATUS,
            'Proposal status set to ' . $status->getText(),
            $new_proposal->getClient(),
            $new_proposal
        );

        $this->getClientRepository()->updateProposalCount($new_proposal->getClient()->getClientId());

        if (!$sameClient) {
            if ($client->getAccount()->getAccountId() != $new_proposal->getOwner()->getAccountId()) {
                // Email the owner of th client if different from the proposal owner
                $emailData = [
                    'clientOwnerFirstName' => $client->getAccount()->getFirstName(),
                    'proposalProjectTitle' => $new_proposal->getProjectName(),
                    'proposalOwnerFullName' => $new_proposal->getOwner()->getFullName(),
                    'clientName' => $new_proposal->getClient()->getFullName(),
                    'accountName' => $new_proposal->getClient()->getClientAccount() ? $new_proposal->getClient()->getClientAccount()->getName() : 'Unspecified Account',
                ];
                $this->load->model('system_email');
                $this->system_email->sendEmail(20, $client->getAccount()->getEmail(), $emailData);
            }

            // Redirect to basic info for a copy
            if ($copy) {
                redirect('proposals/edit/' . $new_proposal->getProposalId() . '/basic_info');
            } else {
                redirect('proposals/edit/' . $new_proposal->getProposalId());
            }
        }
    }

    /**
     *  Remove the duplicate proposal ID
     */
    public function unduplicate()
    {
        //check if proposal exists
        $proposal = $this->em->find('models\Proposals', $this->uri->segment(3));
        if (!$proposal) {
            $this->session->set_flashdata('error', 'Proposal does not exist!');
            redirect('proposals');
        }
        //check if current account can edit proposal
        if (!$this->account()->isAdministrator() && ($this->account()->getFullAccess() == 'no')) { //check if user is not an admin
            //if user is branch manager and the proposal is in a differnet branch
            if (($this->account() != $proposal->getClient()->getAccount()) && (($this->account()->getUserClass() == 1) && ($this->account()->getBranch() != $proposal->getClient()->getAccount()->getBranch()))) {
                $this->session->set_flashdata('error', 'You do not have enough privileges to edit this proposal!');
                redirect('proposals');
            }
        }
        //check if the proposal is in the same company as the user who is editing
        if (!$this->account()->isGlobalAdministrator()) {
            if ($this->account()->getCompany() != $proposal->getClient()->getCompany()) {
                $this->session->set_flashdata('error', 'You do not have enough privileges to edit this proposal!');
                redirect('proposals');
            }
        }
        //lock user out if he is not allowed to send proposals and the proposal is in the queue
        if ( ($this->account()->requiresApproval()) && ($proposal->inApprovalQueue())) {
            $this->session->set_flashdata(
                'error',
                'Hey There! Your proposal is in the approval process. After approval, you will regain access to the proposal.'
            );
            redirect('proposals');
        }
        if (($proposal->getOwner() == $this->account()) && ($this->account()->isSecretary() && $this->uri->segment(4) == 'send')) { //if owner is a secretary, GTFO Bitch
            $this->session->set_flashdata(
                'error',
                'Oops! Based on your type of account with ' . SITE_NAME . ', you are not able to email proposals. <br><br> Please assign the contact to an authorized user and then you can send the proposal.  If you wish to send proposals, contact your company admin to purchase that option.'
            );
            redirect('proposals/edit/' . $this->uri->segment(3));
        }

        // Checks complete, carry out the action
        $proposal->setDuplicateOf(null);
        $this->em->persist($proposal);
        $this->em->flush();
        //Delete user query Cache
        $this->getQueryCacheRepository()->deleteCompanyHeaderProposalCache($this->account()->getCompanyId());

        if (!$proposal->getDuplicateOf()) {
            // Log it
            $this->log_manager->add(
                \models\ActivityAction::STANDALONE_PROPOSAL,
                'Proposal set to standalone from duplicate',
                $proposal->getClient(),
                $proposal
            );
            $this->session->set_flashdata('success', 'Proposal has been added as a new proposal');
        } else {
            $this->session->set_flashdata('error', 'An error occurred. Please try again.');
        }

        redirect('proposals/edit/' . $proposal->getProposalId());
    }

    public function groupCopyToContact()
    {
        set_time_limit(0);

        $ids = $this->input->post('ids');
        $statusId = $this->input->post('statusId');

        if (is_array($ids)) {
            foreach ($ids as $proposalId) {
                $this->duplicate_proposal($proposalId, null, true, true, true, $statusId);
            }
        }

        echo json_encode(
            [
                'ids' => $ids,
                'statusId' => $statusId
            ]
        );
    }

    public function invoice($proposalId)
    {
        // Load the proposal
        $proposal = $this->em->findProposal($proposalId);
  
        // Check load
        if (!$proposal) {
            $this->session->set_flashdata('error', 'Proposal could not be loaded!');
            redirect('proposals');
        }

        // Permission check
        if (!$this->account()->isAdministrator() && (!$this->account()->hasFullAccess())) { //check if user is not an admin
            $this->session->set_flashdata('error', 'You do not have permission to do this!');
            redirect('proposals');
        }

        // Check for optional services
        // if ($proposal->hasOptionalServices()) {
        //     $this->session->set_flashdata('error',
        //         'This proposal has optional services. Please remove any options before invoicing.');
        //     redirect('proposals');
        // }

        // Check for prior invoice
        if ($proposal->getQBID()) {
            $this->session->set_flashdata(
                'error',
                'This proposal has already been invoiced in QuickBooks! Invoice ID: ' . $proposal->getQBID()
            );
            redirect('proposals');
        }

        $numServices = count($proposal->getServices());
     
        if ($numServices < 1) {
            $this->session->set_flashdata('error', 'This proposal has no services to invoice!');
            redirect('proposals');
        }

        if ($this->account()->getCompany()->hasQb()) {
            if ($this->account()->getCompany()->getQbType() == 'desktop') {
                ///////////////For Add Invoice in quickbook dsktop : by sunil///////
                $services = $proposal->getServices();
                $user = md5($this->account()->getCompanyId());
                for ($i = 0; $i < count($services); $i++) {
                    $service_id = $services[$i]->getInitialService();

                    $this->db->select('quickbooks_queue_id')->from('quickbooks_queue')->where(
                        'qb_action',
                        'ItemServiceAdd'
                    )->where('ident', $service_id)->where('qb_status', 's');

                    $query = $this->db->get();
                    
                    if ($query->num_rows() < 1) {
                        $this->getQbdRepository()->enqueue(QUICKBOOKS_ADD_SERVICEITEM, $service_id, 1, '', $user);
                    }
                }
                $this->db->select('quickbooks_queue_id')->from('quickbooks_queue')->where(
                    'qb_action',
                    'CustomerAdd'
                )->where('ident', $proposal->getClient()->getClientId())->where('qb_status', 's');
                $quer1 = $this->db->get();
                if ($quer1->num_rows() < 1) {
                    $this->getQbdRepository()->enqueue(
                        QUICKBOOKS_ADD_CUSTOMER,
                        $proposal->getClient()->getClientId(),
                        1,
                        '',
                        $user
                    );
                }
                $this->db->select('quickbooks_queue_id')->from('quickbooks_queue')->where(
                    'qb_action',
                    'InvoiceAdd'
                )->where('ident', $proposalId)->where('qb_status', 's');
                $query = $this->db->get();

                if ($query->num_rows() > 0) {
                    $this->getQbdRepository()->enqueue(QUICKBOOKS_MOD_INVOICE, $proposalId, 0, '', $user);
                } else {
                    $this->getQbdRepository()->enqueue(QUICKBOOKS_ADD_INVOICE, $proposalId, 0, '', $user);
                }
                /////////////////////////////////////end: by sunil ///////////////////////
            }
        }

        // We're good to proceed - load the status and save it
        $invoicedStatus = $this->em->findStatus(\models\Status::INVOICED_QB);
        $proposal->setProposalStatus($invoicedStatus);
        // Set the sync flag
        if (!$proposal->getQBID()) {
            $proposal->setQBSyncFlag(1);
        }

        //Save
        $this->em->persist($proposal);
        $this->em->flush();
        //Delete user query Cache
        $this->getQueryCacheRepository()->deleteCompanyHeaderProposalCache($this->account()->getCompanyId());

        if (!$proposal->getClient()->getQBID()) {
            $this->getQuickbooksRepository()->addContactToSync($proposal->getClient()->getClientId());
        }

        // Log it
        $this->log_manager->add(\models\ActivityAction::PROPOSAL_INVOICED, 'Proposal Invoiced', $proposal->getClient(), $proposal);

        // Feedback and redirect
        $this->session->set_flashdata(
            'success',
            'Proposal invoiced. The invoice will be generated in QuickBooks shortly'
        );
        redirect('proposals');
    }

    public function export($fileName)
    {
        $fileName = urldecode($fileName);

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $fileName . '.csv"');
        return $this->getProposalRepository()->proposalExportCSV($this->account());
    }

    public function groupExport()
    {
        $proposalIds = $this->input->post('groupExportProposalIds');

        $fileName = urldecode($this->input->post('groupExportName'));

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $fileName . '.csv"');
        return $this->getProposalRepository()->groupProposalExportCSV($this->account(), $proposalIds);
    }

    public function estimate($proposalId)
    {
        $proposal = $this->em->findProposal($proposalId);
         // Check it loaded
        if (!$proposal) {
            // Feedback and redirect
            $this->session->set_flashdata('error', 'Proposal could not be loaded');
            redirect('proposals');
            return;
        }

        //check if the proposal is in the same company as the user who is editing

        if ($this->account()->getCompany() != $proposal->getClient()->getCompany()) {
            $this->session->set_flashdata('error', 'You do not have enough privileges to edit this proposal!');
            redirect('proposals');
        }


        //check estimating permission
        if (!$this->account()->hasEstimatingPermission()) {
            $this->session->set_flashdata('error', 'Estimating permission denied');
            redirect('proposals');
        }


        $company = $this->account()->getCompany();
        $account = $this->account();
        $settings = $this->getEstimationRepository()->getCompanySettings($company);

        if (!$proposal->getEstimateCalculationType()) {
            $proposal->setEstimateCalculationType($settings->getCalculationType());
            $this->em->persist($proposal);
            $this->em->flush();
        }

        $proposalServices = $this->getProposalRepository()->getProposalServiceDetails($this->account()->getCompany(), $proposal);
        // echo '<pre>';
        // print_r($proposalServices);
        // die;
        if (!count($proposalServices) > 0) {
            $this->session->set_flashdata('error', 'Please add at least one service to this proposal to enable estimation');
            redirectPreviousPage();
        }

        // TODO Permission check - leave for now while developing estimator
        // create default Phase if needed
        $this->getEstimationRepository()->createDefaultPhases($this->account()->getCompany(), $proposal);
        // create default ProposalEstimate if needed
        $this->getEstimationRepository()->createDefaultProposalEstimate($proposal, $this->account());
        //echo '<pre>';


        // $temp = $this->getEstimationRepository()->getCompanyPlantsByUser($this->account());
        // print_r($this->getEstimationRepository()->getCompanySortedTypes($this->account()->getCompany()));
        // die;
        // View Data

        $data = [
            'proposal' => $proposal,
            'proposal_status_id' => $proposal->getEstimateStatusId(),
            'calculationTypes' => $this->getEstimationRepository()->getCalculationTypes(),
            'oh_pm_type' => $proposal->getEstimateCalculationType(),
            'proposalRepository' => $this->getProposalRepository(),
            'proposalServices' => $proposalServices,
            'categories' => $this->getEstimationRepository()->getCompanyCategories($this->account()->getCompany()),
            'sortedTypes' => $this->getEstimationRepository()->getCompanySortedTypes($this->account()->getCompany()),
            'types' => $this->getEstimationRepository()->getCompanyTypes($this->account()->getCompany()),
            //'sortedItems' => $this->getEstimationRepository()->getCompanySortedItems($this->account()->getCompany()),

            'sortedItems' => $this->getEstimationRepository()->getCompanyProposalSortedItems($this->account()->getCompany(), $proposalId),

            'sortedUnits' => $this->getEstimationRepository()->getSortedUnits(),
            'serviceTypeAssignments' => $this->getEstimationRepository()->getAllCompanyServiceTypeAssignments($this->account()->getCompany()),
            'serviceTemplateAssignments' => $this->getEstimationRepository()->getAllCompanyServiceTemplateAssignments($this->account()->getCompany()),
            'templates' => $this->getEstimationRepository()->getPopulatedTemplates($this->account()->getCompany(), $proposalId),
            'plants' => $this->getEstimationRepository()->getCompanyPlantsByUser($proposal->getOwner(), $proposal),
            'dumps' => $this->getEstimationRepository()->getCompanyDumpsByUser($proposal->getOwner(), $proposal),
            'customCategoryId' => 6,
            'truckingItems' => json_encode($this->getEstimationRepository()->getTruckingItemsArray($this->account()->getCompany())),
            'sandSealerItems' => json_encode($this->getEstimationRepository()->getSandSealerItemsArray($this->account()->getCompany())),
            'additiveSealerItems' => json_encode($this->getEstimationRepository()->getAdditiveSealerItemsArray($this->account()->getCompany())),
            'laborGroupItems' => $this->getEstimationRepository()->getlaborItemsArray($this->account()->getCompany()),
            'equipments' => $this->getEstimationRepository()->getCategoryTypeByCategoryId($this->account()->getCompany(), \models\EstimationCategory::EQUIPMENT),
            'company_id' => $this->account()->getCompany()->getCompanyId(),
            'service' => null,
            'settings' => $this->getEstimationRepository()->getCompanySettings($company),
            'subContractors' => $this->getEstimationRepository()->getSubcontractors($company),
            'account' => $account,
        ];

        // Scripts
        $this->html->addJS(site_url('3rdparty/jquery.scrollTo-1.4.2-min.js'));
        $this->html->addScript('ckeditor4');
        $this->html->addScript('dataTables');
        //$this->html->addScript('googleAjax');
        // Render view

     
        $this->load->view('proposals/estimate/index', $data);
    }
    

    public function estimate_items($proposalId)
    {
        $proposal = $this->em->findProposal($proposalId);

        // Check it loaded
        if (!$proposal) {
            // Feedback and redirect
            $this->session->set_flashdata('error', 'Proposal could not be loaded');
            redirect('proposals');
            return;
        }

        // TODO Permission check - leave for now while developing estimator

        $data = [
            'proposal' => $proposal,
        ];

        $services = $proposal->getServices();

        $i = 0;
        foreach ($services as $service) {
            $service_id = $service->getServiceId();
            $phases = $this->getEstimationRepository()->getProposalServicePhaseArray($service, $proposalId);

            foreach ($phases as $phase) {
                $phaseId = $phase['id'];

                $data['items'][$i] = [
                    'proposalService' => $service,
                    'phase' => $phase,
                    'sortedItems' => $this->getEstimationRepository()
                        ->getPhaseSortedLineItems($this->account()->getCompany(), $phaseId, $service_id)
                ];
                $i++;
            }
        }


        // Render view
        $this->load->view('proposals/estimate/item-sheet', $data);
    }

    public function job_costing($proposalId)
    {

        $proposal = $this->em->findProposal($proposalId);

        // Check it loaded
        if (!$proposal) {
            // Feedback and redirect
            $this->session->set_flashdata('error', 'Proposal could not be loaded');
            redirect('proposals');
            return;
        }
        $serviceJobCost = $this->em->getRepository('models\ServiceJobCost')->findOneBy(
            array(
                'proposal_id' => $proposalId
            )
        );
        if (!$serviceJobCost) {
            $this->getEstimationRepository()->createDefaultProposalServiceJobCosting($proposal, $this->account());
        } else {
            /// need to uncomment

            if ($serviceJobCost->getStatusId() == \models\JobCostStatus::COMPLETE || $proposal->isWon() == false) {
                $this->session->set_flashdata('error', 'Job Cost could not be loaded');
                redirect('proposals');
                return;
            }
        }


        $data = [
            'proposal' => $proposal,
            'repo' => $this->getEstimationRepository(),
            'attachments' => $this->getEstimationRepository()->getJobCostAttachments($proposalId),
        ];

        $services = $proposal->getServices();


        $i = 0;
        //$this->getEstimationRepository()->getProposalServiceJobCostItems($this->account()->getCompany(), 473691);
        foreach ($services as $service) {
            $service_id = $service->getServiceId();
            $i++;
            $total_estimate_items = $this->getEstimationRepository()->getProposalServiceLineItemsCount($service_id);
            $total_job_cost_items = $this->getEstimationRepository()->getProposalServiceJobCostingItemsCount($service_id);
            $total_job_cost_custom_items = $this->getEstimationRepository()->getProposalServiceJobCostingCustomItemsCount($service_id);

            $is_service_completed = 0;
            // echo $total_estimate_items;
            // echo '<br/>';
            // echo $total_job_cost_items;
            // echo '<br/>';
            // echo $total_job_cost_custom_items;
            // echo '<br/>';
            // die;
            // if($total_estimate_items == ($total_job_cost_items+$total_job_cost_custom_items)){

            //     $is_service_completed = 1;
            // }else
            if ($total_estimate_items <= $total_job_cost_items) {
                $is_service_completed = 1;
            } elseif ($total_estimate_items == 0 && $total_job_cost_custom_items > 0) {
                $is_service_completed = 1;
            }

            $data['services'][$i] = [
                'service_details' => $service,
                'is_service_completed' => $is_service_completed,
                'job_cost_price_difference' => $this->getEstimationRepository()->getServiceJobCostPriceDifference($service_id),
                'subContractorItem' => $this->getEstimationRepository()->getSubContractorServiceJobCostItems($service_id),
                'sortedItems' => $this->getEstimationRepository()
                    ->getProposalServiceNontruckingJobCostItems($proposal->getClient()->getCompany(), $service_id),
                'fieldValues' => $this->getProposalRepository()->getPopulatedServiceFields($proposal->getClient()->getCompany(), $service),
                'truckingItems' => $this->getEstimationRepository()->getTruckingProposalServiceLineItems($proposal->getClient()->getCompany(), $service_id),
            ];
        }
        // echo '<pre>';
        // print_r($data['services']);die;

        $data['foremans'] = $this->getEstimationRepository()->getCompanyForemenList($proposal->getClient()->getCompany());
        $data['categories'] = $this->getEstimationRepository()->getCompanyCategories($proposal->getClient()->getCompany());
        $data['all_proposal_services'] = $services;
        $data['proposaljob_cost_price_difference'] = $this->getEstimationRepository()->getProposalJobCostPriceDifference($proposalId);
        // Render view
        $this->load->view('proposals/job_costing/index2', $data);
    }

    public function mobile_job_costing($proposalId)
    {
        $proposal = $this->em->findProposal($proposalId);

        // Check it loaded
        if (!$proposal) {
            // Feedback and redirect
            $this->session->set_flashdata('error', 'Proposal could not be loaded');
            redirect('proposals');
            return;
        }
        $serviceJobCost = $this->em->getRepository('models\ServiceJobCost')->findOneBy(
            array(
                'proposal_id' => $proposalId
            )
        );
        if (!$serviceJobCost) {
            $this->getEstimationRepository()->createDefaultProposalServiceJobCosting($proposal);
        } else {
            /// need to uncomment

            // if($serviceJobCost->getStatusId()== \models\JobCostStatus::COMPLETE){
            //     $this->session->set_flashdata('error', 'Job Cost could not be loaded');
            //     redirect('proposals');
            //     return;
            // }
        }


        $data = [
            'proposal' => $proposal,
            'repo' => $this->getEstimationRepository(),

        ];

        $services = $proposal->getServices();


        $i = 0;
        //$this->getEstimationRepository()->getProposalServiceJobCostItems($this->account()->getCompany(), 473691);
        foreach ($services as $service) {
            $service_id = $service->getServiceId();
            $i++;

            $total_estimate_items = $this->getEstimationRepository()->getProposalServiceLineItemsCount($service_id);
            $total_job_cost_items = $this->getEstimationRepository()->getProposalServiceJobCostingItemsCount($service_id);
            $is_service_completed = 0;
            if ($total_estimate_items > 0 && $total_estimate_items == $total_job_cost_items) {
                $is_service_completed = 1;
            }


            $data['services'][$i] = [
                'service_details' => $service,
                'is_service_completed' => $is_service_completed,
                'job_cost_price_difference' => $this->getEstimationRepository()->getServiceJobCostPriceDifference($service_id),
                'subContractorItem' => $this->getEstimationRepository()->getSubContractorServiceJobCostItems($service_id),
                'sortedItems' => $this->getEstimationRepository()
                    ->getProposalServiceJobCostItems($this->account()->getCompany(), $service_id),
                'fieldValues' => $this->getProposalRepository()->getPopulatedServiceFields($this->account()->getCompany(), $service)
            ];
        }
        echo '<pre>';
        print_r($data['services']);
        die;

        $data['categories'] = $this->getEstimationRepository()->getCompanyCategories($this->account()->getCompany());
        $data['all_proposal_services'] = $services;
        $data['proposaljob_cost_price_difference'] = $this->getEstimationRepository()->getProposalJobCostPriceDifference($proposalId);
        // Render view
        $this->load->view('proposals/job_costing/mobile_job_costing', $data);
    }

    public function job_cost_report($proposalId)
    {
        $proposal = $this->em->findProposal($proposalId);

        // Check it loaded
        if (!$proposal) {
            // Feedback and redirect
            $this->session->set_flashdata('error', 'Proposal could not be loaded');
            redirect('proposals');
            return;
        }
        if ($proposal->getJobCostStatus() != \models\JobCostStatus::COMPLETE) {
            $this->session->set_flashdata('error', 'Job Costing not Completed ');
            redirect('proposals');
            return;
        }
        //print_r($this->getEstimationRepository()->getJobCostImageCount($proposalId));die;
        $data = [
            'proposal' => $proposal,
            'repo' => $this->getEstimationRepository(),
            'subContractorItems' => $this->getEstimationRepository()->getProposalSubContractorJobCostItems($proposalId),
            'sortedItems' => $this->getEstimationRepository()
                ->getProposalJobCostSortedLineItemsTotal($this->account()->getCompany(), $proposalId),
            'category_total' => $this->getEstimationRepository()
                ->getProposalJobCostCategoryTotal($this->account()->getCompany(), $proposalId),
            'sub_contractor_total' => $this->getEstimationRepository()
                ->getProposalJobCostSubContractorTotal($this->account()->getCompany(), $proposalId),
            'breakdown' => $this->getEstimationRepository()
                ->getJobCostReportSummary($proposal),
            'attachments' => $this->getEstimationRepository()->getJobCostAttachments($proposalId),
            'image_count' => $this->getEstimationRepository()->getJobCostImageCount($proposalId),

        ];
        // echo '<pre>';
        // print_r( $data['category_total']);die;

        $services = $proposal->getServices();


        $i = 0;
        foreach ($services as $service) {
            $service_id = $service->getServiceId();


            $i++;
            $data['services'][$i] = [
                'service_details' => $service,
                'subContractorItem' => $this->getEstimationRepository()->getProposalServiceJobCostSubContractorTotal($service_id),

                'sortedItems' => $this->getEstimationRepository()
                    ->getProposalServiceJobCostCategoryTotal($this->account()->getCompany(), $service_id),
                'fieldValues' => $this->getProposalRepository()->getPopulatedServiceFields($this->account()->getCompany(), $service)
            ];
        }

        $data['all_proposal_services'] = $services;
        $this->html->addScript('dataTables');
        // Render view
        $this->load->view('proposals/job_costing/report', $data);
    }

    public function estimate_items_total($proposalId)
    {
        $proposal = $this->em->findProposal($proposalId);

        // Check it loaded
        if (!$proposal) {
            // Feedback and redirect
            $this->session->set_flashdata('error', 'Proposal could not be loaded');
            redirect('proposals');
            return;
        }
        // echo '<pre>';
        //print_r($this->getEstimationRepository()->getProposalSortedLineItemsTotal($this->account()->getCompany(), $proposalId));die;
        // TODO Permission check - leave for now while developing estimator

        // $data['services_base'] = [

        //     'sortedItems' => $this->getEstimationRepository()
        //         ->getProposalServiceSortedLineItems($this->account()->getCompany(), $proposalId)
        // ];
        //print_r( $this->getEstimationRepository()->getTruckingProposalSortedLineItems($proposalId));die;
        $data = [
            'proposal' => $proposal,
            'repo' => $this->getEstimationRepository(),
            'subContractorItems' => $this->getEstimationRepository()->getSubContractorProposalSortedLineItems($proposalId),
            'sortedItems' => $this->getEstimationRepository()
                ->getProposalSortedLineItemsTotal($this->account()->getCompany(), $proposalId),
            'truckingItems' => $this->getEstimationRepository()->getTruckingProposalSortedLineItems($proposalId),
            'templateItems' => $this->getEstimationRepository()->getProposalTemplateSortedItemSummaryLineItems($proposalId),
        ];

        $services = $proposal->getServices();


        $i = 0;
        foreach ($services as $service) {
            $service_id = $service->getServiceId();
            $phases = $this->getEstimationRepository()->getProposalServicePhaseArray($service, $proposalId);
            $j = 1;
            foreach ($phases as $phase) {
                $phaseId = $phase['id'];

                $data['items'][$i] = [
                    'proposalService' => $service,
                    'phase' => $phase,
                    'phase_count' => $j++,
                    'subContractorItem' => $this->getEstimationRepository()->getSubContractorPhaseSortedLineItems($phaseId),
                    'sortedItems' => $this->getEstimationRepository()->getPhaseSortedLineItemsWithoutFixedTemplate($this->account()->getCompany(), $phaseId, $service_id),
                    'fieldValues' => $this->getProposalRepository()->getPopulatedServiceFields($this->account()->getCompany(), $service),
                    'phaseTotal' => $this->getEstimationRepository()->getPhaseTotal($phaseId),
                    'phaseTruckingItems' => $this->getEstimationRepository()->getTruckingPhaseSortedLineItems($phaseId),
                    'phaseTemplateItems' => $this->getEstimationRepository()->getTemplatePhaseItemSummaryLineItems($phaseId),
                ];
                $i++;
            }

            $data['services'][$i] = [
                'service_details' => $service,
                'subContractorItem' => $this->getEstimationRepository()->getSubContractorServiceSortedLineItems($service_id),
                'sortedItems' => $this->getEstimationRepository()
                    ->getProposalServiceSortedLineItems($this->account()->getCompany(), $service_id),
                'fieldValues' => $this->getProposalRepository()->getPopulatedServiceFields($this->account()->getCompany(), $service),
                'truckingItems' => $this->getEstimationRepository()->getTruckingProposalServiceSortedLineItems($service_id),
                'serviceTemplateItems' => $this->getEstimationRepository()->getServiceTemplateSortedItemSummaryLineItems($service_id),
            ];
        }

        $data['all_proposal_services'] = $services;

        // Render view
        $this->load->view('proposals/estimate/item-sheet-total', $data);
    }

    public function estimates()
    {
        // Handle old format filter data //

        // Status
        if ($this->session->userdata('pFilterStatus') && !is_array($this->session->userdata('pFilterStatus'))) {
            $value = $this->session->userdata('pFilterStatus');
            $this->session->set_userdata('pFilterStatus', [$value]);
        }

        // User
        if ($this->session->userdata('pFilterUser') && !is_array($this->session->userdata('pFilterUser'))) {
            $value = $this->session->userdata('pFilterUser');
            $this->session->set_userdata('pFilterUser', [$value]);
        }

        // Account
        if ($this->session->userdata('pFilterClientAccount') && !is_array($this->session->userdata('pFilterClientAccount'))) {
            $value = $this->session->userdata('pFilterClientAccount');
            $this->session->set_userdata('pFilterClientAccount', [$value]);
        } else {
            if ($this->session->userdata('pFilterClientAccount') == '') {
                $this->session->set_userdata('pFilterClientAccount', []);
            }
        }

        $filteredClientAccounts = [];
        if (count($this->session->userdata('pFilterClientAccount')) > 0) {
            foreach ($this->session->userdata('pFilterClientAccount') as $ccid) {
                $filteredClientAccounts[] = $this->em->find('models\ClientCompany', $ccid);
            }
        }

        // Service
        if ($this->session->userdata('pFilterService') && !is_array($this->session->userdata('pFilterService'))) {
            $value = $this->session->userdata('pFilterService');
            $this->session->set_userdata('pFilterService', [$value]);
        }


        // Queue
        if ($this->session->userdata('pFilterQueue') && !is_array($this->session->userdata('pFilterQueue'))) {
            $value = $this->session->userdata('pFilterQueue');
            $this->session->set_userdata('pFilterQueue', [$value]);
        }

        // Email
        if ($this->session->userdata('pFilterEmailStatus') && !is_array($this->session->userdata('pFilterEmailStatus'))) {
            $value = $this->session->userdata('pFilterEmailStatus');
            $this->session->set_userdata('pFilterEmailStatus', [$value]);
        }


        // End old filter fixes
        $data['categories'] = $this->account()->getCompany()->getCategories();
        $data['statusCollection'] = $this->account()->getStatuses();
        $data['statuses'] = $this->getEstimationRepository()->getStatuses();
        $data['services'] = $this->account()->getCompany()->getServices(true);
        $data['estimateStatuses'] = $this->getEstimationRepository()->getStatuses();
        $data['numMappedProposals'] = $this->getCompanyRepository()->getMappedProposalsCount($this->account());
        $data['account'] = $this->account();
        $data['filteredClientAccounts'] = $filteredClientAccounts;
        $data['action'] = '';
        $data['group'] = '';
        $data['search'] = '';
        $data['client'] = '';
        $data['clientCompany'] = '';
        $data['automatic_reminders_template'] = $this->getProposalNotificationsRepository()->getProposalResendSettings($this->account()->getCompany()->getCompanyId())->template;
        $data['automatic_reminders_enabled'] = $this->getProposalNotificationsRepository()->getProposalResendSettings($this->account()->getCompany()->getCompanyId())->enabled;
        $data['proposal_resend_frequency'] = ($this->getProposalNotificationsRepository()->getProposalResendSettings($this->account()->getCompany()->getCompanyId())->frequency) ?: 86400;
        $this->load->model('clientEmail');
        $data['proposal_email_templates'] = $this->clientEmail->getTemplates(
            $this->account()->getCompany()->getCompanyId(),
            1,
            true
        );
        $data['minBid'] = 0;
        $data['maxBid'] = $this->getEstimationRepository()->getHighestEstimateBid($this->account()->getCompany()->getCompanyId());
        $data['filterMinBid'] = $this->session->userdata('pFilterMinBid') ?: 0;
        $data['filterMaxBid'] = $this->session->userdata('pFilterMaxBid') ?: $this->account()->getCompany()->getHighestBid();

        $type = $this->uri->segment(3);
        $this->load->model('branchesapi');

        $data['branches'] = [];
        // Branches based on permission level
        if ($this->account()->hasFullAccess()) {
            $data['accounts'] = $this->account()->getCompany()->getAccounts();
            $data['branches'] = $this->branchesapi->getBranches($this->account()->getCompany()->getCompanyId());
        } else {
            if ($this->account()->isBranchAdmin()) {
                if ($this->account()->getBranch() > 0) {
                    $data['branches'][] = $this->em->findBranch($this->account()->getBranch());
                    $data['accounts'] = $this->branchesapi->getBranchAccounts(
                        $this->account()->getCompany()->getCompanyId(),
                        $this->account()->getBranch()
                    );
                } else {
                    $data['accounts'] = $this->branchesapi->getBranchAccounts(
                        $this->account()->getCompany()->getCompanyId(),
                        $this->account()->getBranch()
                    );
                }
            } else {
                $data['branches'] = [];
                $data['accounts'][] = $this->account();
            }
        }

        $this->html->addScript('dataTables');
        $this->html->addScript('scheduler');

        $action = $this->uri->segment(2);

        $this->html->addScript('ckeditor4');
        $this->load->model('clientEmail');
        $data['clientTemplates'] = $this->clientEmail->getTemplates(
            $this->account()->getCompany()->getCompanyId(),
            \models\ClientEmailTemplateType::PROPOSAL,
            true
        );

        $data['createdFilter'] = false;

        if ($this->uri->segment(7) == 'sf' || $this->uri->segment(6) == 'sf' || $this->uri->segment(5) == 'sf' || $this->uri->segment(4) == 'sf') {
            $data['createdFilter'] = true;
        }

        switch ($action) {
            case 'status':
                $data['tableStatus'] = true;
                $data['groupUri'] = false;
                $data['statusUri'] = false;


                // Do we want to use the created date filter?
                if ($type == 'all' || $type == 'rollover') {
                    $data['createdFilter'] = true;
                }

                if ($this->uri->segment(3) == 'group') {
                    $data['statusUri'] = $groupUri = str_replace('/status/group/', '/status/', current_url());
                    $data['statusAction'] = 'group';
                    $data['group'] = 'group';
                } else {
                    $data['groupUri'] = str_replace('/status/', '/status/group/', current_url());
                    $data['statusAction'] = false;
                }

                if ($data['createdFilter']) {
                    $this->session->set_userdata('pStatusFilterCreate', '1');
                } else {
                    $this->session->set_userdata('pStatusFilterCreate', '');
                }

                $this->load->view('proposals/index-status', $data);
                break;

            case 'group':
                $data['group'] = 'group';
                $this->load->view('proposals/index', $data);
                break;

            case 'search':
                $data['action'] = 'search';
                $data['search'] = $this->input->post('searchProposal');
                $this->load->view('proposals/index', $data);
                break;

            case 'clientProposals':
                $data['client'] = $this->uri->segment(3);
                $data['clientCompany'] = $this->em->find('\models\Clients', $data['client'])->getFullName();
                $this->load->view('proposals/index', $data);
                break;

            default:
                $this->load->view('proposals/estimates', $data);
                break;
        }
    }

    public function group_resends()
    {
        $data['resends'] = $this->getEstimationRepository()->getCompanyResendList($this->account()->getCompany(), $this->account());
        $this->html->addScript('ckeditor4');
        $this->load->model('clientEmail');
        $data['clientTemplates'] = $this->clientEmail->getTemplates(
            $this->account()->getCompany()->getCompanyId(),
            \models\ClientEmailTemplateType::PROPOSAL,
            true
        );

        $data['account'] = $this->account();
        $data['layout'] = 'account/my_account/group_resends';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account/group_resends', $data);
    }

    public function stats()
    {

        $userId = $this->uri->segment(4);

        $clientCompanyId = $this->uri->segment(3);
        $checkUser = false;
        $statusId = '';

        // Let admins & full access view other users from same company
        // print_r(is_numeric($statusId));die;
        $this->session->set_userdata('pStatsFilterStatusNameShow', '');
        $this->session->set_userdata('pStatsFilterStatusId', '');
        $this->session->set_userdata('pStatsFilterStatusName', '');
        $this->session->set_userdata('pWon', '');
        $this->session->set_userdata('pWonRate', '');
        $this->session->set_userdata('pStatsFilterClientAccount', '');
        $this->session->set_userdata('pStatsFilterBusinessType', '');
        $this->session->set_userdata('pStatsFilterAccountsType', '');
        $this->session->set_userdata('pStatsFilterBranchId', '');
        $this->session->set_userdata('pStatsFilterUser', '');
        $this->session->set_userdata('pStatsFilterUserName', '');
        if (is_numeric($clientCompanyId)) {
            $this->session->set_userdata('pStatsFilterClientAccount', $clientCompanyId);

            $checkUser = true;
        } else {
            $business_type_id = str_replace('type_', '', $clientCompanyId);
            $this->session->set_userdata('pStatsFilterBusinessType', $business_type_id);
            if (is_numeric($userId)) {
                $checkUser = true;
            } else {
                if ($userId == 'user') {
                    if ($this->uri->segment(5) == 'company') {
                        $this->session->set_userdata('pStatsFilterAccountsType', 'company');
                    } else {
                        $this->session->set_userdata('pStatsFilterAccountsType', 'branch');
                        $branch_id = str_replace('branch_', '', $this->uri->segment(5));

                        if ($branch_id == 0) {
                            $this->session->set_userdata('pStatsFilterBranchName', 'Main Branch');
                        } else {
                            $branch = $this->em->find('models\Branches', $branch_id);
                            $this->session->set_userdata('pStatsFilterBranchName', $branch->getBranchName());
                        }
                        $this->session->set_userdata('pStatsFilterBranchId', $branch_id);
                    }
                }
                $statusId = $this->uri->segment(6);
            }
        }

        if ($checkUser) {
            if($userId){
                            
            $statsUser = $this->em->find('\models\Accounts', $userId);
            $statsCompanyId = $statsUser->getCompany()->getCompanyId();

            $this->session->set_userdata('pStatsFilterUser', $userId);
            $this->session->set_userdata('pStatsFilterUserName', $statsUser->getFullName());
            $statusId = $this->uri->segment(5);
            }
        }


        if ($statusId) {
            if (is_numeric($statusId)) {
                $status = $this->em->find('\models\Status', $statusId);
                $this->session->set_userdata('pStatsFilterStatusId', $statusId);
                $this->session->set_userdata('pStatsFilterStatusNameShow', $status->getText());
                $this->session->set_userdata('pSold', '');
            } else {
                $this->session->set_userdata('pStatsFilterStatusName', $statusId);
                if ($statusId == 'won') {
                    $this->session->set_userdata('pWon', 1);
                } elseif ($statusId == 'won_rate') {
                    $this->session->set_userdata('pWonRate', 1);
                    $this->session->set_userdata('pStatsFilterStatusName', 'won');
                }
            }
        }
        $this->session->set_userdata('pStatsFilterFrom', $this->session->userdata('pStatusFilterFrom'));
        $this->session->set_userdata('pStatsFilterTo', $this->session->userdata('pStatusFilterTo'));
        $this->session->set_userdata('pStatsFilter', 1);

        $this->index();
    }

    public function account_stats()
    {

        // $statusId = $this->uri->segment(4);
        // $clientCompanyId = $this->uri->segment(3);
        $userId = $this->uri->segment(4);
        $statusId = $this->uri->segment(5);

        $clientCompanyId = $this->uri->segment(3);

        $this->session->set_userdata('pStatsFilterClientAccount', $clientCompanyId);

        $this->session->set_userdata('pAccStatsFilterStatusNameShow', '');
        $this->session->set_userdata('pAccStatsFilterStatusId', '');
        $this->session->set_userdata('pAccStatsFilterStatusName', '');
        $this->session->set_userdata('pAccStatsFilterUser', '');
        $this->session->set_userdata('pAccFilterBusinessType', '');
        $this->session->set_userdata('pAccFilterBusinessTypeName', '');
        $this->session->set_userdata('pWon', '');
        $this->session->set_userdata('pWonRate', '');


        if ($statusId) {
            if (is_numeric($statusId)) {
                $status = $this->em->find('\models\Status', $statusId);
                $this->session->set_userdata('pAccStatsFilterStatusId', $statusId);
                $this->session->set_userdata('pAccStatsFilterStatusNameShow', $status->getText());
            } else {
                $this->session->set_userdata('pAccStatsFilterStatusName', $statusId);
                if ($statusId == 'won') {
                    $this->session->set_userdata('pWon', 1);
                } elseif ($statusId == 'won_rate') {
                    $this->session->set_userdata('pWonRate', 1);
                    $this->session->set_userdata('pAccStatsFilterStatusName', 'won');
                }
                // $this->session->set_userdata('pAccStatsFilterStatusName', $statusId);
            }
        }

        if (is_numeric($userId)) {
            if ($userId != 0) {
                $user = $this->em->find('\models\Accounts', $userId);
                $statsUsers[] = $user->getFullName();
                $this->session->set_userdata('pAccStatsFilterUser', [$userId]);
                $this->session->set_userdata('pAccStatsFilterUserNames', $statsUsers);
            } elseif ($this->session->userdata('accFilterAUser')) {
                $users = $this->session->userdata('accFilterAUser');
                $statsUsers = [];
                foreach ($users as $uid) {
                    $user = $this->em->find('\models\Accounts', $uid);
                    $statsUsers[] = $user->getFullName();
                }
                $this->session->set_userdata('pAccStatsFilterUser', $users);
                $this->session->set_userdata('pAccStatsFilterUserNames', $statsUsers);
            }
        } else {
            $business_type_id = str_replace('type_', '', $userId);
            $business_type = $this->em->find('\models\BusinessType', $business_type_id);
            $this->session->set_userdata('pAccFilterBusinessType', $business_type_id);
            $this->session->set_userdata('pAccFilterBusinessTypeName', $business_type->getTypeName());
        }

        $this->session->set_userdata('pAccStatsFilter', 1);

        $this->index();
    }

    public function business_stats()
    {

        $userId = $this->uri->segment(4);
        $businessTypeId = $this->uri->segment(3);
        $statusId = $this->uri->segment(5);
        $statsUser = $this->em->find('\models\Accounts', $userId);
        $statsCompanyId = $statsUser->getCompany()->getCompanyId();

        $this->session->set_userdata('pStatsFilterUser', $userId);
        $this->session->set_userdata('pStatsFilterUserName', $statsUser->getFullName());
        $this->session->set_userdata('pStatsFilterBusinessType', $businessTypeId);
        // Let admins & full access view other users from same company
        // print_r(is_numeric($statusId));die;
        $this->session->set_userdata('pStatsFilterStatusNameShow', '');
        $this->session->set_userdata('pStatsFilterStatusId', '');
        $this->session->set_userdata('pStatsFilterStatusName', '');
        $this->session->set_userdata('pWon', '');
        if ($statusId) {
            if (is_numeric($statusId)) {
                $status = $this->em->find('\models\Status', $statusId);
                $this->session->set_userdata('pStatsFilterStatusId', $statusId);
                $this->session->set_userdata('pStatsFilterStatusNameShow', $status->getText());
                $this->session->set_userdata('pSold', '');
            } else {
                if ($statusId == 'won') {
                    $this->session->set_userdata('pWon', 1);
                }
                $this->session->set_userdata('pStatsFilterStatusName', $statusId);
            }
        }

        $this->session->set_userdata('pStatsFilter', 1);

        $this->index();
    }

    public function get_preset_from_dates($startDate, $endDate)
    {


        $preset = 'custom';
        $yesterday = Carbon::now()->subDays(1)->format('m/d/Y');
        if ($startDate == $yesterday && $endDate == $yesterday) {
            $preset = 'Yesterday';
        } elseif ($startDate == Carbon::now()->subDays(7)->format('m/d/Y') && $endDate == Carbon::now()->format('m/d/Y')) {
            $preset = 'Last 7 Days';
        } elseif ($startDate == Carbon::now()->startOfMonth()->format('m/d/Y') && $endDate == Carbon::now()->format('m/d/Y')) {
            $preset = 'Month To Date';
        } elseif ($startDate == Carbon::now()->startOfMonth()->subMonth()->format('m/d/Y') && $endDate == Carbon::now()->subMonth()->endOfMonth()->format('m/d/Y')) {
            $preset = 'Previous Month';
        } elseif ($startDate == Carbon::now()->startOfYear()->format('m/d/Y') && $endDate == Carbon::now()->format('m/d/Y')) {
            $preset = 'Year To Date';
        } elseif ($startDate == Carbon::now()->startOfYear()->subYear(1)->format('m/d/Y') && $endDate == Carbon::now()->endOfYear()->subYear(1)->format('m/d/Y')) {
            $preset = 'Previous Year';
        }

        return $preset;
    }

    /*
     *  Display a map with approx geolocation info
     */
    public function ipMap($ip)
    {
        $httpClient = new Symfony\Component\HttpClient\Psr18Client();
        $psr17Factory = new Nyholm\Psr7\Factory\Psr17Factory();
        $ipdata = new Ipdata\ApiClient\Ipdata($_ENV['IPDATA_KEY'], $httpClient, $psr17Factory);

        $data = $ipdata->lookup($ip);
        if ($data['status'] != 200) {
            echo '<div style="position: absolute;top: 45%;left: 45%;">Map Not Available for current Ip</div>';
            exit;
        }

        // Render the view
        $this->load->view('templates/proposals/map/ipMap', $data);
    }

    public function wonDate(){
        $allStatuses = $this->account()->getStatuses();
        $statusCollection = [];
        $wonStatusCollection = [];
        $prospectStatusCollection = [];
        foreach ($allStatuses as $allStatus) {
            if ($allStatus->isProspect()) {
                $prospectStatusCollection[] = $allStatus;
            }else if ($allStatus->getStatusId() ==2) {
                foreach ($allStatuses as $allWonStatus) {
                    if ($allWonStatus->isSales() ) {
                        if ($allWonStatus->getStatusId() !=2) {
                        $wonStatusCollection[] = $allWonStatus;
                        }
                    }
                }
                $allStatus->WonChilds = $wonStatusCollection;
                $statusCollection[] = $allStatus;
            } else {
                if (!$allStatus->isSales()) {
                    $statusCollection[] = $allStatus;
                }
            }
        }

        $proposal_id="196237";
       // $proposal = $this->em->findProposal($proposal_id);
       $sqlQuery = "SELECT * from proposals 
       WHERE  proposalId= $proposal_id";

       $proposal = $this->db->query($sqlQuery)->result(); 
        echo "<pre>";
        print_r($proposal);
       echo "<pre>";print_r($statusCollection);die;
       
    }
 
}
