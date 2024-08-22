<?php /* @var $template \models\ClientEmailTemplate */ ?>
<?php /* @var $templateType \models\ClientEmailTemplateType */ ?>
<div class="content-box">
    <div class="box-header">
        <?php echo (isset($template)) ? 'Editing: ' . $template->getTemplateName() : 'Adding ' . $templateType->getTypeName().' Template'; ?>
        <a href="<?php echo site_url('admin/client_email_templates/' . $templateType->getTypeId()) ?>" class="box-action tiptip" title="Go Back">Back to Templates</a>
    </div>
    <div class="box-content">
        <?php echo form_open(current_url(), array('class' => 'template-validate', 'autocomplete' => 'off')) ?>
        <input type="hidden" name="templateId" value="<?php echo isset($template) ? $template->getTemplateId() : ''; ?>"/>
        <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
            <tbody>

            <tr>
                <td style="width: 150px; text-align: right;">Template Name:</td>
                <td style="padding-top: 7px;">
                    <input type="text" class="text required" name="templateName" style="width: 350px;" value="<?php echo isset($template) ? $template->getTemplateName() : set_value('templateName'); ?>"/>
                </td>
            </tr>
            <tr>
                <td style="width: 150px; text-align: right;">Template Description:</td>
                <td style="padding-top: 7px;">
                    <input type="text" name="templateDescription" style="width: 350px;" class="text required" value="<?php echo isset($template) ? $template->getTemplateDescription() : set_value('templateDescription'); ?>"/>
                </td>
            </tr>
            <tr>
                <td style="width: 150px; text-align: right;">Fields:</td>
                <td style="padding-top: 7px;">
                    <select name="field" id="field">
                        <option value="">-- Select a field</option>
                        <?php foreach ($templateTypeFields as $field) {
                            /* @var $field \models\ClientEmailTemplateTypeField */
                            ?>
                            <option value="<?php echo $field->getFieldCode() ?>"><?php echo $field->getFieldName() ?></option>
                        <?php
                        }
                        ?>
                    </select>
                    <!--<input type="button" value="Get Code" class="btn" style="margin-top: -2px;" id="addAtCursor"/>-->
                    <input type="text" class="text" id="fieldCode" style="float: right">
                </td>
            </tr>
            <tr>
                <td style="text-align: right">Subject</td>
                <td><input class="text required" type="text" name="subject" id="subject" style="width: 98%;" value="<?php echo isset($template) ? $template->getTemplateSubject() : set_value('templateDescription'); ?>"/></td>
            </tr>
            <tr>
                <td style="text-align: right">Message Body</td>
                <td>
                    <textarea name="body" id="body" class="required" cols="30" rows="10">
                        <?php echo isset($template) ? $template->getTemplateBody() : set_value('body'); ?>
                    </textarea>
                </td>
            </tr>
            <tr>
                <td></td>
                <td><input class="btn ui-btn update-button" type="submit" id="submitTemplate" name="submitTemplate" value="Save"/></td>
            </tr>
            </tbody>
        </table>
        <?php form_close(); ?>
    </div>
</div>


<script type="text/javascript">

    // Instantiate the text editor
    $(document).ready(function () {
        // var template_editor = CKEDITOR.replace('body', {
        //     height: 400
        // });

        tinymce.init({
                        selector: "textarea#body",
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
                        toolbar: tinyMceMenus.email,
                        forced_root_block_attrs: tinyMceMenus.root_attrs,
                        fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
                });
        /* Copy the field codes */
        $("#field").change(function () {
            $("#fieldCode").val('{' + $(this).val() + '}');
        });


        /* Validate the form */
        //$('.validate').validate({});
        $('.template-validate').validate({
            rules: {
                body: {
                    required: function () {
                        //CKEDITOR.instances.body.updateElement();
                        tinymce.get("body").getContent();
                    }
                }
            },
            errorPlacement: function (error, $elem) {
                if ($elem.is('textarea')) {
                    $elem.next().css('border', '1px solid red');
                }
            }
        });

    });


</script>