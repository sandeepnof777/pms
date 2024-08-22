<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="proposal_group_resend_email")
 */
class ProposalGroupResendEmail extends \MY_Model
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

    private $resend_id;
    /**
     * @ORM\Column(type="integer")
     */

    private $log_id;
    /**
     * @ORM\Column(type="integer")
     */

    private $proposal_id;
    /**
     * @ORM\Column(type="string")
     */
    private $email_address;
    /**
     * @ORM\Column(type="datetime")
     */
    private $delivered_at;
    /**
     * @ORM\Column(type="datetime")
     */
    private $bounced_at;
    /**
     * @ORM\Column(type="integer")
     */
    private $is_open;
    /**
     * @ORM\Column(type="datetime")
     */
    private $clicked_at;
    /**
     * @ORM\Column(type="datetime")
     */
    private $opened_at;
    /**
     * @ORM\Column(type="integer")
     */
    private $proposal_status_id;
     /**
     * @ORM\Column(type="integer")
     */
    private $parent_resend_email_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $is_failed=0;
    /**
     * @ORM\Column(type="datetime")
     */
    private $sent_at;


    function __construct()
    {
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
    public function getResendId()
    {
        return $this->resend_id;
    }

    /**
     * @param mixed $resend_id
     */
    public function setResendId($resend_id)
    {
        $this->resend_id = $resend_id;
    }

    /**
     * @return mixed
     */
    public function getLogId()
    {
        return $this->log_id;
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
    public function getEmailAddress()
    {
        return $this->email_address;
    }


    /**
     * @param mixed $email_address
     */
    public function setEmailAddress($email_address)
    {
        $this->email_address = $email_address;
    }

    /**
     * @return mixed
     */
    public function getDeliveredAt()
    {
        return $this->delivered_at;
    }


    /**
     * @param mixed $delivered_at
     */
    public function setDeliveredAt($delivered_at)
    {
        $this->delivered_at = $delivered_at;
    }

    /**
     * @return mixed
     */
    public function getBouncedAt()
    {
        return $this->bounced_at;
    }


    /**
     * @param mixed $bounced_at
     */
    public function setBouncedAt($bounced_at)
    {
        $this->bounced_at = $bounced_at;
    }

    /**
     * @return mixed
     */
    public function getIsOpen()
    {
        return $this->is_open;
    }


    /**
     * @param mixed $is_open
     */
    public function setIsOpen($is_open)
    {
        $this->is_open = $is_open;
    }

    /**
     * @return mixed
     */
    public function getClickedAt()
    {
        return $this->clicked_at;
    }

    /**
     * @param mixed $clicked_at
     */
    public function setClickedAt($clicked_at)
    {
        $this->clicked_at = $clicked_at;
    }

    /**
     * @return mixed
     */
    public function getOpenedAt()
    {
        return $this->opened_at;
    }

    /**
     * @param mixed $opened_at
     */
    public function setOpenedAt($opened_at)
    {
        $this->opened_at = $opened_at;
    }

    /**
     * @return mixed
     */
    public function getProposalStatusId()
    {
        return $this->proposal_status_id;
    }

    /**
     * @param mixed $proposal_status_id
     */
    public function setProposalStatusId($proposal_status_id)
    {
        $this->proposal_status_id = $proposal_status_id;
    }

    /**
     * @return mixed
     */
    public function getParentResendEmailId()
    {
        return $this->parent_resend_email_id;
    }

    /**
     * @param mixed $parent_resend_email_id
     */
    public function setParentResendEmailId($parent_resend_email_id)
    {
        $this->parent_resend_email_id = $parent_resend_email_id;
    }

    
    /**
     * @return mixed
     */
    public function getIsFailed()
    {
        return $this->is_failed;
    }

    /**
     * @param mixed $is_failed
     */
    public function setIsFailed($is_failed)
    {
        $this->is_failed = $is_failed;
    }

    /**
     * @return mixed
     */
    public function getSentAt()
    {
        return $this->sent_at;
    }

    /**
     * @param mixed $sent_at
     */
    public function setSentAt($sent_at)
    {
        $this->sent_at = $sent_at;
    }
    
}