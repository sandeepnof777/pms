<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\DBAL\Query\QueryBuilder;
use Pms\Repositories\ProposalNotifications;
use Ramsey\Uuid\Uuid;

/**
 * @ORM\Entity
 * @ORM\Table(name="proposals", options={"charset": "utf8"})
 */
class Proposals extends \MY_Model
{


    const EMAIL_UNSENT = 1;
    const EMAIL_SENT = 2;
    const EMAIL_EDITED = 3;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $proposalId;
    /**
     * @ORM\Column(type="string")
     */
    private $access_key;
    /**
     * @ORM\ManyToOne(targetEntity="Clients", cascade={"persist"}, inversedBy="proposals")
     * @ORM\JoinColumn (name="client", referencedColumnName="clientId")
     */
    private $client;
    /**
     * @ORM\OneToMany(targetEntity="Proposals_items", mappedBy="proposal", cascade={"persist"})
     */
    private $proposalItems;
    /**
     * @ORM\OneToMany(targetEntity="Proposals_images", mappedBy="proposal", cascade={"persist"})
     * @ORM\OrderBy ({"ord" = "ASC"})
     */
    private $proposalImages;
    /**
     * @ORM\Column(type="string")
     */
    private $projectName;
    /**
     * @ORM\Column(type="string")
     */
    private $projectAddress;
    /**
     * @ORM\Column(type="string")
     */
    private $projectCity;
    /**
     * @ORM\Column(type="string")
     */
    private $projectState;
    /**
     * @ORM\Column(type="string")
     */
    private $projectZip;
    /**
     * @ORM\Column(type="string")
     */
    private $status;
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
    private $paymentTerm;
    /**
     * @ORM\ManyToMany(targetEntity="Attatchments", inversedBy="proposals")
     * @ORM\JoinTable(name="proposals_attatchments",
     *   joinColumns={@ORM\JoinColumn(name="proposal", referencedColumnName="proposalId")},
     *   inverseJoinColumns={@ORM\JoinColumn(name="attatchment", referencedColumnName="attatchmentId")}
     * )
     */
    private $attatchments;
    /**
     * @ORM\Column(type="string")
     */
    private $proposalTitle;
    /**
     * @ORM\Column(type="string")
     */
    private $videoURL;
    /**
     * @ORM\Column(type="string")
     */
    private $thumbImageURL;
    /**
     * @ORM\Column(type="integer")
     */
    private $rebuildFlag;
    /**
     * @ORM\Column(type="string", length=2048)
     */
    private $texts;
    /**
     * @ORM\Column(type="string", length=2048)
     */
    private $texts_categories;
    /**
     * @ORM\Column(type="string")
     */
    private $layout;
    /**
     * @ORM\Column(type="string")
     */
    private $paymentTermText;
    /**
     * @ORM\Column(type="string")
     */
    private $contractCopy;
    /**
     * @ORM\Column(type="string")
     */
    private $jobNumber;
    /**
     * @ORM\Column(type="integer")
     */
    private $duplicateOf;
    /**
     * @ORM\Column(type="float")
     */
    private $price;
    /**
     * @ORM\Column(type="integer")
     */
    private $approvalQueue;
    /**
     * @ORM\Column(type="integer")
     */
    private $declined;

    /**
     * @ORM\Column(type="integer")
     */
    private $images_layout;
    /**
     * @ORM\ManyToOne(targetEntity="Status", cascade={"persist"})
     * @ORM\JoinColumn (name="proposalStatus", referencedColumnName="id")
     * @var
     */
    private $proposalStatus;
    /**
     * @ORM\Column(type="integer")
     */
    private $statusChangeDate;
    /**
     * @ORM\Column(type="integer")
     */
    private $last_activity;
    /**
     * @ORM\Column(type="integer")
     */
    private $email_status;
    /**
     * @ORM\Column(type="integer")
     */
    private $deliveryTime;
    /**
     * @ORM\Column(type="integer")
     */
    private $lastOpenTime;
    /**
     * @ORM\Column(type="integer")
     */
    private $emailSendTime;
    /**
     * @ORM\ManyToOne(targetEntity="Accounts", cascade={"persist"}, inversedBy="proposals")
     * @ORM\JoinColumn (name="owner", referencedColumnName="accountId")
     */
    private $owner;
    /**
     * @ORM\Column (type="string")
     */
    private $header_font;
    /**
     * @ORM\Column (type="string")
     */
    private $text_font;
    /**
     * @ORM\Column (type="string")
     */
    private $gradient_opacity;
    /**
     * @ORM\Column (type="string")
     */
    private $header_bg_color;
    /**
     * @ORM\Column (type="string")
     */
    private $header_bg_opacity;
    /**
     * @ORM\Column (type="string")
     */
    private $header_font_color;
    /**
     * @ORM\Column (type="string")
     */
    private $audit_key;
    /**
     * @ORM\Column (type="integer")
     */
    private $audit_view_time;

    /**
     * @ORM\Column (type="integer")
     */
    private $resend_enabled;

    /**
     * @ORM\Column (type="string")
     */
    private $resend_frequency;

    /**
     * @ORM\Column (type="integer")
     */
    private $resend_template;

    private $resendSettings = null;
    /**
     * @ORM\Column (type="integer")
     */
    private $audit_reminder_sent;
    /**
     * @ORM\Column (type="integer")
     */
    private $win_date;
    /**
     * @ORM\Column (type="integer")
     */
    private $unapproved_services;
    /**
     * @ORM\Column (type="string", length=255)
     */
    private $QBID;
    /**
     * @ORM\Column (type="string", length=255)
     */
    private $QBSyncToken;
    /**
     * @ORM\Column (type="string", length=255)
     */
    private $QBSyncFlag;
    /**
     * @ORM\Column (type="string")
     */
    private $QBError;
    /**
     * @ORM\Column (type="string")
     */
    private $invoice_status;
    /**
     * @ORM\Column (type="decimal", precision=10, scale=2))
     */
    private $invoice_amount;
    /**
     * @ORM\Column (type="integer")
     */
    private $approved;
    /**
     * @ORM\Column (type="string")
     */
    private $work_order_notes;
    /**
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $lat;
    /**
     * @ORM\Column(type="decimal", nullable=true)
     */
    private $lng;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $geocoded;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $inventory_location_id;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $inventory_report_url;
    /**
     * @ORM\Column (type="string")
     */
    private $estimate_notes;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $estimate_calculation_type = 1;
    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $estimate_status_id = 1;
    /**
     * @ORM\Column (type="decimal", precision=5, scale=2))
     */
    private $estimate_oh_rate;
     /**
     * @ORM\Column (type="decimal", precision=5, scale=2))
     */
    private $estimate_pm_rate;
    /**
     * @ORM\Column (type="string")
     */
    private $work_order_layout_type;
    /**
     * @ORM\Column(type="integer")
     */
    private $group_template_item = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $job_cost_status = 0;

    /**
     * @ORM\Column(type="string")
     */
    private $job_cost_username;
    /**
     * @ORM\Column(type="string")
     */
    private $job_cost_notes;
    /**
     * @ORM\Column(type="string")
     */
    private $job_cost_completed_at;

     /**
     * @ORM\Column(type="string")
     */
    private $job_cost_signature_file;

    /**
     * @ORM\Column(type="string")
     */
    private $proposal_uuid;
    /**
     *  @ORM\Column (type="decimal", precision=5, scale=2))
     */
    private $profit_margin_percent;
     /**
     *  @ORM\Column (type="decimal", precision=10, scale=2))
     */
    private $profit_margin_value;
    
