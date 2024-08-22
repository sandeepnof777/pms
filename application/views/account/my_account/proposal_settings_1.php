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
<h3>
&nbsp;
<!-- <a href="<?php echo site_url('account/my_account/proposal_settings') ?>">Back</a> -->
</h3>
<form action="<?php echo site_url('account/company_proposal_settings') ?>" method="post" class="form-validated">

    <h3>Cool Layout Fonts</h3>

    <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">

        <tr>
            <td class="text-right"><h3 style="border-bottom: none;">Header Font</h3></td>
            <td>
                <select id="headerFont" name="header_font">
                    <?php
                    foreach ($fonts as $k => $font) {
                        ?>
                        <option value="<?php echo $k; ?>" style="font-family: '<?php echo $font; ?>'"<?php echo ($k == $company->getCoolHeaderFont() ? ' selected' : '') ?>><?php echo $font; ?></option>
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
                        <option value="<?php echo $k; ?>" style="font-family: '<?php echo $font; ?>'"<?php echo ($k == $company->getCoolTextFont() ? ' selected' : '') ?>><?php echo $font; ?></option>
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
            <td class="text-right"><h3 style="border-bottom: none;">Page 2 Header </h3></td>
            <td>
                <input tabindex="29" class="text trackChanges" type="text" name="pdfHeader" id="pdfHeader" style="width: 300px; margin-left: 0;" value="<?php echo $company->getPdfHeader() ?>"/> <input type="button" value="Choose Other" id="titleChoices" class="btn" style="margin-top: -2px;"/>
            </td>
        </tr>
        <tr>
            <td></td>
            <td><input type="submit" class="btn blue" name="save" value="Save"/></td>
        </tr>

    </table>

</form>
<script type="text/javascript" src="/3rdparty/ckeditor/ckeditor.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#titleChoices").click(function () {
            $("#choices").dialog('open');
            return false;
        });
        $(".choice").click(function () {
            var id = $(this).attr('rel');
            var text = $(id).html();
            $("#pdfHeader").val(text);
            $("#choices").dialog('close');
            return false;
        });
        $("#choices").dialog({
            modal: true,
            autoOpen: false,
            width: 450,
            buttons: {
                Cancel: function () {
                    $(this).dialog("close");
                }
            }
        });
    });
</script>
<div id="choices" title="PDF Page 2 Text Choices">
    <p class="clearfix"><span id="choice-1">Service Provider Information</span> <a class="btn choice" href="#" rel="#choice-1">Select</a></p>

    <p class="clearfix"><span id="choice-2">Your Pavement Contractor</span> <a class="btn choice" href="#" rel="#choice-2">Select</a></p>

    <p class="clearfix"><span id="choice-3">Contractor's Information</span> <a class="btn choice" href="#" rel="#choice-3">Select</a></p>

    <p class="clearfix"><span id="choice-4">Let Us Introduce You To:</span> <a class="btn choice" href="#" rel="#choice-4">Select</a></p>

    <p class="clearfix"><span id="choice-5">Our Company</span> <a class="btn choice" href="#" rel="#choice-5">Select</a></p>

    <p class="clearfix"><span id="choice-6">Welcome!</span> <a class="btn choice" href="#" rel="#choice-6">Select</a></p>
</div>