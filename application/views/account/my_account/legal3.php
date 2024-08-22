<!-- add a back button  -->
<h3>
&nbsp;
<!-- <a href="<?php echo site_url('account/my_account') ?>">Back</a> -->
</h3>
<form action="<?php echo site_url('account/company_legal3') ?>" method="post" class="form-validated">
    <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
        <tbody>
        <tr>
            <td>
                <label>Default Days</label>
                <input tabindex="100" style="width: 30px;" type="text" name="paymentTerm" id="paymentTerm" class="text trackChanges required tiptip" title="Enter the default number of days for the Payment Term" value="<?php echo $company->getPaymentTerm() ?>">
            </td>
        </tr>
        <tr class="even">
            <td>
                <input type="submit" class="btn blue" name="save" value="Save"/>
            </td>
        </tr>
        </tbody>
    </table>
</form>