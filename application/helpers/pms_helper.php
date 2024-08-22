<?php

use Carbon\Carbon;
use Ramsey\Uuid\Uuid;

function new_system($time = null)
{
    if ($time == null) {
        $time = time();
    }
    return ($time > 1355998700);
}

function updateProposalPrice($proposalId = null)
{
     $s = array('$', ',');
    $r = array('', '');
    $CI =& get_instance();
    $CI->load->database();
    //get proposal
    $proposal = $CI->em->find('models\Proposals', $proposalId);

    /* @var $proposal \models\Proposals */
    if (!$proposal) {
        return false;
    } else {
        //get price (new or old system)
        $newSystem = new_system($proposal->getCreated(false));
      //  echo "<pre>";print_r($newSystem);die;
        // if($newSystem) {
        //     $price = getServiceTotalPrice($proposalId);
        // } else {
        //     $price = $proposal->getTotalPrice(false);
        // }
        $price = getServiceTotalPrice($proposalId);
        $price = str_replace($s, $r, $price);
        //update price
        $proposal->setPrice(floatval($price));
        $proposal->setRebuildFlag(1);
        $CI->em->persist($proposal);
        $CI->em->flush();
        $clientRepository = new \Pms\Repositories\Client();
        $clientRepository->updateProposalBidTotal($proposal->getClient()->getClientId());
         return $price;
    }
}

function updateProposalPrices()
{
    $CI =& get_instance();
    $CI->load->database();
    $proposals = $CI->em->getRepository('models\Proposals')->findAll();
    foreach ($proposals as $proposal) {
        updateProposalPrice($proposal->getProposalId());
        echo $proposal->getProposalId();
    }
}

// function getServiceTotalPrice($proposalId = null)
// {
//     $s = array('$', ',');
//     $r = array('', '');
//     $CI =& get_instance();
//     $CI->load->database();
//     $query = $CI->db->query('select serviceId,price from proposal_services where proposal=' . $proposalId . ' AND optional != 1 AND tax != 1 AND is_hide_in_proposal != 1');
//     $total = 0;
//     $debug = '|';
//     foreach ($query->result() as $service) {
//         $total += (float)str_replace($s, $r, $service->price);
//         $debug .= $service->serviceId . '|';
//     }
//     return $total;
// }

function getServiceTotalPrice($proposalId = NULL) {
    $s = array('$', ',');
    $r = array('', '');
    $CI =& get_instance();
    $CI->load->database();
    // Use query binding to prevent SQL injection
    $query = $CI->db->query('SELECT serviceId, price, amountQty FROM proposal_services WHERE proposal = ?', array($proposalId));
    $total = 0;
    foreach ($query->result() as $service) {
        // Replace dollar sign and commas from the price, then multiply by amountQty if it's greater than 0
        if ($service->amountQty && $service->amountQty > 0) {
            $service->price = $service->amountQty * floatval(str_replace($s, $r, $service->price));
        } else {
            $service->price = floatval(str_replace($s, $r, $service->price));
        }
        $total += $service->price;
    }
    // Return the total price
    return $total;
}


function realTime($time = null)
{
    if ($time == null) {
        $time = time();
    }
    return $time + TIMEZONE_OFFSET;
}

function export($data = array(), $type = 'csv', $fileName = null, $download = true)
{
    switch ($type) {
        case 'csv':
            if (!$fileName) {
                $fileName = time() . '.csv';
            }
            $file = UPLOADPATH . '/exports/' . $fileName;
            $fp = fopen($file, 'w');
            foreach ($data as $row) {
                fputcsv($fp, $row);
            }
            fclose($fp);
            if ($download) {
//                header('Location: ' . site_url('uploads/temp/exports') . '/' . $fileName);
                header('Content-Type: text/csv');
                header('Content-Disposition: attachment; filename="' . $fileName . '"');
                echo file_get_contents($file);
            }
            break;
    }
}

function help_box($id, $echo = false)
{
    $ci =& get_instance();
    $ci->load->database();
    $box = $ci->db->query('select * from helpVideos where enabled=1 and helpId=' . $id);
    if ($box->num_rows()) {
        if ($echo) {
            ?>
            ?
            <ul>
                <?php
                $videos = $ci->db->query('select * from helpVideos where parent=' . $id . ' order by ord');
                if ($videos->num_rows()) {
                    foreach ($videos->result() as $video) {
                        ?>
                        <li><a
                                href="//www.youtube.com/embed/<?php echo $video->youtubeId ?>?autoplay=1">
                            <?php echo $video->title ?></a>
                        </li><?php
                    }
                } else {
                    ?>
                    <li>Coming Soon!</li><?php
                }
                ?>
            </ul>
            <?php
        } else {
            return true;
        }
    } else {
        return false;
    }
}

/*
 *  Return the link to geoIP map based on IP
 */
function mapIP($ip, $tip = 'View Location', $external = false)
{
    if ($external) {
        return '<a href="' . site_url('/home/ipMap/' . $ip) . '" class="fancybox fancybox.iframe tiptip" title="' . $tip . '">' . $ip . '</a>';
    } else {
        return '<a href="' . site_url('/account/ipMap/' . $ip) . '" class="fancybox fancybox.iframe tiptip" title="' . $tip . '">' . $ip . '</a>';
    }
}

/**
 * @param $id int Company ID
 * @return true on success, false on fail
 */
