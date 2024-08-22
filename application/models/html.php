<?php

use Doctrine\ORM\Query\ResultSetMapping;

class Html extends CI_Model
{
    use \Pms\Traits\RepositoryTrait;
    private $headCodes;
    private $bodyCodes;
    private $javaScripts;

    function __construct()
    {
        parent::__construct();
        //settings
        $this->javaScripts = "/* Caching of Java Scripts -- Created by IeD3vil to reduce page load */\n";
        $this->addHeadCode('<script type="text/javascript" src="' . site_url('cache/js') . '"></script>');
        //standard
        $this->addJS(site_url('3rdparty/moment/moment.js'));
        $this->addJS(site_url('static/js/jquery.min.js'));
        $this->addJS(site_url('static/js/select2.min.js'));
        $this->addCSS(site_url('static/css/select2.min.css'));
        $this->addCSS(site_url('static/style.css?202205091400'));
        $this->addCSS(site_url('3rdparty/tiptip/tipTip.css'));
        $this->addCSS(site_url('3rdparty/uniform/css/uniform.default.css'));
        $this->addCSS('https://fonts.googleapis.com/css?family=Lato|Roboto|Quicksand');
        $this->addScript('jQueryUI');
        $this->addJS(site_url('static/js/jquery.plugin.js'));
        $this->addJS(site_url('static/js/jquery.countdown.js'));
        $this->addJS(site_url('static/js/general.js?202201281600'));
        $this->addJS(site_url('3rdparty/tiptip/jquery.tipTip.minified.js'));
        $this->addJS(site_url('3rdparty/uniform/jquery.uniform.min.js'));
        $this->addJS(site_url('3rdparty/jquery.validate.js'));
        $this->addJS(site_url('3rdparty/jquery.maskedinput-1.3.min.js'));
        $this->addJS(site_url('3rdparty/jquery.formatCurrency-1.4.0.min.js'));
        $this->addJS(site_url('3rdparty/jquery.ui.touch-punch2.min.js'));
        $this->addJS('//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js');
        $this->addCSS('//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css');
        $this->addCSS(site_url('3rdparty/fontawesome/css/font-awesome.min.css'));
        $this->addScript('fancybox');
        $this->addScript('sweetalert');
        $this->addJS('https://maps.googleapis.com/maps/api/js?key=' . $_ENV['GOOGLE_API_KEY'] . '&libraries=places', false, true); // Fuck it
      //  $this->addJS('https://cdn.tiny.cloud/1/' . $_ENV['TINYMCE_API_KEY'] . '/tinymce/5/tinymce.min.js');
      // $this->addJS('https://cdn.tiny.cloud/1/' . $_ENV['TINYMCE_API_KEY'] . '/tinymce/7/tinymce.min.js');
        
       $this->addJS(site_url('static/js/tinymce/tinymce.min.js'));


        // $this->addCSS('https://cdn.quilljs.com/1.3.6/quill.snow.css');
        // $this->addJS('https://cdn.quilljs.com/1.3.6/quill.js');


        $this->addCSS(site_url('3rdparty/materialize/css/materialized.css?123'));
        $this->addJS(site_url('3rdparty/jeditable/jquery.jeditable.js?202111151600'));
    }

    function addHeadCode($code)
    {
        $this->headCodes .= "\n" . $code;
    }

    function addBodyCode($code)
    {
        $this->bodyCodes .= "\n" . $code;
    }

    function addJS($jsURL, $minify = false, $defer = false)
    {
        if ($minify === true) {
            $this->javaScripts .= "/*File - {$jsURL} */\n";
            $this->javaScripts .= file_get_contents($jsURL) . "\n\n";
        } else {
            $this->addHeadCode('<script type="text/javascript" src="' . $jsURL . '"></script>');
        }
    }

    function getJavaScripts()
    {
        return $this->javaScripts;
    }


    function addCSS($cssURL)
    {
        $this->addHeadCode('<link rel="stylesheet" type="text/css" href="' . $cssURL . '" media="all">');
    }

