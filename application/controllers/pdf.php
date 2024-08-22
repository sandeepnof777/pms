<?php
define('TAB', '');

use Carbon\Carbon;
use Intervention\Image\ImageManager;
use Intervention\Image\Image;
use Ramsey\Uuid\Uuid;
use Rapidinjection\Browser\Browser;

class Pdf extends MY_Controller
{
    /**
     * @var Log_manager
     * var $log_manager;
     */
    /**
     * @var CI_URI
     */
    var $uri;
    var $debug;
    /**
     * @var System_email
     */
    var $system_email;

    private $imageManager;

    private $blacklist = [
        '101.77.233.194',
        '64.235.153.8',
        '64.235.154.192',
        '64.235.151.197',
        '64.235.151.194',
        '64.235.154.194',
        '64.235.154.71',
        '64.235.151.198',
        '64.235.154.69',
        '64.235.154.195',
        '64.235.151.199',
        '64.235.154.68',
        '64.235.151.195',
        '64.235.154.193',
        '64.235.151.196',
        '64.235.150.153',
        '64.235.151.201',
        '64.235.150.220',
        '64.235.150.221',
        '64.235.150.151',
        '64.235.152.53',
        '64.235.152.54',
        '64.235.150.222',
        '64.235.150.223',
        '64.235.150.157',
        '64.235.154.42',
        '64.235.150.252',
        '64.235.154.104',
        '64.235.150.178',
        '64.235.154.105',
        '64.235.154.128',
        '64.235.153.2',
        '64.235.154.109',
        '64.235.154.117',
        '64.235.152.13',
        '64.235.154.140',
        '64.235.150.121',
        '64.235.153.10',
        '64.235.154.141',
        '64.235.153.7',
        '64.235.153.8',
        '64.235.154.106',
        '64.235.153.11',
        '205.217.25.189',
        '193.118.78.190',
        '107.77.234.124'
    ];

    function __construct()
    {
        parent::__construct();
        $this->imageManager = new ImageManager();
        $this->debug = 0; // make 1 to see pdf's html
    }

    function index()
    {
        echo 'you have no business here!';
        print_r($this->uri->uri_string());
    }

    function view()
    {
        $this->debug = 0;
        $this->render();
    }

    function download()
    {
        $this->debug = 0;
        $this->render(true, false, true);
    }

    function debug()
    {
        $this->debug = 0;
        $this->live();
    }

    function live()
    {
        $data = array();
        $deny = false;
        $preview = $this->uri->segment(3) == 'preview';

        if ($this->uri->segment(3) == 'cache') {

            $proposal_url = explode('.', $this->uri->segment(5));
            $proposal_id = str_replace('plproposal_', '', $proposal_url[0]);

            $data['layout'] = $this->uri->segment(4);

            $cache_file_name = 'plproposal_' . $proposal_id . '.pdf';
            $cache_directory = CACHEDIR . '/proposals/' . $data['layout'] . '/';
            //check if directory exists
            if (!is_dir($cache_directory)) {
                mkdir($cache_directory, 755, true);
            }
            $cache_file = $cache_directory . $cache_file_name;

            $this->render(false, $cache_file, true);
            return;
        }

        $clientView = boolval($this->uri->segment(3) == 'view');
        $data['layout'] = $this->uri->segment(4);
        $data['fileName'] = $this->uri->segment(5);


        $preload = ($this->uri->segment(6) == 'load');
        if ($this->uri->segment(3) == 'download') {
            $download = 1;
        } else {
            $download = 0;
        }

        $workOrder = ($this->uri->segment(4) == 'work_order');
        $proposal_url = explode('.', $this->uri->segment(5));
        $proposal_id = str_replace('plproposal_', '', $proposal_url[0]);

        if (strlen($proposal_id) < 16) {
            // Old, numeric format
            $proposal = $this->em->findProposal($proposal_id);

            if (!$proposal) {
                $this->load->view('pdf/proposal_not_found');
            } else {
                // Show message here with link to email sales rep

                $this->load->view(
                    'pdf/proposal_new_link',
                    ['proposal' => $proposal, 'account' => $proposal->getOwner()]
                );
                return;
            }
        } else {
            // New alphanumeric format
            $proposal = $this->em->findProposalByKey($proposal_id);
        }

        

        if ($proposal) {

            if ($data['layout'] != 'work_order'  && $data['layout'] != 'web-work_order') {
                $proposal_preview_link = $this->em->getRepository('models\ProposalPreviewLink')
                ->findOneBy([
                    'proposal_id' => $proposal->getProposalId(),
                    'client_link' =>1
                ]);

                if($proposal_preview_link){
                    redirect($proposal_preview_link->getUrl());
                }else{
                    $clientEmail = $proposal->getClient()->getEmail();
                    $client_link = 1;
                    
                        $uuid = Uuid::uuid4();
                        $ppl = new  \models\ProposalPreviewLink();
                        $ppl->setProposalId($proposal->getProposalId());
                        $ppl->setUuid($uuid);
                        $ppl->setEmail($clientEmail);
                        $ppl->setCreatedAt(Carbon::now());
                        $ppl->setClientLink($client_link);
                        $ppl->setOldLink(1);
                        $ppl->setNoTracking(1);
                        $this->em->persist($ppl);
                        $this->em->flush();
                        $proposal->setProposalViewCount($proposal->getProposalViewCount() + 1);
                        $this->em->persist($proposal);
                        $this->em->flush();
                        redirect($ppl->getUrl());
                }
            }
            if ($clientView) {

                if ($proposal->getIsHiddenToView() == 1) {

                    $this->load->view('pdf/proposal_hidden');
                    $site_url = substr(site_url(), 0, -1);
                    $actual_link = $site_url . $_SERVER['REQUEST_URI'];
                    $actual_link = str_replace("views", "preview", $actual_link);
                    $actual_link = str_replace("view", "preview", $actual_link);

                    $cli = "<b>" . $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName() . "</b>";

                    $this->load->model('system_email');
                    $email_data = array(
                        'first_name' => $proposal->getOwner()->getFirstName(),
                        'last_name' => $proposal->getOwner()->getLastName(),
                        'project_name' => $proposal->getProjectName(),
                        'client_company' => $cli,
                        'time' => date('m/d/Y h:i:s A', realTime(time())),
                        'mapIp' => mapIP($_SERVER['REMOTE_ADDR'], '', true),
                        'client_first' => $proposal->getClient()->getFirstName(),
                        'client_last' => $proposal->getClient()->getLastName(),
                        'client_cell_phone' => $proposal->getClient()->getCellPhone(),
                        'client_office_phone' => $proposal->getClient()->getBusinessPhone(),
                        'client_email' => $proposal->getClient()->getEmail(),
                        'proposal_url' => $proposal->getProposalViewUrl()
                    );

                    $this->system_email->sendEmail(32, $proposal->getOwner()->getEmail(), $email_data);

                    return;
                }
            }
        } else {
            $this->load->view('pdf/proposal_not_found');
            return;
        }

        

        if (!$proposal) {
            $this->load->view('pdf/proposal_not_found');
        } 
        // elseif ($proposal->getOwner()->getExpires() < time()) {
        //     $this->load->view('pdf/proposal_expired');
        // }
         elseif (!$this->account() && $proposal->hasUnapprovedServices()) {
            // Send email to proposal owner to let them know
            $this->getProposalRepository()->sendInProgressViewEmail($proposal);
            // Display the message
            $this->load->view('pdf/in-progress');
        } else {

            $data['proposal'] = $proposal;

            $cache_file_name = 'plproposal_' . $proposal_id . '.pdf';
            $cache_directory = CACHEDIR . '/proposals/' . $data['layout'] . '/';
            //check if directory exists
            if (!is_dir($cache_directory)) {
                mkdir($cache_directory, 755, true);
            }
            $cache_file = $cache_directory . $cache_file_name;
            //                echo 'cache file:' . $cache_file;
            $rebuild = 0;
            //check if the proposal needs to be rebuilt
            if ($proposal->needsRebuild()) {
                $rebuild = 1;
            }

            //check if file exists
            if (!file_exists($cache_file)) {
                $rebuild = 1;
            }
            //just do a rebuild -- TEMPORARY
            //just do a rebuild -- TEMPORARY
             //$rebuild = 1;
            //rebuild the proposal
            if ($this->uri->segment(6) =='print' || $this->uri->segment(6) =='download') {

                if ($rebuild) {
                   
                    // Delete existing cache file
                    if (file_exists($cache_file)) {
                        unlink($cache_file);
                    }

                    $this->render(false, $cache_file);
                    $proposal->setRebuildFlag(0, true, true, false);
                    $this->em->flush();
                }

                if (ini_get('zlib.output_compression')) {
                    ini_set('zlib.output_compression', 'Off');
                }

                $this->setHeaders();
                
            }else{
                
               

                    $this->render(false, $cache_file);
                    
            }

            if (
                !$this->session->userdata('logged')
                && !$workOrder
                && !in_array($_SERVER['REMOTE_ADDR'], $this->blacklist)
                && !$preview
                && !$preload
            ) {

                // Update the proposal view time
                $proposal->setLastOpenTime(time());
                $proposal->setLastActivity();
                $this->em->persist($proposal);
                $this->em->flush();

                if (!$download) {

                    //Event Log
                    $this->getProposalEventRepository()->ProposalView($proposal, $proposal->getClient()->getAccount());

                    $this->log_manager->add(\models\ActivityAction::PROPOSAL_PDF_VIEWED, 'PDF Viewed', NULL, $proposal);
                    $action = 'Viewed';
                    


                } else {
                    $this->log_manager->add(\models\ActivityAction::PROPOSAL_PDF_DOWNLOAD, 'PDF Downloaded', NULL, $proposal);
                    $action = 'Downloaded';
                }
                $cli = "<b>" . $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName() . "</b>";
                //if ($proposal->getClient()->getCompanyName() != 'Residential') {
                //    $cli = $proposal->getClient()->getCompanyName();
                //}

                $cli = $proposal->getClient()->getClientAccount()->getName();
                
            }

            if (!$this->account()) {

                if ($proposal->getLayout() !== 'web-cool' && $proposal->getLayout() !== 'web-standard' & $proposal->getLayout() !== 'web-standard3' && $proposal->getLayout() !== 'web-cool3' && $proposal->getLayout() !== 'web-cool2' && $proposal->getLayout() !== 'web-standard2') {


                //Log PDF viewer Details

                        $ipaddress = $_SERVER['REMOTE_ADDR'];
                        session_start();
                        $session_id = session_id();


                        $proposal_view = $this->em->getRepository('models\ProposalView')
                            ->findOneBy(
                                [
                                    'proposal_id' => $proposal->getProposalId(),
                                    'session_id' => $session_id
                                ],
                                [
                                    'updated_at' => 'DESC'
                                ]
                            );

                        //$proposal_view = false;

                        if ($proposal_view) {
                            if ($proposal_view->getUpdatedAt() < Carbon::now()->subMinutes($_ENV['PROPOSAL_VIEW_MINUTES'])) {
                                $proposal_view = null;
                            }
                        }

                        if (!$proposal_view) {


                            $proposal_view = new \models\ProposalView();
                            $proposal_view->setProposalId($proposal->getProposalId());
                            $proposal_view->setProposalLinkId(0);
                            $proposal_view->setCreatedAt(Carbon::now());
                            $proposal_view->setSessionId($session_id);
                            $proposal_view->setIpAddress($ipaddress);

                            //$proposal->setProposalViewCount($proposal->getProposalViewCount()+1);

                            $browser = new Browser();

                            $device = 'Desktop';
                            $os = $browser->getOS();

                            if ($browser->isMobile()) {
                                $device = 'Phone';
                                if ($browser->getPlatform() == 'iPhone') {
                                    $device = 'iPhone';
                                }
                            } else if ($browser->isTablet()) {
                                $device = 'Tablet';
                                if ($browser->getPlatform() == 'iPad') {
                                    $device = 'iPad';
                                }
                            }

                            $proposal_view->setPlatform($os);
                            $proposal_view->setPlatformVersion($browser->getPlatformVersion());
                            $proposal_view->setDevice($device);
                            $proposal_view->setBrowser($browser->getBrowser());
                            

                            $cli = "<b>" . $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName() . "</b>";

                            $action = 'Viewed';
                            $cli = $proposal->getClient()->getClientAccount()->getName();
                            $this->load->model('system_email');
                            $email_data = array(
                                'first_name' => $proposal->getOwner()->getFirstName(),
                                'last_name' => $proposal->getOwner()->getLastName(),
                                'viewed' => $action,
                                'project_name' => $proposal->getProjectName(),
                                'client_company' => $cli,
                                'time' => date('m/d/Y h:i:s A', realTime(time())),
                                'mapIp' => mapIP($_SERVER['REMOTE_ADDR'], '', true),
                                'client_first' => $proposal->getClient()->getFirstName(),
                                'client_last' => $proposal->getClient()->getLastName(),
                                'client_cell_phone' => $proposal->getClient()->getCellPhone(),
                                'client_office_phone' => $proposal->getClient()->getBusinessPhone(),
                                'client_email' => $proposal->getClient()->getEmail(),
                                'proposal_url' => $proposal->getProposalViewUrl()
                            );
                            if (!$proposal->getClient()->getAccount()->getDisableProposalNotifications()) {
                                $this->system_email->sendEmail(10, $proposal->getOwner()->getEmail(), $email_data);
                            }
                        }
        
                        $proposal_view->setUpdatedAt(Carbon::now());
                        $proposal_view->setPdfView(1);
                        $this->em->persist($proposal_view);
                        
                        $this->em->persist($proposal);
                        $this->em->flush();


                }
                
            }
            if ($this->uri->segment(6) =='print' || $this->uri->segment(6) =='download' || $data['layout'] == 'work_order') {
                if ($download) {
                    header("Content-Transfer-Encoding: binary");
                    header("Content-Description: File Transfer");
                    header("Content-Disposition: attachment; filename=$cache_file_name");
                    header('X-Robots-Tag: noindex');
                }

                readfile($cache_file);
            }
        }
    }

