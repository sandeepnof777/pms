<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title>Title</title>
<style type="text/css">
body {
    font-family: Helvetica, Arial, sans-serif;
    font-size: 13px;
    padding-top: 80px;
    padding-bottom: 10px;
}

#header {
    position: fixed;
    top: -25px;
    left: -10%;
    color: #000;
    border-bottom: 1px solid #666;
    padding-bottom: 15px;
    padding-left: 10%;
    width: 120%;
}

#header h2 {
    font-size: 17px;
    line-height: 20px;
    margin: 0;
    padding: 2px 0 3px 50px;
}

.sales_person {
    position: fixed;
    top: -20px;
    right: -40px;
    width: 200px;
    text-align: center;
}

h1.top {
    margin: 0;
    padding: 0 0 3px 0;
    font-size: 25px;
    line-height: 25px;
}

.address {
    font-weight: normal;
    padding-left: 50px;
    padding-top: 15px;
}

#footer {
    text-align: center;
    font-size: 11px;
    color: #999;
    font-style: italic;
    position: fixed;
    bottom: -3mm;
    left: 0;
}

h1.title {
    text-align: center;
    border-bottom: 2px solid #000000;
    padding-bottom: 2mm;
}

h1.title2 {
    text-align: center;
    padding-bottom: 2mm;
    padding-top: 40mm;
}

h1.underlined {
    border-bottom: 2px solid #000000;
    padding-bottom: 2mm;
    margin-bottom: 0;
    font-size: 38px;
}

h2 {
    font-size: 17px;
}

table {
    border-top: 1px solid #000000;
    border-left: 1px solid #000000;
    border-bottom: 1px solid #000000;
}

thead td {
    padding: 3px;
    /*border-top: 1px solid #000000;*/
    border-bottom: 1px solid #000000;
    border-right: 1px solid #000000;
}

tbody td {
    padding: 5px;
    border-top: none;
    border-bottom: none;
    border-right: 1px solid #000000;
}

tfoot td {
    padding: 5px;
    border-top: 1px solid #000000;
    border-bottom: none;
    border-right: 1px solid #000000;
}

#front_left {
    width: 45%;
    position: absolute;
    left: 0;
}

#front_right {
    width: 35%;
    position: absolute;
    right: 0;
    text-align: right;
}

.issuedby {
    text-align: center;
    padding-top: 170mm;
}

.odd {
    background: #eee;
}

.even {

}

.table-container {
    border: 1px solid #000;
}

    /* Fix for lists */
li {
    line-height: 13px;
    padding-bottom: 4px;
}

.logo {
    position: fixed;
    bottom: 20px;
    right: -30px;
    width: 200px;
    text-align: right;
}

.driving {
    font-weight: normal;
    text-align: right;
    margin: 0;
    padding: 0;
}

#footer:after {
    content: counter(page, roman);
}

.texts {
    padding-top: 0;
    padding-left: 10px;
}

.texts:first-of-type {
    padding-bottom: 20px;
}

.item-content, .driving {
    font-size: 14px;
    padding-left: 20px;
    text-align: left;
}

.driving {
    padding-left: 0;
}

.item-content h2 {
    font-size: 15px;
    margin: 0;
    padding: 0 0 5px 0;
}

.item-content ul, .item-content ol {
    margin-top: 0;
    margin-bottom: 0;
    padding-top: 0;
    padding-bottom: 5px;
    padding-left: 30px;
}

.item-content p {
    margin: 0;
    padding-left: 16px;
    padding-top: 0;
    padding-bottom: 5px;
}

.item-content li {
    line-height: 17px;
    padding-bottom: 1px;
}

.theLogo {
    width: 133px;
    height: 54px;
}

.proposalImage_l {
    width: 650px;
}

.proposalImage_p {
    height: 550px;
}
</style>
</head>
<body>
<div class="logo"><img class="theLogo" src="<?php echo UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo() ?>" alt=""></div>
<div id="footer">
    Page
    <script type="text/php">
        if ( isset($pdf) ) {
        $font = Font_Metrics::get_font("helvetica", "bold");
        $pdf->page_text(6550, 70, "{PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));
        }
    </script>
</div>
<div class="sales_person">
    <b><?php echo $proposal->getClient()->getAccount()->getFullName() ?></b><br>
    Your Point Person<br>
    <b>O: <?php echo $proposal->getClient()->getAccount()->getOfficePhone() ?></b><br>
    <b>C: <?php echo $proposal->getClient()->getAccount()->getCellPhone() ?></b>
</div>

<div id="header">
    <h1 class="top">Work Order:  <?php echo $proposal->getProjectName() ?></h1>

    <h2 class="address"><?php
        echo ($proposal->getProjectAddress()) ? $proposal->getProjectAddress() : '&nbsp;';

        if ($proposal->getProjectCity()) {
            echo ', ' . $proposal->getProjectCity();
        }
        if ($proposal->getProjectState()) {
            echo ', ' . $proposal->getProjectState();
        }
        if ($proposal->getProjectZip()) {
            echo ' '. $proposal->getProjectZip();
        }
        ?></h2>
    <?php
    if ($proposal->getJobNumber()) {
        ?>
        <h2 class="address" style="font-weight: bold; padding-left: 50px; padding-top: 0; margin: 0;">Job Number: <?php echo $proposal->getJobNumber() ?></h2>
    <?php
    } else {
        ?>
        <h2 class="address">&nbsp;</h2>
    <?php
    }
    ?>
</div>

<?php
//Directions preparation
$from = $proposal->getClient()->getAccount()->getAddress() . ', ' . $proposal->getClient()->getAccount()->getCity() . ', ' . $proposal->getClient()->getAccount()->getState() . ', ' . $proposal->getClient()->getAccount()->getZip();
$to = $proposal->getProjectAddress();
$url = 'http://maps.googleapis.com/maps/api/directions/json?origin=' . urlencode($from) . '&destination=' . urlencode($to) . '&sensor=false';
//Request Driving Directions from google
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_NOBODY, false);
//curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);
curl_close($ch);

