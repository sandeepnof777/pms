<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="service_texts_order")
 */
class ServiceTextOrder {
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
    private $service;
    /**
     * @ORM\Column(type="integer")
     */
    private $ord;

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

    public function getService() {
        return $this->service;
    }

    public function setService($service) {
        $this->service = $service;
    }

    public function getOrd() {
        return $this->ord;
    }

    public function setOrd($ord) {
        $this->ord = $ord;
    }
}