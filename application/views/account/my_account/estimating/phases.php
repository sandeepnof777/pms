<style type="text/css">

    ul#categoryList {
        width: 100%;
    }

    ul#categoryList li, ul#serviceList li {
        width: 100%px;
        background: #d8dbd6;
        margin-bottom: 1px;
        border-radius: 5px;
    }

    ul#categoryList li a {
        display: block;
        padding: 10px;
        color: #000;
        background: #d8dbd6;
        border-radius: 5px;
    }

    ul#serviceList li a {
        display: block;
        padding: 10px;
        color: #000;
        background: #edf0eb;
        border-radius: 5px;
        border: 1px solid #b3b6b1;
    }

    ul#categoryList li a:hover {
        background: #949792;
    }

    ul#categoryList li a.selectedCategory {
        display: block;
        padding: 10px;
        color: #fff;
        background: #25aae1;
        border-radius: 5px;
    }

    ul#serviceList li a.selectedService {
        display: block;
        padding: 10px;
        color: #fff;
        background: #25aae1;
        border-radius: 5px;
    }

    ul#categoryList li a {
        display: block;
        padding: 10px;
        color: #000;
        background: #c1c4bf;
        border-radius: 5px;
    }

    ul#serviceList .serviceListItem {
        display: none;
    }

    ul#serviceList #selectCategoryMessage {
        display: block;
    }

    .categoryDefaultPhases {
        display: none;
    }

    .categoryPhaseList li {
        padding: 10px 0 10px 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin-bottom: 2px;
        background: #fff;
    }

    span.sortHandle {
        margin-right: 10px;
    }

    span.phasePosition {
        font-weight: bold;
    }

    a#addPhase {
        display: none;
        float: right;
    }

    .phaseControlButton {
        float: right;
        margin-top: -7px;
        margin-right: 5px;
    }

</style>
<h3>Estimation Phases</h3>
<div class="materialize">

<!-- <a href="<?php echo site_url('account/my_account/proposal_settings') ?>" class="m-btn"  style="position: absolute;right:10px;margin-top: -37px;">
   Back
</a>  -->
</div>
<p class="adminInfoMessage"><i class="fa fa-fw fa-info-circle"></i>These are your Estimation Phases. You can add, edit, delete and reorder.</p>

    
    <!---Start Filter button---->
<div class="materialize" style="min-height: 30px !important;width:100%;top: 4px;float:right;margin-right: 10px;margin-bottom: 10px;white-space: nowrap;">
                                <!-- <a href="#" style="float:right;" class="m-btn" id="resetPhase">
                                    <i class="fa fa-fw fa-undo"></i>
                                    Reset Phases
                                </a> -->
                                <a href="#" style="float:right;margin-right: 10px;" class="m-btn" id="addPhase">
                                    <i class="fa fa-fw fa-plus"></i>
                                    Add Phase
                                </a>
                                <div class="m-btn groupAction tiptip" id="groupAction" style="position: relative;display:none;font-size: 14px;margin-right: 10px;float:right;" title="Carry out actions on selected Types" >
                                    <i class="fa fa-fw fa-check-square-o"></i> Group Actions
                                    <div class="groupActionsContainer materialize" style="width:160px">
                                        <div class="collection groupActionItems" >
                                            
                                            <a href="javascript:void(0);" class="groupDelete collection-item iconLink" style="width: 100%;color:#000;padding: 4px;float: left;font-weight:normal">
                                                <i class="fa fa-fw fa-trash"></i> Delete Types
                                            </a>
                                            
                                        </div>
                                    </div>
                                </div>
                               
                                
                                <div class="clearfix"></div>
