<?php $this->load->view('global/header-admin'); ?>
<div id="content" class="clearfix">
    <div class="widthfix">
        <div class="content-box">
            <div class="box-header">
                FAQ Categories
                <a class="box-action" href="<?php echo site_url('admin') ?>">Back</a>
                <a class="box-action" href="#" id="reorder-categories">Reorder Categories</a>
                <a class="box-action" href="#" id="add-category-link">Add Category</a>
            </div>
            <div class="box-content">
                <div class="centered">
                    <br/>
                    Click on the category names below to expand/contract and edit the questions within them.
                    <br/>
                    <br/>
                </div>
                <ul id="faq-categories">
                    <?php
                    if (!$categories->num_rows()) {
                        ?>
                        <li class="center">No categories found! Add a new one from the button above.</li><?php
                    } else {
                        foreach ($categories->result() as $category) {
                            ?>
                            <li>
                                <h3><a href="#" rel="#faq_category_<?php echo $category->id ?>"><?php echo $category->name ?> <span class="handle-closed">+</span><span class="handle-open">-</span></a></h3>

                                <div class="faq-category-content" id="faq_category_<?php echo $category->id ?>">
                                    <div class="centered padded">
                                        <a class="btn btn-small add-question" href="#" rel="<?php echo $category->id ?>">Add Question</a>
                                        <a class="btn btn-small edit-category" href="#" rel="<?php echo $category->id ?>">Edit Category</a>
                                        <a class="btn btn-small delete-category" href="#" rel="<?php echo $category->id ?>">Delete Category</a>
                                    </div>
                                    <ul class="faq_questions" rel="<?php echo $category->id ?>">
                                        <?php
                                        if (isset($questions[$category->id]) && is_array($questions[$category->id])) {
                                            foreach ($questions[$category->id] as $question) {
                                                ?>
                                                <li id="question_<?php echo $question->id ?>">
                                                    <div class="faq-question clearfix">
                                                        <div class="faq-question-handle">
                                                            <span class="handle ui-icon ui-icon-arrowthick-2-n-s"></span>
                                                        </div>
                                                        <div class="faq-question-content">
                                                            <div class="question"><?php echo $question->question ?></div>
                                                            <!--<div class="answer"><?php echo $question->answer ?></div>-->
                                                        </div>
                                                        <div class="faq-question-actions">
                                                            <a href="#" class="edit-question btn-edit tiptip" title="Edit Question" rel="<?php echo $question->id ?>">Edit</a>
                                                            <a href="#" class="delete-question btn-delete tiptip" title="Delete Question" rel="<?php echo $question->id ?>">Delete</a>
                                                        </div>
                                                    </div>
                                                </li>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <li>
                                                <div class="centered padded"><b>No questions within category! Please add using the buttons above.</b></div>
                                            </li>
                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </li>
                        <?php
                        }
                    }
                    ?>
                </ul>
            </div>
        </div>
    </div>
</div>


<!--#content-->

<script type="text/javascript">
$(document).ready(function () {
    //init - close all
    $(".handle-open").hide();
    $(".faq-category-content").addClass('closed').hide();
    //toggle function
    function toggleCategory(id) {
        if ($(id).hasClass('closed')) {
            $(".faq-category-content.open").slideUp().addClass('closed').removeClass('open');
            $(".handle-open").hide();
            $(".handle-closed").show();
            $(id).addClass('open').removeClass('closed').slideDown();
            $(this).find('.handle-closed').hide();
            $(this).find('.handle-open').show();
        } else {
            $(id).removeClass('open').addClass('closed').slideUp();
            $(this).find('.handle-closed').show();
            $(this).find('.handle-open').hide();
        }
    }

    $("#faq-categories h3 a").click(function () {
        var ulId = $(this).attr('rel');
        toggleCategory(ulId);
        return false;
    });
    <?php if ($this->uri->segment(3)) {
    //activate category if needed
    ?>
    toggleCategory('#faq_category_<?php echo $this->uri->segment(3) ?>');
    <?php
    } ?>
    //dialogs and stuffs
    /*
     * Add Category
     * */
    $("#add-category").dialog({
        width: 400,
        modal: true,
        buttons: {
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });
    $("#add-category-link").click(function () {
        $("#categoryName").val('');
        $("#add-category").dialog("open");
        return false;
    });
    $("#add-category-form").submit(function () {
        if (!$("#categoryName").val()) {
            alert("You must submit a category name!");
            return false;
        } else {
            return true;
        }
    });
    /*
     * Edit Category
     * */
    $("#edit-category").dialog({
        width: 400,
        modal: true,
        buttons: {
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });
    $(".edit-category").click(function () {
        var categoryId = $(this).attr('rel');
        $("#editCategoryId").val(categoryId);
        //get category name
        var url = '<?php echo site_url('admin/get_faq_category_name') ?>/' + categoryId;
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'JSON',
            success: function (response) {
                if (response.success) {
                    $("#editCategoryName").val(response.categoryName);
                    $("#edit-category").dialog('open');
                } else {
                    alert('There has been an error processing your request! Please try again later and contact the dev team if this happens often.')
                }
            }
        });
        return false;
    });
    $("#save-category-form").submit(function () {
        if (!$("#editCategoryName").val()) {
            alert("You must submit a category name!");
            return false;
        } else {
            return true;
        }
    });
    var deleteUrl = '<?php echo site_url('admin/delete_faq_category') ?>/';
    var deleteLink;
    $("#delete-category").dialog({
        width: 400,
        modal: true,
        buttons: {
            Delete: function () {
                document.location.href = deleteLink;
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });
    $(".delete-category").click(function () {
        var categoryId = $(this).attr('rel');
        deleteLink = deleteUrl + categoryId;
        $("#delete-category").dialog("open");
        return false;
    });


    $("#add-question").dialog({
        width: 800,
        modal: true,
        buttons: {
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });
    $(".add-question").click(function () {
        var categoryId = $(this).attr('rel');
        $("#addQuestionCategory").val(categoryId);
        $("#addQuestion").val('');
//            $("#addAnswer").val('');
        //CKEDITOR.instances.addAnswer.setData('');
        tinymce.get("addAnswer").setContent('');
        $("#add-question").dialog("open");
        return false;
    });
    $("#add-question-form").submit(function () {
        if (!$("#addQuestion").val() || !tinymce.get("addAnswer").getContent()) {
            alert('Both question and answer are required!');
            return false;
        } else {
            return true;
        }
    });
    //edit question

    $("#edit-question").dialog({
        width: 800,
        modal: true,
        buttons: {
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });
    $(".edit-question").click(function () {
        var questionId = $(this).attr('rel');
        //get category name
        var url = '<?php echo site_url('admin/get_faq_question_details') ?>/' + questionId;
        $.ajax({
            url: url,
            method: 'POST',
            dataType: 'JSON',
            success: function (response) {
                if (response.success) {
                    $("#edit-question").dialog('open');
                    $("#editQuestionId").val(questionId);
                    $("#editQuestion").val(response.question);
//                        $("#editAnswer").val(response.answer);
                    //CKEDITOR.instances.editAnswer.setData(response.answer);
                    tinymce.get("editAnswer").setContent(response.answer)
                } else {
                    alert('There has been an error processing your request! Please try again later and contact the dev team if this happens often.')
                }
            }
        });
        return false;
    });
    $("#save-question-form").submit(function () {
        if (!$("#editQuestion").val() || !tinymce.get("editAnswer").getContent()) {
            alert('Both question and answer are required!');
            return false;
        } else {
            return true;
        }
    });
    var questionDeleteUrl = '<?php echo site_url('admin/delete_faq_question') ?>/';
    var questionDeleteLink;
    $("#delete-question").dialog({
        width: 400,
        modal: true,
        buttons: {
            Delete: function () {
                document.location.href = questionDeleteLink;
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false
    });
    $(".delete-question").click(function () {
        var questionId = $(this).attr('rel');
        questionDeleteLink = questionDeleteUrl + questionId;
        $("#delete-question").dialog("open");
        return false;
    });
    //ckeditor
    // var addAnswer = CKEDITOR.replace('addAnswer', {
    //     toolbar: 'Medium2'
    // });
    // var editAnswer = CKEDITOR.replace('editAnswer', {
    //     toolbar: 'Medium2'
    // });

    tinymce.init({
            selector: "textarea#addAnswer",
            menubar: false,
            elementpath: false,
            relative_urls : false,
            remove_script_host : false,
            convert_urls : true,
            browser_spellcheck : true,
            contextmenu :false,
            paste_as_text: true,
            height:'320',
            plugins: "link image code lists paste preview ",
            toolbar: tinyMceMenus.serviceMenu,
            forced_root_block_attrs: tinyMceMenus.root_attrs,
            fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
    });

    tinymce.init({
            selector: "textarea#editAnswer",
            menubar: false,
            elementpath: false,
            relative_urls : false,
            remove_script_host : false,
            convert_urls : true,
            browser_spellcheck : true,
            contextmenu :false,
            paste_as_text: true,
            height:'320',
            plugins: "link image code lists paste preview ",
            toolbar: tinyMceMenus.serviceMenu,
            forced_root_block_attrs: tinyMceMenus.root_attrs,
            fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
    });

    //Sort Questions
    $(".faq_questions").each(function () {
        $(this).sortable({
            handle: ".handle",
            stop: function () {
                var k = 0;
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('admin/update_faq_questions_order') ?>",
                    data: $(this).sortable("serialize"),
                    async: false
                });
            }
        });
    });
    //Sort Categories
    $("#reorder-categories-dialog").dialog({
        width: 500,
        modal: true,
        buttons: {
            Save: function() {
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('admin/update_faq_categories_order') ?>",
                    data: $("#categories_order").sortable("serialize"),
                    async: false
                });
                $(this).dialog("close");
                document.location.reload();
            },
            Close: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false,
        close: function(event, ui) {
            $("#categories_order").sortable("destroy");
        }
    });
    $("#reorder-categories").click(function () {
        //init
        $("#categories_order").html('');
        $("#categories_order_notice").html('');
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('admin/get_faq_categories') ?>",
            dataType: "JSON",
            success: function (data) {
                $(data).each(function (key, category) {
                    $("#categories_order").append('<li id="categories_' + category.id + '"><span class="handle ui-icon ui-icon-arrowthick-2-n-s"></span> ' + category.name + '</li>');
                });
                $("#categories_order").sortable({
                    handle: '.handle',
                    stop: function() {
                        //save sort
                    }
                });
                $("#reorder-categories-dialog").dialog("open");
            }
        });
        //init sortable
        return false;
    });
});
</script>

<!--Dialogs-->
<div id="add-category" title="Add New Category">
    <form method="post" action="<?php echo site_url('admin/add_faq_category') ?>" id="add-category-form">
        <p>
            <label for="categoryName">Category Name</label>
            <input type="text" name="categoryName" id="categoryName" value="" style="width: 200px;"/>
            <button type="submit" class="btn ui-button update-button">Save</button>
        </p>
    </form>
</div>
<div id="edit-category" title="Edit Category">
    <form method="post" action="<?php echo site_url('admin/save_faq_category') ?>" id="save-category-form">
        <p>
            <label for="editCategoryName">Category Name</label>
            <input type="text" name="editCategoryName" id="editCategoryName" value="" style="width: 200px;"/>
            <input name="editCategoryId" id="editCategoryId" value="" type="hidden"/>
            <button type="submit" class="btn ui-button update-button">Save</button>
        </p>
    </form>
</div>
<div id="delete-category" title="Delete Category">
    <p>Are you sure you want to delete the category and all of its questions?</p>
</div>
<div id="add-question" title="Add New Question">
    <form method="post" action="<?php echo site_url('admin/add_faq_question') ?>" id="add-question-form">
        <p style="margin-bottom: 5px;">
            <label for="categoryName" style="width: 70px; float: left;">Question</label>
            <input type="text" name="addQuestion" id="addQuestion" value="" style="width: 450px;"/>
        </p>

        <p style="margin-bottom: 5px;">
            <label for="categoryName" style="width: 70px; float: left;">Answer</label> <br/>
            <textarea name="addAnswer" id="addAnswer" cols="30" rows="4" style="width: 100%;"></textarea>
        </p>

        <p>
            <input name="addQuestionCategory" id="addQuestionCategory" type="hidden"/>
            <button type="submit" class="btn ui-button update-button">Save</button>
        </p>
    </form>
</div>
<div id="edit-question" title="Edit Question">
    <form method="post" action="<?php echo site_url('admin/save_faq_question') ?>" id="save-question-form">
        <p style="margin-bottom: 5px;">
            <label for="categoryName" style="width: 70px; float: left;">Question</label>
            <input type="text" name="editQuestion" id="editQuestion" value="" style="width: 450px;"/>
        </p>

        <p style="margin-bottom: 5px;">
            <label for="categoryName" style="width: 70px; float: left;">Answer</label> <br/>
            <textarea name="editAnswer" id="editAnswer" cols="30" rows="4" style="width: 100%;"></textarea>
        </p>

        <p>
            <input name="editQuestionId" id="editQuestionId" type="hidden"/>
            <button type="submit" class="btn ui-button update-button">Save</button>
        </p>
    </form>
</div>
<div id="delete-question" title="Delete Question">
    <p>Are you sure you want to delete the category and all of its questions?</p>
</div>

<div id="reorder-categories-dialog" title="Reorder Categories">
    <ul id="categories_order">

    </ul>
    <div id="categories_order_notice"></div>
</div>

<?php $this->load->view('global/footer'); ?>

<!--FAQ Comment so i can commit and push-->