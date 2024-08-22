<!-- add a back button  -->
<h3>
&nbsp;
<!-- <a href="<?php echo site_url('account/my_account') ?>">Back</a> -->
</h3>
<form action="<?php echo site_url('account/company_legal2') ?>" method="post" class="form-validated">
    <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
        <tbody>
        <tr class="even">
            <td>
                <div class="clearfix">
                <textarea tabindex="61" name="paymentTermText" id="paymentTermText" class="trackChanges" cols="40" rows="10" style="width: 100%; clear: right;"><?php echo $company->getPaymentTermText() ?></textarea>
                </div>
                <p class="clearfix"><br>* Try to limit yourself to a couple paragraphs.</p>
            </td>
        </tr>
        <tr class="even">
            <td>
                <input type="submit" class="btn blue" name="save" value="Save"/>
            </td>
        </tr>
        </tbody>
    </table>
</form>

<script type="text/javascript">
    $(document).ready(function () {
        //CKEDITOR.replace('paymentTermText');
        tinymce.init({
                        selector: "textarea#paymentTermText",
                        menubar: false,
                        relative_urls : false,
                        elementpath: false,
                        remove_script_host : false,
                        convert_urls : true,
                        browser_spellcheck : true,
                        contextmenu :false,
                        paste_as_text: true,
                        height:'320',
                        plugins: "link image code lists paste preview ",
                        toolbar: tinyMceMenus.email,
                        forced_root_block_attrs: tinyMceMenus.root_attrs,
                        font_formats: 'Arial=arial,sans-serif;'+
                                    'Helvetica=helvetica;'+
                                    'Times New Roman=times new roman,times;'+
                                    'Verdana=verdana,geneva;',
                        fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
                });
    });
</script>