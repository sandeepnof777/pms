<?php
// defined('BASEPATH') OR exit('No direct script access allowed');

// class MyCodeIgniter {

//     protected $CI;

//     public function __construct() {
//         $this->CI =& get_instance();
//         // Load any libraries, models, or helpers you need here
//         $this->CI->load->library('redis');
//     }

//     // Add your custom functions here

//     public function test()
//     {
//         $redisResult = $CI->redis->flushAll();

//     }
// }

//$data_string = http_build_query($data);

$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch,CURLOPT_POST, count($data));
//curl_setopt($ch,CURLOPT_POSTFIELDS, $data_string);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec($ch);
curl_close($ch);

$result = json_decode($result,true);

echo "<pre>";
print_r($result);die;


?>