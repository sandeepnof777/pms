<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="estimation_phases")
 */
class EstimationPhase extends \MY_Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $proposal_service_id;
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $proposal_id;
    /**
     * @ORM\Column(type="string")
     */
    private $name;
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $ord = 999;
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $complete = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $material = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $equipment = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $labor = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $trucking = 0;

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
    public function getOrd()
    {
        return $this->ord;
    }

    /**
     * @param mixed $ord
     */
    public function setOrd($ord)
    {
        $this->ord = $ord;
    }

    /**
     * @return mixed
     */
    public function getComplete()
    {
        return $this->complete;
    }

    /**
     * @param mixed $complete
     */
    public function setComplete($complete)
    {
        $this->complete = $complete;
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
    public function getTrucking()
    {
        return $this->trucking;
    }

    /**
     * @param mixed $trucking
     */
    public function setTrucking($trucking)
    {
        $this->trucking = $trucking;
    }
    /**
     * @return \models\Proposal_services
     */
    public function getProposalService()
    {
        $proposalService = $this->doctrine->em->findProposalService($this->getProposalServiceId());

        return $proposalService;
    }
}