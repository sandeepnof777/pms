<?php
session_start();
$result = $_SESSION['proposalData'];
include('connect.php');
$configs = include('config.php');
include('../vendor/autoload.php');

use QuickBooksOnline\API\Core\OAuth\OAuth2\OAuth2LoginHelper;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Facades\Customer;
use QuickBooksOnline\API\Facades\Item;
use QuickBooksOnline\API\Facades\Invoice;

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

date_default_timezone_set('Asia/Calcutta');
$dateTime = date("Y-m-d H:i:s");
$total_icount=0;
$icount=0;
if($result['proposaldetails']){
	$proposalArr = $result['proposaldetails'];
	foreach($proposalArr as $proposal_arr){
		$total_icount++;
		$proposal=$proposal_arr[0];
		if($proposal['clientDetails']){
			$client = $proposal['clientDetails'];
			if($client['businessPhone']!=''){
				$phone = $client['businessPhone'];
			}else{
				$phone = $client['cellPhone'];
			}
			$pcFlag='';
			$cc=1;
			if($client['QBSyncFlag']==1 || $client['QBSyncFlag']==3 && $client['QBID']==null || $client['QBSyncFlag']==1 || $client['QBSyncFlag']==3 && $client['QBID']==''){	
				$entities = $dataService->Query("SELECT * FROM Customer where FamilyName ='".$client['lastName']."' AND PrimaryEmailAddr='".$client['email']."' AND GivenName LIKE '".substr($client['firstName'],0,1)."%'");
				if(count($entities) > 0){
					$client['QBSyncFlag']=3;
					$client['QBID']=$entities[0]->Id;
				}
			}
			if($client['QBSyncFlag']==1){	
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
				if ($error != null) {
					$loginHelper = new OAuth2LoginHelper($client_id, $client_secret);
					$dataService = $loginHelper->refresh_qbo_token($refresh_token,$QBORealmID);
					$resultingCustomerObj = $dataService->Add($customerObj);
					$error = $dataService->getLastError();
				}

				if ($resultingCustomerObj) {
					$client_QBID= $resultingCustomerObj->Id;
					mysqli_query($conn, "update clients set QBID='".$resultingCustomerObj->Id."', QBSyncToken='', QBSyncFlag='0', QBError='' where clientId='".$client['clientId']."' && company='".$client['company']."'");
					$pcFlag='OK';
					$cc=1;
				}
				else {
					

					if ($error != null) {
						
						$c_err = "The Status code is: " . $error->getHttpStatusCode() . "\n";
						$c_err .=  "The Helper message is: " . $error->getOAuthHelperError() . "\n";
						$c_err .= "The Response message is: " . $error->getResponseBody() . "\n";
						mysqli_query($conn, "update clients set QBError='".$c_err."' where clientId='".$client['clientId']."' && company='".$client['company']."'");
						$c_err ='';
						$client_QBID='';
						if($cc==1){
							$cc++;
							$pcFlag='';
						}
					}
				}
			}
			if($client['QBSyncFlag']==3){
				$entities = $dataService->Query("SELECT * FROM Customer where Id='".$client['QBID']."'");
				$error = $dataService->getLastError();
				if ($error != null) {
					
					$loginHelper = new OAuth2LoginHelper($client_id, $client_secret);
					$dataService = $loginHelper->refresh_qbo_token($refresh_token,$QBORealmID);
					$entities = $dataService->Query("SELECT * FROM Customer where Id='".$client['QBID']."'");
					$error = $dataService->getLastError();
						if ($error != null) {
							echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
							echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
							echo "The Response message is: " . $error->getResponseBody() . "\n";
						}
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
				if ($error != null) {
					$loginHelper = new OAuth2LoginHelper($client_id, $client_secret);
					$dataService = $loginHelper->refresh_qbo_token($refresh_token,$QBORealmID);
					$resultingCustomerObj = $dataService->Update($customerObj);
					$error = $dataService->getLastError();
				}
				if ($resultingCustomerObj) {
					$client_QBID= $resultingCustomerObj->Id;
					mysqli_query($conn, "update clients set QBID='".$resultingCustomerObj->Id."', QBSyncToken='', QBSyncFlag='0', QBError='' where clientId='".$client['clientId']."' && company='".$client['company']."'");
					$pcFlag='OK';
					$cc=1;
				}
				else {
					

					
						$c_err = "The Status code is: " . $error->getHttpStatusCode() . "\n";
						$c_err .=  "The Helper message is: " . $error->getOAuthHelperError() . "\n";
						$c_err .= "The Response message is: " . $error->getResponseBody() . "\n";
						mysqli_query($conn, "update clients set QBError='".$c_err."' where clientId='".$client['clientId']."' && company='".$client['company']."'");
						$c_err ='';
						$client_QBID='';
						if($cc==1){
							$cc++;
							$pcFlag='';
						}
					
				}
			}
			if($client['QBSyncFlag']!=1 && $client['QBSyncFlag']!=3 && $client['QBID'] == '' || $client['QBSyncFlag']!=1 && $client['QBSyncFlag']!=3 && $client['QBID'] == null){
				if($cc==1){
					$cc++;
					$pcFlag='';
				}
			}
			if($client['QBID']){
				$client_QBID = $client['QBID'];
				$pcFlag='OK';
				$cc=1;
			}
		}
		
		if($proposal['proposalServices']){
			$itemsArr = $proposal['proposalServices'];
			$psFlag='';
			$ic=1;
			
			$count1=1; 
			$arraInv=array();
			foreach($itemsArr as $items){
				$initial_service_id = $items['initial_service'];
				$item_price = substr($items['price'], 1);
				if($initial_service_id){
					$CQBSGetQue = mysqli_query($conn, "SELECT * FROM company_qb_services where service_id='".$initial_service_id."'");
					if(mysqli_num_rows($CQBSGetQue) > 0){
						$item = mysqli_fetch_assoc($CQBSGetQue);
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
							if ($error != null) {
								$loginHelper = new OAuth2LoginHelper($client_id, $client_secret);
								$dataService = $loginHelper->refresh_qbo_token($refresh_token,$QBORealmID);
								$resultingObj = $dataService->Add($Item);
								$error = $dataService->getLastError();
							}

							if($resultingObj){
								$item_QBID = $resultingObj->Id;
								mysqli_query($conn, "update company_qb_services set QBID='".$resultingObj->Id."', QBSyncToken='', QBSyncFlag='0', QBError='' where service_id='".$item['service_id']."' && company_id='".$item['company_id']."'");
								$psFlag='OK';
								$ic=1;
								$arrayInv[] = array("QBID"=>$item_QBID,"title"=>$item['title'],"item_price"=>$item_price);	
							}
							else{

								
								if ($error != null) {
									$err = "The Status code is: " . $error->getHttpStatusCode() . "\n";
									$err .=  "The Helper message is: " . $error->getOAuthHelperError() . "\n";
									$err .= "The Response message is: " . $error->getResponseBody() . "\n";
									mysqli_query($conn, "update company_qb_services set QBError='".$err."' where service_id='".$item['service_id']."' && company_id='".$item['company_id']."'");
									$err ='';
									if($ic==1){
										$ic++;
										$psFlag='';
									}
								}
							}
						} 
						if($item['QBSyncFlag']==3){
							$entities = $dataService->Query("SELECT * FROM Item where Id='".$item['QBID']."'");
							$error11.$count1 = $dataService->getLastError();
							if ($error11.$count1 != null) {
								echo "The Status code is: " . $error11.$count1 ->getHttpStatusCode() . "\n";
								echo "The Helper message is: " . $error11.$count1 ->getOAuthHelperError() . "\n";
								echo "The Response message is: " . $error11.$count1 ->getResponseBody() . "\n";
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
							$error1 = $dataService->getLastError();
							if ($error1 != null) {
								$loginHelper = new OAuth2LoginHelper($client_id, $client_secret);
								$dataService = $loginHelper->refresh_qbo_token($refresh_token,$QBORealmID);
								$resultingObj = $dataService->Update($updateItem);
								$error1 = $dataService->getLastError();
							}

							if($resultingObj){
								$item_QBID = $resultingObj->Id;
								mysqli_query($conn, "update company_qb_services set QBID='".$resultingObj->Id."', QBSyncToken='', QBSyncFlag='0', QBError='' where service_id='".$item['service_id']."' && company_id='".$item['company_id']."'");
								$psFlag='OK';
								$ic=1;
								$arrayInv[] = array("QBID"=>$item_QBID,"title"=>$item['title'],"item_price"=>$item_price);	
							}
							else{
								

								if ($error1 != null) {
									$err1 = "The Status code is: " . $error1->getHttpStatusCode() . "\n";
									$err1 .=  "The Helper message is: " . $error1->getOAuthHelperError() . "\n";
									$err1 .= "The Response message is: " . $error1->getResponseBody() . "\n";
									mysqli_query($conn, "update company_qb_services set QBError='".$err1."' where service_id='".$item['service_id']."' && company_id='".$item['company_id']."'");
									$err1 ='';
									if($ic==1){
										$ic++;
										$psFlag='';
									}
								}
							}
						}
						
						if($item['QBSyncFlag']!=1 && $item['QBSyncFlag']!=3 && $item['QBID'] == '' || $item['QBSyncFlag']!=1 && $item['QBSyncFlag']!=3 && $item['QBID'] == null){
							if($ic==1){
								$ic++;
								$psFlag='';
							}
						}
						if($item['QBID'] && $item['QBSyncFlag']!=1 && $item['QBSyncFlag']!=3){
							$QBID = $item['QBID'];
							$psFlag='OK';
							$ic=1;
							$arrayInv[] = array("QBID"=>$item['QBID'],"title"=>$item['title'],"item_price"=>$item_price);		
						}
					}
				}
			}
		}
		$tt = [];
		foreach($arrayInv as $Arrval){
		$tt[] = [
				 "Amount" => str_replace( ',', '', $Arrval['item_price'] ),
				 "DetailType" => "SalesItemLineDetail",
				 "SalesItemLineDetail" => [
				   "ItemRef" => [
					 "value" => $Arrval['QBID'] 
					],
					"Qty"=>1
				  ]
				  ];
				  
		}
		unset($arrayInv);
		//Payment Amount
		$monthStartDate = date('Y-m-01');
		$entities = $dataService->Query("SELECT * FROM Invoice WHERE MetaData.LastUpdatedTime >= '".$monthStartDate."' AND MetaData.LastUpdatedTime <= CURRENT_DATE");
		foreach($entities as $entity){
			if($entity->TotalAmt!=$entity->Balance){
				$payed_amount = ($entity->TotalAmt)-($entity->Balance);
				if($entity->Balance==0){
					$invoice_status='Paid';
				}else if($entity->Balance==$entity->TotalAmt){
					$invoice_status='Unpaid';
				}else{
					$invoice_status='PartialPaid';
				}
				mysqli_query($conn, "update proposals set invoice_status='".$invoice_status."',invoice_amount='".$payed_amount."' where QBID='".$entity->Id."'");
			}
		}
		//End payment Anount
		//Add a new Invoice
		if($pcFlag=='OK' && $psFlag=='OK'){
			$pcFlag='';
			$psFlag='';
			if($proposal['QBSyncFlag']==1){
				$theResourceObj = Invoice::create([
					"Line" =>$tt,
					"CustomerRef"=> [
						"value"=> $client_QBID
					],
					"BillEmail" => [
						"Address" => "Familiystore@intuit.com"
					]
				]);
				$resultingObj = $dataService->Add($theResourceObj);
				$error = $dataService->getLastError();
				if ($error != null) {
						$loginHelper = new OAuth2LoginHelper($client_id, $client_secret);
						$dataService = $loginHelper->refresh_qbo_token($refresh_token,$QBORealmID);
						$resultingObj = $dataService->Add($theResourceObj);
						$error1 = $dataService->getLastError();
				}
				
			}	
			if($proposal['QBSyncFlag']==3){
				$entities = $dataService->Query("SELECT * FROM Invoice where Id='".$proposal['QBID']."'");
				$error = $dataService->getLastError();
				if ($error != null) {
					echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
					echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
					echo "The Response message is: " . $error->getResponseBody() . "\n";
				}
				$theInvoice = reset($entities);
				$theResourceObj = Invoice::update($theInvoice, [
					"Id" => $proposal['QBID'],
					"Line" =>$tt,
					"CustomerRef"=> [
						"value"=> $client_QBID
					],
					"BillEmail" => [
						"Address" => "Familiystore@intuit.com"
					]
				]);
				$resultingObj = $dataService->Update($theResourceObj);
				$error = $dataService->getLastError();
				if ($error != null) {
					$loginHelper = new OAuth2LoginHelper($client_id, $client_secret);
					$dataService = $loginHelper->refresh_qbo_token($refresh_token,$QBORealmID);
					$resultingObj = $dataService->Update($theResourceObj);
					$error1 = $dataService->getLastError();
				}
			}
			if ($resultingObj) {
				$s_item_count++;
				$icount++;
				mysqli_query($conn, "update proposals set QBID='".$resultingObj->Id."', QBSyncToken='', QBSyncFlag='0', QBError='' where proposalId='".$proposal['proposalId']."'");
			}
			else{

				$err = "The Status code is: " . $error->getHttpStatusCode() . "\n";
				$err .=  "The Helper message is: " . $error->getOAuthHelperError() . "\n";
				$err .= "The Response message is: " . $error->getResponseBody() . "\n";
				$s_invoice_count++;
				mysqli_query($conn, "update proposals set QBError='".$err."' where proposalId='".$proposal['proposalId']."'");
				$err ='';
			}
		}
	}
}
unset($_SESSION['proposalData']);
$errorMsg = '</br></br></br><b>';									
$errorMsg .= $icount;
$errorMsg .= ' invoice synced out of ';
$errorMsg .= $total_icount;
$errorMsg .= ' invoice.';
$errorMsg .= '</b></br>';
$_SESSION['clientMsg'] = $errorMsg;

$loginPath = $configs['loginPath'];
header("location: ".$loginPath);?>

