<?php
$masterCheckDisplay = (count($proposal_videos) > 0) ? 'block' : 'none';
$noVideoDisplay = (count($proposal_videos) > 0) ? 'none' : 'block';
?>
<style>
    #accordion5 h3 {
        margin-left: 25px;
    }

    .group_checker .checker {
        margin-top: 7px;
    }

    #uniform-masterSelect {
        display: <?=$masterCheckDisplay;?>
    }

    #no_videos_section {
        display: <?=$noVideoDisplay;?>
    }

    .select2-container {
        width: 300px !important;
        margin-right: 15px;
    }
    .close-accordion span.ui-button-icon-primary {
        margin-top: -2px !important;
        margin-left: 0 !important;
        top: 1px !important;
        left: 2px !important;
    }
    .btn-delete.close-accordion{
        margin-top: 1px !important;
    }
</style>
<style>


    .image-area {
        position: relative; /* 16:9 */
        height: auto;
    }

    /* .image-area img { position: absolute; display: block; top: 0; left: 0; width: 100%; height: 100%; z-index: 20; cursor: pointer; } */
    .image-area:after {
        content: "";
        position: absolute;
        display: block;
        top: 45%;
        left: 45%;
        width: 46px;
        height: 36px;
        z-index: 30;
        cursor: pointer;
    }

    .image-area iframe {
        top: 0;
        left: 0;
        width: 100%;
        height: 212px;
    }

    /* image poster clicked, player class added using js */
    .image-area.player img {
        display: none;
    }

    .image-area.player {
        padding-bottom: 0;
        height: auto;
    }

    .image-area.player:after {
        display: none;
    }

    .proposalVideoImageUploaderDiv .fileuploader {
        margin: auto;
        margin-top: 15px;
        width: 90%;
        cursor: pointer;
        padding: 5px;
    }

    .play-overlay {
        position: absolute;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;
        height: 100%;
        width: 100%;
        opacity: 0;
        z-index: 999;
        transition: .3s ease;
        background-color: #0000005c;
    }

    .image-area .play-overlay {
        opacity: 1;
        cursor: pointer;
    }

    .play-icon {
        color: white !important;
        font-size: 80px;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        -ms-transform: translate(-50%, -50%);
        text-align: center;
    }

    .play-icon:hover {
        color: #25AAE1 !important;
    }


    .image-area img {
        max-width: 100%;
        width: 100%;
        height: auto;
    }

    .remove-image {
        display: none;
        position: absolute;
        top: 20px;
        right: 0px;
        z-index: 999;
        border-radius: 10em;
        padding: 2px 6px 3px;
        text-decoration: none;
        font: 700 21px/20px sans-serif;
        background: #555;
        border: 3px solid #fff;
        color: #FFF;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5), inset 0 2px 4px rgba(0, 0, 0, 0.3);
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        -webkit-transition: background 0.5s;
        transition: background 0.5s;
    }

    .remove-image:hover {
        color: #25AAE1;

    }

    .back-to-image {
        display: none;
        position: absolute;
        top: 20px;
        right: 0px;
        border-radius: 10em;
        padding: 2px 6px 3px;
        text-decoration: none;
        font: 700 14px/20px sans-serif;
        background: #555;
        border: 3px solid #fff;
        color: #FFF;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.5), inset 0 2px 4px rgba(0, 0, 0, 0.3);
        text-shadow: 0 1px 2px rgba(0, 0, 0, 0.5);
        -webkit-transition: background 0.5s;
        transition: background 0.5s;
    }

    .back-to-image:hover {
        color: #25AAE1;

    }

    #thumb-image-preview {
        margin-top: 15px;
    }

    #thumb-image-section {
        padding-top: 20px;
    }

    #removeVideo {
        margin-top: -4px;
    }

    #saveVideo {
        margin-top: -4px;
    }


    .playerIconColorDiv input[type="radio"]:checked + label span {
	 transform: scale(1.25);
}
.playerIconColorDiv input[type="radio"]:checked + label .red {
	 border: 2px solid #aa1a1a;
}

.playerIconColorDiv input[type="radio"]:checked + label .black {
	 border: 2px solid #747474;
}

.playerIconColorDiv input[type="radio"]:checked + label .white {
	 border: 2px solid #ced7d0;
}