    /**
     * @ORM\Column(type="integer")
     */
    private $job_cost_foremen_id = NULL;
    /**
     * @ORM\Column(type="string")
     */
    private $actual_created_date;
    /**
     * @ORM\Column(type="integer")
     */
    private $converted_from = NULL;

    /**
     * @ORM\Column(type="integer")
     */
    private $proposal_background = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $is_show_proposal_logo = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $image_count;
    /**
     * @ORM\Column(type="integer")
     */
    private $is_hidden_to_view = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $is_demo = 0;
     /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $business_type_id = null;
    /**
     * @ORM\Column(type="integer")
     */
    private $resend_excluded = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $note_count = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $company_id = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $signature_id = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $proposal_view_count = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $is_pre_proposal_popup = 1;
    /**
     * @ORM\Column(type="integer")
     */
    private $company_signature_id = 0;

    /**
     * @ORM\Column(type="integer")
     */
    private $synched_at;
    /**
     * @ORM\Column(type="integer")
     */
    private $work_order_setting;
    /**
     * @ORM\Column(type="integer")
     */
    private $invoice_date;
   
    
    function __construct()
    {
        $this->deleted = 0;
        $this->created = time();
        $this->status = 'Open';
        $this->attatchments = new ArrayCollection();
        $this->proposalImages = new ArrayCollection();
        $this->paymentTerm = 0;
        $this->rebuildFlag = 1;
        $this->is_pre_proposal_popup =1;
        $this->approvalQueue = 0;
        $this->image_count = 0;
        $this->last_activity = time();
    }

    public function getProposalId()
    {
        return $this->proposalId;
    }

    public function getAccessKey()
    {
        return $this->access_key;
    }

    public function setAccessKey($demo = false)
    {
        $uuid =  Uuid::uuid4();
        $key =  str_replace(['-'], [''], $uuid);

        if($demo) {
            $key = 'demo_' . $key;
        }

        $this->access_key = $key;
    }

    /**
     * @return \models\Clients
     */
    public function getClient()
    {
        return $this->client;
    }

    public function setClient($client)
    {
        $this->client = $client;
    }

    public function getProjectName()
    {
        return $this->projectName;
    }

    public function setProjectName($projectName)
    {
        $this->projectName = $projectName;
        $this->last_activity = time();
    }

    public function getProjectAddress()
    {
        return $this->projectAddress;
    }

    public function setProjectAddress($projectAddress)
    {
        $this->projectAddress = $projectAddress;
        $this->last_activity = time();
    }

    public function getProjectCity()
    {
        return $this->projectCity;
    }

    public function setProjectCity($projectCity)
    {
        $this->projectCity = $projectCity;
        $this->last_activity = time();
    }

    public function getProjectState()
    {
        return $this->projectState;
    }

    public function setProjectState($projectState)
    {
        $this->projectState = $projectState;
        $this->last_activity = time();
    }

    public function getProjectZip()
    {
        return $this->projectZip;
        $this->last_activity = time();
    }

    public function setProjectZip($projectZip)
    {
        $this->projectZip = $projectZip;
        $this->last_activity = time();
    }


    public function getCreated($date = true)
    {
        if ($date) {
            return date('m/d/Y', $this->created + TIMEZONE_OFFSET);
        } else {
            return $this->created;
        }
    }

