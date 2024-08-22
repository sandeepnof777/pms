<?php
namespace Pms\Repositories;

use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;

class Google extends RepositoryAbstract
{
    use DBTrait;

    var $access_token = null;
    var $refresh_token = null;
    var $oauth_data = null;
    var $account;
    var $calendarService;
    private $authenticated = false;

    /**
     * @var \Google_Client
     */
    var $client = null;

    public function __construct()
    {
        parent::__construct();
        if ($this->getAccountRepository()->getLoggedAccount()) {
            $this->setAccount($this->getAccountRepository()->getLoggedAccount()->accountId);
        }
        return $this;
    }

    public function init()
    {
        $this->getTokens(); //creates the oauth data entry if not exists - for persistence and gets the tokens if they exist
        $this->checkAuth();

        if ($this->authenticated()) {
            if (!$this->oauth_data->pms_calendar_id || !$this->calendarExists($this->oauth_data->pms_calendar_id)) {
                $this->oauth_data->pms_calendar_id = $this->createPMSCalendar();
                $this->saveOauthData();
            }
        }
    }

    public function setAccount($accountId)
    {
        $this->account = $this->getAccountRepository()->getUserData($accountId);
        $this->init();
    }

    /**
     * Initializes the $client member
     * @return \Google_Client
     */
    protected function initClient()
    {
        $this->client = new \Google_Client();
        $this->client->setAccessType('offline');
        $this->client->setApplicationName("PMS");
        $this->client->setRedirectUri(site_url('account/oauth_2_callback'));
        $this->client->setClientId('344521802900-on1c8d8vb6albiofom9bv6il5ojd5cvd.apps.googleusercontent.com');
        $this->client->setClientSecret('buVewnz8anMzt6WUX7LN9eh_');
        //Authenticate scopes
        $this->client->addScope(\Google_Service_Calendar::CALENDAR);
        if ($this->getAccessToken()) {
            $accessToken = $this->getAccessToken();
            if (isset($accessToken['error'])) {
                $this->disconnect();
            } else {
                $this->client->setAccessToken($accessToken);
                if ($this->client->isAccessTokenExpired()) {
                    $this->regenerateToken();
                }
            }
        }
        return $this->client;
    }

    public function regenerateToken()
    {
        $accessToken = $this->client->refreshToken($this->refresh_token);
        $this->oauth_data->access_token = json_encode($accessToken);
        $this->saveOauthData();
    }

    public function getTokens()
    {
        $this->initOauthData();
        if ($this->oauth_data->access_token) {
            $this->access_token = json_decode($this->oauth_data->access_token, true);
        }
        if ($this->oauth_data->refresh_token) {
            $this->refresh_token = $this->oauth_data->refresh_token;
        }
    }

    public function getAccessToken()
    {
        return (is_array($this->access_token)) ? array_merge($this->access_token, ['refresh_token' => $this->refresh_token]) : null;
    }

    public function saveOauthData()
    {
        $data = (array)$this->oauth_data;
        $this->update('google_auth_data', 'id', $this->oauth_data->id, $data);
        $this->initOauthData();
    }

    public function getOauthDataFromDb()
    {
        return ($this->account) ? $this->getSingleResult("select * from google_auth_data where account={$this->account->accountId}") : null;
    }

    public function initOauthData()
    {
        if ($this->oauth_data === null) {
            $this->oauth_data = $this->getOauthDataFromDb();
            if (!$this->oauth_data) {
                $this->insert('google_auth_data', [
                    'account' => $this->account->accountId
                ]);
                $this->oauth_data = $this->getOauthDataFromDb();
            }
        }
        return $this->oauth_data;
    }

    /**
     * Use this instead of $this->client PLEASSE
     * @return \Google_Client
     */
    public function getClient()
    {
        return ($this->client === null) ? $this->initClient() : $this->client;
    }

