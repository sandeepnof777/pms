<h3>
    Automatic Reminders
</h3>
<table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
    <thead>
    <tr>
        <td>Service</td>
        <td>Event</td>
        <td>Interval</td>
        <td>Notify</td>
    </tr>
    </thead>
    <tbody>
    <?php $k = 0;
    foreach ($serviceParents as $parent) {
        $k++; ?>
        <tr class="<?php echo ($k % 2) ? 'odd' : 'even' ?>">
            <td><?php echo $parent->serviceName ?></td>
            <td>
                <select name="event_<?php echo $parent->serviceId ?>" id="event_<?php echo $parent->serviceId ?>">
                    <option value="1">Proposal Sent</option>
                    <option value="1">Status changed to Won</option>
                    <option value="1">Status changed to Completed</option>
                </select>
            </td>
            <td>
                <select name="interval_<?php echo $parent->serviceId ?>" id="interval_<?php echo $parent->serviceId ?>">
                    <option value="0">No notification</option>
                    <option value="1">1 Month</option>
                    <option value="2">2 Months</option>
                    <option value="3">3 Months</option>
                    <option value="4">4 Months</option>
                    <option value="5">5 Months</option>
                    <option value="6">6 Months</option>
                    <option value="7">7 Months</option>
                    <option value="8">8 Months</option>
                    <option value="9">9 Months</option>
                    <option value="10">10 Months</option>
                    <option value="11">11 Months</option>
                    <option value="12">12 Months</option>
                </select>
            </td>
            <td>
                <select name="notify_<?php echo $parent->serviceId ?>" id="notify_<?php echo $parent->serviceId ?>">
                    <option value="0">Proposal Owner</option>
                    <option value="X">LIST</option>
                    <option value="Y">OF</option>
                    <option value="Z">Users</option>
                </select>
            </td>
        </tr>
    <?php } ?>
    </tbody>
</table>