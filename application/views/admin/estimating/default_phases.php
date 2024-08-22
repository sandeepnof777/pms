<?php $this->load->view('global/header-admin'); ?>
<style type="text/css">

ul#categoryList, ul#serviceList {
    width: 100%;
    margin-right: 20px;
}

ul#categoryList li, ul#serviceList li {
    width: 100%;
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

ul#categoryList li a:hover, ul#serviceList a:hover {
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
    margin-top: 48px;
}

.phaseControlButton {
    float: right;
    margin-top: -7px;
    margin-right: 5px;
}

</style>
<div id="content" class="clearfix">
    <div class="widthfix">

        <div style="width: 220px; float: left; margin-right: 20px;">

            <h3>Select Category</h3>

            <ul id="categoryList">
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

            <h3>Select Service</h3>

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

        <div style="width: 350px; float: left;">

            <h3>Default Phases</h3>

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

        <div style="width: 120px; float: left;">
            <a href="#" id="addPhase" class="btn blue-button">
                <i class="fa fa-fw fa-plus-circle"></i> Add Phase
            </a>
        </div>
    </div>
</div>

<div id="phaseDialog" title="Phase details">
    <input type="hidden" id="phaseId" value="" />
    <label>Phase Name:</label>
    <input type="text" class="text" id="phaseName" />
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
                            url:"<?php echo site_url('admin/saveEstimateDefaultPhase') ?>",
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
            // Clear previous selection. Also remove service highlighting
            $(".categoryListItem").removeClass('selectedCategory');
            $(".selectedService").removeClass('selectedService');
            // Make sure all are closed
            $(".serviceListItem").hide();
            // Show the selected category phases
            $(".serviceListItemLink[data-category-id='" + categoryId + "']").parents('li').show();
            // Highlight this category
            $(this).addClass('selectedCategory');
            // Hide the default phases as no service selected
            $(".categoryDefaultPhases").hide();
            // Hide the add button
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
                    url:"<?php echo site_url('admin/updateEstimationDefaultPhasesOrder') ?>/" + serviceId,
                    data: postData
                });
            }
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
                        url:"<?php echo site_url('admin/deleteDefaultEstimationPhase') ?>/" + deletePhaseId
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

</script>


<?php $this->load->view('global/footer'); ?>