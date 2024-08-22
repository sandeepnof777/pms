<?php

namespace Pms\Repositories;

use Carbon\Carbon;
use Doctrine\ORM\NoResultException;
use Intervention\Image\ImageManager;
use League\Csv\Writer;
use models\Accounts;
use models\Companies;
use models\EstimateStatus;
use models\Proposal_attachments;
use models\Proposal_services;
use models\ProposalGroupResend;
use models\ProposalGroupResendEmail;
use models\Proposals;
use models\Proposals_images;
use models\ProposalSignee;
use oasis\names\specification\ubl\schema\xsd\CommonBasicComponents_2\AccountID;
use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;
use Doctrine\ORM\Query\ResultSetMapping;
use models\ProposalPreviewLink;
use models\ProposalUserPermission;
use Ramsey\Uuid\Uuid;
use models\ProposalVideo;

class Proposal extends RepositoryAbstract
{
    use DBTrait;

    /**
     * Gets DB entry for proposal id
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->getSingleResult("select * from proposals where proposalId = {$id}");
    }

    /**
     * Sends the proposal to a template
     * @param $proposalId
     * @param $templateId
     * @param string $logAction
     * @param string $logMessage
     * @param $account
     * @return bool
     */
    public function sendWithTemplate($proposalId, $templateId, $account = null, $logAction = 'proposal_send', $logMessage = null)
    {
        //build template todo
        //hook into $this->send() function todo
        return true;
    }

    public function groupSend(array $ids, $emailData, \models\Accounts $account, $logAction = 'proposal_send', $logMessage = null, $pgsId = NULL, $pgsName = NULL, $exclude_override)
    {

        $CI =& get_instance();

        $CI->load->library('jobs2', NULL, 'my_jobs');

        $count = 0;
        $alreadySentCount = 0;
        $unsentCount = 0;
        $check_sent_email = true;
        $owner_email_list = [];
        if ($pgsId != -1) {


            $pgs = $this->em->find('\models\ProposalGroupResend', $pgsId);

            if (!$pgs) {
                $pgs = new ProposalGroupResend();
                $pgs->setAccountId($account->getAccountId());
                $pgs->setCompanyId($account->getCompany()->getCompanyId());
                $pgs->setAccountName($account->getFullName());
                $pgs->setSubject($emailData['subject']);
                $pgs->setEmailCc($emailData['emailCC']);
                $pgs->setCustomSender(($emailData['fromName']) ? 1 : 0);
                $pgs->setCustomSenderName($emailData['fromName']);
                $pgs->setCustomSenderEmail($emailData['fromEmail']);
                $pgs->setFilters(json_encode($emailData['proposal_filter'], JSON_HEX_APOS));
                $pgs->setResendName($pgsName);
                $pgs->setExcludedOverride($exclude_override);
                $check_sent_email = false;
                //Delete Resend List query Cache
                $this->getQueryCacheRepository()->deleteProposalsResendListCache($account->getCompany()->getCompanyId());
            }


            $pgs->setIpAddress($_SERVER['REMOTE_ADDR']);
            $pgs->setEmailContent($emailData['body']);
            $pgs->setCreated(Carbon::now());
            $this->em->persist($pgs);
            $this->em->flush();
        } else {
            $check_sent_email = false;
        }


        foreach ($ids as $proposalId) {
            try {
                $sendIt = true;

                // Check approval status
                if ($account->requiresApproval()) {

                    $proposal = $this->em->findProposal($proposalId);

                    if ($proposal->getTotalPrice() > $account->getApprovalLimit()) {
                        $sendIt = false;
                    }
                }

                if ($sendIt) {
                    if ($check_sent_email) {

                        $resend = $this->em->getRepository('models\ProposalGroupResendEmail')->findOneBy(array(
                            'resend_id' => $pgs->getId(),
                            'proposal_id' => $proposalId
                        ));
                        if ($resend) {
                            $alreadySentCount++;
                            continue;
                        }

                    }

                    $proposal = $this->em->findProposal($proposalId);
                    if ($proposal) {

                        if ($exclude_override == '0') {
                            if ($proposal->getResendExcluded() == 1) {
                                continue;
                            }
                        }

                        if ((isset($emailData['emailClient']) && ($emailData['emailClient'] == false))) {
                            $to = [];
                        } else {
                            if ($proposal->getClient()->getEmail()) {
                                $to = [$proposal->getClient()->getEmail()];
                            } else {
                                continue;
                            }
                        }

                        if (isset($emailData['bcc']) && is_array($emailData['bcc'])) {
                            $to = array_merge($to, $emailData['bcc']);
                        }

                        if (!in_array($proposal->getOwner()->getEmail(), $owner_email_list)) {
                            array_push($owner_email_list, $proposal->getOwner()->getEmail());
                        }
                        $to = implode(" ", array_unique($to));

                        if ($pgsId != -1) {
                            $pgse = new ProposalGroupResendEmail();
                            $pgse->setResendId($pgs->getId());
                            $pgse->setProposalId($proposalId);
                            $pgse->setEmailAddress($to);
                            $pgse->setProposalStatusId($proposal->getStatus());

                            $this->em->persist($pgse);
                            $this->em->flush();
                            $pgseId = $pgse->getId();
                            $pgsId = $pgs->getId();
                        } else {
                            $pgsId = NULL;
                            $pgseId = NULL;
                        }

                        //testing for individual send
                        $job_array = [
                            'proposal_id' => $proposalId,
                            'email_data' => $emailData,
                            'account_id' => $account->getAccountId(),
                            'logAction' => 'proposal_send',
                            'logMessage' => '',
                            'pgseId' => $pgseId,
                            'pgsId' => $pgsId,
                            'mail_to' => $to,
                            'proposal_status' => $proposal->getStatus()

                        ];

                        //if proposal have audit ready status
                        if ($proposal->getProposalStatus()->getStatusId() == \models\Status::AUDIT_READY) {

                            $Status = $this->em->find('models\Status', \models\Status::OPEN);
                            $proposal->setProposalStatus($Status);
                            $this->em->persist($proposal);
                            $this->em->flush();
                        }
                        // Save the queue
                        $CI->my_jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'send_individual_proposal_email_send', $job_array, 'test job');

                        //$this->direct_send($proposalId, $emailData, $account, $logAction, $logMessage, $pgseId);
                        $count++;
                    }

                } else {
                    $unsentCount++;
                }

            } catch (\Exception $e) {
                // Do nothing
            }

        }

        $job_array = [

            'email_data' => $emailData,
            'account_id' => $account->getAccountId(),
            'pgsId' => $pgsId,
        ];