    function live2()
    {

        $data = array();
        $deny = false;

        $layout = $this->uri->segment(4);

        $data['fileName'] = $this->uri->segment(5);

        $download = 1;

        //$workOrder = ($this->uri->segment(4) == 'work_order');
        $proposal_url = explode('.', $this->uri->segment(5));
        $proposal_id = str_replace('plproposal_', '', $proposal_url[0]);


        if (strlen($proposal_id) < 16) {
            // Old, numeric format
            $proposal = $this->em->findProposal($proposal_id);

            if (!$proposal) {
                $this->load->view('pdf/proposal_not_found');
            } else {
                // Show message here with link to email sales rep

                $this->load->view(
                    'pdf/proposal_new_link',
                    ['proposal' => $proposal, 'account' => $proposal->getOwner()]
                );
                return;
            }
        } else {
            // New alphanumeric format
            $proposal = $this->em->findProposalByKey($proposal_id);
        }

        if (!$proposal) {
            $this->load->view('pdf/proposal_not_found');
        } elseif ($proposal->getOwner()->getExpires() < time()) {
            $this->load->view('pdf/proposal_expired');
        } elseif (!$this->account() && $proposal->hasUnapprovedServices()) {
            // Send email to proposal owner to let them know
            $this->getProposalRepository()->sendInProgressViewEmail($proposal);
            // Display the message
            $this->load->view('pdf/in-progress');
        } else {
            if ($layout == 'item-sheet' || $layout == 'phase-total') {
                $data = [
                    'proposal' => $proposal,
                    'repo' => $this->getEstimationRepository(),
                ];

                $services = $proposal->getServices();

                $i = 0;
                foreach ($services as $service) {

                    $service_id = $service->getServiceId();
                    $phases = $this->getEstimationRepository()->getProposalServicePhaseArray($service, $proposal_id);
                    $j = 1;
                    foreach ($phases as $phase) {
                        $phaseId = $phase['id'];

                        $data['items'][$i] = [
                            'proposalService' => $service,
                            'phase' => $phase,
                            'phase_count' => $j++,
                            'subContractorItem' => $this->getEstimationRepository()->getSubContractorPhaseSortedLineItems($phaseId),
                            'sortedItems' => $this->getEstimationRepository()
                                ->getPhaseSortedLineItems($this->account()->getCompany(), $phaseId, $service_id),
                            'fieldValues' => $this->getProposalRepository()->getPopulatedServiceFields($this->account()->getCompany(), $service),
                            'phaseTotal' => $this->getEstimationRepository()->getPhaseTotal($phaseId)
                            //'sortedItems' => $this->getEstimationRepository()->getProposalPhaseSortedLineItems($this->account()->getCompany(), $phaseId)
                        ];
                        $i++;
                    }
                }
            } else if ($layout == 'item-sheet-total') {

                $data = [
                    'proposal' => $proposal,
                    'subContractorItems' => $this->getEstimationRepository()->getSubContractorProposalSortedLineItems($proposal->getproposalId()),
                    'sortedItems' => $this->getEstimationRepository()
                        ->getProposalSortedLineItemsTotal($this->account()->getCompany(), $proposal->getproposalId())
                ];
            } else if ($layout == 'service-breakdown' || $layout == 'service-total' || $layout == 'work-order') {
                $data = [
                    'proposal' => $proposal,
                    'repo' => $this->getEstimationRepository(),
                ];
                $i = 0;
                $services = $proposal->getServices();
                foreach ($services as $service) {

                    $service_id = $service->getServiceId();
                    $data['services'][$i] = [
                        'service_details' => $service,
                        'subContractorItem' => $this->getEstimationRepository()->getSubContractorServiceSortedLineItems($service_id),
                        'sortedItems' => $this->getEstimationRepository()
                            ->getProposalServiceSortedLineItems($this->account()->getCompany(), $service_id),
                        'fieldValues' => $this->getProposalRepository()->getPopulatedServiceFields($this->account()->getCompany(), $service)
                    ];
                    $i++;
                }
            }
            //$proposal->getproposalId()
            ob_start();
            //$this->load->view('pdf/layouts/item-sheet', $data);
            //echo 'test';
            //die;
            $cache_file_name = 'plproposal_' . $proposal_id . '.pdf';
            $cache_directory = CACHEDIR . '/proposals/work_order/';

            //check if directory exists
            if (!is_dir($cache_directory)) {
                mkdir($cache_directory, 755, true);
            }
            $cache_file = $cache_directory . $cache_file_name;
            //                echo 'cache file:' . $cache_file;
            $rebuild = 0;
            //check if the proposal needs to be rebuilt
            if ($proposal->needsRebuild()) {
                $rebuild = 1;
            }
            //check if file exists
            if (!file_exists($cache_file)) {
                $rebuild = 1;
            }
            //just do a rebuild -- TEMPORARY
            $rebuild = 1;
            //rebuild the proposal

            if ($rebuild) {

                if (file_exists($cache_file)) {
                    unlink($cache_file);
                }

                //$this->render(false, $cache_file);

                $this->load->view('pdf/layouts/' . $layout, $data);

                $html = ob_get_contents();
                ob_end_clean();
                // if (!$this->debug) {
                // } else {
                //echo $html;
                // echo 'test';
                //die();
                //}
                //PDF Options

                $pdfOptions = new \Dompdf\Options();
                $pdfOptions->setIsPhpEnabled(true);

                // PDF
                $dompdf = new Dompdf\Dompdf($pdfOptions);


                $dompdf->setPaper("a4", "portrait");

                $dompdf->loadHtml($html);
                header('Content-Type: application/pdf');
                $dompdf->render();
                if ($download) {
                    if ($layout == 'item-sheet') {
                        $dompdf->stream(str_replace("."," ",$proposal->getProjectName()) . ' - Item Sheet');
                    } else {
                        $dompdf->stream(str_replace("."," ",$proposal->getProjectName()) . ' - Item Sheet Total');
                    }
                } else {
                    $pdf = $dompdf->output();
                    if (!$saveToFile) {
                        echo $pdf;
                    } else {
                        file_put_contents($saveToFile, $pdf);
                        $benchmark_duration = time() - $benchmark_start;
                        //                mail('chris@rapidinjection.com', 'PMS benchmark time - Proposal #' . $proposal_id, 'Total time it took to build proposal #' . $proposal_id . ': ' . $benchmark_duration . ' seconds');
                    }
                }

                $proposal->setRebuildFlag(0);
                $this->em->flush();
            }

            if (ini_get('zlib.output_compression')) {
                ini_set('zlib.output_compression', 'Off');
            }
            $this->setHeaders();

            if ($download) {
                header("Content-Transfer-Encoding: binary");
                header("Content-Description: File Transfer");
                header("Content-Disposition: attachment; filename=$cache_file_name");
                header('X-Robots-Tag: noindex');
            }
            readfile($cache_file);
        }
    }

