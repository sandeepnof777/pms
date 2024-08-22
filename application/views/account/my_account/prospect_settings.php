<h3>
    Prospect Sources
    <div class="right">
        <form method="post" action="">
            <input type="hidden" name="action" value="add"/>
            <input type="text" name="newSource" placeholder="Enter New Prospect Source" class="text"
                   style="width: 150px;"/>
            <input type="submit" name="submitNewSource" class="btn ui-button update-button" value="Add Prospect Source"
                   style="font-size: 12px; padding: 2px 5px;"/>
        </form>
    </div>
</h3>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="boxed-table" id="prospectSources">
    <thead>
    <tr>
        <th width="50" style="height: 33px;">Order</th>
        <th>Prospect Source</th>
        <th width="90">Actions</th>
    </tr>
    </thead>
    <tbody class="status-sortable">
    <?php
    foreach ($prospectSources as $prospectSource) {
        /** @var $leadSource \models\Status */
        ?>
        <tr class="even" id="source_<?php echo $prospectSource->getId(); ?>">
            <td style="text-align: center">
                <span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" style="margin: 0 auto;"
                      title="Drag to sort"></span>
            </td>
            <td id="source_id_<?php echo $prospectSource->getId(); ?>"><?php echo $prospectSource->getName(); ?></td>
            <td style="">
                <a href="#" class=" btn-delete delete-source tiptip" title="Delete Source" style=""
                   data-source-id="<?php echo $prospectSource->getId(); ?>">&nbsp;</a>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>


<!-- Delete Status Dialog -->
<div id="delete-source" title="Deleting Source">

    <form method="post">
        <input type="hidden" name="action" value="delete"/>
        <input type="hidden" name="sourceId" id="deleteSourceId" value=""/>

        <p>Are you sure you want to delete this prospect source?</p><br/>

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
        $("#delete-source").dialog({
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
        $('.delete-source').click(function () {
            var sourceId = $(this).data('source-id');
            $('#deleteSourceId').val(sourceId);
            $("#delete-source").dialog('open');
        });


        // Sortable statuses
        $('.status-sortable').sortable({
                handle: '.handle',
                stop: function () {
                    var ordered_data = $(this).sortable("serialize");
                    $.ajax({
                        url: '<?php echo site_url('account/order_prospect_sources') ?>',
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
