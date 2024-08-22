<?php
class AccountSettings extends MY_Model {
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    var $em;
    /**
     * @var CI_DB_driver
     */
    var $db;

    function __construct() {
        parent::__construct();
    }

    function getSetting($account, $settingName) {
        $setting = $this->em->getRepository('models\Account_settings')->findOneBy(array('account' => $account, 'settingName' => $settingName));
        if (!$setting) {
            return NULL;
        } else {
            return $setting->getSettingValue();
            return $setting->getSettingValue();
        }
    }

    function setSetting($account, $settingName, $settingValue) {
        $setting = $this->em->getRepository('models\Account_settings')->findOneBy(array('account' => $account, 'settingName' => $settingName));
        if (!$setting) {
            $setting = new \models\Account_settings();
        }
        $setting->setAccount($account);
        $setting->setSettingName($settingName);
        $setting->setSettingValue($settingValue);
        $this->em->persist($setting);
        $this->em->flush();
    }
}