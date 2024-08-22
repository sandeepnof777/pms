<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="estimation_crews")
 */
class EstimationCrew extends \MY_Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */
    private $name;
    /**
     * @ORM\Column(type="integer", nullable=true))
     */
    private $company_id;
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
    private $unit_id;
    /**
     * @ORM\Column(type="decimal", precision=8, scale=2)
     */
    private $base_price;
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $oh_rate;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $oh_price;
    /**
     * @ORM\Column(type="decimal", precision=5, scale=2)
     */
    private $pm_rate;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $pm_price;
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $total_price;

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
     * @return mixed
     */
    public function getUnitId()
    {
        return $this->unit_id;
    }
    

    /**
     * @param mixed $unit_id
     */
    public function setUnitId($unit_id)
    {
        $this->unit_id = $unit_id;
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
        return $this->oh_rate;
    }

    /**
     * @param mixed $overhead_rate
     */
    public function setOverheadRate($overhead_rate)
    {
        $this->oh_rate = $overhead_rate;
    }

    /**
     * @return mixed
     */
    public function getOverheadPrice()
    {
        return $this->oh_price;
    }

    /**
     * @param mixed $overhead_price
     */
    public function setOverheadPrice($overhead_price)
    {
        $this->oh_price = $overhead_price;
    }

    /**
     * @return mixed
     */
    public function getProfitRate()
    {
        return $this->pm_rate;
    }

    /**
     * @param mixed $profit_rate
     */
    public function setProfitRate($profit_rate)
    {
        $this->pm_rate = $profit_rate;
    }

    /**
     * @return mixed
     */
    public function getProfitPrice()
    {
        return $this->pm_price;
    }

    /**
     * @param mixed $profit_price
     */
    public function setProfitPrice($profit_price)
    {
        $this->pm_price = $profit_price;
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

}