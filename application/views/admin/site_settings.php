<?php $this->load->view('global/header-admin'); ?>
    <div id="content" class="clearfix">
        <div class="widthfix">
            <?php echo form_open('admin/site_settings', array('class' => 'not-big form-validated update-company-form', 'id' => 'updateCompanyForm')) ?>
            <div class="content-box">
                <div class="box-header">
                    Site Settings
                    <a class="box-action" href="<?php echo site_url('admin') ?>">Back</a>
                    <a class="box-action update-button" href="#" onclick="$('#updateCompanyForm').submit(); return false;">Update</a>
                </div>
                <div class="box-content">
                    <table width="100%" border="0" cellpadding="0" cellspacing="0" class="boxed-table">
                        <tr class="even">
                            <td colspan="2">
                                <p class="clearfix">
                                    <label>Print Calculators Text</label>
                                    <span class="clearfix"></span>
                                    <textarea tabindex="10" name="print_text" id="print_text" cols="30" rows="3" style="width: 550px; clear: right;"><?php echo $settings['print_text'] ?></textarea>
                                </p>
                              
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        // CKEDITOR.replace('print_text', {
                                        //     toolbar:'Medium'
                                        // });
                                        tinymce.init({
                                            selector: "textarea#print_text",
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

                                    });
                                </script>
                            </td>
                        </tr>
                        <tr class="even">
                            <td colspan="2">
                                <p class="clearfix">
                                    <input type="hidden" name="save" value="save">
                                    <input type="submit" value="Update" name="updateCompany2" class="btn update-button" style="float: none; margin: 0 auto; display: block;">
                                </p>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <?php echo form_close(); ?>
        </div>
    </div>
    <!--#content-->
<?php $this->load->view('global/footer'); ?>