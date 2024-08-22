<?php /** @var $proposal \models\Proposals */ ?>
<?php $this->load->view('global/header');

$activeItem = 'false';
$activeSelectedItem = 'false';
$email_permission = 1;
?>
<style>
    .hide_input_style2{box-shadow: none;border: 0px;background: transparent;}
    
    .hide_input_style2:focus{
        outline: none;
    }
    .mce-container.mce-panel.mce-floatpanel.mce-window.mce-in {
	z-index: 150000 !important;
}
.tox-tinymce-inline {
    z-index: 150000 !important;
}
.changed_upload_thumb{text-align: center;}
.changed_upload_thumb p{font-weight: bold;font-size: 11px;}
#imageUploader .fileuploader{margin-bottom: 0px;}
#proposalServiceImageUploader{z-index: 9999!important}
#proposalAddServiceImageUploader{z-index: 9999!important}
#proposalServiceMapImageUploader{z-index: 9999!important}
#proposalAddServiceMapImageUploader{z-index: 9999!important}
.ui-tabs .ui-tabs-panel{padding: 1em 0px;}
.add_service_next_btn{right: 563px;position: absolute;}

#addServiceTexts::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #fff;
}

#addServiceTexts::-webkit-scrollbar
{
	width: 6px;
	background-color: #ccc;
}

#addServiceTexts::-webkit-scrollbar-thumb
{
	background-color: #ccc;
}

.view_expired{
    color: red;
}


#editServiceTexts::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	background-color: #fff;
}

#editServiceTexts::-webkit-scrollbar
{
	width: 6px;
	background-color: #ccc;
}

