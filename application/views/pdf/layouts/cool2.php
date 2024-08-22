<?php
    $headerFont = $proposal->getClient()->getCompany()->getCoolHeaderFont();
    $bodyFont = $proposal->getClient()->getCompany()->getCoolTextFont();
    /* @var \models\ProposalSignee $clientSig */
    /* @var \models\ProposalSignee $companySig */
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
<title>Title</title>
<base target="_blank">
<style type="text/css">
    /*Page Margins*/
html {
    margin: 12.5mm;
    padding: 0;
}

    /*Global stuff*/
body {
    font-family: <?php echo $bodyFont ?>, Sans-Serif !important;
    font-size: 13px;
    line-height: 1.1;
    padding-top: 50px;
    padding-bottom: 10px;
    /*word-spacing: 0.15em;*/
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


    #footer:after {
        content: "Page " counter(page, roman);
    }

h1 {
    font-size: 24px;
    font-family: <?php echo $headerFont ?>, Sans-Serif !important;
    /*font-size: 20px;*/
}

h2 {
    font-size: 20px;
    font-family: <?php echo $headerFont ?>, sans-serif !important;
    /*font-size: 14px;*/
}

h3 {
    font-family: <?php echo $headerFont ?>, sans-serif !important;
    font-size: 17px;
}

    /*
    First Page
    */
h1.title_big {
    font-size: 38px;
    text-align: center;
    padding-top: 30mm;
    padding-bottom: 5mm;
}

.company_name {
    font-size: 27px;
    line-height: 38px;
}

.company_owner {
    font-size: 19px;
    line-height: 28px;
}

.company_name, .company_owner {
    padding: 0;
    margin: 0;
}

.issuedby {
    width: 200px;
    line-height: 21px;
    text-align: center;
    position: absolute;
    right: 0;
    top: 850px;
}

.issuedby img {
    height: 60px;
    width: auto;
    margin-bottom: 7px;
}

    /*
    Second Page
    */
h1.title_big2 {
    font-size: 34px;
    text-align: center;
    padding-bottom: 15mm;
    padding-top: 5px;
    margin: 0;
}

h1.title_big_aboutus {
    font-size: 34px;
    text-align: center;
    padding-bottom: 0;
    padding-top: 12mm;
}

.aboutus {
    padding: 0 50px;
}

.relative {
    position: relative;
    height: 500px;
}

.half_left, .half_right {
    width: 300px;
    position: absolute;
    top: 200px;
    text-align: center;
}

.half_right h2, .half_left h2 {
    text-align: center;
    padding-bottom: 15px;
}

.half_right p, .half_left p {
    padding: 0;
    margin: 0;
    line-height: 20px;
}

.half_left {
    left: 0;
}

.half_left img {
    height: 60px;
    width: auto;
    margin-bottom: 7px;
}

.half_right {
    right: 0;
}

    /*Second Page, second layout*/
.page2_cinfo_heading, .page2_cperson_heading {
    width: 250px;
    text-align: right;
    position: absolute;
    left: 0;
}

.page2_cinfo_heading {
    top: 250px;
}

.page2_cperson_heading {
    top: 450px;
}

.page2_cinfo, .page2_cperson {
    width: 300px;
    position: absolute;
    right: 30px;
    text-align: center;
}

.page2_cinfo img {
    height: 100px;
    width: auto;
}

.page2_cinfo {
    top: 245px;
}

.page2_cperson {
    top: 445px;
}

.page2_cinfo p, .page2_cperson p {
    line-height: 17px;
    margin: 5px 0 0 0;
    padding: 0;
}

    /*Third Page*/

h1.title_big3 {
    font-size: 28px;
    text-align: center;
    padding-top: 0;
    line-height: 50px;
    border-bottom: 2px solid #000;
    padding-right: 110px;
}

h1.title_big3 img {
    position: absolute;
    right: 0;
    top: 0;
    height: 50px;
    width: auto;
}

    /*Proposal Stuff*/
h1.title {
    text-align: center;
    border-bottom: 2px solid #000000;
    padding-bottom: 2mm;
}

h1.underlined {
    border-bottom: 2px solid #000000;
    padding-bottom: 1mm;
    margin-bottom: 1mm;
}

table, table tr td {
    border: none;
    padding: 5px;
}

    /*
table {
    border-top: 1px solid #000000;
    border-left: 1px solid #000000;
    border-bottom: 1px solid #000000;
}

thead td {
    padding: 3px;
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
*/

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

.odd {
    background: #eee;
}

.even {

}

.table-container {
    /*border: 1px solid #000;*/
}

    /* Fix for lists */
li {
    line-height: 1.1;
    margin-bottom: 5px;
}

.clear {
    clear: both;
}

.logotopright {
    width: 150px;
    height: 50px;
    position: fixed;
    right: -23px;
    top: -20px;
    text-align: right;
    z-index: 201;
}

.logotopright-hider {
    width: 155px;
    height: 60px;
    position: absolute;
    right: -30px;
    top: -27px;
    background: #fff;
    z-index: 205;
}

.header_fix {
    position: absolute;
    top: -25px;
    left: 0;
    width: 100%;
}

.global_header {
    position: absolute;
    top: -25px;
    left: 0;
    z-index: 100;
    font-size: 24px;
    width: 100%;
}

.header-hider {
    position: absolute;
    width: 100%;
    height: 65px;
    background: #fff;
    z-index: 105;
    top: -70px;
}

.theLogo {
    width: 135px;
    height: 45px;
}

.item-content h1, .item-content h2 {
    margin: 10px 0 0 0;
}

.item-content {
    margin: 0;
    padding: 0;
}

.item-content.no-price {
    background-color: #dddddd;
    border-radius: 10px;
}

.item-content.audit{
    border-left: 1px solid #000;
    border-right: 1px solid #000;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    margin-bottom: 20px;
}

.item-content .audit-footer {
    height: 15px;
    background: #000;
    width: 100%;
    border: 1px solid #000;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
}

