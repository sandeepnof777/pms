<?php

class Client{
    private $client_id;
    private $client_secret;
    const HTTP_METHOD_GET    = 'GET';
    const HTTP_METHOD_POST   = 'POST';
    const HTTP_METHOD_PUT    = 'PUT';
    const HTTP_METHOD_DELETE = 'DELETE';
    const HTTP_METHOD_HEAD   = 'HEAD';
    const HTTP_METHOD_PATCH   = 'PATCH';

    public function __construct($client_id, $client_secret, $certificate_file = null)
    {
        if (!extension_loaded('curl')) {
            throw new Exception('The PHP exention curl must be installed to use this library.', Exception::CURL_NOT_FOUND);
        }
        if(!isset($client_id) || !isset($client_secret)){
            throw new Exception('The App key must be set.', Exception::InvalidArgumentException);
        }

        $this->client_id     = $client_id;
        $this->client_secret = $client_secret;
        $this->setCertificate($certificate_file);
    }

    public function setCertificate($certificate_file){
      $this->certificate_file = $certificate_file;
	  
      if (!empty($this->certificate_file)  && !is_file($this->certificate_file)) {
          throw new InvalidArgumentException('The certificate file was not found', InvalidArgumentException::CERTIFICATE_NOT_FOUND);
      }
    }

    public function callForOpenIDEndpoint($access_token, $url){
      $authorizationHeaderInfo = $this->generateAccessTokenHeader($access_token);
      $http_header = array(
        'Accept' => 'application/json',
        'Authorization' => $authorizationHeaderInfo
      );
      $result = $this->executeRequest($url , null, $http_header, self::HTTP_METHOD_GET);
      return $result;
    }

    private function generateAccessTokenHeader($access_token){
      $authorizationheader = 'Bearer ' . $access_token;
      return $authorizationheader;
    }


    public function getAuthorizationURL($authorizationRequestUrl, $scope, $redirect_uri, $response_type, $state){
        $parameters = array(
          'client_id' => $this->client_id,
          'scope' => $scope,
          'redirect_uri' => $redirect_uri,
          'response_type' => $response_type,
          'state' => $state
        );
        $authorizationRequestUrl .= '?' . http_build_query($parameters, null, '&', PHP_QUERY_RFC1738);
        return $authorizationRequestUrl;
    }

    public function getAccessToken($tokenEndPointUrl, $code, $redirectUrl, $grant_type){
       if(!isset($grant_type)){
          throw new InvalidArgumentException('The grant_type is mandatory.', InvalidArgumentException::INVALID_GRANT_TYPE);
       }

       $parameters = array(
         'grant_type' => $grant_type,
         'code' => $code,
         'redirect_uri' => $redirectUrl
       );
       $authorizationHeaderInfo = $this->generateAuthorizationHeader();
       $http_header = array(
         'Accept' => 'application/json',
         'Authorization' => $authorizationHeaderInfo,
         'Content-Type' => 'application/x-www-form-urlencoded'
       );

       //Try catch???
       $result = $this->executeRequest($tokenEndPointUrl , $parameters, $http_header, self::HTTP_METHOD_POST);
       return $result;
    }

    public function refreshAccessToken($tokenEndPointUrl, $grant_type, $refresh_token){
      $parameters = array(
        'grant_type' => $grant_type,
        'refresh_token' => $refresh_token
      );

      $authorizationHeaderInfo = $this->generateAuthorizationHeader();
      $http_header = array(
        'Accept' => 'application/json',
        'Authorization' => $authorizationHeaderInfo,
        'Content-Type' => 'application/x-www-form-urlencoded'
      );
      $result = $this->executeRequest($tokenEndPointUrl , $parameters, $http_header, self::HTTP_METHOD_POST);
      return $result;
    }

    private function generateAuthorizationHeader(){
        $encodedClientIDClientSecrets = base64_encode($this->client_id . ':' . $this->client_secret);
        $authorizationheader = 'Basic ' . $encodedClientIDClientSecrets;
        return $authorizationheader;
    }

    private function executeRequest($url, $parameters = array(), $http_header="", $http_method="")
    {

      $curl_options = array();

      switch($http_method){
            case self::HTTP_METHOD_GET:
              $curl_options[CURLOPT_HTTPGET] = 'true';
              if (is_array($parameters) && count($parameters) > 0) {
                $url .= '?' . http_build_query($parameters);
              } elseif ($parameters) {
                $url .= '?' . $parameters;
              }
              break;
            case self:: HTTP_METHOD_POST:
              $curl_options[CURLOPT_POST] = '1';
              if(is_array($parameters) && count($parameters) > 0){
                $body = http_build_query($parameters);
                $curl_options[CURLOPT_POSTFIELDS] = $body;
              }
              break;
            default:
              break;
      }
      if(is_array($http_header)){
            $header = array();
            foreach($http_header as $key => $value) {
                $header[] = "$key: $value";
            }
            $curl_options[CURLOPT_HTTPHEADER] = $header;
      }

      $curl_options[CURLOPT_URL] = $url;
      $ch = curl_init(); 
      curl_setopt_array($ch, $curl_options);

      if (!empty($this->certificate_file)) {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
			/*Change this path as per your application path*/
          //  curl_setopt($ch,CURLOPT_CAINFO, "/var/www/vhosts/staging.pavementlayers.com/OAuth_2/Certificate/cacert.pem"); 
            curl_setopt($ch,CURLOPT_CAINFO, "/laragon/www/pms.pavementlayers.com/OAuth_2/Certificate/cacert.pem");  
 
      } else {
            throw new Exception('Cannot find the SSL certificate_file.');
      }
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	  
      $result = curl_exec($ch);

      $headerSent = curl_getinfo($ch, CURLINFO_HEADER_OUT );

      $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);


      $content_type = curl_getinfo($ch, CURLINFO_CONTENT_TYPE);
       if ($curl_error = curl_error($ch)) {
           throw new Exception($curl_error);
       } else {
           $json_decode = json_decode($result, true);
       }
       curl_close($ch);
       return $json_decode;
    }
}
 ?>