function populateCompany($id)
{
    $s = array('$', ',');
    $r = array('', '');
    $CI =& get_instance();
    $CI->load->database();
    //load queue model used for adding delayed emails
    $CI->load->model('queue');
    // Load the clientEmail model for templating
    $CI->load->model('clientEmail');
    // Library for Parsing
    $CI->load->library('EmailTemplateParser');
    // Library for Parsing
    $CI->load->library('jobs');
    //load company
    $company = $CI->em->find('models\Companies', $id);
    $account = $company->getAdministrator();
    if ($company) {
        /*
         *  Step 0 - Create Client Accounts
         */

        $residentialAccount = new \models\ClientCompany();
        $residentialAccount->setName('Residential');
        $residentialAccount->setOwnerCompany($company);
        $residentialAccount->setOwnerUser($account);
        $residentialAccount->setCreated(time());
        $CI->em->persist($residentialAccount);

        $clientAccount1 = new \models\ClientCompany();
        $clientAccount1->setCreated(time());
        $clientAccount1->setOwnerCompany($company);
        $clientAccount1->setOwnerUser($account);
        $clientAccount1->setName('Ethicon J & J Company');
        $CI->em->persist($clientAccount1);

        $clientAccount2 = new \models\ClientCompany();
        $clientAccount2->setCreated(time());
        $clientAccount2->setOwnerCompany($company);
        $clientAccount2->setOwnerUser($account);
        $clientAccount2->setName('CBRE');
        $CI->em->persist($clientAccount2);

        $CI->em->flush();

        /*
         * Step 1 - create clients
         */
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
        $client->setAddress('4545 Creek Rd');
        $client->setCity('Cincinnati');
        $client->setZip('45242');
        $client->setCountry('USA');
        $client->setAccount($account);
        $client->setCompany($company);
        $client->setClientAccount($clientAccount1);
        $CI->em->persist($client);
        //Client #2
        $client2 = new models\Clients();
        $client2->setFirstName('Eric');
        $client2->setLastName('Smith');
        $client2->setBusinessPhone('513-477-2727');
        $client2->setEmail('mike@pavementlayers.com');
        $client2->setCellPhone('513-477-2727');
        $client2->setFax('');
        $client2->setTitle('Owner');
        $client2->setState('OH');
        $client2->setWebsite(site_url());
        $client2->setAddress('101 Main Street');
        $client2->setCity('Cincinnati');
        $client2->setZip('45227');
        $client2->setCountry('USA');
        $client2->setAccount($account);
        $client2->setCompany($company);
        $client2->setClientAccount($clientAccount2);
        $CI->em->persist($client2);
        $CI->em->flush();
        /*
         * Step 2 - Create and send 2xLeads
         */
        $services = $company->getCategories();
        $lead = new models\Leads();
        $lead->setCompany($company->getCompanyId());
        $lead->setAccount($account->getAccountId());
        $lead->setStatus('Working');
        $dueDate = time() + (86400 * 2);
        $lead->setDueDate($dueDate);
        $lead->setRating('Gold');
        $lead->setCompanyName('Acme Apartments');
        $lead->setFirstName('Michael');
        $lead->setLastName('Barrett');
        $lead->setTitle('Property Manager');
        $lead->setAddress('123 Main');
        $lead->setCity('Cincinnati');
        $lead->setState('OH');
        $lead->setZip('45227');
        $lead->setBusinessPhone('513-477-2727');
        $lead->setCellPhone('513-477-2727');
        $lead->setEmail('mike@pavementlayers.com');
        $lead->setWebsite(site_url());
        $lead->setProjectName('Green Acre Apartment');
        $lead->setProjectAddress('123 Main');
        $lead->setProjectCity('Cincinnati');
        $lead->setProjectState('OH');
        $lead->setProjectZip('45227');
        $lead->setProjectPhone('513-477-2727');
        $lead->setProjectContact('513-477-2727');
        $lead->setSource('Partner');
        $lead->setNotes('This is the area where you can add any notes for the estimator to see before he goes to the job.');
        $servicesIDS = '30,5,49,2';
        $servicesArray = array(30, 5, 49, 2);
        $lead->setServices($servicesIDS);
        $CI->em->persist($lead);
        $CI->log_manager->add(\models\ActivityAction::ADD_LEAD, 'Added Lead "' . $lead->getProjectName() . '".');
        $assignedAccount = $account;
        if ($assignedAccount) {
            $mailServices = array();
            $k = 0;
            foreach ($services as $service) {
                $k++;
                if (is_array($servicesArray) && in_array($service->getServiceId(), $servicesArray)) {
                    $mailServices[] = $service->getServiceName();
                }
            }
            $mailServices = implode(', ', $mailServices);
            $emailData = array(
                'first_name' => $assignedAccount->getFirstName(),
                'last_name' => $assignedAccount->getLastName(),
                'project_name' => $lead->getProjectName(),
                'company_name' => $lead->getCompanyName(),
                'requested_work' => $mailServices,
                'contact' => $lead->getFirstName() . ' ' . $lead->getLastName(),
                'contact_title' => $lead->getTitle(),
                'phone' => $lead->getBusinessPhone(),
                'address' => $lead->getAddress() . ' ' . $lead->getCity() . ' ' . $lead->getState() . ', ' . $lead->getZip(),
                'notes' => nl2br($lead->getNotes()),
                //added extra
                'projectPhone' => $lead->getProjectPhone(),
                'leadAddress' => $lead->getAddress() . ' ' . $lead->getCity() . ' ' . $lead->getState() . ' ' . $lead->getZip(),
                'projectContact' => $lead->getProjectContact(),
                'email' => $lead->getEmail(),
            );
            $CI->load->model('system_email');
//            $CI->system_email->sendEmail(5, $assignedAccount->getEmail(), $emailData);
            $emailTemplate = $CI->em->find('models\Email_templates', 5);
            $search = array();
            $replace = array();
            foreach ($emailData as $s => $r) {
                $search[] = '{' . $s . '}';
                $replace[] = $r;
            }
            $search[] = '{site_title}';
            $replace[] = $CI->settings->get('site_title');
            //add the site title and shit to search/replace
            $emailSettings = array(
                'recipient' => $assignedAccount->getEmail(),
                'subject' => str_replace($search, $replace, $emailTemplate->getTemplateSubject()),
                'body' => str_replace($search, $replace, $emailTemplate->getTemplateBody()),
            );

            $CI->queue->addEmail($emailSettings, 300);
        }
        $lead2 = new models\Leads();
        $lead2->setCompany($company->getCompanyId());
        $lead2->setAccount($account->getAccountId());
        $lead2->setStatus('Working');
        $dueDate = time() + (86400 * 2);
        $lead2->setDueDate($dueDate);
        $lead2->setRating('Gold');
        $lead2->setCompanyName('Simon Properties');
        $lead2->setFirstName('Eric');
        $lead2->setLastName('Smith');
        $lead2->setTitle('Property Manager');
        $lead2->setAddress('123 Main');
        $lead2->setCity('Cincinnati');
        $lead2->setState('OH');
        $lead2->setZip('45227');
        $lead2->setBusinessPhone('513-477-2727');
        $lead2->setCellPhone('513-477-2727');
        $lead2->setEmail('mike@pavementlayers.com');
        $lead2->setWebsite(site_url());
        $lead2->setProjectName('Kenwood Mall');
        $lead2->setProjectAddress('123 Main');
        $lead2->setProjectCity('Cincinnati');
        $lead2->setProjectState('OH');
        $lead2->setProjectZip('45227');
        $lead2->setProjectPhone('513-477-2727');
        $lead2->setProjectContact('513-477-2727');
        $lead2->setSource('Partner');
        $lead2->setNotes('This is the area where you can add any notes for the estimator to see before he goes to the job.');
        $servicesIDS = '30,5,49,2';
        $servicesArray = array(30, 5, 49, 2);
        $lead2->setServices($servicesIDS);
        $CI->em->persist($lead2);
        $CI->log_manager->add(\models\ActivityAction::ADD_LEAD, 'Added Lead "' . $lead2->getProjectName() . '".');
        $assignedAccount = $account;
        if ($assignedAccount) {
            $mailServices = array();
            $k = 0;
            foreach ($services as $service) {
                $k++;
                if (is_array($servicesArray) && in_array($service->getServiceId(), $servicesArray)) {
                    $mailServices[] = $service->getServiceName();
                }
            }
            $mailServices = implode(', ', $mailServices);
            $emailData = array(
                'first_name' => $assignedAccount->getFirstName(),
                'last_name' => $assignedAccount->getLastName(),
                'project_name' => $lead2->getProjectName(),
                'company_name' => $lead2->getCompanyName(),
                'requested_work' => $mailServices,
                'contact' => $lead2->getFirstName() . ' ' . $lead2->getLastName(),
                'contact_title' => $lead2->getTitle(),
                'phone' => $lead2->getBusinessPhone(),
                'address' => $lead2->getAddress() . ' ' . $lead2->getCity() . ' ' . $lead2->getState() . ', ' . $lead2->getZip(),
                'notes' => nl2br($lead2->getNotes()),
            );
            $CI->load->model('system_email');
//            $CI->system_email->sendEmail(5, $assignedAccount->getEmail(), $emailData);
        }
        $proposalRepository = new \Pms\Repositories\Proposal();
        /*
         * Adding of 6x Proposals to populate the Pie Chart
         */
        $proposal = $proposalRepository->create();
        $proposal->setProjectAddress('4545 Creek Rd');
        $proposal->setProjectCity('Cincinnati');
        $proposal->setProjectState('OH');
        $proposal->setProjectZip('45242');
        $proposal->setProjectName('Blue Ash Ohio Campus');
        $proposal->setProposalTitle(SITE_NOUN . ' Maintenance Proposal');
        $proposal->setPaymentTerm($company->getPaymentTerm());
        $proposal->setImageCount(5);
        // Reset the access key to flag it as a demo
        $proposal->setAccessKey(true);
        $proposal->setOwner($account);

        $CI->load->database();
        $openStatus = $client->getCompany()->getDefaultStatus(\models\Status::OPEN);
        $proposal->setProposalStatus($openStatus);
        $proposal->setStatusChangeDate(time());
        $proposal->setPaymentTerm(20);
        $proposal->setTexts('45,48,92,100,101,49,93,47,95,50,94,51,102,52,96,53,97,54,98,55,99,56,57,1285,1286,1287,1289,1893,1894,1895,1896,1897,125,1155,1156,1157,1158,1159,1160,1161,1162,1163,1164,1165,1166,1168,1169,2016,2017,2018,2019,2020,2276');
        $proposal->setTextsCategories('1:0|36:0|37:1|191:0|192:0|193:0|194:0|204:0|246:1');
        $proposal->setClient($client);
        $proposal->setIsDemo(1);
        $proposal->setRebuildFlag(1);
        $proposal->setBusinessTypeId(\models\BusinessType::OFFICE);
        $proposal->setCompanyId($company->getCompanyId());
        $CI->em->persist($proposal);
        //2nd proposal
        $proposal2 = $proposalRepository->create();
        $proposal2->setProjectAddress('123 Main');
        $proposal2->setProjectCity('Cincinnati');
        $proposal2->setProjectState('OH');
        $proposal2->setProjectZip('45227');
        $proposal2->setProjectName('Kenwood Mall');
        $proposal2->setProposalTitle(SITE_NOUN . ' Maintenance Proposal');
        $proposal2->setPaymentTerm($company->getPaymentTerm());
        $proposal2->setStatusChangeDate(time());
        $proposal2->setImageCount(2);
        $proposal2->setOwner($account);
        $proposal2->setIsDemo(1);
        $proposal2->setRebuildFlag(1);
        $proposal2->setAccessKey(true);
        $proposal2->setBusinessTypeId(\models\BusinessType::SHOPPING_CENTER);
        $wonStatus = $client->getCompany()->getDefaultStatus(\models\Status::WON);
        $proposal2->setProposalStatus($wonStatus);
        $proposal2->setStatusChangeDate(time());
        $proposal2->setWinDate(time());
        $proposal2->setCompanyId($company->getCompanyId());
        //set up the default texts
        $texts = $CI->customtexts->getTexts($company->getCompanyId());
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
        $proposal2->setPaymentTerm(20);
        $proposal2->setTexts($txts);
        $proposal2->setClient($client2);
        $CI->em->persist($proposal2);
        //save everything so we have the proposal IDs available
        $CI->em->flush();

        // Assign Business Types
        $pr = new \Pms\Repositories\Proposal();
        $pr->checkNewBusinessTypeProposalAssignment($proposal, $proposal->getBusinessTypeId(), $company->getCompanyId());
        $pr->checkNewBusinessTypeProposalAssignment($proposal2, $proposal2->getBusinessTypeId(), $company->getCompanyId());

        /*
         * Add Services to the above proposals
         */
        $serviceIds = array(8 => '$4,367', 38 => '$6,900', 27 => '$234,657', 31 => '$127,400', 3 => '$2,374');
        $serviceFields = array(
            8 => array(
                'measurement' => '299',
                'area_unit' => 'square yards',
                'depth' => '2',
                'depth_unit' => 'Inches',
            ),
            38 => array(
                'lineal_feet_cracks' => '10,000'
            ),
            27 => array(
                'area' => '7,000',
                'area_unit' => 'square yards',
                'number_of_coats' => '2',
                'trips' => '1',
                'day_of_week' => 'Weekend',
                'application' => 'Spray',
                'warranty' => '1 Year',
            ),
            31 => array(
                'area_of_paving' => '17,710',
                'unit' => 'square yards',
                'tons_of_leveling' => '12',
                'depth_of_paving' => '2',
                'number_of_parking_blocks' => '57',
                'trips' => '2',
            ),
            3 => array(),
        );
        $serviceTitles = [
            8 => 'Asphalt Milling Repair | Green Map Area',
            38 => 'Crack Sealing | White Map Area',
            27 => 'Premium Sealcoating',
            31 => 'Mill + Pave Existing Parking Lot | Blue Map Area',
            3 => 'Line Striping',
        ];
        $k = 0;
        $proposal_services = array();
        $textCounter = 0;
        foreach ($serviceIds as $serviceId => $servicePrice) {
            $k++;
            //get service name and texts
            $service = $CI->em->find('models\Services', $serviceId);
            if ($service) {
                $proposal_services[$k] = new \models\Proposal_services();
                $proposal_services[$k]->setOrd($k);
                $proposal_services[$k]->setPrice($servicePrice);
                $proposal_services[$k]->setProposal($proposal->getProposalId());
                $proposal_services[$k]->setInitialService($serviceId);
                $proposal_services[$k]->setServiceName($serviceTitles[$serviceId]);
                $proposal_services[$k]->setOptional(0);
                $proposal_services[$k]->setTax(0);
                $proposal_services[$k]->setApproved(1);
                // Set optional for the new overlay
                if ($serviceId == 31) {
                    $proposal_services[$k]->setOptional(1);
                }

                $CI->em->persist($proposal_services[$k]);
                $CI->em->flush(); //save the proposal service so it has a valid ID
                //add the texts
                $txts = (getServiceTexts($serviceId, $company->getCompanyId()));
                $texts = array();
                foreach ($txts as $textValue) {
                    $textCounter++;
                    $text = new \models\Proposal_services_texts();
                    $text->setServiceId($proposal_services[$k]->getServiceId());
                    $text->setText(htmlentities($textValue, ENT_QUOTES));
                    $text->setOrd($textCounter);
                    $texts[$textCounter] = $text;
                    $CI->em->persist($texts[$textCounter]);
                }
                //add the fields
                $fieldsCounter = 0;
                $fields = array();
                foreach ($serviceFields[$serviceId] as $fieldCode => $fieldValue) {
                    $fieldsCounter++;
                    $field = new \models\Proposal_services_fields();
                    $field->setServiceId($proposal_services[$k]->getServiceId());
                    $field->setFieldCode($fieldCode);
                    $field->setFieldValue($fieldValue);
                    $fields[$fieldsCounter] = $field;
                    $CI->em->persist($fields[$fieldsCounter]);
                }
            }
        }
        $serviceIds2 = array(8 => '$5,000', 38 => '$4,900', 27 => '$37,350', 31 => '$66,530', 3 => '$1,200');
        $serviceFields = array(
            8 => array(
                'measurement' => '500',
                'area_unit' => 'square yards',
                'depth' => '2',
                'depth_unit' => 'Inches',
            ),
            38 => array(
                'lineal_feet_cracks' => '7,500'
            ),
            27 => array(
                'area' => '5,000',
                'area_unit' => 'square yards',
                'number_of_coats' => '2',
                'trips' => '1',
                'day_of_week' => 'Weekend',
                'application' => 'Spray',
                'warranty' => '1 Year',
            ),
            31 => array(
                'area_of_paving' => '2,000',
                'unit' => 'square yards',
                'tons_of_leveling' => '12',
                'depth_of_paving' => '2',
                'number_of_parking_blocks' => '57',
                'trips' => '2',
            ),
            3 => array(),
        );
        $k = 0;
        $proposal_services = array();
        foreach ($serviceIds2 as $serviceId => $servicePrice) {
            $k++;
            //get service name and texts
            $service = $CI->em->find('models\Services', $serviceId);
            if ($service) {
                $proposal_services[$k] = new \models\Proposal_services();
                $proposal_services[$k]->setOrd($k);
                $proposal_services[$k]->setPrice($servicePrice);
                $proposal_services[$k]->setProposal($proposal2->getProposalId());
                $proposal_services[$k]->setInitialService($serviceId);
                $proposal_services[$k]->setServiceName($service->getServiceName());
                $proposal_services[$k]->setOptional(0);
                $proposal_services[$k]->setTax(0);
                $proposal_services[$k]->setApproved(1);
                $CI->em->persist($proposal_services[$k]);
                $CI->em->flush(); //save the proposal service so it has a valid ID
                //add the texts
                $txts = (getServiceTexts($serviceId, $company->getCompanyId()));
                $texts = array();
                foreach ($txts as $textValue) {
                    $textCounter++;
                    $text = new \models\Proposal_services_texts();
                    $text->setServiceId($proposal_services[$k]->getServiceId());
                    $text->setText(htmlentities($textValue, ENT_QUOTES));
                    $text->setOrd($textCounter);
                    $texts[$textCounter] = $text;
                    $CI->em->persist($texts[$textCounter]);
                }
                //add the fields
                $fieldsCounter = 0;
                $fields = array();
                foreach ($serviceFields[$serviceId] as $fieldCode => $fieldValue) {
                    $fieldsCounter++;
                    $field = new \models\Proposal_services_fields();
                    $field->setServiceId($proposal_services[$k]->getServiceId());
                    $field->setFieldCode($fieldCode);
                    $field->setFieldValue($fieldValue);
                    $fields[$fieldsCounter] = $field;
                    $CI->em->persist($fields[$fieldsCounter]);
                }
            }
        }
        /*
         * add proposal images
         */
        $CI->em->flush(); //save so proposals have IDs
        //$folder1 = UPLOADPATH . '/proposals/' . $proposal->getProposalId();
        $folder1 = $proposal->getUploadDir();
        if (!is_dir($folder1)) {
            mkdir($folder1, 0777, true);
        }
        //$folder2 = UPLOADPATH . '/proposals/' . $proposal2->getProposalId();
        $folder2 = $proposal2->getUploadDir();
        if (!is_dir($folder2)) {
            mkdir($folder2, 0777, true);
        }

        // First Proposal Images

        $image5 = new \models\Proposals_images();
        $image5->setProposal($proposal);
        $image5->setOrder(1);
        $image5->setActive(1);
        $image5->setActivewo(1);
        $image5->setImage('wio3.jpg');
        $image5->setTitle($company->getCompanyName() . ' Work Zones');
        $CI->em->persist($image5);
        copy(POPULATE_PATH . '/wio3.jpg', $folder1 . '/wio3.jpg');

        $newImage1 = new \models\Proposals_images();
        $newImage1->setProposal($proposal);
        $newImage1->setOrder(2);
        $newImage1->setActive(1);
        $newImage1->setActivewo(1);
        $newImage1->setImageLayout(1);
        $newImage1->setImage('ethicon1.jpg');
        $newImage1->setTitle('Existing Conditions');
        $CI->em->persist($newImage1);
        copy(POPULATE_PATH . '/ethicon1.jpg', $folder1 . '/ethicon1.jpg');

        $newImage2 = new \models\Proposals_images();
        $newImage2->setProposal($proposal);
        $newImage2->setOrder(3);
        $newImage2->setActive(1);
        $newImage2->setActivewo(1);
        $newImage2->setImageLayout(1);
        $newImage2->setImage('ethicon2.jpg');
        $newImage2->setTitle('Existing Conditions');
        $CI->em->persist($newImage2);
        copy(POPULATE_PATH . '/ethicon2.jpg', $folder1 . '/ethicon2.jpg');

        $image = new \models\Proposals_images();
        $image->setProposal($proposal);
        $image->setOrder(4);
        $image->setActivewo(1);
        $image->setActive(1);
        $image->setImageLayout(1);
        $image->setImage('img1.jpg');
        $image->setTitle('New Asphalt Parking Lot Conditions');
        $CI->em->persist($image);
        copy(POPULATE_PATH . '/img1.jpg', $folder1 . '/img1.jpg');

        $image2 = new \models\Proposals_images();
        $image2->setProposal($proposal);
        $image2->setOrder(5);
        $image2->setActive(1);
        $image2->setActivewo(1);
        $image2->setImageLayout(1);
        $image2->setImage('img2.jpg');
        $image2->setTitle('New Asphalt Parking Lot Conditions');
        $CI->em->persist($image2);
        copy(POPULATE_PATH . '/img2.jpg', $folder1 . '/img2.jpg');

        // Second proposal images
        $image3 = new \models\Proposals_images();
        $image3->setProposal($proposal2);
        $image3->setOrder(1);
        $image3->setActive(1);
        $image->setActivewo(1);
        $image3->setImage('wio1.jpg');
        $image3->setTitle('Wheel It Off Image');
        $CI->em->persist($image3);

        copy(POPULATE_PATH . '/wio1.jpg', $folder2 . '/wio1.jpg');
        $image4 = new \models\Proposals_images();
        $image4->setProposal($proposal2);
        $image4->setOrder(1);
        $image4->setActive(1);
        $image4->setActivewo(1);
        $image4->setImage('wio2.jpg');
        $image4->setTitle('Wheel It Off Image');
        $CI->em->persist($image4);
        copy(POPULATE_PATH . '/wio2.jpg', $folder2 . '/wio2.jpg');
        /*
         * set up the company about us etc
         */
        $company->setAboutCompany('
        <p style="text-align: center;">
            <strong>
                <span style="font-size:16px;">We Solve Problems &amp; Make Pavement Maintenance Simple</span>
            </strong>
        </p>
        <p style="font-size:16px; line-height: 1.1;"><strong>' . $company->getCompanyName() . '</strong> 
        provides pavement design, maintenance &amp; construction 
        services to the residential, commercial, recreational and industrial markets within a 
        60-mile radius of providing service to the 
        <strong>' . $company->getCompanyCity() . ' ' . $company->getCompanyState() . '</strong> and ' .
            ' surrounding communities.</span>
        <br />
        <br />
        <span style="font-size:16px; line-height: 1.1;">
        <strong><em>Details, Facts and a Simple</em></strong>, easy to understand proposal should be the 
        first sign that we understand your needs and issues.  
        Compare this process and proposal to anyone else and you will see that we do not tell you... we show you!
        </p>');
        $company->setContractCopy('<p>
         You are hereby authorized to proceed with the work as identified in this contract. 
         By signing and returning this contract, you are authorized to proceed with the work as stated.<br />
         <br />
         We understand that if any additional work is required different than stated in the this proposal/contract 
         it must be in a new contract or added to this contract.<br />
         <br />
         Please see all attachments for special conditions that may pertain to aspects of this project.</p>');
        $company->setPaymentTermText('<p>
         I am authorized to approve and sign this project as described in this proposal as well as identified 
         below with our payment terms and options.<br />
         &nbsp;</p>');
        $company->setPaymentTerm(20);
        $CI->em->persist($company);
        //setup attachments
        $upload_dir = ATTACHMENTPATH . '/' . $company->getCompanyId();
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir);
        }
        $from_folder = POPULATE_PATH;
        $files = array();
        $files['admin'] = array(
            'Insurance & Workers Comp' => 'Layers Insurance _Work Comp Example.pdf',
        );
        $files['marketing'] = array(
            'Sealmaster MSDS Coal Tar' => 'Sealmaster SMCoalTarConc10-07.pdf',
            'Sealmaster Coal Tar Brochure' => 'Bro_CoalTarSealer-1.pdf',
            'Sealmaster Acrylic Sealer Brochure' => 'Bro_SAPS-1-1.pdf',
            'Crack Sealer Deery' => 'DEERY PLS  Crack Sealer.pdf',
            'Neyra Tarconite MSDS' => '102 Tarconite 04.pdf',
            'Neyra Taronite Brochure' => 'Tarconite 4Pg-1.pdf',
            'GemSeal Poly Tar Brochure' => 'Polytar Brochure-1.pdf',
        );
        //copy files and shit
        $attachments = array();
        $attachmentCounter = 0;
        foreach ($files as $category => $fileList) {
            foreach ($fileList as $fileTitle => $fileName) {
                $attachmentCounter++;
                $attachment = new \models\Attatchments();
                $attachment->setFileName($fileTitle);
                $attachment->setCategory($category);
                $attachment->setCompany($company);
                $attachment->setFilePath($fileName);
                $attachments[$k] = $attachment;
                $proposal->addAttatchment($attachments[$k]);
                $proposal2->addAttatchment($attachments[$k]);
                $CI->em->persist($attachments[$k]);
                //copy the file
                copy($from_folder . '/' . $fileName, $upload_dir . '/' . $fileName);
            }
        }
        //Send Proposal Email new system
        $layout = 'cool';

        // Load the default template
        $defaultTemplate = $CI->clientEmail->getDefaultTemplate(
            $company->getCompanyId(),
            \models\ClientEmailTemplateType::PROPOSAL
        );


            $uuid = Uuid::uuid4();
            $ppl = new  \models\ProposalPreviewLink();
            $ppl->setProposalId($proposal->getProposalId());
            $ppl->setUuid($uuid);
            $ppl->setEmail('mike@pavementlayers.com');
            $ppl->setCreatedAt(Carbon::now());
            $CI->em->persist($ppl);
            $CI->em->flush();
            $proposal->setProposalViewCount($proposal->getProposalViewCount() + 1);



        /* @var $defaultTemplate \models\ClientEmailTemplate */
        $etp = new EmailTemplateParser();
        $etp->setProposal($proposal);
        $etp->setProposalPreviewLink($ppl);
        $emailSettings = array(
            'recipient' => $account->getEmail(),
            'subject' => $etp->parse($defaultTemplate->getTemplateSubject()),
            'body' => $etp->parse($defaultTemplate->getTemplateBody()),
            'fromEmail' => $proposal->getClient()->getAccount()->getEmail(),
            'fromName' => $proposal->getClient()->getAccount()->getFullName() . ' via ' . SITE_NAME,
        );

        $proposalIds = [
            $proposal->getProposalId(),
            $proposal2->getProposalId()
        ];

        $jobData = [
            'proposalIds' => $proposalIds
        ];

        // Save the opaque image
        $CI->jobs->create($_ENV['QUEUE_HIGH'], 'jobs', 'preloadProposals', $jobData, 'preload proposals');

        $emailSettings['body'] = updateEmailLinks($emailSettings['body']);
        $CI->queue->addEmail($emailSettings, 420);

        // Send a copy to Mike 15 minutes after signup
        $emailSettings['recipient'] = 'mike@pavementlayers.com';
        $emailSettings['replyTo'] = $proposal->getOwner()->getEmail();
        $CI->queue->addEmail($emailSettings, 900);


        //save everything
        $CI->em->flush();
        updateProposalPrice($proposal->getProposalId());
        updateProposalPrice($proposal2->getProposalId());
        return true;
    } else {
        return false;
    }
}

function getServiceTexts($id, $companyId)
{
    $CI =& get_instance();
    $CI->load->database();
    $q = "SELECT distinct(st.textId), sdt.linkId, sdt.replacedBy FROM service_texts st
                        LEFT JOIN service_texts_order sto ON (st.textId = sto.textId and sto.company=" . $companyId . ")
                        LEFT JOIN service_deleted_texts sdt on ((st.textId = sdt.textId) and (sdt.company = " . $companyId . "))
                        WHERE ((st.service = " . $id . ") AND (st.company = " . $companyId . " OR st.company = 0))
                        ORDER BY COALESCE( sto.ord, 999999 ) , st.ord";
    $txts = $CI->db->query($q);
    foreach ($txts->result() as $txt) {
        $text = $CI->em->find('models\ServiceText', $txt->textId);
        if ($text) {
            $texts[$txt->textId] = array(
                'text' => $text,
                'deleted' => $txt->linkId,
                'replacedBy' => $txt->replacedBy
            );
        }
    }
    //move deleted to last and replaced texts under the item that replaces them
    foreach ($texts as $id => $text) {
        if ($text['deleted'] && $text['replacedBy'] && isset($texts[$text['replacedBy']])) {
            unset($texts[$id]);
            $texts[$text['replacedBy']]['replacedText'] = $text;
        } elseif ($text['deleted']) {
            unset($texts[$id]);
            //$texts[$id] = $text;
        }
    }
    $texts2 = array();
    foreach ($texts as $txt) {
        $text = $txt['text'];
        if (!$txt['deleted']) {
            $texts2[] = $text->getText();
        }
    }
    return $texts2;
}


//helper for adding http
function addHttp($url)
{
    if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
        $url = "http://" . $url;
    }
    return $url;
}

