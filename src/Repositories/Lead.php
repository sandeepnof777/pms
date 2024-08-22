<?php
namespace Pms\Repositories;

use Carbon\Carbon;
use League\Csv\Writer;
use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;
use \models\Leads;
use \models\Accounts;
use models\Companies;
use models\LeadGroupResend;
use models\LeadGroupResendEmail;

class Lead extends RepositoryAbstract
{
    use DBTrait;

    /**
     * Gets the requested services based on the saved CSV ids.
     * @param $csvIDs
     * @return mixed
     */
    public function getRequestedServices($csvIDs)
    {
        return $this->getSingleResult("select group_concat(s.serviceName SEPARATOR ', ') as requested_work from services s where s.serviceId in ($csvIDs)", 'array');
    }

    /**
     * Gets an array of information set up as the fields we have for emails sending out
     * @param $leadId
     * @return array
     */
    public function getEmailInformation($leadId)
    {
        $sql = "select l.projectName as project_name, l.companyName as company_name, concat(l.firstName, ' ', l.lastName) as contact, l.services as serviceIDs,
l.title as contact_title, l.businessPhone as phone, concat(l.projectAddress, ' ', l.projectCity, ' ', l.projectState, ', ', l.projectZip) as address,
l.notes, l.projectPhone, concat(l.address, ' ', l.city, ' ', l.state, ' ', l.zip) as leadAddress, l.projectContact, l.email
from leads l where l.leadId = {$leadId}";
        $leadInfo = $this->getSingleResult($sql, 'array');
        $serviceIDs = ($leadInfo['serviceIDs']) ?: '-1';
        $requested_services = $this->getRequestedServices($serviceIDs);
        return array_merge($leadInfo, $requested_services);
    }

    /**
     * Cleans old leads from the system
     */
    public function deleteOldLeads()
    {
        $timestamp = time() - (90 * 86400); //90 days ago
        $this->db->query("delete from leads where status = 'Cancelled' and created <= {$timestamp}");
    }

    public function get($id)
    {
        return $this->getSingleResult('SELECT * FROM leads WHERE leadId=' . $id);
    }

