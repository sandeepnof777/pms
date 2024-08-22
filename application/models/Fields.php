<?php

namespace models;
use \Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="fields")
 */
class Fields {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $fieldId;
    /**
     * @ORM\ManyToOne(targetEntity="Items", cascade={"persist"}, inversedBy="fields")
     * @ORM\JoinColumn (name="item", referencedColumnName="itemId")
     */
    private $item;
    /**
     * @ORM\OneToMany(targetEntity="Fields_values", mappedBy="field", cascade={"persist"})
     */
    private $fieldsValues;
    /**
     * @ORM\Column(type="string")
     */
    private $fieldName;
    /**
     * @ORM\Column(type="string")
     */
    private $fieldLabel;
    /**
     * @ORM\Column(type="string")
     */
    private $fieldType;
    /**
     * @ORM\Column(type="string")
     */
    private $fieldValues;
    /**
     * @ORM\Column(type="string")
     */
    private $defaultValue;
    /**
     * @ORM\Column(type="integer")
     */
    private $ord;

    function __construct() {
        $this->ord = 0;
    }

    public function getFieldId() {
        return $this->fieldId;
    }

    public function getItem() {
        return $this->item;
    }

    public function setItem($item) {
        $this->item = $item;
    }

    public function getFieldName() {
        return $this->fieldName;
    }

    public function setFieldName($fieldName) {
        $this->fieldName = $fieldName;
    }

    public function getFieldType() {
        return $this->fieldType;
    }

    public function setFieldType($fieldType) {
        $this->fieldType = $fieldType;
    }

    public function getFieldValues() {
        return $this->fieldValues;
    }

    public function setFieldValues($fieldValues) {
        $this->fieldValues = $fieldValues;
    }

    public function getdefaultValue() {
        return $this->defaultValue;
    }

    public function setdefaultValue($defaultValue) {
        $this->defaultValue = $defaultValue;
    }

    public function getFieldLabel() {
        return $this->fieldLabel;
    }

    public function setFieldLabel($fieldLabel) {
        $this->fieldLabel = $fieldLabel;
    }

    public function getOrder() {
        return $this->ord;
    }

    public function setOrder($order) {
        $this->ord = $order;
    }

    public function getFieldHtml($selectedValue = NULL) {
        $html = '<p class="clearfix field-'.$this->fieldLabel.'">';
        $html .= '<label class="fieldLabel">' . $this->fieldName . '</label>';
        $opts = explode('|', $this->fieldValues);
        $options = array();
        foreach ($opts as $option) {
            $options[$option] = $option;
        }
       
        $selected_value = ($selectedValue == NULL) ? $this->defaultValue : $selectedValue;

        
        $class = 'required';
        if ($this->getFieldLabel() == 'area') {
            $class = '';
        }

        
        switch ($this->fieldType) {
            case 'text':
                $html .= form_input(array('name' => $this->fieldLabel, 'value' => $selected_value, 'class' => $class . ' text textinput'));
                break;
            case 'select':
                $html .= form_dropdown($this->fieldLabel, $options, $selected_value, 'class ="'.$class.'"');
                break;
            case 'textarea':
                $html .= form_textarea(array('name' => $this->fieldLabel, 'value' => $selected_value, 'class' => $class . ''));
                break;
            case 'checkbox':
                break;
            case 'radio':
                break;
        }
        if ($this->getFieldLabel() == 'area') {
            $html .= '<label class="explanation">(Optional) Identify Zone</label>';
        }
        if ($this->getFieldLabel() == 'text') {
            $html .= '<label class="explanation" style="width: 100%;">Each line will be automatically numbered</label>';
        }
        $html .= '</p>';
        return $html;
    }
}