<style>
.cwidth3_container div.selector span{width:50px!important;}
.cwidth3_container div.selector{width:75px!important;}
#templateNameDialog input:focus
{
    border-color: #66afe9;
    outline: 0;
    -webkit-box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
    box-shadow: inset 0 1px 1px rgba(0,0,0,.075), 0 0 8px rgba(102,175,233,.6);
}
table.formTable label.error {
    margin-top: 6px;

}
</style>
<h3>Estimation Assemblies</h3>
<div class="materialize">
    
    <!-- <a class="m-btn"   href="<?php echo site_url('account/my_account/proposal_settings') ?>" style="position: absolute;right:5px;margin-top: -37px;">
              Back
</a> -->
<a class="m-btn" id="addEstTemplate" href="#" style="position: absolute;right:12px;margin-top: -37px;">
            <i class="fa fa-fw fa-plus"></i>
            Add Assembly
</a>

</div>
<p class="adminInfoMessage"><i class="fa fa-fw fa-info-circle"></i>These are your Estimation Assemblies. You can add, edit, delete and reorder.</p>


<!---Start Filter button---->
<div class="materialize" style="min-width: 100px !important;top: 4px;float:right;white-space: nowrap;">
        <div class="m-btn groupAction tiptip"  style="position: relative;display:none;font-size: 14px;" title="Carry out actions on selected Assemblies" >
            <i class="fa fa-fw fa-check-square-o"></i> Group Actions
            <div class="groupActionsContainer materialize" style="width:160px">
                <div class="collection groupActionItems" >
                    
                    <a href="javascript:void(0);" class="groupDelete collection-item iconLink" style="width: 100%;color:#000;padding: 4px;float: left;font-weight:normal">
                        <i class="fa fa-fw fa-trash"></i> Delete Assembly
                    </a>
                    
                </div>
            </div>
        </div>
        
        <div class="clearfix"></div>
