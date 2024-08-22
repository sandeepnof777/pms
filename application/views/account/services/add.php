
<div class="content-box" id="add-service">
    <div class="box-header">
        Add Service
        <a href="<?php echo site_url('account/company_services') ?>" class="box-action tiptip" title="Go Back">Back</a>
    </div>
    <div class="box-content">
        <form autocomplete="off" class="form-validated" accept-charset="utf-8" method="post" action="<?php echo site_url('account/services') ?>">
            <table width="100%" cellspacing="0" cellpadding="0" class="boxed-table">
                <tbody>
                <tr>
                    <td width="50%">
                        <p class="clearfix left">
                            <label>Parent</label>
                            <select name="parent" id="parent">
                                <?php
                                foreach ($categories as $cat) {
                                    ?>
                                    <option value="<?php echo $cat->getServiceId() ?>"><?php echo $cat->getServiceName() ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </p>
                    </td>
                </tr>
                <tr class="even">
                    <td>
                        <p class="clearfix left">
                            <label>Service Name <span>*</span></label>
                            <input type="text" value="" id="serviceName" name="serviceName" class="text required" tabindex="2">
                        </p>
                    </td>
                </tr>
                <tr class="">
                    <td>
                        <label>&nbsp;</label><input type="submit" class="btn ui-button ui-widget ui-state-default ui-corner-all" value="Add Service" tabindex="28" role="button" aria-disabled="false" name="add_service">
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>