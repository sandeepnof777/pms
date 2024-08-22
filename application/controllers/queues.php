<?php

use Intervention\Image\ImageManager;
use \Pms\Traits\RepositoryTrait;
use \Pms\Traits\PMSTrait;

class Queues extends MY_Controller
{
    

    function __construct()
    {
        parent::__construct();
    }

    function run(){
        $this->load->model('system_email');

        $data_read = file_get_contents("redisQueueLogTime.log");
        $time = time();
        
        if( ($time - $data_read) > 30 ){
            file_put_contents('cronRunTest.txt', time().PHP_EOL , FILE_APPEND | LOCK_EX);
        
            $this->load->library('jobs');
            
            $this->jobs->worker('worker',$_ENV['QUEUE_EMAIL']);
            //$this->jobs->worker('worker',$_ENV['QUEUE_HIGH']);
         }else{
             echo 'Queque Already Running';
         }

        
    }

   

}