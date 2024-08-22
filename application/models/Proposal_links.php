<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="proposal_links")
 */
class Proposal_links
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $company;
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $proposal;
    /**
     * @ORM\Column(type="string", length=128)
     */
    private $name;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $url;

    function __construct()
    {
    }

    /**
     * Getter for Company
     * @return mixed
     */
    public function getCompany()
    {
        return $this->company;
    }

    /**
     * Setter for Company
     * @var $company
     */
    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * Getter for Proposal
     * @return mixed
     */
    public function getProposal()
    {
        return $this->proposal;
    }

    /**
     * Setter for Proposal
     * @var $proposal
     */
    public function setProposal($proposal)
    {
        $this->proposal = $proposal;
    }

    /**
     * Getter for Name
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Setter for Name
     * @var $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * Getter for URL
     * @return mixed
     */
    public function getURL()
    {
        return $this->url;
    }

    /**
     * Setter for URL
     * @var $url
     */
    public function setURL($url)
    {
        $this->url = $url;
    }

}
