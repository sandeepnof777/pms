<?php
/*
*Video Page
*/

if (isset($proposal_videos) && count($proposal_videos)) {
   $videoCounter =1;
   $trOpen = false;
                       ?>
    <div style="page-break-after: always"></div>
       <div id="video">
       <div id="videoURL" width="100%"  >
       <table>
           <?php foreach ($proposal_videos as $video) { 
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
                echo '<tr width="50%"><td>'; 
                $trOpen = true;
               }else{
                   echo '<td>';
               }
?>

<div style="position: relative;">
       <h3 class="video_title"><?= $videoCounter; ?>. <?php echo $video->getTitle(); ?></h3>
       
       
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
                //    if ($videoType == 'youtube') {
                      
                //        parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
                //        if(isset($my_array_of_vars['v'])){
                //            $video_id = $my_array_of_vars['v'];   
                //            $thumbImageURL = "https://img.youtube.com/vi/".$video_id."/0.jpg";
                //        }else{
                //            $thumbImageURL = STATIC_PATH.'/images/video-play-icon-transparent.jpg';
                //        }
                       
                //    } else if ($videoType == 'vimeo') {
                //        $urlParts = explode("/", parse_url($url, PHP_URL_PATH));
                //        $video_id = (int)$urlParts[count($urlParts)-1];
                //        $thumbImageURL = "https://vumbnail.com/".$video_id.".jpg";
                //    }else if ($videoType == 'screencast') {
                //        $thumbImageURL = str_replace('www', 'content', $url);
                //        $thumbImageURL = str_replace('embed', 'FirstFrame.jpg', $thumbImageURL);

                //    }


               }


               ?>
               
   <a style="width: 100%;" target="_blank" href="<?php echo $video->getVideoUrl(); ?>"> 
       <img style="width: 350px;object-fit: cover;height: 280px;" src="data:image/png;base64, <?php echo base64_encode(file_get_contents($thumbImageURL)); ?>" >
       <?php if(!$video->getPlayerIconHide()  && $showPlayerIcon){?>
            <img width="100px" style="position: absolute;top: 100px;left: 38%;" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(STATIC_PATH.'/images/video-player-icon_'.$video->getPlayerIconColor().'.png')); ?>"  >
        <?php } ?>
    </a>
   
</div>


           <?php
       if ($videoCounter % 2 == 0) {  
           echo '</td></tr>'; 
           $trOpen = false;
          }else{
              echo '</td>';
          }
          $videoCounter++;
       
          
       } 
       if($trOpen){
           echo '</tr>'; 
       }
       ?>
       </table>
       </div>
       </div>
   <?php
   }else{
      // echo '<div style="page-break-after: always"></div>';
   }

   ?>