.item-content.no-price h2, .item-content.audit h2 {
    background-color: #000000;
    color: #ffffff;
    padding: 10px 20px;
    margin-top: 0;
}


.item-content-texts {
    padding-right: 10px;
}

.proposalImage_p {
    /*Portrait*/
    width: 50%;
    height: auto;
}

.proposalImage_l {
    /*Landscape*/
    width: 90%;
    height: auto;
}

#videoURL {
    text-align: center;
    padding: 20px 0;
}

#videoURL a {
    width: 120px;
    text-align: center;
    margin: 0 auto;
    text-decoration: none;
    padding: 3px 0;
    border-radius: 5px;
}
#proposalAuditLink {
    text-align: center;
    padding: 20px 0;
}


#proposalAuditLink a {
    width: 120px;
    text-align: center;
    margin: 0 auto;
    text-decoration: none;
    padding: 3px 0;
    border-radius: 5px;
    display: block;
}

#auditIcon {
    width: 100px;
    height: 100px;
}

b, strong, i {
    margin: 0 2px 0 0;
    line-height: 1.1;
}

span {
    margin: 0 2px 0 0;
    line-height: 1.1;
}

    /* 2 and 4 images per page layout classes */
.two-page-landscape {
    height: 150px;
    width: auto;
    margin: 0 auto;
}

.two-page-portrait {
    height: 150px;
    width: auto;
    margin: 0 auto;
}

.four-page-landscape {
}

.four-page-portrait {
}

.smallNotes {
    padding: 10px 10px 0;
    font-size: 11px;
    text-align: left;
}

.smallNotes p {
    margin: 0 0 3px 0;
    text-align: left;
}

.inventoryTable th {
    text-align: left;
    padding: 10px 5px;
    background-color: #b5b5b5;
}

</style>
</head>
<body>
<?php
/* @var \models\Proposals $proposal */
$s = array('$', ',');
$r = array('', '');
/*
* First Page
*/
?>

<h1 class="title_big"><?php echo $proposal->getProposalTitle() ?></h1>

<div align="center" style="padding-bottom: 35mm;">
    <img src="<?php echo UPLOADPATH ?>/separator.jpg" width="90%">
</div>
<?php if ($proposal->getClient()->getClientAccount()->getName()) { ?>
    <h2 class="company_name" style="text-align: center;"><?php echo ($proposal->getClient()->getClientAccount()->getName() == 'Residential') ? 'Residential Proposal' : $proposal->getClient()->getClientAccount()->getName();  ?></h2>
<?php } ?>
<h3 class="company_owner" style="text-align: center; padding-bottom: 100px;"><?php echo $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName()  ?></h3>

<h3 class="company_owner" style="text-align: center; font-size: 15px !important; line-height: 17px; margin-bottom: 15   px;">Project:</h3>

<h3 class="company_owner" style="text-align: center; margin-bottom: 0; padding-bottom: 0; line-height: 22px;"><?php echo $proposal->getProjectName()  ?></h3>
<?php if ($proposal->getProjectAddress()) { ?>
    <h4 style="text-align: center; margin-top: 0; padding-top: 0; font-weight: normal; font-size: 13px;"><?php echo $proposal->getProjectAddress() ?><br><?php echo $proposal->getProjectCity() . ', ' . $proposal->getProjectState() . ' ' . $proposal->getProjectZip() ?></h4>
<?php } ?>
<div class="issuedby">
    <p class="clearfix" style="line-height: 16px;">
        <img class="theLogo" src="<?php echo UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo() ?>" alt=""><br>
        <?php echo $proposal->getOwner()->getFullName() ?><br>
        <?php echo $proposal->getOwner()->getTitle() ?>
    </p>
</div>
<div style="page-break-after: always"></div>
<?php
/*
* Second Page
*/
?>
<div class="header-hider"></div>
<div class="logotopright-hider"></div>


<h1 class="title_big2" style="z-index: 200;"><?php echo $proposal->getClient()->getCompany()->getPdfHeader() ?></h1>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td align="center" width="50%"><h2>Company Info</h2></td>
        <td align="center" width="50%"><h2>Contact Person</h2></td>
    </tr>
    <tr>
        <td align="center" width="50%">
            <img class="theLogo" src="<?php echo UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo() ?>" alt="">

            <p><?php echo $proposal->getClient()->getCompany()->getCompanyName() ?><br>
                <?php echo $proposal->getOwner()->getAddress() ?><br>
                <?php echo $proposal->getOwner()->getCity() ?>, <?php echo $proposal->getOwner()->getState() ?> <?php echo $proposal->getOwner()->getZip() ?><br>
                <br>
                P: <?php echo $proposal->getOwner()->getOfficePhone() ?><br>
                <?php if ($proposal->getClient()->getCompany()->getFax() || $proposal->getOwner()->getFax()) { ?>
                    F: <?php echo ($proposal->getOwner()->getFax()) ? $proposal->getOwner()->getFax() : $proposal->getClient()->getCompany()->getFax() ?><br>
                <?php } ?>
                <a href="<?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?>"><?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?></a><br>
            </p>
        </td>
        <td align="center" width="50%">
            <p style="padding-top: 0; margin-top: 0;"><?php echo $proposal->getOwner()->getFullName() ?><br>
                <?php echo $proposal->getOwner()->getTitle() ?><br>
                <a href="mailto:<?php echo $proposal->getOwner()->getEmail() ?>"><?php echo $proposal->getOwner()->getEmail() ?></a><br>
                Cell: <?php echo $proposal->getOwner()->getCellPhone() ?><br />
                Office <?php echo $proposal->getOwner()->getOfficePhoneExt() ? $proposal->getOwner()->getOfficePhone() . ' Ext ' . $proposal->getOwner()->getOfficePhoneExt() : $proposal->getOwner()->getOfficePhone(); ?>
            </p>
        </td>
    </tr>
