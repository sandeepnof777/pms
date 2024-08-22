<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="attatchments")
 */
class Attatchments
{

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $attatchmentId;

    /**
     * @ORM\ManyToOne (targetEntity="Companies", cascade={"persist"}, inversedBy="attatchments")
     * @ORM\JoinColumn (name="company", referencedColumnName="companyId")
     */
    private $company;

    /**
     * @ORM\Column(type="string")
     */
    private $fileName;

    /**
     * @ORM\Column(type="string")
     */
    private $category;

    /**
     * @ORM\Column(type="string")
     */
    private $filePath;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $include;

    /**
     * @ORM\ManyToMany(targetEntity="Proposals",mappedBy="attatchments")
     */
    private $proposals;

    function __construct()
    {
        $this->proposals = new ArrayCollection();
    }

    public function getAttatchmentId()
    {
        return $this->attatchmentId;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company)
    {
        $this->company = $company;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
    }

    public function getFilePath()
    {
        return $this->filePath;
    }

    public function setFilePath($filePath)
    {
        $this->filePath = $filePath;
    }

    public function getCategory()
    {
        return $this->category;
    }

    public function setCategory($category)
    {
        $this->category = $category;
    }
    
    public function getInclude() {
        return $this->include;
    }
    
    public function setInclude($include) {
        $this->include = $include;
    }
}
