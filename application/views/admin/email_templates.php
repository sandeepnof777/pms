<?php $this->load->view('global/header-admin'); ?>
<div id="content" class="clearfix">
    <div class="widthfix">
        <div class="content-box collapse <?php echo ($this->accountSettings->getSetting($account->getAccountId(), 'box-emailsettings-filter') == 'open') ? 'open' : ''; ?>">
            <div class="box-header">
                Email Settings - Basic Settings for all emails sent out
                <a href="<?php echo site_url('admin') ?>" class="box-action tiptip" title="Go Back">Back</a>
            </div>
            <div class="box-content">
                <form action="<?php echo site_url('admin/email_templates') ?>" method="post">
                    <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
                        <thead>
                        <tr>
                            <td width="150" style="text-align: left;">Setting</td>
                            <td style="text-align: left;">Value</td>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td style="text-align: right;">From Email</td>
                            <td><input class="text" type="text" name="settings[from_email]" id="from_email" value="<?php echo $this->settings->get('from_email') ?>" style="width: 95%;"/></td>
                        </tr>
                        <tr class="odd">
                            <td style="text-align: right;">From Name</td>
                            <td><input class="text" type="text" name="settings[from_name]" id="from_name" value="<?php echo $this->settings->get('from_name') ?>" style="width: 95%;"/></td>
                        </tr>
                        <tr>
                            <td style="text-align: right;">Site Title</td>
                            <td><input class="text" type="text" name="settings[site_title]" id="site_title" value="<?php echo $this->settings->get('site_title') ?>" style="width: 95%;"/></td>
                        </tr>
                        <tr class="odd">
                            <td style="text-align: right;">Email Footer</td>
                            <td><input class="text" type="text" name="settings[email_footer]" id="email_footer" value="<?php echo $this->settings->get('email_footer') ?>" style="width: 95%;"/></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input class="btn" type="submit" value="Save"/></td>
                        </tr>
                        </tbody>
                    </table>
                    <input type="hidden" name="saveEmailSettings" value="1"/>
                </form>
            </div>
        </div>
        <?php
        if ($this->uri->segment(3) != 'edit') {
            ?>
            <div class="content-box">
                <div class="box-header">
                    Email Templates
                </div>
                <div class="box-content">
                    <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
                        <thead>
                        <tr>
                            <td width="20">#</td>
                            <td style="text-align: left;">Template</td>
                            <td style="text-align: left;">Description</td>
                            <td style="text-align: left;" width="40">Actions</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        $templateCounter = 0;
                        foreach ($templates as $template) {
                            $templateCounter++;
                            ?>
                            <tr class="<?php echo ($templateCounter % 2 == 0) ? 'odd' : ''; ?>">
                                <td><?php echo $templateCounter ?></td>
                                <td><?php echo $template->getTemplateName() ?></td>
                                <td><?php echo $template->getTemplateDescription() ?></td>
                                <td><a class="btn" href="<?php echo site_url('admin/email_templates/edit/' . $template->getTemplateId()) ?>">Edit</a></td>
                            </tr>
                        <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php } else { ?>
            <div class="content-box">
                <div class="box-header">
                    Edit Template - <?php echo $template->getTemplateName() ?>
                    <a href="<?php echo site_url('admin/email_templates') ?>" class="box-action tiptip" title="Go Back">Back to Templates</a>
                </div>
                <div class="box-content">
                    <form action="<?php echo site_url('admin/email_templates/edit/' . $this->uri->segment(4)) ?>" method="post">
                        <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
                            <tbody>
                            <tr>
                                <td style="width: 150px; text-align: right;">Fields:</td>
                                <td style="padding-top: 7px;">
                                    <select name="field" id="field">
                                        <?php
                                        $fields = $template->getFields();
                                        foreach ($fields as $field) {
                                            ?>
                                            <option value="{<?php echo $field->getFieldCode() ?>}"><?php echo $field->getFieldName() ?></option>
                                        <?php
                                        }
                                        ?>
                                        <option value="{site_title}">Site Title</option>
                                        <option value="{login_url}">Login URL</option>
                                    </select>
                                    <input type="button" value="Add At Cursor" class="btn" style="margin-top: -2px;" id="addAtCursor"/>
                                </td>
                            </tr>
                            <tr>
                                <td style="text-align: right">Subject</td>
                                <td><input class="text" type="text" name="subject" id="subject" style="width: 98%;" value="<?php echo $template->getTemplateSubject() ?>"/></td>
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
                                <td><input class="btn" type="submit" value="Save"/></td>
                            </tr>
                            </tbody>
                        </table>
                    </form>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        // var template_editor = CKEDITOR.replace('body', {
        //     toolbar: 'Minimum'
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
        //add tag
        $("#addAtCursor").click(function () {
           // CKEDITOR.instances.body.insertText($("#field").val());
            tinymce.activeEditor.execCommand('mceInsertContent', false, $("#field").val());
        });
    });
</script>
<?php $this->load->view('global/footer'); ?>
