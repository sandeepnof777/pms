<?php

namespace models;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="branches")
 */
class Branches extends \MY_Model {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $branchId;

    /**
     * @ORM\Column (type="integer", nullable=true)
     */
    private $company;

    /**
     * @ORM\Column (type="string", nullable=true)
     */
    private $branchName;

    private $branchCompany;

    function __construct() {
        //$this->fetchBranchCompany();
    }

    public function getBranchId() {
        return $this->branchId;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCompany($company) {
        $this->company = $company;
    }

    public function getBranchName() {
        return $this->branchName;
    }

    public function setBranchName($branchName) {
        $this->branchName = $branchName;
    }


    /**
     *  Return a collection of proposals with a specific status
     */
    public function getProposalsByStatus($statusId){
        $CI =& get_instance();

        $dql = "SELECT p FROM \models\Proposals p, \models\Clients c
                WHERE p.client = c.clientId
                AND c.account = :accountId
                AND p.proposalStatus = :statusId";

        $query = $CI->em->createQuery($dql);
        $query->setParameter('accountId', $this->getAccountId());
        $query->setParameter('statusId', $statusId);

        $proposals = $query->getResult();

        return $proposals;
    }

    /**
     * Returns a collection of the default statuses
     */
    public function getDefaultStatuses(){
        $CI =& get_instance();

        $q = 'SELECT s FROM models\Status s
                WHERE s.company IS NULL
                AND s.visible = 1
                ORDER BY s.displayOrder ASC';

        $query = $CI->em->createQuery($q);

        return $query->getResult();
    }

    public function getRangeCreatedProposals(array $time, $count = false)
    {
        $dql = "SELECT p FROM \models\Proposals p, \models\Clients c, \models\Accounts a
                WHERE p.client = c.clientId
                AND c.account = a.accountId
                AND a.branch = :branch
                AND p.created >= :startTime
                AND p.statusChangeDate >= :statusChangeStart
                AND p.created <= :finishTime
                AND p.statusChangeDate < :statusChangeFinish";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('branch', $this->getBranchId());
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('statusChangeStart', $time['start']);
        $query->setParameter('finishTime', $time['finish']);
        $query->setParameter('statusChangeFinish', $time['finish']);

        $proposals = $query->getResult();

        if($count){
            return count($proposals);
        }

        return $proposals;
    }


    public function getRangeCreatedProposalsPrice(array $time)
    {
        $dql = "SELECT SUM(p.price) FROM \models\Proposals p, \models\Clients c, \models\Accounts a
                WHERE p.client = c.clientId
                AND p.duplicateOf IS NULL
                AND c.account = a.accountId
                AND a.branch = :branch
                AND p.created >= :startTime
                AND p.statusChangeDate >= :startTime
                AND p.created <= :finishTime
                AND p.statusChangeDate <= :finishTime";

        $query = $this->doctrine->em->createQuery($dql);

        $query->setParameter('branch', $this->getBranchId());
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);

        $total = $query->getSingleScalarResult();

        return $total ?: 0;
    }

    public function getRangeMagicNumber(array $time, \models\Status $status)
    {
        $statusID = $status->getStatusId();

        $dql = "SELECT SUM(p.price)
                FROM \models\Proposals p, \models\Clients c, \models\Accounts a
                WHERE  p.client = c.clientId
                AND c.account = a.accountId
                AND a.branch = :branch
                AND p.proposalStatus = :statusId
                AND p.duplicateOf IS NULL
                AND p.statusChangeDate >= :startTime
                AND p.statusChangeDate <= :finishTime";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('branch', $this->getBranchId());
        $query->setParameter('statusId', $statusID);
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);

        $total = $query->getSingleScalarResult();

