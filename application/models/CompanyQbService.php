<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="company_qb_services")
 */
class CompanyQbService {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $company_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $service_id;
    /**
     * @ORM\Column (type="string", length=255)
     */
    private $title;
    /**
     * @ORM\Column (type="string", length=255)
     */
    private $QBID;
    /**
     * @ORM\Column (type="string", length=255)
     */
    private $QBSyncToken;
    /**
     * @ORM\Column (type="string", length=255)
     */
    private $QBSyncFlag;
    /**
     * @ORM\Column (type="string")
     */
    private $QBError;
    /**
     * @ORM\Column (type="string")
     */
    private $qb_list_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $synched_at;

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
    public function getServiceId()
    {
        return $this->service_id;
    }

    /**
     * @param mixed $service_id
     */
    public function setServiceId($service_id)
    {
        $this->service_id = $service_id;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title)
    {
        $this->title = $title;
    }

    
    /**
     * @return mixed
     */
    public function getQBID()
    {
        return $this->QBID;
    }

    /**
     * @param mixed $QBID
     */
    public function setQBID($QBID)
    {
        $this->QBID = $QBID;
    }

    /**
     * @return mixed
     */
    public function getQBSyncToken()
    {
        return $this->QBSyncToken;
    }

    /**
     * @param mixed $QBSyncToken
     */
    public function setQBSyncToken($QBSyncToken)
    {
        $this->QBSyncToken = $QBSyncToken;
    }

    /**
     * @return mixed
     */
    public function getQBSyncFlag()
    {
        return $this->QBSyncFlag;
    }

    /**
     * @param mixed $QBSyncFlag
     */
    public function setQBSyncFlag($QBSyncFlag)
    {
        $this->QBSyncFlag = $QBSyncFlag;
    }

    /**
     * @return mixed
     */
    public function getQBError()
    {
        return $this->QBError;
    }

    /**
     * @param mixed $QBError
     */
    public function setQBError($QBError)
    {
        $this->QBError = $QBError;
    }

    /**
     * @return mixed
     */
    public function getQbListId()
    {
        return $this->qb_list_id;
    }

    /**
     * @param mixed $qb_list_id
     */
    public function setQbListId($qb_list_id)
    {
        $this->qb_list_id = $qb_list_id;
    }

    public function getSynchedAt()
    {
        return $this->synched_at;
    }

    public function setSynchedAt($synched_at)
    {
        $this->synched_at = $synched_at;
    }


}