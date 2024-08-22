<div style="page-break-after: always"></div>
<div id="project_specifications">
<?php
$s = array('$', ',');
$r = array('', '');
$k = 0;
foreach ($services as $service) {
 

    $k++;

    if(!$proposal->hasSnow()){
?>
        <div id="item_<?php echo $k ?>" style="page-break-inside: avoid;">
            <div style="position: relative;" class="item-content<?php echo ($service->isNoPrice()) ? ' no-price' : ''; ?>">
                <h2><?php echo $service->getServiceName() ?></h2>
                <?php 
                    if ($service->isOptional()) {
                ?>
                    <div style="height:10px;position: absolute;right: 35px;top:0px;font-size: 12px;background-color: #6c757d!important;" class="badge bg-secondary">Optional Service</div>
                <?php }?>
                <div class="item-content-texts">
                <?php echo $services_texts[$service->getServiceId()]; ?>
                </div>
                <?php if (!$lumpSum  && !$service->isNoPrice()) { 
                    $price = (float) str_replace($s, $r, $service->getPrice());
                            $taxprice = (float) str_replace($s, $r, $service->getTaxPrice());
                            ?>
                            
                <span style="padding-left: 40px; margin-top: 0;">Total Price: <?php echo   '$'.number_format(($price-$taxprice), 2);   ?></span>
                <?php
                 } 
                    if(isset($service_images[$service->getServiceId()])){
                        if(count($service_images[$service->getServiceId()])>0){
                    ?>
                        <div style="float: right; width: 140px; margin-left:3px; position: relative; border-radius:5px; background:#25AAE1;color:#fff; padding: 3px 5px; height: 15px;">

                            <img src="data:image/png;base64, <?php echo base64_encode(file_get_contents(STATIC_PATH.'/images/fa-image.png')); ?>" width="18px" style="margin-top: 5px; position: absolute; top: -3px; left: 5px;">
                            <span style="margin-top: 1px; padding-top: 2px; width: 140px; text-align: center; position: absolute; right: 15; top: 3">

                    See Below Images</span>
                        </div>
                    <?php
                        }
                    }
            
                ?>
            


            </div>


        </div>
<?php
    }
    else {
?>
        <div id="item_<?php echo $k ?>" style="page-break-inside: avoid">
            <div class="item-content">
                <h2><?php echo $service->getServiceName() ?></h2>
                <?php echo $services_texts[$service->getServiceId()]; ?>
                <?php  if ($service->getPricingType() != 'Noprice') {
                    switch ($service->getPricingType()) {
                        case 'Trip':
                            ?>
                            <p style="padding-left: 40px;">Price Per Trip: <?php  echo $service->getFormattedPrice()  ?></p>
                            <?php
                            break;
                        case 'Season':
                            ?>
                            <p style="padding-left: 40px;">Total Seasonal Price for this item: <?php  echo $service->getFormattedPrice()  ?></p>
                            <?php
                            break;
                        case 'Year':
                            ?>
                            <p style="padding-left: 40px;">Total Yearly Price for this item: <?php  echo $service->getFormattedPrice()  ?></p>
                            <?php
                            break;
                        case 'Month':
                            ?>
                            <p style="padding-left: 40px;">Total Monthly Price for this item: <?php  echo $service->getFormattedPrice()  ?></p>
                            <?php
                            break;
                        case 'Hour':
                            ?>
                            <p style="padding-left: 40px;">This item has a <?php  echo $service->getFormattedPrice()  ?> hourly price</p>
                            <?php
                            break;
                        case 'Materials':
                            ?>
                            <p style="padding-left: 40px;">This item is priced <?php  echo $service->getFormattedPrice()  ?> Per <?php echo $service->getMaterial() ?></p>
                            <?php
                            break;
                        default:
                            //total and new one
                            ?>
                                <p style="padding-left: 40px;">Total Price for this item: <?php  echo $service->getFormattedPrice()  ?></p>
                            <?php
                            break;
                    }
                } 

                if(isset($service_images[$service->getServiceId()])){
                    if(count($service_images[$service->getServiceId()])>0){
            ?>
        
                        <div style="float: right; width: 140px; margin-left:3px; position: relative; border-radius:5px; background:#25AAE1;color:#fff; padding: 3px 5px; height: 15px;">

                            <img src="data:image/png;base64, <?php echo base64_encode(file_get_contents(STATIC_PATH.'/images/fa-image.png')); ?>" width="18px" style="margin-top: 5px; position: absolute; top: -3px; left: 5px;">
                            <span style="margin-top: 1px; padding-top: 2px; width: 140px; text-align: center; position: absolute; right: 15; top: 3">

                            See Below Images</span>
                        </div>
        
            <?php
                    }
                }
            ?>
            </div>
        </div>
<?php
    }
   

}


foreach ($services as $service) {
$imagesTest = array();
if(isset($service_images[$service->getServiceId()])){

    foreach($service_images[$service->getServiceId()] as $k => $service_image){
        if ($service_image['image']->getActive()) {
            $img = array();
            $img['src'] = $service_image['src'];
            $img['id'] = $service_image['id'];
            $img['path'] = $service_image['path'];
            if (file_exists($img['path'])) {
                $img['orientation'] = $service_image['orientation'];
                $img['title'] = $service_image['image']->getTitle();
                $img['notes'] = $service_image['image']->getNotes();
                $img['image_layout'] = $service_image['image']->getImageLayout();
                $imagesTest[] = $img;
            }
            
        }
    }
    


}

$lop = 1;

if(count($imagesTest)>0){
?>


<div  style="page-break-before: always;" >
<h2 class="service_title" style="margin: 0;"><?php echo $service->getServiceName() ?></h2>

<?php
 $n=1;
 foreach($imagesTest as $image){
    $tableOpen = false;
    if(count($imagesTest)==1){?>
                    <h2 style="text-align: center;font-weight: 400;"><?php echo $image['title'] ?></h2>
                    <div align="center">
                        <img class="<?php echo ($image['orientation'] == 'landscape') ? 'proposalImage_l' : 'proposalImage_p'; ?>" src="<?php echo $image['src']; ?>" alt="">
                    </div>
                    <p>&nbsp;</p>
                    <?php if($image['notes']){?>
                    <h2 style="text-align: center;">Notes:</h2>
                    <div style="text-align: left;"><?php echo $image['notes']; ?></div>
                    <?php }?>



               
    <?php }else{
       
        if($n ==1 || $n ==3){ 
            $tableOpen = true;
            echo '<table style="margin: auto;">';
        }
        

        ?>
        
            <tr>
                <td width="100%" height="400px" valign="top" align="center">
                    <h2 style="text-align: center; padding: 5px 0; margin: 0;margin-bottom:5px;font-weight: 400;"><?php echo $image['title']; ?></h2>
                    <div style="margin-bottom:20px">
                        <img src="<?php echo $image['src'] ?>" class="<?php echo ($image['orientation'] == 'landscape') ? 'proposalImage_l' : 'proposalImage_p'; ?>" alt="" style="height: 270px;max-width:700px; width: auto; margin: 0; padding: 0;"/>
                    </div>
                    <?php if($image['notes']){?>
                    <h2 style="text-align: center;">Notes:</h2>
                    <span class="smallNotes" style="clear:left;"><?php echo $image['notes'] ?></span>
                    <?php }?>
                </td>
            </tr>
<?php } 

        if($n ==2 || $n ==3){
            echo '</table>';
            $tableOpen = false;
        }

?>


<?php
$n++;
} 
if($tableOpen){
    echo '</table>';
   
}

?>



</div>
<?php
    }
}

?>
</div>
