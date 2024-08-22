<?php
$headerFont = $proposal->getClient()->getCompany()->getStandardHeaderFont();
$bodyFont = $proposal->getClient()->getCompany()->getStandardTextFont();
/* @var \models\ProposalSignee $clientSig */
/* @var \models\ProposalSignee $companySig */
?>
<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    <title>Title</title>
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
            font-family: <?php echo $headerFont ?> !important;
            /*font-size: 20px;*/
        }

        h2 {
            font-size: 20px;
            font-family: <?php echo $headerFont ?> !important;
            /*font-size: 14px;*/
        }

        h3 {
            font-family: <?php echo $headerFont ?> !important;
            font-size: 17px;
        }

        /*
        First Page
        */
        h1.title_big {
            font-size: 36px;
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
            max-width: 100%;
            margin-bottom: 7px;
        }

        /*
        Second Page
        */
        h1.title_big2 {
            font-size: 38px;
            text-align: center;
            padding-bottom: 15mm;
            padding-top: 5px;
            margin: 0;
        }

        h1.title_big_aboutus {
            font-size: 38px;
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
            line-height: 1.1em;
            padding-bottom: 4px;
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
            top: -20px;
            left: 0;
            width: 100%;
        }

        .global_header {
            position: absolute;
            top: -20px;
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

        .item-content h1, .item-content h2, .item-content h3 {
            margin: 0;
        }

        .item-content {
            margin: 0 0 10px 0;
            padding: 0;
        }

        .item-content.no-price h2,.item-content.no-price h3{
            background-color: #dddddd;
            padding: 10px 20px;
            margin-top: 20px;
        }

        .item-content.no-price {
            background-color: #ffffff;
            border-radius: 10px;
        }

        .no-price .item-content-texts {

            padding-bottom: 8px;
        }

        .item-content.audit {
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

        .item-content.audit h2 {
            background-color: #000000;
            color: #ffffff;
            padding: 10px 20px;
            margin-top: 0;
        }


        .item-content.audit h3 {
            background-color: #000000;
            color: #ffffff;
            padding: 10px 20px;
            margin-top: 0;
        }


        .item-content-texts {
            padding-right: 10px;
            padding-bottom: 10px;
        }

        .proposalImage_p {
            /*Portrait*/
            height: 420px;
        }

        .proposalImage_l {
            /*Landscape*/
            width: 100%;
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

        strong, b, i, span {
            margin: 0 2px 0 0;
            line-height: 1.1;
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
        .badge {
            padding: .50em;
            height: 15px;
            color: #fff;
            text-align: center;
            border-radius: 0.25rem;
        }
    </style>
</head>
<body>
<?php
/* @var \models\Proposals $proposal */
$s = array('$', ',');
$r = array('', '');

?>
<!--Hide Header code start-->
<div class="header-hider"></div>
<!--Hide Header code end-->
<table width="100%" border="0">
    <tr>
        <td width="70%">
            <p>
                <?php
                echo date('F d, Y', $proposal->getCreated(false));
                ?>
                <br>
                <br>
                Attn: <?php echo $proposal->getClient()->getFullName() ?>
                <?php if ($proposal->getClient()->getClientAccount()->getName() && ($proposal->getClient()->getClientAccount()->getName() != 'Residential')) { ?>
                    <br>
                    <b><?php echo $proposal->getClient()->getClientAccount()->getName() ?></b>
                <?php } ?>
                <br>
                <?php echo $proposal->getClient()->getAddress() ?>
                <br>
                <?php echo $proposal->getClient()->getCity() ?>
                , <?php echo $proposal->getClient()->getState() ?> <?php echo $proposal->getClient()->getZip() ?>
            </p>
        </td>
        <td width="30%">
            <p style="">
                <br>
                <br>
                <b style="font-size: 12px; display: block; border-bottom: 1px solid #DDD; padding-bottom: 2px; color: #444;">Project
                    Name </b>
                <br>
                <span style="display: block; padding-left: 10px; color: #444;">
                    <?php echo $proposal->getProjectName(); ?>
                    <br>
                    <?php echo $proposal->getProjectAddress() ?>
                    <br>
                    <?php echo $proposal->getProjectCity() ?>, <?php echo $proposal->getProjectState() ?> <?php echo $proposal->getProjectZip() ?>
                </span>
            </p>
        </td>
    </tr>
</table>

<div id="intro">
    <?php echo $proposal->getClient()->getCompany()->getStandardLayoutIntro() ?>
</div>

<div class="logotopright"><img class="theLogo" style="height: 40px; width: 120px; margin-right: 8px;"
                               src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())); ?>"
                               alt=""></div>
<div id="footer">
    <!--Page-->

</div>
<h1 class="underlined global_header" style="position: fixed;">Proposal: <?php echo $proposal->getProjectName() ?></h1>
<?php
if ($proposal->getAuditKey()) {
    ?>
    <div style="page-break-inside: avoid">
        <div class="item-content audit">
            <h2>Property Inspection / Audit</h2>

            <table>
                <tr>
                    <td style="text-align: center">
                        <a href="<?php echo $proposal->getAuditReportUrl(true) ?>" target="_blank"
                           style="display: block">
                            <img id="auditIcon" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . '/audit-icon.png')); ?>"/>
                        </a>
                        <p style="text-align: center">Click to See</p>
                    </td>
                    <td style="font-size: 16px;">
                        <p>We have performed a custom site inspection/audit of this site including maps, images and
                            more</p>
                        <p><a href="<?php echo $proposal->getAuditReportUrl(true) ?>">View your Custom Site
                                Inspection/Audit Report</a></p>
                    </td>
                </tr>
            </table>
            <div class="audit-footer"></div>
        </div>
    </div>
<?php }


