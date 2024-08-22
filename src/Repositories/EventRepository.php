<?php
namespace Pms\Repositories;


use Pms\RepositoryAbstract;
use models\Accounts;
use models\ProposalEvent;
use models\ProposalEventType;
use models\Proposals;
use models\EmailContent;
use Pms\Traits\CITrait;
use Pms\Traits\DBTrait;

class EventRepository extends RepositoryAbstract
{
    use DBTrait;
    use CITrait;

    
    // Log the create event
        Public function createProposal(Proposals $proposal, Accounts $account)
        {
            $this->createEvent(
                date("Y-m-d H:i:s"),
                $account->getAccountId(),
                $account->getFullName(),
                ProposalEventType::CREATE_PROPOSAL,
                'Proposal Created',
                $proposal->getProposalId());
        }

        Public function sendProposalIndividual(Proposals $proposal, Accounts $account)
        {
            $this->createEvent(
                date("Y-m-d H:i:s"),
                $account->getAccountId(),
                $account->getFullName(),
                ProposalEventType::SEND_INDIVIDUAL,
                'Proposal Send Individual',
                $proposal->getProposalId());
        }

        Public function sendProposalCampaign(Proposals $proposal, Accounts $account)
        {
            $this->createEvent(
                date("Y-m-d H:i:s"),
                $account->getAccountId(),
                $account->getFullName(),
                ProposalEventType::SEND_CAMPAIGN,
                'Proposal Send Campaign',
                $proposal->getProposalId());
        }

        Public function ProposalView(Proposals $proposal, Accounts $account)
        {
            $this->createEvent(
                date("Y-m-d H:i:s"),
                $account->getAccountId(),
                $account->getFullName(),
                ProposalEventType::PROPOSAL_VIEW,
                'Proposal View',
                $proposal->getProposalId());
        }

        Public function changeProposalStatus(Proposals $proposal, Accounts $account,$from,$to)
        {
            $this->createEvent(
                date("Y-m-d H:i:s"),
                $account->getAccountId(),
                $account->getFullName(),
                ProposalEventType::STATUS_CHANGE,
                'Proposal Status Changed From '.$from.' to '.$to,
                $proposal->getProposalId());
        }

        Public function changeProposalCreated(Proposals $proposal, Accounts $account,$from,$to)
        {
            $this->createEvent(
                date("Y-m-d H:i:s"),
                $account->getAccountId(),
                $account->getFullName(),
                ProposalEventType::DATE_CHANGE,
                'Proposal Date Changed From '. date("m/d/Y",$from).' to '. date("m/d/Y",$to),
                $proposal->getProposalId());
        }

        Public function leadCreated(Proposals $proposal, Accounts $account,$lead_created)
        {
            $this->createEvent(
                date("Y-m-d H:i:s",$lead_created),
                $account->getAccountId(),
                $account->getFullName(),
                ProposalEventType::LEAD_CREATED,
                'Lead was Created',
                $proposal->getProposalId());
        }

        Public function leadConvertToProposal(Proposals $proposal, Accounts $account,$lead_created)
        {

            $now = time(); 
            $datediff = $now - $lead_created;

            $days =  round($datediff / (60 * 60 * 24));

            $this->createEvent(
                date("Y-m-d H:i:s"),
                $account->getAccountId(),
                $account->getFullName(),
                ProposalEventType::LEAD_CONVERT,
                'Lead converted to Proposal. Conversion time: '.$days.' Days' ,
                $proposal->getProposalId());
        }

        

        Public function startEstimation(Proposals $proposal, Accounts $account)
        {
            $this->createEvent(
                date("Y-m-d H:i:s"),
                $account->getAccountId(),
                $account->getFullName(),
                ProposalEventType::ESTIMATION_START,
                'Proposal Estimation Started',
                $proposal->getProposalId());
        }

        Public function completeEstimation(Proposals $proposal, Accounts $account)
        {
            $this->createEvent(
                date("Y-m-d H:i:s"),
                $account->getAccountId(),
                $account->getFullName(),
                ProposalEventType::ESTIMATION_COMPLETED,
                'Proposal Estimation Completed',
                $proposal->getProposalId());
        }
        