function updateOrphanBranches($companyId)
{
    $CI =& get_instance();
    $CI->load->database();
    $CI->db->query("update accounts set branch = 0 where (branch > 0) and (company={$companyId}) and (branch not in (select branchId from branches where company={$companyId}))");
}

function human_filesize($bytes, $decimals = 2)
{
    $size = array('B', 'kB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
    $factor = floor((strlen($bytes) - 1) / 3);
    return sprintf("%.{$decimals}f", $bytes / pow(1024, $factor)) . @$size[$factor];
}

function readableValue($n)
{
    // first strip any formatting;
    $n = (0 + (int)str_replace(",", "", $n));

    // is this a number?
    if (!is_numeric($n)) {
        return false;
    }

    if ($n > 0) {
        // now filter it;
        if ($n > 1000000000000) {
            return round(($n / 1000000000000), 2) . 'tn';
        } elseif ($n > 1000000000) {
            return round(($n / 1000000000), 2) . 'b';
        } elseif ($n >= 1000000) {
            return round(($n / 1000000), 2) . 'm';
        } elseif ($n > 1000) {
            return round(($n / 1000), 1) . 'k';
        }
    } elseif ($n < 0) {
        if ((0 - $n) > 1000000000) {
            return '(' . str_replace('-', '', round(($n / 1000000000), 2)) . 'b)';
        } elseif ((0 - $n) > 1000000) {
            return '(' . str_replace('-', '', round(($n / 1000000), 2)) . 'm)';
        } elseif ((0 - $n) > 1000) {
            return '(' . str_replace('-', '', round(($n / 1000), 1)) . 'k)';
        } else {
            return '(' . str_replace('-', '', round(($n), 1)) . ')';
        }
    }

    return number_format($n);
}


function readableValueWithDollar($n)
{
    // first strip any formatting;
    $n = (0 + str_replace(",", "", $n));

    // is this a number?
    if (!is_numeric($n)) {
        return false;
    }

    if ($n > 0) {
        // now filter it;
        if ($n > 1000000000000) {
            return round(($n / 1000000000000), 2) . 'tn';
        } elseif ($n > 1000000000) {
            return round(($n / 1000000000), 2) . 'b';
        } elseif ($n >= 1000000) {
            return round(($n / 1000000), 2) . 'm';
        } elseif ($n > 1000) {
            return round(($n / 1000), 1) . 'k';
        }
    } elseif ($n < 0) {
        if ((0 - $n) > 1000000000) {
            return '($' . str_replace('-', '', round(($n / 1000000000), 2)) . 'b)';
        } elseif ((0 - $n) > 1000000) {
            return '($' . str_replace('-', '', round(($n / 1000000), 2)) . 'm)';
        } elseif ((0 - $n) > 1000) {
            return '($' . str_replace('-', '', round(($n / 1000), 1)) . 'k)';
        } else {
            return '($' . str_replace('-', '', round(($n), 1)) . ')';
        }
    }

    return number_format($n);
}

function mobileReadableValue($n)
{
    // first strip any formatting;
    $n = (0 + str_replace(",", "", $n));

    // is this a number?
    if (!is_numeric($n)) {
        return false;
    }

    if ($n > 0) {
        // now filter it;
        if ($n > 1000000000000) {
            return round(($n / 1000000000000)) . 'tn';
        } elseif ($n > 1000000000) {
            return round(($n / 1000000000)) . 'b';
        } elseif ($n >= 1000000) {
            return round(($n / 1000000)) . 'm';
        } elseif ($n > 1000) {
            return round(($n / 1000)) . 'k';
        }
    } elseif ($n < 0) {
        if ((0 - $n) > 1000000000) {
            return '(' . str_replace('-', '', round(($n / 1000000000))) . 'b)';
        } elseif ((0 - $n) > 1000000) {
            return '(' . str_replace('-', '', round(($n / 1000000))) . 'm)';
        } elseif ((0 - $n) > 1000) {
            return '(' . str_replace('-', '', round(($n / 1000))) . 'k)';
        } else {
            return '(' . str_replace('-', '', round(($n))) . ')';
        }
    }

    return number_format($n);
}

function getQuarterStartTime()
{

    switch (date('F')) {
        case 'January':
        case 'February':
        case 'March':
            $start = strtotime('midnight first day of January');
            break;

        case 'April':
        case 'May':
        case 'June':
            $start = strtotime('midnight first day of April');
            break;

        case 'July':
        case 'August':
        case 'September':
            $start = strtotime('midnight first day of July');
            break;

        case 'October':
        case 'November':
        case 'December':
            $start = strtotime('midnight first day of October');
            break;
    }

    return $start;
}

/**
 * @param string $range
 * @return array
 */
function getRangeStartFinish($range)
{
    // Calculate the start time based on the time period
    switch ($range) {
        case 'day':
            $start = Carbon::create()->startOfDay()->timestamp;
            $finish = Carbon::create()->endOfDay()->timestamp;
            break;

        case 'week':
            $start = strtotime('midnight Monday this week');
            $start = Carbon::create()->startOfWeek()->startOfDay()->timestamp;
            $finish = Carbon::create()->endOfDay()->timestamp;
            break;

        case 'month':
            $start = Carbon::create()->startOfMonth()->startOfDay()->timestamp;
            $finish = Carbon::create()->endOfDay()->timestamp;
            break;

        case 'quarter':
            $start = getQuarterStartTime();
            $finish = Carbon::create()->endOfDay()->timestamp;
            break;

        case 'year':
            $start = Carbon::create()->startOfYear()->startOfDay()->timestamp;
            $finish = Carbon::create()->endOfDay()->timestamp;
            break;

        case 'prevYear':
            $start = Carbon::create()->subYear(1)->startOfYear()->startOfDay()->timestamp;
            $finish = Carbon::create()->subYear(1)->endOfYear()->endOfDay()->timestamp;
            break;
            
        case 'last12thMonth':
            $start = Carbon::now()->subYear()->startOfDay()->timestamp;
            $finish = Carbon::now()->timestamp;
            break;
    }

    $time = [];
    $time['start'] = $start;
    $time['finish'] = $finish;

    return $time;
}


function removePriceFormatting($priceString)
{
    $search = array('$', ',');
    $replace = array('', '');

    return str_replace($search, $replace, $priceString);
}


function humanTiming($time)
{

    $time = time() - $time; // to get the time since that moment
    $time = ($time < 1) ? 1 : $time;
    $tokens = array(
        31536000 => 'year',
        2592000 => 'month',
        604800 => 'week',
        86400 => 'day',
        3600 => 'hour',
        60 => 'minute',
        1 => 'second'
    );

    foreach ($tokens as $unit => $text) {
        if ($time < $unit) {
            continue;
        }
        $numberOfUnits = floor($time / $unit);
        return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
    }
}

function createUniqueId()
{
    $ci = get_instance();
    $ci->load->helper('string');

    $string = random_String('alnum', 16);

    return $string;
}

function trimNewline($string)
{

    if (strlen($string) > 0) {
        $firstChar = substr($string, 0, 1);

        if ($firstChar == PHP_EOL) {
            $string = substr($string, 1);
        }
    }
    return trim($string);
}

function getUserPrice($numUsers)
{

    if ($numUsers < 6) {
        $userRate = 2200;
    } elseif ($numUsers < 21) {
        $userRate = 2000;
    } else {
        $userRate = 1800;
    }

    return $userRate;
}

function getSubscriptionPlanCode($numUsers)
{

    if ($numUsers < 6) {
        $planCode = 'PL1';
    } elseif ($numUsers < 21) {
        $planCode = 'PL2';
    } else {
        $planCode = 'PL3';
    }

    return $planCode;
}

/**
 * Return the domain from an email
 * @param $email
 * @return string
 */
function getDomainFromEmail($email)
{
    return substr(strrchr($email, "@"), 1);
}

function updateEmailLinks($body)
{
    $search = 'proposals/live/views/';
    $replace = 'proposals/live/view/';

    return str_replace($search, $replace, $body);
}

function populatePmd()
{
    // Company ID
    $id = 3;

    $s = array('$', ',');
    $r = array('', '');
    $CI =& get_instance();
    $CI->load->database();

    //load company
    $company = $CI->em->find('models\Companies', $id);
    $account = $company->getAdministrator();

    // Account
    $clientAccount1 = new \models\ClientCompany();
    $clientAccount1->setCreated(time());
    $clientAccount1->setOwnerCompany($company);
    $clientAccount1->setOwnerUser($account);
    $clientAccount1->setName('Ethicon J & J Company');
    $CI->em->persist($clientAccount1);

    $CI->em->flush();

    // Contact
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
    $client->setAddress('4545 Creek Rd');
    $client->setCity('Cincinnati');
    $client->setZip('45242');
    $client->setCountry('USA');
    $client->setAccount($account);
    $client->setCompany($company);
    $client->setClientAccount($clientAccount1);
    $CI->em->persist($client);

    $CI->em->flush();

    // Dummy Proposal
    $proposalRepository = new \Pms\Repositories\Proposal();

    $proposal = $proposalRepository->create();
    $proposal->setProjectAddress('4545 Creek Rd');
    $proposal->setProjectCity('Cincinnati');
    $proposal->setProjectState('OH');
    $proposal->setProjectZip('45242');
    $proposal->setProjectName('Blue Ash Ohio Campus');
    $proposal->setProposalTitle(SITE_NOUN . ' Maintenance Proposal');
    $proposal->setPaymentTerm($company->getPaymentTerm());
    $proposal->setOwner($account);

    $CI->load->database();
    $openStatus = $client->getCompany()->getDefaultStatus(\models\Status::OPEN);
    $proposal->setProposalStatus($openStatus);
    $proposal->setStatusChangeDate(time());
    $proposal->setPaymentTerm(20);
    $proposal->setTexts('45,48,92,100,101,49,93,47,95,50,94,51,102,52,96,53,97,54,98,55,99,56,57,1285,1286,1287,1289,1893,1894,1895,1896,1897,125,1155,1156,1157,1158,1159,1160,1161,1162,1163,1164,1165,1166,1168,1169,2016,2017,2018,2019,2020,2276');
    $proposal->setTextsCategories('1:0|36:0|37:1|191:0|192:0|193:0|194:0|204:0|246:1');
    $proposal->setClient($client);
    $CI->em->persist($proposal);

    /*
         * Add Services to the above proposals
         */
    $serviceIds = array(8 => '$4,367', 38 => '$6,900', 27 => '$234,657', 31 => '$127,400', 3 => '$2,374');
    $serviceFields = array(
        8 => array(
            'measurement' => '299',
            'area_unit' => 'square yards',
            'depth' => '2',
            'depth_unit' => 'Inches',
        ),
        38 => array(
            'lineal_feet_cracks' => '10,000'
        ),
        27 => array(
            'area' => '7,000',
            'area_unit' => 'square yards',
            'number_of_coats' => '2',
            'trips' => '1',
            'day_of_week' => 'Weekend',
            'application' => 'Spray',
            'warranty' => '1 Year',
        ),
        31 => array(
            'area_of_paving' => '17,710',
            'unit' => 'square yards',
            'tons_of_leveling' => '12',
            'depth_of_paving' => '2',
            'number_of_parking_blocks' => '57',
            'trips' => '2',
        ),
        3 => array(),
    );
    $serviceTitles = [
        8 => 'Asphalt Milling Repair | Green Map Area',
        38 => 'Crack Sealing | White Map Area',
        27 => 'Premium Sealcoating',
        31 => 'Mill + Pave Existing Parking Lot | Blue Map Area',
        3 => 'Line Striping',
    ];
    $k = 0;
    $proposal_services = array();
    $textCounter = 0;
    foreach ($serviceIds as $serviceId => $servicePrice) {
        $k++;
        //get service name and texts
        $service = $CI->em->find('models\Services', $serviceId);
        if ($service) {
            $proposal_services[$k] = new \models\Proposal_services();
            $proposal_services[$k]->setOrd($k);
            $proposal_services[$k]->setPrice($servicePrice);
            $proposal_services[$k]->setProposal($proposal->getProposalId());
            $proposal_services[$k]->setInitialService($serviceId);
            $proposal_services[$k]->setServiceName($serviceTitles[$serviceId]);
            $proposal_services[$k]->setOptional(0);
            $proposal_services[$k]->setTax(0);
            $proposal_services[$k]->setApproved(1);
            // Set optional for the new overlay
            if ($serviceId == 31) {
                $proposal_services[$k]->setOptional(1);
            }

            $CI->em->persist($proposal_services[$k]);
            $CI->em->flush(); //save the proposal service so it has a valid ID
            //add the texts
            $txts = (getServiceTexts($serviceId, $company->getCompanyId()));
            $texts = array();
            foreach ($txts as $textValue) {
                $textCounter++;
                $text = new \models\Proposal_services_texts();
                $text->setServiceId($proposal_services[$k]->getServiceId());
                $text->setText($textValue);
                $text->setOrd($textCounter);
                $texts[$textCounter] = $text;
                $CI->em->persist($texts[$textCounter]);
            }
            //add the fields
            $fieldsCounter = 0;
            $fields = array();
            foreach ($serviceFields[$serviceId] as $fieldCode => $fieldValue) {
                $fieldsCounter++;
                $field = new \models\Proposal_services_fields();
                $field->setServiceId($proposal_services[$k]->getServiceId());
                $field->setFieldCode($fieldCode);
                $field->setFieldValue($fieldValue);
                $fields[$fieldsCounter] = $field;
                $CI->em->persist($fields[$fieldsCounter]);
            }
        }
    }

    /*
         * add proposal images
         */
    $CI->em->flush(); //save so proposals have IDs
    //$folder1 = UPLOADPATH . '/proposals/' . $proposal->getProposalId();
    $folder1 = $proposal->getUploadDir();
    if (!is_dir($folder1)) {
        mkdir($folder1, 0777, true);
    }

    $image = new \models\Proposals_images();
    $image->setProposal($proposal);
    $image->setOrder(2);
    $image->setActivewo(1);
    $image->setActive(1);
    $image->setImage('img1.jpg');
    $image->setTitle('New Asphalt Parking Lot Conditions');
    $CI->em->persist($image);
    copy(POPULATE_PATH . '/img1.jpg', $folder1 . '/img1.jpg');
    $image2 = new \models\Proposals_images();
    $image2->setProposal($proposal);
    $image2->setOrder(3);
    $image2->setActive(1);
    $image2->setActivewo(1);
    $image2->setImage('img2.jpg');
    $image2->setTitle('New Asphalt Parking Lot Conditions');
    $CI->em->persist($image2);
    copy(POPULATE_PATH . '/img2.jpg', $folder1 . '/img2.jpg');
    $image3 = new \models\Proposals_images();
    $image3->setProposal($proposal);
    $image3->setOrder(4);
    $image3->setActive(1);
    $image3->setActivewo(1);
    $image3->setImage('img3.jpg');
    $image3->setTitle('Sealcoating Needed');
    $CI->em->persist($image3);
    copy(POPULATE_PATH . '/img3.jpg', $folder1 . '/img3.jpg');
    $image4 = new \models\Proposals_images();
    $image4->setProposal($proposal);
    $image4->setOrder(5);
    $image4->setActive(1);
    $image4->setActivewo(1);
    $image4->setImage('img4.jpg');
    $image4->setTitle('Existing Crack');
    $CI->em->persist($image4);
    copy(POPULATE_PATH . '/img4.jpg', $folder1 . '/img4.jpg');
    $image5 = new \models\Proposals_images();
    $image5->setProposal($proposal);
    $image5->setOrder(1);
    $image5->setActive(1);
    $image5->setActivewo(1);
    $image5->setImage('wio3.jpg');
    $image5->setTitle($company->getCompanyName() . ' Work Zones');
    $CI->em->persist($image5);
    copy(POPULATE_PATH . '/wio3.jpg', $folder1 . '/wio3.jpg');

    //setup attachments
    $upload_dir = ATTACHMENTPATH . '/' . $company->getCompanyId();
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir);
    }
    $from_folder = POPULATE_PATH;
    $files = array();
    $files['admin'] = array(
        'Insurance & Workers Comp' => 'Layers Insurance _Work Comp Example.pdf',
    );
    $files['marketing'] = array(
        'Sealmaster MSDS Coal Tar' => 'Sealmaster SMCoalTarConc10-07.pdf',
        'Sealmaster Coal Tar Brochure' => 'Bro_CoalTarSealer-1.pdf',
        'Sealmaster Acrylic Sealer Brochure' => 'Bro_SAPS-1-1.pdf',
        'Crack Sealer Deery' => 'DEERY PLS  Crack Sealer.pdf',
        'Neyra Tarconite MSDS' => '102 Tarconite 04.pdf',
        'Neyra Taronite Brochure' => 'Tarconite 4Pg-1.pdf',
        'GemSeal Poly Tar Brochure' => 'Polytar Brochure-1.pdf',
    );
    //copy files and shit
    $attachments = array();
    $attachmentCounter = 0;
    foreach ($files as $category => $fileList) {
        foreach ($fileList as $fileTitle => $fileName) {
            $attachmentCounter++;
            $attachment = new \models\Attatchments();
            $attachment->setFileName($fileTitle);
            $attachment->setCategory($category);
            $attachment->setCompany($company);
            $attachment->setFilePath($fileName);
            $attachments[$k] = $attachment;
            $proposal->addAttatchment($attachments[$k]);
            $CI->em->persist($attachments[$k]);
            //copy the file
            copy($from_folder . '/' . $fileName, $upload_dir . '/' . $fileName);
        }
    }

    $layout = 'cool';
    //save everything
    $CI->em->flush();
    updateProposalPrice($proposal->getProposalId());
}