</table>
<h1 class="title_big_aboutus">About Us</h1>
<!--<p class="aboutus">--><?php //echo preg_replace('!http://([a-zA-Z0-9./-]+[a-zA-Z0-9/-])!i', '<a href="\\0" target="_blank">\\0</a>', nl2br($proposal->getClient()->getCompany()->getAboutCompany())) ?><!--</p>-->
<p class="aboutus"><?php echo $proposal->getClient()->getCompany()->getAboutCompany() ?></p>

<div style="page-break-after: always"></div>
<?php
/*
 * Fourth page
 */
?>
<div class="logotopright"><img class="theLogo" style="height: 40px; width: 120px; margin-right: 8px;" src="<?php echo UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo() ?>" alt=""></div>
<div id="footer">
    <!--Page-->

</div>
<h1 class="underlined global_header" style="position: fixed;">Proposal: <?php echo $proposal->getProjectName() ?></h1>
<?php
    if ($proposal->getVideoURL() <> '') {
?>
    <div id="videoURL">
        <a href="<?php echo $proposal->getVideoURL() ?>" target="_blank"><img src="<?php echo UPLOADPATH ?>/proposal-video.jpg" width="90%"></a>
    </div>
<?php
}

    if ($proposal->getAuditKey()) {
?>
        <div style="page-break-inside: avoid">
            <div class="item-content audit">
                <h2>Property Inspection / Audit</h2>

                <table>
                    <tr>
                        <td style="text-align: center">
                            <a href="<?php echo $proposal->getAuditReportUrl(true) ?>" target="_blank" style="display: block">
                                <img id="auditIcon" src="<?php echo UPLOADPATH ?>/audit-icon.png" />
                            </a>
                            <p style="text-align: center; font-weight: bold; font-style: italic;">Click to See</p>
                        </td>
                        <td style="font-size: 16px;">
                            <p>We have performed a custom site inspection/audit of this site including maps, images and more</p>
                            <p><a href="<?php echo $proposal->getAuditReportUrl(true) ?>" target="_blank">View your Custom Site Inspection/Audit Report</a></p>
                        </td>
                    </tr>
                </table>
                <div class="audit-footer"></div>
            </div>
        </div>
<?php    }

$k = 0;
foreach ($services as $service) {

    $k++;

    if(!$proposal->hasSnow()){
?>
        <div id="item_<?php echo $k ?>" style="page-break-inside: avoid">
            <div class="item-content<?php echo ($service->isNoPrice()) ? ' no-price' : ''; ?>">
                <h2><?php echo $service->getServiceName() ?></h2>
                <div class="item-content-texts">
                <?php echo nl2br($services_texts[$service->getServiceId()]); ?>
                </div>
                <?php if (!$lumpSum  && !$service->isNoPrice()) { 
                    $price = str_replace($s, $r, $service->getPrice());
                            $taxprice = str_replace($s, $r, $service->getTaxPrice());
                            ?>
                            
                <span style="padding-left: 40px; margin-top: 0;">Total Price: <?php  echo   '$'.number_format(($price-$taxprice), 2);   ?></span>
               
                <?php } ?>
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
                } ?>
            </div>
        </div>
<?php
    }
}

$images2 = array();
/*Proposal Images*/
if (count($images)) {
    
    foreach ($images as $image) {
        if ($image->getActive()) {
            $img = array();
            $img['src'] = $proposal->getUploadDir() . '/' . $image->getImage();
            $img['path'] = $proposal->getPathUploadDir() . '/' . $image->getImage();
            if (file_exists($img['path'])) {
                $imageInfo = getimagesize($img['path']);
                if ($imageInfo[0] > $imageInfo[1]) {
                    $img['orientation'] = 'landscape';
                } else {
                    $img['orientation'] = 'portrait';
                }
                $img['title'] = $image->getTitle();
                $img['notes'] = $image->getNotes();
               
                $img['image_layout'] = $image->getImageLayout();
            }
            $images2[] = $img;
        }
    }
    //new world order code
    $imageCount = 0; //image counter
    $tableOpen = 0; //variable to check if the table open
    $old_layout = 0;
    foreach ($images2 as $image) {
       
        switch ($image['image_layout']) {
            case 1:
                //open table
                if (!($imageCount % 2)) {
                    ?>
                    <div style="page-break-after: always"></div>
                    <div style="width:100%;" border="0"><?php
                    $tableOpen = 1;
                }
                //display image
                ?>
                <div style="width:50%;position: relative;">
                    <div style="width:100%;position: relative; height:420px" valign="top" align="center">
                        <h2 style="text-align: center; padding: 10px 0; margin: 0;"><?php echo $image['title'] ?></h2>
                        <img src="<?php echo $image['src'] ?>" alt="" style="height: 290px; width: auto; margin: 0; padding: 0;"/>

                        <div class="smallNotes"><?php echo $image['notes'] ?></div>
                    </div>
                </div>
                <?php
                //increment counter
                $imageCount++;
                //close table
                if ($imageCount % 2 == 0) {
                    ?>
                    </div>
                    <?php
                    $tableOpen = 0;
                }
                break;
            case 2:
                //open table
                if (!($imageCount % 4)) {
                    ?>
                    <div style="page-break-after: always"></div>
                    <div style="width:100%;" border="0"><?php
                    $tableOpen = 1;
                }
                //display image
            if (!($imageCount % 2)) {
                ?>
                <div style="width:100%;float: left;">
            <?php
            }

                ?>
                <div style="width:50%;height:420px;float: left;"  valign="top" align="center">
                    <h2><?php echo $image['title'] ?></h2>

                    <div style="width:50%;    ">
                        <img src="<?php echo $image['src'] ?>" alt="" style="height: 190px; width: auto;"/>
                    </div>
                    <div class="smallNotes"><?php echo $image['notes'] ?></div>
                </div>
                <?php


            if ($imageCount % 2) {
                ?>
                </div>
            <?php
            }
                //increment counter
                $imageCount++;
                //close table
                if ($imageCount % 4 == 0) {
                    ?>
                    </div>
                    <?php
                    $tableOpen = 0;
                }
                break;
            default: //1 image per page

            if ($tableOpen) {
                 if ($old_layout == 1) {
                    //close table
                     echo '</div>';
                 } else {
                    //close tr's if necessary...
                     if ($imageCount % 2) {
                         echo '<div style="width:50%;"></div></div>';
                     }
                    //close table
                    echo '</div>';
                }
            }
        
                ?>
                    <div style="page-break-after: always"></div>
                    <h2 style="text-align: center;"><?php echo $image['title'] ?></h2>
                    <div align="center">
                        <img class="<?php echo ($image['orientation'] == 'landscape') ? 'proposalImage_l' : 'proposalImage_p'; ?>" src="<?php echo $image['src']; ?>" alt="">
                    </div>
                    <p>&nbsp;</p>
                    <h2 style="text-align: center;">Notes:</h2>
                    <div style="text-align: left;"><?php echo $image['notes']; ?></div>
                <?php
                break;
        }
        $old_layout = $image['image_layout'];
    }
    //close tables in case they are not closed
    if ($tableOpen) {
        if ($old_layout == 1) {
           //close table
            echo '</div>';
        } else {
           //close tr's if necessary...
            if ($imageCount % 2) {
                echo '<div style="width:50%;"></div></div>';
            }
           //close table
           echo '</div>';
       }
   }
}

