<?php
class Settings extends MY_Model {
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

    /*New*/
    function get($settingName = '') {
        $setting = $this->em->getRepository('models\Account_settings')->findOneBy(array('account' => 0, 'settingName' => $settingName));
        if (!$setting) {
            return NULL;
        } else {
            return $setting->getSettingValue();
        }
    }

    function set($settingName = '', $value = '') {
        $setting = $this->em->getRepository('models\Account_settings')->findOneBy(array('account' => 0, 'settingName' => $settingName));
        if (!$setting) {
            $setting = new \models\Account_settings();
        }
        $setting->setAccount(0);
        $setting->setSettingName($settingName);
        $setting->setSettingValue($value);
        $this->em->persist($setting);
        $this->em->flush();
    }

    function save($settings = array()) {
        if (is_array($settings)) {
            foreach ($settings as $setting => $value) {
                $this->set($setting, $value);
            }
        }
    }

    function getEmailSettings() {
        $email_settings = array();

        return $email_settings;
    }


}