    public function moveTemporaryAttachment($lead_id, $fileName, $filePath)
    {
        $temporaryUploadDir = UPLOADPATH . '/leads/temp/';
        $uploadDir = UPLOADPATH . '/leads/' . $lead_id . '/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir);
        }
        copy($temporaryUploadDir . $filePath, $uploadDir . $filePath);
        unlink($temporaryUploadDir . $filePath);
        $this->addAttachment($lead_id, $fileName, $filePath);
    }

    public function addAttachment($lead_id, $fileName, $filePath)
    {
        $this->insert('lead_attachments', [
            'lead_id' => $lead_id,
            'file_name' => $fileName,
            'file_path' => $filePath,
        ]);
    }

    public function getAttachments($lead_id)
    {
        return $this->getAllResults("select * from lead_attachments where lead_id={$lead_id}");
    }

    public function removeAttachment($id)
    {
        $this->query('DELETE FROM lead_attachments WHERE id=' . $id);
    }

    public function getAttachmentsEmailFormatted($leadId)
    {
        $attachments = $this->getAttachments($leadId);
        if (!count($attachments)) {
            return 'No Attachments';
        }
        $attachmentsString = '<ul>';
        foreach ($attachments as $attachment) {
            $path = site_url('uploads/leads/' . $leadId . '/' . $attachment->file_path);
            $attachmentsString .= "<li><a href='{$path}'>{$attachment->file_name}</a></li>";
        }
        $attachmentsString .= '</ul>';
        return $attachmentsString;
    }

    public function editAttachmentName($id, $name)
    {
        $this->query("update lead_attachments set file_name='{$name}' where id={$id}");
    }

    /**
     * @param Leads $lead
     * @return array
     */
    public function getLeadNotes(Leads $lead)
    {
        $dql = "SELECT n FROM models\Notes n 
          WHERE n.type = 'lead'
          AND n.relationId = :leadId
          ORDER BY n.added DESC";

        $query = $this->em->createQuery($dql);
        $query->setParameter('leadId', $lead->getLeadId());

        return $query->getResult();
    }

    function getLeadsByCreatedDate(Accounts $account, Array $userIds, Carbon $startDate, Carbon $endDate)
    {
        $dql = "SELECT l FROM models\Leads l 
          WHERE l.company = :companyId
          AND l.created >= :startTime
          AND l.created <= :finishTime
          AND l.account IN (:userIds)
          ORDER BY l.created ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter('companyId', $account->getCompanyId());
        $query->setParameter('startTime', $startDate->timestamp);
        $query->setParameter('finishTime', $endDate->timestamp);
        $query->setParameter('userIds', $userIds);
        return $query->getResult();
    }

    function getParentLeadsByCreatedDate(Array $userIds, Carbon $startDate, Carbon $endDate)
    {
        $dql = "SELECT l FROM models\Leads l 
          
          WHERE l.created >= :startTime
          AND l.created <= :finishTime
          AND l.account IN (:userIds)
          ORDER BY l.created ASC";

        $query = $this->em->createQuery($dql);
        
        $query->setParameter('startTime', $startDate->timestamp);
        $query->setParameter('finishTime', $endDate->timestamp);
        $query->setParameter('userIds', $userIds);
        return $query->getResult();
    }

    /**
     * @param Leads $lead
     * @return string
     */
    public function getLeadServicesString(Leads $lead) {

        $leadServices = explode(',', $lead->getServices());
        $serviceNames = [];

        foreach ($leadServices as $serviceId) {
            $service = $this->em->findService($serviceId);

            if ($service) {
                $serviceNames[] = $service->getServiceName();
            }
        }

        return implode(', ', $serviceNames);
    }

    public function sendLeadEmail(Accounts $account, Leads $lead, $reassigning = false)
    {
        // Load the instance and the system email library
        $CI =& get_instance();
        $CI->load->model('system_email');

        // Flag for account - may not be assigned
        $assignedAccount = false;

        // If we have an account, load it
        if ($lead->getAccount()) {
            $assignedAccount = $this->em->findAccount($lead->getAccount());
        }

        $btArray = $this->getLeadBusinessTypes($lead->getLeadId());
        $btnames =[];
            foreach($btArray as $bt){
                array_push($btnames,$bt->type_name);
            }
        $btnames  = implode(',',$btnames);
        // Only proceed if we have the account
        if ($assignedAccount) {
            $emailData = [
                'first_name' => $assignedAccount->getFirstName(),
                'last_name' => $assignedAccount->getLastName(),
                'project_name' => $lead->getProjectName(),
                'company_name' => $lead->getCompanyName(),
                'requested_work' => $this->getLeadServicesString($lead),
                'contact' => $lead->getFirstName() . ' ' . $lead->getLastName(),
                'contact_title' => $lead->getTitle(),
                'phone' => $lead->getBusinessPhone(),
                'cellPhone' => $lead->getCellPhone(),
                'address' => $lead->getProjectAddress() . ' ' . $lead->getProjectCity() . ' ' . $lead->getProjectState() . ', ' . $lead->getProjectZip(),
                'notes' => nl2br($lead->getNotes()),
                'projectPhone' => $lead->getProjectPhone(),
                'projectCellPhone' => $lead->getProjectCellPhone(),
                'leadAddress' => $lead->getAddress() . ' ' . $lead->getCity() . ' ' . $lead->getState() . ' ' . $lead->getZip(),
                'projectContact' => $lead->getProjectContact(),
                'email' => $lead->getEmail(),
                'auditUrl' => $lead->getPsaAuditUrl(),
                'auditSmsUrl' => $lead->getPsaSmsUrl(),
                'attachments' => $this->getAttachmentsEmailFormatted($lead->getLeadId()),
                'business_types' => $btnames,
            ];


            // Check if we're reassigning and use the correct template
            if ($reassigning) {
                // New lead template as it's fr a new user
                if ($lead->getPsaAuditUrl()) {
                    $templateId = 18;
                } else {
                    $templateId = 5;
                }
            } else {
                // Updated template as it's for same user
                if ($lead->getPsaAuditUrl()) {
                    $templateId = 28;
                } else {
                    $templateId = 27;
                }
            }

            $args = [
                'uniqueArg' => 'lead',
                'uniqueArgVal' => $lead->getLeadId()
            ];

            // Log it
            $this->getLogRepository()->add([
                'action' => 'lead_email',
                'details' => 'Lead Email' . ($lead->getProjectName() ? ' for ' . $lead->getProjectName() : '') .
                    ' sent to ' . $assignedAccount->getEmail(),
                'account' => $account->getAccountId(),
                'company' => $account->getCompany()->getCompanyId(),
            ]);

            // Send the email
            $CI->system_email->sendEmail($templateId, $assignedAccount->getEmail(), $emailData, $args);
        }

    }

    public function getCompanyLeadResendList(Companies $company,$account)
    {

        $sql = "SELECT lgr.resend_name,lgr.id FROM lead_group_resends lgr ";
                //WHERE lgr.company_id = " . (int)$company->getCompanyId()." AND lgr.is_deleted =0 AND lgr.parent_resend_id IS NULL order by id desc";

                if ($account->isAdministrator() && $account->hasFullAccess()) {
                    //branch admin, can access only his branch
                    $sql .= ' WHERE  lgr.company_id=' . $company->getCompanyId();
                }else if ($account->isBranchAdmin()) {
                    //branch admin, can access only his branch
                    $sql .= ' INNER JOIN lead_group_resend_email AS lgre ON lgr.id = lgre.resend_id LEFT JOIN
                    leads l1 ON lgre.lead_id = l1.leadId
                    LEFT JOIN accounts AS a2 ON l1.account = a2.accountId   WHERE a2.branch = ' . $account->getBranch() . '
                        AND lgr.company_id=' . $company->getCompanyId();
                } else {
        
                    //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
        
                    $sql .= ' WHERE lgr.id IN(SELECT DISTINCT (lgre.resend_id)
                            FROM lead_group_resend_email lgre
                        LEFT JOIN leads ON lgre.lead_id = leads.leadId
                        WHERE leads.account = ' . $account->getAccountId().' AND lgre.is_failed =0) ';
                }
        
                $sql .=" AND lgr.is_deleted =0 order by id desc";
        return $this->getAllResults($sql);

    }

    public function groupSend(array $ids, $emailData, \models\Accounts $account, $logAction = 'client_send', $logMessage = null, $lgsId = NULL, $lgsName = NULL)
    {
        $CI =& get_instance();
        $CI->load->library('jobs2', NULL, 'my_jobs');
        $counter = 0;
        $noEmailCounter = 0;
        $unassignedCounter = 0;
        $alreadySentCount =0;
        $duplicateEmailCount =0;
        $check_sent_email = true;
        $check_email_list =[];
        $checkLeadIdsList = [];
        $owner_email_list = [];
        if($lgsId != -1){
            $lgs = $this->em->find('\models\LeadGroupResend', $lgsId);

            if (!$lgs) {
                $lgs = new LeadGroupResend();
                $lgs->setAccountId($account->getAccountId());
                $lgs->setCompanyId($account->getCompany()->getCompanyId());
                $lgs->setAccountName($account->getFullName());
                $lgs->setSubject($emailData['subject']);
                $lgs->setEmailCc(0);
                $lgs->setCustomSender(($emailData['fromName']) ? 1 : 0);
                $lgs->setCustomSenderName($emailData['fromName']);
                $lgs->setCustomSenderEmail($emailData['fromEmail']);
                $lgs->setFilters(json_encode($emailData['lead_filter'],JSON_HEX_APOS));
                $lgs->setResendName($lgsName);
                $check_sent_email = false;
            } else{
                $sql = "SELECT lgre.lead_id,lgre.email_address FROM lead_group_resend_email lgre WHERE lgre.resend_id =".$lgs->getId();
                $all_sent_emails =$this->getAllResults($sql);

                foreach($all_sent_emails as $all_sent_email){
                    array_push($check_email_list,strtolower($all_sent_email->email_address));
                    array_push($checkLeadIdsList,$all_sent_email->lead_id);
                }
            }

            $lgs->setIpAddress($_SERVER['REMOTE_ADDR']);
            $lgs->setEmailContent($emailData['body']);
            $lgs->setCreated(Carbon::now());
            $this->em->persist($lgs);
            $this->em->flush();
        }else{
            $check_sent_email = false;
        }

        foreach ($ids as $leadId) {
            
            try {
                $thisEmailData = $emailData;
                if ($check_sent_email) {

                    if(in_array($leadId, $checkLeadIdsList)){
                        $alreadySentCount++;
                        continue;
                    }
                }

                $lead = $this->em->findLead($leadId);
                
                 if($lead) {
                    if(!$lead->getEmail()){
                        continue;
                    }
                    
                    if(in_array(strtolower($lead->getEmail()), $check_email_list)){
                        $duplicateEmailCount++;
                        continue;
                    }
                    
                     if ($lead->getAccount()) {
                         $leadAccount = $this->em->findAccount($lead->getAccount());

                        if ($leadAccount) {
                            
                             $emailFromName = ($emailData['fromName']) ?: $leadAccount->getFullName();
                             $fromEmail = ($emailData['fromEmail']) ?: $leadAccount->getEmail();

                            $thisEmailData['fromName'] = $emailFromName;
                            $thisEmailData['fromEmail'] = 'noreply@' . SITE_EMAIL_DOMAIN;
                            $thisEmailData['replyTo'] = $fromEmail;
                            
                    $to = $lead->getEmail();
                    if(!in_array($leadAccount->getEmail(), $owner_email_list)){
                        array_push($owner_email_list, strtolower($leadAccount->getEmail()));
                    }
                    
                    if($lgsId != -1){
                        $lgse = new LeadGroupResendEmail();
                        $lgse->setResendId($lgs->getId());
                        $lgse->setLeadId($leadId);
                        $lgse->setEmailAddress($to);

                        $this->em->persist($lgse);
                        $this->em->flush();
                        $lgseId = $lgse->getId();
                        $lgsId =$lgs->getId();
                    }else{
                        $lgseId = NULL;
                        $lgsId = NULL;
                    }
                    
                    $thisEmailData['to'] = $to;
                    
                    $thisEmailData['uniqueArg'] = 'lead_resend_email_id';
                    $thisEmailData['uniqueArgVal'] = $lgseId;
                    $thisEmailData['leadId'] = $leadId;
                    $thisEmailData['campaignId'] = $lgsId;

                    array_push($check_email_list,strtolower($to));

                    $event_id = $this->getProposalEventRepository()->createEmailEvent('Lead',$leadId,$account,$thisEmailData['to'],$thisEmailData['body'],$thisEmailData['subject'],'',$thisEmailData['fromName'],$thisEmailData['fromEmail']);
                    $thisEmailData['uniqueArg2'] = 'email_event';
                    $thisEmailData['uniqueArg2Val'] = $event_id;

                    $etp = new \EmailTemplateParser();
                    $etp->setLead($lead);
                    $etp->setAccount($leadAccount);

                    $thisEmailData['subject'] = $etp->parse($thisEmailData['subject']);
                    $thisEmailData['body'] = $etp->parse($thisEmailData['body']);

                    //$this->getEmailRepository()->send($thisEmailData);

                    $CI->my_jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'send_individual_lead_email',$thisEmailData,'test job');
                    //$this->send($clientlId, $emailData, $account, $logAction, $logMessage, $cgse->getId());
                    $counter++;

                    $accountId = $account->getAccountId();
                    if($lgsId != -1){
                        $logText = 'Lead email campaign '.$lgsName.' sent to ' . $to;
                    }else{
                        $logText = 'Lead email sent to ' . $to;  
                    }
                    $this->getLogRepository()->add([
                        'action' => $logAction,
                        'details' => $logText,
                        'client' => $leadId,
                        'account' => $accountId,
                        'company' => $leadAccount->getCompany()->getCompanyId(),
                    ]);
                    
                    } else {
                        $unassignedCounter++;
                    }
                } else {
                    $unassignedCounter++;
                }
            } else {
                $noEmailCounter++;
            }
        } catch (\Exception $e) {
            // Do nothing
            log_message('debug','mail not sent sunil');
        }

        }

        if ($counter) {
            //log group action
            if($lgsId != -1){
                $this->getLogRepository()->add([
                    'action' => 'group_action_send',
                    'details' => "Campaign '".$lgsName."' Sent email to {$counter} Leads",
                    'account' => $account->getAccountId(),
                    'company' => $account->getCompany()->getCompanyId(),
                ]);

                $job_array = [
                    'email_data' => $emailData,
                    'account_id' => $account->getAccountId(),
                    'lgsId' => $lgsId,
                ];
                
                $CI->my_jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'send_job_lead_completed_mail',$job_array,'test job');
            }
        }

        $out = [
            'counter' => $counter,
            'unassignedCounter' => $unassignedCounter,
            'noEmailCounter' => $noEmailCounter,
            'already_sent' => $alreadySentCount,
            'duplicateEmailCount' => $duplicateEmailCount,
        ];

        return $out;
    }

    function getUnopenedLeadEmails($resend_id){

        $sql = "SELECT l.leadId FROM lead_group_resend_email lgre 
        LEFT JOIN leads l ON cgre.lead_id = c.leadId
        LEFT JOIN lead_group_resends lgr on lgre.resend_id = lgr.id
        WHERE c.lastOpenTime > UNIX_TIMESTAMP(cgr.created)
        AND lgr.id = ".$resend_id." group by l.leadId";

        return $this->getAllResults($sql);
      }
    
      function getUnopenedLeadsStatusCount($resend_id,$clicked=false){

        $sql = "SELECT lgre.id
        FROM lead_group_resend_email lgre"; 
        

        if($clicked){
            $sql .= " WHERE lgre.opened_at IS NOT NULL AND lgre.clicked_at IS NULL
            AND lgre.resend_id = ".$resend_id;
        }else{
            $sql .= " WHERE lgre.opened_at IS NULL
            AND lgre.resend_id = ".$resend_id;
        }
        $sql .= " AND lgre.is_failed = 0";
        
        $unopened_emails = $this->getAllResults($sql);

        $sql2 = "SELECT lgre.id
        FROM lead_group_resend_email lgre 
        
        WHERE lgre.resend_id = ".$resend_id;

        
        $emails_count = $this->getAllResults($sql2);
        $data =array();
        $data['total_unopened'] = count($unopened_emails);
        $data['total_emails'] = count($emails_count);
        
        return $data;
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
            $failed_subquery = " (SELECT SUM(lgre2.is_failed) FROM lead_group_resend_email AS lgre2 WHERE lgre2.resend_id = lgr.id ) AS failed";
        }else if ($account->isBranchAdmin()) {
                //branch admin, can access only his branch
                $failed_subquery = " (SELECT SUM(lgre2.is_failed) FROM lead_group_resend_email AS lgre2   
                
                LEFT JOIN leads l2 ON lgre2.lead_id = l2.leadId
                LEFT JOIN accounts AS a2 ON l2.account = a2.accountId
                WHERE lgre2.resend_id = lgr.id 
                a2.branch = " . $account->getBranch() . "
                    AND pgr.company_id=" . $company->getCompanyId()."
                ) AS failed";
                
            } else {
                $failed_subquery = " (SELECT SUM(lgre2.is_failed) FROM lead_group_resend_email AS lgre2
                LEFT JOIN leads l2 ON lgre2.lead_id = l2.leadId
                 WHERE lgre2.resend_id = lgr.id  AND (lgr.account_id =" . $account->getAccountId()." OR
                 l2.account = " . $account->getAccountId()." )) AS failed";
            
            }
        $sql = "SELECT lgr.*,a.firstname,a.lastname,lgrp.resend_name as parent_name,
                    COUNT(lgre.delivered_at) AS delivered,
                    COUNT(lgre.id) AS total_resend,
                    COUNT(lgre.bounced_at) AS bounced,
                    COUNT(lgre.opened_at) AS opened,
                    COUNT(lgre.clicked_at) as clicked,
                    COUNT(lgre.sent_at) AS sent_count,
                    ". $failed_subquery.",
                    (COUNT(lgre.clicked_at) / COUNT(lgre.id)) AS cct,
                    (COUNT(lgre.opened_at) / COUNT(lgre.id)) AS pct 
                    FROM lead_group_resends lgr 
                    LEFT JOIN lead_group_resend_email AS lgre ON lgr.id = lgre.resend_id
                    LEFT JOIN accounts AS a ON lgr.account_id = a.accountId 
                    LEFT JOIN lead_group_resends AS lgrp ON lgr.parent_resend_id = lgrp.id";

        // Filter on categories

        // Sorting
        $order = $this->ci->input->get('order');
        $sortCol = $order[0]['column'];
        $sortDir = $order[0]['dir'];

        $sortCols = [
            1 => 'lgr.id',
            2 => 'lgr.created',
            3 => 'lgr.resend_name',
            4 => 'lgr.account_name',
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
            $sql .= ' WHERE  lgr.company_id=' . $company->getCompanyId();
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            // $sql .= ' WHERE a.branch = ' . $account->getBranch() . '
            //     AND lgr.company_id=' . $company->getCompanyId();
                $sql .= ' LEFT JOIN
            leads l1 ON lgre.lead_id = l1.leadId
            LEFT JOIN accounts AS a2 ON l1.account = a2.accountId   WHERE a2.branch = ' . $account->getBranch() . '
                AND lgr.company_id=' . $company->getCompanyId();
        } else {

            //$sql .= ' WHERE lgr.account_id=' . $account->getAccountId();
        //     $sql .= ' WHERE lgr.id IN(SELECT DISTINCT
        //     (lgre.resend_id)
        // FROM
        //     lead_group_resend_email lgre
        //         LEFT JOIN
        //     leads ON lgre.lead_id = leads.leadId
        // WHERE
        //         leads.account = ' . $account->getAccountId().') ';
        $sql .= " LEFT JOIN
        leads l1 ON lgre.lead_id = l1.leadId WHERE (lgr.account_id =" . $account->getAccountId()." OR
            l1.account = " . $account->getAccountId()." )";
        }
        //$sql .= ' AND lgr.is_deleted=0 AND lgr.parent_resend_id IS NULL';
        $sql .= ' AND lgr.is_deleted=0 AND lgre.is_failed = 0 ';

        // // Search
        $searchVal = $this->ci->input->get('search')['value'];
        if ($searchVal) {
            $sql .= " AND (" .
                "(lgr.account_name  LIKE '%" . $searchVal . "%')" .
                "OR (lgr.resend_name  LIKE '%" . $searchVal . "%')" .
                ") GROUP BY lgr.id";
        }else{
            $sql .= ' GROUP BY lgr.id';
        }

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
                $failed_info = '<a href="/leads/resend/' . $data->id . '/failed" class="right" style="position: absolute;right: 0;"><i class="fa fa-fw fa-info-circle tiptip" style="color: #000;font-size: 14px;" title="'.$data->failed.' Leads email Failed to send" ></i></a>';
            }
            $create_date = date_format($date, "m/d/y g:i A");

   // if (($account->isAdministrator() && $account->hasFullAccess()) || $data->account_id == $account->getAccountId()) {
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
                            <a href="../leads/resend/'.$data->id.'" class="show_email_content22 " ><i class="fa fa-fw fa-user"></i> View Leads</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" data-val="'.$data->id.'" class="delete_campaign " ><i class="fa fa-fw fa-trash"></i> Delete Campaign</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" data-val="'.$data->id.'" class="resend_upopened " data-unclicked="0"><i class="fa fa-fw fa-share-square"></i> Resend Unopened Eamils</a>
                        </li>
                        <li>
                            <a href="javascript:void(0);" data-val="'.$data->id.'" class="resend_upopened " data-unclicked="1"><i class="fa fa-fw fa-share-square-o"></i> Resend Unclicked Eamils</a>
                        </li>
                            
                        </ul>
                    </div>
                </div>';
                $total_resend = '<div style="position: relative;"><a href="/leads/resend/' . $data->id . '">' . $data->total_resend . '</a>'.$failed_info.'</div>';
                if($data->sent_count < $data->total_resend){
                    $total_sending = $data->total_resend;
                    if($data->failed>0){
                        $total_sending = $data->failed + $total_sending;
                    }
                    $total_resend = '<div style="position: relative;"><a href="/leads/resend/' . $data->id . '">' .$data->sent_count.' / '. $total_sending . '</a>'.$failed_info.'</div>';
                    $create_date .= ' <i class="fa fa-fw fa-info-circle tiptip" style="color: #000;font-size: 14px;" title="Campaign is in progress" ></i>';
                }
                //$total_resend = '<a href="/leads/resend/' . $data->id . '">' . $data->total_resend . '</a>';
                $delivered = '<a href="/leads/resend/' . $data->id . '/delivered">' . $data->delivered . '</a>';
                $bounced = '<a href="/leads/resend/' . $data->id . '/bounced">' . $data->bounced . '</a>';
                $opened = '<div style="display: flex;justify-content: space-between;"><a href="/leads/resend/' . $data->id . '/opened">' . $data->opened . '</a><a href="/leads/resend/' . $data->id . '/opened">' . $open_p . '%</a></div>';
                $link_open_p = '<a href="/leads/resend/' . $data->id . '/opened">' . $open_p . '%</a>';
                $clicked = '<div style="display: flex;justify-content: space-between;"><a href="/leads/resend/' . $data->id . '/clicked">' . $data->clicked . '</a><a href="/leads/resend/' . $data->id . '/clicked">' . $click_p . '%</a></div>';
                $link_click_p = '<a class="tiptip" title="'.$data->clicked.' Clicks" href="/leads/resend/' . $data->id . '/clicked">' . $click_p . '%</a>';
    
            
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

        $parentResend = $this->em->find('\models\LeadGroupResend', $cgsId);

        $parentFilter = json_decode($parentResend->getFilters());
        $parentFilter->pResendType = ($unclicked=='1') ? 'Unclicked' : 'Unopened';

        
        $cgs = new LeadGroupResend();
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

        $sql = "SELECT lgre.lead_id,lgre.id,lgre.email_address,lgre.bounced_at
        FROM lead_group_resend_email lgre"; 
        

        if($unclicked=='1'){
            $sql .= " WHERE lgre.opened_at IS NOT NULL AND lgre.clicked_at IS NULL
            AND lgre.resend_id = ".$cgsId;
        }else{
            $sql .= " WHERE lgre.opened_at IS NULL
            AND lgre.resend_id = ".$cgsId;
        }
        $sql .= " AND lgre.is_failed = 0";

        $Resend_campaigns = $this->getAllResults($sql);

        foreach ($Resend_campaigns as $Resend_campaign) {

            $thisEmailData = $emailData;
            $sendIt = true;
            $bounced =false;
            $lead_id = $Resend_campaign->lead_id;
            $lead = $this->em->findLead($lead_id);

            if ($sendIt) {

                if(in_array(strtolower($lead->getEmail()), $check_email_list)){
                    continue;
                }

                //Event Log
                //$this->getProposalEventRepository()->sendProposalCampaign($proposal, $account);
                $leadAccount = $this->em->findAccount($lead->getAccount());

                $thisEmailData['fromName'] = ($emailData['fromName']) ?: $leadAccount->getFullName();
                $thisEmailData['fromEmail'] = ($emailData['fromEmail']) ?: $leadAccount->getEmail();
                $thisEmailData['replyTo'] = ($emailData['replyTo']) ?: $leadAccount->getEmail();
                $to = $lead->getEmail();
                array_push($check_email_list,strtolower($to));

                $cgse = new LeadGroupResendEmail();
                $cgse->setResendId($cgs->getId());
                $cgse->setLeadId($lead_id);
                $cgse->setEmailAddress($to);
                $cgse->setParentResendEmailId($Resend_campaign->id);
                $this->em->persist($cgse);
                $this->em->flush();

                $thisEmailData['to'] = $to;
                $thisEmailData['uniqueArg'] = 'lead_resend_email_id';
                $thisEmailData['uniqueArgVal'] = $cgse->getId();
                $thisEmailData['leadId'] = $lead_id;
                $thisEmailData['campaignId'] = $cgs->getId();

                array_push($check_email_list,strtolower($to));

                $etp = new \EmailTemplateParser();
                $etp->setLead($lead);
                $etp->setAccount($leadAccount);

                $thisEmailData['subject'] = $etp->parse($thisEmailData['subject']);
                $thisEmailData['body'] = $etp->parse($thisEmailData['body']);

                $CI->my_jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'send_individual_lead_email',$thisEmailData,'test job');

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
                'details' => "Group Mail Sent to {$count} Leads",
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

    /**
     * @param LeadGroupResend $resend
     * @return array
     */
    public function getLeadResendStats(LeadGroupResend $resend,$account)
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

    public function getNumResendEmails(LeadGroupResend $resend,$account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numSent
        FROM lead_group_resend_email lgre";

        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE lgre.resend_id ={$resendId} AND lgre.is_failed = 0";
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            
            $sql .= " LEFT JOIN
                leads l1 ON lgre.lead_id = l1.leadId
                LEFT JOIN accounts AS a2 ON l1.account = a2.accountId   WHERE lgre.resend_id ={$resendId} AND lgre.is_failed = 0 AND a2.branch = " . $account->getBranch();
        } else {
    
            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            $sql .= " LEFT JOIN
                    leads ON lgre.lead_id = leads.leadId WHERE lgre.resend_id ={$resendId}
                    AND lgre.is_failed = 0 AND 
                    leads.account = " . $account->getAccountId();
        } 
        //WHERE lgre.resend_id = " . $resend->getId();


        $data = $this->getSingleResult($sql);

        return $data->numSent;
    }

    public function getNumFailedResendEmails(LeadGroupResend $resend,$account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(fj.id) AS numFailed
        FROM failed_jobs fj";


        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE fj.campaign_id ={$resendId} AND job_type= 'lead_campaign' ";
        }else if ($account->isBranchAdmin()) {
            
            $sql .= " LEFT JOIN
                leads l1 ON fj.entity_id = l1.leadId
                LEFT JOIN accounts AS a2 ON l1.account = a2.accountId   WHERE fj.campaign_id ={$resendId} AND job_type= 'lead_campaign' AND a2.branch = " . $account->getBranch();
                
        } else {
            $sql .= " LEFT JOIN
            leads l1 ON fj.entity_id = l1.leadId WHERE fj.campaign_id ={$resendId}
                AND job_type= 'lead_campaign' AND 
                l1.account = " . $account->getAccountId();

           
        }
        //WHERE pgre.resend_id = " . $resend->getId();

        $data = $this->getSingleResult($sql);

        return $data->numFailed;
    }

    public function getNumDeliveredResendEmails(LeadGroupResend $resend,$account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numDelivered
        FROM lead_group_resend_email lgre";

        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE lgre.resend_id ={$resendId} AND lgre.is_failed = 0 AND delivered_at IS NOT NULL";
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            
            $sql .= " LEFT JOIN
                leads l1 ON lgre.lead_id = l1.leadId
                LEFT JOIN accounts AS a2 ON l1.account = a2.accountId   WHERE lgre.resend_id ={$resendId} AND lgre.is_failed = 0 AND delivered_at IS NOT NULL AND a2.branch = " . $account->getBranch();
        } else {

            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            $sql .= " LEFT JOIN
                    leads ON lgre.lead_id = leads.leadId WHERE lgre.resend_id ={$resendId} AND lgre.is_failed = 0
                    AND delivered_at IS NOT NULL AND leads.account = " . $account->getAccountId();
        }
        // WHERE lgre.resend_id = " . $resend->getId() . "
        // AND delivered_at IS NOT NULL";

        $data = $this->getSingleResult($sql);

        return $data->numDelivered;
    }

    public function getNumBouncedResendEmails(LeadGroupResend $resend,$account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numBounced
        FROM lead_group_resend_email lgre"; 

        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE lgre.resend_id ={$resendId} AND lgre.is_failed = 0 AND bounced_at IS NOT NULL";
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            
            $sql .= " LEFT JOIN
                leads l1 ON lgre.lead_id = l1.leadId
                LEFT JOIN accounts AS a2 ON l1.account = a2.accountId   WHERE lgre.resend_id ={$resendId} AND lgre.is_failed = 0 AND bounced_at IS NOT NULL AND a2.branch = " . $account->getBranch();
        } else {

            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            $sql .= " LEFT JOIN
                    leads ON lgre.lead_id = leads.leadId WHERE lgre.resend_id ={$resendId} AND lgre.is_failed = 0
                    AND bounced_at IS NOT NULL AND leads.account = " . $account->getAccountId();
        }
        // WHERE lgre.resend_id = " . $resend->getId() . "
        // AND bounced_at IS NOT NULL";

        $data = $this->getSingleResult($sql);

        return $data->numBounced;
    }

    public function getNumOpenedResendEmails(LeadGroupResend $resend,$account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numOpened
        FROM lead_group_resend_email lgre";

        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE lgre.resend_id ={$resendId} AND lgre.is_failed = 0 AND opened_at IS NOT NULL";
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            
            $sql .= " LEFT JOIN
                leads l1 ON lgre.lead_id = l1.leadId
                LEFT JOIN accounts AS a2 ON l1.account = a2.accountId   WHERE lgre.resend_id ={$resendId} AND lgre.is_failed = 0 AND opened_at IS NOT NULL AND a2.branch = " . $account->getBranch();
        } else {

            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            $sql .= " LEFT JOIN
                    leads ON lgre.lead_id = leads.leadId WHERE lgre.resend_id ={$resendId} AND lgre.is_failed = 0
                    AND opened_at IS NOT NULL AND leads.account = " . $account->getAccountId();
        }

        
        // WHERE lgre.resend_id = " . $resend->getId() . "
        // AND opened_at IS NOT NULL";

        $data = $this->getSingleResult($sql);

        return $data->numOpened;
    }

    

    public function getNumClickedResendEmails(LeadGroupResend $resend,$account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numClicked
        FROM lead_group_resend_email lgre";

        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE lgre.resend_id ={$resendId} AND lgre.is_failed = 0 AND clicked_at IS NOT NULL";
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            
            $sql .= " LEFT JOIN
                leads l1 ON lgre.lead_id = l1.leadId
                LEFT JOIN accounts AS a2 ON l1.account = a2.accountId   WHERE lgre.resend_id ={$resendId} AND lgre.is_failed = 0 AND clicked_at IS NOT NULL AND a2.branch = " . $account->getBranch();
        } else {

            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            $sql .= " LEFT JOIN
                    leads ON lgre.lead_id = leads.leadId WHERE lgre.resend_id ={$resendId} AND lgre.is_failed = 0
                    AND clicked_at IS NOT NULL AND leads.account = " . $account->getAccountId();
        }

        
        // WHERE lgre.resend_id = " . $resend->getId() . "
        // AND opened_at IS NOT NULL";

        $data = $this->getSingleResult($sql);

        return $data->numClicked;
    }

    public function getNumUnopenedResendEmails(LeadGroupResend $resend,$account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numUnopened
        FROM lead_group_resend_email lgre";

        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE lgre.resend_id ={$resendId} AND lgre.is_failed = 0 AND opened_at IS NULL";
        }else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            
            $sql .= " LEFT JOIN
                leads l1 ON lgre.lead_id = l1.leadId
                LEFT JOIN accounts AS a2 ON l1.account = a2.accountId   WHERE lgre.resend_id ={$resendId} AND lgre.is_failed = 0 AND opened_at IS NULL AND a2.branch = " . $account->getBranch();
        } else {

            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            $sql .= " LEFT JOIN
                    leads ON lgre.lead_id = leads.leadId WHERE lgre.resend_id ={$resendId} AND lgre.is_failed = 0
                    AND opened_at IS  NULL AND leads.account = " . $account->getAccountId();
        }
        // WHERE lgre.resend_id = " . $resend->getId() . "
        // AND opened_at IS NULL";

        $data = $this->getSingleResult($sql);

        return $data->numUnopened;
    }

    public function getLeadChildResend($resend_id){

        $sql = "SELECT lgr.id,lgr.resend_name
        FROM lead_group_resends lgr 
        
        WHERE lgr.parent_resend_id = " . $resend_id ;

        return $this->getAllResults($sql);

    }

    public function getChildResend($resend_id){

        $sql = "SELECT lgr.id,lgr.resend_name
        FROM lead_group_resends lgr 
        
        WHERE lgr.parent_resend_id = " . $resend_id." order by id desc" ;

        return $this->getAllResults($sql);

    }

    public function getLeadTemplateFields(){
        $sql = "SELECT cetpf.*
        FROM client_email_template_type_fields cetpf 
        WHERE cetpf.template_type='2'";
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

    public function getLeadBusinessTypes($lead_id){
        $sql = "SELECT bta.business_type_id,bt.type_name
        FROM business_type_assignments bta 
        LEFT JOIN business_types bt ON bta.business_type_id = bt.id
        WHERE bta.lead_id=".$lead_id;
        return $this->getAllResults($sql);

    }

    /**
     * @param int $leadId
     * @return string
     */
    public function getLeadBusinessTypeNames(int $leadId): string
    {
        $btArray = $this->getLeadBusinessTypes($leadId);
        $btnames =[];

        foreach($btArray as $bt) {
            array_push($btnames, $bt->type_name);
        }

        $btnames  = implode(', ', $btnames);

        return $btnames;
    }

    public function getLeadNotesCount($lead_id){
        $sql = "SELECT COUNT(notes.noteId) as ncount
        FROM notes  
        WHERE type = 'lead' AND relationId=".$lead_id;
        return $this->getAllResults($sql)[0];
    }

    function getLeadSavedFilters($account)
    {
        $sql = "SELECT spf.*
        FROM saved_proposal_filter spf WHERE user_id = ".$account->getAccountId()." AND filter_page = 'Lead' ORDER BY ord";

        return $this->getAllResults($sql);
    }

    public function groupLeadExportCSV(Accounts $account, $leadIds)
    {
        // Get the data
        $leadData = $account->getLeadsByIds($leadIds);
        // Create the writer
        $writer = Writer::createFromFileObject(new \SplTempFileObject());

        // Headings
        $headingData = [
            'Date Created',
            'Business',
            'Source',
            'Status',
            'Rating',
            'Due Date',
            'Company',
            'Zip',
            'Project Name',
            'Contact',
            'Owner',
            'Last Activity',
        ];

        // Add the headings
        $writer->insertOne($headingData);
        $count =0;
        // Loop through the data
        foreach ($leadData as $row) {

           
            $rowData = [
                date('m/d/Y g:ia', $row->created),
                $row->types,
                $row->source,
                $row->status,
                $row->rating,
                $row->dueDate ? date('m/d/y', $row->dueDate) : '-',
                $row->companyName,
                $row->projectZip,
                $row->projectName,
                $row->firstName . ' ' . $row->lastName,
                $row->FN . ' ' . $row->LN,
                $row->last_activity ? date('m/d/y g:ia', $row->last_activity) : '',
            ];
            $writer->insertOne($rowData);
            $count++;
        };

        if($count > 0){
            $this->getLogRepository()->add([
                'action' => 'Group Export',
                'details' => " {$count} Leads Export",
                'account' => $account->getAccountId(),
                'company' => $account->getCompany()->getCompanyId(),
            ]);
        }

        // Output the csv
        return $writer->output();
    }
    
}