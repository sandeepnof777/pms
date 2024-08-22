<?php
if($i!=1){
        ?>
        <div style="page-break-after: always"></div>
<?php
    }?>
<div id="map-direction">


<?php
//Directions preparation
$from = $proposal->getClient()->getCompany()->getCompanyAddress() . ', ' . $proposal->getClient()->getCompany()->getCompanyCity() . ', ' . $proposal->getClient()->getCompany()->getCompanyState() . ', ' . $proposal->getClient()->getCompany()->getCompanyZip();
if ($proposal->getOwner()->getWorkOrderAddress()) {
    $address = $this->em->find('models\Work_order_addresses', $proposal->getOwner()->getWorkOrderAddress());
    if ($address) {
        $from = $address->getFullAddress();
    }
}
$to = $proposal->getProjectAddress();
if ($proposal->getProjectCity()) {
    $to .= ', ' . $proposal->getProjectCity();
}
if ($proposal->getProjectState()) {
    $to .= ', ' . $proposal->getProjectState();
}
if ($proposal->getProjectZip()) {
    $to .= ', ' . $proposal->getProjectZip();
}
$work_order_layout = $proposal->getWorkOrderSetting();
if($work_order_layout==1)
{
    $width="360";

}else{
    $width="520";

}
$url = 'https://maps.googleapis.com/maps/api/directions/json?key=' . $_ENV['GOOGLE_API_SERVER_KEY'] . '&origin=' . urlencode($from) . '&destination=' . urlencode($to) . '&sensor=false';
//Request Driving Directions from google
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_NOBODY, false);
//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);
$directions = json_decode($result, TRUE);

$directions2 = array();
if ((@$directions['status'] == 'OK') && (is_array($directions['routes'][0]['legs']))) {
    foreach (@$directions['routes'][0]['legs'] as $leg) {
        foreach ($leg['steps'] as $step) {
            $directions2[] = $step;
        }
    }
}


?>
<table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 10px;">
    <tr>
        <td width="50%" valign="top">
            <h2>Driving
                Directions <?php echo ((@$directions['status'] == 'OK') && (is_array($directions['routes'][0]))) ? '(Total Distance: ' . @$directions['routes'][0]['legs'][0]['distance']['text'] . ')' : ''; ?></h2>
            <b>From: <?php echo $from ?></b><br>
            <b> &nbsp; &nbsp;&nbsp; To: <?php echo $to ?></b><br><br>
            <?php
            if ((@$directions['status'] == 'OK') && (is_array($directions['routes'][0]['legs']))) {
                ?>
                <div class="item-content">
                    <div class="driving" align="left">
                        <ul><?php
                            $s = array('<br>', '<br />', 'Destination');
                            $r = array(' ', ' ', '. Destination');
                            foreach ($directions2 as $index => $step) {
                                ?>
                                <li><?php echo strip_tags(str_replace($s, $r, $step['html_instructions'] . ' (' . @$step['distance']['text'] . ')'), '<b>') ?></li>
                                <?php
                                if ($index >= 15) {
                                    break;
                                }
                            }
                            ?></ul>
                    </div>
                </div>
                <?php
            } else {
                ?>No driving directions available.<?php
            }
            ?>
        </td>
        <td width="50%" valign="top">
            <?php
            if ((@$directions['status'] == 'OK') && (is_array($directions['routes'][0]['legs']))) {
                $s2 = array(' ', "\n", "\r", "\t", '#');
                $r2 = array(',', '', '', '', '');
                $imageURL = 'http://maps.googleapis.com/maps/api/staticmap?center=' . urlencode(str_replace($s2, $r2, $to)) . '&zoom=15&size='.$width.'x480&key=AIzaSyBvP2a8j2c1wMiDUqHWLctcXgr5vsU80aw&sensor=false&markers=color:red|label:D|' . str_replace($s2, $r2, $to);
                $localImage = UPLOADPATH . '/work_order_maps/map_' . $proposal->getProposalId() . '.png';
                $localImageJPEG = UPLOADPATH . '/work_order_maps/map_' . $proposal->getProposalId() . '.jpg';
                if (file_exists($localImage)) {
                    unlink($localImage);
                }
                if (file_exists($localImageJPEG)) {
                    unlink($localImageJPEG);
                }
                $img = @file_get_contents($imageURL);
                if ($img) {
                    $f = fopen($localImage, 'w');
                    fwrite($f, $img);
                    fclose($f);
                    $jpegImage = imagecreatefrompng($localImage);
                    imagejpeg($jpegImage, $localImageJPEG, 80);
                }
                if (file_exists($localImageJPEG)) {
                    ?>
                    <img style="margin-left: 10px; margin-top: 20px;" src="data:image/png;base64, <?php echo base64_encode(file_get_contents($localImageJPEG)) ?>" alt="">
                    <?php
                }
            }
            ?>
        </td>
    </tr>
</table>



<?php if (count($plantDirections)) : ?>
    <div style="page-break-after: always;"></div>
    <?php foreach ($plantDirections as $plantId => $directions) : ?>

        <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: 10px;">
            <tr>
                <td width="50%" valign="top">
                    <h2>Trucking Directions (Total Distance: <?php echo $directions['distance']; ?> miles)</h2>
                    <b>From
                        Plant: <?php echo $directions['plant']->getCompanyName() . " " . $directions['plant']->getName(); ?></b><br>
                    <b>To: <?php echo $to ?></b><br><br>
                    <?php
                    if (count($directions['directions'])) {
                        ?>
                        <div class="item-content">
                            <div class="driving" align="left">
                                <ul><?php
                                    $s = array('<br>', '<br />', 'Destination');
                                    $r = array(' ', ' ', '. Destination');
                                    foreach ($directions['directions'] as $index => $step) {
                                        ?>
                                        <li><?php echo $step->instruction->text; ?></li>
                                        <?php
                                        if ($index >= 15) {
                                            break;
                                        }
                                    }
                                    ?></ul>
                            </div>
                        </div>
                        <?php
                    } else {
                        ?>No driving directions available.<?php
                    }
                    ?>
                </td>
                <td width="50%" valign="top">
                    <?php

                    $localImage = UPLOADPATH . '/work_order_maps/map_' . $proposal->getProposalId() . '-' . $plantId . '.png';

                    if (file_exists($localImage)) {
                        ?>
                        <img style="margin-left: 10px; margin-top: 20px;" src="<?php echo $localImage ?>" alt="">
                        <?php
                    }

                    ?>
                </td>
            </tr>
        </table>


    <?php endforeach; ?>
<?php endif; ?>

<?php
$directions23 = array_slice($directions2,0,29);
if (count($directions23) > 15) {
    ?>
    <ul>
        <?php
        foreach ($directions23 as $index => $step) {
            if ($index > 15) {
                ?>
                <li><?php echo strip_tags(str_replace($s, $r, $step['html_instructions'] . ' (' . @$step['distance']['text'] . ')'), '<b>') ?></li>
                <?php
            }
        }
        ?>
    </ul>
    
    <?php
}
?>
</div><!--Close map-direction-->