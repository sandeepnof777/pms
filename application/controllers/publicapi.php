<?php

use \models\EstimationLineItem;
use \Carbon\Carbon;

class PublicApi extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
    }

    /**
     * @param array $response
     */
    private function sendResponse(Array $response)
    {
        echo json_encode($response);
    }

    /** Email bounce notifications */
    public function bounce()
    {
        // Get the raw input of the request
        $input = file_get_contents("php://input");
        // Decode the JSON, this will give us an array of events
        $events = json_decode($input);

        if ($events) {
            // We now have an array of event objects
            foreach ($events as $event) {
                // If it's a proposal email
                if (isset($event->proposal)) {
                    $proposal = $this->em->findProposal($event->proposal);

                    switch ($event->event) {
                        // Bounce and drop
                        case 'bounce':
                        case 'dropped':
                            $content = '<p>The Proposal email to "' . $event->email . '" was not delivered.</p>
                                         <p>The reason given by the mail server was: ' . $event->reason . '</p>
                                         <p><a href="' . site_url('dashboard') . '">Click Here</a> to return
                                          to '.SITE_NAME.' and resend your proposal with correct information.
                                         <p><strong>Thank You!</strong><p>
                                         <p>'.SITE_NAME.' Team</p>';

                            $emailData = [
                                'to' => $proposal->getOwner()->getEmail(),
                                'fromName' => SITE_NAME,
                                'fromEmail' => 'no-reply@' . SITE_EMAIL_DOMAIN,
                                'subject' => 'Undelivered Proposal Email: ' . $proposal->getProjectName(),
                                'body' => $content,
                                'categories' => ['Bounce Notification'],
                            ];

                            $this->getEmailRepository()->send($emailData);

                            if (isset($event->resend_email_id)) {
                                $resendEmail = $this->em->find(
                                    'models\ProposalGroupResendEmail',
                                    $event->resend_email_id
                                );

                                if ($resendEmail) {
                                    $resendEmail->setBouncedAt(Carbon::now());
                                    $this->em->persist($resendEmail);
                                    $this->em->flush();
                                }
                            }

                            // Delivery time is no longer reset so have to reset it here
                            $proposal->setDeliveryTime(null);
                            $this->em->persist($proposal);
                            $this->em->flush();

                            // Log the bounce
                            $this->log_manager->add(
                                \models\ActivityAction::PROPOSAL_EMAIL_BOUNCED,
                                'Undelivered Proposal Email: ' . $event->email,
                                $proposal->getClient(),
                                $proposal
                            );
                            break;

                        // Delivery
                        case 'delivered':

                            // Only notify for loaded proposals and 'Proposal' email category
                            if ($proposal && in_array('Proposal', $event->category)) {
                                // Update the delivery time

                                $proposal->setDeliveryTime(time());

                                $this->em->persist($proposal);
                                $this->em->flush();
                                // Log the delivery
                                $this->log_manager->add(\models\ActivityAction::PROPOSAL_EMAIL_DELIVERED,
                                    "Email to '" . $event->email . "' delivered",
                                    $proposal->getClient(),
                                    $proposal);
                            }

                            // Update delivery on proposal resends
                            if(isset($event->resend_email_id)){
                                $resendEmail = $this->em->find('models\ProposalGroupResendEmail',$event->resend_email_id);

                                if ($resendEmail) {
                                    $resendEmail->setDeliveredAt(Carbon::now());
                                    $resendEmail->setBouncedAt(null);
                                    $this->em->persist($resendEmail);
                                    $this->em->flush();
                                }
                            }

                            // Update delivery on proposal automatic resends
                            if(isset($event->automatic_resend_id)){
                                $automaticResend = $this->em->find('models\ProposalAutomaticResend',$event->automatic_resend_id);

                                if ($automaticResend) {
                                    $automaticResend->setDeliveredAt(Carbon::now());
                                    //$automaticResend->setBouncedAt(null);
                                    $this->em->persist($automaticResend);
                                    $this->em->flush();
                                }
                            }
                            

                            break;

                        // Click
                        case "click":
                            if(isset($event->resend_email_id)){
                                $resendEmail = $this->em->find('models\ProposalGroupResendEmail',$event->resend_email_id);

                                // Update when this was clicked if it wasn't clicked before
                                if ($resendEmail) {

                                    if (!$resendEmail->getClickedAt()) {
                                        $timeDiff = 999;
                                        //check clicked after 10 sec of delivered
                                        if($resendEmail->getDeliveredAt()){
                                            $carbonObject =  Carbon::parse($resendEmail->getDeliveredAt()->format('Y-m-d H:i:s'));
                                            $timeDiff = $carbonObject->diffInSeconds(Carbon::now());
                                        }

                                        if($timeDiff >5){
                                            $resendEmail->setClickedAt(Carbon::now());
                                            if (!$resendEmail->getOpenedAt()) {
                                                $resendEmail->setOpenedAt(Carbon::now());
                                            }
                                            $this->em->persist($resendEmail);
                                            $this->em->flush();
                                        }
                                    }
                                }
                            }


                            if(isset($event->automatic_resend_id)){
                                $automaticResend = $this->em->find('models\ProposalAutomaticResend',$event->automatic_resend_id);

                                // Update when this was clicked if it wasn't clicked before
                                if ($automaticResend) {

                                    if (!$automaticResend->getClickedAt()) {
                                        $timeDiff = 999;
                                        //check clicked after 10 sec of delivered
                                        if($automaticResend->getDeliveredAt()){
                                            $carbonObject =  Carbon::parse($automaticResend->getDeliveredAt()->format('Y-m-d H:i:s'));
                                            $timeDiff = $carbonObject->diffInSeconds(Carbon::now());
                                        }

                                        if($timeDiff >5){
                                            $automaticResend->setClickedAt(Carbon::now());
                                            if (!$automaticResend->getOpenedAt()) {
                                                $automaticResend->setOpenedAt(Carbon::now());
                                            }
                                            $this->em->persist($automaticResend);
                                            $this->em->flush();
                                        }
                                    }
                                }
                            }



                            break;
                        case "open":
                            if(isset($event->resend_email_id)){
                                $resendEmail = $this->em->find('models\ProposalGroupResendEmail',$event->resend_email_id);
                                $timeDiff = 999;
                                //check clicked after 5 sec of delivered
                                if($resendEmail->getDeliveredAt()){
                                    $carbonObject =  Carbon::parse($resendEmail->getDeliveredAt()->format('Y-m-d H:i:s'));
                                    $timeDiff = $carbonObject->diffInSeconds(Carbon::now());
                                }

                                if($timeDiff >5){
                                    // Update opened at
                                    $resendEmail->setOpenedAt(Carbon::now());
                                    $this->em->persist($resendEmail);
                                    $this->em->flush();
                                }
                            }

                            if(isset($event->automatic_resend_id)){
                                $automaticResend = $this->em->find('models\ProposalAutomaticResend',$event->automatic_resend_id);
                                $timeDiff = 999;
                                //check clicked after 5 sec of delivered
                                if($automaticResend->getDeliveredAt()){
                                    $carbonObject =  Carbon::parse($automaticResend->getDeliveredAt()->format('Y-m-d H:i:s'));
                                    $timeDiff = $carbonObject->diffInSeconds(Carbon::now());
                                }

                                if($timeDiff >5){
                                    // Update opened at
                                    $automaticResend->setOpenedAt(Carbon::now());
                                    $this->em->persist($automaticResend);
                                    $this->em->flush();
                                }
                            }
                            break;
                        default:
                               
                            break;
                    }
                }

                // Update delivery on client resends
                if(isset($event->client_resend_email_id)){

                    $resendEmail = $this->em->find('models\ClientGroupResendEmail',$event->client_resend_email_id);
                    if ($resendEmail) {

                        switch($event->event) {

                            case "bounce":
                            case "dropped":
                                // Update bounced at
                                $resendEmail->setBouncedAt(Carbon::now());
                                $this->em->persist($resendEmail);
                                $this->em->flush();
                                break;

                            case 'delivered':
                                // Update delivery on client resends
                                if ($resendEmail) {
                                    $resendEmail->setDeliveredAt(Carbon::now());
                                    $resendEmail->setBouncedAt(null);
                                    $this->em->persist($resendEmail);
                                    $this->em->flush();
                                }
                                break;

                            // Click
                            case "click":

                                if ($resendEmail) {
                                    $timeDiff = 999;
                                    //check clicked after 5 sec of delivered
                                    if($resendEmail->getDeliveredAt()){
                                        $carbonObject =  Carbon::parse($resendEmail->getDeliveredAt()->format('Y-m-d H:i:s'));
                                        $timeDiff = $carbonObject->diffInSeconds(Carbon::now());
                                    }

                                    if($timeDiff >5){
                                        // Update when this was clicked if it wasn't clicked before
                                        $resendEmail->setClickedAt(Carbon::now());
                                        if (!$resendEmail->getOpenedAt()) {
                                            $resendEmail->setOpenedAt(Carbon::now());
                                        }
                                        $this->em->persist($resendEmail);
                                        $this->em->flush();
                                    }
                                }

                                break;

                            case "open":
                                $timeDiff = 999;
                                //check opened after 5 sec of delivered
                                if($resendEmail->getDeliveredAt()){
                                    $carbonObject =  Carbon::parse($resendEmail->getDeliveredAt()->format('Y-m-d H:i:s'));
                                    $timeDiff = $carbonObject->diffInSeconds(Carbon::now());
                                }

                                if($timeDiff >5){
                                    // Update opened at
                                    $resendEmail->setOpenedAt(Carbon::now());
                                    $this->em->persist($resendEmail);
                                    $this->em->flush();
                                }
                                break;
                        }
                    }
                }

                // Update delivery on lead resends
                if(isset($event->lead_resend_email_id)){

                    $resendEmail = $this->em->find('models\LeadGroupResendEmail',$event->lead_resend_email_id);
                    if ($resendEmail) {

                        switch($event->event) {

                            case "bounce":
                            case "dropped":
                                // Update bounced at
                                $resendEmail->setBouncedAt(Carbon::now());
                                $this->em->persist($resendEmail);
                                $this->em->flush();
                                break;

                            case 'delivered':
                                // Update delivery on client resends
                                if ($resendEmail) {
                                    $resendEmail->setDeliveredAt(Carbon::now());
                                    $resendEmail->setBouncedAt(null);
                                    $this->em->persist($resendEmail);
                                    $this->em->flush();
                                }
                                break;
                            case "click":

                                if ($resendEmail) {
                                    $timeDiff = 999;
                                    //check Click after 5 sec of delivered
                                    if($resendEmail->getDeliveredAt()){
                                        $carbonObject =  Carbon::parse($resendEmail->getDeliveredAt()->format('Y-m-d H:i:s'));
                                        $timeDiff = $carbonObject->diffInSeconds(Carbon::now());
                                    }

                                    if($timeDiff >5){
                                        // Update when this was clicked if it wasn't clicked before
                                        $resendEmail->setClickedAt(Carbon::now());
                                        if (!$resendEmail->getOpenedAt()) {
                                            $resendEmail->setOpenedAt(Carbon::now());
                                        }
                                        $this->em->persist($resendEmail);
                                        $this->em->flush();
                                    }
                                }

                                break;
                            case "open":
                                $timeDiff = 999;
                                //check opened after 5 sec of delivered
                                if($resendEmail->getDeliveredAt()){
                                    $carbonObject =  Carbon::parse($resendEmail->getDeliveredAt()->format('Y-m-d H:i:s'));
                                    $timeDiff = $carbonObject->diffInSeconds(Carbon::now());
                                }

                                if($timeDiff >5){
                                    // Update opened at
                                    $resendEmail->setOpenedAt(Carbon::now());
                                    $this->em->persist($resendEmail);
                                    $this->em->flush();
                                }
                                break;
                        }
                    }
                }

                // Update delivery on prospect resends
                if(isset($event->prospect_resend_email_id)){

                    $resendEmail = $this->em->find('models\ProspectGroupResendEmail',$event->prospect_resend_email_id);
                    if ($resendEmail) {

                        switch($event->event) {

                            case "bounce":
                            case "dropped":
                                // Update bounced at
                                $resendEmail->setBouncedAt(Carbon::now());
                                $this->em->persist($resendEmail);
                                $this->em->flush();
                                break;

                            case 'delivered':
                                // Update delivery on client resends
                                if ($resendEmail) {
                                    $resendEmail->setDeliveredAt(Carbon::now());
                                    $resendEmail->setBouncedAt(null);
                                    $this->em->persist($resendEmail);
                                    $this->em->flush();
                                }
                                break;
                            case "click":
                                // Update when this was clicked if it wasn't clicked before
                                if ($resendEmail) {
                                    $timeDiff = 999;
                                    //check Click after 5 sec of delivered
                                    if($resendEmail->getDeliveredAt()){
                                        $carbonObject =  Carbon::parse($resendEmail->getDeliveredAt()->format('Y-m-d H:i:s'));
                                        $timeDiff = $carbonObject->diffInSeconds(Carbon::now());
                                    }

                                    if($timeDiff >5){

                                        $resendEmail->setClickedAt(Carbon::now());
                                        if (!$resendEmail->getOpenedAt()) {
                                            $resendEmail->setOpenedAt(Carbon::now());
                                        }
                                        $this->em->persist($resendEmail);
                                        $this->em->flush();
                                    }
                                }

                                break;
                            case "open":
                                $timeDiff = 999;
                                //check Open after 5 sec of delivered
                                if($resendEmail->getDeliveredAt()){
                                    $carbonObject =  Carbon::parse($resendEmail->getDeliveredAt()->format('Y-m-d H:i:s'));
                                    $timeDiff = $carbonObject->diffInSeconds(Carbon::now());
                                }

                                if($timeDiff >5){
                                    // Update opened at
                                    $resendEmail->setOpenedAt(Carbon::now());
                                    $this->em->persist($resendEmail);
                                    $this->em->flush();
                                }
                                break;
                        }
                    }
                }

                // Update delivery on admin resends
                if(isset($event->admin_group_resend_id)){

                    $resendEmail = $this->em->find('models\AdminGroupResendEmail',$event->admin_group_resend_id);
                    if ($resendEmail) {

                        switch($event->event) {

                            case "bounce":
                            case "dropped":
                                // Update bounced at
                                $resendEmail->setBouncedAt(Carbon::now());
                                $this->em->persist($resendEmail);
                                $this->em->flush();
                                break;

                            case 'delivered':
                                // Update delivery on client resends
                                if ($resendEmail) {
                                    $resendEmail->setDeliveredAt(Carbon::now());
                                    $resendEmail->setBouncedAt(null);
                                    $this->em->persist($resendEmail);
                                    $this->em->flush();
                                }
                                break;
                            case "click":
                                if ($resendEmail) {
                                    $timeDiff = 999;
                                    //check Click after 5 sec of delivered
                                    if($resendEmail->getDeliveredAt()){
                                        $carbonObject =  Carbon::parse($resendEmail->getDeliveredAt()->format('Y-m-d H:i:s'));
                                        $timeDiff = $carbonObject->diffInSeconds(Carbon::now());
                                    }

                                    if($timeDiff >5){
                                        // Update Clicked at
                                        $resendEmail->setClickedAt(Carbon::now());
                                        if (!$resendEmail->getOpenedAt()) {
                                            $resendEmail->setOpenedAt(Carbon::now());
                                        }
                                        $this->em->persist($resendEmail);
                                        $this->em->flush();
                                    }
                                }
                                break;
                            case "open":
                                if ($resendEmail) {
                                    $timeDiff = 999;
                                    //check Open after 5 sec of delivered
                                    if($resendEmail->getDeliveredAt()){
                                        $carbonObject =  Carbon::parse($resendEmail->getDeliveredAt()->format('Y-m-d H:i:s'));
                                        $timeDiff = $carbonObject->diffInSeconds(Carbon::now());
                                    }

                                    if($timeDiff >5){
                                        // Update opened at
                                        $resendEmail->setOpenedAt(Carbon::now());
                                        $this->em->persist($resendEmail);
                                        $this->em->flush();
                                    }
                                }
                                break;
                        }
                    }
                }

                // If it's a lead email
                if (isset($event->lead)) {

                    $lead = $this->em->findLead($event->lead);

                    switch ($event->event) {

                        case 'delivered':

                            if ($lead) {
                                // Log the delivery
                                $this->log_manager->add(\models\ActivityAction::LEAD_EMAIL_DELIVERED,
                                    "Lead Email to '" . $event->email . "' delivered");

                                $this->getLogRepository()->add([
                                    'action' => 'lead_email',
                                    'details' => 'Lead Email' . ($lead->getProjectName() ? ' for ' . $lead->getProjectName() : '') .
                                        ' sent to ' . $event->email . ' delivered',
                                    'company' => $lead->getCompany(),
                                    'account' => $lead->getAccount()
                                ]);
                            }
                            break;

                        default:
                            break;
                    }
                }

                // Update an event
                if (isset($event->email_event)) {
                    $proposalEvent = $this->em->find('models\ProposalEvent', $event->email_event);

                    if ($proposalEvent) {

                        switch ($event->event) {

                            case 'delivered':

                                $proposalEvent->setDeliveredAt(Carbon::now());
                                $this->em->persist($proposalEvent);
                                $this->em->flush();

                                break;

                            case "open":
                                // Update opened at
                                $proposalEvent->setOpenedAt(Carbon::now());
                                $this->em->persist($proposalEvent);
                                $this->em->flush();
                                break;

                            case "bounce":
                                // Update opened at
                                $proposalEvent->setBouncedAt(Carbon::now());
                                $this->em->persist($proposalEvent);
                                $this->em->flush();
                                break;

                            default:
                                break;
                        }

                    }
                }

                // Actions based on categories
                if (isset($event->category)) {

                    // Send a notification for admin emails
                    if (in_array('Global Admin Mail', $event->category)) {

                        switch ($event->event) {

                            case 'bounce':
                            case 'dropped':

                                $company = isset($event->company) ? $event->company : 'Not specified';
                                $user = isset($event->user) ? $event->user : 'Not specified';

                                $content = "<p>An admin email to '" . $event->email . "' was not delivered</p>
                                        <p>The reason given was: " . $event->reason . "</p>
                                        <p>Company: " . $company . "</p>
                                        <p>User: " . $user . "</p>";

                                $emailData = [
                                    'to' => 'support@' . SITE_EMAIL_DOMAIN,
                                    'fromName' => SITE_NAME,
                                    'fromEmail' => 'no-reply@' . SITE_EMAIL_DOMAIN,
                                    'subject' => 'Undelivered Admin Email',
                                    'body' => $content,
                                    'categories' => [' AdminBounce Notification'],
                                ];

                                $this->getEmailRepository()->send($emailData);

                                break;
                        }
                    }
                }
            }
        }
    }

    /**
     *  Return an array of estimating categories
     */
    public function getEstimatingCategories()
    {
        $response = [];
        $out = [];
        $categories = $this->getEstimationRepository()->getAdminCategories();

        foreach ($categories as $category) {
            $out[] = [
                'id' => $category->getId(),
                'name' => $category->getName()
            ];
        }

        $response['data'] = $out;

        echo json_encode($response);
    }

    /**
     * @param $categoryId
     * @description Returns an array of all of the types belonging to a category
     */
    public function getEstimatingCategoryTypes($categoryId)
    {
        $response = [];
        $out = [];

        $category = $this->em->findEstimationCategory($categoryId);

        if (!$category) {
            $response['error'] = 1;
            $response['message'] = 'Could not load category';
            $this->sendResponse($response);
            return;
        }

        $types = $this->getEstimationRepository()->getAdminCategoryTypes($category);

        foreach ($types as $type) {
            $out[] = [
                'id' => $type->getId(),
                'name' => $type->getName()
            ];
        }

        $response['data'] = $out;

        $this->sendResponse($response);
    }

    public function getEstimatingTypeItems($typeId)
    {
        $response = [];
        $out = [];

        $type = $this->em->findEstimationType($typeId);

        if (!$type) {
            $response['error'] = 1;
            $response['message'] = 'Could not load type';
            $this->sendResponse($response);
            return;
        }

        $items = $this->getEstimationRepository()->getAdminTypeItems($type);

        foreach ($items as $item) {
            /* @var \models\EstimationItem $item */
            $out[] = [
                'id' => $item->getId(),
                'name' => $item->getName(),
                'price' => $item->getUnitPrice(),
                'taxable' => $item->getTaxable(),
                'tax_rate' => $item->getTaxRate(),
                'unit_type_id' => $item->getUnitModel()->getUnitType(),
                'unit_name' => $item->getUnitModel()->getName()
            ];
        }

        $response['data'] = $out;

        $this->sendResponse($response);
    }

    public function getEstimatingUnitTypes()
    {
        $response = [];
        $out = [];
        $unitTypes = $this->getEstimationRepository()->getUnitTypes();

        foreach ($unitTypes as $unitType) {
            $out[] = [
                'id' => $unitType->getId(),
                'name' => $unitType->getName()
            ];
        }

        $response['data'] = $out;

        echo json_encode($response);
    }


    public function getEstimatingUnitTypeUnits($unitTypeId)
    {
        $response = [];
        $out = [];

        $unitType = $this->em->findEstimationUnitType($unitTypeId);

        if (!$unitType) {
            $response['error'] = 1;
            $response['message'] = 'Could not load unit type';
            $this->sendResponse($response);
            return;
        }

        $units = $this->getEstimationRepository()->getTypeUnits($unitType);

        foreach ($units as $unit) {
            /* @var $unit \models\EstimationUnit */
            $out[] = [
                'id' => $unit->getId(),
                'name' => $unit->getName(),
                'abbr' => $unit->getAbbr()
            ];
        }

        $response['data'] = $out;

        $this->sendResponse($response);
    }

}