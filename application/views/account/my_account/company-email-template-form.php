<?php /* @var $template \models\ClientEmailTemplate */ ?>
<h3>
    <?php echo $boxTitle;
    $templateType = ($template) ? $template->getTemplateType()->getTypeId() : $this->uri->segment(4);
    ?>
    <a class="btn update-button" href="<?php echo site_url('account/company_email_templates/' . $templateType) ?>" style="padding: 0 2px; font-size: 12px;">Back to Templates</a>
</h3>
<?php echo form_open(current_url(), array('class' => 'template-validate', 'autocomplete' => 'off')) ?>
<input type="hidden" name="templateId" value="<?php echo isset($template) ? $template->getTemplateId() : ''; ?>"/>
<table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
    <tbody>
    <tr>
        <td style="width: 150px; text-align: right;">Template Name:</td>
        <td style="padding-top: 7px;">
            <input type="text" class="text required" name="templateName" style="width: 350px;" value="<?php echo $template->getTemplateName(); if ($this->uri->segment(3) == 'duplicate') echo ' - Copy'; ?>"/>
        </td>
    </tr>
    <tr>
        <td style="width: 150px; text-align: right;">Template Description:</td>
        <td style="padding-top: 7px;">
            <input type="text" name="templateDescription" style="width: 350px;" class="text required" value="<?php echo $template->getTemplateDescription(); ?>"/>
        </td>
    </tr>
    <tr>
        <td style="width: 150px; text-align: right;">Fields:</td>
        <td style="padding-top: 7px;">
            <select name="field" id="field">
                <option value="0">- Select Field</option>
                <?php foreach ($typeFields as $field) {
                    /* @var $field \models\ClientEmailTemplateTypeField */
                    ?>
                    <option value="<?php echo $field->getFieldCode(); ?>"><?php echo $field->getFieldName(); ?></option>
                <?php } ?>
            </select>
            <!--<input type="button" value="Get Code" class="btn" style="margin-top: -2px;" id="addAtCursor"/>-->
            <input type="text" class="text" id="fieldCode" style="float: right">
        </td>
    </tr>
    <tr>
        <td style="text-align: right">Subject</td>
        <td><input class="text required" type="text" name="subject" id="subject" style="width: 98%;" value="<?php echo $template->getTemplateSubject() ?>"/></td>
    </tr>
    <tr>
        <td style="text-align: right">Message Body</td>
        <td>
            <textarea name="body" id="body" cols="30" rows="10">
                <?php echo $template->getTemplateBody(); ?>
            </textarea>
        </td>
    </tr>
    <tr>
        <td></td>
        <td><input class="btn ui-btn update-button" type="submit" name="submitTemplate" value="Save"/></td>
    </tr>
    </tbody>
</table>
<?php form_close(); ?>

<script type="text/javascript">


    $(document).ready(function () {

        // Instantiate the text editor
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

        // Display the field code when selected
        $("#field").change(function () {
            $("#fieldCode").val('{' + $(this).val() + '}');
        });

        // Form validation
        /* Validate the form */
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