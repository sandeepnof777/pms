<?php
use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;

class Home extends MY_Controller {

    ### Extended CI_Controller /application/core/MY_Model.php
    /**
     * @var Log_manager
     */
    var $log_manager;
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    var $em;
    /**
     * @var System_email
     */
    var $system_email;

    function  __construct() {
        parent::__construct();
 
    }

    function index() {
        if ($this->session->userdata('logged')) {
            header('Location: ' . site_url('account'));
        } else {
            header('Location: ' . site_url('home/signin'));
        }
        $this->load->view('global/header');
        $this->load->view('home');
        $this->load->view('global/footer');
    }

    function testpms()
    {
                 $this->_ci = &get_instance();
                $this->_ci->load->library('redis');
                $this->_ci->redis->flushAll();
   
     }

    function signin() {
        $data = [];
        $data['remember_email'] = $this->input->cookie('remember_email') ?: '';
        if ($this->session->userdata('logged')) {
            redirect('account');
        }
        if ($this->input->post('email')) {
            $account = $this->em->getRepository('models\Accounts')->findOneBy(array('email' => $this->input->post('email'), 'password' => md5($this->input->post('password'))));
            if (!$account) {
                $this->session->set_flashdata('error', 'Wrong Username/Password Combination!');
                redirect('home/signin');
            } else {
                $this->session->set_userdata(array('logged' => 1, 'accountId' => $account->getAccountId()));
                $this->log_manager->add(\models\ActivityAction::LOGIN, 'User succesfully logged in.');
                if ($this->input->post('remember')) {
                    $token = md5(time());
                    $account->setToken($token);
                    $account = $this->em->merge($account);
                    $this->em->persist($account);
                    $this->em->flush();
                    $this->em->clear();
                    $cookie = array(
                        'name' => 'auth_token',
                        'value' => $token,
                        'expire' => 432000
                    );
                    $this->input->set_cookie($cookie);
                }
                redirect('account');
            }
        }
        $this->load->view('signin', $data);
    }

    function signup() {
        $this->load->view('signup-stripe');
    }

    function signup_trial() {
        $this->load->view('signup-trial');
    }

    function stripe_payment() {
        $this->load->library('Stripe_lib');
        Stripe::setApiKey(STRIPE_SECRET_KEY); //Mike Live
//        Stripe::setApiKey("GKWZtL4KqIgIiUcl2MR82MjzHjjof2Ig"); //chris test
//        Stripe::setApiKey("lBK62sUZHFCxHGXKGelFHVNDukXQUlAV"); //mike test

        $ignoreBots = isset($_POST['ignoreBots']);
        if (!$ignoreBots) {
            $resp = [];
            $resp['error'] = 'There was an error in processing your card information. Please review and try again later!';
            return;
        }

        $token = $_POST['stripeToken'];
        $company = $_POST['company'];
        $name = $_POST['name'];
        $email = $_POST['email'];
        $price = $_POST['custom'];
        $isCustom = false;


        $chargeDescription = "Payment for {$company} - {$name} - {$email}";

        if ($isCustom) {
            $chargeDescription = "Custom Payment: {$company} - {$name} - {$email}";
        }

        $stripe_charge = array(
            "amount" => $price * 100, // amount in cents, again
            "currency" => "usd",
            "card" => $token,
            "description" => $chargeDescription
        );
//        mail('chris@rapidinjection.com', 'stripe debug', print_r($stripe_charge, true));             q
        try {
            $charge = Stripe_Charge::create($stripe_charge);
        } catch (Exception $e) {
            $charge = array();
        }
        $resp = array();
        $headers = "From: PL Purchases <no-reply@".SITE_EMAIL_DOMAIN.">";
        mail('info@'.SITE_EMAIL_DOMAIN, 'PMS Payment Details', "Client Details:\n" . print_r($_POST, true) . "\n\nPayment Details:\n" . print_r($charge, true), $headers);
        if (@$charge['paid']) {
            $resp['success'] = true;
        } else {
            $resp['error'] = 'There was an error in processing your card information. Please review and try again later!';
        }
        echo json_encode($resp);
    }

