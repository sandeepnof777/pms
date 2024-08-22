<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="proposal_events")
 */
class ProposalEvent extends \MY_Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    
    private $type_id;
     /**
     * @ORM\Column(type="integer")
     */
    
    private $account_id;
     /**
     * @ORM\Column(type="integer")
     */
    
    private $proposal_id;
    /**
     * @ORM\Column(type="string")
     */
    private $user_name;
    /**
     * @ORM\Column(type="string")
     */
    private $event_text;
    /**
     * @ORM\Column(type="string")
     */
    private $created_at;
    /**
     * @ORM\Column(type="string")
     */
    private $ip_address;
    /**
     * @ORM\Column(type="integer")
     */
    
    private $client_id;
    /**
     * @ORM\Column(type="integer")
     */
    
    private $lead_id;
    /**
     * @ORM\Column(type="integer")
     */
    
    private $prospect_id;
    /**
     * @ORM\Column(type="string")
     */
    private $delivered_at;
    /**
     * @ORM\Column(type="string")
     */
    private $bounced_at;
    /**
     * @ORM\Column(type="string")
     */
    private $opened_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $event_email_type;
    
    
    function __construct()
    {
        $this->setIpAddress($_SERVER['REMOTE_ADDR']);
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
     * @return mixed
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * @param mixed $type_id
     */
    public function setTypeId($type_id)
    {
        $this->type_id = $type_id;
    }

    /**
     * @return mixed
     */
    public function getAccountId()
    {
        return $this->account_id;
    }

    /**
     * @param mixed $account_id
     */
    public function setAccountId($account_id)
    {
        $this->account_id = $account_id;
    }

    /**
     * @return mixed
     */
    public function getProposalId()
    {
        return $this->proposal_id;
    }

    /**
     * @param mixed $proposal_id
     */
    public function setProposalId($proposal_id)
    {
        $this->proposal_id = $proposal_id;
    }

    /**
     * @return mixed
     */
    public function getUserName()
    {
        return $this->user_name;
    }
    

    /**
     * @param mixed $user_name
     */
    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
    }
    /**
     * @return mixed
     */
    public function getEventText()
    {
        return $this->event_text;
    }
    

    /**
     * @param mixed $event_text
     */
    public function setEventText($event_text)
    {
        $this->event_text = $event_text;
    }

     /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }


      /**
     * @return mixed
     */
    public function getIpAddress()
    {
        return $this->ip_address;

    }
    

    /**
     * @param mixed $ip_address
     */
    public function setIpAddress($ip_address)
    {
        $this->ip_address = $ip_address;
    }


    /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @param mixed $client_id
     */
    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
    }

    /**
     * @return mixed
     */
    public function getLeadId()
    {
        return $this->lead_id;
    }

    /**
     * @param mixed $lead_id
     */
    public function setLeadId($lead_id)
    {
        $this->lead_id = $lead_id;
    }

    /**
     * @return mixed
     */
    public function getProspectId()
    {
        return $this->prospect_id;
    }

    /**
     * @param mixed $prospect_id
     */
    public function setProspectId($prospect_id)
    {
        $this->prospect_id = $prospect_id;
    }

     /**
     * @return mixed
     */
    public function getDeliveredAt()
    {
        return $this->delivered_at;
    }
    

    /**
     * @param mixed $delivered_at
     */
    public function setDeliveredAt($delivered_at)
    {
        $this->delivered_at = $delivered_at;
    }

     /**
     * @return mixed
     */
    public function getBouncedAt()
    {
        return $this->bounced_at;
    }
    

    /**
     * @param mixed $bounced_at
     */
    public function setBouncedAt($bounced_at)
    {
        $this->bounced_at = $bounced_at;
    }

    
     /**
     * @return mixed
     */
    public function getOpenedAt()
    {
        return $this->opened_at;
    }
    

    /**
     * @param mixed $opened_at
     */
    public function setOpenedAt($opened_at)
    {
        $this->opened_at = $opened_at;
    }

     /**
     * @return mixed
     */
    public function getEventEmailType()
    {
        return $this->event_email_type;
    }
    

    /**
     * @param mixed $event_email_type
     */
    public function setEventEmailType($event_email_type)
    {
        $this->event_email_type = $event_email_type;
    }
    
}