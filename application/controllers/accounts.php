<?php

class Accounts extends MY_Controller
{
    function __construct()
    {
        $this->login_restricted = true;
        parent::__construct();
    }

    public function index()
    {
        $this->load->model('clientEmail');
        $this->load->model('branchesapi');

        $data = [];
        $data['account'] = $this->account();
        $data['accounts'] = $this->account()->getCompany()->getAccounts();
        $data['companies'] = $this->account()->getClientAccounts(true);
        $data['branches'] = $this->branchesapi->getBranches($this->account()->getCompany()->getCompanyId());
        $data['businessTypes'] = $this->getCompanyRepository()->getCompanyBusinessTypes($this->account()->getCompany());
        $data['save_filters'] = $this->getAccountRepository()->getAccountSavedFilters($this->account());
        $this->html->addScript('select2');
        $this->html->addScript('dataTables');
        $this->load->view('accounts/index', $data);
    }


    public function proposals($accountId)
    {

        $clientAccount = $this->em->find('\models\ClientCompany', $accountId);
        /* @var \models\ClientCompany $clientAccount */

        if ($clientAccount->getOwnerCompany()->getCompanyId() != $this->account()->getCompany()->getCompanyId()) {
            $this->session->set_flashdata('error', 'You do not have permission to view this account');
            redirect('accounts');
        }

        // Clear the filters and direct to proposals
        $this->session->set_userdata(array(
            'pFilter' => 1,
            'pFilterUser' => '',
            'pFilterBranch' => '',
            'pFilterStatus' => '',
            'pFilterService' => '',
            'pCreatedFrom' => strtotime($this->session->userdata('accFilterFrom')),
            'pCreatedTo' => strtotime('11:59:59 pm ' . $this->session->userdata('accFilterTo')),
            'pFilterQueue' => '',
            'pFilterEmailStatus' => '',
            'pFilterClientAccount' => [$accountId],
        ));

        redirect('proposals');
    }

    public function clients($accountId)
    {

        $clientAccount = $this->em->find('\models\ClientCompany', $accountId);
        /* @var \models\ClientCompany $clientAccount */

        if ($clientAccount->getOwnerCompany()->getCompanyId() != $this->account()->getCompany()->getCompanyId()) {
            $this->session->set_flashdata('error', 'You do not have permission to view this account');
            redirect('accounts');
        }

        // Clear the filters and direct to proposals
        $this->session->set_userdata(array(
            'cFilter' => 1,
            'cFilterUser' => '',
            'cFilterBranch' => '',
            'cFilterClientAccount' => [$accountId],
        ));

        redirect('clients');
    }

    public function add()
    {

        if ($this->input->post('add')) {

            $clientAccount = new \models\ClientCompany();
            $clientAccount->setCreated(time());
            $clientAccount->setName($this->input->post('companyName'));
            $clientAccount->setAddress($this->input->post('address'));
            $clientAccount->setCity($this->input->post('city'));
            $clientAccount->setState($this->input->post('state'));
            $clientAccount->setZip($this->input->post('zip'));
            $clientAccount->setWebsite($this->input->post('website'));
            $clientAccount->setPhone($this->input->post('businessPhone'));
            $clientAccount->setEmail($this->input->post('contactEmail'));
            $clientAccount->setOwnerCompany($this->account()->getCompany());

            $ownerAccount = $this->em->find('\models\Accounts', $this->input->post('account'));
            if ($ownerAccount) {
                $clientAccount->setOwnerUser($ownerAccount);
            } else {
                $clientAccount->setOwnerUser($this->account());
            }

            $this->em->persist($clientAccount);
            $this->em->flush();

            if ($clientAccount->getId()) {
                $this->log_manager->add(\models\ActivityAction::ADD_ACCOUNT, 'Added Account - ' . $clientAccount->getName());
                $this->session->set_flashdata('success', 'Account Added!');
            } else {
                $this->session->set_flashdata('error', 'There was a problem creating the account. Please try again');
            }

            redirect('accounts');
        } else {
            $data = [];
            $data['account'] = $this->account();
            $data['companyUsers'] = $this->account()->getCompany()->getAccounts();
            $this->load->view('accounts/add', $data);
        }
    }


