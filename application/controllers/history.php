<?php

class History extends MY_Controller {
    function __construct() {
        $this->login_restricted = true;
        parent::__construct();
    }

    function index() {
        $data = array();

        $historyUser = $this->em->find('models\Accounts', $this->uri->segment(3));
        $this->html->addScript('dataTables');
        $this->html->addScript('proposalTracking');
        $startY = date('Y', $this->account()->getCompany()->getCreated(true));
        $data['startY'] = $startY;
        $data['account'] = $this->account();
        $data['user'] = $historyUser;

        //Action Types
        $q = 'SELECT aa FROM models\ActivityAction aa where aa.parent_id=0 order by aa.activity_action_name asc';
        
        $query = $this->em->createQuery($q);
        $actionTypes = $query->getResult();

        $data['actionTypes'] = $actionTypes;

        $q = 'SELECT aa FROM models\ActivityAction aa where aa.parent_id!=0 order by aa.activity_action_name asc';
        
        $query = $this->em->createQuery($q);
        $actions = $query->getResult();
        $data['actions'] = $actions;
        $this->load->view('history/index', $data);
    }

    function user() {
        $this->index();
    }

    function super_user(){

        $data = array();

        $historyUser = $this->em->find('models\Accounts', $this->uri->segment(3));
        $this->html->addScript('dataTables');
        $this->html->addScript('proposalTracking');
        $startY = date('Y', $this->account()->getCompany()->getCreated(true));
        $data['startY'] = $startY;
        $data['account'] = $this->account();
        $data['user'] = $historyUser;

        //Action Types
        $q = 'SELECT aa FROM models\ActivityAction aa where aa.parent_id=0 order by aa.activity_action_name asc';
        
        $query = $this->em->createQuery($q);
        $actionTypes = $query->getResult();

        $data['actionTypes'] = $actionTypes;

        $q = 'SELECT aa FROM models\ActivityAction aa where aa.parent_id!=0 order by aa.activity_action_name asc';
        
        $query = $this->em->createQuery($q);
        $actions = $query->getResult();
        $data['actions'] = $actions;
        $this->load->view('history/super_user', $data);

    }

    function download() {
        $historyUser = NULL;
        $start = mktime(0, 0, 0, 1, 1, $this->uri->segment(3));
        $end = mktime(23, 59, 59, 12, 31, $this->uri->segment(3));
        /*  and (l.timeAdded > ' . $start . ') and (l.timeAdded < ' . $end . ') */
        if ($this->account()->isAdministrator()) {
            $q = 'SELECT l FROM models\Log l where (l.company=' . $this->account()->getCompany()->getCompanyId() . ') and (l.timeAdded > ' . $start . ') and (l.timeAdded < ' . $end . ')  order by l.timeAdded desc';
            if ($this->uri->segment(4)) {
                $historyUser = $this->em->find('models\Accounts', $this->uri->segment(4));
                if ($historyUser) {
                    $q = 'SELECT l FROM models\Log l where (l.company=' . $this->account()->getCompany()->getCompanyId() . ') and (l.account=' . $this->uri->segment(4) . ') and (l.timeAdded > ' . $start . ') and (l.timeAdded < ' . $end . ')  order by l.timeAdded desc';
                }
            }
        } else {
            $q = 'SELECT l FROM models\Log l where (l.company=' . $this->account()->getCompany()->getCompanyId() . ') and (l.account=' . $this->account()->getAccountId() . ') and (l.timeAdded > ' . $start . ') and (l.timeAdded < ' . $end . ')  order by l.timeAdded desc';
        }
        $query = $this->em->createQuery($q);
        $logs = $query->getResult();
        $exportLogs = array();
        $exportLogs[] = array(
            'Date',
            'User',
            'IP Address',
            'Contact',
            'Proposal',
            'Details',
        );
        foreach ($logs as $log) {
            try {
                $acc = ($log->getAccount()) ? $log->getAccount()->getFullName() : 'No User';
            } catch (Exception $e) {
                $acc = 'User Deleted';
            }

            try {
                $client = ($log->getClient()) ? $log->getClient()->getCompanyName() : 'None';
            } catch (Exception $e) {
                $client = 'Contact Deleted';
            }

            try {
                $proposal = ($log->getProposal()) ? $log->getProposal()->getProjectName() : 'None';
            } catch (Exception $e) {
                $proposal = 'Proposal Deleted';
            }
            $exportLogs[] = array(
                date('m/d/Y h:i:s A', $log->getTimeAdded() + TIMEZONE_OFFSET),
                $acc,
                $log->getIp(),
                $client,
                $proposal,
                $log->getDetails()
            );
        }
        export($exportLogs, 'csv', 'historyExport-' . $this->uri->segment(3) . '-' . $this->account()->getCompany()->getCompanyId() . '.csv');
    }
}
