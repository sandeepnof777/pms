<?php /** @var $proposal \models\Proposals */ ?>
<?php $this->load->view('global/header'); ?>
<style>
.dropdownToggle:hover{color:#fff!important}
.dropdownToggle{color:#000!important}
.dropdownToggle.open{background:none!important}
.collaspeService{background-color:#efefef;border-radius: 3px;}
.dataTables_info {margin-top: 20px;}
#estimateHistoryTable_paginate a {
    padding: 5px;
    margin: 0px 3px;
}

#uniform-show_only_saved_items{display:none}
#estimateHistoryTable_wrapper{    margin-top: 5px!important;
    padding-top: 5px!important;
    padding-left: 2px!important;
    padding-right: 2px!important;}
.dataTables_scroll{padding-top: 10px!important;}

#estimateHistoryTable_paginate{margin-top: 20px;}

/* .switch input { 
  opacity: 0;
  width: 0;
  height: 0;
}

.slider {
  position: absolute;
  cursor: pointer;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: #ccc;
  -webkit-transition: .4s;
  transition: .4s;
}

.slider:before {
  position: absolute;
  content: "";
  height: 26px;
  width: 26px;
  left: 4px;
  bottom: 4px;
  background-color: white;
  -webkit-transition: .4s;
  transition: .4s;
}

input:checked + .slider {
  background-color: #2196F3;
}

input:focus + .slider {
  box-shadow: 0 0 1px #2196F3;
}

input:checked + .slider:before {
  -webkit-transform: translateX(26px);
  -ms-transform: translateX(26px);
  transform: translateX(26px);
}

/* Rounded sliders */
.slider.round {
  border-radius: 34px;
}

.slider.round:before {
  border-radius: 50%;
} */
</style>

<div id="content" class="clearfix estimate-page" xmlns="http://www.w3.org/1999/html">

    
    <div class="widthfix clearfix relative" style="margin:10px 0px;">
        <div style="width: 60%; float: left;" >
            <h3 style="margin:0px;">Estimate: <span style="color:#848484;font-size:16px"><?= $proposal->getClient()->getClientAccount()->getName() .' | '. $proposal->getProjectName() ?></span></h3>
            <p class="heading_proposal_total" style="margin-left: 95px;float: left; width: 55%;margin-top: 2px; text-align: left; display: block; font-size: 13px;">Proposal: Price <span style="font-weight:bold;" class="final_table_proposal_total_price">0.00</span> | Margin <span style="font-weight:bold;" class="final_table_proposal_profit_percent">0%</span></p>    
        </div>
        <div style="width: 40%; float: right;" >
        <?php
// Delivery status Icon
switch ($proposal->getEstimateStatusId()) {
    case \models\EstimateStatus::NOT_STARTED:
        $class = 'fa-calculator';
        $title = 'Not Started';
        break;
    case \models\EstimateStatus::IN_PROGRESS:
    case \models\EstimateStatus::ALL_SERVICES_ESTIMATED:
        $class = 'fa-pencil';
        $title = 'In Progress';
        break;
    case \models\EstimateStatus::COMPLETE:
        $class = 'fa-check-circle';
        $title = 'Complete';
        break;
    case \models\EstimateStatus::LOCKED:
        $class = 'fa-lock';
        $title = 'Locked';
        break;
}?>

<i class="fa fa-fw <?=$class;?> tiptipleft" title="<?=$title;?>" style="float:right;font-size: 18px;margin-top: 3px;" ></i>
                <div class="dropdownButton" style="float:right;margin-left: 5px;">
                    <a class="dropdownToggle btn" href="#" ><i class="fa fa-cog"></i> <i class="fa fa-chevron-down"></i></a>
                    <div class="dropdownMenuContainer openAbove" style="display: none;width: 140px; left:-105px">
                        
                        <ul class="dropdownMenu" style="width: 156px">
                            <li>
                            <a href="JavaScript:void('0');" id="estimateHistory"  style="padding-left:10px;">
                                <i class="fa fa-fw fa-history" ></i> History
                            </a>
                            </li>
                            <li>
                            <a href="JavaScript:void('0');" id="estimateNotes" style="padding-left:10px;">
                                <i class="fa fa-fw fa-clipboard" ></i> Notes
                            </a>
                            </li>
                            
                            <?php if($proposal_status_id ==5){?>
                                <li>
                                <a href="JavaScript:void('0');" onclick="unlock_estimation()" style="padding-left:10px;">
                                    <i class="fa fa-fw fa-unlock" ></i>
                                    Unlock Estimate
                                </a>
                                </li>
                            <?php }else {?>
                                <?php if($proposal_status_id !=5){?>
                                    <li>
                                    <a href="JavaScript:void('0');" onclick="complete_estimation()" style="padding-left:10px;">
                                    <i class="fa fa-fw fa-check-circle" ></i> Complete Estimate
                                    </a>
                                    </li>
                                <?php }?>
                                <li>
                                <a href="JavaScript:void('0');" onclick="lock_estimation()" style="padding-left:10px;">
                                <i class="fa fa-fw fa-lock" ></i> Lock Estimate
                                </a>
                                </li>
                                
                            <?php }?>
                            
                            <li>
                                <a href="JavaScript:void('0');"  onclick="check_set_cal()" style="padding-left:10px;">
                                <i class="fa fa-fw fa-calculator" ></i> Set Calculation Type
                                </a>
                            </li>
                            <li>
                                <a href="JavaScript:void('0');"  onclick="check_work_order_cal()" style="padding-left:10px;">
                                <i class="fa fa-fw fa-file-word-o" ></i> Work Order Layout
                                </a>
                            </li>
                            <li>
                                <a href="JavaScript:void('0');"  onclick="reset_estimation()" style="padding-left:10px;">
                                <i class="fa fa-fw fa-undo" ></i> Reset Estimation
                                </a>
                            </li>
                        </ul>
                        
                    </div>
                </div>
                <a href="<?php echo site_url('proposals/estimate_items_total/' . $proposal->getProposalId()); ?>" class="btn right show_item_summary_btn" style="margin-left: 5px;">
                    <i class="fa fa-list"></i> Item Summary
                </a>
                
                <div class="dropdownButton" style="float:right;margin-left: 5px;">
                    <a class="dropdownToggle btn" href="#" >Preview <i class="fa fa-chevron-down"></i></a>
                    <div class="dropdownMenuContainer openAbove" style="display: none;width: 130px">
                        
                        <ul class="dropdownMenu" style="width: 130px">
                            <li>
                                <a href="JavaScript:void('0');" id="workorderpreview">
                                <i class="fa fa-fw fa-file-word-o"></i> Work Order
                                </a>
                            </li>
                            <li>
                                <a href="JavaScript:void('0');"  id="estimatepreview">
                                <i class="fa fa-fw fa-file-powerpoint-o"></i> Proposal
                                </a>
                            </li>
                            <!-- <li>
                                <a href="<?php echo site_url('proposals/job_costing/' . $proposal->getProposalId()); ?>"  id="estimatepreview">
                                <i class="fa fa-fw fa-file-powerpoint-o"></i> Job Costing
                                </a>
                            </li> -->
                        
                        </ul>
                        
                    </div>
                </div>
                <a href="<?php echo site_url('proposals/edit/' . $proposal->getProposalId()); ?>" class="btn right">
                    <i class="fa fa-chevron-left"></i> Back
                </a>
                <div class="dropdownButton item_search_btn" style="float:right;margin-left: 5px;margin-right: 5px;display:none">
                    <a class="dropdownToggle btn" href="JavaScript:void('0');" ><i class="fa fa-fw fa-search"></i> </a>
                    <div class="dropdownMenuContainer openAbove" style="display: none;width: 270px;padding: 5px;border-radius: 5px;left: -256px;">
                    <p style="font-size: 16px;padding: 5px;font-weight: bold;"><i class="fa fa-fw fa-search"></i> Item Search </p>
                        <a class="item_search_close" href="JavaScript:void('0');">×</a>
                        <ul class="dropdownMenu" style="width: 216px">
                            <li style="padding:5px">
                            <input type="text" id="item_search" class="clearable" placeholder="search" >
                            </li>
                            
                        </ul>
                        
                    </div>
                </div>
                <?php if($title != 'Locked'){ ?>
                    <a class="switch_check btn if_items_show tiptip" title="Show saved items only" href="JavaScript:void('0');" style="display:none;float:right"><i class="fa fa-fw fa-eye"></i> </a>
                <?php } ?>
                <a class="btn if_items_hide tiptip " title="Show All Items" href="JavaScript:void('0');" style="display:none;float:right;background: rgb(37, 170, 225);"><i style="font-size: 13px;color:#fff" class="fa fa-fw fa-eye"></i> </a>
                <input style="display:none" class="dont-uniform" type="checkbox" id="show_only_saved_items">
                   
                
        </div>
    </div>

    <div class="widthfix clearfix relative">

        <div style="width: 25%; float: left;" id="proposalServicesContainer">
            <h4> <span class="serviceTitle" style="color: #3f3f41;">Services</span> <span class="serviceToggle" style="cursor:pointer;float: right;font-size: 11px;color:#4A4A4A!important;margin-right: 3px;"><i class="fa fa-fw fa-2x fa-chevron-circle-left small " style="position: relative;top: 3.3px;width:21px"></i></span></h4>
            
                                
            <?php $this->load->view('proposals/estimate/proposal-services'); ?>

        </div>

        <div id="proposalEstimator" style="float: right; width: 75%;">
            <!-- <div style="width: 100%;float: left;" >
                <h4 class="heading_proposal_phase" style="float: left; width: 55%;min-height: 18px;margin-left: 6px;"></h4>
                <p class="heading_proposal_total" style="float: left; width: 44%;margin-top: 8px; text-align: right; display: block; font-size: 15px;">Proposal: Price <span style="font-weight:bold;" class="final_table_proposal_total_price">0.00</span> | Margin <span style="font-weight:bold;" class="final_table_proposal_profit_percent">0%</span></p>
            </div> -->
            <?php $this->load->view('proposals/estimate/estimator'); ?>
        </div>
    </div>
</div>

<div id="historyDialog" title="Estimate History" style="display: none;">
    <table id="estimateHistoryTable">
        <thead>
            <tr>
                <th>Date</th>
                <th>IP</th>
                <th>User</th>
                <th>Details</th>
            </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>


<div id="notesDialog" title="Estimate Notes" style="display:none;">
<textarea class="text estimate_note_text"  style="width:98%; margin-bottom:10px;" rows="9"></textarea>
<input type="button" class="btn blue-button estimate_note_btn" value="Save" style="margin-bottom:10px;float:right"/>
</div>

<div id="estimatepreviewDialog" title="Preview Proposal" style="display:none;">
<?php $url = $proposal->getProposalViewUrl(); ?>
<a href="<?= $url;?>" download style="margin-bottom: 5px;"  class="btn right blue-button" >
<i class="fa fa-fw fa-download"></i>Download</a>
<div style="text-align: center;" id="loadingFrame">
            <br />
            <p><strong>Loading Proposal</strong></p><br />
            <p><img src="/static/loading_animation.gif" /></p>
        </div>
        <iframe id="estimate-preview-iframe" style="width: 100%; height: 650px;></iframe>
       
</div>

<div id="workOrderDialog" title="Preview Work Order" style="display:none;">
<?php $url =  site_url('proposals/live/view/work_order/' . $proposal->getAccessKey() . '.pdf');
    $send_url = site_url('proposals/edit/'.$proposal->getProposalId().'/preview_workorder');?>
<a href="<?= $url;?>" download class="btn right blue-button" style="margin-bottom: 5px;" >
<i class="fa fa-fw fa-download" ></i>Download</a>
<a href="<?= $send_url;?>"  class="btn right blue-button" style="margin-bottom: 5px; margin-right:10px;" >
<i class="fa fa-fw fa-envelope" ></i>Send</a>
<div style="text-align: center;" id="loadingFrame2">
            <br />
            <p><strong>Loading Work Order</strong></p><br />
            <p><img src="/static/loading_animation.gif" /></p>
        </div>

<iframe id="workOrder-preview-iframe" style="width: 100%; height: 650px;"></iframe>
       
</div>
<div id="notes" title="Estimate Notes" style="display:none;">
        <form action="#" id="add-note">
            <p>
                <label>Add Note</label>
                <input type="text" name="noteText" id="noteText" style="width: 500px;">
                <input type="hidden" name="relationId" id="relationId" value="0">
                <input type="submit" value="Add">
            </p>
            <p style="padding-top: 10px;padding-left: 56px;"><span style="position: relative;top: 2px;">Include note in Work Order</span> <input type="checkbox" name="proposal_work_order_note" id="proposal_work_order_note"> </p>
            <iframe id="notesFrame" src="" frameborder="0" width="100%" height="250"></iframe>
        </form>
    </div>
<div id="setCalculationDialog" title="Change Calculation Type" style="display: none;">
    <!-- <h3 class="text-center">Change Calculation Type</h3> -->
    <h4 class="text-center">This will change how PM/OH is calculated - you can do this for each item, or for each service as a whole</h4>
    <form action="<?php echo site_url('account/saveProposalEstimationSettings'); ?>" method="post">
    <input type="hidden" name="proposal_id" value="<?php echo $proposal->getProposalId(); ?>">
    <table class="boxed-table pl-striped" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <label for="defaultOverhead" style="width: 150px;"> Calculation Type</label>
                <span class="cwidth4_container">
                <select name="calculationType" class="selcalculationType">
                    <?php foreach ($calculationTypes as $calculationType) : ?>
                    <option value="<?php echo $calculationType->getId() ?>"<?php echo ($calculationType->getId() == $oh_pm_type) ? ' selected' : '' ?>>
                        <?php echo $calculationType->getName(); ?>
                    </option>
                    <?php endforeach; ?>
                </select>
                </span>
            </td>
        </tr>
        <tr class="if_total_pm_oh">
            <td>
                <label for="defaultOverhead" style="width: 150px;"> Overhead %</label>
                <input type="number" name="defaultOverhead" class="text input50" style=" text-align: right"
                       value="<?php echo ($proposal->getEstimateOhRate())?:$settings->getDefaultOverhead(); ?>">
            </td>
        </tr>
        <tr class="if_total_pm_oh">
            <td>
                <label for="defaultProfit" style="width: 150px;"> Profit %</label>
                <input type="number" name="defaultProfit" class="text input50"  style="text-align: right"
                       value="<?php echo ($proposal->getEstimatePmRate())?:$settings->getDefaultProfit(); ?>">
            </td>
        </tr>
        <tr>
            <td>
                <button class="btn blue-button" type="submit" style="float: right;">
                    <i class="fa fa-fw fa-save"></i> Save 
                </button>
            </td>
        </tr>

    </table>

</form>
</div>
<div id="setWorkOrderDialog" title="Change Work Order Layout" style="display: none;">
    <!-- <h3 class="text-center">Change Calculation Type</h3> -->
    <!-- <h4 class="text-center">This will change how PM/OH is calculated - you can do this for each item, or for each service as a whole</h4> -->
    <!-- <form action="<?php echo site_url('account/saveProposalWorkOrderSettings'); ?>" method="post"> -->
    <input type="hidden" id="proposal_id" name="proposal_id" value="<?php echo $proposal->getProposalId(); ?>">
    <table class="boxed-table pl-striped" width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td>
                <label for="" style="width: 150px;"> Work Order Layout</label>
                <span class="cwidth4_container">
                    <select name="work_order_layout_type" id="work_order_layout_type">
                    
                        <option value="service_and_phase" <?php echo ('service_and_phase' == $proposal->getWorkOrderLayoutType()) ? ' selected' : '' ?>>Service & Phase</option>
                        <option value="service" <?php echo ('service' == $proposal->getWorkOrderLayoutType()) ? ' selected' : '' ?>>Service</option>
                        <option value="all_items" <?php echo ('all_items' == $proposal->getWorkOrderLayoutType()) ? ' selected' : '' ?>>All Items</option>
                    
                    </select>
                </span>
            </td>
        </tr>
        <tr >
            <td>
                <label style="width: 150px;">Group Assembly Items</label>
                <input type="checkbox" name="group_template_item" id="group_template_item" <?php echo ('1' == $proposal->getGroupTemplateItem()) ? 'checked="checked"' : '' ?> value="1">
            </td>
        </tr>
        
        <tr>
            <td>
                <button class="btn blue-button" type="submit" id="work_order_layout_submit" style="float: right;">
                    <i class="fa fa-fw fa-save"></i> Save 
                </button>
            </td>
        </tr>

    </table>

<!-- </form> -->
</div>
<script type="text/javascript">

$(document).on("click",".if_items_show",function() {
    $('.if_items_show').hide();
    $('.if_items_hide').show();
    $('#show_only_saved_items').trigger('click')

});

$(document).on("click",".if_items_hide",function() {
    $('.if_items_show').show();
    $('.if_items_hide').hide();
    $('#show_only_saved_items').trigger('click')

});
function check_set_cal(){
            $("#setCalculationDialog").dialog('open');
        }

    function check_work_order_cal(){
        $("#setWorkOrderDialog").dialog('open');
    }
    $(document).ready(function() {
        var activityTable;
        var proposalId = <?php echo $proposal->getProposalId(); ?>;
        var tableUrl = '/ajax/estimateHistory/' + proposalId;
        if($(".selcalculationType").val()=='2'){
                $('.if_total_pm_oh').hide();
        }else{
                $('.if_total_pm_oh').show();
        }
        var winH = $(window).height() - 20;
        // Dialog for history
        $("#historyDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 900,
            height:winH

        });
        $("#notesDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 500
        });

        $("#estimatepreviewDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 900
        });
        $("#workOrderDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 900
        });
        $("#setCalculationDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 500
        });
        $("#setWorkOrderDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 500
        });
        
       
        // History button for popup
        $("#estimateHistory").click(function() {

            

            if (activityTable) {
                activityTable.ajax.url(tableUrl).clear().load();
                $("#historyDialog").dialog('open');
            } else {
                activityTable = $("#estimateHistoryTable").DataTable({
                    "width": 700,
                    "bProcessing": true,
                    "serverSide": true,
                    "scrollCollapse": true,
                    "scrollY": winH,
                    "ajax": {
                        "url": tableUrl
                    },
                    "initComplete":function( settings, json){
                        $("#historyDialog").dialog('open');
        },
                    "aoColumns": [
                        { bSortable: true },
                        { bSortable: true },
                        { bSortable: false },
                        { bSortable: false }
                    ],
                    "bJQueryUI": true,
                    "bAutoWidth": true,
                    "sPaginationType": "full_numbers",
                    "sDom": 'HfltiprF',
                    "aLengthMenu": [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    "order": [[0, "desc"]],
                    "fnDrawCallback": function() {
                        $("#proposalActivity").dialog('open');
                    }
                });
                
                activityTable.ajax.url(tableUrl).clear().load();
            }
           
        });

        $(".selcalculationType").change(function() {
            if($(".selcalculationType").val()=='2'){
                $('.if_total_pm_oh').hide();
            }else{
                $('.if_total_pm_oh').show();
            }
            
        });
    

    });

    $("#estimateNotes22").click(function() {

        $("#notesDialog").dialog('open');
        $.ajax({
            url: '/ajax/check_api3/',
            type: 'post',
            data: {
                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                
            },
            success: function(data){
                data = JSON.parse(data)
                $(".estimate_note_text").val(data.text);
            }
        });
    });

    $("#estimatepreview").click(function() {

        $("#estimatepreviewDialog").dialog('open');
        $("#estimate-preview-iframe").hide();
        // Show the loader
        $("#loadingFrame").show();
        // Refresh the iframe - Load event will handle showing the frame and hiding the loader
        var currSrc = '<?php echo $proposal->getProposalViewUrl(); ?>';
        $("#estimate-preview-iframe").attr("src", currSrc);

    });

    $("#workorderpreview").click(function() {

        $("#workOrderDialog").dialog('open');
        $("#workOrder-preview-iframe").hide();
        // Show the loader
        $("#loadingFrame2").show();
        // Refresh the iframe - Load event will handle showing the frame and hiding the loader
        var currSrc = '<?php echo  site_url('proposals/live/view/work_order/' . $proposal->getAccessKey() . '.pdf');?>';
        $("#workOrder-preview-iframe").attr("src", currSrc);
        
    });
   
    document.getElementById('workOrder-preview-iframe').onload = function() {
        $("#loadingFrame2").hide();
        $("#workOrder-preview-iframe").show();
    }

    $(".estimate_note_btn").click(function() {

        var estimate_note_text = $(".estimate_note_text").val();
        
        $.ajax({
            url: '/ajax/check_api/',
            type: 'post',
            data: {
                'estimate_note_text':estimate_note_text,
                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                
            },
            success: function(data){
                $("#notesDialog").dialog('close');
                swal(
                        'Estimation Note saved',
                        ''
                    );
            }
        });
    });

    $("#estimateNotes").live('click', function () {
        var id = <?php echo $proposal->getProposalId(); ?>;
        $('#proposal_work_order_note').prop("checked",true);
        $.uniform.update()
        var frameUrl = '<?php echo site_url('account/estimate_item_and_estimate_notes') ?>/' + id;
        $("#notesFrame").attr('src', frameUrl);
        $("#relationId").val(id);
        $('#notesFrame').load(function () {
            $("#notes").dialog('open');
        });
        return false;
    });


    $("#add-note").submit(function () {
        var proposal_work_order_note = 0;
        if($('#proposal_work_order_note').prop("checked")){
            proposal_work_order_note = 1;
        }else{
            proposal_work_order_note = 0;
        }
        var request = $.ajax({
            url: '<?php echo site_url('ajax/addNote') ?>',
            type: "POST",
            data: {
                "noteText": $("#noteText").val(),
                "noteType": 'estimate',
                "relationId": $("#relationId").val(),
                "work_order":proposal_work_order_note,
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
var collapsed = false;
$('.serviceToggle').click(function(){
    if(!collapsed){
        var checkHeigth =$( '#proposalEstimator').height();
        $('#proposalServicesContainer').animate({width: '4%',height:checkHeigth});
        $('#proposalServicesContainer').addClass('collaspeService');
        $('#proposalEstimator').animate({width: '96%'});
        $('#piechartParent').animate({width: '67%'});
        $('#proposal_services,.serviceTitle').hide();
        $('.edit_proposal_btn').hide();
        $('.serviceToggle i').removeClass('fa-chevron-circle-left');
        $('.serviceToggle i').addClass('fa-chevron-circle-right');
        
        if($("#page_load_message").is(":visible")){
            $('#addCustomService').hide();
        }
        
    } else {
        $('#proposalServicesContainer').animate({width: '25%'},500, function() {
    // Animation complete.
        $('#proposal_services,.serviceTitle').show();
        if($("#page_load_message").is(":visible")){
            $('#addCustomService').show();
        }
        $('.edit_proposal_btn').show();
        $('#proposalServicesContainer').removeClass('collaspeService');
        $('#proposalServicesContainer').css('height', 'auto');
  });
       
        $('#proposalEstimator').animate({width: '75%'});
        $('#piechartParent').animate({width: '58%'});
        
        
        $('.serviceToggle i').addClass('fa-chevron-circle-left');
        $('.serviceToggle i').removeClass('fa-chevron-circle-right');
        
    }
    collapsed = !collapsed;
})

$("#work_order_layout_submit").click(function() {

$.ajax({
    url: '/ajax/saveProposalWorkOrderSettings/',
    type: 'post',
    data: {
        'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
        'work_order_layout_type': $('#work_order_layout_type').val(),
        'group_template_item':($('#group_template_item').prop("checked")==true)? 1 : 0
    },
    success: function(data){
        $("#setWorkOrderDialog").dialog('close');
                swal(
                        'Work Order layout updated',
                        ''
                    );
        if($("#categoryTabs .ui-tabs-panel:visible").attr("id")=='summaryTab'){
            get_summary_data_by_phase_id();
        }
    }
});
});
</script>

<?php $this->load->view('proposals/estimate/estimate-js'); ?>
<?php $this->load->view('global/footer'); ?>