    public function info($id)
    {
        $cAccount = $this->em->find('models\ClientCompany', $id);
        /* @var $cAccount \models\ClientCompany */

        if (!$cAccount) {
            $this->session->set_flashdata('error', 'There was a problem loading the account');
            redirect('accounts');
        }

        if ($cAccount->getOwnerUser()->getCompany()->getCompanyId() !== $this->account()->getCompany()->getCompanyId()) {
            $this->session->set_flashdata('error', 'You do not have permission to edit this account');
            redirect('accounts');
        }

        if ($this->account()->getUserClass() == 0) {
            if ($cAccount->getOwnerUser()->getAccountId() !== $this->account()->getAccountId()) {
                $this->session->set_flashdata('error', 'You do not have permission to edit this account');
                redirect('accounts');
            }
        }

        $data = [];
        $data['clientAccount'] = $cAccount;
        $this->load->model('branchesapi');
        $data['account'] = $this->account();
        $data['accounts'] = $this->account()->getCompany()->getAccounts();
        $data['companies'] = $this->account()->getClientAccounts(true);
        $data['branches'] = $this->branchesapi->getBranches($this->account()->getCompany()->getCompanyId());
        $time = [];
        $time['defaultStart'] = date('Y-m-d', mktime(0, 0, 0, 1, 1, date('Y')));
        $time['defaultFinish'] = date('Y-m-d');
        $time['start'] = $time['defaultStart'];
        $time['finish'] = $time['defaultFinish'];
        if ($this->session->userdata('accInfoFilterFrom')) {
            $time['start'] = $this->session->userdata('accInfoFilterFrom');
        }
        if ($this->session->userdata('accInfoFilterTo')) {
            $time['finish'] = $this->session->userdata('accInfoFilterTo');
        }
        $data['time'] = $time;

        $timelineStatuses = $this->account()->getCompany()->getStatuses();

        $date = new \DateTime();

        $under30Time = [];
        $date->modify('-30 days');
        $under30Time['start'] = $date->getTimestamp();
        $under30Time['finish'] = time();

        $thirtyToSixty = [];
        $date->modify('-30 days');
        $thirtyToSixty['finish'] = $under30Time['start'];
        $thirtyToSixty['start'] = $date->getTimestamp();

        $sixtyToNinety = [];
        $date->modify('-30 days');
        $sixtyToNinety['finish'] = $thirtyToSixty['start'];
        $sixtyToNinety['start'] = $date->getTimestamp();

        $overNinety = [];
        $date->modify('-30 days');
        $overNinety['finish'] = $sixtyToNinety['start'];
        $overNinety['start'] = 0;


        $statuses = [];
        foreach ($timelineStatuses as $status) {

            $under30val = $cAccount->timeRangeCreatedProposalsPrice($under30Time, $status->getStatusId());
            $thirtyToSixtyVal = $cAccount->timeRangeCreatedProposalsPrice($thirtyToSixty, $status->getStatusId());
            $sixtyToNinetyVal = $cAccount->timeRangeCreatedProposalsPrice($sixtyToNinety, $status->getStatusId());
            $overNinetyVal = $cAccount->timeRangeCreatedProposalsPrice($overNinety, $status->getStatusId());

            $statuses[$status->getStatusId()]['under30'] = [];
            $statuses[$status->getStatusId()]['under30']['value'] = $under30val ?: 0;
            $statuses[$status->getStatusId()]['under30']['readable'] = readableValue($under30val);
            $statuses[$status->getStatusId()]['30to60'] = [];
            $statuses[$status->getStatusId()]['30to60']['value'] = $thirtyToSixtyVal ?: 0;
            $statuses[$status->getStatusId()]['30to60']['readable'] = readableValue($thirtyToSixtyVal);
            $statuses[$status->getStatusId()]['60to90'] = [];
            $statuses[$status->getStatusId()]['60to90']['value'] = $sixtyToNinetyVal ?: 0;
            $statuses[$status->getStatusId()]['60to90']['readable'] = readableValue($sixtyToNinetyVal);
            $statuses[$status->getStatusId()]['over90'] = [];
            $statuses[$status->getStatusId()]['over90']['value'] = $overNinetyVal ?: 0;
            $statuses[$status->getStatusId()]['over90']['readable'] = readableValue($overNinetyVal);

        }

        $data['timelineStatuses'] = $timelineStatuses;
        $data['statusData'] = $statuses;
        $data['events'] = $this->getEventRepository()->getAccountEvents($cAccount->getId());
        $data['account'] = $this->account();
        $data['filterAccounts'] = $this->getAccountRepository()->getAllAccountsByPermission($this->account()->getAccountId(), true);

        $this->html->addScript('dataTables');
        $this->html->addScript('scheduler');
        $this->load->view('accounts/info', $data);
    }

