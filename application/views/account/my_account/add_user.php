<h3>
    Add User
    <a href="<?php echo site_url('account/company_users') ?>">Back</a>
</h3>
<?php echo form_open('account/add_user', array('class' => 'form-validated', 'autocomplete' => 'off')) ?>
<table cellpadding="0" cellspacing="0" border="0" class="boxed-table" width="100%">
    <tr>
        <td width="50%">
            <p class="clearfix">
                <label>First Name <span>*</span></label>
                <input tabindex="1" class="tiptip text required capitalize" type="text" title="Enter the user's First Name" name="firstName" id="firstName" value="<?php echo $this->input->post('firstName') ?>">
            </p>
        </td>
        <td>
            <p class="clearfix">
                <label>Address <span>*</span></label>
                <input tabindex="9" class="tiptip text required" type="text" title="Enter the user's Address" name="address" id="address" value="<?php echo $account->getCompany()->getCompanyAddress() ?>">
            </p>
        </td>
    </tr>
    <tr class="even">
        <td>
            <p class="clearfix">
                <label>Last Name <span>*</span></label>
                <input tabindex="2" class="tiptip text required capitalize" type="text" title="Enter the user's Last Name" name="lastName" id="lastName" value="<?php echo $this->input->post('lastName') ?>">
            </p>
        </td>
        <td>
            <p class="clearfix">
                <label>City <span>*</span></label>
                <input tabindex="10" class="tiptip text required" type="text" title="Enter the user's City" name="city" id="city" value="<?php echo $account->getCompany()->getCompanyCity() ?>">
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <p class="clearfix">
                <label>Title <span>*</span></label>
                <input tabindex="3" class="tiptip text required" type="text" title="Enter the user's Title" name="title" id="title" value="<?php echo $this->input->post('title') ?>">
            </p>
        </td>
        <td>
            <p class="clearfix">
                <label>State <span>*</span></label>
                <input tabindex="11" class="tiptip text required" type="text" title="Enter the user's State" name="state" id="state" value="<?php echo $account->getCompany()->getCompanyState() ?>">
            </p>
        </td>
    </tr>
    <tr class="even">
        <td>
            <p class="clearfix">
                <label>Email <span>*</span></label>
                <input tabindex="4" class="tiptip text required email" type="text" title="Enter a valid email address" name="email" id="email" value="<?php echo $this->input->post('email') ?>">
            </p>
        </td>
        <td>
            <p class="clearfix">
                <label>Zip Code <span>*</span></label>
                <input tabindex="12" class="tiptip text required" title="Enter the user's Zip Code" type="text" name="zip" id="zip" value="<?php echo $account->getCompany()->getCompanyZip() ?>">
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <p class="clearfix">
                <label>Time Zone <span>*</span></label>
                <!--                                <input class="tiptip text required" type="text" title="Enter the user's Time Zone" name="timeZone" id="timeZone" value="--><?php //echo $this->input->post('timeZone') ?><!--">-->
                <?php echo form_dropdown('timeZone', array(
                    'EST' => 'Eastern Time',
                    'CST' => 'Central Time',
                    'MST' => 'Mountain Time',
                    'PST' => 'Pacific Time',
                ), $this->input->post('timeZone'), ' tabindex="14"') ?>
            </p>
        </td>
        <td>
            <p class="clearfix">
                <label>Work Order Address</label>
                <select name="work_order_address" id="work_order_address">
                    <option value="0">Use Company Address</option>
                    <?php
                    foreach ($addresses as $address) {
                        ?>
                        <option value="<?php echo $address->getAddressId() ?>"><?php echo $address->getFullAddress() ?></option><?php
                    }
                    ?>
                </select>
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <p class="clearfix">
                <label>Cell Phone <span>*</span></label>
                <input tabindex="7" class="tiptip text required" type="text" title="Enter the user's Cell Phone" name="cellPhone" id="cellPhone" value="<?php echo $this->input->post('cellPhone') ?>">
            </p>
        </td>
        <td>
            <div class="clearfix">
                <label>User Class</label>
                <?php
                $permissions = array(
                    '0' => 'User',
                    '1' => 'Branch Manager',
                    '2' => 'Full Access',
                    '3' => 'Administrator',
                );
                ?>
                <?php echo form_dropdown('user_class', $permissions, NULL, ' id="userClass"') ?>
                <div class="help tiptip launchPrivileges" title="What is this?" style="float: left; margin-top: 2px;">?</div>
            </div>
        </td>
    </tr>
    <tr class="even">
        <td>
            <p class="clearfix">
                <label>Office Phone <span>*</span></label>
                <input tabindex="8" class="tiptip text required" title="Enter the user's Office Phone" type="text" name="officePhone" id="officePhone" style="width: 85px"  value="<?php echo $account->getCompany()->getCompanyPhone() ?>">
                <input tabindex="8" class="tiptip text" placeholder="Ext" title="Enter the user's Office Phone Extension" style="width: 40px" type="text" name="officePhoneExt" id="officePhoneExt" value="">
            </p>
        </td>
        <td>
            <p class="clearfix">
                <label>Branch</label>
                <select name="branch" id="branch">
                    <option value="NULL">Main</option>
                    <?php foreach ($branches as $branch) {
                        ?>
                        <option value="<?php echo $branch->getBranchId() ?>"><?php echo $branch->getBranchName() ?></option><?php
                    } ?>
                </select>
            </p>
        </td>
    </tr>
    <tr>
        <td>
            <p class="clearfix">
                <label>Fax</label>
                <input tabindex="9" class="tiptip text" type="text" title="Enter the user's Fax #" name="fax" id="fax" value="<?php echo $account->getCompany()->getAlternatePhone() ?>">
            </p>
        </td>
        <td>
            <?php
            if ($logged_account->isGlobalAdministrator()) {
                ?>
                <label>Expiration Date</label>
                <input tabindex="28" type="text" name="expires" id="expires" style="width: 75px; text-align: center;" value="<?php echo date('n/j') ?>/<?php echo (date('Y', time()) + 1) ?>" class="text">
            <?php
            }
            ?>
        </td>
    </tr>
    <tr class="even">
        <td>
            <div class="clearfix" id="approvalLine">
                <label>Requires Bid Approval</label>
                <?php
                $options = array(
                    0 => 'No',
                    1 => 'Yes',
                )
                ?>
                <?php echo form_dropdown('requiresApproval', $options,"",'id="requiresApproval"'); ?>
                <div class="help tiptip launchBidApproval" title="What is this?" style="float: left; margin-top: 2px;">?</div>
                    <br/>
                    <div class="clearfix"></div>
                    <div class="bidApprovalDetails">
                        <label>Company Default</label>
                        <p style="padding-top: 6px;">$<?php echo number_format($account->getCompany()->getDefaultBidApproval()) ?: 0; ?></p>
                    </div>

                    <div class="bidApprovalDetails" style="display: none">
                        <div style="float:left">
                            <label>&nbsp;</label>
                            <input type="checkbox" name="useDefaultApproval" id="useDefaultApproval"/>
                            <p style="padding-top: 6px;float:left">Use Company Default?</p>
                        </div>

                        <div class="clearfix"></div>

                        <div id="bidApprovalLimit">
                            <label>Set Approval Limit</label>
                            <input type="text" name="approvalAmount" id="approvalAmount" class="text field-priceFormat"
                                    value="">
                            <div class="help tiptip launchBidApprovalDetails" title="What is this?" style="float: left; margin-top: 2px;">?</div>
                        </div>
                    </div>    
                
            </div>
        </td>
        <td>
            <label>Proposal Notifications</label>
            <div id="uniform-disable_proposal_notifications" class="selector"><span style="-moz-user-select: none;">Enabled</span><select style="opacity: 0;" name="disable_proposal_notifications" id="disable_proposal_notifications">
                    <option value="0" selected="selected">Enabled</option>
                    <option value="1">Disabled</option>
                </select></div>
        </td>
    </tr>
    <tr>
        <td>
            <label>Sales</label>
            <?php
            $options = array(
                0 => 'No',
                1 => 'Yes',
            )
            ?>
            <?php echo form_dropdown('sales', $options, '', ' id="sales"'); ?>
        </td>
        <td>
            <label>Wheel it Off</label>
            <?php
            $options = array(
                0 => 'No',
                1 => 'Yes',
            )
            ?>
            <?php echo form_dropdown('wio', $options); ?>
        </td>
    </tr>
    <tr>
        <td>
        <div class="clearfix estimatingDiv" style="display:none;">
            <?php 
            if($account->getCompany()->getEstimating()){
                ?>
                <label>Estimating</label>
                <?php
                echo form_dropdown('estimating', array(0 => 'No', 1 => 'Yes'), '', ' id="estimating"');
            }
                ?>
            </div>
        </td>
        <td>
            <div class="clearfix  if_estimating" style="display:none;">
            <?php 
            if($account->getCompany()->getEstimating()){
                ?>
                <label>Edit Prices</label>
                <?php
                echo form_dropdown('edit_prices', array(0 => 'No', 1 => 'Yes'), $account->getEditPrice(), ' id="edit_prices"');
            }
                ?>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <label>Sales Report Emails</label>
            <?php
            echo form_dropdown('sales_report_emails', array(0 => 'No', 1 => 'Yes'), '', ' id="sales_report_emails"');
            ?>
        </td>
        <td>
            <div id="report_frequency_row">
                <label>Report Frequency</label>
                <?php
                echo form_dropdown('email_frequency', array(1 => 'Daily', 2 => 'Weekly', 3 => 'Monthly'), '', ' id="email_frequency"');
                ?>
            </div>
        </td>
    </tr>

    <tr class="">
        <td>
            <p class="clearfix">
                <label>&nbsp;</label><input tabindex="100" type="submit" value="Create" class="btn" name="save">
            </p></td>
        <td></td>
    </tr>
