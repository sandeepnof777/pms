<h3>
    <?php echo $title; ?>
    <a href="<?php echo site_url('account/company_workorder') ?>">Back</a>
</h3>
<form action="#" method="post" class="form-validated">
    <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
        <tbody>
        <tr class="even">
            <td>
                <p class="clearfix">
                    <label>Address</label>
                    <input tabindex="11" type="text" name="address" id="address" class="trackChanges text tiptip required" title="Enter work order street address" value="<?php echo (isset($woa)) ? $woa->getAddress() : ''; ?>">
                </p>
            </td>
            <td>
                <p class="clearfix">
                    <label>State</label>
                    <input tabindex="13" type="text" name="state" id="state" class="trackChanges text tiptip required" title="Enter work order state" value="<?php echo (isset($woa)) ? $woa->getState() : ''; ?>">
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="clearfix">
                    <label>City </label>
                    <input tabindex="12" type="text" name="city" id="city" class="trackChanges text tiptip required" title="Enter work order city" value="<?php echo (isset($woa)) ? $woa->getCity() : ''; ?>">
                </p>
            </td>
            <td>
                <p class="clearfix">
                    <label>Zip </label>
                    <input tabindex="14" type="text" name="zip" id="zip" class="trackChanges text tiptip required" title="Enter work order zip code" value="<?php echo (isset($woa)) ? $woa->getZip() : ''; ?>">
                </p>
            </td>
        </tr>
        <tr class="even">
            <td>
                <label>&nbsp;</label>
                <input type="submit" class="btn blue" name="save" value="Save"/>
            </td>
            <td>&nbsp;</td>
        </tr>
        </tbody>
    </table>
</form>