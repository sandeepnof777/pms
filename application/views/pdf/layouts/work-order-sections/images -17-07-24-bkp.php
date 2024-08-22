
<div id="images">
<?php
//proposal images
if (count($images)) {
    
    foreach ($images as $k => $image) {

        if ($images[$k]['image']->getActivewo()) {
            $img = array();
            $img['src'] = $images[$k]['src'];
            $img['path'] = $images[$k]['path'];
            if (file_exists($img['path'])) {
                $img['orientation'] = $images[$k]['orientation'];
                $img['title'] = $images[$k]['image']->getTitle();
                $img['notes'] = $images[$k]['image']->getNotes();
                $img['image_layout'] = $images[$k]['image']->getImageLayout();
                $images2[] = $img;

                switch($img['orientation']) {
                    case 'portrait':
                        $imgManager = new \Intervention\Image\ImageManager();
                        $newImg = $imgManager->make($img['path']);
                        $newImg->resize(null, 500, function ($constraint) {
                            $constraint->aspectRatio();
                        });
                        $margin = (int) round(((650 - $newImg->width()) / 2), 0);
                        break;

                    default:
                        $margin = 0;
                        break;
                }

               
                if($i!=1){
                        ?>
                        <div style="page-break-after: always"></div> 
                <?php
                    }?>
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="float:left;position:relative">
                    <tr>
                        <td><h2 style="text-align: center;"><?php echo $img['title'] ?></h2></td>
                        <td><h2 style="text-align: center; vertical-align: top;">Notes</h2></td>
                    </tr>
                    <tr>
                        <td border="0" width="500" align="center" style="text-align: center;">
                                <img class="<?php echo ($img['orientation'] == 'landscape') ? 'proposalImage_l' : 'proposalImage_p'; ?>"
                                     <?php echo ($img['orientation'] == 'portrait') ? 'style="margin-top:2px;margin-left: ' . $margin . 'px"': 'style="margin-top:2px;"'; ?>
                                     src="data:image/png;base64, <?php echo base64_encode(file_get_contents($img['path'])); ?>" alt="">
                                
                        </td>
                        <td class="imageNotes" style="vertical-align: top;">
                            <?php echo $img['notes'] ?: '<p style="text-align:center;">No Image Notes</p>'; ?>
                        </td>
                    </tr>
                </table>
                <?php
            }
        }
    }
}
?>
</div><!--Close images-->