        $CI->my_jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'send_job_completed_mail', $job_array, 'test job');

        if ($count) {

            //log group action
            if ($pgsId != -1) {
                $this->getLogRepository()->add([
                    'action' => 'group_action_send',
                    'details' => "Campaign '" . $pgsName . "' Sent Proposals to {$count} clients",
                    'account' => $account->getAccountId(),
                    'company' => $account->getCompany()->getCompanyId(),
                ]);
            }
            //$this->sendOwnerAccountCC($emailData,$account,$owner_email_list);
            //$this->sendAccountCC($emailData, $account,$count);

        }

        $out = [
            'sent' => $count,
            'unsent' => $unsentCount,
            'already_sent' => $alreadySentCount
        ];

        return $out;
    }

    /**
     * Sends the proposal out
     * @param $proposalId
     * @param $emailData
     * @param string $logAction
     * @param string $logMessage
     * @param $account
     * @return bool
     */
    public function send($proposalId, $emailData, $account = null, $logAction = 'proposal_send', $logMessage = null, $resend_id = null,$resend_type = null)
    {
        //validate email data
        if (!isset($emailData['subject']) || !isset($emailData['body']) || !isset($emailData['fromName']) || !isset($emailData['fromEmail'])) {
            return false;
        }
        //initiate and validate proposal
        /* @var $proposal \models\Proposals */
        $proposal = $this->em->find('\models\Proposals', $proposalId);
        if (!$proposal) {
            return false;
        }
        //send emails
        // $etp = new \EmailTemplateParser();
        // $etp->setProposal($proposal);

        if($resend_type == 'automatic'){
            $uniqueArg2 = 'automatic_resend_id';
        }else{
            $uniqueArg2 = 'resend_email_id';
        }
        //build basic email data
        $basicEmailData = [
            'fromName' => ($emailData['fromName']) ?: $proposal->getOwner()->getFullName(),
            'fromEmail' => 'noreply@' . SITE_EMAIL_DOMAIN,
            'subject' => $emailData['subject'],
            'body' => $emailData['body'],
            'replyTo' => (@$emailData['replyTo']) ?: $proposal->getOwner()->getEmail(),
            'uniqueArg2' => $uniqueArg2,
            'uniqueArg2Val' => $resend_id,
            'uniqueArg' => 'proposal',
            'uniqueArgVal' => $proposal->getProposalId(),
            'categories' => (isset($emailData['categories']) && is_array($emailData['categories'])) ? $emailData['categories'] : [],
        ];
        //send email to client and bcc / additional mails
        $to = (isset($emailData['emailClient']) && ($emailData['emailClient'] == false)) ? [] : [$proposal->getClient()->getEmail()];
        if (isset($emailData['bcc']) && is_array($emailData['bcc'])) {
            $to = array_merge($to, $emailData['bcc']);
        }
        $clientEmailData = $basicEmailData;
        $clientEmailData['categories'][] = 'Proposal';
        $clientEmailData['to'] = array_unique($to); //filter out duplicates, just a precaution
        $emails = $clientEmailData['to'];


        foreach ($emails as $email) {

            // Update the link if it's going to the client
            $clientEmail = $proposal->getClient()->getEmail();
            if ($clientEmail == $email) {
                $clientEmailData['body'] = updateEmailLinks($clientEmailData['body']);
            }

            $email = trim($email);
            $clientEmailData['to'] = $email;
            $CI =& get_instance();

            $CI->load->library('jobs');

            $event_id = $this->getProposalEventRepository()->createEmailEvent('Proposal', $proposalId, $account, $clientEmailData['to'], $clientEmailData['body'], $clientEmailData['subject'], \models\EventMailType::GROUPRESEND, $clientEmailData['fromName'], $clientEmailData['fromEmail']);
            $clientEmailData['uniqueArg3'] = 'email_event';
            $clientEmailData['uniqueArg3Val'] = $event_id;
            // Save the opaque image
            $CI->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'group_proposal_resend', $clientEmailData, 'test job');

            //$this->getEmailRepository()->send($clientEmailData);

            //log action
            $accountId = ($account !== null) ? $account->getAccountId() : $proposal->getClient()->getAccount()->getAccountId();
            $logText = ($logMessage) ?: 'Proposal sent to ' . $email;
            $this->getLogRepository()->add([
                'action' => $logAction,
                'details' => $logText,
                'client' => $proposal->getClient()->getClientId(),
                'proposal' => $proposal->getProposalId(),
                'account' => $accountId,
                'company' => $proposal->getClient()->getCompany()->getCompanyId(),
            ]);
        }

        //send cc to proposal owner if cc is true
        if ((@$emailData['emailCC'])) {

            $ccEmailData = $basicEmailData;
            $ccEmailData['categories'][] = 'Proposal CC';
            $ccEmailData['to'] = [$proposal->getOwner()->getEmail()];
            /*
            //send to client owner if different than proposal owner
            if (($proposal->getClient()->getAccount()->getAccountId() != $proposal->getOwner()->getAccountId())) {
                $ccEmailData['to'][] = $proposal->getClient()->getAccount()->getEmail();
            }
            //send to account performing action if not owner [for admins]
            if ($account && (!in_array($account->getEmail(), $ccEmailData['to']))) {
                $ccEmailData['to'][] = $account->getEmail();
            }
            */
            $ccEmailData['to'] = array_unique($ccEmailData['to']); //filter out duplicates, just a precaution
            $emails = $ccEmailData['to'];

            foreach ($emails as $email) {
                $ccEmailData['to'] = $email;
                //$this->getEmailRepository()->send($ccEmailData);

                $event_id = $this->getProposalEventRepository()->createEmailEvent('Proposal', $proposalId, $account, $ccEmailData['to'], $ccEmailData['body'], $ccEmailData['subject'], '2', $ccEmailData['fromName'], $ccEmailData['fromEmail']);
                $ccEmailData['uniqueArg3'] = 'email_event';
                $ccEmailData['uniqueArgVal3'] = $event_id;
                $CI->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'group_proposal_resend', $ccEmailData, 'test job');
            }
        }


        //reset some proposal flags
        $proposal->setLastActivity();
        //$proposal->setDeliveryTime(null);
        //$proposal->setLastOpenTime(null);
        $proposal->setEmailStatus(\models\Proposals::EMAIL_SENT);
        $proposal->setEmailSendTime(time());
        $proposal->setDeclined(0);
        $this->em->persist($proposal);
        $this->em->flush();
        //true on success
        return true;
    }

    public function sendAccountCC($emailData, \models\Accounts $account, $count, $failed_count = NULL)
    {
        $body = $count . ' emails were sent. Your email is shown below. <br/>';
        if ($failed_count > 0) {
            $body .= $failed_count . '  emails failed to sent.<br/>';
        }
        $basicEmailData = [
            'fromName' => SITE_NAME,
            'fromEmail' => 'noreply@' . SITE_EMAIL_DOMAIN,
            'subject' => 'Email Proposal Campaign Confirmation',
            'body' => $body . ' <br/><hr/><br/>' . $emailData['body'],
            'replyTo' => '',
        ];
        //send email to client and bcc / additional mails


        $clientEmailData = $basicEmailData;


        $clientEmailData['to'] = $account->getEmail();
        // $clientEmailData['to'] = 'sunilyadav.acs@gmail.com';
        $this->getEmailRepository()->send($clientEmailData);

        // $CI =& get_instance();

        // $CI->load->library('jobs');

        // // Save the opaque image
        // $CI->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'group_proposal_resend', $clientEmailData, 'test job');

    }

    public function sendOwnerAccountCC($emailData, $account, $owner_email_list)
    {

        $basicEmailData = [
            'fromName' => SITE_NAME,
            'fromEmail' => 'noreply@' . SITE_EMAIL_DOMAIN,
            'subject' => 'Email Proposal Campaign Notification',
            'body' => $account->getFullName() . ' sent Emails on your Proposal. Your email is shown below. <br/><br/><hr/><br/>' . $emailData['body'],
            'replyTo' => '',
        ];
        //send email to client and bcc / additional mails


        $clientEmailData = $basicEmailData;

        for ($i = 0; $i < count($owner_email_list); $i++) {

            if ($account->getEmail() != $owner_email_list[$i]) {

                $clientEmailData['to'] = $owner_email_list[$i];

                $this->getEmailRepository()->send($clientEmailData);
            }

        }

        // $CI =& get_instance();

        // $CI->load->library('jobs');

        // // Save the opaque image
        // $CI->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'group_proposal_resend', $clientEmailData, 'test job');

    }


    public function groupSendUnopened($emailData, \models\Accounts $account, $logAction = 'proposal_send', $logMessage = null, $pgsId = NULL)
    {
        $count = 0;
        $alreadySentCount = 0;
        $unsentCount = 0;
        $check_sent_email = true;

        $pgs = $this->em->find('\models\ProposalGroupResend', $pgsId);

        $query = 'SELECT pgre FROM models\ProposalGroupResendEmail pgre
                WHERE pgre.is_open = 1 AND pgre.resend_id = ' . $pgsId;

        $emails = $this->em->createQuery($query)->getResult();

        foreach ($emails as $email) {
            $sendIt = true;

            // Check approval status
            if ($account->requiresApproval()) {

                $proposal = $this->em->findProposal($email->getProposalId());

                if ($proposal->getTotalPrice() > $account->getApprovalLimit()) {
                    $sendIt = false;
                }
            }

            if ($sendIt) {
                // if($check_sent_email){

                //     $resend = $this->em->getRepository('models\ProposalGroupResendEmail')->findOneBy(array(
                //         'resend_id' => $pgs->getId(),
                //         'proposal_id' => $proposalId
                //     ));
                //     if($resend ){
                //         $alreadySentCount++;
                //         //continue;
                //     }

                // }
                $proposal = $this->em->findProposal($email->getProposalId());
                //Event Log
                $this->getProposalEventRepository()->sendProposalCampaign($proposal, $account);

                if ($this->send($email->getProposalId(), $emailData, $account, $logAction, $logMessage, $pgs->getId())) {
                    $proposal = $this->em->find('\models\Proposals', $email->getProposalId());
                    $to = (isset($emailData['emailClient']) && ($emailData['emailClient'] == false)) ? [] : [$proposal->getClient()->getEmail()];
                    if (isset($emailData['bcc']) && is_array($emailData['bcc'])) {
                        $to = array_merge($to, $emailData['bcc']);
                    }
                    $to = implode(" ", array_unique($to));

                    // print_r($to);die;
                    $now = time();
                    $is_open = 0;
                    if ($proposal->getLastOpenTime()) {
                        if ($proposal->getLastOpenTime() > $now) {
                            $is_open = 1;
                        }
                    }
                    //$pgse = $this->em->find('\models\ProposalGroupResend', $email->getId());

                    $email->setIsOpen($is_open);

                    $this->em->persist($email);
                    $this->em->flush();
                    $count++;
                }

            } else {
                $unsentCount++;
            }
        }

        if ($count) {
            //log group action
            $this->getLogRepository()->add([
                'action' => 'group_action_send',
                'details' => "Group Proposals Sent to {$count} clients",
                'account' => $account->getAccountId(),
                'company' => $account->getCompany()->getCompanyId(),
            ]);
        }

        $out = [
            'sent' => $count,
            'unsent' => $unsentCount,
            'already_sent' => $alreadySentCount
        ];

        return $out;
    }


    public function groupSendUnopened2($emailData, \models\Accounts $account, $logAction = 'proposal_send', $logMessage = null, $pgsId = NULL, $unclicked = NULL, $exclude_override)
    {
        $CI =& get_instance();
        $CI->load->library('jobs2', NULL, 'my_jobs');
        $count = 0;
        $alreadySentCount = 0;
        $unsentCount = 0;
        $bouncedUnsentCount = 0;
        $check_sent_email = true;
        $check_email_list = [];

        $parentResend = $this->em->find('\models\ProposalGroupResend', $pgsId);

        $parentFilter = json_decode($parentResend->getFilters());
        $parentFilter->pResendType = ($unclicked == '1') ? 'Unclicked' : 'Unopened';

        $pgs = new ProposalGroupResend();
        $pgs->setAccountId($account->getAccountId());
        $pgs->setCompanyId($account->getCompany()->getCompanyId());
        $pgs->setAccountName($account->getFullName());
        $pgs->setSubject($emailData['subject']);
        $pgs->setEmailCc($emailData['emailCC']);
        $pgs->setCustomSender(($emailData['fromName']) ? 1 : 0);
        $pgs->setCustomSenderName($emailData['fromName']);
        $pgs->setCustomSenderEmail($emailData['fromEmail']);
        $pgs->setResendName($emailData['new_resend_name']);
        $pgs->setIpAddress($_SERVER['REMOTE_ADDR']);
        if ($unclicked == 1) {
            $pgs->setResendType(2);
        } else {
            $pgs->setResendType(1);
        }
        $pgs->setFilters(json_encode($parentFilter, JSON_HEX_APOS));

        $pgs->setEmailContent($emailData['body']);
        $pgs->setParentResendId($pgsId);
        $pgs->setCreated(Carbon::now());
        $this->em->persist($pgs);
        $this->em->flush();
        //Delete Resend List query Cache
        $this->getQueryCacheRepository()->deleteProposalsResendListCache($account->getCompany()->getCompanyId());

        $sql = "SELECT p.proposalStatus, pgre.proposal_status_id, pgre.proposal_id,pgre.id,pgre.email_address,pgre.bounced_at
        FROM proposal_group_resend_email pgre 
        LEFT JOIN proposals p ON pgre.proposal_id = p.proposalId";

        if ($unclicked == '1') {
            $sql .= " WHERE pgre.opened_at IS NOT NULL AND pgre.clicked_at IS NULL
            AND pgre.resend_id = " . $pgsId;
        } else {
            $sql .= " WHERE pgre.opened_at IS NULL
            AND pgre.resend_id = " . $pgsId;
        }
        $sql .= " AND pgre.is_failed = 0";

        $Resend_proposals = $this->getAllResults($sql);
        foreach ($Resend_proposals as $Resend_proposal) {
            $sendIt = true;
            $bounced = false;
            $proposal_id = $Resend_proposal->proposal_id;

            if ($Resend_proposal->proposalStatus != $Resend_proposal->proposal_status_id) {
                $sendIt = false;
            }

            // Check approval status
            if ($account->requiresApproval()) {

                $proposal = $this->em->findProposal($proposal_id);

                if ($proposal->getTotalPrice() > $account->getApprovalLimit()) {
                    $sendIt = false;
                }
            }
            $proposal = $this->em->findProposal($proposal_id);
            if ($proposal) {
                if ($exclude_override == '0') {
                    if ($proposal->getResendExcluded() == 1) {
                        continue;
                    }
                }

                if ($sendIt) {


                    //Event Log
                    $this->getProposalEventRepository()->sendProposalCampaign($proposal, $account);

                    $to = (isset($emailData['emailClient']) && ($emailData['emailClient'] == false)) ? [] : [$proposal->getClient()->getEmail()];
                    if (isset($emailData['bcc']) && is_array($emailData['bcc'])) {
                        $to = array_merge($to, $emailData['bcc']);
                    }
                    $to = implode(" ", array_unique($to));


                    $pgse = new ProposalGroupResendEmail();
                    $pgse->setResendId($pgs->getId());
                    $pgse->setProposalId($proposal_id);
                    $pgse->setEmailAddress($to);
                    $pgse->setProposalStatusId($proposal->getStatus());
                    $pgse->setParentResendEmailId($Resend_proposal->id);
                    $this->em->persist($pgse);
                    $this->em->flush();
                    $pgseId = $pgse->getId();
                    $pgsId = $pgs->getId();


                    $job_array = [
                        'proposal_id' => $proposal_id,
                        'email_data' => $emailData,
                        'account_id' => $account->getAccountId(),
                        'logAction' => 'proposal_send',
                        'logMessage' => '',
                        'pgseId' => $pgseId,
                        'pgsId' => $pgsId,
                        'mail_to' => $to,
                        'proposal_status' => $proposal->getStatus()

                    ];

                    //if ($this->direct_send($proposal_id, $emailData, $account, $logAction, $logMessage, $pgse->getId())) {
                    // $proposal = $this->em->find('\models\Proposals', $proposal_id);

                    $CI->my_jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'send_individual_proposal_email_send', $job_array, 'test job');
                    $count++;
                    // }

                } else {
                    if (!$bounced) {
                        $unsentCount++;
                    }

                }
            }
        }

        if ($count) {
            //log group action
            $this->getLogRepository()->add([
                'action' => 'group_action_send',
                'details' => "Group Proposals Sent to {$count} clients",
                'account' => $account->getAccountId(),
                'company' => $account->getCompany()->getCompanyId(),
            ]);
            $this->sendAccountCC($emailData, $account, $count);
        }

        $out = [
            'sent' => $count,
            'unsent' => $unsentCount,
            'already_sent' => $alreadySentCount,
            'bouncedUnsentCount' => $bouncedUnsentCount,
        ];

        return $out;
    }

    public function create($companyId = null)
    {
        //setup basic proposal stuff
        $proposal = new \models\Proposals();
        $proposal->setAccessKey();
        $proposal->setCreated(time());
        //set resend stuff if company resend is set
        if ($companyId !== null) {
            $companyResendSettings = $this->getProposalNotificationsRepository()->getSettingsFromDb($companyId);
            if (@$companyResendSettings->enabled) {
                $proposal->setResendEnabled(1);
                $proposal->setResendFrequency(@$companyResendSettings->frequency);
                $proposal->setResendTemplate(@$companyResendSettings->template);
            }
        }
        return $proposal;
    }

    public function migrateAttachmentsFromLead($proposalId, $leadId)
    {
        $leadAttachments = $this->getLeadRepository()->getAttachments($leadId);
        $company = $this->scalar("select c.company as company from proposals p left join clients c on p.client = c.clientId where p.proposalId={$proposalId}", 'company');
        $proposalAttachmentsDir = UPLOADPATH . '/companies/' . $company . '/proposals/' . $proposalId . '/';
        $leadAttachmentsDir = UPLOADPATH . '/leads/' . $leadId . '/';
        if (!is_dir($proposalAttachmentsDir)) {

            mkdir($proposalAttachmentsDir, 0755, true);
        }
        foreach ($leadAttachments as $attachment) {
            copy($leadAttachmentsDir . $attachment->file_path, $proposalAttachmentsDir . $attachment->file_path);
            $this->insert('proposal_attachments', [
                'proposalId' => $proposalId,
                'fileName' => $attachment->file_name,
                'filePath' => $attachment->file_path,
                'ord' => 99
            ]);
        }
    }

    public function getAuditReminderProposals($minutes = 15)
    {
        $timestamp = Carbon::now()->subMinutes($minutes)->timestamp;

        // @TODO Remove the joins for testing
        $dql = "SELECT p
                FROM \models\Proposals p
                WHERE p.audit_key IS NOT NULL
                AND p.lastOpenTime > 1491855000
                AND p.lastOpenTime < " . $timestamp . "
                AND p.audit_view_time IS NULL
                AND p.audit_reminder_sent IS NULL
        ";

        return $this->getDqlResults($dql);
    }

    public function getSenderIps($proposalId)
    {
        $sql = "SELECT DISTINCT(l.ip) as ip
                FROM log l 
                WHERE l.action = 'proposal_send'
                AND proposal = " . $proposalId;

        $ips = $this->getAllResults($sql);

        $out = [];
        foreach ($ips as $data) {
            $out[] = $data->ip;
        }

        return $out;
    }

    /**
     * @param \models\Proposals $proposal
     * @param $dateString
     * @param \models\Accounts $account
     */
    public function updateWinDate(\models\Proposals $proposal, $dateString, \models\Accounts $account)
    {
        $oldWinDate = Carbon::createFromTimestamp($proposal->getWinDate());
        $newDate = Carbon::createFromFormat('m/d/Y', $dateString);

        $proposal->setWinDate($newDate->timestamp);
        $this->em->persist($proposal);
        $this->em->flush();

        $this->getLogRepository()->add([
            'action' => 'Win Date Change',
            'details' => 'Proposal Win Date changed to ' . $newDate->format('m/d/Y') . ' from ' . $oldWinDate->format('m/d/Y'),
            'client' => $proposal->getClient()->getClientId(),
            'proposal' => $proposal->getProposalId(),
            'company' => $proposal->getClient()->getCompany()->getCompanyId(),
            'account' => $account->getAccountId()
        ]);

    }

    /**
     * @param $proposalId
     * @return int
     */
    public function hasServices($proposalId)
    {
        return count($this->getServices($proposalId));
    }

    /**
     * @param $proposalId
     * @param bool $approvedOnly
     * @return array
     */
    public function getServices($proposalId)
    {
        $query = 'SELECT ps FROM models\Proposal_services ps
                  WHERE ps.proposal = ' . $proposalId . '
                  ORDER BY ps.ord, ps.serviceId';

        return $this->em->createQuery($query)->getResult();
    }

    /**
     * @param $proposalId
     * @param bool $approvedOnly
     * @return array
     */
    public function getNonHiddenServices($proposalId)
    {
        $query = 'SELECT ps FROM models\Proposal_services ps
                  WHERE ps.proposal = ' . $proposalId . '
                  AND ps.is_hide_in_proposal =0 ORDER BY ps.ord, ps.serviceId';

        return $this->em->createQuery($query)->getResult();
    }

    /**
     * @param $proposalId
     */
    public function unapproveAllServices($proposalId)
    {
        $this->db->query(
            'UPDATE proposal_services
            SET approved = 0
            WHERE proposal = ' . $proposalId
        );
    }

    /**
     * @param $serviceId
     */
    public function unapproveService($serviceId)
    {
        $this->db->query(
            'UPDATE proposal_services
            SET approved = 0
            WHERE serviceId = ' . $serviceId
        );
    }

    /**
     * @param $serviceId
     */
    public function approveService($serviceId)
    {
        $this->db->query(
            'UPDATE proposal_services
            SET approved = 1
            WHERE serviceId = ' . $serviceId
        );
    }

    public function updateUnapprovedServices(Proposals $proposal, $approver = null)
    {
        $initialValue = $proposal->getUnapprovedServices();

        $unapprovedServices = 0;
        if ($proposal->hasUnapprovedServices()) {
            $unapprovedServices = 1;
            $proposal->setApproved(0);
        } else {
            $proposal->setApproved(1);
        }
        $proposal->setUnapprovedServices($unapprovedServices);
        $this->em->persist($proposal);
        $this->em->flush();

        // If it is going from unapproved to approved, and is done by an admin, count as an approval
        if (($unapprovedServices == 0 && $initialValue == 1) && !is_null($approver)) {
            $this->sendProposalApprovedEmail($approver, $proposal);
        }
    }

    /**
     * @param Accounts $approver
     * @param Proposals $proposal
     */
    public function sendProposalApprovedEmail(Accounts $approver, Proposals $proposal)
    {
        $emailData = array(
            'firstName' => $approver->getFirstName(),
            'lastName' => $approver->getLastName(),
            'userFirstName' => $proposal->getOwner()->getFirstName(),
            'userLastName' => $proposal->getOwner()->getLastName(),
            'projectName' => $proposal->getProjectName(),
        );

        $this->getEmailRepository()->sendSystemEmail(25, $proposal->getOwner()->getEmail(), $emailData);
    }

    public function approve(Proposals $proposal)
    {
        $this->approveAllServices($proposal->getProposalId());
        $proposal->setUnapprovedServices(0);
        $proposal->setApprovalQueue(0);
        $proposal->setApproved(1);
        $this->save($proposal);
    }

    /**
     * @param $proposalId
     */
    public function approveAllServices($proposalId)
    {
        $this->db->query(
            'UPDATE proposal_services
            SET approved = 1
            WHERE proposal = ' . $proposalId
        );
    }

    public function save(Proposals $proposal)
    {
        $this->em->persist($proposal);
        $this->em->flush();
    }

    /**
     * If a proposal has unapproved services, we display an 'in progress' page
     * This alerts the owner of the proposal that someone tried to view the proposal
     * @var Proposals $proposal
     */
    public function sendInProgressViewEmail(Proposals $proposal)
    {
        $emailData = array(
            'project_name' => $proposal->getProjectName(),
        );
        $this->getEmailRepository()->sendSystemEmail(26, $proposal->getOwner()->getEmail(), $emailData);
    }

    function deleteProposalService(Proposal_services $service, Accounts $account)
    {

        $this->db->query("DELETE FROM proposal_services_fields WHERE serviceId = " . $service->getServiceId());
        $this->db->query("DELETE FROM proposal_services_texts WHERE serviceId = " . $service->getServiceId());
        $this->db->query("DELETE FROM estimate_line_items WHERE proposal_service_id = " . $service->getServiceId());
        $this->deleteServiceImages($service->getServiceId());
        $this->em->remove($service);
        $this->em->flush();

        $this->getLogRepository()->add([
            'action' => \models\ActivityAction::DELETE_PROPOSAL_SERVICE,
            'details' => "Deleted " . $service->getServiceName() . " from the proposal",
            'proposal' => $service->getProposal(),
            'account' => $account->getAccountId(),
            'company' => $account->getCompany()->getCompanyId(),
        ]);
    }

    public function saveProposalImage(Proposals $proposal, array $data, $fileName = '', $proposalServiceId = NULL, $map = 0)
    {

        if ($data) {
            $title = 'Image';
            if(isset($data['imgName'])){
                $title = $data['imgName'];
            }else{
                $title =  ($map)?'Site Map':'Image';
            }
            // Save against proposal
            $image = new \models\Proposals_images();
            $image->setProposal($proposal);
            $image->setOrder(999);
            $image->setImage($fileName);
            $image->setTitle($title);
            $image->setNotes((@isset($data['imgNotes']) ? $data['imgNotes'] : ''));
            $image->setActive(1);
            $image->setActivewo(1);
            $image->setProposalServiceId($proposalServiceId);
            $image->setMap($map);
            $this->em->persist($image);

            // Update the image count
            $proposal->setImageCount($this->getRealImageCount($proposal));
            $proposal->setRebuildFlag(1);
            $this->em->persist($proposal);

            $this->em->flush();

            return $image;
        } else {
            return false;
        }
    }

    public function rotateImage(Proposals_images $image, $rotateDegrees)
    {
        $im = new ImageManager();
        $img = $im->make($image->getFullPath());
        $img->rotate($rotateDegrees);
        $img->save($image->getFullPath());
    }

    function deleteProposalImage(Proposals_images $image, Accounts $account)
    {
        $this->getLogRepository()->add([
           // 'action' => 'proposal_delete_image',
            'action' => \models\ActivityAction::DELETE_PROPOSAL_IMAGE,
            'details' => "Deleted proposal image",
            'proposal' => $image->getProposal()->getProposalId(),
            'account' => $account->getAccountId(),
            'company' => $account->getCompany()->getCompanyId(),
        ]);

        $this->em->remove($image);
        $this->em->flush();
    }

    function deleteProposalAttachment(Proposal_attachments $attachment, Accounts $account)
    {
        $this->getLogRepository()->add([
            'action' => 'proposal_delete_attachment',
            'details' => "Deleted proposal attachment: " . $attachment->getFileName(),
            'proposal' => $attachment->getProposalId(),
            'account' => $account->getAccountId(),
            'company' => $account->getCompany()->getCompanyId(),
        ]);

        $this->em->remove($attachment);
        $this->em->flush();
    }

    public function numLogs($proposalId)
    {
        $sql = "SELECT COUNT(logId) As numLogs
                FROM log
                WHERE proposal = {$proposalId}";

        $query = $this->db->query($sql);
        return $query->result()[0]->numLogs;
    }

    public function numProposalPreview($proposalId)
    {
        $sql = "SELECT COUNT(id) As numView
                FROM proposal_preview_links
                WHERE no_tracking = 0 AND proposal_id = {$proposalId}";

        $query = $this->db->query($sql);
        if ($query->result()) {
            return $query->result()[0]->numView;
        } else {
            return 0;
        }

    }

    public function numProposalView($proposalId)
    {
        $sql = "SELECT COUNT(id) As numView
                FROM proposal_preview_links
                WHERE no_tracking =0 AND proposal_id = {$proposalId}
                GROUP BY id";

        $query = $this->db->query($sql);
        if ($query->result()) {
            return count($query->result());
        } else {
            return 0;
        }

    }

    /**
     *   Get the full project address string
     * @param Proposals $proposal
     * @return string
     */
    public function getProjectAddressStringLineBreak(Proposals $proposal)
    {

        $addrString = $proposal->getProjectAddress() . '</br>';

        if ($proposal->getProjectCity()) {
            $addrString .= ' ' . $proposal->getProjectCity() . '</br>';
        }

        if ($proposal->getProjectState()) {
            $addrString .= ' ' . $proposal->getProjectState() . '</br>';
        }

        if ($proposal->getProjectState()) {
            $addrString .= ' ' . $proposal->getProjectZip();
        }

        return $addrString;
    }

    /**
     * @param Proposals $proposal
     * @return bool
     */
    public function isMapped(Proposals $proposal)
    {
        if ($proposal->getLat() && $proposal->getLng()) {
            return true;
        }
        return false;
    }

    /**
     * @param Proposals $proposal
     */
    function setLatLng(Proposals $proposal)
    {
        $proposal->setGeocoded(1);
        if (strlen($proposal->getProjectAddressString()) > 8) {

            try {
                $coords = $this->getCoords($proposal);

                if ($coords) {
                    $proposal->setLat($coords['lat']);
                    $proposal->setLng($coords['lng']);
                } else {
                    $proposal->setLat(NULL);
                    $proposal->setLng(NULL);
                }
            } catch (\Exception $e) {
                // Do nothing
            }
        }
        $this->em->persist($proposal);
        $this->em->flush();
    }

    /**
     *  Return an array with keys 'lat' and 'lng' with the geocoded coordinates if found. Returns NULL if not.
     * @param Proposals $proposal
     * @return mixed
     */
    public function getCoords(Proposals $proposal)
    {
        $address = $this->getProjectAddressString($proposal);

        $curl = new \Ivory\HttpAdapter\CurlHttpAdapter();
        $geocoder = new \Geocoder\Provider\GoogleMaps($curl, null, null, true, $_ENV['GOOGLE_API_SERVER_KEY']);

        $results = $geocoder->geocode($address);

        if ($results->count()) {
            $iterator = $results->getIterator();
            $result = $iterator->current();

            return [
                'lat' => $result->getLatitude(),
                'lng' => $result->getLongitude()
            ];
        } else {
            return null;
        }
    }

    /**
     *   Get the full project address string
     * @param Proposals $proposal
     * @return string
     */
    public function getProjectAddressString(Proposals $proposal)
    {

        $addrString = $proposal->getProjectAddress();

        if ($proposal->getProjectCity()) {
            $addrString .= ' ' . $proposal->getProjectCity();
        }

        if ($proposal->getProjectState()) {
            $addrString .= ' ' . $proposal->getProjectState();
        }

        if ($proposal->getProjectState()) {
            $addrString .= ' ' . $proposal->getProjectZip();
        }

        return $addrString;
    }

    public function proposalExportCSV(Accounts $account)
    {
        // Get the data
        $proposalData = $account->getProposalsData(false, false, 10000);

        // Create the writer
        $writer = Writer::createFromFileObject(new \SplTempFileObject());

        // Headings
        $headingData = [
            'Date Created',
            'Owner',
            'Status',
            //'Branch',
            'Job Number',
            'Project Name',
            'Project Address',
            'Project City',
            'Project State',
            'Project Zip',
            'Contact First Name',
            'Contact Last Name',
            'Contact Company',
            'Contact Title',
            'Contact Office Phone',
            'Contact Cell Phone',
            'Contact Email',
            'Total Price',
            'Last Activity',
            'Last Email Send',
            'Sold Date',
            'Lat',
            'Lng',
            'Services',
            'Last Open Time',
            'Audit Status'
        ];

        // Add the headings
        $writer->insertOne($headingData);

        // Loop through the data
        foreach ($proposalData as $row) {

            // Load the proposal
            $proposal = $this->em->findProposal($row->proposalId);

            // Services
            $serviceString = '';
            $proposalServices = $proposal->getServices();

            $servicesArray = [];
            $first = true;
            $audit_title = '';
            if ($proposal->getAuditKey() && !$proposal->getAuditViewTime()) {
                $audit_title = 'Audit Linked';

                if ($proposal->getAuditReminderSent()) {
                    $audit_title .= ' - Reminder Sent: ' . date('m/d/Y g:ia', realTime($proposal->getAuditReminderSent()));
                } else if ($proposal->getAuditViewTime()) {

                    $audit_title = "Audit Last Opened:" . date('m/d/Y g:ia', realTime($proposal->getAuditViewTime()));

                }
            }

            foreach ($proposalServices as $proposalService) {
                if (!$first) {
                    $serviceString .= ' / ';
                }
                /* @var \models\Proposal_services $proposalService */
                $serviceString .= $proposalService->getServiceName() . ' - ' . $proposalService->getFormattedPrice();
                $serviceString .= " ";
                $first = false;
            }

            $rowData = [
                date('m/d/Y g:ia', $row->created),
                $row->accountFN . ' ' . $row->accountLN,
                $row->statusText,
                //$row->branchName ?: 'Main',
                $row->jobNumber,
                $row->projectName,
                $row->projectAddress,
                $row->projectCity,
                $row->projectState,
                $row->projectZip,
                $row->clientFN,
                $row->clientLN,
                $row->clientAccountName,
                $row->clientTitle,
                $row->clientBP,
                $row->clientCP,
                $row->clientEmail,
                '$' . number_format($row->price),
                date('m/d/Y g:ia', $row->last_activity),
                date('m/d/Y g:ia', $row->emailSendTime),
                $row->win_date ? date('m/d/Y g:i:a', $row->win_date) : 'n/a',
                $row->lat,
                $row->lng,
                $serviceString,
                $row->lastOpenTime ? date('m/d/Y g:i:a', $row->lastOpenTime) : '',
                $audit_title
            ];
            $writer->insertOne($rowData);
        };

        // Output the csv
        return $writer->output();
    }

    /**
     * @param Proposals $proposal
     * @param Accounts $account
     * @return array
     */
    public function getProposalInfo(Proposals $proposal, Accounts $account)
    {
        // Account
        $clientAccount = [
            'name' => $proposal->getClient()->getClientAccount()->getName()
        ];

        // Contact
        $contact = [
            'fullName' => $proposal->getClient()->getFullName(),
            'phone' => $proposal->getClient()->getBusinessPhone(),
            'cellPhone' => $proposal->getClient()->getCellPhone(),
            'email' => $proposal->getClient()->getEmail(),
            'title' => $proposal->getClient()->getTitle()
        ];

        // Proposal Services
        $services = [];
        $optionalServices = [];
        $proposalServices = $proposal->getServices();
        foreach ($proposalServices as $proposalService) {
            /* @var \models\Proposal_services $proposalService */
            $serviceData = [];
            $serviceData['title'] = $proposalService->getServiceName();
            $serviceData['price'] = $proposalService->getPrice(true);

            if (!$proposalService->isOptional()) {
                $services[] = $serviceData;
            } else {
                $optionalServices[] = $serviceData;
            }
        }

        // Proposal Notes
        $notes = [];
        $proposalNotes = $this->getProposalRepository()->getNotes($proposal);
        foreach ($proposalNotes as $note) {
            /* @var \models\Notes $note */
            $noteData = [];
            $noteData['date'] = date('m/d/y', $note->getAdded());
            $noteData['text'] = $note->getNoteText();
            $notes[] = $noteData;
        }

        // Proposal Permission
        $permission = $this->hasEditPermission($proposal, $account);

        // Proposal
        $proposalData = [
            'id' => $proposal->getProposalId(),
            'projectName' => $proposal->getProjectName(),
            'projectAddress' => $proposal->getProjectAddress(),
            'projectCity' => $proposal->getProjectCity(),
            'projectState' => $proposal->getProjectState(),
            'projectZip' => $proposal->getProjectZip(),
            'statusId' => $proposal->getProposalStatus()->getStatusId(),
            'statusName' => $proposal->getProposalStatus()->getText(),
            'proposalDate' => date('m/d/y', $proposal->getCreated(false)),
            'lastActivity' => date('m/d/y g:ia', $proposal->getLastActivity()),
            'price' => ($proposal->getPrice()) ? str_replace(array(',', '$'), '', $proposal->getPrice()) : 0,
            'lat' => $proposal->getLat(),
            'lng' => $proposal->getLng(),
            'services' => $services,
            'optionalServices' => $optionalServices,
            'ownerName' => $proposal->getOwner()->getFullName(),
            'notes' => $notes,
            'permission' => $permission,
            'accessKey' => $proposal->getAccessKey()
        ];

        // Build data array
        $data = [
            'clientAccount' => $clientAccount,
            'contact' => $contact,
            'proposal' => $proposalData
        ];

        return $data;
    }

    public function getNotes(Proposals $proposal)
    {
        $notes = $this->em->createQuery("SELECT n 
          FROM models\Notes n WHERE n.type= 'proposal' 
          AND n.relationId=" . $proposal->getProposalId() . "
          ORDER BY n.added DESC")->getResult();

        return $notes;
    }

    /**
     * @param Proposals $proposal
     * @param Accounts $account
     * @return bool
     */
    public function hasEditPermission(Proposals $proposal, Accounts $account)
    {
        // Must belong to company
        if ($proposal->getOwner()->getCompanyId() !== $account->getCompanyId()) {
            return false;
        }

        // Full access
        if ($account->hasFullAccess()) {
            return true;
        }

        // Branch manager
        if ($account->isBranchAdmin()) {
            if ($proposal->getOwner()->getBranch() == $account->getBranch()) {
                return true;
            }
            return false;
        }

        // Owner
        if ($proposal->getOwner()->getAccountId() == $account->getAccountId()) {
            return true;
        }

        return false;
    }

    public function modifyPrice(Accounts $account, Proposals $proposal, $multiplier)
    {

        try {
            // Original Price for logging
            $oldProposalPrice = number_format($proposal->getPrice());
            // Readable modifier
            $modifier = (($multiplier - 1) * 100) . '%';

            // Get the services
            $services = $proposal->getServices();

            // Apply the price adjustment
            foreach ($services as $service) {
                $oldPrice = $service->getPrice(true);
                $newPrice = round($oldPrice * $multiplier);
                $formattedNewPrice = '$' . number_format($newPrice);

                $service->setPrice($formattedNewPrice);
                $this->em->persist($service);
            }
            $this->em->flush();

            // Update the proposal price
            updateProposalPrice($proposal->getProposalId());

            // Refresh the proposal object
            //$this->em->refresh($proposal);
            $newProposalPrice = number_format($proposal->getPrice());

            // Log
            $logText = 'Proposal price adjusted by ' . $modifier . ' from $' . $oldProposalPrice . ' to $' . $newProposalPrice;
            $this->getLogRepository()->add([
                'account' => $account->getAccountId(),
                'company' => $account->getCompanyId(),
                'action' => 'price_modify',
                'details' => $logText,
                'userName' => $account->getFullName(),
                'proposal' => $proposal->getProposalId(),
                'client' => $proposal->getClient()->getClientId()
            ]);

            return true;
        } catch (\Exception $e) {
            return false;
        }

    }

    public function deleteSignees(Proposals $proposal)
    {
        $this->db->query("DELETE FROM proposal_signees WHERE proposal_id = " . $proposal->getProposalId());
    }

    public function getClientSignee(Proposals $proposal)
    {
        $dql = "SELECT ps
                FROM \models\ProposalSignee ps
                WHERE ps.proposal_id = " . $proposal->getProposalId() . "
                AND ps.signee_type = " . ProposalSignee::CLIENT;

        $results = $this->getDqlResults($dql);

        if ($results) {
            return $results[0];
        }

        return false;
    }


    public function getCompanySignee(Proposals $proposal)
    {
        $dql = "SELECT ps
                FROM \models\ProposalSignee ps
                WHERE ps.proposal_id = " . $proposal->getProposalId() . "
                AND ps.signee_type = " . ProposalSignee::COMPANY;

        $results = $this->getDqlResults($dql);

        if ($results) {
            return $results[0];
        }

        return false;
    }

    public function getClientSignature(Proposals $proposal)
    {
        $dql = "SELECT ps
                FROM \models\ProposalSignature ps
                WHERE ps.is_deleted = 0 AND ps.sig_type = 1 AND ps.proposal_id = " . $proposal->getProposalId();

        $results = $this->getDqlResults($dql);

        if ($results) {
            return $results[0];
        }

        return false;
    }

    public function getCompanySignature(Proposals $proposal)
    {
        $dql = "SELECT ps
                FROM \models\ProposalSignature ps
                WHERE ps.is_deleted = 0 AND ps.sig_type = 2 AND ps.proposal_id = " . $proposal->getProposalId();

        $results = $this->getDqlResults($dql);

        if ($results) {
            return $results[0];
        }

        return false;
    }

    public function getProposalServiceDetails(Companies $company, Proposals $proposal)
    {
        $proposalServices = $proposal->getServices();
        $out = [];

        foreach ($proposalServices as $service) {

            // Return array of details
            $out[$service->getServiceId()] = [
                'service' => $service,
                'serviceName' => $service->getServiceName(),
                'fields' => $this->getPopulatedServiceFields($company, $service)
            ];

        }

        return $out;
    }

    public function getPopulatedServiceFields(Companies $company, Proposal_services $proposalService)
    {
        $fields = $this->getProposalServiceFieldCodes($company, $proposalService);
        $out = [];

        foreach ($fields as $field) {
            $out[$field->getFieldId()] = [];
            $out[$field->getFieldId()]['field'] = $field;
            $out[$field->getFieldId()]['values'] = $this->getProposalServiceFieldCodesValues($proposalService->getServiceId(), $field->getFieldCode());
            $out[$field->getFieldId()]['cesf'] = $this->getEstimationRepository()->getEstimateServiceField($company, $field);
        }

        return $out;
    }

    public function getProposalServiceFieldCodes(Companies $company, Proposal_services $proposalService)
    {
        return $company->getServiceFields($proposalService->getInitialService());
    }

    public function getProposalServiceFieldCodesValues($proposalServiceId, $fieldCode)
    {
        return $this->em->getRepository('models\Proposal_services_fields')->findOneBy(array(
            'serviceId' => $proposalServiceId,
            'fieldCode' => $fieldCode
        ));
    }

    public function getProposalServiceFieldValues(Companies $company, Proposal_services $proposalService)
    {
        $serviceId = $proposalService->getInitialService();
        $service = $this->em->findService($serviceId);

        // Return array of details
        $out = [
            'serviceName' => $service->getServiceName(),
            'fields' => $this->getPopulatedServiceFieldsInfo($company, $proposalService)
        ];

        return $out;
    }

    public function getPopulatedServiceFieldsInfo(Companies $company, Proposal_services $proposalService)
    {
        $fields = $this->getProposalServiceFieldCodes($company, $proposalService);
        $out = [];

        foreach ($fields as $field) {
            $out[$field->getFieldId()] = [];
            $out[$field->getFieldId()]['field'] = $field->getFieldName();
            $out[$field->getFieldId()]['value'] = $this->getProposalServiceFieldCodeValueInfo($proposalService->getServiceId(), $field->getFieldCode());
        }

        return $out;
    }

    public function getProposalServiceFieldCodeValueInfo($proposalServiceId, $fieldCode)
    {
        $field = $this->em->getRepository('models\Proposal_services_fields')->findOneBy(array(
            'serviceId' => $proposalServiceId,
            'fieldCode' => $fieldCode
        ));

        return $field->getFieldValue();
    }

    public function getProposalPlants(Proposals $proposal)
    {
        $query = 'SELECT pp FROM models\ProposalPlant pp
                  WHERE pp.proposal_id = ' . $proposal->getProposalId();

        return $this->em->createQuery($query)->getResult();
    }

    public function getAllTruckingDirections(Proposals $proposal)
    {
        $out = [];
        //$proposalPlants = $this->getProposalPlants($proposal);
        $proposalPlantIds = $this->getEstimationRepository()->getProposalPlantIds($proposal);

        if ($proposal->getGeocoded()) {
            foreach ($proposalPlantIds as $proposalPlantId) {

                $plant = $this->em->findEstimationPlant($proposalPlantId);

                $out[$plant->getId()] = [
                    'plant' => $plant
                ];
                // Path for image
                $imageUrl = "https://dev.virtualearth.net/REST/v1/Imagery/Map/Road/Routes/Truck?routeAttributes=routePath&wp.0=" .
                    $proposal->getLat() . "," . $proposal->getLng() . "&key=" . BING_MAPS_KEY;

                // Local image path
                $localImage = UPLOADPATH . '/work_order_maps/map_' . $proposal->getProposalId() . '-' . $plant->getId() . '.png';

                // Delete it if it exists
                if (file_exists($localImage)) {
                    unlink($localImage);
                }

                // Save the image
                $im = new ImageManager();
                $image = $im->make($imageUrl);
                $image->save($localImage);

                // Now we need directions
                $routePath = "https://dev.virtualearth.net/REST/V1/Routes/Truck?" .
                    "wp.0=" . $plant->getLat() . ',' . $plant->getLng() .
                    "&wp.1=" . $proposal->getLat() . ',' . $proposal->getLng() .
                    "&key=" . BING_MAPS_KEY;

                // Hit the API
                $client = new \GuzzleHttp\Client();
                $result = $client->request('GET', $routePath);

                // Get the response
                $response = \GuzzleHttp\json_decode($result->getBody()->getContents());

                $out[$plant->getId()]['distance'] = number_format($response->resourceSets[0]->resources[0]->travelDistance, 2);
                $out[$plant->getId()]['directions'] = $response->resourceSets[0]->resources[0]->routeLegs[0]->itineraryItems;
            }
        }

        return $out;
    }

    /**
     * @param Proposal_services $proposalService
     * @return array
     */
    public function getIndexedSavedProposalServiceFields(Proposal_services $proposalService)
    {
        $out = [];
        $fields = $this->getSavedProposalServiceFields($proposalService);

        foreach ($fields as $field) {
            $out[$field->getFieldCode()] = $field;
        }

        return $out;
    }

    /**
     * @param Proposal_services $proposalService
     * @return mixed
     */
    public function getSavedProposalServiceFields(Proposal_services $proposalService)
    {
        $dql = "SELECT psf
            FROM \models\Proposal_services_fields psf
            WHERE psf.serviceId = " . $proposalService->getServiceId();

        return $this->getDqlResults($dql);
    }

    /**
     * @param array $oldFields
     * @param array $newFields
     * @return string
     */
    public function getFieldsChangedText(array $oldFields, array $newFields)
    {
        $changeStrings = [];

        if (count($oldFields) && count($newFields))
            $changes = $this->getProposalServiceDifferences($oldFields, $newFields);

        foreach ($changes as $change) {
            $changeStrings[] = '<strong>' . $change['field'] . ':</strong> changed from ' . $change['oldValue'] . ' to ' . $change['newValue'];
        }

        return implode('<br />', $changeStrings);
    }

    /**
     * @param array $oldFields
     * @param array $newFields
     * @return array
     */
    public function getProposalServiceDifferences(array $oldFields, array $newFields)
    {

        $changes = [];

        // Loop through new fields and check against old field
        foreach ($newFields as $k => $field) {

            if (isset($oldFields[$k])) {
                $oldValue = $oldFields[$k]->getFieldValue();
                $newValue = $field->getFieldValue();

                if ($oldValue != $newValue) {
                    $changes[] = [
                        'oldValue' => $oldValue,
                        'newValue' => $newValue,
                        'field' => $k
                    ];
                }
            }
        }

        return $changes;
    }

    /**
     * @param Proposals $proposal
     * @param Accounts $senderAccount
     * @return array
     */
    public function okToSend(Proposals $proposal, Accounts $senderAccount)
    {
        // We'll respond with an array - status and reason
        $response = [
            'error' => 0,
            'message' => ''
        ];

        // Step 1 - Check the price
        $proposalPrice = $proposal->getPrice();

        if ($proposalPrice <= 0) {

            $response ['error'] = 1;
            $response ['message'] = 'Proposal has $0 price';

            return $response;
        }

        // Step 2 - Check estimate status
        $response['error'] = 0;
        // Does this proposal have any items?
        switch ($proposal->getEstimateStatusId()) {

            // Not started, complete or locked let them through
            case EstimateStatus::NOT_STARTED:
            case EstimateStatus::COMPLETE:
            case EstimateStatus::LOCKED:
                break;

            // In progress or not completed
            case EstimateStatus::IN_PROGRESS:
            case EstimateStatus::ALL_SERVICES_ESTIMATED:
                $response ['error'] = 1;
                $response ['message'] = 'Estimate has not been completed';
            //return $response;
        }


        return $response;
    }

    /**
     * @param Proposals $proposal
     * @param Accounts $senderAccount
     * @return array
     */
    public function okToView(Proposals $proposal, Accounts $senderAccount)
    {
        // We'll respond with an array - status and reason
        $response = [
            'error' => 0,
            'message' => ''
        ];

        // Testing
        $response ['error'] = 1;
        $response ['message'] = 'Testing error';

        return $response;

        // Step 1 - Check the price
        $proposalPrice = $proposal->getPrice();

        if ($proposalPrice <= 0) {

            $response ['error'] = 1;
            $response ['message'] = 'Proposal has $0 price';

            return $response;
        }

        // Step 2 - Check estimate status

        // Does this proposal have any items?
        switch ($proposal->getEstimateStatusId()) {

            // Not started, complete or locked let them through
            case EstimateStatus::NOT_STARTED:
            case EstimateStatus::COMPLETE:
            case EstimateStatus::LOCKED:
                break;

            // In progress or not completed
            case EstimateStatus::IN_PROGRESS:
            case EstimateStatus::ALL_SERVICES_ESTIMATED:
                $response ['error'] = 1;
                $response ['message'] = 'Estimate has not been completed';
                return $response;
        }

        $response['error'] = 0;

        return $response;
    }

    function distance($lat1, $lon1, $lat2, $lon2, $unit)
    {
        if (($lat1 == $lat2) && ($lon1 == $lon2)) {
            return 0;
        } else {
            $theta = $lon1 - $lon2;
            $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
            $dist = acos($dist);
            $dist = rad2deg($dist);
            $miles = $dist * 60 * 1.1515;
            $unit = strtoupper($unit);

            if ($unit == "K") {
                return ($miles * 1.609344);
            } else if ($unit == "N") {
                return ($miles * 0.8684);
            } else {
                return $miles;
            }
        }
    }

    function getProposalEvents($proposalId)
    {
        $sql = "SELECT pe.*,a.fullName,pet.type_icon,pet.type_name
        FROM proposal_events pe 
        left join accounts a on pe.account_id = a.accountId
        left join proposal_events_types pet on pe.type_id = pet.id
        WHERE pe.proposal_id = " . $proposalId . " order by pe.created_at ASC";

        return $this->getAllResults($sql);


    }

    function getProposalEventTypes()
    {

        $dql = "SELECT pet
        FROM \models\ProposalEventType pet  
        ORDER BY pet.ord ASC";
        $query = $this->em->createQuery($dql);
        //Cache It
        $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_PROPOSAL_EVENT_TYPE);
        return $query->getResult();
    }

    function getProposalEventEmailTypes()
    {
        $dql = "SELECT eet
        FROM \models\EventMailType eet  ORDER BY eet.id ASC";
        $query = $this->em->createQuery($dql);
        //Cache It
        $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_EVENT_EMAIL_TYPE);
        return $query->getResult();
    }

    /**
     * @param Accounts $account
     * @return array
     */

    function getProposalSavedFilters(Accounts $account)
    {
        $sql = "SELECT spf.*
        FROM saved_proposal_filter spf WHERE user_id = " . $account->getAccountId() . " AND filter_page = 'Proposal' ORDER BY ord";

        return $this->getAllResults($sql);
    }

    function getProposalEventsByType($proposalId, $types)
    {
        $sql = "SELECT pe.*,a.fullName,pet.type_icon,pet.type_name
        FROM proposal_events pe 
        left join accounts a on pe.account_id = a.accountId
        left join proposal_events_types pet on pe.type_id = pet.id
        WHERE pe.proposal_id = " . $proposalId . " AND pet.id IN(" . $types . ") order by pe.created_at ASC";

        return $this->getAllResults($sql);
    }

    /**
     * @param ProposalGroupResend $resend
     * @param $account
     * @return array
     */
    public function getResendStats(ProposalGroupResend $resend, $account)
    {
        $out = [
            'sent' => $this->getNumResendEmails($resend, $account),
            'delivered' => $this->getNumDeliveredResendEmails($resend, $account),
            'bounced' => $this->getNumBouncedResendEmails($resend, $account),
            'opened' => $this->getNumOpenedResendEmails($resend, $account),
            'unopened' => $this->getNumUnopenedResendEmails($resend, $account),
            'clicked' => $this->getNumClickedResendEmails($resend, $account),
            'note_added' => $this->getNewNotesResendEmails($resend, $account),
            'failed_count' => $this->getNumFailedResendEmails($resend, $account)
        ];

        return $out;
    }

    public function getNumResendEmails(ProposalGroupResend $resend, $account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numSent
        FROM proposal_group_resend_email pgre";


        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE pgre.resend_id ={$resendId}";
        } else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            // $sql .= ' WHERE a.branch = ' . $account->getBranch() . '
            //     AND pgr.company_id=' . $company->getCompanyId();

            $sql .= " LEFT JOIN
            proposals p1 ON pgre.proposal_id = p1.proposalId
            LEFT JOIN accounts AS a2 ON p1.owner = a2.accountId   WHERE pgre.resend_id ={$resendId} AND a2.branch = " . $account->getBranch();
        } else {

            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            $sql .= " LEFT JOIN
                proposals ON pgre.proposal_id = proposals.proposalId WHERE pgre.resend_id ={$resendId}
                AND 
                proposals.owner = " . $account->getAccountId();
        }
        //WHERE pgre.resend_id = " . $resend->getId();
        $sql .= " AND pgre.is_failed = 0";
        $data = $this->getSingleResult($sql);

        return $data->numSent;
    }

    public function getNumFailedResendEmails(ProposalGroupResend $resend, $account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(fj.id) AS numFailed
        FROM failed_jobs fj";


        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= " WHERE fj.campaign_id ={$resendId} AND job_type= 'proposal_campaign' ";
        } else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            // $sql .= ' WHERE a.branch = ' . $account->getBranch() . '
            //     AND pgr.company_id=' . $company->getCompanyId();

            $sql .= " LEFT JOIN
            proposals p1 ON fj.entity_id = p1.proposalId
            LEFT JOIN accounts AS a2 ON p1.owner = a2.accountId   WHERE fj.campaign_id ={$resendId} AND job_type= 'proposal_campaign' AND a2.branch = " . $account->getBranch();
        } else {

            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            $sql .= " LEFT JOIN
                proposals ON fj.entity_id = proposals.proposalId WHERE fj.campaign_id ={$resendId}
                AND job_type= 'proposal_campaign' AND 
                proposals.owner = " . $account->getAccountId();
        }
        //WHERE pgre.resend_id = " . $resend->getId();

        $data = $this->getSingleResult($sql);

        return $data->numFailed;
    }

    public function getNumDeliveredResendEmails(ProposalGroupResend $resend, $account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numDelivered
        FROM proposal_group_resend_email pgre";
        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            //$sql .= ' WHERE  pgr.company_id=' . $company->getCompanyId();
            $sql .= " WHERE pgre.resend_id ={$resendId} AND delivered_at IS NOT NULL";
        } else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            // $sql .= ' WHERE a.branch = ' . $account->getBranch() . '
            //     AND pgr.company_id=' . $company->getCompanyId();
            $sql .= " LEFT JOIN
            proposals p1 ON pgre.proposal_id = p1.proposalId
            LEFT JOIN accounts AS a2 ON p1.owner = a2.accountId   WHERE pgre.resend_id ={$resendId} AND delivered_at IS NOT NULL AND a2.branch = " . $account->getBranch();
            //$sql .= " WHERE pgre.resend_id ={$resendId} AND delivered_at IS NOT NULL";
        } else {

            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            $sql .= " LEFT JOIN
                    proposals ON pgre.proposal_id = proposals.proposalId WHERE pgre.resend_id ={$resendId}
                    AND delivered_at IS NOT NULL AND 
                    proposals.owner = " . $account->getAccountId();
        }
        $sql .= " AND pgre.is_failed = 0";
        // WHERE pgre.resend_id = " . $resend->getId() . "
        // AND delivered_at IS NOT NULL";

        $data = $this->getSingleResult($sql);

        return $data->numDelivered;
    }

    public function getNumBouncedResendEmails(ProposalGroupResend $resend, $account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numBounced
        FROM proposal_group_resend_email pgre";
        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            //$sql .= ' WHERE  pgr.company_id=' . $company->getCompanyId();
            $sql .= " WHERE pgre.resend_id ={$resendId} AND bounced_at IS NOT NULL";
        } else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            $sql .= " LEFT JOIN
            proposals p1 ON pgre.proposal_id = p1.proposalId
            LEFT JOIN accounts AS a2 ON p1.owner = a2.accountId   WHERE pgre.resend_id ={$resendId} AND bounced_at IS NOT NULL AND a2.branch = " . $account->getBranch();
            //$sql .= " WHERE pgre.resend_id ={$resendId} AND bounced_at IS NOT NULL";
        } else {

            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            $sql .= " LEFT JOIN
                    proposals ON pgre.proposal_id = proposals.proposalId WHERE pgre.resend_id ={$resendId}
                    AND bounced_at IS NOT NULL AND 
                    proposals.owner = " . $account->getAccountId();
        }
        $sql .= " AND pgre.is_failed = 0";
        // WHERE pgre.resend_id = " . $resend->getId() . "
        // AND bounced_at IS NOT NULL";

        $data = $this->getSingleResult($sql);

        return $data->numBounced;
    }

    public function getNumOpenedResendEmails(ProposalGroupResend $resend, $account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numOpened
        FROM proposal_group_resend_email pgre";
        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            //$sql .= ' WHERE  pgr.company_id=' . $company->getCompanyId();
            $sql .= " WHERE pgre.resend_id ={$resendId} AND opened_at IS NOT NULL";
        } else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            $sql .= " LEFT JOIN
            proposals p1 ON pgre.proposal_id = p1.proposalId
            LEFT JOIN accounts AS a2 ON p1.owner = a2.accountId   WHERE pgre.resend_id ={$resendId} AND opened_at IS NOT NULL AND a2.branch = " . $account->getBranch();
            //$sql .= " WHERE pgre.resend_id ={$resendId} AND opened_at IS NOT NULL";
        } else {

            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            $sql .= " LEFT JOIN
                    proposals ON pgre.proposal_id = proposals.proposalId WHERE pgre.resend_id ={$resendId}
                    AND opened_at IS NOT NULL AND 
                    proposals.owner = " . $account->getAccountId();
        }
        $sql .= " AND pgre.is_failed = 0";
        // WHERE pgre.resend_id = " . $resend->getId() . "
        // AND opened_at IS NOT NULL";

        $data = $this->getSingleResult($sql);

        return $data->numOpened;
    }

    public function getNumClickedResendEmails(ProposalGroupResend $resend, $account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numClicked
        FROM proposal_group_resend_email pgre";
        if ($account->isAdministrator() && $account->hasFullAccess()) {

            $sql .= " WHERE pgre.resend_id ={$resendId} AND clicked_at IS NOT NULL";
        } else if ($account->isBranchAdmin()) {
            $sql .= " LEFT JOIN
            proposals p1 ON pgre.proposal_id = p1.proposalId
            LEFT JOIN accounts AS a2 ON p1.owner = a2.accountId WHERE pgre.resend_id ={$resendId} AND clicked_at IS NOT NULL AND a2.branch = " . $account->getBranch();

        } else {


            $sql .= " LEFT JOIN
                    proposals ON pgre.proposal_id = proposals.proposalId WHERE pgre.resend_id ={$resendId}
                    AND clicked_at IS NOT NULL AND 
                    proposals.owner = " . $account->getAccountId();
        }
        $sql .= " AND pgre.is_failed = 0";

        $data = $this->getSingleResult($sql);

        return $data->numClicked;
    }

    public function getNumUnopenedResendEmails(ProposalGroupResend $resend, $account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(*) AS numUnopened
        FROM proposal_group_resend_email pgre";
        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            //$sql .= ' WHERE  pgr.company_id=' . $company->getCompanyId();
            $sql .= " WHERE pgre.resend_id ={$resendId} AND opened_at IS NULL";
        } else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            $sql .= " LEFT JOIN
            proposals p1 ON pgre.proposal_id = p1.proposalId
            LEFT JOIN accounts AS a2 ON p1.owner = a2.accountId WHERE pgre.resend_id ={$resendId} AND opened_at IS NULL AND a2.branch = " . $account->getBranch();
            //$sql .= " WHERE pgre.resend_id ={$resendId} AND opened_at IS NULL";
        } else {

            //$sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
            $sql .= " LEFT JOIN
                    proposals ON pgre.proposal_id = proposals.proposalId WHERE pgre.resend_id ={$resendId}
                    AND opened_at IS NULL AND 
                    proposals.owner = " . $account->getAccountId();
        }
        $sql .= " AND pgre.is_failed = 0";
        // WHERE pgre.resend_id = " . $resend->getId() . "
        // AND opened_at IS NULL";

        $data = $this->getSingleResult($sql);

        return $data->numUnopened;
    }

    public function getNewNotesResendEmails(ProposalGroupResend $resend, $account)
    {
        $resendId = $resend->getId();
        $sql = "SELECT pgre.id
        FROM proposal_group_resend_email pgre LEFT JOIN proposal_group_resends pgr ON pgre.resend_id = pgr.id LEFT JOIN notes ON pgre.proposal_id = notes.relationId AND notes.type = 'proposal'";
        if ($account->isAdministrator() && $account->hasFullAccess()) {

            $sql .= "WHERE pgre.resend_id ={$resendId} AND notes.added > UNIX_TIMESTAMP(pgr.created) ";
        } else if ($account->isBranchAdmin()) {
            $sql .= " LEFT JOIN
            proposals p1 ON pgre.proposal_id = p1.proposalId
            LEFT JOIN accounts AS a2 ON p1.owner = a2.accountId WHERE pgre.resend_id ={$resendId} AND notes.added > UNIX_TIMESTAMP(pgr.created) AND a2.branch = " . $account->getBranch();

        } else {


            $sql .= " LEFT JOIN
                    proposals ON pgre.proposal_id = proposals.proposalId WHERE pgre.resend_id ={$resendId}
                    AND notes.added > UNIX_TIMESTAMP(pgr.created) AND 
                    proposals.owner = " . $account->getAccountId();
        }
        $sql .= " AND pgre.is_failed = 0";
        $sql .= " group by pgre.id";
//echo $sql;die;
        $data = $this->getAllResults($sql);
//        print_r(count($data));die;

        return count($data);
    }

    public function getChildResend($resend_id)
    {

        $sql = "SELECT pgr.id,pgr.resend_name
        FROM proposal_group_resends pgr 
        
        WHERE pgr.parent_resend_id = " . $resend_id . " AND pgr.is_deleted=0 order by id desc";

        return $this->getAllResults($sql);

    }

    public function getAllWeeklyReportUsers()
    {
        $sql = "SELECT a.accountId
        FROM accounts a 
        left join companies c on a.company = c.companyId
        WHERE a.weekly_email_report = '1' AND (c.companyStatus = 'Test' OR c.companyStatus = 'Active')";

        return $this->getAllResults($sql);
    }

    public function getBrachAllUsers($branchId)
    {
        $sql = "SELECT a.accountId
        FROM accounts a 
        -- left join companies c on a.company = c.companyId
        WHERE a.weekly_email_report = '1' AND a.deleted = '0' AND a.branch = " . $branchId;

        return $this->getAllResults($sql);
    }

    public function getAllMonthlyReportUsers()
    {
        $sql = "SELECT a.accountId
        FROM accounts a 
        left join companies c on a.company = c.companyId
        WHERE a.monthly_email_report = '1' AND (c.companyStatus = 'Test' OR c.companyStatus = 'Active')";

        return $this->getAllResults($sql);
    }

    public function getAlldailySalesReportUsers()
    {
        $sql = "SELECT a.accountId
        FROM accounts a 
        left join companies c on a.company = c.companyId
        WHERE a.sales_report_emails = '1' AND a.email_frequency = '1' AND (c.companyStatus = 'Test' OR c.companyStatus = 'Active')";

        return $this->getAllResults($sql);
    }

    public function getAllWeeklySalesReportUsers()
    {
        $sql = "SELECT a.accountId
        FROM accounts a 
        left join companies c on a.company = c.companyId
        WHERE a.sales_report_emails = '1' AND a.email_frequency = '2' AND (c.companyStatus = 'Test' OR c.companyStatus = 'Active')";

        return $this->getAllResults($sql);
    }

    public function getAllMonthlySalesReportUsers()
    {
        $sql = "SELECT a.accountId
        FROM accounts a 
        left join companies c on a.company = c.companyId
        WHERE a.sales_report_emails = '1' AND a.email_frequency = '3' AND (c.companyStatus = 'Test' OR c.companyStatus = 'Active')";

        return $this->getAllResults($sql);
    }

    public function getAllfailedJobs()
    {


        $dql = "SELECT fj
        FROM \models\FailedJob fj
        WHERE fj.resend < '3'";

        $query = $this->em->createQuery($dql);
        return $query->getResult();

    }

    /**
     * Sends the proposal out
     * @param $proposalId
     * @param $emailData
     * @param string $logAction
     * @param string $logMessage
     * @param $account
     * @return bool
     */
    public function individualSend($proposalId, $emailData, $account = null, $logAction = \models\ActivityAction::PROPOSAL_EMAIL_SEND, $logMessage = null, $resend_id = null)
    {
         
        //validate email data
        if (!isset($emailData['subject']) || !isset($emailData['body']) || !isset($emailData['fromName']) || !isset($emailData['fromEmail'])) {
            return false;
        }
        //initiate and validate proposal
        /* @var $proposal \models\Proposals */
        $proposal = $this->em->find('\models\Proposals', $proposalId);
        if (!$proposal) {
            return false;
        }

        //build basic email data
        $basicEmailData = [
            'fromName' => ($emailData['fromName']) ?: $proposal->getOwner()->getFullName(),
            'fromEmail' => 'noreply@' . SITE_EMAIL_DOMAIN,
            'subject' => $emailData['subject'],
            'body' => $emailData['body'],
            'replyTo' => (@$emailData['replyTo']) ?: $proposal->getOwner()->getEmail(),
            'uniqueArg2' => 'email_event',
            'uniqueArg' => 'proposal',
            'uniqueArgVal' => $proposal->getProposalId(),
            'categories' => (isset($emailData['categories']) && is_array($emailData['categories'])) ? $emailData['categories'] : [],
        ];
        //send email to client and bcc / additional mails
        $to = (isset($emailData['emailClient']) && ($emailData['emailClient'] == false)) ? [] : [$proposal->getClient()->getEmail()];
        if (isset($emailData['to']) && is_array($emailData['to'])) {
            $to = array_merge($to, $emailData['to']);
        }
        $clientEmailData = $basicEmailData;
        $clientEmailData['categories'][] = 'Proposal';
        $clientEmailData['to'] = array_unique($to); //filter out duplicates, just a precaution
        $emails = $clientEmailData['to'];


        foreach ($emails as $email) {
            $email = trim($email);
            // Update the link if it's going to the client
            $client_link = 0;
            $signature_link = 0;
            $clientEmail = $proposal->getClient()->getEmail();
            if ($clientEmail == $email) {
                $clientEmailData['body'] = updateEmailLinks($clientEmailData['body']);
                $client_link = 1;
                $signature_link = 1;
            }

            $ppl = $this->em->getRepository('models\ProposalPreviewLink')->findOneBy(array('email' => $email, 'proposal_id' => $proposal->getProposalId()));

            if (!$ppl) {
                $uuid = Uuid::uuid4();
                $ppl = new  \models\ProposalPreviewLink();
                $ppl->setProposalId($proposal->getProposalId());
                $ppl->setUuid($uuid);
                $ppl->setEmail($email);
                $ppl->setCreatedAt(Carbon::now());
                $ppl->setClientLink($client_link);
                $ppl->setSignatureLink($signature_link);
                $this->em->persist($ppl);
                $this->em->flush();
                $proposal->setProposalViewCount($proposal->getProposalViewCount() + 1);
            }

            $etp = new \EmailTemplateParser();
            $etp->setProposal($proposal);
            $etp->setProposalPreviewLink($ppl);
            //$clientEmailData['subject'] = $etp->parse($clientEmailData['subject']);
            $clientEmailData['body'] = $etp->parse($emailData['body']);

            
            $clientEmailData['to'] = $email;

            $event_id = $this->getProposalEventRepository()->createEmailEvent('Proposal', $proposalId, $account, $clientEmailData['to'], $clientEmailData['body'], $clientEmailData['subject'], '1', $clientEmailData['fromName'], $clientEmailData['fromEmail']);
            $clientEmailData['uniqueArg2Val'] = $event_id;

           // echo "<pre>ppl";print_r($ppl);
          //  echo "<pre>Send Email To Client ";print_r($clientEmailData);

            $this->getEmailRepository()->send($clientEmailData);

            //log action
            $accountId = ($account !== null) ? $account->getAccountId() : $proposal->getClient()->getAccount()->getAccountId();
            $logText = ($logMessage) ?: 'Proposal sent to ' . $email;
            $this->getLogRepository()->add([
                'action' => $logAction,
                'details' => $logText,
                'client' => $proposal->getClient()->getClientId(),
                'proposal' => $proposal->getProposalId(),
                'account' => $accountId,
                'company' => $proposal->getClient()->getCompany()->getCompanyId(),
            ]);
        }

        if (isset($emailData['bcc']) && is_array($emailData['bcc'])) {
            $bcc = $emailData['bcc'];
        }
        $clientEmailData['to'] = array_unique($bcc); //filter out duplicates, just a precaution
        $bcc_emails = $clientEmailData['to'];
        foreach ($bcc_emails as $email) {

            // Update the link if it's going to the client
            $clientEmail = $proposal->getClient()->getEmail();
            if ($clientEmail == $email) {
                $clientEmailData['body'] = updateEmailLinks($clientEmailData['body']);
            }

            $email = trim($email);
            $clientEmailData['to'] = $email;
            //$CI =& get_instance();

            //$CI->load->library('jobs');

            // Save the opaque image
            //$CI->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'group_proposal_resend', $clientEmailData, 'test job');


            $event_id = $this->getProposalEventRepository()->createEmailEvent('Proposal', $proposalId, $account, $clientEmailData['to'], $clientEmailData['body'], $clientEmailData['subject'], '3', $clientEmailData['fromName'], $clientEmailData['fromEmail']);
            $clientEmailData['uniqueArg2Val'] = $event_id;

            $this->getEmailRepository()->send($clientEmailData);

            //log action
            $accountId = ($account !== null) ? $account->getAccountId() : $proposal->getClient()->getAccount()->getAccountId();
            $logText = ($logMessage) ?: 'Proposal sent to ' . $email;
            $this->getLogRepository()->add([
                'action' => $logAction,
                'details' => $logText,
                'client' => $proposal->getClient()->getClientId(),
                'proposal' => $proposal->getProposalId(),
                'account' => $accountId,
                'company' => $proposal->getClient()->getCompany()->getCompanyId(),
            ]);
        }

        //send cc to proposal owner if cc is true
        if ((@$emailData['emailCC'])) {

            $ccEmailData = $basicEmailData;
            $ccEmailData['categories'][] = 'Proposal CC';
            $ccEmailData['to'] = [$proposal->getOwner()->getEmail()];

            $ccEmailData['to'] = array_unique($ccEmailData['to']); //filter out duplicates, just a precaution
            $emails = $ccEmailData['to'];
           // $emails = array_unique($emailData['to']);
            //echo "<pre>cccc";print_r($emailData['to']);
           // echo "<pre>GMAILL";print_r($emails); 

            //Find Default Proposal view link
            $ccPpl = $this->getDefaultProposalLink($proposalId);
            $etp = new \EmailTemplateParser();
            $etp->setProposal($proposal);
            $etp->setProposalPreviewLink($ccPpl);
            
            //Update The amil body
            $ccEmailData['body'] = $etp->parse($ccEmailData['body']);

            foreach ($emails as $email) {
                $ccEmailData['to'] = $email;
                $event_id = $this->getProposalEventRepository()->createEmailEvent('Proposal', $proposalId, $account, $ccEmailData['to'], $ccEmailData['body'], $ccEmailData['subject'], '2', $ccEmailData['fromName'], $ccEmailData['fromEmail']);
                $ccEmailData['uniqueArg2Val'] = $event_id;
                $this->getEmailRepository()->send($ccEmailData);
                //$CI->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'group_proposal_resend', $ccEmailData, 'test job');
            }
        }


        //reset some proposal flags
        $proposal->setLastActivity();
        //$proposal->setDeliveryTime(null);
        //$proposal->setLastOpenTime(null);
        $proposal->setEmailStatus(\models\Proposals::EMAIL_SENT);
        $proposal->setEmailSendTime(time());
        $proposal->setDeclined(0);
        $this->em->persist($proposal);
        $this->em->flush();
        //true on success
        return true;
    }

    public function get_proposal_email_template_fields()
    {
        $dql = "SELECT cetpf
        FROM \models\ClientEmailTemplateTypeField cetpf  WHERE cetpf.template_type='1'";
        $query = $this->em->createQuery($dql);
        //Cache It
        $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_CLIENT_EMAIL_TEMPLATE_TYPE_FIELD);
        return $query->getResult();

    }

    /**
     * Sends the proposal out
     * @param $proposalId
     * @param $emailData
     * @param string $logAction
     * @param string $logMessage
     * @param $account
     * @return bool
     */
    public function direct_send($proposalId, $emailData, $account = null, $logAction = 'proposal_send', $logMessage = null, $resend_id = null)
    {


        try {

            //validate email data
            if (!isset($emailData['subject']) || !isset($emailData['body']) || !isset($emailData['fromName']) || !isset($emailData['fromEmail'])) {
                return false;
            }
            //initiate and validate proposal
            /* @var $proposal \models\Proposals */
            $proposal = $this->em->find('\models\Proposals', $proposalId);
            if (!$proposal) {
                return false;
            }


            //build basic email data
            $basicEmailData = [
                'fromName' => ($emailData['fromName']) ?: $proposal->getOwner()->getFullName(),
                'fromEmail' => 'noreply@' . SITE_EMAIL_DOMAIN,
                'subject' => $emailData['subject'],
                'body' => $emailData['body'],
                'replyTo' => (@$emailData['replyTo']) ?: $proposal->getOwner()->getEmail(),
                'uniqueArg2' => 'resend_email_id',
                'uniqueArg2Val' => $resend_id,
                'uniqueArg' => 'proposal',
                'uniqueArgVal' => $proposal->getProposalId(),
                'categories' => (isset($emailData['categories']) && is_array($emailData['categories'])) ? $emailData['categories'] : [],
            ];
            //send email to client and bcc / additional mails
            $to = (isset($emailData['emailClient']) && ($emailData['emailClient'] == false)) ? [] : [$proposal->getClient()->getEmail()];
            if (isset($emailData['bcc']) && is_array($emailData['bcc'])) {
                $to = array_merge($to, $emailData['bcc']);
            }
            $clientEmailData = $basicEmailData;
            $clientEmailData['categories'][] = 'Proposal';
            $clientEmailData['to'] = array_unique($to); //filter out duplicates, just a precaution
            $emails = $clientEmailData['to'];


            foreach ($emails as $email) {

                // Update the link if it's going to the client
                $clientEmail = $proposal->getClient()->getEmail();
                $ppl = $this->em->getRepository('models\ProposalPreviewLink')->findOneBy(array('email' => $email, 'proposal_id' => $proposal->getProposalId()));
                $client_link = 0;
                $signature_link = 0;

                if ($clientEmail == $email) {
                   $client_link = 1;
                   $signature_link = 1;
                }
                
                if (!$ppl) {
                    $uuid = Uuid::uuid4();
                    $ppl = new  \models\ProposalPreviewLink();
                    $ppl->setProposalId($proposal->getProposalId());
                    $ppl->setUuid($uuid);
                    $ppl->setEmail($email);
                    $ppl->setCreatedAt(Carbon::now());
                    $ppl->setClientLink($client_link);
                    $ppl->setSignatureLink($signature_link);
                    $this->em->persist($ppl);
                    $this->em->flush();
                    $proposal->setProposalViewCount($proposal->getProposalViewCount() + 1);
                }

                $etp = new \EmailTemplateParser();
                $etp->setProposal($proposal);
                $etp->setProposalPreviewLink($ppl);
                $clientEmailData['subject'] = $etp->parse($clientEmailData['subject']);
                $clientEmailData['body'] = $etp->parse($clientEmailData['body']);


                if ($clientEmail == $email) {
                    $clientEmailData['body'] = updateEmailLinks($clientEmailData['body']);
                    
                }
                

                $email = trim($email);

                $clientEmailData['to'] = $email;
                //$CI =& get_instance();

                //$CI->load->library('jobs');

                $event_id = $this->getProposalEventRepository()->createEmailEvent('Proposal', $proposalId, $account, $clientEmailData['to'], $clientEmailData['body'], $clientEmailData['subject'], \models\EventMailType::GROUPRESEND, $clientEmailData['fromName'], $clientEmailData['fromEmail']);
                $clientEmailData['uniqueArg3'] = 'email_event';
                $clientEmailData['uniqueArg3Val'] = $event_id;
                // Save the opaque image
                //$CI->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'group_proposal_resend', $clientEmailData, 'test job');

                $this->getEmailRepository()->send($clientEmailData);

                //log action
                $accountId = ($account !== null) ? $account->getAccountId() : $proposal->getClient()->getAccount()->getAccountId();
                $logText = ($logMessage) ?: 'Proposal sent to ' . $email;
                $this->getLogRepository()->add([
                    'action' => $logAction,
                    'details' => $logText,
                    'client' => $proposal->getClient()->getClientId(),
                    'proposal' => $proposal->getProposalId(),
                    'account' => $accountId,
                    'company' => $proposal->getClient()->getCompany()->getCompanyId(),
                ]);
            }

            //send cc to proposal owner if cc is true
            if ((@$emailData['emailCC'])) {

                $ccEmailData = $basicEmailData;
                $ccEmailData['categories'][] = 'Proposal CC';
                $ccEmailData['to'] = [$proposal->getOwner()->getEmail()];

                $ccEmailData['to'] = array_unique($ccEmailData['to']); //filter out duplicates, just a precaution
                $emails = $ccEmailData['to'];

                //Find Default Proposal view link
                $ccPpl = $this->getDefaultProposalLink($proposalId);
                $etp = new \EmailTemplateParser();
                $etp->setProposal($proposal);
                $etp->setProposalPreviewLink($ccPpl);
            
            //Update The amil body
            $ccEmailData['body'] = $etp->parse($ccEmailData['body']);
            $ccEmailData['subject'] = $etp->parse($ccEmailData['subject']);

                foreach ($emails as $email) {
                    $ccEmailData['to'] = $email;
                    //$this->getEmailRepository()->send($ccEmailData);

                    $event_id = $this->getProposalEventRepository()->createEmailEvent('Proposal', $proposalId, $account, $ccEmailData['to'], $ccEmailData['body'], $ccEmailData['subject'], '2', $ccEmailData['fromName'], $ccEmailData['fromEmail']);
                    $ccEmailData['uniqueArg3'] = 'email_event';
                    $ccEmailData['uniqueArgVal3'] = $event_id;
                    $this->getEmailRepository()->send($ccEmailData);
                    //$CI->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'group_proposal_resend', $ccEmailData, 'test job');
                }
            }

            //reset some proposal flags
            $proposal->setLastActivity();
            //$proposal->setDeliveryTime(null);
            //$proposal->setLastOpenTime(null);
            $proposal->setEmailStatus(\models\Proposals::EMAIL_SENT);
            $proposal->setEmailSendTime(time());
            $proposal->setDeclined(0);
            $this->em->persist($proposal);
            $this->em->flush();
            //true on success
            $return = array(
                'status' => true,
                'error_message' => '',
            );
            return $return;
        } catch (\Exception $e) {
            $return = array(
                'status' => false,
                'error_message' => $e->getMessage(),
            );
            log_message('debug', 'Failed job:' . $e->getMessage());

            return $return;
        }


    }

    public function getRealImageCount(Proposals $proposal)
    {
        $sql = "SELECT COUNT(*) As numImages
                FROM proposals_images
                WHERE proposal = " . $proposal->getProposalId();

        $query = $this->db->query($sql);
        return $query->result()[0]->numImages;
    }

    public function getProposalsYearAllStats(array $time, $statusId, $userId = false)
    {
        $CI = &get_instance();

        $dql = "SELECT SUM(p.price) as total_amount,
        SUM(CASE WHEN (st.sales = '1') THEN p.price ELSE 0 END) as total_sold_amount 
        FROM \models\Proposals p, \models\Clients c,\models\Accounts a, \models\Status st
        
        WHERE p.client = c.clientId AND p.proposalStatus = st.id AND p.owner = a.accountId
        AND p.duplicateOf IS NULL
        
       
        AND p.created >= :startTime
        AND p.created <= :finishTime";


        $dql .= ' AND p.owner =' . $userId;
        //echo $dql;die;


        //echo $dql;die;
        $query = $CI->em->createQuery($dql);


        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);

        $total = $query->getResult();
        return $total[0];

    }

    /**
     * @param Proposals $proposal
     * @param $business_type_id
     * @param $company_id
     * @return bool
     */
    public function checkNewBusinessTypeProposalAssignment(Proposals $proposal, $business_type_id, $company_id)
    {
        $CI = &get_instance();

        $dql = "SELECT bta.id
        FROM \models\BusinessTypeAssignment bta
        WHERE bta.account_id = :accountId AND bta.business_type_id = :businessTypeId";

        $query = $CI->em->createQuery($dql);

        $query->setParameter('accountId', $proposal->getClient()->getClientAccount()->getId());
        $query->setParameter('businessTypeId', $business_type_id);

        $total = $query->getResult();

        if (count($total) < 1) {
            $assignment = new \models\BusinessTypeAssignment();
            $assignment->setBusinessTypeId($business_type_id);
            $assignment->setCompanyId($company_id);
            $assignment->setAccountId($proposal->getClient()->getClientAccount()->getId());
            $this->em->persist($assignment);

            $this->em->flush();
        }

        $dql = "SELECT bta.id
        FROM \models\BusinessTypeAssignment bta
        WHERE bta.client_id = :clientId AND bta.business_type_id = :businessTypeId";

        $query = $CI->em->createQuery($dql);

        $query->setParameter('clientId', $proposal->getClient()->getClientId());
        $query->setParameter('businessTypeId', $business_type_id);

        $total = $query->getResult();

        if (count($total) < 1) {
            $assignment = new \models\BusinessTypeAssignment();
            $assignment->setBusinessTypeId($business_type_id);
            $assignment->setCompanyId($company_id);
            $assignment->setClientId($proposal->getClient()->getClientId());
            $this->em->persist($assignment);
            $this->em->flush();
        }

        return true;
    }

    function checkClientAssignmentInAccount($account_id, $business_type_id, $company_id)
    {
        $CI = &get_instance();

        $dql = "SELECT bta.id
        FROM \models\BusinessTypeAssignment bta
        WHERE bta.account_id = :accountId AND bta.business_type_id = :businessTypeId";

        $query = $CI->em->createQuery($dql);

        $query->setParameter('accountId', $account_id);
        $query->setParameter('businessTypeId', $business_type_id);

        $total = $query->getResult();

        if (count($total) < 1) {
            $assignment = new \models\BusinessTypeAssignment();
            $assignment->setBusinessTypeId($business_type_id);
            $assignment->setCompanyId($company_id);
            $assignment->setAccountId($account_id);
            $this->em->persist($assignment);

            $this->em->flush();
        }
    }

    function getClientBusinessTypeProposalCount($client_id, $business_type_id)
    {
        $sql = "SELECT count(p.proposalId)
                FROM \models\Proposals p
                WHERE p.business_type_id = :typeId
                AND p.client = :clientId";

        $query = $this->em->createQuery($sql);
        $query->setParameter(':typeId', $business_type_id);
        $query->setParameter(':clientId', $client_id);

        return $query->getSingleScalarResult();

    }

    function getClientBusinessTypeProposalArray($client_id)
    {
        $sql = "SELECT distinct(p.business_type_id) as business_type_id
                FROM \models\Proposals p
                WHERE p.business_type_id IS NOT NULL AND p.client = :clientId";

        $query = $this->em->createQuery($sql);
        $query->setParameter(':clientId', $client_id);

        $results = $query->getResult();
        $array_data = array();

        foreach ($results as $result) {
            array_push($array_data, $result['business_type_id']);
        }

        return $array_data;
    }

    function getAccountBusinessTypeProposalCount($account_id, $business_type_id)
    {


        $sql = "SELECT count(p.proposalId) as p_count
                FROM proposals p
                LEFT JOIN clients c ON p.client = c.clientId
                WHERE p.business_type_id = " . $business_type_id . "
                AND c.client_account =" . $account_id;


        $data = $this->db->query($sql)->result();

        return $data[0]->p_count;


    }


    function getAccountBusinessTypeProposalArray($account_id)
    {
        $sql = "SELECT distinct(p.business_type_id) as business_type_id
                FROM proposals p
                LEFT JOIN clients c ON p.client = c.clientId
                WHERE p.business_type_id IS NOT NULL AND c.client_account =" . $account_id;


        $results = $this->db->query($sql)->result();

        $array_data = array();
        foreach ($results as $result) {
            array_push($array_data, $result->business_type_id);
        }

        $sql = "SELECT DISTINCT(bt.business_type_id) as business_type_id FROM  business_type_assignments bt
                LEFT JOIN clients c ON bt.client_id = c.clientId 
                WHERE c.client_account = " . $account_id;

        $query = $this->db->query($sql);

        $business_types = $query->result();
        foreach ($business_types as $business_type) {
            if (!in_array($business_type->business_type_id, $array_data)) {
                array_push($array_data, $business_type->business_type_id);
            }
        }
        return $array_data;
    }

    public function getProposalBusinessTypes($proposal_id)
    {
        $sql = "SELECT bta.business_type_id,bt.type_name
        FROM business_type_assignments bta 
        LEFT JOIN business_types bt ON bta.business_type_id = bt.id
        WHERE bta.proposal_id=" . $proposal_id;
        return $this->getAllResults($sql);

    }

    public function getProposalBusinessTypeName($bt_id)
    {
        if($bt_id){
            $sql = "SELECT bt.type_name
            FROM business_types bt 
            WHERE bt.id=" . $bt_id;
            $btName = $this->getAllResults($sql);
           
            if($btName){
                return $btName[0]->type_name;
            }else{
                return '';
            }
        }else{
            return '';
        }
        
    }
    

    function updateClientBusinessTypeOnProposal($client_id, $business_type_id)
    {
        $sql = "SELECT p
                FROM \models\Proposals p
                WHERE p.client = :clientId";

        $query = $this->em->createQuery($sql);
        $query->setParameter(':clientId', $client_id);

        $proposals = $query->getResult();
        foreach ($proposals as $proposal) {
            $proposal->setBusinessTypeId($business_type_id);
            $this->em->persist($proposal);

        }
        $this->em->flush();

        return count($proposals);


    }

    function getAccountProposalCount($account_id)
    {

        $sql = "SELECT count(p.proposalId) as p_count
                FROM proposals p
                LEFT JOIN clients c ON p.client = c.clientId
                WHERE  c.client_account =" . $account_id;
        $data = $this->db->query($sql)->result();

        return $data[0]->p_count;

    }

    function getAccountsProposalCount($account_ids)
    {

        $sql = "SELECT count(p.proposalId) as p_count
                FROM proposals p
                LEFT JOIN clients c ON p.client = c.clientId
                WHERE  c.client_account IN(" . $account_ids . ")";
        $data = $this->db->query($sql)->result();

        return $data[0]->p_count;

    }

    function getClientProposalCount($client_id)
    {

        $sql = "SELECT count(p.proposalId) as p_count
                FROM proposals p
                WHERE  p.client =" . $client_id;
        $data = $this->db->query($sql)->result();

        return $data[0]->p_count;

    }

    function getClientsProposalCount($client_ids)
    {

        $sql = "SELECT count(p.proposalId) as p_count
                FROM proposals p
                WHERE  p.client IN(" . $client_ids . ")";
        $data = $this->db->query($sql)->result();

        return $data[0]->p_count;
    }


    public function removeWinDateByStatus(Accounts $account, $statusId)
    {
        if ($statusId) {
            $dql = "SELECT p 
                FROM models\Proposals p
                WHERE p.proposalStatus = :statusId";

            $query = $this->em->createQuery($dql);
            $query->setParameter(':statusId', $statusId);
            $proposals = $query->getResult();

            foreach ($proposals as $proposal) {
                /* @var $proposal Proposals */

                // Remove the win date if we have one
                if ($proposal->getWinDate()) {
                    $proposal->setWinDate(null);
                    $this->em->persist($proposal);
                    $this->em->flush();

                    // Log it
                    $this->getLogRepository()->add([
                        'action' => 'status_won_update',
                        'details' => "Proposal Win Date removed after status update",
                        'proposal' => $proposal->getProposalId(),
                        'company' => $proposal->getClient()->getCompany()->getCompanyId(),
                        'client' => $proposal->getClient()->getClientId(),
                        'account' => $account->getAccountId()
                    ]);
                }
            }
        }

    }

    public function deleteNoUserDemoProposals()
    {
        $sql = "DELETE p 
                FROM proposals p 
                LEFT JOIN accounts a ON p.owner = a.accountId 
                WHERE p.is_demo = 1
                AND p.rebuildFlag = 1
                AND a.accountId IS NULL";

        $this->db->simple_query($sql);
    }

    public function groupResendBounced(\models\Accounts $account, $pgsId, $proposal_ids)
    {


        $CI =& get_instance();
        $CI->load->library('jobs2', NULL, 'my_jobs');
        $count = 0;
        $alreadySentCount = 0;
        $unsentCount = 0;
        $bouncedUnsentCount = 0;
        $pgs = $this->em->find('\models\ProposalGroupResend', $pgsId);
        $sql = "SELECT p.proposalStatus, pgre.proposal_status_id, pgre.proposal_id,pgre.id,pgre.email_address,pgre.bounced_at
        FROM proposal_group_resend_email pgre 
        LEFT JOIN proposals p ON pgre.proposal_id = p.proposalId";
        if ($proposal_ids == 0) {
            $sql .= " WHERE pgre.bounced_at IS NOT NULL
            AND pgre.resend_id = " . $pgsId;
        } else {

            $proposal_ids = implode(",", $proposal_ids);
            $sql .= " WHERE pgre.bounced_at IS NOT NULL AND pgre.proposal_id IN(" . $proposal_ids . ")
            AND pgre.resend_id = " . $pgsId;
        }


        $sql .= " AND pgre.is_failed = 0";

        $Resend_proposals = $this->getAllResults($sql);

        $emailData = [
            'subject' => $pgs->getSubject(),
            'body' => $pgs->getEmailContent(),
            'fromName' => $pgs->getCustomSender(),
            'fromEmail' => $pgs->getCustomSenderEmail(),
            'new_resend_name' => $pgs->getResendName(),
            'replyTo' => $pgs->getCustomSenderEmail(),
            'emailCC' => ($pgs->getEmailCc() === 0) ? 0 : 1,
            'categories' => ['Group Resend'],
        ];

        foreach ($Resend_proposals as $Resend_proposal) {
            $sendIt = true;
            $bounced = false;
            $proposal_id = $Resend_proposal->proposal_id;


            // Check approval status
            if ($account->requiresApproval()) {

                $proposal = $this->em->findProposal($proposal_id);

                if ($proposal->getTotalPrice() > $account->getApprovalLimit()) {
                    $sendIt = false;
                }
            }
            $proposal = $this->em->findProposal($proposal_id);

            if ($proposal) {

                if ($sendIt) {


                    //Event Log
                    $this->getProposalEventRepository()->sendProposalCampaign($proposal, $account);

                    $to = (isset($emailData['emailClient']) && ($emailData['emailClient'] == false)) ? [] : [$proposal->getClient()->getEmail()];
                    if (isset($emailData['bcc']) && is_array($emailData['bcc'])) {
                        $to = array_merge($to, $emailData['bcc']);
                    }
                    $to = implode(" ", array_unique($to));


                    $pgseId = $Resend_proposal->id;
                    $pgsId = $pgs->getId();


                    $job_array = [
                        'proposal_id' => $proposal_id,
                        'email_data' => $emailData,
                        'account_id' => $account->getAccountId(),
                        'logAction' => 'proposal_send',
                        'logMessage' => '',
                        'pgseId' => $pgseId,
                        'pgsId' => $pgsId,
                        'mail_to' => $to,
                        'proposal_status' => $proposal->getStatus()

                    ];

                    //if ($this->direct_send($proposal_id, $emailData, $account, $logAction, $logMessage, $pgse->getId())) {
                    // $proposal = $this->em->find('\models\Proposals', $proposal_id);

                    $CI->my_jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'send_individual_proposal_email_send', $job_array, 'test job');
                    $count++;
                    // }

                } else {
                    if (!$bounced) {
                        $unsentCount++;
                    }

                }
            }
        }

        if ($count) {
            //log group action
            $this->getLogRepository()->add([
                'action' => 'group_action_send',
                'details' => "Group Proposals Sent to {$count} clients",
                'account' => $account->getAccountId(),
                'company' => $account->getCompany()->getCompanyId(),
            ]);
            $this->sendAccountCC($emailData, $account, $count);
        }

        $out = [
            'sent' => $count,
            'unsent' => $unsentCount,
            'already_sent' => $alreadySentCount,
            'bouncedUnsentCount' => $bouncedUnsentCount,
        ];

        return $out;
    }

    /**
     * @param Proposals $proposal
     * @return array
     */
    function getProposalImages(Proposals $proposal): array
    {

        $sql = "SELECT pi.imageId, ps.serviceName
                FROM proposals_images pi
                LEFT JOIN proposal_services ps ON pi.proposal_service_id = ps.serviceId
                WHERE pi.proposal = " . $proposal->getProposalId() . "
                ORDER BY COALESCE(ps.ord, 999),
                         pi.ord ASC";

        return $this->getAllResults($sql);
    }

    /**
     * @param int $proposalServiceId
     * @return array
     */
    function getProposalServiceImages(int $proposalServiceId): array
    {

        $sql = "SELECT pi.imageId, ps.serviceName
                FROM proposals_images pi
                LEFT JOIN proposal_services ps ON pi.proposal_service_id = ps.serviceId
                WHERE pi.proposal_service_id = " . $proposalServiceId . "
                ORDER BY COALESCE(ps.ord, 999),
                         pi.ord ASC";

        return $this->getAllResults($sql);
    }

    public function groupProposalExportCSV(Accounts $account, $proposalIds)
    {
        // Get the data
        $proposalData = $account->getProposalsDataByIDs($proposalIds);

        // Create the writer
        $writer = Writer::createFromFileObject(new \SplTempFileObject());
        $count = 0;
        // Headings
        $headingData = [
            'Date Created',
            'Owner',
            'Status',
            //'Branch',
            'Job Number',
            'Project Name',
            'Project Address',
            'Project City',
            'Project State',
            'Project Zip',
            'Contact First Name',
            'Contact Last Name',
            'Contact Company',
            'Contact Title',
            'Contact Office Phone',
            'Contact Cell Phone',
            'Contact Email',
            'Total Price',
            'Last Activity',
            'Last Email Send',
            'Sold Date',
            'Lat',
            'Lng',
            'Services',
            'Last Open Time',
            'Audit Status'
        ];

        // Add the headings
        $writer->insertOne($headingData);

        // Loop through the data
        foreach ($proposalData as $row) {

            // Load the proposal
            $proposal = $this->em->findProposal($row->proposalId);

            // Services
            $serviceString = '';
            $proposalServices = $proposal->getServices();

            $servicesArray = [];
            $first = true;
            $audit_title = '';
            if ($proposal->getAuditKey() && !$proposal->getAuditViewTime()) {
                $audit_title = 'Audit Linked';

                if ($proposal->getAuditReminderSent()) {
                    $audit_title .= ' - Reminder Sent: ' . date('m/d/Y g:ia', realTime($proposal->getAuditReminderSent()));
                } else if ($proposal->getAuditViewTime()) {

                    $audit_title = "Audit Last Opened:" . date('m/d/Y g:ia', realTime($proposal->getAuditViewTime()));

                }
            }

            foreach ($proposalServices as $proposalService) {
                if (!$first) {
                    $serviceString .= ' / ';
                }

                $serviceString .= $proposalService->getServiceName() . ' - ' . $proposalService->getFormattedPrice();
                $serviceString .= " ";
                $first = false;
            }

            $rowData = [
                date('m/d/Y g:ia', $row->created),
                $row->accountFN . ' ' . $row->accountLN,
                $row->statusText,
                //$row->branchName ?: 'Main',
                $row->jobNumber,
                $row->projectName,
                $row->projectAddress,
                $row->projectCity,
                $row->projectState,
                $row->projectZip,
                $row->clientFN,
                $row->clientLN,
                $row->clientAccountName,
                $row->clientTitle,
                $row->clientBP,
                $row->clientCP,
                $row->clientEmail,
                '$' . number_format($row->price),
                date('m/d/Y g:ia', $row->last_activity),
                date('m/d/Y g:ia', $row->emailSendTime),
                $row->win_date ? date('m/d/Y g:i:a', $row->win_date) : 'n/a',
                $row->lat,
                $row->lng,
                $serviceString,
                $row->lastOpenTime ? date('m/d/Y g:i:a', $row->lastOpenTime) : '',
                $audit_title
            ];
            $writer->insertOne($rowData);
            $count++;
        };

        if ($count > 0) {
            $this->getLogRepository()->add([
                'action' => 'Group Export',
                'details' => " {$count} Proposals Export",
                'account' => $account->getAccountId(),
                'company' => $account->getCompany()->getCompanyId(),
            ]);
        }

        // Output the csv
        return $writer->output();
    }

    public function numEditProposalView($previewId)
    {
        $sql = "SELECT COUNT(id) As numView
                FROM proposal_views
                WHERE proposal_link_id = {$previewId}";

        $query = $this->db->query($sql);
        if ($query->result()) {
            return $query->result()[0]->numView;
        } else {
            return 0;
        }

    }

    function getProposalVideos($proposal_id)
    {

        $dql = "SELECT pv
        FROM \models\ProposalVideo pv WHERE pv.proposal_id = {$proposal_id}
        ORDER BY pv.ord ASC";
        $query = $this->em->createQuery($dql);

        return $query->getResult();
    }

    function getProposalVisibleProposalVideos($proposal_id)
    {

        $dql = "SELECT pv
        FROM \models\ProposalVideo pv WHERE pv.proposal_id = {$proposal_id}
        AND pv.visible_proposal = 1
        AND pv.is_intro = 0
        ORDER BY pv.ord ASC";
        $query = $this->em->createQuery($dql);

        return $query->getResult();
    }

    function getProposalIntroVideo($proposal_id)
    {

        $dql = "SELECT pv
        FROM \models\ProposalVideo pv WHERE pv.proposal_id = {$proposal_id}
        AND pv.visible_proposal = 1
        AND pv.is_intro = 1";
        $query = $this->em->createQuery($dql);
        try {
            return$query->getSingleResult();
        } catch (NoResultException $e) {
            return false;
        }
        
    }

    function getProposalIntroVideoReset($proposal_id)
    {
        $this->db->query(
            'UPDATE proposal_videos
            SET is_intro = 0
            WHERE proposal_id = ' . $proposal_id
        );
    }

    function getWorkOrderVisibleProposalVideos($proposal_id)
    {

        $dql = "SELECT pv
        FROM \models\ProposalVideo pv WHERE pv.proposal_id = {$proposal_id}
        AND pv.visible_work_order = 1
        AND pv.is_intro = 0
        ORDER BY pv.ord ASC";
        $query = $this->em->createQuery($dql);

        return $query->getResult();
    }

    function getWorkOrderNotes($proposal_id)
    {

            $notes = $this->em->createQuery("SELECT n 
              FROM models\Notes n WHERE n.type= 'proposal' 
              AND n.relationId=" . $proposal_id . " AND n.work_order = 1
              ORDER BY n.added DESC")->getResult();
    
            return $notes;

    }
    

    function getWorkOrderVisibleIntroVideos($proposal_id)
    {

        $dql = "SELECT pv
        FROM \models\ProposalVideo pv WHERE pv.proposal_id = {$proposal_id}
        AND pv.visible_work_order = 1
        AND pv.is_intro = 1";
        $query = $this->em->createQuery($dql);
        try {
            return$query->getSingleResult();
        } catch (NoResultException $e) {
            return false;
        }
        
    }

    public function deleteProposalVideoById($video_id)
    {
        $sql = "DELETE FROM proposal_videos WHERE id = " . $video_id;
        return $this->db->query($sql);
    }

    public function getVideoType(string $videoUrl)
    {

        $videoType = 'NA';

        $finalUrl = '';
        if (strpos($videoUrl, 'facebook.com/') !== false) {
            //it is FB video
            $videoType = 'facebook';
        } else if (strpos($videoUrl, 'vimeo.com/') !== false) {
            $videoType = 'vimeo';
        } else if (strpos($videoUrl, 'youtube.com/') !== false) {
            $videoType = 'youtube';
        } else if (strpos($videoUrl, 'youtu.be/') !== false) {

            $videoType = 'youtube';
        } else if (strpos($videoUrl, 'screencast.com/') !== false) {
            $videoType = 'screencast';
        } else if (strpos($videoUrl, 'dropbox.com') !== false) {
            $videoType = 'dropbox';
        }

        return $videoType;
    }

    function getScreencastDuration($url)
    {

        $embedUrl = $this->getScreencastEmbedUrl($url);
        echo $embedUrl;

        $matches = [];
        $regex = "/xmpDM:duration xmpDM:scale=\"(.*)\/(.*)\" xmpDM:value=\"(.*)\" \/>/";
        $client = new \GuzzleHttp\Client();
        $newuri = str_replace("www", "content", $embedUrl);
        $newuri = str_replace("embed", "", $newuri);
        $newuri = str_replace("http://", "https://", $newuri);

        //echo '<br />' . $newuri;

        try {
            $response = $client->get($newuri . 'sc.xmp');
            preg_match($regex, $response->getBody(), $matches);

            array_shift($matches);

            return $total = (($matches[0] / $matches[1]) * $matches[2]);
        } catch (\Exception $e) {
            return false;
        }


    }

    function getScreencastEmbedUrl($url)
    {

        try {
            $wrapperPage = @file_get_contents($url);
            preg_match_all('/<iframe.*src=\"(https:\/\/www\.screencast.*)\".*><\/iframe>/isU', $wrapperPage, $matches);

            if (isset($matches[1][0])) {
                return $matches[1][0];
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }

    }

    function getProposalVideoEmbedUrl($url)
    {
        $finalUrl = '';
        if (strpos($url, 'facebook.com/') !== false) {
            //it is FB video

            $finalUrl .= 'https://www.facebook.com/plugins/video.php?href=' . rawurlencode($url) . '&show_text=1&width=200';
        } else if (strpos($url, 'vimeo.com/') !== false) {
            //it is Vimeo video
            $videoId = explode("vimeo.com/", $url)[1];
            if (strpos($videoId, '&') !== false) {
                $videoId = explode("&", $videoId)[0];
            }

            $finalUrl .= 'https://player.vimeo.com/video/' . $videoId;
        } else if (strpos($url, 'youtube.com/') !== false) {
            if (strpos($url, 'embed') > 0) {
                $finalUrl = $url;
            } else {
                //it is Youtube video
                $videoId = explode("v=", $url)[1];
                if (strpos($videoId, '&') !== false) {
                    $videoId = explode("&", $videoId)[0];
                }
                $finalUrl .= 'https://www.youtube.com/embed/' . $videoId . '?enablejsapi=1';
            }

        } else if (strpos($url, 'youtu.be/') !== false) {
            //it is Youtube video
            $videoId = explode("youtu.be/", $url)[1];
            if (strpos($videoId, '&') !== false) {
                $videoId = explode("&", $videoId)[0];
            }
            $finalUrl .= 'https://www.youtube.com/embed/' . $videoId . '?enablejsapi=1';

        } else if (strpos($url, 'dropbox.com') !== false) {
            $finalUrl = str_replace('dl=0', 'raw=1', $url);

        } else {

            $finalUrl = $url;
        }

        return $finalUrl;
    }

    function copyDefaultCompanyVideo($companyId, $proposalId)
    {

        $dql = "SELECT cv
        FROM \models\CompanyVideo cv WHERE cv.company_id = {$companyId}
        AND cv.include_in_proposal = 1
        ORDER BY cv.ord ASC";
        $query = $this->em->createQuery($dql);

        $videos = $query->getResult();

        foreach ($videos as $video) {

            $proposalVideos = new ProposalVideo();
            $proposalVideos->setProposalId($proposalId);
            $proposalVideos->setVideoType($video->getVideoType());
            $proposalVideos->setVideoUrl($video->getVideoUrl());
            $proposalVideos->setEmbedVideoUrl($video->getEmbedVideoUrl());
            $proposalVideos->setTitle($video->getTitle());
            $proposalVideos->setDuration($video->getDuration());
            $proposalVideos->setScreencastVideoId($video->getScreencastVideoId());
            $proposalVideos->setCompanyVideoId($video->getId());
            $proposalVideos->setIsIntro($video->getIsIntro());
            if($video->getIsIntro()){
                $proposalVideos->setIsLargePreview(1);
                $proposalVideos->setVisibleProposal(1);
            }
            $this->em->persist($proposalVideos);

        }
        $this->em->flush();
        return true;
    }

    function getAllCompanyProposalsVideoByVideoId($videoId)
    {
        $dql = "SELECT pv
        FROM \models\ProposalVideo pv WHERE pv.company_video_id = {$videoId}";
        $query = $this->em->createQuery($dql);

        return $query->getResult();
    }

    function deleteServiceImages($serviceId)
    {
        $dql = "SELECT pi
                FROM models\Proposals_images pi
                WHERE pi.proposal_service_id = :proposalServiceId
                ORDER BY pi.ord ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':proposalServiceId', $serviceId);
        $images = $query->getResult();

        foreach ($images as $image) {

            $file = $image->getProposal()->getUploadDir() . '/' . $image->getImage();
            if (file_exists($file)) {
                unlink($file);
            }

            $this->em->remove($image);

        }
        $this->em->flush();
    }

    /**
     * @param $proposalId
     * @return ProposalPreviewLink
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createDefaultProposalLink($proposalId): ProposalPreviewLink
    {
        //$proposal = $this->em->findProposal($proposalId);
        $email = 'default';
        $uuid = Uuid::uuid4();
        $ppl = new  \models\ProposalPreviewLink();
        $ppl->setProposalId($proposalId);
        $ppl->setUuid($uuid);
        $ppl->setEmail($email);
        $ppl->setCreatedAt(Carbon::now());
        $ppl->setNoTracking(1);
        //$proposal->setProposalViewCount($proposal->getProposalViewCount() + 1);
        $this->em->persist($ppl);
        //$this->em->persist($proposal);
        $this->em->flush();
        return $ppl;
    }

    /**
     * @param $proposalId
     * @return ProposalPreviewLink
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     */
    public function createClientProposalLink($proposalId): ProposalPreviewLink
    {
        $proposal = $this->em->findProposal($proposalId);
        $email = $proposal->getClient()->getEmail();
        $uuid = Uuid::uuid4();
        $ppl = new  \models\ProposalPreviewLink();
        $ppl->setProposalId($proposalId);
        $ppl->setUuid($uuid);
        $ppl->setEmail($email);
        $ppl->setCreatedAt(Carbon::now());
        $ppl->setClientLink(1);
        $ppl->setSignatureLink(1);
        $proposal->setProposalViewCount($proposal->getProposalViewCount() + 1);
        $this->em->persist($ppl);
        $this->em->persist($proposal);
        $this->em->flush();
        return $ppl;
    }

    /**
     * @param $proposalId
     * @return int|mixed|string
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    function getDefaultProposalLink($proposalId): ProposalPreviewLink
    {
        $sql = "SELECT p
                FROM \models\ProposalPreviewLink p
                WHERE p.proposal_id = :proposalId
                AND p.email = 'default'";
        $query = $this->em->createQuery($sql);
        $query->setParameter(':proposalId', $proposalId);
        $query->setMaxResults(1);

        try {
            $proposalView = $query->getSingleResult();
        } catch (NoResultException $e) {
            $proposalView = $this->createDefaultProposalLink($proposalId);
        }
        return $proposalView;
    }

    /**
     * @param $proposalId
     * @return int|mixed|string
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    function getClientProposalLink($proposalId): ProposalPreviewLink
    {
        $sql = "SELECT p
                FROM \models\ProposalPreviewLink p
                WHERE p.proposal_id = :proposalId
                AND p.client_link = 1";
        $query = $this->em->createQuery($sql);
        $query->setParameter(':proposalId', $proposalId);
        $query->setMaxResults(1);

        try {
            $proposalView = $query->getSingleResult();
        } catch (NoResultException $e) {
            $proposalView = $this->createClientProposalLink($proposalId);
        }
        return $proposalView;
    }


    public function getProposalLinkViews($linkId)
    {
        $dql = 'SELECT pv
            FROM models\ProposalView pv
            WHERE pv.proposal_link_id = :linkId
            ORDER BY pv.created_at DESC';

        $query = $this->em->createQuery($dql);
        $query->setParameter(':linkId', $linkId);

        return $query->getResult();
    }


    /**
     * @return int|mixed|string
     */
    public function getProposalViewList()
    {
        $startTimeDiff = $_ENV['PROPOSAL_VIEW_EMAIL_DELAY_MINS'];

        $startCheckTime = Carbon::now()->subMinute($startTimeDiff);
        $endCheckTime = Carbon::now()->startOfDay();

        $dql = 'SELECT pv
        FROM models\ProposalView pv
        WHERE pv.created_at <= :startCheckTime 
        AND pv.created_at > :endCheckTime
        AND pv.email_sent = :emailStatus
        AND pv.total_duration >= :minDuration';

        $query = $this->em->createQuery($dql);
        $query->setParameter(':startCheckTime', $startCheckTime->toDateTimeString());
        $query->setParameter(':endCheckTime', $endCheckTime->toDateTimeString());
        $query->setParameter(':emailStatus', \models\ProposalView::EMAIL_NOT_SENT);
        $query->setParameter(':minDuration', $_ENV['PROPOSAL_VIEW_MIN_DURATION_SECONDS']);

        return $query->getResult();
    }

    public function sendProposalViewedEmails()
    {
        $CI =& get_instance();

        $proposalViews = $this->getProposalViewList();
        foreach ($proposalViews as $proposalView) {

            $proposal = $this->em->findProposal($proposalView->getProposalId());

            if (!$proposal->getClient()->getAccount()->getDisableProposalNotifications()) {
                $proposalView->setEmailSent(\models\ProposalView::EMAIL_SENDING);
                $this->em->persist($proposalView);
                $this->em->flush();

                $job_array = [
                    'proposalViewId' => $proposalView->getId(),
                ];

                $CI->load->library('jobs');
                // Save the opaque image
                $CI->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'proposalViewedEmailSend', $job_array, 'test job');

            } else {
                $proposalView->setEmailSent(\models\ProposalView::EMAIL_DO_NOT_SEND);
                $this->em->persist($proposalView);
                $this->em->flush();
            }
        }
    }

    /**
     * @param $proposalId
     * @return int|mixed|string
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    function getProposalUserPermissions($proposalId)
    {
        $proposal = $this->em->findProposal($proposalId);

        $sql = "SELECT p
                FROM \models\ProposalUserPermission p
                WHERE p.proposal_id = :proposalId
                AND p.company_id = :companyId";
        $query = $this->em->createQuery($sql);
        $query->setParameter(':proposalId', $proposalId);
        $query->setParameter(':companyId', $proposal->getCompanyId());
        return $query->getResult();
       
    }

    public function getUserProposalPermission($proposalId,$userId){
        
        $sql = "SELECT p
        FROM \models\ProposalUserPermission p
        WHERE p.proposal_id = :proposalId AND p.user_id = :userId";
        $query = $this->em->createQuery($sql);
        $query->setParameter(':proposalId', $proposalId);
        $query->setParameter(':userId', $userId);

        try {
            $permission = $query->getSingleResult();
            if($permission){
                
                return true;
            }
        } catch (NoResultException $e) {
            
            return false;
        }
    }



    function deleteProposalUserPermissions($proposalId,$companyId)
    {
        $this->db->query("DELETE FROM proposal_user_permissions WHERE proposal_id = " . $proposalId." AND company_id = ".$companyId);
       
    }
    
    
    public function modifyPricesByStatus($statusIds,$modifier,$pModifyFrom,$pModifyTo,$account_id,$ip_address)
    {
        
        $account = $this->em->findAccount($account_id);
        $statusNames = [];
        foreach ($statusIds as $statusId) {
            $statusNames[] = $this->em->findStatus($statusId)->getText();
        }

        $proposals = $this->getCompanyRepository()->getProposalsByStatus($account->getCompany(), $statusIds,$pModifyFrom,$pModifyTo);
        $initialCount = count($proposals);

        $updated = [];

        $additional_info = array(
            'pModifyFrom' => $pModifyFrom,
            'pModifyTo' => $pModifyTo,
        );

        // Record it
        $pm = new \models\PriceModification();
        $pm->setCompanyId($account->getCompanyId());
        $pm->setAccountId($account->getAccountId());
        $pm->setUserName($account->getFullName());
        $pm->setModifier($modifier);
        $pm->setStatuses(join(' | ', $statusNames));
        $pm->setRunDate(Carbon::now());
        $pm->setIpAddress($ip_address);
        $pm->setProposalsModified(0);
        $pm->setAdditionalInfo(json_encode($additional_info));
        $this->em->persist($pm);
        $this->em->flush();

        $CI =& get_instance();

        $CI->load->library('jobs2', NULL, 'my_jobs');

        foreach ($proposals as $proposal) {


            $job_array = [
                'proposalId' => $proposal->getProposalId(),
                'account_id' => $account_id,
                'modifier' =>   $modifier,
                'price_log_id' => $pm->getId(),

            ];
            
            // Save the opaque 
            $CI->my_jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'individualProposalPriceModify', $job_array, 'test job');

        }

        $job_array = [
            'proposalCount' => $initialCount,
            'account_id' => $account_id,
            'modifier' =>   $modifier,
            'status'   =>   join(' | ', $statusNames),
            'pModifyFrom' => $pModifyFrom,
            'pModifyTo' => $pModifyTo,
            'price_log_id' => $pm->getId(),
        ];

        sleep(10);
        // Save the opaque complete Process
        $CI->my_jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'completeProposalPriceModify', $job_array, 'test job');


        $updatedCount = count($updated);
        



        echo json_encode([
            'success' => 1,
            'initialCount' => $initialCount,
            'updatedCount' => $updatedCount,
        ]);

    }

    public function individualModifyPrices($proposalId,$account_id,$modifier,$priceLogId=false)
    {
        $multiplier = 1 + ($modifier / 100);
        $proposal = $this->em->findProposal($proposalId);
        $account = $this->em->findAccount($account_id);
        $update = $this->getProposalRepository()->modifyPrice($account, $proposal, $multiplier);
          
            if ($this->getEstimationRepository()->countProposalEstimate($proposal) > 0) {
                $this->getEstimationRepository()->modifyProposalEstimatePrice($account, $proposal, $multiplier);
            }
        if($update){
            if($priceLogId){
                $pm = $this->em->find('\models\PriceModification', $priceLogId);
                $pm->setProposalsModified($pm->getProposalsModified()+1);
            
                $this->em->persist($pm);
                $this->em->flush();
            }
            
        }
            

            

    }


    public function groupModifyPrices($proposalIds,$modifier,$account_id,$ip_address)
    {

       
         foreach ($proposalIds as $proposalId) {
             $proposal = $this->em->findProposal($proposalId);
             if ($proposal) {
                $job_array = [
                    'proposalId' => $proposal->getProposalId(),
                    'account_id' => $account_id,
                    'modifier' =>   $modifier,
                ];
                $CI =& get_instance();
            
                //$CI->load->library('jobs');
                $CI->load->library('jobs2', NULL, 'my_jobs');
                // Save the opaque image
                $CI->my_jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'individualProposalPriceModify', $job_array, 'test job');
             }
         }

         $job_array = [
            'proposalCount' => count($proposalIds),
            'account_id' => $account_id,
            'modifier' =>   $modifier,
        ];

        sleep(10);
        // Save the opaque complete Process
        $CI->my_jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'completeGroupProposalPriceModify', $job_array, 'test job');


        echo json_encode([
            'success' => 1,
        ]);

    }

    
   public function getRangeCreatedMasterProposals($time,$accountIds){

            $CI = &get_instance();

            $sql = "SELECT count(p.proposalId) as counter
                    FROM proposals p
                    LEFT JOIN statuses s ON p.proposalStatus = s.id
                    WHERE p.owner IN(".implode(',',$accountIds).")
                    AND p.duplicateOf IS NULL
                    AND p.created >= {$time['start']}
                    AND p.created <= {$time['finish']}
                    AND s.prospect = 0
                    AND s.on_hold = 0";

            $query = $CI->em->getConnection()->prepare($sql);
            // $query->bindValue(':accountIds', implode(',',$accountIds));
            // $query->bindValue(':startTime', $time['start']);
            // $query->bindValue(':finishTime', $time['finish']);
            //$query->execute();

           
            $results = $query->execute();
            $data = $results->fetchAll();
            if(isset($data[0])){
                return $data[0]['counter'];
            }else{
                return 0;
            }
            
            
    }


    public function getRangeCreatedMasterProposalsPrice(array $time,$accountIds)
    {
        $CI = &get_instance();

        $sql = "SELECT SUM(p.price) as totalVal
                FROM proposals p
                LEFT JOIN statuses s ON p.proposalStatus = s.id
                WHERE p.owner IN(".implode(',',$accountIds).")
                AND p.duplicateOf IS NULL
                AND p.created >= {$time['start']}
                AND p.created <= {$time['finish']}
                AND s.prospect = 0
                AND s.on_hold = 0";

        $query = $CI->em->getConnection()->prepare($sql);
        // $query->bindValue('accountId', $this->getAccountId());
        // $query->bindValue('startTime', $time['start']);
        // $query->bindValue('finishTime', $time['finish']);
        
        $results = $query->execute();
        $data = $results->fetchAll();
            if(isset($data[0])){
                return $data[0]['totalVal'];
            }else{
                return 0;
            }
    }


    public function getRangeMasterMagicNumber(array $time, \models\Status $status,$accountIds)
    {
        $CI = &get_instance();

        $statusId = $status->getStatusId();

        $dql = "SELECT SUM(p.price)
                FROM \models\Proposals p
                WHERE p.owner IN(:accountIds)
                AND p.proposalStatus = :statusId
                AND p.duplicateOf IS NULL
                
                ";

        $query = $CI->em->createQuery($dql);
         $query->setParameter('accountIds', $accountIds);
         $query->setParameter('statusId', $statusId);
        // $query->setParameter('startTime', $time['start']);
        // $query->setParameter('finishTime', $time['finish']);

        $total = $query->getSingleScalarResult();

        return $total ?: 0;
    }


    public function getRangeMasterCreatedProposalsStatusPrice(array $time, $statusId,$accountIds)
    {
        $CI = &get_instance();

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p
                WHERE p.owner IN(:accountIds)
                AND p.duplicateOf IS NULL
                AND p.created >= :startTime
                AND p.created <= :finishTime
                AND p.proposalStatus = :statusId";

        $query = $CI->em->createQuery($dql);

        $query->setParameter('accountIds', $accountIds);
        $query->setParameter('startTime', $time['start']);
        $query->setParameter('finishTime', $time['finish']);
        $query->setParameter('statusId', $statusId);

        $total = $query->getSingleScalarResult();

        return ($total) ?: 0;
    }

    public function getMasterRolloverValue($company,$startTime, $accountIds)
    {
        $CI = &get_instance();
        $openStatus = $company->getOpenStatus();

        $dql = "SELECT SUM(p.price) FROM \models\Proposals p
                WHERE p.owner IN(:accountIds)
                AND p.duplicateOf IS NULL
                AND p.created < :startTime
                AND p.proposalStatus = :statusId";

        $query = $CI->em->createQuery($dql);
        $query->setParameter('accountIds',  $accountIds);
        $query->setParameter('startTime', $startTime);
        $query->setParameter('statusId', $openStatus->getStatusId());

        $total = $query->getSingleScalarResult();

        return $total ?: 0;
    }


    public function getTopTenProposals($start = false, $end = false, array $users, $service = 0)
    {
       
        $CI = &get_instance();

        $dql = "SELECT p FROM models\Proposals p
           WHERE p.owner IN (:users)
            AND p.proposalStatus = :openStatusId";


        if ($start) {
            $dql .= " AND p.created >= :startTime";
        }

        if ($end) {
            $dql .= " AND p.created <= :endTime";
        }

        $dql .= " ORDER BY p.price DESC";

        $query = $CI->em->createQuery($dql);
        $query->setMaxResults(10);
        //$query->setParameter('companyId', $this->getCompanyId());
        $query->setParameter('users', $users);
        $query->setParameter('openStatusId', \models\Status::OPEN);
        if ($start) {
            $query->setParameter('startTime', $start);
        }
        if ($end) {
            $query->setParameter('endTime', $end);
        }

        return $query->getResult();
    }

    public function getCompanyCustomerChecklist(Proposals $proposal)
    {
        $dql = "SELECT cm.proposal_checklist
                FROM \models\Companies cm
                WHERE cm.companyId = " . $proposal->getCompanyId() ;

        $results = $this->getDqlResults($dql);

        if ($results) {
            return $results[0];
        }

        return false;
    }
}