$k = 0;
foreach ($services as $service) {
    
    $k++;
    ?>
    <div id="item_<?php echo $k ?>">
        <div style="position: relative;" class="item-content<?php echo ($service->isNoPrice()) ? ' no-price' : ''; ?>"
             style="page-break-inside: avoid">
            <h3><?php echo $service->getServiceName() ?></h3>
            <?php 
                    if ($service->isOptional()) {
                ?>
                    <div style="height:10px;position: absolute;right: 35px;top:0px;font-size: 12px;background-color: #6c757d!important;" class="badge bg-secondary">Optional Service</div>
                <?php }?>
            <div class="item-content-texts">
                <?php echo nl2br($services_texts[$service->getServiceId()]); ?>
            </div>
            <?php if (!$lumpSum && !$service->isNoPrice()) { ?>
                <span style="padding-left: 40px; margin-top: 0;">Total Price for this item: <?php echo $service->getFormattedPrice(); ?></span>
                <?php if ($service->getTaxPrice() > 0) { ?>
                    <span style="padding-left: 40px; margin-top: 0; float:right">Includes Tax: <?php echo '$' . number_format($service->getTaxPrice(), 2); ?></span>
                <?php }
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
    
    
    <div style="page-break-before: always;" >
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

//Proposal Map Images
$new_map_images = array();
/*Proposal Images*/
if (isset($map_images)) {
    
    foreach ($map_images as $k => $image) {
        if ($map_images[$k]['image']->getActive()) {
            $img = array();
            $img['src'] = $map_images[$k]['src'];
            $img['path'] = $map_images[$k]['path'];
            if (file_exists($img['path'])) {
                $img['orientation'] = $map_images[$k]['orientation'];
                $img['title'] = $map_images[$k]['image']->getTitle();
                $img['notes'] = $map_images[$k]['image']->getNotes();
               
                $new_map_images[] = $img;
            }
        }
    }
    //new world order code
    $imageCount = 0; //image counter
    $tableOpen = 0; //variable to check if the table open
    $old_layout = 0;
    $j=0;
    foreach ($new_map_images as $image) {
        $j++;
        ?>
        <div class="check" style="page-break-after: always"></div>
        <div class="header-hider"></div>
        <!--Hide Header code end-->
        <h1 class="underlined header_fix" style="z-index: 200; font-size: 24px;">Site Map: <?php echo $proposal->getProjectName()  ?></h1>
        
                    
                    <h2 style="text-align: center;font-weight: 400;"><?php echo $image['title'] ?></h2>
                    <div align="center">
                        <img class="<?php echo ($image['orientation'] == 'landscape') ? 'proposalImage_l' : 'proposalImage_p'; ?>" src="<?php echo $image['src']; ?>" alt="">
                    </div>
                    <p>&nbsp;</p>
                    <h2 style="text-align: center;">Notes:</h2>
                    <div style="text-align: left;"><?php echo $image['notes']; ?></div>
    <?php
    }
}//End Map Images

$images2 = array();

/*Proposal Images*/
if (count($images)) {

    foreach ($images as $k => $image) {
        if ($images[$k]['image']->getActive()) {
            $img = array();
            $img['src'] = $images[$k]['src'];
            $img['path'] = $images[$k]['path'];
            if (file_exists($img['path'])) {
                $img['orientation'] = $img['path'] = $images[$k]['orientation'];
                $img['title'] = $images[$k]['image']->getTitle();
                $img['notes'] = $images[$k]['image']->getNotes();
                $img['image_layout'] = $images[$k]['image']->getImageLayout();
                $images2[] = $img;
            }
        }
    }
    //new world order code
    $imageCount = 0; //image counter
    $tableOpen = 0; //variable to check if the table open
    $old_layout = 0;
    $j = 0;
    
    foreach ($images2 as $image) {
        $j++;
        switch ($image['image_layout']) {
            case 1:
                if ($tableOpen) {
                    if ($old_layout == 2) {

                        //    //close tr's if necessary...
                        if ($imageCount % 4) {
                            echo '<td></td></tr>';
                        }
                        //close table
                        echo '</table>';
                        $tableOpen = 0;
                    }
                }
                //open table
                if ($old_layout != 1) {
                    $imageCount = 0;
                }

                if (!($imageCount % 2)) {
                    ?>
                    <div style="page-break-after: always"></div>
                    <table width="100%" border="0"><?php
                    $tableOpen = 1;
                }
                //display image
                ?>
                <tr>
                    <td width="100%" height="400px" valign="top" align="center">
                        <h2 style="text-align: center; padding: 10px 0; margin: 0;margin-bottom:5px;font-weight: 400;"><?php echo $image['title']; ?></h2>
                        <img src="<?php echo $image['src'] ?>" alt=""
                             style="height: 290px; width: auto; margin: 0; padding: 0;"/>

                        <div class="smallNotes"><?php echo $image['notes'] ?></div>
                    </td>
                </tr>
                <?php
                //increment counter
                $imageCount++;
                //close table
                if ($imageCount % 2 == 0) {
                    ?>
                    </table>
                    <?php
                    $tableOpen = 0;
                }
                break;
            case 2:


                if ($tableOpen) {
                    if ($old_layout == 1) {
                        if ($imageCount % 2) {
                            echo '<td></td></tr>';
                        }
                        //close table
                        echo '</table>';
                        $tableOpen = 0;
                    } else {
                        //    //close tr's if necessary...
                        //     if ($imageCount % 2) {
                        //         echo '<td></td></tr>';
                        //     }
                        //close table
                        //echo '</table>';
                    }
                }
                if ($old_layout != 2) {
                    $imageCount = 0;
                }
                // //open table
                if (!($imageCount % 4)) {
                    ?>
                    <div style="page-break-after: always"></div>
                    <table width="100%" border="0"><?php
                    $tableOpen = 1;
                }
                //display image
            if (!($imageCount % 2)) {
                ?>
                <tr>
                <?php
            }

                ?>
                <td width="50%" height="400px" valign="top" align="center">
                    <h2 style="font-weight: 400;"><?php echo $image['title'] ?></h2>

                    <div>
                        <img src="<?php echo $image['src'] ?>" alt="" style="height: 190px; width: auto;"/>
                    </div>
                    <div class="smallNotes"><?php echo $image['notes'] ?></div>
                </td>
                <?php


            if ($imageCount % 2) {
                ?>
                </tr>
                <?php
            }
                //increment counter
                $imageCount++;
                //close table
                if ($imageCount % 4 == 0) {
                    ?>
                    </table>
                    <?php
                    $tableOpen = 0;
                }
                break;
            default: //1 image per page
                if ($tableOpen) {
                    //echo $old_layout;

                    if ($old_layout != 0) {

                        //close table
                        // echo '</table>';

                        //close tr's if necessary...
                        // if ($imageCount % 2) {
                        //     echo '<td></td></tr>';
                        // }
                        if ($old_layout == 2) {
                            //echo $imageCount;
                            if (($imageCount % 4) != 2) {
                                //echo 'test';die;
                                echo '<td></td></tr></table>';
                                $tableOpen = 0;
                            } else {
                                echo '</table>';
                                $tableOpen = 0;
                                if (count($images2) != $j) {
                                    // echo '</table>';
                                }

                            }

                        } else if ($old_layout == 1) {
                            if ($imageCount % 2) {
                                echo '<td></td></tr>';
                            }

                        }
                        echo '</table>';
                        $tableOpen = 0;
                        //close table
                        //echo '</table>';
                        //echo 'test3';die;
                    }
                    //echo '<div style="page-break-after: always"></div>';
                }

                ?>

                <div class="check" style="page-break-after: always"></div>

                <h2 style="text-align: center;font-weight: 400;"><?php echo $image['title'] ?></h2>
                <div align="center">
                    <img class="<?php echo ($image['orientation'] == 'landscape') ? 'proposalImage_l' : 'proposalImage_p'; ?>"
                         src="<?php echo $image['src']; ?>" alt="">
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
            echo '</table>';
        } else {
            //close tr's if necessary...
            if ($imageCount % 2) {
                echo '<td></td></tr>';
            }
            //close table
            echo '</table>';
        }
    }
}

 if (count($proposal_videos)) {
    $videoCounter =1;
    $trOpen = false;
						?>
        <div id="videoURL" width="100%" style="page-break-after: always" >
        <table>
            <?php foreach ($proposal_videos as $video) { 
                $companyThumbImage = false;
                if($video->getCompanyVideoId() !=0 && $video->getCompanyCoverImage() !=''){
                    $companyThumbImage = $video->getCompanyABSCoverImage();
                }
                //$box_size = 'width:40%';
                // if($video->getIsLargePreview()){
                //     $box_size = 'width:40%';
                // }
                $videoType = $video->getVideoType();
                $url = $video->getVideoUrl();

                if ($videoCounter % 2 != 0) {  
                 echo '<tr width="50%"><td>'; 
                 $trOpen = true;
                }else{
                    echo '<td>';
                }
?>

<div style="position: relative;">
        <h3 class="video_title"><?= $videoCounter; ?>. <?php echo $video->getTitle(); ?></h3>
       
        
<?php



                if ($video->getThumbnailImage() || $companyThumbImage) {
                    if($video->getThumbnailImage()){
                         $thumbImageURL = $proposal->getPathUploadDir() . '/' . $video->getThumbnailImage();
                     }else{
                         $thumbImageURL = $companyThumbImage;
                    }
                    ?>

                <?php } else { 
                    $thumbImageURL = STATIC_PATH.'/images/video-play-icon-transparent.jpg';
                    if ($videoType == 'youtube') {
                       
                        parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
                        if(isset($my_array_of_vars['v'])){
                            $video_id = $my_array_of_vars['v'];   
                            $thumbImageURL = "https://img.youtube.com/vi/".$video_id."/0.jpg";
                        }else{
                            $thumbImageURL = STATIC_PATH.'/images/video-play-icon-transparent.jpg';
                        }
                        
                    } else if ($videoType == 'vimeo') {
                        $urlParts = explode("/", parse_url($url, PHP_URL_PATH));
                        $video_id = (int)$urlParts[count($urlParts)-1];
                        $thumbImageURL = "https://vumbnail.com/".$video_id.".jpg";
                    }else if ($videoType == 'screencast') {
                        $thumbImageURL = str_replace('www', 'content', $url);
                        $thumbImageURL = str_replace('embed', 'FirstFrame.jpg', $thumbImageURL);

                    }


                }


                ?>
                
<a style="width: 100%;" target="_blank" href="<?php echo $video->getVideoUrl(); ?>"> 
    <img style="width: 350px;object-fit: cover;height: 280px;" src="data:image/png;base64, <?php echo base64_encode(file_get_contents($thumbImageURL)); ?>" >
    <img width="100px" style="position: absolute;top: 120px;left: 38%;" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(STATIC_PATH.'/images/play-video.png')); ?>"  >
</a>
          
  </div>
<?php
        if ($videoCounter % 2 == 0) {  
            echo '</td></tr>'; 
            $trOpen = false;
           }else{
               echo '</td>';
           }
           $videoCounter++;
        
           
        } 
        if($trOpen){
            echo '</tr>'; 
        }
        ?>
        </table>
        </div>
    <?php
    }else{
        echo '<div style="page-break-after: always"></div>';
    }
/*
 * Total price page
 */
?>

<!--Hide Header code start-->
<div class="header-hider"></div>
<!--Hide Header code end-->
<h1 class="underlined header_fix" style="z-index: 200; font-size: 24px;">Price
    Breakdown: <?php echo $proposal->getProjectName() ?></h1>
<!--<p>&nbsp;</p>-->
<p>Please find the following breakdown of all services we have provided in this proposal. This proposal originated
    on <?php echo date('F, d, Y', $proposal->getCreated(false)) ?>.
    <?php
    if ($proposal->getJobNumber()) {
        ?>
        <strong>Job Number:</strong> <?php echo $proposal->getJobNumber(); ?>
        <?php
    }
    ?>
</p>


<?php
// Separate optional services
$optionalServices = [];
$taxServices = [];
$isMapDataAdded =false;
$isMapDataAddedOS =false;
foreach ($services as $k => $serviceItem) {
    if ($serviceItem->isOptional()) {
        unset($services[$k]);
        $optionalServices[] = $serviceItem;
        if($serviceItem->getMapAreaData() !=''){
            $isMapDataAddedOS =true;
        }
    }else{
        if($serviceItem->getMapAreaData() !=''){
            $isMapDataAdded =true;
        }
    }
    if ($serviceItem->isNoPrice()) {
        unset($services[$k]);
    }
    if ($serviceItem->getTax()) {
        unset($services[$k]);
        $taxServices[] = $serviceItem;
    }
    
}

?>

<div class="table-container">
    <table width="100%" class="table" border="0">
        <thead>
        <tr>
            <td width="10%"><strong>Item</strong></td>
            <td width="45%"><strong>Description</strong></td>
            <?php if($isMapDataAdded){?><td width="25%"><strong>Map Area</strong></td> <?php }?>
            <td width="20%" style="text-align: right"><strong>Cost</strong></td>
        </tr>
        </thead>
        <tbody>
        <?php
        $k = 0;
        $total = 0;
        $taxTotal = 0;
        $taxSubTotal = 0;
        $isTaxApplied = false;
        
        foreach ($services as $service) {
            $k++;
            $taxprice = (float) str_replace($s, $r, $service->getTaxPrice());
            ?>
            <tr>
                <td <?php if ($k % 2) {
                    echo 'class="odd"';
                } ?>><?php echo $k; ?></td>
                <td <?php if ($k % 2) {
                    echo 'class="odd"';
                } ?>><?php
                    if ($taxprice > 0) {
                        echo '<span style="font-weight:bold;vertical-align: sub;">* </span>';
                        $isTaxApplied = true;
                    }
                    //fix for the price breakdown to show service name instead of Additional Service
                    echo $service->getServiceName();
                    ?></td>
                <?php if($isMapDataAdded){?><td <?php if ($k % 2) {echo 'class="odd"';} ?>> <?php echo $service->getMapAreaData();?></td><?php } ?>
                <td <?php echo ($k % 2) ? ' class="odd"' : ''; ?> style="text-align: right">
                    <?php
                    // Price required for calculations
                    $price = (float) str_replace($s, $r, $service->getPrice());

                    if ($lumpSum) {
                        echo 'Included';
                    } else {
                        //echo $service->getFormattedPrice();
                        echo '$' . number_format(($price - $taxprice), 2);
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
                    <?php if($isMapDataAdded){?><td></td> <?php }?>
                    <td align="right">Subtotal</td>
                    <td style="text-align: right">$<?php echo number_format($total, 2) ?></td>
                </tr>
                <?php
                foreach ($taxServices as $taxService) {
                    $taxTotal += $taxService->getPrice(true);
                }
                ?>
                <tr>
                    <td></td>
                    <?php if($isMapDataAdded){?><td></td> <?php }?>
                    <td align="right">Tax</td>
                    <td style="text-align: right">$<?php echo number_format($taxTotal, 2) ?></td>
                </tr>
            <?php } ?>
            <?php if ($taxSubTotal > 0) { ?>
                <tr>
                    <td></td>
                    <?php if($isMapDataAdded){?><td></td> <?php }?>
                    <td align="right"><strong>Tax:</strong></td>
                    <td style="text-align: right">$<?php echo number_format($taxSubTotal, 2) ?></td>
                </tr>
            <?php } ?>
            <tr>
                <td>&nbsp;</td>
                <?php if($isMapDataAdded){?><td></td> <?php }?>
                <td align="right"><strong>Total</strong></td>
                <td style="text-align: right"><strong>$<?php echo @number_format($total + $taxTotal, 2) ?></strong></td>
            </tr>
            </tfoot>
        <?php } ?>
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
                <td width="45%"><strong>Description</strong></td>
                <?php if($isMapDataAddedOS){?><td width="25%"><strong>Map Area</strong></td> <?php }?>
                <td width="20%" style="text-align: right"><strong>Cost</strong></td>
            </tr>
            </thead>
            <tbody>
            <?php
            $k = 0;
            $total = 0;
            $taxSubTotal = 0;
            $isTaxApplied = false;
            foreach ($optionalServices as $service) {
                $k++;
                $taxprice = (float) str_replace($s, $r, $service->getTaxPrice());
                ?>
                <tr>
                    <td <?php if ($k % 2) {
                        echo 'class="odd"';
                    } ?>><?php echo $k; ?></td>
                    <td <?php if ($k % 2) {
                        echo 'class="odd"';
                    } ?>><?php
                        if ($taxprice > 0) {
                            echo '<span style="font-weight:bold;vertical-align: sub;">* </span>';
                            $isTaxApplied = true;
                        }
                        //fix for the price breakdown to show service name instead of Additional Service
                        echo $service->getServiceName();
                        ?></td>
                        <?php if($isMapDataAddedOS){?><td <?php if ($k % 2) {echo 'class="odd"';} ?>> <?php echo $service->getMapAreaData();?></td><?php } ?>
                    <td <?php echo ($k % 2) ? ' class="odd"' : ''; ?> style="text-align: right">
                        <?php
                        // Price required for calculations
                        $price = (float) str_replace($s, $r, $service->getPrice());


                        //echo $service->getFormattedPrice();
                        echo '$' . number_format(($price - $taxprice), 2);

                        ?>
                    </td>
                </tr>
                <?php
                $total += $price;
                //$taxSubTotal += $taxprice;
            }
            ?>

            </tbody>
            <?php if (!isset($hideTotalPrice) || !$hideTotalPrice) { ?>
                <tfoot>
                <!--
                <?php if ($taxSubTotal > 0) { ?>
                    <tr>
                        <td></td>
                        <?php if($isMapDataAddedOS){?><td></td> <?php }?>
                        <td align="right"><strong>Tax:</strong></td>
                        <td style="text-align: right">$<?php echo number_format($taxSubTotal, 2) ?></td>
                    </tr>
                <?php } ?>
                -->
                <tr>
                    <td></td>
                    <?php if($isMapDataAddedOS){?><td></td> <?php }?>
                    <td align="right"><strong>Total:</strong></td>
                    <td style="text-align: right"><strong>$<?php echo number_format($total + $taxSubTotal, 2) ?></strong>
                    </td>
                </tr>
                </tfoot>
            <?php } ?>
        </table>
    </div>
<?php }
if ($isTaxApplied) {
    ?>
    <p><span style="font-weight:bold;vertical-align: sub;">*</span> Price excludes Tax</p>
    <?php

} ?>

