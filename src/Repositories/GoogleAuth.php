<?php
namespace Pms\Repositories;


use League\OAuth2\Client\Grant\RefreshToken;
use League\OAuth2\Client\Provider\Google;
use League\OAuth2\Client\Token\AccessToken;
use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;
use Google_Service_Calendar_Calendar;
use Google_Service_Calendar_Event;
use Google_Service_Calendar_EventDateTime;
use Google_Service_Calendar;
use Google_Client;
use Google_Service_Calendar_EventReminder;
use Google_Service_Calendar_EventReminders;
use \Carbon\Carbon;
use \DateTime;

class GoogleAuth extends RepositoryAbstract
{
    use DBTrait;

    protected $clientId = '439413438004-9tonspkcj7vn01oqogd7b0h277barshp.apps.googleusercontent.com';
    protected $clientSecret = 'jti1pcJVDtw5TUysgjUj1aBC';
    protected $redirectUri = '';
    protected $accessType = 'offline';
    protected $scopes = [
        'https://www.googleapis.com/auth/calendar',
    ];

    private $provider;
    private $oauth_data = null;
    private $account;
    private $authenticated = false;

    /**
     * @var Google_Client
     */
    private $client;
    /**
     * @var Google_Service_Calendar
     */
    private $calendarService;

    /**
     * GoogleAuth constructor.
     * @param $accountId
     * @throws \Exception if $accountId is invalid
     */
    public function __construct($accountId)
    {
        parent::__construct();
        $this->redirectUri = site_url('account/google_auth');
        //get user data and validate it
        $this->account = $this->getAccountRepository()->getUserData($accountId);
        if (!$this->account) {
            throw new \Exception('User ID provided is invalid!');
        }
        //init the Oauth Data stored in the DB
        $this->initOauthData();
        //init the provider
        $this->provider = new Google([
            'clientId' => $this->clientId,
            'clientSecret' => $this->clientSecret,
            'redirectUri' => $this->redirectUri,
            'accessType' => $this->accessType,
        ]);
        //Try auth if there's a token and refresh token stored
        if ($this->getAccessToken()) {
            if ($this->tokenExpired() && $this->getRefreshToken()) {
                $grant = new RefreshToken();
                $access_token = $this->provider->getAccessToken($grant, [
                    'refresh_token' => $this->getRefreshToken()
                ]);
                $refresh_token = $access_token->getRefreshToken();
                if ($access_token) {
                    $this->updateTokens($access_token, $refresh_token);
                }
            }
            try {
                $this->initGoogleClient();
                $this->calendarService = new Google_Service_Calendar($this->client);
                $clist = $this->getCalendarService()->calendarList->listCalendarList();
            } catch (\Exception $e) {
                $this->disconnect();
            }
            $this->authenticated = 1;
        }
        //Do ya thing girl
        if ($this->authenticated()) {
            //check google calendar exists
            if (!$this->oauth_data->pms_calendar_id || !$this->calendarExists($this->getCalendarId())) {
                $calendar_id = $this->createPMSCalendar();
                if ($calendar_id) {
                    $this->oauth_data->pms_calendar_id = $calendar_id;
                } else {
                    $this->authenticated = false;
                }
                $this->persistOauthData();
            }

        }
    }

    private function initOauthData()
    {
        $this->oauth_data = $this->getOauthDataFromDb();
        if (!$this->oauth_data) {
            $this->insert('google_auth_data', [
                'account' => $this->account->accountId
            ]);
            $this->oauth_data = $this->getOauthDataFromDb();
        }
    }

    private function getOauthDataFromDb()
    {
        return ($this->account) ? $this->getSingleResult("select * from google_auth_data where account={$this->account->accountId}") : null;
    }

    public function persistOauthData()
    {
        $data = (array)$this->oauth_data;
        $this->update('google_auth_data', 'id', $this->oauth_data->id, $data);
    }

    public function authenticated()
    {
        return $this->authenticated;
    }

    public function newAuth()
    {
        if (!empty($_GET['error'])) {
            return ['error' => $_GET['error']];
        } elseif (empty($_GET['code'])) {
            $authUrl = $this->provider->getAuthorizationUrl([
                'scope' => $this->scopes
            ]);
            $this->ci->session->set_userdata('oauth2state', $this->provider->getState());
            header('Location: ' . $authUrl);
            exit;
        } elseif (empty($_GET['state']) || ($_GET['state'] !== $this->ci->session->userdata('oauth2state'))) {
            $this->ci->session->unset_userdata('oauth2state');
            return ['error' => 'Invalid authentication state!'];
        } else {
            $access_token = $this->provider->getAccessToken('authorization_code', [
                'code' => $_GET['code']
            ]);
            $refresh_token = $access_token->getRefreshToken();
            $this->updateTokens($access_token, $refresh_token);
            return true;
        }
    }

