<style>
    #estimate-users div.selector {
        width: 184px;
    }
    #sales-users div.selector {
        width: 184px;
    }
    div.DataTables_sort_wrapper{
        padding-right: 0px!important;
    }
</style>
<!-- add a back button -->
<h3 style="border-bottom:unset;padding-bottom:0px;">
    &nbsp;
    <!-- <a href="<?php echo site_url('account/my_account') ?>">Back</a> -->
    &nbsp;
    <a href="<?php echo site_url('account/add_user') ?>">+ Add User</a>
</h3>
<!---Start Filter button---->
<div class="materialize" style="font-weight: normal;height: 25px;min-width: 100px !important;position: relative;top: 4px;white-space: nowrap;">
        <div class="m-btn groupAction tiptip" id="groupAction" style="position: relative;display:none;font-size: 14px;" title="Carry out actions on selected contacts" >
            <i class="fa fa-fw fa-check-square-o"></i> Group Actions
            <div class="groupActionsContainer materialize" style="width:160px">
                <div class="collection groupActionItems" >
                    <a href="javascript:void(0);" class="groupUserClass collection-item iconLink" style="width: 100%;color:#000;padding: 4px;float: left;font-weight:normal">
                         User Class
                    </a>
                    <a href="javascript:void(0);" class="groupBranch collection-item iconLink" style="width: 100%;color:#000;padding: 4px;float: left;font-weight:normal">
                         Branch
                    </a>
                    <!-- <a href="javascript:void(0);" class="groupWio collection-item iconLink" style="width: 100%;color:#000;padding: 4px;float: left;font-weight:normal">
                        Wheel it Off
                    </a> -->
                    <a href="javascript:void(0);" class="groupDisable collection-item iconLink" style="width: 100%;color:#000;padding: 4px;float: left;font-weight:normal">
                        Disable
                    </a>
                    
                    <a href="javascript:void(0);" class="groupEstimate collection-item iconLink" style="width: 100%;color:#000;padding: 4px;float: left;font-weight:normal">
                         Estimate
                    </a>
                    <a href="javascript:void(0);" class="groupSales collection-item iconLink" style="width: 100%;color:#000;padding: 4px;float: left;font-weight:normal">
                         Sales
                    </a>
                    <a href="javascript:void(0);" class="groupDelete collection-item iconLink" style="width: 100%;color:#000;padding: 4px;float: left;font-weight:normal">
                        Delete
                    </a>
                    <a href="javascript:void(0);" class="groupSalesEmails collection-item iconLink" style="width: 100%;color:#000;padding: 4px;float: left;font-weight:normal">
                        Sales Report Emails
                    </a>
                    
                </div>
            </div>
        </div>
        <div id="filterBadges"></div>
        <div class="clearfix"></div>
    </div>
<!---End Filter button---->

