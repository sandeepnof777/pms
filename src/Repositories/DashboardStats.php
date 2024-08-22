<?php
namespace Pms\Repositories;

use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;

/**
 * Class used to compute the dashboard stats
 * @todo rename it to Stats later
 * Class DashboardStats
 * @package Pms\Repositories
 */
class DashboardStats extends RepositoryAbstract
{
    use DBTrait;

    /**
     * Gets all company stats in a big array that will be used to populate the dashboard
     * @param $companyId
     * @param $start
     * @param $finish
     * @param $accountId
     * @param $branchId
     * @return array
     */
    public function getCompanyStats($companyId, $start, $finish, $accountId = null, $branchId = null)
    {
        $avgConversion = $this->leadAvgConversion($companyId, $start, $finish, $accountId, $branchId);
        $leadsCount = $this->totalLeads($companyId, $start, $finish, $accountId, $branchId);
        $leadsActiveConverted = $this->leadsActiveConverted($companyId, $start, $finish, $accountId, $branchId);
        $leadsAdded = $this->leadsAdded($companyId, $start, $finish, $accountId, $branchId);
        return [
            //date interval
            'leadsCount' => $leadsCount,
            'leadsActive' => $this->leadsActive($companyId, $start, $finish, $accountId, $branchId),
            'leadsConverted' => $this->leadsConverted($companyId, $start, $finish, $accountId, $branchId),
            'leadsConvertedPercent' => ($leadsCount) ? number_format((($leadsActiveConverted * 100) / $leadsCount), 1) : 0,
            'leadsCancelled' => $this->leadsCancelled($companyId, $start, $finish, $accountId, $branchId),
            'leadsAvgConversion' => ($avgConversion) ? $avgConversion : 'No Data',
            'leadsAdded' => $leadsAdded ?: 0,
            //no date interval
            'leadsNew' => $this->leadsNew($companyId, $start, $finish, $accountId, $branchId),
            'leadsCurrent' => $this->leadsCurrent($companyId, $start, $finish, $accountId, $branchId),
            'leadsOld' => $this->leadsOld($companyId, $start, $finish, $accountId, $branchId),
        ];
    }

    /**
     * Gets Lead Average Conversion Time
     * @param $companyId
     * @param $start
     * @param $finish
     * @param null $accountId
     * @param null $branchId
     * @param bool $unassigned
     * @return mixed
     */
    public function leadAvgConversion($companyId, $start, $finish, $accountId = null, $branchId = null, $unassigned = false)
    {
        $sql = "SELECT (round(avg(l.convertedTime - l.created) / 86400, 1)) AS average FROM leads l";
        if ($branchId) {
            $sql .= ' inner join accounts a on a.accountId = l.account';
        }
        $sql .= " WHERE (l.created between {$start} and {$finish}) and l.company = {$companyId} AND l.`STATUS` = 'Converted'";
        if ($accountId) {
            $sql .= " AND l.account = {$accountId}";
        }
        if ($branchId) {
            $sql .= " and a.branch = {$branchId}";
        }
        if (!$accountId && !$branchId && $unassigned) {
            $sql .= " AND (l.account is null or l.account = 0)";
        }
        return $this->scalar($sql, 'average');
    }

    /**
     * Gets the number of new leads
     * @param $companyId
     * @param $start
     * @param $finish
     * @param null $accountId
     * @param null $branchId
     * @param bool $unassigned
     * @return mixed
     */
    public function leadsNew($companyId, $start, $finish, $accountId = null, $branchId = null, $unassigned = false)
    {
        $timeStamp = time() - (86400 * 2);
        $sql = "select count(l.leadId) as counter from leads l";
        if ($branchId) {
            $sql .= ' inner join accounts a on a.accountId = l.account';
        }
        $sql .= " where l.created >= {$timeStamp} and (l.created between {$start} and {$finish}) and (l.status = 'Working' or l.status = 'Waiting for subs') and l.company = {$companyId}";
        if ($accountId) {
            $sql .= " AND l.account = {$accountId}";
        }
        if ($branchId) {
            $sql .= " and a.branch = {$branchId}";
        }
        if (!$accountId && !$branchId && $unassigned) {
            $sql .= " AND (l.account is null or l.account = 0)";
        }
        return $this->scalar($sql, 'counter');
    }

