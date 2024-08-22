<?php

namespace models;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="notes")
 */
class Notes extends \MY_Model {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $noteId;
    /**
     * @ORM\Column(type="string", length=128)
     */
    private $type;
    /**
     * @ORM\Column(type="string", length=2048)
     */
    private $noteText;
    /**
     * @ORM\Column(type="integer")
     */
    private $relationId;
    /**
     * @ORM\Column(type="integer")
     */
    private $added;
    /**
     * @ORM\Column(type="integer")
     */
    private $user;
    /**
     * @ORM\Column(type="integer")
     */
    private $parent_relation_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $work_order;

    function __construct() {
        $this->added = time();
        $this->user = 0;
    }

    public function getNoteId() {
        return $this->noteId;
    }

    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    public function getNoteText() {
        return $this->noteText;
    }

    public function setNoteText($noteText) {
        $this->noteText = $noteText;
    }

    public function getRelationId() {
        return $this->relationId;
    }

    public function setRelationId($relationId) {
        $this->relationId = $relationId;
    }

    public function getAdded() {
        return $this->added;
    }

    public function setAdded($added) {
        $this->added = $added;
    }

    public function getUser() {
        return $this->user;
    }

    public function setUser($user) {
        $this->user = $user;
    }

    /**
     * @return mixed
     */
    public function getParentRelationId()
    {
        return $this->parent_relation_id;
    }

    /**
     * @param mixed $parent_relation_id
     */
    public function setParentRelationId($parent_relation_id)
    {
        $this->parent_relation_id = $parent_relation_id;
    }

    /////////
    /**
     * @return mixed
     */
    public function getWorkOrder()
    {
        return $this->work_order;
    }

    /**
     * @param mixed $work_order
     */
    public function setWorkOrder($work_order)
    {
        $this->work_order = $work_order;
    }

    public function getUsername()
    {

        $username = 'Not found';

        $user = $this->doctrine->em->findAccount($this->getUser());

        if ($user) {
            $username = $user->getFullName();
        }

        return $username;
    }

    public function getEstimateItemName()
    {
        $itemNameString = 'Deleted Item';

        $lineItem = $this->doctrine->em->findEstimationLineItem($this->getRelationId());

        if ($lineItem) {
            $itemName = $lineItem->getItem()->getName();
            $serviceName = $lineItem->getProposalService()->getServiceName();
            $phaseName = $lineItem->getPhase()->getName();

            $itemNameString = '<strong>Item:</strong>' . $itemName . '<br />' .
                '<strong>Service:</strong>' . $serviceName . '<br />' .
                '<strong>Phase:</strong>' . $phaseName;
        }

        return $itemNameString;
    }
}












