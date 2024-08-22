<?php
namespace Pms\Repositories;

use Carbon\Carbon;
use models\CompanyQbService;
use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;
use \models\QuickbooksSettings;
use \models\Companies;
use QuickBooksOnline\API\Core\OAuth\OAuth2\OAuth2LoginHelper;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Facades\Item;
use QuickBooksOnline\API\Facades\Customer;
use QuickBooksOnline\API\Facades\Invoice;

class Quickbooks extends RepositoryAbstract
{
    use DBTrait;

    /* @var $config array */
    var $config;
    /* @var $dataService DataService */
    var $dataService;
    var $OAuth2LoginHelper;
    var $accessToken;

    function __construct()
    {
        parent::__construct();
        $this->setConfig();
    }

    private function setConfig()
    {
        if (DEV) {
            // $config = [
            //     'authorizationRequestUrl' => 'https://appcenter.intuit.com/connect/oauth2',
            //     'tokenEndPointUrl' => 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer',
            //     //'client_id' => 'L0C4EoRwlIIpDxX4jJHONwGIJmcdtRBltGSbg3F8KPoYkXvskh',
            //     //'client_secret' => 'BrJ3E29aqtd69m9S9UGDVhmaHZ1Mda1LpDZL516q',
                
            //     'client_id' => 'Q0I5cQBFtvPHiSXIdQnoItEPN5yZzWusyufLGdG9YdZlrxHxoZ',
            //     'client_secret' => 'LQWdGYWHyirTrcTORWn836XwY8qOLD9ciZkLCS3G',

            //     'oauth_scope' => 'com.intuit.quickbooks.accounting',
            //     'openID_scope' => 'pavement.layer@gmail.com',
            //     'oauth_redirect_uri' => 'https://staging.pavementlayers.com/OAuth_2/OAuth2PHPExample.php',
            //     'openID_redirect_uri' => 'https://staging.pavementlayers.com/OAuth_2/OAuthOpenIDExample.php',
            //     'mainPage' => 'https://staging.pavementlayers.com/account/qbsettings',
            //     'refreshTokenPage' => 'https://staging.pavementlayers.com/OAuth_2/RefreshToken.php',
            //     //'baseUrl' => 'development',

            //     'baseUrl' => 'Production',

            //     'loginPath' => 'https://staging.pavementlayers.com/account/qbsettings/qblogin',
            // ];
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
            // $config = [
            //     'authorizationRequestUrl' => 'https://appcenter.intuit.com/connect/oauth2',
            //     'tokenEndPointUrl' => 'https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer',
            //     'client_id' => 'Q0I5cQBFtvPHiSXIdQnoItEPN5yZzWusyufLGdG9YdZlrxHxoZ',
            //     'client_secret' => 'LQWdGYWHyirTrcTORWn836XwY8qOLD9ciZkLCS3G',
            //     'oauth_scope' => 'com.intuit.quickbooks.accounting',
            //     'openID_scope' => 'pavement.layer@gmail.com',
            //     'oauth_redirect_uri' => 'https://pms.pavementlayers.com/OAuth_2/OAuth2PHPExample.php',
            //     'openID_redirect_uri' => 'https://pms.pavementlayers.com/OAuth_2/OAuthOpenIDExample.php',
            //     'mainPage' => 'https://pms.pavementlayers.com/account/qbsettings',
            //     'refreshTokenPage' => 'https://pms.pavementlayers.com/OAuth_2/RefreshToken.php',
            //     'baseUrl' => 'Production',
            //     'loginPath' => 'https://pms.pavementlayers.com/account/qbsettings/qblogin',
            // ];
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

        $this->config = $config;
    }


    /**
     * @param QuickbooksSettings $qbSettings
     * @return DataService
     */
    private function getDataService(QuickbooksSettings $qbSettings)
    {
//var_dump($qbSettings->getUpdatedAt());
        $check_updated = (($qbSettings->getUpdatedAt() ? $qbSettings->getUpdatedAt() : 0 ) + 3000);
        
        //var_dump($check_updated);//echo $this->config['baseUrl'];die;

        // var_dump(time());
        // die;
        if( $qbSettings->getUpdatedAt() == NULL || $check_updated < time() ){
           // echo 'test';die;
            $loginHelper = new OAuth2LoginHelper($this->config['client_id'], $this->config['client_secret']);
			$token = $loginHelper->refreshAccessTokenWithRefreshToken($qbSettings->getRefreshToken());
    
              $accesstoken = $token->getAccessToken();
    
              $refreshtoken = $token->getRefreshToken();

              $updated_at = time();
              $CI =& get_instance();
              $CI->load->database();
              $company_qb_realmid = $qbSettings->getRealmId();
              $CI->db->query("UPDATE quickbook_settings SET access_token='" . $accesstoken . "',refresh_token='" . $refreshtoken . "',updated_at='" . $updated_at . "' WHERE realm_id='" . $company_qb_realmid . "'");
            
            
            $dataService = DataService::Configure(array(
                'auth_mode' => 'oauth2',
                'ClientID' => $this->config['client_id'],
                'ClientSecret' => $this->config['client_secret'],
                'accessTokenKey' => $accesstoken,
                'refreshTokenKey' => $refreshtoken,
                'QBORealmID' => $qbSettings->getRealmId(),
                'baseUrl' => $this->config['baseUrl'],
            ));
            $this->dataService = $dataService;

        }else{

            $dataService = DataService::Configure(array(
                'auth_mode' => 'oauth2',
                'ClientID' => $this->config['client_id'],
                'ClientSecret' => $this->config['client_secret'],
                'accessTokenKey' => $qbSettings->getAccessToken(),
                'refreshTokenKey' => $qbSettings->getRefreshToken(),
                'QBORealmID' => $qbSettings->getRealmId(),
                'baseUrl' => $this->config['baseUrl'],
            ));
            $this->dataService = $dataService;
            // $this->OAuth2LoginHelper = $dataService->getOAuth2LoginHelper();
            // $this->accessToken = $this->OAuth2LoginHelper->refreshToken();
            
            // $dataService->updateOAuth2Token($this->accessToken);

        }
        return $this->dataService;
    }

    public function connect($companyId, $accessToken, $refreshToken, $realmId, $error)
    {
        $this->saveCredentials($companyId, $accessToken, $refreshToken, $realmId, $error);
    }

    public function disconnect($companyId)
    {
        $this->removeCredentials($companyId);
    }
    public function refresh_new_token($qbSettings)
    {
        return $this->getDataService($qbSettings);
    }

    /**
     * @param \models\Companies $company
     */
    public function migrateQbServices(\models\Companies $company)
    {
        // Get all the services for this company
        $services = $company->getServices();

       // echo "<pre> service";
      //  print_r($services);die;

        foreach ($services as $service) {
            /* @var $service \models\Services */

            $existing = $this->getCompanyQbService($company->getCompanyId(), $service->getServiceId());

            if (!$existing) {
                /* @var $service \models\Services */
                $cqs = new \models\CompanyQbService();
                $cqs->setCompanyId($company->getCompanyId());
                $cqs->setServiceId($service->getServiceId());
                $cqs->setTitle($service->getTitle($company->getCompanyId()) ?: ' Service ' . $service->getServiceId());
                $cqs->setQBSyncFlag(1);
                $this->em->persist($cqs);
            }
        }
        $this->em->flush();
    }

    /**
     * @param $companyId
     * @param $serviceId
     * @return bool | CompanyQbService
     */
    public function getCompanyQbService($companyId, $serviceId)
    {
        $qb = $this->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        $qb->select('cqs')
            ->from('\models\CompanyQbService', 'cqs')
            ->where('cqs.company_id = :companyId')
            ->andWhere('cqs.service_id = :serviceId')
            ->setParameter('companyId', $companyId)
            ->setParameter('serviceId', $serviceId);

        // Create the query and get the result
        $query = $qb->getQuery();
       // echo $this->db->last_query();die;
        $query->setMaxResults(1);

        try {
            $cqs = $query->getSingleResult();
            return $cqs;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $qbId
     * @return bool|mixed
     */
    public function getCompanyQbServiceFromQbId($companyId, $qbId)
    {
        $qb = $this->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        $qb->select('cqs')
            ->from('\models\CompanyQbService', 'cqs')
            ->where('cqs.company_id = :companyId')
            ->andWhere('cqs.QBID = :qbId')
            ->setParameter('companyId', $companyId)
            ->setParameter('qbId', $qbId);

        // Create the query and get the result
        $query = $qb->getQuery();
        $query->setMaxResults(1);

        try {
            $cqs = $query->getSingleResult();
            return $cqs;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @param $companyId
     * @param $accessToken
     * @param $refreshToken
     * @param $realmId
     * @param $error
     */
    public function saveCredentials($companyId, $accessToken, $refreshToken, $realmId, $error)
    {
        $company = $this->em->findCompany($companyId);

        $settings = $company->getQuickbooksSettings();

        if (!$settings) {
            $settings = new QuickbooksSettings();
        }

        $settings->setCompanyId($companyId);
        $settings->setAccessToken($accessToken);
        $settings->setRefreshToken($refreshToken);
        $settings->setRealmId($realmId);
        $settings->setErrorMessage($error);
        $settings->setUpdatedAt(time());
        $this->em->persist($settings);
        $this->em->flush();

        $company->setQbSettingId($settings->getId());
        $this->em->persist($company);
        $this->em->flush();
    }

    /**
     * @param $companyId
     */
    public function removeCredentials($companyId)
    {
        // Update the company record
        $company = $this->em->findCompany($companyId);
        $company->setQbSettingId(null);
        $this->em->persist($company);
        // Remove the credentials
        $settings = $company->getQuickbooksSettings();
        $this->em->remove($settings);
        $this->em->flush();
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getServiceToSync(Companies $company)
    {
        // echo "SELECT * 
        // FROM company_qb_services 
        // WHERE company_id= " . $company->getCompanyId() . "
        // AND QBSyncFlag IN (1,3)";die;
        $query = $this->db->query("SELECT * 
            FROM company_qb_services 
            WHERE company_id= " . $company->getCompanyId() . "
            AND QBSyncFlag IN (1,3)"
        );

        return $query->result_array();
    }

    public function syncServices(Companies $company)
    {

      
        echo '<h3>Syncing Services</h3>';

        $servicesToSync = $this->getServiceToSync($company);

        // echo "<pre> servicesToSync ";
       // print_r($servicesToSync);die;

        if ($servicesToSync) {
            //add time into log file for service
                $logTime = time();
                //Log the time for prevent multiple queue run
                $myfile = fopen("QuickbookSync.log", "w") or die("Unable to open file!");
                //Write the File
                fwrite($myfile, $logTime);
                //Save the data into file
                fclose($myfile);
            //add time into log file

            // Do the setup
            $qbSettings = $company->getQuickbooksSettings();
            $dataService = $this->getDataService($qbSettings);
            $resultingObj = null;

            // Do the sync
           // echo "<pre>servicesToSync: ";
          //  print_r($servicesToSync);die;
            foreach ($servicesToSync as $syncService) {

                if ($syncService['QBSyncFlag'] == 1) {

                    $syncService['title'] = preg_replace('/[^A-Za-z0-9\-]/', '', $syncService['title']);

                    echo '<p>Adding Service: ' . $syncService['title'] . '</p>';
                     $entities = $dataService->Query("SELECT * FROM Item where Name='" . $syncService['title'] . "'");

                

                    if ($entities) {
                        $syncService['title'] = $syncService['service_id'].'-'.$syncService['title'];
                    }
                    $Item = Item::create([
                        "Name" => $syncService['title'],
                        "Description" => $syncService['title'],
                        "Type" => "Service",
                        "IncomeAccountRef" => [
                            "value" => $qbSettings->getIncomeAccountId()
                        ],
                        "ExpenseAccountRef" => [
                            "value" => $qbSettings->getExpenseAccountId()
                        ]
                    ]);

 

                    $resultingObj = $dataService->Add($Item);
                    $error = $dataService->getLastError();
                } else {
                    if ($syncService['QBSyncFlag'] == 3) {

                        echo '<p>Updating Service: ' . $syncService['title'] . '</p>';

                        $entities = $dataService->Query("SELECT * FROM Item where Id='" . $syncService['QBID'] . "'");
                        $error = $dataService->getLastError();
                        if ($error != null) {
                            echo "The Status code is444: " . $error->getHttpStatusCode() . "\n";
                            echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
                            echo "The Response message is5: " . $error->getResponseBody() . "\n";
                        }
                        if(is_array($entities)){
                            $theItem = reset($entities);
                            $updateItem = Item::update($theItem, [
                                "Id" => $syncService['QBID'],
                                "Name" => $syncService['title'],
                                "Description" => $syncService['title'],
                            ]);
                            $resultingObj = $dataService->Update($updateItem);
                            $error = $dataService->getLastError();
                        }
                    }
                }

                if ($error) {
                    echo '<p>' . $error->getResponseBody() . '</p>';
                }

                $cqs = $this->getCompanyQbService($company->getCompanyId(), $syncService['service_id']);
                /* @var \models\CompanyQbService $cqs */
                if ($resultingObj) {
                    if ($cqs) {
                        $cqs->setQBID($resultingObj->Id);
                        //adding synched_at time in services 
                            if ($resultingObj->Id!="") {
                                // Get the current timestamp using Carbon library
                                $synchedTime = Carbon::now()->timestamp;
                                // Set the synched time for the services
                                $cqs->setSynchedAt($synchedTime);
                        }
                        // close synched_at time in services 
                        $cqs->setQBSyncFlag(null);
                        $cqs->setQBSyncToken(null);
                        $cqs->setQBError(null);
                        $this->em->persist($cqs);
                    }
                } else {
                    $err = "The Status code is555: " . $error->getHttpStatusCode() . "\n";
                    $err .= "The Helper message is: " . $error->getOAuthHelperError() . "\n";
                    $err .= "The Response message is: " . $error->getResponseBody() . "\n";

                    if ($cqs) {
                        $cqs->setQBError($err);
                        $this->em->persist($cqs);
                    }
                }
                $this->em->flush();
                unset($error);
            }
        }
        else {
            echo '<p>No Services to sync</p>';
        }
    }

    public function addContactToSync($contactId)
    {
        $this->db->query("UPDATE clients SET QBSyncFlag = 1 WHERE clientId = {$contactId}");
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getContactsToSync(Companies $company)
    {
        $query = $this->db->query("SELECT * 
            FROM clients 
            WHERE company = " . $company->getCompanyId() . "
            AND QBSyncFlag IN (1,3)"
        );
       // echo $this->db->last_query();die;

        return $query->result_array();
    }

    public function syncContacts(Companies $company)
    {
        echo '<h3>Syncing Contacts</h3>';

        $contactsToSync = $this->getContactsToSync($company);
        if ($contactsToSync) {
            //add time into log file for contact
                $logTime = time();
                //Log the time for prevent multiple queue run
                $myfile = fopen("QuickbookSync.log", "w") or die("Unable to open file!");
                //Write the File
                fwrite($myfile, $logTime);
                //Save the data into file
                fclose($myfile);
            //add time into log file
            // DO the setup
            $qbSettings = $company->getQuickbooksSettings();
            $dataService = $this->getDataService($qbSettings);
            $resultingCustomerObj = null;

            foreach ($contactsToSync as $client) {
                if ($client['businessPhone'] != '') {
                    $phone = $client['businessPhone'];
                } else {
                    $phone = $client['cellPhone'];
                }

                if ($client['QBID'] == null || $client['QBID'] == '') {

                    //$str_name = substr($client['firstName'],0, 1);
                    //$entities = $dataService->Query("SELECT * FROM Customer where FamilyName ='" . $client['lastName'] . "' AND PrimaryEmailAddr='" . $client['email'] . "' AND GivenName LIKE '" .$str_name . "%'");

                    // Check on email address first
                    $entities = $dataService->Query("SELECT * FROM Customer where PrimaryEmailAddr='" . $client['email'] . "' ");
                    if ($entities) {
                        
                        $client['QBSyncFlag'] = NULL;
                        $client['QBID'] = $entities[0]->Id;
                        // $client['exists'] = 1;
                        $client['firstName'] = $client['clientId'].'-'.$client['firstName'];
                        $resultingCustomerObj = new \stdClass();
                        $resultingCustomerObj->Id = $client['QBID'];
                    } else {
                        // Check for display Name
                        $displayName = $client['firstName'] . " " . $client['lastName'];
                        $entities = $dataService->Query("SELECT * FROM Customer where DisplayName ='" . $client['firstName'] . " " . $client['lastName'] . "'");

                        if ($entities) {
                            // If there is a matching display name, prepend with the client id
                            $client['firstName'] = $client['clientId'] . '-' . $client['firstName'];
                        } else {
                            // Check for first initial and last name
                            $str_name = substr($client['firstName'], 0, 1);
                            $entities = $dataService->Query("SELECT * FROM Customer where FamilyName ='" . $client['lastName'] . "' AND GivenName LIKE '" . $str_name . "%'");
                            if ($entities) {
                                $client['firstName'] = $client['clientId'] . '-' . $client['firstName'];
                            }
                        }
                    }
                }

                if ($client['QBSyncFlag'] == 1 || $client['QBSyncFlag'] == 3 && $client['QBID'] == null || $client['QBSyncFlag'] == 1 || $client['QBSyncFlag'] == 3 && $client['QBID'] == '') {

                    echo '<p>Adding Customer: ' . $client['firstName'] . ' ' . $client['lastName'] . '</p>';

                    $customerObj = Customer::create([
                        "BillAddr" => [
                            "Line1" => $client['billingAddress'],
                            "City" => $client['billingCity'],
                            "Country" => $client['country'],
                            "CountrySubDivisionCode" => $client['billingState'],
                            "PostalCode" => $client['billingZip']
                        ],
                        "Notes" => "",
                        "Title" => "",
                        "GivenName" => $client['firstName'],
                        "MiddleName" => "",
                        "FamilyName" => $client['lastName'],
                        "Suffix" => "",
                        "FullyQualifiedName" => $client['firstName'] . " " . $client['lastName'],
                        "CompanyName" => $client['companyName'],
                        "DisplayName" => $client['firstName'] . " " . $client['lastName'] . ' - PL' . $client['clientId'],
                        "PrimaryPhone" => [
                            "FreeFormNumber" => $phone
                        ],
                        "PrimaryEmailAddr" => [
                            "Address" => $client['email']
                        ]
                    ]);
                    $resultingCustomerObj = $dataService->Add($customerObj);
                    $error = $dataService->getLastError();
                }
                if ($client['QBSyncFlag'] == 3 && $client['QBID'] != null || $client['QBSyncFlag'] == 3 && $client['QBID'] != '') {

                    echo '<p>Updating Customer: ' . $client['firstName'] . ' ' . $client['lastName'] . '</p>';

                    $entities = $dataService->Query("SELECT * FROM Customer where Id='" . $client['QBID'] . "'");
                    $error = $dataService->getLastError();
                    if ($error != null) {
                        echo '<p>';
                        echo "The Status code is666: " . $error->getHttpStatusCode() . "\n";
                        echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
                        echo "The Response message is: " . $error->getResponseBody() . "\n";
                        echo '</p>';
                    }
                    if(is_array($entities)){
                        $theCustomer = reset($entities);

                        if (!isset($client['exists'])) {
                            $customerObj = Customer::update($theCustomer, [
                                "Id" => $client['QBID'],
                                "BillAddr" => [
                                    "Line1" => $client['billingAddress'],
                                    "City" => $client['billingCity'],
                                    "Country" => $client['country'],
                                    "CountrySubDivisionCode" => $client['billingState'],
                                    "PostalCode" => $client['billingZip']
                                ],
                                "Notes" => "",
                                "Title" => "",
                                "GivenName" => $client['firstName'],
                                "MiddleName" => "",
                                "FamilyName" => $client['lastName'],
                                "Suffix" => "",
                                "FullyQualifiedName" => $client['firstName'] . " " . $client['lastName'],
                                "CompanyName" => $client['companyName'],
                                "DisplayName" => $client['firstName'] . " " . $client['lastName'],
                                "PrimaryPhone" => [
                                    "FreeFormNumber" => $phone
                                ],
                                "PrimaryEmailAddr" => [
                                    "Address" => $client['email']
                                ]
                            ]);
                            $resultingCustomerObj = $dataService->Update($customerObj);
                            $error = $dataService->getLastError();
                        } else {
                            $resultingCustomerObj = new \stdClass();
                            $resultingCustomerObj->Id = $client['QBID'];
                        }
                    }
                }
                
                $contact = $this->em->findClient($client['clientId']);

                if ($resultingCustomerObj) {

                    if ($contact) {
                        $contact->setQBID($resultingCustomerObj->Id);
                    //adding synched_at time in contact 
                            if ($resultingCustomerObj->Id!="") {
                                // Get the current timestamp using Carbon library
                                $synchedTime = Carbon::now()->timestamp;
                                // Set the synched time for the contact
                                $contact->setSynchedAt($synchedTime);
                              }
                    // close synched_at time in contact 
                        $contact->setQBSyncFlag(null);
                        $contact->setQBSyncToken(null);
                        $contact->setQBError(null);
                        $this->em->persist($contact);
                    

                        $this->getLogRepository()->add([
                            'action' => 'qb_sync_contact',
                            'details' => 'Contact ' . $contact->getFullName() . ' synced to QuickBooks',
                            'client' => $contact->getClientId(),
                            'company' => $contact->getCompany()->getCompanyId()
                        ]);
                    }

                } else {
                    $err = "The Status code is: " . $error->getHttpStatusCode() . "\n";
                    $err .= "The Helper message is: " . $error->getOAuthHelperError() . "\n";
                    $err .= "The Response message is: " . $error->getResponseBody() . "\n";

                    echo '<p>';
                    echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
                    echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
                    echo "The Response message is: " . $error->getResponseBody() . "\n";
                    echo '</p>';


                    if ($contact) {
                        $contact->setQBError($err);
                        $this->em->persist($contact);
                    }
                }

                

                $this->em->flush();
                unset($error);
            }
        }
        else {
            echo '<p>No Contacts to sync</p>';
        }
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getProposalsToSync(Companies $company)
    {
        // echo "SELECT p.* 
        // FROM proposals p
        // LEFT JOIN clients c ON p.client = c.clientId
        // WHERE c.company = " . $company->getCompanyId() . "
        // AND p.QBSyncFlag IN (1,3)";die;
        $query = $this->db->query("SELECT p.* 
            FROM proposals p
            LEFT JOIN clients c ON p.client = c.clientId
            WHERE c.company = " . $company->getCompanyId() . "
            AND p.QBSyncFlag IN (1,3)"
        );

       // echo $this->db->last_query();die;

        return $query->result_array();
    }

    public function getProposalServicesToSync($proposalId)
    {
        $query = $this->db->query("SELECT * 
            FROM proposal_services ps
            WHERE ps.proposal = {$proposalId}
            AND ps.optional != 1
            ORDER BY ps.ord ASC"
        );

        return $query->result_array();
    }


    

    public function syncProposals(Companies $company)
    {
        echo '<h3>Syncing Proposals</h3>';
        // Get the proposals to sync
        $proposalsToSync = $this->getProposalsToSync($company);

        // Only proceed if we have them
        if ($proposalsToSync) {

            //add time into log file for proposal
                $logTime = time();
                //Log the time for prevent multiple queue run
                $myfile = fopen("QuickbookSync.log", "w") or die("Unable to open file!");
                //Write the File
                fwrite($myfile, $logTime);
                //Save the data into file
                fclose($myfile);
            //add time into log file

            $dataService = $this->getDataService($company->getQuickbooksSettings());
            foreach ($proposalsToSync as $syncProposal) {
                $invoiceItems = array();

                $proposal = $this->em->findProposal($syncProposal['proposalId']);

                // Get the proposal services for this proposal
                $syncProposalServices = $this->getProposalServicesToSync($syncProposal['proposalId']);

                foreach ($syncProposalServices as $syncProposalService) {

                    // Some useful vars
                    $initialServiceId = $syncProposalService['initial_service'];
                    // Remove the dollar sign. This works for both positive and negative numbers
                    $servicePrice = str_replace('$', '', $syncProposalService['price']);
                    $serviceDescription = $syncProposalService['serviceName'];

                    // Get the CQS
                    $cqs = $this->getCompanyQbService($company->getCompanyId(), $initialServiceId);

                
                    /* @var $cqs \models\CompanyQbService */

               //  echo "<pre>";print_r($cqs);die;

              

                     if ($cqs) {

                        if($cqs->getQBID()){
                            $invoiceItems[] = [
                                "QBID" => !empty($cqs->getQBID())?$cqs->getQBID():"",
                                "title" => $cqs->getTitle(),
                                "item_price" => $servicePrice,
                                'description' => $serviceDescription
                            ];

                        }else{
                            
                            $this->db->query("UPDATE company_qb_services SET QBSyncFlag = 1 WHERE service_id = {$initialServiceId} AND company_id= " . $company->getCompanyId() );
                          //  echo "Skipping due to empty QBID<br>";

                            continue;
                        }
                    
                    }else{

                        $this->db->query("UPDATE company_qb_services SET QBSyncFlag = 1 WHERE service_id = {$initialServiceId} AND company_id= " . $company->getCompanyId() );
                       // echo "Skipping due to empty CQS<br>";

                        continue;
                    }
                }

                // Add all invoice items into an array
                
                $tt = [];
                foreach ($invoiceItems as $invoiceItem) {
                    $tt[] = [
                        "Amount" => str_replace(',', '', $invoiceItem['item_price']),
                        "DetailType" => "SalesItemLineDetail",
                        "SalesItemLineDetail" => [
                            "ItemRef" => [
                                "value" => $invoiceItem['QBID'],
                                "name" => $invoiceItem['title']
                            ],
                            "Qty" => 1
                        ],
                        "Description" => $invoiceItem['description']
                    ];
                }
                // Empty the invoice items for next loop

             //   echo "invoiceItems <pre>";print_r($invoiceItems); 
              //   echo "tt <pre>";print_r($tt); 

                if ($syncProposal['QBSyncFlag'] == '1') {

                   // echo 'Adding proposal77 ' . $proposal->getProposalId() . ': ' . $proposal->getProjectName();

                   //echo "<pre>invoiceItems ";print_r($invoiceItems);

              //  echo "<pre>";print_r($tt);die;
               
                    $theResourceObj = Invoice::create([
                        "Line" => $tt,
                        "CustomerRef" => [
                            "value" => $proposal->getClient()->getQBID()
                        ],
                        "CustomerMemo" => [
                            "value" => 'See '.SITE_NAME.' Proposal: ' . $proposal->getProposalViewUrl()
                        ],
                        "ShipAddr"=>[
                            "City"=>$proposal->getProjectCity(),
                            "Line1"=>$proposal->getProjectAddress(),
                            "PostalCode"=>$proposal->getProjectZip(),
                            "Lat"=>$proposal->getLat(),
                            "Long"=>$proposal->getLng()
                        ],
                    ]);

                    try {

                        $resultingObj = $dataService->Add($theResourceObj);

 
                    } catch (\Exception $e) {

                         // Handle exceptions
                        echo "Caught exception: " . $e->getMessage() . "\n";
                    }
                    
                }

                $skip = false;

  
                if ($syncProposal['QBSyncFlag'] == '3') {

                   // echo '<p>Updating proposal ' . $proposal->getProposalId() . ': ' . $proposal->getProjectName() . "</p>";

                    $entities = $dataService->Query("SELECT * FROM Invoice where Id='" . $syncProposal['QBID'] . "'");

                    $error = $dataService->getLastError();
                    if ($error != null) {
                        echo '<p> Querying Invoice: ';
                        echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
                        echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
                        echo "The Response message is: " . $error->getResponseBody() . "\n";
                        echo '</p>';
                    }

  
                    $skip = false;
                    if (is_array($entities)) {
                        $theInvoice = reset($entities);
                        $theResourceObj = Invoice::update($theInvoice, [
                            "Id" => $syncProposal['QBID'],
                            "Line" => $tt,
                            "CustomerRef" => [
                                "value" => $proposal->getClient()->getQBID()
                            ],
                            "ShipAddr"=>[
                                "City"=>$proposal->getProjectCity(),
                                "Line1"=>$proposal->getProjectAddress(),
                                "PostalCode"=>$proposal->getProjectZip(),
                                "Lat"=>$proposal->getLat(),
                                "Long"=>$proposal->getLng()
                            ],
                        ]);
                        $resultingObj = $dataService->Update($theResourceObj);
                    } else {
                        $skip = true;
                    }
                }

                 if (isset($resultingObj)) {
                    echo '<p>Synced. QBID: ' . $resultingObj->Id . '</p>';
                    $proposal->setQBID($resultingObj->Id);
                    //adding synched_at time in proposal 
                    if ($resultingObj->Id!="") {
                            // Get the current timestamp using Carbon library
                            $synchedTime = Carbon::now()->timestamp;
                            // Set the synched time for the proposal
                            $proposal->setSynchedAt($synchedTime);
                            echo "synchedTime ". $synchedTime;
                    }
                    // close synched_at time in proposal 
                    

                    $proposal->setQBSyncFlag(null);
                    $proposal->setQBSyncToken(null);
                    $proposal->setQBError(null);
                    $this->em->persist($proposal);
                    $this->em->flush();

                    $this->getLogRepository()->add([
                        'action' => 'qb_sync_proposal',
                        'details' => 'Proposal ' . $proposal->getProjectName() . ' synced to QuickBooks',
                        'client' => $proposal->getClient()->getClientId(),
                        'proposal' => $proposal->getProposalId(),
                        'company' => $proposal->getClient()->getCompany()->getCompanyId()
                    ]);

                } else if (!$skip) {
                    $error = $dataService->getLastError();
                   // echo "<pre>error ";print_r($error);die;
                    if ($error != null) {
                        $err = "The Status code is: " . $error->getHttpStatusCode() . "\n";
                        $err .= "The Helper message is: " . $error->getOAuthHelperError() . "\n";
                        $err .= "The Response message is: " . $error->getResponseBody() . "\n";
    
                        echo '<p>';
                        echo "The Status code is: " . $error->getHttpStatusCode() . "\n";
                        echo "The Helper message is: " . $error->getOAuthHelperError() . "\n";
                        echo "The Response message is11: " . $error->getResponseBody() . "\n";
                        echo '</p>';
    
                        $proposal->setQBError($err);
                        $this->em->persist($proposal);
                        $this->em->flush();
                    }
                    
                }

                // Clear var for next loop
                unset($invoiceItems);
                unset($error);
                unset($resultingObj);
            }
        }
        else {
            echo '<p>No Proposals to sync</p>';
        }
    }

    public function syncPaymentStatus(Companies $company)
    {
        $dataService = $this->getDataService($company->getQuickbooksSettings());

        $monthStartDate = date('Y-m-01');
        $entities = $dataService->Query("SELECT * FROM Invoice WHERE MetaData.LastUpdatedTime >= '" . $monthStartDate . "' AND MetaData.LastUpdatedTime <= CURRENT_DATE");
        if ($entities) {
            foreach ($entities as $entity) {
                if ($entity->TotalAmt != $entity->Balance) {
                    $payed_amount = ($entity->TotalAmt) - ($entity->Balance);
                    if ($entity->Balance == 0) {
                        $invoice_status = 'Paid';
                    } else {
                        if ($entity->Balance == $entity->TotalAmt) {
                            $invoice_status = 'Unpaid';
                        } else {
                            $invoice_status = 'PartialPaid';
                        }
                    }

                    echo '<p>Updating payment status of QB transaction ID: ' . $entity->Id . '</p>';
                    echo '<p>Status: ' . $invoice_status . ' | Amount: ' . $payed_amount . '</p>';
                    $this->db->query("UPDATE proposals set invoice_status='" . $invoice_status . "',invoice_amount='" . $payed_amount . "' where QBID='" . $entity->Id . "'");
                }
            }
        }
    }

    public function getIncomeAccounts(Companies $company)
    {
        $dataService = $this->getDataService($company->getQuickbooksSettings());
        $accounts = $dataService->Query("SELECT Id, Name FROM Account WHERE AccountType =  'Income'");
        $error = $dataService->getLastError();
        //print_r($accounts);die;
        return $accounts;
    }

    public function getExpenseAccounts(Companies $company)
    {
        $dataService = $this->getDataService($company->getQuickbooksSettings());
        $accounts = $dataService->Query("SELECT Id, Name FROM Account WHERE AccountType =  'Cost of Goods Sold'");
        return $accounts;
    }

    public function checkQbConnection(Companies $company)
    {
                try {

            $dataService = $this->getDataService($company->getQuickbooksSettings());

            $accounts = $dataService->Query("SELECT Id, Name FROM Account WHERE AccountType =  'Income'");
            $error = $dataService->getLastError();
            if( $error !=NULL){
                return false;
            }else{
                return true;
            }
        } catch (\Exception $e) {
            return false;
        }

        
    }

}