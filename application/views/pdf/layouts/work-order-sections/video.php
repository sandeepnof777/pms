
<div id="video">
<?php
//Proposal Videos;
if (count($work_order_videos)) {


if($i!=1){ ?>
        <div style="page-break-after: always"></div>
<?php }

    $videoCounter =1;
    $trOpen = false;
    $btn_left = '25%';
    if(count($work_order_videos)==1){
        $btn_left = '21%';
    }
    
						?>
        <div id="videoURL" style="width:100%" >
        <table style="width: 100%;">
            <?php foreach ($work_order_videos as $video) { 
                $companyThumbImage = false;
                if($video->getCompanyVideoId() !=0 && $video->getCompanyCoverImage() !=''){
                    $companyThumbImage = $video->getCompanyABSCoverImage();
                }
                //$box_size = 'width:40%';
                // if($video->getIsLargePreview()){
                //     $box_size = 'width:40%';
                // }
                $videoType = $video->getVideoType();
                $url = $video->getVideoUrl();

                if ($videoCounter % 2 != 0) {  
                 echo '<tr><td>'; 
                 $trOpen = true;
                }else{
                   // echo '<td>';
                }
?>

<div style="position: relative;">
        <h3 class="video_title"><?= $videoCounter; ?>. <?php echo $video->getTitle(); ?></h3>
        <p><?php echo $video->getVideoNote(); ?></p>
        
<?php



                if ($video->getThumbnailImage() || $companyThumbImage) {
                    if($video->getThumbnailImage()){
                         $thumbImageURL = $proposal->getPathUploadDir() . '/' . $video->getThumbnailImage();
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

              ///  $video->getPlayerIconColor();
                        $playerIconColor = $video->getPlayerIconColor();
                        if (empty($playerIconColor)) {
                        $playerIconColor = 1; // 1 stand for default blue color
                        }
                ?>
                
    <a style="width: 100%;" target="_blank" href="<?php echo $video->getVideoUrl(); ?>"> 
        <img style="width:500px;object-fit:cover;position: relative;margin-top:50px;height: 330px;" src="data:image/png;base64, <?php echo base64_encode(file_get_contents($thumbImageURL)); ?>" >
        <?php if($showPlayerIcon){?>
            <img width="100px" style="position: absolute;top: 180px;left: <?=$btn_left;?>;" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(STATIC_PATH.'/images/video-player-icon_'.$playerIconColor.'.png')); ?>"  >
        <?php } ?>
        
    </a>
    
    
</div>

            <?php
        if ($videoCounter % 2 == 0) {  
            echo '</td></tr>'; 
            $trOpen = false;
           }else{
              // echo '</td>';
           }
           $videoCounter++;
        
           
        } 
        if($trOpen){
            echo '</tr>'; 
        }
        ?>
        </table>
        </div>
    <?php
    }

?>
</div><!--Close Video-->