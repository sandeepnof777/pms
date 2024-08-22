<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="business_type_assignments")
 */
class BusinessTypeAssignment
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
    private $business_type_id;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $company_id;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $prospect_id;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $lead_id;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $account_id;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $client_id;

    // /**
    // * @ORM\ManyToOne(targetEntity="Prospect", inversedBy="bta")
    // * @ORM\JoinColumn(name="prospect_id", referencedColumnName="prospectId")
    // */
    // private $prospect;

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
    public function getBusinessTypeId()
    {
        return $this->business_type_id;
    }

    /**
     * @param mixed $business_type_id
     */
    public function setBusinessTypeId($business_type_id)
    {
        $this->business_type_id = $business_type_id;
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

    /**
     * @return mixed
     */
    public function getProspectId()
    {
        return $this->prospect_id;
    }

    /**
     * @param mixed $prospect_id
     */
    public function setProspectId($prospect_id)
    {
        $this->prospect_id = $prospect_id;
    }

    /**
     * @return mixed
     */
    public function getLeadId()
    {
        return $this->lead_id;
    }

    /**
     * @param mixed $lead_id
     */
    public function setLeadId($lead_id)
    {
        $this->lead_id = $lead_id;
    }

    /**
     * @return mixed
     */
    public function getAccountId()
    {
        return $this->account_id;
    }

    /**
     * @param mixed $account_id
     */
    public function setAccountId($account_id)
    {
        $this->account_id = $account_id;
    }

 /**
     * @return mixed
     */
    public function getClientId()
    {
        return $this->client_id;
    }

    /**
     * @param mixed $account_id
     */
    public function setClientId($client_id)
    {
        $this->client_id = $client_id;
    }

}