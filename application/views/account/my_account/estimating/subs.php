<style type="text/css">

    .pac-container {
        width: 300px !important;
    }

</style>
<h3>Estimation Sub Contractors</h3>
<div class="materialize">
<a href="#" class="m-btn" id="addSub" style="position: absolute;right:12px;margin-top: -37px;">
                <i class="fa fa-fw fa-plus"></i>
                Add Sub Contractor
            </a>

<!-- <a href="<?php echo site_url('account/my_account/proposal_settings') ?>" class="m-btn"  style="position: absolute;right:10px;margin-top: -37px;">
   Back
</a>  -->
</div>
<p class="adminInfoMessage"><i class="fa fa-fw fa-info-circle"></i>These are your Estimation Sub Contractors. You can add, edit, delete and reorder.</p>



    
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




<table id="estimatingSubsTable" class="defaultTable">
    <thead>
    <tr>
    <th width="5%"><span class="span_checkbox_th2px"><input type="checkbox" class="check_all"></span></th>
        <th><i class="fa fa-fw fa-sort"></i> </th>
        <th>Company Name</th>
        <th>City</th>
        <th>State</th>
        <th>Zip</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($subContractors as $sub) : ?>
        <?php /* @var $sub \models\EstimateSubContractor */ ?>
        <tr id="subs_<?php echo $sub->getId(); ?>"
            data-sub-id="<?php echo $sub->getId() ?>"
            data-company-name="<?php echo $sub->getCompanyName() ?>"
            data-address="<?php echo $sub->getAddress() ?>"
            data-city="<?php echo $sub->getCity() ?>"
            data-state="<?php echo $sub->getState() ?>"
            data-zip="<?php echo $sub->getZip() ?>"
            data-phone="<?php echo $sub->getPhone() ?>"
            data-website="<?php echo $sub->getWebsite() ?>">
            <td><span class="span_checkbox"><input type="checkbox" class="subs_check" data-sub-id="<?php echo $sub->getId(); ?>" ></span></td>
            <td class="center">
                <a class="handle"><i class="fa fa-fw fa-sort"></i></a>
            </td>
            <td>
                <?php echo $sub->getCompanyName(); ?>
            </td>
            <td>
                <?php echo $sub->getCity(); ?>
            </td>
            <td>
                <?php echo $sub->getState(); ?>
            </td>
            <td>
                <?php echo $sub->getZip(); ?>
            </td>
            <td>
                <a class="btn editSub tiptip" href="#" title="Edit Sub Contractor">
                    <i class="fa fa-fw fa-edit"></i>
                </a>
                <a class="btn deleteSub tiptip" href="#" title="Delete Sub Contractor" data-sub-id="<?php echo $sub->getId(); ?>">
                    <i class="fa fa-fw fa-trash"></i>
                </a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<div id="subFormDialog" title="Sub Contractor Details">
    <form action="<?php echo site_url('account/saveEstimationSub') ?>" class="form-validated"
          method="post" id="estimationSubForm">
        <input type="hidden" name="subId" id="subId" />
        <table class="formTable">
            <tr>
                <td>
                    <label>Company Name:</label>
                </td>
                <td>
                    <input type="text" class="text required" name="subCompanyName" id="subCompanyName" />
                </td>
            </tr>
            <tr>
                <td>
                    <label>Address:</label>
                </td>
                <td>
                    <input type="text" class="text required" name="subAddress" id="subAddress"
                           placeholder="Type Sub Contractor address"/>
                </td>
            </tr>
            <tr>
                <td>
                    <label>City:</label>
                </td>
                <td>
                    <input type="text" class="text required" name="subCity" id="subCity" />
                </td>
            </tr>
            <tr>
                <td>
                    <label>State:</label>
                </td>
                <td>
                    <input type="text" class="text required" name="subState" id="subState" />
                </td>
            </tr>
            <tr>
                <td>
                    <label>Zip:</label>
                </td>
                <td>
                    <input type="text" class="text required" name="subZip" id="subZip" />
                </td>
            </tr>
            <tr>
                <td>
                    <label>Phone:</label>
                </td>
                <td>
                    <input type="text" class="text required" name="subPhone" id="subPhone" />
                </td>
            </tr>
            <tr>
                <td>
                    <label>Website:</label>
                </td>
                <td>
                    <input type="text" class="text required" name="subWebsite" id="subWebsite" />
                </td>
            </tr>
        </table>
    </form>
</div>
<!-- Confirm delete dialog -->
<div id="delete-Subs" title="Confirmation">
    <h3>Confirmation - Delete Sub Contractors</h3>

    <p>This will delete a total of <strong><span id="deleteNum"></span></strong> Sub Contractors.</p>
    <br/>
    <p><strong>Sub Contractors used in existing estimates will be saved</strong></p>
    <br />
    <p>Proceed?</p>
</div>
<div id="delete-subs-status" title="Confirmation">
    <h3>Confirmation - Delete Sub Contractors</h3>

    <p id="deleteSubsStatus"></p>