    private function updateTokens($access_token, $refresh_token = null)
    {
        if ($access_token != null) {
            $this->oauth_data->access_token = json_encode($access_token);
        } else {
            $this->oauth_data->access_token = $access_token;
        }
        if ($refresh_token !== null) {
            $this->oauth_data->refresh_token = $refresh_token;
        }
        $this->persistOauthData();
    }

    private function clearTokens()
    {
        $this->updateTokens(null, '');
    }

    private function fixToken($token)
    {
        if (!isset($token->expires_in) || !isset($token->created)) {
            if (!isset($token->expires)) {
                throw new \Exception('There was a problem with the token!');
            }
            $token->expires_in = $token->expires - time();
            $token->created = time() - $token->expires_in;
        }
        return $token;
    }

    public function getAccessToken()
    {
        return ($this->oauth_data->access_token) ? $this->fixToken(json_decode($this->oauth_data->access_token)) : null;
    }

    public function getLeagueAccessToken()
    {
        return new AccessToken((array)$this->getAccessToken());
    }

    public function getRefreshToken()
    {
        return $this->oauth_data->refresh_token;
    }

    public function tokenExpired()
    {
        $token = $this->getaccessToken();
        return (($token->expires) < time());
    }

    public function expiresIn()
    {
        return ($this->getAccessToken()) ? (($this->getAccessToken()->expires) - time()) : 'No Token';
    }

    public function disconnect()
    {
        if ($this->authenticated()) {
            $this->getClient()->revokeToken();
        }
        $this->clearTokens();
        $this->authenticated = false;
    }

    public function getClient()
    {
        return $this->client;
    }

    public function getCalendarService()
    {
        return $this->calendarService;
    }

    public function initGoogleClient()
    {
        $this->client = new Google_Client();
        $this->client->setApplicationName("PMS");
        $this->client->setAccessType($this->accessType);
        $this->client->setRedirectUri($this->redirectUri);
        $this->client->setClientId($this->clientId);
        $this->client->setClientSecret($this->clientSecret);
        //Authenticate scopes
        foreach ($this->scopes as $scope) {
            $this->client->addScope($scope);
        }
        $this->client->setAccessToken((array)$this->getAccessToken());
    }


    /**
     * Creates a calendar called PMS in google
     * @return string calendar ID string from google
     */
    public function createPMSCalendar()
    {
        $calendar = new Google_Service_Calendar_Calendar();
        $calendar->setSummary(SITE_NAME);
        $calendar->setTimeZone($this->getGoogleTimeZone());
        try {
            $createdCalendar = $this->getCalendarService()->calendars->insert($calendar);
        } catch (\Exception $e) {
            return false;
        }
        return $createdCalendar->getId();
    }

    public function getGoogleTimeZone()
    {
        switch ($this->account->timeZone) {
            case 'MST':
                return 'America/Denver';
                break;
            case 'PST':
                return 'America/Los_Angeles';
                break;
            case 'CST':
                return 'America/Chicago';
                break;
            default:
                return 'America/New_York';
                break;
        }
    }

