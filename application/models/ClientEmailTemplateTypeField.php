<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="client_email_template_type_fields")
 */
class ClientEmailTemplateTypeField extends \MY_Model{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\ManyToOne(targetEntity="ClientEmailTemplateType", inversedBy="fields", cascade={"persist"})
     * @ORM\JoinColumn (name="template_type", referencedColumnName="id")
     */
    private $template_type;
    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $field_name;
    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $field_code;
    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private $field_description;


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
    public function getFieldCode()
    {
        return $this->field_code;
    }

    /**
     * @param mixed $field_code
     */
    public function setFieldCode($field_code)
    {
        $this->field_code = $field_code;
    }

    /**
     * @return mixed
     */
    public function getFieldDescription()
    {
        return $this->field_description;
    }

    /**
     * @param mixed $field_description
     */
    public function setFieldDescription($field_description)
    {
        $this->field_description = $field_description;
    }

    /**
     * @return mixed
     */
    public function getFieldName()
    {
        return $this->field_name;
    }

    /**
     * @param mixed $field_name
     */
    public function setFieldName($field_name)
    {
        $this->field_name = $field_name;
    }

    /**
     * @return mixed
     */
    public function getTemplateType()
    {
        return $this->template_type;
    }

    /**
     * @param mixed $template_type
     */
    public function setTemplateType($templateType)
    {
        $this->template_type = $templateType;
    }
}