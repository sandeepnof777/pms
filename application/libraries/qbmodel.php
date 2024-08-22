<?php

class QBModel {

    const OAUTH_URL = '/account/quickbooks/oauth';
    const SUCCESS_URL = '/account/quickbooks';
    const LIB_FILE = '/var/www/vhosts/pms.pavementlayers.com/application/libraries/QuickBooks/QuickBooks.php';
    const MENU_URL = '/account/quickbooks/menu';

    public static function getCustomerList(\models\Accounts $account){

        $CI =& get_instance();

        $the_tenant = $account->getCompany()->getCompanyId();
        require 'QuickBooks/docs/example_app_ipp_v3/config.php';

        // Set up the IPP instance
        $IPP = new QuickBooks_IPP(QB_DSN);

        // Get our OAuth credentials from the database
        $creds = $IntuitAnywhere->load($the_username, $the_tenant);

        // Tell the framework to load some data from the OAuth store
        $IPP->authMode(
            QuickBooks_IPP::AUTHMODE_OAUTH,
            $the_username,
            $creds);


        // This is our current realm
        $realm = $creds['qb_realm'];

        // Load the OAuth information from the database
        if ($Context = $IPP->context())
        {
            // Set the IPP version to v3
            $IPP->version(QuickBooks_IPP_IDS::VERSION_3);

            $CustomerService = new QuickBooks_IPP_Service_Customer();

            $customers = $CustomerService->query($Context, $realm, "SELECT * FROM Customer");

            $out = array();

            if($customers){
                foreach ($customers as $Customer)
                {
                    $out[] = $Customer;
                }
            }
            else {
                return $out;
            }

            return $out;

        }
        else
        {
            die('Unable to load a context...?');
        }

        return count($customers);

    }

    public static function addProposalCustomer(\models\Accounts $account, \models\Proposals $proposal){

        $CI =& get_instance();

        $the_tenant = $account->getCompany()->getCompanyId();
        require 'QuickBooks/docs/example_app_ipp_v3/config.php';

        // Set up the IPP instance
        $IPP = new QuickBooks_IPP(QB_DSN);

        // Get our OAuth credentials from the database
        $creds = $IntuitAnywhere->load($the_username, $the_tenant);

        // Tell the framework to load some data from the OAuth store
        $IPP->authMode(
            QuickBooks_IPP::AUTHMODE_OAUTH,
            $the_username,
            $creds);

        // This is our current realm
        $realm = $creds['qb_realm'];

        // Load the OAuth information from the database
        if ($Context = $IPP->context())
        {

            $client = $proposal->getClient();

            // Set the IPP version to v3
            $IPP->version(QuickBooks_IPP_IDS::VERSION_3);

            $CustomerService = new QuickBooks_IPP_Service_Customer();

            $Customer = new QuickBooks_IPP_Object_Customer();
            $Customer->setTitle(substr($client->getTitle(), 0, 15));
            $Customer->setGivenName($client->getFirstName());
            $Customer->setMiddleName('');
            $Customer->setFamilyName($client->getLastName());
            $Customer->setCompanyName($client->getCompanyName());
            $Customer->setDisplayName($client->getFullName() . ' - ' . $client->getCompanyName());
            $Customer->setAccountNum($client->getClientId());
            $Customer->setWebAddr($client->getWebsite());

            // Phone #
            $PrimaryPhone = new QuickBooks_IPP_Object_PrimaryPhone();
            $PrimaryPhone->setFreeFormNumber($client->getBusinessPhone());
            $Customer->setPrimaryPhone($PrimaryPhone);

            // Bill address
            $BillAddr = new QuickBooks_IPP_Object_BillAddr();
            $BillAddr->setLine1($client->getAddress());
            $BillAddr->setCity($client->getCity());
            $BillAddr->setCountrySubDivisionCode($client->getState());
            $BillAddr->setPostalCode($client->getZip());
            $Customer->setBillAddr($BillAddr);

            if ($resp = $CustomerService->add($Context, $realm, $Customer))
            {
                $id = str_replace(array('{', '}', '-'), array('','', ''), $resp);
                $client->setQuickbooksId($id);
                $CI->em->persist($client);
                $CI->em->flush();

                return $id;
            }
            else
            {
                return false;
            }

        }
        else
        {
            die('Unable to load a context...?');
        }

    }

