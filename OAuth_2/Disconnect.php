<?php
use Google\Auth\HttpHandler\HttpHandlerFactory;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Psr7;
use GuzzleHttp\Psr7\Request;

class Google_AccessToken_Revoke
{
  private $http;
  public function __construct(ClientInterface $http = null)
  {
    $this->http = $http;
  }
  public function revokeToken($token)
  {
    if (is_array($token)) {
      if (isset($token['refresh_token'])) {
        $token = $token['refresh_token'];
      } else {
        $token = $token['access_token'];
      }
    }
    $body = Psr7\stream_for(http_build_query(array('token' => $token)));
    $request = new Request(
        'POST',
        Google_Client::OAUTH2_REVOKE_URI,
        [
          'Cache-Control' => 'no-store',
          'Content-Type'  => 'application/x-www-form-urlencoded',
        ],
        $body
    );
    $httpHandler = HttpHandlerFactory::build($this->http);
    $response = $httpHandler($request);
    return $response->getStatusCode() == 200;
  }
}
session_start();    
$accesstoken=$_GET['access_token'];    
unset($_SESSION['access_token']);    
unset($_SESSION['userData']);       
$client = new Google_Client();    
$client->revokeToken($accesstoken);    
session_destroy(); 
