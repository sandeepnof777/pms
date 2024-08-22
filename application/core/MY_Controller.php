<?php
## Extend CI_Controller to include Doctrine Entity Manager and set up basic stuff

use Doctrine\ORM\Query\ResultSetMapping;

class  MY_Controller extends CI_Controller
{
    use \Pms\Traits\RepositoryTrait;
    use \Pms\Traits\PMSTrait;

    /* @var \Doctrine\ORM\EntityManager */
    public $em;
    protected $accountData;
    protected $login_restricted = false;

    var $leadStatuses;
    var $prospectStatuses;
    var $prospectBusinesses;
    var $leadRatings;
    var $prospectRatings;
    var $leads;
    var $leadSources;
    var $leadCount = 0;
    var $upcomingEventsCount = 0;

    function __construct()
    {
        parent::__construct();
        //$this->load->library('session');
        if ($this->login_restricted) {
           // echo '<pre>';


            if (!$this->session->userdata('logged')) {
                //echo 'check';die;
                $this->session->set_flashdata('error', 'You must be logged in to view this page!');
                redirect('home/signin');
            }
        }
        $this->em = $this->doctrine->em;

        $this->config->load('system', TRUE);

        //Load sensible information from the config - this should be done when used not bootstrapped, todo for later
        $this->leadStatuses = $this->system_setting('lead_statuses');
        $this->prospectStatuses = $this->system_setting('prospect_statuses');
        $this->prospectBusinesses = $this->system_setting('prospect_businesses');
        $this->leadRatings = $this->system_setting('lead_ratings');
        $this->prospectRatings = $this->system_setting('prospect_ratings');
        $this->leadSources = $this->system_setting('lead_sources');
        $this->servicePricingTypes = $this->system_setting('service_pricing_types');
        $this->materials = $this->system_setting('materials');

        //new lead count sql, if user is logged
        if ($this->session->userdata('accountId')) {

            // if ($this->account()->getUserClass() >= 2) {//admin

            //     $dql = "SELECT count(l.leadId) AS leadCount
            //     FROM \models\Leads l
            //     WHERE l.company = :companyId
            //      AND (l.status = 'Working' OR l.status = 'Waiting for subs')";

            //     $query = $this->em->createQuery($dql);
            //     $query->setParameter(':companyId', $this->account()->getCompany()->getCompanyId());
            //     //Cache It
            //     $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_ADMIN_HEADER_LEAD_COUNT . $this->account()->getCompany()->getCompanyId());



            // } elseif ($this->account()->getUserClass() == 1) {
            //     //branch manager

            //     $rsm = new ResultSetMapping();
                
            //     $rsm->addScalarResult('leadCount','leadCount');

            //     $sql = "SELECT count(l.leadId) AS leadCount
            //         FROM leads l
            //         INNER JOIN accounts a ON a.accountId = l.account
            //         WHERE l.company = :companyId AND (l.status = 'Working' OR l.status = 'Waiting for subs')
            //         AND a.branch = :branch";

            //     $query = $this->em->createNativeQuery($sql, $rsm);
            //     $query->setParameter(':branch', $this->account()->getBranch());
            //     $query->setParameter(':companyId', $this->account()->getCompany()->getCompanyId());

            //     // Cache it
            //     $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_BRANCH_HEADER_LEAD_COUNT . $this->account()->getCompany()->getCompanyId());


            // } else { //regular user

            //     $dql = "SELECT count(l.leadId) AS leadCount
            //     FROM \models\Leads l
            //     WHERE l.company = :companyId
            //      AND (l.status = 'Working' OR l.status = 'Waiting for subs') and l.account= :accountId";

            //     $query = $this->em->createQuery($dql);
            //     $query->setParameter(':companyId', $this->account()->getCompany()->getCompanyId());
            //     $query->setParameter(':accountId', $this->account()->getAccountId());
            //     //Cache It
            //     $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_USER_HEADER_LEAD_COUNT . $this->account()->getCompany()->getCompanyId());


            // }

            // $total = $query->getResult();
            // $this->leadCount = ($total[0]['leadCount']) ? $total[0]['leadCount'] : 0;
           
            $this->upcomingEventsCount = $this->getEventRepository()->getUpcomingEventsCount($this->account());

            $this->load->library('BaseHelper');
            $this->load->library('PmsRepository');
        }
    }

    /**
     * @param bool $refresh
     * @return \models\Accounts
     */
    protected function account($refresh = FALSE)
    {

    $em = $this->doctrine->em;

        if (($this->accountData === NULL) || $refresh) {

            //echo $this->session->userdata('accountId');

            $this->accountData = $em->find("models\Accounts", $this->session->userdata('accountId'));


            if ($this->session->userdata('sublogin')) {
                $sublogin_account = $this->em->find('models\Accounts', $this->session->userdata('sublogin'));
                if ($sublogin_account) {
                    $this->accountData = $sublogin_account;
                }
            }
        }
        return $this->accountData;
    }

    function getCompanyAccounts()
    {
        $accounts = array();
        $accs = $this->account()->getCompany()->getAccounts();
        foreach ($accs as $acc) {
            $accounts[$acc->getAccountId()] = $acc;
        }
        return $accounts;
    }

    /**
     * @param $class
     * @param $message
     * Wrapper for flashdata functionality
     */
    function alert($class, $message)
    {
        $this->session->set_flashdata($class, $message);
    }

    /**
     * Returns a system config key, shorthand
     * @param $key
     * @return mixed
     */
    public function system_setting($key)
    {
        return $this->config->item($key, 'system');
    }

}