<!-- add a back button  -->
<h3>
    &nbsp;
    <!-- <a href="<?php echo site_url('account/my_account') ?>">Back</a> -->
</h3>

<p style="padding: 20px;">Set the default amount for users requiring bid approval.</p>

<form action="<?php echo site_url('account/bid_approval') ?>" method="post" class="form-validated">
    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="boxed-table">
        <tr>
            <td width="80%">
                <p class="clearfix">
                    <label style="width: 200px !important;">Default Bid Approval Limit</label>
                    <input type="text" name="defaultBidApproval" class="text field-priceFormat"
                           value="$<?php echo number_format($defaultBidApproval); ?>" />
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <button type="submit" class="btn blue" name="submitDefaultBidApproval" value="1" style="margin-left: 30px;">Save</button>
            </td>
        </tr>
    </table>
</form>