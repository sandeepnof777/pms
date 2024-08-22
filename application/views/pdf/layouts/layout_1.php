<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Title</title>
<style type="text/css">
        /*Page Margins*/
    html {
        margin: 12.5mm;
        padding: 0;
    }

        /*Global stuff*/
    body {
        font-family: Helvetica, Arial, sans-serif;
        font-size: 13px;
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

        /*
        #footer:after {
            content: counter(page, roman);
        }*/

    h1 {
        font-size: 24px;
        /*font-size: 20px;*/
    }

    h2 {
        font-size: 20px;
        /*font-size: 14px;*/
    }

    h3 {
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
        padding-bottom: 2mm;
        margin-bottom: 0;
    }

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
        top: 0;
        left: 0;
    }

    .global_header {
        position: fixed;
        top: 0;
        left: 0;
        z-index: 100;
        font-size: 24px;
    }

    .header-hider {
        position: absolute;
        width: 100%;
        height: 48px;
        background: #fff;
        z-index: 105;
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

    strong {
        margin-right: 3px;
    }
</style>
</head>
<body>
<?php
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
<?php if ($proposal->getClient()->getCompanyName()) { ?>
<h2 class="company_name" style="text-align: center;"><?php echo $proposal->getClient()->getCompanyName()  ?></h2>
    <?php } ?>
<h3 class="company_owner" style="text-align: center; padding-bottom: 100px;"><?php echo $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName()  ?></h3>
<h3 class="company_owner" style="text-align: center;">Project</h3>
<h3 class="company_owner" style="text-align: center;"><?php echo $proposal->getProjectName()  ?></h3>
<div class="issuedby">
    <p class="clearfix" style="line-height: 16px;">
        <img class="theLogo" src="<?php echo UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo() ?>" alt=""><br>
        <?php echo $proposal->getClient()->getAccount()->getFullName() ?><br>
        <?php echo $proposal->getClient()->getAccount()->getTitle() ?>
    </p>
</div>
<div style="page-break-after: always"></div>
<?php
/*
* Second Page
*/
?>
<div class="logotopright-hider"></div>

<!--Hide Header code start-->
<div class="header-hider"></div>
<!--Hide Header code end-->
<h1 class="title_big2" style="z-index: 200;">Service Provider Information</h1>
<table border="0" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td align="center" width="50%"><h2>Company Info</h2></td>
        <td align="center" width="50%"><h2>Contact Person</h2></td>
    </tr>
    <tr>
        <td align="center" width="50%">
            <img class="theLogo" src="<?php echo UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo() ?>" alt="">
            <p><?php echo $proposal->getClient()->getCompany()->getCompanyName() ?><br>
                <?php echo $proposal->getClient()->getCompany()->getCompanyAddress() ?><br>
                <?php echo $proposal->getClient()->getCompany()->getCompanyCity() ?>, <?php echo $proposal->getClient()->getCompany()->getCompanyState() ?>, <?php echo $proposal->getClient()->getCompany()->getCompanyZip() ?><br>
                <br>
                Phone: <?php echo $proposal->getClient()->getCompany()->getCompanyPhone() ?><br>
                <a href="<?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?>"><?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?></a><br>
            </p>
        </td>
        <td align="center" width="50%">
            <p style="padding-top: 0; margin-top: 0;"><?php echo $proposal->getClient()->getAccount()->getFullName() ?><br>
                <?php echo $proposal->getClient()->getAccount()->getTitle() ?><br>
                <a href="mailto:<?php echo $proposal->getClient()->getAccount()->getEmail() ?>"><?php echo $proposal->getClient()->getAccount()->getEmail() ?></a><br>
                Cell: <?php echo $proposal->getClient()->getAccount()->getCellPhone() ?>
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
<div class="logotopright"><img class="theLogo" src="<?php echo UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo() ?>" alt=""></div>
<div id="footer">
    <!--Page-->
    <script type="text/php">
        if ( isset($pdf) ) {
        $font = Font_Metrics::get_font("helvetica", "italic");
        $pdf->page_text(280, 765, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 9, array(0.6,0.6,0.6));
        }
    </script>
</div>
<h1 class="underlined global_header" style="">Proposal: <?php echo $proposal->getProjectName() ?></h1>
<?php if ($proposal->getVideoURL() <> '') {
    ?>
<div id="videoURL">
    <a href="<?php echo $proposal->getVideoURL() ?>" target="_blank"><img src="<?php echo UPLOADPATH ?>/proposal-video.jpg" width="90%"></a>
</div>
    <?php
} ?>
<?php
$k = 0;
foreach ($services as $service) {
    $k++;
    ?>
<div id="item_<?php echo $k ?>" style="page-break-inside: avoid">
    <div class="item-content">
        <h2><?php echo $service->getServiceName() ?></h2>
        <?php echo $services_texts[$service->getServiceId()]; ?>
        <p style="padding-left: 40px;">Total Price for this item: $<?php  echo number_format(intval(str_replace($s, $r, $service->getPrice())), 2)  ?></p>
    </div>
</div>
    <?php
}
?>
<?php
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
<p>Here you will have the prices of all the items, detailed. This proposal originated on <?php echo date('F, d, Y', $proposal->getCreated(false)) ?>.</p>
<div class="table-container">
    <table width="100%" class="table" border="0">
        <thead>
        <tr>
            <td>Item</td>
            <td>Description</td>
            <td>Cost</td>
        </tr>
        </thead>
        <tbody>
        <?php
        $k = 0;
        $total = 0;
        foreach ($services as $service) {
            $k++;
            ?>
        <tr>
            <td <?php if ($k % 2) {
                echo 'class="odd"';
            } ?>><?php echo $k; ?></td>
            <td <?php if ($k % 2) {
                echo 'class="odd"';
            } ?>><?php
                //fix for the price breakdown to show service name instead of Additional Service
                echo $service->getServiceName();
                ?></td>
            <td <?php if ($k % 2) {
                echo 'class="odd"';
            } ?>>$<?php
                $price = str_replace($s, $r, $service->getPrice());
                echo number_format($price, 2);
                ?></td>
        </tr>
            <?php
            $total += $price;
        }
        ?>
        </tbody>
        <tfoot>
        <tr>
            <td>&nbsp;</td>
            <td align="right">Total</td>
            <td>$<?php echo number_format($total, 2) ?></td>
        </tr>
        </tfoot>
    </table>
</div>
<br>
<?php if (trim($proposal->getClient()->getCompany()->getContractCopy())) { ?>
<br>
<h2>Authorization to Proceed & Contract</h2>
<p style="padding: 0; margin: 0;"><?php echo ($proposal->getClient()->getCompany()->getContractCopy()) ?></p>
    <?php } ?>
<h2>Payment Terms</h2>
<p style="padding: 0; margin: 0;"><?php echo ($proposal->getPaymentTerm() == 0) ? 'Payment is required at the completion of the project.' : 'We argree to pay the total sum ' . $proposal->getPaymentTerm() . ' days after the completion of work.'; ?>
    I am authorized to approve and sign this project as described in this proposal as well as identified below with our payment terms and options.</p>
<!--The signature and stuff-->
<br>
<br>
<br>
<table border="0">
    <tr>
        <td width="270">______________________________________</td>
        <td width="270">______________________________________</td>
    </tr>
</table>
<table border="0">
    <tr>
        <td valign="top" width="270"><?php echo $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName() . ' / ' . $proposal->getClient()->getCompanyName() ?></td>
        <td valign="top" width="270"><?php echo $proposal->getClient()->getAccount()->getFirstName() . ' ' . $proposal->getClient()->getAccount()->getLastName() . ' / ' . $proposal->getClient()->getAccount()->getTitle() . '<br>' . $proposal->getClient()->getAccount()->getCompany()->getCompanyName() ?></td>
    </tr>
</table>
<br>
<br>
<br>
<table border="0">
    <tr>
        <td width="270">Date: _________________________________</td>
    </tr>
</table>
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
//Attachments page
$attachments = $proposal->getAttatchments();
if (count($attachments)) {
    ?>
<div style="page-break-after: always"></div>
<!--Hide Header code start-->
<div class="header-hider"></div>
<!--Hide Header code end-->
<h1 class="underlined header_fix" style="z-index: 200;">Attachments</h1>
<!--<p>&nbsp;</p>-->
    <?php
    foreach ($attachments as $attachment) {
        $url = site_url('attachments/' . $proposal->getClient()->getCompany()->getCompanyId()) . '/' . $attachment->getFilePath();
        ?>
    <h3 style="margin: 0; padding: 5px 0 5px 0;"><?php echo $attachment->getFileName() ?></h3>
    <a href="<?php echo str_replace(' ', '%20', $url) ?>"><?php echo $url ?></a><?php
    }
    ?>
    <?php
}
$images = $proposal->getProposalImages();
if (count($images)) {
    foreach ($images as $image) {
        if ($image->getActive()) {
            $imagePath = UPLOADPATH . '/proposals/' . $proposal->getProposalId() . '/' . $image->getImage();
            if (file_exists($imagePath)) {
//            mail('chris@rapidinjection.com','path',$imagePath);
                $imageInfo = getimagesize($imagePath);
                if ($imageInfo[0] > $imageInfo[1]) {
                    $imageLayout = 'landscape';
                } else {
                    $imageLayout = 'portrait';
                }
                ?>
            <div style="page-break-after: always"></div>
            <!--        <p>&nbsp;</p>-->
            <h2 style="text-align: center;"><?php echo $image->getTitle() ?></h2>
            <div align="center">
                <img class="<?php echo ($imageLayout == 'landscape') ? 'proposalImage_l' : 'proposalImage_p'; ?>" src="<?php echo $imagePath; ?>" alt="">
            </div>
            <p>&nbsp;</p>
            <h2>Notes:</h2>
                <?php
            }
        }
    }
}
?>
</body>
</html>