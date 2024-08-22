<?php
namespace models;
use \Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="work_order_addresses")
 */
class Work_order_addresses {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $addressId;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $company;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $created;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $address;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $city;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $state;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $zip;

    /**
     * @ORM\Column(type="string", nullable=true)
     */

    function __construct() {
        $this->created = time();
    }

    public function getAddressId() {
        return $this->addressId;
    }

    public function setAddressId($addressId) {
        $this->addressId = $addressId;
    }

    public function getCreated($timestamp = false) {
        if ($timestamp) {
            return $this->created;
        } else {
            return date('m/d/Y', $this->created + TIMEZONE_OFFSET);
        }
    }

    public function setCreated($created) {
        $this->created = $created;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCompany($company) {
        $this->company = $company;
    }

    public function getAddress() {
        return $this->address;
    }

    public function setAddress($address) {
        $this->address = $address;
    }

    public function getCity() {
        return $this->city;
    }

    public function setCity($city) {
        $this->city = $city;
    }

    public function getState() {
        return $this->state;
    }

    public function setState($state) {
        $this->state = $state;
    }

    public function getZip() {
        return $this->zip;
    }

    public function setZip($zip) {
        $this->zip = $zip;
    }

    public function getFullAddress() {
        return $this->address . ', ' . $this->city . ', ' . $this->state . ', ' . $this->zip;
    }


}