        Public function jobCostingStart(Proposals $proposal, Accounts $account)
        {
            $this->createEvent(
                date("Y-m-d H:i:s"),
                $account->getAccountId(),
                $account->getFullName(),
                ProposalEventType::JOB_COSTING_START,
                'Proposal Job Costing Started',
                $proposal->getProposalId());
        }

        Public function jobCostingComplete(Proposals $proposal, Accounts $account)
        {
            $this->createEvent(
                date("Y-m-d H:i:s"),
                $account->getAccountId(),
                $account->getFullName(),
                ProposalEventType::JOB_COSTING_COMPLETED,
                'Proposal Job Costing Completed',
                $proposal->getProposalId());
        }

        Public function proposalsSetSold(Proposals $proposal, Accounts $account)
        {
            $this->createEvent(
                date("Y-m-d H:i:s"),
                $account->getAccountId(),
                $account->getFullName(),
                ProposalEventType::PROPOSAL_SOLD,
                'Proposal Set to Sold',
                $proposal->getProposalId());
        }

        //////////////

        Public function proposalsDuplicateTo(Proposals $proposal, Accounts $account,$log_string)
        {
            $this->createEvent(
                date("Y-m-d H:i:s"),
                $account->getAccountId(),
                $account->getFullName(),
                ProposalEventType::PROPOSAL_DUPLICATE_TO,
                $log_string,
                $proposal->getProposalId());
        }

        Public function proposalsDuplicateFrom(Proposals $proposal, Accounts $account,$log_string)
        {
            $this->createEvent(
                date("Y-m-d H:i:s"),
                $account->getAccountId(),
                $account->getFullName(),
                ProposalEventType::PROPOSAL_DUPLICATE_FROM,
                $log_string,
                $proposal->getProposalId());
        }
        
        Public function proposalEmailExcluded(Proposals $proposal, Accounts $account)
        {
            $this->createEvent(
                date("Y-m-d H:i:s"),
                $account->getAccountId(),
                $account->getFullName(),
                ProposalEventType::PROPOSAL_EMAIL_EXCLUDED,
                'Proposal Excluded From Email Campaigns',
                $proposal->getProposalId());
        }

        Public function proposalEmailIncluded(Proposals $proposal, Accounts $account)
        {
            $this->createEvent(
                date("Y-m-d H:i:s"),
                $account->getAccountId(),
                $account->getFullName(),
                ProposalEventType::PROPOSAL_EMAIL_INCLUDED,
                'Proposal Included In Email Campaigns',
                $proposal->getProposalId());
        }

        

        Public function createEvent($create_at,$account_id,$user_name,$event_type_id,$event_text,$proposal_id)
        {
           
            $proposalEvent = new ProposalEvent();
            $proposalEvent->setCreatedAt($create_at);
            $proposalEvent->setAccountId($account_id);
            $proposalEvent->setProposalId($proposal_id);
            $proposalEvent->setUserName($user_name);
            $proposalEvent->setTypeId($event_type_id);
            $proposalEvent->setEventText($event_text);
            $this->em->persist($proposalEvent);
            $this->em->flush();
        }