    public static function addProposalInvoice(\models\Accounts $account,\models\Proposals $proposal){

        $CI =& get_instance();

        $the_tenant = $account->getCompany()->getCompanyId();
        require 'QuickBooks/docs/example_app_ipp_v3/config.php';

        // Set up the IPP instance
        $IPP = new QuickBooks_IPP(QB_DSN);

        // Get our OAuth credentials from the database
        $creds = $IntuitAnywhere->load($the_username, $the_tenant);

        // Tell the framework to load some data from the OAuth store
        $IPP->authMode(
            QuickBooks_IPP::AUTHMODE_OAUTH,
            $the_username,
            $creds);

        // This is our current realm
        $realm = $creds['qb_realm'];

        // Load the OAuth information from the database
        if ($Context = $IPP->context())
        {
            // Set the IPP version to v3
            $IPP->version(QuickBooks_IPP_IDS::VERSION_3);

            $InvoiceService = new QuickBooks_IPP_Service_Invoice();
            $Invoice = new QuickBooks_IPP_Object_Invoice();

            $Invoice->setDocNumber($proposal->getProposalId());
            $Invoice->setTxnDate(date('Y-m-d'));


            $services = $CI->em->createQuery('select s from models\Proposal_services s where s.proposal=' . $proposal->getProposalId() . ' order by s.ord')->getResult();

            foreach($services as $service){

                $servicePrice = str_replace(array('$', ','), array('', ''), $service->getPrice());
                //$serviceQty = $service->getAmountQty() ? $service->getAmountQty() : 1;
                $serviceQty = 1;

                $Line = new QuickBooks_IPP_Object_Line();
                $Line->setDetailType('SalesItemLineDetail');
                $Line->setAmount($servicePrice * $serviceQty);
                $Line->setDescription($service->getServiceName());

                $SalesItemLineDetail = new QuickBooks_IPP_Object_SalesItemLineDetail();
                //$SalesItemLineDetail->setClassRef('2');
                $SalesItemLineDetail->setUnitPrice($servicePrice);
                $SalesItemLineDetail->setQty($serviceQty);

                $Line->addSalesItemLineDetail($SalesItemLineDetail);

                $Invoice->addLine($Line);

            }

            $Invoice->setCustomerRef($proposal->getClient()->getQuickbooksId());
            $Invoice->setCustomerMemo('Ref: ' . site_name() . ' proposal #' . $proposal->getProposalId());

            // Add ship to addr
            $shipAddr = new QuickBooks_IPP_Object_ShipAddr();
            $shipAddr->setLine1($proposal->getProjectName());
            $shipAddr->setLine2($proposal->getProjectAddress());
            $shipAddr->setCity($proposal->getProjectCity());
            $shipAddr->setCountrySubDivisionCode($proposal->getProjectState());
            $shipAddr->setPostalCode($proposal->getProjectZip());
            $Invoice->setShipAddr($shipAddr);

            $resp = $InvoiceService->add($Context, $realm, $Invoice);

            if ($resp)
            {
                // Update the proposal status
                $proposal->setStatus('Invoiced via QuickBooks');
                $CI->em->persist($proposal);
                $CI->em->flush();

                return str_replace(array('{', '}', '-'), array('','', ''), $resp);
            }
            else
            {
                return false;
            }

        }
        else
        {
            return false;
        }

    }