$directions = json_decode($result, TRUE);
?>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td width="50%" valign="top">
            <h2>Driving Directions <?php echo ((@$directions['status'] == 'OK') && (is_array($directions['routes'][0]))) ? '(Total Distance: ' . @$directions['routes'][0]['legs'][0]['distance']['text'] . ')' : ''; ?></h2>
            <b>From: <?php echo $from ?></b><br>
            <b> &nbsp; &nbsp; To: <?php echo $to ?></b><br><br>
            <?php
            if ((@$directions['status'] == 'OK') && (is_array($directions['routes'][0]['legs']))) {
                ?>
                <div class="item-content">
                    <div class="driving" align="left">
                        <ul><?php
                            $s = array('<br>', '<br />', 'Destination');
                            $r = array(' ', ' ', '. Destination');
                            foreach (@$directions['routes'][0]['legs'] as $leg) {
                                foreach ($leg['steps'] as $step) {
                                    ?>
                                    <li><?php echo strip_tags(str_replace($s, $r, $step['html_instructions'] . ' (' . @$step['distance']['text'] . ')'), '<b>') ?></li><?php
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
                $s2 = array(' ', "\n", "\r", "\t");
                $r2 = array(',', '', '', '');
                $imageURL = 'http://maps.googleapis.com/maps/api/staticmap?center=' . str_replace($s2, $r2, $to) . '&zoom=15&size=520x480&key=AIzaSyBvP2a8j2c1wMiDUqHWLctcXgr5vsU80aw&sensor=false&markers=color:red|label:D|' . str_replace($s2, $r2, $to);
                $localImage = UPLOADPATH . '/work_order_maps/map_' . $proposal->getProposalId() . '.png';
                $localImageJPEG = UPLOADPATH . '/work_order_maps/map_' . $proposal->getProposalId() . '.jpg';
                if (file_exists($localImage)) {
                    unlink($localImage);
                }
                if (file_exists($localImageJPEG)) {
                    unlink($localImageJPEG);
                }
                $img = file_get_contents($imageURL);
                $f = fopen($localImage, 'w');
                fwrite($f, $img);
                fclose($f);
                $jpegImage = imagecreatefrompng($localImage);
                imagejpeg($jpegImage, $localImageJPEG, 80);
                if (file_exists($localImageJPEG)) {
                    ?>
                    <img style="margin-left: 10px; margin-top: 20px;" src="<?php echo $localImageJPEG ?>" alt="">
                <?php
                }
            }
            ?>
        </td>
    </tr>
</table>
<div style="page-break-after: always;"></div>
<h2 style="margin-bottom: 0; font-size: 20px;">Scope of Work</h2>
<?php
foreach ($proposal_items as $proposalItem) {
    ?>
    <div id="item">
        <div class="item-content">
            <?php echo $proposalItem->getItemText() ?>
        </div>
    </div>
<?php
}
?>
<?php
$k = 0;
foreach ($services as $service) {
    $k++;
    ?>
    <div id="item_<?php echo $k ?>">
        <div class="item-content">
            <h3><?php echo $service->getServiceName() ?></h3>
            <?php echo $services_texts[$service->getServiceId()]; ?>
        </div>
    </div>
<?php
}

if (count($images)) {
    foreach ($images as $image) {
        if ($image->getActivewo()) {
            $imagePath = $proposal->getUploadDir() . '/' . $image->getImage();
            if (file_exists($imagePath)) {
                $imageInfo = getimagesize($imagePath);
                if ($imageInfo[0] > $imageInfo[1]) {
                    $imageLayout = 'landscape';
                } else {
                    $imageLayout = 'portrait';
                }
                ?>
                <div style="page-break-after: always"></div>
                <br>
                <br>
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="margin-top: -50px;">
                    <tr>
                        <td border="0" width="<?php echo ($imageLayout == 'portrait') ? '400' : '550'; ?>" align="center">
                            <h2 style="text-align: center;"><?php echo $image->getTitle() ?></h2>
                            <br>
                            <img class="<?php echo ($imageLayout == 'landscape') ? 'proposalImage_l' : 'proposalImage_p'; ?>" src="<?php echo $imagePath; ?>" alt="">
                        </td>
                        <td border="0">
                            <h2>&nbsp;</h2>

                            <h2 style="text-align: center;">Notes</h2>
                            <?php
                            echo $image->getNotes();
                            ?>
                        </td>
                    </tr>
                </table>
            <?php
            }
        }
    }
}

?>
</body>
</html>