        Public function createEmailEvent($entity_type,$entity_id,$account,$email_to,$email_content,$email_subject='',$email_type='',$from_name='',$from_email='')
        {

            $create_at =date("Y-m-d H:i:s");
            $log_string ='';
            $account_id = $account->getAccountId();
            $account_name = $account->getFullName();
            $account_email = $account->getEmail();
            $Event = new ProposalEvent();
            $Event->setCreatedAt($create_at);
            $Event->setAccountId($account_id);
            if($entity_type == 'Proposal'){
                $event_type_id = ProposalEventType::PROPOSAL_SEND_INDIVIDUAL;
                $Event->setProposalId($entity_id);
                $proposal = $this->em->findProposal($entity_id);
                $Event->setClientId($proposal->getClient()->getClientId());
                
                $log_string ='Proposal Email Sent';
            }else if($entity_type == 'Client'){
                $event_type_id = ProposalEventType::CLIENT_SEND_INDIVIDUAL;
                $Event->setClientId($entity_id);
                $log_string ='Client Email Sent';
            }else if($entity_type == 'Lead'){
                $event_type_id = ProposalEventType::LEAD_SEND_INDIVIDUAL;
                $Event->setLeadId($entity_id);
                $log_string ='Lead Email Sent';
            }else if($entity_type == 'Prospect'){
                $event_type_id = ProposalEventType::PROSPECT_SEND_INDIVIDUAL;
                $Event->setProspectId($entity_id);
                $log_string ='Prospect Email Sent';
            }
            
            $Event->setUserName($account_name);
            $Event->setTypeId($event_type_id);
            $Event->setEventText($log_string);
            $Event->setEventEmailType($email_type);
            $this->em->persist($Event);
            $this->em->flush();
           
            $emailEvent = new EmailContent();

            $from_name = $from_name?:$account_name;
            $from_name = str_replace('via '. SITE_NAME,'',$from_name);
            $from_email = $from_email?:$account_email;
            //$emailEvent->setCreatedAt($create_at);
            $emailEvent->setEventId($Event->getId());
            $emailEvent->setEntity($entity_type);
            $emailEvent->setEntityId($entity_id);
            $emailEvent->setEmailContent($email_content);
            $emailEvent->setEmailSubject($email_subject);
            $emailEvent->setToEmail($email_to);
            $emailEvent->setSenderName($from_name);
            $emailEvent->setSenderEmail($from_email);
            
            $this->em->persist($emailEvent);
            $this->em->flush();

            return $Event->getId();
        }



        function getEmailEventEmailContent($event_id){
            
            $sql = "SELECT ec.email_content,ec.email_subject,ec.sender_name,ec.to_email
            FROM email_content ec 
            WHERE ec.event_id = " . $event_id ;
    
            return $this->getSingleResult($sql);
        }

