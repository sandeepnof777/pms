<style type="text/css">

    .pac-container {
        width: 300px !important;
    }
    .formTable td label.error{
        margin-top:4px;
    }
</style>
<h3>Estimation Plants</h3>
<div class="materialize">
    <!-- <a href="<?php echo site_url('account/my_account/proposal_settings') ?>" class="m-btn "   style="position: absolute;right:10px;margin-top: -37px;">
             Back
        </a> -->
<a href="#" class="m-btn " id="addPlant" style="position: absolute;right:12px;margin-top: -37px;">
        <i class="fa fa-fw fa-plus"></i>
        Add Plant
    </a>
</div>
<p class="adminInfoMessage"><i class="fa fa-fw fa-info-circle"></i>These are your Estimation Plants. You can add, edit, delete and reorder.</p>

<!---Start Filter button---->
<div class="materialize" style="min-height: 30px !important;top: 4px;float:right;margin-right: 10px;margin-bottom: 10px;white-space: nowrap;">
        <div class="m-btn groupAction tiptip"  style="position: relative;display:none;font-size: 14px;" title="Carry out actions on selected Plants" >
            <i class="fa fa-fw fa-check-square-o"></i> Group Actions
            <div class="groupActionsContainer materialize" style="width:160px">
                <div class="collection groupActionItems" >
                    
                    <a href="javascript:void(0);" class="groupDelete collection-item iconLink" style="width: 100%;color:#000;padding: 4px;float: left;font-weight:normal">
                        <i class="fa fa-fw fa-trash"></i> Delete Plants
                    </a>
                    
                </div>
            </div>
        </div>
        
        <div class="clearfix"></div>
</div>
<!---End Filter button---->

<table id="estimatingPlantsTable" class="defaultTable ">
    <thead>
        <tr>
        <th width="5%"><input type="checkbox" class="check_all"></th>
            <th><i class="fa fa-fw fa-sort"></i> </th>
            <th>Company Name</th>
            <th>Name</th>
            <th>City</th>
            <th>State</th>
            <th>Zip</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach ($plants as $plant) : ?>
    <?php /* @var $plant \models\EstimationPlant */ ?>
    
        <tr id="plants_<?php echo $plant->getId(); ?>"
            data-plant-id="<?php echo $plant->getId() ?>"
            data-company-name="<?php echo $plant->getCompanyName() ?>"
            data-name="<?php echo $plant->getName() ?>"
            data-address="<?php echo $plant->getAddress() ?>"
            data-city="<?php echo $plant->getCity() ?>"
            data-state="<?php echo $plant->getState() ?>"
            data-zip="<?php echo $plant->getZip() ?>"
            data-lat="<?php echo $plant->getLat() ?>"
            data-lng="<?php echo $plant->getLng() ?>"
            data-plant-as-dump="<?php echo $plant->getDump() ?>"
            data-phone="<?php echo $plant->getPhone() ?>">
            <td><span class="span_checkbox"><input type="checkbox" class="plant_check" data-plant-id="<?php echo $plant->getId(); ?>" ></span></td>
            <td class="center">
                <a class="handle"><i class="fa fa-fw fa-sort"></i></a>
            </td>
            <td>
                <?php echo $plant->getCompanyName(); ?>
            </td>
            <td>
                <?php echo $plant->getName(); ?>
            </td>
            <td>
                <?php echo $plant->getCity(); ?>
            </td>
            <td>
                <?php echo $plant->getState(); ?>
            </td>
            <td>
                <?php echo $plant->getZip(); ?>
            </td>
            <td>
                <a class="btn editPlant tiptip" href="javascript:void(0);" title="Edit Plant">
                    <i class="fa fa-fw fa-edit"></i>
                </a>
                <a class="btn deletePlant tiptip" href="javascript:void(0);" title="Delete Plant" data-plant-id="<?php echo $plant->getId(); ?>">
                    <i class="fa fa-fw fa-trash"></i>
                </a>
                <?php if(count($branches)>0){?>
                    <a class="btn assignBraches tiptip" href="javascript:void(0);" title="Assign Branch" data-plant-name="<?php echo $plant->getName(); ?>" data-plant-id="<?php echo $plant->getId(); ?>">
                        <i class="fa fa-fw fa-list-alt"></i>
                    </a>
                <?php } ?>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<div id="plantFormDialog" title="Plant Details">
    <form action="<?php echo site_url('account/saveEstimationPlant') ?>" class="form-validated"
          method="post" id="estimationPlantForm">
    <input type="hidden" name="plantId" id="plantId" />
    <table class="formTable boxed-table-error">
        <tr>
            <td>
                <label>Company Name:</label>
            </td>
            <td>
                <input type="text" class="text required" name="plantCompanyName" id="plantCompanyName" />
            </td>
        </tr>
        <tr>
            <td>
                <label>Plant Name:</label>
            </td>
            <td>
                <input type="text" class="text required" name="plantName" id="plantName" />
            </td>
        </tr>
        <tr>
            <td>
                <label>Address:</label>
            </td>
            <td>
                <input type="text" class="text required" name="plantAddress" id="plantAddress"
                    placeholder="Type Plant address"/>
            </td>
        </tr>
        <tr>
            <td>
                <label>City:</label>
            </td>
            <td>
                <input type="text" class="text required" name="plantCity" id="plantCity" />
            </td>
        </tr>
        <tr>
            <td>
                <label>State:</label>
            </td>
            <td>
                <input type="text" class="text required" name="plantState" id="plantState" />
            </td>
        </tr>
        <tr>
            <td>
                <label>Zip:</label>
            </td>
            <td>
                <input type="text" class="text required" name="plantZip" id="plantZip" />
            </td>
        </tr>
        <tr>
            <td>
                <label>Phone:</label>
            </td>
            <td>
                <input type="text" class="text" name="plantPhone" id="plantPhone" />
            </td>
        </tr>
        <tr>
                <td>
                    <label>Also a Dump:</label>
                </td>
                <td>
                    <input type="checkbox" name="plantAsDump" id="plantAsDump" value="1">
                </td>
            </tr>

    </table>
        <input type="hidden" name="lat" id="lat" />
        <input type="hidden" name="lng" id="lng" />
    </form>
