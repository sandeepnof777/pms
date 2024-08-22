<?php

use Intervention\Image\ImageManager;
use Ramsey\Uuid\Uuid;
use zcrmsdk\crm\crud\ZCRMRecord;
use zcrmsdk\crm\setup\restclient\ZCRMRestClient;
use zcrmsdk\oauth\ZohoOAuth;
use \Carbon\Carbon;
use models\ProposalSectionIndividualOrder;
use Rapidinjection\Browser\Browser;

class Test extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $monthlypay = 1200;
        $luni = 36;
        ?><h1>Simulare <?php echo "{$monthlypay} RON per luna - {$luni} luni"; ?></h1>
        <table border="1" cellpadding="2" cellspacing="2" width="1000">
        <thead>
        <tr>
            <td>Luna</td>
            <td>Sold Initial</td>
            <td>Suma Depusa</td>
            <td>Dobanda</td>
            <td>Sold Final</td>
        </tr>
        </thead>
        <tbody>
        <?php
$bank = 0;
        for ($i = 1; $i <= $luni; $i++) {
            $bank1 = $bank;
            $bank += $monthlypay;
            $dobanda = $bank * 0.07;
            $bank *= 1.07;
            ?>
            <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $bank1; ?></td>
                <td><?php echo $monthlypay ?></td>
                <td><?php echo $dobanda ?></td>
                <td><?php echo $bank ?></td>
            </tr>
            <?php

        }
        ?></tbody>
        </table><?php
