<?php
namespace Pms\Repositories;

use Accounts;
use Carbon\Carbon;
use models\ClientGroupResend;
use models\ClientGroupResendEmail;
use models\Companies;
use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;

class Client extends RepositoryAbstract
{
    use DBTrait;

    public function get($id)
    {
        return $this->getSingleResult("select * from clients where clientId = {$id}");
    }

    

    
    public function getCompanyClientResendList(Companies $company,$account)
    {

        $sql = "SELECT cgr.resend_name,cgr.id FROM client_group_resends cgr"; 
                //WHERE cgr.company_id = " . (int)$company->getCompanyId()." AND cgr.is_deleted =0 AND cgr.parent_resend_id IS NULL order by id desc";

                if ($account->isAdministrator() && $account->hasFullAccess()) {
                    //branch admin, can access only his branch
                    $sql .= ' WHERE  cgr.company_id=' . $company->getCompanyId();
                }else if ($account->isBranchAdmin()) {
                    //branch admin, can access only his branch
                    $sql .= ' INNER JOIN client_group_resend_email AS cgre ON cgr.id = cgre.resend_id 
                    LEFT JOIN clients c1 ON cgre.client_id = c1.clientId
                    LEFT JOIN accounts AS a2 ON c1.account = a2.accountId   
                    WHERE a2.branch = ' . $account->getBranch() . '
                    AND cgr.company_id=' . $company->getCompanyId();
                } else {
        
                    //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
        
                    $sql .= ' WHERE cgr.id IN(SELECT DISTINCT (cgre.resend_id)
                            FROM client_group_resend_email cgre
                            LEFT JOIN clients ON cgre.client_id = clients.clientId
                            WHERE clients.account = ' . $account->getAccountId().') ';
                }
        