    /**
     * Gets the number of the company current leads
     * @param $companyId
     * @param $start
     * @param $finish
     * @param null $accountId
     * @param null $branchId
     * @param bool $unassigned
     * @return mixed
     */
    public function leadsCurrent($companyId, $start, $finish, $accountId = null, $branchId = null, $unassigned = false)
    {
        $timeStampMin = time() - (86400 * 7);
        $timeStampMax = time() - (86400 * 2);
        $sql = "select count(l.leadId) as counter from leads l";
        if ($branchId) {
            $sql .= ' inner join accounts a on a.accountId = l.account';
        }
        $sql .= " where (l.created > {$timeStampMin} and l.created < {$timeStampMax}) and (l.created between {$start} and {$finish}) and (l.status = 'Working' or l.status = 'Waiting for subs') and l.company = {$companyId}";
        if ($accountId) {
            $sql .= " AND l.account = {$accountId}";
        }
        if ($branchId) {
            $sql .= " and a.branch = {$branchId}";
        }
        if (!$accountId && !$branchId && $unassigned) {
            $sql .= " AND (l.account is null or l.account = 0)";
        }
        return $this->scalar($sql, 'counter');
    }

    /**
     * Gets the number of old leads
     * @param $companyId
     * @param $start
     * @param $finish
     * @param null $accountId
     * @param null $branchId
     * @param bool $unassigned
     * @return mixed
     */
    public function leadsOld($companyId, $start, $finish, $accountId = null, $branchId = null, $unassigned = false)
    {
        $timeStamp = time() - (86400 * 7);
        $sql = "select count(l.leadId) as counter from leads l";
        if ($branchId) {
            $sql .= ' inner join accounts a on a.accountId = l.account';
        }
        $sql .= " where l.created <= {$timeStamp} and (l.created between {$start} and {$finish}) and (l.status = 'Working' or l.status = 'Waiting for subs') and l.company = {$companyId}";
        if ($accountId) {
            $sql .= " AND l.account = {$accountId}";
        }
        if ($branchId) {
            $sql .= " and a.branch = {$branchId}";
        }
        if (!$accountId && !$branchId && $unassigned) {
            $sql .= " AND (l.account is null or l.account = 0)";
        }
        return $this->scalar($sql, 'counter');
    }

    /**
     * Gets the number of active leads
     * @param $companyId
     * @param $start
     * @param $finish
     * @param null $accountId
     * @param null $branchId
     * @param bool $unassigned
     * @return mixed
     */
    public function leadsActive($companyId, $start, $finish, $accountId = null, $branchId = null, $unassigned = false)
    {
        $sql = "select count(l.leadId) as counter from leads l";
        if ($branchId) {
            $sql .= ' inner join accounts a on a.accountId = l.account';
        }
        $sql .= " where (l.created between {$start} and {$finish}) and (l.status = 'Working' or l.status = 'Waiting for subs') and l.company = {$companyId}";
        if ($accountId) {
            $sql .= " AND l.account = {$accountId}";
        }
        if ($branchId) {
            $sql .= " and a.branch = {$branchId}";
        }
        if (!$accountId && !$branchId && $unassigned) {
            $sql .= " AND (l.account is null or l.account = 0)";
        }
        return $this->scalar($sql, 'counter');
    }

    /**
     * Gets the number of cancelled leads
     * @param $companyId
     * @param $start
     * @param $finish
     * @param null $accountId
     * @param null $branchId
     * @param bool $unassigned
     * @return mixed
     */
    public function leadsCancelled($companyId, $start, $finish, $accountId = null, $branchId = null, $unassigned = false)
    {
        $sql = "select count(l.leadId) as counter from leads l";
        if ($branchId) {
            $sql .= ' inner join accounts a on a.accountId = l.account';
        }
        $sql .= " where (l.created between {$start} and {$finish}) and l.status = 'Cancelled' and l.company = {$companyId}";
        if ($accountId) {
            $sql .= " AND l.account = {$accountId}";
        }
        if ($branchId) {
            $sql .= " and a.branch = {$branchId}";
        }
        if (!$accountId && !$branchId && $unassigned) {
            $sql .= " AND (l.account is null or l.account = 0)";
        }
        return $this->scalar($sql, 'counter');
    }

