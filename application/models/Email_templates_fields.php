<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="email_templates_fields")
 */
class Email_templates_fields {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $templateFieldId;
    /**
     * @ORM\ManyToOne(targetEntity="Email_templates", inversedBy="fields")
     * @ORM\JoinColumn(name="template", referencedColumnName="templateId")
     **/
    private $template;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fieldName;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $fieldCode;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $defaultValue;


    function __construct() {
    }

    public function getTemplateFieldId() {
        return $this->templateFieldId;
    }

    public function setTemplateFieldId($templateFieldId) {
        $this->templateFieldId = $templateFieldId;
    }

    public function getFieldName() {
        return $this->fieldName;
    }

    public function setFieldName($fieldName) {
        $this->fieldName = $fieldName;
    }

    public function getDefaultValue() {
        return $this->defaultValue;
    }

    public function setDefaultValue($defaultValue) {
        $this->defaultValue = $defaultValue;
    }

    public function getFieldCode() {
        return $this->fieldCode;
    }

    public function setFieldCode($fieldCode) {
        $this->fieldCode = $fieldCode;
    }
    

}