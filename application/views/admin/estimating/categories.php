<?php $this->load->view('global/header-admin'); ?>
<div id="content" class="clearfix">
    <div class="widthfix">

        <h3>Estimating Categories</h3>

        <div class="clearfix"></div>

        <div class="content-box">
            <div class="box-header">
                Estimating Categories
                <a class="box-action" id="addEstCategory" href="#">
                    <i class="fa fa-fw fa-plus"></i>
                    Add Category
                </a>
            </div>
            <div class="box-content">

                <table class="boxed-table" width="100%" id="estimationCategories">
                    <thead style="padding: 5px;">
                    <tr>
                        <th style="padding: 5px;"></th>
                        <th style="padding: 10px; text-align: left;">Category Name</th>
                        <th style="padding: 10px; text-align: left;">Actions</th>
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
                            <td width="10%">
                                <a href="#" class="btn tiptip editCategory" title="Edit <?php echo $category->getName(); ?> Category"
                                    data-category-id="<?php echo $category->getId(); ?>"
                                    data-category-name="<?php echo $category->getName(); ?>">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Dialogs -->
        <div id="categoryFormDialog" title="Category Details">

            <br/>
            <form id="categoryForm" action="<?php echo site_url('admin/saveCategory'); ?>" method="post">
                <input type="hidden" name="categoryId" id="categoryId" />

                <label for="name">Category Name:</label>
                <input type="text" name="categoryName" id="categoryName" maxlength="25" />
            </form>

        </div>

    </div>
</div>

<script type="text/javascript">

    $(document).ready(function() {

        // Sortable categories
        $("#estimationCategories tbody").sortable({
            helper: fixHelper,
            handle:".handle",
            stop:function () {
                var postData = $(this).sortable("serialize");
                $.ajax({
                    type:"POST",
                    url:"<?php echo site_url('ajax/updateEstimationCategoryDefaultOrder') ?>",
                    data:postData,
                    async:false
                });
            }
        });

        // Return a helper with preserved width of cells
        var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        };

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

        $("#addEstCategory").click(function() {
            // Clear the id in case we edited
            $("#categoryId").val('');
            $("#categoryFormDialog").dialog('open');
            return false;
        });

        $(".editCategory").click(function() {
            // Set the ID
            $("#categoryId").val($(this).data('category-id'));
            // Set the name
            $("#categoryName").val($(this).data('category-name'));
            $("#categoryFormDialog").dialog('open');
            return false;
        });

    });

</script>

<?php $this->load->view('global/footer'); ?>