    /**
     * Get number of converted leads
     * @param $companyId
     * @param $start
     * @param $finish
     * @param null $accountId
     * @param null $branchId
     * @param bool $unassigned
     * @return mixed
     */
    public function leadsConverted($companyId, $start, $finish, $accountId = null, $branchId = null, $unassigned = false)
    {
        $sql = "select count(l.leadId) as counter from leads l";
        if ($branchId) {
            $sql .= ' inner join accounts a on a.accountId = l.account';
        }
        $sql .= " where (l.created between {$start} and {$finish}) and (l.convertedTime between {$start} and {$finish}) and l.status = 'Converted' and l.company = {$companyId}";
        if ($accountId) {
            $sql .= " AND l.account = {$accountId}";
        }
        if ($branchId) {
            $sql .= " and a.branch = {$branchId}";
        }
        if (!$accountId && !$branchId && $unassigned) {
            $sql .= " AND (l.account is null or l.account = 0)";
        }
        return $this->scalar($sql, 'counter');
    }
    /**
     * Get number of converted leads
     * @param $companyId
     * @param $start
     * @param $finish
     * @param null $accountId
     * @param null $branchId
     * @param bool $unassigned
     * @return mixed
     */
    public function leadsActiveConverted($companyId, $start, $finish, $accountId = null, $branchId = null, $unassigned = false)
    {
        $sql = "select count(l.leadId) as counter from leads l";
        if ($branchId) {
            $sql .= ' inner join accounts a on a.accountId = l.account';
        }
        $sql .= " where (l.convertedTime between {$start} and {$finish}) and (l.created between {$start} and {$finish}) and l.status = 'Converted' and l.company = {$companyId}";
        if ($accountId) {
            $sql .= " AND l.account = {$accountId}";
        }
        if ($branchId) {
            $sql .= " and a.branch = {$branchId}";
        }
        if (!$accountId && !$branchId && $unassigned) {
            $sql .= " AND (l.account is null or l.account = 0)";
        }
        return $this->scalar($sql, 'counter');
    }

    /**
     * Gets the total number of leads
     * @param $companyId
     * @param $start
     * @param $finish
     * @param null $accountId
     * @param null $branchId
     * @param bool $unassigned
     * @return mixed
     */
    public function totalLeads($companyId, $start, $finish, $accountId = null, $branchId = null, $unassigned = false)
    {
        $sql = "select count(l.leadId) as counter from leads l";
        if ($branchId) {
            $sql .= ' inner join accounts a on a.accountId = l.account';
        }
        $sql .= " where (l.created between {$start} and {$finish}) and l.company = {$companyId}";
        if ($accountId) {
            $sql .= " AND l.account = {$accountId}";
        }
        if ($branchId) {
            $sql .= " AND a.branch = {$branchId}";
        }
        if (!$accountId && !$branchId && $unassigned) {
            $sql .= " AND (l.account is null or l.account = 0)";
        }
        return $this->scalar($sql, 'counter');
    }

    public function leadsAdded($companyId, $start, $finish, $accountId = null, $branchId = null)
    {
        $sql = "select count(l.leadId) as counter from leads l";
        if ($branchId) {
            $sql .= ' inner join accounts a on a.accountId = l.account';
        }
        $sql .= " where (l.created between {$start} and {$finish}) and l.company = {$companyId}";
        if ($accountId) {
            $sql .= " AND l.account = {$accountId}";
        }
        if ($branchId) {
            $sql .= " AND a.branch = {$branchId}";
        }

        return $this->scalar($sql, 'counter');
    }

