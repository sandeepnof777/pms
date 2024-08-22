<?php

namespace Pms\Repositories;

use Carbon\Carbon;
use Doctrine\ORM\Query\ResultSetMapping;
use EmailTemplateParser;
use models\Accounts;
use models\AdminGroupResend;
use models\AdminGroupResendEmail;
use models\Companies;
use models\ProposalSectionCompanyOrder;
use models\WorkOrderSectionCompanyOrder;
use models\ProposalSectionIndividualOrder;
use models\ZohoSubscription;
use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;

class Company extends RepositoryAbstract
{
    use DBTrait;

    /**
     * @param $id
     * @return mixed
     */
    public function get($id)
    {
        return $this->getSingleResult("select * from companies where companyId = {$id}");
    }

    /**
     * @param int $companyId
     */
    public function resetUserLayouts($companyId)
    {
        $this->db->query(
            "UPDATE accounts 
              SET layout = NULL
              WHERE company = {$companyId}"
        );
    }

    /**
     * @param $companyId
     * @param null $branchId
     * @param bool $array
     * @return array
     */
    public function getSalesAccounts($companyId, $branchId = null, $array = false)
    {
        $dql = "SELECT a
                FROM \models\Accounts a
                WHERE a.company = :companyId
                AND a.deleted = 0
                AND a.sales = 1";

        // Add branch to query if we have one
        if (isset($branchId)) {
            $dql .= " AND a.branch = :branchId";
        }

        // Complete the query
        $dql .= " ORDER BY a.firstName ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter('companyId', $companyId);

        if (isset($branchId)) {
            $query->setParameter('branchId', $branchId);
        }

        $accounts = $query->getResult();

        if ($array) {
            $out = [];
            foreach ($accounts as $acc) {
                $out[$acc->getAccountId()] = $acc->getFullName();
            }
            return $out;
        }

        return $accounts;
    }

    /**
     * @param $companyId
     * @param null $branchId
     * @param bool $array
     * @return array
     */
    public function getSalesAndSecretaryAccounts($companyId, $branchId = null, $array = false)
    {
        $dql = "SELECT a
                FROM \models\Accounts a
                WHERE a.company = :companyId
                AND a.deleted = 0
                AND (a.sales = 1 OR a.secretary = 1)";

        // Add branch to query if we have one
        if (isset($branchId)) {
            $dql .= " AND a.branch = :branchId";
        }

        // Complete the query
        $dql .= " ORDER BY a.firstName ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter('companyId', $companyId);

        if (isset($branchId)) {
            $query->setParameter('branchId', $branchId);
        }

        $accounts = $query->getResult();

        if ($array) {
            $out = [];
            foreach ($accounts as $acc) {
                $out[$acc->getAccountId()] = $acc->getFullName();
            }
            return $out;
        }

        return $accounts;
    }

    public function getPermittedAccounts(Accounts $account, $array = false)
    {
        // Admin, full access, return all
        if ($account->hasFullAccess()) {
            return $this->getAccounts($account->getCompanyId(), null, $array);
        }

        // Branch Manager
        if ($account->isBranchAdmin()) {
            return $this->getAccounts($account->getCompanyId(), $account->getBranch(), $array);
        }

        // User, return self
        if ($array) {
            return [$account->getAccountId() => $account->getFullName()];
        }

        return [
            $account
        ];
    }

    /**
     * @param $companyId
     * @param null $branchId
     * @param bool $array
     * @return array
     */
    public function getAccounts($companyId, $branchId = null, $array = false)
    {
        // Base query
        $dql = "SELECT a
            FROM \models\Accounts a
            WHERE a.company = :companyId";

        // Add branch to query if needed
        if ($branchId) {
            $dql .= " AND a.branch = :branchId";
        }

        // Order
        $dql .= " ORDER BY a.firstName ASC";

        // Create query with default params
        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $companyId);

        // Add branch param if necessary
        if ($branchId) {
            $query->setParameter(':branchId', $branchId);
        }

        $accounts = $query->getResult();

        if ($array) {
            $out = [];
            foreach ($accounts as $acc) {
                $out[$acc->getAccountId()] = $acc->getFullName();
            }
            return $out;
        }

