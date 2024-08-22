<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="proposal_preview_links")
 */
class ProposalPreviewLink extends \MY_Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="string",nullable=true)
     */
    private $uuid;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $proposal_id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $email;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $active;

    /**
     * @ORM\Column(type="string")
     */
    private $created_at;

    /**
     * @ORM\Column(type="string")
     */
    private $expires;
    /**
     * @ORM\Column(type="integer")
     */
    private $no_tracking = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $client_link = 0;
     /**
     * @ORM\Column(type="integer")
     */
    private $old_link = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $signature_link = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $log_id;

    function __construct()
    {
        $this->active = 1;
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
    public function getUuid()
    {
        return $this->uuid;
    }

    /**
     * @param mixed $uuid
     */
    public function setUuid($uuid)
    {
        $this->uuid = $uuid;
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
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

     /**
     * @return mixed
     */
    public function getActive()
    {
        return $this->active;
    }

    /**
     * @param mixed $active
     */
    public function setActive($active)
    {
        $this->active = $active;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * @param mixed $expires
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;
    }

    /**
     * @return mixed
     */
    public function getNoTracking()
    {
        return $this->no_tracking;
    }

    /**
     * @param mixed $no_tracking
     */
    public function setNoTracking($no_tracking)
    {
        $this->no_tracking = $no_tracking;
    }

    /**
     * @return mixed
     */
    public function getClientLink()
    {
        return $this->client_link;
    }
    /**
     * @param mixed $client_link
     */
    public function setClientLink($client_link)
    {
        $this->client_link = $client_link;
    }


    /**
     * @param mixed $old_link
     */
    public function setOldLink($old_link)
    {
        $this->old_link = $old_link;
    }

    /**
     * @return mixed
     */
    public function getOldLink()
    {
        return $this->old_link;
    }

    /**
     * @param mixed $signature_link
     */
    public function setSignatureLink($signature_link)
    {
        $this->signature_link = $signature_link;
    }

    /**
     * @return mixed
     */
    public function getSignatureLink()
    {
        return $this->signature_link;
    }
    
    /**
     * @param mixed $log_id
     */
    public function setLogId($log_id)
    {
        $this->log_id = $log_id;
    }

    /**
     * @return mixed
     */
    public function getLogId()
    {
        return $this->log_id;
    }
    /**
     * @return string
     */
    public function getUrl(): string
    {
        return site_url('proposal/' . $this->getUuid());
    }
}