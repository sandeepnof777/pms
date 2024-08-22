<?php $this->load->view('global/header-admin'); ?>

<style>

.reload_table span{
            padding: 4px!important;
            line-height: 12px!important;
        }
.materialize .row .col{
            padding: 0 .25rem!important;
        }
        #summary_popup #cke_email_content .cke_bottom{
            display:none
        }
        #summary_popup .swal2-confirm {
            float: right;
        }
        #summary_popup h2 {
            font-size: 24px!important;
        }
        #cke_email_content .cke_reset_all{
            display:none
        }
        .filter_info_icon:hover{color: #25AAE1!important;}
        .s2custom{
            width: 14.28%;
            margin-left: auto;
            left: auto;
            right: auto;
        }
        .mail_count_tab {
            float: left;
            font-size: 14px;
            color: #444444;
            font-weight: bold;
        }
        #campaignProposalsContainer .card.highlightedCard .mail_count_tab {
            color: #fff !important;
        }
        #campaignProposalsContainer .card-content strong i {
            width: 18px;
        }
        #campaignProposalsContainer .card-action {
            padding: 0 5px 3px 27px;
            
        }
        #showEmailContent{margin-right: 0px;}
</style>
<div id="content" class="clearfix" style="padding-top:5px">

        <input type="hidden" id="campaignEmailFilter" value="<?php echo $campaignEmailFilter; ?>"/>
        <input type="hidden" id="campaignEmailContent" value="<?php echo htmlentities($resend->getEmailContent()); ?>"/>
        <div class="materialize expanded" id="campaignProposalsContainer">
            <div class="row">
                <div class="col s12">
                    <p class="campaignProposalsHeading">
                    
                        <a href="#" class="toggleProposalCampaignDetails"></a>
                        <span class="campaignProposalsCreated"><strong>Sent:</strong> 
                        <?php //echo $resend->getCreated()->format('m/d/y g:ia') ?>
                        <?php 
                               $createDate = $resend->getCreated()->format('m/d/y g:ia');
                               echo date('m/d/y g:ia', strtotime($createDate) + TIMEZONE_OFFSET);
                        ?>

                       </span>
                        <a href="javascript:void(0);"  style="float:right;margin-right:10px;" class="blue-button reload_table tiptip btn" title="Reload Stats"><i class="fa fa-refresh" style="font-size:14px;"></i></a>
                        <?php if($resendStats['failed_count']>0){?>
                            <span class="failed_top_icon tiptipleft right" style="display: none;cursor:pointer;border-bottom: none;" title="<?=$resendStats['failed_count'];?> Lead email failed to send. Click to view"><img style="margin-top: 3px;margin-right: 8px;"  src="/3rdparty/icons/warning-sign.png"></span>
                        <?php } ?>
                        
                        <i class="fa fa-fw fa-envelope"></i> Admin Campaign: <span style="color: #a09b9b;">
                        <?php //echo $resend->getResendName(); ?>
                        <?php 
                              $nameResend = $resend->getResendName();
                              $parts = explode("|", $nameResend);
                              $datePart = isset($parts[1]) ? $parts[0]."| ".date('m/d/y g:ia', strtotime(trim($parts[1])) + TIMEZONE_OFFSET) :$parts[0];
                              echo $datePart;                      
                        ?>

                         </span> 
                        
                    </p>
                    
                </div>
            </div>
            <hr/>
            <div class="row" id="resend_reload_btn" style="margin-bottom: 5px;margin-top: 8px;">
                <div class="col s12">
                
                    
                    <?php if(count($child_resends)>0){ 
                                 $resend_show = 'display:block!important;';
                            }else{
                                $resend_show = 'display:none!important;';
                            }

                    ?>



                    <span style="float:right" >
                        <select id="child_resend" style = "<?php echo $resend_show;?> padding: 2px;border: 1px solid;border-radius: 3px;height:auto;font: caption;" class="dont-uniform" >
                        <option value="<?=$resend->getId();?>"><?=$resend->getResendName();?></option>
                    <?php 
                        foreach($child_resends as $child_resend){
                            echo '<option value="'.$child_resend->id.'">'.$child_resend->resend_name.'</option>';
                        }
                     ?>
                    </select></span>
                </div>
            </div>
            <div id="campaignProposalsContent">
                <div class="row">

                    <div class="col s2custom">
                        <div class="card statCard<?php if (!$campaignEmailFilter) { echo ' highlightedCard'; } ?>">
                            <div class="card-content">
                                <strong><i class="fa fa-fw fa-envelope"></i> Sent: </strong><span class="total_sent"> <?php echo $resendStats['sent'] ?></span>
                            </div>
                            <div class="card-action" style="padding: 0 5px 3px 28px;">
                                <a href="<?php echo site_url('proposals/resend/' . $resend->getId()) ?>" data-filter="">View All</a>
                            </div>
                        </div>
                    </div>

                    <div class="col s2custom">
                        <div class="card statCard<?php if ($campaignEmailFilter == 'delivered') { echo ' highlightedCard'; } ?>">
                            <div class="card-content">
                                <strong><i class="fa fa-fw fa-envelope-square"></i> Delivered: </strong>
                            </div>
                            <div class="card-action">
                                <a href="<?php echo site_url('proposals/resend/' . $resend->getId() . '/delivered') ?>" data-filter="delivered">
                                    <span class="total_delivered mail_count_tab"> <?php echo $resendStats['delivered'] ?></span>
                                    <span class="total_delivered_percent" style="float:right"><?php echo $resendStats['delivered'] ? round(($resendStats['delivered'] / $resendStats['sent']) * 100) : '0'; ?>%</span>
                                    
                                </a>
                            </div>
                        </div>
                    </div>

                    

                    <div class="col s2custom">
                        <div class="card statCard<?php if ($campaignEmailFilter == 'opened') { echo ' highlightedCard'; } ?>">
                            <div class="card-content">
                                <strong><i class="fa fa-fw fa-envelope-open"></i> Opened:</strong>
                            </div>
                            <div class="card-action">
                                <a href="<?php echo site_url('proposals/resend/' . $resend->getId() . '/opened') ?>" data-filter="opened">
                                    <span class="total_opened mail_count_tab"> <?php echo $resendStats['opened'] ?></span>
                                    <span class="total_opened_percent" style="float:right"><?php echo $resendStats['opened'] ? round(($resendStats['opened'] / $resendStats['sent']) * 100) : '0'; ?>%</span>
                                    
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col s2custom">
                        <div class="card statCard<?php if ($campaignEmailFilter == 'clicked') { echo ' highlightedCard'; } ?>">
                            <div class="card-content">
                                <strong><i class="fa fa-fw fa-envelope"></i> Clicked:</strong>
                            </div>
                            <div class="card-action">
                                <a href="<?php echo site_url('proposals/resend/' . $resend->getId() . '/clicked') ?>" data-filter="clicked">
                                <span class="total_clicked mail_count_tab" ><?php echo $resendStats['clicked'] ?></span>
                                <span class="total_clicked_percent" style="float:right"><?php echo $resendStats['clicked'] ? round(($resendStats['clicked'] / $resendStats['sent']) * 100) : '0'; ?>%</span>
                                   
                                </a>
                            </div>
                        </div>
                    </div>

                    <div class="col s2custom">
                        <div class="card statCard<?php if ($campaignEmailFilter == 'unopened') { echo ' highlightedCard'; } ?>">
                            <div class="card-content">
                                <strong><i class="fa fa-fw fa-envelope"></i> Unopened:</strong>
                            </div>
                            <div class="card-action">
                                <a href="<?php echo site_url('proposals/resend/' . $resend->getId() . '/unopened') ?>" data-filter="unopened">
                                    <span class="total_unopened mail_count_tab" ><?php echo $resendStats['unopened'] ?></span>
                                    <span class="total_unopened_percent" style="float:right"><?php echo $resendStats['unopened'] ? round(($resendStats['unopened'] / $resendStats['sent']) * 100) : '0'; ?>%</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col s2custom">
                        <div class="card statCard<?php if ($campaignEmailFilter == 'bounced') { echo ' highlightedCard'; } ?>">
                            <div class="card-content">
                                <strong><i class="fa fa-fw fa-exclamation-triangle"></i> Bounced:</strong>
                            </div>
                            <div class="card-action">
                                <a href="<?php echo site_url('proposals/resend/' . $resend->getId() . '/bounced') ?>" data-filter="bounced">
                                    <span class="total_bounced mail_count_tab"> <?php echo $resendStats['bounced'] ?></span>
                                    <span class="total_bounced_percent" style="float:right"><?php echo $resendStats['bounced'] ? round(($resendStats['bounced'] / $resendStats['sent']) * 100) : '0'; ?>%</span>
                                    
                                </a>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col s2custom">
                        <div class="card">
                            <div class="card-content showEmailContent">
                                <a href="#" class="showEmailContent" id="viewEmailIcon">
                                    <strong><i class="fa fa-fw fa-pencil-square-o""></i> Summary</strong>
                                </a>
                            </div>
                            <div class="card-action">
                                <a href="#" class="showEmailContent" id="showEmailContent">View Email</a>
                            </div>
                        </div>
                    </div>


                </div>
            </div>

        </div>
        <?php if($this->uri->segment(4)!='failed'){ 
                                if($resendStats['failed_count']>0){?>
                                    <p class="adminInfoMessageWarning check_failed_count_msg" ><i class="fa fa-fw fa-info-circle"></i> <?php echo $resendStats['failed_count'] ?> Admin emails failed to send in this campaign. <a href="/admin/resend/<?=$resend->getId();?>/failed">View Emails</a><span class="close_failed_info_batch"><i class="fa fa-fw fa-close"></i></span></p>
                                <?php }?>    
                        <?php }else{?> 
                            <p class="adminInfoMessageWarning  failed_count_msg" style="display: none;"><i class="fa fa-fw fa-info-circle"></i> <?php echo $resendStats['failed_count'] ?> Admin emails failed to send in this campaign. <a href="#" class="reload_failed" data-filter="failed">View Emails</a> <span class="close_failed_info_batch"><i class="fa fa-fw fa-close"></i></span></p>
                            <p class="adminInfoMessageWarning view_admin_msg "  ><i class="fa fa-fw fa-info-circle"></i> You are viewing the Admin emails that failed to send in the campaign. Click the buttons above to see the sent email.</p>
                        <?php }?>
        <div class="clearfix"></div>


    <div style="height:35px;width:966px">
    <!---Start Filter button---->
        <div class="materialize" style="float: left;font-style: initial;position: relative;top: 4px;left: 5px;white-space: nowrap;">
                        
        
                   



                        <div class="m-btn groupAction tiptip groupActionsButton" title="Carry out actions on selected proposals"
                            id="typeGroupAction" style="display:none">
                            <i class="fa fa-fw fa-check-square-o"></i> Group Actions
                            <div class="materialize groupActionsContainer" style="width:300px">
                                <div class="collection groupActionItems">
                                    
                                    <a href="javascript:void(0);"  class="deleteCompanies collection-item iconLink">
                                        <i class="fa fa-fw fa-trash"></i> Delete
                                    </a>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
    <!---End Filter button---->
       
    </div>

    <div class="widthfix">
        <div class="content-box">
            <div class="box-header centered" style="position: relative;">
            <div id="proposalsTableLoader" style="width: 150px; position:absolute;right:20px; display: none; ">
                    <img src="/static/loading-bars.svg" />
                </div>
                <!-- <div style="position: absolute; left: 10px; top: 6px;">
                    <a class="box-action bulkAction changeStatus" style="float: left; margin: 0 5px 0 0; display: none;" href="#">Change Status</a>
                    <a class="box-action bulkAction deleteCompanies" style="float: left; margin: 0 5px 0 0; display: none;" href="#">Delete</a>
                    <a class="box-action bulkAction emailCompanies" style="float: left; margin: 0 5px 0 0; display: none;" href="#">Send Email</a>
                </div> -->
                Campaign Users
                <div style="position: absolute; right: 10px; top: 6px;">
                    
                </div>
            </div>
            <div class="box-content">
                <table cellpadding="0" cellspacing="0" border="0" class="dataTables-admin display">
                    <thead>
                    <tr>
                       <td>Company</td>
                        <td>Users</td>
                        <td>Email</td>
                        <td>Delivered</td>
                        <td>Opened</td>
                        <td>Bounced</td>
                        <td>Clicked</td>
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

