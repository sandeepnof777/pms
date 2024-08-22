<?php
// Define the system path and application folder path
 

// Load the CodeIgniter framework
 
// require_once APPPATH . '../libraries/Custom_Radius.php';

// // Now, you can load and use your custom library
// $ci =& get_instance();
// $ci->load->driver('custom_radius');
    
// // Create an instance of CodeIgniter
// $CI = &get_instance();

// // Load the Redis library
// $CI->load->library('redis');

// // Use the library's functions/methods as needed
// $result = $CI->redis->flushAll();

// // Output the result
// echo 'Result: ' . $result;

$url="https://local.pms.pavementlayers.com/home/testpms";
$ch = curl_init();
curl_setopt($ch,CURLOPT_URL, $url);
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