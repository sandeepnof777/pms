<?php
namespace models;
use \Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="service_deleted_texts")
 */
class Service_deleted_texts {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $linkId;
    /**
     * @ORM\Column(type="string")
     */
    private $company;
    /**
     * @ORM\Column(type="integer")
     */
    private $textId;
    /**
     * @ORM\Column(type="integer")
     */
    private $replacedBy;

    function __construct() {
    }

    public function getLinkId() {
        return $this->linkId;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCompany($company) {
        $this->company = $company;
    }

    public function getTextId() {
        return $this->textId;
    }

    public function setTextId($textId) {
        $this->textId = $textId;
    }

    public function getReplacedBy() {
        return $this->replacedBy;
    }

    public function setReplacedBy($replacedBy) {
        $this->replacedBy = $replacedBy;
    }
}