<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="proposal_videos")
 */
class ProposalVideo { 

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $proposal_id;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $video_url;

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $thumbnail_image;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $title;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $video_type;
    
     /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $video_note;
    
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $embed_video_url;
    /**
     * @ORM\Column(type="integer")
     */
    private $ord = 999;
    /**
     * @ORM\Column(type="integer")
     */
    private $duration = 0;
    /**
     * @ORM\Column(type="string", nullable=true)
     */
    private $screencast_video_id;
    /**
     * @ORM\Column(type="integer")
     */
    private $company_video_id = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $is_large_preview = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $visible_proposal = 1;
    /**
     * @ORM\Column(type="integer")
     */
    private $visible_work_order = 1;
    /**
     * @ORM\Column(type="integer")
     */
    private $is_intro = 0;
    /**
     * @ORM\Column(type="integer")
     */
    private $player_icon_hide = 0;
    /**
     * @ORM\Column(type="string")
     */
    private $player_icon_color= 0;

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
    public function getVideoUrl()
    {
        return $this->video_url;
    }

    /**
     * @param mixed $video_url
     */
    public function setVideoUrl($video_url)
    {
        $this->video_url = $video_url;
    }

    /**
     * @return mixed
     */
    public function getThumbnailImage()
    {
        return $this->thumbnail_image;
    }

    /**
     * @param mixed $thumbnail_image
     */
    public function setThumbnailImage($thumbnail_image)
    {
        $this->thumbnail_image = $thumbnail_image;
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
    public function getVideoType()
    {
        return $this->video_type;
    }

    /**
     * @param mixed $video_type
     */
    public function setVideoType($video_type)
    {
        $this->video_type = $video_type;
    }



    /**
     * @return mixed
     */
    public function getVideoNote()
    {
        return $this->video_note;
    }

    /**
     * @param mixed $video_note
     */
    public function setVideoNote($video_note)
    {
        $this->video_note = $video_note;
    }

    /**
     * @return mixed
     */
    public function getEmbedVideoUrl()
    {
        // $finalUrl = parse_url($this->embed_video_url);
        // $finalUrl = $finalUrl['scheme'] . '://' . $finalUrl['host'] . $finalUrl['path'];
        // $this->embed_video_url=$finalUrl;
        // return  $this->embed_video_url;
          return $this->embed_video_url; 
    }

    /**
     * @param mixed $embed_video_url
     */
    public function setEmbedVideoUrl($embed_video_url)
    {
        $this->embed_video_url = $embed_video_url;
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
    public function getDuration()
    {
        return $this->duration;
    }

    /**
     * @param mixed $duration
     */
    public function setDuration($duration)
    {
        $this->duration = $duration;
    }
    
    /**
     * @return mixed
     */
    public function getScreencastVideoId()
    {
        return $this->screencast_video_id;
    }

    /**
     * @param mixed $screencast_video_id
     */
    public function setScreencastVideoId($screencast_video_id)
    {
        $this->screencast_video_id = $screencast_video_id;
    }

    

    /**
     * @return mixed
     */
    public function getCompanyVideoId()
    {
        return $this->company_video_id;
    }

    /**
     * @param mixed $company_video_id
     */
    public function setCompanyVideoId($company_video_id)
    {
        $this->company_video_id = $company_video_id;
    }

    /**
     * @return mixed
     */
    public function getIsLargePreview()
    {
        return $this->is_large_preview;
    }

    /**
     * @param mixed $is_large_preview
     */
    public function setIsLargePreview($is_large_preview)
    {
        $this->is_large_preview = $is_large_preview;
    }

    /**
     * @return mixed
     */
    public function getVisibleProposal()
    {
        return $this->visible_proposal;
    }

    /**
     * @param mixed $visible_proposal
     */
    public function setVisibleProposal($visible_proposal)
    {
        $this->visible_proposal = $visible_proposal;
    }


    /**
     * @return mixed
     */
    public function getVisibleWorkOrder()
    {
        return $this->visible_work_order;
    }

    /**
     * @param mixed $visible_work_order
     */
    public function setVisibleWorkOrder($visible_work_order)
    {
        $this->visible_work_order = $visible_work_order;
    }



    /**
     * @return mixed
     */
    public function getIsIntro()
    {
        return $this->is_intro;
    }

    /**
     * @param mixed $is_intro
     */
    public function setIsIntro($is_intro)
    {
        $this->is_intro = $is_intro;
    }
    
    /**
     * @return mixed
     */
    public function getPlayerIconHide()
    {
        return $this->player_icon_hide;
    }

    /**
     * @param mixed $player_icon_hide
     */
    public function setPlayerIconHide($player_icon_hide)
    {
        $this->player_icon_hide = $player_icon_hide;
    }

    /**
     * @return mixed
     */
    public function getPlayerIconColor()
    {
        return $this->player_icon_color;
    }

    /**
     * @param mixed $player_icon_color
     */
    public function setPlayerIconColor($player_icon_color)
    {
        $this->player_icon_color = $player_icon_color;
    }

    function getCompanyCoverImage(){
        if($this->company_video_id !=0){
            $CI =& get_instance();
            $companylVideo = $CI->em->find('models\CompanyVideo',  $this->company_video_id);
            if($companylVideo){
                if($companylVideo->getThumbnailImage()){
                    return $companylVideo->getFullThumbImagePath();
                }
            }
        }
        return false;
    }

    function getCompanyABSCoverImage(){
        if($this->company_video_id !=0){
            $CI =& get_instance();
            $companylVideo = $CI->em->find('models\CompanyVideo',  $this->company_video_id);
            if($companylVideo){
                if($companylVideo->getThumbnailImage()){
                    return $companylVideo->getThumbImagePath();
                }
            }
        }
        return false;
    }


    
}