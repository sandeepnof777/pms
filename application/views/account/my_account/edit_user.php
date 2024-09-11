<?php /* @var $user \models\Accounts */ ?>
<style>
     /* Custom styles for OTP Dialog */
#otp-verification-dialog {
    padding: 20px;
}

#otp-verification-dialog .ui-dialog-title {
    font-size: 1.5em;
    font-weight: bold;
}

#otp-verification-dialog .form-group {
    margin-top: 15px;
}

#otp-label {
    font-weight: bold;
    margin-bottom: 5px;
}

#otp-input {
    /* width: 100%;
    padding: 10px;
    border-radius: 4px;
    border: 1px solid #ccc;
    box-sizing: border-box; */
    border: 1px solid #ddd;
    border-radius: 2px 2px 2px 2px;
    box-shadow: 0 0 2px rgba(0, 0, 0, 0.1) inset;
    -moz-box-shadow: 0 0 2px rgba(0, 0, 0, 0.1) inset;
    color: #777777;
    padding: 5px;
}

#verify-btn {
    width: 100%;
    padding: 10px;
    font-size: 1.2em;
    border-radius: 4px;
    border: none;
    background-color: #25AAE1!important; /* Blue background color */
    color: #fff!important;/* White text color */
    cursor: pointer;
    margin-top:8px;
 }

 #otp-verification-dialog p
 {
    font-size:14px;
    font-family: Arial, Helvetica, sans-serif!important;
    color:#444444;
    line-height: 1.8;
 }

 #otpResend {
    position: relative;
    z-index: 9999;
    background-color: #25AAE1;
    color:white!important;

}
#otpResend a {
    pointer-events: auto;
}
 
.radio-option {
        display: flex;
        align-items: center;
         margin-left:15px;

    }

    .radio-option label {
        margin-left: 10px; /* Space between the radio button and label */
        min-width: 190px; /* Ensures labels align consistently */
    }

    .boxed-table label {
     text-align: left!important; 
 }

 div.error, div.success{
 
    width: 300px!important;
    margin-left:5px!important;
}
 .Otp_box label{
    width: unset !important;
 }

 .Otp_box input.text{
    width: unset !important;
 }
 .send_varification_code  #otpResend:hover,
#otpResend:focus {
  background-color: #25AAE1 !important;
  background: #25AAE1!important;
  color:white!important;
}

 
    </style>
<h3>
    Editing User - <?php echo $user->getFirstName() . ' ' . $user->getLastName() ?>
    <a href="<?php echo site_url('account/company_users') ?>">Back</a>
    <?php if ($user->getSecretary()) { ?>
        <span style="color: red;">(Limited User)</span>
    <?php } ?>
</h3>


