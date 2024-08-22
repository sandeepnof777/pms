<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="business_types")
 */
class BusinessType
{
    const OFFICE = 134;
    const SHOPPING_CENTER = 48;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $type_name;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $company_id;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $deleted=0;
    /**
     * @ORM\Column(type="integer")
     */
    private $ord = 999;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTypeName()
    {
        return $this->type_name;
    }

    /**
     * @param mixed $type_name
     */
    public function setTypeName($type_name)
    {
        $this->type_name = $type_name;
    }

    /**
     * @return mixed
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * @param mixed $company_id
     */
    public function setCompanyId($company_id)
    {
        $this->company_id = $company_id;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return int
     */
    public function getOrd()
    {
        return $this->ord;
    }

    /**
     * @param int $ord
     */
    public function setOrd($ord)
    {
        $this->ord = $ord;
    }

    
    /**
     * Check if a status is unique for the specified account (defaults to NULL - the default texts)
     *
     * @param $text
     * @param Accounts $account
     * @return bool
     */
    public static function isUnique($text, Accounts $account = null)
    {
        $CI = &get_instance();
        $sql = "SELECT COUNT(bt.id) as count_id FROM business_types bt
        LEFT JOIN business_type_deleted btd ON bt.id = btd.business_type_id
        WHERE bt.type_name = '$text'";
        if ($account) {
            $sql .= " AND btd.id IS NULL AND (bt.company_id = " . $account->getCompany()->getCompanyId() . " OR bt.company_id IS NULL)";
        } else {
            $sql .= " AND btd.id IS NULL AND bt.company IS NULL";
        }
        $count = $CI->db->query($sql)->result();

        if($count){
            if ($count[0]->count_id > 0) {
                return false;
            }
        }
        return true;
    }

    public function getRangeCreatedProposalsBusinessType(array $time,$userId,$id)
    {
        //echo $this->getId();die;
        $CI = &get_instance();

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p

                WHERE p.duplicateOf IS NULL
               
                AND p.created >= :startTime
                AND p.business_type_id = :typeId
                AND p.statusChangeDate >= :startTime
                AND p.created <= :finishTime
                AND p.statusChangeDate < :finishTime";


            $dql .= ' AND p.owner = :userId' ;
       
        $query = $CI->em->createQuery($dql);

        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);
        $query->setParameter('typeId', $id);
        $query->setParameter('userId', $userId);

        $total = $query->getSingleScalarResult();

        return $total;
    }

    public function getRangeCreatedProposalsAccountBusinessType(array $time,$accountId,$id)
    {
        $CI = &get_instance();

        $sql = "SELECT SUM(p.price) as p_total FROM proposals p
                LEFT JOIN clients c ON p.client = c.clientId

                WHERE p.duplicateOf IS NULL
                AND c.client_account =".$accountId."
                AND p.business_type_id = ".$id;

        if($time['start'] !=''){
            $sql .= " AND p.created >= ".$time['start']."
                    AND p.statusChangeDate >= ".$time['start']."
                    AND p.created <= ".$time['finish']."
                    AND p.statusChangeDate < ".$time['finish'];
        }

        $data = $CI->db->query($sql)->result();
        if($data[0]->p_total >0){
            return $data[0]->p_total;
        }else{
            return 0;
        }
       
    }

    public function getRangeCreatedProposalsBusinessTypeDashboard(array $time,$users,$id)
    {
        $CI = &get_instance();

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p

                WHERE p.duplicateOf IS NULL
                AND p.business_type_id = :typeId
                AND p.created >= :startTime
               
                AND p.statusChangeDate >= :startTime
                AND p.created <= :finishTime
                AND p.statusChangeDate < :finishTime";


            $dql .= ' AND p.owner  IN(' . $users.')' ;
       
            $query = $CI->em->createQuery($dql);
        
            $query->setParameter('startTime', $time['start']);
            $query->setParameter('finishTime', $time['finish']);
            $query->setParameter('typeId', $id);
       

        $total = $query->getSingleScalarResult();

        return $total;
    }


    public function getRangeCreatedProposalsSalesBusinessType(array $time,$userId,$id)
    {
        //echo $this->getId();die;
        $CI = &get_instance();

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p,  \models\Status s 

                WHERE  p.proposalStatus = s.id
                AND p.duplicateOf IS NULL
               
                AND p.created >= :startTime
                AND p.business_type_id = :typeId
                AND p.statusChangeDate >= :startTime
                AND p.created <= :finishTime
                AND p.statusChangeDate < :finishTime
                AND s.sales = 1";


            $dql .= ' AND p.owner = :userId' ;
       
        $query = $CI->em->createQuery($dql);

        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);
        $query->setParameter('typeId', $id);
        $query->setParameter('userId', $userId);

        $total = $query->getSingleScalarResult();

        return $total;
    }

    public function getRangeCreatedProposalsSalesAccountBusinessType(array $time,$accountId,$id)
    {
        $CI = &get_instance();

        $sql = "SELECT SUM(p.price) as p_total FROM proposals p
                LEFT JOIN clients c ON p.client = c.clientId
                LEFT JOIN statuses s ON p.proposalStatus = s.id
                WHERE p.duplicateOf IS NULL
                AND s.sales = 1
                
                AND p.business_type_id = ".$id."
                
                AND c.client_account =".$accountId;

        if($time['start'] !=''){
            $sql .= " AND p.created >= ".$time['start']."
                    AND p.statusChangeDate >= ".$time['start']."
                    AND p.created <= ".$time['finish']."
                    AND p.statusChangeDate < ".$time['finish'];
        }

        $data = $CI->db->query($sql)->result();
        if($data[0]->p_total >0){
            return $data[0]->p_total;
        }else{
            return 0;
        }
    }
    

}