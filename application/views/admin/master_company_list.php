<?php $this->load->view('global/header-admin'); ?>
<style>
    /*view notes popup start*/
#add-note {
    margin-top: 15px;
}
#add-note button{
    font-size: 15px;
}
#add-note button span{
    line-height: 0;
}
#tiptip_holder {
    max-width: 400px!important;
}
    /*view notes popup end*/

    
.dataTables-admin tbody tr.odd.selectedRow,
.dataTables-admin tbody tr.even.selectedRow,
.dataTables-admin tbody tr.even.selectedRow td.sorting_1,
.dataTables-admin tbody tr.odd.selectedRow td.sorting_1
{
    background-color: #e4e3e3!important;
}  
#uniform-templateSelect {
    width: 225px!important;
}
#uniform-templateSelect span {
    width: 200px!important;
}
#uniform-resendSelect {
    width: 225px!important;
}
#uniform-resendSelect span {
    width: 200px!important;
}
#uniform-expired {
    width: 225px!important;
}
#uniform-expired span {
    width: 200px!important;
}
#newProposalsPopup {
    width: 450px!important;
}
</style>
<div id="content" class="clearfix" style="padding-top:5px">
    <div style="height:35px;width:966px">
    <!---Start Filter button---->
        <div class="materialize" style="float: left;font-style: initial;position: relative;top: 4px;left: 5px;white-space: nowrap;">
                        
        
                   



                         <div class="m-btn groupAction tiptip groupActionsButton" title="Carry out actions on selected proposals"
                            id="typeGroupAction" style="display:none">
                            <i class="fa fa-fw fa-check-square-o"></i> Group Actions
                            <div class="materialize groupActionsContainer" style="width:300px">
                                <div class="collection groupActionItems">
                                    <!-- <a href="javascript:void(0);" onclick="enableGroupEstimating()" class="enableGroupEstimating collection-item iconLink">
                                        <i class="fa fa-fw fa-external-link"></i> Enable Estimating
                                    </a>
                                    <a href="javascript:void(0);" onclick="disableGroupEstimating()" class="collection-item iconLink">
                                        <i class="fa fa-fw fa-times"></i> Disable Estimating
                                    </a>
                                    <a href="javascript:void(0);"  class="changeStatus collection-item iconLink">
                                        <i class="fa fa-fw fa-external-link-square"></i> Change Status
                                    </a> -->
                                    <a href="javascript:void(0);"  class="deleteCompanies collection-item iconLink">
                                        <i class="fa fa-fw fa-trash"></i> Delete
                                    </a>
                                    <!-- <a href="javascript:void(0);"  class="emailCompanies collection-item iconLink">
                                        <i class="fa fa-fw fa-envelope"></i> Send Email
                                    </a> -->
                                   


                                </div>
                            </div>
                        </div> 
                        <div class="clearfix"></div>
                    </div>
    <!---End Filter button---->
        <!-- <div id="expiredFilter" style="float:right;margin-top: 3px;">Expiry Filter: <select id="expiryFilterSelect" style="background: #ddd; border: 1px solid #aaa;"><option value="0">All</option><option>Active</option><option>Expired</option></select></div>
        <div id="statusFilter" style="float:right;margin-top: 3px;">Status Filter: <select id="statusFilterSelect" style="background: #ddd; border: 1px solid #aaa;"><option value="0">All</option><option>Active</option><option>Test</option><option>Inactive</option><option>Trial</option></select></div>
         -->
    </div>

    <div class="widthfix">
        <div class="content-box">
            <div class="box-header centered" style="position: relative;">
            
                <!-- <div style="position: absolute; left: 10px; top: 6px;">
                    <a class="box-action bulkAction changeStatus" style="float: left; margin: 0 5px 0 0; display: none;" href="#">Change Status</a>
                    <a class="box-action bulkAction deleteCompanies" style="float: left; margin: 0 5px 0 0; display: none;" href="#">Delete</a>
                    <a class="box-action bulkAction emailCompanies" style="float: left; margin: 0 5px 0 0; display: none;" href="#">Send Email</a>
                </div> -->
                Manage Parent Companies
                <div style="position: absolute; right: 10px; top: 6px;">
                    <a class="box-action" href="<?php echo site_url('admin/add_master_company') ?>">Add Parent Company</a>
                </div>
            </div>
            <div class="box-content">
                <table cellpadding="0" cellspacing="0" border="0" class="dataTables-admin display">
                    <thead>
                    <tr>
                        <td width="30"></td>
                        <td width="38">ID</td>
                        <td>Company Name</td>
                        <td>Child Companies</td>
                        <td>Status</td>
                        <td>Users</td>
                        <td>Paid</td>
                        <td>Inactive</td>
                        <td>Expires</td>
                        <td>Administrator</td>
                        <!-- <td>Layouts</td>
                        <td>PSA</td>
                        <td>Est.</td> -->
                        <td width="80">Actions</td>
                    </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>
        </div>
 
    </div>
