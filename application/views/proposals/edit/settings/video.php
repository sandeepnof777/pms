<?php 
 $uploadDisplay ="block";
 $removeBtnDisplay ="none";
 $thumbImageDisplay ="block";
 $image_path = '';
 $url = $proposal->getVideoURL();
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
     if (strpos($proposal->getVideoURL(), 'embed') > 0) {
         $finalUrl = $proposal->getVideoURL();
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
     $finalUrl = $proposal->getVideoURL();
 } else if (strpos($proposal->getVideoURL(), 'dropbox.com') !== false) {
     $finalUrl = str_replace('dl=0', 'raw=1', $proposal->getVideoURL());
 } else {
     $buttonShow = true;
     $finalUrl = $proposal->getVideoURL();
 }
if($proposal->getVideoURL()==''){
        $uploadDisplay ="none";
        $removeBtnDisplay ="block";
} 
if($proposal->getThumbImageURL()==''){
    $thumbImageDisplay ="none";
}else{
    $image_path = $proposal->getSitePathUploadDir().'/'.$proposal->getThumbImageURL();
}
?>
<div class="clearfix" style="padding-top: 15px;">
    <label style="margin-right: 5px;">Proposal Video URL</label>
    <input type="text" name="videoURL" id="videoURL" class="text" style="width: 515px; margin-right: 10px;"
           value="<?php echo $proposal->getVideoURL() ?>">
    
    <a class="btn update-button saveIcon" style="float:right;display:<?=$removeBtnDisplay;?>" id="saveVideo">Save Video</a>
    <a class="btn update-button" style="float:right;display:<?=$uploadDisplay;?>" id="removeVideo">Remove Video</a>
    <span id="video_link_error_msg" style="margin-left: 128px;color:red;display:none"></span>
</div>
<div class="clearfix"></div>

<div class="clearfix" id="thumb-image-section" style="width: 786px;display:<?=$uploadDisplay;?>" >
    <p><strong>Video Overlay Image</strong></p>
    <div id="imageUploader" class="is_video_added" style="width: 388px;float:left;">
        <input accept="image/*" id="proposalVideoThumbImageUploader44" type="file" name="files">
    </div>
    <div id="thumb-image-preview" class="is_video_added" style="margin-left:5px;box-shadow: rgb(60 64 67 / 30%) 0px 1px 4px 0px;padding: 10px;float:left;width: 373px;">
                <div class="image-area" data-final-url="<?php echo $finalUrl; ?>" data-image-url="" data-button-show="<?php if ($buttonShow) { echo 1;}else{echo 0;}?>">
                <?php if ($proposal->getThumbImageURL()) { 
											$thumbImageURL = $proposal->getSitePathUploadDir().'/'.$proposal->getThumbImageURL();
											?>
											<img id="thumb_preview_img" src="<?= $thumbImageURL; ?>" style="">
											
                                            <div class="play-overlay">
												<a href="javascript:void(0)" class="play-icon">
													<!-- <i class="fa fa-play"></i> -->
                                                    <img style="width: 70px;"  src="<?php echo site_url('static\images\video-player-icon.png') ?>" style="">
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
                                                <a href="<?php echo $finalUrl; ?>" class="btn btn-primary" style="width:150px;" target="_blank">Proposal Video</a>
                                            <?php } else { ?>
                                            
											<iframe id="video-uploaded-iframe" class="embed-responsive-item" src="<?php echo $finalUrl; ?>" allowfullscreen loading="lazy"></iframe>
										<?php } }?>
                    
                    
                  
            </div>
            <a class="remove-image" onclick="remove_saved_thumb_image()" href="#" style="display:<?=$thumbImageDisplay;?>;">&#215;</a>
            <a class="back-to-image" onclick="show_saved_thumb_image()" href="javascript:void(0)" ><i class="fa fa-arrow-left"></i></a>
                   
    </div>
</div>
<style>

    
.image-area { position: relative;  /* 16:9 */ height: auto; }
/* .image-area img { position: absolute; display: block; top: 0; left: 0; width: 100%; height: 100%; z-index: 20; cursor: pointer; } */
.image-area:after { content: ""; position: absolute; display: block;  
    top: 45%; left: 45%; width: 46px; height: 36px; z-index: 30; cursor: pointer; } 
.image-area iframe {  top: 0; left: 0; width: 100%;height: 212px; }

/* image poster clicked, player class added using js */
.image-area.player img { display: none; }
.image-area.player{padding-bottom: 0;height: auto;}
.image-area.player:after { display: none; }

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
  background-color: transparent;
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