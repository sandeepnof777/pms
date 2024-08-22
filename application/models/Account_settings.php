<?php
namespace models;
use Doctrine\ORM\Mapping as ORM;
use \Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity
 * @ORM\Table(name="account_settings")
 */
class Account_settings {
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false)
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $settingId;
    /**
     * @ORM\Column(type="integer")
     */
    private $account;
    /**
     * @ORM\Column(type="string")
     */
    private $settingName;
    /**
     * @ORM\Column(type="string")
     */
    private $settingValue;

    function __construct() {
    }

    public function getSettingId() {
        return $this->settingId;
    }

    public function getAccount() {
        return $this->account;
    }

    public function setAccount($account) {
        $this->account = $account;
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