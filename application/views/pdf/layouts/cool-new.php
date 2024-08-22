<?php
    $headerFont = $proposal->getClient()->getCompany()->getCoolHeaderFont();
    $bodyFont = $proposal->getClient()->getCompany()->getCoolTextFont();
    /* @var \models\ProposalSignee $clientSig */
    /* @var \models\ProposalSignee $companySig */
    // die;
?>
<!DOCTYPE HTML>
<html lang="en-US">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Title</title>
    <base target="_blank">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous">
    </script>
    <style>
    .title {
        margin-top: 50px;
    }

    h1.underlined {
        border-bottom: 2px solid #000000;
        padding-bottom: 1mm;
        margin-bottom: 1mm;
    }

    .panel-default>.panel-heading-custom {
        color: white;
        background: black;
        border: 2px solid;
        border-color: black;
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
    <div class="col-md-12 sticky-top" style="background-color:white;">
        <h1 class="underlined">Proposal: <?php echo $proposal->getProjectName() ?></h1>
    </div>
    <div class="col-md-12">
        <h1 align="center" class="title"> <?php echo $proposal->getProposalTitle() ?> </h1>
    </div>
    <div class="container" align="center" style="margin-bottom:100px;">
        <img src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
            UPLOADPATH . '/separator.jpg')) ?>" width="90%">
    </div>
    <div class="col-md-12" align="center">
        <?php if ($proposal->getClient()->getClientAccount()->getName()) { ?>
        <h2 class="company_name">
            <?php echo ($proposal->getClient()->getClientAccount()->getName() == 'Residential') ? 'Residential Proposal' : $proposal->getClient()->getClientAccount()->getName();  ?>
        </h2>
        <?php } ?>
        <h3 style="padding-bottom: 100px;">
            <?php echo $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName()  ?></h3>
        <h3 style="font-size: 15px !important; line-height: 17px; margin-bottom: 15px;"><b>Project:</b></h3>
        <h3 style="margin-bottom: 0; padding-bottom: 0; line-height: 22px;"><?php echo $proposal->getProjectName()  ?>
        </h3>
        <?php if ($proposal->getProjectAddress()) { ?>
        <h4 style="margin-top: 0; padding-top: 0; font-weight: normal; font-size: 13px;">
            <?php echo $proposal->getProjectAddress() ?><br><?php echo $proposal->getProjectCity() . ', ' . $proposal->getProjectState() . ' ' . $proposal->getProjectZip() ?>
        </h4>
        <?php } ?>
    </div>
    <h1 class="title_big2" style="z-index: 200; text-align: center; margin-bottom:100px;">
        <?php echo $proposal->getClient()->getCompany()->getPdfHeader() ?></h1>
    <div class="container" style="margin-bottom:50px">
        <div class="row">
            <div class="col-sm">
                <h4>Company Info</h4>
                <img class="theLogo img-fluid" width="150px" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>" alt="">

                <p><?php echo $proposal->getClient()->getCompany()->getCompanyName() ?><br>
                    <?php echo $proposal->getOwner()->getAddress() ?><br>
                    <?php echo $proposal->getOwner()->getCity() ?>, <?php echo $proposal->getOwner()->getState() ?>
                    <?php echo $proposal->getOwner()->getZip() ?><br>
                    <br>
                    P: <?php echo $proposal->getOwner()->getOfficePhone() ?><br>
                    <?php if ($proposal->getClient()->getCompany()->getFax() || $proposal->getOwner()->getFax()) { ?>
                    F:
                    <?php echo ($proposal->getOwner()->getFax()) ? $proposal->getOwner()->getFax() : $proposal->getClient()->getCompany()->getFax() ?><br>
                    <?php } ?>
                    <a
                        href="<?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?>"><?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?></a><br>
                </p>
            </div>
            <div class="col-sm">
                <h4>Contact Person</h4>
                <p style="padding-top: 0; margin-top: 0;"><?php echo $proposal->getOwner()->getFullName() ?><br>
                    <?php echo $proposal->getOwner()->getTitle() ?><br>
                    <a
                        href="mailto:<?php echo $proposal->getOwner()->getEmail() ?>"><?php echo $proposal->getOwner()->getEmail() ?></a><br>
                    Cell: <?php echo $proposal->getOwner()->getCellPhone() ?><br />
                    Office
                    <?php echo $proposal->getOwner()->getOfficePhoneExt() ? $proposal->getOwner()->getOfficePhone() . ' Ext ' . $proposal->getOwner()->getOfficePhoneExt() : $proposal->getOwner()->getOfficePhone(); ?>
                </p>
            </div>
            <div class="col-sm float-left">
                <div class="row">
                    <img class="theLogo img-fluid" width="300px" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                        UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>"
                        alt=""><br>
                        <p align="center">
                    <?php echo $proposal->getOwner()->getFullName() ?><br>
                    <?php echo $proposal->getOwner()->getTitle() ?> </p>
                </div>
            </div>
        </div>
    </div>
    <div class="container" align="center">
        <h1 class="title_big_aboutus">About Us</h1>
        <p class="aboutus"><?php echo $proposal->getClient()->getCompany()->getAboutCompany() ?></p>
    </div>
    <div class="container">
        <?php
            if ($proposal->getAuditKey()) {
        ?>
        <div style="page-break-inside: avoid">
            <div class="item-content audit">
                <div class="panel panel-default">
                    <div class="panel-heading-custom panel-heading heading"> Property Inspection / Audit</div>
                    <div class="panel-body panel-info" style="border: 2px solid black;">
                        <div class="row">
                            <div class="col-sm-2">
                                <a href="<?php echo $proposal->getAuditReportUrl(true) ?>" target="_blank"
                                    style="text-align: center;display: block">
                                    <img id="auditIcon" width="100px"
                                        src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . '/audit-icon.png')); ?>" />
                                </a>
                                <p style="text-align: center; font-weight: bold; font-style: italic;">Click to See</p>
                            </div>
                            <div class="col-sm-10">
                                <p>We have performed a custom site inspection/audit of this site including maps, images
                                    and more</p>
                                <p><a href="<?php echo $proposal->getAuditReportUrl(true) ?>" target="_blank">View your
                                        Custom Site Inspection/Audit Report</a></p>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="audit-footer"></div>
            </div>
        </div>
        <?php    } ?>
    </div>
    <div class="container">
        <?php $k = 0;
