<?php

use Carbon\Carbon;
use Intervention\Image\ImageManager;
use GuzzleHttp\Client;
use models\Email_templates;
use Ramsey\Uuid\Uuid;

class Jobs extends MY_Controller
{
    private $imageManager;

    function __construct()
    {
        parent::__construct();
        $this->imageManager = new ImageManager();
    }

    function account_image_process()
    {
        set_time_limit(0);

        $data = json_decode(json_encode($_POST));
        $company_id = $data[0];

        $opacity = $data[1];

        $pct = floor($opacity * 100);
        $manager = new ImageManager();
        $originalFileName = UPLOADPATH . '/clients/logos/bg-' . $company_id . '-orig.png';
        $fileName = UPLOADPATH . '/clients/logos/bg-' . $company_id . '.png';


        if (file_exists($originalFileName)) {
            $img = $manager->make($originalFileName);
            $img->resize(919, 1300);
            $img->opacity($pct);
            //$img->rotate(90);
            $img->save($fileName);
        }
    }

    function proposal_image_process()
    {
        set_time_limit(0);
        $data = json_decode(json_encode($_POST));

        $company_id = $data[0];
        $proposal_id = $data[1];
        //$proposal = $this->doctrine->em->findProposal($proposal_id);
        $opacity = $_POST[2];
        $pct = floor($opacity * 100);

        $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
        //$data = $_POST[1];
        $txt = $proposal_id . "\n";
        fwrite($myfile, $txt);
        $txt = $opacity . "\n";
        fwrite($myfile, $txt);

        fclose($myfile);

        $manager = new ImageManager();


        $originalFileName = UPLOADPATH . '/companies/' . $company_id . '/proposals/' . $proposal_id . '/cover-orig.png';
        $fileName = UPLOADPATH . '/companies/' . $company_id . '/proposals/' . $proposal_id . '/cover.png';
        if (file_exists($originalFileName)) {
            $theFile = $originalFileName;
        } else {
            // If not, check if there's a company image
            $theFile = UPLOADPATH . '/clients/logos/bg-' . $company_id . '-orig.png';
        }

        if (file_exists($theFile)) {
            $img = $manager->make($theFile);
            $img->opacity($pct);
            $img->save($fileName);
        }
    }

    function test()
    {
        
        // $myfile = fopen("newfileSunil1.txt", "w") or die("Unable to open file!");
         $data = $_POST[0];
        // $txt = $data . "\n";
        // fwrite($myfile, $txt);

        // fclose($myfile);

        $myfile = file_put_contents('newfileSunil1.txt', $data.PHP_EOL , FILE_APPEND | LOCK_EX);
    }

    function group_proposal_resend()
    {
        set_time_limit(0);
        if (isset($_POST['uniqueArgVal'])) {
            $proposal = $this->em->find('\models\Proposals', $_POST['uniqueArgVal']);
            $clientEmail = $proposal->getClient()->getEmail();

            $ppl = $this->em->getRepository('models\ProposalPreviewLink')->findOneBy(array('email' => $_POST['to'], 'proposal_id' => $proposal->getProposalId()));
            $client_link = 0;
            $signature_link = 0;

            if ($clientEmail == $_POST['to']) {
                $client_link = 1;
                $signature_link = 1;
            }
            
            if (!$ppl) {
                $uuid = Uuid::uuid4();
                $ppl = new  \models\ProposalPreviewLink();
                $ppl->setProposalId($proposal->getProposalId());
                $ppl->setUuid($uuid);
                $ppl->setEmail($_POST['to']);
                $ppl->setCreatedAt(Carbon::now());
                $ppl->setClientLink($client_link);
                $ppl->setSignatureLink($signature_link);
                $this->em->persist($ppl);
                $this->em->flush();
                $proposal->setProposalViewCount($proposal->getProposalViewCount() + 1);
            }


            $etp = new \EmailTemplateParser();
            $etp->setProposal($proposal);
            $etp->setProposalPreviewLink($ppl);
            $_POST['subject'] = $etp->parse($_POST['subject']);
            $_POST['body'] = $etp->parse($_POST['body']);

            if ($proposal) {
                // Update the link if it's going to the client
                $clientEmail = $proposal->getClient()->getEmail();
                if ($clientEmail == $_POST['to']) {
                    $_POST['body'] = updateEmailLinks($_POST['body']);
                }
            }
           
            $this->getEmailRepository()->send($_POST);
        }
    }

    function group_client_resend()
    {
        set_time_limit(0);

        $client = $this->em->find('\models\Clients', $_POST['clientId']);

        $etp = new \EmailTemplateParser();
        $etp->setClient($client);
        $etp->setAccount($client->getAccount());

        $_POST['subject'] = $etp->parse($_POST['subject']);
        $_POST['body'] = $etp->parse($_POST['body']);

        $this->getEmailRepository()->send($_POST);
    }


    function group_lead_resend()
    {
        set_time_limit(0);

        $lead = $this->em->find('\models\Leads', $_POST['leadId']);
        $leadAccount = $this->em->findAccount($lead->getAccount());
        $etp = new \EmailTemplateParser();
        $etp->setLead($lead);
        $etp->setAccount($leadAccount);

        $_POST['subject'] = $etp->parse($_POST['subject']);
        $_POST['body'] = $etp->parse($_POST['body']);

        $this->getEmailRepository()->send($_POST);
    }

    function group_prospect_resend()
    {
        set_time_limit(0);

        $prospect = $this->em->findProspect($_POST['prospectId']);
        $prospectAccount = $this->em->findAccount($prospect->getAccount());
        $etp = new \EmailTemplateParser();
        $etp->setProspect($prospect);
        $etp->setAccount($prospectAccount);

        $_POST['subject'] = $etp->parse($_POST['subject']);
        $_POST['body'] = $etp->parse($_POST['body']);

        $this->getEmailRepository()->send($_POST);
    }

    function group_admin_resend()
    {
        set_time_limit(0);

        $account = $this->em->findAccount($_POST['accountId']);

        $etp = new EmailTemplateParser();
        $etp->setAccount($account);
        // Get the parsed content
        $_POST['subject'] = $etp->parse($_POST['subject']);
        $_POST['body'] = $etp->parse($_POST['body']);

        $this->getEmailRepository()->send($_POST);
    }


    function group_proposal_email_send()
    {
        set_time_limit(0);
        ignore_user_abort(1);
        $account = $this->em->findAccount($_POST['account_id']);

        $emailData = [
            'subject' => 'test',
            'body' => 'test',
            'fromName' => 'abc',
            'fromEmail' => '',
            'replyTo' => '',
            'emailCC' => '',
            'categories' => ['Group Resend'],
            'proposal_filter' => ''
        ];


        $this->getProposalRepository()->groupSend($_POST['proposal_ids'], $_POST['email_data'], $account, 'proposal_send', null, $_POST['resend_id'], $_POST['resend_name'], $_POST['exclude_override']);
    }

    function send_individual_proposal_email_send()
    {
        set_time_limit(0);
        ignore_user_abort(1);
        $account = $this->em->findAccount($_POST['account_id']);

        $check = $this->getProposalRepository()->direct_send($_POST['proposal_id'], $_POST['email_data'], $account, $_POST['logAction'], $_POST['logMessage'], $_POST['pgseId']);

        if (!$check['status']) {
            //update campaign email row to failed
            if ($_POST['pgseId']) {
                $campaign_email = $this->em->find('\models\ProposalGroupResendEmail', $_POST['pgseId']);
                if ($campaign_email) {
                    $campaign_email->setIsFailed(1);
                    $campaign_email->setSentAt(Carbon::now());
                    $this->em->persist($campaign_email);
                    $this->em->flush();
                }
            }

            if (isset($_POST['failed_individual_job_id'])) {
                $failed_job = $this->em->find('\models\FailedJob', $_POST['failed_individual_job_id']);
                if ($failed_job) {
                    $failed_job->setLastRetryAt(date('Y-m-d H:i:s'));
                    $failed_job->setErrorMessage($check['error_message']);
                    $this->em->persist($failed_job);
                    $this->em->flush();
                }
            } else {
                $failed_job = new \models\FailedJob();
                $failed_job->setJobName('send_individual_proposal_email_send');
                $failed_job->setFailedAt(date('Y-m-d H:i:s'));
                $failed_job->setJobData(json_encode($_POST));
                $failed_job->setJobType('proposal_campaign');
                $failed_job->setEntityId($_POST['proposal_id']);
                $failed_job->setCampaignId($_POST['pgsId']);
                $this->em->persist($failed_job);
                $this->em->flush();
            }

            $body = 'Proposal Id: ' . $_POST['proposal_id'] . '<br/>Campaign Id: ' . $_POST['pgsId'];
            $basicEmailData = [
                'fromName' => SITE_NAME,
                'fromEmail' => 'noreply@' . SITE_EMAIL_DOMAIN,
                'subject' => 'Job Failed from send_individual',
                'body' => $body,
                'to' => 'sunilyadav.acs@gmail.com',
            ];

            $this->getEmailRepository()->send($basicEmailData);
            $basicEmailData = [
                'fromName' => SITE_NAME,
                'fromEmail' => 'noreply@' . SITE_EMAIL_DOMAIN,
                'subject' => 'Job Failed',
                'body' => $body,
                'to' => 'andy@pavementlayers.com',
            ];

            $this->getEmailRepository()->send($basicEmailData);
        } else {
            if ($_POST['pgseId']) {
                $campaign_email = $this->em->find('\models\ProposalGroupResendEmail', $_POST['pgseId']);
                if ($campaign_email) {
                    $campaign_email->setSentAt(Carbon::now());

                    if (isset($_POST['failed_individual_job_id'])) {
                        $campaign_email->setIsFailed(0);

                        $failed_job = $this->em->find('\models\FailedJob', $_POST['failed_individual_job_id']);
                        if ($failed_job) {
                            $new_resend = $failed_job->getResend() + 100;
                            $failed_job->setResend($new_resend);
                            $this->em->persist($failed_job);
                        }
                    }
                    $this->em->persist($campaign_email);
                    $this->em->flush();
                }
            }
        }
        log_message('debug', 'sunil_test');
    }

    function send_job_completed_mail()
    {
        set_time_limit(0);
        ignore_user_abort(1);
        $account = $this->em->findAccount($_POST['account_id']);
        $pgs = $this->em->find('\models\ProposalGroupResend', $_POST['pgsId']);
        if ($pgs && $account) {
            $send_data = $this->getProposalRepository()->getResendStats($pgs, $account);
            $this->load->model('system_email');
            $emailData = array(
                'sent_count' => $send_data['sent'],
                'failed_count' => $send_data['failed_count'],
                'sent_email_body' => $_POST['email_data']['body'],
                'campaignName' => $pgs->getResendName(),
            );

            $this->system_email->sendEmail(38, $account->getEmail(), $emailData);
        }
    }

