<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="estimate_calculator_values")
 */
class EstimationCalculatorValue extends \MY_Model
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
    private $item_id;
    /**
     * @ORM\Column(type="string")
     */
    private $saved_values;
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $line_item_id;
    /**
     * @ORM\Column(type="string")
     */
    private $calculator_name;
    
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
    public function getItemId()
    {
        return $this->item_id;
    }

    /**
     * @param mixed $item_id
     */
    public function setItemId($item_id)
    {
        $this->item_id = $item_id;
    }

    /**
     * @return mixed
     */
    public function getSavedValues()
    {
        return $this->saved_values;
    }

    /**
     * @param mixed $values
     */
    public function setSavedValues($values)
    {
        $this->saved_values = $values;
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

    /**
     * @return mixed
     */
    public function getCalculatorName()
    {
        return $this->calculator_name;
    }

    /**
     * @param mixed $calculator_name
     */
    public function setCalculatorName($calculator_name)
    {
        $this->calculator_name = $calculator_name;
    }
    
}