.playerIconColorDiv input[type="radio"]:checked + label .blue {
	 border: 2px solid #1a82ac;
}

.playerIconColorDiv label {
	 display: inline-block;
	 width: 25px;
	 height: 25px;
	 margin-right: 10px;
	 cursor: pointer;
}
.playerIconColorDiv label:hover span {
	 transform: scale(1.25);
}
.playerIconColorDiv label span {
	 display: block;
	 width: 100%;
	 height: 100%;
	 transition: transform 0.2s ease-in-out;
}
.playerIconColorDiv .dont-uniform{
	 display: none;
}
.playerIconColorDiv label span.red {
	 background: #ff0000;
}

.playerIconColorDiv label span.black {
	 background: #000000;
}

.playerIconColorDiv label span.white {
	 background: #ffffff;
     border: 1px solid #030303;
}

.playerIconColorDiv label span.blue {
	 background: #25AAE1;
}


    
</style>
<div class="clearfix" style="padding-top: 15px;margin-bottom: 10px;">
    <div style="width: 150px;margin-left: 20px;float:left;margin-top: 7px;">

        <input type="checkbox" id="masterSelect">
        <div style="padding-top:2px;"><a href="#" id="select_video_all">All</a> / <a href="#" id="select_video_none">None</a>
        </div>
    </div>

    <div class="btn update-button groupVideoAction tiptip" title="Actions on selected Videos"
         style=" display: none;left: 224px;position: absolute;border-radius:2px"
         id="groupVideoActionsButton">
        <i class="fa fa-fw fa-check-square-o"></i> Group Actions
        <div class="materialize groupActionsContainer" style="width: 230px;top: 27px;left: -5px;">
            <div class="collection groupActionItems">
                <a href="JavaScript:void(0);" id="groupVideoDelete"
                   data-proposal-id="<?= $proposal->getProposalId(); ?>" class="collection-item iconLink">
                    <i class="fa fa-fw fa-trash"></i> Delete Videos
                </a>
                <a href="JavaScript:void(0);" id="groupVideoShowProposal" class="groupVideoShowProposal collection-item iconLink" data-visible-proposal="1"  data-proposal-id="<?= $proposal->getProposalId(); ?>">
                    <i class="fa fa-fw fa-eye"></i> <i class="fa fa-fw fa-file-powerpoint-o"></i> Show in Proposal
                </a>
                <a href="JavaScript:void(0);" id="groupVideoShowWorkOrder" class="groupVideoRemoveWorkOrder collection-item iconLink" data-visible-work-order="1" data-proposal-id="<?= $proposal->getProposalId(); ?>">
                    <i class="fa fa-fw fa-eye"></i> <i class="fa fa-fw fa-file-word-o"></i> Show in Work Order
                </a>
                <a href="JavaScript:void(0);" id="groupVideoRemoveProposal" class="groupVideoShowProposal collection-item iconLink" data-visible-proposal="0" data-proposal-id="<?= $proposal->getProposalId(); ?>">
                    <i class="fa fa-fw fa-eye-slash"></i> <i class="fa fa-fw fa-file-powerpoint-o"></i> Remove from Proposal
                </a>
                <a href="JavaScript:void(0);" id="groupVideoRemoveWorkOrder" class="groupVideoRemoveWorkOrder collection-item iconLink" data-visible-work-order="0"  data-proposal-id="<?= $proposal->getProposalId(); ?>">
                    <i class="fa fa-fw fa-eye-slash"></i> <i class="fa fa-fw fa-file-word-o"></i> Remove from Work Order
                </a>
                <a href="JavaScript:void(0);"  class="groupVideoEnableDisableLargePlayer collection-item iconLink" data-enable-large-player="1"  data-proposal-id="<?= $proposal->getProposalId(); ?>">
                    <i class="fa fa-fw fa fa-video-camera"></i> Enable Large Player
                </a>
                <a href="JavaScript:void(0);"  class="groupVideoEnableDisableLargePlayer collection-item iconLink" data-enable-large-player="0"  data-proposal-id="<?= $proposal->getProposalId(); ?>">
                    <i class="fa fa-fw fa fa-file-video-o"></i> Disable Large Player
                </a>
                <a href="JavaScript:void(0);" id="groupVideoShowPlayerIcon" class="groupVideoPlayerIcon collection-item iconLink" data-visible-player-icon="0"  data-proposal-id="<?= $proposal->getProposalId(); ?>">
                    <i class="fa fa-fw fa-eye"></i> Show Player Icon
                </a>
                <a href="JavaScript:void(0);" id="groupVideohidePlayerIcon" class="groupVideoPlayerIcon collection-item iconLink" data-visible-player-icon="1"  data-proposal-id="<?= $proposal->getProposalId(); ?>">
                    <i class="fa fa-fw fa-eye-slash"></i> Hide Player Icon
                </a>
            </div>
        </div>
    </div>
    <div style="float:left;margin-left: 220px;">
        <?php
        if (count($company_videos) > 0) {
            ?>
            <select id="company_video" class="dont-uniform select2_company_videos" name="company_videos[]" multiple>

                <optgroup label="Add New">
                    <option value="-1">Enter Video Url</option>
                </optgroup>
                <optgroup label="Video Library">


                    <?php
                    foreach ($company_videos as $video) {
                        echo '<option value="' . $video->getId() . '">' . $video->getTitle() . '</option>';
                    }
                    ?>
                </optgroup>
            </select>
            <a class="btn update-button saveIcon" style="float:right; margin-right: 20px;" id="saveCompanyVideo">Add
                Video</a>

        <?php } else { ?>
            <a class="btn update-button saveIcon" style="float:left;margin-left: 285px;" onclick="saveVideoUrl()">Add
                Video Link</a>
        <?php } ?>
        <!-- <label style="margin-right: 5px; margin-left: 22px; font-weight: bold;">Add Video URL</label>
        <input type="text" name="videoURL" id="videoURL" class="text" style="width: 385px; margin-right: 10px;">

        <a class="btn update-button saveIcon" style="float:right; margin-right: 20px;" id="saveVideo">Add Video</a>
        <span id="video_link_error_msg" style="margin-left: 128px;color:red;display:none"></span> -->
    </div>
