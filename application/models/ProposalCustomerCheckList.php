<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="proposal_customer_check_list")
 */
class ProposalCustomerCheckList extends \MY_Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer")
     */
    private $proposal_id;
     /**
     * @ORM\Column(type="string", length=255)
     */
    private $billing_contact;
    /**
     * @ORM\Column(type="string", length=2048)
     */
    private $billing_address;
    /**
     * @ORM\Column (type="string", length=50)
     */
    private $billing_phone;
    /**
     * @ORM\Column (type="string", length=100)
     */
    private $billing_email;
    /**
     * @ORM\Column (type="string", length=100)
     */
    private $property_owner_name;
    /**
     * @ORM\Column (type="string", length=255)
     */
    private $legal_address;
    /**
     * @ORM\Column (type="string", length=100)
     */
    private $customer_phone;
    /**
     * @ORM\Column (type="string", length=50)
     */
    private $customer_email;
    /**
     * @ORM\Column (type="string", length=50)
     */
    private $onsite_contact;
    /**
     * @ORM\Column (type="string", length=50)
     */
    private $onsite_phone;
    /**
     * @ORM\Column (type="string", length=50)
     */
    private $onsite_email;
       /**
     * @ORM\Column (type="string", length=20)
     */
    private $invoicing_portal;

    /**
     * @ORM\Column(type="string", length=2048)
     */
    private $special_instructions;

   

 


    function __construct()
    {
        $this->load->library('doctrine');
  

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
     * @return mixed proposal_id
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
     * @return mixed billing_contact
     */
    public function getBillingContact()
    {
        return $this->billing_contact;
    }
    
      /**
     * @param mixed $billing_contact
     */
    public function setBillingContact($billing_contact)
    {
        $this->billing_contact = $billing_contact;
    } 

    /**
     * @return mixed $billing_address
     */
    public function getBillingAddress()
    {
        return $this->billing_address;
    }

    /**
     * @param mixed $billing_address
     */
    public function setBillingAddress($billing_address)
    {
        $this->billing_address = $billing_address;
    }
    
      /**
     * @return mixed $billing_phone
     */
    public function getBillingPhone()
    {
        return $this->billing_phone;
    }

    /**
     * @param mixed $billing_phone
     */
    public function setBillingPhone($billing_phone)
    {
        $this->billing_phone = $billing_phone;
    } 

    /**
     * @return mixed $billing_email
     */
    public function getBillingEmail()
    {
        return $this->billing_email;
    }

    /**
     * @param mixed $billing_email
     */
    public function setBillingEmail($billing_email)
    {
        $this->billing_email = $billing_email;
    }
    
    /**
     * @return mixed $property_owner_name
     */
    public function getPropertyOwnerName()
    {
        return $this->property_owner_name;
    }

    /**
     * @param mixed $property_owner_name
     */
    public function setProperyOwnerName($property_owner_name)
    {
        $this->property_owner_name = $property_owner_name;
    } 

  /**
     * @return mixed $legal_address
     */
    public function getLegalAddress()
    {
        return $this->legal_address;
    }

    /**
     * @param mixed $legal_address
     */
    public function setLegalAddress($legal_address)
    {
        $this->legal_address = $legal_address;
    } 

     /**
     * @return mixed $customer_phone
     */
    public function getCustomerPhone()
    {
        return $this->customer_phone;
    }

    /**
     * @param mixed $customer_phone
     */
    public function setCustomerPhone($customer_phone)
    {
        $this->customer_phone = $customer_phone;
    }
    
    /**
     * @return mixed $customer_email
     */
    public function getCustomerEmail()
    {
        return $this->customer_email;
    }

    /**
     * @param mixed $customer_email
     */
    public function setCustomerEmail($customer_email)
    {
        $this->customer_email = $customer_email;
    }


    /**
     * @return mixed $onsite_contact
     */
    public function getOnsiteContact()
    {
        return $this->onsite_contact;
    }

    /**
     * @param mixed $onsite_contact
     */
    public function setOnsiteContact($onsite_contact)
    {
        $this->onsite_contact = $onsite_contact;
    }

     /**
     * @return mixed $onsite_phone
     */
    public function getOnsitePhone()
    {
        return $this->onsite_phone;
    }

    /**
     * @param mixed $onsite_phone
     */
    public function setOnsitePhone($onsite_phone)
    {
        $this->onsite_phone = $onsite_phone;
    }
     
    /**
     * @return mixed $onsite_email
     */
    public function getOnsiteEmail()
    {
        return $this->onsite_email;
    }

    /**
     * @param mixed $onsite_email
     */
    public function setOnsiteEmail($onsite_email)
    {
        $this->onsite_email = $onsite_email;
    }

     /**
     * @return mixed $invoicing_portal
     */
    public function getInvoicingPortal()
    {
        return $this->invoicing_portal;
    }

    /**
     * @param mixed $invoicing_portal
     */
    public function setInvoicingPortal($invoicing_portal)
    {
        $this->invoicing_portal = $invoicing_portal;
    }

         /**
     * @return mixed $special_instructions
     */
    public function getSpecialInstructions()
    {
        return $this->special_instructions;
    }

    /**
     * @param mixed $special_instructions
     */
    public function setSpecialInstructions($special_instructions)
    {
        $this->special_instructions = $special_instructions;
    }

  


}
