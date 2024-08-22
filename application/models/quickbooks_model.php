<?php

class Quickbooks_model extends MY_Model
{

    /**
     * Set the DSN connection string for the queue class
     */
    public function dsn($dsn)
    {
        $this->_dsn = $dsn;
    }

    /**
     * Queue up a request for the Web Connector to process
     */
    public function enqueue($action, $ident, $priority = 0, $extra = null, $user = null)
    {
        //$user = md5($this->account()->getCompanyId());
        $Queue = new QuickBooks_WebConnector_Queue($this->_dsn);
        return $Queue->enqueue($action, $ident, $priority, $extra, $user);
    }

    function get_invoice_txnid()
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

    function update_invoice_response($TxnID, $ID, $action)
    {
        $this->db->where('qb_action', $action);
        $this->db->where('ident', $ID);
        $this->db->set('txn_id', $TxnID);
        $this->db->update('quickbooks_queue');
    }

    function get_txn_id_by_ident($id)
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

    function get_invoice_txn_id_by_ident($id)
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

    function get_list_id_by_client_id($client_id)
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

    function get_customer_list_id_by_ident($id)
    {
        $this->db->select('list_id,edit_seq');
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

    function get_service_list_id_by_ident($id)
    {
        $this->db->select('list_id,edit_seq');
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

    function update_invoice_result($appl_amm, $ID)
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

    public function update_add_service_result($ListID, $EditSequence, $ID)
    {
        $this->db->set('list_id', "$ListID");
        $this->db->set('edit_seq', "$EditSequence");
        $this->db->where('qb_action', 'ItemServiceAdd');
        $this->db->where('ident', $ID);
        $this->db->update('quickbooks_queue');

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

    public function get_service_list_for_queue($c_id)
    {

        $quser = $this->db->query("SELECT `serviceId` FROM services WHERE company ='$c_id' AND NOT EXISTS (SELECT quickbooks_queue_id FROM quickbooks_queue WHERE quickbooks_queue.ident = services.serviceId)");

        if ($quser->num_rows() > 0) {

            return $quser->result_array();
        } else {
            return false;
        }
    }

    public function add_setting_for_desktop($c_id)
    {
        $uname = md5($c_id);
        $data = array(
            'company_id' => $c_id,
            'username' => $uname,
            'qb_connection_type' => 'desktop'
        );

        $this->db->insert('quickbook_settings', $data);
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
}