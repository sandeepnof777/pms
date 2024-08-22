
<!-- add a back button  -->
<h3>
&nbsp;
<!-- <a href="<?php echo site_url('account/my_account/proposal_settings') ?>">Back</a> -->
</h3>
<form action="<?php echo site_url('account/company_proposal_settings4') ?>" method="post" class="form-validated">


    <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td class="text-right">Use Automatic Job Numbering</td>
                <td><input type="checkbox" name="useAutoNumber"<?php echo $account->getCompany()->getUseAutoNum() ? ' checked="checked"' : ''; ?> /></td>
            </tr>
            <tr>
                <td class="text-right">Auto Number Prefix</td>
                <td>
                    <input type="text" size="6" class="text" name="autoNumberPrefix" value="<?php echo $account->getCompany()->getAutoNumPrefix(); ?>" />
                    <p style="display: inline; float: left; padding-top: 5px;">Use a numbers, letters or symbols</p>
                </td>
            </tr>
            <tr>
                <td class="text-right">Auto Number Value</td>
                <td>
                    <input type="text" size="6" class="number text" name="autoNumberValue" value="<?php echo $account->getCompany()->getAutoNum(); ?>" />
                    <p style="display: inline; float: left; padding-top: 5px;">Use a number only</p>
                </td>
            </tr>
            <tr>
                <td class="text-right"></td>
                <td><input type="submit" name="save" class="btn blue ui-button" value="Save" /></td>
            </tr>
        </tbody>
    </table>

</form>