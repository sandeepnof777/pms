<?php
namespace Pms\Cron;

use Pms\CronInterface;
use Pms\Repositories\LeadNotifications;

/**
 * Checks for
 * Class LeadNotificationsCron
 * @package Pms\Cron
 */
class LeadNotificationsCron implements CronInterface
{
    var $hour;

    public function __construct()
    {
        $this->hour = date('H');
    }

    /**
     * Sets the hour the cron runs at (used for debug)
     * @param $hour
     * @return $this
     */
    public function setHour($hour)
    {
        $this->hour = $hour;
        return $this;
    }

    /**
     * Cron run function
     */
    public function run()
    {
        $call = [
            //11am mappings
            '11' => [11, 'EST'],
            '12' => [11, 'CST'],
            '13' => [11, 'MST'],
            '14' => [11, 'PST'],
            //3pm mappings
            '15' => [15, 'EST'],
            '16' => [15, 'CST'],
            '17' => [15, 'MST'],
            '18' => [15, 'PST'],
            //7pm mappings
            '19' => [19, 'EST'],
            '20' => [19, 'CST'],
            '21' => [19, 'MST'],
            '22' => [19, 'PST'],
        ];
        $leadNotificationRepository = new LeadNotifications();
        if (isset($call[$this->hour])) {
            $leadNotificationRepository->sendDailyNotifications($call[$this->hour][0], $call[$this->hour][1]);
            echo 'Done! Notifications sent.';
        } else {
            echo 'No notifications set up for this time.';
        }
    }
}