</div>
<!---End Filter button---->
<table class="boxed-table defaultTable" width="100%" id="estimationTemplates">
    <thead >
    <tr>
    <th width="3%"><span class="span_checkbox_th"><input type="checkbox" class="check_all"></span></th>
    <th style="padding: 5px;width:5%"> <i class="fa fa-fw fa-sort"></i></th>
        <th style="padding: 10px; text-align: left;width:20%">Assembly Name</th>
        <th style="padding: 10px; text-align: left;width:9%">Type</th>
        <th style="padding: 10px; text-align: left;width:9%">Unit</th>
        <th style="padding: 10px; text-align: left;width:9%">Rate</th>
        <th style="padding: 10px; text-align: left;width:20%">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($templates as $template) : ?>
        <tr id="templates_<?php echo $template->getId(); ?>">
        <td><span class="span_checkbox"><input type="checkbox" class="template_check" data-template-id="<?php echo $template->getId(); ?>" ></span></td>
            <td style="text-align: center" width="5%">
                <a class="handle">
                    <i class="fa fa-fw fa-sort"></i>
                </a>
            </td>
            <td><?php echo $template->getName(); 
                if($template->getIsEmpty()==0 && $template->getItemCount()<1){?>
                    <a href="<?php echo site_url('account/edit_estimating_template/' . $template->getId()); ?>"><i class="fa fa-exclamation-triangle no_item_flag tiptip " title="No Item Assign" style="margin-right: 2px;float:right;color:#000"></i></a>
                <?php }
                ?></td>
            <td><?php if($template->getFixed()){ echo 'Fixed Rate';
                echo ($template->getIsEmpty()) ? ' <span class="tiptip" title="Empty Template">[E]</span>' : '';}else{ echo 'Standard';} ?></td>
            <td><?php if($template->getFixed())
                        {
                            if($template->getCalculationType()==1){
                                echo 'Daily';
                            }else if($template->getCalculationType()==2){
                                echo 'Hourly';
                            }else{ echo 'None';}
                    }else{echo '-';}  ?></td>
            <td><?php  echo $template->getFixed() ? '$'.number_format($template->getPriceRate(), 2) : '-' ?></td>
            <td width="20%">
                <?php if ($template->getCompanyId()) : ?>
                    <a href="javascript:void(0);" class="btn tiptip editTemplate" title="Edit Assembly Name"
                       data-template-id="<?php echo $template->getId(); ?>"
                       data-template-name="<?php echo $template->getName(); ?>"
                       data-template-type="<?php echo $template->getFixed(); ?>"
                       data-template-empty="<?php echo $template->getIsEmpty(); ?>"
                       data-template-rate="<?php echo $template->getPriceRate(); ?>"
                       data-template-base-price="<?php echo $template->getBasePrice(); ?>"

                       data-template-overhead-rate="<?php echo $template->getOverheadRate(); ?>"
                       data-template-profit-rate="<?php echo $template->getProfitRate(); ?>"
                       data-template-overhead-price="<?php echo $template->getOverheadPrice(); ?>" 
                       data-template-profit-price="<?php echo $template->getProfitPrice(); ?>"


                       data-calculation-type="<?php echo $template->getCalculationType(); ?>"
                       >
                        <i class="fa fa-edit"></i>
                    </a>
                    <?php if(!$template->getIsEmpty()){?>
                    <a href="<?php echo site_url('account/edit_estimating_template/' . $template->getId()); ?>"
                       class="btn tiptip" title="Manage Assembly Items">
                        <i class="fa fa-list"></i>
                    </a>
                    <?php } ?>
                    <a href="javascript:void(0);" class="btn tiptip assignTemplate" title="Assign Assembly to Services"
                       data-template-id="<?php echo $template->getId(); ?>" data-template-name="<?php echo $template->getName(); ?>">
                        <i class="fa fa-list-alt"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn tiptip deleteTemplate" title="Delete Assembly"
                       data-template-id="<?php echo $template->getId(); ?>">
                        <i class="fa fa-trash"></i>
                    </a>
                    <a href="javascript:void(0);" class="btn tiptip btn-duplicate duplicateTemplate" title="Duplicate Assembly"
                       data-template-id="<?php echo $template->getId(); ?>"
                       data-template-name="<?php echo $template->getName(); ?>"
                       data-template-type="<?php echo $template->getFixed(); ?>"
                       data-template-empty="<?php echo $template->getIsEmpty(); ?>"
                       data-template-rate="<?php echo $template->getPriceRate(); ?>"
                       data-template-base-price="<?php echo $template->getBasePrice(); ?>"

                       data-template-overhead-rate="<?php echo $template->getOverheadRate(); ?>"
                       data-template-profit-rate="<?php echo $template->getProfitRate(); ?>"
                       data-template-overhead-price="<?php echo $template->getOverheadPrice(); ?>" 
                       data-template-profit-price="<?php echo $template->getProfitPrice(); ?>"


                       data-calculation-type="<?php echo $template->getCalculationType(); ?>"
                       >&nbsp;
                        <!-- <i class="fa fa-edit"></i> -->
                    </a>
                    <!-- <a href="<?php echo site_url('account/duplicate_template/' . $template->getId()) ?>" class="tiptip btn-duplicate" style="display: inline-block" title="Duplicate Assembly">&nbsp;</a> -->
                   
                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div id="templateNameDialog" title="Save Assembly ">

    <div style="padding-top: 10px;">
        <form id="saveTemplateForm" action="<?php echo site_url('account/saveEstimatingTemplate') ?>" method="post">
            <input type="hidden" name="templateId" id="templateId">
            <input type="hidden" name="isTemplateDuplicate" id="isTemplateDuplicate">      

    <table class="formTable boxed-table-error">
        <tr>
            <td>
                <label style="font-weight: bold;">Assembly Name</label>
            </td>
            <td>
                <input type="text" class="text" name="templateName" id="templateName" style="width: 250px;">
            </td>
        </tr>
        
        <tr>
            <td>
                <label style="font-weight: bold;">Fixed Rate</label>
            </td>
            <td>
                <input type="checkbox"  name="templateType" id="templateType">
                <span id="templateTypeMsgSpan" style="top: 2px;position: relative;">Assembly type may not be changed</span>
            </td>
        </tr>
        <tr class="templateRateRow">
            <td>
                <label style="font-weight: bold;">Empty</label>
            </td>
            <td>
                <input type="checkbox"  name="templateEmpty" id="templateEmpty">
                <span id="templateEmptyMsgSpan" style="top: 2px;position: relative;">Empty Assembly may not be changed</span>
            </td>
        </tr>
        <tr class="templateRateRow">
            <td>
            <label style="font-weight: bold;" >Base Cost</label>
            </td>
            <td>
                <input type="text" class="text currencyFormat"  name="templateBasePrice" id="templateBasePrice" style="width:60px">
                
            </td>
        </tr>
        <tr class="templateRateRow">
            <td>
            <label style="font-weight: bold;" >Overhead %</label>
            </td>
            <td>
                <input type="text" class="text percentFormat" name="templateOverheadRate" id="templateOverheadRate" style="width:60px">
                <input type="hidden" name="templateOverheadPrice" id="templateOverheadPrice">
                <span id="templateOverheadPriceSpan"></span>
            </td>
        </tr>
        <tr class="templateRateRow">
            <td>
            <label style="font-weight: bold;" >Profit %</label>
            </td>
            <td>
                <input type="text" class="text percentFormat" name="templateProfitRate" id="templateProfitRate" style="width:60px">
                <input type="hidden" name="templateProfitPrice" id="templateProfitPrice">
                <span id="templateProfitPriceSpan"></span>
            </td>
        </tr>
        <tr class="templateRateRow">
            <td>
            <label style="font-weight: bold;" class="rate_label">Daily Rate</label>
            </td>
            <td>
                <input type="text" class="text currencyFormat" name="templateRate" id="templateRate" style="width:60px">
                <span class="cwidth3_container">
                <select name="calculation_type" id="calculation_type">
                    <option value="1">Per Day</option>
                    <option value="2">Per Hour</option>
                </select>
                </span>
            </td>
        </tr>
        
        
    </table>
        </form>
    </div>

