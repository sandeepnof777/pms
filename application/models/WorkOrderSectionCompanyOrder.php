<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="work_order_sections_company_order")
 */
class WorkOrderSectionCompanyOrder
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
    private $work_order_section_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $company_id = 999;
    /**
     * @ORM\Column(type="integer")
     */
    private $ord = 999;



    /**
     * @ORM\Column(type="integer")
     */
    private $visible = 1;

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
    public function getWorkOrderSectionId()
    {
        return $this->work_order_section_id;
    }

    /**
     * @param mixed $work_order_section_id
     */
    public function setWorkOrderSectionId($work_order_section_id)
    {
        $this->work_order_section_id = $work_order_section_id;
    }

    /**
     * @return int
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * @param int $company_id
     */
    public function setCompanyId($company_id)
    {
        $this->company_id = $company_id;
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
}