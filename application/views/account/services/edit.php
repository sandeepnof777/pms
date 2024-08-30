<?php $this->load->view('global/header');
/* @var $service \models\Services */
$fieldTypeNames = array(
    'select' => 'Dropdown',
    'text' => 'Number',
    'texttext' => 'Text',
    'textarea' => 'Text Area'
);
?>
<div id="content" class="clearfix">
    <div class="widthfix">
        <h4>Edit Service: <?php if (@$category) {
                echo $category->getServiceName() . ' - ';
            } ?><span class="editServiceName tiptip" title="Click to edit" id="<?php echo $service->getServiceId() ?>">
                <?php echo $service->hasCustomTitle($account->getCompany()->getCompanyId())
                    ? $service->getCustomTitle($account->getCompany()->getCompanyId())->getTitle()
                    : $service->getServiceName(); ?>
        </h4>
        <div class="content-box left" id="service-customtexts">
            <div class="box-header">
                Service Texts
                <a href="<?php echo site_url('account/company_services') ?>" class="box-action tiptip" title="Go Back">Back</a>
                <a href="#" id="addText" class="box-action tiptip" title="Go Back">Add New Text</a>
            </div>
            <div class="box-content">
                <input type="hidden" id="serviceId" value="<?php echo $service->getServiceId(); ?>" />
                <?php
                if (!count($texts)) {
                    ?><p class="padded">No texts found.</p><?php
                } else {
                    ?>
                    <div id="service-texts-edit"><?php
                    $k = 0;
                    foreach ($texts as $text) {
                        $k++;
                        ?>
                        <div class="<?php echo ($k % 2) ? 'odd' : '' ?> text clearfix" id="texts_<?php echo $text->getTextId() ?>">
                            <span class="handle ui-icon ui-icon-arrowthick-2-n-s"></span>
                            <span class="textValue">
                                <?php echo $text->getText() ?>
                            </span>
                            <span class="actions">
                                <a class="btn-edit tiptip edit-text" title="Edit Text" href="#" rel="<?php echo $text->getTextId() ?>">Edit Text</a>
                                <a class="btn-delete tiptip delete-text" title="Delete Text" href="<?php echo site_url('account/delete_service_text/' . $text->getTextId()) ?>">Delete Text</a>
                            </span>
                        </div>
                    <?php
                    }
                    ?></div><?php
                }
                ?>
            </div>
        </div>
        <div id="service-fields" class="right">
            <div class="content-box right">
                <div class="box-header">
                    Service Fields
                    <a href="<?php echo site_url('account/company_services') ?>" class="box-action tiptip" title="Go Back">Back</a>
                </div>
                <div class="box-content">
                    <?php
                    if (!count($fields)) {
                        ?>
                        <p class="padded">No fields have been defined for this service.</p>
                    <?php
                    } else {
                        ?>
                        <div id="service-fields-edit">
                            <?php
                            $k = 0;
                            foreach ($fields as $field) {
                                /* @var $field \models\ServiceField */
                                $k++;
                                ?>
                                <div class="<?php echo ($k % 2) ? 'odd' : '' ?> field clearfix" id="fields_<?php echo $field->getFieldId() ?>">
                                    <span class="handle ui-icon ui-icon-arrowthick-2-n-s"></span>
                                    <span class="fieldName">
                                        <?php echo $field->getFieldName(); ?>
                                    </span>
                                    <span class="fieldType">
                                        <?php echo isset($fieldTypeNames[$field->getFieldType()]) ? $fieldTypeNames[$field->getFieldType()] : strtoupper($field->getFieldType()); ?>
                                    </span>
                                    <span class="actions">
                                        <?php if ($field->getCompany() == $account->getCompany()->getCompanyId()) { ?>
                                        <a class="btn-edit tiptip edit-field" rel="<?php echo $field->getFieldId() ?>" href="#" title="Edit Field">Edit Field</a>
                                        <?php } ?>
                                        <a class="btn-delete tiptip delete-field" href="<?php echo site_url('account/delete_service_field/' . $field->getFieldId()) ?>" title="Delete Field">Delete Field</a>
                                    </span>
                                </div>
                            <?php
                            }
                            ?>
                        </div>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <div class="content-box right" id="service-addfield">
                <div class="box-header">
                    Add New Field
                </div>
                <div class="box-content">
                    <form autocomplete="off" class="form-validated" accept-charset="utf-8" method="post" action="<?php echo site_url('account/edit_service/' . $service->getServiceId()) ?>">
                        <table width="100%" cellspacing="0" cellpadding="0" class="boxed-table">
                            <tbody>
                            <tr class="">
                                <td>
                                    <p class="clearfix left">
                                        <label class="tiptip" title="The Name of the field as it appears">Field Name</label>
                                        <input type="text" name="fieldName" id="fieldName" class="text required tiptip" title="Name of field, descriptive">
                                    </p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <p class="clearfix left">
                                        <label class="tiptip" title="The string of text you put in the custom text to include this field">Field Code</label>
                                        <input type="text" name="fieldCode" id="fieldCode" class="text required tiptip" title="Code that shows up in the text. Try to use lowercase letters. NO SPACES.">
                                    </p>
                                </td>
                            </tr>
                            <tr class="">
                                <td>
                                    <p class="clearfix left">
                                        <label>Field Type</label>
                                        <select name="fieldType" id="fieldType">
                                            <option value="text">Number</option>
                                            <option value="text">Text</option>
                                            <option value="select">Dropdown</option>
                                            <option value="textarea">Text Area</option>
                                        </select>
                                    </p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <p class="clearfix">
                                        <label>Field Value(s)<br>*1 per row for select</label>
                                        <textarea name="fieldValue" id="fieldValue" style="width: 220px; height: 90px;"></textarea>
                                    </p>
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <label>&nbsp;</label>
                                    <input type="submit" class="btn ui-button ui-widget ui-state-default ui-corner-all" value="Add New Field" tabindex="28" role="button" aria-disabled="false" name="add_field">
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="/3rdparty/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //Edit Category Name
        $(".editServiceName").editable('<?php echo site_url('ajax/editServiceName') ?>', {
            cancel:'Cancel',
            submit:'OK',
            width:510,
            height:100
        });
        //Sort fields
        $("#service-fields-edit").sortable({
            handle:'.handle',
            stop:function () {
                var k = 0;
                $("#service-fields-edit .field").each(function () {
                    k++;
                    $(this).removeClass('odd');
                    if (k % 2 == 1) {
                        $(this).addClass('odd');
                    }
                });
                var fields = $("#service-fields-edit").sortable("serialize");
                fields += '&service=' + $("#serviceId").val();
                $.ajax({
                    type:"POST",
                    url:"<?php echo site_url('ajax/updateCompanyServiceFieldsOrder') ?>",
                    data:fields,
                    async:false
                });
            }
        });
        //Sort texts
        $("#service-texts-edit").sortable({
            handle:'.handle',
            stop:function () {
                var l = 0;
                $("#service-texts-edit .text").each(function () {
                    l++;
                    $(this).removeClass('odd');
                    if (l % 2 == 1) {
                        $(this).addClass('odd');
                    }
                });
                setTextsOrder();
            }
        });
        function setTextsOrder() {
            var texts = $("#service-texts-edit").sortable("serialize");
            texts += '&service=' + $("#serviceId").val();
            $.ajax({
                type:"POST",
                url:"<?php echo site_url('ajax/updateCompanyServiceTextsOrder') ?>",
                data: texts,
                async:false
            });
        }
        setTextsOrder();
        //Delete Field
        var deleteURL = '';
        $(".delete-field").click(function () {
            deleteURL = $(this).attr('href');
            $("#confirm-delete-field").dialog('open');
            return false;
        });
        $("#confirm-delete-field").dialog({
            autoOpen:false,
            buttons:{
                Ok:function () {
                    document.location.href = deleteURL;
                    $(this).dialog('close');
                },
                Cancel:function () {
                    $(this).dialog('close');
                }
            },
            width:400
        });
        //Edit Field
        $(".edit-field").click(function () {
            var fieldId = $(this).attr('rel');
            $.getJSON('<?php echo site_url('ajax/getServiceFieldDetails') ?>/' + fieldId, function (data) {
                $("#editFieldName").val(data.fieldName);
                $("#editFieldCode").val(data.fieldCode);
                $("#editFieldValue").val(data.fieldValue);
                $("#editFieldType").val(data.fieldType);
                $("#fId").val(data.fieldId);
                $.uniform.update();
            });
            $("#edit-field").dialog('open');
            return false;
        });
        $("#edit-field").dialog({
            autoOpen:false,
            buttons:{
                Save:function () {
                    $("#edit-field-form").submit();
                },
                Cancel:function () {
                    $(this).dialog('close');
                }
            },
            width:550,
            modal:true,
            open:function () {
            }
        });
        //ckeditor
        // var addtext_editor = CKEDITOR.replace('addTextText', {
        //     toolbar:'Minimum'
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
            autoOpen:false,
            buttons:{
                Add:function () {
                    $("#add-servicetext-form").submit();
                },
                Cancel:function () {
                    $(this).dialog('close');
                }
            },
            width:650,
            modal:true,
            open:function () {
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
            autoOpen:false,
            buttons:{
                Ok:function () {
                    document.location.href = deleteURL;
                    $(this).dialog('close');
                },
                Cancel:function () {
                    $(this).dialog('close');
                }
            },
            width:400
        });
        //edit text
        $("#edit-servicetext").dialog({
            autoOpen:false,
            buttons:{
                Save:function () {
                    $("#edit-servicetext-form").submit();
                },
                Cancel:function () {
                    $(this).dialog('close');
                }
            },
            width:650,
            modal:true,
            open:function () {
            }
        });
        //ckeditor
        // var edittext_editor = CKEDITOR.replace('editServiceText', {
        //     toolbar:'Minimum'
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
            tinymce.activeEditor.setContent('');
            $.get('<?php echo site_url('ajax/get_service_text') ?>/' + id, function (data) {
                //CKEDITOR.instances.editServiceText.setData(data);
                tinymce.activeEditor.setContent(data);
            });
            $("#edit-servicetext").dialog('open');
            return false;
        });
    });