</div>


<div id="servicesDialog" title="Assign Assembly to Services">

    <h3>Assign Assembly to Services: <span id="assignTemplateName"></span></h3>
    <p style="font-size: 14px;margin-bottom: 10px;border-radius: 2px;padding: 5px 5px 5px 10px;background-color: #e8e3e3;"><i class="fa fa-info-circle"></i> &nbsp;Choose which services you want this assembly to be available for</p>
    <div class="clearfix"></div>

    <div id="assignLoading" style="display: none; text-align: center;">
        <img src="/static/loading_animation.gif" />
    </div>

    <a href="#" id="checkAll">All</a> / <a href="#" id="checkNone">None</a>
    <div class="clearfix"></div>

    <input type="hidden" id="assignTemplateId">

    <?php foreach ($services as $category) : ?>
        <div class="serviceTypeCheckContainer">
            <label>
                <input type="checkbox" class="serviceCheck" data-service-id="<?php echo $category->getServiceId() ?>"
                       value="<?php echo $category->getServiceId() ?>" />
                <span style="position: relative; top: 3px;"><?php echo $category->getServiceName(); ?></span>
            </label>

        </div>
    <?php endforeach; ?>
    <div class="clearfix"></div>
    <hr />

    <a class="left btn btn-default" href="#" id="cancelAssign">
        <i class="fa fa-fw fa-close"></i> Cancel
    </a>

    <a class="right btn blue-button" href="#" id="saveAssignments">
        <i class="fa fa-fw fa-save"></i> Save Assignments
    </a>

</div>

<!-- Confirm delete dialog -->
<div id="delete-Templates" title="Confirmation">
    <h3>Confirmation - Delete Assemblies</h3>

    <p>This will delete a total of <strong><span id="deleteNum"></span></strong> assemblies.</p>
    <br/>
    <p><strong>Assemblies used in existing estimates will be saved</strong></p>
    <br />
    <p>Proceed?</p>
</div>
<div id="delete-templates-status" title="Confirmation">
    <h3>Confirmation - Delete Assemblies</h3>

    <p id="deleteTemplatesStatus"></p>
