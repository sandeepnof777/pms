<h3>
    Editing Service: <span id="<?php echo $service->getServiceId() ?>" class="editServiceName tiptip" title="Customize the title as it appears on the proposal"><?php echo (isset($customTitle)) ? $customTitle : $service->getServiceName() ?></span>
    <a href="<?php echo site_url('account/company_services') ?>">Back</a>

    <?php if ($this->uri->segment(2) == 'edit_service') { ?>
    <a href="#" id="addText">Add Text</a>
    <?php } ?>
</h3>
<?php
if (!count($texts)) {
    ?><p class="padded">No texts found for this service.</p><?php
} else {
    ?>
    <div id="edit-texts">
        <?php
        $k = 0;
        foreach ($texts as $txt) {
            $k++;
            $text = $txt['text'];
            ?>
            <div class="<?php echo ($k % 2) ? 'odd ' : '' ?><?php if ($txt['deleted']) {
                echo 'deleted ';
            } ?>text clearfix" id="texts_<?php echo $text->getTextId() ?>">
                <span class="handle ui-icon ui-icon-arrowthick-2-n-s"></span>
                                <span class="textValue">
                                    <?php if ($txt['deleted']) { ?><b>Deleted Original Text: </b><?php } ?>
                                    <?php echo $text->getText() ?>
                                    <?php if (isset($txt['replacedText'])) {
                                        echo '<span class="deleted-text"><br><b>Previous Text:</b>' . $txt['replacedText']['text']->getText() . '</span>';
                                    } ?>
                                </span>
                                <span class="actions">
                                    <?php if (!$txt['deleted']) { ?>
                                        <a class="btn-edit edit-text tiptip" title="Edit Text" href="#" rel="<?php echo $text->getTextId() ?>">Edit</a>
                                        <a class="btn-delete delete-text tiptip" title="Delete Text" href="<?php echo site_url('account/delete_text/' . $text->getTextId()) ?>">Delete</a>
                                    <?php } ?>
                                    <?php if ($txt['deleted']) { ?>
                                        <a class="btn-restore tiptip" title="Restore Text" href="<?php echo site_url('account/restore_text/' . $text->getTextId()) ?>">Restore</a>
                                    <?php } ?>
                                    <?php if (isset($txt['replacedText'])) { ?>
                                        <a class="btn-restore tiptip" title="Restore Previous Text" href="<?php echo site_url('account/restore_text/' . $txt['replacedText']['text']->getTextId()) ?>">Restore</a>
                                    <?php } ?>
                                </span>
            </div>
        <?php
        }
        ?>
    </div>
<?php
}
?>

