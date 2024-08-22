<?php
namespace Pms\Repositories;

use Carbon\Carbon;
use League\Csv\Writer;
use models\Companies;
use models\ProspectGroupResend;
use models\ProspectGroupResendEmail;
use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;

class Prospect extends RepositoryAbstract
{
    use DBTrait;

    public function get($id)
    {
        return $this->getSingleResult("select * from prospects where prospectId = {$id}");
    }

    public function groupSend(array $ids, $emailData, \models\Accounts $account, $logAction = 'proposal_send', $logMessage = null, $pgsId = NULL, $pgsName = NULL)
    {
        $CI =& get_instance();
        $CI->load->library('jobs2', NULL, 'my_jobs');
        $count = 0;
        $alreadySentCount = 0;
        $unsentCount = 0;
        $alreadySentCount =0;
        $duplicateEmailCount =0;
        $check_sent_email = true;
        $check_email_list =[];
        $owner_email_list = [];
        $check_propsect_ids_list =[];
        if($pgsId != -1){

        
            $pgs = $this->em->find('\models\ProspectGroupResend', $pgsId);

            if (!$pgs) {
                $pgs = new ProspectGroupResend();
                $pgs->setAccountId($account->getAccountId());
                $pgs->setCompanyId($account->getCompany()->getCompanyId());
                $pgs->setAccountName($account->getFullName());
                $pgs->setSubject($emailData['subject']);
                $pgs->setEmailCc($emailData['emailCC']);
                $pgs->setCustomSender(($emailData['fromName']) ? 1 : 0);
                $pgs->setCustomSenderName($emailData['fromName']);
                $pgs->setCustomSenderEmail($emailData['fromEmail']);
                $pgs->setFilters(json_encode($emailData['prospect_filter'],JSON_HEX_APOS));
                $pgs->setResendName($pgsName);
                $check_sent_email = false;
            }else{
                $sql = "SELECT pgre.prospect_id,pgre.email_address FROM prospect_group_resend_email pgre WHERE pgre.resend_id =".$pgs->getId(); 
                $all_sent_emails =$this->getAllResults($sql);

                foreach($all_sent_emails as $all_sent_email){
                    array_push($check_email_list,strtolower($all_sent_email->email_address));
                    array_push($check_propsect_ids_list,$all_sent_email->prospect_id);
                }
                

            }


            $pgs->setIpAddress($_SERVER['REMOTE_ADDR']);
            $pgs->setEmailContent($emailData['body']);
            $pgs->setCreated(Carbon::now());
            $this->em->persist($pgs);
            $this->em->flush();
        }else{
            $check_sent_email =false;
        }

        foreach ($ids as $prospectId) {
            try{
                $sendIt = true;
                $thisEmailData = $emailData;

            if ($sendIt) {
                if ($check_sent_email) {

                    // $resend = $this->em->getRepository('models\ProspectGroupResendEmail')->findOneBy(array(
                    //     'resend_id' => $pgs->getId(),
                    //     'proposal_id' => $prospectId
                    // ));
                    if(in_array($prospectId, $check_propsect_ids_list)){
                        $alreadySentCount++;
                        continue;
                    }
                    

                }
                $prospect = $this->em->findProspect($prospectId);
                if($prospect){

                    if ($prospect->getEmail()) {

                        if(in_array(strtolower($prospect->getEmail()), $check_email_list)){
                            $duplicateEmailCount++;
                            continue;
                        }
                        if ($prospect->getAccount()) {
    
                            $prospectAccount = $this->em->findAccount($prospect->getAccount());
                            
                            $emailFromName = ($emailData['fromName']) ?: $prospectAccount->getFullName();
                            $fromEmail = ($emailData['fromEmail']) ?: $prospectAccount->getEmail();

                            $thisEmailData['fromName'] = $emailFromName;
                            $thisEmailData['fromEmail'] = 'noreply@' . SITE_EMAIL_DOMAIN;
                            $thisEmailData['replyTo'] = $fromEmail;
               
                            $to = $prospect->getEmail();
                            if(!in_array($prospectAccount->getEmail(), $owner_email_list)){
                                array_push($owner_email_list,$prospectAccount->getEmail());
                            }
                            if($pgsId != -1){
                                $pgse = new ProspectGroupResendEmail();
                                $pgse->setResendId($pgs->getId());
                                $pgse->setProspectId($prospectId);
                                $pgse->setEmailAddress($to);
                            

                                $this->em->persist($pgse);
                                $this->em->flush();
                                $pgseId = $pgse->getId();
                                $pgsId =$pgs->getId();
                            }else{
                                $pgseId = NULL;
                                $pgsId = NULL;
                            }
                           

                    $thisEmailData['to'] = $to;
                    
                    $thisEmailData['uniqueArg'] = 'prospect_resend_email_id';
                    $thisEmailData['uniqueArgVal'] = $pgseId;
                    $thisEmailData['prospectId'] = $prospectId;
                    $thisEmailData['campaignId'] = $pgsId;

                    array_push($check_email_list,strtolower($to));
                    $event_id = $this->getProposalEventRepository()->createEmailEvent('Prospect',$prospectId,$account,$thisEmailData['to'],$thisEmailData['body'],$thisEmailData['subject'],'',$thisEmailData['fromName'],$thisEmailData['fromEmail']);
                    $thisEmailData['uniqueArg2'] = 'email_event';
                    $thisEmailData['uniqueArg2Val'] = $event_id;

                    $etp = new \EmailTemplateParser();
                    $etp->setProspect($prospect);
                    $etp->setAccount($prospectAccount);

                    $thisEmailData['subject'] = $etp->parse($thisEmailData['subject']);
                    $thisEmailData['body'] = $etp->parse($thisEmailData['body']);

                    //$this->getEmailRepository()->send($thisEmailData);

                    $CI->my_jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'send_individual_prospect_email',$thisEmailData,'test job');
                    // $CI =& get_instance();
                    // $CI->load->library('jobs');
                    // $CI->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'group_prospect_resend',$thisEmailData,'test job');
                   
                    $count++;
                }
            }
        }

            } else {
                $unsentCount++;
            }

            } catch (\Exception $e) {
                // Do nothing
            }
        }

