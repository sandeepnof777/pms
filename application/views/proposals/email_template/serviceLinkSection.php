<?php
$service_link_viewed = json_decode($proposalView->getServiceLinksViewed());
//Service Link Viewed
if($service_link_viewed){?>

    <div class="service_link_viewed_info" style="width:100%;float: right;"><h4>Service Link Viewed</h4>
<?php
    for($i=0;$i<count($service_link_viewed);$i++){

    ?>
        <p><a class="link_wrap_text" target="_blank" href="<?=$service_link_viewed[$i]->url;?>"><?=$service_link_viewed[$i]->url;?></a></p>
    <?php } ?>
    </div>
    <?php } ?>