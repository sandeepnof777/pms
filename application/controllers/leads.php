<?php

use Carbon\Carbon;

class Leads extends MY_Controller
{
    function __construct()
    {
        $this->login_restricted = true;
        parent::__construct();
    }

    function index()
    {
        $this->load->model('clientEmail');
        $data = array();
        /*
         * Dashboard filter code
         */
        $data['filter'] = false;
        if ($this->uri->segment(3) == 'filter') {
            //clear old filters if present
            $this->session->set_userdata([
                'lFilter' => '',
                'lFilterUser' => '',
                'lFilterBranch' => '',
                'lFilterSource' => '',
                'lFilterStatus' => '',
                'lFilterAge' => '',
                'lFilterRange' => '',
                'lFilterDateStart' => '',
                'lFilterDateEnd' => '',
            ]);
            //get filter array
            $filter = $this->uri->uri_to_assoc(4);
            $data['filter'] = $filter;
            //set session filter information
            $this->session->set_userdata('lFilter', 1);
            if (isset($filter['user'])) {
                $this->session->set_userdata('lFilterUser', [$filter['user']]);
            }
            if (isset($filter['source'])) {
                $this->session->set_userdata('lFilterSource', [$filter['source']]);
            }
            if (isset($filter['status'])) {
                if ($filter['status'] == 'All') {
                    $this->session->set_userdata('lFilterStatus', ['Active', 'Converted', 'Cancelled']);
                } else {
                    $this->session->set_userdata('lFilterStatus', [$filter['status']]);
                }
            }
            if (isset($filter['age'])) {
                $this->session->set_userdata('lFilterAge', $filter['age']);
            }
            if (isset($filter['from'])) {
                $filterFrom = Carbon::createFromFormat('m-d-Y', $filter['from'])->timestamp;
                $this->session->set_userdata('lFilterDateStart', $filterFrom);
            }
            if (isset($filter['to'])) {
                $filterFrom = Carbon::createFromFormat('m-d-Y', $filter['to'])->timestamp;
                $this->session->set_userdata('lFilterDateEnd', $filterFrom);
            }

        } else {
            //clear any filters set by dashboard to avoid confusion
            $this->session->set_userdata([
                'lFilterAge' => '',
                'lFilterRange' => ''
            ]);

        }


        //Dashboard filter code END
        $data['leads'] = [];
        $data['account'] = $this->account();
        $data['accounts'] = $this->getCompanyAccounts();
        $data['services'] = $this->account()->getCompany()->getServices();
        $data['ratings'] = $this->leadRatings;
        $data['statuses'] = $this->leadStatuses;
        $data['group'] = $this->uri->segment(2) === 'group';
        $data['clientTemplates'] = $this->clientEmail->getTemplates($this->account()->getCompany()->getCompanyId(),
            \models\ClientEmailTemplateType::LEAD, true);
        $data['auditTemplate'] = $this->em->find('models\Email_templates', 23);
        $this->load->model('branchesapi');
        $data['branches'] = $this->branchesapi->getBranches($this->account()->getCompany()->getCompanyId());
        $data['leadStatuses'] = array('Converted', 'Cancelled');
        $data['dueDates'] = array('Due', 'Overdue');
        $data['leadSources'] = $this->account()->getCompany()->getLeadSources(true);

        $data['resends'] = $this->getLeadRepository()->getCompanyLeadResendList($this->account()->getCompany(), $this->account());
        $data['email_template_fields'] = $this->getLeadRepository()->getLeadTemplateFields();

        $data['leadTypes'] = ['Residential', 'Commercial'];
        $this->html->addScript('ckeditor4');
        $this->html->addScript('dataTables');
        $this->html->addScript('scheduler');
        $this->html->addScript('maps');
        $data['resendId'] = $this->uri->segment(3) ?: '';
        $data['campaignEmailFilter'] = $this->uri->segment(4) ?: '';
        $data['filterResend'] = false;
        $data['show_last_activity'] = 'true';
        $data['show_opened_at'] = 'false';
        $data['businessTypes'] = $this->getCompanyRepository()->getCompanyBusinessTypes($this->account()->getCompany());
        $data['save_filters'] = $this->getLeadRepository()->getLeadSavedFilters($this->account());

        $this->html->addScript('select2');
        if ($this->uri->segment(2) == 'resend') {
            $data['filterResend'] = true;
            $data['show_last_activity'] = 'false';
            $data['show_opened_at'] = 'true';
            $data['resend'] = $this->em->find('models\LeadGroupResend', $data['resendId']);
            if ($data['resend']) {

                $data['resendStats'] = $this->getLeadRepository()->getLeadResendStats($data['resend'], $this->account());
                $data['child_resends'] = $this->getLeadRepository()->getLeadChildResend($data['resendId']);
                //print_r($data['resend']);die;
                $this->load->view('leads/index-resend', $data);
            } else {

                $this->session->set_flashdata('error', 'Campaign Not Found!');
                redirect('leads');
            }

        } else {
            $this->load->view('leads/index', $data);
        }

    }

    function all()
    {
        $this->index();
    }

    function group()
    {
        $this->index();
    }

