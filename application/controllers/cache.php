<?php
class Cache extends CI_Controller {
    function __construct() {
        parent::__construct();
    }

    function index() {
    }

    function js() {
        header('Content-Type: application/javascript');
        echo $this->html->getJavaScripts();
    }


    function clearRedisCache()
    {           $this->_ci = &get_instance();
                $this->_ci->load->library('redis');
                $this->_ci->redis->flushAll();    
                echo "test";die;
     }

}
