<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="proposal_views")
 */
class ProposalView extends \MY_Model
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $proposal_link_id;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $proposal_id;


    /**
     * @ORM\Column(type="string")
     */
    private $created_at;

    /**
     * @ORM\Column(type="string")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string")
     */
    private $view_data;

    /**
     * @ORM\Column(type="string")
     */
    private $view_count;

    /**
     * @ORM\Column(type="string")
     */
    private $session_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $total_duration;

    /**
     * @ORM\Column(type="integer")
     */
    private $audit_viewed;

    /**
     * @ORM\Column(type="string")
     */
    private $images_clicked;

    /**
     * @ORM\Column(type="string")
     */
    private $service_spec_clicked;

    /**
     * @ORM\Column(type="integer")
     */
    private $signed;
    
    /**
     * @ORM\Column(type="string")
     */
    private $printed;

    /**
     * @ORM\Column(type="string")
     */
    private $video_played;

    /**
     * @ORM\Column(type="string")
     */
    private $video_playtime;
    /**
     * @ORM\Column(type="string")
     */
    private $ip_address;
     /**
     * @ORM\Column(type="string")
     */
    private $service_links_viewed;
    /**
     * @ORM\Column(type="string")
     */
    private $viewed_image_data;
    
    /**
     * @ORM\Column(type="string")
     */
    private $service_text_viewed_time;

    /**
     * @ORM\Column(type="integer")
     */
    private $audit_viewed_time;
    /**
     * @ORM\Column(type="string")
     */
    private $platform;
    /**
     * @ORM\Column(type="string")
     */
    private $platform_version;
    /**
     * @ORM\Column(type="string")
     */
    private $browser;
    /**
     * @ORM\Column(type="string")
     */
    private $device;
    /**
     * @ORM\Column(type="integer")
     */
    private $pdf_view = 0;
      /**
     * @ORM\Column(type="integer")
     */
    private $access_denied = 0;
    /**
     * @ORM\Column(type="string")
     */
    private $viewed_video_data;
    /**
     * @ORM\Column(type="integer")
     */
    private $email_sent = 0;
    
    CONST EMAIL_SENT = 1;
    CONST EMAIL_NOT_SENT = 0;
    CONST EMAIL_DO_NOT_SEND = -1;
    CONST EMAIL_SENDING = 2;
    
    function __construct()
    {
        $this->audit_viewed = 0;
    }

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
    public function getProposalLinkId()
    {
        return $this->proposal_link_id;
    }

    /**
     * @param mixed $proposal_link_id
     */
    public function setProposalLinkId($proposal_link_id)
    {
        $this->proposal_link_id = $proposal_link_id;
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
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * @param mixed $created_at
     */
    public function setCreatedAt($created_at)
    {
        $this->created_at = $created_at;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * @param mixed $updated_at
     */
    public function setUpdatedAt($updated_at)
    {
        $this->updated_at = $updated_at;
    }

    /**
     * @return mixed
     */
    public function getViewData()
    {
        return $this->view_data;
    }

    /**
     * @param mixed $view_data
     */
    public function setViewData($view_data)
    {
        $this->view_data = $view_data;
    }

    /**
     * @param mixed $view_count
     */
    public function setViewCount($view_count)
    {
        $this->view_count = $view_count;
    }

    /**
     * @return mixed
     */
    public function getViewCount()
    {
        return $this->view_count;
    }

    

    /**
     * @param mixed $session_id
     */
    public function setSessionId($session_id)
    {
        $this->session_id = $session_id;
    }

    /**
     * @return mixed
     */
    public function getSessionId()
    {
        return $this->session_id;
    }

    

    /**
     * @param mixed $total_duration
     */
    public function setTotalDuration($total_duration)
    {
        $this->total_duration = $total_duration;
    }

    /**
     * @return mixed
     */
    public function getTotalDuration()
    {
        return $this->total_duration;
    }
    
    

    /**
     * @param mixed $audit_viewed
     */
    public function setAuditViewed($audit_viewed)
    {
        $this->audit_viewed = $audit_viewed;
    }

    /**
     * @return mixed
     */
    public function getAuditViewed()
    {
        return $this->audit_viewed;
    }

    /**
     * @param mixed $images_clicked
     */
    public function setImagesClicked($images_clicked)
    {
        $this->images_clicked = $images_clicked;
    }

    /**
     * @return mixed
     */
    public function getImagesClicked()
    {
        return $this->images_clicked;
    }

    /**
     * @param mixed $service_spec_clicked
     */
    public function setServiceSpecClicked($service_spec_clicked)
    {
        $this->service_spec_clicked = $service_spec_clicked;
    }

    /**
     * @return mixed
     */
    public function getServiceSpecClicked()
    {
        return $this->service_spec_clicked;
    }

    /**
     * @param mixed $signed
     */
    public function setSigned($signed)
    {
        $this->signed = $signed;
    }

    /**
     * @return mixed
     */
    public function getSigned()
    {
        return $this->signed;
    }

    /**
     * @param mixed $printed
     */
    public function setPrinted($printed)
    {
        $this->printed = $printed;
    }

    /**
     * @return mixed
     */
    public function getPrinted()
    {
        return $this->printed;
    }

    /**
     * @param mixed $video_played
     */
    public function setVideoPlayed($video_played)
    {
        $this->video_played = $video_played;
    }

    /**
     * @return mixed
     */
    public function getVideoPlayed()
    {
        return $this->video_played;
    }

    /**
     * @param mixed $video_playtime
     */
    public function setVideoPlaytime($video_playtime)
    {
        $this->video_playtime = $video_playtime;
    }

    /**
     * @return mixed
     */
    public function getVideoPlaytime()
    {
        return $this->video_playtime;
    }

     /**
     * @param mixed $ip_address
     */
    public function setIpAddress($ip_address)
    {
        $this->ip_address = $ip_address;
    }

    /**
     * @return mixed
     */
    public function getIpAddress()
    {
        return $this->ip_address;
    }

    /**
     * @param mixed $service_links_viewed
     */
    public function setServiceLinksViewed($service_links_viewed)
    {
        $this->service_links_viewed = $service_links_viewed;
    }

    /**
     * @return mixed
     */
    public function getServiceLinksViewed()
    {
        return $this->service_links_viewed;
    }

      /**
     * @param mixed $audit_viewed_time
     */
    public function setAuditViewedTime($audit_viewed_time)
    {
        $this->audit_viewed_time = $audit_viewed_time;
    }

    /**
     * @return mixed
     */
    public function getAuditViewedTime()
    {
        return $this->audit_viewed_time;
    }

        /**
     * @param mixed $service_text_viewed_time
     */
    public function setServiceTextViewedTime($service_text_viewed_time)
    {
        $this->service_text_viewed_time = $service_text_viewed_time;
    }

    /**
     * @return mixed
     */
    public function getServiceTextViewedTime()
    {
        return $this->service_text_viewed_time;
    }

    /**
     * @param mixed $viewed_image_data
     */
    public function setViewedImageData($viewed_image_data)
    {
        $this->viewed_image_data = $viewed_image_data;
    }

    /**
     * @return mixed
     */
    public function getViewedImageData()
    {
        return $this->viewed_image_data;
    }

    

    /**
     * @param mixed $platform
     */
    public function setPlatform($platform)
    {
        $this->platform = $platform;
    }

    /**
     * @return mixed
     */
    public function getPlatform()
    {
        return $this->platform;
    }

    /**
     * @param mixed $platform_version
     */
    public function setPlatformVersion($platform_version)
    {
        $this->platform_version = $platform_version;
    }

    /**
     * @return mixed
     */
    public function getPlatformVersion()
    {
        return $this->platform_version;
    }

    

    /**
     * @param mixed $browser
     */
    public function setBrowser($browser)
    {
        $this->browser = $browser;
    }

    /**
     * @return mixed
     */
    public function getBrowser()
    {
        return $this->browser;
    }

    /**
     * @param mixed $device
     */
    public function setDevice($device)
    {
        $this->device = $device;
    }

    /**
     * @return mixed
     */
    public function getDevice()
    {
        return $this->device;
    }
    
    
    /**
     * @param mixed $pdf_view
     */
    public function setPdfView($pdf_view)
    {
        $this->pdf_view = $pdf_view;
    }

    /**
     * @return mixed
     */
    public function getPdfView()
    {
        return $this->pdf_view;
    }

    /**
     * @param mixed $access_denied
     */
    public function setAccessDenied($access_denied)
    {
        $this->access_denied = $access_denied;
    }

    /**
     * @return mixed
     */
    public function getAccessDenied()
    {
        return $this->access_denied;
    }

    /**
     * @param mixed $viewed_video_data
     */
    public function setViewedVideoData($viewed_video_data)
    {
        $this->viewed_video_data = $viewed_video_data;
    }

    /**
     * @return mixed
     */
    public function getViewedVideoData()
    {
        return $this->viewed_video_data;
    }


    

     /**
     * @param mixed $email_sent
     */
    public function setEmailSent($email_sent)
    {
        $this->email_sent = $email_sent;
    }

    /**
     * @return mixed
     */
    public function getEmailSent()
    {
        return $this->email_sent;
    }
}