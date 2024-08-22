<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="email_content")
 */
class EmailContent extends \MY_Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="string")
     */

    private $entity;
    /**
     * @ORM\Column(type="integer")
     */

    private $entity_id;
    /**
     * @ORM\Column(type="string")
     */
    private $email_content;
    /**
     * @ORM\Column(type="integer")
     */

    private $event_id;
    /**
     * @ORM\Column(type="datetime")
     */
    private $delivered_at;
    /**
     * @ORM\Column(type="datetime")
     */
    private $bounced_at;
   
    /**
     * @ORM\Column(type="datetime")
     */
    private $opened_at;

     /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;
    /**
     * @ORM\Column(type="string")
     */
    private $email_subject;
    /**
     * @ORM\Column(type="string")
     */

    private $sender_name;
    /**
     * @ORM\Column(type="string")
     */

    private $sender_email;
    /**
     * @ORM\Column(type="string")
     */

    private $to_email;
    
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
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * @param mixed $entity
     */
    public function setEntity($entity)
    {
        $this->entity = $entity;
    }

    /**
     * @return mixed
     */
    public function getEntityId()
    {
        return $this->entity_id;
    }

    /**
     * @param mixed $entity_id
     */
    public function setEntityId($entity_id)
    {
        $this->entity_id = $entity_id;
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
    public function getEmailSubject()
    {
        return $this->email_subject;
    }

    /**
     * @param mixed $email_subject
     */
    public function setEmailSubject($email_subject)
    {
        $this->email_subject = $email_subject;
    }

    /**
     * @return mixed
     */
    public function getSenderName()
    {
        return $this->sender_name;
    }

    /**
     * @param mixed $sender_name
     */
    public function setSenderName($sender_name)
    {
        $this->sender_name = $sender_name;
    }

    /**
     * @return mixed
     */
    public function getSenderEmail()
    {
        return $this->sender_email;
    }

    /**
     * @param mixed $sender_email
     */
    public function setSenderEmail($sender_email)
    {
        $this->sender_email = $sender_email;
    }

    /**
     * @return mixed
     */
    public function getToEmail()
    {
        return $this->to_email;
    }

    /**
     * @param mixed $to_email
     */
    public function setToEmail($to_email)
    {
        $this->to_email = $to_email;
    }

    
    
}