        public function getProposalEmailEvents($proposal_id,$count = false,$email_type='',$total = false)
        {
            
            $CI =& get_instance();
            $CI->load->library('session');
            $sql = "SELECT pe.*,ec.email_subject,ec.sender_name,ec.to_email,eet.type_name,eet.type_code,eet.color_code
            FROM proposal_events pe 
            left join email_content ec on pe.id = ec.event_id
            left join event_email_types eet on pe.event_email_type = eet.id
            WHERE pe.proposal_id = " . $proposal_id ." AND pe.type_id = ".ProposalEventType::PROPOSAL_SEND_INDIVIDUAL."";
 
            // if(($email_type && $count && $total) ||($email_type && !$count)){


            //     $email_type = implode(',',$email_type);
                
            //     $sql .=" AND pe.event_email_type IN(".$email_type.") ";
            //     }

            if($email_type){

                if($email_type=='none' && !$count){
                    return [];
                }else if($email_type=='none' && $count){
                   return 0; 
                }else{
                     $email_type = implode(',',$email_type);
                    
                     $sql .=" AND pe.event_email_type IN(".$email_type.") ";
                }
             }else{
                $sql .=" AND pe.event_email_type > 0 ";
             }
            // Filter on categories
    
            // Sorting
            $order = $this->ci->input->get('order');
            $sortCol = $order[0]['column'];
            $sortDir = $order[0]['dir'];
            if(!$order){
                $sortCol = 0;
                $sortDir = 'DESC';
            }
            $sortCols = [
                0 => 'pe.created_at',
                1 => 'ec.email_subject',
                2 => 'ec.sender_name',
                3 => 'ec.to_email',
                4 => 'eet.type_name',
                5 => 'pe.delivered_at',
                6 => 'pe.opened_at',
                
            ];
    
            // // Search
            $searchVal = $this->ci->input->get('search')['value'];
            if ($searchVal) {
                $sql .= " AND (" .
                    "(ec.email_subject  LIKE '%" . $searchVal . "%')" .
                    "OR (ec.sender_name  LIKE '%" . $searchVal . "%')" .
                    "OR (ec.to_email  LIKE '%" . $searchVal . "%')" .
                    "OR (ec.email_content  LIKE '%" . $searchVal . "%')" .
                    "OR (pe.created_at  LIKE '%" . $searchVal . "%')" .
                    ") ";
            }
    
            $sql .= " ORDER BY " . $sortCols[$sortCol] . ' ' . $sortDir;
            if($sortCol==0){
                $sql .=",pe.id ". $sortDir;
            }
            // Handle Limit
            if ($this->ci->input->get('length') && !$count) {
                $sql .= ' LIMIT ' . $this->ci->input->get('length');
                $sql .= ' OFFSET ' . $this->ci->input->get('start');
            }
            // if($email_type){
            //     echo $sql;die;
            // }
            //echo $sql;die;
    
            // Organize the data
            $rows = $this->getAllResults($sql);
    
            // If counting, just return the count
            if ($count) {
                return count($rows);
            }
    
            $tableData = [];
            
            foreach ($rows as $data) {

                $delivered = '<span class="tiptip" style="color:#ad1515" title="Not Delivered"><i class="fa fa-fw fa-times-circle-o"></i></span>';
                $delivered_at = '-';
                if($data->delivered_at){
                    //$delivered_at = date_format(date_create($data->delivered_at),"m/d/y g:ia");
                    $delivered_at =  date('m/d/Y g:i A', strtotime($data->delivered_at) + TIMEZONE_OFFSET);
                    $delivered = '<span class="tiptip" style="color:#268c0f" title="'.$delivered_at.'"><i class="fa fa-fw fa-check-circle-o"></i></span>';
 
                }
                $opened = '<span class="tiptip" style="color:#ad1515" title="Not Opened"><i class="fa fa-fw fa-times-circle-o"></i></span>';
                $opened_at = '-';
                if($data->opened_at){
                   // $opened_at = date_format(date_create($data->opened_at),"m/d/y g:ia");
                    $opened_at =  date('m/d/Y g:i A', strtotime($data->opened_at) + TIMEZONE_OFFSET);
                    $opened = '<span class="tiptip" style="color:#268c0f" title="'.$opened_at.'"><i class="fa fa-fw fa-check-circle-o"></i></span>';
                }
                $type_name = '';
                if($data->type_name){
                    
                    $type_name = '<div class="badge tiptiptop" style="background-color:'.$data->color_code.';width: fit-content;margin: 0px auto;" title="'.$data->type_name.'">'.$data->type_code.'</div>';
                }
               
                $row = [
                  //  0 => date_format(date_create($data->created_at),"m/d/y g:ia"),
                    0 => date('m/d/Y g:i A', strtotime($data->created_at) + TIMEZONE_OFFSET),
                    1 => $data->email_subject,
                    2 => $data->sender_name,
                    3 => $data->to_email,
                    4 => $type_name,
                    5 => $delivered,
                    6 => $opened,
                  //  7 => '<a class="email_event_email_show_span tiptipleft" title="View Email" style="cursor:pointer" data-event-id="'.$data->id.'" data-sent="'.date_format(date_create($data->created_at),"m/d/y g:ia").'" data-delivered="'.$delivered_at.'" data-opened="'.$opened_at.'"><i class="fa fa-fw fa-envelope-o"></i></a>',
                    7 => '<a class="email_event_email_show_span ram-ram tiptipleft" title="View Email" style="cursor:pointer" data-event-id="'.$data->id.'"  data-sent="'.date('m/d/Y g:i A', strtotime($data->created_at) + TIMEZONE_OFFSET).'"  data-delivered="'.$delivered_at.'" data-opened="'.$opened_at.'"><i class="fa fa-fw fa-envelope-o"></i></a>',

                ];
    
                $tableData[] = $row;
            }
    
            return $tableData;
        }


