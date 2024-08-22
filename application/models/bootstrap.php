<?php

use Doctrine\ORM\Query\ResultSetMapping;

class Bootstrap extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->em = $this->doctrine->em;
        //check for authentication token and
        $this->relogin();
        //set TimeZone offset
        $tz_offset = 0; //default offset, for EST - server time
        if ($this->session->userdata('logged')) {
            $account = $this->em->find('models\Accounts', $this->session->userdata('accountId'));
            switch ($account->getTimeZone()) {
                case 'EST':
                    $tz_offset = 0;
                    break;
                case 'CST':
                    $tz_offset = -3600;
                    break;
                case 'MST':
                    $tz_offset = -7200;
                    break;
                case 'PST':
                    $tz_offset = -10800;
                    break;
                default:
                    $tz_offset = 0;
            }
        }
        define('TIMEZONE_OFFSET', $tz_offset); //set the timezone offset for the logged in user's timezone set up
        //count the number of proposals in Queue
        if ($this->session->userdata('logged')) {
            $leadAccount = $account;
            $sublogin_account = $this->em->find('models\Accounts', $this->session->userdata('sublogin'));
            if ($sublogin_account) {
                $leadAccount = $sublogin_account;
            }
            $this->load->database();
            // if ($leadAccount->getUserClass() > 1) {

            //     $rsm = new ResultSetMapping();
            //     $rsm->addScalarResult('count','count');
            //     $sql = "SELECT count( p.proposalId ) AS count
            //             FROM proposals AS p
            //             LEFT JOIN clients AS c ON p.client = c.clientId
            //             LEFT JOIN accounts AS a ON c.account = a.accountId
            //             WHERE (a.company = :companyId)
            //             AND (p.approvalQueue = 1)"; 
            //     $query = $this->em->createNativeQuery($sql, $rsm);
            //     $query->setParameter(':companyId', $leadAccount->getCompany()->getCompanyId());
            //     // Cache it
            //     $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_ADMIN_HEADER_QUEUED_PROPOSAL_COUNT . $leadAccount->getCompany()->getCompanyId());
            //     $countQueued = $query->getResult();

            //     $rsm = new ResultSetMapping();
            //     $rsm->addScalarResult('count','count');
            //     $sql = "SELECT count( p.proposalId ) AS count
            //             FROM proposals AS p
            //             LEFT JOIN clients AS c ON p.client = c.clientId
            //             LEFT JOIN accounts AS a ON c.account = a.accountId
            //             WHERE (a.company = :companyId)
            //             AND (p.declined = 1)";
            //     $query = $this->em->createNativeQuery($sql, $rsm);
            //     $query->setParameter(':companyId', $leadAccount->getCompany()->getCompanyId());
            //     // Cache it
            //     $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_ADMIN_HEADER_DECLINED_PROPOSAL_COUNT . $leadAccount->getCompany()->getCompanyId());
            //     $countDeclined = $query->getResult();
            //     $countQueued = $countQueued[0]['count'];
            //     $countDeclined = $countDeclined[0]['count'];

            // } elseif ($leadAccount->getUserClass() == 1) {
            //     $rsm = new ResultSetMapping();
            //     $rsm->addScalarResult('count','count');
            //     $sql = "SELECT count( p.proposalId ) AS count
            //             FROM proposals AS p
            //             LEFT JOIN clients AS c ON p.client = c.clientId
            //             LEFT JOIN accounts AS a ON c.account = a.accountId
            //             WHERE (a.company = :companyId)
            //             AND (p.approvalQueue = 1)
            //             AND (a.branch = :branch)";
            //     $query = $this->em->createNativeQuery($sql, $rsm);
            //     $query->setParameter(':companyId', $leadAccount->getCompany()->getCompanyId());
            //     $query->setParameter(':branch', $leadAccount->getBranch());
            //     // Cache it
            //     $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_BRANCH_HEADER_QUEUED_PROPOSAL_COUNT . $leadAccount->getCompany()->getCompanyId());
            //     $countQueued = $query->getResult();

            //     $rsm = new ResultSetMapping();
            //     $rsm->addScalarResult('count','count');
            //     $sql = "SELECT count( p.proposalId ) AS count
            //             FROM proposals AS p
            //             LEFT JOIN clients AS c ON p.client = c.clientId
            //             LEFT JOIN accounts AS a ON c.account = a.accountId
            //             WHERE (a.company = :companyId)
            //             AND (p.declined = 1)
            //             AND (a.branch = :branch)";
                
            //     $query = $this->em->createNativeQuery($sql, $rsm);
            //     $query->setParameter(':companyId', $leadAccount->getCompany()->getCompanyId());
            //     $query->setParameter(':branch', $leadAccount->getBranch());
            //     // Cache it
            //     $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_BRANCH_HEADER_DECLINED_PROPOSAL_COUNT . $leadAccount->getCompany()->getCompanyId());
            //     $countDeclined = $query->getResult();


            //     $countQueued = $countQueued[0]['count'];
            //     $countDeclined = $countDeclined[0]['count'];
            // } else {
            //     $countQueued = 0;
            //     $countDeclined = 0;
            // }
            // if ($countQueued == 0) {

            //     if( !$this->session->userdata('pFilterQueue') == 'duplicate' ){
            //         $this->session->set_userdata('pFilterQueue', '');
            //     }
            // }
            // define('QUEUEDPROPOSALS', $countQueued);
            // define('DECLINEDPROPOSALS', $countDeclined);
        }
    }

    function relogin() {
        if (!$this->session->userdata('logged') && $this->input->cookie('auth_token')) {
            $account = $this->em->getRepository('models\Accounts')->findOneBy(array('token' => $this->input->cookie('auth_token', TRUE)));
            if ($account) {
                $this->session->set_userdata(array('logged' => 1, 'accountId' => $account->getAccountId()));
            }
        }
    }
}