</div>
<script type="text/javascript">

var adminTable;
var notes_tiptip_company_id;
var currentXhr;
$(document).ready(function () {

     adminTable = $('.dataTables-admin').DataTable({
        "bServerSide": true,
        "ajax": {
            "url": "<?php echo site_url('admin/masterCompaniesTableData'); ?>"
        },
        "aoColumns": [
            {bSortable: false},
            null, //0
            null, //1
            null, //2
            null, //3
            null, //4
            null, //5
            null, // 6
            null, // 7
            null, // 8
            {"bSearchable": false, 'sortable': false} //9
        ],
        "scrollCollapse": true,
            "scrollX": true,
        "bJQueryUI": true,
        "bAutoWidth": false,
        "bPaginate" : true,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [
            [10, 25, 50, 100,500,1000,-1],
            [10, 25, 50, 100,500,1000,'All']
        ],
        "drawCallback": function (settings) {
            check_highlighted_row();
            notes_tooltip();
            initTiptip();
        },
        "aaSorting": [[ 1, "asc" ]],
        "bStateSave": true,
        "sDom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop"><"#expiredFilter"><"#statusFilter">f>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"lipr>'
    });


    $('.companyStatus').live('click', function () {
        $(this).editable("<?php echo site_url('admin/updateCompanyStatus') ?>", {
            indicator: '<img src="/3rdparty/jeditable/img/indicator.gif">',
            data: "{'Active':'Active','Test':'Test','Inactive':'Inactive','Trial':'Trial'}",
            type: "select",
            submit: "OK",
            style: "inherit",
            tooltip: 'Click to edit...'
        });
    });

    $(".companyCheckbox").removeAttr('checked');
    $.uniform.update();
    function refreshGroupButtons() {
        $(".selectedCompanyCount").text($(".companyCheckbox:checked").length);
        if ($(".companyCheckbox:checked").length > 0) {
            $(".bulkAction").show();
            $(".groupAction").show();
            
        } else {
            $(".bulkAction").hide();
            $(".groupAction").hide();
        }
    }

    $(".companyCheckbox").live('change', function () {
        refreshGroupButtons();
    });
    
    $("#changeCompanyStatus").dialog({
        modal: true,
        autoOpen: false,
        width: 450,
        buttons: {
            Cancel: function () {
                $(this).dialog("close");
            }
        }
    });
    $("#deleteCompanyGroup").dialog({
        modal: true,
        autoOpen: false,
        width: 450,
        buttons: {
            Cancel: function () {
                $(this).dialog("close");
            }
        }
    });
    $(".changeStatus").click(function () {
        $("#changeCompanyStatus").dialog('open');
        $("#pleaseWaitStatus").hide();
        return false;
    });
    $('#saveGroupStatus').click(function () {
        var companies = [];
        $(".companyCheckbox:checked").each(function () {
            companies.push($(this).attr('id').replace('companies_', ''));
        });
        $("#pleaseWaitStatus").show();
        $.ajax({
            url: '<?php echo site_url('admin/saveCompanyGroupStatus') ?>',
            type: 'POST',
            data: {
                companies: companies,
                status: $("#newGroupStatus").val()
            },
            success: function () {
                document.location.reload();
            }
        });
    });
    $(".deleteCompanies").click(function () {
        $("#deleteCompanyGroup").dialog('open');
        $("#pleaseWaitGroup").hide();
        return false;
    });
    $("#deleteGroupStatus").click(function () {
        $("#pleaseWaitGroup").show();
        var companies = [];
        $(".companyCheckbox:checked").each(function () {
            companies.push($(this).attr('id').replace('companies_', ''));
        });
        $("#pleaseWaitStatus").show();
        $.ajax({
            url: '<?php echo site_url('admin/deleteCompanyGroup') ?>',
            type: 'POST',
            data: {
                companies: companies
            },
            success: function () {
                document.location.reload();
            }
        });
    });

    // var template_editor = CKEDITOR.replace('message', {
    //     toolbar: [
    //                         { name: 'styles', items: [ 'Font', 'FontSize' ] },
    //                         { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
    //                         { name: 'editing', groups: ['spellchecker' ], items: [ 'Scayt' ] },
    //                         { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline','-', 'RemoveFormat' ] },
    //                         { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
    //                         { name: 'links', items: [ 'Link', 'Unlink' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
    //                         [ 'Cut', 'Copy', 'Paste', 'PasteText' ],			// Defines toolbar group without name.
    //                         '/',																					// Line break - next group will be placed in new line.
	//                     ],
    //     height: 200
    // });

    tinymce.init({
                        selector: "textarea#message",
                        menubar: false,
                        elementpath: false,
                        relative_urls : false,
                        remove_script_host : false,
                        convert_urls : true,
                        browser_spellcheck : true,
                        contextmenu :false,
                        paste_as_text: true,
                        height:'320',
                        plugins: "link image code lists paste preview ",
                        toolbar: tinyMceMenus.email,
                        forced_root_block_attrs: tinyMceMenus.root_attrs,
                        fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
                });
    
    // Populate the toolbar
    $("#groupSelectAllTop").html('<a href="#" id="selectAll">All</a> / <a href="#" id="selectNone">None</a>&nbsp;&nbsp;&nbsp;<span id="numSelected">0</span> selected');
    //$("#statusFilter").html('Status Filter: <select id="statusFilterSelect" style="background: #ddd; border: 1px solid #aaa;"><option value="0">All</option><option>Active</option><option>Test</option><option>Inactive</option><option>Trial</option></select>');
    //$("#expiredFilter").html('Expiry Filter: <select id="expiryFilterSelect" style="background: #ddd; border: 1px solid #aaa;"><option value="0">All</option><option>Active</option><option>Expired</option></select>');
    //init status filter
    <?php
     if ($this->session->userdata('adminStatusFilter')) {
     ?>
    $("#statusFilterSelect").val('<?php echo $this->session->userdata('adminStatusFilter') ?>');
    <?php
     }
     ?>
    <?php
    if ($this->session->userdata('adminStatusExpiredFilter')) {
    ?>
    $("#expiryFilterSelect").val('<?php echo $this->session->userdata('adminStatusExpiredFilter') ?>');
    <?php
    }
    ?>
    $("#statusFilterSelect").change(function () {
        $.ajax({
            url: '<?php echo site_url('admin/filterStatus') ?>',
            type: 'POST',
            data: {
                status: $("#statusFilterSelect").val()
            },
            success: function () {
                adminTable.ajax.reload();
            }
        });
    });
    $("#expiryFilterSelect").change(function () {
        $.ajax({
            url: '<?php echo site_url('admin/filterExpired') ?>',
            type: 'POST',
            data: {
                status: $("#expiryFilterSelect").val()
            },
            success: function () {
                adminTable.ajax.reload();
            }
        });
    });
    // All
    $("#selectAll").live('click', function () {
        $(".companyCheckbox").attr('checked', 'checked');
        updateNumSelected();
        refreshGroupButtons();
        $.uniform.update();
        return false;
    });

    // None
    $("#selectNone").live('click', function () {
        $(".companyCheckbox").attr('checked', false);
        updateNumSelected();
        refreshGroupButtons();
        $.uniform.update();
        return false;
    });

    // Update the counter after each change
    $(".companyCheckbox").live('change', function () {
        updateNumSelected();
    });
//Group action functionality

        // Group Actions Button
        $(".groupAction").click(function () {
        
        // Toggle the buttons
        $(".groupActionsContainer").toggle();
        return false;
    });
    /* Update the number of selected items */
    function updateNumSelected() {
        var num = $(".companyCheckbox:checked").length;

        // Hide the options if 0 selected
        if (num < 1) {
            $("#groupActionIntro").show();
            $(".groupAction").hide();
        }
        else {
            $("#groupActionIntro").hide();
            $(".groupAction").show();
        }

        $("#numSelected").html(num);
    }

    /*Send Email to Selected Companies*/
    $(".emailCompanies").click(function () {
        loadTemplateContents($('#templateSelect option:selected').data('template-id'));
        get_resend_lists();
        $("#unlock_editor" ).prop( "checked", false );
        $("#unlock_editor_span" ).hide();
        $("#resend-proposals").dialog('open');
        $("#resendSelect").val(0);
        $(".new_resend_name").val('<?=date("m/d/Y h:ia");?>');
        $.uniform.update();
        return false;
    });

    function get_resend_lists(){

    $.ajax({
        url: '<?php echo site_url('ajax/get_admin_resend_lists') ?>',
        type: "GET",
        
        dataType: "json",
        success: function (data) {
            var html = '<option value="">Select Resend Campaign</option><option value="0">New</option><option value="-1">No Campaign</option>';
            for($i=0;$i<data.length;$i++){
                html +='<option value="'+data[$i].id+'">'+data[$i].resend_name+'</option>'
            }
            if(data.length){
                $('.campaign_btn').show();
            }
            $("#resendSelect").html(html);
        }
    });

}

    $("#resend-proposals").dialog({
        width: 950,
        modal: true,
        buttons: {
            "Resend": {
                text: 'Send Email',
                'class': 'btn ui-button update-button',
                'id': 'confirmResend',
                click: function () {
                    var companies = [];
                    $(".companyCheckbox:checked").each(function () {
                        companies.push($(this).attr('id').replace('companies_', ''));
                    });

                    var userClass = [];
                    $(".userClassCheckbox:checked").each(function () {
                        userClass.push($(this).val());
                    });
                    if (userClass.length == 0) {
                        alert('Please make sure you have atleast a user class selected!');
                        return;
                    }

                    if($('#resendSelect').val()==0 && !$('.new_resend_name').val()){
                        alert('Please enter Resend Name');
                            return false;
                    }

                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'companies': companies,
                            'subject': $("#messageSubject").val(),
                            'message': tinymce.get("message").getContent(),
                            'fromName': $("#fromName").val(),
                            'fromEmail': $("#fromEmail").val(),
                            'userClass': userClass,
                            'expired': $("#expired").val(),
                            'new_resend_name': $(".new_resend_name").val(),
                            'resendId': $("#resendSelect").val(),
                            'statusFilter' : $("#statusFilterSelect option:selected").html(),
                            'expiryFilter' : $("#expiryFilterSelect option:selected").html()
                        },
                        url: "<?php echo site_url('admin/sendEmail') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"
                    }).success(function (data) {
                        if (data.success) {
                            var resendText = 'Your emails are being sent';
                        } else {
                            var resendText = 'An error occurred. Please try again';
                        }
                        $("#sendEmailStatus").html(resendText);
                    }).error(function() {
                        alert('There\'s been an error. Please contact Andy & Chris');
                    });
                    $(this).dialog('close');
                    $("#sendEmailStatus").html('Sending emails...<img src="/static/loading.gif" />');
                    $("#send-email-status").dialog('open');
                   
                }
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });

    $("#send-email-status").dialog({
        modal: true,
        autoOpen: false,
        buttons: {
            OK: function () {
                $(this).dialog("close");
            }
        }
    });

    // Template change handler
    $('#templateSelect').change(function () {
        loadTemplateContents($('#templateSelect option:selected').data('template-id'));
    });
    function loadTemplateContents(templateId) {
        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            data: {'templateId': templateId},
            url: "<?php echo site_url('account/ajaxGetClientTemplateRaw') ?>?" + Math.floor((Math.random() * 100000) + 1),
            dataType: "JSON"
        })
            .success(function (data) {
                $("#messageSubject").val(data.templateSubject);
                //CKEDITOR.instances.message.setData(data.templateBody);
                tinymce.get("message").setContent(data.templateBody)
            });
        $.uniform.update();
    }

    // All
    $("#selectAllUserClasses").live('click', function () {
        $(".userClassCheckbox").attr('checked', 'checked');
        updateNumSelected();
        $.uniform.update();
        return false;
    });

    // None
    $("#selectNoneUserClasses").live('click', function () {
        $(".userClassCheckbox").attr('checked', false);
        updateNumSelected();
        $.uniform.update();
        return false;
    });

    // Fields Codes
    $("#templateFields").change(function () {
        $("#fieldCode").val($(this).val());
    });