    public function getMasterCompanyStats($company, $start, $finish, $accountIds = null, $branchId = null,$childIds = null)
    {
        $avgConversion = $this->leadMasterAvgConversion($start, $finish, $accountIds, $branchId,false,$childIds);


        $leadsCount = $this->totalMasterLeads($start, $finish, $accountIds, $branchId,false,$childIds);
        $leadsActiveConverted = $this->leadsMasterActiveConverted($start, $finish, $accountIds,$branchId,false,$childIds);
        $leadsAdded = $this->leadsMasterAdded($start, $finish, $accountIds, $branchId,$childIds);
        return [
            //date interval
            'leadsCount' => $leadsCount,
            'leadsActive' => $this->leadsMasterActive($start, $finish, $accountIds, $branchId,false,$childIds),
            'leadsConverted' => $this->leadsMasterConverted($start, $finish, $accountIds, $branchId,false,$childIds),
            'leadsConvertedPercent' => ($leadsCount) ? number_format((($leadsActiveConverted * 100) / $leadsCount), 1) : 0,
            'leadsCancelled' => $this->leadsMasterCancelled($start, $finish, $accountIds, $branchId,false,$childIds),
            'leadsAvgConversion' => ($avgConversion) ? $avgConversion : 'No Data',
            'leadsAdded' => $leadsAdded ?: 0,
            //no date interval
            'leadsNew' => $this->leadsMasterNew($start, $finish, $accountIds, $branchId,false,$childIds),
            'leadsCurrent' => $this->leadsMasterCurrent($start, $finish, $accountIds, $branchId,false,$childIds),
            'leadsOld' => $this->leadsMasterOld($start, $finish, $accountIds, $branchId,false,$childIds),
        ];
    }

    public function getMasterCompanyBranchStats($filterBranches, $start, $finish)
    {
        

        $leadsCount = 0;
        $leadsActiveConverted = 0;
        $leadsAdded = 0;

        $leadsActive = 0;
        $leadsConverted = 0;
        $leadsCancelled = 0;

        $avgConversion = 0;
        $leadsNew = 0;
        $leadsCurrent = 0;
        $leadsOld = 0;


        foreach($filterBranches as $filterBranch){

            //if( $filterBranch['branchId'] > 0){

                $avgConversion += $this->leadMasterAvgConversion($start, $finish, null, $filterBranch['branchId'],false,[$filterBranch['companyId']]);


                $leadsCount += $this->totalMasterLeads($start, $finish, null, $filterBranch['branchId'],false,[$filterBranch['companyId']]);
                $leadsActiveConverted += $this->leadsMasterActiveConverted($start, $finish, null,$filterBranch['branchId'],false,[$filterBranch['companyId']]);
                $leadsAdded += $this->leadsMasterAdded($start, $finish, null, $filterBranch['branchId'],[$filterBranch['companyId']]);
                $leadsActive += $this->leadsMasterActive($start, $finish, null, $filterBranch['branchId'],false,[$filterBranch['companyId']]);
                $leadsConverted += $this->leadsMasterConverted($start, $finish, null, $filterBranch['branchId'],false,[$filterBranch['companyId']]);
                $leadsCancelled += $this->leadsMasterCancelled($start, $finish, null, $filterBranch['branchId'],false,[$filterBranch['companyId']]);
                $leadsNew += $this->leadsMasterNew($start, $finish, null, $filterBranch['branchId'],false,[$filterBranch['companyId']]);
                $leadsCurrent += $this->leadsMasterCurrent($start, $finish, null, $filterBranch['branchId'],false,[$filterBranch['companyId']]);
                $leadsOld += $this->leadsMasterOld($start, $finish, null, $filterBranch['branchId'],false,[$filterBranch['companyId']]);

            // }else{

                

            // }

        }
     

        return [
            //date interval
             'leadsCount' => $leadsCount,
             'leadsActive' => $leadsActive,
             'leadsConverted' => $leadsConverted,
             'leadsConvertedPercent' => ($leadsCount) ? number_format((($leadsActiveConverted * 100) / $leadsCount), 1) : 0,
             'leadsCancelled' => $leadsCancelled,
             'leadsAvgConversion' => ($avgConversion) ? $avgConversion : 'No Data',
             'leadsAdded' => $leadsAdded ?: 0,
            // //no date interval
             'leadsNew' => $leadsNew,
             'leadsCurrent' => $leadsCurrent,
             'leadsOld' => $leadsOld,
        ];


    }

