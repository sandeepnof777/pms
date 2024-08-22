<?php
$this->load->view('global/header-admin');
?>
    <div id="content" class="clearfix">
        <div class="widthfix">
            <div class="content-box">
                <div class="box-header">
                    Custom Texts
                    <a class="box-action tiptip" title="Back to My Account" href="<?php echo ($this->uri->segment(1) == 'account') ? site_url('account/my_account') : site_url('admin') ?>">Back</a>
                    <a class="box-action tiptip" title="Add Text" id="addtext" href="#">Add Text</a>
                    <a class="box-action tiptip" title="Add Category" id="addcat" href="#">Add Category</a>
                </div>
                <div class="box-content">
                    </table>
                    <table class="boxed-table customtexts_table" width="100%" cellspacing="0" cellpadding="0">
                        <?php foreach ($categories as $id => $cat) { ?>
                            <tbody id="category-header-<?php echo $cat->getCategoryId() ?>">
                            <tr class="text_category">
                                <td colspan="3">
                                    <div class="cat">
                                        <a href="#" class="" id="cat-<?php echo $cat->getCategoryId() ?>" title="Click to expand/contract" rel="#category-<?php echo $cat->getCategoryId() ?>"><?php echo $cat->getCategoryName() ?> <span class="sign ui-icon ui-icon-plus"></span></a>
                                    </div>
                                </td>
                                <td width="80">
                                    <?php
                                    if (($cat->getCompany()) || ($this->uri->segment(1) == 'admin')) { //checks if its not a global category (category=0)
                                        ?>
                                        <a title="Edit Category" href="#" rel="<?php echo $cat->getCategoryId() ?>" class="tiptip btn-edit btn-edit-cat">&nbsp;</a>
                                        <a title="Delete Category" href="#" rel="<?php echo $cat->getCategoryId() ?>" class="tiptip confirm-deletion btn-delete btn-delete-cat">&nbsp;</a>
                                    <?php } ?>
                                </td>
                            </tr>
                            </tbody>
                            <tbody class="texts-sortable" id="category-<?php echo $cat->getCategoryId() ?>">
                            <tr class="thead">
                                <td width="20"></td>
                                <td>Content Area</td>
                                <td width="50">Default</td>
                                <td width="80">Actions</td>
                            </tr>
                            <?php
                            $k = 0;
                            foreach ($texts as $textId => $text) {
                                if ($text->getCategory() == $cat->getCategoryId()) {
                                    $k++;
                                    ?>
                                    <tr <?php echo ($k % 2) ? 'class="even"' : ''; ?> id="text_<?php echo $text->getTextId() ?>">
                                        <td>
                                            <span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" title="Drag to sort"></span>
                                        </td>
                                        <td><?php echo $text->getText() ?></td>
                                        <td><?php echo ($text->getChecked() == 'yes') ? 'Yes' : 'No'; ?></td>
                                        <td>
                                            <a title="Edit Text2" href="#" rel="<?php echo $text->getTextId() ?>" class="tiptip btn-edit btn-edit-text">&nbsp;</a>
                                            <a title="Delete Text" href="#" rel="<?php echo $text->getTextId() ?>" class="tiptip confirm-deletion btn-delete btn-delete-text">&nbsp;</a>
                                        </td>
                                    </tr>
                                <?php
                                }
                            }
                            ?>
                            </tbody>
                        <?php } ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div id="addnew" title="Add new text">
        <form action="#" class="dialog-form">
            <p class="clearfix"><label>Default</label><select name="addnew-checked" id="addnew-checked">
                    <option value="no">No</option>
                    <option value="yes">Yes</option>
                </select></p>
            <p class="clearfix"><label>Category</label>
                <select name="addnew-category" id="addnew-category">
                    <?php foreach ($categories as $cat) {
                        ?>
                        <option value="<?php echo $cat->getCategoryId() ?>"><?php echo $cat->getCategoryName() ?></option>
                    <?php
                    } ?>
                </select>
            </p>
            <p class="clearfix"><label>Text</label>
                <span class="clearfix"></span>
                <textarea name="addnew-text" id="addnew-text" cols="60" rows="3"></textarea>
            </p>
        </form>
    </div>
    <div id="add_cat" title="Add new category">
        <form action="#" class="dialog-form">
            <p class="clearfix"><label>Name</label>
                <input type="text" name="addcat-name" id="addcat-name" style="width: 400px;">
            </p>
        </form>
    </div>
    <div id="edit_cat" title="Edit category">
        <form action="#" class="dialog-form">
            <p class="clearfix"><label>Name</label>
                <input type="text" name="editcat-name" id="editcat-name" style="width: 400px;">
                <input type="hidden" name="editcat-id" id="editcat-id">
            </p>
        </form>
    </div>
    <div id="edit" title="Edit text">
        <form action="#" class="dialog-form">
            <p class="clearfix"><label>Default</label><select name="edit-checked" id="edit-checked">
                    <option value="no">No</option>
                    <option value="yes">Yes</option>
                </select></p>
            <p class="clearfix"><label>Category</label>
                <select name="edit-category" id="edit-category">
                    <?php foreach ($categories as $cat) {
                        ?>
                        <option value="<?php echo $cat->getCategoryId() ?>"><?php echo $cat->getCategoryName() ?></option>
                    <?php
                    } ?>
                </select>
            </p>
            <p class="clearfix"><label>Text</label>
                <span class="clearfix"></span>
                <textarea name="edit-text" id="edit-text" cols="60" rows="3"></textarea>
                <input type="hidden" name="edit-id" id="edit-id">
            </p>
        </form>
    </div>
    <div id="confirm-delete-message" title="Confirmation">
        <p>Are you sure you want to delete this text?</p>
        <a id="client-delete" href="" rel=""></a>
    </div>
    <div id="confirm-delete-message-cat" title="Confirmation">
        <p>Are you sure you want to delete this category? All the texts under it will be lost.</p>
        <a id="category-delete" href="" rel=""></a>
    </div>
    <script type="text/javascript" src="/3rdparty/ckeditor/ckeditor.js"></script>
    <script type="text/javascript">
    $(document).ready(function () {
        //ckeditor
        // var addnew_editor = CKEDITOR.replace('addnew-text', {
        //     toolbar: 'Minimum'
        // });
        // var edit_editor = CKEDITOR.replace('edit-text', {
        //     toolbar: 'Minimum'
        // });

        tinymce.init({
                selector: "textarea#addnew-text",
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
                selector: "textarea#edit-text",
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

        //accordions code
        $(".texts-sortable").hide();
        $(".cat a").click(function () {
            var id = $(this).attr('rel');
            if ($(this).find('span').hasClass('ui-icon-plus')) {
                $(".cat a span").removeClass('ui-icon-minus').addClass('ui-icon-plus');
                $(".texts-sortable").hide();
                $(this).find('span').removeClass('ui-icon-plus').addClass('ui-icon-minus');
                $(id).fadeIn();
            } else {
                $(".cat a span").removeClass('ui-icon-minus').addClass('ui-icon-plus');
                $(id).fadeOut();
            }
            return false;
        });
        <?php if ($this->uri->segment(3)) {
            ?>
        $("#category-<?php echo $this->uri->segment(3) ?>").show();
        $("#cat-<?php echo $this->uri->segment(3) ?>").find('span').removeClass('ui-icon-plus').addClass('ui-icon-minus');
        <?php
    } ?>
        ///
        $('span.tiptip').tipTip({
            defaultPosition: "top",
            delay: 0,
            maxWidth: '220px'
        });
        $("tbody.texts-sortable").each(function () {
            var categoryId = $(this).attr('id');
            categoryId = categoryId.replace('category-', '');
            var tbody = $(this);
            $(this).sortable({
                handle: '.handle',
                stop: function () {
                    var ordered_data = tbody.sortable("serialize");
                    console.log(ordered_data);
                    var request = $.ajax({
                        url: '<?php echo site_url('admin/adminReorderText') ?>',
                        type: "POST",
                        data: ordered_data,
                        dataType: "json",
                        success: function (data) {
                            if (data.success) {
                                swal('','Order Updated')
                            } else {
//                                document.location.reload();
                            }
                        },
                        error: function () {
                            alert('There was an error processing the request. Please try again later.');
                        }
                    });
                }
            });
        });
        $("#addnew").dialog({
            width: 600,
            buttons: {
                Add: function () {
                    var request = $.ajax({
                        url: '<?php echo site_url($this->uri->segment(1) . '/add_customtext') ?>',
                        type: "POST",
                        data: {
                            category: $("#addnew-category").val(),
                            text: tinymce.get("addnew-text").getContent(),
                            checked: $("#addnew-checked").val()
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data.error) {
                                alert(data.error);
                            } else {
                                document.location.href = '<?php echo site_url($this->uri->segment(1) . '/custom_texts') ?>/' + $("#addnew-category").val();
                            }
                        },
                        error: function () {
                            alert('There was an error processing the request. Please try again later.');
                        }
                    });
                    $(this).dialog("close");
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            open: function () {
                $("#addnew-text").html('Your Text Here');
                //addnew_editor.setData('Your Text Here');
                tinymce.get("addnew-text").setContent('Your Text Here')
            },
            autoOpen: false
        });
        $("#add_cat").dialog({
            width: 600,
            buttons: {
                Add: function () {
                    var request = $.ajax({
                        url: '<?php echo site_url($this->uri->segment(1) . '/add_customtext_cat') ?>',
                        type: "POST",
                        data: {
                            category: $("#addcat-name").val()
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data.error) {
                                alert(data.error);
                            } else {
                                document.location.reload();
                            }
                        },
                        error: function () {
                            alert('There was an error processing the request. Please try again later.');
                        }
                    });
                    $(this).dialog("close");
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            open: function () {
                $("#addcat-name").val('Your Category Name');
            },
            autoOpen: false
        });
        $("#edit").dialog({
            width: 600,
            buttons: {
                Save: function () {
                    var request = $.ajax({
                        url: '<?php echo site_url($this->uri->segment(1) . '/edit_customtext') ?>',
                        type: "POST",
                        data: {
                            category: $("#edit-category").val(),
                            text: tinymce.get("edit-text").getContent(),
                            checked: $("#edit-checked").val(),
                            id: $("#edit-id").val()
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data && data.error) {
                                alert(data.error);
                            } else {
                                document.location.href = '<?php echo site_url($this->uri->segment(1) . '/custom_texts') ?>/' + $("#edit-category").val();
                            }
                        },
                        error: function () {
                            alert('There was an error processing the request. Please try again later.');
                        }
                    });
                    $(this).dialog("close");
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            open: function () {
                $("#addnew-text").html('Your Text Here');
            },
            autoOpen: false
        });
        $("#edit_cat").dialog({
            width: 600,
            buttons: {
                Save: function () {
                    var request = $.ajax({
                        url: '<?php echo site_url($this->uri->segment(1) . '/edit_customtext_cat') ?>',
                        type: "POST",
                        data: {
                            category: $("#editcat-name").val(),
                            id: $("#editcat-id").val()
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data && data.error) {
                                alert(data.error);
                            } else {
                                document.location.reload();
                            }
                        },
                        error: function () {
                            alert('There was an error processing the request. Please try again later.');
                        }
                    });
                    $(this).dialog("close");
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            open: function () {
                $("#addnew-text").html('Your Text Here');
            },
            autoOpen: false
        });
        $("#addtext").click(function () {
            $("#addnew").dialog("open");
            return false;
        });
        $("#addcat").click(function () {
            $("#add_cat").dialog("open");
            return false;
        });
        $(".btn-edit-text").click(function () {
            //get the details
            var id = $(this).attr('rel');
            var url = '<?php echo site_url($this->uri->segment(1) . '/get_customtext') ?>/' + id;
            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $("#edit-text").html(data.text);
                    //edit_editor.setData(data.text);
                    tinymce.get("edit-text").setContent(data.text)
                    $("#edit-category").val(data.category);
                    $("#edit-checked").val(data.checked);
                    $("#edit-id").val(id);
                    $.uniform.update();
                },
                error: function () {
                    alert('There was an error processing the request. Please try again later.');
                }
            });
            //populate the form
            //open the dialog
            $("#edit").dialog("open");
            return false;
        });
        $(".btn-edit-cat").click(function () {
            //get the details
            var id = $(this).attr('rel');
            $("#editcat-id").val(id);
            var url = '<?php echo site_url($this->uri->segment(1) . '/get_customtext_cat') ?>/' + id;
            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $("#editcat-name").val(data.category);
                    $.uniform.update();
                },
                error: function () {
                    alert('There was an error processing the request. Please try again later.');
                }
            });
            //populate the form
            //open the dialog
            $("#edit_cat").dialog("open");
            return false;
        });

        $("#confirm-delete-message").dialog({
            width: 400,
            modal: true,
            buttons: {
                Ok: function () {
//                    document.location.href = $("#client-delete").attr('rel');
                    $.get('<?php echo site_url($this->uri->segment(1) . '/delete_customtext') ?>/' + $("#client-delete").attr('rel'), function () {
                        document.location.reload();
                    });
                    $('#text_' + $("#client-delete").attr('rel')).fadeOut('slow');
                    $(this).dialog("close");
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });
        $(".btn-delete-text").click(function () {
            $("#client-delete").attr('rel', $(this).attr('rel'));
            $("#confirm-delete-message").dialog('open');
            return false;
        });
        $("#confirm-delete-message-cat").dialog({
            width: 400,
            modal: true,
            buttons: {
                Ok: function () {
                    var id = $("#category-delete").attr('rel');
                    $.get('<?php echo site_url($this->uri->segment(1) . '/delete_customtext_cat') ?>/' + id);
                    $("#category-header-" + id).fadeOut('slow');
                    $("#category-" + id).fadeOut('slow');
//                    document.location.reload();
                    $(this).dialog("close");
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });
        $(".btn-delete-cat").click(function () {
            $("#category-delete").attr('rel', $(this).attr('rel'));
            $("#confirm-delete-message-cat").dialog('open');
            return false;
        });

        <?php
        if ($this->session->flashdata('category_open')) {
            ?>
        $("#category_<?php echo $this->session->flashdata('category_open') ?>").show();
        <?php
    }
    ?>
    });
    </script>
<?php
$this->load->view('global/footer');
?>