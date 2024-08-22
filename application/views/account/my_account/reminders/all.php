<div class="clearfix" style="padding: 20px">
    <a href="#" class="btn update-button" id="addNewEvent" data-account="<?= $account->getAccountId() ?>">Add New Event</a> <br><br>
    <div id="calendar">

    </div>
</div>
<p>&nbsp;</p>
<h3>List (just for reference)</h3>
<p>&nbsp;</p>
<table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
        <td>Event Type</td>
        <td>User</td>
        <td>Name</td>
        <td>Text</td>
        <td>Start</td>
        <td>End</td>
        <td>Completed</td>
        <td>Reminder</td>
        <td>Reminder Sent</td>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($events as $event): ?>
        <tr>
            <td style="<?= ((isset($event_types[$event->type]))) ? 'color: ' . $event_types[$event->type]->backgroundColor . ';' : '' ?>">
                <strong><?= (isset($event_types[$event->type])) ? $event_types[$event->type]->name : 'No type defined!' ?></strong>
            </td>
            <td><?= (isset($accounts[$event->account])) ? $accounts[$event->account]->firstName . ' ' . $accounts[$event->account]->lastName : 'No user!' ?></td>
            <td><?= $event->name ?></td>
            <td><?= $event->text ?></td>
            <td><?= date('m/d/Y H:i:s', $event->startTime) ?></td>
            <td><?= date('m/d/Y H:i:s', $event->endTime) ?></td>
            <td><?= ($event->eventCompleteTime) ? (date('m/d/Y H:i:s', $event->eventCompleteTime)) : 'Not Completed' ?></td>
            <td><?= ($event->reminderTime) ? (date('m/d/Y H:i:s', $event->reminderTime)) : 'No Reminder' ?></td>
            <td><?= ($event->reminderSentTime) ? (date('m/d/Y H:i:s', $event->reminderSentTime)) : 'Not sent' ?></td>
        </tr>
    <?php endforeach ?>
    </tbody>
</table>

<script>
    $(document).ready(function () {
        $('#calendar').fullCalendar({
            header: {
                left: 'prev,next today',
                center: 'title',
                right: 'listWeek,agendaDay,agendaWeek,month'
//                right: 'listWeek'
            },
            theme: true,
            allDayDefault: false,
            defaultView: 'listWeek',
            events: {
                url: '<?= site_url('account/getEvents') ?>',
                type: 'POST',
                dataType: 'JSON',
                error: function () {
                    alert('there was an error while fetching events!');
                }
            },
            eventClick: function (calEvent, jsEvent, view) {
                editScheduledEvent(calEvent.id);
            },
            viewRender: function (view, element) {

            }
        });
    });
</script>