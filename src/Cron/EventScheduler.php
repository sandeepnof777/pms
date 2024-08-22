<?php
namespace Pms\Cron;

use Pms\CronInterface;
use Pms\Traits\RepositoryTrait;

class EventScheduler implements CronInterface
{
    use RepositoryTrait;

    public function run()
    {
        $this->getEventRepository()->scheduleDueEvents();
    }
}