<table cellpadding="0" cellspacing="0" border="0" id="myAccountUsersTable" class="display">
    <thead>
    <tr>
        <td class="dtCenter"><input type="checkbox" name="all_users" id="check_all"></td>
        <td>User</td>
        <td>Branch</td>
        <td>Bid Approval</td>
        <td>Added</td>
        <td>Exp.</td>
        <td>Est.</td>
        <td width="144">Actions</td>
    </tr>
    </thead>
    <tbody>
    <?php
    $accountOptions = array();
    $companyAdmin = '0';
    
    foreach ($accounts as $acc) {
       
        $accountOptions[$acc->getAccountId()] = $acc->getFullName();
        
        ?>
        <tr>
        <td class="dtCenter"><input type="checkbox" name="user" data-user-id="<?php echo $acc->getAccountId() ?>" class="user_check"></td>
            <td>
            <?php if($acc->isDisabled()) { ?><i class="fa fa-fw fa-ban tiptip" title="User is disabled"></i><?php } ?><a class="tiptip" title="Email <?php echo $acc->getEmail() ?>" href="mailto:<?php echo $acc->getEmail() ?>"><span style="<?php if ($acc->isAdministrator(true)){$companyAdmin =$acc->getAccountId(); echo 'color: red; font-weight: bold;';  }?>"><?php echo $acc->getFirstName() . ' ' . $acc->getLastName();?> </span></a><br><?php if($acc->getSales()==1){ echo '<span class="tiptip" style="cursor:help;font-weight:bold" title="Sales User">[S]</span> ';} echo $acc->getUserClass(true) ?>
            </td>
            <td>
                <?php echo ($acc->getBranch() && isset($branches[$acc->getBranch()])) ? $branches[$acc->getBranch()]->getBranchName() : 'Main'; ?>
            </td>
            <td>
                <?php echo ($acc->requiresApproval()) ? 'Yes - $' . number_format( (int) $acc->getApprovalLimit()) :'No'; ?>
            </td>
            <td><?php echo date('n/d/y', $acc->getCreated(false)); ?></td>
            <td><?php echo ($acc->getExpires() < time()) ? '<span style="color: red; font-weight: bold;">Expired</span>' : date('n/d/y', $acc->getExpires()); ?></td>
            <td><?php 
                if($acc->getUserClass()==1 || $acc->getUserClass()==3 ){
                    echo 'Yes';
                }else{
                    echo ($acc->getEstimating()) ? 'Yes' : 'No';
                }
            ?></td>
            <td>
                <!--<a href="#details-<?php echo $acc->getAccountId() ?>" rel="<?php echo $acc->getAccountId() ?>" class="tiptip btn-view viewAccount">View User Info</a>-->
                <a href="<?php echo site_url('account/edit_user/' . $acc->getAccountid()) ?>" class="tiptip btn-edit">Edit User</a>
                <a class="btn-reassign reassign-clients tiptip" title="Reassign Contacts, Proposals &amp; Accounts" href="#" rel="<?php echo $acc->getAccountId() ?>">Reassign Contacts, Proposals &amp; Accounts</a>
                <a class="btn-history tiptip" href="<?php echo site_url('history/user/' . $acc->getAccountId()) ?>" title="View user history">View User History</a>
                <?php if ((!$acc->isAdministrator(true)) /*&& (($acc->getExpires() < time()))*/) { ?>
                    <a href="<?php echo site_url('account/delete_account/' . $acc->getAccountid()) ?>" rel="<?php echo site_url('account/delete_account/' . $acc->getAccountid()) ?>" id="<?php echo $acc->getAccountId() ?>" class="tiptip confirm-deletion btn-delete">Delete User</a>
                <?php } ?>
            </td>
        </tr>
    <?php
    
    }
    ?>
    </tbody>
</table>

<!--User Class dialog -->
<div id="user-class-users"  title="Update User Settings">
<p class="adminInfoMessage"><i class="fa fa-fw fa-info-circle"></i>The following setting will be applied to the selected users.</p>
    <div style="margin-top:15px">
        <label style="width: 140px;float: left;font-size: 15px;font-weight: bold;margin-top: 3px;margin-left: 25px;">Select User Type </label>

        <select name="user_class" id="user_class">
            <option value="0">User</option>
            <option value="1">Branch Manager</option>
            <option value="2">Full Access</option>
            <option value="3">Adminstrator</option>
        </select>
        <div class="help tiptip launchPrivileges" title="What is this?" style="float: right;margin-right:85px; margin-top: 2px;">?</div>
    </div>
</div>

<!--branch dialog -->
<div id="branch-users"  title="Update User Settings">
<p class="adminInfoMessage"><i class="fa fa-fw fa-info-circle"></i>The following setting will be applied to the selected users.</p>
    <div style="margin-top:15px">
        <label style="width: 140px;float: left;font-size: 15px;font-weight: bold;margin-top: 3px;margin-left: 25px;">Select Branch </label>

        <select name="user_branch" id="user_branch" >
            <option value="NULL">Main</option>
            <option value="1">Dayton</option>                        
            <option value="2">Louisville</option>
        </select>
    </div>