    function proposal_signature_email_send()
    {
        set_time_limit(0);
        ignore_user_abort(1);

        $proposal = $this->em->findProposal($_POST['proposal_id']);
        $proposal_id = $_POST['proposal_id'];

        //Get Default non tracking View Link
        $proposalLink = $this->getProposalRepository()->getDefaultProposalLink($proposal_id);

        $this->load->model('system_email');
        $emailData = array(
            'signeeName' => $_POST['p_signature_firstname'] . ' ' . $_POST['p_signature_lastname'],
            'signeeCompany' => $_POST['p_signature_company'],
            'signeeTitle' => $_POST['p_signature_title'],
            'signeeEmail' => $_POST['p_signature_email'],
            'signeeComments' => $_POST['p_signature_comment'],
            'signeeDateTime' => $_POST['p_signature_created_at'],
            'signeeIpAddress' => $_POST['p_signature_ip_address'],
            'projectName' => $proposal->getProjectname(),
            'siteName' => SITE_NAME,
            'contactName' => $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName(),
            'contactCell' => $proposal->getClient()->getCellPhone(),
            'contactEmail' => $proposal->getClient()->getEmail(),
            'companyName' => $proposal->getClient()->getCompany()->getCompanyName(),
            'proposalPreviewUrl' => $proposalLink->getUrl(),
        );

        $layout = 'cool';

        //$cache_file_name = 'plproposal_' . $proposal->getAccessKey() . '.pdf';
        $cache_file_name = $proposal->getProjectname() . ' - Signed.pdf';
        $cache_directory = CACHEDIR . '/proposals/attachment/' . $layout . '/';
        //check if directory exists
        if (!is_dir($cache_directory)) {
            mkdir($cache_directory, 755, true);
        }
        $cache_file = $cache_directory . $cache_file_name;


        $this->render($cache_file, $layout, $cache_file_name, $proposal, $proposal_id);

        $argData = array(
            'attachments' => $cache_file,
        );
        
        
        $this->system_email->sendEmail(Email_templates::PROPOSAL_SIGNED_USER, $proposal->getOwner()->getEmail(), $emailData, $argData);

        $emailData['siteLogoUrl'] = site_url('/uploads/clients/logos/'.$proposal->getClient()->getCompany()->getCompanyEmailLogo());

        $proposalUserName = $proposal->getOwner()->getFirstName() .' '.$proposal->getOwner()->getLastName();
        if (strtolower($_POST['p_signature_email']) != strtolower($proposal->getClient()->getEmail())) {
            $this->system_email->sendEmail(Email_templates::PROPOSAL_SIGNED_SIGNEE, $proposal->getClient()->getEmail(), $emailData, $argData,$proposalUserName,$proposal->getOwner()->getEmail());
        }

        if($_POST['p_signature_type'] != 'company'){
            $this->system_email->sendEmail(Email_templates::PROPOSAL_SIGNED_SIGNEE, $_POST['p_signature_email'], $emailData, $argData,$proposalUserName,$proposal->getOwner()->getEmail());
        }


        
        
        //Change Ip address text for Client
        $emailData['signeeIpAddress'] = $_POST['p_signature_ip_address_text'];
        
        
        
        
    }

    function proposal_company_final_signature_email_send()
    {
        set_time_limit(0);
        ignore_user_abort(1); 

        $proposal = $this->em->findProposal($_POST['proposal_id']);
        $proposal_id = $_POST['proposal_id']; 
        
        //Get Default non tracking View Link
        $proposalLink = $this->getProposalRepository()->getDefaultProposalLink($proposal_id);

        $this->load->model('system_email');
        $emailData = array(
            'signeeName' => $_POST['p_signature_firstname'] . ' ' . $_POST['p_signature_lastname'],
            'signeeCompany' => $_POST['p_signature_company'],
            'signeeTitle' => $_POST['p_signature_title'],
            'signeeEmail' => $_POST['p_signature_email'],
            'signeeComments' => $_POST['p_signature_comment'],
            'signeeDateTime' => $_POST['p_signature_created_at'],
            'signeeIpAddress' => $_POST['p_signature_ip_address'],
            'projectName' => $proposal->getProjectname(),
            'siteName' => SITE_NAME,
            'contactName' => $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName(),
            'contactCell' => $proposal->getClient()->getCellPhone(),
            'contactEmail' => $proposal->getClient()->getEmail(),
            'client_company' => $proposal->getClient()->getClientAccount()->getName(),
            'client_first' => $proposal->getClient()->getFirstName(),
            'client_last' => $proposal->getClient()->getLastName(),
            'client_cell_phone' => $proposal->getClient()->getCellPhone(),
            'client_office_phone' => $proposal->getClient()->getBusinessPhone(),
            'client_email' => $proposal->getClient()->getEmail(),
            'proposalPreviewUrl' => $proposalLink->getUrl(),
            'companyName' => $proposal->getClient()->getCompany()->getCompanyName(),
        );

        $layout = 'cool';


        //$cache_file_name = 'plproposal_' . $proposal->getAccessKey() . '.pdf';
        $cache_file_name = $proposal->getProjectname() . ' - Signed.pdf';
        $cache_directory = CACHEDIR . '/proposals/attachment/' . $layout . '/';
        //check if directory exists
        if (!is_dir($cache_directory)) {
            mkdir($cache_directory, 755, true);
        }
        $cache_file = $cache_directory . $cache_file_name;


        $this->render($cache_file, $layout, $cache_file_name, $proposal, $proposal_id);

        $argData = array(
            'attachments' => $cache_file,
        );

        //$this->system_email->sendEmail(43, $proposal->getOwner()->getEmail(), $emailData, $argData);

        //Change Ip address text for Client
        $emailData['signeeIpAddress'] = $_POST['p_signature_ip_address_text'];

        $this->system_email->sendEmail(Email_templates::PROPOSAL_FINAL_CONTRACT_USER, $proposal->getOwner()->getEmail(), $emailData, $argData);

        $emailData['siteLogoUrl'] = site_url('/uploads/clients/logos/'.$proposal->getClient()->getCompany()->getCompanyEmailLogo());

        $proposalUserName = $proposal->getOwner()->getFirstName() .' '.$proposal->getOwner()->getLastName();
        // if (strtolower($_POST['p_signature_email']) != strtolower($proposal->getClient()->getEmail())) {
            
        // }
       

        $this->system_email->sendEmail(Email_templates::PROPOSAL_FINAL_CONTRACT_CLIENT, $proposal->getClient()->getEmail(), $emailData, $argData,$proposalUserName,$proposal->getOwner()->getEmail());
        
        
    }

    function proposal_client_final_signature_email_send()
    {
        set_time_limit(0);
        ignore_user_abort(1);

        $proposal = $this->em->findProposal($_POST['proposal_id']);
        $proposal_id = $_POST['proposal_id'];

        //Get Default non tracking View Link
        $proposalLink = $this->getProposalRepository()->getDefaultProposalLink($proposal_id);

        $this->load->model('system_email');
        $emailData = array(
            'signeeName' => $_POST['p_signature_firstname'] . ' ' . $_POST['p_signature_lastname'],
            'signeeCompany' => $_POST['p_signature_company'],
            'signeeTitle' => $_POST['p_signature_title'],
            'signeeEmail' => $_POST['p_signature_email'],
            'signeeComments' => $_POST['p_signature_comment'],
            'signeeDateTime' => $_POST['p_signature_created_at'],
            'signeeIpAddress' => $_POST['p_signature_ip_address'],
            'projectName' => $proposal->getProjectname(),
            'siteName' => SITE_NAME,
            'contactName' => $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName(),
            'contactCell' => $proposal->getClient()->getCellPhone(),
            'contactEmail' => $proposal->getClient()->getEmail(),
            'client_company' => $proposal->getClient()->getClientAccount()->getName(),
            'client_first' => $proposal->getClient()->getFirstName(),
            'client_last' => $proposal->getClient()->getLastName(),
            'client_cell_phone' => $proposal->getClient()->getCellPhone(),
            'client_office_phone' => $proposal->getClient()->getBusinessPhone(),
            'client_email' => $proposal->getClient()->getEmail(),
            'proposalPreviewUrl' => $proposalLink->getUrl(),
            'companyName' => $proposal->getClient()->getCompany()->getCompanyName(),
        );

        $layout = 'cool';


        //$cache_file_name = 'plproposal_' . $proposal->getAccessKey() . '.pdf';
        $cache_file_name = $proposal->getProjectname() . ' - Signed.pdf';
        $cache_directory = CACHEDIR . '/proposals/attachment/' . $layout . '/';
        //check if directory exists
        if (!is_dir($cache_directory)) {
            mkdir($cache_directory, 755, true);
        }
        $cache_file = $cache_directory . $cache_file_name;


        $this->render($cache_file, $layout, $cache_file_name, $proposal, $proposal_id);

        $argData = array(
            'attachments' => $cache_file,
        );

       // $this->system_email->sendEmail(44, $proposal->getOwner()->getEmail(), $emailData, $argData);

        //Change Ip address text for Client
        $emailData['signeeIpAddress'] = $_POST['p_signature_ip_address_text'];
        $proposalUserName = $proposal->getOwner()->getFirstName() .' '.$proposal->getOwner()->getLastName();
        //Final contract email for User
        $this->system_email->sendEmail(Email_templates::PROPOSAL_FINAL_CONTRACT_USER, $proposal->getOwner()->getEmail(), $emailData, $argData);

        if (strtolower($_POST['p_signature_email']) != strtolower($proposal->getClient()->getEmail())) {
            $this->system_email->sendEmail(Email_templates::PROPOSAL_SIGNED_SIGNEE, $_POST['p_signature_email'], $emailData, $argData,$proposalUserName,$proposal->getOwner()->getEmail());
        }

        $emailData['siteLogoUrl'] = site_url('/uploads/clients/logos/'.$proposal->getClient()->getCompany()->getCompanyEmailLogo());

        $this->system_email->sendEmail(Email_templates::PROPOSAL_FINAL_CONTRACT_CLIENT, $proposal->getClient()->getEmail(), $emailData, $argData,$proposalUserName,$proposal->getOwner()->getEmail());
        
        
        
        
        
    }


