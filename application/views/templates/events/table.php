<div id="events-filter" class="clearfix">
    <select name="eventFilterType" id="eventFilterType">
        <option value="0">All Types</option>
        <?php foreach ($event_types as $type): ?>
            <option value="<?= $type->id ?>"><?= $type->name ?></option>
        <?php endforeach; ?>
    </select>
    <select name="eventFilterBy" id="eventFilterBy">
        <option value="upcoming">Upcoming</option>
        <option value="all">All</option>
        <option value="completed">Completed</option>
    </select>
    <?php if (!$account->isUser()): ?>
        <select name="eventFilterUser" id="eventFilterUser">
            <option value="0">All Users</option>
            <?php
                if(isset($filterAccounts)){
                    foreach ($filterAccounts as $filterAccount): ?>
                <option value="<?= $filterAccount->getAccountId(); ?>"><?= $filterAccount->getFullName(); ?></option>
            <?php endforeach; 
                }
            ?>
        </select>
    <?php endif; ?>
</div>
<div style="">
    <table class="boxed-table eventTable" width="100%" cellpadding="0" cellspacing="0">
        <thead>
        <tr>
            <td>Date Int</td>
            <td>Date</td>
            <td>Type</td>
            <td>User</td>
            <td>Name</td>
            <td>Text</td>
            <td>Status</td>
            <td style="width: 150px;">Actions</td>
        </tr>
        </thead>
        <tbody>
        <?php
        if (count($events)):
            foreach ($events as $event):
                /* @var $event \models\Event */
                $classes = ' type-' . $event->getType()->getId();
                if ($event->getStartTime() < time()) {
                    $status = 'Overdue';
                } else if ($event->getStartTime() >= time() && $event->getStartTime() <= (time() + (86400 * 7))) {
                    $classes .= ' upcoming';
                    $status = 'Upcoming';
                } else {
                    $classes .= ' upcoming';
                    $status = 'Scheduled';
                }

                if ($event->getEventCompleteTime()) {
                    $classes .= ' eventComplete';
                    $classes .= ' completed';
                    $status = 'Completed';
                }
                $classes .= ' user-' . $event->getAccount()->getAccountId();
                ?>
                <tr class="existingEvent <?= $classes ?>" data-id="<?= $event->getId() ?>">
                    <td><?= $event->getStartTime(); ?></td>
                    <td><?= $event->getStartTime(true); ?></td>
                    <td style="<?= ($event->getType()) ? 'color: ' . $event->getType()->getBackgroundColor() . ';' : '' ?>">
                        <strong><?= ($event->getType()->getName()) ?: ''; ?></strong>
                    </td>
                    <td><?= ($event->getAccount()) ? $event->getAccount()->getInitials(true) : '' ?></td>
                    <td><?= $event->getName(); ?></td>
                    <td><?= (strlen($event->getText()) < 120) ? $event->getText() : substr($event->getText(), 0, 120) . '...'; ?></td>
                    <td><?= $status; ?></td>
                    <td>
                        <?php if ($event->getEventCompleteTime()): ?>
                            <a class="btn btn-disabled tiptip schedule-event-uncomplete" title="Uncomplete Event">&nbsp;</a>
                        <?php else: ?>
                            <a class="btn btn-enabled tiptip schedule-event-complete" title="Complete Event">&nbsp;</a>
                        <?php endif; ?>
                        <a class="btn btn-edit tiptip schedule-event-edit" title="Edit Event">&nbsp;</a>
                        <a class="btn btn-delete tiptip schedule-event-delete" data-id="<?= $event->getId() ?>" title="Delete Event">&nbsp;</a>
                        <a href="<?= site_url('calendar/agendaDay/' . date('Ymd', $event->getStartTime())) ?>" class="btn btn-calendar tiptip" title="Calendar">&nbsp;</a>
                    </td>
                </tr>
            <?php endforeach;
        endif; ?>
        </tbody>
    </table>
</div>

<script type="text/javascript">

    $(document).ready(function () {

        // For handling filters when displayed
        function filterEvents() {

            $('tr.existingEvent').hide();

            // Filter on event type
            var typeId = $("#eventFilterType").val();

            if (typeId > 0) {
                var typeClass = 'type-' + typeId;
                $("tr.existingEvent." + typeClass).show();
            }
            else {
                $('tr.existingEvent').show();
            }

            // Filter on upcoming
            var rangeId = $("#eventFilterBy").val();

            if (rangeId != 'all') {
                $("tr.existingEvent:not('." + rangeId + "')").hide();
            }

            // Filter on User
            var userId = $("#eventFilterUser").val();

            if (userId > 0) {
                var userClass = 'user-' + userId;
                $("tr.existingEvent:not('." + userClass + "')").hide();
            }
        }

        filterEvents();
        $("#eventFilterBy, #eventFilterType, #eventFilterUser").on('change', function () {
            filterEvents();
        });

        $(".eventTable").dataTable({
            "bProcessing": true,
            "aoColumns": [
                {"bVisible": false},
                {"iDataSort": 0},
                null,
                {"sType": "html", "bSearchable": "true"},
                null,
                null,
                null,
                null
            ],
            "aaSorting": [
                [1, "desc"]
            ],
            "bJQueryUI": true,
            "bAutoWidth": true,
            "bStateSave": false,
            "sPaginationType": "full_numbers", "sDom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop">fl>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"pir>',
            "aLengthMenu": [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            "sDom": '<"H"lfr>t<"F"p>'
        });

    });

</script>