</div>
<script type="text/javascript">

    $(document).ready(function() {

        // Dialogs
        $("#subFormDialog").dialog({
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
                    html: '<i class="fa fa-fw fa-save"></i> Save Sub Contractor',
                    'class': 'btn blue-button',
                    click: function () {
                        // Validate and submit
                        $("#estimationSubForm").submit();
                    }
                }
            }
        });

        // Sortable categories
        $("#estimatingSubsTable tbody").sortable({
            helper: fixHelper,
            handle:".handle",
            stop:function () {
                var postData = $(this).sortable("serialize");
                $.ajax({
                    type:"POST",
                    url:"<?php echo site_url('ajax/updateEstimationSubsOrder') ?>",
                    data:postData,
                    async:false
                });
            }
        });

        // Input masking
        $("#subPhone").mask("999-999-9999");

        // Add plant click
        $("#addSub").click(function() {
            // Reset all inputs
            $("#estimationSubForm input").val('');
            // Remove any errors
            $("#estimationSubForm input").removeClass('error');
            // Show the dialog
            $("#subFormDialog").dialog('open');
            return false;
        });

        // Edit plant click
        $(".editSub").click(function() {

            var parentRow = $(this).parents('tr');

            // PopulateInputs
            $("#subId").val($(parentRow).data('sub-id'));
            $("#subCompanyName").val($(parentRow).data('company-name'));
            $("#subAddress").val($(parentRow).data('address'));
            $("#subCity").val($(parentRow).data('city'));
            $("#subState").val($(parentRow).data('state'));
            $("#subZip").val($(parentRow).data('zip'));
            $("#subPhone").val($(parentRow).data('phone'));
            $("#subWebsite").val($(parentRow).data('website'));

            // Show the dialog
            $("#subFormDialog").dialog('open');
            return false;
        });

        // Init the autocomplete
        initAutocomplete();

        $(".deleteSub").click(function() {

            var subId = $(this).data('sub-id');

            swal({
                title: 'Delete Sub Contractor',
                html: '<p>Are you sure you want to delete this sub contraxctor?</p>',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText:
                    '<i class="fa fa-fw fa-trash"></i> Delete Sub Contractor',
                cancelButtonText:
                    '<i class="fa fa-fw fa-close"></i> Cancel'
            }).then(
                function() {
                    window.location.href = '<?php echo site_url('account/deleteEstimatingSub'); ?>/' + subId;
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
            /** @type {!HTMLInputElement} */(document.getElementById('subAddress')),
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

            $("#subAddress").val(addr.trim());
            $("#subCity").val(city.trim());
            $("#subState").val(state.trim());
            $("#subZip").val(zip.trim());

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
    function getSubsSelectedIds() {

        var IDs = new Array();

        $(".subs_check:checked").each(function () {
            IDs.push($(this).data('sub-id'));
        });

        return IDs;
    }

/* Update the number of selected items */
function updateNumSelected() {
            var num = $(".subs_check:checked").length;

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
     $(".subs_check").live('change', function () {
       
            updateNumSelected();
        });

        
        // All
        $(".check_all").live('click', function () {
            if($(this).prop("checked")===true){
                $(this).closest('table').find(".subs_check").prop('checked', true);
            }else{
                $(this).closest('table').find(".subs_check").prop('checked', false);
            }
            
            updateNumSelected();
            $.uniform.update();
            //return false;
        });
    
    // Delete Click
    $('.groupDelete').click(function(){
            $("#delete-Subs").dialog('open');
            $("#deleteNum").html($(".subs_check:checked").length);
    });

    // Item Delete Update
    $("#delete-Subs-status").dialog({
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
        $("#delete-Subs").dialog({
            width: 500,
            modal: true,
            buttons: {
                "Delete": {
                    text: 'Delete Subs',
                    'class': 'btn ui-button update-button',
                    'id': 'confirmDelete',
                    click: function () {
                        
                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {'ids': getSubsSelectedIds()},
                            url: "<?php echo site_url('ajax/subsGroupDelete'); ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {

                                if (data.success) {
                                    var deleteText = data.count + ' Subs were deleted';
                                }
                                else {
                                    var deleteText = 'An error occurred. Please try again';
                                }
                                var itemIds = getSubsSelectedIds();
                                for($i=0;$i<itemIds.length;$i++){
                                    
                                    $("tr#subs_" + itemIds[$i]).remove();
                                    updateNumSelected();
                                //    var table = $(row).closest('table');
                                //    table.DataTable().row(row).remove().draw();
                                   //var categoryId = table.data('category-id');
                                   //$('.type_count[data-category-id="' + categoryId+'"]').text(table.DataTable().rows().count());
                                  

                                }
                                $("#deleteSubsStatus").html(deleteText);
                                $("#delete-subs-status").dialog('open');
                            });

                        $(this).dialog('close');
                        $("#deleteSubsStatus").html('Deleting Subs...<img src="/static/loading.gif" />');
                        $("#delete-subs-status").dialog('open');
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });
    // Dumps Delete Update
    $("#delete-subs-status").dialog({
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