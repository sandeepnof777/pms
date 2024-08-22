<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="email_templates")
 */
class Email_templates {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $templateId;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $templateName;
    /**
     * @ORM\Column(type="string", length=2048, nullable=true)
     */
    private $templateDescription;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $templateSubject;
    /**
     * @ORM\Column(type="string", length=10000, nullable=true)
     */
    private $templateBody;
    /**
     * @ORM\OneToMany(targetEntity="Email_templates_fields", mappedBy="template", cascade={"remove"})
     **/
    private $fields;

    public CONST PROPOSAL_SIGNED_SIGNEE = 43;
    public CONST PROPOSAL_SIGNED_USER = 44;
    public CONST PROPOSAL_QUESTION_USER = 45;
    public CONST PROPOSAL_FINAL_CONTRACT_CLIENT = 48;
    public CONST PROPOSAL_FINAL_CONTRACT_USER = 49;
   
    function __construct() {
        $this->fields = new ArrayCollection();
    }

    public function getTemplateId() {
        return $this->templateId;
    }

    public function setTemplateId($templateId) {
        $this->templateId = $templateId;
    }

    public function getTemplateName() {
        return $this->templateName;
    }

    public function setTemplateName($templateName) {
        $this->templateName = $templateName;
    }

    public function getTemplateBody() {
        return $this->templateBody;
    }

    public function setTemplateBody($templateBody) {
        $this->templateBody = $templateBody;
    }

    public function getFields() {
        return $this->fields;
    }

    public function setFields($templateFields) {
        $this->fields = $templateFields;
    }

    public function getTemplateFields() {
        $template_fields = array();
        $fields = $this->getFields();
        foreach ($fields as $field) {
            $template_fields[] = array(
                'fieldName' => $field->getFieldName(),
                'fieldCode' => $field->getFieldCode(),
                'fieldValue' => $field->getDefaultValue(),
            );
        }
        return $template_fields;
    }

    public function getTemplateSubject() {
        return $this->templateSubject;
    }

    public function setTemplateSubject($templateSubject) {
        $this->templateSubject = $templateSubject;
    }

    public function getTemplateDescription() {
        return $this->templateDescription;
    }

    public function setTemplateDescription($templateDescription) {
        $this->templateDescription = $templateDescription;
    }

}