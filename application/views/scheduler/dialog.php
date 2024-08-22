<div id="scheduler_dialog" title="Create Event" style="display: none;">
    <form action="<?php echo site_url('account/saveEvent') ?>" method="post" id="scheduleEventForm">
        <table class="boxed-table" width="100%" cellspacing="0" cellpadding="0">
            <tr class="even">
                <td style=" width: 150px; text-align: right; padding-right: 10px;">User</td>
                <td>
                    <select name="account" id="schedule-account">
                        <?php foreach ($event_accounts as $account): ?>
                            <option value="<?= $account->accountId ?>" <?= ($account->accountId == $currentAccountId) ? ' selected="selected"' : '' ?>><?= $account->firstName . ' ' . $account->lastName ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td style=" width: 150px; text-align: right; padding-right: 10px;">Type</td>
                <td>
                    <select name="type" id="schedule-type">
                        <?php foreach ($event_types as $event_type) : ?>
                            <option value="<?= $event_type->id ?>"><?= $event_type->name ?></option>
                        <?php endforeach ?>
                    </select>
                </td>
            </tr>
            <tr id="schedule-linkedToRow">
                <td style=" width: 150px; text-align: right; padding-right: 10px;" id="schedule-linkedTo"></td>
                <td id="schedule-linkedToName"></td>
            </tr>
            <tr class="odd">
                <td style=" width: 150px; text-align: right; padding-right: 10px;">Subject</td>
                <td><input type="text" name="name" id="schedule-name" class="text" placeholder="Event Name" style="width: 95%;"></td>
            </tr>
            <tr class="even">
                <td style=" width: 150px; text-align: right; padding-right: 10px; vertical-align: top;">Notes</td>
                <td><textarea name="text" id="schedule-text" style="width: 95%; height: 100px;" class="textarea" placeholder="Event Text"></textarea></td>
            </tr>
            <tr class="even">
                <td style=" width: 150px; text-align: right; padding-right: 10px;">Location</td>
                <td><input type="text" name="location" id="schedule-location" class="text" placeholder="Event Location" style="width: 95%;"></td>
            </tr>
            <tr class="odd">
                <td style=" width: 150px; text-align: right; padding-right: 10px;">Start Event</td>
                <td>
                    <input type="text" name="startDate" id="schedule-startDate" class="text" style="width: 90px;">
                    <input type="number" name="startTimeHr" min="1" max="12" id="schedule-startTimeHr" class="text" style="width: 50px;">
                    <input  type="tel" pattern="[0-9]*" name="startTimeMin" min="0" max="59" id="schedule-startTimeMin" class="text" style="width: 50px;">
                    <select name="startPeriod" id="schedule-startPeriod" class="dont-uniform" style="margin-top: 3px; color: #777;">
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                </td>
            </tr>
            <tr class="even">
                <td style=" width: 150px; text-align: right; padding-right: 10px;">End Event</td>
                <td>
                    <input type="text" name="endDate" id="schedule-endDate" class="text" style="width: 90px;">
                    <input type="number" name="endTimeHr" min="1" max="12" id="schedule-endTimeHr" class="text" style="width: 50px;">
                    <input  type="tel" pattern="[0-9]*" name="endTimeMin" min="0" max="59" id="schedule-endTimeMin" class="text" style="width: 50px;">
                    <select name="endPeriod" id="schedule-endPeriod" class="dont-uniform" style="margin-top: 3px; color: #777;">
                        <option value="AM">AM</option>
                        <option value="PM">PM</option>
                    </select>
                </td>
            </tr>
            <tr class="odd">
                <td style=" width: 150px; text-align: right; padding-right: 10px;">Reminder</td>
                <td>
                    <select name="reminderDuration" id="schedule-reminderDuration">
                        <option value="0">No Reminder</option>
                        <option value="1800">0.5 h before</option>
                        <option value="3600">1 h before</option>
                        <option value="7200">2 h before</option>
                        <option value="10800">3 h before</option>
                        <option value="14400">4 h before</option>
                    </select>
                </td>
            </tr>
            <tr class="even" id="schedule-deleteUi">
                <td style=" width: 150px; text-align: right; padding-right: 10px;">Actions</td>
                <td>
                    <input type="button" class="btn delete-button" id="schedule-event-delete" value="Delete">
                    <input type="button" class="btn delete-button" id="schedule-event-complete" value="Complete">
                    <input type="button" class="btn delete-button" id="schedule-event-uncomplete" value="Uncomplete" style="display: none">
                </td>
            </tr>
        </table>
        <input type="hidden" name="client" id="schedule-client">
        <input type="hidden" name="proposal" id="schedule-proposal">
        <input type="hidden" name="lead" id="schedule-lead">
        <input type="hidden" name="prospect" id="schedule-prospect">
        <input type="hidden" name="id" id="schedule-id">
        <input type="hidden" name="redirectRoute" id="schedule-redirectRoute" value="<?php echo $this->uri->uri_string() ?>">
    </form>
    <input type="hidden" name="currentAccountId" id="currentAccountId" value="<?= $currentAccountId ?>">
</div>