        return $total ?: 0;
    }

    public function getRolloverValue($startTime)
    {
        $branchCompany = $this->doctrine->em->findCompany($this->getCompany());
        $openStatus = $branchCompany->getOpenStatus();

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p, \models\Clients c, \models\Accounts a
                WHERE p.client = c.clientId
                AND p.duplicateOf IS NULL
                AND c.account = a.accountId
                AND a.branch = :branch
                AND p.created < :startTime
                AND p.proposalStatus = :statusId";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('branch', $this->getBranchId());
        $query->setParameter('startTime', $startTime);
        $query->setParameter('statusId', $openStatus->getStatusId());

        $total = $query->getSingleScalarResult();

        return $total ?: 0;
    }

    public function getRangeCreatedProposalsStatusPrice(array $time, $statusId){
        $CI = &get_instance();

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p, \models\Clients c, \models\Accounts a
                WHERE p.client = c.clientId
                AND p.duplicateOf IS NULL
                AND c.account = a.accountId
                AND a.branch = :branch
                AND p.created >= :startTime
                AND p.created <= :finishTime
                AND p.proposalStatus = :statusId
                AND p.statusChangeDate >= :startTime
                AND p.statusChangeDate < :finishTime";

        $query = $CI->em->createQuery($dql);

        $query->setParameter('branch', $this->getBranchId());
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);
        $query->setParameter('statusId', $statusId);

        $total = $query->getSingleScalarResult();

        return ($total) ?: 0;
    }

    public function getRangeCreatedProposalsWonStatusPrice(array $time){
        $CI = &get_instance();

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p, \models\Clients c, \models\Accounts a, \models\Status s
                WHERE p.client = c.clientId
                AND p.duplicateOf IS NULL
                AND c.account = a.accountId
                AND a.branch = :branch
                AND p.created >= :startTime
                AND p.created <= :finishTime
                AND p.proposalStatus = s.id
                AND p.statusChangeDate >= :startTime
                AND p.statusChangeDate < :finishTime
                AND s.sales = 1";

        $query = $CI->em->createQuery($dql);

        $query->setParameter('branch', $this->getBranchId());
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);

        $total = $query->getSingleScalarResult();

        return ($total) ?: 0;
    }

    public static function getRangeCreatedProposalsStatusPriceMain(array $time, $companyId, $statusId){
        $CI = &get_instance();

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p, \models\Clients c, \models\Accounts a
                WHERE p.client = c.clientId
                AND p.duplicateOf IS NULL
                AND c.account = a.accountId
                AND a.company = :companyId
                AND a.branch = 0
                AND p.created >= :startTime
                AND p.created <= :finishTime
                AND p.proposalStatus = :statusId
                AND p.statusChangeDate >= :startTime
                AND p.statusChangeDate < :finishTime";

        $query = $CI->em->createQuery($dql);

        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);
        $query->setParameter('companyId', $companyId);
        $query->setParameter('statusId', $statusId);

        $total = $query->getSingleScalarResult();

        return ($total) ?: 0;
    }

    public static function getRangeCreatedProposalsMain(array $time, $companyId, $count = false)
    {
        $CI = &get_instance();

        $dql = "SELECT p FROM \models\Proposals p, \models\Clients c, \models\Accounts a
                WHERE p.client = c.clientId
                AND c.account = a.accountId
                AND a.company = :companyId
                AND a.branch = 0
                AND p.created >= :startTime
                AND p.statusChangeDate >= :statusChangeStart
                AND p.created <= :finishTime
                AND p.statusChangeDate < :statusChangeFinish";

        $query = $CI->em->createQuery($dql);
        $query->setParameter('companyId', $companyId);
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('statusChangeStart', $time['start']);
        $query->setParameter('finishTime', $time['finish']);
        $query->setParameter('statusChangeFinish', $time['finish']);

        $proposals = $query->getResult();

        if($count){
            return count($proposals);
        }

        return $proposals;
    }

    public static function getRangeCreatedProposalsPriceMain(array $time, $companyId)
    {
        $CI = &get_instance();

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p, \models\Clients c, \models\Accounts a
                WHERE p.client = c.clientId
                AND p.duplicateOf IS NULL
                AND c.account = a.accountId
                AND a.company = :companyId
                AND a.branch = 0
                AND p.created >= :startTime
                AND p.statusChangeDate >= :startTime
                AND p.created <= :finishTime
                AND p.statusChangeDate <= :finishTime";

        $query = $CI->em->createQuery($dql);

        $query->setParameter('companyId', $companyId);
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);

        $total = $query->getSingleScalarResult();

        return $total ?: 0;
    }

    public static function getRangeWonMagicNumberMain(array $time, $companyId)
    {
        $CI = &get_instance();

        

        $dql = "SELECT SUM(p.price)
                FROM \models\Proposals p, \models\Clients c, \models\Accounts a, \models\Status s
                WHERE  p.client = c.clientId
                AND c.account = a.accountId
                AND a.company = :companyId
                AND a.branch = 0
                AND p.proposalStatus = s.id
                AND p.created >= :startTime
                AND p.statusChangeDate >= :startTime
                AND p.created <= :finishTime
                AND p.statusChangeDate <= :finishTime
                AND s.sales = 1
                AND p.duplicateOf IS NULL";

        $query = $CI->em->createQuery($dql);
        $query->setParameter('companyId', $companyId);
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);

        $total = $query->getSingleScalarResult();

        return $total ?: 0;
    }

    public static function getRangeMagicNumberMain(array $time, $companyId, \models\Status $status)
    {
        $CI = &get_instance();

        $statusID = $status->getStatusId();

        $dql = "SELECT SUM(p.price)
                FROM \models\Proposals p, \models\Clients c, \models\Accounts a
                WHERE  p.client = c.clientId
                AND c.account = a.accountId
                AND a.company = :companyId
                AND a.branch = 0
                AND p.proposalStatus = :statusId
                AND p.duplicateOf IS NULL
                AND p.statusChangeDate >= :startTime
                AND p.statusChangeDate <= :finishTime";

        $query = $CI->em->createQuery($dql);
        $query->setParameter('companyId', $companyId);
        $query->setParameter('statusId', $statusID);
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);

        $total = $query->getSingleScalarResult();

        return $total ?: 0;
    }

    public static function getRolloverValueMain($startTime, $companyId)
    {
        $CI = &get_instance();

        $branchCompany = $CI->em->findCompany($companyId);
        $openStatus = $branchCompany->getOpenStatus();

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p, \models\Clients c, \models\Accounts a
                WHERE p.client = c.clientId
                AND p.duplicateOf IS NULL
                AND c.account = a.accountId
                AND a.company = :companyId
                AND a.branch = 0
                AND p.created < :startTime
                AND p.proposalStatus = :statusId";

        $query = $CI->em->createQuery($dql);
        $query->setParameter('companyId', $companyId);
        $query->setParameter('startTime', $startTime);
        $query->setParameter('statusId', $openStatus->getStatusId());

        $total = $query->getSingleScalarResult();

        return $total ?: 0;
    }

}