</div>
<script src='/static/js/inputmask.js'></script>
<script type="text/javascript">

    $(document).ready(function() {
        
        $( "#saveTemplateForm" ).validate({
            rules:{
                
                templateRate:{
                    required:function(){
                    return "#templateType:checked"
                    }
                },
                templateOverheadRate:{
                    required:function(){
                    return "#templateType:checked"
                    }
                },
                templateProfitRate:{
                    required:function(){
                    return "#templateType:checked"
                    }
                },
                templateBasePrice:{
                    required:function(){
                    return "#templateType:checked"
                    }
                }
            }
            });

        $(".currencyFormat").inputmask("decimal",
            {
                "radixPoint": ".",
                "groupSeparator":",",
                "digits":2,
                "prefix":"$",
                "autoGroup":true,
                "showMaskOnHover": false,
                "showMaskOnFocus": false,
            }
        );
        $(".percentFormat").inputmask("decimal",
        {
            "radixPoint": ".",
            "groupSeparator":",",
            "suffix":"%",
            "autoGroup":true,
            "digits": 2,
            "showMaskOnHover": false,
            "showMaskOnFocus": false,
        }
    );
        // Instantiate Dialogs
        $("#templateNameDialog").dialog({
            autoOpen: false,
            modal: true,
            width: 500,
            buttons: {
                "Cancel": {
                    html: '<i class="fa fa-fw fa-close"></i> Cancel',
                    'class': 'btn left',
                    click: function () {
                        $(this).dialog('close');
                    }
                },
                "Save": {
                    html: '<i class="fa fa-fw fa-save"></i> Save Assembly',
                    'class': 'btn blue-button',
                    click: function () {

                        if (!$("#templateName").val()) {
                            swal('Please enter a assembly name!');
                            return false;
                        } else {
                            $("#templateType").removeAttr("disabled");
                            $("#saveTemplateForm").submit();
                        }

                    }
                }
            }
        });


        // Click to add new assembly
        $("#addEstTemplate").click(function() {
            // Clear the inputs
            $("#templateId").val('');
            $("#isTemplateDuplicate").val(0);
            $("#templateName").val('');
            $("#templateRate").val('0.00');
            $("#templateBasePrice").val('0.00');

            $("#templateOverheadRate").val(<?=$settings->getDefaultOverhead();?>);
            $("#templateProfitRate").val(<?=$settings->getDefaultProfit();?>);
         

            $("#templateOverheadPriceSpan").text('$0.00');
            $("#templateProfitPriceSpan").text('$0.00');
            $("#templateOverheadPrice").val('0.00');
            $("#templateProfitPrice").val('0.00');

            $("#templateType").prop("checked",false);
            
            $(".templateRateRow").hide();
            $("#templateType").removeAttr("disabled");
            $("#templateEmpty").removeAttr("disabled");
            $("#templateTypeMsgSpan").hide();
            $("#templateEmptyMsgSpan").hide();
            $.uniform.update();
            // SHow the dialog
            $( "#saveTemplateForm" ).valid();
            $("#templateNameDialog").dialog('option', 'title', 'Add New Assembly');
            $("#templateNameDialog").dialog('open');
            return false;
        });

        // Click to add new Assembly
        $(".editTemplate").click(function() {
            // Clear the inputs
            $("#templateId").val($(this).data('template-id'));
            $("#isTemplateDuplicate").val(0);
            $("#templateName").val($(this).data('template-name'));
            
            if($(this).data('template-type')){
                
                $("#templateType").prop('checked',true);
                $("#templateRate").val($(this).data('template-rate'));
                $("#templateOverheadRate").val($(this).data('template-overhead-rate'));
                $("#templateOverheadPrice").val($(this).data('template-overhead-price'));
                $("#templateOverheadPriceSpan").text('$'+addCommas($(this).data('template-overhead-price')));
                $("#templateBasePrice").val($(this).data('template-base-price'));
                $("#templateProfitRate").val($(this).data('template-profit-rate'));
                $("#templateProfitPrice").val($(this).data('template-profit-price'));
                $("#templateProfitPriceSpan").text('$'+addCommas($(this).data('template-profit-price')));


                $("#calculation_type").val($(this).data('calculation-type'));
                $("#calculation_type").trigger('change');
                $(".templateRateRow").show();
            }else{
               
                $("#templateType").prop('checked',false);
                $(".templateRateRow").hide();
            }

            if($(this).data('template-empty')){
                $("#templateEmpty").prop('checked',true);
                
            }else{
                $("#templateEmpty").prop('checked',false);
            }
            $("#templateType").attr("disabled", true);
            $("#templateEmpty").attr("disabled", true);
            $("#templateTypeMsgSpan").show();
            $("#templateEmptyMsgSpan").show();
            $.uniform.update();
            // SHow the dialog
            $( "#saveTemplateForm" ).valid();
            $("#templateNameDialog").dialog('option', 'title', 'Edit Assembly');
            $("#templateNameDialog").dialog('open');
            return false;
        });

        // Click to Duplicate Assembly
        $(".duplicateTemplate").click(function() {
            // Clear the inputs
            $("#templateId").val($(this).data('template-id'));
            $("#isTemplateDuplicate").val(1);
            $("#templateName").val('Copy of '+$(this).data('template-name'));
            
            if($(this).data('template-type')){
                
                $("#templateType").prop('checked',true);
                $("#templateRate").val($(this).data('template-rate'));
                $("#templateOverheadRate").val($(this).data('template-overhead-rate'));
                $("#templateOverheadPrice").val($(this).data('template-overhead-price'));
                $("#templateOverheadPriceSpan").text('$'+addCommas($(this).data('template-overhead-price')));
                $("#templateBasePrice").val($(this).data('template-base-price'));
                $("#templateProfitRate").val($(this).data('template-profit-rate'));
                $("#templateProfitPrice").val($(this).data('template-profit-price'));
                $("#templateProfitPriceSpan").text('$'+addCommas($(this).data('template-profit-price')));


                $("#calculation_type").val($(this).data('calculation-type'));
                $("#calculation_type").trigger('change');
                $(".templateRateRow").show();
            }else{
               
                $("#templateType").prop('checked',false);
                $(".templateRateRow").hide();
                $("#templateRate").val('0.00');
                $("#templateBasePrice").val('0.00');

                $("#templateOverheadRate").val(<?=$settings->getDefaultOverhead();?>);
                $("#templateProfitRate").val(<?=$settings->getDefaultProfit();?>);
            

                $("#templateOverheadPriceSpan").text('$0.00');
                $("#templateProfitPriceSpan").text('$0.00');
                $("#templateOverheadPrice").val('0.00');
                $("#templateProfitPrice").val('0.00');
            }
             if($(this).data('template-empty')){
                $("#templateEmpty").prop('checked',true);
                
            }else{
                $("#templateEmpty").prop('checked',false);
            }
            $("#templateType").attr("disabled", false);
            $("#templateEmpty").attr("disabled", false);
             $("#templateTypeMsgSpan").hide();
             $("#templateEmptyMsgSpan").hide();
            $.uniform.update();
            // SHow the dialog
            $( "#saveTemplateForm" ).valid();
            $("#templateNameDialog").dialog('option', 'title', 'Duplicate Assembly');
            $("#templateNameDialog").dialog('open');
            return false;
        });

        // Delete button
        $(".deleteTemplate").click(function() {

            var templateId = $(this).data('template-id');

            swal({
                html: 'Are you sure you want to delete this assembly?',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText:
                    '<i class="fa fa-fw fa-trash"></i> Delete Assembly',
                cancelButtonText:
                    '<i class="fa fa-fw fa-close"></i> Cancel'
            }).then(
                function() {
                    window.location.href = '<?php echo site_url('account/deleteEstimatingTemplate'); ?>/' + templateId;
                }, function (dismiss) {

                }
            );

            return false;
        });

        // Sortable Assemblies
        $("#estimationTemplates tbody").sortable({
            helper: fixHelper,
            handle:".handle",
            stop:function () {
                var postData = $(this).sortable("serialize");
                $.ajax({
                    type:"POST",
                    url:"<?php echo site_url('ajax/updateEstimationTemplateOrder') ?>",
                    data:postData,
                    async:false
                });
            }
        });


        // End document ready
    });

    // Return a helper with preserved width of cells
    var fixHelper = function(e, ui) {
        ui.children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    };