foreach ($services as $service) {

    $k++;

    if(!$proposal->hasSnow()){
?>
        <div id="item_<?php echo $k ?>" style="page-break-inside: auto;">
            <div class="item-content<?php echo ($service->isNoPrice()) ? ' no-price' : ''; ?>">
                <h2><?php echo $service->getServiceName() ?></h2>
                <div class="item-content-texts">
                    <?php echo $services_texts[$service->getServiceId()]; ?>
                </div>
                <?php if (!$lumpSum  && !$service->isNoPrice()) { 
                    $price = (float) str_replace($s, $r, $service->getPrice());
                            $taxprice = (float) str_replace($s, $r, $service->getTaxPrice());
                            ?>

                <span style="padding-left: 40px; margin-top: 0;">Total Price:
                    <?php  echo   '$'.number_format(($price-$taxprice), 2);   ?></span>

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
                <p style="padding-left: 40px;">Total Seasonal Price for this item:
                    <?php  echo $service->getFormattedPrice()  ?></p>
                <?php
                            break;
                        case 'Year':
                            ?>
                <p style="padding-left: 40px;">Total Yearly Price for this item:
                    <?php  echo $service->getFormattedPrice()  ?></p>
                <?php
                            break;
                        case 'Month':
                            ?>
                <p style="padding-left: 40px;">Total Monthly Price for this item:
                    <?php  echo $service->getFormattedPrice()  ?></p>
                <?php
                            break;
                        case 'Hour':
                            ?>
                <p style="padding-left: 40px;">This item has a <?php  echo $service->getFormattedPrice()  ?> hourly
                    price</p>
                <?php
                            break;
                        case 'Materials':
                            ?>
                <p style="padding-left: 40px;">This item is priced <?php  echo $service->getFormattedPrice()  ?> Per
                    <?php echo $service->getMaterial() ?></p>
                <?php
                            break;
                        default:
                            //total and new one
                            ?>
                <p style="padding-left: 40px;">Total Price for this item: <?php  echo $service->getFormattedPrice()  ?>
                </p>
                <?php
                            break;
                    }
                } ?>
            </div>
        </div>
        <?php
        }
    } ?>
    </div>
    <div class="container">
        <?php
        $images2 = array();
        /*Proposal Images*/
        if (count($images)) {
            
            foreach ($images as $k => $image) {
                if ($images[$k]['image']->getActive()) {
                    $img = array();
                    $img['src'] = $images[$k]['src'];
                    $img['path'] = $images[$k]['path'];
                    if (file_exists($img['path'])) {
                        $img['orientation'] = $images[$k]['orientation'];
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
            $j=0;
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
                            $tableOpen =0;
                        }
                    }
                        //open table
                        if ($old_layout !=1) {
                            $imageCount = 0;
                        }
                        
                        if (!($imageCount % 2)) {
                            ?>
                <table width="100%" border="0">
                    <?php
                            $tableOpen = 1;
                        }
                        //display image
                        ?>
                    <tr>
                        <td width="100%" height="400px" valign="top" align="center">
                            <h2 style="text-align: center; padding: 10px 0; margin: 0;"><?php echo $image['title']; ?></h2>
                            <img src="<?php echo $image['src'] ?>" alt=""
                                style="height: 290px; width: auto; margin: 0; padding: 0;" />

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
                                $tableOpen =0;
                            } else {
                            //    //close tr's if necessary...
                            //     if ($imageCount % 2) {
                            //         echo '<td></td></tr>';
                            //     }
                            //close table
                            //echo '</table>';
                        }
                    }
                    if ($old_layout !=2) {
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
                            <h2><?php echo $image['title'] ?></h2>

                            <div>
                                <img src="<?php echo $image['src'] ?>" alt="" style="height: 190px; width: auto;" />
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
                            if ($old_layout == 2 ) {
                                //echo $imageCount;
                                if(($imageCount % 4) != 2){
                                //echo 'test';die;
                                    echo '<td></td></tr></table>';
                                    $tableOpen =0;
                                }else{
                                    echo '</table>';
                                    $tableOpen =0;
                                    if(count($images2) != $j){
                                    // echo '</table>';
                                    }
                                    
                                }
                            
                            }else if($old_layout == 1){
                                if ($imageCount % 2) {
                                        echo '<td></td></tr>';
                                    }
                                    
                                }
                                echo '</table>';
                                $tableOpen =0;
                        //close table
                        //echo '</table>';
                        //echo 'test3';die;
                    }
                    //echo '<div style="page-break-after: always"></div>';
                }
            
                        ?>

                <div class="check" style="page-break-after: always"></div>

                <h2 style="text-align: center;"><?php echo $image['title'] ?></h2>
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
        } ?>
    </div>
    <div class="container" style="margin-top: 50px;">
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

    </div>
    <div class="container">
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
        <div class="table-container container-fluid">
            <table width="100%" class="table table-striped" border="0">
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
                        $taxprice = (float) str_replace($s, $r, $service->getTaxPrice());
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
                                $price = (float) str_replace($s, $r, $service->getPrice());
                                

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
        <h2 style="margin-top: 100px;">Optional Services:</h2>
        <div class="table-container container-fluid">
            <table width="100%" class="table table-striped" border="0">
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
                    $taxPrice = 0;
                    if ($service->getTaxPrice()) {
                        $taxprice = (float) str_replace($s, $r, $service->getTaxPrice());
                    }
                    ?>
                    <tr>
                        <td <?php if ($k % 2) {
                            echo 'class="odd"';
                        } ?>><?php echo $k; ?></td>
                        <td <?php if ($k % 2) {
                            echo 'class="odd"';
                        } ?>>
                    <?php
                        if(floatval($taxprice > 0)){
                            echo '<span style="font-weight:bold;vertical-align: sub;">* </span>';
                            $isTaxApplied = true;
                        }
                        //fix for the price breakdown to show service name instead of Additional Service
                        echo $service->getServiceName();
                    ?></td>
                        <td <?php echo ($k % 2) ? ' class="odd"' : ''; ?> style="text-align: right">
                        <?php
                        // Price required for calculations
                        $price = (float) str_replace($s, $r, $service->getPrice());

                        //echo $service->getFormattedPrice();
                        echo '$'.number_format(($price - $taxprice), 2);
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
                <?php if ($taxSubTotal>0) { ?>
                <tr>
                    <td></td>
                    <td align="right"><strong>Tax:</strong></td>
                    <td style="text-align: right">$<?php echo number_format($taxSubTotal, 2) ?></td>
                </tr>
                <?php } ?>
                <!--
                <tr>
                    <td></td>
                    <td align="right"><strong>Total:</strong></td>
                    <td style="text-align: right"><strong>$<?php echo number_format($total + $taxSubTotal, 2) ?></strong></td>
                </tr>
                -->
                </tfoot>
                <?php } ?>
            </table>
        </div>
        <?php
        }
        } else {
            // Snow proposal
        ?>
        <div class="table-container container-fluid">
            <h4 style="margin-top: 0; padding-top: 0; margin-bottom: 0; padding-bottom: 0; font-size:15px">Service Pricing</h4>
            <table width="100%" class="table table-striped" border="0" style="margin-bottom: 0;">
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
                                $price = (float) str_replace($s, $r, $service->getPrice());
                                echo @number_format($price, 2);
                                ?></td>
                            <td class="<?php echo $class; ?>" align="right"><?php
                                if (!in_array($service->getPricingType(), $hiddenPrices)) {
                                    if (in_array($service->getPricingType(), $fixedPrices)) {
                                        $amountQty = 1;
                                    }
                                    $partialTotal = ( (float) str_replace($s, $r, $price) * $amountQty);
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
                <h4 style="margin-top: 100px; padding-top: 0; margin-bottom: 0; padding-bottom: 0; font-size: 15px">Time & Material Items</h4>
                <div class="table-container container-fluid">
                <table width="100%" class="table table-striped" border="0">
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
                                    $price = (float) str_replace($s, $r, $service->getPrice());
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
                </div>
            <?php } ?>
        </div>
        <?php
            }
        ?>
    </div>
    <div class="container">
        <?php if (trim($proposal->getClient()->getCompany()->getContractCopy())) { ?>
            <h2 style="margin-top: 2px; margin-top: 20px;">Authorization to Proceed & Contract</h2>
            <p style="padding: 0; margin: 0;"><?php echo ($proposal->getContractCopy()) ? $proposal->getContractCopy() : $proposal->getClient()->getCompany()->getContractCopy() ?></p>
        <?php } ?>

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

        <table class="table-responsive" border="0">
            <tr>
                <td width="230" style="border-bottom: 1px solid #000; padding: 0 0 2px 0;">&nbsp;</td>
                <td width="65" style="padding: 0;">&nbsp;</td>
                <td width="230" style="border-bottom: 1px solid #000; padding: 0 0 2px 0;"><?php
                    if (file_exists(UPLOADPATH . '/clients/signatures/signature-' . $proposal->getOwner()->getAccountId() . '.jpg') && !$companySig) {
                        ?>
                        <img style="width: auto; height: 70px;" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . '/clients/signatures/signature-' . $proposal->getOwner()->getAccountId() . '.jpg')) ?>" alt="">
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
    <div class="container">
    <?php

        if (count($specs)) {
            ?>
            <h1 class="underlined" style="z-index: 200;margin-top: 50px;">Product Info</h1>
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
            <h1 class="underlined header_fix" style="z-index: 200; font-size: 24px; margin-top: 50px;">Additional Info: <?php echo $proposal->getProjectName()  ?></h1>

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
        } ?>
    </div>
    <div class="container">
        <?php
    if ($proposal->getInventoryReportUrl()) {
    ?>
    <div style="page-break-before: always">

        <div class="item-content audit">
            <div class="panel panel-default">
                <div class="panel-heading-custom panel-heading heading">Property Inventory Details</div>
                <div class="panel-body panel-info" style="border: 2px solid black;">
                    <div class="row">
                        <div class="col-sm-2">
                            <a href="https://local.psa/location/inventory/report/<?php echo $proposal->getInventoryReportUrl() ?>" target="_blank"
                            style="text-align: center;display: block">
                                <img id="auditIcon" width="100px" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . 'audit-icon.png')); ?>"/>
                            </a>
                            <p style="text-align: center; font-weight: bold; font-style: italic;">Click to See</p>
                        </div>
                        <div class="col-sm-10">
                                <p>We have performed an inventory of your site</p>
                                <p><a href="https://local.psa/location/inventory/report/<?php echo $proposal->getInventoryReportUrl() ?>" target="_blank">View your
                                    Custom Site Inventory Report</a></p>
                        </div>
                    </div>
                </div>

            </div>
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
                    <div class="table-container">
                        <table class="table inventoryTable table-striped" style="width: 100%;" border="none" cellspacing="0">
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
                </div>
                <?php
            }

            if (count($inventoryData->data->totals)) {
                ?>
                <div style="padding-top: 30px; page-break-inside: avoid;">
                    <h3>Inventory Totals</h3>
                    <div class="table-container">
                        <table class="table inventoryTable table-striped" style="width: 100%;" border="none" cellspacing="0">
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
                </div>
                <?php
            }

            if (count($inventoryData->data->zoneItems)) {
                ?>
                <div style="padding-top: 30px; page-break-inside: avoid;">
                    <h3>Inventory Zone Items Breakdown</h3>
                    <div class="table-container">
                        <table class="table inventoryTable table-striped" style="width: 100%;" border="none" cellspacing="0">
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
                </div>
                <?php
            }

            if (count($inventoryData->data->zoneItemTotals)) {
                ?>
                <div style="padding-top: 30px; page-break-inside: avoid;">
                    <h3>Inventory Zone Item Totals</h3>
                    <div class="table-container">
                        <table class="table inventoryTable table-striped" style="width: 100%;" border="none" cellspacing="0">
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
                </div>
                <?php
            }
        }
    } ?>
    </div>
    <div class="container">
    <?php 
        //Attachments page
        $attachments = $proposal->getAttatchments();
        if (count($attachments) || count($proposal_attachments)) {
            ?>
            <h1 class="underlined" style="z-index: 200;">Attachments</h1>
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
    </div>

</body>

</html>