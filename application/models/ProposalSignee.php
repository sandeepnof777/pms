<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="proposal_signees")
 */
class ProposalSignee
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
     * @ORM\Column(type="integer", nullable=false)
     */
    private $proposal_id;
    /**
     * @ORM\Column(type="integer", nullable=false)
     */
    private $signee_type;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $account_id;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $first_name;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $last_name;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $name;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $title;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $company_name;
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
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $fax;
    /**
     * @ORM\Column(type="string", nullable=false)
     */
    private $email;


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
    public function getSigneeType()
    {
        return $this->signee_type;
    }

    /**
     * @param mixed $signeeType
     */
    public function setSigneeType($signeeType)
    {
        $this->signee_type = $signeeType;
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
    public function getName($nameOnly = false)
    {

        if ($nameOnly) {
            return $this->name;
        }

        // This will work effectively after the migration
        return $this->first_name . ' ' . $this->last_name;
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
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * @param mixed $first_name
     */
    public function setFirstName($first_name): void
    {
        $this->first_name = $first_name;
    }

    /**
     * @return mixed
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * @param mixed $last_name
     */
    public function setLastName($last_name): void
    {
        $this->last_name = $last_name;
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

    /**
     * @return mixed
     */
    public function getFax()
    {
        return $this->fax;
    }

    /**
     * @param mixed $fax
     */
    public function setFax($fax)
    {
        $this->fax = $fax;
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

}