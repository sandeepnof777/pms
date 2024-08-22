
<div  style="width:100%;float: right;" ><h4 style="margin-bottom:5px;margin-top:22px;">Video Viewed</h4>
<?php

if($proposalView->getViewedVideoData()){
    $videoViewData = json_decode($proposalView->getViewedVideoData());
    if($videoViewData){
        ?>
        
        <?php
        foreach($videoViewData as $s => $videoData ) {

            $video = $this->em->find('models\ProposalVideo', $videoData->videoId);
            if ($video) {?>

                <p style="padding: 5px 0px;"><span style="float:left">
                <a target="_blank" href="<?=$video->getEmbedVideoUrl();?>"><?=$video->getTitle();?></a>
                </p>
               <?php
            }
        }?>
        
<?php

    }else{
        echo 'No Videos Viewed';
    }
}else{
    echo 'No Videos Viewed';
}

?>
</div>
