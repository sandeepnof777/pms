<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="estimation_company_default_stages_deleted")
 */
class EstimateCompanyPhaseDeleted
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
    private $default_stage_id;
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
    public function getDefaultStageId()
    {
        return $this->default_stage_id;
    }

    /**
     * @param mixed $default_stage_id
     */
    public function setDefaultStageId($default_stage_id)
    {
        $this->default_stage_id = $default_stage_id;
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
    public function setCompanyId($company_id)
    {
        $this->company_id = $company_id;
    }

}