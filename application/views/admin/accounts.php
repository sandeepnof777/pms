<?php $this->load->view('global/header-admin'); ?>
<div id="content" class="clearfix">

    <div class="widthfix">


    <h3 style="text-align: center;">Manage Users <?php echo (!$this->uri->segment(3)) ? ' - All' : ' - ' . $company->getCompanyName() ?></h3>

<!---Start Filter button---->
        <div class="materialize" style="position: absolute;top: 225px;white-space: nowrap;">

                        <div class="m-btn groupAction tiptip groupActionsButton" title="Carry out actions on selected Users"
                            id="typeGroupAction" style="display:none">
                            <i class="fa fa-fw fa-check-square-o"></i> Group Actions
                            <div class="materialize groupActionsContainer" style="width:300px;    z-index: 999999;">
                                <div class="collection groupActionItems">
                                    <a href="javascript:void(0);" id="changeExpiry" class="enableGroupEstimating collection-item iconLink">
                                        <i class="fa fa-fw fa-external-link"></i> Set Expiry
                                    </a>
                                    
                                    <a href="javascript:void(0);" id="groupEnableWO" class="collection-item iconLink">
                                        <i class="fa fa-fw fa-check-circle-o"></i> Enable Wheel it Off
                                    </a>
                                    <a href="javascript:void(0);" id="groupDisableWO"  class="collection-item iconLink">
                                        <i class="fa fa-fw fa-times"></i> Disable Wheel it Off
                                    </a>
                                    <a href="javascript:void(0);" id="groupSetSales"  class=" collection-item iconLink">
                                        <i class="fa fa-fw fa-check-circle-o"></i> Set as Sales
                                    </a>
                                    <a href="javascript:void(0);" id="groupRemoveSales" class="emailCompanies collection-item iconLink">
                                        <i class="fa fa-fw fa-times"></i> Remove as sales
                                    </a>
                                    <!--
                                    <a href="javascript:void(0);" id="groupRoleChange"  class=" collection-item iconLink">
                                        <i class="fa fa-fw fa-external-link-square"></i> Role
                                    </a>
                                    -->
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
    <!---End Filter button---->
        

        <div class="content-box">

            <div class="box-header">
                <a href="<?php echo site_url('admin/company_data') ?>" class="box-action tiptip" title="Go Back">Company Data</a>
                <a href="<?php echo site_url('admin') ?>" class="box-action tiptip" title="Go Back">Dashboard</a>
                <div style="position: absolute; top: 37px; left: 0px; z-index: 99999; font-weight: normal; text-shadow: none;  font-style: normal; padding-left: 10px;">
                    <a href="#" id="selectAllUsers">All</a> / <a href="#" id="selectNoneUsers">None</a>
                </div>
                <div style="padding: 0px ; width: 300px;" class="clearfix" id="multi-actions">
                    
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="box-content">
                <table id="adminCompanyAccountsTable" cellpadding="0" cellspacing="0" border="0" class="display">
                    <thead>
                    <tr>
                        <td></td>
                        <td>ID#</td>
                        <td>Name</td>
                        <td>Company</td>
                        <td>Type</td>
                        <td>WIO</td>
                        <td>Sales</td>
                        <td>Secretary</td>
                        <td>Last Login Timestamp</td>
                        <td>Last Login</td>
                        <td>Last Login Timestamp</td>
                        <td>Expires</td>
                        <td>Actions</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($accounts as $account) {
                        /* @var $account \models\Accounts */
                        ?>
                    <tr>
                        <td><input type="checkbox" name="selectedUsers[]" class="multi-actions" data-id="<?= $account->getAccountId() ?>" data-expiry="<?php echo $account->getExpires(); ?>"></td>
                        <td><?php echo $account->getAccountId(); ?></td>
                        <td>
                            <a href="mailto:<?php echo $account->getEmail() ?>" class="iconLink">
                                <i class="fa fa-fw fa-envelope tiptip " title="Email: <?php echo $account->getEmail(); ?>"></i>
                            </a>
                            <?php if($account->isDisabled()) { ?>
                                <i class="fa fa-fw fa-ban tiptip" title="User is disabled"></i>
                            <?php } ?>
                           <span style="<?php if ($account->isAdministrator(true)){echo 'color: red;font-weight:bold';  }?>">  <?php echo $account->getfullName(); ?></span>
                        </td>
                        <td><?php echo $account->getCompany()->getCompanyName(); ?></td>
                        <td><?php echo ($account->getUserClass(true)); ?></td>
                        <td><?php echo ($account->getWio()) ? 'Yes' : 'No'; ?></td>
                        <td><?php echo ($account->isSales()) ? 'Yes' : 'No'; ?></td>
                        <td><?php echo ($account->isSecretary()) ? 'Yes' : 'No'; ?></td>
                        <td><span style="<?php echo ($account->getExpires() < time()) ? 'color: red;' : ''; ?>"><?php echo ($account->getLastLogin()) ? $account->getLastLogin()->timestamp : 0; ?></span></td>
                        <td><span style="<?php echo ($account->getExpires() < time()) ? 'color: red;' : ''; ?>"><?php echo ($account->getLastLogin()) ? $account->getLastLogin()->format('m/d/Y') : '-'; ?></span></td>
                        <td><span style="<?php echo ($account->getExpires() < time()) ? 'color: red;' : ''; ?>"><?php echo $account->getExpires(); ?></span></td>
                        <td><span style="<?php echo ($account->getExpires() < time()) ? 'color: red;' : ''; ?>"><?php echo date('m/d/Y', $account->getExpires()); ?></span></td>
                        <td>
                            <!--<a class="btn-edit tiptip" title="Edit User" href="<?php echo site_url('admin/edit_account/' . $account->getAccountId()) ?>">Edit</a>-->
                            <a class="btn-settings tiptip" title="Log In As" href="<?php echo site_url('admin/sublogin/' . $account->getAccountId()) ?>">Log In As</a>
                            <?php
                            if (!$account->isAdministrator(true)) {
                                ?>
                                <a class="btn-promote tiptip" title="Make Admin" href="<?php echo site_url('admin/make_administrator/' . $account->getAccountId()) ?>">Make Admin</a>
                                <a class="btn-delete tiptip" title="Delete" href="<?php echo site_url('admin/delete_user/' . $account->getAccountId()) ?>">Delete User</a>
                                <?php } ?>
                        </td>
                    </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php 
//set roles array
$permissions = array(
    array('id' =>0,'name' => 'User'),
    array('id' =>2,'name' => 'Full Access'),
    array('id' =>1,'name' => 'Branch Manager'),
    array('id' =>3,'name' => 'Administrator'),

);

?>
<div id="change-expiry" title="Change Expiration Date">
    <p>&nbsp;</p>
    <label for="expiryDate">New Expiration Date</label>
    <input type="text" name="expiryDate" id="expiryDate" class="expiryDate" value="<?= $firstExpiry; ?>">
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $(".tiptip").tipTip({defaultPosition: 'right'});

        $('#adminCompanyAccountsTable').dataTable({
            "bProcessing": true,
            "aoColumns": [
                null, // 0 Checkbox
                null, // 1 ID
                null, // 2 Name
                null, // 3 Company
                null, // 4 Type
                {className: "dtCenter"}, // 5 Sales
                {className: "dtCenter"}, // 6 WIO
                {className: "dtCenter"}, // 7 Secretary
                {"bVisible": false}, // 8 Last Login Timestamp
                {"iDataSort": 8}, // 9 Last Login
                {"bVisible": false}, // 10 Expiry Timestamp
                {"iDataSort": 10}, // 11 Expiry
                {"sWidth": '120px'}// 12 Actions
            ],
            "bJQueryUI": true,
            "bAutoWidth": false,
            "sPaginationType": "full_numbers",
            "aLengthMenu": [
                [ -1, 10, 25, 50],
                ["All", 10, 25, 50]
            ],
            "sDom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"f>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"lir>'
        });


        $(".btn-delete").click(function() {
            if (!confirm('Are you sure? All of his clients will be attributed to the company admin on deletion.')) {
                return false;
            }
        });

        updateMultiActions();
        $(".multi-actions").on('change', function () {
            updateMultiActions();
        });
        $("#changeExpiry").on('click', function () {
            $("#change-expiry").dialog('open');
            $(".groupActionsContainer").hide();
            return false;
        });
        //multi actions
        function updateMultiActions() {
            if ($(".multi-actions:checked").length) {
                $("#multi-actions").show();
                $(".groupActionsButton").show();
                
            } else {
                $("#multi-actions").hide();
                $(".groupActionsButton").hide();
            }
        }

                // Group Actions Button
        $(".groupActionsButton").click(function () {
            
            // Toggle the buttons
            $(".groupActionsContainer").toggle();
        });

        $("#change-expiry").dialog({
            width: 400,
            modal: true,
            open: function() {
                updateDateFields();
            },
            buttons: {
                Ok: function () {
                    var users = [];
                    $(".multi-actions:checked").each(function () {
                        users.push($(this).data('id'));
                    });
                    $.ajax({
                        url: "<?= site_url('account/updateMultipleExpiry') ?>",
                        type: "POST",
                        data: {
                            users: users,
                            expiryDate: $("#expiryDate").val()
                        },
                        success: function () {
                            window.location.reload();
                        }
                    });
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });

        $("#expiryDate").datepicker({
            showOn: "button",
            buttonImage: "/static/images/calendar.gif",
            buttonImageOnly: true,
            buttonText: "Select date",
            beforeShow: function(input, inst) {
                updateDateFields();
            }
        });

        // All
        $("#selectAllUsers").click(function () {
            $(".multi-actions").attr('checked', 'checked');
            updateMultiActions();
            $.uniform.update();
            return false;
        });

        // None
        $("#selectNoneUsers").click(function () {
            $(".multi-actions").attr('checked', false);
            updateMultiActions();
            $.uniform.update();
            return false;
        });

        function updateDateFields() {
            var lowestVal = $(".multi-actions:checked").map(function() {
                return $(this).data('expiry');
            });
            var lowestTimestamp = Math.min.apply(Math, lowestVal);
            var expiryDate = new Date((lowestTimestamp * 1000));
            expiryDate.setFullYear(expiryDate.getFullYear() + 1);

            var dateString = (expiryDate.getMonth() + 1) + '/' + expiryDate.getDate() + '/' +  expiryDate.getFullYear();

            $("#expiryDate").val(dateString);
            $(this).datepicker("setDate", expiryDate);
        }
    });

    $("#groupEnableWO").click(function () {

        swal({
            title: "",
            text: "Enable Wheel it Off?",
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function(isConfirm) {
            if (isConfirm) {

                swal({
                    title: 'Saving..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                    swal.showLoading();
                    }
                })

                var users = [];
                    $(".multi-actions:checked").each(function () {
                        users.push($(this).data('id'));
                    });


                $.ajax({
                    url: '/account/groupEnableWO',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        'users': users,
                    },

                    success: function( data){
                        swal('',data.count+' Users - Wheel it Off Enabled. Reloading Page...');
                        window.location.reload();
                        
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        swal("Error", "An error occurred Please try again");
                    }
                })


            } else {
                swal("Cancelled", "user Not Updated :)", "error");
            }
        });

});

