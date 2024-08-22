<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;
/**
 * @ORM\Entity
 * @ORM\Table(name="announcements")
 */
class Announcement extends \MY_Model {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column (type="string", nullable=false)
     */
    private $title;

    /**
     * @ORM\Column (type="string")
     */
    private $video_url;

    /**
     * @ORM\Column (type="string", nullable=false)
     */
    private $text;

    /**
     * @ORM\Column (type="integer", nullable=false)
     */
    private $admin;

    /**
     * @ORM\Column (type="integer", nullable=false)
     */
    private $sticky;

    /**
     * @ORM\Column (type="datetime", nullable=false)
     */
    private $released;

    /**
     * @ORM\Column (type="datetime", nullable=false)
     */
    private $expires;

    /**
     * @ORM\Column (type="integer", nullable=false)
     */
    private $ord;

    /* Constructor */
    function __construct() {

    }

    /* Getters & Setters */

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
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
    public function getText()
    {
        return $this->text;
    }

    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * @return mixed
     */
    public function getAdmin()
    {
        return $this->admin;
    }

    /**
     * @param mixed $admin
     */
    public function setAdmin($admin)
    {
        $this->admin = $admin;
    }

    /**
     * @return mixed
     */
    public function getSticky()
    {
        return $this->sticky;
    }

    /**
     * @param mixed $sticky
     */
    public function setSticky($sticky)
    {
        $this->sticky = $sticky;
    }

    /**
     * @return mixed
     */
    public function getReleased()
    {
        return $this->released;
    }

    /**
     * @param mixed $released
     */
    public function setReleased($released)
    {
        $this->released = $released;
    }

    /**
     * @return mixed
     */
    public function getExpires()
    {
        return $this->expires;
    }

    /**
     * @param mixed $expires
     */
    public function setExpires($expires)
    {
        $this->expires = $expires;
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

    /* End Getters & Setters */

}