    public function setCreated($created)
    {
        $this->created = $created;
        $this->last_activity = time();
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

    public function getStatus()
    {
        return $this->proposalStatus->getStatusId();
    }

    public function getStatusText()
    {
        return $this->proposalStatus->getStatusText();
    }

    public function setStatus($statusId)
    {
        $CI =& get_instance();

        //$this->status = $status;
        $status = $CI->em->find('\models\Status', $statusId);

        $this->setProposalStatus($status);
        $this->last_activity = time();
    }

    public function getProposalImages()
    {
        return $this->proposalImages;
    }

    public function addImage($image)
    {
        if (!$this->proposalImages->contains($image)) {
            $this->proposalImages->add($image);
            $this->last_activity = time();
        }
    }

    public function removeImage($image)
    {
        $this->proposalImages->removeElement($image);
        $this->last_activity = time();
    }

    public function getProposalItems()
    {
        return $this->proposalItems;
    }

    public function getAttatchments()
    {
        $attachmentArray = Array();
        $proposalAttachments = $this->attatchments;
        foreach ($proposalAttachments as $attachment) {
            $attachmentArray[$attachment->getFileName() . $attachment->getAttatchmentId()] = $attachment;
        }
        ksort($attachmentArray);
        return $attachmentArray;
    }

    public function addAttatchment($attatchment)
    {
        if (!$this->attatchments->contains($attatchment)) {
            $this->attatchments->add($attatchment);
            $this->setLastActivity();
        }
    }

    public function removeAttatchment($attatchment)
    {
        $this->attatchments->removeElement($attatchment);
        $this->setLastActivity();
    }

    public function getPaymentTerm()
    {
        return $this->paymentTerm;
    }

    public function setPaymentTerm($paymentTerm)
    {
        $this->paymentTerm = $paymentTerm;
    }

    public function getTotalPrice($number = true)
    {
        $price = 0;
        foreach ($this->getProposalItems() as $pi) {
            $price += $pi->getPrice(true);
        }
        if (new_system($this->getCreated(false))) {
            //include the prices of the services
            $price += getServiceTotalPrice($this->getProposalId());
        }
        if ($number) {
            return $price;
        } else {
            return number_format($price);
        }
    }

    public function getProposalTitle()
    {
        return $this->proposalTitle;
    }

    public function setProposalTitle($proposalTitle)
    {
        $this->proposalTitle = $proposalTitle;
        $this->last_activity = time();
    }

    public function getVideoURL()
    {
        return $this->videoURL;
    }

    public function setVideoURL($videoUrl)
    {
        $this->videoURL = $videoUrl;
        $this->last_activity = time();
    }

    
    public function getThumbImageURL()
    {
        return $this->thumbImageURL;
    }

    public function setThumbImageURL($thumbImageURL)
    {
        $this->thumbImageURL = $thumbImageURL;
    }

    public function getRebuildFlag()
    {
        return $this->rebuildFlag;
    }

    public function setRebuildFlag($rebuildFlag, $lastActivity = true, $emailStatus = true, $deleteWorkOrder = true)
    {
        $this->rebuildFlag = $rebuildFlag;

        // Update the last activity time of this proposal
        if ($lastActivity) {
            if ($rebuildFlag > 0) {
                $this->setLastActivity();
            }
        }
        // Update the email status of this proposal
        if ($emailStatus) {
            if ($rebuildFlag > 0) {
                $this->rebuildEmailStatus();
            }
        }

        // Set an update flag if there's a QB ID
        if ($this->getQBID()) {
            $this->setQBSyncFlag(3);
        }

        // Delete the work order cache file
        if ($deleteWorkOrder) {
            $cache_file = CACHEDIR . '/proposals/work_order/plproposal_' . $this->getAccessKey() . '.pdf';
            //check if file exists
            if(file_exists($cache_file)){
                unlink($cache_file);
            }
        }
    }

    public function needsRebuild()
    {
        return $this->rebuildFlag;
    }

    public function getTexts($type = 'array')
    {
        if ($type == 'array') {
            return explode(',', $this->texts);
        }
        return $this->texts;
    }

    public function setTexts($texts)
    {
        $this->texts = $texts;
        $this->last_activity = time();
    }

    public function getTextsCategories($type = 'array')
    {
        if ($type == 'array') {
            $textcats = array();
            $cats = explode('|', $this->texts_categories);
            foreach ($cats as $cat) {
                $cat = explode(':', $cat);
                if (@$cat[0]) {
                    $textcats[$cat[0]] = @$cat[1];
                }
            }
            return $textcats;
        }
        return $this->texts_categories;
    }

    public function setTextsCategories($texts_categories)
    {
        $this->texts_categories = $texts_categories;
        $this->last_activity = time();
    }
    public function getLayout()
    {
        
        return $this->layout ?: $this->getOwner()->getLayout();
    }

    public function getNewLayout()
    {
        $layout = $this->layout ?: $this->getOwner()->getLayout();

        //If web-proposal on
        if($_ENV['WEB_PROPOSAL']=='ON'){
            // if($layout == 'gradient'){
            //     return 'web-custom';
            // }
            $layout = str_replace("gradient","custom",$layout);
            if(strpos($layout, 'web-') !== false){
                return $layout;
            }else{
                return 'web-'.$layout;
            }
            
        }else{
            return $layout;
        }
       
    }

    public function setLayout($layout)
    {
        $this->layout = $layout;
        $this->last_activity = time();
    }

    public function getPaymentTermText()
    {
        return $this->paymentTermText;
    }

    public function setPaymentTermText($paymentTermText)
    {
        $this->paymentTermText = $paymentTermText;
        $this->last_activity = time();
    }

    public function getContractCopy()
    {
        return $this->contractCopy;
    }

    public function setContractCopy($contractCopy)
    {
        $this->contractCopy = $contractCopy;
        $this->last_activity = time();
    }

    public function getJobNumber()
    {
        return $this->jobNumber;
    }

    public function setJobNumber($jobNumber)
    {
        $this->jobNumber = $jobNumber;
        $this->last_activity = time();
    }

    public function getDuplicateOf()
    {
        return $this->duplicateOf;
    }

    public function setDuplicateOf($duplicateOf)
    {
        $this->duplicateOf = $duplicateOf;
    }

    public function getPrice($number = true)
    {
        if (!$number) {
            return number_format($this->price);
        } else {
            return $this->price;
        }
    }

    public function setPrice($price)
    {
        $this->price = floatval($price);
        $this->last_activity = time();
    }

    function inApprovalQueue()
    {
        return $this->approvalQueue;
    }

    public function setApprovalQueue($approvalQueue)
    {
        $this->approvalQueue = $approvalQueue;
        $this->last_activity = time();
    }

    function isDeclined()
    {
        return $this->declined;
    }

    public function setDeclined($declined)
    {
        $this->declined = $declined;
        $this->last_activity = time();
    }

    public function getImagesLayout()
    {
        return $this->images_layout;
    }

    public function setImagesLayout($images_layout)
    {
        $this->images_layout = $images_layout;
        $this->last_activity = time();
    }

    public function getServices()
    {

        $CI =& get_instance();

        $proposalServices = $CI->em->createQuery('select ps from models\Proposal_services ps where ps.proposal=' . $this->getProposalId() . ' order by ps.ord, ps.serviceId')->getResult();

        return $proposalServices;
    }

    public function getNonHiddenServices()
    {

        $CI =& get_instance();

        $proposalServices = $CI->em->createQuery('select ps from models\Proposal_services ps where ps.proposal=' . $this->getProposalId() . ' AND ps.is_hide_in_proposal = 0  order by ps.ord, ps.serviceId')->getResult();

        return $proposalServices;
    }

    public function getOptionalServices()
    {

        $CI =& get_instance();

        $proposalServices = $CI->em->createQuery('select ps from models\Proposal_services ps where ps.proposal=' . $this->getProposalId() . 'AND ps.optional = 1 order by ps.ord, ps.serviceId')->getResult();

        return $proposalServices;
    }

    function getStatusChangeDate()
    {
        return $this->statusChangeDate;
    }

    function setStatusChangeDate($newDate)
    {
        $this->statusChangeDate = $newDate;
        $this->last_activity = time();
    }

    /**
     * @return mixed
     */
    public function getLastActivity()
    {
        return $this->last_activity;
    }

    /**
     * Sets the last activity to current timestamp
     */
    public function setLastActivity()
    {
        $this->last_activity = time();
        $client = $this->getClient();
        if ($client) {
            $client->setLastActivity();
        }
    }

    /**
     * Retrieve the attached files for this proposal
     * @return array
     */
    public function getAttachedFiles()
    {
        $qb = $this->doctrine->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        $qb->select('pa')
            ->from('\models\Proposal_attachments', 'pa')
            ->where('pa.proposalId = :proposalId')
            ->orderBy('pa.ord', 'ASC')
            ->setParameter('proposalId', $this->getProposalId());

        return $qb->getQuery()->getResult();
    }

    /**
     * @return mixed
     */
    public function getEmailStatus()
    {
        return $this->email_status;
    }

    /**
     * @param mixed $email_status
     */
    public function setEmailStatus($email_status)
    {
        $this->email_status = $email_status;
    }

    /**
     * @return mixed
     */
    public function getDeliveryTime()
    {
        return $this->deliveryTime;
    }

    /**
     * @param mixed $deliveryTime
     */
    public function setDeliveryTime($deliveryTime)
    {
        $this->deliveryTime = $deliveryTime;
    }

    /**
     * @return mixed
     */
    public function getLastOpenTime()
    {
        return $this->lastOpenTime;
    }

    /**
     *
     */
    public function setLastOpenTime($lastOpenTime)
    {
        $this->lastOpenTime = $lastOpenTime;
    }

    /**
     * @return mixed
     */
    public function getEmailSendTime()
    {
        return $this->emailSendTime;
    }

    /**
     * @param mixed $emailSendTime
     */
    public function setEmailSendTime($emailSendTime)
    {
        $this->emailSendTime = $emailSendTime;
    }

    /**
     * @return \models\Accounts
     */
    public function getOwner()
    {
        return $this->owner;
    }

    /**
     * @param \models\Accounts $owner
     */
    public function setOwner($owner)
    {
        $this->owner = $owner;
    }

    /**
     * @return mixed
     */
    public function getAuditKey()
    {
        return $this->audit_key;
    }

    /**
     * @param mixed $audit_key
     */
    public function setAuditKey($audit_key)
    {
        $this->audit_key = $audit_key;
    }

    /**
     * @return mixed
     */
    public function getAuditViewTime()
    {
        return $this->audit_view_time;
    }

    /**
     * @param mixed $audit_view_time
     */
    public function setAuditViewTime($audit_view_time)
    {
        $this->audit_view_time = $audit_view_time;
    }

    /**
     * @return mixed
     */
    public function getWinDate()
    {
        return $this->win_date;
    }

    /**
     * @param mixed $win_date
     */
    public function setWinDate($win_date)
    {
        $this->win_date = $win_date;

        if ($this->win_date) {
            $this->duplicateOf = null;
        }
    }

    /**
     * @description Returns a boolean value on whether or not this proposal has a win date
     * @return bool
     */
    public function isWon()
    {
        return $this->win_date ? true : false;
    }

    /**
     * @return mixed
     */
    public function getApproved()
    {
        return $this->approved;
    }

    /**
     * @param mixed $approved
     */
    public function setApproved($approved)
    {
        $this->approved = $approved;
    }

    /**
     * @return mixed
     */
    public function hasBeenApproved()
    {
        return $this->approved;
    }

    /**
     * @return mixed
     */
    public function getUnapprovedServices()
    {
        return $this->unapproved_services;
    }

    /**
     * @param mixed $unapproved_services
     */
    public function setUnapprovedServices($unapproved_services)
    {
        $this->unapproved_services = $unapproved_services;
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

    public function updateQbSyncFlag()
    {
        if ($this->getQBID()) {
            $this->setQBSyncFlag(3);
        }
        if ($this->getClient()->getAccount()->getCompany()->getQbType() == 'desktop') {
            $proposalId = $this->getProposalId();
            $user = md5($this->getCompanyId());
            $services = $this->getServices();

            for ($i = 0; $i < count($services); $i++) {

                $service_id = $services[$i]->getInitialService();

                $this->db->select('quickbooks_queue_id')->from('quickbooks_queue')->where('qb_action',
                    'ItemServiceAdd')->where('ident', $service_id)->where('qb_status', 's');

                $query = $this->db->get();
                if ($query->num_rows() < 1) {
                    $this->getQbdRepository()->enqueue(QUICKBOOKS_ADD_SERVICEITEM, $service_id, 1, '', $user);
                }
            }

            $this->db->select('quickbooks_queue_id')->from('quickbooks_queue')->where('qb_action',
                'InvoiceAdd')->where('ident', $proposalId)->where('qb_status', 's');
            $query = $this->db->get();

            if ($query->num_rows() > 0) {
                $this->getQbdRepository()->enqueue(QUICKBOOKS_MOD_INVOICE, $proposalId, 0, '', $user);
            } else {
                $this->getQbdRepository()->enqueue(QUICKBOOKS_ADD_INVOICE, $proposalId, 0, '', $user);
            }
        }
    }

    public function updateQBDSyncFlag()
    {
        $proposalId = $this->getProposalId();

        $this->db->select('quickbooks_queue_id')->from('quickbooks_queue')->where('qb_action',
                'InvoiceAdd')->where('ident', $proposalId)->where('qb_status', 's');
            $query = $this->db->get();

        if ($query->num_rows() > 0) {

            $user = md5($this->getCompanyId());
            $services = $this->getServices();

            for ($i = 0; $i < count($services); $i++) {

                $service_id = $services[$i]->getInitialService();

                $this->db->select('service_id')->from('company_qb_services')->where('service_id', $service_id)->where('company_id',$this->getCompanyId());

                $query = $this->db->get();
                if ($query->num_rows() < 1) {
                    $this->getQbdRepository()->enqueue(QUICKBOOKS_ADD_SERVICEITEM, $service_id, 1, '', $user);
                }
            }

            
            $this->getQbdRepository()->enqueue(QUICKBOOKS_MOD_INVOICE, $proposalId, 0, '', $user);
        }
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
        $this->QBSError = $QBError;
    }

    /**
     * @return mixed
     */
    public function getInvoiceStatus()
    {
        return $this->invoice_status;
    }

    /**
     * @param mixed $invoice_status
     */
    public function setInvoiceStatus($invoice_status)
    {
        $this->invoice_status = $invoice_status;
    }

    /**
     * @return mixed
     */
    public function getInvoiceAmount()
    {
        return $this->invoice_amount;
    }

    /**
     * @param mixed $invoice_amount
     */
    public function setInvoiceAmount($invoice_amount)
    {
        $this->invoice_amount = $invoice_amount;
    }


    public function getEditAuditUrl()
    {
        return 'https://my.prositeaudit.com/edit/' . $this->getAuditKey();
    }

    public function getAuditReportUrl($view = false)
    {

        $url = 'https://my.prositeaudit.com/report/' . $this->getAuditKey();

        if ($view) {
            $url .= '/view';
        }
        return $url;
    }

    /**
     * Called when proposal is rebuilt. This determines what the email status should be set to
     */
    public function rebuildEmailStatus()
    {
        // Action is only relevant if email status is sent. Set to edited.
        if ($this->getEmailStatus() == Proposals::EMAIL_SENT) {
            $this->setEmailStatus(Proposals::EMAIL_EDITED);
        }

        //$this->setDeliveryTime(null);
        //$this->setLastOpenTime(null);
    }

    /**
     *  Returns whether or not this proposal has snow removal services
     *
     * @return bool
     */
    public function hasSnow()
    {

        // Need this for the DB connection
        $CI =& get_instance();

        // Query the services
        $proposalServices = $CI->em->createQuery('SELECT ps
                                                        FROM models\Proposal_services ps
                                                        WHERE ps.proposal=' . $this->getProposalId() . '
                                                        ORDER BY ps.ord, ps.serviceId')->getResult();

        // SPL time
        $ao = new \ArrayObject($proposalServices);

        // Are there items?
        if ($ao->count()) {

            $ai = $ao->getIterator();
            while ($ai->valid()) {

                $proposalService = $ai->current();
                /* @var $proposalService \models\Proposal_services */

                if ($proposalService) {
                    $service = $CI->em->find('models\Services', $proposalService->getInitialService());
                    /* @var $service \models\Services */

                    // Check for snow
                    if ($service->getParent() == 105) {
                        // Set the flag
                        return true;
                    }
                }
                $ai->next();
            }
        } else {
            return false;
        }
    }

    /**
     *  Return the new status object instead of the string
     *
     * @return \models\Status
     */
    public function getProposalStatus()
    {
        return $this->proposalStatus;
    }

    /**
     * Set new proposal status
     *
     * @param Status $status
     */
    public function setProposalStatus(\models\Status $status)
    {
        if ($status != $this->proposalStatus) {
            $this->proposalStatus = $status;
            $this->statusChangeDate = time();
            $this->last_activity = time();
        }
    }

    /**
     * @return mixed
     */
    public function getAuditReminderSent()
    {
        return $this->audit_reminder_sent;
    }

    /**
     * @param mixed $auditReminderSent
     */
    public function setAuditReminderSent($auditReminderSent)
    {
        $this->audit_reminder_sent = $auditReminderSent;
    }


    /**
     * Mass update proposals from one status to another
     *
     * @param Status $oldStatus
     * @param Status $newStatus
     * @return mixed
     */
    public static function statusUpdate(\models\Status $oldStatus, \models\Status $newStatus)
    {
        $CI = &get_instance();

        $query = 'UPDATE models\Proposals p
                    SET p.proposalStatus = :newStatus,
                    p.statusChangeDate = :timestamp,
                    p.last_activity = :timestamp,';

        if ($newStatus->isSales()) {
            $query .= " p.win_date = " . time();
        } else {
            $query .= " p.win_date = NULL";
        }

        $query .= " WHERE p.proposalStatus = :oldStatus";

        /** @var $query \Doctrine\ORM\QueryBuilder */
        $query = $CI->em->createQuery($query);
        $query->setParameter('newStatus', $newStatus->getStatusId());
        $query->setParameter('oldStatus', $oldStatus->getStatusId());
        $query->setParameter('timestamp', time());
        $numUpdated = $query->execute();

        return $numUpdated;
    }

    public function lastStatusChangeInRange($from, $to)
    {

        $log = $this->getLastStatusChange();

        if (!$log) {
            return false;
        } else {
            if ($log->getProposal()->getProposalStatus()->getStatusId() == $log->getStatusTo()) {
                if (($log->getTimeAdded() >= $from) && ($log->getTimeAdded() <= $to)) {
                    return true;
                }
            }
        }
        return false;

    }

    /**
     * @return \models\Log
     */
    public function getLastStatusChange()
    {

        $CI = &get_instance();

        $sql = "SELECT l
                    FROM \models\Log l
                    WHERE l.proposal = :proposalId
                    AND l.statusTo IS NOT NULL
                    ORDER BY l.timeAdded DESC";

        $query = $CI->em->createQuery($sql);
        $query->setParameter('proposalId', $this->getProposalId());
        $query->setMaxResults(1);

        try {
            $log = $query->getSingleResult();
        } catch (\Exception $e) {
            return false;
        }

        return $log;
    }

    /** Resend the proposal to the client, CC'd to owner */
    public function resend($subject, $body, $fromName = '', $fromEmail = '', $cc = true)
    {

        $etp = new \EmailTemplateParser();
        $etp->setProposal($this);
        $text = $etp->parse($body);
        $subject = $etp->parse($subject);

        $emailFromName = ($fromName) ?: $this->getOwner()->getFullName();
        $replyTo = ($fromEmail) ?: $this->getOwner()->getEmail();


        $emailData = [
            'to' => $this->getClient()->getEmail(),
            'fromName' => $emailFromName . ' via ' . SITE_NAME,
            'fromEmail' => 'proposals@' . SITE_EMAIL_DOMAIN,
            'replyTo' => $replyTo,
            'subject' => $subject,
            'uniqueArg' => 'Proposal',
            'uniqueArgVal' => $this->getProposalId(),
            'body' => $text,
            'categories' => ['Proposal', 'Proposal Group Resend'],
        ];

        $this->getEmailRepository()->send($emailData);


        if ($cc) {
            // Copy the proposal owner
            $copyAddr = $this->getOwner()->getEmail();

            $emailData = [
                'to' => $copyAddr,
                'fromName' => $emailFromName,
                'fromEmail' => 'proposals@' . SITE_EMAIL_DOMAIN,
                'subject' => $subject,
                'body' => $text,
                'categories' => ['Proposal CC', 'Proposal Group Resend'],
            ];

            $this->getEmailRepository()->send($emailData);
        }
    }

    /**
     *  Delete the images for this proposal from the file system
     */
    public function deleteImages()
    {
        $proposalImages = $this->getProposalImages();

        // Delete from database and file system
        foreach ($proposalImages as $image) {
            /* @var $image \models\Proposals_images */
            $this->doctrine->em->remove($image);
            $image->deleteFile();
        }
        $this->doctrine->em->flush();
    }

    /**
     *  Delete the Videos for this proposal from the file system
     */
    public function deleteVideos()
    {
        $proposalVideos = $this->getProposalVideos();

        // Delete from database and file system
        foreach ($proposalVideos as $proposalVideos) {
            /* @var $image \models\Proposals_images */
            $this->doctrine->em->remove($proposalVideos);
            
        }
        $this->doctrine->em->flush();
    }

    /**
     * Retrieve the attached files for this proposal
     * @return array
     */
    public function getProposalVideos()
    {
        $qb = $this->doctrine->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        $qb->select('pv')
        ->from('\models\ProposalVideo', 'pv')
        ->where('pv.proposal_id = :proposalId')
        ->setParameter('proposalId', $this->getProposalId());

        return $qb->getQuery()->getResult();
    }

    /**
     *  Delete the attachments for this proposal from the file system
     */
    public function deleteAttachments()
    {
        $attachments = $this->getAttachedFiles();

        foreach ($attachments as $attachment) {
            /* @var $attachment \models\Proposal_attachments */
            $this->doctrine->em->remove($attachment);
            $attachment->deleteFile();
        }
        $this->doctrine->em->flush();
    }

    /**
     * Delete the upload directory for this proposal
     */
    public function deleteProposalUploadDir()
    {
        /*
        $dirPath = $this->getUploadDir();
        if ((is_dir($dirPath))) {
            rmdir($dirPath);
        }
        */
    }


    public function deleteFilesAndDir()
    {
        $this->deleteImages();
        $this->deleteAttachments();
        $this->deleteProposalUploadDir();
        $this->deleteProposalGroupResendEmails();
        $this->deleteVideos();
    }

    /**
     * Returns true if this proposal has any duplicates, false if not.
     * @return bool
     */
    public function hasDuplicates()
    {
        $qb = $this->doctrine->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        $qb->select('COUNT(p.proposalId)')
            ->from('\models\Proposals', 'p')
            ->where('p.duplicateOf = :proposalId')
            ->setParameter('proposalId', $this->getProposalId());

        $duplicates = $qb->getQuery()->getSingleScalarResult();

        if ($duplicates > 0) {
            return true;
        }
        return false;
    }

    /**
     * Returns an array of duplicates for this proposal
     * @return array
     */
    public function getDuplicates()
    {
        $qb = $this->doctrine->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        $qb->select('p')
            ->from('\models\Proposals', 'p')
            ->where('p.duplicateOf = :proposalId')
            ->orderBy('p.created')
            ->setParameter('proposalId', $this->getProposalId());

        return $qb->getQuery()->getResult();
    }


    function getOldStatusUpdate()
    {

        $CI =& get_instance();

        $dql = "SELECT l
                FROM \models\Log l
                WHERE l.action = 'proposal_status_update'
                AND l.proposal = :proposalId
                ORDER BY l.timeAdded DESC";

        $query = $CI->em->createQuery($dql);
        $query->setParameter('proposalId', $this->getProposalId());
        $query->setMaxResults(1);

        $log = $query->getSingleResult();

        return $log;

    }

    function getOldProposalAdded()
    {

        $CI =& get_instance();

        $dql = "SELECT l
                FROM \models\Log l
                WHERE l.action = 'add_proposal'
                AND l.proposal = :proposalId
                ORDER BY l.timeAdded DESC";

        $query = $CI->em->createQuery($dql);
        $query->setParameter('proposalId', $this->getProposalId());
        $query->setMaxResults(1);

        $log = $query->getSingleResult();

        return $log;

    }

    function getOldProposalUpdated()
    {

        $CI =& get_instance();

        $dql = "SELECT l
                FROM \models\Log l
                WHERE l.action = 'update_proposal'
                AND l.proposal = :proposalId
                ORDER BY l.timeAdded DESC";

        $query = $CI->em->createQuery($dql);
        $query->setParameter('proposalId', $this->getProposalId());
        $query->setMaxResults(1);

        $log = $query->getSingleResult();

        return $log;

    }

    public function getEditLink()
    {
        return site_url('proposals/edit/' . $this->getProposalId());
    }


    /**
     * Returns the full path of the PARENT (company) directory for uploads belonging to this proposal
     * @return String
     */
    public function getCompanyUploadDir()
    {
        $companyId = $this->getClient()->getAccount()->getCompany()->getCompanyId();
        return UPLOADPATH . '/companies/' . $companyId;
    }

    /**
     * Returns the full path of the directory for uploads belonging to this proposal
     * Does NOT have the trailing slash
     * @return String
     */
    public function getUploadDir()
    {
        $companyId = $this->getClient()->getAccount()->getCompany()->getCompanyId();
        return UPLOADPATH . '/companies/' . $companyId . '/proposals/' . $this->getProposalId();
        //return site_url('uploads/companies/').'/' . $companyId . '/proposals/' . $this->getProposalId();
        
    }

    public function getPathUploadDir()
    {
        $companyId = $this->getClient()->getAccount()->getCompany()->getCompanyId();
        return UPLOADPATH . '/companies/' . $companyId . '/proposals/' . $this->getProposalId();
        //return 'https://local.pms/companies/' . $companyId . '/proposals/' . $this->getProposalId();
    }

    /**
     * Returns the http path of the directory for uploads belonging to this proposal
     * Does NOT have the trailing slash
     * @return String
     */
    public function getUploadedAssetsDir()
    {
        $companyId = $this->getClient()->getAccount()->getCompany()->getCompanyId();
        return UPLOADPATH . '/companies/' . $companyId . '/proposals/' . $this->getProposalId();
    }
    public function getSitePathUploadDir()
    {
        $companyId = $this->getClient()->getAccount()->getCompany()->getCompanyId();
        return site_url('uploads/companies/').'/' . $companyId . '/proposals/' . $this->getProposalId();
    }

    public static function createUniqueId()
    {
        $uuid =  Uuid::uuid4();
        return str_replace(['-'], [''], $uuid);
    }

    public static function isUnique($key)
    {
        $ci = get_instance();
        $qb = $ci->doctrine->em->createQueryBuilder();
        /* @var $qb QueryBuilder */

        $qb->select('count(p.proposalId)')
            ->from('\models\Proposals', 'p')
            ->where('p.access_key = :access_key')
            ->setParameter('access_key', $key);

        $count = $qb->getQuery()->getSingleScalarResult();

        if ($count > 0) {
            return false;
        }

        return true;
    }

    /**
     * Returns a concatenated project address string
     * @return string
     */
    public function getProjectAddressString()
    {
        return $this->getProjectAddress() . '<br />' .
            $this->getProjectCity() . ' ' .
            $this->getProjectState() . ' ' .
            $this->getProjectZip();
    }

    /**
     * Returns the number of tax services belonging to this proposal
     * It's an integer behaving as a boolean
     * @return integer
     */
    public function hasTaxService()
    {
        $qb = $this->doctrine->em->createQueryBuilder();
        /* @var $qb QueryBuilder */

        $qb->select('count(ps.serviceId)')
            ->from('\models\Proposal_services', 'ps')
            ->where('ps.proposal = :proposalId')
            ->andWhere('ps.tax = 1')
            ->setParameter('proposalId', $this->getProposalId());

        return $qb->getQuery()->getSingleScalarResult();
    }

    public static function resetProposalFilter()
    {
        $CI =& get_instance();
        $CI->session->set_userdata(array(
            'pFilter' => '',
            'pFilterUser' => '',
            'pFilterBranch' => '',
            'pFilterStatus' => '',
            'pFilterService' => '',
            'pFilterFrom' => '',
            'pFilterTo' => '',
            'pFilterQueue' => '',
            'pFilterEmailStatus' => '',
            'pFilterClientAccount' => '',
        ));
    }

    /**
     * @return mixed
     */
    public function getHeaderFont()
    {
        return $this->getClient()->getCompany()->getHeaderFont();
    }

    /**
     * @param mixed $header_font
     */
    public function setHeaderFont($header_font)
    {
        $this->header_font = $header_font;
    }

    /**
     * @return mixed
     */
    public function getTextFont()
    {
        return $this->getClient()->getCompany()->getTextFont();
    }

    /**
     * @param mixed $text_font
     */
    public function setTextFont($text_font)
    {
        $this->text_font = $text_font;
    }

    /**
     * @return mixed
     */
    public function getGradientOpacity()
    {
        return $this->gradient_opacity ?: $this->getClient()->getCompany()->getGradientOpacity();
    }

    /**
     * @param mixed $gradient_opacity
     */
    public function setGradientOpacity($gradient_opacity)
    {
        $this->gradient_opacity = $gradient_opacity;
    }

    /**
     * @return mixed
     */
    public function getHeaderBgColor()
    {
        return $this->header_bg_color ?: $this->getClient()->getCompany()->getHeaderBgColor();
    }

    /**
     * @param mixed $header_bg_color
     */
    public function setHeaderBgColor($header_bg_color)
    {
        $this->header_bg_color = $header_bg_color;
    }

    /**
     * @return mixed
     */
    public function getHeaderBgOpacity()
    {
        return $this->header_bg_opacity ?: $this->getClient()->getCompany()->getHeaderBgOpacity();
    }

    /**
     * @param mixed $header_bg_opacity
     */
    public function setHeaderBgOpacity($header_bg_opacity)
    {
        $this->header_bg_opacity = $header_bg_opacity;
    }

    /**
     * @return mixed
     */
    public function getHeaderFontColor()
    {
        return $this->header_font_color ?: $this->getClient()->getCompany()->getHeaderFontColor();
    }

    /**
     * @param mixed $header_font_color
     */
    public function setHeaderFontColor($header_font_color)
    {
        $this->header_font_color = $header_font_color;
    }

    public function getCoverImagePath()
    {
        $companyId = $this->getClient()->getCompany()->getCompanyId();

        $propPath = UPLOADPATH . '/companies/' . $companyId . '/proposals/' . $this->getProposalId() . '/cover-orig.png';

        if (file_exists($propPath)) {
            return $propPath;
        }

        $defaultPath = UPLOADPATH . '/clients/logos/bg-' . $companyId . '.png';

        if (file_exists($defaultPath)) {
            return $defaultPath;
        }

        return false;
    }

    public function hasCustomImage()
    {
        $imgPath = $this->getCoverImagePath();

        if (!$imgPath) {
            return false;
        }

        return (strpos($imgPath, 'cover') !== false);
    }

    public function getCoverImageSrc($imgSuffix = '')
    {
        $companyId = $this->getClient()->getCompany()->getCompanyId();

        $propPath = UPLOADPATH . '/companies/' . $companyId . '/proposals/' . $this->getProposalId() . '/cover' . $imgSuffix . '.png';

        if (file_exists($propPath)) {
            return '/uploads/companies/' . $companyId . '/proposals/' . $this->getProposalId() . '/cover' . $imgSuffix . '.png';
        }

        $defaultPath = UPLOADPATH . '/clients/logos/bg-' . $companyId . '.png';

        if (file_exists($defaultPath)) {
            return '/uploads/clients/logos/bg-' . $companyId . '.png';
        }

        return '';
    }

    public function removeCustomImage()
    {
        $companyId = $this->getClient()->getCompany()->getCompanyId();
        $propPath = UPLOADPATH . '/companies/' . $companyId . '/proposals/' . $this->getProposalId() . '/cover.png';
        $propOrigPath = UPLOADPATH . '/companies/' . $companyId . '/proposals/' . $this->getProposalId() . '/cover-orig.png';

        unlink($propPath);
        unlink($propOrigPath);
    }

    /**
     * Getter for ResendEnabled
     * @return mixed
     */
    public function getResendEnabled()
    {
        return $this->resend_enabled;
    }

    /**
     * Setter for ResendEnabled
     * @var $resend_enabled
     */
    public function setResendEnabled($resend_enabled)
    {
        $this->resend_enabled = $resend_enabled;
    }

    /**
     * Getter for ResendTemplate
     * @return mixed
     */
    public function getResendTemplate()
    {
        return ($this->resend_template) ?: @$this->getResendSettings()->template;
    }

    /**
     * Setter for ResendTemplate
     * @var $resend_template
     */
    public function setResendTemplate($resend_template)
    {
        $this->resend_template = $resend_template;
    }

    /**
     * Getter for ResendFrequency
     * @return mixed
     */
    public function getResendFrequency()
    {
        return ($this->resend_frequency) ?: @$this->getResendSettings()->frequency;
    }

    /**
     * Setter for ResendFrequency
     * @var $resend_frequency
     */
    public function setResendFrequency($resend_frequency)
    {
        $resend_frequency = ($resend_frequency >= 86400) ? $resend_frequency : 86400;
        $this->resend_frequency = $resend_frequency;
    }

    /**
     * Getter for ProposalNotificationSettingsRepository
     * @return mixed
     */
    public function getResendSettings()
    {
        if ($this->resendSettings === null) {
            $notificationsRepository = new ProposalNotifications();
            $this->resendSettings = $notificationsRepository->getProposalResendSettings($this->getClient()->getAccount()->getCompany()->getCompanyId());
        }
        return $this->resendSettings;
    }

    /**
     * @return string
     */
    public function getLeadSource()
    {
        if($this->getConvertedFrom()){

            $lead =  $this->doctrine->em->findLead($this->getConvertedFrom());
            if(!$lead){
                return '';
            }


        }else{

            $sql = "SELECT l
                        FROM \models\Leads l
                        WHERE l.convertedTo = :proposalId
                        ORDER BY l.convertedTime DESC";

            $query = $this->doctrine->em->createQuery($sql);
            $query->setParameter('proposalId', $this->getProposalId());
            $query->setMaxResults(1);


            try {
                $lead = $query->getSingleResult();
            } catch (\Exception $e) {
                return '';
            }
        }

        return $lead->getSource();
    }

    public function getPdfUrl($preview = false, $cache = false)
    {
        $view = ($preview) ? 'preview' : 'view';
        if ($cache) {
            $view = 'cache';
        }
        return site_url('proposals/live/' . $view . '/' . $this->getLayout() . '/plproposal_' . $this->getAccessKey() . '.pdf');
    }

    public function hasOptionalServices()
    {
        return count($this->getOptionalServices());
    }

    public function hasUnapprovedServices()
    {
        $sql = "SELECT COUNT(ps)
                    FROM \models\Proposal_services ps
                    WHERE ps.approved = 0
                    AND ps.proposal = :proposalId";

        $query = $this->doctrine->em->createQuery($sql);
        $query->setParameter('proposalId', $this->getProposalId());
        return $query->getSingleScalarResult();
    }

    /**
     * @return mixed
     */
    public function getWorkOrderNotes()
    {
        return $this->work_order_notes;
    }

    /**
     * @param mixed $work_order_notes
     */
    public function setWorkOrderNotes($work_order_notes)
    {
        $this->work_order_notes = $work_order_notes;
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
    public function getGeocoded()
    {
        return $this->geocoded;
    }

    /**
     * @param mixed $geocoded
     */
    public function setGeocoded($geocoded)
    {
        $this->geocoded = $geocoded;
    }

    /**
     * @return mixed
     */
    public function getInventoryLocationId()
    {
        return $this->inventory_location_id;
    }

    /**
     * @param mixed $inventory_location_id
     */
    public function setInventoryLocationId($inventory_location_id)
    {
        $this->inventory_location_id = $inventory_location_id;
    }

    /**
     * @return mixed
     */
    public function getInventoryReportUrl()
    {
        return $this->inventory_report_url;
    }

    /**
     * @param mixed $inventory_report_url
     */
    public function setInventoryReportUrl($inventory_report_url)
    {
        $this->inventory_report_url = $inventory_report_url;
    }

    /**
     * @return mixed
     */
    public function getEstimateNotes()
    {
        return $this->estimate_notes;
    }

    /**
     * @param mixed $estimate_notes
     */
    public function setEstimateNotes($estimate_notes)
    {
        $this->estimate_notes = $estimate_notes;
    }

    /**
     * @return mixed
     */
    public function getEstimateCalculationType()
    {
        return $this->estimate_calculation_type;
    }

    /**
     * @param mixed $estimate_calculation_type
     */
    public function setEstimateCalculationType($estimate_calculation_type)
    {
        $this->estimate_calculation_type = $estimate_calculation_type;
    }

    /**
     * @return mixed
     */
    public function getEstimateStatusId()
    {
        return $this->estimate_status_id;
    }

    /**
     * @param mixed $estimate_status_id
     */
    public function setEstimateStatusId($estimate_status_id)
    {
        $this->estimate_status_id = $estimate_status_id;
    }


    /**
     * @return mixed
     */
    public function getEstimateOhRate()
    {
        return $this->estimate_oh_rate;
    }

    /**
     * @param mixed $estimate_oh_rate
     */
    public function setEstimateOhRate($estimate_oh_rate)
    {
        $this->estimate_oh_rate = $estimate_oh_rate;
    }


    /**
     * @return mixed
     */
    public function getEstimatePmRate()
    {
        return $this->estimate_pm_rate;
    }

    /**
     * @param mixed $estimate_pm_rate
     */
    public function setEstimatePmRate($estimate_pm_rate)
    {
        $this->estimate_pm_rate = $estimate_pm_rate;
    }


    /**
     * @return mixed
     */
    public function getWorkOrderLayoutType()
    {
        if($this->work_order_layout_type==NULL){
            $settings = $this->getEstimationRepository()->getCompanySettings($this->getOwner()->getCompany());
            return $settings->getWorkOrderLayoutType();
        }
        return $this->work_order_layout_type;

    }

    /**
     * @param mixed $work_order_layout_type
     */
    public function setWorkOrderLayoutType($work_order_layout_type)
    {
        $this->work_order_layout_type = $work_order_layout_type;
    }


    /**
     * @return mixed
     */
    public function getGroupTemplateItem()
    {
        if($this->work_order_layout_type==NULL){
            $settings = $this->getEstimationRepository()->getCompanySettings($this->getOwner()->getCompany());
            return $settings->getGroupTemplateItem();
        }
        return $this->group_template_item;
    }

    /**
     * @param mixed $group_template_item
     */
    public function setGroupTemplateItem($group_template_item)
    {
        $this->group_template_item = $group_template_item;
    }

    /**
     * @return mixed
     */
    public function getJobCostStatus()
    {
        
        return $this->job_cost_status;
    }

    /**
     * @param mixed $job_cost_status
     */
    public function setJobCostStatus($job_cost_status)
    {
        $this->job_cost_status = $job_cost_status;
    }

    /**
     * @return mixed
     */
    public function getJobCostUsername()
    {
        
        return $this->job_cost_username;
    }

    /**
     * @param mixed $job_cost_username
     */
    public function setJobCostUsername($job_cost_username)
    {
        $this->job_cost_username = $job_cost_username;
    }

    /**
     * @return mixed
     */
    public function getJobCostNotes()
    {
        
        return $this->job_cost_notes;
    }

    /**
     * @param mixed $job_cost_notes
     */
    public function setJobCostNotes($job_cost_notes)
    {
        $this->job_cost_notes = $job_cost_notes;
    }

    /**
     * @return mixed
     */
    public function getJobCostCompletedAt()
    {
        
        return $this->job_cost_completed_at;
    }

    /**
     * @param mixed $job_cost_completed_at
     */
    public function setJobCostCompletedAt($job_cost_completed_at)
    {
        $this->job_cost_completed_at = $job_cost_completed_at;
    }

    /**
     * @return mixed
     */
    public function getJobCostSignatureFile()
    {
        
        return $this->job_cost_signature_file;
    }

    /**
     * @param mixed $job_cost_signature_file
     */
    public function setJobCostSignatureFile($job_cost_signature_file)
    {
        $this->job_cost_signature_file = $job_cost_signature_file;
    }

    /**
     * @return mixed
     */
    public function getProposalUuid()
    {
        
        return $this->proposal_uuid;
    }

    /**
     * @param mixed $proposal_uuid
     */
    public function setProposalUuid($proposal_uuid)
    {
        $this->proposal_uuid  = Uuid::uuid4();
    }

    /**
     * @param mixed $proposal_uuid
     */
    public function setProposalUuid2($proposal_uuid)
    {
        $this->proposal_uuid  = $proposal_uuid;
    }

    public function getProposalMobileJobCostingUrl()
    {
        return site_url('home/mobile_job_costing').'/'.$this->proposal_uuid;
    }

    public function getProposalJobCostingUrl()
    {
        return site_url('proposal/job_costing').'/'.$this->proposal_uuid;
    }
    

    /**
     * @return mixed
     */
    public function getProfitMarginPercent()
    {
        
        return $this->profit_margin_percent;
    }

    /**
     * @param mixed $profit_margin_percent
     */
    public function setProfitMarginPercent($profit_margin_percent)
    {
        $this->profit_margin_percent = $profit_margin_percent;
    }

    /**
     * @return mixed
     */
    public function getProfitMarginValue()
    {
        
        return $this->profit_margin_value;
    }

    /**
     * @param mixed $profit_margin_value
     */
    public function setProfitMarginValue($profit_margin_value)
    {
        $this->profit_margin_value = $profit_margin_value;
    }

    /**
     * @return mixed
     */
    public function getJobCostForemenId()
    {
        
        return $this->job_cost_foremen_id;
    }

    /**
     * @param mixed $job_cost_foremen_id
     */
    public function setJobCostForemenId($job_cost_foremen_id)
    {
        $this->job_cost_foremen_id = $job_cost_foremen_id;
    }

    /**
     * @return mixed
     */
    public function getActualCreatedDate()
    {
        
        return $this->actual_created_date;
    }

    /**
     * @param mixed $actual_created_date
     */
    public function setActualCreatedDate($actual_created_date)
    {
        $this->actual_created_date = $actual_created_date;
    }

     /**
     * @return mixed
     */
    public function getConvertedFrom()
    {
        
        return $this->converted_from;
    }

    /**
     * @param mixed $converted_from
     */
    public function setConvertedFrom($converted_from)
    {
        $this->converted_from = $converted_from;
    }

    /**
     * @return mixed
     */
    public function getProposalBackground()
    {
        
        return $this->proposal_background;
    }

    /**
     * @param mixed $proposal_background
     */
    public function setProposalBackground($proposal_background)
    {
        $this->proposal_background = $proposal_background;
    }
    
    /**
     * @return mixed
     */
    public function getIsShowProposalLogo()
    {
        return $this->is_show_proposal_logo;
    }

    /**
     * @param mixed $is_show_proposal_logo
     */
    public function setIsShowProposalLogo($is_show_proposal_logo)
    {
        $this->is_show_proposal_logo = $is_show_proposal_logo;
    }

    /**
     * @return mixed
     */
    public function getImageCount()
    {
        return $this->image_count;
    }

    /**
     * @param mixed $image_count
     */
    public function setImageCount($image_count)
    {
        $this->image_count = $image_count;
    }


    /**
     * @return mixed
     */
    public function getIsHiddenToView()
    {
        return $this->is_hidden_to_view;
    }

    /**
     * @param mixed $is_hidden_to_view
     */
    public function setIsHiddenToView($is_hidden_to_view)
    {
        $this->is_hidden_to_view = $is_hidden_to_view;
    }

    
   
   
    /**
    
     * @return mixed
     */
    public function getIsDemo()
    {
        return $this->is_demo;
    }

    /**
     * @param mixed $is_demo
     */
    public function setIsDemo($is_demo)
    {
        $this->is_demo = $is_demo;
    }

    /**
     * @return mixed
     */
    public function getBusinessTypeId()
    {
        return $this->business_type_id;
    }

    /**
     * @param mixed $business_type_id
     */
    public function setBusinessTypeId($business_type_id)
    {
        $this->business_type_id = $business_type_id;
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
        $this->setLastActivity();
    }
    /**
     * @param mixed $note_count
     */
    public function setNoteCount($note_count)
    {
        $this->note_count = $note_count;
    }
    /**
     * @return mixed
     */
    public function getNoteCount()
    {
        return $this->note_count;
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
    public function getCompanyId()
    {
        return $this->company_id;
    }
        

    /**
     * @param mixed $signature_id
     */
    public function setSignatureId($signature_id)
    {
        $this->signature_id = $signature_id;
    }
    /**
     * @return mixed
     */
    public function getSignatureId()
    {
        return $this->signature_id;
    }
    

    /**
     * @param mixed $proposal_view_count
     */
    public function setProposalViewCount($proposal_view_count)
    {
        $this->proposal_view_count = $proposal_view_count;
    }
    /**
     * @return mixed
     */
    public function getProposalViewCount()
    {
        return $this->proposal_view_count;
    }

     /**
     * @return mixed
     */
    public function getIsPreProposalPopup()
    {
        return $this->is_pre_proposal_popup;
    }

    /**
     * @param mixed $is_pre_proposal_popup
     */
    public function setIsPreProposalPopup($is_pre_proposal_popup)
    {
        $this->is_pre_proposal_popup = $is_pre_proposal_popup;
    }
    
    /**
     * Retrieve the attached files for this proposal
     * @return array
     */
    public function getProposalGroupResendEmails()
    {
        $qb = $this->doctrine->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        $qb->select('pgre')
        ->from('\models\ProposalGroupResendEmail', 'pgre')
        ->where('pgre.proposal_id = :proposalId')
        ->setParameter('proposalId', $this->getProposalId());

        return $qb->getQuery()->getResult();
    }

    /**
     *  Delete the Resend emails for this proposal
     */
    public function deleteProposalGroupResendEmails()
    {
        $proposalGroupResendEmails = $this->getProposalGroupResendEmails();

        // Delete from database and file system
        foreach ($proposalGroupResendEmails as $email) {
            /* @var $image \models\Proposals_images */
            $this->doctrine->em->remove($email);

        }
        //Delete user query Cache
        $this->getQueryCacheRepository()->deleteProposalsResendListCache($this->getClient()->getAccount()->getCompany()->getCompanyId());
        $this->doctrine->em->flush();
    }

    /**
     * @param mixed $company_signature_id
     */
    public function setCompanySignatureId($company_signature_id)
    {
        $this->company_signature_id = $company_signature_id;
    }
    /**
     * @return mixed
     */
    public function getCompanySignatureId()
    {
        return $this->company_signature_id;
    }

    function getProposalViewUrl($client = false){
        if($client){
            $proposalViewUrl = $this->getProposalRepository()->getClientProposalLink($this->getProposalId());
        }else{
            $proposalViewUrl = $this->getProposalRepository()->getDefaultProposalLink($this->getProposalId());
        }
        
        return $proposalViewUrl->getUrl();
    }

    public function getSynchedAt()
    {
        return $this->synched_at;
    }

    public function setSynchedAt($synched_at)
    {
        $this->synched_at = $synched_at;
    }
    // function for work order setting
    public function getWorkOrderSetting()
    {
     return ($this->work_order_setting !== "" && $this->work_order_setting !== NULL) ? $this->work_order_setting : $this->getOwner()->getWorkOrderSetting();

    }

    public function setWorkOrderSetting($work_order_setting)
    {
        $this->work_order_setting = $work_order_setting;
    }

    //for invoice date getter setter method
    public function getInvoiceDate()
    {
        return $this->invoice_date;
    }
    public function setInvoiceDate($invoice_date)
    {
        $this->invoice_date = $invoice_date;
    }


  
}