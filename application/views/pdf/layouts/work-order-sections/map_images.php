<?php

//Proposal Map Images
$new_map_images = array();
/*Proposal Images*/
if (isset($map_images)) {
    if (count($map_images)>0) {    
    ?>
    

    <?php
    
    foreach ($map_images as $k => $image) {
        if ($map_images[$k]['image']->getActivewo()) {
            $img = array();
            $img['src'] = $map_images[$k]['src'];
            $img['path'] = $map_images[$k]['path'];
            if (file_exists($img['path'])) {
                $img['orientation'] = $map_images[$k]['orientation'];
                $img['title'] = $map_images[$k]['image']->getTitle();
                $img['notes'] = $map_images[$k]['image']->getNotes();
               
                $new_map_images[] = $img;
            }
        }
    }
    //new world order code
    $imageCount = 0; //image counter
    $tableOpen = 0; //variable to check if the table open
    $old_layout = 0;
    $j=0;
    ?>
    <div  style="page-break-after: always"></div>
    <div class="header-hider"></div>
    <!--Hide Header code end-->
    <h1 class="underlined header_fix" style="z-index: 200; font-size: 24px;">Site Map: <?php echo $proposal->getProjectName()  ?></h1>
    <div id="map_images">
    <?php
    foreach ($new_map_images as $image) {
        $j++;

        if($j!=1){?>
            <div  style="page-break-after: always"></div>
       <?php } ?>
        

                    <h2 style="text-align: center;font-weight: 400;">Map: <?php echo $image['title'] ?></h2>
                    <div align="center">
                        <img class="<?php echo ($image['orientation'] == 'landscape') ? 'proposalImage_l' : 'proposalImage_p'; ?>" src="<?php echo $image['src']; ?>" alt="">
                    </div>
                    <p>&nbsp;</p>
                    <h2 style="text-align: center;">Notes:</h2>
                    <div style="text-align: left;"><?php echo $image['notes']; ?></div>
    <?php } ?>
    </div>
    
<?php
}
}//End Map Images

?>