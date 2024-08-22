<?php
    $gradients = [
        '0',
        '0.1',
        '0.2',
        '0.3',
        '0.4',
        '0.5',
        '0.6',
        '0.7',
        '0.8',
        '0.9',
        '1'
    ];

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

<style>
    tr:nth-child(even) {
  background-color: #f2f2f2;
}
td:nth-child(even) {
  width: 70%;
}
td:nth-child(odd) {
  width: 30%;
}
.box-content .dataTables_wrapper tbody td, .nav-content td {
    border-top: 1px solid #D5D5D5 !important;
    border-bottom: 0px !important;
    border-right: 1px solid #D5D5D5 !important;
}
#uniform-select_background_image{margin-top:11px;}
#headerBgColorUndo .ui-button-text {
    padding: 2px;
}
#headerFontColorUndo .ui-button-text {
    padding: 2px;
}
</style>
<h3>
&nbsp;
<!-- <a href="<?php echo site_url('account/my_account/proposal_settings') ?>">Back</a> -->
</h3> 
<p style="padding: 20px;">You can use this section to change the cover page of your proposal. You can upload an image, change font, change background with text area as well as apply a gradient to the image.</p>
<form action="<?php echo site_url('account/company_proposal_settings6') ?>" id="company_proposal_settings6" enctype="multipart/form-data" method="post">
    <table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td class="text-right"><h3 style="border-bottom: none;">Background Image</h3></td>
                <td>
                    <select name="select_background_image"  class="select_background_image custom_setting" id="select_background_image">
                        <option value="" >Select Background</option>
                        <option value="1" data-val="<?php echo site_url('static/images/b1.jpg') ?>" <?php echo ('1' == $company->getProposalBackground() ? ' selected' : '') ?>>Background 1</option>
                        <option value="2" data-val="<?php echo site_url('static/images/b2.jpg') ?>" <?php echo ('2' == $company->getProposalBackground() ? ' selected' : '') ?>>Background 2</option>
                        <option value="3" data-val="<?php echo site_url('static/images/b3.jpg') ?>" <?php echo ('3' == $company->getProposalBackground() ? ' selected' : '') ?>>Background 3</option>
                        <option value="4" data-val="<?php echo site_url('static/images/b4.jpg') ?>" <?php echo ('4' == $company->getProposalBackground() ? ' selected' : '') ?>>Background 4</option>
                        <option value="0" <?php echo ('0' == $company->getProposalBackground() ? ' selected' : '') ?>>custom</option>
                    </select>
                    <input type="hidden" name="background_url" class="background_url">
                    <br/>
                    <p class="upload_image_p" style="position: relative;margin-top: 23px;display:none"><input type="file" id="gradientImage" name="gradientImage" style="margin-top: 6px;" /> <i class="fa fa-fw fa-info-circle tiptip" style="right: 0px;font-size: 17px;position: absolute;top: 10px;" title="Ideal image size is 820px width and 1060px.<br/>Images of other sizes will be scaled to fit."></i></p><br /><br />
                </td>
            </tr>
            <!-- <tr>
                <td></td>
                <td>
                    <p>Ideal image size is 820px width and 1060px.</p>
                    <p>Images of other sizes will be scaled to fit.</p>
                    <p><a href="/account/coverTemplate">Download Image Template Here</a></p>
                </td>
            </tr> -->
            <tr>
                <td class="text-right"><h3 style="border-bottom: none;">Background Image Opacity</h3></td>
                <td class="text-right">
                    <select id="imageOpacity" name="gradientOpacity" class="custom_setting">
                        <?php
                        foreach ($gradients as $gradient) {
                            ?>
                            <option value="<?php echo $gradient; ?>"<?php echo ($gradient == $company->getGradientOpacity() ? ' selected' : '') ?>><?php echo $gradient; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <td class="text-right"><h3 style="border-bottom: none;">Header Font</h3></td>
                <td>
                    <select id="headerFont" name="header_font" class="custom_setting">
                        <?php
                        foreach ($fonts as $k => $font) {
                            ?>
                            <option value="<?php echo $k; ?>" style="font-family: '<?php echo $font; ?>'"<?php echo ($k == $company->getHeaderFont() ? ' selected' : '') ?>><?php echo $font; ?></option>
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
                    <select id="textFont" name="text_font" class="custom_setting">
                        <?php
                        foreach ($fonts as $k => $font) {
                            ?>
                            <option value="<?php echo $k; ?>" style="font-family: '<?php echo $font; ?>'"<?php echo ($k == $company->getTextFont() ? ' selected' : '') ?>><?php echo $font; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                    <p id="exampleText" style="font-size: 14px; padding-top: 7px;">This is some example text.</p>
                    <i class="fa fa-fw fa-info-circle tiptip" style="right: 0px;font-size: 17px;margin-top: -16px;position: absolute;" title="<b>Note</b>Arial will not preview on a Mac/iPad.<br/>Helvetica will not preview on Windows.<br/>The correct font will be used in the PDF document"></i>
                   
                    
                </td>
            </tr>
            <tr>
                <td class="text-right"><h3 style="border-bottom: none;">Background Color</h3></td>
                <td>
                    <input id="headerBgColor" name="headerBgColor" class="jscolor custom_setting" value="<?php echo $company->getHeaderBgColor(); ?>" type="text" onchange="updateBgPreview(this.jscolor)" />
                    <a href="javascript:void(0)" class="btn"  id="headerBgColorUndo" style="margin-left: 10px;height: 20px;width: 20px;"><i class="fa fa-undo"></i></a>
                </td>
            </tr>
            <tr>
                <td class="text-right"><h3 style="border-bottom: none;">Text Color</h3></td>
                <td><input id="headerFontColor" name="headerFontColor" class="jscolor custom_setting" type="text" value="<?php echo $company->getHeaderFontColor(); ?>" onchange="updateHeadingPreview(this.jscolor)" />
                <a href="javascript:void(0)" class="btn" id="headerFontColorUndo" style="margin-left: 10px;height: 20px;width: 20px;"> <i class="fa fa-undo"></i></a>
                </td>
            </tr>
            <tr>
                <td class="text-right"><h3 style="border-bottom: none;">Show Logo</h3></td>
                <td><input type="radio" name="show_logo" class="show_logo" value="1" <?php echo ('1' == $company->getIsShowProposalLogo() ? ' checked' : '') ?>> Yes <input type="radio" name="show_logo" class="show_logo" value="0" <?php echo ('0' == $company->getIsShowProposalLogo() ? ' checked' : '') ?>> No</td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <p>
                        <button type="button" id="saveImage" name="saveImage" class="btn blue ui-button"><i class="fa fa-save"></i> Save Settings</button>
                        <button type="button" onclick="window.location.reload();"  class="btn ui-button"><i class="fa fa-close"></i> Cancel All</button>
                    </p>
                </td>
            </tr>
            <?php
                $previewDisplay = '';
                if (!file_exists($fileName = UPLOADPATH."/uploads/clients/logos/bg-" . $account->getCompany()->getCompanyId() . '.png')) {
                    $previewDisplay = 'display: none;';
                }
            ?>
                <tr id="previewContainer" style="<?php echo $previewDisplay; ?>">
                    <td class="text-right" style="vertical-align: text-top"><h3 style="border-bottom: none;">Preview</h3></td>
                    <td>
                        <div style="position: relative; width: 410px;">
                            <img id="currentImage" src="<?php echo UPLOADPATH; ?>/uploads/clients/logos/bg-<?php echo $account->getCompany()->getCompanyId(); ?>-orig.png?<?php echo time(); ?>" width="400px" height="530px" />
                            <h4 id="preview-heading" class="preview-heading" style="position: absolute; top: 110px; width: 66%; padding: 3px; left: 17%; text-align: center; border-radius: 5px;">Pavement Maintenance Proposal</h4>
                            <h4 id="preview-contact" class="preview-heading" style="position: absolute; top: 210px; width: 50%; padding: 3px; left: 25%; text-align: center; border-radius: 5px;">
                                <span style="font-size: 14px;" class="preview-heading">Contact Name</span><br />
                                <span style="font-size: 12px;" class="preview-heading">Company Name</span>
                            </h4>
                            <h4 id="preview-contact" class="preview-heading" style="position: absolute; top: 335px; width: 50%; padding: 3px; left: 25%; text-align: center; border-radius: 5px;">
                                <span style="display: block; font-size: 12px; padding-bottom: 10px;" class="preview-heading">Project:</span>
                                <span style="font-size: 13px;" class="preview-heading">Project Name</span><br />
                                <span style="font-size: 11px;" class="preview-heading"><span class="preview-text">Project Address</span></span>
                            </h4>
                            <?php
                          
                            if (file_exists(UPLOADPATH ."/uploads/clients/logos/logo-" . $account->getCompany()->getCompanyId() . '.jpg')) {
                            ?>
                            <img id="preview-logo" src="<?php echo UPLOADPATH; ?>/uploads/clients/logos/logo-<?php echo $account->getCompany()->getCompanyId() ?>.jpg" width="70px" style="position: absolute; bottom: 20px; right: 30px;" />
                            <?php
                            }
                            ?>
                        </div>
                    </td>
                </tr>
        </tbody>
</table>
</form>



<div id="imageProcessing" title="Confirmation">

    <div style="text-align: center">
        <p>
            Image Processing <br/>
            <img src="/static/loading.gif"/>
        </p>
        <br />
        <p>Please wait a moment while the image is processed</p>
    </div>

</div>

<script type="text/javascript">
var bgColor = new Array();
var textColor = new Array();
    $(document).ready(function() {
        $('#headerBgColorUndo').hide();
        $('#headerFontColorUndo').hide();
        bgColor.push('<?=$company->getHeaderBgColor();?>');
        
        textColor.push('<?=$company->getHeaderFontColor();?>')
        if(<?=$company->getIsShowProposalLogo();?>=='0'){
            $('#preview-logo').hide();
        }else{
            $('#preview-logo').show();
        }

        if($("#select_background_image").val()==0){
                $('.upload_image_p').show();
                //$("#previewContainer").hide();
        }else{
            console.log($("#select_background_image").find(':selected').attr('data-val'));
            $('.background_url').val($("#select_background_image").find(':selected').attr('data-val'));
            $('.background_image').val($("#select_background_image").val());
            
        }


        $("#imageOpacity").change(function(){
            $("#currentImage").css('opacity', $(this).val());
        });

        $("#saveImage").click(function() {
            customSettingsChanged = false;
           $("#imageProcessing").dialog('open');
           $("#company_proposal_settings6").submit();
            return true;
        });

        $("#imageProcessing").dialog({
            width: 400,
            modal: true,
            buttons: {
            },
            autoOpen: false
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#currentImage').attr('src', e.target.result);
                };

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#gradientImage").change(function(){
            readURL(this);
            $("#previewContainer").show();
        });

        

    });

    function updateBgPreview(jscolor) {
        var rgbColor = (jscolor.toRGBString());
        $(".preview-heading").css("background-color", rgbColor);
    }

    function updateHeadingPreview(jscolor) {
        var rgbColor = (jscolor.toRGBString());
        $(".preview-heading").css("color", rgbColor);
    }

    
    $("#select_background_image").change(function(){
            if($(this).val()==0){
                $('.upload_image_p').show();
                //$("#previewContainer").hide();
            }else{
                $('.upload_image_p').hide();
                $('#currentImage').attr('src', $(this).find(':selected').attr('data-val'));
                $('.background_url').val($(this).find(':selected').attr('data-val'));
                $("#previewContainer").show();
            }
            
    });

$('.show_logo').live('click', function () {
    if($(this).val()=='0'){
        $('#preview-logo').hide();
    }else{
        $('#preview-logo').show();
    }
    customSettingsChanged = true;
})

$('#headerBgColor').change(function () {
    console.log(bgColor)
    bgColor.push($(this).val());
    if(bgColor.length>1){
        $('#headerBgColorUndo').show();
    }else{
        $('#headerBgColorUndo').hide();
    }
    console.log(bgColor)
});

$('#headerFontColor').change(function () {

    textColor.push($(this).val());
    if(textColor.length>0){
        $('#headerFontColorUndo').show();
    }else{
        $('#headerFontColorUndo').hide();
    }
});

$('#headerBgColorUndo').click(function () {
    
    $('#headerBgColor').val(bgColor[bgColor.length-2]);
    $('#headerBgColor').css('background-color','#'+bgColor[bgColor.length-2])
    
    
    if(bgColor.length>1){
        bgColor.pop();
    }
    if(bgColor.length>1){
        $('#headerBgColorUndo').show();
    }else{
        
        $('#headerBgColorUndo').hide();
    }

});

$('#headerFontColorUndo').click(function () {
    $('#headerFontColor').val(textColor[textColor.length-2])
    $('#headerFontColor').css('background-color','#'+textColor[textColor.length-2])
    if(textColor.length>1){
        textColor.pop();
    }

    if(textColor.length>1){
        $('#headerFontColorUndo').show();
    }else{
        
        $('#headerFontColorUndo').hide();
    }

});

// Check for changed general settings
$(".custom_setting").change(function () {

    customSettingsChanged = true;

});



window.onbeforeunload = function () {
            if (customSettingsChanged) {
                return 'You have not saved your changes!';
            }
            return null;
        };
</script>
