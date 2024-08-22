<style>#proposalMapImages span.group_checker div.checker{margin-top:7px;position: absolute;
    left: 550px;}
    
        
</style>
<link rel="stylesheet" type="text/css" href="/static/css/jquery.fileuploader.css" media="all">
<table width="100%">
    <tr>
        <td width="50%" valign="top">
            <div id="editMapImages" style="<?php if(count($mapImages)<1) {echo 'width:50%';} ?>">
                
                <div id="imageMapUploader">
                
                    <input accept="image/*" id="proposalMapImageUploader" type="file" name="files">
                    <p class="clearfix">
                        You can upload a maximum of <strong><?php echo MAP_IMAGE_UPLOAD_LIMIT; ?></strong>
                        
                    </p>
                </div>
                <div id="mapImageLimitReached">
                    <p>You have reached the map upload limit of
                        <strong><?php echo MAP_IMAGE_UPLOAD_LIMIT; ?></strong> maps.</p>

                    <p>If you wish to add a new maps, please remove one of the existing maps
                        first.</p>
                </div>



            </div>

            <!-- In case of emergency
            <div style="padding: 10px; border-radius: 10px; border: 1px solid; text-align: center">
                <p>Image uploading is temporarily disabled due to a technical issue.</p>
                <p>It will available again shortly.</p>
            </div>
            -->

        </td>
        <td width="50%" valign="top" class="all_map_images_td" style="<?php if(count($mapImages)<1) {echo 'display:none';} ?>">
            <div class="" style="padding: 0 0 0 20px;">
                

                
                <br />
                <div ><a href="#" id="select_image_all">All</a> / <a href="#" id="select_image_none">None</a></div>
                <div class="btn update-button groupAction tiptip groupActionsButton" title="Actions on selected Images" style="display:none;margin-right:5px;top:20px;right:0px;line-height: 25px;padding: 0 5px;position: absolute;border-radius: 2px;"
                    id="groupActionsButtonMap">
                    <i class="fa fa-fw fa-check-square-o"></i> Group Actions
                    <div class="materialize groupActionsContainerMap" style="width:300px;top:27px;right:-2px; left: auto;">
                        <div class="collection groupActionItems">
                            
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
                                <i class="fa fa-fw fa-trash"></i> Delete Maps
                            </a>
                    
                        </div>
                    </div>
                </div>
                <hr style="margin-top:10px;" />
                <h4 style="text-align: center"><i class="fa fa-fw fa-image"></i> Maps</h4>
                

                <div id="proposalMapImages" style="margin-left:20px;width:95%!important">
                    <?php
                    

                    if (count($mapImages)) {
                        foreach ($mapImages as $image) {
                            ?>
                            
                            <div id="image_<?php echo $image->getImageId() ?>" class="map_image_div" >
                                <span class="group_checker"><input type="checkbox" id="checkbox_image_<?php echo $image->getImageId() ?>"  name="images" class="proposal_images" value="<?php echo $image->getImageId() ?>" style="float:left;"></span>
                                <h3>
                                    <a href="#"><span
                                                id="title_<?php echo $image->getImageId() ?>"><?php echo $image->getTitle() ?></span></a>
                                    <span title="Show In Work Order" class="superScript grey_b tiptip" id="header_span_workorder_<?php echo $image->getImageId() ?>" style="right: 72px;position: absolute;top: 7px;display:<?php echo ($image->getActivewo()) ? 'block' : 'none'; ?>">WO</span>
                                    <span title="Show In Proposal" class="superScript grey_b tiptip" id="header_span_proposal_<?php echo $image->getImageId() ?>" style="right: 105px;position: absolute;top: 7px;display:<?php echo ($image->getActive()) ? 'block' : 'none'; ?>">P</span>
                                    
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
                                                         src="<?php echo site_url('uploads/companies/' . $proposal->getClient()->getCompany()->getCompanyId() . '/proposals/' . $proposal->getProposalId() . '/' . $image->getImage() . '?' . rand(10000,
                                                                 99999)) ?>" alt="" title="Click to enlarge"
                                                         class="tiptip">
                                                </a>
                                                <?php
                                            }
                                            ?>
                                        </div>
                                        <div style="width: 200px; float: left">
                                            <p class="clearfix" style="margin-top: 10px;">
                                                <label style="width: 32px; margin: 0 5px 0 0; line-height: 20px;">Title</label>
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
                                                <label style="margin: 0 5px 0 0; line-height: 20px;">Move Map To Service</label>
                                               <select name="select_service_map" class="select_service_map" id="select_service_map_<?=$image->getImageId();?>">
                                                    <option value="" selected>Select Service To Move</option>
                                                
                                                <?php
                                                    foreach ($proposal_services as $service) {
                                                        if(!in_array($service->getServiceId(),$mapServicesIds)){
                                                            echo '<option value="'.$service->getServiceId().'">'.$service->getServiceName().'</option>';
                                                        }else{
                                                            echo '<option disabled value="'.$service->getServiceId().'">'.$service->getServiceName().'</option>';
                                                        }
                                                    }
                                                    
                                                    ?>
                                               </select>
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
                                                    <a href="#" title="Notes" class="btn image-notes notesIcon tiptip" id="notes-<?php echo $image->getImageId(); ?>" style="margin-right: 8px;">
                                                        
                                                    </a>
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
            
        </td>
    </tr>
</table>