function check_highlighted_row(){
    if(localStorage.getItem("ad_last_active_row")){
        var row_num =localStorage.getItem("ad_last_active_row");
        $('#DataTables_Table_0 tbody').find("[data-company-id='"+row_num+"']").closest('tr').addClass('selectedRow');
    }
}
});

// New Action button popup
$(document).on('click', ".adminTableDropdownToggle", function(e) {

    $('#newProposalsPopup').html('');
    $('#newProposalsPopup').show();
    $('.template_class').show();

    var template;
    var company_id = $(this).attr('data-company-id');
    var login_as_admin = $(this).attr('data-login-as-admin');
    var company_name = $(this).attr('data-company-name');
    var company_new_layout = $(this).attr('data-company-new-layout');
    var company_estimation = $(this).attr('data-company-estimation');
    var company_psa = $(this).attr('data-company-psa');

    if(company_new_layout == '0'){ 
        $('#enableLayout').css('display', 'block');
        $('#disableLayout').css('display', 'none');
    } else { 
        $('#disableLayout').css ('display', 'block');
        $('#enableLayout').hide();
    }

    if(company_estimation == '0'){
        $('#enableEstimation').css('display', 'block');
        $('#disableEstimation').css('display', 'none');
    } else {
        $('#disableEstimation').css('display', 'block');
        $('#enableEstimation').css('display', 'none');

    }

    if(company_psa == '0'){
        $('#enablePsa').css('display', 'block');
        $('#disablePsa').css('display', 'none');
    } else { 
        $('#disablePsa').css('display', 'block');
        $('#enablePsa').css('display', 'none');
    }
    template = $("#template").html();
    template = template.toString();

    template = template.replace(new RegExp('{companyId}', 'g'), company_id);
    template = template.replace(new RegExp('{loginAsAdmin}', 'g'), login_as_admin);
    template = template.replace(new RegExp('{companyName}', 'g'), company_name);
    template = template.replace(new RegExp('{companyNewLayout}', 'g'), company_new_layout);
    template = template.replace(new RegExp('{companyEstimation}', 'g'), company_estimation);
    template = template.replace(new RegExp('{companyPsa}', 'g'), company_psa);

 
    

    $('#newProposalsPopup').html(template);
});
</script>

