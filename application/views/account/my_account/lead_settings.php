
<?php //var_dump($notification_settings) ?>
<form action="<?php echo site_url('account/lead_settings') ?>" method="post" class="form-validated">
    <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
        <tbody>
        <tr class="even">
            <td>
                <label for="enabled">Enabled</label>
                <select name="enabled" id="enabled">
                    <option value="0" <?php echo (!@$notification_settings->enabled) ? ' selected="selected"' : '' ?>>No</option>
                    <option value="1" <?php echo (@$notification_settings->enabled) ? ' selected="selected"' : '' ?>>Yes</option>
                </select>
            </td>
        </tr>
        <tr class="odd">
            <td>
                <label for="account">Notification Receiver</label>
                <select name="account" id="account">
                    <option value="0">No User</option>
                    <?php foreach ($accounts as $account): ?>
                        <?php if ($account->isAdministrator()): ?>
                            <option <?php echo (@$notification_settings->account == $account->getAccountId()) ? ' selected="selected"' : '' ?> value="<?php echo $account->getAccountId() ?>"><?php echo $account->getFullName() . ' [' . $account->getTimeZone() . ']' ?></option>
                        <?php endif; ?>
                    <?php endforeach ?>
                </select>
            </td>
        </tr>
        <tr class="even">
            <td>
                <label for="instant">Instant Notification</label>
                <select name="instant" id="instant">
                    <option value="0">Disabled</option>
                    <option value="1" <?php echo (@$notification_settings->instant) ? ' selected="selected"' : '' ?>>Enabled</option>
                </select>
            </td>
        </tr>
        <tr class="odd">
            <td>
                <label>Daily Notifications</label>
                <?php $selected_intervals = explode('|', @$notification_settings->notificationIntervals); ?>
                <?php foreach ($intervals as $interval_name => $interval): ?>
                    <label for="interval_<?php echo $interval_name ?>" style="text-align: left; width: 65px;">
                        <?php echo strtoupper($interval_name) ?>
                        <input type="checkbox" name="intervals[]" id="interval_<?php echo $interval_name; ?>" value="<?php echo $interval ?>" <?php echo (in_array($interval, $selected_intervals)) ? 'checked="checked"' : '' ?>>
                    </label>
                <?php endforeach; ?>
            </td>
        </tr>
        <tr class="even">
            <td>
                <p>The <strong>notification receiver</strong> will automatically be notified about unassigned leads.</p>
                <p>When the <strong>instant notification</strong> setting is enabled, the user will also receive an instant email whenever a new lead is added as "Not Assigned". </p>
                <p><strong>Daily notifications</strong> are sent at selected times via email every weekday with a list of leads that have to be assigned, so you don't lose potential clients!</p>
            </td>
        </tr>
        <tr class="odd">
            <td>
                <input type="submit" class="btn blue" name="save" value="Save"/>
            </td>
        </tr>
        </tbody>
    </table>
    <input type="hidden" name="company" value="<?php echo $company->getCompanyId() ?>">
</form>