    public function edit($id)
    {

        $cAccount = $this->em->find('models\ClientCompany', $id);
        
        /* @var $cAccount \models\ClientCompany */

           // Aovid to rename residentail name
           $disableAccountName=0;
           $getCompanyName =  $cAccount->getName();
           if(trim($getCompanyName)=="Residential")
           {
               $disableAccountName=1;
           } 
          // Aovid to rename residentail name

       
        if (!$cAccount) {
            $this->session->set_flashdata('error', 'There was a problem loading the account');
            redirect('accounts');
        }

        if ($cAccount->getOwnerUser()->getCompany()->getCompanyId() !== $this->account()->getCompany()->getCompanyId()) {
            $this->session->set_flashdata('error', 'You do not have permission to edit this account');
            redirect('accounts');
        }

        if ($this->account()->getUserClass() == 0) {
            if ($cAccount->getOwnerUser()->getAccountId() !== $this->account()->getAccountId()) {
                $this->session->set_flashdata('error', 'You do not have permission to edit this account');
                redirect('accounts');
            }
        }


        if ($this->input->post('companyName')) {
 
            //$this->getCompanyRepository()->clearAccountAssignedBusinessTypes($this->account()->getCompany(),$cAccount->getId());
            $cAccount = $cAccount;
            $cAccount->setCreated(time());
            if($disableAccountName==1)
            {
                $cAccount->setName("Residential");
            }else{
                $cAccount->setName($this->input->post('companyName'));
            }
            $cAccount->setAddress($this->input->post('address'));
            $cAccount->setCity($this->input->post('city'));
            $cAccount->setState($this->input->post('state'));
            $cAccount->setZip($this->input->post('zip'));
            $cAccount->setWebsite($this->input->post('website'));
            $cAccount->setPhone($this->input->post('businessPhone'));
            $cAccount->setEmail($this->input->post('contactEmail'));

            $ownerAccount = $this->em->find('\models\Accounts', $this->input->post('account'));
            if ($ownerAccount) {
                $cAccount->setOwnerUser($ownerAccount);
            }

           $this->em->persist($cAccount);
           $this->em->flush();
            $business_types = ($this->input->post('business_type'))?:[];
            if($this->input->post('apply_bt_on_contact')=='1'){
                $clients = $this->getClientRepository()->getAccountClients($cAccount->getId());
                
               foreach($clients as $client){
                    if(count($business_types)>1){
                        $this->getProposalRepository()->updateClientBusinessTypeOnProposal($client->clientId,$this->input->post('apply_bt_on_proposal'));
                    }else{
                        $this->getProposalRepository()->updateClientBusinessTypeOnProposal($client->clientId,$business_types[0]);
                    }
                    
                    // if just add new ones
                    // foreach ($business_types as $business_type) {
                    //     $this->getClientRepository()->checkClientBusinessTypeAssignment($client->clientId,$business_type,$this->account()->getCompany()->getCompanyId());
                        
                    // }
                    //if need to remove client business type
                    $this->getCompanyRepository()->checkclearClientAssignedBusinessTypes($this->account()->getCompany(),$client->clientId,$business_types);
               }
            }
            $this->getCompanyRepository()->checkClearAccountAssignedBusinessTypes($this->account()->getCompany(),$cAccount->getId(),$business_types);
            
            $this->log_manager->add(\models\ActivityAction::EDIT_ACCOUNT, 'Account Edited - ' . $cAccount->getName());
            $this->session->set_flashdata('success', 'Account Edited!');

            redirect('accounts');
        } else {
            $data = [];
            $data['account'] = $this->account();
            $data['cAccount'] = $cAccount;
            $data['disableAccountName'] = $disableAccountName;
            
            $data['assignedBusinessTypes'] = $this->getCompanyRepository()->getCompanyBusinessTypeAssignments($this->account()->getCompany(),'account',$cAccount->getId(),true);
            
            $data['companyUsers'] = $this->account()->getCompany()->getAccounts();
            $data['businessTypes'] = $this->getCompanyRepository()->getCompanyBusinessTypes($this->account()->getCompany());
            $data['disableBusinessTypes'] = $this->getProposalRepository()->getAccountBusinessTypeProposalArray($cAccount->getId());
            //print_r( $data['disableBusinessTypes']);die;
            $this->html->addScript('select2');
            $this->html->addScript('dataTables');
            $this->load->view('accounts/edit', $data);
        }
    }