<!-- new Action button popup start -->
<div id="template" style="display:none">

    <div class="dropdownMenuContainer template_class">
        <div class="closeDropdown closeProposalsDropdown" style="line-height: 10px;">
            <a href="#" class="closeDropdownMenu">&times;</a>
        </div>
        <div class="proposalMenuTitle">
            <h4>{companyName}</h4>
        </div>
        <div class="clearfix"></div>
        <ul class="dropdownMenu" style="float: left;width: 220px">
            <li class="divider noHover"><b>Actions</b></li>
            <li>
                <a href="<?php echo site_url('admin/super_accounts/{companyId}') ?>"><img
                        src="/3rdparty/icons/user_suit.png"> Users</a>
            </li>
            <li>
                <a href="<?php echo site_url('admin/add_child_company/{companyId}') ?>"><img
                        src="/3rdparty/icons/user_edit.png"> Add Child Company</a>
            </li>
            <li class="divider noHover"><b>&nbsp</b></li>
            
            <!-- <li>
                <a href="<?php echo site_url('admin/user_activity/{companyId}') ?>"><img
                        src="/3rdparty/icons/time.png"> User Activity</a>
            </li> -->
            
            <!-- <li>
                <a href="<?php echo ('{loginAsAdmin}') ? site_url('admin/sublogin/{loginAsAdmin}') : '-1' ?>"><img
                        src="/3rdparty/icons/user_edit.png"> Log In As Admin</a>
            </li>
            <li>
                <a onclick="return confirm('Are you sure? This will delete all users, clients and proposals!')"
                   href="<?php echo site_url('admin/delete_company/{companyId}') ?>"><img
                        src="/3rdparty/icons/delete.png"> Delete Company</a>
            </li> -->
        </ul>
        <ul class="dropdownMenu" style="float: left;width: 220px">
            <li class="divider noHover"><b>&nbsp</b></li>
            <li>
                <a href="<?php echo site_url('admin/add_super_account/{companyId}') ?>"><img
                        src="/3rdparty/icons/add.png"> Add User</a>
            </li>
            
            <!-- <li>
                <a href="<?php echo site_url('admin/statistics/{companyId}') ?>"><img
                        src="/3rdparty/icons/comments.png"> Company
                    Statistics</a>
            </li>
            <li>
                    <a href="<?php echo site_url('admin/enableLayouts/{companyId}') ?>" id="enableLayout" style="display: none;"><img
                            src="/3rdparty/icons/application_add.png"> Enable
                        New Layouts</a>

                    <a href="<?php echo site_url('admin/disableLayouts/{companyId}') ?>" id="disableLayout" style="display: none;"><img
                            src="/3rdparty/icons/application_delete.png">
                        Disable New Layouts</a>

            </li>
            <li>

                    <a onclick="show_loader();" href="<?php echo site_url('admin/enableEstimating/{companyId}') ?>" id="enableEstimation" style="display: none;"><img
                                src="/3rdparty/icons/calculator_edit.png">
                        Enable Estimating</a>

                    <a onclick="show_loader();" href="<?php echo site_url('admin/disableEstimating/{companyId}') ?>" id="disableEstimation" style="display: none;"><img
                                src="/3rdparty/icons/calculator_edit.png">
                        Disable Estimating</a>

            </li>
            <li>

                    <a href="<?php echo site_url('admin/enablePsa/{companyId}') ?>" id="enablePsa" style="display: none;"><img
                            src="/3rdparty/icons/map_add.png"> Enable PSA</a>

                    <a href="<?php echo site_url('admin/disablePsa/{companyId}') ?>" id="disablePsa" style="display: none;"><img
                            src="/3rdparty/icons/map_delete.png"> Disable
                        PSA</a>

            </li>
            
            <li class="view-notes" data-value-id="<?php echo ('{companyId}') ?>">
                <a href="#"><img src="/3rdparty/icons/book_edit.png" class="adminViewNotes" > Notes</a>
            </li> -->
        </ul>
    </div>

