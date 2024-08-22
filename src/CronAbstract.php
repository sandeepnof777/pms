<?php
namespace Pms;

/**
 * Initializes a cron Task's Process
 * Class CronAbstract
 * @package Pms
 */
abstract class CronAbstract implements CronInterface
{
    /**
     * @var int
     */
    protected $startTime;
    /**
     * Used to set the max execution time of the cron process
     * @var int
     */
    protected $maxSeconds;

    /**
     * CronAbstract constructor.
     * Sets the max execution time and logs the
     */
    function __construct()
    {
        $this->startTime = time();
        $this->maxSeconds = 25;
    }

    /**
     * Checks if the max execution time of the current process
     * has taken longer than the allowed time, in order to break it programatically
     * @return bool
     */
    public function checkExecutionTime()
    {
        return ((time() - $this->startTime) > $this->maxSeconds);
    }
}