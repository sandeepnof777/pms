<?php
namespace Pms\Repositories;

use Carbon\Carbon;
use models\CompanyQbService;
use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;
use \models\QuickbooksSettings;
use \models\Companies;
use QuickBooksOnline\API\DataService\DataService;
use QuickBooksOnline\API\Facades\Item;
use QuickBooksOnline\API\Facades\Customer;
use QuickBooksOnline\API\Facades\Invoice;

class QuickbooksDesktop extends RepositoryAbstract
{
    use DBTrait;

    var $dsn;

    function __construct()
    {
        parent::__construct();
        $this->setDsn();
    }

    private function setDsn()
    {
        $this->dsn = 'mysqli://' . $this->db->username . ':' . $this->db->password . '@' . $this->db->hostname . '/' . $this->db->database;
    }


    /**
     * Queue up a request for the Web Connector to process
     */
    public function enqueue($action, $ident, $priority = 0, $extra = null, $user = null)
    {
        //$user = md5($this->account()->getCompanyId());
        $Queue = new \QuickBooks_WebConnector_Queue($this->dsn);
        return $Queue->enqueue($action, $ident, $priority, $extra, $user);
    }

    public function get_invoice_txnid()
    {
        $this->db->select('q.ident');
        $this->db->from('quickbooks_queue as q');
        $this->db->join('proposals as p', 'p.proposalID = q.ident');
        $this->db->where('q.qb_action', 'InvoiceAdd');
        $this->db->where('q.qb_status', 's');
        $this->db->where('q.txn_id !=', '');
        $this->db->where("(p.invoice_status IS NULL OR p.invoice_status != 'paid')");
        $query = $this->db->get();
        return $query->result_array();
    }

    public function update_invoice_response($TxnID, $ID, $action)
    {
        $this->db->where('qb_action', $action);
        $this->db->where('ident', $ID);
        $this->db->set('txn_id', $TxnID);
        $this->db->update('quickbooks_queue');
    }