    function recover_password() {
        if ($this->input->post('email')) {
            $account = $this->em->getRepository('models\Accounts')->findOneByEmail($this->input->post('email'));
            /* @var $account \models\Accounts */
            if ($account) {
                $this->session->set_userdata('recoveremail', $account->getEmail());
                $this->session->set_userdata('cellphone', $account->getCellPhone());

                 redirect('home/send_varification_code');

            }
            else {
                 $this->session->set_flashdata('error', 'Email not found in the database!');
                redirect('home/recover_password');
            }
        }

        $this->load->view('recover_password');
    }

    public function password_reset($recoverKey) {

        $data['new'] = false;
        $data['buttonText'] = 'Reset Password';

        if ($this->uri->segment(4) == 'new') {
            $data['new'] = true;
            $data['buttonText'] = 'Create Password';
        }

        $account = $this->em->getRepository('models\Accounts')->findOneBy(['recovery_code' => $recoverKey]);
        /* @var $account \models\Accounts */
        
        if (!$account) {
            //echo 'Recover Key not recognized';
            $data['user'] =0;
        }
        else {
            if ($this->input->post('password')) {

                $account->setPassword($this->input->post('password'));
                $account->setRecoveryCode('');
                $this->em->persist($account);
                $this->em->flush();
                $this->log_manager->add('reset_password', 'Password reset for ' . $account->getFullName());
                $account->confirmPasswordChanged();

                $this->session->set_flashdata('success', 'Your password has been reset! You can now log in using your new password.');
                redirect('home/signin');
            }
            $data['user'] =1;
        }
        $this->load->view('reset-password',$data);
    }

    function create_account() {
        if (count($_POST)) {
            $message = "Client Information:\n\n";
            foreach ($_POST as $key => $value) {
                $message .= "{$key} = {$value}\n<br>";
            }
            $subject = 'Website New Account';
            $headers = "From: New Account ".SITE_NAME." <no-reply@".SITE_EMAIL_DOMAIN.">\r\n";
            mail('chris@rapidinjection.com', $subject, $message, $headers);
            mail('barrettmjb@gmail.com', $subject, $message, $headers);
            header('Location: '.site_url().'/thank-you');
        } else {
        }
    }

    function check_email() {
        $response = array();
        $testAcc = $this->em->getRepository('models\Accounts')->findOneBy(array('email' => $this->input->post('email')));
        if ($testAcc) {
            $response['used'] = true;
        }
        echo json_encode($response);
    }

    /**
     * Create trial main JSON function
     */
    // function create_trial_account() {
    //     $resp = array();
    //     $testAcc = $this->em->getRepository('models\Accounts')->findOneBy(array('email' => $this->input->post('email')));
    //     if ($testAcc) {
    //         $resp['error'] = 'Email already used! If you don\'t remember signing up, please contact us at <a href="mailto:contact@'.SITE_EMAIL_DOMAIN.'">contact@'.SITE_EMAIL_DOMAIN.'</a>';
    //     } else {
    //         if (!count($_POST)) {
    //             $resp['error'] = 'No information provided! Please fill in the form and try again!';
    //         } else {
    //              $captcha_response = trim($this->input->post('g-recaptcha-response'));
    //              $keySecret = '6LfMFiApAAAAAOeYLqvi2c8s0xtg6LZDd_Nm_Z7f';

    //             $check = array(
    //                 'secret'		=>	$keySecret,
    //                 'response'		=>	$this->input->post('g-recaptcha-response')
    //             );

             

    //             $startProcess = curl_init();

    //             curl_setopt($startProcess, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    //             curl_setopt($startProcess, CURLOPT_POST, true);
    //             curl_setopt($startProcess, CURLOPT_POSTFIELDS, http_build_query($check));
    //             curl_setopt($startProcess, CURLOPT_SSL_VERIFYPEER, false);
    //             curl_setopt($startProcess, CURLOPT_RETURNTRANSFER, true);
    //             $receiveData = curl_exec($startProcess);
    //             $finalResponse = json_decode($receiveData, true);
  
