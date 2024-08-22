<?php
namespace Pms\Cron;

use Pms\CronInterface;
use Pms\Traits\RepositoryTrait;

/**
 * Cleans up old (90 days +) cancelled leads from the system
 * Class LeadCleanup
 * @package Pms\Cron
 */
class LeadCleanup implements CronInterface
{
    use RepositoryTrait;

    public function run()
    {
        $this->getLeadRepository()->deleteOldLeads();
    }
}