    function job_cost_report_pdf()
    {

        $data = array();
        $proposal_id = $this->uri->segment(3);

        // Old, numeric format
        $proposal = $this->em->findProposal($proposal_id);

        if (!$proposal) {
            $this->load->view('pdf/proposal_not_found');
        } else {

            // $data = [
            //     'proposal' => $proposal,
            //     'repo' => $this->getEstimationRepository(),
            // ];

            //        $services = $proposal->getServices();

            $data = [
                'proposal' => $proposal,
                'repo' => $this->getEstimationRepository(),
                'subContractorItems' => $this->getEstimationRepository()->getSubContractorProposalSortedLineItems($proposal_id),
                'sortedItems' => $this->getEstimationRepository()
                    ->getProposalJobCostSortedLineItemsTotal($this->account()->getCompany(), $proposal_id),
                'category_total' => $this->getEstimationRepository()
                    ->getProposalJobCostCategoryTotal($this->account()->getCompany(), $proposal_id),
                'breakdown' => $this->getEstimationRepository()
                    ->getJobCostReportSummary($proposal),


            ];

            $services = $proposal->getServices();


            $i = 0;
            foreach ($services as $service) {

                $service_id = $service->getServiceId();


                $i++;
                $data['services'][$i] = [
                    'service_details' => $service,
                    'subContractorItem' => $this->getEstimationRepository()->getSubContractorServiceSortedLineItems($service_id),

                    'allSortedItems' => $this->getEstimationRepository()
                        ->getProposalServiceJobCostItems($this->account()->getCompany(), $service_id),
                    'fieldValues' => $this->getProposalRepository()->getPopulatedServiceFields($this->account()->getCompany(), $service),
                    'sortedItems' => $this->getEstimationRepository()
                        ->getProposalServiceJobCostCategoryTotal($this->account()->getCompany(), $service_id),
                    'fieldValues' => $this->getProposalRepository()->getPopulatedServiceFields($this->account()->getCompany(), $service)
                ];
            }

            $data['all_proposal_services'] = $services;


            //$proposal->getproposalId()
            ob_start();
            //$this->load->view('pdf/layouts/item-sheet', $data);
            //echo 'test';
            //die;
            $cache_file_name = 'job_cost_report_' . $proposal_id . '.pdf';
            $cache_directory = CACHEDIR . '/proposals/work_order/';

            //check if directory exists
            if (!is_dir($cache_directory)) {
                mkdir($cache_directory, 755, true);
            }
            $cache_file = $cache_directory . $cache_file_name;
            //                echo 'cache file:' . $cache_file;
            $rebuild = 0;
            //check if the proposal needs to be rebuilt
            if ($proposal->needsRebuild()) {
                $rebuild = 1;
            }
            //check if file exists
            if (!file_exists($cache_file)) {
                $rebuild = 1;
            }
            //just do a rebuild -- TEMPORARY
            $rebuild = 1;
            //rebuild the proposal

            if ($rebuild) {
                //            mail('chris@rapidinjection.com', 'proposal cached: ' . $proposal_id, 'cest la vie');

                if (file_exists($cache_file)) {
                    unlink($cache_file);
                }

                //$this->render(false, $cache_file);

                $this->load->view('pdf/layouts/job-cost-report', $data);

                $html = ob_get_contents();
                ob_end_clean();
                // if (!$this->debug) {
                // } else {
                //echo $html;
                // echo 'test';
                //die();
                //}
                //PDF Options

                $pdfOptions = new \Dompdf\Options();
                $pdfOptions->setIsPhpEnabled(true);

                // PDF
                $dompdf = new Dompdf\Dompdf($pdfOptions);


                $dompdf->setPaper("a4", "portrait");

                $dompdf->loadHtml($html);
                header('Content-Type: application/pdf');
                $dompdf->render();

                // if($layout=='item-sheet'){
                $dompdf->stream(str_replace("."," ",$proposal->getProjectName()) . ' - Item Sheet');
                // }else{
                //     $dompdf->stream($proposal->getProjectName() . ' - Item Sheet Total');
                // }


                $proposal->setRebuildFlag(0);
                $this->em->flush();
            }

            if (ini_get('zlib.output_compression')) {
                ini_set('zlib.output_compression', 'Off');
            }
            $this->setHeaders();


            header("Content-Transfer-Encoding: binary");
            header("Content-Description: File Transfer");
            header("Content-Disposition: attachment; filename=$cache_file_name");
            header('X-Robots-Tag: noindex');

            readfile($cache_file);
        }
    }

