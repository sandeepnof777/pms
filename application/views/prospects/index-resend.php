<?php $this->load->view('global/header'); ?>
    <style>
        .dataTables-prospects {
            table-layout: fixed;
            width: 100% !important;
        }

        .paging_full_numbers {
            width: 500px !important;
        }

        .dataTables_info {
            width: 46% !important;
            clear: none !important;
        }

        #addAtCursorEdit {
            position: absolute;
            margin-top: 1px;
            margin-left: 16px;
        }

        #addAtCursorEdit span {
            padding-top: 2px;
            padding-bottom: 2px;
        }

        #uniform-templateFields span {
            width: 125px !important;
        }

        #uniform-templateFields {
            width: 150px !important;
            margin-left: 41px;
        }

        #uniform-resendSelect span {
            width: 200px !important;
        }

        #uniform-resendSelect {
            width: 225px !important;
        }

        #uniform-templateSelect span {
            width: 200px !important;
        }

        #uniform-templateSelect {
            width: 225px !important;
        }

        .error_editor {

            border: 2px solid #FBC2C4;
        }

        #cke_event_email_content .cke_reset_all {
            display: none
        }

        #email_events_table_info {
            width: 18% !important;
            clear: none !important;
        }

        #newProspectsPopup {
            padding-bottom: 10px;
        }
        .reload_table span{
            padding: 4px!important;
            line-height: 12px!important;
        }
        .s2custom{
            width: 14.28%;
            margin-left: auto;
            left: auto;
            right: auto;
        }
        .mail_count_tab{
            float: left;
            font-size: 14px;
            color: #444444;
            font-weight: bold;
        }
        .materialize .row .col{
            padding: 0 .25rem!important;
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
    <div id="content" class="clearfix">
        <div class="widthfix">

            <input type="hidden" id="delayUI" value="1"/>
            <input type="hidden" id="campaignEmailFilter" value="<?php echo $campaignEmailFilter; ?>"/>
        <input type="hidden" id="campaignEmailContent" value="<?php echo htmlentities($resend->getEmailContent()); ?>"/>
        <div class="materialize expanded" id="campaignProposalsContainer">
            <div class="row">
                <div class="col s12">
                    <p class="campaignProposalsHeading">
                    
                        <a href="#" class="toggleProposalCampaignDetails"></a>
                        <span class="campaignProposalsCreated"><strong>Sent:</strong> <?php echo $resend->getCreated()->format('m/d/y g:ia') ?></span>
                        <a href="javascript:void(0);"  style="float:right;margin-right:10px;" class="blue-button reload_table tiptip btn" title="Reload Stats"><i class="fa fa-refresh" style="font-size:14px;"></i></a>
                        <?php if($resendStats['failed_count']>0){?>
                            <span class="failed_top_icon tiptipleft right" style="display: none;cursor:pointer;border-bottom: none;" title="<?=$resendStats['failed_count'];?> Prospect email failed to send. Click to view"><img style="margin-top: 3px;margin-right: 8px;"  src="/3rdparty/icons/warning-sign.png"></span>
                        <?php } ?>
                        <i class="fa fa-fw fa-envelope"></i> Prospect Campaign: <span style="color: #a09b9b;"><?php echo $resend->getResendName(); ?></span> 
                        
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
                                <a href="<?php echo site_url('prospects/resend/' . $resend->getId()) ?>" data-filter="">View All</a>
                            </div>
                        </div>
                    </div>

                    <div class="col s2custom">
                        <div class="card statCard<?php if ($campaignEmailFilter == 'delivered') { echo ' highlightedCard'; } ?>">
                            <div class="card-content">
                                <strong><i class="fa fa-fw fa-envelope-square"></i> Delivered: </strong>
                            </div>
                            <div class="card-action">
                                <a href="<?php echo site_url('prospects/resend/' . $resend->getId() . '/delivered') ?>" data-filter="delivered">
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
                                <a href="<?php echo site_url('prospects/resend/' . $resend->getId() . '/opened') ?>" data-filter="opened">
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
                                <a href="<?php echo site_url('prospects/resend/' . $resend->getId() . '/clicked') ?>" data-filter="clicked">
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
                                <a href="<?php echo site_url('prospects/resend/' . $resend->getId() . '/unopened') ?>" data-filter="unopened">
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
                                <a href="<?php echo site_url('prospects/resend/' . $resend->getId() . '/bounced') ?>" data-filter="bounced">
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
        <?php if($this->uri->segment(4)!='failed'){ ?>
            <?php if($resendStats['failed_count']>0){?>
                    <p class="adminInfoMessageWarning check_failed_count_msg" ><i class="fa fa-fw fa-info-circle"></i> <?php echo $resendStats['failed_count'] ?> Prospects email failed to send in this campaign. <a href="/prospects/resend/<?=$resend->getId();?>/failed">View Prospects</a><span class="close_failed_info_batch"><i class="fa fa-fw fa-close"></i></span></p>
                <?php }?>    
        <?php }else{?> 
            <p class="adminInfoMessageWarning  failed_count_msg" style="display: none;"><i class="fa fa-fw fa-info-circle"></i> <?php echo $resendStats['failed_count'] ?> Prospects failed to send in this campaign. <a href="#" class="reload_failed" data-filter="failed">View Prospects</a> <span class="close_failed_info_batch"><i class="fa fa-fw fa-close"></i></span></p>
            <p class="adminInfoMessageWarning view_prospects_msg "  ><i class="fa fa-fw fa-info-circle"></i> You are viewing the Prospects that failed to send in the campaign. Click the buttons above to see the sent prospects.</p>
        <?php }?>
            <?php $this->load->view('templates/prospects/table/resend-filters-new'); ?>

            <div class="content-box">
                <div class="box-header">

                    <div id="prospectsTableLoader"
                         style="width: 150px; display: none; position: absolute; left: 421px; top: 8px;">
                        <img src="/static/loading-bars.svg">
                    </div>

                    <?php if (help_box(20)) { ?>
                        <div class="help right tiptip" title="Help"><?php help_box(20, true) ?></div>
                    <?php } ?>
                    Prospects
                    <a class="tiptip box-action" href="<?php echo site_url('account/upload_data') ?>"
                       title="Upload prospects from CSV files" style="margin-left: 10px;">Upload Prospects</a>
                    <a class="tiptip box-action" href="<?php echo site_url('prospects/add') ?>"
                       title="Create a new prospect by filling a form" style="margin-left: 10px;">Add Prospect</a>
                    <a class="box-action tiptip" href="<?php echo site_url('prospects/map') ?>"
                       title="View all prospects on a map">Map</a>


                </div>
                <div class="box-content">
                    <table cellpadding="0" cellspacing="0" border="0" id="dataTables-prospects"
                           class="dataTables-prospects display">
                           <thead>
                        <tr>
                            <td><input type="checkbox" id="prospectMasterCheck"></td>
                            <td style="text-align: center;">Go</td>
                            <td>Date Int</td>
                            <td >Date Created</td>
                            <td>Status</td>
                            <td>Rating Order</td>
                            <td>Rating </td>
                            <td>Business</td>
                            <td>Company</td>
                            <td>Contact Name</td>
                            <td>Contact</td>
                            
                            <td>Owner Text</td>
                            <td>Owner</td>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <form id="selectedProspectsForm" method="post" action="<?php echo site_url('prospects/map'); ?>">
                    </form>
                </div>
            </div>
            <script src="<?= site_url('3rdparty/DataTables-new/datatables.min.js'); ?>"></script>
            <script src="<?= site_url('3rdparty/DataTables-new/DataTables-1.10.20/js/dataTables.jqueryui.min.js'); ?>"></script>
            
            <link rel="stylesheet" type="text/css" href="<?= site_url('3rdparty/DataTables-new/datatables.min.css'); ?>"
                  media="all">

            <div id="datatablesError" title="Error" style="text-align: center; display: none;">
                <h3>Oops, something went wrong</h3>

                <p>We're having a problem loading this page.</p><br/>
                <p>Click to retry, or <a href="mailto:support@<?php echo SITE_EMAIL_DOMAIN; ?>&subject=Support: Help with Table">contact
                        support</a> if this keeps happening.</p>
            </div>

            <div id="change-prospect-business-type" title="Change Prospect Business Type">
                    <p style="font-size: 14px;font-weight: bold;">Prospect - <span class="change-bt-prospect-name"></span></p>
                    <p style="padding-top:10px;">Choose one or many Business Types to assign to the prospects</p><br/>
                    <label >Select Business Type</label> 
                    <input type="hidden" id="business_prospect_id" name="prospectsChangeBusinessTypes">
                    <select  class="dont-uniform prospectBusinessTypeMultiple"  style="width: 64%" name="prospect_business_type[]" multiple="multiple">
                               <?php 
                                    foreach($businessTypes as $businessType){
                                        echo '<option value="'.$businessType->getId().'">'.$businessType->getTypeName().'</option>';
                                    }
                               ?>
                            </select>

                </div>
<script type="text/javascript">

var ui = false;
var resend_id = '<?=$resend->getId();?>';
$(document).ready(function () {
    $('.prospectBusinessTypeMultiple').select2({
                        placeholder: "Select one or many"
                    });
var failed_info = localStorage.getItem("failed_lead_info_batch_hide_"+resend_id);
    if(failed_info){
        $('.check_failed_count_msg').hide();
        $('.failed_top_icon').show();
    }else{
        $('.failed_top_icon').hide();
    }
        // Datatables error Dialog
    $("#datatablesError").dialog({
        width: 500,
        modal: true,
        buttons: {
            Retry: function () {
                window.location.reload();
            }
        },
        autoOpen: false
    });


    });
</script>
<script type="text/javascript">
function getFilterValue() {
    return $("#campaignEmailFilter").val();
}
    var pTable;
    var prospectFilter;
    var notes_tiptip_prospect_id;
    $(document).ready(function () {
                    $.fn.dataTable.ext.errMode = 'none';

                    function initTable() {
                        pTable = $('.dataTables-prospects').on('error.dt', function (e, settings, techNote, message) {
                            console.log('An error has been reported by DataTables: ', message);
                            $("#datatablesError").dialog('open');
                        })
                            .on('processing.dt', function (e, settings, processing) {
                                if (processing) {
                                    $("#prospectsTableLoader").show();
                                } else {
                                    $("#prospectsTableLoader").hide();
                                }
                            })
                            .DataTable({
                                "processing": true,
                                "serverSide": true,
                                "ajax": {
                                        url: "<?php echo site_url('prospects/table_resend?action=resend&resend_id=').$this->uri->segment(3); ?>",
                                        data: function(d) {
                                            d.type = getFilterValue();
                                        }
                                    },

                                "columnDefs": [
                                    {
                                        "targets": [0],
                                        "width": '15px',
                                        "searchable": false,
                                        "sortable": false,
                                        'class': 'dtCenter'
                                    },
                                    {"targets": [1], "sortable": false, "type": "html", 'class': 'dtCenter', "width": "60px"},
                                    {"targets": [2], "visible": false},
                                    {"targets": [3],"width": '8%', "sortable": true, "orderData": 2},
                                    {"targets": [4],"width": '8%', "sortable": true}, //status
                                    {"targets": [5], "visible": false}, //rating num
                                    {"targets": [6], "width": '8%',"sortable": true, "orderData": 5},//rating text
                                    {"targets": [7], "width": '8%',"sortable": false},//business type
                                    {"targets": [8], "width": '10%',"sortable": true},// company name 
                                    {"targets": [9], "visible": false}, // contact 
                                    {"targets": [10],  "width": '10%',"sortable": true, "orderData": 9},// contact html
                                    {"targets": [11], "visible": false},//Owner
                                    {"targets": [12],"width": '5%', "orderData": 11},//Owner html
                                ],
                                "sorting": [
                                    [2, "desc"]
                                ],
                                "jQueryUI": true,
                                "autoWidth": false,
                                "stateSave": true,
                                "scrollY": '70vh',
                                "scrollCollapse": true,
                                "paginationType": "full_numbers",
                                "dom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop">fl>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"pir>',
                                "lengthMenu": [
                                    [10, 25, 50, 100, 200, 500, 1000],
                                    [10, 25, 50, 100, 200, 500, 1000]
                                ],
                                "drawCallback": function (settings) {
                                    if (!ui) {
                                        initUI();
                                        ui = true;
                                    }
                                    initTiptip();
                                    notes_tooltip();
                                    updateGroupButtons();
                                    check_highlighted_row();
                                    if (pTable) {
                                        $("#filterNumResults").text(pTable.page.info().recordsDisplay);
                                    }
                                    $("#groupSelectAllTop").html('<span id="numSelected">0</span> selected');
                                    $("#prospectMasterCheck").prop('checked', false);
                                    $("#filterResults").show();
                                    $("#filterLoading").hide();
                                }
                            });

                        var column_show = localStorage.getItem("prospect_column_show");
                        if (column_show) {

                            var column_show = column_show.split(',');
                            pTable.columns(column_show).visible(true);

                            for ($i = 0; $i < column_show.length; $i++) {
                                $("input[name=column_show][value=" + column_show[$i] + "]").prop("checked", true);
                            }

                        } else {

                            var column_show = [3, 4, 6, 7, 8, 10, 12];
                            pTable.columns(column_show).visible(true);
                            for ($i = 0; $i < column_show.length; $i++) {
                                $("input[name=column_show][value=" + column_show[$i] + "]").prop("checked", true);
                            }
                        }


                    }

                    
function notes_tooltip() {

$(".prospect_table_notes_tiptip").tipTip({   delay :200,
        maxWidth : "400px",
        context : this,
        defaultPosition: "right",
        content: function (e) {
        
        setTimeout( function(){
                    $.ajax({
                        url: '<?php echo site_url('ajax/getTableNotes') ?>',
                        type:'post',
                        data:{relationId:notes_tiptip_prospect_id,type:'prospect'},
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

$(document).on('mouseenter', ".prospect_table_notes_tiptip", function () {
                notes_tiptip_prospect_id = $(this).data('val');
                return false;
                
            });
            $(document).on('click', ".manage_business_type", function () {
                var company_name = $(this).closest('tr').find('.prospectsTableDropdownToggle').attr('data-company-name');
                $('.change-bt-prospect-name').text(company_name);
                prospect_id = $(this).attr('rel');
                $('.prospectBusinessTypeMultiple').val('');
                $('.prospectBusinessTypeMultiple').trigger("change");
                $('#business_prospect_id').val(prospect_id);
                $.ajax({
                                    url: '<?php echo site_url('ajax/getProspectBusinessTyeps') ?>',
                                    type:'post',
                                    data:{prospect_id:prospect_id},
                                    cache: false,
                                    dataType: 'JSON',
                                    success: function (response) {
                                       
                                        if(response.success){
                                           var selected_bt =[];
                                            var bts = response.business_types;
                                            for($i=0;$i<bts.length;$i++){
                                               
                                                selected_bt.push(bts[$i]['business_type_id']);
                                            }
                                            $('.prospectBusinessTypeMultiple').val(selected_bt);
                                            $('.prospectBusinessTypeMultiple').trigger("change");

                                        }
                                     $("#change-prospect-business-type").dialog('open');    
                                    }
                                });
                return false;
                
            });

                                // Prospect Business Type Update
                                $("#change-prospect-business-type").dialog({
                        width: 500,
                        modal: true,
                        buttons: {
                            Save: {
                                'class': 'btn ui-button update-button',
                                text: 'Save',
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
                                        data: {prospect_id:$('#business_prospect_id').val(),businessTypes: $('.prospectBusinessTypeMultiple').val()},
                                        url: "<?php echo site_url('ajax/prospectsChangeBusinessTypes') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                        dataType: "JSON"
                                    }).success(function (data) {
                                        
                                        //document.location.reload();
                                        pTable.ajax.reload(null,false);
                                        $("#change-prospect-business-type").dialog('close');
                                        swal('','Business Type changed');
                                        
                                    });
                                }
                            },
                            Cancel: function () {
                                $(this).dialog('close');
                            }
                        },
                        autoOpen: false
                    });

function check_highlighted_row(){
    console.log(localStorage.getItem("ps_last_active_row"))
    if(localStorage.getItem("ps_last_active_row")){
        var row_num =localStorage.getItem("ps_last_active_row");
        $('#dataTables-prospects tbody').find("[data-prospect-id='"+row_num+"']").closest('tr').addClass('selectedRow');
    }
}

                    $(".filterButton").click(function () {
                        $(".newFilterContainer").toggle();
                        $(".groupActionsContainer").hide();
                    });

                    $("#newProposalFilterButton").click(function () {
                        hideInfoSlider();
                        $("#newProposalFilters").toggle();
                        // Clear search so that filters aren't affected
                        accTable.search('');
                        // Hide group action menu
                        $(".groupActionsContainer").hide();
                    });

                    $("#closeFilters").click(function () {
                        $(".newFilterContainer").toggle();
                        $(".filterColumn, .filterColumnWide").addClass('filterCollapse');
                    });

                    $(".filterColumnWide .filterColumnHeader").click(function () {
                        $(this).parents('.filterColumnWide').toggleClass('filterCollapse');

                    });

                    $(".filterColumn .filterColumnHeader").click(function () {
                        $(this).parents('.filterColumn').toggleClass('filterCollapse');
                    });

                    // Group Actions Button
                    $("#groupActionsButton").click(function () {
                        // Hide the filter content
                        $(".newFilterContainer").hide();
                        // Toggle the buttons
                        $(".groupActionsContainer").toggle();
                    });

                    //Hide Menu when clicking on a group action item
                    $(".groupActionItems a").click(function () {
                        $(".groupActionsContainer").hide();
                        return false;
                    });

                    $(".filterCheck").click(function () {

                        // If it's a branch click
                        if ($(this).hasClass('branchFilterCheck')) {
                            // So, we're clicking on a branch //
                            // How many are there? //
                            var numBranches = $(".branchFilterCheck").length;
                            var numSelectedBranches = $(".branchFilterCheck:checked").length;
                            var selectedBranches = [];

                            // If all branches selects, check the all box and all users
                            if (numSelectedBranches == numBranches) {
                                $("#allUsersCheck").prop('checked', true);
                                // Check all users
                                $('.userFilterCheck').prop('checked', true);
                            } else {
                                $("#allUsersCheck").prop('checked', false);

                                // Check the users of the selected branches
                                selectedBranches = $(".branchFilterCheck:checked").map(function () {
                                    return $(this).data('branch-id');
                                }).get();

                                $('.userFilterCheck').not('.branchFilterCheck').each(function () {
                                    var branchId = $(this).data('branch-id');
                                    if (selectedBranches.indexOf(branchId) < 0) {
                                        $(this).prop('checked', false);
                                    } else {
                                        $(this).prop('checked', true);
                                    }
                                });

                            }
                            console.log(selectedBranches);

                        } else if ($(this).hasClass('userFilterCheck')) {
                            // This is a user checkbox that isn't a branch, it's being changed so removed the branch filter
                            $('.branchFilterCheck').prop('checked', false);

                            var selectedUserBranches = $(".userFilterCheck:checked").map(function () {
                                return $(this).data('branch-id');
                            }).get();

                            var uniqueUserBranches = Array.from(new Set(selectedUserBranches));

                            if (uniqueUserBranches.length > 1) {
                                $('.branchFilterCheck').prop('checked', false);
                            } else {

                                // Do we need to check the branc box?
                                var branchIds = selectedBranches = $(".branchFilterCheck").map(function () {
                                    return $(this).data('branch-id');
                                }).get();


                                $.each(branchIds, function (index, value) {
                                    // Count how many there are
                                    var totalBranchUsers = $('[data-branch-id="' + value + '"]').not('.branchFilterCheck').length;
                                    var numUnchecked = $('[data-branch-id="' + value + '"]').not('.branchFilterCheck').not(':checked').length;

                                    if (totalBranchUsers > 0 && numUnchecked == 0) {
                                        $('.branchFilterCheck[data-branch-id="' + value + '"]').prop('checked', true);
                                    }
                                });
                            }
                        } else if ($(this).hasClass('statusFilterCheck')) {
                            if ($(this).val() == 'Converted' || $(this).val() == 'Cancelled' || $(this).val() == 'On Hold' || $(this).val() == 'Waiting for Subs') {
                                $(".statusFilterCheck[value='Active']").prop('checked', false);
                            } else {
                                $(".statusFilterCheck[value!='Active']").prop('checked', false);
                            }
                        }
                        $.uniform.update();
                    });


                    $(document).on('change', ".filterCheck", function () {

                        if ($(this).hasClass('clientAccountFilterCheck') && $(this).hasClass('searchSelected')) {
                            if (!$(this).is(':checked')) {
                                $(this).parents('.filterColumnRow').remove();
                                $('#accountSearch').trigger('input');
                            }
                        } else if ($(this).hasClass('clientAccountFilterCheck')) {
                            var parent = $(this).parents('.filterColumnRow');
                            parent.addClass('searchSelectedRow');
                            $(this).addClass('searchSelected');
                            parent.insertAfter('#accountRowAll');
                        }

                        var numSearchSelected = $('.searchSelected').length;
                        if (numSearchSelected < 1) {
                            $('#allClientAccounts').prop('checked', true);
                        } else {
                            $('#allClientAccounts').prop('checked', false);
                        }

                        $.uniform.update();
                        applyFilter();
                    });

                    $(document).on('change', '.filterColumnCheck', function () {

                        var showAll = false;
                        var className = $(this).data('affected-class');

                        if ($(this).attr('id') == 'allClientAccounts') {
                            if ($(this).is(':checked')) {
                                $("#accountSearch").val('');
                                $("#accountSearch").trigger('input');
                                $('.searchSelectedRow').remove();
                            }
                        }

                        if ($(this).is(':checked')) {
                            showAll = true;
                        }

                        $('.' + className).prop('checked', showAll);
                        $.uniform.update();
                        applyFilter();
                    });

                    // Removing user filter
                    $(document).on('click', '#removeUserFilter', function () {
                        $(".userFilterCheck").prop('checked', false);
                        $.uniform.update();
                        applyFilter();
                    });

                    // Removing source filter
                    $(document).on('click', '#removeSourceFilter', function () {
                        $(".sourceFilterCheck").prop('checked', false);
                        $.uniform.update();
                        applyFilter();
                    });


                    // Removing status filter
                    $(document).on('click', '#removeStatusFilter', function () {
                        $(".statusFilterCheck").prop('checked', false);
                        $(".statusFilterCheck[value='Active']").prop('checked', true);
                        $.uniform.update();
                        applyFilter();
                    });

                    // New filter reset button
                    $(".resetFilterButton").click(function () {

                        // Reset Dates
                        $("#lCreatedFrom").val("");
                        $("#lCreatedTo").val("");

                        // Reset All Checkboxes
                        $(".filterCheck, .filterColumnCheck").prop('checked', true);
                        $(".filterColumn, .filterColumnWide").addClass('filterCollapse');

                        // Set Active as it's default (by unchecking others)
                        $(".statusFilterCheck[value!='Active']").prop('checked', false);

                        $.uniform.update();
                        applyFilter();

                        return false;
                    });

                    $("#lCreatedFrom, #lCreatedTo").datepicker();

                    // Handle preset change
                    $("#lCreatedFrom, #lCreatedTo").change(function () {
                        $("#createdPreset").val('custom');
                        $.uniform.update();
                        applyFilter();
                    });

                    $("#lCreatedFrom, #pCrelCreatedToatedTo").on('input', function () {
                        $("#createdPreset").val('custom');
                        $.uniform.update();
                        applyFilter();
                    });

                    $("#createdPreset").change(function () {

                        var selectVal = $(this).val();

                        if (selectVal) {

                            if (selectVal == 'custom') {
                                $("#lCreatedFrom").focus();
                            } else {
                                var preset = datePreset(selectVal);
                                $("#lCreatedFrom").val(preset.startDate);
                                $("#lCreatedTo").val(preset.endDate);
                                applyFilter();
                            }
                        }
                    });


                    // Run the filter by default
                    applyFilter();

                    function applyFilter() {
                        $("#filterResults").hide();
                        $("#filterLoading").show();
                        setTimeout(function () {
                            $(".resetFilter").show();

                            // Users & Branches
                            var users = [];
                            var userValues = [];
                            if ($(".userFilterCheck:checked").not('.branchFilterCheck').length != $(".userFilterCheck").not('.branchFilterCheck').length) {
                                users = $(".userFilterCheck:checked").not('.branchFilterCheck').map(function () {
                                    userValues.push($(this).data('text-value'));
                                    return $(this).val();
                                }).get();
                            } else {
                                users = 'All'
                            }
                            if (!users.length) {
                                users = [];
                            }

                            // Lead Sources
                            var leadSources = [];
                            var leadSourceValues = [];

                            if ($(".sourceFilterCheck:checked").length != $(".sourceFilterCheck").length) {
                                leadSources = $(".sourceFilterCheck:checked").map(function () {
                                    leadSourceValues.push($(this).val());
                                    return $(this).val();
                                }).get();
                            } else {
                                leadSources = 'All';
                            }

                            if (!leadSources.length) {
                                leadSources = [];
                            }

                            // ratings
                            var ratings = [];
                            var ratingsValues = [];

                            var numRatings = $(".ratingFilterCheck").length;
                            var numSelectedRatings = $(".ratingFilterCheck:checked").length;


                            // If all branches selects, check the all box and all users
                            if (numRatings == numSelectedRatings) {
                                var ratings = 'All';
                            } else {

                                ratings = $(".ratingFilterCheck:checked").map(function () {
                                    ratingsValues.push($(this).data('text-value'));
                                    return $(this).val();
                                }).get();
                            }

                            if (!ratings.length) {
                                ratingsValues = [];
                            }
                            console.log(ratings);
                            // Due Dates
                            var dueDates = [];
                            var dueDateValues = [];

                            if ($(".dueDateFilterCheck:checked").length != $(".dueDateFilterCheck").length) {
                                dueDates = $(".dueDateFilterCheck:checked").map(function () {
                                    dueDateValues.push($(this).data('text-value'));
                                    return $(this).val();
                                }).get();
                            }

                            if (!dueDates.length) {
                                dueDateValues = [];
                            }

                            // Created Range
                            var lCreatedFrom = $("#lCreatedFrom").val();
                            var lCreatedTo = $("#lCreatedTo").val();

                            // Filter Badges  and UI Update//

                            var filterBadgeHtml = '';
                            var createdHeaderText = ' [ All ]';
                            var userHeaderText = ' [ All ]';
                            var sourceHeaderText = ' [ All ]';
                            var statusHeaderText = ' [ All ]';
                            var dueDateHeaderText = ' [ All ]';
                            var numFilters = 0;


                            // Date Range
                            // Created Date Range
                            if ($("#lCreatedFrom").val() || $("#lCreatedTo").val()) {
                                numFilters++;
                                var fromDateString;
                                var toDateString;
                                var createdRangeString;

                                if ($("#lCreatedFrom").val() && $("#lCreatedTo").val()) {

                                    fromDateString = $("#lCreatedFrom").val();
                                    toDateString = $("#lCreatedTo").val();
                                    createdRangeString = fromDateString + ' - ' + toDateString;
                                } else if ($("#lCreatedFrom").val()) {
                                    fromDateString = $("#lCreatedFrom").val();
                                    createdRangeString = 'After ' + fromDateString;
                                } else {
                                    toDateString = $("#lCreatedTo").val();
                                    createdRangeString = 'Before ' + toDateString;
                                }

                                filterBadgeHtml += '<div class="filterBadge">' +
                                    '<div class="filterBadgeTitle">Created: </div>' +
                                    '<div class="filterBadgeContent">' +
                                    createdRangeString +
                                    '</div>' +
                                    '<div class="filterBadgeRemove"><a href="#" id="removeCreatedFilter">&times;</a></div>' +
                                    '</div>';

                                createdHeaderText = createdRangeString;
                                $('#createdFilterHeader').addClass('activeFilter');
                            } else {
                                $('#createdFilterHeader').removeClass('activeFilter');
                            }
                            $("#createdHeaderText").text(createdHeaderText);

                            // User
                            if (userValues.length) {
                                numFilters++;
                                $('#userFilterHeader').addClass('activeFilter');

                                var userBadgeText = '[' + userValues.length + ']';

                                if (userValues.length == $(".userFilterCheck").not('.branchFilterCheck').length) {
                                    userBadgeText = 'All';
                                }

                                if (userValues.length == 1) {
                                    userBadgeText = userValues[0];
                                }

                                filterBadgeHtml += '<div class="filterBadge">' +
                                    '<div class="filterBadgeTitle">Users: </div>' +
                                    '<div class="filterBadgeContent">' +
                                    userBadgeText +
                                    '</div>' +
                                    '<div class="filterBadgeRemove"><a href="#" id="removeUserFilter">&times;</a></div>' +
                                    '</div>';

                                userHeaderText = '[' + userValues.length + ']';

                            } else {
                                $('#userFilterHeader').removeClass('activeFilter');
                            }
                            $("#userHeaderText").text(userHeaderText);

                            // Source
                            if (leadSourceValues.length) {

                                numFilters++;
                                $('#sourceFilterHeader').addClass('activeFilter');

                                var sourceBadgeText = '[' + leadSourceValues.length + ']';

                                if (leadSourceValues.length == $(".sourceFilterCheck:checked").not('.sourceFilterCheck').length) {
                                    sourceBadgeText = 'All';
                                }

                                if (leadSourceValues.length == 1) {
                                    sourceBadgeText = leadSourceValues[0];
                                }

                                filterBadgeHtml += '<div class="filterBadge">' +
                                    '<div class="filterBadgeTitle">Source: </div>' +
                                    '<div class="filterBadgeContent">' +
                                    sourceBadgeText +
                                    '</div>' +
                                    '<div class="filterBadgeRemove"><a href="#" id="removeSourceFilter">&times;</a></div>' +
                                    '</div>';

                                sourceHeaderText = '[' + leadSourceValues.length + ']';

                            } else {
                                $('#sourceFilterHeader').removeClass('activeFilter');
                            }
                            $("#sourceHeaderText").text(sourceHeaderText);


                            $("#statusHeaderText").text(statusHeaderText);

                            // Due Date
                            if (ratingsValues.length) {
                                numFilters++;
                                $('#createdFilterHeader').addClass('activeFilter');

                                var ratingsBadgeText = '[' + ratingsValues.length + ']';

                                if (ratingsValues.length == $(".ratingFilterCheck").length) {
                                    ratingsBadgeText = 'All';
                                }

                                if (ratingsValues.length == 1) {
                                    ratingsBadgeText = ratingsValues[0];
                                }

                                filterBadgeHtml += '<div class="filterBadge">' +
                                    '<div class="filterBadgeTitle">Ratings: </div>' +
                                    '<div class="filterBadgeContent">' +
                                    ratingsBadgeText +
                                    '</div>' +
                                    '<div class="filterBadgeRemove"><a href="#" id="removeStatusFilter">&times;</a></div>' +
                                    '</div>';

                                ratingsBadgeText = '[' + ratingsValues.length + ']';

                            } else {
                                $('#createdFilterHeader').removeClass('activeFilter');
                            }
                            $("#createdHeaderText").text(dueDateHeaderText);


                            // Apply the HTML
                            $("#filterBadges").html(filterBadgeHtml);

                            if (numFilters < 1) {
                                $(".filterButton").removeClass('update-button');
                                $(".filterButton").addClass('grey');
                                $('.resetFilterButton').hide();
                            } else {
                                $(".filterButton").addClass('update-button');
                                $(".filterButton").removeClass('grey');
                                $('.resetFilterButton').show();
                            }
                            var numBranches = $(".branchFilterCheck").length;
                            var numSelectedBranches = $(".branchFilterCheck:checked").length;


                            // If all branches selects, check the all box and all users
                            if (numSelectedBranches == numBranches) {
                                var selectedBranches = 'All';
                            } else {
                                var selectedBranches = [];
                                selectedBranches = $(".branchFilterCheck:checked").map(function () {
                                    return $(this).data('branch-id');
                                }).get();
                            }
                            prospectFilter = {
                                "ptFilterUser": userValues,
                                "ptFilterRating": ratingsValues,
                                "ptFilterSource": leadSourceValues
                            }

                            $.ajax({
                                type: "POST",
                                url: '<?php echo site_url('ajax/setProspectResendFilter').'/'.$this->uri->segment(3) ?>',
                                data: {


                                    ptFilterUser: users,
                                    ptFilterBranch: selectedBranches,
                                    ptFilterRating: ratings,
                                    ptFilterSource: leadSources
                                },
                                dataType: 'JSON',
                                success: function () {
                                    updateTable();
                                }
                            });
                        }, 500);
                    }

                    function updateTable() {

                        if ($.fn.DataTable.isDataTable('#dataTables-prospects')) {
                            pTable.ajax.reload();
                        } else {
                            initTable();
                        }

                    }

                    $("#dialog-message").dialog({
                        width: 500,
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
                                document.location.href = $("#client-delete").attr('rel');
                                $(this).dialog("close");
                            },
                            Cancel: function () {
                                $(this).dialog("close");
                            }
                        },
                        autoOpen: false
                    });
                    $(".confirm-deletion").live('click', function () {
                        $('#newProspectsPopup').hide();
                        $("#client-delete").attr('rel', $(this).attr('rel'));
                        $("#confirm-delete-message").dialog('open');
                        return false;
                    });
                    $('.viewClient').live('click', function () {
                        var clientId = $(this).attr('rel');
                        $.getJSON("<?php echo site_url('ajax/getClientData') ?>/" + clientId, function (data) {
                            var items = [];
                            $.each(data, function (key, val) {
                                $("#field_" + key).html(val);
                            });
                        });
                        $("#dialog-message").dialog("open");
                    });
                    /**
                     * Notes stuff here
                     */
                    $("#notes").dialog({
                        modal: true,
                        buttons: {
                            Close: function () {
                                $(this).dialog("close");
                            }
                        },
                        autoOpen: false,
                        width: 700
                    });
                    $(".notes").live('click', function () {
                        $('#newProspectsPopup').hide();
                        var id = $(this).attr('rel');
                        var frameUrl = '<?php echo site_url('account/notes/prospect') ?>/' + id;
                        $("#notesFrame").attr('src', frameUrl);
                        $("#relationId").val(id);
                        $('#notesFrame').load(function () {
                            $("#notes").dialog('open');
                        });
                        return false;
                    });
                    $("#add-note").submit(function () {
                        var request = $.ajax({
                            url: '<?php echo site_url('ajax/addNote') ?>',
                            type: "POST",
                            data: {
                                "noteText": $("#noteText").val(),
                                "noteType": 'prospect',
                                "relationId": $("#relationId").val()
                            },
                            dataType: "json",
                            success: function (data) {
                                if (data.success) {
                                    //refresh frame
                                    $("#noteText").val('');
                                    $('#notesFrame').attr('src', $('#notesFrame').attr('src'));
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

                    //$("#groupSelectAllTop").html('<a href="#" id="selectAll">All</a> / <a href="#" id="selectNone">None</a>&nbsp;&nbsp;&nbsp;<span id="numSelected">0</span> selected');
                    function updateGroupButtons() {
                        var counter = $(".groupSelect:checked").length;
                        if (counter > 0) {
                            $("#groupActions").show();
                        } else {
                            $("#groupActions").hide();
                        }

                        if (counter > 7) {
                            $('.planRoute').hide();
                        } else {
                            $('.planRoute').show();
                        }

                        $.uniform.update();
                        $("#numSelected, #deleteNum, #changeOwnerNum, #resendNum, #changeSourceNum").html('<strong>' + counter + '</strong>');
                    }

                    $("#groupActions").hide();
                    $(".groupSelect:checked").removeAttr('checked');
                    //updateGroupButtons();
                    $(".groupSelect").live('change', function () {
                        updateGroupButtons();
                    });
                    $(".changeOwner").click(function () {
                        $("#change-owner").dialog('open');
                    });

                    function getSelectedIds() {
                        var IDs = [];

                        $(".groupSelect:checked").each(function () {
                            IDs.push($(this).data('prospect-id'));
                        });

                        return IDs;
                    }

                    $(".deleteProspects").click(function () {
                        $("#delete-prospects").dialog('open');
                    });

                    //group stuff but needs to be here because i'm too lazy
                    $("#delete-prospects").dialog({
                        width: 500,
                        modal: true,
                        buttons: {
                            "Delete": {
                                text: 'Delete Prospects',
                                'class': 'btn ui-button update-button',
                                'id': 'confirmDelete',
                                click: function () {
                                    $.ajax({
                                        type: "POST",
                                        async: true,
                                        cache: false,
                                        data: {'ids': getSelectedIds()},
                                        url: "<?php echo site_url('ajax/groupDeleteProspects') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                        dataType: "JSON"
                                    }).success(function (data) {
                                        $("#deleteProposalsStatus").html('Done!');
                                        document.location.reload();
                                    });
                                    $(this).dialog('close');
                                    $("#deleteProposalsStatus").html('Deleting prospects, please wait... <img src="/static/loading.gif" />');
                                    $("#delete-proposals-status").dialog('open');
                                }
                            },
                            Cancel: function () {
                                $(this).dialog("close");
                            }
                        },
                        autoOpen: false
                    });
                    // Proposal Status Update
                    $("#delete-proposals-status").dialog({
                        width: 500,
                        modal: true,
                        buttons: {
                            OK: function () {
                                $(this).dialog('close');
                                pTable.fnDraw();
                            }
                        },
                        autoOpen: false
                    });
                    // Proposal Status Update
                    $("#change-owner").dialog({
                        width: 500,
                        modal: true,
                        buttons: {
                            Save: {
                                'class': 'btn ui-button update-button',
                                text: 'Save',
                                click: function () {
                                    $("#changeOwnerStatus").html('Updating owners, please wait...  <img src="/static/loading.gif" />');
                                    $.ajax({
                                        type: "POST",
                                        async: true,
                                        cache: false,
                                        data: {'ids': getSelectedIds(), newOwner: $("#newOwner").val()},
                                        url: "<?php echo site_url('ajax/groupProspectsChangeOwner') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                        dataType: "JSON"
                                    }).success(function (data) {
                                        $("#changeOwnerStatus").html('Done!');
                                        document.location.reload();
                                    });
                                }
                            },
                            Cancel: function () {
                                $(this).dialog('close');
                            }
                        },
                        autoOpen: false
                    });

                    $("#prospectMasterCheck").change(function () {
                        var checked = $(this).is(":checked");
                        $(".groupSelect").prop('checked', checked);
                        updateGroupButtons();
                    });
                    // All
                    $("#selectAll").live('click', function () {
                        $(".groupSelect").attr('checked', 'checked');
                        updateGroupButtons();
                        return false;
                    });

                    $("#emailCustom").change(function () {
                        if ($("#emailCustom").attr('checked')) {
                            $(".emailFromOption").show();
                        } else {
                            $(".emailFromOption").hide();
                            $(".emailFromOption input").val('');
                        }
                    });

                    // None
                    $("#selectNone").live('click', function () {
                        $(".groupSelect").attr('checked', false);
                        updateGroupButtons();
                        return false;
                    });

                    /*Send Email Functioanlity*/
                    

                    $("#resendSelect").live('change', function () {
                        $(".new_resend_name").prop('disabled', false);
                        $(".no_campaign").show();
                        if ($(this).val() < 1) {
                            $('.new_resend_name_span').show();

                            if ($(this).val() == 0) {
                                $(".new_resend_name").val('<?=date("m/d/Y h:ia");?>');
                            } else {
                                $(".new_resend_name").val('');
                                $(".no_campaign").hide();
                                //$(".new_resend_name").prop('disabled', true);
                            }

                            $('#messageFromName').prop('disabled', false);
                            $('#messageFromEmail').prop('disabled', false);
                            $('#messageSubject').prop('disabled', false);
                            $('#templateSelect').prop('disabled', false);
                            $('.is_templateSelect_disable').hide();
                            $("#emailCustom").prop("checked", false);
                            $("#emailCC").prop("checked", false);
                            $("#emailCustom").trigger('change');
                            $("#templateSelect").trigger('change');

                            $('#emailCC').prop('disabled', false);
                            $('#emailCustom').prop('disabled', false);

                            //CKEDITOR.instances.message.setReadOnly(false);
                            tinymce.activeEditor.mode.set("design");
                            $.uniform.update();

                        } else {
                            $('.new_resend_name_span').hide();
                            $('.new_resend_name').removeClass('error');
                            $.ajax({
                                url: '<?php echo site_url('ajax/get_prospect_resend_details') ?>',
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
                                        $('.is_templateSelect_disable').css('display', 'block');
                                        if (data.email_cc == 1) {
                                            $("#emailCC").prop("checked", true);
                                            $('#emailCC').prop('disabled', true);
                                            $.uniform.update();
                                        } else {
                                            $("#emailCC").prop("checked", false);
                                            $('#emailCC').prop('disabled', true);
                                            $.uniform.update();
                                        }


                                        if (data.custom_sendor == 1) {
                                            $("#emailCustom").prop("checked", true);
                                            $('#emailCustom').prop('disabled', true);

                                            $.uniform.update();

                                            $('#messageFromName').val(data.custom_sendor_name);
                                            $('#messageFromEmail').val(data.custom_sendor_email);
                                        } else {
                                            $("#emailCustom").prop("checked", false);
                                            $('#emailCustom').prop('disabled', true);
                                            $.uniform.update();
                                            $('#messageFromName').val('');
                                            $('#messageFromEmail').val('');
                                        }
                                        $("#emailCustom").trigger('change');

                                        $('.new_resend_name').val(data.resend_name);
                                        $('#messageFromName').prop('disabled', true);
                                        $('#messageFromEmail').prop('disabled', true);
                                        //$('#message').val(data.email_content);
                                        //CKEDITOR.instances.message.setData(data.email_content);
                                        tinymce.get('message').setContent(data.email_content);
                                        tinymce.activeEditor.mode.set("readonly");
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

                    // Resend dialog
                    $("#send-email").dialog({
                        width: 950,
                        modal: true,
                        open: function () {
                            $("#emailCustom").attr('checked', false);
                            $(".emailFromOption").hide();
                            $.uniform.update();
                        },
                        buttons: {
                            "Resend": {
                                text: 'Send Email',
                                'class': 'btn ui-button update-button',
                                'id': 'confirmResend',
                                click: function () {
                                    $('#email-feedback').dialog('open');
                                    $('#feedbackText').text('Sending emails');

                                    if ($("#emailCustom").attr('checked')) {

                                        if (!$("#messageFromName").val() || !$("#messageFromEmail").val()) {
                                            alert('Please enter a from name and email address');
                                            return false;
                                        }
                                    }

                                    if ($('#resendSelect').val() == 0 && !$('.new_resend_name').val()) {
                                        alert('Please enter Resend Name');
                                        return false;
                                    }

                                    $.ajax({
                                        type: "POST",
                                        async: true,
                                        cache: false,
                                        data: {
                                            'ids': getSelectedIds(),
                                            'subject': $("#messageSubject").val(),
                                            'body': tinyMCE.get('message').getContent(),
                                            'fromName': $("#messageFromName").val(),
                                            'fromEmail': $("#messageFromEmail").val(),
                                            'resendId': $("#resendSelect").val(),
                                            'new_resend_name': $(".new_resend_name").val(),
                                            'prospectFilter': prospectFilter

                                        },
                                        url: "<?php echo site_url('ajax/groupProspectsSendEmail') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                        dataType: "JSON"
                                    })
                                        .success(function (data) {

                                            msg = data.counter + ' prospect emails were sent';

                                            if (data.noEmailCounter) {
                                                msg += "<br /><br />" + data.noEmailCounter + " email(s) could not be sent as the prospect has no email address."
                                            }
                                            $("#feedbackText").text(msg);
                                        });
                                    $(this).dialog('close');
//                        $("#resendProposalsStatus").html('Sending proposal mails...<img src="/static/loading.gif" />');
//                        $("#resend-proposals-status").dialog('open');
                                }
                            },
                            Cancel: function () {
                                $(this).dialog("close");
                            }
                        },
                        autoOpen: false
                    });
                    $(".sendEmail").click(function () {
                        tinymce.remove('message')
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
                        $("#send-email").dialog('open');
                        //$("#resendNum").html($(".groupSelect:checked").length);
                        // $("#resend-proposals").dialog('open');
                        //$('.new_resend_name_span').show();
                        //$(".no_campaign").show();
                        $('#messageFromName').prop('disabled', false);
                        $('#messageFromEmail').prop('disabled', false);
                        $('#messageSubject').prop('disabled', false);
                        $('#templateSelect').prop('disabled', false);
                        $('.is_templateSelect_disable').hide();
                        $('#emailCustom').prop('disabled', false);
                        //CKEDITOR.instances.message.setReadOnly(false);
                        //$('#templateSelect').trigger('change');
                        $("#resendSelect").val(0)
                        $(".new_resend_name").val('<?=date("m/d/Y h:ia");?>')

                        $("#resendSelect").trigger('change')
                        //$("#emailCC").prop('checked', false);
                        $.uniform.update();
                        // $('.groupActionsContainer').hide();
                        return false;
                    });


                    $("#email-feedback").dialog({
                        width: 500,
                        modal: true,
                        buttons: {
                            OK: function () {
                                pTable.ajax.reload();
                                $(this).dialog('close');
                            }
                        },
                        autoOpen: false
                    });
                    // Template change handler
                    $('#templateSelect').change(function () {
                        var selectedTemplate = $('#templateSelect option:selected').data('template-id');
                        loadTemplateContents(selectedTemplate);
                    });

                    // Load the selected content
                    var defaultTemplate = $('#templateSelect option:selected').data('template-id');

                    //loadTemplateContents(defaultTemplate);

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
                                tinymce.activeEditor.setContent(data.templateBody);
                            });

                        $.uniform.update();
                    }

                    $(".planRoute").click(function () {
                        $("#selectedProspectsForm").html('');

                        var ids = getSelectedIds();

                        $.each(ids, function (index, value) {
                            var inputText = '<input type="hidden" name="prospects[]" value="' + value + '" />';
                            $("#selectedProspectsForm").append(inputText);
                        });

                        $("#selectedProspectsForm").submit();
                    });

                    // Change Source
                    $(".changeSource").click(function () {
                        $("#change-source").dialog('open');
                        return false;
                    });

                    // Prospect Source Update
                    $("#change-source").dialog({
                        width: 500,
                        modal: true,
                        buttons: {
                            Save: {
                                'class': 'btn ui-button update-button',
                                text: 'Save',
                                click: function () {
                                    $("#changeSourceStatus").html('Updating sources, please wait...  <img src="/static/loading.gif" />');
                                    $.ajax({
                                        type: "POST",
                                        async: true,
                                        cache: false,
                                        data: {'ids': getSelectedIds(), newSource: $("#newSource").val()},
                                        url: "<?php echo site_url('ajax/groupProspectsChangeSource') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                        dataType: "JSON"
                                    }).success(function (data) {
                                        $("#changeSourceStatus").html('Done!');
                                        document.location.reload();
                                    });
                                }
                            },
                            Cancel: function () {
                                $(this).dialog('close');
                            }
                        },
                        autoOpen: false
                    });

                    // Prospect Filters
                    /*New Filter Code*/
                    closeFilters(); //init with all filters closed to prevent the browser refresh cache

                    function closeFilters() {
                        $("#newFilter .trigger").removeClass('active');
                        $(".filter-code").hide();
                        $(".filterOverlay").hide();
                    }

                    //updates branch users -- hides the users that are not needed when a branch is selected.
                    function updateBranchUsers() {
                        //show all
                        $(".branchUser").show();
                        if (($("#filterBranchValue").val() != 'All') && ($("#filterBranchValue").val() != '')) {
                            var userClass = 'branch_' + $("#filterBranchValue").val();
//                console.log('userClass:' + userClass);
                            //hide users that do not belong
                            $(".branchUser:not(." + userClass + ")").hide();
                            //reset user filter selector
                            $("#userFilter").removeClass('filterActive');
                            $("#userFilter .trigger").text('User: All');
                        } else {
//                console.log('NOUP');
                        }
                    }

                    function resetFilters() {
                        $("#userFilter").removeClass('filterActive');
                        $("#userFilter .trigger").text('User: All');
                        $("#branchFilter").removeClass('filterActive');
                        $("#branchFilter .trigger").text('Branch: All');
                        $("#statusFilter").removeClass('filterActive');
                        $("#statusFilter .trigger").text('Status: Active');
                        $("#ratingFilter").removeClass('filterActive');
                        $("#ratingFilter .trigger").text('Status: All');
                        $("#sourceFilter").removeClass('filterActive');
                        $("#sourceFilter .trigger").text('Status: All');
                    }

                    $(".filterOverlay").live('click', function () {
                        closeFilters();
                    });
                    $(".trigger.reset").live('click', function () {
                        resetFilters();
                    });

                    $("#newFilter .trigger").live('click', function () {
                        if ($(this).hasClass('active')) {
                            //hide the filter
                            closeFilters();
                        } else {
                            //show the filter
                            closeFilters();
                            $(this).addClass('active');
                            $(this).next().show();
                            $(".filterOverlay").css({
                                display: "block",
                                width: "100%",
                                height: "100%"
                            });
                        }
                        return false;
                    });

                    //Code for branch change filter
                    $("#branchFilter li a").click(function () {
                        $("#branchFilter .trigger").text($(this).attr('title'));
                        $("#filterBranchValue").val($(this).attr('rel'));
                        if ($(this).attr('rel') == 'All') {
                            $("#branchFilter").removeClass('filterActive');
                        } else {
                            $("#branchFilter").addClass('filterActive');
                        }
                        updateBranchUsers();
                        closeFilters();
                        return false;
                    });

                    //Code for user change filter
                    $("#userFilter li a").click(function () {
                        $("#userFilter .trigger").text($(this).attr('title'));
                        $("#filterUserValue").val($(this).attr('rel'));
                        if ($(this).attr('rel') == 'All') {
                            $("#userFilter").removeClass('filterActive');
                        } else {
                            $("#userFilter").addClass('filterActive');
                        }
                        closeFilters();
                        return false;
                    });

                    //Code for branch change filter
                    $("#statusFilter li a").click(function () {
                        $("#statusFilter .trigger").text($(this).attr('title'));
                        $("#filterStatusValue").val($(this).attr('rel'));
                        if ($(this).attr('rel') == 'All') {
                            $("#statusFilter").removeClass('filterActive');
                        } else {
                            $("#statusFilter").addClass('filterActive');
                        }
                        closeFilters();
                        return false;
                    });

                    // Rating filter
                    $("#ratingFilter li a").click(function () {
                        $("#ratingFilter .trigger").text($(this).attr('title'));
                        $("#filterRatingValue").val($(this).attr('rel'));
                        if ($(this).attr('rel') == 'All') {
                            $("#ratingFilter").removeClass('filterActive');
                        } else {
                            $("#ratingFilter").addClass('filterActive');
                        }
                        closeFilters();
                        return false;
                    });

                    // Source filter
                    $("#sourceFilter li a").click(function () {
                        $("#sourceFilter .trigger").text($(this).attr('title'));
                        $("#filterSourceValue").val($(this).attr('rel'));
                        if ($(this).attr('rel') == 'All') {
                            $("#sourceFilter").removeClass('filterActive');
                        } else {
                            $("#sourceFilter").addClass('filterActive');
                        }
                        closeFilters();
                        return false;
                    });

                    $(".filter-list a").on('click', function () {
                        applyFilter();
                    });

                    $("#applyFilter").click(function () {
                        applyFilter();
                        return false;
                    });



                    $("#resetFilter").click(function () {
                        $("#reset-filter").show();

                        $.ajax({
                            type: "POST",
                            url: '<?php echo site_url('ajax/resetProspectFilter') ?>',
                            data: {},
                            dataType: 'JSON',
                            success: function () {
                                setTimeout(function () {
                                    //disable reload for debug functionality
                                    //document.location.reload();
                                    pTable.ajax.reload();
                                }, 300);
                            }
                        });
                        return false;
                    });

                    // Group Actions Button
                    $("#groupActions").click(function () {
                        // Hide the filter content
                        $(".newFilterContainer").hide();
                        // Toggle the buttons
                        $(".groupActionsContainer").toggle();
                    });

                    //Hide Menu when clicking on a group action item
                    $(".groupActionItems a").click(function () {
                        $(".groupActionsContainer").hide();
                        return false;
                    });


        // Toggle the card links when clink
        $(".statCard").click(function() {
            // Handle highlighting
            if(!$('.failed_top_icon').is(":visible")){
                $('.failed_count_msg').show();
            }
            
            $('.view_prospects_msg ').hide();
            $(".card").removeClass('highlightedCard');
            $(this).addClass('highlightedCard');
            // Set the filter value
            $("#campaignEmailFilter").val($(this).find('.card-action a').data('filter'));
            $("#campaignEmailsFilterCount").text($(this).find('.card-action a').data('filter') ? $(this).find('.card-action a').data('filter') : 'All');
            // Reload the table
            pTable.ajax.reload();

            return false;
        });

        $(".reload_failed").click(function() {
                    // Handle highlighting
                    $('.failed_count_msg').hide();
                    $('.view_prospects_msg').show();
                    $(".card").removeClass('highlightedCard');
                    
                    // Set the filter value
                    $("#campaignEmailFilter").val('failed');
                    
                    // Reload the table
                    pTable.ajax.reload();

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
                        $('.view_prospects_msg').show();
                    }else{
                        $('.check_failed_count_msg').show();
                        $('.failed_count_msg').show();
                        $('.view_prospects_msg').hide();
                    }
                   
                    $('.failed_top_icon').hide();
                });
                

        $(".toggleProposalCampaignDetails").click(function() {
                    $("#campaignProposalsContainer").toggleClass('expanded');
                    return false;
                });

        $(".showEmailContent").click(function() {

            var resend_id = $('#child_resend').val();
            console.log(resend_id);
            $.ajax({
                        url: '/ajax/get_prospect_resend_counts_details/',
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
                                var prospect_filters = JSON.parse(data.filters);
                                
                                var custom_sender_details = "Prospect Owner";
                                if(custom_sender=='1'){
                                    var custom_sender_details = data.custom_sendor_name+' | '+data.custom_sendor_email;
                                }

                    

                    var filter_text = "";
                    var filter_count =0;
                    if(prospect_filters){
                        
                        
                        if(prospect_filters.pResendType){
                            filter_count++;
                            filter_text += "<p><strong style='text-align:left;'>Resend :</strong>"+prospect_filters.pResendType+"</p><br/>";
                        }

                        if(prospect_filters.ptFilterUser){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<prospect_filters.ptFilterUser.length;$i++){
                                temp_text +=prospect_filters.ptFilterUser[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Users:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                        }
                        
                        
                        
                        if(prospect_filters.ptFilterSourceObject){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<prospect_filters.ptFilterSourceObject.length;$i++){
                                temp_text +=prospect_filters.ptFilterSourceObject[$i].name+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Source:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
                        }

                        if(prospect_filters.ptFilterRating){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<prospect_filters.ptFilterRating.length;$i++){
                                temp_text +=prospect_filters.ptFilterRating[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Rating:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
                        }

                        if(prospect_filters.ptFilterBusinessType){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<prospect_filters.ptFilterBusinessType.length;$i++){
                                temp_text +=prospect_filters.ptFilterBusinessType[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Business:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
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
                            tinymce.init({selector: ".email_content",menubar: false,relative_urls : false,remove_script_host : false,convert_urls : true,statusbar: false,toolbar : false,paste_as_text: true,height:'300',readonly : true});
                            
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
                    url: '/ajax/change_prospect_child_resend',
                    type: "POST",
                    dataType: "json",
                    data: {
                        "child_resend_id": $(this).val(),
                    },

                    success: function (data) {
                        if (!data.error) {
                            pTable.ajax.reload(null, false);
                            $('.total_sent').text(' '+data.resendStats.sent);
                            $('.total_delivered').text(' '+data.resendStats.delivered);
                            $('.total_bounced').text(' '+data.resendStats.bounced);
                            $('.total_opened').text(' '+data.resendStats.opened);
                            $('.total_unopened').text(' '+data.resendStats.unopened);
                            $('#campaignEmailContent').val(data.email_content);
                           
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



                    $("#tableColumnFilterButton").click(function () {
                        //hideInfoSlider();
                        $("#newProspectColumnFilters").toggle();
                        // Clear search so that filters aren't affected
                        // pTable.fnFilter('');
                        // Hide group action menu
                        $(".groupActionsContainer").hide();
                    });


                    $(".close_column").click(function () {
                        $("#newProspectColumnFilters").hide();
                        $(".column_show").attr('checked', false);
                        var column_show = localStorage.getItem("prospect_column_show");

                        if (column_show) {

                            var column_show = column_show.split(',');

                            for ($i = 0; $i < column_show.length; $i++) {
                                $("input[name=column_show][value=" + column_show[$i] + "]").prop("checked", true);
                            }
                            $.uniform.update();
                        } else {
                            $(".column_show").attr('checked', true);
                        }
                    })


                    $('body').click(function (event) {

                        var $trigger = $("#tableColumnFilterButton");


                        if ("tableColumnFilterButton" !== event.target.id && !$trigger.has(event.target).length) {
                            if ($(event.target).parents('#newProspectColumnFilters').length == 0) {
                                if (event.target.id != 'newProspectColumnFilters') {
                                    $("#newProspectColumnFilters").hide();

                                    $(".column_show").attr('checked', false);
                                    var column_show = localStorage.getItem("prospect_column_show");

                                    if (column_show) {

                                        var column_show = column_show.split(',');

                                        for ($i = 0; $i < column_show.length; $i++) {
                                            $("input[name=column_show][value=" + column_show[$i] + "]").prop("checked", true);
                                        }
                                        $.uniform.update();
                                    }
                                }

                            }

                        }


                    });

                    // All
                    $("#select_p_column_all").live('click', function () {
                        $(".column_show").attr('checked', 'checked');
                        $.uniform.update();
                        //updateNumSelected()
                        return false;
                    });

                    // None
                    $("#select_p_column_none").live('click', function () {
                        $(".column_show").attr('checked', false);
                        $.uniform.update();
                        //updateNumSelected()
                        return false;
                    });

                    $('.column_show_apply').click(function () {
                        //  pTable.api().columns( [2,3,4,5,6,7,8,9,10,11,13] ).visible( false );
                        pTable.columns([3, 4, 6, 7, 9, 10, 12]).visible(false);
                        var favorite = [];
                        $.each($("input[name='column_show']:checked"), function () {
                            favorite.push($(this).val());
                        });

                        pTable.columns(favorite).visible(true);
                        if(hasLocalStorage){
                            localStorage.setItem("prospect_column_show", favorite);
                        }

                        pTable.ajax.reload(null, false);
                        $("#newProspectColumnFilters").hide();

                    });


                });


                $(document).on('click', ".prospectsTableDropdownToggle", function (e) {
                    //console.log(document.getElementsByTagName("template")[0]);
                    $('#newProspectsPopup').html('');
                    $('#newProspectsPopup').show();

                    $('.is_converted').css('display', 'none');
                    $('.is_audit').css('display', 'none');
                    // $(".template_class").find('.estimating').css('display','none');
                    //$('.job_cost_report,.job_costing,.estimating').css('display','none');
                    var template;

                    var prospect_phone = $(this).attr('data-phone');
                    var prospect_id = $(this).attr('data-prospect-id');
                    var prospect_name = $(this).attr('data-prospect-fullname');
                    var prospect_email = $(this).attr('data-email');
                    var prospect_account = $(this).attr('data-account');

                    var prospect_company_name = $(this).attr('data-company-name');
                    var prospect_url = $(this).attr('data-url');


                    template = $("#template").html();
                    template = template.toString()

                    template = template.replace(new RegExp('{prospectId}', 'g'), prospect_id);
                    template = template.replace(new RegExp('{prospectPhone}', 'g'), prospect_phone);
                    template = template.replace(new RegExp('{prospectFullname}', 'g'), prospect_name);
                    template = template.replace(new RegExp('{prospectAccount}', 'g'), prospect_account);
                    template = template.replace(new RegExp('{prospectEmail}', 'g'), prospect_email);
                    template = template.replace(new RegExp('{companyName}', 'g'), prospect_company_name);
                    template = template.replace(new RegExp('{url}', 'g'), prospect_url);
                    $('#newProspectsPopup').html(template);


                    $(document).on("click", ".email_events", function (e) {
                        $('#newProspectsPopup').hide();
                        var prospect_id = $(this).attr('data-prospect-id');
                        var prospect_account = $(this).attr('data-account');
                        var prospect_comapny_name = $(this).attr('data-comapny-name');
                        var table = '<p style="font-weight: bold; font-size: 16px;"><span style="position: absolute;left: 0px;"><span style="display: block; float: left;  color: #595959; text-align: left; margin-right: 10px;"><i class="fa fw fa-file-pdf-o"></i> Project: </span><span class="shadowz" style="float:left"><a class="tiptip" href="#" >' + prospect_comapny_name + '</a></span></span>' +
                                    '<span style="right: 0px;position: absolute;" ><span style="display: block;float: left;margin-right:10px;  color: #595959; text-align: left; "><i class="fa fw fa-user"></i> Project: </span><span style="float:left;"><a style="float:left" class="tiptip" title="Edit " href="#">'+prospect_account+'</a></span></span></p><br><hr/><div><div id="historyTableLoader" style="position: absolute;right: 100px;display: none;top: 44px;"><img src="/static/blue-loader.svg" /></div><a class="btn right blue-button reload_history_table" href="javascript:void(0);" style="border-radius: 5px;padding: 5px 10px 5px 10px;font-size: 14px;margin-bottom: 10px;"><i class="fa fa-fw fa-refresh"></i> Reload</a></div>'+
                                    '<table id="email_events_table" style="width:100%" ><thead><tr><th>Sent</th><th>Subject</th><th>From</th><th>To</th><th class="delivery_column"><div class="badge blue tiptiptop" title="Delivery Status">D</div></th><th class="delivery_column"><div class="badge green tiptiptop" title="Open Status">O</div></th><th class="delivery_column"><i class="fa fa-envelope-o"></i></th></tr></thead><tbody>';
         
       
                        table +='</tbody></table><div style="display:none;" id="email_event_email_content_div"><div style="width:100%;float:left;font-size: 15px;margin-bottom: 15px;text-align:left;"><div style="width:30%;float:left;"><strong>Subject: </strong><span class="content_div_subject">Test subject</span></div><div style="width:30%;float:left;"><strong>From: </strong><span class="content_div_from">Sunil yadav</span></div><div style="width:30%;float:left;"><strong>To: </strong><span class="content_div_to">test@gmail.com</span></div><div style="width:10%;float:left;"><a style="font-size: 14px;margin-bottom: 5px;float:right;padding: 5px;position: relative;" class="show_email_event_table btn ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only " href="#" ><i class="fa fa-chevron-left"></i> Back</a></div><div style="width:100%;float:left;font-size: 15px;margin-bottom: 15px;margin-top: 10px;text-align:left;"><div style="width:30%;float:left;"><strong>Sent: </strong><span class="content_div_sent">07/14/20 1:24 PM</span></div><div style="width:30%;float:left;"><strong>Delivered: </strong><span class="content_div_delievered">07/14/20 1:24 PM</span></div><div style="width:30%;float:left;"><strong>Opened: </strong><span class="content_div_opened">07/14/20 1:24 PM</span></div><div style="width:10%"></div></div></div><div style="float:left;width: 100%;"><textarea id="event_email_content"></textarea></div></div>';

                        swal({
                            title: "<i class='fa fw fa-envelope'></i> Email History",
                            html: table,

                            showCancelButton: false,
                            width: '950px',
                            confirmButtonText: 'Ok',

                            dangerMode: false,
                            showCloseButton: true,
                            onOpen: function () {


                                // CKEDITOR.replace('event_email_content', {
                                //     removePlugins: 'elementspath',
                                //     readOnly: true,
                                //     height: 300
                                // });
                        //tinymce.init({selector: "#event_email_content",menubar: false,statusbar: false,toolbar : false,height:'300',readonly : true});

                                $('.swal2-modal').attr('id', 'send_proposal_popup')

                                hTable = $('#email_events_table').on('processing.dt', function (e, settings, processing) {
                                    if (processing) {
                                        $("#historyTableLoader").show();
                                    } else {
                                        $("#historyTableLoader").hide();
                                    }
                            }).DataTable({
                                    "processing": true,
                                    "serverSide": true,

                                    "ajax": "<?php echo site_url('ajax/get_prospect_email_events_table_data') ?>/" + prospect_id,
                                    "columns": [
                                        {width: '23%', class: 'dtLeft'},                                            // 3 Branch
                                        {width: '20%', class: 'dtLeft'},                                            // 4 Readable status
                                        {width: '15%', class: 'dtLeft'},                              // 5 Status Link
                                        {width: '15%', class: 'dtLeft'},
                                        {width: '8%', class: 'dtCenter', sortable: false},
                                        {width: '7%', class: 'dtCenter', sortable: false},
                                        {width: '8%', class: 'dtCenter', sortable: false},
                                    ],
                                    "sorting": [
                                        [0, "desc"]
                                    ],
                                    "jQueryUI": true,
                                    "autoWidth": true,
                                    "stateSave": false,
                                    "paginationType": "full_numbers",
                                    "dom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop">fl>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"pir>',
                                    "lengthMenu": [
                                        [10, 25, 50, 100, 200, 500, 1000],
                                        [10, 25, 50, 100, 200, 500, 1000]
                                    ],

                                    "drawCallback": function (settings) {
                                        if (!ui) {
                                            initUI();
                                            ui = true;
                                        }
                                        if (pTable) {
                                            $("#filterNumResults").text(pTable.page.info().recordsDisplay);
                                        }
                                        $("#groupSelectAllTop").html('<span id="numSelected">0</span> selected');
                                        $("#prospectMasterCheck").prop('checked', false);
                                        $("#filterResults").show();
                                        $("#filterLoading").hide();

                                    },


                                });


                            },

                        })

                    });

    $(document).on("click",".reload_history_table",function(e) {
        hTable.ajax.reload(null,false )
     });
                    $(document).on("click", ".email_event_email_show_span", function (e) {
                        var event_id = $(this).attr('data-event-id');
                        var sent_at = $(this).attr('data-sent');
                        var delievered_at = $(this).attr('data-delivered');
                        var opened_at = $(this).attr('data-opened');
                        tinymce.remove("#event_email_content");
                        tinymce.init({selector: "#event_email_content",menubar: false,relative_urls : false,remove_script_host : false,convert_urls : true,statusbar: false,toolbar : false,paste_as_text: true,height:'300',readonly : true});

                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {'event_id': event_id},
                            url: "<?php echo site_url('ajax/get_email_event_email_content') ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {

                                //CKEDITOR.instances.event_email_content.setData(data.email_content);
                            tinymce.get("event_email_content").setContent(data.email_content);
                                
                                $('.content_div_subject').text(data.email_subject);
                                $('.content_div_from').text(data.sender_name);
                                $('.content_div_to').text(data.to_email ? data.to_email : '-');
                                $('.content_div_sent').text(sent_at);
                                $('.content_div_delievered').text(delievered_at);
                                $('.content_div_opened').text(opened_at);
                                $('#email_events_table_wrapper').hide();
                                $('#email_event_email_content_div').show();
                            });

                    });

                    $(document).on("click", ".show_email_event_table", function (e) {

                        $('#email_events_table_wrapper').show();
                        $('#email_event_email_content_div').hide();
                    })


                    $(document).on("click", ".send_email_individual", function (e) {
                        $('#newProspectsPopup').hide();
                        var prospect_id = $(this).attr('data-prospect-id');
                        var prospect_name = $(this).attr('data-account');
                        var prospect_comapny_name = $(this).attr('data-comapny-name');
                        var to_email = $(this).attr('data-email');
                        tinymce.remove('#email_content');
                        swal({
                            title: "<i class='fa fw fa-envelope'></i> Send Email",
                            html: '<p style="font-weight: bold; font-size: 16px;"><span style="position: absolute;left: 0px;"><span style="display: block; float: left;  color: #595959; text-align: left; margin-right: 10px;"><i class="fa fw fa-file-pdf-o"></i> Project: </span><span class="shadowz" style="float:left"><a class="tiptip" href="#" >' + prospect_comapny_name + '</a></span></span>' +
                                '<span style="right: 0px;position: absolute;" ><span style="display: block;float: left;margin-right:10px;  color: #595959; text-align: left; "><i class="fa fw fa-user"></i> Contact: </span><span style="float:left;"><a style="float:left" class="tiptip" title="Edit " href="#">' + prospect_name + '</a></span></span></p><br><hr/>' +
                                '<form id="send_proposal_email" >' +
                                '<input type="hidden" class="" name="send_email" value="Send">' +
                                '<input type="hidden" class="send_email_prospect_id" name="prospect_id" value="' + prospect_id + '">' +
                                '<table class="boxed-table pl-striped" style="border-bottom:0px"; width="100%" cellpadding="0" cellspacing="0">'+
                                '<tr>' +
                                    '<td><label style="width: 150px;text-align: left;"> Email Template <span>*</span></label><span class="cwidth4_container" style="float: left;"><select style="border-radius: 3px;padding: 0.4em;width: 314px;" id="sendTemplateSelect"><?php foreach ($clientTemplates as $template) {?><option data-template-id="<?php echo $template->getTemplateId(); ?>"><?php echo $template->getTemplateName(); ?></option><?php } ?></select></span></td>'+
                                    '<td></td>' +
                                '</tr>'+
                                '<tr>' +
                                    '<td><label for="" style="width: 150px;text-align: left;"> To <span>*</span></label><input type="text" id="popup_email_to" name="to" class="text send_to tiptiptop"  title="Separate email addresses by commas" style="width: 300px; float: right;" required value="'+to_email+'"></td>' +
                                    '<td><label for="" style="width: 70px;text-align: left;"> BCC</label><input type="text" name="bcc" class="text input60 send_bcc tiptiptop" title="Separate email addresses by commas" style="width: 300px; float: right; margin-right: 0;" value=""></td>' +
                                '</tr>'+
                                '<tr>' +
                                    '<td><label for="" style="width: 70px;text-align: left;"> Subject <span>*</span></label><input type="text" name="subject" required class="text input60 number_field send_subject" title="Separate email addresses by commas" style="width: 300px; float: right;" id="poup_email_subject"  value=""></td>' +
                                    '<td></td>' +
                                '</tr>' +
                                '<tr>' +
                                    '<td colspan="2"><br/><textarea cols="40" rows="10" id="email_content" name="message">Brief Description here...</textarea></td>'+
                                '</tr>' +
                            '</table>' +
                            '</form>'+
                                '<p style="font-size: 12px;font-weight: bold;padding: 10px 0px 8px 10px;"><span class="send_popup_validation_msg" style="display:none;float:right;font-size: 12px;font-weight: bold;padding: 0px 0px 8px 10px;text-align: left;color: #f00;">Please Fill all required fields.</span></p>',

                            showCancelButton: true,
                            width: '950px',
                            confirmButtonText: '<i class="fa fw fa-envelope"></i> Send',
                            cancelButtonText: "<i class='fa fw fa-times'></i> Cancel",
                            dangerMode: false,
                            showCloseButton: true,
                            onOpen: function () {

                                loadTemplateContentsForEmail();
                                


                                tinymce.init({
                                        selector: "#email_content",
                                        menubar: false,
                                        relative_urls : false,
                                        remove_script_host : false,
                                        convert_urls : true,
                                        browser_spellcheck : true,
                                        contextmenu :false,
                                        paste_as_text: true,
                                        height:'320',
                                        setup:function(ed) {
                                            ed.on('keyup', function(e) {
                                                check_popup_validation()
                                            });
                                        },
                                        plugins: "link image code lists paste preview ",
                                        toolbar: tinyMceMenus.email,
                                        forced_root_block_attrs: tinyMceMenus.root_attrs,
                                        fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
                                });

                               
                                $('.swal2-modal').attr('id', 'send_proposal_popup')
                                // Tiptip the address inputs
                                initTiptip();
                                // Uniform the select
                                $("#sendTemplateSelect").uniform();
                            },


                        }).then(function (result) {
                            swal({
                                title: 'Sending..',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                timer: 10000,
                                onOpen: () => {
                                    swal.showLoading();
                                    $('.swal2-modal').attr('id', '')
                                }
                            })
                            var values, index;

                            // Get the parameters as an array
                            values = $("#send_proposal_email").serializeArray();

                            // Find and replace `content` if there
                            for (index = 0; index < values.length; ++index) {
                                if (values[index].name == "message") {
                                    values[index].value = tinyMCE.activeEditor.getContent();
                                    break;
                                }
                            }
                            $.ajax({
                                type: "POST",
                                async: true,
                                cache: false,
                                data: values,
                                url: "<?php echo site_url('ajax/send_prospect_individual_email') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                dataType: "JSON"
                            }).success(function (data) {
                                console.log(data);
                                swal('', 'Email Sent');
                            });
                        })


                        return false;
                    });



                    $(document).on("keyup", "#poup_email_subject,#popup_email_to", function (e) {
                        if ($(this).val()) {
                            $(this).removeClass('error');

                        } else {
                            $(this).addClass('error');

                        }
                        check_popup_validation()

                    });


                    function check_popup_validation() {
                        if (tinyMCE.activeEditor.getContent() == '' || $('#poup_email_subject').val() == '' || $('#popup_email_to').val() == '') {
                            $('.send_popup_validation_msg').show();
                            $('#send_proposal_popup .swal2-confirm').attr('disabled', true);
                        } else {
                            $('.send_popup_validation_msg').hide();
                            $('#send_proposal_popup .swal2-confirm').attr('disabled', false);
                        }
                    }

                    // Template change handler
                    $(document).on("change", "#sendTemplateSelect", function (e) {

                        loadTemplateContentsForEmail();
                    });

                    function loadTemplateContentsForEmail() {
                        console.log('check')
                        var defaultTemplate = $('#sendTemplateSelect option:selected').data('template-id');
                        var prospect_id = $('.send_email_prospect_id').val()
                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {'templateId': defaultTemplate,'prospect_id':prospect_id},
                            url: "<?php echo site_url('account/ajaxGetProspectTemplateParsed') ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {
                                $("#poup_email_subject").val(data.templateSubject);
                                //CKEDITOR.instances.email_content.setData(data.templateBody);
                                tinymce.get("email_content").setContent(data.templateBody);
                                
                            });

                        //$.uniform.update();
                        //initUI();
                    }

                    $('body').click(function (event) {
                        // console.log('fff')


                        var $trigger3 = $("#prospectsTableDropdownToggle");

                        if ('prospectsTableDropdownToggle' !== event.target.id && !$trigger3.has(event.target).length) {
                            if ($(event.target).parents('#newProspectsPopup').length == 0) {
                                if (event.target.id != 'newProspectsPopup') {
                                    $("#newProspectsPopup").hide();
                                }
                            }
                        }

                    });
                });

                $(document).on("click", ".closeDropdownMenu1", function (e) {
                    $('#newProspectsPopup').hide();

                    return false;
                });
                $(document).on('click', '#addAtCursorEdit', function () {
                    //CKEDITOR.instances.message.insertText($("#templateFields").val());
                    tinymce.activeEditor.execCommand('mceInsertContent', false, $("#templateFields").val());
                });
            </script>
            <div class="javascript_loaded">
                <div id="notes" title="Notes">
                    <form action="#" id="add-note">
                        <p>
                            <label>Add Note</label>
                            <input type="text" name="noteText" id="noteText" style="width: 500px;">
                            <input type="hidden" name="relationId" id="relationId" value="0">
                            <input type="submit" value="Add">
                        </p>
                        <iframe id="notesFrame" src="" frameborder="0" width="100%" height="250px;"></iframe>
                    </form>
                </div>
                <div id="dialog-message" title="Client Information">
                    <p class="clearfix"><strong class="fixed-width-strong">First Name:</strong> <span
                                id="field_firstName"></span></p>

                    <p class="clearfix"><strong class="fixed-width-strong">Last Name:</strong> <span
                                id="field_lastName"></span></p>

                    <p class="clearfix"><strong class="fixed-width-strong">Title:</strong> <span
                                id="field_title"></span></p>

                    <p class="clearfix"><strong class="fixed-width-strong">Company:</strong> <span
                                id="field_company"></span></p>

                    <p class="clearfix"><strong class="fixed-width-strong">Email:</strong> <span
                                id="field_email"></span></p>

                    <p class="clearfix"><strong class="fixed-width-strong">Address:</strong> <span
                                id="field_address"></span></p>

                    <p class="clearfix"><strong class="fixed-width-strong">City:</strong> <span id="field_city"></span>
                    </p>

                    <p class="clearfix"><strong class="fixed-width-strong">Zip:</strong> <span id="field_zip"></span>
                    </p>

                    <p class="clearfix"><strong class="fixed-width-strong">State:</strong> <span
                                id="field_state"></span></p>

                    <p class="clearfix"><strong class="fixed-width-strong">Country:</strong> <span
                                id="field_country"></span></p>

                    <p class="clearfix"><strong class="fixed-width-strong">Cell Phone:</strong> <span
                                id="field_cellPhone"></span></p>

                    <p class="clearfix"><strong class="fixed-width-strong">Business Phone:</strong> <span
                                id="field_businessPhone"></span></p>

                    <p class="clearfix"><strong class="fixed-width-strong">Fax:</strong> <span id="field_fax"></span>
                    </p>
                </div>
                <div id="confirm-delete-message" title="Confirmation">
                    <p>Are you sure you want to delete your prospect? <br>This will delete all the proposals sent to
                        him.</p>
                    <a id="client-delete" href="" rel=""></a>
                </div>
                <div id="delete-prospects" title="Confirmation">
                    <h3>Confirmation - Delete Prospects</h3>

                    <p>This will delete a total of <strong><span id="deleteNum"></span></strong> prospects.</p>
                    <br/>

                    <p>Are you sure that you want to proceed?</p>
                </div>
                <div id="delete-proposals-status" title="Confirmation">
                    <h3>Confirmation</h3>

                    <p id="deleteProposalsStatus"></p>
                </div>
                <div id="change-owner" title="Confirmation">
                    <p>Changing Owner for a total of <span id="changeOwnerNum"></span> prospects:</p><br/>

                    <label for="newOwner">New Owner</label> <select name="newOwner" id="newOwner">
                        <?php
                        foreach ($accounts as $user) {
                            ?>
                            <option
                            value="<?php echo $user->getAccountId() ?>"><?php echo $user->getFullName() ?></option><?php
                        }
                        ?>
                    </select>

                    <p id="changeOwnerStatus"></p>
                </div>
                <div id="send-email" title="Confirmation">
                    <h3>Confirmation - Send Email</h3>

                    <p style="margin-bottom: 15px;">
                        <span style="padding-right: 38px;font-weight:bold">Email Template</span>

                        <select id="templateSelect">
                            <?php
                            foreach ($clientTemplates as $template) {
                                /* @var $template \models\ClientEmailTemplate */
                                ?>
                                <option data-template-id="<?php echo $template->getTemplateId(); ?>"><?php echo $template->getTemplateName(); ?></option>
                                <?php
                            }
                            ?>
                        </select>

                        <?php if ($account->isAdministrator()) { ?>
                            <span style="float: right;padding-right: 205px;"><input type="checkbox"
                                                                                    id="emailCustom"> <span
                                        style="display: inline-block; padding-top: 2px;"> Customize Email Sender Info</span></span>

                        <?php } ?>
                        <!-- <span style="float: right;padding-right: 15px;"><input type="checkbox" id="emailCC"> <span
                            style="display: inline-block; padding-top: 2px;"> Send CC to User</span></span> -->


                    </p>
                    <p>

                        <span style="padding-right: 13px;font-weight:bold">Choose Campaign:</span>

                        <select name="resendId" id="resendSelect">
                            <option value="">Select Resend Campaign</option>
                            <option value="0">New</option>
                            <option value="-1">No Campaign</option>
                            <?php

                            foreach ($resends as $resend) {
                                /* @var $template \models\ClientEmailTemplate */
                                ?>
                                <option value="<?php echo $resend->id; ?>"><?php echo $resend->resend_name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <label style="padding-left: 150px;font-weight:bold" class="no_campaign">Campaign Name:</label>
                        <input type="text" class="text new_resend_name no_campaign" name="new_resend_name"/>

                    </p>
                    <br/>


                    <p style="margin-bottom: 15px;">
                        <span style="width: 100px; display: inline-block;padding-right: 39px;font-weight:bold ">Subject:</span><input
                                class="text" type="text" id="messageSubject" style="width: 225px;">

                        <label style="padding-left: 150px;font-weight:bold" class="no_campaign">Add Field:</label>
                        <select id="templateFields">
                            <option value="">- Select a field</option>
                            <?php
                            foreach ($email_template_fields as $fields) {
                                ?>
                                <option value="{<?php echo $fields->field_code; ?>}"><?php echo $fields->field_name; ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        <a class="btn" href="javascript:void(0);" id="addAtCursorEdit"><i
                                    class="fa fa-fw fa-plus-circle"></i> Add</a>


                    </p>
                    <?php if ($account->isAdministrator()) { ?>
                        <p class="emailFromOption" style="color: #b81900; margin-bottom: 10px;">Leave blank for the
                            emails to come from
                            the owner of the proposal.</p>
                        <p class="emailFromOption" style="margin-bottom: 10px;"><span
                                    style="width: 100px;font-weight:bold; display: inline-block">From Name:</span><input
                                    class="text"
                                    type="text"
                                    id="messageFromName"
                                    style="width: 200px;"><span
                                    style="padding-left: 50px;width: 100px;font-weight:bold; display: inline-block">From Email:</span><input
                                    class="text" type="text" id="messageFromEmail" style="width: 200px;"></p>

                    <?php } ?>


                    <textarea id="message">This is the content</textarea>


                    <p>This will send a total of <strong><span id="resendNum"></span></strong> email(s) to the
                        prospects.</p>
                    <br/>

                    <p>Are you sure that you want to proceed?</p>
                </div>
                <div id="email-feedback" title="Send Prospect Email(s)">
                    <p id="feedbackText"></p>
                </div>

                <div id="change-source" title="Change Prospect Source">
                    <p>Changing Source for a total of <span id="changeSourceNum"></span> prospects:</p><br/>

                    <label for="newSource">New Source</label> <select name="newSource" id="newSource">
                        <?php
                        foreach ($prospectSources as $prospectSource) {
                            ?>
                            <option
                            value="<?php echo $prospectSource->getId(); ?>"><?php echo $prospectSource->getName(); ?></option><?php
                        }
                        ?>
                    </select>

                    <p id="changeSourceStatus"></p>
                </div>


            </div>
        </div>
    </div>

    <div id="template" style="display: none;">
        <div class="dropdownMenuContainer single">

            <div class="closeDropdown closeProspectDropdown" style="line-height: 10px;position: absolute;right: 0;">
                <a href="javascript:void(0);" class="closeDropdownMenu1">&times;</a>
            </div>

            <div class="" style="font-size: 17px;padding:8px 15px;    border-bottom: 1px solid #e2e2e2;">
                <p>Propect Options</p>
            </div>

            <div class="" style="font-size: 18px;padding:8px 15px;">
                <p style="text-align: center;">{companyName} | {prospectFullname}</p>
            </div>
            <ul class="dropdownMenu">

                <li>
                    <a href="<?php echo site_url('prospects/edit/{prospectId}'); ?>">
                        <img src="/3rdparty/icons/user_edit.png"> Edit Prospect
                    </a>
                </li>
                <li>
                    <a class="send_email_individual"
                       data-prospect-id="{prospectId}"
                       data-account="{prospectFullname}"
                       data-comapny-name="{companyName}"
                       data-email="{prospectEmail}"
                       href="javascript:void(0);">
                        <img src="/3rdparty/icons/email_go.png"> Send Email
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('prospects/delete/{prospectId}'); ?>"
                       rel="<?php echo site_url('prospects/delete/{prospectId}'); ?>" class="confirm-deletion">
                        <img src="/3rdparty/icons/delete.png"> Delete Prospect
                    </a>
                </li>
                <li>
                    <a href="#" class="notes" rel="{prospectId}">
                        <img src="/3rdparty/icons/comments.png"> Prospect Notes
                    </a>
                </li>

            </ul>
            <ul class="dropdownMenu">


                <li class="">
                    <a title="View on Map" href="https://www.google.com/maps/place/{url}" target="_blank">
                        <img src="/3rdparty/icons/map.png"> See on Map
                    </a>
                </li>
                <li>
                    <a href="<?php echo site_url('leads/add/{prospectId}'); ?>">
                        <img src="/3rdparty/icons/arrow_switch.png"> Convert to Lead
                    </a>
                </li>
                <li>
                    <a href="#" class="scheduleProspectCall" data-prospect="{prospectId}"
                       data-account="{prospectAccount}"
                       data-prospectname="{prospectFullname}" data-phone="{prospectPhone}">
                        <img src="/3rdparty/icons/time_add.png"> Schedule an Event
                    </a>
                </li>
                <li>
                    <a href="javascript:void(0);" rel="{prospectId}" class="email_events"
                       data-prospect-id="{prospectId}"
                       data-account="{prospectFullname}"
                       data-comapny-name="{companyName}"
                    >
                        <img src="/3rdparty/icons/time_add.png"> Email history
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <style>
        .checker {
            float: none !important;
        }
    </style>
    <!--#content-->
<?php $this->load->view('global/footer'); ?>