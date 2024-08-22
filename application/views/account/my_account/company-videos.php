<?php 
$masterCheckDisplay = (count($company_videos)>0)?'visible':'hidden';
$noVideosDisplay = (count($company_videos)>0)?'none':'block';   
?>
<style>
    #accordion5 h4{margin-left: 25px;}
    #accordion5 h4 span{color: #665874;}
    #accordion5 h4.ui-state-active span{
    color: #ffffff!important;}
    .group_checker .checker{margin-top: 7px;}
    #accordion5 h3{
        padding:0;
    }
    #uniform-masterSelect{visibility:<?=$masterCheckDisplay;?>}
    #no_videos_section{display:<?=$noVideosDisplay;?>}
    
.image-area { position: relative;  /* 16:9 */ height: auto; }
/* .image-area img { position: absolute; display: block; top: 0; left: 0; width: 100%; height: 100%; z-index: 20; cursor: pointer; } */
.image-area:after { content: ""; position: absolute; display: block;  
    top: 45%; left: 45%; width: 46px; height: 36px; z-index: 30; cursor: pointer; } 
.image-area iframe {  top: 0; left: 0; width: 100%;height: 212px; }

/* image poster clicked, player class added using js */
.image-area.player img { display: none; }
.image-area.player{padding-bottom: 0;height: auto;}
.image-area.player:after { display: none; }
.changed_upload_thumb{text-align: center;}
.changed_upload_thumb p{font-weight: bold;font-size: 11px;}
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

.image-area:hover .play-overlay {
  opacity: 1;
}

.play-icon {
  color: white!important;
  font-size: 100px;
  position: absolute;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  -ms-transform: translate(-50%, -50%);
  text-align: center;
}



.image-area img{
  max-width: 100%;
  height: auto;
}
.remove-image {
display: none;
z-index: 999;
position: absolute;
top: 20px;
right: 0px;
border-radius: 10em;
padding: 2px 6px 3px;
text-decoration: none;
font: 700 21px/20px sans-serif;
background: #555;
border: 3px solid #fff;
color: #FFF;
box-shadow: 0 2px 6px rgba(0,0,0,0.5), inset 0 2px 4px rgba(0,0,0,0.3);
  text-shadow: 0 1px 2px rgba(0,0,0,0.5);
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
box-shadow: 0 2px 6px rgba(0,0,0,0.5), inset 0 2px 4px rgba(0,0,0,0.3);
  text-shadow: 0 1px 2px rgba(0,0,0,0.5);
  -webkit-transition: background 0.5s;
  transition: background 0.5s;
}
.back-to-image:hover {
    color: #25AAE1;
    
}
#thumb-image-preview{margin-top: 15px;}
#thumb-image-section{padding-top: 20px;}
#removeVideo{margin-top:-4px;}
#saveVideo{margin-top:-4px;}
</style>
<link rel="stylesheet" type="text/css" href="/static/css/jquery.fileuploader.css" media="all">
<div class="clearfix" style="padding-top: 15px;margin-bottom: 10px;">
        <div style="margin-left: 10px;float:left;margin-top: 7px;">

        <input type="checkbox" id="masterSelect" >
        </div>

        <div id="groupVideoActionsButton" class="btn update-button groupVideoAction tiptip" title="Actions on selected Videos" style="display: none;position: absolute; float: left; left: 38px;">
            <i class="fa fa-fw fa-check-square-o"></i> Group Actions
            <div class="materialize groupActionsContainer" style="width: 200px;top: 27px;left: -5px;">
                <div class="collection groupActionItems">
                    <a href="JavaScript:void(0);" id="groupVideoDelete" data-company-id="<?= $company->getCompanyId();?>" class="collection-item iconLink">
                        <i class="fa fa-fw fa-trash"></i> Delete Videos
                    </a>
                </div>
            </div>
        </div> 
    <div style="float:left">   
    
    <a class="btn update-button saveIcon" style="float:left; margin-left: 620px;" id="saveVideoUrl">Add Video Link</a>
        <!-- <label style="margin-right: 5px; margin-left: 145px; font-weight: bold;">Add Video URL</label>
        <input type="text" name="videoURL" id="videoURL" class="text" style="width: 385px; margin-right: 10px;">

        <a class="btn update-button saveIcon" style="float:right; margin-right: 20px;" id="saveVideo">Add Video</a>
        <span id="video_link_error_msg" style="margin-left: 128px;color:red;display:none"></span> -->
    </div>
</div>

<div id="no_videos_section" style="text-align: center;"><h3 style="border:0">No Videos. Add a video link to get started.</h3></div>