function trimmedCurrency($amount)
{
    return str_replace('.00', '', number_format($amount, 2));
}

function trimmedQuantity($amount)
{
    return str_replace('.00', '', number_format($amount, 2));
}

/**
 * Method to redirect to the previous page
 */
if (!function_exists('redirectPreviousPage')) {
    function redirectPreviousPage()
    {
        if (isset($_SERVER['HTTP_REFERER'])) {
            header('Location: ' . $_SERVER['HTTP_REFERER']);
        } else {
            header('Location: http://' . $_SERVER['SERVER_NAME']);
        }

        exit;
    }
}

function secondsToTime($inputSeconds) {
    $secondsInAMinute = 60;
    $secondsInAnHour = 60 * $secondsInAMinute;
    $secondsInADay = 24 * $secondsInAnHour;

    // Extract days
    $days = floor($inputSeconds / $secondsInADay);

    // Extract hours
    $hourSeconds = $inputSeconds % $secondsInADay;
    $hours = floor($hourSeconds / $secondsInAnHour);

    // Extract minutes
    $minuteSeconds = $hourSeconds % $secondsInAnHour;
    $minutes = floor($minuteSeconds / $secondsInAMinute);

    // Extract the remaining seconds
    $remainingSeconds = $minuteSeconds % $secondsInAMinute;
    $seconds = ceil($remainingSeconds);

    // Format and return
    $timeParts = [];
    $sections = [
        'd' => (int)$days,
        'h' => (int)$hours,
        'm' => (int)$minutes,
        's' => (int)$seconds,
    ];

    foreach ($sections as $name => $value){
        if ($value > 0){
            $timeParts[] = $value . $name;
        }
    }

    if (!count($timeParts)) {
        return '0s';
    }

    return implode(' ', $timeParts);
}

 