</div>
        <!---End Filter button---->
    




    <div class="widthfix" style="padding: 10px;">

        <div style="width: 220px;float: left;margin-right: 20px;">

            <h4>Categories</h4>

            <ul id="categoryList" style="height:500px;overflow-y:scroll">
                <?php foreach ($categories as $category) : ?>
                    <li>
                        <a href="#" class="categoryListItem" data-category-id="<?php echo $category->getServiceId(); ?>">
                            <?php echo $category->getServiceName(); ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

        </div>

        <div style="width: 220px; float: left; margin-right: 20px;">

            <h4>Select Service</h4>

            <ul id="serviceList">
                <li id="selectCategoryMessage" class="serviceListItem">
                    <a href="#">
                        Select a category...
                    </a>
                </li>
                <?php foreach ($services as $serviceIds) : ?>
                    <?php foreach ($serviceIds as $service) : ?>
                        <li class="serviceListItem">
                            <a href="#" class="serviceListItemLink" data-category-id="<?= $service->getParent(); ?>" data-service-id="<?php echo $service->getServiceId(); ?>">
                                <?php echo $service->getServiceName(); ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </ul>

        </div>

        <div style="width: 290px; float: left;">

            <h4>Default Phases</h4>

            <?php foreach ($services as $serviceIds) : ?>
                <?php foreach ($serviceIds as $service) : ?>
                    <div class="categoryDefaultPhases" data-category-id="<?php echo $service->getServiceId(); ?>">
                        <ul class="categoryPhaseList" data-service-id="<?php echo $service->getServiceId(); ?>">
                            <?php
                            $i = 1;
                            foreach ($phases[$service->getServiceId()] as $defaultPhase) : ?>
                                <li id="phases_<?php echo $defaultPhase->getId(); ?>">
                            <span class="sortHandle">
                                <i class="fa fa-fw fa-sort"></i>
                            </span>
                                    <span class="phasePosition"><?php echo $i; ?></span>.&nbsp;

                                    <span class="phaseItemName"><?php echo $defaultPhase->getName(); ?></span>

                                    <a class="btn tiptip deletePhase phaseControlButton" title="Delete"
                                       data-phase-id="<?php echo $defaultPhase->getId(); ?>">
                                        <i class="fa fa-fw fa-trash"></i>
                                    </a>

                                    <a class="btn tiptip editPhase phaseControlButton" title="Edit"
                                       data-phase-id="<?php echo $defaultPhase->getId(); ?>">
                                        <i class="fa fa-fw fa-edit"></i>
                                    </a>
                                </li>
                                <?php
                                $i++;
                            endforeach; ?>
                        </ul>

                    </div>
                <?php endforeach; ?>
            <?php endforeach; ?>

        </div>
    </div>


<div id="phaseDialog" title="Phase details">
    <input type="hidden" id="phaseId" value="" />
    <label>Phase Name:</label>
    <input type="text" class="text" id="phaseName" />
</div>


<!-- Confirm delete dialog -->
<div id="delete-Phases" title="Confirmation">
    <h3>Confirmation - Delete Phases</h3>

    <p>This will delete a total of <strong><span id="deleteNum"></span></strong> phases.</p>
    <br/>
    <p><strong>Phases used in existing estimates will be saved</strong></p>
    <br />
    <p>Proceed?</p>
</div>
<div id="delete-phases-status" title="Confirmation">
    <h3>Confirmation - Delete Phases</h3>

    <p id="deletePhasesStatus"></p>
