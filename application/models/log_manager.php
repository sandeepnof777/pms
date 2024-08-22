<?php

class Log_manager extends CI_Model {
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    var $em;

    function __construct() {
        parent::__construct();
        $this->accountData = NULL;
        $this->em = $this->doctrine->em;
    }

    protected function account($refresh = FALSE) {
        if (($this->accountData === NULL) || $refresh) {
            $this->accountData = $this->em->find('models\Accounts', $this->session->userdata('accountId'));
            if ($this->session->userdata('sublogin')) {
                $sublogin_account = $this->em->find('models\Accounts', $this->session->userdata('sublogin'));
                if ($sublogin_account) {
                    $this->accountData = $sublogin_account;
                }
            }
        }
        return $this->accountData;
    }

    function add($action = '', $details = '', $client = NULL, $proposal = NULL, $company = NULL, $acc = NULL, $statusFrom = NULL, $statusTo = NULL, $ipOverride = NULL) {
        $log = new models\Log();
        $log->setAction($action);
        $log->setDetails($details);
        $account = $this->account();
        $log->setAccount($account);
        $userName = ($account) ? $account->getFirstName() . ' ' . $account->getLastName() : NULL;
        $cmp = 'NULL';
        if ($account) {
            $log->setCompany($account->getCompany());
            $cmp = $account->getCompany()->getCompanyId();
        } elseif ($proposal) {
            $log->setCompany($proposal->getClient()->getCompany());
            $cmp = $proposal->getClient()->getCompany()->getCompanyId();
        } else {
            $log->setCompany(NULL); //debug stuff
            $cmp = 'NULL';
        }
        if ($client) {
            $log->setClient($client);
        }
        if ($proposal) {
            $log->setProposal($proposal);
        }
        //
//        $this->load->library('doctrine');
//        $this->em->persist($log);
//        $this->em->flush();
        $this->load->database();
        $c = 'NULL';
        if ($client) {
            $c = $client->getClientId();
        }
        if (!$this->account()) {
            $a = 'NULL';
        } else {
            $a = $this->account()->getAccountId();
        }
        if ($a == 'NULL' && $acc) {
            $a = $acc;
        }
        $p = 'NULL';
        if ($proposal) {
            $p = $proposal->getProposalId();
        }

        $statusFromId = 'NULL';
        if($statusFrom){
            $statusFromId = $statusFrom;
        }

        $statusToId = 'NULL';
        if($statusTo){
            $statusToId = $statusTo;
        }

        if (!$ipOverride) {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        else {
            $ip = $ipOverride;
        }

        $details = $this->db->escape($details);
        $userName = $this->db->escape($userName);
        $this->db->query("insert into log values(NULL," . $a . "," . $cmp . "," . $c . "," . $p . ",'" . $ip . "'," . time() . ",'{$action}'," . $details . "," . $userName . ", " . $statusFromId . ", " . $statusToId . ")");
    }

    function add_external($action = '', $details = '', $client = 'NULL', $proposal = 'NULL', $company = 'NULL', $account = 'NULL', $statusFrom=NULL, $statusTo=NULL) {
        $this->load->database();
        $userName = NULL;
        if ($account) {
            try {
                if (is_object($account))
                    $userName = ($account && ($account instanceof models\Accounts)) ? $account->getFirstName() . ' ' . $account->getLastName() : NULL;
            } catch (Exception $e) {

            }
        }
        $accountId = (is_object($account)) ? $account->getAccountId() : $account;

        $statusFromId = NULL;
        if($statusFrom){
            $statusFromId = $statusFrom;
        }

        $statusToId = NULL;
        if($statusTo){
            $statusToId = $statusTo;
        }

        $this->db->query("insert into log values(NULL," . $accountId . "," . $company . "," . $client . "," . $proposal . ",'" . $_SERVER['REMOTE_ADDR'] . "'," . time() . ",'{$action}','{$details}','{$userName}', '{$statusFromId}', '{$statusToId}')");
    }
}