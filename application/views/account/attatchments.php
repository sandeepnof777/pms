<?php $this->load->view('global/header'); ?>
<div id="content" class="clearfix">
    <div class="widthfix">
        <div class="content-box">
            <div class="box-header">
                Add Attatchment
                <a class="box-action" href="<?php echo site_url('account/my_account') ?>">Back</a>
            </div>
            <div class="box-content">
                <?php echo form_open('account/attatchments/', array('id' => 'fileUpload', 'class' => '', 'autocomplete' => 'off', 'enctype' => 'multipart/form-data')) ?>
                <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td width="50%">
                            <p class="clearfix"><label>File Name</label><input class="text" type="text" name="fileName" id="fileName" value="<?php echo $this->input->post('fileName') ?>"></p>
                        </td>
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
                        <td></td>
                    </tr>
                    <tr>
                        <td>
                            <p class="clearfix"><label>&nbsp;</label><input type="submit" value="Upload" name="upload" class="btn"></p>
                        </td>
                        <td></td>
                    </tr>
                </table>

                <?php echo form_close() ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        $("#fileUpload").submit(function () {
            $("#file_uploading").dialog('open');
        });
    });
</script>

<!--#content-->
<?php $this->load->view('global/footer'); ?>
