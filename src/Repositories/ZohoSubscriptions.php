<?php
namespace Pms\Repositories;

use Carbon\Carbon;
use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;
use \Zoho\Subscription\Api\Customer;
use Zoho\Subscription\Api\Invoice;
use \Zoho\Subscription\Api\Plan;
use \Zoho\Subscription\Api\Addon;
use Zoho\Subscription\Api\Subscription;
use \models\ZohoSubscription;


class ZohoSubscriptions extends RepositoryAbstract
{
    use DBTrait;

    var $cache;
    var $client;

    var $planClient;
    var $addonClient;
    var $customerClient;
    var $subClient;
    var $invoiceClient;

    public function __construct()
    {
        parent::__construct();
        $this->cache = new \Doctrine\Common\Cache\ArrayCache();
        $this->planClient = new Plan(ZS_AUTH_TOKEN, ZS_ORG_ID, $this->cache);
        $this->addonClient = new Addon(ZS_AUTH_TOKEN, ZS_ORG_ID, $this->cache);
        $this->customerClient = new Customer(ZS_AUTH_TOKEN, ZS_ORG_ID, $this->cache);
        $this->subClient = new Subscription(ZS_AUTH_TOKEN, ZS_ORG_ID, $this->cache);
        $this->invoiceClient = new Invoice(ZS_AUTH_TOKEN, ZS_ORG_ID, $this->cache);
    }

    /**
     * @return array
     */
    public function getActivationPlan()
    {
        return $this->planClient->getPlan(ZS_ACTIVATION_PLAN_ID);
    }

    /**
     * @return array
     */
    public function getUserAddon()
    {
        return $this->addonClient->getAddon(ZS_USER_ADDON_ID);
    }

    /**
     * @return array
     */
    public function getWioAddon()
    {
        return $this->addonClient->getAddon(ZS_WIO_ADDON_ID);
    }

    /**
     * @param array $customerData
     * @return array|bool
     */
    public function createCustomer(array $customerData)
    {
        return $this->customerClient->createCustomer($customerData);
    }

    /**
     * @param $customerId
     * @return array
     */
    public function getCustomerById($customerId)
    {
        return $this->customerClient->getCustomerById($customerId);
    }

    /**
     * @param array $subscriptionData
     * @return string
     */
    public function addSubscriptionToCustomer(array $subscriptionData)
    {
        $subscription = $this->subClient->createSubscription($subscriptionData);
        return $subscription;
    }

    /**
     * @param $subscriptionId
     * @return array
     */
    public function getSubscription($subscriptionId)
    {
        $subscription = $this->subClient->getSubscription($subscriptionId);
        return $subscription;
    }

    /**
     * @param $subscriptionId
     * @param array $subscriptionData
     * @return string
     */
    public function editSubscription($subscriptionId, array $subscriptionData)
    {
        $subscription = $this->subClient->editSubscription($subscriptionId, $subscriptionData);
        return $subscription;
    }

    /**
     * @param ZohoSubscription $subscription
     */
    public function updateAccountsFromSubscription(ZohoSubscription $subscription)
    {
        // Convert the ref into account Ids
        $accountIds = explode('/', $subscription->getRef());

        foreach ($accountIds as $accountId) {
            $account = $this->em->findAccount($accountId);
            // If the account loads, update expiry
            if ($account) {
                // Get the account expiry
                $expiry = Carbon::createFromTimestamp($account->getExpires());
                // Add a year
                $expiry->addYear(1);
                // Set the user expiry
                $account->setExpires($expiry->timestamp);
                $this->em->persist($account);
            }
        }
        $this->em->flush();
    }

    /**
     * @param $subscriptionId
     */
    public function cancelSubscription($subscriptionId)
    {
        // First, void any invoices for this subscription
        $this->voidSubscriptionInvoices($subscriptionId);
        // Now cancel the subscription itself
        try {
            $this->subClient->cancelSubscription($subscriptionId);
        }
        catch (\Exception $e) {}
    }

    /**
     * @param $subscriptionId
     */
    public function voidSubscriptionInvoices($subscriptionId)
    {
        $invoices = $this->invoiceClient->listInvoicesBySubscription($subscriptionId);

        foreach ($invoices as $invoice) {
            $invoiceId =  $invoice['invoice_id'];
            try {
                $this->invoiceClient->voidInvoice($invoiceId);
            }
            catch(\Exception $e) {}
        }
    }



}