    /**
     * Gets Lead Average Conversion Time
     * @param $company
     * @param $start
     * @param $finish
     * @param null $accountId
     * @param null $branchId
     * @param bool $unassigned
     * @return mixed
     */
    public function leadMasterAvgConversion($start, $finish, $accountIds = null, $branchId = null, $unassigned = false,$childCompanyIds = null)
    {


        $sql = "SELECT (round(avg(l.convertedTime - l.created) / 86400, 1)) AS average FROM leads l";
        if ($branchId != null) {
            $sql .= ' left join accounts a on a.accountId = l.account';
        }
        $sql .= " WHERE (l.created between {$start} and {$finish}) AND l.`STATUS` = 'Converted'";
        
        if($childCompanyIds){
            $sql .= "and l.company IN(".implode(",",$childCompanyIds).") ";
        }
        if ($accountIds) {
            $sql .= " AND l.account IN(".implode(',',$accountIds).")";
        }
        if ($branchId != null) {
            if ($branchId>0) {
                $sql .= " and a.branch = {$branchId}";
            }else{
                $sql .= " and (a.branch = 0 OR a.branch IS NULL) ";
            }
        }
        if (!$accountIds && !$branchId && $unassigned) {
            $sql .= " AND (l.account is null or l.account = 0)";
        }
        return $this->scalar($sql, 'average');
    }


    /**
     * Gets the total number of leads
     * @param $company
     * @param $start
     * @param $finish
     * @param null $accountId
     * @param null $branchId
     * @param bool $unassigned
     * @return mixed
     */
    public function totalMasterLeads($start, $finish, $accountIds = null, $branchId = null, $unassigned = false,$childCompanyIds = null)
    {
        $sql = "select count(l.leadId) as counter from leads l";
        if ($branchId != null) {
            $sql .= ' left join accounts a on a.accountId = l.account';
        }
        $sql .= " where (l.created between {$start} and {$finish}) ";

        if($childCompanyIds){
            $sql .= "and l.company IN(".implode(",",$childCompanyIds).") ";
        }

        if ($accountIds) {
            $sql .= " AND l.account IN(".implode(",",$accountIds).") ";
        }
        if ($branchId != null) {
            if ($branchId>0) {
                $sql .= " and a.branch = {$branchId}";
            }else{
                $sql .= " and (a.branch = 0 OR a.branch IS NULL) ";
            }
        }
        if (!$accountIds && !$branchId && $unassigned) {
            $sql .= " AND (l.account is null or l.account = 0)";
        }
        return $this->scalar($sql, 'counter');
    }

    /**
     * Get number of converted leads
     * @param $company
     * @param $start
     * @param $finish
     * @param null $accountId
     * @param null $branchId
     * @param bool $unassigned
     * @return mixed
     */
    public function leadsMasterActiveConverted($start, $finish, $accountIds = null, $branchId = null, $unassigned = false,$childCompanyIds = null)
    {
        $sql = "select count(l.leadId) as counter from leads l";
        if ($branchId != null) {
            $sql .= ' left join accounts a on a.accountId = l.account';
        }
        $sql .= " where (l.convertedTime between {$start} and {$finish}) and (l.created between {$start} and {$finish}) and l.status = 'Converted' ";

        if($childCompanyIds){
            $sql .= " and l.company IN(".implode(",",$childCompanyIds).") ";
        }

        if ($accountIds) {
            $sql .= " AND l.account IN(".implode(",",$accountIds).") ";
        }
        if ($branchId != null) {
            if ($branchId>0) {
                $sql .= " and a.branch = {$branchId}";
            }else{
                $sql .= " and (a.branch = 0 OR a.branch IS NULL) ";
            }
        }
        if (!$accountIds && !$branchId && $unassigned) {
            $sql .= " AND (l.account is null or l.account = 0)";
        }
        return $this->scalar($sql, 'counter');
    }

    public function leadsMasterAdded($start, $finish, $accountIds = null, $branchId = null,$childCompanyIds = null)
    {
        $sql = "select count(l.leadId) as counter from leads l";
        if ($branchId != null) {
            $sql .= ' left join accounts a on a.accountId = l.account';
        }
        $sql .= " where (l.created between {$start} and {$finish}) ";

        if($childCompanyIds){
            $sql .= " and l.company IN(".implode(",",$childCompanyIds).") ";
        }
        
        if ($accountIds) {
            $sql .= " AND l.account IN(".implode(",",$accountIds).") ";
        }
        if ($branchId != null) {
            if ($branchId>0) {
                $sql .= " and a.branch = {$branchId}";
            }else{
                $sql .= " and (a.branch = 0 OR a.branch IS NULL) ";
            }
        }

        return $this->scalar($sql, 'counter');
    }


