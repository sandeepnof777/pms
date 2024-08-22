<?php

namespace models;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="prospects")
 */
class Prospects extends \MY_Model {
    /**
     * @ORM\Id            `
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $prospectId;
    /**
     * @ORM\Column (type="integer", nullable=true)
     */
    private $account;
    /**
     * @ORM\Column (type="integer", nullable=true)
     */
    private $company;
    /**
     * @ORM\Column (type="string", length=45, nullable=true)
     */
    private $firstName;
    /**
     * @ORM\Column (type="string", length=45, nullable=true)
     */
    private $lastName;
    /**
     * @ORM\Column (type="string", length=45, nullable=true)
     */
    private $companyName;
    /**
     * @ORM\Column (type="string", length=45, nullable=true)
     */
    private $businessPhone;
    /**
     * @ORM\Column (type="string", length=45, nullable=true)
     */
    private $businessPhoneExt;
    /**
     * @ORM\Column (type="string", length=45, nullable=true)
     */
    private $email;
    /**
     * @ORM\Column (type="string", length=45, nullable=true)
     */
    private $cellPhone;
    /**
     * @ORM\Column (type="string", length=45, nullable=true)
     */
    private $fax;
    /**
     * @ORM\Column (type="string", length=45, nullable=true)
     */
    private $address;
    /**
     * @ORM\Column (type="string", length=255, nullable=true)
     */
    private $city;
    /**
     * @ORM\Column (type="string", length=45, nullable=true)
     */
    private $zip;
    /**
     * @ORM\Column (type="string", length=45, nullable=true)
     */
    private $title;
    /**
     * @ORM\Column (type="string", length=45, nullable=true)
     */
    private $state;
    /**
     * @ORM\Column (type="string", length=45, nullable=true)
     */
    private $website;
    /**
     * @ORM\Column (type="string", length=45, nullable=true)
     */
    private $country;
    /**
     * @ORM\Column (type="integer", nullable=true)
     */
    private $created;
    /**
     * @ORM\Column (type="string", length=45, nullable=true)
     */
    private $business;
    /**
     * @ORM\Column (type="string", length=45, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column (type="string", length=45, nullable=true)
     */
    private $rating;

    /**
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $lat;

    /**
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $lng;
    /**
     * @ORM\Column (type="integer", nullable=true)
     */
    private $prospect_source_id;

    /**
    * @ORM\OneToMany(targetEntity="BusinessTypeAssignment", mappedBy="prospect")
    */
    protected $bta;

    function __construct() {
        $this->created = time();
    }

    public function getProspectId() {
        return $this->prospectId;
    }

    public function getAccount() {
        return $this->account;
    }

    public function setAccount($account) {
        $this->account = $account;
    }

    public function getCompany() {
        return $this->company;
    }

    public function setCompany($company) {
        $this->company = $company;
    }

    public function setFirstName($firstName) {
        $this->firstName = ucwords(($firstName));
    }

    public function getFirstName() {
        return htmlspecialchars(ucwords(($this->firstName)), ENT_QUOTES);
    }

    public function getLastName() {
        return htmlspecialchars(ucwords(($this->lastName)), ENT_QUOTES);
    }

