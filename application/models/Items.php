<?php
namespace models;
use \Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="items")
 */
class Items {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $itemId;
    /**
     * @ORM\OneToMany(targetEntity="Fields", mappedBy="item",cascade={"persist"})
     */
    private $fields;
    /**
     * @ORM\OneToMany(targetEntity="Proposals_items", mappedBy="item", cascade={"persist"})
     */
    private $proposals;
    /**
     * @ORM\Column(type="string")
     */
    private $itemName;
    /**
     * @ORM\Column(type="string")
     */
    private $itemText;
    /**
     * @ORM\Column(type="integer")
     */
    private $ord;
    /**
     * @ORM\Column(type="string")
     */
    private $specs;

    function __construct() {
        $this->fields = new ArrayCollection();
    }

    public function getItemId() {
        return $this->itemId;
    }

    public function getItemName() {
        return $this->itemName;
    }

    public function setItemName($itemName) {
        $this->itemName = $itemName;
    }

    public function getItemText() {
        return $this->itemText;
    }

    public function setItemText($itemText) {
        $this->itemText = $itemText;
    }

    public function getFields() {
        return $this->fields;
    }

    public function getOrder() {
        return $this->ord;
    }

    public function setOrder($order) {
        $this->ord = $order;
    }

    public function getProposals() {
        return $this->proposals;
    }

    public function getSpecs() {
        return $this->specs;
    }

    public function setSpecs($specs) {
        $this->specs = $specs;
    }
}