<?php

namespace models;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="announcements_hidden")
 */
class HiddenAnnouncement extends \MY_Model {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column (type="integer", nullable=false)
     */
    private $account_id;

    /**
     * @ORM\Column (type="integer", nullable=false)
     */
    private $announcement_id;


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
    public function getAnnouncementId()
    {
        return $this->announcement_id;
    }

    /**
     * @param mixed $announcement_id
     */
    public function setAnnouncementId($announcement_id)
    {
        $this->announcement_id = $announcement_id;
    }


    /* End Getters & Setters */

}
