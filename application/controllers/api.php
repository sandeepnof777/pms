<?php

use Pms\RepositoryAbstract;
use Intervention\Image\ImageManager;

class Api extends MY_Controller
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    var $em;
    /**
     * @var Log_manager
     */
    var $log_manager;
    private $response = Array();
    private $account = NULL;

    function __construct()
    {
        parent::__construct();

        if (!$this->input->post('psa')) {

            $account = $this->em->createQuery("select a from models\Accounts a where a.email='" . $this->input->post('email') . "' and a.password='" . md5($this->input->post('password')) . "' order by a.accountId asc")->setMaxResults(1);
            $account = $account->getResult();
            if (!count($account)) { //former if (!$account)
                $this->response['responseCode'] = 1002; // throw an error for invalid email/pass used for authentication
                die();
            } else {
                $this->account = $account[0];
                if ($this->account->isExpired()) {
                    $this->response['responseCode'] = 1003; //throw an error of company expired for expired user and die
                    die();
                }

                if (!$this->account->getWio()) {
                    $this->response['responseCode'] = 1003; // No API access
                    die();
                }
            }

        }
    }

    private function createResponse()
    {
        echo json_encode($this->response);
    }

    function __destruct()
    {
        $this->createResponse();
    }

    function checkLogin()
    {
        if ($this->input->post('generateToken')) {
            $authToken = md5(time());
//            $this->account->setToken($authToken);
            $this->em->persist($this->account);
            $this->em->flush();
            $this->response['authToken'] = $authToken;
        }
        $this->response['responseCode'] = 0;
    }

    function checkLogin2()
    {
        $account = $this->em->createQuery("select a from models\Accounts a where a.email='" . $this->input->post('email') . "' and a.password='" . md5($this->input->post('password')) . "' order by a.accountId asc")->setMaxResults(1);
        $account = $account->getResult();
        if (!count($account)) {
            $this->response['accountName'] = 'None Found';
        } else {
            $account = $account[0];
            $this->response['accountName'] = $account->getFullName();
        }
        if ($this->input->post('generateToken')) {
            $authToken = md5(time());
            $this->em->persist($this->account);
            $this->em->flush();
            $this->response['authToken'] = $authToken;
        }
        $this->response['responseCode'] = 0;
    }

    function getClients()
    {
        // We now allow users to see all clients
        $clients = $this->account->getCompany()->getClients();
        /*
        if ($this->account->isAdministrator() || ($this->account->getFullAccess() == 'yes')) {
            $clients = $this->account->getCompany()->getClients();
        } else {
            $clients = $this->account->getClients();
        }
        */
        if (!count($clients)) {
            $this->response['responseCode'] = 2001;
        } else {
            $this->response['responseCode'] = 0;
            $this->response['clients'] = Array();
            foreach ($clients as $client) {
                /* @var $client \models\Clients */
                $this->response['clients'][] = array(
                    'clientId' => $client->getClientId(),
                    'firstName' => $client->getFirstName(),
                    'lastName' => $client->getLastName(),
                    'companyName' => $client->getClientAccount()->getName(),
                );
            }
        }
    }

    function getClientsForPSA()
    {
        $accountId = base64_decode($this->input->post('accountId'));
        $query = $this->input->post('q');
        $account = $this->em->findAccount($accountId);
        $this->account = $account;

        // We now allow users to see all clients
        $resultArray = $this->account->getCompany()->getPsaSearchClients($query);

        if (!count($resultArray)) {
            $this->response['clients'] = [];
        } else {
            $this->response['responseCode'] = 0;
            $this->response['clients'] = Array();
            foreach ($resultArray as $client) {
                $this->response['clients'][] = array(
                    'id' => base64_encode($client->clientId),
                    'name' => $client->clientCompanyName . ': ' . $client->fullName
                );
            }
        }
    }

    function getProposalsForPSA()
    {
        $account = $this->em->findAccount(base64_decode($this->input->post('accountId')));
        $this->account = $account;

        $client = $this->em->findClient(base64_decode($this->input->post('clientId')));
        if (!$client) {
            $this->response['responseCode'] = 3001;
            die();
        }
        //check access level
        if (($this->account->getCompany() == $client->getCompany()) && (($this->account->isAdministrator()) || ($this->account->getFullAccess() == 'yes') || ($this->account == $client->getAccount()))) {
            $proposals = $this->account->getCompany()->getPsaSearchProposals($client->getClientId());
            if (!count($proposals)) {
                $this->response['responseCode'] = 3002;
            } else {
                $this->response['responseCode'] = 0;
                $this->response['proposals'] = Array();
                foreach ($proposals as $proposal) {

                    $this->response['proposals'][] = array(
                        'id' => base64_encode($proposal->proposalId),
                        'text' => $proposal->projectName,
                    );
                }
            }
        } else {
            $this->response['responseCode'] = 3003;
        }
//        $this->log_manager->add_external('wio_getProposals', 'WheelItOff Get Proposals', $proposal->getClient()->getClientId(), $proposal->getProposalId(), $this->account->getCompany()->getCompanyId(), $this->account->getAccountId());
    }

    public function inventoryLogin()
    {
        $account = $this->em->createQuery("select a from models\Accounts a where a.email='" . $this->input->post('email') . "' and a.password='" . md5($this->input->post('password')) . "' order by a.accountId asc")->setMaxResults(1);
        $account = $account->getResult();
        if (!count($account)) {
            $this->response['loginFailed'] = 1;
            $this->response['accountName'] = 'Incorrect Login';
        } else {
            $account = $account[0];
            $this->response['accountName'] = $account->getFullName();
            $this->response['secureId'] = base64_encode($account->getAccountId());
        }
        $this->response['responseCode'] = 0;
    }

    public function uploadInventoryImages()
    {
        $this->account = $this->em->findAccount(base64_decode($this->input->post('accountId')));
        $proposal = $this->em->findProposal(base64_decode($this->input->post('proposalId')));
        $proposal->setLastActivity();
        $this->em->persist($proposal);
        $this->em->flush();

        $arrContextOptions=array(
            "ssl"=>array(
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ),
        );

        $imageData = $this->input->post('imageData');

        $companyFolder = $proposal->getCompanyUploadDir();
        if (!is_dir($companyFolder)) {
            mkdir($companyFolder, 0775, true);
        }

        $folder = $proposal->getUploadDir();
        if (!is_dir($folder)) {
            mkdir($folder, 0775, true);
        }

        foreach ($imageData as $data) {

            $url = $data['url'];
            $response = file_get_contents($url, false, stream_context_create($arrContextOptions));

            if ($response) {

                // Encode the response
                $base64Data = base64_encode($response);
                $fileName = md5(microtime()) . '.png';
                $path = $folder . '/' . $fileName;

                // Save the image
                $imageManager = new ImageManager();
                $image = $imageManager->make($base64Data);
                $image->save($path);

                $imageName = $data['name'];
                $imageDescription = $data['description'];

                $imgData = [
                    'imgName' => $imageName,
                    'imgNotes' => $imageDescription,
                    'fileName' => $fileName
                ];

                $this->getProposalRepository()->saveProposalImage($proposal, $imgData, $fileName);
                $this->log_manager->add_external('inventory_image_added', 'Inventory Image Added - ' . $imageName, $proposal->getClient()->getClientId(), $proposal->getProposalId(), $this->account->getCompany()->getCompanyId(), $this->account);
            }
        }
    }

    function getProposals()
    {

        $client = $this->em->find('models\Clients', $this->input->post('clientID'));

        if (!$client) {
            $this->response['responseCode'] = 3001;
            log_message('error', 'Error Loading Wheel it Off Client');
            die();
        }

        log_message('error', 'Client Loaded: ' . $client->getClientId());

        //check access level
        if ($this->account->getCompany() == $client->getCompany()) {

            log_message('error', 'Access Granted to user: ' . $this->account->getFullName());

            $proposals = $client->getProposals();
            if (!count($proposals)) {
                $this->response['responseCode'] = 3002;
                log_message('error', 'No Proposals Found');
            } else {
                log_message('error', 'Proposals Found');
                $this->response['responseCode'] = 0;
                $this->response['proposals'] = Array();
                foreach ($proposals as $proposal) {
                    /* @var models\Proposals $proposal */

                    // Project name with job number if we have one
                    $projectName = $proposal->getProjectName();
                    if ($proposal->getJobNumber()) {
                        $projectName = '#' . $proposal->getJobNumber() . ' - ' . $projectName;
                    }

                    log_message('error', 'Proposal Found: ' . $projectName);

                    $this->response['proposals'][] = array(
                        'proposalId' => $proposal->getProposalId(),
                        'projectName' => $projectName,
                    );
                }
            }
        } else {
            $this->response['responseCode'] = 3003;
        }
//        $this->log_manager->add_external('wio_getProposals', 'WheelItOff Get Proposals', $proposal->getClient()->getClientId(), $proposal->getProposalId(), $this->account->getCompany()->getCompanyId(), $this->account->getAccountId());
    }

    function addImage()
    {
        //check proposal privileges
        $proposal = $this->em->find('models\Proposals', $this->input->post('proposalID'));
        if (!$proposal) {
            $this->response['responseCode'] = 4001;
            die();
        }
        if ($this->account->getCompanyId() != $proposal->getClient()->getCompany()->getCompanyId()) {
            $this->response['responseCode'] = 4001;
            die();
        }
        if ($_FILES['image']['error']) {
            $this->response['responseCode'] = 4004;
        } else {
            $supported_files = array('image/png', 'image/x-png', 'image/xpng');
            if (!in_array($_FILES['image']['type'], $supported_files)) {
                $this->response['responseCode'] = 4003;
            } else {
                //check if title has been sent
                if (!@$this->input->post('title')) {
                    $this->response['responseCode'] = 4005;
                    die();
                }
                //all good, go upload
                $ext = '.png';
                $ext = '.jpg';
                // New directory structure
                $companyFolder = $proposal->getCompanyUploadDir();
                if (!is_dir($companyFolder)) {
                    mkdir($companyFolder, 0777, true);
                }

                $folder = $proposal->getUploadDir();
                if (!is_dir($folder)) {
                    mkdir($folder, 0777, true);
                }
                //upload picture
                $fileName = md5(time()) . $ext;
                $file = $folder . '/' . $fileName;
                $im = imagecreatefrompng($_FILES['image']['tmp_name']);
                //check if the image needs resizing
                $size = @getimagesize($_FILES['image']['tmp_name']);
                if ($size) {
                    $width = $size[0];
                    if ($width > 1000) {
                        $newh = round((1000 / $size[0]) * $size[1]);
                        $new_im = imagecreatetruecolor(1000, $newh);
                        imagecopyresampled($new_im, $im, 0, 0, 0, 0, 1100, $newh, $size[0], $size[1]);
                        imagejpeg($new_im, $file);
                    } else {
                        imagejpeg($im, $file);
                    }
                } else {
                    imagejpeg($im, $file);
                }
                //attach to proposal
                $image = new \models\Proposals_images();
                $image->setProposal($proposal);
                $image->setOrder(999);
                $image->setImage($fileName);
                $image->setTitle($this->input->post('title'));
                $image->setActive(1);
                $image->setActivewo(1);
                $image->setMap(1);
                $this->em->persist($image);
                $this->em->flush();

                $proposal->setLastActivity();
                $proposal->setRebuildFlag(1);
                $this->em->persist($proposal);
                $proposal->setImageCount($this->getProposalRepository()->getRealImageCount($proposal));
                $this->em->flush();
                $this->em->clear();

                //done
                $this->log_manager->add_external('wio_addImage', 'WheelItOff Added Image - ' . $this->input->post('title'), $proposal->getClient()->getClientId(), $proposal->getProposalId(), $this->account->getCompany()->getCompanyId(), $proposal->getClient()->getAccount());
                $this->response['responseCode'] = '0';
            }
        }
    }


    function psaConvertLead()
    {

        $lead = $this->em->find('models\Leads', $this->input->post('leadId'));
        $reportUrl = $this->input->post('reportUrl');
        $completed = $this->input->post('completed');
        $auditKey = $this->input->post('auditKey');
        $completedDateTime = new \DateTime();
        $completedDateTime->setTimestamp($completed);

        /* @var $lead \models\Leads */
        if ($lead) {

            if ($lead->getConvertedTo()) {
                return false;
            }

            $account = $this->em->find('models\Accounts', $lead->getAccount());
            $company = $this->em->findCompany($lead->getCompany());

            if (!$account) {
                $account = $company->getAdministrator();
            }

            $client = null;

            if ($lead->getClient()) {
                $client = $this->em->find('models\Clients', $lead->getClient());
            }

            //create proposal and send user to edit proposal page
            if (!$client) {

                // Get or create the account
                $clientAccount = $company->getAccountFromName($lead->getCompanyName(), $account);

                $client = new models\Clients();
                $client->setFirstName($lead->getFirstName());
                $client->setLastName($lead->getLastName());
                $client->setCompanyName($lead->getCompanyName());
                $client->setBusinessPhone($lead->getBusinessPhone());
                $client->setCellPhone($lead->getCellPhone());
                $client->setEmail($lead->getEmail());
                $client->setTitle($lead->getTitle());
                $client->setAddress($lead->getAddress());
                $client->setCity($lead->getCity());
                $client->setState($lead->getState());
                $client->setZip($lead->getZip());
                $client->setCountry('USA');
                // Account allocation
                $client->setClientAccount($clientAccount);

                // If no lead account, assign to current user
                if (!$lead->getAccount()) {
                    $client->setAccount($account);
                } else {
                    // Load account and assign
                    $acc = $this->em->find('models\Accounts', $lead->getAccount());
                    if ($acc) {
                        $client->setAccount($acc);
                    } else {
                        $client->setAccount($account);
                    }
                }
                $client->setCompany($account->getCompany());
                $this->em->persist($client);
                $this->em->flush();
            }


            $status = $account->getCompany()->getDefaultStatus(\models\Status::AUDIT_READY);

            $proposal = $this->getProposalRepository()->create($account->getCompany()->getCompanyId());
            $proposal->setProjectAddress($lead->getProjectAddress());
            $proposal->setProjectCity($lead->getProjectCity());
            $proposal->setProjectState($lead->getProjectState());
            $proposal->setProjectZip($lead->getProjectZip());
            $proposal->setProjectName($lead->getProjectName());
            $proposal->setProposalTitle(SITE_NOUN.' Maintenance Proposal');
            $proposal->setPaymentTerm($account->getCompany()->getPaymentTerm());
            $proposal->setProposalStatus($status);
            $proposal->setClient($client);
            $proposal->setOwner($account);
            $proposal->setAuditKey($auditKey);
            $proposal->setCompanyId($account->getCompany()->getCompanyId());

            //set the default texts selected in my account -> custom texts
            //$this->load->library('Repositories/CustomtextRepository');
            //$proposal->setTextsCategories($this->customtextrepository->getDefaultCategories($account->getCompany()->getCompanyId()));
            $proposal->setTextsCategories($this->getCompanyRepository()->getDefaultTextCategories($account->getCompany()->getCompanyId()));

            // Set the job number if set
            if ($account->getCompany()->getUseAutoNum()) {
                $proposal->setJobNumber($account->getCompany()->getProposalAutoNum());
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
            
            //Delete user query Cache
            $this->getQueryCacheRepository()->deleteCompanyHeaderProposalCache($account->getCompanyId());
            // Geocode
            $this->getProposalRepository()->setLatLng($proposal);

            $this->getClientRepository()->updateProposalCount($proposal->getClient()->getClientId());

            //migrate attachments if present
            $this->getProposalRepository()->migrateAttachmentsFromLead($proposal->getProposalId(), $lead->getLeadId());

            //link the selected attachments to be included automatically
            //$this->load->library('Repositories/AttachmentRepository.php');
            //$this->attachmentrepository->linkCheckedAttachments($account->getCompany()->getCompanyId(), $proposal->getProposalId());

            $this->log_manager->add(\models\ActivityAction::LEAD_CONVERT, 'Converted Lead #' . $lead->getLeadId() . ' (' . $lead->getProjectName() . ') to Proposal', $client, $proposal);
            $this->log_manager->add(\models\ActivityAction::ADD_PROPOSAL, 'Added Proposal', $client, $proposal);

            $emailData = array(
                'first_name' => $account->getFirstName(),
                'last_name' => $account->getLastName(),
                'project_name' => $proposal->getProjectName(),
                'company_name' => $proposal->getClient()->getCompanyName(),
                'client_name' => $proposal->getClient()->getFullName() . ($proposal->getClient()->getCompanyName() ? ' - ' . $proposal->getClient()->getCompanyName() : ''),
                'address' => $proposal->getProjectAddress() . ' ' . $proposal->getProjectCity() . ' ' . $proposal->getProjectState() . ', ' . $proposal->getProjectZip(),
                'editProposalUrl' => $proposal->getEditLink()
            );
            $this->load->model('system_email');
            $this->system_email->sendEmail(19, $account->getEmail(), $emailData);

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
        }
    }

    public function auditView()
    {
        if ($this->input->post('audit_key')) {
            $proposal = $this->em->findProposalByAuditKey($this->input->post('audit_key'));
            if ($proposal) {

                // Get a list of Sender IPs
                $senderIPs = $this->getProposalRepository()->getSenderIps($proposal->getProposalId());
                // Grab the IP from the input
                $viewIP =  $this->input->post('ip');

                // If the view isn't from a sender IP address, mark the audit as viewed
                if (!in_array($viewIP, $senderIPs)) {
                    // Update the proposal
                    $proposal->setAuditViewTime(time());
                    $this->em->persist($proposal);
                    $this->em->flush();
                    // Log the view
                    $this->log_manager->add(\models\ActivityAction::PROPOSAL_AUDIT_VIEWED, 'Audit Viewed', $proposal->getClient(), $proposal, null, null, null, null, $viewIP);
                }
            }
        }
    }

    public function linkInventoryWithProposal()
    {
        $proposalId = base64_decode($this->input->post('proposal_id'));
        $locationId = $this->input->post('location_id');
        $reportUrl = $this->input->post('reportKey');

        $account = $this->em->findAccount(base64_decode($this->input->post('account_id')));
        $this->account = $account;

        $proposal = $this->em->findProposal($proposalId);

        $this->response = [
            'error' => 1
        ];

        if ($proposal) {
            $proposal->setInventoryLocationId($locationId);
            $proposal->setInventoryReportUrl($reportUrl);
            $this->em->persist($proposal);
            $this->em->flush();

            $this->log_manager->add_external('psa_link_inventory', 'Inventory linked with proposal', $proposal->getClient()->getClientId(), $proposal->getProposalId(), $this->account->getCompany()->getCompanyId(), $this->account);

            $this->response = [
                'error' => 0,
                'projectName' => $proposal->getProjectName()
            ];
        }

    }

    public function getInventoryLinkedProposals()
    {
        $locationId = base64_decode($this->input->post('location_id'));

        $qb = $this->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        // Select clients from this company that aren't deleted
        $qb->select('p')
            ->from('\models\Proposals', 'p')
            ->where('p.inventory_location_id = :location_id');

        // Set the parameter
        $qb->setParameter('location_id', $locationId);

        // Create the query and get the result
        $query = $qb->getQuery();
        $proposals = $query->getResult();

        $this->response['proposals'] = [];

        $i = 0;
        foreach($proposals as $proposal) {
            $out = [
                'projectName' => $proposal->getProjectName(),
                'status' => $proposal->getProposalStatus()->getText()
            ];

            $this->response['proposals'][$i] = array_values($out);
            $i++;
        }
    }

}