    function add()
    {
        $additionalText = '';
        //$services = $this->em->createQuery('select s from models\Services s where s.parent=0 order by s.serviceName')->getResult();
        $services = $this->account()->getCompany()->getActiveCategories();
        if ($this->input->post('add')) {
            $lead = new models\Leads();
            $lead->setCompany($this->account()->getCompany()->getCompanyId());
            $lead->setAccount($this->input->post('account'));
            $lead->setAddedByUserId($this->account()->getAccountId());
            $lead->setAddedByUserName($this->account()->getFullName());
            $lead->setStatus($this->input->post('status'));
            if (!$this->input->post('dueDate')) {
                $dueDate = time() + (86400 * 2);
            } else {
                $date = explode('/', $this->input->post('dueDate'));
                $dueDate = mktime(23, 59, 59, $date[0], $date[1], $date[2]);
            }
            $lead->setDueDate($dueDate);
            if ($this->input->post('client')) {
                // Load the client
                $client = $this->em->find('\models\Clients', $this->input->post('client'));
                /* @var $client \models\Clients */

                // Check the name matches, this is to avoid creating duplicate clients
                if ($client->getFirstName() == $this->input->post('firstName')
                    && $client->getLastName() == $this->input->post('lastName')
                ) {

                    // They match, so set the client
                    $lead->setClient($client->getClientId());

                    // Now update the client
                    $client->setCompanyName($this->input->post('companyName'));
                    $client->setTitle($this->input->post('title'));
                    $client->setAddress($this->input->post('address'));
                    $client->setCity($this->input->post('city'));
                    $client->setState($this->input->post('state'));
                    $client->setZip($this->input->post('zip'));
                    $client->setFax($this->input->post('fax'));
                    $client->setBusinessPhone($this->input->post('businessPhone'));
                    $client->setBusinessPhoneExt($this->input->post('businessPhoneExt'));
                    $client->setCellPhone($this->input->post('cellPhone'));
                    $client->setEmail($this->input->post('email'));
                    $client->setWebsite($this->input->post('website'));


                    // Save the details
                    $this->em->persist($client);
                }
            }
            $lead->setRating($this->input->post('rating'));
            $lead->setCompanyName($this->input->post('companyName'));
            $lead->setFirstName($this->input->post('firstName'));
            $lead->setLastName($this->input->post('lastName'));
            $lead->setTitle($this->input->post('title'));
            $lead->setAddress($this->input->post('address'));
            $lead->setCity($this->input->post('city'));
            $lead->setState($this->input->post('state'));
            $lead->setZip($this->input->post('zip'));
            $lead->setFax($this->input->post('fax'));
            $lead->setBusinessPhone($this->input->post('businessPhone'));
            $lead->setBusinessPhoneExt($this->input->post('businessPhoneExt'));
            $lead->setCellPhone($this->input->post('cellPhone'));
            $lead->setEmail($this->input->post('email'));
            $lead->setWebsite($this->input->post('website'));
            $lead->setProjectName($this->input->post('projectName'));
            $lead->setProjectAddress($this->input->post('projectAddress'));
            $lead->setProjectCity($this->input->post('projectCity'));
            $lead->setProjectState($this->input->post('projectState'));
            $lead->setProjectZip($this->input->post('projectZip'));
            $lead->setProjectPhone($this->input->post('projectPhone'));
            $lead->setProjectPhoneExt($this->input->post('projectPhoneExt'));
            $lead->setProjectCellPhone($this->input->post('projectCellPhone'));
            $lead->setProjectContact($this->input->post('projectContact'));
            $lead->setSource($this->input->post('source'));
            $lead->setNotes($this->input->post('notes'));

            $servicesIDS = '';
            $k = 0;
            if (is_array($this->input->post('services'))) {
                foreach ($this->input->post('services') as $service) {
                    $k++;
                    $servicesIDS .= $service;
                    if ($k < count($this->input->post('services'))) {
                        $servicesIDS .= ',';
                    }
                }
            }
            $lead->setServices($servicesIDS);
            $lead->setLastActivity();
            $lead->setLatLng();
            $this->em->persist($lead);
            $this->em->flush();
            $this->getQueryCacheRepository()->deleteCompanyLeadsCountCache($this->account()->getCompanyId());

            $business_type = $this->input->post('business_type');
            $business_type_names = '';
            if ($business_type) {
                $assignment = new models\BusinessTypeAssignment();
                $assignment->setBusinessTypeId($business_type);
                $assignment->setCompanyId($this->account()->getCompany()->getCompanyId());
                $assignment->setLeadId($lead->getLeadId());
                $this->em->persist($assignment);
                $type_details = $this->em->find('models\BusinessType', $business_type);
                $business_type_names = $type_details->getTypeName();
                $this->em->flush();
            }

            //copy prospect notes
            if ($this->input->post('convert_prospect') != '0') {
                // Copy notes
                $prospectNotes = $this->getProspectRepository()->getProspectNotes($this->input->post('convert_prospect'));

                // Copy across individual notes
                if (count($prospectNotes)) {
                    foreach ($prospectNotes as $prospectNote) {
                        /* @var \models\Notes $leadNote */
                        $leadNote = new \models\Notes();
                        $leadNote->setType('lead');
                        $leadNote->setNoteText('[Prospect Note] ' . $prospectNote->noteText);
                        $leadNote->setRelationId($lead->getLeadId());
                        $leadNote->setAdded($prospectNote->added);
                        $leadNote->setUser($prospectNote->user);
                        $this->em->persist($leadNote);
                    }
                    $this->em->flush();
                }
            }

            //add attachments to the newly created lead
            if (is_array($this->input->post('attachmentFiles'))) {
                $fileNames = $this->input->post('attachmentFileNames');
                foreach ($this->input->post('attachmentFiles') as $key => $filePath) {
                    $this->getLeadRepository()->moveTemporaryAttachment($lead->getLeadId(), $fileNames[$key],
                        $filePath);
                }
            }

            $assignedAccount = $this->em->find('models\Accounts', $lead->getAccount());

            // PSA Stuff
            if ($this->input->post('psaAuditCheck') && $assignedAccount) {

                $this->load->library('psa_client', ['account' => $assignedAccount]);

                $apiParams = [
                    'company_name' => $lead->getCompanyName(),
                    'project_name' => $lead->getProjectName(),
                    'address' => $lead->getProjectAddress(),
                    'city' => $lead->getProjectCity(),
                    'state' => $lead->getProjectState(),
                    'zip' => $lead->getProjectZip(),
                    'first_name' => $lead->getFirstName(),
                    'last_name' => $lead->getLastName(),
                    'title' => $lead->getTitle()
                ];

                $responseObj = $this->psa_client->addLocation($apiParams);

                if (!$responseObj->error) {
                    // Location was created, we can proceed
                    $auditParams = [
                        'locationId' => $responseObj->locationId,
                        'auditType' => $this->input->post('auditType'),
                        'leadId' => $lead->getLeadId()
                    ];

                    $auditResponse = $this->psa_client->createAudit($auditParams);

                    if (!$auditResponse->error) {
                        $additionalText = 'Audit created successfully';

                        $lead->setPsaAuditUrl($auditResponse->auditUrl);
                        $lead->setPsaSmsUrl($auditResponse->auditSmsUrl);
                        $this->em->persist($lead);
                        $this->em->flush();
                    } else {
                        $additionalText = "Prosite Audit Error: " . $responseObj->message;
                    }
                } else {
                    $additionalText = "PrositeAudit Location Error: " . $responseObj->message;
                }
            }

            $this->log_manager->add(\models\ActivityAction::ADD_LEAD, 'Added Lead "' . $lead->getProjectName() . '".');

            $this->session->set_flashdata('success', 'Lead Added!' . '<br /><p>' . $additionalText . '</p>');
            $assignedAccount = $this->em->find('models\Accounts', $this->input->post('account'));

            //send email out to the assigned account
            if ($assignedAccount) {
                $mailServices = array();
                foreach ($services as $service) {
                    $k++;
                    if (is_array($this->input->post('services')) && in_array($service->getServiceId(),
                            $this->input->post('services'))
                    ) {
                        $mailServices[] = $service->getServiceName();
                    }
                }
                $mailServices = implode(', ', $mailServices);

                $emailData = array(
                    'first_name' => $assignedAccount->getFirstName(),
                    'last_name' => $assignedAccount->getLastName(),
                    'project_name' => $this->input->post('projectName'),
                    'company_name' => $lead->getCompanyName(),
                    'requested_work' => $mailServices,
                    'contact' => $lead->getFirstName() . ' ' . $lead->getLastName(),
                    'contact_title' => $lead->getTitle(),
                    'phone' => $lead->getBusinessPhone(),
                    'cellPhone' => $lead->getCellPhone(),
                    'address' => $lead->getProjectAddress() . ' ' . $lead->getProjectCity() . ' ' . $lead->getProjectState() . ', ' . $lead->getProjectZip(),
                    'notes' => nl2br($lead->getNotes()),
                    //added extra
                    'projectPhone' => $lead->getProjectPhone(),
                    'projectCellPhone' => $lead->getProjectCellPhone(),
                    'leadAddress' => $lead->getAddress() . ' ' . $lead->getCity() . ' ' . $lead->getState() . ' ' . $lead->getZip(),
                    'projectContact' => $lead->getProjectContact(),
                    'email' => $lead->getEmail(),
                    'auditUrl' => $lead->getPsaAuditUrl(),
                    'auditSmsUrl' => $lead->getPsaSmsUrl(),
                    'business_types' => $business_type_names,
                    //attachments
                    'attachments' => $this->getLeadRepository()->getAttachmentsEmailFormatted($lead->getLeadId()),
                );
                $this->load->model('system_email');


                if (isset($auditResponse)) {
                    if (!$auditResponse->error) {
                        $this->system_email->sendEmail(18, $assignedAccount->getEmail(), $emailData);
                    }
                } else {
                    $this->system_email->sendEmail(5, $assignedAccount->getEmail(), $emailData);
                }
            } else {
                //send instant notification
                $leadNotifications = $this->getLeadNotificationsRepository();
                $leadNotifications->sendUnassignedNotification($this->account()->getCompany()->getCompanyId(),
                    $lead->getLeadId()); //only sends if it is enabled
            }
            redirect('leads');
        }
        $prospect = null;
        $client = null;
        $prospectSource = '';
        $client_id = '';
        $companyName = '';
        $business_type_id = '';

        if ($this->uri->segment(3)) {
            if ($this->uri->segment(3) == 'client') {
                $prospect = $this->em->findClient($this->uri->segment(4));
                $companyName = $prospect->getClientAccount()->getName();
                $client_id = $prospect->getClientId();
            } else {
                $prospect = $this->em->findProspect($this->uri->segment(3));
                if ($prospect) {
                    $prospectSource = $prospect->getProspectSourceText();
                    $companyName = $prospect->getCompanyName();
                    $bTypes = $this->getCompanyRepository()->getCompanyBusinessTypeAssignments($this->account()->getCompany(), 'prospect', $prospect->getProspectId(), true);
                    if (count($bTypes) == 1) {
                        $business_type_id = $bTypes[0];
                    }
                }
            }
        }

        $data = array();
        $data['companyName'] = $companyName;
        $data['prospect'] = $prospect;
        $data['client_id'] = $client_id;
        $data['business_type_id'] = $business_type_id;
        $data['prospectSource'] = $prospectSource;
        $data['users'] = $this->getCompanyAccounts();;
        $data['services'] = $services;
        $data['ratings'] = $this->leadRatings;
        $data['statuses'] = $this->leadStatuses;
        $data['sources'] = $this->account()->getCompany()->getLeadSources();
        $data['account'] = $this->account();
        $data['businessTypes'] = $this->getCompanyRepository()->getCompanyBusinessTypes($this->account()->getCompany());
        $this->html->addScript('select2');
        $this->load->view('leads/add', $data);
    }

