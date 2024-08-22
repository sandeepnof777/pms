<?php
class Servicesapi extends MY_Model {
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

}