    /**
     * Checks if the calendar ID stored in our db exists on google
     * @param $calendarId
     * @return bool
     */
    public function calendarExists($calendarId)
    {
        try {
            $this->getCalendarService()->calendarList->get($calendarId);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    public function getCalendarId()
    {
        return $this->oauth_data->pms_calendar_id;
    }

    /**
     * @param $event
     * @return string event ID string from google
     */
    public function syncEvent($event_id, $google_event_id)
    {
        //for non auth users do nothing
        if (!$this->authenticated()) {
            return false;
        }
        //get event
        $event = $this->getEventRepository()->get($event_id);
        if (!$event) { //inexistent event
            return false;
        }
        if ($google_event_id) {
            //remove old event and its sync data
            $this->removeSyncDataByGoogleEventId($google_event_id);
            $this->deleteEvent($google_event_id);
        }
        $google_event = new Google_Service_Calendar_Event();
        //build google event
        $google_event->setSummary($event->name);
        $google_event->setDescription($event->text);
        $start = new Google_Service_Calendar_EventDateTime();
        $start->setDateTime(date('c', $event->startTime));
        $start->setTimeZone($this->getGoogleTimeZone());
        $end = new Google_Service_Calendar_EventDateTime();
        $end->setDateTime(date('c', $event->endTime));
        $end->setTimeZone($this->getGoogleTimeZone());
        $google_event->setStart($start);
        $google_event->setEnd($end);
        if ($event->location) {
            $google_event->setLocation($event->location);
        }
        if ($event->reminderTime) {
            $reminderMinutes = round(($event->startTime - $event->reminderTime) / 60);
            $reminder = new Google_Service_Calendar_EventReminder();
            $reminder->setMethod('email');
            $reminder->setMinutes($reminderMinutes);
            $reminders = new Google_Service_Calendar_EventReminders();
            $reminders->setUseDefault('false');
            $reminders->setOverrides(array($reminder));
            $google_event->setReminders($reminders);
        }
        //save to google
        $google_event = $this->getCalendarService()->events->insert($this->getCalendarId(), $google_event);
        $google_event_id = $google_event->getId();
        $this->updateSyncData($event_id, $event->account, $google_event_id, $this->getCalendarId());
        return true;
    }

    public function removeSyncDataByGoogleEventId($google_event_id)
    {
        $this->query("delete from events_synced where google_event_id = '{$google_event_id}'");
    }

    public function updateSyncData($event_id, $account, $google_event_id, $google_calendar_id)
    {
        $this->query("delete from events_synced where event_id = {$event_id} and google_event_id = '{$google_event_id}' and google_calendar_id = '{$google_calendar_id}'");
        $this->insert('events_synced', [
            'event_id' => $event_id,
            'account' => $account,
            'google_event_id' => $google_event_id,
            'google_calendar_id' => $google_calendar_id,
            'synced' => time(),
        ]);
    }

    public function deleteEvent($google_event_id)
    {
        $this->removeSyncDataByGoogleEventId($google_event_id);
        if ($this->authenticated()) {
            try {
                $this->getCalendarService()->events->delete($this->getCalendarId(), $google_event_id);
            } catch (\Exception $e) {
                return false;
            }
            return true;
        }
        return false;
    }

    public function syncChangedEvents()
    {
        if ($this->authenticated()) {
            $syncCounter = 0;
            // Get The events
            $events = $this->getCalendarService()->events->listEvents($this->oauth_data->pms_calendar_id);
            // Stuff we'll need for each user
            $account = $this->em->findAccount($this->oauth_data->account);
            $company = $account->getCompany();
            // Save the sync token - this should be set after the initial sync
            $this->oauth_data->sync_token = $events->getNextSyncToken();
            $this->persistOauthData();

            $eventItems = $events->getItems();

            foreach ($eventItems as $eventItem) {

                if ($eventItem->start) {

                    /* @var $eventItem Google_Service_Calendar_Event */
                    // Get the sync_event data from the google_event_id if we have it
                    $savedEventData = $this->getEventRepository()->getEventSyncDataByGoogleEventId($eventItem->getId());

                    // Calculate the timestamps
                    $startTime = Carbon::createFromFormat(DateTime::ISO8601, $eventItem->start->dateTime);
                    $endTime = Carbon::createFromFormat(DateTime::ISO8601, $eventItem->end->dateTime);

                    // Default to 1 hr reminder
                    $reminderMinutes = 60;
                    // Check for override
                    if (count($eventItem->getReminders()->getOverrides())) {
                        $reminderMinutes = $eventItem->getReminders()->getOverrides()[0]->minutes;
                    }
                    $reminderTimeStamp = $startTime->copy()->subMinutes($reminderMinutes)->timestamp;

                    // Build the data
                    $data = [
                        'id' => (isset($savedEventData['event_id'])) ? $savedEventData['event_id'] : null,
                        'account' => $account->getAccountId(),
                        'location' => ($eventItem->location) ?: null,
                        'company' => $company->getCompanyId(),
                        'name' => $eventItem->getSummary(),
                        'text' => $eventItem->getDescription(),
                        'startTime' => $startTime->timestamp,
                        'endTime' => $endTime->timestamp,
                        'reminderTime' => $reminderTimeStamp,
                        'type' => 1 // Default to reminder
                    ];

                    $eventId = $this->getEventRepository()->save($data);

                    // Update the sync data
                    $this->updateSyncData(
                        $eventId,
                        $account->getAccountId(),
                        $eventItem->getId(),
                        $this->oauth_data->pms_calendar_id
                    );
                    $syncCounter++;
                }
            }
            return $syncCounter;
        }
        else {
            echo 'Not authenticated';
        }
        return 0;
    }


}