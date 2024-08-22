<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="service_fields")
 */
class ServiceField
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $fieldId;
    /**
     * @ORM\Column(type="integer")
     */
    private $service;
    /**
     * @ORM\Column(type="string")
     */
    private $fieldName;
    /**
     * @ORM\Column(type="string")
     */
    private $fieldCode;
    /**
     * @ORM\Column(type="string")
     */
    private $fieldType;
    /**
     * @ORM\Column(type="string")
     */
    private $fieldValue;
    /**
     * @ORM\Column(type="integer")
     */
    private $ord;
    /**
     * @ORM\Column(type="integer")
     */
    private $company;
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
    public $depth = 0;
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

    function __construct()
    {
    }

    public function getFieldId()
    {
        return $this->fieldId;
    }

    public function getService()
    {
        return $this->service;
    }

    public function setService($service)
    {
        $this->service = $service;
    }

    public function getFieldName()
    {
        return $this->fieldName;
    }

    public function setFieldName($fieldName)
    {
        $this->fieldName = $fieldName;
    }

    public function getFieldCode()
    {
        return $this->fieldCode;
    }

    public function setFieldCode($fieldCode)
    {
        $this->fieldCode = $fieldCode;
    }

    public function getFieldType()
    {
        return $this->fieldType;
    }

    public function setFieldType($fieldType)
    {
        $this->fieldType = $fieldType;
    }

    public function getOrd()
    {
        return $this->ord;
    }

    public function setOrd($ord)
    {
        $this->ord = $ord;
    }

    /**
     * @return int
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * @param $companyId int
     */
    public function setCompany($companyId)
    {
        $this->company = $companyId;
    }

    public function getFieldValue()
    {
        return $this->fieldValue;
    }

    public function setFieldValue($fieldValue)
    {
        $this->fieldValue = $fieldValue;
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
     * @param Accounts $account
     * @return bool
     * Check to see if the account has permission
     */
    public function deleteAuth(Accounts $account)
    {
        // Only available to admins
        if ($account->isAdministrator()) {
            return true;
        }

        // Default to false
        return false;
    }

    /**
     * @param $fieldCode
     * @param $serviceId
     * @param $companyId
     * @return bool
     * Return true if the company is not already using this field code for this service
     */
    public static function isUnique($fieldCode, $serviceId, $companyId)
    {
        $CI =& get_instance();

        $dql = "SELECT COUNT(sf.fieldId)
                FROM \models\ServiceField sf
                WHERE sf.fieldCode = :fieldCode
                AND sf.company = :company
                AND sf.service = :serviceId";

        $query = $CI->em->createQuery($dql);
        $query->setParameter('fieldCode', $fieldCode);
        $query->setParameter('company', $companyId);
        $query->setParameter('serviceId', $serviceId);

        $count = $query->getSingleScalarResult();

        if ($count > 0){
            return false;
        }
        return true;
    }


}