<?php
namespace Pms\Repositories;

use Carbon\Carbon;
use models\Status;
use Pms\RepositoryAbstract;
use Pms\Traits\DBTrait;

class SalesTargets extends RepositoryAbstract
{
    use DBTrait;

    private $default_config = [
        'sales_target' => '2000000',
        'weeks_per_year' => '48',
        'win_rate' => '20',
    ];

    public function getConfig($companyId, $accountId = 0)
    {
        $config = $this->getConfigFromDB($companyId, $accountId);
        if (!$config) {
            $config = $this->createConfig($companyId, $accountId);
        }

        $config = array_merge($this->default_config, $config);
        $config['bid_target'] = $config['sales_target'] * (100 / $config['win_rate']);
        $config['bid_per_day'] = $config['bid_target'] / ($config['weeks_per_year'] * 5);
        $config['sales_per_day'] = $config['sales_target'] / ($config['weeks_per_year'] * 5);

        if (!isset($config['start_date']) && $accountId) {
            $acc = $this->em->findAccount($accountId);
            if ($acc) {
                $config['start_date'] = $acc->getCreated(false);
            }
        }
        $config['workday_ratio'] = ($config['weeks_per_year'] / 52);
        $config['bid_per_day_52'] = $config['bid_per_day'] * ($config['weeks_per_year'] / 52);

        return $config;
    }

    public function getConfigRaw($companyId, $accountId = 0)
    {
        $config = $this->getConfig($companyId, $accountId);
        unset($config['bid_target']);
        unset($config['bid_per_day']);
        unset($config['bid_per_day_52']);
        unset($config['workday_ratio']);
        return $config;
    }

    private function getConfigFromDB($companyId, $accountId = 0)
    {
        return $this->getSingleResult("select * from sales_targets where company_id = {$companyId} and account_id = {$accountId}", 'array');
    }

    /**
     * @param $companyId
     * " Basically an alias for the create config function which is private
     */
    public function createDefaultConfig($companyId)
    {
        $this->createConfig($companyId);
    }


    private function createConfig($companyId, $accountId = 0)
    {
        $config = [];
        $config = array_merge($this->default_config, $config);
        if ($accountId > 0) {
            $config = array_merge($config, $this->getConfigRaw($companyId));
        }
        $config['company_id'] = $companyId;
        $config['account_id'] = $accountId;
        unset($config['id']);
        unset($config['sales_per_day']);
        $this->insert('sales_targets', $config);
        return $config;
    }

    public function saveConfig($config, $companyId, $accountId = 0)
    {
        $dbConfig = $this->getConfigFromDB($companyId, $accountId);
        $config = array_merge($dbConfig, $config);
        unset($config['id']);
        $this->db->update('sales_targets', $config, ['company_id' => $companyId, 'account_id' => $accountId]);
        return true;
    }

    public function getUserStats(\models\Accounts $account, $from, $to)
    {
        $config = self::getConfig($account->getCompany()->getCompanyId(), $account->getAccountId());
        $start = new Carbon($from . ' 00:00:00');
        $startTime = $start->timestamp;

        if ($config['start_date'] > $startTime) {
            $startTime = $config['start_date'];
            $start = Carbon::createFromTimestamp($startTime);
            $start->startOfDay();
        }

        $end = new Carbon($to);
        $end->endOfDay();
        //$end->addDays(1);
        $endTime = $end->timestamp;
        $weekdays = $start->diffInWeekdays($end);
        if ($weekdays < 1) {
            $weekdays = 1;
        }
        $time = [
            'start' => $startTime,
            'finish' => ($endTime) ? $endTime : '999999999999'
        ];

        $totalBid = $account->getRangeCreatedProposalsPrice($time);
        $totalProposals = $account->getRangePricedCreatedProposals($time, true);
        $openStatus = $account->getCompany()->getOpenStatus();
        $totalOpenProposal = $account->getRangeCreatedProposalsStatusPrice($time,$openStatus->getStatusId());
        $totalOtherProposal = $account->getOtherSalesValue($time);
        
        // Sold proposals based on time period
        $wonCompletedValue = (int)$account->getSalesValue($time);
        $rolloverSales = (int)$account->getSalesValueRollover($time);
        $wonValue = (int)$account->getSalesValueCreated($time);
        
        $stats = [
            'user' => $account->getFullName(),
            'total_bid' => $totalBid,
            'avg_bid_wk' => (($totalBid / $weekdays) * 5),
            'sales_per_day' => ($totalBid / $weekdays),
            'win_rate' => (float)$totalBid ? (($wonValue / $totalBid) * 100) : 0,
            'avg_bids' => $totalProposals ? (($totalProposals / $weekdays) * 5) : 0,
            'totalProposals' => $totalProposals,
            'wonCompletedProposals' => $wonCompletedValue,
            'rangeRollover' => $rolloverSales,
            'weekdaysDifference' => $weekdays,
            'totalOpen' => $totalOpenProposal,
            'totalOtherProposal' => $totalOtherProposal,
            
        ];

        return $stats;
    }

    public function isEnabled($companyId)
    {
        $config = $this->getConfig($companyId);
        return ($config['enabled']);
    }

}