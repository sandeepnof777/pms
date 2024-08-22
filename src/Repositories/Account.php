<?php
namespace Pms\Repositories;

use Pms\RepositoryAbstract;
use Pms\Traits\CITrait;
use Pms\Traits\DBTrait;
use \models\Accounts;
use \models\Proposals;

class Account extends RepositoryAbstract
{
    use DBTrait;

    public function getBasicEmailInformation($accountId)
    {
        return $this->getSingleResult("select firstName as first_name, lastName as last_name from accounts where accountId = {$accountId}", 'array');
    }

    public function getEmailById($accountId)
    {
        return $this->scalar('select email from accounts where accountId=' . $accountId, 'email');
    }

    public function getAllAccounts($company)
    {
        return $this->getAllResultsIndexed("select * from accounts where company = {$company}", 'accountId');
    }

    public function getUserData($accountId)
    {
        return $this->getSingleResult('select * from accounts where accountId=' . $accountId);
    }

    public function getLoggedAccount()
    {
        $loggedUser = $this->ci->session->userdata('sublogin') ?: $this->ci->session->userdata('accountId');
        return ($loggedUser) ? $this->getUserData($loggedUser) : null;
    }

    public function getAllAccountsByPermission($accountId, $objects = false)
    {
        /** @var \models\Accounts $account */
        $account = $this->em->find('models\Accounts', $accountId);
        $company = $account->getCompany()->getCompanyId();
        $sql = "select * from accounts where company = {$company}";
        if (!$account->isAdministrator() && !$account->hasFullAccess() && $account->isBranchAdmin()) {
            $sql .= ' and branch = ' . $account->getBranch();
        } elseif (!$account->isAdministrator(true) && !$account->hasFullAccess()) {
            $sql .= ' and accountId = ' . $accountId;
        }

        if ($objects) {
            $out = [];
            $accountsData = $this->getAllResults($sql);
            foreach ($accountsData as $result) {
                $account = $this->em->findAccount($result->accountId);
                if ($account) {
                    $out[] = $account;
                }
            }
            return $out;
        }

        return $this->getAllResultsIndexed($sql, 'accountId');
    }

    function updateMultipleExpiry($accounts, $expirationDate)
    {
        
        // if (is_array($accounts)) {
        //     $expiryTimestamp = strtotime($expirationDate . ' 23:59:59');
        //     foreach ($accounts as $account) {
        //         $this->update('accounts', 'accountId', $account, ['expires' => $expiryTimestamp]);
        //     }
        // }
        if (is_array($accounts)) {
            $expiryTimestamp = strtotime($expirationDate . ' 23:59:59');
            foreach ($accounts as $account) {
                $this->update('accounts', 'accountId', $account, ['expires' => $expiryTimestamp]);
            }
            // Add code for child expires updation Start
            $this->db->select('a.accountId');
            $this->db->from('accounts a');
            $this->db->where_in('a.parent_user_id', $accounts);
            $query = $this->db->get();
            $result = $query->result_array();
            if(!empty($result)){
                foreach ($result as $childaccount) {
                    $this->update('accounts', 'accountId', $childaccount['accountId'], ['expires' => $expiryTimestamp]);
                }
            }
            // Add code for child expires updation  End
        }
    }

    function updateEnableDisableWO($accounts, $enable_disable)
    {
        if (is_array($accounts)) {
          
            foreach ($accounts as $account) {
                $this->update('accounts', 'accountId', $account, ['wio' => $enable_disable]);
            }
        }
    }

    /**
     * @param Accounts $account
     * @return array
     */
    public function getMapData(Accounts $account)
    {
        $data = [
            'prospects' => $this->getProspectsMapData($account),
            'leads' => $this->getProspectsMapData($account),
            'proposals' => $this->getProposalsMapData($account)
        ];

        return $data;
    }

    /**
 * @param $account
 * @return array
 */
    public function getProspectsMapData(Accounts $account)
    {
        // The Data array
        $data = [];

        // Get the prospects for this account
        $prospectData = $account->getProspects();

        foreach($prospectData as $prospect) {
            /* @var \models\Prospects $prospect */
            $datum = [
                'id' => $prospect->getProspectId(),
                'title' => $prospect->getTitle(),
                'fullName' => $prospect->getFullName(),
                'companyName' => $prospect->getCompanyName(),
                'email' => $prospect->getEmail(),
                'phone' => $prospect->getBusinessPhone(),
                'cellPhone' => $prospect->getCellPhone(),
                'address' => $prospect->getAddress(),
                'city' => $prospect->getCity(),
                'state' => $prospect->getState(),
                'zip' => $prospect->getZip(),
                'source' => $prospect->getProspectSourceText(),
                'status' => $prospect->getStatus(),
                'rating' => $prospect->getRating(),
                'business' => $prospect->getBusiness(),
                'created' => $prospect->getCreated(),
                'lat' => $prospect->getLat(),
                'lng' => $prospect->getLng()
            ];
            $data[$prospect->getProspectId()] = $datum;
        }

        return $data;
    }


