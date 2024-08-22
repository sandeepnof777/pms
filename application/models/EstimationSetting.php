<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="estimation_settings")
 */
class EstimationSetting
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $company_id;
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $default_overhead;
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $default_profit;
    /**
     * @ORM\Column(type="integer")
     */
    private $calculation_type = 1;
    /**
     * @ORM\Column(type="integer")
     */
    private $production_rate = 0;
    /**
     * @ORM\Column (type="string", nullable=false)
     */
    private $work_order_layout_type;
    /**
     * @ORM\Column(type="integer")
     */
    private $group_template_item = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $disposal_load;
    
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
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * @param mixed $company_id
     */
    public function setCompanyId($company_id)
    {
        $this->company_id = $company_id;
    }

    /**
     * @return mixed
     */
    public function getDefaultOverhead()
    {
        return $this->default_overhead;
    }

    /**
     * @param mixed $default_overhead
     */
    public function setDefaultOverhead($default_overhead)
    {
        $this->default_overhead = $default_overhead;
    }

    /**
     * @return mixed
     */
    public function getDefaultProfit()
    {
        return $this->default_profit;
    }

    /**
     * @param mixed $default_profit
     */
    public function setDefaultProfit($default_profit)
    {
        $this->default_profit = $default_profit;
    }

    /**
     * @return mixed
     */
    public function getCalculationType()
    {
        return $this->calculation_type;
    }

    /**
     * @param mixed $calculation_type
     */
    public function setCalculationType($calculation_type)
    {
        $this->calculation_type = $calculation_type;
    }
    /**
     * @return mixed
     */
    public function getProductionRate()
    {
        return $this->production_rate;
    }

    /**
     * @param mixed $production_rate
     */
    public function setProductionRate($production_rate)
    {
        $this->production_rate = $production_rate;
    }


    /**
     * @return mixed
     */
    public function getWorkOrderLayoutType()
    {   
        if($this->work_order_layout_type == NULL){
            return  'service_and_phase';
        }
        return $this->work_order_layout_type;
    }

    /**
     * @param mixed $work_order_layout_type
     */
    public function setWorkOrderLayoutType($work_order_layout_type)
    {
        $this->work_order_layout_type = $work_order_layout_type;
    }
    

     /**
     * @return mixed
     */
    public function getGroupTemplateItem()
    {   
        if($this->group_template_item == NULL){
            return  1;
        }
        return $this->group_template_item;
    }

    /**
     * @param mixed $group_template_item
     */
    public function setGroupTemplateItem($group_template_item)
    {
        $this->group_template_item = $group_template_item;
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