</div>
<!-- new Action button popup end -->

<div id="changeCompanyStatus" title="Change Status">
    <div>Changing Status for <span class="selectedCompanyCount"></span> companies:</div>
    <div>&nbsp;</div>
    <select name="newGroupStatus" id="newGroupStatus">
        <option value="Active">Active</option>
        <option value="Test">Test</option>
        <option value="Inactive">Inactive</option>
        <option value="Trial">Trial</option>
    </select>
    <a id="saveGroupStatus" href="#" class="btn btn-primary">Save</a>
    <span id="pleaseWaitStatus"> Please wait...</span>
</div>
<div id="deleteCompanyGroup" title="Change Status">
    <div>Are you sure you want to delete <span class="selectedCompanyCount"></span> companies?</div>
    <div>&nbsp;</div>
    <a id="deleteGroupStatus" href="#" class="btn btn-primary">Delete Permanently</a>
    <span id="pleaseWaitGroup"> Please wait...</span>
</div>


<div id="send-email-status" title="Send Email Status">
    <br />
    <p id="sendEmailStatus" style="text-align: center"></p>

</div>

<div id="loading">

    
    <div  style="text-align: center;">
    <h3>Please Wait</h3>
        <img src="/static/loading_animation.gif" />
    </div>

</div>

<!-- view notes swal popup start-->
<div id="notes" title="Company Notes" style="display: none;">
        <form action="#" id="{add-note}" style="font-size: 15px;">
            <p>
                <label style="font-weight: bold;">Add Note</label>
                <input type="text" class="text" name="noteText" id="{noteText}" style="width: 500px;margin-bottom: 10px;padding: 5px;">
                <input type="hidden" name="relationId" id="relationId" value="0">
                <button type="button" style="position: relative;top: 2px;" class="btn blue-button dont-uniform add-notes-popup-btn" value="Add"><i class="fa fa-fw fa-floppy-o"></i>Add</button>

            </p>
            <iframe id="notesFrame" src="" frameborder="0" width="100%" height="300"></iframe>
        </form>
