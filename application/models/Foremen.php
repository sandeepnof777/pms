<?php
namespace models;
use \Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="foremen")
 */
class Foremen {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $company;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $name;
     /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $contact;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $email;
    /**
     * @ORM\Column(type="integer")
     */
    private $ord =999;
    /**
     * @ORM\Column(type="integer")
     */
    private $is_deleted =0;
    
    function __construct() {
        $this->created = time();
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCompany($company) {
        $this->company = $company;
    }
    

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    public function getContact() {
        return $this->contact;
    }

    public function setContact($contact) {
        $this->contact = $contact;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getOrd() {
        return $this->ord;
    }

    public function setOrd($ord) {
        $this->ord = $ord;
    }

    public function getIsDeleted() {
        return $this->is_deleted;
    }

    public function setIsDeleted($is_deleted) {
        $this->is_deleted = $is_deleted;
    }
    


}