<?php echo form_open($this->uri->segment(1) . '/' . $this->uri->segment(2) . '/' . $user->getAccountId(), array('class' => 'form-validated', 'autocomplete' => 'off')) ?>
<table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td width="50%">
            <p class="clearfix">
                <label>First Name <span>*</span></label>
                <input tabindex="1" class="tiptip text required capitalize" type="text" title="Enter the user's First Name" name="firstName" id="firstName" value="<?php echo $user->getFirstName() ?>">
            </p>
        </td>
        <td>
            <p class="clearfix">
                <label>Address <span>*</span></label>
                <input tabindex="21" class="tiptip text required" type="text" title="Enter the user's Address" name="address" id="address" value="<?php echo $user->getAddress() ?>">
            </p>
        </td>
    </tr>
    <tr class="even">
        <td>
            <p class="clearfix">
                <label>Last Name <span>*</span></label>
                <input tabindex="2" class="tiptip text required capitalize" type="text" title="Enter the user's Last Name" name="lastName" id="lastName" value="<?php echo $user->getLastName() ?>">
            </p>
        </td>
        <td>
            <p class="clearfix">
                <label>City <span>*</span></label>
                <input tabindex="22" class="tiptip text required" type="text" title="Enter the user's City" name="city" id="city" value="<?php echo $user->getCity() ?>">
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <p class="clearfix">
                <label>Title <span>*</span></label>
                <input tabindex="3" class="tiptip text required" type="text" title="Enter the user's Title" name="title" id="title" value="<?php echo $user->getTitle() ?>">
            </p>
        </td>
        <td>
            <p class="clearfix">
                <label>State <span>*</span></label>
                <input tabindex="23" class="tiptip text required" type="text" title="Enter the user's State" name="state" id="state" value="<?php echo $user->getState() ?>">
            </p>
        </td>
    </tr>
    <tr class="even">
        <td>
            <p class="clearfix">
                <label>Email <span>*</span></label>
                <input tabindex="4" class="tiptip text required email" type="text" title="Enter a valid email address" name="email" id="email" value="<?php echo $user->getEmail() ?>">
            </p>
        </td>
        <td>
            <p class="clearfix">
                <label>Zip Code <span>*</span></label>
                <input tabindex="24" class="tiptip text required" title="Enter the user's Zip Code" type="text" name="zip" id="zip" value="<?php echo $user->getZip() ?>">
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <p class="clearfix">
                <label>Password</label>
                <a class="btn ui-button" id="sendPasswordReset" data-account-id="<?php echo $user->getAccountId(); ?>">Send Password Reset Email</a>
            </p>
        </td>
        <td>
            <p class="clearfix">
                <label>Time Zone <span>*</span></label> <?php echo form_dropdown('timeZone', array(
                    'EST' => 'Eastern Time',
                    'CST' => 'Central Time',
                    'MST' => 'Mountain Time',
                    'PST' => 'Pacific Time',
                ), $user->getTimeZone(), ' tabindex="26"') ?>
            </p>
        </td>
    </tr>
    <tr class="even">
        <td>
            <p class="clearfix">
                <label>Cell Phone <span>*</span></label>
                <input tabindex="6" class="tiptip text required" type="text" title="Enter the user's Cell Phone" name="cellPhone" id="cellPhone" value="<?php echo $user->getCellPhone() ?>">
            </p>
        </td>
        <td>
            <div class="clearfix">
                <?php if (!$user->isAdministrator(true)) { ?>
                    <label>User Class</label>
                    <?php
                    $permissions = array(
                        '0' => 'User',
                        '1' => 'Branch Manager',
                        '2' => 'Full Access',
                        '3' => 'Administrator',
                    );
                    ?>
                    <?php echo form_dropdown('user_class', $permissions, $user->getUserClass(), ' id="userClass"') ?>
                    <div class="help tiptip launchPrivileges" title="What is this?" style="float: left; margin-top: 2px;">?</div>
                <?php } ?>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <p class="clearfix">
                <label>Office Phone <span>*</span></label>
                <input tabindex="7" class="tiptip text required" title="Enter the user's Office Phone" style="width: 85px" type="text" name="officePhone" id="officePhone" value="<?php echo $user->getOfficePhone() ?>">
                <input tabindex="8" class="tiptip text" placeholder="Ext" title="Enter the user's Office Phone Extension" style="width: 40px" type="text" name="officePhoneExt" id="officePhoneExt" value="<?php echo $user->getOfficePhoneExt() ?>">
            </p>
        </td>
        <td>
            <p class="clearfix">
                <label>Branch</label>
                <select name="branch" id="branch">
                    <option value="NULL">Main</option>
                    <?php foreach ($branches as $branch) {
                        ?>
                        <option value="<?php echo $branch->getBranchId() ?>" <?php echo ($user->getBranch() == $branch->getBranchId()) ? 'selected="selected"' : '' ?>><?php echo $branch->getBranchName() ?></option><?php
                    } ?>
                </select>
            </p>
        </td>
    </tr>
    <tr class="even">
        <td>
            <p class="clearfix">
                <label>Fax</label>
                <input tabindex="8" class="tiptip text" title="Enter the user's Fax<br>Leave blank to use company Fax" type="text" name="fax" id="fax" value="<?php echo $user->getFax() ?>">
            </p>
        </td>
        <td>
            <p class="clearfix">
                <label>Sales</label>
                <select name="sales" id="sales">
                    <option value="0">No</option>
                    <option value="1" <?php if ($user->isSales()) echo 'selected="selected"'; ?>>Yes</option>
                </select>
            </p>
        </td>
     
    </tr>
    <tr class="">
        <td>
            <label>Work Order Address</label>
            <select name="work_order_address" id="work_order_address">
                <option value="0">Use Company Address</option>
                <?php
                foreach ($addresses as $address) {
                    ?>
                    <option <?php echo ($address->getAddressId() == $user->getWorkOrderAddress()) ? 'selected="selected"' : '' ?> value="<?php echo $address->getAddressId() ?>"><?php echo $address->getFullAddress() ?></option><?php
                }
                ?>
            </select>
        </td>
        <td>
            <?php
            if (!$user->isAdministrator(true) && ($logged_account->getAccountId() != $user->getAccountId())) {
                ?>
                <p class="clearfix">
                    <label>Disabled</label>
                    <select name="disabled" id="disabled">
                        <option value="0">No</option>
                        <option value="1" <?php if ($user->getDisabled()) echo 'selected="selected"'; ?>>Yes</option>
                    </select>
                </p>
            <?php } ?>
        </td>
    </tr>
    <tr class="even">
        <td>
            <label for="layout">Default Proposal Layout</label>
            <select name="layout" >
                <optgroup label="Web Layout">
                    <?php foreach($web_layouts as $web_layout => $layout) { 
                        $selected = '';
                        if ($layout == $user->getLayout()) {
                            $selected = ' selected="selected" ';
                        }
                        ?>
                        
                        <option value="<?php echo $layout ?>" <?php echo $selected ?>><?php echo $web_layout ?></option>
                        
                    <?php } ?>
                </optgroup>
                <optgroup label="Pdf">
                            <?php
                            foreach ($layouts as $layoutName => $layout) {
                                $selected = '';
                                if ($layout == $user->getLayout()) {
                                    $selected = ' selected="selected" ';
                                }
                                ?>
                                <option value="<?php echo $layout ?>" <?php echo $selected ?>><?php echo $layoutName ?></option>
                                <?php
                            }
                            ?>
                </optgroup>
            </select>
            
        </td>
        <td>
            <div class="clearfix">
                <label>Proposal Notifications</label>
                <?php
                echo form_dropdown('disable_proposal_notifications', array(0 => 'Enabled', 1 => 'Disabled'), $user->getDisableProposalNotifications(), ' id=""disable_proposal_notifications"');
                ?>
            </div>
        </td>
    </tr>
    
    <?php if ($logged_account->isGlobalAdministrator()) { ?>
    <tr>
        <td>
            <label>Wheel it Off</label>
            <?php
            echo form_dropdown('wio', array(0 => 'No', 1 => 'Yes'), $user->getWio());
            ?>
        </td>
        <td>
        <div class="clearfix estimatingDiv" style="display:none;">
            <?php 
            if($user->getCompany()->getEstimating()){
                ?>
                <label>Estimating</label>
                <?php
                echo form_dropdown('estimating', array(0 => 'No', 1 => 'Yes'), $user->getEstimating(), ' id="estimating"');
            }
                ?>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <label>Sales Report Emails</label>
            <?php
            echo form_dropdown('sales_report_emails', array(0 => 'No', 1 => 'Yes'), $user->getSalesReportEmails(), ' id="sales_report_emails"');
            ?>
            
        </td>
        <td>
        <div class="clearfix  if_estimating" style="display:none;">
            <?php 
            if($user->getCompany()->getEstimating()){
                ?>
                <label>Edit Prices</label>
                <?php
                echo form_dropdown('edit_prices', array(0 => 'No', 1 => 'Yes'), $user->getEditPrice(), ' id="edit_prices"');
            }
                ?>
            </div>
        </td>
    </tr>
    <tr id="report_frequency_row">
        <td>
            <label>Report Frequency</label>
            <?php
            echo form_dropdown('email_frequency', array(1 => 'Daily', 2 => 'Weekly', 3 => 'Monthly'), $user->getEmailFrequency(), ' id="email_frequency"');
            ?>
        </td>
     
    </tr>
    <?php } ?>
    <tr >
        <td>
            <label>Proposal Email CC</label>
            <input type="checkbox" name="proposal_email_cc" class="proposal_email_cc" <?php echo ($user->getProposalEmailCC())? 'checked':'';?> >
        </td>
     
    </tr>
    <?php if (!$user->isAdministrator(true)) : ?>
        <tr class="odd">
            <td>
                <div class="clearfix" id="approvalLine">
                    <label>Requires Bid Approval</label>
                    <?php
                    $options = array(
                        0 => 'No',
                        1 => 'Yes',
                    )
                    ?>
                    <?php echo form_dropdown('requiresApproval', $options, $user->requiresApproval(), 'id="requiresApproval"'); ?>
                    <div class="help tiptip launchBidApproval" title="What is this?" style="float: left; margin-top: 2px;">?</div>
                    <br/>
                    <div class="clearfix"></div>
                    <div class="bidApprovalDetails">
                        <label>Company Default</label>
                        <p style="padding-top: 6px;">$<?php echo number_format($user->getCompany()->getDefaultBidApproval()) ?: 0; ?></p>
                    </div>
                </div>
            </td>
            <td>
                <div class="bidApprovalDetails" style="display: none">
                    <div>
                        <label>&nbsp;</label>
                        <input type="checkbox" name="useDefaultApproval" id="useDefaultApproval"
                            <?php echo($user->getDefaultApproval() ? ' checked="checked"' : ''); ?>/>
                        <p style="padding-top: 6px">Use Company Default?</p>
                    </div>

                    <div class="clearfix"></div>

                    <div id="bidApprovalLimit">
                        <label>Set Approval Limit</label>
                        <input type="text" name="approvalAmount" id="approvalAmount" class="text field-priceFormat"
                               value="$<?php echo number_format($user->getApprovalAmount()); ?>">
                        <div class="help tiptip launchBidApprovalDetails" title="What is this?" style="float: left; margin-top: 2px;">?</div>
                    </div>
                </div>
            </td>
        </tr>
    <?php endif; ?>
 
    <?php if ($logged_account->isGlobalAdministrator()) { ?>
        <tr>
            <td colspan="2" style="background: #f4f4f4;">
                <h4 style="text-align: center;">Administrative Options</h4>
            </td>
        </tr>
        <tr>
            <td>
                <label>Expiration Date</label>
                <input tabindex="28" type="text" name="expires" id="expires" style="width: 75px; text-align: center;" value="<?php echo date('n/j/Y', $user->getExpires()) ?>" class="text">
            </td>
            <td>
                <?php if ($logged_account->isGlobalAdministrator()) { ?>
                    <label>Secretary</label>
                    <?php
                    echo form_dropdown('secretary', Array(0 => 'No', 1 => 'Yes'), $user->getSecretary(), ' id="secretary"');
                    ?>
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
    <tr class="even">
        <td><label>&nbsp;</label><input tabindex="100" type="submit" value="Save" class="btn blue" name="save"></td>
        <td></td>
    </tr>
</table>

<?php echo form_close() ?>


<!-- Signature -->


<table width="100%" border="0" cellpadding="0" cellspacing="0" class="boxed-table">
    <thead>
    <tr>
        <td colspan="2">
            <h4>User Signature</h4>
        </td>
    </tr>
    </thead>
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
                <form id="changesig_form" action="<?php echo site_url('account/edit_user/' . $user->getAccountId()) ?>" method="post" enctype="multipart/form-data">
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
                if (file_exists(UPLOADPATH . '/clients/signatures/signature-' . $user->getAccountId() . '.jpg')) {
                    ?>
                    <h4 align="center">Current Signature:</h4>
                    <img style="width: 200px; height: auto; display: block; margin: 0 auto;" src="/uploads/clients/signatures/signature-<?php echo $user->getAccountId() ?>.jpg?<?php echo rand(100000, 999999) ?>" alt="">
                    <a style="display: block; text-align: center;" href="<?php echo site_url('account/edit_user/' . $user->getAccountId() . '/removeSignature') ?>">[Remove]</a>
                    <?php
                }
                ?>
            </div>
        </td>
    </tr>
    </tbody>
</table>

<!-- PSA COnnection -->
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="boxed-table">
    <thead>
    <tr>
        <td colspan="2">
            <h4>ProSiteAudit</h4>
        </td>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td width="50%">
            <div class="padded">
                <p style="text-align: center">
                    <img src="/static/images/psa.jpeg" width="200px"/>
                </p>
                <p style="margin-top: 20px; text-align: center">
                    Real-Time pavement audits only available to user who purchased this additional option. For more information visit <a href="http://www.prositeaudit.com" target="_blank">prositeaudit.com</a>
                </p>

            </div>

        </td>
        <td width="50%">
            <form id="psa_form" action="<?php echo site_url('account/edit_user/' . $user->getAccountId()) ?>" method="post">
                <table class="boxed-table">
                    <thead></thead>
                    <tbody>
                    <tr>
                        <td>
                            <label>Email</label>
                            <input type="text" name="psaEmail" id="psaEmail" class="text" autocomplete="off"
                                   value="<?php echo $user->getPsaEmail(); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Password</label>
                            <input type="password" name="psaPass" id="psaPass" class="text" autocomplete="off"
                                   value="<?php echo $user->getPsaPassword(); ?>">
                        </td>
                    </tr>
                    <tr>
                        <td style="text-align: center">
                            <input class="btn" name="savePsa" id="savePsa" type="submit" value="Save Credentials" style="float: none !important;">
                        </td>
                    </tr>
                    </tbody>
                </table>
            </form>
        </td>
    </tr>
    </tbody>
</table>


<script type="text/javascript">
    $(document).ready(function () {
        $("#otpResend").css("display", "block");

        $(".bidApprovalDetails").hide();
        //approval code
        if ($('#sales').val()==0) {
                $('#sales_report_emails').val('0');
                $('#sales_report_emails').prop('disabled', true);
                check_sales_report();
                
            }
            if ($('#sales_report_emails').val()==0) {
                check_sales_report();
                
            }
            
            $.uniform.update();

        if ($('#estimating').val()==0) {
            
                $('.if_estimating').hide();
            }
            else {
                $('.if_estimating').show();
            }
        function checkUserClass() {
            if ($("#userClass").val() > 0) {
                //$("#approvalLine").hide();
                //$('.bidApprovalDetails').hide();

            } else {
                $("#approvalLine").show();
                $("#requiresApproval").trigger('change');
            }

            if ($("#userClass").val() == 0 || $("#userClass").val() == 2) {
               
                $(".estimatingDiv").show();
                
            } else {
               
                $(".estimatingDiv").hide();
                $(".if_estimating").hide();
            }
        }

        checkUserClass();
        $("#userClass").change(function () {
            checkUserClass();
        });
        ///privileges code
        $(".launchPrivileges").click(function () {
            $("#privileges").dialog('open');
            return false;
        });
        $("#privileges").dialog({
            modal: true,
            width: 700,
            autoOpen: false,
            buttons: {
                Close: function () {
                    $(this).dialog('close');
                }
            }
        });
        ///bid approval code
        $(".launchBidApproval").click(function () {
            $("#bidApproval").dialog('open');
            return false;
        });
        $("#bidApproval").dialog({
            modal: true,
            width: 700,
            autoOpen: false,
            buttons: {
                Close: function () {
                    $(this).dialog('close');
                }
            }
        });

        // Show bid approval details if approval required (hidden by default)
        var requiresApproval = $('#requiresApproval').val();
        if (requiresApproval > 0) {
            $('.bidApprovalDetails').show();
        }

        // Hide text box if default is checked
        var useDefaultApproval = $('#useDefaultApproval').is(':checked');
        if (useDefaultApproval) {
            $('#bidApprovalLimit').hide();
        }

        // Handle change of checkbox event
        $('#useDefaultApproval').change(function () {
            if ($(this).is(':checked')) {
                $('#bidApprovalLimit').hide();
            }
            else {
                $('#bidApprovalLimit').show();
            }

        });
        // Handle change of checkbox event
        $('#estimating').change(function () {
            if ($(this).val()==0) {
                $('.if_estimating').hide();
               
                $('#edit_prices').val(0);
            }
            else {
                $('.if_estimating').show();
            }

        });
        
        // Show if changed to yes
        $('#requiresApproval').change(function () {
            if ($(this).val() > 0) {
                $('.bidApprovalDetails').show();
            }
            else {
                $('.bidApprovalDetails').hide();
            }
        });

        ///bid approval code
        $(".launchBidApprovalDetails").click(function () {
            $("#bidApprovalDetailsHelp").dialog('open');
            return false;
        });
        $("#bidApprovalDetailsHelp").dialog({
            modal: true,
            width: 700,
            autoOpen: false,
            buttons: {
                Close: function () {
                    $(this).dialog('close');
                }
            }
        });

        // Copy default value
        $('#useCompanyDefaultApproval').click(function () {
            var companyDefaultApproval = $('#companyDefaultApproval').text();
            $('#approvalAmount').val(companyDefaultApproval);
            return false;
        });

        // Password Reset request
        $("#sendPasswordReset").click(function () {
            $("#sendPasswordEmailHelp").dialog('open'); 
        });

        $("#sendPasswordEmailHelp").dialog({
            modal: true,
            width: 400,
            autoOpen: false,
            buttons: {
                Close: function () {
                    $(this).dialog('close');
                }
            }
        });

    $('#sales').change(function () {
        
        handle_sales_report_options()
    });

    $('#sales_report_emails').change(function () {
        
        check_sales_report();
    });

    $('#userClass').change(function () {
        handle_sales_report_options()
    });

    function handle_sales_report_options(){
        if ($('#sales').val()==0 && $('#userClass').val()==0) {
                $('#sales_report_emails').val('0');
                $('#sales_report_emails').prop('disabled', true);
                $('#email_frequency').val('0');
                $('#email_frequency').prop('disabled', true);
                
            }
            else {
                $('#sales_report_emails').val('1');
                $('#sales_report_emails').prop('disabled', false);
                $('#email_frequency').val('1');
                $('#email_frequency').prop('disabled', false);
            }
            $.uniform.update();
            check_sales_report();
    }

    function check_sales_report(){
        if ($('#sales_report_emails').val()==0 ) {
            $('#report_frequency_row').hide();
        }else{
            $('#report_frequency_row').show();
        }
    }

        // to check mobile varification before enable 2way authentication
      // Initialize the OTP Verification Dialog
      $("#otp-verification-dialog").dialog({
            autoOpen: false, // Keep the dialog hidden initially
            modal: true,
            buttons: {
                Close: function() {
                    $(this).dialog("close");
                   // $("#2way_auth").val('0').change(); // Set value to "No"  
                }
            }
        });
        // Open the OTP Verification Dialog when #2way_auth changes to '1'
   
    
    // Initially hide OTP-related fields and messages
    $("#otpResend").hide();
    $("#otp-label, #otp-input, #msg_success, #msg_error").hide();
    $(".Otp_box").hide();
    $("#logging_error, #logging_in").hide();
    $("#AuthBtn").on("click", function (e) {
      e.preventDefault(); // Prevent default form submission behavior
      $("#logging_in").show();
      $("#logging_error").hide();
      var remember = 0;
      if ($('#remember').attr('checked')) {
          remember = 1;
      }
      var request = $.ajax({
          url:"/ajax/otp_validate2",
          type:"POST",
          data:{
              "email":$("#email").val(),
              "otp":$("#otp").val()
          },
          dataType:"json",
          success:function (data) {
              if(data.otp==false){
                  $("#otpResend").show();
              }else{
                  $("#otpResend").hide();
              }                                    
              if (data.success) {
                  $(".loading").hide();
                  swal({
                      title: 'Success',
                      html: 'We have emailed you instructions for resetting your password. Please check your email.',
                      showCloseButton: true,
                  }).then(function() {
                      //document.location.href = url;
                      $("#sendPasswordEmailHelp").dialog('close');
                      });
               } else {
                  console.log("dfsgsdf");
                  if (data.auth) {return false;}
                  $("#logging_in").hide();
                  if (data.error) {
                      $("#logging_error").html(data.error);
                  }
                  $("#logging_error").show();
                  if (data.fail=="false" || data.fail==false) {
                      $("#otpResend").show();
                      $("#logging_in").hide();
                      $("#logging_error").hide();
                      $("#msg_error").html(data.msg);
                      $("#msg_error").show();
                  }
              }
          }
      });
      return false;
  });

  //otp resend 
// OTP Resend
// $("#otpResend").on("click", function (e) {
$(document).on("click", ".otpResend, #otpResend", function (e) {

e.preventDefault(); // Prevent default form submission behavior
$("#msg_error").hide();
$("#logging_error").hide();
$("#logging_in").show();
$(".Otp_box").hide();

var method = $("input[name='2way_auth']:checked").val();
if (!$("input[name='2way_auth']:checked").val()) {
      event.preventDefault(); // Prevent form submission
       $("#msg_error").html("'Please select where you would like the Verification Code sent.");
       $("#msg_error").show();
  
}else{
  $(".send_varification_code").hide();
  $(".Otp_box").show();
  
  var request = $.ajax({
  url: "/ajax/resendOtp2",
  type: "POST",
  data: {
      email: $("#email").val(),
      method:method
  },
  dataType: "json",
  success: function (data) {
      if (data.auth) {
           $("#logging_error").hide();
          $("#logging_in").hide();
          $("#msg_success").html(data.msg);
          $("#msg_success").show();

      } else {
          if (data.fail) {
              //$("#msg_success").hide();
              $("#logging_error").hide();
              
          }
      }
  },
  error: function (jqXHR, textStatus, errorThrown) {
      //console.log("Request failed: " + textStatus + " - " + errorThrown);
      $("#logging_error").html("An error occurred. Please try again.");
  }
});

} 
return false;
});
setTimeout(function() {
$("#msg_error").hide();
$("#msg_success").fadeOut(); // Hide the message after 5 seconds
$("#msg_error").fadeOut();
$("#logging_error").fadeOut();
}, 10000); // 1000 milliseconds = 1 seconds
//otp resend close 
 
  
});






</script>

<div id="privileges" title="User Privileges">
    To help you out with figuring out what you want your users to see and have access to, we have devised this list to help you out:
    <br><br><b style="color:black;">User</b><br>
    <ul>
        <li>Can only see his own proposals/....</li>
        <li>Can view <b>Company Info</b> (Name, Address, Phone, Fax, Website URL and the Administrators name)</li>
        <li>Can view <b>My Info</b> (Email, Name, Address Time Zone)</li>
        <li>Can add Prospects, Leads, Contacts and Proposals</li>
        <li>Can view their own History</li>
        <li>Can import Client Lists</li>
        <li>Can view the Dashboard</li>
    </ul>
    <br><b style="color:black;">Branch Manager</b><br>
    <ul>
        <li><i>All of the above plus:</i></li>
        <li>Can view/edit/delete all Proposals, Leads, Prospects, etc. for all the branch users</li>
    </ul>
    <br><b style="color:black;">Full Access</b><br>
    <ul>
        <li><i>All of the above plus:</i><br></li>
        <li>Can View all History</li>
        <li>Can view all Leads</li>
        <li>Can view all Prospects</li>
        <li>Can view all Proposals</li>
    </ul>
    <br><b style="color:black;">Administrator</b><br>
    <ul>
        <li><i>All of the above plus:</i><br></li>
        <li>Can edit Users info including Passwords</li>
        <li>Can Disable a User</li>
    </ul>
    <br><b style="color:black;">Company Administrator</b><br>
    <ul>
        <li><u>There is only per company</u> - highlighted in red in the users page<br></li>
        <li><i>All of the above plus:</i></li>
        <li>Can grant/revoke admin privileges to other users<br></li>
    </ul>
</div>

<div id="bidApproval" title="User Privileges">
    <b style="color:black;">Use:</b><br><br>

    <p>When you have multiple sales people and would like one or many of them to have a proposal “approved” prior to sending it to a customers, this is a process to do that.</p>
    <br/>

    <p>This is an excellent way to manage and control the review process in a simple, timely manner to ensure success and management of costs.</p>
    <br/><b style="color:black;">Process:</b><br><br>
    <ul>
        <li>The user will be able to create the proposal, add images; specifications and pricing just like any other proposal. The user can basically do anything a full access user can do except send a proposal at any time.</li>
        <li>After completion, the user will submit the proposal for approval to one or many people at the company designated for the approval process. Once submitted, the “Approver” will immediately receive an email letting them know they have a project to “Approve”.</li>
        <li>Once the “Approver” approves and reviews the project, the project will be emailed directly to the contact from the “User”, and the “User” will immediately receive an email letting them know that the project was “approved.”</li>
    </ul>
    <br><b style="color:black;">Limitations:</b><br><br>
    <ul>
        <li>The user cannot at anytime email the contact a proposal, a change of proposal etc. If any changes occur after the approval process, it is required that the proposal be reapproved etc.</li>
        <li>All proposals will be in the “proposal queue” until they are approved. This will make it simple to identify the proposals needing approval and easily accessed in the “Proposal” area of <?php echo SITE_NAME;?>.</li>
        <li>You can change the authorization required for approvals in the User- Edit section under the My Account Tab.</li>
    </ul>
</div>

<div id="bidApprovalDetailsHelp" title="User Privileges">

    <p>Use this feature to set a limit for this user needing bid approval.</p>
    <br/>

    <p>Bids above the specifed amount will be sent for approval.</p>
    <br/>

    <p>Set to $0 for all bids to require approval.</p>
    <br/>

    <p>Leave blank to use the company default limit.</p>
</div>


<div id="sendPasswordEmailHelp" title="Varification Code Send">

              
            <div class="box-content">
                <form action="#" method="post" class="validate big">
                    <table class="boxed-table send_varification_code" cellpadding="0" cellspacing="0" width="100%">
                        <tr class="even">
                            <td>
                                <p class="text-center">Resetting your password requires 2-Step Verification. Please
                                choose where you would like your Verification Code sent.</p>
                            </td>
                        </tr>
                        <tr>
                        <td>
                            <div class="radio-option">
                                <input type="radio" class="radioButton" id="auth_email" name="2way_auth" value="email">
                                <label for="auth_email"><?php echo $user->getEmail(); ?></label>
                            </div>
                        </td>
                         </tr>
                        <tr>
                            <td>
                                <div class="radio-option">
                                    <input type="radio" class="radioButton" id="auth_mobile" name="2way_auth" value="mobile">
                                    <label for="auth_mobile"><?php echo $user->getCellPhone(); ?></label>
                                </div>
                            </td>
                        </tr>


                        <tr class="even">
                            <td>
                                <label>&nbsp;</label>
                                <!-- <input style="margin-left:40px;" type="submit" id="otpResend" value="Send" class="submit btn update-button" name="recover"> -->
                           
                                 <input id="otpResend" type="submit" value="Send" class="btn blue" role="button" aria-disabled="false">

                                </td>
                        </tr>
 
 
                        
                    </table>

                    <!--otp box start-->
                    <table  class="boxed-table Otp_box" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td>
                                <label>Email:</label>
                                <input type="hidden" name="email" id="email" class="text required email" value="<?php echo $user->getEmail(); ?>">
                                <div id="email" style="margin-top:6px;"><?php echo $user->getEmail(); ?></div>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <label>Verification Code:</label>
                                <input type="text" name="otp" id="otp" class="text required" autocomplete="off" maxlength="6">
                            
                            </td>
                        </tr>
                     
                        <tr class="even">
                            <td>
                                
                                <button type="submit"class="btn blue-button" id="AuthBtn" style="width: 180px;left: 115px;padding: 3px 10px;font-size: 14px;margin: 0;"><i class="fa fa-fw fa-sign-in"></i>Submit</button>
                                <div class="otpResend" ><a href="#">Resend Verification Code</a></div>
                             </td>
                        </tr>
                    
                       
                    </table>
                    
                    <!--otp box close-->
                    <table>
                    <tr class="even">
                            <td>


                                <div  style="width:280px;display:none;margin-left:2px;" id="logging_in" class="loading">Checking your credentials...</div>
                                <div style="display:none;" id="logging_error" class="error closeonclick"></div>
                                <div style="display:none;" id="msg_error" class="error closeonclick"></div>
                                <div style="display:none;" id="msg_success" class="success closeonclick" style="font-color:green;"></div>


                            </td>
                        </tr>
                    </table>
                </form>
            </div>
 

</div>
 <!-- OTP Verification Dialog -->

 <div id="otp-verification-dialog" title="2way Authentication" style="display:none;">
    <?php if($user->getCellPhone() != "") { ?>
        <p>A verification code has been sent to your mobile number: <b><?php echo $user->getCellPhone() ?></b></p>

        <div class="form-group" id="otp-field">
            <label for="otp-input" id="otp-label" style="display:none;">Enter OTP:</label>
            <input type="text" id="otp-input" maxlength="6" class="form-control" placeholder="Enter OTP" style="display:none;" disabled>
        </div>

        <div id="msg_success" class="success" style="display:none; color:green;"></div>
        <div id="msg_error" class="error" style="display:none; color:red;"></div>
        <div id="otpResend"><a href="#">Resend OTP</a></div>

        <button id="verify-btn">Verify</button>
    <?php } else { ?>
        <p>Mobile Number is required for two-way Authentication.</p>
    <?php } ?>
</div>

<script type="text/javascript">
    document.addEventListener("DOMContentLoaded", function() {
    var otpResendButton = document.getElementById("otpResend");
    if (otpResendButton) {
        otpResendButton.style.display = "block";
    }
});     
</script>