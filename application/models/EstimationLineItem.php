<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="estimate_line_items")
 */
class EstimationLineItem extends \MY_Model
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
    private $proposal_service_id;
    /**
     * @ORM\Column(type="string")
     */
    private $uuid;
    /**
     * @ORM\Column(type="integer")
     */
    private $item_id;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $unit_price;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $quantity;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $total_price;
    /**
     * @ORM\Column(type="integer")
     */
    private $custom_unit_price;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $base_price;
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $overhead_rate;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $overhead_price;
    /**
     * @ORM\Column(type="decimal", precision=12, scale=2)
     */
    private $profit_rate;
    /**
     * @ORM\Column(type="decimal", precision=12, scale=2)
     */
    private $profit_price;
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $tax_rate;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $tax_price;
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $trucking_overhead_rate;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $trucking_overhead_price;
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $trucking_profit_rate;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $trucking_profit_price;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $trucking_total_price;
    /**
     * @ORM\Column(type="string")
     */
    private $custom_name;
    /**
     * @ORM\Column(type="string")
     */
    private $notes;
    /**
     * @ORM\Column(type="integer")
     */
    private $parent_line_item_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $phase_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $plant_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $sub_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $child_material = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $parent_updated = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $fees = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $permit = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $work_order = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $template_id = NULL;

    /**
     * @ORM\Column(type="integer")
     */
    private $days = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $num_people = 0;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $hours_per_day = 0.00;
     /**
     * @ORM\Column(type="integer")
     */
    private $dump_trucking_id = 0;
     /**
     * @ORM\Column(type="integer")
     */
    private $fixed_template = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $custom_total_price = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $is_custom_sub = 0;
    
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $fixed_labor_total = 0.00;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $fixed_equipment_total = 0.00;

     /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $fixed_labor_base_total = 0.00;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $fixed_equipment_base_total = 0.00;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $fixed_labor_oh_total = 0.00;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $fixed_equipment_oh_total = 0.00;

     /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $fixed_labor_pm_total = 0.00;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $fixed_equipment_pm_total = 0.00;

    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $expected_total = 0.00;
    /**
     * @ORM\Column(type="integer")
     */
    private $edited_base_price =  0.00;
    /**
       * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $edited_unit_price =  0.00;
    /**
       * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $edited_total_price = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $disposal_load_check = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $disposal_loads = 0;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $disposal_unit_price = 0.00;

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
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param mixed $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
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
    public function getUnitPrice()
    {
        return $this->unit_price;
    }

    /**
     * @param mixed $unit_price
     */
    public function setUnitPrice($unit_price)
    {
        $this->unit_price = $unit_price;
    }

    /**
     * @return mixed
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param mixed $quantity
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return mixed
     */
    public function getTotalPrice()
    {
        return $this->total_price;
    }

    /**
     * @param mixed $total_price
     */
    public function setTotalPrice($total_price)
    {
        $this->total_price = $total_price;
    }

    /**
     * @return mixed
     */
    public function getCustomUnitPrice()
    {
        return $this->custom_unit_price;
    }

    /**
     * @return mixed
     */
    public function getBasePrice()
    {
        return $this->base_price;
    }

    /**
     * @param mixed $base_price
     */
    public function setBasePrice($base_price)
    {
        $this->base_price = $base_price;
    }

    /**
     * @return mixed
     */
    public function getOverheadRate()
    {
        return $this->overhead_rate;
    }

    /**
     * @param mixed $overhead_rate
     */
    public function setOverheadRate($overhead_rate)
    {
        $this->overhead_rate = $overhead_rate;
    }

    /**
     * @return mixed
     */
    public function getOverheadPrice()
    {
        return $this->overhead_price;
    }

    /**
     * @param mixed $overhead_price
     */
    public function setOverheadPrice($overhead_price)
    {
        $this->overhead_price = $overhead_price;
    }

    /**
     * @return mixed
     */
    public function getProfitRate()
    {
        return $this->profit_rate;
    }

    /**
     * @param mixed $profit_rate
     */
    public function setProfitRate($profit_rate)
    {
        $this->profit_rate = $profit_rate;
    }

    /**
     * @return mixed
     */
    public function getProfitPrice()
    {
        return $this->profit_price;
    }

    /**
     * @param mixed $profit_price
     */
    public function setProfitPrice($profit_price)
    {
        $this->profit_price = $profit_price;
    }

    /**
     * @return mixed
     */
    public function getTaxRate()
    {
        return $this->tax_rate;
    }

    /**
     * @param mixed $tax_rate
     */
    public function setTaxRate($tax_rate)
    {
        $this->tax_rate = $tax_rate;
    }

    /**
     * @return mixed
     */
    public function getTaxPrice()
    {
        return $this->tax_price;
    }

    /**
     * @param mixed $tax_price
     */
    public function setTaxPrice($tax_price)
    {
        $this->tax_price = $tax_price;
    }

    /**
     * @param mixed $custom_unit_price
     */
    public function setCustomUnitPrice($custom_unit_price)
    {
        $this->custom_unit_price = $custom_unit_price;
    }

    /**
     * @return EstimationItem
     */
    public function getItem()
    {
        return $this->doctrine->em->findEstimationItem($this->getItemId());
    }

    /**
     * @return EstimationType
     */
    public function getItemType()
    {
        return $this->getItem()->getType();
    }

    /**
     * @return EstimationCategory
     */
    public function getItemTypeCategory()
    {
        return $this->getItem()->getType()->getCategory();
    }

    /**
     * @return mixed
     */
    public function getTruckingOverheadRate()
    {
        return $this->trucking_overhead_rate;
    }

    /**
     * @param mixed $trucking_overhead_rate
     */
    public function setTruckingOverheadRate($trucking_overhead_rate)
    {
        $this->trucking_overhead_rate = $trucking_overhead_rate;
    }

    /**
     * @return mixed
     */
    public function getTruckingOverheadPrice()
    {
        return $this->trucking_overhead_price;
    }

    /**
     * @param mixed $trucking_overhead_price
     */
    public function setTruckingOverheadPrice($trucking_overhead_price)
    {
        $this->trucking_overhead_price = $trucking_overhead_price;
    }

    /**
     * @return mixed
     */
    public function getTruckingProfitRate()
    {
        return $this->trucking_profit_rate;
    }

    /**
     * @param mixed $trucking_profit_rate
     */
    public function setTruckingProfitRate($trucking_profit_rate)
    {
        $this->trucking_profit_rate = $trucking_profit_rate;
    }

    /**
     * @return mixed
     */
    public function getTruckingProfitPrice()
    {
        return $this->trucking_profit_price;
    }

    /**
     * @param mixed $trucking_profit_price
     */
    public function setTruckingProfitPrice($trucking_profit_price)
    {
        $this->trucking_profit_price = $trucking_profit_price;
    }

    /**
     * @return mixed
     */
    public function getTruckingTotalPrice()
    {
        return $this->trucking_total_price;
    }

    /**
     * @param mixed $trucking_total_price
     */
    public function setTruckingTotalPrice($trucking_total_price)
    {
        $this->trucking_total_price = $trucking_total_price;
    }

    /**
     * @return mixed
     */
    public function getCustomName()
    {
        return $this->custom_name;
    }

    /**
     * @param mixed $custom_name
     */
    public function setCustomName($custom_name)
    {
        $this->custom_name = $custom_name;
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
    public function getParentLineItemId()
    {
        return $this->parent_line_item_id;
    }

    /**
     * @param mixed $parent_line_item_id
     */
    public function setParentLineItemId($parent_line_item_id)
    {
        $this->parent_line_item_id = $parent_line_item_id;
    }

    /**
     * @return mixed
     */
    public function getPhaseId()
    {
        return $this->phase_id;
    }

    /**
     * @param mixed $phase_id
     */
    public function setPhaseId($phase_id)
    {
        $this->phase_id = $phase_id;
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
    public function getSubId()
    {
        return $this->sub_id;
    }

    /**
     * @param mixed $sub_id
     */
    public function setSubId($sub_id)
    {
        $this->sub_id = $sub_id;
    }

    /**
     * @return mixed
     */
    public function getChildMaterial()
    {
        return $this->child_material;
    }

    /**
     * @param mixed $child_material
     */
    public function setChildMaterial($child_material)
    {
        $this->child_material = $child_material;
    }

    /**
     * @return mixed
     */
    public function getParentUpdated()
    {
        return $this->parent_updated;
    }
    /**
     * @param mixed $parent_updated
     */
    public function setParentUpdated($parent_updated)
    {
        $this->parent_updated = $parent_updated;
    }

    /**
     * @return mixed
     */
    public function getFees()
    {
        return $this->fees;
    }

    /**
     * @param mixed $fees
     */
    public function setFees($fees)
    {
        $this->fees = $fees;
    }


    /**
     * @return mixed
     */
    public function getPermit()
    {
        return $this->permit;
    }

    /**
     * @param mixed $permit
     */
    public function setPermit($permit)
    {
        $this->permit = $permit;
    }

    /**
     * @return mixed
     */
    public function getWorkOrder()
    {
        return $this->work_order;
    }

    /**
     * @param mixed work_order
     */
    public function setWorkOrder($work_order)
    {
        $this->work_order = $work_order;
    }

    /**
     * @return mixed
     */
    public function getTemplateId()
    {
        return $this->template_id;
    }

    /**
     * @param mixed template_id
     */
    public function setTemplateId($template_id)
    {
        $this->template_id = $template_id;
    }

    /**
     * @return mixed
     */
    public function getDay()
    {
        return $this->days;
    }

    /**
     * @param mixed days
     */
    public function setDay($days)
    {
        $this->days = $days;
    }

    /**
     * @return mixed
     */
    public function getNumPeople()
    {
        return $this->num_people;
    }

    /**
     * @param mixed num_people
     */
    public function setNumPeople($num_people)
    {
        $this->num_people = $num_people;
    }

     /**
     * @return mixed
     */
    public function getHoursPerDay ()
    {
        return $this->hours_per_day ;
    }

    /**
     * @param mixed hours_per_day 
     */
    public function setHoursPerDay ($hours_per_day )
    {
        $this->hours_per_day  = $hours_per_day ;
    }
    
    /**
     * @return mixed
     */
    public function getDumpTruckingId()
    {
        return $this->dump_trucking_id ;
    }

    /**
     * @param mixed dump_trucking_id 
     */
    public function setDumpTruckingId($dump_trucking_id )
    {
        $this->dump_trucking_id  = $dump_trucking_id ;
    }
    /**
     * @return mixed
     */
    public function getFixedTemplate()
    {
        return $this->fixed_template ;
    }

    /**
     * @param mixed fixed_template 
     */
    public function setFixedTemplate($fixed_template )
    {
        $this->fixed_template  = $fixed_template ;
    }

    /**
     * @return mixed
     */
    public function getCustomTotalPrice()
    {
        return $this->custom_total_price ;
    }

    /**
     * @param mixed custom_total_price 
     */
    public function setCustomTotalPrice($custom_total_price )
    {
        $this->custom_total_price  = $custom_total_price ;
    }
    
    /**
     * @return mixed
     */
    public function getIsCustomSub()
    {
        return $this->is_custom_sub ;
    }

    /**
     * @param mixed is_custom_sub 
     */
    public function setIsCustomSub($is_custom_sub )
    {
        $this->is_custom_sub  = $is_custom_sub ;
    }
   
    /**
     * @return mixed
     */
    public function getFixedLaborTotal()
    {
        return $this->fixed_labor_total ;
    }

    /**
     * @param mixed fixed_labor_total 
     */
    public function setFixedLaborTotal($fixed_labor_total )
    {
        $this->fixed_labor_total  = $fixed_labor_total ;
    }

    /**
     * @return mixed
     */
    public function getFixedEquipmentTotal()
    {
        return $this->fixed_equipment_total ;
    }

    /**
     * @param mixed fixed_equipment_total 
     */
    public function setFixedEquipmentTotal($fixed_equipment_total )
    {
        $this->fixed_equipment_total  = $fixed_equipment_total ;
    }


/**
     * @return mixed
     */
    public function getFixedLaborBaseTotal()
    {
        return $this->fixed_labor_base_total ;
    }

    /**
     * @param mixed fixed_labor_base_total 
     */
    public function setFixedLaborBaseTotal($fixed_labor_base_total )
    {
        $this->fixed_labor_base_total  = $fixed_labor_base_total ;
    }

    /**
     * @return mixed
     */
    public function getFixedEquipmentBaseTotal()
    {
        return $this->fixed_equipment_base_total ;
    }

    /**
     * @param mixed fixed_equipment_base_total 
     */
    public function setFixedEquipmentBaseTotal($fixed_equipment_base_total )
    {
        $this->fixed_equipment_base_total  = $fixed_equipment_base_total ;
    }


    /**
     * @return mixed
     */
    public function getFixedLaborOhTotal()
    {
        return $this->fixed_labor_oh_total ;
    }

    /**
     * @param mixed fixed_labor_oh_total 
     */
    public function setFixedLaborOhTotal($fixed_labor_oh_total )
    {
        $this->fixed_labor_oh_total  = $fixed_labor_oh_total ;
    }

    /**
     * @return mixed
     */
    public function getFixedEquipmentOhTotal()
    {
        return $this->fixed_equipment_oh_total ;
    }

    /**
     * @param mixed fixed_equipment_oh_total 
     */
    public function setFixedEquipmentOhTotal($fixed_equipment_oh_total )
    {
        $this->fixed_equipment_oh_total  = $fixed_equipment_oh_total ;
    }


    /**
     * @return mixed
     */
    public function getFixedLaborPmTotal()
    {
        return $this->fixed_labor_pm_total ;
    }

    /**
     * @param mixed fixed_labor_pm_total 
     */
    public function setFixedLaborPmTotal($fixed_labor_pm_total )
    {
        $this->fixed_labor_pm_total  = $fixed_labor_pm_total ;
    }

    /**
     * @return mixed
     */
    public function getFixedEquipmentPmTotal()
    {
        return $this->fixed_equipment_pm_total ;
    }

    /**
     * @param mixed fixed_equipment_pm_total 
     */
    public function setFixedEquipmentPmTotal($fixed_equipment_pm_total )
    {
        $this->fixed_equipment_pm_total  = $fixed_equipment_pm_total ;
    }


    /**
     * @return mixed
     */
    public function getExpectedTotal()
    {
        return $this->expected_total ;
    }

    /**
     * @param mixed expected_total 
     */
    public function setExpectedTotal($expected_total )
    {
        $this->expected_total  = $expected_total ;
    }


    /**
    * @return mixed
    */
    public function getEditedBasePrice()
    {
        return $this->edited_base_price ;
    }

    /**
    * @param mixed edited_base_price 
    */
    public function setEditedBasePrice($edited_base_price )
    {
        $this->edited_base_price  = $edited_base_price ;
    }

    /**
    * @return mixed
    */
    public function getEditedUnitPrice()
    {
        return $this->edited_unit_price ;
    }

    /**
    * @param mixed edited_unit_price 
    */
    public function setEditedUnitPrice($edited_unit_price )
    {
        $this->edited_unit_price  = $edited_unit_price ;
    }

    /**
    * @return mixed
    */
    public function getEditedTotalPrice()
    {
        return $this->edited_total_price ;
    }

    /**
    * @param mixed edited_unit_price 
    */
    public function setEditedTotalPrice($edited_total_price )
    {
        $this->edited_total_price  = $edited_total_price ;
    }

    /**
    * @return mixed
    */
    public function getDisposalLoadCheck()
    {
        return $this->disposal_load_check ;
    }

    /**
    * @param mixed disposal_load_check 
    */
    public function setDisposalLoadCheck($disposal_load_check )
    {
        $this->disposal_load_check  = $disposal_load_check ;
    }

    /**
    * @return mixed
    */
    public function getDisposalLoads()
    {
        return $this->disposal_loads ;
    }

    /**
    * @param mixed disposal_loads 
    */
    public function setDisposalLoads($disposal_loads )
    {
        $this->disposal_loads  = $disposal_loads ;
    }

    /**
    * @return mixed
    */
    public function getDisposalUnitPrice()
    {
        return $this->disposal_unit_price ;
    }

    /**
    * @param mixed disposal_unit_price 
    */
    public function setDisposalUnitPrice($disposal_unit_price )
    {
        $this->disposal_unit_price  = $disposal_unit_price ;
    }
    

     /**
     * @return \models\EstimationPhase
     */
    public function getPhase()
    {
        $phase = $this->doctrine->em->findEstimationPhase($this->getPhaseId());

        return $phase;
    }

    /**
     * @return \models\Proposal_services
     */
    public function getProposalService()
    {
        $proposalService = $this->doctrine->em->findProposalService($this->getProposalServiceId());

        return $proposalService;
    }

    /**
     * Returns any notes associated with a line item
     * @return mixed
     */
    public function getEstimateNotes()
    {
        $dql = "SELECT n FROM models\Notes n 
                WHERE n.type='estimate_line_item' 
                AND n.relationId = :lineItemId
                ORDER BY n.added DESC";

        $query = $this->doctrine->em->createQuery($dql);
        $query->setParameter(':lineItemId', $this->getId());

        return $query->getResult();
    }

    public function getSubContractor()
    {
        $sub = $this->doctrine->em->findEstimateSubContractor($this->getSubId());

        return $sub;
    }
}