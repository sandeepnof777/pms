<h3>
    <div class="right">
        <form method="post" action="">
            <input type="hidden" name="action" value="add"/>
            <input type="text" name="newSource" placeholder="Enter New Lead Source" class="text" style="width: 150px;"/>
            <input type="submit" name="submitNewSource" class="btn ui-button update-button" value="Add Lead Source" style="font-size: 12px; padding: 2px 5px;"/>
        </form>
    </div>
</h3>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="boxed-table" id="leadSources">
    <thead>
    <tr>
        <th width="50" style="height: 33px;">Order</th>
        <th>Lead Source</th>
        <th width="90">Actions</th>
    </tr>
    </thead>
    <tbody class="status-sortable">
    <?php
    foreach ($leadSources as $leadSource) {
        /** @var $leadSource \models\Status */
        ?>
        <tr class="even" id="source_<?php echo $leadSource->getId(); ?>">
            <td style="text-align: center">
                <span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" style="margin: 0 auto;" title="Drag to sort"></span>
            </td>
            <td id="source_id_<?php echo $leadSource->getId(); ?>">
               <span class="lead-source-text"><?php echo $leadSource->getName(); ?></span>
               <input type="text" class="lead-source-edit" value="<?php echo $leadSource->getName(); ?>" style="display:none;"/>
             </td>
            <td style="">
                <a href="#" class=" btn-delete delete-source tiptip" title="Delete Source" style="" data-source-id="<?php echo $leadSource->getId(); ?>">&nbsp;</a>
                <a href="#" class="btn-edit edit-source tiptip" title="Edit Source" data-source-id="<?php echo $leadSource->getId(); ?>">&nbsp;</a>
                <a href="#" class="btn-save save-source tiptip" title="Save Source" data-source-id="<?php echo $leadSource->getId(); ?>" style="display:none;">Save</a>
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

        <p>Are you sure you want to delete this lead source?</p><br />

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
                        url: '<?php echo site_url('account/order_lead_sources') ?>',
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
          // createing a functioning for edit lead source start
      // Edit Source
   $('.edit-source').click(function () {
        var sourceId = $(this).data('source-id');
        var row = $(this).closest('tr');
        var inputField = row.find('.lead-source-edit');
        var editButton = $(this);
        
        row.find('.lead-source-text').hide(); // Hide the display text
        inputField.show(); // Show the input field
        row.find('.btn-save').show(); // Show the save button
        editButton.hide(); // Hide the edit button
        // Focus and scroll to the input field
        inputField.focus();
        $('html, body').animate({
            scrollTop: inputField.offset().top - 100 // Adjust the offset as needed
        }, 500); // Duration of the scroll animation in milliseconds
    });

    // Save Source
    $('.btn-save').click(function (e) {
        e.preventDefault();
        var sourceId = $(this).data('source-id');
        var row = $(this).closest('tr');
        var newName = row.find('.lead-source-edit').val();

        $.ajax({
            url: '<?php echo site_url('account/update_lead_source') ?>',
            type: "POST",
            data: {
                action: 'update',
                sourceId: sourceId,
                newName: newName
            },
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    row.find('.lead-source-text').text(newName).show();
                    row.find('.lead-source-edit').hide();
                    row.find('.btn-save').hide();
                    row.find('.btn-edit').show();
                    swal({
                                title: 'Updating...',
                                allowEscapeKey: false,
                                allowOutsideClick: false,
                                timer: 1000,
                                onOpen: () => {
                                    swal.showLoading();
                                }
                            })

                 } else {
                    console.log(data.error);
                }
            },
            error: function () {
                 console.log("There was an error processing the request. Please try again later.");

            }
        });
    });
 

    });

  
</script>
