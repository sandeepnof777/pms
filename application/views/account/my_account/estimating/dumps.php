<style type="text/css">

    .pac-container {
        width: 300px !important;
    }
    .formTable td label.error{
    margin-top:4px;
}
</style>
<h3>Estimation Dumps</h3>
<div class="materialize">
<a href="#" class="m-btn " id="addDump" style="position: absolute;right:12px;margin-top: -37px;">
            <i class="fa fa-fw fa-plus"></i>
            Add Dump
        </a>
        <!-- <a href="<?php echo site_url('account/my_account/proposal_settings') ?>" class="m-btn " id="addDump" style="position: absolute;right:2px;margin-top: -37px;">
             Back
        </a> -->
</div>
<p class="adminInfoMessage"><i class="fa fa-fw fa-info-circle"></i>These are your Estimation Dumps. You can add, edit, delete and reorder.</p>

<!---Start Filter button---->
<div class="materialize" style="min-height: 30px !important;top: 4px;float:right;margin-right: 10px;margin-bottom: 10px;white-space: nowrap;">
        <div class="m-btn groupAction tiptip"  style="position: relative;display:none;font-size: 14px;" title="Carry out actions on selected Dumps" >
            <i class="fa fa-fw fa-check-square-o"></i> Group Actions
            <div class="groupActionsContainer materialize" style="width:160px">
                <div class="collection groupActionItems" >
                    
                    <a href="javascript:void(0);" class="groupDelete collection-item iconLink" style="width: 100%;color:#000;padding: 4px;float: left;font-weight:normal">
                        <i class="fa fa-fw fa-trash"></i> Delete Dumps
                    </a>
                    
                </div>
            </div>
        </div>
        
        <div class="clearfix"></div>
</div>
<!---End Filter button---->

<table id="estimatingDumpsTable" class="defaultTable">
    <thead>
        <tr>
        <th width="5%"><span class="span_checkbox_th2px"><input type="checkbox" class="check_all"></span></th>
            <th><i class="fa fa-fw fa-sort"></i> </th>
            <th>Company Name</th>
            <th>Name</th>
            <th>City</th>
            <th>State</th>
            <th>Zip</th>
            <th>Fee</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($dumps as $dump) : ?>
    <?php /* @var $dump \models\EstimationDump */ ?>
        <tr id="dumps_<?php echo $dump->getId(); ?>"
            data-dump-id="<?php echo $dump->getId() ?>"
            data-company-name="<?php echo $dump->getCompanyName() ?>"
            data-name="<?php echo $dump->getName() ?>"
            data-address="<?php echo $dump->getAddress() ?>"
            data-city="<?php echo $dump->getCity() ?>"
            data-state="<?php echo $dump->getState() ?>"
            data-zip="<?php echo $dump->getZip() ?>"
            data-lat="<?php echo $dump->getLat() ?>"
            data-lng="<?php echo $dump->getLng() ?>"
            data-dump-as-plant="<?php echo $dump->getPlant() ?>"
            data-price-rate="<?php echo $dump->getPriceRate() ?>"
            data-phone="<?php echo $dump->getPhone() ?>">
            <td><span class="span_checkbox"><input type="checkbox" class="dump_check" data-dump-id="<?php echo $dump->getId(); ?>" ></span></td>
            <td class="center">
                <a class="handle"><i class="fa fa-fw fa-sort"></i></a>
            </td>
            <td>
                <?php echo $dump->getCompanyName(); ?>
            </td>
            <td>
                <?php echo $dump->getName(); ?>
            </td>
            <td>
                <?php echo $dump->getCity(); ?>
            </td>
            <td>
                <?php echo $dump->getState(); ?>
            </td>
            <td>
                <?php echo $dump->getZip(); ?>
            </td>
            <td>
                <?php echo '$'.number_format($dump->getPriceRate(),2); ?>
            </td>
            <td>
                <a class="btn editdump tiptip" href="#" title="Edit Dump">
                    <i class="fa fa-fw fa-edit"></i>
                </a>
                <a class="btn deleteDump tiptip" href="#" title="Delete Dump" data-dump-id="<?php echo $dump->getId(); ?>">
                    <i class="fa fa-fw fa-trash"></i>
                </a>
                <?php if(count($branches)>0){?>
                    <a class="btn assignBraches tiptip" href="javascript:void(0);" title="Assign Branch" data-dump-name="<?php echo $dump->getName(); ?>" data-dump-id="<?php echo $dump->getId(); ?>">
                        <i class="fa fa-fw fa-list-alt"></i>
                    </a>
                <?php } ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<div id="dumpFormDialog" title="Dump Details">
    <form action="<?php echo site_url('account/saveEstimationDump') ?>" class="form-validated"
          method="post" id="estimationDumpForm">
    <input type="hidden" name="dumpId" id="dumpId" />
    <table class="formTable boxed-table-error">
        <tr>
            <td>
                <label>Company Name:</label>
            </td>
            <td>
                <input type="text" class="text required" name="dumpCompanyName" id="dumpCompanyName" />
            </td>
        </tr>
        <tr>
            <td>
                <label>Dump Name:</label>
            </td>
            <td>
                <input type="text" class="text required" name="dumpName" id="dumpName" />
            </td>
        </tr>
        <tr>
            <td>
                <label>Address:</label>
            </td>
            <td>
                <input type="text" class="text required" name="dumpAddress" id="dumpAddress"
                    placeholder="Type Dump address"/>
            </td>
        </tr>
        <tr>
            <td>
                <label>City:</label>
            </td>
            <td>
                <input type="text" class="text required" name="dumpCity" id="dumpCity" />
            </td>
        </tr>
        <tr>
            <td>
                <label>State:</label>
            </td>
            <td>
                <input type="text" class="text required" name="dumpState" id="dumpState" />
            </td>
        </tr>
        <tr>
            <td>
                <label>Zip:</label>
            </td>
            <td>
                <input type="text" class="text required" name="dumpZip" id="dumpZip" />
            </td>
        </tr>
        <tr>
            <td>
                <label>Phone:</label>
            </td>
            <td>
                <input type="text" class="text" name="dumpPhone" id="dumpPhone" />
            </td>
        </tr>
        <tr>
            <td>
                <label>Dump Fee:</label>
            </td>
            <td>
                <input type="text" class="text currencyFormat" name="priceRate" id="priceRate" style="width:60px" /> Per Ton
            </td>
        </tr>
        <tr>
            <td>
                <label>Also a Plant:</label>
            </td>
            <td>
                <input type="checkbox" name="dumpAsPlant" id="dumpAsPlant" value="yes">
            </td>
        </tr>
    </table>
        <input type="hidden" name="lat" id="lat" />
        <input type="hidden" name="lng" id="lng" />
    </form>