var adminTable
var resend_id = '<?=$resend->getId();?>';
$(document).ready(function () {
    
    var failed_info = localStorage.getItem("failed_client_info_batch_hide_"+resend_id);
    if(failed_info){
        $('.check_failed_count_msg').hide();
        $('.failed_top_icon').show();
    }else{
        $('.failed_top_icon').hide();
    }
    function getFilterValue() {
        return $("#campaignEmailFilter").val();
    }

     adminTable = $('.dataTables-admin').on('processing.dt', function (e, settings, processing) {
        if (processing) {
            $("#proposalsTableLoader").show();
        } else {
            $("#proposalsTableLoader").hide();
        }
   }).DataTable({
        "bServerSide": true,
        "ajax": {
            "url": "<?php echo site_url('admin/companiesResendTableData?action=resend'); ?>",
            "data": function (d) {
                return $.extend( {}, d, {
                        "type ": getFilterValue()
                    })
            },
        },
        "aoColumns": [
            null, //0
            null, //1
            null, //2
            null, //3
            null, //4
            null, //5
            null, //6
        ],
        "sorting": [
            [1, "desc"]
        ],
        "bJQueryUI": true,
        "bAutoWidth": true,
        "bPaginate" : true,
        "sPaginationType": "full_numbers",
        "aLengthMenu": [
            [10, 25, 50, -1],
            [10, 25, 50, "All"]
        ],
        "bStateSave": true,
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

//     var template_editor = CKEDITOR.replace('message', {
// //        toolbar: 'Minimum',
//         height: 400
//     });

    tinymce.init({
                        selector: "textarea#message",
                        menubar: false,
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
        $("#resend-proposals").dialog('open');
        return false;
    });

    function get_resend_lists(){

    $.ajax({
        url: '<?php echo site_url('ajax/get_admin_resend_lists') ?>',
        type: "GET",
        
        dataType: "json",
        success: function (data) {
            console.log(data)
            var html = '<option value="">Select Resend Campaign</option><option value="0">New</option><option value="-1">No Campaign</option>';
            for($i=0;$i<data.length;$i++){
                html +='<option value="'+data[$i].id+'">'+data[$i].resend_name+'</option>'
            }
            if(data.length){
                $('.campaign_btn').show();
            }
            console.log(html);
            $("#resendSelect").html(html);
        }
    });

}

    $("#resend-proposals").dialog({
        width: 800,
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
                            var resendText = data.count + ' emails were sent';
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
                    get_resend_lists()
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
        autoOpen: false
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
                tinymce.get("message").setContent(data.templateBody)
                //CKEDITOR.instances.message.setData(data.templateBody);
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
});
</script>
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
<div id="resend-proposals" title="Send Email to Selected Companies Users" style="padding: 0 !important;">
    <form action="<?php echo site_url('admin/sendEmail') ?>" method="post">
        <table class="boxed-table" style="width: 100%;" cellpadding="0" cellspacing="0">
            <tbody>
            <tr class="even">
                <td width="150">From Name</td>
                <td><input type="text" name="fromName" id="fromName" class="text" value="<?php echo $this->settings->get('from_name') ?>"/></td>
            </tr>
            <tr>
                <td valign="top">From Email</td>
                <td><input type="text" name="fromEmail" id="fromEmail" class="text" value="<?php echo $this->settings->get('from_email') ?>"/></td>
            </tr>

            <tr class="even">
                <td width="150"><span style="padding-right: 13px;font-weight:bold">Choose Campaign:</span></td>
                <td><select name="resendId" id="resendSelect" >
                <option value="">Select Resend Campaign</option>
                <option value="0">New</option>
                <option value="-1">No Campaign</option>
                <?php
                foreach ($resends as $resend2) {
                    /* @var $template \models\ClientEmailTemplate */
                    ?>
                    <option value="<?php echo $resend2->id; ?>"><?php echo $resend2->resend_name; ?></option>
                    <?php
                }
                ?>
            </select></td>
            </tr>
            <tr>
                <td valign="top"><label style="text-align: left;font-weight:bold" class="no_campaign">Campaign Name:</label></td>
                <td><input type="text" class="text new_resend_name no_campaign" name="new_resend_name"/></td>
            </tr>

            <tr class="even">
                <td valign="top">
                    User Classes <br/>
                    <a href="#" id="selectAllUserClasses">All</a> | <a href="#" id="selectNoneUserClasses">None</a>
                </td>
                <td>
                    <p class="clearfix">
                        <label class="admin-class-label">&nbsp;Main Admin <input checked="checked" type="checkbox" name="userClass[]" class="userClassCheckbox" value="0"/></label>
                        <label class="admin-class-label">&nbsp;Company Admin <input checked="checked" type="checkbox" name="userClass[]" class="userClassCheckbox" value="1"/></label>
                        <label class="admin-class-label">&nbsp;Full Access <input checked="checked" type="checkbox" name="userClass[]" class="userClassCheckbox" value="2"/></label>
                        <label class="admin-class-label">&nbsp;Branch Manager <input checked="checked" type="checkbox" name="userClass[]" class="userClassCheckbox" value="3"/></label>
                        <label class="admin-class-label">&nbsp;User <input checked="checked" type="checkbox" name="userClass[]" class="userClassCheckbox" value="4"/></label>
                        <label class="admin-class-label">&nbsp;Secretary Account <input checked="checked" type="checkbox" name="userClass[]" class="userClassCheckbox" value="5"/></label>
                    </p>
                </td>
            </tr>
            <tr>
                <td>Expired Accounts?</td>
                <td>
                    <select name="expired" id="expired">
                        <option value="1">Only Active Users</option>
                        <option value="2">Only Expired Users</option>
                        <option value="3">Active and Expired Users</option>
                    </select>
                </td>
            </tr>
            <tr class="even">
                <td width="150">Email Template</td>
                <td><select id="templateSelect">
                        <?php
                        foreach ($emailTemplates as $template) {
                            /* @var $template \models\ClientEmailTemplate */
                            ?>
                            <option data-template-id="<?php echo $template->getTemplateId(); ?>"><?php echo $template->getTemplateName(); ?></option>
                        <?php
                        }
                        ?>
                    </select></td>
            </tr>
            <tr>
                <td width="150">Field Codes</td>
                <td>
                    <select id="templateFields">
                        <option value="">- Select a field</option>
                        <?php
                        foreach ($templateFields as $k => $v) {
                            ?>
                            <option value="<?php echo $k; ?>"><?php echo $v; ?></option>
                        <?php
                        }
                        ?>
                    </select>

                    <input type="text" class="text" id="fieldCode" style="width: 200px; ;float: right"/>
                </td>
            </tr>
            <tr>
                <td>Subject</td>
                <td><input class="text" type="text" id="messageSubject" style="width: 300px;"></td>
            </tr>
            <tr class="even">
                <td>Message</td>
                <td></td>
            </tr>
            <tr>
                <td colspan="2">
                    <textarea id="message" name="message">Loading Content...</textarea>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
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
<?php $this->load->view('global/footer'); ?>
<script>
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
        $(".no_campaign").show();
       if($(this).val() <1){
            $('.new_resend_name_span').show();
            
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
            tinymce.get("message").mode.set("design");
            //CKEDITOR.instances.message.setReadOnly(false);
            $.uniform.update();
           
       }else{
            $('.new_resend_name_span').hide();
            $('.new_resend_name').removeClass('error');
            $.ajax({
            url: '<?php echo site_url('ajax/get_admin_resend_details') ?>',
            type: "POST",
            data: {
                "resend_id": $(this).val(),
               
            },
            dataType: "json",
            success: function (data) {
                console.log(data)
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
                           console.log(data.user_class[$i]);
                            $("input[name='userClass[]'][value='" + data.user_class[$i] + "']").prop('checked', true);
                       }
                   
                   }
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
                        $('#emailCustom').prop('disabled', true);

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
                    $('#messageFromName').prop('disabled', true); 
                   $('#messageFromEmail').prop('disabled', true); 
                   //$('#message').val(data.email_content);
                   //CKEDITOR.instances.message.setData(data.email_content);
                   //CKEDITOR.instances.message.setReadOnly(true);
                   tinymce.get("message").setContent(data.email_content);
                   tinymce.get("message").mode.set("readonly");
                   
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

    // Toggle the card links when clink
    $(".statCard").click(function() {
                    // Handle highlighting
                    if(!$('.failed_top_icon').is(":visible")){
                        $('.failed_count_msg').show();
                    }
                    
                    $('.view_admin_msg ').hide();
                    $(".card").removeClass('highlightedCard');
                    $(this).addClass('highlightedCard');
                    // Set the filter value
                    $("#campaignEmailFilter").val($(this).find('.card-action a').data('filter'));
                    $("#campaignEmailsFilterCount").text($(this).find('.card-action a').data('filter') ? $(this).find('.card-action a').data('filter') : 'All');
                    // Reload the table
                    adminTable.ajax.reload();

                    return false;
                });
                $(".reload_failed").click(function() {
                    // Handle highlighting
                    $('.failed_count_msg').hide();
                    $('.view_admin_msg').show();
                    $(".card").removeClass('highlightedCard');
                    
                    // Set the filter value
                    $("#campaignEmailFilter").val('failed');
                    
                    // Reload the table
                    oTable.ajax.reload();

                    return false;
                });
                $(".close_failed_info_batch").click(function() {
                    if(hasLocalStorage){
                        localStorage.setItem("failed_lead_info_batch_hide_"+resend_id, 1);
                    }
                    $('.check_failed_count_msg').hide();
                    $('.failed_count_msg').hide();
                    $('.failed_top_icon').show();
                });

                $(".failed_top_icon").click(function() {
                    if(hasLocalStorage){
                        localStorage.setItem("failed_lead_info_batch_hide_"+resend_id,'');
                    }
                    if($("#campaignEmailFilter").val()=='failed'){
                        $('.check_failed_count_msg').hide();
                        $('.failed_count_msg').hide();
                        $('.view_admin_msg').show();
                    }else{
                        $('.check_failed_count_msg').show();
                        $('.failed_count_msg').show();
                        $('.view_admin_msg').hide();
                    }
                   
                    $('.failed_top_icon').hide();
                });

        $(".showEmailContent").click(function() {

            var resend_id = $('#child_resend').val();
            console.log(resend_id);
            $.ajax({
                        url: '/ajax/get_admin_resend_counts_details/',
                        type: "POST",
                        dataType: "json",
                        data: {
                            "resend_id": resend_id,
                        },

                        success: function (data) {
                            if (data.success) {

                                var email_content = data.email_content;
                    var subject = data.subject;
                    var sent_time = data.created_at;
                    var custom_sender = data.custom_sendor;
                    if(data.filters){
                        var admin_filters = JSON.parse(data.filters);
                        admin_filters = admin_filters[0]
                    }else{
                        var admin_filters =''
                    }
                    var custom_sender_details = "Admin Owner";
                    if(custom_sender=='1'){
                        var custom_sender_details = data.custom_sendor_name+' | '+data.custom_sendor_email;
                    }

                var filter_text = "";
                var filter_count =0;
                if(admin_filters){
                        console.log(admin_filters);
                    if(admin_filters.pResendType){
                            filter_count++;
                            filter_text += "<p><strong style='text-align:left;'>Resend :</strong>"+admin_filters.pResendType+"</p><br/>";
                    }    
                    var user_class_name = ['Main Admin','Company Admin','Full Access','Branch Manager','User','Secretary Account']
                        
                        if(admin_filters.user_class){
                            filter_count++;
                            var temp_text ='';
                            if(admin_filters.user_class.length == user_class_name.length){
                                 temp_text ='All';
                            }else{
                                for($i=0;$i<admin_filters.user_class.length;$i++){
                                    temp_text += user_class_name[admin_filters.user_class[$i]]+'<br/>';
                                }
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>User Class:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
                        }
                        
                        var expired_name = ['','Only Active Users','Only Expired Users','Active and Expired Users']
                        if(admin_filters.expired){
                            filter_count++;
                            
                            filter_text +="<p><strong style='text-align:left;'>Expired:</strong>"+expired_name[admin_filters.expired]+"</p><br/>";
                        }
                        
                        if(admin_filters.statusFilter){
                            filter_count++;
                            
                            filter_text +="<p><strong style='text-align:left;'>Status:</strong>"+admin_filters.statusFilter+"</p><br/>";
                        }
                        
                        
                        
                        if(admin_filters.expiryFilter){
                            filter_count++;
                            
                            filter_text +="<p><strong style='text-align:left;'>Expiry:</strong>"+admin_filters.expiryFilter+"</p><br/>";
                        }
                        
                        
                    }


                    if(filter_count==0){
                        var filter_text_details ='<p style="margin-top: 6px;text-align:right">No Filter Applied</p>';
                    }else{
                        var filter_text_details ='<p style="margin-top: 6px;text-align:right">'+ filter_count+' Filters Applied <a class="tiptipleft filter_info_icon" style="cursor:pointer;" title="'+filter_text+'"><i class="fa fa-question-circle"></i></a></p>'
                    }



                swal({
                title: "Campaign Summary",
                html: '<table class="boxed-table pl-striped" style="font-size: 16px;" width="100%" cellpadding="0" cellspacing="0">'+
                            '<tr><td style="width:70%"><label  style="width: 70px;text-align: left;"> Subject:</label><p style="padding:7px;text-align:left">'+subject+'</p></td><td style="width:30%"><label  style="width: 65px;text-align: left;"> Sent:</label><p style="margin-top:7px;text-align:right">'+sent_time+'</p></td></tr>'+
                            '<tr><td style="width:70%"><label  style="width: 70px;text-align: left;"> Sender:</label><p style="padding:7px;text-align:left">'+custom_sender_details+'</p></td><td style="text-align: left;width:30%"><label  style="width: 65px;text-align: left;"> Filters:</label>'+filter_text_details+'</td></tr>'+
                        
                            '<tr><td colspan="2"><textarea  rows="15" class="email_content" name="email_content">'+email_content+'</textarea></td>'+
                            '</tr></table></form>',
                   
                    showCancelButton: false,
                    confirmButtonText: '<i class="fa fa-check-circle "></i> Ok',
                    cancelButtonText: "Cancel",
                    dangerMode: false,
                    width:800,
                    showCloseButton: true,
                    onOpen:  function() {
                        initTiptip(); 
                        //CKEDITOR.replace( 'email_content',{removePlugins: 'elementspath',readOnly:true,height:300} ); 
                        tinymce.init({selector: ".email_content",relative_urls : false,remove_script_host : false,convert_urls : true,menubar: false,toolbar : false,paste_as_text: true,height:'300',readonly : true}) 
                        $('.swal2-modal').attr('id','summary_popup')  
                    }
                }).then(function (result) {
                
                }).catch(swal.noop)

            } else {
                    swal("Error", "An error occurred Please try again");
                    return false;
                }


            },
            error: function (jqXhr, textStatus, errorThrown) {
                swal("Error", "An error occurred Please try again");
                console.log(errorThrown);
            }
        })

    });


       
            $(".reload_table").click(function () {
                $("#child_resend").trigger('change');
                $( this ).find('i').addClass( 'fa-spin' );

                var $el = $(this);
                setTimeout(function() { $el.find('i').removeClass( 'fa-spin' ); }, 1000);
            });  

            $("#child_resend").change(function () {
                $.ajax({
                    url: '/ajax/change_admin_child_resend',
                    type: "POST",
                    dataType: "json",
                    data: {
                        "child_resend_id": $(this).val(),
                    },

                    success: function (data) {
                        if (!data.error) {
                            adminTable.ajax.reload(null, false);
                            $('.total_sent').text(' '+data.resendStats.sent);
                            $('.total_delivered').text(' '+data.resendStats.delivered);
                            $('.total_bounced').text(' '+data.resendStats.bounced);
                            $('.total_opened').text(' '+data.resendStats.opened);
                            $('.total_unopened').text(' '+data.resendStats.unopened);
                            $('#email-preview').html(data.email_content);
                           
                            var total_delivered_percent =  data.resendStats.delivered ? Math.round((data.resendStats.delivered / data.resendStats.sent) * 100) : '0'; 
                            var total_unopened_percent =  data.resendStats.unopened ? Math.round((data.resendStats.unopened / data.resendStats.sent) * 100) : '0';
                            var total_bounced_percent =  data.resendStats.bounced ? Math.round((data.resendStats.bounced / data.resendStats.sent) * 100) : '0'; 
                            var total_opened_percent =  data.resendStats.opened ? Math.round((data.resendStats.opened / data.resendStats.sent) * 100) : '0'; 
                            console.log(total_unopened_percent);
                            $('.total_delivered_percent').text(total_delivered_percent+'%');
                            $('.total_bounced_percent').text(total_bounced_percent+'%');
                            $('.total_opened_percent').text(total_opened_percent+'%');
                            $('.total_unopened_percent').text(total_unopened_percent+'%');
                            
                        } else {
                            swal("Error", "An error occurred Please try again");
                            return false;
                        }
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        swal("Error", "An error occurred Please try again");
                        console.log(errorThrown);
                    }
                })

            });



        $(document).on('click', ".resend_upopened", function () {

        var resend_id = $(this).attr('data-val');
        $.ajax({
            url: '/ajax/get_admin_resend_counts_details/',
            type: "POST",
            dataType: "json",
            data: {
                "resend_id": resend_id,
            },

            success: function (data) {
                if (data.success) {
                    if(data.total_resending>0){
                        $("#resend-leads-new").dialog('open');
        
                    }else{
                        swal('','This Campaign has no Unopened Emails!');
                        return false;
                    }
                   $('.new_resend_name').val(data.resend_name);
                   $('#messageSubject').val(data.subject);
                   $('#resendSelect').val(resend_id);
                   $('#totalNum').text(data.total_leads);
                   $('#resendNum').text(data.total_resending);
                   if(data.total_not_sent>0){
                      $('.if_admin_status_change').show();
                      $('#changeStatusNum').text(data.total_not_sent);
                   }else{
                    $('.if_admin_status_change').hide();
                   }
                   
                    
      
      // $('.is_templateSelect_disable').css('display','block');
       if(data.email_cc==1){
            $( "#emailCC" ).prop( "checked", true );
            
            $.uniform.update();
       }else{
            $( "#emailCC" ).prop( "checked", false );
           
            $.uniform.update();
       }
       

       if(data.custom_sendor==1){
            $( "#emailCustom" ).prop( "checked", true );
            

            $.uniform.update();
            
            $('#messageFromName').val(data.custom_sendor_name);
            $('#messageFromEmail').val(data.custom_sendor_email);
       }else{
            $( "#emailCustom" ).prop( "checked", false );
            
            $.uniform.update();
            $('#messageFromName').val('');
            $('#messageFromEmail').val('');
       }
       $( "#emailCustom" ).trigger('change');
      
        
       $('#message').html(data.email_content);
       //CKEDITOR.instances.message_resend.setData(data.email_content);

                } else {
                    swal("Error", "An error occurred Please try again");
                    return false;
                }


            },
            error: function (jqXhr, textStatus, errorThrown) {
                swal("Error", "An error occurred Please try again");
                console.log(errorThrown);
            }
        })


       

        return false;


});

function get_resend_lists(){

$.ajax({
    url: '<?php echo site_url('ajax/get_admin_child_resend_lists').'/'.$resend->getId() ?>',
    type: "GET",
    
    dataType: "json",
    success: function (data) {
        
        var html = '<option value="<?=$resend->getId();?>"><?=$resend->getResendName();?></option>';
        for($i=0;$i<data.length;$i++){
            html +='<option value="'+data[$i].id+'">'+data[$i].resend_name+'</option>'
        }
        console.log(html);
        $("#child_resend").html(html);
        $("#child_resend").show();
    }
});

}
        
    </script>