    function addScript($script)
    {
        switch ($script) {
            case 'jQueryUI':
                $this->addJS(site_url('static/js/jquery-ui.min.js'));
                $this->addCSS(site_url('3rdparty/jqueryUi/css/eggplant/jquery-ui-1.8.15.custom.css'));
                break;
            case 'dataTables':
                $this->addCSS(site_url('3rdparty/dataTables/media/css/demo_table_jui.css'));
                $this->addJS(site_url('3rdparty/dataTables/media/js/jquery.dataTables.min.js'));
                $this->addCSS(site_url('3rdparty/DataTables-new/datatables.min.css'));
                $this->addJS(site_url('3rdparty/DataTables-new/dataTables.fixedColumns.min.js'));
                //$this->addJS(site_url('3rdparty/DataTables-new/DataTables-1.10.20/js/dataTables.fixedHeader.min.js'));
                
                $this->addJS(site_url('3rdparty/dataTables/media/js/datatables.fnReloadAjax.js'));



                // Row Reorder Plugin
                $this->addCSS(site_url('3rdparty/dataTables/media/css/datatables-rowreorder-1.2.4.css'));
                $this->addJS(site_url('3rdparty/dataTables/media/js/datatables-rowreorder-1.2.4.js'));
                $this->addJS(site_url('static/js/dataTable.js?123'));
                break;
            case 'fancybox':
                $this->addJS(site_url('3rdparty/fancybox/source/jquery.fancybox.js'));
                $this->addJS(site_url('3rdparty/fancybox/source/helpers/jquery.fancybox-buttons.js?v=2.0.4'));
                $this->addJS(site_url('3rdparty/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=2.0.4'));
                $this->addCSS(site_url('3rdparty/fancybox/source/jquery.fancybox.css'));
                $this->addCSS(site_url('3rdparty/fancybox/source/helpers/jquery.fancybox-buttons.css?v=2.0.4'));
                $this->addCSS(site_url('3rdparty/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=2.0.4'));
                $this->addJS(site_url('static/js/fancybox.js'));
                break;
            case 'kendo':
                $this->addCSS(site_url('3rdparty/kendo/styles/kendo.common.min.css'));
                $this->addCSS(site_url('3rdparty/kendo/styles/kendo.metro.min.css'));
                $this->addJS(site_url('3rdparty/kendo/js/kendo.dataviz.min.js'));
                break;
            case 'flot':
                $this->addJS(site_url('3rdparty/flot/jquery.flot.min.js'));
                $this->addJS(site_url('3rdparty/flot/jquery.flot.pie.min.js'));
                break;
            case 'ckeditor':
                $this->addJS(site_url('3rdparty/ckeditor/ckeditor.js'));
                break;
            case 'ckeditor4':
                $this->addJS(site_url('static/js/jquery.spellchecker.min.js'));
                $this->addCSS(site_url('static/css/jquery.spellchecker.min.css'));
                $this->addJS(site_url('3rdparty/ckeditor4/ckeditor.js'));
                break;
            case 'prettyPhoto':
                $this->addJS(site_url('3rdparty/prettyPhoto/jquery.prettyPhoto.js'));
                $this->addCSS(site_url('3rdparty/prettyPhoto/prettyPhoto.css'));
                break;
            case 'googleAjax':
                $this->addJS('https://www.google.com/jsapi');
                break;
            case 'maps':
                //$this->addJS('https://maps.googleapis.com/maps/api/js?key=' . GOOGLE_API_KEY . '&libraries=places');
                // Now included by default
                break;
            case 'daterangepicker':
                $this->addJS(site_url('3rdparty/moment/moment.js'));
                $this->addJS(site_url('3rdparty/daterangepicker/jquery.comiseo.daterangepicker.min.js'));
                $this->addCSS(site_url('3rdparty/daterangepicker/jquery.comiseo.daterangepicker.css'));
                break;
            case 'colorpicker':
                $this->addJS(site_url('3rdparty/jscolor/jscolor.min.js'));
                break;
            case 'scheduler':
                $this->addJS(site_url('static/js/scheduler.js'));
                $schedulerData = [];
                $schedulerData['event_types'] = $this->getEventRepository()->getTypes($this->getAccountRepository()->getLoggedAccount()->company);
                $schedulerData['event_accounts'] = $this->getAccountRepository()->getAllAccountsByPermission($this->getAccountRepository()->getLoggedAccount()->accountId);
                $schedulerData['currentAccountId'] = $this->getAccountRepository()->getLoggedAccount()->accountId;
                $this->addBodyCode($this->load->view('scheduler/dialog', $schedulerData, true));
                $this->addJS(site_url('3rdparty/fullcalendar/lib/moment.min.js'));
                $this->addScript('wickedpicker');
                break;
            case 'fullCalendar':
                $this->addCSS(site_url('3rdparty/fullcalendar/fullcalendar.css'));
                $this->addJS(site_url('3rdparty/fullcalendar/lib/moment.min.js'));
                $this->addJS(site_url('3rdparty/fullcalendar/fullcalendar.min.js'));
                break;
            case 'wickedpicker':
                $this->addJs(site_url('3rdparty/wickedpicker/wickedpicker.min.js'));
                $this->addCss(site_url('3rdparty/wickedpicker/wickedpicker.min.css'));
                break;
            case 'sweetalert':
                $this->addJS(site_url('3rdparty/sweetalert/sweetalert2.min.js'));
                $this->addCSS(site_url('3rdparty/sweetalert/sweetalert2.min.css'));
                break;
            case 'spectrum':
                $this->addJS(site_url('3rdparty/spectrum/spectrum.js'));
                $this->addCSS(site_url('3rdparty/spectrum/spectrum.css'));
                break;
            case 'fontawesome':
                $this->addCSS(site_url('3rdparty/fontawesome/font-awesome.min.css'));
                break;
            case 'select2':
                
                break;
            case 'proposalTracking':
                $this->addJS(site_url('static/js/proposalTrackingDetails.js'));
                break;
        }
    }

