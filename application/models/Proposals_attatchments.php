<?php

namespace models;
use \Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="proposals_attatchments")
 */
class Proposals_attatchments {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $attatchId;
    /**
     *
     */
    private $attatchment;
    /**
     *
     */
    private $proposal;

    function __construct() {

    }

    /**
     * @return mixed
     */
    public function getAttatchId()
    {
        return $this->attatchId;
    }

    /**
     * @param mixed $attatchId
     */
    public function setAttatchId($attatchId)
    {
        $this->attatchId = $attatchId;
    }


}