        if ($count) {
            //log group action
            if($pgsId != -1){
                $this->getLogRepository()->add([
                    'action' => 'group_action_send',
                    'details' => "Campaign '".$pgsName."' Sent Prospect to {$count} Prospects",
                    'account' => $account->getAccountId(),
                    'company' => $account->getCompany()->getCompanyId(),
                ]);

                
                $job_array = [
                    'email_data' => $emailData,
                    'account_id' => $account->getAccountId(),
                    'pgsId' => $pgsId,
                ];
                
                $CI->my_jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'send_job_prospect_completed_mail',$job_array,'test job');
                
            }

            //$this->sendAccountCC($emailData, $account,$count);
            //$this->sendOwnerAccountCC($emailData, $account,$owner_email_list);
        }

        $out = [
            'sent' => $count,
            'unsent' => $unsentCount,
            'already_sent' => $alreadySentCount
        ];

        return $out;
    }

    public function getCompanyProspectResendList(Companies $company,$account)
    {

        $sql = "SELECT pgr.resend_name,pgr.id FROM prospect_group_resends pgr ";
                //WHERE pgr.company_id = " . (int)$company->getCompanyId()." AND pgr.is_deleted =0 AND pgr.parent_resend_id IS NULL order by id desc";


                if ($account->isAdministrator() && $account->hasFullAccess()) {
                    //branch admin, can access only his branch
                    $sql .= ' WHERE  pgr.company_id=' . $company->getCompanyId();
                }else if ($account->isBranchAdmin()) {
                    //branch admin, can access only his branch
                    $sql .= ' INNER JOIN prospect_group_resend_email AS pgre ON pgr.id = pgre.resend_id LEFT JOIN
                    prospects p1 ON pgre.prospect_id = p1.prospectId
                    LEFT JOIN accounts AS a2 ON p1.account = a2.accountId   WHERE a2.branch = ' . $account->getBranch() . '
                        AND pgr.company_id=' . $company->getCompanyId();
                } else {
        
                    //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
        
                    $sql .= ' WHERE pgr.id IN(SELECT DISTINCT
                    (pgre.resend_id)
                FROM
                prospect_group_resend_email pgre
                        LEFT JOIN
                        prospects ON pgre.prospect_id = prospects.prospectId
                WHERE
                prospects.account = ' . $account->getAccountId().' AND pgre.is_failed =0) ';
                }
        
                $sql .=" AND pgr.is_deleted =0 order by id desc";
        return $this->getAllResults($sql);

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
            $failed_subquery = " (SELECT SUM(pgre2.is_failed) FROM prospect_group_resend_email AS pgre2 WHERE pgre2.resend_id = pgr.id ) AS failed";
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            $failed_subquery = " (SELECT SUM(pgre2.is_failed) FROM prospect_group_resend_email AS pgre2   
            
            LEFT JOIN prospects p1 ON pgre2.prospect_id = p1.prospectId
            LEFT JOIN accounts AS a2 ON p1.account = a2.accountId
            WHERE pgre2.resend_id = pgr.id 
            a2.branch = " . $account->getBranch() . "
                AND pgr.company_id=" . $company->getCompanyId()."
            ) AS failed";
            
        } else {
            $failed_subquery = " (SELECT SUM(pgre2.is_failed) FROM prospect_group_resend_email AS pgre2
            LEFT JOIN prospects p1 ON pgre2.prospect_id = p1.prospectId
                WHERE pgre2.resend_id = pgr.id  AND (pgr.account_id =" . $account->getAccountId()." OR
                p1.account = " . $account->getAccountId()." )) AS failed";
        
        }

        $sql = "SELECT pgr.*,a.firstname,a.lastname,pgrp.resend_name as parent_name,
                    
                    COUNT(pgre.delivered_at) AS delivered,
                    COUNT(pgre.id) AS total_resend,
                    COUNT(pgre.bounced_at) AS bounced,
                    COUNT(pgre.opened_at) AS opened,
                    COUNT(pgre.clicked_at) as clicked,
                    COUNT(pgre.sent_at) AS sent_count,
                    ".$failed_subquery.",
                    (COUNT(pgre.clicked_at) / COUNT(pgre.id)) AS cct,
                    (COUNT(pgre.opened_at) / COUNT(pgre.id)) AS pct 
                    FROM prospect_group_resends pgr 
                    LEFT JOIN prospect_group_resend_email AS pgre ON pgr.id = pgre.resend_id
                    LEFT JOIN accounts AS a ON pgr.account_id = a.accountId 
                    LEFT JOIN prospect_group_resends AS pgrp ON pgr.parent_resend_id = pgrp.id";

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
            // $sql .= ' WHERE a.branch = ' . $account->getBranch() . '
            //     AND lgr.company_id=' . $company->getCompanyId();
                $sql .= ' LEFT JOIN
                prospects p1 ON pgre.prospect_id = p1.prospectId
            LEFT JOIN accounts AS a2 ON p1.account = a2.accountId   WHERE a2.branch = ' . $account->getBranch() . '
                AND pgr.company_id=' . $company->getCompanyId();
        } else {


            $sql .= " LEFT JOIN
            prospects p1 ON pgre.prospect_id = p1.prospectId WHERE (pgr.account_id =" . $account->getAccountId()." OR
            p1.account = " . $account->getAccountId()." )";
        }
       
        $sql .= ' AND pgr.is_deleted=0 AND pgre.is_failed = 0 ';
        //echo $sql;die;
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

        $sql .= " ORDER BY " . $sortCols[$sortCol] . ' ' . $sortDir;

        // Handle Limit
        if ($this->ci->input->get('length') && !$count) {
            $sql .= ' LIMIT ' . $this->ci->input->get('length');
            $sql .= ' OFFSET ' . $this->ci->input->get('start');
        }
        

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
            if($data->failed > 0){
                $failed_info = '<a href="/prospects/resend/' . $data->id . '/failed" class="right" style="position: absolute;right: 0;"><i class="fa fa-fw fa-info-circle tiptip" style="color: #000;font-size: 14px;" title="'.$data->failed.' Prospect email Failed to send" ></i></a>';
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
                        <a href="../prospects/resend/'.$data->id.'" class="show_email_content22 " ><i class="fa fa-fw fa-user"></i> View Prospects</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" data-val="'.$data->id.'" class="delete_campaign " ><i class="fa fa-fw fa-trash"></i> Delete Campaign</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" data-val="'.$data->id.'" class="resend_upopened " data-unclicked="0"><i class="fa fa-fw fa-share-square"></i> Resend Unopened Eamils</a>
                    </li>
                    <li>
                        <a href="javascript:void(0);" data-val="'.$data->id.'" class="resend_upopened " data-unclicked="1"><i class="fa fa-fw fa-share-square"></i> Resend Unclicked Emails</a>
                    </li>
                        
                    </ul>
                </div>
            </div>';
            $total_resend = '<div style="position: relative;"><a href="/prospects/resend/' . $data->id . '">' . $data->total_resend . '</a>'.$failed_info.'</div>';
            if($data->sent_count < $data->total_resend){
                $total_sending = $data->total_resend;
                if($data->failed>0){
                    $total_sending = $data->failed + $total_sending;
                }
                $total_resend = '<div style="position: relative;"><a href="/leads/resend/' . $data->id . '">' .$data->sent_count.' / '. $total_sending . '</a>'.$failed_info.'</div>';
                $create_date .= ' <i class="fa fa-fw fa-info-circle tiptip" style="color: #000;font-size: 14px;" title="Campaign is in progress" ></i>';
            }
            $delivered = '<a href="/prospects/resend/' . $data->id . '/delivered">' . $data->delivered . '</a>';
            $bounced = '<a href="/prospects/resend/' . $data->id . '/bounced">' . $data->bounced . '</a>';
            $opened = '<div style="display: flex;justify-content: space-between;"><a href="/prospects/resend/' . $data->id . '/opened">' . $data->opened . '</a><a href="/prospects/resend/' . $data->id . '/opened">' . $open_p . '%</a></div>';
            $link_open_p = '<a href="/prospects/resend/' . $data->id . '/opened">' . $open_p . '%</a>';
            $clicked = '<div style="display: flex;justify-content: space-between;"><a href="/prospects/resend/' . $data->id . '/clicked">' . $data->clicked . '</a><a  href="/prospects/resend/' . $data->id . '/clicked">' . $click_p . '%</a></div>';
            $link_click_p = '<a class="tiptip" title="'.$data->clicked.' Clicks" href="/prospects/resend/' . $data->id . '/clicked">' . $click_p . '%</a>';
    
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

    public function groupSendUnopened($emailData, \models\Accounts $account, $logAction = 'client_send', $logMessage = null, $cgsId = NULL,$unclicked = NULL)
    {
        $CI =& get_instance();
        $CI->load->library('jobs2', NULL, 'my_jobs');
        $count = 0;
        $alreadySentCount = 0;
        $unsentCount = 0;
        $duplicateEmailCount =0;
        $bouncedUnsentCount =0;
        $check_sent_email = true;
        $check_email_list =[];

        $parentResend = $this->em->find('\models\ProspectGroupResend', $cgsId);

        $parentFilter = json_decode($parentResend->getFilters());
        $parentFilter->pResendType = ($unclicked=='1') ? 'Unclicked' : 'Unopened';

        
        $cgs = new ProspectGroupResend();
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
        $cgs->setFilters(json_encode($parentFilter,JSON_HEX_APOS));
        if($unclicked == 1){
            $cgs->setResendType(2);
        } else {
            $cgs->setResendType(1);
        }
        $cgs->setCreated(Carbon::now());
        $this->em->persist($cgs);
        $this->em->flush();

        $sql = "SELECT pgre.prospect_id,pgre.id,pgre.email_address,pgre.bounced_at
        FROM prospect_group_resend_email pgre"; 

        if($unclicked=='1'){
            $sql .= " WHERE pgre.opened_at IS NOT NULL AND pgre.clicked_at IS NULL
            AND pgre.resend_id = ".$cgsId;
        }else{
            $sql .= " WHERE pgre.opened_at IS NULL
            AND pgre.resend_id = ".$cgsId;
        }
        $sql .= " AND pgre.is_failed = 0";
        
        $Resend_campaigns = $this->getAllResults($sql);
        foreach ($Resend_campaigns as $Resend_campaign) {
            $thisEmailData = $emailData;
            $sendIt = true;
            $bounced =false;
            $prospect_id = $Resend_campaign->prospect_id;
            $prospect = $this->em->findProspect($prospect_id);
              
            

            if ($sendIt) {
               
             
              if(in_array($prospect->getEmail(), $check_email_list)){
                $duplicateEmailCount++;
                continue;
             }
                //Event Log
                //$this->getProposalEventRepository()->sendProposalCampaign($proposal, $account);
                $prospectAccount = $this->em->findAccount($prospect->getAccount());

                    $emailFromName = ($emailData['fromName']) ?: $prospectAccount->getFullName();
                    $fromEmail = ($emailData['fromEmail']) ?: $prospectAccount->getEmail();

                    $thisEmailData['fromEmail'] = 'noreply@' . SITE_EMAIL_DOMAIN;
                    $thisEmailData['replyTo'] = ($fromEmail) ;

                    $thisEmailData['fromName'] = $emailFromName;
                    

                $to = $prospect->getEmail();

                $cgse = new ProspectGroupResendEmail();
                $cgse->setResendId($cgs->getId());
                $cgse->setProspectId($prospect_id);
                $cgse->setEmailAddress($to);
                //$cgse->setProposalStatusId($proposal->getStatus());
                $cgse->setParentResendEmailId($Resend_campaign->id);
                $this->em->persist($cgse);
                $this->em->flush();
                $cgseId = $cgse->getId();
                $cgsId =$cgs->getId();

              $thisEmailData['to'] = $to;
              
              $thisEmailData['uniqueArg'] = 'prospect_resend_email_id';
              $thisEmailData['uniqueArgVal'] = $cgse->getId();
              $thisEmailData['prospectId'] = $prospect_id;
              $thisEmailData['campaignId'] = $cgsId;

              array_push($check_email_list,strtolower($to));
            $event_id = $this->getProposalEventRepository()->createEmailEvent('Prospect',$prospect_id,$account,$thisEmailData['to'],$thisEmailData['body'],$thisEmailData['subject'],'',$thisEmailData['fromName'],$thisEmailData['fromEmail']);
            $thisEmailData['uniqueArg2'] = 'email_event';
            $thisEmailData['uniqueArg2Val'] = $event_id;

              $etp = new \EmailTemplateParser();
                $etp->setProspect($prospect);
                $etp->setAccount($prospectAccount);

              $thisEmailData['subject'] = $etp->parse($thisEmailData['subject']);
              $thisEmailData['body'] = $etp->parse($thisEmailData['body']);

              //$this->getEmailRepository()->send($thisEmailData);

              $CI->my_jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'send_individual_prospect_email',$thisEmailData,'test job');

                //   $CI =& get_instance();
                //   $CI->load->library('jobs');
                //   // Save the opaque image
                //   $CI->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'group_prospect_resend',$thisEmailData,'test job');
                //   //$this->send($clientlId, $emailData, $account, $logAction, $logMessage, $cgse->getId());
                  $count++;

            } else {
                if(!$bounced){
                    $unsentCount++;
                }
            }
        }

        if ($count) {
            //log group action
            $this->getLogRepository()->add([
                'action' => 'group_action_send',
                'details' => "Group Mail Sent to {$count} Prospects",
                'account' => $account->getAccountId(),
                'company' => $account->getCompany()->getCompanyId(),
            ]);
            //$this->sendAccountCC($emailData, $account,$count);
        }

        $out = [
            'sent' => $count,
            'unsent' => $unsentCount,
            'already_sent' => $alreadySentCount,
            'duplicateEmailCount' => $duplicateEmailCount,
            'bouncedUnsentCount' => $bouncedUnsentCount,
        ];

        return $out;
    }

    function getUnopenedProspectsStatusCount($resend_id,$clicked=false){

        $sql = "SELECT pgre.id
        FROM prospect_group_resend_email pgre"; 
        
        if($clicked){
            $sql .= " WHERE pgre.opened_at IS NOT NULL AND pgre.clicked_at IS NULL
            AND pgre.resend_id = ".$resend_id;
        }else{
            $sql .= " WHERE pgre.opened_at IS NULL
            AND pgre.resend_id = ".$resend_id;
        }
        $sql .= " AND pgre.is_failed = 0";
        
        $unopened_emails = $this->getAllResults($sql);

        $sql2 = "SELECT pgre.id
        FROM prospect_group_resend_email pgre 
        
        WHERE pgre.resend_id = ".$resend_id;

        
        $emails_count = $this->getAllResults($sql2);
        $data =array();
        $data['total_unopened'] = count($unopened_emails);
        $data['total_emails'] = count($emails_count);
        
        return $data;
      }

          /**
     * @param ProspectGroupResend $resend
     * @return array
     */
    public function getProspectResendStats(ProspectGroupResend $resend,$account)
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

    public function getNumResendEmails(ProspectGroupResend $resend,$account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numSent
        FROM prospect_group_resend_email pgre";
        
        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0";
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            
            $sql .= " LEFT JOIN
                prospects p1 ON pgre.prospect_id = p1.prospectId
                LEFT JOIN accounts AS a2 ON p1.account = a2.accountId   WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND a2.branch = " . $account->getBranch();
        } else {
    
            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            $sql .= " LEFT JOIN
                    prospects ON pgre.prospect_id = prospects.prospectId WHERE pgre.resend_id ={$resendId}
                    AND pgre.is_failed = 0 AND 
                    prospects.account = " . $account->getAccountId();
        } 
        //WHERE pgre.resend_id = " . $resend->getId();

        $data = $this->getSingleResult($sql);

        return $data->numSent;
    }

    public function getNumFailedResendEmails(ProspectGroupResend $resend,$account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(fj.id) AS numFailed
        FROM failed_jobs fj";


        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE fj.campaign_id ={$resendId} AND job_type= 'prospect_campaign' ";
        }else if ($account->isBranchAdmin()) {
            
            $sql .= " LEFT JOIN
                prospects p1 ON fj.entity_id = p1.prospectId
                LEFT JOIN accounts AS a2 ON l1.account = a2.accountId   WHERE fj.campaign_id ={$resendId} AND job_type= 'prospect_campaign' AND a2.branch = " . $account->getBranch();
                
        } else {
            $sql .= " LEFT JOIN
            prospects ON fj.entity_id = prospects.prospectId WHERE fj.campaign_id ={$resendId}
                AND job_type= 'prospect_campaign' AND 
                prospects.account = " . $account->getAccountId();

           
        }
        //WHERE pgre.resend_id = " . $resend->getId();

        $data = $this->getSingleResult($sql);

        return $data->numFailed;
    }

    public function getNumDeliveredResendEmails(ProspectGroupResend $resend,$account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numDelivered
        FROM prospect_group_resend_email pgre";
        
        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND delivered_at IS NOT NULL";
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            
            $sql .= " LEFT JOIN
                prospects p1 ON pgre.prospect_id = p1.prospectId
                LEFT JOIN accounts AS a2 ON p1.account = a2.accountId   WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND delivered_at IS NOT NULL AND a2.branch = " . $account->getBranch();
        } else {
    
            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            $sql .= " LEFT JOIN
                    prospects ON pgre.prospect_id = prospects.prospectId WHERE pgre.resend_id ={$resendId}
                    AND pgre.is_failed = 0 AND delivered_at IS NOT NULL AND prospects.account = " . $account->getAccountId();
        } 
        // WHERE pgre.resend_id = " . $resend->getId() . "
        // AND delivered_at IS NOT NULL";

        $data = $this->getSingleResult($sql);

        return $data->numDelivered;
    }

    public function getNumBouncedResendEmails(ProspectGroupResend $resend,$account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numBounced
        FROM prospect_group_resend_email pgre ";

        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND bounced_at IS NOT NULL";
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            
            $sql .= " LEFT JOIN
                prospects p1 ON pgre.prospect_id = p1.prospectId
                LEFT JOIN accounts AS a2 ON p1.account = a2.accountId   WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND bounced_at IS NOT NULL AND a2.branch = " . $account->getBranch();
        } else {
    
            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            $sql .= " LEFT JOIN
                    prospects ON pgre.prospect_id = prospects.prospectId WHERE pgre.resend_id ={$resendId}
                    AND pgre.is_failed = 0 AND bounced_at IS NOT NULL AND prospects.account = " . $account->getAccountId();
        } 
        // WHERE pgre.resend_id = " . $resend->getId() . "
        // AND bounced_at IS NOT NULL";

        $data = $this->getSingleResult($sql);

        return $data->numBounced;
    }

    public function getNumOpenedResendEmails(ProspectGroupResend $resend,$account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numOpened
        FROM prospect_group_resend_email pgre";
        
        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND opened_at IS NOT NULL";
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            
            $sql .= " LEFT JOIN
                prospects p1 ON pgre.prospect_id = p1.prospectId
                LEFT JOIN accounts AS a2 ON p1.account = a2.accountId   WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND opened_at IS NOT NULL AND a2.branch = " . $account->getBranch();
        } else {
    
            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            $sql .= " LEFT JOIN
                    prospects ON pgre.prospect_id = prospects.prospectId WHERE pgre.resend_id ={$resendId}
                    AND pgre.is_failed = 0 AND opened_at IS NOT NULL AND prospects.account = " . $account->getAccountId();
        } 

        // WHERE pgre.resend_id = " . $resend->getId() . "
        // AND opened_at IS NOT NULL";

        $data = $this->getSingleResult($sql);

        return $data->numOpened;
    }

    

    public function getNumClickedResendEmails(ProspectGroupResend $resend,$account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numClicked
        FROM prospect_group_resend_email pgre";
        
        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND clicked_at IS NOT NULL";
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            
            $sql .= " LEFT JOIN
                prospects p1 ON pgre.prospect_id = p1.prospectId
                LEFT JOIN accounts AS a2 ON p1.account = a2.accountId   WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND clicked_at IS NOT NULL AND a2.branch = " . $account->getBranch();
        } else {
    
            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            $sql .= " LEFT JOIN
                    prospects ON pgre.prospect_id = prospects.prospectId WHERE pgre.resend_id ={$resendId}
                    AND pgre.is_failed = 0 AND clicked_at IS NOT NULL AND prospects.account = " . $account->getAccountId();
        } 

        // WHERE pgre.resend_id = " . $resend->getId() . "
        // AND opened_at IS NOT NULL";

        $data = $this->getSingleResult($sql);

        return $data->numClicked;
    }

    public function getNumUnopenedResendEmails(ProspectGroupResend $resend,$account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numUnopened
        FROM prospect_group_resend_email pgre"; 

        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND opened_at IS  NULL";
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            
            $sql .= " LEFT JOIN
                prospects p1 ON pgre.prospect_id = p1.prospectId
                LEFT JOIN accounts AS a2 ON p1.account = a2.accountId   WHERE pgre.resend_id ={$resendId} AND pgre.is_failed = 0 AND opened_at IS  NULL AND a2.branch = " . $account->getBranch();
        } else {
    
            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            $sql .= " LEFT JOIN
                    prospects ON pgre.prospect_id = prospects.prospectId WHERE pgre.resend_id ={$resendId}
                    AND pgre.is_failed = 0 AND opened_at IS  NULL AND prospects.account = " . $account->getAccountId();
        } 
        // WHERE pgre.resend_id = " . $resend->getId() . "
        // AND opened_at IS NULL";

        $data = $this->getSingleResult($sql);

        return $data->numUnopened;
    }

    public function getProspectChildResend($resend_id){

        $sql = "SELECT lgr.id,lgr.resend_name
        FROM prospect_group_resends lgr 
        
        WHERE lgr.parent_resend_id = " . $resend_id ;

        return $this->getAllResults($sql);

    }

    public function getChildResend($resend_id){

        $sql = "SELECT pgr.id,pgr.resend_name
        FROM prospect_group_resends pgr 
        
        WHERE pgr.parent_resend_id = " . $resend_id." order by id desc" ;

        return $this->getAllResults($sql);

    }

    public function getProspectTemplateFields(){
        $sql = "SELECT cetpf.*
        FROM client_email_template_type_fields cetpf 
        WHERE cetpf.template_type='3'";
        return $this->getAllResults($sql);

    }

    public function sendOwnerAccountCC($emailData, $account,$owner_email_list){

        $basicEmailData = [
            'fromName' => SITE_NAME,
            'fromEmail' => 'noreply@' . SITE_EMAIL_DOMAIN,
            'subject' => 'Email Lead Campaign Notification',
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
        
            
    }

    public function getProspectBusinessTypes($prospect_id){
        $sql = "SELECT bta.business_type_id,bt.type_name
        FROM business_type_assignments bta 
        LEFT JOIN business_types bt ON bta.business_type_id = bt.id
        WHERE bta.prospect_id=".$prospect_id;
        return $this->getAllResults($sql);

    }
    public function getProspectNotesCount($prospect_id){
        $sql = "SELECT COUNT(notes.noteId) as ncount
        FROM notes  
        WHERE type = 'prospect' AND relationId=".$prospect_id;
        return $this->getAllResults($sql)[0];
    }

    public function getProspectNotes($prospect_id){
        $sql = "SELECT *
        FROM notes  
        WHERE type = 'prospect' AND relationId=".$prospect_id;
        return $this->getAllResults($sql);
    }

    function getProspectSavedFilters($account)
    {
        $sql = "SELECT spf.*
        FROM saved_proposal_filter spf WHERE user_id = ".$account->getAccountId()." AND filter_page = 'Prospect' ORDER BY ord";

        return $this->getAllResults($sql);
    }

    public function groupProspectExportCSV($account, $prospectIds)
    {
        // Get the data
        $prospectData = $account->getProspectsByIds($prospectIds);
        
        // Create the writer
        $writer = Writer::createFromFileObject(new \SplTempFileObject());

        $count =0;
        // Headings
        $headingData = [
            'Date Created',
            'Status',
            'Rating',
            'Business',
            'Company', 
            'Contact',
            'Title',
            'Owner',
        ];

        // Add the headings
        $writer->insertOne($headingData);

        // Loop through the data
        foreach ($prospectData as $row) {

            $rowData = [
                date('m/d/Y g:ia', $row->created),
                $row->status,
                $row->rating,
                $row->types,
                $row->companyName,
                $row->firstName . ' ' . $row->lastName,
                $row->title,
                $row->FN . ' ' . $row->LN,
            ];
            $writer->insertOne($rowData);
            $count ++;
        };
        
        if ($count > 0) {
            $this->getLogRepository()->add([
                'action' => \models\ActivityAction::PROSPECT_EXPORT,
                'details' => " {$count} Prospects Export",
                'account' => $account->getAccountId(),
                'company' => $account->getCompany()->getCompanyId(),
            ]);
        }

        // Output the csv
        return $writer->output();
    }

}