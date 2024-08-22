<?php
session_start();
$result = $_SESSION['itemResult'];
include('connect.php');
$configs = include('config.php');
include('../vendor/autoload.php');

use QuickBooksOnline\API\Core\ServiceContext;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\PlatformService\PlatformService;
use QuickBooksOnline\API\Core\Http\Serialization\XmlObjectSerializer;
use QuickBooksOnline\API\Facades\Item;

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
$e_item_count=0;
$s_item_count=0;
if($result['items']){
	$itemsArr = $result['items'];
	foreach($itemsArr as $item){
		if($item['QBSyncFlag']==1){
			$Item = Item::create([
				  "Name" => $item['title'],
				  "Description" => $item['title'],
				  "Active" => true,
				  "FullyQualifiedName" => "",
				  "Taxable" => false,
				  "UnitPrice" => 0,
				   "Type" => "Inventory",
				  "IncomeAccountRef"=> [
					"value"=> 79,
					"name" => "Landscaping Services:Job Materials:Fountains and Garden Lighting"
				  ],
				  "PurchaseDesc"=> "This is the purchasing description.",
				  "PurchaseCost"=> 0,
				  "ExpenseAccountRef"=> [
					"value"=> 80,
					"name"=> "Cost of Goods Sold"
				  ],
				  "AssetAccountRef"=> [
					"value"=> 81,
					"name"=> "Inventory Asset"
				  ],
				  "TrackQtyOnHand" => true,
				  "QtyOnHand"=> 1,
				  "InvStartDate"=> $dateTime
			]);
			$resultingObj = $dataService->Add($Item);
			$error = $dataService->getLastError();
		} 
		else if($item['QBSyncFlag']==3){
			$entities = $dataService->Query("SELECT * FROM Item where Id='".$item['QBID']."'");
			$error = $dataService->getLastError();
			if ($error != null) {
				echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
				echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
				echo "The Response message is: " . $error->getResponseBody() . "\n";
			}
			$theItem = reset($entities);
			$updateItem = Item::update($theItem, [
				"Id" => $item['QBID'],
				"Name" => $item['title'],
				"Description" => $item['title'],
				"Active" => true,
				"FullyQualifiedName" => "",
				"Taxable" => false,
				"UnitPrice" => 0,
				"Type" => "Inventory",
				"IncomeAccountRef"=> [
				"value"=> 79,
				"name" => "Landscaping Services:Job Materials:Fountains and Garden Lighting"
				],
				"PurchaseDesc"=> "This is the purchasing description.",
				"PurchaseCost"=> 0,
				"ExpenseAccountRef"=> [
				"value"=> 80,
				"name"=> "Cost of Goods Sold"
				],
				"AssetAccountRef"=> [
				"value"=> 81,
				"name"=> "Inventory Asset"
				],
				"TrackQtyOnHand" => true,
				"QtyOnHand"=> 1,
				"InvStartDate"=> $dateTime
			]);
			$resultingObj = $dataService->Update($updateItem);
			$error = $dataService->getLastError();
		}
		
		if ($resultingObj) {
			$s_item_count++;
			$excluded = 1;
			mysqli_query($conn, "update company_qb_services set QBID='".$resultingObj->Id."', QBSyncToken='', QBSyncFlag='0', QBError='' where service_id='".$item['service_id']."' && company_id='".$item['company_id']."'");
		}
		else{
			$err = "The Status code is: " . $error->getHttpStatusCode() . "\n";
			$err .=  "The Helper message is: " . $error->getOAuthHelperError() . "\n";
			$err .= "The Response message is: " . $error->getResponseBody() . "\n";
			$e_item_count++;
			mysqli_query($conn, "update company_qb_services set QBError='".$err."' where service_id='".$item['service_id']."' && company_id='".$item['company_id']."'");
			$err ='';
			unset($error);
		}
	}
}
unset($_SESSION['itemResult']);
$_SESSION['e_item_count'] = $e_item_count;
$_SESSION['s_item_count'] = $s_item_count;

$loginPath = $configs['loginPath'];
header("location: ".$loginPath);?>