    public static function saveClient(\models\Accounts $account, \models\Clients $client, QuickBooks_IPP_Object_Customer $Customer){

        $CI =& get_instance();

        $client->setAccount($account);
        $client->setFirstName($Customer->getGivenName());
        $client->setLastName($Customer->getFamilyName());
        $client->setCompanyName($Customer->getCompanyName());
        $client->setCompany($account->getCompany());
        // Email
        $customerEmail = $Customer->getPrimaryEmailAddr();
        /* @var $customerEmail QuickBooks_IPP_Object_PrimaryEmailAddr */
        if($customerEmail){
            $client->setEmail($customerEmail->getAddress());
        }

        $customerAddress = $Customer->getBillAddr();
        /* @var $customerAddress QuickBooks_IPP_Object_Address */
        if($customerAddress){
            $client->setAddress($customerAddress->getLine1());
            $client->setCity($customerAddress->getCity());
            $client->setState($customerAddress->getCountrySubDivisionCode());
            $client->setZip($customerAddress->getPostalCode());
        }


        // Primary Phone
        $primaryPhone = $Customer->getPrimaryPhone();
        if($primaryPhone){
            $client->setBusinessPhone($primaryPhone->getFreeFormNumber());
        }

        // Cell Phone
        $cellPhone = $Customer->getMobile();
        if($cellPhone){
            $client->setCellPhone($cellPhone->getFreeFormNumber());
        }

        // Fax
        $fax = $Customer->getFax();
        if($fax){
            $client->setFax($fax->getFreeFormNumber());
        }

        // Website
        $website = $Customer->getWebAddr();
        if($website){
            $client->setWebsite($website->getURI());
        }

        $customerId = str_replace(array('{', '}', '-'), array('','', ''), $Customer->getId());
        $client->setQuickbooksId($customerId);

        $CI->em->persist($client);
        $CI->em->flush();
    }

    public static function addCustomer(\models\Accounts $account, \models\Clients $client){

        $CI =& get_instance();

        $the_tenant = $account->getCompany()->getCompanyId();
        require 'QuickBooks/docs/example_app_ipp_v3/config.php';

        // Set up the IPP instance
        $IPP = new QuickBooks_IPP($dsn);

        // Get our OAuth credentials from the database
        $creds = $IntuitAnywhere->load($the_username, $the_tenant);

        // Tell the framework to load some data from the OAuth store
        $IPP->authMode(
            QuickBooks_IPP::AUTHMODE_OAUTH,
            $the_username,
            $creds);


        // This is our current realm
        $realm = $creds['qb_realm'];

        // Load the OAuth information from the database
        if ($Context = $IPP->context())
        {
            // Set the IPP version to v3
            $IPP->version(QuickBooks_IPP_IDS::VERSION_3);

            $CustomerService = new QuickBooks_IPP_Service_Customer();

            $Customer = new QuickBooks_IPP_Object_Customer();
            $Customer->setGivenName($client->getFirstName());
            $Customer->setFamilyName($client->getLastName());
            $Customer->setDisplayName($client->getFullName() . ' - ' . $client->getCompanyName());
            $Customer->setCompanyName($client->getCompanyName());

            // Phone #
            $PrimaryPhone = new QuickBooks_IPP_Object_PrimaryPhone();
            $PrimaryPhone->setFreeFormNumber($client->getBusinessPhone());
            $Customer->setPrimaryPhone($PrimaryPhone);

            // Cell Phone
            if($client->getCellPhone()){
                $CellPhone = new QuickBooks_IPP_Object_Mobile();
                $CellPhone->setFreeFormNumber($client->getCellPhone());
                $Customer->setMobile($CellPhone);
            }

            // Bill address
            $BillAddr = new QuickBooks_IPP_Object_BillAddr();
            $BillAddr->setLine1($client->getAddress());
            $BillAddr->setLine2('');
            $BillAddr->setCity($client->getCity());
            $BillAddr->setCountrySubDivisionCode($client->getState());
            $BillAddr->setPostalCode($client->getZip());
            $Customer->setBillAddr($BillAddr);

            // Email address
            $EmailAddr = new QuickBooks_IPP_Object_PrimaryEmailAddr();
            $EmailAddr->setAddress($client->getEmail());
            $Customer->setPrimaryEmailAddr($EmailAddr);

            // Website
            if($client->getWebsite()){

                $http = strstr($client->getWebsite(), 'http://');

                if(!$http){
                    $website = 'http://' . $client->getWebsite();
                }
                else {
                    $website = $client->getWebsite();
                }

                //Website
                $WebAddr = new QuickBooks_IPP_Object_WebAddr();
                $WebAddr->setURI($website);
                $Customer->setWebAddr($WebAddr);
            }

            if ($resp = $CustomerService->add($Context, $realm, $Customer)){
                $id = str_replace(array('{', '}', '-'), array('','', ''), $resp);

                $client->setQuickbooksId($id);
                $CI->em->persist($client);
                $CI->em->flush();
                $CI->em->clear();

                return $id;
            }
            else {
                return false;
            }
        }
        else {
            return false;
        }

    }

