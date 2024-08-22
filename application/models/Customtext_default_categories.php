<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="customtext_default_categories")
 */
class Customtext_default_categories
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    
    /**
     * @ORM\Column (type="integer", nullable=true)
     */
    private $company;
    
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $categoryId;

    function __construct()
    {
    }

   public function getId() {
       return $this->id;
   }

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($companyId)
    {
        $this->company = $companyId;
    }
    
    public function getCategoryId() {
        return $this->categoryId;
    }

    public function setCategoryId($categoryId) {
        $this->categoryId = $categoryId;
    }
}
