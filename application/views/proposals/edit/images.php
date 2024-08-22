<style>#accordion3 span.group_checker div.checker{margin-top:7px;position: absolute;
    left: 550px;}
    .ui-button.deleteIcon span.ui-button-text:before {margin-right: 0px;}
    .ui-button.notesIcon span.ui-button-text:before {margin-right: 0px;}
    .grey_b{background:#25aae1;border-bottom:none!important;}
    .ui-sortable-helper .group_checker{
        display:none!important;
    }
    .group_checker{
        display: block;
    }
    .close-accordion{
        padding: 0px 1px!important;
        margin-top: -2px;
        margin-left: 8px;
    }
        
</style>
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
<link rel="stylesheet" href="<?php echo site_url('/3rdparty/cropper/css/cropper.css') ?>">
<link rel="stylesheet" href="<?php echo site_url('/3rdparty/cropper/css/main.css') ?>">
<link rel="stylesheet" type="text/css" href="/static/css/jquery.fileuploader.css" media="all">
<table width="100%">
    <tr>
        <td width="50%" valign="top">
            <div id="editImages" style="<?php if(count($images)<1) {echo 'width:50%';} ?>">
                
                <div id="imageUploader">
                
                    <input accept="image/*" id="proposalImageUploader" type="file" name="files">
                    <p class="clearfix">
                        You can upload a maximum of <strong><?php echo IMAGE_UPLOAD_LIMIT; ?></strong>
                        
                    </p>
                </div>
                <div id="imageLimitReached">
                    <p>You have reached the image upload limit of
                        <strong><?php echo IMAGE_UPLOAD_LIMIT; ?></strong> images.</p>

                    <p>If you wish to add a new image, please remove one of the existing images
                        first.</p>
                </div>


                
                <!--

                <p class="clearfix text-center" style="margin-bottom: 8px;">
                    <span style="display: block;" class="clearfix"> <b>Note:</b> You can only upload JPEG and PNG images.</span>
                </p>


                <div id="imageLimitReached">
                    <p>You have reached the image upload limit of
                        <strong><?php echo IMAGE_UPLOAD_LIMIT; ?></strong> images.</p>

                    <p>If you wish to add a new image, please remove one of the existing images
                        first.</p>
                </div>

                <div id="imageUploader">
                    <p class="clearfix text-center">
                        <label> Files</label><input style="margin-top: 2px;" type="file" accept="image/*" name="images[]" id="image" multiple="multiple" class="required">
                    </p>

                    <p class="clearfix" style="text-align: center;">
                        <a class="btn update-button" id="uploadImage">
                            <i class="fa fa-fw fa-upload"></i>
                            Upload
                        </a>
                    </p>
                    <p class="imageUpdating" id="imageUploading">
                        Uploading <span id="imageUploadNum"></span> Image(s). Please Wait.
                        <br />
                        Uploaded <span id="imageUploadedNum"></span> of <span id="imageUploadedNum2"></span> Image(s).
                        <br />
                        <img src="/static/loading_animation.gif" />
                    </p>
                </div>

                <div style="padding: 10px; border: 0; text-align: center;">
                    <img src="" style="max-width: 300px; border: none;" id="imageUploadPreview" />
                </div>
                <div class="multipleImagePreview" style="display:none;width: 100%;border:1px solid #000;clear: both;display: table;">
                    
                </div>
                -->

            </div>

            <!-- In case of emergency
            <div style="padding: 10px; border-radius: 10px; border: 1px solid; text-align: center">
                <p>Image uploading is temporarily disabled due to a technical issue.</p>
                <p>It will available again shortly.</p>
            </div>
            -->

        </td>
        <td width="50%" valign="top" class="all_images_td" style="<?php if(count($images)<1) {echo 'display:none';} ?>">
            <div class="" style="padding: 0 0 0 20px;">
                

                
                <br />
                <div ><a href="#" id="select_image_all">All</a> / <a href="#" id="select_image_none">None</a></div>
                <div class="btn update-button groupAction tiptip groupActionsButton" title="Actions on selected Images" style="display:none;margin-right:5px;top:20px;right:0px;line-height: 25px;padding: 0 5px;position: absolute;border-radius: 2px;"
                    id="groupActionsButton">
                    <i class="fa fa-fw fa-check-square-o"></i> Group Actions
                    <div class="materialize groupActionsContainer" style="width:300px;top:27px;right:-2px; left: auto;">
                        <div class="collection groupActionItems">
                            <a href="JavaScript:void(0);" id="groupImageLayoutUpdate" class="collection-item iconLink">
                                <i class="fa fa-fw fa-picture-o"></i> Update Image Layout
                            </a>
                            <a href="JavaScript:void(0);" id="groupShowProposal" class="collection-item iconLink">
                            <i class="fa fa-fw fa-eye"></i> <i class="fa fa-fw fa-file-powerpoint-o"></i> Show in Proposal
                            </a>
                            <a href="JavaScript:void(0);" id="groupShowWorkOrder" class="collection-item iconLink">
                            <i class="fa fa-fw fa-eye"></i> <i class="fa fa-fw fa-file-word-o"></i> Show in Work Order
                            </a>
                            <a href="JavaScript:void(0);" id="groupRemoveProposal" class="collection-item iconLink">
                            <i class="fa fa-fw fa-eye-slash"></i> <i class="fa fa-fw fa-file-powerpoint-o"></i> Remove from Proposal
                            </a>
                            <a href="JavaScript:void(0);" id="groupRemoveWorkOrder" class="collection-item iconLink">
                                <i class="fa fa-fw fa-eye-slash"></i> <i class="fa fa-fw fa-file-word-o"></i> Remove from Work Order
                            </a>
                            
                            <a href="JavaScript:void(0);" id="groupImageDelete" class="collection-item iconLink">
                                <i class="fa fa-fw fa-trash"></i> Delete Images
                            </a>
                    
                        </div>
                    </div>
                </div>
                <hr style="margin-top:10px;" />
                <h4 style="text-align: center"><i class="fa fa-fw fa-image"></i> Images</h4>
                

                <div id="accordion3" style="margin-left:20px;width:95%!important">
                    <?php
                     $imageLayouts = array(
                        0 => '1 Image Per Page',
                        1 => '2 Images Per Page',
                        2 => '4 Images Per Page',
                    );

                    if (count($images)) {
                        foreach ($images as $image) {
                            ?>
                            
                            <div id="image_<?php echo $image->getImageId() ?>" class="image_div" >
                                <span class="group_checker"><input type="checkbox" id="checkbox_image_<?php echo $image->getImageId() ?>"  name="images" class="proposal_images" value="<?php echo $image->getImageId() ?>" style="float:left;"></span>
                                <h3>
                                    <a href="#"><span
                                                id="title_<?php echo $image->getImageId() ?>"><?php echo $image->getTitle() ?></span></a>
                                    <span title="Show In Work Order" class="superScript grey_b tiptip" id="header_span_workorder_<?php echo $image->getImageId() ?>" style="right: 72px;position: absolute;top: 7px;display:<?php echo ($image->getActivewo()) ? 'block' : 'none'; ?>">WO</span>
                                    <span title="Show In Proposal" class="superScript grey_b tiptip" id="header_span_proposal_<?php echo $image->getImageId() ?>" style="right: 105px;position: absolute;top: 7px;display:<?php echo ($image->getActive()) ? 'block' : 'none'; ?>">P</span>
                                    <span title="<?=$imageLayouts[$image->getImageLayout()];?>" class="superScript grey_b tiptip" id="header_span_image_<?php echo $image->getImageId() ?>" style="right: 35px;position: absolute;top: 7px;"><?=  ($image->getImageLayout()>1)?'4': $image->getImageLayout() +1;?> <i class="fa fa-fw fa-picture-o"></i></span>
                                    
                                    <a class="btn-delete close-accordion" href="#">&nbsp;</a>
                                </h3>

                                <form class="big update-title-form form-validated imgForm" style="padding: 2px 5px !important;">
                                    <div class="clearfix">
                                        <div style="width: 155px; float: left">
                                            <?php
                                            $file = $proposal->getUploadDir() . '/' . $image->getImage();
                                            if (!file_exists($file)) {
                                                echo 'There was an error with the file and it cannot be displayed.';
                                            } else {
                                                ?>
                                                <a href="<?php echo site_url('uploads/companies/' . $proposal->getClient()->getCompany()->getCompanyId() . '/proposals/' . $proposal->getProposalId() . '/' . $image->getImage() . '?' . rand(10000,
                                                        99999)) ?>" class="fancybox">
                                                    <img id="img_<?php echo $image->getImageId() ?>"
                                                         style="height: auto; width: 150px;"
                                                         src="<?php echo site_url('uploads/companies/' . $proposal->getClient()->getCompany()->getCompanyId() . '/proposals/' . $proposal->getProposalId() . '/' . $image->getImage() . '?' . rand(10000,99999)) ?>" alt="" title="Click to enlarge" class="tiptip">
                                                </a>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div style="width: 200px; float: left">
                                            <p class="clearfix" style="margin-top: 10px;">
                                                <label style="width: 40px; margin: 0 5px 0 0; line-height: 20px;">Title</label>
                                                <input type="text" name="title" class="required" style="width: 150px;"
                                                       id="title2_<?php echo $image->getImageId() ?>"
                                                       value="<?php echo $image->getTitle() ?>">
                                            </p>

                                            <p class="clearfix">
                                                <label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;"
                                                       for="active_<?php echo $image->getImageId() ?>">Proposal</label>
                                                <input type="checkbox" name="active"
                                                       id="active_<?php echo $image->getImageId() ?>" <?php echo ($image->getActive()) ? ' checked="checked"' : ''; ?>>
                                                <span class="clearfix"></span>
                                                <label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;"
                                                       for="activewo_<?php echo $image->getImageId() ?>">Work
                                                    Order</label>
                                                <input type="checkbox" name="active"
                                                       id="activewo_<?php echo $image->getImageId() ?>" <?php echo ($image->getActivewo()) ? ' checked="checked"' : ''; ?>>
                                                <div class="clearfix"></div>
                                                <?php
                                                    $imageLayouts = array(
                                                        0 => '1 Image Per Page',
                                                        1 => '2 Images Per Page',
                                                        2 => '4 Images Per Page',
                                                    );
                                                    echo form_dropdown('images_layout', $imageLayouts, $image->getImageLayout(),
                                                        'id="images_layout_'.$image->getImageId().'" style="float: left;"');
                                                    ?>
                                               
                                            </p>
                                                    

                                            <p id="updating_<?php echo $image->getImageId() ?>" class="imageUpdating"></p>
                                        </div>
                                    </div>
                                    <div class="clearfix">
                                        <div class="clearfix" style="padding: 10px 0 0;">
                                            <div style="width: 150px; float: left; text-align: center;">
                                                <a style="float: left; margin-left: 45px; font-size: 26px; color: #000;"
                                                   class="rotateImage rotateLeft tiptip"
                                                   rel="<?php echo $image->getImageId() ?>" title="Rotate Left"
                                                   href="#">
                                                    <i class="fa fa-fw fa-rotate-left"></i>
                                                </a>
                                                <a style="float: left; font-size: 26px; color: #000;" class="rotateImage rotateRight tiptip"
                                                   rel="<?php echo $image->getImageId() ?>" title="Rotate Right"
                                                   href="#">
                                                    <i class="fa fa-fw fa-rotate-right"></i>
                                                </a>
                                            </div>
                                            <div style="width: 205px; float: left">
                                                <p class="clearfix">
                                                    <a href="#" title="Delete" class="btn delete-image-button deleteIcon tiptip" data-delete-id="<?php echo $image->getImageId(); ?>" style="margin-right: 8px; margin-left: 10px;">
                                                        
                                                    </a>
                                                    <a href="#" title="Notes" class="btn image-notes notesIcon tiptip" id="notes-<?php echo $image->getImageId(); ?>" style="margin-right: 8px;"></a>
                                                    <a href="#" data-imageId="<?=$image->getImageId();?>" data-imagename="<?=$image->getImage();?>" data-imageurl="<?php echo site_url('uploads/companies/' . $proposal->getClient()->getCompany()->getCompanyId() . '/proposals/' . $proposal->getProposalId() . '/' . $image->getImage() . '?' . rand(10000,99999)) ?>" title="Edit Image" class="btn image-editor-btn editIcon tiptip" id="image-crop-<?php echo $image->getImageId(); ?>" style="margin-right: 8px;">
                                                        
                                                    </a>
                                                    <a href="#" class="btn update-image-button update-button saveIcon" data-image-id="<?php echo $image->getImageId(); ?>"  style="float:right">
                                                        Update
                                                    </a>
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <?php
                        }
                    }
                    ?>
                </div>
            </div>
            <div id="editImageNotes" title="Edit Image Notes">
                <textarea name="imageNotes" id="imageNotes" cols="30" rows="10"></textarea>
                <input type="hidden" name="editImageNotesId" id="editImageNotesId">

                <p>
                    <br>
                    *Note: The space below the image can vary depending on the image size. <br>
                    &nbsp; Please check the PDF after you add text to make sure it does not go over to the next page.
                </p>
            </div>
        </td>
    </tr>