    function edit($id)
    {
        $lead = $this->em->findLead($id);
        $services = $this->account()->getCompany()->getActiveCategories();


        $additionalText = '';
        $assignedAccount = null;

        // Flag for reassignment
        $reassigning = false;

        if ($lead) {
            $oldProjectAddressString = $lead->getProjectAddressString();

            $data = array();
            if ($this->input->post('save')) {

                // Check for reassignment
                $newAccount = $this->input->post('account');
                if ($newAccount != $lead->getAccount()) {
                    $reassigning = true;
                }

                $this->getCompanyRepository()->clearLeadAssignedBusinessTypes($this->account()->getCompany(), $lead->getLeadId());
                // Set the object values
                $lead->setCompany($this->account()->getCompany()->getCompanyId());
                $lead->setStatus($this->input->post('status'));
                if (!$this->input->post('dueDate')) {
                    $dueDate = time() + (86400 * 2);
                } else {
                    $date = explode('/', $this->input->post('dueDate'));
                    $dueDate = mktime(23, 59, 59, $date[0], $date[1], $date[2]);
                }
                $lead->setDueDate($dueDate);
                $lead->setRating($this->input->post('rating'));
                $lead->setCompanyName($this->input->post('companyName'));
                $lead->setFirstName($this->input->post('firstName'));
                $lead->setLastName($this->input->post('lastName'));
                $lead->setTitle($this->input->post('title'));
                $lead->setAddress($this->input->post('address'));
                $lead->setCity($this->input->post('city'));
                $lead->setState($this->input->post('state'));
                $lead->setZip($this->input->post('zip'));
                $lead->setBusinessPhone($this->input->post('businessPhone'));
                $lead->setBusinessPhoneExt($this->input->post('businessPhoneExt'));
                $lead->setCellPhone($this->input->post('cellPhone'));
                $lead->setFax($this->input->post('fax'));
                $lead->setEmail($this->input->post('email'));
                $lead->setWebsite($this->input->post('website'));
                $lead->setProjectName($this->input->post('projectName'));
                $lead->setProjectAddress($this->input->post('projectAddress'));
                $lead->setProjectCity($this->input->post('projectCity'));
                $lead->setProjectState($this->input->post('projectState'));
                $lead->setProjectZip($this->input->post('projectZip'));
                $lead->setProjectPhone($this->input->post('projectPhone'));
                $lead->setProjectPhoneExt($this->input->post('projectPhoneExt'));
                $lead->setProjectCellPhone($this->input->post('projectCellPhone'));
                $lead->setProjectContact($this->input->post('projectContact'));
                $lead->setSource($this->input->post('source'));
                $lead->setNotes($this->input->post('notes'));
                $lead->setAccount($this->input->post('account'));
                // Build services string
                $servicesText = '';
                if (is_array($this->input->post('services'))) {
                    $servicesText = implode(', ', $this->input->post('services'));
                }
                $lead->setServices($servicesText);
                $lead->setLastActivity();
                // Geocode
                $lead->setLatLng();
                // Save
                $this->em->persist($lead);
                $this->em->flush();

                $this->getQueryCacheRepository()->deleteCompanyLeadsCountCache($this->account()->getCompanyId());

                $business_type = $this->input->post('business_type');
                if ($business_type) {

                    //foreach($business_types as $business_type){

                    $assignment = new models\BusinessTypeAssignment();
                    $assignment->setBusinessTypeId($business_type);
                    $assignment->setCompanyId($this->account()->getCompany()->getCompanyId());
                    $assignment->setLeadId($lead->getLeadId());
                    $this->em->persist($assignment);

                    // }

                    $this->em->flush();
                }
                $assignedAccount = $this->em->find('models\Accounts', $lead->getAccount());

                // PSA Stuff for a new audit
                if ($this->input->post('psaAuditCheck') && $assignedAccount) {
                    $this->load->library('psa_client', ['account' => $assignedAccount]);

                    $apiParams = [
                        'company_name' => $lead->getCompanyName(),
                        'project_name' => $lead->getProjectName(),
                        'address' => $lead->getProjectAddress(),
                        'city' => $lead->getProjectCity(),
                        'state' => $lead->getProjectState(),
                        'zip' => $lead->getProjectZip(),
                        'first_name' => $lead->getFirstName(),
                        'last_name' => $lead->getLastName(),
                        'title' => $lead->getTitle()
                    ];

                    $responseObj = $this->psa_client->addLocation($apiParams);

                    if (!$responseObj->error) {
                        // Location was created, we can proceed
                        $auditParams = [
                            'locationId' => $responseObj->locationId,
                            'auditType' => $this->input->post('auditType'),
                            'leadId' => $lead->getLeadId()
                        ];

                        $auditResponse = $this->psa_client->createAudit($auditParams);

                        if (!$auditResponse->error) {
                            $additionalText = 'Audit created successfully';

                            $lead->setPsaAuditUrl($auditResponse->auditUrl);
                            $lead->setPsaSmsUrl($auditResponse->auditSmsUrl);
                            $this->em->persist($lead);
                            $this->em->flush();
                        } else {
                            $additionalText = "Prosite Audit Error: " . $responseObj->message;
                        }
                    } else {
                        $additionalText = "PrositeAudit Location Error: " . $responseObj->message;
                    }
                }

                // If we're reassigning and there's an existing audit
                if ($reassigning && $lead->getPsaAuditUrl() && $assignedAccount) {
                    // Load the API client
                    $this->load->library('psa_client', ['account' => $assignedAccount]);

                    // We just need the lead ID. User credentials are supplied by the API client
                    $apiParams = [
                        'leadId' => $lead->getLeadId()
                    ];

                    // Send the request
                    $responseObj = $this->psa_client->reassignLeadAudit($apiParams);

                    if ($responseObj->error) {
                        $additionalText = 'There was a problem reassigning the audit in ProSiteAudit.';
                    }
                }

                // Log it
                $this->log_manager->add(\models\ActivityAction::EDIT_LEAD, 'Edited Lead - Project Name: ' . $lead->getProjectName());
                // Feedback
                $this->session->set_flashdata('success', 'Lead Saved!' . '<br /><p>' . $additionalText . '</p>');

                // Send an email if it's assigned to a user
                if ($assignedAccount) {
                    $this->getLeadRepository()->sendLeadEmail($this->account(), $lead, $reassigning);
                }

                redirect('leads');
            }



           // $event = $this->getEventRepository()->getLeadEvents($lead->getLeadId());

            $data['lead'] = $lead;
            $data['accounts'] = $this->getCompanyAccounts();
            $data['users'] = $this->getCompanyAccounts();
            $data['assignedBusinessTypes'] = $this->getCompanyRepository()->getCompanyBusinessTypeAssignments($this->account()->getCompany(), 'lead', $lead->getLeadId(), true);
            $data['attachments'] = $this->getLeadRepository()->getAttachments($lead->getLeadId());
            $data['services'] = $services;
            $data['ratings'] = $this->leadRatings;
            $data['statuses'] = $this->leadStatuses;
            $data['sources'] = $this->account()->getCompany()->getLeadSources();
            $data['account'] = $this->account();
            $data['selectedServices'] = explode(',', $lead->getServices());
            $data['events'] = $this->getEventRepository()->getLeadEvents($lead->getLeadId());
            $data['filterAccounts'] = $this->getAccountRepository()->getAllAccountsByPermission(
                $this->account()->getAccountId(),
                true
            );
            $data['businessTypes'] = $this->getCompanyRepository()->getCompanyBusinessTypes($this->account()->getCompany());
            $this->html->addScript('dataTables');
            $this->html->addScript('scheduler');
            $this->html->addScript('select2');
            $this->load->view('leads/edit', $data);
        } else {
            $this->session->set_flashdata('error', 'Lead Not Found!');
            redirect('leads');
        }
    }

