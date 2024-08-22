<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="proposal_signatures")
 */
class ProposalSignature extends \MY_Model
{
    const CLIENT = 1;
    const COMPANY = 2;
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
     * @ORM\Column(type="string")
     */
    private $firstname;

    /**
     * @ORM\Column(type="string")
     */
    private $lastname;

    /**
     * @ORM\Column(type="string")
     */
    private $company;

    /**
     * @ORM\Column(type="string")
     */
    private $email;

    /**
     * @ORM\Column(type="string")
     */
    private $title;
    /**
     * @ORM\Column(type="string")
     */
    private $signature_file;
    /**
     * @ORM\Column(type="string")
     */
    private $comments;
    
    /**
     * @ORM\Column(type="string")
     */
    private $ip_address;
    
    /**
     * @ORM\Column(type="string")
     */
    private $created_at;
    /**
     * @ORM\Column(type="integer")
     */

    private $sig_type = self::CLIENT;
    /**
     * @ORM\Column(type="integer")
     */

    private $proposal_link_id;
     /**
     * @ORM\Column(type="integer")
     */

    private $is_deleted = 0;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $address;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $city;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $state;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $zip;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $cell_phone;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $office_phone;

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
    public function getFirstName()
    {
        return $this->firstname;
    }

    /**
     * @param mixed $firstName
     */
    public function setFirstName($firstname)
    {
        $this->firstname = $firstname;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->lastname;
    }

    /**
     * @param mixed $lastname
     */
    public function setLastName($lastname)
    {
        $this->lastname = $lastname;
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
    public function getSignatureFile()
    {
        return $this->signature_file;
    }


    /**
     * @param mixed $signature_file
     */
    public function setSignatureFile($signature_file)
    {
        $this->signature_file = $signature_file;
    }

    /**
     * @return mixed
     */
    public function getComments()
    {
        return $this->comments;
    }


    /**
     * @param mixed $comments
     */
    public function setComments($comments)
    {
        $this->comments = $comments;
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
    public function getCompany()
    {
        return $this->company;
    }


    /**
     * @param mixed $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
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
    public function getSigType()
    {
        return $this->sig_type;
    }


    /**
     * @param mixed $sig_type
     */
    public function setSigType($sig_type)
    {
        $this->sig_type = $sig_type;
    }

    /**
     * @return mixed
     */
    public function getProposalLinkId()
    {
        return $this->proposal_link_id;
    }


    /**
     * @param mixed $proposal_link_id
     */
    public function setProposalLinkId($proposal_link_id)
    {
        $this->proposal_link_id = $proposal_link_id;
    }


    /**
     * @return mixed
     */
    public function getIsdeleted()
    {
        return $this->is_deleted;
    }


    /**
     * @param mixed $is_deleted
     */
    public function setIsdeleted($is_deleted)
    {
        $this->is_deleted = $is_deleted;
    }

     /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
    }

    /**
     * @return mixed
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @param mixed $state
     */
    public function setState($state)
    {
        $this->state = $state;
    }

    /**
     * @return mixed
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * @param mixed $zip
     */
    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    /**
     * @return mixed
     */
    public function getCellPhone()
    {
        return $this->cell_phone;
    }

    /**
     * @param mixed $cell_phone
     */
    public function setCellPhone($cell_phone)
    {
        $this->cell_phone = $cell_phone;
    }

    /**
     * @return mixed
     */
    public function getOfficePhone()
    {
        return $this->office_phone;
    }

    /**
     * @param mixed $office_phone
     */
    public function setOfficePhone($office_phone)
    {
        $this->office_phone = $office_phone;
    }

}