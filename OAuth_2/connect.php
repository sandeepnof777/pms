<?php
if (strstr($_SERVER['HTTP_HOST'], 'staging.pavementlayers.com')) {
    $dbhost = 'localhost';
	$dbuser = 'pms';
	$dbpass = 'ejAurK4W9XcpHh';
	$dbname = 'pms';
}
//set the bd custom on pms
if (strstr($_SERVER['HTTP_HOST'], 'pms.pavementlayers.com')) {
   	$dbhost = 'localhost';
	$dbuser = 'pms';
	$dbpass = 'ejAurK4W9XcpHh';
	$dbname = 'pms';
}
// Change database if not on live server
if (!strstr($_SERVER['HTTP_HOST'], 'pms.pavementlayers.com') && !strstr($_SERVER['HTTP_HOST'], 'staging.pavementlayers.com')) {
    // Use the development database for all other environments
    $dbhost = '104.239.148.41';
	$dbuser = 'qb_dev';
	$dbpass = 'sk2bsYaZtVTGZrNG';
	$dbname = 'pms_dev';
}
$conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die(mysqli_error($conn));
// mysqli_select_db($conn, $dbname) or die(mysqli_error($conn));
?>