    /** Email bounce notifications */
    function bounce()
    {
        // Get the raw input of the request
        $input = file_get_contents("php://input");
        // Decode the JSON, this will give us an array of events
        $events = json_decode($input);

        if ($events) {

            // We no have an array of event objects
            foreach ($events as $event) {

                if (isset($event->proposal)) {

                    $proposal = $this->em->find('models\Proposals', $event->proposal);
                    /* @var \models\Proposals $proposal */

                    switch ($event->event) {

                        case 'bounce':
                        case 'dropped':

                            $content = '<p>The Proposal email to "' . $event->email . '" was not delivered.</p>
                                         <p>The reason given by the mail server was: ' . $event->reason . '</p>
                                         <p><a href="' . site_url('proposals/edit/' . $proposal->getProposalId() . '/send') . '">Click Here</a> to return back to ' . SITE_NAME . ' and resend your proposal with correct information.
                                         <p><strong>Thank You!</strong><p>
                                         <p>' . SITE_NAME . ' Team</p>';

                            $emailData = [
                                'to' => $proposal->getOwner()->getEmail(),
                                'fromName' => SITE_NAME . ' Support',
                                'fromEmail' => 'no-reply@' . SITE_EMAIL_DOMAIN,
                                'subject' => 'Undelivered Proposal Email: ' . $proposal->getProjectName(),
                                'body' => $content,
                                'categories' => ['Bounce Notification'],
                            ];

                            $this->getEmailRepository()->send($emailData);

                            // Log the bounce
                            $this->log_manager->add(
                                \models\ActivityAction::PROPOSAL_EMAIL_BOUNCED,
                                'Undelivered Proposal Email: ' . $event->email,
                                $proposal->getClient(),
                                $proposal
                            );
                            break;

                        default:
                            break;
                    }
                }
            }
        }
    }

    private function render($download = false, $saveToFile = false, $cacheOnly = false)
    {
        
        $benchmark_start = time();
        //get proposal data
        $data = array();
        $data['lumpSum'] = false;
        $data['hideTotalPrice'] = false;
        $data['showPreProposalPopup'] = 0;
        $data['showCompanySignatureButton'] = 0;
        if (in_array($this->uri->segment(2), array('live', 'debug'))) {
            $data['layout'] = $this->uri->segment(4);
            $data['layout'] = str_replace("web-","",$data['layout']);
            if ($this->uri->segment(4) == 'cool2' || $this->uri->segment(4) == 'standard2' || $this->uri->segment(4) == 'gradient2' || $this->uri->segment(4) == 'web-cool2' || $this->uri->segment(4) == 'web-standard2' || $this->uri->segment(4) == 'web-custom2') {
                $data['layout'] = substr($this->uri->segment(4), 0, -1);
                $data['hideTotalPrice'] = 1;
            }
            if ($this->uri->segment(4) == 'cool3' || $this->uri->segment(4) == 'standard3' || $this->uri->segment(4) == 'gradient3' || $this->uri->segment(4) == 'web-cool3' || $this->uri->segment(4) == 'web-standard3' || $this->uri->segment(4) == 'web-custom3') {
                $data['layout'] = substr($this->uri->segment(4), 0, -1);
                $data['lumpSum'] = 1;
            }


            $data['fileName'] = $this->uri->segment(5);
            $proposal_url = explode('.', $this->uri->segment(5));
            $proposal_id = str_replace('plproposal_', '', $proposal_url[0]);
        } else {
            $data['layout'] = $this->uri->segment(3);
            $data['layout'] = str_replace("web-","",$data['layout']);
            $data['fileName'] = $this->uri->segment(4);
            $proposal_url = explode('.', $this->uri->segment(4));
            $proposal_id = $proposal_url[0];
        }
        //$proposal = $this->em->find('models\Proposals', $proposal_id);

        if (strlen($proposal_id) < 16) {
            // Old, numeric format
            $proposal = $this->em->findProposal($proposal_id);
        } else {
            // New alphanumeric format
            $proposal = $this->em->findProposalByKey($proposal_id);
        }
        $data['nosidebar'] = 1;

        if ($data['layout'] == 'web-cool' || $data['layout'] == 'web-standard' || $data['layout'] == 'web-custom' ||  $data['layout'] == 'cool' || $data['layout'] == 'standard' || $data['layout'] == 'gradient' && $this->uri->segment(6) !='print') {


            if ($data['layout'] == 'web-cool' || $data['layout'] == 'cool') {
                $data['template'] = 'web-cool';
            }else if ($data['layout'] == 'web-custom' || $data['layout'] == 'gradient') {
                $data['template'] = 'web-custom';
            } else {
                $data['template'] = 'web-standard';
            }

            $data['layout'] = 'web-cool-standard';
        }

        if($this->uri->segment(6) =='print'){
            
            $data['layout'] = $this->uri->segment(4);
        }

        $data['track_activity'] = 0;
        $data['uuid'] = 0;
        if (!$this->session->userdata('logged')) {
            if (!$download) {
                //                $this->log_manager->add(\models\ActivityAction::PROPOSAL_PDF_VIEWED, 'PDF Viewed', NULL, $proposal);
            } else {
                //                $this->log_manager->add(\models\ActivityAction::PROPOSAL_PDF_DOWNLOAD, 'PDF Downloaded', NULL, $proposal);
            }
            $data['track_activity'] = 1;
        }
        $data['proposal'] = $proposal;
        $data['clientSig'] = $this->getProposalRepository()->getClientSignee($proposal);
        $data['companySig'] = $this->getProposalRepository()->getCompanySignee($proposal);
        $data['clientSignature'] = $this->getProposalRepository()->getClientSignature($proposal);
        $data['companySignature'] = $this->getProposalRepository()->getCompanySignature($proposal);
        $data['estimationRepository'] = $this->getEstimationRepository();
        $data['proposal_videos'] = $this->getProposalRepository()->getProposalVisibleProposalVideos($proposal->getProposalId());
        $data['proposal_intro_video'] = $this->getProposalRepository()->getProposalIntroVideo($proposal->getProposalId());
        
        $data['work_order_videos'] = $this->getProposalRepository()->getWorkOrderVisibleProposalVideos($proposal->getProposalId());
        $data['work_order_intro_video'] = $this->getProposalRepository()->getWorkOrderVisibleIntroVideos($proposal->getProposalId());
        $data['workOrderSections'] = $this->getCompanyRepository()->getCompanyWorkOrderSections($proposal->getCompanyId());
        $data['work_order_notes'] = $this->getProposalRepository()->getWorkOrderNotes($proposal->getProposalId());
        

        $browser = new Browser();

        $device = 'Desktop';
        $os = $browser->getOS();

        if ($browser->isMobile()) {
            $device = 'Phone';
            if ($browser->getPlatform() == 'iPhone') {
                $device = 'iPhone';
            }
        } else if ($browser->isTablet()) {
            $device = 'Tablet';
            if ($browser->getPlatform() == 'iPad') {
                $device = 'iPad';
            }
        }
        $data['device'] = $device;
        $data['proposal_preview_link_id'] = 0;
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
        $data['services_org'] = $services;
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

            $service_images = $this->em->createQuery('SELECT i FROM models\Proposals_images i  where i.proposal_service_id = '.$service->getServiceId().'  AND i.proposal=' . $proposal->getProposalId() . ' order by i.map DESC,i.ord ASC')->getResult();
            
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
                    $data['images'][$imgIndex]['websrc'] =  site_url($image->getWebPath());

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

        // Do we need to load some PSA data?
        if ($proposal->getInventoryReportUrl()) {
            $this->load->library('psa_client', ['public' => true]);
            $data['inventoryData'] = $this->psa_client->inventoryData(['reportKey' => $proposal->getInventoryReportUrl()]);
        }

        if (($data['layout'] == 'work_order') || ($data['layout'] == 'work_order2')) {
            $data['plantDirections'] = $this->getProposalRepository()->getAllTruckingDirections($proposal);
        }

        $this->load->view('pdf/layouts/' . $data['layout'], $data);

        if (($data['layout'] !== 'web-cool-standard') || $cacheOnly) {

            $html = ob_get_contents();
           // echo $html;die;
            ob_end_clean();
            if (!$this->debug) {
            } else {
                echo $html;
                die();
            }

            //PDF Options
            $pdfOptions = new \Dompdf\Options();
            $pdfOptions->setIsPhpEnabled(true);

            // PDF
            $dompdf = new Dompdf\Dompdf($pdfOptions);

            if (($data['layout'] == 'work_order') || ($data['layout'] == 'work_order2')) {
                //$dompdf->setPaper("a4", "landscape");
                $orderSetting = $proposal->getWorkOrderSetting();
                if ($orderSetting == 0) {
                    $dompdf->setPaper(array(0, 0, 800.44, 800.07), 'landscape'); 
 
                } else {
                    $dompdf->setPaper('a4', 'portrait');
                }
            }

         // echo $html;die;
            $dompdf->loadHtml($html);

            if (!$cacheOnly) {
                header('Content-Type: application/pdf');
            }

            $dompdf->render();
           
 
            if ($download || $cacheOnly) {

                if (!$cacheOnly) {
                    $dompdf->stream($this->uri->segment(4));
                } else {
                    file_put_contents($saveToFile, $dompdf->output());
                }

            } else {
                $pdf = $dompdf->output();
                if (!$saveToFile) {
                    echo $pdf;
                } else {
                    file_put_contents($saveToFile, $pdf);
                    $benchmark_duration = time() - $benchmark_start;//                mail('chris@rapidinjection.com', 'PMS benchmark time - Proposal #' . $proposal_id, 'Total time it took to build proposal #' . $proposal_id . ': ' . $benchmark_duration . ' seconds');
                }
            }
        }
    }