<div id="accordion5" style="margin-bottom:40px;margin-left:10px;margin-top:10px;width:97%!important">
    <?php
    
    if (count($company_videos)) {
        foreach ($company_videos as $video) {

            $uploadDisplay = "block";
            $removeBtnDisplay = "none";
            $thumbImageDisplay = "block";
            $image_path = '';
            $url = $video->getVideoUrl();
            $finalUrl = '';
            $buttonShow = false;
            if (strpos($url, 'facebook.com/') !== false) {
                //it is FB video
                $finalUrl .= 'https://www.facebook.com/plugins/video.php?href=' . rawurlencode($url) . '&show_text=1&width=200';
            } else if (strpos($url, 'vimeo.com/') !== false) {
                //it is Vimeo video
                $videoId = explode("vimeo.com/", $url)[1];
                if (strpos($videoId, '&') !== false) {
                    $videoId = explode("&", $videoId)[0];
                }
                $finalUrl .= 'https://player.vimeo.com/video/' . $videoId;
            } else if (strpos($url, 'youtube.com/') !== false) {
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
            } else if (strpos($url, 'youtu.be/') !== false) {
                //it is Youtube video
                $videoId = explode("youtu.be/", $url)[1];
                if (strpos($videoId, '&') !== false) {
                    $videoId = explode("&", $videoId)[0];
                }
                $finalUrl .= 'https://www.youtube.com/embed/' . $videoId;
            } else if (strpos($url, 'screencast.com/') !== false) {
                $finalUrl = $video->getVideoUrl();
            } else if (strpos($video->getVideoUrl(), 'dropbox.com') !== false) {
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
                $image_path = $company->getCompanyVideoCoverImagePath() . '/' . $video->getThumbnailImage();
            }
    ?>

            <div id="video_<?php echo $video->getId() ?>" class="video_div">
                <span class="group_checker"><input type="checkbox" id="checkbox_video_<?php echo $video->getId() ?>"  name="videos" class="company_videos" value="<?php echo $video->getId() ?>" style="float:left;"></span>
                <h4>
                    <a href="#"><span id="title_<?php echo $video->getId() ?>"><?php echo $video->getTitle() ?></span></a>


                    <a class="btn-delete close-accordion" href="#">&nbsp;</a>
                </h4>


                <div class="clearfix" style="margin-left: 25px;">
                
                    <div class="video_left_section" style="width: 310px;margin-top: 15px;float:left;margin-bottom: 15px;">
                        <div class="updateProposalVideoTitle" style="width: 360px;">
                            <label for="updateProposalVideoTitle"><b>Video Title: </b></label>
                            <input type="text" class="text" id="videoTitle_<?php echo $video->getId() ?>" value="<?php echo $video->getTitle() ?>" name="videoTitle" >
                           
                        </div>
                       <?php if (!$buttonShow) { 
                           
                                $display = 'block';
                                $displayplayerIconDiv = 'none';
                                if ($video->getThumbnailImage()) {
                                    $display = 'none';
                                    $displayplayerIconDiv = 'block';
                                }

                           ?>
                            
                            <div class="is_video_added proposalVideoImageUploaderDiv" data-video-id="<?php echo $video->getId() ?>" style="width: 120px;float:left;display:<?= $display; ?>;">
                                <p style="margin-top: 15px;"><strong>Video Thumbnail</strong></p>
                                <input accept="image/*" class="proposalVideoThumbImageUploader" type="file" name="files" data-video-id="<?php echo $video->getId() ?>">
                            </div>
                        <?php }else{echo '<div style="height:35px;"></div>';} ?>
                        
                        <div style="margin-top: 35px;float: left;width:100%;">
                            <input type="checkbox" name="include_in_proposal" id="include_in_proposal_<?php echo $video->getId() ?>" <?= ($video->getIncludeInProposal())?'checked':'';?> >Include automatically in new Proposals
                        </div>
                        <div style="margin-top: 15px;float: left;">
                            <input type="checkbox" name="intro_video" id="intro_video_<?php echo $video->getId() ?>" <?= ($video->getIsIntro())?'checked':'';?> >Intro Video
                        </div>
                        
                        <div class="playerIconDiv" data-video-id="<?php echo $video->getId() ?>" style="float:left;width: 100%;display:<?= $displayplayerIconDiv; ?>;">
                                <p style="margin-top: 15px;margin-bottom: 7px;"><strong>Player Icon</strong></p>
                                
                                <input type="checkbox" name="player_icon_hide" class="player_icon_hide videoLayoutSetting" data-video-id="<?php echo $video->getId() ?>" id="player_icon_hide<?php echo $video->getId() ?>" <?= ($video->getPlayerIconHide())?'checked':'';?>>Hide
                            </div>
                    </div>
                    <div class="video_right_section" style="width: 410px;float:left;margin-bottom: 15px;">

                        <div id="thumb-image-preview" class="is_video_added" style="margin-left:5px;box-shadow: rgb(60 64 67 / 30%) 0px 1px 4px 0px;padding: 10px;float:left;width: 400px;margin-bottom: 45px;">
                            <div id="image-area_<?php echo $video->getId() ?>" class="image-area" data-final-url="<?php echo $finalUrl; ?>" data-image-url="" data-button-show="<?php if ($buttonShow) {echo 1;} else {echo 0;} ?>">
                                <?php if ($video->getThumbnailImage()) {
                                    $thumbImageURL = $company->getSitePathCompanyVideoCoverImage() . '/' . $video->getThumbnailImage();
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
                                            <img style="width: 70px;" src="<?php echo site_url('static\images\video-player-icon.png') ?>">
                                            </a>
                                        </div>
                                    <?php if ($buttonShow) { ?>
                                        <!-- <a href="<?php echo $url; ?>" class="btn btn-primary" style="width:150px;" target="_blank">Company Video</a> -->
                                    <?php } else { ?>
                                        <!-- <iframe class="embed-responsive-item" src="<?php echo $finalUrl . '?autoplay=1'; ?>"
                                                                                    allowfullscreen loading="lazy" allow="autoplay"></iframe> -->
                                    <?php } ?>

                                    <?php } else {
                                    if ($buttonShow) { ?>
                                        <a href="<?php echo $finalUrl; ?>" class="btn btn-primary" style="width:180px;margin-left: 90px;" target="_blank"><i class="fa fa-fw fa-play-circle-o"></i>Play Company Video</a>
                                    <?php } else { ?>

                                        <iframe id="video-uploaded-iframe" class="embed-responsive-item" src="<?php echo $finalUrl; ?>" allowfullscreen loading="lazy"></iframe>
                                <?php }
                                } ?>



                            </div>
                            <a class="remove-image" onclick="remove_saved_thumb_image(<?php echo $video->getId() ?>)" href="#" style="display:<?= $thumbImageDisplay; ?>;">&#215;</a>
                            <a class="back-to-image" onclick="show_saved_thumb_image(this)" href="javascript:void(0)"><i class="fa fa-arrow-left"></i></a>

                        </div>
                        <div style="margin-top: 15px;float: left;width: 410px;position: absolute;bottom: 20px;">
                            
                            <a href="#" class="deleteVideoUrl tiptip btn" title="Delete Video" style="float: left;" data-video-id="<?php echo $video->getId() ?>"><i class="fa fa-fw fa-trash"></i>Delete Video</a>
                            <a  href="javascript:void(0)" class="btn tiptip deleteThumbnail" data-video-id="<?php echo $video->getId() ?>" title="Delete thumb image" style="margin-left: 19px;font-size: 13px;float: left;display:<?= $thumbImageDisplay; ?>;" onclick="remove_saved_thumb_image(<?php echo $video->getId() ?>)"><i class="fa fa-fw fa-trash"></i>Delete Thumbnail</a>
                            <a class="btn blue-button updateVideoTitle" data-video-id="<?php echo $video->getId() ?>" style="float: right;"><i class="fa fa-fw fa-save"></i> Update Video</a>
                             
                        </div>
                    </div>
                    
                    
                </div>

            </div>
    <?php
        }
    }
    ?>