    //             $account = new models\Accounts();
    //             $company = new models\Companies();
    //             $company->setCompanyName($this->input->post('company'));
    //             $company->setCompanyCountry('USA');
    //             $company->setCompanyAddress($this->input->post('companyAddress'));
    //             $company->setCompanyCity($this->input->post('companyCity'));
    //             $company->setCompanyPhone($this->input->post('companyFax'));
    //             $company->setCompanyState($this->input->post('companyState'));
    //             $company->setCompanyPhone($this->input->post('companyPhone'));
    //             $company->setAlternatePhone($this->input->post('cellPhone'));
    //             $company->setCompanyZip($this->input->post('companyZip'));
    //             $company->setCompanyWebsite($this->input->post('website'));
    //             $company->setCompanyLogo('');
    //             $company->setHearAboutUs('Trial Account');
    //             $company->setAdministrator($account);
    //             $company->setCompanyStatus('Trial');
    //             $expires = time() + 14 * 86400;
    //             $account->setEmail($this->input->post('email'));
    //             $account->setRecoveryCode();
    //             $account->setFirstName($this->input->post('firstName'));
    //             $account->setLastName($this->input->post('lastName'));
    //             $account->setCountry('USA');
    //             $account->setCity($this->input->post('companyCity'));
    //             $account->setState($this->input->post('companyState'));
    //             $account->setTitle($this->input->post('title'));
    //             $account->setCellPhone($this->input->post('cellPhone'));
    //             $account->setOfficePhone($this->input->post('cellPhone'));
    //             $account->setAddress($this->input->post('companyAddress'));
    //             $account->setZip($this->input->post('companyZip'));
    //             $account->setTimeZone('EST');
    //             $account->setCompany($company);
    //             $account->setFullAccess('yes');
    //             $account->setCreated(time());
    //             $account->setExpires($expires);
    //             $account->setSales(1);
    //             $account->unDelete();
    //             if($finalResponse['success'])
    //             {
    //                 $this->em->persist($account);
    //                 $this->em->persist($company);
    //                 $this->em->flush();
    //             }             

    //             $job_array = $_POST;
    //             $job_array['company_id'] = $company->getCompanyId();
    //             $this->load->library('jobs');
        
    //             // Save the opaque image
    //             if($finalResponse['success'])
	// 		      {
    //                   $this->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'trail_account_process',$job_array,'test job');
    //               }

    //             $resp['success'] = true;

                
    //             /*
    //              * ZoHo Start
    //              */
    //             $zohoMsg = '';

    //             // ZCRMRestClient::initialize([
    //             //     'client_id' => ZOHO_CRM_USER,
    //             //     'client_secret' => ZOHO_CRM_CLIENT_SECRET,
    //             //     'redirect_uri' => site_url(),
    //             //     'currentUserEmail' => 'mike@pavementlayers.com',
    //             //     'token_persistence_path' => ROOTPATH . '/application/config',
    //             //     "apiBaseUrl" => "www.zohoapis.com",
    //             //     "apiVersion"=>"v2"
    //             // ]);

    //            // $moduleInstance = ZCRMRestClient::getInstance()->getModuleInstance("Leads");
    //             $records = [];

    //            // $leadRecord = ZCRMRecord::getInstance("leads", null);
    //             // $leadRecord->setFieldValue('First_Name', $this->input->post('firstName'));
    //             // $leadRecord->setFieldValue('Last_Name', $this->input->post('lastName'));
    //             // $leadRecord->setFieldValue('Designation', $this->input->post('title'));
    //             // $leadRecord->setFieldValue('Phone', $this->input->post('companyPhone'));
    //             // $leadRecord->setFieldValue('Mobile', $this->input->post('cellPhone'));
    //             // $leadRecord->setFieldValue('Email', $this->input->post('email'));
    //             // $leadRecord->setFieldValue('Company', $this->input->post('company'));
    //             // $leadRecord->setFieldValue('Address_1', $this->input->post('companyAddress'));
    //             // $leadRecord->setFieldValue('City', $this->input->post('companyCity'));
    //             // $leadRecord->setFieldValue('State', $this->input->post('companyState'));
    //             // $leadRecord->setFieldValue('Zip_Code',  $this->input->post('companyZip'));
    //             // $leadRecord->setFieldValue('Website', $this->input->post('website'));
    //             // $leadRecord->setFieldValue('Lead_Source', 'Automatic Trial SignUp');
    //             // $leadRecord->setFieldValue('Temperature', 'Med - Interested');
    //             // $leadRecord->setFieldValue('Rating', 'Silver 1-4 users');