    function proposal_question_email_send()
    {
        set_time_limit(0);
        ignore_user_abort(1);

        $proposal = $this->em->findProposal($_POST['proposal_id']);
        
        //Get Default non tracking View Link
        $proposalLink = $this->getProposalRepository()->getDefaultProposalLink($_POST['proposal_id']);

        $this->load->model('system_email');
        $emailData = array(
            'contactName' => $_POST['p_question_firstname'] . ' ' . $_POST['p_question_lastname'],
            'contactCompany' => $_POST['p_question_company'],
            'contactTitle' => $_POST['p_question_title'],
            'contactEmail' => '<a href="mailto:'.$_POST['p_question_email'].'?subject=Your Proposal Question - '.$proposal->getProjectname().'">'.$_POST['p_question_email'].'</a>',
            'contactQuestion' => nl2br($_POST['p_question_text']),
            'questioned_ip' => $_POST['p_question_ip_address'],
            'siteName' => SITE_NAME,
            'projectName' => $proposal->getProjectname(),
            'proposalPreviewUrl' => $proposalLink->getUrl(),
        );

        $this->system_email->sendEmail(Email_templates::PROPOSAL_QUESTION_USER, $proposal->getOwner()->getEmail(), $emailData,[],'','',$_POST['p_question_email']);
    }

    function unopend_proposal_email_send()
    {
        set_time_limit(0);
        ignore_user_abort(1);
        $account = $this->em->findAccount($_POST['account_id']);

        $this->getProposalRepository()->groupSendUnopened2(
            $_POST['email_data'],
            $account,
            'proposal_send',
            null,
            $_POST['resend_id'],
            $_POST['unclicked'],
            $_POST['exclude_override']
        );
    }

    function bounced_proposal_email_send()
    {
        set_time_limit(0);
        ignore_user_abort(1);
        $account = $this->em->findAccount($_POST['account_id']);

        $this->getProposalRepository()->groupResendBounced($account, $_POST['resend_id'], $_POST['proposal_ids']);
    }

    function bounced_proposal_email_send1()
    {
        set_time_limit(0);
        ignore_user_abort(1);
        $account = $this->em->findAccount(1902);

        $this->getProposalRepository()->groupResendBounced($account, 340, ["195983"]);
    }


    function unopend_client_email_send()
    {
        set_time_limit(0);
        ignore_user_abort(1);
        $account = $this->em->findAccount($_POST['account_id']);

        $this->getClientRepository()->groupSendUnopened($_POST['email_data'], $account, 'client_send', null, $_POST['resend_id'], $_POST['unclicked'], $_POST['exclude_override']);
    }

    function unopend_lead_email_send()
    {
        set_time_limit(0);
        ignore_user_abort(1);
        $account = $this->em->findAccount($_POST['account_id']);

        $this->getLeadRepository()->groupSendUnopened($_POST['email_data'], $account, 'lead_send', null, $_POST['resend_id'], $_POST['unclicked']);
    }

    function unopend_prospect_email_send()
    {
        set_time_limit(0);
        ignore_user_abort(1);
        $account = $this->em->findAccount($_POST['account_id']);

        $this->getProspectRepository()->groupSendUnopened($_POST['email_data'], $account, 'prospect_send', null, $_POST['resend_id'], $_POST['unclicked']);
    }

    function group_unopend_proposal_email_send()
    {
        $resendIds = $_POST['resend_ids'];
        $account = $this->em->findAccount($_POST['account_id']);
        for ($i = 0; $i < count($resendIds); $i++) {
            $pgs = $this->em->find('\models\ProposalGroupResend', $resendIds[$i]);
            if ($pgs) {
                $emailData = [
                    'subject' => $pgs->getSubject(),
                    'body' => $pgs->getEmailContent(),
                    'fromName' => $pgs->getCustomSenderName(),
                    'fromEmail' => $pgs->getCustomSenderEmail(),
                    'replyTo' => $pgs->getCustomSenderEmail(),
                    'emailCC' => $pgs->getEmailCc(),
                    'new_resend_name' => $pgs->getResendName(),
                    'categories' => ['Group Resend'],
                ];

                //send all proposals selected
                $this->getProposalRepository()->groupSendUnopened2($emailData, $account, 'proposal_send', null, $resendIds[$i], null, 0);
            }
        }
    }

    function group_unopend_client_email_send()
    {
        $resendIds = $_POST['resend_ids'];
        $account = $this->em->findAccount($_POST['account_id']);
        for ($i = 0; $i < count($resendIds); $i++) {
            $pgs = $this->em->find('\models\ProposalGroupResend', $resendIds[$i]);
            if ($pgs) {
                $emailData = [
                    'subject' => $pgs->getSubject(),
                    'body' => $pgs->getEmailContent(),
                    'fromName' => $pgs->getCustomSenderName(),
                    'fromEmail' => $pgs->getCustomSenderEmail(),
                    'replyTo' => $pgs->getCustomSenderEmail(),
                    'emailCC' => $pgs->getEmailCc(),
                    'new_resend_name' => $pgs->getResendName(),
                    'categories' => ['Group Resend'],
                ];

                //send all proposals selected
                $this->getClientRepository()->groupSendUnopened($emailData, $account, 'client_send', null, $resendIds[$i], null, 0);
            }
        }
    }

    function group_unopend_lead_email_send()
    {
        $resendIds = $_POST['resend_ids'];
        $account = $this->em->findAccount($_POST['account_id']);
        for ($i = 0; $i < count($resendIds); $i++) {
            $pgs = $this->em->find('\models\ProposalGroupResend', $resendIds[$i]);

            if ($pgs) {
                $emailData = [
                    'subject' => $pgs->getSubject(),
                    'body' => $pgs->getEmailContent(),
                    'fromName' => $pgs->getCustomSenderName(),
                    'fromEmail' => $pgs->getCustomSenderEmail(),
                    'replyTo' => $pgs->getCustomSenderEmail(),
                    'emailCC' => $pgs->getEmailCc(),
                    'new_resend_name' => $pgs->getResendName(),
                    'categories' => ['Group Resend'],
                ];

                //send all  selected
                $this->getLeadRepository()->groupSendUnopened($emailData, $account, 'lead_send', null, $resendIds[$i]);
            }
        }
    }

    function group_unopend_prospect_email_send()
    {
        $resendIds = $_POST['resend_ids'];
        $account = $this->em->findAccount($_POST['account_id']);
        for ($i = 0; $i < count($resendIds); $i++) {
            $pgs = $this->em->find('\models\ProposalGroupResend', $resendIds[$i]);
            if ($pgs) {
                $emailData = [
                    'subject' => $pgs->getSubject(),
                    'body' => $pgs->getEmailContent(),
                    'fromName' => $pgs->getCustomSenderName(),
                    'fromEmail' => $pgs->getCustomSenderEmail(),
                    'replyTo' => $pgs->getCustomSenderEmail(),
                    'emailCC' => $pgs->getEmailCc(),
                    'new_resend_name' => $pgs->getResendName(),
                    'categories' => ['Group Resend'],
                ];

                //send all  selected
                $this->getProspectRepository()->groupSendUnopened($emailData, $account, 'prospect_send', null, $resendIds[$i]);
            }
        }
    }

    function group_client_email_send()
    {
        set_time_limit(0);
        ignore_user_abort(1);
        $account = $this->em->findAccount($_POST['account_id']);

        $this->getClientRepository()->groupSend($_POST['client_ids'], $_POST['email_data'], $account, 'client_send', null, $_POST['resend_id'], $_POST['resend_name'], $_POST['exclude_override']);
    }


    function group_client_email_send_test()
    {
        set_time_limit(0);
        ignore_user_abort(1);
        $account = $this->em->findAccount(3749);

        $emailData = [
            'subject' => 'Client Mail Demo',
            'body' => '<p >This is the content</p>',
            'fromName' => '',
            'fromEmail' => '',
            'replyTo' => '',
            'emailCC' => false,
            'categories' => ['Group Resend'],
            'clientFilter' => []
        ];

        //send all proposals selected
        $job_array = [
            'client_ids' => [139651,261784],
            'email_data' => $emailData,
            'account_id' => 3749,
            'resend_id' => '',
            'resend_name' => '02/16/2022 10:26am',
            'exclude_override' => 0
        ];

        $this->getClientRepository()->groupSend([139651,261784], $emailData, $account, 'client_send', null, $job_array['resend_id'], $job_array['resend_name'], $job_array['exclude_override']);
    }

    function send_individual_client_email()
    {
        set_time_limit(0);
        ignore_user_abort(1);

        $check = $this->getEmailRepository()->tryToSend($_POST);

        if (!$check['status']) {
            if (isset($_POST['uniqueArgVal'])) {
                $campaign_email = $this->em->find('\models\ClientGroupResendEmail', $_POST['uniqueArgVal']);
                if ($campaign_email) {
                    $campaign_email->setIsFailed(1);
                    $campaign_email->setSentAt(Carbon::now());
                    $this->em->persist($campaign_email);
                    $this->em->flush();
                }
            }
            if (isset($_POST['failed_individual_job_id'])) {
                $failed_job = $this->em->find('\models\FailedJob', $_POST['failed_individual_job_id']);
                if ($failed_job) {
                    $failed_job->setLastRetryAt(date('Y-m-d H:i:s'));
                    $failed_job->setErrorMessage($check['error_message']);
                    $this->em->persist($failed_job);
                    $this->em->flush();
                }
            } else {
                $failed_job = new \models\FailedJob();
                $failed_job->setJobName('send_individual_client_email');
                $failed_job->setFailedAt(date('Y-m-d H:i:s'));
                $failed_job->setJobData(json_encode($_POST));
                $failed_job->setJobType('client_campaign');
                $failed_job->setEntityId($_POST['clientId']);
                $failed_job->setCampaignId($_POST['campaignId']);
                $this->em->persist($failed_job);
                $this->em->flush();
            }

            $body = 'Client Id: ' . $_POST['clientId'] . '<br/>Campaign Id: ' . $_POST['campaignId'];
            $basicEmailData = [
                'fromName' => SITE_NAME,
                'fromEmail' => 'noreply@' . SITE_EMAIL_DOMAIN,
                'subject' => 'Job Failed from send_client_individual',
                'body' => $body,

                'to' => 'sunilyadav.acs@gmail.com',

            ];

            $this->getEmailRepository()->send($basicEmailData);
            $basicEmailData = [
                'fromName' => SITE_NAME,
                'fromEmail' => 'noreply@' . SITE_EMAIL_DOMAIN,
                'subject' => 'Job Failed from send_client_individual',
                'body' => $body,

                'to' => 'andy@pavementlayers.com',

            ];

            $this->getEmailRepository()->send($basicEmailData);
        } else {
            if (isset($_POST['uniqueArgVal'])) {
                $campaign_email = $this->em->find('\models\ClientGroupResendEmail', $_POST['uniqueArgVal']);
                if ($campaign_email) {
                    $campaign_email->setSentAt(Carbon::now());
                    if (isset($_POST['failed_individual_job_id'])) {
                        $campaign_email->setIsFailed(0);
                        $failed_job = $this->em->find('\models\FailedJob', $_POST['failed_individual_job_id']);
                        if ($failed_job) {
                            $new_resend = $failed_job->getResend() + 100;
                            $failed_job->setResend($new_resend);
                            $this->em->persist($failed_job);
                        }
                    }
                    $this->em->persist($campaign_email);
                    $this->em->flush();
                }
            }
        }
    }


