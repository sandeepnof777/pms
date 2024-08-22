<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="price_modifications")
 */
class PriceModification {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column (type="integer")
     */
    private $company_id;
    /**
     * @ORM\Column (type="integer")
     */
    private $account_id;
    /**
     * @ORM\Column (type="string")
     */
    private $user_name;
    /**
     * @ORM\Column (type="string")
     */
    private $modifier;
    /**
     * @ORM\Column (type="string")
     */
    private $statuses;
    /**
     * @ORM\Column (type="integer")
     */
    private $proposals_modified;
    /**
     * @ORM\Column (type="datetime")
     */
    private $run_date;
    /**
     * @ORM\Column (type="string")
     */
    private $ip_address;
    /**
     * @ORM\Column (type="string")
     */
    private $additional_info;
    /**
     * @ORM\Column (type="integer")
     */
    private $completed = 0;
    

    function __construct() {

    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
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
    public function getUserName()
    {
        return $this->user_name;
    }

    /**
     * @param mixed $user_name
     */
    public function setUserName($user_name)
    {
        $this->user_name = $user_name;
    }

    /**
     * @return mixed
     */
    public function getModifier()
    {
        return $this->modifier;
    }

    /**
     * @param mixed $modifier
     */
    public function setModifier($modifier)
    {
        $this->modifier = $modifier;
    }

    /**
     * @return mixed
     */
    public function getStatuses()
    {
        return $this->statuses;
    }

    /**
     * @param mixed $statuses
     */
    public function setStatuses($statuses)
    {
        $this->statuses = $statuses;
    }

    /**
     * @return mixed
     */
    public function getProposalsModified()
    {
        return $this->proposals_modified;
    }

    /**
     * @param mixed $proposals_modified
     */
    public function setProposalsModified($proposals_modified)
    {
        $this->proposals_modified = $proposals_modified;
    }

    /**
     * @return mixed
     */
    public function getRunDate()
    {
        return $this->run_date;
    }

    /**
     * @param mixed $run_date
     */
    public function setRunDate($run_date)
    {
        $this->run_date = $run_date;
    }

    /**
     * @return mixed
     */
    public function getIpAddress()
    {
        return $this->ip_address;
    }

    /**
     * @param mixed $ip_address
     */
    public function setIpAddress($ip_address)
    {
        $this->ip_address = $ip_address;
    }

    

    /**
     * @return mixed
     */
    public function getAdditionalInfo()
    {
        return $this->additional_info;
    }

    /**
     * @param mixed $additional_info
     */
    public function setAdditionalInfo($additional_info)
    {
        $this->additional_info = $additional_info;
    }

    /**
     * @return mixed
     */
    public function getCompleted()
    {
        return $this->completed;
    }

    /**
     * @param mixed $completed
     */
    public function setCompleted($completed)
    {
        $this->completed = $completed;
    }

}
