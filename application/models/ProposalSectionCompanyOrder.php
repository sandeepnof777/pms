<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="proposal_sections_company_order")
 */
class ProposalSectionCompanyOrder
{

    const COOL = 1;
    const STANDARD = 2;
    const CUSTOM = 3;

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
    private $company_id = 999;
    /**
     * @ORM\Column(type="integer")
     */
    private $ord = 999;

    /**
     * @ORM\Column(type="integer")
     */
    private $layout = 1;

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
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * @param int $company_id
     */
    public function setCompanyId($company_id)
    {
        $this->company_id = $company_id;
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
    public function getLayout()
    {
        return $this->layout;
    }

    /**
     * @param int $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
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