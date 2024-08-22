<?php
class Clients extends MY_Controller
{
    /**
     * @var Html
     */
    var $html;

    function __construct()
    {
        $this->login_restricted = true;
        parent::__construct();
		
		// QuickBooks config
		$this->load->config('quickbooks');
		
		// QuickBooks model
		$this->load->model('quickbooks_model');
		
		// Configure the model
		$this->load->database();
		$this->quickbooks_model->dsn('mysqli://' . $this->db->username . ':' . $this->db->password . '@' . $this->db->hostname . '/' . $this->db->database);
        // Load some extra stuff we'll need
        //        $this->load->library('qbmodel');
        //        $this->load->library('clientmodel');
        //        $this->load->file(QBModel::LIB_FILE);
    }

    function index()
    {
        $clients = array();
        $data['clients'] = $clients;
        $data['group'] = '';
        $data['account'] = $this->account();
        $data['accounts'] = $this->account()->getCompany()->getAccounts();
        $data['resends'] = $this->getClientRepository()->getCompanyClientResendList($this->account()->getCompany(),$this->account());

        $data['search'] = $this->input->post('searchClient') ?: '';
        $this->load->model('branchesapi');
        $data['branches'] = $this->branchesapi->getBranches($this->account()->getCompany()->getCompanyId());
        $data['clientAccounts'] = $this->account()->getCompany()->getClientAccounts(true);
        $data['email_template_fields'] = $this->getClientRepository()->getClientTemplateFields();
        $data['save_filters'] = $this->getClientRepository()->getClientSavedFilters($this->account());
        $filteredClientAccounts = [];
        if (is_array($this->session->userdata('cFilterClientAccount'))) {
            foreach ($this->session->userdata('cFilterClientAccount') as $caId) {
                $filteredClientAccounts[] = $this->em->findClientAccount($caId);
            }
        }
        $data['filteredClientAccounts'] = $filteredClientAccounts;
        //$data['clients'] = $this->account()->getCompany()->getClients();
        $data['clientAccounts'] = $this->account()->getCompany()->getClientAccounts(true);
        $this->load->model('clientEmail');
        $data['clientTemplates'] = $this->clientEmail->getTemplates($this->account()->getCompany()->getCompanyId(), \models\ClientEmailTemplateType::CLIENT, true);
        $data['companyAccounts'] = $this->account()->getCompany()->getAccounts();
        $this->html->addScript('scheduler');
        $this->html->addScript('dataTables');
        $this->html->addScript('ckeditor4');
        $data['resendId'] = $this->uri->segment(3) ?: '';
        $data['campaignEmailFilter'] = $this->uri->segment(4) ?: '';
        $data['filterResend'] = false;
        $data['show_last_activity'] = 'true';
        $data['show_opened_at'] = 'false';
        $data['businessTypes'] = $this->getCompanyRepository()->getCompanyBusinessTypes($this->account()->getCompany());
        $this->html->addScript('select2');

        if($this->uri->segment(2)=='resend'){

                    $data['filterResend'] = true;
                    $data['show_last_activity'] = 'false';
                    $data['show_opened_at'] = 'true';
                    $data['resend'] = $this->em->find('models\ClientGroupResend', $data['resendId']);
                    $data['resendStats'] = $this->getClientRepository()->getClientResendStats($data['resend'],$this->account());
                    $data['child_resends'] = $this->getClientRepository()->getClientChildResend($data['resendId']);
                    
                    $this->load->view('clients/index-resend', $data);
                    
        }else{
           
            $this->load->view('clients/index', $data);
        }
        
    }

    function search()
    {
        $this->index();
    }

    function group()
    {
        $clients = array();
        $data['clients'] = $clients;
        $data['account'] = $this->account();
        $data['group'] = 'group';
        $data['search'] = '';
        $this->load->model('branchesapi');
        $data['branches'] = $this->branchesapi->getBranches($this->account()->getCompany()->getCompanyId());
        $data['clientAccounts'] = $this->account()->getCompany()->getClientAccounts(true);
        $this->load->model('clientEmail');
        $data['clientTemplates'] = $this->clientEmail->getTemplates($this->account()->getCompany()->getCompanyId(), \models\ClientEmailTemplateType::CLIENT, true);
        $data['companyAccounts'] = $this->account()->getCompany()->getAccounts();
        // Load branches
        $this->load->model('branchesapi');
        $data['branches'] = $this->branchesapi->getBranches($this->account()->getCompany()->getCompanyId());
        $data['accounts'] = $this->account()->getCompany()->getAccounts();
        $this->html->addScript('dataTables');
        $this->html->addScript('ckeditor4');
        $this->load->view('clients/index', $data);
    }