// Services Dialog
$("#servicesDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 650
        });

        // Open Service Dialog
        $(".assignTemplate").click(function() {

            // SHow the loader
            $("#assignLoading").show();

            // Grab the vars
            var templateId = $(this).data('template-id');
            var templateName = $(this).data('template-name');

            // Clear all checkboxes
            $(".serviceCheck").prop('checked', false);

            // Load the title and form
            $("#assignTemplateId").val(templateId);
            $("#assignTemplateName").text(templateName);

            // Grab the assigned services for this type
            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: {
                    'templateId' : templateId
                },
                url: "<?php echo site_url('ajax/getCompanyTemplateServices'); ?>",
                dataType: "JSON"
            })
            .success(function (data) {
                if (!data.error) {

                    $.each(data.services, function(idx, val) {
                        $('.serviceCheck[data-service-id="' + val + '"]').prop('checked', true);
                    });

                    $.uniform.update();

                } else {
                    swal(data.message);
                    console.log(data.debug);
                }

                $("#assignLoading").hide();
            });
            
            // Open the dialog
            $("#servicesDialog").dialog('open');
            return false;
        });

        $("#cancelAssign").click(function() {
            $("#servicesDialog").dialog('close');
            return false;
        });
        

        $("#saveAssignments").click(function() {

            var templateId = $("#assignTemplateId").val();

            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: {
                    'templateId' : templateId,
                    'serviceIds': getSelectedIds()
                },
                url: "<?php echo site_url('ajax/companyTemplateServiceAssign'); ?>",
                dataType: "JSON"
            })
            .success(function (data) {
                if (!data.error) {
                    $("#servicesDialog").dialog('close');
                    swal('Assignments Saved');
                } else {
                    $("#servicesDialog").dialog('close');
                    swal(data.message);
                    console.log(data.debug);
                }
            });

            return false;
        });
    // Check All
    $("#checkAll").click(function() {
            $(".serviceCheck").prop('checked', true);
            $.uniform.update();
            return false;
        });

        // Check All
        $("#checkNone").click(function() {
            $(".serviceCheck").prop('checked', false);
            $.uniform.update();
            return false;
        });
        $("#cancelAssign").click(function() {
            $("#servicesDialog").dialog('close');
            return false;
        });

 /* Create an array of the selected IDs */
 function getSelectedIds() {

var IDs = new Array();

$(".serviceCheck:checked").each(function () {
    IDs.push($(this).data('service-id'));
});

return IDs;
}