    public function merge($id)
    {
        $cAccount = $this->em->find('models\ClientCompany', $id);
        /* @var $cAccount \models\ClientCompany */

        if (!$cAccount) {
            $this->session->set_flashdata('error', 'There was a problem loading the account');
            redirect('accounts');
        }

        if ($cAccount->getOwnerUser()->getCompany()->getCompanyId() !== $this->account()->getCompany()->getCompanyId()) {
            $this->session->set_flashdata('error', 'You do not have permission to delete this account');
            redirect('accounts');
        }

        $reassignId = $this->uri->segment(4);
        
        if ($reassignId) {

            $reassignAccount = $this->em->find('models\ClientCompany', $reassignId);

            if (!$reassignAccount) {
                $this->session->set_flashdata('error', 'There was a problem loading the account to merge into');
                redirect('accounts');
            }

            if ($reassignAccount->getOwnerUser()->getCompany()->getCompanyId() !== $this->account()->getCompany()->getCompanyId()) {
                $this->session->set_flashdata('error', 'You do not have permission merge into this account!');
                redirect('accounts');
            } else {
                
                //     $clients = $this->getClientRepository()->getAccountClients($id);
                //     $businessTypes = $this->getCompanyRepository()->getCompanyBusinessTypeAssignments($this->account()->getCompany(),'account',$reassignId,true);
                //    foreach($clients as $client){
                   
                //        foreach ($businessTypes as $business_type) {
                //            $this->getClientRepository()->checkClientBusinessTypeAssignment($client->clientId,$business_type,$this->account()->getCompany()->getCompanyId());
                           
                //        }
                //    }
                //     $this->em->flush();

                    $this->getCompanyRepository()->checkAccountClientAssignedBusinessTypes($this->account()->getCompany(),$reassignId,$id);
               
               
                // Reassign
                $this->db->query("UPDATE clients SET client_account = " . $reassignId . " WHERE client_account = " . $id);
                $this->em->remove($cAccount);
                $this->em->flush();

                
                $this->log_manager->add(\models\ActivityAction::ACCOUNT_MERGED, 'Account ' . $cAccount->getName() . ' merged into ' . $reassignAccount->getName());
                $this->session->set_flashdata('success', 'Accounts Merged!');
                
                redirect('accounts');
            }
        }

        $this->session->set_flashdata('error', 'There was a problem with your merge request');
        redirect('accounts');
    }


    public function delete($id)
    {

        $cAccount = $this->em->find('models\ClientCompany', $id);
        /* @var $cAccount \models\ClientCompany */

        if (!$cAccount) {
            $this->session->set_flashdata('error', 'There was a problem loading the account');
            redirect('accounts');
        }

        if ($cAccount->getOwnerUser()->getCompany()->getCompanyId() !== $this->account()->getCompany()->getCompanyId()) {
            $this->session->set_flashdata('error', 'You do not have permission to delete this account');
            redirect('accounts');
        }

        foreach ($cAccount->getContacts() as $client) {

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
            }
            $this->em->remove($client);
            $this->em->flush();

        }
        $this->getCompanyRepository()->clearAccountAssignedBusinessTypes($this->account()->getCompany(),$cAccount->getId());

        $this->em->remove($cAccount);
        $this->em->flush();

        $this->log_manager->add(\models\ActivityAction::DELETE_ACCOUNT, 'Account Deleted - ' . $cAccount->getName());
        $this->session->set_flashdata('success', 'Account Deleted!');
        redirect('accounts');
    }

    public function timeline($cAccountId, $statusId, $range)
    {
        $status = $this->em->findStatus($statusId);
        \models\Proposals::resetProposalFilter();

        $date = new \DateTime();

        switch ($range) {

            case 'under30':
                $finish = $date->format('m/d/Y');
                $date->modify('-30days');
                $start = $date->format(('m/d/Y'));
                break;

            case '30to60':
                $date->modify('-30days');
                $finish = $date->format('m/d/Y');
                $date->modify('-30days');
                $start = $date->format(('m/d/Y'));
                break;

            case '60to90':
                $date->modify('-60days');
                $finish = $date->format('m/d/Y');
                $date->modify('-30days');
                $start = $date->format(('m/d/Y'));
                break;

            case 'over90':
                $date->modify('-90days');
                $finish = $date->format('m/d/Y');
                $start = '1/1/2012';
                break;
        }

        $this->session->set_userdata([
            'pFilter' => 1,
            'pFilterClientAccount' => $cAccountId,
            'pFilterStatus' => $statusId,
            'pFilterStatusName' => $status->getText(),
            'pFilterFrom' => $start,
            'pFilterTo' => $finish,
        ]);

        redirect('proposals');

    }

}