</table>

<!--Delete Image-->
<div id="delete-images" title="Confirmation">
        <h3>Confirmation - Delete Images</h3>

        <p>This will delete a total of <strong><span id="deleteNum"></span></strong> Images.</p>
        <br/>
        <p>Are you sure that you want to proceed?</p>
    </div>

    <div id="delete-images-status" title="Confirmation">
        <h3>Confirmation - Delete Images</h3>

        <p id="deleteImagesStatus"></p>
    </div>

<!--Show In proposal-->
<div id="show-proposal-images" title="Confirmation">
        <h3>Confirmation - Show Images in Proposal</h3>

        <p>This will Show a total of <strong><span id="showProposalNum"></span></strong> Images.</p>
        <br/>
        <p>Are you sure that you want to proceed?</p>
    </div>

    <div id="show-proposal-images-status" title="Confirmation">
        <h3>Confirmation - Show Images</h3>

        <p id="showProposalImagesStatus"></p>
    </div>

    <!--Show In work Order-->
<div id="show-work-order-images" title="Confirmation">
        <h3>Confirmation - Show Images in Work Order</h3>

        <p>This will Show a total of <strong><span id="showWorkOrderNum"></span></strong> Images.</p>
        <br/>
        <p>Are you sure that you want to proceed?</p>
    </div>

    <div id="show-work-order-images-status" title="Confirmation">
        <h3>Confirmation - Show Images</h3>

        <p id="showWorkOrderImagesStatus"></p>
    </div>

