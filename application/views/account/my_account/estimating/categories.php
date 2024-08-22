<!-- <a style="float: right;margin-right: 20px;margin-top: 12px;font-size: 14px;font-weight: bold;" href="<?php echo site_url('account/my_account/proposal_settings') ?>">Back</a> -->
<h3>Categories</h3>
<p class="adminInfoMessage"><i class="fa fa-fw fa-info-circle"></i>These are the categories the all types and items belong. You can re-order them here.</p>
<table class="boxed-table" width="100%" id="estimationCategories">
    <thead style="padding: 5px;">
    <tr>
        <th style="padding: 5px;"></th>
        <th style="padding: 10px; text-align: left;">Category Name</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($categories as $category) : ?>
        <tr id="categories_<?php echo $category->getId(); ?>">
            <td style="text-align: center" width="10%">
                <a class="handle">
                    <i class="fa fa-fw fa-sort"></i>
                </a>
            </td>
            <td><?php echo $category->getName() ?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<!-- Dialogs -->
<div id="categoryFormDialog" title="Category Details">

    <br/>
    <form id="categoryForm" action="<?php echo site_url('account/saveEstimatingCategory'); ?>" method="post">
        <input type="hidden" name="categoryId" id="categoryId" />

        <label for="name">Category Name:</label>
        <input type="text" name="categoryName" id="categoryName" maxlength="25" />
    </form>

</div>

<script type="text/javascript">

    $(document).ready(function() {

        // Form modal
        $("#categoryFormDialog").dialog({
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
                    text: 'Save Category',
                    'class': 'btn blue-button',
                    click: function () {
                        $("#categoryForm").submit();
                    }
                }
            }
        });

        // Sortable categories
        $("#estimationCategories tbody").sortable({
            helper: fixHelper,
            handle:".handle",
            stop:function () {
                var postData = $(this).sortable("serialize");
                $.ajax({
                    type:"POST",
                    url:"<?php echo site_url('ajax/updateEstimationCategoryOrder') ?>",
                    data:postData,
                    async:false
                });
            }
        });

        // Delete button
        $(".deleteCategory").click(function() {

            var categoryId = $(this).data('category-id');

            swal({
                title: 'Delete Category',
                html: '<p>Are you sure you want to delete this category?</p>',
                showCloseButton: true,
                showCancelButton: true,
                confirmButtonText:
                    '<i class="fa fa-fw fa-trash"></i> Delete Category',
                cancelButtonText:
                    '<i class="fa fa-fw fa-close"></i> Cancel'
            }).then(
                function() {
                    window.location.href = '<?php echo site_url('account/deleteEstimatingCategory'); ?>/' + categoryId;
                }, function (dismiss) {

                }
            );

            return false;
        });

        // End Document ready
    });

    // Return a helper with preserved width of cells
    var fixHelper = function(e, ui) {
        ui.children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    };

</script>