<?php

use \Carbon\Carbon;
use \models\EstimationCategory;
use \models\EstimationItem;
use \models\EstimationType;
use models\AdminGroupResend;
use models\AdminGroupResendEmail;

class Admin extends MY_Controller
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    var $em;
    /**
     * @var Settings
     */
    var $settings;
    /**
     * @var ClientEmail
     */
    var $clientEmail;
    protected $accountData;
    var $leads;
    /**
     * @var System_email
     */
    var $system_email;
    /**
     * @var ClientEmail
     */
    var $clientEmal;
    /**
     * @var CI_Session
     */
    var $session;

    function __construct()
    {
        parent::__construct();
        if (!$this->session->userdata('logged')) {
            $this->session->set_flashdata('error', 'You must be logged in to view this page!');
            redirect('home/signin');
        }
        $this->accountData = NULL;
        $account = $this->account();
        if (!$account->isGlobalAdministrator()) {
            $this->session->set_flashdata('error', 'You do not have sufficient privileges to access this page!');
            redirect('home');
        }
    }

    function index()
    {
        $data = [];
        $this->load->model('clientEmail');
        $data['emailTemplates'] = $this->clientEmail->getTemplates(NULL, \models\ClientEmailTemplateType::GLOB);
        $data['templateFields'] = $this->clientEmail->getTemplateFields(\models\ClientEmailTemplateType::GLOB);
        $data['resends'] = $this->getCompanyRepository()->getAdminResendList($this->account()->getCompany());
        $this->html->addScript('dataTables');
        $this->html->addScript('ckeditor4');
        $data['resendId'] = $this->uri->segment(3) ?: '';
        $data['campaignEmailFilter'] = $this->uri->segment(4) ?: '';
        $data['filterResend'] = false;
        $data['show_last_activity'] = 'true';
        $data['show_opened_at'] = 'false';
        if ($this->uri->segment(2) == 'resend') {
            $data['filterResend'] = true;
            $data['show_last_activity'] = 'false';
            $data['show_opened_at'] = 'true';
            $data['resend'] = $this->em->find('models\AdminGroupResend', $data['resendId']);
            $data['resendStats'] = $this->getCompanyRepository()->getAdminResendStats($data['resend']);
            $data['child_resends'] = $this->getCompanyRepository()->getAdminChildResend($data['resendId']);
            //print_r($data['resend']);die;
            //$this->load->view('leads/index-resend', $data);
            $this->load->view('admin/dashboard_resend', $data);

        } else {
            $this->load->view('admin/dashboard', $data);
        }

    }


    function sendEmail()
    {
        $data = $_POST;
        $data['account_id'] = $this->account()->getAccountId();

        $this->load->library('jobs');

        // Queue the job with all the data
        $this->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'group_admin_email_send', $data, 'test job');

        $this->load->library('JsonResponse');
        $response = new JsonResponse();
        $response->success = 1;
        $response->count = 0;
        $response->send();
    }

    function adminResendUnopened()
    {
        $data = $_POST;
        $data['account_id'] = $this->account()->getAccountId();

        $this->load->library('jobs');

        // Queue the job with all the data
        $this->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'group_admin_unopened_email_send', $data, 'test job');

        $this->load->library('JsonResponse');
        $response = new JsonResponse();
        $response->success = 1;
        $response->count = 0;
        $response->send();
    }

    function filterStatus()
    {

        $newValue = $this->input->post('status');

        if ($newValue) {
            $this->session->set_userdata('adminStatusFilter', $newValue);
        } else {
            $this->session->set_userdata('adminStatusFilter', NULL);
            $this->session->unset_userdata('adminStatusFilter');
        }
    }

    function filterExpired()
    {
        $newValue = $this->input->post('status');

        if ($newValue) {
            $this->session->set_userdata('adminStatusExpiredFilter', $newValue);
        } else {
            $this->session->set_userdata('adminStatusExpiredFilter', NULL);
            $this->session->unset_userdata('adminStatusExpiredFilter');
        }
    }

    function dashboard()
    {
        $data = array();
        $query = $this->em->createQuery('SELECT COUNT(c.companyId) FROM models\Companies c');
        $count = $query->getSingleScalarResult();
        $data['companiesstats'] = $count;
        $query = $this->em->createQuery("SELECT COUNT(c.companyId) FROM models\Companies c where c.companyStatus = 'Active'");
        $count = $query->getSingleScalarResult();
        $data['companiesActive'] = $count;
        $query = $this->em->createQuery("SELECT COUNT(c.companyId) FROM models\Companies c where c.companyStatus = 'Trial'");
        $count = $query->getSingleScalarResult();
        $data['companiesTrial'] = $count;
        $query = $this->em->createQuery("SELECT COUNT(c.companyId) FROM models\Companies c where c.companyStatus = 'Inactive'");
        $count = $query->getSingleScalarResult();
        $data['companiesInactive'] = $count;
        $query = $this->em->createQuery("SELECT COUNT(c.companyId) FROM models\Companies c where c.companyStatus = 'Test'");
        $count = $query->getSingleScalarResult();
        $data['companiesTest'] = $count;
        $query = $this->em->createQuery('SELECT COUNT(a.accountId) FROM models\Accounts a');
        $count = $query->getSingleScalarResult();
        $data['accounts'] = $count;
        $query = $this->em->createQuery('SELECT COUNT(p.proposalId) FROM models\Proposals p');
        $count = $query->getSingleScalarResult();
        $data['proposals'] = $count;
        $query = $this->em->createQuery('SELECT COUNT(c.clientId) FROM models\Clients c');
        $count = $query->getSingleScalarResult();
        $data['clients'] = $count;
        $query = $this->em->createQuery("SELECT COUNT(p.proposalId) FROM models\Proposals p where p.status = 'Open'");
        $count = $query->getSingleScalarResult();
        $data['proposals_open'] = $count;
        $query = $this->em->createQuery("SELECT COUNT(p.proposalId) FROM models\Proposals p where p.status = 'Won'");
        $count = $query->getSingleScalarResult();
        $data['proposals_won'] = $count;
        $query = $this->em->createQuery("SELECT COUNT(p.proposalId) FROM models\Proposals p where p.status = 'Completed'");
        $count = $query->getSingleScalarResult();
        $data['proposals_completed'] = $count;
        $query = $this->em->createQuery("SELECT COUNT(p.proposalId) FROM models\Proposals p where p.status = 'Lost'");
        $count = $query->getSingleScalarResult();
        $data['proposals_lost'] = $count;
        $query = $this->em->createQuery("SELECT COUNT(p.proposalId) FROM models\Proposals p where p.status = 'Cancelled'");
        $count = $query->getSingleScalarResult();
        $data['proposals_cancelled'] = $count;
        $query = $this->em->createQuery("SELECT COUNT(p.proposalId) FROM models\Proposals p where p.status = 'On Hold'");
        $count = $query->getSingleScalarResult();
        $data['proposals_on_hold'] = $count;
        $this->html->addJS(site_url('3rdParty/easypiechart/jquery.easypiechart.min.js'));
        $this->html->addCSS(site_url('3rdParty/easypiechart/jquery.easypiechart.css'));
        $this->load->view('admin/dashboard-new', $data);
    }

    function companies()
    {
        $data = array();
        $query = $this->em->createQuery('SELECT c FROM models\Companies c');
        $data['companies'] = $query->getResult();
        $this->load->view('admin/companies', $data);
    }

    function edit_company()
    {
        $data = array();
        $company = $this->em->find('models\Companies', $this->uri->segment(3));
        if (!$company) {
            $this->session->set_flashdata('success', 'Invalid company ID!');
            redirect('admin');
        }
        $this->load->library('form_validation');
        if ($this->input->post('updateCompany')) {
            $this->form_validation->set_rules('companyName', 'Company Name', 'required');
            $this->form_validation->set_rules('companyAddress', 'Company Address', 'required');
            $this->form_validation->set_rules('companyPhone', 'Company Phone', 'required');
            $this->form_validation->set_rules('companyCity', 'Company City', 'required');
            $this->form_validation->set_rules('companyCountry', 'Company Country', 'required');
            $this->form_validation->set_rules('companyState', 'Company State', 'required');
            $this->form_validation->set_rules('companyZip', 'Company Zip', 'required');
        }
        if ($this->form_validation->run()) {
            if ($this->input->post('updateCompany')) {
                $company->setCompanyName($this->input->post('companyName'));
                $company->setCompanyAddress($this->input->post('companyAddress'));
                $company->setCompanyWebsite($this->input->post('companyWebsite'));
                $company->setCompanyPhone($this->input->post('companyPhone'));
                $company->setCompanyCity($this->input->post('companyCity'));
                $company->setCompanyCountry($this->input->post('companyCountry'));
                $company->setCompanyState($this->input->post('companyState'));
                $company->setCompanyState($this->input->post('companyState'));
                $company->setAlternatePhone($this->input->post('alternatePhone'));
                $company->setAboutCompany($this->input->post('aboutCompany'));
                $company->setContractCopy($this->input->post('contractCopy'));
                $this->em->persist($company);
                $this->em->flush();
                $this->session->set_flashdata('success', 'Company information updated succesfully!');
                redirect('admin/edit_company/' . $this->uri->segment(3));
            }
        }
        $data['company'] = $company;
        $this->load->view('account/edit_company', $data);
    }

    function accounts()
    {
        $data = array();
        if ($this->uri->segment(3)) {
            $company = $this->em->find('models\Companies', $this->uri->segment(3));
            if (!$company) {
                $this->session->set_flashdata('success', 'Invalid company ID!');
                redirect('admin');
            }
            $query = $this->em->createQuery('SELECT a FROM models\Accounts a where a.company is not NULL and a.parent_user_id =0 and a.company=' . $this->uri->segment(3) . ' ORDER BY a.expires ASC');
        } else {
            $query = $this->em->createQuery('SELECT a FROM models\Accounts a where a.company is not NULL and a.parent_user_id =0');
        }

        $data['accounts'] = $query->getResult();
        $data['company'] = $company;
        $data['firstExpiry'] = Carbon::createFromTimestamp($data['accounts'][0]->getExpires())->addYear()->format('m/d/Y');

        $this->html->addScript('dataTables');
        $this->load->view('admin/accounts', $data);
    }

    function super_accounts()
    {
        $data = array();
        if ($this->uri->segment(3)) {
            $company = $this->em->find('models\Companies', $this->uri->segment(3));
            if (!$company) {
                $this->session->set_flashdata('success', 'Invalid company ID!');
                redirect('admin');
            }

            $query = $this->em->createQuery('SELECT a FROM models\Accounts a where a.company is not NULL and (a.company=' . $this->uri->segment(3) . ' OR a.parent_company_id =' . $this->uri->segment(3) . ') ORDER BY a.expires ASC');
        } else {
            $query = $this->em->createQuery('SELECT a FROM models\Accounts a where a.company is not NULL');
        }
       
        $data['accounts'] = $query->getResult();
       //print_r($data['accounts']);die;
        $data['company'] = $company;
        $data['firstExpiry'] = Carbon::createFromTimestamp($data['accounts'][0]->getExpires())->addYear()->format('m/d/Y');

        $this->html->addScript('dataTables');
        $this->load->view('admin/super_accounts', $data);
    }

    /**
     * @deprecated not used anymore
     */
    function edit_account()
    {
        $account = $this->em->find('models\Accounts', $this->uri->segment(3));
        if (!$account) {
            $this->session->set_flashdata('success', 'Invalid account ID!');
            redirect('admin');
        }
        $this->load->helper('form');
        $this->load->library('form_validation');
        $this->form_validation->set_rules('firstName', 'First Name', 'required');
        $this->form_validation->set_rules('lastName', 'Last Name', 'required');
        $this->form_validation->set_rules('cellPhone', 'Cell Phone', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('zip', 'Zip Code', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');
        $this->form_validation->set_rules('timeZone', 'Time Zone', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'min_length[4]|max_length[15');
        if ($this->form_validation->run()) {
            //check if the email is changed...
            if ($this->input->post('email') != $account->getEmail()) {
                $testAcc = $this->em->getRepository('models\Accounts')->findOneBy(array('email' => $this->input->post('email')));
                if ($testAcc) {
                    $this->session->set_flashdata('error', 'Email already in use!');
                    redirect('admin/edit_account/' . $this->uri->segment(3));
                } else {
                    $account->setEmail($this->input->post('email'));
                    $message = "
        Here is your new email:

        Email: {$this->input->post('email')}

        You can sign in here: " . site_url('home/signin');
                    //function deprecated
                    mail($this->input->post('email'), 'Email Change at Proposal Management System', $message, "From: Proposal Management Sysyem <no-reply@rapidinjection.com>\r\n");
                }
            }
            //check if the user is trying to imput limited access to admin user
            if (($this->input->post('fullAccess') == 'no') && ($account->isAdministrator())) {
                $this->session->set_flashdata('notice', 'The Administrator user account can not have limited access!');
            } else {
                $account->setFullAccess($this->input->post('fullAccess'));
            }
            //check if a new password is set up
            if ($this->input->post('password')) {
                $account->setPassword($this->input->post('password'));
                //function deprecated
                mail($account->getEmail(), 'New Password at PMS', 'Your new password is: ' . $this->input->post('password'), "From: Proposal Management Sysyem <noreply@pms2.rapidinjection.com>");
            }
            $account->setFirstName($this->input->post('firstName'));
            $account->setLastName($this->input->post('lastName'));
            $account->setTitle($this->input->post('title'));
            $account->setCellPhone($this->input->post('cellPhone'));
            $account->setAddress($this->input->post('address'));
            $account->setCity($this->input->post('city'));
            $account->setState($this->input->post('state'));
            $account->setZip($this->input->post('zip'));
            $account->setCountry($this->input->post('country'));
            $account->setTimeZone($this->input->post('timeZone'));
            $expDate = explode('/', $this->input->post('expires'));
            $expires = mktime(23, 59, 59, $expDate[0], $expDate[1], $expDate[2]);
            $account->setExpires($expires);
            $this->em->persist($account);
            $this->em->flush();
            $this->session->set_flashdata('success', 'User updated succesfully!');
            redirect('admin/edit_account/' . $this->uri->segment(3));
        }
        $data = array();
        $data['account'] = $account;
        $data['formaction'] = 'admin/edit_account/' . $account->getAccountId();
        $this->load->view('account/edit_account', $data);
    }

    function proposals()
    {
        $data = array();
        if ($this->uri->segment(3)) {
            $company = $this->em->find('models\Companies', $this->uri->segment(3));
            if (!$company) {
                $this->session->set_flashdata('success', 'Invalid company ID!');
                redirect('admin');
            }
            $query = $this->em->createQuery('SELECT p, c, cmp FROM models\Proposals p inner join p.client c inner join c.company cmp where (cmp.companyId = c.company) and (cmp.companyId = ' . $this->uri->segment(3) . ')');
        } else {
            $query = $this->em->createQuery('SELECT p, c FROM models\Proposals p join p.client c where p.client is not null');
        }
        $data['proposals'] = $query->getResult();
        $this->load->view('admin/proposals', $data);
    }

    function clients()
    {
        $data = array();
        if ($this->uri->segment(3)) {
            $company = $this->em->find('models\Companies', $this->uri->segment(3));
            if (!$company) {
                $this->session->set_flashdata('error', 'Invalid company ID!');
                redirect('admin');
            }
            $query = $this->em->createQuery('SELECT c FROM models\Clients c where c.company is not NULL and c.company=' . $this->uri->segment(3));
        } else {
            $query = $this->em->createQuery('SELECT c FROM models\Clients c');
        }
        $data['clients'] = $query->getResult();
        $this->load->view('admin/clients', $data);
    }

    function edit_client()
    {
        $client = $this->em->find('models\Clients', $this->uri->segment(3));
        if (!$client) {
            $this->session->set_flashdata('error', 'Contact does not exist!');
            redirect('admin/clients');
        }
        $this->load->library('form_validation');
        $this->form_validation->set_rules('firstName', 'First Name', 'required');
        $this->form_validation->set_rules('lastName', 'Last Name', 'required');
        $this->form_validation->set_rules('companyName', 'Company', 'required');
        //        $this->form_validation->set_rules('businessPhone', 'Business Phone', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('cellPhone', 'Cell Phone', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('zip', 'Zip Code', 'required');
        $this->form_validation->set_rules('country', 'Country', 'required');
        if ($this->form_validation->run()) {
            //                print_r($_POST);
            $client->setFirstName($this->input->post('firstName'));
            $client->setLastName($this->input->post('lastName'));
            $client->setCompanyName($this->input->post('companyName'));
            $client->setBusinessPhone($this->input->post('businessPhone'));
            $client->setEmail($this->input->post('email'));
            $client->setCellPhone($this->input->post('cellPhone'));
            $client->setFax($this->input->post('fax'));
            $client->setAddress($this->input->post('address'));
            $client->setCity($this->input->post('city'));
            $client->setZip($this->input->post('zip'));
            $client->setCountry($this->input->post('country'));
            $client->setTitle($this->input->post('title'));
            $client->setWebsite($this->input->post('website'));
            $client->setState($this->input->post('state'));
            if (($this->input->post('owner')) && ($this->account()->isAdministrator())) {
                $newOwner = $this->em->find('models\Accounts', $this->input->post('owner'));
                $client->setAccount($newOwner);
            }
            $client->setCompany($this->account()->getCompany());
            $this->em->persist($client);
            $this->em->flush();
            $this->session->set_flashdata('success', 'Contact edited succesfully!');
            redirect('admin/edit_client/' . $this->uri->segment(3));
        }
        $data['client'] = $client;
        $data['account'] = $this->account();
        $this->load->view('clients/edit', $data);
    }

    function user_activity()
    {
        $data = array();
        if ($this->uri->segment(3)) {
            $company = $this->em->find('models\Companies', $this->uri->segment(3));
            if (!$company) {
                header('Location: ' . site_url('admin/user_activity'));
            }
            $data['company'] = $company;
        }
        // if (!$this->uri->segment(3)) {
        //     $data['logs'] = $this->em->createQuery("select l from models\Log l order by l.logId desc")->setMaxResults(200)->getResult();
        // } else {
        //     $data['logs'] = $this->em->createQuery("select l from models\Log l where l.company=" . $this->uri->segment(3) . " order by l.logId desc")->setMaxResults(200)->getResult();
        // }
        //Action Types
        $q = 'SELECT aa FROM models\ActivityAction aa where aa.parent_id=0 order by aa.activity_action_name asc';
        
        $query = $this->em->createQuery($q);
        $actionTypes = $query->getResult();

        $data['actionTypes'] = $actionTypes;

        $q = 'SELECT aa FROM models\ActivityAction aa where aa.parent_id!=0 order by aa.activity_action_name asc';
        
        $query = $this->em->createQuery($q);
        $actions = $query->getResult();
        $data['actions'] = $actions;

        $this->html->addScript('proposalTracking');
        $this->html->addScript('dataTables');
        $this->load->view('admin/user_activity', $data);
    }
 
    function add_company()
    {
        $data = array();
        if ($this->input->post('addNewCompany')) {
            $account = new models\Accounts();
            $company = new models\Companies();
            $company->setStandardLayoutIntro('We are happy to present to you the following proposal for work to be performed. If you have any questions, please do not hesitate to call us.');
            $company->setCompanyName($this->input->post('companyName'));
            $company->setCompanyCountry($this->input->post('companyCountry'));
            $company->setCompanyAddress($this->input->post('companyAddress'));
            $company->setCompanyWebsite($this->input->post('companyWebsite'));
            $company->setCompanyCity($this->input->post('companyCity'));
            $company->setCompanyPhone($this->input->post('companyPhone'));
            $company->setCompanyState($this->input->post('companyState'));
            $company->setCompanyPhone($this->input->post('companyPhone'));
            $company->setAlternatePhone($this->input->post('alternatePhone'));
            $company->setCompanyZip($this->input->post('companyZip'));
            $company->setPaymentTerm(0);
            $company->setCompanyLogo('');
            $company->setHearAboutUs('Admin Created Account');
            $company->setPaymentTermText('I am authorized to approve and sign this project as described in this proposal as well as identified below with our payment terms and options.');
            $company->setAdministrator($account);
            $company->setCompanyStatus($this->input->post('companyStatus'));
            $account->setEmail($this->input->post('accountEmail'));
            //$account->setPassword($this->input->post('password'));    We're no longer setting passwords
            $account->setRecoveryCode();                            //  Set a code for the user to set their own instead
            $account->setFirstName($this->input->post('firstName'));
            $account->setLastName($this->input->post('lastName'));
            $account->setCountry($this->input->post('companyCountry'));
            $account->setCity($this->input->post('companyCity'));
            $account->setState($this->input->post('companyState'));
            $account->setTitle('Administrator');
            $account->setCellPhone($this->input->post('companyPhone'));
            $account->setFax($this->input->post('alternatePhone'));
            $account->setAddress($this->input->post('companyAddress'));
            $account->setZip($this->input->post('companyZip'));
            $account->setTimeZone('EST');
            $account->setCompany($company);
            $account->setFullAccess('yes');
            $account->setOfficePhone($this->input->post('companyPhone'));
            $account->setCreated(time());
            $expDate = explode('/', $this->input->post('expires'));
            $expires = mktime(23, 59, 59, $expDate[0], $expDate[1], $expDate[2]);
            $account->setExpires($expires);
            $account->unDelete();
            $this->em->persist($account);
            $this->em->persist($company);
            $this->em->flush();

            // Assign the default statuses to this company
            //$company->assignDefaultStatuses();
            // Assign the email Template
            //$company->assignEmailTemplates();
            //$account->sendNewCompanyEmail();

            // Create Residential Account
            $residentialAccount = new \models\ClientCompany();
            $residentialAccount->setName('Residential');
            $residentialAccount->setOwnerCompany($company);
            $residentialAccount->setOwnerUser($account);
            $residentialAccount->setCreated(time());
            $this->em->persist($residentialAccount);
            $this->em->flush();

            $this->session->set_flashdata('success', 'Company added successfully!');


            redirect('admin');
        }
        $this->load->view('admin/add_company', $data);
    }

    function add_account()
    {
        $company = $this->em->find('models\Companies', $this->uri->segment(3));
        if (!$company) {
            $this->session->set_flashdata('success', 'Invalid company ID!');
            redirect('admin');
        }
        $data = array();
        if ($this->input->post('addNewAccount')) {
            $account = new models\Accounts();
            $account->setEmail($this->input->post('accountEmail'));
            $account->setPassword($this->input->post('password'));
            $account->setFirstName($this->input->post('firstName'));
            $account->setLastName($this->input->post('lastName'));
            $account->setCompany($company);
            $account->setCountry($company->getCompanyCountry());
            $account->setCity($company->getCompanyCity());
            $account->setCellPhone($company->getCompanyPhone());
            $account->setOfficePhone($company->getCompanyPhone());
            $account->setAddress($company->getCompanyAddress());
            $account->setZip($company->getCompanyZip());
            $account->setTimeZone('EST');
            $account->setFullAccess('yes');
            $account->setCreated(time());
            $expDate = explode('/', $this->input->post('expires'));
            $expires = mktime(23, 59, 59, $expDate[0], $expDate[1], $expDate[2]);
            $account->setExpires($expires);
            $account->unDelete();
            $this->em->persist($account);
            $this->em->flush();
            $this->em->clear();
            $this->session->set_flashdata('success', 'Account added succesfully!');
            redirect('admin/add_account/' . $this->uri->segment(3));
        }
        $this->load->view('admin/add_account', $data);
    }

    function add_accounts()
    {
        $company = $this->em->find('models\Companies', $this->uri->segment(3));
        if (!$company) {
            $this->session->set_flashdata('success', 'Invalid company ID!');
            redirect('admin');
        }
        $accounts = array();
        for ($i = 1; $i <= $this->input->post('usersNumber'); $i++) {
            $accounts[$i] = new models\Accounts();
            $accounts[$i]->setEmail('setmeup@'.SITE_EMAIL_DOMAIN);
            $accounts[$i]->setPassword('password');
            $accounts[$i]->setFirstName('Account');
            $accounts[$i]->setLastName('Number #' + $i);
            $accounts[$i]->setCompany($company);
            $accounts[$i]->setCountry($company->getCompanyCountry());
            $accounts[$i]->setCity($company->getCompanyCity());
            $accounts[$i]->setState($company->getCompanyState());
            $accounts[$i]->setCellPhone($company->getCompanyPhone());
            $accounts[$i]->setOfficePhone($company->getCompanyPhone());
            $accounts[$i]->setAddress($company->getCompanyAddress());
            $accounts[$i]->setZip($company->getCompanyZip());
            $accounts[$i]->setTimeZone('EST');
            $accounts[$i]->setFullAccess('yes');
            $accounts[$i]->setCreated(time());
            $expDate = explode('/', $this->input->post('expires'));
            $expires = mktime(23, 59, 59, $expDate[0], $expDate[1], $expDate[2]);
            $accounts[$i]->setExpires($expires);
            $accounts[$i]->unDelete();
            $this->em->persist($accounts[$i]);
        }
        $this->em->flush();
        foreach ($accounts as $i => $account) {
            $accounts[$i]->setLastName('Number #' + $accounts[$i]->getAccountId());
            $accounts[$i]->setEmail('account' . $accounts[$i]->getAccountId() . '@'.SITE_EMAIL_DOMAIN);
        }
        $this->em->flush();
        $this->em->clear();
        $this->session->set_flashdata('success', 'Accounts added succesfully!');
        redirect('admin');
    }

    function make_administrator()
    {
        $account = $this->em->find('models\Accounts', $this->uri->segment(3));
        if (!$account) {
            $this->session->set_flashdata('error', 'Invalid account ID!');
            redirect('admin');
        }
        $company = $account->getCompany();
        if (!$company) {
            $this->session->set_flashdata('error', 'There was an error in retrieving the company for the selected account!');
            redirect('admin');
        }
        $company->setAdministrator($account);
        $this->em->persist($account);
        $this->em->flush();
        $this->session->set_flashdata('success', 'Account edited successfully!');
        redirect('admin/accounts/' . $company->getCompanyId());
    }

    function sublogin()
    {
        $account = $this->em->find('models\Accounts', $this->uri->segment(3));
        if (!$account) {
            $this->session->set_flashdata('error', 'Invalid account ID!');
            redirect('admin');
        }
        //set the session sublogin id
        $this->session->set_userdata('sublogin', $this->uri->segment(3));
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

    function delete_company()
    {
        //@todo Optimize this to include proposals and clients too
        $company = $this->em->find('models\Companies', $this->uri->segment(3));
        if (!$company) {
            $this->session->set_flashdata('error', 'Invalid company ID!');
            redirect('admin');
        }
        $users = $company->getAccounts();
        foreach ($users as $user) {
            $this->em->remove($user);
        }
        //to add later - proper deletion with DQL of everything
        $this->em->remove($company);
        $this->em->flush();
        $this->em->clear();
        $this->session->set_flashdata('success', 'Company deleted!');
        redirect('admin');
    }

    function deleteCompanyGroup()
    {
        print_r($_POST);
        if (is_array($this->input->post('companies'))) {
            foreach ($this->input->post('companies') as $companyId) {
                if ($companyId) {
                    $companyIdInt = intval($companyId);
                    $this->db->query("delete from companies where companyId = {$companyIdInt} limit 1");
                    $this->db->query("delete from accounts where company = {$companyIdInt}");
                }

            }
            $this->session->set_flashdata('success', count($this->input->post('companies')) . ' companies deleted!');
        }
    }

    function statistics()
    {
        $company = $this->em->find('models\Companies', $this->uri->segment(3));
        if (!$company) {
            $this->session->set_flashdata('success', 'Invalid company ID!');
            redirect('admin');
        }
        $query = $this->em->createQuery('SELECT COUNT(a.accountId) FROM models\Accounts a where a.company=' . $this->uri->segment(3));
        $data['accounts'] = $query->getSingleScalarResult();
        $query = $this->em->createQuery('SELECT count(p.proposalId) FROM models\Proposals p inner join p.client c inner join c.company cmp where (cmp.companyId = c.company) and (cmp.companyId = ' . $this->uri->segment(3) . ')');
        $data['proposals'] = $query->getSingleScalarResult();
        $query = $this->em->createQuery('SELECT count(c.clientId) FROM models\Clients c where c.company is not NULL and c.company=' . $this->uri->segment(3));
        $data['clients'] = $query->getSingleScalarResult();
        $query = $this->em->createQuery("SELECT count(p.proposalId) FROM models\Proposals p inner join p.client c inner join c.company cmp where (p.status='Won') and (cmp.companyId = c.company) and (cmp.companyId = " . $this->uri->segment(3) . ')');
        $data['proposals_won'] = $query->getSingleScalarResult();
        $query = $this->em->createQuery("SELECT count(p.proposalId) FROM models\Proposals p inner join p.client c inner join c.company cmp where (p.status='Open') and (cmp.companyId = c.company) and (cmp.companyId = " . $this->uri->segment(3) . ')');
        $data['proposals_open'] = $query->getSingleScalarResult();
        $query = $this->em->createQuery("SELECT count(p.proposalId) FROM models\Proposals p inner join p.client c inner join c.company cmp where (p.status='Lost') and (cmp.companyId = c.company) and (cmp.companyId = " . $this->uri->segment(3) . ')');
        $data['proposals_lost'] = $query->getSingleScalarResult();
        $query = $this->em->createQuery("SELECT count(p.proposalId) FROM models\Proposals p inner join p.client c inner join c.company cmp where (p.status='Cancelled') and (cmp.companyId = c.company) and (cmp.companyId = " . $this->uri->segment(3) . ')');
        $data['proposals_cancelled'] = $query->getSingleScalarResult();
        $query = $this->em->createQuery("SELECT count(p.proposalId) FROM models\Proposals p inner join p.client c inner join c.company cmp where (p.status='On Hold') and (cmp.companyId = c.company) and (cmp.companyId = " . $this->uri->segment(3) . ')');
        $data['proposals_on_hold'] = $query->getSingleScalarResult();
        $query = $this->em->createQuery("SELECT count(p.proposalId) FROM models\Proposals p inner join p.client c inner join c.company cmp where (p.status='Completed') and (cmp.companyId = c.company) and (cmp.companyId = " . $this->uri->segment(3) . ')');
        $data['proposals_completed'] = $query->getSingleScalarResult();
        $this->load->view('admin/company_statistics', $data);
    }

    function manage_items()
    {
        $items = $this->em->createQuery("select i from models\Items i order by i.ord")->getResult();
        if ($this->uri->segment(3)) {
            $selectedItem = $this->em->find('models\Items', $this->uri->segment(3));
            if (!$selectedItem) {
                $this->session->set_flashdata('error', 'Unexisting item!');
                redirect('admin/manage_items');
            } else {
                $data['selectedItem'] = $selectedItem;
            }
        }
        $data['items'] = $items;
        $this->load->view('admin/manage_items', $data);
    }

    function manage_services()
    {
        if ($this->input->post('add_service')) {

            $parentService = $this->em->findService($this->input->post('parent'));

            $serv = new \models\Services();
            $serv->setServiceName($this->input->post('serviceName'));
            $serv->setOrd(99);
            $serv->setParent($this->input->post('parent'));
            if ($parentService) {
                $serv->setTax($parentService->getTax());
            }
            $this->em->persist($serv);
            $this->em->flush();
            //Delete All Cache
            $this->doctrine->deleteSiteAllCache();
            
            $this->session->set_flashdata('success', 'New Service Added!');
            redirect('admin/manage_services');
        }
        $data = array();
        $data['categories'] = \models\Services::getCategories();
        $data['services'] = \models\Services::getAdminPopulatedCategories();
        $this->load->view('admin/manage_services', $data);
    }

    function updateServiceCategoryOrder()
    {
        $cats = array();
        foreach ($this->input->post('services') as $ord => $cat) {
            $cat = $this->em->find('models\Services', $cat);
            $cat->setOrd($ord);
            $cats[$cat->getServiceId()] = $cat;
            $this->em->persist($cats[$cat->getServiceId()]);
        }
        $this->em->flush();
    }

    function updateServiceFieldsOrder()
    {
        $fields = array();
        foreach ($this->input->post('fields') as $ord => $fId) {
            $field = $this->em->find('models\ServiceField', $fId);
            $field->setOrd($ord);
            $fields[$field->getFieldId()] = $field;
            $this->em->persist($fields[$field->getFieldId()]);
        }
        $this->em->flush();
    }

    function updateServiceTextsOrder()
    {
        $texts = array();
        foreach ($this->input->post('texts') as $ord => $tId) {
            $text = $this->em->find('models\ServiceText', $tId);
            $text->setOrd($ord);
            $texts[$text->getTextId()] = $text;
            $this->em->persist($texts[$text->getTextId()]);
        }
        $this->em->flush();
    }

    function delete_service($id)
    {
        $service = $this->em->find('models\Services', $id);
        $message = 'Service Deleted!';
        if ($service->getParent() == 0) {
            $message = 'Category Deleted!';
        }
        $this->em->remove($service);
        $this->em->flush();
        
        $this->session->set_flashdata('success', $message);
        redirect('admin/manage_services');
    }

    function editServiceCatName()
    {
        $id = str_replace('cat_', '', $this->input->post('id'));
        $cat = $this->em->find('models\Services', $id);
        $cat->setServiceName($this->input->post('value'));
        $this->em->persist($cat);
        $this->em->flush();
        //Delete All Cache
        $this->doctrine->deleteSiteAllCache();
        
        echo $this->input->post('value');
    }

    function edit_service($id)
    {
        $data = array();
        $service = $this->em->find('models\Services', $id);
        if (!$service) {
            $this->session->set_flashdata('error', 'Service not found!');
            redirect('admin/manage_services');
        }
        $data['category'] = $this->em->find('models\Services', $service->getParent());
        if ($this->input->post('add_field')) {
            $field = new \models\ServiceField();
            $field->setOrd(99);
            $field->setService($service->getServiceid());
            $field->setFieldName($this->input->post('fieldName'));
            $field->setFieldCode(str_replace(' ', '_', preg_replace("/[^ \w]+/", "", strtolower($this->input->post('fieldCode')))));
            $field->setFieldType($this->input->post('fieldType'));
            $field->setFieldValue($this->input->post('fieldValue'));
            $this->em->persist($field);
            $this->em->flush();
            $this->em->clear();
            $this->session->set_flashdata('success', 'Field Added!');
            redirect('admin/edit_service/' . $service->getServiceId());
        }
        if ($this->input->post('save_field')) {
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
                $this->session->set_flashdata('success', 'Field Edited!');
            }
            redirect('admin/edit_service/' . $service->getServiceId());
        }
        if ($this->input->post('add_text')) {
            if ($this->input->post('addTextText')) {
                $text = new \models\ServiceText();
                $text->setService($service->getServiceId());
                $text->setCompany(0);
                $text->setOrd(99);
                $text->setText($this->input->post('addTextText'));
                $this->em->persist($text);
                $this->em->flush();
                $this->session->set_flashdata('success', 'Text Added!');
            } else {
                $this->session->set_flashdata('error', 'You must submit a text!');
            }
            redirect('admin/edit_service/' . $service->getServiceId());
        }
        if ($this->input->post('edit_text')) {
            $text = $this->em->find('models\ServiceText', $this->input->post('editTextId'));
            if (!$text) {
                $this->session->set_flashdata('error', 'Text not found!');
            } else {
                if ($this->input->post('editServiceText')) {
                    $text->setText($this->input->post('editServiceText'));
                    $this->em->persist($text);
                    $this->em->flush();
                    $this->session->set_flashdata('success', 'Text Edited!');
                } else {
                    $this->session->set_flashdata('error', 'You must submit a text!');
                }
            }
            redirect('admin/edit_service/' . $service->getServiceId());
        }
        $fields = $service->getDefaultFields();
        $data['fields'] = $fields;
        $texts = $service->getDefaultTexts();
        $data['texts'] = $texts;
        $data['service'] = $service;
        $this->load->view('admin/edit_service', $data);
    }

    function get_field_info($id = 0)
    {
        $fieldArray = array();
        $field = $this->em->find('models\ServiceField', $id);
        $fieldArray['fieldName'] = $field->getFieldName();
        $fieldArray['fieldCode'] = $field->getFieldCode();
        $fieldArray['fieldType'] = $field->getFieldType();
        $fieldArray['fieldValue'] = $field->getFieldValue();
        $fieldArray['fieldId'] = $field->getFieldId();
        echo json_encode($fieldArray);
    }

    function get_service_text($id)
    {
        $text = $this->em->find('models\ServiceText', $id);
        if ($text) {
            echo $text->getText();
        }
    }

    function delete_service_field($id)
    {
        $field = $this->em->find('models\ServiceField', $id);
        $service = $field->getService();
        $message = 'Field Deleted!';
        $this->em->remove($field);
        $this->em->flush();
        $this->session->set_flashdata('success', $message);
        redirect('admin/edit_service/' . $service);
    }

    function delete_service_text($id)
    {
        $text = $this->em->find('models\ServiceText', $id);
        $service = $text->getService();
        $message = 'Text Deleted!';
        $this->em->remove($text);
        $this->em->flush();
        $this->session->set_flashdata('success', $message);
        redirect('admin/edit_service/' . $service);
    }

    function rebuild_proposals()
    {
        if (!$this->uri->segment(3)) {
            $this->load->database();
            $this->db->query('update proposals set rebuildFlag = 1 where rebuildFlag = 0;');
            $this->session->set_flashdata('success', 'All proposals flagged for rebuild!!');
        } else {
            $proposals = $this->em->createQuery('SELECT p, c, cmp FROM models\Proposals p inner join p.client c inner join c.company cmp where (p.rebuildFlag=0) and (cmp.companyId = c.company) and (cmp.companyId = ' . $this->uri->segment(3) . ')')->getResult();
            foreach ($proposals as $proposal) {
                $proposal->setRebuildFlag(1, false, false);
                $this->em->persist($proposal);
            }
            $this->em->flush();
            $this->em->clear();
            $this->session->set_flashdata('success', 'All company proposals flagged for rebuild!!');
        }
        redirect('admin');
    }

    function getItemDetails()
    {
        $item = $this->em->find('models\Items', $this->uri->segment(3));
        if (!$item) {
            echo json_encode(array('success' => 'false'));
        } else {
            $itemFields = array();
            $fields = $item->getFields();
            foreach ($fields as $field) {
                $itemFields[$field->getFieldLabel()] = $field->getFieldName();
            }
            echo json_encode(array(
                'success' => 'true',
                'fields' => $itemFields,
                'itemText' => $item->getItemText(),
                'itemTextParsed' => array(),
            ));
        }
    }

    function custom_texts()
    {
        $data = array();
        $data['company'] = 0;
        $cats = $this->em->createQuery('SELECT c FROM models\Customtext_categories c  where (c.company=0)')->getResult();
        $categories = array();
        foreach ($cats as $cat) {
            $categories[$cat->getCategoryId()] = $cat;
        }
        $data['categories'] = $categories;
        $data['texts'] = $this->em->createQuery('SELECT t FROM models\Customtext t  where (t.company=0) order by t.ord')->getResult();
        $this->load->view('admin/edit_customtexts', $data);
    }

    function add_customtext()
    {
        $data = array();
        if (!$this->input->post('category') || !$this->input->post('text') || !$this->input->post('checked')) {
            $data['error'] = 'All fields are required!';
        } else {
            $category = $this->em->find('models\Customtext_categories', $this->input->post('category'));

            if ($category) {
                //add text in the admin
                $texts = array();
                $texts[0] = new models\Customtext();
                $texts[0]->setCategory($this->input->post('category'));
                $texts[0]->setCompany(0);
                $texts[0]->setOrd(100);
                $texts[0]->setChecked($this->input->post('checked'));
                $texts[0]->setText($this->input->post('text'));
                $this->em->persist($texts[0]);
                $companies = $this->em->createQuery('SELECT c FROM models\Companies c')->getResult();
                $k = 0;
                foreach ($companies as $company) {
                    $k++;
                    $companyId = $company->getCompanyId();
                    $categoryName = $category->getCategoryName();
                    //check if the category exists
                    $cats = $this->em->createQuery('SELECT c FROM models\Customtext_categories c  where (c.company=' . $companyId . ') and (c.categoryName =\'' . $categoryName . '\')')->getResult();
                }
                $this->em->flush();

                $this->session->set_flashdata('success', 'Text Added!');
                $this->session->set_flashdata('category_open', $this->input->post('category'));
            } else {
                $data['error'] = 'Category not found!';
                $data = array_merge($data, $_POST);
            }
        }
        echo json_encode($data);
    }

    function add_customtext_cat()
    {
        $data = array();
        if (!$this->input->post('category')) {
            $data['error'] = 'You must provide a category name!';
        } else {
            $cat = new models\Customtext_categories();
            $cat->setCategoryName($this->input->post('category'));
            $company = 0;
            if ($this->uri->segment(1) == 'account') {
                $company = $this->account()->getCompany()->getCompanyId();
            }
            $cat->setCompany($company);
            $this->em->persist($cat);
            $this->em->flush();
            $this->session->set_flashdata('success', 'Category added!');
        }
        echo json_encode($data);
    }

    function get_customtext()
    {
        $data = array();
        $text = $this->accountData = $this->em->find('models\Customtext', $this->uri->segment(3));
        if (!$text) {
            $data['error'] = 'Text not found!';
        } else {
            $data['category'] = $text->getCategory();
            $data['text'] = $text->getText();
            $data['checked'] = $text->getChecked();
        }
        echo json_encode($data);
    }

    function get_customtext_cat()
    {
        $data = array();
        $cat = $this->accountData = $this->em->find('models\Customtext_categories', $this->uri->segment(3));
        if (!$cat) {
            $data['error'] = 'Category not found!';
        } else {
            $data['category'] = $cat->getCategoryName();
        }
        echo json_encode($data);
    }

    function edit_customtext_cat()
    {
        $data = array();
        $cat = $this->accountData = $this->em->find('models\Customtext_categories', $this->input->post('id'));
        if (!$cat) {
            $data['error'] = 'Category not found!';
        } else {
            $cat->setCategoryName($this->input->post('category'));
            $this->em->persist($cat);
            $this->em->flush();
            $this->session->set_flashdata('success', 'Category Edited Successfully!');
        }
        echo json_encode($data);
    }

    function edit_customtext()
    {
        $data = array();
        $text = $this->accountData = $this->em->find('models\Customtext', $this->input->post('id'));
        if (!$text) {
            $data['error'] = 'Text not found!';
        } else {
            $text->setCategory($this->input->post('category'));
            $text->setChecked($this->input->post('checked'));
            $text->setText($this->input->post('text'));
            $this->em->persist($text);
            $this->em->flush();
            $this->session->set_flashdata('success', 'Text Edited Successfully!');
        }
        echo json_encode($data);
    }

    function delete_customtext()
    {
        $text = $this->accountData = $this->em->find('models\Customtext', $this->uri->segment(3));
        if (!$text) {
            $this->session->set_flashdata('success', 'Text not found!');
        } else {
            $this->em->remove($text);
            $this->em->flush();
            $this->session->set_flashdata('success', 'Text Deleted Successfully!');
        }
    }

    function delete_customtext_cat()
    {
        $cat = $this->accountData = $this->em->find('models\Customtext_categories', $this->uri->segment(3));
        if (!$cat) {
            $this->session->set_flashdata('success', 'Category not found!');
        } else {
            $this->em->remove($cat);
            $this->em->flush();
//            $this->session->set_flashdata('success', 'Category Deleted Successfully!');
        }
//        redirect('admin/custom_texts');
    }

    function reorder_texts()
    {
        $k = 0;
        foreach ($_POST['text'] as $textId) {
            $k++;
            $text = $this->accountData = $this->em->find('models\Customtext', $textId);
            if ($text) {
                $text->setOrd($k);
            }
            $this->em->persist($text);
        }
        $this->em->flush();
        echo json_encode(array());
    }

    function exportAllUsers()
    {
        header("Content-Disposition: attachment; filename=pms-global-report.csv");
        header("Content-Type: text/csv");
        $s = array(',');
        $r = array('');
        echo 'First Name, Last Name, Title,  Email, Cell Phone, Office Phone, Type, User Class, Address, City, State, Zip, Company ID, Company Name, Company Phone, Company Fax, Company Address, Company City, Company State, Company Zip, Created, Expires, User Status, Company Status' . "\r\n";
        $allUsers = $this->em->createQuery('SELECT a FROM models\Accounts a where a.company IS NOT NULL')->getResult();
        foreach ($allUsers as $account) {
            $add = true;
            try {
                $company = $account->getCompany()->getCompanyName();
                $companyId = $account->getCompany()->getCompanyId();
            } catch (Exception $e) {
                $add = false;
            }
            if ($add) {
                $type = ($account->isAdministrator(true)) ? 'Administrator' : 'User';
                $userClass = $account->getUserClass('true');
                $userStatus = ($account->isExpired()) ? 'Expired' : 'Active';
                $companyStatus = $account->getCompany()->getCompanyStatus();
                echo str_replace($s, $r, $account->getFirstName()) . ',' .
                    str_replace($s, $r, $account->getLastName()) . ',' .
                    str_replace($s, $r, $account->getTitle()) . ',' .
                    str_replace($s, $r, $account->getEmail()) . ',' .
                    str_replace($s, $r, $account->getCellPhone()) . ',' .
                    str_replace($s, $r, $account->getOfficePhone()) . ',' .
                    $type . ',' .
                    $userClass . ',' .
                    str_replace($s, $r, $account->getAddress()) . ',' .
                    str_replace($s, $r, $account->getCity()) . ',' .
                    str_replace($s, $r, $account->getState()) . ',' .
                    str_replace($s, $r, $account->getZip()) . ',' .
                    str_replace($s, $r, $companyId) . ',' .
                    str_replace($s, $r, $company) . ',' .
                    str_replace($s, $r, $account->getCompany()->getCompanyPhone()) . ',' .
                    str_replace($s, $r, $account->getCompany()->getAlternatePhone()) . ',' .
                    str_replace($s, $r, $account->getCompany()->getCompanyAddress()) . ',' .
                    str_replace($s, $r, $account->getCompany()->getCompanyCity()) . ',' .
                    str_replace($s, $r, $account->getCompany()->getCompanyState()) . ',' .
                    str_replace($s, $r, $account->getCompany()->getCompanyZip()) . ',' .
                    str_replace($s, $r, $account->getCreated()) . ',' .
                    str_replace($s, $r, $account->getExpires(true)) . ',' .
                    $userStatus . ',' .
                    $companyStatus .

                    "\r\n";
            }
        }
    }

    function updateCompanyStatus()
    {
        $cr = $this->getCompanyRepository();

        $company = $this->accountData = $this->em->find('models\Companies', $this->input->post('id'));
        /* @var $company \models\Companies */
        $oldStatus = $company->getCompanyStatus();

        if ($company) {
            $company->setCompanyStatus($_POST['value']);
            $this->em->persist($company);
            $this->em->flush();
        }

        if ($oldStatus == 'Trial' && $_POST['value'] == 'Active') {
            $cr->createSubscription($company);
        }

        if ($_POST['value'] == "Inactive") {
            $cr->cancelCompanySubscriptions($company->getCompanyId());
        }

        echo $_POST['value'];
    }

    function saveCompanyGroupStatus()
    {
        if (is_array($this->input->post('companies'))) {
            foreach ($this->input->post('companies') as $companyId) {
                $this->db->query("update companies set companyStatus='" . $this->input->post('status') . "' where companyId=" . $companyId . ' limit 1');
            }
            $this->session->set_flashdata('success', 'Company status updated for ' . count($this->input->post('companies')) . ' companies!');
        }
    }

    function delete_user()
    {
        $account = $this->em->findAccount($this->uri->segment(3));
        if (!$account) {
            $this->session->set_flashdata('error', 'User Not found!');
            redirect('admin');
        }
        if ($this->account()->getAccountId() == $this->uri->segment(3)) {
            $this->session->set_flashdata('error', 'You are not allowed to delete your own user!');
            redirect('admin/accounts/' . $account->getCompany()->getCompanyId());
        }
        $newOwner = $account->getCompany()->getAdministrator();
        if (!$newOwner) {
            $this->session->set_flashdata('error', 'Error in finding the company admin!');
            redirect('admin/accounts/' . $account->getCompany()->getCompanyId());
        }

        // Transfer everything to admin
        $this->getAccountRepository()->reassignAll($account, $newOwner);

        $this->log_manager->add(\models\ActivityAction::DELETE_ACCOUNT, 'Account #' . $account->getAccountId() . ' deleted!');
        $account = $this->em->merge($account);
        $this->em->remove($account);
        $this->em->flush();
        $this->session->set_flashdata('success', 'User deleted!');
        redirect('admin/accounts/' . $newOwner->getCompany()->getCompanyId());
    }


    function delete_master_user()
    {
        $account = $this->em->findAccount($this->uri->segment(3));
        $masterCompanyId = $this->uri->segment(4);
        
        if (!$account) {
            $this->session->set_flashdata('error', 'User Not found!');
            redirect('admin');
        }
        
        $newOwner = $account->getCompany()->getAdministrator();
        if (!$newOwner) {
            $this->session->set_flashdata('error', 'Error in finding the company admin!');
            redirect('admin/super_accounts/' . $masterCompanyId);
        }

        $accountId = $account->getAccountId();
        if($account->getParentCompanyId() > 0 ){
            $account->setParentCompanyId(0);
            $account->setParentUserId(0);
            $account->setIsSuperUser(0);
            $this->em->persist($account);
            $this->em->flush();

            $deleteUserCompanyId = $account->getCompany()->getCompanyId();
            $otherUsers = $this->db->query("select * from accounts where company={$deleteUserCompanyId} AND parent_company_id = {$masterCompanyId}");
            $usersExist = $otherUsers->result();
            if(!$usersExist){
                //Delete Temp user
                $this->db->query("delete from companies_parent_child_ralations where parent_company_id={$masterCompanyId} and child_company_id={$deleteUserCompanyId}");
            }


        }else if($account->getCompany()->getCompanyId() == $masterCompanyId ){
            // Transfer everything to admin
            $this->getAccountRepository()->reassignAll($account, $newOwner);

            $this->log_manager->add(\models\ActivityAction::DELETE_ACCOUNT, 'Account #' . $account->getAccountId() . ' deleted!');
            $account = $this->em->merge($account);
    
            
            $this->em->remove($account);
            $this->em->flush();

        }
        
       //Delete Temp user
        $this->db->query("delete from accounts where parent_user_id={$accountId}");

        $this->session->set_flashdata('success', 'User deleted!');
        redirect('admin/super_accounts/' . $masterCompanyId);
    }

    function site_settings()
    {
        if ($this->input->post('save')) {
            $save_settings = array(
                'print_text' => $this->input->post('print_text')
            );
            foreach ($save_settings as $settingName => $settingValue) {
                $save_settings[$settingName] = $this->em->getRepository('models\Site_settings')->findOneBy(array('settingName' => $settingName));
                $save_settings[$settingName]->setSettingValue($settingValue);
                $this->em->persist($save_settings[$settingName]);
            }
            $this->em->flush();
            $this->em->clear();
            $this->session->set_flashdata('success', 'Settings Updated');
            redirect('admin/site_settings');
        }
        $settings = array();
        $sts = $this->em->getRepository('models\Site_settings')->findAll();
        foreach ($sts as $st) {
            $settings[$st->getSettingName()] = $st->getSettingValue();
        }
        $this->load->view('admin/site_settings', array('settings' => $settings));
    }

    function helpvideos()
    {
        $this->load->database();
        $data = array();
        $videos = array();
        //get main areas with their sections and videos
        $areas = $this->db->query("select * from helpVideos where parent=0 order by ord");
        foreach ($areas->result() as $area) {
            $areaSections = array();
            $sections = $this->db->query("select * from helpVideos where parent={$area->helpId} order by ord");
            foreach ($sections->result() as $section) {
                $videos_array = array();
                $videosDb = $this->db->query("select * from helpVideos where parent={$section->helpId} order by ord");
                foreach ($videosDb->result() as $video) {
                    $videos_array[$video->helpId] = array(
                        'title' => $video->title,
                        'youtubeId' => $video->youtubeId,
                    );
                }
                $areaSections[$section->helpId] = array(
                    'title' => $section->title,
                    'videos' => $videos_array,
                    'enabled' => $section->enabled,
                );
            }
            $videos[$area->helpId] = array(
                'title' => $area->title,
                'sections' => $areaSections,
            );
        }
        $data['videos'] = $videos;
        $data['account'] = $this->account();
        $this->load->view('admin/helpVideos', $data);
    }

    function helpVideoSectionEnable()
    {
        $this->load->database();
        $q = 'update helpVideos set enabled=' . $this->input->post('enabled') . ' where helpId=' . $this->input->post('sectionId');
        $this->db->query($q);
    }

    function helpVideochangeTitle()
    {
        $this->load->database();
        $value = $this->input->post('value');
        if (!strlen(($value))) {
            $value = 'Title';
        }
        $q = 'update helpVideos set title=\'' . $value . '\' where helpId=' . $this->input->post('id');
        $this->db->query($q);
        echo $this->input->post('value');
    }

    function helpVideochangeYoutube()
    {
        $this->load->database();
        $value = $this->input->post('value');
        if (!strlen(($value))) {
            $value = 'Youtube_ID';
        }
        $q = 'update helpVideos set youtubeId=\'' . $value . '\' where helpId=' . $this->input->post('id');
        $this->db->query($q);
        echo $this->input->post('value');
    }

    function deleteHelpVideo()
    {
        $this->load->database();
        $this->db->query('delete from helpVideos where helpId=' . $this->input->post('id') . ' limit 1');
        $this->session->set_flashdata('success', 'Video Deleted!');
    }

    function addHelpVideo()
    {
        $this->load->database();
        $this->db->query('insert into helpVideos values(NULL, ' . $this->input->post('parent') . ",1,'" . $this->input->post('title') . "','" . $this->input->post('youtubeId') . "',99)");
        $this->session->set_flashdata('success', 'Video Added!');
        redirect('admin/helpVideos');
    }

    function updateAllPrices()
    {
        $this->load->database();
        $proposals = $this->db->query('select proposalId, price from proposals');
        $count = 0;
        foreach ($proposals->result() as $proposal) {
            if ($proposal->price == NULL) {
                $count++;
                updateProposalPrice($proposal->proposalId);
            }
            if ($count > 499) {
                break;
            }
        }
        $this->session->set_flashdata('success', 'Success! ' . $count . ' prices Updated!');
        redirect('admin');
    }

    function email_templates()
    {
        $data = array();
        if ($this->input->post('saveEmailSettings')) {
            
            $this->settings->save($this->input->post('settings'));
            $this->session->set_flashdata('success', 'Email settings saved!');
            redirect('admin/email_templates');
        }
        $templates = $this->em->createQuery("select t from models\Email_templates t order by t.templateId")->getResult();
        
        if ($this->uri->segment(3) == 'edit') {
           
            $data['template'] = NULL;
            foreach ($templates as $template) {
                if ($template->getTemplateId() == $this->uri->segment(4)) {
                    $data['template'] = $template;
                }
            }
            if ($this->input->post('subject')) {
                $request_body = file_get_contents("php://input");
                $data_content = array();
                parse_str($request_body, $data_content);      
                if (isset($data_content['body'])) {
                    // Echo the 'value' field
                    $body = $data_content['body'];
                } 
        
             
                $tpl = $data['template'];
                $tpl->setTemplateSubject($this->input->post('subject'));
                //$tpl->setTemplateBody($this->input->post('body'));
                $tpl->setTemplateBody($body);
                $this->em->persist($tpl);
                $this->em->flush();
                $this->session->set_flashdata('success', 'Email Information saved!');
                redirect('admin/email_templates');
            }
            if (!$data['template']) {
                $this->session->set_flashdata('error', 'Template not found! If this keeps up showing contact the king, the god, the one, the only, Chris!');
                redirect('admin/email_templates');
            }
        }
        $data['templates'] = $templates;
        $data['account'] = $this->account();
        $this->load->view('admin/email_templates', $data);
    }

    function client_email_templates()
    {
        $this->load->model('clientEmail');
        $data = array();
        // Applies to all actions
        $action = $this->uri->segment(3);
        $data['action'] = $action;

        // When editing/deleting
        $templateId = $this->uri->segment(4);

        // When adding
        $templateTypeId = $this->uri->segment(5);
        if ($templateTypeId) {
            $templateType = $this->em->find('models\ClientEmailTemplateType', $templateTypeId);
        }


        if (!$templateTypeId) {
            // Load the template if we have one
            if ($templateId) {
                $template = $this->em->find('\models\ClientEmailTemplate', $templateId);
                $templateType = $template->getTemplateType();
            }
        }


        // Permission check
        if (!$this->account()->isGlobalAdministrator()) {
            $this->session->set_flashdata('error', 'You do not have permission to access this template!');
            redirect(site_url('/'));
        }

        // Are we dealing with a posted form?
        if ($this->input->post('submitTemplate')) {

            $this->load->library('form_validation');
            // Yes, process the input
            $this->form_validation->set_rules('templateName', 'Template Name', 'required');
            $this->form_validation->set_rules('templateDescription', 'Template Description', 'required');
            $this->form_validation->set_rules('subject', 'Subject', 'required');
            $this->form_validation->set_rules('body', 'Mail Body', 'required');

            if ($this->form_validation->run()) {
                // Success

                // Validation passed, save the template
                if ($this->input->post('templateId') && $action != 'duplicate') {
                    $template = $this->em->find('models\ClientEmailTemplate', $this->input->post('templateId'));
                    $logAction = 'edited';
                } else {
                    $template = new \models\ClientEmailTemplate();
                    $template->setTemplateType($templateType);
                    $template->setOrder(999);
                    $template->setDefaultTemplate(0);
                    $logAction = 'created';
                }
                //change the template code start
                    $request_body = file_get_contents("php://input");
                    $data = array();
                    parse_str($request_body, $data);      
                    if (isset($data['body'])) {
                        // Echo the 'value' field
                        $message = $data['body'];
                    } 
                     
                //change the template code stop

                $template->setTemplateName($this->input->post('templateName'));
                $template->setTemplateDescription($this->input->post('templateDescription'));
                $template->setTemplateSubject($this->input->post('subject'));
               // $template->setTemplateBody($this->input->post('body'));
                $template->setTemplateBody($message);
                $template->setUpdateAt(Carbon::now());

                $this->em->persist($template);
                $this->em->flush();

                //Delete All Cache
                $this->doctrine->deleteSiteAllCache();

                $this->session->set_flashdata('success', "The template '" . $template->getTemplateName() . "' saved");

                // Log it
                $this->log_manager->add('client_email_template_' . $logAction, "Client Email Template '" . $template->getTemplateName() . "' " . $logAction);

                redirect('admin/client_email_templates/' . $template->getTemplateType()->getTypeId());

            }
        }

        switch ($action) {

            case 'edit':
                $templateType = $template->getTemplateType();
                $data['template'] = $template;
                $data['templateType'] = $templateType;
                $data['templateTypeFields'] = $templateType->getFields();
                //Delete All Cache
        $this->doctrine->deleteSiteAllCache();
                break;

            case 'duplicate':
                $templateType = $template->getTemplateType();
                $data['template'] = $template;
                $data['templateType'] = $templateType;
                $data['templateTypeFields'] = $templateType->getFields();
                //Delete All Cache
        $this->doctrine->deleteSiteAllCache();
                break;

            case 'add':
                $data['templateType'] = $templateType;
                $data['templateTypeFields'] = $templateType->getFields();
                
                break;

            case 'delete':
                if (!$template) {
                    $this->session->set_flashdata('error', 'Template not found!');
                    redirect('admin/client_email_templates');
                }
                // Check we aren't deleting the last one //
                $typeId = $template->getTemplateType()->getTypeId();
                // Only proceed if we have more than one of this type
                if ($template->getTemplateType()->getAdminCount() > 1) {
                    $this->em->remove($template);
                    $this->em->flush();
                    //Delete All Cache
                    $this->doctrine->deleteSiteAllCache();
                    $this->session->set_flashdata('success', "The template '" . $template->getTemplateName() . "' deleted");
                    $this->log_manager->add('client_email_template_deleted', "Client Email Template '" . $template->getTemplateName() . "' deleted");
                    redirect('admin/client_email_templates/' . $typeId);
                } else {
                    $this->session->set_flashdata('error', "You cannot delete the last remaining template!");
                    redirect('admin/client_email_templates/' . $typeId);
                }


                break;
        }

        //$data['templates'] = $templates;
        $data['templateTypes'] = $this->clientEmail->getTemplateTypes(true);
        $data['templates'] = array();
        $adminTemplates = \models\ClientEmailTemplate::getAdminTemplates();
        foreach ($adminTemplates as $template) {
            /* @var $template \models\ClientEmailTemplate */
            $data['templates'][$template->getTemplateType()->getTypeId()][] = $template;
        }
        $data['account'] = $this->account();
        $this->html->addScript('ckeditor4');
        $this->load->view('admin/client_email_templates/index', $data);
    }

   
    function statuses()
    {

        if ($this->input->post('action')) {
            switch ($this->input->post('action')) {
                case 'add':
                    if ($this->input->post('newStatus')) {

                        // Sales status
                        $salesFlag = $this->input->post('newStatusSold') ? 1 : 0;

                        $newStatus = new \models\Status();
                        $newStatus->setText($this->input->post('newStatus'));
                        $newStatus->setColor($this->input->post('newColor'));
                        $newStatus->setVisible(1);
                        $newStatus->setSales($salesFlag);
                        $newStatus->setOrder(999);
                        $this->em->persist($newStatus);
                        $this->em->flush();
                        //Delete All Cache
                        $this->doctrine->deleteSiteAllCache();
                        // Check status was created
                        if ($newStatus->getStatusId()) {
                            $this->session->set_flashdata('success', "The new Proposal Status '" . $newStatus->getText() . "' has been added");
                            redirect('admin/statuses');
                        } else {
                            $this->session->set_flashdata('error', 'There was a problem saving the new status. Please try again.');
                            redirect('admin/statuses');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Please enter a Status Text');
                        redirect('admin/statuses');
                    }
                    break;

                case 'edit':
                    if ($this->input->post('statusText')) {

                        $status = $this->em->find('\models\Status', $this->input->post('statusId'));
                        /** @var $status \models\Status */

                        // Sales status
                        $salesFlag = $this->input->post('editStatusSold') ? 1 : 0;

                        if ($status) {
                            $status->setText($this->input->post('statusText'));
                            $status->setColor($this->input->post('editColor'));
                            $status->setSales($salesFlag);
                            $this->em->persist($status);
                            $this->em->flush();
                            //Delete All Cache
                            $this->doctrine->deleteSiteAllCache();
                            $this->session->set_flashdata('success', 'Status Updated');
                            redirect('admin/statuses');
                        } else {
                            $this->session->set_flashdata('error', 'There was a problem loading the status. Please try again.');
                            redirect('admin/statuses');
                        }

                    } else {
                        $this->session->set_flashdata('error', 'Please enter a Status Text');
                        redirect('admin/statuses');
                    }
                    break;

                case 'delete':
                    if ($this->input->post('targetStatus')) {

                        $deleteStatus = $this->em->find('\models\Status', $this->input->post('statusId'));
                        $targetStatus = $this->em->find('\models\Status', $this->input->post('targetStatus'));

                        if ($deleteStatus->getStatusId() == $targetStatus->getStatusId()) {
                            $this->session->set_flashdata('error', 'Please select a different status to transfer to');
                            redirect('admin/statuses');
                        }

                        if ($deleteStatus && $targetStatus) {
                            // This is the admin changing the defaults,so these changes apply to all proposals, not just this company
                            $updated = \models\Proposals::statusUpdate($deleteStatus, $targetStatus);
                            $this->em->remove($deleteStatus);
                            $this->em->flush();
                            //Delete All Cache
                            $this->doctrine->deleteSiteAllCache();

                            $this->session->set_flashdata('success', '<p>' . $updated . ' proposals updated from "' . $deleteStatus->getText() . '" to "' . $targetStatus->getText() . '".</p><br /><p>Status "' . $deleteStatus->getText() . '" deleted</p>');
                            redirect('admin/statuses');
                        } else {
                            $this->session->set_flashdata('error', 'There was a problem loading the status. Please try again.');
                            redirect('admin/statuses');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Please enter the status to ');
                        redirect('admin/statuses');
                    }
                    break;
            }
        }

        $data = array();
        $this->html->addScript('colorpicker');
        $data['statuses'] = $this->account()->getDefaultStatuses();
        $this->load->view('admin/statuses', $data);
    }

    function business_types()
    {

        if ($this->input->post('action')) {
            switch ($this->input->post('action')) {
                case 'add':
                    if ($this->input->post('newBusinessType')) {


                        $newBusinessType = new \models\BusinessType();
                        $newBusinessType->setTypeName($this->input->post('newBusinessType'));
                        $this->em->persist($newBusinessType);
                        $this->em->flush();
                        //Delete All Cache
                        $this->doctrine->deleteSiteAllCache();

                        // Check status was created
                        if ($newBusinessType->getId()) {
                            $this->log_manager->add('Added Business Type',
                                "Business Type of '" . $newBusinessType->getTypeName() . "' added", null, null, $this->account());
                            $this->session->set_flashdata('success', 'The new Business Type has been added');
                            redirect('admin/business_types');
                        } else {
                            $this->session->set_flashdata('error', 'There was a problem saving the new status. Please try again.');
                            redirect('admin/business_types');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Please enter a Business Type');
                        redirect('admin/business_types');
                    }
                    break;

                case 'edit':
                    if ($this->input->post('newBusinessType')) {

                        $business_type = $this->em->find('\models\BusinessType', $this->input->post('businessTypeId'));
                        $oldtype = $business_type->getTypeName();
                        if ($business_type) {
                            $business_type->setTypeName($this->input->post('newBusinessType'));

                            $this->em->persist($business_type);
                            $this->em->flush();
                            //Delete All Cache
                            $this->doctrine->deleteSiteAllCache();
                            $this->log_manager->add('Edit Business Type',
                                "Business Type Chaged from '" . $oldtype . "' to '" . $business_type->getTypeName() . "' ", null, null, $this->account());
                            $this->session->set_flashdata('success', 'Business type Updated');
                            redirect('admin/business_types');
                        } else {
                            $this->session->set_flashdata('error', 'There was a problem loading the status. Please try again.');
                            redirect('admin/business_types');
                        }

                    } else {
                        $this->session->set_flashdata('error', 'Please enter a Business type Text');
                        redirect('admin/business_types');
                    }
                    break;

                case 'delete':
                    if ($this->input->post('businessTypeId')) {
                        $business_type = $this->em->find('\models\BusinessType', $this->input->post('businessTypeId'));

                        $business_type->setDeleted(1);
                        $this->em->persist($business_type);
                        $this->em->flush();
                        //Delete All Cache
                        $this->doctrine->deleteSiteAllCache();
                        $this->log_manager->add('Delete Business Type',
                            "Business Type '" . $business_type->getTypeName() . "' Deleted ", null, null, $this->account());
                        $data = array();
                        $data['error'] = 0;
                        $data['isSuccess'] = true;


                        echo json_encode($data);
                        die;
                        // $this->session->set_flashdata('success', 'Business Type Deleted');
                        // redirect('admin/business_types');
                    }
                    break;
            }
        }


        $data['businessTypes'] = $this->getCompanyRepository()->getAdminBusinessTypes();
        $this->load->view('admin/business_type', $data);
    }


    function hide_show_admin_proposal_section(){
        
        if ($this->input->post('sectionId')) {
            $proposal_section = $this->em->find('\models\ProposalSection', $this->input->post('sectionId'));

            $proposal_section->setVisible($this->input->post('action'));
            $this->em->persist($proposal_section);
            $this->em->flush();
            
            // $this->log_manager->add('Delete Business Type',
            //     "Business Type '" . $business_type->getTypeName() . "' Deleted ", null, null, $this->account());
            $data = array();
            $data['error'] = 0;
            $data['isSuccess'] = true;


            echo json_encode($data);
            die;
            
        }
    }
    
    function faq()
    {
        $data = array();
        //get categories
        $categories = $this->db->query("select * from faq_categories order by ord");
        $data['categories'] = $categories;
        //get questions
        $sqlQuestions = $this->db->query("select * from faq_questions order by ord");
        $questions = array();
        foreach ($sqlQuestions->result() as $question) {
            $questions[$question->category_id][] = $question;
        }
        $data['questions'] = $questions;
        $this->html->addScript('ckeditor4');
        $this->load->view('admin/faq', $data);
    }

    function add_faq_category()
    {
        $this->db->insert('faq_categories', array('name' => $this->input->post('categoryName'), 'ord' => 99));
        $this->session->set_flashdata('success', 'Category Added!');
        redirect('admin/faq');
    }

    function get_faq_category_name($id)
    {
        $response = new stdClass();
        $category = $this->db->query("select * from faq_categories where id=" . $id);
        if (!$category->num_rows()) {
            $response->success = false;
        } else {
            $response->success = true;
            $category = $category->result();
            $categoryName = $category[0]->name;
            $response->categoryName = $categoryName;
        }
        echo json_encode($response);
    }

    function save_faq_category()
    {
        $this->db->query("update faq_categories set name='" . $this->input->post('editCategoryName') . "' where id=" . $this->input->post('editCategoryId') . ' limit 1');
        $this->session->set_flashdata('success', 'Category Saved!');
        redirect('admin/faq/' . $this->input->post('editCategoryId'));
    }

    function delete_faq_category($id)
    {
        $this->db->query("delete from faq_categories where id={$id} limit 1");
        $this->db->query("delete from faq_questions where category_id={$id}");
        $this->session->set_flashdata('success', 'Category Deleted!');
        redirect('admin/faq');
    }

    function add_faq_question()
    {
        $this->db->insert('faq_questions',
            array(
                'category_id' => $this->input->post('addQuestionCategory'),
                'question' => $this->input->post('addQuestion'),
                'answer' => $this->input->post('addAnswer'),
                'ord' => 99)
        );
        $this->session->set_flashdata('success', 'Question Added!');
        redirect('admin/faq/' . $this->input->post('addQuestionCategory'));
    }

    function get_faq_question_details($id)
    {
        $response = new stdClass();
        $question = $this->db->query("select * from faq_questions where id={$id}");
        if (!$question->num_rows()) {
            $response->success = false;
        } else {
            $question = $question->result();
            $response->success = true;
            $response->question = $question[0]->question;
            $response->answer = $question[0]->answer;
        }
        echo json_encode($response);
    }

    function save_faq_question()
    {
        $this->db->query("update faq_questions set question='" . $this->input->post('editQuestion') . "', answer='" . $this->input->post('editAnswer') . "' where id=" . $this->input->post('editQuestionId') . ' limit 1');
        $question = $this->db->query("select * from faq_questions where id=" . $this->input->post('editQuestionId'));
        $question = $question->result();
        $question = $question[0];
        $this->session->set_flashdata('success', 'Question Saved!');
        redirect('admin/faq/' . $question->category_id);
    }

    function delete_faq_question($id)
    {
        $question = $this->db->query("select * from faq_questions where id=" . $id);
        $question = $question->result();
        $question = $question[0];
        $this->db->query("delete from faq_questions where id={$id} limit 1");
        $this->session->set_flashdata('success', 'Question Deleted!');
        redirect('admin/faq/' . $question->category_id);
    }

    function update_faq_questions_order()
    {
        foreach ($this->input->post('question') as $ord => $questionId) {
            $this->db->query("update faq_questions set ord={$ord} where id={$questionId} limit 1");
        }
    }

    function update_faq_categories_order()
    {
        foreach ($this->input->post('categories') as $ord => $categoryId) {
            $this->db->query("update faq_categories set ord={$ord} where id={$categoryId} limit 1");
        }
    }

    function get_faq_categories()
    {
        $categories = array();
        $cats = $this->db->query("select * from faq_categories order by ord");
        foreach ($cats->result() as $cat) {
            $categories[] = array(
                'id' => $cat->id,
                'name' => $cat->name,
            );
        }
        echo json_encode($categories);
    }

    function testOrder()
    {
        $this->load->model('clientEmail');
        $this->clientEmail->getTemplates(3, 1);
    }

    function ajaxSortTemplates()
    {
        $templates = $this->input->post('templates');

        if (count($templates)) {
            $i = 1;
            foreach ($templates as $templateId) {
                $template = $this->em->find('\models\ClientEmailTemplate', $templateId);
                $template->setOrder($i);
                $this->em->persist($template);
                $i++;
            }
            $this->em->flush();
        }
        echo json_encode(array('error' => 0));
    }

    public function enableLayouts($companyId)
    {
        $company = $this->em->findCompany($companyId);
        $company->setNewLayouts(1);
        $this->em->persist($company);
        $this->em->flush();
        $this->session->set_flashdata('success', 'New Layouts Enabled');
        redirect('admin/');
    }

    public function disableLayouts($companyId)
    {
        $company = $this->em->findCompany($companyId);
        $company->setNewLayouts(0);
        $this->em->persist($company);
        $this->em->flush();
        $this->session->set_flashdata('success', 'New Layouts Disabled');
        redirect('admin/');
    }

    public function enablePsa($companyId)
    {
        $company = $this->em->findCompany($companyId);
        $company->setPsa(1);
        $this->em->persist($company);
        $this->em->flush();
        $this->session->set_flashdata('success', 'PSA Enabled');
        redirect('admin/');
    }

    public function disablePsa($companyId)
    {
        $company = $this->em->findCompany($companyId);
        $company->setPsa(0);
        $this->em->persist($company);
        $this->em->flush();
        $this->session->set_flashdata('success', 'PSA Disabled');
        redirect('admin/');
    }

    public function company_data()
    {
        $statusFilter = $this->uri->segment(3);
        $expiredFilter = $this->uri->segment(4);

        if ($statusFilter) {

            $this->session->set_userdata('adminStatusFilter', $statusFilter);

            if ($expiredFilter) {
                $this->session->set_userdata('adminStatusExpiredFilter', $expiredFilter);
            } else {
                $this->session->set_userdata('adminStatusExpiredFilter', '');
            }

            redirect('admin');
        }

        $cr = $this->getCompanyRepository();
        $data = [];

        $activeCompanies = $cr->getActiveCompanies();
        $data['activeUsers'] = $cr->getTotalActiveUsers();
        $data['activeSecretaries'] = $cr->getTotalActiveUsers();
        $data['numActiveTrialCompanies'] = $cr->getNumActiveTrialCompanies();
        $data['numExpiredTrialCompanies'] = $cr->getNumExpiredTrialCompanies();

        $data['activeCompanies'] = [];

        foreach ($activeCompanies as $company) {
            /* @var \models\Companies $company */
            $data['activeCompanies'][$company->getCompanyId()] = [];
            $data['activeCompanies'][$company->getCompanyId()]['companyName'] = $company->getCompanyName();
            $data['activeCompanies'][$company->getCompanyId()]['companyStatus'] = $company->getCompanyStatus();
            $data['activeCompanies'][$company->getCompanyId()]['activeUsers'] = $cr->getNumCompanyActiveUsers($company->getCompanyId());
            $data['activeCompanies'][$company->getCompanyId()]['activeSecretaries'] = $cr->getNumCompanyActiveSecretaryUsers($company->getCompanyId());
            $data['activeCompanies'][$company->getCompanyId()]['activeWio'] = $cr->getNumCompanyActiveWioUsers($company->getCompanyId());
            $data['activeCompanies'][$company->getCompanyId()]['totalValue'] = $cr->getTotalValue($company->getCompanyId());
            $data['activeCompanies'][$company->getCompanyId()]['nextExpiryTime'] = $cr->getNextUserExpiry($company->getCompanyId());
            $data['activeCompanies'][$company->getCompanyId()]['nextExpiry'] = Carbon::createFromTimestamp($data['activeCompanies'][$company->getCompanyId()]['nextExpiryTime'])->format('m/d/Y');
            $data['activeCompanies'][$company->getCompanyId()]['adminId'] = $company->getAdministrator()->getAccountId();
            $data['activeCompanies'][$company->getCompanyId()]['adminName'] = $company->getAdministrator()->getFullName();
        }

        $this->html->addScript('dataTables');
        $this->load->view('admin/company_data', $data);
    }

    public function announcements()
    {
        if ($this->input->post('saveAnnouncement')) {

            if ($this->input->post('announcementId')) {
                $ann = $this->em->find('models\Announcement', $this->input->post('announcementId'));
            } else {
                $ann = $this->getAnnouncementRepository()->create();
            }
            $ann->setTitle($this->input->post('title'));
            $ann->setText($this->input->post('announceText'));
            $ann->setAdmin($this->input->post('admin') ? 1 : 0);
            $ann->setSticky($this->input->post('sticky') ? 1 : 0);
            $ann->setReleased(Carbon::createFromFormat('m/d/Y', $this->input->post('release')));
            $ann->setExpires(Carbon::createFromFormat('m/d/Y', $this->input->post('expires')));

            $this->em->persist($ann);
            $this->em->flush();

            $this->session->set_flashdata('success', 'Announcement Saved');
            redirect('admin/announcements');
        }

        $data = [
            'announcements' => $this->getAnnouncementRepository()->getAllActiveAnnouncements(),
            'expiredAnnouncements' => $this->getAnnouncementRepository()->getAllExpiredAnnouncements()
        ];

        $this->html->addScript('ckeditor4');
        $this->load->view('/admin/announcements', $data);
    }

    function deleteAnnouncement($id)
    {
        $ann = $this->em->find('models\Announcement', $id);

        if (!$ann) {
            $this->session->set_flashdata('error', 'Problem deleting announcement');
            redirect('admin/announcements');
            return;
        }

        $this->em->remove($ann);
        $this->em->flush();
        $this->session->set_flashdata('success', 'Announcement Deleted');
        redirect('admin/announcements');
    }

    public function updateAnnouncementsOrder()
    {
        $i = 0;
        foreach ($this->input->post('announcement') as $announcementId) {
            $announcement = $this->em->find('models\Announcement', $announcementId);
            $announcement->setOrd($i);
            $this->em->persist($announcement);
            $i++;
        }
        $this->em->flush();
    }

    public function companiesTableData()
    {
        $json = array();
        $this->load->database();

        $totalCompanies = $this->db->query("SELECT COUNT(companyId) AS numCompanies FROM companies")->row()->numCompanies;

        // Get the table data
        $companies = $this->account()->getAdminCompaniesTableData();

       // echo "<pre>";print_r($companies);die;

        // Build the response
        $companiesData = [];
        foreach ($companies as $company) {
            $companyName =  '<div style="display: flex;justify-content: space-between;"><div>'.$company->companyName.'</div><div><span style="display: flex;float:right;justify-content: flex-end;text-align:right;font-size: 14px;">';
            $displayAddNote = ($company->ncount) ? false : true;
            $companyName .= ' <a href="javascript:void(0);"  class="view-notes comapny_table_notes_tiptip hasNotes" data-value-id="'.$company->companyId.'" data-val="'.$company->companyId.'"  style="font-size: 14px;color:#a5a2a2; display:' . (($displayAddNote) ? 'none' : 'block') . '"><i class="fa fa-fw fa-sticky-note-o "  ></i></a>';
            $companyName .= '<a href="javascript:void(0);"class="view-notes tiptip hasNoNotes" title="Add Company Notes"  data-value-id="'.$company->companyId.'"  style="font-size: 14px;color:#a5a2a2;float:right; display:' . (($displayAddNote) ? 'block' : 'none') . '"><i class="fa fa-fw fa-plus"></i></a>';
            $companyName .= '</div></span></div>';

            $companyData = [
                // 0 - Checkbox
                '0' => $this->load->view('templates/admin/table/check', array('company' => $company), true),
                // 1 - Company Id
                '1' => $this->load->view('templates/admin/table/actions', array('company' => $company), true),
                '2' => $company->companyId,
                // 2 - Company Name
                '3' => $companyName,
                // 3 - Company Status
                '4' => $this->load->view('templates/admin/table/status', array('company' => $company), true),
                // 4 - Num Users
                '5' => $company->numUsers,
                // 5 - Paid Users
                '6' => $company->numPaidUsers,
                // 6 - Inactive Users
                '7' => $company->numInactiveUsers,
                // 7 - Next Expiry
                '8' => $this->load->view('templates/admin/table/expires', array('company' => $company), true),
                // 8 - Administrator
                '9' => $company->adminFullName,
                // 9 - Layouts
                '10' => $company->new_layouts ? 'Yes' : 'No',
                // 10 - PSA
                '11' => $company->psa ? 'Yes' : 'No',
                // 10 - estimating
                '12' => $company->estimating ? 'Yes' : 'No',

                '13' => $company->sales_manager==0 ? 'No' : 'Yes',

                '14' => $company->modify_price==0 ? 'No' : 'Yes',

                '15' => $company->proposalCampaigns==0 ? 'No' : 'Yes',                 
                // 15 - Actions
             ];

            $companiesData[] = $companyData;
        }

        $json["iTotalRecords"] = $totalCompanies;
        $json["iTotalDisplayRecords"] = $this->account()->getAdminCompaniesTableData(true);
        $json['aaData'] = $companiesData;
        $json['sEcho'] = $this->input->get('sEcho');
        echo json_encode($json);
    }
    

    public function companiesResendTableData()
    {
        $json = array();
        $this->load->database();

        // Get the table data
        $companies = $this->account()->getAdminCompaniesResendTableData(false, '', $_GET['type_']);

        // Build the response
        $companiesData = [];

        foreach ($companies as $company) {
            $companyData = [
                // 0 - Checkbox
                //'0' => '<input type="checkbox" name="user['. $company->accountId.']" id="users_'.$company->accountId.'" class="companyCheckbox"/>',

                // 1 - Company Name
                '0' => $company->companyName,
                // 2 - adminFullName
                '1' => $company->adminFullName,
                // 3 - Num Users
                '2' => $company->email,
                // 4 - delivered_at
                '3' => $company->delivered_at ? date_format(date_create($company->delivered_at), "m/d/y g:i A") : '-',
                // 5 - opened_at
                '4' => $company->opened_at ? date_format(date_create($company->opened_at), "m/d/y g:i A") : '-',
                // Bounced At
                '5' => $company->bounced_at ? date_format(date_create($company->bounced_at), "m/d/y g:i A") : '-',
                // CLicked
                '6' => $company->clicked_at ? date_format(date_create($company->clicked_at), "m/d/y g:i A") : '-',

            ];

            $companiesData[] = $companyData;
        }

        $json["iTotalRecords"] = $this->account()->getAdminCompaniesResendTableData(true);
        $json["iTotalDisplayRecords"] = $this->account()->getAdminCompaniesResendTableData(true, '', $_GET['type_']);
        $json['aaData'] = $companiesData;
        $json['sEcho'] = $this->input->get('sEcho');
        echo json_encode($json);
    }

    public function estimating_categories()
    {
        $data = [];
        $er = $this->getEstimationRepository();

        $data['categories'] = $er->getAdminCategories();

        $this->load->view('admin/estimating/categories', $data);
    }

    /**
     * Page to display default estimation settings
     */
    public function estimating_settings()
    {
        //$company = $this->account()->getCompany();
        $data = [];
        $data['calculationTypes'] = $this->getEstimationRepository()->getCalculationTypes();
        $data['settings'] = $this->getEstimationRepository()->getAdminCompanySettings(null);
        //print_r($data['settings']);die;
        //$data['layout'] = 'account/my_account/estimating/settings';
        $this->load->view('admin/estimating/settings', $data);
    }


    public function saveEstimationSettings()
    {
        //$company = $this->account()->getCompany();

        $defaultOverhead = $this->input->post('defaultOverhead');
        $defaultProfit = $this->input->post('defaultProfit');
        $settingType = $this->input->post('calculationType');
        $productionRate = $this->input->post('productionRate');

        $settings = $this->getEstimationRepository()->getAdminCompanySettings();

        $settings->setDefaultOverhead($defaultOverhead);
        $settings->setDefaultProfit($defaultProfit);
        $settings->setCalculationType($settingType);
        $settings->setProductionRate($productionRate);

        $this->em->persist($settings);
        $this->em->flush();

        // Feedback and redirect
        $this->session->set_flashdata('success', 'Settings Saved');
        redirect('admin/estimating_settings');
    }

    public function saveCategory()
    {
        $categoryId = $this->input->post('categoryId');
        $categoryName = $this->input->post('categoryName');

        $category = new EstimationCategory();

        if ($categoryId) {
            $category = $this->em->findEstimationCategory($categoryId);
        }

        $category->setName($categoryName);
        $this->em->persist($category);
        $this->em->flush();

        $this->session->set_flashdata('success', 'Category Saved');
        redirect('admin/estimating_categories');
    }

    public function estimating_types()
    {
        $data = [];
        $er = $this->getEstimationRepository();

        $data['categories'] = $er->getAdminCategories();
        $data['types'] = $er->getSortedTypes();
        $data['services'] = $er->getAdminServices();
        $this->html->addScript('dataTables');
        $this->load->view('admin/estimating/types', $data);
    }


    /**
     * Save a new type
     */
    public function addEstimatingType()
    {
        $categoryId = $this->input->post('categoryId');
        $typeName = $this->input->post('typeName');

        $type = new EstimationType();
        $type->setCategoryId($categoryId);
        $type->setName($typeName);
        $this->em->persist($type);
        $this->em->flush();

        $this->session->set_flashdata('success', 'Type Saved');
        redirect('admin/estimating_types');
    }


    public function saveEstimatingType()
    {
        $typeId = $this->input->post('typeId');
        $categoryId = $this->input->post('categoryId');
        $typeName = $this->input->post('typeName');

        $type = new EstimationType();
        //$logMessage = 'Estimating Type "' . $typeName . '" created';

        if ($typeId) {
            $type = $this->em->findEstimationType($typeId);
            $oldName = $type->getName();
            $newName = $typeName;
            //$logMessage = 'Estimating Type "' . $oldName . '" changed to "' . $newName . '"';
        }

        // Save Values
        $type->setCategoryId($categoryId);
        $type->setName($typeName);
        $type->setCompanyId(null);
        $this->em->persist($type);
        $this->em->flush();

        // Log it
        // $this->getLogRepository()->add([
        //     'action' => 'estimation_type',
        //     'details' => $logMessage,
        //     'account' => $this->account()->getAccountId(),
        //     'company' => $this->account()->getCompanyId()
        // ]);

        // Assign it to all categories
        //$this->getEstimationRepository()->assignNewEstimatingType($this->account()->getCompany(), $type);

        // Respond
        $this->session->set_flashdata('success', 'Type Saved');
        redirect('admin/estimating_types');
    }

    /**
     * Update a saved type
     */
    public function updateEstimatingType()
    {
        $typeId = $this->input->post('typeId');
        $typeName = $this->input->post('updateTypeName');

        $type = $this->em->findEstimationType($typeId);
        $type->setName($typeName);
        $this->em->persist($type);
        $this->em->flush();

        $this->session->set_flashdata('success', 'Type Updated');
        redirect('admin/estimating_types');
    }

    public function estimating_items()
    {
        $data = [];
        $er = $this->getEstimationRepository();
        $data['categories'] = $er->getAdminCategories();
        $data['types'] = $er->getAdminTypes();
        $data['sortedTypes'] = $er->getSortedTypes();
        $data['sortedItems'] = $er->getSortedItems();
        $data['sortedUnits'] = $er->getSortedUnits();
        $data['searchItems'] = $er->defaultSearchItems();

        $this->html->addScript('dataTables');
        $this->load->view('admin/estimating/items', $data);
    }

    public function addEstimatingItem()
    {
        $unitPrice = str_replace(
            ['$', ','],
            ['', ''],
            $this->input->post('unitPrice')
        );

        $item = $this->em->findEstimationItem($this->input->post('itemId'));

        if (!$item) {
            $item = new EstimationItem();
        }

        $item->setCompanyId(null);
        $item->setName($this->input->post('itemName'));
        $item->setTypeId($this->input->post('typeId'));
        $item->setTaxable($this->input->post('taxable'));
        $item->setUnit($this->input->post('unitId'));
        $item->setUnitPrice($unitPrice);

        $this->em->persist($item);
        $this->em->flush();

        $this->session->set_flashdata('success', 'Item Saved');
        redirect('admin/estimating_items');
    }


    public function saveEstimatingItem()
    {
        // Flag for updating
        $editing = false;

        // Strip out dollar sign and commas
        $unitPrice = str_replace(
            ['$', ','],
            ['', ''],
            $this->input->post('unitPrice')
        );

        $itemBaseCost = str_replace(
            ['$', ','],
            ['', ''],
            $this->input->post('itemBaseCost')
        );

        $itemOverheadRate = str_replace(
            ['$', ',', '%'],
            ['', '', ''],
            $this->input->post('itemOverheadRate')
        );

        $itemOverheadPrice = str_replace(
            ['$', ','],
            ['', ''],
            $this->input->post('itemOverheadPrice')
        );

        $itemProfitRate = str_replace(
            ['$', ',', '%'],
            ['', '', ''],
            $this->input->post('itemProfitRate')
        );

        $itemProfitPrice = str_replace(
            ['$', ','],
            ['', ''],
            $this->input->post('itemProfitPrice')
        );

        // Set taxable into 0/1
        $taxable = $this->input->post('taxable') ? 1 : 0;

        // Set capacity to zero if blank
        $capacity = $this->input->post('itemCapacity') ?: 0;

        // Load and set default message
        if ($this->input->post('itemId')) {
            $item = $this->em->findEstimationItem($this->input->post('itemId'));
            $oldItem = clone $item;
            $editing = true;
        } else {
            $item = false;
        }

        $logMessage = 'Estimating Item "' . $this->input->post('itemName') . '" edited';

        // New if not loaded
        if (!$item) {
            $item = new EstimationItem();
            $logMessage = 'Estimating Item "' . $this->input->post('itemName') . '" created';
        }
        /* estimating items  edit start */

        // Check if $itemOverheadPrice is empty
        if ($itemOverheadPrice === '') {
            $itemOverheadPrice = 0; // For example, setting it to 0
       }
        // Check if $itemProfitPrice is empty
        if ($itemProfitPrice === '') {
            $itemProfitPrice = 0; // For example, setting it to 0
        }

        // Check if tax rate is provided and not empty
        if (!empty($taxRateInput)) {
            // Convert tax rate to decimal
            $taxRateInput = floatval($taxRateInput);
        } else {
            // Set a default tax rate or handle it according to your application's logic
            $taxRateInput = 0.00; // For example, setting it to 0.00
        }
        /* estimating items  edit end */


        // Save it
        $item->setCompanyId(null);
        $item->setName($this->input->post('itemName'));
        $item->setTypeId($this->input->post('typeId'));
        $item->setTaxable($taxable);
        $item->setTaxRate($taxRateInput);
        $item->setUnit($this->input->post('unitId'));
        $item->setUnitPrice($unitPrice);
        $item->setVendor($this->input->post('itemVendor'));
        $item->setSku($this->input->post('itemSku'));
        $item->setNotes($this->input->post('itemNotes'));
        $item->setBasePrice($itemBaseCost);
        $item->setOverheadRate($itemOverheadRate);
        $item->setOverheadPrice($itemOverheadPrice);
        $item->setProfitRate($itemProfitRate);
        $item->setProfitPrice($itemProfitPrice);
        $item->setCapacity($capacity);

        // Flush to DB
        $this->em->persist($item);
        $this->em->flush();

        if (!$editing) {
            $this->getEstimationRepository()->distributeEstimatingItem($item);
        }

        // Log it
        $this->getLogRepository()->add([
            'action' => 'estimation_item',
            'details' => $logMessage,
            'account' => $this->account()->getAccountId(),
            'company' => $this->account()->getCompanyId()
        ]);

        // Apply price changes if required
        if ($editing) {

            // Get the list of estimate statuses we're changing
            $statusIds = $this->input->post('updateStatus');

            // Check it's an array and has values
            if (is_array($statusIds) && count($statusIds)) {

                // Loop through each and apply the update
                foreach ($statusIds as $statusId) {
                    // Apply the change
                    $this->getEstimationRepository()->applyItemChanges($this->account(), $statusId, $oldItem, $item);
                }
            }
            $this->getEstimationRepository()->EstimationItemPriceChanges($oldItem, $item, $this->account());
        }


        // Feedback and redirect
        $this->session->set_flashdata('success', 'Item Saved');
        if ($this->input->post('page') == 'estimating_price_report') {
            redirect('admin/estimating_price_report');
        } else {
            redirect('admin/estimating_items');
        }

    }

    public function updateEstimationItemsDefaultOrder()
    {
        $i = 0;
        $ids = $this->input->post('items');

        if (is_array($ids)) {
            foreach ($ids as $itemId) :
                $item = $this->em->findEstimationItem($itemId);
                if ($item) {
                    $item->setOrd($i);
                    $this->em->persist($item);
                    $i++;
                }
            endforeach;

            $this->em->flush();
        }
    }

    public function defaultEstimationItemSearch()
    {
        $searchTerm = $this->input->post('term');
        $results = $this->getEstimationRepository()->defaultSearch($searchTerm);

        echo json_encode($results);
    }

    /**
     *
     */
    public function getEstimatingServiceFields()
    {
        $company = $this->account()->getCompany();
        $serviceId = $this->input->post('serviceId');

        $response = [];

        $fields = $company->getServiceFields($serviceId);

        foreach ($fields as $field) {
            $cesf = $this->getEstimationRepository()->getDefaultEstimateServiceField($field);

            if (!$cesf) {
                $cesf = new \models\CompanyEstimateServiceField();
            }

            $response[] = [
                'id' => $field->getFieldId(),
                'name' => $field->getFieldName(),
                'cesf' => [
                    'measurement' => $cesf->getMeasurement(),
                    'unit' => $cesf->getUnit(),
                    'depth' => $cesf->getDepth(),
                    'area' => $cesf->getArea(),
                    'length' => $cesf->getLength(),
                    'qty' => $cesf->getQty(),
                    'gravel_depth' => $cesf->getGravelDepth(),
                    'base_depth' => $cesf->getBaseDepth(),
                    'exc_depth' => $cesf->getExcavationDepth(),
                ]
            ];
        }

        echo json_encode($response);
    }


    public function saveEstimatingServiceFields()
    {
        // Clear defaults for this service
        $this->getEstimationRepository()->clearDefaultCesf($this->input->post('serviceId'));

        try {

            // Measurement
            if ($this->input->post('measurement')) {
                $cesf = new \models\CompanyEstimateServiceField();
                $cesf->setServiceId($this->input->post('serviceId'));
                $cesf->setCompanyId(null);
                $cesf->setFieldId($this->input->post('measurement'));
                $cesf->setMeasurement(1);
                $this->em->persist($cesf);
            }

            // Unit
            if ($this->input->post('unit')) {
                $cesf = new \models\CompanyEstimateServiceField();
                $cesf->setServiceId($this->input->post('serviceId'));
                $cesf->setCompanyId(null);
                $cesf->setFieldId($this->input->post('unit'));
                $cesf->setUnit(1);
                $this->em->persist($cesf);
            }

            // Depth
            if ($this->input->post('excDepth')) {
                $cesf = new \models\CompanyEstimateServiceField();
                $cesf->setServiceId($this->input->post('serviceId'));
                $cesf->setCompanyId(null);
                $cesf->setFieldId($this->input->post('excDepth'));
                $cesf->setExcavationDepth(1);
                $this->em->persist($cesf);
            }

            // Depth
            if ($this->input->post('depth')) {
                $cesf = new \models\CompanyEstimateServiceField();
                $cesf->setServiceId($this->input->post('serviceId'));
                $cesf->setCompanyId(null);
                $cesf->setFieldId($this->input->post('depth'));
                $cesf->setDepth(1);
                $this->em->persist($cesf);
            }

            // Base Depth
            if ($this->input->post('baseDepth')) {
                $cesf = new \models\CompanyEstimateServiceField();
                $cesf->setServiceId($this->input->post('serviceId'));
                $cesf->setCompanyId(null);
                $cesf->setFieldId($this->input->post('baseDepth'));
                $cesf->setBaseDepth(1);
                $this->em->persist($cesf);
            }

            // GravelDepth
            if ($this->input->post('gravelDepth')) {
                $cesf = new \models\CompanyEstimateServiceField();
                $cesf->setServiceId($this->input->post('serviceId'));
                $cesf->setCompanyId(null);
                $cesf->setFieldId($this->input->post('gravelDepth'));
                $cesf->setGravelDepth(1);
                $this->em->persist($cesf);
            }

            // Area
            if ($this->input->post('area')) {
                $cesf = new \models\CompanyEstimateServiceField();
                $cesf->setServiceId($this->input->post('serviceId'));
                $cesf->setCompanyId(null);
                $cesf->setFieldId($this->input->post('area'));
                $cesf->setArea(1);
                $this->em->persist($cesf);
            }

            // Qty
            if ($this->input->post('area')) {
                $cesf = new \models\CompanyEstimateServiceField();
                $cesf->setServiceId($this->input->post('serviceId'));
                $cesf->setCompanyId(null);
                $cesf->setFieldId($this->input->post('area'));
                $cesf->setQty(1);
                $this->em->persist($cesf);
            }

            $this->em->flush();

            echo json_encode([
                'error' => 0,
                'message' => 'Fields Saved'
            ]);

        } catch (\Exception $e) {
            echo json_encode([
                'error' => 1,
                'message' => 'Error Saving Fields'
            ]);
        }
    }

    public function default_phases()
    {
        $data = [];
        $data['categories'] = \models\Services::getCategories();
        $data['services'] = \models\Services::getAdminPopulatedCategories();
        $data['phases'] = [];

        foreach ($data['services'] as $categoryId => $categoryServices) {
            foreach ($categoryServices as $categoryService) {
                $data['phases'][$categoryService->getServiceId()] = $this->getEstimationRepository()->getDefaultStages($categoryService->getServiceId());
            }
        }

        $this->load->view('admin/estimating/default_phases', $data);
    }

    public function updateEstimationDefaultPhasesOrder()
    {
        $i = 0;
        $phaseIds = $this->input->post('phases');

        if (is_array($phaseIds)) {
            foreach ($phaseIds as $phaseId) :
                $phase = $this->em->findEstimateStage($phaseId);
                if ($phase) {
                    $phase->setOrd($i);
                    $this->em->persist($phase);
                    $i++;
                }
            endforeach;

            $this->em->flush();
        }
    }

    public function saveEstimateDefaultPhase()
    {
        $serviceId = $this->input->post('serviceId');
        $phaseId = $this->input->post('phaseId');
        $phaseName = $this->input->post('phaseName');

        if ($phaseId) {
            $phase = $this->em->findEstimateStage($phaseId);
        } else {
            $phase = new \models\EstimateDefaultStage();
            $phase->setOrd(999);
        }

        $phase->setCompanyId(null);
        $phase->setServiceId($serviceId);
        $phase->setName($phaseName);

        $this->em->persist($phase);
        $this->em->flush();

        if ($phase->getId()) {
            echo json_encode([
                'error' => 0,
                'phase' => [
                    'id' => $phase->getId(),
                    'name' => $phase->getName()
                ]
            ]);
        } else {
            echo json_encode([
                'error' => 1
            ]);
        }
    }

    public function deleteDefaultEstimationPhase($phaseId)
    {
        $phase = $this->em->findEstimateStage($phaseId);

        if ($phase) {

            try {
                $this->em->remove($phase);
                $this->em->flush();

                echo json_encode([
                    'error' => 0,
                    'message' => 'Default Phase Deleted'
                ]);
            } catch (\Exception $e) {
                echo json_encode([
                    'error' => 1,
                    'message' => 'Error Deleting Phase'
                ]);
            }

        } else {
            echo json_encode([
                'error' => 1,
                'message' => 'Error Loading Phase'
            ]);
        }
    }

    public function enableEstimating($companyId)
    {
        $company = $this->em->findCompany($companyId);


        $addrString = $company->getCompanyAddress();

        if ($company->getCompanyCity()) {
            $addrString .= ' ' . $company->getCompanyCity();
        }

        if ($company->getCompanyState()) {
            $addrString .= ' ' . $company->getCompanyState();
        }

        if ($company->getCompanyState()) {
            $addrString .= ' ' . $company->getCompanyZip();
        }

        $curl = new \Ivory\HttpAdapter\CurlHttpAdapter();
        $geocoder = new \Geocoder\Provider\GoogleMaps($curl, null, null, true, $_ENV['GOOGLE_API_SERVER_KEY']);


        try {
            $geocoder->geocode($addrString);

        } catch (Exception $e) {
            $this->session->set_flashdata('error', "Company Address is not correct");
            redirect('admin');

        }


        $company->setEstimating(1);
        $this->em->persist($company);
        $this->em->flush();

        $items = $this->getEstimationRepository()->getAllCompanyItems($company);

        if (!$items) {
            $this->getEstimationRepository()->migrateDefaultEstimatingItems($company);
        }
        //$this->getEstimationRepository()->assignAllEstimateCompanyServiceTypes($company);
        $this->getEstimationRepository()->createDefualtPlantDump($company);
        $this->getEstimationRepository()->createDefaultTemplates($company);
        $setting = $this->getEstimationRepository()->getCompanySettings($company);

        $this->session->set_flashdata('success', "Estimating activated for " . $company->getCompanyName());
        $this->log_manager->add(\models\ActivityAction::PROPOSAL_ESTIMATE_ACTIVATE, "Estimating activated for " . $company->getCompanyName());
        redirect('admin');
    }

    public function disableEstimating($companyId)
    {
        $company = $this->em->findCompany($companyId);
        $company->setEstimating(0);
        $this->em->persist($company);
        $this->em->flush();

        $this->session->set_flashdata('success', "Estimating deactivated for " . $company->getCompanyName());
        $this->log_manager->add(\models\ActivityAction::PROPOSAL_ESTIMATE_ACTIVATE, "Estimating deactivated for " . $company->getCompanyName());
        redirect('admin');
    }

    /**
     * @param $itemId
     * Function to set a specified type as deleted
     */
    public function deleteEstimatingItem($itemId)
    {
        // Load the item
        $item = $this->em->findEstimationItem($itemId);

        // Check it loaded
        if (!$item) {
            $this->session->set_flashdata('error', 'Error Loading Item!');
            redirect('admin/estimating_items');
            return;
        }

        // Passed checks, proceed to mark as deleted
        $item->setDeleted(1);
        $this->em->persist($item);
        $this->em->flush();

        // $eid = new \models\EstimationItemDeleted();
        // $eid->setItemId($itemId);
        // $eid->setCompanyId($this->account()->getCompanyId());
        // $this->em->persist($eid);
        // $this->em->flush();

        // $templateItem = $this->em->getRepository('models\EstimateTemplateItem')->findOneBy(array('item_id' => $itemId));
        // if ($templateItem) {
        //     $this->em->remove($templateItem);
        //     $this->em->flush();
        // }

        // // Log it
        // $this->getLogRepository()->add([
        //     'action' => 'estimation_item',
        //     'details' => 'Estimation Item "' . $item->getName() . '" deleted',
        //     'account' => $this->account()->getAccountId(),
        //     'company' => $this->account()->getCompanyId()
        // ]);

        // Response
        $this->session->set_flashdata('success', 'Item Deleted');
        redirect('admin/estimating_items');
        return;
    }


    public function estimating_templates()
    {
        $data = [];
        $er = $this->getEstimationRepository();

        $data['templates'] = $er->getAdminTemplates();
        $data['settings'] = $er->getAdminCompanySettings();
        $data['services'] = $er->getAdminServices();
        $this->html->addScript('dataTables');
        $this->load->view('admin/estimating/templates', $data);
    }


    public function saveAdminEstimatingTemplate()
    {
        $templateId = $this->input->post('templateId');
        $isTemplateDuplicate = $this->input->post('isTemplateDuplicate');
        $templateName = $this->input->post('templateName');
        $calculation_type = $this->input->post('calculation_type');
        $templateType = ($this->input->post('templateType')) ? 1 : 0;
        $templatePriceRate = str_replace(',', '', $this->input->post('templateRate'));
        $templatePriceRate = str_replace('$', '', $templatePriceRate);
        $templateOverheadRate = str_replace('%', '', $this->input->post('templateOverheadRate'));
        $templateProfitRate = str_replace('%', '', $this->input->post('templateProfitRate'));
        $templateOverheadPrice = str_replace(['$', ','], ['', ''], $this->input->post('templateOverheadPrice'));
        $templateProfitPrice = str_replace(['$', ','], ['', ''], $this->input->post('templateProfitPrice'));
        $templateBasePrice = str_replace(['$', ','], ['', ''], $this->input->post('templateBasePrice'));
        $assignServices = false;
        $duplicateAssignServices = false;
        // $newItem = str_replace(['%', ','], ['', ''], $this->input->post('templateOverheadRate'));
        // Load or create
        if ($templateId) {
            if ($isTemplateDuplicate == 1) {
                $duplicateAssignServices = true;

                $template = new \models\EstimationTemplate();
                $template->setCompanyId(0);
                $oldTemplate = $this->em->findEstimationTemplate($templateId);
            } else {
                $template = $this->em->findEstimationTemplate($templateId);
            }
        } else {
            $assignServices = true;
            $template = new \models\EstimationTemplate();
            $template->setCompanyId(0);

        }

        // Set the name
        $template->setName($templateName);
        $template->setFixed($templateType);
        $template->setPriceRate($templatePriceRate);
        $template->setCalculationType($calculation_type);
        $template->setOverheadRate($templateOverheadRate);
        $template->setOverheadPrice($templateOverheadPrice);
        $template->setProfitRate($templateProfitRate);
        $template->setProfitPrice($templateProfitPrice);

        $template->setBasePrice($templateBasePrice);
        // Save
        $this->em->persist($template);
        $this->em->flush();

        // new template assgin all service by default
        if ($assignServices) {
            $services = $this->getEstimationRepository()->getAdminServices();
            foreach ($services as $category) {

                $eti = new \models\EstimationServiceTemplate();
                $eti->setServiceId($category->getServiceId());
                $eti->setTemplateId($template->getId());
                $eti->setCompanyId(0);
                $this->em->persist($eti);
                //$this->em->flush();
            }
            $this->em->flush();
        }

        if ($duplicateAssignServices) {
            $allItems = $this->getEstimationRepository()->getEstimateTemplateItems($templateId);

            foreach ($allItems as $templateItem) {
                $newTemplateItem = clone $templateItem;
                $newTemplateItem->setTemplateId($template->getId());
                $newTemplateItem->setId(NULL);
                $this->em->persist($newTemplateItem);
            }
            $this->em->flush();


            $serviceItems = $this->getEstimationRepository()->getAdminTemplateServices($templateId);

            foreach ($serviceItems as $serviceItem) {
                $newServiceItem = clone $serviceItem;
                $newServiceItem->setTemplateId($template->getId());
                $newServiceItem->setId(NULL);
                $this->em->persist($newServiceItem);
            }
            $this->em->flush();
            $typeName = ($templateType == 1) ? '[Fixed]' : '[Standard]';
            $this->log_manager->add('duplicate_template', '"' . $oldTemplate->getName() . '" template duplicated as "' . $templateName . '" ' . $typeName);
        }
        // Redirect
        $this->session->set_flashdata('success', 'Template Saved');
        redirect('admin/estimating_templates');
    }

    public function deleteAdminEstimatingTemplate($templateId)
    {
        // Load the template
        $template = $this->em->findEstimationTemplate($templateId);

        // Check it loaded
        if (!$template) {
            $this->session->set_flashdata('error', 'Error loading template');
            redirect('admin/estimating_templates');
            return;
        }


        // Good to go, delete the item records
        $this->getEstimationRepository()->deleteTemplateItems($template);

        // Delete the template itself
        $template->setDeleted('1');
        $this->em->persist($template);

        $this->em->flush();

        // Redirect
        $this->session->set_flashdata('success', 'Template Deleted');
        redirect('admin/estimating_templates');
    }


    public function edit_estimating_template($templateId)
    {
        // Load the template
        $template = $this->em->findEstimationTemplate($templateId);

        // Check it loaded
        if (!$template) {
            $this->session->set_flashdata('error', 'Template could not be loaded');
            redirect('admin/estimating_templates');
            return;
        }


        // Good to go, gather vars
        $data = [];
        //$data['layout'] = 'admin/estimating/edit_estimate_template';
        $data['template'] = $template;

        // Add datatables
        $this->html->addScript('dataTables');
        // Load the view
        // $this->load->view('admin/my_account', $data);
        $this->load->view('admin/estimating/edit_estimate_template', $data);
    }

    public function estimate_stats()
    {

        $data = [];
        $er = $this->getEstimationRepository();

        $data['company_count'] = $er->getEstimatesCompanyCount();

        $data['estimates_started'] = $er->getEstimatesStartedCount();
        $estimates_completed = $er->getEstimatesCompletedCount();

        $data['estimated_total'] = $er->getEstimatedValueTotal();

        if ($data['estimates_started'] > 0) {
            $data['estimates_completed'] = ($estimates_completed * 100) / $data['estimates_started'];
            $data['estimated_average'] = ceil($data['estimated_total'] / $data['estimates_started']);
        } else {
            $data['estimates_completed'] = '0.00';
            $data['estimated_average'] = '0.00';
        }


        //average
        // //$data['types'] = $er->getSortedTypes();
        // $data['services'] = $er->getAdminServices();
        // $this->html->addScript('dataTables');
        $this->load->view('admin/estimating/estimate_stats', $data);
    }

    public function creatDemoEstimate($companyId)
    {
        $company = $this->em->findCompany($companyId);

        $account = $company->getAdministrator();
        // $client = $this->em->find('models\Clients','87364');
        /*
         * Step 1 - create clients
         */
        //mike@pavementlayers.com
// check if client exist

        $client = $this->em->getRepository('models\Clients')->findOneBy(array(
            'email' => 'mike@pavementlayers.com',
            'company' => $company->getCompanyId(),
        ));

        if (!$client) {

            $clientAccount1 = new \models\ClientCompany();
            $clientAccount1->setCreated(time());
            $clientAccount1->setOwnerCompany($company);
            $clientAccount1->setOwnerUser($account);
            $clientAccount1->setName('Acme Apartments');
            $this->em->persist($clientAccount1);
            $this->em->flush();

            $client = new models\Clients();
            $client->setFirstName('Mike');
            $client->setLastName('Barrett');
            $client->setBusinessPhone('513-477-2727');
            $client->setEmail('mike@pavementlayers.com');
            $client->setCellPhone('513-477-2727');
            $client->setFax('');
            $client->setTitle('Property Manager');
            $client->setState('OH');
            $client->setWebsite(site_url());
            $client->setAddress('123 Main Street');
            $client->setCity('Cincinnati');
            $client->setZip('45227');
            $client->setCountry('USA');
            $client->setAccount($account);
            $client->setCompany($company);
            $client->setClientAccount($clientAccount1);
            $this->em->persist($client);
            $this->em->flush();
        }
        //print_r($client);die;
        $this->getEstimationRepository()->create_demo_estimate($company, $account, $client);

        $this->session->set_flashdata('success', "Demo Estimate Created ");
        //$this->log_manager->add(\models\ActivityAction::PROPOSAL_ESTIMATE_ACTIVATE, "Estimating deactivated for " . $company->getCompanyName());
        redirect('admin');
    }

    public function group_resends()
    {
        $data = [];
        $this->html->addScript('ckeditor4');
        $this->load->model('clientEmail');
        $data['emailTemplates'] = $this->clientEmail->getTemplates(NULL, \models\ClientEmailTemplateType::GLOB);
        $data['templateFields'] = $this->clientEmail->getTemplateFields(\models\ClientEmailTemplateType::GLOB);
        $data['resends'] = $this->getCompanyRepository()->getAdminResendList($this->account()->getCompany());
        $data['account'] = $this->account();
        $data['layout'] = 'admin/group_resends';
        $this->html->addScript('dataTables');
        $this->load->view('admin/group_resends', $data);
    }

    public function group_resends_data()
    {
        $company = $this->account()->getCompany();

        $tableData = [];
        $rowsData = [];
        // $itemsData = [];
        $itemsData = $this->getCompanyRepository()->getGroupResendData($company, false, $this->account());

        foreach ($itemsData as $dataRow) {
            $rowsData[] = $dataRow;
        }

        $tableData['sEcho'] = (int)$this->input->post('echo');
        $tableData['iTotalRecords'] = $this->getCompanyRepository()->getGroupResendData($company, true, $this->account());
        $tableData['iTotalDisplayRecords'] = $this->getCompanyRepository()->getGroupResendData($company, true, $this->account());
        $tableData['aaData'] = $rowsData;

        echo json_encode($tableData);
    }

    function resend()
    {
        // Auth checks

        $filter = $this->uri->segment(3);
        $this->session->set_userdata('pAdminResendFilter', 1);
        $this->session->set_userdata('pAdminResendFilterId', $filter);

        $this->index();
    }

    public function adminReorderText()
    {
        $k = 0;
        
        foreach ($_POST['text'] as $textId) {
            // Load the Customtext model
            $customText = $this->em->find('models\Customtext', $textId);
            
            // Set the Ord
            $customText->setOrd($k);
            // Persist
            $this->em->persist($customText);
            // Increment Ord
            $k++;
        }
        
        $this->em->flush();
        
        echo json_encode([
            'success' => 1,
            'message' => 'Data Updated'
        ]);
    }

    function proposal_sections()
    {

       
        $data['proposalCoolSections'] = $this->getCompanyRepository()->getAdminProposalCoolSections();
        $data['proposalStandardSections'] = $this->getCompanyRepository()->getAdminProposalStandardSections();
        $data['proposalCustomSections'] = $this->getCompanyRepository()->getAdminProposalCustomSections();
        $this->load->view('admin/proposal_section', $data);
    }

    function work_order_sections()
    {

       
        $data['workOrderSections'] = $this->getCompanyRepository()->getAdminWorkOrderSections();
       
        $this->load->view('admin/admin_work_order_section', $data);
    }

    /**
     * @description Set the order of workOrder Type for this company
     */
    public function order_admin_work_order_section()
    {


        $types = $this->input->post('type');

        if (count($types)) {
            $i = 1;
            foreach ($types as $type) {
                $bt = $this->em->find('models\WorkOrderSection', $type);
                $bt->setOrd($i);
                $this->em->persist($bt);
                $i++;
            }
            $this->em->flush();
        }
        echo json_encode(array('error' => 0));
    }


    function hide_show_admin_work_order_section(){
        
        if ($this->input->post('sectionId')) {
            $proposal_section = $this->em->find('\models\WorkOrderSection', $this->input->post('sectionId'));

            $proposal_section->setVisible($this->input->post('action'));
            $this->em->persist($proposal_section);
            $this->em->flush();
            
            // $this->log_manager->add('Delete Business Type',
            //     "Business Type '" . $business_type->getTypeName() . "' Deleted ", null, null, $this->account());
            $data = array();
            $data['error'] = 0;
            $data['isSuccess'] = true;

            echo json_encode($data);
            die;
            
        }
    }

    function add_master_company()
    {
        $data = array();
        
        if ($this->input->post('addNewCompany')) {
            
            $childCompanyIds = $this->input->post('child_companies');
       
            if($this->input->post('superUserType') == '2'){
                $account = new models\Accounts();
            }else{
                $account = $this->em->findAccount($this->input->post('company_admin_id'));
            }
            
            
            $company = new models\Companies();
            
            $company->setStandardLayoutIntro('We are happy to present to you the following proposal for work to be performed. If you have any questions, please do not hesitate to call us.');
            $company->setCompanyName($this->input->post('companyName'));
            $company->setCompanyCountry($this->input->post('companyCountry'));
            $company->setCompanyAddress($this->input->post('companyAddress'));
            $company->setCompanyWebsite($this->input->post('companyWebsite'));
            $company->setCompanyCity($this->input->post('companyCity'));
            $company->setCompanyPhone($this->input->post('companyPhone'));
            $company->setCompanyState($this->input->post('companyState'));
            $company->setCompanyPhone($this->input->post('companyPhone'));
            $company->setAlternatePhone($this->input->post('alternatePhone'));
            $company->setCompanyZip($this->input->post('companyZip'));
            $company->setPaymentTerm(0);
            $company->setCompanyLogo('');
            $company->setHearAboutUs('Admin Created Account');
            $company->setPaymentTermText('I am authorized to approve and sign this project as described in this proposal as well as identified below with our payment terms and options.');
            $company->setAdministrator($account);
            $company->setCompanyStatus($this->input->post('companyStatus'));
            $company->setIsMaster(1);

            $expDate = explode('/', $this->input->post('expires'));
            $expires = mktime(23, 59, 59, $expDate[0], $expDate[1], $expDate[2]);

            $this->em->persist($company);
            $this->em->flush();
            
            if($this->input->post('superUserType') == '2'){
                $account->setEmail($this->input->post('accountEmail'));
                //$account->setPassword('Players_123');   // We're no longer setting passwords
                $account->setRecoveryCode();                            //  Set a code for the user to set their own instead
                $account->setFirstName($this->input->post('firstName'));
                $account->setLastName($this->input->post('lastName'));
                $account->setCountry($this->input->post('companyCountry'));
                $account->setCity($this->input->post('companyCity'));
                $account->setState($this->input->post('companyState'));
                $account->setTitle('Administrator');
                $account->setCellPhone($this->input->post('companyPhone'));
                $account->setFax($this->input->post('alternatePhone'));
                $account->setAddress($this->input->post('companyAddress'));
                $account->setZip($this->input->post('companyZip'));
                $account->setTimeZone('EST');
                $account->setCompany($company);
                $account->setFullAccess('yes');
                $account->setOfficePhone($this->input->post('companyPhone'));
                $account->setCreated(time());
                $account->setExpires($expires);
                $account->unDelete();
            }else{
                $account->setParentCompanyId($company->getCompanyId());
            }
            
            
           
            
            


            $account->setIsSuperUser(1);
            $this->em->persist($account);

            $this->em->flush();

            if($this->input->post('superUserType') == '2'){
                //Set Password email send
                $account->sendNewUserEmail();
            }

             //Save Child Relations
             foreach($childCompanyIds as $childCompanyId){
                $relation = new models\CompanyParentChildRelation();
                $relation->setParentCompanyId($company->getCompanyId());
                $relation->setChildCompanyId($childCompanyId);
                $this->em->persist($relation);

                $childCompany = $this->em->findCompany($childCompanyId);

                if($account->getCompany()->getCompanyId() != $childCompanyId){
                    $childAccount = new models\Accounts();
                    $childAccount->setEmail($childCompanyId.'_'.$account->getEmail());
                
                    $childAccount->setRecoveryCode();                            //  Set a code for the user to set their own instead
                    $childAccount->setFirstName($account->getFirstName());
                    $childAccount->setLastName($account->getLastName());
                    $childAccount->setCountry($this->input->post('companyCountry'));
                    $childAccount->setCity($this->input->post('companyCity'));
                    $childAccount->setState($this->input->post('companyState'));
                    $childAccount->setTitle('Administrator');
                    $childAccount->setCellPhone($this->input->post('companyPhone'));
                    $childAccount->setFax($this->input->post('alternatePhone'));
                    $childAccount->setAddress($this->input->post('companyAddress'));
                    $childAccount->setZip($this->input->post('companyZip'));
                    $childAccount->setTimeZone('EST');
                    $childAccount->setCompany($childCompany);
                    $childAccount->setFullAccess('yes');
                    $childAccount->setOfficePhone($this->input->post('companyPhone'));
                    $childAccount->setCreated(time());
                    $childAccount->setUserClass(3);
                    $childAccount->setExpires($expires);
                    $childAccount->setHidden();
                    $childAccount->setParentUserId($account->getAccountId());
                    $this->em->persist($childAccount);
                }

            }
            $this->em->flush();
            

            // Create Residential Account
            $residentialAccount = new \models\ClientCompany();
            $residentialAccount->setName('Residential');
            $residentialAccount->setOwnerCompany($company);
            $residentialAccount->setOwnerUser($account);
            $residentialAccount->setCreated(time());
            $this->em->persist($residentialAccount);
            $this->em->flush();

            $this->session->set_flashdata('success', 'Company added successfully!');


            redirect('admin/master_company_list');
        }
        $data['childCompanies'] = \models\Companies::getAllChildCompanies();
        
        $this->load->view('admin/add_master_company', $data);
    }

    function master_company_list()
    {
        $data = [];
        // $this->load->model('clientEmail');
        // $data['emailTemplates'] = $this->clientEmail->getTemplates(NULL, \models\ClientEmailTemplateType::GLOB);
        // $data['templateFields'] = $this->clientEmail->getTemplateFields(\models\ClientEmailTemplateType::GLOB);
        // $data['resends'] = $this->getCompanyRepository()->getAdminResendList($this->account()->getCompany());
        $this->html->addScript('dataTables');
        $this->html->addScript('ckeditor4');
       // $data['resendId'] = $this->uri->segment(3) ?: '';
       // $data['campaignEmailFilter'] = $this->uri->segment(4) ?: '';
       // $data['filterResend'] = false;
        $data['show_last_activity'] = 'true';
        $data['show_opened_at'] = 'false';
        
        $this->load->view('admin/master_company_list', $data);
        

    }

    public function masterCompaniesTableData()
    {
        $json = array();
        $this->load->database();

        $totalCompanies = $this->db->query("SELECT COUNT(companyId) AS numCompanies FROM companies where is_master = 1")->row()->numCompanies;

        // Get the table data
        $companies = $this->account()->getMasterCompaniesTableData();

        // Build the response
        $companiesData = [];

        foreach ($companies as $company) {
            $companyName =  '<div style="display: flex;justify-content: space-between;"><div>'.$company->companyName.'</div><div><span style="display: flex;float:right;justify-content: flex-end;text-align:right;font-size: 14px;">';
            
            $childCompanies =  $this->getCompanyRepository()->getParentChildCompanies($company->companyId);

            $childCompanyNames = '';
            foreach($childCompanies as $childCompany){
                $childCompanyNames .= $childCompany->companyName.'</br>';
            }
            
            $displayAddNote = ($company->ncount) ? false : true;
            $companyName .= ' <a href="javascript:void(0);"  class="view-notes comapny_table_notes_tiptip hasNotes" data-value-id="'.$company->companyId.'" data-val="'.$company->companyId.'"  style="font-size: 14px;color:#a5a2a2; display:' . (($displayAddNote) ? 'none' : 'block') . '"><i class="fa fa-fw fa-sticky-note-o "  ></i></a>';
            $companyName .= '<a href="javascript:void(0);"class="view-notes tiptip hasNoNotes" title="Add Company Notes"  data-value-id="'.$company->companyId.'"  style="font-size: 14px;color:#a5a2a2;float:right; display:' . (($displayAddNote) ? 'block' : 'none') . '"><i class="fa fa-fw fa-plus"></i></a>';
            $companyName .= '</div></span></div>';

            $companyData = [
                // 0 - Checkbox
                '0' => $this->load->view('templates/admin/table/check', array('company' => $company), true),
                // 1 - Company Id
                '1' => $company->companyId,
                // 2 - Company Name
                '2' => $companyName,
                // 3 -Child Companies
                '3' => '<a href="#" class="tiptip" title="'.$childCompanyNames.'">'.count($childCompanies).'</a>',
                // 4 - Company Status
                '4' => $this->load->view('templates/admin/table/status', array('company' => $company), true),
                // 5 - Num Users
                '5' => $company->numUsers,
                // 6 - Paid Users
                '6' => $company->numPaidUsers,
                // 7 - Inactive Users
                '7' => $company->numInactiveUsers,
                // 8 - Next Expiry
                '8' => $this->load->view('templates/admin/table/expires', array('company' => $company), true),
                // 9 - Administrator
                '9' => $company->adminFullName,
                // // 9 - Layouts
                // '9' => $company->new_layouts ? 'Yes' : 'No',
                // // 10 - PSA
                // '10' => $company->psa ? 'Yes' : 'No',
                // // 10 - estimating
                // '11' => $company->estimating ? 'Yes' : 'No',
                // 12 - Actions
                // '10' => $this->load->view('templates/admin/table/actions', array('company' => $company), true),
                '10' => $this->load->view('templates/admin/table/actions2', array('company' => $company), true),

            ];

            $companiesData[] = $companyData;
        }

        $json["iTotalRecords"] = $totalCompanies;
        $json["iTotalDisplayRecords"] = $this->account()->getMasterCompaniesTableData(true);
        $json['aaData'] = $companiesData;
        $json['sEcho'] = $this->input->get('sEcho');
        echo json_encode($json);
    }


    function add_super_account()
    {
        $company = $this->em->find('models\Companies', $this->uri->segment(3));
        if (!$company) {
            $this->session->set_flashdata('success', 'Invalid company ID!');
            redirect('admin');
        }
        $data = array();

        if ($this->input->post('addNewAccount')) {

            $childCompanies =  $this->getCompanyRepository()->getParentChildCompanies($company->getCompanyId());

          //  echo "<pre>";print_r($childCompanies);
            //$childCompanyIds = $this->input->post('child_companies');
            if($this->input->post('superUserType') == '2'){
                $account = new models\Accounts();
            }else{
                $account = $this->em->findAccount($this->input->post('existing_user_id'));
                $account_company_id = $account->getCompany()->getCompanyId();
                $companyAssigned = $this->em->createQuery('SELECT cpc FROM models\CompanyParentChildRelation cpc  where cpc.parent_company_id ='.$company->getCompanyId().' AND cpc.child_company_id = '.$account_company_id)->getResult();
                if(!$companyAssigned){

                    $relation = new models\CompanyParentChildRelation();
                    $relation->setParentCompanyId($company->getCompanyId());
                    $relation->setChildCompanyId($account_company_id);
                    $this->em->persist($relation);
                }
            }
            
           

            $expDate = explode('/', $this->input->post('expires'));
            $expires = mktime(23, 59, 59, $expDate[0], $expDate[1], $expDate[2]);

            if($this->input->post('superUserType') == '2'){
                $account->setEmail($this->input->post('accountEmail'));
                $account->setPassword($this->input->post('password'));   // We're no longer setting passwords
                $account->setRecoveryCode();                            //  Set a code for the user to set their own instead
                $account->setFirstName($this->input->post('firstName'));
                $account->setLastName($this->input->post('lastName'));
                $account->setCountry($company->getCompanyCountry());
                $account->setCity($company->getCompanyCity());
                $account->setState($company->getCompanyState());
                $account->setTitle('Administrator');
                $account->setCellPhone($company->getCompanyPhone());
                $account->setFax($company->getAlternatePhone());
                $account->setAddress($company->getCompanyAddress());
                $account->setZip($company->getCompanyZip());
                $account->setTimeZone('EST');
                $account->setCompany($company);
                $account->setFullAccess('yes');
                $account->setOfficePhone($company->getCompanyPhone());
                $account->setCreated(time());
                $account->setExpires($expires);
                $account->unDelete();
            }else{
                $account->setParentCompanyId($company->getCompanyId());
            }
            

            $account->setIsSuperUser(1);
            $this->em->persist($account);

            $this->em->flush();

            // echo "<pre>";
            // print_r($childCompanies);die;

           
             //Save Child Relations
             foreach($childCompanies as $childCo){

                // $relation = new models\CompanyParentChildRelation();
                // $relation->setParentCompanyId($company->getCompanyId());
                // $relation->setChildCompanyId($childCompanyId);
                // $this->em->persist($relation);
                

                $childCompany = $this->em->findCompany($childCo->companyId);   

                if($account->getCompany()->getCompanyId() != $childCo->companyId){
                    $childAccount = new models\Accounts();
                    $childAccount->setEmail($childCo->companyId.'_'.$account->getEmail());
                
                    $childAccount->setRecoveryCode();                            //  Set a code for the user to set their own instead
                    $childAccount->setFirstName($account->getFirstName());
                    $childAccount->setLastName($account->getLastName());
                    $childAccount->setCountry($childCompany->getCompanyCountry());
                    $childAccount->setCity($childCompany->getCompanyCity());
                    $childAccount->setState($childCompany->getCompanyState());
                    $childAccount->setTitle('Administrator');
                    $childAccount->setCellPhone($childCompany->getCompanyPhone());
                    $childAccount->setFax($childCompany->getAlternatePhone());
                    $childAccount->setAddress($childCompany->getCompanyAddress());
                    $childAccount->setZip($childCompany->getCompanyZip());
                    $childAccount->setTimeZone('EST');
                    $childAccount->setCompany($childCompany);
                    $childAccount->setFullAccess('yes');
                    $childAccount->setOfficePhone($this->input->post('companyPhone'));
                    $childAccount->setCreated(time());
                    $childAccount->setUserClass(3);
                    $childAccount->setExpires($expires);
                    $childAccount->setHidden();
                    $childAccount->setParentUserId($account->getAccountId());
                    $this->em->persist($childAccount);
                }

            }
            $this->em->flush();

            // echo "<pre>";print_r($childCompanies);

            //     echo "<pre>";print_r($_POST);

            //     die;



            $this->session->set_flashdata('success', 'Account added succesfully!');
            redirect('admin/master_company_list');
        }
        $this->load->view('admin/add_super_account', $data);
    }


    function add_child_company(){

        

        $parentCompany = $this->em->find('models\Companies', $this->uri->segment(3));

 
        if (!$parentCompany) {
            $this->session->set_flashdata('success', 'Invalid company ID!');
            redirect('admin');
        }
        $data = array();

        
        if ($this->input->post('addNewChildCompany')) {
             
            $expires = Carbon::now()->addYear()->timestamp;
            $childCompanyIds = $this->input->post('child_companies');

        
            //Save Child Relations
            foreach($childCompanyIds as $childCompanyId){
                
                $relation = new models\CompanyParentChildRelation();
                $relation->setParentCompanyId($parentCompany->getCompanyId());
                $relation->setChildCompanyId($childCompanyId);
                $this->em->persist($relation);
                
                
                $childCompany = $this->em->findCompany($childCompanyId);
             

                $query = $this->em->createQuery('SELECT a FROM models\Accounts a where a.company is not NULL and (a.company=' . $parentCompany->getCompanyId() . ' OR a.parent_company_id =' . $parentCompany->getCompanyId() . ') ORDER BY a.expires ASC');

                 $accounts = $query->getResult();  
                 
             

                foreach($accounts as $account){
                    $childAccount = new models\Accounts();
                    $childAccount->setEmail($childCompanyId.'_'.$account->getEmail());
                
                    $childAccount->setRecoveryCode();                            //  Set a code for the user to set their own instead
                    $childAccount->setFirstName($account->getFirstName());
                    $childAccount->setLastName($account->getLastName());
                    $childAccount->setCountry($childCompany->getCompanyCountry());
                    $childAccount->setCity($childCompany->getCompanyCity());
                    $childAccount->setState($childCompany->getCompanyState());
                    $childAccount->setTitle('Administrator');
                    $childAccount->setCellPhone($childCompany->getCompanyPhone());
                    $childAccount->setFax($childCompany->getAlternatePhone());
                    $childAccount->setAddress($childCompany->getCompanyAddress());
                    $childAccount->setZip($childCompany->getCompanyZip());
                    $childAccount->setTimeZone('EST');
                    $childAccount->setCompany($childCompany);
                    $childAccount->setFullAccess('yes');
                    $childAccount->setOfficePhone($this->input->post('companyPhone'));
                    $childAccount->setCreated(time());
                    $childAccount->setUserClass(3);
                    $childAccount->setExpires($expires);
                    $childAccount->setHidden();
                    $childAccount->setParentUserId($account->getAccountId());
                    $this->em->persist($childAccount);
                }

                 
            }
            $this->em->flush();



            $this->session->set_flashdata('success', 'Child Company added succesfully!');
            redirect('admin/master_company_list');
        }

        $data['childCompanies'] = \models\Companies::getAllChildCompanies(); 
        $this->load->view('admin/add_child_company', $data);

    }

    //enable Sales Manager
    public function enableSalesManager($companyId)
    {
        $company = $this->em->findCompany($companyId);
           if ($company) {
            $company->setSalesManager(1);
            $this->em->persist($company);
             } 
             $this->em->flush();
             $this->session->set_flashdata('success', 'Sales Manager Enabled');
            $this->log_manager->add(\models\ActivityAction::PROPOSAL_ESTIMATE_ACTIVATE, "Sales Manager activated for " . $company->getCompanyName());
            redirect('admin/');
    }

    //disable Sales Manager
    public function disableSalesManager($companyId)
    {
          $company = $this->em->findCompany($companyId);
        if ($company) {
            $company->setSalesManager(0);
            $this->em->persist($company);
        } 
        $this->em->flush();
        $this->session->set_flashdata('success', 'Sales Manager Disabled');
        $this->log_manager->add(\models\ActivityAction::PROPOSAL_ESTIMATE_ACTIVATE, "Sales Manager deactivated for " . $company->getCompanyName());
        redirect('admin/');
    }

    //enable modify price
    public function enableModifyPrice($companyId)
    {
        $company = $this->em->findCompany($companyId);
           if ($company) {
            $company->setModifyPrice(1);
            $this->em->persist($company);
            
             } 
             $this->em->flush();
             $this->session->set_flashdata('success', 'Modify Price Enabled');
            $this->log_manager->add(\models\ActivityAction::PROPOSAL_ESTIMATE_ACTIVATE, "Modify Price activated for " . $company->getCompanyName());
            redirect('admin/');
    }
    //disable modify price
    public function disableModifyPrice($companyId)
    {
          $company = $this->em->findCompany($companyId);
        if ($company) {
            $company->setModifyPrice(0);
            $this->em->persist($company);
            
        } 
        $this->em->flush();
        $this->session->set_flashdata('success', 'Modify Price Disabled');
        $this->log_manager->add(\models\ActivityAction::PROPOSAL_ESTIMATE_ACTIVATE, "Modify Price deactivated for " . $company->getCompanyName());
        redirect('admin/');
    }

        //enable proposal
        public function enableProposalCampaigns($companyId)
        {
            $company = $this->em->findCompany($companyId);
            $company->setProposalCampaigns(1);
            $this->em->persist($company);
            $this->em->flush();              
            $this->session->set_flashdata('success', 'Proposal Campaigns Enabled');
            $this->log_manager->add(\models\ActivityAction::PROPOSAL_ESTIMATE_ACTIVATE, "Proposal Campaigns activated for " . $company->getCompanyName());
            redirect('admin/'); 
        }

         //disable proposal
         public function disableProposalCampaigns($companyId)
         {
            $cacheDriver = $this->em->getConfiguration()->getResultCacheImpl();
            if ($cacheDriver) {
                $cacheDriver->deleteAll();
            }
            $company = $this->em->findCompany($companyId);
            $company->setProposalCampaigns(0);
            $this->em->persist($company);
            $this->em->flush();
            $this->session->set_flashdata('success', 'Proposal Campaigns Disabled');
            $this->log_manager->add(\models\ActivityAction::PROPOSAL_ESTIMATE_ACTIVATE, "Proposal Campaigns deactivated for " . $company->getCompanyName());
            redirect('admin/');             
         }

            //enable Proposal Checklist
        public function enableProposalChecklist($companyId)
        {
            $cacheDriver = $this->em->getConfiguration()->getResultCacheImpl();
            if ($cacheDriver) {
                $cacheDriver->deleteAll();
            }

                $company = $this->em->findCompany($companyId);
                $company->setProposalChecklist(1);
                $this->em->persist($company);
                $this->em->flush();              
                $this->session->set_flashdata('success', 'Customer Checklist Enabled');
                $this->log_manager->add(\models\ActivityAction::PROPOSAL_ESTIMATE_ACTIVATE, "Customer Checklist activated for " . $company->getCompanyName());
                redirect('admin/');
        }

        //disable Proposal Checklist
        public function disableProposalChecklist($companyId)
        {
            $company = $this->em->findCompany($companyId);
            if ($company) {
                $company->setProposalChecklist(0);
                $this->em->persist($company);
            } 
            $this->em->flush();
            $this->session->set_flashdata('success', 'Customer Checklist Disabled');
            $this->log_manager->add(\models\ActivityAction::PROPOSAL_ESTIMATE_ACTIVATE, "Customer Checklist deactivated for " . $company->getCompanyName());
            redirect('admin/');
        }
 
        // Add a Quickbook sync function 
        function quickbooks_sync()
        {
            $data = array();
            if ($this->uri->segment(3)) {
                $company = $this->em->find('models\Companies', $this->uri->segment(3));
                if (!$company) {
                    header('Location: ' . site_url('admin/quickbooks_sync'));
                }
                $data['company'] = $company;
            }
          
            $this->html->addScript('dataTables');
            $this->load->view('admin/quickbook_sync', $data); 
        }

 

        
        public function user_data_export() {
            $data = [];
            $users = [];
        
            $currentYear = date('Y');
            $proposalUserQuery = "SELECT 
                accounts.accountId AS account_id,
                companies.companyName AS companyName,
                accounts.wio AS Wio,
                accounts.sales AS Sales,
                accounts.secretary AS Secretary,
                DATE_FORMAT(FROM_UNIXTIME(accounts.created), '%m-%d-%y') AS created_date,
                DATE_FORMAT(FROM_UNIXTIME(accounts.expires), '%m-%d-%y') AS expires_date,
                DATE_FORMAT(accounts.last_login, '%m-%d-%y') AS last_login,
                CONCAT(accounts.firstName, ' ', accounts.lastName) AS full_name,
                CASE 
                    WHEN accounts.userClass = 0 THEN 'User'
                    WHEN accounts.userClass = 1 THEN 'Branch Manager'
                    WHEN accounts.userClass = 2 THEN 'Full Access'
                    WHEN accounts.userClass = 3 THEN 'Administrator'
                    ELSE 'Unknown'
                END AS user_role
            FROM accounts 
            LEFT JOIN companies ON companies.companyId = accounts.company
            WHERE YEAR(FROM_UNIXTIME(accounts.created)) = $currentYear
            ORDER BY accounts.firstName ASC";
        
            // Execute the query
            $users = $this->db->query($proposalUserQuery)->result();
       
        
            // Define the fields
            $fields = ["Account ID", "User Name", "Company Name","Type", "Wio", "Sales", "Secretary", "created_date", "expires_date", "last_login"];
        
            // Add the header to data
            if (is_array($fields)) {
                $labels = $fields;
                $data[] = $labels;
            }
        
            // Populate data array with user records
            foreach ($users as $record) {
                $p = [];
                foreach ($fields as $value) {
                    switch ($value) {
                        case 'Account ID':
                            $p[] = $record->account_id;
                            break;
                        case 'User Name':
                            $p[] = $record->full_name;
                            break;
                        case 'Company Name':
                            $p[] = $record->companyName;
                            break;
                        case 'Type':
                            $p[] = $record->user_role;
                            break;
                        case 'Wio':
                            $p[] = $record->Wio;
                            break;
                        case 'Sales':
                            $p[] = $record->Sales;
                            break;
                        case 'Secretary':
                            $p[] = $record->Secretary;
                            break;
                        case 'created_date':
                            $p[] = $record->created_date;
                            break;
                        case 'expires_date':
                            $p[] = $record->expires_date;
                            break;
                        case 'last_login':
                            $p[] = $record->last_login;
                            break;                    
                        default:
                            $p[] = $value . ' undefined.';
                            break;
                    }
                }
                $data[] = $p;
            }
        
            // Call the export function
            $fileName = "user_export_" . time() . ".csv";
            export($data, 'csv', $fileName, false);
        }


        public function recent_added_user()
        {
            $this->html->addScript('dataTables');
            $data['defaultCustomFrom'] = $this->session->userdata('pStatusFilterFrom') ?: $this->account()->getCompany()->getCreated(false);
            $data['defaultCustomTo'] = $this->session->userdata('pStatusFilterTo') ?: date('m/d/Y');
            $this->load->view('admin/recent_added_user',$data);
        }

        public function recentAddedUserTable()
        {
            $data = [];
            $users = []; 
            $users = $this->getLatestAddedUserTableData(false);
            $recentUserData = [];
  
            foreach ($users as $userData) {
                $companyData = [
                    '0' => $userData->created_date ?? '-',
                    '1' => $userData->expires_date ?? '-',
                    '2' => $userData->companyStatus ?? '-',
                    '3' => $userData->companyName ?? '-',
                    '4' => $userData->full_name ?? '-',
                    '5' => $userData->user_role ?? '-',
                    '6' => $userData->email ?? '-',
                    '7' => $userData->cellPhone ?? '-', 

                 ];
    
                $recentUserData[] = $companyData;
            } 
            $json["iTotalRecords"] = count($users);
            $json["iTotalDisplayRecords"] = $this->getLatestAddedUserTableData(true);
            $json['aaData'] = $recentUserData;
            $json['sEcho'] = $this->input->get('sEcho');
            echo json_encode($json);
         }

 

       public  function getLatestAddedUserTableData($count = false)
       {

              $time['start'] = 0;
              $time['finish'] = Carbon::create()->endOfDay()->timestamp;
              $range = $this->input->get('range');

              if ($range!='custom' && $range!="quarter" && $range!="month") {    
                $time = getRangeStartFinish($range);                                
               } else {
               $customFrom = $this->input->get('customFrom');
               $customTo = $this->input->get('customTo');
                //    $time['start'] = 0;
                //    $time['finish'] = Carbon::create()->endOfDay()->timestamp;
                $time['start'] = Carbon::parse($customFrom)->startOfDay()->timestamp;
                $time['finish'] = Carbon::parse($customTo)->endOfDay()->timestamp;
             
               if($range=="quarter")
               {
                   $time['start'] = Carbon::now()->subDays(90)->startOfDay()->timestamp;
                   $time['finish'] = Carbon::now()->endOfDay()->timestamp;
               }
               if($range=="month")
               {
                $time['start'] = Carbon::now()->subMonth()->startOfMonth()->startOfDay()->timestamp;
                $time['finish'] = Carbon::create()->endOfDay()->timestamp;
               }
           }  

                // Get the current year
                $sql = "SELECT 
                accounts.accountId AS account_id,
                companies.companyName AS companyName,
                companies.companyStatus AS companyStatus,
                accounts.sales AS Sales,
                accounts.email as email,
                accounts.cellPhone as cellPhone,
                DATE_FORMAT(FROM_UNIXTIME(accounts.created), '%m-%d-%y') AS created_date,
                DATE_FORMAT(FROM_UNIXTIME(accounts.expires), '%m-%d-%y') AS expires_date,
                DATE_FORMAT(accounts.last_login, '%m-%d-%y') AS last_login,
                CONCAT(accounts.firstName, ' ', accounts.lastName) AS full_name,
                CASE 
                    WHEN accounts.userClass = 0 THEN 'User'
                    WHEN accounts.userClass = 1 THEN 'Branch Manager'
                    WHEN accounts.userClass = 2 THEN 'Full Access'
                    WHEN accounts.userClass = 3 THEN 'Administrator'
                    ELSE 'Unknown'
                END AS user_role
            FROM accounts 
            LEFT JOIN companies ON companies.companyId = accounts.company
            WHERE accounts.created BETWEEN " . $this->db->escape($time['start']) . " AND " . $this->db->escape($time['finish']). "
            AND accounts.parent_user_id = 0";;
            // Sorting parameters
            $sortCol = $this->input->get('order')[0]['column'];
            $sortDir = $this->input->get('order')[0]['dir'];

            // Search
            $searchVal = $this->input->get('search')['value'];
            if ($searchVal) {
                $searchVal = $this->db->escape_like_str($searchVal);
                $sql .= " AND ((CONCAT(accounts.firstName, ' ', accounts.lastName) LIKE '%" . $searchVal . "%')
                        OR (companies.companyName LIKE '%" . $searchVal . "%') OR (accounts.email LIKE '%" . $searchVal . "%')  OR (accounts.cellPhone LIKE '%" . $searchVal . "%'))";
            }

            // Sorting
            $sortColumns = [
                0 => 'accounts.firstName',
                1 => 'email',
                2 => 'cellPhone',
                3 => 'companies.companyName',
                4 => 'accounts.userClass',
                5 => 'companies.companyStatus',
                6 => 'accounts.created',
                7 => 'accounts.expires',
              ];

            if (isset($sortColumns[$sortCol])) {
                $sql .= ' ORDER BY ' . $sortColumns[$sortCol] . ' ' . $this->db->escape_str($sortDir);
            }

            // Return count if requested
            if ($count) {
                return $this->db->query($sql)->num_rows();
            }

            // Paging
            $length = $this->input->get('length');
            $start = $this->input->get('start');
 
            if ($length != -1 ) {
                $sql .= ' LIMIT ' . $this->db->escape_str($start) . ', ' . $this->db->escape_str($length);
            }

            // Execute query and fetch results
            $data = $this->db->query($sql)->result();
           // echo $this->db->last_query();die;
            $this->db->close();
            return $data; 
}
 
public function export_csv()
{
    $data = [];
    $users = $this->exportLatestAddedUser();
    //$fields = ["User Name","Email","Phone", "Company Name", "Role", "Status", "created_date", "expires_date"];
    $fields = ["created_date","expires_date","Status", "Company Name", "User Name", "Role", "Email", "Phone"];

    // Add the header to data
    if (is_array($fields)) {
        $labels = $fields;
        $data[] = $labels;
    }
    foreach ($users as $record) {
        $p = [];
        foreach ($fields as $value) {
            switch ($value) {
                case 'User Name':
                    $p[] = $record->full_name;
                    break;
                case 'Email':
                    $p[] = $record->email;
                    break;
                case 'Phone':
                    $p[] = $record->cellPhone;
                    break;
                case 'Company Name':
                    $p[] = $record->companyName;
                    break;
                case 'Role':
                    $p[] = $record->user_role;
                    break;
                case 'Status':
                    $p[] = $record->companyStatus;
                    break;                        
                case 'created_date':
                    $p[] = $record->created_date;
                    break;
                case 'expires_date':
                    $p[] = $record->expires_date;
                    break;
                default:
                    $p[] = $value . ' undefined.';
                    break;
            }
        }
        $data[] = $p;
    }

    // Generate CSV content
    $csvContent = '';
    foreach ($data as $row) {
        $escapedRow = array_map(function($field) {
            return '"' . str_replace('"', '""', $field) . '"';
        }, $row);
        $csvContent .= implode(",", $escapedRow) . "\n";
    }
    // Save CSV to a file
    $filePath = 'exports/user_export_' . time() . '.csv';
    file_put_contents($filePath, $csvContent);
    // Return JSON response with file path
    echo json_encode(['filePath' => $filePath]);
    exit;
} 
public function exportLatestAddedUser()
{
    $time['start'] = 0;
    $time['finish'] = Carbon::create()->endOfDay()->timestamp;
    $range = trim($this->input->post('range'));  
    $customFrom = trim($this->input->post('customFrom'));   
    $customTo = trim($this->input->post('customTo'));  

       if ($range!='custom' && $range!="quarter" && $range!="month") {    
           $time = getRangeStartFinish($range);                                
      } else {
            
            //   $time['start'] = 0;
            //   $time['finish'] = Carbon::create()->endOfDay()->timestamp;

            $time['start'] = Carbon::parse($customFrom)->startOfDay()->timestamp;
              $time['finish'] = Carbon::parse($customTo)->endOfDay()->timestamp;
        
          if($range=="quarter")
          {
              $time['start'] = Carbon::now()->subDays(90)->startOfDay()->timestamp;
              $time['finish'] = Carbon::now()->endOfDay()->timestamp;
          }
          if($range=="month")
          {
            $time['start'] = Carbon::now()->subMonth()->startOfMonth()->startOfDay()->timestamp;
            $time['finish'] = Carbon::create()->endOfDay()->timestamp;
          }
      }
      // Get the current year
      $sql = "SELECT 
      companies.companyName AS companyName,
      companies.companyStatus AS companyStatus,
      accounts.sales AS Sales,
      accounts.email AS email,
      accounts.cellPhone AS cellPhone,
      DATE_FORMAT(FROM_UNIXTIME(accounts.created), '%m-%d-%y') AS created_date,
      DATE_FORMAT(FROM_UNIXTIME(accounts.expires), '%m-%d-%y') AS expires_date,
      DATE_FORMAT(accounts.last_login, '%m-%d-%y') AS last_login,
      CONCAT(accounts.firstName, ' ', accounts.lastName) AS full_name,
      CASE 
          WHEN accounts.userClass = 0 THEN 'User'
          WHEN accounts.userClass = 1 THEN 'Branch Manager'
          WHEN accounts.userClass = 2 THEN 'Full Access'
          WHEN accounts.userClass = 3 THEN 'Administrator'
          ELSE 'Unknown'
      END AS user_role
  FROM accounts 
  LEFT JOIN companies ON companies.companyId = accounts.company
  WHERE accounts.created BETWEEN " . $this->db->escape($time['start']) . " AND " . $this->db->escape($time['finish']). "
            AND accounts.parent_user_id = 0";
   // Execute query and fetch results
  $data = $this->db->query($sql)->result();
 //echo $this->db->last_query();die;
  $this->db->close();
  return $data; 

}

        
        
}
