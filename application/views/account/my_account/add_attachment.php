<h3>Add Attachment
    <a href="<?php echo site_url('account/company_attachments') ?>">Back</a>
</h3>
<?php echo form_open('account/company_add_attachment', array('id' => 'fileUpload', 'class' => 'form-validated', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data')) ?>
    <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td>
                <p class="clearfix"><label>File Name</label><input class="text required" type="text" name="fileName" id="fileName" value="<?php echo $this->session->flashdata('fileName') ?>"></p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="clearfix">
                    <label>Category</label><?php echo form_dropdown('category', array('admin' => 'Admin & Sales', 'marketing' => 'Marketing'), 'admin') ?>
                </p>
            </td>
        </tr>
        <tr class="even">
            <td>
                <p class="clearfix"><label>File</label><input type="file" name="file" id="file"></p>
            </td>
        </tr>
        <tr>
            <td>
                <p>
                    <label for="include">Include Automatically</label>
                    <input type="checkbox" name="include" id="include" checked="checked">
                </p>
            </td>
        </tr>
        <tr>
            <td>
                <p class="clearfix"><label>&nbsp;</label><input type="submit" value="Upload" name="upload" class="btn blue"></p>
            </td>
        </tr>
    </table>

<?php echo form_close() ?>