    /**
     * @param \models\Accounts $account
     * @return bool
     */
    public static function isConnected(\models\Accounts $account){

        $the_tenant = $account->getCompany()->getCompanyId();
        require 'QuickBooks/docs/example_app_ipp_v3/config.php';
        /* @var $quickbooks_is_connected bool */

        if($quickbooks_is_connected){
            return true;
        }
        else {
            return false;
        }
    }

    /**
     * @param \models\Accounts $account
     */
    public static function oauthConnect(\models\Accounts $account){

        $the_tenant = $account->getCompany()->getCompanyId();

        
        require 'QuickBooks/docs/example_app_ipp_v3/config.php';

        // Try to handle the OAuth request
        if ($IntuitAnywhere->handle($the_username, $the_tenant))
        {
            ; // The user has been connected, and will be redirected to $that_url automatically.
        }
        else
        {
            // If this happens, something went wrong with the OAuth handshake
            die('Oh no, something bad happened: ' . $IntuitAnywhere->errorNumber() . ': ' . $IntuitAnywhere->errorMessage());
        }
    }

    public static function disconnect(\models\Accounts $account){

        $the_tenant = $account->getCompany()->getCompanyId();
        require 'QuickBooks/docs/example_app_ipp_v3/config.php';

        $IntuitAnywhere->disconnect($the_username, $the_tenant);

    }

    public static function menu(\models\Accounts $account){

        $the_tenant = $account->getCompany()->getCompanyId();
        require 'QuickBooks/docs/example_app_ipp_v3/config.php';

        echo $IntuitAnywhere->widgetMenu($the_username, $the_tenant);
    }

    /**
     * @param \models\Accounts $account
     * @return bool
     */
    public static function hasPermission(\models\Accounts $account){

        if($account->getFullAccess() == 'yes' && QBModel::isConnected($account)){
            return true;
        }
        else {
            return false;
        }
    }

    public static function syncClientFromQb(\models\Accounts $account, $clientId, $qbCustomerId){
        $CI =& get_instance();



        if($clientId){
            $client = $CI->em->find('models\Clients', $clientId);
            if(!$client){
                $client = new \models\Clients();
            }
        }
        else {
            $client = new \models\Clients();
        }



        $the_tenant = $account->getCompany()->getCompanyId();
        require 'QuickBooks/docs/example_app_ipp_v3/config.php';

        // Set up the IPP instance
        $IPP = new QuickBooks_IPP(QB_DSN);

        // Get our OAuth credentials from the database
        $creds = $IntuitAnywhere->load($the_username, $the_tenant);

        // Tell the framework to load some data from the OAuth store
        $IPP->authMode(
            QuickBooks_IPP::AUTHMODE_OAUTH,
            $the_username,
            $creds);

        // This is our current realm
        $realm = $creds['qb_realm'];

        // Load the OAuth information from the database
        if ($Context = $IPP->context())
        {
            // Set the IPP version to v3
            $IPP->version(QuickBooks_IPP_IDS::VERSION_3);

            $CustomerService = new QuickBooks_IPP_Service_Customer();

            $customers = $CustomerService->query($Context, $realm, "SELECT * FROM Customer WHERE Id = '" . $qbCustomerId . "'");

            if($customers[0] && $client){
                $customer =  $customers[0];
                QBModel::saveClient($account, $client, $customer);
            }
        }
    }