</div>
<div id="notes_popup_div" style="display: none;">
        <iframe id="newNotesFrame2" src="" frameborder="0" width="100%" height="300"></iframe>

    </div>
<!-- view notes swal popup end-->

<?php $this->load->view('global/footer'); ?>
<script>
$(document).on('click', '#DataTables_Table_0 tbody td a, #DataTables_Table_0 tbody td span',  function() {
    $('tr.selectedRow').removeClass('selectedRow');
    $(this).parents('tr').addClass('selectedRow');
    var row_num = $(this).closest('tr').find('td:eq(0) input[type="checkbox"]').attr('data-company-id');
    if(hasLocalStorage){
        localStorage.setItem("ad_last_active_row", row_num);
    }
    
});

$(document).on('click', '.javascript_loaded',  function(e) {
    $('tr.selectedRow').removeClass('selectedRow');
    if(hasLocalStorage){
        localStorage.setItem("ad_last_active_row", '');
    }
});
     $(document).ready(function () {
        $("#loading").dialog({
            modal: true,
            autoOpen: false,
            width: 650
        });

       
     });
    function getEnableEstimatingSelectedIds(){
        var IDs = new Array();

        $(".companyCheckbox:checked").each(function () {
            var company_id = $(this).attr('id');
            company_id = company_id.replace("companies_", "");
            IDs.push(company_id);
        });

        return IDs;
}
function show_loader(){
    $("#loading").dialog('open');
}
function enableGroupEstimating() {
    $("#loading").dialog('open');
            $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {'ids': getEnableEstimatingSelectedIds()},
                            url: "<?php echo site_url('ajax/enableGroupEstimating'); ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {
                                location.href = "/admin";
                               
                            });
        };
        function disableGroupEstimating() {
            $("#loading").dialog('open');
            $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {'ids': getEnableEstimatingSelectedIds()},
                            url: "<?php echo site_url('ajax/disableGroupEstimating'); ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {
                                location.href = "/admin";
                            
            });
        };

    $("#resendSelect").live('change', function () {
        $(".new_resend_name").prop('disabled', false);
        $( "#unlock_editor" ).prop( "checked", false );
        $(".no_campaign").show();
       if($(this).val() <1){
            $('.new_resend_name_span').show();
            $( "#unlock_editor_span").hide();
            if($(this).val() ==0){
                $(".new_resend_name").val('<?=date("m/d/Y h:ia");?>');
            }else{
                $(".new_resend_name").val('');
                $(".no_campaign").hide();
                //$(".new_resend_name").prop('disabled', true);
            }

            $('#messageFromName').prop('disabled', false); 
            $('#messageFromEmail').prop('disabled', false); 
            $('#messageSubject').prop('disabled', false);
            $('#templateSelect').prop('disabled', false);
            $('.is_templateSelect_disable').hide();
            $( "#emailCustom" ).prop( "checked", false );
            $( "#emailCC" ).prop( "checked", false );
            $( "#emailCustom" ).trigger('change');
            $( "#templateSelect" ).trigger('change');
            
            $('#emailCC').prop('disabled', false);
            $('#emailCustom').prop('disabled', false);
            $(".userClassCheckbox").prop("disabled", false);
            $('#expired').prop("disabled", false);
            tinymce.get("message").mode.set("design");
            $.uniform.update();
           
       }else{
            $('.new_resend_name_span').hide();
            $( "#unlock_editor_span").show();
            $('.new_resend_name').removeClass('error');
            $.ajax({
            url: '<?php echo site_url('ajax/get_admin_resend_details') ?>',
            type: "POST",
            data: {
                "resend_id": $(this).val(),
               
            },
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    //refresh frame
                   
                   $('#messageSubject').val(data.subject);
                   $('#messageSubject').prop('disabled', true);
                   $('#templateSelect').prop('disabled', true);
                   $('.is_templateSelect_disable').css('display','block');

                   if(data.expired){
                        $('#expired').val(data.expired);
                   }

                   //$('.userClassCheckbox').
                   $(".userClassCheckbox").prop("checked", false);

                   if(data.user_class){
                       for($i=0;$i<data.user_class.length;$i++){
                            $("input[name='userClass[]'][value='" + data.user_class[$i] + "']").prop('checked', true);
                       }
                   
                   }
                   $(".userClassCheckbox").prop("disabled", true);
                   $('#expired').prop("disabled", true);
                   if(data.email_cc==1){
                        $( "#emailCC" ).prop( "checked", true );
                        $('#emailCC').prop('disabled', true);
                        $.uniform.update();
                   }else{
                        $( "#emailCC" ).prop( "checked", false );
                        $('#emailCC').prop('disabled', true);
                        $.uniform.update();
                   }
                   

                   if(data.custom_sendor==1){
                        $( "#emailCustom" ).prop( "checked", true );
                        //$('#emailCustom').prop('disabled', true);

                        $.uniform.update();
                        
                        $('#messageFromName').val(data.custom_sendor_name);
                        $('#messageFromEmail').val(data.custom_sendor_email);
                   }else{
                        $( "#emailCustom" ).prop( "checked", false );
                        $('#emailCustom').prop('disabled', true);
                        $.uniform.update();
                        $('#messageFromName').val('');
                        $('#messageFromEmail').val('');
                   }
                   $( "#emailCustom" ).trigger('change');
                   
                   $('.new_resend_name').val(data.resend_name);
                   $('.new_resend_name').prop('disabled', true);
                   $('#messageFromName').prop('disabled', true);
                   $('#messageFromEmail').prop('disabled', true);
                   //$('#message').val(data.email_content);
                   //CKEDITOR.instances.message.setData(data.email_content);
                   tinymce.get("message").setContent(data.email_content);
                   tinymce.get("message").mode.set("readonly");
                   //CKEDITOR.instances.message.setReadOnly(true);
                   
                } else {
                    if (data.error) {
                        alert("Error: " + data.error);
                    } else {
                        alert('An error has occurred. Please try again later!')
                    }
                }
            }
        });
            
       }
    });
        
    
    $('#unlock_editor').click( function(event) {
        if($(this).prop("checked") == true){
            $("#resendSelect").val(0);
            $('#templateSelect').prop('disabled', false);
            $('#messageSubject').prop('disabled', false);
            
            $('.is_templateSelect_disable').hide();
            $( "#emailCustom" ).prop( "checked", false );
            $( "#emailCC" ).prop( "checked", false );
            $('#expired').prop("disabled", false);
            
            $('#emailCC').prop('disabled', false);
            $('#emailCustom').prop('disabled', false);
            $(".userClassCheckbox").prop("disabled", false);
            
            tinymce.get("message").mode.set("design");
            $.uniform.update();
        }else{
            $("#resendSelect").trigger('change');
        }
           
    });
    $('body').click( function(event) {

     var $trigger = $("#groupAction");
      if('groupAction' !== event.target.id && !$trigger.has(event.target).length){
        
                $(".groupActionsContainer").hide();

       
        
     }
       
       
   });