        public function getClientEmailEvents($client_id,$count = false)
        {
            $CI =& get_instance();
            $CI->load->library('session');
            $sql = "SELECT pe.*,ec.email_subject,ec.sender_name,ec.to_email
            FROM proposal_events pe 
            left join email_content ec on pe.id = ec.event_id
            WHERE pe.client_id = " . $client_id ."";
    
            // Filter on categories
    
            // Sorting
            $order = $this->ci->input->get('order');
            $sortCol = $order[0]['column'];
            $sortDir = $order[0]['dir'];
            if(!$order){
                $sortCol = 0;
                $sortDir = 'DESC';
            }
            $sortCols = [
                0 => 'pe.created_at',
                1 => 'ec.email_subject',
                2 => 'ec.sender_name',
                3 => 'ec.to_email',
                4 => 'pe.delivered_at',
                5 => 'pe.opened_at',
                
            ];
    


    
            // // Search
            $searchVal = $this->ci->input->get('search')['value'];
            if ($searchVal) {
                $sql .= " AND (" .
                    "(ec.email_subject  LIKE '%" . $searchVal . "%')" .
                    "OR (ec.sender_name  LIKE '%" . $searchVal . "%')" .
                    "OR (ec.to_email  LIKE '%" . $searchVal . "%')" .
                    "OR (ec.email_content  LIKE '%" . $searchVal . "%')" .
                    "OR (pe.created_at  LIKE '%" . $searchVal . "%')" .
                    ") ";
            }
    
            $sql .= " ORDER BY " . $sortCols[$sortCol] . ' ' . $sortDir;
            if($sortCol==0){
                $sql .=",pe.id ". $sortDir;
            }
            // Handle Limit
            if ($this->ci->input->get('length') && !$count) {
                $sql .= ' LIMIT ' . $this->ci->input->get('length');
                $sql .= ' OFFSET ' . $this->ci->input->get('start');
            }
           // echo $sql;die;
    
            // Organize the data
            $rows = $this->getAllResults($sql);
    
            // If counting, just return the count
            if ($count) {
                return count($rows);
            }
    
            $tableData = [];
            
            foreach ($rows as $data) {

                $delivered = '<span class="tiptip" style="color:#ad1515" title="Not Delivered"><i class="fa fa-fw fa-times-circle-o"></i></span>';
                $delivered_at = '-';
                if($data->delivered_at){
                    $delivered_at = date_format(date_create($data->delivered_at),"m/d/y g:ia");
                    $delivered = '<span class="tiptip" style="color:#268c0f" title="'.date_format(date_create($data->delivered_at),"m/d/y g:ia").'"><i class="fa fa-fw fa-check-circle-o"></i></span>';
                
                }
                $opened = '<span class="tiptip" style="color:#ad1515" title="Not Opened"><i class="fa fa-fw fa-times-circle-o"></i></span>';
                $opened_at = '-';
                if($data->opened_at){
                    $opened_at = date_format(date_create($data->opened_at),"m/d/y g:ia");
                    $opened = '<span class="tiptip" style="color:#268c0f" title="'.date_format(date_create($data->opened_at),"m/d/y g:ia").'"><i class="fa fa-fw fa-check-circle-o"></i></span>';
                }  
               
                $row = [
                    0 => date_format(date_create($data->created_at),"m/d/y g:ia"),
                    1 => $data->email_subject,
                    2 => $data->sender_name,
                    3 => $data->to_email,
                    4 => $delivered,
                    5 => $opened,
                    6 => '<a class="email_event_email_show_span tiptipleft" title="View Email" style="cursor:pointer" data-event-id="'.$data->id.'" data-sent="'.date_format(date_create($data->created_at),"m/d/y g:ia").'" data-delivered="'.$delivered_at.'" data-opened="'.$opened_at.'"><i class="fa fa-fw fa-envelope-o"></i></a>',
                    
                ];
    
                $tableData[] = $row;
            }
    
            return $tableData;
        }
        
