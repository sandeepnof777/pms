<?php

use Carbon\Carbon;

class Zoho extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    function updateSubscription()
    {
        $zsr = $this->getZohoSubscriptionsRepository();

        // Get the request and parse into object
        $requestBody = file_get_contents('php://input');
        $data = json_decode($requestBody);

        // Get the subscription ID
        $subscriptionId = $data->data->subscription->subscription_id;
        $nextBilling = $data->data->subscription->next_billing_at;
        // Expiry date object, set to end of day of expiry
        $expiryDate = Carbon::createFromFormat('Y-m-d', $nextBilling)->endOfDay();

        // Process if we have a subscription ID
        if ($subscriptionId) {

            // Check we have an event type
            if ($data->event_type) {

                // Proceed based on event type
                switch ($data->event_type) {

                    // These are the only events from Zoho subscriptions that we are going to handle
                    case 'subscription_activated':
                    case 'subscription_renewed':

                        // Load the subscription
                        $zs = $this->em->find('models\ZohoSubscription', $subscriptionId);

                        if ($zs) {

                            /* @var $zs models\ZohoSubscription */
                            $zs->setExpiry($expiryDate);
                            // Update our record and then update the accounts
                            $this->em->persist($zs);
                            $this->em->flush();
                            $zsr->updateAccountsFromSubscription($zs);
                        }
                        break;
                }
            }
        }
    }



}