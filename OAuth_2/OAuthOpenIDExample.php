<?php
if (isset($_GET["code"])) {
?>
    <script
        type="text/javascript"
        src="https://appcenter.intuit.com/Content/IA/intuit.ipp.anywhere-1.3.3.js">
    </script>
<?php
}
?>

<?php
require("Client.php");
$configs = include('config.php');
session_start();
$mainPage = $configs['mainPage'];
$client_id = $configs['client_id'];
$client_secret = $configs['client_secret'];
$authorizationRequestUrl = $configs['authorizationRequestUrl'];
$scope = $configs['openID_scope'];
$response_type = 'code';
$redirect_uri = $configs['openID_redirect_uri'];
$state = 'RandomState';
$grant_type= 'authorization_code';


$certFilePath = dirname(dirname(__FILE__)).'/OAuth_2/Certificate/cacert.pem';

$certFilePathOpenID = dirname(dirname(__FILE__)).'/OAuth_2/Certificate/sandbox_all_platform_intuit_com.pem';

$usrInfoURL = 'https://sandbox-accounts.platform.intuit.com/v1/openid_connect/userinfo';
$tokenEndPointUrl = $configs['tokenEndPointUrl'];

$OpenIDclient = new Client($client_id, $client_secret, $certFilePathOpenID);

if (!isset($_GET["code"]))
{
   $authUrl = $client->getAuthorizationURL($authorizationRequestUrl, $scope, $redirect_uri, $response_type, $state);
    header("Location: ".$authUrl);
    exit();
}
else
{
    $code = $_GET["code"];
    $responseState = $_GET['state'];
    if(strcmp($state, $responseState) != 0){
      throw new Exception("The state is not correct from Intuit Server. Consider your app is hacked.");
    }
    $result = $client->getAccessToken($tokenEndPointUrl,  $code, $redirect_uri, $grant_type);
    $openID_accessToken = $result['access_token'];
    
    $client->setCertificate($certFilePathOpenID);
    $userInfo = $client->callForOpenIDEndpoint($openID_accessToken, $usrInfoURL);
    $_SESSION['userInfo'] = $userInfo;
   
    var_dump($_SESSION['userInfo']);
    echo " <a href=\"javascript:void(0)\" onclick=\"return intuit.ipp.anywhere.logout(function ()
          { window.location.href = '" .$mainPage . "';});\">
          Sign Out and go back to Main page
    </a>";

}

?>
