<?php

namespace models;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="deleted_customtexts")
 */
class Deleted_customtexts {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $deletionId;
    /**
     * @ORM\Column (type="integer", nullable=true)
     */
    private $textId;
    /**
     * @ORM\Column (type="integer", nullable=true)
     */
    private $companyId;
    /**
     * @ORM\Column (type="integer", nullable=true)
     */
    private $replacedBy;

    public function getDeletionId() {
        return $this->deletionId;
    }

    public function getTextId() {
        return $this->textId;
    }

    public function setTextId($textId) {
        $this->textId = $textId;
    }

    public function getCompanyId() {
        return $this->companyId;
    }

    public function setCompanyId($companyId) {
        $this->companyId = $companyId;
    }

    public function getReplacedBy() {
        return $this->replacedBy;
    }

    public function setReplacedBy($replacedBy) {
        $this->replacedBy = $replacedBy;
    }
}