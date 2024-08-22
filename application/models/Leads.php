<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="leads")
 */
class Leads
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $leadId;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $company;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $account;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $created;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $status;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $rating;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $dueDate;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $client;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $companyName;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $firstName;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $lastName;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;
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
    private $businessPhone;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $businessPhoneExt;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $cellPhone;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $fax;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $email;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $website;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $projectName;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $projectAddress;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $projectCity;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $projectState;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $projectZip;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $projectPhone;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $projectPhoneExt;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $projectCellPhone;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $services;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $projectContact;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $source;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $notes;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $convertedTo;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $convertedTime;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $last_activity;
    /**
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $lat;
    /**
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $lng;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $psa_audit_url;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $psa_sms_url;
    /**
     * @ORM\Column(type="integer")
     */
    private $added_by_user_id;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $added_by_user_name;
    
    function __construct()
    {
        $this->created = time();
    }

    public function getLeadId()
    {
        return $this->leadId;
    }

    public function getCreated($timestamp = false)
    {
        if ($timestamp) {
            return $this->created;
        } else {
            return date('m/d/Y', $this->created + TIMEZONE_OFFSET);
        }
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus($status)
    {
        $this->status = $status;
    }

    public function getCompany()
    {
        return $this->company;
    }

    public function setCompany($company)
    {
        $this->company = $company;
    }

    public function getAccount()
    {
        return $this->account;
    }

    public function setAccount($account)
    {
        $this->account = $account;
    }

    public function getDueDate($timestamp = false)
    {
        if ($timestamp) {
            return $this->dueDate;
        } else {
            return date('m/d/Y', $this->dueDate + TIMEZONE_OFFSET);
        }
    }

    public function setDueDate($dueDate)
    {
        $this->dueDate = $dueDate;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function setClient($client)
    {
        $this->client = $client;
    }

    public function getRating()
    {
        return $this->rating;
    }

    public function setRating($rating)
    {
        $this->rating = $rating;
    }

    public function getCompanyName()
    {
        return $this->companyName ? $this->companyName : 'Residential';
    }

    public function setCompanyName($companyName)
    {
        $this->companyName = $companyName;
    }

    public function getFirstName()
    {
        return ucwords(($this->firstName));
    }

    public function setFirstName($firstName)
    {
        $this->firstName = ucwords(($firstName));
    }

    public function getLastName()
    {
        return ucwords(($this->lastName));
    }

    public function setLastName($lastName)
    {
        $this->lastName = ucwords(($lastName));
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function setAddress($address)
    {
        $this->address = $address;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function setCity($city)
    {
        $this->city = $city;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getZip()
    {
        return $this->zip;
    }

    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getWebsite()
    {
        return $this->website;
    }

    public function setWebsite($website)
    {
        $this->website = $website;
    }

    public function getProjectName()
    {
        return $this->projectName;
    }

    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;
    }

    public function getProjectAddress()
    {
        return $this->projectAddress;
    }

    public function setProjectAddress($projectAddress)
    {
        $this->projectAddress = $projectAddress;
    }

    public function getProjectCity()
    {
        return $this->projectCity;
    }

    public function setProjectCity($projectCity)
    {
        $this->projectCity = $projectCity;
    }

    public function getProjectState()
    {
        return $this->projectState;
    }

    public function setProjectState($projectState)
    {
        $this->projectState = $projectState;
    }

    public function getProjectZip()
    {
        return $this->projectZip;
    }

    public function setProjectZip($projectZip)
    {
        $this->projectZip = $projectZip;
    }

    public function getProjectPhone()
    {
        return $this->projectPhone;
    }

    public function setProjectPhone($projectPhone)
    {
        $this->projectPhone = $projectPhone;
    }

    public function getProjectPhoneExt()
    {
        return $this->projectPhoneExt;
    }

    public function setProjectPhoneExt($projectPhoneExt)
    {
        $this->projectPhoneExt = $projectPhoneExt;
    }

    public function getServices()
    {
        return $this->services;
    }

    public function setServices($services)
    {
        $this->services = $services;
    }

    public function getCellPhone()
    {
        return $this->cellPhone;
    }

    public function setCellPhone($cellPhone)
    {
        $this->cellPhone = $cellPhone;
    }

    public function getFax()
    {
        return $this->fax;
    }

    public function setFax($fax)
    {
        $this->fax = $fax;
    }

    public function getBusinessPhone($ext = false)
    {

        if (!$ext) {
            return $this->businessPhone;
        } else {
            if (!$this->getBusinessPhoneExt()) {
                return $this->businessPhone;
            } else {
                return $this->businessPhone . ' Ext: ' . $this->getBusinessPhoneExt();
            }
        }

    }

    public function setBusinessPhone($businessPhone)
    {
        $this->businessPhone = $businessPhone;
    }

    public function setBusinessPhoneExt($businessPhoneExt)
    {
        $this->businessPhoneExt = $businessPhoneExt;
    }

    public function getBusinessPhoneExt()
    {
        return $this->businessPhoneExt;
    }

    /**
     * @return mixed
     */
    public function getProjectCellPhone()
    {
        return $this->projectCellPhone;
    }

    /**
     * @param mixed $projectCellPhone
     */
    public function setProjectCellPhone($projectCellPhone)
    {
        $this->projectCellPhone = $projectCellPhone;
    }

    public function getProjectContact()
    {
        return $this->projectContact;
    }

    public function setProjectContact($projectContact)
    {
        $this->projectContact = $projectContact;
    }

    public function getSource()
    {
        return $this->source;
    }

    public function setSource($source)
    {
        $this->source = $source;
    }

    public function getNotes()
    {
        return $this->notes;
    }

    public function setNotes($notes)
    {
        $this->notes = $notes;
    }

    public function getConvertedTo()
    {
        return $this->convertedTo;
    }

    public function setConvertedTo($convertedTo)
    {
        $this->convertedTo = $convertedTo;
    }

    public function getConverted($timestamp = false)
    {
        if ($timestamp) {
            return $this->convertedTime;
        } else {
            return date('m/d/Y', $this->convertedTime + TIMEZONE_OFFSET);
        }
    }

    public function setConverted($convertedTime)
    {
        $this->convertedTime = $convertedTime;
    }

    public function getFullName()
    {
        return $this->firstName . ' ' . $this->lastName;
    }

    /**
     * @return mixed
     */
    public function getLastActivity()
    {
        return $this->last_activity;
    }

    /**
     *  Set the last activity to the current time
     */
    public function setLastActivity()
    {
        $this->last_activity = time();
    }

    /**
     * Get the latitude value
     * @return mixed
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     *  Set the lat
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
    }

    /**
     * Get the longitude value
     * @return mixed
     */
    public function getLng()
    {
        return $this->lng;
    }

    /**
     *  Set the ng
     */
    public function setLng($lng)
    {
        $this->lng = $lng;
    }

    /**
     * @return mixed
     */
    public function getPsaAuditUrl()
    {
        return $this->psa_audit_url;
    }

    /**
     * @param mixed $psa_audit_url
     */
    public function setPsaAuditUrl($psa_audit_url)
    {
        $this->psa_audit_url = $psa_audit_url;
    }

    /**
     * @return mixed
     */
    public function getPsaSmsUrl()
    {
        return $this->psa_sms_url;
    }

    /**
     * @param mixed $psa_audit_url
     */
    public function setPsaSmsUrl($psa_sms_url)
    {
        $this->psa_sms_url = $psa_sms_url;
    }

     /**
     * @return mixed
     */
    public function getAddedByUserId()
    {
        return $this->added_by_user_id;
    }

    /**
     * @param mixed $added_by_user_id
     */
    public function setAddedByUserId($added_by_user_id)
    {
        $this->added_by_user_id = $added_by_user_id;
    }

    /**
     * @return mixed
     */
    public function getAddedByUserName()
    {
        return $this->added_by_user_name;
    }

    /**
     * @param mixed $added_by_user_name
     */
    public function setAddedByUserName($added_by_user_name)
    {
        $this->added_by_user_name = $added_by_user_name;
    }


    /**
     *   Get the full address string
     * @return string
     */
    public function getAddressString()
    {

        $addrString = $this->getAddress();

        if ($this->getCity()) {
            $addrString .= '. ' . $this->getCity();
        }

        if ($this->getState()) {
            $addrString .= '. ' . $this->getState();
        }

        if ($this->getZip()) {
            $addrString .= '. ' . $this->getZip();
        }

        return $addrString;
    }

    /**
     *   Get the full project address string
     * @return string
     */
    public function getProjectAddressString()
    {

        $addrString = $this->getProjectAddress();

        if ($this->getProjectCity()) {
            $addrString .= ' ' . $this->getProjectCity();
        }

        if ($this->getProjectState()) {
            $addrString .= ' ' . $this->getProjectState();
        }

        if ($this->getProjectState()) {
            $addrString .= ' ' . $this->getProjectZip();
        }

        return $addrString;
    }

    function setLatLng()
    {
        if (strlen($this->getProjectAddressString()) > 8) {

            try {
                $coords = $this->getCoords();

                if ($coords) {
                    $this->setLat($coords['lat']);
                    $this->setLng($coords['lng']);
                }
            } catch (\Exception $e) {
                // Do noting
            }
        }
    }

    /**
     *  Return an array with keys 'lat' and 'lng' with the geocoded coordinates if found. Returns NULL if not.
     */
    public function getCoords()
    {
        $address = $this->getProjectAddressString();

        $curl = new \Ivory\HttpAdapter\CurlHttpAdapter();
        $geocoder = new \Geocoder\Provider\GoogleMaps($curl, null, null, true, $_ENV['GOOGLE_API_SERVER_KEY']);

        $results = $geocoder->geocode($address);

        if ($results->count()) {
            $iterator = $results->getIterator();
            $result = $iterator->current();

            return [
                'lat' => $result->getLatitude(),
                'lng' => $result->getLongitude()
            ];
        } else {
            return null;
        }
    }

    public function isMapped()
    {
        if ($this->getLat() && $this->getLng()) {
            return true;
        }
        return false;
    }

}