$("#groupDisableWO").click(function () {

swal({
    title: "",
    text: "Disable Wheel it Off?",
    showCancelButton: true,
    confirmButtonText: 'Save',
    cancelButtonText: "Cancel",
    dangerMode: false,
}).then(function(isConfirm) {
    if (isConfirm) {

        swal({
            title: 'Saving..',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timer: 2000,
            onOpen: () => {
            swal.showLoading();
            }
        })

        var users = [];
            $(".multi-actions:checked").each(function () {
                users.push($(this).data('id'));
            });


        $.ajax({
            url: '/account/groupDisableWO',
            type: "POST",
            dataType: "JSON",
            data: {
                'users': users,
            },

            success: function( data){
                swal('',data.count+' Users - Wheel it Off Disabled. Reloading Page...');
                window.location.reload();
            },
            error: function( jqXhr, textStatus, errorThrown ){
                swal("Error", "An error occurred Please try again");
            }
        })


    } else {
        swal("Cancelled", "user Not Updated :)", "error");
    }
});

});

$("#groupSetSales").click(function () {

    swal({
        title: "Set as Sales?",
        text: "",
        showCancelButton: true,
        confirmButtonText: 'Save',
        cancelButtonText: "Cancel",
        dangerMode: false,
    }).then(function(isConfirm) {
        if (isConfirm) {

            swal({
                title: 'Saving..',
                allowEscapeKey: false,
                allowOutsideClick: false,
                timer: 2000,
                onOpen: () => {
                swal.showLoading();
                }
            })

            var users = [];
                $(".multi-actions:checked").each(function () {
                    users.push($(this).data('id'));
                });


            $.ajax({
                url: '/account/groupSetSales',
                type: "POST",
                dataType: "JSON",
                data: {
                    'users': users,
                    'set': 1,
                },

                success: function( data){
                    swal(data.count+' Users Set as Sales. Reloading Page...');
                    window.location.reload();
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    swal("Error", "An error occurred Please try again");
                }
            })


        } else {
            swal("Cancelled", "user Not Updated :)", "error");
        }
    });

});