    //             // Add records to instance and send via API
    //            // $records[] = $leadRecord;
                
    //             // try {
    //             //     if($finalResponse['success'])
    //             //     {
    //             //         $insert = $moduleInstance->createRecords($records);
    //             //     }
    //             // } catch (ErrorException $e) {
    //             //     $zohoMsg = $e->getMessage();
    //             // }

    //             /*
    //              * ZoHo End
    //              */
    //             $this->em->flush();
    //             $resp['success'] = true;

    //             // Set up lead notification settings
    //             $this->getLeadNotificationsRepository()->setDefaultNotificationSettings($company);

    //             // Set up default sales config
    //             $str = $this->getSalesTargetsRepository();
    //             $str->createDefaultConfig($company->getCompanyId());
    //             if($finalResponse['success'])
    //             {
    //                 $account->sendTrialSignupEmail();
    //             }

    //             sleep(1.5); //delay so the emails don't get too scrambled.
    //             populateCompany($company->getCompanyId());
    //             //message for chris and mike with the users information
    //             // $message2 = 'Account information:<br>';

    //             // $message2 .= "<b>Company:</b> " . $_POST['company'] . "<br />
    //             //         <b>First Name:</b> " . $_POST['firstName'] . "<br />
    //             //         <b>Last Name:</b> " . $_POST['lastName'] . "<br />
    //             //         <b>Email:</b> " . $_POST['email'] . "<br />
    //             //         <b>Title:</b> " . $_POST['title'] . "<br />
    //             //         <b>Cell Phone:</b> " . $_POST['cellPhone'] . "<br />
    //             //         <b>Website:</b> " . $_POST['website'] . "<br />
    //             //         <b>Company Phone:</b> " . $_POST['companyPhone'] . "<br />
    //             //         <b>Company Fax:</b> " . $_POST['companyFax'] . "<br />
    //             //         <b>Company Address:</b> " . $_POST['companyAddress'] . "<br />
    //             //         <b>Company City:</b> " . $_POST['companyCity'] . "<br />
    //             //         <b>Company State:</b> " . $_POST['companyState'] . "<br />
    //             //         <b>Company Zip:</b> " . $_POST['companyZip'].'<br /> <br /> Also, the account was added as a lead automatically into ZoHo';

    //             // $subject = 'New Trial Account on '.SITE_NAME;
    //             // $content = $message2 . $zohoMsg;

    //             // $emailData = [
    //             //     'to' => 'support@' . SITE_EMAIL_DOMAIN,
    //             //     'fromName' => SITE_NAME,
    //             //     'fromEmail' => 'no-reply@' . SITE_EMAIL_DOMAIN,
    //             //     'subject' => $subject,
    //             //     'body' => $content,
    //             //     'categories' => ['Trial Signup'],
    //             // ];
                
    //             // if($finalResponse['success'])
    //             // {
    //             //     $this->getEmailRepository()->send($emailData);
    //             //     $this->getSendgridRepository()->updateAddressWhitelist();
    //             // }
    //         }
    //     }
    //     echo json_encode($resp);
    // }

