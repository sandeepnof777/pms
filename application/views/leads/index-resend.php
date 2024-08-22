<?php /* @var $account \models\Accounts */ ?>
<?php $this->load->view('global/header'); ?>
<style>
    .dataTables-leads{
  table-layout: fixed;
  width: 100% !important;
}
.paging_full_numbers {
    width: 500px !important;
}
.dataTables_info {
    width: 46%!important;
    clear: none!important;
}
.error_editor {
    border: 2px solid #FBC2C4;
}
#cke_event_email_content .cke_reset_all{
            display:none
        }
#email_events_table_info{
    width: 18%!important;
    clear: none!important;
}
#newLeadsPopup{
    padding-bottom: 10px;
}
#addAtCursorEdit{
  position: absolute;
    margin-top: 1px;
    margin-left: 16px;
}
#addAtCursorEdit span{
  padding-top: 2px;
    padding-bottom: 2px;
}

#uniform-templateFields span {
        width: 125px!important;
    }

    #uniform-templateFields {
        width: 150px!important;
        margin-left: 41px;
    }
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
        /* #summary_popup .tox-tinymce{
            border: 0px;   
        } */
        .filter_info_icon:hover{color: #25AAE1!important;}
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
    <div id="content">
        <div class="widthfix">

        <input type="hidden" id="delayUI" value="1">  
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
                            <span class="failed_top_icon tiptipleft right" style="display: none;cursor:pointer;border-bottom: none;" title="<?=$resendStats['failed_count'];?> Lead email failed to send. Click to view"><img style="margin-top: 3px;margin-right: 8px;"  src="/3rdparty/icons/warning-sign.png"></span>
                        <?php } ?>
                        <i class="fa fa-fw fa-envelope"></i> Lead Campaign: <span style="color: #a09b9b;"><?php echo $resend->getResendName(); ?></span> 
                        
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
                                <a href="<?php echo site_url('leads/resend/' . $resend->getId()) ?>" data-filter="">View All</a>
                            </div>
                        </div>
                    </div>

                    <div class="col s2custom">
                        <div class="card statCard<?php if ($campaignEmailFilter == 'delivered') { echo ' highlightedCard'; } ?>">
                            <div class="card-content">
                                <strong><i class="fa fa-fw fa-envelope-square"></i> Delivered: </strong>
                            </div>
                            <div class="card-action">
                                <a href="<?php echo site_url('leads/resend/' . $resend->getId() . '/delivered') ?>" data-filter="delivered">
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
                                <a href="<?php echo site_url('leads/resend/' . $resend->getId() . '/opened') ?>" data-filter="opened">
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
                                <a href="<?php echo site_url('leads/resend/' . $resend->getId() . '/clicked') ?>" data-filter="clicked">
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
                                <a href="<?php echo site_url('leads/resend/' . $resend->getId() . '/unopened') ?>" data-filter="unopened">
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
                                <a href="<?php echo site_url('leads/resend/' . $resend->getId() . '/bounced') ?>" data-filter="bounced">
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
                    <p class="adminInfoMessageWarning check_failed_count_msg" ><i class="fa fa-fw fa-info-circle"></i> <?php echo $resendStats['failed_count'] ?> Leads email failed to send in this campaign. <a href="/leads/resend/<?=$resend->getId();?>/failed">View Leads</a><span class="close_failed_info_batch"><i class="fa fa-fw fa-close"></i></span></p>
                <?php }?>    
        <?php }else{?> 
            <p class="adminInfoMessageWarning  failed_count_msg" style="display: none;"><i class="fa fa-fw fa-info-circle"></i> <?php echo $resendStats['failed_count'] ?> Leads failed to send in this campaign. <a href="#" class="reload_failed" data-filter="failed">View Leads</a> <span class="close_failed_info_batch"><i class="fa fa-fw fa-close"></i></span></p>
            <p class="adminInfoMessageWarning view_leads_msg "  ><i class="fa fa-fw fa-info-circle"></i> You are viewing the Leads that failed to send in the campaign. Click the buttons above to see the sent leads.</p>
        <?php }?>
        <div class="clearfix"></div>
            <?php $this->load->view('leads/resend-filters'); ?>

            <div class="content-box">
                <div class="box-header">
                        <!-- <div style="position: absolute; left: 0px; top: 6px;" id="groupActions2">

                            <a class="box-action tiptip printLeads" href="#" title="Print the selected leads">Print
                                Leads</a>
                            <a class="box-action tiptip resend" href="#" title="Resend Lead Emails">Resend</a>
                            <a class="tiptip box-action planRoute" href="#" title="Plan A Route to selected leads">Plan
                                Route</a>
                            <a class="tiptip box-action sendEmail" href="#" title="Send Email to all leads">Send
                                Email</a>
                            <?php if ($account->getUserClass() >= 3) { ?>
                                <a class="tiptip box-action changeOwner" href="#" title="Change Leads Owner">Change
                                    Owner</a>
                            <?php } ?>
                            <a class="tiptip box-action deleteLeads" href="#" title="Delete all checked leads">Delete Leads</a>
                            <a class="tiptip box-action deleteLeads" href="#" title="Delete all checked leads">Cancel
                                Leads</a>
                        </div> -->

                    <?php if (help_box(21)) { ?>
                        <div class="help right tiptip" title="Help"><?php help_box(21, true) ?></div>
                    <?php } ?>Leads

                    <div id="leadsTableLoader" style="width: 150px; position: absolute; left: 422px; top: 8px; display: none;">
                        <img src="/static/loading-bars.svg">
                    </div>
                    
                    <?php
                        $leadsUri = 'leads/index';
                        if ($filter) {
                            $leadsUri .= '/filter/' . $this->uri->assoc_to_uri($filter);
                        }
                        ?>

                </div>
                <div class="box-content" style="width: 950px; overflow-y: scroll; overflow-y: hidden;">
                    <div id="leadsTableContainer" style="width: 1100px;">
                        <table cellpadding="0" cellspacing="0" border="0" class="dataTables-leads display" id="leadsTable">
                            <thead>
                            <tr>
                                <td><input type="checkbox" id="leadMasterCheck"></td>
                                <td>Go</td>
                                <td>Created</td>
                                <td>Business</td>
                                <td>Source</td>
                                <td>Status</td>
                                <td>Rating</td>
                                <td>Due Date</td>
                                <td>Company</td>
                                <td>Zip</td>
                                <td>Project Name</td>
                                <td>Contact</td>
                                <td>Owner</td>
                                <td>Last Activity Int</td>
                                <td>Last Activity</td>
                                <td>Opened at</td>
                            </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>

                    <form id="selectedLeadsForm" method="post" action="<?php echo site_url('leads/map'); ?>">
                    </form>

                </div>


            </div>

<div id="datatablesError" title="Error" style="text-align: center; display: none;">
    <h3>Oops, something went wrong</h3>

    <p>We're having a problem loading this page.</p><br />
    <p>Click to retry, or <a href="mailto:support@<?php echo SITE_EMAIL_DOMAIN; ?>&subject=Support: Help with Table">contact support</a> if this keeps happening.</p>
