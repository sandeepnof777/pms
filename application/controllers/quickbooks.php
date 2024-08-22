<?php


class Quickbooks extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();

        // QuickBooks config
        $this->load->config('quickbooks');
        $this->load->database();
    }

    public function login()
    {
        $companyId = $this->account()->getCompanyId();
        $access_token = $this->uri->segment(3);
        $refresh_token = $this->uri->segment(4);
        $realmId = $_SESSION['realmId'];
        $error = '';
        $this->getQuickbooksRepository()->connect($companyId, $access_token, $refresh_token, $realmId, $error);
        $this->log_manager->add('qb_connect', 'Company Connected to Quickbooks', null, null,
            $this->account()->getCompany());
        // Migrate the services to CQS table
        $this->getQuickbooksRepository()->migrateQbServices($this->account()->getCompany());
        redirect('/account/qbsettings/qblogin', 'refresh');
    }

    /**
     * Generate and return a .QWC Web Connector configuration file
     */
    public function config()
    {
        $name = SITE_NAME.' QuickBooks Desktop API';            // A name for your server (make it whatever you want)
        $descrip = SITE_NAME.' QuickBooks Desktop API';        // A description of your server

        $appurl = 'https://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['REQUEST_URI']) . '/qbwc';        // This *must* be httpS:// (path to your QuickBooks SOAP server)
        $appsupport = $appurl;        // This *must* be httpS:// and the domain name must match the domain name above

        $username = md5($this->account()->getCompanyId());        // This is the username you stored in the 'quickbooks_user' table by using QuickBooks_Utilities::createUser()
        $c_id = $this->account()->getCompanyId();
        // Remove the old record
        $this->getQbdRepository()->remove_quickbooks_user($username);

        // Queue Up services
        $pass = $this->config->item('quickbooks_pass');
        $dsn = $this->getQbdRepository()->dsn;
        QuickBooks_Utilities::createUser($dsn, $username, $pass);
        $this->getQbdRepository()->enqueue(QUICKBOOKS_QUERY_ACCOUNT, $c_id, 1, '', $username);
        $this->getQbdRepository()->add_setting_for_desktop($this->account()->getCompanyId());
        $services = $this->getQbdRepository()->get_service_list_for_queue($this->account()->getCompanyId());
        if ($services) {
            foreach ($services as $service) {
                $this->getQbdRepository()->enqueue(QUICKBOOKS_ADD_SERVICEITEM, $service, 0, '',
                    $username, $this->account()->getCompanyId());
            }
        }

        $fileid = QuickBooks_WebConnector_QWC::fileID();        // Just make this up, but make sure it keeps that format
        $ownerid = QuickBooks_WebConnector_QWC::ownerID();        // Just make this up, but make sure it keeps that format

        $qbtype = QUICKBOOKS_TYPE_QBFS;    // You can leave this as-is unless you're using QuickBooks POS

        $readonly = false; // No, we want to write data to QuickBooks

        $run_every_n_seconds = 600; // Run every 600 seconds (10 minutes)

        // Generate the XML file
        $QWC = new QuickBooks_WebConnector_QWC($name, $descrip, $appurl, $appsupport, $username, $fileid, $ownerid,
            $qbtype, $readonly, $run_every_n_seconds);
        $xml = $QWC->generate();

        // Send as a file download
        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename="pavementlayers-wc-file.qwc"');
        print($xml);
        exit;
    }

    /**
     * SOAP endpoint for the Web Connector to connect to
     */
    public function qbwc()
    {
        $dataPOST = trim(file_get_contents('php://input'));
        if ($dataPOST) {
            $xmlData = simplexml_load_string($dataPOST);
            //$newxml=simplexml_load_string($xml);
            $user = $xmlData->UserName;
        } else {
            $user = $this->config->item('quickbooks_user');
        }

        $pass = md5($this->config->item('quickbooks_pass'));

        // Memory limit
        ini_set('memory_limit', $this->config->item('quickbooks_memorylimit'));

        // We need to make sure the correct timezone is set, or some PHP installations will complain
        if (function_exists('date_default_timezone_set')) {
            // * MAKE SURE YOU SET THIS TO THE CORRECT TIMEZONE! *
            // List of valid timezones is here: http://us3.php.net/manual/en/timezones.php
            date_default_timezone_set($this->config->item('quickbooks_tz'));
        }

        // Map QuickBooks actions to handler functions
        $map = array(
            QUICKBOOKS_ADD_CUSTOMER => array(array($this, '_addCustomerRequest'), array($this, '_addCustomerResponse')),
            QUICKBOOKS_QUERY_CUSTOMER => array(array($this, '_qcstreq'), array($this, '_qcstres')),
            QUICKBOOKS_MOD_CUSTOMER => array(array($this, '_modCustomerRequest'), array($this, '_modCustomerResponse')),
            QUICKBOOKS_ADD_SERVICEITEM => array(array($this, '_addItemRequest'), array($this, '_addItemResponse')),
            QUICKBOOKS_MOD_SERVICEITEM => array(array($this, '_modItemRequest'), array($this, '_modItemResponse')),
            QUICKBOOKS_ADD_INVOICE => array(array($this, '_addInvoiceRequest'), array($this, '_addInvoiceResponse')),
            QUICKBOOKS_MOD_INVOICE => array(array($this, '_modInvoiceRequest'), array($this, '_modInvoiceResponse')),
            QUICKBOOKS_QUERY_ACCOUNT => array(array($this, '_quAccountRequest'), array($this, '_quAccountResponse')),
            QUICKBOOKS_QUERY_INVOICE => array(array($this, '_getinRequest'), array($this, '_getinResponse')),
        );

        // Catch all errors that QuickBooks throws with this function
        $errmap = array(
            '*' => array($this, '_catchallErrors'),
        );

        // Call this method whenever the Web Connector connects
        $hooks = array(//QuickBooks_WebConnector_Handlers::HOOK_LOGINSUCCESS => array( array( $this, '_loginSuccess' ) ), 	// Run this function whenever a successful login occurs
        );

        // An array of callback options
        $callback_options = array();

        // Logging level
        $log_level = $this->config->item('quickbooks_loglevel');

        // What SOAP server you're using
        //$soapserver = QUICKBOOKS_SOAPSERVER_PHP;			// The PHP SOAP extension, see: www.php.net/soap
        $soapserver = QUICKBOOKS_SOAPSERVER_BUILTIN;        // A pure-PHP SOAP server (no PHP ext/soap extension required, also makes debugging easier)

        $soap_options = array(        // See http://www.php.net/soap
        );

        $handler_options = array(
            'deny_concurrent_logins' => false,
            'deny_reallyfast_logins' => false,
        );        // See the comments in the QuickBooks/Server/Handlers.php file

        $driver_options = array(        // See the comments in the QuickBooks/Driver/<YOUR DRIVER HERE>.php file ( i.e. 'Mysql.php', etc. )
            'max_log_history' => 32000,
            // Limit the number of quickbooks_log entries to 1024
            'max_queue_history' => 1024,
            // Limit the number of *successfully processed* quickbooks_queue entries to 64
        );

        // Build the database connection string
        $dsn = 'mysqli://' . $this->db->username . ':' . $this->db->password . '@' . $this->db->hostname . '/' . $this->db->database;

        // Check to make sure our database is set up
        if (!QuickBooks_Utilities::initialized($dsn)) {
            // Initialize creates the neccessary database schema for queueing up requests and logging
            QuickBooks_Utilities::initialize($dsn);

            // This creates a username and password which is used by the Web Connector to authenticate
            QuickBooks_Utilities::createUser($dsn, $user, $pass);
        }

        // Set up our queue singleton
        QuickBooks_WebConnector_Queue_Singleton::initialize($dsn);

        // Create a new server and tell it to handle the requests
        // __construct($dsn_or_conn, $map, $errmap = array(), $hooks = array(), $log_level = QUICKBOOKS_LOG_NORMAL, $soap = QUICKBOOKS_SOAPSERVER_PHP, $wsdl = QUICKBOOKS_WSDL, $soap_options = array(), $handler_options = array(), $driver_options = array(), $callback_options = array()
        $Server = new QuickBooks_WebConnector_Server($dsn, $map, $errmap, $hooks, $log_level, $soapserver,
            QUICKBOOKS_WSDL, $soap_options, $handler_options, $driver_options, $callback_options);
        $response = $Server->handle(true, true);
    }

    /**
     * Issue a request to QuickBooks to add a customer
     */

    public function _addCustomerRequest(
        $requestID,
        $user,
        $action,
        $ID,
        $extra,
        &$err,
        $last_action_time,
        $last_actionident_time,
        $version,
        $locale
    ) {
        // Do something here to load data using your model
        $client = $this->em->find('models\Clients', $ID);
        /* @var models\Clients $client */

        if($extra=='Duplicate'){
            
            $customer_name = $ID.'-' . $client->getFirstName() . ' ' . $client->getLastName();
        }else{
            $customer_name = $client->getFirstName() . ' ' . $client->getLastName();
        }
        // Build the qbXML request from $data
        $xml = '<?xml version="1.0" encoding="utf-8"?>
				<?qbxml version="2.0"?>
				<QBXML>
					<QBXMLMsgsRq onError="continueOnError">
						<CustomerAddRq requestID="' . $requestID . '">
							<CustomerAdd>
								<Name>' . $customer_name . '</Name>
								<CompanyName>' . $client->getClientAccount()->getName() . '</CompanyName>
								<FirstName>' . $client->getFirstName() . '</FirstName>
								<LastName>' . $client->getLastName() . '</LastName>
								<BillAddress>
									<Addr1>' . $client->getBillingAddress() . '</Addr1>
									<Addr2></Addr2>
									<City>' . $client->getBillingCity() . '</City>
									<State>' . $client->getBillingState() . '</State>
									<PostalCode>' . $client->getBillingZip() . '</PostalCode>
									<Country></Country>
								</BillAddress>
								<Phone>' . $client->getBusinessPhone() . '</Phone>
								<AltPhone>' . $client->getCellPhone() . '</AltPhone>
								<Fax>' . $client->getFax() . '</Fax>
								<Email>' . $client->getEmail() . '</Email>
								<Contact>' . $client->getFirstName() . ' ' . $client->getLastName() . '</Contact>
							</CustomerAdd>
						</CustomerAddRq>
					</QBXMLMsgsRq>
				</QBXML>';

        return $xml;
    }

    /**
     * Handle a response from QuickBooks indicating a new customer has been added
     */
    public function _addCustomerResponse(
        $requestID,
        $user,
        $action,
        $ID,
        $extra,
        &$err,
        $last_action_time,
        $last_actionident_time,
        $xml,
        $idents
    ) {
        $newxml = simplexml_load_string($xml);

        $ListID = $newxml->QBXMLMsgsRs->CustomerAddRs->CustomerRet->ListID;
        $EditSequence = $newxml->QBXMLMsgsRs->CustomerAddRs->CustomerRet->EditSequence;
        return $this->getQbdRepository()->update_add_contact_result($ListID, $EditSequence, $ID);
    }

    /**
     * Catch and handle errors from QuickBooks
     */
    public function _catchallErrors($requestID, $user, $action, $ID, $extra, &$err, $xml, $errnum, $errmsg)
    {
       
        if ($action=='ItemServiceAdd' && $errnum =='3100') {
            $this->load->model('quickbooks_model');
            $this->quickbooks_model->dsn('mysqli://' . $this->db->username . ':' . $this->db->password . '@' . $this->db->hostname . '/' . $this->db->database);
            $this->quickbooks_model->enqueue(QUICKBOOKS_ADD_SERVICEITEM, $ID, 5, 'Duplicate', $user);
        }else if($action=='CustomerAdd' && $errnum =='3100'){
            $this->load->model('quickbooks_model');
            $this->quickbooks_model->dsn('mysqli://' . $this->db->username . ':' . $this->db->password . '@' . $this->db->hostname . '/' . $this->db->database);
            $this->quickbooks_model->enqueue(QUICKBOOKS_ADD_CUSTOMER, $ID, 5, 'Duplicate', $user);
        }
        
       
       
        return false;
    }



    /**
     * Whenever the Web Connector connects, do something (e.g. queue some stuff up if you want to)
     */
    public function _loginSuccess($requestID, $user, $hook, &$err, $hook_data, $callback_config)
    {
        return true;
    }

    public function _addItemRequest(
        $requestID,
        $user,
        $action,
        $ID,
        $extra,
        &$err,
        $last_action_time,
        $last_actionident_time,
        $version,
        $locale
    ) {
        // Load the service
        $service = $this->em->findService($ID);

        $company_id = $this->getQbdRepository()->get_company_id_by_username($user);
        // Extra here is the company Id
        $service_name = $service->getTitle($company_id);

        $service_name = $company_id.'-'. $service_name;

        if($extra=='Duplicate'){
            
            $service_name = $ID.'-'. $service_name;
        }
        // Get the account name that the item belongs to
        $account_name = $this->getQbdRepository()->get_income_account_for_service($user);
        $this->getQbdRepository()->migrate_company_qb_service($service,$user);


        $xml = '<?xml version="1.0" encoding="utf-8"?>
				<?qbxml version="5.0"?>
				<QBXML>
				  <QBXMLMsgsRq onError="stopOnError">
					<ItemServiceAddRq requestID="' . $requestID . '" >
					  <ItemServiceAdd>
						<Name>' . substr($service_name, 0, 31) . '</Name>
						<SalesOrPurchase>
						  <Desc> </Desc>
						  <Price> </Price>
						  <AccountRef>
							<FullName>' . $account_name . '</FullName>
						  </AccountRef>
						</SalesOrPurchase>
					  </ItemServiceAdd>
					</ItemServiceAddRq>
				  </QBXMLMsgsRq>
				</QBXML>';

        return $xml;
    }


    public function _addItemResponse(
        $requestID,
        $user,
        $action,
        $ID,
        $extra,
        &$err,
        $last_action_time,
        $last_actionident_time,
        $xml,
        $idents
    ) {
        $newxml = simplexml_load_string($xml);
        
        $ListID = $newxml->QBXMLMsgsRs->ItemServiceAddRs->ItemServiceRet->ListID;
        $EditSequence = $newxml->QBXMLMsgsRs->ItemServiceAddRs->ItemServiceRet->EditSequence;
        return $this->getQbdRepository()->update_add_service_result($ListID, $EditSequence, $ID,$user);
    }

    public function _addInvoiceRequest(
        $requestID,
        $user,
        $action,
        $ID,
        $extra,
        &$err,
        $last_action_time,
        $last_actionident_time,
        $version,
        $locale
    ) {

        $proposal = $this->em->findProposal($ID);
        $companyId = $proposal->getClient()->getCompany()->getCompanyId();
        $proposalServices = $this->em->createQuery('select ps from models\Proposal_services ps where ps.proposal=' . $proposal->getProposalId() . ' order by ps.ord, ps.serviceId')->getResult();

        if($proposal->getClient()->getQbListId()){
            $CustomerRef = '<ListID>'.$proposal->getClient()->getQbListId().'</ListID>';
        }else{
            $this->quickbooks_model->enqueue(QUICKBOOKS_ADD_CUSTOMER, $proposal->getClient()->getClientId(), 5, '', $user);
            return true;
            //$CustomerRef = '<FullName>' . $proposal->getClient()->getFullName() . '</FullName>';
        }
        
        $xml = '<?xml version="1.0" encoding="utf-8"?>
				<?qbxml version="10.0"?>
				<QBXML>
				  <QBXMLMsgsRq onError="stopOnError">
					<InvoiceAddRq requestID="' . $requestID . '">
					  <InvoiceAdd>
						<CustomerRef>'.$CustomerRef.'</CustomerRef>
						<TxnDate>' . date("Y-m-d", strtotime($proposal->getCreated())) . '</TxnDate>
						<RefNumber></RefNumber>
						<BillAddress>
						  <Addr1>' . $proposal->getClient()->getAddress() . '</Addr1>
						  <City>' . $proposal->getClient()->getCity() . '</City>
						  <State>' . $proposal->getClient()->getState() . '</State>
						  <PostalCode>' . $proposal->getClient()->getZip() . '</PostalCode>
						  <Country></Country>
						</BillAddress>
						<PONumber></PONumber>
						<Memo></Memo>
						';
        for ($x = 0; $x < count($proposalServices); $x++) {

            $CompanyQbService = $this->em->createQuery('select cqs from models\CompanyQbService cqs where cqs.service_id=' . $proposalServices[$x]->getInitialService() . ' AND  cqs.company_id='. $companyId)->getResult();

            $ItemRef = '<FullName>' . $proposalServices[$x]->getServiceName() . '</FullName>';
            if($CompanyQbService){
                if($CompanyQbService[0]->getQbListId()){
                    $ItemRef = '<ListID>'.$CompanyQbService[0]->getQbListId().'</ListID>';
                }
                
            }


            $cleanPrice = str_replace(['$', ','], ['', ''], $proposalServices[$x]->getPrice());
            $formattedPrice = number_format($cleanPrice, 2, '.', '');
            $xml .= '<InvoiceLineAdd>
						  <ItemRef>'.$ItemRef.'</ItemRef>
						  <Desc>' . $proposalServices[$x]->getServiceName() . '</Desc>
						  <Quantity></Quantity>
						  <Rate>' . $formattedPrice . '</Rate>
						</InvoiceLineAdd>
						';
        }

        $xml .= '</InvoiceAdd>
					</InvoiceAddRq>
				  </QBXMLMsgsRq>
				</QBXML>';

        return $xml;
    }

    public function _addInvoiceResponse(
        $requestID,
        $user,
        $action,
        $ID,
        $extra,
        &$err,
        $last_action_time,
        $last_actionident_time,
        $xml,
        $idents
    ) {
        $newxml = simplexml_load_string($xml);

        $EditSequence = $newxml->QBXMLMsgsRs->InvoiceAddRs->InvoiceRet->EditSequence;
        return $this->getQbdRepository()->update_add_invoice_result($idents['TxnID'], $EditSequence, $ID);
    }

    public function _getinRequest(
        $requestID,
        $user,
        $action,
        $ID,
        $extra,
        &$err,
        $last_action_time,
        $last_actionident_time,
        $version,
        $locale
    ) {

        $emailData = [
            'to' => 'andy@pavementlayers.com',
            'fromName' => 'Server',
            'fromEmail' => 'andy@pavementlayers.com',
            'subject' => 'Invoice Request',
            'body' => 'This should be requesting'
        ];

        $this->getEmailRepository()->send($emailData);

        $txn_id = $this->getQbdRepository()->get_txn_id_by_ident($ID);

        $xml = '<?xml version="1.0" encoding="utf-8"?>
				<?qbxml version="10.0"?>
				<QBXML>

				  <QBXMLMsgsRq onError="stopOnError">
					<InvoiceQueryRq requestID="' . $requestID . '">
					  <TxnID>' . $txn_id . '</TxnID>
					</InvoiceQueryRq>
				  </QBXMLMsgsRq>
				</QBXML>';

        return $xml;
    }

    public function _getinResponse(
        $requestID,
        $user,
        $action,
        $ID,
        $extra,
        &$err,
        $last_action_time,
        $last_actionident_time,
        $xml,
        $idents
    ) {

        $newxml = simplexml_load_string($xml);

        $appl_amm = $newxml->QBXMLMsgsRs->InvoiceQueryRs->InvoiceRet->AppliedAmount;
        $appl_amm = str_replace("-", "", $appl_amm);
        if ($appl_amm > 0) {

            return $this->getQbdRepository()->update_invoice_result($appl_amm, $ID);

        } else {

            return true;
        }


    }

    public function _modCustomerRequest(
        $requestID,
        $user,
        $action,
        $ID,
        $extra,
        &$err,
        $last_action_time,
        $last_actionident_time,
        $version,
        $locale
    ) {

        $client = $this->em->find('models\Clients', $ID);
        $edit_data = $this->getQbdRepository()->get_customer_list_id_by_ident($ID);
        $list_id = $edit_data['list_id'];
        $edit_seq = $edit_data['edit_seq'];

        if (strpos($edit_data['extra'], 'Duplicate') !== false) {
            $customer_name = $ID.'-' . $client->getFirstName() . ' ' . $client->getLastName();
        }else{
            $customer_name = $client->getFirstName() . ' ' . $client->getLastName();
        }

        $xml = '<?xml version="1.0" encoding="utf-8"?>
				<?qbxml version="8.0"?>
				<QBXML>
				  <QBXMLMsgsRq onError="stopOnError">
					<CustomerModRq requestID="' . $requestID . '">
					  <CustomerMod>
						<ListID>' . $list_id . '</ListID>
						<EditSequence>' . $edit_seq . '</EditSequence>
				 		<Name>' . $customer_name . '</Name>
								<CompanyName>' . $client->getClientAccount()->getName() . '</CompanyName>
								<FirstName>' . $client->getFirstName() . '</FirstName>
								<LastName>' . $client->getLastName() . '</LastName>
								<BillAddress>
									<Addr1>' . $client->getBillingAddress() . '</Addr1>
									<Addr2></Addr2>
									<City>' . $client->getBillingCity() . '</City>
									<State>' . $client->getBillingState() . '</State>
									<PostalCode>' . $client->getBillingZip() . '</PostalCode>
									<Country></Country>
								</BillAddress>
								<Phone>' . $client->getBusinessPhone() . '</Phone>
								<AltPhone>' . $client->getCellPhone() . '</AltPhone>
								<Fax>' . $client->getFax() . '</Fax>
								<Email>' . $client->getEmail() . '</Email>
								<Contact>' . $client->getFirstName() . ' ' . $client->getLastName() . '</Contact>
				 	  </CustomerMod>
					</CustomerModRq>
				  </QBXMLMsgsRq>
				</QBXML>';

        return $xml;

    }

    public function _modCustomerResponse(
        $requestID,
        $user,
        $action,
        $ID,
        $extra,
        &$err,
        $last_action_time,
        $last_actionident_time,
        $xml,
        $idents
    ) {

        $newxml = simplexml_load_string($xml);

        $ListID = $newxml->QBXMLMsgsRs->CustomerModRs->CustomerRet->ListID;
        $EditSequence = $newxml->QBXMLMsgsRs->CustomerModRs->CustomerRet->EditSequence;
        return $this->getQbdRepository()->update_mod_contact_result($ListID, $EditSequence, $ID);
    }

    public function _modItemRequest(
        $requestID,
        $user,
        $action,
        $ID,
        $extra,
        &$err,
        $last_action_time,
        $last_actionident_time,
        $version,
        $locale
    ) {

        $service = $this->em->find('models\Services', $ID);
        // $this->db->select('title')->from('service_titles')->where('service', $ID);
        // $query = $this->db->get();
        // if ($query->num_rows() > 0) {
        //     $data = $query->result_array();
        //     $service_name = $data[0]['title'];
        // } else {
        //     $service_name = $service->getServiceName();
        // }

        $edit_data = $this->getQbdRepository()->get_service_list_id_by_ident($ID);
        $account_name = $this->getQbdRepository()->get_income_account_for_service($user);
        $list_id = $edit_data['list_id'];
        $edit_seq = $edit_data['edit_seq'];

        $service_name = $service->getTitle($extra);

        if (strpos($edit_data['extra'], 'Duplicate') !== false) {
            
            $service_name = $ID.'-'. $service_name;
        }
        $xml = '<?xml version="1.0" encoding="utf-8"?>
					<?qbxml version="8.0"?>
					<QBXML>
  						 <QBXMLMsgsRq onError="stopOnError">
      						<ItemServiceModRq requestID="' . $requestID . '">
         						<ItemServiceMod  >
           							<ListID>' . $list_id . '</ListID>
									<EditSequence>' . $edit_seq . '</EditSequence>
									<Name>' . substr($service_name, 0, 31) . '</Name>
            						<SalesOrPurchaseMod>
          								<Desc> </Desc>
          								<Price> </Price>
										<AccountRef>
											<FullName>' . $account_name . '</FullName>
										</AccountRef>
       								</SalesOrPurchaseMod>
 							</ItemServiceMod>
 						 </ItemServiceModRq>
					  </QBXMLMsgsRq>
					</QBXML>';
        return $xml;
    }

    public function _modItemResponse(
        $requestID,
        $user,
        $action,
        $ID,
        $extra,
        &$err,
        $last_action_time,
        $last_actionident_time,
        $xml,
        $idents
    ) {

        $newxml = simplexml_load_string($xml);

        $ListID = $newxml->QBXMLMsgsRs->ItemServiceModRs->ItemServiceRet->ListID;
        $EditSequence = $newxml->QBXMLMsgsRs->ItemServiceModRs->ItemServiceRet->EditSequence;
        return $this->getQbdRepository()->update_mod_service_result($ListID, $EditSequence, $ID);

    }

    public function _qcstreq(
        $requestID,
        $user,
        $action,
        $ID,
        $extra,
        &$err,
        $last_action_time,
        $last_actionident_time,
        $version,
        $locale
    ) {

        $client = $this->em->find('models\Clients', $ID);
        $xml = '<?xml version="1.0" encoding="utf-8"?>
				<?qbxml version="8.0"?>
				<QBXML>
				  <QBXMLMsgsRq onError="continueOnError">
					<CustomerQueryRq requestID="' . $requestID . '">
						<FullName>' . $client->getFirstName() . ' ' . $client->getLastName() . '</FullName>
						<OwnerID>0</OwnerID>
					</CustomerQueryRq>  
				  </QBXMLMsgsRq>
				</QBXML>';
        return $xml;
    }

    public function _qcstres(
        $requestID,
        $user,
        $action,
        $ID,
        $extra,
        &$err,
        $last_action_time,
        $last_actionident_time,
        $xml,
        $idents
    ) {
        $newxml = simplexml_load_string($xml);
        $attr = $newxml->QBXMLMsgsRs->CustomerQueryRs[0]->attributes();

        if ($attr['statusCode'] == 0) {

            $ListID = $newxml->QBXMLMsgsRs->CustomerQueryRs->CustomerRet->ListID;
            $EditSequence = $newxml->QBXMLMsgsRs->CustomerQueryRs->CustomerRet->EditSequence;
            $this->getQbdRepository()->add_contact_in_queue($ListID, $EditSequence, $ID);

        }

        return true;
    }

    public function _modInvoiceRequest(
        $requestID,
        $user,
        $action,
        $ID,
        $extra,
        &$err,
        $last_action_time,
        $last_actionident_time,
        $version,
        $locale
    ) {

        $proposal = $this->em->find('models\Proposals', $ID);
        $client_id = $proposal->getClient()->getClientId();
        $proposalServices = $this->em->createQuery('select ps from models\Proposal_services ps where ps.proposal=' . $proposal->getProposalId() . ' order by ps.ord, ps.serviceId')->getResult();
        $edit_data = $this->getQbdRepository()->get_invoice_txn_id_by_ident($ID);
        $client_list_id = $this->getQbdRepository()->get_list_id_by_client_id($client_id);
        $txn_id = $edit_data['txn_id'];
        $edit_seq = $edit_data['edit_seq'];

        $xml = '<?xml version="1.0" encoding="utf-8"?>
				<?qbxml version="6.0"?><QBXML>
					<QBXMLMsgsRq onError="stopOnError">
						<InvoiceModRq requestID="' . $requestID . '">
							<InvoiceMod> 
								<TxnID >' . $txn_id . '</TxnID> 
								<EditSequence >' . $edit_seq . '</EditSequence>
								<CustomerRef>
									<ListID >' . $client_list_id . '</ListID>
								</CustomerRef>';
        for ($x = 0; $x < count($proposalServices); $x++) {
            $service_id = $proposalServices[$x]->getInitialService();
            //$service_data = $this->getQbdRepository()->get_service_list_id_by_ident($service_id);
            $cleanPrice = str_replace(['$', ','], ['', ''], $proposalServices[$x]->getPrice());
            $formattedPrice = number_format($cleanPrice, 2, '.', '');
            
            $CompanyQbService = $this->em->createQuery('select cqs from models\CompanyQbService cqs where cqs.service_id=' . $service_id . ' AND  cqs.company_id='. $proposal->getCompanyId())->getResult();

            $ItemRef = '<FullName>' . $proposalServices[$x]->getServiceName() . '</FullName>';
            if($CompanyQbService){
                if($CompanyQbService[0]->getQbListId()){
                    $ItemRef = '<ListID>'.$CompanyQbService[0]->getQbListId().'</ListID>';
                }
                
            }
            $xml .= '<InvoiceLineMod>
								<TxnLineID >-1</TxnLineID> 
								<ItemRef>'. $ItemRef .'</ItemRef>
								<Desc></Desc>
								<Rate>' . $formattedPrice. '</Rate>
							</InvoiceLineMod>';
        }
        $xml .= '</InvoiceMod>
               		</InvoiceModRq>
			   	</QBXMLMsgsRq>
        	</QBXML>';
        return $xml;
    }

    public function _modInvoiceResponse(
        $requestID,
        $user,
        $action,
        $ID,
        $extra,
        &$err,
        $last_action_time,
        $last_actionident_time,
        $xml,
        $idents
    ) {
        $newxml = simplexml_load_string($xml);

        $EditSequence = $newxml->QBXMLMsgsRs->InvoiceModRs->InvoiceRet->EditSequence;
        return $this->getQbdRepository()->update_mod_invoice_result($EditSequence, $ID);
    }

    public function _quAccountRequest(
        $requestID,
        $user,
        $action,
        $ID,
        $extra,
        &$err,
        $last_action_time,
        $last_actionident_time,
        $version,
        $locale
    ) {

        $xml = '<?xml version="1.0" encoding="utf-8"?>
				<?qbxml version="2.0"?>
				<QBXML>
					<QBXMLMsgsRq onError="stopOnError">
						<AccountQueryRq requestID="' . $requestID . '">
						</AccountQueryRq>
					</QBXMLMsgsRq>
				</QBXML>';
        return $xml;
    }

    public function _quAccountResponse(
        $requestID,
        $user,
        $action,
        $ID,
        $extra,
        &$err,
        $last_action_time,
        $last_actionident_time,
        $xml,
        $idents
    ) {
        $newxml = simplexml_load_string($xml);
        $newxml = json_decode(json_encode($newxml), true);
        $account = $newxml['QBXMLMsgsRs']['AccountQueryRs']['AccountRet'];
        //print_r($account);
        $data = '';
        for ($i = 0; $i < count($account); $i++) {
            $name = $account[$i]['FullName'];
            $type = $account[$i]['AccountType'];
            $data = array(
                'acc_name' => $name,
                'acc_type' => $type,
                'c_id' => $ID
            );
            $this->getQbdRepository()->add_accounts($data);
        }

        // $this->Add_user->save_accounts($data);
        return true;
    }


}
	