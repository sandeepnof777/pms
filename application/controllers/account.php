<?php
use Carbon\Carbon;
use Doctrine\ORM\Tools\SchemaValidator;
use Intervention\Image\ImageManager;
use League\Csv\Reader;
use League\Csv\Writer;
use models\EstimationCategory;
use models\EstimationItem;
use models\EstimationType;
use models\EstimationPlant;
use models\EstimationDump;
use models\EstimationCrew;
use Ipdata\ApiClient\Ipdata;
use Symfony\Component\HttpClient\Psr18Client;
use Nyholm\Psr7\Factory\Psr17Factory;

class Account extends MY_Controller
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    var $em;
    /**
     * @var CI_Form_validation
     */
    var $form_validation;
    /**
     * @var CI_Session
     */
    var $session;
    /**
     * @var CI_Input
     */
    var $input;
    /**
     * @var Log_manager
     */
    var $log_manager;
    /**
     * @var Customtexts
     */
    var $customtexts;
    /**
     * @var Html
     */
    var $html;
    /**
     * @var AccountSettings
     */
    var $accountSettings;
    /**
     * @var Calculator
     */
    var $calculator;
    /**
     * @var System_email
     */
    var $system_email;
    /**
     * @var ClientEmail
     */
    var $clientEmail;
    /**
     * @var branchesapi
     */
    var $branchesapi;

    /**
     * @var ServiceFieldHelper
     */
    var $servicefieldhelper;

    /**
     * @var ServiceTextHelper
     */
    var $servicetexthelper;

    /** @var ServiceHelper */
    var $servicehelper;

    /**
     * @var CustomtextRepository
     */
    var $customtextrepository;

    function __construct()
    {
 
        $this->login_restricted = true;
        parent::__construct();
          $this->html->addCSS(site_url('static/my-style.css'));
        // Configure the model
          //allow logout
        if ($this->uri->segment(2) != 'logout') {
            //check if the user is expired/disabled
            if ($this->account()->isExpired() || $this->account()->getDisabled()) {
                //check if there's actually a global admin logged on an expired/disabled user
                $logged_main_account = $this->em->find('models\Accounts', $this->session->userdata('accountId'));
                if (!$logged_main_account->isGlobalAdministrator()) {
                    //if it's a global admin it doesn't care
                    if (!$this->account()->isGlobalAdministrator()) {
                        if ($this->account()->isExpired()) {
                            $this->logout('Your account is expired! <a href="mailto:support@'.SITE_EMAIL_DOMAIN.'">Contact Us Now!</a> for payment or clarification!',
                                false);
                            //redirect administrators to the renew page
                            if ($this->account()->isAdministrator()) {
                                $this->session->set_flashdata('error',
                                    'Your subscription has expired. Please renew your subscription in the next page!');
                                redirect('home/signup');
                            } else {
                                $this->logout('Your subscription has expired. Please contact your account administrator to renew!');
                                redirect('home/signup');
                            }
                        } else {
                            $this->logout('You are unable to access your account.  Please contact your company administrator.');
                            redirect('home/signup');
                        }
                    }
                }
            }
        }

        // Load some extra stuff we'll need
//        $this->load->library('qbmodel');
//        $this->load->library('clientmodel');
//        $this->load->file(QBModel::LIB_FILE);
    }

    function logout($message = '', $redirect = true)
    {
        if ($this->session->userdata('logged')) {
            $this->log_manager->add(\models\ActivityAction::LOGOUT, 'User logged out.');
            $this->session->set_userdata('logged', null);
            $this->session->set_userdata('userId', null);
            $this->session->unset_userdata('logged');
            $this->session->unset_userdata('userId');
            $this->session->unset_userdata('accountId');
            $this->session->unset_userdata('sublogin');
            $this->session->unset_userdata('psaAlertShown');
            if (!$message) {
                $message = 'Succesfully logged out!';
            } else {
                $this->session->set_flashdata('error', $message);
            }
            $cookie = array(
                'name' => 'auth_token',
            );
            $this->input->set_cookie($cookie);
            $this->session->sess_destroy();
        }
        if ($redirect) {
            redirect('home/signin');
        }
    
    }

    function index()
    {
         if($this->account()->getIsSuperUser() && $this->account()->getParentCompanyId()==0){
            redirect('dashboard/super_user');
         }else{
            redirect('dashboard'); //new world order caused this. nothing to see here anymore.
        }
        
    }

    function my_account()
    {
        $data = $this->edit_company_data();
        $data['accounts'] = $this->account()->getCompany()->getAccounts();
        $data['layout'] = 'account/my_account/company_info';
        $this->html->addScript('dataTables');
         //$this->load->view('account/my_account', $data);
        //For event type
          $data['event_types'] = $this->getEventRepository()->getTypes($this->account()->getCompany()->getCompanyId());
          $account = ($this->account()->isAdministrator()) ? null : $this->account()->getAccountId();
          $data['events'] = $this->getEventRepository()->getAll($data['company']->getCompanyId(), $account);
          $this->html->addScript('fullCalendar');
          $this->html->addScript('dataTables');
          $this->html->addScript('spectrum');

          $salesManagerDeactive = $this->account()->getCompany()->getSalesManager();
          $modifyPriceDeactive = $this->account()->getCompany()->getModifyPrice();

          if ($salesManagerDeactive==0) {
              $tabDeactivearr = 0; //inactive
          }else{
              $tabDeactivearr = 1; //active
          } 

          if ($modifyPriceDeactive==0) {
               $modifyPricePermission = 0; //inactive
            }else{
                $modifyPricePermission = 1; //active
            } 
          $data['checkActive']=$tabDeactivearr; 
          $data['checkActiveModify']=$modifyPricePermission; 

 
        //For event type close

        // if ($this->account()->isAdministrator()) {
        //      $this->load->view('account/account_main', $data);
        // }else{
        //    $this->load->view('account/my_account', $data);
        //    //$this->load->view('account/user_account', $data);

        // }
 
        $this->load->view('account/account_main', $data);


    }

    function company_info()
    {
        $data = $this->edit_company_data();
        $data['accounts'] = $this->account()->getCompany()->getAccounts();
        $data['layout'] = 'account/my_account/company_info';
        $this->html->addScript('dataTables');
        //$this->load->view('account/my_account', $data);
        //For event type
          $data['event_types'] = $this->getEventRepository()->getTypes($this->account()->getCompany()->getCompanyId());
          $account = ($this->account()->isAdministrator()) ? null : $this->account()->getAccountId();
          $data['events'] = $this->getEventRepository()->getAll($data['company']->getCompanyId(), $account);
          $this->html->addScript('fullCalendar');
          $this->html->addScript('dataTables');
          $this->html->addScript('spectrum');
        $this->load->view('account/my_account', $data);
    }

    private function edit_company_data()
    {
        $data = array();
        $data['company'] = $this->account()->getCompany();
        $data['account'] = $this->account();
        $data['accounts'] = $this->account()->getCompany()->getAccounts();
        $data['attatchments'] = $this->account()->getCompany()->getAttatchments();
        return $data;
    }

    function my_info()
    {
        $data = $this->edit_company_data();
        $data['accounts'] = $this->account()->getCompany()->getAccounts();
        $data['layout'] = 'account/my_account/my_info';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    function psa()
    {
        // Only show this page if the company has PSA
        if (!$this->account()->getCompany()->hasPSA()) {
            $this->session->set_flashdata('error',
                'Your company does not have access to this page! Please speak to your company administrator');
            redirect('account/my_account');
        }

        // Load the account
        $account = $this->account();

        // Save PSA data
        if ($this->input->post('savePsa') || $this->input->post('removePsa')) {

            if ($this->input->post('savePsa')) {
                $account->setPsaEmail($this->input->post('psaEmail'));
                $account->setPsaPassword($this->input->post('psaPass'));

                $this->load->library('psa_client', ['account' => $account]);
                $responseObj = $this->psa_client->checkCredentials();

                if ($responseObj->error) {
                    $this->session->set_flashdata('error',
                        '<p style="text-align: center;">Your username or password for ProSiteAudit is incorrect.</p><br /><p style="text-align: center;"><a href="https://my.prositeaudit.com/account/forgot" target="_blank">Click here</a> to change your password</p>');
                    redirect('account/psa');
                } else {
                    $this->em->persist($account);
                    $this->em->flush();
                    $this->log_manager->add(\models\ActivityAction::EDIT_ACCOUNT,
                        'Account #' . $account->getAccountId() . ' (' . $account->getFullName() . ') ProSiteAudit Credentials Updated');
                    $this->session->set_flashdata('success', 'ProSiteAudit Credentials updated successfully!');
                    redirect('dashboard');
                }
            } elseif ($this->input->post('removePsa')) {
                $account->setPsaEmail(null);
                $account->setPsaPassword(null);
                $this->em->persist($account);
                $this->em->flush();
                $this->log_manager->add(\models\ActivityAction::EDIT_ACCOUNT,
                    'Account #' . $account->getAccountId() . ' (' . $account->getFullName() . ') ProSiteAudit Credentials Removed');
                $this->session->set_flashdata('success', 'ProSiteAudit Credentials removed successfully!');
                redirect('dashboard');
            }
        }

        $data = $this->edit_company_data();
        $data['layout'] = 'account/my_account/psa';
        $this->load->view('account/my_account', $data);
    }

    public function qbonline()
    {

        if ($this->input->post('save_accounts')) {
            
            $qbSettings = $this->account()->getCompany()->getQuickbooksSettings();
            $qbSettings->setIncomeAccountId($this->input->post('income_account'));
            $qbSettings->setExpenseAccountId($this->input->post('income_account'));
            $this->em->persist($qbSettings);
            $this->em->flush();
            $this->session->set_flashdata('success', 'Accounts Saved!');
            redirect('account/qbonline');
        }
  
        $data = $this->edit_company_data();
     
        if ($this->account()->getCompany()->hasQb()) {
         
            $data['incomeAccounts'] = $this->getQuickbooksRepository()->getIncomeAccounts($this->account()->getCompany());
              $data['expenseAccounts'] = $this->getQuickbooksRepository()->getExpenseAccounts($this->account()->getCompany());
        }
   
        $data['layout'] = 'account/my_account/qbsetting';
        $this->load->view('account/my_account', $data);
    }

    function qbsettings()
    {
        $data = $this->edit_company_data();
        $company = $this->account()->getCompany();
        
 
        if ($company->hasQb()) {

            switch ($company->getQbType()) {

                case 'desktop':
                    redirect('account/qbdesktop');
                    break;

                default:
                    redirect('account/qbonline');
                    break;
            }

        }

        $data['layout'] = 'account/my_account/qbsetup';
        $this->load->view('account/my_account', $data);

    }

    function qbsetup()
    {
        $data = $this->edit_company_data();
        if ($this->account()->getCompany()->hasQb()) {

            switch ($this->account()->getCompany()->getQbType()) {
                case 'online':
                    $data['incomeAccounts'] = $this->getQuickbooksRepository()->getIncomeAccounts($this->account()->getCompany());
                    $data['expenseAccounts'] = $this->getQuickbooksRepository()->getExpenseAccounts($this->account()->getCompany());
                    break;
            }
        }
        $data['layout'] = 'account/my_account/qbsetup';
        $this->load->view('account/my_account', $data);
    }

    function qbdesktop()
    {
        $this->load->config('quickbooks');
        $data = $this->edit_company_data();
        $qbSettings = $this->account()->getCompany()->getQuickbooksSettings();

        if ($this->input->post('save_accounts')) {
            $qbSettings->setQbdIncomeAccountName($this->input->post('income_account'));
            $this->em->persist($qbSettings);
            $this->em->flush();
            $this->session->set_flashdata('success', 'Accounts Saved!');
            redirect('account/qbdesktop');
        }

        // Flag for QB
        $data['hasQb'] = $this->account()->getCompany()->hasQb();

        // All income Accounts
        $data['incomeAccounts'] = [];
        if ($this->account()->getCompany()->hasQb()) {
            $data['incomeAccounts'] = $this->getCompanyRepository()->getQbIncomeAccounts($this->account()->getCompanyId());
        }

        // Selected Income Account
        $data['selectedIncomeAccount'] = null;
        if ($qbSettings) {
            $data['selectedIncomeAccount'] = $qbSettings->getQbdIncomeAccountName();
        }

        // QB Password
        $data['qbd_pass'] = $this->config->item('quickbooks_pass');

        // Render view
        $data['layout'] = 'account/my_account/qbdesktop';
        $this->load->view('account/my_account', $data);
    }

    function edit_company_info()
    {
        $data = $this->edit_company_data();
        if ($this->input->post('updateCompany')) {
            $company = $data['company'];
            $company->setCompanyName($this->input->post('companyName'));
            $company->setCompanyAddress($this->input->post('companyAddress'));
            $company->setCompanyWebsite($this->input->post('companyWebsite'));
            $company->setCompanyPhone($this->input->post('companyPhone'));
            $company->setCompanyCity($this->input->post('companyCity'));
            $company->setCompanyState($this->input->post('companyState'));
            $company->setCompanyZip($this->input->post('companyZip'));
            $company->setAlternatePhone($this->input->post('alternatePhone'));
            $this->em->persist($company);
            $this->em->flush();
            $this->log_manager->add(\models\ActivityAction::UPDATE_COMPANY, 'Company Information Updated.');
            $this->session->set_flashdata('success', 'Company Information updated!');
            redirect('account/my_account');
        }
        $data['layout'] = 'account/my_account/edit_company_info';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    function company_users()
    {
        $this->load->model('branchesapi');
        $data = $this->edit_company_data();
        $data['accounts'] = $this->account()->getCompany()->getAccounts();
        $data['layout'] = 'account/my_account/users';
        $data['branches'] = $this->branchesapi->getBranches($this->account()->getCompany()->getCompanyId());
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    function branches()
    {
        $this->load->database();
        $branchUsers = array();
        $this->load->model('branchesapi');
        $branches = $this->branchesapi->getBranches($this->account()->getCompany()->getCompanyId());
        foreach ($branches as $branch) {
            $branchUsers[$branch->getBranchId()] = $this->branchesapi->getUserCount($this->account()->getCompany()->getCompanyId(),
                $branch->getBranchId());
        }
        $branchUsers[0] = $this->branchesapi->getUserCount($this->account()->getCompany()->getCompanyId(), null);
        $data['layout'] = 'account/my_account/branches';
        $data['account'] = $this->account();
        $data['branches'] = $branches;
        $data['branchUsers'] = $branchUsers;
        $this->load->view('account/my_account', $data);
    }

    function addBranch()
    {
        if ($this->input->post('branchName')) {
            $branch = new \models\Branches();
            $branch->setCompany($this->account()->getCompany()->getCompanyId());
            $branch->setBranchName($this->input->post('branchName'));
            $this->em->persist($branch);
            $this->em->flush();
            $this->log_manager->add(\models\ActivityAction::COMPANY_ADD_BRANCH, 'Added branch "' . $this->input->post('branchName') . '"');
            $this->session->set_flashdata('success', 'Branch Added!');
            redirect('account/branches');
        } else {
            $this->session->set_flashdata('error', 'No Branch Name Provided!');
            redirect('account/branches');
        }
    }

    function deleteBranch($branchId)
    {
        $branch = $this->em->find('models\Branches', $branchId);
        if ($branch) {
            if ($branch->getCompany() == $this->account()->getCompany()->getCompanyId()) {
                $this->em->remove($branch);
                $this->load->database();
                $this->db->query('UPDATE accounts SET branch=0 WHERE branch=' . $branchId);
                $this->log_manager->add(\models\ActivityAction::COMPANY_DELETE_BRANCH, 'Deleted Branch branch "' . $branch->getBranchName() . '"');
                $this->em->flush();
                $this->session->set_flashdata('error', 'Branch deleted!');
                redirect('account/branches');
            } else {
                $this->session->set_flashdata('error', 'You have no privileges to delete the branch!');
                redirect('account/branches');
            }
        } else {
            $this->session->set_flashdata('error', 'Branch not found!');
            redirect('account/branches');
        }
    }

    function saveBranchName()
    {
        $branch = $this->em->find('models\Branches', $this->input->post('id'));
        if (!$branch) {
            echo $this->input->post('value');
        } else {
            if (!$this->input->post('value')) {
                echo $branch->getBranchName();
            } else {
                $this->log_manager->add(\models\ActivityAction::COMPANY_EDIT_BRANCH,
                    'Renamed branch "' . $branch->getBranchName() . '" to "' . $this->input->post('value') . '"');
                $branch->setBranchName($this->input->post('value'));
                $this->em->persist($branch);
                $this->em->flush();
                echo $this->input->post('value');
            }
        }
    }

    function edit_user()
    {
        
        $data = $this->edit_company_data();
        $addresses = $this->em->createQuery('SELECT wa FROM models\Work_order_addresses wa WHERE wa.company=' . $this->account()->getCompany()->getCompanyId())->getResult();
        $data['addresses'] = $addresses;
        $data['accounts'] = $this->account()->getCompany()->getAccounts();
        $this->load->model('branchesapi');
        $data['branches'] = $this->branchesapi->getBranches($this->account()->getCompany()->getCompanyId());
        $data['layouts'] = $this->account()->getCompany()->getLayouts();
        $data['web_layouts'] = $this->account()->getCompany()->getWebLayouts();
        $logged_account = $this->em->find('models\Accounts', $this->session->userdata('accountId'));
        if (!$this->account()->isAdministrator()) {
            $this->session->set_flashdata('error', 'Only Company Administrators can do this!!');
            redirect('account/my_account');
        }
        $account = $this->em->findAccount($this->uri->segment(3));
        if (!$account) {
            $this->session->set_flashdata('error', 'Account Not found!');
            redirect('account/company_users');
        }
        if ($this->account()->getCompany() != $account->getCompany()) {
            $this->session->set_flashdata('error', 'You are not allowed to edit other companies user!');
            redirect('account/company_users');
        }

        if ($this->uri->segment(4) == 'removeSignature') {
            $sig = UPLOADPATH . '/clients/signatures/' . 'signature-' . $account->getAccountId() . '.jpg';
            @unlink($sig);
            $this->session->set_flashdata('success', 'Signature successfully removed!');
            redirect('account/edit_user/' . $account->getAccountId());
        }
        //signature upload
        $acceptedImages = array('image/jpeg', 'image/pjpeg', 'image/jpg', 'image/png', 'image/x-png');
        if ($this->input->post('changeSignature')) {
            if ($_FILES['clientLogo']['error'] === 0) {
                if (!in_array($_FILES['clientLogo']['type'], $acceptedImages)) {
                    $this->session->set_flashdata('error', 'Only JPEG and PNG format is accepted!');
                    redirect('account/edit_user/' . $account->getAccountId());
                } else {
                    //check if file size is larger than 500KB
                    if ($_FILES['clientLogo']['size'] > 512000) {
                        $this->session->set_flashdata('error',
                            'File size exceeds 500KB! You are not allowed to upload files larger than that.');
                        redirect('account/edit_user/' . $account->getAccountId());
                    } else {
                        $path = UPLOADPATH . '/clients/signatures/';
                        $filename = 'signature-' . $account->getAccountId() . '.';
                        switch ($_FILES['clientLogo']['type']) {
                            case 'image/jpeg':
                                $filename .= 'jpg';
                                break;
                            case 'image/jpg':
                                $filename .= 'jpg';
                                break;
                            case 'image/pjepg':
                                $filename .= 'jpg';
                                break;
                            case 'image/png':
                                $filename .= 'jpg';
                                break;
                        }
                        $imagepath = $path . $filename;
                        if (file_exists($imagepath)) {
                            unlink($imagepath);
                        }
                        if (in_array($_FILES['clientLogo']['type'], array('image/png', 'image/x-png'))) {
                            $sizes = getimagesize($_FILES['clientLogo']['tmp_name']);
                            $w = $sizes[0];
                            $h = $sizes[1];
                            $white_bg = imagecreatetruecolor($w, $h);
                            $white = imagecolorallocate($white_bg, 255, 255, 255);
                            imagefill($white_bg, 0, 0, $white);
                            $im = imagecreatefrompng($_FILES['clientLogo']['tmp_name']);
                            imagealphablending($im, true);
                            imagealphablending($white_bg, true);
                            $out = imagecreatetruecolor($w, $h);
                            imagecopyresampled($out, $white_bg, 0, 0, 0, 0, $w, $h, $w, $h);
                            imagecopyresampled($out, $im, 0, 0, 0, 0, $w, $h, $w, $h);
                            imagejpeg($out, $imagepath);
                        } else {
                            move_uploaded_file($_FILES['clientLogo']['tmp_name'], $imagepath);
                        }
                        $this->session->set_flashdata('success', 'Signature updated succesfully!.');
                        $this->log_manager->add(\models\ActivityAction::ADD_ACCOUNT,
                            'Uploaded Signature for User#' . $account->getAccountId());
                        redirect('account/edit_user/' . $account->getAccountId());
                    }
                }
            } else {
                $this->session->set_flashdata('error',
                    'Errors have occured during the upload. Please check your file format or size of file and try again a bit later.');
                redirect('account/edit_user/' . $account->getAccountId());
            }
        }

        // Save PSA data
        if ($this->input->post('savePsa')) {
            $account->setPsaEmail($this->input->post('psaEmail'));
            $account->setPsaPassword($this->input->post('psaPass'));

            $this->load->library('psa_client', ['account' => $account]);
            $responseObj = $this->psa_client->checkCredentials();

            if ($responseObj->error) {
                $this->session->set_flashdata('error',
                    '<p style="text-align: center;">Your username or password for ProSiteAudit is incorrect.</p><br /><p style="text-align: center;"><a href="https://my.prositeaudit.com/account/forgot" target="_blank">Click here</a> to change your password</p>');
                redirect('account/edit_user/' . $account->getAccountId());
            } else {
                $this->em->persist($account);
                $this->em->flush();
                $this->log_manager->add(\models\ActivityAction::EDIT_ACCOUNT,
                    'Account #' . $account->getAccountId() . ' (' . $account->getFullName() . ') ProSiteAudit Credentials Update!');
                $this->session->set_flashdata('success', 'ProSiteAudit Credentials updated successfully!');
            }

            redirect('account/company_users');
        }

        //saving user data
        if ($this->input->post('save')) {

            //check if name/email has been changed
            if (($account->getFirstName() != $this->input->post('firstName')) || ($account->getLastName() != $this->input->post('lastName')) || ($account->getEmail() != $this->input->post('email'))) {
                $message = '<b>Old user information:</b><br><br>
                <b style="width: 100px; text-align: right; display: block; float: left; margin-right: 5px;">First Name:</b> ' . $account->getFirstName() . '<br>
                <b style="width: 100px; text-align: right; display: block; float: left; margin-right: 5px;">Last Name:</b> ' . $account->getLastName() . '<br>
                <b style="width: 100px; text-align: right; display: block; float: left; margin-right: 5px;">Email:</b> ' . $account->getEmail() . '<br><br>
                <b>New user information:</b><br><br>
                <b style="width: 100px; text-align: right; display: block; float: left; margin-right: 5px;">First Name:</b> ' . $this->input->post('firstName') . '<br>
                <b style="width: 100px; text-align: right; display: block; float: left; margin-right: 5px;">Last Name:</b> ' . $this->input->post('lastName') . '<br>
                <b style="width: 100px; text-align: right; display: block; float: left; margin-right: 5px;">Email:</b> ' . $this->input->post('email') . '<br>';
                $this->load->model('system_email');
                $emailData = array(
                    'first_name' => $this->account()->getCompany()->getAdministrator()->getFirstName(),
                    'last_name' => $this->account()->getCompany()->getAdministrator()->getLastName(),
                    'new_information' => $message,
                );
                $this->system_email->categories = array('User', 'Edit User');
                $this->system_email->uniqueArgs = array('user' => $account->getAccountId());
                $this->system_email->sendEmail(2, $this->account()->getCompany()->getAdministrator()->getEmail(),
                    $emailData);

            }
            //check if the email is changed...
            if ($this->input->post('email') != $account->getEmail()) {
                $testAcc = $this->em->getRepository('models\Accounts')->findOneBy(array('email' => $this->input->post('email')));
                if ($testAcc) {
                    $this->session->set_flashdata('error', 'Email already in use!');
                    redirect('account/edit_user/' . $this->uri->segment(3));
                } else {
                    $account->setEmail($this->input->post('email'));
                    $this->load->model('system_email');
                    $emailData = array(
                        'new_email' => $this->input->post('email'),
                        'first_name' => $account->getFirstName(),
                        'last_name' => $account->getLastName(),
                    );
                    $this->system_email->categories = array('User', 'Email Change');
                    $this->system_email->uniqueArgs = array('user' => $account->getAccountId());
                    $this->system_email->sendEmail(1, $this->input->post('email'), $emailData);
                }
            }
            //check if the user is trying to imput limited access to admin user
            if (($this->input->post('fullAccess') == 'no') && ($account->isAdministrator(true))) {
                //                $this->session->set_flashdata('notice', 'The Administrator user account can not have limited access!');
            } else {
                $account->setFullAccess($this->input->post('fullAccess'));
            }
            //check if a new password is set up
            if ($this->input->post('password')) {
                $account->setPassword($this->input->post('password'));
                $emailData = array(
                    'first_name' => $account->getFirstName(),
                    'last_name' => $account->getFirstName(),
                    'password' => $this->input->post('password'),
                    'email' => $account->getEmail(),
                );
                $this->load->model('system_email');
                $this->system_email->categories = array('User', 'Password Change');
                $this->system_email->uniqueArgs = array('user' => $account->getAccountId());
                $this->system_email->sendEmail(3, $account->getEmail(), $emailData);
                $this->log_manager->add(\models\ActivityAction::CHANGE_PASSWORD, 'User succesfully changed password.');
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
            $account->setOfficePhone($this->input->post('officePhone'));
            $account->setOfficePhoneExt($this->input->post('officePhoneExt'));
            $account->setFax($this->input->post('fax'));
            $account->setBranch($this->input->post('branch'));
            $account->setWorkOrderAddress($this->input->post('work_order_address'));
            $account->setProposalEmailCC(($this->input->post('proposal_email_cc'))? 1 : 0 );
            $account->setAuthLogin(($this->input->post('2way_auth'))? 1 : 0);
            
            if ($this->input->post('sales_report_emails')) {
                $account->setSalesReportEmails($this->input->post('sales_report_emails'));
            }else{
                $account->setSalesReportEmails(0);
            }
            if ($this->input->post('email_frequency')) {
                $account->setEmailFrequency($this->input->post('email_frequency'));
            }else{
                $account->setEmailFrequency(0);
            }

            $secretaryInput = $this->input->post('secretary');

            // Only update the secretary value if there is one
            if ($secretaryInput !== false) {
                $secretary = ($secretaryInput) ? 1 : 0;
                $account->setSecretary($secretary);
            }

            $account->setRequiresApproval($this->input->post('requiresApproval'));
            $account->setLayout($this->input->post('layout'));
            // Clean out any commas and save the approval amount value
            $approvalAmount = removePriceFormatting($this->input->post('approvalAmount'));
            $account->setApprovalAmount($approvalAmount);
            if ($this->input->post('useDefaultApproval')) {
                $useDefaultApproval = 1;
            } else {
                $useDefaultApproval = 0;
            }
            $account->setDefaultApproval($useDefaultApproval);
            $account->setSales($this->input->post('sales'));

            // Only update Wio if there is a value
            $wio = $this->input->post('wio');
            if ($wio === '0' || $wio === '1') {
                $account->setWio($wio);
            }

            // Save the old user class to check if changed
            $oldUserClass = $account->getUserClass();
            // Set the new class
            $account->setUserClass($this->input->post('user_class'));

            // Do the user class check if a user class was posted
            if ($oldUserClass <> $account->getUserClass()) {
                $account->setUserClass($this->input->post('user_class'));
                $permissions = array(
                    '0' => 'User',
                    '1' => 'Branch Manager',
                    '2' => 'Full Access',
                    '3' => 'Adminstrator',
                    '4' => 'Adminstrator',
                );
                $class = ($permissions[$this->input->post('user_class')]) ? $permissions[$this->input->post('user_class')] : 'User';
                $message = 'Your new user class is <b>' . $class . '</b>.';
                $this->load->model('system_email');
                $this->system_email->categories = array('User', 'Privilege Change');
                $this->system_email->uniqueArgs = array('user' => $account->getAccountId());
                $this->system_email->sendEmail(4, $account->getEmail(), array('privilege_message' => $message));
            }

            // Check to see if they are the assigned user for leads
            // Only do it if the user class is below admin
            if ($account->getUserClass() < 3) {
                $notificationRepo = $this->getLeadNotificationsRepository();
                $notificationSettings = $notificationRepo->getLeadNotificationSettings($this->account()->getCompany()->getCompanyId());
                $notificationAccount = $notificationSettings->account;

                // Check to see if this use is the assigned recipient
                if ($account->getAccountId() == $notificationAccount) {
                    // Switch it over to the company admin if so
                    $notificationData = [
                        'enabled' => $notificationSettings->enabled,
                        'instant' => $notificationSettings->instant,
                        'account' => $this->account()->getCompany()->getAdministrator()->getAccountId(),
                        'company' => $notificationSettings->company,
                        'notificationIntervals' => $notificationSettings->notificationIntervals,
                    ];
                    $this->db->delete('lead_notification_settings',
                        array('company' => $this->account()->getCompany()->getCompanyId()));
                    $this->db->insert('lead_notification_settings', $notificationData);
                    $logMessage = 'Updated Lead Notification Settings Automatically Updated: Recipient changed to ' . $this->account()->getCompany()->getAdministrator()->getEmail();
                    $this->getLogRepository()->add([
                        'action' => 'updated_lead_notification_settings',
                        'details' => $logMessage,
                        'account' => $this->account()->getAccountId()
                    ]);
                }
            }

            $account->setDisableProposalNotifications($this->input->post('disable_proposal_notifications'));
            if ($this->input->post('disabled') && $account->getDisabled() != $this->input->post('disabled')) {
                $this->log_manager->add(\models\ActivityAction::UPDATE_COMPANY,
                    'Account #' . $account->getAccountId() . ' (' . $account->getFullName() . ') Disabled.');
            }
            $account->setDisabled($this->input->post('disabled'));
            if ($logged_account->isGlobalAdministrator()) {
                $expDate = explode('/', $this->input->post('expires'));
                $expires = mktime(23, 59, 59, $expDate[0], $expDate[1], $expDate[2]);
                $account->setExpires($expires);
                 // Add code for child expires updation Start
                $this->db->select('a.accountId');
                $this->db->from('accounts a');
                $this->db->where_in('a.parent_user_id', $account->getAccountId());
                $query = $this->db->get();
                $result = $query->result_array();
                if(!empty($result)){
                    $accountIds = array_column($result, 'accountId');
                     // Add code for child expires updation Start
                        $this->db->set('expires', $expires);
                        $this->db->where_in('accountId', $accountIds);
                        $this->db->update('accounts');
                        // Add code for child expires updation End
                }
                // Add code for child expires updation  End
            }
            $account->setEstimating($this->input->post('estimating'));
            $account->setEditPrice($this->input->post('edit_prices'));
            $this->em->persist($account);

            $this->em->flush();

            //Delete user query Cache
            $this->getQueryCacheRepository()->deleteCompanyUserAllCache($this->account()->getCompanyId());

            // Flag proposals to be rebuilt
            $this->getCompanyRepository()->flagAccountProposalsForRebuild($account->getAccountId());

            // Update the company subscription
            if (($this->account()->getCompany()->isActive()) && $this->account()->getCompany()->shouldUpdateZS()) {
                $cr = $this->getCompanyRepository();
                $cr->updateSubscriptions($this->account()->getCompany());
            }

            $this->log_manager->add(\models\ActivityAction::COMPANY_EDIT_USER,
                'Account #' . $account->getAccountId() . ' (' . $account->getFullName() . ') information updated succesfully!');
            $this->session->set_flashdata('success', 'User updated succesfully!');
            redirect('account/company_users');
        }
        $data['user'] = $account;

        $data['logged_account'] = $logged_account;
        $data['account'] = $this->account();
        $data['layout'] = 'account/my_account/edit_user';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    function add_user()
    {
        
        if (!$this->account()->isAdministrator()) {
            $this->session->set_flashdata('error', 'Only Company Administrators can do this!');
            redirect('account/company_users');
        }
        $logged_account = $this->em->find('models\Accounts', $this->session->userdata('accountId'));
        if ($this->input->post('save')) {
            $account = new models\Accounts();
            $account->setCompany($this->account()->getCompany());
            $account->setState($this->input->post('state'));
            $account->setTitle($this->input->post('title'));
            $account->setEmail($this->input->post('email'));
            $account->setRecoveryCode();
            $account->setFullAccess($this->input->post('fullAccess'));
            $account->setFirstName($this->input->post('firstName'));
            $account->setLastName($this->input->post('lastName'));
            $account->setCellPhone($this->input->post('cellPhone'));
            $account->setOfficePhone($this->input->post('officePhone'));
            $account->setOfficePhoneExt($this->input->post('officePhoneExt'));
            $account->setFax($this->input->post('fax'));
            $account->setAddress($this->input->post('address'));
            $account->setCity($this->input->post('city'));
            $account->setZip($this->input->post('zip'));
            $account->setCountry($this->input->post('country'));
            $account->setTimeZone($this->input->post('timeZone'));
            $account->setCreated(time());
            $account->setBranch($this->input->post('branch'));
            $account->setWorkOrderAddress($this->input->post('work_order_address'));
            $account->setUserClass($this->input->post('user_class'));

            //required approval amount
            $account->setRequiresApproval($this->input->post('requiresApproval'));
            $approvalAmount = removePriceFormatting($this->input->post('approvalAmount'));

            if ($this->input->post('useDefaultApproval')) {
                $useDefaultApproval = 1;
                $account->setDefaultApproval($useDefaultApproval);
                $account->setApprovalAmount("0");
            } else {
                $useDefaultApproval = 0;
                $account->setDefaultApproval($useDefaultApproval);
                $account->setApprovalAmount($approvalAmount);
            }


            $account->setDisableProposalNotifications($this->input->post('disable_proposal_notifications'));
            $account->setSales($this->input->post('sales'));
            $account->setWio($this->input->post('wio'));
            $account->setEstimating($this->input->post('estimating'));
            $account->setEditPrice($this->input->post('edit_prices'));
            if ($this->input->post('sales_report_emails')) {
                $account->setSalesReportEmails($this->input->post('sales_report_emails'));
            } else {
                $account->setSalesReportEmails(0);
            }
            if ($this->input->post('email_frequency')) {
                $account->setEmailFrequency($this->input->post('email_frequency'));
            } else {
                $account->setEmailFrequency(0);
            }


            $this->em->persist($account);
            if ($logged_account->isGlobalAdministrator()) {
                $expDate = explode('/', $this->input->post('expires'));
                $expires = mktime(23, 59, 59, $expDate[0], $expDate[1], $expDate[2]);
                $account->setExpires($expires);
            }
            // if a trial company admin is adding a new user, match the dates of the new users to that
            if ($this->account()->getCompany()->isTrial()) {
                $account->setExpires($this->account()->getCompany()->getAdministrator()->getExpires());
            }
            $this->em->flush();

            //Delete user query Cache
            $this->getQueryCacheRepository()->deleteCompanyUserAllCache($this->account()->getCompanyId());
            
            $this->log_manager->add(
                \models\ActivityAction::COMPANY_ADD_USER,
                'Added account #' . $account->getAccountId() . ' (' . $account->getFullName() . ')'
            );
            $account->sendNewUserEmail();

            // Update the company subscription
            if (($this->account()->getCompany()->isActive()) && $this->account()->getCompanyId() != 8) {
                $cr = $this->getCompanyRepository();
                $cr->updateSubscriptions($this->account()->getCompany());
            }

            $account->sendAccountAddEmailToSupport();
            $this->session->set_flashdata('success', '<b>Account added!</b> <br/><br/>You will be invoiced for this new user and they will be activated');
            redirect('account/company_users');
        }
        $data = $this->edit_company_data();
        $addresses = $this->em->createQuery('SELECT wa FROM models\Work_order_addresses wa WHERE wa.company=' . $this->account()->getCompany()->getCompanyId())->getResult();
        $data['addresses'] = $addresses;
        $this->load->model('branchesapi');
        $data['branches'] = $this->branchesapi->getBranches($this->account()->getCompany()->getCompanyId());
        $data['accounts'] = $this->account()->getCompany()->getAccounts();
        $data['account'] = $this->account();
        $data['logged_account'] = $logged_account;
        $data['layout'] = 'account/my_account/add_user';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }


    /*Work order recipients section*/
    function work_order_recipients()
    {
        $data = $this->edit_company_data();
        $data['layout'] = 'account/my_account/work_order_recipients';
        $recipients = $this->em->createQuery('SELECT r FROM models\Work_order_recipients r WHERE r.company=' . $this->account()->getCompany()->getCompanyId() . ' ORDER BY r.name')->getResult();
        $data['recipients'] = $recipients;
        $this->load->view('account/my_account', $data);
    }

     /*foremen section*/
     function foremen_list()
     {
         $data = $this->edit_company_data();
         $data['layout'] = 'account/my_account/foremen_list';
         $data['foremens'] = $this->em->createQuery('SELECT r FROM models\Foremen r WHERE r.company=' . $this->account()->getCompany()->getCompanyId() . ' AND r.is_deleted = 0 ORDER BY r.ord')->getResult();
         $this->load->view('account/my_account', $data);
     }

    function addWorkRecipient()
    {
        if ($this->input->post('name') && $this->input->post('email')) {
            $wr = new \models\Work_order_recipients();
            $wr->setName($this->input->post('name'));
            $wr->setEmail($this->input->post('email'));
            $wr->setCompany($this->account()->getCompany()->getCompanyId());
            $this->em->persist($wr);
            $this->em->flush();
            $this->getQueryCacheRepository()->deleteCompanyWorkOrderRecipCache($this->account()->getCompanyId());
            // $this->em->getConfiguration()->getResultCacheImpl()->delete( CACHE_COMPANY_WORK_ORDER_RECIP . $this->account()->getCompanyId());
            $email  = $this->input->post('email');
            $this->log_manager->add(\models\ActivityAction::UPDATE_COMPANY, "Added workorder recipient $email");
            $this->session->set_flashdata('success', 'Recipient Added!');
            echo '1';
        } else {
            echo '0';
            $this->session->set_flashdata('error',
                'Data not saved! Please make sure you fill in both fields correctly!');
        }
    }

    function saveWorkRecipientInfo()
    {
        $value = $this->input->post('value');
        $data = explode('_', $this->input->post('id'));
        $woa = $this->em->find('models\Work_order_recipients', $data[1]);
        if ($woa) {
            if ($value) {
                switch ($data[0]) {
                    case 'recipientName':
                        $woa->setName($value);
                        break;
                    case 'recipientEmail':
                        $woa->setEmail($value);
                        break;
                }
            }
            $this->em->persist($woa);
            $this->em->flush();
        }
        switch ($data[0]) {
            case 'recipientName':
                echo $woa->getName();
                break;
            case 'recipientEmail':
                echo $woa->getEmail();
                break;
        }
    }

    function addForemen()
    {
        if ($this->input->post('name') && $this->input->post('email')) {
            $wr = new \models\Foremen();
            $wr->setName($this->input->post('name'));
            $wr->setContact($this->input->post('contact'));
            $wr->setEmail($this->input->post('email'));
            $wr->setCompany($this->account()->getCompany()->getCompanyId());
            $this->em->persist($wr);
            $this->em->flush();
            //Temp Delete Cache result
            $this->getQueryCacheRepository()->deleteCompanyForemenCache($this->account()->getCompanyId());
            // $this->em->getConfiguration()->getResultCacheImpl()->delete( CACHE_COMPANY_FOREMEN . $this->account()->getCompanyId());

            $this->session->set_flashdata('success', 'Foremen Added!');
            echo '1';
        } else {
            echo '0';
            $this->session->set_flashdata('error',
                'Data not saved! Please make sure you fill in both fields correctly!');
        }
    }

    function saveForemenInfo()
    {
        $value = $this->input->post('value');
        $data = explode('_', $this->input->post('id'));
        $woa = $this->em->find('models\Foremen', $data[1]);
        if ($woa) {
            if ($value) {
                switch ($data[0]) {
                    case 'foremenName':
                        $woa->setName($value);
                        break;
                    case 'foremenContact':
                        $woa->setContact($value);
                        break;
                    case 'foremenEmail':
                        $woa->setEmail($value);
                        break;
                }
            }
            $this->em->persist($woa);
            $this->em->flush();
            
        }
        switch ($data[0]) {
            case 'foremenName':
                echo $woa->getName();
                break;
            case 'foremenContact':
                $woa->setContact($value);
                break;
            case 'foremenEmail':
                echo $woa->getEmail();
                break;
        }
        //Temp Delete Cache result
        $this->getQueryCacheRepository()->deleteCompanyForemenCache($this->account()->getCompanyId());
        // $this->em->getConfiguration()->getResultCacheImpl()->delete( CACHE_COMPANY_FOREMEN . $this->account()->getCompanyId());

    }

    function deleteForemen($id)
    {
        $woa = $this->em->find('models\Foremen', $id);
        if ($woa) {
            $woa->setIsDeleted(1);
            $this->em->flush();
        }
        //Temp Delete Cache result
        
        $this->getQueryCacheRepository()->deleteCompanyForemenCache($this->account()->getCompanyId());
        //$this->em->getConfiguration()->getResultCacheImpl()->delete( CACHE_COMPANY_FOREMEN . $this->account()->getCompanyId());

        $this->session->set_flashdata('success', 'Foremen Deleted!');
        redirect('account/foremen_list');
    }

    
    function deleteWorkOrderRecipient($id)
    {
        $woa = $this->em->find('models\Work_order_recipients', $id);
        if ($woa) {
            $this->em->remove($woa);
            $this->em->flush();
           //Delete cache
           $email =  $woa->getEmail();
           $this->log_manager->add(\models\ActivityAction::UPDATE_COMPANY, "Deleted workorder recipient $email");
           $this->getQueryCacheRepository()->deleteCompanyWorkOrderRecipCache($this->account()->getCompanyId());
            // $this->em->getConfiguration()->getResultCacheImpl()->delete( CACHE_COMPANY_WORK_ORDER_RECIP . $this->account()->getCompanyId());
        }
        $this->session->set_flashdata('success', 'Recipient Deleted!');
        redirect('account/work_order_recipients');
    }

    /*Company work order addresses etc*/
    function company_workorder()
    {
        $data = $this->edit_company_data();
        $data['layout'] = 'account/my_account/work_order';
        $addresses = $this->em->createQuery('SELECT wa FROM models\Work_order_addresses wa WHERE wa.company=' . $this->account()->getCompany()->getCompanyId())->getResult();
        $data['addresses'] = $addresses;
        $this->load->view('account/my_account', $data);
    }

    function add_work_order_address()
    {
        if ($this->input->post('save')) {
            $woa = new models\Work_order_addresses();
            $woa->setCompany($this->account()->getCompany()->getCompanyId());
            $woa->setAddress($this->input->post('address'));
            $woa->setCity($this->input->post('city'));
            $woa->setState($this->input->post('state'));
            $woa->setZip($this->input->post('zip'));
            $this->em->persist($woa);
            $this->em->flush();
            $this->session->set_flashdata('success', 'Successfully added work order address!');
            $address = ($this->input->post('address') ? $this->input->post('address') : '') . 
           ($this->input->post('city') ? ', ' . $this->input->post('city') : '') . 
           ($this->input->post('state') ? ', ' . $this->input->post('state') : '') . 
           ($this->input->post('zip') ? ' ' . $this->input->post('zip') : '');
            $this->log_manager->add(\models\ActivityAction::COMPANY_ADD_WORK_ORDER_ADDRESS, "Added workorder address: $address");
            redirect('account/company_workorder');
        }
        $data = $this->edit_company_data();
        $data['title'] = 'Add new work order address';
        $data['layout'] = 'account/my_account/edit_work_order';
        $this->load->view('account/my_account', $data);
    }

    function edit_work_order_address($id)
    {
        $data = $this->edit_company_data();
        $woa = $this->em->find('models\Work_order_addresses', $id);
        if (!$woa || ($woa->getCompany() != $this->account()->getCompany()->getCompanyId())) {
            $this->session->set_flashdata('error',
                'Address does not exist or you do not have enough privileges to access it!');
            redirect('account/company_workorder');
        }
        if ($this->input->post('save')) {
            $woa->setAddress($this->input->post('address'));
            $woa->setCity($this->input->post('city'));
            $woa->setState($this->input->post('state'));
            $woa->setZip($this->input->post('zip'));
            $this->em->persist($woa);
            $this->em->flush();
            $this->session->set_flashdata('success', 'Successfully saved work order address!');
            $address = ($this->input->post('address') ? $this->input->post('address') : '') . 
            ($this->input->post('city') ? ', ' . $this->input->post('city') : '') . 
            ($this->input->post('state') ? ', ' . $this->input->post('state') : '') . 
            ($this->input->post('zip') ? ' ' . $this->input->post('zip') : '');
            $this->log_manager->add(\models\ActivityAction::COMPANY_EDIT_WORK_ORDER_ADDRESS, "Edited workorder address $address");
            redirect('account/company_workorder');
        }
        $data['woa'] = $woa;
        $data['title'] = 'Edit work order address';
        $data['layout'] = 'account/my_account/edit_work_order';
        $this->load->view('account/my_account', $data);
    }

    function delete_work_order_address($id)
    {
        $woa = $this->em->find('models\Work_order_addresses', $id);

        $address = ($woa->getAddress() ? $woa->getAddress() : '') . 
        ($woa->getCity() ? ', ' . $woa->getCity() : '') . 
        ($woa->getState() ? ', ' . $woa->getState() : '') . 
        ($woa->getZip() ? ', ' . $woa->getZip() : '');
 
        if (!$woa || ($woa->getCompany() != $this->account()->getCompany()->getCompanyId())) {
            $this->session->set_flashdata('error',
                'Address does not exist or you do not have enough privileges to access it!');
            redirect('account/company_workorder');
        }
        $this->em->remove($woa);
        $this->em->flush();
        $this->session->set_flashdata('success', 'Successfully deleted work order address!');
        $this->log_manager->add(\models\ActivityAction::COMPANY_DELETE_WORK_ORDER_ADDRESS, "Deleted workorder $address");
        redirect('account/company_workorder');
    }

    function company_edit_workorder()
    {
        $data = $this->edit_company_data();
        if ($this->input->post('save')) {
            $company = $data['company'];
            if ($this->input->post('woEnabled')) {
                $woEnabled = 1;
            } else {
                $woEnabled = 0;
            }
            $company->setWoEnabled($woEnabled);
            $company->setWoAddress($this->input->post('woAddress'));
            $company->setWoCity($this->input->post('woCity'));
            $company->setWoState($this->input->post('woState'));
            $company->setWoZip($this->input->post('woZip'));
            $this->em->persist($company);
            $this->em->flush();
            $this->log_manager->add(\models\ActivityAction::UPDATE_COMPANY, 'Work Order Address Updated.');
            $this->session->set_flashdata('success', 'Company Work Order Settings updated!');
            redirect('account/company_workorder');
        }
        $data['layout'] = 'account/my_account/edit_work_order';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    function bid_approval()
    {
        $data = [];
        $data['account'] = $this->account();
        $company = $this->account()->getCompany();

        // Check for posted value
        if ($this->input->post('submitDefaultBidApproval')) {

            if (!$this->account()->isAdministrator()) {
                $this->session->set_flashdata('error', 'You do not have permission to perform this action');
                redirect('account/bid_approval');
            }

            // Remove any comma separators
            $amt = removePriceFormatting($this->input->post('defaultBidApproval'));
            // Set and save
            $company->setDefaultBidApproval($amt);
            $this->em->persist($company);
            $this->em->flush();

            // Log it
            $this->log_manager->add(\models\ActivityAction::COMPANY_UPDATE_BID_APPROVAL,
                'Default company bid approval amount set to ' . $this->input->post('defaultBidApproval'));
            $this->session->set_flashdata('success', 'Default Bid Approval Amount Set');
            redirect('account/bid_approval');
        }

        $data['layout'] = 'account/my_account/bid_approval';
        $data['defaultBidApproval'] = $company->getDefaultBidApproval();
        $this->load->view('account/my_account', $data);
    }

    function company_proposal_settings()
    {
        $data = $this->edit_company_data();
        if ($this->input->post('save')) {
            $company = $data['company'];
            $company->setPdfHeader($this->input->post('pdfHeader'));
            $company->setCoolHeaderFont($this->input->post('header_font'));
            $company->setCoolTextFont($this->input->post('text_font'));
            $this->em->persist($company);
            $this->em->flush();
            $this->log_manager->add(\models\ActivityAction::UPDATE_COMPANY, 'Cool Layout Settings Updated in My Account.');
            $this->session->set_flashdata('success', 'Cool Layout Settings updated!');
            redirect('account/company_proposal_settings');
        }
        $salesManagerDeactive = $this->account()->getCompany()->getSalesManager();
        if ($salesManagerDeactive==0) {
                  $tabDeactivearr = 0; //inactive
              }else{
                  $tabDeactivearr = 1; //active
              }
       $data['checkActive']=$tabDeactivearr; 
        $data['layout'] = 'account/my_account/proposal_settings_1';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    function company_proposal_notifications()
    {
        $page_check =  $this->uri->segment(2);
        $salesManagerDeactive = $this->account()->getCompany()->getSalesManager();
        if ($salesManagerDeactive==0  && $page_check=="company_proposal_notifications") {
              redirect('account/my_account');
        }

        $data = $this->edit_company_data();
        if ($this->input->post('save')) {
            $notificationData = [
                'company' => $this->account()->getCompany()->getCompanyId(),
                'enabled' => $this->input->post('enabled'),
                'frequency' => ((round($this->input->post('frequency')) * 86400) >= 86400) ? (round($this->input->post('frequency') * 86400)) : 86400,
                'template' => $this->input->post('template'),
                'resend_time' => $this->input->post('resend_time'),
                'statuses' => (is_array($this->input->post('statuses'))) ? implode(',',
                    $this->input->post('statuses')) : '',
            ];
            //save
            $this->getProposalNotificationsRepository()->saveProposalResendSettings($notificationData);
            //log
            $logMessage = 'UpdatedProposal Re-send Settings: Enabled: ' . (($notificationData['enabled'] ? 'Yes' : 'No'));
            /*  ', Daily Notifications: ' . ((is_array($this->input->post('sta'))) ? implode(', ', $this->input->post('Statuses')) : 'None');
          $this->getLogRepository()->add(['action' => 'updated_lead_notification_settings', 'details' => $logMessage, 'account' => $this->account()->getAccountId()]);*/
            $this->getLogRepository()->add([
                'action' => 'updated_proposal_resend_settings',
                'details' => $logMessage,
                'account' => $this->account()->getAccountId()
            ]);
            $this->session->set_flashdata('success', 'Proposal re-send settings updated!');
            redirect('account/company_proposal_notifications');
        }
        $data['resend_settings'] = $this->getProposalNotificationsRepository()->getProposalResendSettings($this->account()->getCompany()->getCompanyId());
        $data['layout'] = 'account/my_account/proposal_notifications';
        $data['accounts'] = $this->account()->getCompany()->getAccounts();
        $data['statuses'] = $this->account()->getCompany()->getStatuses();
        $data['resend_times'] = $this->system_setting('proposal_resend_times');
        $data['selected_statuses'] = (isset($data['resend_settings']->statuses)) ? explode(',',
            $data['resend_settings']->statuses) : [];
        $this->load->model('clientEmail');
        $data['proposal_email_templates'] = $this->clientEmail->getAllTemplates($this->account()->getCompany()->getCompanyId(),
            1);

            $salesManagerDeactive = $this->account()->getCompany()->getSalesManager();
            if ($salesManagerDeactive==0 ) {
                $tabDeactivearr = 0; //inactive
            }else{
                $tabDeactivearr = 1; //active
            } 
            $data['checkActive']=$tabDeactivearr; 

        $this->load->view('account/my_account', $data);
    }

    function prospect_settings()
    {
        $data = $this->edit_company_data();

        if ($this->input->post('action')) {
            switch ($this->input->post('action')) {

                case 'add':
                    if ($this->input->post('newSource')) {

                        // Check for uniqueness
                        if (\models\ProspectSource::isUnique($this->input->post('newSource'), $this->account())) {
                            // Save the status
                            $newSource = new \models\ProspectSource();
                            $newSource->setName($this->input->post('newSource'));
                            $newSource->setCompany($this->account()->getCompany()->getCompanyId());
                            //add a history log for status start 
                            $newSourceText = $this->input->post('newSource');
                            //echo $newStatus;die;
                            $this->log_manager->add(\models\ActivityAction::COMPANY_ADD_PROSPECT_SOURCE, "Added prospect settings source: $newSourceText");
                            //add a history log for staus close
                            $this->em->persist($newSource);
                            $this->em->flush();


                            $this->session->set_flashdata('success', 'Prospect Source Added');
                            redirect('account/prospect_settings');
                        } else {
                            $this->session->set_flashdata('error', 'This Prospect Source already exists');
                            redirect('account/prospect_settings');
                        }

                        if ($newSource->getId()) {
                            $this->log_manager->add(\models\ActivityAction::COMPANY_ADD_PROSPECT_SOURCE,
                                "Prospect Source of '" . $newSource->getName() . "' added", null, null, $this->account());
                            $this->session->set_flashdata('success',
                                "Prospect Source: '" . $newSource->getName() . "' has been added");
                            redirect('account/prospect_settings');
                        } else {
                            $this->session->set_flashdata('error',
                                'There was a problem saving the new source. Please try again.');
                            redirect('account/prospect_settings');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Please Enter Source Name.');
                        redirect('account/prospect_settings');
                    }
                    break;

                case 'delete':
                    if ($this->input->post('sourceId')) {

                        $deletedSource = new models\ProspectSourceDeleted();
                        $deletedSource->setCompany($this->account()->getCompany()->getCompanyId());
                        $deletedSource->setProspectSourceId($this->input->post('sourceId'));
                        $this->em->persist($deletedSource);
                        $this->em->flush();

                        $this->session->set_flashdata('success', 'Prospect Source Deleted');
                        redirect('account/prospect_settings');
                    }
                    break;
            }
        }

        $data['layout'] = 'account/my_account/prospect_settings';
        $data['prospectSources'] = $this->getCompanyRepository()->getProspectSources($data['company']);
        $this->load->view('account/my_account', $data);
    }

    function prospect_rating_settings()
    {
        $data = $this->edit_company_data();

        if ($this->input->post('action')) {
            switch ($this->input->post('action')) {

                case 'add':
                    if ($this->input->post('newRating')) {

                        // Check for uniqueness
                        if (\models\ProspectRating::isUnique($this->input->post('newRating'), $this->account())) {
                            // Save the status
                            $newRating = new \models\ProspectRating();
                            $newRating->setRatingName($this->input->post('newRating'));
                            $newRating->setCompany($this->account()->getCompany()->getCompanyId());
                            //add a history log for rating start 
                            $newRatingText = $this->input->post('newRating');
                            //echo $newStatus;die;
                            $this->log_manager->add(\models\ActivityAction::COMPANY_ADD_PROSPECT_RATING, "Added prospect settings source: $newRatingText");
                            //add a history log for rating close
                            $this->em->persist($newRating);
                            $this->em->flush();

                            $this->session->set_flashdata('success', 'Prospect Rating Added');
                            redirect('account/prospect_rating_settings');
                        } else {
                            $this->session->set_flashdata('error', 'This Prospect Rating already exists');
                            redirect('account/prospect_rating_settings');
                        }

                        if ($newRating->getId()) {
                            $this->log_manager->add(\models\ActivityAction::COMPANY_ADD_PROSPECT_RATING,
                                "Prospect Rating of '" . $newRating->getRatingName() . "' added", null, null, $this->account());
                            $this->session->set_flashdata('success',
                                "Prospect Rating: '" . $newRating->getRatingName() . "' has been added");
                            redirect('account/prospect_rating_settings');
                        } else {
                            $this->session->set_flashdata('error',
                                'There was a problem saving the new rating. Please try again.');
                            redirect('account/prospect_rating_settings');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Please Enter Rating Name.');
                        redirect('account/prospect_rating_settings');
                    }
                    break;

                case 'delete':
                    if ($this->input->post('ratingId')) {
                        $ratingId = $this->input->post('ratingId');

                        $deletedSource = new models\ProspectRatingDeleted();
                        $deletedSource->setCompany($this->account()->getCompany()->getCompanyId());
                        $deletedSource->setProspectRatingId($ratingId);
                        $this->em->persist($deletedSource);
                        $this->em->flush();

                        $this->session->set_flashdata('success', 'Prospect Rating Deleted');
                        redirect('account/prospect_rating_settings');
                    }
                    break;
            }
        }

        $data['layout'] = 'account/my_account/prospect_rating_settings';
        $data['prospectRatings'] = $this->getCompanyRepository()->getProspectRatings($data['company']);
        $this->load->view('account/my_account', $data);
    }

    function business_type_settings()
    {
        $data = $this->edit_company_data();

        if ($this->input->post('action')) {
            switch ($this->input->post('action')) {

                case 'add':
                    if ($this->input->post('newBusinessType')) {

                        // Check for uniqueness
                        if (\models\BusinessType::isUnique($this->input->post('newBusinessType'), $this->account())) {
                            // Save the status
                            $newType = new \models\BusinessType();
                            $newType->setTypeName($this->input->post('newBusinessType'));
                            $newType->setCompanyId($this->account()->getCompany()->getCompanyId());
                            $this->em->persist($newType);
                            $this->em->flush();
                            //Temp Delete Cache result
                            $this->getQueryCacheRepository()->deleteCompanyBusinessTypeCache($this->account()->getCompanyId());
                            // $this->em->getConfiguration()->getResultCacheImpl()->delete( CACHE_COMPANY_BUSINESS_TYPE . $this->account()->getCompanyId());

                            $this->log_manager->add(\models\ActivityAction::COMPANY_ADD_BUSINESS_TYPE,
                            "Business Type of '" . $newType->getTypeName() . "' added", null, null, $this->account());
                            $this->session->set_flashdata('success', 'Business Type Added');
                            redirect('account/business_type_settings');
                        } else {
                            $this->session->set_flashdata('error', 'This Business Type already exists');
                            redirect('account/business_type_settings');
                        }

                        if ($newType->getId()) {
                           
                            $this->session->set_flashdata('success',
                                "Business Type: '" . $newType->getTypeName() . "' has been added");
                            redirect('account/business_type_settings');
                        } else {
                            $this->session->set_flashdata('error',
                                'There was a problem saving the new Business Type. Please try again.');
                            redirect('account/business_type_settings');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Please Enter Business Type.');
                        redirect('account/business_type_settings');
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

                                //Temp Delete Cache result    
                                $this->getQueryCacheRepository()->deleteCompanyBusinessTypeCache($this->account()->getCompanyId());
                                // $this->em->getConfiguration()->getResultCacheImpl()->delete( CACHE_COMPANY_BUSINESS_TYPE . $this->account()->getCompanyId());
                                
                                $this->log_manager->add(\models\ActivityAction::COMPANY_EDIT_BUSINESS_TYPE,
                                "Business Type Chaged from '" . $oldtype . "' to '" . $business_type->getTypeName() . "' ", null, null, $this->account());
                                $this->session->set_flashdata('success', 'Business type Updated');
                                redirect('account/business_type_settings');
                            } else {
                                $this->session->set_flashdata('error', 'There was a problem loading the status. Please try again.');
                                redirect('account/business_type_settings');
                            }
    
                        } else {
                            $this->session->set_flashdata('error', 'Please enter a Business type Text');
                            redirect('account/business_type_settings');
                        }
                        break;

                case 'delete':
                    

                    if ($this->input->post('businessTypeId')) {
                        $typeId = $this->input->post('businessTypeId');
                        $business_type = $this->em->find('\models\BusinessType', $this->input->post('businessTypeId'));
                        $deletedType = new models\BusinessTypeDeleted();
                        $deletedType->setCompany($this->account()->getCompany()->getCompanyId());
                        $deletedType->setbusinessTypeId($typeId);
                        $this->em->persist($deletedType);
                        $this->em->flush();
                        //Temp Delete Cache result
                        $this->getQueryCacheRepository()->deleteCompanyBusinessTypeCache($this->account()->getCompanyId());
                        // $this->em->getConfiguration()->getResultCacheImpl()->delete( CACHE_COMPANY_BUSINESS_TYPE . $this->account()->getCompanyId());

                        $this->log_manager->add(\models\ActivityAction::COMPANY_DELETE_BUSINESS_TYPE,
                                "Business Type '" . $business_type->getTypeName() . "' Deleted ", null, null, $this->account());
                        $data = array();
                        $data['error'] = 0;
                        $data['isSuccess']=true;
                        

                        echo json_encode($data);
                    die;
                        // $this->session->set_flashdata('success', 'Business Type Deleted');
                        // redirect('admin/business_type');
                    }
                    break;
            }
        }

        $data['layout'] = 'account/my_account/business_type_settings';
        $data['businessTypes'] = $this->getCompanyRepository()->getCompanyBusinessTypes($data['company']);
        $this->load->view('account/my_account', $data);
    }

    function prospect_status_settings()
    {
        $data = $this->edit_company_data();

        if ($this->input->post('action')) {
            switch ($this->input->post('action')) {

                case 'add':
                    if ($this->input->post('newStatus')) {

                        // Check for uniqueness
                        if (\models\ProspectStatus::isUnique($this->input->post('newStatus'), $this->account())) {
                            // Save the status
                            $newStatus = new \models\ProspectStatus();
                            $newStatus->setStatusName($this->input->post('newStatus'));
                            $newStatus->setCompany($this->account()->getCompany()->getCompanyId());
                            //add a history log for status start 
                            $newStatusText = $this->input->post('newStatus');
                            //echo $newStatus;die;
                            $this->log_manager->add(\models\ActivityAction::COMPANY_ADD_PROSPECT_STATUS, "Added prospect settings source: $newStatusText");
                            //add a history log for staus close
                            $this->em->persist($newStatus);
                            $this->em->flush();

                            $this->session->set_flashdata('success', 'Prospect Business Type Added');
                            redirect('account/prospect_status_settings');
                        } else {
                            $this->session->set_flashdata('error', 'This Prospect Business Type already exists');
                            redirect('account/prospect_status_settings');
                        }

                        if ($newStatus->getId()) {
                            $this->log_manager->add('Added Prospect Business Type Status',
                                "Prospect Status of '" . $newStatus->getStatusName() . "' added", null, null, $this->account());
                            $this->session->set_flashdata('success',
                                "Prospect Status: '" . $newStatus->getStatusName() . "' has been added");
                            redirect('account/prospect_status_settings');
                        } else {
                            $this->session->set_flashdata('error',
                                'There was a problem saving the new Business Status. Please try again.');
                            redirect('account/prospect_status_settings');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Please Business Status.');
                        redirect('account/prospect_status_settings');
                    }
                    break;

                case 'delete':

                    //echo $this->input->post('statusId');die;
                    if ($this->input->post('statusId')) {
                        $statusId = $this->input->post('statusId');

                        $deletedStatus = new models\ProspectStatusDeleted();
                        $deletedStatus->setCompany($this->account()->getCompany()->getCompanyId());
                        $deletedStatus->setProspectStatusId($statusId);
                        $this->em->persist($deletedStatus);
                        $this->em->flush();

                        $this->session->set_flashdata('success', 'Prospect Status Deleted');
                        redirect('account/prospect_status_settings');
                    }
                    break;
            }
        }

        $data['layout'] = 'account/my_account/prospect_status_settings';
        $data['prospectStatuses'] = $this->getCompanyRepository()->getProspectStatuses($data['company']);
        $this->load->view('account/my_account', $data);
    }


    function lead_settings()
    {
        $notificationRepository = $this->getLeadNotificationsRepository();
        $data = $this->edit_company_data();
        if ($this->input->post('save')) {
            $notificationData = [
                'enabled' => $this->input->post('enabled'),
                'instant' => $this->input->post('instant'),
                'account' => $this->input->post('account'),
                'company' => $this->input->post('company'),
                'notificationIntervals' => (is_array($this->input->post('intervals'))) ? implode('|',
                    $this->input->post('intervals')) : '',
            ];
            $logMessage = 'Updated Lead Notification Settings: Enabled: ' . (($this->input->post('enabled') ? 'Yes' : 'No')) .
                ', Instant: ' . (($this->input->post('instant') ? 'Yes' : 'No')) .
                ', Daily Notifications: ' . ((is_array($this->input->post('intervals'))) ? implode(', ',
                    $this->input->post('intervals')) : 'None');
            // $this->getLogRepository()->add([
            //     'action' => 'updated_lead_notification_settings',
            //     'details' => $logMessage,
            //     'account' => $this->account()->getAccountId()
            // ]);
            $this->getLogRepository()->add([
                'action' => \models\ActivityAction::LEAD_SETTINGS,
                'details' => "$logMessage",
                'account' => $this->account()->getAccountId(),
                'company' => $this->account()->getCompanyId()
                ]); 
            $this->db->delete('lead_notification_settings', array('company' => $this->input->post('company')));
            $this->db->insert('lead_notification_settings', $notificationData);
            $this->session->set_flashdata('success', 'Lead notification settings updated!');
            redirect('account/lead_settings');
        }
        $data['notification_settings'] = $notificationRepository->getLeadNotificationSettings($this->account()->getCompany()->getCompanyId());
        $data['layout'] = 'account/my_account/lead_settings';
        $data['accounts'] = $this->account()->getCompany()->getAccounts();
        $data['intervals'] = $this->system_setting('leads_notification_intervals');
        $this->load->view('account/my_account', $data);
    }

    function lead_settings2()
    {
        $data = $this->edit_company_data();

        if ($this->input->post('action')) {
            switch ($this->input->post('action')) {

                case 'add':
                    if ($this->input->post('newSource')) {

                        // Check for uniqueness
                        if (\models\LeadSource::isUnique($this->input->post('newSource'), $this->account())) {
                            // Save the status
                            $newSource = new \models\LeadSource();
                            $newSource->setName($this->input->post('newSource'));
                            $newSource->setCompany($this->account()->getCompany()->getCompanyId());
                            $this->em->persist($newSource);
                            $this->em->flush();
                        } else {
                            $this->session->set_flashdata('error', 'This Lead Source already exists');
                            redirect('account/lead_settings2');
                        }

                        if ($newSource->getId()) {
                            $this->log_manager->add(\models\ActivityAction::COMPANY_ADD_LEAD_SOURCE,
                                "Lead Source of '" . $newSource->getName() . "' added", null, null, $this->account());
                            $this->session->set_flashdata('success',
                                "Lead Source: '" . $newSource->getName() . "' has been added");
                            redirect('account/lead_settings2');
                        } else {
                            $this->session->set_flashdata('error',
                                'There was a problem saving the new source. Please try again.');
                            redirect('account/lead_settings2');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Please Enter Source Name.');
                        redirect('account/lead_settings2');
                    }
                    break;

                case 'delete':
                    if ($this->input->post('sourceId')) {

                        $deletedSource = new models\LeadSourceDeleted();
                        $deletedSource->setCompany($this->account()->getCompany()->getCompanyId());
                        $deletedSource->setLeadSourceId($this->input->post('sourceId'));
                        $this->em->persist($deletedSource);
                        $this->em->flush();

                        $this->session->set_flashdata('success', 'Lead Source Deleted');
                        redirect('account/lead_settings2');
                    }
                    break;
            }
        }

        $data['layout'] = 'account/my_account/lead_settings2';
        $data['leadSources'] = $this->account()->getCompany()->getLeadSources(true);
        $this->load->view('account/my_account', $data);
    }

    function company_proposal_settings2()
    {
        $data = $this->edit_company_data();
        if ($this->input->post('save')) {
            $company = $data['company'];
            $company->setAboutCompany($this->input->post('aboutCompany'));
            $this->em->persist($company);
            $this->em->flush();
            $this->log_manager->add(\models\ActivityAction::UPDATE_COMPANY, 'About Company updated in My Account. ');
            $this->session->set_flashdata('success', 'About Company updated!');
            $this->getCompanyRepository()->flagProposalsForRebuild($company->getCompanyId());
            redirect('account/company_proposal_settings2');
        }
        $this->html->addScript('ckeditor4');
        $data['layout'] = 'account/my_account/proposal_settings_2';
        $this->html->addScript('dataTables');
        $salesManagerDeactive = $this->account()->getCompany()->getSalesManager();
        if ($salesManagerDeactive==0 ) {
            $tabDeactivearr = 0; //inactive
        }else{
            $tabDeactivearr = 1; //active
        } 
        $data['checkActive']=$tabDeactivearr; 
        $this->load->view('account/my_account', $data);
    }

    function company_proposal_intro()
    {
        $data = $this->edit_company_data();
        if ($this->input->post('save')) {
            $company = $data['company'];
            $company->setCompanyIntro($this->input->post('companyIntro'));
            $this->em->persist($company);
            $this->em->flush();
            $this->log_manager->add(\models\ActivityAction::UPDATE_COMPANY, 'Company Intro updated in My Account. ');
            $this->session->set_flashdata('success', 'Company Intro updated!');
            $this->getCompanyRepository()->flagProposalsForRebuild($company->getCompanyId());
            redirect('account/company_proposal_intro');
        }

        $salesManagerDeactive = $this->account()->getCompany()->getSalesManager();
        if ($salesManagerDeactive==0) {
                  $tabDeactivearr = 0; //inactive
              }else{
                  $tabDeactivearr = 1; //active
              }
        $data['checkActive']=$tabDeactivearr; 

        $this->html->addScript('ckeditor4');
        $data['layout'] = 'account/my_account/company_proposal_intro';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    function company_proposal_settings3()
    {
        $data = $this->edit_company_data();
        if ($this->input->post('save')) {
            $company = $data['company'];
            $company->setStandardLayoutIntro($this->input->post('standardLayoutIntro'));
            $company->setStandardHeaderFont($this->input->post('header_font'));
            $company->setStandardTextFont($this->input->post('text_font'));
            $this->em->persist($company);
            $this->em->flush();
            $this->log_manager->add(\models\ActivityAction::UPDATE_COMPANY, 'Proposal Standard Layout Settings updated in My Account.');
            $this->session->set_flashdata('success', 'Proposal Standard Layout Settings updated!');
            $this->getCompanyRepository()->flagProposalsForRebuild($company->getCompanyId());
            redirect('account/company_proposal_settings3');
        }
        $this->html->addScript('ckeditor4');
        $data['layout'] = 'account/my_account/proposal_settings_3';
        $this->html->addScript('dataTables');

        $salesManagerDeactive = $this->account()->getCompany()->getSalesManager();
    
        if ($salesManagerDeactive==0 ) {
            $tabDeactivearr = 0; //inactive
        }else{
            $tabDeactivearr = 1; //active
        } 
        $data['checkActive']=$tabDeactivearr; 

        $this->load->view('account/my_account', $data);
    }

    public function order_lead_sources()
    {
        $this->account()->getCompany()->clearLeadSourceOrder();

        $sources = $this->input->post('source');

        if (count($sources)) {
            $i = 1;
            foreach ($sources as $source) {
                $lso = new models\LeadSourceOrder();
                $lso->setOrd($i);
                $lso->setLeadSourceId($source);
                $lso->setCompany($this->account()->getCompany()->getCompanyId());
                $this->em->persist($lso);
                $i++;
            }
            $this->em->flush();
        }

        echo json_encode(array('error' => 0));
    }

    /**
     * @description Set the order of prospect sources for this company
     */
    public function order_prospect_sources()
    {
        $this->getCompanyRepository()->clearProspectSourceOrder($this->account()->getCompany());

        $sources = $this->input->post('source');

        if (count($sources)) {
            $i = 1;
            foreach ($sources as $source) {
                $pso = new models\ProspectSourceOrder();
                $pso->setOrd($i);
                $pso->setProspectSourceId($source);
                $pso->setCompany($this->account()->getCompany()->getCompanyId());
                $this->em->persist($pso);
                $i++;
            }
            $this->em->flush();
        }
        echo json_encode(array('error' => 0));
    }


    /**
     * @description Set the order of prospect rating for this company
     */
    public function order_prospect_ratings()
    {
        $this->getCompanyRepository()->clearProspectRatingOrder($this->account()->getCompany());

        $ratings = $this->input->post('rating');

        if (count($ratings)) {
            $i = 1;
            foreach ($ratings as $rating) {
                $pso = new models\ProspectRatingOrder();
                $pso->setOrd($i);
                $pso->setProspectRatingId($rating);
                $pso->setCompany($this->account()->getCompany()->getCompanyId());
                $this->em->persist($pso);
                $i++;
            }
            $this->em->flush();
        }
        echo json_encode(array('error' => 0));
    }

    /**
     * @description Set the order of prospect Type for this company
     */
    public function order_prospect_type()
    {
        $this->getCompanyRepository()->clearProspectTypeOrder($this->account()->getCompany());

        $types = $this->input->post('type');

        if (count($types)) {
            $i = 1;
            foreach ($types as $type) {
                $pso = new models\ProspectTypeOrder();
                $pso->setOrd($i);
                $pso->setProspectTypeId($type);
                $pso->setCompany($this->account()->getCompany()->getCompanyId());
                $this->em->persist($pso);
                $i++;
            }
            $this->em->flush();
        }
        echo json_encode(array('error' => 0));
    }

        /**
     * @description Set the order of prospect Status for this company
     */
    public function order_prospect_status()
    {
        $this->getCompanyRepository()->clearProspectStatusOrder($this->account()->getCompany());

        $statuses = $this->input->post('type');

        if (count($statuses)) {
            $i = 1;
            foreach ($statuses as $status) {
                $pso = new models\ProspectStatusOrder();
                $pso->setOrd($i);
                $pso->setProspectStatusId($status);
                $pso->setCompany($this->account()->getCompany()->getCompanyId());
                $this->em->persist($pso);
                $i++;
            }
            $this->em->flush();
        }
        echo json_encode(array('error' => 0));
    }

    /**
     * @description Set the order of prospect Type for this company
     */
    public function order_admin_business_type()
    {
        //$this->getCompanyRepository()->clearAdminBusinessTypeOrder();

        $types = $this->input->post('type');

        if (count($types)) {
            $i = 1;
            foreach ($types as $type) {
                $bt = $this->em->find('models\BusinessType', $type);
                $bt->setOrd($i);
                $this->em->persist($bt);
                $i++;
            }
            $this->em->flush();
        }
        echo json_encode(array('error' => 0));
    }

    /**
     * @description Set the order of prospect Type for this company
     */
    public function order_admin_proposal_section()
    {
        //$this->getCompanyRepository()->clearAdminBusinessTypeOrder();

        $types = $this->input->post('type');

        if (count($types)) {
            $i = 1;
            foreach ($types as $type) {
                $bt = $this->em->find('models\ProposalSection', $type);
                $bt->setOrd($i);
                $this->em->persist($bt);
                $i++;
            }
            $this->em->flush();
        }
        echo json_encode(array('error' => 0));
    }

    /**
     * @description Set the order of prospect Type for this company
     */
    public function order_company_business_type()
    {
        $this->getCompanyRepository()->clearCompanyBusinessTypeOrder($this->account()->getCompany());

        $types = $this->input->post('type');

        if (count($types)) {
            $i = 1;
            foreach ($types as $type) {
                $bso = new models\BusinessTypeOrder();
                $bso->setOrd($i);
                $bso->setBusinessTypeId($type);
                $bso->setCompany($this->account()->getCompany()->getCompanyId());
                $this->em->persist($bso);
                $i++;
            }
            $this->em->flush();
            //Temp Delete Cache result
            $this->getQueryCacheRepository()->deleteCompanyBusinessTypeCache($this->account()->getCompanyId());
            // $this->em->getConfiguration()->getResultCacheImpl()->delete( CACHE_COMPANY_BUSINESS_TYPE . $this->account()->getCompanyId());
        }
        echo json_encode(array('error' => 0));
    }


    function company_proposal_settings4()
    {
        $data = $this->edit_company_data();


        if ($this->input->post('save')) {
            $company = $data['company'];
            /* @var $company \models\Companies */

            $useAutoNum = 0;
            if ($this->input->post('useAutoNumber')) {
                $useAutoNum = 1;
            }

            $company->setUseAutoNum($useAutoNum);
            $company->setAutoNumPrefix($this->input->post('autoNumberPrefix'));
            $company->setAutoNum($this->input->post('autoNumberValue'));

            $this->em->persist($company);
            $this->em->flush();
            $this->log_manager->add(\models\ActivityAction::UPDATE_COMPANY, 'Job Number Settings updated');
            $this->session->set_flashdata('success', 'Job Number Settings Saved!');
            redirect('account/company_proposal_settings4');
        }
        $this->html->addScript('ckeditor4');
        $data['layout'] = 'account/my_account/proposal_settings_4';
        $this->html->addScript('dataTables');

        $salesManagerDeactive = $this->account()->getCompany()->getSalesManager();
        if ($salesManagerDeactive==0 ) {
            $tabDeactivearr = 0; //inactive
        }else{
            $tabDeactivearr = 1; //active
        } 
        $data['checkActive']=$tabDeactivearr; 

        $this->load->view('account/my_account', $data);
    }

    function company_proposal_settings5()
    {


        $data = $this->edit_company_data();
        /* @var $company \models\Companies */
        $company = $data['company'];
        if ($this->input->post('save')) {
            $companyRepo = $this->getCompanyRepository();
            $webLayout = $this->input->post('webLayout');
            $company->setLayout($this->input->post('layout'));
            $companyRepo->resetUserLayouts($company->getCompanyId());
            $company_settings = $this->em->find('models\CompanySettings',$company->getCompanyId());
            $company_settings->setWebLayout($webLayout);
            if($webLayout == 1){
                $company_settings->setIsPreProposalPopup($this->input->post('preProposalPopup'));
            }
            $this->em->persist($company);
            $this->em->persist($company_settings);
            $this->em->flush();
            $this->log_manager->add(\models\ActivityAction::EDIT_PROPOSAL,
                'Proposal default layout set to ' . $this->input->post('layout'));
            $this->session->set_flashdata('success', 'Layout Settings Saved');
            redirect('account/company_proposal_settings5');
        }

        $salesManagerDeactive = $this->account()->getCompany()->getSalesManager();
        if ($salesManagerDeactive==0) {
                  $tabDeactivearr = 0; //inactive
              }else{
                  $tabDeactivearr = 1; //active
              }
        $data['checkActive']=$tabDeactivearr; 

        $data['layout'] = 'account/my_account/proposal_settings_5';
        $data['layouts'] = $this->account()->getCompany()->getLayouts();
        $data['selected_layout'] = $company->getLayout();
        $data['savedWebLayout'] =  $this->account()->getCompany()->getCompanySettings()->getWebLayout();
        $data['isPreProposalPopup'] =  $this->account()->getCompany()->getCompanySettings()->getIsPreProposalPopup();
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    function company_proposal_settings6()
    {
        $data = $this->edit_company_data();
       
        /* @var $company \models\Companies */
        $company = $data['company'];
 

        if ($this->input->post('header_font')) {
            $this->load->library('jobs');
            //print_r($_FILES['gradientImage']['error']);die;
            //print_r($this->input->post('select_background_image'));die;

            $opacity = $this->input->post('gradientOpacity');
            $pct = floor($opacity * 100);
            $manager = new ImageManager();

            $originalFileName = UPLOADPATH . '/clients/logos/bg-' . $this->account()->getCompany()->getCompanyId() . '-orig.png';

          
            $fileName = UPLOADPATH . '/clients/logos/bg-' . $this->account()->getCompany()->getCompanyId() . '.png';


            // Save the image original
            if($this->input->post('select_background_image')=='0'){
                if (!$_FILES['gradientImage']['error']) {
                
                    $img = $manager->make($_FILES['gradientImage']['tmp_name']);
                    $img->resize(919, 1300);
                    $img->save($originalFileName);
                }
            }else{
                $img = $manager->make($this->input->post('background_url'));
                $img->resize(919, 1300);
                $img->save($originalFileName);
            }
          

            $params =[$this->account()->getCompany()->getCompanyId(),$this->input->post('gradientOpacity')];
            //$params =array('postvar1' => 'value1');
            
            // Save the opaque image
            $this->jobs->create($_ENV['QUEUE_HIGH'], 'jobs', 'account_image_process',$params,'test job');
            // if (file_exists($originalFileName)) {
            //     $img = $manager->make($originalFileName);
            //     $img->opacity($pct);
            //     $img->save($fileName);
            // }

            $company->setGradientOpacity($this->input->post('gradientOpacity'));
            $company->setHeaderBgColor($this->input->post('headerBgColor'));
            $company->setHeaderBgOpacity($this->input->post('bgOpacity'));
            $company->setHeaderFontColor($this->input->post('headerFontColor'));
            $company->setHeaderFont($this->input->post('header_font'));
            $company->setProposalBackground($this->input->post('select_background_image'));
            $company->setIsShowProposalLogo($this->input->post('show_logo'));
            
            $company->setTextFont($this->input->post('text_font'));
            $this->em->persist($company);
            $this->em->flush();
            $this->log_manager->add(\models\ActivityAction::EDIT_PROPOSAL, 'Custom Layout Settings Updated');
            $this->session->set_flashdata('success', 'Your image is currently being processed and will update automatically in the next 2 minutes.');
           
            redirect('account/company_proposal_settings6');
        }


        $salesManagerDeactive = $this->account()->getCompany()->getSalesManager();
        if ($salesManagerDeactive==0) {
                  $tabDeactivearr = 0; //inactive
              }else{
                  $tabDeactivearr = 1; //active
              }
         $data['checkActive']=$tabDeactivearr; 

        $data['layout'] = 'account/my_account/proposal_settings_6';

 
 
        $data['layouts'] = $this->system_setting('proposal_layouts');
        $data['selected_layout'] = $company->getLayout();
        $this->html->addScript('colorpicker');
        $this->load->view('account/my_account', $data);
    }

    function company_proposal_settings7()
    {
        $data = $this->edit_company_data();
        /* @var $company \models\Companies */
        $company = $data['company'];
        $linkRepository = new \Pms\Repositories\ProposalLinks();
        if ($this->input->post('name') && $this->input->post('url')) {
            $proposal = ($this->input->post('proposal')) ? $this->input->post('proposal') : 0;
            $linkRepository->addLink($this->input->post('name'), $this->input->post('url'), $company->getCompanyId(),
                $proposal);
            $this->session->set_flashdata('success', 'Link added!');
            if ($this->uri->segment(3) == 'edit') {
                redirect('proposals/edit/' . $this->uri->segment(4));
            } else {
                redirect('account/company_proposal_settings7');
            }
        }
        $data['layout'] = 'account/my_account/proposal_settings_7';
        $data['layouts'] = $this->system_setting('proposal_layouts');
        $data['selected_layout'] = $company->getLayout();
        $data['proposal_links'] = $linkRepository->getCompanyProposalLinks($company->getCompanyId());

        $salesManagerDeactive = $this->account()->getCompany()->getSalesManager();
        if ($salesManagerDeactive==0 ) {
            $tabDeactivearr = 0; //inactive
        }else{
            $tabDeactivearr = 1; //active
        } 
        $data['checkActive']=$tabDeactivearr; 

        $this->load->view('account/my_account', $data);
    }

    public function deleteProposalLink($id, $proposal = null)
    {
        $linkRepository = new \Pms\Repositories\ProposalLinks();
        $linkRepository->deleteLink($id);
        $this->session->set_flashdata('success', 'Link deleted!');
        if (!$proposal) {
            redirect('account/company_proposal_settings7');
        } else {
            redirect('proposals/edit/' . $proposal);
        }
    }

    public function updateLinkDetails()
    {
         $linkRepository = new \Pms\Repositories\ProposalLinks();
       //  $linkRepository->
         $linkRepository->updateLinkDetails($this->input->post('id'), $this->input->post('name'),
            $this->input->post('url'));
         $linkName = $this->input->post('name');
         $proposal = $this->em->findProposal($this->input->post('proposal_id'));
          $this->getLogRepository()->add([
            'action' => \models\ActivityAction::UPDATE_PROPOSAL_SETTING,
            'details' => "Update link for $linkName of Proposal",
            'proposal' => $proposal->getProposalId(),
            'account' => $this->account()->getAccountId(),
            'company' => $this->account()->getCompanyId(),
        ]);
        echo "1";
    }

    public function coverTemplate()
    {
        $file = STATIC_PATH . '/cover_template.png';
        if (file_exists($file)) {

            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename=' . basename($file));
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Content-Length: ' . filesize($file));

            ob_clean();
            flush();
            readfile($file);
            exit;
        }
    }

    function company_legal()
    {
        $data = $this->edit_company_data();
        if ($this->input->post('save')) {
            $company = $data['company'];
            $company->setContractCopy($this->input->post('contractCopy'));
            $this->em->persist($company);
            $this->em->flush();
            $this->log_manager->add(\models\ActivityAction::UPDATE_COMPANY, 'Company Contract Copy updated in My Account.');
            $this->session->set_flashdata('success', 'Company Contract Copy updated!');
            redirect('account/company_legal');
        }
        $data['layout'] = 'account/my_account/legal1';
        $this->html->addScript('dataTables');
        $this->html->addScript('ckeditor4');
        $this->load->view('account/my_account', $data);
    }

    function company_legal2()
    {
        $data = $this->edit_company_data();
        if ($this->input->post('save')) {
            $company = $data['company'];
            $company->setPaymentTermText($this->input->post('paymentTermText'));
            $this->em->persist($company);
            $this->em->flush();
            $this->log_manager->add(\models\ActivityAction::UPDATE_COMPANY, 'Company Payment Term updated in My Account.');
            $this->session->set_flashdata('success', 'Company Payment Term updated!');
            redirect('account/company_legal2');
        }
        $data['layout'] = 'account/my_account/legal2';
        $this->html->addScript('dataTables');
        $this->html->addScript('ckeditor4');
        $this->load->view('account/my_account', $data);
    }

    function company_legal3()
    {
        $data = $this->edit_company_data();
        if ($this->input->post('save')) {
            $company = $data['company'];
            $company->setPaymentTerm($this->input->post('paymentTerm'));
            $this->em->persist($company);
            $this->em->flush();
            $this->log_manager->add(\models\ActivityAction::UPDATE_COMPANY, 'Company Payment Term Text updated in My Account.');
            $this->session->set_flashdata('success', 'Company Payment Term Text updated!');
            redirect('account/company_legal3');
        }
        $data['layout'] = 'account/my_account/legal3';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    function company_logo()
    {
        $data = $this->edit_company_data();
        $company = $data['company'];
        $acceptedImages = array('image/jpeg', 'image/pjpeg', 'image/jpg', 'image/png', 'image/x-png');
        if ($this->input->post('changeLogo')) {
            if ($_FILES['clientLogo']['error'] === 0) {
                if (!in_array($_FILES['clientLogo']['type'], $acceptedImages)) {
                    $this->session->set_flashdata('error', 'Only JPEG and PNG format is accepted!');
                    redirect('account/company_logo');
                } else {
                    //check if file size is larger than 500KB
                    if ($_FILES['clientLogo']['size'] > 512000) {
                        $this->session->set_flashdata('error',
                            'File size exceeds 500KB! You are not allowed to upload files larger than that.');
                        redirect('account/company_logo');
                    } else {
                        $path = UPLOADPATH . '/clients/logos/';
                        $filename = 'logo-' . $company->getCompanyId() . '.';
                        switch ($_FILES['clientLogo']['type']) {
                            case 'image/jpeg':
                                $filename .= 'jpg';
                                break;
                            case 'image/jpg':
                                $filename .= 'jpg';
                                break;
                            case 'image/pjepg':
                                $filename .= 'jpg';
                                break;
                            case 'image/png':
                                $filename .= 'jpg';
                                break;
                        }
                        $imagepath = $path . $filename;
                        if (file_exists($imagepath)) {
                            unlink($imagepath);
                        }
                        if (in_array($_FILES['clientLogo']['type'], array('image/png', 'image/x-png'))) {
                            $sizes = getimagesize($_FILES['clientLogo']['tmp_name']);
                            $w = $sizes[0];
                            $h = $sizes[1];
                            $white_bg = imagecreatetruecolor($w, $h);
                            $white = imagecolorallocate($white_bg, 255, 255, 255);
                            imagefill($white_bg, 0, 0, $white);
                            $im = imagecreatefrompng($_FILES['clientLogo']['tmp_name']);
                            imagealphablending($im, true);
                            imagealphablending($white_bg, true);
                            $out = imagecreatetruecolor($w, $h);
                            imagecopyresampled($out, $white_bg, 0, 0, 0, 0, $w, $h, $w, $h);
                            imagecopyresampled($out, $im, 0, 0, 0, 0, $w, $h, $w, $h);
                            imagejpeg($out, $imagepath);
                        } else {
                            move_uploaded_file($_FILES['clientLogo']['tmp_name'], $imagepath);
                        }
                        $company->setCompanyLogo($filename);
                        $this->em->persist($company);
                        $this->em->flush();

                        // Flag for rebuild
                        $this->getCompanyRepository()->flagProposalsForRebuild($company->getCompanyId());

                        $this->log_manager->add(\models\ActivityAction::UPDATE_COMPANY_LOGO, 'Company Logo updated');
                        $this->session->set_flashdata('success', 'Company Logo updated succesfully!.');
                        redirect('account/company_logo');
                    }
                }
            } else {
                $this->session->set_flashdata('error',
                    'Errors have occured during the upload. Please check your file format or size of file and try again a bit later.');
                redirect('account/company_logo');
            }
        }
        $data['layout'] = 'account/my_account/logo';
        $this->html->addScript('dataTables');
         $this->load->view('account/my_account', $data);
    }

    function company_logo_upload()
    {
        $data = $this->edit_company_data();
        $company = $data['company'];
        $acceptedImages = array('image/jpeg', 'image/pjpeg', 'image/jpg', 'image/png', 'image/x-png');
        if ($this->input->post('changeLogo')) {
            if ($_FILES['clientLogo']['error'] === 0) {
                if (!in_array($_FILES['clientLogo']['type'], $acceptedImages)) {
                    $data = array();
                    $data['status'] = 0;
                    $data['message'] = 'Format Incorrect';

                    echo json_encode($data);
                } else {
                    //check if file size is larger than 2MB
                    if ($_FILES['clientLogo']['size'] > 2048000) {
                       
                            $data = array();
                            $data['status'] = 0;
                            $data['message'] = 'File size exceeds 2MB! You are not allowed to upload files larger than that.';
        
                            echo json_encode($data);
                    } else {
                        $path = UPLOADPATH . '/clients/logos/';
                        $filename = 'logo-' . $company->getCompanyId() . '.';
                        switch ($_FILES['clientLogo']['type']) {
                            case 'image/jpeg':
                                $filename .= 'jpg';
                                break;
                            case 'image/jpg':
                                $filename .= 'jpg';
                                break;
                            case 'image/pjepg':
                                $filename .= 'jpg';
                                break;
                            case 'image/png':
                                $filename .= 'jpg';
                                break;
                        }
                        $imagepath = $path . $filename;
                        if (file_exists($imagepath)) {
                            unlink($imagepath);
                        }
                        if (in_array($_FILES['clientLogo']['type'], array('image/png', 'image/x-png'))) {
                            $sizes = getimagesize($_FILES['clientLogo']['tmp_name']);
                            $w = $sizes[0];
                            $h = $sizes[1];
                            $white_bg = imagecreatetruecolor($w, $h);
                            $white = imagecolorallocate($white_bg, 255, 255, 255);
                            imagefill($white_bg, 0, 0, $white);
                            $im = imagecreatefrompng($_FILES['clientLogo']['tmp_name']);
                            imagealphablending($im, true);
                            imagealphablending($white_bg, true);
                            $out = imagecreatetruecolor($w, $h);
                            imagecopyresampled($out, $white_bg, 0, 0, 0, 0, $w, $h, $w, $h);
                            imagecopyresampled($out, $im, 0, 0, 0, 0, $w, $h, $w, $h);
                            imagejpeg($out, $imagepath);
                        } else {
                            move_uploaded_file($_FILES['clientLogo']['tmp_name'], $imagepath);
                        }
                        $company->setCompanyLogo($filename);
                        $this->em->persist($company);
                        $this->em->flush();

                        // Flag for rebuild
                        $this->getCompanyRepository()->flagProposalsForRebuild($company->getCompanyId());

                        $this->log_manager->add(\models\ActivityAction::UPDATE_COMPANY_LOGO, 'Company Logo updated');
                        $data = array();
                        $data['status'] = 1;
                        $data['message'] = 'Uploaded';

                        echo json_encode($data);
                    }
                }
            } else {
                $data = array();
                $data['status'] = 0;
                $data['message'] = 'Errors have occured during the upload. Please check your file format or size of file and try again a bit later.';

                echo json_encode($data);


            }
        }
        
    }

    function company_proposal_details()
    {
        $data = $this->edit_company_data();
        $company = $data['company'];
        $data['categories'] = $this->customtexts->getCategories($company->getCompanyId());
        $data['texts'] = $this->customtexts->getTexts($company->getCompanyId());
        $deletedTexts = $this->em->createQuery('SELECT d FROM models\Deleted_customtexts d WHERE (d.companyId=' . $this->account()->getCompany()->getCompanyId() . ' AND d.replacedBy IS NULL)')->getResult();
        $data['deleted_texts'] = $deletedTexts;
        //added by ss
        $data['category'] = $this->account()->getCompany()->getCategories();
        $data['service_titles'] = $this->account()->getCompany()->getServiceTitles();
        $data['services'] = $this->account()->getCompany()->getServices(true);
        $data['disabledServices'] = $this->account()->getCompany()->getDisabledServices();
        //added by ss
     // echo "<pre>service_titles ";print_r($data['service_titles']); 
     // echo "<pre>servces78 ";print_r($data['services']);die;

        $data['layout'] = 'account/my_account/proposal_details';
        $data['enabledCategories'] = $this->getEnabledCustomtextCategories();
        $this->html->addScript('ckeditor4');
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    /**
     * Returns array containing ids of enabled categories
     * @return array
     */
    private function getEnabledCustomtextCategories()
    {
        $enabledCategories = [];
        $enabledCategoriesDb = $this->db->where('company',
            $this->account()->getCompany()->getCompanyId())->select('categoryId')->from('customtext_default_categories')->get();
        foreach ($enabledCategoriesDb->result() as $link) {
            $enabledCategories[] = $link->categoryId;
        }
        return $enabledCategories;
    }

    function company_services()
    {
        $data = $this->edit_company_data();

        $data['categories'] = $this->account()->getCompany()->getCategories();
        $data['service_titles'] = $this->account()->getCompany()->getServiceTitles();
        $data['services'] = $this->account()->getCompany()->getServices(true);
        $data['disabledServices'] = $this->account()->getCompany()->getDisabledServices(); 
        $data['layout'] = 'account/my_account/company-services';
        $data['account'] = $this->account();
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }
    
    function company_videos()
    {
        $data = $this->edit_company_data();

        $data['company_videos'] = $this->getCompanyRepository()->getCompanyVideos($this->account()->getCompany()->getCompanyId());

        $data['layout'] = 'account/my_account/company-videos';
        $data['account'] = $this->account();
        $data['company'] = $this->account()->getCompany();
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    function company_attachments()
    {
        if (($this->uri->segment(3) == 'delete') && ($this->uri->segment(4))) {
            $delete_attachment = $this->em->find('models\Attatchments', $this->uri->segment(4));
            if ($delete_attachment) {
                $this->log_manager->add('delete_attachment', 'Deleted Attachment ' . $delete_attachment->getFileName());
                $delete_attachment = $this->em->merge($delete_attachment);
                $this->em->remove($delete_attachment);
                $this->em->flush();
                $this->session->set_flashdata('success', 'Attachment deleted!');
                redirect('account/company_attachments');
            }
        }
        $data = $this->edit_company_data();
        $data['layout'] = 'account/my_account/attachments';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    function company_add_attachment()
    {
        $data = $this->edit_company_data();
        if (!$this->account()->isAdministrator()) {
            $this->session->set_flashdata('error', 'Only Company Administrators can view this page!');
            redirect('account/my_account');
        }
        $data = array();
        //check posted data
        $acceptedFiles = array(
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'png' => 'image/png',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'doc' => 'application/msword',
            'pdf' => 'application/pdf',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet'
        );
        //check uploaded data
        if ($this->input->post('upload')) {
            $error = '';
            //check file name
            if (!$this->input->post('fileName')) {
                $error .= 'You must input a file name!';
            }
            //check file type
            if (($_FILES['file']['error']) || (!in_array($_FILES['file']['type'], $acceptedFiles))) {
                $error .= 'File is required, and must be one of the following types: Images, Text, PDF, Documents!<br>';
                $this->session->set_flashdata('fileName', $this->input->post('fileName'));
            }
            if ($error) {
                $this->session->set_flashdata('error', $error);
                redirect('account/company_add_attachment');
            } else {
                $upload_dir = ATTACHMENTPATH . '/' . $this->account()->getCompany()->getCompanyId();
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $fileName = $_FILES['file']['name'];
                while (file_exists($upload_dir . '/' . $fileName)) {
                    $fileName = str_replace('.', '_' . rand(0, 9) . '.', $fileName);
                }
                move_uploaded_file($_FILES['file']['tmp_name'], $upload_dir . '/' . $fileName);
                $attachment = new \models\Attatchments();
                $attachment->setFileName($this->input->post('fileName'));
                $attachment->setCategory($this->input->post('category'));
                $attachment->setCompany($this->account()->getCompany());
                $include = ($this->input->post('include')) ? 1 : 0;
                $attachment->setInclude($include);
                $attachment->setFilePath($fileName);
                $this->em->persist($attachment);
                $this->em->flush();
                $this->log_manager->add(\models\ActivityAction::COMPANY_ADD_ATTACHMENT, 'Added Attachment ' . $attachment->getFileName());
                $this->session->set_flashdata('success', 'File Uploaded succesfully!');
                redirect('account/company_attachments');
            }
        }
        $data['account'] = $this->account();
        $data['layout'] = 'account/my_account/add_attachment';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    function company_edit_attachment()
    {
        $data = $this->edit_company_data();
        if (!$this->account()->isAdministrator()) {
            $this->session->set_flashdata('error', 'Only Company Administrators can view this page!');
            redirect('account/my_account');
        }
        /** @var \models\Attatchments $attachment */
        $attachment = $this->em->find('models\Attatchments', $this->uri->segment(3));
        if (!$attachment) {
            $this->session->set_flashdata('error', 'Inexistent attachment!');
            redirect('account/company_attachments');
        }
        if ($this->input->post('save')) {
            if (!$this->input->post('fileName')) {
                $this->session->set_flashdata('error', 'Please input an attachment name!');
                redirect('account/company_attachments');
            } else {
                $attachment->setFileName($this->input->post('fileName'));
                $attachment->setCategory($this->input->post('category'));
                $this->em->persist($attachment);
                $this->em->flush();
                $this->log_manager->add(\models\ActivityAction::COMPANY_ADD_ATTACHMENT, 'Updated Attachment - ' . $attachment->getFileName());
                $this->session->set_flashdata('success', 'Attachment saved succesfully!');
                redirect('account/company_attachments');
            }
        }
        $data['attachment'] = $attachment;
        $data['layout'] = 'account/my_account/edit_attachment';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    function company_proposal_statuses()
    {
        $data = array();
        if ($this->input->post('action')) {
            switch ($this->input->post('action')) {

                case 'add':
                    if ($this->input->post('newStatus')) {

                        // Sales status
                        $salesFlag = $this->input->post('newStatusSold') ? 1 : 0;
                        $prospectFlag = $this->input->post('newStatusProspect') ? 1 : 0;
                        $onHoldFlag = $this->input->post('newStatusOnHold') ? 1 : 0;

                        // Save the status
                        $newStatus = new \models\Status();
                        $newStatus->setText($this->input->post('newStatus'));
                        $newStatus->setCompany($this->account()->getCompany()->getCompanyId());
                        $newStatus->setOrder(999);
                        $newStatus->setSales($salesFlag);
                        $newStatus->setProspect($prospectFlag);
                        $newStatus->setOnHold($onHoldFlag);
                        $newStatus->setVisible(1);
                        $newStatus->setColor($this->input->post('newColor'));
                        $this->em->persist($newStatus);
                        $this->em->flush();

                        //Temp Delete Cache result
                        $this->getQueryCacheRepository()->deleteCompanyStatusCache($this->account()->getCompanyId());
                        // $this->em->getConfiguration()->getResultCacheImpl()->delete( CACHE_COMPANY_STATUSES . $this->account()->getCompanyId());
                        
                        if ($newStatus->getStatusId()) {
                            $this->log_manager->add(\models\ActivityAction::ADD_PROPOSAL_STATUS,
                                "Proposal Status " . $newStatus->getText() . "' created", null, null, $this->account());
                            $this->session->set_flashdata('success',
                                "The new Proposal Status " . $newStatus->getText() . " has been added");
                            redirect('account/company_proposal_statuses');
                        } else {
                            $this->session->set_flashdata('error',
                                'There was a problem saving the new status. Please try again.');
                            redirect('account/company_proposal_statuses');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Please Enter Status Name.');
                        redirect('account/company_proposal_statuses');
                    }
                    break;

                case 'edit':
                    if ($this->input->post('statusText')) {

                        // Sales status
                        $salesFlag = $this->input->post('editStatusSold') ? 1 : 0;
                        $prospectFlag = $this->input->post('editStatusProspect') ? 1 : 0;
                        $onHoldFlag = $this->input->post('editStatusOnHold') ? 1 : 0;

                        $status = $this->em->find('\models\Status', $this->input->post('statusId'));
                        $oldStatusText = $status->getText();
                        /** @var $status \models\Status */

                        if ($status) {
                            $status->setText($this->input->post('statusText'));
                            $status->setSales($salesFlag);
                            $status->setProspect($prospectFlag);
                            $status->setOnHold($onHoldFlag);
                            $status->setColor($this->input->post('editColor'));
                            $this->em->persist($status);
                            $this->em->flush();
                            //Temp Delete Cache result
                            $this->getQueryCacheRepository()->deleteCompanyStatusCache($this->account()->getCompanyId());
                            // $this->em->getConfiguration()->getResultCacheImpl()->delete( CACHE_COMPANY_STATUSES . $this->account()->getCompanyId());
                            
                            $this->log_manager->add('Edited Proposal Status',
                                "Proposal Status of " . $oldStatusText . " edited to " . $status->getText(), null, null,
                                $this->account());

                            // Remove win dates if applicable
                            if (!$status->getSales()) {
                                $this->getProposalRepository()->removeWinDateByStatus($this->account(), $status->getStatusId());
                            }

                            // Feedback to user
                            $this->session->set_flashdata('success', 'Status Updated');
                            redirect('account/company_proposal_statuses');
                        } else {

                        }

                    } else {
                        $this->session->set_flashdata('error', 'Please enter a Status Text');
                        redirect('account/company_proposal_statuses');
                    }
                    break;

                case 'delete':
                    if ($this->input->post('targetStatus')) {

                        $deleteStatus = $this->em->find('\models\Status', $this->input->post('statusId'));
                        $targetStatus = $this->em->find('\models\Status', $this->input->post('targetStatus'));

                        if ($deleteStatus->getStatusId() == $targetStatus->getStatusId()) {
                            $this->session->set_flashdata('error', 'Please select a different status to transfer to');
                            redirect('account/company_proposal_statuses');
                        }

                        if ($deleteStatus && $targetStatus) {
                            // Migrate any proposal to selected status
                            $updated = \models\Proposals::statusUpdate($deleteStatus, $targetStatus);
                            // Hide the old status
                            $deleteStatus->setVisible(0);
                            $this->em->persist($deleteStatus);
                            $this->em->flush();

                            //Temp Delete Cache result
                            $this->getQueryCacheRepository()->deleteCompanyStatusCache($this->account()->getCompanyId());
                            // $this->em->getConfiguration()->getResultCacheImpl()->delete( CACHE_COMPANY_STATUSES . $this->account()->getCompanyId());

                            $this->log_manager->add('Deleted Proposal Status',
                                "Proposal Status of " . $deleteStatus->getText() . ". Proposals updated to " . $targetStatus->getText(),
                                null, null, $this->account());

                            $this->session->set_flashdata('success',
                                '<p>' . $updated . ' proposals updated from "' . $deleteStatus->getText() . '" to "' . $targetStatus->getText() . '".</p><br /><p>Status "' . $deleteStatus->getText() . '" deleted</p>');
                            redirect('account/company_proposal_statuses');
                        } else {
                            $this->session->set_flashdata('error',
                                'There was a problem loading the status. Please try again.');
                            redirect('account/company_proposal_statuses');
                        }
                    } else {
                        $this->session->set_flashdata('error', 'Please enter the status to ');
                        redirect('account/company_proposal_statuses');
                    }
                    break;
            }
        } else {

            if ($this->uri->segment(3) == 'revert') {
                $status = $this->em->find('\models\Status', $this->uri->segment(4));
                /* @var $status \models\Status */

                // Check it loaded
                if (!$status) {
                    $this->session->set_flashdata('error', 'Status does not exist!');
                    redirect('account/company_proposal_statuses');
                }

                // Check company permission
                if ($this->account()->getCompany()->getCompanyId() != $status->getCompany()) {
                    $this->session->set_flashdata('error', 'You do not have permission to edit this status!');
                    redirect('account/company_proposal_statuses');
                }

                // Check user permission
                if ($this->account()->getUserClass() < 2) {
                    $this->session->set_flashdata('error', 'You do not have permission to edit this status!');
                    redirect('account/company_proposal_statuses');
                }

                // Permissions clear, reset to default
                $defaultStatus = $this->em->find('\models\Status', $status->getDefaultStatus());
                $originalText = $status->getText();
                $status->setText($defaultStatus->getText());
                $this->em->persist($status);
                $this->em->flush();

                // Log
                $this->log_manager->add('status_revert',
                    "Proposal Status '" . $originalText . "' reverted to '" . $status->getText() . "'");

                $this->session->set_flashdata('success',
                    "Status '" . $originalText . "' reverted to '" . $status->getText() . "'");
                redirect('account/company_proposal_statuses');
            }
        }

        $this->html->addScript('colorpicker');
        $data['account'] = $this->account();
        $data['layout'] = 'account/my_account/company_statuses';

        // Get the custom statuses for this company
        $data['statuses'] = $this->account()->getStatuses();

        $this->load->view('account/my_account', $data);
    }

    function company_email_templates()
    {
        $data = array();
        $this->load->model('clientEmail');
        $templates = array();
        $templateTypes = $this->clientEmail->getTemplateTypes();
        $data['templateTypes'] = $templateTypes;
        foreach ($templateTypes as $templateType) {
            $templates[$templateType->getTypeId()] = $this->clientEmail->getAllTemplates($this->account()->getCompany()->getCompanyId(),
                $templateType->getTypeId());
        }
        $action = $this->uri->segment(3);
        $data['action'] = $action;
        $data['template'] = null;
        $templateId = $this->uri->segment(4);
        $template = $this->em->find('\models\ClientEmailTemplate',
            $templateId); //general cases, else overwritten within switch clause
        $data['template'] = $template;
        /* @var $template \models\ClientEmailTemplate */
        //for including image start
        $request_body = file_get_contents("php://input");
        $data_content = array();
        parse_str($request_body, $data_content);      
        if (isset($data_content['body'])) {
            // Echo the 'value' field
            $body = $data_content['body'];
        } 
        //for including image end
        switch ($action) {
            case 'edit':
                if (!$template) {
                    $this->session->set_flashdata('error', 'Template not found!');
                    redirect('account/company_email_templates');
                } else {
                    if (!$template->getCompany()) {
                        $this->session->set_flashdata('error',
                            'This template cannot be edited! Please duplicate to create your own version of this template');
                        redirect('account/company_email_templates');
                    }
                    $data['boxTitle'] = 'Edit Email Template - ' . $template->getTemplateName();
                    $data['typeFields'] = $template->getTemplateType()->getFields();
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
                       // echo "<pre>";print_r($body);die;
                        $template->setCompany($this->account()->getCompany());
                        $template->setTemplateName($this->input->post('templateName'));
                        $template->setTemplateDescription($this->input->post('templateDescription'));
                        $template->setTemplateSubject($this->input->post('subject'));
                       // $template->setTemplateBody($this->input->post('body'));
                        $template->setTemplateBody($body);
                        $template->setDefaultTemplate(0);
                        $template->setUpdateAt(Carbon::now());
                        $this->em->persist($template);
                        $this->em->flush();
                        //Delete Template query Cache
                        $this->getQueryCacheRepository()->deleteEmailTemplateListCache($this->account()->getCompanyId(),$template->getTemplateType()->getTypeId());
                        $this->session->set_flashdata('success',
                            "The template '" . $template->getTemplateName() . "' was saved");
                        // Log it
                        $this->log_manager->add(\models\ActivityAction::CLIENT_EMAIL_TEMPLATE_EDIT,
                            "Client Email Template '" . $template->getTemplateName() . "' edited");
                        redirect(site_url('account/company_email_templates/' . $template->getTemplateType()->getTypeId()));
                    }
                }
                break;
            case 'duplicate':
                $data['template'] = null;
                $template = $this->em->find('\models\ClientEmailTemplate', $templateId);
                /* @var $template \models\ClientEmailTemplate */
                if (!$template) {
                    $this->session->set_flashdata('error', 'Template not found!');
                    redirect('account/company_email_templates');
                } else {
                    $data['template'] = $template;
                    $data['boxTitle'] = 'Duplicate Email Template - ' . $template->getTemplateName();
                    $data['typeFields'] = $template->getTemplateType()->getFields();
                    $templateType = $template->getTemplateType();
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
                        // We're duplicating, so use a new template
                        $template = new \models\ClientEmailTemplate();
                        $template->setTemplateType($templateType);
                        $template->setCompany($this->account()->getCompany());
                        $template->setTemplateName($this->input->post('templateName'));
                        $template->setTemplateDescription($this->input->post('templateDescription'));
                        $template->setTemplateSubject($this->input->post('subject'));
                        $template->setTemplateBody($body);
                        $template->setDefaultTemplate(0);
                        $template->setUpdateAt(Carbon::now());
                        $template->setOrder(999);
                        $this->em->persist($template);
                        $this->em->flush();
                                                //Delete Template query Cache
                                                $this->getQueryCacheRepository()->deleteEmailTemplateListCache($this->account()->getCompanyId(),$template->getTemplateType()->getTypeId());
                        $this->session->set_flashdata('success',
                            "The template '" . $template->getTemplateName() . "' was saved");
                        // Log it
                        $this->log_manager->add(\models\ActivityAction::CLIENT_EMAIL_TEMPLATE_EDIT,
                            "Client Email Template '" . $template->getTemplateName() . "' edited");
                        redirect(site_url('account/company_email_templates/' . $template->getTemplateType()->getTypeId()));
                    }
                }
                break;
            case 'add':
                $templateTypeId = $this->uri->segment(4);
                $templateType = $this->em->find('\models\ClientEmailTemplateType', $templateTypeId);
                // Check type was loaded
                if ($templateType) {
                    $data['typeFields'] = $templateType->getFields();
                } else {
                    $this->session->set_flashdata('error', 'Template Type not recognized. Please try again.');
                    redirect(site_url('account/company_email_templates'));
                }
                $data['template'] = new \models\ClientEmailTemplate();
                $data['template']->setTemplateType($templateType); //so we don't have errors in the form... using this for the back button
                $data['boxTitle'] = 'Add New Email Template';
 
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
                        $template = new \models\ClientEmailTemplate();
                        $template->setTemplateType($templateType);
                        $template->setCompany($this->account()->getCompany());
                        $template->setTemplateName($this->input->post('templateName'));
                        $template->setTemplateDescription($this->input->post('templateDescription'));
                        $template->setTemplateSubject($this->input->post('subject'));
                        $template->setTemplateBody($body);
                        $template->setDefaultTemplate(0);
                        $template->setUpdateAt(Carbon::now());
                        $template->setOrder(999);
                        $this->em->persist($template);
                        $this->em->flush();
                        //Delete Template query Cache
                        $this->getQueryCacheRepository()->deleteEmailTemplateListCache($this->account()->getCompanyId(),$template->getTemplateType()->getTypeId());
                        $this->session->set_flashdata('success',
                            "The template '" . $template->getTemplateName() . "' was saved");
                        // Log it
                        $this->log_manager->add(\models\ActivityAction::CLIENT_EMAIL_TEMPLATE_ADD,
                            "Client Email Template '" . $template->getTemplateName() . "' added");
                        redirect(site_url('account/company_email_templates/' . $template->getTemplateType()->getTypeId()));
                    }
                }
                break;
            case 'delete':
                if (!$template) {
                    $this->session->set_flashdata('error', 'Template not found!');
                    redirect('account/company_email_templates');
                }
                //prevent user to delete admin templates
                if (!$template->getCompany()) {
                    $this->session->set_flashdata('error', 'You are not allowed to delete the standard templates!');
                    redirect('account/company_email_templates/' . $template->getTemplateType()->getTypeId());
                }
                // Don't disable the last enabled template
                $typeEnabledCount = $this->clientEmail->countEnabledTemplatesOfType($this->account()->getCompany()->getCompanyId(),
                    $template->getTemplateType()->getTypeId());
                if ($typeEnabledCount < 2) {
                    $this->session->set_flashdata('error',
                        '<p>Template not deleted.</p><br /><p>You must have at least one enabled template for this template type!</p>');
                    redirect('account/company_email_templates/' . $template->getTemplateType()->getTypeId());
                }
                $redirectType = $template->getTemplateType()->getTypeId();
                //Delete Template query Cache
                $this->getQueryCacheRepository()->deleteEmailTemplateListCache($this->account()->getCompanyId(),$template->getTemplateType()->getTypeId());

                $this->clientEmail->delete($this->account()->getCompany()->getCompanyId(), $template->getTemplateId());
                $this->log_manager->add(\models\ActivityAction::CLIENT_EMAIL_TEMPLATE_DELETE,
                    "Email Template '" . $template->getTemplateName() . "' deleted", null, null, $this->account());
                $this->session->set_flashdata('success', 'Email Template deleted');
                redirect('account/company_email_templates/' . $redirectType);
                break;
            case 'disable':
                if (!$template) {
                    $this->session->set_flashdata('error', 'Template not found!');
                    redirect('account/company_email_templates');
                }
                if ($template->getDefaultTemplate()) {
                    $this->session->set_flashdata('error', 'This template cannot be diabled!');
                    redirect('account/company_email_templates');
                }
                // Don't disable the last enabled template
                $typeEnabledCount = $this->clientEmail->countEnabledTemplatesOfType($this->account()->getCompany()->getCompanyId(),
                    $template->getTemplateType()->getTypeId());
                if ($typeEnabledCount < 2) {
                    $this->session->set_flashdata('error',
                        '<p>Template not disabled.</p><br /><p>You must have at least one enabled template for this template type!</p>');
                    redirect('account/company_email_templates/' . $template->getTemplateType()->getTypeId());
                }
                // Save the disabling
                $this->clientEmail->disable($this->account()->getCompany()->getCompanyId(), $template->getTemplateId());
                        //Delete Template query Cache
                        $this->getQueryCacheRepository()->deleteEmailTemplateListCache($this->account()->getCompanyId(),$template->getTemplateType()->getTypeId());
                // Log it
                $this->log_manager->add(\models\ActivityAction::CLIENT_EMAIL_TEMPLATE_DISABLE,
                    "Client Email Template '" . $template->getTemplateName() . "' disabled");
                $this->session->set_flashdata('success', 'Template disabled');
                redirect('account/company_email_templates/' . $template->getTemplateType()->getTypeId());
                break;
            case 'enable':
                if (!$template) {
                    $this->session->set_flashdata('error', 'Template not found!');
                    redirect('account/company_email_templates');
                }
                //Delete Template query Cache
                $this->getQueryCacheRepository()->deleteEmailTemplateListCache($this->account()->getCompanyId(),$template->getTemplateType()->getTypeId());
                $this->clientEmail->enable($this->account()->getCompany()->getCompanyId(), $template->getTemplateId());
                // Log it
                $this->log_manager->add(\models\ActivityAction::CLIENT_EMAIL_TEMPLATE_ENABLE,
                    "Client Email Template '" . $template->getTemplateName() . "' enabled");
                $this->session->set_flashdata('success', 'Template enabled');
                redirect('account/company_email_templates/' . $template->getTemplateType()->getTypeId());
        }
        $data['proposalType'] = $this->em->find('\models\ClientEmailTemplateType', 1);
        $data['account'] = $this->account();
        $data['layout'] = 'account/my_account/company_email_templates';
        $data['templates'] = $templates;
        $data['templateTypes'] = $templateTypes;
        $data['proposalCount'] = $this->clientEmail->countEnabledTemplatesOfType($this->account()->getCompany()->getCompanyId(),
            1);
        $this->html->addScript('dataTables');
        $this->html->addScript('ckeditor4');
        $this->load->view('account/my_account', $data);
    }

    function delete_account()
    {
        if (!$this->account()->isAdministrator()) {
            $this->session->set_flashdata('error', 'Only Company Administrators can do this!');
            redirect('account/my_account');
        }
        $account = $this->em->find('models\Accounts', $this->uri->segment(3));
        if (!$account) {
            $this->session->set_flashdata('error', 'User Not found!');
            redirect('account/company_users');
        }
        if ($this->account()->getCompany() != $account->getCompany()) {
            $this->session->set_flashdata('error', 'You are not allowed to delete other companies users!');
            redirect('account/company_users');
        }
        if ($this->account()->getAccountId() == $this->uri->segment(3)) {
            $this->session->set_flashdata('error', 'You are not allowed to delete your own user!');
            redirect('account/company_users');
        }
        $newOwner = $this->em->find('models\Accounts', $this->uri->segment(4));
        if (!$newOwner) {
            $this->session->set_flashdata('error', 'Invalid user set for new owner!');
            redirect('account/company_users');
        }
        //change owner of the accounts
        /*
        $clients = $account->getClients();
        $buffer = 10;
        $count = 0;
        foreach ($clients as $client) {
            $count++;
            $client->setAccount($newOwner);
            $this->em->persist($client);
            if ($count % $buffer == 0) {
                $this->em->flush();
                $this->em->clear();
            }
        }
        */
        // Reassign Contacts
        $this->db->query("UPDATE clients SET account = " . $newOwner->getAccountId() . " WHERE account = " . $account->getAccountId());
        // Reassign Leads
        $this->db->query("UPDATE leads SET account = " . $newOwner->getAccountId() . " WHERE account = " . $account->getAccountId());
        // Reassign Proposals
        $this->db->query("UPDATE proposals SET owner = " . $newOwner->getAccountId() . " WHERE owner = " . $account->getAccountId());
        // Reassign Accounts
        $this->db->query("UPDATE client_companies SET owner_user = " . $newOwner->getAccountId() . " WHERE owner_user = " . $account->getAccountId());
        // Reassign saved reports
        $this->db->query("UPDATE saved_reports SET account = " . $newOwner->getAccountId() . " WHERE account = " . $account->getAccountId());


        // Switch lead notifications if needed
        $notificationRepo = $this->getLeadNotificationsRepository();
        $notificationSettings = $notificationRepo->getLeadNotificationSettings($this->account()->getCompany()->getCompanyId());
        $notificationAccount = @$notificationSettings->account;

        if ($notificationAccount) {

            // Check to see if this use is the assigned recipient
            if ($account->getAccountId() == $notificationAccount) {
                // Switch it over to the company admin if so
                $notificationData = [
                    'enabled' => $notificationSettings->enabled,
                    'instant' => $notificationSettings->instant,
                    'account' => $this->account()->getCompany()->getAdministrator()->getAccountId(),
                    'company' => $notificationSettings->company,
                    'notificationIntervals' => $notificationSettings->notificationIntervals,
                ];
                $this->db->delete('lead_notification_settings',
                    array('company' => $this->account()->getCompany()->getCompanyId()));
                $this->db->insert('lead_notification_settings', $notificationData);
                $logMessage = 'Updated Lead Notification Settings Automatically Updated: Recipient changed to ' . $this->account()->getCompany()->getAdministrator()->getEmail();
                $this->getLogRepository()->add([
                    'action' => 'updated_lead_notification_settings',
                    'details' => $logMessage,
                    'account' => $this->account()->getAccountId()
                ]);
            }
        }

        $this->em->flush();
        $this->em->clear();
        $account = $this->em->find('models\Accounts', $this->uri->segment(3));
        $this->log_manager->add(\models\ActivityAction::COMPANY_DELETE_USER,
            'User #' . $account->getAccountId() . ' - ' . $account->getFirstName() . ' ' . $account->getLastName() . ' deleted!');
        $account = $this->em->merge($account);
        $this->em->remove($account);
        $this->em->flush();
        //Delete user query Cache
        $this->getQueryCacheRepository()->deleteCompanyUserAllCache($this->account()->getCompanyId());
        
        // Update the company subscription
        if (($this->account()->getCompany()->isActive()) && $this->account()->getCompanyId() != 8) {
            $cr = $this->getCompanyRepository();
            $cr->updateSubscriptions($this->account()->getCompany());
        }
        // Feedback
        $this->session->set_flashdata('success', 'User deleted!');
        redirect('account/company_users');
    }

    function reassign_clients()
    {
        $reassignFrom = $this->input->post('reassignFrom');
        $reassignTo = $this->input->post('reassignUser');

        if (!$this->account()->isAdministrator()) {
            $this->session->set_flashdata('error', 'Only Company Administrators can do this!');
            redirect('account/my_account');
        }

        $company = $this->account()->getCompany();
        if (!$company) {
            $this->session->set_flashdata('error', 'An error has occurred. Please try again later.!');
            redirect('account/my_account');
        }

        $fromAccount = $this->em->find('models\Accounts', $reassignFrom);
        if (!$fromAccount) {
            $this->session->set_flashdata('error', 'Account Not found!');
            redirect('account/my_account');
        }

        $account = $this->em->find('models\Accounts', $reassignTo);
        if (!$account) {
            $this->session->set_flashdata('error', 'Account Not found!');
            redirect('account/my_account');
        }

        // Reassign Contacts
        $this->db->query("UPDATE clients SET account = " . $reassignTo . " WHERE account = " . $reassignFrom);
        // Reassign Proposals
        $this->db->query("UPDATE proposals SET owner = " . $reassignTo . " WHERE owner = " . $reassignFrom);
        // Reassign Accounts
        $this->db->query("UPDATE client_companies SET owner_user = " . $reassignTo . " WHERE owner_user = " . $reassignFrom);

        $this->log_manager->add(\models\ActivityAction::PROPOSAL_REASSIGN,
            'Accounts, Contacts and Proposals reassigned from ' . $fromAccount->getFullName() . ' to ' . $account->getFullName());

        $this->session->set_flashdata('success', 'Accounts, Contacts &amp; Proposals reassigned successfully!');
        redirect('account/company_users');
    }

    function super_reassign_clients()
    {
        $reassignFrom = $this->input->post('reassignFrom');
        $reassignTo = $this->input->post('reassignUser');

        if (!$this->account()->isAdministrator()) {
            $this->session->set_flashdata('error', 'Only Company Administrators can do this!');
            redirect('account/super_company_users');
        }

        $company = $this->account()->getCompany();
        if (!$company) {
            $this->session->set_flashdata('error', 'An error has occurred. Please try again later.!');
            redirect('account/super_company_users');
        }

        $fromAccount = $this->em->find('models\Accounts', $reassignFrom);
        if (!$fromAccount) {
            $this->session->set_flashdata('error', 'Account Not found!');
            redirect('account/super_company_users');
        }

        $account = $this->em->find('models\Accounts', $reassignTo);
        if (!$account) {
            $this->session->set_flashdata('error', 'Account Not found!');
            redirect('account/super_company_users');
        }

        // Reassign Contacts
        $this->db->query("UPDATE clients SET account = " . $reassignTo . " WHERE account = " . $reassignFrom);
        // Reassign Proposals
        $this->db->query("UPDATE proposals SET owner = " . $reassignTo . " WHERE owner = " . $reassignFrom);
        // Reassign Accounts
        $this->db->query("UPDATE client_companies SET owner_user = " . $reassignTo . " WHERE owner_user = " . $reassignFrom);

        $this->log_manager->add(\models\ActivityAction::PROPOSAL_REASSIGN,
            'Accounts, Contacts and Proposals reassigned from ' . $fromAccount->getFullName() . ' to ' . $account->getFullName());

        $this->session->set_flashdata('success', 'Accounts, Contacts &amp; Proposals reassigned successfully!');
        redirect('account/super_company_users');
    }

    function edit_company()
    {
        if (!$this->account()->isAdministrator()) {
            $this->session->set_flashdata('error', 'You are not allowed to view this page!');
            redirect('account/my_account');
        }
        $company = $this->account()->getCompany();
        $this->load->library('form_validation');
        if ($this->input->post('updateCompany')) {
            $this->form_validation->set_rules('companyName', 'Company Name', 'required');
            $this->form_validation->set_rules('companyAddress', 'Company Address', 'required');
            $this->form_validation->set_rules('companyPhone', 'Company Phone', 'required');
            $this->form_validation->set_rules('companyCity', 'Company City', 'required');
//            $this->form_validation->set_rules('companyCountry', 'Company Country', 'required');
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
                $company->setCompanyZip($this->input->post('companyZip'));
                $company->setAlternatePhone($this->input->post('alternatePhone'));
                $company->setAboutCompany($this->input->post('aboutCompany'));
                $company->setContractCopy($this->input->post('contractCopy'));
                $company->setStandardLayoutIntro($this->input->post('standardLayoutIntro'));
                $company->setPaymentTermText($this->input->post('paymentTermText'));
                $company->setPaymentTerm($this->input->post('paymentTerm'));
                $company->setPdfHeader($this->input->post('pdfHeader'));
                //work order stuff
                if ($this->input->post('woEnabled')) {
                    $woEnabled = 1;
                } else {
                    $woEnabled = 0;
                }
                $company->setWoEnabled($woEnabled);
                $company->setWoAddress($this->input->post('woAddress'));
                $company->setWoCity($this->input->post('woCity'));
                $company->setWoState($this->input->post('woState'));
                $company->setWoZip($this->input->post('woZip'));
                $this->em->persist($company);
                $this->em->flush();
                $this->session->set_flashdata('success', 'Company information updated succesfully!');
                $this->log_manager->add(\models\ActivityAction::UPDATE_COMPANY, 'Company information updated.');
                $this->getCompanyRepository()->flagProposalsForRebuild($company->getCompanyId());
                redirect('account/my_account');
            }
        }
        $acceptedImages = array('image/jpeg', 'image/pjpeg', 'image/jpg', 'image/png', 'image/x-png');
        if ($this->input->post('changeLogo')) {
            if ($_FILES['clientLogo']['error'] === 0) {
                if (!in_array($_FILES['clientLogo']['type'], $acceptedImages)) {
                    $this->session->set_flashdata('error', 'Only JPEG and PNG format is accepted!');
                    redirect('account/edit_company#logo');
                } else {
                    //check if file size is larger than 500KB
                    if ($_FILES['clientLogo']['size'] > 512000) {
                        $this->session->set_flashdata('error',
                            'File size exceeds 500KB! You are not allowed to upload files larger than that.');
                        redirect('account/edit_company#logo');
                    } else {
                        $path = UPLOADPATH . '/clients/logos/';
                        $filename = 'logo-' . $company->getCompanyId() . '.';
                        switch ($_FILES['clientLogo']['type']) {
                            case 'image/jpeg':
                                $filename .= 'jpg';
                                break;
                            case 'image/jpg':
                                $filename .= 'jpg';
                                break;
                            case 'image/pjepg':
                                $filename .= 'jpg';
                                break;
                            case 'image/png':
                                $filename .= 'jpg';
                                break;
                        }
                        $imagepath = $path . $filename;
                        if (file_exists($imagepath)) {
                            unlink($imagepath);
                        }
                        if (in_array($_FILES['clientLogo']['type'], array('image/png', 'image/x-png'))) {
                            $sizes = getimagesize($_FILES['clientLogo']['tmp_name']);
                            $w = $sizes[0];
                            $h = $sizes[1];
                            $white_bg = imagecreatetruecolor($w, $h);
                            $white = imagecolorallocate($white_bg, 255, 255, 255);
                            imagefill($white_bg, 0, 0, $white);
                            $im = imagecreatefrompng($_FILES['clientLogo']['tmp_name']);
                            imagealphablending($im, true);
                            imagealphablending($white_bg, true);
                            $out = imagecreatetruecolor($w, $h);
                            imagecopyresampled($out, $white_bg, 0, 0, 0, 0, $w, $h, $w, $h);
                            imagecopyresampled($out, $im, 0, 0, 0, 0, $w, $h, $w, $h);
                            imagejpeg($out, $imagepath);
                        } else {
                            move_uploaded_file($_FILES['clientLogo']['tmp_name'], $imagepath);
                        }
                        $company->setCompanyLogo($filename);
                        $this->em->persist($company);
                        $this->em->flush();
                        $this->session->set_flashdata('success', 'Logo updated succesfully!.');
                        $this->getCompanyRepository()->flagProposalsForRebuild($company->getCompanyId());
                        redirect('account/my_account');
                    }
                }
            } else {
                $this->session->set_flashdata('error',
                    'Errors have occured during the upload. Please check your file format or size of file and try again a bit later.');
                redirect('account/edit_company');
            }
        }
        $data['account'] = $this->account();
        $data['company'] = $this->account()->getCompany();
        $this->load->view('account/edit_company', $data);
    }

    function resetCompanyProposals($redirect = '')
    {
        $props = $this->em->createQuery('SELECT p, c, cmp FROM models\Proposals p INNER JOIN p.client c INNER JOIN c.company cmp WHERE (p.rebuildFlag = 0) AND (cmp.companyId = c.company) AND (cmp.companyId = ' . $this->account()->getCompany()->getCompanyId() . ')')->getResult();
        foreach ($props as $proposal) {
            $proposal->setRebuildFlag(1, false, false);
            $this->em->persist($proposal);
        }
        $this->em->flush();
        $this->em->clear();
        if ($this->session->flashdata('error')) {
            $this->session->set_flashdata('error', $this->session->flashdata('error'));
        }
        if ($this->session->flashdata('success')) {
            $this->session->set_flashdata('success', $this->session->flashdata('success'));
        }
        if ($redirect == '') {
            redirect('account/my_account');
        } else {
//            redirect('account/' . $redirect);
        }
    }

    function resetProposals($company)
    {
        $props = $this->em->createQuery('SELECT p, c, cmp FROM models\Proposals p INNER JOIN p.client c INNER JOIN c.company cmp WHERE (p.rebuildFlag = 0) AND (cmp.companyId = c.company) AND (cmp.companyId = ' . $company . ')')->getResult();
        foreach ($props as $proposal) {
            $proposal->setRebuildFlag(1, false, false);
            $this->em->persist($proposal);
        }
        $this->em->flush();
    }

    function export_proposals()
    {
        if ($this->account()->isAdministrator() || ($this->account()->getFullAccess() == 'yes')) {
            $proposals = $this->account()->getCompany()->getProposals();
        } else {
            $this->session->set_flashdata('error', 'You are not allowed to view this page!');
            redirect('account/my_account');
        }
        $this->log_manager->add('export_proposals', 'Proposals exported');
        header('Content-Type: text/csv');
        header("Content-Type: application/force-download");
        header("Content-Disposition: attachment; filename=proposals.csv;");
        echo "Date Issued,Project Name,Contact,Price,Status\n";
        foreach ($proposals as $proposal) {
            echo str_replace(',', ' ', $proposal->getCreated()) . ',' .
                str_replace(',', ' ', $proposal->getProjectName()) . ',' .
                str_replace(',', ' ',
                    $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName() . ' (' . $proposal->getClient()->getCompanyName() . ')') . ',' .
                str_replace(',', ' ', '$' . $proposal->getTotalPrice()) . ',' .
                str_replace(',', '', $proposal->getStatus()) .
                "\n";
        }
    }

    function dummyPost()
    {
        $data = array();
        if (!$this->session->userdata('logged')) {
            $data['status'] = 0;
            

        }else{
            $data['status'] = 1;
            $data['value'] =  $this->input->post('value');
        }

        echo json_encode($data);
    }

    function edit_attachment()
    {
        $data = array();
        if (!$this->account()->isAdministrator()) {
            $this->session->set_flashdata('error', 'Only Company Administrators can view this page!');
            redirect('account/my_account');
        }
        $attachment = $this->em->find('models\Attatchments', $this->uri->segment(3));
        if (!$attachment) {
            $this->session->set_flashdata('error', 'Inexistent attachment!');
            redirect('account/company_attachments');
        }

        //Allow files array
        $acceptedFiles = array(
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'png' => 'image/png',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'doc' => 'application/msword',
            'pdf' => 'application/pdf',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet'
        );
       
        if ($this->input->post('save')) {
            if (!$this->input->post('fileName')) {
                $this->session->set_flashdata('error', 'Please input an attachment name!');
                redirect('account/edit_attachment/'.$this->uri->segment(3));
            } else {


        //check uploaded data
        if ($_FILES['file']['size']) {

            //echo 'test1';die;
           
            //check file type
            if ( !in_array($_FILES['file']['type'], $acceptedFiles)) {
                $error = 'File is required, and must be one of the following types: Images, Text, PDF, Documents!<br>';
                $this->session->set_flashdata('error', $error);
                redirect('account/edit_attachment/'.$this->uri->segment(3));
            }
            
                $upload_dir = ATTACHMENTPATH . '/' . $this->account()->getCompany()->getCompanyId();
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir, 0777, true);
                }
                $fileName = $_FILES['file']['name'];
                while (file_exists($upload_dir . '/' . $fileName)) {
                    $fileName = str_replace('.', '_' . rand(0, 9) . '.', $fileName);
                }
                move_uploaded_file($_FILES['file']['tmp_name'], $upload_dir . '/' . $fileName);
               
                $attachment->setFilePath($fileName);
 
            
        }

                $attachment->setFileName($this->input->post('fileName'));
                $attachment->setCategory($this->input->post('category'));
                $include = ($this->input->post('include')) ? 1 : 0;
                $attachment->setInclude($include);
                $this->em->persist($attachment);
                $this->em->flush();

                $this->getCompanyRepository()->flagProposalsForRebuild($this->account()->getCompany()->getCompanyId());

                $this->session->set_flashdata('success', 'Attachment saved succesfully!');
                redirect('account/company_attachments');
            }
        }
        $data['attachment'] = $attachment;
        $data['account'] = $this->account();
        $data['layout'] = 'account/my_account/edit_attachment';
        $this->load->view('account/my_account', $data);
    }

    function attatchments()
    {
        //check privileges
        if (!$this->account()->isAdministrator()) {
            $this->session->set_flashdata('error', 'Only Company Administrators can view this page!');
            redirect('account/my_account');
        }
        if (($this->uri->segment(3) == 'delete') && ($this->uri->segment(4))) {
            $delete_attachment = $this->em->find('models\Attatchments', $this->uri->segment(4));
            if ($delete_attachment) {
                $this->log_manager->add(\models\ActivityAction::COMPANY_DELETE_ATTACHMENT, 'Deleted Attachment ' . $delete_attachment->getFileName());
                $delete_attachment = $this->em->merge($delete_attachment);
                $this->em->remove($delete_attachment);
                $this->em->flush();
                $this->session->set_flashdata('success', 'Attachment deleted!');
                redirect('account/company_attachments');
            }
        }
        $data = array();
        //check posted data
        $acceptedFiles = array(
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'png' => 'image/png',
            'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'doc' => 'application/msword',
            'pdf' => 'application/pdf',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet'
        );
        //check uploaded data
        if ($this->input->post('upload')) {
            $error = '';
            //check file name
            if (!$this->input->post('fileName')) {
                $error .= 'You must input a file name!';
            }
            //check file type
            if (($_FILES['file']['error']) || (!in_array($_FILES['file']['type'], $acceptedFiles))) {
                $error .= 'File is required, and must be one of the following types: Images, Text, PDF, Documents!<br>';
            }
            if ($error) {
                $this->session->set_flashdata('error', $error);
                redirect('account/attatchments');
            } else {
                $upload_dir = ATTACHMENTPATH . '/' . $this->account()->getCompany()->getCompanyId();
                if (!is_dir($upload_dir)) {
                    mkdir($upload_dir);
                }
                $fileName = $_FILES['file']['name'];
                while (file_exists($upload_dir . '/' . $fileName)) {
                    $fileName = str_replace('.', '_' . rand(0, 9) . '.', $fileName);
                }
                move_uploaded_file($_FILES['file']['tmp_name'], $upload_dir . '/' . $fileName);
                $attachment = new \models\Attatchments();
                $attachment->setFileName($this->input->post('fileName'));
                $attachment->setCategory($this->input->post('category'));
                $attachment->setCompany($this->account()->getCompany());
                $attachment->setFilePath($fileName);
                $this->em->persist($attachment);
                $this->em->flush();
                $this->log_manager->add(\models\ActivityAction::COMPANY_ADD_ATTACHMENT, 'Added Attachment ' . $attachment->getFileName());
                $this->session->set_flashdata('success', 'File Uploaded succesfully!');
                redirect('account/my_account');
            }
        }
        $data['account'] = $this->account();
        //load view
        $this->load->view('account/attatchments', $data);
    }

    function payment_history()
    {
        $query = $this->em->createQuery('SELECT p FROM models\Payments p WHERE p.companyId=' . $this->account()->getCompany()->getCompanyId() . ' ORDER BY p.added DESC');
        $data['payments'] = $query->getResult();
        $this->load->view('account/payments', $data);
    }

    function checkSchema()
    {
        $validator = new SchemaValidator($this->em);
        $errors = $validator->validateMapping();
        echo '<pre>';
        print_r($errors);
        echo '</pre>';
    }

    function blank_page()
    {
    }

    function upload_data()
    {
         ini_set('post_max_size', '5G');

        $data = array();
        $data['step'] = 1;
        //check if a file has been uploaded
        $fieldsCount = 0;
        $fieldsHeadings = array();
        if ($this->input->post('fileUpload')) {

             $extension = pathinfo($_FILES['csv']['name'], PATHINFO_EXTENSION);
 
            if ($extension !== 'csv') {
 
                $this->session->set_flashdata('error', 'Upload must be a CSV file!');
                redirectPreviousPage();
                return;
            } 

            if ($_FILES['csv']['error'] == 0) {
                $fileName = UPLOADPATH . '/' . time() . $_FILES['csv']['name'];
                $fileName = str_replace(' ', '_', $fileName);
                move_uploaded_file($_FILES['csv']['tmp_name'], $fileName);

                // User new CSV Reader
                $reader = Reader::createFromPath($fileName);
                $fieldsHeadings = $reader->fetchOne();


                //NEW END
                $data['step'] = 2;
                $data['fieldsCount'] = $fieldsCount;
                $data['fieldsHeadings'] = $fieldsHeadings;
                $data['fileName'] = $fileName;
                $data['account'] = $this->account();

              
            } 
          }
 
        if ($this->input->post('pickOwners')) {
            $data['step'] = 3;
            $fileName = $this->input->post('csvFile');
            $data['fileName'] = $fileName;
            $mappings = $this->input->post('mappings');
            $data['mappings'] = $mappings;
            $rows = [];

            // New CSV Reader
            $reader = Reader::createFromPath($fileName);
            $rowIterator = $reader->fetch();

            foreach($rowIterator as $row) {

                $empty = true;
                $duplicate = false;

                foreach ($row as $rowField) {
                    if ($rowField) {
                        $empty = false;
                        continue;
                    }
                }

                if (!$empty) {
                    $rows[] = $row;
                }

            }
            $accounts = array();
            $accs = $this->account()->getCompany()->getAccounts();
            foreach ($accs as $acc) {
                $accounts[$acc->getAccountId()] = $acc->getFullName();
            }
            $data['em'] = $this->em;
            //            $data['companyId'] = $this->account()->getCompany()->getCompanyId();
            $data['accounts'] = $accounts;
            $fieldsValues = array();
            $this->load->library('DataSource');
            $csv = new DataSource;
            $csv->load($fileName);
            $rows = $csv->connect();
            $handle = fopen($fileName, "r");
            $k = 0;
            foreach ($rows as $row) {
                 $email = ($mappings['email']) ? @$row[$mappings['email']] : '';
                $searchData = array(
                    'email' => trim($email),
                    'company' => $this->account()->getCompany()->getCompanyId()
                );

                $check = 0;

                if (strlen($email)) {
                    switch ($this->uri->segment(3)) {
                        case 'clients':
                            $check = $this->em->getRepository('models\Clients')->findOneBy($searchData);
                            break;
                        case 'prospects':
                            $check = $this->em->getRepository('models\Prospects')->findOneBy($searchData);
                            break;
                    }
                    if (@$check) {
                        $row['isPossibleDuplicate'] = 1;
                    }
                }

                $fieldsValues[] = $row;
            }
            $data['fieldsValues'] = $fieldsValues;
 //            print_r($fieldsValues);
        }


        if ($this->input->post('addData')) {
            $mappings = $this->input->post('mappings');

            $fileName = $this->input->post('csvFile');
            $fileContents = file_get_contents($fileName); //old
            $rows = explode("\n", $fileContents); //old

            // New CSV Reader
            $reader = Reader::createFromPath($fileName);
            $rows = $reader->fetch();
            $this->load->library('DataSource');
            $csv = new DataSource;
            $csv->load($fileName);
            $rows = $csv->connect();

            $k = 0;
            $the_raw_data = array();
            if(is_array($rows)){
                foreach ($rows as $row) {
                    $the_raw_data[] = $row;
                }
            }
            $the_data = array();
            $add = $this->input->post('add');
            if (is_array($add)) {
                foreach ($add as $rowcount => $value) {
                    $the_data[$rowcount] = $the_raw_data[$rowcount];
                }

             }

             //get the respective accounts
            $the_accounts = array();
            $owners = $this->input->post('owner');
            foreach ($owners as $owner) {
                if (!isset($the_accounts[$owner])) {
                    $the_accounts[$owner] = $this->em->find('models\Accounts', $owner);
                }
            }
            //start adding data to the database
            $add = $this->input->post('add');
            if (!is_array($add)) {
                $add = array();
            }
            $batchSize = 20;
            $count = 0;
            $objects = array();
            $residentialAccount = $this->account()->getCompany()->findResidentialAccount();
            $companyId = $this->account()->getCompanyId();
            $excludedRows = [];
            $addedRowCount = 0;
          
            foreach ($add as $key => $on) {

                $count++;

                switch ($this->uri->segment(3)) {
                    case 'clients':
                        $count++;
                        $logId = \models\ActivityAction::UPLOAD_CONTACT;
                      
                        // We're going to need the user account
                        if (isset($the_accounts[$owners[$key]])) {
                            $assignedAccount = $the_accounts[$owners[$key]];
                        } else {
                            $assignedAccount = $this->account();
                        }

                        // Handle Client Account
                        $companyName = (isset($mappings['company'])) ? trim(@$the_data[$key][$mappings['company']]) : '';

                        // Use residential if it says so, or if there's no company name
                        if (!$companyName || strtolower($companyName) == 'residential') {
                            $clientAccount = $residentialAccount;
                        } else {
                            // Otherwise, lookup/create based on company name
                          $clientAccount = $this->account()->getCompany()->findClientAccountByName($companyName, $assignedAccount);
                        //  $clientAccount = $residentialAccount;

                        }

                        // Now Save the client
                        $client = new models\Clients();
                        $firstName = ($mappings['firstName']) ? @$the_data[$key][$mappings['firstName']] : '';
                         //add for clean firstName
                        // Remove special characters using regex
                        $firstName = preg_replace('/[^\w\s]/u', '', $firstName);
                        // Remove extra spaces 
                        $firstName = preg_replace('/\s+/', ' ', $firstName);
                        // Trim the First Name
                        $firstName = trim($firstName);
                        //add for firstName clean
                        $client->setFirstName($firstName);
                        $lastName = ($mappings['lastName']) ? @$the_data[$key][$mappings['lastName']] : '';
                        $lastName = $this->cleanString($lastName);

                        $client->setLastName($lastName);
                        $companyName = (isset($mappings['company'])) ? trim(@$the_data[$key][$mappings['company']]) : 'residential';
                        $companyName = $this->cleanString($companyName);  
 
                         //check balnk data
                        $client->setCompanyName($companyName);
                        $businessPhone2 = ($mappings['businessPhone']) ? @$the_data[$key][$mappings['businessPhone']] : '';
                        // Assuming $csvData contains the CSV data for the businessPhone column
                        $phoneNumbers = explode('|', $businessPhone2);

                        // Normalize and insert each phone number into the database
                        foreach ($phoneNumbers as $phoneNumber) {
                        $normalizedPhoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber); // Remove non-numeric characters
                        // Insert $normalizedPhoneNumber into the database using your preferred method (e.g., prepared statements)
                        $businessPhone = preg_replace('/(\d{3})(\d{3})(\d{4})/', '$1-$2-$3', $normalizedPhoneNumber);

                        }

                        $client->setBusinessPhone($businessPhone);
                        $email = ($mappings['email']) ? @$the_data[$key][$mappings['email']] : '';
                        // Explode the email addresses by the vertical bar (|)
                        $emails = explode('|', $email);
                        // Iterate through each email address
                        foreach ($emails as &$email) {
                        // Remove leading and trailing whitespace
                        $email = trim($email);
                        // Remove any special characters that are not allowed in email addresses
                        $email = filter_var($email, FILTER_SANITIZE_EMAIL);
                        // Optionally, you can perform additional validation on the email address here
                        }
                        // Implode the sanitized email addresses back into a single string, separated by a comma
                        $sanitizedEmail = implode(', ', $emails);
                        $client->setEmail($email);
                        $cellPhone = ($mappings['cellPhone']) ? @$the_data[$key][$mappings['cellPhone']] : '';
                        $client->setCellPhone($cellPhone);
                        $fax = ($mappings['fax']) ? @$the_data[$key][$mappings['fax']] : '';
                        $client->setFax($fax);
                        $address = ($mappings['address']) ? trim(@$the_data[$key][$mappings['address']]) : '';
                        //add for clean address
                        // Remove special characters using regex
                        $address = $this->cleanString($address);
                        $client->setAddress($address);
                        $city = ($mappings['city']) ? @$the_data[$key][$mappings['city']] : '';
                        $client->setCity($city);
                        $zip = ($mappings['zip']) ? @$the_data[$key][$mappings['zip']] : '';
                        $client->setZip($zip);
                        $country = 'USA';
                        $client->setCountry($country);
                        $title = ($mappings['title']) ? @$the_data[$key][$mappings['title']] : '';
                        $client->setTitle($title);
                        $state = ($mappings['state']) ? @$the_data[$key][$mappings['state']] : '';
                        $client->setState($state);
                        $website = ($mappings['website']) ? @$the_data[$key][$mappings['website']] : '';
                        $client->setWebsite($website);
                        // Set Owner Account and Company
                        $client->setAccount($assignedAccount);
                        $client->setCompany($this->account()->getCompany());
                        // Set client account
                        $client->setClientAccount($clientAccount);
                        $objects[$key] = $client;
                        $this->em->persist($objects[$key]);
                        $addedRowCount++;
                        break;

                    case 'leads':
                        $count++;

                        $logId = \models\ActivityAction::UPLOAD_LEAD;
                        // We're going to need the user account
                        if (isset($the_accounts[$owners[$key]])) {
                            $assignedAccount = $the_accounts[$owners[$key]];
                        } else {
                            $assignedAccount = $this->account();
                        }

                        // Handle Client Account
                        $companyName = (isset($mappings['company'])) ? @$the_data[$key][$mappings['company']] : '';

                        // Handle Business type
                        $businessTypeName = (isset($mappings['businessType'])) ? trim($the_data[$key][$mappings['businessType']]) : '';
                        $businessType = $this->em->getRepository('models\BusinessType')->findOneBy(array(
                            'type_name' => $businessTypeName
                        ));  
                        
                        // Use residential if it says so, or if there's no company name
                        if (!$companyName || strtolower($companyName) == 'residential') {
                            $clientAccount = $residentialAccount;
                        } else {
                            // Otherwise, lookup/create based on company name
                            $clientAccount = $this->account()->getCompany()->findClientAccountByName($companyName, $assignedAccount);
                        }

                        // Now Save the client
                        $lead = new models\Leads();
                        $firstName = ($mappings['firstName']) ? @$the_data[$key][$mappings['firstName']] : '';
                        $lead->setFirstName($firstName);
                        $lastName = ($mappings['lastName']) ? @$the_data[$key][$mappings['lastName']] : '';
                        $lead->setLastName($lastName);
                        $companyName = (isset($mappings['company'])) ? @$the_data[$key][$mappings['company']] : '';
                        $lead->setCompanyName($companyName);
                        $businessPhone = ($mappings['businessPhone']) ? @$the_data[$key][$mappings['businessPhone']] : '';
                        $lead->setBusinessPhone($businessPhone);
                        $email = ($mappings['email']) ? @$the_data[$key][$mappings['email']] : '';
                        $lead->setEmail($email);
                        $cellPhone = ($mappings['cellPhone']) ? @$the_data[$key][$mappings['cellPhone']] : '';
                        $lead->setCellPhone($cellPhone);
                        $fax = ($mappings['fax']) ? @$the_data[$key][$mappings['fax']] : '';
                        $lead->setFax($fax);
                        $address = ($mappings['address']) ? @$the_data[$key][$mappings['address']] : '';
                        $lead->setAddress($address);
                        $city = ($mappings['city']) ? @$the_data[$key][$mappings['city']] : '';
                        $lead->setCity($city);
                        $zip = ($mappings['zip']) ? @$the_data[$key][$mappings['zip']] : '';
                        $lead->setZip($zip);
                        $country = 'USA';
                        //$lead->setCountry($country);
                        $source = ($mappings['source']) ? @$the_data[$key][$mappings['source']] : '';
                        $lead->setSource($source);

                        $status = ($mappings['status']) ? trim($the_data[$key][$mappings['status']]) : '';
                        if($status=='Active'){
                            $status = 'Working';
                        }
                        $lead->setStatus($status);

                        $rating = ($mappings['rating']) ? @$the_data[$key][$mappings['rating']] : '';
                        $lead->setRating($rating);

                        $title = ($mappings['title']) ? @$the_data[$key][$mappings['title']] : '';
                        $lead->setTitle($title);
                        $state = ($mappings['state']) ? @$the_data[$key][$mappings['state']] : '';
                        $lead->setState($state);
                        $website = ($mappings['website']) ? @$the_data[$key][$mappings['website']] : '';
                        $lead->setWebsite($website);
                        // Set Owner Account and Company
                        $lead->setAccount($assignedAccount->getAccountId());
                        $lead->setCompany($this->account()->getCompany()->getCompanyId());


                        $projectName = ($mappings['projectName']) ? @$the_data[$key][$mappings['projectName']] : '';
                        $lead->setProjectName($projectName);

                        $projectAddress = ($mappings['projectAddress']) ? @$the_data[$key][$mappings['projectAddress']] : '';
                        $lead->setProjectAddress($projectAddress);

                        $projectCity = ($mappings['projectCity']) ? @$the_data[$key][$mappings['projectCity']] : '';
                        $lead->setProjectCity($projectCity);

                        $projectState = ($mappings['projectState']) ? @$the_data[$key][$mappings['projectState']] : '';
                        $lead->setProjectState($projectState);

                        $projectZip = ($mappings['projectZip']) ? @$the_data[$key][$mappings['projectZip']] : '';
                        $lead->setProjectZip($projectZip);

                        // Set client account
                       // $lead->setClientAccount($clientAccount);

                         $objects[$key] = $lead;
                         $this->em->persist($objects[$key]);
                         $this->em->flush();

                         if($businessType){
                            $assignment = new models\BusinessTypeAssignment(); 

                            $assignment->setBusinessTypeId($businessType->getId());
                            $assignment->setCompanyId($this->account()->getCompany()->getCompanyId());
                            $assignment->setLeadId($lead->getLeadId());
                            $this->em->persist($assignment);
                            $this->em->flush();
                            //add a data into notes table   
                        

                        }
                        $addedRowCount++;
                        break;
                    case 'prospects':
                        $logId = \models\ActivityAction::UPLOAD_PROSPECT;
                        $prospectEmail = @$the_data[$key][$mappings['email']];
                        $existing = false;

                        if ($prospectEmail) {
                            if ($this->getCompanyRepository()->checkProspectDuplicateEmail($companyId, $prospectEmail)) {
                                $existing = true;
                            }
                        }

                        if (!$existing) {
                            $client = new models\Prospects();
                            $firstName = ($mappings['firstName']) ? @$the_data[$key][$mappings['firstName']] : '';
                            $client->setFirstName($firstName);
                            $lastName = ($mappings['lastName']) ? @$the_data[$key][$mappings['lastName']] : '';
                            $client->setLastName($lastName);
                            $companyName = (isset($mappings['company'])) ? @$the_data[$key][$mappings['company']] : '';
                            $client->setCompanyName($companyName);
                            $businessPhone = ($mappings['businessPhone']) ? @$the_data[$key][$mappings['businessPhone']] : '';
                            $client->setBusinessPhone($businessPhone);
                            $email = ($mappings['email']) ? @$the_data[$key][$mappings['email']] : '';
                            $client->setEmail($email);
                            $cellPhone = ($mappings['cellPhone']) ? @$the_data[$key][$mappings['cellPhone']] : '';
                            $client->setCellPhone($cellPhone);
                            $fax = ($mappings['fax']) ? @$the_data[$key][$mappings['fax']] : '';
                            $client->setFax($fax);
                            $address = ($mappings['address']) ? @$the_data[$key][$mappings['address']] : '';
                            $client->setAddress($address);
                            $city = ($mappings['city']) ? @$the_data[$key][$mappings['city']] : '';
                            $client->setCity($city);
                            $zip = ($mappings['zip']) ? @$the_data[$key][$mappings['zip']] : '';
                            $client->setZip($zip);
                            $country = 'USA';
                            $client->setCountry($country);
                            $title = ($mappings['title']) ? @$the_data[$key][$mappings['title']] : '';
                            $client->setTitle($title);
                            $state = ($mappings['state']) ? @$the_data[$key][$mappings['state']] : '';
                            $client->setState($state);
                            $website = ($mappings['website']) ? @$the_data[$key][$mappings['website']] : '';
                            $client->setWebsite($website);
                            //bla - extra from client
                            $businessType = ($mappings['businessType']) ? @$the_data[$key][$mappings['businessType']] : 'Other';
                            $client->setBusiness($businessType);
                            $status = ($mappings['status']) ? @$the_data[$key][$mappings['status']] : 'Working';
                            $client->setStatus($status);
                            $rating = ($mappings['rating']) ? @$the_data[$key][$mappings['rating']] : 'Unknown';
                            $client->setRating($rating);
                            //setaccount and setcompany
                            $client->setAccount($owners[$key]);
                            $client->setCompany($the_accounts[$owners[$key]]->getCompany()->getCompanyId());
                            $objects[$key] = $client;
                            $this->em->persist($objects[$key]);

                            $addedRowCount++;
                            break;

                        } else {
                            $excludedRows = $the_data;
                        }
                }
            }

            $this->em->flush();
            $this->em->clear();
            $data['data'] = $the_data;
            $data['step'] = 4;
            $data['numberAdded'] = $addedRowCount;
            $data['numberDuplicates'] = count($excludedRows);
            @unlink($this->input->post('csvFile'));
           // $this->log_manager->add($logId, 'Uploaded ' . $data['numberAdded'] . ' ' . $this->uri->segment(3) . ' from csv.');
        }

      
        $this->html->addScript('dataTables');
        $this->load->view('account/upload_data2', $data);
    }

    function cleanString($string)
    {
        //add for clean address
                        // Remove special characters using regex
                        $string = preg_replace('/[^\w\s]/u', '', $string);
                        // Remove extra spaces
                        $string = preg_replace('/\s+/', ' ', $string);
                        // Trim the address
                        $string = trim($string);
                        //add for address clean 
                        return $string;
    }

    function print_report()
    {
        $this->load->view('print');
    }

    function cropLogo()
    {
        //check privileges
        if (!$this->account()->isAdministrator()) {
            $this->session->set_flashdata('error', 'Only Company Administrators can view this page!');
            redirect('account/my_account');
        }
        $company = $this->account()->getCompany();
        $image = UPLOADPATH . '/clients/logos/' . $company->getCompanyLogo();
        if (file_exists($image) && is_file($image)) {
            $data = $_POST;
            $data['x1'] = str_replace('px', '', $data['x1']);
            $data['y1'] = str_replace('px', '', $data['y1']);
            $imageInfo = getimagesize($image);
            if ($imageInfo) {
                switch ($imageInfo['mime']) {
                    case 'image/jpeg':
                        $type = 'jpg';
                        $im = imagecreatefromjpeg($image);
                        break;
                    case 'image/jpg':
                        $type = 'jpg';
                        $im = imagecreatefromjpeg($image);
                        break;
                    case 'image/png':
                        $type = 'png';
                        $im = imagecreatefrompng($image);
                        break;
                }
                $ratio = $imageInfo[0] / $data['w1'];
                $x = round($data['x1'] * $ratio);
                $y = round($data['y1'] * $ratio);
                $w = round($data['w2'] * $ratio);
                $h = round($data['h2'] * $ratio);
                $new_im = imagecreatetruecolor($w, $h);
                imagealphablending($new_im, false);
                imagesavealpha($new_im, true);
                imagecolortransparent($new_im, imagecolorallocate($new_im, 0, 0, 0));
                imagecopyresampled($new_im, $im, 0, 0, $x, $y, $w, $h, $w, $h);
                unlink($image);
                switch ($type) {
                    case 'jpg':
                        imagejpeg($new_im, $image);
                        break;
                    case 'png':
                        imagepng($new_im, $image);
                        break;
                    case 'gif':
                        imagegif($new_im, $image);
                        break;
                }
                $this->getCompanyRepository()->flagProposalsForRebuild($company->getCompanyId());
                redirect('account/my_account');
                //                print_r($imageInfo);
                //                print_r($data);
            } else {
                echo 'Image not good!';
            }
        } else {
            echo 'ERROR';
        }
    }

    function sublogin_logout()
    {
        $this->session->unset_userdata('sublogin');
        $this->session->unset_userdata('oldsublogin');
        $this->session->set_flashdata('success', 'Logged out successfully from the sub account!');
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
        redirect('admin');
    }

    function parent_sublogin_logout()
    {
        $this->session->unset_userdata('sublogin');
        $this->session->set_flashdata('success', 'Logged out successfully from the sub account!');

        if($this->session->userdata('oldsublogin')){
            //set the session sublogin id
            $this->session->set_userdata('sublogin', $this->session->userdata('oldsublogin'));
        }
    

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
        redirect('dashboard/super_user');
    }

    function getLogo()
    {
        ob_start();
        $path = UPLOADPATH . '/clients/logos/';
        $company = $this->account()->getCompany();
        $fullPath = $path . $company->getCompanyLogo();
        if (!file_exists($fullPath)) {
            $fullPath = $path . 'none.jpg';
        }
        $path_parts = pathinfo($fullPath);
        $ext = strtolower($path_parts["extension"]);
        switch ($ext) {
            case "gif":
                $ctype = "image/gif";
                break;
            case "png":
                $ctype = "image/png";
                break;
            case "jpeg":
            case "jpg":
                $ctype = "image/jpg";
                break;
            default:
                $ctype = "image/jpg";
        }

        if (ini_get('zlib.output_compression')) {
            ini_set('zlib.output_compression', 'Off');
        }
        header("Pragma: public"); // required
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false); // required for certain browsers
        header("Content-Type: $ctype");
        ob_clean();
        flush();
        readfile($fullPath);
    }

    function getSuperUserLogo()
    {
        ob_start();
        $path = UPLOADPATH . '/clients/logos/';
        $company = $this->account()->getParentCompany();
        $fullPath = $path . $company->getCompanyLogo();
        if (!file_exists($fullPath)) {
            $fullPath = $path . 'none.jpg';
        }
        $path_parts = pathinfo($fullPath);
        $ext = strtolower($path_parts["extension"]);
        switch ($ext) {
            case "gif":
                $ctype = "image/gif";
                break;
            case "png":
                $ctype = "image/png";
                break;
            case "jpeg":
            case "jpg":
                $ctype = "image/jpg";
                break;
            default:
                $ctype = "image/jpg";
        }

        if (ini_get('zlib.output_compression')) {
            ini_set('zlib.output_compression', 'Off');
        }
        header("Pragma: public"); // required
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false); // required for certain browsers
        header("Content-Type: $ctype");
        ob_clean();
        flush();
        readfile($fullPath);
    }

    function cleanOrphans()
    {
        $this->load->database();
        $proposals = $this->db->query('SELECT * FROM proposals LEFT JOIN clients ON proposals.client = clients.clientId WHERE clients.clientId IS NULL');
        $ids = '';
        $k = 0;
        foreach ($proposals->result() as $proposal) {
            $this->db->query("DELETE FROM proposals_images WHERE proposal=" . $proposal->proposalId);
            $this->db->query("DELETE FROM proposals WHERE proposalId=" . $proposal->proposalId . ' LIMIT 1');
        }
    }


    function add_customtext()
    {
       // echo "<pre>";print_r($_POST);die;
        $data = array();
        if (!$this->input->post('category') || !$this->input->post('text') || !$this->input->post('checked')) {
            $data['error'] = 'All fields are required!';
        } else {
            $text = new models\Customtext();
            $text->setCategory($this->input->post('category'));
            $text->setCompany($this->account()->getCompany()->getCompanyId());
            $text->setOrd(100);
            $text->setChecked($this->input->post('checked'));
            $text->setText($this->input->post('text'));
            $text->setServiceId($this->input->post('service_id'));
            $this->em->persist($text);
            $this->em->flush();
            $this->session->set_flashdata('success', 'Text Added!');
            $this->session->set_flashdata('category_open', $this->input->post('category'));
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
            if ($this->input->post('on')) {
                $this->db->insert('customtext_default_categories', [
                    'categoryId' => $cat->getCategoryId(),
                    'company' => $this->account()->getCompany()->getCompanyId(),
                ]);
            }
            $this->session->set_flashdata('success', 'Category added!');
        }
        echo json_encode($data);
    }

    function get_customtext()
    {
        $data = array();
        $text = $this->em->find('models\Customtext', $this->uri->segment(3));
        if (!$text) {
            $data['error'] = 'Text not found!';
        } else {
            $data['category'] = $text->getCategory();
            $cat = $this->em->find('models\Customtext_categories', $text->getCategory());
            $data['categoryName'] = $cat->getCategoryName();
            $data['text'] = $text->getText();
            $data['service_id'] = $text->getServiceId();
            $data['checked'] = $text->getChecked();
        }
        echo json_encode($data);
    }

    function get_customtext_cat()
    {
        $data = array();
        $cat = $this->em->find('models\Customtext_categories', $this->uri->segment(3));
        if (!$cat) {
            $data['error'] = 'Category not found!';
        } else {
            $data['category'] = $cat->getCategoryName();
        }
        echo json_encode($data);
    }

    function edit_customtext()
    {
        $data = array();
        $text = $this->em->find('models\Customtext', $this->input->post('id'));
        if (!$text) {
            $data['error'] = 'Text not found!';
            echo json_encode($data);
        } else {
            $company = $this->account()->getCompany()->getCompanyId();
            $newValues = array();
            $newValues[] = $this->input->post('category');
            $newValues[] = $this->input->post('text');
            $newValues[] = $this->input->post('checked');
            $newValues[] = $this->input->post('checked');
            $newValues[]= $this->input->post('edit_service_id');
            $this->customtexts->editText($text, $newValues, $company);
            $this->session->set_flashdata('success', 'Text Edited Successfully!');
            redirect('account/resetCompanyProposals/custom_texts');
        }
    }

    function edit_customtext_cat()
    {
        $data = array();
        $cat = $this->em->find('models\Customtext_categories', $this->input->post('id'));
        if (!$cat) {
            $data['error'] = 'Category not found!';
        } else {
            $cat->setCategoryName($this->input->post('category'));
            $this->em->persist($cat);
            $this->em->flush();
            $this->session->set_flashdata('success', 'Category Edited Successfully!');
            redirect('account/resetCompanyProposals/custom_texts');
        }
        echo json_encode($data);
    }

    function delete_customtext()
    {
        $text = $this->em->find('models\Customtext', $this->uri->segment(3));
        if (!$text) {
//            $this->session->set_flashdata('success', 'Text not found!');
        } else {
            $company = $this->account()->getCompany()->getCompanyId();
            $this->customtexts->deleteText($text, $company);
//            $this->session->set_flashdata('success', 'Text Deleted Successfully!');
            redirect('account/resetCompanyProposals/custom_texts');
        }
//        redirect('account/custom_texts');
    }

    function delete_customtext_cat()
    {
        $cat = $this->em->find('models\Customtext_categories', $this->uri->segment(3));
        if (!$cat) {
            $this->session->set_flashdata('success', 'Category not found!');
        } else {
            $this->em->remove($cat);
            $this->em->flush();
//            $this->session->set_flashdata('success', 'Category Deleted Successfully!');
            redirect('account/resetCompanyProposals/custom_texts');
        }
        redirect($this->uri->segment(1) . '/custom_texts');
    }

    function restore_customtext()
    {
        $deleted_text = $this->em->getRepository('models\Deleted_customtexts')->findOneBy(array(
            'textId' => $this->uri->segment(3),
            'companyId' => $this->account()->getCompany()->getCompanyId()
        ));
        if ($deleted_text) {
            if ($deleted_text->getReplacedBy()) {
                $text = $this->em->find('models\Customtext', $deleted_text->getReplacedBy());
                if ($text) {
                    $this->em->remove($text);
                }
            }
            $this->em->remove($deleted_text);
            $this->em->flush();
            $this->session->set_flashdata('success', 'Text restored successfully!');
        } else {
            $this->session->set_flashdata('error', 'Error processing your request. Please try again later.');
        }
        if (!$this->uri->segment(4)) {
            redirect('account/company_proposal_details');
        }
    }

    function notes()
    {
        $data['notes'] = array();
        $notes = $this->em->createQuery("SELECT n FROM models\Notes n WHERE n.type='" . $this->uri->segment(3) . "' AND n.relationId=" . $this->uri->segment(4) . ' ORDER BY n.added DESC ')->getResult();
        if (count($notes)) {
            $data['notes'] = $notes;
        }

         
        $this->load->view('account/notes', $data);
    }

    function item_and_estimate_notes()
    {
        $data['notes'] = array();
        $notes = $this->em->createQuery("SELECT n FROM models\Notes n WHERE (n.type='estimate' AND n.relationId=" . $this->uri->segment(3) . ") OR (n.type='estimate_line_item' AND n.parent_relation_id=" . $this->uri->segment(3) ." ) ORDER BY n.added DESC")->getResult();
        if (count($notes)) {
            $data['notes'] = $notes;
        }
        $this->load->view('account/estimate-notes', $data);
    }
    function estimate_item_and_estimate_notes()
    {
        $data['notes'] = array();
        $notes = $this->em->createQuery("SELECT n FROM models\Notes n WHERE (n.type='estimate' AND n.relationId=" . $this->uri->segment(3) . ") OR (n.type='estimate_line_item' AND n.parent_relation_id=" . $this->uri->segment(3) ." ) ORDER BY n.added DESC")->getResult();
        if (count($notes)) {
            $data['notes'] = $notes;
        }
        $this->load->view('account/estimate-notes-cal', $data);
    }

    function estimate_item_notes()
    {
        $data['notes'] = array();
        $notes = $this->em->createQuery("SELECT n FROM models\Notes n WHERE n.type='" . $this->uri->segment(3) . "' AND n.relationId='" . $this->uri->segment(5) . "' AND n.parent_relation_id=" . $this->uri->segment(4)  . ' ORDER BY n.added DESC')->getResult();
        if (count($notes)) {
            $data['notes'] = $notes;
        }
        $this->load->view('account/notes', $data);
    }

    function edit_services()
    {
        $this->load->database();
        if (!$this->account()->isAdministrator()) {
            $this->session->set_flashdata('error', 'Only Company Administrators can do this!');
            redirect('account/my_account');
        }
        $data = array();
        $services = array();
        $disabledServices = array();
        //$categories = $this->em->createQuery('select c from models\Services c where c.parent = 0 order by c.ord')->getResult();
        $data['categories'] = $this->account()->getCompany()->getCategories();
        //$servs = $this->em->createQuery('select s from models\Services s where s.parent <> 0 order by s.ord')->getResult();
        //foreach ($servs as $service) {
        //    $services[$service->getParent()][] = $service;
        //}
        $service_titles = array();
        $stitles = $this->em->createQuery('SELECT st FROM models\Service_titles st WHERE st.company=' . $this->account()->getCompany()->getCompanyId())->getResult();
        foreach ($stitles as $st) {
            $service_titles[$st->getService()] = $st->getTitle();
        }
        $data['service_titles'] = $service_titles;
        $data['services'] = $this->account()->getCompany()->getServices(true);
        $dServices = $this->db->query("SELECT * FROM services_disabled WHERE company=" . $this->account()->getCompany()->getCompanyId());
        foreach ($dServices->result() as $dService) {
            $disabledServices[] = $dService->service;
        }
        $data['disabledServices'] = $disabledServices;
        $this->load->view('account/edit_services', $data);
    }

    function edit_default_service($id)
    {
        $this->load->database();
        $data = $this->edit_company_data();
        $service = $this->em->find('models\Services', $id);
        if (!$service) {
            $this->session->set_flashdata('error', 'Service not found!');
            redirect('account/edit_services');
        }
        //check if we are having a diffferent title defined
        $customTitle = $this->em->getRepository('models\Service_titles')->findOneBy(array(
            'company' => $this->account()->getCompany()->getCompanyId(),
            'service' => $service->getServiceId()
        ));
        $serviceName = $service->getServiceName();
        if ($customTitle) {
            $data['customTitle'] = $customTitle->getTitle();
            $serviceName = $customTitle->getTitle();
        }
        //post's
        if ($this->input->post('add_text')) {
            if ($this->input->post('addTextText')) {
                $text = new \models\ServiceText();
                $text->setService($service->getServiceId());
                $text->setCompany($this->account()->getCompany()->getCompanyId());
                $text->setOrd(99);
                $text->setText($this->input->post('addTextText'));
                $this->em->persist($text);
                $this->em->flush();
                $this->session->set_flashdata('success', 'Text Added!');
                $this->log_manager->add(\models\ActivityAction::COMPANY_ADD_SERVICE_TEXT,
                    'Added text "' . strip_tags($this->input->post('addTextText')) . '" to service ' . $serviceName);
            } else {
                $this->session->set_flashdata('error', 'You must submit a text!');
            }
            redirect('account/edit_service/' . $service->getServiceId());
        }
        if ($this->input->post('edit_text')) {
            $text = $this->em->find('models\ServiceText', $this->input->post('editTextId'));
            if (!$text) {
                $this->session->set_flashdata('error', 'Text not found!');
            } else {
                $this->log_manager->add(\models\ActivityAction::COMPANY_EDIT_SERVICE_TEXT,
                    'Edited text from "' . strip_tags($text->getText()) . '" to "' . strip_tags($this->input->post('editServiceText')) . '" within service ' . $serviceName);
                if ($text->getCompany() == 0) {
                    //create new text and mark original one as deleted for this company
                    $newText = new \models\ServiceText();
                    $newText->setCompany($this->account()->getCompany()->getCompanyId());
                    $newText->setText($this->input->post('editServiceText'));
                    $newText->setService($service->getServiceId());
                    $newText->setOrd($text->getOrd());
                    $this->em->persist($newText);
                    $this->em->flush();
                    //check if text is reordered by the company
                    $ord = $this->em->getRepository('\models\ServiceTextOrder')->findOneBy(array(
                        'company' => $this->account()->getCompany()->getCompanyId(),
                        'service' => $service->getServiceId(),
                        'textId' => $text->getTextId()
                    ));
                    if ($ord) {
                        $ord->setTextId($newText->getTextId());
                    }
                    //set admin text as deleted and replaced
                    $deletedText = new \models\Service_deleted_texts();
                    $deletedText->setCompany($this->account()->getCompany()->getCompanyId());
                    $deletedText->setTextId($text->getTextId());
                    $deletedText->setReplacedBy($newText->getTextId());
                    $this->em->persist($deletedText);
                    $this->em->flush();
                } elseif ($text->getCompany() == $this->account()->getCompany()->getCompanyId()) {
                    //just edit the text.
                    $text->setText($this->input->post('editServiceText'));
                    $this->em->persist($text);
                    $this->em->flush();
                }
                $this->session->set_flashdata('success', 'Text Edited!');
            }
            redirect('account/edit_service/' . $service->getServiceId());
        }
        $data['service'] = $service;
        $texts = array();
        $q = "SELECT st.*, sdt.linkId, sdt.replacedBy FROM service_texts st
        LEFT JOIN service_texts_order sto ON (st.textId = sto.textId)
        LEFT JOIN service_deleted_texts sdt ON ((st.textId = sdt.textId) AND (sdt.company = " . $this->account()->getCompany()->getCompanyId() . "))
        WHERE ((st.service = " . $service->getServiceId() . ") AND (st.company = " . $this->account()->getCompany()->getCompanyId() . " OR st.company = 0))
        ORDER BY COALESCE( sto.ord, 999999 ) , st.ord";
        $q = "SELECT st.*, sdt.linkId, sdt.replacedBy FROM service_texts st
        LEFT JOIN service_texts_order sto ON (st.textId = sto.textId AND sto.company=" . $this->account()->getCompany()->getCompanyId() . ")
        LEFT JOIN service_deleted_texts sdt ON ((st.textId = sdt.textId) AND (sdt.company = " . $this->account()->getCompany()->getCompanyId() . "))
        WHERE ((st.service = " . $service->getServiceId() . ") AND (st.company = " . $this->account()->getCompany()->getCompanyId() . " OR st.company = 0))
        ORDER BY COALESCE( sto.ord, 999999 ) , st.ord";
        $txts = $this->db->query($q);
        foreach ($txts->result() as $txt) {
            $text = $this->em->find('models\ServiceText', $txt->textId);
            if ($text) {
                $texts[$txt->textId] = array(
                    'text' => $text,
                    'deleted' => $txt->linkId,
                    'replacedBy' => $txt->replacedBy
                );
            }
        }
        //move deleted to last and replaced texts under the item that replaces them
        foreach ($texts as $id => $text) {
            if ($text['deleted'] && $text['replacedBy'] && isset($texts[$text['replacedBy']])) {
                unset ($texts[$id]);
                $texts[$text['replacedBy']]['replacedText'] = $text;
            } elseif ($text['deleted']) {
                unset($texts[$id]);
                $texts[$id] = $text;
            }
        }
        $data['texts'] = $texts;
        $fields = $this->em->createQuery('SELECT f FROM models\ServiceField f WHERE f.service=' . $service->getServiceId() . ' ORDER BY f.ord')->getResult();
        $data['fields'] = $fields;
        $this->html->addScript('ckeditor4');
        $data['layout'] = 'account/my_account/edit_service';
        $this->load->view('account/my_account', $data);
    }

    function delete_text($id)
    {
        $text = $this->em->find('models\ServiceText', $id);
        if ($text) {
            $service = $this->em->find('models\Services', $text->getService());
            $this->log_manager->add(\models\ActivityAction::COMPANY_DELETE_SERVICE_TEXT,
                'Deleted text "' . strip_tags($text->getText()) . '" from service ' . $service->getServiceName());
            if ($text->getCompany() == $this->account()->getCompany()->getCompanyId()) {
                $this->em->remove($text);
                $this->em->flush();
            } else {
                $dt = new \models\Service_deleted_texts();
                $dt->setCompany($this->account()->getCompany()->getCompanyId());
                $dt->setTextId($text->getTextId());
                $this->em->persist($dt);
                $this->em->flush();
            }
            $this->session->set_flashdata('success', 'Text Deleted!');
            redirect('account/edit_service/' . $text->getService());
        } else {
            $this->session->set_flashdata('error', 'Text Not found!');
            redirect('account/edit_services');
        }
    }

    function restore_text($id)
    {
        $text = $this->em->find('models\ServiceText', $id);
        if ($text) {
            $service = $this->em->find('models\Services', $text->getService());
            $this->log_manager->add(\models\ActivityAction::COMPANY_RESTORE_SERVICE_TEXT,
                'Restored text "' . strip_tags($text->getText()) . '" from service ' . $service->getServiceName());
            //check if it is a simply deleted text or a replaced.
            $sdt = $this->em->getRepository('models\Service_deleted_texts')->findOneBy(array(
                'company' => $this->account()->getCompany()->getCompanyId(),
                'textId' => $id
            ));
            if (!$sdt) {
                $this->session->set_flashdata('error', 'Text Not found!');
                redirect('account/edit_services');
            } else {
                if ($sdt->getReplacedBy()) {
                    $rt = $this->em->find('models\ServiceText', $sdt->getReplacedBy());
                    if ($rt) {
                        $this->em->remove($rt);
                    }
                }
                $this->em->remove($sdt);
                $this->em->flush();
                $this->session->set_flashdata('success', 'Text recovered!');
                redirect('account/edit_service/' . $text->getService());
            }
        } else {
            $this->session->set_flashdata('error', 'Text Not found!');
            redirect('account/edit_services');
        }
    }


    function setPaymentTerm()
    {
        $id = $this->uri->segment(3);
        $proposal = $this->em->find('models\Proposals', $id);
        if ($proposal) {
            $proposal->setPaymentTermTexT($this->input->post('paymentTermText'));
            $proposal->setRebuildFlag(1);
            $this->em->persist($proposal);
            $this->session->set_flashdata('success', 'Payment Term Text Saved!');
            $this->em->flush();
        } else {
            $this->session->set_flashdata('error', 'Proposal not found!');
        }
        redirect('proposals/edit/' . $id);
    }

    function setContractCopy()
    {
        $id = $this->uri->segment(3);
        $proposal = $this->em->find('models\Proposals', $id);
        if ($proposal) {
            $proposal->setContractCopy($this->input->post('contractCopyText'));
            $proposal->setRebuildFlag(1);
            $this->em->persist($proposal);
            $this->session->set_flashdata('success', 'Contract Copy Saved!');
            $this->em->flush();
        } else {
            $this->session->set_flashdata('error', 'Proposal not found!');
        }
        redirect('proposals/editl/' . $id);
    }

    function updatePhones()
    {
        $accounts = $this->em->createQuery('SELECT a FROM models\Accounts a, models\Companies c WHERE a.company IS NOT NULL')->getResult();
        foreach ($accounts as $account) {
            $account->setOfficePhone($account->getCompany()->getCompanyPhone());
            $this->em->persist($account);
        }
        $this->em->flush();
        echo 'Done!';
    }

    function changeCollapseBoxState()
    {
        $account = $this->account()->getAccountId();
        $settingName = $this->input->post('box');
        $settingValue = $this->input->post('state');
        $this->accountSettings->setSetting($account, $settingName, $settingValue);
    }

    function calculators()
    {
        $data = array();
        $data['service'] = null;
        $data['account'] = $this->account();
        if ($this->uri->segment(4)) {
            $service = $this->em->find('models\Proposal_services', $this->uri->segment(4));
            if ($service) {
                $proposal = $this->em->find('models\Proposals', $service->getProposal());
            }
            if (!$service || !$proposal) {
                $this->session->set_flashdata('error', 'Service or Proposal Invalid!');
                redirect('account/calculators/' . $this->uri->segment(3));
            } else {
                $data['proposal'] = $proposal;
                $data['service'] = $service;
                $fields = array();
                //item fields
                $fds = $this->em->createQuery('SELECT f FROM models\ServiceField f WHERE f.service=' . $service->getInitialService())->getResult();
                foreach ($fds as $field) {
                    $fields[$field->getFieldCode()] = $field->getFieldValue();
                }
                $fds2 = $this->em->createQuery('SELECT f FROM models\Proposal_services_fields f WHERE f.serviceId=' . $service->getServiceId())->getResult();
                foreach ($fds2 as $field) {
                    $fields[$field->getFieldCode()] = $field->getFieldValue();
                }
                $data['fields'] = $fields;
            }
        }
        $this->load->view('account/calculators', $data);
    }

    /*
     *  Display a map with approx geolocation info
     */
    function ipMap($ip)
    {
        $httpClient = new Psr18Client();
        $psr17Factory = new Psr17Factory();
        $ipdata = new Ipdata($_ENV['IPDATA_KEY'], $httpClient, $psr17Factory);

        //Create view data
        $data = array();
        // Assign the GP object
        $data['gp'] = (object) $ipdata->lookup($ip, ['latitude', 'longitude']);

        // Render the view
        $this->load->view('account/ipMap', $data);

    }

    /*Faq Page*/
    function faq()
    {
        $data = array();
        //get categories
        $categories = $this->db->query("SELECT * FROM faq_categories ORDER BY ord");
        $data['categories'] = $categories;
        //get questions
        $sqlQuestions = $this->db->query("SELECT * FROM faq_questions ORDER BY ord");
        $questions = array();
        foreach ($sqlQuestions->result() as $question) {
            $questions[$question->category_id][] = $question;
        }
        $data['questions'] = $questions;
        $this->load->view('account/faq_page', $data);
    }

    function ajaxSortTemplates()
    {
        $this->load->model('clientEmail');

        $templates = $this->input->post('templates');
        $templateType = $this->input->post('templateType');

        if (count($templates)) {
            // Clear existing order
            $this->clientEmail->clearCompanyOrder($this->account()->getCompany()->getCompanyId(), $templateType);

            $i = 1;

            foreach ($templates as $templateId) {

                $ceo = new \models\ClientEmailOrder();
                $ceo->setCompany($this->account()->getCompany()->getCompanyId());
                $ceo->setTemplateId($templateId);
                $ceo->setOrd($i);

                $this->em->persist($ceo);
                $i++;
            }
            $this->em->flush();

            //Delete Template query Cache
            $this->getQueryCacheRepository()->deleteEmailTemplateListCache($this->account()->getCompanyId(),$templateType);

            // Log the change
            $this->log_manager->add(\models\ActivityAction::COMPANY_SETTING, 'User updated email templates order');
        }
    }

    function testClear()
    {
        $this->load->model('clientEmail');
        $this->clientEmail->clearCompanyOrder(3, 1);
    }

    function ajaxGetClientTemplateParsed()
    {

        
        $this->load->library('JsonResponse');

        $templateId = $this->input->post('templateId');
        $client_id = $this->input->post('client_id');

        $template = $this->em->find('\models\ClientEmailTemplate', $templateId);
        /* @var $template \models\ClientEmailTemplate */
        $client = $this->em->find('\models\Clients', $client_id);
        
        $etp = new \EmailTemplateParser();
        $etp->setClient($client);
        $etp->setAccount($client->getAccount());
        $response = new JsonResponse();
        $response->templateSubject = $etp->parse($template->getTemplateSubject());
        $response->templateBody = $etp->parse($template->getTemplateBody());
       // $response->typeFields = $template->getTemplateType()->getFields();
        $response->send();
    }

    function ajaxGetClientTemplateRaw()
    {

        
        $this->load->library('JsonResponse');

        $templateId = $this->input->post('templateId');

        $template = $this->em->find('\models\ClientEmailTemplate', $templateId);
        /* @var $template \models\ClientEmailTemplate */

        $response = new JsonResponse();
        $response->templateSubject = $template->getTemplateSubject();
        $response->templateBody = $template->getTemplateBody();
       // $response->typeFields = $template->getTemplateType()->getFields();
        $response->send();
    }

    function ajaxGetProposalTemplateParsed()
    {
        $this->load->library('JsonResponse');

        $templateId = $this->input->post('templateId');
        $proposalId = $this->input->post('proposalId');

        $template = $this->em->find('\models\ClientEmailTemplate', $templateId);
        /* @var $template \models\ClientEmailTemplate */
        $proposal = $this->em->find('\models\Proposals', $proposalId);
        /* @var $template \models\Proposals */

        $etp = new \EmailTemplateParser();
        $etp->setProposal($proposal);
        $etp->setParseProposalLink(false);

        $response = new JsonResponse();
        $response->templateSubject = $etp->parse($template->getTemplateSubject());
        $response->templateBody = $etp->parse($template->getTemplateBody());
        $response->email_to = $proposal->getClient()->getEmail();

        $response->send();
    }

    function ajaxGetLeadTemplateParsed()
    {

        
        $this->load->library('JsonResponse');

        $templateId = $this->input->post('templateId');
        $lead_id = $this->input->post('lead_id');

        $template = $this->em->find('\models\ClientEmailTemplate', $templateId);
        /* @var $template \models\ClientEmailTemplate */
        $lead = $this->em->find('\models\Leads', $lead_id);
        $leadAccount = $this->em->findAccount($lead->getAccount());
        //print_r($lead->getFirstName());die;
        $etp = new \EmailTemplateParser();
        $etp->setLead($lead);
        $etp->setAccount($leadAccount);
       // print_r($etp->parse($template->getTemplateBody()));die;
        $response = new JsonResponse();
        $response->templateSubject = $etp->parse($template->getTemplateSubject());
        $response->templateBody = $etp->parse($template->getTemplateBody());
       // $response->typeFields = $template->getTemplateType()->getFields();
        $response->send();
    }


    function ajaxGetProspectTemplateParsed()
    {

        
        $this->load->library('JsonResponse');

        $templateId = $this->input->post('templateId');
        $prospect_id = $this->input->post('prospect_id');

        $template = $this->em->find('\models\ClientEmailTemplate', $templateId);
        /* @var $template \models\ClientEmailTemplate */
        $prospect = $this->em->find('\models\Prospects', $prospect_id);
        $prospectAccount = $this->em->findAccount($prospect->getAccount());
        //print_r($lead->getFirstName());die;
        $etp = new \EmailTemplateParser();
        $etp->setProspect($prospect);
        $etp->setAccount($prospectAccount);
       // print_r($etp->parse($template->getTemplateBody()));die;
        $response = new JsonResponse();
        $response->templateSubject = $etp->parse($template->getTemplateSubject());
        $response->templateBody = $etp->parse($template->getTemplateBody());
       // $response->typeFields = $template->getTemplateType()->getFields();
        $response->send();
    }

    function services()
    {

        $data = $this->edit_company_data();
        $services = array();
        $disabledServices = array();
        $service_titles = array();
        $categories = array();

        $data['action'] = $this->uri->segment(3);
        $data['categories'] = $this->account()->getCompany()->getCategories();


        if ($this->input->post('add_service')) {

            if ($this->account()->isAdministrator()) {
                $this->load->library('helpers/ServiceHelper', array('account' => $this->account()));
                $this->servicehelper->add();

                $this->alert($this->servicehelper->getAlertClass(), $this->servicehelper->getAlertMessage());
            } else {
                $this->alert('error', 'You do ot have permission to add a new service!');
            }

            redirect('account/company_services');
        }

        $data['layout'] = 'account/services/index';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);

    }

    function edit_service($id)
    {
        $data = array();

        // Load the service
        $service = $this->em->find('models\Services', $id);
        /* @var $service \Models\Services */

        // Check service loaded
        if (!$service) {
            $this->session->set_flashdata('error', 'Service not found!');
            redirect('account/company_services');
        }

        // There is a company, check it's the right one
        if (!$service->editAuth($this->account())) {
            $this->session->set_flashdata('error', 'You do not have permission to edit this service');
            redirect('account/company_services');
        }

        // Service Field add/edit
        if ($this->input->post('add_field') || $this->input->post('save_field')) {

            // Load the helper
            $this->load->library('helpers/ServiceFieldHelper', array('account' => $this->account()));
            $this->servicefieldhelper->setService($service);
            $this->servicefieldhelper->setRedirect('account/edit_service/' . $service->getServiceId());

            // Adding a field
            if ($this->input->post('add_field')) {
                $this->servicefieldhelper->add();
            }

            // Editing a field
            if ($this->input->post('save_field')) {
                $this->servicefieldhelper->edit();
            }

            //Temp Delete Cache result
            $this->getQueryCacheRepository()->deleteCompanyServiceCache($this->account()->getCompanyId());
            // $this->em->getConfiguration()->getResultCacheImpl()->delete( CACHE_COMPANY_SERVICES . $this->account()->getCompanyId());
            $this->getQueryCacheRepository()->deleteCompanyServiceMapCache($this->account()->getCompanyId());
            // $this->em->getConfiguration()->getResultCacheImpl()->delete( CACHE_COMPANY_SERVICES_MAP . $this->account()->getCompanyId());
            
            
            // Redirect
            if ($this->servicefieldhelper->getRedirect()) {
                $this->alert($this->servicefieldhelper->getAlertClass(), $this->servicefieldhelper->getAlertMessage());
                redirect($this->servicefieldhelper->getRedirect());
            }

            
        }

        // Service Text add/edit
        if ($this->input->post('add_text') || $this->input->post('edit_text')) {

            // Load the helper
            $this->load->library('helpers/ServiceTextHelper', array('account' => $this->account()));
            $this->servicetexthelper->setService($service);
            $this->servicetexthelper->setRedirect('account/edit_service/' . $service->getServiceId());

            // Adding text
            if ($this->input->post('add_text')) {
                $this->servicetexthelper->add();
            }

            // Editing text
            if ($this->input->post('edit_text')) {
                $this->servicetexthelper->edit();
            }

            //Temp Delete Cache result
            $this->getQueryCacheRepository()->deleteCompanyServiceCache($this->account()->getCompanyId());
            // $this->em->getConfiguration()->getResultCacheImpl()->delete( CACHE_COMPANY_SERVICES . $this->account()->getCompanyId());
            $this->getQueryCacheRepository()->deleteCompanyServiceMapCache($this->account()->getCompanyId());
            // $this->em->getConfiguration()->getResultCacheImpl()->delete( CACHE_COMPANY_SERVICES_MAP . $this->account()->getCompanyId());


            if ($this->servicetexthelper->getRedirect()) {
                $this->alert($this->servicetexthelper->getAlertClass(), $this->servicetexthelper->getAlertMessage());
                redirect($this->servicetexthelper->getRedirect());
            }
        }

        // Default variables and view
        $data['category'] = $this->em->find('models\Services', $service->getParent());
        $data['fields'] = $this->account()->getCompany()->getServiceFields($service->getServiceId());
        $data['texts'] = $this->account()->getCompany()->getOrderedServiceTexts($service->getServiceId());
        $data['service'] = $service;
        $data['account'] = $this->account();
        $this->load->view('account/services/edit', $data);
    }

    /**
     * @param $id
     * @description Duplicates a service for a companyy
     */
    function duplicate_service($id)
    {
        // Load the service
        $service = $this->em->find('models\Services', $id);
        /* @var $service \Models\Services */

        // Check service loaded
        if (!$service) {
            $this->session->set_flashdata('error', 'Service not found!');
            redirect('account/company_services');
        }

        // There is a company, check it's the right one
        if (!$service->editAuth($this->account())) {
            $this->session->set_flashdata('error', 'You do not have permission to duplicate this service');
            redirect('account/company_services');
        }

        // Load the helper and pass in the service
        $this->load->library('helpers/ServiceHelper', array('account' => $this->account()));
        $this->servicehelper->setService($service);

        // Run the duplication
        $this->servicehelper->duplicate();

        // Clear the service cache
        $this->getQueryCacheRepository()->deleteCompanyServiceCache($this->account()->getCompanyId());
        $this->getQueryCacheRepository()->deleteCompanyServiceMapCache($this->account()->getCompanyId());

        // Feedback
        $this->alert($this->servicehelper->getAlertClass(), $this->servicehelper->getAlertMessage());
        // Redirect
        redirect('account/company_services');
    }

    function duplicate_template($id)
    {
        // Load the service
        
        $template = $this->em->findTemplate($id);
        /* @var $service \Models\Services */

        // Check service loaded
        if (!$template) {
            $this->session->set_flashdata('error', 'Template not found!');
            redirect('account/estimating_templates');
        }

        $newTemplate = clone $template;
        
        // Set the name
        $newTemplate->setName('Copy of '.$template->getName());
        $newTemplate->setId(NULL);
        
        // Save
        $this->em->persist($newTemplate);
        $this->em->flush();

        // Load the helper and pass in the service
        $allItems = $this->getEstimationRepository()->getEstimateTemplateItems($id);
       
        foreach($allItems as $templateItem){
            $newTemplateItem = clone  $templateItem;
            $newTemplateItem->setTemplateId($newTemplate->getId());
            $newTemplateItem->setId(NULL);
            $this->em->persist($newTemplateItem);
        }
        $this->em->flush();
        
        $company = $this->account()->getCompany();
        $serviceItems = $this->getEstimationRepository()->getAllCompanyTemplateServices($company, $id);
        
        foreach($serviceItems as $serviceItem){
            $newServiceItem = clone  $serviceItem;
            $newServiceItem->setTemplateId($newTemplate->getId());
            $newServiceItem->setId(NULL);
            $this->em->persist($newServiceItem);
        }
        $this->em->flush();
        // Feedback
        $this->alert('success', 'Template copied');
        // Redirect
        redirect('account/estimating_templates');
    }

    function delete_service_text($id)
    {

        $text = $this->em->find('\models\ServiceText', $id);

        if (!$text) {
            $this->alert('error', 'Field could not be loaded');
        }

        // Load the helper
        $this->load->library('helpers/ServiceTextHelper', array('account' => $this->account()));
        // Set where redirects go
        $this->servicetexthelper->setRedirectBase('account/edit_service/');
        // Pass in the service
        $this->servicetexthelper->setText($text);
        // Delete
        $this->servicetexthelper->delete();
        // Clear result cache
        $this->getQueryCacheRepository()->deleteCompanyServiceCaches($this->account()->getCompanyId());
        
        // Alert and redirect
        $this->alert($this->servicetexthelper->getAlertClass(), $this->servicetexthelper->getAlertMessage());
        redirect($this->servicetexthelper->getRedirect());


    }

    function delete_service_field($id)
    {

        $field = $this->em->find('\models\ServiceField', $id);
        /* @var $field \models\ServiceField */

        if (!$field) {
            $this->alert('error', 'Field could not be loaded');
        }

        // Load the helper
        $this->load->library('helpers/ServiceFieldHelper', array('account' => $this->account()));
        // Set where redirects go
        $this->servicefieldhelper->setRedirectBase('account/edit_service/');
        // Pass in the field
        $this->servicefieldhelper->setField($field);
        // Delete
        $this->servicefieldhelper->delete();

        // Alert and redirect
        $this->alert($this->servicefieldhelper->getAlertClass(), $this->servicefieldhelper->getAlertMessage());
        redirect($this->servicefieldhelper->getRedirect());
    }

    function disable_service($id)
    {

        $service = $this->em->find('\models\Services', $id);
        /* @var $service \models\Services */

        if (!$service) {
            $this->alert('error', 'The service could not be loaded!');
            redirect('account/company_services');
        }

        // Load library and set the service
        $this->load->library('helpers/ServiceHelper', array('account' => $this->account()));
        $this->servicehelper->setService($service);

        // Attempt to disable
        $this->servicehelper->disable();
        // Set the alert
        $this->alert($this->servicehelper->getAlertClass(), $this->servicehelper->getAlertMessage());
        // Redirect
        redirect('account/company_services');
    }

    function enable_service($id)
    {

        $service = $this->em->find('\models\Services', $id);
        /* @var $service \models\Services */

        if (!$service) {
            $this->alert('error', 'The service could not be loaded!');
            redirect('account/company_services');
        }

        // Load library and set the service
        $this->load->library('helpers/ServiceHelper', array('account' => $this->account()));
        $this->servicehelper->setService($service);

        // Attempt to disable
        $this->servicehelper->enable();
        // Set the alert
        $this->alert($this->servicehelper->getAlertClass(), $this->servicehelper->getAlertMessage());
        // Redirect
        redirect('account/company_services');
    }

    function delete_service($serviceId)
    {
        // Load service
        $service = $this->em->find('\models\Services', $serviceId);
        /* @var $service \models\Services */

        // Redirect if not loaded
        if (!$service) {
            $this->alert('error', 'The service could not be loaded');
            redirect('account/company_services');
        }

        // Load the helper
        $this->load->library('helpers/ServiceHelper', array('account' => $this->account()));
        $this->servicehelper->setService($service);

        // Delete it
        $this->servicehelper->delete();

        // Clear the services cache
        $this->getQueryCacheRepository()->deleteCompanyServiceCaches($this->account()->getCompanyId());

        $this->alert($this->servicehelper->getAlertClass(), $this->servicehelper->getAlertMessage());
        redirect('account/company_services');

    }

    function disable_service_field($id)
    {
        $field = $this->em->find('\models\ServiceField', $id);
        /* @var $field \models\ServiceField */

        if (!$field) {
            $this->alert('error', 'The $field could not be loaded!');
            redirect($_SERVER['HTTP_REFERER']);
        }

        // Load library and set the service
        $this->load->library('helpers/ServiceFieldHelper', array('account' => $this->account()));
        $this->servicefieldhelper->setField($field);

        // Attempt to disable
        $this->servicefieldhelper->disable();

        // Clear the service cache
        $this->getQueryCacheRepository()->deleteCompanyServiceCaches($this->account()->getCompanyId());

        // Set the alert
        $this->alert($this->servicefieldhelper->getAlertClass(), $this->servicefieldhelper->getAlertMessage());
        // Redirect
        redirect('account/edit_service/' . $field->getService());
    }

    /**
     * Turns existing custom text category on or off with ajax post
     */
    public function toggleCustomtextCategory()
    {
        if ($this->input->post('enable')) {
            $this->db->insert('customtext_default_categories', [
                'categoryId' => $this->input->post('categoryId'),
                'company' => $this->account()->getCompany()->getCompanyId(),
            ]);
        } else {
            $this->db->where('company', $this->account()->getCompany()->getCompanyId())
                ->where('categoryId', $this->input->post('categoryId'))
                ->delete('customtext_default_categories');
        }
        echo 'success';
    }

    public function test()
    {
        $data = [
            'action' => 'test_action',
            'details' => 'test action',
        ];
        $this->getLogRepository()->add($data);
        echo 'done!';
    }

    public function calendar()
    {
        $data = $this->edit_company_data();
        $data['accounts'] = $this->getAccountRepository()->getAllAccounts($this->account()->getCompany()->getCompanyId());
       // echo "<pre>";print_r($data['accounts']);die;
        $this->html->addScript('fullCalendar');
        $this->html->addScript('dataTables');
        $this->html->addScript('scheduler');
        $data['filterAccounts'] = $this->getCompanyRepository()->getPermittedAccounts($this->account());
        $data['event_types'] = $this->getEventRepository()->getTypes($this->account()->getCompany()->getCompanyId());
        $data['googleRepository'] = new \Pms\Repositories\GoogleAuth($this->account()->getAccountId());
 
        $account = ($this->account()->isFullAccess()) ? null : $this->account()->getAccountId();
        $data['events'] = $this->getEventRepository()->getAll($data['company']->getCompanyId(), $account);
        //echo "<pre>";print_r($data['events']);die;
        $this->load->view('calendar/index', $data);
    }

    public function setCalendarFilter()
    {
        foreach ($_POST as $key => $value) {
            $this->session->set_userdata($key, $value);
        }
    }

    public function event_types()
    {
        if ($this->input->post('addType')) {
            $typeData = $this->input->post('typeData');
            $this->getEventRepository()->addType($typeData);
            $this->session->set_flashdata('success', 'Event Type Added!');
            //redirect('account/event_types');
            redirect('account/my_account/event');

        }
        $data = $this->edit_company_data();
        $data['accounts'] = $this->getAccountRepository()->getAllAccounts($this->account()->getCompany()->getCompanyId());
        $data['event_types'] = $this->getEventRepository()->getTypes($this->account()->getCompany()->getCompanyId());
         $data['layout'] = 'account/my_account/calendar/event_types';
        $this->html->addScript('fullCalendar');
        $this->html->addScript('dataTables');
        $this->html->addScript('spectrum');
        $account = ($this->account()->isAdministrator()) ? null : $this->account()->getAccountId();
        $data['events'] = $this->getEventRepository()->getAll($data['company']->getCompanyId(), $account);
        $this->load->view('account/my_account', $data);
    }

    public function delete_type($id, $transferTo = null)
    {
        // Load the event type
        $eventType = $this->em->find('\models\EventType', $id);

        if ($transferTo) {

            if ($eventType) {
                // Migrate
                $this->getEventRepository()->transferEventTypes($eventType->getId(), $transferTo,
                    $this->account()->getCompany()->getCompanyId());

                // Is it default
                if (!$eventType->getCompany()) {
                    // If so, add to deleted table
                    $this->getEventRepository()->deleteType($eventType->getId(),
                        $this->account()->getCompany()->getCompanyId());
                } else {
                    // Otherwise safe to remove
                    $this->getEventRepository()->removeType($id);
                }
            }
        } else {
            $this->getEventRepository()->removeType($id);
        }
        $this->getLogRepository()->add([
            'action' => 'delete_event_type',
            'details' => 'Event Type "' . $eventType->getName() . '" deleted',
            'account' => $this->account()->getAccountId(),
            'userName' => $this->account()->getFullName(),
            'company' => $this->account()->getCompany()->getCompanyId()
        ]);
        $this->session->set_flashdata('success', 'Event Type Removed!');
    }

    public function update_type($id)
    {
        $this->getEventRepository()->updateType($id, $_POST);
    }

    public function automatic_reminders()
    {
        $data = $this->edit_company_data();
        $servicesRepository = new \Pms\Repositories\ProposalServices();
        $data['serviceParents'] = $servicesRepository->getParents($data['company']->getCompanyId());
        $data['layout'] = 'account/my_account/reminders/automatic_reminders';
        $this->load->view('account/my_account', $data);
    }

    public function saveEvent()
    {
//        var_dump($_POST); die;
        if ($this->input->post('id')) {
            $event = $this->em->findEvent($this->input->post('id'));
            if ($event) {
                if ($this->account()->isUser()) {
                    if ($event->getAccount()->getAccountId() !== $this->account()->getAccountId()) {
                        $this->session->set_flashdata('error', 'You do not have permission to edit this event');
                        if ($this->input->post('redirectRoute')) {
                            redirect($this->input->post('redirectRoute'));
                        } else {
                            redirect('dashboard');
                        }
                    }
                }
            }
        }
        $startTime = strtotime($this->input->post('startDate') . ' ' . $this->input->post('startTimeHr') . ':' . $this->input->post('startTimeMin') . ' ' . $this->input->post('startPeriod'));
        $endTime = strtotime($this->input->post('endDate') . ' ' . $this->input->post('endTimeHr') . ':' . $this->input->post('endTimeMin') . ' ' . $this->input->post('endPeriod'));
        if ($endTime < $startTime) { //failsafe
//            $endTime = $startTime + 3600;
        }
        if ($this->input->post('reminderDuration')) {
            $reminderTime = $startTime - $this->input->post('reminderDuration');
        } else {
            $reminderTime = null;
        }
        $data = [
            'id' => ($this->input->post('id')) ?: null,
            'account' => ($this->input->post('account')) ?: null,
            'proposal' => ($this->input->post('proposal')) ?: null,
            'prospect' => ($this->input->post('prospect')) ?: null,
            'location' => ($this->input->post('location')) ?: null,
            'lead' => ($this->input->post('lead')) ?: null,
            'client' => ($this->input->post('client')) ?: null,
            'type' => ($this->input->post('type')) ?: 1,
            'reminderTime' => $reminderTime,
            'company' => $this->account()->getCompany()->getCompanyId(),
            'name' => $this->input->post('name'),
            'text' => $this->input->post('text'),
            'startTime' => $startTime,
            'endTime' => $endTime,
        ];
//        var_dump($data); die;
        $this->getEventRepository()->save($data);
        $action = ($this->input->post('id')) ? 'updated' : 'added';
        $log_type = ($this->input->post('id')) ? 'calendar_eventupdated' : 'calendar_eventadded';
        $this->getLogRepository()->add([
            // 'action'=>$log_type,
            'action' => \models\ActivityAction::UPDATE_PROPOSAL_SETTING,
            'details' => 'Event "' . $this->input->post('name') . '" ' . $action,
            'userName' => $this->account()->getFullName(),
            'account' => $this->account()->getAccountId(),
            'company' => $this->account()->getCompany()->getCompanyId()
        ]);
        $this->session->set_flashdata('success', 'Event saved successfully!');
        if ($this->input->post('redirectRoute')) {
            redirect($this->input->post('redirectRoute'));
        } else {
            redirect('dashboard');
        }
    }

    public function getEvents()
    {
 //        header('Content-Type: application/json');
        $start = strtotime($this->input->post('start') . ' 00:00:00');
        $end = strtotime($this->input->post('end') . ' 24:59:59');
        $account = ($this->account()->isFullAccess()) ? null : $this->account()->getAccountId();
        //echo "<pre>";print_r($account);die;
        $branch = ($this->account()->isBranchAdmin()) ? $this->account()->getBranch() : null;
$events = $this->getEventRepository()->getCalendarEvents($start, $end,$this->account()->getCompany()->getCompanyId(), $account, $branch);

         echo json_encode($events);
    }

    public function getEventData($id)
    {
        echo json_encode($this->getEventRepository()->getEventData($id));
    }

    public function deleteEvent()
    {
        $event = $this->getEventRepository()->get($this->input->post('id'));
        $this->getEventRepository()->remove($this->input->post('id'));
        $this->getLogRepository()->add([
            // 'action' => 'calendar_event_deleted',
            'action' => \models\ActivityAction::UPDATE_PROPOSAL_SETTING,
            'details' => 'Deleted Event "' . $event->name . '"',
            'account' => $this->account()->getAccountId(),
            'userName' => $this->account()->getFullName(),
            'company' => $this->account()->getCompany()->getCompanyId()
        ]);
        $this->session->set_flashdata('success', 'Event deleted successfully!');
    }

    public function completeEvent()
    {
        $event = $this->getEventRepository()->get($this->input->post('id'));

        if ($this->input->post('revert')) {
            $completeVal = null;
            $action = 'calendar_event_uncompleted';
            $detail = 'Uncompleted Event';
            $text = 'Event Uncompleted';
        } else {
            $action = 'calendar_event_completed';
            $completeVal = Carbon::now()->timestamp;
            $detail = 'Completed Event';
            $text = 'Event Completed';
        }

        $data = [
            'id' => ($this->input->post('id')) ?: null,
            'eventCompleteTime' => $completeVal
        ];
        $this->getEventRepository()->save($data);
        $this->getLogRepository()->add([
            'action' => $action,
            'details' => $detail . '"' . $event->name . '"',
            'account' => $this->account()->getAccountId(),
            'userName' => $this->account()->getFullName(),
            'company' => $this->account()->getCompany()->getCompanyId()
        ]);
        $this->session->set_flashdata('success', $text);
    }

    /*
     * Google Stuff starts here
     * */


    public function google_auth()
    {
        $googleRepository = new \Pms\Repositories\GoogleAuth($this->account()->getAccountId());
        $response = $googleRepository->newAuth();
        if (isset($response['error'])) {
            $this->set_error_message($response['error'], 'calendar');
        } else {
            $this->set_success_message('Successfully connected to google calendar!', 'calendar');
        }
    }

    public function disconnect_google_calendar()
    {
        $googleRepository = new \Pms\Repositories\GoogleAuth($this->account()->getAccountId());
        $googleRepository->disconnect();
        $this->set_success_message('Google calendar disconnected successfully!', 'calendar');
    }


    public function sync()
    {/*
        $client = $this->initGoogleClient();
        $client->setAccessToken($this->getAccessToken());
        $service = new Google_Service_Calendar($client);*/


        $event = new Google_Service_Calendar_Event(array(
            'summary' => 'PMS Test Event',
            'location' => '800 Howard St., San Francisco, CA 94103',
            'description' => 'A chance to hear more about Google\'s developer products.',
            'start' => array(
                'dateTime' => date('c'),
                'timeZone' => 'America/New_York',
            ),
            'end' => array(
                'dateTime' => date('c', (time() + 3600)),
                'timeZone' => 'America/New_York',
            ),
            /* 'recurrence' => array(//'RRULE:FREQ=DAILY;COUNT=2'
             ),
             'attendees' => array(
 //                array('email' => 'lpage@example.com'),
 //                array('email' => 'sbrin@example.com'),
             ),
           /*'reminders' => array(
                 'useDefault' => FALSE,
                 'overrides' => array(
                     array('method' => 'email', 'minutes' => 24 * 60),
                     array('method' => 'popup', 'minutes' => 10),
                 ),
             ),*/
        ));

        //$calendarId = 'ptalkptj008884gug7mjgairs4@group.calendar.google.com';
        //$event = $service->events->insert($calendarId, $event);


        //$calendarList  = $service->calendarList->listCalendarList();
        $gAuth1 = $this->getGoogleAuthRepository(285);
        $gAuth2 = $this->getGoogleAuthRepository(911);
        ?>
        <h1>Syncing Google Calendar...</h1>
        <p>Google Calendar authenticated with User 285 - <?= ($gAuth1->authenticated()) ? 'Yes' : 'No' ?></p>
        <p>Google Calendar authenticated with User 911 - <?= ($gAuth2->authenticated()) ? 'Yes' : 'No' ?></p>
        <?php


    }


    public function pullFromGoogle()
    {
        $synced = $this->getEventRepository()->syncFromGoogle(10);
        ?><h3>Synced <?= $synced ?> Events.</h3><?php
    }

    public function updateMultipleExpiry()
    {
        $this->getAccountRepository()->updateMultipleExpiry($this->input->post('users'),
            $this->input->post('expiryDate'));
        $this->set_success_message('Users updated!');
    }


    public function groupEnableWO()
    {

        $users = $this->input->post('users');
            // Counter
            $numUsers = 0;
            
            // Loop if we have them
            if (count($users)) {
                foreach ($users as $user) {

                    $user = $this->em->findAccount($user);
                   
                    $user->setWio(1);
                    $this->em->persist($user);
                    $numUsers++;

                        // Log each delete
                        $this->log_manager->add('group_action_user_wio',
                            "[Group Action] - User <strong>" . $user->getFullName() . "</strong> - Wheel it Off Enabled",
                            null,
                            null,
                            null,
                            $this->account()
                        );
                    

                }
                $this->em->flush();
            }

      

        echo json_encode(array(
            'success' => true,
            'count' => $numUsers
        ));
    }

    public function groupDisableWO()
    {

        $users = $this->input->post('users');
            // Counter
            $numUsers = 0;

            // Loop if we have them
            if (count($users)) {
                foreach ($users as $user) {

                    $user = $this->em->findAccount($user);
                   
                    $user->setWio(0);
                    $this->em->persist($user);
                    $numUsers++;

                        // Log each delete
                        $this->log_manager->add('group_action_user_wio',
                            "[Group Action] - User <strong>" . $user->getFullName() . "</strong> - Wheel it Off Disabled",
                            null,
                            null,
                            null,
                            $this->account()
                        );
                    

                }
                $this->em->flush();
            }

      

        echo json_encode(array(
            'success' => true,
            'count' => $numUsers
        ));
    }

    public function groupSetSales()
    {

        $users = $this->input->post('users');
        $set = $this->input->post('set');
            // Counter
            $numUsers = 0;

            // Loop if we have them
            if (count($users)) {
                foreach ($users as $user) {

                    $user = $this->em->findAccount($user);
                   // if(!$user->isSales()){
                        $user->setSales($set);
                        $this->em->persist($user);
                        $numUsers++;



                            // Log each delete
                            $this->log_manager->add('group_action_user_wio',
                                "[Group Action] - User <strong>" . $user->getFullName() . "</strong> Set as Sales User",
                                null,
                                null,
                                null,
                                $this->account()
                            );
                     //   }
                    

                }
                $this->em->flush();
            }

      

        echo json_encode(array(
            'success' => true,
            'count' => $numUsers
        ));
    }
    

    public function sales_targets_config()
    {
        $page_check =  $this->uri->segment(2);
        $salesManagerDeactive = $this->account()->getCompany()->getSalesManager();
        if ($salesManagerDeactive==0  && $page_check=="sales_targets_config") {
              redirect('account/my_account');
        }

        $data = $this->edit_company_data();
        $data['layout'] = 'account/my_account/sales_targets/sales_targets_config';
        $data['config'] = $this->getSalesTargetsRepository()->getConfig($this->account()->getCompanyId());
        $this->html->addJS(site_url('static/js/my_account/sales_targets_config.js'));
        $this->load->view('account/my_account', $data);
    }

    public function sales_targets_users_config()
    {
        
        $page_check =  $this->uri->segment(2);
        $salesManagerDeactive = $this->account()->getCompany()->getSalesManager();
        if ($salesManagerDeactive==0  && $page_check=="sales_targets_users_config") {
              redirect('account/my_account');
        }

        $data = $this->edit_company_data();
        $data['accounts'] = $this->getCompanyRepository()->getSalesAccounts($this->account()->getCompanyId());
        $data['accountStats'] = [];
        foreach ($data['accounts'] as $account) {
            /** @var $account \models\Accounts */
            $data['accountStats'][$account->getAccountId()] = $this->getSalesTargetsRepository()->getConfig($account->getCompany()->getCompanyId(),
                $account->getAccountId());
        }
        $data['layout'] = 'account/my_account/sales_targets/sales_targets_users_config';
        $data['config'] = $this->getSalesTargetsRepository()->getConfig($this->account()->getCompanyId());
        $this->html->addJS(site_url('static/js/my_account/sales_targets_users_config.js'));
        $this->load->view('account/my_account', $data);
    }

    public function save_sales_targets()
    {
        $result = $this->getSalesTargetsRepository()->saveConfig($this->input->post('config'),
            $this->account()->getCompanyId());
        echo json_encode(['success' => $result]);
    }

    public function save_sales_targets_users()
    {
        $allConfigs = $this->input->post('config');

        foreach ($allConfigs['userConfigs'] as $account_id => $config) {
            $config['start_date'] = strtotime($config['start_date'] . ' 00:00:00');
            $this->getSalesTargetsRepository()->saveConfig($config, $this->account()->getCompanyId(), $account_id);
        }
        echo json_encode(['success' => true]);
    }

    public function stats($accountId)
    {
        // check sales manager  active or not
        $page_check =  $this->uri->segment(2);
        $salesManagerDeactive = $this->account()->getCompany()->getSalesManager();
        if ($salesManagerDeactive==0 && $page_check=="stats") {
             redirect('account/my_account');
        }


        $data = $this->edit_company_data();
        $account = $this->em->findAccount($accountId);
        if (!$account) {
            $this->set_error_message('Account not found!', '/');
        }

        // Permissions checks //

        // Company
        if ($this->account()->getCompanyId() !== $account->getCompanyId()) {
           // $this->set_error_message('You do not have permission to view statistics for this user', '/');
        }

        // Let full access through
        if (!$this->account()->hasFullAccess()) {

            // User can only view own
            if ($this->account()->isUser()) {
                if ($this->account()->getAccountId() !== $account->getAccountId()) {
                    $this->set_error_message('You do not have permission to view statistics for this user', '/');
                }
            }

            // Branch manager can only view branch users
            if ($this->account()->isBranchAdmin()) {
                if ($this->account()->getBranch() !== $account->getBranch()) {
                    $this->set_error_message('You do not have permission to view statistics for this user', '/');
                }
            }
        }
        $Statuses = $this->account()->getCompany()->getStatuses();
        $statusObject = [];
        $i=0;
        foreach ($Statuses as $status) { 
            $statusObject[$i]['id'] = $status->getStatusId();
            $statusObject[$i]['status_name'] = $status->getText();
            $statusObject[$i]['status_color'] = $status->getColor();
            $i++;
        }
        $data['statusObject']  = $statusObject;
        $data['account'] = $account;
        $data['config'] = $this->getSalesTargetsRepository()->getConfig($account->getCompanyId(), $accountId);
        $data['sortedAccounts'] = $this->account()->getCompany()->getActiveSortedAccounts();
        $this->html->addJS(site_url('static/js/account_stats.js'));
        $this->html->addScript('googleAjax');
        $this->html->addScript('dataTables');
        $this->html->addScript('select2');
        $this->load->view('account/account_stats', $data);
    }

    public function ajaxStats()
    {
        $account = $this->em->findAccount($this->input->post('accountId'));

        // Set proposal status filters for links
        // $this->session->set_userdata('pStatusFilterFrom', $this->input->post('from'));
        // $this->session->set_userdata('pStatusFilterTo', $this->input->post('to'));
        $this->session->set_userdata('pStatsFilterFrom', $this->input->post('from'));
        $this->session->set_userdata('pStatsFilterTo', $this->input->post('to'));

        // Retrieve and build stats
        $stats = $this->getSalesTargetsRepository()->getUserStats($account, $this->input->post('from'),
            $this->input->post('to'));
        $config = $this->getSalesTargetsRepository()->getConfig($account->getCompanyId(), $account->getAccountId());


        $stats['win_rate_readable'] = number_format($stats['win_rate'], 1);
        $stats['total_bid_readable'] = readableValue($stats['total_bid']);
        $stats['win_rate_difference'] = ($stats['win_rate'] - $config['win_rate']);
        $stats['win_rate_difference_readable'] = number_format($stats['win_rate_difference'], 1);
        $stats['amount_bid'] = $stats['weekdaysDifference'] * $config['bid_per_day_52'];
        $stats['amount_bid_readable'] = readableValue($stats['amount_bid']);
        $stats['amount_bid_difference'] = $stats['total_bid'] - $stats['amount_bid'];
        $stats['amount_bid_difference_readable'] = readableValue($stats['amount_bid_difference']);
        $stats['sales_target'] = ($config['sales_target'] / ($config['weeks_per_year'] * 5)) * $stats['weekdaysDifference'];
        $stats['sales_target_readable'] = readableValue($stats['sales_target']);
        $stats['wonCompletedProposals_readable'] = readableValue($stats['wonCompletedProposals']);
        $stats['wonCompletedProposals_difference'] = $stats['wonCompletedProposals'] - $stats['sales_target'];
        $stats['wonCompletedProposals_difference_readable'] = readableValue($stats['wonCompletedProposals_difference']);
        $stats['projected_sales'] = readableValue((260 / $stats['weekdaysDifference']) * $stats['total_bid'] * ($stats['win_rate'] / 100));
        $remainingDays = 260 - $stats['weekdaysDifference'];
        if ($remainingDays == 0) {
            $remainingDays = 1;
        }
        $weekdayDifference = ($stats['weekdaysDifference'] > 0) ? $stats['weekdaysDifference'] : 0.1;
        $totalBid = ($stats['total_bid'] <> 0) ? $stats['total_bid'] : 0.1;
        $requiredWinRate = (($config['sales_target'] - $stats['wonCompletedProposals']) * 100) / (($remainingDays * $totalBid) / $weekdayDifference);
        $stats['required_win_rate'] = number_Format(($requiredWinRate), 1);
        $ppwcl = (($config['sales_target'] - $stats['wonCompletedProposals']) / $remainingDays) * 5;
        $stats['proposals_per_week_current_levels'] = ($ppwcl >= 0) ? readableValue($ppwcl) : 0;
        $stats['config'] = $config;
        echo json_encode($stats);
    }

    public function modify_prices()
    {
        $page_check =  $this->uri->segment(2);
        $modifyPriceDeactive = $this->account()->getCompany()->getModifyPrice();
        if ($modifyPriceDeactive==0  && $page_check=="modify_prices") {
            redirect('account/my_account');
        }
        $data = $this->edit_company_data();
        $data['statuses'] = $this->account()->getCompany()->getStatuses();
        $data['layout'] = 'account/my_account/modify_prices';
        $this->load->view('account/my_account', $data);
    }

    public function modify_prices_history()
    {
        $page_check =  $this->uri->segment(2);
        $modifyPriceDeactive = $this->account()->getCompany()->getModifyPrice();
        if ($modifyPriceDeactive==0  && $page_check=="modify_prices_history") {
            redirect('account/my_account');
        }

        $data = $this->edit_company_data();
        $data['priceMods'] = $this->getCompanyRepository()->getPriceModifications($this->account()->getCompany());
        $data['layout'] = 'account/my_account/modify_prices_history';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    public function estimating()
    {
        $data = $this->edit_company_data();
        $data['categories'] = $this->getEstimationRepository()->getCompanyCategories($this->account()->getCompany());
        $data['layout'] = 'account/my_account/estimating/categories';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    public function saveEstimatingCategory()
    {
        // What we need
        $company = $this->account()->getCompany();
        $categoryId = $this->input->post('categoryId');
        $categoryName = $this->input->post('categoryName');

        // Check we have a value
        if (!$categoryName) {
            $this->session->set_flashdata('error', 'Category name cannot be blank!');
            redirect('account/estimating');
            return;
        }

        // Create a new object for new
        $category = new EstimationCategory();
        $logMessage = 'Estimating Category "' . $categoryName . '" created';

        // Load if existing
        if ($categoryId) {
            $category = $this->em->findEstimationCategory($categoryId);
            $oldName = $category->getName();
            $newName = $categoryName;
            $logMessage = 'Estimating Category "' . $oldName . '" changed to "' . $newName . '"';
        }

        // Save values
        $category->setCompanyId($company->getCompanyId());
        $category->setName($categoryName);
        $this->em->persist($category);
        $this->em->flush();

        // Log it
        $this->getLogRepository()->add([
            'action' => 'estimation_category',
            'details' => $logMessage,
            'account' => $this->account()->getAccountId(),
            'company' => $this->account()->getCompanyId()
        ]);

        // Respond
        $this->session->set_flashdata('success', 'Category Saved');
        redirect('account/estimating');
    }

    /**
     * @param $categoryId
     * Function to set a specified category as deleted
     */
    public function deleteEstimatingCategory($categoryId)
    {
        // Load the category
        $category = $this->em->findEstimationCategory($categoryId);

        // Check it loaded
        if (!$category) {
            $this->session->set_flashdata('error', 'Error Loading Category!');
            redirect('account/estimating');
            return;
        }

        // Check Permission
        if ($category->getCompanyId() != $this->account()->getCompany()->getCompanyId()) {
            $this->session->set_flashdata('error', 'You do not have permission to delete this category!');
            redirect('account/estimating');
            return;
        }

        // Passed checks, proceed to mark as deleted
        $category->setDeleted(1);
        $this->em->persist($category);
        $this->em->flush();

        // Log it
        $this->getLogRepository()->add([
            'action' => 'estimation_category',
            'details' => 'Estimation Category "' . $category->getName() . '" deleted',
            'account' => $this->account()->getAccountId(),
            'company' => $this->account()->getCompanyId()
        ]);

        // Response
        $this->session->set_flashdata('success', 'Category Deleted');
        redirect('account/estimating');
        return;
    }

    /**
     * Display the estimating types content
     */
    public function estimating_types()
    {
        $company = $this->account()->getCompany();
        $data = $this->edit_company_data();
        $data['categories'] = $this->getEstimationRepository()->getCompanyCategories($company);
        $data['types'] = $this->getEstimationRepository()->getCompanySortedTypes($company);
        $data['layout'] = 'account/my_account/estimating/types';
        $data['services'] = $company->getCategories();
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    public function saveEstimatingType()
    {
        $typeId = $this->input->post('typeId');
        $categoryId = $this->input->post('categoryId');
        $typeName = $this->input->post('typeName');

        $type = new EstimationType();
        $logMessage = 'Estimating Type "' . $typeName . '" created';

        if ($typeId) {
            $type = $this->em->findEstimationType($typeId);
            $oldName = $type->getName();
            $newName = $typeName;
            $logMessage = 'Estimating Type "' . $oldName . '" changed to "' . $newName . '"';
        }

        // Save Values
        $type->setCategoryId($categoryId);
        $type->setName($typeName);
        $type->setCompanyId($this->account()->getCompanyId());
        $this->em->persist($type);
        $this->em->flush();

        // Log it
        $this->getLogRepository()->add([
            'action' => 'estimation_type',
            'details' => $logMessage,
            'account' => $this->account()->getAccountId(),
            'company' => $this->account()->getCompanyId()
        ]);

        // Assign it to all categories
        $this->getEstimationRepository()->assignNewEstimatingType($this->account()->getCompany(), $type);

        // Respond
        $this->session->set_flashdata('success', 'Type Saved');
        redirect('account/estimating_types');
    }

    /**
     * @param $typeId
     * Function to set a specified type as deleted
     */
    public function deleteEstimatingType($typeId)
    {
        // Load the type
        $type = $this->em->findEstimationType($typeId);

        // Check it loaded
        if (!$type) {
            $this->session->set_flashdata('error', 'Error Loading Type!');
            redirect('account/estimating_types');
            return;
        }

        // Check Permission
        if ($type->getCompanyId() != $this->account()->getCompany()->getCompanyId()) {
            $this->session->set_flashdata('error', 'You do not have permission to delete this type!');
            redirect('account/estimating_types');
            return;
        }

        
        // Passed checks, proceed to mark as deleted
        $type->setDeleted(1);
        $this->em->persist($type);
        $this->em->flush();
        $this->getEstimationRepository()->clearCompanyServiceTypeAssignments($this->account()->getCompany(), $typeId);
        // Log it
        $this->getLogRepository()->add([
            'action' => 'estimation_type',
            'details' => 'Estimation Type "' . $type->getName() . '" deleted',
            'account' => $this->account()->getAccountId(),
            'company' => $this->account()->getCompanyId()
        ]);

        // Response
        $this->session->set_flashdata('success', 'Type Deleted');
        redirect('account/estimating_types');
        return;
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
            redirect('account/estimating_items');
            return;
        }

        // Passed checks, proceed to mark as deleted
        $item->setDeleted(1);
        $this->em->persist($item);
        $this->em->flush();

        $eid = new \models\EstimationItemDeleted();
        $eid->setItemId($itemId);
        $eid->setCompanyId($this->account()->getCompanyId());
        $this->em->persist($eid);
        $this->em->flush();
        
        $templateItem = $this->em->getRepository('models\EstimateTemplateItem')->findOneBy(array('item_id' => $itemId));
        if ($templateItem) {
            $this->em->remove($templateItem);
            $this->em->flush();
        }

        // Log it
        $this->getLogRepository()->add([
            'action' => 'estimation_item',
            'details' => 'Estimation Item "' . $item->getName() . '" deleted',
            'account' => $this->account()->getAccountId(),
            'company' => $this->account()->getCompanyId()
        ]);

        // Response
        $this->session->set_flashdata('success', 'Item Deleted');
        redirect('account/estimating_items');
        return;
    }

    public function estimating_items()
    {
        $company = $this->account()->getCompany();
        $er = $this->getEstimationRepository();
        
        $data = $this->edit_company_data();
        $data['categories'] = $er->getCompanyCategories($company);
        $data['sortedTypes'] = $er->getCompanySortedTypes($company);
        $data['templates'] = $er->getCompanyTemplates($company);
        $data['types'] = $er->getCompanyTypes($company);
        $data['sortedItems'] = $er->getCompanySortedItems($company);
        $data['sortedUnits'] = $er->getSortedUnits();
        $data['searchItems'] = $er->companySearchItems($company);
        $data['estimationSettings'] = $this->getEstimationRepository()->getCompanySettings($company);
        $data['updateStatuses'] = $er->getUpdateableEstimateStatuses();
        $data['page'] = 'estimating_items';
        $data['layout'] = 'account/my_account/estimating/items';
        
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
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

        // Set Minimum hours 
        $minimum_hours = $this->input->post('minimum_hours') ;

        // Set capacity to zero if blank
        $capacity = $this->input->post('itemCapacity') ?: 0;

        // Load and set default message
        if($this->input->post('itemId')){
            $item = $this->em->findEstimationItem($this->input->post('itemId'));
            $oldItem = clone $item;
            $editing = true;
        }else{
            $item = false;
        }

        $logMessage = 'Estimating Item "' . $this->input->post('itemName') . '" edited';

        // New if not loaded
        if (!$item) {
            $item = new EstimationItem();
            $logMessage = 'Estimating Item "' . $this->input->post('itemName') . '" created';
        }

        // Save it
        $item->setCompanyId($this->account()->getCompanyId());
        $item->setName($this->input->post('itemName'));
        $item->setTypeId($this->input->post('typeId'));
        $item->setTaxable($taxable);
        $item->setTaxRate($this->input->post('tax_rate'));
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
        $item->setMinimumHours($minimum_hours);

        // Flush to DB
        $this->em->persist($item);
        $this->em->flush();

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
            $this->getEstimationRepository()->EstimationItemPriceChanges($oldItem,$item,$this->account());
        }

        
        // Feedback and redirect
        $this->session->set_flashdata('success', 'Item Saved');
        if($this->input->post('page')=='estimating_price_report'){
            redirect('account/estimating_price_report');
        }else{
            redirect('account/estimating_items');
        }
        
    }

    /**
     * Page to display company estimating templates
     */
    public function estimating_templates()
    {
        $company = $this->account()->getCompany();
        $data = $this->edit_company_data();
        $data['templates'] = $this->getEstimationRepository()->getCompanyTemplates($this->account()->getCompany());
        $data['services'] = $company->getCategories();
        $data['settings'] = $this->getEstimationRepository()->getCompanySettings($company);
        $data['layout'] = 'account/my_account/estimating/templates';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    public function edit_estimating_template($templateId)
    {
        // Load the template
        $template = $this->em->findEstimationTemplate($templateId);

        // Check it loaded
        if (!$template) {
            $this->session->set_flashdata('error', 'Template could not be loaded');
            redirect('account/estimating_templates');
            return;
        }

        // Check owner
        if ($template->getCompanyId() !== $this->account()->getCompany()->getCompanyId()) {
            $this->session->set_flashdata('error', 'You do not have permission to edit this template');
            redirect('account/estimating_templates');
            return;
        }

        // Good to go, gather vars
        $data = $this->edit_company_data();
        $data['layout'] = 'account/my_account/estimating/template';
        $data['template'] =  $template;

        // Add datatables
        $this->html->addScript('dataTables');
        // Load the view
        $this->load->view('account/my_account', $data);
    }

    /**
     * Page to display default estimation settings
     */
    public function estimating_settings()
    {
        $company = $this->account()->getCompany();
        $data = $this->edit_company_data();
        $data['calculationTypes'] = $this->getEstimationRepository()->getCalculationTypes();
        $data['settings'] = $this->getEstimationRepository()->getCompanySettings($company);
        $data['layout'] = 'account/my_account/estimating/settings';
        $this->load->view('account/my_account', $data);
    }

    public function saveEstimationSettings()
    {
        $company = $this->account()->getCompany();
        $defaultOverhead = $this->input->post('defaultOverhead');
        $defaultProfit = $this->input->post('defaultProfit');
        $settingType = $this->input->post('calculationType');
        $productionRate = $this->input->post('productionRate');
        $disposalLoad = $this->input->post('disposalLoad');
        $work_order_layout_type = $this->input->post('work_order_layout_type');
        $group_template_item = ($this->input->post('group_template_item')) ? 1:0;

        $settings = $this->getEstimationRepository()->getCompanySettings($company);

        $settings->setDefaultOverhead($defaultOverhead);
        $settings->setDefaultProfit($defaultProfit);
        $settings->setCalculationType($settingType);
        $settings->setProductionRate($productionRate);
        $settings->setWorkOrderLayoutType($work_order_layout_type);
        $settings->setGroupTemplateItem($group_template_item);
        $settings->setDisposalLoad($disposalLoad);

        $this->em->persist($settings);
        $this->em->flush();

        // Feedback and redirect
        $this->session->set_flashdata('success', 'Settings Saved');
        redirect('account/estimating_settings');
    }
    
    public function saveProposalWorkOrderSettings(){
        
        $work_order_layout_type = $this->input->post('work_order_layout_type');
        $group_template_item = ($this->input->post('group_template_item')) ? 1:0;
        $proposal_id = $this->input->post('proposal_id');

        $proposal = $this->em->findProposal($proposal_id);

        $proposal->setWorkOrderLayoutType($work_order_layout_type);
        $proposal->setGroupTemplateItem($group_template_item);

        $this->em->persist($proposal);
        $this->em->flush();

        // Log it
        if($work_order_layout_type=='service_and_phase'){$type = 'Service & Phase';}elseif($work_order_layout_type=='service'){$type = 'Service';}else{$type = 'All Items'; }
        if($group_template_item){$group = ' With Template Group';}else{$group = ' Without Template Group'; }
        $this->getEstimationRepository()->addLog(
            $this->account(),
            $proposal_id,
            'update_status',
            'Work Order layout updated to '.$type . $group
        );

        $this->session->set_flashdata('success', 'Settings Saved');
        redirect('/proposals/estimate/'.$proposal_id);
    }

    public function saveProposalEstimationSettings()
    {
        $company = $this->account()->getCompany();

        $ohRate = $this->input->post('defaultOverhead');
        $pmRate = $this->input->post('defaultProfit');
        $settingType = $this->input->post('calculationType');
        $proposal_id = $this->input->post('proposal_id');
        
        $proposal = $this->em->findProposal($proposal_id);

        if($settingType=='1'){
            //Update all item //////////////////
            try {

                foreach($proposal->getServices() as $proposalService){
                    $estimate = $this->getEstimationRepository()->getProposalServiceEstimate($proposalService);

                    // Update the estimate object
                    $estimate->setOverheadRate($ohRate);
                    $estimate->setProfitRate($pmRate);
                    $this->em->persist($estimate);
                }
                $lineItems = $this->getEstimationRepository()->getAllProposalLineItems($proposal_id);

                foreach($lineItems as $lineItem) {
                    /* @var $lineItem \models\EstimationLineItem */


                    // Item unit price before PM/OH
                    $itemBaseUnitPrice = $lineItem->getBasePrice();
                    // Base Price is the new unit price * qty
                    $itemBasePrice = ($itemBaseUnitPrice * $lineItem->getQuantity());
                    // Get OH unit rate
                    $itemUnitOhRate = $itemBaseUnitPrice * ($ohRate/100);
                    // Calculate the OH price
                    $itemOhPrice = $itemBasePrice * ($ohRate/100);
                    // Get PM unit rate
                    $itemUnitPmRate = $itemBaseUnitPrice * ($pmRate/100);
                    // Calculate the PM price
                    $itemPmPrice = $itemBasePrice * ($pmRate/100);
                    // Add together and then round
                    $totalUnitPrice = ($itemBaseUnitPrice + $itemUnitOhRate + $itemUnitPmRate);
                    // Calculate pre tax price
                    $itemPreTaxPrice = ($totalUnitPrice * $lineItem->getQuantity());
                    // Calculate the tax
                    $itemTaxPrice = $itemPreTaxPrice * ($lineItem->getTaxRate() / 100);

                    // Total Price
                    $itemTotalPrice = $itemBasePrice + $itemOhPrice + $itemPmPrice + $itemTaxPrice;

                    // Update the line item
                    $lineItem->setOverheadRate(round($ohRate, 2));
                    $lineItem->setOverheadPrice(round($itemOhPrice, 2));
                    $lineItem->setProfitRate(round($pmRate, 2));
                    $lineItem->setProfitPrice(round($itemPmPrice, 2));
                    $lineItem->setUnitPrice(round($totalUnitPrice, 2));
                    $lineItem->setTaxPrice(round($itemTaxPrice, 2));
                    $lineItem->setTotalPrice(round($itemTotalPrice, 2));
                    $this->em->persist($lineItem);

                }

                $this->em->flush();



            } catch (\Exception $e) {

            }
        }
        $proposal->setEstimateCalculationType($settingType);
        if($settingType=='1'){
            $proposal->setEstimatePmRate($pmRate);
            $proposal->setEstimateOhRate($ohRate);
        }
        $this->em->persist($proposal);
        $this->em->flush();
        ////////////////////////////////
        // Log it
        if($settingType==1){$type = 'Total PM & OH';}else{$type = 'Item PM & OH ';}
        $this->getEstimationRepository()->addLog(
            $this->account(),
            $proposal_id,
            'update_status',
            'Estimate Calculation Type updated to '.$type
        );
        // Feedback and redirect
        $this->session->set_flashdata('success', 'Settings Saved');
        redirect('/proposals/estimate/'.$proposal_id);
    }

    public function saveEstimatingTemplate()
    {
       
        $templateId = $this->input->post('templateId');
        $isTemplateDuplicate = $this->input->post('isTemplateDuplicate');
        $templateName = $this->input->post('templateName');
        $calculation_type = $this->input->post('calculation_type');
        $templateType = ($this->input->post('templateType')) ? 1 : 0;
        $templateEmpty = ($this->input->post('templateEmpty')) ? 1 : 0;
        $templatePriceRate = str_replace( ',', '', $this->input->post('templateRate'));
        $templatePriceRate = str_replace( '$', '', $templatePriceRate);
        $templateOverheadRate = str_replace( '%', '', $this->input->post('templateOverheadRate'));
        $templateProfitRate = str_replace( '%', '', $this->input->post('templateProfitRate'));
        $templateOverheadPrice = str_replace( ['$', ','], ['', ''], $this->input->post('templateOverheadPrice'));
        $templateProfitPrice = str_replace( ['$', ','], ['', ''], $this->input->post('templateProfitPrice'));
        $templateBasePrice = str_replace( ['$', ','], ['', ''], $this->input->post('templateBasePrice'));
        $assignServices = false;
        $duplicateAssignServices = false;
       // $newItem = str_replace(['%', ','], ['', ''], $this->input->post('templateOverheadRate'));
        // Load or create
        if ($templateId ) {
            if($isTemplateDuplicate==1){
                $duplicateAssignServices = true;
            
                $template = new \models\EstimationTemplate();
                $template->setCompanyId($this->account()->getCompanyId());
                $template->setIsEmpty($templateEmpty);
                $oldTemplate = $this->em->findEstimationTemplate($templateId);
            }else{
                $template = $this->em->findEstimationTemplate($templateId);
            }
            
        } else {
            $assignServices = true;
            
            $template = new \models\EstimationTemplate();
            $template->setCompanyId($this->account()->getCompanyId());
            $template->setIsEmpty($templateEmpty);
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
        if($assignServices){
            $company = $this->account()->getCompany();
            foreach($company->getCategories() as $category){
                
                $eti = new \models\EstimationServiceTemplate();
                $eti->setServiceId($category->getServiceId());
                $eti->setTemplateId($template->getId());
                $eti->setCompanyId($company->getCompanyId());
                $this->em->persist($eti);
                //$this->em->flush();
            }
            $this->em->flush();
        }

        if($duplicateAssignServices){
            $allItems = $this->getEstimationRepository()->getEstimateTemplateItems($templateId);
       
            foreach($allItems as $templateItem){
                $newTemplateItem = clone  $templateItem;
                $newTemplateItem->setTemplateId($template->getId());
                $newTemplateItem->setId(NULL);
                $this->em->persist($newTemplateItem);
            }
            $this->em->flush();
            
            $company = $this->account()->getCompany();
            $serviceItems = $this->getEstimationRepository()->getAllCompanyTemplateServices($company, $templateId);
            
            foreach($serviceItems as $serviceItem){
                $newServiceItem = clone  $serviceItem;
                $newServiceItem->setTemplateId($template->getId());
                $newServiceItem->setId(NULL);
                $this->em->persist($newServiceItem);
            }
            $this->em->flush();
            $typeName =($templateType==1) ? '[Fixed]' : '[Standard]';
            $this->log_manager->add(\models\ActivityAction::COMPANY_PROPOSAL_ASSEMBLY_DUPLICATE,'"'.$oldTemplate->getName(). '" template duplicated as "'.$templateName.'" '.$typeName  );
           
        }

        // Redirect
        $this->session->set_flashdata('success', 'Template Saved');
        redirect('account/estimating_templates');
    }

    public function deleteEstimatingTemplate($templateId)
    {
        // Load the template
        $template = $this->em->findEstimationTemplate($templateId);

        // Check it loaded
        if (!$template) {
            $this->session->set_flashdata('error', 'Error loading template');
            redirect('account/estimating_templates');
            return;
        }

        // Check Permission
        if ($template->getCompanyId() !== $this->account()->getCompanyId()) {
            $this->session->set_flashdata('error', 'You do not have permission to delete this template');
            redirect('account/estimating_templates');
            return;
        }

        // Good to go, delete the item records
        //$this->getEstimationRepository()->deleteTemplateItems($template);

        // Delete the template itself

        $template->setDeleted(1);
        // Save
        $this->em->persist($template);
        $this->em->flush();

        // Redirect
        $this->session->set_flashdata('success', 'Template Deleted');
        redirect('account/estimating_templates');
    }

    public function estimating_plants()
    {
        $this->load->model('branchesapi');
        $company = $this->account()->getCompany();
        $data = $this->edit_company_data();
        $data['layout'] = 'account/my_account/estimating/plants';
        $data['plants'] = $this->getEstimationRepository()->getCompanyPlants($company);
        $data['branches'] = $this->branchesapi->getBranches($this->account()->getCompany()->getCompanyId());
        $this->load->view('account/my_account', $data);
    }

    public function estimating_dumps()
    {
        $this->load->model('branchesapi');
        $company = $this->account()->getCompany();
        $data = $this->edit_company_data();
        $data['layout'] = 'account/my_account/estimating/dumps';
        $data['dumps'] = $this->getEstimationRepository()->getCompanyDumps($company);
        $data['branches'] = $this->branchesapi->getBranches($this->account()->getCompany()->getCompanyId());
        $this->load->view('account/my_account', $data);
    }

    public function saveEstimationPlant()
    {
        $this->load->model('branchesapi');
        $plantId = $this->input->post('plantId');

        $plant = $this->em->findEstimationPlant($plantId);

        if (!$plant) {
            $plant = new EstimationPlant();
            $plant->setCompanyId($this->account()->getCompanyId());
            $plant->setDeleted(0);
        }

        // Set properties //
        $plant->setCompanyName($this->input->post('plantCompanyName'));
        $plant->setName($this->input->post('plantName'));
        $plant->setAddress($this->input->post('plantAddress'));
        $plant->setCity($this->input->post('plantCity'));
        $plant->setState($this->input->post('plantState'));
        $plant->setZip($this->input->post('plantZip'));
        $plant->setPhone($this->input->post('plantPhone'));
        $plant->setOrd(999);
        $plant->setLat($this->input->post('lat'));
        $plant->setLng($this->input->post('lng'));
        $plant->setPlant('1');
        $plantAsDump = ($this->input->post('plantAsDump')) ? 1 : 0;
        $plant->setDump($plantAsDump);
        // Save
        $this->em->persist($plant);
        $this->em->flush();



        //Auto assign all branches to current plant//
        $branchs = $this->branchesapi->getBranches($this->account()->getCompanyId());

        // Assign main branch with branch id is 0//
            $eti = new \models\EstimationBranchPlant();
            $eti->setBranchId(0);
            $eti->setPlantId($plant->getId());
            $eti->setCompanyId($this->account()->getCompanyId());
            $this->em->persist($eti);
            $this->em->flush();

        /// all branches assign to plant
        foreach ($branchs as $branch) {
            // Save New
            $eti = new \models\EstimationBranchPlant();
            $eti->setBranchId($branch->getBranchId());
            $eti->setPlantId($plant->getId());
            $eti->setCompanyId($this->account()->getCompanyId());
            $this->em->persist($eti);
            //$this->em->flush();
        }
        $this->em->flush();
        // Redirect
        $this->session->set_flashdata('success', 'Plant Saved');
        redirect('account/estimating_plants');
    }

    public function saveEstimationDump()
    {
        $this->load->model('branchesapi');
        $dumpId = $this->input->post('dumpId');

        $dump = $this->em->findEstimationPlant($dumpId);

        if (!$dump) {
            $dump = new EstimationPlant();
            $dump->setCompanyId($this->account()->getCompanyId());
            $dump->setDeleted(0);
        }
        $priceRate = str_replace(
            ['$', ','],
            ['', ''],
            $this->input->post('priceRate')
        );
        // Set properties //
        $dump->setCompanyName($this->input->post('dumpCompanyName'));
        $dump->setName($this->input->post('dumpName'));
        $dump->setAddress($this->input->post('dumpAddress'));
        $dump->setCity($this->input->post('dumpCity'));
        $dump->setState($this->input->post('dumpState'));
        $dump->setZip($this->input->post('dumpZip'));
        $dump->setPhone($this->input->post('dumpPhone'));
        $dump->setOrd(999);
        $dump->setLat($this->input->post('lat'));
        $dump->setLng($this->input->post('lng'));
        $dump->setPriceRate($priceRate);
        $dumpAsPlant = ($this->input->post('dumpAsPlant')) ? 1 : 0;
        $dump->setPlant($dumpAsPlant);
        $dump->setDump('1');

        // Save
        $this->em->persist($dump);
        $this->em->flush();

        //Auto assign all branches to current dump//
        $branchs = $this->branchesapi->getBranches($this->account()->getCompanyId());

        // Assign main branch with branch id is 0//
            $eti = new \models\EstimationBranchPlant();
            $eti->setBranchId(0);
            $eti->setPlantId($dump->getId());
            $eti->setCompanyId($this->account()->getCompanyId());
            $this->em->persist($eti);
            $this->em->flush();

        /// all branches assign to plant
        foreach ($branchs as $branch) {
            // Save New
            $eti = new \models\EstimationBranchPlant();
            $eti->setBranchId($branch->getBranchId());
            $eti->setPlantId($dump->getId());
            $eti->setCompanyId($this->account()->getCompanyId());
            $this->em->persist($eti);
            //$this->em->flush();
        }
        $this->em->flush();
        
        // Redirect
        $this->session->set_flashdata('success', 'Dump Saved');
        redirect('account/estimating_dumps');
    }

    public function deleteEstimatingPlant($plantId)
    {
        $plant = $this->em->findEstimationPlant($plantId);

        // Check it loaded
        if (!$plant) {
            $this->session->set_flashdata('error', 'Error Loading Plant!');
            redirect('account/estimating_plants');
            return;
        }

        // Check permission
        if ($plant->getCompanyId() != $this->account()->getCompanyId()) {
            $this->session->set_flashdata('error', 'You do not have permission to delete this plant');
            redirect('account/estimating_plants');
            return;
        }

        // Good to go
        $plant->setDeleted(1);
        $this->em->persist($plant);
        $this->em->flush();

        $this->session->set_flashdata('success', 'Plant Deleted');
        redirect('account/estimating_plants');
    }

    public function deleteEstimatingDump($dumpId)
    {
        $dump = $this->em->findEstimationPlant($dumpId);

        // Check it loaded
        if (!$dump) {
            $this->session->set_flashdata('error', 'Error Loading Dump!');
            redirect('account/estimating_dumps');
            return;
        }

        // Check permission
        if ($dump->getCompanyId() != $this->account()->getCompanyId()) {
            $this->session->set_flashdata('error', 'You do not have permission to delete this dump');
            redirect('account/estimating_dumps');
            return;
        }

        // Good to go
        $dump->setDeleted(1);
        $this->em->persist($dump);
        $this->em->flush();

        $this->session->set_flashdata('success', 'Dump Deleted');
        redirect('account/estimating_dumps');
    }

    public function estimating_item_upload()
    {
        $company = $this->account()->getCompany();
        $data = $this->edit_company_data();
        $data['layout'] = 'account/my_account/estimating/upload';
        $this->load->view('account/my_account', $data);
    }

    public function estimating_phases()
    {
        $company = $this->account()->getCompany();
        $data = $this->edit_company_data();
        $data['layout'] = 'account/my_account/estimating/phases';
        $data['categories'] = $categories = $this->account()->getCompany()->getCategories();
        $data['services'] = $categories = $this->account()->getCompany()->getServices(true);
        foreach ($data['services'] as $categoryId => $categoryServices) {
            foreach ($categoryServices as $categoryService) {
                $data['phases'][$categoryService->getServiceId()] = $this->getEstimationRepository()->getCompanyDefaultEstimateStages($this->account()->getCompany(), $categoryService->getServiceId());
            }
        }

        $this->load->view('account/my_account', $data);
    }

    /**
     *  Page for displaying company sub contractors
     */
    public function estimating_subs()
    {
        $company = $this->account()->getCompany();
        $data = $this->edit_company_data();
        $data['layout'] = 'account/my_account/estimating/subs';
        $data['subContractors'] = $this->getEstimationRepository()->getSubcontractors($company);
        $this->load->view('account/my_account', $data);
    }

    /**
     *  function for saving sub contractor
     */
    public function saveEstimationSub()
    {
        $subId = $this->input->post('subId');

        $sub = $this->em->findEstimateSubContractor($subId);

        if (!$sub) {
            $sub = new \models\EstimateSubContractor();
            $sub->setCompanyId($this->account()->getCompanyId());
            $sub->setDeleted(0);
        }

        // Set properties //
        $sub->setCompanyName($this->input->post('subCompanyName'));
        $sub->setAddress($this->input->post('subAddress'));
        $sub->setCity($this->input->post('subCity'));
        $sub->setState($this->input->post('subState'));
        $sub->setZip($this->input->post('subZip'));
        $sub->setPhone($this->input->post('subPhone'));
        $sub->setWebsite($this->input->post('subWebsite'));
        $sub->setOrd(999);

        // Save
        $this->em->persist($sub);
        $this->em->flush();

        // Redirect
        $this->session->set_flashdata('success', 'Sub Contractor Saved');
        redirect('account/estimating_subs');
    }

    public function deleteEstimatingSub($subId)
    {
        $sub = $this->em->findEstimateSubContractor($subId);

        // Check it loaded
        if (!$sub) {
            $this->session->set_flashdata('error', 'Error Loading Sub Contractor!');
            redirect('account/estimating_subs');
            return;
        }

        // Check permission
        if ($sub->getCompanyId() != $this->account()->getCompanyId()) {
            $this->session->set_flashdata('error', 'You do not have permission to delete this sub contractor');
            redirect('account/estimating_subs');
            return;
        }

        // Good to go
        $this->em->remove($sub);
        $this->em->flush();

        $this->session->set_flashdata('success', 'Sub Contractor Deleted');
        redirect('account/estimating_subs');
    }

    public function estimating_reports()
    {
        $data = $this->edit_company_data();
        $data['layout'] = 'account/my_account/estimating/reports/index';
        $this->load->view('account/my_account', $data);
    }

    public function job_cost_reports()
    {
        $data = $this->edit_company_data();
        $data['layout'] = 'account/my_account/job_cost_report';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    public function estimating_price_report()
    {
        $er = $this->getEstimationRepository();
        $company = $this->account()->getCompany();
       

        $data = $this->edit_company_data();
        $data['categories'] = $er->getCompanyCategories($company);
        $data['templates'] = $er->getCompanyTemplates($company);
        $data['types'] = $er->getCompanyTypes($company);
        $data['estimationSettings'] = $this->getEstimationRepository()->getCompanySettings($company);
        $data['updateStatuses'] = $er->getUpdateableEstimateStatuses();
        $data['sortedUnits'] = $er->getSortedUnits();
        $data['page'] = 'estimating_price_report';

        // Layout and view
        $data['layout'] = 'account/my_account/estimating/reports/pricing';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    public function estimating_material_report()
    {
        $this->load->model('branchesapi');
        $data = $this->edit_company_data();
        
        $data['page'] = 'estimating_material_report';
        $data['layout'] = 'account/my_account/estimating/reports/material';
        $data['categoryId'] = EstimationCategory::MATERIAL;

        // Filter Data
        $data['statusCollection'] = $this->account()->getStatuses();
        $data['branches'] = [];
        // Branches based on permission level
        if ($this->account()->hasFullAccess()) {
            $data['accounts'] = $this->account()->getCompany()->getAccounts();
            $data['branches'] = $this->branchesapi->getBranches($this->account()->getCompany()->getCompanyId());
        } else {
            if ($this->account()->isBranchAdmin()) {
                if ($this->account()->getBranch() > 0) {
                    $data['branches'][] = $this->em->findBranch($this->account()->getBranch());
                    $data['accounts'] = $this->branchesapi->getBranchAccounts($this->account()->getCompany()->getCompanyId(),
                        $this->account()->getBranch());

                } else {
                    $data['accounts'] = $this->branchesapi->getBranchAccounts($this->account()->getCompany()->getCompanyId(),
                        $this->account()->getBranch());
                }
            } else {
                $data['branches'] = [];
                $data['accounts'][] = $this->account();
            }
        }

        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    public function estimating_equipment_report()
    {
        $data = $this->edit_company_data();

        $data['page'] = 'estimating_material_report';
        $data['layout'] = 'account/my_account/estimating/reports/material';
        $data['categoryId'] = EstimationCategory::EQUIPMENT;
        $data['branches'] = [];
        // Filter Data
        $data['statusCollection'] = $this->account()->getStatuses();

        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    public function estimating_labor_report()
    {
        $data = $this->edit_company_data();

        $data['page'] = 'estimating_material_report';
        $data['layout'] = 'account/my_account/estimating/reports/material';
        $data['categoryId'] = EstimationCategory::LABOR;
        $data['branches'] = [];

        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    public function estimating_services_report()
    {
        $data = $this->edit_company_data();

        $data['page'] = 'estimating_material_report';
        $data['layout'] = 'account/my_account/estimating/reports/material';
        $data['categoryId'] = EstimationCategory::SERVICES;
        $data['branches'] = [];
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    public function estimatePricingReportData()
    {
        $company = $this->account()->getCompany();

        $tableData = [];
        $rowsData = [];
        $itemsData = $this->getEstimationRepository()->getPricingReportData($company);
        foreach ($itemsData as $dataRow) {
            $rowsData[] = $dataRow;
        }

        $tableData['sEcho'] = (int)$this->input->post('echo');
        $tableData['iTotalRecords'] = $this->getEstimationRepository()->getPricingDataCountAll($company);
        $tableData['iTotalDisplayRecords'] = $this->getEstimationRepository()->getPricingReportData($company, true);
        $tableData['aaData'] = $rowsData;

        echo json_encode($tableData);
    }

    public function estimateCategoryReportData($categoryId)
    {
        $company = $this->account()->getCompany();

        $tableData = [];
        $rowsData = [];
        $itemsData = $this->getEstimationRepository()->getCategoryReportData($company, $categoryId);
        foreach ($itemsData as $dataRow) {
            $rowsData[] = $dataRow;
        }

        $tableData['sEcho'] = (int)$this->input->post('echo');
        $tableData['iTotalRecords'] = $this->getEstimationRepository()->getCategoryReportDataCountAll($company, $categoryId);
        $tableData['iTotalDisplayRecords'] = $this->getEstimationRepository()->getCategoryReportData($company, $categoryId, true);
        $tableData['aaData'] = $rowsData;

        echo json_encode($tableData);
    }


    public function jobCostReportData()
    {
        $company = $this->account()->getCompany();

        $tableData = [];
        $rowsData = [];
       // $itemsData = [];
        $itemsData = $this->getEstimationRepository()->getJobCostReportData($company);
        //print_r($itemsData);die;
        foreach ($itemsData as $dataRow) {
            $rowsData[] = $dataRow;
        }

        $tableData['sEcho'] = (int)$this->input->post('echo');
        $tableData['iTotalRecords'] = $this->getEstimationRepository()->getJobCostReportDataCountAll($company);
        $tableData['iTotalDisplayRecords'] = $this->getEstimationRepository()->getJobCostReportData($company, true);
        $tableData['aaData'] = $rowsData;

        echo json_encode($tableData);
    }

    public function group_resends()
    {  
        $page_check =  $this->uri->segment(2);
        $proposalCampaignsDeactive = $this->account()->getCompany()->getProposalCampaigns();
        if ($proposalCampaignsDeactive==0 && $page_check=="group_resends") {
             redirect('proposals');
        }
        
        $data = $this->edit_company_data();
        $this->html->addScript('ckeditor4');
        $data['resends'] = $this->getEstimationRepository()->getCompanyResendList($this->account()->getCompany(),$this->account());
        
        
        $this->load->model('clientEmail');
        $data['clientTemplates'] = $this->clientEmail->getTemplates($this->account()->getCompany()->getCompanyId(),
            \models\ClientEmailTemplateType::PROPOSAL, true);

        $data['account'] = $this->account();
        $data['layout'] = 'account/my_account/group_resends';
        //$this->html->addScript('dataTables');


        //Proposal Table Data 
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
        
        $filteredClientAccounts = [];

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
        $data['approvalUser'] = (($this->account()->getUserClass() == 0) && $this->account()->requiresApproval());
                 
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
            $this->account()->getCompany()->getCompanyId()
        );
        $recipients = $this->db->query(
            'select * from accounts where ((userClass > 1) or (userClass=1 and branch=?) or (accountId=?)) and (company=?)',
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
        $data['tableAutomaticResend'] = true;

        $this->load->view('account/my_account/group_resends', $data);
    }

    public function group_resends_data()
    {
        $company = $this->account()->getCompany();

        $tableData = [];
        $rowsData = [];
       // $itemsData = [];
        $itemsData = $this->getEstimationRepository()->getGroupResendData($company,false,$this->account());
        //print_r($itemsData);die;
        foreach ($itemsData as $dataRow) {
            $rowsData[] = $dataRow;
        }

        $tableData['sEcho'] = (int)$this->input->post('echo');
        $tableData['iTotalRecords'] = $this->getEstimationRepository()->getGroupResendData($company, true,$this->account());
        $tableData['iTotalDisplayRecords'] = $this->getEstimationRepository()->getGroupResendData($company, true,$this->account());
        $tableData['aaData'] = $rowsData;

        echo json_encode($tableData);
    }

    

    /**
     * Page to display company estimating crews
     */
    public function estimating_crews()
    {
        $company = $this->account()->getCompany();
        $data = $this->edit_company_data();
        $data['crews'] = $this->getEstimationRepository()->getCompanyCrews($this->account()->getCompany());
        $data['services'] = $company->getCategories();
        
        $data['sortedUnits'] = $this->getEstimationRepository()->getSortedUnits();
        $data['layout'] = 'account/my_account/estimating/crews';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_account', $data);
    }

    public function saveEstimatingCrew()
    {
        // What we need
        $company = $this->account()->getCompany();
        $crewName = $this->input->post('crewName');
        $crewUnitId = $this->input->post('unitId');
        // Strip out dollar sign and commas
        $unitPrice = str_replace(
            ['$', ','],
            ['', ''],
            $this->input->post('unitPrice')
        );

        $crewBaseCost = str_replace(
            ['$', ','],
            ['', ''],
            $this->input->post('crewBaseCost')
        );

        $crewOverheadRate = str_replace(
            ['$', ',', '%'],
            ['', '', ''],
            $this->input->post('crewOverheadRate')
        );

        $crewOverheadPrice = str_replace(
            ['$', ','],
            ['', ''],
            $this->input->post('crewOverheadPrice')
        );

        $crewProfitRate = str_replace(
            ['$', ',', '%'],
            ['', '', ''],
            $this->input->post('crewProfitRate')
        );

        $crewProfitPrice = str_replace(
            ['$', ','],
            ['', ''],
            $this->input->post('crewProfitPrice')
        );
        
        $crewId = $this->input->post('crewId');

        $crew = $this->em->findEstimationCrew($crewId);

        if (!$crew) {
            $crew = new EstimationCrew();
            $crew->setCompanyId($company->getCompanyId());
            $logMessage = 'Estimating Crew "' . $crewName . '" created';
        }else{
            $logMessage = 'Estimating Crew "' . $crewName . '" Updated';
        }

        // Save values
        
        $crew->setName($crewName);
        $crew->setBasePrice($crewBaseCost);
        $crew->setUnitId($crewUnitId);
        $crew->setOverheadRate($crewOverheadRate);
        $crew->setOverheadPrice('2');
        $crew->setProfitRate($crewProfitRate);
        $crew->setProfitPrice('2');
        $crew->setTotalPrice($unitPrice);
        

        $this->em->persist($crew);
        $this->em->flush();

        // Log it
        $this->getLogRepository()->add([
            'action' => 'estimation_crew',
            'details' => $logMessage,
            'account' => $this->account()->getAccountId(),
            'company' => $this->account()->getCompanyId()
        ]);

        // Respond
        $this->session->set_flashdata('success', 'Crew Saved');
        redirect('account/estimating_crews');
    }

    function deleteEstimatingCrew($crewId){

        $crew = $this->em->findEstimationCrew($crewId);

        if (!$crew) {
            // Respond
            $this->session->set_flashdata('success', 'Crew Not found');
            redirect('account/estimating_crews');
        }

        $logMessage = 'Estimating Crew "' . $crew->getName() . '" Deleted';
        $crew->setDeleted('1');
        

        $this->em->persist($crew);
        $this->em->flush();

        // Log it
        $this->getLogRepository()->add([
            'action' => 'estimation_crew',
            'details' => $logMessage,
            'account' => $this->account()->getAccountId(),
            'company' => $this->account()->getCompanyId()
        ]);
         // Respond
         $this->session->set_flashdata('success', 'Crew Deleted');
         redirect('account/estimating_crews');
    }

    public function edit_estimating_crew($crewId)
    {
        // Load the template
        $crew = $this->em->findEstimationCrew($crewId);

        // Check it loaded
        if (!$crew) {
            $this->session->set_flashdata('error', 'Crew could not be loaded');
            redirect('account/estimating_crews');
            return;
        }

        // Check owner
        if ($crew->getCompanyId() !== $this->account()->getCompany()->getCompanyId()) {
            $this->session->set_flashdata('error', 'You do not have permission to edit this crew');
            redirect('account/estimating_crews');
            return;
        }

        // Good to go, gather vars
        $data = $this->edit_company_data();
        $data['layout'] = 'account/my_account/estimating/crew';
        $data['crew'] =  $crew;

        // Add datatables
        $this->html->addScript('dataTables');
        // Load the view
        $this->load->view('account/my_account', $data);
    }

    public function resetCompanyEstimationFeature($companyId){

        $this->getEstimationRepository()->deleteComapnyAllTemplates($companyId);
        $this->getEstimationRepository()->deleteCompanyAllItems($companyId);
        $allProposals = $this->getEstimationRepository()->getCompanyEstimatedProposals($companyId);

        foreach($allProposals as $proposal){
            // echo $proposal->getProposalId();
            // echo '<br>';
            $this->getEstimationRepository()->resetProposalEstimation($proposal);

             $proposal->setEstimateStatusId(\models\EstimateStatus::NOT_STARTED);
             $this->em->persist($proposal);
            
            
             $this->getEstimationRepository()->updateProposalEstimate($proposal,false);
        }
        $this->em->flush();
       
    }

    

    public function proposal_filters()
    {
        // $data = array();
        $data = $this->edit_company_data();
        $data['layout'] = 'account/my_account/proposal_filters';
        //$company_id =$this->account()->getCompanyId();

        //$data['proposal_filters'] = $this->db->query("SELECT s.filter_name, s.filter_page, s.filter_data, s.user_id,s.created_at, s.updated_at, s.id, s.ord, s.company_id, a.firstName, a.lastName, a.accountId FROM saved_proposal_filter s LEFT JOIN accounts a ON s.user_id = a.accountId WHERE s.filter_page = 'Proposal' AND company_id ='$company_id' Order by s.ord")->result();
        
        $data['proposal_filters'] = $this->getProposalRepository()->getProposalSavedFilters($this->account());

        //$data['client_filters'] = $this->db->query("SELECT s.filter_name, s.filter_page, s.filter_data, s.user_id,s.created_at, s.updated_at, s.id, s.ord, s.company_id FROM saved_proposal_filter s WHERE s.filter_page = 'Client' AND company_id ='$company_id' Order by s.ord")->result();

        $data['client_filters'] = $this->getClientRepository()->getClientSavedFilters($this->account());
        
        //$data['lead_filters'] = $this->db->query("SELECT s.filter_name, s.filter_page, s.filter_data, s.user_id,s.created_at, s.updated_at, s.id, s.ord, s.company_id FROM saved_proposal_filter s WHERE s.filter_page = 'Lead' AND company_id ='$company_id' Order by s.ord")->result();
        
        $data['lead_filters'] = $this->getLeadRepository()->getLeadSavedFilters($this->account());

        //$data['account_filters'] = $this->db->query("SELECT s.filter_name, s.filter_page, s.filter_data, s.user_id,s.created_at, s.updated_at, s.id, s.ord, s.company_id FROM saved_proposal_filter s WHERE s.filter_page = 'Account' AND company_id ='$company_id' Order by s.ord")->result();
        
        $data['account_filters'] = $this->getAccountRepository()->getAccountSavedFilters($this->account());

        //$data['prospect_filters'] = $this->db->query("SELECT s.filter_name, s.filter_page, s.filter_data, s.user_id,s.created_at, s.updated_at, s.id, s.ord, s.company_id FROM saved_proposal_filter s WHERE s.filter_page = 'Prospect' AND company_id ='$company_id' Order by s.ord")->result();

        $data['prospect_filters'] = $this->getProspectRepository()->getProspectSavedFilters($this->account());

        $this->load->view('account/my_account', $data);
    }

    function deleteProposalFilter($id)
    {
        $woa = $this->em->find('models\SavedProposalFilter', $id);
        if ($woa) {
            $this->em->remove($woa);
            $this->em->flush();
        }
        $this->session->set_flashdata('success', 'Filter Deleted!');
        redirect('account/proposal_filters');
    }

    function company_settings() {

        $data = $this->edit_company_data();
        //$proposalStatus = $this->em->createQuery("SELECT s.text, s.id FROM models\Status s WHERE s.company = ". $this->account()->getCompany()->getCompanyId())->getResult();
        // print_r($proposalStatus[0]['text']); die;
        $data['layout'] = 'account/my_account/company_settings';
        $data['accounts'] = $this->account()->getCompany()->getAccounts();

        $data['savedStatus'] =  $this->account()->getCompany()->getCompanySettings()->getProposalSignatureStatus();
        $data['savedWebLayout'] =  $this->account()->getCompany()->getCompanySettings()->getWebLayout();
        //$data['savedStatus'] =  '18830';
        $data['statuses'] = $this->account()->getStatuses();
        $this->load->view('account/my_account', $data);
    }

    function save_company_settings() {
        if($this->input->post('saveStatus')) {
            $status = $this->input->post('status');
            $company = $this->input->post('company');
            
            if($this->em->find('models\CompanySettings', $company)){
                $company_settings = $this->em->find('models\CompanySettings', $company);
                $company_settings->setProposalSignatureStatus($status);
                $company_settings->setUpdatedAt(time());
                
                $this->em->persist($company_settings);
                $this->em->flush();
                $this->session->set_flashdata('Status Updated Successfully');
                                redirect('account/company_settings');
            } else {
                $company_settings = new \models\CompanySettings();
                $company_settings->setCompanyId($company);
                $company_settings->setProposalSignatureStatus($status);
                $company_settings->setCreatedAt(time());
                
                $this->em->persist($company_settings);
                $this->em->flush();
                $this->session->set_flashdata('Status Saved Successfully');
                                redirect('account/company_settings');
            }
        } else {
            $this->session->set_flashdata('error', 'Something Went Wrong');
                                redirect('account/company_settings');
        }
    }


    function company_proposal_sections()
    {
        $data = $this->edit_company_data();
        $company_id = $this->account()->getCompany()->getCompanyId();
        
        $data['proposalCoolSections'] = $this->getCompanyRepository()->getCompanyProposalCoolSections($company_id);
        $data['proposalStandardSections'] = $this->getCompanyRepository()->getCompanyProposalStandardSections($company_id);
        $data['proposalCustomSections'] = $this->getCompanyRepository()->getCompanyProposalCustomSections($company_id);
        $data['layout'] = 'account/my_account/company_proposal_sections';

        $salesManagerDeactive = $this->account()->getCompany()->getSalesManager();
        if ($salesManagerDeactive==0 ) {
            $tabDeactivearr = 0; //inactive
        }else{
            $tabDeactivearr = 1; //active
        } 
        $data['checkActive']=$tabDeactivearr; 
        $this->load->view('account/my_account', $data);
    }

    /**
     * @description Set the order of Proposal Work Order for this company
     */
    public function order_company_proposal_section()
    {
        $layout = $this->input->post('layout');
        $company_id = $this->account()->getCompany()->getCompanyId();

        $types = $this->input->post('type');

        if (count($types)) {
            $i = 1;
            foreach ($types as $type) {
                
                $proposal_section = $this->em->find('\models\ProposalSectionCompanyOrder', $type);
                $proposal_section->setOrd($i);
                $this->em->persist($proposal_section);

                $i++;
            }
            $this->em->flush();
        }
        $this->log_manager->add('company_proposal_section', 'Company Proposal Section order changed', null, null, $this->account());
        $this->getCompanyRepository()->flagProposalsForRebuild($company_id);

        echo json_encode(array('error' => 0));
    }

    function hide_show_company_proposal_section(){
        
        if ($this->input->post('sectionId')) {
            $proposal_section = $this->em->find('\models\ProposalSectionCompanyOrder', $this->input->post('sectionId'));

            $proposal_section->setVisible($this->input->post('action'));
            $this->em->persist($proposal_section);
            $this->em->flush();
            
            $this->getCompanyRepository()->flagProposalsForRebuild($this->account()->getCompany()->getCompanyId());

            $this->log_manager->add('company_proposal_section', 'Company Proposal Section setting changed', null, null, $this->account());
            $data = array();
            $data['error'] = 0;
            $data['isSuccess'] = true;


            echo json_encode($data);
            die;
            
        }
    }
    

    function company_work_order_sections()
    {
        $data = $this->edit_company_data();
        $company_id = $this->account()->getCompany()->getCompanyId();
        
        $data['workOrderSections'] = $this->getCompanyRepository()->getCompanyWorkOrderSections($company_id);

        $data['workOrder'] =  $this->account()->getCompany()->getWorkOrderSetting();  

        $data['layout'] = 'account/my_account/company_work_order_sections';


        $salesManagerDeactive = $this->account()->getCompany()->getSalesManager();
        if ($salesManagerDeactive==0 ) {
            $tabDeactivearr = 0; //inactive
        }else{
            $tabDeactivearr = 1; //active
        } 
        $data['checkActive']=$tabDeactivearr; 
        $this->load->view('account/my_account', $data);
    }

    

    /**
     * @description Set the order of Proposal Work Order for this company
     */
    public function order_company_work_order_section()
    {
        $company_id = $this->account()->getCompany()->getCompanyId();

        $types = $this->input->post('type');

        if (count($types)) {
            $i = 1;
            foreach ($types as $type) {
                
                $work_order_section = $this->em->find('\models\WorkOrderSectionCompanyOrder', $type);
                $work_order_section->setOrd($i);
                $this->em->persist($work_order_section);

                $i++;
            }
            $this->em->flush();
        }
        $this->log_manager->add('company_work_order_section', 'Company Work Order Section order changed', null, null, $this->account());
        $this->getCompanyRepository()->flagProposalsForRebuild($company_id);

        echo json_encode(array('error' => 0));
    }

    

    function hide_show_company_work_order_section(){
        
        if ($this->input->post('sectionId')) {
            $work_order_section = $this->em->find('\models\WorkOrderSectionCompanyOrder', $this->input->post('sectionId'));

            $work_order_section->setVisible($this->input->post('action'));
            $this->em->persist($work_order_section);
            $this->em->flush();
            
            $this->getCompanyRepository()->flagProposalsForRebuild($this->account()->getCompany()->getCompanyId());

            $this->log_manager->add('company_work_order_section', 'Company Work Order Section setting changed', null, null, $this->account());
            $data = array();
            $data['error'] = 0;
            $data['isSuccess'] = true;


            echo json_encode($data);
            die;
            
        }
    }

    function my_super_account()
    {
        
        $data = array();
        $data['company'] = $this->account()->getCompany();
        $data['account'] = $this->account();

        $data['childCompanies'] =  $this->getCompanyRepository()->getParentChildCompanies($this->account()->getParentCompany()->getCompanyId());

        if($this->account()->getParentCompanyId()){
            
            $data['parentCompany'] = $this->em->findCompany($this->account()->getParentCompanyId());
        }else{
            
            $data['parentCompany'] = $this->account()->getCompany();
        }
        
        //$data['accounts'] = $this->account()->getCompany()->getAccounts();
        //$data['attatchments'] = $this->account()->getCompany()->getAttatchments();


       // $data = $this->edit_company_data();
        $data['accounts'] = $this->account()->getCompany()->getAccounts();
        $data['layout'] = 'account/my_super_account/company_info';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_super_account', $data);
    }

    function super_company_logo()
    {
        if($this->account()->getParentCompanyId()){
            
            $data['company'] = $this->em->findCompany($this->account()->getParentCompanyId());
        }else{
            
            $data['company'] = $this->account()->getCompany();
        }

        $data['childCompanies'] =  $this->getCompanyRepository()->getParentChildCompanies($this->account()->getParentCompany()->getCompanyId());
        
        $company = $data['company'];
        $acceptedImages = array('image/jpeg', 'image/pjpeg', 'image/jpg', 'image/png', 'image/x-png');
        if ($this->input->post('changeLogo')) {
            if ($_FILES['clientLogo']['error'] === 0) {
                if (!in_array($_FILES['clientLogo']['type'], $acceptedImages)) {
                    $this->session->set_flashdata('error', 'Only JPEG and PNG format is accepted!');
                    redirect('account/company_logo');
                } else {
                    //check if file size is larger than 500KB
                    if ($_FILES['clientLogo']['size'] > 512000) {
                        $this->session->set_flashdata('error',
                            'File size exceeds 500KB! You are not allowed to upload files larger than that.');
                        redirect('account/company_logo');
                    } else {
                        $path = UPLOADPATH . '/clients/logos/';
                        $filename = 'logo-' . $company->getCompanyId() . '.';
                        switch ($_FILES['clientLogo']['type']) {
                            case 'image/jpeg':
                                $filename .= 'jpg';
                                break;
                            case 'image/jpg':
                                $filename .= 'jpg';
                                break;
                            case 'image/pjepg':
                                $filename .= 'jpg';
                                break;
                            case 'image/png':
                                $filename .= 'jpg';
                                break;
                        }
                        $imagepath = $path . $filename;
                        if (file_exists($imagepath)) {
                            unlink($imagepath);
                        }
                        if (in_array($_FILES['clientLogo']['type'], array('image/png', 'image/x-png'))) {
                            $sizes = getimagesize($_FILES['clientLogo']['tmp_name']);
                            $w = $sizes[0];
                            $h = $sizes[1];
                            $white_bg = imagecreatetruecolor($w, $h);
                            $white = imagecolorallocate($white_bg, 255, 255, 255);
                            imagefill($white_bg, 0, 0, $white);
                            $im = imagecreatefrompng($_FILES['clientLogo']['tmp_name']);
                            imagealphablending($im, true);
                            imagealphablending($white_bg, true);
                            $out = imagecreatetruecolor($w, $h);
                            imagecopyresampled($out, $white_bg, 0, 0, 0, 0, $w, $h, $w, $h);
                            imagecopyresampled($out, $im, 0, 0, 0, 0, $w, $h, $w, $h);
                            imagejpeg($out, $imagepath);
                        } else {
                            move_uploaded_file($_FILES['clientLogo']['tmp_name'], $imagepath);
                        }
                        $company->setCompanyLogo($filename);
                        $this->em->persist($company);
                        $this->em->flush();

                        

                        //$this->log_manager->add(\models\ActivityAction::UPDATE_COMPANY_LOGO, 'Company Logo updated');
                        $this->session->set_flashdata('success', 'Company Logo updated succesfully!.');
                        redirect('account/super_company_logo');
                    }
                }
            } else {
                $this->session->set_flashdata('error',
                    'Errors have occured during the upload. Please check your file format or size of file and try again a bit later.');
                redirect('account/super_company_logo');
            }
        }
        $data['layout'] = 'account/my_super_account/logo';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_super_account', $data);
    }


    function super_company_users(){

        if($this->account()->getParentCompanyId()){
            
            $data['company'] = $this->em->findCompany($this->account()->getParentCompanyId());
        }else{
            
            $data['company'] = $this->account()->getCompany();
        }

        $data['childCompanies'] =  $this->getCompanyRepository()->getParentChildCompanies($this->account()->getParentCompany()->getCompanyId());
        
        $company = $data['company'];

        $query = $this->em->createQuery('SELECT a FROM models\Accounts a where a.company is not NULL and (a.company=' . $company->getCompanyId() . ' OR a.parent_company_id =' . $company->getCompanyId() . ') ORDER BY a.expires ASC');
        $data['accounts'] = $query->getResult();

        $data['layout'] = 'account/my_super_account/users';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_super_account', $data);
    }

    function parant_company_logo_upload()
    {
        //$data = $this->edit_company_data();
        if($this->account()->getParentCompanyId()){
            
            $data['parentCompany'] = $this->em->findCompany($this->account()->getParentCompanyId());
        }else{
            
            $data['parentCompany'] = $this->account()->getCompany();
        }
        $company = $data['parentCompany'];
        $acceptedImages = array('image/jpeg', 'image/pjpeg', 'image/jpg', 'image/png', 'image/x-png');
        if ($this->input->post('changeLogo')) {
            if ($_FILES['clientLogo']['error'] === 0) {
                if (!in_array($_FILES['clientLogo']['type'], $acceptedImages)) {
                    $data = array();
                    $data['status'] = 0;
                    $data['message'] = 'Format Incorrect';

                    echo json_encode($data);
                } else {
                    //check if file size is larger than 500KB
                    if ($_FILES['clientLogo']['size'] > 512000) {
                       
                            $data = array();
                            $data['status'] = 0;
                            $data['message'] = 'File size exceeds 500KB! You are not allowed to upload files larger than that.';
        
                            echo json_encode($data);
                    } else {
                        $path = UPLOADPATH . '/clients/logos/';
                        $filename = 'logo-' . $company->getCompanyId() . '.';
                        switch ($_FILES['clientLogo']['type']) {
                            case 'image/jpeg':
                                $filename .= 'jpg';
                                break;
                            case 'image/jpg':
                                $filename .= 'jpg';
                                break;
                            case 'image/pjepg':
                                $filename .= 'jpg';
                                break;
                            case 'image/png':
                                $filename .= 'jpg';
                                break;
                        }
                        $imagepath = $path . $filename;
                        if (file_exists($imagepath)) {
                            unlink($imagepath);
                        }
                        if (in_array($_FILES['clientLogo']['type'], array('image/png', 'image/x-png'))) {
                            $sizes = getimagesize($_FILES['clientLogo']['tmp_name']);
                            $w = $sizes[0];
                            $h = $sizes[1];
                            $white_bg = imagecreatetruecolor($w, $h);
                            $white = imagecolorallocate($white_bg, 255, 255, 255);
                            imagefill($white_bg, 0, 0, $white);
                            $im = imagecreatefrompng($_FILES['clientLogo']['tmp_name']);
                            imagealphablending($im, true);
                            imagealphablending($white_bg, true);
                            $out = imagecreatetruecolor($w, $h);
                            imagecopyresampled($out, $white_bg, 0, 0, 0, 0, $w, $h, $w, $h);
                            imagecopyresampled($out, $im, 0, 0, 0, 0, $w, $h, $w, $h);
                            imagejpeg($out, $imagepath);
                        } else {
                            move_uploaded_file($_FILES['clientLogo']['tmp_name'], $imagepath);
                        }
                        $company->setCompanyLogo($filename);
                        $this->em->persist($company);
                        $this->em->flush();

                        // Flag for rebuild
                       // $this->getCompanyRepository()->flagProposalsForRebuild($company->getCompanyId());

                        $this->log_manager->add(\models\ActivityAction::UPDATE_COMPANY_LOGO, 'Company Logo updated');
                        $data = array();
                        $data['status'] = 1;
                        $data['message'] = 'Uploaded';

                        echo json_encode($data);
                    }
                }
            } else {
                $data = array();
                $data['status'] = 0;
                $data['message'] = 'Errors have occured during the upload. Please check your file format or size of file and try again a bit later.';

                echo json_encode($data);


            }
        }
        
    }


    function edit_parent_company_info()
    {
        $data['company'] = $this->account()->getParentCompany();
        
        if ($this->input->post('updateCompany')) {
            $company = $data['company'];
            $company->setCompanyName($this->input->post('companyName'));
            $company->setCompanyAddress($this->input->post('companyAddress'));
            $company->setCompanyWebsite($this->input->post('companyWebsite'));
            $company->setCompanyPhone($this->input->post('companyPhone'));
            $company->setCompanyCity($this->input->post('companyCity'));
            $company->setCompanyState($this->input->post('companyState'));
            $company->setCompanyZip($this->input->post('companyZip'));
            $company->setAlternatePhone($this->input->post('alternatePhone'));
            $this->em->persist($company);
            $this->em->flush();
            $this->log_manager->add(\models\ActivityAction::UPDATE_COMPANY, 'Company Information Updated.');
            $this->session->set_flashdata('success', 'Company Information updated!');
            redirect('account/my_super_account');
        }
        $data['layout'] = 'account/my_super_account/edit_company_info';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_super_account', $data);
    }

    function super_edit_user()
    {
        
        
        $account = $this->em->findAccount($this->uri->segment(3));
        if (!$account) {
            $this->session->set_flashdata('error', 'Account Not found!');
            redirect('account/super_company_users');
        }
        $data = array();
        $data['company'] = $account->getCompany();
        $data['account'] = $account;
        $data['accounts'] = $account->getCompany()->getAccounts();
        $data['attatchments'] = $account->getCompany()->getAttatchments();

        $addresses = $this->em->createQuery('SELECT wa FROM models\Work_order_addresses wa WHERE wa.company=' . $account->getCompany()->getCompanyId())->getResult();
        $data['addresses'] = $addresses;

        $this->load->model('branchesapi');
        $data['branches'] = $this->branchesapi->getBranches($account->getCompany()->getCompanyId());

        $data['layouts'] = $account->getCompany()->getLayouts();
        $data['web_layouts'] = $account->getCompany()->getWebLayouts();

        $logged_account = $this->em->find('models\Accounts', $this->session->userdata('accountId'));

        


        if ($this->uri->segment(4) == 'removeSignature') {
            $sig = UPLOADPATH . '/clients/signatures/' . 'signature-' . $account->getAccountId() . '.jpg';
            @unlink($sig);
            $this->session->set_flashdata('success', 'Signature successfully removed!');
            redirect('account/super_edit_user/' . $account->getAccountId());
        }
        //signature upload
        $acceptedImages = array('image/jpeg', 'image/pjpeg', 'image/jpg', 'image/png', 'image/x-png');
        if ($this->input->post('changeSignature')) {
            if ($_FILES['clientLogo']['error'] === 0) {
                if (!in_array($_FILES['clientLogo']['type'], $acceptedImages)) {
                    $this->session->set_flashdata('error', 'Only JPEG and PNG format is accepted!');
                    redirect('account/super_edit_user/' . $account->getAccountId());
                } else {
                    //check if file size is larger than 500KB
                    if ($_FILES['clientLogo']['size'] > 512000) {
                        $this->session->set_flashdata('error',
                            'File size exceeds 500KB! You are not allowed to upload files larger than that.');
                        redirect('account/super_edit_user/' . $account->getAccountId());
                    } else {
                        $path = UPLOADPATH . '/clients/signatures/';
                        $filename = 'signature-' . $account->getAccountId() . '.';
                        switch ($_FILES['clientLogo']['type']) {
                            case 'image/jpeg':
                                $filename .= 'jpg';
                                break;
                            case 'image/jpg':
                                $filename .= 'jpg';
                                break;
                            case 'image/pjepg':
                                $filename .= 'jpg';
                                break;
                            case 'image/png':
                                $filename .= 'jpg';
                                break;
                        }
                        $imagepath = $path . $filename;
                        if (file_exists($imagepath)) {
                            unlink($imagepath);
                        }
                        if (in_array($_FILES['clientLogo']['type'], array('image/png', 'image/x-png'))) {
                            $sizes = getimagesize($_FILES['clientLogo']['tmp_name']);
                            $w = $sizes[0];
                            $h = $sizes[1];
                            $white_bg = imagecreatetruecolor($w, $h);
                            $white = imagecolorallocate($white_bg, 255, 255, 255);
                            imagefill($white_bg, 0, 0, $white);
                            $im = imagecreatefrompng($_FILES['clientLogo']['tmp_name']);
                            imagealphablending($im, true);
                            imagealphablending($white_bg, true);
                            $out = imagecreatetruecolor($w, $h);
                            imagecopyresampled($out, $white_bg, 0, 0, 0, 0, $w, $h, $w, $h);
                            imagecopyresampled($out, $im, 0, 0, 0, 0, $w, $h, $w, $h);
                            imagejpeg($out, $imagepath);
                        } else {
                            move_uploaded_file($_FILES['clientLogo']['tmp_name'], $imagepath);
                        }
                        $this->session->set_flashdata('success', 'Signature updated succesfully!.');
                        $this->log_manager->add(\models\ActivityAction::ADD_ACCOUNT,
                            'Uploaded Signature for User#' . $account->getAccountId());
                        redirect('account/super_edit_user/' . $account->getAccountId());
                    }
                }
            } else {
                $this->session->set_flashdata('error',
                    'Errors have occured during the upload. Please check your file format or size of file and try again a bit later.');
                redirect('account/super_edit_user/' . $account->getAccountId());
            }
        }

        // Save PSA data
        if ($this->input->post('savePsa')) {
            $account->setPsaEmail($this->input->post('psaEmail'));
            $account->setPsaPassword($this->input->post('psaPass'));

            $this->load->library('psa_client', ['account' => $account]);
            $responseObj = $this->psa_client->checkCredentials();

            if ($responseObj->error) {
                $this->session->set_flashdata('error',
                    '<p style="text-align: center;">Your username or password for ProSiteAudit is incorrect.</p><br /><p style="text-align: center;"><a href="https://my.prositeaudit.com/account/forgot" target="_blank">Click here</a> to change your password</p>');
                redirect('account/super_edit_user/' . $account->getAccountId());
            } else {
                $this->em->persist($account);
                $this->em->flush();
                $this->log_manager->add(\models\ActivityAction::EDIT_ACCOUNT,
                    'Account #' . $account->getAccountId() . ' (' . $account->getFullName() . ') ProSiteAudit Credentials Update!');
                $this->session->set_flashdata('success', 'ProSiteAudit Credentials updated successfully!');
            }

            redirect('account/super_company_users');
        }

        //saving user data
        if ($this->input->post('save')) {

            //check if name/email has been changed
            if (($account->getFirstName() != $this->input->post('firstName')) || ($account->getLastName() != $this->input->post('lastName')) || ($account->getEmail() != $this->input->post('email'))) {
                $message = '<b>Old user information:</b><br><br>
                <b style="width: 100px; text-align: right; display: block; float: left; margin-right: 5px;">First Name:</b> ' . $account->getFirstName() . '<br>
                <b style="width: 100px; text-align: right; display: block; float: left; margin-right: 5px;">Last Name:</b> ' . $account->getLastName() . '<br>
                <b style="width: 100px; text-align: right; display: block; float: left; margin-right: 5px;">Email:</b> ' . $account->getEmail() . '<br><br>
                <b>New user information:</b><br><br>
                <b style="width: 100px; text-align: right; display: block; float: left; margin-right: 5px;">First Name:</b> ' . $this->input->post('firstName') . '<br>
                <b style="width: 100px; text-align: right; display: block; float: left; margin-right: 5px;">Last Name:</b> ' . $this->input->post('lastName') . '<br>
                <b style="width: 100px; text-align: right; display: block; float: left; margin-right: 5px;">Email:</b> ' . $this->input->post('email') . '<br>';
                $this->load->model('system_email');
                $emailData = array(
                    'first_name' => $this->account()->getCompany()->getAdministrator()->getFirstName(),
                    'last_name' => $this->account()->getCompany()->getAdministrator()->getLastName(),
                    'new_information' => $message,
                );
                $this->system_email->categories = array('User', 'Edit User');
                $this->system_email->uniqueArgs = array('user' => $account->getAccountId());
                $this->system_email->sendEmail(2, $this->account()->getCompany()->getAdministrator()->getEmail(),
                    $emailData);

            }
            //check if the email is changed...
            if ($this->input->post('email') != $account->getEmail()) {
                $testAcc = $this->em->getRepository('models\Accounts')->findOneBy(array('email' => $this->input->post('email')));
                if ($testAcc) {
                    $this->session->set_flashdata('error', 'Email already in use!');
                    redirect('account/super_edit_user/' . $this->uri->segment(3));
                } else {
                    $account->setEmail($this->input->post('email'));
                    $this->load->model('system_email');
                    $emailData = array(
                        'new_email' => $this->input->post('email'),
                        'first_name' => $account->getFirstName(),
                        'last_name' => $account->getLastName(),
                    );
                    $this->system_email->categories = array('User', 'Email Change');
                    $this->system_email->uniqueArgs = array('user' => $account->getAccountId());
                    $this->system_email->sendEmail(1, $this->input->post('email'), $emailData);
                }
            }
            //check if the user is trying to imput limited access to admin user
            if (($this->input->post('fullAccess') == 'no') && ($account->isAdministrator(true))) {
                //                $this->session->set_flashdata('notice', 'The Administrator user account can not have limited access!');
            } else {
                $account->setFullAccess($this->input->post('fullAccess'));
            }
            //check if a new password is set up
            if ($this->input->post('password')) {
                $account->setPassword($this->input->post('password'));
                $emailData = array(
                    'first_name' => $account->getFirstName(),
                    'last_name' => $account->getFirstName(),
                    'password' => $this->input->post('password'),
                    'email' => $account->getEmail(),
                );
                $this->load->model('system_email');
                $this->system_email->categories = array('User', 'Password Change');
                $this->system_email->uniqueArgs = array('user' => $account->getAccountId());
                $this->system_email->sendEmail(3, $account->getEmail(), $emailData);
                $this->log_manager->add(\models\ActivityAction::CHANGE_PASSWORD, 'User succesfully changed password.');
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
            $account->setOfficePhone($this->input->post('officePhone'));
            $account->setOfficePhoneExt($this->input->post('officePhoneExt'));
            $account->setFax($this->input->post('fax'));
            $account->setBranch($this->input->post('branch'));
            $account->setWorkOrderAddress($this->input->post('work_order_address'));
            $account->setProposalEmailCC(($this->input->post('proposal_email_cc'))? 1 : 0 );
            
            if ($this->input->post('sales_report_emails')) {
                $account->setSalesReportEmails($this->input->post('sales_report_emails'));
            }else{
                $account->setSalesReportEmails(0);
            }
            if ($this->input->post('email_frequency')) {
                $account->setEmailFrequency($this->input->post('email_frequency'));
            }else{
                $account->setEmailFrequency(0);
            }

            $secretaryInput = $this->input->post('secretary');

            // Only update the secretary value if there is one
            if ($secretaryInput !== false) {
                $secretary = ($secretaryInput) ? 1 : 0;
                $account->setSecretary($secretary);
            }

            $account->setRequiresApproval($this->input->post('requiresApproval'));
            $account->setLayout($this->input->post('layout'));
            // Clean out any commas and save the approval amount value
            $approvalAmount = removePriceFormatting($this->input->post('approvalAmount'));
            $account->setApprovalAmount($approvalAmount);
            if ($this->input->post('useDefaultApproval')) {
                $useDefaultApproval = 1;
            } else {
                $useDefaultApproval = 0;
            }
            $account->setDefaultApproval($useDefaultApproval);
            $account->setSales($this->input->post('sales'));

            // Only update Wio if there is a value
            $wio = $this->input->post('wio');
            if ($wio === '0' || $wio === '1') {
                $account->setWio($wio);
            }

            // Save the old user class to check if changed
            $oldUserClass = $account->getUserClass();
            // Set the new class
            $account->setUserClass($this->input->post('user_class'));

            // Do the user class check if a user class was posted
            if ($oldUserClass <> $account->getUserClass()) {
                $account->setUserClass($this->input->post('user_class'));
                $permissions = array(
                    '0' => 'User',
                    '1' => 'Branch Manager',
                    '2' => 'Full Access',
                    '3' => 'Adminstrator',
                    '4' => 'Adminstrator',
                );
                $class = ($permissions[$this->input->post('user_class')]) ? $permissions[$this->input->post('user_class')] : 'User';
                $message = 'Your new user class is <b>' . $class . '</b>.';
                $this->load->model('system_email');
                $this->system_email->categories = array('User', 'Privilege Change');
                $this->system_email->uniqueArgs = array('user' => $account->getAccountId());
                $this->system_email->sendEmail(4, $account->getEmail(), array('privilege_message' => $message));
            }

            // Check to see if they are the assigned user for leads
            // Only do it if the user class is below admin
            if ($account->getUserClass() < 3) {
                $notificationRepo = $this->getLeadNotificationsRepository();
                $notificationSettings = $notificationRepo->getLeadNotificationSettings($this->account()->getCompany()->getCompanyId());
                $notificationAccount = $notificationSettings->account;

                // Check to see if this use is the assigned recipient
                if ($account->getAccountId() == $notificationAccount) {
                    // Switch it over to the company admin if so
                    $notificationData = [
                        'enabled' => $notificationSettings->enabled,
                        'instant' => $notificationSettings->instant,
                        'account' => $this->account()->getCompany()->getAdministrator()->getAccountId(),
                        'company' => $notificationSettings->company,
                        'notificationIntervals' => $notificationSettings->notificationIntervals,
                    ];
                    $this->db->delete('lead_notification_settings',
                        array('company' => $this->account()->getCompany()->getCompanyId()));
                    $this->db->insert('lead_notification_settings', $notificationData);
                    $logMessage = 'Updated Lead Notification Settings Automatically Updated: Recipient changed to ' . $this->account()->getCompany()->getAdministrator()->getEmail();
                    $this->getLogRepository()->add([
                        'action' => 'updated_lead_notification_settings',
                        'details' => $logMessage,
                        'account' => $this->account()->getAccountId()
                    ]);
                }
            }

            $account->setDisableProposalNotifications($this->input->post('disable_proposal_notifications'));
            if ($this->input->post('disabled') && $account->getDisabled() != $this->input->post('disabled')) {
                $this->log_manager->add(\models\ActivityAction::UPDATE_COMPANY,
                    'Account #' . $account->getAccountId() . ' (' . $account->getFullName() . ') Disabled.');
            }
            $account->setDisabled($this->input->post('disabled'));
            if ($logged_account->isGlobalAdministrator()) {
                $expDate = explode('/', $this->input->post('expires'));
                $expires = mktime(23, 59, 59, $expDate[0], $expDate[1], $expDate[2]);
                $account->setExpires($expires);
                 // Add code for child expires updation Start
                 $this->db->select('a.accountId');
                 $this->db->from('accounts a');
                 $this->db->where_in('a.parent_user_id', $account->getAccountId());
                 $query = $this->db->get();
                 $result = $query->result_array();
                 if(!empty($result)){
                     $accountIds = array_column($result, 'accountId');
                      // Add code for child expires updation Start
                         $this->db->set('expires', $expires);
                         $this->db->where_in('accountId', $accountIds);
                         $this->db->update('accounts');
                         // Add code for child expires updation End
                 }
                 // Add code for child expires updation  End


            }
            $account->setEstimating($this->input->post('estimating'));
            $account->setEditPrice($this->input->post('edit_prices'));
            $this->em->persist($account);

            $this->em->flush();

            //Delete user query Cache
            $this->getQueryCacheRepository()->deleteCompanyUserAllCache($this->account()->getCompanyId());

            // Flag proposals to be rebuilt
            $this->getCompanyRepository()->flagAccountProposalsForRebuild($account->getAccountId());

            // Update the company subscription
            if (($this->account()->getCompany()->isActive()) && $this->account()->getCompany()->shouldUpdateZS()) {
                $cr = $this->getCompanyRepository();
                $cr->updateSubscriptions($this->account()->getCompany());
            }

            $this->log_manager->add(\models\ActivityAction::COMPANY_EDIT_USER,
                'Account #' . $account->getAccountId() . ' (' . $account->getFullName() . ') information updated succesfully!');
            $this->session->set_flashdata('success', 'User updated succesfully!');
            redirect('account/super_company_users');
        }
        $data['user'] = $account;

        $data['logged_account'] = $logged_account;
        $data['account'] = $this->account();
        $data['layout'] = 'account/my_super_account/super_edit_user';
        $this->html->addScript('dataTables');
        $this->load->view('account/my_super_account', $data);
    }

    function delete_super_user()
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
        redirect('account/super_company_users/');
    }

    
    function company_setting()
    {
        $data = $this->edit_company_data();
        $data['accounts'] = $this->account()->getCompany()->getAccounts();
        $data['layout'] = 'account/my_account/company_info';
        $this->html->addScript('dataTables');
        $this->load->view('account/company_setting', $data);
    }

    
    function proposal_setting()
    {
        $data = $this->edit_company_data();
        $data['accounts'] = $this->account()->getCompany()->getAccounts();
        $data['layout'] = 'account/my_account/company_info';
        $this->html->addScript('dataTables');
        $this->load->view('account/proposal_setting', $data);
    }

    function user_role()
    {
        $data = $this->edit_company_data();
        $data['layout'] = 'account/my_account/work_order';
        $addresses = $this->em->createQuery('SELECT wa FROM models\Work_order_addresses wa WHERE wa.company=' . $this->account()->getCompany()->getCompanyId())->getResult();
        $data['addresses'] = $addresses;
        $this->load->view('account/my_account', $data);
 
  
    }

    function work_order_setting_update(){
         if ($this->input->post('workOrderSetting')==0 || ($this->input->post('workOrderSetting')==1)) {
            $data['company'] = $this->account()->getCompany();
            $company = $data['company'];
            $company->setWorkOrderSetting($this->input->post('workOrderSetting'));
            $this->em->persist($company);
            $this->em->flush();            
            //$this->getCompanyRepository()->flagProposalsForRebuild($this->account()->getCompany()->getCompanyId());
          //  $this->log_manager->add('company_work_order_section', 'Company Work Order Section setting changed', null, null, $this->account());
            $data = array();
            $data['error'] = 0;
            $data['isSuccess'] = true;
            echo json_encode($data);
            die;
            
        } 
    }


    public function update_lead_source()
    {
        try {
            if ($this->input->post('action') === 'update') {
                $sourceId = $this->input->post('sourceId');
                $newName = $this->input->post('newName');
                $lead_source = $this->em->find('models\LeadSource', $sourceId);
                $lead_source->setName($newName);
                $this->getLogRepository()->add([
                'action' => \models\ActivityAction::LEAD_SETTINGS,
                'details' => "Lead source updated successfully with $newName",
                'account' => $this->account()->getAccountId(),
                'company' => $this->account()->getCompanyId()
                ]);
                $this->em->persist($lead_source);
                $this->em->flush();
                echo json_encode(['success' => true, 'message' => 'Lead source updated successfully.']);
            }
            }catch (\Exception $e) {
                // Handle exceptions and errors
                echo json_encode(['error' => 'Failed to update lead source: ' . $e->getMessage()]);
            }
    }
    
}