    /**
 * @param $account
 * @return array
 */
    public function getLeadsMapData(Accounts $account)
    {
        // The Data array
        $data = [];

        // Get the prospects for this account
        $leadsData = $account->getLeads();

        foreach($leadsData as $lead) {
            /* @var \models\Leads $lead */
            $datum = [
                'id' => $lead->getLeadId(),
                'title' => $lead->getTitle(),
                'fullName' => $lead->getFullName(),
                'companyName' => $lead->getCompanyName(),
                'email' => $lead->getEmail(),
                'phone' => $lead->getBusinessPhone(),
                'cellPhone' => $lead->getCellPhone(),
                'address' => $lead->getAddress(),
                'city' => $lead->getCity(),
                'state' => $lead->getState(),
                'zip' => $lead->getZip(),
                'status' => $lead->getStatus(),
                'rating' => $lead->getRating(),
                'created' => $lead->getCreated(),
                'lat' => $lead->getLat(),
                'lng' => $lead->getLng()
            ];
            $data[$lead->getLeadId()] = $datum;
        }

        return $data;
    }

    public function getProposalsMapDataPoints(Accounts $account, $page, $numRecords, $coords, $count = false)
    {
        // The data array
        $data = [];
        // Get the proposals based on filters
        $props = $account->getProposalsData(null, null, false, true, true, $page, $numRecords, $coords);

        if ($count) {
            return count($props);
        }

        // Populate the data array
        foreach ($props as $proposalData) {
            /* @var \models\Proposals $proposal */
            $proposal = $this->em->findProposal($proposalData->proposalId);

            // Proposal
            $proposalData = [
                'id' => $proposal->getProposalId(),
                'lat' => $proposal->getLat(),
                'lng' => $proposal->getLng(),
                'projectName' => $proposal->getProjectName()
            ];            // Build data array
            $data[$proposal->getProposalId()] = [
                'proposal' => $proposalData
            ];
        }

        return $data;
    }

    /**
     * @param Accounts $fromUser
     * @param Accounts $toUser
     */
    public function reassignAll(Accounts $fromUser, Accounts $toUser)
    {
        $this->reassignAllAccounts($fromUser, $toUser);
        $this->reassignAllProspects($fromUser, $toUser);
        $this->reassignAllLeads($fromUser, $toUser);
        $this->reassignAllProposals($fromUser, $toUser);
        $this->reassignAllContacts($fromUser, $toUser);
        $this->reassignAllReports($fromUser, $toUser);
    }

    /**
     * @param Accounts $fromUser
     * @param Accounts $toUser
     */
    public function reassignAllLeads(Accounts $fromUser, Accounts $toUser)
    {
        $this->db->query("UPDATE leads SET account = " . $toUser->getAccountId() . " WHERE account = " . $fromUser->getAccountId());
    }

    /**
     * @param Accounts $fromUser
     * @param Accounts $toUser
     */
    public function reassignAllProposals(Accounts $fromUser, Accounts $toUser)
    {
        $this->db->query("UPDATE proposals SET owner = " . $toUser->getAccountId() . " WHERE owner = " . $fromUser->getAccountId());
    }

    /**
     * @param Accounts $fromUser
     * @param Accounts $toUser
     */
    public function reassignAllProspects(Accounts $fromUser, Accounts $toUser)
    {
        $this->db->query("UPDATE prospects SET account = " . $toUser->getAccountId() . " WHERE account = " . $fromUser->getAccountId());
    }

    /**
     * @param Accounts $fromUser
     * @param Accounts $toUser
     */
    public function reassignAllAccounts(Accounts $fromUser, Accounts $toUser)
    {
        $this->db->query("UPDATE client_companies SET owner_user = " . $toUser->getAccountId() . " WHERE owner_user = " . $fromUser->getAccountId());
    }

    /**
     * @param Accounts $fromUser
     * @param Accounts $toUser
     */
    public function reassignAllContacts(Accounts $fromUser, Accounts $toUser)
    {
        $this->db->query("UPDATE clients SET account = " . $toUser->getAccountId() . " WHERE account = " . $fromUser->getAccountId());
    }

    /**
     * @param Accounts $fromUser
     * @param Accounts $toUser
     */
    public function reassignAllReports(Accounts $fromUser, Accounts $toUser)
    {
        $this->db->query("UPDATE saved_reports SET account = " . $toUser->getAccountId() . " WHERE account = " . $fromUser->getAccountId());
    }

    /**
     * @param Accounts $account
     * @return mixed
     */
    public function getCompanyServiceCategories(Accounts $account)
    {
        return $account->getCompany()->getCategories();
    }

    public function getAccountBusinessTypes($account_id){
        $sql = "SELECT bta.business_type_id,bt.type_name
        FROM business_type_assignments bta 
        LEFT JOIN business_types bt ON bta.business_type_id = bt.id
        WHERE bta.account_id=".$account_id;
        return $this->getAllResults($sql);

    }
    function getAccountSavedFilters($account)
    {
        $sql = "SELECT spf.*
        FROM saved_proposal_filter spf WHERE user_id = ".$account->getAccountId()." AND filter_page = 'Account' ORDER BY ord";

        return $this->getAllResults($sql);
    }
}