</div>
<!--wio dialog -->
<div id="wio-users"  title="Update User Settings">
<p class="adminInfoMessage"><i class="fa fa-fw fa-info-circle"></i>The following setting will be applied to the selected users.</p>
    <div style="margin-top:15px">
        <label style="width: 140px;float: left;font-size: 15px;font-weight: bold;margin-top: 3px;margin-left: 25px;">Wheel it Off </label>

        <select name="user_wio" id="user_wio" >
            <option value="1">Yes</option>                        
            <option value="0">No</option>
        </select>
    </div>
</div>
<!--disable dialog -->
<div id="disable-users"  title="Update User Settings">
<p class="adminInfoMessage"><i class="fa fa-fw fa-info-circle"></i>The following setting will be applied to the selected users.</p>
    <div style="margin-top:15px">
        <label style="width: 140px;float: left;font-size: 15px;font-weight: bold;margin-top: 3px;margin-left: 25px;">User Disable </label>

        <select name="user_disable" id="user_disable" >
            <option value="1">Yes</option>                        
            <option value="0">No</option>
        </select>
    </div>
</div>
<!--Estimate dialog -->
<div id="estimate-users"  title="Update User Settings">
<p class="adminInfoMessage"><i class="fa fa-fw fa-info-circle"></i>The following setting will be applied to the selected users.</p>
    <div style="margin-top:15px">
        <label style="width: 140px;float: left;font-size: 15px;font-weight: bold;margin-top: 3px;margin-left: 25px;">Enable Estimating </label>

        <select name="estimate_type" id="estimate_type">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
    </div>
</div>

<!-- Sales dialog -->
<div id="sales-users" title="Update User Settings">
<p class="adminInfoMessage"><i class="fa fa-fw fa-info-circle"></i>The following setting will be applied to the selected users.</p>
    <div style="margin-top:15px">
        <label style="width: 140px;float: left;font-size: 15px;font-weight: bold;margin-top: 3px;margin-left: 25px;">Is Sales Person </label>
      
        <select name="sales_type" id="sales_type">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
    </div>
</div>
<!-- Delete User dialog -->
<div id="delete-users" title="Update User Settings">
<p class="adminInfoMessage"><i class="fa fa-fw fa-info-circle"></i>The following setting will be applied to the selected users.</p>
    <div style="margin-top:15px">
    <p>Are you sure you want to delete the user? <br><span style="color: red;">This can not be undone and the subscription will be lost! </span><br>
        You have to assign the leads, accounts, contacts and proposals of this user to another user!<br>
        <label style="width: 140px;float: left;font-size: 15px;font-weight: bold;margin-top: 3px;margin-left: 25px;">Select User </label>
      
        <select name="newOwnerSelect" id="newOwnerSelect">
           
        </select>
    </div>
</div>

<!-- Sales Email dialog -->
<div id="sales-emails" title="Sales Email Settings">
<p class="adminInfoMessage"><i class="fa fa-fw fa-info-circle"></i>The following setting will be applied to the selected users.</p>
    <div style="margin-top:15px">
        <label style="width: 150px;float: left;font-size: 15px;font-weight: bold;margin-top: 3px;margin-left: 25px;">Sales Report Emails </label>
      
        <select name="sales_report_emails" id="sales_report_emails">
            <option value="1">Yes</option>
            <option value="0">No</option>
        </select>
    </div>
    <div style="margin-top:15px" class="is_sales_email">
        <label style="width: 150px;float: left;font-size: 15px;font-weight: bold;margin-top: 3px;margin-left: 25px;">Report Frequency </label>
      
        <select name="email_frequency" id="email_frequency" style="opacity: 0;">
            <option value="1" selected="selected">Daily</option>
            <option value="2">Weekly</option>
            <option value="3">Monthly</option>
        </select>
    </div>