<!--hide In proposal-->
<div id="hide-proposal-images" title="Confirmation">
        <h3>Confirmation - Remove Images in Proposal</h3>

        <p>This will Remove a total of <strong><span id="hideProposalNum"></span></strong> Images.</p>
        <br/>
        <p>Are you sure that you want to proceed?</p>
    </div>

    <div id="hide-proposal-images-status" title="Confirmation">
        <h3>Confirmation - Show Images</h3>

        <p id="hideProposalImagesStatus"></p>
    </div>

    <!--hide In work Order-->
<div id="hide-work-order-images" title="Confirmation">
        <h3>Confirmation - Remove Images in Work Order</h3>

        <p>This will Remove a total of <strong><span id="hideWorkOrderNum"></span></strong> Images.</p>
        <br/>
        <p>Are you sure that you want to proceed?</p>
    </div>

    <div id="hide-work-order-images-status" title="Confirmation">
        <h3>Confirmation - Remove Images</h3>

        <p id="hideWorkOrderImagesStatus"></p>
    </div>

    <div id="update_image_layout" title="Update Image layout">
        <h3>Update Image layout</h3>

        <span>Select Image Layout</span>
                    <?php
                   
                    echo form_dropdown('images_layout_popup', $imageLayouts, $proposal->getImagesLayout(),
                        'id="images_layout_popup" style="float: right;"');
                    ?>
        <br/>
         <p>This will Update a total of <strong><span id="updateImageLayoutNum"></span></strong> Images.</p>
        <br/>
        <p>Are you sure that you want to proceed?</p>
    </div>

    <div id="update-image-layout-status" title="Confirmation">
        <h3>Confirmation - Images Layout Updated</h3>

        <p id="updateLayoutImagesStatus"></p>
    </div>


    