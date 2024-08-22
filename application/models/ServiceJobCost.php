<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="service_job_cost")
 */
class ServiceJobCost extends \MY_Model
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
    private $proposal_service_id;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $estimated_cost = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $actual_cost = 0.00;
    
    /**
     * @ORM\Column(type="string")
     */
    private $name;
    /**
     * @ORM\Column(type="string")
     */
    private $notes;
    /**
     * @ORM\Column(type="integer")
     */
    private $status_id;
    
    /**
     * @ORM\Column(type="string")
     */
    private $updated_at;
    /**
     * @ORM\Column(type="integer")
     */
    private $proposal_id;

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
     * @return mixed
     */
    public function getProposalServiceId()
    {
        return $this->proposal_service_id;
    }

    /**
     * @param mixed $proposal_service_id
     */
    public function setProposalServiceId($proposal_service_id)
    {
        $this->proposal_service_id = $proposal_service_id;
    }

    /**
     * @return mixed
     */
    public function getEstimatedCost()
    {
        return $this->estimated_cost;
    }

    /**
     * @param mixed $estimated_cost
     */
    public function setEstimatedCost($estimated_cost)
    {
        $this->estimated_cost = $estimated_cost;
    }

    /**
     * @return mixed
     */
    public function getActualCost()
    {
        return $this->actual_cost;
    }

    /**
     * @param mixed $actual_cost
     */
    public function setActualCost($actual_cost)
    {
        $this->actual_cost = $actual_cost;
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
    public function getNotes()
    {
        return $this->notes;
    }

    /**
     * @param mixed $notes
     */
    public function setNotes($notes)
    {
        $this->notes = $notes;
    }
    /**
     * @return mixed
     */
    public function getStatusId()
    {
        return $this->status_id;
    }

    /**
     * @param mixed $status_id
     */
    public function setStatusId($status_id)
    {
        $this->status_id = $status_id;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $status_id
     */
    public function SetUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
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
}