<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="job_cost_item")
 */
class JobCostItem extends \MY_Model
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
     * @ORM\Column(type="integer")
     */
    private $service_job_cost_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $estimate_line_item_id;
    
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $estimated_qty = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $actual_qty = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $estimated_unit_price = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $actual_unit_price = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $estimated_base_cost = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $actual_base_cost = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $estimated_oh_rate = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $actual_oh_rate = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $estimated_pm_rate = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $actual_pm_rate = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $estimated_tax_rate = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $actual_tax_rate = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $estimated_total_price = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $actual_total_price = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price_difference = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $area = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $depth = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $day = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $num_people = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $hpd = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $estimated_oh_price = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $actual_oh_price = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $estimated_pm_price = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $actual_pm_price = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $estimated_tax_price = 0.00;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $actual_tax_price = 0.00;
    /**
     * @ORM\Column(type="integer")
     */
    private $category_id = 0;
    /**
     * @ORM\Column(type="string")
     */
    private $custom_item_name;
    /**
     * @ORM\Column(type="integer")
     */
    private $proposal_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $is_sub_contractor = 0;
     /**
     * @ORM\Column(type="integer")
     */
    private $disposal_load = 0;

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
    public function getServiceJobCostId()
    {
        return $this->service_job_cost_id;
    }

    /**
     * @param mixed $service_job_cost_id
     */
    public function setServiceJobCostId($service_job_cost_id)
    {
        $this->service_job_cost_id = $service_job_cost_id;
    }

        /**
     * @return mixed
     */
    public function getEstimateLineItemId()
    {
        return $this->estimate_line_item_id;
    }

    /**
     * @param mixed $estimate_line_item_id
     */
    public function setEstimateLineItemId($estimate_line_item_id)
    {
        $this->estimate_line_item_id = $estimate_line_item_id;
    }

    /**
     * @return mixed
     */
    public function getEstimatedQty()
    {
        return $this->estimated_qty;
    }

    /**
     * @param mixed $estimated_qty
     */
    public function setEstimatedQty($estimated_qty)
    {
        $this->estimated_qty = $estimated_qty;
    }

    /**
     * @return mixed
     */
    public function getActualQty()
    {
        return $this->actual_qty;
    }

    /**
     * @param mixed $actual_qty
     */
    public function setActualQty($actual_qty)
    {
        $this->actual_qty = $actual_qty;
    }

    /**
     * @return mixed
     */
    public function getEstimatedUnitPrice()
    {
        return $this->estimated_unit_price;
    }

    /**
     * @param mixed $estimated_unit_price
     */
    public function setEstimatedUnitPrice($estimated_unit_price)
    {
        $this->estimated_unit_price = $estimated_unit_price;
    }
    /**
     * @return mixed
     */
    public function getActualUnitPrice()
    {
        return $this->actual_unit_price;
    }

    /**
     * @param mixed $actual_unit_price
     */
    public function setActualUnitPrice($actual_unit_price)
    {
        $this->actual_unit_price = $actual_unit_price;
    }

    /**
     * @return mixed
     */
    public function getEstimatedBaseCost()
    {
        return $this->estimated_base_cost;
    }

    /**
     * @param mixed $estimated_base_cost
     */
    public function setEstimatedBaseCost($estimated_base_cost)
    {
        $this->estimated_base_cost = $estimated_base_cost;
    }

    /**
     * @return mixed
     */
    public function getActualBaseCost()
    {
        return $this->actual_base_cost;
    }

    /**
     * @param mixed $actual_base_cost
     */
    public function setActualBaseCost($actual_base_cost)
    {
        $this->actual_base_cost = $actual_base_cost;
    }

     /**
     * @return mixed
     */
    public function getEstimatedOhRate()
    {
        return $this->estimated_oh_rate;
    }

    /**
     * @param mixed $estimated_oh_rate
     */
    public function setEstimatedOhRate($estimated_oh_rate)
    {
        $this->estimated_oh_rate = $estimated_oh_rate;
    }

     /**
     * @return mixed
     */
    public function getActualOhRate()
    {
        return $this->actual_oh_rate;
    }

    /**
     * @param mixed $actual_oh_rate
     */
    public function setActualOhRate($actual_oh_rate)
    {
        $this->actual_oh_rate = $actual_oh_rate;
    }

     /**
     * @return mixed
     */
    public function getEstimatedPmRate()
    {
        return $this->estimated_pm_rate;
    }

    /**
     * @param mixed $estimated_pm_rate
     */
    public function setEstimatedPmRate($estimated_pm_rate)
    {
        $this->estimated_pm_rate = $estimated_pm_rate;
    }

     /**
     * @return mixed
     */
    public function getActualPmRate()
    {
        return $this->actual_pm_rate;
    }

    /**
     * @param mixed $actual_pm_rate
     */
    public function setActualPmRate($actual_pm_rate)
    {
        $this->actual_pm_rate = $actual_pm_rate;
    }

     /**
     * @return mixed
     */
    public function getEstimatedTaxRate()
    {
        return $this->estimated_tax_rate;
    }

    /**
     * @param mixed $estimated_tax_rate
     */
    public function setEstimatedTaxRate($estimated_tax_rate)
    {
        $this->estimated_tax_rate = $estimated_tax_rate;
    }

    /**
     * @return mixed
     */
    public function getActualTaxRate()
    {
        return $this->actual_tax_rate;
    }

    /**
     * @param mixed $actual_tax_rate
     */
    public function setActualTaxRate($actual_tax_rate)
    {
        $this->actual_tax_rate = $actual_tax_rate;
    }
    /**
     * @return mixed
     */
    public function getEstimatedTotalPrice()
    {
        return $this->estimated_total_price;
    }

    /**
     * @param mixed $estimated_total_price
     */
    public function setEstimatedTotalPrice($estimated_total_price)
    {
        $this->estimated_total_price = $estimated_total_price;
    }
    /**
     * @return mixed
     */
    public function getActualTotalPrice()
    {
        return $this->actual_total_price;
    }

    /**
     * @param mixed $actual_total_price
     */
    public function setActualTotalPrice($actual_total_price)
    {
        $this->actual_total_price = $actual_total_price;
    }
    /**
     * @return mixed
     */
    public function getPriceDifference()
    {
        return $this->price_difference;
    }

    /**
     * @param mixed $price_difference
     */
    public function setPriceDifference($price_difference)
    {
        $this->price_difference = $price_difference;
    }

    /**
     * @return mixed
     */
    public function getArea()
    {
        return $this->area;
    }

    /**
     * @param mixed $area
     */
    public function setArea($area)
    {
        $this->area = $area;
    }

    /**
     * @return mixed
     */
    public function getDepth()
    {
        return $this->depth;
    }

    /**
     * @param mixed $depth
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
    }

    /**
     * @return mixed
     */
    public function getDay()
    {
        return $this->day;
    }

    /**
     * @param mixed $day
     */
    public function setDay($day)
    {
        $this->day = $day;
    }

    /**
     * @return mixed
     */
    public function getNumPeople()
    {
        return $this->num_people;
    }

    /**
     * @param mixed $num_people
     */
    public function setNumPeople($num_people)
    {
        $this->num_people = $num_people;
    }

     /**
     * @return mixed
     */
    public function getHpd()
    {
        return $this->hpd;
    }

    /**
     * @param mixed $hpd
     */
    public function setHpd($hpd)
    {
        $this->hpd = $hpd;
    }
    
    ///////
    /**
     * @return mixed
     */
    public function getEstimatedOhPrice()
    {
        return $this->estimated_oh_price;
    }

    /**
     * @param mixed $estimated_oh_price
     */
    public function setEstimatedOhPrice($estimated_oh_price)
    {
        $this->estimated_oh_price = $estimated_oh_price;
    }

     /**
     * @return mixed
     */
    public function getActualOhPrice()
    {
        return $this->actual_oh_price;
    }

    /**
     * @param mixed $actual_oh_price
     */
    public function setActualOhPrice($actual_oh_price)
    {
        $this->actual_oh_price = $actual_oh_price;
    }

     /**
     * @return mixed
     */
    public function getEstimatedPmPrice()
    {
        return $this->estimated_pm_price;
    }

    /**
     * @param mixed $estimated_pm_price
     */
    public function setEstimatedPmPrice($estimated_pm_price)
    {
        $this->estimated_pm_price = $estimated_pm_price;
    }

     /**
     * @return mixed
     */
    public function getActualPmPrice()
    {
        return $this->actual_pm_price;
    }

    /**
     * @param mixed $actual_pm_price
     */
    public function setActualPmPrice($actual_pm_price)
    {
        $this->actual_pm_price = $actual_pm_price;
    }

     /**
     * @return mixed
     */
    public function getEstimatedTaxPrice()
    {
        return $this->estimated_tax_price;
    }

    /**
     * @param mixed $estimated_tax_price
     */
    public function setEstimatedTaxPrice($estimated_tax_price)
    {
        $this->estimated_tax_price = $estimated_tax_price;
    }

    /**
     * @return mixed
     */
    public function getActualTaxPrice()
    {
        return $this->actual_tax_price;
    }

    /**
     * @param mixed $actual_tax_price
     */
    public function setActualTaxPrice($actual_tax_price)
    {
        $this->actual_tax_price = $actual_tax_price;
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

    /**
     * @return mixed
     */
    public function getCustomItemName()
    {
        return $this->custom_item_name;
    }

    /**
     * @param mixed $custom_item_name
     */
    public function setCustomItemName($custom_item_name)
    {
        $this->custom_item_name = $custom_item_name;
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
    public function getIsSubContractor()
    {
        return $this->is_sub_contractor;
    }

    /**
     * @param mixed $is_sub_contractor
     */
    public function setIsSubContractor($is_sub_contractor)
    {
        $this->is_sub_contractor = $is_sub_contractor;
    }

    /**
     * @return mixed
     */
    public function getDisposalLoad()
    {
        return $this->disposal_load;
    }

    /**
     * @param mixed $disposal_load
     */
    public function setDisposalLoad($disposal_load)
    {
        $this->disposal_load = $disposal_load;
    }

   
    
}