    protected function setHeaders($fileName = false)
    {
        header("Pragma: public"); // required
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header('Content-Type: application/pdf');
        if ($fileName) {
            header('Content-Disposition: attachment; filename="' . $fileName . '"');
        }
    }

    public function lead($leadsCsv)
    {
        $this->debug = 0;
        //$this->load->library('Dompdf_library');
        if (!$this->debug) {
            $this->setHeaders('PL_Leads.pdf');
        }
        //load html
        ob_start();
        $data = [];
        $leads = [];
        $leadIds = explode('-', $leadsCsv);
        foreach ($leadIds as $leadId) {
            $leads[] = $this->em->find('models\Leads', $leadId);
        }
        $data['leads'] = $leads;
        $data['services'] = $this->account()->getCompany()->getCategories();
        $data['company'] = $this->account()->getCompany();
        $this->load->view('pdf/leads/default', $data);
        $html = ob_get_contents();
        ob_end_clean();
        //render lead
        if (!$this->debug) {
            $pdfOptions = new \Dompdf\Options();
            $pdfOptions->setIsPhpEnabled(true);

            // PDF
            $dompdf = new Dompdf\Dompdf($pdfOptions);
            $dompdf->loadHtml($html);
            $dompdf->render();
            echo $dompdf->output();
        } else {
            echo $html;
        }
    }

    function item_list()
    {
        ob_start();
        //echo '<pre>';
        $data['companyItems'] = $this->getEstimationRepository()->getAllCompanyItemsPdf($this->account()->getCompany());
        //print_r($data['companyItems']);die();
        $this->load->view('pdf/layouts/item-list-pdf', $data);

        $html = ob_get_contents();
        ob_end_clean();

        $pdfOptions = new \Dompdf\Options();
        $pdfOptions->setIsPhpEnabled(true);

        // PDF
        $dompdf = new Dompdf\Dompdf($pdfOptions);

        $dompdf->setPaper("a4", "portrait");

        $dompdf->loadHtml($html);
        header('Content-Type: application/pdf');
        $dompdf->render();

        $pdf = $dompdf->output();
        echo $pdf;
    }

    function material_item_list()
    {
        ob_start();

        $company = $this->account()->getCompany();
        $material_category = $this->em->find('models\EstimationCategory', 1);
        $data['typeItems'] = $this->getEstimationRepository()->getCompanyCategoryTypeItems($company, $material_category);
        $this->load->view('pdf/layouts/material-item-list-pdf', $data);

        $html = ob_get_contents();
        ob_end_clean();
        //echo $html;
        //die;
        $pdfOptions = new \Dompdf\Options();
        $pdfOptions->setIsPhpEnabled(true);

        // PDF
        $dompdf = new Dompdf\Dompdf($pdfOptions);
        $dompdf->setPaper("a4", "portrait");

        $dompdf->loadHtml($html);
        header('Content-Type: application/pdf');
        $dompdf->render();

        $pdf = $dompdf->output();
        echo $pdf;
    }

    function equipment_item_list()
    {
        ob_start();

        $company = $this->account()->getCompany();
        $material_category = $this->em->find('models\EstimationCategory', 2);
        $data['typeItems'] = $this->getEstimationRepository()->getCompanyCategoryTypeItems($company, $material_category);
        $this->load->view('pdf/layouts/equipment-item-list-pdf', $data);

        $html = ob_get_contents();
        ob_end_clean();

        $pdfOptions = new \Dompdf\Options();
        $pdfOptions->setIsPhpEnabled(true);

        // PDF
        $dompdf = new Dompdf\Dompdf($pdfOptions);
        $dompdf->setPaper("a4", "portrait");

        $dompdf->loadHtml($html);
        header('Content-Type: application/pdf');
        $dompdf->render();

        $pdf = $dompdf->output();
        echo $pdf;
    }

    function labor_item_list()
    {
        ob_start();

        $company = $this->account()->getCompany();
        $material_category = $this->em->find('models\EstimationCategory', 3);
        $data['typeItems'] = $this->getEstimationRepository()->getCompanyCategoryTypeItems($company, $material_category);
        $this->load->view('pdf/layouts/labor-item-list-pdf', $data);

        $html = ob_get_contents();
        ob_end_clean();

        $pdfOptions = new \Dompdf\Options();
        $pdfOptions->setIsPhpEnabled(true);

        // PDF
        $dompdf = new Dompdf\Dompdf($pdfOptions);
        $dompdf->setPaper("a4", "portrait");

        $dompdf->loadHtml($html);
        header('Content-Type: application/pdf');
        $dompdf->render();

        $pdf = $dompdf->output();
        echo $pdf;
    }

    function services_item_list()
    {
        ob_start();

        $company = $this->account()->getCompany();
        $material_category = $this->em->find('models\EstimationCategory', 5);
        $data['typeItems'] = $this->getEstimationRepository()->getCompanyCategoryTypeItems($company, $material_category);
        $this->load->view('pdf/layouts/services-item-list-pdf', $data);

        $html = ob_get_contents();
        ob_end_clean();

        $pdfOptions = new \Dompdf\Options();
        $pdfOptions->setIsPhpEnabled(true);

        // PDF
        $dompdf = new Dompdf\Dompdf($pdfOptions);
        $dompdf->setPaper("a4", "portrait");

        $dompdf->loadHtml($html);
        header('Content-Type: application/pdf');
        $dompdf->render();

        $pdf = $dompdf->output();
        echo $pdf;
    }

