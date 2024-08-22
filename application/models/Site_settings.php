<?php

namespace models;
use \Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="site_settings")
 */
class Site_settings {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $settingId;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $settingName;
    /**
     * @ORM\Column(type="string", length=4086)
     */
    private $settingValue;

    function __construct() {
    }

    public function getSettingId() {
        return $this->settingId;
    }

    public function getSettingName() {
        return $this->settingName;
    }

    public function setSettingName($settingName) {
        $this->settingName = $settingName;
    }

    public function getSettingValue() {
        return $this->settingValue;
    }

    public function setSettingValue($settingValue) {
        $this->settingValue = $settingValue;
    }
}
