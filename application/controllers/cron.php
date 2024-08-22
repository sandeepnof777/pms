<?php
use Pms\Cron\LeadNotificationsCron;
use Carbon\Carbon;
class Cron extends MY_Controller
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    var $em;
    /**
     * @var System_email
     */
    var $system_email;
    /**
     * @var Queue
     */
    var $queue;

    function __construct()
    {
        set_time_limit(1500);
        parent::__construct();
    }

    function flash_all()
    {
        $this->_ci = &get_instance();
        $this->_ci->load->library('redis2');
        $this->_ci->redis2->flushAll();
     }

    function run()
    {
        //running every 5/10 minutes on the server
        /*
         * Emails -- The only queue we have at the moment but at given times in the future we may create additional functionality of this daemon
         * */
        $this->load->model('system_email');
        $queued_emails = $this->em->createQuery('select e from models\Email_queue e where e.completed=0 and e.due<' . time())->getResult();
        $emails = array();
        $k = 0;
        foreach ($queued_emails as $email) {
            echo $email->getTaskId() . '<br>';
            $this->system_email->send_mail($email->getRecipient(), $email->getSubject(), $email->getBody(),
                $email->getFromName() . ' <' . $email->getFromEmail() . '>',false,[],$email->getReplyTo());

            $email->setCompleted(1);
            $emails[$k] = $email;
            $this->em->persist($emails[$k]);
            $k++;
        }
        $this->em->flush();

    }



    function silent()
    {
        echo('current time:' . time());
        $queued_emails = $this->em->createQuery('select e from models\Email_queue e where e.completed=0 and e.due<' . time())->getResult();
        foreach ($queued_emails as $email) {
            echo $email->getTaskId() . '<br>';
        }
    }

    /**
     *  Clear the cache directories of files modified more than 12 hours ago
     */
    function cache()
    {

        // The list of directories
        $cacheDirs = array(
            'cache/proposals/cool/',
            'cache/proposals/cool2/',
            'cache/proposals/cool3/',
            'cache/proposals/standard/',
            'cache/proposals/standard2/',
            'cache/proposals/standard3/',
            'cache/proposals/gradient/',
            'cache/proposals/gradient2/',
            'cache/proposals/gradient3/',
            'cache/proposals/work_order/',
            'cache/proposals/web-cool/',
            'cache/proposals/web-cool2/',
            'cache/proposals/web-cool3/',
            'cache/proposals/web-standard/',
            'cache/proposals/web-standard2/',
            'cache/proposals/web-standard3/',
            'cache/proposals/web-custom/',
            'cache/proposals/web-custom2/',
            'cache/proposals/web-custom3/',
        );

        // Cut off time
        $clearTime = time() - (21600); // 6 hours

        // File Counter
        $filesDeleted = 0;

        // Memory Counter
        $memory = 0;

        // Iterate through each dir
        foreach ($cacheDirs as $cacheDir) {

            if (is_dir(FCPATH .$cacheDir)) {
                // Iterate through the files in the dir
                foreach (new DirectoryIterator($cacheDir) as $fileInfo) {
                    /* @var SplFileInfo $fileInfo */

                    // Ignore dots
                    if (!$fileInfo->isDot()) {
                        //modified time
                        $modified = $fileInfo->getMTime();
                        $size = $fileInfo->getSize();

                        // If old enough, remove
                        if ($modified < $clearTime) {

                            // Build the file path
                            $filePath = FCPATH . $cacheDir . $fileInfo->getFilename();

                            if (!strstr($filePath, 'demo_')) {

                                // Delete
                                unlink($filePath);

                                // Check it is gone
                                if (!file_exists($filePath)) {
                                    // Update the counters
                                    $filesDeleted++;
                                    $memory = ($memory + $size);
                                }
                            }
                        }
                    }
                }
            }
        }

        // Make the memory readable
        $readableMemory = human_filesize($memory);

        $emailData = [
            'to' => 'support@' . SITE_EMAIL_DOMAIN,
            'fromName' => SITE_NAME,
            'fromEmail' => 'no-reply@' . SITE_EMAIL_DOMAIN,
            'subject' => 'Cache Clearance Report',
            'body' => 'Cache cleared. ' . $filesDeleted . ' files deleted, ' . $readableMemory . ' of memory freed',
            'categories' => ['Cache Report'],
        ];

        $this->getEmailRepository()->send($emailData);
    }

    /*
     * Lead Notification Cron Job
     * */
    public function daily_lead_notifications($hourOverride = null)
    {
        $hour = $hourOverride ?: date('H');
        $cron = new LeadNotificationsCron();
        $cron->setHour($hour)->run();
    }

    public function lead_cleanup()
    {
        $cron = new \Pms\Cron\LeadCleanup();
        $cron->run();
    }

    public function event_scheduler()
    {
        $cron = new \Pms\Cron\EventScheduler();
        $cron->run();
    }

    public function calendar_sync()
    {
        $cron = new \Pms\Cron\CalendarSync();
        $cron->run();
    }

    public function proposal_resend_schedule()
    {
        $cron = new \Pms\Cron\ProposalResend();
        $cron->run();
    }

    public function auditReminderEmail()
    {
        $cron = new \Pms\Cron\AuditReminder();
        //$cron->run();
    }

    public function qbSync()
    {
        //  set_time_limit(0);
        // //Get the time from QucikbookSynch.log
        //  $time = time();
        //  $data_read = file_get_contents("QuickbookSync.log");  
        //  $timediffrence = abs($time - $data_read);     
        // if( $timediffrence > 300 ){
        //     $cron = new \Pms\Cron\QuickBooks();
        //     $cron->run();                
        // } 

       
       $cron = new \Pms\Cron\QuickBooks();
       $cron->run();
    }

    public function cacheDemoProposals()
    {
        // Delete proposals for deleted accounts
        $this->getProposalRepository()->deleteNoUserDemoProposals();

        $q = $this->em->createQuery('SELECT p FROM models\Proposals p WHERE p.is_demo = 1 and p.rebuildFlag = 1');
        $proposals = $q->getResult();

        foreach($proposals as $proposal) {
            /* @var models\Proposals $proposal */

            $cache_file_name = 'plproposal_' . $proposal->getAccessKey() . '.pdf';
            $cache_directory = CACHEDIR . '/proposals/' . $proposal->getLayout() . '/';
            //check if directory exists
            if (!is_dir($cache_directory)) {
                mkdir($cache_directory);
            }
            $cache_file = $cache_directory . $cache_file_name;
            echo $cache_file;

            //get proposal data
            $data = [];
            $data['lumpSum'] = false;
            $data['layout'] = $proposal->getLayout();
            $data['proposal'] = $proposal;
            $data['clientSig'] = $this->getProposalRepository()->getClientSignee($proposal);
            $data['companySig'] = $this->getProposalRepository()->getCompanySignee($proposal);
            $data['estimationRepository'] = $this->getEstimationRepository();

            $data['clientSignature'] = $this->getProposalRepository()->getClientSignature($proposal);
            $data['companySignature'] = $this->getProposalRepository()->getCompanySignature($proposal);
            $data['proposal_videos'] = $this->getProposalRepository()->getProposalVisibleProposalVideos($proposal->getProposalId());
            $data['proposal_intro_video'] = $this->getProposalRepository()->getProposalIntroVideo($proposal->getProposalId());
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
                $s = array('<br>', '<BR>');
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
            }
            $data['services_texts'] = $texts;
            //load pdf renderer
            //$this->load->library('Dompdf_library');
            //load content
            ob_start();
            $images = $this->em->createQuery('SELECT i FROM models\Proposals_images i  where i.proposal=' . $proposal->getProposalId() . ' order by i.ord')->getResult();
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
                    if (file_exists($path)) {
                        $img = \Intervention\Image\ImageManagerStatic::make($path);
                    
                        if($img) {
                            $data['images'][$imgIndex]['image'] = $image;
                            $data['images'][$imgIndex]['path'] = $img->basePath();
                            $data['images'][$imgIndex]['width'] = $img->getWidth();
                            $data['images'][$imgIndex]['height'] = $img->getHeight();
                            $data['images'][$imgIndex]['orientation'] = ($data['images'][$imgIndex]['width']
                                >= $data['images'][$imgIndex]['height']) ? 'landscape' : 'portrait';
                            $data['images'][$imgIndex]['src'] = $img->encode('data-url');

                            $imgIndex++;
                        }
                    }
                }
            }
            $proposal_attachments = $this->em->createQuery('SELECT i FROM models\Proposal_attachments i  where i.proposalId=' . $proposal->getProposalId() . ' and i.proposal=1 order by i.ord')->getResult();
            $data['proposal_attachments'] = $proposal_attachments;
            $workorder_attachments = $this->em->createQuery('SELECT i FROM models\Proposal_attachments i  where i.proposalId=' . $proposal->getProposalId() . ' and i.work_order=1 order by i.ord')->getResult();
            $data['workorder_attachments'] = $workorder_attachments;

            $this->load->view('pdf/layouts/' . $data['layout'], $data);
            $html = ob_get_contents();
            ob_end_clean();

            //PDF Options
            $pdfOptions = new \Dompdf\Options();
            $pdfOptions->setIsPhpEnabled(true);

            // PDF
            $dompdf = new Dompdf\Dompdf($pdfOptions);

            $dompdf->loadHtml($html);
            //header('Content-Type: application/pdf');
            $dompdf->render();
            $pdf = $dompdf->output();
            file_put_contents($cache_file, $pdf);

            $proposal->setRebuildFlag(0);
            $this->em->persist($proposal);
            $this->em->flush();
        }
    }

    function sendProposalViewedEmails(){
        $cron = new \Pms\Cron\ProposalViewEmails();
        $cron->run();
    }

    function sendExpiringAccountEmailsToMike(){
        $cron = new \Pms\Cron\CompanyExpiryEmails();
        $cron->run();
    }

    function sendExpiringAccountEmailsToAdmin(){
        $cron = new \Pms\Cron\AdminCompanyExpiryEmails();
        $cron->run();
    }


      /* prepare a function for automatic diabled trial company */
 
      function disabledTrialCompanyServices()
      {
          $data = array();
          $this->load->database();
           $companies = $this->account()->getExpireAdminCompaniesTableData();
          foreach($companies as $company)
          {
                 $company = $this->em->findCompany($company->companyId);
                 $company->setSalesManager(0);
                 $company->setModifyPrice(0);
                 $company->setProposalCampaigns(0);
                 $this->em->persist($company);
                 $this->em->flush();
          }
  
      }

 

}