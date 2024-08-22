<?php

namespace models;
use \Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="calculators_values")
 */
class Calculators_values {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $fieldId;
    /**
     * @ORM\Column(type="integer")
     */
    private $company;
    /**
     * @ORM\Column(type="integer")
     */
    private $itemId;
    /**
     * @ORM\Column(type="string")
     */
    private $fieldName;
    /**
     * @ORM\Column(type="string")
     */
    private $fieldValue;

    function __construct() {
    }

    public function getFieldId() {
        return $this->fieldId;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCompany($company) {
        $this->company = $company;
    }

    public function getItemId() {
        return $this->itemId;
    }

    public function setItemId($itemId) {
        $this->itemId = $itemId;
    }

    public function getFieldName() {
        return $this->fieldName;
    }

    public function setFieldName($fieldName) {
        $this->fieldName = $fieldName;
    }

    public function getFieldValue() {
        return $this->fieldValue;
    }

    public function setFieldValue($fieldValue) {
        $this->fieldValue = $fieldValue;
    }
}