</div>

<div id="no_videos_section" style="text-align: center;border: 1px solid #ccc;border-radius: 5px;height: 100px;"><h3
            style="margin-top: 40px;font-size: 14px;">No Proposal Videos. Add or select a video to get started.</h3>
</div>

<div id="accordion5" style="margin-left:20px;margin-top:10px;width:95%!important">
    <?php

    if (count($proposal_videos)) {
        foreach ($proposal_videos as $video) {
            $uploadDisplay = "block";
            $removeBtnDisplay = "none";
            $thumbImageDisplay = "block";
            $image_path = '';
            $url = $video->getVideoUrl();
            $finalUrl = '';
            $buttonShow = false;
            $companyThumbImage = false;

            if ($video->getCompanyVideoId() != 0 && $video->getCompanyCoverImage() != '') {
                $companyThumbImage = $video->getCompanyCoverImage();
            }

            if (strpos($url, 'facebook.com/') !== false) {
                //it is FB video
                $finalUrl .= 'https://www.facebook.com/plugins/video.php?href=' . rawurlencode($url) . '&show_text=1&width=200';
            } elseif (strpos($url, 'vimeo.com/') !== false) {
                //it is Vimeo video
                $videoId = explode("vimeo.com/", $url)[1];
                if (strpos($videoId, '&') !== false) {
                    $videoId = explode("&", $videoId)[0];
                }
                $finalUrl .= 'https://player.vimeo.com/video/' . $videoId;
            } elseif (strpos($url, 'youtube.com/') !== false) {
                if (strpos($video->getVideoUrl(), 'embed') > 0) {
                    $finalUrl = $video->getVideoUrl();
                } else {
                    //it is Youtube video
                    $videoId = explode("v=", $url)[1];
                    if (strpos($videoId, '&') !== false) {
                        $videoId = explode("&", $videoId)[0];
                    }
                    $finalUrl .= 'https://www.youtube.com/embed/' . $videoId;
                }
            } elseif (strpos($url, 'youtu.be/') !== false) {
                //it is Youtube video
                $videoId = explode("youtu.be/", $url)[1];
                if (strpos($videoId, '&') !== false) {
                    $videoId = explode("&", $videoId)[0];
                }
                $finalUrl .= 'https://www.youtube.com/embed/' . $videoId;
            } elseif (strpos($url, 'screencast.com/') !== false) {
                $finalUrl = $video->getVideoUrl();
            } elseif (strpos($video->getVideoUrl(), 'dropbox.com') !== false) {
                $finalUrl = str_replace('dl=0', 'raw=1', $video->getVideoUrl());
            } else {
                $buttonShow = true;
                $finalUrl = $video->getVideoUrl();
            }
            if ($video->getVideoUrl() == '') {
                $uploadDisplay = "none";
                $removeBtnDisplay = "block";
            }
            if ($video->getThumbnailImage() == '') {
                $thumbImageDisplay = "none";
            } else {
                $image_path = $proposal->getSitePathUploadDir() . '/' . $video->getThumbnailImage();
            }
            ?>

            <div id="video_<?php echo $video->getId() ?>" class="video_div">
                <span class="group_checker"><input type="checkbox" id="checkbox_video_<?php echo $video->getId() ?>"
                                                   name="videos" class="proposal_videos"
                                                   value="<?php echo $video->getId() ?>" style="float:left;"></span>
                <h3>
                    <a href="#"><span id="title_<?php echo $video->getId() ?>"><?php echo $video->getTitle() ?></span></a>
                    
                    <span title="Show In Work Order" class="superScript grey_b tiptip" id="video_header_span_workorder_<?php echo $video->getId() ?>" style="right: 40px;position: absolute;top: 8px;display:<?php echo ($video->getVisibleWorkOrder()) ? 'block' : 'none'; ?>">WO</span>
                    <span title="Show In Proposal" class="superScript grey_b tiptip" id="video_header_span_proposal_<?php echo $video->getId() ?>" style="right: 80px;position: absolute;top: 8px;display:<?php echo ($video->getVisibleProposal()) ? 'block' : 'none'; ?>">P</span>
                    <span title="Large Player" class="superScript grey_b tiptip" id="video_header_span_large_player_<?php echo $video->getId() ?>" style="right: 107px;position: absolute;top: 8px;display:<?php echo ($video->getIsLargePreview()) ? 'block' : 'none'; ?>">Large Player</span>
                    <span title="Intro Video" class="superScript grey_b tiptip intro_badge" id="video_header_span_is_intro_<?php echo $video->getId() ?>" style="right: 190px;position: absolute;top: 8px;display:<?php echo ($video->getIsIntro()) ? 'block' : 'none'; ?>">Intro</span>
                    <a class="btn-delete close-accordion" href="#">&nbsp;</a>
                </h3>


                <div class="clearfix" style="margin-left: 25px;">

                    <div class="video_left_section"
                         style="width: 310px;margin-top: 15px;float:left;margin-bottom: 15px;">
                        <div class="updateProposalVideoTitle" style="width: 310px;">
                            <label for="updateProposalVideoTitle"><b>Video Title: </b></label>
                            <input type="text" class="text videoLayoutSetting" id="videoTitle_<?php echo $video->getId() ?>"
                                   value="<?php echo $video->getTitle() ?>" maxlength="50" name="videoTitle">

                        </div>

                        <div style="width: 100%;position:relative;float:left;margin-top: 20px;display: grid;">
                            <label for=""><b>Video Setting: </b></label>
                            <p style="float: left;margin: 5px 0px 5px 13px;">
                                <input type="checkbox" class="is_intro videoLayoutSetting" data-video-id="<?php echo $video->getId() ?>" name="is_intro" id="is_intro_<?php echo $video->getId() ?>" <?php if ($video->getIsIntro()) { echo 'checked';} ?> ><span style="float: left;margin-top: 2px;width: 100px;">Intro Video</span>
                                <input type="checkbox" class="videoLayoutSetting" name="visible_proposal" id="visible_proposal_<?php echo $video->getId() ?>" <?php if ($video->getVisibleProposal()) { echo 'checked';} ?> <?php if ($video->getIsIntro()) { echo 'disabled';} ?>><span style="float: left;margin-top: 2px;width: 100px;">Proposal</span>
                            </p>
                            <p style="float: left;margin: 5px 0px 5px 13px;">
                                <input type="checkbox" class="videoLayoutSetting" name="is_large_preview" id="is_large_preview_<?php echo $video->getId() ?>" <?php if ($video->getIsLargePreview()) { echo 'checked'; } ?> <?php if ($video->getIsIntro()) { echo 'disabled';} ?> ><span style="float: left;margin-top: 2px;width: 100px;">Large Player</span>
                                <input type="checkbox" class="videoLayoutSetting" name="visible_work_order" id="visible_work_order_<?php echo $video->getId() ?>" <?php if ($video->getVisibleWorkOrder()) { echo 'checked';} ?> ><span style="float: left;margin-top: 2px;width: 100px;">Work Order</span>
                            </p>

                            
                        </div>

                        <?php 
                        $displayplayerIconDiv = ''; // Or whatever default value you want to assign

                        if (!$buttonShow) {
                            $display = 'block';
                            $displayplayerIconDiv = 'none';
                            if ($video->getThumbnailImage()) {
                                $display = 'none';
                                $displayplayerIconDiv = 'block';
                            }

                            if($companyThumbImage){
                                $displayplayerIconDiv = 'block';
                            }

                            ?>

                            <div class="is_video_added proposalVideoImageUploaderDiv"
                                 data-video-id="<?php echo $video->getId() ?>"
                                 style="width: 120px;float:left;display:<?= $display; ?>;">
                                <p style="margin-top: 15px;"><strong>Video Thumbnail</strong></p>
                                <input accept="image/*" class="proposalVideoThumbImageUploader" type="file" name="files"
                                       data-video-id="<?php echo $video->getId() ?>">
                            </div>
                        <?php } else {
                            echo '<div style="height:35px;"></div>';
                        } 
                        $icon_color = $video->getPlayerIconColor();
                        ?>
                        
                        <div class="playerIconDiv" data-video-id="<?php echo $video->getId() ?>" style="float:left;width: 100%;display:<?= $displayplayerIconDiv; ?>;">
                                <p style="margin-top: 15px;margin-bottom: 7px;"><strong>Player Icon</strong></p>
                                
                                <input type="checkbox" name="player_icon_hide" class="player_icon_hide videoLayoutSetting" data-video-id="<?php echo $video->getId() ?>" id="player_icon_hide<?php echo $video->getId() ?>" <?php if ($video->getPlayerIconHide()) { echo 'checked'; } ?>>Hide
                            </div>

                            <div class="playerIconColorDiv" data-video-id="<?php echo $video->getId() ?>" style="float:left;width: 100%;display:<?= $displayplayerIconDiv; ?>;">
                                <p style="margin-top: 15px;margin-bottom: 7px;"><strong>Player Icon Color</strong></p>
                                <input type="radio" class="dont-uniform " name="player_icon_color_<?php echo $video->getId() ?>" id="one_label_<?php echo $video->getId() ?>" value="0"  <?php if ($icon_color =='0') { echo 'checked'; } ?> />
                                <label data-color="0" for="one_label_<?php echo $video->getId() ?>"><span class="blue"></span></label>

                                <input type="radio" class="dont-uniform " name="player_icon_color_<?php echo $video->getId() ?>" id="two_label_<?php echo $video->getId() ?>" value="1" <?php if ($icon_color =='1') { echo 'checked'; } ?> />
                                <label data-color="1" for="two_label_<?php echo $video->getId() ?>"><span class="white"></span></label>

                                <input type="radio" class="dont-uniform " name="player_icon_color_<?php echo $video->getId() ?>" id="three_label_<?php echo $video->getId() ?>" value="2" <?php if ($icon_color =='2') { echo 'checked'; } ?> />
                                <label data-color="2" for="three_label_<?php echo $video->getId() ?>"><span class="black"></span></label>

                                <input type="radio" class="dont-uniform " name="player_icon_color_<?php echo $video->getId() ?>" id="four_label_<?php echo $video->getId() ?>" value="3" <?php if ($icon_color =='3') { echo 'checked'; } ?> />
                                <label data-color="3" for="four_label_<?php echo $video->getId() ?>"><span class="red"></span></label>

                            
                            </div>
                        
                        
                    </div>
                    <div class="video_right_section" style="width: 430px;float:left;margin-bottom: 15px;">

                        <div id="thumb-image-preview" class="is_video_added"
                             style="margin-left:5px;box-shadow: rgb(60 64 67 / 30%) 0px 1px 4px 0px;padding: 10px;float:left;width: 410px;">
                            <div id="image-area_<?php echo $video->getId() ?>" class="image-area"
                                 data-final-url="<?php echo $finalUrl; ?>" data-image-url="" data-video-id="<?php echo $video->getId() ?>"
                                 data-button-show="<?php if ($buttonShow) {
                                     echo 1;
                                 } else {
                                     echo 0;
                                 } ?>" data-company-video-id="<?= $video->getCompanyVideoId(); ?>"
                                 data-proposal-thumb-image="<?= $video->getThumbnailImage(); ?>">
                                <?php if ($video->getThumbnailImage() || $companyThumbImage) {
                                    if ($video->getThumbnailImage()) {
                                        $thumbImageURL = $proposal->getSitePathUploadDir() . '/' . $video->getThumbnailImage();
                                    } else {
                                        $thumbImageURL = $companyThumbImage;
                                    }

                                    ?>
                                    <img id="thumb_preview_img" src="<?= $thumbImageURL; ?>" style="">

                                    
                                    <?php 
                                        $playerIconDisplay = '';
                                        if ($video->getPlayerIconHide()) {
                                            $playerIconDisplay = 'hide';
                                        }
                                        
                                    ?>
                                    
                                        <div class="play-overlay <?= $playerIconDisplay;?>"  id="player_overlay<?php echo $video->getId() ?>">
                                            <a href="javascript:void(0)" class="play-icon">
                                            <img style="width: 70px;" src="<?php echo site_url('static\images').'\video-player-icon_'.$icon_color.'.png'; ?>">
                                            </a>
                                        </div>
                                    
                                    <?php if ($buttonShow) { ?>
                                        <!-- <a href="<?php echo $url; ?>" class="btn btn-primary" style="width:150px;" target="_blank">Proposal Video</a> -->
                                    <?php } else { ?>
                                        <!-- <iframe class="embed-responsive-item" src="<?php echo $finalUrl . '?autoplay=1'; ?>"
                                                                                    allowfullscreen loading="lazy" allow="autoplay"></iframe> -->
                                    <?php } ?>

                                <?php } else {
                                    if ($buttonShow) { ?>
                                        <a href="<?php echo $finalUrl; ?>" class="btn btn-primary"
                                           style="width:180px;margin-left: 90px;" target="_blank"><i
                                                    class="fa fa-fw fa-play-circle-o"></i>Play Proposal Video</a>
                                    <?php } else { ?>
                                        <iframe id="video-uploaded-iframe" class="embed-responsive-item"
                                                src="<?php echo $finalUrl; ?>" allowfullscreen loading="lazy"></iframe>
                                    <?php }
                                } ?>


                            </div>
                            <a class="remove-image tiptip" title="Delete thumb image"
                               onclick="remove_saved_thumb_image(<?php echo $video->getId() ?>)"
                               href="javascript:void(0)" style="display:<?= $thumbImageDisplay; ?>;">&#215;</a>
                            <a class="back-to-image" onclick="show_saved_thumb_image(this)" href="javascript:void(0)"><i
                                        class="fa fa-arrow-left"></i></a>

                        </div>
                        <div style="margin-top: 20px;float: left;width: 430px;">

                            <a href="#" class="deleteVideoUrl tiptip btn" title="Delete Video" style="float: left;"
                               data-video-id="<?php echo $video->getId() ?>"><i class="fa fa-fw fa-trash"></i>Delete
                                Video</a>

                            <a  href="javascript:void(0)" class="btn tiptip deleteThumbnail" data-video-id="<?php echo $video->getId() ?>" title="Delete thumb image" style="margin-left: 29px;font-size: 13px;float: left;display:<?= $thumbImageDisplay; ?>;"
                            onclick="remove_saved_thumb_image(<?php echo $video->getId() ?>)"><i class="fa fa-fw fa-trash"></i>Delete Thumbnail</a>
                            <a class="btn blue-button updateVideoTitle" data-video-id="<?php echo $video->getId() ?>"
                               style="float: right;"><i class="fa fa-fw fa-save"></i> Update Video</a>

                        </div>        
                    </div>


                </div>

            </div>
            <?php
        }
    }
    ?>
</div>