    /**
     * Sends the user to google to authenticate the requested scopes
     */
    public function createNewAuth()
    {
        $auth_url = $this->getClient()->createAuthUrl();
        header('Location: ' . filter_var($auth_url, FILTER_SANITIZE_URL));
    }

    /**
     * Authenticates the API, gets the access code and refresh code and persists them to the db
     * @param $code
     * @return bool
     */
    public function auth($code)
    {
        $this->oauth_data->access_token = json_encode($this->getClient()->authenticate($code));
        $this->oauth_data->refresh_token = $this->getClient()->getRefreshToken();
        $this->saveOauthData();
        $this->getTokens(); //reinitialize tokens
        return ($this->oauth_data->access_token) ? true : false;
    }

    /**
     * Disconnects the current API from google, revoking the token
     */
    public function disconnect()
    {
        $success = true;
        try {
            $this->getClient()->revokeToken();
        } catch (\Exception $e) {
            $success = false;
        }
        $this->oauth_data->access_token = null;
        $this->oauth_data->refresh_token = null;
        $this->saveOauthData();
        $this->authenticated = false;
        return $success;
    }

    public function initCalendarService()
    {
        $this->calendarService = new \Google_Service_Calendar($this->getClient());
        return $this->calendarService;
    }

    public function getCalendarService()
    {
        return ($this->calendarService !== null) ? $this->calendarService : $this->initCalendarService();
    }

    protected function checkConnection() //do a dummy request to see if we got errors
    {
        try {
            $this->getCalendarService()->calendarList->listCalendarList();
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * Checks the auth and sets the authenticated flag
     */
    private function checkAuth()
    {
        //check if the calendar is connected properly and create the PMS Calendar if it does not exist
        if (($this->access_token && !$this->checkConnection()) || !$this->access_token) {
            $this->disconnect();
            $this->authenticated = false;
        } else {
            $this->authenticated = true;
        }
    }

    public function authenticated()
    {
        return $this->authenticated;
    }

    public function calendarExists($calendarId)
    {
        try {
            $this->getCalendarService()->calendarList->get($calendarId);
        } catch (\Exception $e) {
            return false;
        }
        return true;
    }

    /**
     * @return string calendar ID string from google
     */
    public function createPMSCalendar()
    {
        $calendar = new \Google_Service_Calendar_Calendar();
        $calendar->setSummary('PMS');
        switch ($this->account->timeZone) {
            case 'MST':
                $timezone = 'America/Denver';
                break;
            case 'PST':
                $timezone = 'America/Los_Angeles';
                break;
            case 'CST':
                $timezone = 'America/Chicago';
                break;
            default:
                $timezone = 'America/New_York';
                break;
        }
        $calendar->setTimeZone($timezone);
        $createdCalendar = $this->getCalendarService()->calendars->insert($calendar);
        return $createdCalendar->getId();
    }

    public function sync()
    {
        $googleRepoChris = new Google();
        $googleRepoChris->setAccount(285);
        $googleRepoAndy = new Google();
        $googleRepoAndy->setAccount(911);
        ?>
        <h3>Testing Library with multiple Users</h3>
        <p>User 285 (Chris) - Authenticated? <?= ($googleRepoChris->authenticated()) ? 'Yes' : 'No' ?> <?= $googleRepoChris->account->accountId ?></p>
        <p>User 911 (Andy) - Authenticated?  <?= ($googleRepoAndy->authenticated()) ? 'Yes' : 'No' ?> <?= $googleRepoAndy->account->accountId ?></p>
        <h3>Users with connected calendars:</h3>
        <p><?= $this->scalar('select count(account) as counter from google_auth_data where access_token is not null and pms_calendar_id is not null', 'counter') ?></p>
        <h3>Events to sync:</h3>
        <p>34</p>
        <h3>Events to delete</h3>
        <p>0</p>
        <?php
    }


    /**
     * @param $event
     * @return string event ID string from google
     */
    public function syncEvent($event, $google_event_id)
    {

    }

    public function deleteEvent($event)
    {

    }


}