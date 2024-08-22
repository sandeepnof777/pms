<?php
class Branchesapi extends CI_Model {
    function __construct() {
        parent::__construct();
        $this->em = $this->doctrine->em;
    }

    function getBranches($companyId) {
       
        $branches_doctrine = $this->em->createQuery('select b from models\Branches b where b.company=' . $companyId)->getResult();
       
        $branches = array();
        foreach ($branches_doctrine as $branch) {
            $branches[$branch->getBranchId()] = $branch;
        }
        return $branches;
    }

    function getUserCount($companyId, $branchId = NULL) {
        $this->load->database();
        if ($branchId) {
            $count = $this->db->query("select count(accountId) as count from accounts where branch=" . $branchId . ' and company=' . $companyId)->result();
        } else {
            $count = $this->db->query("SELECT count(accountId) as count FROM accounts LEFT JOIN branches ON accounts.branch = branches.branchId WHERE accounts.company = {$companyId} AND (accounts.branch IS NULL OR branches.branchId IS NULL)")->result();
        }
        $count = $count[0]->count;
        return $count;
    }

    function getBranchAccounts($companyId, $branchId) {
        $CI =& get_instance();

        $dql = "SELECT a
                FROM \models\Accounts a
                WHERE a.branch = :branch
                AND a.company = :company
                AND a.secretary = 0
                ORDER BY a.firstName ASC";

        $query = $CI->doctrine->em->createQuery($dql);
        $query->setParameter('branch', $branchId);
        $query->setParameter('company', $companyId);

        $accounts = $query->getResult();

        return $accounts;
    }
}