</div>
<script type="text/javascript">

    $(document).ready(function() {

        // var for selected category
        var categoryId, serviceId;
        var editingPhase = false;
        var editPhaseId, deletePhaseId;

        // Tooltips
        initTiptip();

        // Dialog
        $("#phaseDialog").dialog({
            modal: true,
            autoOpen: false,
            buttons: {
                "Cancel": {
                    text: 'Cancel',
                    'class': 'btn left',
                    click: function () {
                        $(this).dialog('close');
                    }
                },
                "Save": {
                    text: 'Save Phase',
                    'class': 'btn blue-button',
                    click: function () {
                        // Save dynamically
                        $.ajax({
                            type:"POST",
                            url:"<?php echo site_url('ajax/saveEstimateDefaultPhase') ?>",
                            dataType: 'JSON',
                            data: {
                                serviceId: serviceId,
                                phaseId: $("#phaseId").val(),
                                phaseName: $("#phaseName").val()
                            }
                        }).success(function(data) {

                            if (data.error) {
                                swal('Error saving phase!')
                            } else {
                                $("#phaseDialog").dialog('close');
                                swal('Phase Saved');

                                var position = ($("ul[data-service-id='" + serviceId + "'] li").length) + 1

                                // If editing, update content
                                if (editingPhase) {

                                    $("li#phases_" + data.phase.id).find('.phaseItemName').text(data.phase.name);


                                } else {
                                    // Adding, so append
                                    $("ul[data-service-id='" + serviceId + "']").append(
                                        '<li id="phases_' + data.phase.id + '">' +
                                        '<span class="sortHandle">' +
                                        '<i class="fa fa-fw fa-sort"></i> </span> ' +
                                        '<span class="phasePosition">' + position + '</span>.&nbsp;' +
                                        '<span class="phaseItemName">' + data.phase.name + '</span>' +
                                        '<a class="btn tiptip deletePhase phaseControlButton" title="Delete"' +
                                        'data-phase-id="' + data.phase.id + '">' +
                                        '<i class="fa fa-fw fa-trash"></i>' +
                                        '</a>' +
                                        '<a class="btn tiptip editPhase phaseControlButton" title="Edit"' +
                                        'data-phase-id="' + data.phase.id + '">' +
                                        '<i class="fa fa-fw fa-edit"></i>' +
                                        '</a>' +
                                        '</li>'
                                    );
                                    
                                    // Init buttons and tooltips as it's a new element
                                    initButtons();
                                    initTiptip();
                                    
                                }
                                $.uniform.update();
                                var li_count = $(".categoryDefaultPhases[data-category-id='" + serviceId + "']").find('li').length;
            
                                if(li_count>0){
                                    $('.no_phases_msg').hide();
                                }else{
                                    $('.no_phases_msg').show();
                                }
                                // Refresh the sorter
                                $(".categoryPhaseList").sortable('refresh');
                            }
                        });
                    }
                }
            }
        });

        // Handle click of category name
        $(".categoryListItem").click(function() {

            // Set the current category
            categoryId = $(this).data('category-id');
            // Clear previous selection
            $(".categoryListItem").removeClass('selectedCategory');
            $(".selectedService").removeClass('selectedService');
            // Make sure all are closed
            $(".serviceListItem").hide();
            $(".categoryDefaultPhases").hide();
            // Show the selected category phases
            $(".serviceListItemLink[data-category-id='" + categoryId + "']").parents('li').show();
            var li_count = $(".serviceListItemLink[data-category-id='" + categoryId + "']").find('li').length;
            
            if(li_count>0){
                $('.no_phases_msg').hide();
            }else{
                $('.no_phases_msg').show();
            }
            // Highlight this category
            $(this).addClass('selectedCategory');
            // Show the add button
            $("#addPhase").hide();

            return false;
        });

        // Handle click of service name
        $(".serviceListItemLink").click(function() {

            // Set the current category
            serviceId = $(this).data('service-id');
            // Clear previous selection
            $(".selectedService").removeClass('selectedService');
            // HIde all phases
            $(".categoryDefaultPhases").hide();
            // Show the selected category phases
            $(".categoryDefaultPhases[data-category-id='" + serviceId + "']").show();
            // Highlight this category
            $(this).addClass('selectedService');
            // Show the add button
            $("#addPhase").show();

            return false;
        });

        // Add phase click
        $("#addPhase").click(function() {
            editingPhase = false;
            $("#phaseId").val('');
            $("#phaseName").val('');
            $("#phaseDialog").dialog('open');
            return false;
        });

        // Edit phase click
        $(document).on("click", ".editPhase", function() {
            editingPhase = true;
            editPhaseId = $(this).data('phase-id');
            $("#phaseId").val(editPhaseId);
            $("#phaseName").val($(this).parents('li').find('.phaseItemName').text());
            $("#phaseDialog").dialog('open');
            return false;
        });

        // Sortable Phases
        $(".categoryPhaseList").sortable({
            // Update the numbers in the list
            update: function(event, ui) {
                updateListNumbers();
            },
            stop: function () {
                var postData = $(this).sortable("serialize");
                $.ajax({
                    type:"POST",
                    url:"<?php echo site_url('ajax/updateCompanyEstimationDefaultPhasesOrder') ?>/" + serviceId,
                    data: postData
                });
            }
        });

        // Delete Button CLick
        $(document).on("click", ".deletePhase", function() {

            deletePhaseId = $(this).data('phase-id');

            swal({
                title: 'Delete Phase',
                html: '<p>Are you sure you want to delete this phase?</p>',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText:
                    '<i class="fa fa-fw fa-trash"></i> Delete Phase',
                cancelButtonText:
                    '<i class="fa fa-fw fa-close"></i> Cancel'
            }).then(
                function() {
                    $.ajax({
                        type:"GET",
                        url:"<?php echo site_url('ajax/deleteDefaultEstimationPhase') ?>/" + deletePhaseId
                    }).success(function(data) {

                        if (!data.error) {

                            swal('Default Phase Deleted');

                            // Delete from list
                            $("li#phases_" + deletePhaseId).remove();

                            // List numbering
                            updateListNumbers();

                        } else {
                            swal('Error deleting Phase');
                        }

                    });
                }, function (dismiss) {

                }
            );
            return false;
        });

        // End document ready
    });

    function updateListNumbers() {
        $(".categoryDefaultPhases").each(function() {
            if ($(this).is(':visible')) {
                $(this).find('span.phasePosition').each(function(i) {
                    var num = i + 1;
                    $(this).text(num);
                });
            }
        });
    }

