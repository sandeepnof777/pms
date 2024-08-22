<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>Title</title>
    <style type="text/css">
         /* @page { size: 800pt 800pt; size: A4 portrait;} */
         body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 13px;
            padding-top: 115px;
            padding-bottom: 10px;
        }

        #header {
            position: fixed;
            top: -30px;
            left: -10%;
            color: #000;
            border-bottom: 1px solid #666;
            padding-bottom: 0px;
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
            padding-left: 0;
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
            margin-bottom: 10px;
        }

        thead td {
            padding: 3px;
        }

        td {
            padding: 0;
        }

        tbody td {
            padding: 0;
        }

        tfoot td {
            padding: 5px;
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
            line-height: 15px;
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
            content: "Page" counter(page, roman);
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
            padding: 0 0 5px 0 !important;
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
            width: 500px;
        }

        .proposalImage_p {
            height: 500px;
            margin: auto;
        }

        span.header-left {
            display: inline-block;
            width: 160px;
            text-align: right;
        }

        h2 span.header-left {
            width: 120px;
        }

        table.header-table {
        }

        table.header-table td {
            font-size: 20px;
        }

        td.imageNotes ol, td.imageNotes ul {
            width: 100%;
            display: block;
            margin-top: 0;
            margin-bottom: 0;
            padding-top: 0;
            padding-bottom: 5px;
            padding-left: 30px;
            clear: both;
        }

        td.imageNotes ol li {
            line-height: 20px;
            list-style-position: inside;
        }
        table#estimateSummaryItems { border-collapse: collapse; margin-bottom: 20px; }
    table#estimateSummaryItems td { text-align: center;vertical-align: top;    position: relative;top: 5px; }
    table#estimateSummaryItems tr:nth-child(odd) {background-color: #fafafa;}
    table#estimateSummaryItems tr:nth-child(even){background-color: #efefef;}

    table#estimateSummaryItems th {
        background: #ccc;
        padding: 5px;
        text-align: left;
    }

    table#estimateSummaryItems td {
        padding: 5px;
        text-align: left;
    }
    .checkbox_div {
        border: 1px solid #929191;
        width: .95em;
        height: .95em;
        position: relative;
        top: 0px;
        border-radius: 2px;
    }
    .input_div {
        border: 1px solid #929191;
        width: 100%;
        height: 1.3em;
        position: relative;
        top: 2px;
        border-radius: 2px;
    }

    .smallNotes {
    /* padding: 10px 10px 0; */
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
 
<div class="logo"><img class="theLogo"
                       <?php
                        $logoPath = UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo();
                       if (file_exists($logoPath)){
                           $src = $logoPath;
                       } else {
                           $src = UPLOADPATH . '/clients/logos/none.jpg';
                       }
                       ?>
                       src="data:image/png;base64, <?php echo base64_encode(file_get_contents($src)); ?>"
                       alt=""></div>
<div id="footer">

</div>
<div id="header">
    <table width="650" cellspacing="6" cellpadding="0" border="0"   >
        <tr>
            <td width="120" style="text-align: right; font-weight: bold; font-size: 25px; height: 20px;">
                Work Order:
            </td>
            <td style="font-size: 17px; height: 25px;">
                <?php
                echo $proposal->getClient()->getClientAccount()->getName(); ?> |
                <b>Project: </b> <?php echo $proposal->getProjectName();
                ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; font-size: 17px; line-height: 20px;"></td>
            <td style="font-size: 17px; line-height: 20px;"><?php
            
                echo ($proposal->getProjectAddress()) ? $proposal->getProjectAddress() : '&nbsp;';
                if ($proposal->getProjectCity()) {
                    echo ', ' . $proposal->getProjectCity();
                }
                if ($proposal->getProjectState()) {
                    echo ', ' . $proposal->getProjectState();
                }
                if ($proposal->getProjectZip()) {
                    echo ' ' . $proposal->getProjectZip();
                }
                ?></td>
        </tr>
        <tr>
            <td style="text-align: right; font-size: 17px; line-height: 20px;"><b>Contact:</b></td>
            <td style="font-size: 17px; line-height: 20px;">
                <?php
                echo $proposal->getClient()->getFullName();
                echo ($proposal->getClient()->getCellPhone()) ? ' | C: ' . $proposal->getClient()->getCellPhone() : '';
                echo ($proposal->getClient()->getBusinessPhone()) ? ' | O: ' . $proposal->getClient()->getBusinessPhone() : '';
                echo ($proposal->getClient()->getEmail()) ? ' | E: ' . $proposal->getClient()->getEmail() : '';
                ?>
            </td>
        </tr>
        <tr>
            <td style="text-align: right; font-size: 17px; line-height: 20px;">
                <b><?php echo ($proposal->getJobNumber()) ? 'Job Number:' : '&nbsp;'; ?></b></td>
            <td style="font-size: 17px; line-height: 20px;"><?php echo ($proposal->getJobNumber()) ? $proposal->getJobNumber() : '&nbsp;'; ?></td>
        </tr>
    </table>
</div>
<?php /* @var $proposal models\Proposals */ ?>
<div class="sales_person">
    <b><?php echo $proposal->getOwner()->getFullName() ?></b><br>
    Your Point Person<br>
    <b>O: <?php echo $proposal->getOwner()->getOfficePhone() ?></b><br>
    <b>C: <?php echo $proposal->getOwner()->getCellPhone() ?></b>
</div>

<?php
$orderSetting = $proposal->getWorkOrderSetting();
$data = [];
$data['workOrderSetting']=$orderSetting;
$data['i'] = 1;
foreach($workOrderSections as $workOrderSection){

switch ($workOrderSection->section_code) {
    case "map-direction":
        if($workOrderSection->c_visible){
          $this->load->view('pdf/layouts/work-order-sections/map-direction',$data);
        }
        break;

    case "estimate_items":
        if($workOrderSection->c_visible){
          $this->load->view('pdf/layouts/work-order-sections/estimate_items',$data);
        }
        break;

    case "notes-section":
        if($workOrderSection->c_visible){
          $this->load->view('pdf/layouts/work-order-sections/notes-section',$data);
        }

        break;

    case "audit-section":
        if($workOrderSection->c_visible){
           $this->load->view('pdf/layouts/work-order-sections/audit-section',$data);
        }
            break;

     case "project_specifications":
        if($workOrderSection->c_visible){
           $this->load->view('pdf/layouts/work-order-sections/project_specifications',$data);
        }
            break;

    case "images":
        if($workOrderSection->c_visible){
           $this->load->view('pdf/layouts/work-order-sections/images',$data);
        }
        break;
    case "map_images":
        if($workOrderSection->c_visible){
           $this->load->view('pdf/layouts/work-order-sections/map_images',$data);
        }
        break;    

    case "video":
        if($workOrderSection->c_visible){
           $this->load->view('pdf/layouts/work-order-sections/video',$data);
        }
        break;

    case "intro_video":
        if($workOrderSection->c_visible){
            $this->load->view('pdf/layouts/work-order-sections/intro_video',$data);
        }
        break;
    case "attachments":
        if($workOrderSection->c_visible){
            $this->load->view('pdf/layouts/work-order-sections/attachments',$data); 
        }
        break;
    default:
        echo "";
    }
    $data['i'] = $data['i'] +1;
}
?>


</body>
</html>