<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="prospect_status_order")
 */
class ProspectStatusOrder
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $prospect_status_id;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $company_id;
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $ord;

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
    public function getProspectStatusId()
    {
        return $this->prospect_status_id;
    }

    /**
     * @param mixed $prospect_status_id
     */
    public function setProspectStatusId($prospect_status_id)
    {
        $this->prospect_status_id = $prospect_status_id;
    }

    /**
     * @return mixed
     */
    public function getCompanyId()
    {
        return $this->company_id;
    }

    /**
     * @param mixed $company_id
     */
    public function setCompany($company_id)
    {
        $this->company_id = $company_id;
    }

    /**
     * @return mixed
     */
    public function getOrd()
    {
        return $this->ord;
    }

    /**
     * @param mixed $ord
     */
    public function setOrd($ord)
    {
        $this->ord = $ord;
    }

}