//Group action functionality

        // Group Actions Button
        $(".groupAction").click(function () {
        
        // Toggle the buttons
        $(".groupActionsContainer").toggle();
        return false;
    });

//  Create an array of the selected IDs 
function getPhasesSelectedIds() {

var IDs = new Array();

$(".phase_check:checked").each(function () {
    IDs.push($(this).data('phase-id'));
});

return IDs;
}

// Update the number of selected items
function updateNumSelected() {
            var num = $(".phase_check:checked").length;

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


     // Update the counter after each change
     $(".phase_check").live('change', function () {
        //var cat_id = $(this).data('category-id');
            updateNumSelected();
        });

        
        // All
        $(".check_all").live('click', function () {
            if($(this).prop("checked")===true){
                $(this).closest('table').find(".phase_check").prop('checked', true);
            } else {
                $(this).closest('table').find(".phase_check").prop('checked', false);
            }
            //var cat_id = $(this).data('category-id');
            updateNumSelected();
            $.uniform.update();
            //return false;
        });
    
    // Delete Click
    $('.groupDelete').click(function(){
            $("#delete-Phases").dialog('open');
            $("#deleteNum").html($(".phase_check:checked").length);
        });

    // Item Delete Update
    $("#delete-phases-status").dialog({
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
        $("#delete-Phases").dialog({
            width: 500,
            modal: true,
            buttons: {
                "Delete": {
                    text: 'Delete Phases',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmDelete',
                    click: function () {
                        
                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {'ids': getPhasesSelectedIds()},
                            url: "<?php echo site_url('ajax/phasesGroupDelete'); ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {

                                if (data.success) {
                                    var deleteText = data.count + ' Types were deleted';
                                }
                                else {
                                    var deleteText = 'An error occurred. Please try again';
                                }
                                var itemIds = getPhasesSelectedIds();
                                for($i=0;$i<itemIds.length;$i++){
                                    
                                 
                                   
                                 var parent_ul = $("li#phases_" + itemIds[$i]).closest('ul');
                                
                                $("li#phases_" + itemIds[$i]).remove();
                                var li_count = $(parent_ul).find('li').length;
            
                                    if(li_count>0){
                                        $('.no_phases_msg').hide();
                                    }else{
                                        $('.no_phases_msg').show();
                                    }
                                }
                                $('#groupAction').hide();
                                updateListNumbers();
                                $("#deletePhasesStatus").html(deleteText);
                                $("#delete-phases-status").dialog('open');
                            });

                        $(this).dialog('close');
                        $("#deletePhasesStatus").html('Deleting Phases...<img src="/static/loading.gif" />');
                        $("#delete-phases-status").dialog('open');
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });

        
 // Edit phase click
 $(document).on("click", ".resetPhase", function() {
    swal({
                title: 'Delete All Phases',
                html: '<p>Are you sure you want to delete All phases?</p>',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText:
                    '<i class="fa fa-fw fa-trash"></i> Reset Phases',
                cancelButtonText:
                    '<i class="fa fa-fw fa-close"></i> Cancel'
            }).then(
                function() {
                    $.ajax({
                        type:"GET",
                        url:"<?php echo site_url('ajax/deleteDefaultEstimationPhase') ?>/" + deletePhaseId
                    }).success(function(data) {

                        if (!data.error) {

                            swal('Default Phase Deleted');

                            // Delete from list
                           
                            // List numbering
                            updateListNumbers();

                        } else {
                            swal('Error deleting Phase');
                        }

                    });
                }, function (dismiss) {

                }
            );
        });
</script>