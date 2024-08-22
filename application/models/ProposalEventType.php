<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="proposal_events_types")
 */
class ProposalEventType extends \MY_Model
{
    const CREATE_PROPOSAL = 1;
    const SEND_INDIVIDUAL = 2;
    const SEND_CAMPAIGN = 3;
    const PROPOSAL_VIEW = 4;
    const STATUS_CHANGE = 5;
    const LEAD_CREATED = 6;
    const LEAD_CONVERT = 7;
    const DATE_CHANGE = 8;

    const ESTIMATION_START = 9;
    const ESTIMATION_COMPLETED = 10;
    const JOB_COSTING_START = 11;
    const JOB_COSTING_COMPLETED = 12;
    const PROPOSAL_SOLD = 13;
    const PROPOSAL_DUPLICATE_FROM = 14;
    const PROPOSAL_DUPLICATE_TO = 15;
    const CLIENT_SEND_INDIVIDUAL = 16;
    const LEAD_SEND_INDIVIDUAL = 17;
    const PROSPECT_SEND_INDIVIDUAL = 18;
    const PROPOSAL_SEND_INDIVIDUAL = 19;
    const PROPOSAL_EMAIL_EXCLUDED = 20;
    const PROPOSAL_EMAIL_INCLUDED = 21;
    
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
     * @ORM\Column(type="integer")
     */
    private $ord;
    /**
     * @ORM\Column(type="integer")
     */
    
    private $category_id;
    
   
    
    
    function __construct()
    {
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
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * @param mixed $category_id
     */
    public function setCategoryId($category_id)
    {
        $this->category_id = $category_id;
    }

    

}