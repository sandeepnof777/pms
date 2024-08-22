<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="lead_group_resends")
 */
class LeadGroupResend extends \MY_Model
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
    
    private $account_id;
    /**
     * @ORM\Column(type="integer")
     */
    
    private $company_id;
    /**
     * @ORM\Column(type="string")
     */
    private $account_name;
    /**
     * @ORM\Column(type="string")
     */
    private $ip_address = 0;
    /**
     * @ORM\Column(type="string")
     */
    private $email_content;
    /**
     * @ORM\Column(type="datetime")
     */
    private $created;
   /**
     * @ORM\Column(type="string")
     */
    private $resend_name;
    /**
     * @ORM\Column(type="string")
     */
    private $subject;
    /**
     * @ORM\Column(type="integer")
     */
    private $email_cc;
    
     /**
     * @ORM\Column(type="integer")
     */
    
    private $custom_sender;

     /**
     * @ORM\Column(type="string")
     */
    private $custom_sender_name;
     /**
     * @ORM\Column(type="string")
     */
    private $custom_sender_email;
     /**
     * @ORM\Column(type="integer")
     */
    
    private $is_deleted =0;

     /**
     * @ORM\Column(type="integer")
     */
    
    private $parent_resend_id;
    /**
     * @ORM\Column(type="string")
     */
    private $filters;
    /**
     * @ORM\Column(type="integer")
     */
    
    private $resend_type =0;

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
    public function getAccountName()
    {
        return $this->account_name;
    }

    /**
     * @param mixed $account_name
     */
    public function setAccountName($account_name)
    {
        $this->account_name = $account_name;
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
    public function getCreated()
    {
        return $this->created;
    }
    

    /**
     * @param mixed $created
     */
    public function setCreated($created)
    {
        $this->created = $created;
    }


    /**
     * @return mixed
     */
    public function getResendName()
    {
        return $this->resend_name;
    }
    

    /**
     * @param mixed $resend_name
     */
    public function setResendName($resend_name)
    {
        $this->resend_name = $resend_name;
    }

    /**
     * @return mixed
     */
    public function getSubject()
    {
        return $this->subject;
    }
    

    /**
     * @param mixed $subject
     */
    public function setSubject($subject)
    {
        $this->subject = $subject;
    }

    /**
     * @return mixed
     */
    public function getEmailCc()
    {
        return $this->email_cc;
    }
    

    /**
     * @param mixed $email_cc
     */
    public function setEmailCc($email_cc)
    {
        $this->email_cc = $email_cc;
    }

    /**
     * @return mixed
     */
    public function getCustomSender()
    {
        return $this->custom_sender;
    }
    

    /**
     * @param mixed $custom_sender
     */
    public function setCustomSender($custom_sender)
    {
        $this->custom_sender = $custom_sender;
    }

    /**
     * @return mixed
     */
    public function getCustomSenderName()
    {
        return $this->custom_sender_name;
    }
    

    /**
     * @param mixed $custom_sender_name
     */
    public function setCustomSenderName($custom_sender_name)
    {
        $this->custom_sender_name = $custom_sender_name;
    }

    /**
     * @return mixed
     */
    public function getCustomSenderEmail()
    {
        return $this->custom_sender_email;
    }
    

    /**
     * @param mixed $custom_sender_email
     */
    public function setCustomSenderEmail($custom_sender_email)
    {
        $this->custom_sender_email = $custom_sender_email;
    }

    /**
     * @return mixed
     */
    public function getIsDeleted()
    {
        return $this->is_deleted;
    }
    

    /**
     * @param mixed $is_deleted
     */
    public function setIsDeleted($is_deleted)
    {
        $this->is_deleted = $is_deleted;
    }

    /**
     * @return mixed
     */
    public function getParentResendId()
    {
        return $this->parent_resend_id;
    }
    

    /**
     * @param mixed $parent_resend_id
     */
    public function setParentResendId($parent_resend_id)
    {
        $this->parent_resend_id = $parent_resend_id;
    }
    
    /**
     * @return mixed
     */
    public function getFilters()
    {
        return $this->filters;
    }
    

    /**
     * @param mixed $filters
     */
    public function setFilters($filters)
    {
        $this->filters = $filters;
    }

    /**
     * @return mixed
     */
    public function getResendType()
    {
        return $this->resend_type;
    }
    

    /**
     * @param mixed $resend_type
     */
    public function setResendType($resend_type)
    {
        $this->resend_type = $resend_type;
    }
    
}