    function group_lead_email_send()
    {
        set_time_limit(0);
        ignore_user_abort(1);
        $account = $this->em->findAccount($_POST['account_id']);

        $this->getLeadRepository()->groupSend($_POST['lead_ids'], $_POST['email_data'], $account, 'lead_send', null, $_POST['resend_id'], $_POST['resend_name']);
    }

    function group_prospect_email_send()
    {
        set_time_limit(0);
        ignore_user_abort(1);
        $account = $this->em->findAccount($_POST['account_id']);

        $this->getProspectRepository()->groupSend($_POST['prospect_ids'], $_POST['email_data'], $account, 'prospect_send', null, $_POST['resend_id'], $_POST['resend_name']);
    }


    function preloadProposals()
    {
        $proposalIds = $this->input->post('proposalIds');

        foreach ($proposalIds as $proposalId) {
            $proposal = $this->em->findProposal($proposalId);

            if ($proposal) {
                $url = $proposal->getPdfUrl() . '/load';
                $client = new GuzzleHttp\Client(['verify' => false]);

                try {
                    $client->request('get', $url);
                } catch (\Exception $e) {
                }
            }
        }
    }


    function group_admin_email_send()
    {
        set_time_limit(0);
        ignore_user_abort(1);

        $account = $this->em->findAccount($_POST['account_id']);
        $this->getCompanyRepository()->group_send($_POST, $account);
    }

    function group_admin_unopened_email_send()
    {
        set_time_limit(0);
        ignore_user_abort(1);
        $emailData = [
            'subject' => $_POST['subject'],
            'body' => $_POST['body'],
            'fromName' => $_POST['fromName'],
            'fromEmail' => $_POST['fromEmail'],
            'new_resend_name' => $_POST['new_resend_name'],
            'replyTo' => $_POST['fromEmail'],
            'emailCC' => ($_POST['emailCC']) ? 0 : 1,
            'categories' => ['Group Resend'],
        ];

        $account = $this->em->findAccount($_POST['account_id']);
        $this->getCompanyRepository()->groupSendUnopened($emailData, $account, 'admin_send', null, $_POST['resendId'], $_POST['unclicked']);
    }

    function trail_account_process()
    {

        $company = $this->em->findCompany($_POST['company_id']);

        /*
                 * ZoHo Start
                 */
        $this->load->helper('zoho');
        $ZOHO_USER = "mike@prositeaudit.com";
        $ZOHO_PASSWORD = "3814weststreet";
        $ZOHO_API_KEY = 'fe3b5440dfe4403979f5cf2bb49c3e76';
        $z = new Zoho($ZOHO_USER, $ZOHO_PASSWORD, $ZOHO_API_KEY);

        $data = array(
            //user details
            'First Name' => $_POST['firstName'],
            'Last Name' => $_POST['lastName'],
            'Company' => $_POST['company'],
            'Phone' => $_POST['companyPhone'],
            'Email' => $_POST['email'],
            'Address' => $_POST['companyAddress'],
            'City' => $_POST['companyCity'],
            'State' => $_POST['companyState'],
            'Zip Code' => $_POST['companyZip'],
            'Title' => $_POST['title'],
            'Fax' => $_POST['companyFax'],
            'Mobile' => $_POST['cellPhone'],
            'Website' => $_POST['website'],
            //system stuff
            'Lead Source' => 'Automatic Trial SignUp',
            'Lead Status' => 'Trial SignUp',
            'Temperature' => 'Med - Interested',
            'Rating' => 'Silver 1-4 users',
        );

        try {
            $z->insertRecords('Leads', array($data));
        } catch (ZohoException $e) {
            //        echo '<span>Error inserting data: ' . $e->getMessage() . '</span>';
        }

        /*
         * ZoHo End
         */
        // $this->em->flush();
        $resp['success'] = true;

        // Set up lead notification settings
        $this->getLeadNotificationsRepository()->setDefaultNotificationSettings($company);

        // Set up default sales config
        $str = $this->getSalesTargetsRepository();
        $str->createDefaultConfig($company->getCompanyId());

        sleep(1.5); //delay so the emails don't get too scrambled.
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
                        <b>Company Zip:</b> " . $_POST['companyZip'] . '<br /> <br /> Also, the account was added as a lead automatically into ZoHo';

        $subject = 'New Trial Account on ' . SITE_NAME;
        $content = $message2;

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
    }

    function failed_job_mail()
    {
        set_time_limit(0);

        //$failed_job = $this->em->find('\models\FailedJob', $_POST['job_id']);
        $body = 'Controller: ' . $_POST['controller'] . '<br/>Function: ' . $_POST['method'] . '<br/>Params:' . $_POST['params'];
        $basicEmailData = [
            'fromName' => SITE_NAME,
            'fromEmail' => 'noreply@' . SITE_EMAIL_DOMAIN,
            'subject' => 'Job Failed 3 Times',
            'body' => $body,
            'to' => 'sunilyadav.acs@gmail.com,andy@pavementlayers.com',
        ];

        $this->getEmailRepository()->send($basicEmailData);
    }


    function send_individual_lead_email()
    {
        set_time_limit(0);
        ignore_user_abort(1);

        $check = $this->getEmailRepository()->tryToSend($_POST);
        if (!$check['status']) {
            if (isset($_POST['uniqueArgVal'])) {
                $campaign_email = $this->em->find('\models\LeadGroupResendEmail', $_POST['uniqueArgVal']);
                if ($campaign_email) {
                    $campaign_email->setIsFailed(1);
                    $campaign_email->setSentAt(Carbon::now());
                    $this->em->persist($campaign_email);
                    $this->em->flush();
                }
            }
            if (isset($_POST['failed_individual_job_id'])) {
                $failed_job = $this->em->find('\models\FailedJob', $_POST['failed_individual_job_id']);
                if ($failed_job) {
                    $failed_job->setLastRetryAt(date('Y-m-d H:i:s'));
                    $failed_job->setErrorMessage($check['error_message']);
                    $this->em->persist($failed_job);
                    $this->em->flush();
                }
            } else {
                $failed_job = new \models\FailedJob();
                $failed_job->setJobName('send_individual_lead_email');
                $failed_job->setFailedAt(date('Y-m-d H:i:s'));
                $failed_job->setJobData(json_encode($_POST));
                $failed_job->setJobType('lead_campaign');
                $failed_job->setEntityId($_POST['leadId']);
                $failed_job->setCampaignId($_POST['campaignId']);
                $this->em->persist($failed_job);
                $this->em->flush();
            }

            $body = 'Lead Id: ' . $_POST['leadId'] . '<br/>Campaign Id: ' . $_POST['campaignId'];
            $basicEmailData = [
                'fromName' => SITE_NAME,
                'fromEmail' => 'noreply@' . SITE_EMAIL_DOMAIN,
                'subject' => 'Job Failed from send_lead_individual',
                'body' => $body,
                'to' => 'sunilyadav.acs@gmail.com',
            ];

            $this->getEmailRepository()->send($basicEmailData);
            $basicEmailData = [
                'fromName' => SITE_NAME,
                'fromEmail' => 'noreply@' . SITE_EMAIL_DOMAIN,
                'subject' => 'Job Failed from send_lead_individual',
                'body' => $body,
                'to' => 'andy@pavementlayers.com',
            ];

            $this->getEmailRepository()->send($basicEmailData);
        } else {
            if (isset($_POST['uniqueArgVal'])) {
                $campaign_email = $this->em->find('\models\LeadGroupResendEmail', $_POST['uniqueArgVal']);
                if ($campaign_email) {
                    $campaign_email->setSentAt(Carbon::now());
                    if (isset($_POST['failed_individual_job_id'])) {
                        $campaign_email->setIsFailed(0);
                        $failed_job = $this->em->find('\models\FailedJob', $_POST['failed_individual_job_id']);
                        if ($failed_job) {
                            $new_resend = $failed_job->getResend() + 100;
                            $failed_job->setResend($new_resend);
                            $this->em->persist($failed_job);
                        }
                    }
                    $this->em->persist($campaign_email);
                    $this->em->flush();
                }
            }
        }
    }

    function send_individual_prospect_email()
    {
        set_time_limit(0);
        ignore_user_abort(1);

        $check = $this->getEmailRepository()->tryToSend($_POST);
        if (!$check['status']) {
            if (isset($_POST['uniqueArgVal'])) {
                $campaign_email = $this->em->find('\models\ProspectGroupResendEmail', $_POST['uniqueArgVal']);
                if ($campaign_email) {
                    $campaign_email->setIsFailed(1);
                    $campaign_email->setSentAt(Carbon::now());
                    $this->em->persist($campaign_email);
                    $this->em->flush();
                }
            }
            if (isset($_POST['failed_individual_job_id'])) {
                $failed_job = $this->em->find('\models\FailedJob', $_POST['failed_individual_job_id']);
                if ($failed_job) {
                    $failed_job->setLastRetryAt(date('Y-m-d H:i:s'));
                    $failed_job->setErrorMessage($check['error_message']);
                    $this->em->persist($failed_job);
                    $this->em->flush();
                }
            } else {
                $failed_job = new \models\FailedJob();
                $failed_job->setJobName('send_individual_prospect_email');
                $failed_job->setFailedAt(date('Y-m-d H:i:s'));
                $failed_job->setJobData(json_encode($_POST));
                $failed_job->setJobType('prospect_campaign');
                $failed_job->setEntityId($_POST['prospectId']);
                $failed_job->setCampaignId($_POST['campaignId']);
                $this->em->persist($failed_job);
                $this->em->flush();
            }

            $body = 'Prospect Id: ' . $_POST['prospectId'] . '<br/>Campaign Id: ' . $_POST['campaignId'];
            $basicEmailData = [
                'fromName' => SITE_NAME,
                'fromEmail' => 'noreply@' . SITE_EMAIL_DOMAIN,
                'subject' => 'Job Failed from send_prospect_individual',
                'body' => $body,
                'to' => 'sunilyadav.acs@gmail.com',
                'uniqueArgVal' => ($_POST['uniqueArgVal']) ? $_POST['uniqueArgVal'] : '0',
            ];

            $this->getEmailRepository()->send($basicEmailData);
            $basicEmailData = [
                'fromName' => SITE_NAME,
                'fromEmail' => 'noreply@' . SITE_EMAIL_DOMAIN,
                'subject' => 'Job Failed from send_prospect_individual',
                'body' => $body,
                'to' => 'andy@pavementlayers.com',
                'uniqueArgVal' => ($_POST['uniqueArgVal']) ? $_POST['uniqueArgVal'] : '0',
            ];

            $this->getEmailRepository()->send($basicEmailData);
        } else {
            if (isset($_POST['uniqueArgVal'])) {
                $campaign_email = $this->em->find('\models\ProspectGroupResendEmail', $_POST['uniqueArgVal']);
                if ($campaign_email) {
                    $campaign_email->setSentAt(Carbon::now());

                    if (isset($_POST['failed_individual_job_id'])) {
                        $campaign_email->setIsFailed(0);

                        $failed_job = $this->em->find('\models\FailedJob', $_POST['failed_individual_job_id']);
                        if ($failed_job) {
                            $new_resend = $failed_job->getResend() + 100;
                            $failed_job->setResend($new_resend);
                            $this->em->persist($failed_job);
                        }
                    }
                    $this->em->persist($campaign_email);
                    $this->em->flush();
                }
            }
        }
    }