$("#groupRemoveSales").click(function () {

    swal({
        title: "Remove as Sales?",
        text: "",
        showCancelButton: true,
        confirmButtonText: 'Save',
        cancelButtonText: "Cancel",
        dangerMode: false,
    }).then(function(isConfirm) {
        if (isConfirm) {

            swal({
                title: 'Saving..',
                allowEscapeKey: false,
                allowOutsideClick: false,
                timer: 2000,
                onOpen: () => {
                swal.showLoading();
                }
            })

            var users = [];
                $(".multi-actions:checked").each(function () {
                    users.push($(this).data('id'));
                });


            $.ajax({
                url: '/account/groupSetSales',
                type: "POST",
                dataType: "JSON",
                data: {
                    'users': users,
                    'set': 0,
                },

                success: function( data){
                    swal(data.count+' Users Removed as Sales. Reloading Page...');
                    window.location.reload();
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    swal("Error", "An error occurred Please try again");
                }
            })


        } else {
            swal("Cancelled", "user Not Updated :)", "error");
        }
    });

});

// change group status
$("#groupRoleChange").click(function(){
    swal({
                    title: "<i class='fa fw fa-clone'></i> Change User Role",
                    html: '<hr/>'+
                        '<form method="post" id="change_role_form">'+
                            '<input type="hidden" name="action" value="change"/>'+
                            '<input type="hidden" name="statusId" id="deleteStatusId" value=""/>'+
                            '<br/><p>Choose the new status for the selected Leads</p><br/>'+
                            '<select name="user_roles" id="user_roles" class="swal-select">'+
                                '<option value="">-Select Role</option>'+
                                <?php foreach ($permissions as $permission) { ?>
                                        '<option value="<?php echo $permission['id']; ?>" ><?php echo $permission['name']; ?></option>'+
                                    <?php } ?>
                            '</select>'+
                            '<p class="show_if_user_full_selected" style="display:none;"><input type="checkbox" name="secretary" id="secretary">Secretary'+
                            '</form>',

                    showCancelButton: true,
                    width: '600px',
                    confirmButtonText: "<i class='fa fw fa-clone'></i> Change",
                    cancelButtonText: "<i class='fa fw fa-times'></i> Cancel",
                    dangerMode: false,
                    showCloseButton: true,
                    onOpen:function() { 
                        $('.swal2-modal').attr('id','change_role_popup');
                        $.uniform.update();
                    }
                }).then(function (result) {
                    
                    swal({
                            title: '',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 10000,
                            width: '300px',
                            onOpen: () => {
                                swal.showLoading();
                                $('.swal2-modal').attr('id','');
                            }
                        })
                        var users = [];
                        $(".multi-actions:checked").each(function () {
                            users.push($(this).data('id'));
                        });

                            if($('#targetStatus').val()){
                                var statusId = $('#user_roles').val();
                                var leadIds = getSelectedIds();
                                $.ajax({
                                    url: '<?php echo site_url('ajax/changeGroupUserRole') ?>',
                                    type: 'POST',
                                    dataType: 'json',
                                    data: {roleId:roleId,userIds:users},
                                    success: function (response) {
                                        if(response.success){
                                            swal({
                                                title: "",
                                                text: 'Role Updated for '+leadIds.length+' Users',
                                                width: '300px'
                                            })
                                            //swal('','Status Updated for '+leadIds.length+' Leads');
                                            oTable.ajax.reload();
                                        }else{
                                            swal('Error','An error occurred');
                                        }
                                    }
                                });
                            }

        
        }).catch(swal.noop);;

})

$(document).on('change', "#user_roles", function () {
    var role = $(this).val();
    $('.show_if_user_full_selected').hide();
    if(role==0 || role == 1){
        $('.show_if_user_full_selected').show();
    }else{
        $('.show_if_user_full_selected').hide();
    }
});

</script>
<?php $this->load->view('global/footer'); ?>