#editServiceTexts::-webkit-scrollbar-thumb
{
	background-color: #ccc;
}
.ui-icon-closethick{
    background-position: -96px -126px;
}
.buttonInside {
    position: relative;
    margin-bottom: 10px;
    margin-right: 40px;
    float: left;
}
.send_proposal_to_field_div{
    position: relative;
    padding-left: 160px;
}
.buttonInside button{
  position:absolute;
  right: 10px;
  top: 0px;
  border:none;
  height:26px;
  width:35px;
  cursor: pointer;
  outline:none;
  text-align:center;
  font-weight:bold;
  padding:2px;
}
.send_proposal_to_field_td{
    width: 480px;
}
</style>
    <div id="content" class="clearfix" xmlns="http://www.w3.org/1999/html">
    <div class="widthfix clearfix relative">
    <h4 style="margin: -5px 0 5px 0; font-size: 13px;">
        <span style="display: block; float: left; width: 100px; color: #000; text-align: right; margin-right: 10px;">Project: </span>
        <span class="shadowz"><a class="tiptipright" href="<?php echo site_url('proposals/edit/' . $this->uri->segment(3) . '/basic_info') ?>" title="Edit Project Info"><?php echo $proposal->getProjectname() ?></a></span>
        <br/>
        <span style="display: block; float: left; width: 100px; color: #000; text-align: right; margin-right: 10px;">Contact: </span>
        <a class="tiptipright" title="Edit Contact" href="<?php echo site_url('clients/edit/' . $proposal->getClient()->getClientId() . '/' . $proposal->getProposalId()) ?>">
            <?php echo $proposal->getClient()->getFullName(); ?>
        </a>
        <br/>
        <span style="display: block; float: left; width: 100px; color: #000; text-align: right; margin-right: 10px;">Account: </span>
        <a class="tiptipright" title="Edit Account" href="<?php echo site_url('accounts/edit/' . $proposal->getClient()->getClientAccount()->getId()); ?>">
            <?php echo $proposal->getClient()->getClientAccount()->getName(); ?>
        </a>
    </h4>

    <?php
    if ($proposal->getLayout()) {
        $theLayout = $proposal->getLayout();
    }
    switch ($page) {
        /*
        * BASIC INFO
        */
    case 'basic_info':
        $this->load->view('proposals/edit/basic-info');
        break;
    /*
    * PROPOSAL ITEMS
    */
    case 'items':
    if (new_system($proposal->getCreated(false))) {
    ?>
        <div style="position: relative;">
            <?php if (help_box(25)) { ?>
                <div class="help center box-center tiptip" id="help_icon" title="Help"
                     style="top: -40px;"><?php help_box(25, true) ?></div>
            <?php } ?>
        </div>
        <div id="layout_options" style="width: 440px;" class="clearfix">

            <!--             <a class="btn right update-button" style="margin-left: 5px;" href="<?php echo site_url('proposals/edit/' . $proposal->getProposalId() . '/preview') ?>">Send / Preview</a> -->

            <a class="btn right ui-state-default" href="<?php echo site_url('proposals') ?>">
                <i class="fa fa-fw fa-chevron-circle-left"></i>
            </a>
           
            <a href="#" id="workorderpreview" class="btn right update-button" title="Preview your proposal"
            data-access-key="<?php echo $proposal->getAccessKey() ?>" data-val="<?=$proposal->getProposalId();?>" data-project-name="<?php echo $proposal->getProjectname() ?>" style="margin-right: 5px;">
               <i class="fa fa-fw fa-file-text"></i> Work Order
            </a>
            <a href="#" id="estimatepreview" class="btn right update-button" title="Preview Work Order"
               data-preview-url="<?php echo $proposalPreviewUrl->getUrl(); ?>" style="margin-right: 5px;">
               <i class="fa fa-fw fa-file-text"></i> Preview
            </a> 
            <?php
                $email_permission =1;
                if (!$proposal->inApprovalQueue()) {

                if ($account->requiresApproval()) {
                    // Check if we're above the approval limit
                    if ($account->getApprovalLimit() <= $proposal->getTotalPrice(true)) {
                        // Has it been approved already
                        if (!$proposal->hasBeenApproved()) {
                            $email_permission =0;
                        }
                    }
                }
                
                ?>
                
                <a href="#"
                   class="btn right update-button has_email_permission <?= $email_permission ?'send_proposal_email':'approval_proposal_email';?>" data-val="<?=$proposal->getProposalId();?>" data-client-id="<?=$proposal->getClient()->getClientId();?>" data-project-name="<?=$proposal->getProjectName();?>" data-client-name ="<?php echo $proposal->getClient()->getFullName(); ?>" title="Send your proposal" style="margin-right: 3px;">
                    <i class="fa fa-fw fa-envelope"></i> Send
                </a>
                <?php if ($account->isAdministrator() && $proposal->hasUnapprovedServices()) { ?>
                    <a href="<?php echo site_url('proposals/edit/' . $this->uri->segment(3) . '/approve') ?>"
                       class="btn right update-button tiptip" title="Approve this proposal">
                        <i class="fa fa-fw fa-check"></i> Approve
                    </a>
                    <a href="<?php echo site_url('proposals/declineProposal/' . $this->uri->segment(3)) ?>"
                   class="btn right red-button" title="Decline Proposal" style="margin-right: 3px;">Decline</a>
                <?php } ?>
            <?php } else { ?>

                <a href="<?php echo site_url('proposals/declineProposal/' . $this->uri->segment(3)) ?>"
                   class="btn right red-button" title="Decline Proposal" style="margin-right: 3px;">Decline</a>
                <a href="<?php echo site_url('proposals/edit/' . $this->uri->segment(3) . '/send') ?>"
                   class="btn right update-button" title="Send this proposal" style="margin-right: 3px;">Approve &
                    Send</a>
                <a href="<?php echo site_url('proposals/edit/' . $this->uri->segment(3) . '/approve') ?>"
                   class="btn right update-button" title="Approve this proposal" style="margin-right: 3px;">Approve</a>
            <?php } ?>
        </div>

        <style>
            /* New Proposal Edit Page */
            .ui-tabs-vertical > .ui-tabs-nav { float: left; width: 10%; margin-top: 2px;}
            .ui-tabs-vertical > .ui-tabs-nav li { clear: left; width: 100%; border-bottom-width: 1px !important; border-right-width: 0 !important;  }
            .ui-tabs-vertical > .ui-tabs-nav li a { display:block; width: 100%; height: 100%; padding: 20px 0; text-align: center; }
            .ui-tabs-vertical > .ui-tabs-nav li a i { font-size: px; margin-bottom: 5px; }
            .ui-tabs-vertical > .ui-tabs-nav li.ui-tabs-active { padding-bottom: 0; padding-right: .1em; border-right-width: 1px; }
            .ui-tabs-vertical > .ui-tabs-panel { float: right; width: 88%; padding: 5px 0;}

            #proposal-tabs { background: #f4f4f4; }
            #proposal-tabs .lefthalf { width: 47%; margin: 0 2px; }
            .content-box .box-content.padded, .padded {padding: 5px;}
            #proposal-tabs .righthalf { width: 51%; margin: 0 2px; }
            #proposal-tabs .selectOptions { width: 47%; margin: 0 1%; }
            #proposal-tabs #proposal_services .service.clearfix { width: 100%;}
            #proposal-tabs #proposal_services .service .service { width: 207px;}
            #proposal-tabs #proposal_services .actions { width: 168px; float: right;}

            #proposal_services > .service { padding: 0px; }
            /* #proposal-tabs #proposal_services .service.clearfix:has( .actions .hide_in_proposal){
                background:red!important;
            } */
            #proposal-tabs #proposal_services .hide_in_proposal {
                background-color: #f2f2f2;color: #7b7a7a;}
            #saveGeneralSettings { position: absolute; top: 3px; right: 2px; display: none; }
            .editProposal-customtext { width: 95%; }

            #editImages p,#editMapImages p { 
                padding: 10px;
                color: #444 !important;
                font-weight: bold;
                font-size: 1.1em;
            }
            #editImages,#editMapImages{
                position: relative;
                margin: auto;
                text-align: center;
                top: 20px; 
            }
            #imagesLayout { margin: 10px 0; }
            #saveImagesLayout { margin-top: -3px; float: right;}

            label.editedLabel { color: #25aae1; }

            span.includedTextCategory {float: right; margin: 7px 15px 0 0; font-size: 15px; }

            tr.customLayoutRow { display: none; }
            #attachmentsUploading {display: none; background: #25aae1; color: #fff; text-align: center; margin-top: 5px;}
            .attachmentUpdating, .imageUpdating {display: none; background: #25aae1; color: #fff; text-align: center; margin-top: 5px; padding: 5px; border-radius: 5px;}



        </style>

        <div class="clearfix">
            <?php if ($proposal->hasUnapprovedServices() && $proposal->getOwner()->requiresApproval()) { ?>
                <div class="materialize">
                    <div class="card-panel red darken-1 white-text center-align">
                        <p>
                            <i class="fa fa-fw fa-exclamation-triangle"></i>
                            This proposal needs approval before it will be visible to the contact
                            <i class="fa fa-fw fa-exclamation-triangle"></i>
                        </p>
                    </div>
                </div>
            <?php } ?>
        </div>

        <div class="clearfix">
            <div id="proposal-tabs">
                <ul>
                    <li>
                        <a href="#services">
                            <i class="fa fa-fw fa-list"></i><br />
                            Services
                        </a>
                    </li>
                    <li>
                        <span class="superScript" id="imageCounter"></span>
                        <a href="#images">
                            <i class="fa fa-fw fa-picture-o"></i><br />
                            Images
                        </a>
                    </li>
                    <li>
                        <span class="superScript " id="videoSettings"></span>
                        <a href="#videos">
                            <i class="fa fa-fw fa-video-camera"></i><br />
                            Videos
                        </a>
                    </li>
                    <li>
                        <span class="superScript " id="mapImageCounter"></span>
                        <a href="#maps">
                            <i class="fa fa-fw fa-map"></i><br />
                            Map
                        </a>
                    </li>
                    <?php
                        if($proposal->getCompanyId() == $account->getCompanyId()){
                    ?>
                            <li>
                                <a href="#settings">
                                    <i class="fa fa-fw fa-cog"></i><br />
                                    Settings
                                </a>
                            </li>
                    <?php
                        }else{
                    ?>
                        <li  style="cursor: not-allowed;">
                            <a href="#settings" style="pointer-events: none;">
                                <i class="fa fa-fw fa-cog"></i><br />
                                Settings
                            </a>
                        </li>

                    <?php
                        }
                    ?>

                    <li>
                        <a href="#docs">
                            <i class="fa fa-fw fa-file-text"></i><br />
                            Docs
                        </a>
                    </li>
                    <li>
                        <a href="#activity">
                            <i class="fa fa-fw fa-history"></i><br />
                            Activity
                        </a>
                    </li>
                    <li>
                        <a href="#proposalView">
                            <i class="fa fa-fw fa-envelope"></i><br />
                            Links
                        </a>
                    </li>
                    <!-- <li>
                        <a href="#events" onclick="get_events()">
                            <i class="fa fa-fw fa-calendar-check-o"></i><br />
                            Events
                        </a>
                    </li> -->
                </ul>
                <div id="services"><?php $this->load->view('proposals/edit/services'); ?></div>
                <div id="images"><?php $this->load->view('proposals/edit/images'); ?></div>
                <div id="videos"><?php $this->load->view('proposals/edit/videos'); ?></div>
                <div id="maps"><?php $this->load->view('proposals/edit/maps'); ?></div>
                <div id="settings"><?php $this->load->view('proposals/edit/settings'); ?></div>
                <div id="docs"><?php $this->load->view('proposals/edit/docs'); ?></div>
                <div id="activity"><?php $this->load->view('proposals/edit/activity'); ?></div>
                <div id="proposalView"><?php $this->load->view('proposals/edit/proposal_view'); ?></div>
                <!-- <div id="events"><?php //$this->load->view('proposals/edit/events'); ?></div> -->
            </div>
        </div>


        <script type="text/javascript" src="<?php echo base_url() ?>3rdparty/jquery.generateId.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>3rdparty/jquery.jeditable.ckeditor.js"></script>

        <div id="editPaymentTerm" title="Edit Payment Term">
            <form action="<?php echo site_url('account/setPaymentTerm/' . $this->uri->segment(3)) ?>" method="post"
                  id="editPaymentTermForm">
                <textarea name="paymentTermText" id="paymentTermText" cols="30" rows="10">
                    Testing This
                </textarea>
            </form>
        </div>
        <div id="editContractCopy" title="Edit Contract Copy">
            <form action="<?php echo site_url('account/setContractCopy/' . $this->uri->segment(3)) ?>" method="post"
                  id="editContractCopyForm">
                <textarea name="contractCopyText" id="contractCopyText" cols="30" rows="10">
                    Testing This
                </textarea>
            </form>
        </div>
        <div id="badService" title="No valid service selected">
            <p class="padded">No valid service selected! Please check your service selection and try again.</p>
        </div>
        <div id="snowError" title="Invalid Service Selected">
            <p class="padded">Proposals with snow removal services may not contain other service categories.</p>
        </div>
        <div id="badService2" title="No valid service found">
            <p class="padded">No valid service found! Please refresh the page and try again.</p>
        </div>
        <div id="confirmServiceDelete" title="Delete Service?">
            <p class="padded">Are you sure you want to delete the service from the proposal?</p>
        </div>
        <div id="confirmImageDelete" title="Delete Image?">
            <p class="padded">Are you sure you want to delete this image?</p>
        </div>
        <div id="confirmImageMoveToMaps" title="Move to Maps">
            <p class="padded">Are you sure you want to Move this image?</p>
        </div>
        <div id="confirmAttachmentDelete" title="Confirm Delete Attachment">
            <p class="padded">Are you sure you want to delete this attachment?</p>
        </div>
        <div id="confirmLinkDelete" title="Confirm Deletion">
            <p class="padded">Are you sure you want to delete this link?</p>
        </div>
        <div id="addService" title="Fine Tune and Customize Here6">
            <input type="hidden" name="addServiceId" id="addServiceId" value="0">
            <h4>Service Name: <span id="addServiceName" class="tiptip" title="Click to edit">Service Name Here</span>
            </h4>

            <div class="clearfix">
                <!-- <div id="addServiceTexts" class="serviceTexts" style="float: right; width: 660px;">

                </div> -->
                <div id="addServiceFields" class="serviceFields" style="float: left; width: 266px;">

                </div>

                <div id="add_service_tabs" style="float: right; width: 665px;">
                    

                        <div id="addServiceTexts" class="serviceTexts" style="float: right;max-height:500px;overflow-y:auto; width: 665px;scrollbar-width: thin;">

                        </div>
                    
                        <form id="add-text-to-proposal" action="">
                            <label style="display: none;">Add Text: &nbsp; </label>
                            <input type="text" name="addServiceAddField" id="addServiceAddField"
                                style="width: 435px; margin-top: 5px; display: none">
                            <a href="#" class="btn left addIcon" style="margin-top: 5px;margin-left: 250px;" id="addServiceAddFieldButton">Add New Text</a>
                        </form>
                </div>

            </div>
            
        </div>
        <div id="editService" title="Fine Tune and Customize Here8">
            <input type="hidden" name="editServiceId" id="editServiceId" value="0">
            <h4>Service Name: <span id="editServiceName" class="tiptip" title="Click to edit">Service Name Here</span>
            </h4>

            <div id="edit_service_tabs" style="float: left;width:930px ">
                    
                    <ul>
                        <li><a href="#tabs-1">Service Texts</a></li>
                        <li><a href="#tabs-3">Map [<span class="map_image_count"></span>]</a></li>
                        <li><a href="#tabs-2">Images [<span class="service_image_count"></span>]</a></li>
                        

                    </ul>
                    <div id="tabs-1">

                        <div class="clearfix">

                            


                            <div id="editServiceFields" class="serviceFields" style="float: left; width: 266px;position: relative;">

                            </div>
               


                
                            <div id="editServiceTexts" class="serviceTexts" style="float: right;max-height:500px;overflow-y:auto; width: 660px;scrollbar-width: thin;">

                            </div>
                            <form id="add-text-to-edit-proposal" action="" style="float: right; width: 660px;">
                                <label style="display: none;">Add More: &nbsp; </label>
                                <input type="text" name="editServiceAddField" id="editServiceAddField" style="width: 500px; display: none;">
                                <a href="#" id="editServiceAddFieldButton"  class="btn left addIcon editServiceAddText" style="margin-top: 5px;margin-left: 250px;">Add New Text</a>
                            </form>
                        </div>
                    
                      


                
                    <a href="JavaScript:void(0);" class="btn" style="margin-top: 10px;left: 10px;bottom: 3px;" id="duplicate_service"><i class="fa fw fa-files-o"></i> Duplicate</a>
                    <a href="JavaScript:void(0);" class="btn update-button saveIcon" style="margin-top: 10px;left: 100px;bottom: 3px;" id="editServiceCopyButton">Save</a>
                    
                </div>
                <div id="tabs-2" style="min-height: 250px;position:relative;padding-top:0px;">
                        <!-- <a href="JavaScript:void(0);" class="btn blue-button" style="position: absolute;right: 2px;">Delete All</a> -->
                        <div style="position: absolute;right: 200px;"><h4><i class="fa fa-fw fa-image"></i> Images</h4></div>
                        <div id="proposalServiceimageUploader" style="width: 50%;float:left;margin-top: 16px;" >
                            
                            <input accept="image/*" id="proposalServiceImageUploader" type="file" name="files" >
                            <div class="proposal_sevice_image_notes_div" style="display: block;padding-left: 15px;">
                                <label style="font-size: 16px;font-weight: bold;">Image Notes</label>
                                <div class="proposal_sevice_image_notes" style="padding-top: 10px;max-height: 150px;overflow-y: scroll;"></div>
                            </div>
                        </div>
                        
                        <div id="serviceImages" style="width: calc(50% - 5px);float:left;padding-top: 30px;padding-left: 5px;">

                        </div>

                </div>
                <div id="tabs-3" style="min-height: 250px;position:relative;padding-top:0px;">
                        <!-- <a href="JavaScript:void(0);" class="btn blue-button" style="position: absolute;right: 2px;">Delete All</a> -->
                        <div style="position: absolute;right: 200px;"><h4><i class="fa fa-fw fa-image"></i> Map</h4></div>
                        <div id="proposalServiceMapImageUploaderDiv" style="width: 50%;float:left;margin-top: 16px;" >
                            
                            <input accept="image/*" id="proposalServiceMapImageUploader" type="file" name="files" >
                            <div class="proposal_sevice_map_image_notes_div" style="display: block;padding-left: 15px;">
                                <label style="font-size: 16px;font-weight: bold;">Map Notes</label>
                                <div class="proposal_sevice_map_image_notes" style="padding-top: 10px;max-height: 150px;overflow-y: scroll;"></div>
                            </div>
                        </div>
                        
                        <div id="serviceMapImages" style="width: calc(50% - 5px);float:left;padding-top: 30px;padding-left: 5px;">

                        </div>

                </div>
            </div>
            

        </div>
    <?php
    } else
    {
    ?>
        <!--Start of items-->
        <div class="javascript_loaded">
        <div class="clearfix">
            <div class="content-box left lefthalf">
                <div class="box-header centered" style="font-size: 15px; background: #BBB;" id="build-proposal">Build Your
                    Proposal
                </div>
                <div class="box-content padded">
                    <div id="accordion">
                        <?php
                        $k = 0;
                        foreach ($items as $item) {
                            if (($this->session->flashdata('activeItem') == $item->getItemId())) {
                                $activeItem = $k;
                            }
                            ?>
                            <h3 class="item_<?php echo $item->getItemId() ?>"><a href="#"
                                                                                 class=""><?php echo $item->getItemName() ?></a><a
                                        class="btn-delete close-accordion" href="#">&nbsp;</a></h3>
                        <div class="item_<?php echo $item->getItemId() ?>">
                            <?php
                            echo form_open('proposals/edit/' . $this->uri->segment(3) . '/' . $this->uri->segment(4), array('class' => 'big form-item-' . $item->getItemId()));
                            $query = $this->em->createQuery('SELECT f FROM models\Fields f where f.item = ' . $item->getItemId() . ' order by f.ord');
                            $fields = $query->getResult();
                            foreach ($fields as $field) {
                                echo $field->getFieldHtml();
                            }
                            ?>
                            <p class="clearfix">
                                <label>&nbsp;</label>
                                <input type="hidden" name="action" value="add_item">
                                <input type="hidden" name="itemId" value="<?php echo $item->getItemId() ?>">
                                <input type="submit" class="btn" name="add_item" value="Add">
                                <?php
                                if (($item->getItemId() == 1)) {
                                    ?>
                                    &nbsp <a class="btn launchSealcoatCalculator tiptip"
                                             title="Launch SealCoating Calculator" type="button" rel="0">Calculator</a>
                                    <a class="btn launchSealcoatCalculator tiptip" title="Launch SealCoating Calculator"
                                       style="position: absolute; right: 9px; top: 65px; background: #ddd; border: 1px solid #ccc;"
                                       type="button" rel="0">Calc.</a>
                                    <?php
                                }
                                ?>
                            </p>
                            <input type="hidden" name="calculatorRequestToken" class="calculatorRequestToken">
                            <?php echo form_close(); ?>
                            </div><?php
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div class="content-box right righthalf">
                <div class="box-header centered"
                     style="font-size: 15px; padding-left: 60px; background: #000; color: #fff;">
                    Your Proposal
                    <a style="font-size: 13px;"
                       href="<?php echo site_url('proposals/edit/' . $this->uri->segment(3) . '/preview') ?>"
                       class="box-action update-button tiptip" title="Preview / Send your proposal">Preview / Send</a>
                </div>
                <div class="box-content padded dfdf">
                    <div id="accordion2">
                        <?php
                        $k = 0;
                        foreach ($proposalItems as $proposalItem) {
                            if (($this->session->flashdata('activeSelectedItem') == $proposalItem->getLinkId())) {
                                //                            $activeSelectedItem = $k;
                            }
                            $proposalItem->updateFields($this->em);
                            $fv = $proposalItem->getFieldsValues();
                            ?>
                            <div id="item_<?php echo $proposalItem->getLinkId() ?>">
                                <h3><a href="#"><?php
                                        //hackalicious - don't like this 100% but it works perfectly, for now.
                                        if ($proposalItem->getItem()->getItemId() == 11) {
                                            echo $proposalItem->getFieldValue('service_name');
                                        } else {
                                            echo $proposalItem->getItem()->getItemName();
                                        }
                                        if ($proposalItem->getItem()->getItemId() == 14) {
                                            ?>
                                            <span
                                                    class="area-name"><?php echo $proposalItem->getFieldValue('type'); ?></span>
                                            <?php
                                        } elseif ($proposalItem->getFieldValue('area')) {
                                            ?>
                                            <span
                                                    class="area-name"><?php echo (strlen($proposalItem->getFieldValue('area')) < 25) ? $proposalItem->getFieldValue('area') : substr($proposalItem->getFieldValue('area'), 0, 24) . '...'; ?></span>
                                            <?php
                                        }
                                        ?>
                                    </a><a class="btn-delete close-accordion" href="#">&nbsp;</a></h3>

                                <div>
                                    <?php
                                    echo form_open('proposals/edit/' . $this->uri->segment(3) . '/' . $this->uri->segment(4), array('id' => 'PIF_' . $proposalItem->getLinkId(), 'class' => 'big form-item-' . $proposalItem->getItem()->getItemId()));
                                    $query = $this->em->createQuery('SELECT f FROM models\Fields f where f.item = ' . $proposalItem->getItem()->getItemId() . ' order by f.ord');
                                    $fields = $query->getResult();
                                    foreach ($fv as $field_value) {
                                        $fv[$field_value->getField()->getFieldLabel()] = $field_value->getFieldValue();
                                    }
                                    foreach ($fields as $field) {
                                        echo $field->getFieldHtml($fv[$field->getFieldLabel()]);
                                    }
                                    ?><input type="hidden" name="action" value="edit_item"><input type="hidden"
                                                                                                  name="linkId"
                                                                                                  value="<?php echo $proposalItem->getLinkId() ?>"><input
                                            type="submit" name="edit_item" value="Save" class="btn submit"> &nbsp; <a
                                            href="<?php echo site_url('proposals/edit/' . $this->uri->segment(3) . '/items/delete/' . $proposalItem->getLinkId()) ?>"
                                            class="confirm btn">Delete</a>

                                    <?php
                                    if (($proposalItem->getItem()->getItemId() == 1)) {
                                        ?>
                                        &nbsp <a class="btn launchSealcoatCalculator tiptip"
                                                 title="Launch SealCoating Calculator" type="button" rel="0">Calculator</a>
                                        <?php
                                    }
                                    ?>
                                    <?php
                                    echo form_close();
                                    ?>
                                </div>
                            </div>
                            <?php
                            $k++;
                        }
                        ?>
                    </div>
                    <?php
                    if (!$k) {
                        ?>
                        <div class="padded centered">No items added. You can add more from the box on the left.</div><?php
                    }
                    ?>
                </div>
            </div>

        </div>
        <!--End of itmes-->
        <?php } ?>



        </div>


        </div>
    <?php
    break;
    /*
     * PREVIEW WORKORDER
     */
    case 'preview_workorder':
    ?>
        <div class="clearfix">
            <div class="content-box">
                <div class="box-header">Send Work Order</div>
                <div class="box-content padded">
                    <form action="<?php echo site_url('proposals/send_work_order/' . $proposal->getProposalId()) ?>" method="post">
                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <th style="text-align: left; padding-bottom: 10px;" width="510">Please chose send to options here:</th>
                                <th style="text-align: left; padding-bottom: 10px;">Add any other emails here. For more than one, separate by comma:</th>
                                <th>&nbsp;</th>
                            </tr>
                            <tr>
                                <td>
                                    <?php
                                    foreach ($workOrderRecipients as $recipient) {
                                        ?>
                                        <label class="nice-label" for="recipient_<?php echo $recipient->getRecipientId() ?>"><?php echo $recipient->getName() ?> <input type="checkbox" value="<?php echo $recipient->getEmail() ?>" name="recipients[<?php echo $recipient->getRecipientId() ?>]"
                                                                                                                                                                        id="recipient_<?php echo $recipient->getRecipientId() ?>"/></label>
                                        <?php
                                    }
                                    if (!count($workOrderRecipients)) {
                                        ?><p class="">No recipients found! Please add from <a href="<?php echo site_url('account/work_order_recipients') ?>">My Account > Work Order Recipients</a>.</p><?php
                                    }
                                    ?>
                                </td>
                                <td valign="top"><input class="text" style="width: 95%; margin-top: 5px;" type="text" name="additional_emails" id="additional_emails" placeholder="Add Emails Here"/></td>
                                <td valign="top"><input class="btn right" type="submit" value="Send"/></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
            <div class="content-box">

                <div class="box-header centered" style="font-size: 15px;">Preview Work Order</div>
                <div class="box-content relative clearfix">
                    <div style="float: right; margin: 10px;">
                        <a href="<?php echo site_url('proposals/live/download/work_order/' . $proposal->getAccessKey() . '.pdf') ?>" class="btn">Download Work Order</a>
                    </div>
                    <iframe id="preview-frame" name="preview" src="<?php echo site_url('proposals/live/view/work_order/' . $proposal->getAccessKey() . '.pdf') ?>" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    <?php
    break;
    /*
    * PREVIEW
    */
    case 'preview':
    ?>
        <div id="layout_options" class="clearfix">
            <a class="btn right" style="margin-left: 5px;" href="<?php echo site_url('proposals/edit/' . $this->uri->segment(3) . '/items') ?>">Back</a>
            <?php
            if (new_system($proposal->getCreated(false))) {
                ?>
                <a class="btn update-button right" style="margin-left: 5px;" href="<?php echo site_url('proposals/live/download/' . $theLayout . '/plproposal_' . $proposal->getAccessKey() . '.pdf') ?>">Download</a>
                <a class="btn update-button right" style="margin-left: 5px;" href="<?php echo site_url('proposals/edit/' . $proposal->getProposalId() . '/send/' . $theLayout) ?>">Send</a>
                <?php
            } else {
                ?>
                <a class="btn update-button right" style="margin-left: 5px;" href="<?php echo site_url('proposals/live/download/' . $theLayout . '/plproposal_' . $proposal->getAccessKey() . '.pdf') ?>">Download</a>
                <a class="btn update-button right" style="margin-left: 5px;" href="<?php echo site_url('proposals/edit/' . $proposal->getProposalId() . '/send/' . $theLayout) ?>">Send</a>
                <?php
            }
            ?>
        </div>
    <?php if ($account->getCompany()->getCompanyId() != 0) { ?>
        <div class="clearfix">
            <div class="content-box">
                <div class="box-header centered" style="font-size: 15px;">Preview Proposal</div>
                <div class="box-content relative clearfix">
                    <iframe id="proposal-preview-frame" name="preview" src="<?php echo site_url('proposals/live/preview/' . $theLayout . '/plproposal_' . $proposal->getAccessKey() . '.pdf') ?>" frameborder="0"></iframe>
                </div>
            </div>
        </div>
    <?php }

    break;
    case 'send':
    $layout = ($proposal->getLayout()) ? $proposal->getLayout() : $proposal->getClient()->getAccount()->getLayout();
    $search = array(
        '{proposal_url}', //1
        '{project_name}', //2
        '{client_first_name}', //3
        '{client_last_name}', //4
        '{client_company_name}', //5
        '{account_first_name}', //6
        '{account_last_name}', //7
        '{account_title}', //8
        '{account_cell_phone}', //9
        '{account_email}', //10
        '{company_website}', //11
        '{company_name}', //12
        '{site_title}', //13
        '{login_url}', //14
        '{proposal_link}', //15
        '{officePhone}', // 90
    );
    $client = $proposal->getClient();
    $account = $proposal->getOwner();

    // Format the office phone number for use
    $formattedOfficePhone = $account->getOfficePhoneExt() ? $account->getOfficePhone() . ' Ext ' . $account->getOfficePhoneExt() : $account->getOfficePhone();

    $replace = array(
        '<a href="' . site_url('proposals/live/view/' . $layout . '/plproposal_' . $proposal->getProposalId() . '.pdf') . '">' . $proposal->getProjectName() . ' Proposal</a>',
        $proposal->getProjectName(), //2
        $client->getFirstName(), //3
        $client->getLastName(), //4
        $client->getCompanyName(), //5
        $account->getFirstName(), //6
        $account->getLastName(), //7
        $account->getTitle(), //8
        $account->getCellPhone(), //9
        '<a href="mailto:' . $account->getEmail() . '">' . $account->getEmail() . '</a>', //10
        '<a target="_blank" href="' . $account->getCompany()->getCompanyWebsite() . '">' . $account->getCompany()->getCompanyWebsite() . '</a>', //11
        $account->getCompany()->getCompanyName(), //12
        $this->settings->get('site_title'), //13
        site_url('home/signin'), //14
        site_url('proposals/live/view/' . $layout . '/plproposal_' . $proposal->getProposalId() . '.pdf'), //15
        $formattedOfficePhone, // 90
    );
    $emailTemplate = $this->em->find('models\Email_templates', 11);
    echo form_open('proposals/edit/' . $this->uri->segment(3) . '/send/' . $this->uri->segment(5), array('class' => 'form-validated')) ?>
        <div id="send_proposal" class="clearfix">
            <div class="content-box">
                <div class="box-header">
                    Send Proposal
                    <a class="box-action" href="<?php echo site_url('proposals/edit/' . $this->uri->segment(3)) ?>">Back</a>
                </div>
                <div class="box-content">
                    <table cellpadding="0" cellspacing="0" border="0" class="boxed-table" width="100%">
                        <tbody>
                        <?php if ($proposal->inApprovalQueue()) { ?>
                            <tr>
                                <td><h4 style="text-align: center;">You are approving the proposal. Once sent, it will be automatically approved and the user will be notified by email.</h4></td>
                            </tr>
                        <?php } ?>
                        <tr class="odd">
                            <td>
                                <label>Email Template</label>

                                <p style="margin-bottom: 15px;">

                                    <select id="templateSelect">
                                        <?php
                                        foreach ($clientTemplates as $template) {
                                            /* @var $template \models\ClientEmailTemplate */
                                            ?>
                                            <option data-template-id="<?php echo $template->getTemplateId(); ?>"><?php echo str_replace('\'', '\\\'', $template->getTemplateName()); ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                    <?php
                                    if ($account->isAdministrator()) {
                                        ?>
                                        <!--
                                        <span style="float: right; margin-top: 8px;"><a href="<?php echo site_url('account/company_email_templates'); ?>">Edit Email Templates</a></span>
                                        -->
                                        <?php
                                    }
                                    ?>
                                </p>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <p class="clearfix">
                                    <label>To <span>*</span></label><input type="text" name="to" id="to" class="tiptip text required" title="Separate email addresses by commas" value="<?php echo $proposal->getClient()->getEmail(); ?>">
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="clearfix">
                                    <label>BCC </label><input type="text" name="bcc" id="bcc" class="tiptip text" title="Separate email addresses by commas *optional" value="">
                                </p>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <p class="clearfix">
                                    <label>Subject <span>*</span></label><input type="text" name="subject" id="subject" class="tiptip text required" title="Enter your subject" value="<?php echo $defaultSubject; //echo str_replace($search, $replace, $emailTemplate->getTemplateSubject());
                                    ?>">
                                </p>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <p class="clearfix">
                                    <label>Message <span>*</span></label>
                                </p>

                                <p class="clearfix">
                                    <textarea name="message" id="message" cols="30" rows="20" class="textarea required" style="width: 750px; clear: right;"><?php
                                        //echo str_replace($search, $replace, $emailTemplate->getTemplateBody());
                                        echo $defaultBody;
                                        ?></textarea>
                                </p>

                                <p class="clearfix">
                                    <label style="width: auto;">You will receive a carbon copy of this email automatically.</label>
                                </p>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <p class="clearfix">
                                    <input type="submit" name="send_email" value="Send" class="btn btn-lightblue">
                                </p>
                            </td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php echo form_close() ?>
        <?php
        break;
    }

    ?>

    <div id="imageProcessing" title="Confirmation">
        <div style="text-align: center">
            <p>
                Image Processing <br/>
                <img src="/static/loading.gif"/>
            </p>
            <br/>
            <p>Please wait a moment while the image is processed</p>
        </div>

    </div>

    <div id="textEditorOpen" title="Text Editor is Open">
        <p>You still have a text editor open.</p><br/>
        <p>Click <strong>Save Text</strong> to keep changes or <strong>Cancel</strong> to close without saving.</p><br/>
        <p>You will then be able to save the service.</p>
    </div>

    <div id="custom-message" title="Message"></div>

    <div id="privileges" title="Image Layouts">
        <p>We have multiple ways to display the images in the PDF proposal:</p>

        <h3>1 Image Per Page</h3>

        <p>Each image within the proposal will be presented on its own page, with the title and notes.</p>

        <p>&nbsp;</p>

        <h3>Style 2</h3>

        <p>Images within the proposal will be set up 2 on each page, one above, and one below.</p>

        <p>&nbsp;</p>

        <h3>Style 3</h3>

        <p>Images within the proposal will be set up 4 on each page, 2 on top and 2 on the bottom.</p>

        <p>&nbsp;</p>

        <p>Take note of the fact that if you put too many lines of notes on an image hte layout might get a bit messed up. When you have a large text make sure you preview the proposal to make sure the layout is not affected.</p>

        <p>The image layout does not affect the work order.</p>

        <p>&nbsp;</p>
    </div>
    <div id="notesSaved" title="Success!">
        <p class="clearfix">Notes Saved!</p>
    </div>

    <div id="unduplicateConfirm" title="Confirm">
        <p class="clearfix">Use this to create new separate proposal</p>
        <br/>
        <p>Continue?</p>
    </div>


    <!--Old System-->
    <?php if (!new_system($proposal->getCreated(false))) { ?>
        <div id="sealcoatCalculator" title="Sealcoating Calculator">
            <table class="calculator-table" width="100%" cellpadding="0" cellspacing="0">
                <tbody>
                <tr>
                    <td width="50%" class="head">
                        1. Enter Material Costs
                    </td>
                    <td class="head">Total Material Breakdown</td>
                </tr>
                <tr>
                    <td>
                        <label>Sealer Cost</label>
                        <input type="text" name="sealcoatSealerCost" id="sealcoatSealerCost" size="5" value="0" class="text-input">
                        <span>$ / Gal</span>
                    </td>
                    <td>
                        <label>Total Bulk Sealer</label>
                        <span><strong><span id="sealcoatSealerTotal">0.00</span> Gallons</strong></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Sand Cost</label>
                        <input type="text" name="sealcoatSandCost" id="sealcoatSandCost" size="5" value="0" class="text-input">
                        <span>$ / 100Lb</span>
                    </td>
                    <td>
                        <label>Water</label>
                        <span><strong><span id="sealcoatWaterTotal">0.00</span> Gallons</strong></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Additive Cost</label>
                        <input type="text" name="sealcoatAdditiveCost" id="sealcoatAdditiveCost" size="5" value="0" class="text-input">
                        <span>$ / Gal</span>
                    </td>
                    <td>
                        <label>Additive</label>
                        <span><strong><span id="sealcoatAdditiveTotal">0.00</span> Gallons</strong></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Spot Primer Cost</label>
                        <input type="text" name="sealcoatSpotPrimerCost" id="sealcoatSpotPrimerCost" size="5" value="0" class="text-input">
                        <span>$ / Gal</span></td>
                    <td>
                        <label>Spot Primer</label>
                        <span><strong><span id="sealcoatSpotPrimerTotal">0.00</span> Gallons</strong></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Labor Hourly Rate</label>
                        <input type="text" name="sealcoatHourlyCost" id="sealcoatHourlyCost" size="5" value="0" class="text-input">
                        <span>$ (+ all taxes + insurance)</span>
                    </td>
                    <td>
                        <label>Sand</label>
                        <span><strong><span id="sealcoatSandTotal">0.00</span> Lb / <span id="sealcoatSandTotalGal">0.00</span> Gal</strong></span>
                    </td>
                </tr>
                <tr>
                    <td class="head"> 2. Project Specifications</td>
                    <td>
                        <label>Total Project</label>
                        <span><strong><span id="sealcoatTotal">0.00</span> Gallons</strong></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Number of coats</label>
                        <select name="sealcoatCoats" id="sealcoatCoats" class="dont-uniform">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                        </select>
                    </td>
                    <td class="head">Project Costs</td>
                </tr>
                <tr>
                    <td>
                        <label>Area</label>
                        <input type="text" name="sealcoatArea" id="sealcoatArea" size="8" value="0" class="text-input">
                        <select name="sealcoatUnit" id="sealcoatUnit" class="dont-uniform">
                            <option value="yd">Sq. Yds.</option>
                            <option value="ft">Sq. Ft.</option>
                        </select>
                    </td>
                    <td>
                        <label>&nbsp;</label>
                        <label style="text-align: center;"><strong>Total Cost</strong></label>
                        <label style="text-align: center;"><strong>Cost/Unit</strong></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Application Rate</label>
                        <select class="apprate apprate1 dont-uniform" name="sealcoatApplicationRate" style="display: none;">
                            <option>0.10</option>
                            <option>0.11</option>
                            <option>0.12</option>
                            <option>0.13</option>
                            <option>0.14</option>
                            <option>0.15</option>
                            <option>0.16</option>
                            <option>0.17</option>
                            <option>0.18</option>
                            <option>0.19</option>
                            <option>0.20</option>
                            <option>0.21</option>
                            <option>0.22</option>
                        </select>
                        <select class="apprate apprate2 dont-uniform" name="sealcoatApplicationRate" style="display: inline-block; " id="sealcoatApplicationRate">
                            <option>0.010</option>
                            <option>0.011</option>
                            <option>0.012</option>
                            <option>0.013</option>
                            <option>0.014</option>
                            <option>0.015</option>
                            <option>0.016</option>
                            <option>0.017</option>
                            <option>0.018</option>
                            <option>0.019</option>
                            <option>0.02</option>
                            <option>0.021</option>
                            <option>0.022</option>
                        </select>
                        <span>Gal / <span id="sealCoatUnitValue2">Sq.Feet</span></span>
                    </td>
                    <td>
                        <label>Sealer Cost:</label>
                        <label style="text-align: center;"><strong>$<span id="sealcoatTotalSealerValue">0.00</span></strong></label>
                        <label style="text-align: center;"><strong>$<span id="sealcoatTotalSealerValuePerArea">0.00</span></strong></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>% of Water</label>
                        <select name="sealcoatWater" id="sealcoatWater" class="dont-uniform">
                            <option>0</option>
                            <option>5</option>
                            <option>10</option>
                            <option>15</option>
                            <option>20</option>
                            <option>25</option>
                            <option>30</option>
                            <option>35</option>
                            <option>40</option>
                            <option>45</option>
                            <option>50</option>
                        </select>
                    </td>
                    <td>
                        <label>Sand Cost:</label>
                        <label style="text-align: center;"><strong>$<span id="sealcoatTotalSandValue">0.00</span></strong></label>
                        <label style="text-align: center;"><strong>$<span id="sealcoatTotalSandValuePerArea">0.00</span></strong></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>% of Additive</label>
                        <select name="sealcoatAdditive" id="sealcoatAdditive" class="dont-uniform">
                            <option>0</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                        </select>
                    </td>
                    <td>
                        <label>Additive Cost:</label>
                        <label style="text-align: center;"><strong>$<span id="sealcoatTotalAdditiveValue">0.00</span></strong></label>
                        <label style="text-align: center;"><strong>$<span id="sealcoatTotalAdditiveValuePerArea">0.00</span></strong></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Spot Primer</label>
                        <input type="text" name="sealcoatSpotPrimerGal" id="sealcoatSpotPrimerGal" size="5" value="0" class="text-input">
                        <span>Gal</span>
                    </td>
                    <td>
                        <label>Spot Primer Cost</label>
                        <label style="text-align: center;"><strong>$<span id="sealcoatTotalSpotPrimerValue">0.00</span></strong></label>
                        <label style="text-align: center;"><strong>$<span id="sealcoatTotalSpotPrimerValuePerArea">0.00</span></strong></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Sand</label>
                        <select name="sealcoatSand" id="sealcoatSand" class="dont-uniform">
                            <option>0</option>
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                        </select> Lb / Gal
                    </td>
                    <td>
                        <label>Total Material Cost:</label>
                        <label style="text-align: center;"><strong>$<span id="sealcoatMaterialCost">0.00</span></strong></label>
                        <label style="text-align: center;"><strong>$<span id="sealcoatMaterialCostPerArea">0.00</span></strong></label>
                    </td>
                </tr>
                <tr>
                    <td class="head">3. Labor for Project</td>
                    <td class="">
                        <label>Total Labor Cost</label>
                        <label style="text-align: center;"><strong>$<span id="sealcoatLaborCost">0.00</span></strong></label>
                        <label style="text-align: center;"><strong>$<span id="sealcoatLaborCostPerArea">0.00</span></strong></label>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Trip Count</label>
                        <select name="sealcoatTrips" id="sealcoatTrips" class="dont-uniform">
                            <option>1</option>
                            <option>2</option>
                            <option>3</option>
                            <option>4</option>
                            <option>5</option>
                            <option>6</option>
                            <option>7</option>
                            <option>8</option>
                            <option>9</option>
                            <option>10</option>
                        </select>
                    </td>
                    <td class="grey2">
                        <label>Overhead+Profit</label>
                        <label style="text-align: center;"><strong>$<span id="sealcoatOverheadAndProffit">0.00</span></strong></label>
                        <label style="text-align: center;"><strong>$<span id="sealcoatOverheadAndProffitPerArea">0.00</span></strong></label>
                    </td>
                <tr>
                    <td>
                        <label>Men #</label>
                        <input type="text" name="sealcoatMen" id="sealcoatMen" size="5" value="0" class="text-input">
                    </td>
                    <td class="black">
                        <label>Total Project Cost:</label>
                        <label style="text-align: center;"><strong>$<span id="sealcoatTotalCost">0.00</span></strong></label>
                        <label style="text-align: center;"><strong>$<span id="sealcoatTotalCostPerArea">0.00</span></strong></label>
                    </td>
                <tr>
                    <td>
                        <label>Hours per Trip</label>
                        <input type="text" name="sealcoatTripHours" id="sealcoatTripHours" size="5" value="0" class="text-input">
                    </td>
                    <td class="last">
                    </td>
                <tr>
                    <td>
                        <label>Overhead</label>
                        <input type="text" name="sealcoatOverhead" id="sealcoatOverhead" size="5" value="0" class="text-input">
                        <span>$ / Trip</span>
                    </td>
                    <td></td>
                <tr>
                    <td class="last">
                        <label>Profit</label>
                        <input type="text" name="sealcoatProffit" id="sealcoatProffit" size="5" value="0" class="text-input">
                        <span>$ / Trip</span>
                    </td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        </div>
    <?php } ?>
    </div>
    </div>


    <div id="approval_email_template" style="display:none">
    <form id="approval_email_form">
    <table width="100%" cellpadding="0" style="font-size:14px;" cellspacing="0" border="0">
                            <tr>
                                <td>
                                    <div class="padded" style="float:left;text-align:left">
                                        <p>Please choose one or many from the list below to send your proposal for approval please!</p>

                                        <p>&nbsp;</p>

                                        <p><b>VIP</b>: After you send your proposal for approval, you will not be able to change/edit until it is approved. You will receive an email asap after the approval.</p>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="padded">
                                        <?php
                                        foreach ($recipients as $recipient) {
                                            ?>
                                            <label class="nice-label" for="recipient_<?php echo $recipient->accountId ?>"><?php echo $recipient->firstName . ' ' . $recipient->lastName; ?> <input type="checkbox" value="<?php echo $recipient->email ?>" class="approval_recipients" data-val="<?php echo $recipient->accountId ?>" name="recipients[<?php echo $recipient->accountId ?>]" id="recipient_<?php echo $recipient->accountId ?>"/></label>
                                        <?php
                                        }
                                        ?>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div class="padded">
                                        <p style="text-align:left">Message:</p>
                                        <textarea name="message"  class="approval_email_message" cols="30" rows="10" style="float:left;width: 50%; height: 70px;"></textarea>
                                    </div>
                                </td>
                            </tr>
                           
            </table>
            <span class="send_popup_validation_msg" style="display:none;float:right;font-size: 12px;font-weight: bold;padding: 0px 0px 8px 10px;text-align: left;color: #f00;">Please Fill all required fields.</span>
        </form>
</div>


<div id="estimatepreviewDialog" title="Preview Proposal" style="display:none;">
<p style="font-weight: bold;width: 700px;position: absolute;font-size: 14px;top: 3px;"><span style="position:absolute;"><span style="display: block; float: left;  color: #595959; text-align: left; margin-right: 10px;"><i class="fa fw fa-file-pdf-o"></i> Project: </span><span class="shadowz" style="float:left"><a class="dialog_project_name" href="#" ><?=$proposal->getProjectName();?></a></span></span><br/>
    <span style="position:absolute;left:0px;margin-top:3px" ><span style="display: block;float: left;margin-right:7px;  color: #595959; text-align: left; "><i class="fa fw fa-user"></i> Contact: </span><span style="float:left;"><a style="float:left"   href="#" class="dialog_project_contact_name"><?php echo $proposal->getClient()->getFullName(); ?></a></span></span></p>
<?php $url = $proposal->getProposalViewUrl(); ?>
<a href="javascript:void(0);"  class="btn right blue-button proposal_link_copy tiptip" title="Copy Proposal Link" style="margin-bottom: 5px;" >
        <i class="fa fa-fw fa-copy" ></i> Copy Link</a>
<a href="<?php echo $proposalPreviewUrl->getUrl(); ?>" target="_blank"   class="btn right blue-button tiptip" title="Customer View" >
    <i class="fa fa-fw fa-external-link"></i>Customer View</a>
<a href="<?php echo $proposalPreviewUrl->getUrl(); ?>/download" id="previewDialogDownloadBtn" download  class="btn right blue-button tiptip" title="Download your proposal" >
<i class="fa fa-fw fa-download"></i>Download</a>
<a href="JavaScript:void(0);" data-preview-url="<?php echo $proposalPreviewUrl->getUrl(); ?>/print" id="estimatepreviewPDF"   class="btn right blue-button tiptip" title="PDF/Print" >
<i class="fa fa-fw fa-download"></i>PDF/Print</a>
<a href="JavaScript:void(0);" data-preview-url="<?php echo $proposalPreviewUrl->getUrl(); ?>" id="estimatepreviewWEB"   class="btn right blue-button tiptip" title="Web Proposal" >
<i class="fa fa-fw fa-globe"></i>Web View</a>
<a href="#" class="btn tiptip right update-button <?= $email_permission ?'send_proposal_email':'approval_proposal_email';?> has_email_permission" data-val="<?=$proposal->getProposalId();?>" data-client-id="<?=$proposal->getClient()->getClientId();?>" data-project-name="<?=$proposal->getProjectName();?>" data-client-name ="<?php echo $proposal->getClient()->getFullName(); ?>" title="Send your proposal" style="margin-right: 3px;">
                    <i class="fa fa-fw fa-envelope"></i> Send
</a>
<div style="text-align: center;" id="loadingFrame">
            <br />
            <br />
            <br />
            <br />
            <p><img src="/static/blue-loader.svg"></p>
        </div>
        <iframe id="estimate-preview-iframe" style="width: 100%; height: 650px; margin-top: 10px; border-top: 1px solid #444;""></iframe>
       
</div>
<div id="send_work_order_template" style="display: none;">
                    <form >
                        <table style="margin-top:25px" width="100%" cellpadding="0" cellspacing="0" border="0">
                            <tr>
                                <th style="text-align: left; padding-bottom: 10px;font-size:14px" width="510">Please chose send to options here:</th>
                                <th   style="text-align: left; padding-bottom: 10px;font-size:14px">Add any other emails here. For more than one, separate by comma:</th>

                            </tr>
                            <tr>
                                <td>
                                    <?php

                                    if (!count($workOrderRecipients)) {
                                        ?><p class="">No recipients found! Please add from <a href="<?php echo site_url('account/work_order_recipients') ?>">My Account > Work Order Recipients</a>.</p><?php
                                    } else {
                                        foreach ($workOrderRecipients as $recipient) {
                                            ?>
                                            <label class="nice-label" for="recipient_<?php echo $recipient->getRecipientId() ?>"><?php echo $recipient->getName(); ?> <input type="checkbox" value="<?php echo $recipient->getEmail() ?>" class="work_order_recipients" data-val="<?php echo $recipient->getRecipientId() ?>" name="recipients[<?php echo $recipient->getRecipientId() ?>]" id="recipient_<?php echo $recipient->getRecipientId() ?>"/></label>
                                            <?php
                                        }
                                    }

                                    ?>
                                </td>
                                <td valign="top"><input  style="width: 95%; margin-top: 5px;" type="text" name="additional_emails" class="work_order_additional_emails text" placeholder="Add Emails Here"/></td>

                            </tr>
                        </table>
                    </form>
                    <span class="send_popup_validation_msg" style="display:none;float:right;font-size: 12px;font-weight: bold;padding: 0px 0px 8px 10px;text-align: left;color: #f00;">Please Fill all required fields.</span>
</div>

    <div id="LogoUploadEditor" title="Image Editor " style="display: none;height:auto;min-height: 96px;">
    
        <div class="docs-demo" style="float: left;width:750px">
            <div class="img-container-new">
                <img src="" alt="Picture">
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
        <div class="progress hidden" style="margin-bottom: 0px;">
        <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
        </div>
    
    
    </div>

<?php $this->load->view('proposals/edit/edit-js'); ?>
<?php $this->load->view('global/footer'); ?>
<script>

</script>