<?php

$this->load->view('global/header');

?>
<div id="content" class="clearfix">
    <div class="widthfix">
        <div class="content-box">
            <div class="box-header">
                Edit Attachment
                <a class="box-action" href="<?php echo site_url('account/attatchments') ?>">Back</a>
            </div>
            <div class="box-content">
                <?php echo form_open('account/edit_attachment/' . $this->uri->segment(3), array('id' => 'fileUpload', 'class' => 'form-validated', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data')) ?>
                <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="50%">
                            <p class="clearfix"><label>File Name</label><input class="text" type="text" name="fileName" id="fileName" value="<?php echo $attachment->getFileName() ?>"></p>

                        </td>
                        <td>
                            <p class="clearfix">
                                <label>Category</label><?php echo form_dropdown('category', array('admin' => 'Admin & Sales', 'marketing' => 'Marketing'), $attachment->getCategory()) ?>
                            </p>
                        </td>
                    </tr>
                    <tr class="even">
                        <td>
                            <p class="clearfix">
                                <label>&nbsp;</label><input type="submit" value="Save" name="save" class="btn">
                            </p>
                        </td>
                        <td></td>
                    </tr>
                </table>
                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->load->view('global/footer');