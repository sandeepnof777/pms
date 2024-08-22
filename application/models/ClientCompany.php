<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="client_companies")
 */
class ClientCompany extends \MY_Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="Accounts", cascade={"persist"}, inversedBy="client_companies")
     * @ORM\JoinColumn (name="owner_user", referencedColumnName="accountId")
     */
    private $owner_user;
    /**
     * @ORM\ManyToOne(targetEntity="Companies", cascade={"persist"}, inversedBy="client_companies")
     * @ORM\JoinColumn (name="owner_company", referencedColumnName="companyId")
     */
    private $owner_company;
    /**
     * @ORM\OneToMany(targetEntity="Clients", mappedBy="client_account", cascade={"persist"})
     */
    private $contacts;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;
    /**
     * @ORM\Column (type="string", length=255)
     */
    private $address;
    /**
     * @ORM\Column (type="string", length=255)
     */
    private $address2;
    /**
     * @ORM\Column (type="string", length=255)
     */
    private $city;
    /**
     * @ORM\Column (type="string", length=255)
     */
    private $state;
    /**
     * @ORM\Column (type="string", length=12)
     */
    private $zip;
    /**
     * @ORM\Column (type="string", length=255)
     */
    private $email;
    /**
     * @ORM\Column (type="string", length=255)
     */
    private $phone;
    /**
     * @ORM\Column (type="string", length=255)
     */
    private $website;
    /**
     * @ORM\Column (type="integer")
     */
    private $created;

    function __construct()
    {
        $this->load->library('doctrine');
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return \models\Companies
     */
    public function getOwnerCompany()
    {
        return $this->owner_company;
    }

    /**
     * @param \models\Companies $owner_company
     */
    public function setOwnerCompany($owner_company)
    {
        $this->owner_company = $owner_company;
    }

    /**
     * @return mixed
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    /**
     * @return \models\Accounts
     */
    public function getOwnerUser()
    {
        return $this->owner_user;
    }

    /**
     * @param \models\Accounts $owner_user
     */
    public function setOwnerUser($owner_user)
    {
        $this->owner_user = $owner_user;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getAddress2()
    {
        return $this->address2;
    }

    /**
     * @param mixed $address2
     */
    public function setAddress2($address2)
    {
        $this->address2 = $address2;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param mixed $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * @param mixed $website
     */
    public function setWebsite($website)
    {
        $this->website = $website;
    }

    /**
     * @return mixed
     */
    public function getCreated()
    {
        return $this->created;
    }

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getNumClients()
    {
        return count($this->getContacts());
    }


    public function getNumProposals()
    {
        $query = $this->doctrine->em->createQuery("
            SELECT COUNT(p) FROM models\Proposals p, models\Clients c
            WHERE p.client = c.clientId
            AND c.client_account = :clientAccountId
        ");
        $query->setParameter(':clientAccountId', $this->getId());
        $count = $query->getSingleScalarResult();

        return $count;
    }

    public function getTotalBid()
    {
        $query = $this->doctrine->em->createQuery("
            SELECT SUM(p.price) FROM models\Proposals p, models\Clients c
            WHERE p.client = c.clientId
            AND c.client_account = :clientAccountId
        ");
        $query->setParameter(':clientAccountId', $this->getId());
        $count = $query->getSingleScalarResult();

        return $count;
    }

    public function getRangeCreatedProposals(array $time, $count = false, $excludeDuplicates=false)
    {

        $dql = "SELECT p FROM \models\Proposals p, \models\Clients c
                WHERE p.client = c.clientId
                AND c.client_account = :accountId
                AND p.created >= :startTime
                AND p.statusChangeDate >= :statusChangeStart
                AND p.created <= :finishTime
                AND p.statusChangeDate < :statusChangeFinish";

        if ($excludeDuplicates) {
            $dql .= " AND p.duplicateOf IS NULL";
        }
        if ($this->session->userdata('accFilter')) {
            if ($this->session->userdata('accFilterAUser')) {
                $aUsers = implode(',', $this->session->userdata('accFilterAUser'));
                $dql .= ' AND p.owner IN (' . $aUsers . ')';
            }
        }

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('accountId', $this->getId());
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('statusChangeStart', $time['start']);
        $query->setParameter('finishTime', $time['finish']);
        $query->setParameter('statusChangeFinish', $time['finish']);

        $proposals = $query->getResult();

        if ($count) {
            return count($proposals);
        }

        return $proposals;
    }

    public function getRangeCreatedProposalsPrice(array $time)
    {
        $dql = "SELECT SUM(p.price) FROM \models\Proposals p, \models\Clients c
                WHERE p.client = c.clientId
                AND c.client_account = :accountId
                AND p.duplicateOf IS NULL
                AND p.created >= :startTime
                AND p.statusChangeDate >= :startTime
                AND p.created <= :finishTime
                AND p.statusChangeDate < :finishTime";

        if ($this->session->userdata('accFilter')) {
            if ($this->session->userdata('accFilterAUser')) {
                $aUsers = implode(',', $this->session->userdata('accFilterAUser'));
                $dql .= ' AND p.owner IN (' . $aUsers . ')';
            }
        }
        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('accountId', $this->getId());
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);

        $total = $query->getSingleScalarResult();

        return $total ?: 0;
    }

    public function getRangeMagicNumber(array $time, \models\Status $status)
    {
        $statusId = $status->getStatusId();

        $dql = "SELECT SUM(p.price)
                FROM \models\Proposals p, \models\Clients c
                WHERE p.client = c.clientId
                AND c.client_account = :accountId
                AND p.proposalStatus = :statusId
                AND p.duplicateOf IS NULL
                AND p.statusChangeDate >= :startTime
                AND p.statusChangeDate <= :finishTime";
        if($this->session->userdata('accFilter')) {
            if ($this->session->userdata('accFilterAUser')) {
                $aUsers = implode(',', $this->session->userdata('accFilterAUser'));
                $dql .= ' AND p.owner IN (' . $aUsers . ')';
            }
        }
        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter('accountId', $this->getId());
        $query->setParameter('statusId', $statusId);
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);

        $total = $query->getSingleScalarResult();

        return $total ?: 0;
    }

    public function getRangeCreatedProposalsStatusPrice(array $time, $statusId,$userId = false)
    {
        $CI = &get_instance();

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p, \models\Clients c
                WHERE p.client = c.clientId
                AND p.duplicateOf IS NULL
                AND c.client_account = :clientAccountId
                AND p.created >= :startTime
                AND p.proposalStatus = :statusId
                AND p.statusChangeDate >= :startTime
                AND p.created <= :finishTime
                AND p.statusChangeDate < :finishTime";

        if($userId){
            $dql .= ' AND p.owner IN (' . $userId . ')';
        }else{
            if($this->session->userdata('accFilter')) {
                if ($this->session->userdata('accFilterAUser')) {
                    $aUsers = implode(',', $this->session->userdata('accFilterAUser'));
                    $dql .= ' AND p.owner IN (' . $aUsers . ')';
                }
            }
        }
        $query = $CI->em->createQuery($dql);

        $query->setParameter('clientAccountId', $this->getId());
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);
        $query->setParameter('statusId', $statusId);

        $total = $query->getSingleScalarResult();

        return $total;
    }


    public function getRangeCreatedProposalsStatusCountPrice(array $time, $statusId,$userId = false)
    {
        
        $CI = &get_instance();
        // $q = "SELECT s.id, s.text, s.company, s.sales, s.prospect, s.on_hold
        //       FROM statuses s
        //       LEFT JOIN company_status_config csc ON s.id = csc.status_id AND csc.company_id = :companyId
        //       WHERE (
        //         s.company IS NULL
        //         OR s.company = :companyId
        //       )
        //       AND (
        //         csc.visible IS NULL 
        //         OR csc.visible = 1
        //       )
        //       AND s.visible = 1
        //       ORDER BY COALESCE(csc.ord, 999)";

        $dql = "SELECT SUM(p.price) as p_total ,COUNT(p.proposalId) as p_count,st.text,st.sales,st.id
                FROM \models\Status st, \models\Proposals p, \models\Clients c
                WHERE p.client = c.clientId 
                AND p.proposalStatus = st.id
                AND p.duplicateOf IS NULL
               
                AND c.client_account = :clientAccountId
                AND p.created >= :startTime
                AND p.owner = :userId
                AND p.statusChangeDate >= :startTime
                AND p.created <= :finishTime
                AND p.statusChangeDate < :finishTime";
                
        // if($userId){
        //     $dql .= ' AND p.owner =' . $userId ;
        // }else{
        //     if($this->session->userdata('accFilter')) {
        //         if ($this->session->userdata('accFilterAUser')) {
        //             $aUsers = implode(',', $this->session->userdata('accFilterAUser'));
        //             $dql .= ' AND p.owner IN (' . $aUsers . ')';
        //         }
        //     }
        // }
        
        $sortCol = $CI->input->get('order')[0]['column'];
        $sortDir = $CI->input->get('order')[0]['dir'];
        
       
        $dql .= ' GROUP BY st.id ';
        switch ($sortCol) {
            case 0: // user name
                $dql .= ' ORDER BY st.text ' . $sortDir;
                break;
            case 1: // user name
                $dql .= ' ORDER BY p_count ' . $sortDir;
                break;
            case 2: // Company Name
                $dql .= ' ORDER BY p_total ' . $sortDir;
                break;
           
           
         }
         
        //echo $dql;die;
        $query = $CI->em->createQuery($dql);

      
        $query->setParameter('clientAccountId', $this->getId());
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);
        $query->setParameter('userId', $userId);

        $total = $query->getResult();
        return $total;
    }

    public function timeRangeCreatedProposalsPrice(array $time, $statusId)
    {
        $CI = &get_instance();

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p, \models\Clients c
                WHERE p.client = c.clientId
                AND p.duplicateOf IS NULL
                AND c.client_account = :clientAccountId
                AND p.created >= :startTime
                AND p.created <= :finishTime
                AND p.proposalStatus = :statusId
                AND p.statusChangeDate >= :startTime";

        $query = $CI->em->createQuery($dql);

        $query->setParameter('clientAccountId', $this->getId());
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);
        $query->setParameter('statusId', $statusId);

        $total = $query->getSingleScalarResult();

        return $total;
    }

    public function accountProposalsUserIds()
    {
        $CI = &get_instance();

        $dql = "SELECT IDENTITY(p.owner),count(p.proposalId) FROM \models\Proposals p, \models\Clients c
        WHERE p.client = c.clientId
        AND p.duplicateOf IS NULL
                AND c.client_account = :clientAccountId";
                
        if($this->session->userdata('accFilter')) {
            if ($this->session->userdata('accFilterAUser')) {
                $aUsers = implode(',', $this->session->userdata('accFilterAUser'));
                $dql .= ' AND p.owner IN (' . $aUsers . ')';
            }
        }     
                
        $dql .= ' GROUP BY p.owner';

       
        $query = $CI->em->createQuery($dql);

        $query->setParameter('clientAccountId', $this->getId());

        $total = $query->getResult();
        $out = [];
        $i =0;
        foreach($total as $userData){
            $out[$i]['user_id'] = $userData[1];
            $out[$i]['proposal_count'] = $userData[2];
            $i++;
        }
        return $out;
    }

    public function getProposalsUserPrice($userId)
    {
        $CI = &get_instance();

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p, \models\Clients c
                WHERE p.client = c.clientId
                AND p.duplicateOf IS NULL
                AND c.client_account = :clientAccountId
                AND p.owner = :userId";
        
        $query = $CI->em->createQuery($dql);

        $query->setParameter('clientAccountId', $this->getId());
        $query->setParameter('userId', $userId);

        $total = $query->getSingleScalarResult();

        return $total;
    }

    // public function getSalesValue(array $time)
    // {
    //     $CI = &get_instance();

    //     $sql = "SELECT SUM(p2.price) AS totalVal 
    //             FROM \models\Proposals p2,\models\Status st2
    //             WHERE p2.owner = p.owner
    //             AND p2.proposalStatus = st2.id
    //             AND p2.duplicateOf IS NULL
    //             AND p2.win_date >= :startTime
    //             AND p2.win_date <= :finishTime
    //             AND st2.sales = 1";

    //     // Raw PDO
    //     $query = $CI->em->getConnection()->prepare($sql);
    //     $query->bindValue('accountId', $this->getAccountId());
    //     $query->bindValue('startTimeChange', $time['start']);
    //     $query->bindValue('finishTimeChange', $time['finish']);
    //     $query->execute();

    //     $result = $query->fetch();

    //     return (float)$result['totalVal'] ?: 0;
    // }

    public function accountProposalsUserStats($time)
    {
        $CI = &get_instance();
        // echo $time['start'];
        // echo '</br>';
        // echo $time['finish'];
        // echo '</br>';
        $bidSoldAmtSubQuery = " (SELECT SUM(CASE WHEN (st.sales = '1') THEN p2.price ELSE 0 END) as total_sold_amount2 FROM proposals p2, clients c, statuses st  
           
        WHERE p2.client = c.clientId AND p.proposalStatus = st.id AND  p2.duplicateOf IS NULL";
        $bidSoldAmtSubQuery = "(SELECT SUM(p2.price) AS totalVal 
        FROM \models\Proposals p2,\models\Status st2,\models\Clients c2
        WHERE p2.owner = p.owner
        AND p2.client = c2.clientId
        AND c2.client_account = c.client_account
        AND p2.proposalStatus = st2.id
        AND p2.duplicateOf IS NULL
        AND p2.win_date >= :startTime
        AND p2.win_date <= :finishTime
        AND st2.sales = 1) AS totalSold";
    // Date filter applies to bid subquery

     // die;
           // $bidSoldAmtSubQuery .= " AND (p2.win_date >= " . $time['start'] . " AND p2.win_date <= " . $time['finish'] . ")";
        

        // Show all accounts
        //$bidSoldAmtSubQuery .= ' AND p2.owner = p.owner';
        

    //$bidSoldAmtSubQuery .= " AND p2.owner = p.owner) AS totalSold";

        $dql = "SELECT IDENTITY(p.owner) as user_id,count(p.proposalId) as proposal_count,SUM(p.price) as total_amount,
        SUM(CASE WHEN (st.sales = '1') THEN p.price ELSE 0 END) as total_sold_amount,
        SUM(CASE WHEN (st.sales = '1') THEN p.price ELSE 0 END) * 100 / SUM(p.price)  AS percent_total,
        a.firstName,a.lastName,$bidSoldAmtSubQuery
        FROM \models\Proposals p, \models\Clients c,\models\Accounts a, \models\Status st
        
        WHERE p.client = c.clientId AND p.proposalStatus = st.id AND p.owner = a.accountId
        AND p.duplicateOf IS NULL
                AND c.client_account = :clientAccountId
                AND p.created >= :startTime
                AND p.created <= :finishTime";
        if($this->session->userdata('accFilter')) {
            if ($this->session->userdata('accFilterAUser')) {
                $aUsers = implode(',', $this->session->userdata('accFilterAUser'));
                $dql .= ' AND p.owner IN (' . $aUsers . ')';
            }

            
        } 
        $dql .= ' GROUP BY p.owner';
        if($this->input->get('order')){
            $sortCol = $this->input->get('order')[0]['column'];
            $sortDir = $this->input->get('order')[0]['dir'];
            
           

            switch ($sortCol) {
                case 1: // date
                    $dql .= ' ORDER BY proposal_count ' . $sortDir;
                    break;
                case 2: // user name
                    $dql .= ' ORDER BY total_amount ' . $sortDir;
                    break;
                case 3: // Company Name
                    $dql .= ' ORDER BY total_sold_amount ' . $sortDir;
                    break;
                case 4: // Project Name
                    $dql .= ' ORDER BY percent_total ' . $sortDir;
                    break;
            
            }
        }else{
           
            $sortDir = 'asc';
            $dql .= ' ORDER BY percent_total ' . $sortDir;
        }

        

        //echo $dql;die;
        $query = $CI->em->createQuery($dql);

        $query->setParameter('clientAccountId', $this->getId());
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);
        $total = $query->getResult();
        return $total;
        $out = [];
        $i =0;
        foreach($total as $userData){
            $out[$i]['user_id'] = $userData[1];
            $out[$i]['proposal_count'] = $userData[2];
            $i++;
        }
        return $out;
    }

    public function getProposalsYearStats(array $time, $statusId,$userId = false)
    {
        $CI = &get_instance();

        $dql = "SELECT SUM(p.price) as total_amount,
        SUM(CASE WHEN (st.sales = '1') THEN p.price ELSE 0 END) as total_sold_amount 
        FROM \models\Proposals p, \models\Clients c,\models\Accounts a, \models\Status st
        
        WHERE p.client = c.clientId AND p.proposalStatus = st.id AND p.owner = a.accountId
        AND p.duplicateOf IS NULL
        
        AND c.client_account = :clientAccountId
        AND p.created >= :startTime
        AND p.created <= :finishTime";
                
       
        if ($userId) {
                 
                 $dql .= ' AND p.owner ='.$userId;
                 //echo $dql;die;
        }
       
        //echo $dql;die;
        $query = $CI->em->createQuery($dql);

        $query->setParameter('clientAccountId', $this->getId());
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);

        $total = $query->getResult();
        return $total[0];
       
    }



    public function getRangeCreatedProposalsStatusStats(array $time)
    {
        
        $CI = &get_instance();
       
        $dql = "SELECT SUM(p.price) as p_total ,COUNT(p.proposalId) as p_count,st.text,st.sales,st.id
                FROM \models\Status st, \models\Proposals p, \models\Clients c
                WHERE p.client = c.clientId 
                AND p.proposalStatus = st.id
                
               
                AND c.client_account = :clientAccountId
                AND p.created >= :startTime
                AND p.statusChangeDate >= :startTime
                AND p.created <= :finishTime
                AND p.statusChangeDate < :finishTime";
                
        // if($userId){
        //     $dql .= ' AND p.owner =' . $userId ;
        // }else{
             if($this->session->userdata('accFilter')) {
                 if ($this->session->userdata('accFilterAUser')) {
                    $aUsers = implode(',', $this->session->userdata('accFilterAUser'));
                     $dql .= ' AND p.owner IN (' . $aUsers . ')';
                 }
             }
        // }
        
       
       
        $dql .= ' GROUP BY st.id ORDER BY st.id ASC';
        
         
        //echo $dql;die;
        $query = $CI->em->createQuery($dql);

      
        $query->setParameter('clientAccountId', $this->getId());
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);
        //$query->setParameter('userId', $userId);

        $total = $query->getResult();
        return $total;
    }
}
