<!-- add a back button  -->
<h3>
&nbsp;
<!-- <a href="<?php echo site_url('account/my_account/proposal_settings') ?>">Back</a> -->
</h3>
<?php

$fonts = [
    'Arial, Helvetica, sans-serif' => 'Arial',
    'Helvetica, Arial, sans-serif' => 'Helvetica',
    'Georgia, serif' => 'Georgia',
    'Lato, sans-serif' => 'Lato',
    'Roboto, sans-serif' => 'Roboto',
    'Tahoma, sans-serif' => 'Tahoma',
    'Times New Roman, serif' => 'Times New Roman',
    'Trebuchet MS, sans-serif' => 'Trebuchet MS',
];
?>

<form action="<?php echo site_url('account/company_proposal_settings3') ?>" method="post" class="form-validated">

    <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td class="text-right"><h3 style="border-bottom: none;">Header Font</h3></td>
                <td>
                    <select id="headerFont" name="header_font">
                        <?php
                        foreach ($fonts as $k => $font) {
                            ?>
                            <option value="<?php echo $k; ?>" style="font-family: '<?php echo $font; ?>'"<?php echo ($k == $company->getStandardHeaderFont() ? ' selected' : '') ?>><?php echo $font; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <h4 id="exampleHeader" style="padding-left: 30px;">Example Header</h4>
                </td>
            </tr>
            <tr>
                <td class="text-right"><h3 style="border-bottom: none;">Body Font</h3></td>
                <td>
                    <select id="textFont" name="text_font">
                        <?php
                        foreach ($fonts as $k => $font) {
                            ?>
                            <option value="<?php echo $k; ?>" style="font-family: '<?php echo $font; ?>'"<?php echo ($k == $company->getStandardTextFont() ? ' selected' : '') ?>><?php echo $font; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <p id="exampleText" style="font-size: 14px; padding-top: 7px;">This is some example text.</p>
                    <p style="padding-top: 20px;"><strong>Note: </strong>Arial will not preview on a Mac/iPad, Helvetica will not preview on Windows.</p>
                    <p style="padding-top: 10px;">The correct font will be used in the PDF document</p>
                </td>
            </tr>
            <tr>
                <td class="text-right"><h3 style="border-bottom: none;">Intro Text</h3></td>
                <td>
                    <div class="clearfix">
                        <textarea tabindex="51" class="trackChanges" name="standardLayoutIntro" id="standardLayoutIntro" rows="5"><?php echo $company->getStandardLayoutIntro() ?></textarea>
                    </div>
                    <p class="clearfix"><br>* Try to limit yourself to a couple paragraphs.</p>
                </td>
            </tr>
            <tr class="even">
                <td></td>
                <td>
                    <input type="submit" class="btn blue" name="save" value="Save"/>
                </td>
            </tr>
        </tbody>
    </table>


</form>

<script type="text/javascript">
    $(document).ready(function () {
        //CKEDITOR.replace('standardLayoutIntro');
        tinymce.init({
                        selector: "textarea#standardLayoutIntro",
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
                        font_formats: 'Arial=arial,sans-serif;'+
                                    'Helvetica=helvetica;'+
                                    'Times New Roman=times new roman,times;'+
                                    'Verdana=verdana,geneva;',
                        fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
                });

    });
</script>