<?php
namespace Pms\Repositories;

use Dompdf\Exception;
use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;
use Pms\Traits\CITrait;
use \Carbon\Carbon;

class Event extends RepositoryAbstract
{
    use DBTrait;
    use CITrait;

    /**
     * Cache the types variable in case it's used multiple times to avoid multi-query
     * @var null | array
     */
    var $eventTypes = null;

    public function getAll($company, $account = null, $from = null, $to = null)
    {
        $sql = 'select * from events';
        $sql .= " where company = {$company}";
        if ($account !== null) {
            $sql .= " and account = {$account}";
        }
        if ($from !== null) {
            $sql .= " and `startTime` >= {$from}";
        }
        if ($to !== null) {
            $sql .= " and `startTime` <= {$to}";
        }
        $sql .= ' order by `startTime`';
        return $this->getAllResults($sql);
    }

    public function getTypes($company = 0, $all = false) //todo: use all flag to exclude the system events
    {
        if ($this->eventTypes === null) {
            $this->eventTypes = $this->getAllResultsIndexed(
                "SELECT et.* 
                FROM event_types et
                LEFT JOIN event_types_order eto ON et.id = eto.event_type_id AND eto.company_id = {$company}
                LEFT JOIN event_types_deleted etd ON et.id = etd.event_type_id AND etd.company_id = {$company}
                WHERE (company = 0 OR company = {$company})
                AND etd.id IS NULL
                ORDER BY COALESCE(eto.ord, 99999)", 'id');
        }
        return $this->eventTypes;
    }

    /**
     * @return void
     * Clear previously set event type order
     */
    function clearEventTypeOrder($companyId)
    {
        $this->query("DELETE FROM event_types_order 
                      WHERE company_id = {$companyId}");
    }

    public function save($eventData)
    {
        if ($eventData['startTime'] > $eventData['endTime']) { //failsafe
            $eventData['endTime'] = $eventData['startTime'] + 3600; //set it manually
        }
        $id = null;
        if (isset($eventData['id']) && $eventData['id']) {
            $eventData['updated'] = time();
            $this->update('events', 'id', $eventData['id'], $eventData);
            $id = $eventData['id'];
        } else {
            $eventData['created'] = time();
            $eventData['updated'] = time();
            $id = $this->insert('events', $eventData);
        }
        return $id;
    }

    public function remove($eventId)
    {
        $this->query("delete from events where id = {$eventId} limit 1");
    }

    public function addType($typeData)
    {
        $this->insert('event_types', $typeData);
    }

    public function removeType($typeId)
    {
        $this->query("delete from event_types where id= {$typeId} limit 1");
    }

    public function deleteType($typeId, $companyId)
    {
        $etd = new \models\EventTypeDeleted();
        $etd->setEventTypeId($typeId);
        $etd->setCompany($companyId);
        $this->em->persist($etd);
        $this->em->flush();
    }

    public function updateType($id, $data)
    {
        $this->update('event_types', 'id', $id, $data);
    }

    public function transferEventTypes($fromType, $toType, $companyId)
    {
        $this->query("UPDATE events SET type = {$toType} WHERE type = {$fromType} AND company = {$companyId}");
    }

    public function buildBody($event)
    {
        $account = $this->getAccountRepository()->getUserData($event->account);
        $text = '<strong>Start Date:</strong> ' . date('m/d/Y H:i A', $event->startTime);
        $text .= '<br><strong>End  Date:</strong> ' . date('m/d/Y H:i A', $event->endTime);
        if ($event->location) {
            $text .= '<br><strong>Location:</strong> ' . $event->location;
        }
        $text .= '<br><strong>Subject:</strong> ' . $event->name;
        $text .= '<br><strong>Notes: </strong><br>' . $event->text . '<br>';
        if ($event->proposal) {
            $proposal = $this->getProposalRepository()->get($event->proposal);
            if ($proposal) {
                $text .= '<br><strong>Proposal:</strong> ' . $proposal->projectName;
                $text .= ' [<a href="' . site_url('proposals/edit/' . $event->proposal) . '">Edit in PMS</a>]';
                $text .= '<br><strong>Project Address: </strong> ' . $proposal->projectAddress . ' ' . $proposal->projectCity . ' ' . $proposal->projectState . ' ' . $proposal->projectZip;
            }
        }
        if ($event->client || (isset($proposal) && $proposal)) {
            $client = ($event->client) ? $this->getClientRepository()->get($event->client) : $this->getClientRepository()->get($proposal->client);
            if ($client) {
                $text .= '<br><strong>Contact:</strong> ' . $client->firstName . ' ' . $client->lastName;
                $text .= ' [<a href="' . site_url('clients/edit/' . $event->client) . '">Edit in PMS</a>]';
                if ($client->email) {
                    $text .= '<br><strong>Email:</strong> ' . $client->email;
                }
                if ($client->cellPhone) {
                    $text .= '<br><strong>Cell:</strong> ' . $client->cellPhone;
                }
                if ($client->businessPhone) {
                    $text .= '<br><strong>Business Phone:</strong> ' . $client->businessPhone;
                    if ($client->businessPhoneExt) {
                        $text .= ' <strong>Ext.</strong> ' . $client->businessPhoneExt;
                    }
                }
            }
        }
        if ($event->prospect) {
            $prospect = $this->getProspectRepository()->get($event->prospect);
            $text .= '<br><strong>Prospect Data</strong><br> <strong>Name:</strong> ' . $prospect->firstName . ' ' . $prospect->lastName . ' [<a href="' . site_url('prospects/edit/' . $event->prospect) . '">Edit in PMS</a>]';
            if ($prospect) {
                if ($prospect->email) {
                    $text .= '<br><strong>Email:</strong> ' . $prospect->email;
                }
                if ($prospect->cellPhone) {
                    $text .= '<br><strong>Cell:</strong> ' . $prospect->cellPhone;
                }
                if ($prospect->businessPhone) {
                    $text .= '<br><strong>Business Phone:</strong> ' . $prospect->businessPhone;
                    if ($prospect->businessPhoneExt) {
                        $text .= ' <strong>Ext.</strong> ' . $prospect->businessPhoneExt;
                    }
                }
            }
        }
        if ($event->lead) {
            $lead = $this->getLeadRepository()->get($event->lead);
            if ($lead) {
                $text .= '<br><strong>Lead Data</strong> <br> <strong>Name: </strong> ' . $lead->firstName . ' ' . $lead->lastName . ' [<a href="' . site_url('leads/edit/' . $event->lead) . '">Edit in PMS</a>]';
                if ($lead->email) {
                    $text .= '<br><strong>Email:</strong> ' . $lead->email;
                }
                if ($lead->projectName) {
                    $text .= '<br><strong>Project: </strong>' . $lead->projectName;
                }
                if ($lead->cellPhone) {
                    $text .= '<br><strong>Cell:</strong> ' . $lead->cellPhone;
                }
                if ($lead->businessPhone) {
                    $text .= '<br><strong>Business Phone:</strong> ' . $lead->businessPhone;
                    if ($lead->businessPhoneExt) {
                        $text .= ' <strong>Ext.</strong> ' . $lead->businessPhoneExt;
                    }
                }
            }
        }
        return $text;
    }

    public function markAsFired($id)
    {
        $this->query("update events set reminderSentTime = " . time() . " where id = {$id} limit 1");
    }

    public function   getDueEvents($limit)
    {
        return $this->getAllResults('select * from events where (reminderTime is not null) and (reminderTime < ' . time() . ') and (reminderSentTime is null) limit ' . $limit);
    }

    public function scheduleDueEvents($limit = 50)
    {
        $events = $this->getDueEvents($limit);
        foreach ($events as $event) {
            $emailQueueData = [
                'subject' => 'Event Reminder: ' . $event->name,
                'body' => $this->buildBody($event),
                'recipient' => $this->getAccountRepository()->getEmailById($event->account)
            ];
            if ($this->getEmailQueueRepository()->add($emailQueueData)) {
                $this->markAsFired($event->id);
            }
        }
    }

    public function getUpcomingEventsCount(\models\Accounts $account)
    {
        return $this->getCalendarEventObjects(
            $account,
            Carbon::now()->timestamp,
            Carbon::now()->addWeek()->timestamp,
            true
        );
    }

    // public function getCalendarEvents($start, $end, $company, $account = null, $branch = null)
    // {
    //     $sql = "SELECT e.account, e.id, e. NAME AS `title`, e.startTime AS startTime, e.endTime as endTime, et.color as textColor, et.backgroundColor, proposal, client, lead, prospect FROM `events` e";
    //     $sql .= " LEFT JOIN event_types et ON e.type = et.id";
    //     $sql .= " where (e.company = {$company}) and (e.startTime between {$start} and {$end})";
    //     if ($branch) {
    //         $sql .= " and e.account in (select accountId from accounts where branch = {$branch})";
    //     }
    //     if (!$branch && $account) {
    //         $sql .= " and (e.account = {$account})";
    //     }
    //     if ($this->ci->session->userdata('calendarType')) {
    //         $sql .= 'and et.id = ' . $this->ci->session->userdata('calendarType');
    //     }
    //     if ($this->ci->session->userdata('calendarBy')) {
    //         if ($this->ci->session->userdata('calendarBy') == 'completed') {
    //             $sql .= ' and e.eventCompleteTime is not null';
    //         }
    //         if ($this->ci->session->userdata('calendarBy') == 'incomplete') {
    //             $sql .= ' and e.eventCompleteTime is null';
    //         }
    //     }
    //     if ($this->ci->session->userdata('calendarUser')) {
    //         $sql .= ' and (e.account = ' . $this->ci->session->userdata('calendarUser') . ')';
    //     }
    //     $events = $this->getAllResults($sql, 'array');
    //     foreach ($events as $key => $event) {
    //         $prefix = '';
    //         if ($event['proposal']) {
    //             $proposal = $this->getProposalRepository()->get($event['proposal']);
    //             $prefix = ($proposal) ? '[Proposal: ' . $proposal->projectName . ']' : '';
    //         }
    //         if ($event['lead']) {
    //             $lead = $this->getLeadRepository()->get($event['lead']);
    //             $prefix = ($lead) ? '[Lead: ' . $lead->projectName . ']' : '';
    //         }
    //         if ($event['client']) {
    //             $client = $this->getClientRepository()->get($event['client']);
    //             $prefix = ($client) ? '[Contact: ' . $client->firstName . ' ' . $client->lastName . ']' : '';
    //         }
    //         if ($event['prospect']) {
    //             $prospect = $this->getProspectRepository()->get($event['prospect']);
    //             $prefix = ($prospect) ? '[Prospect: ' . $prospect->firstName . ' ' . $prospect->lastName . ']' : '';
    //         }
    //         if ($prefix) {
    //             //$events[$key]['title'] = $prefix . ' ' . $events[$key]['title'];
    //         }
    //         $user = $this->getAccountRepository()->getUserData($events[$key]['account']);
    //         $firstName = (strpos($user->firstName, ' ')) ? substr($user->firstName, 0, strpos($user->firstName, ' ')) : $user->firstName;
    //         $userName = $firstName . ' ' . strtoupper(substr($user->lastName, 0, 1)) . '.';
    //         $events[$key]['title'] = '[' . $userName . '] ' . $events[$key]['title'];

    //         $events[$key]['start'] = date('Y-m-d H:i:s', $event['startTime']);
    //         $events[$key]['end'] = date('Y-m-d H:i:s', $event['endTime']);
    //         unset($events[$key]['startTime']);
    //         unset($events[$key]['endTime']);
    //     }
    //     return $events;
    // }
    public function getCalendarEvents($start, $end, $company, $account = null, $branch = null)
{
    $sql = "SELECT e.account, e.id, e.NAME AS `title`, e.startTime AS startTime, e.endTime as endTime, et.color as textColor, et.backgroundColor, proposal, client, lead, prospect FROM `events` e";
    $sql .= " LEFT JOIN event_types et ON e.type = et.id";
    $sql .= " where (e.company = {$company}) and (e.startTime between '{$start}' and '{$end}')"; // Corrected: Added single quotes for date values
    
    $sql = "SELECT e.account, e.id, e.NAME AS `title`, e.startTime AS startTime, e.endTime as endTime, et.color as textColor, et.backgroundColor, e.proposal, e.client, e.lead, e.prospect 
    FROM `events` e";
$sql .= " LEFT JOIN event_types et ON e.type = et.id";
$sql .= " LEFT JOIN prospects p ON e.prospect = p.prospectId"; // Assuming 'prospect' is a column in the 'events' table and 'id' is the primary key in the 'prospects' table
$sql .= " WHERE (e.company = {$company}) AND (e.startTime BETWEEN '{$start}' AND '{$end}')"; 
// Rest of your conditions...

  
    if ($branch) {
        $sql .= " and e.account in (select accountId from accounts where branch = '{$branch}')"; // Corrected: Added single quotes for branch value
    }
    if (!$branch && $account) {
        $sql .= " and (e.account = {$account})";
    }
    if ($this->ci->session->userdata('calendarType')) {
        $sql .= ' and et.id = ' . $this->ci->session->userdata('calendarType');
    }
    if ($this->ci->session->userdata('calendarBy')) {
        if ($this->ci->session->userdata('calendarBy') == 'completed') {
            $sql .= ' and e.eventCompleteTime is not null';
        }
        if ($this->ci->session->userdata('calendarBy') == 'incomplete') {
            $sql .= ' and e.eventCompleteTime is null';
        }
    }
    if ($this->ci->session->userdata('calendarUser')) {
        $sql .= ' and (e.account = ' . $this->ci->session->userdata('calendarUser') . ')';
    }
    $events = $this->getAllResults($sql, 'array');
    foreach ($events as $key => $event) {
        $prefix = '';
        if ($event['proposal']) {
            $proposal = $this->getProposalRepository()->get($event['proposal']);
            $prefix = ($proposal) ? '[Proposal: ' . $proposal->projectName . ']' : '';
        }
        if ($event['lead']) {
            $lead = $this->getLeadRepository()->get($event['lead']);
            $prefix = ($lead) ? '[Lead: ' . $lead->projectName . ']' : '';
        }
        if ($event['client']) {
            $client = $this->getClientRepository()->get($event['client']);
            $prefix = ($client) ? '[Contact: ' . $client->firstName . ' ' . $client->lastName . ']' : '';
        }
        if ($event['prospect']) {
            $prospect = $this->getProspectRepository()->get($event['prospect']);
            $prefix = ($prospect) ? '[Prospect: ' . $prospect->firstName . ' ' . $prospect->lastName . ']' : '';
        }
        if ($prefix) {
            //$events[$key]['title'] = $prefix . ' ' . $events[$key]['title'];
        }
        $user = $this->getAccountRepository()->getUserData($events[$key]['account']);
        $firstName = (strpos($user->firstName, ' ')) ? substr($user->firstName, 0, strpos($user->firstName, ' ')) : $user->firstName;
        $userName = $firstName . ' ' . strtoupper(substr($user->lastName, 0, 1)) . '.';
        $events[$key]['title'] = '[' . $userName . '] ' . $events[$key]['title'];

        $events[$key]['start'] = date('Y-m-d H:i:s', $event['startTime']);
        $events[$key]['end'] = date('Y-m-d H:i:s', $event['endTime']);
        unset($events[$key]['startTime']);
        unset($events[$key]['endTime']);
    }
    return $events;
}


    public function getCalendarEventObjects(\models\Accounts $user, $start, $end, $count = false)
    {
        $company = $user->getCompany()->getCompanyId();
        $branch = null;
        $account = null;

        // Lets apply some permissions
        if ($user) {
            if ($user->isBranchAdmin()) {
                $branch = $user->getBranch();
            }
            if ($user->isUser()) {
                $account = $user->getAccountId();
            }
        }

        if ($count) {
            $sql = "SELECT count(e.id) as numEvents";
        } else {
            $sql = "SELECT e.id";
        }
        $sql .= " FROM events e";
        $sql .= " LEFT JOIN event_types et ON e.type = et.id";
        if ($branch) {
            $sql .= " LEFT JOIN accounts a ON e.account = a.accountId";
        }
        $sql .= " where (e.company = {$company}) and (e.startTime between {$start} and {$end})";
        if ($branch) {
            $sql .= " and a.branch = {$branch}";
        }
        if (!$branch && $account) {
            $sql .= " and (e.account = {$account})";
        }

        if ($count) {
            return $this->scalar($sql, 'numEvents');
        }

        $events = $this->getAllResults($sql);
        $out = [];
        foreach ($events as $eventData) {
            $event = $this->em->findEvent($eventData->id);
            if ($event):
                $out[] = $event;
            endif;
        }
        return $out;
    }


    public function get($id)
    {
        return $this->getSingleResult('select * from events where id=' . $id);
    }

    public function getEventSyncDataByGoogleEventId($googleEventId)
    {
        return $this->getSingleResult("select * from events_synced where google_event_id='{$googleEventId}'", 'array');
    }


    public function getEventData($id)
    {
       //$eventInformation = $this->getSingleResult("select id, name, text, type, client, proposal, account, lead, prospect, location, startTime as start, endTime as end, reminderTime, eventCompleteTime from events where id={$id}", 'array');
       $eventInformation = $this->getSingleResult("select * from events where id={$id}", 'array');

      
 
        $eventInformation['startDate'] = date('m/d/Y', $eventInformation['startTime']);
        $eventInformation['endDate'] = date('m/d/Y', $eventInformation['endTime']);
        $eventInformation['startTimeHr'] = date('g', $eventInformation['startTime']);
        $eventInformation['startTimeMin'] = date('i', $eventInformation['startTime']);
        $eventInformation['startPeriod'] = date('A', $eventInformation['startTime']);
        $eventInformation['endTimeHr'] = date('g', $eventInformation['endTime']);
        $eventInformation['endTimeMin'] = date('i', $eventInformation['endTime']);
        $eventInformation['endPeriod'] = date('A', $eventInformation['endTime']);
        $eventInformation['startTime24h'] = date('H:i', $eventInformation['startTime']);
        $eventInformation['duration'] = $eventInformation['endTime'] - $eventInformation['startTime'];
        $eventInformation['reminderDuration'] = ($eventInformation['reminderTime']) ? ($eventInformation['startTime'] - $eventInformation['reminderTime']) : null;
        //proposal additioal info
        if ($eventInformation['proposal']) {
            $eventInformation['linkedTo'] = 'Proposal';
            $proposal = $this->getProposalRepository()->get($eventInformation['proposal']);
            $proposalData = ($proposal) ? '<a href="' . site_url('proposals/edit/' . $proposal->proposalId) . '" target="_blank">' . $proposal->projectName . '</a>' : 'Proposal Not Found';
            $client = $this->getClientRepository()->get($proposal->client);
            if ($client) {
                $proposalData .= ' | <a href="' . site_url('clients/edit/' . $client->clientId) . '" target="_blank">' . $client->firstName . ' ' . $client->lastName . '</a>';
                if ($client->cellPhone) {
                    $proposalData .= ' | <strong>Cell:</strong> ' . $client->cellPhone;
                }
                if ($client->businessPhone) {
                    $proposalData .= ' | <strong>Business Phone:</strong> ' . $client->businessPhone;
                    if ($client->businessPhoneExt) {
                        $proposalData .= ' <strong>Ext.</strong> ' . $client->businessPhoneExt;
                    }
                }
            }
            $eventInformation['linkedToName'] = $proposalData;
        }
        //lead addtional info
        if ($eventInformation['lead']) {
            $eventInformation['linkedTo'] = 'Lead';
            $lead = $this->getLeadRepository()->get($eventInformation['lead']);
            if (!$lead) {
                $leadData = 'Lead Not Found';
            } else {
                $leadData = '<a href="' . site_url('leads/edit/' . $lead->leadId) . '" target="_blank">' . $lead->firstName . ' ' . $lead->lastName . '</a>';
                if ($lead->projectName) {
                    $leadData .= ' | <strong>Project: </strong>' . $lead->projectName;
                }
                if ($lead->cellPhone) {
                    $leadData .= ' | <strong>Cell:</strong> ' . $lead->cellPhone;
                }
                if ($lead->businessPhone) {
                    $leadData .= ' | <strong>Business Phone:</strong> ' . $lead->businessPhone;
                    if ($lead->businessPhoneExt) {
                        $leadData .= ' <strong>Ext.</strong> ' . $lead->businessPhoneExt;
                    }
                }
            }
            $eventInformation['linkedToName'] = $leadData;
        }
        //prospect additional info
        if ($eventInformation['prospect']) {
            $eventInformation['linkedTo'] = 'Prospect';
            $prospect = $this->getProspectRepository()->get($eventInformation['prospect']);
            if (!$prospect) {
                $prospectData = 'Prospect Not Found';
            } else {
                $prospectData = '<a href="' . site_url('prospects/edit/' . $prospect->prospectId) . '" target="_blank">' . $prospect->firstName . ' ' . $prospect->lastName . '</a>';
                if ($prospect->cellPhone) {
                    $prospectData .= ' | <strong>Cell:</strong> ' . $prospect->cellPhone;
                }
                if ($prospect->businessPhone) {
                    $prospectData .= ' | <strong>Business Phone:</strong> ' . $prospect->businessPhone;
                    if ($prospect->businessPhoneExt) {
                        $prospectData .= ' <strong>Ext.</strong> ' . $prospect->businessPhoneExt;
                    }
                }
            }
            $eventInformation['linkedToName'] = $prospectData;
        }
        //client additional info
        if ($eventInformation['client']) {
            $eventInformation['linkedTo'] = 'Contact';
            $client = $this->getClientRepository()->get($eventInformation['client']);
            if (!$client) {
                $clientData = 'Contact Not Found';
            } else {
                $clientData = '<a href="' . site_url('clients/edit/' . $client->clientId) . '" target="_blank">' . $client->firstName . ' ' . $client->lastName . '</a>';
                if ($client->cellPhone) {
                    $clientData .= ' | <strong>Cell:</strong> ' . $client->cellPhone;
                }
                if ($client->businessPhone) {
                    $clientData .= ' | <strong>Business Phone:</strong> ' . $client->businessPhone;
                    if ($client->businessPhoneExt) {
                        $clientData .= ' <strong>Ext.</strong> ' . $client->businessPhoneExt;
                    }
                }
            }
            $eventInformation['linkedToName'] = $clientData;
        }

        return $eventInformation;
    }


    public function getContactEvents($contactId, $from = null, $to = null)
    {
        return $this->getSpecificEvents('client', $contactId, $from, $to);
    }

    public function getProspectEvents($prospectId, $from = null, $to = null)
    {
        return $this->getSpecificEvents('prospect', $prospectId, $from, $to);
    }

    public function getAccountEvents($accountId, $from = null, $to = null)
    {
        return $this->getSpecificEvents('client', "(select clientId from clients where client_account = {$accountId})", $from, $to, 'in');
    }

    public function getLeadEvents($leadId, $from = null, $to = null)
    {
        return $this->getSpecificEvents('lead', $leadId, $from, $to);
    }

    public function getProposalEvents($proposalId, $from = null, $to = null)
    {
        return $this->getSpecificEvents('proposal', $proposalId, $from, $to);
    }

    public function getSpecificEvents($column, $id, $from = null, $to = null, $operator = '=')
    {
        // $sql = 'SELECT id FROM events';
        // $sql .= " WHERE {$column} {$operator} {$id}";
        // if ($from !== null) {
        //     $sql .= " and `startTime` >= {$from}";
        // }
        // if ($to !== null) {
        //     $sql .= " and `startTime` <= {$to}";
        // }
        // $sql .= ' order by `startTime`';
        //Note: above query not working on localhost
        $sql = 'SELECT e.id FROM events AS e';
        $sql .= " WHERE e.{$column} {$operator} {$id}";
        if ($from !== null) {
        $sql .= " AND e.startTime >= '{$from}'";
        }
        if ($to !== null) {
        $sql .= " AND e.startTime <= '{$to}'";
        }
        $sql .= ' ORDER BY e.startTime';


 
        $events = [];
        $eventResults = $this->getAllResults($sql);

        foreach ($eventResults as $result) {
            $events[] = $this->em->findEvent($result->id);
        }
        return $events;
    }

    public function getEventsToSync($limit)
    {
        $query = "SELECT e.*, es.id as sync_id, es.google_event_id, es.google_calendar_id, es.synced FROM events e
        LEFT JOIN events_synced es ON e.id = es.event_id 
        LEFT JOIN google_auth_data gad ON e.account = gad.account
        WHERE
	    (startTime > " . time() . ") 
	    AND 
	    ((es.id IS NULL) OR ((es.id IS NOT NULL) AND (e.updated > es.synced) AND (es.google_calendar_id = gad.pms_calendar_id))) 
	    AND 
	    (gad.access_token IS NOT NULL) 
	    AND 
	    (gad.access_token <> '')
	    LIMIT {$limit};";
        return $this->getAllResults($query);
    }

    public function getOauthConnectedAccounts()
    {
        return $this->getAllResults("select * from google_auth_data where access_token is not null and access_token <> ''");
    }

    public function getSyncedEventsToDelete($limit)
    {
        return $this->getAllResults("SELECT es.* FROM events_synced es LEFT JOIN events e ON e.id = es.event_id WHERE e.id IS NULL LIMIT {$limit};");
    }

    public function syncFromGoogle($limit)
    {
        $syncedEvents = 0;
        $authAccounts = $this->getEventRepository()->getOauthConnectedAccounts();

        var_dump($authAccounts);

        foreach ($authAccounts as $authAccountData) {
            try {
                $googleAuth = $this->getGoogleAuthRepository($authAccountData->account);
                $syncedEvents += $googleAuth->syncChangedEvents();
                if ($syncedEvents > $limit) {
                    break;
                }
            } catch (Exception $e) {
                //skip it
            }
        }
        return $syncedEvents;
    }

}