</div>
<script type="text/javascript">
var leadFilter;
var resend_id = '<?=$resend->getId();?>';
    $(document).ready(function() {
        
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
function getFilterValue() {
    return $("#campaignEmailFilter").val();
}
            var oTable;
                $(document).ready(function () {

                    var ui = false;
                    $.fn.dataTable.ext.errMode = 'none';
                    // Need to do this as we're delaying the UI
                    preUI();

                    function initTable(redraw) {

                        oTable =  $('.dataTables-leads').on( 'error.dt', function ( e, settings, techNote, message ) {
                            console.log( 'An error has been reported by DataTables: ', message );
                            $("#datatablesError").dialog('open');
                        })
                        .on('processing.dt', function (e, settings, processing) {
                            if (processing) {
                                $("#leadsTableLoader").show();
                            } else {
                                $("#leadsTableLoader").hide();
                            }
                        })
                        .DataTable( {
                            "fixedHeader": false,
                            "processing": true,
                            "serverSide": true,
                            
                            "ajax": {
                                        url: "<?php echo site_url('ajax/ajaxGetLeads?action=resend&resend_id=').$this->uri->segment(3); ?>",
                                        data: function(d) {
                                            d.type = getFilterValue();
                                        }
                                    },


                            "columnDefs": [
                                {
                                    "targets": [ 0 ],
                                    "width":'15px',
                                    "searchable": false,
                                    "sortable": false
                                },
                                {"targets": [ 1 ],"sortable": false, "width": "60px"},
                                {"targets": [ 2 ],"sortable": true,"type": "date-formatted"},
                                {"targets": [ 3 ],"sortable": false,"width": "110px"},
                                {"targets": [ 4 ],"sortable": true},
                                {"targets": [ 5 ],"sortable": true},
                                {"targets": [ 6 ],"sortable": true},
                                {"targets": [ 7 ],"sortable": true},
                                {"targets": [ 8 ],"sortable": true},
                                {"targets": [ 9 ],"type": "html", "width": "50px"},
                                {"targets": [ 10 ],"sortable": true},
                                {"targets": [ 11 ],"sortable": true, "width": 'auto'},
                                {"targets": [ 12 ],"searchable": false,"sortable": false},
                                {"targets": [ 13 ],"visible": false},
                                {"targets": [ 14 ],"searchable": false,"orderData": 13},
                                {"targets": [ 15 ],"searchable": false}
                            ],
                            "sorting": [
                                [2, "desc"]
                            ],
                            "jQueryUI": true,
                            "autoWidth": true,
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
                                        initUI(true);
                                        ui = true;
                                            }

                                    $.uniform.update();
                                    initTiptip();
                                    notes_tooltip();
                                    check_highlighted_row();
                                    updateGroupButtons();
                                    if (oTable) {
                                        $("#filterNumResults").text(oTable.page.info().recordsDisplay);
                                    }

                                    $("#groupSelectAllTop").html('<span id="numSelected">0</span> selected');
                                    $("#leadMasterCheck").prop('checked', false);
                                    $("#filterLoading").hide();
                                    $("#filterResults").show();
                                    //$("#groupSelectAllTop").html('<a href="#" id="selectAll">All</a> / <a href="#" id="selectNone">None</a>&nbsp;&nbsp;&nbsp;<span id="numSelected">0</span> selected');
                                    oTable.columns.adjust();
                                }
                        } );


                        var column_show = localStorage.getItem("lead_column_show_22_12");
                        if(column_show){
                            oTable.columns( [2,3,4,5,6,7,8,9,10,11,12,14,15] ).visible( false );
                            oTable.columns( column_show ).visible( true );
                            var column_show = column_show.split(',');
                            

                            for($i=0;$i < column_show.length;$i++){
                                $("input[name=column_show][value="+column_show[$i]+"]").prop("checked",true);
                            }

                        } else {

                            var column_show = [2,3,4,5,6,7,8,9,10,11,12,14,15];
                            oTable.columns( column_show ).visible( true );
                            for($i=0;$i < column_show.length;$i++){
                                $("input[name=column_show][value="+column_show[$i]+"]").prop("checked",true);
                            }
                        }



                    }

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
                    $(".btn-delete, .confirm-delete, .btn-cancel, .confirm-cancel").live('click', function () {
                        $('#newLeadsPopup').hide();
                        $("#client-delete").attr('rel', $(this).attr('href'));
                        $("#confirm-delete-message").dialog('open');
                        return false;
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
                    $(".btn-notes, .lead-notes").live('click', function () {
                        $('#newLeadsPopup').hide();
                        var id = $(this).attr('rel');
                        var frameUrl = '<?php echo site_url('account/notes/lead') ?>/' + id;
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
                                "noteType": 'lead',
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

                    $(".resendAudit").live('click', function () {
                        $('#newLeadsPopup').hide();
                        var leadId = $(this).data('lead-id');

                        $('.auditSent').hide();
                        $('.auditSending').show();
                        $('#audit-resent').dialog('open');

                        $.ajax({
                            url: '<?php echo site_url('ajax/leadResendAudit') ?>',
                            type: "POST",
                            data: {
                                "leadId": leadId
                            },
                            dataType: "json"
                        })
                            .success(function (data) {
                                $('.auditSent').show();
                                $('.auditSending').hide();
                            });
                        return false;
                    });

                    $(".resend").live('click', function () {

                        var counter = getSelectedIds().length;

                        swal({
                            title: "Resend " + counter + ' leads?',
                            text: "Unassigned leads will not be sent anywhere.",
                            showCancelButton: true,
                            confirmButtonColor: "#25aae1",
                            confirmButtonText: "Resend"
                        }).then(function () {
                            $.ajax({
                                url: '<?php echo site_url('ajax/groupLeadResend') ?>',
                                type: "POST",
                                data: {
                                    "ids": getSelectedIds()
                                },
                                dataType: "json"
                            })
                            .success(function (data) {

                                swal('', data.count + ' leads resent!', '');

                                $(".groupSelect").prop('checked', false);
                                updateGroupButtons();
                            });
                        }).catch(swal.noop);
                        return false;
                    });

                    //group stuff here
                    //$.uniform.restore(".groupSelect"); //remove uniform for the checkboxes on the page
                    function updateGroupButtons() {
                        var counter = $(".groupSelect:checked").length;
                        if (counter > 0) {
                            $("#groupActions").show();
                        } else {
                            $("#groupActions").hide();
                        }

                        if (counter > 7) {
                            $('.planRoute').hide();
                        }
                        else {
                            $('.planRoute').show();
                        }


                        $("#numSelected, #deleteNum, #changeOwnerNum, #resendNum").html(counter);
                    }

                    $("#groupActions").hide();
                    $(".groupSelect:checked").removeAttr('checked');
                    updateGroupButtons();
                    $(".groupSelect").live('change', function () {
                        updateGroupButtons();
                    });
                    $(".changeOwner").click(function () {
                        $("#change-owner").dialog('open');
                    });

                    function getSelectedIds() {

                        var IDs = new Array();

                        $(".groupSelect:checked").each(function () {
                            IDs.push($(this).data('lead-id'));
                        });

                        return IDs;
                    }

                    $(".deleteLeads").click(function () {
                        $("#delete-prospects").dialog('open');
                        return false;
                    });

                    //group stuff but needs to be here because i'm too lazy
                    $("#delete-prospects").dialog({
                        width: 500,
                        modal: true,
                        buttons: {
                            "Delete": {
                                text: 'Cancel Leads',
                                'class': 'btn ui-button update-button',
                                'id': 'confirmDelete',
                                click: function () {
                                    $.ajax({
                                        type: "POST",
                                        async: true,
                                        cache: false,
                                        data: {'ids': getSelectedIds()},
//                                        url: "<?php //echo site_url('ajax/groupDeleteLeads') ?>//?" + Math.floor((Math.random() * 100000) + 1),
                                        url: "<?php echo site_url('ajax/groupCancelLeads') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                        dataType: "JSON"
                                    }).success(function (data) {
                                        $("#deleteProposalsStatus").html('Done!');
                                        document.location.reload();
                                    });
                                    $(this).dialog('close');
                                    $("#deleteProposalsStatus").html('Cancelling leads, please wait... <img src="/static/loading.gif" />');
                                    $("#delete-proposals-status").dialog('open');
                                }
                            },
                            Cancel: function () {
                                $(this).dialog("close");
                            }
                        },
                        autoOpen: false
                    });
                    //Leads Status Update
                    $("#delete-proposals-status").dialog({
                        width: 500,
                        modal: true,
                        buttons: {
                            OK: function () {
                                $(this).dialog('close');
                                oTable.ajax.reload();
                            }
                        },
                        autoOpen: false
                    });
                    //Leads Status Update
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
                                        url: "<?php echo site_url('ajax/groupLeadsChangeOwner') ?>?" + Math.floor((Math.random() * 100000) + 1),
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
                    // All
                    // $("#selectAll").live('click', function () {
                    //     $(".groupSelect").attr('checked', 'checked');
                    //     updateGroupButtons();
                    //     return false;
                    // });

                    // // None
                    // $("#selectNone").live('click', function () {
                    //     $(".groupSelect").attr('checked', false);
                    //     updateGroupButtons();
                    //     return false;
                    // });

                    $("#leadMasterCheck").change(function () {
                        var checked = $(this).is(":checked");
                        $(".groupSelect").prop('checked', checked);
                        updateGroupButtons();
            });

                    /*Send Email Functioanlity*/
                

                    $(".sendEmail").click(function () {
                        tinymce.remove();
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
                        return false;
                    });

                    $("#email-feedback").dialog({
                        width: 500,
                        modal: true,
                        buttons: {
                            OK: function () {
                                //location.reload();
                                $(this).dialog("close");
                                oTable.ajax.reload();
                            }
                        },
                        autoOpen: false
                    });

                    $(".sendAuditEmails").click(function () {
                        $("#send-audit-emails").dialog('open');
                        return false;
                    });

                    $("#audit-email-feedback").dialog({
                        width: 500,
                        modal: true,
                        buttons: {
                            OK: function () {
                                $(this).dialog('close');
                            }
                        },
                        autoOpen: false
                    });

                    $("#delete-proposals-status").dialog({
                        width: 500,
                        modal: true,
                        buttons: {
                            OK: function () {
                                $(this).dialog('close');
                                oTable.ajax.reload();
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
                    //var defaultTemplate = $('#templateSelect option:selected').data('template-id');
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
                                tinymce.get("message").setContent(data.templateBody);
                            });

                        $.uniform.update();
                    }

                    /* Audit Email Functionality */
                    var audit_template_editor = CKEDITOR.replace('auditMessage', {
                        height: 250
                    });

                    // Resend dialog
                    $("#send-email").dialog({
                        width: 950,
                        modal: true,
                        open: function () {
                            $("#emailCustom").attr('checked', false);
                            $(".emailFromOption").hide();
                            $("#resendSelect").val('0');
                            $("#resendSelect").trigger('change')
                            $.uniform.update();
                        },
                        buttons: {
                            "Resend": {
                                text: 'Send Email',
                                'class': 'btn ui-button update-button',
                                'id': 'confirmResend',
                                click: function () {

                                    if ($("#emailCustom").attr('checked')) {

                                        if (!$("#messageFromName").val() || !$("#messageFromEmail").val()) {
                                            alert('Please enter a from name and email address');
                                            return false;
                                        }
                                    }
                                    if($('#resendSelect').val()==0 && !$('.new_resend_name').val()){
                                        alert('Please enter Resend Name');
                                            return false;
                                    }

                                    $('#email-feedback').dialog('open');
                                    $('#feedbackText').text('Sending mail');

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
                                            'leadFilter': leadFilter},
                                        url: "<?php echo site_url('ajax/groupLeadsSendEmail') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                        dataType: "JSON"
                                    })
                                        .success(function (data) {

                                            if (data.success) {
                                                msg ='<span style="font-weight:bold">'+ data.counter + ' lead emails sent</span>';

                                                if (data.noEmailCounter) {
                                                    msg += "<br /><br />" + data.noEmailCounter + " email(s) could not be sent as the lead has no email address."
                                                }

                                                if (data.unassignedCounter) {
                                                    msg += "<br /><br />" + data.unassignedCounter + " email(s) could not be sent as the lead has not been assigned to a user."
                                                }
                                                if (data.duplicateEmailCount) {
                                                    msg += "<br /><br />" + data.duplicateEmailCount + " email(s) not sent as they were duplicate email addresses."
                                                }
                                                
                                            }
                                            else {
                                                msg = 'An error occurred. Please try again';
                                            }

                                            $('#feedbackText').html(msg);

//                                $("#resendProposalsStatus").html(resendText);
//                                $("#resend-proposals-status").dialog('open');

                                        });
                                    $(this).dialog('close');
                                    get_lead_resend_lists();
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


$(document).on("keyup",".new_resend_name",function(e) {
         
         if($(this).val()){
             $(this).removeClass('error');
         }else{
            
            if($("#resendSelect").val() == 0){
                $(this).addClass('error');
            }
         }
        
     });


function get_lead_resend_lists(){

    $.ajax({
        url: '<?php echo site_url('ajax/get_lead_resend_lists') ?>',
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

$("#resendSelect").live('change', function () {
       // alert('ff');return false;
       $('.no_campaign').show()
       if($("#resendSelect").val() <1){
            $('.new_resend_name_span').show();
            $(".new_resend_name").prop('disabled', false);
           if($("#resendSelect").val() ==0){
                $(".new_resend_name").val('<?=date("m/d/Y h:ia");?>');
            }else{
                $(".new_resend_name").val('');
                $('.no_campaign').hide()
                
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

            //CKEDITOR.instances.message.setReadOnly(false);
            tinymce.get('message').mode.set("design");
            $.uniform.update();
           
       }else{
           
         
            $.ajax({
            url: '<?php echo site_url('ajax/get_lead_resend_details') ?>',
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
                   $(".new_resend_name").prop('disabled', true);
                   $('.is_templateSelect_disable').css('display','block');
                   if(data.email_cc==1){
                        $( "#emailCC" ).prop( "checked", true );
                        $('#emailCC').prop('disabled', true);
                        $.uniform.update();
                   }else{
                        $( "#emailCC" ).prop( "checked", false );
                        $('#emailCC').prop('disabled', true);
                        $.uniform.update();
                   }
                   
                   $(".new_resend_name").val(data.resend_name);
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
                  
                    $('#messageFromName').prop('disabled', true); 
                   $('#messageFromEmail').prop('disabled', true); 
                   //$('#message').val(data.email_content);
                   //CKEDITOR.instances.message.setData(data.email_content);
                   tinymce.get('message').setContent(data.email_content);
                   tinymce.get('message').mode.set("readonly");
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
                    $("#send-audit-emails").dialog({
                        width: 700,
                        modal: true,
                        open: function () {
                            $("#auditEmailCustom").attr('checked', false);
                            $(".auditEmailFromOption").hide();
                            $.uniform.update();
                        },
                        buttons: {
                            "Send": {
                                text: 'Send Email',
                                'class': 'btn ui-button update-button',
                                'id': 'confirmResend',
                                click: function () {

                                    if ($("#auditEmailCustom").attr('checked')) {

                                        if (!$("#auditMessageFromName").val() || !$("#auditMessageFromEmail").val()) {
                                            alert('Please enter a from name and email address');
                                            return false;
                                        }
                                    }

                                    // Progress dialog
                                    $('#auditFeedbackLoader').show();
                                    $('#auditFeedbackText').text('Sending mail');
                                    $('#audit-email-feedback').dialog('open');

                                    $.ajax({
                                        type: "POST",
                                        async: true,
                                        cache: false,
                                        data: {
                                            'ids': getSelectedIds(),
                                            'subject': $("#auditMessageSubject").val(),
                                            'body': CKEDITOR.instances.auditMessage.getData(),
                                            'fromName': $("#auditMessageFromName").val(),
                                            'fromEmail': $("#auditMessageFromEmail").val()
                                        },
                                        url: "<?php echo site_url('ajax/groupLeadsSendAuditEmail') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                        dataType: "JSON"
                                    })
                                        .success(function (data) {

                                            var msg = '';

                                            if (data.success) {
                                                msg = data.counter + ' audit links were sent';

                                                if (data.noEmailCounter) {
                                                    msg += "<br /><br />" + data.noEmailCounter + " email(s) could not be sent as the lead has no audit or is not assigned to a user."
                                                }
                                            }
                                            else {
                                                msg = 'An error occurred. Please try again';
                                            }

                                            $('#auditFeedbackLoader').hide();
                                            $('#auditFeedbackText').html(msg);

                                        });
                                    $(this).dialog('close');

                                }
                            },
                            Cancel: function () {
                                $(this).dialog("close");
                            }
                        },
                        autoOpen: false
                    });

                    // Proposal Resend options
                    // $("#emailCustom").change(function () {
                    //     if ($("#emailCustom").attr('checked')) {
                    //         $(".emailFromOption").show();
                    //     }
                    //     else {
                    //         $(".emailFromOption").hide();
                    //         $(".emailFromOption input").val('');
                    //     }
                    // });

                    $(document).on('change', "#emailCustom", function () {
                        if ($("#emailCustom").attr('checked')) {
                            $(".emailFromOption").show();
                        }
                        else {
                            $(".emailFromOption").hide();
                            $(".emailFromOption input").val('');
                        }
                    });

                    // Audit Send Options
                    $("#auditEmailCustom").change(function () {
                        if ($("#auditEmailCustom").attr('checked')) {
                            $(".auditEmailFromOption").show();
                        }
                        else {
                            $(".auditEmailFromOption").hide();
                            $(".auditEmailFromOption input").val('');
                        }
                    });

                    $(".planRoute").click(function () {
                        $("#selectedLeadsForm").html('');

                        var ids = getSelectedIds();

                        $.each(ids, function (index, value) {
                            var inputText = '<input type="hidden" name="leads[]" value="' + value + '" />';
                            $("#selectedLeadsForm").append(inputText);
                        });
                        $("#selectedLeadsForm").submit();
                    });

                    $("#audit-resent").dialog({
                        'modal': true,
                        'autoOpen': false,
                        buttons: {
                            Ok: function () {
                                $(this).dialog("close");
                            }
                        }
                    });

                    /**
                     * Print Leads click event
                     */
                    $(".printLeads").on('click', function () {
                        var ids = getSelectedIds();
                        var pdfUrl = '<?php echo site_url('pdf/lead') ?>/' + ids.join('-');
                        var win = window.open(pdfUrl, '_blank');
                        win.focus();
                    });

                    var oTable = null;

                    $(document).ready(function () {

                        $(".filterButton").click(function () {
                            $(".newFilterContainer").toggle();
                            $(".groupActionsContainer").hide();
                        });

                        $("#newProposalFilterButton").click(function () {
                            hideInfoSlider();
                            $("#newProposalFilters").toggle();
                            // Clear search so that filters aren't affected
                            oTable.search('');
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

                        
                // Toggle the dropdown
                $(".toggleProposalCampaignDetails").click(function() {
                    $("#campaignProposalsContainer").toggleClass('expanded');
                    return false;
                });

                

                // Toggle the card links when clink
                $(".statCard").click(function() {
                    // Handle highlighting
                    if(!$('.failed_top_icon').is(":visible")){
                        $('.failed_count_msg').show();
                    }
                    
                    $('.view_leads_msg ').hide();
                    $(".card").removeClass('highlightedCard');
                    $(this).addClass('highlightedCard');
                    // Set the filter value
                    $("#campaignEmailFilter").val($(this).find('.card-action a').data('filter'));
                    $("#campaignEmailsFilterCount").text($(this).find('.card-action a').data('filter') ? $(this).find('.card-action a').data('filter') : 'All');
                    // Reload the table
                    oTable.ajax.reload();

                    return false;
                });

                $(".reload_failed").click(function() {
                    // Handle highlighting
                    $('.failed_count_msg').hide();
                    $('.view_leads_msg').show();
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
                        $('.view_leads_msg').show();
                    }else{
                        $('.check_failed_count_msg').show();
                        $('.failed_count_msg').show();
                        $('.view_leads_msg').hide();
                    }
                   
                    $('.failed_top_icon').hide();
                });
                


                // Dialog for email content
                $("#emailContentDialog").dialog({
                    modal: true,
                    autoOpen: false,
                    width: 900
                });

                // $(".showEmailContent").click(function() {
                //     $("#emailContentDialog").dialog('open');
                //     return false;
                // });

                $(".showEmailContent").click(function() {

                    // var email_content = "";
                    var email_content = $('#email-preview').html();
                    var subject = "<?=$resend->getSubject();?>";
                    var sent_time = "<?=$resend->getCreated()->format('m/d/y g:ia');?>";
                    var custom_sender = "<?=$resend->getCustomSender()?>";
                    var filters = '<?=$resend->getFilters()?>';
                    if(filters){
                        var lead_filters = JSON.parse('<?=$resend->getFilters()?>');
                    }else{
                        var lead_filters = false;
                    }
                    var custom_sender_details = "Lead Owner";
                    if(custom_sender=='1'){
                        var custom_sender_details = "<?=$resend->getCustomSenderName().' | '.$resend->getCustomSenderEmail();?>";
                    }



                    var filter_text = "";
                    var filter_count =0;
                    if(lead_filters){
                        
                        
                        if(lead_filters.pResendType){
                            filter_count++;
                            filter_text += "<p><strong style='text-align:left;'>Resend :</strong>"+lead_filters.pResendType+"</p><br/>";
                        }
                        
                        if(lead_filters.lFilterUser){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<lead_filters.lFilterUser.length;$i++){
                                temp_text +=lead_filters.lFilterUser[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Users:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                        }
                        
                        
                        
                        if(lead_filters.lFilterSource){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<lead_filters.lFilterSource.length;$i++){
                                temp_text +=lead_filters.lFilterSource[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Source:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
                        }

                        if(lead_filters.lFilterStatus){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<lead_filters.lFilterStatus.length;$i++){
                                temp_text +=lead_filters.lFilterStatus[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Status:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
                        }
                        if(lead_filters.lFilterBusinessType){
                            filter_count++;
                            var temp_text ='';
                            for($i=0;$i<lead_filters.lFilterBusinessType.length;$i++){
                                temp_text +=lead_filters.lFilterBusinessType[$i]+'<br/>';
                            }
                            filter_text += "<table><tr><td style='vertical-align: top;'><strong style='text-align:left;'>Business:</strong></td><td style='text-align: left;'><span>"+temp_text+"</span></td></tr></table><br/>";
                            
                        }

                        var createdText='';
                        if(lead_filters.lFilterDateStart !=''){
                            createdText += "<p><strong style='text-align:left;'>Created:</strong>From "+lead_filters.lFilterDateStart;
                        }
                        if(lead_filters.lFilterDateEnd !=''){
                            if(createdText !=''){
                                createdText +=' To '+lead_filters.lFilterDateEnd+'</p><br/>';
                            }else{
                                createdText +="<p><strong style='text-align:left;'>Created:</strong>Before "+lead_filters.lFilterDateEnd+"</p><br/>";
                            }
                            
                        }else{
                            if(createdText !=''){
                                createdText +='</p><br/>';
                            }
                        }
                        filter_text +=createdText;
                        if(createdText !=''){
                                filter_count++;
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


            return false;
            });



            
            $(".reload_table").click(function () {
                $("#child_resend").trigger('change');
                $( this ).find('i').addClass( 'fa-spin' );
                var $el = $(this);
                setTimeout(function() { $el.find('i').removeClass( 'fa-spin' ); }, 1000);
            });        

            $("#child_resend").change(function () {
                $.ajax({
                    url: '/ajax/change_lead_child_resend',
                    type: "POST",
                    dataType: "json",
                    data: {
                        "child_resend_id": $(this).val(),
                    },

                    success: function (data) {
                        if (!data.error) {
                            oTable.ajax.reload(null, false);
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
                                }
                                else {
                                    $("#allUsersCheck").prop('checked', false);

                                    // Check the users of the selected branches
                                    selectedBranches = $(".branchFilterCheck:checked").map(function () {
                                        return $(this).data('branch-id');
                                    }).get();

                                    $('.userFilterCheck').not('.branchFilterCheck').each(function () {
                                        var branchId = $(this).data('branch-id');
                                        if (selectedBranches.indexOf(branchId) < 0) {
                                            $(this).prop('checked', false);
                                        }
                                        else {
                                            $(this).prop('checked', true);
                                        }
                                    });

                                }
                            }
                            else if ($(this).hasClass('userFilterCheck')) {
                                // This is a user checkbox that isn't a branch, it's being changed so removed the branch filter
                                $('.branchFilterCheck').prop('checked', false);

                                var selectedUserBranches = $(".userFilterCheck:checked").map(function () {
                                    return $(this).data('branch-id');
                                }).get();

                                var uniqueUserBranches = Array.from(new Set(selectedUserBranches));

                                if (uniqueUserBranches.length > 1) {
                                    $('.branchFilterCheck').prop('checked', false);
                                }
                                else {

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
                            }
                            else if ($(this).hasClass('statusFilterCheck')) {
                                if ($(this).val() == 'Converted' || $(this).val() == 'Cancelled' || $(this).val() == 'On Hold' || $(this).val() == 'Waiting for Subs') {
                                    $(".statusFilterCheck[value='Active']").prop('checked', false);
                                } else {
                                    $(".statusFilterCheck[value!='Active']").prop('checked', false);
                                }
                            }
                            $.uniform.update();
                        });

                        // Filter Check box handler
                        $(document).on('change', ".filterCheck", function () {

                            if ($(this).hasClass('clientAccountFilterCheck') && $(this).hasClass('searchSelected')) {
                                if (!$(this).is(':checked')) {
                                    $(this).parents('.filterColumnRow').remove();
                                    $('#accountSearch').trigger('input');
                                }
                            }
                            else if ($(this).hasClass('clientAccountFilterCheck')) {
                                var parent = $(this).parents('.filterColumnRow');
                                parent.addClass('searchSelectedRow');
                                $(this).addClass('searchSelected');
                                parent.insertAfter('#accountRowAll');
                            }

                            var numSearchSelected = $('.searchSelected').length;
                            if (numSearchSelected < 1) {
                                $('#allClientAccounts').prop('checked', true);
                            }
                            else {
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
                                }
                                else {
                                    var preset = datePreset(selectVal);
                                    $("#lCreatedFrom").val(preset.startDate);
                                    $("#lCreatedTo").val(preset.endDate);
                                    applyFilter();
                                }
                            }
                        });


                        // Run the filter by default
                        applyFilter();
                    });

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
                            }
                            if (!users.length) {
                                users = [];
                            }

                            // Lead Sources
                            var leadSources = [];
                            var leadSourceValues = [];

                            if ($(".sourceFilterCheck:checked").length != $(".sourceFilterCheck").length) {
                                leadSources = $(".sourceFilterCheck:checked").map(function () {
                                    leadSourceValues.push($(this).data('text-value'));
                                    return $(this).data('text-value');
                                }).get();
                            }

                            if (!leadSources.length) {
                                leadSources = [];
                            }

                            // Statuses
                            var statuses = [];
                            var statusValues = [];

                            statuses = $(".statusFilterCheck:checked").map(function () {
                                statusValues.push($(this).data('text-value'));
                                return $(this).val();
                            }).get();

                            if (!statuses.length) {
                                statusValues = [];
                            }

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
                                }
                                else if ($("#lCreatedFrom").val()) {
                                    fromDateString = $("#lCreatedFrom").val();
                                    createdRangeString = 'After ' + fromDateString;
                                }
                                else {
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

                            // Status
                            if (statuses.length) {

                                numFilters++;
                                $('#statusFilterHeader').addClass('activeFilter');

                                var statusBadgeText = '[' + statusValues.length + ']';

                                if (statusValues.length == $(".statusFilterCheck").length) {
                                    statusBadgeText = 'All';
                                }

                                if (statusValues.length == 1) {
                                    statusBadgeText = statusValues[0];
                                }

                                filterBadgeHtml += '<div class="filterBadge">' +
                                    '<div class="filterBadgeTitle">Status: </div>' +
                                    '<div class="filterBadgeContent">' +
                                    statusBadgeText +
                                    '</div>' +
                                    '<div class="filterBadgeRemove"><a href="#" id="removeStatusFilter">&times;</a></div>' +
                                    '</div>';

                                statusHeaderText = '[' + statusValues.length + ']';

                            } else {
                                $('#statusFilterHeader').removeClass('activeFilter');
                            }
                            $("#statusHeaderText").text(statusHeaderText);

                            // Due Date
                            if (dueDates.length) {
                                numFilters++;
                                $('#dueFilterHeader').addClass('activeFilter');

                                var dueDateBadgeText = '[' + dueDateValues.length + ']';

                                if (dueDateValues.length == $(".dueDateFilterCheck").length) {
                                    dueDateBadgeText = 'All';
                                }

                                if (dueDateValues.length == 1) {
                                    dueDateBadgeText = dueDateValues[0];
                                }

                                filterBadgeHtml += '<div class="filterBadge">' +
                                    '<div class="filterBadgeTitle">Due Date: </div>' +
                                    '<div class="filterBadgeContent">' +
                                    dueDateBadgeText +
                                    '</div>' +
                                    '<div class="filterBadgeRemove"><a href="#" id="removeStatusFilter">&times;</a></div>' +
                                    '</div>';

                                dueDateHeaderText = '[' + dueDateValues.length + ']';

                            } else {
                                $('#dueFilterHeader').removeClass('activeFilter');
                            }
                            $("#dueHeaderText").text(dueDateHeaderText);


                            // Apply the HTML
                            $("#filterBadges").html(filterBadgeHtml);

                            if (numFilters < 1) {
                                $(".filterButton").removeClass('update-button');
                                $(".filterButton").addClass('grey');
                                $('.resetFilterButton').hide();
                            }
                            else {
                                $(".filterButton").addClass('update-button');
                                $(".filterButton").removeClass('grey');
                                $('.resetFilterButton').show();
                            }

                            leadFilter = {
                                    "lFilterDateStart": lCreatedFrom,
                                    "lFilterDateEnd": lCreatedTo,
                                    "lFilterUser": userValues,
                                    "lFilterSource": leadSourceValues,
                                    "lFilterStatus": statusValues,
                                    "lFilterDue": dueDateValues
                                };


                            $.ajax({
                                type: "POST",
                                url: '<?php echo site_url('ajax/setLeadResendFilters').'/'.$this->uri->segment(3) ?>',
                                data: {
                                    lFilterDateStart: lCreatedFrom,
                                    lFilterDateEnd: lCreatedTo,
                                    lFilterUser: users,
                                    lFilterSource: leadSources,
                                    lFilterStatus: statuses,
                                    lFilterDue: dueDates
                                },
                                dataType: 'JSON',
                                success: function () {
                                    updateTable();
                                }
                            });
                        }, 500);
                    }

                    function updateTable() {

                        if($.fn.DataTable.isDataTable('#leadsTable')){
                            oTable.ajax.reload();
                        }else{
                            initTable();
                        }
                        
                    }

                    function datePreset(preset) {

                        var startDate;
                        var endDate;

                        switch (preset) {

                            case 'today':
                                startDate = moment();
                                endDate = moment();
                                break;

                            case 'yesterday':
                                startDate = moment().subtract(1, 'days');
                                endDate = moment().subtract(1, 'days');
                                break;

                            case 'last7days':
                                startDate = moment().subtract(6, 'days');
                                endDate = moment();
                                break;

                            case 'monthToDate':
                                startDate = moment().startOf('month');
                                endDate = moment();
                                break;

                            case 'previousMonth':
                                startDate = moment().subtract(1, 'month').startOf('month');
                                endDate = moment().subtract(1, 'month').endOf('month');
                                break;

                            case 'yearToDate':
                                startDate = moment().startOf('year');
                                endDate = moment();
                                break;

                            case 'previousYear':
                                startDate = moment().subtract(1, 'year').startOf('year');
                                endDate = moment().subtract(1, 'year').endOf('year');
                                break;
                        }

                        var presetDate = {
                            startDate: startDate.format('MM/DD/YYYY'),
                            endDate: endDate.format('MM/DD/YYYY')
                        };

                        return presetDate;

                    }



$(document).on('click', ".leadsTableDropdownToggle", function(e) {

    //console.log(document.getElementsByTagName("template")[0]);
    $('#newLeadsPopup').html('');
    $('#newLeadsPopup').show();

    $('.is_converted').css('display','none');
    $('.is_audit').css('display','none');
   // $(".template_class").find('.estimating').css('display','none');
    //$('.job_cost_report,.job_costing,.estimating').css('display','none');
    var template;
    
    var lead_project_name = $(this).attr('data-lead-project-name') ? $(this).attr('data-lead-project-name') :'-';
    var lead_id = $(this).attr('data-lead-id');
    var lead_name = $(this).attr('data-lead-fullname');
    var lead_email = $(this).attr('data-email');
    var lead_account = $(this).attr('data-account');

    var lead_company_name = $(this).attr('data-company-name');
    var lead_converted = $(this).attr('data-converted');
    var lead_url = $(this).attr('data-url');
    var lead_audit_url = $(this).attr('data-audit-url');
    console.log(lead_audit_url)
    if(lead_audit_url=='1'){
        $('.is_audit').css('display','block');
    }else{
        $('.is_audit').css('display','none');
    }

    

    if(lead_converted=='1'){
        
            $('.is_converted').css('display','block');
    }else{
            $('.is_converted').css('display','none');
    }

    
    
    
    template = $("#template").html();
    template = template.toString()

    template = template.replace(new RegExp('{leadId}', 'g'), lead_id);
    template = template.replace(new RegExp('{leadProjectname}', 'g'), lead_project_name);
    template = template.replace(new RegExp('{leadFullname}', 'g'), lead_name);
    template = template.replace(new RegExp('{leadAccount}', 'g'), lead_account);
    template = template.replace(new RegExp('{leadEmail}', 'g'), lead_email);
    template = template.replace(new RegExp('{companyName}', 'g'), lead_company_name);
    template = template.replace(new RegExp('{url}', 'g'), lead_url);
    $('#newLeadsPopup').html(template);
    
    
});

$('.column_show_apply').click(function(){

        oTable.columns( [2,3,4,5,6,7,8,9,10,11,13] ).visible( false );
        var favorite = [];
        $.each($("input[name='column_show']:checked"), function(){
                favorite.push($(this).val());
            });

            oTable.columns( favorite ).visible( true );
            if(hasLocalStorage){
                localStorage.setItem("lead_column_show", favorite);
            }
           
           oTable.ajax.reload(null,false);
           $("#newLeadColumnFilters").hide(); 
            
      });

      function check_highlighted_row(){
        if(localStorage.getItem("l_last_active_row")){
            var row_num =localStorage.getItem("l_last_active_row");
            $('#leadsTable tbody').find("[data-lead-id='"+row_num+"']").closest('tr').addClass('selectedRow');
        }
    }


     // Lead Business Type Update
 $("#change-lead-business-type").dialog({
            width: 500,
            modal: true,
            buttons: {
                Save: {
                    'class': 'btn ui-button update-button change_bt_popup_btn',
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
                            data: {lead_id:$('#business_lead_id').val(),businessTypes: $('.leadBusinessTypeMultiple').val()},
                            url: "<?php echo site_url('ajax/leadsChangeBusinessTypes') ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        }).success(function (data) {
                            
                            //document.location.reload();
                            oTable.ajax.reload(null,false);
                            $("#change-lead-business-type").dialog('close');
                            swal('','Business Type Updated');
                            
                        });
                    }
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            },
            autoOpen: false
        });


                });


$('body').click( function(event) {
       // console.log('fff')
        


     var $trigger3 = $("#leadsTableDropdownToggle");
      
      if('leadsTableDropdownToggle' !== event.target.id && !$trigger3.has(event.target).length){
        if($(event.target).parents('#newLeadsPopup').length==0 ){
               if(event.target.id !='newLeadsPopup'){
                $("#newLeadsPopup").hide();
                }
           }
     }
       
});

$(document).on("click",".email_events",function(e) {
        $('#newLeadsPopup').hide();
        var lead_id = $(this).attr('data-lead-id');
        var lead_name = $(this).attr('data-contact-name') ? $(this).attr('data-contact-name') : '';
        var lead_account_name = $(this).attr('data-account');
        var table = '<p style="font-weight: bold; font-size: 16px;"><span style="position: absolute;left: 0px;"><span style="display: block; float: left;  color: #595959; text-align: left; margin-right: 10px;"><i class="fa fw fa-file-pdf-o"></i> Account: </span><span class="shadowz" style="float:left"><a class="tiptip" href="#" >'+lead_account_name+'</a></span></span>'+
                    '<span style="right: 0px;position: absolute;" ><span style="display: block;float: left;margin-right:10px;  color: #595959; text-align: left; "><i class="fa fw fa-user"></i> Project: </span><span style="float:left;"><a style="float:left" class="tiptip" title="Edit " href="#">'+lead_name+'</a></span></span></p><br><hr/><div><div id="historyTableLoader" style="position: absolute;right: 100px;display: none;top: 44px;"><img src="/static/blue-loader.svg" /></div><a class="btn right blue-button reload_history_table" href="javascript:void(0);" style="border-radius: 5px;padding: 5px 10px 5px 10px;font-size: 14px;margin-bottom: 10px;"><i class="fa fa-fw fa-refresh"></i> Reload</a></div>'+
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
                    onOpen:function() { 
                        
                        
                        //CKEDITOR.replace( 'event_email_content',{removePlugins: 'elementspath',readOnly:true,height:300} );
                        //tinymce.init({selector: "#event_email_content",menubar: false,statusbar: false,toolbar : false,height:'300',readonly : true});
                        
                        $('.swal2-modal').attr('id','send_proposal_popup')

                        hTable = $('#email_events_table').on('processing.dt', function (e, settings, processing) {
                                    if (processing) {
                                        $("#historyTableLoader").show();
                                    } else {
                                        $("#historyTableLoader").hide();
                                    }
                            }).DataTable({
                                "processing": true,
                                "serverSide": true,
                                
                                "ajax": "<?php echo site_url('ajax/get_lead_email_events_table_data') ?>/" + lead_id,
                                "columns": [
                                    {width: '17%',class: 'dtLeft'},                                            // 3 Branch
                                    {width: '20%',class: 'dtLeft'},                                            // 4 Readable status
                                    {width: '15%',class: 'dtLeft'},                              // 5 Status Link
                                    {width: '15%',class: 'dtLeft'},    
                                    {width: '8%',class: 'dtCenter',sortable:false}, 
                                    {width: '7%',class: 'dtCenter',sortable:false},
                                    {width: '8%',class: 'dtCenter',sortable:false},
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
                                   
                                   initTiptip();
                   
                               },
                                
                            });

                           

            },
                
        })
        
     });

     $(document).on("click",".reload_history_table",function(e) {
        hTable.ajax.reload(null,false )
     });

     $(document).on("click",".email_event_email_show_span",function(e) {
        var event_id = $(this).attr('data-event-id');
        var sent_at = $(this).attr('data-sent');
        var delievered_at = $(this).attr('data-delivered');
        var opened_at = $(this).attr('data-opened');
        tinymce.remove('#event_email_content');
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

     $(document).on("click",".show_email_event_table",function(e) {

        $('#email_events_table_wrapper').show();
        $('#email_event_email_content_div').hide();
     })


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


        

    $("#tableColumnFilterButton").click(function () {
        //hideInfoSlider();
        $("#newLeadColumnFilters").toggle();
        // Clear search so that filters aren't affected
       // oTable.fnFilter('');
        // Hide group action menu
        $(".groupActionsContainer").hide();
    });

        
    $(".close_column").click(function(){
        $("#newLeadColumnFilters").hide();
        $(".column_show").attr('checked', false);
                var column_show = localStorage.getItem("lead_column_show_22_12");
    
                if(column_show){
                    
                    var column_show = column_show.split(',');
                 
                    for($i=0;$i < column_show.length;$i++){
                        $("input[name=column_show][value="+column_show[$i]+"]").prop("checked",true);
                    }
                    $.uniform.update();
                }else{
                    $(".column_show").attr('checked', true);
                }
    })


    
    $('body').click( function(event) {
        
        var $trigger = $("#tableColumnFilterButton");
       
       
        if("tableColumnFilterButton" !== event.target.id && !$trigger.has(event.target).length){
           if($(event.target).parents('#newLeadColumnFilters').length==0 ){
               if(event.target.id !='newLeadColumnFilters'){
                $("#newLeadColumnFilters").hide();

                $(".column_show").attr('checked', false);
                var column_show = localStorage.getItem("lead_column_show_22_12");
    
                if(column_show){
                    
                    var column_show = column_show.split(',');
                 
                    for($i=0;$i < column_show.length;$i++){
                        $("input[name=column_show][value="+column_show[$i]+"]").prop("checked",true);
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

    


    $(document).on("click",".send_email_individual",function(e) {
        $('#newLeadsPopup').hide();
        var lead_id = $(this).attr('data-lead-id');
        var lead_name = $(this).attr('data-account');
        var lead_project_name = $(this).attr('data-project-name');
        var to_email = $(this).attr('data-email');
        tinymce.remove();
         swal({
                    title: "<i class='fa fw fa-envelope'></i> Send Email",
                    html: '<p style="font-weight: bold; font-size: 16px;"><span style="position: absolute;left: 0px;"><span style="display: block; float: left;  color: #595959; text-align: left; margin-right: 10px;"><i class="fa fw fa-file-pdf-o"></i> Project: </span><span class="shadowz" style="float:left"><a class="tiptip" href="#" >'+lead_project_name+'</a></span></span>'+
                          '<span style="right: 0px;position: absolute;" ><span style="display: block;float: left;margin-right:10px;  color: #595959; text-align: left; "><i class="fa fw fa-user"></i> Contact: </span><span style="float:left;"><a style="float:left" class="tiptip" title="Edit " href="#">'+lead_name+'</a></span></span></p><br><hr/>'+
                        '<form id="send_proposal_email" >'+
                        '<input type="hidden" class="" name="send_email" value="Send">'+
                        '<input type="hidden" class="send_email_lead_id" name="lead_id" value="'+lead_id+'">'+
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
                    onOpen:function() { 
                        
                        loadTemplateContentsForEmail();
                        // var email_content_editor = CKEDITOR.replace( 'email_content',{
                        //     toolbar: [
                        //         { name: 'styles', items: [ 'Font', 'FontSize' ] },
                        //         { name: 'colors', items: [ 'TextColor', 'BGColor' ] },
                        //         { name: 'editing', groups: ['spellcheck' ], items: ['jQuerySpellChecker'] },
                        //         { name: 'basicstyles', items: [ 'Bold', 'Italic', 'Underline','-', 'RemoveFormat' ] },
                        //         { name: 'paragraph', groups: [ 'list', 'indent', 'blocks', 'align', 'bidi' ], items: [ 'NumberedList', 'BulletedList', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
                        //         { name: 'links', items: [ 'Link', 'Unlink' ] },	// Defines toolbar group with name (used to create voice label) and items in 3 subgroups.
                        //         [ 'Cut', 'Copy', 'Paste', 'PasteText', ],			// Defines toolbar group without name.
                        //         '/',																					// Line break - next group will be placed in new line.
                        //     ],
                        // } );

                        
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
                    
                        // email_content_editor.on('change', function(ev){ 
                        //     if(CKEDITOR.instances.email_content.getData()){
                        //         $("#cke_email_content").removeClass('error_editor');
                                
                        //     }else{
                        //         $("#cke_email_content").addClass('error_editor');
                                
                        //     }
                        //     check_popup_validation()
                        //  });  
                    
                    
                    $('.swal2-modal').attr('id','send_proposal_popup');
                        // Tiptip the address inputs
                        initTiptip();
                        // Uniform the select
                        $("#sendTemplateSelect").uniform();
                    
                    },

                    }).then(function(result){
                    
                    

                            swal({
                                title: 'Sending..',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                timer: 10000,
                                onOpen: () => {
                                swal.showLoading();
                                $('.swal2-modal').attr('id','')
                                }
                            })
                            var values, index;

                            // Get the parameters as an array
                            values = $("#send_proposal_email").serializeArray();

                            // Find and replace `content` if there
                            for (index = 0; index < values.length; ++index) {
                                if (values[index].name == "message") {
                                    values[index].value = tinyMCE.get('email_content').getContent();
                                    break;
                                }
                            }
                            $.ajax({
                                type: "POST",
                                async: true,
                                cache: false,
                                data: values,
                                url: "<?php echo site_url('ajax/send_lead_individual_email') ?>?" + Math.floor((Math.random() * 100000) + 1),
                                dataType: "JSON"
                            }).success(function (data) {
                                console.log(data);
                                swal('','Email Sent');
                            });
                        
                
                })
                


            return false;
     });


     $(document).on("keyup","#poup_email_subject,#popup_email_to",function(e) {
        if($(this).val()){
            $(this).removeClass('error');
            
        }else{
            $(this).addClass('error');
            
        }
        check_popup_validation()
        
     });

function check_popup_validation(){
    if(tinyMCE.get('email_content').getContent()=='' || $('#poup_email_subject').val() =='' || $('#popup_email_to').val()==''){
            $('.send_popup_validation_msg').show();
            $('#send_proposal_popup .swal2-confirm').attr('disabled', true);
    }else{
        $('.send_popup_validation_msg').hide();
        $('#send_proposal_popup .swal2-confirm').attr('disabled', false);
    }
}


    // Template change handler
    $(document).on("change","#sendTemplateSelect",function(e) {
                         console.log('fff')   
        loadTemplateContentsForEmail();
    });
     function loadTemplateContentsForEmail(){
            var defaultTemplate = $('#sendTemplateSelect option:selected').data('template-id');
            var lead_id = $('.send_email_lead_id').val();
            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: {'templateId': defaultTemplate,'lead_id':lead_id},
                url: "<?php echo site_url('account/ajaxGetLeadTemplateParsed') ?>?" + Math.floor((Math.random() * 100000) + 1),
                dataType: "JSON"
            })
            .success(function (data) {
                $("#poup_email_subject").val(data.templateSubject);
                //CKEDITOR.instances.email_content.setData(data.templateBody);
                tinymce.get('email_content').setContent(data.templateBody);
                
            });

            //$.uniform.update();
            //initUI();
    }

    $(document).on("click",".closeDropdownMenu1",function(e) {
        $('#newLeadsPopup').hide();
       
        return false;
    });
    
$(document).on('click', '#addAtCursorEdit', function () {
        //CKEDITOR.instances.message.insertText($("#templateFields").val());
        tinymce.get('message').execCommand('mceInsertContent', false, $("#templateFields").val());

});

function get_resend_lists(){

$.ajax({
    url: '<?php echo site_url('ajax/get_lead_child_resend_lists').'/'.$resend->getId() ?>',
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

function notes_tooltip() {

$(".lead_table_notes_tiptip").tipTip({   delay :200,
        maxWidth : "400px",
        context : this,
        defaultPosition: "right",
        content: function (e) {
        
        setTimeout( function(){
                    $.ajax({
                        url: '<?php echo site_url('ajax/getTableNotes') ?>',
                        type:'post',
                        data:{relationId:notes_tiptip_lead_id,type:'lead'},
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


$(document).on('click', ".manage_business_type", function () {
                var company_name = '<i class="fa fa-fw fa-building-o"></i> '+$(this).closest('tr').find('.leadsTableDropdownToggle').attr('data-company-name')+' <i class="fa fa-fw fa-user-o"></i> '+$(this).closest('tr').find('.leadsTableDropdownToggle').attr('data-lead-fullname');
                $('.change-bt-lead-name').html(company_name);
                lead_id = $(this).attr('rel');
                $('.leadBusinessTypeMultiple').val('');
                $('.leadBusinessTypeMultiple').trigger("change");
                $('#business_lead_id').val(lead_id);
                $.ajax({
                                    url: '<?php echo site_url('ajax/getLeadBusinessTyeps') ?>',
                                    type:'post',
                                    data:{lead_id:lead_id},
                                    cache: false,
                                    dataType: 'JSON',
                                    success: function (response) {
                                      
                                        if(response.success){
                                           var selected_bt =[];
                                            var bts = response.business_types;
                                            if(bts.length){
                                                $('.leadBusinessTypeMultiple').val(bts[0]['business_type_id']);
                                                $('.leadBusinessTypeMultiple').trigger("change");
                                            }
                                            
                                            

                                        }
                                     $("#change-lead-business-type").dialog('open');    
                                    }
                                });
                return false;
                
            });

            $(document).on('change', ".leadBusinessTypeMultiple", function () {
                if($('.leadBusinessTypeMultiple').val()==''){
                    $('.change_bt_popup_btn').prop('disabled', true);
                    $('.change_bt_popup_btn').addClass('ui-state-disabled');
                }else{
                    $('.change_bt_popup_btn').prop('disabled', false);
                    $('.change_bt_popup_btn').removeClass('ui-state-disabled');
                }
                
            }); 

$(document).on('mouseenter', ".lead_table_notes_tiptip", function () {
    notes_tiptip_lead_id = $(this).data('val');
    return false;
    
});
</script>
            <div class="javascript_loaded">
                <div id="confirm-delete-message" title="Confirmation">
                    <p>Are you sure you want to cancel the lead?</p>
                    <a id="client-delete" href="" rel=""></a>
                </div>
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
                <div id="delete-prospects" title="Confirmation">
                    <h3>Confirmation - Cancel Leads</h3>

                    <p>This will cancel a total of <strong><span id="deleteNum"></span></strong> leads.</p>
                    <br/>

                    <p>Are you sure that you want to proceed?</p>
                </div>
                <div id="delete-proposals-status" title="Confirmation">
                    <h3>Confirmation</h3>

                    <p id="deleteProposalsStatus"></p>
                </div>
                <div id="change-owner" title="Confirmation">
                    <p>Changing Owner for a total of <span id="changeOwnerNum"></span> leads:</p>

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
<style>
    #uniform-resendSelect span {
        width: 200px!important;
    }

    #uniform-resendSelect {
        width: 225px!important;
    }
    #uniform-templateSelect span {
        width: 200px!important;
    }

    #uniform-templateSelect {
        width: 225px!important;
    }
</style>
<div id="change-lead-business-type" title="Update Lead Business Type">
                    <p style="font-size: 14px;margin: 15px 0px 20px 0px;"><span style="font-weight: bold;">Lead: </span><span class="change-bt-lead-name"></span></p>
                   
                    <label ><strong>Business Type:</strong></label> 
                    <input type="hidden" id="business_lead_id" name="leadsChangeBusinessTypes">
                    <select  class="leadBusinessTypeMultiple"  style="width: 64%" name="lead_business_type">
                    <option value="">Please select business type </option>
                        <?php 
                            foreach($businessTypes as $businessType){
                                echo '<option value="'.$businessType->getId().'">'.$businessType->getTypeName().'</option>';
                            }
                        ?>
                    </select>

                </div>
    <div id="send-email" title="Confirmation">
                    <h3>Confirmation - Send Email</h3>
            <p style="margin-bottom: 15px;">
                    <span style="padding-right: 33px;font-weight:bold">Email Template:</span>
                        <select id="templateSelect">
                            <?php
                            foreach ($clientTemplates as $template) {
                                /* @var $template \models\ClientEmailTemplate */
                                ?>
                                <option
                                    data-template-id="<?php echo $template->getTemplateId(); ?>"><?php echo $template->getTemplateName(); ?></option>
                                <?php
                            }
                            ?>
                </select>

                <?php if ($account->isAdministrator()) { ?>
                        <span style="float: right;padding-right: 205px;"><input type="checkbox" id="emailCustom"> <span style="display: inline-block; padding-top: 2px;"> Customize Email Sender Info</span></span>

                    <?php } ?>
            </p>
                <p >
                <span style="padding-right: 12px;font-weight:bold">Choose Campaign:</span>
                
                <select name="resendId" id="resendSelect" >
                <option value="">Select Resend Campaign</option>
                <option value="0">New</option>
                <option value="-1">No Campaign</option>
                <?php
                foreach ($resends as $resend1) {
                    /* @var $template \models\ClientEmailTemplate */
                    ?>
                    <option value="<?php echo $resend1->id; ?>"><?php echo $resend1->resend_name; ?></option>
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
                    <a class="btn" href="javascript:void(0);" id="addAtCursorEdit"><i class="fa fa-fw fa-plus-circle"></i> Add</a>

                    
                </p>

    <?php if ($account->isAdministrator()) { ?>
        <p class="emailFromOption" style="color: #b81900; margin-bottom: 10px;">Leave blank for the emails to come from the owner of the lead.</p>
        <p class="emailFromOption" style="margin-bottom: 10px;"><span
                    style="width: 100px;font-weight:bold; display: inline-block">From Name:</span><input class="text"
                                                                                                         type="text"
                                                                                                         id="messageFromName"
                                                                                                         style="width: 200px;"><span
                    style="padding-left: 50px;width: 100px;font-weight:bold; display: inline-block">From Email:</span><input
                    class="text" type="text" id="messageFromEmail" style="width: 200px;"></p>

    <?php } ?>
                    

    <p style="font-weight:bold;margin-bottom: 10px;">Email Content</p>   
        <span style="color: rgb(184, 25, 0);margin-bottom: 10px;display:none" class="is_templateSelect_disable adminInfoMessage "><i class="fa fa-fw fa-info-circle"></i> Email content cannot be edited when adding to an existing campaign</span>
    <textarea id="message">This is the content</textarea>


                    <p>This will send a total of <strong><span id="resendNum"></span></strong> email(s) to the leads.
                    </p>
                    <br/>

                    <p>Are you sure that you want to proceed?</p>
                </div>
                <div id="email-feedback" title="Send Lead Email">
                    <p id="feedbackText" style="text-align:center;margin-top:15px"></p>
                </div>

                <div id="send-audit-emails" title="Confirmation">
                    <h3>Confirmation - Send Audit Email</h3>

                    <p>Subject: <input class="text" type="text" id="auditMessageSubject" style="width: 300px;"
                                       value="<?php echo $auditTemplate->getTemplateSubject(); ?>"></p><br/>

                    <textarea id="auditMessage"><?php echo $auditTemplate->getTemplateBody(); ?></textarea>

                    <br/>

                    <p>Are you sure that you want to proceed?</p>
                </div>

                <div id="audit-email-feedback" title="Send Audit Email" style="text-align: center;">
                    <p id="auditFeedbackText" ></p>
                    <p id="auditFeedbackLoader"><img src="/static/loading.gif"/></p>
                </div>

                <div id="audit-resent" title="Confirmation">

                    <div class="auditSending">
                        <p style="text-align: center">
                            Sending <br/>
                            <img src="/static/loading.gif"/>
                        </p>

                    </div>

                    <div class="auditSent" style="display: none;">
                        <h3>Confirmation - Audit Resend</h3>

                        <p>The lead details have been emailed</p>
                    </div>

                </div>


            </div>
        </div>
    </div>



<div id="template" style="display: none;">
<div class="dropdownMenuContainer single">
    
        <div class="closeDropdown closeLeadDropdown" style="line-height: 10px;position: absolute;right: 0;">
            <a href="javascript:void(0);" class="closeDropdownMenu1">&times;</a>
        </div>
        <div class="" style="font-size: 14px;padding: 8px 15px;border-bottom: 1px solid #e2e2e2;">
            <p>{companyName} | {leadFullname}</p>
        </div>
      
        <div class="" style="font-size: 17px;padding: 8px 15px;">
            <p style="text-align: center;"><strong >Project:</strong> {leadProjectname}</p>
        </div>
        <ul class="dropdownMenu">


            <li>
                <a href="<?php echo site_url('leads/edit/{leadId}') ?>">
                    <img src="/3rdparty/icons/user_edit.png"> Edit Lead
                </a>
            </li>

            <li>
                <a href="<?php echo site_url('leads/convert/{leadId}') ?>">
                    <img src="/3rdparty/icons/arrow_switch.png"> Convert to Proposal
                </a>
            </li>

            <li>
                <a class="send_email_individual" 
                    data-lead-id="{leadId}"
                    data-account="{leadFullname}"
                    data-project-name="{leadProjectname}"
                    data-email="{leadEmail}"
                href="javascript:void(0);">
                    <img src="/3rdparty/icons/email_go.png"> Send Email
                </a>
            </li>
            <li>
                <a target="_blank"
                   href="<?php echo site_url('pdf/lead/{leadId}') ?>">
                    <img src="/3rdparty/icons/print.png"> Print Lead
                </a>
            </li>

            <li>
                <a target="_blank"
                   href="<?php echo site_url('leads/cancel/{leadId}') ?>"
                   class="confirm-delete">
                    <img src="/3rdparty/icons/cancel.png"> Cancel Lead
                </a>
            </li>

            <!--<li>
                                                    <a href="<?php /*echo site_url('leads/delete/' . $lead->getLeadId()) */ ?>" class="confirm-delete">
                                                        <img src="/3rdparty/icons/delete.png"> Delete Lead
                                                    </a>
                                                </li>-->

           

            

           


            
                
            
        </ul>
        <ul class="dropdownMenu">
            

            <li>
                <a title="View Lead Notes" href="#"
                   rel="{leadId}" class="lead-notes">
                    <img src="/3rdparty/icons/comments.png"> Lead Notes
                </a>
            </li>

            
                <li class="is_audit">
                    <a title="Resend Email" href="#"
                       data-lead-id="{leadId}"
                       class="resendAudit">
                        <img src="/3rdparty/icons/email.png"> Resend Audit Email
                    </a>
                </li>

          

            <li >
                <a title="View on Map"
                   href="https://www.google.com/maps/place/{url}"
                   target="_blank">
                    <img src="/3rdparty/icons/map.png"> See on Map
                </a>
            </li>


            
                <li class="is_converted">
                    <a href="<?php echo site_url('leads/convert/{leadId}') ?>">
                        <img src="/3rdparty/icons/arrow_switch.png"> Convert to Proposal
                    </a>
                </li>
            
            <li>
                <a href="#" class="scheduleLeadEvent" data-account="{leadAccount}" data-lead="{leadId}" data-projectname="{leadProjectname}">
                    <img src="/3rdparty/icons/time_add.png"> Schedule an Event
                </a>
            </li>
            <li>
                <a href="javascript:void(0);" rel="{leadId}" class="email_events"
                    data-lead-id="{leadId}"
                    data-account="{leadFullname}"
                    data-project-name="{leadProjectname}"
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

<div id="emailContentDialog" title="Preview Email" style="display:none;">
        <div id="email-preview" style="padding:10px">
            <?php echo $resend->getEmailContent(); ?>
        </div>
    </div>
<?php $this->load->view('global/footer'); ?>