/*
 * Total price page
 */
?>
<div style="page-break-after: always"></div>
<!--Hide Header code start-->
<div class="header-hider"></div>
<!--Hide Header code end-->
<h1 class="underlined header_fix" style="z-index: 200; font-size: 24px;">Price Breakdown: <?php echo $proposal->getProjectName()  ?></h1>
<!--<p>&nbsp;</p>-->
<p>Please find the following breakdown of all services we have provided in this proposal.</p>
<p>This proposal originated on <?php echo date('F d, Y', $proposal->getCreated(false)) ?>.
    <?php
    if ($proposal->getJobNumber()) {
        ?>
        <strong>Job Number:</strong> <?php echo $proposal->getJobNumber() ?>
    <?php
    }
    ?>
</p>

<?php

    // Separate optional services, and no price services
    $optionalServices = [];
    $taxServices = [];
    foreach ($services as $k => $serviceItem) {
        if ($serviceItem->isOptional()) {
            unset($services[$k]);
            $optionalServices[] = $serviceItem;
        }
        if($serviceItem->isNoPrice()) {
            unset($services[$k]);
        }
        if ($serviceItem->getTax()) {
            unset($services[$k]);
            $taxServices[] = $serviceItem;
        }
    }


    // Use standard layout for non-snow
    if(!$proposal->hasSnow()){
?>
        <div class="table-container">
            <table width="100%" class="table" border="0">
                <thead>
                <tr>
                    <td width="10%"><strong>Item</strong></td>
                    <td width="65%"><strong>Description</strong></td>
                    <td width="25%" style="text-align: right"><strong>Cost</strong></td>
                </tr>
                </thead>
                <tbody>
                <?php
                $k = 0;
                $total = 0;
                $taxTotal = 0;
                $taxSubTotal = 0;
                $isTaxApplied =false;
                foreach ($services as $service) {
                    $k++;
                    $taxprice = str_replace($s, $r, $service->getTaxPrice());
                    ?>
                    <tr>
                        <td <?php if ($k % 2) {
                            echo 'class="odd"';
                        } ?>><?php echo $k; ?></td>
                        <td <?php if ($k % 2) {
                            echo 'class="odd"';
                        } ?>> <?php
                        if($taxprice>0){echo '<span style="font-weight:bold;vertical-align: sub;">* </span>'; $isTaxApplied =true;}
                            //fix for the price breakdown to show service name instead of Additional Service
                            echo $service->getServiceName();
                            ?></td>
                        <td <?php echo ($k % 2) ? ' class="odd"' : ''; ?> style="text-align: right">
                        <?php
                            // Price required for calculations
                            $price = str_replace($s, $r, $service->getPrice());
                            

                            if ($lumpSum) {
                                echo 'Included';
                            }
                            else {
                                //echo $service->getFormattedPrice();
                                echo '$'.number_format(($price-$taxprice), 2); 
                            }
                        ?>
                        </td>
                    </tr>
                    <?php
                    $total += $price;
                    $taxSubTotal += $taxprice;
                }
                ?>
                </tbody>
                <?php if (!isset($hideTotalPrice) || !$hideTotalPrice) { ?>
                    <tfoot>
                    <?php if (count($taxServices)) { ?>
                        <tr>
                            <td></td>
                            <td align="right">Subtotal:</td>
                            <td style="text-align: right">$<?php echo number_format($total, 2) ?></td>
                        </tr>
                        <?php
                        foreach ($taxServices as $taxService) {
                            $taxTotal += $taxService->getPrice(true);
                        }
                        ?>
                        <tr>
                            <td></td>
                            <td align="right">Tax:</td>
                            <td style="text-align: right">$<?php echo number_format($taxTotal, 2) ?></td>
                        </tr>
                    <?php } ?>
                    <?php if ($taxSubTotal>0) { ?>
                    <tr>
                            <td></td>
                            <td align="right"><strong>Tax:</strong></td>
                            <td style="text-align: right">$<?php echo number_format($taxSubTotal, 2) ?></td>
                        </tr>
                    <?php } ?>
                        <tr>
                            <td></td>
                            <td align="right"><strong>Total:</strong></td>
                            <td style="text-align: right"><strong>$<?php echo number_format($total + $taxTotal, 2) ?></strong></td>
                        </tr>
                        </tfoot>
                <?php
                }?>
            </table>
        </div>
<?php
        if (count($optionalServices)) {
?>
            <h2>Optional Services:</h2>
            <div class="table-container">
                <table width="100%" class="table" border="0">
                    <thead>
                    <tr>
                        <td width="10%"><strong>Item</strong></td>
                        <td width="65%"><strong>Description</strong></td>
                        <td width="25%" style="text-align: right"><strong>Cost</strong></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $k = 0;
                    $total = 0;
                    $taxSubTotal = 0;
                    $isTaxApplied =false;
                    foreach ($optionalServices as $service) {
                        $k++;
                        $taxprice = str_replace($s, $r, $service->getTaxPrice());
                        ?>
                        <tr>
                            <td <?php if ($k % 2) {
                                echo 'class="odd"';
                            } ?>><?php echo $k; ?></td>
                            <td <?php if ($k % 2) {
                                echo 'class="odd"';
                            } ?>><?php
                            if($taxprice>0){echo '<span style="font-weight:bold;vertical-align: sub;">* </span>'; $isTaxApplied =true;}
                                //fix for the price breakdown to show service name instead of Additional Service
                                echo $service->getServiceName();
                                ?></td>
                            <td <?php echo ($k % 2) ? ' class="odd"' : ''; ?> style="text-align: right">
                            <?php
                            // Price required for calculations
                            $price = str_replace($s, $r, $service->getPrice());
                            

                                //echo $service->getFormattedPrice();
                                echo '$'.number_format(($price-$taxprice), 2); 
                           
                        ?>
                        </td>
                    </tr>
                    <?php
                    $total += $price;
                    $taxSubTotal += $taxprice;

                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <?php if ($taxSubTotal>0) { ?>
                    <tr>
                            <td></td>
                            <td align="right"><strong>Tax:</strong></td>
                            <td style="text-align: right">$<?php echo number_format($taxSubTotal, 2) ?></td>
                        </tr>
                    <?php } ?>
                        <tr>
                            <td></td>
                            <td align="right"><strong>Total:</strong></td>
                            <td style="text-align: right"><strong>$<?php echo number_format($total + $taxTotal, 2) ?></strong></td>
                        </tr>
                        </tfoot>
                </table>
            </div>
<?php
        }
    }
    else{
        // Snow proposal
?>
        <div class="table-container">
            <h4 style="margin-top: 0; padding-top: 0; margin-bottom: 0; padding-bottom: 0; font-size:15px">Service Pricing</h4>
            <table width="100%" class="table" border="0" style="margin-bottom: 0;">
                <thead>
                <tr>
                    <td width="20"><strong>Item</strong></td>
                    <td width="200"><strong>Description</strong></td>
                    <td><strong>Freq.</strong></td>
                    <td><strong>Type</strong></td>
                    <td align="right"><strong>Price</strong></td>
                    <td align="right"><strong>Total</strong></td>
                </tr>
                </thead>
                <tbody>
                <?php
                $k = 0;
                $total = 0;
                $hiddenPrices = array('Noprice', 'Hour', 'Materials');
                $timeMaterialServices = array('Hour', 'Materials');
                $fixedPrices = array('Total', 'Year');
                $timeMaterial = false;
                foreach ($services as $service) {
                    if (in_array($service->getPricingType(), $timeMaterialServices)) {
                        $timeMaterial = true;
                    }
                    if (!in_array($service->getPricingType(), $hiddenPrices) && !in_array($service->getPricingType(), $timeMaterialServices)) {
                        $k++;
                        $class = ($k % 2) ? 'odd' : '';
                        ?>
                        <tr>
                            <td class="<?php echo $class; ?>"><?php echo $k; ?></td>
                            <td class="<?php echo $class; ?>"><?php
                                //fix for the price breakdown to show service name instead of Additional Service
                                echo $service->getServiceName();
                                ?></td>
                            <td class="<?php echo $class; ?>"><?php
                                if (!in_array($service->getPricingType(), $hiddenPrices) && !in_array($service->getPricingType(), $fixedPrices)) {
                                    $amountQty = (is_numeric($service->getAmountQty())) ? $service->getAmountQty() : 0;
                                    echo $amountQty;
                                }
                                ?></td>
                            <td class="<?php echo $class; ?>"><?php
                                switch ($service->getPricingType()) {
                                    case 'Total':
                                        echo 'Fixed Price';
                                        break;
                                    default:
                                        echo 'Per ' . $service->getPricingType();
                                        break;
                                }
                                ?></td>
                            <td align="right" class="<?php echo $class; ?>">$<?php
                                $price = str_replace($s, $r, $service->getPrice());
                                echo @number_format($price, 2);
                                ?></td>
                            <td class="<?php echo $class; ?>" align="right"><?php
                                if (!in_array($service->getPricingType(), $hiddenPrices)) {
                                    if (in_array($service->getPricingType(), $fixedPrices)) {
                                        $amountQty = 1;
                                    }
                                    $partialTotal = (str_replace($s, $r, $price) * $amountQty);
                                    echo '$' . number_format($partialTotal, 2);
                                }
                                ?></td>
                        </tr>
                        <?php
                        if (!in_array($service->getPricingType(), $hiddenPrices)) {
                            $total += $partialTotal;
                        }
                    }
                }
                ?>
                </tbody>
                <?php if (!isset($hideTotalPrice) || !$hideTotalPrice) { ?>
                    <tfoot>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td align="right"><b>Total</b></td>
                        <td align="right"><b>$<?php echo number_format($total, 2) ?></b></td>
                    </tr>
                    </tfoot>
                <?php } ?>
            </table>
            <?php if ($timeMaterial) { ?>
                <h4 style="margin-top: 0; padding-top: 0; margin-bottom: 0; padding-bottom: 0; font-size: 15px">Time & Material Items</h4>
                <table width="100%" class="table" border="0">
                    <thead>
                    <tr>
                        <td width="20"><strong>Item</strong></td>
                        <td width="350"><strong>Description</strong></td>
                        <td align="right"><strong>Price</strong></td>
                        <td align="right"><strong>Type</strong></td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $k = 0;
                    foreach ($services as $service) {
                        if (in_array($service->getPricingType(), $timeMaterialServices)) {
                            $k++;
                            $class = ($k % 2) ? 'odd' : '';
                            ?>
                            <tr>
                                <td class="<?php echo $class; ?>"><?php echo $k; ?></td>
                                <td class="<?php echo $class; ?>"><?php echo $service->getServiceName(); ?></td>
                                <td align="right" class="<?php echo $class; ?>">$<?php
                                    $price = str_replace($s, $r, $service->getPrice());
                                    echo @number_format($price, 2);
                                    ?></td>
                                <td align="right" class="<?php echo $class; ?>">Per <?php echo ($service->getPricingType() != 'Materials') ? $service->getPricingType() : $service->getMaterial(); ?></td>
                            </tr>
                        <?php
                        }
                    }
                    ?>
                    </tbody>
                </table>
            <?php } ?>
        </div>
<?php
    }

    if($isTaxApplied){?> 
    <p><span style="font-weight:bold;vertical-align: sub;">*</span> Price excludes Tax</p>
    <?php 
    }
?>



<?php if (trim($proposal->getClient()->getCompany()->getContractCopy())) { ?>
    <h2 style="margin-top: 2px; margin-top: 20px;">Authorization to Proceed & Contract</h2>
    <p style="padding: 0; margin: 0;"><?php echo ($proposal->getContractCopy()) ? $proposal->getContractCopy() : $proposal->getClient()->getCompany()->getContractCopy() ?></p>
<?php } ?>

<div style="page-break-inside: avoid">

<h2 style="margin-top: 10px;">Payment Terms</h2>

<p style="padding: 0; margin: 0;"><?php echo ($proposal->getPaymentTerm() == 0) ? 'We agree to pay the total sum or balance in full upon completion of this project.' : 'We agree to pay the total sum or balance in full ' . $proposal->getPaymentTerm() . ' days after the completion of work.'; ?></p>

<!--Dynamic Section-->
<?php
echo ($proposal->getPaymentTermText()) ? $proposal->getPaymentTermText() : $proposal->getOwner()->getCompany()->getPaymentTermText();
?>
<!--The signature and stuff-->

<table border="0">
    <tr>
        <td width="30">Date:</td>
        <td width="182" style="border-bottom: 1px solid #000;">&nbsp;</td>
    </tr>
</table>


    <?php
    if (!file_exists(UPLOADPATH . '/clients/signatures/signature-' . $proposal->getOwner()->getAccountId() . '.jpg') || $companySig) {
        echo '<br /><br />';
    }
    ?>

<table border="0">
    <tr>
        <td width="230" style="border-bottom: 1px solid #000; padding: 0 0 2px 0;">&nbsp;</td>
        <td width="65" style="padding: 0;">&nbsp;</td>
        <td width="230" style="border-bottom: 1px solid #000; padding: 0 0 2px 0;"><?php
            if (file_exists(UPLOADPATH . '/clients/signatures/signature-' . $proposal->getOwner()->getAccountId() . '.jpg') && !$companySig) {
                ?>
                <img style="width: auto; height: 70px;" src="<?php echo UPLOADPATH . '/clients/signatures/signature-' . $proposal->getOwner()->getAccountId() . '.jpg' ?>" alt="">
            <?php
            }
            ?></td>
    </tr>
    <tr>
        <td valign="top" width="220" style="line-height: 1.3">
            <?php
            if ($clientSig) {
            ?>
                <?php echo $clientSig->getName() . ' | ' . $clientSig->getTitle(); ?><br />
                <?php echo $clientSig->getCompanyName() ?><br />
                <?php echo $clientSig->getAddress() ?><br />
                <?php echo $clientSig->getCity() ?> <?php echo $clientSig->getState(); ?> <?php echo $clientSig->getZip() ?><br />
                <?php
                    if ($clientSig->getEmail()) {
                ?>
                    <a href="mailto:<?php echo $clientSig->getEmail(); ?>"><?php echo $clientSig->getEmail(); ?></a><br />
                <?php
                    }
                ?>
                <?php
                if ($clientSig->getCellPhone()) {
                    ?>
                    C: <?php echo $clientSig->getCellPhone(); ?><br />
                    <?php
                }
                ?>
                <?php
                if ($clientSig->getOfficePhone()) {
                    ?>
                    O: <?php echo $clientSig->getOfficePhone(); ?><br />
                    <?php
                }
                ?>
            <?php
            }
            else {
                echo $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName();
                if ($proposal->getClient()->getTitle()) {
                    echo ' | ' . $proposal->getClient()->getTitle();
                }
                ?>  <br>
                <?php echo $proposal->getClient()->getClientAccount()->getName() ?><br>
                <?php echo $proposal->getClient()->getAddress() ?><br>
                <?php echo $proposal->getClient()->getCity() . ', ' . $proposal->getClient()->getState() . ' ' . $proposal->getClient()->getZip() ?>
                <br>
                <a href="mailto:<?php echo $proposal->getClient()->getEmail() ?>">
                    <?php echo $proposal->getClient()->getEmail() ?></a><br>
                <?php
                $ph = 0;
                if ($proposal->getClient()->getCellPhone()) {
                    echo 'C: ' . $proposal->getClient()->getCellPhone();
                    $ph = 1;
                }
                if ($proposal->getClient()->getBusinessPhone()) {
                    if ($ph) {
                        echo '<br>';
                    }
                    echo 'O: ' . $proposal->getClient()->getBusinessPhone(true);
                }
            }
            ?><br>
        </td>
        <td width="65"></td>
        <td valign="top" width="220" style="line-height: 1.3">

            <?php
            if ($companySig) {
            ?>
                <?php echo $companySig->getName() . ' | ' . $companySig->getTitle(); ?><br />
                <?php echo $companySig->getCompanyName() ?><br />
                <?php echo $companySig->getAddress() ?><br />
                <?php echo $companySig->getCity() ?> <?php echo $companySig->getState(); ?> <?php echo $companySig->getZip() ?><br />
                <?php
                if ($companySig->getEmail()) {
                    ?>
                    <a href="mailto:<?php echo $companySig->getEmail(); ?>"><?php echo $companySig->getEmail(); ?></a><br />
                    <?php
                }
                ?>
                <?php
                if ($companySig->getCellPhone()) {
                    ?>
                    C: <?php echo $companySig->getCellPhone(); ?><br />
                    <?php
                }
                ?>
                <?php
                if ($companySig->getOfficePhone()) {
                    ?>
                    O: <?php echo $companySig->getOfficePhone(); ?><br />
                    <?php
                }
                ?>
            <?php } else { ?>
                <?php echo $proposal->getOwner()->getFirstName() . ' ' . $proposal->getOwner()->getLastName() . ' | ' . $proposal->getOwner()->getTitle();?>
                <br>
                <?php echo $proposal->getOwner()->getCompany()->getCompanyName(); ?>
                <br>
                <?php echo $proposal->getOwner()->getAddress() ?><br>
                <?php echo $proposal->getOwner()->getCity() ?>, <?php echo $proposal->getOwner()->getState() ?> <?php echo $proposal->getOwner()->getZip() ?><br>
                E: <a href="mailto:<?php echo $proposal->getOwner()->getEmail() ?>"><?php echo $proposal->getOwner()->getEmail() ?></a><br>
                C: <?php echo $proposal->getOwner()->getCellPhone() ?><br />
                P: <?php echo $proposal->getOwner()->getOfficePhoneExt() ? $proposal->getOwner()->getOfficePhone() . ' Ext ' . $proposal->getOwner()->getOfficePhoneExt() : $proposal->getOwner()->getOfficePhone(); ?><br>
                <?php if ($proposal->getClient()->getCompany()->getFax() || $proposal->getOwner()->getFax()) { ?>
                F: <?php echo ($proposal->getOwner()->getFax()) ? $proposal->getOwner()->getFax() : $proposal->getClient()->getCompany()->getFax() ?><br>
                <?php } ?>
                <a href="<?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?>"><?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?></a>
            <?php } ?>
        </td>
    </tr>
</table>
</div>
<?php

if (count($specs)) {
    ?>
    <div style="page-break-after: always"></div>
    <!--Hide Header code start-->
    <div class="header-hider"></div>
    <!--Hide Header code end-->
    <h1 class="underlined header_fix" style="z-index: 200;">Product Info</h1>
    <?php
    foreach ($specs as $item => $specz) {
        ?>
        <div class="spec">
            <h2><?php echo $item ?></h2>

            <div class="spec-content">
                <?php
                foreach ($specz as $spec) {
                    echo $spec;
                }
                ?>
            </div>
        </div>
    <?php
    }
}
//Custom texts
//$cats = $this->em->createQuery('SELECT c FROM models\Customtext_categories c  where (c.company=' . $proposal->getClient()->getCompany()->getCompanyId() . ' or c.company=0)')->getResult();
$cats = $this->customtexts->getCategories($proposal->getClient()->getCompany()->getCompanyId());
$categories = array();
$havetexts = false;
$proposal_categories = $proposal->getTextsCategories();
foreach ($cats as $cat) {
    if (@$proposal_categories[$cat->getCategoryId()]) {
        $categories[$cat->getCategoryId()] = array('name' => $cat->getCategoryName(), 'texts' => array());
    }
}
$texts = $this->customtexts->getTexts($proposal->getClient()->getCompany()->getCompanyId());
$proposal_texts = $proposal->getTexts();
foreach ($texts as $textId => $text) {
    if ((in_array($textId, $proposal_texts)) && (isset($categories[$text->getCategory()]))) {
        $havetexts = true;
        $categories[$text->getCategory()]['texts'][] = $text->getText();
    }
}
if ($havetexts) {
    ?>
    <div style="page-break-after: always"></div>
    <!--Hide Header code start-->
    <div class="header-hider"></div>
    <!--Hide Header code end-->
    <h1 class="underlined header_fix" style="z-index: 200; font-size: 24px;">Additional Info: <?php echo $proposal->getProjectName()  ?></h1>

    <!--<p>&nbsp;</p>-->
    <?php
    foreach ($proposal_categories as $catId => $on) {
        if ($on && isset($categories[$catId])) {
            $cat = $categories[$catId];
            if (count($cat['texts'])) {
                ?>
                <h2><?php echo $cat['name'] ?></h2>
                <ol>
                    <?php
                    foreach ($cat['texts'] as $text) {
                        ?>
                        <li><?php echo $text; ?></li><?php
                    }
                    ?>
                </ol>
            <?php
            }
        }
    }
}

if ($proposal->getInventoryReportUrl()) {
    ?>
    <div style="page-break-before: always">

        <div class="item-content audit">
            <h2>Property Inventory Details</h2>

            <table>
                <tr>
                    <td style="text-align: center">
                        <a href="https://local.psa/location/inventory/report/<?php echo $proposal->getInventoryReportUrl() ?>" target="_blank"
                           style="display: block">
                            <img id="auditIcon" src="<?php echo UPLOADPATH ?>/audit-icon.png"/>
                        </a>
                        <p style="text-align: center; font-weight: bold; font-style: italic;">Click to See</p>
                    </td>
                    <td style="font-size: 16px;">
                        <p>We have performed an inventory of your site</p>
                        <p><a href="https://local.psa/location/inventory/report/<?php echo $proposal->getInventoryReportUrl() ?>" target="_blank">View your
                                Custom Site Inventory Report</a></p>
                    </td>
                </tr>
            </table>
            <div class="audit-footer"></div>
        </div>


    </div>
    <?php
    // Do we have inventory Data
    if ($inventoryData) {
        if (count($inventoryData->data->breakdown)) {
            ?>
            <div style="padding-top: 30px; page-break-inside: avoid;">
                <h3>Inventory Breakdown</h3>

                <table class="table inventoryTable" style="width: 100%;" border="none" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Name</th>
                        <th>Area (ft<sup>2</sup>)</th>
                        <th>Area (yds<sup>2</sup>)</th>
                        <th>Length (ft)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $kk = 1;
                    foreach ($inventoryData->data->breakdown as $breakdownData) {
                        $class = ($kk % 2) ? 'odd' : '';
                        ?>
                        <tr class="<?php echo $class; ?>">
                            <td><?php echo $breakdownData->categoryName; ?></td>
                            <td><?php echo $breakdownData->typeName; ?></td>
                            <td><?php echo $breakdownData->assetName; ?></td>
                            <td><?php echo $breakdownData->area_m ? number_format($breakdownData->area_m * M_TO_SQ_FT) : '-'; ?></td>
                            <td><?php echo $breakdownData->area_m ? number_format(($breakdownData->area_m * M_TO_SQ_FT) / 9) : '-'; ?></td>
                            <td><?php echo $breakdownData->length_m ? number_format($breakdownData->length_m * M_TO_FT) : '-'; ?></td>
                        </tr>
                        <?php
                        $kk++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
        }

        if (count($inventoryData->data->totals)) {
            ?>
            <div style="padding-top: 30px; page-break-inside: avoid;">
                <h3>Inventory Totals</h3>

                <table class="table inventoryTable" style="width: 100%;" border="none" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Category</th>
                        <th>Type</th>
                        <th># Items</th>
                        <th>Total Area (ft<sup>2</sup>)</th>
                        <th>Total Area (yds<sup>2</sup>)</th>
                        <th>Total Length (ft)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $kk = 1;
                    foreach ($inventoryData->data->totals as $totalsData) {
                        $class = ($kk % 2) ? 'odd' : '';
                        ?>
                        <tr class="<?php echo $class; ?>">
                            <td><?php echo $totalsData->categoryName; ?></td>
                            <td><?php echo $totalsData->typeName; ?></td>
                            <td><?php echo $totalsData->typeCount; ?></td>
                            <td><?php echo $totalsData->typeArea ? number_format($totalsData->typeArea * M_TO_SQ_FT) : '-'; ?></td>
                            <td><?php echo $totalsData->typeArea ? number_format(($totalsData->typeArea * M_TO_SQ_FT) / 9) : '-'; ?></td>
                            <td><?php echo $totalsData->typeLength ? number_format($totalsData->typeLength * M_TO_FT) : '-'; ?></td>
                        </tr>
                        <?php
                        $kk++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
        }

        if (count($inventoryData->data->zoneItems)) {
            ?>
            <div style="padding-top: 30px; page-break-inside: avoid;">
                <h3>Inventory Zone Items Breakdown</h3>

                <table class="table inventoryTable" style="width: 100%;" border="none" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Category</th>
                        <th>Type</th>
                        <th>Zone Name</th>
                        <th>Zone Item</th>
                        <th>Value</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $kk = 1;
                    foreach ($inventoryData->data->zoneItems as $zoneItemsData) {
                        $class = ($kk % 2) ? 'odd' : '';
                        ?>
                        <tr class="<?php echo $class; ?>">
                            <td><?php echo $zoneItemsData->categoryName; ?></td>
                            <td><?php echo $zoneItemsData->typeName; ?></td>
                            <td><?php echo $zoneItemsData->assetName; ?></td>
                            <td><?php echo $zoneItemsData->attributeTypeName ?></td>
                            <td><?php echo $zoneItemsData->attributeValue ?></td>
                        </tr>
                        <?php
                        $kk++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
        }

        if (count($inventoryData->data->zoneItemTotals)) {
            ?>
            <div style="padding-top: 30px; page-break-inside: avoid;">
                <h3>Inventory Zone Item Totals</h3>

                <table class="table inventoryTable" style="width: 100%;" border="none" cellspacing="0">
                    <thead>
                    <tr>
                        <th>Category</th>
                        <th>Zone Item</th>
                        <th>Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $kk = 1;
                    foreach ($inventoryData->data->zoneItemTotals as $zoneItemTotalData) {
                        $class = ($kk % 2) ? 'odd' : '';
                        ?>
                        <tr class="<?php echo $class; ?>">
                            <td><?php echo $zoneItemTotalData->categoryName; ?></td>
                            <td><?php echo $zoneItemTotalData->typeName; ?></td>
                            <td><?php echo $zoneItemTotalData->typeCount; ?></td>
                        </tr>
                        <?php
                        $kk++;
                    }
                    ?>
                    </tbody>
                </table>
            </div>
            <?php
        }
    }
}

//Attachments page
$attachments = $proposal->getAttatchments();
if (count($attachments) || count($proposal_attachments)) {
    ?>
    <div style="page-break-after: always"></div>
    <!--Hide Header code start-->
    <div class="header-hider"></div>
    <!--Hide Header code end-->
    <h1 class="underlined header_fix" style="z-index: 200;">Attachments</h1>
    <p>Please click any of the links below to view and print all documents.</p>
    <?php
    if (count($attachments)) {
        ?>
        <h2>Company Attachments</h2>
        <?php
        foreach ($attachments as $attachment) {
            $url = site_url('attachments/' . $proposal->getClient()->getCompany()->getCompanyId()) . '/' . $attachment->getFilePath();
            ?>
            <h3 style="margin: 0; padding: 5px 0 5px 0;"><a href="<?php echo str_replace(' ', '%20', $url) ?>"><?php echo $attachment->getFileName() ?></a></h3>
        <?php
        }
    }
    if (count($proposal_attachments)) {
        ?>
        <h2>Project Attachments</h2>
        <?php
        foreach ($proposal_attachments as $attachment) {
            $url = site_url('uploads/companies/' . $proposal->getClient()->getCompany()->getCompanyId() . '/proposals/' . $proposal->getProposalId() . '/' . $attachment->getFilePath());
            ?>
            <h3 style="margin: 0; padding: 5px 0 5px 0;"><a href="<?php echo str_replace(' ', '%20', $url) ?>"><?php echo $attachment->getFileName() ?></a></h3>
        <?php
        }
    }
}
?>
<?php //die;?>
</body>
</html>