    function getHeadCodes()
    {
        return $this->headCodes . "\n";
    }

    function getBodyCodes()
    {
        return $this->bodyCodes . "\n";
    }

    public function getleadsCount(){
        
            if ($this->session->userdata('accountId')) {
                $account = $this->em->find('models\Accounts', $this->session->userdata('accountId'));
                
                if($this->session->userdata('sublogin')) {
                    $account = $this->em->find('models\Accounts', $this->session->userdata('sublogin'));
                }
                $companyId = $account->getCompany()->getCompanyId();
                if ($account->getUserClass() >= 2) {//admin

                    $dql = "SELECT count(l.leadId) AS leadCount
                    FROM \models\Leads l
                    WHERE l.company = :companyId
                    AND (l.status = 'Working' OR l.status = 'Waiting for subs')";

 
                    $query = $this->em->createQuery($dql);
                  
                    $query->setParameter(':companyId', $companyId);
                    //Cache It
                    $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_ADMIN_HEADER_LEAD_COUNT . $companyId);



                } elseif ($account->getUserClass() == 1) {
                    //branch manager

                    $rsm = new ResultSetMapping();
                    
                    $rsm->addScalarResult('leadCount','leadCount');

                    $sql = "SELECT count(l.leadId) AS leadCount
                        FROM leads l
                        INNER JOIN accounts a ON a.accountId = l.account
                        WHERE l.company = :companyId AND (l.status = 'Working' OR l.status = 'Waiting for subs')
                        AND a.branch = :branch";

                    $query = $this->em->createNativeQuery($sql, $rsm);
                    $query->setParameter(':branch', $account->getBranch());
                    $query->setParameter(':companyId', $companyId);

                    // Cache it
                    $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_BRANCH_HEADER_LEAD_COUNT . $companyId);


                } else { //regular user

                    $dql = "SELECT count(l.leadId) AS leadCount
                    FROM \models\Leads l
                    WHERE l.company = :companyId
                    AND (l.status = 'Working' OR l.status = 'Waiting for subs') and l.account= :accountId";

                    $query = $this->em->createQuery($dql);
                    $query->setParameter(':companyId', $companyId);
                    $query->setParameter(':accountId', $account->getAccountId());
                    //Cache It
                    $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_USER_HEADER_LEAD_COUNT . $companyId);


                }

                $total = $query->getResult();
                return ($total[0]['leadCount']) ? $total[0]['leadCount'] : 0;
            }
        }

        public function getQueuedProposals(){
            $account = $this->em->find('models\Accounts', $this->session->userdata('accountId'));
            $leadAccount = $account;
            $sublogin_account = $this->em->find('models\Accounts', $this->session->userdata('sublogin'));
            if ($sublogin_account) {
                $leadAccount = $sublogin_account;
            }
            if ($leadAccount->getUserClass() > 1) {

                $rsm = new ResultSetMapping();
                $rsm->addScalarResult('count','count');
                $sql = "SELECT count( p.proposalId ) AS count
                        FROM proposals AS p
                        LEFT JOIN clients AS c ON p.client = c.clientId
                        LEFT JOIN accounts AS a ON c.account = a.accountId
                        WHERE (a.company = :companyId)
                        AND (p.approvalQueue = 1)"; 
                $query = $this->em->createNativeQuery($sql, $rsm);
                $query->setParameter(':companyId', $leadAccount->getCompany()->getCompanyId());
                // Cache it
                $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_ADMIN_HEADER_QUEUED_PROPOSAL_COUNT . $leadAccount->getCompany()->getCompanyId());
                $countQueued = $query->getResult();

                $rsm = new ResultSetMapping();
                $rsm->addScalarResult('count','count');
                $sql = "SELECT count( p.proposalId ) AS count
                        FROM proposals AS p
                        LEFT JOIN clients AS c ON p.client = c.clientId
                        LEFT JOIN accounts AS a ON c.account = a.accountId
                        WHERE (a.company = :companyId)
                        AND (p.declined = 1)";
                $query = $this->em->createNativeQuery($sql, $rsm);
                $query->setParameter(':companyId', $leadAccount->getCompany()->getCompanyId());
                // Cache it
                $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_ADMIN_HEADER_DECLINED_PROPOSAL_COUNT . $leadAccount->getCompany()->getCompanyId());
                $countDeclined = $query->getResult();
                $countQueued = $countQueued[0]['count'];
                $countDeclined = $countDeclined[0]['count'];

            } elseif ($leadAccount->getUserClass() == 1) {
                $rsm = new ResultSetMapping();
                $rsm->addScalarResult('count','count');
                $sql = "SELECT count( p.proposalId ) AS count
                        FROM proposals AS p
                        LEFT JOIN clients AS c ON p.client = c.clientId
                        LEFT JOIN accounts AS a ON c.account = a.accountId
                        WHERE (a.company = :companyId)
                        AND (p.approvalQueue = 1)
                        AND (a.branch = :branch)";
                $query = $this->em->createNativeQuery($sql, $rsm);
                $query->setParameter(':companyId', $leadAccount->getCompany()->getCompanyId());
                $query->setParameter(':branch', $leadAccount->getBranch());
                // Cache it
                $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_BRANCH_HEADER_QUEUED_PROPOSAL_COUNT . $leadAccount->getCompany()->getCompanyId());
                $countQueued = $query->getResult();

                $rsm = new ResultSetMapping();
                $rsm->addScalarResult('count','count');
                $sql = "SELECT count( p.proposalId ) AS count
                        FROM proposals AS p
                        LEFT JOIN clients AS c ON p.client = c.clientId
                        LEFT JOIN accounts AS a ON c.account = a.accountId
                        WHERE (a.company = :companyId)
                        AND (p.declined = 1)
                        AND (a.branch = :branch)";
                
                $query = $this->em->createNativeQuery($sql, $rsm);
                $query->setParameter(':companyId', $leadAccount->getCompany()->getCompanyId());
                $query->setParameter(':branch', $leadAccount->getBranch());
                // Cache it
                $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_BRANCH_HEADER_DECLINED_PROPOSAL_COUNT . $leadAccount->getCompany()->getCompanyId());
                $countDeclined = $query->getResult();


                $countQueued = $countQueued[0]['count'];
                $countDeclined = $countDeclined[0]['count'];
            } else {
                $countQueued = 0;
                $countDeclined = 0;
            }
            if ($countQueued == 0) {

                if( !$this->session->userdata('pFilterQueue') == 'duplicate' ){
                    $this->session->set_userdata('pFilterQueue', '');
                }
            }
            return $countQueued;
            // define('QUEUEDPROPOSALS', $countQueued);
            // define('DECLINEDPROPOSALS', $countDeclined);
        }
    
}