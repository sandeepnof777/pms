<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="company_videos")
 */
class CompanyVideo { 

    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(type="integer",nullable=true)
     */
    private $company_id;

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
     * @ORM\Column(type="datetime")
     */
    private $created_at;
    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;
    /**
     * @ORM\Column(type="datetime")
     */
    private $deleted_at;
     /**
     * @ORM\Column(type="integer")
     */
    private $is_deleted=0;
     /**
     * @ORM\Column(type="integer")
     */
    private $include_in_proposal=0;
    /**
     * @ORM\Column(type="integer")
     */
    private $is_intro=0;
     /**
     * @ORM\Column(type="integer")
     */
    private $player_icon_hide=0;
    
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
    public function getDeletedAt()
    {
        return $this->deleted_at;
    }

    /**
     * @param mixed $deleted_at
     */
    public function setDeletedAt($deleted_at)
    {
        $this->deleted_at = $deleted_at;
    }

    
     /**
     * @return mixed
     */
    public function getIsDeleted()
    {
        return $this->is_deleted;
    }

    /**
     * @param mixed $is_deleted
     */
    public function setIsDeleted($is_deleted)
    {
        $this->is_deleted = $is_deleted;
    }


     /**
     * @return mixed
     */
    public function getIncludeInProposal()
    {
        return $this->include_in_proposal;
    }

    /**
     * @param mixed $include_in_proposal
     */
    public function setIncludeInProposal($include_in_proposal)
    {
        $this->include_in_proposal = $include_in_proposal;
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

    function getFullThumbImagePath(){
        if($this->getThumbnailImage()){
            return site_url('uploads/companies/').'/' . $this->getCompanyId() . '/company_video_cover/' .$this->getThumbnailImage() ;
        }else{
            return '';
        }
        
    }

    function getThumbImagePath(){
        if($this->getThumbnailImage()){
            return UPLOADPATH . '/companies/' . $this->getCompanyId() . '/company_video_cover/' . $this->getThumbnailImage();
            
        }else{
            return '';
        }
        
    }
}