    /**
     * Gets the number of active leads
     * @param $company
     * @param $start
     * @param $finish
     * @param null $accountId
     * @param null $branchId
     * @param bool $unassigned
     * @return mixed
     */
    public function leadsMasterActive($start, $finish, $accountIds = null, $branchId = null, $unassigned = false,$childCompanyIds = null)
    {
        
        $sql = "select count(l.leadId) as counter from leads l";
        if ($branchId != null) {
            $sql .= ' left join accounts a on a.accountId = l.account';
        }
        
        $sql .= " where (l.created between {$start} and {$finish}) and (l.status = 'Working' or l.status = 'Waiting for subs') ";

        if($childCompanyIds){
            $sql .= " and l.company IN(".implode(",",$childCompanyIds).") ";
        }

        if ($accountIds) {
            $sql .= " AND l.account IN(".implode(",",$accountIds).") ";
        }
        if ($branchId != null) {
            if ($branchId>0) {
                $sql .= " and a.branch = {$branchId}";
            }else{
                //$sql .= " and a.branch = {$branchId}";
                $sql .= " and (a.branch = 0 OR a.branch IS NULL) ";
            }
        }
        if (!$accountIds && !$branchId && $unassigned) {
            $sql .= " AND (l.account is null or l.account = 0)";
        }
        //echo $sql;die;
        return $this->scalar($sql, 'counter');
    }

    /**
     * Get number of converted leads
     * @param $company
     * @param $start
     * @param $finish
     * @param null $accountId
     * @param null $branchId
     * @param bool $unassigned
     * @return mixed
     */
    public function leadsMasterConverted($start, $finish, $accountIds = null, $branchId = null, $unassigned = false,$childCompanyIds = null)
    {
        $sql = "select count(l.leadId) as counter from leads l";
        if ($branchId != null) {
            $sql .= ' left join accounts a on a.accountId = l.account';
        }
        $sql .= " where (l.created between {$start} and {$finish}) and (l.convertedTime between {$start} and {$finish}) and l.status = 'Converted' ";

        if($childCompanyIds){
            $sql .= " and l.company IN(".implode(",",$childCompanyIds).") ";
        }

        if ($accountIds) {
            $sql .= " AND l.account IN(".implode(",",$accountIds).") ";
        }
        if ($branchId != null) {
            if ($branchId>0) {
                $sql .= " and a.branch = {$branchId}";
            }else{
                $sql .= " and (a.branch = 0 OR a.branch IS NULL) ";
            }
        }
        if (!$accountIds && !$branchId && $unassigned) {
            $sql .= " AND (l.account is null or l.account = 0)";
        }
        return $this->scalar($sql, 'counter');
    }

    /**
     * Gets the number of cancelled leads
     * @param $company
     * @param $start
     * @param $finish
     * @param null $accountId
     * @param null $branchId
     * @param bool $unassigned
     * @return mixed
     */
    public function leadsMasterCancelled($start, $finish, $accountIds = null, $branchId = null, $unassigned = false,$childCompanyIds = null)
    {
        $sql = "select count(l.leadId) as counter from leads l";
        if ($branchId != null) {
            $sql .= ' left join accounts a on a.accountId = l.account';
        }
        $sql .= " where (l.created between {$start} and {$finish}) and l.status = 'Cancelled' ";

        if($childCompanyIds){
            $sql .= " and l.company IN(".implode(",",$childCompanyIds).") ";
        }

        if ($accountIds) {
            $sql .= " AND l.account IN(".implode(",",$accountIds).") ";
        }
        if ($branchId != null) {
            if ($branchId>0) {
                $sql .= " and a.branch = {$branchId}";
            }else{
                $sql .= " and (a.branch = 0 OR a.branch IS NULL) ";
            }
        }
        if (!$accountIds && !$branchId && $unassigned) {
            $sql .= " AND (l.account is null or l.account = 0)";
        }
        return $this->scalar($sql, 'counter');
    }