    public function get_txn_id_by_ident($id)
    {
        $this->db->select('txn_id');
        $this->db->from('quickbooks_queue');
        $this->db->where('qb_action', 'InvoiceAdd');
        $this->db->where('qb_status', 's');
        $this->db->where('ident', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $ids) {
                return $ids['txn_id'];
            }
        }
    }

    public function get_invoice_txn_id_by_ident($id)
    {
        $this->db->select('txn_id,edit_seq');
        $this->db->from('quickbooks_queue');
        $this->db->where('qb_action', 'InvoiceAdd');
        $this->db->where('qb_status', 's');
        $this->db->where('ident', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $ids) {
                return $ids;
            }
        }
    }

    public function get_list_id_by_client_id($client_id)
    {
        $this->db->select('list_id');
        $this->db->from('quickbooks_queue');
        $this->db->where('qb_action', 'CustomerAdd');
        $this->db->where('qb_status', 's');
        $this->db->where('ident', $client_id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $ids) {
                return $ids['list_id'];
            }
        }
    }

    public function get_customer_list_id_by_ident($id)
    {
        $this->db->select('list_id,edit_seq,extra');
        $this->db->from('quickbooks_queue');
        $this->db->where('qb_action', 'CustomerAdd');
        $this->db->where('qb_status', 's');
        $this->db->where('ident', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $data) {
                return $data;
            }
        }
    }

    public function get_service_list_id_by_ident($id)
    {
        $this->db->select('list_id,edit_seq,extra');
        $this->db->from('quickbooks_queue');
        $this->db->where('qb_action', 'ItemServiceAdd');
        $this->db->where('qb_status', 's');
        $this->db->where('ident', $id);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $data) {
                return $data;
            }
        }
    }

    public function update_invoice_result($appl_amm, $ID)
    {
        $this->db->select('invoice_amount,invoice_status,price');
        $this->db->from('proposals');
        $this->db->where('proposalID', $ID);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $data = $query->result_array();
            $price = $data[0]['price'];
            //$appl_amm = $data[0]['invoice_amount'] > 0 ? $data[0]['invoice_amount'] + $appl_amm  : $appl_amm ;
            $status = $price <= $appl_amm ? 'paid' : 'PartialPaid';
            if ($data[0]['invoice_status'] == 'PartialPaid') {
                $this->db->where('proposalID', $ID);
                $this->db->set('invoice_amount', 'invoice_amount+' . $appl_amm, false);
                $this->db->set('invoice_status', $status);
                $this->db->update('proposals');


            } else {
                $this->db->where('proposalID', $ID);
                $this->db->set('invoice_amount', $appl_amm);
                $this->db->set('invoice_status', $status);
                $this->db->update('proposals');
            }
        }
    }


    public function update_add_contact_result($ListID, $EditSequence, $ID)
    {
        $this->db->set('list_id', "$ListID");
        $this->db->set('edit_seq', "$EditSequence");
        $this->db->where('qb_action', 'CustomerAdd');
        $this->db->where('ident', $ID);
        $this->db->update('quickbooks_queue');

        $client =  $this->em->findClient($ID);
        if($client){
            $client->setQbListId($ListID);
            $this->em->persist($client);
            $this->em->flush();
        }
        
    }

    public function update_mod_contact_result($ListID, $EditSequence, $ID)
    {
        $this->db->where('qb_action', 'CustomerAdd');
        $this->db->where('ident', $ID);
        $this->db->where('list_id', "$ListID");
        $this->db->set('edit_seq', "$EditSequence");
        $this->db->update('quickbooks_queue');
    }

    public function update_mod_service_result($ListID, $EditSequence, $ID)
    {
        $this->db->where('qb_action', 'ItemServiceAdd');
        $this->db->where('ident', $ID);
        $this->db->where('list_id', "$ListID");
        $this->db->set('edit_seq', "$EditSequence");
        $this->db->update('quickbooks_queue');
    }

    public function update_add_service_result($ListID, $EditSequence, $ID,$user)
    {
        $this->db->set('list_id', "$ListID");
        $this->db->set('edit_seq', "$EditSequence");
        $this->db->where('qb_action', 'ItemServiceAdd');
        $this->db->where('ident', $ID);
        $this->db->update('quickbooks_queue');

        $company_id = $this->get_company_id_by_username($user);
        if($company_id){
        
            $CompanyQbService = $this->em->getRepository('models\CompanyQbService')->findOneBy(array(
                'service_id' => $ID,
                'company_id' => $company_id
                
            ));
            if($CompanyQbService){
                $CompanyQbService->setQbListId($ListID);
                $this->em->persist($CompanyQbService);
                $this->em->flush();
            }
        }
        

    }

    public function add_contact_in_queue($ListID, $EditSequence, $ID)
    {
        $this->db->set('list_id', "$ListID");
        $this->db->set('edit_seq', "$EditSequence");
        $this->db->set('qb_status', "s");
        $this->db->where('qb_action', 'CustomerAdd');
        $this->db->where('ident', $ID);
        $this->db->update('quickbooks_queue');
    }

    public function update_add_invoice_result($txnID, $EditSequence, $ID)
    {
        $this->db->set('txn_id', "$txnID");
        $this->db->set('edit_seq', "$EditSequence");
        $this->db->where('qb_action', 'InvoiceAdd');
        $this->db->where('ident', $ID);
        $this->db->update('quickbooks_queue');
    }

    public function update_mod_invoice_result($EditSequence, $ID)
    {
        $this->db->set('edit_seq', "$EditSequence");
        $this->db->where('qb_action', 'InvoiceAdd');
        $this->db->where('ident', $ID);
        $this->db->update('quickbooks_queue');
    }

    public function get_service_list_for_queue($companyId)
    {
        $company = $this->em->findCompany($companyId);
        return $company->getQbdServiceList();
    }

    public function remove_quickbooks_user($qbUserName)
    {
        $this->db->where('qb_username', $qbUserName);
        $this->db->delete('quickbooks_user');
    }

    public function remove_quickbooks_setting($companyId)
    {
        $this->db->where('company_id', $companyId);
        $this->db->delete('quickbook_settings');
    }

    public function add_setting_for_desktop($c_id)
    {
        // Remove any old setting
        $this->remove_quickbooks_setting($c_id);

        $qbs = new QuickbooksSettings();
        $qbs->setCompanyId($c_id);
        $qbs->setUsername(md5($c_id));
        $qbs->setQbConnectionType('desktop');
        $this->em->persist($qbs);
        $this->em->flush();

        $company = $this->em->findCompany($c_id);
        $company->setQbSettingId($qbs->getId());
        $this->em->persist($company);
        $this->em->flush();
    }

    public function add_accounts($data)
    {
        $this->db->insert('quickbook_accounts', $data);
    }

    public function get_income_account_for_service($c_name)
    {
        
        $this->db->select('qbd_income_account_name')->from('quickbook_settings')->where('username', $c_name);
        $query = $this->db->get();
        $data = $query->result_array();

        $qbd_income_account_name = $data[0]['qbd_income_account_name'];
        if ($qbd_income_account_name) {
            return $qbd_income_account_name;
        } else {
            return '';
        }
    }



    function migrate_company_qb_service($service,$user){

        $company_id = $this->get_company_id_by_username($user);
       
        if($company_id){
            
            $existing = $this->getQuickbooksRepository()->getCompanyQbService($company_id, $service->getServiceId());
            
            if (!$existing) {

                /* @var $service \models\Services */
                $cqs = new \models\CompanyQbService();
                $cqs->setCompanyId($company_id);
                $cqs->setServiceId($service->getServiceId());
                $cqs->setTitle($service->getTitle($company_id) ?: ' Service ' . $service->getServiceId());
                $this->em->persist($cqs);
                $this->em->flush();
            }
            
        }
    }
    function update_error_result($errnum, $errmsg, $ID){
       
        $this->db->set('list_id', "$errnum");
        $this->db->set('msg', "$errmsg");
        $this->db->where('qb_action', 'ItemServiceAdd');
        $this->db->where('ident', $ID);
        $this->db->update('quickbooks_queue');

    }

    public function get_company_id_by_username($user)
    {
        $this->db->select('company_id');
        $this->db->from('quickbook_settings');
        $this->db->where('username', $user);
        
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $ids) {
                return $ids['company_id'];
            }
        }else{
            return false;
        }

    }

}