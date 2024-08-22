<h3>Edit Attachment
    <a href="<?php echo site_url('account/company_attachments') ?>">Back</a>
</h3>
<?php echo form_open('account/edit_attachment/' . $this->uri->segment(3), array('id' => 'fileUpload', 'class' => 'form-validated', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data')) ?>
    <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td width="50%">
                <p class="clearfix"><label>File Name</label><input class="text" type="text" name="fileName" id="fileName" value="<?php echo $attachment->getFileName() ?>"></p>

            </td>
        </tr>
        <tr class="even">
            <td>
                <p class="clearfix">
                    <label>Category</label><?php echo form_dropdown('category', array('admin' => 'Admin & Sales', 'marketing' => 'Marketing'), $attachment->getCategory()) ?>
                </p>
            </td>
        </tr>
        <tr class="even">
            <td>
                <p class="clearfix"><label>Add New File</label><input type="file" name="file" id="file"></p>
                <p class="clearfix" style="padding-left: 150px;line-height: 25px;font-size: 13px;font-weight:bold;">This will be updated in all Proposals. </p>
            </td>
        </tr>
        <tr>
            <td>
                <p>
                    <label for="include">Include Automatically</label>
                    <input type="checkbox" name="include" id="include" <?php if ($attachment->getInclude()) { echo 'checked="checked"'; } ?>>
                </p>
            </td>
        </tr>
        <tr class="even">
            <td>
                <p class="clearfix">
                    <label>&nbsp;</label><input type="submit" value="Save" name="save" class="btn blue">
                </p>
            </td>
        </tr>
    </table>
<?php echo form_close() ?>