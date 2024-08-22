<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="proposal_automatic_resends")
 */
class ProposalAutomaticResend extends \MY_Model
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

    private $proposal_id;
    /**
     * @ORM\Column(type="integer")
     */

    private $event_id;
    /**
     * @ORM\Column(type="string")
     */
    private $email_content;
   
    /**
     * @ORM\Column(type="datetime")
     */
    private $delivered_at;
    
    /**
     * @ORM\Column(type="datetime")
     */
    private $clicked_at;
    /**
     * @ORM\Column(type="datetime")
     */
    private $opened_at;
    
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
    public function getEventId()
    {
        return $this->event_id;
    }

    /**
     * @param mixed $event_id
     */
    public function setEventId($event_id)
    {
        $this->event_id = $event_id;
    }

    /**
     * @return mixed
     */
    public function getEmailContent()
    {
        return $this->email_content;
    }

    /**
     * @param mixed $email_content
     */
    public function setEmailContent($email_content)
    {
        $this->email_content = $email_content;
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