    function send_individual_admin_email()
    {
        set_time_limit(0);
        ignore_user_abort(1);

        $check = $this->getEmailRepository()->tryToSend($_POST);
        if (!$check['status']) {
            if (isset($_POST['uniqueArgVal'])) {
                $campaign_email = $this->em->find('\models\AdminGroupResendEmail', $_POST['uniqueArgVal']);
                if ($campaign_email) {
                    $campaign_email->setIsFailed(1);
                    $campaign_email->setSentAt(Carbon::now());
                    $this->em->persist($campaign_email);
                    $this->em->flush();
                }
            }
            if (isset($_POST['failed_individual_job_id'])) {
                $failed_job = $this->em->find('\models\FailedJob', $_POST['failed_individual_job_id']);
                if ($failed_job) {
                    $failed_job->setLastRetryAt(date('Y-m-d H:i:s'));
                    $failed_job->setErrorMessage($check['error_message']);
                    $this->em->persist($failed_job);
                    $this->em->flush();
                }
            } else {
                $failed_job = new \models\FailedJob();
                $failed_job->setJobName('send_individual_admin_email');
                $failed_job->setFailedAt(date('Y-m-d H:i:s'));
                $failed_job->setJobData(json_encode($_POST));
                $failed_job->setJobType('admin_campaign');
                $failed_job->setEntityId($_POST['accountId']);
                $failed_job->setCampaignId($_POST['campaignId']);
                $this->em->persist($failed_job);
                $this->em->flush();
            }

            $body = 'User Id: ' . $_POST['accountId'] . '<br/>Campaign Id: ' . $_POST['campaignId'];
            $basicEmailData = [
                'fromName' => SITE_NAME,
                'fromEmail' => 'noreply@' . SITE_EMAIL_DOMAIN,
                'subject' => 'Job Failed from send_admin_individual',
                'body' => $body,
                'to' => 'sunilyadav.acs@gmail.com',
            ];

            $this->getEmailRepository()->send($basicEmailData);
            $basicEmailData = [
                'fromName' => SITE_NAME,
                'fromEmail' => 'noreply@' . SITE_EMAIL_DOMAIN,
                'subject' => 'Job Failed from send_admin_individual',
                'body' => $body,
                'to' => 'andy@pavementlayers.com',
            ];

            $this->getEmailRepository()->send($basicEmailData);
        } else {
            if (isset($_POST['uniqueArgVal'])) {
                $campaign_email = $this->em->find('\models\AdminGroupResendEmail', $_POST['uniqueArgVal']);
                if ($campaign_email) {
                    $campaign_email->setSentAt(Carbon::now());

                    if (isset($_POST['failed_individual_job_id'])) {
                        $campaign_email->setIsFailed(0);

                        $failed_job = $this->em->find('\models\FailedJob', $_POST['failed_individual_job_id']);
                        if ($failed_job) {
                            $new_resend = $failed_job->getResend() + 100;
                            $failed_job->setResend($new_resend);
                            $this->em->persist($failed_job);
                        }
                    }
                    $this->em->persist($campaign_email);
                    $this->em->flush();
                }
            }
        }
    }

    function send_job_client_completed_mail()
    {
        set_time_limit(0);
        ignore_user_abort(1);

        if (isset($_POST['cgsId'])) {
            $account = $this->em->findAccount($_POST['account_id']);

            $cgs = $this->em->find('\models\ClientGroupResend', $_POST['cgsId']);
            $send_data = $this->getClientRepository()->getClientResendStats($cgs, $account);
            $this->load->model('system_email');
            $emailData = array(
                'sent_count' => $send_data['sent'],
                'failed_count' => $send_data['failed_count'],
                'sent_email_body' => $_POST['email_data']['body'],
            );

            $this->system_email->sendEmail(34, $account->getEmail(), $emailData);
        }
    }

    function send_job_lead_completed_mail()
    {
        set_time_limit(0);
        ignore_user_abort(1);
        if (isset($_POST['lgsId'])) {
            $account = $this->em->findAccount($_POST['account_id']);
            $lgs = $this->em->find('\models\LeadGroupResend', $_POST['lgsId']);
            $send_data = $this->getLeadRepository()->getLeadResendStats($lgs, $account);
            $this->load->model('system_email');
            $emailData = array(
                'sent_count' => $send_data['sent'],
                'failed_count' => $send_data['failed_count'],
                'sent_email_body' => $_POST['email_data']['body'],

            );
            $this->system_email->sendEmail(35, $account->getEmail(), $emailData);
        }
    }

    function send_job_prospect_completed_mail()
    {
        set_time_limit(0);
        ignore_user_abort(1);
        if (isset($_POST['pgsId'])) {
            $account = $this->em->findAccount($_POST['account_id']);
            $pgs = $this->em->find('\models\ProspectGroupResend', $_POST['pgsId']);
            $send_data = $this->getProspectRepository()->getProspectResendStats($pgs, $account);
            $this->load->model('system_email');
            $emailData = array(
                'sent_count' => $send_data['sent'],
                'failed_count' => $send_data['failed_count'],
                'sent_email_body' => $_POST['email_data']['body'],

            );
            $this->system_email->sendEmail(36, $account->getEmail(), $emailData);
        }
    }

    function send_job_admin_completed_mail()
    {
        set_time_limit(0);
        ignore_user_abort(1);
        if (isset($_POST['pgsId'])) {
            $account = $this->em->findAccount($_POST['account_id']);
            $ags = $this->em->find('\models\AdminGroupResend', $_POST['agsId']);
            $send_data = $this->getCompanyRepository()->getAdminResendStats($ags);
            $this->load->model('system_email');
            $emailData = array(
                'sent_count' => $send_data['sent'],
                'failed_count' => $send_data['failed_count'],
                'sent_email_body' => $_POST['email_data']['body'],
                'campaignName' => $_POST['agsName']
            );
            $this->system_email->sendEmail(37, $account->getEmail(), $emailData);
        }
    }

    function send_job_admin_completed_mail2()
    {
        set_time_limit(0);
        ignore_user_abort(1);

        $this->load->model('system_email');
        $emailData = array(
            'sent_count' => $_POST['sent'],
            'failed_count' => 0,
            'sent_email_body' => 'test',
            'campaignName' => 'test'
        );
        $this->system_email->sendEmail(37, 'sunilyadav.acs@gmail.com', $emailData);
    }


    function client_individual_exclude_include_email()
    {
        set_time_limit(0);
        ignore_user_abort(1);
        $account = $this->em->findAccount($_POST['account_id']);


        $client = $this->em->find('\models\Clients', $_POST['client_id']);
        $proposals = $client->getProposals();

        foreach ($proposals as $proposal) {
            // $proposal->setResendExcluded($_POST['exclude']);
            // $this->em->persist($proposal);
            $this->log_manager->add(\models\ActivityAction::EXCLUDE_PROPOSAL_FROM_EMAIL, 'Proposal Exclude from email Campaign', $proposal->getClient(), $proposal);
            //Event Log
            $this->getProposalEventRepository()->proposalEmailExcluded($proposal, $account);

            //$this->em->flush();
        }
    }