    public function getFullName() {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function setLastName($lastName) {
        $this->lastName = ucwords(($lastName));
    }

    public function getCompanyName() {
        return ($this->companyName) ? $this->companyName : 'Residential';
    }

    public function setCompanyName($companyName) {
        $this->companyName = $companyName;
    }

    public function getBusinessPhone($ext = false) {

        if (!$ext) {
            return $this->businessPhone;
        }
        else {
            if (!$this->getBusinessPhoneExt()){
                return $this->businessPhone;
            }
            else {
                return $this->businessPhone . ' Ext: ' . $this->getBusinessPhoneExt();
            }
        }

    }

    public function setBusinessPhone($businessPhone) {
        $this->businessPhone = $businessPhone;
    }

    public function setBusinessPhoneExt($businessPhoneExt) {
        $this->businessPhoneExt = $businessPhoneExt;
    }

    public function getBusinessPhoneExt() {
        return $this->businessPhoneExt;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getCellPhone() {
        return $this->cellPhone;
    }

    public function setCellPhone($cellPhone) {
        $this->cellPhone = $cellPhone;
    }

    public function getFax() {
        return $this->fax;
    }

    public function setFax($fax) {
        $this->fax = $fax;
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

    public function getZip() {
        return $this->zip;
    }

    public function setZip($zip) {
        $this->zip = $zip;
    }

    public function getCountry() {
        return $this->country;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function getCreated($timestamp = false) {
        if (!$timestamp) {
            return date('m/d/Y', $this->created + TIMEZONE_OFFSET);
        } else {
            return $this->created + TIMEZONE_OFFSET;
        }
    }

    public function setCreated($created) {
        $this->created = $created;
    }

    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    public function getState() {
        return $this->state;
    }

    public function setState($state) {
        $this->state = $state;
    }

    public function getWebsite() {
        return $this->website;
    }

    public function setWebsite($website) {
        $this->website = $website;
    }

    public function getBusiness() {
        return $this->business;
    }

    public function setBusiness($business) {
        $this->business = $business;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($status) {
        $this->status = $status;
    }
    public function getRating($ord = false) {
        if (!$ord) {
            return $this->rating;
        }

        switch ($this->rating) {
            case 'Platinum':
                return 1;
                break;

            case 'Gold':
                return 2;
                break;

            case 'Silver':
                return 3;
                break;

            default: return 4;
        }
    }

    public function setRating($rating) {
        $this->rating = $rating;
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
    public function getProspectSourceId()
    {
        return $this->prospect_source_id;
    }

    /**
     * @param mixed $prospect_source_id
     */
    public function setProspectSourceId($prospect_source_id)
    {
        $this->prospect_source_id = $prospect_source_id;
    }

    public function getProspectSourceText()
    {
        if (!$this->getProspectSourceId()) {
            return 'Unknown';
        }

        $prospectSource = $this->doctrine->em->find('models\ProspectSource', $this->getProspectSourceId());
        if ($prospectSource) {
            return $prospectSource->getName();
        }
        return 'Unknown';

    }


    /**
     *   Get the full address string
     *   @return string
     */
    public function getAddressString() {

        $addrString = $this->getAddress();

        if ($this->getCity()) {
            $addrString .= ' ' . $this->getCity();
        }

        if ($this->getState()) {
            $addrString .= ' ' . $this->getState();
        }

        if ($this->getZip()) {
            $addrString .= ' ' . $this->getZip();
        }

        return $addrString;
    }

    function setLatLng() {

        if (strlen($this->getAddressString()) > 8) {

            try {
                $coords = $this->getCoords();

                if ($coords) {
                    $this->setLat($coords['lat']);
                    $this->setLng($coords['lng']);
                }
            }
            catch (\Exception $e) {
                // Do noting
            }

        }

    }

    /**
     *  Return an array with keys 'lat' and 'lng' with the geocoded coordinates if found. Returns NULL if not.
     */
    public function getCoords() {
        $address = $this->getAddressString();

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
        }
        else {
            return null;
        }
    }

    public function isMapped() {
        if ($this->getLat() && $this->getLng()) {
            return true;
        }
        return false;
    }

    /**
     * Retrieve the attached files for this Prospect
     * @return array
     */
    public function getProspectGroupResendEmails()
    {
        $qb = $this->doctrine->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        $qb->select('pgre')
        ->from('\models\ProspectGroupResendEmail', 'pgre')
        ->where('pgre.prospect_id = :prospectId')
        ->setParameter('prospectId', $this->getProspectId());

        return $qb->getQuery()->getResult();
    }

    /**
     *  Delete the Resend emails for this Prospect
     */
    public function deleteProspectGroupResendEmails()
    {
        $prospectGroupResendEmails = $this->getProspectGroupResendEmails();

        // Delete from database and file system
        foreach ($prospectGroupResendEmails as $email) {
            /* @var $image \models\Proposals_images */
            $this->doctrine->em->remove($email);

        }
        $this->doctrine->em->flush();
    }
}