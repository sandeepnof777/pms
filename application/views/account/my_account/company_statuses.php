<div style="padding: 10px">
    <style>

        .colpick {
            z-index: 9999;
        }</style>
    <div class="content-box">

        <div class="box-header">Manage Statuses</div>

        <div class="box-content">

            <table width="100%" border="0" cellpadding="0" cellspacing="0" class="boxed-table" id="defaultStatuses">
                <thead>
                <tr>
                    <th width="50" style="height: 33px;">Order</th>
                    <th>Status</th>
                    <td>Won Status <a class="iconLink tiptip"
                                       title="A proposal is considered Won when changed to this status type"><i
                                    class="fa fa-fw fa-info-circle"></i></a></td>
                    <td>Prospect Status <a class="iconLink tiptip"
                                           title="A status used for separating out proposals. Not counted in sales/bid figures. Hidden from proposals table by default"><i
                                    class="fa fa-fw fa-info-circle"></i></a></td>
                    <!--
                    <td>On Hold Status <a class="iconLink tiptip" title="A status used for separating out proposals. Not counted in sales/bid figures. Proposals remain visible in proposals table."><i class="fa fa-fw fa-info-circle"></i></a> </td>
                    -->
                    <th width="90">Actions</th>
                </tr>
                </thead>
                <tbody class="status-sortable">
                <?php
                foreach ($statuses as $status) {
                    /** @var $status \models\Status */
                    ?>
                    <tr class="even" id="status_<?php echo $status->getStatusId(); ?>" style="height: 45px;">
                        <td style="text-align: center">
                            <span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" style="margin: 0 auto;"
                                  title="Drag to sort"></span>
                        </td>
                        <td style="border-left: 4px solid #<?= $status->getColor(); ?>"
                            id="statusName_<?php echo $status->getStatusId(); ?>"><?php echo $status->getText(); ?><?php echo ($status->getStatusId() == $status::OPEN) ? ' (Default)' : ''; ?></td>
                        <td style="text-align: center">
                            <?php if ($status->isSales()) { ?>
                                <i class="fa fa-fw fa-check-circle"></i>
                            <?php } ?>
                        </td>
                        <td style="text-align: center">
                            <?php if ($status->isProspect()) { ?>
                                <i class="fa fa-fw fa-check-circle"></i>
                            <?php } ?>
                        </td>
                        <!--
                    <td style="text-align: center">
                        <?php if ($status->isOnHold()) { ?>
                            <i class="fa fa-fw fa-check-circle"></i>
                        <?php } ?>
                    </td>
                    -->
                        <td style="">
                            <?php if ($status->getCompany()) { ?>
                                <a href="#" class="btn-edit edit-status tiptip" title="Edit Status"
                                   data-sold="<?php echo $status->getSales(); ?>"
                                   data-prospect="<?php echo $status->getProspect() ?>"
                                   data-on_-old="<?php echo $status->getOnHold() ?>"
                                   data-status-id="<?php echo $status->getStatusId(); ?>"
                                   data-status-color="<?php echo $status->getColor(); ?>"
                                   data-status-text="<?php echo $status->getText(); ?>">&nbsp;</a>
                                <a href="#" class=" btn-delete delete-status tiptip" title="Delete Status" style=""
                                   data-status-id="<?php echo $status->getStatusId(); ?>">&nbsp;</a>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>

        </div>

    </div>


    <div class="content-box">
        <div class="box-header">
            Add New Proposal Status
        </div>
        <div class="box-content" style="padding: 20px;">
            <form method="post" action="">
                <input type="hidden" name="action" value="add"/>
                <table class="boxed-table">
                    <tr>
                        <td>
                            <label>Status Name: </label>
                        </td>
                        <td>
                            <input type="text" class="text" name="newStatus"/>
                            <input type="text" id="newColor" name="newColor" style="visibility:hidden;width:1px"
                                   class="jsColor" onchange="updateAddBgPreview(this.jscolor)">
                            <div style="width: 25px;float: left;height: 22px;background-color: rgb(255, 51, 25);cursor:pointer;border:1px solid #cccccc"
                                 onclick="document.getElementById('newColor').jscolor.show()"
                                 id="click_add_color_pick"></div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Won Status:</label>
                        </td>
                        <td>
                            <input type="checkbox" class="checkbox" name="newStatusSold"/>
                            <span style="position: relative; top: 4px;"><i class="fa fa-fw fa-info-circle"></i> A proposal is considered <strong>Won</strong> when changed to this status type</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Prospect Status:</label>
                        </td>
                        <td>
                            <input type="checkbox" class="checkbox" name="newStatusProspect"/>
                        </td>
                    </tr>

                    <!--
                    <tr>
                        <td>
                            <label>On Hold Status:</label>
                        </td>
                        <td>
                            <input type="checkbox" class="checkbox" name="newStatusOnHold" />
                        </td>
                    </tr>
                    -->
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" name="submitNewStatus" class="btn ui-button update-button"
                                   value="Add Status"/>
                        </td>
                    </tr>
                </table>

            </form>
        </div>
    </div>


</div>
<!-- Edit Status Dialog -->
<div id="edit-status" title="Edit Status">

    <form method="post">
        <input type="hidden" name="action" value="edit"/>
        <input type="hidden" name="statusId" id="statusId" value=""/>

        <table class="boxed-table">
            <tr>
                <td width: 30% style="text-align: right;"><strong>Status Name</strong></td>
                <td>
                    <input type="text" name="statusText" id="statusText" value="" style="width: 200px;"/>
                    <input type="text" id="editColor" name="editColor" style="display:none" class="jsColor"
                           onchange="updateBgPreview(this.jscolor)">
                    <div style="width: 25px;float: left;margin-left: 5px;height: 18px;background-color: rgb(255, 51, 25);cursor:pointer;border:1px solid #cccccc"
                         onclick="document.getElementById('editColor').jscolor.show()" id="click_color_pick"></div>
                </td>
            </tr>
            <tr>
                <td width: 30% style="text-align: right;"><strong>Won Status</strong></td>
                <td>
                    <input type="checkbox" name="editStatusSold" id="editStatusSold">
                    <input type="hidden" id="editStatusOriginalSold">
                </td>
            </tr>
            <tr>
                <td width: 30% style="text-align: right;"><strong>Prospect Status</strong></td>
                <td>
                    <input type="checkbox" name="editStatusProspect" id="editStatusProspect">
                </td>
            </tr>
            <tr class="unsoldRow" style="display: none;">
                <td width: 30% style="text-align: right;"><strong>Note</strong></td>
                <td>
                    This will remove the win date of all proposal with this status.
                </td>
            </tr>

            <!--
            <tr>
                <td>On Hold Status</td>
                <td>
                    <input type="checkbox" name="editStatusOnHold" id="editStatusOnHold">
                </td>
            </tr>
            -->
            <tr>
                <td></td>
                <td>
                    <button type="submit" class="btn ui-button update-button">Save</button>
                </td>
            </tr>
        </table>
    </form>
</div>

<!-- Delete Status Dialog -->
<div id="delete-status" title="Deleting Status">

    <form method="post">
        <input type="hidden" name="action" value="delete"/>
        <input type="hidden" name="statusId" id="deleteStatusId" value=""/>

        <p>After deleting status "<span id="deleteStatusName"></span>" , they will be changed to the following status:
        </p><br/>

        <select name="targetStatus" id="targetStatus">
            <?php foreach ($statuses as $status) { ?>
                <option value="<?php echo $status->getStatusId(); ?>"
                        id="status-option-<?php echo $status->getStatusId(); ?>"><?php echo $status->getText(); ?></option>
            <?php } ?>
        </select>


        <button type="submit" class="btn ui-button update-button">Delete</button>
    </form>
</div>


<!-- Revert Status Dialog -->
<div id="revert-status" title="Revert Status" data-status-id="">

    <p>Are you sure that you want to revert this status name to it's original name?</p>

</div>

<script type="text/javascript">

    $(document).ready(function () {

        console.log(jscolor.zIndex);
//         jscolor.presets.myPreset = {
//     format: 'any',
//     width: 101,
//     backgroundColor: '#333',
// };
        function updateRowColors() {
            var k = 0;
            $("#defaultStatuses tbody tr").each(function () {
                $(this).removeClass('even');
                k++;
                if (!(k % 2)) {
                    $(this).addClass('even');
                }
            });
        }

        updateRowColors();
        // Edit status dialog
        $("#edit-status").dialog({
            width: 600,
            modal: true,
            buttons: {
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false,
            open: function (event, ui) {
                $(this).parent().css('position', 'fixed');
                $(this).parent().css('top', '200px');
                $(this).parent().css('left', '50%');
                $(this).parent().css('transform', 'translateX(-50%)');
            }
        });
        // Edit Status dialog open
        $('.edit-status').click(function () {

            // Populate the fields before displaying
            $('#statusId').val($(this).data('status-id'));
            $('#statusText').val($(this).data('status-text'));
            $('#editColor').val($(this).data('status-color'));

            $('#click_color_pick').css('background-color', '#' + $(this).data('status-color'));
            // Sold Checkbox
            $("#editStatusSold").prop('checked', $(this).data('sold'));
            $("#editStatusOriginalSold").val($(this).data('sold'));
            $("#editStatusProspect").prop('checked', $(this).data('prospect'));
            $("#editStatusOnHold").prop('checked', $(this).data('on-hold'));
            $.uniform.update();

            $("#edit-status").dialog('open');
            setTimeout(function () {
                $('#editColor').click();
            }, 300);
            return false;
        });

        // Delete status dialog
        $("#delete-status").dialog({
            width: 400,
            modal: true,
            buttons: {
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });

        // Delete Status dialog open
        $('.delete-status').click(function () {
            var statusId = $(this).data('status-id');
            $("#targetStatus option").show();
            $("#status-option-" + statusId).hide();
            $("#deleteStatusName").text($('#statusName_' + statusId).text());
            $('#deleteStatusId').val(statusId);
            $("#delete-status").dialog('open');
        });

        // Revert Status dialog open
        $('.btn-restore').click(function () {
            var statusId = $(this).data('status-id');

            $("#revert-status").data('status-id', statusId);
            $("#revert-status").dialog('open');
        });

        // Revert status dialog
        $("#revert-status").dialog({
            width: 400,
            modal: true,
            buttons: {
                "Revert": {
                    text: 'Revert',
                    'class': 'btn ui-button update-button',
                    click: function () {
                        window.location.href = '<?php echo site_url('account/company_proposal_statuses/revert'); ?>/' + $(this).data('status-id');
                    }
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });


        // Sortable statuses
        $('.status-sortable').sortable({
                handle: '.handle',
                stop: function () {
                    var ordered_data = $(this).sortable("serialize");
                    $.ajax({
                        url: '<?php echo site_url('ajax/order_statuses') ?>',
                        type: "POST",
                        data: ordered_data,
                        dataType: "json",
                        success: function (data) {
//                            console.log(data);
                            updateRowColors();
                            if (data.error) {
                                alert(data.error);
                            } else {
//                                document.location.reload();
                            }
                        },
                        error: function () {
                            alert('There was an error processing the request. Please try again later.');
                        }
                    });
                }
            }
        );

        $("#editStatusSold").change(function() {

            var originalSold = $("#editStatusOriginalSold").val();
            var sold = Boolean($(this).is(':checked'));

            if (originalSold == 1 && !sold) {
                $(".unsoldRow").show();
            } else {
                $(".unsoldRow").hide();
            }

        });

    });

    $(document).on('click', '#editColor', function () {

        $(".ui-widget-overlay").next().css('z-index', '1020');
        var x = $("#click_color_pick").position();
        var left_position = $("#click_color_pick").offset().left - $(document).scrollLeft();


        var top_position = $("#click_color_pick").offset().top - $(document).scrollTop();
        top_position = parseInt(top_position) + parseInt(20);


        $(".ui-widget-overlay").next().css('top', top_position);
        $(".ui-widget-overlay").next().css('left', left_position);
    });

    $(document).on('click', '#click_color_pick', function () {

        $("#editColor").click();
        // $( "#editColor" ).trigger( "focus" );
    });


    function updateBgPreview(jscolor) {
        var rgbColor = (jscolor.toRGBString());
        $("#click_color_pick").css("background-color", rgbColor);
    }

    $(document).on('click', '#click_add_color_pick', function () {

        $("#newColor").click();
    });

    function updateAddBgPreview(jscolor) {
        var rgbColor = (jscolor.toRGBString());
        $("#click_add_color_pick").css("background-color", rgbColor);
    }
</script>
