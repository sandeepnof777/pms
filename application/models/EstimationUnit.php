<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="estimation_units")
 */
class EstimationUnit
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
    private $name;
    /**
     * @ORM\Column(type="integer")
     */
    private $ord = 999;
    /**
     * @ORM\Column(type="integer")
     */
    private $company_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $unit_type;
    /**
     * @ORM\Column(type="string")
     */
    private $abbr;

    /**
     * @ORM\Column(type="string")
     */
    private $single_name;
    /**
     * @ORM\Column(type="string")
     */
    private $single_abbr;


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
    public function getUnitType()
    {
        return $this->unit_type;
    }

    /**
     * @param mixed $unit_type
     */
    public function setUnitType($unit_type)
    {
        $this->unit_type = $unit_type;
    }

    /**
     * @return mixed
     */
    public function getAbbr()
    {
        return $this->abbr;
    }

    /**
     * @param mixed $abbr
     */
    public function setAbbr($abbr)
    {
        $this->abbr = $abbr;
    }

    /**
     * @return mixed
     */
    public function getSingleName()
    {
        return $this->single_name;
    }

    /**
     * @param mixed $single_name
     */
    public function setSingleName($single_name)
    {
        $this->single_name = $single_name;
    }

    /**
     * @return mixed
     */
    public function getSingleAbbr()
    {
        return $this->single_abbr;
    }

    /**
     * @param mixed $single_abbr
     */
    public function setSingleAbbr($single_abbr)
    {
        $this->single_abbr = $single_abbr;
    }
    
}