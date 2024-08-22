<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="work_order_sections")
 */
class WorkOrderSection
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
    private $section_name;
    /**
     * @ORM\Column(type="string")
     */
    private $section_code;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $ord = 999;


    /**
     * @ORM\Column(type="integer")
     */
    private $visible = 1;
    /**
     * @ORM\Column(type="string")
     */
    private $icon_code;

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
    public function getSectionName()
    {
        return $this->section_name;
    }

    /**
     * @param mixed $section_name
     */
    public function setSectionName($section_name)
    {
        $this->section_name = $section_name;
    }

    
    /**
     * @return mixed
     */
    public function getSectionCode()
    {
        return $this->section_code;
    }

    /**
     * @param mixed $section_code
     */
    public function setSectionCode($section_code)
    {
        $this->section_code = $section_code;
    }
   
    /**
     * @return int
     */
    public function getOrd()
    {
        return $this->ord;
    }

    /**
     * @param int $ord
     */
    public function setOrd($ord)
    {
        $this->ord = $ord;
    }


    /**
     * @return int
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * @param int $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }

    /**
     * @return int
     */
    public function getIconCode()
    {
        return $this->icon_code;
    }

    /**
     * @param int $icon_code
     */
    public function setIconCode($icon_code)
    {
        $this->icon_code = $icon_code;
    }

    
}