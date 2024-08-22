<link rel="stylesheet" href="<?php echo site_url('/3rdparty/cropper/css/cropper.css') ?>">
<link rel="stylesheet" href="<?php echo site_url('/3rdparty/cropper/css/main.css') ?>">
<style>
.progress {
    float: left;
    width: 100%;
    height: 20px;
    margin-bottom: 10px;
    margin-top: 5px;
    overflow: hidden;
    background-color: #f5f5f5;
    border-radius: 4px;
    -webkit-box-shadow: inset 0 1px 2px rgb(0 0 0 / 10%);
    box-shadow: inset 0 1px 2px rgb(0 0 0 / 10%);
}

.progress-bar {
    float: left;
    width: 0%;
    height: 100%;
    font-size: 12px;
    line-height: 20px;
    color: #fff;
    text-align: center;
    background-color: #337ab7;
    -webkit-box-shadow: inset 0 -1px 0 rgb(0 0 0 / 15%);
    box-shadow: inset 0 -1px 0 rgb(0 0 0 / 15%);
    -webkit-transition: width .6s ease;
    -o-transition: width .6s ease;
    transition: width .6s ease;
}

.progress.hidden {
  opacity: 0;
  transition: opacity 1.3s;
}
</style>
<h3>
    &nbsp;
    <!-- <a href="<?php echo site_url('account/my_account') ?>">Back</a> -->
</h3>
<div class="left" style="width: 60%;">
    <div class="padded" style="padding-left: 20px;">
        <h4>Upload Instructions</h4>

        <p>This is where you set up a new logo so that it will be displayed throughout your proposal. Choose a file with your logo, it must be a <b>jpeg</b> or <b>png</b> file no larger than <b>500kb</b> in size. Once you click upload, you will see your logo appear. You also will be able to center, adust etc after you upload the logo.</p>
        <h4>Requirements &amp; Tips</h4>
        <ul class="bullets">
            <li>Please choose a logo with a white background, it looks better on our PDFs.</li>
            <li>Make sure that the quality of your logo is good, to ensure the first impression of your clients will not be a poor one.</li>
            <li>Adjust the logo so the width/height ratio will be 3:1. Example: 300x100 pixels or 600x200 pixels.</li>
        </ul>
        <?php
        $path = UPLOADPATH . '/clients/logos/';
        if ((file_exists($path . $company->getCompanyLogo()) || !is_file($path . $company->getCompanyLogo())) && 0) {
            ?>
            <h4>Adjustment Instructions</h4>
            <p>This is where you can adjust your logo so that it looks great. Click the Adjust Button to make any adjustment to your logo such as centering, making it larger, smaller etc. When oyu click adjust, please make certain that the logo fits inside of the visible box.</p>
            <p class="clearfix" style="text-align: center;">
                <a href="#" id="change_logo" class="btn">Click here to adjust!</a>
            </p>
        <?php } ?>
    </div>
</div>
<div class="left" style="width: 40%;">
    <div class="padded">
        <!-- <form id="changelogo_form" action="<?php echo site_url('account/company_logo') ?>" method="post" enctype="multipart/form-data">
            <p class="clearfix">
                <label style="font-weight: bold; display: block; text-align: center; margin: 0 auto 5px auto; float: none;">Logo File</label>
                <input type="file" name="clientLogo" id="clientLogo" class="required" style="display: block; margin: 0 auto; float: none;">
            </p>

            <p class="clearfix">
                <input class="btn blue" name="changeLogo" id="changeLogo" type="submit" value="Upload" style="display: block; margin: 5px auto 35px auto; float: none;">
            </p>
            <input type="hidden" name="change_logo" value="1">
        </form> -->
        <div class="container" style="margin-bottom: 40px;margin-top: 40px;">
    
    
            <label class="btn btn-primary btn-upload" style="margin-left: 41%;padding-left: 0.75rem;
  padding-right: 0.75rem;" for="inputImage" title="Upload image file">
                    <input type="file" class="sr-only" id="inputImage" name="file" accept="image/*">
                    <span class="docs-tooltip tiptip" style="border:0px;"  title="Upload Logo">
                    <span class="fa fa-upload"></span>
                    </span>
                </label>
            
        </div>
        <img style="width: 200px; height: auto; display: block; margin: 0 auto;" src="<?php echo site_url('account/getLogo'); ?>" alt="">
    </div>
</div>









  
  <!-- <div class="progress">
      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
    </div> -->



<div id="LogoUploadEditor" title="Logo Upload " style="display: none;height:auto;min-height: 96px;">
    
    <div class="docs-demo" style="float: left;width:750px">
        <div class="img-container">
        <img src="<?php echo UPLOADPATH; ?>images/picture.jpg" alt="Picture">
        </div>
    </div>
    
    <div style="float: left;width:100%">
        <a href="javascript:void(0)" class="btn right blue-button" id="imageCrop">Save</a>
        <a href="javascript:void(0)" class="btn left image_editor_action_btn tiptip" title="Rotate Left"  id="rotateLeft"><i class="fa fa-undo" aria-hidden="true"></i></a>
        <a href="javascript:void(0)" class="btn left image_editor_action_btn tiptip" title="Rotate Right" id="rotateRight"><i class="fa fa-repeat" aria-hidden="true"></i></a>
        <a href="javascript:void(0)" class="btn left image_editor_action_btn tiptip" title="Zoom In"  id="zoom_in"><i class="fa fa-search-plus" aria-hidden="true"></i></a>
        <a href="javascript:void(0)" class="btn left image_editor_action_btn tiptip" title="Zoom Out" id="zoom_out"><i class="fa fa-search-minus" aria-hidden="true"></i></a>
        <a href="javascript:void(0)" class="btn left image_editor_action_btn tiptip" title="Reset" id="image_reset"><i class="fa fa-refresh" aria-hidden="true"></i></a>
    </div>
    <div class="progress hidden">
      <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
    </div>
    <div class="docs-preview clearfix" style="width: 100%;">
        <p style="font-size: 16px;font-weight:bold">Preview:</h3>
        <div class="img-preview" style="width: 40%;height:auto;" ><img src="https://fengyuanchen.github.io/cropperjs/images/picture.jpg" alt="Picture"></div>
        
    </div>
    
</div>
<script src="<?php echo site_url('/3rdparty/cropper/js/cropper.js') ?>"></script>
<script src="<?php echo site_url('/3rdparty/cropper/js/main.js') ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#changelogo_form").submit(function () {
            $("#changeLogo").val('Please wait...');
        });
        
        $("#LogoUploadEditor").dialog({
          modal: true,
          autoOpen: false,
          width: 785,
          height:690,
          position: ['center'] 
      });
        
    });
</script>