        public function getLeadEmailEvents($lead_id,$count = false)
        {
            $CI =& get_instance();
            $CI->load->library('session');
            $sql = "SELECT pe.*,ec.email_subject,ec.sender_name,ec.to_email
            FROM proposal_events pe 
            left join email_content ec on pe.id = ec.event_id
            WHERE pe.lead_id = " . $lead_id ."";
    
            // Filter on categories
    
            // Sorting
            $order = $this->ci->input->get('order');
            $sortCol = $order[0]['column'];
            $sortDir = $order[0]['dir'];
    
            if(!$order){
                $sortCol = 0;
                $sortDir = 'DESC';
            }
            $sortCols = [
                0 => 'pe.created_at',
                1 => 'ec.email_subject',
                2 => 'ec.sender_name',
                3 => 'ec.to_email',
                4 => 'pe.delivered_at',
                5 => 'pe.opened_at',
                
            ];

            // // Search
            $searchVal = $this->ci->input->get('search')['value'];
            if ($searchVal) {
                $sql .= " AND (" .
                    "(ec.email_subject  LIKE '%" . $searchVal . "%')" .
                    "OR (ec.sender_name  LIKE '%" . $searchVal . "%')" .
                    "OR (ec.to_email  LIKE '%" . $searchVal . "%')" .
                    "OR (ec.email_content  LIKE '%" . $searchVal . "%')" .
                    "OR (pe.created_at  LIKE '%" . $searchVal . "%')" .
                    ") ";
            }
    
            $sql .= " ORDER BY " . $sortCols[$sortCol] . ' ' . $sortDir;
            if($sortCol==0){
                $sql .=",pe.id ". $sortDir;
            }
            // Handle Limit
            if ($this->ci->input->get('length') && !$count) {
                $sql .= ' LIMIT ' . $this->ci->input->get('length');
                $sql .= ' OFFSET ' . $this->ci->input->get('start');
            }
           // echo $sql;die;
    
            // Organize the data
            $rows = $this->getAllResults($sql);
    
            // If counting, just return the count
            if ($count) {
                return count($rows);
            }
    
            $tableData = [];
            
            foreach ($rows as $data) {

                $delivered = '<span class="tiptip" style="color:#ad1515" title="Not Delivered"><i class="fa fa-fw fa-times-circle-o"></i></span>';
                $delivered_at = '-';
                if($data->delivered_at){
                  //  $delivered_at = date_format(date_create($data->delivered_at),"m/d/y g:ia");
                    $delivered_at=date('m/d/Y g:i A', strtotime($data->delivered_at) + TIMEZONE_OFFSET);
                    $delivered = '<span class="tiptip" style="color:#268c0f" title="'.$delivered_at.'"><i class="fa fa-fw fa-check-circle-o"></i></span>';
                
                }
                $opened = '<span class="tiptip" style="color:#ad1515" title="Not Opened"><i class="fa fa-fw fa-times-circle-o"></i></span>';
                $opened_at = '-';
                if($data->opened_at){
                   // $opened_at = date_format(date_create($data->opened_at),"m/d/y g:ia");
                    $opened_at =  date('m/d/Y g:i A', strtotime($data->opened_at) + TIMEZONE_OFFSET);
                    $opened = '<span class="tiptip" style="color:#268c0f" title="'.$opened_at.'"><i class="fa fa-fw fa-check-circle-o"></i></span>';
                }  
               
                $row = [
                    //0 => date_format(date_create($data->created_at),"m/d/y g:ia"),
                    0 => date('m/d/Y g:i A', strtotime($data->created_at) + TIMEZONE_OFFSET),
                    1 => $data->email_subject,
                    2 => $data->sender_name,
                    3 => $data->to_email,
                    4 => $delivered,
                    5 => $opened,
                    6 => '<a class="email_event_email_show_span tiptipleft" title="View Email" style="cursor:pointer" data-event-id="'.$data->id.'" data-sent="'.date('m/d/Y g:i A', strtotime($data->created_at) + TIMEZONE_OFFSET).'" data-delivered="'.$delivered_at.'" data-opened="'.$opened_at.'"><i class="fa fa-fw fa-envelope-o"></i></a>',
                    
                ];
    
                $tableData[] = $row;
            }
    
            return $tableData;
        }

