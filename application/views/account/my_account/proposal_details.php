<h3>Custom Texts  <span style="float: right; font-size: 12px;">Set Default
<!-- add a back button  -->
&nbsp;&nbsp;&nbsp;
<!-- <a style="color:#999;" href="<?php echo site_url('account/my_account/proposal_settings') ?>">Back</a> -->
</span></h3>
<table class="boxed-table customtexts_table" width="100%" cellspacing="0" cellpadding="0" id="customTexts">
    <?php foreach ($categories as $id => $cat) { ?>
        <tbody id="category-header-<?php echo $cat->getCategoryId() ?>" class="<?php echo (in_array($cat->getCategoryId(), $enabledCategories)) ? 'category-enabled' : 'category-disabled' ?>">
        <tr class="text_category">
            <td colspan="2">
                <div class="cat">
                    <a href="#" class="" id="cat-<?php echo $cat->getCategoryId() ?>" title="Click to expand/contract" rel="#category-<?php echo $cat->getCategoryId() ?>"><?php echo $cat->getCategoryName() ?> <span class="sign ui-icon ui-icon-plus"></span></a>
                </div>
            </td>
            <td width="85">
                <?php
                if ($cat->getCompany()) { //checks if its not a global category (category=0)
                    ?>
                    <div style="width: 70px !important; display block; height: 1px;">&nbsp;</div>
                    <a title="Edit Category" href="#" rel="<?php echo $cat->getCategoryId() ?>" class="tiptip btn-edit btn-edit-cat">&nbsp;</a>
                    <a title="Delete Category" href="#" rel="<?php echo $cat->getCategoryId() ?>" class="tiptip confirm-deletion btn-delete btn-delete-cat">&nbsp;</a>
                <?php } ?>
            </td>
            <td width="100">
                <div style="width: 70px !important; display block; height: 1px;">&nbsp;</div>
                <a href="#" title="Make Default" data-id="<?php echo $cat->getCategoryId() ?>" style="margin-left: 0; float: left;" class="tiptip enableCategory box-action small update-button right">Turn On</a>
                <a href="#" title="Disable Default" data-id="<?php echo $cat->getCategoryId() ?>" style="margin-left: 0; float: left;" class="tiptip disableCategory box-action small red-button right"> Turn Off</a>
            </td>
        </tr>
        </tbody>
        <tbody class="texts-sortable" id="category-<?php echo $cat->getCategoryId() ?>">
        <tr class="thead">
            <td width="20"></td>
            <td>Text</td>
            <td width="50">Default</td>
            <td width="110">Actions</td>
        </tr>
        <?php
        $k = 0;
        foreach ($texts as $textId => $text) {
            if ($text->getCategory() == $cat->getCategoryId()) {
                $k++;
                ?>
                <tr <?php echo ($k % 2) ? 'class="even"' : ''; ?> id="text_<?php echo $text->getTextId() ?>">
                    <td valign="top">
                        <span class="handle ui-icon ui-icon-arrowthick-2-n-s tiptip" title="Drag to sort"></span>
                    </td>
                    <td style="display: block; overflow: hidden; width: 575px; padding-bottom: 20px;">
                        <?php echo $text->getText() ?></td>
                    <td valign="top"><?php echo ($text->getChecked() == 'yes') ? 'Yes' : 'No'; ?></td>
                    <td valign="top">
                        <a title="Edit Text" href="#" rel="<?php echo $text->getTextId() ?>" class="tiptip btn-edit btn-edit-text">&nbsp;</a>
                        <a title="Delete Text" href="#" rel="<?php echo $text->getTextId() ?>" class="tiptip confirm-deletion btn-delete btn-delete-text">&nbsp;</a>
                        <?php
                        if ($textId != $text->getTextId()) {
                            ?>
                            <a rel="<?php echo $textId ?>" href="#" title="View / Restore Original Text" class="btn-restore-text btn-restore tiptip">&nbsp;</a>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
        if (!$k) {
            ?>
            <tr>
                <td colspan="4" class="padded centered">No texts found! Use the buttons above to add texts in this category.</td>
            </tr>
            <?php
        }
        ?>
        </tbody>
    <?php } ?>
</table>


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
        
   

         <p class="clearfix"><label>Services</label>

            <select name="service_id" id="service_id">
            <?php  foreach ($category as $cat) { ?>
                <option value="">Please Select Services</option>

                <optgroup label="<?php echo $cat->getServiceName(); ?>">
                <?php
                   if (isset($services[$cat->getServiceId()])) {?>

                <?php foreach ($services[$cat->getServiceId()] as $service) {
                  
                    if (!in_array($service->getServiceId(), $disabledServices)) { ?>

                  <option value="<?php echo $service->getServiceId(); ?>"><?php echo (isset($service_titles[$service->getServiceId()])) ? $service_titles[$service->getServiceId()] : $service->getServiceName() ?></option>
              <?php   } }
            }
            ?>
                </optgroup>
            <?php } ?>
               
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
        <p class="clearfix">
            <label>Default</label>
            <input type="checkbox" name="addcat-default" id="addcat-default" checked="checked">
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
<div id="edit" title="Edit text9">
    <form action="#" class="dialog-form">
        <p class="clearfix"><label>Default</label><select name="edit-checked" id="edit-checked">
                <option value="no">No</option>
                <option value="yes">Yes</option>
            </select></p>
        <p class="clearfix"><label>Category6</label>
            <select name="edit-category" id="edit-category">
                <?php foreach ($categories as $cat) {
                    ?>
                    <option value="<?php echo $cat->getCategoryId() ?>"><?php echo $cat->getCategoryName() ?></option>
                    <?php
                } ?>
            </select>
        </p>
        <p class="clearfix"><label>Services</label>

            <select name="edit_service_id" id="edit_service_id">
            <?php  foreach ($category as $cat) { ?>
                <option value="">Please Select Services</option>

                <optgroup label="<?php echo $cat->getServiceName(); ?>">
                <?php
                if (isset($services[$cat->getServiceId()])) {?>

                <?php foreach ($services[$cat->getServiceId()] as $service) {
                
                    if (!in_array($service->getServiceId(), $disabledServices)) { ?>

                <option value="<?php echo $service->getServiceId(); ?>"><?php echo (isset($service_titles[$service->getServiceId()])) ? $service_titles[$service->getServiceId()] : $service->getServiceName() ?></option>
            <?php   } }
            }
            ?>
                </optgroup>
            <?php } ?>
            
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

<script type="text/javascript">
    $(document).ready(function () {
        //ckeditor
        // var addnew_editor = CKEDITOR.replace('addnew-text', {
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
        // var edit_editor = CKEDITOR.replace('edit-text', {
        //     toolbar: 'Minimum'
        // });
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
                    var request = $.ajax({
                        url: '<?php echo site_url('ajax/reorder_texts') ?>',
                        type: "POST",
                        data: ordered_data,
                        dataType: "json",
                        success: function (data) {
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
            });
        });
        $("#addnew").dialog({
            width: 600,
            modal: true,
            buttons: {
                Add: function () {
                    var request = $.ajax({
                        url: '<?php echo site_url($this->uri->segment(1) . '/add_customtext') ?>',
                        type: "POST",
                        data: {
                            category: $("#addnew-category").val(),
                            text: tinymce.get("addnew-text").getContent(),
                            service_id: $("#service_id").val(),
                            checked: $("#addnew-checked").val()
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data.error) {
                                alert(data.error);
                            } else {
                                document.location.href = '<?php echo site_url('account/company_proposal_details') ?>/' + $("#addnew-category").val();
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
                tinymce.get("addnew-text").setContent('Your Text Here');
            },
            autoOpen: false
        });
        $("#add_cat").dialog({
            width: 600,
            modal: true,
            buttons: {
                Add: function () {
                    var request = $.ajax({
                        url: '<?php echo site_url($this->uri->segment(1) . '/add_customtext_cat') ?>',
                        type: "POST",
                        data: {
                            category: $("#addcat-name").val(),
                            on: $("#addcat-default").attr('checked') ? 1 : 0
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
            modal: true,
            buttons: {
                Save: function () {
                    var request = $.ajax({
                        url: '<?php echo site_url($this->uri->segment(1) . '/edit_customtext') ?>',
                        type: "POST",
                        data: {
                            category: $("#edit-category").val(),
                            text: tinymce.get("edit-text").getContent(),
                            edit_service_id: $("#edit_service_id").val(),
                            checked: $("#edit-checked").val(),
                            id: $("#edit-id").val()
                        },
                        dataType: "json",
                        success: function (data) {
                            if (data && data.error) {
                                alert(data.error);
                            } else {
                                document.location.href = '<?php echo site_url('account/company_proposal_details') ?>/' + $("#edit-category").val();
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
            modal: true,
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
                    console.log("Data",data);
                    $("#edit-text").html(data.text);
                    tinymce.get("edit-text").setContent(data.text);
                    $("#edit-category").val(data.category);
                    $("#edit_service_id").val(data.service_id);
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
                    $.get('<?php echo site_url($this->uri->segment(1) . '/delete_customtext') ?>/' + $("#client-delete").attr('rel'));
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
        //restore custom texts code snippet here
        $(".btn-restore-text").click(function () {
            var id = $(this).attr('rel');
            var url = '<?php echo site_url($this->uri->segment(1) . '/get_customtext') ?>/' + id;
            $.ajax({
                url: url,
                type: "GET",
                dataType: "json",
                success: function (data) {
                    $("#restore-text").html(data.text);
                    $("#restore-id").val(id);
                    $("#restore-default").html(data.checked);
                    $("#restore-category").html(data.categoryName);
                },
                error: function () {
                    alert('There was an error processing the request. Please try again later.');
                }
            });
            $("#restore").dialog("open");
            return false;
        });
        $("#restore").dialog({
            width: 600,
            buttons: {
                Restore: function () {
                    var url = '<?php echo site_url($this->uri->segment(1) . '/restore_customtext') ?>/' + $("#restore-id").val();
                    document.location.href = url;
                    $(this).dialog("close");
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            open: function () {
                $("#restore-category").html('');
                $("#restore-default").html('');
                $("#restore-text").html('');
            },
            autoOpen: false,
            modal: true
        });
        //deleted texts snippets
        $("#deleted_texts").click(function () {
            $("#restore-deleted").dialog('open');
            return false;
        });
        $("#restore-deleted").dialog({
            width: 700,
            height: 500,
            buttons: {
                Close: function () {
                    $(this).dialog("close");
                }
            },
            open: function () {
            },
            close: function () {
                if ($("#deletedTextsRefresh").val() == '1') {
                    document.location.href = '<?php echo site_url('account/company_proposal_details') ?>';
                }
            },
            autoOpen: false,
            modal: true
        });
        $(".restoredeletedtext").click(function () {
            $.get($(this).attr('href'));
            $($(this).attr('rel')).fadeOut();
            $("#deletedTextsRefresh").val(1);
            return false;
        });
        /*
         Enables/Disables a custom text cateogry as default
         */
        $(".enableCategory, .disableCategory").on('click', function () {
            //compile data
            var categoryId = $(this).data('id');
            var tbody = $(this).parents('tbody');
            var enable = 1;
            if ($(this).is('.disableCategory')) {
                enable = 0;
            }
            var newClass = (enable) ? 'category-enabled' : 'category-disabled';
            //send toggle request
            $.ajax({
                url: '<?php echo site_url('account/toggleCustomtextCategory') ?>',
                type: "POST",
                data: {
                    enable: enable,
                    categoryId: categoryId
                },
                success: function (data) {
                    if (data == 'success') {
                        tbody.removeClass('category-enabled').removeClass('category-disabled').addClass(newClass);
//                        alert('done!');
                    }
                },
                error: function () {
                    alert('There was an error processing the request. Please try again later.');
                }
            });
            return false;
        });
    });
</script>
<!--Model box for the restore deleted texts button-->
<div id="restore-deleted" title="View/Restore Deleted Texts">
    <table class="calculator-table customtexts-table" width="100%" cellpadding="4" cellspacing="0">
        <tr>
            <td class="head">Deleted Text</td>
            <td class="head" width="65">Actions</td>
        </tr>
        <?php
        foreach ($deleted_texts as $dt) {
            $text = $this->em->find('models\Customtext', $dt->getTextId());
            if ($text) {
                ?>
                <tr id="deletedtext_<?php echo $text->getTextId() ?>">
                    <td>
                        <?php echo $text->getText() ?>
                    </td>
                    <td>
                        <a class="btn restoredeletedtext" rel="#deletedtext_<?php echo $text->getTextId() ?>" href="<?php echo site_url('account/restore_customtext/' . $text->getTextId()) ?>/dontdredir">Restore</a>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </table>
    <input type="hidden" id="deletedTextsRefresh" name="deletedTextsRefresh" value="0">
</div>
<!--Modal box for the restore edited texts buttons-->
<div id="restore" title="View / Restore text">
    <p align="left" style="padding: 5px 0;">You are about to change the current text as it appears back to the default text of PavementLayers.</p>

    <p align="center" style="padding: 5px 0;"><strong>This is the text that you are installing:</strong></p>

    <div style="border: 1px solid #eee; background: #fafafa; margin: 0 30px; padding: 10px;">
        <form action="#" class="dialog-form">
            <p class="clearfix">
                <span id="restore-text">Text gona be here yo</span>
                <input type="hidden" name="restore-id" id="restore-id">
            </p>
        </form>
    </div>
    <p style="color: red; text-align: center; padding: 10px 0;"><strong>Warning: <br> Restoring the original text will replace the current text! This can not be undone!</strong></p>
</div>