</div>

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

<script type="text/javascript">
    $(document).ready(function () {
        $('#myAccountUsersTable').dataTable({
            "aaSorting": [[1, "asc"]],
        "aoColumns": [
            {bSortable: false,"sWidth": "7px"},
            null,
            null,
            null,
            null,
            null,
            null,
            null
        ],
        
        "bPaginate": true,
        "bJQueryUI": true,
        "bAutoWidth": false,
        "sPaginationType": "full_numbers",
       // "aoColumnDefs": [ { "sWidth": "7px", "aTargets": [0] } ],
     });


        var selectOptions = Array();
        
        <?php

        foreach ($accountOptions as $accId => $optionText) {
            ?>selectOptions[<?php echo $accId ?>] = "<?php echo addslashes($optionText) ?>";
        <?php
                }
                ?>

        $("#dialog-message").dialog({
            width: 400,
            modal: true,
            buttons: {
                Close: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false,
            beforeClose: function (event, ui) {
                $("#dialog-message span").html('');
            }
        });
        $("#confirm-delete-message").dialog({
            width: 400,
            modal: true,
            buttons: {
                Ok: function () {
                    var url = $("#client-delete").attr('rel') + '/' + $("#newOwner").val();
                    document.location.href = url;
                    $(this).dialog("close");
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });
        $(".confirm-deletion").live('click', function () {
            $("#client-delete").attr('rel', $(this).attr('rel'));
            var selectOptionsText = '';
            for (i in selectOptions) {
                if (i != $(this).attr('id')) {
                    selectOptionsText = selectOptionsText + '<option value="' + i + '">' + selectOptions[i] + '</option>';
                }
            }
            $("#newOwner").html(selectOptionsText);
            $.uniform.update();
            $("#confirm-delete-message").dialog('open');
            return false;
        });
        $('.viewAccount').live('click', function () {
            var userId = $(this).attr('rel');
            $.getJSON("<?php echo site_url('ajax/getAccountData') ?>/" + userId, function (data) {
                var items = [];
                $.each(data, function (key, val) {
                    $("#field_" + key).html(val);
                });
            });
            $("#dialog-message").dialog("open");
        });

        $("#confirm-delete-message-attachment").dialog({
            width: 400,
            modal: true,
            buttons: {
                Ok: function () {
                    document.location.href = $("#client-delete-attachment").attr('rel');
                    $(this).dialog("close");
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });
        $(".confirm-deletion-attachment").on('click', function () {
            $("#client-delete-attachment").attr('rel', $(this).attr('href'));
            $("#confirm-delete-message-attachment").dialog('open');
            return false;
        });
        $("#reassign-clients").dialog({
            width: 500,
            modal: true,
            open: function (dialog, ui) {
            },
            buttons: {
                "Reassign Accounts": function () {
                    $("#reassign-form").submit();
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });
        var users = [
                <?php
                $k = 0;
                foreach ($accounts as $account) {
                    $k++;
                    ?>[<?php echo $account->getAccountId() ?>, '<?php echo addslashes($account->getFullName()) ?>']<?php
                echo ($k < count($accounts)) ? ",\n" : "\n";
            }
            ?>
        ];
        $('.reassign-clients').live('click', function () {

            var reassignFromId = $(this).attr('rel');
            $("#reassignFrom").val(reassignFromId);

            //init the reassign select box
            $("#reassignUser").html('');
            for (i in users) {
                var user = users[i];
                if (user[0] != reassignFromId) {
                    $("#reassignUser").append("<option value='" + user[0] + "'>" + user[1] + "</option>");
                }
            }

            $("#reassignUser option:first").attr('selected', 'selected');
            $.uniform.update();
            $("#reassign-clients").dialog('open');

            return false;
        });

    });

        // All
        $("#check_all").live('click', function () {
            if($(this).prop("checked")===true){
                
                $(this).closest('table').find(".user_check").prop('checked', true);
            }else{
                
                $(this).closest('table').find(".user_check").prop('checked', false);
            }
           
            $.uniform.update();
            updateNumSelected();
            //return false;
        });
    
        $(".user_check").live('change', function () {
        
        
            updateNumSelected();
        });

        $("#sales_report_emails").live('change', function () {
           
            if($(this).val()==1){
                $(".is_sales_email").show();
            }else{
                $(".is_sales_email").hide();
            }
        
        });
        

        function updateNumSelected() {
           
            var num = $(".user_check:checked").length;
            
            // Hide the options if 0 selected
            if (num < 1) {
               // $("#groupActionIntro").show();
                $("#groupAction").hide();
                //$(".groupActionsContainer").hide();
            }
            else {
                //$("#groupActionIntro").hide();
                $("#groupAction").show();
            }

            //$("#numSelected").html(num);
        }
    // Group Actions Button
    $(".groupAction").click(function () {
        
        // Toggle the buttons
        $(".groupActionsContainer").toggle();
        return false;
    });

    /* Create an array of the selected IDs */
    function getSelectedUserIds() {

        var IDs = new Array();

        $(".user_check:checked").each(function () {
            IDs.push($(this).data('user-id'));
        });

        return IDs;
        }
        // user class Click
        $('.groupUserClass').click(function(){
            $("#user-class-users").dialog('open');
            
        });
        // user branch Click
        $('.groupBranch').click(function(){
            $("#branch-users").dialog('open');
            
        });
        // user wio Click
        $('.groupWio').click(function(){
            $("#wio-users").dialog('open');
            
        });
        // user disable Click
        $('.groupDisable').click(function(){
            $("#disable-users").dialog('open');
            
        });
        
        // estimate Click
        $('.groupEstimate').click(function(){
            $("#estimate-users").dialog('open');
            
        });

        // Sales Click
        $('.groupSales').click(function(){
            $("#sales-users").dialog('open');
           
        });
        var selectOptions = Array();
        <?php
        foreach ($accountOptions as $accId => $optionText) {
            ?>selectOptions[<?php echo $accId ?>] = "<?php echo addslashes($optionText) ?>";
        <?php
                }
                ?>
        // Delete Click
        $('.groupDelete').click(function(){
           var selected_users = getSelectedUserIds();
           if(selected_users.indexOf(<?=$companyAdmin;?>)!= -1){
            swal('You cant delete the Company Admin');
            return false
           }else{
            
            var selectOptionsText = '';
            for (i in selectOptions) {
                
                if (selected_users.indexOf(parseInt(i))== -1) {
                    
                    //selectOptionsText = selectOptionsText + selectOptions[i];
                    selectOptionsText = selectOptionsText + '<option value="' + i + '">' + selectOptions[i] + '</option>';
                }
            }
            
            $("#newOwnerSelect").html(selectOptionsText);
            $.uniform.update();
            $("#delete-users").dialog('open');
           }
            
           
        });

        $('.groupSalesEmails').click(function(){
           var selected_users = getSelectedUserIds();
           
           // $("#newOwnerSelect").html(selectOptionsText);
            $.uniform.update();
            $("#sales-emails").dialog('open');
           
            
           
        });

        // User Branch dialog
        $("#branch-users").dialog({
            width: 500,
            modal: true,
            buttons: {
                "Save": {
                    text: 'Save',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmDelete',
                    click: function () {
                        swal({
                            title: 'Saving..',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 2000,
                            onOpen: () => {
                            swal.showLoading();
                            }
                        })
                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {'ids': getSelectedUserIds(),'user_branch':$('#user_branch').val()},
                            url: "<?php echo site_url('ajax/userGroupUserBranch'); ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {

                                swal('Users Branch changed');
                                
                                window.location.reload();
                            });
                        
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });

        // User WIO dialog
        $("#wio-users").dialog({
            width: 500,
            modal: true,
            buttons: {
                "Save": {
                    text: 'Save',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmDelete',
                    click: function () {
                        swal({
                            title: 'Saving..',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 2000,
                            onOpen: () => {
                            swal.showLoading();
                            }
                        })
                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {'ids': getSelectedUserIds(),'user_wio':$('#user_wio').val()},
                            url: "<?php echo site_url('ajax/userGroupUserWio'); ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {

                                swal('Users WIO changed');
                                // $('.dataTable').find(".user_check").prop('checked', false);
                                // $("#check_all").prop('checked', false);
                                // $.uniform.update();
                                // updateNumSelected();
                                // $("#estimate-users").dialog('close');
                                window.location.reload();
                            });
                        
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });

        // User Disable dialog
        $("#disable-users").dialog({
            width: 500,
            modal: true,
            buttons: {
                "Save": {
                    text: 'Save',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmDelete',
                    click: function () {
                        swal({
                            title: 'Saving..',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 2000,
                            onOpen: () => {
                            swal.showLoading();
                            }
                        })
                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {'ids': getSelectedUserIds(),'user_disable':$('#user_disable').val()},
                            url: "<?php echo site_url('ajax/userGroupUserDisable'); ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {

                                swal('Users Disable changed');
                               
                                window.location.reload();
                            });
                        
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });
        // User Class dialog
        $("#user-class-users").dialog({
            width: 500,
            modal: true,
            buttons: {
                "Save": {
                    text: 'Save',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmDelete',
                    click: function () {
                        swal({
                            title: 'Saving..',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 2000,
                            onOpen: () => {
                            swal.showLoading();
                            }
                        })
                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {'ids': getSelectedUserIds(),'user_class':$('#user_class').val()},
                            url: "<?php echo site_url('ajax/userGroupUserClass'); ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {

                                swal('Users Class changed');
                                // $('.dataTable').find(".user_check").prop('checked', false);
                                // $("#check_all").prop('checked', false);
                                // $.uniform.update();
                                // updateNumSelected();
                                // $("#estimate-users").dialog('close');
                                window.location.reload();
                            });
                        
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });

        // Estimate dialog
        $("#estimate-users").dialog({
            width: 500,
            modal: true,
            buttons: {
                "Save": {
                    text: 'Save',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmDelete',
                    click: function () {
                        swal({
                            title: 'Saving..',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 2000,
                            onOpen: () => {
                            swal.showLoading();
                            }
                        })
                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {'ids': getSelectedUserIds(),'estimating':$('#estimate_type').val()},
                            url: "<?php echo site_url('ajax/userGroupEstimate'); ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {

                                swal('Users Estimation changed');
                                // $('.dataTable').find(".user_check").prop('checked', false);
                                // $("#check_all").prop('checked', false);
                                // $.uniform.update();
                                // updateNumSelected();
                                // $("#estimate-users").dialog('close');
                                window.location.reload();
                            });
                        
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });

        

        // Delete dialog
        $("#delete-users").dialog({
            width: 500,
            modal: true,
            buttons: {
                "Save": {
                    text: 'Save',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmDelete',
                    click: function () {
                        swal({
                            title: 'Saving..',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 10000,
                            onOpen: () => {
                            swal.showLoading();
                            }
                        })
                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {'ids': getSelectedUserIds(),'new_owner':$('#newOwnerSelect').val()},
                            url: "<?php echo site_url('ajax/userGroupDelete'); ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {

                                
                                swal('Users Deleted');
                               
                                window.location.reload();
                            });
                        
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });
        // Sales dialog
        $("#sales-users").dialog({
            width: 500,
            modal: true,
            buttons: {
                "Save": {
                    text: 'Save',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmDelete',
                    click: function () {
                        swal({
                            title: 'Saving..',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 2000,
                            onOpen: () => {
                            swal.showLoading();
                            }
                        })
                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {'ids': getSelectedUserIds(),'sales':$('#sales_type').val()},
                            url: "<?php echo site_url('ajax/userGroupSales'); ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {

                                
                                swal('Users Sales changed');
                                // $('.dataTable').find(".user_check").prop('checked', false);
                                // $("#check_all").prop('checked', false);
                                // $.uniform.update();
                                // updateNumSelected();
                                // $("#sales-users").dialog('close');
                                window.location.reload();
                            });
                        
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });


        

        // Sales Emails dialog
        $("#sales-emails").dialog({
            width: 500,
            modal: true,
            buttons: {
                "Save": {
                    text: 'Save',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmDelete',
                    click: function () {
                        swal({
                            title: 'Saving..',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 2000,
                            onOpen: () => {
                            swal.showLoading();
                            }
                        })
                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {'ids': getSelectedUserIds(),'sales_report_emails':$('#sales_report_emails').val(),'email_frequency':$('#email_frequency').val()},
                            url: "<?php echo site_url('ajax/userGroupSalesEmails'); ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {

                                var msg = data.updated+' Users Updated';
                                if(data.non_updated > 0){
                                    msg += '<br/><br/>'+data.non_updated+' user(s) not updated due to not being a sales user';
                                }
                                swal('',msg);
                                $('.dataTable').find(".user_check").prop('checked', false);
                                $("#check_all").prop('checked', false);
                                $.uniform.update();
                                updateNumSelected();
                                $("#sales-emails").dialog("close");
                                //window.location.reload();
                            });
                        
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
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
</script>

<div id="reassign-clients" title="Reassign Contacts">
    <div style="position: relative;">
        <form action="<?php echo site_url('account/reassign_clients') ?>" method="post" id="reassign-form">

            <div class="content-box" style="margin-bottom: 0; padding: 10px;">
                <div class="box-content">
                    <p>Select the user to reassign all Accounts, Contacts and Proposals to:</p><br />
                    <p><label>Reassign To:</label><select name="reassignUser" id="reassignUser"></select></p>
                    <input type="hidden" name="reassignFrom" id="reassignFrom" value="" />
                </div>
            </div>

        </form>
    </div>
</div>

<div id="confirm-delete-message-attachment" title="Confirmation">
    <p>Are you sure you want to delete this file? <br>It will be automatically removed from all existing proposals that
        have it.</p>
    <a id="client-delete-attachment" href="" rel=""></a>
</div>
<div id="dialog-message" title="User Information">
    <p class="clearfix"><strong class="fixed-width-strong">Full Name:</strong> <span id="field_fullName"></span></p>

    <p class="clearfix"><strong class="fixed-width-strong">Email:</strong> <span id="field_email"></span></p>

    <p class="clearfix"><strong class="fixed-width-strong">Address:</strong> <span id="field_address"></span></p>

    <p class="clearfix"><strong class="fixed-width-strong">City:</strong> <span id="field_city"></span></p>

    <p class="clearfix"><strong class="fixed-width-strong">State:</strong> <span id="field_state"></span></p>

    <p class="clearfix"><strong class="fixed-width-strong">Zip:</strong> <span id="field_zip"></span></p>

    <p class="clearfix"><strong class="fixed-width-strong">Country:</strong> <span id="field_country"></span></p>

    <p class="clearfix"><strong class="fixed-width-strong">Cell Phone:</strong> <span id="field_cellPhone"></span></p>
</div>
<div id="confirm-delete-message" title="Confirmation">
    <p>Are you sure you want to delete the user? <br><span style="color: red;">This can not be undone and the subscription will be lost! </span><br>
        You have to assign the leads, accounts, contacts and proposals of this user to another user!<br>
        <select name="newOwner" id="newOwner">
        </select>
    </p>
    <a id="client-delete" class="" href="" rel=""></a>
</div>