    //not used anymore
    function delete($id)
    {
        $lead = $this->em->find('models\Leads', $id);
        if ($lead) {
            $this->log_manager->add(\models\ActivityAction::DELETE_LEAD, 'Deleted Lead #' . $lead->getLeadId() . '.');
            $this->em->remove($lead);
            $this->em->flush();
            $this->getQueryCacheRepository()->deleteCompanyLeadsCountCache($this->account()->getCompanyId());
            $this->session->set_flashdata('success', 'Lead Deleted!');
        } else {
            $this->session->set_flashdata('error', 'Lead Not Found!');
        }
        redirect('leads');
    }

    /**
     * Cancel a lead
     * @param $id
     */
    function cancel($id)
    {
        /** @var \models\Leads $lead */
        $lead = $this->em->find('models\Leads', $id);
        if ($lead) {
            $lead->setStatus('Cancelled');
            $this->em->persist($lead);
            $this->em->flush();
            $this->getQueryCacheRepository()->deleteCompanyLeadsCountCache($this->account()->getCompanyId());
            $this->session->set_flashdata('success', 'Lead Cancelled!');
        } else {
            $this->session->set_flashdata('error', 'Lead Not Found!');
        }
        redirect('leads');
    }


    function convert($id)
    {
        /** @var \models\Leads $lead */
        $lead = $this->em->find('models\Leads', $id);
        if ($lead) {
            if ($this->input->post('continue')) {

                $client = null;

                if ($lead->getClient()) {
                    $client = $this->em->find('models\Clients', $lead->getClient());
                }

                //create proposal and send user to edit proposal page
                if (!$client) {

                    if (!$this->input->post('account_id')) {
                        $clientAccount = new \models\ClientCompany();
                        $clientAccount->setOwnerCompany($this->account()->getCompany());
                        $clientAccount->setCreated(time());
                        $clientAccount->setName($this->input->post('accCompanyName'));

                        $ownerAccount = $this->em->find('\models\Accounts', $this->input->post('owner'));
                        if ($ownerAccount) {
                            $clientAccount->setOwnerUser($ownerAccount);
                        } else {
                            $clientAccount->setOwnerUser($this->account());
                        }

                        $this->em->persist($clientAccount);
                        $this->em->flush();
                    } else {
                        $clientAccount = $this->em->find('\models\ClientCompany', $this->input->post('client_account'));
                    }

                    $client = new models\Clients();
                    $client->setFirstName($this->input->post('firstName'));
                    $client->setLastName($this->input->post('lastName'));
                    $client->setCompanyName($this->input->post('companyName'));
                    $client->setBusinessPhone($this->input->post('businessPhone'));
                    $client->setEmail($this->input->post('email'));
                    $client->setCellPhone($this->input->post('cellPhone'));
                    $client->setFax($this->input->post('fax'));
                    $client->setTitle($this->input->post('title'));
                    $client->setState($this->input->post('state'));
                    $client->setWebsite($this->input->post('website'));
                    $client->setAddress($this->input->post('address'));
                    $client->setCity($this->input->post('city'));
                    $client->setZip($this->input->post('zip'));
                    $client->setCountry('USA');
                    $client->setCountry($this->input->post('country'));
                    $client->setClientAccount($clientAccount);
                    // Account allocation

                    // If no lead account, assign to current user
                    if (!$lead->getAccount()) {
                        $client->setAccount($this->account());
                        $proposalAccount = $this->account();
                    } else {
                        // Load account and assign
                        $acc = $this->em->find('models\Accounts', $lead->getAccount());
                        if ($acc) {
                            $client->setAccount($acc);
                        } else {
                            $client->setAccount($this->account());
                        }
                    }
                    $client->setCompany($this->account()->getCompany());
                    $this->em->persist($client);
                    $this->em->flush();

                    $contact_business_types = $this->input->post('contact_business_type');
                    if ($contact_business_types) {
                        $this->getCompanyRepository()->checkClearClientAssignedBusinessTypes($this->account()->getCompany(), $client->getClientId(), $contact_business_types);
                        // $this->getCompanyRepository()->checkClearClientAssignedBusinessTypes($this->account()->getCompany(),$client->getClientId(),$businessTypes);
                        // foreach($contact_business_types as $contact_business_type){

                        //     $assignment = new models\BusinessTypeAssignment();
                        //     $assignment->setBusinessTypeId($contact_business_type);
                        //     $assignment->setCompanyId($this->account()->getCompany()->getCompanyId());
                        //     $assignment->setClientId($client->getClientId());
                        //     $this->em->persist($assignment);
                        // }

                        // $this->em->flush();
                    }
                }

                $proposalAccount = $this->em->find('models\Accounts', $this->input->post('owner'));
                $openStatus = $this->account()->getCompany()->getDefaultStatus(\models\Status::OPEN);

                $proposal = $this->getProposalRepository()->create($this->account()->getCompany()->getCompanyId());
                $proposal->setProjectAddress($this->input->post('projectAddress'));
                $proposal->setProjectCity($this->input->post('projectCity'));
                $proposal->setProjectState($this->input->post('projectState'));
                $proposal->setProjectZip($this->input->post('projectZip'));
                $proposal->setProjectName($this->input->post('projectName'));
                $proposal->setProposalTitle($this->input->post('projectTitle'));
                $proposal->setBusinessTypeId($this->input->post('business_type'));
                $proposal->setPaymentTerm($this->account()->getCompany()->getPaymentTerm());
                $proposal->setProposalStatus($openStatus);
                $proposal->setConvertedFrom($lead->getLeadId());
                $proposal->setResendExcluded($client->getResendExcluded());
                $proposal->setClient($client);
                $proposal->setOwner($proposalAccount);
                $proposal->setProposalUuid('');
                $proposal->setCompanyId($this->account()->getCompany()->getCompanyId());

                if ($client->getAccount()->getAccountId() != $proposal->getOwner()->getAccountId()) {
                    // Email the owner of th client if different from the proposal owner
                    $emailData = [
                        'clientOwnerFirstName' => $client->getAccount()->getFirstName(),
                        'proposalProjectTitle' => $proposal->getProjectName(),
                        'proposalOwnerFullName' => $proposal->getOwner()->getFullName(),
                        'clientName' => $proposal->getClient()->getFullName(),
                        'accountName' => $proposal->getClient()->getClientAccount() ? $proposal->getClient()->getClientAccount()->getName() : 'Unspecified Account',
                    ];
                    $this->load->model('system_email');
                    $this->system_email->sendEmail(20, $client->getAccount()->getEmail(), $emailData);
                }

                //set the default texts selected in my account -> custom texts
                $this->load->library('Repositories/CustomtextRepository');
                $proposal->setTextsCategories($this->customtextrepository->getDefaultCategories($this->account()->getCompany()->getCompanyId()));

                // Set the job number if set
                if ($this->account()->getCompany()->getUseAutoNum()) {
                    $proposal->setJobNumber($this->account()->getCompany()->getProposalAutoNum());
                }

                //set up the default texts
                $texts = $this->customtexts->getTexts($proposal->getClient()->getCompany()->getCompanyId());
                $txts = '';
                $k = 0;
                foreach ($texts as $textId => $text) {
                    $k++;
                    if ($text->getChecked() == 'yes') {
                        $txts .= $textId;
                        if ($k < count($texts)) {
                            $txts .= ',';
                        }
                    }
                }
                $proposal->setTexts($txts);
                $this->em->persist($proposal);
                if ($lead->getAddedByUserId()) {
                    $account = $this->em->find('models\Accounts', $lead->getAddedByUserId());
                }
                if (!isset($account)) {
                    $account = $this->account();
                }
                $lead->setStatus('Converted');
                $this->em->persist($lead);
                $lead->setConverted(time());
                $this->em->flush();
                $lead->setConvertedTo($proposal->getProposalId());
                $lead->setLastActivity();
                $this->em->persist($lead);
                $this->em->flush();

                //Create Proposal preview Client Link
                $this->getProposalRepository()->createClientProposalLink($proposal->getProposalId());

                //Copy All default Video 
                $this->getProposalRepository()->copyDefaultCompanyVideo($this->account()->getCompany()->getCompanyId(),$proposal->getProposalId());

                $this->getQueryCacheRepository()->deleteCompanyLeadsCountCache($this->account()->getCompanyId());
                $this->getQueryCacheRepository()->deleteCompanyHeaderProposalCache($this->account()->getCompanyId());

                // Geocode the proposal
                $this->getProposalRepository()->setLatLng($proposal);

                //Check business type assignment in account
                $this->getProposalRepository()->checkNewBusinessTypeProposalAssignment($proposal, $this->input->post('business_type'), $this->account()->getCompany()->getCompanyId());

                //Event Log 
                $this->getProposalEventRepository()->leadCreated($proposal, $account, $lead->getCreated(true));
                $this->getProposalEventRepository()->leadConvertToProposal($proposal, $this->account(), $lead->getCreated(true));
                // Copy notes
                $leadNotes = $this->getLeadRepository()->getLeadNotes($lead);

                // Copy across individual notes
                if (count($leadNotes)) {
                    foreach ($leadNotes as $leadNote) {
                        /* @var \models\Notes $leadNote */
                        $proposalNote = new \models\Notes();
                        $proposalNote->setType('proposal');
                        $proposalNote->setNoteText('[Lead Note] ' . $leadNote->getNoteText());
                        $proposalNote->setRelationId($proposal->getProposalId());
                        $proposalNote->setAdded($leadNote->getAdded());
                        $proposalNote->setUser($leadNote->getUser());
                        $this->em->persist($proposalNote);
                    }
                    $this->em->flush();
                }

                // Copy across general notes
                if ($lead->getNotes()) {
                    $proposalNote = new \models\Notes();
                    $proposalNote->setType('proposal');
                    $proposalNote->setNoteText('[Lead Notes]: ' . $lead->getNotes());
                    $proposalNote->setRelationId($proposal->getProposalId());
                    $proposalNote->setAdded(time());
                    $proposalNote->setUser($this->account()->getAccountId());
                    $this->em->persist($proposalNote);
                    $this->em->flush();
                }

                //migrate attachments if present
                $this->getProposalRepository()->migrateAttachmentsFromLead($proposal->getProposalId(),
                    $lead->getLeadId());

                //link the selected attachments to be included automatically
                $this->load->library('Repositories/AttachmentRepository.php');
                $this->attachmentrepository->linkCheckedAttachments($this->account()->getCompany()->getCompanyId(),
                    $proposal->getProposalId());

                $this->getClientRepository()->updateProposalCount($proposal->getClient()->getClientId());

                $this->log_manager->add(\models\ActivityAction::LEAD_CONVERT,
                    'Converted Lead #' . $lead->getLeadId() . ' (' . $lead->getProjectName() . ') to Proposal', $client,
                    $proposal);
                $this->log_manager->add(\models\ActivityAction::ADD_PROPOSAL, 'Added Proposal', $client, $proposal);
                redirect('proposals/edit/' . $proposal->getProposalId() . '/items');
            }

            $data = array();
            $data['lead'] = $lead;
            $client = null;
            if ($lead->getClient()) {
                $client = $this->em->find('models\Clients', $lead->getClient());
            }
            if ($this->uri->segment(4)) {
                $client = $this->em->find('models\Clients', $this->uri->segment(4));
            }
            if (!$client) {
                $q = 'SELECT c FROM models\Clients c WHERE c.company IS NOT NULL AND c.company=' . $this->account()->getCompany()->getCompanyId() . "and c.companyName LIKE '%" . str_replace("'",
                        '%', $lead->getCompanyName()) . "%'";
                $data['clients'] = $this->em->createQuery($q)->setMaxResults(10)->getResult();
            }

            $data['client'] = $client;
            $data['account'] = $this->account();
            $data['assignedBusinessTypes'] = $this->getCompanyRepository()->getCompanyBusinessTypeAssignments($this->account()->getCompany(), 'lead', $lead->getLeadId(), true);

            $data['clientAccounts'] = $this->account()->getCompany()->getClientAccounts(true);
            $data['userAccounts'] = $this->account()->getCompany()->getActiveSortedAccounts();
            $data['businessTypes'] = $this->getCompanyRepository()->getCompanyBusinessTypes($this->account()->getCompany());
            $this->html->addScript('select2');
            $this->load->view('leads/convert', $data);
        } else {
            $this->session->set_flashdata('error', 'Lead Not Found!');
            redirect('leads');
        }
    }


