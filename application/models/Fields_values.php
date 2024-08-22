<?php

namespace models;
use \Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fields_values")
 */
class Fields_values {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $valueId;
    /**
     * @ORM\ManyToOne(targetEntity="Fields", inversedBy="fieldsValues")
     * @ORM\JoinColumn(name="field", referencedColumnName="fieldId")
     */
    private $field;
    /**
     * @ORM\ManyToOne(targetEntity="Proposals_items", inversedBy="fieldsValues")
     * @ORM\JoinColumn(name="proposalItem", referencedColumnName="linkId")
     */
    private $proposalItem;
    /**
     * @ORM\Column(type="string")
     */
    private $fieldValue;

    function __construct() {
    }

    public function getValueId() {
        return $this->valueId;
    }

    public function getField() {
        return $this->field;
    }

    public function setField($field) {
        $this->field = $field;
    }

    public function getFieldValue() {
        return $this->fieldValue;
    }

    public function setFieldValue($fieldValue) {
        $this->fieldValue = $fieldValue;
    }

    public function getProposalItem() {
        return $this->proposalItem;
    }

    public function setProposalItem($proposalItem) {
        $this->proposalItem = $proposalItem;
    }
}
