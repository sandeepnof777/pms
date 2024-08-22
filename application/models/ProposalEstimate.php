<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="proposal_estimates")
 */
class ProposalEstimate extends \MY_Model
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
    
    private $proposal_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $status_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $days = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $material;
    /**
     * @ORM\Column(type="integer")
     */
    private $equipment;
    /**
     * @ORM\Column(type="integer")
     */
    private $labor;
    /**
     * @ORM\Column(type="string")
     */
    private $last_updated;
    /**
     * @ORM\Column(type="string")
     */
    private $created_at;
    /**
     * @ORM\Column(type="string")
     */
    private $completed_at;

    /**
     * @ORM\Column (type="decimal", precision=5, scale=2))
     */
    private $completion_percent;
    
    
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
    public function getDays()
    {
        return $this->days;
    }

    /**
     * @param mixed $days
     */
    public function setDays($days)
    {
        $this->days = $days;
    }

    /**
     * @return mixed
     */
    public function getMaterial()
    {
        return $this->material;
    }
    

    /**
     * @param mixed $material
     */
    public function setMaterial($material)
    {
        $this->material = $material;
    }
    /**
     * @return mixed
     */
    public function getEquipment()
    {
        return $this->equipment;
    }
    

    /**
     * @param mixed $equipment
     */
    public function setEquipment($equipment)
    {
        $this->equipment = $equipment;
    }

    /**
     * @return mixed
     */
    public function getLabor()
    {
        return $this->labor;
    }

    /**
     * @param mixed $labor
     */
    public function setLabor($labor)
    {
        $this->labor = $labor;
    }

    /**
     * @return mixed
     */
    public function getLastUpdated()
    {
        return $this->last_updated;
    }

    /**
     * @param mixed $last_updated
     */
    public function setLastUpdated($last_updated)
    {
        $this->last_updated = $last_updated;
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
    public function getComplatedAt()
    {
        return $this->completed_at;
    }

    /**
     * @param mixed $completed_at
     */
    public function setCompletedAt($completed_at)
    {
        $this->completed_at = $completed_at;
    }

    /**
     * @return mixed
     */
    public function getCompletionPercent()
    {
        return $this->completion_percent;
    }

    /**
     * @param mixed $completion_percent
     */
    public function setCompletionPercent($completion_percent)
    {
        $this->completion_percent = $completion_percent;
    }

}