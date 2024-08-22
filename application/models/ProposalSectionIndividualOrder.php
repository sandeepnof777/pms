<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="proposal_sections_individual_order")
 */
class ProposalSectionIndividualOrder
{



    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $proposal_section_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $proposal_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $ord = 999;

    /**
     * @ORM\Column(type="integer")
     */
    private $visible = 1;

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
    public function getProposalSectionId()
    {
        return $this->proposal_section_id;
    }

    /**
     * @param mixed $proposal_section_id
     */
    public function setProposalSectionId($proposal_section_id)
    {
        $this->proposal_section_id = $proposal_section_id;
    }

    /**
     * @return int
     */
    public function getProposalId()
    {
        return $this->proposal_id;
    }

    /**
     * @param int $proposal_id
     */
    public function setProposalId($proposal_id)
    {
        $this->proposal_id = $proposal_id;
    }
    
   
    /**
     * @return int
     */
    public function getOrd()
    {
        return $this->ord;
    }

    /**
     * @param int $ord
     */
    public function setOrd($ord)
    {
        $this->ord = $ord;
    }


    /**
     * @return int
     */
    public function getVisible()
    {
        return $this->visible;
    }

    /**
     * @param int $visible
     */
    public function setVisible($visible)
    {
        $this->visible = $visible;
    }
}