    public function route()
    {
        $leads = $this->account()->getLeads();
        $data = [];
        $data['leads'] = $leads;

        $this->load->view('leads/route', $data);
    }

    public function map()
    {
        $group = false;
        $leads = [];

        if ($this->input->post('leads')) {
            $group = true;
            foreach ($this->input->post('leads') as $leadId) {
                $leads[] = $this->em->find('models\Leads', $leadId);
            }

        } else {
            foreach ($this->account()->getLeads() as $lead) {
                $leads[] = $lead[0];
            }
            // $leads = $this->account()->getLeads();
        }

        $data = [];
        $data['leads'] = $leads;
        $data['account'] = $this->account();
        $data['group'] = $group;
        $this->html->addScript('dataTables');
        $this->load->view('leads/map', $data);
    }

    function addTemporaryAttachment()
    {
        $uploadDir = UPLOADPATH . '/leads/';
        $uploadFolder = 'temp';
        $uploadDir .= $uploadFolder . '/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir);
        }
        $response = [];
        if ((isset($_FILES['attachment']) && $_FILES['attachment']['error']) || !isset($_FILES['attachment'])) {
            $response['success'] = false;
        } else {
            $response['success'] = true;
            $fileName = md5(microtime()) . $_FILES['attachment']['name'];
            $newFileName = str_replace([' ', '+'], '_', $fileName);
            move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadDir . $newFileName);
            $response['fileURL'] = site_url('uploads/leads/' . $uploadFolder . '/' . $newFileName);
            $response['fileName'] = $_POST['fileName'];
            $response['filePath'] = $newFileName;
        }
        echo json_encode($response);
    }

    public function removeAttachment($attachmentId, $leadId)
    {
        $this->getLeadRepository()->removeAttachment($attachmentId);
        $this->getLogRepository()->add([
            'action' => 'removed_lead_attachment',
            'details' => 'Removed Lead Attachment on Lead with ID: ' . $leadId,
            'account' => $this->account()->getAccountId(),
            'company' => $this->account()->getCompany()->getCompanyId()
        ]);
        $this->session->set_flashdata('success', 'Attachment deleted!');
        redirect('leads/edit/' . $leadId);
    }

    function addAttachment($leadId)
    {
        $uploadDir = UPLOADPATH . '/leads/';
        $uploadFolder = $leadId;
        $uploadDir .= $uploadFolder . '/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 755, true);
        }
        $response = [];
        if ((isset($_FILES['attachment']) && $_FILES['attachment']['error']) || !isset($_FILES['attachment'])) {
            $response['success'] = false;
        } else {
            $response['success'] = true;
            $fileName = md5(microtime()) . $_FILES['attachment']['name'];
            $newFileName = str_replace([' ', '+'], '_', $fileName);
            move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadDir . $newFileName);
            $response['fileURL'] = site_url('uploads/leads/' . $uploadFolder . '/' . $newFileName);
            $response['fileName'] = $_POST['fileName'];
            $response['filePath'] = $newFileName;
            $this->getLeadRepository()->addAttachment($leadId, $_POST['fileName'], $newFileName);
            $this->session->set_flashdata('success', 'Attachment added!');
            $this->getLogRepository()->add([
                'action' => 'added_lead_attachment',
                'details' => 'Added Lead Attachment on Lead with ID: ' . $leadId,
                'account' => $this->account()->getAccountId(),
                'company' => $this->account()->getCompany()->getCompanyId()
            ]);
        }
        echo json_encode($response);
    }

    public function editAttachmentName($id)
    {
        $this->getLeadRepository()->editAttachmentName($id, $this->input->post('name'));
        echo json_encode(['success' => true, 'id' => $id, 'name' => $this->input->post('name')]);
    }


    public function group_resends()
    {
        $data = [];
        $this->html->addScript('ckeditor4');
        $data['resends'] = $this->getLeadRepository()->getCompanyLeadResendList($this->account()->getCompany(), $this->account());


        $this->load->model('clientEmail');
        $data['clientTemplates'] = $this->clientEmail->getTemplates($this->account()->getCompany()->getCompanyId(), \models\ClientEmailTemplateType::CLIENT, true);
        $data['account'] = $this->account();
        $data['layout'] = 'leads/group_resends';
        $this->html->addScript('dataTables');
        $this->load->view('leads/group_resends', $data);
    }

    public function group_resends_data()
    {
        $company = $this->account()->getCompany();

        $tableData = [];
        $rowsData = [];
        // $itemsData = [];
        $itemsData = $this->getLeadRepository()->getGroupResendData($company, false, $this->account());

        foreach ($itemsData as $dataRow) {
            $rowsData[] = $dataRow;
        }

        $tableData['sEcho'] = (int)$this->input->post('echo');
        $tableData['iTotalRecords'] = $this->getLeadRepository()->getGroupResendData($company, true, $this->account());
        $tableData['iTotalDisplayRecords'] = $this->getLeadRepository()->getGroupResendData($company, true, $this->account());
        $tableData['aaData'] = $rowsData;

        echo json_encode($tableData);
    }

    function resend()
    {
        // Auth checks

        $filter = $this->uri->segment(3);


        $this->session->set_userdata('pLeadResendFilter', 1);


        $this->session->set_userdata('pLeadResendFilterId', $filter);


        $this->index();
    }

    function groupExport()
    {
        $leadIds = $this->input->post('groupExportLeadIds');
        $fileName = str_replace(('/[^a-zA-Z0-9_-\s]/g'), '', $this->input->post('fileName'));

        header('Content-Type: text/csv; charset=UTF-8');
        header('Content-Disposition: attachment; filename="' . $fileName . '.csv"');
        return $this->getLeadRepository()->groupLeadExportCSV($this->account(), $leadIds);
    }
}
