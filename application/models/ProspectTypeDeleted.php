<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="prospect_type_deleted")
 */
class ProspectTypeDeleted
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
    private $prospect_type_id;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $company_id;

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
    public function getProspectTypeId()
    {
        return $this->prospect_type_id;
    }

    /**
     * @param mixed $prospect_type_id
     */
    public function setProspectTypeId($prospect_type_id)
    {
        $this->prospect_type_id = $prospect_type_id;
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

}