    function create_trial_account() {

        $captcha_response = trim($this->input->post('g-recaptcha-response'));
         if($captcha_response != '')
		{
                $keySecret = '6LfMFiApAAAAAOeYLqvi2c8s0xtg6LZDd_Nm_Z7f';
              // $keySecret = RECAPTCHA_SECRET;
			$check = array(
				'secret'		=>	$keySecret,
				'response'		=>	$this->input->post('g-recaptcha-response')
			);
			$startProcess = curl_init();
			curl_setopt($startProcess, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
			curl_setopt($startProcess, CURLOPT_POST, true);
			curl_setopt($startProcess, CURLOPT_POSTFIELDS, http_build_query($check));
			curl_setopt($startProcess, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($startProcess, CURLOPT_RETURNTRANSFER, true);
			$receiveData = curl_exec($startProcess);
			$finalResponse = json_decode($receiveData, true);
             if($finalResponse['success'])
			{

        $resp = array();
        $testAcc = $this->em->getRepository('models\Accounts')->findOneBy(array('email' => $this->input->post('email')));
        if ($testAcc) {
            $resp['error'] = 'Email already used! If you don\'t remember signing up, please contact us at <a href="mailto:contact@'.SITE_EMAIL_DOMAIN.'">contact@'.SITE_EMAIL_DOMAIN.'</a>';
        } else {
            if (!count($_POST)) {
                $resp['error'] = 'No information provided! Please fill in the form and try again!';
            } else {
                $account = new models\Accounts();
                $company = new models\Companies();
                $company->setCompanyName($this->input->post('company'));
                $company->setCompanyCountry('USA');
                $company->setCompanyAddress($this->input->post('companyAddress'));
                $company->setCompanyCity($this->input->post('companyCity'));
                $company->setCompanyPhone($this->input->post('companyFax'));
                $company->setCompanyState($this->input->post('companyState'));
                $company->setCompanyPhone($this->input->post('companyPhone'));
                $company->setAlternatePhone($this->input->post('cellPhone'));
                $company->setCompanyZip($this->input->post('companyZip'));
                $company->setCompanyWebsite($this->input->post('website'));
                $company->setCompanyLogo('');
                $company->setHearAboutUs('Trial Account');
                $company->setAdministrator($account);
                $company->setCompanyStatus('Trial');
                $expires = time() + 14 * 86400;
                $account->setEmail($this->input->post('email'));
                $account->setRecoveryCode();
                $account->setFirstName($this->input->post('firstName'));
                $account->setLastName($this->input->post('lastName'));
                $account->setCountry('USA');
                $account->setCity($this->input->post('companyCity'));
                $account->setState($this->input->post('companyState'));
                $account->setTitle($this->input->post('title'));
                $account->setCellPhone($this->input->post('cellPhone'));
                $account->setOfficePhone($this->input->post('cellPhone'));
                $account->setAddress($this->input->post('companyAddress'));
                $account->setZip($this->input->post('companyZip'));
                $account->setTimeZone('EST');
                $account->setCompany($company);
                $account->setFullAccess('yes');
                $account->setCreated(time());
                $account->setExpires($expires);
                $account->setSales(1);
                $account->unDelete();

                $this->em->persist($account);
                $this->em->persist($company);

                $this->em->flush();

                $job_array = $_POST;
                $job_array['company_id'] = $company->getCompanyId();
                $this->load->library('jobs');
        
                // Save the opaque image
                $this->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'trail_account_process',$job_array,'test job');
                $resp['success'] = true;
                
                /*
                 * ZoHo Start
                 */
                $zohoMsg = '';

                ZCRMRestClient::initialize([
                    'client_id' => ZOHO_CRM_USER,
                    'client_secret' => ZOHO_CRM_CLIENT_SECRET,
                    'redirect_uri' => site_url(),
                    'currentUserEmail' => 'mike@pavementlayers.com',
                    'token_persistence_path' => ROOTPATH . '/application/config',
                    "apiBaseUrl" => "www.zohoapis.com",
                    "apiVersion"=>"v2"
                ]);

                $moduleInstance = ZCRMRestClient::getInstance()->getModuleInstance("Leads");
                $records = [];

                $leadRecord = ZCRMRecord::getInstance("leads", null);
                $leadRecord->setFieldValue('First_Name', $this->input->post('firstName'));
                $leadRecord->setFieldValue('Last_Name', $this->input->post('lastName'));
                $leadRecord->setFieldValue('Designation', $this->input->post('title'));
                $leadRecord->setFieldValue('Phone', $this->input->post('companyPhone'));
                $leadRecord->setFieldValue('Mobile', $this->input->post('cellPhone'));
                $leadRecord->setFieldValue('Email', $this->input->post('email'));
                $leadRecord->setFieldValue('Company', $this->input->post('company'));
                $leadRecord->setFieldValue('Address_1', $this->input->post('companyAddress'));
                $leadRecord->setFieldValue('City', $this->input->post('companyCity'));
                $leadRecord->setFieldValue('State', $this->input->post('companyState'));
                $leadRecord->setFieldValue('Zip_Code',  $this->input->post('companyZip'));
                $leadRecord->setFieldValue('Website', $this->input->post('website'));
                $leadRecord->setFieldValue('Lead_Source', 'Automatic Trial SignUp');
                $leadRecord->setFieldValue('Temperature', 'Med - Interested');
                $leadRecord->setFieldValue('Rating', 'Silver 1-4 users');

                // // Add records to instance and send via API
                $records[] = $leadRecord;
                
                try {
                    $insert = $moduleInstance->createRecords($records);
                } catch (ErrorException $e) {
                    $zohoMsg = $e->getMessage();
                }

                /*
                 * ZoHo End
                 */
                $this->em->flush();
                $resp['success'] = true;

                  // Set up lead notification settings
                $this->getLeadNotificationsRepository()->setDefaultNotificationSettings($company);

                // Set up default sales config
                $str = $this->getSalesTargetsRepository();
                $str->createDefaultConfig($company->getCompanyId());

                $account->sendTrialSignupEmail();

                // sleep(1.5); //delay so the emails don't get too scrambled.
                 populateCompany($company->getCompanyId());
                //message for chris and mike with the users information
                $message2 = 'Account information:<br>';

                $message2 .= "<b>Company:</b> " . $_POST['company'] . "<br />
                        <b>First Name:</b> " . $_POST['firstName'] . "<br />
                        <b>Last Name:</b> " . $_POST['lastName'] . "<br />
                        <b>Email:</b> " . $_POST['email'] . "<br />
                        <b>Title:</b> " . $_POST['title'] . "<br />
                        <b>Cell Phone:</b> " . $_POST['cellPhone'] . "<br />
                        <b>Website:</b> " . $_POST['website'] . "<br />
                        <b>Company Phone:</b> " . $_POST['companyPhone'] . "<br />
                        <b>Company Fax:</b> " . $_POST['companyFax'] . "<br />
                        <b>Company Address:</b> " . $_POST['companyAddress'] . "<br />
                        <b>Company City:</b> " . $_POST['companyCity'] . "<br />
                        <b>Company State:</b> " . $_POST['companyState'] . "<br />
                        <b>Company Zip:</b> " . $_POST['companyZip'].'<br /> <br /> Also, the account was added as a lead automatically into ZoHo';

                  $subject = 'New Trial Account on '.SITE_NAME;
                  $content = $message2 . $zohoMsg;

                $emailData = [
                    'to' => 'support@' . SITE_EMAIL_DOMAIN,
                    'fromName' => SITE_NAME,
                    'fromEmail' => 'no-reply@' . SITE_EMAIL_DOMAIN,
                    'subject' => $subject,
                    'body' => $content,
                    'categories' => ['Trial Signup'],
                ];

                $this->getEmailRepository()->send($emailData);
                $this->getSendgridRepository()->updateAddressWhitelist();
                echo json_encode($resp);

            }
        }
        echo json_encode($resp);
    }
       
    } 
    }

    function checklogin() {
        $account = $this->em->createQuery("select a from models\Accounts a where a.email='" . @$_GET['email'] . "' and a.password='" . md5(@$_GET['password']) . "'");
        $account = $account->getResult();
        if (!count($account)) {
            echo 0;
        } else {
            echo 1;
        }
    }

    function test() {
        $this->load->helper('zoho');
        $ZOHO_USER = "ied3vil@gmail.com";
        $ZOHO_PASSWORD = "h4ckerz";
        $ZOHO_API_KEY = '0ed2b964b73b9a193792d316de456df8';
        $z = new Zoho($ZOHO_USER, $ZOHO_PASSWORD, $ZOHO_API_KEY);

        $data = array(
            'First Name' => 'Mike2',
            'Last Name' => 'Lead2',
            'Company' => 'New Trial Lead2',
            'Phone' => '+35 1234567',
            'Email' => 'newlead23@pavementlayers.com',
            'Address' => '1123 Main',
            'City' => 'Cincinnati',
            'State' => 'OH',
            'Zip Code' => '45465',
            'Lead Status' => 'Trial SignUp',
            'Temperature' => 'Med - Interested',
            'Rating' => 'Silver 1-4 users',
        );

        try {
            $z->insertRecords('Leads', array($data));
            echo '<h3>Done.</h3>';

        } catch (ZohoException $e) {
            //        echo '<span>Error inserting data: ' . $e->getMessage() . '</span>';
        }
    }

    function mobile_job_costing_old($uuid)
    {
        $proposal = $this->em->findProposalByUuid($uuid);
        

        // Check it loaded
        if (!$proposal) {
            // Feedback and redirect
            $this->session->set_flashdata('error', 'Proposal could not be loaded');
            redirect('proposals');
            return;
        }
        $proposalId = $proposal->getProposalId();
        $serviceJobCost = $this->em->getRepository('models\ServiceJobCost')->findOneBy(array(
            'proposal_id' => $proposalId
        ));
        if(!$serviceJobCost){
            $this->getEstimationRepository()->createDefaultProposalServiceJobCosting($proposal);
        }else{
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
            if($total_estimate_items>0 && $total_estimate_items <= $total_job_cost_items){
               
                    $is_service_completed = 1;
            }
        
            $data['services'][$i] = [
                'service_details' => $service,
                'is_service_completed' => $is_service_completed,
                'job_cost_price_difference' => $this->getEstimationRepository()->getServiceJobCostPriceDifference($service_id),
                'subContractorItem' => $this->getEstimationRepository()->getSubContractorServiceJobCostItems($service_id),
                'sortedItems' => $this->getEstimationRepository()
                    ->getProposalServiceJobCostItems($proposal->getClient()->getCompany(), $service_id),
                'fieldValues' => $this->getProposalRepository()->getPopulatedServiceFields($proposal->getClient()->getCompany(), $service)
            ];

        }
        // echo '<pre>';
        // print_r($data['services']);die;
        
        $data['foremans'] = ['sunil yadav','Andy long','Mohit',
        ];
        $data['categories'] = $this->getEstimationRepository()->getCompanyCategories($proposal->getClient()->getCompany());
        $data['all_proposal_services'] =  $services;
        $data['proposaljob_cost_price_difference'] =  $this->getEstimationRepository()->getProposalJobCostPriceDifference($proposalId);
        // Render view
        $this->load->view('proposals/job_costing/mobile_job_costing', $data);
    }

    function mobile_job_costing($uuid)
    {
        $proposal = $this->em->findProposalByUuid($uuid);

        // Check it loaded
        if (!$proposal) {
            // Feedback and redirect
            $this->session->set_flashdata('error', 'Proposal could not be loaded');
            redirect('proposals');
            return;
        }
        $proposalId = $proposal->getProposalId();
        $serviceJobCost = $this->em->getRepository('models\ServiceJobCost')->findOneBy(array(
            'proposal_id' => $proposalId
        ));
        if(!$serviceJobCost){
            $this->getEstimationRepository()->createDefaultProposalServiceJobCosting($proposal);
        }else{
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
            if($total_estimate_items <= $total_job_cost_items){
                
                    $is_service_completed = 1;
            }elseif($total_estimate_items==0 && $total_job_cost_custom_items >0){
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
        $data['all_proposal_services'] =  $services;
        $data['proposaljob_cost_price_difference'] =  $this->getEstimationRepository()->getProposalJobCostPriceDifference($proposalId);
        // Render view
        
        $this->load->view('proposals/job_costing/mobile_job_costing2', $data);
    }

    function test2(){
        $this->load->view('proposals/job_costing/mobile_job_costing3');
    }

    

    /*
     *  Display a map with approx geolocation info
     */
    function ipMap($ip)
    {
        // Load the lib
        $this->load->library('GeoPlugin');

        // Locate
        $gp = new GeoPlugin();
        $gp->locate($ip);

        //Create view data
        $data = array();
        // Assign the GP object
        $data['gp'] = $gp;

        // Render the view
        $this->load->view('external_ip_map', $data);

    }

    function terms_of_use(){
        $data = array();
        $this->load->view('term', $data);
    }

    function privacy_policy(){
        $data = array();
        $this->load->view('privacy_policy', $data);
    }

    function terms_of_service(){
        $data = array();
        $this->load->view('terms_of_service', $data);
    }

 

    public function auth(){
        $data = [];
        if(!empty($this->session->all_userdata())){
           $email =  $this->session->userdata('useremail');

        }
        $data['remember_email'] = $this->input->cookie('remember_email') ?: $email;

       $this->load->view('auth', $data);
     }
     
     public function authCheck(){
        $data = [];
        if(!empty($this->session->all_userdata())){
           $email =  $this->session->userdata('recoveremail');
           $account = $this->em->getRepository('models\Accounts')->findOneBy(
               array('email' => $email)
           );
        }    
        if ($account) {
           $data['rcovery_code']  =  $account->getRecoveryCode();
        }
        $data['remember_email'] = $this->input->cookie('remember_email') ?: $email;
  
       $this->load->view('forget-pass-auth', $data);
     } 

    public function sendOtp($account){
            $generated_otp = rand(100000, 999999); // Generate a 6-digit OTP
            $current_time = time(); // Get current time
            $mobileNo = $account->getCellPhone();
            $mobileOtpResult = $this->sendMobileOtp($mobileNo,$generated_otp);
                 if(!empty($mobileOtpResult) && $mobileOtpResult['success']==1)
                {
                    $account->setEmailOtp($generated_otp);
                    $account->setOtpTime($current_time); // Save the current timestamp
                    $this->em->persist($account);
                    $this->em->flush();
                    $this->em->clear();
                    $maskedNumber = str_repeat('*', strlen($mobileNo) - 4) . substr($mobileNo, -4);
                    $this->session->set_flashdata('success', "Otp sent to your mobile number $maskedNumber");
                    redirect('home/authCheck');
                    }else{
                  
                }
           
            die;  
}


public function sendMobileOtp($to_number,$otp)
{
    $this->log_manager->add(\models\ActivityAction::LOGIN, 'User successfully logged in.');
    $mobileNo = ['9039181447','9826778111'];  
     // Check if the number exists in the array
     if (in_array($to_number, $mobileNo)) {
        // Prepend the country code for India (+91)
        $to_number = '+91' . $to_number;
    } else {
        // Prepend the country code for USA (+1)
        $to_number = '+1' . $to_number;
    }
    $result = $this->twiliolibrary->send_mobile_otp($to_number,$otp);
    return $result;
}

public function send_varification_code(){
 
    $data['remember_email']="*******";
    $data['cellphone']="*********";        

     if($this->session->userdata('recoveremail'))
    {
            $email = $this->session->userdata('recoveremail');
            // Split the email into two parts: before and after the "@" symbol
            list($name, $domain) = explode('@', $email);
            // Mask the part before the "@" symbol, leaving the first three characters visible
            $maskedEmail = substr($name, 0, 3) . str_repeat('*', strlen($name) - 3) . '@' . $domain;
            $data['remember_email']=$maskedEmail;
    }
    if($this->session->userdata('cellphone'))
    {
        $mobileNo=$this->session->userdata('cellphone');
        $maskedNumber = str_repeat('*', strlen($mobileNo) - 4) . substr($mobileNo, -4);
        $data['cellphone']=$maskedNumber;        
      
    }
    $this->load->view('send_varification_code',$data);

}

 

}