    public static function nameExists(\models\Accounts $account, \models\Clients $client){
        $CI =& get_instance();

        $the_tenant = $account->getCompany()->getCompanyId();
        require 'QuickBooks/docs/example_app_ipp_v3/config.php';

        // Set up the IPP instance
        $IPP = new QuickBooks_IPP(QB_DSN);

        // Get our OAuth credentials from the database
        $creds = $IntuitAnywhere->load($the_username, $the_tenant);

        // Tell the framework to load some data from the OAuth store
        $IPP->authMode(
            QuickBooks_IPP::AUTHMODE_OAUTH,
            $the_username,
            $creds);

        // This is our current realm
        $realm = $creds['qb_realm'];

        // Load the OAuth information from the database
        if ($Context = $IPP->context())
        {
            // Set the IPP version to v3
            $IPP->version(QuickBooks_IPP_IDS::VERSION_3);

            $CustomerService = new QuickBooks_IPP_Service_Customer();

            $query = "SELECT * FROM Customer WHERE GivenName LIKE '" . $client->getFirstName() . "' AND FamilyName LIKE '" . $client->getLastName() . "'";

            $customers = $CustomerService->query($Context, $realm, $query);

            if($customers){
                return true;
            }
            else {
                return false;
            }
        }

    }

    /**
     * @param \models\Accounts $account
     * @param \models\Clients $client
     * @param $qbClientId
     * @return bool|mixed
     */
    public static function updateQbFromClient(\models\Accounts $account, \models\Clients $client, $qbClientId){

        $CI =& get_instance();

        $the_tenant = $account->getCompany()->getCompanyId();
        require 'QuickBooks/docs/example_app_ipp_v3/config.php';

        // Set up the IPP instance
        $IPP = new QuickBooks_IPP(QB_DSN);

        // Get our OAuth credentials from the database
        $creds = $IntuitAnywhere->load($the_username, $the_tenant);

        // Tell the framework to load some data from the OAuth store
        $IPP->authMode(
            QuickBooks_IPP::AUTHMODE_OAUTH,
            $the_username,
            $creds);


        // This is our current realm
        $realm = $creds['qb_realm'];

        // Load the OAuth information from the database
        if ($Context = $IPP->context())
        {
            // Set the IPP version to v3
            $IPP->version(QuickBooks_IPP_IDS::VERSION_3);

            $CustomerService = new QuickBooks_IPP_Service_Customer();

            $Customer = new QuickBooks_IPP_Object_Customer();
            $Customer->setGivenName($client->getFirstName());
            $Customer->setFamilyName($client->getLastName());
            $Customer->setDisplayName($client->getFullName());
            $Customer->setCompanyName($client->getCompanyName());

            // Phone #
            $PrimaryPhone = new QuickBooks_IPP_Object_PrimaryPhone();
            $PrimaryPhone->setFreeFormNumber($client->getBusinessPhone());
            $Customer->setPrimaryPhone($PrimaryPhone);

            // Bill address
            $BillAddr = new QuickBooks_IPP_Object_BillAddr();
            $BillAddr->setLine1($client->getAddress());
            $BillAddr->setLine2('');
            $BillAddr->setCity($client->getCity());
            $BillAddr->setCountrySubDivisionCode($client->getState());
            $BillAddr->setPostalCode($client->getZip());
            $Customer->setBillAddr($BillAddr);

            $idType = QuickBooks_IPP_IDS::usableIDType('{-' . $qbClientId . '}');

            if ($resp = $CustomerService->update($Context, $realm, $idType, $Customer))
            {
                $id = str_replace(array('{', '}', '-'), array('','', ''), $resp);
                $client->setQuickbooksId($id);
                $CI->em->persist($client);
                $CI->em->flush();

                return $id;
            }
            else
            {
                print($CustomerService->lastError($Context));
                echo '<pre>';
                print($CustomerService->lastRequest());
                echo '</pre>';
                return false;
            }
        }
        else
        {
            return false;
        }
    }

    /**
     * @param QuickBooks_IPP_Object_Customer $customer
     * @return string
     */
    public static function customerSearchString(QuickBooks_IPP_Object_Customer $customer) {
        return $customer->getGivenName() . ' ' . $customer->getFamilyName() . ' ' . $customer->getCompanyName();
    }

    public static function isFullySynced(){
        return false;
    }

