<h3>
    Prospect Ratings
    <div class="right">
        <form method="post" action="">
            <input type="hidden" name="action" value="add"/>
            <input type="text" name="newRating" placeholder="Enter New Prospect Rating" class="text"
                   style="width: 150px;"/>
            <input type="submit" name="submitNewRating" class="btn ui-button update-button" value="Add Prospect Rating"
                   style="font-size: 12px; padding: 2px 5px;"/>
        </form>
    </div>
</h3>
<table width="100%" border="0" cellpadding="0" cellspacing="0" class="boxed-table" id="prospectRatings">
    <thead>
    <tr>
        <th width="50" style="height: 33px;">Order</th>
        <th>Prospect Rating</th>
        <th width="90">Actions</th>
    </tr>
    </thead>
    <tbody class="status-sortable">
    <?php
    foreach ($prospectRatings as $prospectRating) {
       
        ?>
        <tr class="even" id="rating_<?php echo $prospectRating->getId(); ?>">
            <td style="text-align: center">
                <span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" style="margin: 0 auto;"
                      title="Drag to sort"></span>
            </td>
            <td id="rating_id_<?php echo $prospectRating->getId(); ?>"><?php echo $prospectRating->getRatingName(); ?></td>
            <td style="">
                <a href="#" class=" btn-delete delete-rating tiptip" title="Delete Rating" style=""
                   data-rating-id="<?php echo $prospectRating->getId(); ?>">&nbsp;</a>
            </td>
        </tr>
        <?php
    }
    ?>
    </tbody>
</table>


<!-- Delete Status Dialog -->
<div id="delete-rating" title="Deleting Rating">

    <form method="post">
        <input type="hidden" name="action" value="delete"/>
        <input type="hidden" name="ratingId" id="deleteRatingId" value=""/>

        <p>Are you sure you want to delete this prospect rating?</p><br/>

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
        $("#delete-rating").dialog({
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
        $('.delete-rating').click(function () {
            var ratingId = $(this).data('rating-id');
            $('#deleteRatingId').val(ratingId);
            $("#delete-rating").dialog('open');
        });


        // Sortable statuses
        $('.status-sortable').sortable({
                handle: '.handle',
                stop: function () {
                    var ordered_data = $(this).sortable("serialize");
                    $.ajax({
                        url: '<?php echo site_url('account/order_prospect_ratings') ?>',
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
