<?php
if($i!=1){
        ?>
        <!-- <div style="page-break-after: always"></div> -->
<?php
    }?>
<div id="project_specifications">
 <?php if(!empty($proposal_items)){?>
<h2 style="margin-bottom: 0; font-size:16px; margin-top:20px;">Scope of Work</h2>
<?php
 foreach ($proposal_items as $proposalItem) {
    ?>
    <div id="item" style="page-break-inside:avoid">
        <div class="item-content" >
            <?php echo $proposalItem->getItemText() ?>
        </div>
    </div>
    <?php
}
}
?>
<?php
$k = 0;
foreach ($services as $service) {
    $k++;
    // Don't show optional services
    if (!$service->isOptional()) {
    ?>
    <div id="item_<?php echo $k ?>" style="page-break-inside: avoid">
        <div class="item-content">
            <h3><?php echo $service->getServiceName() ?></h3>
            <?php echo $services_texts[$service->getServiceId()]; ?>
        </div>
    </div>
    <?php
    }
}
?>

<?php
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

    
    
    <?php
     $n=1;
     foreach($imagesTest as $image){
    
            ?>
        <div style="page-break-before: always;"></div>
        <h2 class="service_title" style="margin: 0;text-align: center;"><?php echo $service->getServiceName() ?></h2>
                <table border="0"  cellpadding="0" cellspacing="0" width="100%" style="margin-left:auto;margin-right:auto;">
                    <tr>
                        <td><h2 style="text-align: center;"><?php echo $image['title'] ?></h2></td>
                        <td><h2 style="text-align: center; vertical-align: top;">Notes</h2></td>
                    </tr>
                    <tr>
                        <td  border="1"   align="center" style="text-align: center;">
                                <img align="center" style="width:auto;height:400px;" class="<?php echo ($image['orientation'] == 'landscape') ? 'proposalImage_l' : 'proposalImage_p'; ?>"
                                   
                                     src="<?php echo $image['src']; ?>" alt="">
                                
                        </td>
                        <td class="imageNotes" style="vertical-align: top;">
                            <?php echo $image['notes'] ?: '<p style="text-align:center;">No Image Notes</p>'; ?>
                        </td>
                    </tr>
                </table>
    
    
    <?php
    
    } 
 
    ?>
    
    
  
    <?php
        }
    }
?>
</div><!--Close project_specifications-->