<?php if (trim($proposal->getClient()->getCompany()->getContractCopy())) { ?>
    <h2 style="margin-top: 5px;">Authorization to Proceed & Contract</h2>
    <p style="padding: 0; margin: 0;"><?php echo ($proposal->getContractCopy()) ? $proposal->getContractCopy() : $proposal->getClient()->getCompany()->getContractCopy() ?></p>
<?php } ?>

<div style="page-break-inside: avoid">
    <h2>Acceptance</h2>

    <p style="padding: 0; margin: 0;"
       id="paymentTerms"><?php echo ($proposal->getPaymentTerm() == 0) ? 'We agree to pay the total sum or balance in full upon completion of this project.' : 'We agree to pay the total sum or balance in full ' . $proposal->getPaymentTerm() . ' days after the completion of work.'; ?></p>

    <!--Dynamic Section-->
    <?php
    echo ($proposal->getPaymentTermText()) ? $proposal->getPaymentTermText() : $proposal->getOwner()->getCompany()->getPaymentTermText();
    ?>

    <!--The signature and stuff-->
    <br>
    <br>
    <br>
    <table border="0">
        <tr>
            <td width="30">Date:</td>
            <td width="187" style="border-bottom: 1px solid #000;">&nbsp;<?php if (isset($clientSignature) && ($clientSignature)) {echo  date_format(date_create($clientSignature->getCreatedAt()), "n/d/Y");} ?></td>
        </tr>
    </table>
    <br>
    <br>
    <br>
    <table border="0" width="">
        <tr>
            <td width="230" style="border-bottom: 1px solid #000; padding: 0 0 2px 0;">
            <?php if (file_exists(UPLOADPATH . '/proposal_signature/' . $proposal->getProposalId() . '/client_signature.png')) { ?>
                    <img style="width: auto; height: 70px;" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . '/proposal_signature/' . $proposal->getProposalId() . '/client_signature.png')) ?>"  alt="">
            <?php }else if ($clientSignature) {
                 if (file_exists(UPLOADPATH . '/proposal_signature/' . $proposal->getProposalId() . '/' . $clientSignature->getSignatureFile())) { ?>
                    <img style="width: auto; max-height: 70px;" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . '/proposal_signature/' . $proposal->getProposalId() . '/' . $clientSignature->getSignatureFile())); ?>"  alt="">
            <?php }}?>
            </td>
            <td width="65" style="padding: 0;">&nbsp;</td>
            <td width="230" style="border-bottom: 1px solid #000; padding: 0 0 2px 0;"><?php
                if (file_exists(UPLOADPATH . '/clients/signatures/signature-' . $proposal->getOwner()->getAccountId() . '.jpg') && !$companySig) {
                    ?>
                    <img style="width: auto; height: 70px;" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . '/clients/signatures/signature-' . $proposal->getOwner()->getAccountId() . '.jpg')) ?>" alt="">
                <?php
                }else if ($companySignature) {
                    if (file_exists(UPLOADPATH . '/proposal_signature/' . $proposal->getProposalId() . '/' . $companySignature->getSignatureFile())) { ?>
                        <img style="width: auto; max-height: 70px;" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . '/proposal_signature/' . $proposal->getProposalId(). '/' . $companySignature->getSignatureFile())); ?>" alt="">
                <?php }}?>
            </td>
        </tr>
        <tr>
            <td valign="top" width="220">

                <?php
                if ($clientSig) {
                    ?>
                    <?php echo $clientSig->getName() . ' | ' . $clientSig->getTitle(); ?><br/>
                    <?php echo $clientSig->getCompanyName() ?><br/>
                    <?php echo $clientSig->getAddress() ?><br/>
                    <?php echo $clientSig->getCity() ?><?php echo $clientSig->getState(); ?><?php echo $clientSig->getZip() ?>
                    <br/>
                    <?php
                    if ($clientSig->getEmail()) {
                        ?>
                        <a href="mailto:<?php echo $clientSig->getEmail(); ?>"><?php echo $clientSig->getEmail(); ?></a>
                        <br/>
                        <?php
                    }
                    ?>
                    <?php
                    if ($clientSig->getCellPhone()) {
                        ?>
                        C: <?php echo $clientSig->getCellPhone(); ?><br/>
                        <?php
                    }
                    ?>
                    <?php
                    if ($clientSig->getOfficePhone()) {
                        ?>
                        O: <?php echo $clientSig->getOfficePhone(); ?><br/>
                        <?php
                    }
                    ?>

                    <?php
                } else {
                    echo $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName();
                    if ($proposal->getClient()->getTitle()) {
                        echo ' / ' . $proposal->getClient()->getTitle();
                    }
                    ?>  <br>
                    <?php echo $proposal->getClient()->getClientAccount()->getName(); ?><br>
                    <?php echo $proposal->getClient()->getAddress() ?><br>
                    <?php echo $proposal->getClient()->getCity() . ', ' . $proposal->getClient()->getState() . ', ' . $proposal->getClient()->getZip() ?>
                    <br>
                    <a href="mailto:<?php echo $proposal->getClient()->getEmail() ?>"><?php echo $proposal->getClient()->getEmail() ?></a>
                    <br>
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
                if (isset($clientSignature) && ($clientSignature)) {
                    echo '<br>';
                    ?>
                    <span id="signed_span">Signed : <?= date_format(date_create($clientSignature->getCreatedAt()), "m/d/y g:i A"); ?></span>
                <?php
                }
                ?><br>
            </td>
            <td width="80">&nbsp;</td>
            <td valign="top" width="220">
                <?php
                if ($companySig) {
                    ?>
                    <?php echo $companySig->getName() . ' | ' . $companySig->getTitle(); ?><br/>
                    <?php echo $companySig->getCompanyName() ?><br/>
                    <?php echo $companySig->getAddress() ?><br/>
                    <?php echo $companySig->getCity() ?><?php echo $companySig->getState(); ?><?php echo $companySig->getZip() ?>
                    <br/>
                    <?php
                    if ($companySig->getEmail()) {
                        ?>
                        <a href="mailto:<?php echo $companySig->getEmail(); ?>"><?php echo $companySig->getEmail(); ?></a>
                        <br/>
                        <?php
                    }
                    ?>
                    <?php
                    if ($companySig->getCellPhone()) {
                        ?>
                        C: <?php echo $companySig->getCellPhone(); ?><br/>
                        <?php
                    }
                    ?>
                    <?php
                    if ($companySig->getOfficePhone()) {
                        ?>
                        O: <?php echo $companySig->getOfficePhone(); ?><br/>
                        <?php
                    }
                    ?>
                <?php } else { ?>
                    <?php echo $proposal->getOwner()->getFirstName() . ' ' . $proposal->getOwner()->getLastName() . ' | ' . $proposal->getOwner()->getTitle(); ?>
                    <br>
                    <?php echo $proposal->getOwner()->getCompany()->getCompanyName(); ?><br/>
                    <?php echo $proposal->getOwner()->getAddress() ?><br/>
                    <?php echo $proposal->getOwner()->getCity() ?>, <?php echo $proposal->getOwner()->getState() ?>, <?php echo $proposal->getOwner()->getZip() ?>
                    <br/>
                    <a href="mailto:<?php echo $proposal->getOwner()->getEmail() ?>"><?php echo $proposal->getOwner()->getEmail() ?></a>
                    <br>
                    C: <?php echo $proposal->getOwner()->getCellPhone() ?><br/>
                    P: <?php echo $proposal->getOwner()->getOfficePhoneExt() ? $proposal->getOwner()->getOfficePhone() . ' Ext ' . $proposal->getOwner()->getOfficePhoneExt() : $proposal->getOwner()->getOfficePhone(); ?>
                    <br>
                    <?php if ($proposal->getClient()->getCompany()->getFax() || $proposal->getOwner()->getFax()) { ?>
                        F: <?php echo ($proposal->getOwner()->getFax()) ? $proposal->getOwner()->getFax() : $proposal->getClient()->getCompany()->getFax() ?>
                        <br>
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
    <h1 class="underlined header_fix" style="z-index: 200;">Additional
        Info: <?php echo $proposal->getProjectName(); ?></h1>
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
            <p style="margin: 0; padding: 5px 0 5px 0;"><a
                        href="<?php echo str_replace(' ', '%20', $url) ?>"><?php echo $attachment->getFileName() ?></a>
            </p>
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
            <h3 style="margin: 0; padding: 5px 0 5px 0;"><a
                        href="<?php echo str_replace(' ', '%20', $url) ?>"><?php echo $attachment->getFileName() ?></a>
            </h3>
            <?php
        }
    }
}
?>
</body>
</html>