<script type="text/javascript">
    $(document).ready(function () {
        //Edit Service Name
        $(".editServiceName").editable('<?php echo site_url('ajax/editServiceName') ?>', {
            cancel: 'Cancel',
            submit: 'OK',
            width: 510,
            height: 100
        });
        //sort texts
        $("#edit-texts").sortable({
            items: "div:not(.deleted)",
            handle: ".handle",
            stop: function () {
                var k = 0;
                $("#edit-texts .text").each(function () {
                    k++;
                    $(this).removeClass('odd');
                    if (k % 2 == 1) {
                        $(this).addClass('odd');
                    }
                });
                var postData = $("#edit-texts").sortable("serialize");
                postData = 'service=<?php echo $service->getServiceId() ?>&' + postData;
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('ajax/updateServiceTextsOrder') ?>",
                    data: postData,
                    async: false
                });
            }
        });
        //ckeditor
        // var addtext_editor = CKEDITOR.replace('addTextText', {
        //     toolbar: 'Minimum2'
        // });
        tinymce.init({
                        selector: "textarea#addTextText",
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
                        fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
                });
        //Add Service Text
        $("#addText").click(function () {
//            CKEDITOR.instances.addTextText.setData('');
            $("#add-servicetext").dialog('open');
            return false;
        });
        $("#add-servicetext").dialog({
            autoOpen: false,
            buttons: {
                Save: function () {
                    $("#add-servicetext-form").submit();
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            },
            width: 650,
            modal: true,
            open: function () {
            }
        });
        //add tag
        $("#addAtCursor").click(function () {
            //CKEDITOR.instances.addTextText.insertText($("#addTag").val());
            tinymce.activeEditor.execCommand('mceInsertContent', false, $("#addTag").val());

        });
        //delete text
        $(".delete-text").click(function () {
            deleteURL = $(this).attr('href');
            $("#confirm-delete-text").dialog('open');
            return false;
        });
        $("#confirm-delete-text").dialog({
            autoOpen: false,
            buttons: {
                Ok: function () {
                    document.location.href = deleteURL;
                    $(this).dialog('close');
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            },
            width: 400
        });
        //edit text
        $("#edit-servicetext").dialog({
            autoOpen: false,
            buttons: {
                Save: function () {
                    $("#edit-servicetext-form").submit();
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            },
            width: 650,
            modal: true,
            open: function () {
            }
        });
        //ckeditor
        // var edittext_editor = CKEDITOR.replace('editServiceText', {
        //     toolbar: 'Minimum2'
        // });
        tinymce.init({
                        selector: "textarea#editServiceText",
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
                        fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
                });
        //add tag
        $("#addAtCursorEdit").click(function () {
            //CKEDITOR.instances.editServiceText.insertText($("#addTagEdit").val());
            tinymce.activeEditor.execCommand('mceInsertContent', false, $("#addTagEdit").val());
        });
        $(".edit-text").click(function () {
            var id = $(this).attr('rel');
            $("#editTextId").val(id);
            //CKEDITOR.instances.editServiceText.setData('');
            tinymce.get("editServiceText").setContent('');
            
            $.get('<?php echo site_url('ajax/get_service_text') ?>/' + id, function (data) {
                //CKEDITOR.instances.editServiceText.setData(data);
                tinymce.get("editServiceText").setContent(data);
            });
            $("#edit-servicetext").dialog('open');
            return false;
        });
        //restore text
        var restoreURL;
        $(".btn-restore").click(function () {
            restoreURL = $(this).attr('href');
            $("#confirm-restore-text").dialog('open');
            return false;
        });
        $("#confirm-restore-text").dialog({
            autoOpen: false,
            buttons: {
                Ok: function () {
                    document.location.href = restoreURL;
                    $(this).dialog('close');
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            },
            width: 400
        });
    });
</script>
<div id="confirm-delete-text" title="Confirm Deletion">
    <p class="padded">Are you sure you want to delete this text?</p>
</div>
<div id="confirm-restore-text" title="Confirm Deletion">
    <p class="padded">
        Are you sure you want to restore the text? <br>
        Restoring replaced texts will ireversibly replace your edit.</p>
</div>
<div id="add-servicetext" title="Add New Text">
    <p class="clearfix" style="margin-bottom: 10px;">
        <label>Add Field: </label>
        <select name="addTag" id="addTag">
            <?php
            foreach ($fields as $field) {
                ?>
                <option value="{<?php echo $field->getFieldCode() ?>}"><?php echo $field->getFieldName() ?></option><?php
            }
            ?>
        </select>
        <input class="btn" type="button" value="Add at cursor" id="addAtCursor">
    </p>
    <form action="<?php echo site_url('account/edit_service/' . $this->uri->segment(3)) ?>" method="post" id="add-servicetext-form">
        <textarea name="addTextText" id="addTextText" cols="30" rows="10"></textarea>
        <input type="hidden" value="Add Text" name="add_text" class="btn">
    </form>
</div>
<div id="edit-servicetext" title="Edit Text">
    <p class="clearfix" style="margin-bottom: 10px;">
        <label>Add Field: </label>
        <select name="addTagEdit" id="addTagEdit">
            <?php
            foreach ($fields as $field) {
                ?>
                <option value="{<?php echo $field->getFieldCode() ?>}"><?php echo $field->getFieldName() ?></option><?php
            }
            ?>
        </select>
        <input class="btn" type="button" value="Add at cursor" id="addAtCursorEdit">
    </p>
    <form action="<?php echo site_url('account/edit_service/' . $this->uri->segment(3)) ?>" method="post" id="edit-servicetext-form">
        <input id="editTextId" type="hidden" name="editTextId">
        <textarea name="editServiceText" id="editServiceText" cols="30" rows="10"></textarea>
        <input type="hidden" value="Save Text" name="edit_text" class="btn">
    </form>
</div>