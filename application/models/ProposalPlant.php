<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="proposal_plants")
 */
class ProposalPlant extends \MY_Model
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
    private $plant_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $line_item_id;


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
    public function getPlantId()
    {
        return $this->plant_id;
    }

    /**
     * @param mixed $plant_id
     */
    public function setPlantId($plant_id)
    {
        $this->plant_id = $plant_id;
    }

    /**
     * @return mixed
     */
    public function getLineItemId()
    {
        return $this->line_item_id;
    }

    /**
     * @param mixed $line_item_id
     */
    public function setLineItemId($line_item_id)
    {
        $this->line_item_id = $line_item_id;
    }

}