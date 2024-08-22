<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="pre_proposal_popup_hide")
 */

class PreProposalPopupHide {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=248, nullable=true)
     */
    private $email;

   /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $proposal_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $proposal_link_id;
    

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getEmail() {
        return $this->email;
    }

    /**
     * @return mixed
     */
    public function getProposalId()
    {
        return $this->proposal_id;
    }

    /**
     * @param mixed $proposal_id
     */
    public function setProposalId($proposal_id)
    {
        $this->proposal_id = $proposal_id;
    }

    /**
     * @return mixed
     */
    public function getProposalLinkId()
    {
        return $this->proposal_link_id;
    }

    /**
     * @param mixed $proposal_link_id
     */
    public function setProposalLinkId($proposal_link_id)
    {
        $this->proposal_link_id = $proposal_link_id;
    }

}
