<?php
use \yidas\queue\worker\Controller as WorkerController;

class Worker extends \yidas\queue\worker\Controller
{
    // Initializer
    protected function init() {

        $myfile = fopen("newfile.txt", "w") or die("Unable to open file!");
        $txt = "John Doe\n";
        fwrite($myfile, $txt);
        $txt = "Jane Doe\n";
        fwrite($myfile, $txt);
        fclose($myfile);
    }
    
    // Worker
    protected function handleWork() {

       
    }
    
    // Listener
    protected function handleListen() {}

    function index(){
        echo 'test';
    }
}