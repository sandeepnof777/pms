<!-- add a back button  -->
<h3>
&nbsp;
<!-- <a href="<?php echo site_url('account/my_account/proposal_settings') ?>">Back</a> -->
</h3> 
 
<h3>Proposal Automatic Re-Send</h3>
<?php //var_dump($notification_settings) ?>
<form action="<?php echo site_url('account/company_proposal_notifications') ?>" method="post" class="form-validated">
    <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
        <tbody>
        <tr class="even">
            <td>
                <label for="enabled">Enabled</label>
                <select name="enabled" id="enabled">
                    <option value="0" <?php echo (!@$resend_settings->enabled) ? ' selected="selected"' : '' ?>>No</option>
                    <option value="1" <?php echo (@$resend_settings->enabled) ? ' selected="selected"' : '' ?>>Yes</option>
                </select>
            </td>
        </tr>
        <tr class="odd">
            <td>
                <label for="frequency">Frequency: Every</label>
                <input type="text" name="frequency" id="frequency" value="<?= ((@$resend_settings->frequency / 86400) >= 1) ? (round(@$resend_settings->frequency / 86400)) : 1  ?>" class="text" style="width: 20px;">
                <label style="text-align: left;">Days</label>
            </td>
        </tr>
        <tr class="even">
            <td>
                <label>Email Template</label>
                <select name="template" id="template">
                    <?php foreach ($proposal_email_templates as $template): /** @var $template models\ClientEmailTemplate */ ?>
                        <option <?php echo (@$resend_settings->template == $template->getTemplateId()) ? ' selected="selected"' : '' ?> value="<?= $template->getTemplateId() ?>"><?= $template->getTemplateName() ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr class="even">
            <td>
                <label>Proposal Statuses</label>
                <div class="right" style="width: 620px;">
                    <?php
                    foreach ($statuses as $status) {
                        /** @var $status \models\Status */
                        ?>
                    <label for="status_<?= $status->getStatusId() ?>" style="text-align: left; width: auto;">
                        <?= $status->getText() ?>
                        <input type="checkbox" name="statuses[]" id="status_<?= $status->getStatusId() ?>" value="<?= $status->getStatusId() ?>" <?php echo (in_array($status->getStatusId(), $selected_statuses)) ? 'checked="checked"' : '' ?>>
                        </label><?php
                    }
                    ?>
                </div>
            </td>
        </tr>
        <tr class="odd">
            <td>
                <label>Re-Send Time</label>
                <select name="resend_time" id="resend_time">
                    <?php foreach ($resend_times as $time => $label): ?>
                        <option <?php echo (@$resend_settings->resend_time == $time) ? ' selected="selected"' : '' ?> value="<?= $time ?>"><?= $label ?></option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>
        <tr class="even">
            <td>
                <p>When the <strong>automatic re-send</strong> is enabled, the contact will receive the proposal at the selected frequency and time to any proposals of the selected statuses and have the option enabled.</p><br />
                <p><strong>Caution: </strong> Even if you enable the setting to a certain proposal but you don't send it out initially, the settings won't take effect. </p>
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
