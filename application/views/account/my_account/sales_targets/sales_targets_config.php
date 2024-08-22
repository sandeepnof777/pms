<table class="boxed-table" width="100%" cellspacing="0" cellpadding="0">
    <thead>
    <tr>
        <td width="140" style="text-align: right">Setting</td>
        <td width="100" style="text-align: left;">Value</td>
        <td style="text-align: left;">Description</td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td align="right"><strong>Enabled</strong></td>
        <td>
            <select name="enabled" id="enabled">
                <option value="1" <?= ($config['enabled']) ? 'selected="selected"' : '' ?>>Yes</option>
                <option value="0" <?= (!$config['enabled']) ? 'selected="selected"' : '' ?>>No</option>
            </select>
        </td>
        <td></td>
    </tr>
    <tr>
        <td align="right"><strong>Win Rate</strong></td>
        <td><input type="text" style="width: 90px; margin-right: 0;" class="text percentInput" id="win_rate" value="<?= $config['win_rate'] ?>%"></td>
        <td>Win rate, percentage</td>
    </tr>
    <tr>
        <td align="right"><strong>Sales Target</strong></td>
        <td><input type="text" style="width: 90px; margin-right: 0;" class="text" id="sales_target" value="<?= $config['sales_target'] ?>"></td>
        <td>Total bid in dollars</td>
    </tr>
    <tr>
        <td align="right"><strong>Weeks Per Year</strong></td>
        <td><input type="text" style="width: 90px; margin-right: 0;" class="text" id="weeks_per_year" value="<?= $config['weeks_per_year'] ?>"></td>
        <td>Number of weeks per year your company operates</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
        <td colspan="2">
            <input value="Save" id="saveConfig" class="btn blue ui-button ui-widget ui-state-default ui-corner-all" tabindex="200" style="margin-right: 5px;" role="button" aria-disabled="false" type="submit">
        </td>
    </tr>
    </tbody>
</table>