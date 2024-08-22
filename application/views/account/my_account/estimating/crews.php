<style>
    .stripping-table tr:nth-child(odd){background-color: #fafafa;}
    .stripping-table tr:nth-child(even){background-color: #efefef;}
    .after_input2 {
        padding: 6px;
        padding-left: 0px;
        display: inline-block;
    }
</style>
<h3>Estimation Crews</h3>
<p class="adminInfoMessage"><i class="fa fa-fw fa-info-circle"></i>These are your Estimation Crews. You can add, edit, delete and reorder.</p>


<!---Start Filter button---->
<div class="materialize" style="min-width: 100px !important;top: 4px;float:right;white-space: nowrap;">
    <div class="m-btn groupAction tiptip"  style="position: relative;display:none;font-size: 14px;" title="Carry out actions on selected Crews" >
        <i class="fa fa-fw fa-check-square-o"></i> Group Actions
        <div class="groupActionsContainer materialize" style="width:160px">
            <div class="collection groupActionItems" >

                <a href="javascript:void(0);" class="groupDelete collection-item iconLink" style="width: 100%;color:#000;padding: 4px;float: left;font-weight:normal">
                    <i class="fa fa-fw fa-trash"></i> Delete Crews
                </a>

            </div>
        </div>
    </div>
    <a class="m-btn" id="addEstCrew" href="#" style="margin: 10px 10px 10px 0;">
        <i class="fa fa-fw fa-plus"></i>
        Add Crew
    </a>
    <div class="clearfix"></div>
</div>
<!---End Filter button---->
<table class="boxed-table defaultTable" width="100%" id="estimationCrews">
    <thead >
    <tr>
        <th width="3%"><span class="span_checkbox_th"><input type="checkbox" class="check_all"></span></th>
        <th style="padding: 5px;"> <i class="fa fa-fw fa-sort"></i></th>
        <th style="padding: 10px; text-align: left;">Crew Name</th>
        <th style="padding: 10px; text-align: left;">Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($crews as $crew) : ?>
        <tr id="crew_<?php echo $crew->getId(); ?>">
            <td><span class="span_checkbox"><input type="checkbox" class="crew_check" data-crew-id="<?php echo $crew->getId(); ?>" ></span></td>
            <td style="text-align: center" width="10%">
                <a class="handle">
                    <i class="fa fa-fw fa-sort"></i>
                </a>
            </td>
            <td><?php echo $crew->getName() ?></td>
            <td width="20%">
                <?php if ($crew->getCompanyId()) : ?>
                    <a href="javascript:void(0);" class="btn tiptip editCrew" title="Edit Crew Name"
                       data-crew-id="<?php echo $crew->getId(); ?>"
                       data-crew-name="<?php echo $crew->getName(); ?>"
                       data-crew-unit-id="<?php echo $crew->getUnitId(); ?>"
                       data-crew-base-price="<?php echo $crew->getBasePrice(); ?>"
                       data-crew-pm-rate="<?php echo $crew->getProfitRate(); ?>"
                       data-crew-oh-rate="<?php echo $crew->getOverheadRate(); ?>"
                       data-crew-total-price="<?php echo $crew->getTotalPrice(); ?>">
                        <i class="fa fa-edit"></i>
                    </a>
                    <a href="<?php echo site_url('account/edit_estimating_crew/' . $crew->getId()); ?>"
                       class="btn tiptip" title="Manage Crew Items">
                        <i class="fa fa-list"></i>
                    </a>

                    <!--
                    <a href="javascript:void(0);" class="btn tiptip assignTemplate" title="Assign Crew to Services"
                       data-template-id="<?php echo $crew->getId(); ?>" data-template-name="<?php echo $crew->getName(); ?>">
                        <i class="fa fa-list-alt"></i>
                    </a>
                    -->
                    <a href="javascript:void(0);" class="btn tiptip deleteCrew" title="Delete Crew"
                       data-crew-id="<?php echo $crew->getId(); ?>">
                        <i class="fa fa-trash"></i>
                    </a>

                <?php endif; ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>

<div id="crewNameDialog" title="Save Crew Name">

    <div style="padding-top: 10px;">
        <form id="saveCrewForm" action="<?php echo site_url('account/saveEstimatingCrew') ?>" method="post">
            <input type="hidden" name="crewId" id="crewId">

            <div style="width: 380px; float: left">
    <div class="content-box" id="add-type">
        <div class="box-header">
            Crew Info
        </div>
        <div class="box-content">

                <table width="100%" cellspacing="0" cellpadding="0" class="boxed-table stripping-table">
                    <tbody>
                        <tr>
                            <td>
                                <p class="clearfix left">
                                    <label>Crew Name</label>
                                    <input type="text" value="" id="crewName" name="crewName" style="width: 180px;"
                                           class="text required" tabindex="2">
                                </p>
                            </td>
                        </tr>
                        
                        
                        <tr class="unitRow">
                            <td>
                                <p class="clearfix left">
                                    <label>Unit</label>
                                    <select name="unitId" id="unitId" required>
                                        <option value="">-- Select Unit</option>
                                       <option data-val="Hour" value="17">Hours (hrs)</option>
                                       <option data-val="Day" value="18">Days (days)</option>
                                                
                                    </select>
                                </p>
                            </td>
                        </tr>
                       
                    </tbody>
                </table>
        </div>
    </div>
</div>


<div style="width: 380px; float: right;">

    <div class="content-box" id="add-type">
        <div class="box-header">
            Pricing
        </div>
        <div class="box-content">

                <table width="100%" cellspacing="0" cellpadding="0" class="boxed-table stripping-table">
                    <tbody>
                    <tr>
                        <td>
                            <p class="clearfix left">
                                <label>Base Cost</label>
                                <input type="text" value="" id="crewBaseCost" name="crewBaseCost"
                                       class="text required currencyFormat" tabindex="2" style="width: 50px;"><span class="unit_type_text" style="position: relative;top: 6px;"></span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <p class="clearfix left">
                                <label>Overhead %</label>
                                <input type="text" value="" id="crewOverheadRate" name="crewOverheadRate"
                                       class="text required percentFormat" tabindex="2" style="width: 50px;">
                                <span class="crewOverheadPrice after_input2">$0.00</span>
                            </p>
                        </td>
                    </tr>

                    <tr>
                        <td>
                            <p class="clearfix left">
                                <label>Profit %</label>
                                <input type="text" value="" id="crewProfitRate" name="crewProfitRate"
                                       class="text required percentFormat" tabindex="2" style="width: 50px;">
                                <span class="crewProfitPrice after_input2">$0.00</span>
                            </p>
                        </td>
                    </tr>

                   
                    <tr>
                        <td>
                            <p class="clearfix left">
                                <label>Total Crew Price</label>
                                <input type="text" id="unitPrice" name="unitPrice" class="text currencyFormat"
                                       style="width: 50px;" readonly><span class="unit_type_text" style="position: relative;top: 6px;"></span>
                            </p>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>
        </form>
    </div>

</div>


<!-- Confirm delete dialog -->
<div id="delete-crews" title="Confirmation">
    <h3>Confirmation - Delete Crews</h3>

    <p>This will delete a total of <strong><span id="deleteNum"></span></strong> crews.</p>
    <br/>
    <p><strong>Crews used in existing estimates will be saved</strong></p>
    <br />
    <p>Proceed?</p>
</div>
<div id="delete-crews-status" title="Confirmation">
    <h3>Confirmation - Delete Crews</h3>

    <p id="deleteCrewsStatus"></p>
</div>
<script src='/static/js/inputmask.js'></script>
<script type="text/javascript">

// Update prices when typing
$("#crewBaseCost, #crewOverheadRate, #crewProfitRate").keyup(function() {
   
           updateItemPrices();
        });

function updateItemPrices() {

        var basePrice = cleanNumber($("#crewBaseCost").val());
        var overheadRate = cleanNumber($("#crewOverheadRate").val());
        var profitRate = cleanNumber($("#crewProfitRate").val());
       
        if(!overheadRate){
            $("#itemOverheadRate").val(0);
            overheadRate=0;
        }
        if(!profitRate){
            $("#itemProfitRate").val(0);
            profitRate=0;
        }
        
        var overheadPrice = ((basePrice * overheadRate) / 100);
        var profitPrice = ((basePrice * profitRate) / 100);
        var totalPrice = parseFloat(basePrice) + parseFloat(overheadPrice) + parseFloat(profitPrice);

       

        $(".crewOverheadPrice").text('$'+overheadPrice.toFixed(2));
        $(".crewProfitPrice").text('$'+profitPrice.toFixed(2));
        $("#unitPrice").val(totalPrice.toFixed(2));
}

function cleanNumber(numberString) {
        var number = numberString.replace('$', '');
        number = number.replace(/,/g, '');
        number = number.replace("%", '');
        return number;
    }

    $(document).ready(function() {

        // Instantiate Dialogs
        $("#crewNameDialog").dialog({
            width: 800,
            autoOpen: false,
            modal: true,
            buttons: {
                "Cancel": {
                    html: '<i class="fa fa-fw fa-close"></i> Cancel',
                    'class': 'btn left',
                    click: function () {
                        $(this).dialog('close');
                    }
                },
                "Save": {
                    html: '<i class="fa fa-fw fa-save"></i> Save Crew',
                    'class': 'btn blue-button',
                    click: function () {
                        console.log(!cleanNumber($("#crewBaseCost").val())>0);

                        if (!$("#crewName").val()) {
                            swal('Please enter a crew name!');
                            return false;
                        }else if (!$("#unitId").val()) {
                            swal('Please Select a unit !');
                            return false;
                        }else if (cleanNumber($("#crewBaseCost").val())==0) {
                            swal('Please enter Base Cost');
                            return false;
                        } else {
                            $("#saveCrewForm").submit();
                        }

                    }
                }
            }
        });

// Input Masks
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
        // Click to add new template
        $("#addEstCrew").click(function() {
            // Clear the inputs
            $("#crewId").val('');
            $("#crewName").val('');
            $("#unitId").val('');
            $("#crewProfitRate").val(0);
            $("#crewOverheadRate").val(0);
            $("#crewBaseCost").val(0);
            $("#unitPrice").val(0);
            updateItemPrices();
            // SHow the dialog
            $("#crewNameDialog").dialog('open');
            $.uniform.update()
            return false;
        });

        // Click to add new template
        $(".editCrew").click(function() {
            // Clear the inputs
            $("#crewId").val($(this).data('crew-id'));
            $("#crewName").val($(this).data('crew-name'));
            $("#unitId").val($(this).data('crew-unit-id'));
            $("#crewProfitRate").val($(this).data('crew-pm-rate'));
            $("#crewOverheadRate").val($(this).data('crew-oh-rate'));
            $("#crewBaseCost").val($(this).data('crew-base-price'));
            $("#unitPrice").val($(this).data('crew-total-price'));
            updateItemPrices();
            // SHow the dialog
            $("#crewNameDialog").dialog('open');
            $.uniform.update()
            return false;
        });

        // Delete button
        $(".deleteCrew").click(function() {

            var crewId = $(this).data('crew-id');

            swal({
                html: 'Are you sure you want to delete this crew?',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText:
                    '<i class="fa fa-fw fa-trash"></i> Delete Crew',
                cancelButtonText:
                    '<i class="fa fa-fw fa-close"></i> Cancel'
            }).then(
                function() {
                    window.location.href = '<?php echo site_url('account/deleteEstimatingCrew'); ?>/' + crewId;
                }, function (dismiss) {

                }
            );

            return false;
        });

        // Sortable templates
        $("#estimationCrews tbody").sortable({
            helper: fixHelper,
            handle:".handle",
            stop:function () {
                var postData = $(this).sortable("serialize");
                $.ajax({
                    type:"POST",
                    url:"<?php echo site_url('ajax/updateEstimationCrewOrder') ?>",
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


    //Group action functionality

    // Group Actions Button
    $(".groupAction").click(function () {

        // Toggle the buttons
        $(".groupActionsContainer").toggle();
        return false;
    });

    /* Create an array of the selected IDs */
    function getCrewsSelectedIds() {

        var IDs = new Array();

        $(".crew_check:checked").each(function () {
            IDs.push($(this).data('crew-id'));
        });

        return IDs;
    }

    /* Update the number of selected items */
    function updateNumSelected() {
        var num = $(".crew_check:checked").length;

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
    $(".crew_check").live('change', function () {

        updateNumSelected();
    });


    // All
    $(".check_all").live('click', function () {
        if($(this).prop("checked")===true){
            $(this).closest('table').find(".crew_check").prop('checked', true);
        }else{
            $(this).closest('table').find(".crew_check").prop('checked', false);
        }

        updateNumSelected();
        $.uniform.update();
        //return false;
    });

    // Delete Click
    $('.groupDelete').click(function(){
        $("#delete-crews").dialog('open');
        $("#deleteNum").html($(".crew_check:checked").length);
    });

    // Item Delete Update
    $("#delete-crews-status").dialog({
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
    $("#delete-crews").dialog({
        width: 500,
        modal: true,
        buttons: {
            "Delete": {
                text: 'Delete Crews',
                'class': 'btn ui-button update-button',
                'id': 'confirmDelete',
                click: function () {

                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {'ids': getCrewsSelectedIds()},
                        url: "<?php echo site_url('ajax/crewGroupDelete'); ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"
                    })
                        .success(function (data) {

                            if (data.success) {
                                var deleteText = data.count + ' Crews were deleted';
                            }
                            else {
                                var deleteText = 'An error occurred. Please try again';
                            }
                            var itemIds = getCrewsSelectedIds();
                            for($i=0;$i<itemIds.length;$i++){

                                $("tr#crew_" + itemIds[$i]).remove();
                                updateNumSelected();
                                //    var table = $(row).closest('table');
                                //    table.DataTable().row(row).remove().draw();
                                //var categoryId = table.data('category-id');
                                //$('.type_count[data-category-id="' + categoryId+'"]').text(table.DataTable().rows().count());


                            }
                            $("#deleteCrewsStatus").html(deleteText);
                            $("#delete-crews-status").dialog('open');
                        });

                    $(this).dialog('close');
                    $("#deleteCrewsStatus").html('Deleting Crews...<img src="/static/loading.gif" />');
                    $("#delete-crews-status").dialog('open');
                }
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });
    // Template Delete Update
    $("#delete-crews-status").dialog({
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
</script>