    public static function findClientMatches(\models\Clients $client, $customerList, $exclude=false){

        $out = array();

        if(count($customerList)){
            foreach($customerList as $k => $v){

                if($exclude && in_array($k, $exclude)){
                    continue;
                }

                $clientString = $client->qbSearchString();
                $qbString = $v['searchString'];

                similar_text($clientString, $qbString, $pct);

                if($pct > 50){
                    $out[] = $v['customer'];
                }
            }
        }

        return $out;
    }

    /*
    public static function clientHasMatches(\models\Accounts $account, \models\Clients $client){

        $customerList = QBModel::getCustomerList($account);

        if(count($customerList)){
            foreach($customerList as $k => $v){

                if($exclude && in_array($k, $exclude)){
                    continue;
                }

                $clientString = $client->qbSearchString();
                $qbString = $v['searchString'];

                similar_text($clientString, $qbString, $pct);

                if($pct > 50){
                    $out[] = $v['customer'];
                }
            }
        }
        else {
            return false;
        }
    }
    */

    public static function getLinkedQbIds(\models\Accounts $account){
        $CI =& get_instance();

        $out = array();

        $query = $CI->em->createQuery('SELECT c.quickbooksId
                    FROM \models\Clients c
                    WHERE c.quickbooksId > 0
                    AND c.account = :accountId')
            ->setParameter('accountId', $account->getAccountId());

        $data = $query->getResult();

        if($data){
            foreach($data as $datum){
                $out[] = $datum['quickbooksId'];
            }
        }

        return $out;

    }

    public static function updateCustomer(\models\Accounts $account, \models\Clients $client, $qbCustomerId){


        $CI =& get_instance();

            $the_tenant = $account->getCompany()->getCompanyId();
            require 'QuickBooks/docs/example_app_ipp_v3/config.php';

            // Set up the IPP instance
            $IPP = new QuickBooks_IPP(QB_DSN);

            // Get our OAuth credentials from the database
            $creds = $IntuitAnywhere->load($the_username, $the_tenant);

            // Tell the framework to load some data from the OAuth store
            $IPP->authMode(
                QuickBooks_IPP::AUTHMODE_OAUTH,
                $the_username,
                $creds);

            // This is our current realm
            $realm = $creds['qb_realm'];

                    // Load the OAuth information from the database
                    if ($Context = $IPP->context())
                    {
                        // Set the IPP version to v3
                        $IPP->version(QuickBooks_IPP_IDS::VERSION_3);

                        $CustomerService = new QuickBooks_IPP_Service_Customer();

                        $customers = $CustomerService->query($Context, $realm, "SELECT * FROM Customer WHERE Id = '" . $qbCustomerId . "' ");

                        if($customers[0]){
                            $Customer = $customers[0];

                            $Customer->setGivenName($client->getFirstName());
                            $Customer->setFamilyName($client->getLastName());
                            $Customer->setDisplayName($client->getFullName() . ' - ' . $client->getCompanyName());
                            $Customer->setCompanyName($client->getCompanyName());

                            // Phone #
                            $PrimaryPhone = new QuickBooks_IPP_Object_PrimaryPhone();
                            $PrimaryPhone->setFreeFormNumber($client->getBusinessPhone());
                            $Customer->setPrimaryPhone($PrimaryPhone);

                            // Cell Phone
                            $CellPhone = new QuickBooks_IPP_Object_Mobile();
                            $CellPhone->setFreeFormNumber($client->getCellPhone());
                            $Customer->setMobile($CellPhone);

                            // Bill address
                            $BillAddr = new QuickBooks_IPP_Object_BillAddr();
                            $BillAddr->setLine1($client->getAddress());
                            $BillAddr->setLine2('');
                            $BillAddr->setCity($client->getCity());
                            $BillAddr->setCountrySubDivisionCode($client->getState());
                            $BillAddr->setPostalCode($client->getZip());
                            $Customer->setBillAddr($BillAddr);

                            // Email address
                            $EmailAddr = new QuickBooks_IPP_Object_PrimaryEmailAddr();
                            $EmailAddr->setAddress($client->getEmail());
                            $Customer->setPrimaryEmailAddr($EmailAddr);


                            if($client->getWebsite()){

                                $http = strpos($client->getWebsite(), 'http://');

                                if($http === false){
                                    $website = 'http://' . $client->getWebsite();
                                }
                                else {
                                    $website = $client->getWebsite();
                                }

                                //Website
                                $WebAddr = new QuickBooks_IPP_Object_WebAddr();
                                $WebAddr->setURI($website);
                                $Customer->setWebAddr($WebAddr);
                            }

                            $resp = $CustomerService->update($Context, $realm, $Customer->getId(), $Customer);

                            if ($resp)
                            {
                                return true;
                            }
                            else
                            {
                                echo $IPP->lastRequest();
                                echo $IPP->lastResponse();
                                return false;
                            }
                        }
                        else {
                            return false;
                        }
                    }

    }

    public static function getQbCustomer(\models\Accounts $account, $qbCustomerId){
        $CI =& get_instance();

        $the_tenant = $account->getCompany()->getCompanyId();
        require 'QuickBooks/docs/example_app_ipp_v3/config.php';

        // Set up the IPP instance
        $IPP = new QuickBooks_IPP(QB_DSN);

        // Get our OAuth credentials from the database
        $creds = $IntuitAnywhere->load($the_username, $the_tenant);

        // Tell the framework to load some data from the OAuth store
        $IPP->authMode(
            QuickBooks_IPP::AUTHMODE_OAUTH,
            $the_username,
            $creds);

        // This is our current realm
        $realm = $creds['qb_realm'];

        // Load the OAuth information from the database
        if ($Context = $IPP->context())
        {
            // Set the IPP version to v3
            $IPP->version(QuickBooks_IPP_IDS::VERSION_3);

            $CustomerService = new QuickBooks_IPP_Service_Customer();

            $customers = $CustomerService->query($Context, $realm, "SELECT * FROM Customer WHERE Id = '" . $qbCustomerId . "' ");

            if(isset($customers[0])){
                return $customers[0];
            }
            else {
                return false;
            }
        }
    }

    public static function clientIsSynced(\models\Accounts $account, \models\Clients $client){

        $customer = QBModel::getQbCustomer($account, $client->getQuickbooksId());

        if($customer){
            // First Name
            if($customer->getGivenName()){

                if(trim($customer->getGivenName()) != trim($client->getFirstName())){
                    return false;
                }
            }
            else {
                if ($client->getFirstName()){
                    return false;
                }
            }

            // Last Name
            if($customer->getFamilyName()){

                if($customer->getFamilyName() != $client->getLastName()){
                    return false;
                }
            }
            else {
                if ($client->getLastName()){
                    return false;
                }
            }

            // Company name
            if($customer->getCompanyName()){
                if($customer->getCompanyName() != $client->getCompanyName()){
                    return false;
                }
            }
            else {
                if ($client->getCompanyName()){
                    return false;
                }
            }

            // Business Phone
            if($customer->getPrimaryPhone()){
                if($customer->getPrimaryPhone()->getFreeFormNumber() != $client->getBusinessPhone()){
                    return false;
                }
            }
            else {
                if ($client->getBusinessPhone()){
                    return false;
                }
            }

            // Cell Phone
            if($customer->getMobile()) {
                if($customer->getMobile()->getFreeFormNumber() != $client->getCellPhone()){
                    return false;
                }
            }
            else {
                if ($client->getCellPhone()){
                    return false;
                }
            }

            // Address
            $address = $customer->getBillAddr();
            /* @var $address QuickBooks_IPP_Object_BillAddr */


            if(!$address){
                return false;
            }

            // Line1
            if($address->getLine1()){
                if($address->getLine1() != $client->getAddress()){
                    return false;
                }
            }
            else {
                return false;
            }

            // City
            if($address->getCity()){
                if($address->getCity() != $client->getCity()){
                    return false;
                }
            }
            else {
                return false;
            }

            // State
            if($address->getCountrySubDivisionCode()){
                if($address->getCountrySubDivisionCode() != $client->getState()){
                    return false;
                }
            }
            else {
                return false;
            }

            // State
            if($address->getPostalCode()){
                if($address->getPostalCode() != $client->getZip()){
                    return false;
                }
            }
            else {
                return false;
            }

            // This point will only be reached if all details are matched, so return true
            return true;
        }

        return false;
    }

}
