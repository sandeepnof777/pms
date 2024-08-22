<?php
$viewer = '<i class="fa fa-fw fa-envelope"></i> '.$proposal_preview->getEmail();
if($proposal->getClient()->getEmail() == $proposal_preview->getEmail()){
    $viewer ='<i class="fa fa-fw fa-user"></i> '.$proposal->getClient()->getFirstName().' '.$proposal->getClient()->getLastName();
}
?>
<p style="text-align: left;width:100%;margin: 5px 0px;">
    <strong>Viewed At: </strong><span ><?= $created_at; ?></span>
    </p>
<p style="text-align: left;margin:0px;"><strong>Viewer: </strong><span><?=$viewer;?></span></p>
<?php
    if($proposal_preview->getClientLink()){
?>
<p style="text-align: left;margin:0px;"><strong>Email: </strong><span><?=$proposal->getClient()->getEmail();?></span></p>
<?php if($proposal->getClient()->getCellPhone()){?>
<p style="text-align: left;margin:0px;"><strong>Contact: </strong><span><?=$proposal->getClient()->getCellPhone();?></span></p>
<?php 
    }
}
?>