</div>

<!-- Confirm delete dialog -->
<div id="delete-Plants" title="Confirmation">
    <h3>Confirmation - Delete Plants</h3>

    <p>This will delete a total of <strong><span id="deleteNum"></span></strong> plants.</p>
    <br/>
    <p><strong>Plants used in existing estimates will be saved</strong></p>
    <br />
    <p>Proceed?</p>
</div>
<div id="delete-plants-status" title="Confirmation">
    <h3>Confirmation - Delete Plants</h3>

    <p id="deletePlantsStatus"></p>
</div>



<div id="plantDialog" title="Assign Plant to Branches">

    <h3>Assign Plant to Branches: <span id="assignPlantName"></span></h3>
    <p style="font-size: 14px;margin-bottom: 10px;border-radius: 2px;padding: 5px 5px 5px 10px;background-color: #e8e3e3;"><i class="fa fa-info-circle"></i> &nbsp;Choose which braches you want this Plant to be available for</p>
    <div class="clearfix"></div>

    <div id="assignLoading" style="display: none; text-align: center;">
        <img src="/static/loading_animation.gif" />
    </div>

    <a href="#" id="checkAll">All</a> / <a href="#" id="checkNone">None</a>
    <div class="clearfix"></div>

    <input type="hidden" id="assignPlantId">
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
<script type="text/javascript">
    
    $(document).ready(function() {

        // Dialogs
        $("#plantFormDialog").dialog({
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
                    html: '<i class="fa fa-fw fa-save"></i> Save Plant',
                    'class': 'btn blue-button',
                    click: function () {
                        // Validate and submit
                        $("#estimationPlantForm").submit();
                    }
                }
            }
        });

        // Sortable categories
        $("#estimatingPlantsTable tbody").sortable({
            helper: fixHelper,
            handle:".handle",
            stop:function () {
                var postData = $(this).sortable("serialize");
                $.ajax({
                    type:"POST",
                    url:"<?php echo site_url('ajax/updateEstimationPlantsOrder') ?>",
                    data:postData,
                    async:false
                });
            }
        });

        // INput masking
        $("#plantPhone").mask("999-999-9999");

        // Add plant click
        $("#addPlant").click(function() {
            // Reset all inputs
            $("#estimationPlantForm input").val('');
            //set Input Checkbox as 1 again
            $("#plantAsDump").val(1);
            // Remove any errors
            $("#estimationPlantForm input").removeClass('error');
            // Show the dialog
            $("#plantFormDialog").dialog('open');
            return false;
        });

        // Edit plant click
        $(".editPlant").click(function() {

            var parentRow = $(this).parents('tr');

            // PopulateInputs
            $("#plantId").val($(parentRow).data('plant-id'));
            $("#plantCompanyName").val($(parentRow).data('company-name'));
            $("#plantName").val($(parentRow).data('name'));
            $("#plantAddress").val($(parentRow).data('address'));
            $("#plantCity").val($(parentRow).data('city'));
            $("#plantState").val($(parentRow).data('state'));
            $("#plantZip").val($(parentRow).data('zip'));
            $("#plantPhone").val($(parentRow).data('phone'));
            $("#lat").val($(parentRow).data('lat'));
            $("#lng").val($(parentRow).data('lng'));

            //Handle Use as Dump checkbox condition
            if($(parentRow).data('plant-as-dump') == 1)
            {
                $("#plantAsDump").prop('checked', true);
                $.uniform.update();
            } else {
                $("#plantAsDump").prop('checked', false);
                $.uniform.update();
            }

            // Show the dialog
            $("#plantFormDialog").dialog('open');
            return false;
        });
        
        // Init the autocomplete
        initAutocomplete();

        $(".deletePlant").click(function() {

            var plantId = $(this).data('plant-id');

            swal({
                title: 'Delete Plant',
                html: '<p>Are you sure you want to delete this plant?</p>',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText:
                    '<i class="fa fa-fw fa-trash"></i> Delete Plant',
                cancelButtonText:
                    '<i class="fa fa-fw fa-close"></i> Cancel'
            }).then(
                function() {
                    window.location.href = '<?php echo site_url('account/deleteEstimatingPlant'); ?>/' + plantId;
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
            /** @type {!HTMLInputElement} */(document.getElementById('plantAddress')),
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

            $("#plantAddress").val(addr.trim());
            $("#plantCity").val(city.trim());
            $("#plantState").val(state.trim());
            $("#plantZip").val(zip.trim());

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
    function getPlantsSelectedIds() {

        var IDs = new Array();

        $(".plant_check:checked").each(function () {
            IDs.push($(this).data('plant-id'));
        });

        return IDs;
    }

/* Update the number of selected items */
function updateNumSelected() {
            var num = $(".plant_check:checked").length;

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
     $(".plant_check").live('change', function () {
       
            updateNumSelected();
        });

        
        // All
        $(".check_all").live('click', function () {
            if($(this).prop("checked")===true){
                $(this).closest('table').find(".plant_check").prop('checked', true);
            }else{
                $(this).closest('table').find(".plant_check").prop('checked', false);
            }
            
            updateNumSelected();
            $.uniform.update();
            //return false;
        });
    
    // Delete Click
    $('.groupDelete').click(function(){
            $("#delete-Plants").dialog('open');
            $("#deleteNum").html($(".plant_check:checked").length);
    });

    // Item Delete Update
    $("#delete-plants-status").dialog({
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
        $("#delete-Plants").dialog({
            width: 500,
            modal: true,
            buttons: {
                "Delete": {
                    text: 'Delete Plants',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmDelete',
                    click: function () {
                        
                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {'ids': getPlantsSelectedIds()},
                            url: "<?php echo site_url('ajax/plantsGroupDelete'); ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {

                                if (data.success) {
                                    var deleteText = data.count + ' Plants were deleted';
                                }
                                else {
                                    var deleteText = 'An error occurred. Please try again';
                                }
                                var itemIds = getPlantsSelectedIds();
                                for($i=0;$i<itemIds.length;$i++){
                                    
                                    $("tr#plants_" + itemIds[$i]).remove();
                                    updateNumSelected();
                                //    var table = $(row).closest('table');
                                //    table.DataTable().row(row).remove().draw();
                                   //var categoryId = table.data('category-id');
                                   //$('.type_count[data-category-id="' + categoryId+'"]').text(table.DataTable().rows().count());
                                  

                                }
                                $("#deletePlantsStatus").html(deleteText);
                                $("#delete-plants-status").dialog('open');
                            });

                        $(this).dialog('close');
                        $("#deletePlantsStatus").html('Deleting Plants...<img src="/static/loading.gif" />');
                        $("#delete-plants-status").dialog('open');
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });
    // Plants Delete Update
    $("#delete-plants-status").dialog({
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



// Plant Dialog
$("#plantDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 650
        });

        // Open Service Dialog
        $(".assignBraches").click(function() {

            // SHow the loader
            $("#assignLoading").show();

            // Grab the vars
            var plantId = $(this).data('plant-id');
            var plantName = $(this).data('plant-name');

            // Clear all checkboxes
            $(".branchCheck").prop('checked', false);

            // Load the title and form
            $("#assignPlantId").val(plantId);
            $("#assignPlantName").text(plantName);

            // Grab the assigned services for this type
            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: {
                    'plantId' : plantId
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
            $("#plantDialog").dialog('open');
            return false;
        });

        $("#cancelAssign").click(function() {
            $("#plantDialog").dialog('close');
            return false;
        });
        

        $("#saveAssignments").click(function() {

            var plantId = $("#assignPlantId").val();

            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: {
                    'plantId' : plantId,
                    'branchIds': getSelectedIds()
                },
                url: "<?php echo site_url('ajax/companyPlantBranchAssign'); ?>",
                dataType: "JSON"
            })
            .success(function (data) {
                if (!data.error) {
                    $("#plantDialog").dialog('close');
                    swal('Assignments Saved');
                } else {
                    $("#plantDialog").dialog('close');
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
            $("#plantDialog").dialog('close');
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