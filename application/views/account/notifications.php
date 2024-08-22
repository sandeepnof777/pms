<!--<div class="content-box">

    <div class="box-header centered clearfix">Create Event Reminder [beta]</div>

    <div class="box-content padded">
        <p class="clearfix">
        <form action="<?/*= site_url('account/addEvent') */?>" method="post" id="addReminder">
            <input type="text" name="name" id="name" placeholder="Name">
            <input type="text" name="text" id="text" placeholder="Text">
            <input type="text" name="eventDue" id="eventDue" placeholder="Due Date">
            <input type="submit" value="Add Reminder">
        </form>
        </p>
    </div>
    <div class="clearfix"></div>

</div>-->

<div class="content-box">

    <div class="box-header centered clearfix">Notifications</div>

    <div class="box-content padded">
        <p class="clearfix">
        <?php if ($account->isAdministrator(true)) {?>
            <a href="<?php echo site_url('proposals/status/delete-requests'); ?>" class="notification-button clearfix">
                <span class="notification-text">Proposal Deletes Requested</span>
                <span class="notification-number"><?php echo $deleteRequests; ?></span>
            </a>
        <?php } ?>
            <a href="<?php echo site_url('leads/group/filter/user/u'); ?>" class="notification-button clearfix">
                <span class="notification-text">Leads Unassigned</span>
                <span class="notification-number"><?php echo $unassignedLeads; ?></span>
            </a>
            <a href="<?php echo site_url('calendar'); ?>" class="notification-button clearfix">
                <span class="notification-text">Upcoming Events</span>
                <span class="notification-number"><?= $upcomingEventsCounter ?></span>
            </a>
        </p>
    </div>
    <div class="clearfix"></div>

</div>

<!--<script>
    $(document).ready(function () {
        $("#eventDue").datepicker({
            minDate: +1
        });
        $("#addReminder").on('submit', function () {
            if (!$("#name").val() || !$("#text").val() || !$("#eventDue").val()) {
                alert('All fields are required!');
                return false;
            }
        });
    });
</script>-->