</div>
<script type="text/javascript" src="/static/js/jquery.fileuploader.min.js"></script>
<script>
$(document).ready(function() {


    var companyId = '<?php echo $company->getCompanyId(); ?>';
            //Save Video
            $("#saveVideo").click(function () {
            var videoUrl = $("#videoURL").val();
            if(videoUrl !==''){
                var pattern = /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/;
                if(!pattern.test(videoUrl)){
                    $('#video_link_error_msg').text('Please Enter correct URL');
                    $('#video_link_error_msg').show();
                    return false;
                }else{
                    $('#video_link_error_msg').hide();
                }
            }else{
                $('#video_link_error_msg').text('Please Enter URL');
                $('#video_link_error_msg').show();
                return false;
            }

            swal({
                    title: 'Saving..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 10000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })

            var postData = {
                companyId: companyId,
                videoUrl: $("#videoURL").val(),
            };

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('ajax/saveCompanyVideos') ?>",
                dataType: 'json',
                data: postData
            })
                .done(function (data) {

                    if (data.error) {
                        swal(
                            'Error',
                            'There was an error saving the video'
                        );
                        return;
                    }

                    swal(
                        'Success',
                        'Video Saved'
                    );


                    $("#videoURL").val('');



                    var newContent = '' +

                    '<div  data-video-id="' + data.id + '" id="video_' + data.id + '" class="video_div">'+
            '<span class="group_checker"><input type="checkbox" id="checkbox_video_' + data.id + '"  name="videos" class="company_videos" value="' + data.id + '" style="float:left;"></span>' +
            '<h4>' +
            '<a href="#"><span id="title_' + data.id + '">' + data.title + '</span></a>' +
            '<a class="btn-delete close-accordion" href="#">&nbsp;</a>' +
            '</h4>' +
            '<div class="clearfix" style="margin-left: 25px;">'+
            '<div class="video_left_section" style="width: 310px;margin-top: 15px;float:left;margin-bottom: 15px;">'+
            '<div class="updateProposalVideoTitle" style="width: 360px;">'+
            '<label for="updateProposalVideoTitle"><b>Video Title: </b></label>'+
            '<input type="text" class="text" id="videoTitle_' + data.id + '" value="' + data.title + '" name="videoTitle" >'+
            '</div>';
            if(data.buttonShow==0){
                newContent +='<div class="is_video_added proposalVideoImageUploaderDiv" data-video-id="' + data.id + '" style="width: 120px;float:left;">'+
                            '<p style="margin-top: 15px;"><strong>Video Thumbnail</strong></p>'+
                            '<input accept="image/*" class="proposalVideoThumbImageUploader" type="file" name="files" data-video-id="' + data.id + '">'+
                            '</div>';
            }else{
                newContent +='<div style="height:35px;"></div>';
            }
            newContent += '<div style="margin-top: 35px;">'+
            '<input type="checkbox" name="include_in_proposal" id="include_in_proposal_' + data.id + '">Include automatically in new Proposals'+
            '</div>'+
            '</div>'+
            '<div class="video_right_section" style="width: 410px;margin-top: 15px;float:left;margin-bottom: 15px;">'+
            '<div id="thumb-image-preview" class="is_video_added" style="margin-left:5px;box-shadow: rgb(60 64 67 / 30%) 0px 1px 4px 0px;padding: 10px;float:left;width: 350px;margin-bottom: 45px;">'+
            '<div id="image-area_' + data.id + '" class="image-area" data-final-url="'+data.videoUrl+'" data-image-url="" data-button-show="0">';
            

            if(data.buttonShow==1){
                newContent +='<a href="'+data.videoUrl+'" class="btn btn-primary" style="width:180px;margin-left: 90px;" target="_blank"><i class="fa fa-fw fa-play-circle-o"></i>Play Proposal Video</a>';
            }else{
                newContent +='<p style="margin-top: 100px;margin-bottom: 100px;margin-left: 100px;" class="iframeLoadingImage"><img src="../../static/blue-loader.svg" alt="Loading"></p><iframe id="video-uploaded-iframe" class="embed-responsive-item" src="'+data.videoUrl+'" style="display:none;" onload="removeLoadingImage(this)" allowfullscreen loading="lazy"></iframe>';
            }
            
            newContent +='</div>'+
            '<a class="remove-image" onclick="remove_saved_thumb_image(' + data.id + ')" href="#" >&#215;</a>'+
            '<a class="back-to-image" onclick="show_saved_thumb_image(this)" href="javascript:void(0)"><i class="fa fa-arrow-left"></i></a>'+
            '</div>'+
            '<div style="margin-top: 15px;float: left;width: 360px;position: absolute;bottom: 20px;">'+
            '<a href="#" class="deleteVideoUrl tiptip btn" title="Delete Video" style="float: left;" data-video-id="' + data.id + '"><i class="fa fa-fw fa-trash"></i>Delete Video</a>'+
            '<a class="btn blue-button updateVideoTitle" data-video-id="' + data.id + '" style="float: right;"><i class="fa fa-fw fa-save"></i> Update Video</a>'+
            '</div>'+
            '</div>'+
            '</div>'+
            '</div>';

                        $("#accordion5").append(newContent);
                        $("#accordion5").sortable('refresh');
                        $("#accordion5").accordion('destroy').accordion({
                            collapsible: true,
                            active: false,
                            autoHeight: false,
                            navigation: true,
                            header: "> div > h4"
                        });
                    
                        $( '#accordion5' ).accordion( 'option', 'active', parseInt($( '#accordion5 .video_div').length-1) )

                    initButtons();
                    
                    resetAllVideoThumbUploader();
                    enable_fileupload_plugin();
                    $('#checkbox_video_' + data.id).uniform();
                    $('#include_in_proposal_' + data.id).uniform();
                    $('#intro_video' + data.id).uniform();
                    $('#player_icon_hide' + data.id).uniform();
                    setTimeout(function () {
                            removeLoadingImage();
                        }, 2000);
                })
                .fail(function (xhr) {
                    $("#loading").hide();

                    swal(
                        'Error',
                        'There was an error saving the Video'
                    );
                });

        });


        $("#accordion5").accordion({
                collapsible: true,
                active: false,
                autoHeight: false,
                navigation: true,
                header: "> div > h4"
            })
            .sortable({
                axis: "y",
                handle: "h4",
                stop: function() {
                    stop = true;
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('ajax/sort_companyVideos') ?>",
                        data: $("#accordion5").sortable("serialize"),
                        success: function(data) {
                            //                                alert(data);
                        }
                    });
                }
            });



    function resetAllVideoThumbUploader(){
        

        $(".proposalVideoImageUploaderDiv").each(function() {
            var video_id = $(this).attr('data-video-id');
            $(this).html('<p style="margin-top: 15px;"><strong>Video Thumbnail</strong></p><input accept="image/*" class="proposalVideoThumbImageUploader" type="file" name="files" data-video-id="'+video_id+'">');
        });
    }

    function enable_fileupload_plugin(){
    // enable fileupload plugin
    thumbfileuploader = $('.proposalVideoThumbImageUploader').fileuploader({
        enableApi: true,
        limit: 1,
        maxSize: 60,
        fileMaxSize: 20,
        changeInput: function (options) {
                return '<div class="changed_upload_thumb"><img width="25" src="<?php echo site_url('static/images/add_images.png');?>"><p>Upload Thumbnail</p></div>';
            },
        extensions: ['jpg', 'png', 'jpeg', 'heif', 'heic', 'tiff', 'tif', 'gif'],
        dialogs: {
            // alert dialog
            alert: function(text) {
                return swal('', text)
                // alert(text);
            },

            // confirm dialog
            confirm: function(text, callback) {
                confirm(text) ? callback() : null;
            }
        },
        // Callback fired on selecting and processing a file
        onSelect: function(item, listEl, parentEl, newInputEl, inputEl) {
            // callback will go here
             //console.log(item)
             //console.log(parentEl)
             //console.log(inputEl)
        },
        upload: {
            url: "<?php echo site_url('ajax/companyVideoThumbImageUpload') ?>",

            data: null,
            type: 'POST',
            enctype: 'multipart/form-data',
            start: true,
            synchron: true,

            beforeSend: function(item, listEl, parentEl, newInputEl, inputEl) {
                console.log();
                item.upload.data.companyId = '<?= $company->getCompanyId(); ?>';
                item.upload.data.companyVideoId = $(inputEl).attr('data-video-id');
            },
            onSuccess: function(result, item) {
                var companyId = '<?php echo $company->getCompanyId(); ?>';
               
                var data = JSON.parse(result),
                    nameWasChanged = false;

                // get the new file name
                if (data.isSuccess) {

                    item.html.find('.column-title div').animate({
                        opacity: 0
                    }, 400);
                    item.html.find('.column-actions').append('<a class="fileuploader-action fileuploader-action-remove fileuploader-action-success" title="Remove"><i></i></a>');
                    setTimeout(function() {
                        item.html.find('.column-title div').attr('title', item.name).text(item.name).animate({
                            opacity: 1
                        }, 400);
                        item.html.find('.progress-bar2').fadeOut(400);
                    }, 400);

                    var image_path = '<?php echo $company->getSitePathCompanyVideoCoverImage(); ?>/';
                    image_path = image_path + data.path;
                    var video_id = data.video_id;

                    
                    var final_url =  $('#image-area_'+video_id).attr('data-final-url');
                    var button_show =  $('#image-area_'+video_id).attr('data-button-show');
                    
                    // $('#thumb_preview_img').attr('src',image_path);
                    // $('#thumb_preview_a').attr('href',image_path);

                    // $('#thumb-image-preview').show();
                    //$('.remove-image').show();
                    var new_content = '<img id="thumb_preview_img" src="' + image_path + '" style="">' +
                        '<div class="play-overlay" id="player_overlay'+video_id+'">' +
                        '<a href="javascript:void(0)" class="play-icon">' +
                        '<img style="width: 70px;" src="<?php echo site_url('static/images/video-player-icon.png') ?>">' +
                        '</a>' +
                        '</div>';
                    console.log(button_show);
                    if (button_show == 1) {
                        console.log('check1');
                        new_content += '<!-- <a href="' + data.embeded_url + '" class="btn btn-primary" style="width:150px;" target="_blank">Proposal Video</a> -->';
                    } else {
                        console.log('check2');
                        new_content += '<!-- <iframe class="embed-responsive-item" src="' + final_url + '?autoplay=1" allowfullscreen loading="lazy" allow="autoplay"></iframe> -->';
                    }

                    $('.proposalVideoImageUploaderDiv[data-video-id="' + video_id + '"]').hide();
                    $('.deleteThumbnail[data-video-id="' + video_id + '"]').show(); 
                    $('.playerIconDiv[data-video-id="' + video_id + '"]').show();

                    initButtons();
                    $('#image-area_'+video_id).closest('.is_video_added').find('.remove-image').show();
                    $('#image-area_'+video_id).html(new_content);
                    $('#image-area_'+video_id).removeClass('player');
                } else {

                    if (data.warnings) {
                        swal('', 'File Not Uploaded<br>Error:' + data.warnings[0], "error")
                    }

                    var progressBar = item.html.find('.progress-bar2');

                    // make HTML changes
                    if (progressBar.length > 0) {
                        progressBar.find('span').html(0 + "%");
                        progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
                        item.html.find('.progress-bar2').fadeOut(400);
                    }

                    item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
                        '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
                    ) : null;
                }
            },
            onError: function(item) {
                var progressBar = item.html.find('.progress-bar2');

                // make HTML changes
                if (progressBar.length > 0) {
                    progressBar.find('span').html(0 + "%");
                    progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
                    item.html.find('.progress-bar2').fadeOut(400);
                }

                item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
                    '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
                ) : null;
            },
            onProgress: function(data, item) {
                var progressBar = item.html.find('.progress-bar2');

                // make HTML changes
                if (progressBar.length > 0) {
                    progressBar.show();
                    progressBar.find('span').html(data.percentage + "%");
                    progressBar.find('.fileuploader-progressbar .bar').width(data.percentage + "%");
                }
            },
            onComplete: function(listEl, parentEl, newInputEl, inputEl, jqXHR, textStatus) {

                setTimeout(reset_thumb_uploader(), 300);
            },
        },
        onRemove: function(item) {
            // send POST request
            $.post('./php/ajax_remove_file.php', {
                file: item.name
            });
        }
    });
}

    function reset_thumb_uploader() {
        console.log('reset')

        // thumbfileuploaderApi = $.fileuploader.getInstance(thumbfileuploader);
        // //thumbfileuploaderApi.destroy();
        // thumbfileuploaderApi.reset();
        //enable_fileupload_plugin
        $('.proposalVideoThumbImageUploader').each(function() {
            var api = $.fileuploader.getInstance(this);

            api.reset();
        })
    }



    $(function() {
        var videos = $(".image-area");
        $(document).on("click", ".image-area", function() {


            if ($(this).find('#thumb_preview_img').length) {
                $(this).attr('data-image-url', $(this).find('#thumb_preview_img').attr('src'));
                var elm = $(this),
                    conts = elm.contents(),
                    le = conts.length,
                    ifr = null;

                for (var i = 0; i < le; i++) {
                    if (conts[i].nodeType == 8) ifr = conts[i].textContent;
                }

                elm.addClass("player").html(ifr);
                elm.off("click");
                $(this).closest('.is_video_added').find('.remove-image').hide();

                $(this).closest('.is_video_added').find('.back-to-image').show();
            }
        });
    });



    enable_fileupload_plugin();



   $(document).on("click", ".updateVideoTitle", function() {
    swal({
                        title: 'Updating..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                    })
    


    // swal({
    //         title: 'Are you Sure?',
    //         allowOutsideClick: false,
    //         showCancelButton: true,
    //         confirmButtonText: 'Update',
    //         cancelButtonText: "Cancel",
    //         dangerMode: false,
    //         reverseButtons:false,
    //         html:'<p><input type="checkbox" id="update_all_proposals"  value="" >You want to update all proposals also</p><br>',


    //         }).then(function (result) {

            
                
            var id=$(this).data('video-id');
            var videoTitle = $('#videoTitle_'+id).val();
            var videoNote = $('#video_note_'+id).val();
            var include_in_proposal = ($('#include_in_proposal_'+id).prop("checked"))? 1 : 0;
            var intro_video = ($('#intro_video_'+id).prop("checked"))? 1 : 0;
            var player_icon_hide = ($('#player_icon_hide'+id).prop("checked"))? 1 : 0;
            //var is_update_all_proposals = ($('#update_all_proposals').prop('checked'))? 1 : 0;
           var is_update_all_proposals = 0;
            var postData = {
                videoId: id,
                videoTitle: videoTitle,
                videoNote:videoNote,
                include_in_proposal:include_in_proposal,
                is_update_all_proposals : is_update_all_proposals,
                intro_video:intro_video,
                player_icon_hide : player_icon_hide,
            };
            // swal.showLoading();
            $.ajax({
                type: "POST",
                    url: "<?php echo site_url('ajax/updateCompanyVideoTitle') ?>",
                    dataType: 'json',
                    data: postData
                })
                .done(function(data) {

                    if (data.error) {
                        swal(
                            'Error',
                            'There was an error saving the video'
                        );
                        return;
                    }

                    if (intro_video) {
                            $("input[name='intro_video']:checkbox").prop('checked',false);
                            $('#intro_video_' + id).prop('checked',true);
                            $("input[name='intro_video']:checkbox").uniform();
                           
                        } 

                    swal(
                        'Success',
                        'Video Saved'
                    );


                    
                    $('#title_'+id).html(videoTitle);
            })


                
          //  }).catch(swal.noop)



return false;

})

        $(document).on('click', '.deleteVideoUrl', function(){
            var id=$(this).data('video-id');

            swal({
            title: "Are you sure?",
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonText: 'Remove',
            cancelButtonText: "Cancel",
            dangerMode: false,
            reverseButtons:false,
            html: '<p style="text-align: left;"><input type="checkbox" id="remove_in_proposals"  value="" > Remove From All Proposals <i class="fa fa-fw fa-info-circle tiptipright" title="Select this checkbox to delete this video from your proposals."></i></p><br>',

            onOpen: function () {
               
                initTiptip();
            }
            
            }).then(function(isConfirm) {
                if (isConfirm) {

                    var is_removed_proposals = ($('#remove_in_proposals').prop('checked'))? 1 : 0;
                    swal({
                        title: 'Deleting..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 10000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                    })
                    $.ajax({
                        type: "POST",
                            url: "<?php echo site_url('ajax/deleteCompanyVideo') ?>",
                            dataType: 'json',
                            data: { id: id,is_removed_proposals:is_removed_proposals },
                    })
                    .done(function(data) {

                        if (data.error) {
                            swal(
                                'Error',
                                'There was an error Deleting the video'
                            );
                            return;
                        }

                        swal(
                            'Success',
                            'Video Deleted'
                        );
                        $('#video_'+id).remove();
                        if($(".company_videos").length == 0){
                            $('#uniform-masterSelect').css('visibility','hidden');
                            $('#no_videos_section').show();
                        }
                    })
                } else {
                    swal("Cancelled", "Your Thumb Image is safe :)", "error");
                }
            });
        });



        function updateVideoNumSelected() {
        var num = $(".company_videos:checked").length;
        
        // Hide the options if 0 selected
        if (num < 1) {

            $(".groupVideoAction").hide();
           // $(".groupActionsContainer").hide();
        } else {

            $(".groupVideoAction").show();
           // $(".groupActionsContainer").show();
        }
    }


        // Group Actions Button
        $(document).on("click", "#groupVideoActionsButton", function() {

            // Toggle the buttons
            $(".groupActionsContainer").toggle();
        });

    
    $(".company_videos").live('click', function() {

        $.uniform.update();
        updateVideoNumSelected()

    });

    

    $("#masterSelect").live('change', function() {
        if($(this).prop('checked')){
            $(".company_videos").attr('checked', 'checked');
        }else{
            $(".company_videos").attr('checked', false);
        }
        $.uniform.update();
        updateVideoNumSelected()
        return false;
    });
    // All
    

    function checkVideosSelected() {
        var num = $(".company_videos:checked").length;
        if (num > 0) {
            return true;
        }
        $("#no-proposals-selected").dialog('open');
        return false;
    }
    // get a list of the selected IDs /
    function getSelectedVideoIds() {
        var IDs = new Array();
        $(".company_videos:checked").each(function() {
            IDs.push($(this).val());
        });
        return IDs;
    }

    // get a list of the selected IDs /
    function getAllVideoIds() {
        var IDs = new Array();
        $(".company_videos").each(function() {
            IDs.push($(this).val());
        });
        return IDs;
    }


    $(document).on("click", "#groupVideoDelete", function() {
        

        swal({
            title: "Are you sure?",
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonText: 'Remove',
            cancelButtonText: "Cancel",
            dangerMode: false,
            reverseButtons:false,
            html: '<p style="text-align: left;"><input type="checkbox" id="remove_in_proposals"  value="" > Remove From All Proposals <i class="fa fa-fw fa-info-circle tiptipright" title="Select this checkbox to delete these videos from your proposals."></i></p><br>',

            onOpen: function () {
               
                initTiptip();
            }
            
            }).then(function(isConfirm) {
        
                var is_removed_proposals = ($('#remove_in_proposals').prop('checked'))? 1 : 0;
            if (isConfirm) {

                swal({
                    title: 'Removing..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 10000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })

                $.ajax({
                    url: '/ajax/remove_group_company_videos',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        'videos_ids': getSelectedVideoIds(),
                        'is_removed_proposals' : is_removed_proposals,
                    },

                    success: function(data) {
                        swal('', 'Company Videos Removed');
                        $(".company_videos:checked").each(function() {
                           var video_id = $(this).val();
                           $('#video_'+video_id).remove();
                        });
                        updateVideoNumSelected();
                        $('#masterSelect').prop('checked',false);
                        $.uniform.update();
                        if($(".company_videos").length == 0){
                            $('#uniform-masterSelect').css('visibility','hidden');
                            $('#no_videos_section').show();
                        }
                    },
                    error: function(jqXhr, textStatus, errorThrown) {
                        swal("Error", "An error occurred. Please try again");
                    }
                })
            } else {
                swal("Cancelled", "Your proposal videos not removed :)", "error");
            }
        });

    });



    $(document).on("click", "#saveVideoUrl", function() {

            swal({
            title: 'Save Video Link',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: "Cancel",
            dangerMode: false,
            reverseButtons:false,
            html:
                '<input id="swal-input1" class="swal2-input" value="" Placeholder="Enter Video Link"><br><span id="video_link_error_msg"></span><p style="text-align: left;"><input type="checkbox" id="add_in_proposals"  value="" > Include Automatically <i class="fa fa-fw fa-info-circle tiptipright" title="Check this box for this video to be included automatically on all new proposals.<br/><br/>It can still be removed from individual proposals if necessary."></i></p><br>',

            preConfirm: function () {
                    if($('#swal-input1').val()){

                     return new Promise(function (resolve) {
                        var videoUrl= $('#swal-input1').val();

                        if(videoUrl !==''){
                            var pattern = /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/;
                            if(!pattern.test(videoUrl)){
                                $('#video_link_error_msg').text('Please Enter correct URL');
                                $('#video_link_error_msg').show();
                                $('#swal-input1').addClass("error");
                                return false;
                            }else{
                                resolve(      
                                    $('#swal-input1').val()

                                )
                            }
                        }else{
                            $('#video_link_error_msg').text('Please Enter URL');
                            $('#video_link_error_msg').show();
                            $('#swal-input1').addClass("error");
                            return false;
                        }


                        })
                    }else{
                        alert('Please Enter the filter Name');
                    }
                },
            onOpen: function () {
                $('#swal-input1').focus();
                console.log('check init')
                initTiptip();
            }
            }).then(function (result) {

                
                var video_url = result;
                var include_in_proposal = ($('#add_in_proposals').prop("checked"))? 1 : 0;
                swal({
                    title: 'Saving..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 10000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })

                var postData = {
                    companyId: '<?php echo $company->getCompanyId(); ?>',
                    videoUrl: video_url,
                    include_in_proposal : include_in_proposal
                };
                var include_checked = (include_in_proposal)?'checked':'';
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('ajax/saveCompanyVideos') ?>",
                    dataType: 'json',
                    data: postData
                })
                .done(function (data) {

                    if (data.error) {
                        swal(
                            'Error',
                            'There was an error saving the video'
                        );
                        return;
                    }

                    swal(
                        'Success',
                        'Video Saved'
                    );
                    $('#uniform-masterSelect').css('visibility','visible');

                    var newContent = '' +

                    '<div  data-video-id="' + data.id + '" id="video_' + data.id + '" class="video_div">'+
            '<span class="group_checker"><input type="checkbox" id="checkbox_video_' + data.id + '"  name="videos" class="company_videos" value="' + data.id + '" style="float:left;"></span>' +
            '<h4>' +
            '<a href="#"><span id="title_' + data.id + '">' + data.title + '</span></a>' +
            '<a class="btn-delete close-accordion" href="#">&nbsp;</a>' +
            '</h4>' +
            '<div class="clearfix" style="margin-left: 25px;">'+
            '<div class="video_left_section" style="width: 310px;margin-top: 15px;float:left;margin-bottom: 15px;">'+
            '<div class="updateProposalVideoTitle" style="width: 360px;">'+
            '<label for="updateProposalVideoTitle"><b>Video Title: </b></label>'+
            '<input type="text" class="text" id="videoTitle_' + data.id + '" value="' + data.title + '" name="videoTitle" >'+
            '</div>';
            if(data.buttonShow==0){
                newContent +='<div class="is_video_added proposalVideoImageUploaderDiv" data-video-id="' + data.id + '" style="width: 120px;float:left;">'+
                            '<p style="margin-top: 15px;"><strong>Video Thumbnail</strong></p>'+
                            '<input accept="image/*" class="proposalVideoThumbImageUploader" type="file" name="files" data-video-id="' + data.id + '">'+
                            '</div>';
            }else{
                newContent +='<div style="height:35px;"></div>';
            }
            newContent +='<div style="margin-top: 35px;float: left;">'+
            '<input type="checkbox" name="include_in_proposal" id="include_in_proposal_' + data.id + '" '+include_checked+'>Include automatically in new Proposals'+
            '</div>'+
            '<div style="margin-top: 15px;float: left;">'+
            '<input type="checkbox" name="intro_video" id="intro_video_' + data.id + '"  >Intro Video'+
            '</div>'+
            '<div class="playerIconDiv" data-video-id="' + data.id + '" style="float:left;width: 100%;display:none;">'+
            '<p style="margin-top: 15px;margin-bottom: 7px;"><strong>Player Icon</strong></p>'+
            '<input type="checkbox" name="player_icon_hide" class="player_icon_hide videoLayoutSetting" data-video-id="' + data.id + '" id="player_icon_hide' + data.id + '" >Hide'+
            '</div>'+
            '</div>'+
            '<div class="video_right_section" style="width: 410px;margin-top: 15px;float:left;margin-bottom: 15px;">'+
            '<div id="thumb-image-preview" class="is_video_added" style="margin-left:5px;box-shadow: rgb(60 64 67 / 30%) 0px 1px 4px 0px;padding: 10px;float:left;width: 400px;margin-bottom: 45px;">'+
            '<div id="image-area_' + data.id + '" class="image-area" data-final-url="'+data.videoUrl+'" data-image-url="" data-button-show="0">';
            

            if(data.buttonShow==1){
                newContent +='<a href="'+data.videoUrl+'" class="btn btn-primary" style="width:180px;margin-left: 90px;" target="_blank"><i class="fa fa-fw fa-play-circle-o"></i>Play Proposal Video</a>';
            }else{
                newContent +='<p style="margin-top: 100px;margin-bottom: 100px;margin-left: 100px;" class="iframeLoadingImage"><img src="../../static/blue-loader.svg" alt="Loading"></p><iframe id="video-uploaded-iframe" class="embed-responsive-item" src="'+data.videoUrl+'" style="display:none;" onload="removeLoadingImage(this)" allowfullscreen loading="lazy"></iframe>';
            }
            
            newContent +='</div>'+
            '<a class="remove-image" onclick="remove_saved_thumb_image(' + data.id + ')" href="#" >&#215;</a>'+
            '<a class="back-to-image" onclick="show_saved_thumb_image(this)" href="javascript:void(0)"><i class="fa fa-arrow-left"></i></a>'+
            '</div>'+
            '<div style="margin-top: 15px;float: left;width: 410px;position: absolute;bottom: 20px;">'+
            '<a href="#" class="deleteVideoUrl tiptip btn" title="Delete Video" style="float: left;" data-video-id="' + data.id + '"><i class="fa fa-fw fa-trash"></i>Delete Video</a>'+
            '<a href="javascript:void(0)" class="deleteThumbnail tiptip btn" title="Delete thumb image" style="margin-left: 19px;font-size: 13px;float: left;display:none" data-video-id="' + data.id + '" onclick="remove_saved_thumb_image(' + data.id + ')"><i class="fa fa-fw fa-trash"></i>Delete Thumbnail</a>' +
            '<a class="btn blue-button updateVideoTitle" data-video-id="' + data.id + '" style="float: right;"><i class="fa fa-fw fa-save"></i> Update Video</a>'+
            '</div>'+
            '</div>'+
            '</div>'+
            '</div>';

                        $("#accordion5").append(newContent);
                        $("#accordion5").sortable('refresh');
                        $("#accordion5").accordion('destroy').accordion({
                            collapsible: true,
                            active: false,
                            autoHeight: false,
                            navigation: true,
                            header: "> div > h4"
                        });
                    
                    $( '#accordion5' ).accordion( 'option', 'active', parseInt($('#accordion5 .video_div').length-1) )

                    initButtons();
                    
                    resetAllVideoThumbUploader();
                    enable_fileupload_plugin();
                    $('#checkbox_video_' + data.id).uniform();
                    $('#include_in_proposal_' + data.id).uniform();
                    $('#intro_video_' + data.id).uniform();
                    $('#player_icon_hide' + data.id).uniform();
                    $('#no_videos_section').hide();
                    setTimeout(function () {
                            removeLoadingImage();
                        }, 2000);
                })
                .fail(function (xhr) {
                    $("#loading").hide();

                    swal(
                        'Error',
                        'There was an error saving the Video'
                    );
                });


                
            }).catch(swal.noop)
        });



});//End Ready

function remove_saved_thumb_image(video_id) {
        swal({
            title: "Are you sure?",
            text: "This will Delete the Video Thumb Image",
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function(isConfirm) {
            if (isConfirm) {

                swal({
                    title: 'Deleting..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })
                $.ajax({
                    type: "GET",
                    url: "<?php echo site_url('ajax/remove_company_video_thumb_image') ?>/" + video_id,
                    async: false,
                    dataType: 'json',
                    success: function(data) {

                        // Proposal either has snow, or no other services
                        if (data.success) {
                            // No problem here, move along
                            swal('', 'Image deleted');

                            var final_url = $('#video_'+video_id).find('.image-area').attr('data-final-url');
                            var button_show = $('#video_'+video_id).find('.image-area').attr('data-button-show');
                            $('.remove-image').hide();

                            if (button_show == 1) {
                                var new_content = '<a href="' + final_url + '" class="btn btn-primary" style="width:150px;" target="_blank">Company Video</a>';
                            } else {
                                var new_content = '<iframe class="embed-responsive-item" src="' + final_url + '" allowfullscreen loading="lazy" allow="autoplay"></iframe>';
                            }

                            $('.proposalVideoImageUploaderDiv[data-video-id="' + video_id + '"]').show();
                            $('.deleteThumbnail[data-video-id="' + video_id + '"]').hide(); 

                            initButtons();
                            $('#video_'+video_id).find('.image-area').html(new_content);
                        } else {
                            swal('', 'image not deleted');
                        }
                    }
                });
            } else {
                swal("Cancelled", "Your Thumb Image is safe :)", "error");
            }
        });
    }


function removeLoadingImage(e){
            $('.iframeLoadingImage').hide();
            $('.embed-responsive-item').show();
        }

    function show_saved_thumb_image(e) {
       
       var image_path = $(e).closest('.is_video_added').find('.image-area').attr('data-image-url');

       var final_url = $(e).closest('.is_video_added').find('.image-area').attr('data-final-url');
       var button_show = $(e).closest('.is_video_added').find('.image-area').attr('data-button-show');

       $('.remove-image').show();
       var new_content = '<img id="thumb_preview_img" src="' + image_path + '" style="">' +
           '<div class="play-overlay">' +
           '<a href="javascript:void(0)" class="play-icon">' +
           '<i class="fa fa-play-circle"></i>' +
           '</a>' +
           '</div>';
       if (button_show == 1) {
           new_content += '<!-- <a href="' + final_url + '" class="btn btn-primary" style="width:150px;" target="_blank">Proposal Video</a> -->';
       } else {
           new_content += '<!-- <iframe class="embed-responsive-item" src="' + final_url + '?autoplay=1" allowfullscreen loading="lazy" allow="autoplay"></iframe> -->';
       }
       initButtons();
       $(e).closest('.is_video_added').find('.image-area').html(new_content);
       $(e).closest('.is_video_added').find('.image-area').removeClass('player');
       $(e).hide();
   }

   $(document).on("click", ".player_icon_hide", function () {
        console.log($(this).attr('data-video-id'));

        var video_id = $(this).attr('data-video-id');

        if($(this).is(":checked")){
            $('#player_overlay'+video_id).hide();
        }else{
            $('#player_overlay'+video_id).show();
        }
    });

   
</script>