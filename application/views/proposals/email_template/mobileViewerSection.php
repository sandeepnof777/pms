<?php
$viewer = '<i class="fa fa-fw fa-envelope"></i> '.$proposal_preview->getEmail();
if($proposal->getClient()->getEmail() == $proposal_preview->getEmail()){
    $viewer ='<i class="fa fa-fw fa-user"></i> '.$proposal->getClient()->getFirstName().' '.$proposal->getClient()->getLastName();
}
?>

<table style="padding-left: 20%;">
    <tr><td style="text-align: right;" width="150"><strong >Viewed At: </strong></td><td style="padding-left: 10px;"><span ><?=$created_at; ?></span></td></tr>
    <tr><td style="text-align: right;" width="150"><strong >Viewer: </strong></td><td style="padding-left: 10px;"><span><?=$viewer;?></span></td></tr>
<?php
    if($proposal_preview->getClientLink()){
?>
<tr><td style="text-align: right;" width="150"><strong >Email: </strong></td><td style="padding-left: 10px;"><span><?=$proposal->getClient()->getEmail();?></span></td></tr>
<?php if($proposal->getClient()->getCellPhone()){?>
<tr><td style="text-align: right;" width="150"><strong >Contact: </strong></td><td style="padding-left: 10px;"><span><?=$proposal->getClient()->getCellPhone();?></span></td></tr>
<?php 
    }
}
?>
    <tr><td style="text-align: right;" width="150"><strong>Total Time: </strong></td><td style="padding-left: 10px;"><span><?=$formattedDuration;?></span></td></tr>
</table>

