<?php
namespace models;
use \Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="proposal_services_fields")
 */
class Proposal_services_fields extends \MY_Model {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $fieldId;
    /**
     * @ORM\Column(type="integer")
     */
    private $serviceId;
    /**
     * @ORM\Column(type="string")
     */
    private $fieldCode;
    /**
     * @ORM\Column(type="string")
     */
    private $fieldValue;

    function __construct() {
    }

    public function getFieldId() {
        return $this->fieldId;
    }

    public function getServiceId() {
        return $this->serviceId;
    }

    public function setServiceId($serviceId) {
        $this->serviceId = $serviceId;
    }

    public function getFieldCode() {
        return $this->fieldCode;
    }

    public function setFieldCode($fieldCode) {
        $this->fieldCode = $fieldCode;
    }

    public function getFieldValue() {
        return $this->fieldValue;
    }

    public function setFieldValue($fieldValue) {
        $this->fieldValue = $fieldValue;
    }

    public function getField()
    {
        return $this->doctrine->em->findServiceField($this->getFieldId());
    }
}