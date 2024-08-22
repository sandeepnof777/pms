<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="companies_parent_child_ralations")
 */
class CompanyParentChildRelation {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $parent_company_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $child_company_id;
   
    

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
    public function getParentCompanyId()
    {
        return $this->parent_company_id;
    }

    /**
     * @param mixed $parent_company_id
     */
    public function setParentCompanyId($parent_company_id)
    {
        $this->parent_company_id = $parent_company_id;
    }

    /**
     * @return mixed
     */
    public function getChildCompanyId()
    {
        return $this->child_company_id;
    }

    /**
     * @param mixed $child_company_id
     */
    public function setChildCompanyId($child_company_id)
    {
        $this->child_company_id = $child_company_id;
    }

    
}