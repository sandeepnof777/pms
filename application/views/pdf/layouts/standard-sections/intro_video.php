<?php
/*
 *Video Page
 */

if ($proposal_intro_video) {?>
    <div style="page-break-after: always"></div>
        <div style="height: 350px;" id="intro_video" >
        <h3 style="width:100%;text-align:center" class="video_title"><?php echo $proposal_intro_video->getTitle(); ?></h3>
        <table>
            <?php 
                $companyThumbImage = false;
                if($proposal_intro_video->getCompanyVideoId() !=0 && $proposal_intro_video->getCompanyCoverImage() !=''){
                    $companyThumbImage = $proposal_intro_video->getCompanyABSCoverImage();
                }
                
                $videoType = $proposal_intro_video->getVideoType();
                $url = $proposal_intro_video->getVideoUrl();

                
?>
<tr width="100%">
    
<td>
<div style="position: relative;margin-left:50%">
        
        
        
<?php



                if ($proposal_intro_video->getThumbnailImage() || $companyThumbImage) {
                    if($proposal_intro_video->getThumbnailImage()){
                         $thumbImageURL = $proposal->getPathUploadDir() . '/' . $proposal_intro_video->getThumbnailImage();
                     }else{
                         $thumbImageURL = $companyThumbImage;
                    }
                    $showPlayerIcon = true;
                } else { 
                    $thumbImageURL = STATIC_PATH.'/images/video_play.png';
                    $showPlayerIcon = false;
                    // if ($videoType == 'youtube') {
                       
                    //     parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
                    //     if(isset($my_array_of_vars['v'])){
                    //         $video_id = $my_array_of_vars['v'];   
                    //         $thumbImageURL = "https://img.youtube.com/vi/".$video_id."/0.jpg";
                    //     }else{
                    //         $thumbImageURL = STATIC_PATH.'/images/video-play-icon-transparent.jpg';
                    //     }
                        
                    // } else if ($videoType == 'vimeo') {
                    //     $urlParts = explode("/", parse_url($url, PHP_URL_PATH));
                    //     $video_id = (int)$urlParts[count($urlParts)-1];
                    //     $thumbImageURL = "https://vumbnail.com/".$video_id.".jpg";
                    // }else if ($videoType == 'screencast') {
                    //     $thumbImageURL = str_replace('www', 'content', $url);
                    //     $thumbImageURL = str_replace('embed', 'FirstFrame.jpg', $thumbImageURL);

                    // }


                }


                ?>
                
    <a style="width: 100%;float:left;" target="_blank" href="<?php echo $proposal_intro_video->getVideoUrl(); ?>"> 
        <img style="width: 350px;object-fit: cover;height: 280px;" src="data:image/png;base64, <?php echo base64_encode(file_get_contents($thumbImageURL)); ?>" >
        <?php if(!$proposal_intro_video->getPlayerIconHide()  && $showPlayerIcon){?>
            <img width="100px" style="position: absolute;top: 100px;left: 65%;" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(STATIC_PATH.'/images/video-player-icon_'.$proposal_intro_video->getPlayerIconColor().'.png')); ?>"  >
        <?php } ?>
    </a>
    
    </div>
    </tr></td>

</table>
</div>
    

<?php } ?>