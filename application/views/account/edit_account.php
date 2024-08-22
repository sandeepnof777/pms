<?php $this->load->view('global/header'); ?>
<div id="content" class="clearfix">
<div class="widthfix">
<div class="content-box">
    <div class="box-header">
        <?php if (help_box(51)) { ?>
            <div class="help right tiptip" title="Help"><?php help_box(51, true) ?></div>
        <?php } ?>
        Edit User [<?php echo $account->getEmail() ?>]
        <a class="box-action" href="<?php echo site_url('account/company_users') ?>">Back</a>
    </div>
    <div class="box-content">
        <?php echo form_open($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $account->getAccountId(), array('class' => 'form-validated', 'autocomplete' => 'off')) ?>
        <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
            <tr>
                <td width="50%">
                    <p class="clearfix">
                        <label>First Name <span>*</span></label>
                        <input tabindex="1" class="tiptip text required" type="text" title="Enter the user's First Name" name="firstName" id="firstName" value="<?php echo $account->getFirstName() ?>">
                    </p>
                </td>
                <td>
                    <p class="clearfix">
                        <label>Address <span>*</span></label>
                        <input tabindex="21" class="tiptip text required" type="text" title="Enter the user's Address" name="address" id="address" value="<?php echo $account->getAddress() ?>">
                    </p>
                </td>
            </tr>
            <tr class="even">
                <td>
                    <p class="clearfix">
                        <label>Last Name <span>*</span></label>
                        <input tabindex="2" class="tiptip text required" type="text" title="Enter the user's Last Name" name="lastName" id="lastName" value="<?php echo $account->getLastName() ?>">
                    </p>
                </td>
                <td>
                    <p class="clearfix">
                        <label>City <span>*</span></label>
                        <input tabindex="22" class="tiptip text required" type="text" title="Enter the user's City" name="city" id="city" value="<?php echo $account->getCity() ?>">
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="clearfix">
                        <label>Title <span>*</span></label>
                        <input tabindex="3" class="tiptip text required" type="text" title="Enter the user's Title" name="title" id="title" value="<?php echo $account->getTitle() ?>">
                    </p>
                </td>
                <td>
                    <p class="clearfix">
                        <label>State <span>*</span></label>
                        <input tabindex="23" class="tiptip text required" type="text" title="Enter the user's State" name="state" id="state" value="<?php echo $account->getState() ?>">
                    </p>
                </td>
            </tr>
            <tr class="even">
                <td>
                    <p class="clearfix">
                        <label>Email <span>*</span></label>
                        <input tabindex="4" class="tiptip text required email" type="text" title="Enter a valid email address" name="email" id="email" value="<?php echo $account->getEmail() ?>">
                    </p>
                </td>
                <td>
                    <p class="clearfix">
                        <label>Zip Code <span>*</span></label>
                        <input tabindex="24" class="tiptip text required" title="Enter the user's Zip Code" type="text" name="zip" id="zip" value="<?php echo $account->getZip() ?>">
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="clearfix">
                        <label>Password</label>
                        <input tabindex="5" class="tiptip text" title="Password (leave blank not to change)" type="password" name="password" id="password">
                    </p>
                </td>
                <td>
                    <!--<p class="clearfix">
                                <label>Country <span>*</span></label>
                                <input tabindex="25" class="tiptip text required" title="Enter the user's Country" type="text" name="country" id="country" value="<?php /*echo $account->getCountry() */?>">
                            </p>-->
                    <p class="clearfix">
                        <label>Time Zone <span>*</span></label>                                                                                 <?php echo form_dropdown('timeZone', array(
                            'EST' => 'Eastern Time',
                            'CST' => 'Central Time',
                            'MST' => 'Mountain Time',
                            'PST' => 'Pacific Time',
                        ), $account->getTimeZone(), ' tabindex="26"') ?>
                        <!--                                <input class="tiptip text required" type="text" title="Enter the user's Time Zone" name="timeZone" id="timeZone" value="--><?php //echo $account->getTimeZone() ?><!--">-->
                    </p>
                </td>
            </tr>
            <tr class="even">
                <td>
                    <p class="clearfix">
                        <label>Cell Phone <span>*</span></label>
                        <input tabindex="6" class="tiptip text required" type="text" title="Enter the user's Cell Phone" name="cellPhone" id="cellPhone" value="<?php echo $account->getCellPhone() ?>">
                    </p>
                </td>
                <td>
                    <p class="clearfix">
                        <?php if ($logged_account->isAdministrator(true) && !$account->isAdministrator()) {
                            ?>
                            <label>Full Access</label>
                            <?php
                            $options = array('no' => 'No', 'yes' => 'Yes');
                            echo form_dropdown('fullAccess', $options, $account->getFullAccess(), 'style="margin-top: 5px;" tabindex="27"');
                        } else {
                            ?>
                            <input type="hidden" name="fullAccess" value="<?php echo $account->getFullAccess() ?>">
                        <?php
                        }
                        ?>
                    </p>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="clearfix">
                        <label>Office Phone <span>*</span></label>
                        <input tabindex="7" class="tiptip text required" title="Enter the user's Office Phone" type="text" name="officePhone" id="officePhone" value="<?php echo $account->getOfficePhone() ?>">

                    </p>
                </td>
                <td>
                    <?php
                    if (!$account->isAdministrator(true) && ($logged_account->getAccountId() != $account->getAccountId())) {
                    ?>
                    <p class="clearfix">
                        <label>Disabled</label>
                        <select name="disabled" id="disabled">
                            <option value="0">No</option>
                            <option value="1" <?php if ($account->getDisabled()) echo 'selected="selected"'; ?>>Yes</option>
                        </select>
                    </p>
                    <?php } ?>
                </td>
            </tr>
            <tr>
                <td>
                    <p class="clearfix">
                        <label>Fax</label>
                        <input tabindex="8" class="tiptip text" title="Enter the user's Fax" type="text" name="fax" id="fax" value="<?php echo $account->getFax() ?>">
                    </p>
                </td>
                <td>
                    <p>* Leave Blank to use Company Fax</p>
                </td>
            </tr>
            <?php
            if (($logged_account->isAdministrator(true) && !$account->isAdministrator(true)) || ($logged_account->isGlobalAdministrator())) {
                ?>
                <tr class="even">
                    <td>
                        <?php
                        if (!$account->isAdministrator(true)) {
                            ?>
                            <label>Admin Privileges</label><?php
                            $options = array('0' => 'No', '1' => 'Yes');
                            echo form_dropdown('adminPrivileges', $options, $account->getAdminprivileges(), 'style="margin-top: 5px;" tabindex="8"');
                        }
                        ?>
                    </td>
                    <td>
                        <?php
                        if ($logged_account->isGlobalAdministrator()) {
                            ?>
                            <label>Expiration Date</label>
                            <input tabindex="28" type="text" name="expires" id="expires" style="width: 75px; text-align: center;" value="<?php echo date('n/j/Y', $account->getExpires()) ?>" class="text">
                        <?php
                        }
                        ?></td>
                </tr>
            <?php
            }
            ?>
            <tr class="">
                <td><label>&nbsp;</label><input tabindex="100" type="submit" value="Save" class="btn"></td>
                <td></td>
            </tr>
        </table>
        <?php echo form_close() ?>
    </div>
