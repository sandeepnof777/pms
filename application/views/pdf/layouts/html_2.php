<!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
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
        padding-top: 30px;
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
        content: counter(page, roman);
    }

    h1 {
        font-size: 28px;
    }

    h2 {
        font-size: 20px;
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
        padding-bottom: 40mm;
        padding-top: 30mm;
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
        padding-top: 25mm;
    }

    .aboutus {
        padding: 0 100px;
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
        line-height: 13px;
        padding-bottom: 4px;
    }

    .clear {
        clear: both;
    }

    .logotopright {
        width: 200px;
        height: 50px;
        position: fixed;
        right: -23px;
        top: -20px;
        text-align: right;
        z-index: 201;
    }

    .logotopright-hider {
        width: 215px;
        height: 70px;
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
    }

    .header-hider {
        position: absolute;
        width: 100%;
        height: 48px;
        background: #fff;
        z-index: 105;
    }

    .theLogo {
        width: 133px;
        height: 54px;
    }
</style>
</head>
<body>
<?php
/*
 * First Page
 */
?>
<h1 class="title_big"><?php echo $proposal->getProposalTitle() ?></h1>
<h2 class="company_name" style="text-align: center;"><?php echo $proposal->getClient()->getCompanyName()  ?></h2>
<h3 class="company_owner" style="text-align: center; padding-bottom: 100px;"><?php echo $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName()  ?></h3>
<h3 class="company_owner" style="text-align: center;">Project</h3>
<h3 class="company_owner" style="text-align: center;"><?php echo $proposal->getProjectName()  ?></h3>
<div class="issuedby">
    <p class="clearfix">
        <img class="theLogo" src="<?php echo UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo() ?>" alt=""><br>
        <?php echo $proposal->getClient()->getAccount()->getFullName() ?><br>
        <?php echo $proposal->getClient()->getCompany()->getCompanyPhone() ?>
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
        <td align="center" widt="50%"><h2>Contact Person</h2></td>
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
        <td align="center" widt="50%">
            <p style="padding-top: 0; margin-top: 0;"><?php echo $proposal->getClient()->getAccount()->getFullName() ?><br>
                <?php echo $proposal->getClient()->getAccount()->getTitle() ?><br>
                <a href="mailto:<?php echo $proposal->getClient()->getAccount()->getEmail() ?>"><?php echo $proposal->getClient()->getAccount()->getEmail() ?></a><br>
                Cell: <?php echo $proposal->getClient()->getAccount()->getCellPhone() ?>
            </p>
        </td>
    </tr>
</table>
<h1 class="title_big_aboutus">About Us</h1>
<p class="aboutus"><?php echo nl2br($proposal->getClient()->getCompany()->getAboutCompany()) ?></p>

<div style="page-break-after: always"></div>
<?php
/*
 * Third Page
 */
?>

<?php
/*
 * Fourth page
 */
?>
<div class="logotopright"><img class="theLogo" src="<?php echo UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo() ?>" alt=""></div>
<div id="footer">
    Proposal Generated by Neyra Proposal Management System. <br>
    Page
    <script type="text/php">
        if ( isset($pdf) ) {
        $font = Font_Metrics::get_font("helvetica", "bold");
        $pdf->page_text(6550, 70, "{PAGE_NUM} of {PAGE_COUNT}", $font, 10, array(0,0,0));
        }
    </script>
</div>
<h1 class="underlined global_header" style="">Proposal: <?php echo $proposal->getProjectName() ?></h1>
<!--<h1 class="title">Layout 1: Proposal for: --><?php //echo $proposal->getProjectName() ?><!--</h1>-->
<?php
foreach ($proposal_items as $proposalItem) {
    ?>
<div id="item" style="page-break-inside: avoid">
    <!--<h2><?php /*echo $proposalItem->getItem()->getItemName() */?></h2>-->
    <div class="item-content">
        <?php echo $proposalItem->getItemText() ?>
        <p style="padding-left: 40px;">Total Price for this item: <?php echo $proposalItem->getPrice() ?></p>
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
<h1 class="underlined header_fix" style="z-index: 200;">Price Breakdown: <?php echo $proposal->getProjectName()  ?></h1>
<p>&nbsp;</p>
<p>Here you will have the prices of all the items, detailed.</p>
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
$s = array('$', ',');
$r = array('', '');
foreach ($proposal_items as $proposalItem) {
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
        if ($proposalItem->getItem()->getItemId() != 11) {
            echo $proposalItem->getItem()->getItemName();
        } else {
            $name = 'Item name gona be here!';
            $fv = $proposalItem->getFieldsValues();
            foreach ($fv as $fieldValue) {
                if ($fieldValue->getField()->getFieldLabel() == 'service_name') {
                    $name = $fieldValue->getFieldValue();
                }
            }
            echo $name;
        }
        ?></td>
    <td <?php if ($k % 2) {
        echo 'class="odd"';
    } ?>><?php echo $proposalItem->getPrice() ?></td>
</tr>
         <?php
             $price = str_replace($s, $r, $proposalItem->getPrice());
    $total += $price;
}
?>
        </tbody>
        <tfoot>
        <tr>
            <td>&nbsp;</td>
            <td align="right">Total</td>
            <td>$<?php echo number_format($total) ?></td>
        </tr>
        </tfoot>
    </table>
</div>
<br>
<br>
<h2>Authorization to Proceed & Contract</h2>
<p style="padding: 0; margin: 0;"><?php echo nl2br($proposal->getClient()->getCompany()->getContractCopy()) ?></p>
<h3>Payment Terms</h3>
<p style="padding: 0; margin: 0;"><?php echo ($proposal->getPaymentTerm() == 0) ? 'Payment is required at the completion of the project.' : 'We argree to pay the total sum ' . $proposal->getPaymentTerm() . ' days after the completion of work.'; ?></p>
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
        <td width="270"><?php echo $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName() ?></td>
        <td width="270"><?php echo $proposal->getClient()->getCompanyName() ?></td>
    </tr>
</table>
<br>
<br>
<br>
<table border="0">
    <tr>
        <td width="270">______________________________________</td>
    </tr>
</table>
<table border="0">
    <tr>
        <td width="270">Signature</td>
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
$attachments = $proposal->getAttatchments();
if (count($attachments)) {
    ?>
<div style="page-break-after: always"></div>
<!--Hide Header code start-->
<div class="header-hider"></div>
<!--Hide Header code end-->
<h1 class="underlined header_fix" style="z-index: 200;">Attachments</h1>
<p>&nbsp;</p>

    <?php
    foreach ($attachments as $attachment) {
        $url = site_url('attachments/' . $proposal->getClient()->getCompany()->getCompanyId()) . '/' . $attachment->getFilePath();
        ?>
    <h3 style="margin: 0; padding: 5px 0 5px 0;"><?php echo $attachment->getFileName() ?></h3>
    <a href="<?php echo $url ?>"><?php echo $url ?></a><?php

    }
    ?>
    <?php

}
?>

<!--Testing the header stuff-->

</body>
</html>