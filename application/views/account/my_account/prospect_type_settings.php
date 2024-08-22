<h3>
    Prospect Type
    <div class="right">
        <form method="post" action="">
            <input type="hidden" name="action" value="add"/>
            <input type="text" name="newType" placeholder="Enter New Business Type" class="text"
                   style="width: 150px;"/>
            <input type="submit" name="submitNewType" class="btn ui-button update-button" value="Add Business Type"
                   style="font-size: 12px; padding: 2px 5px;"/>
        </form>
    </div>
</h3>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="boxed-table" id="businessTypes">
    <thead>
    <tr>
        <th width="50" style="height: 33px;">Order</th>
        <th>Prospect Type</th>
        <th width="90">Actions</th>
    </tr>
    </thead>
    <tbody class="type-sortable">
    <?php
    foreach ($prospectTypes as $prospectType) {
       
        ?>
        <tr class="even" id="type_<?php echo $prospectType->getId(); ?>">
            <td style="text-align: center">
                <span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" style="margin: 0 auto;"
                      title="Drag to sort"></span>
            </td>
            <td id="type_id_<?php echo $prospectType->getId(); ?>"><?php echo $prospectType->getTypeName(); ?></td>
            <td style="">
                <a href="#" class=" btn-delete delete-type tiptip" title="Delete Type" style=""
                   data-type-id="<?php echo $prospectType->getId(); ?>">&nbsp;</a>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>


<!-- Delete type Dialog -->
<div id="delete-type" title="Deleting Type">

    <form method="post">
        <input type="hidden" name="action" value="delete"/>
        <input type="hidden" name="typeId" id="deleteTypeId" value=""/>

        <p>Are you sure you want to delete this prospect type?</p><br/>

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
        $("#delete-type").dialog({
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
        $('.delete-type').click(function () {
            var typeId = $(this).data('type-id');
            $('#deleteTypeId').val(typeId);
            $("#delete-type").dialog('open');
        });


        // Sortable statuses
        $('.type-sortable').sortable({
                handle: '.handle',
                stop: function () {
                    var ordered_data = $(this).sortable("serialize");
                    $.ajax({
                        url: '<?php echo site_url('account/order_prospect_type') ?>',
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
