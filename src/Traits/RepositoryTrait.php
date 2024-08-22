<?php
namespace Pms\Traits;

use Pms\Repositories\AnnouncementRepository;
use Pms\Repositories\Client;
use Pms\Repositories\Company;
use Pms\Repositories\DashboardStats;
use Pms\Repositories\EmailQueue;
use Pms\Repositories\EstimationRepository;
use Pms\Repositories\EventRepository;
use Pms\Repositories\Event;
use Pms\Repositories\Google;
use Pms\Repositories\GoogleAuth;
use Pms\Repositories\Log;
use Pms\Repositories\Lead;
use Pms\Repositories\Account;
use Pms\Repositories\Email;
use Pms\Repositories\LeadNotifications;
use Pms\Repositories\Proposal;
use Pms\Repositories\ProposalNotifications;
use Pms\Repositories\Prospect;
use Pms\Repositories\QueryCache;
use Pms\Repositories\QuickbooksDesktop;
use Pms\Repositories\SalesTargets;
use Pms\Repositories\SendgridRepository;
use Pms\Repositories\ZohoSubscriptions;
use Pms\Repositories\Quickbooks;

/**
 * Provides getters for all repositories.
 * Class RepositoryTrait
 * @package Pms\Traits
 */
trait RepositoryTrait
{

    /** @var  Email */
    var $emailRepository = null;

    /** @var Account */
    var $accountRepository = null;

    /** @var Account */
    var $leadRepository = null;

    /** @var Log */
    var $logRepository = null;

    /** @var LeadNotifications */
    var $leadNotificationsRepository = null;

    /** @var DashboardStats */
    var $dashboardStatsRepository = null;

    /** @var Event */
    var $eventRepository = null;

    /** @var EventRepository */
    var $proposalEventRepository = null;

    /** @var EmailQueue */
    var $emailQueueRepository = null;

    /** @var Proposal */
    var $proposalRepository = null;

    /** @var Client */
    var $clientRepository = null;

    /** @var Prospect */
    var $prospectRepository = null;

    /** @var Google */
    var $googleRepository = null;

    var $googleAuthRepositories = [];

    /** @var ProposalNotifications */
    var $proposalNotificationsRepository = null;

    /** @var ProposalNotifications */
    var $salesTargetsRepository = null;

    /* @var Company */
    var $companyRepository;

    /* @var Company */
    var $queryCacheRepository;

    /* @var Zoho Subscriptions */
    var $zohoSubscriptionRepository = null;

    /* @var Quickbooks */
    var $quickbooksRepository;

    /* @var QuickbooksDesktop */
    var $qbdRepository;

    /* @var SendgridRepository */
    var $sendgridRepository;

    /* @var AnnouncementRepository */
    var $announcementRepository;

    /* @var EstimationRepository */
    var $estimationRepository;

    /**
     * Getter for the Email Repository
     * @return Email
     */
    public function getEmailRepository()
    {
        if ($this->emailRepository === null) {
            $this->emailRepository = new Email();
        }
        return $this->emailRepository;
    }

    /**
     * Getter for the account repository
     * @return Account
     */
    public function getAccountRepository()
    {
        if ($this->accountRepository === null) {
            $this->accountRepository = new Account();
        }
        return $this->accountRepository;
    }

    /**
     * Getter for the Lead Repository
     * @return Lead
     */
    public function getLeadRepository()
    {
        if ($this->leadRepository === null) {
            $this->leadRepository = new Lead();
        }
        return $this->leadRepository;
    }

    /**
     * Getter for the Lead Repository
     * @return Log
     */
    public function getLogRepository()
    {
        if ($this->logRepository === null) {
            $this->logRepository = new Log();
        }
        return $this->logRepository;
    }

    /**
     * Getter for the DashboardStats Repository
     * @return DashboardStats
     */
    public function getDashboardStatsRepository()
    {
        if ($this->dashboardStatsRepository === null) {
            $this->dashboardStatsRepository = new DashboardStats();
        }
        return $this->dashboardStatsRepository;
    }

    /**
     * Getter for the LeadNotifications Repository
     * @return LeadNotifications
     */
    public function getLeadNotificationsRepository()
    {
        if ($this->leadNotificationsRepository === null) {
            $this->leadNotificationsRepository = new LeadNotifications();
        }
        return $this->leadNotificationsRepository;
    }

