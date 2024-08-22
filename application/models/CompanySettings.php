<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="company_settings")
 */
class CompanySettings { 

     /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     */
    private $company_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $created_at;
    /**
     * @ORM\Column(type="integer")
     */
    private $updated_at;
    /**
     * @ORM\Column(type="integer")
     */
    private $proposal_signature_status;
    /**
     * @ORM\Column(type="integer")
     */
    private $web_layout;
    /**
     * @ORM\Column(type="integer")
     */
    private $is_pre_proposal_popup = 1;
    

    function __construct()
    {
        $this->created_at = time();
        $this->is_pre_proposal_popup =1;
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

    public function getCreatedAt()
    {
        return date('d-M-Y', $this->created_at + TIMEZONE_OFFSET);
    }

    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

       /**
     * @return mixed
     */
    public function getProposalSignatureStatus()
    {
        return $this->proposal_signature_status;
    }

    /**
     * @param mixed $proposal_signature_status
     */
    public function setProposalSignatureStatus($proposal_signature_status)
    {
        $this->proposal_signature_status = $proposal_signature_status;
    }

    /**
     * @return mixed
     */
    public function getWebLayout()
    {
        //return $this->web_layout;
        return 1;
    }

    /**
     * @param mixed $web_layout
     */
    public function setWebLayout($web_layout)
    {
        $this->web_layout = $web_layout;
    }

    

    /**
     * @return mixed
     */
    public function getIsPreProposalPopup()
    {
        return $this->is_pre_proposal_popup;
    }

    /**
     * @param mixed $is_pre_proposal_popup
     */
    public function setIsPreProposalPopup($is_pre_proposal_popup)
    {
        $this->is_pre_proposal_popup = $is_pre_proposal_popup;
    }
}