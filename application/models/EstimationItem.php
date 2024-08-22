<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="estimation_items")
 */
class EstimationItem extends \MY_Model
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
     * @ORM\Column(type="string")
     */
    private $name;
    /**
     * @ORM\Column(type="integer")
     */
    private $company_id = null;
    /**
     * @ORM\Column(type="integer")
     */
    private $unit;
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
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $profit_rate;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $profit_price;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $unit_price;
    /**
     * @ORM\Column(type="integer")
     */
    private $taxable = 0;
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $tax_rate = 0.00;
    /**
     * @ORM\Column(type="string")
     */
    private $vendor;
    /**
     * @ORM\Column(type="string")
     */
    private $sku;
    /**
     * @ORM\Column(type="string")
     */
    private $notes;
    /**
     * @ORM\Column(type="integer")
     */
    private $ord = 999;
    /**
     * @ORM\Column(type="integer")
     */
    private $deleted = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $capacity = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $default_item_id;

    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $minimum_hours = 0.00;

    function __construct()
    {
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
    public function getId()
    {
        return $this->id;
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
    public function getTaxable()
    {
        return $this->taxable;
    }

    /**
     * @param mixed $taxable
     */
    public function setTaxable($taxable)
    {
        $this->taxable = $taxable;
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
    public function getVendor()
    {
        return $this->vendor;
    }

    /**
     * @param mixed $vendor
     */
    public function setVendor($vendor)
    {
        $this->vendor = $vendor;
    }

    /**
     * @return mixed
     */
    public function getSku()
    {
        return $this->sku;
    }

    /**
     * @param mixed $sku
     */
    public function setSku($sku)
    {
        $this->sku = $sku;
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
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
    }

    /**
     * @return EstimationType
     */
    public function getType()
    {
        return $this->doctrine->em->findEstimationType($this->getTypeId());
    }

    /**
     * @return getTemplates
     */
    public function getTemplates($company_id)
    {
        return $this->getEstimationRepository()->findTemplates($this->getId(),$company_id);
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
     * @return \models\EstimationUnit
     */
    public function getUnitModel()
    {
        $ci =& get_instance();
        return $ci->em->find('\models\EstimationUnit', $this->getUnit());
    }

    /**
     * @return mixed
     */
    public function getUnit()
    {
        return $this->unit;
    }

    /**
     * @param mixed $unit
     */
    public function setUnit($unit)
    {
        $this->unit = $unit;
    }

    /**
     * @return mixed
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * @param mixed $capacity
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
    }

    /**
     * @return mixed
     */
    public function getDefaultItemId()
    {
        return $this->default_item_id;
    }

    /**
     * @param mixed $default_item_id
     */
    public function setDefaultItemId($default_item_id)
    {
        $this->default_item_id = $default_item_id;
    }
    

    /**
     * @return mixed
     */
    public function getMinimumHours()
    {
        return $this->minimum_hours;
    }

    /**
     * @param mixed $minimum_hours
     */
    public function setMinimumHours($minimum_hours)
    {
        $this->minimum_hours = $minimum_hours;
    }

}