    public function getProspectEmailEvents($prospect_id,$count = false)
        {
            $CI =& get_instance();
            $CI->load->library('session');
            $sql = "SELECT pe.*,ec.email_subject,ec.sender_name,ec.to_email
            FROM proposal_events pe 
            left join email_content ec on pe.id = ec.event_id
            WHERE pe.prospect_id = " . $prospect_id ."";
    
            // Filter on categories
    
            // Sorting
            $order = $this->ci->input->get('order');
            $sortCol = $order[0]['column'];
            $sortDir = $order[0]['dir'];
    
            if(!$order){
                $sortCol = 0;
                $sortDir = 'DESC';
            }
            $sortCols = [
                0 => 'pe.created_at',
                1 => 'ec.email_subject',
                2 => 'ec.sender_name',
                3 => 'ec.to_email',
                4 => 'pe.delivered_at',
                5 => 'pe.opened_at',
                
            ];
    
            // // Search
            $searchVal = $this->ci->input->get('search')['value'];
            if ($searchVal) {
                $sql .= " AND (" .
                    "(ec.email_subject  LIKE '%" . $searchVal . "%')" .
                    "OR (ec.sender_name  LIKE '%" . $searchVal . "%')" .
                    "OR (ec.to_email  LIKE '%" . $searchVal . "%')" .
                    "OR (ec.email_content  LIKE '%" . $searchVal . "%')" .
                    "OR (pe.created_at  LIKE '%" . $searchVal . "%')" .
                    ") ";
            }
    
            $sql .= " ORDER BY " . $sortCols[$sortCol] . ' ' . $sortDir;
            if($sortCol==0){
                $sql .=",pe.id ". $sortDir;
            }
            // Handle Limit
            if ($this->ci->input->get('length') && !$count) {
                $sql .= ' LIMIT ' . $this->ci->input->get('length');
                $sql .= ' OFFSET ' . $this->ci->input->get('start');
            }
           // echo $sql;die;
    
            // Organize the data
            $rows = $this->getAllResults($sql);
    
            // If counting, just return the count
            if ($count) {
                return count($rows);
            }
    
            $tableData = [];
            
            foreach ($rows as $data) {

                $delivered = '<span class="tiptip" style="color:#ad1515" title="Not Delivered"><i class="fa fa-fw fa-times-circle-o"></i></span>';
                $delivered_at = '-';
                if($data->delivered_at){
                   // $delivered_at = date_format(date_create($data->delivered_at),"m/d/y g:ia");
                    $delivered_at = date('m/d/Y g:i A', strtotime($data->delivered_at) + TIMEZONE_OFFSET);
                    $delivered = '<span class="tiptip" style="color:#268c0f" title="'.$delivered_at.'"><i class="fa fa-fw fa-check-circle-o"></i></span>';
                
                }
                $opened = '<span class="tiptip" style="color:#ad1515" title="Not Opened"><i class="fa fa-fw fa-times-circle-o"></i></span>';
                $opened_at = '-';
                if($data->opened_at){
                   // $opened_at = date_format(date_create($data->opened_at),"m/d/y g:ia");
                    $opened_at = date('m/d/Y g:i A', strtotime($data->opened_at) + TIMEZONE_OFFSET);
                    $opened = '<span class="tiptip" style="color:#268c0f" title="'.$opened_at.'"><i class="fa fa-fw fa-check-circle-o"></i></span>';
                }  
               
                $row = [
                   // 0 => date_format(date_create($data->created_at),"m/d/y g:ia"),
                    0 => date('m/d/Y g:i A', strtotime($data->created_at) + TIMEZONE_OFFSET),
                    1 => $data->email_subject,
                    2 => $data->sender_name,
                    3 => $data->to_email,
                    4 => $delivered,
                    5 => $opened,
                    6 => '<a class="email_event_email_show_span tiptipleft" title="View Email" style="cursor:pointer" data-event-id="'.$data->id.'" data-sent="'.date('m/d/Y g:i A', strtotime($data->created_at) + TIMEZONE_OFFSET).'" data-delivered="'.$delivered_at.'" data-opened="'.$opened_at.'"><i class="fa fa-fw fa-envelope-o"></i></a>',
                    
                ];
    
                $tableData[] = $row;
            }
    
            return $tableData;
        }
   
}