</div>
<!-- Confirm delete dialog -->
<div id="delete-Dumps" title="Confirmation">
    <h3>Confirmation - Delete Dumps</h3>

    <p>This will delete a total of <strong><span id="deleteNum"></span></strong> dumps.</p>
    <br/>
    <p><strong>Dumps used in existing estimates will be saved</strong></p>
    <br />
    <p>Proceed?</p>
</div>
<div id="delete-dumps-status" title="Confirmation">
    <h3>Confirmation - Delete Dumps</h3>

    <p id="deleteDumpsStatus"></p>
</div>

<div id="dumpDialog" title="Assign Dump to Branches">

    <h3>Assign Dump to Branches: <span id="assignDumpName"></span></h3>
    <p style="font-size: 14px;margin-bottom: 10px;border-radius: 2px;padding: 5px 5px 5px 10px;background-color: #e8e3e3;"><i class="fa fa-info-circle"></i> &nbsp;Choose which braches you want this Dump to be available for</p>
    <div class="clearfix"></div>

    <div id="assignLoading" style="display: none; text-align: center;">
        <img src="/static/loading_animation.gif" />
    </div>

    <a href="#" id="checkAll">All</a> / <a href="#" id="checkNone">None</a>
    <div class="clearfix"></div>

    <input type="hidden" id="assignDumpId">
    <div class="branchTypeCheckContainer">
            <label>
                <input type="checkbox" class="branchCheck" data-branch-id="0"
                       value="0" />
                <span style="position: relative; top: 3px;">Main Branch</span>
            </label>

        </div>
    <?php foreach ($branches as $branch) : ?>
        <div class="branchTypeCheckContainer">
            <label>
                <input type="checkbox" class="branchCheck" data-branch-id="<?php echo $branch->getBranchId() ?>"
                       value="<?php echo $branch->getBranchId() ?>" />
                <span style="position: relative; top: 3px;"><?php echo $branch->getBranchName(); ?></span>
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
<script src='/static/js/inputmask.js'></script>
<script type="text/javascript">
    
    $(document).ready(function() {
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
        // Dialogs
        $("#dumpFormDialog").dialog({
            modal: true,
            autoOpen: false,
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
                    html: '<i class="fa fa-fw fa-save"></i> Save Dump',
                    'class': 'btn blue-button',
                    click: function () {
                        // Validate and submit
                        $("#estimationDumpForm").submit();
                    }
                }
            }
        });

        // Sortable categories
        $("#estimatingDumpsTable tbody").sortable({
            helper: fixHelper,
            handle:".handle",
            stop:function () {
                var postData = $(this).sortable("serialize");
                $.ajax({
                    type:"POST",
                    url:"<?php echo site_url('ajax/updateEstimationDumpsOrder') ?>",
                    data:postData,
                    async:false
                });
            }
        });

        // INput masking
        $("#dumpPhone").mask("999-999-9999");

        // Add dump click
        $("#addDump").click(function() {
            // Reset all inputs
            $("#estimationDumpForm input").val('');
            // Remove any errors
            $("#estimationDumpForm input").removeClass('error');
            // Assign value to use as plant checkbox
            $('#dumpAsPlant').val(1);
            // Show the dialog
            $("#dumpFormDialog").dialog('open');
            return false;
        });

        // Edit dump click
        $(".editdump").click(function() {

            var parentRow = $(this).parents('tr');
            console.log(parentRow);
            // PopulateInputs
            $("#dumpId").val($(parentRow).data('dump-id'));
            $("#dumpCompanyName").val($(parentRow).data('company-name'));
            $("#dumpName").val($(parentRow).data('name'));
            $("#dumpAddress").val($(parentRow).data('address'));
            $("#dumpCity").val($(parentRow).data('city'));
            $("#dumpState").val($(parentRow).data('state'));
            $("#dumpZip").val($(parentRow).data('zip'));
            $("#dumpPhone").val($(parentRow).data('phone'));
            $("#lat").val($(parentRow).data('lat'));
            $("#lng").val($(parentRow).data('lng'));
            $("#priceRate").val($(parentRow).data('price-rate'));

            //Handle Use as Plant condtion
            if($(parentRow).data('dump-as-plant') == 1)
            {
                $("#dumpAsPlant").prop('checked', true);
                $.uniform.update();
            } else {
                $("#dumpAsPlant").prop('checked', false);
                $.uniform.update();
            }

            // Show the dialog
            $("#dumpFormDialog").dialog('open');
            return false;
        });
        
        // Init the autocomplete
        initAutocomplete();

        $(".deleteDump").click(function() {

            var dumpId = $(this).data('dump-id');

            swal({
                title: 'Delete Dump',
                html: '<p>Are you sure you want to delete this dump?</p>',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText:
                    '<i class="fa fa-fw fa-trash"></i> Delete Dump',
                cancelButtonText:
                    '<i class="fa fa-fw fa-close"></i> Cancel'
            }).then(
                function() {
                    window.location.href = '<?php echo site_url('account/deleteEstimatingDump'); ?>/' + dumpId;
                }, function (dismiss) {}
            );
            return false;
        });

        // End document ready
    });

    // Google Maps Autocomplete
    function initAutocomplete() {
        // Create the autocomplete object, restricting the search to geographical
        // location types.
        autocomplete = new google.maps.places.Autocomplete(
            /** @type {!HTMLInputElement} */(document.getElementById('dumpAddress')),
            {});

        google.maps.event.addListener(autocomplete, 'place_changed', function() {
            var place = autocomplete.getPlace();
            console.log(place);

            placeParser = function(place){
                result = {};
                for(var i = 0; i < place.address_components.length; i++){
                    ac = place.address_components[i];
                    result[ac.types[0]] = ac.long_name;

                    if (ac.types[0] == 'administrative_area_level_1') {
                        result.stateCode = ac.short_name;
                    }

                    if (ac.types[0] == 'administrative_area_level_2') {
                        result.stateCode = ac.short_name;
                    }
                }
                return result;
            };

            var parsedPlace = placeParser(place);
            var address = place.formatted_address;
            var value = address.split(",");

            var addr = value[0];
            var state = parsedPlace.stateCode;
            var town = parsedPlace.postal_town;
            var city = parsedPlace.locality;
            var zip = parsedPlace.postal_code;

            if (!city) {
                city = town;
            }

            $("#dumpAddress").val(addr.trim());
            $("#dumpCity").val(city.trim());
            $("#dumpState").val(state.trim());
            $("#dumpZip").val(zip.trim());

            // Lat and Lng
            $("#lat").val(place.geometry.location.lat());
            $("#lng").val(place.geometry.location.lng());
        });
    }
    
    // Return a helper with preserved width of cells
    var fixHelper = function(e, ui) {
        ui.children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    };