                $sql .=" AND cgr.is_deleted =0 order by id desc";
        return $this->getAllResults($sql);

    }


    public function groupSend(array $ids, $emailData, \models\Accounts $account, $logAction = 'client_send', $logMessage = null, $cgsId = NULL, $cgsName = NULL,$exclude_override)
    {

        $CI =& get_instance();
        $CI->load->library('jobs2', NULL, 'my_jobs');
        $count = 0;
        $alreadySentCount = 0;
        $unsentCount = 0;
        $duplicateEmailCount =0;
        $check_sent_email = true;
        $check_email_list =[];
        $check_client_ids_list =[];
        $owner_email_list = [];
        if($cgsId != -1){
            $cgs = $this->em->find('\models\ClientGroupResend', $cgsId);

            if (!$cgs) {
                $cgs = new ClientGroupResend();
                $cgs->setAccountId($account->getAccountId());
                $cgs->setCompanyId($account->getCompany()->getCompanyId());
                $cgs->setAccountName($account->getFullName());
                $cgs->setSubject($emailData['subject']);
                $cgs->setEmailCc(0);
                $cgs->setCustomSender(($emailData['fromName']) ? 1 : 0);
                $cgs->setCustomSenderName($emailData['fromName']);
                $cgs->setCustomSenderEmail($emailData['fromEmail']);
                $cgs->setResendName($cgsName);
                $cgs->setExcludedOverride($exclude_override);
                $cgs->setFilters(json_encode($emailData['clientFilter'],JSON_HEX_APOS));
                $check_sent_email = false;
            }else{
                $sql = "SELECT cgre.client_id,cgre.email_address FROM client_group_resend_email cgre WHERE cgre.resend_id =".$cgs->getId(); 
                $all_sent_emails =$this->getAllResults($sql);

                foreach($all_sent_emails as $all_sent_email){
                    array_push($check_email_list,strtolower($all_sent_email->email_address));
                    array_push($check_client_ids_list,$all_sent_email->client_id);
                }
            }


            $cgs->setIpAddress($_SERVER['REMOTE_ADDR']);
            $cgs->setEmailContent($emailData['body']);
            $cgs->setCreated(Carbon::now());
            $this->em->persist($cgs);
            $this->em->flush();
        }else{
            $check_sent_email = false;
        }

        foreach ($ids as $clientlId) {
            try{
                $thisEmailData = $emailData;
            
                if ($check_sent_email) {

                    if(in_array($clientlId, $check_client_ids_list)){
                        $alreadySentCount++;
                        continue;
                    }
                }

                $client = $this->em->findClient($clientlId);
                if($client){

                    if($exclude_override=='0'){
                        if($client->getResendExcluded()==1){
                            continue;
                        }
                    }
                    
                    if(!$client->getEmail()){
                        continue;
                    }

                    if(in_array(strtolower($client->getEmail()), $check_email_list)){
                        $duplicateEmailCount++;
                        continue;
                    }

                    //$clientAccount = $this->em->findAccount($client->getAccount());
                    $thisEmailData['fromName'] = ($emailData['fromName']) ?: $client->getAccount()->getFullName();
                    $thisEmailData['fromEmail'] = 'noreply@' . SITE_EMAIL_DOMAIN;
                    $thisEmailData['replyTo'] = ($emailData['replyTo']) ?: $client->getAccount()->getEmail();

                    $to = $client->getEmail();
                    if(!in_array($client->getAccount()->getEmail(), $owner_email_list)){
                        array_push($owner_email_list, strtolower($client->getAccount()->getEmail()));
                    } 
                    if($cgsId != -1){
                        $cgse = new ClientGroupResendEmail();
                        $cgse->setResendId($cgs->getId());
                        $cgse->setClientId($clientlId);
                        $cgse->setEmailAddress($to);

                        $this->em->persist($cgse);
                        $this->em->flush();
                        $cgseId = $cgse->getId();
                        $cgsId =$cgs->getId();
                    } else {
                        $cgsId = NULL;
                        $cgseId = NULL;
                    }
                    $thisEmailData['to'] = $to;

                    $thisEmailData['uniqueArg'] = 'client_resend_email_id';
                    $thisEmailData['uniqueArgVal'] = $cgseId;
                    $thisEmailData['clientId'] = $clientlId;
                    $thisEmailData['campaignId'] = $cgsId;

                    array_push($check_email_list, strtolower($to));
                    $event_id = $this->getProposalEventRepository()->createEmailEvent('Client',$clientlId,$account,$thisEmailData['to'],$thisEmailData['body'],$thisEmailData['subject'],'',$thisEmailData['fromName'],$thisEmailData['fromEmail']);
                    $thisEmailData['uniqueArg2'] = 'email_event';
                    $thisEmailData['uniqueArg2Val'] = $event_id;

                    $etp = new \EmailTemplateParser();
                    $etp->setClient($client);
                    $etp->setAccount($client->getAccount());

                    $thisEmailData['subject'] = $etp->parse($thisEmailData['subject']);
                    $thisEmailData['body'] = $etp->parse($thisEmailData['body']);

                    
                    // Save the queue
                    $CI->my_jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'send_individual_client_email',$thisEmailData,'test job');
                    // $CI->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'group_client_resend',$thisEmailData,'test job');
                    // //$this->send($clientlId, $emailData, $account, $logAction, $logMessage, $cgse->getId());
                    $count++;
                    //log action
                    $accountId = $account->getAccountId();
                    if($cgsId != -1){
                        $logText = 'Client email campaign '.$cgsName.' sent to ' . $to;
                    }else{
                        $logText = 'Client email sent to ' . $to;  
                    }
                    
                    $this->getLogRepository()->add([
                        'action' => $logAction,
                        'details' => $logText,
                        'client' => $clientlId,
                        'account' => $accountId,
                        'company' => $client->getCompany()->getCompanyId(),
                    ]);
                }
                else {
                    $unsentCount++;
                }

            } catch (\Exception $e) {
                // Do nothing
            }
        }
        
        
        if ($count) {
            //log group action
            if($cgsId != -1){
                $this->getLogRepository()->add([
                    'action' => 'group_action_send',
                    'details' => "Campaign '".$cgsName."' Sent email to {$count} clients",
                    'account' => $account->getAccountId(),
                    'company' => $account->getCompany()->getCompanyId(),
                ]);

                $job_array = [
                    'email_data' => $emailData,
                    'account_id' => $account->getAccountId(),
                    'cgsId' => $cgsId,
                ];
                
                $CI->my_jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'send_job_client_completed_mail',$job_array,'test job');
            }

            //$this->sendAccountCC($emailData, $account,$count);
            //$this->sendOwnerAccountCC($emailData, $account,$owner_email_list);
        }

        $out = [
            'sent' => $count,
            'unsent' => $unsentCount,
            'already_sent' => $alreadySentCount,
            'duplicateEmailCount' => $duplicateEmailCount
        ];
        
        return $out;
    }

            /**
     * @param Companies $company
    
     * @return array
     */
    public function getGroupResendData(Companies $company, $count = false,$account=NULL)
    {
        $CI =& get_instance();
        $CI->load->library('session');
        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $failed_subquery = " (SELECT SUM(cgre2.is_failed) FROM client_group_resend_email AS cgre2 WHERE cgre2.resend_id = pgr.id ) AS failed";
        }else if ($account->isBranchAdmin()) {
                //branch admin, can access only his branch
                $failed_subquery = " (SELECT SUM(cgre2.is_failed) FROM client_group_resend_email AS cgre2   
                
                LEFT JOIN clients c1 ON cgre2.client_id = c1.clientId
                LEFT JOIN accounts AS a2 ON c1.account = a2.accountId
                WHERE cgre2.resend_id = pgr.id 
                a2.branch = " . $account->getBranch() . "
                    AND pgr.company_id=" . $company->getCompanyId()."
                ) AS failed";
                
            } else {
                $failed_subquery = " (SELECT SUM(cgre2.is_failed) FROM client_group_resend_email AS cgre2
                LEFT JOIN clients ON cgre2.client_id = clients.clientId
                 WHERE cgre2.resend_id = pgr.id  AND (pgr.account_id =" . $account->getAccountId()." OR
                 clients.account = " . $account->getAccountId()." )) AS failed";
            
            }
        

        $sql = "SELECT pgr.*,a.firstname,a.lastname,cgrp.resend_name as parent_name,
                    
                    COUNT(pgre.delivered_at) AS delivered,
                    COUNT(pgre.id) AS total_resend,
                    COUNT(pgre.bounced_at) AS bounced,
                    COUNT(pgre.opened_at) AS opened,
                    COUNT(pgre.clicked_at) as clicked,
                    COUNT(pgre.sent_at) AS sent_count,
                    ". $failed_subquery.",
    
                    
                    (COUNT(pgre.clicked_at) / COUNT(pgre.id)) AS cct,
                    (COUNT(pgre.opened_at) / COUNT(pgre.id)) AS pct 
                    FROM client_group_resends pgr 
                    LEFT JOIN client_group_resend_email AS pgre ON pgr.id = pgre.resend_id
                    LEFT JOIN accounts AS a ON pgr.account_id = a.accountId 
                    LEFT JOIN client_group_resends AS cgrp ON pgr.parent_resend_id = cgrp.id";

        // Filter on categories

        // Sorting
        $order = $this->ci->input->get('order');
        $sortCol = $order[0]['column'];
        $sortDir = $order[0]['dir'];

        $sortCols = [
            1 => 'pgr.id',
            2 => 'pgr.created',
            3 => 'pgr.resend_name',
            4 => 'pgr.account_name',
            5 => 'total_resend',
            6 => 'delivered',
            7 => 'bounced',
            8 => 'opened',
            9 => 'clicked',
            10 => 'cct',
            12 => 'pct',
        ];

        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= ' WHERE  pgr.company_id=' . $company->getCompanyId();
        }else if ($account->isBranchAdmin()) {
                //branch admin, can access only his branch
               
                    $sql .= ' LEFT JOIN
                    clients c1 ON pgre.client_id = c1.clientId
                LEFT JOIN accounts AS a2 ON c1.account = a2.accountId   WHERE a2.branch = ' . $account->getBranch() . '
                    AND pgr.company_id=' . $company->getCompanyId();
            } else {
    
                
            $sql .= " LEFT JOIN
                clients ON pgre.client_id = clients.clientId WHERE (pgr.account_id =" . $account->getAccountId()." OR
                    clients.account = " . $account->getAccountId()." )";
            }
       
        $sql .= ' AND pgr.is_deleted=0 AND pgre.is_failed = 0 ';

        // // Search
        $searchVal = $this->ci->input->get('search')['value'];
        if ($searchVal) {
            $sql .= " AND (" .
                "(pgr.account_name  LIKE '%" . $searchVal . "%')" .
                "OR (pgr.resend_name  LIKE '%" . $searchVal . "%')" .
                ") GROUP BY pgr.id";
        }else{
            $sql .= ' GROUP BY pgr.id';
        }