//Group action functionality

        // Group Actions Button
        $(".groupAction").click(function () {
        
        // Toggle the buttons
        $(".groupActionsContainer").toggle();
        return false;
    });

    /* Create an array of the selected IDs */
    function getTemplatesSelectedIds() {

        var IDs = new Array();

        $(".template_check:checked").each(function () {
            IDs.push($(this).data('template-id'));
        });

        return IDs;
    }

/* Update the number of selected items */
function updateNumSelected() {
            var num = $(".template_check:checked").length;

            // Hide the options if 0 selected
            if (num < 1) {
               // $("#groupActionIntro").show();
                $(".groupAction").hide();
                //$(".groupActionsContainer").hide();
            }
            else {
                //$("#groupActionIntro").hide();
                $(".groupAction").show();
            }

        }


     // Update the counter after each change
     $(".template_check").live('change', function () {
       
            updateNumSelected();
        });

        
        // All
        $(".check_all").live('click', function () {
            if($(this).prop("checked")===true){
                $(this).closest('table').find(".template_check").prop('checked', true);
            }else{
                $(this).closest('table').find(".template_check").prop('checked', false);
            }
            
            updateNumSelected();
            $.uniform.update();
            //return false;
        });
    
    // Delete Click
    $('.groupDelete').click(function(){
            $("#delete-Templates").dialog('open');
            $("#deleteNum").html($(".template_check:checked").length);
    });

    // Item Delete Update
    $("#delete-types-status").dialog({
            width: 500,
            modal: true,
            beforeClose: function (e, ui) {
                //location.reload();
            },
            buttons: {
                OK: function () {
                    $(this).dialog('close');
                    //location.reload();
                }
            },
            autoOpen: false
        });

        // Delete dialog
        $("#delete-Templates").dialog({
            width: 500,
            modal: true,
            buttons: {
                "Delete": {
                    text: 'Delete Types',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmDelete',
                    click: function () {
                        
                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {'ids': getTemplatesSelectedIds()},
                            url: "<?php echo site_url('ajax/templatesGroupDelete'); ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {

                                if (data.success) {
                                    var deleteText = data.count + ' Types were deleted';
                                }
                                else {
                                    var deleteText = 'An error occurred. Please try again';
                                }
                                var itemIds = getTemplatesSelectedIds();
                                for($i=0;$i<itemIds.length;$i++){
                                    
                                    $("tr#templates_" + itemIds[$i]).remove();
                                    updateNumSelected();
                                //    var table = $(row).closest('table');
                                //    table.DataTable().row(row).remove().draw();
                                   //var categoryId = table.data('category-id');
                                   //$('.type_count[data-category-id="' + categoryId+'"]').text(table.DataTable().rows().count());
                                  

                                }
                                $("#deleteTemplatesStatus").html(deleteText);
                                $("#delete-templates-status").dialog('open');
                            });

                        $(this).dialog('close');
                        $("#deleteTemplatesStatus").html('Deleting Items...<img src="/static/loading.gif" />');
                        $("#delete-templates-status").dialog('open');
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });
    // Assembly Delete Update
    $("#delete-templates-status").dialog({
            width: 500,
            modal: true,
            beforeClose: function (e, ui) {
                //location.reload();
            },
            buttons: {
                OK: function () {
                    $(this).dialog('close');
                    //location.reload();
                }
            },
            autoOpen: false
        }); 

 // Click to add new Assembly
 $("#templateType").click(function() {
    $(".templateRateRow").toggle($("#templateType").prop("checked"));
});

$("#calculation_type").on('change', function () {
       
       if($(this).val()==1){
            $('.rate_label').text('Daily Rate');
       }else{
            $('.rate_label').text('Hourly Rate');
       }
   });
   function cleanNumber(numberString) {
        var number = numberString.replace('$', '');
        number = number.replace(/,/g, '');
        number = number.replace("%", '');
        return number;
    }

   $(document).on("keyup","#templateRate,#templateOverheadRate,#templateProfitRate",function() {

        var templateRate = cleanNumber($('#templateRate').val());
        var templateOverheadRate = cleanNumber($('#templateOverheadRate').val());
        var templateProfitRate = cleanNumber($('#templateProfitRate').val());

        var total_rate = ((parseFloat(templateOverheadRate) + parseFloat(templateProfitRate)) /100) + parseFloat(1);

var base_cost = parseFloat(templateRate / total_rate);


    if(base_cost>0){
        $('#templateBasePrice').val(base_cost);
        var overheadPrice = parseFloat(parseFloat(base_cost * templateOverheadRate)/100).toFixed(2);
        var profitPrice = parseFloat(parseFloat(base_cost * templateProfitRate)/100).toFixed(2);
        $('#templateOverheadPrice').val(overheadPrice);
        $('#templateProfitPrice').val(profitPrice);
        $('#templateProfitPriceSpan').text('$'+addCommas(profitPrice));
        $('#templateOverheadPriceSpan').text('$'+addCommas(overheadPrice));
        
    }else{
        $('#templateBasePrice').val('0.00');
    }
});

   $(document).on("keyup","#templateBasePrice",function() {

        var templateBasePrice = cleanNumber($('#templateBasePrice').val());
        var templateOverheadRate = cleanNumber($('#templateOverheadRate').val());
        var templateProfitRate = cleanNumber($('#templateProfitRate').val());

        if(!templateOverheadRate){
            //$("#itemOverheadRate").val(0);
            templateOverheadRate=0;
        }
        if(!templateProfitRate){
           // $("#itemProfitRate").val(0);
            templateProfitRate=0;
        }
        console.log(templateBasePrice);
if(templateBasePrice>0){
        var overheadPrice = ((templateBasePrice * templateOverheadRate) / 100);
        var profitPrice = ((templateBasePrice * templateProfitRate) / 100);
        var totalPrice = parseFloat(templateBasePrice) + parseFloat(overheadPrice) + parseFloat(profitPrice);
        $('#templateOverheadPrice').val(overheadPrice);
        $('#templateProfitPrice').val(profitPrice);
        $('#templateProfitPriceSpan').text('$'+addCommas(profitPrice));
        $('#templateOverheadPriceSpan').text('$'+addCommas(overheadPrice));
        
        $('#templateRate').val(totalPrice);
    }else{
        $('#templateRate').val('0.00');
        $('#templateOverheadPrice').val('0.00');
        $('#templateProfitPrice').val('0.00');
        $('#templateProfitPriceSpan').text('$0.00');
        $('#templateOverheadPriceSpan').text('$0.00');
    }
        
});

    
       
</script>