echo "Suma totala pt {$monthlypay} ron ({$luni} luni) ar fi: {$bank}";
    }

    public function testAPI()
    {
        ?>
        <!doctype html>
        <html lang="en-US">
        <head>
            <meta charset="UTF-8">
            <title></title>
        </head>
        <body>
        <form action="<?php echo site_url(); ?>/api/getClients" method="post" name="apiTest">
            <input type="hidden" name="email" value="Chad@peterspaving.com"/>
            <input type="hidden" name="password" value="e99d69c7"/>
            <input type="hidden" name="clientId" value="15104"/>
            <input type="submit" value="TEST API"/>
        </form>
        </body>
        </html>
        <?php
}

    public function fixOrphanClients()
    {
        echo 'Checking for Orphans...<br>';
        $this->load->database();
        $sql = "select clients.clientId, clients.account, clients.company from clients left join accounts on clients.account = accounts.accountId where accounts.accountId is null";
        $orphans = $this->db->query($sql)->result();
        echo count($orphans) . ' found! Fixing...<br>';
        $orphansFixed = 0;
        $orphansNotFixed = 0;
        $companyAdmins = array();
        foreach ($orphans as $orphan) {
            $good = true;
            if (!isset($companyAdmins[$orphan->company])) {
                $company = $this->db->query('select administrator from companies where companyId = ?',
                    array($orphan->company))->result();
                if (!count($company)) {
                    $good = false;
                    $this->db->query("delete from clients where clientId=?", array($orphan->clientId));
                    $orphansNotFixed++;
                } else {
                    $company = $company[0];
                    $companyAdmins[$orphan->company] = $company->administrator;
                }
            }
            if ($good) {
                $this->db->query('update clients set account=? where clientId=? limit 1',
                    array($companyAdmins[$orphan->company], $orphan->clientId));
                $orphansFixed++;
            }
        }
        echo "Done! {$orphansFixed} orphans fixed, and {$orphansNotFixed} orphans deleted due to company not existent!<br>";
//        print_r($companyAdmins);
        //        print_r($orphans);
    }

    public function config()
    {
        var_dump($_SERVER);
    }

    public function info()
    {
        echo phpinfo();
    }

    public function report()
    {
        $data = array();
        $data['account'] = $this->account();
        $data['accounts'] = $this->account()->getCompany()->getAccounts();
        $categories = $this->em->createQuery('SELECT c FROM models\Services c where c.parent = 0 order by c.serviceName')->getResult();
        $data['categories'] = $categories;
        $data['statuses'] = $this->account()->getStatuses();
        $services = array();
        $servs = $this->em->createQuery('select s from models\Services s where s.parent <> 0 order by s.ord')->getResult();
        foreach ($servs as $service) {
            $services[$service->getParent()][] = $service;
        }
        $data['services'] = $services;
        $startY = date('Y', $this->account()->getCompany()->getCreated(true));
        $data['startY'] = $startY;

        $this->load->view('test/report', $data);
    }

    public function savedexport()
    {

        $reportTypes =

        /*
        $account = $this->em->find('\models\Accounts', 634);
        $company = $account->getCompany();
        $reportType = $this->em->find('\models\ReportType', 4);

        // Lets create a saved report
        $report = new \models\SavedReport();
        $report->setCompany($company);
        $report->setAccount($account);
        $report->setReportType($reportType);
        $report->setReportName('Manual SE');
        $report->setParams('json');

        $this->em->persist($report);
        $this->em->flush();
         */

        $savedExport = $this->em->find('\models\SavedReport', 9);

        var_dump($savedExport);

    }

    public function emailTemplates()
    {

        $defaultTemplate = $this->em->find('\models\Email_templates', 16);
        /* @var $defaultTemplate \models\Email_templates */
        $templateType = $this->em->find('\models\ClientEMailTemplateType', \models\ClientEmailTemplateType::PROPOSAL);

        $companies = \models\Companies::getAllCompanies();

        foreach ($companies as $company) {

            $template = new \models\ClientEmailTemplate();
            $template->setTemplateName($defaultTemplate->getTemplateName());
            $template->setTemplateDescription($defaultTemplate->getTemplateDescription());
            $template->setTemplateSubject($defaultTemplate->getTemplateSubject());
            $template->setTemplateBody($defaultTemplate->getTemplateBody());
            $template->setCompany($company);
            $template->setTemplateType($templateType);
            $this->em->persist($template);

            /* @var $company \models\Companies */
            echo '<p>' . $company->getCompanyName() . ': Updated</p>';
        }
        $this->em->flush();

    }

    public function benchmark()
    {

        $range = 'custom';

        $custom['from'] = time() - 31536000;
        $custom['to'] = time();

        $start = microtime(true);
        $totalBid = $this->account()->getCompany()->getRangeMagicNumber($range, $custom);
        echo 'Total: ' . $totalBid . "<br />";
        $stop = microtime(true);
        $duration = $stop - $start;
        echo "Query duration - existing method: " . $duration . " microseconds<br /><br />";

    }

    public function statusUpdate()
    {

        $dql = 'SELECT l FROM \models\Log l
                WHERE l.statusTo IS NOT NULL
                ORDER BY l.timeAdded ASC';

        $query = $this->doctrine->em->createQuery($dql);

        $logs = $query->getResult();
        $i = 0;

        foreach ($logs as $log) {
            /* @var $log \models\Log */
            $proposal = $log->getProposal();

            try {
                $proposal->setStatusChangeDate($log->getTimeAdded());
                $this->doctrine->em->persist($proposal);
                $i++;
            } catch (\Exception $e) {

            }

        }
        $this->doctrine->em->flush();

        echo $i . ' proposals updated';

    }

    public function oldStatusUpdate()
    {

        $dql = "SELECT DISTINCT p.proposalId
                FROM \models\Log l, \models\Proposals p
                WHERE l.proposal = p.proposalId
                AND p.proposalId > 9000
                AND p.proposalId < 9501
                AND p.statusChangeDate IS NULL
                AND l.action = 'proposal_status_update'
                AND l.statusTo IS NULL";

        $query = $this->doctrine->em->createQuery($dql);

        $results = $query->getResult();
        $i = 0;

        foreach ($results as $result) {
            $proposalId = $result['proposalId'];

            $proposal = $this->doctrine->em->find('\models\Proposals', $proposalId);
            /* @var $proposal \models\Proposals */

            $lastUpdate = $proposal->getOldStatusUpdate()->getTimeAdded();

            $proposal->setStatusChangeDate($lastUpdate);
            $this->doctrine->em->persist($proposal);

            $i++;

        }

        echo $i . ' proposals updated';

        $this->doctrine->em->flush();

    }

    public function proposalAdded()
    {
        $dql = "SELECT DISTINCT p.proposalId
                FROM \models\Log l, \models\Proposals p
                WHERE l.proposal = p.proposalId
                AND p.proposalId > 1000
                AND p.proposalId < 2001
                AND p.statusChangeDate IS NULL
                AND l.action = 'add_proposal'
                AND l.statusTo IS NULL";

        $query = $this->doctrine->em->createQuery($dql);

        $results = $query->getResult();
        $i = 0;

        foreach ($results as $result) {
            $proposalId = $result['proposalId'];

            $proposal = $this->doctrine->em->find('\models\Proposals', $proposalId);
            /* @var $proposal \models\Proposals */

            $lastUpdate = $proposal->getOldProposalAdded()->getTimeAdded();

            $sql = "UPDATE proposals SET statusChangeDate = " . $lastUpdate . " WHERE proposalId = " . $proposalId;
            $this->db->query($sql);

            $i++;

        }

        echo $i . ' proposals updated';

        $this->doctrine->em->flush();
    }

    public function proposalUpdated()
    {
        $dql = "SELECT DISTINCT p.proposalId
                FROM \models\Log l, \models\Proposals p
                WHERE l.proposal = p.proposalId
                AND p.statusChangeDate IS NULL
                AND l.action = 'update_proposal'
                AND l.statusTo IS NULL";

        $query = $this->doctrine->em->createQuery($dql);

        $results = $query->getResult();
        $i = 0;

        foreach ($results as $result) {
            $proposalId = $result['proposalId'];

            $proposal = $this->doctrine->em->find('\models\Proposals', $proposalId);
            /* @var $proposal \models\Proposals */

            $lastUpdate = $proposal->getOldProposalUpdated()->getTimeAdded();

            $sql = "UPDATE proposals SET statusChangeDate = " . $lastUpdate . " WHERE proposalId = " . $proposalId;
            $this->db->query($sql);

            $i++;

        }

        echo $i . ' proposals updated';

        $this->doctrine->em->flush();
    }

    public function created()
    {
        $company = $this->doctrine->em->find('\models\Companies', 3);

        echo $company->getFirstProposalTime();
    }

    public function branch()
    {
        $this->load->model('branchesapi');

        $accId = $this->account()->getAccountId();

        $branchAccounts = $this->branchesapi->getUsers($this->account()->getCompany()->getCompanyId(), 5);

        echo count($branchAccounts);

    }

    public function data()
    {

        $this->load->library('stats/MyQueryServlet');
        $servlet = new MyQueryServlet();
        $data = array();
        $data['servlet'] = $servlet;

        $this->load->view('test/pie', $data);

    }

    public function services()
    {

        $serviceTitles = $this->account()->getCompany()->getServiceTitles();

        foreach ($serviceTitles as $serviceTitle) {
            /* @var $serviceTitle \models\Service_titles */

            $service = $this->em->find('\models\Services', $serviceTitle->getService());
            /* @var $service \models\Services */

            if ($service->getServiceName() == 'Add New Service Here!') {
                echo '<p>' . $serviceTitle->getTitle() . ' from service ID: ' . $serviceTitle->getService() . '</p>';
                echo '<p>This is a custom service and needs to be migrated</p>';

                var_dump($service);

                $copy = clone $service;
                $copy->setServiceName('Custom Service');
                $copy->setCompany($this->account()->getCompany()->getCompanyId());

                $this->em->persist($copy);

            }

        }

        $this->em->flush();

    }

    public function helper()
    {

        $field = $this->em->find('\models\ServiceField', 207);

        $this->load->library('ServiceFieldHelper', array('account' => $this->account()));

        $this->servicefieldhelper->setField($field);

        var_dump($this->servicefieldhelper->getField());

    }

    public function migrate()
    {
        // Get a bunch of companies
        $migrateCompanies = \models\Companies::getCompaniesBatch(551, 600);

        foreach ($migrateCompanies as $company) {
            if ($company) {
                /* @var $company \models\Companies */
                $company->migrateServices();
            }
        }
    }

    public function batch()
    {
        $migrateCompanies = \models\Companies::getCompaniesBatch(0, 50);
        foreach ($migrateCompanies as $company) {
            if ($company) {
                /* @var $company \models\Companies */
                echo '<p>' . $company->getCompanyName() . '</p>';
            }
        }
    }

    public function proposalImages()
    {
        $this->load->library('/helpers/ProposalHelper', array('account' => $this->account()));

        $proposal = $this->em->findProposal(9216);
        $this->proposalhelper->setProposal($proposal);
        $this->proposalhelper->deleteImages();

    }

    public function attachments()
    {
        $this->load->library('/helpers/ProposalHelper', array('account' => $this->account()));

        $proposal = $this->em->findProposal(4090);
        $this->proposalhelper->setProposal($proposal);
        $this->proposalhelper->delete();
    }

    public function delivery()
    {

        $events = json_decode('[{"response":"250 2.0.0 OK 1430422645 w8si4824510pbs.184 - gsmtp ","sg_event_id":"1QdnD5mVTfGfNAdtIql4Gw","sg_message_id":"14d0bd55efb.5b19.10aedf.filter-375.7853.5542847215.0","event":"delivered","email":"5richkids@gmail.com","timestamp":1430422645,"smtp-id":"","proposal":52873,"category":["Proposal CC"]}]');
        var_dump($events);

        if (in_array('Proposal', $events[0]->category)) {
            echo 'THis is a proposal email';
        }

    }

    public function newProposals()
    {
        echo $this->account()->getProposalsDataTotal();
    }

    public function upload_dir()
    {
        $start = 30000;
        $finish = 50000;
        $basePath = UPLOADPATH . '/proposals';
        for ($i = $start; $i < $finish; $i++) {
            // Construct the dir path
            $dirPath = $basePath . '/' . $i;
            // Check if it's a directory
            if (is_dir($dirPath)) {
                $fileCount = 0;
                echo $dirPath . '<br />';
                // Check for a proposal
                $proposal = $this->em->findProposal($i);
                if ($proposal) {
                    try {
                        $companyId = $proposal->getClient()->getCompany()->getCompanyId();
                        if ($companyId) {
                            $files = array();
                            $di = new DirectoryIterator($dirPath);
                            foreach ($di as $file) {
                                if ($file->isFile()) {
                                    echo $file->getFilename() . '<br />';
                                    $files[] = $file->getFilename();
                                    $fileCount++;
                                }
                            }
                            echo $fileCount . ' files found<br /><br />';
                            // New Paths //
                            // Need to make sure the company directory exists
                            $companyDir = $basePath . '/' . $companyId;
                            if (!is_dir($companyDir)) {
                                echo 'Creating company dir: ' . $companyDir . '<br />';
                                mkdir($companyDir);
                            }
                            // Then make the new one
                            $newDir = $basePath . '/' . $companyId . '/' . $proposal->getProposalId();
                            if (!is_dir($newDir)) {
                                echo 'Creating proposal dir: ' . $newDir . '<br />';
                                mkdir($newDir);
                            }
                            // Dirs have been made, files can be moved
                            foreach ($files as $filename) {
                                $oldFile = $dirPath . '/' . $filename;
                                $newFile = $newDir . '/' . $filename;

                                echo "Moving file from $oldFile to $newFile<br />";
                                rename($oldFile, $newFile);
                            }
                            rmdir($dirPath);
                            echo 'Deleting ' . $dirPath . '<br />';
                            echo '<br />';
                            echo '_____________________________________________________________________________________';
                            echo '<br />';
                        } else {
                            echo 'No Company' . '<br />';
                        }
                    } catch (Exception $e) {
                        echo 'No Client' . '<br />';
                    }
                } else {
                    echo 'No Proposal<br />';
                }
            }
        }
    }

    public function fixUploadDir()
    {
        $start = time();
        $rootPath = UPLOADPATH; // eq to /var/www/vhosts/pms.pavementlayers.com/uploads
        $newPath = UPLOADPATH . '/companies';
        $scanFolder = $rootPath . '/proposals';
        set_time_limit(3600); //failsafe
        ob_implicit_flush(true);
        $scanned_folders = scandir($scanFolder);
        foreach ($scanned_folders as $proposalId) {
            if (is_numeric($proposalId)) {
                $dirPath = $scanFolder . '/' . $proposalId;
                $good = true;
                try {
                    $proposal = $proposal = $this->em->findProposal($proposalId);
                    if (!$proposal) {
                        $good = false;
                    } else {
                        $companyId = $proposal->getClient()->getCompany()->getCompanyId();
                    }
                } catch (Exception $e) {
                    $good = false;
                }
                if ($good) {
                    //proceed to move stuff
                    $newDirPath = $newPath . '/' . $companyId . '/proposals';
                    if (!is_dir($newDirPath)) {
                        mkdir($newDirPath, 0777, true);
                    }
                    $newDirPath .= '/' . $proposalId;
//                    echo 'Company #' . $companyId . ' -- Proposal #' . $proposalId . ' - ' . $proposal->getProjectName() . '<br>';
                    echo "Moving {$dirPath} to  {$newDirPath}";
                    rename($dirPath, $newDirPath); //move entire folder
                    echo " - Done!<br>";
                } else {
                    echo 'Skipped Proposal #' . $proposalId . '<br>';
                }
            }
        }
        $duration = time() - $start;
        $h = floor($duration / 3600);
        $m = floor(($duration % 3600) / 60);
        $s = floor($duration % 60);
        echo "Done! {$h}:{$m}:{$s} passed<br>";
    }

    public function clients()
    {
        $clients = $this->account()->ajaxGetClients();

        var_dump($clients);
    }

    public function setKeys()
    {
        $dql = "SELECT p FROM \models\Proposals p
        WHERE p.proposalId >= 40000";

        $query = $this->em->createQuery($dql);
        $proposals = $query->getResult();

        foreach ($proposals as $proposal) {
            $proposal->setAccessKey();
            $this->em->persist($proposal);
        }
        $this->em->flush();

        echo count($proposals) . ' proposals found';
    }

    public function geocode()
    {

        $qb = $this->doctrine->em->createQueryBuilder();
        /* @var $qb \Doctrine\ORM\QueryBuilder */

        // Select proposals
        $qb->select('l')
            ->from('\models\Leads', 'l')
            ->where('l.status = :status')
            ->andWhere('l.leadId >= 23166')
            ->andWhere('l.company = 3')
            ->setParameter('status', 'Working');

        $qb->setMaxResults(100);
        $query = $qb->getQuery();

        $leads = $query->getResult();

        foreach ($leads as $lead) {
            $lead->setLatLng();
            $this->em->persist($lead);
            $this->em->flush();
            usleep(250000);
        }
        echo $lead->getLeadId();

    }

    public function chars()
    {

        $pst = $this->em->find('\models\Proposal_services_texts', 1110228);
        $text = $pst->getText();
        $firstChar = substr($text, 0, 1);

        if ($firstChar == PHP_EOL) {
            echo 'Starts with newline';
        } else {
            echo 'No Newline';
        }

    }

    public function createAudit()
    {

        $this->load->library('psa_client', ['account' => $this->account()]);

        $auditTypeId = 1;
        $locationId = 2737;

        $apiParams = [
            'locationId' => $locationId,
            'auditType' => $auditTypeId,
        ];

        $responseObj = $this->psa_client->createAudit($apiParams);

        var_dump($responseObj);

    }

    public function clientAccounts($companyId)
    {

        ignore_user_abort(true);
        set_time_limit(0);

        $company = $this->em->find('\models\Companies', $companyId);
        /* @var \models\Companies $company */
        echo '<p>Migrating clients for ' . $company->getCompanyName() . '</p>';

        $companyClients = $company->getClients(1);
        echo '<p>' . count($companyClients) . ' clients found</p>';

        $residentialAccount = new \models\ClientCompany();
        $residentialAccount->setName('Residential');
        $residentialAccount->setOwnerCompany($company);
        $residentialAccount->setOwnerUser($company->getAdministrator());
        $residentialAccount->setCreated(time());
        $this->em->persist($residentialAccount);
        $this->em->flush();

        foreach ($companyClients as $companyClient) {
            /* @var \models\Clients $companyClient */

            // Check we have a company name
            if ($companyClient->getCompanyName(true) && ($companyClient->getCompanyName(true) != 'Residential')) {

                echo '<p>Client: ' . $companyClient->getFullName() . ' of ' . $companyClient->getCompanyName(true) . '</p>';

                $dql = "SELECT cc FROM \models\ClientCompany cc
                        WHERE cc.name = :companyName
                        AND cc.owner_company = :companyId";

                $query = $this->em->createQuery($dql);
                $query->setParameter(':companyName', $companyClient->getCompanyName(true));
                $query->setParameter(':companyId', $companyId);
                $clientAccount = $query->getOneOrNullResult();

                if (!$clientAccount) {

                    $clientAccount = new \models\ClientCompany();
                    /* @var \models\ClientCompany $newAccount */
                    $clientAccount->setName($companyClient->getCompanyName(true));
                    $clientAccount->setOwnerUser($companyClient->getAccount());
                    $clientAccount->setOwnerCompany($company);
                    $clientAccount->setCreated(time());
                    $this->em->persist($clientAccount);
                    $this->em->flush();
                }
            } else {
                $clientAccount = $residentialAccount;
            }

            $companyClient->setClientAccount($clientAccount);
            $this->em->persist($companyClient);
            $this->em->flush();
        }

        echo $company->getCompanyName() . ' clients migrated';
    }

    public function resAccount()
    {

        $company = $this->em->find('\models\Companies', 3);
        $resAcct = $company->getResidentialAccount();

        var_dump($resAcct);
    }

    public function nullClientAccounts()
    {

        ignore_user_abort(true);
        set_time_limit(0);

        $dql = "SELECT c FROM \models\Clients c
        WHERE c.client_account IS NULL";

        $query = $this->em->createQuery($dql);
        $query->setMaxResults(3000);
        $clients = $query->getResult();

        foreach ($clients as $companyClient) {
            /* @var \models\Clients $companyClient */

            echo '<p>Migrating client: ' . $companyClient->getFullName() . ' - ' . $companyClient->getClientId() . '</p>';

            $company = $companyClient->getCompany();
            /* @var \models\Companies $company */

            if ($company) {

                // Check we have a company name
                if ($companyClient->getCompanyName(true) && ($companyClient->getCompanyName(true) != 'Residential')) {

                    $dql = "SELECT cc FROM \models\ClientCompany cc
                            WHERE cc.name = :companyName
                            AND cc.owner_company = :companyId";

                    $query = $this->em->createQuery($dql);
                    $query->setParameter(':companyName', $companyClient->getCompanyName(true));
                    $query->setParameter(':companyId', $company->getCompanyId());
                    $clientAccount = $query->getOneOrNullResult();

                    if (!$clientAccount) {

                        $ownerUser = $companyClient->getAccount();

                        try {
                            $clientAccount = new \models\ClientCompany();
                            /* @var \models\ClientCompany $newAccount */
                            $clientAccount->setName($companyClient->getCompanyName(true));
                            $clientAccount->setOwnerUser($ownerUser);
                            $clientAccount->setOwnerCompany($company);
                            $clientAccount->setCreated(time());
                            $this->em->persist($clientAccount);
                            $this->em->flush();

                            echo '<p>Saved</p>';
                        } catch (\Exception $e) {
                            echo '<p>Error</p>';
                            var_dump($e);
                        }

                    }
                } else {

                    $clientAccount = null;

                    try {
                        $clientAccount = $company->findResidentialAccount();
                    } catch (\Exception $e) {

                    }

                    if (!$clientAccount) {
                        $residentialAccount = new \models\ClientCompany();
                        $residentialAccount->setName('Residential');
                        $residentialAccount->setOwnerCompany($company);
                        $residentialAccount->setOwnerUser($company->getAdministrator());
                        $residentialAccount->setCreated(time());
                        $this->em->persist($residentialAccount);
                        $this->em->flush();
                        $clientAccount = $residentialAccount;
                    }
                }

                if ($clientAccount) {
                    echo '<p>Saving client</p>';
                    $companyClient->setClientAccount($clientAccount);
                    $this->em->persist($companyClient);
                    $this->em->flush();
                }

            }
        }

    }

    public function fixOrphanAccounts()
    {
        echo 'Checking for Orphan Accounts...<br>';
        $this->load->database();
        $sql = "select cc.id, cc.owner_user, cc.owner_company from client_companies cc left join accounts on cc.owner_user = accounts.accountId where accounts.accountId is null";
        $orphans = $this->db->query($sql)->result();
        echo count($orphans) . ' found! Fixing...<br>';
        $orphansFixed = 0;
        $orphansNotFixed = 0;
        $companyAdmins = array();

        foreach ($orphans as $orphan) {
            $good = true;
            if (!isset($companyAdmins[$orphan->owner_company])) {
                $company = $this->db->query('select administrator from companies where companyId = ?',
                    array($orphan->owner_company))->result();
                if (!count($company)) {
                    $good = false;
                    //$this->db->query("delete from clients where clientId=?", array($orphan->clientId));
                    //$orphansNotFixed++;
                } else {
                    $company = $company[0];
                    $companyAdmins[$orphan->owner_company] = $company->administrator;
                }
            }
            if ($good) {
                $this->db->query('update client_companies set owner_user=? where id=? limit 1',
                    array($companyAdmins[$orphan->owner_company], $orphan->id));
                $orphansFixed++;
            }
        }
        echo "Done! {$orphansFixed} orphans fixed, and {$orphansNotFixed} orphans deleted due to company not existent!<br>";

    }

    public function auditReminders()
    {
        $proposals = $this->getProposalRepository()->getAuditReminderProposals();
        foreach ($proposals as $proposal) {
            echo '<p>' . $proposal->getProjectName() . '</p>';
        }

    }

    public function newStatus()
    {

        $companyId = 3;

        $statuses = $this->getCompanyRepository()->getStatuses($companyId);

        foreach ($statuses as $status) {
            echo '<p>' . $status->getText() . '</p>';
        }

    }

    public function addUserSub()
    {

        $user = $this->em->findAccount(911);
        $newUser = clone $user;
        $newUser->setEmail('mr.a.long+' . mt_rand(0, 5000) . '@gmail.com');
        $newUser->setExpires(time());
        $this->em->persist($newUser);
        $this->em->flush();

        $zsr = $this->getZohoSubscriptionsRepository();
        $zsr->addUser($newUser);
    }

    public function syncSubscription()
    {
        $cr = $this->getCompanyRepository();
        $pmd = $this->em->findCompany(62);

        $cr->createSubscription($pmd);
    }

    public function activeCompanies()
    {
        $cr = $this->getCompanyRepository();
        $companies = $cr->getActiveCompanies();

        foreach ($companies as $company) {
            $cr->createSubscription($company);
        }
    }

    public function testSync()
    {
        set_time_limit(600);
        $cr = $this->getCompanyRepository();

        $companies = $cr->getActiveCompanies();

        foreach ($companies as $company) {
            $cr->createSubscription($company);
        }

    }

    public function testNotes()
    {
        $cr = $this->getCompanyRepository();
        $company = $this->em->findCompany(770);

        $cr->createSubscription($company);
    }

    public function cancelSubscription()
    {
        $zr = $this->getZohoSubscriptionsRepository();

        $subscriptionId = '110710000000123780';
        $zr->cancelSubscription($subscriptionId);
    }

    /*
     * This test shows how to load
     */
    public function loadCQS()
    {
        $cr = $this->getCompanyRepository();
        $companyId = 3;
        $serviceId = 10;

        $cqs = $cr->getCompanyQbService($companyId, $serviceId);

        // Now you have an object where you can set the qbid, sync flag etc
    }

    /**
     * This test takes all the services that a company uses and puts them in the intermediate table
     */
    public function qbServices()
    {
        // Pave my Drive Example company
        $company = $this->em->findCompany(3);
        $this->getQuickbooksRepository()->migrateQbServices($company);
    }

    public function syncServices()
    {
        $company = $this->em->findCompany(3);
        $this->getQuickbooksRepository()->syncServices($company);
    }

    public function getQbCompanies()
    {
        var_dump($this->getCompanyRepository()->getQbCompanies());
    }

    public function syncContacts()
    {
        $company = $this->em->findCompany(3);
        $this->getQuickbooksRepository()->syncContacts($company);
    }

    public function syncProposals()
    {
        $company = $this->em->findCompany(3);
        $this->getQuickbooksRepository()->syncProposals($company);
    }

    public function newSendgrid()
    {
        $emailData = [
            'fromName' => SITE_NAME,
            'fromEmail' => 'no-reply@' . SITE_EMAIL_DOMAIN,
            'subject' => 'Test',
            'body' => 'THis is the email content',
            'to' => 'andy@pavementlayers.com',
            'cc' => 'mr.a.long@gmail.com',
        ];

        $this->getEmailRepository()->send($emailData);
    }

    public function domains()
    {
        $this->getSendgridRepository()->updateAddressWhitelist();
    }

    public function proposalInProgress()
    {
        $proposal = $this->em->findProposal(159799);
        $this->getProposalRepository()->sendInProgressViewEmail($proposal);
    }

    public function qbd()
    {
        $username = md5($this->account()->getCompanyId());
        $this->getQbdRepository()->add_setting_for_desktop($this->account()->getCompanyId());
        $services = $this->getQbdRepository()->get_service_list_for_queue($this->account()->getCompanyId());
        if ($services) {
            foreach ($services as $serviceId) {
                $this->getQbdRepository()->enqueue(QUICKBOOKS_ADD_SERVICEITEM, $serviceId, 0, '',
                    $username, $this->account()->getCompanyId());
            }
        }
    }

    public function serviceTitle()
    {
        $service = $this->em->findService(129);
        echo $service->getTitle(3);
    }

    public function qb_accounts()
    {
        $accs = $this->getCompanyRepository()->getQbIncomeAccounts(3);

        var_dump($accs);
    }

    public function priceFormat()
    {

        $proposalServices = $this->em->createQuery('select ps from models\Proposal_services ps where ps.proposal=177565 order by ps.ord, ps.serviceId')->getResult();

        foreach ($proposalServices as $ps) {
            $cleanPrice = str_replace(['$', ','], ['', ''], $ps->getPrice());
            $formattedPrice = number_format($cleanPrice, 2, '.', '');
            echo $formattedPrice . '<br />';
        }

    }

    public function geocodeProposal()
    {
        $proposal = $this->em->findProposal(183187);
        var_dump($this->getProposalRepository()->setLatLng($proposal));

    }

    public function mapApi()
    {

        $account = $this->account();

        $data = $this->getAccountRepository()->getMapData($account);

        var_dump($data);

    }

    public function geocodeProposals()
    {
        set_time_limit(59);

        $dql = "SELECT p
                FROM \models\Proposals p
                WHERE p.geocoded IS NULL
                AND (p.lat IS NULL AND p.lng IS NULL)
                ORDER BY p.proposalId DESC";

        $query = $this->em->createQuery($dql);
        $query->setMaxResults(80);

        $proposals = $query->getResult();

        foreach ($proposals as $proposal) {
            $this->getProposalRepository()->setLatLng($proposal);
            usleep(100000);
        }
    }

    public function leadNotifications()
    {
        $companies = \models\Companies::getAllCompanies();

        foreach ($companies as $company) {
            echo '<p>' . $company->getCompanyId() . ': ' . $company->getCompanyName() . '</p>';
            $notificationSettings = $this->getLeadNotificationsRepository()->getLeadNotificationSettings($company->getCompanyId());

            if ($notificationSettings) {
                echo '<p>Has notification settings</p>';
            } else {
                echo '<p>Creating notification settings</p>';
                $this->getLeadNotificationsRepository()->setDefaultNotificationSettings($company);
                echo '<p>Done</p>';
            }
            echo '</hr>';
        }
    }

    public function estimateTable($uuid)
    {
        $data = [];
        $data['lineItems'] = $this->getEstimationRepository()->getLineItemsByUuid('abc123');
        $this->html->addScript('dataTables');
        $this->load->view('test/estimate-table', $data);
    }

    public function qbsetting()
    {
        $this->getQbdRepository()->add_setting_for_desktop(3);
    }

    public function qbdServices()
    {
        $services = $this->getQbdRepository()->get_service_list_for_queue($this->account()->getCompanyId());
        var_dump($services);
    }

    public function pmdProposal()
    {
        populatePmd();
    }

    public function truckRoute()
    {
        $proposal = $this->em->findProposal(194923);

        $this->getProposalRepository()->getAllTruckingDirections($proposal);
    }

    public function itemBreakdown()
    {
        $lineItem = $this->em->findEstimationLineItem(10);

        $this->getEstimationRepository()->getItemPriceBreakdown($lineItem);
    }

    public function phaseBreakdown()
    {
        $proposal = $this->em->findProposal(194923);

        $proposalServices = $proposal->getServices();

        foreach ($proposalServices as $proposalService) {

            echo '<h2>Service: ' . $proposalService->getServiceName() . '</h2>';

            $servicePhases = $this->getEstimationRepository()->getProposalServicePhases($proposalService);

            // Check we have phases
            if (!count($servicePhases)) {
                echo '<p>This service does not have a phase!</p>';
                echo '<p>Creating default phase</p>';
                $this->getEstimationRepository()->createDefaultPhase($proposalService);
                // Reload phases to account for new one
                $servicePhases = $this->getEstimationRepository()->getProposalServicePhases($proposalService);
            }

            // Then loop through phases as this will pick up any defaults created
            foreach ($servicePhases as $servicePhase) {
                echo '<h3>' . "Phase: " . $servicePhase->getName() . "</h3>";

                $parentItems = $this->getEstimationRepository()->getPhaseParentItems($servicePhase);

                if (count($parentItems)) {
                    ?>
                    <table width="80%">
                        <thead>
                        <tr>
                            <th>Item</th>
                            <th></th>
                            <th>Qty</th>
                            <th>Unit</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
foreach ($parentItems as $parentItem) {
                        /* @var \models\EstimationLineItem $parentItem */
                        ?>
                            <tr>
                                <td><?php echo $parentItem->getItem()->getName() ?></td>
                                <td></td>
                                <td><?php echo $parentItem->getQuantity(); ?></td>
                                <td><?php echo $parentItem->getItem()->getUnitModel()->getName(); ?></td>
                            </tr>
                            <?php
$childItems = $this->getEstimationRepository()->getItemChildItems($parentItem);

                        if (count($childItems)) {

                            foreach ($childItems as $childItem) {
                                ?>
                                    <tr>
                                        <td></td>
                                        <td><?php echo $childItem->getItem()->getName() ?></td>
                                        <td><?php echo $childItem->getQuantity(); ?></td>
                                        <td><?php echo $childItem->getItem()->getUnitModel()->getName(); ?></td>
                                    </tr>
                                    <?php
}
                        }
                    }
                    ?>
                        </tbody>
                    </table>
                    <?php
}
            }
        }
    }

    public function itemCompare()
    {
        $oldItem = $this->em->findEstimationLineItem(14);
        $newItem = $this->em->findEstimationLineItem(15);

        echo $this->getEstimationRepository()->getLineItemsDifferencesString($oldItem, $newItem);
    }

    public function updateEstimateLineItemBasePrice($item_id, $new_base_price)
    {

        $this->load->database();
        $sql = "SELECT eli.base_price,eli.total_price,eli.quantity,eli.overhead_rate,eli.overhead_price,eli.profit_rate,eli.profit_price,eli.tax_rate,eli.tax_price,eli.proposal_id,eli.id,eli.item_id
        FROM estimate_line_items as eli
        LEFT JOIN proposals as ps ON eli.proposal_id = ps.proposalId
        AND ps.status = 'Open'
        WHERE eli.item_id = '$item_id'";

        $results = $this->db->query($sql)->result();
        foreach ($results as $result) {
            echo 'estimate Line-</br>';
            echo 'Item Quantity-' . $result->quantity . '</br>';
            echo 'old base Price-' . $result->base_price . '</br>';
            echo 'old overhead_rate-' . $result->overhead_rate . '</br>';
            echo 'old overheadPrice-' . $result->overhead_price . '</br>';

            echo 'old profitRate-' . $result->profit_rate . '</br>';
            echo 'old profitPrice-' . $result->profit_price . '</br>';

            echo 'old tax_rate-' . $result->tax_rate . '</br>';
            echo 'old taxPrice-' . $result->tax_price . '</br>';

            echo 'old line_total-' . $result->total_price . '</br>';
            $tempoverheadPrice = (($new_base_price * $result->overhead_rate) / 100);
            $tempprofitPrice = (($new_base_price * $result->profit_rate) / 100);
            $temptaxPrice = (($new_base_price * $result->tax_rate) / 100);
            echo 'single unit overhead price-' . $tempoverheadPrice . '</br>';
            echo 'single unit profit price-' . $tempprofitPrice . '</br>';
            echo 'single unit tax price-' . $temptaxPrice . '</br>';
            $overheadPrice = $tempoverheadPrice * $result->quantity;
            $profitPrice = $tempprofitPrice * $result->quantity;
            $taxPrice = $temptaxPrice * $result->quantity;

            echo 'new base Price-' . $new_base_price . '</br>';

            echo 'new overheadPrice-' . $overheadPrice . '</br>';

            echo 'new profitPrice-' . $profitPrice . '</br>';
            echo 'new taxPrice-' . $taxPrice . '</br>';
            //$t = $result->overhead_price + $result->profit_price + $result->tax_price;
            //$y = $result->total_price - $t;
            $trr = $result->quantity * $new_base_price;
            $new_line_total = $trr + $overheadPrice + $profitPrice + $taxPrice;
            //$new_line_total = $y +$overheadPrice + $profitPrice + $taxPrice;
            echo 'new_line_total-' . $new_line_total . '</br>';

            $estimationLineItem = $this->doctrine->em->find('\models\EstimationLineItem', $result->id);
            $estimationLineItem->setBasePrice($new_base_price);
            $estimationLineItem->setOverheadPrice($overheadPrice);
            $estimationLineItem->setProfitPrice($profitPrice);
            $estimationLineItem->setTaxPrice($taxPrice);
            $estimationLineItem->setTotalPrice($new_line_total);
            $this->doctrine->em->persist($estimationLineItem);
            echo '==========================================</br>';
        }

        $this->doctrine->em->flush();

    }

    public function serviceField($fieldId)
    {
        $serviceField = $this->em->findServiceField($fieldId);

        $csef = $this->getEstimationRepository()->getEstimateServiceField($this->account()->getCompany(),
            $serviceField);

        var_dump($csef);
    }

    public function serviceFields($serviceId)
    {

        $company = $this->account()->getCompany();
        $service = $this->em->findService($serviceId);

        echo '<h2>' . $service->getServiceName() . '</h2>';

        $fields = $company->getServiceFields($serviceId);
        ?>
        <table>
            <thead>
            <tr>
                <th>Field</th>
                <th>Measurement</th>
                <th>Unit</th>
                <th>Depth</th>
                <th>Area</th>
                <th>Length</th>
                <th>Quantity</th>
                <th>Gravel Depth</th>
            </tr>
            </thead>
            <tbody>
            <?php
foreach ($fields as $field) {

            $cesf = $this->getEstimationRepository()->getEstimateServiceField($company, $field);
            ?>
                <tr>
                    <td><strong><?php echo $field->getFieldName(); ?></strong></td>
                    <td><?php echo $cesf->getMeasurement(); ?></td>
                    <td><?php echo $cesf->getUnit(); ?></td>
                    <td><?php echo $cesf->getDepth(); ?></td>
                    <td><?php echo $cesf->getArea(); ?></td>
                    <td><?php echo $cesf->getLength(); ?></td>
                    <td><?php echo $cesf->getQty(); ?></td>
                    <td><?php echo $cesf->getGravelDepth(); ?></td>
                </tr>
                <?php
}
        ?>
            </tbody>
        </table>
        <?php
}

    public function compareServices()
    {
        $company = $this->account()->getCompany();
        $proposalService1 = $this->em->findProposalService(473416);
        $proposalService2 = $this->em->findProposalService(473416);
        $service1Fields = $this->getProposalRepository()->getIndexedSavedProposalServiceFields($proposalService1);
        $service2Fields = $this->getProposalRepository()->getIndexedSavedProposalServiceFields($proposalService2);

        $changes = $this->getProposalRepository()->getProposalServiceDifferences($proposalService1, $proposalService2);

        var_dump($changes);

    }

    public function defaultStages($serviceId)
    {
        $stages = $this->getEstimationRepository()->getDefaultStages($serviceId);

        var_dump($stages);
    }

    public function estimateBreakdown($proposalId)
    {
        $proposal = $this->em->findProposal($proposalId);

        $price = $proposal->getPrice();
        $breakdownData = $this->getEstimationRepository()->getProposalPriceBreakdown($proposalId);

        // Time for some math
        $totalPrice = $price;
        $basePrice = $breakdownData['basePrice'];
        $profitPrice = $breakdownData['profitPrice'];
        $profitMargin = $profitPrice / $basePrice;
        $overheadPrice = $breakdownData['overheadPrice'];
        $overheadMargin = $overheadPrice / $basePrice;

        // Assemble the data

        $out = [
            'totalPrice' => '$' . number_format($price),
            'basePrice' => '$' . number_format($basePrice),
            'profitPrice' => $profitPrice,
            'profitMargin' => number_format($profitMargin, 5) . '%',
            'overheadPrice' => $profitPrice,
            'overheadMargin' => number_format($overheadMargin, 5) . '%',
        ];

        var_dump($out);
    }

    public function check_calculator()
    {
        $this->load->view('test/check_calculator');
    }

    public function new_check_cal()
    {
        $measuremnt = $this->input->post('measurement');
        $depth = $this->input->post('depth');
        $measurement_unit = $this->input->post('unit_type');
        $item_base_price = $this->input->post('item_base_price');
        $overheadRate = $this->input->post('overheadRate');
        $profitRate = $this->input->post('profitRate');
        $taxRate = $this->input->post('taxRate');
        $t = $this->getEstimationRepository()->calculate_measurement($measuremnt, $depth, $item_base_price,
            $overheadRate, $profitRate, $taxRate, $measurement_unit);
        echo '<pre>';
        print_r($t);
        die;
    }

    public function testCalc()
    {
        $calculator = new Pms\Calculators\Material\Asphalt();
        $calculator->setMeasurement(5000);
        $calculator->setDepth(3);
        $calculator->setUnit('square yard');
        $calculator->setItemBasePrice(50.00);
        $calculator->setOhRate(10.00);
        $calculator->setPmRate(10.00);
        $calculator->setTaxRate(0);
        $result = $calculator->run();

        var_dump($result);
    }

    public function testCalc2()
    {
        $calculator = new Pms\Calculators\Material\CrackSealing();
        $calculator->setWidth(4);
        $calculator->setDepth(4);
        $calculator->setLength(600);
        $calculator->setItemBasePrice(45.00);
        $calculator->setOhRate(10.00);
        $calculator->setPmRate(10.00);
        $calculator->setTaxRate(0);
        $result = $calculator->run();

        var_dump($result);
    }

    public function testCalc3()
    {
        $calculator = new Pms\Calculators\Material\ConcreteCalculator();
        $calculator->setMeasurement(12000);
        $calculator->setDepth(4);
        $calculator->setItemBasePrice(50.00);
        $calculator->setOhRate(10.00);
        $calculator->setPmRate(10.00);
        $calculator->setTaxRate(0);
        $result = $calculator->run();

        var_dump($result);
    }

    public function testCalc4()
    {
        $calculator = new Pms\Calculators\Material\LineStripingCalculator();
        $calculator->setLength(4000);
        $calculator->setColor(320);
        $calculator->setPailSize(0);
        $calculator->setItemBasePrice(45.00);
        $calculator->setOhRate(10.00);
        $calculator->setPmRate(10.00);
        $calculator->setTaxRate(0);
        $result = $calculator->run();

        var_dump($result);
    }

    public function testCalc5()
    {
        $calculator = new Pms\Calculators\Material\SealCoatCalculator();
        $calculator->setArea(11000);
        $calculator->setApplicationRate(0.1);
        $calculator->setItemBasePrice(8.00);
        $calculator->setOhRate(10.00);
        $calculator->setPmRate(10.00);
        $calculator->setTaxRate(0);
        $result = $calculator->run();

        var_dump($result);
    }

    public function testCalc6()
    {
        $calculator = new Pms\Calculators\Material\TruckingCalculator();
        $calculator->setTons(660);
        $calculator->setCapacity(15);
        $calculator->setTripTime(30);
        $calculator->setPlantTime(0.25);
        $calculator->setSiteTime(0.25);
        $calculator->setDays(1);
        $calculator->setHoursPerDay(8);
        $calculator->setItemBasePrice(60.00);
        $calculator->setOhRate(10.00);
        $calculator->setPmRate(10.00);
        $calculator->setTaxRate(0);
        $result = $calculator->run();
        echo '<pre>';
        print_r($result);
    }

    public function update_item_price()
    {
        $item_id = 23;
        $estimate_status = 2;
        $item_base_price = 40;
        $postohRate = 7;
        $postpmRate = 8;
        echo '<pre>';
        // $dql = 'SELECT pl FROM \models\Proposals pl
        //         WHERE pl.estimate_status_id ='.$estimate_status;
        // $query = $this->doctrine->em->createQuery($dql);

        // $proposals = $query->getResult();
        $company = $this->account()->getCompany();

        $proposals = $this->getEstimationRepository()->getCompanyProposalsByEstimateStatus($company, $estimate_status);

        foreach ($proposals as $proposal) {
            //print_r($proposal->getProposalId());die();
            // echo $proposal->getProposalId();
            $proposalId = $proposal->getProposalId();

            $dql1 = 'SELECT eli FROM \models\EstimationLineItem eli
            WHERE eli.item_id =  ' . $item_id . ' AND eli.proposal_id = ' . $proposalId;

            $query = $this->doctrine->em->createQuery($dql1);
            $lineItems = $query->getResult();

            foreach ($lineItems as $lineItem) {

                /* @var $lineItem \models\EstimationLineItem */
                if ($lineItem->getSubId() > 0) {

                } else {
                    echo $lineItem->getId();
                    echo '<br>';
                    $log_msg = $lineItem->getItem()->getName() . " item updated for Service: " . $lineItem->getProposalService()->getServiceName() . '<br/>';
                    $add_log = false;
                    if ($proposal->getEstimateCalculationType() == 2) {

                        $ohRate = $postohRate;
                        $pmRate = $postpmRate;
                        if ($postpmRate != $lineItem->getProfitRate()) {
                            $log_msg .= 'Adjusted PM rate from ' . number_format($lineItem->getProfitRate(),
                                2) . '% to ' . number_format($postpmRate, 2) . '%';
                            $log_msg .= '<br/>';
                            $add_log = true;
                        }
                        if ($postohRate != $lineItem->getOverheadRate()) {
                            $log_msg .= 'Adjusted OH rate from ' . number_format($lineItem->getOverheadRate(),
                                2) . '% to ' . number_format($postohRate, 2) . '%';
                            $log_msg .= '<br/>';
                            $add_log = true;
                        }

                    } else {
                        $ohRate = $lineItem->getOverheadRate();
                        $pmRate = $lineItem->getProfitRate();

                    };

                    // Item unit price before PM/OH
                    $itemBaseUnitPrice = $item_base_price;
                    if ($itemBaseUnitPrice != $lineItem->getBasePrice()) {
                        $log_msg .= 'Adjusted Base Price from $' . number_format($lineItem->getBasePrice(),
                            2) . ' to $' . number_format($itemBaseUnitPrice, 2) . '';
                        $log_msg .= '<br/>';
                        $add_log = true;
                    }
                    $old_unit_price = $lineItem->getUnitPrice();
                    $old_total_price = $lineItem->getTotalPrice();
                    // Base Price is the new unit price * qty
                    $itemBasePrice = ($itemBaseUnitPrice * $lineItem->getQuantity());
                    // Get OH unit rate
                    $itemUnitOhRate = $itemBaseUnitPrice * ($ohRate / 100);
                    // Calculate the OH price
                    $itemOhPrice = $itemBasePrice * ($ohRate / 100);
                    // Get PM unit rate
                    $itemUnitPmRate = $itemBaseUnitPrice * ($pmRate / 100);
                    // Calculate the PM price
                    $itemPmPrice = $itemBasePrice * ($pmRate / 100);
                    // Add together and then round
                    $totalUnitPrice = ($itemBaseUnitPrice + $itemUnitOhRate + $itemUnitPmRate);
                    // Calculate pre tax price
                    $itemPreTaxPrice = ($totalUnitPrice * $lineItem->getQuantity());
                    // Calculate the tax
                    $itemTaxPrice = $itemPreTaxPrice * ($lineItem->getTaxRate() / 100);

                    // Total Price
                    $itemTotalPrice = $itemBasePrice + $itemOhPrice + $itemPmPrice + $itemTaxPrice;

                    // Update the line item
                    $lineItem->setBasePrice(round($item_base_price, 2));
                    $lineItem->setOverheadRate(round($ohRate, 2));
                    $lineItem->setOverheadPrice(round($itemOhPrice, 2));
                    $lineItem->setProfitRate(round($pmRate, 2));
                    $lineItem->setProfitPrice(round($itemPmPrice, 2));
                    $lineItem->setUnitPrice(round($totalUnitPrice, 2));
                    $lineItem->setTaxPrice(round($itemTaxPrice, 2));
                    $lineItem->setTotalPrice(round($itemTotalPrice, 2));
                    $this->em->persist($lineItem);

                    if ($add_log) {
                        $log_msg .= 'Adjusted Unit Price from $' . number_format($old_unit_price,
                            2) . ' to $' . number_format($totalUnitPrice, 2) . '';
                        $log_msg .= '<br/>';
                        $log_msg .= 'Adjusted Total Price from $' . number_format($old_total_price,
                            2) . ' to $' . number_format($itemTotalPrice, 2) . '';
                        $log_msg .= '<br/>';
                        $this->getEstimationRepository()->addLog(
                            $this->account(),
                            $proposalId,
                            'update_item',
                            $log_msg
                        );
                    }

                }
            }
            $this->em->flush();
            updateProposalPrice($proposalId);
        }
        //print_r($proposals);die;
    }

    public function test_defualt_temp()
    {
        $pmd = $this->em->findCompany(138);
        $this->getEstimationRepository()->createDefaultTemplates($pmd);
    }

    public function test_default_proposal()
    {
        $company = $this->account()->getCompany();
        $this->getEstimationRepository()->createDemoCustomer($company);
    }

    public function get_lat_long()
    {
        $address = '3814 West Street,Cincinnati';
        $apiKey = 'AIzaSyBeuXgI6iCFUU2T34ysJMnd_LY8sdBkMlA'; // Google maps now requires an API key.
        // Get JSON results from this request
        $geo = file_get_contents('https://maps.googleapis.com/maps/api/geocode/json?address=' . urlencode($address) . '&sensor=false&key=' . $apiKey);
        $geo = json_decode($geo, true); // Convert the JSON to an array
        print_r($geo);
        die;
        //$geocode = file_get_contents('http://maps.google.com/maps/api/geocode/json?key=AIzaSyAAwPTBepSPhx3vqo0g5p4-axKBMw6wrq8&address='.$address.'&sensor=false');

        // $output= json_decode($geocode);

        // echo $lat = $output->results[0]->geometry->location->lat;
        // echo '<br/>';
        // echo $long = $output->results[0]->geometry->location->lng;
    }

    public function test_percent()
    {
        $proposal = $this->em->findProposal(195843);
        $this->getEstimationRepository()->calculate_estimate_completion_percentage(195843);
    }

    public function pricePer($proposalServiceId)
    {
        // Load the service
        $proposalService = \models\Proposal_services::find($proposalServiceId);

        // Get the type

        // Get the measurement and unit

        // Get the Price

        // Do the math

        // Return price per unit
    }

    public function demo_estimate()
    {
        $company = $this->account()->getCompany();
        $account = $this->account();
        // $client = $this->em->find('models\Clients','87364');
        /*
         * Step 1 - create clients
         */
        //mike@pavementlayers.com
        // check if client exist

        $client = $this->em->getRepository('models\Clients')->findOneBy(array(
            'email' => 'mike@pavementlayers.com',
            'company' => $company->getCompanyId(),
        ));

        if (!$client) {

            $clientAccount1 = new \models\ClientCompany();
            $clientAccount1->setCreated(time());
            $clientAccount1->setOwnerCompany($company);
            $clientAccount1->setOwnerUser($account);
            $clientAccount1->setName('Acme Apartments');
            $this->em->persist($clientAccount1);
            $this->em->flush();

            $client = new models\Clients();
            $client->setFirstName('Mike');
            $client->setLastName('Barrett');
            $client->setBusinessPhone('513-477-2727');
            $client->setEmail('mike@pavementlayers.com');
            $client->setCellPhone('513-477-2727');
            $client->setFax('');
            $client->setTitle('Property Manager');
            $client->setState('OH');
            $client->setWebsite(site_url());
            $client->setAddress('123 Main Street');
            $client->setCity('Cincinnati');
            $client->setZip('45227');
            $client->setCountry('USA');
            $client->setAccount($account);
            $client->setCompany($company);
            $client->setClientAccount($clientAccount1);
            $this->em->persist($client);
            $this->em->flush();
        }
        //print_r($client);die;
        $this->getEstimationRepository()->create_demo_estimate($company, $account, $client);
    }

    public function generate_proposal_uuid()
    {

        //$dql = 'SELECT pr.* FROM \models\Proposals pr WHERE proposal_uuid IS NULL ORDER BY pr.proposalId ASC LIMIT 1';
        $q = $this->em->createQuery('SELECT pr FROM models\Proposals pr WHERE pr.proposal_uuid IS NULL ORDER BY pr.proposalId ASC ');
        $q->setMaxResults(500);
        $proposals = $q->getResult();

        foreach ($proposals as $proposal) {

            $uuid = Uuid::uuid4();

            $proposal->setProposalUuid2($uuid);
            $this->em->persist($proposal);
            $this->em->flush();

        }
        echo count($proposals);
        die;
    }

    public function test_file_c()
    {

        $myfile = fopen("newfile2.txt", "w") or die("Unable to open file!");
        //$datas = file_get_contents("php://input");
        //$txt = 'heehehe';
        //$json = file_get_contents('php://input');
        //$obj = json_encode($json);
        if ($_SERVER["CONTENT_TYPE"] == 'application/json') {
            $obj = json_decode(file_get_contents('php://input'));
        } else {
            $obj = $_POST;
            print_r($obj['proposalViewId']);die;
        }

        fwrite($myfile, $obj->proposalViewId);
        $txt = "sunil123123123 \n";
        fwrite($myfile, $txt);
        fclose($myfile);
    }

    public function test_worker()
    {
        $this->load->library('jobs');
       for($i=0;$i<3000;$i++){
            // Save the opaque image
            $this->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'test', [$i], 'test job');
       }
        
    }

    public function get_failed_queue()
    {
        $this->load->library('jobs');
        var_dump($this->jobs->get_stat('failed'));

    }

    public function destroy_job()
    {
        $this->load->library('jobs');
        $this->jobs->destroy(QUEUE_EMAIL);
    }

    public function work()
    {
        //set_time_limit(0);
        $this->load->library('jobs');
        var_dump($this->jobs->worker('worker', QUEUE_HIGH));
    }

    public function get_queue_size()
    {
        $this->load->library('jobs');
        var_dump($this->jobs->get_stat(QUEUE_HIGH));
    }

    public function work_email()
    {
        $this->load->library('jobs');
        var_dump($this->jobs->worker('worker', $_ENV['QUEUE_EMAIL']));
    }

    public function work_email_check()
    {
        $this->load->library('jobs');
        $data_read = file_get_contents("redisQueueLogTime.log");
        $time = time();
        
        if( ($time - $data_read) > 30 ){
            var_dump($this->jobs->worker('worker', $_ENV['QUEUE_EMAIL']));
        }else{
            echo 'test';
        }
        
    }

    public function work_high()
    {
        $this->load->library('jobs');
        var_dump($this->jobs->worker('worker', $_ENV['QUEUE_HIGH']));
    }

    public function sendTestEmail()
    {
        $this->load->model('system_email');
        $this->system_email->send_mail('sunilyadav.acs@gmail.com', 'Queue Test', 'Test email');

        $myfile = fopen("newfileyadav1.txt", "w") or die("Unable to open file!");
        $data = 'Sunil';
        $txt = $data . "\n";
        fwrite($myfile, $txt);

        fclose($myfile);
    }

    public function emailQueue()
    {
        $this->load->library('jobs');

        for ($i = 1; $i < 5; $i++) {

            $this->jobs->create($_ENV['QUEUE_EMAIL'], 'test', 'sendTestEmail', ['Email'], 'test email');
        }
        echo 'Sent ' . ($i) . ' emails';
    }

    public function account_image_process()
    {
        // $CI =& get_instance();
        //print_r($CI);die;
        //$this->load->model('system_email');
        //$this->system_email->send_mail('sunil@itsabacus.com', 'image Test', 'image Test');
        //$company_id = $_POST[0];
        //$data = json_encode($_POST);
        $data = $this->uri->segment(2);
        // $data1 = json_encode($_GET);
        $data1 = $this->uri->segment(3);
        $fp = fopen('php://input', 'r');
        $data2 = json_encode(stream_get_contents($fp));
        // $company_id = $_POST[0];
        // $opacity = $_POST[1];
        // $pct = floor($opacity * 100);
        // $manager = new ImageManager();
        // $originalFileName = UPLOADPATH . '/clients/logos/bg-' . $company_id . '-orig.png';
        // $fileName = UPLOADPATH . '/clients/logos/bg-' . $company_id . '.png';

        // if (file_exists($originalFileName)){

        //     $img = $manager->make($originalFileName);
        //     $img->opacity($pct);
        //     $img->save($fileName);
        // }else{
        //    // $this->system_email->send_mail('sunil@itsabacus.com', 'image not Test', 'image not Test');
        // }
        $myfile = fopen("newfile1.txt", "w") or die("Unable to open file!");
        //$data = $_POST[1];
        $txt = $data . "\n";
        fwrite($myfile, $txt);
        $txt = $data1 . "\n";
        fwrite($myfile, $txt);
        $txt = $data2 . "\n";
        fwrite($myfile, $txt);
        $txt = 'data22' . "\n";
        fwrite($myfile, $txt);
        fclose($myfile);

    }

    public function test_group_resend()
    {
        set_time_limit(0);
        $this->getEmailRepository()->send($_POST);
        $myfile = fopen("newfile1.txt", "w") or die("Unable to open file!");
        $data = print_r($_POST, true);

        $txt = $data . "\n";
        fwrite($myfile, $txt);
        $data2 = json_decode($data);
        $frname = $_POST['fromName'];
        $fromEmail = $_POST['fromEmail'];
        $txt = $frname . "\n";
        fwrite($myfile, $txt);
        $txt = $fromEmail . "\n";
        fwrite($myfile, $txt);
        $txt = 'rrrr' . "\n";
        fwrite($myfile, $txt);

        fclose($myfile);
    }

    public function clear_queue()
    {
        $this->load->library('jobs');
        $this->jobs->clear('low');
        var_dump($this->jobs->clear($_ENV['QUEUE_EMAIL']));
       // var_dump($this->jobs->clear(QUEUE_EMAIL));

    }

    public function env()
    {
        echo 'Prod: ' . PROD;
    }

    public function test_error()
    {
        echo $test->getData();
        trigger_error("Fatal error", E_USER_ERROR);
        echo 'hello';
    }

    public function session()
    {

        echo 'Session';
        log_message('error', 'Test Session Function');

    }

    public function get_week_stats($userId)
    {
        $data = [];
        // $dashboardStats = $this->getDashboardStatsRepository();

        $range = 'week';
        $time = getRangeStartFinish($range);

        //$companyId = $this->account()->getCompany()->getCompanyId();

        $account = $this->em->findAccount($userId);

        // Totals
        $data['user_fullname'] = $account->getFullname();
        $data['user_id'] = $account->getAccountId();
        $data['proposalCount'] = $account->getRangeCreatedProposals($time, true);
        $data['proposalValue'] = $account->getRangeCreatedProposalsPrice($time);
        $data['avgValue'] = $data['proposalCount'] ? (readableValue($data['proposalValue'] / $data['proposalCount'])) : 0;
        $data['readableTotalValue'] = readableValue($data['proposalValue']);

        // Won
        $data['wonProposalCount'] = $account->getRangeWonProposals($time, true);
        $wonVal = $account->getRangeMagicNumber($time,
            $account->getCompany()->getDefaultStatus(\models\Status::WON));
        $data['wonValue'] = readableValue($wonVal);

        /*Leads Stuff*/
        //$data = array_merge($data,$dashboardStats->getCompanyStats($this->account()->getCompany()->getCompanyId(), $time['start'],$time['finish'], $this->uri->segment(3)));
        // echo '<pre>';
        //print_r($data);
        return $data;
    }

    public function get_year_stats($userId)
    {
        $data = [];
        // $dashboardStats = $this->getDashboardStatsRepository();

        $range = 'year';
        $time = getRangeStartFinish($range);

        //$companyId = $this->account()->getCompany()->getCompanyId();

        $account = $this->em->findAccount($userId);

        // Totals
        $data['user_fullname'] = $account->getFullname();
        $data['user_firstname'] = $account->getFirstname();
        $data['user_lastname'] = substr($account->getFirstname(), 0, 1) . '. ' . $account->getLastname();
        $data['user_id'] = $account->getAccountId();
        $data['proposalCount'] = $account->getRangeCreatedProposals($time, true);
        $data['proposalValue'] = $account->getRangeCreatedProposalsPrice($time);
        $data['avgValue'] = $data['proposalCount'] ? (readableValue($data['proposalValue'] / $data['proposalCount'])) : 0;
        $data['mobileAvgValue'] = $data['proposalCount'] ? (mobileReadableValue($data['proposalValue'] / $data['proposalCount'])) : 0;
        $data['readableTotalValue'] = readableValue($data['proposalValue']);
        $data['mobileReadableTotalValue'] = mobileReadableValue($data['proposalValue']);

        // Won
        $data['wonProposalCount'] = $account->getRangeWonProposals($time, true);
        $wonVal = $account->getRangeMagicNumber($time,
            $account->getCompany()->getDefaultStatus(\models\Status::WON));
        $data['wonValue'] = readableValue($wonVal);

        /*Leads Stuff*/
        //$data = array_merge($data,$dashboardStats->getCompanyStats($this->account()->getCompany()->getCompanyId(), $time['start'],$time['finish'], $this->uri->segment(3)));
        // echo '<pre>';
        //print_r($data);
        return $data;
    }

    public function send_weekly_report()
    {
        $this->load->library('jobs');
        $users = $this->getProposalRepository()->getAllWeeklyReportUsers();
        print_r($users);
        foreach ($users as $user) {
            $this->jobs->create($_ENV['QUEUE_EMAIL'], 'test', 'job_send_weekly_report', ['accountId' => $user->accountId],
                'test email');
        }

        echo 'run job';

    }

    public function job_send_weekly_report()
    {

        $account = $this->em->find('\models\Accounts', $_POST['accountId']);
        $table_html = '<table width="100%"><thead ><tr><th style="padding-bottom: 5px;" >User</th><th style="padding-bottom: 5px;">Bids</th><th style="padding-bottom: 5px;">Bid $</th><th style="padding-bottom: 5px;">Bids Won</th><th style="padding-bottom: 5px;">Won $</th></tr><thead>';

        if ($account->hasFullAccess()) {
            $companyUsers = $this->getCompanyRepository()->getSalesAccounts($account->getCompanyId());

            foreach ($companyUsers as $user) {

                $company_users_data = $this->get_week_stats($user->getAccountId());

                $table_html .= '<tbody><tr>
                                    <td style="text-align:left;font-weight:bold;">' . $company_users_data['user_fullname'] . '</td>
                                    <td style="text-align:center">' . $company_users_data['proposalCount'] . '</td>
                                    <td style="text-align:center">$' . $company_users_data['readableTotalValue'] . '</td>
                                    <td style="text-align:center">' . $company_users_data['wonProposalCount'] . '</td>
                                    <td style="text-align:center">$' . $company_users_data['wonValue'] . '</td></tr><tbody>';

            }

        } else {
            if ($account->isBranchAdmin()) {
                $branchUsers = $this->getCompanyRepository()->getSalesAccounts($account->getCompanyId(),
                    $account->getBranch());

                foreach ($branchUsers as $user) {
                    $branch_users_data = $this->get_week_stats($user->getAccountId());

                    $table_html .= '<tr>
                                    <td style="text-align:left;font-weight:bold;">' . $branch_users_data['user_fullname'] . '</td>
                                    <td style="text-align:center">' . $branch_users_data['proposalCount'] . '</td>
                                    <td style="text-align:center">$' . $branch_users_data['readableTotalValue'] . '</td>
                                    <td style="text-align:center">' . $branch_users_data['wonProposalCount'] . '</td>
                                    <td style="text-align:center">$' . $branch_users_data['wonValue'] . '</td></tr>';

                }

            } else {

                $user_data = $this->get_week_stats($_POST['accountId']);

                $table_html .= '<tr>
                                    <td style="text-align:left;font-weight:bold;">' . $user_data['user_fullname'] . '</td>
                                    <td style="text-align:center">' . $user_data['proposalCount'] . '</td>
                                    <td style="text-align:center">$' . $user_data['proposalValue'] . '</td>
                                    <td style="text-align:center">' . $user_data['wonProposalCount'] . '</td>
                                    <td style="text-align:center">$' . $user_data['wonValue'] . '</td></tr>';

            }
        }

        $email_template = $this->em->findAdminTemplate(29);
        $email_content = str_replace("{reportContent}", $table_html, $email_template->getTemplateBody());
        $this->load->model('system_email');
        $this->system_email->categories = ['Weekly Report'];
        $this->system_email->send_mail($account->getEmail(), $email_template->getTemplateSubject(), $email_content);

        // }
    }

    public function send_monthly_report()
    {
        $this->load->library('jobs');
        $users = $this->getProposalRepository()->getAllMonthlyReportUsers();

        foreach ($users as $user) {
            $this->jobs->create($_ENV['QUEUE_EMAIL'], 'test', 'job_send_monthly_report', ['accountId' => $user->accountId],
                'test email');
        }

        echo 'run job';

    }

    public function job_send_monthly_report()
    {
        $companyRepo = $this->getCompanyRepository();

        $from = date('Y-m-d', strtotime('first day of last month'));
        $to = date('Y-m-d', strtotime('last day of last month'));

        $job_account_id = $_POST['accountId'];
        //$job_account_id = 1902;
        $startTime = new Carbon($from . '00:00:00');
        $endTime = new Carbon($to);

        $weekdays = $startTime->diffInWeekdays($endTime);
        // $users = $this->getProposalRepository()->getAllMonthlyReportUsers();
        //print_r($users);
        //foreach($users as $user){
        //$job_account_id =   $user->accountId;
        $job_account = $this->em->find('\models\Accounts', $job_account_id);
        // Otherwise, the user/branch is being specified and we need to load the relevant accounts
        if ($job_account->hasFullAccess()) {
            $accounts = $companyRepo->getSalesAccounts($job_account->getCompanyId());

        } else {
            if ($job_account->isBranchAdmin()) {
                $accounts = $companyRepo->getSalesAccounts($job_account->getCompanyId(),
                    $job_account->getBranch());

            } else {
                $accounts = [
                    $job_account,
                ];
            }
        }

        // Now we have the account(s) and can process the data in the same way for all
        $data = array();

        $salesTargetStats = $this->getSalesTargetsRepository();
        $table_html = '<table width="100%"><thead ><tr><th style="padding-bottom: 5px;" >User</th><th style="padding-bottom: 5px;">Sales</th><th style="padding-bottom: 5px;">Win $</th><th style="padding-bottom: 5px;">Bid</th><th style="padding-bottom: 5px;">Goal $ (YR)</th></tr><thead>';
        foreach ($accounts as $account) {
            /* @var $account \models\Accounts */

            $targets = $salesTargetStats->getConfig($account->getCompanyId(), $account->getAccountId());

            // Dates now have to be calculate per user in case of varying start times
            $startTime = new Carbon($from);
            $endTime = new Carbon($to);

            $startTimeString = '';
            if ($targets['start_date'] > $startTime->timestamp) {
                $startTime = Carbon::createFromTimestamp($targets['start_date']);
                $startTimeString = '<a href="#" class="right tiptipright iconLink" onclick="return false" title="User Start Date is ' . $startTime->format('m/d/y') . '. Targets are adjusted to account for this."><i class="fa fa-fw fa-calendar"></i></a>';
            }

            // Calculate weekdays
            $weekdays = $startTime->diffInWeekdays($endTime);

            // Get the stats
            $stats = $salesTargetStats->getUserStats($account, $from, $to);

            // Win rate
            $targetWinRate = $targets['win_rate'];
            $winRate = $stats['win_rate'];

            // Sales Target
            $currentSalesTarget = ($targets['sales_per_day'] * $weekdays);

            // Bid Target
            $targetBidPerDay = $targets['bid_per_day_52'];
//            $targetBidPerDay = $targets['bid_per_day'];
            $targetTotalBid = ($targetBidPerDay * $weekdays);
            $totalBid = $stats['total_bid'];
            $bidDiff = $totalBid - $targetTotalBid;
            $plusDiff = ($bidDiff >= 0);

            // Sales Value
            $salesValue = $stats['wonCompletedProposals'];
            $rolloverValue = $stats['rangeRollover'];
            $actualValue = ($salesValue - $rolloverValue);
            $differenceValue = ($salesValue - $currentSalesTarget);

            // Build the html content //
            $targetsHit = 0;

            // Sales $ //
            $salesClass = '<span style="color:red;"> &#8595;</span>';
            $linkClass = 'belowTarget';
            if ($salesValue >= $currentSalesTarget) {
                $salesClass = '<span style="color:green;"> &#8593;</span>';
                $targetsHit++;
            }
            $salesContent = '$' . readableValue($salesValue);

            // Win Rate
            $winRateClass = '<span style="color:red;"> &#8595;</span>';
            $linkClass = 'belowTarget';
            if ($winRate >= $targetWinRate) {
                $winRateClass = '<span style="color:green;"> &#8593;</span>';
                $linkClass = 'aboveTarget';
            }
            $winRateContent = number_format($winRate,
                2) . '% ';

            // Bid Amount
            $bidClass = '<span style="color:red;"> &#8595;</span>';
            $linkClass = 'belowTarget';
            if ($totalBid >= $targetTotalBid) {
                $bidClass = '<span style="color:green;"> &#8593;</span>';
                $linkClass = 'aboveTarget';
            }
            $bidContent = '$' . readableValue($targetTotalBid);

            // Content needs to be style dependent on comparison vs performance
            $row = [
                $account->getFullName(),
                $targetsHit,

                $salesValue,
                $salesContent,
                $winRate,
                $winRateContent,
                $totalBid,
                $bidContent,
                $targets['sales_target'],
                '$' . readableValue($targets['sales_target']),
            ];
            $table_html .= '<tr>
                                <td style="text-align:left;font-weight:bold;">' . $account->getFullName() . '</td>
                                <td style="text-align:center">' . $salesContent . $salesClass . '	</td>
                                <td style="text-align:center">$' . $winRateContent . $winRateClass . '</td>
                                <td style="text-align:center">' . $bidContent . $bidClass . '  </td>
                                <td style="text-align:center">$' . readableValue($targets['sales_target']) . '</td></tr>';

            //$data['aaData'][] = $row;
        }

        $email_template = $this->em->findAdminTemplate(30);
        $email_content = str_replace("{reportContent}", $table_html, $email_template->getTemplateBody());
        $this->load->model('system_email');
        $this->system_email->categories = ['Monthly Report'];
        $this->system_email->send_mail($job_account->getEmail(), $email_template->getTemplateSubject(), $email_content);

        // }

        // Return as JSON
        //echo json_encode($data);

        die;
        echo '<pre>';
        print_r($data);
    }

    public function send_sales_monthly_report()
    {
        $this->load->library('jobs');
        $users = $this->getProposalRepository()->getAllMonthlySalesReportUsers();

        foreach ($users as $user) {
            $this->jobs->create($_ENV['QUEUE_EMAIL'], 'test', 'job_send_sales_report',
                ['accountId' => $user->accountId, 'template_id' => 30], 'test email');
        }

        echo 'run job';

    }

    public function send_sales_weekly_report()
    {
        $this->load->library('jobs');
        $users = $this->getProposalRepository()->getAllweeklySalesReportUsers();

        foreach ($users as $user) {
            $this->jobs->create($_ENV['QUEUE_EMAIL'], 'test', 'job_send_sales_report',
                ['accountId' => $user->accountId, 'template_id' => 29], 'test email');
        }

        echo 'run job';

    }

    public function send_sales_daily_report()
    {
        try {
            $this->load->library('jobs');
            $users = $this->getProposalRepository()->getAllDailySalesReportUsers();

            foreach ($users as $user) {
                $job = $this->jobs->create($_ENV['QUEUE_EMAIL'], 'test', 'job_send_sales_report',
                    ['accountId' => $user->accountId, 'template_id' => 31], 'test email');
                if (!$job) {
                    throw new Exception("Job not created");
                }
            }

            echo 'run job';
        } catch (Exception $e) {
            //echo 'Message: ' .$e->getMessage();
            $this->send_error_notification();
        }

    }

    public function send_sales_report()
    {
        try {
            $this->load->library('jobs');

            $users = $this->getProposalRepository()->getAllDailySalesReportUsers();

            foreach ($users as $user) {
                $job = $this->jobs->create($_ENV['QUEUE_EMAIL'], 'test', 'job_send_sales_report', ['accountId' => $user->accountId],
                    'test email');
                if (!$job) {
                    throw new Exception("Job not created");
                }
            }

            $today = Carbon::now();
            if ($today->dayOfWeek == Carbon::MONDAY) {
                $users = $this->getProposalRepository()->getAllweeklySalesReportUsers();

                foreach ($users as $user) {
                    $this->jobs->create($_ENV['QUEUE_EMAIL'], 'test', 'job_send_sales_report',
                        ['accountId' => $user->accountId, 'template_id' => 29], 'test email');
                }
            }

            $firstWeekday = Carbon::parse('first day of this month +0 weekdays');

            if ($firstWeekday->today()) {

                $users = $this->getProposalRepository()->getAllMonthlySalesReportUsers();

                foreach ($users as $user) {
                    $this->jobs->create($_ENV['QUEUE_EMAIL'], 'test', 'job_send_sales_report',
                        ['accountId' => $user->accountId, 'template_id' => 29], 'test email');
                }
            }

            echo 'run job';
        } catch (Exception $e) {
            //echo 'Message: ' .$e->getMessage();
            $this->send_error_notification();
        }

    }

    public function check_cron()
    {
        $date = Carbon::parse('first day of June 2020');

        for ($i = 0; $i < 200; $i++) {
            echo $date->format('m/d/y') . '<br />';

            // Daily Check
            echo ' - Daily<br />';

            // Weekly Check
            //$today = Carbon::now();
            if ($date->dayOfWeek == Carbon::MONDAY) {
                echo ' - Weekly<br />';
            }

            // MonthlyCheck
            $firstWeekday = Carbon::parse('first day of ' . $date->format('M') . ' +0 weekdays');

            if ($firstWeekday->isSameDay($date)) {
                echo ' - Monthly<br />';
            }
            $date->addDay();
        }
    }

    public function job_send_sales_report()
    {

        try {

            //throw new Exception("Email not sent");
            $account = $this->em->find('\models\Accounts', $_POST['accountId']);
            //$account = $this->em->find('\models\Accounts', '285');

            $from = date('Y-m-d', strtotime('midnight first day of January this year'));
            $to = date('Y-m-d', time());

            // $job_account_id = $_POST['accountId'];
            //$job_account_id = 1902;
            $startTime = new Carbon($from . '00:00:00');
            $endTime = new Carbon($to);

            $weekdays = $startTime->diffInWeekdays($endTime);

            $salesTargetStats = $this->getSalesTargetsRepository();
            $table_html = '<p>' . $account->getFullName() . '</p><table width="100%"><thead ><tr><th style="padding-bottom: 5px;" >User</th><th style="padding-bottom: 5px;">Bids</th><th style="padding-bottom: 5px;">Bids / Day </th><th style="padding-bottom: 5px;">Avg Bid</th><th style="padding-bottom: 5px;">Bid $</th><th style="padding-bottom: 5px;">Target</th></tr><thead>';
            $mobile_table_html = '<table width="100%"><thead ><tr><th style="padding-bottom: 5px;" >User</th><th style="padding-bottom: 5px;">Bids/Daily</th><th style="padding-bottom: 5px;">Avg Bid</th><th style="padding-bottom: 5px;">Bid $ / Target</th></tr><thead>';

            if ($account->hasFullAccess()) {
                $companyUsers = $this->getCompanyRepository()->getSalesAccounts($account->getCompanyId());

                foreach ($companyUsers as $user) {

                    $targets = $salesTargetStats->getConfig($user->getCompanyId(), $user->getAccountId());

                    $company_users_data = $this->get_year_stats($user->getAccountId());
                    $currentSalesTarget = ($targets['sales_per_day'] * $weekdays);
                    $targetBidPerDay = $targets['bid_per_day_52'];
                    $targetTotalBid = ($targetBidPerDay * $weekdays);

                    $avg = $company_users_data['proposalCount'] ? number_format(($company_users_data['proposalCount'] / $weekdays),
                        2) : '0';
                    $mAvg = $company_users_data['proposalCount'] ? ($company_users_data['proposalCount'] / $weekdays) : 0;

                    $mAvg = (floor($mAvg) == number_format($mAvg, 1)) ? number_format($mAvg) : number_format($mAvg, 1);
                    $table_html .= '<tbody><tr>
                                        <td style="text-align:left;font-weight:bold;">' . $company_users_data['user_fullname'] . '</td>
                                        <td style="text-align:center">' . $company_users_data['proposalCount'] . '</td>
                                        <td style="text-align:center">' . $avg . '</td>
                                        <td style="text-align:center">$' . $company_users_data['avgValue'] . '</td>
                                        <td style="text-align:center">$' . $company_users_data['readableTotalValue'] . '</td>
                                        <td style="text-align:center">$' . readableValue($currentSalesTarget) . '</td></tr><tbody>';

                    $mobile_table_html .= '<tbody><tr>
                                        <td style="text-align:left;font-weight:bold;">' . $company_users_data['user_lastname'] . '<span style="float:right">$' . readableValue($targets['sales_target']) . '</span></td>
                                        <td style="text-align:center">' . $company_users_data['proposalCount'] . ' / ' . $mAvg . '</td>
                                        <td style="text-align:center">$' . $company_users_data['mobileAvgValue'] . '</td>
                                        <td style="text-align:center">$' . $company_users_data['mobileReadableTotalValue'] . ' / $' . mobileReadableValue($targetTotalBid) . '</td></tr><tbody>';

                }

            } else {
                if ($account->isBranchAdmin()) {
                    $branchUsers = $this->getCompanyRepository()->getSalesAccounts($account->getCompanyId(),
                        $account->getBranch());

                    foreach ($branchUsers as $user) {
                        $branch_users_data = $this->get_year_stats($user->getAccountId());
                        $targets = $salesTargetStats->getConfig($user->getCompanyId(), $user->getAccountId());
                        $currentSalesTarget = ($targets['sales_per_day'] * $weekdays);
                        $targetBidPerDay = $targets['bid_per_day_52'];
                        $targetTotalBid = ($targetBidPerDay * $weekdays);

                        $avg = $branch_users_data['proposalCount'] ? number_format(($branch_users_data['proposalCount'] / $weekdays),
                            2) : '0';
                        $mAvg = $branch_users_data['proposalCount'] ? ($branch_users_data['proposalCount'] / $weekdays) : '0';
                        $mAvg = (floor($mAvg) == number_format($mAvg, 1)) ? number_format($mAvg) : number_format($mAvg,
                            1);

                        $table_html .= '<tbody><tr>
                                        <td style="text-align:left;font-weight:bold;">' . $branch_users_data['user_fullname'] . '</td>
                                        <td style="text-align:center">' . $branch_users_data['proposalCount'] . '</td>
                                        <td style="text-align:center">' . $avg . '</td>
                                        <td style="text-align:center">$' . $branch_users_data['avgValue'] . '</td>
                                        <td style="text-align:center">$' . $branch_users_data['readableTotalValue'] . '</td>
                                        <td style="text-align:center">$' . readableValue($currentSalesTarget) . '</td></tr><tbody>';

                        $mobile_table_html .= '<tbody><tr>
                                        <td style="text-align:left;font-weight:bold;">' . $branch_users_data['user_lastname'] . '<span style="float:right">$' . readableValue($targets['sales_target']) . '</span></td>
                                        <td style="text-align:center">' . $branch_users_data['proposalCount'] . ' / ' . $mAvg . '</td>
                                        <td style="text-align:center">$' . $branch_users_data['mobileAvgValue'] . '</td>
                                        <td style="text-align:center">$' . $branch_users_data['mobileReadableTotalValue'] . ' / $' . mobileReadableValue($targetTotalBid) . '</td></tr><tbody>';
                    }

                } else {

                    $user_data = $this->get_year_stats($_POST['accountId']);
                    $targets = $salesTargetStats->getConfig($account->getCompanyId(), $account->getAccountId());
                    $currentSalesTarget = ($targets['sales_per_day'] * $weekdays);
                    $targetBidPerDay = $targets['bid_per_day_52'];
                    $targetTotalBid = ($targetBidPerDay * $weekdays);

                    $avg = $user_data['proposalCount'] ? number_format(($user_data['proposalCount'] / $weekdays),
                        2) : '0';

                    $mAvg = $user_data['proposalCount'] ? ($user_data['proposalCount'] / $weekdays) : '0';
                    $mAvg = (floor($mAvg) == number_format($mAvg, 1)) ? number_format($mAvg) : number_format($mAvg, 1);

                    $table_html .= '<tbody><tr>
                                        <td style="text-align:left;font-weight:bold;">' . $user_data['user_fullname'] . '</td>
                                        <td style="text-align:center">' . $user_data['proposalCount'] . '</td>
                                        <td style="text-align:center">' . $avg . '</td>
                                        <td style="text-align:center">$' . $user_data['avgValue'] . '</td>
                                        <td style="text-align:center">$' . $user_data['readableTotalValue'] . '</td>
                                        <td style="text-align:center">$' . readableValue($currentSalesTarget) . '</td></tr><tbody>';

                    $mobile_table_html .= '<tbody><tr>
                                        <td style="text-align:left;font-weight:bold;">' . $user_data['user_lastname'] . '<span style="float:right">$' . readableValue($targets['sales_target']) . '</span></td>
                                        <td style="text-align:center">' . $user_data['proposalCount'] . ' / ' . $mAvg . '</td>
                                        <td style="text-align:center">$' . $user_data['mobileAvgValue'] . '</td>
                                        <td style="text-align:center">$' . $user_data['mobileReadableTotalValue'] . ' / $' . mobileReadableValue($targetTotalBid) . '</td></tr><tbody>';

                }
            }

            $email_template = $this->em->findAdminTemplate(29);
            $email_content = str_replace("{reportContent}", $table_html, $email_template->getTemplateBody());
            $email_content = str_replace("{reportMobileContent}", $mobile_table_html, $email_content);

            $this->load->model('system_email');
            $this->system_email->categories = ['Weekly Report'];
            // $this->system_email->send_mail($account->getEmail(), $email_template->getTemplateSubject(), $email_content);
            //$sent_email = $this->system_email->send_mail('sunilyadav.acs@gmail.com', $email_template->getTemplateSubject(), $email_content);
            $this->system_email->send_mail('andy@pavementlayers.com', $email_template->getTemplateSubject(),
                $email_content);
            //$this->system_email->send_mail('sunilyadav.acs@gmail.com', $email_template->getTemplateSubject(), $email_content);
            ///if(!$sent_email){
            //throw new Exception("Email not sent");
            //}
            // }
        } catch (Exception $e) {
            //echo 'Message: ' .$e->getMessage();

            $failed_job = new \models\FailedJob();
            $failed_job->setJobName('job_send_sales_report');
            $failed_job->setJobValues(json_encode($_POST));
            $failed_job->setFailedAt(date('Y-m-d H:i:s'));
            $this->em->persist($failed_job);
            $this->em->flush();
            $this->send_error_notification();
        }

    }

    public function send_error_notification()
    {

        $this->load->model('system_email');
        $email_content = '<p>job_send_sales_report job failed.  </p>';
        $this->system_email->send_mail('sunilyadav.acs@gmail.com', 'Job Failed', $email_content);
    }

    public function check_error()
    {
        //trigger exception in a "try" block
        try {
            throw new Exception("Value must be 1 or below");
            //If the exception is thrown, this text will not be shown
            echo 'If you see this, the number is 1 or below';
        } //catch exception
         catch (Exception $e) {
            echo 'Message: ' . $e->getMessage();
            $this->send_error_notification();
        }
    }

    public function resend_failed_jobs()
    {
        $jobs = $this->getProposalRepository()->getAllfailedJobs();
        $this->load->library('jobs');
        foreach ($jobs as $job) {

            $data = json_decode($job->getJobData(), true);

            $data['failed_individual_job_id'] = $job->getId();

            $this->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', $job->getJobName(), $data, 'test email');
            // $failed_job = $this->em->find('\models\FailedJob', $job->getId());
            log_message('debug', $job->getJobData());
            $new_resend = $job->getResend() + 1;
            $job->setResend($new_resend);
            $this->em->persist($job);
            $this->em->flush();
            if ($new_resend > 2) {
                $body = 'Failed Job Id: ' . $job->getId();
                $basicEmailData = [
                    'fromName' => SITE_NAME,
                    'fromEmail' => 'noreply@' . SITE_EMAIL_DOMAIN,
                    'subject' => 'Job Failed 3rd time',
                    'body' => $body,

                    'to' => 'andy@pavementlayers.com',

                ];

                $this->getEmailRepository()->send($basicEmailData);
                $basicEmailData['to'] = 'sunilyadav.acs@gmail.com';
                $this->getEmailRepository()->send($basicEmailData);
            }
        }
    }

    public function get_queue()
    {
        $this->load->library('jobs');
        print_r($this->jobs->get_queue_size(QUEUE_EMAIL));
    }

    public function test_qb($companyId)
    {

        $company = $this->em->findCompany($companyId);
        if ($company->getQuickbooksSettings()) {
            echo '<h2>Syncing ' . $company->getCompanyName() . '</h2>';

            if ($company->getQuickbooksSettings()->getIncomeAccountId() && $company->getQuickbooksSettings()->getExpenseAccountId()) {
                if ($this->getQuickbooksRepository()->checkQbConnection($company)) {
                    try {
                        $this->getQuickbooksRepository()->migrateQbServices($company);
                        $this->getQuickbooksRepository()->syncServices($company);
                        $this->getQuickbooksRepository()->syncContacts($company);
                        $this->getQuickbooksRepository()->syncProposals($company);
                        //$this->getQuickbooksRepository()->syncPaymentStatus($company);
                    } catch (\Exception $e) {
                        echo '<p>Error syncing for this company. Check the logs.';
                    }
                } else {
                    // continue;
                    echo 'error';
                }
            } else {
                echo '<p>Company does not have income and expense accounts set</p>';
            }
        }

    }

    public function testPreloadDemoProposal()
    {

        $this->load->library('jobs');

        $proposalIds = [
            195886,
            195884,
        ];

        $jobData = [
            'proposalIds' => $proposalIds,
        ];

        // Save the opaque image
        $this->jobs->create($_ENV['QUEUE_HIGH'], 'jobs', 'preloadProposals', $jobData, 'preload proposals');
    }

    public function check_tiny_mce()
    {
        $this->load->view('test/test_tiny_mce');
    }

    public function testfile()
    {
        $myfile = fopen("newfile1.txt", "w") or die("Unable to open file!");

        $txt = 'testin2222' . "\n";
        fwrite($myfile, $txt);

        fclose($myfile);
    }

    public function test_user_stats()
    {
        $cAccount = $this->em->findClientAccount(3659);
        $allUserIds = $cAccount->accountProposalsUserStats();
        echo '<pre>';
        print_r($allUserIds);
    }

    public function delete_trash_company_folder()
    {
        $dir = UPLOADPATH . '/companies/';

        // Sort in ascending order - this is default
        $folders = scandir($dir);
        $i = 0;
        foreach ($folders as $folder) {
            if ($i == 0) {
                if ($folder != '.' && $folder != '..') {
                    echo $folder;
                    echo '<br/>';
                    $company = $this->em->findCompany($folder);
                    if ($company) {
                        echo 'found company';
                        echo '<br/>';
                    } else {
                        echo 'not found company';
                        $this->deleteDir($dir . $folder);
                        echo '<br/>';
                        $i = 1;
                    }
                    //echo '<br/>';
                }
            }
        }

    }

    public function deleteDir($dirPath)
    {
        if (!is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                $this->deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    public function delete_trash_all_company()
    {
        $companies = \models\Companies::getAllCompanies();

        foreach ($companies as $company) {
            echo $company->getCompanyId();
            $this->delete_trash_proposal_images($company->getCompanyId());
            echo '<br/>';
        }
    }

    public function delete_trash_proposal_images($companyId)
    {

        $total_size = 0;

        $dir = UPLOADPATH . '/companies/' . $companyId . '/proposals/';

        // Sort in ascending order - this is default
        $a = scandir($dir);

        foreach ($a as $folder) {

            //var_dump($folder);
            if ($folder != '.' && $folder != '..') {

                echo $folder;
                echo '<br/>';
                $proposal = $this->em->findProposal($folder);
                if (!$proposal) {
                    echo $path = UPLOADPATH . '/companies/' . $companyId . '/proposals/' . $folder;
                    echo '<br/>';
                    echo '<b>Delete Folder</b>';
                    echo '<br/>';
                    echo 'folder files size-';
                    // $tsize = $this->folderSize($path);
                    // echo $tsize;
                    // $total_size = $total_size + $tsize;
                    echo '<br/>';
                    $temp_files = glob($path . '/*');

                    // Deleting all the files in the list
                    foreach ($temp_files as $temp_file) {

                        if (is_file($temp_file)) {

                            echo $temp_file;
                            $tsize = filesize($temp_file);
                            echo "file size -" . $tsize;
                            $total_size = $total_size + $tsize;
                            // Delete the given file
                            unlink($temp_file);

                        }

                    }

                    rmdir($path);
                    continue;
                }

                $temp_imag = [];
                echo '<b>attachments</b>';
                foreach ($proposal->getAttachedFiles() as $files) {
                    $temp_imag[] = $files->getFilepath();
                }

                echo '<br/>';
                foreach ($proposal->getProposalImages() as $image) {
                    //print_r($image->getImage());
                    $temp_imag[] = $image->getImage();
                    //echo '<br/>';
                }
                print_r($temp_imag);
                echo '<br/>';

                $files = scandir($dir . '/' . $folder);
                print_r($files);
                echo '<br/>';
                foreach ($files as $file) {
                    if ($file != '.' && $file != '..') {
                        if (in_array($file, $temp_imag)) {
                            print_r($file);

                            echo '<br/>';
                            echo "Match found";
                            //print_r($file);
                        } else {
                            if ($file == 'cover.png' || $file == 'cover-orig.png') {
                                echo '<br/>';
                                echo "cover file";
                                echo '<br/>';

                            } else {
                                print_r($file);
                                echo '<br/>';
                                echo "Delete file";
                                $tsize = filesize($dir . '/' . $folder . "/" . $file);
                                echo "size -" . $tsize;
                                $total_size = $total_size + $tsize;
                                unlink($dir . '/' . $folder . "/" . $file);

                            }

                        }
                    }
                    echo '<br/>';
                }

            }
        }

        echo '<br/>';
        echo '<h1>Total size - ' . $this->readableBytes($total_size) . '</h1>';

    }

    public function test_file_delete()
    {
        $folder_path = UPLOADPATH . '/companies/3/proposals/195930';

        // List of name of files inside
        // specified folder
        $files = glob($folder_path . '/*');

        // Deleting all the files in the list
        foreach ($files as $file) {

            if (is_file($file)) {
                echo $file;
            }
            // Delete the given file
            //unlink($file);
        }
    }

    public function readableBytes($bytes)
    {
        $i = floor(log($bytes) / log(1024));
        $sizes = array('B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');

        return sprintf('%.02F', $bytes / pow(1024, $i)) * 1 . ' ' . $sizes[$i];
    }

    public function folderSize($dir)
    {
        $count_size = 0;
        $count = 0;
        $dir_array = scandir($dir);
        foreach ($dir_array as $key => $filename) {
            if ($filename != ".." && $filename != ".") {
                if (is_dir($dir . "/" . $filename)) {
                    $new_foldersize = $this->foldersize($dir . "/" . $filename);
                    $count_size = $count_size + $new_foldersize;
                } else {
                    if (is_file($dir . "/" . $filename)) {
                        $count_size = $count_size + filesize($dir . "/" . $filename);
                        $count++;
                    }
                }
            }
        }
        return $count_size;
    }

    public function optimized_proposal_images()
    {
        $q = $this->em->createQuery('SELECT pr FROM models\Proposals_images pr WHERE pr.optimized = 0 OR pr.optimized IS NULL order by pr.proposal desc ');
        $q->setMaxResults(100);
        $proposal_images = $q->getResult();
        echo '<pre>';
        $save_space = 0;
        foreach ($proposal_images as $proposal_image) {

            try {

                //echo 'test';die;

                echo '<br><br>--------------------------------------------<br><br><strong>Image' . $proposal_image->getImageId() . '<strong><br><br>';
                $continue = true;
                if ($proposal = $proposal_image->getProposal()) {
                    if ($client = $proposal->getClient()) {
                        if ($account = $client->getAccount()) {
                            if ($company = $account->getCompany()) {
                                if ($company_id = $company->getCompanyId()) {
                                    $continue = false;
                                }
                            }
                        }
                    }
                }

                if ($continue) {
                    continue;
                }

                echo $file = ROOTPATH . '/uploads/companies/' . $company_id . '/proposals/' . $proposal_image->getProposal()->getProposalId() . '/' . $proposal_image->getImage();
                $file_temp = ROOTPATH . '/uploads/companies/' . $company_id . '/proposals/' . $proposal_image->getProposal()->getProposalId() . '/optimize' . $proposal_image->getImage();
                // echo $file = ROOTPATH.'/uploads/companies/3/proposals/195935/57f53ebb90bd7a3cf9beca0439f5fa22.jpg';
                //$file_temp = ROOTPATH.'/uploads/companies/3/proposals/195935/optimaize-57f53ebb90bd7a3cf9beca0439f5fa22.jpg';
                if (file_exists($file)) {
                    $im = new ImageManager();
                    $image = $im->make($file);

                    $size = getimagesize($file);
                    $oldFileSize = filesize($file);
                    echo '<br>Old Image Size-' . $oldFileSize . '<br>';
                    if ($image->width() > 1100) {
                        $image->resize(1100, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    } else {
                        if ($image->height() > 800) {
                            $image->resize(null, 800, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        }
                    }

                    echo '<br>';
                    $image->save($file_temp, 85);
                    echo 'New Image Size-' . $image->filesize() . '<br>';
                    if ($oldFileSize > $image->filesize()) {
                        $image->save($file, 85);
                        $proposal_image->setOptimized(1);
                        $this->em->persist($proposal_image);

                        echo 'New Image smaller';

                        $save_space = $save_space + ($oldFileSize - $image->filesize());
                    } else {
                        echo 'New Image bigger';
                    }

                    echo '<br>';
                    unlink($file_temp);

                }

            } catch (Exception $e) {
                echo $e->getMessage();
            }

            $proposal_image->setOptimized(1);
            $this->em->persist($proposal_image);
            $this->em->flush();
        }

        echo '<br>';
        if ($save_space > 0) {
            echo '<p style="font-size:15px;font-weight:bold">Saved Space on server-' . $this->readableBytes($save_space) . '</p>';
        } else {
            echo '<p style="font-size:15px;font-weight:bold">No data Change</p>';
        }

    }

    function optimizedProposalImages($proposalId)
    {
        $q = $this->em->createQuery('SELECT pr FROM models\Proposals_images pr 
            WHERE pr.proposal = ' . $proposalId . "
            AND (
                pr.optimized = 0 
                OR pr.optimized IS NULL
            )"
        );
        $q->setMaxResults(100);
        $proposal_images = $q->getResult();
        echo '<pre>';
        $save_space = 0;
        foreach ($proposal_images as $proposal_image) {

            try {

                //echo 'test';die;

                echo '<br><br>--------------------------------------------<br><br><strong>Image' . $proposal_image->getImageId() . '<strong><br><br>';
                $continue = true;
                if ($proposal = $proposal_image->getProposal()) {
                    if ($client = $proposal->getClient()) {
                        if ($account = $client->getAccount()) {
                            if ($company = $account->getCompany()) {
                                if ($company_id = $company->getCompanyId()) {
                                    $continue = false;
                                }
                            }
                        }
                    }
                }

                if ($continue) {
                    continue;
                }

                echo $file = ROOTPATH . '/uploads/companies/' . $company_id . '/proposals/' . $proposal_image->getProposal()->getProposalId() . '/' . $proposal_image->getImage();
                $file_temp = ROOTPATH . '/uploads/companies/' . $company_id . '/proposals/' . $proposal_image->getProposal()->getProposalId() . '/optimize' . $proposal_image->getImage();
                // echo $file = ROOTPATH.'/uploads/companies/3/proposals/195935/57f53ebb90bd7a3cf9beca0439f5fa22.jpg';
                //$file_temp = ROOTPATH.'/uploads/companies/3/proposals/195935/optimaize-57f53ebb90bd7a3cf9beca0439f5fa22.jpg';
                if (file_exists($file)) {
                    $im = new ImageManager();
                    $image = $im->make($file);


                    $size = getimagesize($file);
                    $oldFileSize = filesize($file);
                    echo '<br>Old Image Size-' . $oldFileSize . '<br>';
                    if ($image->width() > 1100) {
                        $image->resize(1100, null, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                    } else {
                        if ($image->height() > 800) {
                            $image->resize(null, 800, function ($constraint) {
                                $constraint->aspectRatio();
                            });
                        }
                    }

                    echo '<br>';
                    $image->save($file_temp, 85);
                    echo 'New Image Size-' . $image->filesize() . '<br>';
                    if ($oldFileSize > $image->filesize()) {
                        $image->save($file, 85);
                        $proposal_image->setOptimized(1);
                        $this->em->persist($proposal_image);

                        echo 'New Image smaller';

                        $save_space = $save_space + ($oldFileSize - $image->filesize());
                    } else {
                        echo 'New Image bigger';
                    }

                    echo '<br>';
                    unlink($file_temp);

                }

            } catch (Exception $e) {
                echo $e->getMessage();
            }

            $proposal_image->setOptimized(1);
            $this->em->persist($proposal_image);
            $this->em->flush();
        }




        echo '<br>';
        if ($save_space > 0) {
            echo '<p style="font-size:15px;font-weight:bold">Saved Space on server-' . $this->readableBytes($save_space) . '</p>';
        } else {
            echo '<p style="font-size:15px;font-weight:bold">No data Change</p>';
        }

    }

    function test11(){
         //$start = Carbon::parse('first day of this year +0 weekdays');
         echo $start = Carbon::now()->startOfYear()->subYear(1)->format('m/d/Y');
        echo '<br>';
        echo $end = Carbon::now()->endOfYear()->subYear(1)->format('m/d/Y');
        echo '<br>';
        echo 'yesterday- ' . Carbon::now()->subDays(1)->format('m/d/Y');
        echo '<br>';
        echo '1st day of last month-' . Carbon::now()->startOfMonth()->subMonth()->format('m/d/Y');
        echo '<br>';
        echo 'last day of last month-' . Carbon::now()->subMonth()->endOfMonth()->format('m/d/Y');
        echo '<br>';
        echo 'current year start date- ' . Carbon::now()->startOfYear()->format('m/d/Y');
//echo Carbon::parse($end )->diffForHumans($start);
    }

    public function test_get_account()
    {
        $companyRepo = $this->getCompanyRepository();
        print_r($companyRepo->getSalesAccounts($this->account()->getCompanyId()));die;
    }

    public function prospect_migrate()
    {
        // $dql = "SELECT ps.prospectId,ps.business,ps.company
        //         FROM \models\Prospects ps
        //         WHERE ps.business IS NOT NULL";

        // $query = $this->em->createQuery($dql);

        // $prospects = $query->getResult();

        $this->load->database();
        $sql = "SELECT ps.prospectId,ps.business,ps.company
        FROM prospects as ps
        LEFT JOIN business_type_assignments as bta ON ps.prospectId = bta.prospect_id
        WHERE bta.prospect_id IS NULL
        AND ps.business IS NOT NULL
        AND ps.business != '0'
        AND ps.business != ''
        ORDER BY ps.prospectId ASC
        LIMIT 500";

        $prospects = $this->db->query($sql)->result();

        foreach ($prospects as $prospect) {

            // find business in company table
            $business_type = $this->checkBusinessType($prospect);
            //print_r(count($business_type));die;

            if ($business_type) {
                $business_type_id = $business_type['id'];
            } else {
                //create new business type
                $business_type_id = $this->createBusinessType($prospect);
            }

            //assign prospect to business type assignment table
            $this->businessTypeAssignment($prospect->prospectId, $prospect->company, $business_type_id);
        }
        //print_r($prospects);
    }

    public function checkBusinessType($prospect)
    {
        $dql = "SELECT bt.id
        FROM \models\BusinessType bt
        WHERE bt.type_name ='" . $prospect->business . "'
        AND (bt.company_id = " . $prospect->company . " OR bt.company_id IS NULL)";

        $query = $this->em->createQuery($dql);

        $results = $query->getResult();
        if ($results) {
            return $results[0];
        } else {
            return false;
        }

    }

    public function createBusinessType($prospect)
    {
        $newBusinessType = new \models\BusinessType();
        $newBusinessType->setTypeName($prospect->business);
        $newBusinessType->setCompanyId($prospect->company);
        $this->em->persist($newBusinessType);
        $this->em->flush();

        return $newBusinessType->getId();
    }

    public function businessTypeAssignment($prospectId, $company_id, $business_type_id)
    {
        $newBusinessType = new \models\BusinessTypeAssignment();
        $newBusinessType->setBusinessTypeId($business_type_id);
        $newBusinessType->setCompanyId($company_id);
        $newBusinessType->setProspectId($prospectId);
        $this->em->persist($newBusinessType);
        $this->em->flush();

        return $newBusinessType->getId();
    }

    public function newZohoLead()
    {

        try {
            ZCRMRestClient::initialize([
                'client_id' => ZOHO_CRM_USER,
                'client_secret' => ZOHO_CRM_CLIENT_SECRET,
                'redirect_uri' => site_url(),
                'currentUserEmail' => 'mike@pavementlayers.com',
                'token_persistence_path' => ROOTPATH . '/application/config',
                "apiBaseUrl" => "www.zohoapis.com",
                "apiVersion" => "v2",
            ]);

            $moduleInstance = ZCRMRestClient::getInstance()->getModuleInstance("Leads");
            $records = [];

            $leadRecord = ZCRMRecord::getInstance("leads", null);
            $leadRecord->setFieldValue('First_Name', 'Andrew');
            $leadRecord->setFieldValue('Last_Name', 'Long');
            $leadRecord->setFieldValue('Designation', 'Developer');
            $leadRecord->setFieldValue('Phone', '513-878-5791');
            $leadRecord->setFieldValue('Mobile', '513-878-5791');
            $leadRecord->setFieldValue('Email', 'mr.a.long+' . time() . '@gmail.com');
            $leadRecord->setFieldValue('Company', SITE_NAME);
            $leadRecord->setFieldValue('Address_1', '3814 West Street');
            $leadRecord->setFieldValue('City', 'Cincinnati');
            $leadRecord->setFieldValue('State', 'Ohio');
            $leadRecord->setFieldValue('Zip_Code', '45227');
            $leadRecord->setFieldValue('Website', '');
            $leadRecord->setFieldValue('Lead_Source', 'Automatic Trial SignUp');
            $leadRecord->setFieldValue('Temperature', 'Hot - Action');

            // Add records to instance and send via API
            $records[] = $leadRecord;
            $insert = $moduleInstance->createRecords($records);
        } catch (\Exception $e) {
            var_dump($e);
        }

    }

    public function createZohoOauthFile()
    {
        ZCRMRestClient::initialize([
            'client_id' => ZOHO_CRM_USER,
            'client_secret' => ZOHO_CRM_CLIENT_SECRET,
            'redirect_uri' => site_url(),
            'currentUserEmail' => 'mike@pavementlayers.com',
            'token_persistence_path' => ROOTPATH . '/application/config',
            "apiBaseUrl" => "www.zohoapis.com",
            "apiVersion" => "v2",
        ]);

        $oAuthClient = ZohoOAuth::getClientInstance();
        $refreshToken = "1000.b5e2c51a67d61c0bd748d32917bd0ac6.ae29088c28d35763359a8aa0eff77305";
        $userIdentifier = "mike@pavementlayers.com";
        $oAuthClient->generateAccessTokenFromRefreshToken($refreshToken, $userIdentifier);
    }

    public function update_client_business_type_to_account($companyId)
    {

        $sql = "select cc.id, cc.owner_user, cc.owner_company from client_companies cc
                where owner_company =" . $companyId;
        $company = $this->em->findCompany($companyId);
        $accounts = $this->db->query($sql)->result();
        foreach ($accounts as $account) {
            $this->getCompanyRepository()->checkAccountAllClientAssignedBusinessTypes($company, $account->id);

        }
    }

    public function check_time_diff($filterid)
    {
        $filter = $this->em->find('models\SavedProposalFilter', $filterid);
        if ($filter) {
            //print_r($filter->getUpdatedAt());
            echo '<br>';

            $carbonObject = Carbon::parse('');
            print_r($carbonObject);
            echo '<br>';
            $check = $carbonObject->diffInSeconds(Carbon::now());
            // print_r($check);
        }
    }

    public function test_last()
    {
        print_r($this->session->all_userdata());
        die;
        $user_data = $this->session->all_userdata();
//         echo $user_data['last_activity'];
        //         $datetime2 = $user_data['last_activity'];
        // $datetime1 = time();
        // $interval  = abs($datetime2 - $datetime1);
        // $minutes   = round($interval / 60);
        // echo 'Diff. in minutes is: '.$minutes;

// echo $datetime1 = $user_data['last_activity'];
        // echo '<br/>';
        // echo $datetime2 = time();
        // echo '<br/>';
        // $interval  = abs($datetime2 - $datetime1);
        // $minutes   = round($interval / 60);
        // echo 'Diff. in minutes is: '.$minutes;

        $time = new DateTime();
        $time->setTimestamp($user_data['last_activity']);
        print_r($time);
        echo '<br/>';
        $diff = $time->diff(new DateTime());
        $now = new DateTime();
        print_r(new DateTime());
        echo '<br/>';
        echo $minutes = ($diff->days * 24 * 60) + ($diff->h * 60) + $diff->i;
        echo '<br/>';
        echo $diffSeconds = $now->getTimestamp() - $time->getTimestamp();
    }

    public function error()
    {
        throw new Exception('This is a test error');
    }

    public function testPopulate($companyId)
    {
        populateCompany($companyId);
    }

    public function addtest()
    {
        echo 'hello';
    }

    public function update_bid_total($client_id)
    {
        $this->getClientRepository()->updateProposalBidTotal($client_id);
    }

    public function delete_cache()
    {
        $this->doctrine->deleteSiteAllCache();
    }

    public function updateCompanyProposalCount()
    {
        $company_id = $this->uri->segment(3);
        $sql = "SELECT clientId FROM clients WHERE company = $company_id";
        $client_ids = $this->db->query($sql)->result_array();
        foreach ($client_ids as $client_id) {
            $this->getClientRepository()->updateProposalBidTotal($client_id['clientId']);
        }
    }

    public function filter_push()
    {
        $parentResend = $this->em->find('\models\AdminGroupResend', 119);

        $p = json_decode($parentResend->getFilters());
        $push = array(
            'pResendType' => 'unOpened',
        );
        // print_r($p);die;
        //array_push($p,$push);
        $p[0]->pResendType = 'unOpened';
        print_r(json_encode($p));die;
    }

    public function remove_qb_connection()
    {
        $company_id = 3;

        $this->db->query("delete from quickbook_settings where company_id=?", array($company_id));
        $this->db->query('update companies set qb_setting_id=? where companyId=? limit 1',
            array(null, $company_id));
    }

    public function getScreencastDuration()
    {
        $matches = [];
        $regex = "/xmpDM:duration xmpDM:scale=\"(.*)\/(.*)\" xmpDM:value=\"(.*)\" \/>/";
        $client = new GuzzleHttp\Client();
        $response = $client->get('https://content.screencast.com/users/andy_long_pl/folders/Snagit/media/da061b35-ff7c-428b-ab19-86c46ce35662/sc.xmp');
        preg_match($regex, $response->getBody(), $matches);

        array_shift($matches);

        echo '<pre>';
        var_dump($matches);
        echo '</pre>';

        echo '<p>Video duration is ' . (($matches[0] / $matches[1]) * $matches[2]) . ' seconds';
    }

    public function testBrowser()
    {

        $browser = new Browser();
        //var_dump($browser);die;
        if ($browser->getBrowser() == Browser::BROWSER_FIREFOX && $browser->getVersion() >= 10) {
            echo 'You have FireFox version 10 or greater';
        }
    }

    public function timeTest()
    {
        $seconds = 0;

        $readableTime = secondsToTime($seconds);

        echo $readableTime;
    }

    public function ipdataTest()
    {
        $httpClient = new Symfony\Component\HttpClient\Psr18Client();
        $psr17Factory = new Nyholm\Psr7\Factory\Psr17Factory();
        $ipdata = new Ipdata\ApiClient\Ipdata($_ENV['IPDATA_KEY'], $httpClient, $psr17Factory);

        $data = $ipdata->lookup('69.78.70.144');
        echo "<pre>";
        print_r($data);die;
        var_dump((object) $data);
        echo "</pre>";
        //echo json_encode($data, JSON_PRETTY_PRINT);
    }

    public function convertVideos()
    {
        set_time_limit(0);

        $dql = "SELECT p FROM \models\Proposals p
                WHERE p.videoURL IS NOT NULL
                AND p.videoURL != ''";

        //$query = $this->doctrine->em->createQuery($dql)->setMaxResults(10);
        $query = $this->doctrine->em->createQuery($dql);

        $proposalsWithVideo = $query->getResult();

        foreach ($proposalsWithVideo as $proposal) {

            $save = true;

            echo '<h4>' . $proposal->getProjectName() . '-' . $proposal->getProposalId() . '</h4> - ' . $proposal->getVideoURL() . '<br />';

            $proposalVideo = new \models\ProposalVideo();
            $proposalVideo->setProposalId($proposal->getProposalId());
            $proposalVideo->setVideoType($this->getProposalRepository()->getVideoType($proposal->getVideoURL()));
            $proposalVideo->setVideoUrl($proposal->getVideoURL());
            $proposalVideo->setTitle('Video');

            if ($proposalVideo->getVideoType() == 'screencast') {
                $duration = $this->getProposalRepository()->getScreencastDuration($proposal->getVideoURL());

                preg_match('~media/(.*?)/~', $proposal->getVideoURL(), $output);
                //Get Screencast video Id for tracking
                if (isset($output[1])) {
                    $screencastVideoId = $output[1];
                    $proposalVideo->setScreencastVideoId($screencastVideoId);
                };

                if ($duration) {
                    $proposalVideo->setDuration($duration);
                    $proposalVideo->setEmbedVideoUrl($this->getProposalRepository()->getScreencastEmbedUrl($proposal->getVideoURL()));
                } else {
                    $save = false;
                }

            } else {
                $proposalVideo->setEmbedVideoUrl($this->getProposalRepository()->getProposalVideoEmbedUrl($proposal->getVideoURL()));
            }

            if ($save) {
                echo '<pre>';
                var_dump($proposalVideo);
                echo "'</pre>";
                $this->em->persist($proposalVideo);
                $this->em->flush();
            } else {
                echo 'No video - do not migrate';
            }

        }

    }

    public function echo_account_id()
    {
        echo $this->account()->getAccountId();
    }

    public function failedEmail()
    {
        $emailData = [
            'fromName' => SITE_NAME,
            'fromEmail' => 'no-reply@' . SITE_EMAIL_DOMAIN,
            'subject' => 'Undeliverable Email',
            'body' => 'This is the mail system at host smtp6.relay.ord1c.emailsrvr.com.

I am sorry to have to inform you that your message could not be delivered to one or more recipients.

For further assistance, please send mail to postmaster.
',
            'to' => 'praveen@itsabacus.com',
            'bcc' => 'andy@pavementlayers.com',
        ];

        //$this->getEmailRepository()->send($emailData);
    }

    public function run_jobs_manualy()
    {
        $this->load->library('jobs');
    }


    public function testProposalLink()
    {
        $this->getProposalRepository()->getDefaultProposalLink('196055');
    }

    public function getAggregateViewData($linkId)
    {
        $proposalLink = $this->em->find(models\ProposalPreviewLink::class, $linkId);
        /* @var \models\ProposalPreviewLink $proposalLink */

        $proposal = $this->em->find(models\Proposals::class, $proposalLink->getProposalId());
        /* @var models\Proposals $proposal */

        $linkViews = $this->getProposalRepository()->getProposalLinkViews($linkId);



        // Set up data
        $data = [
            'email' => $proposalLink->getEmail(),
            'duration' => 0
        ];

        // View Data
        $viewData = [];

        // Proposal
        $proposalData = [];
        $proposalData['projectName'] = $proposal->getProjectName();
        $proposalData['address'] = [
            'address' => $proposal->getProjectAddress(),
            'city' => $proposal->getProjectCity(),
            'state' => $proposal->getProjectState(),
            'zip' => $proposal->getProjectZip(),
        ];

        // Client Data
        $clientData = [];
        $clientData['accountName'] = $proposal->getClient()->getClientAccount()->getName();
        $clientData['firstName'] = $proposal->getClient()->getFirstName();
        $clientData['lastName'] = $proposal->getClient()->getLastName();
        // Belongs to the proposal
        $proposalData['client'] = $clientData;
        $data['viewer'] = '<i class="fa fa-fw fa-envelope"></i> ' . $proposalLink->getEmail();
        if ($proposal->getClient()->getEmail() == $proposalLink->getEmail()) {
            $data['viewer'] = '<i class="fa fa-fw fa-user"></i> ' .
                $clientData['firstName'] . ' ' . $clientData['lastName'];
        }

        $data['proposalData'] = $proposalData;

        // Arrays for later
        $pageViewTimes = [];
        $serviceViewTimes = [];
        $imageDurationData = [];
        $userAgentData = [
            'os'            => [],
            'os_version'    => [],
            'device'        => [],
            'browser'       => []
        ];



        // Keep this outside of the loop
        $proposalServices = $proposalServices = $proposal->getServices();
        $serviceIds = [];

        foreach ($linkViews as $linkView) {
            /* @var \models\ProposalView $linkView */

            // Populate the link view data
            $viewData[$linkView->getId()] = [
                'id' => $linkView->getId(),
                'duration' => 0,
                'date' => $data['created_at'] = Carbon::createFromFormat(
                        'Y-m-d H:i:s',
                        $linkView->getCreatedAt())->format('m/d/y g:iA')
            ];

            // Increment the duration
            $data['duration'] += $linkView->getTotalDuration();

            // User Agent Data - add if not already there

            // OS
            if (!in_array($linkView->getPlatform(), $userAgentData['os'])) {
                $userAgentData['os'][] = $linkView->getPlatform();
            }

            // Device
            if (!in_array($linkView->getPlatformVersion(), $userAgentData['os_version'])) {
                $userAgentData['os_version'][] = $linkView->getPlatformVersion();
            }

            // Device
            if (!in_array($linkView->getDevice(), $userAgentData['device'])) {
                $userAgentData['device'][] = $linkView->getDevice();
            }

            // Browser
            if (!in_array($linkView->getBrowser(), $userAgentData['browser'])) {
                $userAgentData['browser'][] = $linkView->getBrowser();
            }


            // Page and service view times
            $pageViewData = json_decode($linkView->getViewData());

            if ($pageViewData) {

                foreach ($pageViewData as $k => $v) {
                    if ($k !== 'service_section') {
                        if ($v > 0) {

                            // Increment if exists, create if not
                            if (array_key_exists(ucfirst($k), $pageViewTimes)) {
                                $pageViewTimes[ucfirst($k)] += $v;
                            } else {
                                $pageViewTimes[ucfirst($k)] = $v;
                            }
                        }
                    } else {

                        foreach ($proposalServices as $proposalService) {
                            /* @var \models\Proposal_services $proposalService */

                            $duration = 0;
                            $clicks = 0;

                            foreach ($v as $kk => $vv) {
                                if ($vv->id == $proposalService->getServiceId()) {
                                    $duration = $vv->duration;
                                    if(isset($vv->clicks)){
                                        $clicks = $vv->clicks;
                                    };

                                }
                            }
                            $serviceIds[] = $proposalService->getServiceId();

                            // Increment the value if we have a key. Create anew key if not
                            if (array_key_exists($proposalService->getServiceId(), $serviceViewTimes)) {
                                $serviceViewTimes[$proposalService->getServiceId()]['clicks'] += $clicks;
                                $serviceViewTimes[$proposalService->getServiceId()]['duration'] += $duration;
                            } else {
                                $serviceViewTimes[$proposalService->getServiceId()] = [
                                    'serviceTitle' => $proposalService->getServiceName(),
                                    'duration' => $duration,
                                    'clicks' => $clicks
                                ];
                            }
                        }

                        foreach ($v as $kk => $vv) {

                            if (!in_array($vv->id, $serviceIds)) {

                                if(array_key_exists('deleted', $serviceViewTimes)) {
                                    $serviceViewTimes['deleted'] += $vv->duration;
                                } else {
                                    $serviceViewTimes['deleted'] = [
                                        'serviceTitle' => 'Deleted Service(s)',
                                        'duration' => $vv->duration
                                    ];
                                }
                            }
                        }
                    }
                }
            }


            // Image View Data
            if ($linkView->getViewedImageData()) {

                $imageViewData = json_decode($linkView->getViewedImageData());

                foreach ($imageViewData as $s => $imageData) {

                    $image = $this->em->findProposalImage($imageData->imageId);
                    if ($image) {

                        if (array_key_exists($s, $imageDurationData)) {
                            $imageDurationData[$s]['duration'] += $imageData->duration;
                            $imageDurationData[$s]['clicks'] += $imageData->clicks;
                        } else {
                            $imageDurationData[$s] = [
                                'imagepath' => $image->getFullWebPath(),
                                'title' => $image->getTitle(),
                                'duration' => $imageData->duration,
                                'clicks' => $imageData->clicks
                            ];
                        }
                    }

                }
            }
        }

        $data['pageData']               = $pageViewTimes;
        $data['servicePageViewData']    = $serviceViewTimes;
        $data['viewData']               = $viewData;
        $data['imageDurationData']      = $imageDurationData;
        $data['userAgentData']          = $userAgentData;

        // Need to handle: User Agents

        $pageViewTimes = [];
        $serviceViewTimes = [];


        // Total Duration
        echo '<pre>';
        var_dump($data);
        echo '</pre>';
    }

    function getProposalViewEmailList(){

        $proposalViews = $this->getProposalRepository()->getProposalViewList();
        foreach($proposalViews as $proposalView){

            $proposal = $this->em->findProposal($proposalView->getProposalId());
            if (!$proposal->getClient()->getAccount()->getDisableProposalNotifications()) {

                $proposalView->setEmailSent(models\ProposalView::EMAIL_SENDING);
                $this->em->persist($proposalView);
                $this->em->flush();

                $job_array = [
                    'proposalViewId' => $proposalView->getId(),
                ];

                $this->load->library('jobs');
                // Save the opaque image
                $this->jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'proposalViewedEmailSend', $job_array, 'test job');
                
                
           }else{
               $proposalView->setEmailSent(models\ProposalView::EMAIL_DO_NOT_SEND);
               $this->em->persist($proposalView);
               $this->em->flush();

           }
            
        }
        
    }

    public function rebuildAllProposals(){
        $dql = "SELECT  p.proposalId
                FROM \models\Proposals p
                WHERE  p.rebuildFlag = 0";

        $query = $this->doctrine->em->createQuery($dql);

        $results = $query->getResult();
        print_r(count($results));die;

        foreach ($results as $result) {
            $proposalId = $result['proposalId'];
            $this->proposalCache($proposalId);
        }
    }

    public function proposalCache($proposalId)
    {
        $proposal = $this->em->findProposal($proposalId);
        $proposalPreviewUrl = $this->getProposalRepository()->getDefaultProposalLink($proposal->getProposalId());
        $url = $proposalPreviewUrl->getUrl().'/cache';
        try {
            $ch = curl_init();
        
            // Check if initialization had gone wrong*    
            if ($ch === false) {
                throw new Exception('failed to initialize');
            }
        
            // Better to explicitly set URL
            curl_setopt($ch, CURLOPT_URL, $url);
            // That needs to be set; content will spill to STDOUT otherwise
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            // Set more options
            
            $content = curl_exec($ch);
        
            // Check the return value of curl_exec(), too
            if ($content === false) {
                throw new Exception(curl_error($ch), curl_errno($ch));
            }
        
            // Check HTTP return code, too; might be something else than 200
            $httpReturnCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
            /* Process $content here */
        
        } catch(Exception $e) {
        
            trigger_error(sprintf(
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);
        
        } finally {
            // Close curl handle unless it failed to initialize
            if (is_resource($ch)) {
                curl_close($ch);
            }
        }
        // $pdfUrl = $proposal->getPdfUrl(false, true);

        // die($pdfUrl);
    }

    function check_device(){
        $browser = new Browser();

        $device = 'Desktop';
        $os = $browser->getOS();

        if ($browser->isMobile()) {
            $device = 'Phone';
            if ($browser->getPlatform() == 'iPhone') {
                $device = 'iPhone';
            }
        } else if ($browser->isTablet()) {
            $device = 'Tablet';
            if ($browser->getPlatform() == 'iPad') {
                $device = 'iPad';
            }
        }

        print_r($_SERVER['HTTP_USER_AGENT']);
        echo '<br/>';
        var_dump($browser->isMobile());
        echo '<br/>';
        var_dump($browser->isTablet());
        echo '<br/>';
        print_r('getPlatform-'.$browser->getPlatform());
        echo '<br/>';
        die;
    }


    public function migrateProposalSignees()
    {
        // First we get all of the signees
        $dql = "SELECT ps
               FROM models\ProposalSignee ps";

        $signees = $this->em->createQuery($dql)->getResult();


        foreach ($signees as $signee) {

            // Split them into an array
            $names = explode(' ', $signee->getName(true));

            // Count how many parts there are to they array - we'll need this in case there's more than 2 names
            $nameCount = count($names);

            // First name - easy. Let's save that
            $firstName = $names[0];

            // Now remove the first name from the array
            unset($names[0]);

            // If there are more than 2 pieces, glue them all together with a space
            if ($nameCount > 2) {
                $lastName = join(' ', $names);
            } else {

                // It's less than 2

                // Is there a second word?
                if (!isset($names[1])) {
                    // No, so just use a space for last name
                    $lastName = ' ';
                } else {
                    // Yes, save it as last name
                    $lastName = $names[1];
                }
            }

            // Save the new values here
            $signee->setFirstName($firstName);
            $signee->setLastName($lastName);
            // Set the old column to null
            // $signee->setName(null);
            $this->em->persist($signee);
            $this->em->flush();

            echo '<p>Name Field: ' . $signee->getName(true) . ' - First Name: ' . $firstName . ' LastName: ' . $lastName . '</p>';
        }


        //$this->load->view('test/migrate-signees', ['signees' => $signees]);
    }

    function viewLogToProposalView(){
        set_time_limit(0);
        $sql = "SELECT * FROM log where details = 'PDF Viewed' AND timeAdded > 1629000000 AND logId > 14455925";
        $pdfViewedLogs = $this->db->query($sql)->result();
        echo count($pdfViewedLogs) . ' logs! Found...<br>';
       
        foreach ($pdfViewedLogs as $log) {
            
            $proposal = $this->em->findProposal($log->proposal);
            if($proposal){
                
                $ppl = $this->em->getRepository('models\ProposalPreviewLink')->findOneBy(array('log_id' => $log->logId));

                if (!$ppl) {
                    $uuid = Uuid::uuid4();
                    $ppl = new  \models\ProposalPreviewLink();
                    $ppl->setProposalId($proposal->getProposalId());
                    $ppl->setUuid($uuid);
                    $ppl->setEmail('PDF View');
                    $ppl->setCreatedAt(Carbon::createFromTimestamp($log->timeAdded)->toDateTimeString());
                    $ppl->setLogId($log->logId);
                    $this->em->persist($ppl);
                    $this->em->flush();
                    $proposal->setProposalViewCount($proposal->getProposalViewCount() + 1);
                }


            }
        }
    }

    function testURL(){
        echo Carbon::now()->startOfDay()->timestamp;
die;
        $proposal = $this->em->findProposal(196058);
        echo $proposal->getProposalViewUrl(true);
        echo '<br/>';
        echo $proposal->getProposalViewUrl();
    }

    function testEx(){

        $date = Carbon::now()->addDays(5)->timestamp;
        $now = Carbon::now()->timestamp;

        // Base query
        $sql = "SELECT c.companyId, c.companyName, c.companyStatus, c.new_layouts, a.cellPhone, c.administrator,c.estimating,
                CONCAT(a.firstName, ' ', a.lastName) AS adminFullName,
                (SELECT GROUP_CONCAT(accountId) FROM accounts a WHERE a.company = c.companyId AND a.secretary <> 1 AND a.expires > ".$now." AND a.expires < " . $date . ") AS users,                 
                (SELECT COUNT(accountId) FROM accounts a WHERE a.company = c.companyId AND a.secretary <> 1 AND a.expires > ".$now." AND a.expires < " . $date . ") AS numInactiveUsers
                  
            FROM companies c
            LEFT JOIN accounts a ON c.administrator = a.accountId WHERE c.companyId > 0  HAVING numInactiveUsers >0";

        $companies = $this->db->query($sql)->result();
        foreach($companies as $expiry){

            $usersData = '<table id="user_table"><caption>Users</caption><thead><tr><th scope="col">UserName</th><th scope="col">Role</th><th scope="col">Expiring At</th></tr></thead><tbody>';
            $users = explode(",",$expiry->users);

            foreach($users as $user){
                $newuser = $this->em->findAccount($user);
                $usersData .= "<tr><td>".$newuser->getFullname()."</td><td>".$newuser->getUserClass(true)."</td><td>".date('m/d/Y', $newuser->getExpires())."</td></tr>";
            }

             $usersData .= "</tbody></table>";

             $this->load->model('system_email');
             $emailData = array(
                 
                 'siteName' => SITE_NAME,
                 'companyName' => $expiry->companyName,
                 'adminFullName' => $expiry->adminFullName,
                 'adminContact' => $expiry->cellPhone,
                 'Users' => $usersData,
                 
             );
             
             $this->system_email->sendEmail(52, 'sunil@pavementlayers.com', $emailData);
           
        }
        

    }

    function testEx2(){

        $date = Carbon::now()->addDays(14)->timestamp;
        $now = Carbon::now()->timestamp;

        // Base query
        $sql = "SELECT c.companyId, c.companyName, c.companyStatus, a.email, a.cellPhone, c.administrator,c.estimating,
                CONCAT(a.firstName, ' ', a.lastName) AS adminFullName,
                (SELECT GROUP_CONCAT(accountId) FROM accounts a WHERE a.company = c.companyId AND a.secretary <> 1 AND a.expires > ".$now." AND a.expires < " . $date . ") AS users,                 
                (SELECT COUNT(accountId) FROM accounts a WHERE a.company = c.companyId AND a.secretary <> 1 AND a.expires > ".$now." AND a.expires < " . $date . ") AS numInactiveUsers
                  
            FROM companies c
            LEFT JOIN accounts a ON c.administrator = a.accountId WHERE c.companyId > 0  HAVING numInactiveUsers >0";

       
        $companies = $this->db->query($sql)->result();
        foreach($companies as $expiry){

            $usersData = '<table id="user_table"><caption>Users</caption><thead><tr><th scope="col">UserName</th><th scope="col">Role</th><th scope="col">Expiring At</th></tr></thead><tbody>';
            $users = explode(",",$expiry->users);

            foreach($users as $user){
                $newuser = $this->em->findAccount($user);
                $usersData .= "<tr><td>".$newuser->getFullname()."</td><td>".$newuser->getUserClass(true)."</td><td>".date('m/d/Y', $newuser->getExpires())."</td></tr>";
            }

             $usersData .= "</tbody></table>";

             $this->load->model('system_email');
             $emailData = array(
                 
                 'siteName' => SITE_NAME,
                 'companyName' => $expiry->companyName,
                 'adminFullName' => $expiry->adminFullName,
                 'adminContact' => $expiry->cellPhone,
                 'Users' => $usersData,
                 'prior_days' => $usersData,
                 
             );
             echo $expiry->email;
             $this->system_email->sendEmail(53, 'sunil@pavementlayers.com', $emailData);
             //$this->system_email->sendEmail(53, $expiry->email, $emailData);
           
        }
    }

    function revert_price_33(){

        $modifier = '-10';
        $multiplier = 1 + ($modifier / 100);


        $sql = "SELECT log.proposal,count(proposal) as count FROM log where company ='310' AND timeAdded > '1644901200' AND details LIKE '%Proposal price adjusted by 10%' group by proposal order by proposal desc LIMIT 601, 900 ";
        $proposalsResults = $this->db->query($sql)->result();

        foreach ($proposalsResults as $proposalRow) {
            
            $count = $proposalRow->count;

            $proposalId = $proposalRow->proposal;
            echo $proposalId;
            echo '-';
            // $sql = "SELECT log.proposal,count(proposal) as count FROM log where proposal ='{$proposalId}' AND timeAdded > '1644901200' AND details LIKE '%Proposal price adjusted by -10%'  ";
            // $proposalschecks = $this->db->query($sql)->result();
            // if($proposalschecks){
            //     if(isset($proposalschecks[0])){
                    
            //         $count = $count - $proposalschecks[0]->count;
            //     }
            // }

            $proposal = $this->em->findProposal($proposalId);
            // if($count>0){

            
            //     for($i=0;$i<$count;$i++){
            //         echo $proposalId.'check'.$i;
            //         echo '</br>';

            //         $account = $this->em->findAccount(3919);

            //         $this->getProposalRepository()->modifyPrice($account, $proposal, $multiplier);
                
            //     }
            // }
            if($count<3){
            $service_price_total = 0;
            echo 'Proposal Total -'. getServiceTotalPrice($proposalId);
            $services = $proposal->getServices();
            $multiplier = '0.826451';
            // Apply the price adjustment
            foreach ($services as $service) {
                $oldPrice = $service->getPrice(true);
                $newPrice = round($oldPrice * $multiplier);
                $formattedNewPrice = '$' . number_format($newPrice);

                $service_price_total = round(floatval($service_price_total) + floatval($newPrice));

                //  $service->setPrice($formattedNewPrice);
                //  $this->em->persist($service);
            }
            $this->em->flush();

           
           
           echo ' --- Proposal NewTotal -'.$service_price_total;
           echo '<br/>';
        }else if($count>3){
            $service_price_total = 0;
            echo 'Proposal Total -'. getServiceTotalPrice($proposalId);
            $services = $proposal->getServices();
            $multiplier = '0.621';
            // Apply the price adjustment
            foreach ($services as $service) {
                $oldPrice = $service->getPrice(true);
                $newPrice = round($oldPrice * $multiplier);
                $formattedNewPrice = '$' . number_format($newPrice);

                $service_price_total = round(floatval($service_price_total) + floatval($newPrice));

                //  $service->setPrice($formattedNewPrice);
                //  $this->em->persist($service);
            }
            $this->em->flush();

           
           
           echo ' --- Proposal NewTotal -'.$service_price_total;
           echo '<br/>';
        }


            // Update the proposal price
            //updateProposalPrice($proposal->getProposalId());
           

        }


    }

   function revert_single_proposal($proposalId,$multiplier){
        $proposal = $this->em->findProposal($proposalId);
        echo $proposalId ;
        echo '-';
        echo $multiplier;
       
        $services = $proposal->getServices();
        echo 'Proposal Total -'. getServiceTotalPrice($proposalId);

        // $newPrice = round(getServiceTotalPrice($proposalId) * $multiplier);
        // echo 'Proposal New Total -'. $newPrice;
        // die;
        // Apply the price adjustment
        foreach ($services as $service) {
            $oldPrice = $service->getPrice(true);
            $newPrice = round($oldPrice * $multiplier);
            $formattedNewPrice = '$' . number_format($newPrice);

            //$service_price_total = round(floatval($service_price_total) + floatval($newPrice));

                $service->setPrice($formattedNewPrice);
                $this->em->persist($service);
        }
        $this->em->flush();

        // Update the proposal price
        updateProposalPrice($proposal->getProposalId());
        
        echo ' --- Proposal NewTotal -'. getServiceTotalPrice($proposalId);
                   echo '<br/>';


   }

    function revert_sunil_price_33(){

        $modifier = '-10';
        $multiplier = 1 + ($modifier / 100);


        $sql = "SELECT log.proposal,count(proposal) as count FROM log where company ='310'  AND timeAdded > '1644901200' AND details LIKE '%Proposal price adjusted by -10%' group by proposal order by proposal desc LIMIT 401, 800";
        $proposalsResults = $this->db->query($sql)->result();

        foreach ($proposalsResults as $proposalRow) {
            
            $count = $proposalRow->count;

            $proposalId = $proposalRow->proposal;

           echo $proposalId;
           echo '-';

            $proposal = $this->em->findProposal($proposalId);
            if($count>1){

                
                // for($i=0;$i<$count;$i++){
                //     echo $proposalId.'check'.$i;
                //     echo '</br>';
                $multiplier = '1.6935';
                    $account = $this->em->findAccount(3919);

                    //$this->getProposalRepository()->modifyPrice($account, $proposal, $multiplier);
                    $service_price_total = 0;

                    $services = $proposal->getServices();
                    echo 'Proposal Total -'. getServiceTotalPrice($proposalId);
                    // Apply the price adjustment
                    foreach ($services as $service) {
                        $oldPrice = $service->getPrice(true);
                        $newPrice = round($oldPrice * $multiplier);
                        $formattedNewPrice = '$' . number_format($newPrice);
        
                        //$service_price_total = round(floatval($service_price_total) + floatval($newPrice));

                         $service->setPrice($formattedNewPrice);
                         $this->em->persist($service);
                    }
                    $this->em->flush();

                   // Update the proposal price
                   updateProposalPrice($proposal->getProposalId());
                   
                   echo ' --- Proposal NewTotal -'. getServiceTotalPrice($proposalId);
                   echo '<br/>';

        
                    
                
                //}
            }else if($count>5){

//                 $multiplier = '1.88164';
//                     $account = $this->em->findAccount(3919);

//                     //$this->getProposalRepository()->modifyPrice($account, $proposal, $multiplier);


//                     $services = $proposal->getServices();
// $service_price_total = 0;
//                     // Apply the price adjustment
//                     foreach ($services as $service) {
//                         $oldPrice = $service->getPrice(true);
//                         $newPrice = round($oldPrice * $multiplier);
//                         $formattedNewPrice = '$' . number_format($newPrice);
//                         $service_price_total = $service_price_total + $newPrice;
//                         //$service->setPrice($formattedNewPrice);
//                         //$this->em->persist($service);
//                     }
//                     ///$this->em->flush();
        
//                     echo 'Proposal OldTotal -'. getServiceTotalPrice($proposalId);
//                     echo ' --- Proposal NewTotal -'. $service_price_total;
//                    echo '<br/>';

                    // Update the proposal price
                    //updateProposalPrice($proposal->getProposalId());

            }
           

        }


    }


    function update_proposal_for_sigle_service_33(){

        $sql = "SELECT logId,account,proposal,count(proposal) as rows,REPLACE(SUBSTRING_INDEX(details,'to',1),'Proposal price adjusted by 10% from','') as old_value FROM pms.log

        where 
        -- proposal ='482195' 
        company = '310'
       AND timeAdded > '1644901200' AND details LIKE '%Proposal price adjusted by 10%'   
       
        group by proposal 

        order by timeAdded asc LIMIT 1701,2000";

        $proposalsResults = $this->db->query($sql)->result();


        
        foreach ($proposalsResults as $proposalRow) {
            
            $count = 0;

            $proposalId = $proposalRow->proposal;
            $formattedNewPrice = $proposalRow->old_value;
            
           echo $proposalId;
           echo '-';

            $proposal = $this->em->findProposal($proposalId);
            echo 'Proposal Total -'. getServiceTotalPrice($proposalId);
            $services = $proposal->getServices();
            if(count($services)==1){

                
                // for($i=0;$i<$count;$i++){
                //     echo $proposalId.'check'.$i;
                //     echo '</br>';
                //$multiplier = '1.6935';
                    //$account = $this->em->findAccount(3919);

                    //$this->getProposalRepository()->modifyPrice($account, $proposal, $multiplier);
                    $service_price_total = 0;

                    

                    // Apply the price adjustment
                    foreach ($services as $service) {
                        // $oldPrice = $service->getPrice(true);
                        // $newPrice = round($oldPrice * $multiplier);
                        // $formattedNewPrice = '$' . number_format($newPrice);
                       // $service_price_total = round(floatval($service_price_total) + floatval($newPrice));

                         $service->setPrice($formattedNewPrice);
                         $this->em->persist($service);
                    }
                    $this->em->flush();

                   
                   
                   echo ' --- Proposal NewTotal -'. $formattedNewPrice;
                   

        
                    // Update the proposal price
                    updateProposalPrice($proposal->getProposalId());
                
                //}
            }
            echo '<br/>';

        }

         
    }


    public function modifyPricesStatus12222($count)
    {
        
        $modifier = '10';
        $multiplier = 1 + ($modifier / 100);

        $statusNames = [];
       // foreach ($statusIds as $statusId) {
            $statusNames[] = $this->em->findStatus(1)->getText();
        //}
        $account = $this->em->findAccount(3919);
        $company_id = 310;
        //$company_id = 3;
        //$proposals = $this->getCompanyRepository()->getProposalsByStatus($this->account()->getCompany(), 1);

        $dql = "SELECT p FROM \models\Proposals p
        WHERE
    (p.company_id = {$company_id})

        AND (p.proposalStatus IN (1))
        AND (p.created >= 1609477200)
        AND (p.created <= 1641013199)
ORDER BY p.created DESC";

//$query = $this->doctrine->em->createQuery($dql)->setMaxResults(10);
$query = $this->doctrine->em->createQuery($dql)->setFirstResult($count)->setMaxResults(200);;

$proposals = $query->getResult();

        $initialCount = count($proposals);

        $updated = [];

        foreach ($proposals as $proposal) {
            /* @var \models\Proposals $proposal */

            $update = $this->getProposalRepository()->modifyPrice($account, $proposal, $multiplier);
            if ($update) {
                $updated[] = $proposal;
            }

            // if ($this->getEstimationRepository()->countProposalEstimate($proposal) > 0) {
            //     $this->getEstimationRepository()->modifyProposalEstimatePrice($this->account(), $proposal, $multiplier);
            // }

            // Flag for rebuild
            $proposal->setRebuildFlag(1);
            $this->em->persist($proposal);

        }
        $updatedCount = count($updated);

        // // Record it
        // $pm = new \models\PriceModification();
        // $pm->setCompanyId($this->account()->getCompanyId());
        // $pm->setAccountId($this->account()->getAccountId());
        // $pm->setUserName($this->account()->getFullName());
        // $pm->setModifier($modifier);
        // $pm->setStatuses(join(' | ', $statusNames));
        // $pm->setRunDate(Carbon::now());
        // $pm->setIpAddress($_SERVER['REMOTE_ADDR']);
        // $pm->setProposalsModified($updatedCount);
        // $this->em->persist($pm);
        // $this->em->flush();

        echo json_encode([
            'success' => 1,
            'initialCount' => $initialCount,
            'updatedCount' => $updatedCount,
        ]);

    }

    function check_queue_size(){
        echo ini_get('max_execution_time'); 
        $this->load->library('jobs');
        echo date("Y/m/d H:i:s" );
        echo '<br/>';
       echo 'get_workers'; 
       var_dump($this->jobs->get_workers());
       echo '<br/>';
       $data = $this->jobs->get_workers();
       echo date("Y/m/d H:i:s",$data[0]['run_at']);
       echo '<br/>';
       echo 'waiting'; 
        var_dump($this->jobs->get_stat('waiting'));
        echo '<br/>';
       echo 'running'; 
        var_dump($this->jobs->get_stat('running'));
        echo '<br/>';
       echo 'complete'; 
        var_dump($this->jobs->get_stat('complete'));
        echo '<br/>';
       echo 'failed'; 
        var_dump($this->jobs->get_stat('failed'));
        echo '<br/>';
// //sleep(60);
// var_dump($this->jobs->peek($_ENV['QUEUE_EMAIL']));
// echo '<br/>';
        
        //sleep(60);
        var_dump($this->jobs->get_queue_size($_ENV['QUEUE_EMAIL']));
    }


    function testLog(){
        $data_read = file_get_contents("redisQueueLogTime.log");
        print_r($data_read);	die;
        $mapFile = fopen("redisQueueLogTime.log", "w") or die("Unable to open file!");
        $line = fread($mapFile, filesize('redisQueueLogTime.log'));
        print_r($line);
        fclose($mapFile);die;
       // $txt_file = fopen('abc.txt','r');
       //$mapFile = fopen('config/map.txt', 'r'); // don't need `or die()`
       while ($line = fread($mapFile, filesize('redisQueueLogTime.log')))
       {
           echo $line;
       }
fclose($mapFile);
die;
		$logTime = time();

        //Log the time for prevent multiple queue run
        $myfile = fopen("redisQueueLogTime.log", "w") or die("Unable to open file!");
        //Write the File
        fwrite($myfile, $logTime);
        //Save the data into file
        fclose($myfile);

            // Start infinite loop
            while (true) {

                
                
                    usleep(200000);
            

                $time = time();
                if($time > $logTime){
                    $logTime = $time;
                    //Log the time for prevent multiple queue run
                    $myfile = fopen("redisQueueLogTime.log", "w") or die("Unable to open file!");
                    //Write the File
                    fwrite($myfile, $logTime);
                    //Save the data into file
                    fclose($myfile);

                }
                    

            }
    }

    function remove_duplicate_proposal_layout(){
        $sql = "SELECT ps.proposal_id,pr.company_id FROM proposal_sections_individual_order as ps LEFT JOIN proposals as pr ON ps.proposal_id = pr.proposalId group by ps.proposal_id having count(ps.proposal_id)>12 order by pr.proposalId LIMIT 100";

        $proposalsResults = $this->db->query($sql)->result();

        foreach($proposalsResults as $dup){

            $p_id = $dup->proposal_id;

            $sql2 = "SELECT  p.* FROM proposal_sections_individual_order as p where proposal_id = ".$p_id." group by ord";
            $old_datas = $this->db->query($sql2)->result();
            if(count($old_datas)>0){
                $sql3 = "DELETE FROM proposal_sections_individual_order WHERE proposal_id = ".$p_id;
                $this->db->query($sql3);
                foreach($old_datas as $old_data){

                    $psio = new ProposalSectionIndividualOrder();
                    $psio->setProposalSectionId($old_data->proposal_section_id);
                    $psio->setProposalId($p_id);
                    $psio->setOrd($old_data->ord);
                    $psio->setVisible($old_data->visible);
                    $this->em->persist($psio);
                    $this->em->flush();

                }
            }
            

        }
    }
}