//echo $sql;die;
        $sql .= " ORDER BY " . $sortCols[$sortCol] . ' ' . $sortDir;

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
            
            // Not sure what's going on here but I'll keep it for now
            $names = '';
            $names2 = explode(' ', trim($data->firstname . ' ' . $data->lastname));
            foreach ($names2 as $name) {
                $names .= substr($name, 0, 1) . ' . ';
            }

            $account_name = '<span class="tiptip" title="'. $data->firstname . ' ' . $data->lastname.'">'. $names.'</span>';
            $date=date_create($data->created);
            $open = ($data->total_resend - ($data->delivered+$data->bounced));
            
            // $unsend = $this->getUnopenedProposals($data->id);
            // $unsend = count($unsend);
            $unsend = '10';
            $open_p = $data->opened ? round(($data->pct) * 100) : '0';
            $click_p = $data->clicked ? round(($data->cct) * 100) : '0';
            $failed_info = '';
            if($data->failed>0){
                $failed_info = '<a href="/clients/resend/' . $data->id . '/failed" class="right" style="position: absolute;right: 0;"><i class="fa fa-fw fa-info-circle tiptip" style="color: #000;font-size: 14px;" title="'.$data->failed.' Client email Failed to send" ></i></a>';
            }
            $create_date = date_format($date, "m/d/y g:i A");
    //if (($account->isAdministrator() && $account->hasFullAccess()) || $data->account_id == $account->getAccountId()) {
    
            $action = '<div class="dropdownButton">
                <a class="dropdownToggle" href="#">Go</a>
                <div class="dropdownMenuContainer single">
                    <ul class="dropdownMenu">
                    <li>
                        <a data-resend-name="'.$data->resend_name.'" data-resend-id="'.$data->id.'" href="javascript:void(0);" class="edit_resend_name "><i class="fa fa-fw fa-pencil"></i> Edit Campaign Name</a>
                    </li> 
                    
                    <li>
                        <a data-resend-id="'.$data->id.'" href="javascript:void(0);" class="show_email_content "><i class="fa fa-fw fa-pencil-square-o"></i> Summary</a>
                    </li>
                    <li>
                        <a href="../clients/resend/'.$data->id.'" class="show_email_content22 " ><i class="fa fa-fw fa-user"></i> View Clients</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" data-val="'.$data->id.'" class="delete_campaign " ><i class="fa fa-fw fa-trash"></i> Delete Campaign</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" data-val="'.$data->id.'" class="resend_upopened " data-unclicked="0" ><i class="fa fa-fw fa-share-square"></i> Resend Unopened Emails</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" data-val="'.$data->id.'" class="resend_upopened " data-unclicked="1"><i class="fa fa-fw fa-share-square-o"></i> Resend Unclicked Emails</a>
                    </li>
                        
                    </ul>
                </div>
            </div>';
            
            $total_resend = '<div style="position: relative;"><a href="/clients/resend/' . $data->id . '">' . $data->total_resend . '</a>'.$failed_info.'</div>';
            if($data->sent_count < $data->total_resend){
                $total_sending = $data->total_resend;
                if($data->failed>0){
                    $total_sending = $data->failed + $total_sending;
                }
                $total_resend = '<div style="position: relative;"><a href="/clients/resend/' . $data->id . '">' .$data->sent_count.' / '.  $total_sending . '</a>'.$failed_info.'</div>';
                $create_date .= ' <i class="fa fa-fw fa-info-circle tiptip" style="color: #000;font-size: 14px;" title="Campaign is in progress" ></i>';
            }
            $delivered = '<a href="/clients/resend/' . $data->id . '/delivered">' . $data->delivered . '</a>';
            $bounced = '<a href="/clients/resend/' . $data->id . '/bounced">' . $data->bounced . '</a>';
            $opened = '<div style="display: flex;justify-content: space-between;"><a href="/clients/resend/' . $data->id . '/opened">' . $data->opened . '</a><a href="/clients/resend/' . $data->id . '/opened">' . $open_p . '%</a></div>';
            $link_open_p = '<a href="/clients/resend/' . $data->id . '/opened">' . $open_p . '%</a>';
            $clicked = '<div style="display: flex;justify-content: space-between;"><a href="/clients/resend/' . $data->id . '/clicked">' . $data->clicked . '</a><a class="tiptip" title="'.$data->clicked.' Clicks" href="/clients/resend/' . $data->id . '/clicked">' . $click_p . '%</a></div>';
            $link_click_p = '<a class="tiptip" title="'.$data->clicked.' Clicks" href="/clients/resend/' . $data->id . '/clicked">' . $click_p . '%</a>';
    // }else{
    //     $action = '<div class="dropdownButton">
    //             <a class="dropdownToggle" href="#">Go</a>
    //             <div class="dropdownMenuContainer single">
    //                 <ul class="dropdownMenu">
                   
                    
    //                 <li>
    //                     <a data-resend-id="'.$data->id.'" href="javascript:void(0);" class="show_email_content "><i class="fa fa-fw fa-pencil-square-o"></i> Summary</a>
    //                 </li>
    //                 <li>
    //                     <a href="../clients/resend/'.$data->id.'" class="show_email_content22 " ><i class="fa fa-fw fa-user"></i> View Clients</a>
    //                 </li>
                    
                        
    //                 </ul>
    //             </div>
    //         </div>';

    //         $total_resend = '<a title="View My Cients" class="tiptip" href="/clients/resend/' . $data->id . '"><i  class="fa fa-fw fa-eye"></i></a>';
    //         $delivered = '<a title="View My Cients" class="tiptip" href="/clients/resend/' . $data->id . '/delivered"><i class="fa fa-fw fa-eye"></i></a>';
    //         $bounced = '<a title="View My Cients" class="tiptip" href="/clients/resend/' . $data->id . '/bounced"><i class="fa fa-fw fa-eye"></i></a>';
    //         $opened = '<a title="View My Cients" class="tiptip" href="/clients/resend/' . $data->id . '/opened"><i class="fa fa-fw fa-eye"></i></a>';
    //         $link_open_p = '<a title="View My Cients" class="tiptip" href="/clients/resend/' . $data->id . '/opened"><i class="fa fa-fw fa-eye"></i></a>';
    //         $clicked = '<a title="View My Proposals" class="tiptip" href="/clients/resend/' . $data->id . '/clicked"><i class="fa fa-fw fa-eye"></i></a>';
    //         $link_click_p = '<a title="View My Proposals" class="tiptip" href="/clients/resend/' . $data->id . '/clicked"><i class="fa fa-fw fa-eye"></i></a>';
    // }
            $badge = "R";
            $resend_type_text = "Resend";
            if($data->resend_type == 1){
                $badge = "RUO";
                $resend_type_text = "Resend Unopened";
            }
            if($data->resend_type == 2){
                $badge = "RUC";
                $resend_type_text = "Resend Unclicked";
            }
            if($data->resend_type == 3){
                $badge = "RB";
                $resend_type_text = "Resend Bounced";
            }
            $campaign_name = $data->parent_name?'[<span class="tiptip" title ="'.$resend_type_text.' of '.$data->parent_name.' ">'.$badge.'</span>] '.$data->resend_name:$data->resend_name;
            //$campaign_name = $data->parent_name?'[<span class="tiptip" title ="Resend of '.$data->parent_name.' ">R</span>] '.$data->resend_name:$data->resend_name;
            
            $row = [
                0 => '<input type="checkbox" class="campaignCheck" data-campaign-id="' . $data->id . '" />',
                1 => $action,
                2 => $create_date,
                3 => $campaign_name,
                4 => $account_name,
                5 => $total_resend,
                6 => $delivered,
                7 => $bounced,
                8 => $opened,
                9 => $clicked,
                10 => $open_p,
                11 => $click_p,
                
            ];

            $tableData[] = $row;
        }

        return $tableData;
    }

    function getUnopenedClientEmails($resend_id){

        $sql = "SELECT c.clientId FROM client_group_resend_email cgre 
        LEFT JOIN clients c ON cgre.client_id = c.clientId
        LEFT JOIN client_group_resends pgr on cgre.resend_id = cgr.id
        WHERE c.lastOpenTime > UNIX_TIMESTAMP(cgr.created)
        AND cgr.id = ".$resend_id." group by c.clientId";

        return $this->getAllResults($sql);
      }
    
      function getUnopenedClientsStatusCount($resend_id,$clicked=false){

        $sql = "SELECT COUNT(cgre.id) as unopened_emails, SUM(clients.resend_excluded) as total_excluded
        FROM client_group_resend_email cgre
        LEFT JOIN clients ON cgre.client_id = clients.clientId"; 

        if($clicked){
            $sql .= " WHERE cgre.opened_at IS NOT NULL AND cgre.clicked_at IS NULL
            AND cgre.resend_id = ".$resend_id;
        }else{
            $sql .= " WHERE cgre.opened_at IS NULL
            AND cgre.resend_id = ".$resend_id;
        }
        $sql .= " AND cgre.is_failed = 0";
        
        $emails = $this->getAllResults($sql);

        if($emails){
            $total_excluded[] = $emails[0]->total_excluded;
            $unopened_emails[] = $emails[0]->unopened_emails;
        }else{
            $total_excluded[] = 0;
            $unopened_emails[] = 0;
        }

        $sql2 = "SELECT cgre.id
        FROM client_group_resend_email cgre 
        
        WHERE cgre.resend_id = ".$resend_id;

        
        $emails_count = $this->getAllResults($sql2);
        $data =array();
        $data['total_unopened'] = $unopened_emails;
        $data['total_emails'] = count($emails_count);
        $data['total_excluded'] = count($total_excluded);
        
        return $data;


      }


      public function groupSendUnopened($emailData, \models\Accounts $account, $logAction = 'client_send', $logMessage = null, $cgsId = NULL,$unclicked = NULL,$exclude_override)
      {
          $CI =& get_instance();
          $CI->load->library('jobs2', NULL, 'my_jobs');
          $count = 0;
          $alreadySentCount = 0;
          $unsentCount = 0;
          $bouncedUnsentCount = 0;
          $check_sent_email = true;
          $check_email_list = [];
          
          $parentResend = $this->em->find('\models\ClientGroupResend', $cgsId);

         $parentFilter = json_decode($parentResend->getFilters());
         $parentFilter->pResendType = ($unclicked=='1') ? 'Unclicked' : 'Unopened';

          $cgs = new ClientGroupResend();
          $cgs->setAccountId($account->getAccountId());
          $cgs->setCompanyId($account->getCompany()->getCompanyId());
          $cgs->setAccountName($account->getFullName());
          $cgs->setSubject($emailData['subject']);
          $cgs->setEmailCc(0);
          $cgs->setCustomSender(($emailData['fromName']) ? 1 : 0);
          $cgs->setCustomSenderName($emailData['fromName']);
          $cgs->setCustomSenderEmail($emailData['fromEmail']);
          $cgs->setResendName($emailData['new_resend_name']);
          $cgs->setIpAddress($_SERVER['REMOTE_ADDR']);
          $cgs->setEmailContent($emailData['body']);
          $cgs->setParentResendId($cgsId);
          $cgs->setExcludedOverride($exclude_override);
          
          $cgs->setFilters(json_encode($parentFilter,JSON_HEX_APOS));
          if($unclicked == 1){
            $cgs->setResendType(2);
        } else {
            $cgs->setResendType(1);
        }
          $cgs->setCreated(Carbon::now());
          $this->em->persist($cgs);
          $this->em->flush();
            
                
          $sql = "SELECT cgre.client_id,cgre.id,cgre.email_address,cgre.bounced_at
          FROM client_group_resend_email cgre"; 
          
         
            if($unclicked=='1'){
                $sql .= " WHERE cgre.opened_at IS NOT NULL AND cgre.clicked_at IS NULL
                AND cgre.resend_id = ".$cgsId;
            }else{
                $sql .= " WHERE cgre.opened_at IS NULL
                AND cgre.resend_id = ".$cgsId;
            }
            $sql .= " AND cgre.is_failed = 0";

          $Resend_campaigns = $this->getAllResults($sql);
          foreach ($Resend_campaigns as $Resend_campaign) {
              $sendIt = true;
              $bounced =false;
              $client_id = $Resend_campaign->client_id;
              $thisEmailData = $emailData;
              $client = $this->em->findClient($client_id);
           if($client){

                if($exclude_override=='0'){
                    if($client->getResendExcluded()==1){
                        continue;
                    }
                }

              if ($sendIt) {
                  
                    if(in_array(strtolower($client->getEmail()), $check_email_list)){
                        continue;
                    }
                
                  //Event Log
                  //$this->getProposalEventRepository()->sendProposalCampaign($proposal, $account);

                  $thisEmailData['fromName'] = ($emailData['fromName']) ?: $client->getAccount()->getFullName();
                  $thisEmailData['fromEmail'] = 'noreply@' . SITE_EMAIL_DOMAIN;
                  $thisEmailData['replyTo'] = ($emailData['replyTo']) ?: $client->getAccount()->getEmail();
                  $to = $client->getEmail();
                  array_push($check_email_list,strtolower($to));

                  $cgse = new ClientGroupResendEmail();
                  $cgse->setResendId($cgs->getId());
                  $cgse->setClientId($client_id);
                  $cgse->setEmailAddress($to);
                  $cgse->setParentResendEmailId($Resend_campaign->id);
                  $this->em->persist($cgse);
                  $this->em->flush();
                  $cgseId = $cgse->getId();
                  $cgsId =$cgs->getId();
  
                $thisEmailData['to'] = $to;
                
                $thisEmailData['uniqueArg'] = 'client_resend_email_id';
                $thisEmailData['uniqueArgVal'] = $cgse->getId();
                $thisEmailData['clientId'] = $client_id;
                $thisEmailData['campaignId'] = $cgsId;

                $event_id = $this->getProposalEventRepository()->createEmailEvent('Client',$client_id,$account,$thisEmailData['to'],$thisEmailData['body'],$thisEmailData['subject'],'',$thisEmailData['fromName'],$thisEmailData['fromEmail']);
                $thisEmailData['uniqueArg2'] = 'email_event';
                $thisEmailData['uniqueArg2Val'] = $event_id;

                $etp = new \EmailTemplateParser();
                $etp->setClient($client);
                $etp->setAccount($client->getAccount());

                $thisEmailData['subject'] = $etp->parse($thisEmailData['subject']);
                $thisEmailData['body'] = $etp->parse($thisEmailData['body']);

                //$this->getEmailRepository()->send($thisEmailData);

                $CI->my_jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'send_individual_client_email',$thisEmailData,'test job');
                    // $CI =& get_instance();
                    // $CI->load->library('jobs');
                    // // Save the opaque image
                    // $CI->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'group_client_resend',$thisEmailData,'test job');
                    // //$this->send($clientlId, $emailData, $account, $logAction, $logMessage, $cgse->getId());
                    $count++;
  
              } else {
                if(!$bounced){
                    $unsentCount++;
                }
              }
            }
          }
  
          if ($count) {
              //log group action
              $this->getLogRepository()->add([
                  'action' => 'group_action_send',
                  'details' => "Group Mail Sent to {$count} clients",
                  'account' => $account->getAccountId(),
                  'company' => $account->getCompany()->getCompanyId(),
              ]);
              //$this->sendAccountCC($emailData, $account,$count);
          }
  
          $out = [
              'sent' => $count,
              'unsent' => $unsentCount,
              'already_sent' => $alreadySentCount,
              'bouncedUnsentCount' => $bouncedUnsentCount,
          ];
  
          return $out;
      }

      public function getClientChildResend($resend_id){

        $sql = "SELECT cgr.id,cgr.resend_name
        FROM client_group_resends cgr 
        
        WHERE cgr.parent_resend_id = " . $resend_id ;

        return $this->getAllResults($sql);

    }
    

    /**
     * @param ClientGroupResend $resend
     * @return array
     */
    public function getClientResendStats(ClientGroupResend $resend,$account)
    {
        $out = [
            'sent' => $this->getNumResendEmails($resend,$account),
            'delivered' => $this->getNumDeliveredResendEmails($resend,$account),
            'bounced' => $this->getNumBouncedResendEmails($resend,$account),
            'opened' => $this->getNumOpenedResendEmails($resend,$account),
            'unopened' => $this->getNumUnopenedResendEmails($resend,$account),
            'clicked' => $this->getNumClickedResendEmails($resend,$account),
            'failed_count' => $this->getNumFailedResendEmails($resend,$account)
        ];

        return $out;
    }

    public function getNumResendEmails(ClientGroupResend $resend,$account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numSent
        FROM client_group_resend_email pgre";

        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0";
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            
            $sql .= " LEFT JOIN
                clients c1 ON pgre.client_id = c1.clientId
                LEFT JOIN accounts AS a2 ON c1.account = a2.accountId   WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND a2.branch = " . $account->getBranch();
        } else {

            // $sql .= " LEFT JOIN
            // client_group_resends pgr ON pgre.resend_id = pgr.id WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND pgr.account_id=" . $account->getAccountId();
            // $sql .= " LEFT JOIN
            //     clients ON pgre.client_id = clients.clientId WHERE pgre.resend_id ={$resendId}
            //     AND pgre.is_failed = 0 AND 
            //         clients.account = " . $account->getAccountId();
                    $sql .= " LEFT JOIN
                    clients ON pgre.client_id = clients.clientId 
                    LEFT JOIN
                    client_group_resends AS pgr ON pgre.resend_id = pgr.id WHERE pgre.resend_id ={$resendId} AND (pgr.account_id =" . $account->getAccountId()." OR
                        clients.account = " . $account->getAccountId()." ) AND pgre.is_failed = 0";        
                    
        } 
        //WHERE pgre.resend_id = " . $resend->getId();

        $data = $this->getSingleResult($sql);

        return $data->numSent;
    }

    public function getNumFailedResendEmails(ClientGroupResend $resend,$account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(fj.id) AS numFailed
        FROM failed_jobs fj";


        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE fj.campaign_id ={$resendId} AND job_type= 'client_campaign' ";
        }else if ($account->isBranchAdmin()) {
            
            $sql .= " LEFT JOIN
                clients c1 ON fj.entity_id = c1.clientId
                LEFT JOIN accounts AS a2 ON c1.account = a2.accountId   WHERE fj.campaign_id ={$resendId} AND job_type= 'client_campaign' AND a2.branch = " . $account->getBranch();
        } else {
            $sql .= " LEFT JOIN
            clients c1 ON fj.entity_id = c1.clientId 
            LEFT JOIN client_group_resends AS pgr ON fj.campaign_id = pgr.id
            WHERE fj.campaign_id ={$resendId} AND job_type= 'client_campaign' AND  (pgr.account_id =" . $account->getAccountId()." OR
            c1.account = " . $account->getAccountId()." )";

           
        }
        //WHERE pgre.resend_id = " . $resend->getId();

        $data = $this->getSingleResult($sql);

        return $data->numFailed;
    }

    public function getNumDeliveredResendEmails(ClientGroupResend $resend,$account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numDelivered
        FROM client_group_resend_email pgre";
        
        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND delivered_at IS NOT NULL";
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            
            $sql .= " LEFT JOIN
                clients c1 ON pgre.client_id = c1.clientId
                LEFT JOIN accounts AS a2 ON c1.account = a2.accountId   WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND delivered_at IS NOT NULL AND a2.branch = " . $account->getBranch();
        } else {

            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            // $sql .= " LEFT JOIN
            //     clients ON pgre.client_id = clients.clientId WHERE pgre.resend_id ={$resendId}
            //     AND pgre.is_failed = 0 AND delivered_at IS NOT NULL AND clients.account = " . $account->getAccountId();
            $sql .= " LEFT JOIN
                    clients ON pgre.client_id = clients.clientId 
                    LEFT JOIN
                    client_group_resends AS pgr ON pgre.resend_id = pgr.id WHERE pgre.resend_id ={$resendId} AND (pgr.account_id =" . $account->getAccountId()." OR
                        clients.account = " . $account->getAccountId()." ) AND pgre.is_failed = 0 AND delivered_at IS NOT NULL";
        }
        // WHERE pgre.resend_id = " . $resend->getId() . "
        // AND delivered_at IS NOT NULL";

        $data = $this->getSingleResult($sql);

        return $data->numDelivered;
    }

    public function getNumBouncedResendEmails(ClientGroupResend $resend,$account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numBounced
        FROM client_group_resend_email pgre";
        
        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND bounced_at IS NOT NULL";
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            
            $sql .= " LEFT JOIN
                clients c1 ON pgre.client_id = c1.clientId
                LEFT JOIN accounts AS a2 ON c1.account = a2.accountId   WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND bounced_at IS NOT NULL AND a2.branch = " . $account->getBranch();
        } else {

            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            // $sql .= " LEFT JOIN
            //     clients ON pgre.client_id = clients.clientId WHERE pgre.resend_id ={$resendId}
            //     AND pgre.is_failed = 0 AND bounced_at IS NOT NULL AND clients.account = " . $account->getAccountId();
            $sql .= " LEFT JOIN
                    clients ON pgre.client_id = clients.clientId 
                    LEFT JOIN
                    client_group_resends AS pgr ON pgre.resend_id = pgr.id WHERE pgre.resend_id ={$resendId} AND (pgr.account_id =" . $account->getAccountId()." OR
                        clients.account = " . $account->getAccountId()." ) AND pgre.is_failed = 0 AND bounced_at IS NOT NULL";
        }
        // WHERE pgre.resend_id = " . $resend->getId() . "
        // AND bounced_at IS NOT NULL";

        $data = $this->getSingleResult($sql);

        return $data->numBounced;
    }

    public function getNumOpenedResendEmails(ClientGroupResend $resend,$account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numOpened
        FROM client_group_resend_email pgre";

        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND opened_at IS NOT NULL";
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            
            $sql .= " LEFT JOIN
                clients c1 ON pgre.client_id = c1.clientId
                LEFT JOIN accounts AS a2 ON c1.account = a2.accountId   WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND opened_at IS NOT NULL AND a2.branch = " . $account->getBranch();
        } else {

            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            // $sql .= " LEFT JOIN
            //     clients ON pgre.client_id = clients.clientId WHERE pgre.resend_id ={$resendId}
            //     AND pgre.is_failed = 0 AND opened_at IS NOT NULL AND clients.account = " . $account->getAccountId();
            $sql .= " LEFT JOIN
                    clients ON pgre.client_id = clients.clientId 
                    LEFT JOIN
                    client_group_resends AS pgr ON pgre.resend_id = pgr.id WHERE pgre.resend_id ={$resendId} AND (pgr.account_id =" . $account->getAccountId()." OR
                        clients.account = " . $account->getAccountId()." ) AND pgre.is_failed = 0 AND opened_at IS NOT NULL";
        }
        // WHERE pgre.resend_id = " . $resend->getId() . "
        // AND opened_at IS NOT NULL";

        $data = $this->getSingleResult($sql);

        return $data->numOpened;
    }

    public function getNumUnopenedResendEmails(ClientGroupResend $resend,$account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numUnopened
        FROM client_group_resend_email pgre";
        
        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND opened_at IS NULL";
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            
            $sql .= " LEFT JOIN
                clients c1 ON pgre.client_id = c1.clientId
                LEFT JOIN accounts AS a2 ON c1.account = a2.accountId   WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND opened_at IS NULL AND a2.branch = " . $account->getBranch();
        } else {

            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            // $sql .= " LEFT JOIN
            //     clients ON pgre.client_id = clients.clientId WHERE pgre.resend_id ={$resendId}
            //     AND pgre.is_failed = 0 AND opened_at IS NULL AND clients.account = " . $account->getAccountId();
            $sql .= " LEFT JOIN
                    clients ON pgre.client_id = clients.clientId 
                    LEFT JOIN
                    client_group_resends AS pgr ON pgre.resend_id = pgr.id WHERE pgre.resend_id ={$resendId} AND (pgr.account_id =" . $account->getAccountId()." OR
                        clients.account = " . $account->getAccountId()." ) AND pgre.is_failed = 0 AND opened_at IS NULL";
        }
        // WHERE pgre.resend_id = " . $resend->getId() . "
        // AND opened_at IS NULL";

        $data = $this->getSingleResult($sql);

        return $data->numUnopened;
    }

    public function getNumClickedResendEmails(ClientGroupResend $resend,$account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numClicked
        FROM client_group_resend_email pgre";

        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND clicked_at IS NOT NULL";
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            
            $sql .= " LEFT JOIN
                clients c1 ON pgre.client_id = c1.clientId
                LEFT JOIN accounts AS a2 ON c1.account = a2.accountId   WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND clicked_at IS NOT NULL AND a2.branch = " . $account->getBranch();
        } else {

            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            // $sql .= " LEFT JOIN
            //     clients ON pgre.client_id = clients.clientId WHERE pgre.resend_id ={$resendId}
            //     AND pgre.is_failed = 0 AND clicked_at IS NOT NULL AND clients.account = " . $account->getAccountId();
            $sql .= " LEFT JOIN
                    clients ON pgre.client_id = clients.clientId 
                    LEFT JOIN
                    client_group_resends AS pgr ON pgre.resend_id = pgr.id WHERE pgre.resend_id ={$resendId} AND (pgr.account_id =" . $account->getAccountId()." OR
                        clients.account = " . $account->getAccountId()." ) AND pgre.is_failed = 0 AND clicked_at IS NOT NULL";
        }
        // WHERE pgre.resend_id = " . $resend->getId() . "
        // AND opened_at IS NOT NULL";

        $data = $this->getSingleResult($sql);

        return $data->numClicked;
    }
    
    function getUnopenedProposalsStatusCount($resend_id){

        $sql = "SELECT p.proposalStatus, pgre.proposal_status_id, pgre.proposal_id
        FROM proposal_group_resend_email pgre 
        LEFT JOIN proposals p ON pgre.proposal_id = p.proposalId
        WHERE pgre.opened_at IS NULL
        AND pgre.resend_id = ".$resend_id;

        
        $proposals = $this->getAllResults($sql);

        $sql2 = "SELECT pgre.proposal_id
        FROM proposal_group_resend_email pgre 
        
        WHERE pgre.resend_id = ".$resend_id;

        
        $proposals_count = $this->getAllResults($sql2);
        $data =array();
        $data['total_opened'] = count($proposals);
        $data['total_proposals'] = count($proposals_count);
        $total_not_sent = 0;
        foreach($proposals as $proposal){
            if($proposal->proposalStatus != $proposal->proposal_status_id){
                $total_not_sent++;
            }
        }
        $data['total_not_sent'] = $total_not_sent;
        $data['total_resending'] = $data['total_opened'] - $total_not_sent;
        return $data;
      }

      public function getChildResend($resend_id){

        $sql = "SELECT cgr.id,cgr.resend_name
        FROM client_group_resends cgr 
        
        WHERE cgr.parent_resend_id = " . $resend_id." order by id desc" ;

        return $this->getAllResults($sql);

    }
    public function getClientTemplateFields(){
        $sql = "SELECT cetpf.*
        FROM client_email_template_type_fields cetpf 
        WHERE cetpf.template_type='5'";
        return $this->getAllResults($sql);

    }

    public function sendOwnerAccountCC($emailData, $account,$owner_email_list){

        $basicEmailData = [
            'fromName' => SITE_NAME,
            'fromEmail' => 'noreply@' . SITE_EMAIL_DOMAIN,
            'subject' => 'Email Client Campaign Notification',
            'body' => $account->getFullName().' sent Emails on your Proposal. Your email is shown below. <br/><br/><hr/><br/>'.$emailData['body'],
            'replyTo' => '',
        ];
        //send email to client and bcc / additional mails
        
        
        
        $clientEmailData = $basicEmailData;
       
        for($i=0;$i<count($owner_email_list);$i++){

            if($account->getEmail() !=$owner_email_list[$i]){
        
                $clientEmailData['to'] = $owner_email_list[$i];

                $this->getEmailRepository()->send($clientEmailData);
            }

        }
        
            // $CI =& get_instance();

            // $CI->load->library('jobs');

            // // Save the opaque image
            // $CI->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'group_proposal_resend', $clientEmailData, 'test job');

    }

    
    public function getClientNotesCount($client_id){
        $sql = "SELECT COUNT(notes.noteId) as ncount
        FROM notes  
        WHERE type = 'client' AND relationId=".$client_id;
        return $this->getAllResults($sql)[0];
    }

    function getAccountClients($account_id){
        

        $sql = "SELECT c.clientId 
                FROM clients c 
                WHERE  c.client_account =".$account_id;

       
        $data = $this->db->query($sql)->result();
        
        return $data;


    }

    public function checkClientBusinessTypeAssignment($clientId,$business_type_id,$company_id){
        $CI =& get_instance();
        $dql = "SELECT bta.id
        FROM \models\BusinessTypeAssignment bta
        WHERE bta.client_id = :clientId AND bta.business_type_id = :businessTypeId";
        
        $query = $CI->em->createQuery($dql);

        $query->setParameter('clientId', $clientId);
        $query->setParameter('businessTypeId', $business_type_id);

        $total = $query->getResult();

        if(count($total) < 1){
            $assignment = new \models\BusinessTypeAssignment();
            $assignment->setBusinessTypeId($business_type_id);
            $assignment->setCompanyId($company_id);
            $assignment->setClientId($clientId);
            $this->em->persist($assignment);
        }
    }

    public function getClientBusinessTypes($client_id){
        $sql = "SELECT bta.business_type_id,bt.type_name
        FROM business_type_assignments bta 
        LEFT JOIN business_types bt ON bta.business_type_id = bt.id
        WHERE bta.client_id=".$client_id;
        return $this->getAllResults($sql);

    }

    /**
     * @param $clientId
     */
    public function flagProposalsForRebuild($clientId)
    {
        if ($clientId) {
            $query = "UPDATE proposals p
              SET rebuildFlag = 1
              WHERE p.client = {$clientId}";
            $this->db->query($query);
        }
    }


    function getClientSavedFilters($account)
    {
        $sql = "SELECT spf.*
        FROM saved_proposal_filter spf WHERE user_id = ".$account->getAccountId()." AND filter_page = 'Client' ORDER BY ord";

        return $this->getAllResults($sql);
    }

    function updateProposalCount($client_id)
    {
        
        $sql = "SELECT count(proposalId) as p_count FROM proposals WHERE duplicateOf IS NULL AND client = ".$client_id;
        $proposals_count = $this->db->query($sql)->result();
        
        $this->db->query('update clients set proposals_count=? where clientId=? limit 1',
                    array($proposals_count[0]->p_count, $client_id));

        $this->updateProposalBidTotal($client_id);
    }

    function updateProposalBidTotal($client_id)
    {
        
        $sql = "SELECT SUM(price) as bid_total FROM proposals WHERE duplicateOf IS NULL AND client = ".$client_id;
        $proposals_count = $this->db->query($sql)->result();
        
        $this->db->query('update clients set bid_total=? where clientId=? limit 1',
                    array($proposals_count[0]->bid_total, $client_id));
    }
}