    private function render($saveToFile, $layout, $fileName, $proposal, $proposal_id)
    {
        $benchmark_start = time();
        //get proposal data
        $data = array();
        $data['lumpSum'] = false;

        //$data['layout'] = $layout;

        $data['hideTotalPrice'] = 0;

        $data['fileName'] = $fileName;

        //$proposal = $this->em->find('models\Proposals', $proposal_id);

        if ($proposal) {
            $data['layout'] = $proposal->getNewLayout();
            if ($proposal->getNewLayout() == 'cool2' || $proposal->getNewLayout() == 'standard2' || $proposal->getNewLayout() == 'gradient2' || $proposal->getNewLayout() == 'web-cool2' || $proposal->getNewLayout() == 'web-standard2' || $proposal->getNewLayout() == 'web-custom2') {
                $data['layout'] = substr($proposal->getNewLayout(), 0, -1);
                $data['hideTotalPrice'] = 1;
            }
            if ($proposal->getNewLayout() == 'cool3' || $proposal->getNewLayout() == 'standard3' || $proposal->getNewLayout() == 'gradient3' || $proposal->getNewLayout() == 'web-cool3' || $proposal->getNewLayout() == 'web-standard3' || $proposal->getNewLayout() == 'web-custom3') {
                $data['layout'] = substr($proposal->getNewLayout(), 0, -1);
                $data['lumpSum'] = 1;
            }
            
                if($data['layout'] == 'web-custom'){
                    $data['layout'] = 'gradient';
                }
                $data['layout'] = str_replace("web-","",$data['layout']);
            
        }
        $data['proposal'] = $proposal;
        $data['clientSig'] = $this->getProposalRepository()->getClientSignee($proposal);
        $data['companySig'] = $this->getProposalRepository()->getCompanySignee($proposal);
        $data['clientSignature'] = $this->getProposalRepository()->getClientSignature($proposal);
        $data['companySignature'] = $this->getProposalRepository()->getCompanySignature($proposal);
        $data['estimationRepository'] = $this->getEstimationRepository();
        $data['proposal_videos'] = $this->getProposalRepository()->getProposalVisibleProposalVideos($proposal->getProposalId());
        $data['proposal_intro_video'] = $this->getProposalRepository()->getProposalIntroVideo($proposal->getProposalId());
        
        // for proposal check list
        $data['proposalChecklistData'] = $this->em->getRepository('models\ProposalCustomerCheckList')->findOneBy(array(
            'proposal_id' => $proposal_id
            ));
            // $proposalChecklist = $this->account()->getCompany()->getProposalChecklist(); 
                 $proposalChecklist =  $this->getProposalRepository()->getCompanyCustomerChecklist($proposal);
            //  echo "<pre>test ";print_r($proposalChecklist);die;
            // echo  $proposal->getCompanyId();die;
            if ($proposalChecklist==0) {
                 $data['checkProposalChecklist'] = 0; //inactive
            }else{
                 $data['checkProposalChecklist'] = 1; //active
            }  
        //for proposal check list close


        $query = $this->em->createQuery('SELECT p FROM models\Proposals_items p where p.proposal=' . $proposal->getProposalId() . ' order by p.ord');
        $proposal_items = $query->getResult();
        $specs = array();
        foreach ($proposal_items as $proposalItem) {
            $proposalSpecs = $proposalItem->getSpecs();
            if (count($proposalSpecs)) {
                foreach ($proposalSpecs as $key => $val) {
                    foreach ($val as $key2 => $val2) {
                        $specs[$key][$key2] = $val2;
                    }
                }
            }
        }
        $data['proposal_items'] = $proposal_items;
        $data['specs'] = $specs;
        /*
         *  New Service System
         */
        //get services
        //$services = $this->em->createQuery('select s from models\Proposal_services s where s.proposal=' . $proposal->getProposalId() . ' AND s.approved = 1 order by s.ord')->getResult();
        $services = $this->getProposalRepository()->getNonHiddenServices($proposal->getProposalId());
        $data['services'] = $services;
        $data['service_images'] = [];
        //get the texts
        $texts = array();
        foreach ($services as $service) {
            //get fields
            $fields = array();
            //item fields
            $fds = $this->em->createQuery('select f from models\ServiceField f where f.service=' . $service->getInitialService())->getResult();
            foreach ($fds as $field) {
                $fields[$field->getFieldCode()] = $field->getFieldValue();
            }
            $fds2 = $this->em->createQuery('select f from models\Proposal_services_fields f where f.serviceId=' . $service->getServiceId())->getResult();
            foreach ($fds2 as $field) {
                $fields[$field->getFieldCode()] = $field->getFieldValue();
            }
            $s = array('<p>', '</p>');
            $r = array('', '');
            foreach ($fields as $code => $value) {
                $s[] = '{' . $code . '}';
                $r[] = trim($value);
            }
            $t = '<ol>';
            $txts = $this->em->createQuery('select t from models\Proposal_services_texts t where t.serviceId=' . $service->getServiceId() . ' order by t.ord')->getResult();
            foreach ($txts as $text) {
                $t .= '<li>' . str_replace($s, $r, trimNewline(html_entity_decode($text->getText()))) . '</li>';
            }
            $t .= '</ol>';
            $texts[$service->getServiceId()] = $t;


            $service_images = $this->em->createQuery('SELECT i FROM models\Proposals_images i  where i.proposal_service_id = ' . $service->getServiceId() . '  AND i.proposal=' . $proposal->getProposalId() . ' order by i.ord')->getResult();

            $temp_service_id = $service->getServiceId();
            if (count($service_images)) {
                $imgIndex = 0;

                // Create an array for the image
                // ['image'] is the object
                // ['src'] is the encoded src
                // ['path'] is the file path
                foreach ($service_images as $image) {
                    /* @var $image \models\Proposals_images */
                    $path = $image->getFullPath();
                    $img = $this->imageManager->make($path);

                    if ($img) {
                        $data['service_images'][$temp_service_id][$imgIndex]['image'] = $image;
                        $data['service_images'][$temp_service_id][$imgIndex]['path'] = $img->basePath();
                        $data['service_images'][$temp_service_id][$imgIndex]['width'] = $img->getWidth();
                        $data['service_images'][$temp_service_id][$imgIndex]['height'] = $img->getHeight();
                        $data['service_images'][$temp_service_id][$imgIndex]['id'] = $image->getImageId();
                        $data['service_images'][$temp_service_id][$imgIndex]['orientation'] = ($data['service_images'][$temp_service_id][$imgIndex]['width']
                            >= $data['service_images'][$temp_service_id][$imgIndex]['height']) ? 'landscape' : 'portrait';
                        $data['service_images'][$temp_service_id][$imgIndex]['src'] = $img->encode('data-url');
                        $data['service_images'][$temp_service_id][$imgIndex]['websrc'] = site_url($image->getWebPath());

                        $imgIndex++;
                    }
                }
            }
        }

        $data['services_texts'] = $texts;
        //load pdf renderer
        //$this->load->library('Dompdf_library');
        //load content
        ob_start();
        $images = $this->em->createQuery('SELECT i FROM models\Proposals_images i  where i.proposal=' . $proposal->getProposalId() . ' AND i.map = 0 AND i.proposal_service_id IS NULL order by i.ord')->getResult();
        $data['images'] = [];
        if (count($images)) {
            $imgIndex = 0;

            // Create an array for the image
            // ['image'] is the object
            // ['src'] is the encoded src
            // ['path'] is the file path
            foreach ($images as $image) {
                /* @var $image \models\Proposals_images */
                $path = $image->getFullPath();
                $img = $this->imageManager->make($path);

                if ($img) {
                    $data['images'][$imgIndex]['image'] = $image;
                    $data['images'][$imgIndex]['path'] = $img->basePath();
                    $data['images'][$imgIndex]['width'] = $img->getWidth();
                    $data['images'][$imgIndex]['height'] = $img->getHeight();
                    $data['images'][$imgIndex]['id'] = $image->getImageId();
                    $data['images'][$imgIndex]['orientation'] = ($data['images'][$imgIndex]['width']
                        >= $data['images'][$imgIndex]['height']) ? 'landscape' : 'portrait';
                    $data['images'][$imgIndex]['src'] = $img->encode('data-url');
                    $data['images'][$imgIndex]['websrc'] = site_url($image->getWebPath());

                    $imgIndex++;
                }
            }
        }

         //Map Images
         $mapImages = $this->em->createQuery('SELECT i FROM models\Proposals_images i  where i.proposal=' . $proposal->getProposalId() . ' AND i.map = 1 AND i.proposal_service_id IS NULL order by i.ord')->getResult();
         $data['map_images'] = [];
         if (count($mapImages)) {
 
             $imgIndex = 0;
 
             // Create an array for the image
             // ['image'] is the object
             // ['src'] is the encoded src
             // ['path'] is the file path
             foreach ($mapImages as $image) {
                 /* @var $image \models\Proposals_images */
                 $path = $image->getFullPath();
                 try{
                     $img = $this->imageManager->make($path);
  
                     $data['map_images'][$imgIndex]['image'] = $image;
                     $data['map_images'][$imgIndex]['path'] = $img->basePath();
                     $data['map_images'][$imgIndex]['width'] = $img->getWidth();
                     $data['map_images'][$imgIndex]['height'] = $img->getHeight();
                     $data['map_images'][$imgIndex]['id'] = $image->getImageId();
                     $data['map_images'][$imgIndex]['orientation'] = ($data['map_images'][$imgIndex]['width']
                         >= $data['map_images'][$imgIndex]['height']) ? 'landscape' : 'portrait';
                     $data['map_images'][$imgIndex]['src'] = $img->encode('data-url');
                     $data['map_images'][$imgIndex]['websrc'] = site_url($image->getWebPath());
 
                     $imgIndex++;
                 }
                 catch(Exception $e){
                    
                 }
             }
         }
        $proposal_attachments = $this->em->createQuery('SELECT i FROM models\Proposal_attachments i  where i.proposalId=' . $proposal->getProposalId() . ' and i.proposal=1 order by i.ord')->getResult();
        $data['proposal_attachments'] = $proposal_attachments;
        $workorder_attachments = $this->em->createQuery('SELECT i FROM models\Proposal_attachments i  where i.proposalId=' . $proposal->getProposalId() . ' and i.work_order=1 order by i.ord')->getResult();
        $data['workorder_attachments'] = $workorder_attachments;

        $data['layoutOption'] = $proposal->getLayout();
        if (is_numeric(substr($proposal->getLayout(), -1))) {
            $data['layoutOption'] = substr($proposal->getLayout(), 0, -1);
        }
        
        $section_layout_id = 1;
        if($data['layoutOption'] == 'standard'){
            $section_layout_id = 2;
        }else if($data['layoutOption'] == 'gradient'){
            $section_layout_id = 3;
        }
        $data['proposalSections'] = $this->getCompanyRepository()->getIndividualProposalSections($proposal,$section_layout_id);
        
        // Do we need to load some PSA data?
        if ($proposal->getInventoryReportUrl()) {
            $this->load->library('psa_client', ['public' => true]);
            $data['inventoryData'] = $this->psa_client->inventoryData(['reportKey' => $proposal->getInventoryReportUrl()]);
        }


        $this->load->view('pdf/layouts/' . $data['layout'], $data);
        $html = ob_get_contents();
        ob_end_clean();
 
        //PDF Options
        $pdfOptions = new \Dompdf\Options();
        $pdfOptions->setIsPhpEnabled(true);

        // PDF
        $dompdf = new Dompdf\Dompdf($pdfOptions);


        $dompdf->loadHtml($html);

        $dompdf->render();

        $pdf = $dompdf->output();

        file_put_contents($saveToFile, $pdf);
    }


    function company_video_delete()
    {
        set_time_limit(0);
        ignore_user_abort(1);


        $video_id = $_POST['video_id'];

        $proposalVideos = $this->getProposalRepository()->getAllCompanyProposalsVideoByVideoId($video_id);


        foreach ($proposalVideos as $video) {
            $proposal = $this->em->findProposal($video->getProposalId());

            $this->log_manager->add(
                \models\ActivityAction::COMPANY_PROPOSAL_VIDEO_DELETE,
                "Proposal Default Video Deleted:" . $video->getTitle(),
                $proposal->getClient(),
                $proposal,
                $proposal->getClient()->getCompany(),
                $_POST['accountId'],
                null,
                null
            );
            $this->em->remove($video);
        }
        $this->em->flush();
    }


