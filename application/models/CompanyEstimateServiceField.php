<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="estimate_company_service_fields")
 */
class CompanyEstimateServiceField extends \MY_Model
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
    private $company_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $service_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $field_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $measurement = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $unit = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $depth = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $area = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $length = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $qty = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $gravel_depth = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $base_depth = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $excavation_depth = 0;

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
    public function getFieldId()
    {
        return $this->field_id;
    }

    /**
     * @param mixed $field_id
     */
    public function setFieldId($field_id)
    {
        $this->field_id = $field_id;
    }

    /**
     * @return mixed
     */
    public function getMeasurement()
    {
        return $this->measurement;
    }

    /**
     * @param mixed $measurement
     */
    public function setMeasurement($measurement)
    {
        $this->measurement = $measurement;
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
    public function getLength()
    {
        return $this->length;
    }

    /**
     * @param mixed $length
     */
    public function setLength($length)
    {
        $this->length = $length;
    }

    /**
     * @return mixed
     */
    public function getQty()
    {
        return $this->qty;
    }

    /**
     * @param mixed $qty
     */
    public function setQty($qty)
    {
        $this->qty = $qty;
    }

    /**
     * @return mixed
     */
    public function getGravelDepth()
    {
        return $this->gravel_depth;
    }

    /**
     * @param mixed $gravel_depth
     */
    public function setGravelDepth($gravel_depth)
    {
        $this->gravel_depth = $gravel_depth;
    }

    /**
     * @return mixed
     */
    public function getServiceId()
    {
        return $this->service_id;
    }

    /**
     * @param mixed $service_id
     */
    public function setServiceId($service_id)
    {
        $this->service_id = $service_id;
    }

    /**
     * @return mixed
     */
    public function getBaseDepth()
    {
        return $this->base_depth;
    }

    /**
     * @param mixed $base_depth
     */
    public function setBaseDepth($base_depth)
    {
        $this->base_depth = $base_depth;
    }

    /**
     * @return mixed
     */
    public function getExcavationDepth()
    {
        return $this->excavation_depth;
    }

    /**
     * @param mixed $excavation_depth
     */
    public function setExcavationDepth($excavation_depth)
    {
        $this->excavation_depth = $excavation_depth;
    }

}