//Group action functionality

        // Group Actions Button
        $(".groupAction").click(function () {
        
        // Toggle the buttons
        $(".groupActionsContainer").toggle();
        return false;
    });

    /* Create an array of the selected IDs */
    function getDumpsSelectedIds() {

        var IDs = new Array();

        $(".dump_check:checked").each(function () {
            IDs.push($(this).data('dump-id'));
        });

        return IDs;
    }

/* Update the number of selected items */
function updateNumSelected() {
            var num = $(".dump_check:checked").length;

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
     $(".dump_check").live('change', function () {
       
            updateNumSelected();
        });

        
        // All
        $(".check_all").live('click', function () {
            if($(this).prop("checked")===true){
                $(this).closest('table').find(".dump_check").prop('checked', true);
            }else{
                $(this).closest('table').find(".dump_check").prop('checked', false);
            }
            
            updateNumSelected();
            $.uniform.update();
            //return false;
        });
    
    // Delete Click
    $('.groupDelete').click(function(){
            $("#delete-Dumps").dialog('open');
            $("#deleteNum").html($(".dump_check:checked").length);
    });

    // Item Delete Update
    $("#delete-Dumps-status").dialog({
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
        $("#delete-Dumps").dialog({
            width: 500,
            modal: true,
            buttons: {
                "Delete": {
                    text: 'Delete Dumps',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmDelete',
                    click: function () {
                        
                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {'ids': getDumpsSelectedIds()},
                            url: "<?php echo site_url('ajax/dumpsGroupDelete'); ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {

                                if (data.success) {
                                    var deleteText = data.count + ' Dumps were deleted';
                                }
                                else {
                                    var deleteText = 'An error occurred. Please try again';
                                }
                                var itemIds = getDumpsSelectedIds();
                                for($i=0;$i<itemIds.length;$i++){
                                    
                                    $("tr#dumps_" + itemIds[$i]).remove();
                                    updateNumSelected();
                                //    var table = $(row).closest('table');
                                //    table.DataTable().row(row).remove().draw();
                                   //var categoryId = table.data('category-id');
                                   //$('.type_count[data-category-id="' + categoryId+'"]').text(table.DataTable().rows().count());
                                  

                                }
                                $("#deleteDumpsStatus").html(deleteText);
                                $("#delete-dumps-status").dialog('open');
                            });

                        $(this).dialog('close');
                        $("#deleteDumpsStatus").html('Deleting Dumps...<img src="/static/loading.gif" />');
                        $("#delete-dumps-status").dialog('open');
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });
    // Dumps Delete Update
    $("#delete-dumps-status").dialog({
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


/////////////////////////////////////////


// Dump Dialog
$("#dumpDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 650
        });

        // Open Service Dialog
        $(".assignBraches").click(function() {

            // SHow the loader
            $("#assignLoading").show();

            // Grab the vars
            var dumpId = $(this).data('dump-id');
            var dumpName = $(this).data('dump-name');

            // Clear all checkboxes
            $(".branchCheck").prop('checked', false);

            // Load the title and form
            $("#assignDumpId").val(dumpId);
            $("#assignDumpName").text(dumpName);

            // Grab the assigned services for this type
            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: {
                    'plantId' : dumpId
                },
                url: "<?php echo site_url('ajax/getCompanyBranchPlants'); ?>",
                dataType: "JSON"
            })
            .success(function (data) {
                if (!data.error) {

                    $.each(data.branches, function(idx, val) {
                        $('.branchCheck[data-branch-id="' + val + '"]').prop('checked', true);
                    });

                    $.uniform.update();

                } else {
                    swal(data.message);
                    console.log(data.debug);
                }

                $("#assignLoading").hide();
            });
            
            // Open the dialog
            $("#dumpDialog").dialog('open');
            return false;
        });

        $("#cancelAssign").click(function() {
            $("#dumpDialog").dialog('close');
            return false;
        });
        

        $("#saveAssignments").click(function() {

            var dumpId = $("#assignDumpId").val();

            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: {
                    'plantId' : dumpId,
                    'branchIds': getSelectedIds()
                },
                url: "<?php echo site_url('ajax/companyPlantBranchAssign'); ?>",
                dataType: "JSON"
            })
            .success(function (data) {
                if (!data.error) {
                    $("#dumpDialog").dialog('close');
                    swal('Assignments Saved');
                } else {
                    $("#dumpDialog").dialog('close');
                    swal(data.message);
                    console.log(data.debug);
                }
            });

            return false;
        });
    // Check All
    $("#checkAll").click(function() {
            $(".branchCheck").prop('checked', true);
            $.uniform.update();
            return false;
        });

        // Check All
        $("#checkNone").click(function() {
            $(".branchCheck").prop('checked', false);
            $.uniform.update();
            return false;
        });
        $("#cancelAssign").click(function() {
            $("#dumpDialog").dialog('close');
            return false;
        });

 /* Create an array of the selected IDs */
 function getSelectedIds() {

var IDs = new Array();

$(".branchCheck:checked").each(function () {
    IDs.push($(this).data('branch-id'));
});

return IDs;
}   
</script> 