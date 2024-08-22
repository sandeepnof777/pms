<?php
require("Client.php");

// QuickBook credentials based on host
// if (strstr($_SERVER['HTTP_HOST'], 'pms.pavementlayers.com')) {
//     $config = [
//         'authorizationRequestUrl' => 'https://appcenter.intuit.com/connect/oauth2',
//         'tokenEndPointUrl' => 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer',
//         'client_id' => 'Q0I5cQBFtvPHiSXIdQnoItEPN5yZzWusyufLGdG9YdZlrxHxoZ',
//         'client_secret' => 'LQWdGYWHyirTrcTORWn836XwY8qOLD9ciZkLCS3G',
//         'oauth_scope' => 'com.intuit.quickbooks.accounting',
//         'openID_scope' => 'pavement.layer@gmail.com',
//         'oauth_redirect_uri' => 'https://pms.pavementlayers.com/OAuth_2/OAuth2PHPExample.php',
//         'openID_redirect_uri' => 'https://pms.pavementlayers.com/OAuth_2/OAuthOpenIDExample.php',
//         'mainPage' => 'https://pms.pavementlayers.com/account/qbsettings',
//         'refreshTokenPage' => 'https://pms.pavementlayers.com/OAuth_2/RefreshToken.php',
//         'baseUrl' => 'development',
//         'loginPath' => 'https://pms.pavementlayers.com/account/qbsettings/qblogin',
//     ];
// } else {
//     $config = [
//         'authorizationRequestUrl' => 'https://appcenter.intuit.com/connect/oauth2',
//         'tokenEndPointUrl' => 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer',
//         //'client_id' => 'L0C4EoRwlIIpDxX4jJHONwGIJmcdtRBltGSbg3F8KPoYkXvskh',
//         //'client_secret' => 'BrJ3E29aqtd69m9S9UGDVhmaHZ1Mda1LpDZL516q',
//         'client_id' => 'Q0I5cQBFtvPHiSXIdQnoItEPN5yZzWusyufLGdG9YdZlrxHxoZ',
//         'client_secret' => 'LQWdGYWHyirTrcTORWn836XwY8qOLD9ciZkLCS3G',
        
//         'oauth_scope' => 'com.intuit.quickbooks.accounting',
//         'openID_scope' => 'pavement.layer@gmail.com',
//         'oauth_redirect_uri' => 'https://staging.pavementlayers.com/OAuth_2/OAuth2PHPExample.php',
//         'openID_redirect_uri' => 'https://staging.pavementlayers.com/OAuth_2/OAuthOpenIDExample.php',
//         'mainPage' => 'https://staging.pavementlayers.com/account/qbsettings',
//         'refreshTokenPage' => 'https://staging.pavementlayers.com/OAuth_2/RefreshToken.php',
//         'baseUrl' => 'development',
//         'loginPath' => 'https://staging.pavementlayers.com/account/qbsettings/qblogin',
//     ];
// }


if (strstr($_SERVER['HTTP_HOST'], 'pms.pavementlayers.com')) {
    $config = [
        'authorizationRequestUrl' => 'https://appcenter.intuit.com/connect/oauth2',
        'tokenEndPointUrl' => 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer',
        'client_id' => 'ABNPRDBoN3yuoj0zhQzNJkTncvWyBkay0Kqa8mz1iXEiaz5Ltm',
        'client_secret' => 'HlOvQL3Dmp9EUMEJwNeEfIWC19U57VYpTFizK1P9',
        'oauth_scope' => 'com.intuit.quickbooks.accounting',
        'openID_scope' => 'sandysvimmca@gmail.com',
        'oauth_redirect_uri' => 'https://local.pms.pavementlayers.com/OAuth_2/OAuth2PHPExample.php',
        'openID_redirect_uri' => 'https://local.pms.pavementlayers.com/OAuth_2/OAuthOpenIDExample.php',
        'mainPage' => 'https://local.pms.pavementlayers.com/account/qbsettings',
        'refreshTokenPage' => 'https://local.pms.pavementlayers.com/OAuth_2/RefreshToken.php',
        'baseUrl' => 'development',
        'loginPath' => 'https://local.pms.pavementlayers.com/account/qbsettings/qblogin',
    ];
} else {
    $config = [
        'authorizationRequestUrl' => 'https://appcenter.intuit.com/connect/oauth2',
        'tokenEndPointUrl' => 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer',
        'client_id' => 'ABNPRDBoN3yuoj0zhQzNJkTncvWyBkay0Kqa8mz1iXEiaz5Ltm',
        'client_secret' => 'HlOvQL3Dmp9EUMEJwNeEfIWC19U57VYpTFizK1P9',
        'oauth_scope' => 'com.intuit.quickbooks.accounting',
        'openID_scope' => 'sandysvimmca@gmail.com',
        'oauth_redirect_uri' => 'https://local.pms.pavementlayers.com/OAuth_2/OAuth2PHPExample.php',
        'openID_redirect_uri' => 'https://local.pms.pavementlayers.com/OAuth_2/OAuthOpenIDExample.php',
        'mainPage' => 'https://local.pms.pavementlayers.com/account/qbsettings',
        'refreshTokenPage' => 'https://local.pms.pavementlayers.com/OAuth_2/RefreshToken.php',
        'baseUrl' => 'development',
        'loginPath' => 'https://local.pms.pavementlayers.com/account/qbsettings/qblogin',
    ];
}


session_start();
$authorizationRequestUrl = $config['authorizationRequestUrl'];
$tokenEndPointUrl = $config['tokenEndPointUrl'];
$client_id = $config['client_id'];
$client_secret = $config['client_secret'];
$scope = $config['oauth_scope'];
$redirect_uri = $config['oauth_redirect_uri'];
$response_type = 'code';
$state = 'RandomState';
$include_granted_scope = 'false';
$grant_type = 'authorization_code';
$certFilePath = dirname(dirname(__FILE__)) . '/OAuth_2/Certificate/cacert.pem';
$client = new Client($client_id, $client_secret, $certFilePath);

if (!isset($_GET["code"])) {
    unset($_SESSION['access_token']);
    unset($_SESSION['refresh_token']);
    $authUrl = $client->getAuthorizationURL($authorizationRequestUrl, $scope, $redirect_uri, $response_type, $state);
    header("Location: " . $authUrl);
    exit();
} else {
    $code = $_GET["code"];
    $realmId = $_GET['realmId'];
    $responseState = $_GET['state'];
    if (strcmp($state, $responseState) != 0) {
        echo 'An error occurred';
        throw new Exception("The state is not correct from Intuit Server. Consider your app is hacked.");
    }
    $result = $client->getAccessToken($tokenEndPointUrl, $code, $redirect_uri, $grant_type);
    $_SESSION['access_token'] = $result['access_token'];
    $_SESSION['refresh_token'] = $result['refresh_token'];
    $_SESSION['realmId'] = $realmId;
    $_SESSION['connected'] = false;

    echo ' <!DOCTYPE html>
           <script type="text/javascript">
               window.opener.location.href = "/account/qbonline"
               window.close();   
          </script>';

}
