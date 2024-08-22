<?php
namespace Pms\Repositories;

use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;
use \models\Companies;

class LeadNotifications extends RepositoryAbstract
{
    use DBTrait;

    var $notificationSettings = [];

    /**
     * Sends instant notification, if that is enabled
     * @param $companyId
     * @param $leadId
     */
    public function sendUnassignedNotification($companyId, $leadId)
    {
        if ($this->instantNotificationsEnabled($companyId)) {
            $settings = $this->getLeadNotificationSettings($companyId);
            //create lead information array for email
            $leadInformation = ($this->getLeadRepository()->getEmailInformation($leadId)) ?: [];
            $accountInformation = ($this->getAccountRepository()->getBasicEmailInformation($settings->account)) ?: [];
            $email = $this->getAccountRepository()->getEmailById($settings->account);
            if ($email) {
                $this->getLogRepository()->add(['action' => 'lead_instant_notification', 'details' => 'Lead: Unassigned Instant Email Notification to ' . $email, 'account' => $settings->account]);
                $this->getEmailRepository()->sendSystemEmail(21, $email, array_merge($leadInformation, $accountInformation));
            }
        }
    }

    /**
     * Returns the mysql settings table for the lead notification settings
     * @param $companyId
     * @return mixed
     */
    public function getLeadNotificationSettings($companyId)
    {
        if (!isset($this->notificationSettings[$companyId])) {
            $this->notificationSettings[$companyId] = $this->getSingleResult('select * from lead_notification_settings where company=' . $companyId);
        }
        return ($this->notificationSettings[$companyId]);
    }

    /**
     * Checks if instant notifications are enabled for given companyId
     * @param $companyId
     * @return bool
     */
    public function instantNotificationsEnabled($companyId)
    {
        $notificationSettings = $this->getLeadNotificationSettings($companyId);
        return ($notificationSettings) ? ($notificationSettings->enabled && $notificationSettings->instant) : false;
    }

    /**
     * Sends daily notifications for companies who have the setting enabled for given hour and timezone
     * @param $hour
     * @param $timezone
     */
    public function sendDailyNotifications($hour, $timezone)
    {
        $time = time();

        //get all accounts that have to be notified checking settings in same query
        $sql = "SELECT ls.company, ls.account, a.email,
            (SELECT GROUP_CONCAT(l.leadId) FROM leads l WHERE l.company = ls.company AND ( l.account = 0 OR l.account IS NULL ) and (l.status = 'Working' or l.status = 'Waiting for subs')) AS leads 
            FROM lead_notification_settings ls  
            INNER JOIN accounts a ON ls.account = a.accountId 
            INNER JOIN companies c on ls.company = c.companyId
            WHERE ls.enabled = 1 AND ls.notificationIntervals LIKE '%{$hour}%' and a.timeZone = '{$timezone}' AND (c.companyStatus <> 'Inactive') AND (a.expires > {$time})";
        $notifications = $this->getAllResults($sql, 'array');
        foreach ($notifications as $notification) {
            if ($notification['leads']) {
                //send notifications
                $leads = $this->getAllResults("select * from leads where leadId in ({$notification['leads']})");
                $accountInformation = $this->getAccountRepository()->getBasicEmailInformation($notification['account']);
                $leadsContent = "________________________________<br>\n";
                $leadsCount = 0;
                foreach ($leads as $lead) {
                    $requestedServices = ($lead->services) ? $this->getLeadRepository()->getRequestedServices($lead->services . ',-1') : ['requested_work' => ''];
                    $leadsCount++;
                    $leadsContent .= '<p>';
                    $leadsContent .= '<strong>Company Name:</strong> ' . $lead->companyName . '<br>';
                    $leadsContent .= '<strong>Project Name:</strong> ' . $lead->projectName . '<br>';
                    $leadsContent .= '<strong>Contact:</strong> ' . $lead->firstName . ' ' . $lead->lastName;
                    if ($lead->title) {
                        $leadsContent .= ' | ' . $lead->title;
                    }
                    if ($lead->businessPhone) {
                        $leadsContent .= ' | ' . $lead->businessPhone;
                    }
                    $leadsContent .= '<br>';
                    $leadsContent .= '<strong>Requested Work: </strong> ' . $requestedServices['requested_work'];
                    $leadsContent .= '<br>';
                    $leadsContent .= '</p>';
                    $leadsContent .= "________________________________<br>\n";
                }
                $accountInformation['leads'] = $leadsContent;
                $accountInformation['leads_count'] = $leadsCount;
                $accountInformation['unassigned_leads_url'] = site_url('leads/group/filter/user/u');
                $this->getLogRepository()->add([
                    'action' => 'lead_daily_notification',
                    'details' => "Leads: Unassigned Daily Email Notification for {$leadsCount} leads to " . $notification['email'] . " at {$hour}:00 {$timezone}",
                    'account' => $notification['account'],
                ]);
                $this->getEmailRepository()->sendSystemEmail(22, $notification['email'], array_merge($accountInformation));
            }
        }
    }

    public function setDefaultNotificationSettings(Companies $company)
    {
        $notificationData = [
            'enabled' => 0,
            'instant' => 0,
            'account' => $company->getAdministrator()->getAccountId(),
            'company' => $company->getCompanyId(),
            'notificationIntervals' => ''
        ];

        $this->db->insert('lead_notification_settings', $notificationData);
    }

}