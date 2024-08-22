<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="clients")
 */
class Clients extends \MY_Model
{
    /**
     * @ORM\Id            `
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $clientId;
    /**
     * @ORM\ManyToOne (targetEntity="Accounts", inversedBy="clients")
     * @ORM\JoinColumn (name="account", referencedColumnName="accountId")
     */
    private $account;
    /**
     * @ORM\ManyToOne(targetEntity="ClientCompany", cascade={"persist"}, inversedBy="clients")
     * @ORM\JoinColumn (name="client_account", referencedColumnName="id")
     */
    private $client_account;
    /**
     * @ORM\ManyToOne (targetEntity="Companies", inversedBy="clients", cascade={"persist"})
     * @ORM\JoinColumn (name="company", referencedColumnName="companyId")
     */
    private $company;
    /**
     * @ORM\OneToMany(targetEntity="Proposals", mappedBy="client")
     */
    private $proposals;
    /**
     * @ORM\Column (type="string", length=45)
     */
    private $firstName;
    /**
     * @ORM\Column (type="string", length=45)
     */
    private $lastName;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $companyName;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $businessPhone;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $businessPhoneExt;
    /**
     * @ORM\Column(type="string", length=64)
     */
    private $email;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $cellPhone;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $fax;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $city;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $zip;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $title;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $state;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $website;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $country;
    /**
     * @ORM\Column(type="integer")
     */
    private $created;
    /**
     * @ORM\Column(type="integer")
     */
    private $deleted;
    /**
     * @ORM\Column(type="integer")
     */
    private $quickbooksId;
    /**
     * @ORM\Column(type="integer")
     */
    private $last_activity;


    /*Billing stuff*/


    /**
     * @ORM\Column(type="string", length=45)
     */
    private $billingFirstName;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $billingLastName;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $billingBusinessPhone;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $billingBusinessPhoneExt;
    /**
     * @ORM\Column(type="string", length=64)
     */
    private $billingEmail;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $billingCellPhone;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $billingFax;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $billingAddress;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $billingCity;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $billingZip;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $billingTitle;
    /**
     * @ORM\Column(type="string", length=45)
     */
    private $billingState;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $QBID;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $QBSyncToken;
    /**
     * @ORM\Column(type="integer")
     */
    private $QBSyncFlag;
    /**
     * @ORM\Column(type="string")
     */
    private $QBError;
    /**
     * @ORM\Column(type="integer")
     */
    private $resend_excluded;
    /**
     * @ORM\Column(type="integer")
     */
    private $proposals_count;
    /**
     * @ORM\Column (type="decimal", precision=10, scale=2))
     */
    private $bid_total;
    /**
     * @ORM\Column(type="string")
     */
    private $qb_list_id;
      /**
     * @ORM\Column(type="integer")
     */
    private $synched_at;

    function __construct()
    {
        $this->deleted = 0;
        $this->created = time();
        $this->last_activity = time();
        $this->proposals = new ArrayCollection();
        $this->companyName = 'Residential';
    }