    function preview_proposal()
    {

          $data = array();
        $download = false;
        $print = false;
        $cache = false;
        $render = false;
        $isDefaultView = false;
        $showPreProposalPopup = 0;
        $showCompanySignatureButton = 0;
        $uuid = $this->uri->segment(2);
        if($this->uri->segment(3) == 'download'){
            $download = true;
        }

        if($this->uri->segment(3) == 'print'){
            $print = true;
        }
        if($this->uri->segment(3) == 'cache'){
            $cache = true;
        }


        $browser = new Browser();

        $device = 'Desktop';
        $os = $browser->getOS();

        if ($browser->isMobile()) {
            $device = 'Phone';
            if ($browser->getPlatform() == 'iPhone') {
                $device = 'iPhone';
            }
        } else if ($browser->isTablet()) {
            $device = 'Tablet';
            if ($browser->getPlatform() == 'iPad') {
                $device = 'iPad';
            }
        }


        $proposal_preview_link = $this->em->getRepository('models\ProposalPreviewLink')->findOneBy(array('uuid' => $uuid));


        if ($proposal_preview_link) {
            $proposal_id = $proposal_preview_link->getProposalId();

            $checkproposalPreviewUrl = $this->getProposalRepository()->getDefaultProposalLink($proposal_id);
            // if($uuid == $checkproposalPreviewUrl->getUuid()){
            //     $isDefaultView = true;
            // }else{
                $this->load->library('jobs');
       
                $this->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'job_create_proposal_pdf_cache', ['proposal_id' => $proposal_id],'test email');
            //}

            $proposal = $this->em->findProposal($proposal_id);
            if ($proposal) {

                $data['layout'] = $proposal->getNewLayout();
                
                
                if ($proposal->getIsHiddenToView() == 1) {

                    $this->load->view('pdf/proposal_hidden');
                    $site_url = substr(site_url(), 0, -1);
                    $actual_link = $site_url . $_SERVER['REQUEST_URI'];
                    $actual_link = str_replace("views", "preview", $actual_link);
                    $actual_link = str_replace("view", "preview", $actual_link);

                    $cli = "<b>" . $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName() . "</b>";

                    $this->load->model('system_email');
                    $email_data = array(
                        'first_name' => $proposal->getOwner()->getFirstName(),
                        'last_name' => $proposal->getOwner()->getLastName(),
                        'project_name' => $proposal->getProjectName(),
                        'client_company' => $cli,
                        'time' => date('m/d/Y h:i:s A', realTime(time())),
                        'mapIp' => mapIP($_SERVER['REMOTE_ADDR'], '', true),
                        'client_first' => $proposal->getClient()->getFirstName(),
                        'client_last' => $proposal->getClient()->getLastName(),
                        'client_cell_phone' => $proposal->getClient()->getCellPhone(),
                        'client_office_phone' => $proposal->getClient()->getBusinessPhone(),
                        'client_email' => $proposal->getClient()->getEmail(),
                        'proposal_url' => $proposal->getProposalViewUrl()
                    );

                    $this->system_email->sendEmail(32, $proposal->getOwner()->getEmail(), $email_data);

                    return;
                }



                if (!$this->account()) {
                    
                    if($proposal->getOwner()->getCompany()->getCompanySettings()->getIsPreProposalPopup() ==1 && $proposal->getIsPreProposalPopup() ==1){
                         //$showPreProposalPopup = 1;
                         $pre_proposal_popup = $this->em->getRepository('models\PreProposalPopupHide')->findOneBy(array('proposal_link_id' => $proposal_preview_link->getId()));
                        
                        if(!$pre_proposal_popup){
                             $showPreProposalPopup = 1;
                            
                        }

                        
                    }
 
                    if ($proposal_preview_link->getActive() == 0 || $proposal_preview_link->getExpires() != '' && $proposal_preview_link->getExpires() < Carbon::now()) {

                        $ipaddress = $_SERVER['REMOTE_ADDR'];
                        session_start();
                        $session_id = session_id();


                        $proposal_view = $this->em->getRepository('models\ProposalView')
                            ->findOneBy(
                                [
                                    'proposal_link_id' => $proposal_preview_link->getId(),
                                    'session_id' => $session_id
                                ],
                                [
                                    'updated_at' => 'DESC'
                                ]
                            );

                        if (!$proposal_view) {


                            $proposal_view = new \models\ProposalView();
                            $proposal_view->setProposalId($proposal_preview_link->getProposalId());
                            $proposal_view->setProposalLinkId($proposal_preview_link->getId());
                            $proposal_view->setCreatedAt(Carbon::now());
                            $proposal_view->setSessionId($session_id);
                            $proposal_view->setIpAddress($ipaddress);
                            $proposal_view->setAccessDenied(1);

                            // $proposal->setProposalViewCount($proposal->getProposalViewCount()+1);



                            $proposal_view->setPlatform($os);
                            $proposal_view->setPlatformVersion($browser->getPlatformVersion());
                            $proposal_view->setDevice($device);
                            $proposal_view->setBrowser($browser->getBrowser());
                            
                           $denied_reason = '';
                           if($proposal_preview_link->getActive()==0){
                                $denied_reason = 'Link has been Disabled';
                           }else if($proposal_preview_link->getExpires() != '' && $proposal_preview_link->getExpires() < Carbon::now()){
                                $denied_reason = 'Link Expired '.Carbon::parse($proposal_preview_link->getExpires())->format('m/d/Y');
                           }
                            $basicEmailData = [
                                'proposalPreviewUrl' => site_url().'proposal/'.$uuid,
                                'projectName' => $proposal->getProjectName(),
                                'contactEmail' => $proposal_preview_link->getEmail(),
                                'viewDeniedReason' => $denied_reason,
                                'siteName' => SITE_NAME,
                            ];
                           // $this->getEmailRepository()->send($basicEmailData);

                            // if (!$proposal->getClient()->getAccount()->getDisableProposalNotifications()) {
                                $this->load->model('system_email');
                                $this->system_email->sendEmail(50, $proposal->getOwner()->getEmail(), $basicEmailData);
                            // }
                        }


                            $proposal_view->setUpdatedAt(Carbon::now());
                            $this->em->persist($proposal_view);
                            $this->em->persist($proposal);
                            $this->em->flush();
                        $proposal_owner_data = [
                            'first_name' => $proposal->getOwner()->getFirstName(),
                            'last_name' => $proposal->getOwner()->getLastName(),
                            'email' => $proposal->getOwner()->getEmail()
                        ];
                        if ($proposal_preview_link->getActive() == 0) {
                            $this->load->view('pdf/link_not_active',$proposal_owner_data);
                            return;
                        }
                        if ($proposal_preview_link->getExpires() != '' && $proposal_preview_link->getExpires() < Carbon::now()) {
                            $this->load->view('pdf/link_expired',$proposal_owner_data);
                            return;
                        }
                }

                   
                    //Log PDF viewer Details

                    if ($proposal->getNewLayout() !== 'web-cool' && $proposal->getNewLayout() !== 'web-standard' & $proposal->getNewLayout() !== 'web-standard3' && $proposal->getNewLayout() !== 'web-cool3' && $proposal->getNewLayout() !== 'web-cool2' && $proposal->getNewLayout() !== 'web-standard2') {



                        $ipaddress = $_SERVER['REMOTE_ADDR'];
                        session_start();
                        $session_id = session_id();


                        $proposal_view = $this->em->getRepository('models\ProposalView')
                            ->findOneBy(
                                [
                                    'proposal_link_id' => $proposal_preview_link->getId(),
                                    'session_id' => $session_id
                                ],
                                [
                                    'updated_at' => 'DESC'
                                ]
                            );

                        //$proposal_view = false;

                        if ($proposal_view) {
                            if ($proposal_view->getUpdatedAt() < Carbon::now()->subMinutes($_ENV['PROPOSAL_VIEW_MINUTES'])) {
                                $proposal_view = null;
                            }
                        }

                        if (!$proposal_view) {


                            $proposal_view = new \models\ProposalView();
                            $proposal_view->setProposalId($proposal_preview_link->getProposalId());
                            $proposal_view->setProposalLinkId($proposal_preview_link->getId());
                            $proposal_view->setCreatedAt(Carbon::now());
                            $proposal_view->setSessionId($session_id);
                            $proposal_view->setIpAddress($ipaddress);

                            //$proposal->setProposalViewCount($proposal->getProposalViewCount()+1);



                            $proposal_view->setPlatform($os);
                            $proposal_view->setPlatformVersion($browser->getPlatformVersion());
                            $proposal_view->setDevice($device);
                            $proposal_view->setBrowser($browser->getBrowser());
                            
                        

                            $cli = "<b>" . $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName() . "</b>";

                            $action = 'Viewed';
                            $cli = $proposal->getClient()->getClientAccount()->getName();
                            $this->load->model('system_email');
                            $email_data = array(
                                'first_name' => $proposal->getOwner()->getFirstName(),
                                'last_name' => $proposal->getOwner()->getLastName(),
                                'viewed' => $action,
                                'project_name' => $proposal->getProjectName(),
                                'client_company' => $cli,
                                'time' => date('m/d/Y h:i:s A', realTime(time())),
                                'mapIp' => mapIP($_SERVER['REMOTE_ADDR'], '', true),
                                'client_first' => $proposal->getClient()->getFirstName(),
                                'client_last' => $proposal->getClient()->getLastName(),
                                'client_cell_phone' => $proposal->getClient()->getCellPhone(),
                                'client_office_phone' => $proposal->getClient()->getBusinessPhone(),
                                'client_email' => $proposal->getClient()->getEmail(),
                                'proposal_url' => $proposal->getProposalViewUrl()
                            );
                            if (!$proposal->getClient()->getAccount()->getDisableProposalNotifications()) {
                                $this->system_email->sendEmail(10, $proposal->getOwner()->getEmail(), $email_data);
                            }
                        }

                            $proposal_view->setUpdatedAt(Carbon::now());
                            $proposal_view->setPdfView(1);
                            $this->em->persist($proposal_view);
                            $this->em->persist($proposal);
                            $this->em->flush();
                    }
                }else{

                    if ($proposal_preview_link->getActive() == 0 || $proposal_preview_link->getExpires() != '' && $proposal_preview_link->getExpires() < Carbon::now()) {
                        if ($this->account()->getCompany() != $proposal->getClient()->getCompany()) {
                            $this->session->set_flashdata('error', 'You do not have enough privileges to view this proposal!');
                            redirect('proposals');
                        }
                        
                        //check if current account can edit proposal
                        if (!$this->account()->isAdministrator() && ($this->account()->getFullAccess() == 'no')) { 
                            
                            
                            if (($this->account() != $proposal->getClient()->getAccount()) && ($this->account() != $proposal->getOwner()) ) {
                                
                                $this->session->set_flashdata('error', 'You do not have enough privileges to view this proposal!');
                                redirect('proposals');
                            }
                        }
                    }
                     $showPreProposalPopup = 0;
                   
                    if(($this->account()->isAdministrator() || ($this->account()->getFullAccess() == 'yes') || ($this->account() == $proposal->getOwner() )) && ($this->account()->getCompanyId() == $proposal->getCompanyId()) ) {
                        $showCompanySignatureButton = 1;
                    }

                }
            } else {

                $this->load->view('pdf/proposal_not_found');
                return;
            }


            if (!$proposal) {
                $this->load->view('pdf/proposal_not_found');
            } 
            // elseif ($proposal->getOwner()->getExpires() < time()) {
            //      $this->load->view('pdf/proposal_expired');
            // } 
            elseif (!$this->account() && $proposal->hasUnapprovedServices()) {
                // Send email to proposal owner to let them know
                $this->getProposalRepository()->sendInProgressViewEmail($proposal);
                // Display the message
                $this->load->view('pdf/in-progress');
            } else {


                $data['proposal'] = $proposal;

                $cache_file_name = 'plproposal_' . $proposal_id . '.pdf';
                $cache_directory = CACHEDIR . '/proposals/' . $data['layout'] . '/';
                //check if directory exists
                if (!is_dir($cache_directory)) {
                    mkdir($cache_directory, 755, true);
                }
                $cache_file = $cache_directory . $cache_file_name;
                //                echo 'cache file:' . $cache_file;
                $rebuild = 0;
                //check if the proposal needs to be rebuilt
                if ($proposal->needsRebuild()) {
                    $rebuild = 1;
                }
                
                //check if file exists
                if (!file_exists($cache_file)) {
                    $rebuild = 1;
                }

                if ($cache) {
                    $rebuild = 1;
                }
                
                if ($rebuild) {
                    
                    // Delete existing cache file
                    if (file_exists($cache_file)) {
                        unlink($cache_file);
                    }
                    
                    $this->renderProposal($download,$print,$cache,$cache_file, $proposal, $proposal_id,$showPreProposalPopup,$showCompanySignatureButton,$proposal_preview_link->getNoTracking(),$device,$proposal_preview_link->getId(),$proposal_preview_link);
                          
                    $proposal->setRebuildFlag(0, true, true, false);
                    $this->em->flush();
                    $render = true;
                }

                
                // Update the proposal view time
                if (!$this->account() && $proposal_preview_link->getEmail() !='default') {
                    $proposal->setLastOpenTime(time());
                }else if($this->account()){
                    if($this->account()->getCompanyId() != $proposal->getCompanyId() && $proposal_preview_link->getEmail() !='default'){
                        //Handle For LogedIn user with diffrent company
                        $proposal->setLastOpenTime(time());
                    }
                }
                $proposal->setLastActivity();
                $this->em->persist($proposal);
                $this->em->flush();

                if ($download || $print || $cache) {

                    if (ini_get('zlib.output_compression')) {
                        ini_set('zlib.output_compression', 'Off');
                    }

                    $this->setHeaders();
                    readfile($cache_file);
                }else{
                    if(!$render){
                        $this->renderProposal($download,$print,$cache,$cache_file, $proposal, $proposal_id,$showPreProposalPopup,$showCompanySignatureButton,$proposal_preview_link->getNoTracking(),$device,$proposal_preview_link->getId(),$proposal_preview_link);
                    }
                }


                
                
            }
        } else {
            $this->load->view('pdf/proposal_not_found');
        }
    }

    private function renderProposal($download = false,$print = false, $cache = false,$saveToFile = false, $proposal, $proposal_id,$showPreProposalPopup=1,$showCompanySignatureButton=0,$noTracking=0,$device='',$proposal_preview_link_id,$proposal_preview_link)
    {

        $benchmark_start = time();
        //get proposal data
        $data = array();
        $data['lumpSum'] = false;
        $data['fileName'] = 'Proposal';
        $data['showPreProposalPopup'] = $showPreProposalPopup;
        $data['showCompanySignatureButton'] = $showCompanySignatureButton;
        $data['device'] = $device;
        $data['proposal_preview_link_id'] = $proposal_preview_link_id;
        $data['proposal_preview_old_link'] = $proposal_preview_link->getOldLink();
        $data['proposal_preview_signature_link'] = $proposal_preview_link->getSignatureLink();

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
            if($download || $print || $cache){
                if($data['layout'] == 'web-custom'){
                    $data['layout'] = 'gradient';
                 }
                $data['layout'] = str_replace("web-","",$data['layout']);
             }
        } else {
            $this->load->view('pdf/proposal_not_found');
        }

    //echo "<pre>";print_r($data);die;
          
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
        $data['services_org'] = $services;
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


            $service_images = $this->em->createQuery('SELECT i FROM models\Proposals_images i  where i.proposal_service_id = '.$service->getServiceId().'  AND i.proposal=' . $proposal->getProposalId() . ' order by i.map DESC,i.ord ASC')->getResult();
            
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
       // echo "<pre>";
       // print_r($data['proposal_videos']);die;
        $data['proposal_intro_video'] = $this->getProposalRepository()->getProposalIntroVideo($proposal->getProposalId());
        $data['work_order_videos'] = $this->getProposalRepository()->getWorkOrderVisibleProposalVideos($proposal->getProposalId());
        $data['work_order_intro_video'] = $this->getProposalRepository()->getWorkOrderVisibleIntroVideos($proposal->getProposalId());
        $data['work_order_notes'] = $this->getProposalRepository()->getWorkOrderNotes($proposal->getProposalId());

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

        $data['track_activity'] = 0;
        $data['nosidebar'] = 0;
        if (!$this->session->userdata('logged') && $noTracking == 0) {
            $data['track_activity'] = 1;
            
        }

        //Handle For LogedIn user with diffrent company
        if($this->account()){

            if($this->account()->getCompanyId() != $proposal->getCompanyId() && $noTracking == 0){
                $data['track_activity'] = 1;
            }
        }
        

        if($noTracking == 1){
            $data['nosidebar'] = 1;
        }
        

        // if (($data['layout'] == 'work_order') || ($data['layout'] == 'work_order2')) {
        //     $data['plantDirections'] = $this->getProposalRepository()->getAllTruckingDirections($proposal);
        // }
        ob_start();

         // echo $data['layout'];die;
          
         $this->load->view('pdf/layouts/' . $data['layout'], $data);
       // $this->load->view('pdf/layouts/web-cool-standard2', $data);
       
        if ($data['layout'] !== 'web-cool-standard') {

            $html = ob_get_contents();
           // echo $html;die;
            ob_end_clean();
            if (!$this->debug) {
            } else {
                echo $html;
                die();
            }
            //PDF Options
            $pdfOptions = new \Dompdf\Options();
            $pdfOptions->setIsPhpEnabled(true);

            // PDF
            $dompdf = new Dompdf\Dompdf($pdfOptions);
            
            if (($data['layout'] == 'work_order') || ($data['layout'] == 'work_order2')) {
                $dompdf->setPaper("a4", "landscape");
            }

             $dompdf->loadHtml($html);

 
            if (!$cache) {
                header('Content-Type: application/pdf');
            }
 
            $dompdf->render();
            if ($download) {
                 $dompdf->stream(str_replace("."," ",$proposal->getProjectName()));
            }else if($print){
                $pdf = $dompdf->output();
                echo $pdf;
            }else if($cache){
                $pdf = $dompdf->output();
                file_put_contents($saveToFile, $pdf);
                die($saveToFile);
            } else {
                $pdf = $dompdf->output();
                
                if (!$saveToFile) {
                    echo $pdf;
                } else {
                    file_put_contents($saveToFile, $pdf);

                    //                mail('chris@rapidinjection.com', 'PMS benchmark time - Proposal #' . $proposal_id, 'Total time it took to build proposal #' . $proposal_id . ': ' . $benchmark_duration . ' seconds');
                }
            }
        }

                // Define the array
                $timeKey = date("Y-m-d H:i:s");

                 $array = array(
                    "function Name" => "renderProposal", "layout" => $data['layout'],
                    "download"=>$download,"print"=>$print,"cache"=>$cache,"saveToFile"=>$saveToFile,
                    "timeKey"=>$timeKey,"checkProposalChecklist"=>$data['checkProposalChecklist']

                );
                
                // Initialize an empty string to hold the formatted data
                $formattedData = '';
                
                // Iterate over the array and concatenate key-value pairs
                foreach ($array as $key => $value) {
                    $formattedData .= "$key: $value\n";
                }
                // Write the formatted data to a text file
                $file = 'output.txt'; // Specify the file name
                file_put_contents($file, $formattedData);
                
 
    }


    public function createPageView()
    {

        $this->load->library('JsonResponse');
        $response = new JsonResponse();
        $ipaddress = $_SERVER['REMOTE_ADDR'];

        $uuid = $this->input->post('uuid');
        session_start();
        $session_id = session_id();

        $proposal_preview_link = $this->em->getRepository('models\ProposalPreviewLink')
            ->findOneBy([
                'uuid' => $uuid
            ]);


        $proposal_view = $this->em->getRepository('models\ProposalView')
            ->findOneBy(
                [
                    'proposal_link_id' => $proposal_preview_link->getId(),
                    'session_id' => $session_id
                ],
                [
                    'updated_at' => 'DESC'
                ]
            );

        //$proposal_view = false;

        if ($proposal_view) {
            if ($proposal_view->getUpdatedAt() < Carbon::now()->subMinutes($_ENV['PROPOSAL_VIEW_MINUTES'])) {
                $proposal_view = null;
            }
        }
        $proposal = $this->em->findProposal($proposal_preview_link->getProposalId());
        if (!$proposal_view) {


            $proposal_view = new \models\ProposalView();
            $proposal_view->setProposalId($proposal_preview_link->getProposalId());
            $proposal_view->setProposalLinkId($proposal_preview_link->getId());
            $proposal_view->setCreatedAt(Carbon::now());
            $proposal_view->setSessionId($session_id);
            $proposal_view->setIpAddress($ipaddress);

            
            //$proposal->setProposalViewCount($proposal->getProposalViewCount()+1);

            $browser = new Browser();

            $device = 'Desktop';
            $os = $browser->getOS();

            if ($browser->isMobile()) {
                $device = 'Phone';
                if ($browser->getPlatform() == 'iPhone' || $browser->getPlatform() == 'iOS') {
                    $device = 'iPhone';
                }
            } else if ($browser->isTablet()) {
                $device = 'Tablet';
                if ($browser->getPlatform() == 'iPad' || $browser->getPlatform() == 'iOS') {
                    $device = 'iPad';
                }
            }

            $proposal_view->setPlatform($os);
            $proposal_view->setPlatformVersion($browser->getPlatformVersion());
            $proposal_view->setDevice($device);
            $proposal_view->setBrowser($browser->getBrowser());

            //End send email 

        }


        $proposal_view->setUpdatedAt(Carbon::now());
        $proposal_view->setPdfView(0);
        $this->em->persist($proposal_view);
        $this->em->persist($proposal);
        $this->em->flush();

        if (!$proposal_view->getViewData()) {
            $viewData = json_encode([
                "cover" => 0,
                "title" => 0,
                "audit" => 0,
                "provider" => 0,
                "services" => 0,
                "images" => 0,
                "video" => 0,
                "terms" => 0,
                "signature" => 0,
                "price" => 0,
                "attachments" => 0
            ]);
        } else {
            $viewData = $proposal_view->getViewData();
        }

        $this->log_manager->add(\models\ActivityAction::WEB_PROPOSAL_VIEWED, '<a href="javascript:void(0);" class="log_proposal_view" data-proposal-preview-id="'.$proposal_view->getId().'" >Proposal Viewed</a> - '.$proposal_preview_link->getEmail().' <a href="mailto:'.$proposal_preview_link->getEmail().'"><i class="fa fa-fw fa-envelope"></i></a>', NULL, $proposal);

        $response->succes = true;
        $response->proposal_view_id = $proposal_view->getId();
        $response->proposal_view_data = $viewData;
        $response->proposal_total_duration = $proposal_view->getTotalDuration();
        $response->proposal_video_viewed = $proposal_view->getVideoPlayed();
        $response->proposal_image_viewed = $proposal_view->getImagesClicked();
        $response->proposal_service_spec_viewed = $proposal_view->getServiceSpecClicked();


        $response->service_text_links = $proposal_view->getServiceLinksViewed();
        $response->auditLinkOpenTime = $proposal_view->getAuditViewedTime();
        $response->auditClicked = $proposal_view->getAuditViewed();
        $response->view_service_text = $proposal_view->getServiceTextViewedTime();
        $response->image_object = $proposal_view->getViewedImageData();
        $response->video_object = $proposal_view->getViewedVideoData();

        $response->send();
    }

    function work_order_preview()
    {
        $data = array();
        $proposal_id =  $this->uri->segment(2);
        $print = false;
        $download = false;

        if($this->uri->segment(3) == 'print'){
            $print = true;
        }else if($this->uri->segment(3) == 'download'){
            $download = true;
        }
        if (strlen($proposal_id) < 16) {
            // Old, numeric format
            $proposal = $this->em->findProposal($proposal_id);

            if (!$proposal) {
                $this->load->view('pdf/proposal_not_found');
            } else {
                // Show message here with link to email sales rep

                $this->load->view(
                    'pdf/proposal_new_link',
                    ['proposal' => $proposal, 'account' => $proposal->getOwner()]
                );
                return;
            }
        } else {
            // New alphanumeric format
            $proposal = $this->em->findProposalByKey($proposal_id);
        }


       
        if (!$proposal) {
            $this->load->view('pdf/proposal_not_found');
        }
        //  elseif ($proposal->getOwner()->getExpires() < time()) {
        //     $this->load->view('pdf/proposal_expired');
        // } 
        elseif (!$this->account() && $proposal->hasUnapprovedServices()) {
            // Send email to proposal owner to let them know
            $this->getProposalRepository()->sendInProgressViewEmail($proposal);
            // Display the message
            $this->load->view('pdf/in-progress');
        } else {

            $data['proposal'] = $proposal;




        //get proposal data
        $data = array();
        $data['lumpSum'] = false;
        $data['fileName'] = 'Proposal';
        $data['showPreProposalPopup'] = 0;




        // print_r($this->getProposalRepository()->getClientSignature($proposal));die;
        $data['proposal'] = $proposal;
        $data['uuid'] = $this->uri->segment(2);
        $data['clientSig'] = $this->getProposalRepository()->getClientSignee($proposal);
        $data['companySig'] = $this->getProposalRepository()->getCompanySignee($proposal);
        $data['clientSignature'] = $this->getProposalRepository()->getClientSignature($proposal);
        $data['companySignature'] = $this->getProposalRepository()->getCompanySignature($proposal);

        $data['workOrderSections'] = $this->getCompanyRepository()->getCompanyWorkOrderSections($proposal->getCompanyId());
        
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
        $data['services_org'] = $services;
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


            $service_images = $this->em->createQuery('SELECT i FROM models\Proposals_images i  where i.proposal_service_id = '.$service->getServiceId().'  AND i.proposal=' . $proposal->getProposalId() . ' order by i.map DESC,i.ord ASC')->getResult();
            
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
        $data['work_order_videos'] = $this->getProposalRepository()->getWorkOrderVisibleProposalVideos($proposal->getProposalId());
        $data['work_order_intro_video'] = $this->getProposalRepository()->getWorkOrderVisibleIntroVideos($proposal->getProposalId());
        $data['work_order_notes'] = $this->getProposalRepository()->getWorkOrderNotes($proposal->getProposalId());
        $data['plantDirections'] = $this->getProposalRepository()->getAllTruckingDirections($proposal);
        // Do we need to load some PSA data?
        if ($proposal->getInventoryReportUrl()) {
            $this->load->library('psa_client', ['public' => true]);
            $data['inventoryData'] = $this->psa_client->inventoryData(['reportKey' => $proposal->getInventoryReportUrl()]);
        }

        $data['track_activity'] = 0;
        $data['noDownload'] = 0;
        $data['nosidebar'] = 1;
       
        if($this->uri->segment(3) == 'noDownload'){
            $data['noDownload'] = 1;
        }

        

        if ($print || $download) {
            $this->load->view('pdf/layouts/work_order', $data);
            $html = ob_get_contents();
            ob_end_clean();
            if (!$this->debug) {
            } else {
                echo $html;
                die();
            }
            //PDF Options
            $pdfOptions = new \Dompdf\Options();
            $pdfOptions->setIsPhpEnabled(true);

            // PDF
            $dompdf = new Dompdf\Dompdf($pdfOptions);

            
                $dompdf->setPaper("a4", "landscape");
           
            $dompdf->loadHtml($html);
            header('Content-Type: application/pdf');
            $dompdf->render();
            if ($download) {
                
                $dompdf->stream(str_replace("."," ",$proposal->getProjectName()));
            }else if($print){
                $pdf = $dompdf->output();
                echo $pdf;
            }
        }else{
            $data['work_order_layout'] = $proposal->getWorkOrderSetting();
            $this->load->view('pdf/layouts/web-work_order', $data);
        }



        }
    }

    // create a pdf for proposal customer checklist 

    public function checklist($proposal_id)
    {
        $this->debug = 0;
         if (!$this->debug) {
            $this->setHeaders('proposal_customer_checklist.pdf');
        }
         ob_start();
             $data['data'] = $this->em->getRepository('models\ProposalCustomerCheckList')->findOneBy(array(
            'proposal_id' => $proposal_id
        ));

          $this->load->view('pdf/proposal-customer-checklist/default', $data);

  
        $html = ob_get_contents();
        ob_end_clean();
        if (!$this->debug) {
            $pdfOptions = new \Dompdf\Options();
            $pdfOptions->setIsPhpEnabled(true);
            // PDF
            $dompdf = new Dompdf\Dompdf($pdfOptions);
            $dompdf->loadHtml($html);
            $dompdf->render();
            echo $dompdf->output();
        } else {
            $html = preg_replace('/>\s+</', '><', $html); //for remove blank page

            echo $html;
        }
    }

    // create a pdf for proposal customer checklist

    public function testTime(){
        date_default_timezone_set('Pacific/Pitcairn');
       echo  date('m/d/Y h:i:s A', realTime(time()));
    }
}
