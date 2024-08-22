<?php
session_start();
$result = $_SESSION['clientResult'];
include('connect.php');
$configs = include('config.php');
include('../vendor/autoload.php');

use QuickBooksOnline\API\Core\ServiceContext;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\PlatformService\PlatformService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Customer;

$client_id = $configs['client_id'];
$client_secret = $configs['client_secret'];
$QBORealmID = $configs['QBORealmID'];
$baseUrl = $configs['baseUrl'];
$access_token = $result['getqbSetting']['access_token'];
$refresh_token = $result['getqbSetting']['refresh_token'];
$dataService = DataService::Configure(array(
      'auth_mode' => 'oauth2',
	  'ClientID' => $client_id,
	  'ClientSecret' => $client_secret,
	  'accessTokenKey' =>  $access_token,
	  'refreshTokenKey' => $refresh_token,
	  'QBORealmID' => $QBORealmID,
	  'baseUrl' => $baseUrl
));
$dataService->setLogLocation("/Users/hlu2/Desktop/newFolderForLog");
$OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
$accessToken = $OAuth2LoginHelper->refreshToken();
$error = $OAuth2LoginHelper->getLastError();
if ($error != null) {
    echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
    echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
    echo "The Response message is: " . $error->getResponseBody() . "\n";
    return;
}
$dataService->updateOAuth2Token($accessToken);
 
date_default_timezone_set('Asia/Calcutta');
$dateTime = date("Y-m-d H:i:s");
$e_client_count=0;
$s_client_count=0;
// Add a customer
if($result['client']){
	$clientArr = $result['client'];
	foreach($clientArr as $client){
		if($client['businessPhone']!=''){
			$phone = $client['businessPhone'];
		}
		else{
			$phone = $client['cellPhone'];
		}
		
		if($client['QBSyncFlag']==1 || $client['QBSyncFlag']==3 && $client['QBID']==null || $client['QBSyncFlag']==1 || $client['QBSyncFlag']==3 && $client['QBID']==''){	
			$entities = $dataService->Query("SELECT * FROM Customer where FamilyName ='".$client['lastName']."' AND PrimaryEmailAddr='".$client['email']."' AND GivenName LIKE '".substr($client['firstName'],0,1)."%'");
			if(count($entities) > 0){
				$client['QBSyncFlag']=3;
				$client['QBID']=$entities[0]->Id;
			}
		}
		if($client['QBSyncFlag']==1 || $client['QBSyncFlag']==3 && $client['QBID']==null || $client['QBSyncFlag']==1 || $client['QBSyncFlag']==3 && $client['QBID']==''){		
			$customerObj = Customer::create([
			  "BillAddr" => [
				 "Line1"=>  $client['billingAddress'],
				 "City"=>  $client['billingCity'],
				 "Country"=>  $client['country'],
				 "CountrySubDivisionCode"=>  $client['billingState'],
				 "PostalCode"=>  $client['billingZip']
			 ],
			 "Notes" =>  "",
			 "Title"=>  "",
			 "GivenName"=>  $client['firstName'],
			 "MiddleName"=>  "",
			 "FamilyName"=>  $client['lastName'],
			 "Suffix"=>  "",
			 "FullyQualifiedName"=>  $client['firstName']." ".$client['lastName'],
			 "CompanyName"=>  $client['companyName'],
			 "DisplayName"=>  $client['firstName']." ".$client['lastName'],
			 "PrimaryPhone"=>  [
				 "FreeFormNumber"=>  $phone
			 ],
			 "PrimaryEmailAddr"=>  [
				 "Address" =>$client['email']
			 ]
			]);
			$resultingCustomerObj = $dataService->Add($customerObj);
			$error = $dataService->getLastError();
		}
		if($client['QBSyncFlag']==3 && $client['QBID'] != null || $client['QBSyncFlag']==3 && $client['QBID'] != ''){
			$entities = $dataService->Query("SELECT * FROM Customer where Id='".$client['QBID']."'");
			$error = $dataService->getLastError();
			if ($error != null){
				echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
				echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
				echo "The Response message is: " . $error->getResponseBody() . "\n";
			}
			$theCustomer = reset($entities);
			$customerObj = Customer::update($theCustomer, [
			 "Id"=>  $client['QBID'],
			  "BillAddr" => [
				 "Line1"=>  $client['billingAddress'],
				 "City"=>  $client['billingCity'],
				 "Country"=>  $client['country'],
				 "CountrySubDivisionCode"=>  $client['billingState'],
				 "PostalCode"=>  $client['billingZip']
			 ],
			 "Notes" =>  "",
			 "Title"=>  "",
			 "GivenName"=>  $client['firstName'],
			 "MiddleName"=>  "",
			 "FamilyName"=>  $client['lastName'],
			 "Suffix"=>  "",
			 "FullyQualifiedName"=>  $client['firstName']." ".$client['lastName'],
			 "CompanyName"=>  $client['companyName'],
			 "DisplayName"=>  $client['firstName']." ".$client['lastName'],
			 "PrimaryPhone"=>  [
				 "FreeFormNumber"=>  $phone
			 ],
			 "PrimaryEmailAddr"=>  [
				 "Address" =>$client['email']
			 ]
			]);
			$resultingCustomerObj = $dataService->Update($customerObj);
			$error = $dataService->getLastError();
		}
		if ($resultingCustomerObj) {
			$s_client_count++;
			mysqli_query($conn, "update clients set QBID='".$resultingCustomerObj->Id."', QBSyncToken='', QBSyncFlag='0', QBError='' where clientId='".$client['clientId']."' && company='".$client['company']."'");
		}
		else{
			$err = "The Status code is: " . $error->getHttpStatusCode() . "\n";
			$err .=  "The Helper message is: " . $error->getOAuthHelperError() . "\n";
			$err .= "The Response message is: " . $error->getResponseBody() . "\n";
			$e_client_count++;
			mysqli_query($conn, "update clients set QBError='".$err."' where clientId='".$client['clientId']."' && company='".$client['company']."'");
			$err ='';
			unset($error);
		}	
	}
}
unset($_SESSION['clientResult']);
$errorMsg = '</br></br></br><b>';									
$errorMsg .= $s_client_count;
$errorMsg .= ' client synced out of ';
$errorMsg .= $e_client_count+$s_client_count;
$errorMsg .= ' client.';
$errorMsg .= '</b></br>';
$_SESSION['clientMsg'] = $errorMsg;

$loginPath = $configs['loginPath'];
header("location: ".$loginPath);?>


