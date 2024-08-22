<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="estimation_plants")
 */
class EstimationPlant extends \MY_Model {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column (type="integer", nullable=false)
     */
    private $company_id;

    /**
     * @ORM\Column (type="string", nullable=false)
     */
    private $company_name;

    /**
     * @ORM\Column (type="string", nullable=false)
     */
    private $name;

    /**
     * @ORM\Column (type="integer", nullable=false)
     */
    private $deleted = 0;

    /**
     * @ORM\Column (type="string", nullable=false)
     */
    private $address;

    /**
     * @ORM\Column (type="string", nullable=false)
     */
    private $city;

    /**
     * @ORM\Column (type="string", nullable=false)
     */
    private $state;

    /**
     * @ORM\Column (type="string", nullable=false)
     */
    private $zip;
    /**
     * @ORM\Column (type="string", nullable=false)
     */
    private $phone;

    /**
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $lat;
    /**
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $lng;

    /**
     * @ORM\Column (type="integer", nullable=false)
     */
    private $ord;
    /**
     * @ORM\Column (type="integer", nullable=true)
     */
    private $plants;
    /**
     * @ORM\Column (type="integer", nullable=true)
     */
    private $dumps;
    
    /**
     * @ORM\Column(type="decimal", precision=10, scale=2)
     */
    private $price_rate = 0.00;
    /* Constructor */
    function __construct() {

    }

    /* Getters and Setters */

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
    public function getCompanyName()
    {
        return $this->company_name;
    }

    /**
     * @param mixed $company_name
     */
    public function setCompanyName($company_name)
    {
        $this->company_name = $company_name;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @return mixed
     */
    public function getDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param mixed $deleted
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;
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
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * @param mixed $lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * @return mixed
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     * @param mixed $lng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    /**
     * @return mixed
     */
    public function getOrd()
    {
        return $this->ord;
    }

    /**
     * @param mixed $ord
     */
    public function setOrd($ord)
    {
        $this->ord = $ord;
    }

    /**
     * @return mixed
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * @param mixed $phone
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;
    }

    /**
     * @return mixed
     */
    public function getPlant()
    {
        return $this->plants;
    }

    /**
     * @param mixed $plants
     */
    public function setPlant($plants)
    {
        $this->plants = $plants;
    }

    /**
     * @return mixed
     */
    public function getDump()
    {
        return $this->dumps;
    }

    /**
     * @param mixed $dumps
     */
    public function setDump($dumps)
    {
        $this->dumps = $dumps;
    }

    /**
     * @return mixed
     */
    public function getPriceRate()
    {
        return $this->price_rate;
    }

    /**
     * @param mixed $price_rate
     */
    public function setPriceRate($price_rate)
    {
        $this->price_rate = $price_rate;
    }

    /* End Getters & Setters */

}
