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

<div class="logotopright"><img class="theLogo" style="height: 40px; width: 120px; margin-right: 8px;"
                               src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())); ?>"
                               alt=""></div>
<div id="footer">
    <!--Page-->

</div>
<h1 class="underlined global_header" style="position: fixed;">Proposal: <?php echo $proposal->getProjectName() ?></h1>


<?php
/* @var \models\Proposals $proposal */
$s = array('$', ',');
$r = array('', '');



foreach($proposalSections as $proposalSection){

    switch ($proposalSection->section_code) {
        case "title-page":
            if($proposalSection->p_visible){
                $this->load->view('pdf/layouts/standard-sections/title-page');
            }
            break;

        // case "service-provider":
        //     if($proposalSection->p_visible){
        //         $this->load->view('pdf/layouts/standard-sections/service-provider');
        //     }
        //     break;

        case "intro_video":
            if($proposalSection->p_visible){
                $this->load->view('pdf/layouts/standard-sections/intro_video');
            }

            break;

        case "audit-section":
            if($proposalSection->p_visible){
                $this->load->view('pdf/layouts/standard-sections/audit-section');
            }
                break;

         case "project_specifications":
            if($proposalSection->p_visible){
                $this->load->view('pdf/layouts/standard-sections/project_specifications');
            }
                break;

        case "map_images":
            if($proposalSection->p_visible){
                $this->load->view('pdf/layouts/standard-sections/map_images');
            }
            break;

        case "images":
            if($proposalSection->p_visible){
                $this->load->view('pdf/layouts/standard-sections/images');
            }
            break;

        case "video":
            if($proposalSection->p_visible){
                $this->load->view('pdf/layouts/standard-sections/video');
            }
            break;

        case "price-breakdown":
            if($proposalSection->p_visible){
                $this->load->view('pdf/layouts/standard-sections/price-breakdown');
            }
            if($proposalSection->p_visible){
                $this->load->view('pdf/layouts/standard-sections/signature');
            }
            break;

        // case "signature":
        //     $this->load->view('pdf/layouts/standard-sections/price-breakdown');
        //     $this->load->view('pdf/layouts/standard-sections/signature');
        //     break;

        case "additional-info-section":
            if($proposalSection->p_visible){
                $this->load->view('pdf/layouts/standard-sections/additional-info-section');
            }
            break;

        case "attachments":
            if($proposalSection->p_visible){
                $this->load->view('pdf/layouts/standard-sections/attachments'); 
            }
            break;
        default:
            echo "";
        }
    }
?>


</body>
</html>