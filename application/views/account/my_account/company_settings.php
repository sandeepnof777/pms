<h3>Proposal Signature Status</h3>
<?php //var_dump($company_settings) ?>
<form action="<?php echo site_url('account/save_company_settings') ?>" method="post" class="form-validated">
    <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
        <tbody>
        <tr class="even">
            <td>
                <label for="status">Status</label>
                <select name="status" id="status">
                <?php foreach($statuses as $status) { ?>
                <option value="<?php echo $status->getStatusId(); ?>" <?php if($savedStatus == $status->getStatusId()){ echo "selected"; } ?>><?php echo $status->getText(); ?></option>
                <?php } ?>
                </select>
            </td>
        </tr>
        
        <tr class="odd">
            <td>
               
                <p><strong>Note: </strong> After proposal signed by Client Proposal status will be changed. </p>
            </td>
        </tr>
        <tr class="even">
            <td>
                <input type="submit" class="btn blue" name="saveStatus" value="Save"/>
            </td>
        </tr>
        </tbody>
    </table>
    <input type="hidden" name="company" value="<?php echo $company->getCompanyId() ?>">
</form>