// swal popup for admin panel view notes
   $(".btn-notes, .view-notes").live('click', function () {
        var id = $(this).data('value-id');
        var frameUrl = '<?php echo site_url('account/notes/company') ?>/' + id;
        $("#notesFrame").attr('src', frameUrl);
        $("#relationId").val(id);
        $('#notesFrame').load(function () {
           var notes_content =  $("#notes").html();
           notes_content = notes_content.toString()

           notes_content = notes_content.replace(new RegExp('{add-note}', 'g'), 'add-note');
           notes_content = notes_content.replace(new RegExp('{noteText}', 'g'), 'noteText');
           notes_content = notes_content.replace(new RegExp('notesFrame', 'g'), 'newNotesFrame');

            swal({
                    title: "",
                    html:  notes_content,
                        showCancelButton: false,
                        confirmButtonText: '<i class="fa fa-check-circle "></i> Ok',
                        cancelButtonText: "Cancel",
                        dangerMode: false,
                        width:700,
                        showCloseButton: true,
                        onOpen:  function() {

                            $('.swal2-modal').attr('id','proposal_notes_popup');
                            setTimeout(function(){
                                $('#noteText').focus();
                            },200);
                        }
                    }).then(function (result) {
                    }).catch(swal.noop)
        });
        return false;
    });

    $(".add-notes-popup-btn").live('click', function (e) {
        e.preventDefault();

        $('#add-note').submit();
        return false;
    });

    $(document).on('submit', "#add-note", function (e) {

        e.preventDefault();
        var request = $.ajax({
            url: '<?php echo site_url('ajax/addNote') ?>',
            type: "POST",
            data: {
                "noteText": $("#noteText").val(),
                "noteType": 'company',
                "relationId": $("#relationId").val()
            },
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    //refresh frame
                    $("#noteText").val('');
                    $('#newNotesFrame').attr('src', $('#notesFrame').attr('src'));
                    $('.hasNoNotes[data-value-id="' + $("#relationId").val() + '"]').hide();
                    $('.hasNotes[data-value-id="' + $("#relationId").val() + '"]').show();
                } else {
                    if (data.error) {
                        alert("Error: " + data.error);
                    } else {
                        alert('An error has occurred. Please try again later!')
                    }
                }
            }
        });

        return false;
    });

    function notes_tooltip() {

        $(".comapny_table_notes_tiptip").tipTip({   delay :200,
                maxWidth : "400px",
                context : this,
                defaultPosition: "right",
                content: function (e) {

                setTimeout( function(){
                    currentXhr = $.ajax({
                                url: '<?php echo site_url('ajax/getTableNotes') ?>',
                                type:'post',
                                data:{relationId:notes_tiptip_company_id,type:'company'},
                                cache: false,
                                success: function (response) {
                                    $('#tiptip_content').html(response);
                                    //console.log('ffffggg')
                                }
                            });
                        },200);
                            return 'Loading...';
                        }
            });
};

$(document).on('mouseenter', ".comapny_table_notes_tiptip", function () {
    if(currentXhr && currentXhr.readyState != 4){
        currentXhr.abort();
    }
    notes_tiptip_company_id = $(this).data('value-id');
    return false;
});
</script>
