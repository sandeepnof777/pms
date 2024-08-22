<?php

require("Client.php");
$configs = include('config.php');
session_start();
$tokenEndPointUrl = $configs['tokenEndPointUrl'];
$mainPage = $configs['mainPage'];
$client_id = $configs['client_id'];
$client_secret = $configs['client_secret'];
$disconnectUrl = '../datauploadqb/logoutQbLogin';
$grant_type= 'refresh_token';

$certFilePath = dirname(dirname(__FILE__)).'/OAuth_2/Certificate/sandbox_all_platform_intuit_com.pem';
 
$refresh_token = $_SESSION['refresh_token'];
$client = new Client($client_id, $client_secret, $certFilePath);
if (!isset($_GET["deleteSession"])){
$result = $client->refreshAccessToken($tokenEndPointUrl, $grant_type, $refresh_token);
$_SESSION['access_token'] = $result['access_token'];
$_SESSION['refresh_token'] = $result['refresh_token'];
echo '<script type="text/javascript">
            window.location.href = \'' .$mainPage . '\';
          </script>';          
}else{
  $_SESSION['access_token'] = null;
  $_SESSION['refresh_token'] = null;
  echo '<script type="text/javascript">
              window.location.href = \'' .$disconnectUrl . '\';
            </script>';
}?>