    function proposalViewedEmailSend()
    {
        $proposal_view_id =  $_POST['proposalViewId'];
        $proposalView = $this->em->find('\models\ProposalView', $proposal_view_id);

        $proposal_preview = $this->em->find('models\ProposalPreviewLink', $proposalView->getProposalLinkId());

        $proposal = $this->em->findProposal($proposalView->getProposalId());
        
        $created_at = Carbon::createFromFormat('Y-m-d H:i:s', $proposalView->getCreatedAt())->format('m/d/y g:iA');
        $formattedDuration = secondsToTime($proposalView->getTotalDuration());
        $timeSection = $this->load->view('proposals/email_template/timeSection', array( 'formattedDuration' => $formattedDuration), true);

        $headSection = $this->load->view('proposals/email_template/headerTitle', array('proposal' => $proposal), true);
        $viewerSection = $this->load->view('proposals/email_template/viewerSection', array('created_at' => $created_at,'proposal' => $proposal, 'proposal_preview' => $proposal_preview), true);
        $mobileViewerSection = $this->load->view('proposals/email_template/mobileViewerSection', array('created_at' => $created_at,'proposal' => $proposal, 'proposal_preview' => $proposal_preview,'formattedDuration' => $formattedDuration), true);
        $pageTable = $this->load->view('proposals/email_template/pageTable', array('proposalView' => $proposalView), true);
        $mobilePageTable = $this->load->view('proposals/email_template/mobilePageTable', array('proposalView' => $proposalView), true);
        $userAgentSection = $this->load->view('proposals/email_template/userAgent', array('proposalView' => $proposalView), true);
        $mobileUserAgentSection = $this->load->view('proposals/email_template/mobileUserAgent', array('proposalView' => $proposalView), true);
        $auditSection = $this->load->view('proposals/email_template/auditSection', array('proposalView' => $proposalView), true);
        $imageSection = $this->load->view('proposals/email_template/imageSection', array('proposalView' => $proposalView), true);
        $mobileImageSection = $this->load->view('proposals/email_template/mobileImageSection', array('proposalView' => $proposalView), true);
        $videoSection = $this->load->view('proposals/email_template/videoSection', array('proposalView' => $proposalView), true);
        $serviceSection = $this->load->view('proposals/email_template/serviceLinkSection', array('proposalView' => $proposalView), true);

        $data['email'] = $proposal_preview->getEmail();

        // Proposal
        $proposalData = [];
        $proposalData['projectName'] = $proposal->getProjectName();
        $proposalData['address'] = [
            'address' => $proposal->getProjectAddress(),
            'city' => $proposal->getProjectCity(),
            'state' => $proposal->getProjectState(),
            'zip' => $proposal->getProjectZip(),
        ];

        // CLient
        $clientData = [];
        $clientData['accountName'] = $proposal->getClient()->getClientAccount()->getName();

        $clientData['firstName'] = $proposal->getClient()->getFirstName();
        $clientData['lastName'] = $proposal->getClient()->getLastName();
        // Belongs to the proposal
        $proposalData['client'] = $clientData;


        $data['proposalData'] = $proposalData;


        if ($proposal->getAuditKey()) {
            $auditHasLink = true;
        } else {
            $auditHasLink = false;
        }

        $data['service_text_viewed'] = $proposalView->getServiceTextViewedTime();
        if ($proposal->getVideoURL() <> '') {
            $videoHasLink = true;
        } else {
            $videoHasLink = false;
        }


        $data['signed'] = $proposalView->getSigned();
        $data['printed'] = $proposalView->getPrinted();
        $data['ipAddress'] = $proposalView->getIpAddress();


        $action = 'Viewed';
        $cli = $proposal->getClient()->getClientAccount()->getName();
        $this->load->model('system_email');
        $email_data = array(
            'first_name' => $proposal->getOwner()->getFirstName(),
            'last_name' => $proposal->getOwner()->getLastName(),
            'viewed' => $action,
            'projectName' => $proposal->getProjectName(),
            'client_company' => $cli,
            'time' => date('m/d/Y h:i:s A', realTime(time())),
            'mapIp' => mapIP($_SERVER['REMOTE_ADDR'], '', true),
            'client_first' => $proposal->getClient()->getFirstName(),
            'client_last' => $proposal->getClient()->getLastName(),
            'client_cell_phone' => $proposal->getClient()->getCellPhone(),
            'client_office_phone' => $proposal->getClient()->getBusinessPhone(),
            'client_email' => $proposal->getClient()->getEmail(),
            'proposal_url' => $proposal_preview->getUrl(),
            'headerSection' => $headSection,
            'viewerSection' => $viewerSection,
            'mobileViewerSection' => $mobileViewerSection,
            'pageTable' => $pageTable,
            'mobilePageTable' => $mobilePageTable,
            'auditSection' => $auditSection,
            'imageSection' => $imageSection,
            'mobileImageSection' => $mobileImageSection,
            'timeSection' => $timeSection,
            'userAgentSection' => $userAgentSection,
            'mobileUserAgentSection' => $mobileUserAgentSection,
            'videoSection' => $videoSection,
            'mobileVideoSection' => $videoSection,
            'serviceSection' => $serviceSection,
            'mobileServiceSection' => $serviceSection,
            'proposalPreviewUrl' => $proposal_preview->getUrl(),
            'siteName'   => SITE_NAME,
        );
       

        $this->system_email->sendEmail(47, $proposal->getOwner()->getEmail(), $email_data);
        $proposalView->setEmailSent(models\ProposalView::EMAIL_SENT);

        $this->em->persist($proposalView);
        $this->em->flush();
        
    }

    
    function job_create_proposal_pdf_cache(){
        
        $proposal_id =  $_POST['proposal_id'];
        //$proposal_id =  '196056';
        $proposal = $this->em->findProposal($proposal_id);

        $cache_file_name = 'plproposal_' . $proposal_id . '.pdf';
        $cache_directory = CACHEDIR . '/proposals/' . $proposal->getNewLayout() . '/';
        //check if directory exists
        if (!is_dir($cache_directory)) {
            mkdir($cache_directory, 755, true);
        }
        $cache_file = $cache_directory . $cache_file_name;
        
        
        //check if file exists
        if (!file_exists($cache_file)  || $proposal->needsRebuild() ) {
            $this->renderProposal($proposal,$cache_file);
            $proposal->setRebuildFlag(0, true, true, false);
            $this->em->persist($proposal);
            $this->em->flush();
        }

        
        

    }