    function add()
    {
        

        $data = array();
       // echo $this->session->userdata('co_firstName');die;
        $data['qbPermission'] = false;
        $this->load->library('form_validation');
        $this->form_validation->set_rules('firstName', 'First Name', 'required');
        $this->form_validation->set_rules('lastName', 'Last Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('state', 'State', 'required');
        $this->form_validation->set_rules('address', 'Address', 'required');
        $this->form_validation->set_rules('city', 'City', 'required');
        $this->form_validation->set_rules('zip', 'Zip Code', 'required');
        if ($this->form_validation->run()) {

            // If we don't have a selected CLientAccountID
            if (!$this->input->post('accountId')) {

                // If no company name given, set it to residential account
                if (!$this->input->post('accCompanyName')) {
                    $clientAccount = $this->account()->getCompany()->findResidentialAccount();
                } else {
                    // Create New Account
                    $clientAccount = new \models\ClientCompany();
                    $clientAccount->setCreated(time());
                    $clientAccount->setName($this->input->post('accCompanyName'));
                    $clientAccount->setOwnerCompany($this->account()->getCompany());

                    $ownerAccount = $this->em->find('\models\Accounts', $this->input->post('owner'));
                    if ($ownerAccount) {
                        $clientAccount->setOwnerUser($ownerAccount);
                    } else {
                        $clientAccount->setOwnerUser($this->account());
                    }
                    $this->em->persist($clientAccount);
                    $this->em->flush();
                }
            } else {
                $clientAccount = $this->em->find('\models\ClientCompany', $this->input->post('accountId'));
            }

            //Allow only english world some time it' was containg Arabic word
             $address  = $this->input->post('address');
             $city = $this->input->post('city');
             $billingAddress = $this->input->post('billingAddress');
             $billingCity = $this->input->post('billingCity');
             $address = preg_replace('/[^\p{L}\s,.-]/u', '', $address);
             $city = preg_replace('/[^\p{L}\s,.-]/u', '', $city);
             $billingAddress = preg_replace('/[^\p{L}\s,.-]/u', '', $billingAddress);
             $billingCity = preg_replace('/[^\p{L}\s,.-]/u', '', $billingCity); 

            //Allow only english word end
            $client = new models\Clients();
            $client->setFirstName($this->input->post('firstName'));
            $client->setLastName($this->input->post('lastName'));
            $client->setBusinessPhone($this->input->post('businessPhone'));
            $client->setBusinessPhoneExt($this->input->post('businessPhoneExt'));
            $client->setEmail($this->input->post('email'));
            $client->setCellPhone($this->input->post('cellPhone'));
            $client->setFax($this->input->post('fax'));
            $client->setTitle($this->input->post('title'));
            $client->setState($this->input->post('state'));
            $client->setAddress($address);
            $client->setCity($city);
            $client->setZip($this->input->post('zip'));
            $client->setBillingFirstName($this->input->post('billingFirstName'));
            $client->setBillingLastName($this->input->post('billingLastName'));
            $client->setBillingBusinessPhone($this->input->post('billingBusinessPhone'));
            $client->setBillingBusinessPhoneExt($this->input->post('billingBusinessPhoneExt'));
            $client->setBillingEmail($this->input->post('billingEmail'));
            $client->setBillingCellPhone($this->input->post('billingCellPhone'));
            $client->setBillingFax($this->input->post('billingFax'));
            $client->setBillingTitle($this->input->post('billingTitle'));
            $client->setBillingState($this->input->post('billingState'));
            $client->setBillingAddress($billingAddress);
            $client->setBillingCity($billingCity);
            $client->setBillingZip($this->input->post('billingZip'));
            $client->setWebsite($this->input->post('website'));
            $client->setCountry($this->input->post('country'));
            if (!$this->input->post('owner')) {
                $client->setAccount($this->account());
            } else {
                $assignedAccount = $this->em->find('models\Accounts', $this->input->post('owner'));
                $client->setAccount($assignedAccount);
            }
            $client->setCompany($this->account()->getCompany());
            $client->setLastActivity();
            $client->setClientAccount($clientAccount);
            $this->em->persist($client);
            $this->em->flush();

            $business_types = $this->input->post('business_type');
            if($business_types){
                foreach($business_types as $business_type){
                    
                    $this->getProposalRepository()->checkClientAssignmentInAccount($client->getClientAccount()->getId(),$business_type,$this->account()->getCompany()->getCompanyId());
                    $assignment = new models\BusinessTypeAssignment();
                    $assignment->setBusinessTypeId($business_type);
                    $assignment->setCompanyId($this->account()->getCompany()->getCompanyId());
                    $assignment->setClientId($client->getClientId());
                    $this->em->persist($assignment);
                }

                $this->em->flush();
            }
            $this->log_manager->add(\models\ActivityAction::ADD_CONTACT, 'Added Contact ' . $client->getFullName() . ' of ' . $client->getClientAccount()->getName());

            if ($this->uri->segment(3) == 'proposal') {
                $this->session->set_flashdata('success', 'Contact added successfully!');
                redirect('proposals/add/' . $client->getClientId());
            } else {
                $qbMsg = '';

                if ($this->input->post('addToQb')) {
                    $clientId = QBModel::addCustomer($this->account(), $client);

                    if ($clientId) {
						
                        $qbMsg = '<br /><br /><p>Contact successfully added to QuickBooks!<br /><br />This contact will now be visible in your QuickBooks Customers.</p>';
                    } else {
                        $qbMsg = '<br /><br /><p>Syncing Contact to QuickBooks failed. This is usually caused by a duplicate display name within QuickBooks.</p><br />'
                            . '<p>QuickBooks does not permit customers with a duplicate first and last name combination.</p>'
                            . '<p>Please check your existing QuickBooks customers</p>';
                    }
                }

                

                $this->session->set_flashdata('success', 'Contact saved succesfully!' . $qbMsg);
                redirect('clients');
            }
        }


        $duplicate = FALSE;
        $is_create_proposal = 0;
        if ($this->uri->segment(3)) {
            if($this->uri->segment(3)=='proposal'){
                $is_create_proposal = 1;
            }else{
                $client = $this->em->find('models\Clients', $this->uri->segment(3));
                if ($client) {
                    $duplicate = $client;
                }
            }
            
        }

        $data['account'] = $this->account();
        $data['duplicate'] = $duplicate;
        $data['is_create_proposal'] = $is_create_proposal;
        
        $data['businessTypes'] = $this->getCompanyRepository()->getCompanyBusinessTypes($this->account()->getCompany());
        $this->html->addScript('select2');
        $this->load->view('clients/add', $data);
    }

    function edit()
    {
 
        $data = array();
        //Quickbooks permission
//        $data['qbPermission'] = QBModel::hasPermission($this->account());
        $data['qbPermission'] = false;
        $data['qbLinked'] = false;
        $data['qbSynced'] = false;
 
         $client = $this->em->find('models\Clients', $this->uri->segment(3));

  
         /* @var $client \models\Clients */
        if (!$client) {
            $this->session->set_flashdata('error', 'Contact does not exist!');
            redirect('clients');
        }
        //preserver referrer



        // Check to see if linked
        if ($data['qbPermission']) {
            if ($client->getQuickbooksId()) {
                $data['qbLinked'] = true;

                if (QBModel::clientIsSynced($this->account(), $client)) {
                    $data['qbSynced'] = true;
                }
            }
        }

        //check access level
        if (($this->account()->getCompany() == $client->getCompany()) && (($this->account()->isAdministrator()) || ($this->account()->getFullAccess() == 'yes') || ($this->account() == $client->getAccount()))) {
            $this->load->library('form_validation');
            $this->form_validation->set_rules('firstName', 'First Name', 'required');
            $this->form_validation->set_rules('lastName', 'Last Name', 'required');
//            $this->form_validation->set_rules('companyName', 'Company', 'required');
            //        $this->form_validation->set_rules('businessPhone', 'Business Phone', 'required');
            $this->form_validation->set_rules('email', 'Email', 'required');
//            $this->form_validation->set_rules('cellPhone', 'Cell Phone', 'required');
            $this->form_validation->set_rules('state', 'State', 'required');
            $this->form_validation->set_rules('address', 'Address', 'required');
            $this->form_validation->set_rules('city', 'City', 'required');
            $this->form_validation->set_rules('zip', 'Zip Code', 'required');
//            $this->form_validation->set_rules('country', 'Country', 'required');
            if ($this->form_validation->run()) {
 
                // If we don't have a selected CLientAccountID
                if (!$this->input->post('accountId')) {
 
                    // If no company name given, set it to residential account
                    if (!$this->input->post('accCompanyName')) {
                        $clientAccount = $this->account()->getCompany()->findResidentialAccount();
                    } else {
                        // Create New Account
                        $clientAccount = new \models\ClientCompany();
                        $clientAccount->setCreated(time());
                        $clientAccount->setName($this->input->post('accCompanyName'));
                        $clientAccount->setOwnerCompany($this->account()->getCompany());

                        $ownerAccount = $this->em->find('\models\Accounts', $this->input->post('owner'));
                        if ($ownerAccount) {
                            $clientAccount->setOwnerUser($ownerAccount);
                        } else {
                            $clientAccount->setOwnerUser($this->account());
                        }
                        $this->em->persist($clientAccount);
                        $this->em->flush();
                    }
                } else {
                    $clientAccount = $this->em->find('\models\ClientCompany', $this->input->post('accountId'));
                }

                
       


                $business_types = ($this->input->post('business_type'))?:[];
                
                $this->getCompanyRepository()->checkClearClientAssignedBusinessTypes($this->account()->getCompany(),$client->getClientId(),$business_types);

                if($this->input->post('apply_bt_on_contact')=='1'){
                    
                    if(count($business_types)>1){
                        $this->getProposalRepository()->updateClientBusinessTypeOnProposal($client->getClientId(),$this->input->post('apply_bt_on_proposal'));
                    }else{
                        $this->getProposalRepository()->updateClientBusinessTypeOnProposal($client->getClientId(),$business_types[0]);
                    }
               
                }
                
                $client->setFirstName($this->input->post('firstName'));
                $client->setLastName($this->input->post('lastName'));
                $client->setBusinessPhone($this->input->post('businessPhone'));
                $client->setBusinessPhoneExt($this->input->post('businessPhoneExt'));
                $client->setEmail($this->input->post('email'));
                $client->setCellPhone($this->input->post('cellPhone'));
                $client->setFax($this->input->post('fax'));
                $client->setAddress($this->input->post('address'));
                $client->setCity($this->input->post('city'));
                $client->setZip($this->input->post('zip'));
                $client->setBillingFirstName($this->input->post('billingFirstName'));
                $client->setBillingLastName($this->input->post('billingLastName'));
                $client->setBillingBusinessPhone($this->input->post('billingBusinessPhone'));
                $client->setBillingBusinessPhoneExt($this->input->post('billingBusinessPhoneExt'));
                $client->setBillingEmail($this->input->post('billingEmail'));
                $client->setBillingCellPhone($this->input->post('billingCellPhone'));
                $client->setBillingFax($this->input->post('billingFax'));
                $client->setBillingTitle($this->input->post('billingTitle'));
                $client->setBillingState($this->input->post('billingState'));
                $client->setBillingAddress($this->input->post('billingAddress'));
                $client->setBillingCity($this->input->post('billingCity'));
                $client->setBillingZip($this->input->post('billingZip'));
                $client->setCountry($this->input->post('country'));
                $client->setTitle($this->input->post('title'));
                $client->setWebsite($this->input->post('website'));
                $client->setState($this->input->post('state'));
                if (($this->input->post('owner')) && ($this->account()->isAdministrator())) {
                    $newOwner = $this->em->find('models\Accounts', $this->input->post('owner'));
                    $client->setAccount($newOwner);
                }
                
                $client->setCompany($this->account()->getCompany());
                $client->setClientAccount($clientAccount);
                //flag all proposals for rebuild
                $this->getClientRepository()->flagProposalsForRebuild($client->getClientId());

                $client->setLastActivity();
                // Only set the edit flag if the client has a QB ID

               // echo "<pre> client ";print_r($client);die;
                if ($client->getQBID()) {
                    $client->setQBSyncFlag(3);
                }
                $this->em->persist($client);
                $this->em->flush();
                $this->em->clear();


                
                //Delete user query Cache
                $this->getQueryCacheRepository()->deleteCompanyContactsAllCache($this->account()->getCompanyId());

                $this->log_manager->add(\models\ActivityAction::EDIT_CONTACT, 'Edited Contact ' . $client->getFullName() . ' of ' . $client->getClientAccount()->getName());
				
				///////For enqueue the client for Quickboos desktop : BY Sunil//////////;
				$this->db->select('quickbooks_queue_id')->from('quickbooks_queue')->where('qb_action','CustomerAdd')->where('ident',$client->getClientId())->where('qb_status','s');
			
			$query = $this->db->get();
			$user = md5($this->account()->getCompanyId());
			if ($query->num_rows() < 1){
                
				$this->quickbooks_model->enqueue(QUICKBOOKS_ADD_CUSTOMER, $client->getClientId(),0,'',$user);
             
            }else{
				$this->quickbooks_model->enqueue(QUICKBOOKS_MOD_CUSTOMER, $client->getClientId(),0,'',$user);
			}
				///////////////////////////////////////end: by sunil////////////////////
                $this->session->set_flashdata('success', 'Contact edited successfully!');
                redirect('clients/');
            }
            
            $data['client'] = $client;
            $data['account'] = $this->account();
            $data['company'] = $this->account()->getCompany();
            $data['assignedBusinessTypes'] = $this->getCompanyRepository()->getCompanyBusinessTypeAssignments($this->account()->getCompany(),'client',$client->getClientId(),true);
            $data['events'] = $this->getEventRepository()->getContactEvents($client->getClientId());
            $data['filterAccounts'] = $this->getAccountRepository()->getAllAccountsByPermission($this->account()->getAccountId(), true);
            $data['event_types'] = $this->getEventRepository()->getTypes($this->account()->getCompany()->getCompanyId());
            $data['businessTypes'] = $this->getCompanyRepository()->getCompanyBusinessTypes($this->account()->getCompany());
            $data['disableBusinessTypes'] = $this->getProposalRepository()->getClientBusinessTypeProposalArray($client->getClientId());
            
 
            $this->html->addScript('select2');
            $this->html->addScript('dataTables');
            $this->html->addScript('scheduler');
            $this->load->view('clients/edit', $data);
        } else {
            $this->session->set_flashdata('error', 'You do not have enough privileges to Edit the Contact!');
            redirect('clients');
        }
    }

    function delete()
    {
        $client = $this->em->find('models\Clients', $this->uri->segment(3));
       
        if (!$client) {
            $out = [];
            $out['success'] =false;

            echo json_encode($out);
        }
        //check access level
        if (($this->account()->getCompany() == $client->getCompany()) && (($this->account()->isAdministrator()) || ($this->account()->getFullAccess() == 'yes') || ($this->account() == $client->getAccount()))) {
            $this->log_manager->add(\models\ActivityAction::DELETE_CONTACT, 'Deleted Contact ' . $client->getFullName() . ' of ' . $client->getClientAccount()->getName());
            $client = $this->em->merge($client);

            $proposals = $client->getProposals();
            foreach ($proposals as $proposal) {
                /* @var \models\Proposals $proposal */
                $proposalImages = $proposal->getProposalImages();
                foreach ($proposalImages as $proposalImage) {
                    $this->em->remove($proposalImage);
                }
                $proposalAttachments = $proposal->getAttatchments();
                foreach ($proposalAttachments as $proposalAttachment) {
                    $this->em->remove($proposalAttachment);
                }
                $this->em->flush();
                $this->em->remove($proposal);
                $this->em->flush();
                $proposal->deleteProposalGroupResendEmails();
            }
            $this->getCompanyRepository()->clearClientAssignedBusinessTypes($this->account()->getCompany(),$client->getClientId());
            $client->deleteClientGroupResendEmails();
            $this->em->remove($client);
            //Delete user query Cache
            $this->getQueryCacheRepository()->deleteCompanyContactsAllCache($this->account()->getCompanyId());
            $this->em->flush();
            $out = [];
            $out['success'] =true;

            echo json_encode($out);
        }else{
            $out = [];
            $out['success'] =false;

            echo json_encode($out);
        }
    }

    function reassign()
    {
        $this->load->library('JsonResponse');
        $response = new JsonResponse();
        $fromClientId = $this->input->post('clientFrom');
        $toClientId = $this->input->post('clientTo');

        $fromClient = $this->em->find('\models\Clients', $fromClientId);
        /* @var \models\Clients $fromClient */
        $toClient = $this->em->find('\models\Clients', $toClientId);
        /* @var \models\Clients $toClient */

        if (!$fromClient || !$toClient) {
            $this->session->set_flashdata('error', 'There was a problem loading the contacts');
            redirect('clients');
        }

        if (($fromClient->getCompany()->getCompanyId() !== $this->account()->getCompany()->getCompanyId()) || ($toClient->getCompany()->getCompanyId() !== $this->account()->getCompany()->getCompanyId())) {
            $this->session->set_flashdata('error', 'You do not have permission to transfer to or from this contact');
            redirect('clients');
        }

        $this->db->query("UPDATE proposals SET client = " . $toClientId . " WHERE client = " . $fromClientId);


        $this->getClientRepository()->updateProposalCount($fromClientId);
        $this->getClientRepository()->updateProposalCount($toClientId);
        
        $this->log_manager->add(\models\ActivityAction::PROPOSAL_REASSIGN, 'Proposals Reassigned from <strong>' . $fromClient->getFullName() . '</strong> to <strong>' . $toClient->getFullName().'</strong>');
        // $this->session->set_flashdata('success', 'Proposals Reassigned from ' . $fromClient->getFullName() . ' to ' . $toClient->getFullName());
        // redirect('clients');
        $response->success = true;
        $response->msg = 'Proposals Reassigned from <strong>' . $fromClient->getFullName() . '</strong> to <strong>' . $toClient->getFullName().'</strong>';
        $response->send();
    }
	
	function syncPlToQb()
    {
		echo 'Navin';die;
	}

    public function group_resends()
    {   $data = [];
        $this->html->addScript('ckeditor4');
        $data['resends'] = $this->getClientRepository()->getCompanyClientResendList($this->account()->getCompany(),$this->account());
        
        
        $this->load->model('clientEmail');
        $data['clientTemplates'] = $this->clientEmail->getTemplates($this->account()->getCompany()->getCompanyId(), \models\ClientEmailTemplateType::CLIENT, true);
        $data['account'] = $this->account();
        $data['layout'] = 'clients/group_resends';
        $this->html->addScript('dataTables');
        $this->load->view('clients/group_resends', $data);
    }

    public function group_resends_data()
    {
        $company = $this->account()->getCompany();

        $tableData = [];
        $rowsData = [];
       // $itemsData = [];
        $itemsData = $this->getClientRepository()->getGroupResendData($company,false,$this->account());
        
        foreach ($itemsData as $dataRow) {
            $rowsData[] = $dataRow;
        }

        $tableData['sEcho'] = (int)$this->input->post('echo');
        $tableData['iTotalRecords'] = $this->getClientRepository()->getGroupResendData($company, true,$this->account());
        $tableData['iTotalDisplayRecords'] = $this->getClientRepository()->getGroupResendData($company, true,$this->account());
        $tableData['aaData'] = $rowsData;

        echo json_encode($tableData);
    }


    function resend()
    {
        // Auth checks
       
         $filter = $this->uri->segment(3);
        

        $this->session->set_userdata('pClientResendFilter', 1);


        $this->session->set_userdata('pClientResendFilterId', $filter);
    
       
        $this->index();
    }

    function check_add_contact(){
       
    $this->session->set_userdata('co_accCompanyName', $this->input->post('accCompanyName'));
    $this->session->set_userdata('co_firstName', $this->input->post('firstName'));
    $this->session->set_userdata('co_lastName', $this->input->post('lastName'));
    $this->session->set_userdata('co_email', $this->input->post('email'));
    $this->session->set_userdata('co_accountId', $this->input->post('accountId'));
   
    echo 1;
        //redirect('clients/add/');
    }

    function clientPreviewEditCheck(){
        $client = $this->em->find('models\Clients', $this->uri->segment(3));

        if (($this->account()->getCompany() == $client->getCompany()) && (($this->account()->isAdministrator()) || ($this->account()->getFullAccess() == 'yes') || ($this->account() == $client->getAccount()))) {
            redirect('clients/edit/'.$this->uri->segment(3));
        }else{
            $this->session->set_userdata('ClientSearchFilter', $this->uri->segment(3));
            redirect('clients');
        }
    }
}