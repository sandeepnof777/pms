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
            font-family: Helvetica, Arial, sans-serif;
            font-size: 13px;
            line-height: 1.1;
            padding-top: 50px;
            padding-bottom: 10px;
            /*word-spacing: 0.15em;*/
        }
        #footer {
            text-align: right;
            font-size: 11px;
            /*color: #999;*/
            /*font-style: italic;*/
            position: fixed;
            bottom: 10mm;
            left: 0;
        }
        #footer h2 {
            padding-left: 150px;
        }
        #footer-img {
            width: 120px;
            height: 37px;
            position: fixed;
            left: 10px;
            bottom: -20px;
            z-index: 201;
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
        .item-content.no-price {
            background-color: #dddddd;
            border-radius: 10px;
        }
        .item-content.no-price h2 {
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

    </style>
</head>
<body>
<div class="logotopright"><img class="theLogo" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . '/clients/logos/' . $company->getCompanyLogo() )); ?>" alt=""></div>
<img id="footer-img" src="data:image/png;base64, <?php echo base64_encode(file_get_contents( ROOTPATH . '/static/images/logo.png' )); ?>" alt="">
<div id="footer">
    <h2>Don't forget to convert your lead to a Proposal!</h2>
</div>
<?php
$leadCounter = 0;
/** @var \models\Leads $lead */
foreach ($leads as $lead) {
    $leadCounter++;
    ?>
    <h1 class="underlined header_fix" style="z-index: 200; font-size: 24px;">Lead Request</h1>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td><strong>Source: </strong><?php echo $lead->getSource() ?></td>
            <td><b>Status: </b> <?php echo $lead->getStatus(); ?></td>
            <td><b>Rating: </b> <?php echo $lead->getRating() ?></td>
            <td><b>Due Date: </b> <?php echo $lead->getDueDate() ?></td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2"><b>Company Name: </b> <?php echo $lead->getCompanyName() ?></td>
            <td colspan="2"><b>Zip: </b> <?php echo $lead->getZip() ?></td>
        </tr>
        <tr>
            <td colspan="2"><b>First Name: </b> <?php echo $lead->getFirstName() ?></td>
            <td colspan="2"><b>Business Phone: </b> <?php echo $lead->getBusinessPhone() . ' ' . $lead->getBusinessPhoneExt() ?></td>
        </tr>
        <tr>
            <td colspan="2"><b>Last Name: </b> <?php echo $lead->getLastName() ?></td>
            <td colspan="2"><b>Cell Phone: </b> <?php echo $lead->getCellPhone() ?></td>
        </tr>
        <tr>
            <td colspan="2"><b>Title: </b> <?php echo $lead->getTitle() ?></td>
            <td colspan="2"><b>Fax: </b> <?php echo $lead->getFax() ?></td>
        </tr>
        <tr>
            <td colspan="2"><b>Address: </b> <?php echo $lead->getAddress() ?></td>
            <td colspan="2"><b>Email: </b> <?php echo $lead->getEmail() ?></td>
        </tr>
        <tr>
            <td colspan="2"><b>City: </b> <?php echo $lead->getCity() ?></td>
            <td colspan="2"><b>Website: </b> <?php echo $lead->getWebsite() ?></td>
        </tr>
        <tr>
            <td colspan="4"><b>State: </b> <?php echo $lead->getState() ?></td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4">
                <h2>Project Info</h2>
            </td>
        </tr>
        <tr>
            <td colspan="2"><b>Project Name: </b> <?php echo $lead->getProjectName() ?></td>
            <td colspan="2"><b>Address: </b> <?php echo $lead->getProjectAddress() ?></td>
        </tr>
        <tr>
            <td colspan="2"><b>Contact Name: </b> <?php echo $lead->getProjectContact() ?></td>
            <td colspan="2"><b>City: </b> <?php echo $lead->getProjectCity() ?></td>
        </tr>
        <tr>
            <td colspan="2"><b>Phone: </b> <?php echo $lead->getProjectPhone() . ' ' . $lead->getProjectPhoneExt() ?></td>
            <td colspan="2"><b>State: </b> <?php echo $lead->getProjectState() ?></td>
        </tr>
        <tr>
            <td colspan="2">&nbsp;</td>
            <td colspan="2"><b>Zip: </b> <?php echo $lead->getProjectZip() ?></td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4">
                <h2>Requested Services</h2>
            </td>
        </tr>
        <tr>
            <td colspan="4">
                <?php
                $selectedServices = explode(',', $lead->getServices());
                $selectedServicesNames = [];
                /** @var models\Services $service */
                foreach ($services as $service) {
                    if (in_array($service->getServiceId(), $selectedServices)) {
                        $selectedServicesNames[] = $service->getServiceName();
                    }
                }
                echo implode(', ', $selectedServicesNames);
                ?>
            </td>
        </tr>
        <tr>
            <td colspan="4">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="4">
                <h2>Notes</h2>
                <p><?php echo $lead->getNotes() ?></p>
            </td>
        </tr>
    </table>
    <p style="border-bottom: 1px solid #000;">&nbsp;</p>
    <p style="border-bottom: 1px solid #000;">&nbsp;</p>
    <p style="border-bottom: 1px solid #000;">&nbsp;</p>
    <p style="border-bottom: 1px solid #000;">&nbsp;</p>
    <p style="border-bottom: 1px solid #000;">&nbsp;</p>
    <p style="border-bottom: 1px solid #000;">&nbsp;</p>

    <?php if ($leadCounter < count($leads)) { ?>
        <div style="page-break-after: always"></div>
        <?php
    }
}
?>

</body>
</html>