    /**
     * Getter for the Event Repository
     * @return Event Repository
     */
    public function getEventRepository()
    {
        if ($this->eventRepository === null) {
            $this->eventRepository = new Event();
        }
        return $this->eventRepository;
    }

    /**
     * Getter for the Email Queue Repository
     * @return EmailQueue Repository
     */
    public function getEmailQueueRepository()
    {
        if ($this->emailQueueRepository === null) {
            $this->emailQueueRepository = new EmailQueue();
        }
        return $this->emailQueueRepository;
    }

    /**
     * Getter for the Proposal Repository
     * @return Proposal Repository
     */
    public function getProposalRepository()
    {
        if ($this->proposalRepository === null) {
            $this->proposalRepository = new Proposal();
        }
        return $this->proposalRepository;
    }

    /**
     * Getter for the Client Repository
     * @return Client Repository
     */
    public function getClientRepository()
    {
        if ($this->clientRepository === null) {
            $this->clientRepository = new Client();
        }
        return $this->clientRepository;
    }

    /**
     * Getter for the Client Repository
     * @return Prospect Repository
     */
    public function getProspectRepository()
    {
        if ($this->prospectRepository === null) {
            $this->prospectRepository = new Prospect();
        }
        return $this->prospectRepository;
    }

    /**
     * Getter for the Google Repository
     * @return Google Repository
     */
    public function getGoogleRepository()
    {
        if ($this->googleRepository === null) {
            $this->googleRepository = new Google();
        }
        return $this->googleRepository;
    }

    /**
     * @param $accountId
     * @return GoogleAuth
     */
    public function getGoogleAuthRepository($accountId)
    {
        if (!isset($this->googleAuthRepositories[$accountId])) {
            $this->googleAuthRepositories[$accountId] = new GoogleAuth($accountId);
        }
        return $this->googleAuthRepositories[$accountId];
    }

    /**
     * Getter for the Google Repository
     * @return ProposalNotifications Repository
     */
    public function getProposalNotificationsRepository()
    {
        if ($this->proposalNotificationsRepository === null) {
            $this->proposalNotificationsRepository = new ProposalNotifications();
        }
        return $this->proposalNotificationsRepository;
    }

    public function getSalesTargetsRepository()
    {
        if ($this->salesTargetsRepository === null) {
            $this->salesTargetsRepository = new SalesTargets();
        }
        return $this->salesTargetsRepository;
    }

    public function getCompanyRepository()
    {
        if ($this->companyRepository === null) {
            $this->companyRepository = new Company();
        }
        return $this->companyRepository;
    }

    public function getQueryCacheRepository()
    {
        if ($this->queryCacheRepository === null) {
            $this->queryCacheRepository = new QueryCache();
        }
        return $this->queryCacheRepository;
    }

    public function getZohoSubscriptionsRepository()
    {
        if ($this->zohoSubscriptionRepository === null) {
            $this->zohoSubscriptionRepository = new ZohoSubscriptions();
        }
        return $this->zohoSubscriptionRepository;
    }

    public function getQuickbooksRepository()
    {
        if ($this->quickbooksRepository === null) {
            $this->quickbooksRepository = new Quickbooks();
        }
        return $this->quickbooksRepository;
    }

    public function getQbdRepository()
    {
        if ($this->qbdRepository === null) {
            $this->qbdRepository = new QuickbooksDesktop();
        }
        return $this->qbdRepository;
    }


    public function getSendgridRepository()
    {
        if ($this->sendgridRepository === null) {
            $this->sendgridRepository = new SendgridRepository();
        }
        return $this->sendgridRepository;
    }

    public function getAnnouncementRepository()
    {
        if ($this->announcementRepository === null) {
            $this->announcementRepository = new AnnouncementRepository();
        }
        return $this->announcementRepository;
    }

    public function getEstimationRepository()
    {
        if ($this->estimationRepository === null) {
            $this->estimationRepository = new EstimationRepository();
        }
        return $this->estimationRepository;
    }

    public function getProposalEventRepository()
    {
        if ($this->proposalEventRepository === null) {
            $this->proposalEventRepository = new EventRepository();
        }
        return $this->proposalEventRepository;
    }

}