    public function renderProposal($proposal,$saveToFile)
    {
        
        $benchmark_start = time();
        //get proposal data
        $data = array();
        $data['lumpSum'] = false;
        $data['fileName'] = 'Proposal';
        $data['showPreProposalPopup'] = 1;
        $data['showCompanySignatureButton'] = 0;

        if ($proposal) {
            $data['layout'] = $proposal->getNewLayout();
            if ($proposal->getNewLayout() == 'cool2' || $proposal->getNewLayout() == 'standard2' || $proposal->getNewLayout() == 'gradient2' || $proposal->getNewLayout() == 'web-cool2' || $proposal->getNewLayout() == 'web-standard2' || $proposal->getNewLayout() == 'web-custom2') {
                $data['layout'] = substr($proposal->getNewLayout(), 0, -1);
                $data['hideTotalPrice'] = 1;
            }
            if ($proposal->getNewLayout() == 'cool3' || $proposal->getNewLayout() == 'standard3' || $proposal->getNewLayout() == 'gradient3' || $proposal->getNewLayout() == 'web-cool3' || $proposal->getNewLayout() == 'web-standard3' || $proposal->getNewLayout() == 'web-custom3') {
                $data['layout'] = substr($proposal->getNewLayout(), 0, -1);
                $data['lumpSum'] = 1;
            }
            
                if($data['layout'] == 'web-custom'){
                    $data['layout'] = 'gradient';
                }
                $data['layout'] = str_replace("web-","",$data['layout']);
            
        } else {
            $this->load->view('pdf/proposal_not_found');
        }


        if ($data['layout'] == 'web-cool' || $data['layout'] == 'web-standard' || $data['layout'] == 'web-custom') {


            if ($data['layout'] == 'web-cool') {
                $data['template'] = 'web-cool';
            }else if ($data['layout'] == 'web-custom') {
                $data['template'] = 'web-custom';
            } else {
                $data['template'] = 'web-standard';
            }
            $data['layout'] = 'web-cool-standard';
        }


        // print_r($this->getProposalRepository()->getClientSignature($proposal));die;
        $data['proposal'] = $proposal;
        $data['uuid'] = $this->uri->segment(2);
        $data['clientSig'] = $this->getProposalRepository()->getClientSignee($proposal);
        $data['companySig'] = $this->getProposalRepository()->getCompanySignee($proposal);
        $data['clientSignature'] = $this->getProposalRepository()->getClientSignature($proposal);
        $data['companySignature'] = $this->getProposalRepository()->getCompanySignature($proposal);
        
        $data['estimationRepository'] = $this->getEstimationRepository();
        $query = $this->em->createQuery('SELECT p FROM models\Proposals_items p where p.proposal=' . $proposal->getProposalId() . ' order by p.ord');
        $proposal_items = $query->getResult();
        $specs = array();
        foreach ($proposal_items as $proposalItem) {
            $proposalSpecs = $proposalItem->getSpecs();
            if (count($proposalSpecs)) {
                foreach ($proposalSpecs as $key => $val) {
                    foreach ($val as $key2 => $val2) {
                        $specs[$key][$key2] = $val2;
                    }
                }
            }
        }
        $data['proposal_items'] = $proposal_items;
        $data['specs'] = $specs;
        /*
         *  New Service System
         */
        //get services
        //$services = $this->em->createQuery('select s from models\Proposal_services s where s.proposal=' . $proposal->getProposalId() . ' AND s.approved = 1 order by s.ord')->getResult();
        $services = $this->getProposalRepository()->getNonHiddenServices($proposal->getProposalId());
        $data['services'] = $services;
        $data['service_images'] = [];
        //get the texts
        $texts = array();
        foreach ($services as $service) {
            //get fields
            $fields = array();
            //item fields
            $fds = $this->em->createQuery('select f from models\ServiceField f where f.service=' . $service->getInitialService())->getResult();
            foreach ($fds as $field) {
                $fields[$field->getFieldCode()] = $field->getFieldValue();
            }
            $fds2 = $this->em->createQuery('select f from models\Proposal_services_fields f where f.serviceId=' . $service->getServiceId())->getResult();
            foreach ($fds2 as $field) {
                $fields[$field->getFieldCode()] = $field->getFieldValue();
            }
            $s = array('<p>', '</p>');
            $r = array('', '');
            foreach ($fields as $code => $value) {
                $s[] = '{' . $code . '}';
                $r[] = trim($value);
            }
            $t = '<ol>';
            $txts = $this->em->createQuery('select t from models\Proposal_services_texts t where t.serviceId=' . $service->getServiceId() . ' order by t.ord')->getResult();
            foreach ($txts as $text) {
                $t .= '<li>' . str_replace($s, $r, trimNewline(html_entity_decode($text->getText()))) . '</li>';
            }
            $t .= '</ol>';
            $texts[$service->getServiceId()] = $t;


            $service_images = $this->em->createQuery('SELECT i FROM models\Proposals_images i  where i.proposal_service_id = '.$service->getServiceId().'  AND i.proposal=' . $proposal->getProposalId() . ' order by i.ord')->getResult();
            
            $temp_service_id = $service->getServiceId();
            if (count($service_images)) {
    
                $imgIndex = 0;
    

                foreach ($service_images as $image) {
                    /* @var $image \models\Proposals_images */
                    $path = $image->getFullPath();
                    try{
                        $img = $this->imageManager->make($path);
                        
                        $data['service_images'][$temp_service_id][$imgIndex]['image'] = $image;
                        $data['service_images'][$temp_service_id][$imgIndex]['path'] = $img->basePath();
                        $data['service_images'][$temp_service_id][$imgIndex]['width'] = $img->getWidth();
                        $data['service_images'][$temp_service_id][$imgIndex]['height'] = $img->getHeight();
                        $data['service_images'][$temp_service_id][$imgIndex]['id'] = $image->getImageId();
                        $data['service_images'][$temp_service_id][$imgIndex]['orientation'] = ($data['service_images'][$temp_service_id][$imgIndex]['width']
                            >= $data['service_images'][$temp_service_id][$imgIndex]['height']) ? 'landscape' : 'portrait';
                        $data['service_images'][$temp_service_id][$imgIndex]['src'] = $img->encode('data-url');
                        $data['service_images'][$temp_service_id][$imgIndex]['websrc'] = site_url($image->getWebPath());
    
                        $imgIndex++;
                        
                    }
                    catch(Exception $e){
                       
                    }
                    
    
                }

                
            }
        }

        $data['services_texts'] = $texts;

        ob_start();
        $images = $this->em->createQuery('SELECT i FROM models\Proposals_images i  where i.proposal=' . $proposal->getProposalId() . ' AND i.map = 0 AND i.proposal_service_id IS NULL order by i.ord')->getResult();
        $data['images'] = [];
        if (count($images)) {

            $imgIndex = 0;

            foreach ($images as $image) {
                /* @var $image \models\Proposals_images */
                $path = $image->getFullPath();
                try{
                    $img = $this->imageManager->make($path);
 
                    $data['images'][$imgIndex]['image'] = $image;
                    $data['images'][$imgIndex]['path'] = $img->basePath();
                    $data['images'][$imgIndex]['width'] = $img->getWidth();
                    $data['images'][$imgIndex]['height'] = $img->getHeight();
                    $data['images'][$imgIndex]['id'] = $image->getImageId();
                    $data['images'][$imgIndex]['orientation'] = ($data['images'][$imgIndex]['width']
                        >= $data['images'][$imgIndex]['height']) ? 'landscape' : 'portrait';
                    $data['images'][$imgIndex]['src'] = $img->encode('data-url');
                    $data['images'][$imgIndex]['websrc'] = site_url($image->getWebPath());

                    $imgIndex++;
                }
                catch(Exception $e){
                   
                }
            }
        }
         //Map Images
         $mapImages = $this->em->createQuery('SELECT i FROM models\Proposals_images i  where i.proposal=' . $proposal->getProposalId() . ' AND i.map = 1 AND i.proposal_service_id IS NULL order by i.ord')->getResult();
         $data['map_images'] = [];
         if (count($mapImages)) {
 
             $imgIndex = 0;
 
             // Create an array for the image
             // ['image'] is the object
             // ['src'] is the encoded src
             // ['path'] is the file path
             foreach ($mapImages as $image) {
                 /* @var $image \models\Proposals_images */
                 $path = $image->getFullPath();
                 try{
                     $img = $this->imageManager->make($path);
  
                     $data['map_images'][$imgIndex]['image'] = $image;
                     $data['map_images'][$imgIndex]['path'] = $img->basePath();
                     $data['map_images'][$imgIndex]['width'] = $img->getWidth();
                     $data['map_images'][$imgIndex]['height'] = $img->getHeight();
                     $data['map_images'][$imgIndex]['id'] = $image->getImageId();
                     $data['map_images'][$imgIndex]['orientation'] = ($data['map_images'][$imgIndex]['width']
                         >= $data['map_images'][$imgIndex]['height']) ? 'landscape' : 'portrait';
                     $data['map_images'][$imgIndex]['src'] = $img->encode('data-url');
                     $data['map_images'][$imgIndex]['websrc'] = site_url($image->getWebPath());
 
                     $imgIndex++;
                 }
                 catch(Exception $e){
                    
                 }
             }
         }

        $proposal_attachments = $this->em->createQuery('SELECT i FROM models\Proposal_attachments i  where i.proposalId=' . $proposal->getProposalId() . ' and i.proposal=1 order by i.ord')->getResult();
        $data['proposal_attachments'] = $proposal_attachments;
        $workorder_attachments = $this->em->createQuery('SELECT i FROM models\Proposal_attachments i  where i.proposalId=' . $proposal->getProposalId() . ' and i.work_order=1 order by i.ord')->getResult();
        $data['workorder_attachments'] = $workorder_attachments;
        $data['proposal_videos'] = $this->getProposalRepository()->getProposalVisibleProposalVideos($proposal->getProposalId());
        $data['proposal_intro_video'] = $this->getProposalRepository()->getProposalIntroVideo($proposal->getProposalId());
        $data['work_order_videos'] = $this->getProposalRepository()->getWorkOrderVisibleProposalVideos($proposal->getProposalId());
        $data['work_order_intro_video'] = $this->getProposalRepository()->getWorkOrderVisibleIntroVideos($proposal->getProposalId());

        $data['layoutOption'] = $proposal->getLayout();

        if (is_numeric(substr($proposal->getLayout(), -1))) {
            $data['layoutOption'] = substr($proposal->getLayout(), 0, -1);
        }
        

        $section_layout_id = 1;

        if($data['layoutOption'] == 'standard'){
            $section_layout_id = 2;
        }else if($data['layoutOption'] == 'gradient'){
            $section_layout_id = 3;
        }

        $data['proposalSections'] = $this->getCompanyRepository()->getIndividualProposalSections($proposal,$section_layout_id);

        // Do we need to load some PSA data?
        if ($proposal->getInventoryReportUrl()) {
            $this->load->library('psa_client', ['public' => true]);
            $data['inventoryData'] = $this->psa_client->inventoryData(['reportKey' => $proposal->getInventoryReportUrl()]);
        }

        $data['track_activity'] = 1;
        $data['nosidebar'] = 1;

        $this->load->view('pdf/layouts/' . $data['layout'], $data);

            $html = ob_get_contents();
            ob_end_clean();
           
            //PDF Options
            $pdfOptions = new \Dompdf\Options();
            $pdfOptions->setIsPhpEnabled(true);

            echo $pdfOptions;die;

            // PDF
            $dompdf = new Dompdf\Dompdf($pdfOptions);
            
            $dompdf->loadHtml($html);
           
            $dompdf->render();
            $pdf = $dompdf->output();
            file_put_contents($saveToFile, $pdf);

    }

    public function userProposalPermissionEmail(){
        $proposal_id =  $_POST['proposal_id'];
        $user_id =  $_POST['user_id'];
        $permissionGrantor =  $_POST['permissionGrantor'];

        
        $user = $this->em->findAccount($user_id);
        $proposal = $this->em->findProposal($proposal_id);
        
            $this->load->model('system_email');
            $emailData = array(
                'siteLogoUrl' => site_url('/uploads/clients/logos/'.$proposal->getClient()->getCompany()->getCompanyEmailLogo()),
                'siteName' => SITE_NAME,
                'projectName' => $proposal->getProjectname(),
                'permittedUserFirstName' => $user->getFirstName(),
                'permissionGrantor' => $permissionGrantor,
            );
            
            $this->system_email->sendEmail(51, $user->getEmail(), $emailData);
        
    }

   function proposalPriceModifyStatus(){
    
        $this->getProposalRepository()->modifyPricesByStatus($_POST['ids'], $_POST['modifier'],$_POST['pModifyFrom'],$_POST['pModifyTo'], $_POST['account_id'], $_POST['ip_address']);
   }



   function individualProposalPriceModify(){
        if(isset($_POST['price_log_id'])){

            $this->getProposalRepository()->individualModifyPrices($_POST['proposalId'], $_POST['account_id'], $_POST['modifier'], $_POST['price_log_id']);
        }else{
            $this->getProposalRepository()->individualModifyPrices($_POST['proposalId'], $_POST['account_id'], $_POST['modifier']);
        }
        
    }

    function groupProposalPriceModify(){
    
        $this->getProposalRepository()->groupModifyPrices($_POST['ids'], $_POST['modifier'], $_POST['account_id'], $_POST['ip_address']);
   }
    

   function completeProposalPriceModify(){
    
        //$this->getProposalRepository()->completeProposalPriceModify($_POST['proposalCount'], $_POST['modifier'], $_POST['account_id']);

        $user = $this->em->findAccount($_POST['account_id']);
       
        $pm = $this->em->find('\models\PriceModification',  $_POST['price_log_id']);
        
        $this->load->model('system_email');
        $emailData = array(
            'modifier' => +($_POST['modifier']),
            'proposalCount' => $pm->getProposalsModified(),
            'userName' => $user->getFullName(),
            'siteName' => SITE_NAME,
            'status'   => $_POST['status'],
            'date'  => date("m/d/Y",$_POST['pModifyFrom']).' - '.date("m/d/Y",$_POST['pModifyTo']),
        );

        $this->system_email->sendEmail(54, $user->getEmail(),$emailData);

        $pm->setCompleted(1);
        $this->em->persist($pm);
        $this->em->flush();
    }

    function completeGroupProposalPriceModify(){
    
        //$this->getProposalRepository()->completeProposalPriceModify($_POST['proposalCount'], $_POST['modifier'], $_POST['account_id']);

        $user = $this->em->findAccount($_POST['account_id']);
       
        
        $this->load->model('system_email');
        $emailData = array(
            'modifier' => +($_POST['modifier']),
            'proposalCount' => $_POST['proposalCount'],
            'userName' => $user->getFullName(),
            'siteName' => SITE_NAME,
            'date'  => date("m/d/Y"),
        );

        $this->system_email->sendEmail(55, $user->getEmail(),$emailData);
    }
   
}