        return $query->getResult();
    }


    /**
     * @param $companyId
     * @param bool $array
     * @return array
     */
    public function getMainBranchAccounts($companyId, $array = false)
    {
        // Base query
        $dql = "SELECT a
            FROM \models\Accounts a
            WHERE a.company = :companyId AND a.deleted = 0
            AND (a.branch = 0 OR a.branch IS NULL) ORDER BY a.firstName ASC";


        // Create query with default params
        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $companyId);

        

        $accounts = $query->getResult();

        if ($array) {
            $out = [];
            foreach ($accounts as $acc) {
                $out[$acc->getAccountId()] = $acc->getFullName();
            }
            return $out;
        }

        return $query->getResult();
    }

    /**
     * @param $companyId
     * @param bool $array
     * @return array
     */
    public function getStatuses($companyId, $array = false)
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('\models\Status', 's');
        $rsm->addFieldResult('s', 'id', 'id');
        $rsm->addFieldResult('s', 'text', 'text');
        $rsm->addFieldResult('s', 'color', 'color');
        $rsm->addFieldResult('s', 'company', 'company');
        $rsm->addFieldResult('s', 'sales', 'sales');
        $rsm->addFieldResult('s', 'prospect', 'prospect');
        $rsm->addFieldResult('s', 'on_hold', 'on_hold');

        $q = "SELECT s.id, s.text, s.company, s.sales, s.prospect, s.on_hold, s.color
              FROM statuses s
              LEFT JOIN company_status_config csc ON s.id = csc.status_id AND csc.company_id = :companyId
              WHERE (
                s.company IS NULL
                OR s.company = :companyId
              )
              AND (
                csc.visible IS NULL 
                OR csc.visible = 1
              )
              AND s.visible = 1
              ORDER BY csc.ord,s.displayOrder,s.id";

        $query = $this->em->createNativeQuery($q, $rsm);
        $query->setParameter('companyId', $companyId);
        //Cache It
        $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_STATUSES . $companyId);
        $statuses = $query->getResult();
        $query->disableResultCache();

        if ($array) {

            $out = array();
            $ao = new \ArrayObject($statuses);

            if ($array) {
                $ai = $ao->getIterator();
                while ($ai->valid()) {
                    $out[$ai->current()->getStatusId()] = $ai->current()->getText();
                    $ai->next();
                }
            }

            return $out;
        }

        return $statuses;
    }

    public function clearStatusConfig($companyId)
    {
        $this->db->query(
            "DELETE FROM company_status_config 
              WHERE company_id = {$companyId}"
        );
    }

    /**
     * @param $companyId
     * @param bool $array
     * @return array
     */
    public function getActiveSortedAccounts($companyId, $array = false)
    {
        $dql = "SELECT a
                FROM \models\Accounts a
                WHERE a.company = :companyId
                AND a.deleted = 0
                AND a.secretary = 0
                AND a.sales = 1
                ORDER BY a.firstName ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter('companyId', $companyId);

        $accounts = $query->getResult();

        if ($array) {
            $out = [];
            foreach ($accounts as $acc) {
                $out[$acc->getAccountId()] = $acc->getFullName();
            }
            return $out;
        }

        return $accounts;
    }

    /**
     * @param Accounts $account
     * @param bool $sec
     * @param bool $deleted
     * @return array|Accounts[]
     */
    public function getVisibleAccounts(Accounts $account, $sec = true, $deleted = false)
    {
        // Admin, full access, return all
        if ($account->hasFullAccess()) {
            return $this->getAccounts($account->getCompanyId(), $sec, $deleted);
        }

        // Branch Manager
        if ($account->isBranchAdmin()) {
            return $this->getAccounts($account->getCompanyId(), $sec, $deleted, $account->getBranch());
        }

        // User, return self
        return [
            $account
        ];
    }

    /**
     * Returns the formatted string to be saved into the database with the category id's for the selected custom text categories
     * @param $companyId
     * @return string
     */
    public function getDefaultTextCategories($companyId)
    {
        $categories = [];
        $query = $this->db->query("SELECT (concat(cc.categoryId, ':', (select count(id) as enabled from customtext_default_categories where categoryId = cc.categoryId and company = $companyId))) as val
                FROM customtext_categories cc WHERE cc.company = 0 OR cc.company = {$companyId}");
        foreach ($query->result() as $row) {
            $categories[] = $row->val;
        }
        return implode('|', $categories);
    }

    /**
     * @return array
     */
    public function getQbCompanies()
    {
        $dql = "SELECT c
                FROM \models\Companies c
                WHERE c.qb_setting_id > 0";

        $query = $this->em->createQuery($dql);

        return $query->getResult();
    }

    function quickbookSyncCompanies(){

        $sql = "SELECT DISTINCT c.companyId FROM companies AS c
            LEFT JOIN proposals AS p ON p.company_id = c.companyId AND p.QBSyncFLAG IN (1,3)
            LEFT JOIN clients AS cl ON cl.company = c.companyId AND  cl.QBSyncFLAG IN (1,3)
            LEFT JOIN company_qb_services AS cqs ON cqs.company_id = c.companyId AND cqs.QBSyncFLAG IN (1,3)
            LEFT JOIN quickbook_settings AS qs ON qs.company_id = c.companyId 
            WHERE  c.qb_setting_id > 0 AND qs.qb_connection_type IS NULL";

        $company_ids  = $this->db->query($sql)->result();
        $companies =  array();
        foreach($company_ids as $company_id){
           
            $companies[] = $this->em->find('\models\Companies', $company_id->companyId);
        }
        
        return $companies;
    }

    /**
     * @return array|int|string
     */
    public function getActiveCompanies()
    {
        $dql = "SELECT c
                FROM \models\Companies c 
                WHERE c.companyStatus = 'Active'";

        $query = $this->em->createQuery($dql);
        return $query->getResult();
    }

    /**
     * @return array|int|string
     */
    public function getEmailWhitelistCompanies()
    {
        $dql = "SELECT c
                FROM \models\Companies c 
                WHERE c.companyStatus = 'Active'
                OR c.companyStatus = 'Trial'";

        $query = $this->em->createQuery($dql);
        return $query->getResult();
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getSubscriptionValues(Companies $company)
    {

        $accounts = $company->getAllAccounts();

        $numUsers = 0;
        $numSecretaries = 0;

        foreach ($accounts as $account) {
            /* @var $account \models\Accounts */

            if ($account->isSecretary()) {
                $numSecretaries++;
            } else {
                $numUsers++;
            }
        }

        $data = [
            'numUsers' => $numUsers,
            'numSecretaries' => $numSecretaries,
        ];

        return $data;
    }

    /**
     * @param Companies $company
     */
    public function createSubscription(Companies $company)
    {
        return;
        // Load the repos
        $cr = $this->getCompanyRepository();
        $zsr = $this->getZohoSubscriptionsRepository();
        // Get the company admin
        $companyAdmin = $company->getAdministrator();

        if ($companyAdmin) {

            if ($company->getZsCustomerId()) {
                $customerId = $company->getZsCustomerId();
            } else {
                // Build the data for the customer
                $customerData = $cr->buildZsCustomerData($company);
                $customer = $zsr->createCustomer($customerData);
                $customerId = $customer['customer_id'];
                // Save the customer ID against the company
                $company->setZsCustomerId($customerId);
            }

            if ($customerId) {
                // Construct local subscriptions
                $subscriptions = $cr->buildLocalSubscriptions($company);

                foreach ($subscriptions as $start => $localSubscription) {
                    /* @var $localSubscription \models\ZohoSubscription */

                    $startDate = Carbon::createFromFormat('Y-m-d', $start);
                    // Earliest a subscription can be is tomorrow (so it's no considered paid. So lets's grab an instance of that
                    $earliest = Carbon::tomorrow()->startOfDay();
                    // Subtract 45 days from expiry to generate the invoice ahead of time
                    $startDate->subDays(45);
                    // Default the invoice date to the start date
                    $invoiceDate = $startDate;

                    // Check that it's nt before the earliest
                    if ($startDate->lessThan($earliest)) {
                        // It is, so set it to tomorrow
                        $invoiceDate = $earliest;
                    }

                    // Build it and push it to Zoho
                    $subData = $localSubscription->buildSubscriptionData();
                    $subData['customer_id'] = $customerId;
                    $subData['starts_at'] = $invoiceDate->toDateString();
                    // Add the description
                    $subData['plan']->plan_description = $localSubscription->getNotes();

                    $subscription = $zsr->addSubscriptionToCustomer($subData);

                    // Save the local version - now has the subscription id
                    $localSubscription->setZsId($subscription['subscription']['subscription_id']);
                    $this->em->persist($localSubscription);
                }
                $this->em->flush();
            }
        }
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function buildZsCustomerData(Companies $company)
    {
        $customerData = [];

        $companyAdmin = $company->getAdministrator();

        if ($companyAdmin) {
            $billingAddress = new \stdClass();
            $billingAddress->street = $company->getCompanyAddress();
            $billingAddress->city = $company->getCompanyCity();
            $billingAddress->state = $company->getCompanyState();
            $billingAddress->zip = $company->getCompanyZip();

            $customerData = [
                'display_name' => $companyAdmin->getFullName(),
                'first_name' => $companyAdmin->getFirstName(),
                'last_name' => $companyAdmin->getLastName(),
                'email' => $companyAdmin->getEmail(),
                'company_name' => $company->getCompanyName(),
                'website' => $company->getCompanyWebsite(),
                'billing_address' => $billingAddress
            ];
        }

        return $customerData;
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function buildLocalSubscriptions(Companies $company)
    {
        $accounts = $company->getAllAccounts();

        $totalUsers = 0;
        $totalWio = 0;
        $totalSec = 0;

        $expiryDates = [];

        foreach ($accounts as $account) {

            $expiryDate = Carbon::createFromTimestamp($account->getExpires());
            $dateString = $expiryDate->toDateString();

            // Create the key if it doesn't exist
            if (!array_key_exists($dateString, $expiryDates)) {
                $expiryDates[$dateString] = [];
                $expiryDates[$dateString]['accounts'][] = $account->getAccountId();
            } else {
                $expiryDates[$dateString]['accounts'][] = $account->getAccountId();
            }
        }

        foreach ($expiryDates as $dateString => $data) {

            $formattedDate = Carbon::createFromFormat('Y-m-d', $dateString)->addYear()->format('m/d/Y');

            $subUsers = [];
            $numUsers = 0;
            $numWio = 0;
            $numSec = 0;

            foreach ($data['accounts'] as $accountId) {

                $account = $this->em->findAccount($accountId);
                $subUsers[] = $account->getFullName();
                if ($account->isSecretary()) {
                    $numSec++;
                } else {
                    $numUsers++;
                }
            }

            $expiryDates[$dateString]['ref'] = implode('/', $data['accounts']);
            $expiryDates[$dateString]['notes'] = 'Account(s) for renewal: ' . implode(', ', $subUsers) . ' until ' . $formattedDate;
            $expiryDates[$dateString]['plu'] = $numUsers;
            $expiryDates[$dateString]['wio'] = $numWio;
            $expiryDates[$dateString]['sec'] = $numSec;

            $totalUsers += $numUsers;
            $totalWio += $numWio;
            $totalSec += $numSec;
        }

        $userRate = getUserPrice($totalUsers);
        $planCode = getSubscriptionPlanCode($totalUsers);

        $subscriptions = [];

        foreach ($expiryDates as $expiryDate => $expiryData) {

            // Now put the relevant info into the database
            $zs = new ZohoSubscription();
            $zs->setCompanyId($company->getCompanyId());
            $zs->setExpiry(Carbon::createFromFormat('Y-m-d', $expiryDate));
            $zs->setUpdatedAt(Carbon::now());
            $zs->setPlu($expiryData['plu']);
            $zs->setWio($expiryData['wio']);
            $zs->setSec($expiryData['sec']);
            $zs->setRef($expiryData['ref']);
            $zs->setNotes($expiryData['notes']);
            $zs->setUserRate($userRate);
            $zs->setPlanCode($planCode);

            $subscriptions[$expiryDate] = $zs;
        }

        return $subscriptions;

    }

    /**
     * @param Companies $company
     */
    public function updateSubscriptions(Companies $company)
    {
        return;

        $zsr = $this->getZohoSubscriptionsRepository();
        // Update/Create subscriptions
        $newSubData = $this->buildLocalSubscriptions($company);

        foreach ($newSubData as $subData) {
            /* @var $subData \models\ZohoSubscription */

            $newSubExpiry = $subData->getExpiry();

            try {
                $existingSub = $this->getSubscriptionFromDate($company->getCompanyId(), $newSubExpiry);
                /* @var $existingSub \models\ZohoSubscription */

                // Found the subscription for this day, so update it
                $existingSub->setUpdatedAt(Carbon::now());
                $existingSub->setPlu($subData->getPlu());
                $existingSub->setWio($subData->getWio());
                $existingSub->setSec($subData->getSec());
                $existingSub->setRef($subData->getRef());
                $existingSub->setNotes($subData->getNotes());

                $this->em->persist($existingSub);
                $this->em->flush();
                try {
                    $zsr->editSubscription($existingSub->getZsId(), $existingSub->buildSubscriptionData());
                } catch (\Exception $e) {
                    // If it didn't need updating (no changes) an exception is thrown.
                    // Catch it here to continue executing
                }
            } catch (\Exception $e) {
                // There was no record, so let's create a new one
                $newSub = new \models\ZohoSubscription();
                $newSub->setCompanyId($company->getCompanyId());
                $newSub->setUpdatedAt(Carbon::now());
                $newSub->setPlu($subData->getPlu());
                $newSub->setWio($subData->getWio());
                $newSub->setSec($subData->getSec());
                $newSub->setRef($subData->getRef());
                $newSub->setNotes($subData->getNotes());
                $newSub->setPlanCode($subData->getPlanCode());
                $newSub->setUserRate($subData->getUserRate());
                $newSub->setExpiry($newSubExpiry);

                // Retrieve the customer info or create a new one
                $customerId = $company->getZsCustomerId();
                if (!$customerId) {
                    $customer = $zsr->createCustomer($this->buildZsCustomerData($company));
                    $customerId = $customer['customer_id'];
                }

                // Build and send the subscription
                $newSubData = $newSub->buildSubscriptionData();
                $newSubData['customer_id'] = $customerId;
                $newSubData['starts_at'] = $newSubExpiry->format('Y-m-d');
                $subscription = $zsr->addSubscriptionToCustomer($newSubData);

                // Save the new one to the DB
                $newSub->setZsId($subscription['subscription']['subscription_id']);
                $this->em->persist($newSub);
                $this->em->flush();
            }
        }
    }

    /**
     * @param $companyId
     * @param \DateTime $date
     * @return mixed
     */
    public function getSubscriptionFromDate($companyId, \DateTime $date)
    {
        $dateString = $date->format('Y-m-d');

        $dql = "SELECT zs
                FROM \models\ZohoSubscription zs 
                WHERE zs.company_id = {$companyId}
                AND zs.expiry = '{$dateString}'";

        $query = $this->em->createQuery($dql);
        $query->setMaxResults(1);
        return $query->getSingleResult();
    }

    /**
     * @param $companyId
     */
    public function cancelCompanySubscriptions($companyId)
    {
        return;
        $zsr = $this->getZohoSubscriptionsRepository();

        // Retrieve all company Subscriptions
        $cr = $this->getCompanyRepository();
        $companySubscriptions = $cr->getSubscriptions($companyId);

        // Cancel in ZS
        foreach ($companySubscriptions as $subscription) {
            /* @var \models\ZohoSubscription $subscription */
            $zsr->cancelSubscription($subscription->getZsId());
            // Then remove local record
            $this->em->remove($subscription);
        }

        $this->em->flush();
    }

    /**
     * @param $companyId
     * @return array
     */
    public function getSubscriptions($companyId)
    {
        $dql = "SELECT zs
                FROM \models\ZohoSubscription zs 
                WHERE zs.company_id = {$companyId}";

        $query = $this->em->createQuery($dql);
        return $query->getResult();
    }

    //TODO JOIN this query on company status

    public function getTrialActiveUsers()
    {
        $dql = "SELECT a
                FROM \models\Accounts a 
                AND a.secretary = 0
                AND a.expires > :now";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':now', Carbon::now()->timestamp);
        return $query->getResult();
    }

    public function getTotalActiveUsers()
    {
        $sql = "SELECT COUNT(*) AS numUsers 
                FROM accounts a
                LEFT JOIN companies c ON a.company = c.companyId
                WHERE a.secretary = 0 
                AND c.companyStatus = 'Active'
                AND c.companyId != 3
                AND a.expires > " . Carbon::now()->timestamp;

        $query = $this->db->query($sql);

        return $query->result()[0]->numUsers;
    }

    public function getTotalActiveSecretaryUsers()
    {
        $sql = "SELECT COUNT(*) AS numUsers 
                FROM accounts a
                LEFT JOIN companies c ON a.company = c.companyId
                WHERE WHERE a.secretary = 1 
                AND c.companyStatus = 'Active'
                AND c.companyId != 3
                AND a.expires > " . Carbon::now()->timestamp;

        $query = $this->db->query($sql);

        return $query->result()[0]->numUsers;
    }

    public function getNumCompanyExpiredUsers($companyId)
    {

        $dql = "SELECT COUNT(a)
                FROM \models\Accounts a
                WHERE a.company = :companyId
                AND a.secretary = 0
                AND a.expires < :now";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $companyId);
        $query->setParameter(':now', Carbon::now()->timestamp);
        return $query->getSingleScalarResult();
    }

    public function getNextUserExpiry($companyId)
    {
        $dql = "SELECT MIN(a.expires)
                FROM \models\Accounts a 
                WHERE a.company = :companyId
                AND a.secretary = 0
                AND a.expires > :now";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $companyId);
        $query->setParameter(':now', Carbon::now()->timestamp);
        return $query->getSingleScalarResult();
    }

    public function getTotalValue($companyId)
    {
        // Get the counts
        $activeUsers = $this->getNumCompanyActiveUsers($companyId);
        $secUsers = $this->getNumCompanyActiveSecretaryUsers($companyId);
        $wioUsers = $this->getNumCompanyActiveWioUsers($companyId);

        // Calculate values
        $userRate = getUserPrice($activeUsers);
        $userValue = $activeUsers * $userRate;
        $secValue = $secUsers * 300;
        $wioValue = $wioUsers * 300;

        return $userValue + $secValue + $wioValue;
    }

    public function getNumCompanyActiveUsers($companyId)
    {

        $dql = "SELECT COUNT(a)
                FROM \models\Accounts a
                WHERE a.company = :companyId
                AND a.secretary = 0
                AND a.expires > :now";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $companyId);
        $query->setParameter(':now', Carbon::now()->timestamp);
        return $query->getSingleScalarResult();
    }

    public function getNumCompanyActiveSecretaryUsers($companyId)
    {

        $dql = "SELECT COUNT(a)
                FROM \models\Accounts a 
                WHERE a.company = :companyId
                AND a.secretary = 1
                AND a.expires > :now";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $companyId);
        $query->setParameter(':now', Carbon::now()->timestamp);
        return $query->getSingleScalarResult();
    }

    public function getNumCompanyActiveWioUsers($companyId)
    {

        $dql = "SELECT COUNT(a)
                FROM \models\Accounts a 
                WHERE a.company = :companyId
                AND a.wio = 1
                AND a.expires > :now";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $companyId);
        $query->setParameter(':now', Carbon::now()->timestamp);
        return $query->getSingleScalarResult();
    }

    public function getNumActiveTrialCompanies()
    {
        $sql = "SELECT COUNT(*) AS numCompanies FROM companies c 
                LEFT JOIN accounts a ON c.administrator = a.accountId
                WHERE c.companyStatus = 'Trial'
                AND a.expires > " . Carbon::now()->timestamp;

        $query = $this->db->query($sql);

        return $query->result()[0]->numCompanies;
    }

    public function getNumExpiredTrialCompanies()
    {
        $sql = "SELECT COUNT(*) AS numCompanies FROM companies c 
                LEFT JOIN accounts a ON c.administrator = a.accountId
                WHERE c.companyStatus = 'Trial'
                AND a.expires < " . Carbon::now()->timestamp;

        $query = $this->db->query($sql);

        return $query->result()[0]->numCompanies;
    }

    /**
     * @param Companies $company
     * @return mixed
     */
    public function getProspectSources(Companies $company, $array = false)
    {
        $rsm = new \Doctrine\ORM\Query\ResultSetMapping();
        $rsm->addEntityResult('\models\LeadSource', 'ps');
        $rsm->addFieldResult('ps', 'id', 'id');
        $rsm->addFieldResult('ps', 'name', 'name');
        $rsm->addFieldResult('ps', 'company_id', 'company_id');

        $dql = "SELECT ps.*
                FROM prospect_sources ps
                LEFT JOIN prospect_source_deleted psd ON ps.id = psd.prospect_source_id AND psd.company_id = :psdCompany
                LEFT JOIN prospect_source_order pso ON ps.id = pso.prospect_source_id AND pso.company_id = :psoCompany                
                WHERE (ps.company_id IS NULL
                OR ps.company_id = :companyId)
                AND psd.id IS NULL
                ORDER BY COALESCE(pso.ord, 99999), ps.ord";

        $query = $this->em->createNativeQuery($dql, $rsm);
        $query->setParameter(':psdCompany', $company->getCompanyId());
        $query->setParameter(':psoCompany', $company->getCompanyId());
        $query->setParameter(':companyId', $company->getCompanyId());

        $prospectSources = $query->getResult();

        if ($array) {
            $out = [];
            foreach ($prospectSources as $prospectSource) {
                /* @var \models\ProspectSource $prospectSource */
                $out[$prospectSource->getId()] = $prospectSource->getName();
            }
            return $out;
        }

        return $prospectSources;
    }

    /**
     * @param Companies $company
     * @return mixed
     */
    public function getProspectRatings(Companies $company, $array = false)
    {


        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('\models\ProspectRating', 'pr');
        $rsm->addFieldResult('pr', 'id', 'id');
        $rsm->addFieldResult('pr', 'rating_name', 'rating_name');
        $rsm->addFieldResult('pr', 'company_id', 'company_id');

        $sql = "SELECT pr.*
                FROM prospect_ratings pr
                LEFT JOIN prospect_rating_deleted prd ON pr.id = prd.prospect_rating_id  AND prd.company_id = :prCompany
                LEFT JOIN prospect_rating_order pro ON pr.id = pro.prospect_rating_id AND pro.company_id = :prCompany
                WHERE (pr.company_id IS NULL
                 OR pr.company_id = :companyId)
                 AND prd.id IS NULL
                 ORDER BY COALESCE(pro.ord, 99999), pr.ord
               ";

        $query = $this->em->createNativeQuery($sql, $rsm);
        $query->setParameter(':prCompany', $company->getCompanyId());
        $query->setParameter(':companyId', $company->getCompanyId());


        $prospectRatings = $query->getResult();

        if ($array) {
            $out = [];
            foreach ($prospectRatings as $prospectRating) {
                //print_r($prospectRating->getId());
                /* @var \models\ProspectSource $prospectSource */
                $out[$prospectRating->getId()] = $prospectRating->getRatingName();
            }
            //die;
            return $out;
        }


        return $prospectRatings;
    }

    /**
     * @param Companies $company
     * @return mixed
     */
    public function getProspectTypes(Companies $company, $array = false)
    {


        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('\models\ProspectType', 'pt');
        $rsm->addFieldResult('pt', 'id', 'id');
        $rsm->addFieldResult('pt', 'type_name', 'type_name');
        $rsm->addFieldResult('pt', 'company_id', 'company_id');

        $sql = "SELECT pt.*
                FROM prospect_types pt
                LEFT JOIN prospect_type_deleted ptd ON pt.id = ptd.prospect_type_id  AND ptd.company_id = :ptCompany
                LEFT JOIN prospect_type_order pto ON pt.id = pto.prospect_type_id AND pto.company_id = :ptCompany
                WHERE (pt.company_id IS NULL
                 OR pt.company_id = :companyId)
                 AND ptd.id IS NULL
                 ORDER BY COALESCE(pto.ord, 99999), pt.ord
               ";

        $query = $this->em->createNativeQuery($sql, $rsm);
        $query->setParameter(':ptCompany', $company->getCompanyId());
        $query->setParameter(':companyId', $company->getCompanyId());


        $prospectTypes = $query->getResult();

        if ($array) {
            $out = [];
            foreach ($prospectTypes as $prospectType) {
                //print_r($prospectRating->getId());
                /* @var \models\ProspectSource $prospectSource */
                $out[$prospectType->getId()] = $prospectType->getTypeName();
            }
            //die;
            return $out;
        }


        return $prospectTypes;
    }

    /**
     * @param Companies $company
     * @return mixed
     */
    public function getProspectStatuses(Companies $company, $array = false)
    {


        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('\models\ProspectStatus', 'ps');
        $rsm->addFieldResult('ps', 'id', 'id');
        $rsm->addFieldResult('ps', 'status_name', 'status_name');
        $rsm->addFieldResult('ps', 'company_id', 'company_id');

        $sql = "SELECT ps.*
                FROM prospect_statuses ps
                LEFT JOIN prospect_status_deleted psd ON ps.id = psd.prospect_status_id  AND psd.company_id = :psCompany
                LEFT JOIN prospect_status_order pso ON ps.id = pso.prospect_status_id AND pso.company_id = :psCompany
                WHERE (ps.company_id IS NULL
                 OR ps.company_id = :companyId)
                 AND psd.id IS NULL
                 ORDER BY COALESCE(pso.ord, 99999), ps.ord
               ";

        $query = $this->em->createNativeQuery($sql, $rsm);
        $query->setParameter(':psCompany', $company->getCompanyId());
        $query->setParameter(':companyId', $company->getCompanyId());


        $prospectStatuses = $query->getResult();

        if ($array) {
            $out = [];
            foreach ($prospectStatuses as $prospectStatus) {
                //print_r($prospectRating->getId());
                /* @var \models\ProspectSource $prospectSource */
                $out[$prospectStatus->getId()] = $prospectStatus->getStatusName();
            }
            //die;
            return $out;
        }


        return $prospectStatuses;
    }

    public function getAdminBusinessTypes()
    {

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('\models\BusinessType', 'bt');
        $rsm->addFieldResult('bt', 'id', 'id');
        $rsm->addFieldResult('bt', 'type_name', 'type_name');
        $rsm->addFieldResult('bt', 'company_id', 'company_id');

        $sql = "SELECT bt.*
                FROM business_types bt
                LEFT JOIN business_type_deleted btd ON bt.id = btd.business_type_id AND btd.company_id IS NULL
                WHERE bt.company_id IS NULL AND bt.deleted =0
                ORDER BY bt.ord";

        $query = $this->em->createNativeQuery($sql, $rsm);

        $businessTypes = $query->getResult();

        return $businessTypes;
    }

    /**
     * @param Companies $company
     * @return mixed
     */
    public function getCompanyBusinessTypes(Companies $company, $array = false)
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('\models\BusinessType', 'bt');
        $rsm->addFieldResult('bt', 'id', 'id');
        $rsm->addFieldResult('bt', 'type_name', 'type_name');
        $rsm->addFieldResult('bt', 'company_id', 'company_id');

        $sql = "SELECT bt.*
        FROM business_types bt
                LEFT JOIN business_type_deleted btd ON bt.id = btd.business_type_id  AND btd.company_id = :btCompany
                LEFT JOIN business_type_order bto ON bt.id = bto.business_type_id AND bto.company_id = :btCompany
                WHERE (bt.company_id IS NULL
                OR bt.company_id = :companyId)
                AND btd.id IS NULL 
                AND bt.deleted = 0
                ORDER BY COALESCE(bto.ord, 99999), bt.ord
               ";

        $query = $this->em->createNativeQuery($sql, $rsm);
        $query->setParameter(':btCompany', $company->getCompanyId());
        $query->setParameter(':companyId', $company->getCompanyId());

        // Emable cache with id - company_business_type_$companyId
        // Cache it
        $query->enableResultCache(CACHE_DEFAULT_LIFETIME, CACHE_COMPANY_BUSINESS_TYPE . $company->getCompanyId());
        
        $businessTypes = $query->getResult();

        if ($array) {
            $out = [];
            foreach ($businessTypes as $businessType) {
                //print_r($prospectRating->getId());
                /* @var \models\ProspectSource $prospectSource */
                $out[$businessType->getId()] = $businessType->getTypeName();
            }
            //die;
            return $out;
        }


        return $businessTypes;
    }

    /**
     * @description Clear previously set prospect source order
     * @param Companies $company
     * @return void
     */
    function clearProspectAssignedBusinessTypes(Companies $company, $prospect_id)
    {
        $dql = "DELETE \models\BusinessTypeAssignment bta
                WHERE bta.company_id = :companyId
                AND bta.prospect_id = :prospectId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());
        $query->setParameter(':prospectId', $prospect_id);

        $query->execute();
    }

    /**
     * @description Clear previously set prospect source order
     * @param Companies $company
     * @return void
     */
    function clearLeadAssignedBusinessTypes(Companies $company, $lead_id)
    {
        $dql = "DELETE \models\BusinessTypeAssignment bta
                WHERE bta.company_id = :companyId
                AND bta.lead_id = :leadId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());
        $query->setParameter(':leadId', $lead_id);

        $query->execute();
    }

    /**
     * @description Clear previously set prospect source order
     * @param Companies $company
     * @return void
     */
    function clearClientAssignedBusinessTypes(Companies $company, $client_id)
    {
        $dql = "DELETE \models\BusinessTypeAssignment bta
                WHERE bta.company_id = :companyId
                AND bta.client_id = :clientId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());
        $query->setParameter(':clientId', $client_id);

        $query->execute();
    }

    /**
     * @description Clear previously set prospect source order
     * @param Companies $company
     * @return void
     */
    function checkclearClientAssignedBusinessTypes(Companies $company, $client_id, $newBusinessTypes)
    {

        $old_business_types = $this->getCompanyBusinessTypeAssignments($company, 'client', $client_id, true);

        $deleteResults = array_diff($old_business_types, $newBusinessTypes);

        $insertResults = array_diff($newBusinessTypes, $old_business_types);

        if ($deleteResults) {
            foreach ($deleteResults as $business_type_id) {
                // get proposals counts
                $pCount = $this->getProposalRepository()->getClientBusinessTypeProposalCount($client_id, $business_type_id);

                if ($pCount < 1) {
                    // delete assignments
                    $this->deleteClientBTA($client_id, $business_type_id);

                }

            }

        }

        if ($insertResults) {
            $client = $this->em->findClient($client_id);
            foreach ($insertResults as $business_type) {

                $this->getProposalRepository()->checkClientAssignmentInAccount($client->getClientAccount()->getId(), $business_type, $company->getCompanyId());
                $assignment = new \models\BusinessTypeAssignment();
                $assignment->setBusinessTypeId($business_type);
                $assignment->setCompanyId($company->getCompanyId());
                $assignment->setClientId($client_id);
                $this->em->persist($assignment);
            }

            $this->em->flush();
        }

    }

    /**
     * @param Companies $company
     * @return mixed
     */
    public function getCompanyBusinessTypeAssignments(Companies $company, $entity, $entityId, $array = false)
    {
        $dql = "SELECT bta
                FROM \models\BusinessTypeAssignment bta
                WHERE bta.company_id = :companyId";

        // Add branch to query if we have one
        if ($entity == 'prospect') {
            $dql .= " AND bta.prospect_id = :prospectId";
        } else if ($entity == 'lead') {
            $dql .= " AND bta.lead_id = :leadId";
        } else if ($entity == 'client') {
            $dql .= " AND bta.client_id = :clientId";
        } else if ($entity == 'account') {
            $dql .= " AND bta.account_id = :accountId";
        }

        $query = $this->em->createQuery($dql);
        $query->setParameter('companyId', $company->getCompanyId());

        if ($entity == 'prospect') {
            $query->setParameter('prospectId', $entityId);
        } else if ($entity == 'lead') {
            $query->setParameter('leadId', $entityId);
        } else if ($entity == 'client') {
            $query->setParameter('clientId', $entityId);
        } else if ($entity == 'account') {
            $query->setParameter('accountId', $entityId);
        }

        $assignments = $query->getResult();

        if ($array) {
            $out = [];
            foreach ($assignments as $assignment) {
                $out[] = $assignment->getBusinessTypeId();
            }
            return $out;
        }

        return $assignments;
    }

    function deleteClientBTA($client_id, $business_type_id)
    {
        $dql = "DELETE \models\BusinessTypeAssignment bta
                    WHERE bta.business_type_id = :typeId
                    AND bta.client_id = :clientId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':typeId', $business_type_id);
        $query->setParameter(':clientId', $client_id);

        $query->execute();
    }

    /**
     * @description Clear previously set prospect source order
     * @param Companies $company
     * @return void
     */
    function checkclearAccountAssignedBusinessTypes(Companies $company, $account_id, $newBusinessTypes)
    {

        $old_business_types = $this->getCompanyBusinessTypeAssignments($company, 'account', $account_id, true);

        $deleteResults = array_diff($old_business_types, $newBusinessTypes);

        $insertResults = array_diff($newBusinessTypes, $old_business_types);

        $notDeleteResults = $this->getProposalRepository()->getAccountBusinessTypeProposalArray($account_id);
        
        if ($deleteResults) {
            foreach ($deleteResults as $business_type_id) {

                // get proposals counts
                //$pCount = $this->getProposalRepository()->getAccountBusinessTypeProposalCount($account_id, $business_type_id);
                
                if (!in_array($business_type_id,$notDeleteResults)) {
                    
                    // delete assignments
                    $this->deleteAccountBTA($account_id, $business_type_id);

                }

            }

        }
   

        if ($insertResults) {
            foreach ($insertResults as $business_type) {
                $assignment = new \models\BusinessTypeAssignment();
                $assignment->setBusinessTypeId($business_type);
                $assignment->setCompanyId($company->getCompanyId());
                $assignment->setAccountId($account_id);
                $this->em->persist($assignment);
            }

            $this->em->flush();
        }

    }

    function deleteAccountBTA($account_id, $business_type_id)
    {
        $dql = "DELETE \models\BusinessTypeAssignment bta
                    WHERE bta.business_type_id = :typeId
                    AND bta.account_id = :accountId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':typeId', $business_type_id);
        $query->setParameter(':accountId', $account_id);

        $query->execute();
    }

    /**
     * @description Clear previously set prospect source order
     * @param Companies $company
     * @return void
     */
    function clearAccountAssignedBusinessTypes(Companies $company, $account_id)
    {
        $dql = "DELETE \models\BusinessTypeAssignment bta
                WHERE bta.company_id = :companyId
                AND bta.account_id = :accountId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());
        $query->setParameter(':accountId', $account_id);

        $query->execute();
    }

    /**
     * @description Clear previously set prospect source order
     * @param Companies $company
     * @return void
     */
    function clearProspectSourceOrder(Companies $company)
    {
        $dql = "DELETE \models\ProspectSourceOrder pso
                WHERE pso.company_id = :companyId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());

        $query->execute();
    }

    /**
     * @description Clear previously set prospect rating order
     * @param Companies $company
     * @return void
     */
    function clearProspectRatingOrder(Companies $company)
    {
        $dql = "DELETE \models\ProspectRatingOrder pro
                WHERE pro.company_id = :companyId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());

        $query->execute();
    }

    /**
     * @description Clear previously set prospect Type order
     * @param Companies $company
     * @return void
     */
    function clearProspectTypeOrder(Companies $company)
    {
        $dql = "DELETE \models\ProspectTypeOrder pto
                WHERE pto.company_id = :companyId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());

        $query->execute();
    }

    function clearAdminBusinessTypeOrder()
    {
        $dql = "DELETE \models\BusinessTypeOrder bto
                WHERE bto.company_id IS NULL";

        $query = $this->em->createQuery($dql);

        $query->execute();
    }

    /**
     * @description Clear previously set prospect Status order
     * @param Companies $company
     * @return void
     */
    function clearCompanyBusinessTypeOrder(Companies $company)
    {
        $dql = "DELETE \models\BusinessTypeOrder bto
                WHERE bto.company_id = :companyId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());

        $query->execute();
    }

    /**
     * @description Clear previously set prospect Status order
     * @param Companies $company
     * @return void
     */
    function clearProspectStatusOrder(Companies $company)
    {
        $dql = "DELETE \models\ProspectStatusOrder pto
                WHERE pto.company_id = :companyId";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());

        $query->execute();
    }

    public function getQbIncomeAccounts($companyId)
    {
        $dql = "SELECT qa
                FROM \models\QuickbooksAccount qa 
                WHERE qa.c_id = :companyId
                AND qa.acc_type = 'Income'";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $companyId);
        return $query->getResult();
    }

    /**
     * @param Accounts $account
     * @return int
     */
    public function getMappedProposalsCount(Accounts $account)
    {
        $numProposals = $account->getProposalsData('', '', false, true, true);
        return count($numProposals);
    }

    public function getProposalsByStatus(Companies $company, array $statusIds,$pModifyFrom='',$pModifyTo='')
    {

        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('\models\Proposals', 'p');
        $rsm->addFieldResult('p', 'proposalId', 'proposalId');

        $sql = "SELECT p.proposalId
                FROM proposals p
                WHERE p.company_id = :companyId
                AND p.proposalStatus IN (:statusIds)";

        if($pModifyFrom !='' && $pModifyTo != ''){
            $sql .= " AND (p.created >= :pModifyFrom)
                        AND (p.created <= :pModifyTo)";
        }

        $query = $this->em->createNativeQuery($sql, $rsm);
        $query->setParameter(':companyId', $company->getCompanyId());
        $query->setParameter(':statusIds', $statusIds);

        if($pModifyFrom !='' && $pModifyTo != ''){
            $query->setParameter(':pModifyFrom', $pModifyFrom);
            $query->setParameter(':pModifyTo', $pModifyTo);
        }

        $proposalIds = $query->getResult();

        $out = [];

        foreach ($proposalIds as $proposalRsm) {
            $proposalId = $proposalRsm->getProposalId();
            $this->em->detach($proposalRsm);
            $proposal = $this->em->findProposal($proposalId);
            if ($proposal) {
                $out[] = $proposal;
            }
        }

        return $out;
    }

    public function getPriceModifications(Companies $company)
    {
        $dql = "SELECT pm
                FROM \models\PriceModification pm 
                WHERE pm.company_id = :companyId
                ORDER BY pm.run_date DESC";

        $query = $this->em->createQuery($dql);
        $query->setParameter(':companyId', $company->getCompanyId());
        return $query->getResult();
    }

    public function getAdminResendList(Companies $company)
    {

        $sql = "SELECT pgr.resend_name,pgr.id FROM admin_group_resends pgr 
                WHERE pgr.company_id = " . (int)$company->getCompanyId() . " AND pgr.is_deleted =0  AND pgr.parent_resend_id IS NULL order by id desc";


        return $this->getAllResults($sql);

    }

    function getUnopenedAdminStatusCount($resend_id,$clicked)
    {

        
        $sql = "SELECT agre.id
        FROM admin_group_resend_email agre"; 

        if($clicked){
            $sql .= " WHERE agre.opened_at IS NOT NULL AND agre.clicked_at IS NULL
            AND agre.resend_id = ".$resend_id;
        }else{
            $sql .= " WHERE agre.opened_at IS NULL
            AND agre.resend_id = ".$resend_id;
        }
        $sql .= " AND agre.is_failed = 0";

        $unopened_emails = $this->getAllResults($sql);

        $sql2 = "SELECT pgre.id
        FROM admin_group_resend_email pgre 
        
        WHERE pgre.resend_id = " . $resend_id;

        $sql = "SELECT agre.id,a.accountId
        FROM admin_group_resend_email agre LEFT JOIN
            accounts a ON agre.user_id = a.accountId"; 

        if($clicked){
            $sql .= " WHERE agre.opened_at IS NOT NULL AND agre.clicked_at IS NULL
            AND agre.resend_id = ".$resend_id;
        }else{
            $sql .= " WHERE agre.opened_at IS NULL
            AND agre.resend_id = ".$resend_id;
        }
        $sql .= " AND agre.is_failed = 0 AND a.accountId IS NULL";

        $removed_account_emails = $this->getAllResults($sql);

        $emails_count = $this->getAllResults($sql2);
        $data = array();
        $data['total_unopened'] = count($unopened_emails);
        $data['removed_account_emails'] = count($removed_account_emails);
        $data['total_emails'] = count($emails_count);

        return $data;
    }

    /**
     * @param Companies $company
     * @return array
     */
    public function getGroupResendData(Companies $company, $count = false, $account = NULL)
    {
        $CI =& get_instance();
        $CI->load->library('session');
        $sql = "SELECT pgr.*,a.firstname,a.lastname,pgrp.resend_name as parent_name,
                    COUNT(pgre.delivered_at) AS delivered,
                    COUNT(pgre.id) AS total_resend,
                    COUNT(pgre.bounced_at) AS bounced,
                    COUNT(pgre.opened_at) AS opened,
                    COUNT(pgre.sent_at) AS sent_count,
                    (SELECT COUNT(fj.campaign_id) FROM failed_jobs AS fj WHERE fj.campaign_id = pgr.id AND job_type = 'admin_campaign') AS failed,
                    (COUNT(pgre.opened_at) / COUNT(pgre.id)) AS pct,
                    COUNT(pgre.clicked_at) AS clicked,
                    (COUNT(pgre.clicked_at) / COUNT(pgre.id)) AS cct
                    FROM admin_group_resends pgr 
                    LEFT JOIN admin_group_resend_email AS pgre ON pgr.id = pgre.resend_id
                    LEFT JOIN accounts AS a ON pgr.account_id = a.accountId 
                    LEFT JOIN admin_group_resends AS pgrp ON pgr.parent_resend_id = pgrp.id";

        // Filter on categories

        // Sorting
        $order = $this->ci->input->get('order');
        $sortCol = $order[0]['column'];
        $sortDir = $order[0]['dir'];

        $sortCols = [
            1 => 'pgr.id',
            2 => 'pgr.created',
            3 => 'pgr.resend_name',
            4 => 'pgr.account_name',
            5 => 'total_resend',
            6 => 'delivered',
            7 => 'bounced',
            8 => 'opened',
            9 => 'clicked',
            10 => 'pct',
            11 => 'cct',
        ];

        if ($account->isAdministrator() && $account->hasFullAccess()) {
            //branch admin, can access only his branch
            $sql .= ' WHERE  pgr.company_id=' . $company->getCompanyId();
        } else if ($account->isBranchAdmin()) {
            //branch admin, can access only his branch
            $sql .= ' WHERE a.branch = ' . $account->getBranch() . '
                AND pgr.company_id=' . $company->getCompanyId();
        } else {

            $sql .= ' WHERE pgr.account_id=' . $account->getAccountId();
        }
        $sql .= ' AND pgr.is_deleted=0 AND pgre.is_failed=0 ';

        // // Search
        $searchVal = $this->ci->input->get('search')['value'];
        if ($searchVal) {
            $sql .= " AND (" .
                "(pgr.account_name  LIKE '%" . $searchVal . "%')" .
                "OR (pgr.resend_name  LIKE '%" . $searchVal . "%')" .
                ") GROUP BY pgre.resend_id";
        } else {
            $sql .= ' GROUP BY pgre.resend_id';
        }

        $sql .= " ORDER BY " . $sortCols[$sortCol] . ' ' . $sortDir;

        // Handle Limit
        if ($this->ci->input->get('length') && !$count) {
            $sql .= ' LIMIT ' . $this->ci->input->get('length');
            $sql .= ' OFFSET ' . $this->ci->input->get('start');
        }
        // echo $sql;die;

        // Organize the data
        $rows = $this->getAllResults($sql);

        // If counting, just return the count
        if ($count) {
            return count($rows);
        }

        $tableData = [];

        foreach ($rows as $data) {

            // Not sure what's going on here but I'll keep it for now
            $names = '';
            $names2 = explode(' ', trim($data->firstname . ' ' . $data->lastname));
            foreach ($names2 as $name) {
                $names .= substr($name, 0, 1) . ' . ';
            }

            $account_name = '<span class="tiptip" title="' . $data->firstname . ' ' . $data->lastname . '">' . $names . '</span>';
            $date = date_create($data->created);
            $open = ($data->total_resend - ($data->delivered + $data->bounced));

            // $unsend = $this->getUnopenedProposals($data->id);
            // $unsend = count($unsend);
            $unsend = '10';

            $action = '<div class="dropdownButton">
        <a class="dropdownToggle" href="#">Go</a>
        <div class="dropdownMenuContainer single">
            <ul class="dropdownMenu">
            <li>
                <a data-resend-name="' . $data->resend_name . '" data-resend-id="' . $data->id . '" href="javascript:void(0);" class="edit_resend_name "><i class="fa fa-fw fa-pencil"></i> Edit Campaign Name</a>
            </li> 
            
            <li>
                <a data-resend-id="' . $data->id . '" href="javascript:void(0);" class="show_email_content "><i class="fa fa-fw fa-pencil-square-o"></i> Summary</a>
            </li>
            <li>
                <a href="../admin/resend/' . $data->id . '" class="show_email_content22 " ><i class="fa fa-fw fa-user"></i> View Company</a>
            </li>
            <li>
                <a href="javascript:void(0);" data-val="' . $data->id . '" class="delete_campaign " ><i class="fa fa-fw fa-trash"></i> Delete Campaign</a>
            </li>
            <li>
                <a href="javascript:void(0);" data-val="' . $data->id . '" class="resend_upopened " data-unclicked="0"><i class="fa fa-fw fa-share-square"></i> Resend Unopened Eamils</a>
            </li>
            <li>
                <a href="javascript:void(0);" data-val="' . $data->id . '" class="resend_upopened " data-unclicked="1"><i class="fa fa-fw fa-share-square"></i> Resend Unclicked Eamils</a>
            </li>
            </ul>
        </div>
    </div>';

            $open_p = $data->opened ? round(($data->pct) * 100) : '0';
            $click_p = $data->clicked ? round(($data->cct) * 100) : '0';
            $failed_info = '';
            if($data->failed > 0){
                $failed_info = '<a href="/admin/resend/' . $data->id . '/failed" class="right" style="position: absolute;right: 0;"><i class="fa fa-fw fa-info-circle tiptip" style="color: #000;font-size: 14px;" title="'.$data->failed.' User email Failed to send" ></i></a>';
            }
            $total_resend = '<div style="position: relative;"><a href="/admin/resend/' . $data->id . '">' . $data->total_resend . '</a>'.$failed_info.'</div>';
           
            $create_date = date_format($date, "m/d/y g:i A");
            $create_date = date('m/d/Y g:i A', strtotime($create_date) + TIMEZONE_OFFSET);
 
            if($data->sent_count < $data->total_resend){
                $total_sending = $data->total_resend;
                if($data->failed>0){
                    $total_sending = $data->failed + $total_sending;
                }
                $total_resend = '<div style="position: relative;"><a href="/admin/resend/' . $data->id . '">' .$data->sent_count.' / '. $total_sending . '</a>'.$failed_info.'</div>';
                $create_date .= ' <i class="fa fa-fw fa-info-circle tiptip" style="color: #000;font-size: 14px;" title="Campaign is in progress" ></i>';
            }
            $badge = "R";
            $resend_type_text = "Resend";
            if($data->resend_type == 1){
                $badge = "RUO";
                $resend_type_text = "Resend Unopened";
            }
            if($data->resend_type == 2){
                $badge = "RUC";
                $resend_type_text = "Resend Unclicked";
            }
            if($data->resend_type == 3){
                $badge = "RB";
                $resend_type_text = "Resend Bounced";
            } 

            $string = $data->resend_name;
            $parts = explode("|", $string);            
            $datePart = isset($parts[1]) ? $parts[0]."| ".date('m/d/y g:ia', strtotime(trim($parts[1])) + TIMEZONE_OFFSET) :$string;
            $campaign_name = ($data->parent_resend_id >0)?'[<span class="tiptip" title ="'.$resend_type_text.' of '.$data->parent_name.' ">'.$badge.'</span>] '.$datePart:$datePart;
 
            $row = [
                0 => '<input type="checkbox" class="campaignCheck" data-campaign-id="' . $data->id . '" />',
                1 => $action,
                2 => $create_date,
                3 => $campaign_name,
                4 => $account_name,
                5 =>  $total_resend,
                6 => '<a href="/admin/resend/' . $data->id . '/delivered">' . $data->delivered . '</a>',
                7 => '<a href="/admin/resend/' . $data->id . '/bounced">' . $data->bounced . '</a>',
                8 => '<div style="display: flex;justify-content: space-between;"><a href="/admin/resend/' . $data->id . '/opened">' . $data->opened . '</a><a href="/admin/resend/' . $data->id . '/opened">' . $open_p . '%</a></div>',
                9 => '<div style="display: flex;justify-content: space-between;"><a href="/admin/resend/' . $data->id . '/clicked">' . $data->clicked . '</a><a href="/admin/resend/' . $data->id . '/clicked">' . $click_p . '%</a>',
                10 => $open_p,
                11 => $click_p
            ];

            $tableData[] = $row;
        }

        return $tableData;
    }

    public function groupSendUnopened($emailData, \models\Accounts $account, $logAction = 'admin_send', $logMessage = null, $cgsId = NULL,$unclicked = NULL)
    {
        $CI =& get_instance();
        $CI->load->library('jobs2', NULL, 'my_jobs');
        $count = 0;
        $alreadySentCount = 0;
        $unsentCount = 0;
        $duplicateEmailCount = 0;
        $bouncedUnsentCount = 0;
        $check_sent_email = true;
        $check_email_list = [];

        $ags = $this->em->find('\models\AdminGroupResend', $cgsId);
        $parentFilter = json_decode($ags->getFilters());
        $parentFilter[0]->pResendType = ($unclicked=='1') ? 'Unclicked' : 'Unopened';

        $cgs = new AdminGroupResend();
        $cgs->setAccountId($account->getAccountId());
        $cgs->setCompanyId($account->getCompany()->getCompanyId());
        $cgs->setAccountName($account->getFullName());
        $cgs->setSubject($emailData['subject']);
        $cgs->setEmailCc(0);
        $cgs->setCustomSender(($emailData['fromName']) ? 1 : 0);
        $cgs->setCustomSenderName($emailData['fromName']);
        $cgs->setCustomSenderEmail($emailData['fromEmail']);
        $cgs->setResendName($emailData['new_resend_name'] . ' - Resend | ' . date("m/d/y h:iA"));
        $cgs->setIpAddress($_SERVER['REMOTE_ADDR']);
        $cgs->setEmailContent($emailData['body']);
       
        $cgs->setFilters(json_encode($parentFilter,JSON_HEX_APOS));
        if($unclicked == 1){
            $cgs->setResendType(2);
        } else {
            $cgs->setResendType(1);
        }
        $cgs->setParentResendId($cgsId);
        $cgs->setCreated(Carbon::now());
        $this->em->persist($cgs);
        $this->em->flush();

        $sql = "SELECT agre.company_id,agre.id,agre.email_address,agre.bounced_at,agre.user_id,a.accountId
        FROM admin_group_resend_email agre LEFT JOIN
	accounts a ON agre.user_id = a.accountId";

        if($unclicked=='1'){
            $sql .= " WHERE agre.opened_at IS NOT NULL AND agre.clicked_at IS NULL
            AND agre.resend_id = ".$cgsId;
        }else{
            $sql .= " WHERE agre.opened_at IS NULL
            AND agre.resend_id = ".$cgsId;
        }
        $sql .= " AND agre.is_failed = 0 AND a.accountId IS NOT NULL";

        $Resend_campaigns = $this->getAllResults($sql);
        
        foreach ($Resend_campaigns as $Resend_campaign) {
            $thisEmailData = $emailData;
            //$sendIt = true;
            $bounced = false;
            $user_id = $Resend_campaign->user_id;
            $account = $this->em->findAccount($user_id);


            if ($account) {

                if (in_array(strtolower($account->getEmail()), $check_email_list)) {
                    $duplicateEmailCount++;
                    continue;
                }

                $emailFromName = ($emailData['fromName']) ?: $account->getFullName();
                $fromEmail = ($emailData['fromEmail']) ?: 'noreply@' . SITE_EMAIL_DOMAIN;

                $thisEmailData['fromName'] = $emailFromName;
                $thisEmailData['fromEmail'] = 'noreply@' . SITE_EMAIL_DOMAIN;
                $thisEmailData['replyTo'] = ($emailData['replyTo']) ?: $fromEmail;

                $to = $account->getEmail();
                //$to = 'sunilyadav.acs@gmail.com';

                $cgse = new AdminGroupResendEmail();
                $cgse->setResendId($cgs->getId());
                $cgse->setCompanyId($account->getCompany()->getCompanyId());
                $cgse->setEmailAddress($to);
                $cgse->setParentResendEmailId($Resend_campaign->id);
                $cgse->setUserId($user_id);
                $this->em->persist($cgse);
                $this->em->flush();
                $cgseId = $cgse->getId();
                $cgsId =$cgs->getId();

                $thisEmailData['to'] = $to;
                $thisEmailData['uniqueArg'] = 'admin_group_resend_id';
                $thisEmailData['uniqueArgVal'] = $cgse->getId();
                $thisEmailData['accountId'] = $user_id;
                $thisEmailData['campaignId'] = $cgsId;

                array_push($check_email_list, strtolower($account->getEmail()));
                $CI->my_jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'send_individual_admin_email',$thisEmailData,'test job');
                $count++;

            } else {
                if (!$bounced) {
                    $unsentCount++;
                }
            }
        }

        // if ($count) {
        //     //log group action
        //     $this->getLogRepository()->add([
        //         'action' => 'group_action_send',
        //         'details' => "Group Mail Sent to {$count} Prospects",
        //         'account' => $account->getAccountId(),
        //         'company' => $account->getCompany()->getCompanyId(),
        //     ]);
        // }

        $out = [
            'sent' => $count,
            'unsent' => $unsentCount,
            'already_sent' => $alreadySentCount,
            'duplicateEmailCount' => $duplicateEmailCount,
            'bouncedUnsentCount' => $bouncedUnsentCount,
        ];

        return $out;
    }

    public function getCompanyAdminResendList(Companies $company)
    {

        $sql = "SELECT lgr.resend_name,lgr.id FROM admin_group_resends lgr 
                WHERE lgr.company_id = " . (int)$company->getCompanyId() . " AND lgr.is_deleted =0 AND lgr.parent_resend_id IS NULL order by id desc";


        return $this->getAllResults($sql);

    }

    public function getAdminChildResend($resend_id)
    {

        $sql = "SELECT lgr.id,lgr.resend_name
        FROM admin_group_resends lgr 
        
        WHERE lgr.parent_resend_id = " . $resend_id;

        return $this->getAllResults($sql);

    }

    /**
     * @param AdminGroupResend $resend
     * @return array
     */
    public function getAdminResendStats(AdminGroupResend $resend)
    {
        $out = [
            'sent' => $this->getNumResendEmails($resend),
            'delivered' => $this->getNumDeliveredResendEmails($resend),
            'bounced' => $this->getNumBouncedResendEmails($resend),
            'opened' => $this->getNumOpenedResendEmails($resend),
            'unopened' => $this->getNumUnopenedResendEmails($resend),
            'clicked' => $this->getNumClickedResendEmails($resend),
            'failed_count' => $this->getNumFailedResendEmails($resend)

        ];

        return $out;
    }

    public function getNumResendEmails(AdminGroupResend $resend)
    {
        $sql = "SELECT COUNT(*) AS numSent
        FROM admin_group_resend_email lgre 
        WHERE lgre.is_failed=0 AND lgre.resend_id = " . $resend->getId();

        $data = $this->getSingleResult($sql);

        return $data->numSent;
    }

    public function getNumFailedResendEmails(AdminGroupResend $resend)
    {
        $resendId = $resend->getId();
        $sql = "SELECT COUNT(fj.id) AS numFailed
        FROM failed_jobs fj WHERE fj.campaign_id ={$resendId} AND job_type= 'admin_campaign' ";

        $data = $this->getSingleResult($sql);

        return $data->numFailed;
    }


    public function getNumDeliveredResendEmails(AdminGroupResend $resend)
    {
        $sql = "SELECT COUNT(*) AS numDelivered
        FROM admin_group_resend_email lgre 
        WHERE lgre.resend_id = " . $resend->getId() . "
        AND lgre.is_failed=0 AND delivered_at IS NOT NULL";

        $data = $this->getSingleResult($sql);

        return $data->numDelivered;
    }

    public function getNumBouncedResendEmails(AdminGroupResend $resend)
    {
        $sql = "SELECT COUNT(*) AS numBounced
        FROM admin_group_resend_email lgre 
        WHERE lgre.resend_id = " . $resend->getId() . "
        AND lgre.is_failed=0 AND bounced_at IS NOT NULL";

        $data = $this->getSingleResult($sql);

        return $data->numBounced;
    }

    public function getNumOpenedResendEmails(AdminGroupResend $resend)
    {
        $sql = "SELECT COUNT(*) AS numOpened
        FROM admin_group_resend_email lgre 
        WHERE lgre.resend_id = " . $resend->getId() . "
        AND lgre.is_failed=0 AND opened_at IS NOT NULL";

        $data = $this->getSingleResult($sql);

        return $data->numOpened;
    }

    public function getNumUnopenedResendEmails(AdminGroupResend $resend)
    {
        $sql = "SELECT COUNT(*) AS numUnopened
        FROM admin_group_resend_email lgre 
        WHERE lgre.resend_id = " . $resend->getId() . "
        AND lgre.is_failed=0 AND opened_at IS NULL";

        $data = $this->getSingleResult($sql);

        return $data->numUnopened;
    }

    public function getNumClickedResendEmails(AdminGroupResend $resend)
    {
        $sql = "SELECT COUNT(*) AS numClicked
        FROM admin_group_resend_email lgre 
        WHERE lgre.resend_id = " . $resend->getId() . "
        AND lgre.is_failed=0 AND clicked_at IS NOT NULL";

        $data = $this->getSingleResult($sql);

        return $data->numClicked;
    }

    public function getChildResend($resend_id)
    {

        $sql = "SELECT lgr.id,lgr.resend_name
        FROM admin_group_resends lgr 
        
        WHERE lgr.parent_resend_id = " . $resend_id . " order by id desc";

        return $this->getAllResults($sql);

    }

    public function group_send($data, $senderAccount)
    {
        //Build Query
        $query = 'select a.accountId, a.company, a.email, a.userClass, a.firstName, a.lastName';
        $query .= ' from accounts a';
        $query .= ' left join companies c on a.company = c.companyId';
        $query .= ' where (a.company in (' . implode(',', $data['companies']) . '))';
        $criterias = array();
        $filter = array();
        $secretary = 0; //we just set this to 1 if we find below and handle later
        $mainAdmin = 0; //ditto
        $userClasses = array();
        $CI =& get_instance();
        $CI->load->library('jobs2', NULL, 'my_jobs');

        foreach ($data['userClass'] as $classId) {
            switch ($classId) {
                case 0:  //main admin
                    $mainAdmin = 1;
                    break;
                case 1: //administrator level users
                    $userClasses[] = 3;
                    break;
                case 2: //full access
                    $userClasses[] = 2;
                    break;
                case 3: //Branch Manager
                    $userClasses[] = 1;
                    break;
                case 4: //User
                    $userClasses[] = 0;
                    break;
                case 5: //Secretary
                    $secretary = 1;
                    break;
            }
        }
//        echo "Main Admin: {$mainAdmin} | Secretary: {$secretary} | User Classes: " . count($userClasses) . "\n";
        if ($mainAdmin && !count($userClasses) && !$secretary) { //if we just want the main admin
            $query .= ' and (a.accountId = c.administrator)';
        } elseif (!$mainAdmin && count($userClasses) && !$secretary) { //if we just want some classes
            $query .= ' and ((a.userclass in (' . implode(',', $userClasses) . ')) and (a.secretary < 1) and (a.accountId <> c.administrator))';
        } elseif (!$mainAdmin && !count($userClasses) && $secretary) { //if we just want secretary
            $query .= ' and (a.secretary > 0)';
        } elseif ($mainAdmin && count($userClasses) && !$secretary) { //if we want admins and classes
            $query .= ' and ((a.userclass in (' . implode(',', $userClasses) . ')) and (a.secretary < 1) or (a.accountId = c.administrator))';
        } elseif ($mainAdmin && !count($userClasses) && $secretary) { //if we want admins and secretary
            $query .= ' and ((a.accountId = c.administrator) or (a.secretary > 0))';
        } else if ($mainAdmin && count($userClasses) && $secretary) {
            $query .= ' and ((a.userclass in (' . implode(',', $userClasses) . ')) or (a.accountId = c.administrator) or (a.secretary > 0))'; //Chris: This could have been removed completely, kept as an else branch OR no else at all... not adding this part of the query does the same thing, no logic
        } else { //if we want classes and secretary
            $query .= ' and ((a.userclass in (' . implode(',', $userClasses) . ')) and (a.accountId <> c.administrator) or (a.secretary > 0))';
        }
        //expired stuff
        if ($data['expired'] == 1) {
            $query .= ' and (a.expires > ' . time() . ')';
        } elseif ($data['expired'] == 2) {
            $query .= ' and (a.expires < ' . time() . ')';
        }

        $users = $this->db->query($query);
        $users = $users->result();


        $agsId = $data['resendId'];

        $agsName = $data['new_resend_name'];
        $count = 0;
        $alreadySentCount = 0;
        $unsentCount = 0;
        $check_sent_email = true;
        $check_email_list =[];
        $check_user_ids_list =[];
        $filter[] = [
            'user_class' => $data['userClass'],
            'expired' => $data['expired'],
            'statusFilter' => $data['statusFilter'],
            'expiryFilter' => $data['expiryFilter']];

        if ($agsId != -1) {

            $ags = $this->em->find('\models\AdminGroupResend', $agsId);

            if (!$ags) {
                $ags = new AdminGroupResend();
                $ags->setAccountId($senderAccount->getAccountId());
                $ags->setCompanyId($senderAccount->getCompany()->getCompanyId());
                $ags->setAccountName($senderAccount->getFullName());
                $ags->setSubject($data['subject']);
                $ags->setEmailCc(0);
                $ags->setCustomSender(($data['fromName']) ? 1 : 0);
                $ags->setCustomSenderName($data['fromName']);
                $ags->setCustomSenderEmail($data['fromEmail']);
                $ags->setFilters(json_encode($filter, JSON_HEX_APOS));
                $ags->setResendName($agsName);
                $check_sent_email = false;
            }else{
                $sql = "SELECT agre.user_id,agre.email_address FROM admin_group_resend_email agre WHERE agre.resend_id =".$ags->getId(); 
                $all_sent_emails =$this->getAllResults($sql);

                foreach($all_sent_emails as $all_sent_email){
                    array_push($check_email_list,strtolower($all_sent_email->email_address));
                    array_push($check_user_ids_list,$all_sent_email->user_id);
                }
            }

            $ags->setIpAddress($_SERVER['REMOTE_ADDR']);
            $ags->setEmailContent($data['message']);
            $ags->setCreated(Carbon::now());
            $this->em->persist($ags);
            $this->em->flush();
        } else {
            $check_sent_email = false;
        }

        foreach ($users as $user) {

            try {

                $userId = $user->accountId;
                
                // Load the account
                $account = $this->em->find('\models\Accounts', $userId);
                /* @var $account \models\Accounts */

                $CI =& get_instance();
                $CI->load->library('EmailTemplateParser');
                // Load the parser
                $etp = new EmailTemplateParser();
                $etp->setAccount($account);
                // Get the parsed content
                $subject = $data['subject'];
                $message = $data['message'];
                if ($check_sent_email) {

                    if(in_array($userId, $check_user_ids_list)){
                        $alreadySentCount++;
                        continue;
                    }
                }

                if(in_array(strtolower($account->getEmail()), $check_email_list)){
                    continue;
                }

                if ($agsId != -1) {
                    $agse = new AdminGroupResendEmail();
                    $agse->setResendId($ags->getId());
                    $agse->setCompanyId($account->getCompany()->getCompanyId());
                    $agse->setEmailAddress($account->getEmail());
                    $agse->setUserId($userId);
                    $this->em->persist($agse);
                    $this->em->flush();
                    $agseId = $agse->getId();
                    $agsId =$ags->getId();
                }else{
                    $agseId = NULL;
                    $agsId = NULL;
                }
                array_push($check_email_list,strtolower($account->getEmail()));
               
                $replyTo = ($data['fromEmail']) ?: 'noreply@' . SITE_EMAIL_DOMAIN;

                $emailData = [
                    'to' => $account->getEmail(),
                    //'to' => 'sunilyadav.acs@gmail.com',
                    //'to' => 'mr.a.long@gmail.com',
                    'fromName' => $data['fromName'],
                    'fromEmail' => $data['fromEmail'],
                    'replyTo' => $replyTo,
                    'subject' => $subject,
                    'body' => $message,
                    'accountId' => $userId,
                    'categories' => ['Global Admin Mail'],
                    'uniqueArg' => 'admin_group_resend_id',
                    'uniqueArgVal' => $agseId,
                    'campaignId' => $agsId,
                ];
               
                $CI->my_jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'send_individual_admin_email',$emailData,'test job');

            } catch (\Exception $e) {
                // If it didn't need updating (no changes) an exception is thrown.
                // Catch it here to continue executing
                continue;
            }
        }

        if($agsId && $agsId != -1){
            $job_array = [
                'email_data' => $emailData,
                'agsId' => $agsId,
                'account_id' =>$senderAccount->getAccountId(),
                'agsName' => $agsName
            ];
            
            $CI->my_jobs->create($_ENV['QUEUE_EMAIL'], 'jobs', 'send_job_admin_completed_mail',$job_array,'test job');
        }
    }

    /**
     * @param $companyId
     * @param $prospectEmail
     * @return bool
     */
    public function checkProspectDuplicateEmail($companyId, $prospectEmail)
    {
        $sql = "SELECT COUNT(*) AS numProspects
        FROM prospects p 
        WHERE p.company = " . $companyId . "
        AND p.email = '" .  $prospectEmail . "'";

        $data = $this->getSingleResult($sql);

        return boolval($data->numProspects);
    }

    /**
     * @param $companyId
     */
    public function flagProposalsForRebuild($companyId)
    {
        if ($companyId) {
            $query = "UPDATE proposals p
              LEFT JOIN clients c ON p.client = c.clientId
              SET rebuildFlag = 1
              WHERE p.company_id = {$companyId}";
            $this->db->query($query);
        }
    }

    /**
     * @param $accountId
     */
    public function flagAccountProposalsForRebuild($accountId)
    {
        if ($accountId) {
            $query = "UPDATE proposals p
              SET rebuildFlag = 1
              WHERE p.owner = {$accountId}";
            $this->db->query($query);
        }

    }


    /**
     * @description Clear previously set prospect source order
     * @param Companies $company
     * @return void
     */
    function checkAccountClientAssignedBusinessTypes(Companies $company, $old_account_id,$new_account_id)
    {

        $old_business_types = $this->getCompanyBusinessTypeAssignments($company, 'account', $old_account_id, true);

        $newBusinessTypes =$this->getClientBusinessTypesByAccount($new_account_id);

        $insertResults = array_diff($newBusinessTypes, $old_business_types);

        if ($insertResults) {
            foreach ($insertResults as $business_type) {

                $assignment = new \models\BusinessTypeAssignment();
                $assignment->setBusinessTypeId($business_type);
                $assignment->setCompanyId($company->getCompanyId());
                $assignment->setAccountId($old_account_id);
                $this->em->persist($assignment);
            }

            $this->em->flush();
        }

    }

    public function getClientBusinessTypesByAccount($account_id){
        $sql = "SELECT DISTINCT(bt.business_type_id) FROM  business_type_assignments bt
                LEFT JOIN clients c ON bt.client_id = c.clientId 
                WHERE c.client_account = " .$account_id;

        $query = $this->db->query($sql);

         $business_types = $query->result();
         $out = [];
         foreach ($business_types as $business_type) {
             $out[] = $business_type->business_type_id;
         }
         return $out;
    }

    function checkAccountAllClientAssignedBusinessTypes(Companies $company, $account_id)
    {

        $old_business_types = $this->getCompanyBusinessTypeAssignments($company, 'account', $account_id, true);

        $newBusinessTypes =$this->getClientBusinessTypesByAccount($account_id);

        $insertResults = array_diff($newBusinessTypes, $old_business_types);
       
        if ($insertResults) {
            foreach ($insertResults as $business_type) {

                $assignment = new \models\BusinessTypeAssignment();
                $assignment->setBusinessTypeId($business_type);
                $assignment->setCompanyId($company->getCompanyId());
                $assignment->setAccountId($account_id);
                $this->em->persist($assignment);
            }

            $this->em->flush();
        }

    }

    //Get Company Videos by companyId
    function getCompanyVideos($companyId){

        

        $dql = "SELECT cv
                FROM \models\CompanyVideo cv
                WHERE cv.company_id = :companyId
                ORDER BY cv.ord ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter('companyId', $companyId);


        $company_videos = $query->getResult();

       
        return $company_videos;
    }

    function companyIntroVideoReset($companyId)
    {
        $this->db->query(
            'UPDATE company_videos
            SET is_intro = 0
            WHERE company_id = ' . $companyId
        );
    }

    public function deleteCompanyVideoById($video_id) {
        $sql = "DELETE FROM company_videos WHERE id = ".$video_id;
        return $this->db->query($sql);
    }

    public function sendAccountExpiryEmailsToMike(){

        $date = Carbon::now()->addDays(5)->timestamp;
        $checkdate = Carbon::now()->addDays(4)->timestamp;

        $CI =& get_instance();
        // Base query
        $sql = "SELECT c.companyId, c.companyName, c.companyStatus, c.new_layouts, a.cellPhone,a.email, c.administrator,c.estimating,
                CONCAT(a.firstName, ' ', a.lastName) AS adminFullName,
                (SELECT GROUP_CONCAT(accountId) FROM accounts a WHERE a.company = c.companyId AND a.deleted = 0 AND a.secretary <> 1 AND a.expires > ".$checkdate." AND a.expires < " . $date . ") AS users,                 
                (SELECT COUNT(accountId) FROM accounts a WHERE a.company = c.companyId AND a.deleted = 0 AND a.secretary <> 1 AND a.expires > ".$checkdate." AND a.expires < " . $date . ") AS numInactiveUsers
                  
            FROM companies c
            LEFT JOIN accounts a ON c.administrator = a.accountId WHERE c.companyId > 0  HAVING numInactiveUsers >0";

       
        $companies = $this->db->query($sql)->result();
        $CI->load->model('system_email');
        foreach($companies as $expiry){

            $usersData = '<table id="user_table"><caption>Users</caption><thead><tr><th scope="col">UserName</th><th scope="col">Role</th><th scope="col">Expiring At</th></tr></thead><tbody>';
            $users = explode(",",$expiry->users);

            foreach($users as $user){
                $newuser = $this->em->findAccount($user);
                $usersData .= "<tr><td>".$newuser->getFullname()."</td><td>".$newuser->getUserClass(true)."</td><td>".date('m/d/Y', $newuser->getExpires())."</td></tr>";
            }

             $usersData .= "</tbody></table>";

             $emailData = array(
                 
                 'siteName' => SITE_NAME,
                 'companyName' => $expiry->companyName,
                 'adminFullName' => $expiry->adminFullName,
                 'adminEmail' => $expiry->email,
                 'adminContact' => $expiry->cellPhone,
                 'Users' => $usersData,
                 
             );
             
             $CI->system_email->sendEmail(52, 'mike@pavementlayers.com', $emailData);
           
        }
        

    }

    public function sendCompanyExpiryEmailsToAdmin(){

        $date = Carbon::now()->addDays(14)->timestamp;
        $checkdate = Carbon::now()->addDays(13)->timestamp;
        $now = Carbon::now()->timestamp;

        $CI =& get_instance();
        // Base query
        $sql = "SELECT c.companyId, c.companyName, c.companyStatus, a.email, a.cellPhone, c.administrator,c.estimating,
                CONCAT(a.firstName, ' ', a.lastName) AS adminFullName,
                (SELECT GROUP_CONCAT(accountId) FROM accounts a WHERE a.company = c.companyId AND a.deleted = 0 AND a.secretary <> 1 AND a.expires > ".$checkdate." AND a.expires < " . $date . ") AS users,                 
                (SELECT COUNT(accountId) FROM accounts a WHERE a.company = c.companyId AND a.deleted = 0 AND a.secretary <> 1 AND a.expires > ".$checkdate." AND a.expires < " . $date . ") AS numInactiveUsers
                  
            FROM companies c
            LEFT JOIN accounts a ON c.administrator = a.accountId WHERE c.companyId > 0  HAVING numInactiveUsers >0";

       
        $companies = $this->db->query($sql)->result();
        $CI->load->model('system_email');
        foreach($companies as $expiry){

            $usersData = '<table id="user_table"><caption>Users</caption><thead><tr><th scope="col">UserName</th><th scope="col">Role</th><th scope="col">Expiring At</th></tr></thead><tbody>';
            $users = explode(",",$expiry->users);

            foreach($users as $user){
                $newuser = $this->em->findAccount($user);
                $usersData .= "<tr><td>".$newuser->getFullname()."</td><td>".$newuser->getUserClass(true)."</td><td>".date('m/d/Y', $newuser->getExpires())."</td></tr>";
            }

             $usersData .= "</tbody></table>";

             
             $emailData = array(
                 
                 'siteName' => SITE_NAME,
                 'companyName' => $expiry->companyName,
                 'adminFullName' => $expiry->adminFullName,
                 'adminContact' => $expiry->cellPhone,
                 'Users' => $usersData,
                 'prior_days' => 14,
             );
             
             //$CI->system_email->sendEmail(53, 'sunil@pavementlayers.com', $emailData);
             $CI->system_email->sendEmail(53, $expiry->email, $emailData);
           
        }

        $date = Carbon::now()->addDays(7)->timestamp;
        $checkdate = Carbon::now()->addDays(6)->timestamp;
        $now = Carbon::now()->timestamp;

        $CI =& get_instance();
        // Base query
        $sql = "SELECT c.companyId, c.companyName, c.companyStatus, a.email, a.cellPhone, c.administrator,c.estimating,
                CONCAT(a.firstName, ' ', a.lastName) AS adminFullName,
                (SELECT GROUP_CONCAT(accountId) FROM accounts a WHERE a.company = c.companyId AND a.deleted = 0 AND a.secretary <> 1 AND a.expires > ".$checkdate." AND a.expires < " . $date . ") AS users,                 
                (SELECT COUNT(accountId) FROM accounts a WHERE a.company = c.companyId AND a.deleted = 0 AND a.secretary <> 1 AND a.expires > ".$checkdate." AND a.expires < " . $date . ") AS numInactiveUsers
                  
            FROM companies c
            LEFT JOIN accounts a ON c.administrator = a.accountId WHERE c.companyId > 0  HAVING numInactiveUsers >0";

       
        $companies = $this->db->query($sql)->result();
        $CI->load->model('system_email');
        foreach($companies as $expiry){

            $usersData = '<table id="user_table"><caption>Users</caption><thead><tr><th scope="col">UserName</th><th scope="col">Role</th><th scope="col">Expiring At</th></tr></thead><tbody>';
            $users = explode(",",$expiry->users);

            foreach($users as $user){
                $newuser = $this->em->findAccount($user);
                $usersData .= "<tr><td>".$newuser->getFullname()."</td><td>".$newuser->getUserClass(true)."</td><td>".date('m/d/Y', $newuser->getExpires())."</td></tr>";
            }

             $usersData .= "</tbody></table>";

             
             $emailData = array(
                 
                 'siteName' => SITE_NAME,
                 'companyName' => $expiry->companyName,
                 'adminFullName' => $expiry->adminFullName,
                 'adminContact' => $expiry->cellPhone,
                 'Users' => $usersData,
                 'prior_days' => 7,
             );
             
             //$CI->system_email->sendEmail(53, 'mike@pavementlayers.com', $emailData);
             $CI->system_email->sendEmail(53, $expiry->email, $emailData);
           
        }
  

    }

    public function getAdminProposalCustomSections()
    {
        $dql = "SELECT ps
        FROM \models\ProposalSection ps where ps.layout = 3
        ORDER BY ps.ord ASC";

        $query = $this->em->createQuery($dql);
        $company_videos = $query->getResult();

        return $company_videos;

    }

    public function getAdminProposalCoolSections()
    {
        $dql = "SELECT ps
        FROM \models\ProposalSection ps where ps.layout = 1
        ORDER BY ps.ord ASC";

        $query = $this->em->createQuery($dql);
        $company_videos = $query->getResult();

        return $company_videos;

    }


    public function getAdminProposalStandardSections()
    {
        $dql = "SELECT ps
        FROM \models\ProposalSection ps where ps.layout = 2
        ORDER BY ps.ord ASC";

        $query = $this->em->createQuery($dql);
        $company_videos = $query->getResult();

        return $company_videos;

    }

    public function getAdminWorkOrderSections()
    {
        $dql = "SELECT wos
        FROM \models\WorkOrderSection wos 
        ORDER BY wos.ord ASC";

        $query = $this->em->createQuery($dql);
        $work_order_sections = $query->getResult();

        return $work_order_sections;

    }

    

    ///

    public function getCompanyProposalCustomSections($company_id)
    {

        $sql = "SELECT ps.*,psc.visible as c_hidden,psc.id as company_section_id
         FROM proposal_sections ps
                 LEFT JOIN proposal_sections_company_order psc ON ps.id = psc.proposal_section_id AND psc.company_id = {$company_id} 
                 WHERE psc.company_id = {$company_id} AND psc.layout = 3
                 ORDER BY COALESCE(psc.ord, 99999)";

        $company_proposal_sections  = $this->db->query($sql)->result();


        if(count($company_proposal_sections)>0){
            return $company_proposal_sections;
        }else{
            return $this->createDefaultCompanyProposalSection($company_id,3);
        }

    }

    public function getCompanyProposalCoolSections($company_id)
    {
        
        $sql = "SELECT ps.*,psc.visible as c_hidden,psc.id as company_section_id
        FROM proposal_sections ps
                LEFT JOIN proposal_sections_company_order psc ON ps.id = psc.proposal_section_id AND psc.company_id = {$company_id} 
                WHERE psc.company_id = {$company_id} AND psc.layout = 1
                ORDER BY COALESCE(psc.ord, 99999)";

       $company_proposal_sections  = $this->db->query($sql)->result();


       if(count($company_proposal_sections)>0){
           return $company_proposal_sections;
       }else{

        return $this->createDefaultCompanyProposalSection($company_id,1);
       }


    }


    public function getCompanyProposalStandardSections($company_id)
    {
        // $rsm = new ResultSetMapping();
        // $rsm->addEntityResult('\models\ProposalSection', 'ps');
        
        // $rsm->addFieldResult('ps', 'id', 'id');
        // $rsm->addFieldResult('ps', 'section_name', 'section_name');
        //$rsm->addJoinedEntityResult('\models\ProposalSectionCompanyOrder', 'psc','ps','proposal_sections_company_order');
       // $rsm->addFieldResult('psc', 'hidden', 'hidden');

        // $sql = "SELECT ps.*
        // FROM proposal_sections ps
        //         LEFT JOIN proposal_sections_company_order psc ON ps.id = psc.proposal_section_id AND psc.company_id = :psCompany 
        //         WHERE psc.company_id = :companyId AND psc.layout = 2
                
        //         ORDER BY COALESCE(psc.ord, 99999), ps.ord";

        // $query = $this->em->createNativeQuery($sql, $rsm);
        // $query->setParameter(':psCompany', $company_id);
        // $query->setParameter(':companyId', $company_id);


        // $company_proposal_sections = $query->getResult();



        $sql = "SELECT ps.*,psc.visible as c_hidden,psc.id as company_section_id
         FROM proposal_sections ps
                 LEFT JOIN proposal_sections_company_order psc ON ps.id = psc.proposal_section_id AND psc.company_id = {$company_id} 
                 WHERE psc.company_id = {$company_id} AND psc.layout = 2
                 ORDER BY COALESCE(psc.ord, 99999)";

        $company_proposal_sections  = $this->db->query($sql)->result();


        if(count($company_proposal_sections)>0){
            return $company_proposal_sections;
        }else{
            return $this->createDefaultCompanyProposalSection($company_id,2);

        }

    }

    function createDefaultCompanyProposalSection($company_id,$layout){
        $sql = "SELECT ps.* FROM proposal_sections ps";

        $proposal_sections  = $this->db->query($sql)->result();

        foreach($proposal_sections as $proposal_section){
            $psco = new ProposalSectionCompanyOrder();
            $psco->setProposalSectionId($proposal_section->id);
            $psco->setCompanyId($company_id);
            $psco->setLayout($proposal_section->layout);
            $psco->setOrd($proposal_section->ord);
            $this->em->persist($psco);

        }
        $this->em->flush();

        $sql = "SELECT ps.*,psc.visible as c_hidden,psc.id as company_section_id
         FROM proposal_sections ps
                 LEFT JOIN proposal_sections_company_order psc ON ps.id = psc.proposal_section_id AND psc.company_id = {$company_id} 
                 WHERE psc.company_id = {$company_id} AND psc.layout = {$layout}
                 ORDER BY COALESCE(psc.ord, 99999)";

        $company_proposal_sections  = $this->db->query($sql)->result();

        return $company_proposal_sections;

    }

    function createDefaultIndividualProposalSection($proposal_id,$company_id,$layout){
        
        $sql = "SELECT ps.*,psc.visible as c_hidden,psc.id as company_section_id
         FROM proposal_sections ps
                 LEFT JOIN proposal_sections_company_order psc ON ps.id = psc.proposal_section_id AND psc.company_id = {$company_id} 
                 WHERE psc.company_id = {$company_id} AND psc.layout = {$layout}
                 ORDER BY COALESCE(psc.ord, 99999)";

        $company_proposal_sections  = $this->db->query($sql)->result();

        if(count($company_proposal_sections)>0){

            foreach($company_proposal_sections as $proposal_section){
                $psio = new ProposalSectionIndividualOrder();
                $psio->setProposalSectionId($proposal_section->id);
                $psio->setProposalId($proposal_id);
                $psio->setOrd($proposal_section->ord);
                $this->em->persist($psio);
                $this->em->flush();
            }
            
        }else{

            $company_proposal_sections = $this->createDefaultCompanyProposalSection($company_id,$layout);

            foreach($company_proposal_sections as $proposal_section){
                $psio = new ProposalSectionIndividualOrder();
                $psio->setProposalSectionId($proposal_section->id);
                $psio->setProposalId($proposal_id);
                $psio->setOrd($proposal_section->ord);
                $this->em->persist($psio);
                $this->em->flush();
            }
            

        }

        $sql = "SELECT ps.*,psi.visible as p_visible,psi.id as individual_section_id
        FROM proposal_sections ps
                
                LEFT JOIN proposal_sections_individual_order psi ON ps.id = psi.proposal_section_id AND psi.proposal_id = {$proposal_id}
                WHERE psi.proposal_id = {$proposal_id}
                ORDER BY COALESCE(psi.ord, 99999),ps.ord";

       return $this->db->query($sql)->result();

    }

    

    function clearCompanyProposalSectionOrder($company_id,$layout)
    {
        $dql = "DELETE \models\ProposalSectionCompanyOrder psco
                WHERE psco.company_id = {$company_id} AND psco.layout = {$layout}";

        $query = $this->em->createQuery($dql);

        $query->execute();
    }

    function clearIndividualProposalSectionOrder($proposal_id)
    {
        $sql = "DELETE FROM proposal_sections_individual_order WHERE proposal_id = ".$proposal_id;
        return $this->db->query($sql);

        
    }

    public function getIndividualProposalSections($proposal,$layout)
    {
        $proposal_id = $proposal->getProposalId();
        $company_id = $proposal->getCompanyId();

        $sql = "SELECT * FROM proposal_sections_individual_order WHERE proposal_id = ".$proposal_id;
        $proposal_sections = $this->db->query($sql)->result();

       if(count($proposal_sections)>0){

        $sql = "SELECT ps.*,psi.visible as p_visible,psi.id as individual_section_id
        FROM proposal_sections ps
                
                LEFT JOIN proposal_sections_individual_order psi ON ps.id = psi.proposal_section_id AND psi.proposal_id = {$proposal_id}
                WHERE psi.proposal_id = {$proposal_id}
                ORDER BY COALESCE(psi.ord, 99999),ps.ord";

       $company_proposal_sections  = $this->db->query($sql)->result();

           return $company_proposal_sections;
       }else{

        return $this->createDefaultIndividualProposalSection($proposal_id,$company_id,$layout);
       }


    }

    function createDefaultCompanyWorkOrderSection($company_id){
        $sql = "SELECT ps.* FROM work_order_sections ps";

        $work_order_sections  = $this->db->query($sql)->result();

        foreach($work_order_sections as $work_order_section){
            $wosco = new WorkOrderSectionCompanyOrder();
            
            $wosco->setWorkOrderSectionId($work_order_section->id);
            $wosco->setCompanyId($company_id);
            $wosco->setOrd($work_order_section->ord);
            $this->em->persist($wosco);

        }
        
        $this->em->flush();

        $sql = "SELECT wos.*,wosc.visible as c_visible,wosc.id as company_section_id
        FROM work_order_sections wos
                LEFT JOIN work_order_sections_company_order wosc ON wos.id = wosc.work_order_section_id AND wosc.company_id = {$company_id} 
                WHERE wosc.company_id = {$company_id} 
                ORDER BY COALESCE(wosc.ord, 99999)";

        $company_proposal_sections  = $this->db->query($sql)->result();

        return $company_proposal_sections;

    }


    public function getCompanyWorkOrderSections($company_id)
    {
        
        $sql = "SELECT wos.*,wosc.visible as c_visible,wosc.id as company_section_id
        FROM work_order_sections wos
                LEFT JOIN work_order_sections_company_order wosc ON wos.id = wosc.work_order_section_id AND wosc.company_id = {$company_id} 
                WHERE wosc.company_id = {$company_id} 
                ORDER BY COALESCE(wosc.ord, 99999)";

       $company_work_order_sections  = $this->db->query($sql)->result();

       if(count($company_work_order_sections)>0){
           return $company_work_order_sections;
       }else{

        return $this->createDefaultCompanyWorkOrderSection($company_id);
       }

    }

    function getParentChildCompanies($companyId){
        $sql = "SELECT c.companyId,c.companyName FROM companies c 
                LEFT JOIN companies_parent_child_ralations cpc ON c.companyId = cpc.child_company_id
                WHERE cpc.parent_company_id =  " . $companyId;

        $data = $this->db->query($sql)->result();
        return $data;
    }

    function getChildSubloginAccount($account,$companyId){
        $sql = "SELECT a.accountId FROM accounts a 
                
                WHERE a.company =  " . $companyId." AND parent_user_id = ".$account->getAccountId();

        $data = $this->db->query($sql)->result();
        if(isset($data[0])){
            return $data[0]->accountId;
        }else{
            return false;
        }
    }

    

        /**
     * @param $companyId
     * @param null $branchId
     * @param bool $array
     * @return array
     */
    public function getMasterSalesAccounts($companyIds, $branchId = null, $array = false)
    {
        $dql = "SELECT a
                FROM \models\Accounts a
                WHERE a.company IN( :companyIds)
                AND a.deleted = 0
                AND a.sales = 1";

        // Add branch to query if we have one
        // if (isset($branchId)) {
        //     $dql .= " AND a.branch = :branchId";
        // }
        if ($branchId != null) {
            if ($branchId>0) {
                $dql .= " AND a.branch = :branchId";
            }else{
                $dql .= " AND (a.branch = 0 OR a.branch IS NULL) ";
            }
        }

        // Complete the query
        $dql .= " ORDER BY a.firstName ASC";

        $query = $this->em->createQuery($dql);
        $query->setParameter('companyIds', $companyIds);

        if ($branchId != null) {
            if ($branchId>0) {
                $query->setParameter('branchId', $branchId);
            }
        }
        // if (isset($branchId)) {
        //     $query->setParameter('branchId', $branchId);
        // }

        $accounts = $query->getResult();

      

        if ($array) {
            $out = [];
            foreach ($accounts as $acc) {
                $out[$acc->getAccountId()] = $acc->getFullName();
            }
            return $out;
        }

        return $accounts;
    }


    /**
     * @param $companyIds
     * @return mixed
     */
    public function getParentCompanyBusinessTypes($companyIds, $array = false)
    {
        $rsm = new ResultSetMapping();
        $rsm->addEntityResult('\models\BusinessType', 'bt');
        $rsm->addFieldResult('bt', 'id', 'id');
        $rsm->addFieldResult('bt', 'type_name', 'type_name');
        $rsm->addFieldResult('bt', 'company_id', 'company_id');

        $sql = "SELECT bt.*
        FROM business_types bt
                LEFT JOIN business_type_deleted btd ON bt.id = btd.business_type_id
                WHERE (bt.company_id IS NULL
                OR bt.company_id IN(:companyIds))
                AND btd.id IS NULL 
                AND bt.deleted = 0
               ";

        $query = $this->em->createNativeQuery($sql, $rsm);
        $query->setParameter(':companyIds', $companyIds);

 
        $businessTypes = $query->getResult();

        if ($array) {
            $out = [];
            foreach ($businessTypes as $businessType) {
                //print_r($prospectRating->getId());
                /* @var \models\ProspectSource $prospectSource */
                $out[$businessType->getId()] = $businessType->getTypeName();
            }
            //die;
            return $out;
        }


        return $businessTypes;
    }

}