    /**
     * Gets the number of new leads
     * @param $companyId
     * @param $start
     * @param $finish
     * @param null $accountId
     * @param null $branchId
     * @param bool $unassigned
     * @return mixed
     */
    public function leadsMasterNew($start, $finish, $accountIds = null, $branchId = null, $unassigned = false,$childCompanyIds = null)
    {
        $timeStamp = time() - (86400 * 2);
        $sql = "select count(l.leadId) as counter from leads l";
        if ($branchId != null) {
            $sql .= ' left join accounts a on a.accountId = l.account';
        }
        $sql .= " where l.created >= {$timeStamp} and (l.created between {$start} and {$finish}) and (l.status = 'Working' or l.status = 'Waiting for subs') ";

        if($childCompanyIds){
            $sql .= " and l.company IN(".implode(",",$childCompanyIds).") ";
        }
        
        if ($accountIds) {
            $sql .= " AND l.account IN(".implode(",",$accountIds).") ";
        }
        if ($branchId != null) {
            if ($branchId>0) {
                $sql .= " and a.branch = {$branchId}";
            }else{
                $sql .= " and (a.branch = 0 OR a.branch IS NULL) ";
            }
        }
        if (!$accountIds && !$branchId && $unassigned) {
            $sql .= " AND (l.account is null or l.account = 0)";
        }
        return $this->scalar($sql, 'counter');
    }

    /**
     * Gets the number of the company current leads
     * @param $company
     * @param $start
     * @param $finish
     * @param null $accountId
     * @param null $branchId
     * @param bool $unassigned
     * @return mixed
     */
    public function leadsMasterCurrent($start, $finish, $accountIds = null, $branchId = null, $unassigned = false,$childCompanyIds = null)
    {
        $timeStampMin = time() - (86400 * 7);
        $timeStampMax = time() - (86400 * 2);
        $sql = "select count(l.leadId) as counter from leads l";
        if ($branchId != null) {
            $sql .= ' left join accounts a on a.accountId = l.account';
        }
        $sql .= " where (l.created > {$timeStampMin} and l.created < {$timeStampMax}) and (l.created between {$start} and {$finish}) and (l.status = 'Working' or l.status = 'Waiting for subs') ";

        if($childCompanyIds){
            $sql .= " and l.company IN(".implode(",",$childCompanyIds).") ";
        }

        if ($accountIds) {
            $sql .= " AND l.account IN(".implode(",",$accountIds).") ";
        }
        if ($branchId != null) {
            if ($branchId>0) {
                $sql .= " and a.branch = {$branchId}";
            }else{
                $sql .= " and (a.branch = 0 OR a.branch IS NULL) ";
            }
        }
        if (!$accountIds && !$branchId && $unassigned) {
            $sql .= " AND (l.account is null or l.account = 0)";
        }
        return $this->scalar($sql, 'counter');
    }

    /**
     * Gets the number of old leads
     * @param $company
     * @param $start
     * @param $finish
     * @param null $accountId
     * @param null $branchId
     * @param bool $unassigned
     * @return mixed
     */
    public function leadsMasterOld($start, $finish, $accountIds = null, $branchId = null, $unassigned = false,$childCompanyIds = null)
    {
        $timeStamp = time() - (86400 * 7);
        $sql = "select count(l.leadId) as counter from leads l";
        if ($branchId != null) {
            $sql .= ' left join accounts a on a.accountId = l.account';
        }
        $sql .= " where l.created <= {$timeStamp} and (l.created between {$start} and {$finish}) and (l.status = 'Working' or l.status = 'Waiting for subs') ";

        if($childCompanyIds){
            $sql .= " and l.company IN(".implode(",",$childCompanyIds).") ";
        }

        if ($accountIds) {
            $sql .= " AND l.account IN(".implode(",",$accountIds).") ";
        }
        if ($branchId != null) {
            if ($branchId>0) {
                $sql .= " and a.branch = {$branchId}";
            }else{
                $sql .= " and (a.branch = 0 OR a.branch IS NULL) ";
            }
        }
        if (!$accountIds && !$branchId && $unassigned) {
            $sql .= " AND (l.account is null or l.account = 0)";
        }
        return $this->scalar($sql, 'counter');
    }

}