</script>
<div id="confirm-delete-field" title="Confirm Deletion">
    <p class="padded">Are you sure you want to delete this field?</p>
</div>
<div id="confirm-delete-text" title="Confirm Deletion">
    <p class="padded">Are you sure you want to delete this text?</p>
</div>
<div id="edit-field" title="Edit Field" style="padding: 0;">
    <form class="form-validated" accept-charset="utf-8" method="post" action="<?php echo site_url('account/edit_service/' . $service->getServiceId()) ?>" id="edit-field-form">
        <input type="hidden" name="fId" id="fId">
        <table width="100%" cellspacing="0" cellpadding="0" class="boxed-table">
            <tbody>
            <tr class="">
                <td>
                    <p class="clearfix left">
                        <label title="The Name of the field as it appears" class="tiptip">Field Name</label>
                        <input type="text" class="text required tiptip" id="editFieldName" name="editFieldName" title="Name of field, descriptive.">
                    </p>
                </td>
            </tr>
            <tr class="even">
                <td>
                    <p class="clearfix left">
                        <label>Field Code</label>
                        <input type="text" class="text required tiptip" id="editFieldCode" name="editFieldCode" title="Code that shows up in the text. Try to use lowercase letters. NO SPACES.">
                    </p>
                </td>
            </tr>
            <tr class="">
                <td>
                    <p class="clearfix left">
                        <label>Field Type</label>
                        <select name="editFieldType" id="editFieldType">
                            <option value="text">Text</option>
                            <option value="select">Dropdown</option>
                            <option value="textarea">Text Area</option>
                        </select>
                    </p>
                </td>
            </tr>
            <tr class="even">
                <td>
                    <p class="clearfix">
                        <label>Default Value(s)<br>*1 per row for select</label>
                        <textarea style="width: 220px; height: 90px;" id="editFieldValue" name="editFieldValue"></textarea>
                        <input type="hidden" name="save_field" tabindex="28" value="Save Field">
                    </p>
                </td>
            </tr>
            </tbody>
        </table>
    </form>
</div>
<div id="add-servicetext" title="Add New Text">
    <p class="clearfix" style="margin-bottom: 10px;">
        <label>Add Field: </label>
        <select name="addTag" id="addTag">
            <?php
            foreach ($fields as $field) {
                ?>
                <option value="{<?php echo $field->getFieldCode(); ?>}"><?php echo $field->getFieldName() ?></option><?php
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
        <label>Edit Field: </label>
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
<?php $this->load->view('global/footer'); ?>
