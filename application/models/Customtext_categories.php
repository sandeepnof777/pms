<?php

namespace models;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="customtext_categories")
 */
class Customtext_categories {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $categoryId;

    /**
     * @ORM\Column (type="integer", nullable=true)
     */
    private $company;

    /**
     * @ORM\Column (type="string", nullable=true)
     */
    private $categoryName;

    function __construct() {
    }

    public function getCategoryId() {
        return $this->categoryId;
    }

    public function getCategoryName() {
        return $this->categoryName;
    }

    public function setCategoryName($categoryName) {
        $this->categoryName = $categoryName;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCompany($companyId) {
        $this->company = $companyId;
    }
}