</div>

<div class="content-box" id="editAccountSignature">
    <div class="box-header">
        <?php if (help_box(52)) { ?>
            <div class="help right tiptip" title="Help"><?php help_box(52, true) ?></div>
        <?php } ?>
        Upload User Signature
    </div>
    <div class="box-content">
        <table width="100%" border="0" cellpadding="0" cellspacing="0" class="boxed-table">
            <tbody>
            <tr>
                <td valign="top">
                    <div class="padded">
                        <h4>Signature Instructions</h4>

                        <p>The image uploaded will have to be in <b>JPEG</b> or <b>PNG</b> format, with a maximum file size of 500kb. The image dimensions must be a rectangular shape, in a wide format. </p>
                        <p>Please see video above for extra tips</p>

                        <p style=""><a class="btn" href="/static/images/logo-instructions.jpg" id="launchInstructions">Click here for more instructions.</a></p>
                    </div>
                </td>
                <td valign="top" width="300">
                    <div class="padded">
                        <form id="changesig_form" action="<?php echo site_url('account/edit_account/' . $account->getAccountId()) ?>" method="post" enctype="multipart/form-data">
                            <p class="clearfix" STYLE="text-align: center;">
                                <b>Image File: </b><br>
                                <input type="file" name="clientLogo" id="clientLogo" class="required" style="float: none !important;">
                            </p>
                            <br>
                            <p class="clearfix" style="text-align: center;">
                                <input class="btn" name="changeSignature" id="changeSignature" type="submit" value="Upload Signature" style="float: none !important;">
                            </p>
                            <input type="hidden" name="change_signature" value="1">
                        </form>
                        <?php
                        if (file_exists(UPLOADPATH . '/clients/signatures/signature-' . $account->getAccountId() . '.jpg')) {
                            ?>
                            <h4 align="center">Current Signature:</h4>
                            <img style="width: 200px; height: auto; display: block; margin: 0 auto;" src="/uploads/clients/signatures/signature-<?php echo $account->getAccountId() ?>.jpg?<?php echo rand(100000, 999999) ?>" alt="">
                            <a style="display: block; text-align: center;" href="<?php echo site_url('account/edit_account/' . $account->getAccountId() . '/removeSignature') ?>">[Remove]</a>
                        <?php
                        }
                        ?>
                    </div>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

</div>
</div>
<div id="instructions" title="Logo Upload Instructions">
    <img src="/static/images/logo-instructions.jpg" alt="" style="margin: 0 auto;"/>
</div>
<script type="text/javascript">$(document).ready(function () {
        $("#expires").datepicker({
            dateFormat: 'm/d/yy'
        });
        $("#cellPhone").mask("999-999-9999");
        $("#officePhone").mask("999-999-9999");
        $("#fax").mask("999-999-9999");
        $("#changesig_form").submit(function () {
            $("#changeSignature").val('Uploading... Please wait');
        });
        $("#instructions").dialog({
            autoOpen: false,
            width: 500,
            height: 400
        });
        $("#launchInstructions").live('click', function () {
            $("#instructions").dialog('open');
            return false;
        });
    });
</script>
<!--#content-->
<?php $this->load->view('global/footer'); ?>







