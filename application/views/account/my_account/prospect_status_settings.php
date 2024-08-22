<h3>
    Prospect Status
    <div class="right">
        <form method="post" action="">
            <input type="hidden" name="action" value="add"/>
            <input type="text" name="newStatus" placeholder="Enter New Status" class="text"
                   style="width: 150px;"/>
            <input type="submit" name="submitNewStatus" class="btn ui-button update-button" value="Add Prospect Status"
                   style="font-size: 12px; padding: 2px 5px;"/>
        </form>
    </div>
</h3>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="boxed-table" id="prospectStatus">
    <thead>
    <tr>
        <th width="50" style="height: 33px;">Order</th>
        <th>Prospect Status</th>
        <th width="90">Actions</th>
    </tr>
    </thead>
    <tbody class="status-sortable">
    <?php
    foreach ($prospectStatuses as $prospectStatus) {
       
        ?>
        <tr class="even" id="type_<?php echo $prospectStatus->getId(); ?>">
            <td style="text-align: center">
                <span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" style="margin: 0 auto;"
                      title="Drag to sort"></span>
            </td>
            <td id="type_id_<?php echo $prospectStatus->getId(); ?>"><?php echo $prospectStatus->getStatusName(); ?></td>
            <td style="">
                <a href="#" class=" btn-delete delete-status tiptip" title="Delete Type" style=""
                   data-status-id="<?php echo $prospectStatus->getId(); ?>">&nbsp;</a>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>


<!-- Delete status Dialog -->
<div id="delete-status" title="Deleting Status">

    <form method="post">
        <input type="hidden" name="action" value="delete"/>
        <input type="hidden" name="statusId" id="deleteStatusId" value=""/>

        <p>Are you sure you want to delete this prospect status?</p><br/>

        <button type="submit" class="btn ui-button update-button">Delete</button>
    </form>
</div>


<script type="text/javascript">

    $(document).ready(function () {
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
            $('#deleteStatusId').val(statusId);
            $("#delete-status").dialog('open');
        });


        // Sortable statuses
        $('.status-sortable').sortable({
                handle: '.handle',
                stop: function () {
                    var ordered_data = $(this).sortable("serialize");
                    $.ajax({
                        url: '<?php echo site_url('account/order_prospect_status') ?>',
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

    });
</script>