    public function getProposals()
    {
        return $this->proposals;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function setFirstName($firstName)
    {
        $this->firstName = ucwords(($firstName));
    }

    public function getFirstName()
    {
        return htmlspecialchars(ucwords(($this->firstName)), ENT_QUOTES);
    }

    public function getLastName()
    {
        return htmlspecialchars(ucwords(($this->lastName)), ENT_QUOTES);
    }

    public function getFullName()
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    public function setLastName($lastName)
    {
        $this->lastName = ucwords(($lastName));
    }

    public function getCompanyName($trueValue = false, $bold = false)
    {
        $companyName = ($this->companyName) ? $this->companyName : 'Residential';
        if (!$trueValue) {
            if ($companyName == 'Residential') {
                if ($bold) {
                    $companyName = '<b>RES</b> - ' . $this->getFirstName() . ' ' . $this->getLastName();
                } else {
                    $companyName = 'RES - ' . $this->getFirstName() . ' ' . $this->getLastName();
                }
            }
        }
        return $companyName;
    }

    public function checkCompanyName($trueValue = false, $bold = false)
    {
        $companyName = ($this->companyName) ? $this->companyName : 'Residential';
        return $companyName;
    }

    public function setCompanyName($companyName)
    {
        if ($companyName) {
            $this->companyName = $companyName;
        } else {
            $this->companyName = 'Residential';
        }
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

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
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

    public function getZip()
    {
        return $this->zip;
    }

    public function setZip($zip)
    {
        $this->zip = $zip;
    }

    public function getCountry()
    {
        return $this->country;
    }

    public function setCountry($country)
    {
        $this->country = $country;
    }

    public function getCreated()
    {
        return date('d-M-Y', $this->created + TIMEZONE_OFFSET);
    }

    public function setCreated($created)
    {
        $this->created = $created;
    }

    public function safeDelete()
    {
        $this->deleted = 1;
    }

    public function unDelete()
    {
        $this->deleted = 0;
    }

    public function isDeleted()
    {
        return $this->deleted;
    }

    public function setAccount($account)
    {
        $this->account = $account;
    }

    /**
     * @return \models\Accounts
     */
    public function getAccount()
    {
        return $this->account;
    }

    public function setCompany($company)
    {
        $this->company = $company;
    }

    /**
     * @return \models\Companies
     */
    public function getCompany()
    {
        return $this->company;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function getState()
    {
        return $this->state;
    }

    public function setState($state)
    {
        $this->state = $state;
    }

    public function getWebsite()
    {
        return $this->website;
    }

    public function setWebsite($website)
    {
        $this->website = $website;
    }

    public function setQuickbooksId($quickbooksId)
    {
        $this->quickbooksId = $quickbooksId;
    }

    public function getQuickbooksId()
    {
        return $this->quickbooksId;
    }

    /**
     * @return mixed
     */
    public function getLastActivity()
    {
        return $this->last_activity;
    }

    /**
     * Set the activity time to current time
     */
    public function setLastActivity()
    {
        $this->last_activity = time();
    }

    /**
     * @return \models\ClientCompany
     */
    public function getClientAccount()
    {
        return $this->client_account;
    }

    /**
     * @param mixed \models\ClientCompany
     */
    public function setClientAccount($client_account)
    {
        $this->client_account = $client_account;
    }


    public function qbSearchString()
    {
        return $this->getFirstName() . ' ' . $this->getLastName() . ' ' . $this->getCompanyName();
    }

    public static function delete(\models\Clients $client)
    {
        $CI =& get_instance();

        $proposals = $client->getProposals();
        foreach ($proposals as $proposal) {
            $proposalImages = $proposal->getProposalImages();
            foreach ($proposalImages as $proposalImage) {
                $CI->em->remove($proposalImage);
            }
            $proposal->deleteProposalGroupResendEmails();
            $CI->em->flush();
            $CI->em->remove($proposal);
            $CI->em->flush();
        }
        $client->deleteClientGroupResendEmails();
        $CI->em->remove($client);
        $CI->em->flush();
    }

    public function sendMail($subject, $body, $fromName = '', $fromEmail = '')
    {
        // $etp = new \EmailTemplateParser();
        // $etp->setClient($this);
        // $etp->setAccount($this->getAccount());
        // $text = $etp->parse($body);
        // $subject = $etp->parse($subject);

        $emailFromName = ($fromName) ?: $this->getAccount()->getFullName();
        $replyTo = ($fromEmail) ?: $this->getAccount()->getEmail();

        $emailData = [
            'to' => $this->getEmail(),
            'fromName' => $emailFromName,
            'fromEmail' => $replyTo,
            'replyTo' => $replyTo,
            'subject' => $subject,
            'body' => $body,
            'categories' => ['Client Group Action Email'],
        ];

        //$CI =& get_instance();
            
        $this->load->library('jobs');
        
            // Save the opaque image
            $this->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'group_client_resend',$emailData,'test job');
        //$this->getEmailRepository()->send($emailData);
    }

    /*Billing stuff*/
    /**
     * Getter for BillingFirstName
     * @return mixed
     */
    public function getBillingFirstName()
    {
        return $this->billingFirstName;
    }

    /**
     * Setter for BillingFirstName
     * @var $billingFirstName
     */
    public function setBillingFirstName($billingFirstName)
    {
        $this->billingFirstName = $billingFirstName;
    }

    /**
     * Getter for BillingLastName
     * @return mixed
     */
    public function getBillingLastName()
    {
        return $this->billingLastName;
    }

    /**
     * Setter for BillingLastName
     * @var $billingLastName
     */
    public function setBillingLastName($billingLastName)
    {
        $this->billingLastName = $billingLastName;
    }

    /**
     * Getter for BillingBusinessPhone
     * @return mixed
     */
    public function getBillingBusinessPhone()
    {
        return $this->billingBusinessPhone;
    }

    /**
     * Setter for BillingBusinessPhone
     * @var $billingBusinessPhone
     */
    public function setBillingBusinessPhone($billingBusinessPhone)
    {
        $this->billingBusinessPhone = $billingBusinessPhone;
    }

    /**
     * Getter for BillingBusinessPhoneExt
     * @return mixed
     */
    public function getBillingBusinessPhoneExt()
    {
        return $this->billingBusinessPhoneExt;
    }

    /**
     * Setter for BillingBusinessPhoneExt
     * @var $billingBusinessPhoneExt
     */
    public function setBillingBusinessPhoneExt($billingBusinessPhoneExt)
    {
        $this->billingBusinessPhoneExt = $billingBusinessPhoneExt;
    }

    /**
     * Getter for BillingEmail
     * @return mixed
     */
    public function getBillingEmail()
    {
        return $this->billingEmail;
    }

    /**
     * Setter for BillingEmail
     * @var $billingEmail
     */
    public function setBillingEmail($billingEmail)
    {
        $this->billingEmail = $billingEmail;
    }

    /**
     * Getter for BillingCellPhone
     * @return mixed
     */
    public function getBillingCellPhone()
    {
        return $this->billingCellPhone;
    }

    /**
     * Setter for BillingCellPhone
     * @var $billingCellPhone
     */
    public function setBillingCellPhone($billingCellPhone)
    {
        $this->billingCellPhone = $billingCellPhone;
    }

    /**
     * Getter for BillingFax
     * @return mixed
     */
    public function getBillingFax()
    {
        return $this->billingFax;
    }

    /**
     * Setter for BillingFax
     * @var $billingFax
     */
    public function setBillingFax($billingFax)
    {
        $this->billingFax = $billingFax;
    }

    /**
     * Getter for BillingAddress
     * @return mixed
     */
    public function getBillingAddress()
    {
        return $this->billingAddress;
    }

    /**
     * Setter for BillingAddress
     * @var $billingAddress
     */
    public function setBillingAddress($billingAddress)
    {
        $this->billingAddress = $billingAddress;
    }

    /**
     * Getter for BillingCity
     * @return mixed
     */
    public function getBillingCity()
    {
        return $this->billingCity;
    }

    /**
     * Setter for BillingCity
     * @var $billingCity
     */
    public function setBillingCity($billingCity)
    {
        $this->billingCity = $billingCity;
    }

    /**
     * Getter for BillingZip
     * @return mixed
     */
    public function getBillingZip()
    {
        return $this->billingZip;
    }

    /**
     * Setter for BillingZip
     * @var $billingZip
     */
    public function setBillingZip($billingZip)
    {
        $this->billingZip = $billingZip;
    }

    /**
     * Getter for BillingTitle
     * @return mixed
     */
    public function getBillingTitle()
    {
        return $this->billingTitle;
    }

    /**
     * Setter for BillingTitle
     * @var $billingTitle
     */
    public function setBillingTitle($billingTitle)
    {
        $this->billingTitle = $billingTitle;
    }

    /**
     * Getter for billingState
     * @return mixed
     */
    public function getBillingState()
    {
        return $this->billingState;
    }

    /**
     * Setter for billingState
     * @var $billingState
     */
    public function setBillingState($billingState)
    {
        $this->billingState = $billingState;
    }

    /**
     * @return mixed
     */
    public function getQBID()
    {
        return $this->QBID;
    }

    /**
     * @param mixed $QBID
     */
    public function setQBID($QBID)
    {
        $this->QBID = $QBID;
    }

    /**
     * @return mixed
     */
    public function getQBSyncToken()
    {
        return $this->QBSyncToken;
    }

    /**
     * @param mixed $QBSyncToken
     */
    public function setQBSyncToken($QBSyncToken)
    {
        $this->QBSyncToken = $QBSyncToken;
    }

    /**
     * @return mixed
     */
    public function getQBSyncFlag()
    {
        return $this->QBSyncFlag;
    }

    /**
     * @param mixed $QBSyncFlag
     */
    public function setQBSyncFlag($QBSyncFlag)
    {
        $this->QBSyncFlag = $QBSyncFlag;
    }

    /**
     * @return mixed
     */
    public function getQBError()
    {
        return $this->QBError;
    }

    /**
     * @param mixed $QBError
     */
    public function setQBError($QBError)
    {
        $this->QBError = $QBError;
    }

        /**
     * @return mixed
     */
    public function getResendExcluded()
    {
        return $this->resend_excluded;
    }

    /**
     * @param mixed $resend_excluded
     */
    public function setResendExcluded($resend_excluded)
    {
        $this->resend_excluded = $resend_excluded;
    }

    /**
     * @return mixed
     */
    public function getProposalsCount()
    {
        return $this->proposals_count;
    }

    /**
     * @param mixed $proposals_count
     */
    public function setProposalsCount($proposals_count)
    {
        $this->proposals_count = $proposals_count;
    }

    /**
     * @return mixed
     */
    public function getBidTotal()
    {
        return $this->bid_total;
    }

    /**
     * @param mixed $bid_total
     */
    public function setBidTotal($bid_total)
    {
        $this->bid_total = $bid_total;
    }
    
    /**
     * Retrieve the attached files for this proposal
     * @return array
     */
    public function getClientGroupResendEmails()
    {
        $qb = $this->doctrine->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        $qb->select('cgre')
        ->from('\models\ClientGroupResendEmail', 'cgre')
        ->where('cgre.client_id = :clientId')
        ->setParameter('clientId', $this->getClientId());

        return $qb->getQuery()->getResult();
    }

    /**
     *  Delete the Resend emails for this proposal
     */
    public function deleteClientGroupResendEmails()
    {
        $ClientGroupResendEmails = $this->getClientGroupResendEmails();

        // Delete from database and file system
        foreach ($ClientGroupResendEmails as $email) {
            /* @var $image \models\Proposals_images */
            $this->doctrine->em->remove($email);

        }
        $this->doctrine->em->flush();
    }

    /**
     * @return mixed
     */
    public function getQbListId()
    {
        return $this->qb_list_id;
    }

    /**
     * @param mixed $qb_list_id
     */
    public function setQbListId($qb_list_id)
    {
        $this->qb_list_id = $qb_list_id;
    }

    public function getSynchedAt()
    {
        return $this->synched_at;
    }

    public function setSynchedAt($synched_at)
    {
        $this->synched_at = $synched_at;
    }
    
}