</table>
<?php echo form_close() ?>
<script type="text/javascript">
    $(document).ready(function () {
        $(".bidApprovalDetails").hide();
        handle_sales_report_options();
        
        $.uniform.update();
        if ($('#estimating').val()==0) {
            
            $('.if_estimating').hide();
        }
        else {
            $('.if_estimating').show();
        }
        //approval code
        function checkUserClass() {
            if ($("#userClass").val() > 0) {
                //$("#approvalLine").hide();
                $("#requiresApproval").val('no');
                $("#requiresApproval").trigger('change');
            } else {
                $("#approvalLine").show();
            }
            if ($("#userClass").val() == 0 || $("#userClass").val() == 2) {
               
               $(".estimatingDiv").show();
               
           } else {
              
               $(".estimatingDiv").hide();
               $('.if_estimating').hide();
           }
        }

        checkUserClass();
        $("#userClass").change(function () {
            checkUserClass();
        });
        //bla bla
        $("#cellPhone, #officePhone, #fax").mask("999-999-9999");
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

        // Handle change of Select event
    $('#sales').change(function () {
        handle_sales_report_options()
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

    $('#sales_report_emails').change(function () {
        
        check_sales_report();
    });

    function check_sales_report(){
        if ($('#sales_report_emails').val()==0 ) {
            $('#report_frequency_row').hide();
        }else{
            $('#report_frequency_row').show();
        }
    }

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

<div id="bidApprovalDetailsHelp" title="User Privileges">

    <p>Use this feature to set a limit for this user needing bid approval.</p>
    <br/>

    <p>Bids above the specifed amount will be sent for approval.</p>
    <br/>

    <p>Set to $0 for all bids to require approval.</p>
    <br/>

    <p>Leave blank to use the company default limit.</p>
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