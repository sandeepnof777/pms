<table>
    <tr><th colspan="2"><h4 style="text-align: center;margin-bottom:2px;font-size:16px;margin-top:22px;">Images Viewed</h4></th></tr>
<?php
if ($proposalView->getViewedImageData()) {
    $imageViewData = json_decode($proposalView->getViewedImageData());

    if ($imageViewData) {
        ?>
        
        <?php
        $count = 0;
        $trOpen = false;
        foreach ($imageViewData as $s => $imageData) {
            $image = $this->em->findProposalImage($imageData->imageId);
            if ($image) {
                if ($count % 2 == 0) {
                    $trOpen = true;
                    echo '<tr>';
                  }
                ?>
                
                
                    <td style="padding: 5px;">

                <div align="center" class="img-container center"
                     style="float:left;width:50%;padding-right: 0px;padding-left: 0px;padding-top: 2px;padding-bottom: 2px;margin-top:5px;margin-bottom:5px;">
                    <!--[if mso]>
                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                        <tr style="line-height:0px">
                            <td style="padding-right: 0px;padding-left: 0px;" align="center">
                    <![endif]-->
                    <a href="<?= $image->getFullWebPath(); ?>" target="_blank">
                        <img align="center"
                            border="0"
                            class="center autowidth"
                            src="<?= $image->getFullWebPath(); ?>"
                            style="text-decoration: none; -ms-interpolation-mode: bicubic; height: auto; border: 0; width: 125px; max-width: 100%; display: block;"
                            width="125"/>
                    </a>
                    <!--[if mso]></td></tr></table><![endif]-->
                </div>
                </td>


                <?php
                if ($count % 2 != 0) {
                    echo '</tr>';
                    $trOpen = false;
                  }
                $count++;
                 
                  
            }

        }
        if ($trOpen ) {
            echo '</tr>';
        }
    }else{
        echo '<tr><td colspan="2" style="text-align: center;font-size:17px;">No Images Viewed</td></tr>';
    } ?>
    
    <?php
}else{
    echo '<tr><td colspan="2" style="text-align: center;font-size:17px;">No Images Viewed</td></tr>';
}
?>
</table>
