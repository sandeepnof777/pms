<?php
namespace Pms\Cron;

use Pms\CronInterface;
use Pms\Traits\RepositoryTrait;

class CalendarSync implements CronInterface
{
    use RepositoryTrait;

    public function run()
    {
        $start = microtime(true);
        set_time_limit(90);
        $this->syncEvents(10);
        $this->deleteGoogleEvents(10);
        $this->pullFromGoogle(10);
        echo '<br>Done! Time to execute: ' . abs(round((microtime(true) - $start), 2)) . ' seconds';
    }

    public function syncEvents($limit)
    {
        ?><h3>Syncing Events</h3><?php
        $events = $this->getEventRepository()->getEventsToSync($limit);
        foreach ($events as $event) {
            echo "Syncing Event # {$event->id}...";
            if ($this->getGoogleAuthRepository($event->account)->syncEvent($event->id, $event->google_event_id)) {
                echo 'Success!';
            } else {
                echo 'Fail!';
            }
            echo '<br>';
        }
        echo 'Done!<br>';
    }

    public function deleteGoogleEvents($limit)
    {
        ?><h3>Deleting Orphan Events</h3><?php
        $eventsToBeDeleted = $this->getEventRepository()->getSyncedEventsToDelete($limit);
        foreach ($eventsToBeDeleted as $eventSyncData) {
            echo "Deleted event with google event id: {$eventSyncData->google_event_id}";
            try {
                $this->getGoogleAuthRepository($eventSyncData->account)->deleteEvent($eventSyncData->google_event_id);
            }
            catch (\Exception $e) {
                echo 'Fail!';
            }
            echo '<br>';
        }
        echo 'Done!<br>';
    }

    public function pullFromGoogle($limit)
    {
        ?>
        <h3>Pulling from google</h3>
        <?php
        $synced = $this->getEventRepository()->syncFromGoogle($limit);
        echo "Done! Synced {$synced} event(s).";
    }
}