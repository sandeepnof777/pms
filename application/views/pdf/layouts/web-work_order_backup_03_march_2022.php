<!DOCTYPE html>
<html lang="en">
<?php //echo $layout; die;?>
<head>
    <?php
    $testFont = 'Inter';
    $headerFont = $testFont; //$proposal->getClient()->getCompany()->getCoolHeaderFont();
    $bodyFont = $testFont; //$proposal->getClient()->getCompany()->getCoolTextFont();
    ?>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com    @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title><?php echo $proposal->getProjectName() ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo site_url('static') ?>/css/signature-pad.css">
    <link rel="stylesheet" href="<?php echo site_url('3rdparty/fontawesome/css/font-awesome.min.css') ?>">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Hind:wght@400;500&family=Roboto:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">
    <link rel="stylesheet" href="<?php echo site_url('static') ?>/css/proposal.css">
    <link rel="stylesheet" type="text/css" href="<?php echo site_url('3rdparty/sweetalert/sweetalert2.min.css'); ?>" media="all">
    <script src="https://maps.googleapis.com/maps/api/js?v=3&key=<?php echo $_ENV['GOOGLE_API_KEY']; ?>"></script>

    <?php
    if($nosidebar){?>

    <style>

        @media all and (max-width: 1024px) and (max-height: 768px) {
            .ipad_hide {
                display: none !important;
            }
            /* .header_project_name{width:40%!important;} */
            .info_header_buttons{width:35%!important;}
            /* .header-info-btn{display: block!important;} */
            #infoHeader{z-index: 1!important;}
            #navbar-example3{z-index: 2!important;}
        }

    </style>
<?php }?>
<?php
    if($noDownload){?>
<style>
    .download-btn,.download-zoom{ display: none !important;}
</style>
<?php } ?>
<style type="text/css">
body{
            /* font-family: <?php echo $bodyFont; ?>, sans-serif!important; */
            font-weight: 500;
            background: #41464b;
            position: relative;
            font-size: 13px;
            line-height: 1.1;
            color: #000;
        }

        h1 {
            font-size: 24px;
            font-family: <?php echo $headerFont ?>, Sans-Serif !important;
            font-weight: bold;
            margin: 25.56px 0px;
        }

        h2 {
            font-size: 20px;
            font-family: <?php echo $headerFont ?>, sans-serif !important;
            font-weight: bold;
            margin: 25.56px 0px;
        }

        h3 {
            font-family: <?php echo $headerFont ?>, sans-serif !important;
            font-size: 17px;
            font-weight: bold;
            margin: 25.56px 0px;
        }

        #videoURL {
            display: none;
        }

        .only_show_print {
            display: none;
        }

        .zoom {
            top: 165px;
        }

        .zoom-out {
            top: 235px;
        }

        .zoom-init {
            top: 305px;
        }
        .service_image_offcanvas,#offcanvasRight2{width:100%;}


        @media all and (min-width: 768px) and (min-height: 1024px) and (orientation: portrait) {
            /* .title_big { color: red; }  */
            .ipad_hide {
                display: none !important;
            }
            
            .map-direction{
                order:2;
            }
            .top_table{width: 78%!important;}
            .top_hide_mobile{margin-top: 30px!important;}
            .map-height{min-height:400px!important;}
            .embed-responsive-item.audit-full-height{height: calc(100vh - 40px)!important;}
            .canvas-back-right-btn{
                right: 10px;
            }
            #followTab2{width: 45px;}
            .ftSpan i {
                    font-size: 38px !important;
                }
            .embed-responsive-16by9 .play-overlay {
                opacity: 1;
            }
            .VideoPlayersOffcanvas{width: 85%!important;}
            .sectionChanger{display: none !important;}
            .mg-left-55{margin-left: 0;}
            .info_header_buttons{width:40%}
            .header_project_name{width:25%}
            .download-btn {
                float: left!important;
            }
            .btn-pause {
                top: 80px !important;
            }

            .ipad_sidebar_space {
                margin-top: 60px !important;
            }

            /* .boxed-section { width: 75%;}
			#navbar-example3 { width: 25%;}
			.sidebar-close {left: 35%;}
			#followTab {left: 25%;} */
            #boxed-section {
                padding-left: 5px !important;
                padding-right: 5px !important;
            }

            .boxed-section {
                width: 100%;
            }

            #navbar-example3 {
                width: 35%;
                z-index: 3;
            }

            .sidebar-close {
                left: 35%;
            }

            .closeNav {
                right: 65%
            }

            #followTab {
                /* left: 35%; */
            }

            #offcanvasRight {
                width: 80%;
            }

            #offcanvasRight3 {
                width: 80%;
            }

            #offcanvasRight2 {
                width: 80%;
            }

            #offcanvasRight4 {
                width: 90%;
            }

            #serviceOffcanvasRight {
                width: 80%;
            }

            .openbtn {
                z-index: 99;
            }

            .margin-left-38 {
                margin-left: 0px !important;
            }

            #infoHeader {
                width: 100% !important;
            }

            .header-info-btn {
                display: block;
            }
/* 
            .proposal-details {
                margin-bottom: 75px;
                width: 100%;
            }

            .signee-details {
                padding-top: 7px;
                float: left !important;
                width: 100%;
            }

            #add_signature {
                margin: 0px 40%;
            } */
            .play-overlay{z-index:1;}
            .video img{z-index:1;}
            .proposal_video_ifram{min-height:360px}
        }

        
        @media all and (max-width: 1024px) and (min-height: 768px) and (orientation: landscape) {
            /* .title_big { color: blue; }  */
            .embed-responsive-16by9 .play-overlay {
                opacity: 1;
            }
           
            .download-zoom {
                bottom: 15px!important;
            }
            .button-text {
                display: none;
            }
            
            .canvas-back-right-btn{
                right: 10px;
            }
            .embed-responsive-item.audit-full-height{height: calc(100vh - 40px)!important;}
            .ipad_hide {
                display: none !important;
            }
            .sectionChanger{display: none !important;}
            .mg-left-55{margin-left: 0;}
            #offcanvasRight {
                width: 80%;
            }

            #offcanvasRight3 {
                width: 80%;
            }

            #offcanvasRight2 {
                width: 80%;
            }

            #offcanvasRight4 {
                width: 90%;
            }

            #serviceOffcanvasRight {
                width: 80%;
            }

            .margin-left-38 {
                margin-left: 0px !important;
            }

            .boxed-section-wide #infoHeader {
                width: 100% !important;
            }

            .boxed-section #infoHeader {
                width: 100% !important;
            }

            .embed-responsive-item {
                min-height: 500px !important;
                height: auto !important;
            }

            .proposal_video_ifram{min-height:285px!important;}
            .header-info-btn {
                display: block !important;
            }

            .ipad2 {
                width: 25% !important;
            }

            .ipad3 {
                width: 50% !important;
            }

            .ipad4 {
                width: 75% !important;
            }

            /* #add_signature {
                margin: 0px 40%;
            } */
            #navToggleBtn{z-index:101;}
            #navbar-example3{z-index:100;}
            #infoHeader{z-index:99;}
            .play-overlay{z-index:1;}
            .video img{z-index:1;}
        }

        @media all and (max-width: 1024px) and (min-height: 1366px) and (orientation: portrait) {
            #navToggleBtn{z-index:101;}
            #navbar-example3{z-index:100;}
            #infoHeader{z-index:99;}
        }

        @media all and (max-width: 414px) and (max-height: 823px) and (orientation: portrait) {
            .sectionChanger{display: none !important;}
            .embed-responsive-16by9 .play-overlay {
                opacity: 1;
            }
            .only_show_on_mobile_portrait{display: block!important;}
            .map-direction{
                order:2;
            }

            .top_bar_logo_mobile{
                width: 100px!important;
            }
            .header-project-name{
                display: block!important;
                padding-top: 5px;
                width: 60%;
                float: left;
            }
            .header-project-name tr:nth-child(2){font-weight: bold;}
            .map-height{display: none;}
            .download-zoom{
                width: 40px;
                height: 40px;
                color: #989797;
                padding: 3px 5px 5px 5px;
                border: 1px solid #989797;
                right: 20px;
                font-size: 25px;
        }
            .image-section-inlarge-text{display: none;}
            .image-note-section-info{display: none!important;}
            .image-section-info{
                display: block;
                position: absolute;
                right: 13px;
                margin-top: 7px;
                background: #000000a3;
                color: #fff;
                width: 31px;
                cursor: pointer;
                height: 31px;
                text-align: center;
                font-size: 22px;
                border-radius: 0 0 0 5px;
            }
            #mobileImageInfo{
                height: fit-content;
                height: -moz-max-content;
                width: 90%;
                overflow-y: auto;
                max-height: 85%;
                padding: 0;
                margin: auto;
                display: block;
                top: 0;
                bottom: 0;
                left: 0;
                right: 0;
            }
            .canvas-back-right-btn{
                right: 10px;
            }
            .embed-responsive-item.audit-full-height{height: calc(100vh - 40px)!important;}
            .aboutus{max-height: 150px;margin-bottom: 5px;overflow: hidden;}
            .fullText{max-height: none!important;}
            #about_us_read_more{display: block;margin-left: 75%;width: 95px;}
            .company-info-section h2{margin-top: 15px;}
            .company-info-section img{display: none;}
            .contact-person-section h2{ margin: 20px 0px;}
            .info_header_logo{width: 33%;}
            .header_project_name{width: 60%;padding-top: 0px;display: flex;align-items: center;}
            .info_header_client_details{display: none;}
            .info_header_buttons{display: none;}
            .info_header_logo img{width: 100!important;}
            h1.underlined{margin-top:0px;margin-bottom: 10px;}
            .container-fluid{
                padding-left: 5px;
                padding-right: 5px;
            }
            .ipad_sidebar_space {
                margin-top: 60px !important;
            }
            .doc-section{
                margin-top: 5px;
            }
            .download-btn,.header_project_name,.top_table{
                display: none !important;
            }
            #infoHeader.grid {
                width: 100% !important;
                position: sticky;
                z-index: 9!important;
                padding: 5px 17px!important;
                min-height: 55px;
            }
            .mobile-text-right{text-align: right;}
            .play-overlay {
                z-index: 0;
            }
            .mg-left-55{margin-left: 0;}
            /* .title_big { color: yellow; }  */
            .VideoPlayersOffcanvas{
                width: 90%!important;
            }
            .small_device_hide {
                display: none !important;
            }
            .mobile_img{
                    display: block;
                }
            .mobile-menu{
                z-index:99!important;
                top: 11px;
            }
            .closeNav {
                display: none;
            }

            #navbar-example3 {
                width: 0%;
                box-shadow: rgb(31 73 125 / 80%) 12px 0px 20px -4px, rgb(31 73 125 / 80%) -12px 0px 15px -4px;
            }

            .mobile-menu {
                display: block;
            }

            .mobile_close_nav {
                display: block;
            }

            .phone-potrait-margin-0 {
                margin: 0px;
            }

            #offcanvasRight {
                width: 90%;
            }

            #offcanvasRight3 {
                width: 90%;
            }

            #offcanvasRight2 {
                width: 90%;
            }

            #offcanvasRight4 {
                width: 90%;
            }

            #serviceOffcanvasRight {
                width: 90%;
            }

            .boxed-section {
                margin: auto;
                width: 100%;
            }

            /* #infoHeader {
                display: none !important;
                margin-left: 25px;
            } */

            .signee-details {
                padding-top: 7px;
                float: left !important;
                width: 100%;
            }

            .margin-left-38 {
                margin-left: 0px !important;
            }

            .pdf-height {
                min-height: 0 !important;
            }

            .carousel-control-next, .carousel-control-prev {
                width: 25px;
            }

            .invoice {
                padding: 20px !important;
                padding-right: 20px !important;
                padding-left: 20px !important;
            }

            .item-content-texts ol {
                padding-left: 13px !important;
            }

            #additional-info-section ol {
                padding-left: 13px !important;
            }

            .service_text_total {
                padding-left: 10px !important;
            }

            .embed-responsive-item {
                
                height: auto !important;
            }
            .proposal_video_ifram{min-height:100%!important;}

            .table-striped td:nth-child(3) {
                display: none;
            }

            #service_provider_title {
                padding-bottom: 0px !important;
                padding-top: 45px !important;
            }

            h1.title_big_aboutus {
                padding-top: 45px !important;
            }

            .service-section a {
                word-wrap: break-word !important;
            }

            span {
                line-height: 1.3 !important;
            }

            .doc-section li {
                line-height: 1.3 !important;
            }

            .ft-s-28 {
                font-size: 28px !important;
            }

            .ft-s-22 {
                font-size: 22px !important;
            }

            .image_title {
                
                margin: 15px 0px !important;
            }

            .img_mobile {
                padding: 0px !important;
                object-fit: contain!important;
                height: auto!important;
            }
            .video_title{
                text-align: center;
            }

            .no-price ol {
                padding-left: 23px !important;
            }

            h1.title_big {
                padding-top: 20px !important;
            }

            .coverHr {
                padding-bottom: 35px !important;
            }

            .company_owner {
                padding-bottom: 15px !important;
            }

            .issuedby {
                margin-top: 40px !important;
                float: none;
                margin: auto;
            }

            .service-section {
                margin-bottom: 30px;
            }

            table.mg-l-11 {
                margin-left: 0px;
            }

            /* #add_signature {
                float: right;
                margin: 0 !important;
            } */

            .proposal-details {
                margin-bottom: 75px;
                width: 100%;
            }

            .attachmentsHead {
                margin-left: 12px !important;
            }

            .margin-bottom-17 {
                margin-bottom: 10px !important;
            }

            .carousel-img {
                height: calc(100vh - 500px);
            }

            #proposalCarousel {
                margin: 50% 0px;
            }

        }

        @media all and (max-width: 823px) and (max-height: 414px) and (orientation: landscape) {
            /* .title_big { color: red; } */
            .embed-responsive-16by9 .play-overlay {
                opacity: 1;
            }
            .download-zoom {
                bottom: 15px!important;
            }
            .canvas-back-right-btn{
                right: 30px;
            }
            .button-text {
            display: none;
        }
        
        .map-direction{
                order:2;
            }
        .map-height{display: none;}
        .top_table{width: 70%!important;}
        

            .embed-responsive-item.audit-full-height{height: calc(100vh - 40px)!important;}
            #offcanvasRight2 .offcanvas-header{display: none !important;}
            #offcanvasRight2 .carousel-caption{display: none !important;}
            #offcanvasRight2 .offcanvas-body{padding-top: 0;padding-bottom: 0;}
            #offcanvasRight2 .pd-top-25{padding-top: 3px;}
            #proposalCarousel{margin-top: 0px;}
            .mobile_landscape_image_close_btn{display: block;position: absolute;right: 0px;font-size: 25px;z-index: 999;}
            #followTab2{width: 45px;}
            
            .play-overlay {
                z-index: 1;
            }
            .small_device_hide_l {
                display: none !important;
            }
            .ftSpan{top: 40%!important;}
            .VideoPlayersOffcanvas{width: 73%!important;}
            .video_player_iframe_body{ padding-bottom: 44.25%!important;}
            .sectionChanger{display: none !important;}
            .mg-left-55{margin-left: 0;}
            .mobile-menu{
                z-index:2!important;
            }
            .proposal_video_ifram{min-height:260px!important;}
            .info_header_buttons{width:40%;padding-left: 0;padding-right: 0;}
            .header_project_name{width:25%}

            .ipad_sidebar_space {
                margin-top: 60px !important;
            }

            /* .boxed-section { width: 75%;}
			#navbar-example3 { width: 25%;}
			.sidebar-close {left: 35%;}
			#followTab {left: 25%;} */
            .boxed-section {
                width: 100%;
            }

            #navbar-example3 {
                width: 35%;
                z-index: 3;
            }

            .sidebar-close {
                left: 35%;
            }

            .closeNav {
                right: 65%
            }

            #followTab {
                /* left: 35%; */
            }

            #boxed-section {
                padding-left: 5px !important;
                padding-right: 5px !important;
            }

            #offcanvasRight {
                width: 90%;
            }

            #offcanvasRight3 {
                width: 90%;
                height: auto !important;
                overflow: scroll;
            }

            #offcanvasRight2 {
                width: 90%;
                height: auto !important;
                overflow: scroll;
            }

            #offcanvasRight4 {
                width: 90%;
            }

            #serviceOffcanvasRight {
                width: 90%;
                height: auto;
                overflow: scroll;
            }

            .signee-details {
                padding-top: 20px;
                float: left !important;
                width: 100%;
            }

            .openbtn {
                z-index: 99;
            }

            /* .button-text {display:none;} */
            .header-info-btn {
                display: block;
            }

            #infoHeader.grid {
                width: 100% !important;
                position: sticky;
            }

            .btn-toggle2::after {
                right: 10px;
                content: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='24' height='24' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='rgba%280,0,0,.5%29' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 14l6-6-6-6'/%3e%3c/svg%3e");
    
            }

            .margin-left-38 {
                margin-left: 0px !important;
            }

            .carousel-control-next, .carousel-control-prev {
                width: 25px;
            }

            .carousel-img {
                height: 98vh!important;
            }

            .proposal-details {
                margin-bottom: 75px;
                width: 100%;
            }

            /* #add_signature {
                margin: 0px 40%;
            } */
        }

        @media print {
            
            #print_msg{
                display: block!important;
                font-size: 20px;
                font-weight: bold;
                margin: auto;
                text-align: center;
                position: absolute;
                top: 50%;
            }
            #print_msg h1{font-size: 40px;}
            .note_print{margin-top: 50px;font-weight: 100;font-size: 35px;}
            .boxed-section{ display: none; }
            .download-zoom,nav {
                display: none !important;
            }
            .sidebar-close {
                display: none !important;
            }
            #followTab {
                display: none !important;
            }
            .print_hide {
                display: none !important;
            }
            
        }

        @page {
            size: A4;
            margin: 0mm;
            margin-top: 20px;
        }

        

        @media only screen 
and (min-width : 900px) 
and (max-width : 990px) {
    .map-height,.map-direction{width: 50%!important;}
    .top_table{width: 80%!important;}
}

@media all and (min-width: 1366px) {
    .topbar_contact_tr{display:none!important;}
   
    .topbar_contact_table{display: block!important;width:33%;float: right;margin-top: 9px!important;}

    .top_table{margin-top: 10px!important;margin-left: 40px!important;width:53%!important;}
}


        .loader_overlay {
            background: #ffffff;
            color: #666666;
            position: fixed;
            height: 100%;
            width: 100%;
            z-index: 5000;
            top: 0;
            left: 0;
            float: left;
            text-align: center;
            padding-top: 20%;
            opacity: .80;
        }
.download-zoom{bottom: 85px;}
.play-overlay{z-index: 0;}
.pdf-height{min-height:816px}
.map-height{min-height:500px;}
.header-project-name{display: none;}
.topbar_contact_table{display: none;}
.sales_person_office_contact{display: none;}
.top_bar_logo_mobile{margin-top: 10px;margin-bottom: 10px;}
.topbar_contact_table,.top_table{margin-top: 5px;}
.header_project_name{text-align: center;}
.only_show_on_mobile_portrait{display: none;}
.sidebar_bottom_email_tag{
    max-width: 215px;
    display: table;
    white-space: pre-wrap;
    white-space: -moz-pre-wrap;
    white-space: -pre-wrap;
    white-space: -o-pre-wrap;
    word-wrap: break-word;
    hyphens: auto;
    overflow-wrap: anywhere;
}

.image-note-section-info{
            display: block;
                position: absolute;
                bottom: 1px;
                right: 98px;
                background: #000000a3;
                color: #fff;
                width: 31px;
                cursor: pointer;
                height: 25px;
                text-align: center;
                font-size: 18px;
                margin-top: 1px;
                border-radius: 5px 5px 0px 0px;
            }
            .image-section-info i,.image-note-section-info i{margin-top: 5px;}
    </style>
</head>

<div id="sizer">
    <div class="d-block d-sm-none d-md-none d-lg-none d-xl-none" data-size="xs"></div>
    <div class="d-none d-sm-block d-md-none d-lg-none d-xl-none" data-size="sm"></div>
    <div class="d-none d-sm-none d-md-block d-lg-none d-xl-none" data-size="md"></div>
    <div class="d-none d-sm-none d-md-none d-lg-block d-xl-none" data-size="lg"></div>
    <div class="d-none d-sm-none d-md-none d-lg-none d-xl-block" data-size="xl"></div>
</div>
<body>
<div id="print_msg">
    <div><h1>Print Instructions</h1></div>   
    <img width="800px" src="<?php echo site_url('static/images/work_order_print_guide.png'); ?>">
    <div class="note_print"><p>Please use the print button on the page as shown. <br/><br/>This will generate a secure PDF for you to print.</p></div>   
</div>

<div style="display: none; height: 10px; position: sticky; width: 100%; top:300px; background-color: red; z-index: 999999"></div>
<?php
$s = array('$', ',');
$r = array('', '');
$pdf_layout = 'cool';
if ($proposal->getLayout()) {
    $pdf_layout = $proposal->getLayout();
} else {
    if ($proposal->getOwner()->getLayout()) {
        $pdf_layout = $proposal->getOwner()->getLayout();
    } else {
        $pdf_layout = $proposal->getOwner()->getCompany()->getLayout();
    }
}

$print_layout = ltrim($pdf_layout, "web-");
$print_pdf_url = site_url('proposals/live/view/work_order/' . $proposal->getAccessKey() . '.pdf');

// Estimation Stuff
/* @var $estimationRepository \Pms\Repositories\EstimationRepository */
$lineItemCount = $estimationRepository->proposalHasEstimateItems($proposal);
?>
<div class="divider">
    <div class="inner"></div>
</div>
<a class="mobile-menu openMobileNav"><i class="fa fa-bars" aria-hidden="true"></i></a>
<a class="back-to-top print_hide" data-container="body"><i class="fa fa-chevron-up"></i></a>
<a class="btn-pause print_hide" data-container="body" data-bs-toggle="tooltip" data-bs-placement="left"
   title="Pause All"><i class="fa fa-pause"></i></a>
<a class="btn-zoom zoom print_hide small_device_hide ipad_hide small_device_hide_l" data-container="body"
   data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom In"><i class="fa fa-plus"></i></a>
<a class="btn-zoom zoom-out print_hide small_device_hide ipad_hide small_device_hide_l" data-container="body"
   data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom Out"><i class="fa fa-minus"></i></a>
<a class="btn-zoom zoom-init print_hide small_device_hide ipad_hide small_device_hide_l" data-container="body"
   data-bs-toggle="tooltip" data-bs-placement="left" title="Reset Zoom"><i class="fa fa-undo"></i></a>
<a href="<?= $_SERVER['REQUEST_URI'].'/download';  ?>" target="_blank" download="<?= $proposal->getProjectName();?>"
   class="btn-zoom download-zoom " data-container="body"
   data-bs-toggle="tooltip" data-bs-placement="left" title="Download"><i class="fa fa-download"></i></a>


   <a href="<?php echo site_url('proposals/live/view/work_order/'.$proposal->getAccessKey().'.pdf'); ?>" target="_blank"
   class="btn-zoom print-btn print_hide small_device_hide ipad_hide small_device_hide_l" data-container="body"
   data-bs-toggle="tooltip" data-bs-placement="left" title="Print"><i class="fa fa-print"></i></a>
<div class="container-fluid">
    <button type="button" class="btn btn-dark  print_hide  <?php if($nosidebar){ echo 'openNav';}else{echo 'closeNav';}?>" id="navToggleBtn" <?php if($nosidebar){ echo 'style="right:calc(100%)"';}?> aria-label="Close"><i
                class="fa fa-chevron-left sidebar-btn-icon"></i></button>
    <ul id="followTab2" class="<?php if($nosidebar){ echo 'openNav';}else{echo 'closeNav';}?> print_hide small_device_hide">
        <span class="ftSpan">
            <i class="fa fa-fw fa-chevron-right"></i>
        </span>
    </ul>
    <div class="row phone-potrait-margin-0">

        <nav class="col-md-3 nav " id="navbar-example3" style="width: 0px;">
            <!-- <button type="button" class="btn btn-dark sidebar-close small_device_hide" aria-label="Close"><i class="fa fa-chevron-left sidebar-btn-icon"></i></button>
				<ul id="followTab" class="sidebar-close small_device_hide"></ul> -->
            <div class="flex-shrink-0 p-3 bg-white sticky-sidebar scrollbar-primary">
                <button type="button" class="btn-close mobile_close_nav"></button>
                <a href="#"
                   class="d-flex align-items-center pb-3 sidebarTitle link-dark text-decoration-none border-bottom">
                    <span class="fs-5 fw-semibold">Table of Contents</span>
                </a>


                <ul class="list-unstyled ps-0 list-group-striped" style="max-height: 60%;overflow: auto;">

                    <li class="mb-1"><a href="#map-direction" class="btn sep-link align-items-center rounded">
                            <i class="fa fa-fw fa-file-o"></i>&nbsp;&nbsp;Map & Directions</a>


                    <li class="mb-1 ">
                        <a href="#project_specifications"
                           class="sep-link btn btn-toggle align-items-center rounded collapsed proposal_service_btn"
                           data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
                            <i class="fa fa-fw fa-list"></i>&nbsp;&nbsp;Project Specifications
                        </a>
                        <div class="collapse" id="home-collapse">
                            <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
                                <?php foreach ($services as $service) { ?>
                                    <li><a href="#service_<?= $service->getServiceId(); ?>"
                                           data-parent-menu-class="proposal_service_btn"
                                           class="btn sep-link rounded inline-block sub_menu"><?php echo $service->getServiceName();
                                            if ($service->isOptional()) { ?><span
                                                    class="badge rounded-pill bg-info pull-right" data-container="body"
                                                    data-bs-toggle="tooltip" data-bs-placement="right"
                                                    title="Optional Service">OS</span><?php } ?></a></li>
                                <?php } ?>

                            </ul>
                        </div>
                    </li>
                    <?php
                    if ($lineItemCount>0) {
                        ?>

                        <li class="mb-1"><a href="#estimate_items"
                                            class="video_section_btn btn sep-link align-items-center rounded">
                                <i class="fa fa-fw fa-video-camera"></i>&nbsp;&nbsp;Estimate Items</a>
                        </li>
                    <?php } ?>
                    <?php if (count($images)) { ?>
                        <li class="mb-1"><a href="#images"
                                            class="image_section_btn btn sep-link align-items-center rounded">
                                <i class="fa fa-fw fa-picture-o"></i>&nbsp;&nbsp;Proposal Images</a>
                        </li>

                        <?php
                    }

                    if (count($work_order_videos)) {
                        ?>

                        <li class="mb-1"><a href="#video"
                                            class="video_section_btn btn sep-link align-items-center rounded">
                                <i class="fa fa-fw fa-video-camera"></i>&nbsp;&nbsp;Proposal Video</a>
                        </li>
                    <?php } ?>


                    <?php
                        if ($proposal->getAuditKey()) { ?>
                    <li class="mb-1"><a href="#audit-section" class="btn sep-link align-items-center rounded">
                            <i class="fa fa-fw fa-map-marker"></i>&nbsp;&nbsp;Property Inspection/Audit</a></li>
                    <?php } ?>
                    <?php
                    //proposal attachments
                    if ($proposal->getWorkOrderNotes()) {
                    ?>
                    <li class="mb-1">
                        <a href="#notes-section" class="btn sep-link align-items-center rounded">
                            <i class="fa fa-fw fa-usd"></i>&nbsp;&nbsp;Notes
                        </a>
                    </li>
                    <?php } 
                   
                   
                    if (count($workorder_attachments)) { ?>
                        

                        <li class="mb-1 ">
                            <a href="#attachments" class="btn sep-link align-items-center rounded">
                                <i class="fa fa-fw fa-paperclip"></i>&nbsp;&nbsp;Attachments
                            </a>
                        </li>
                    <?php } ?>

                </ul>

                <table class="only_show_on_mobile_portrait"  cellspacing="6" cellpadding="0" border="0" style="float: left;position:absolute;bottom: 100px;width: 99%;left:0">
                <colgroup>
                    <col width="31%">
                    <col width="69%">
                </colgroup>
                                    <tr class="top_hide_mobile">
                                        <td width="115" style="text-align: right; font-weight: bold; font-size: 16px; height: 20px;">
                                            Work Order:&nbsp;&nbsp;
                                        </td>
                                        <td style="font-size: 16px;">
                                            <?php
                                            echo $proposal->getClient()->getClientAccount()->getName(); ?>
                                        </td>
                                    </tr>
                                    <tr class="top_hide_mobile">
                                        <td width="115" style="text-align: right; font-weight: bold; font-size: 16px; height: 20px;">
                                            Project:&nbsp;&nbsp;
                                        </td>
                                        <td style="font-size: 16px;">
                                            <?php echo ($proposal->getJobNumber() ? 'Job #: ' . $proposal->getJobNumber() . "<br />" : ''); ?>
                                            <?php echo $proposal->getProjectName();
                                            ?>
                                        </td>
                                    </tr>
                                    
                                    <tr class="top_show_mobile">
                                        <td width="115" style="text-align: right; font-size: 16px; line-height: 20px;vertical-align: baseline;"><b>Address:&nbsp;&nbsp;</b></td>
                                        <td style="font-size: 16px;">
                                       
                                        <?php

                                            echo ($proposal->getProjectAddress()) ? $proposal->getProjectAddress().', ' : '&nbsp;';
                                            if ($proposal->getProjectCity()) {
                                                echo $proposal->getProjectCity();
                                            }
                                            if ($proposal->getProjectState()) {
                                                echo ', ' . $proposal->getProjectState();
                                            }
                                            if ($proposal->getProjectZip()) {
                                                echo ' ' . $proposal->getProjectZip();
                                            }
                                            ?>
                                        </td>
                                    </tr>

                                    
                                    <tr>
                                        <td style="text-align: right; font-size: 16px; line-height: 20px;vertical-align: baseline;"><b>Contact:&nbsp;&nbsp;</b></td>
                                        <td style="font-size: 16px;">
                                            <?php
                                            echo $proposal->getClient()->getFullName();
                                            echo ($proposal->getClient()->getCellPhone()) ? ' | C: <a href="tel:'. $proposal->getClient()->getCellPhone().'">' . $proposal->getClient()->getCellPhone().'</a>' : '';
                                            echo ($proposal->getClient()->getBusinessPhone()) ? ' <br/> O: <a href="tel:'. $proposal->getClient()->getBusinessPhone().'">' . $proposal->getClient()->getBusinessPhone().'</a>' : '';
                                            echo ($proposal->getClient()->getEmail()) ? ' <br/> E: <a class="sidebar_bottom_email_tag" href="mailto:'. $proposal->getClient()->getEmail().'">' . $proposal->getClient()->getEmail().'<br/></a>' : '';
                                            ?>
                                        </td>
                                    </tr>
                                   
                                </table>
                            </div>
                            <div class="col-lg-2 col-md-3  pd-t-5 only_show_on_mobile_portrait" style="position: absolute;bottom: 20px;margin: auto;left: 28%;text-align: center;">
                                <div class="sales_person">
                                    <b><?php echo $proposal->getOwner()->getFullName() ?></b><br>
                                    <p style="margin-bottom: 5px;">Your Point Person</p>
                                    
                                    <b >O: <a href="tel:<?php echo $proposal->getOwner()->getOfficePhone() ?>"><?php echo $proposal->getOwner()->getOfficePhone() ?></a></b><br>
                                    <b>C: <a href="tel:<?php echo $proposal->getOwner()->getCellPhone() ?>"><?php echo $proposal->getOwner()->getCellPhone() ?></a></b>
                                </div>
                                
                            </div>

            </div>


        </nav>


        <!-- BEGIN INVOICE -->
        <div class="boxed-section" id="boxed-section" style="width: 100%;">
            <?php


            $pdf_url = site_url('proposals/live/preview/' . $pdf_layout . '/plproposal_' . $proposal->getAccessKey() . '.pdf');
            ?>
<div class="header grid invoice print_hide sticky" id="infoHeader" style="padding: 0px 16px;">
                    <div class="grid-body">
                        <div class="row">

                            <div class="col-lg-10 col-md-9 " style="padding: 0px;">
                            
                                <img class="mg-left--4 top_bar_logo_mobile" style="float: left;margin-top: 15px;"
                                     src="<?php echo site_url('uploads/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo()); ?>"
                                     width="125px" height="auto" alt="">
                           
                            <table class="header-project-name">
                                <tr><td><?php echo $proposal->getClient()->getClientAccount()->getName(); ?></td></tr>
                                <tr><td>
                                        <?php echo ($proposal->getJobNumber() ? 'Job #: ' . $proposal->getJobNumber() : ''); ?>
                                        <?php echo $proposal->getProjectName();?>
                                    </td></tr>
                            </table>
                            <table class="top_table"  cellspacing="6" cellpadding="0" border="0" style="float: left;">
                                    <tr class="top_hide_mobile">
                                        <td width="115" style="text-align: right; font-weight: bold; font-size: 16px; height: 20px;">
                                            Work Order:&nbsp;&nbsp;
                                        </td>
                                        <td style="font-size: 16px; height: 25px;">
                                            <?php
                                            echo $proposal->getClient()->getClientAccount()->getName(); ?> |
                                            <b>Project: </b> <?php echo $proposal->getProjectName();
                                            ?>
                                        </td>
                                    </tr>
                                    
                                    <tr class="top_show_mobile">
                                        <td width="115" style="text-align: right; font-size: 16px; line-height: 20px;vertical-align: baseline;"><b>Address:&nbsp;&nbsp;</b></td>
                                        <td style="font-size: 16px; line-height: 20px;">
                                      
                                        <?php

                                            echo ($proposal->getProjectAddress()) ? $proposal->getProjectAddress().', ' : '&nbsp;';
                                            if ($proposal->getProjectCity()) {
                                                echo $proposal->getProjectCity();
                                            }
                                            if ($proposal->getProjectState()) {
                                                echo ', ' . $proposal->getProjectState();
                                            }
                                            if ($proposal->getProjectZip()) {
                                                echo ' ' . $proposal->getProjectZip();
                                            }
                                            ?>
                                        </td>
                                    </tr>

                                    
                                    <tr class="topbar_contact_tr">
                                        <td style="text-align: right; font-size: 16px; line-height: 20px;vertical-align: baseline;"><b>Contact:&nbsp;&nbsp;</b></td>
                                        <td style="font-size: 16px; line-height: 20px;">
                                            <?php
                                            echo $proposal->getClient()->getFullName();
                                            echo ($proposal->getClient()->getCellPhone()) ? ' | C: <a href="tel:'. $proposal->getClient()->getCellPhone().'">' . $proposal->getClient()->getCellPhone().'</a>' : '';
                                            echo ($proposal->getClient()->getBusinessPhone()) ? ' | O: <a href="tel:'. $proposal->getClient()->getBusinessPhone().'">' . $proposal->getClient()->getBusinessPhone().'</a>' : '';
                                            // echo ($proposal->getClient()->getEmail() && !$noDownload) ? ' | E: <a href="mailto:'. $proposal->getClient()->getEmail().'">' . $proposal->getClient()->getEmail().'</a>' : '';
                                            ?>
                                        </td>
                                    </tr>
                                   
                                </table>
                                <!-- <a href="<?= $print_pdf_url;  ?>" download ="<?= $proposal->getProjectName();?>"
                                    style="float: right;margin-top: 15px;"
                                   class="download-btn btn btn-primary btn-sm mg-l-10 pave-btn tiptip" title="Download"><i
                                            class="fa fa-fw fa-download"></i> <span class="button-text">Download</span></a> -->
                                <table class="topbar_contact_table"><tr><td style="text-align: right; font-size: 16px; line-height: 20px;vertical-align: baseline;"><b>Contact:&nbsp;&nbsp;</b></td>
                                        <td style="font-size: 16px; line-height: 20px;">
                                            <?php
                                            echo $proposal->getClient()->getFullName();
                                            echo ($proposal->getClient()->getCellPhone()) ? ' | C: <a href="tel:'. $proposal->getClient()->getCellPhone().'">' . $proposal->getClient()->getCellPhone().'</a>' : '';
                                            echo ($proposal->getClient()->getBusinessPhone()) ? ' | O: <a href="tel:'. $proposal->getClient()->getBusinessPhone().'">' . $proposal->getClient()->getBusinessPhone().'</a>' : '';
                                            echo ($proposal->getClient()->getEmail() ) ? ' <br/> E: <a href="mailto:'. $proposal->getClient()->getEmail().'">' . $proposal->getClient()->getEmail().'</a>' : '';
                                            ?>
                                        </td></table>
                            </div>
                            <div class="col-lg-2 col-md-3  pd-t-5 header_project_name mg-t-5">
                                <div class="sales_person">
                                    <b><?php echo $proposal->getOwner()->getFullName() ?></b><br>
                                    <p style="margin-bottom: 5px;">Your Point Person</p>
                                    
                                    <b class="sales_person_office_contact">O: <a href="tel:<?php echo $proposal->getOwner()->getOfficePhone() ?>"><?php echo $proposal->getOwner()->getOfficePhone() ?></a><br></b>
                                    <b>C: <a href="tel:<?php echo $proposal->getOwner()->getCellPhone() ?>"><?php echo $proposal->getOwner()->getCellPhone() ?></a></b>
                                </div>
                                
                            </div>



                        </div>
                    </div>
                    <!-- <div  id="info-collapse">
                        <div class="row grid info-collapse" style="position: absolute;top: 60px;right: 12px;">

                            <div class="col-md-6 sticky_header_expanded">
                                <strong>
                                    <?php echo ($proposal->getClient()->getClientAccount()->getName() == 'Residential') ? 'Residential Proposal' : $proposal->getClient()->getClientAccount()->getName(); ?>
                                </strong><br/>
                                <span><?php echo $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName() ?></span>
                            </div>
                            <div class="col-md-6 sticky_header_expanded">
                                <strong><?php echo $proposal->getProjectName() ?></strong></br>
                                <span><?php echo $proposal->getProjectAddress() ?><?php echo trim($proposal->getProjectCity()) . ', ' . $proposal->getProjectState() . ' ' . $proposal->getProjectZip() ?></span>
                            </div>


                        </div>
                    </div> -->
                </div>

            <div class="doc-section" id="doc-section" style="max-width: 1120px;">
                


                <div id="print_header" style="display:none;">
                    <h1 class="underlined global_header" style="position: fixed;">
                        Proposal:
                        <?php echo ($proposal->getJobNumber() ? 'Job #: ' . $proposal->getJobNumber() . "<br />" : ''); ?>
                        <?php echo $proposal->getProjectName() ?></h1>
                    <div class="logotopright"><img class="theLogo"
                                                   style="height: 40px; width: 120px; margin-right: 8px;"
                                                   src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                                                       UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>"
                                                   alt=""></div>


                </div>

                    <div class="grid invoice page_break no-header-element pdf-height" data-page-id="cover">
                        <div class="grid-body">
                            <div class="row">

                            <div class="col-lg-10 col-md-9 ">
                            
                                <img class="mg-left--4" style="float: left;"
                                     src="<?php echo site_url('uploads/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo()); ?>"
                                     width="125px" height="auto" alt="">
                            
                            <table class="top_table"  cellspacing="6" cellpadding="0" border="0" style="float: left;">
                                    <tr class="top_hide_mobile">
                                        <td width="115" style="text-align: right; font-weight: bold; font-size: 16px; height: 20px;">
                                            Work Order:&nbsp;&nbsp;
                                        </td>
                                        <td style="font-size: 16px; height: 25px;">
                                            <?php
                                            echo $proposal->getClient()->getClientAccount()->getName(); ?> |
                                            <b>Project: </b>
                                            <?php echo ($proposal->getJobNumber() ? 'Job #: ' . $proposal->getJobNumber() . ' - ' : ''); ?>
                                            <?php echo $proposal->getProjectName();
                                            ?>
                                        </td>
                                    </tr>
                                    
                                    <tr class="top_show_mobile">
                                        <td width="115" style="text-align: right; font-size: 16px; line-height: 20px;vertical-align: baseline;"><b>Address:&nbsp;&nbsp;</b></td>
                                        <td style="font-size: 16px; line-height: 20px;">
                                       
                                        <?php

                                            echo ($proposal->getProjectAddress()) ? $proposal->getProjectAddress().', ' : '&nbsp;';
                                            if ($proposal->getProjectCity()) {
                                                echo $proposal->getProjectCity();
                                            }
                                            if ($proposal->getProjectState()) {
                                                echo ', ' . $proposal->getProjectState();
                                            }
                                            if ($proposal->getProjectZip()) {
                                                echo ' ' . $proposal->getProjectZip();
                                            }
                                            ?>
                                        </td>
                                    </tr>

                                    
                                    <tr>
                                        <td style="text-align: right; font-size: 16px; line-height: 20px;vertical-align: baseline;"><b>Contact:&nbsp;&nbsp;</b></td>
                                        <td style="font-size: 16px; line-height: 20px;">
                                            <?php
                                            echo $proposal->getClient()->getFullName();
                                            echo ($proposal->getClient()->getCellPhone()) ? ' | C: <a href="tel:'. $proposal->getClient()->getCellPhone().'">' . $proposal->getClient()->getCellPhone().'</a>' : '';
                                            echo ($proposal->getClient()->getBusinessPhone()) ? ' | O: <a href="tel:'. $proposal->getClient()->getBusinessPhone().'">' . $proposal->getClient()->getBusinessPhone().'</a>' : '';
                                            echo ($proposal->getClient()->getEmail()) ? ' | E: <a href="mailto:'. $proposal->getClient()->getEmail().'">' . $proposal->getClient()->getEmail().'</a>' : '';
                                            ?>
                                        </td>
                                    </tr>
                                   
                                </table>
                            </div>
                            <div class="col-lg-2 col-md-3  pd-t-5 header_project_name">
                                <div class="sales_person">
                                    <b><?php echo $proposal->getOwner()->getFullName() ?></b><br>
                                    <p style="margin-bottom: 5px;">Your Point Person</p>
                                    
                                    <b >O: <a href="tel:<?php echo $proposal->getOwner()->getOfficePhone() ?>"><?php echo $proposal->getOwner()->getOfficePhone() ?></a></b><br>
                                    <b>C: <a href="tel:<?php echo $proposal->getOwner()->getCellPhone() ?>"><?php echo $proposal->getOwner()->getCellPhone() ?></a></b>
                                </div>
                                
                            </div>



                                        </div>
                            <div class="invoice-title avoid-break" id="map-direction">

                                <div class="row" style="margin-top: 30px;">

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
                                        <div class="col-md-12 col-lg-6 map-direction">

                                                <h2 class="top_hide_mobile" style="margin-top: 0px;">Driving
                                                    Directions <?php echo ((@$directions['status'] == 'OK') && (is_array($directions['routes'][0]))) ? '(Total Distance: ' . @$directions['routes'][0]['legs'][0]['distance']['text'] . ')' : ''; ?></h2>
                                                <div class="text-direction-section  top_hide_mobile" style="min-height:450px;">
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
                                                </div>
                                                <a target="_blank" href="https://www.google.com/maps/dir/?api=1&destination=<?=urlencode($to);?>" class="btn btn-primary btn-lg btn-block"><i class="fa fa-fw fa-location-arrow"></i> Click to Navigate</a>
                                        </div>

                                        <div class="col-md-12 col-lg-6  map-height">
                                            <div id="map_canvas" style="width:100%; height:100%">
                                        </div>
                                </div>

                                </div>

                            </div>


                        </div>
                        <div class="row page_number">Page 1</div>

                    </div>
                    <!-- END INVOICE -->
                    <!-- BEGIN INVOICE -->



                <div class="grid invoice pdf-height page_break page_break_before" style="padding-top: 10px;"
                     data-page-id="services">
                    <div class="grid-body">
                        <div class="row">
                            <div class="row" id="project_specifications">
                                <h1 class="underlined global_header print_hide">Project Specification </h1>
                                <h1 class="underlined global_header only_show_print">
                                    Proposal:
                                    <?php echo ($proposal->getJobNumber() ? 'Job #: ' . $proposal->getJobNumber() . "<br />" : ''); ?>
                                    <?php echo $proposal->getProjectName() ?> </h1>
                                <div class="logotopright only_show_print"><img class="theLogo"
                                                                               style="height: 35px; width: 120px; margin-right: 8px;"
                                                                               src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                                                                                   UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>"
                                                                               alt=""></div>
                            </div>
                        </div>
                        <div class="row">
                            <?php if (count($work_order_videos)) {
                                ?>
                                <div id="videoURL" width="100%">
                                    <?php foreach ($work_order_videos as $video) { ?>
                                        <label><?php $video->getTitle(); ?></label>
                                        <a href="<?php echo $video->getVideoUrl() ?>" target="_blank"><img
                                                    src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . '/proposal-video.jpg')); ?>"
                                                    width="90%"></a>
                                        <p><?php echo $video->getVideoNote(); ?></p>
                                    <?php } ?>
                                </div>
                                <?php
                            }


                            $k = 0;
                            foreach ($services as $service) {

                                $k++;

                                if (!$proposal->hasSnow()) {
                                    ?>
                                    <div class="col-md-12 margin-top-bottom-10 avoid-break service-section"
                                         id="service_<?php echo $service->getServiceId() ?>"
                                         data-service-id="<?php echo $service->getServiceId() ?>">
                                        <div class="item-content<?php echo ($service->isNoPrice()) ? ' no-price' : ''; ?>">
                                            <h2 class="service_title"><?php echo $service->getServiceName() ?></h2>
                                            <div class="item-content-texts">
                                                <?php echo $services_texts[$service->getServiceId()]; ?>
                                            </div>

                                            <?php 
                                            $imagesTest = array();
                                            if(isset($service_images[$service->getServiceId()])){

                                                foreach($service_images[$service->getServiceId()] as $k => $service_image){
                                                    if ($service_image['image']->getActivewo()) {
                                                        $img = array();
                                                        $img['src'] = $service_image['websrc'];
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
                                            ?>

                                                <div class="row" style="clear: both;">
                                                <!-- <div class="col-md-6"> -->
                                                <?php
                                                $lop = 1;
                                                foreach ($imagesTest as $image) {
                                                    if (count($imagesTest) == 3) {
                                                        $col = '4';
                                                        $width = '75%';
                                                    } else if (count($imagesTest) == 1) {
                                                        $col = '12';
                                                        $width = '25%';
                                                    } else {
                                                        $col = '6';
                                                        $width = '50%';

                                                    }
                                                    ?>


                                                    <div class="col-12 col-sm-<?= $col; ?> col-md-<?= $col; ?> mg-btm-20 break-after image-section"
                                                         style="float: left;padding:5px 0px;"
                                                         data-image-id="<?php echo $image['id']; ?>">


                                                        <div class="mx-auto d-block"
                                                             style="position: relative; width:<?= $width; ?>;">
                                                            <div style="position: relative;">
                                                                <h2 class="image_title" style="font-size: 15px;margin: 10px 0px 0px 0px;"><?php echo $image['title'] ?></h2>
                                                                <?php if ($image['notes']) { ?>
                                                                    <a href="javascript:void(0)"
                                                                       data-bs-toggle="offcanvas"
                                                                       data-bs-target="#mobileImageInfo"
                                                                       aria-controls="offcanvasRight"
                                                                       class="image-section-info not_link">
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </a>

                                                                <?php } ?>

                                                                <span class="service-image-pinch-back">
                                                    <button type="button" class="btn-close text-reset btn-close-white"
                                                            data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                </span>
                                                                <img data-slide="slide-image-<?= $lop++; ?>"
                                                                     data-image-id="<?php echo $image['id']; ?>"
                                                                     data-bs-toggle="offcanvas"
                                                                     data-bs-target="#service_image_offcanvas_<?= $service->getServiceId(); ?>"
                                                                     aria-controls="offcanvasRight"
                                                                     class="img-fluid img-thumbnail img_service_mobile btn showProposalCarousel "
                                                                     style="object-fit: cover;padding-right: 0px;padding-left: 0;height:150px;width: 100%;"
                                                                     src="<?php echo $image['src']; ?>" alt="">

                                                                <?php
                                                                if ($image['notes']) {
                                                                    ?>
                                                                    <a href="javascript:void(0)"
                                                                       data-placement="top"
                                                                       data-container="body"
                                                                       data-bs-toggle="tooltip"
                                                                       title="View Notes"
                                                                       data-bs-custom-class="custom-tooltip"
                                                                       class="image-note-section-info not_link"
                                                                       style="right: 85px;bottom: 7px;"
                                                                    >
                                                                        <i class="fa fa-info-circle"></i>
                                                                    </a>
                                                                <?php } ?>

                                                                <p class="image-section-inlarge-text"
                                                                   style="pointer-events: none;right: 2px;bottom: -9px;padding-top: 1px;">
                                                                    + Enlarge</p>
                                                            </div>
                                                            <div class="image-section-notes"
                                                                 style="display: none;position: relative;padding: 5px;width: 100%;border-radius: 5px;border: 1px solid #939090;max-height: 100px;overflow-y: auto;"><?= $image['notes']; ?>
                                                                <span class="close"></span></div>
                                                        </div>
                                                    </div>
                                                <?php }

                                                ?>

                                                <!-- </div>
                                                <div class="col-md-6"></div> -->
                                            </div>

                                        </div>
                                    </div>
                                    <?php
                                } else {
                                    ?>
                                    <div class="col-md-12 margin-top-bottom-10 avoid-break service-section"
                                         id="service_<?php echo $service->getServiceId() ?>"
                                         style="page-break-inside: avoid"
                                         data-service-id="<?php echo $service->getServiceId() ?>">
                                        <div class=" item-content">
                                            <h2 class="service_title"><?php echo $service->getServiceName() ?></h2>
                                            <?php echo $services_texts[$service->getServiceId()]; ?>

                                        </div>
                                    </div>
                                    <?php
                                }
                            } ?>
                        </div>
                    </div>

                        <div class="row page_number">Page 2</div>

                </div>

                <!-- END INVOICE -->




<?php




if ($lineItemCount>0) {
   ?>
    <div class="grid invoice pdf-height page_break page_break_before" style="padding-top: 10px;" data-page-id="estimate_items">
            <div class="grid-body">
            <div class="row" id="estimate_items">
                <h1 class="underlined global_header print_hide">Estimates Items </h1>

            </div>
    <?php
    $settings = $estimationRepository->getCompanySettings($proposal->getClient()->getCompany());
    $work_order_layout_type = $proposal->getWorkOrderLayoutType();
    $templateGroup = ($proposal->getGroupTemplateItem()==1)? true : false;


   if($work_order_layout_type != 'all_items'){

    $proposalServices = $proposal->getServices();
    $items='';
    $j=0;
            foreach ($proposalServices as $service) {

                $service_id = $service->getServiceId();

                $phases = $estimationRepository->getProposalServicePhaseArray($service,$proposal->getProposalId());

                $i =0;
                $items=[];

                if($work_order_layout_type == 'service_and_phase'){
                    foreach($phases as $phase){
                        $phaseId = $phase['id'];

                        if($templateGroup){
                            $sortedItems =  $estimationRepository->getProposalServiceSortedLineItemsPhaseNonTemplate($proposal->getClient()->getCompany(),$service_id, $phaseId);
                            $templateItems = $estimationRepository->getTemplatePhaseSortedLineItems($phaseId);
                        }else{
                            $sortedItems =  $estimationRepository->getProposalServiceSortedLineItemsPhase($proposal->getClient()->getCompany(),$service_id, $phaseId);
                            $templateItems = [];
                        }
                        $items[$i]= [
                            'proposalService' => $service,
                            'phase' => $phase,
                            'subContractorItems' =>  $estimationRepository->getSubContractorPhaseSortedLineItems($phaseId),
                            'feesItems' =>  $estimationRepository->getFeesPhaseSortedLineItems($phaseId),
                            'permitItems' =>  $estimationRepository->getPermitPhaseSortedLineItems($phaseId),
                            'sortedItems' =>   $sortedItems,
                            'templateItems' => $templateItems,
                            'disposalItems' => $estimationRepository->getDisposalPhaseSortedLineItems($phaseId),
                        ];
                        $i++;
                    }

                }else{


                    if($templateGroup){

                        $sortedItems =  $estimationRepository->getProposalServiceSortedLineItemsNonTemplate($proposal->getClient()->getCompany(),$service_id);
                        $templateItems = $estimationRepository->getTemplateSortedLineItems($service_id);
                    }else{
                        $sortedItems =  $estimationRepository->getProposalServiceSortedLineItems($proposal->getClient()->getCompany(),$service_id);
                        $templateItems = [];
                    }

                    $items[$i]= [
                        'proposalService' => $service,
                        'phase' => '',
                        'subContractorItems' =>  $estimationRepository->getSubContractorPhaseSortedLineItems($service_id),
                        'feesItems' =>  $estimationRepository->getFeesServiceSortedLineItems($service_id),
                        'permitItems' =>  $estimationRepository->getPermitServiceSortedLineItems($service_id),
                        'sortedItems' =>   $sortedItems,
                        'templateItems' => $templateItems,
                        'disposalItems' => $estimationRepository->getDisposalServiceSortedLineItems($service_id),
                    ];

                }
            // echo '<pre>';
            // print_r($items);
            //}



            foreach ($items as $item) :
                //print_r($item['sortedItems']);
                $sortedItems =  $item['sortedItems'];
                $subContractorItems =  $item['subContractorItems'];
                $templateItems =  $item['templateItems'];
                $feesItems =  $item['feesItems'];
                $permitItems =  $item['permitItems'];
                $disposalItems =  $item['disposalItems'];
            if(count($sortedItems)>0 || count($subContractorItems)>0 || count($templateItems)>0){


            ?>


        <div class="clearfix relative <?= $j;?>" <?php if($j!=0){echo 'style="page-break-before:always"'; }
        $j++;
        ?> >

            <p style="margin:0px;font-size:16px;font-weight:bold"><?php echo $service->getServiceName(); if($work_order_layout_type == 'service_and_phase'){echo ' | '. $item['phase']['name'];}?> </p>
        <hr style="color:#2c2c2c;border-top:1px;margin-top:4px;margin-bottom:0px;"/>

            <?php


            foreach ($sortedItems as $sortedItem) : ?>
                <?php $rowTotal = 0; ?>
            <div class="row">

                <div class="col s12" style="page-break-inside:avoid">
                <h4 style="margin-bottom:2px;margin-top:6px;"><?php echo $sortedItem['category']->getName(); ?></h4>
                <table id="estimateSummaryItems" class="table table-striped table-bordered" style="width: 100%;">
                    <thead>
                    <tr>
                        <!-- <th width="30%">Type</th>
                        <th width="50%">Item</th>
                        <th width="20%">Quantity</th> -->
                        <th width="2%" ></th>
                        <th width="20%" >Type</th>
                            <th width="30%">Item</th>
                            <?php if($sortedItem['category']->getId() !=1){ ?>
                                <th width="5%">Days</th>
                                <th width="5%">#</th>

                                <th width="5%">Hrs/Day</th>
                            <?php } else{ ?>
                                <th width="12%">Area</th>
                                <th width="7%">Depth</th>
                                <th width="1%"></th>
                            <?php } ?>
                            <th width="10%" style="text-align:right;">Quantity</th>
                            <th width="7%" ></th>
                        <!-- <th>Total Price</th> -->
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($sortedItem['items'] as $lineItem) : ?>
                        <?php /* @var \models\EstimationLineItem $lineItem */

                        $line_item_notes  = $estimationRepository->getEstimateLineItemNotes($lineItem->getId())
                        ?>
                        <tr>
                        <td><div class="checkbox_div"></div></td>
                        <td><?php
                                $saved_values = $lineItem->saved_values;
                                $check_type = $lineItem->item_type_time;
                                echo $lineItem->getItemType()->getName();
                                $notes1 ='';

                                if(count($line_item_notes)>0){
                                    foreach($line_item_notes as $line_item_note){
                                        if($line_item_note->getWorkOrder()==1){
                                            $notes1.= '<br/><strong>'. date('m/d/Y', $line_item_note->getAdded()).' '.date('g:i a', $line_item_note->getAdded()).'</strong>';

                                        }
                                    }
                                }
                                if($lineItem->getNotes() != '' || $notes1 != ''){
                                    echo '<br/><strong>Note: </strong>';
                                    echo $notes1;
                                }

                                ?></td>
                            <td>
                            <?php
                                if ($sortedItem['category']->getId() == \models\EstimationCategory::CUSTOM || $lineItem->getItemId() == '71') {
                                    echo $lineItem->getCustomName();
                                } else {
                                    echo $lineItem->getItem()->getName();
                                }

                                if($lineItem->item_type_trucking ==1){
                                    echo $lineItem->plant_dump_address;
                                }
                                $notes1 ='';

                                if(count($line_item_notes)>0){
                                    foreach($line_item_notes as $line_item_note){
                                        if($line_item_note->getWorkOrder()==1){
                                            $notes1.=  '<br/>'. $line_item_note->getNoteText();
                                        }
                                    }
                                }
                                if($lineItem->getNotes() != '' || $notes1 != ''){
                                    echo '<br/>'.$lineItem->getNotes();
                                    echo $notes1;
                                }
                            ?>
                            </td>
                            <?php
                                    if($sortedItem['category']->getId() != \models\EstimationCategory::MATERIAL){
                                        if($check_type){

                                            echo '<td>'.$lineItem->getDay().'</td><td>'.$lineItem->getNumPeople().'</td><td>'.floatval($lineItem->getHoursPerDay()).'</td>';
                                        }else{
                                            echo '<td></td><td></td><td></td>';
                                        }

                                    }else {
                                        if ($saved_values) {
                                            $saved_values = json_decode($saved_values);
                                            $measurement = '';
                                            $unit = '';
                                            $depth = '';
                                            for ($i = 0; $i < count($saved_values); $i++) {
                                                if ($saved_values[$i]->name == 'measurement' || $saved_values[$i]->name == 'sealcoatArea') {
                                                    $measurement=$saved_values[$i]->value;
                                                }else if ($saved_values[$i]->name == 'measurement_unit' || $saved_values[$i]->name == 'sealcoatUnit') {
                                                    if($saved_values[$i]->value=='Square Yards'){
                                                        $unit = 'Sq. Yd';
                                                    }else{
                                                        $unit = 'Sq. Ft';
                                                    }
                                                }else if ($saved_values[$i]->name == 'depth' ) {
                                                    $depth = $saved_values[$i]->value.' Inch';
                                                }
                                            }
                                            echo '<td>'.$measurement.' '.$unit.'</td><td>'.$depth.'</td><td></td>';
                                        } else {
                                            $saved_values = [];
                                            echo '<td></td><td></td><td></td>';
                                        }
                                    }
                                    ?>
                            <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                    <?php echo $lineItem->getItem()->getUnitModel()->getAbbr(); ?></span>
                                </td>

                            <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->
                            <td style="padding-top: 2px;"><div class="input_div"></div></td>
                        </tr>
                        <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice();

                        ?>
                    <?php endforeach; ?>
                    </tbody>

                </table>
                <div class="divider"></div>
                </div>

            </div>
            <?php endforeach;

        foreach ($templateItems as $key=>$templateSortedItem) : ?>
            <?php $rowTotal = 0; ?>
        <div class="row">

            <div class="col s12" style="page-break-inside:avoid">
            <h4 style="margin-bottom:2px;margin-top:6px;">Assembly - <?=$templateSortedItem['template_name'];?></h4>
            <table id="estimateSummaryItems" class="table table-striped table-bordered" style="width: 100%;">
                <thead>
                <tr>
                    <!-- <th width="30%">Type</th>
                    <th width="50%">Item</th>
                    <th width="20%">Quantity</th> -->
                    <th width="2%" ></th>
                    <th width="10%" >Category</th>
                    <th width="20%" >Type</th>
                        <th width="20%">Item</th>

                            <th width="5%">Days</th>
                            <th width="5%">#</th>

                            <th width="5%">Hrs/Day</th>

                        <th width="10%" style="text-align:right;">Quantity</th>
                        <th width="7%" ></th>
                    <!-- <th>Total Price</th> -->
                </tr>
                </thead>
                <tbody>
                <?php foreach ($templateSortedItem['items'] as $lineItem) : ?>
                    <?php /* @var \models\EstimationLineItem $lineItem */
                    $line_item_notes  = $estimationRepository->getEstimateLineItemNotes($lineItem->getId())
                    ?>
                    <tr>
                    <td><div class="checkbox_div"></div></td>
                    <td><?php echo $lineItem->getItemTypeCategory()->getName()?></td>
                    <td><?php

                            echo $lineItem->getItemType()->getName();
                            $notes1 ='';

                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        $notes1.= '<br/><strong>'. date('m/d/Y', $line_item_note->getAdded()).' '.date('g:i a', $line_item_note->getAdded()).'</strong>';

                                    }
                                }
                            }
                            if($lineItem->getNotes() != '' || $notes1 != ''){
                                echo '<br/><strong>Note: </strong>';
                                echo $notes1;
                            }

                            ?></td>
                        <td>
                        <?php

                                echo $lineItem->getItem()->getName();



                            $notes1 ='';

                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        $notes1.=  '<br/>'. $line_item_note->getNoteText();
                                    }
                                }
                            }
                            if($lineItem->getNotes() != '' || $notes1 != ''){
                                echo '<br/>'.$lineItem->getNotes();
                                echo $notes1;
                            }
                        ?>
                        </td>
                        <?php



                                        echo '<td>'.$lineItem->getDay().'</td><td>'.$lineItem->getNumPeople().'</td><td>'.floatval($lineItem->getHoursPerDay()).'</td>';


                                ?>
                        <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                <?php echo $lineItem->getItem()->getUnitModel()->getAbbr(); ?></span>
                            </td>

                        <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->
                        <td style="padding-top: 2px;"><div class="input_div"></div></td>
                    </tr>
                    <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                <?php endforeach; ?>
                </tbody>

            </table>
            <div class="divider"></div>
            </div>

        </div>
        <?php endforeach;

            foreach ($subContractorItems as $subContractorItem) : ?>
                <?php $rowTotal = 0; ?>
            <div class="row">

                <div class="col s12" style="page-break-inside:avoid">
                <h4 style="margin-bottom:2px;margin-top:6px;">Sub Contractors</h4>
                <table id="estimateSummaryItems" class="table table-striped table-bordered" style="width: 100%;">
                    <thead>
                    <tr>
                        <!-- <th width="30%">Type</th>
                        <th width="50%">Item</th>
                        <th width="20%">Quantity</th> -->

                        <th width="35%">Item</th>
                        <th width="15%" style="text-align:right;">Quantity</th>

                        <!-- <th>Total Price</th> -->
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($subContractorItem['items'] as $lineItem) : ?>
                        <?php /* @var \models\EstimationLineItem $lineItem */ ?>
                        <tr>

                            <td>
                            <?php
                            if($lineItem->getIsCustomSub()==1){
                                echo $lineItem->getCustomName();
                            }else{
                                echo $lineItem->getSubContractor()->getCompanyName();
                            }

                            ?>
                            </td>

                            <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                    QTY
                                </span>
                            </td>

                            <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->

                        </tr>
                        <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                    <?php endforeach; ?>
                    </tbody>

                </table>
                <div class="divider"></div>
                </div>

            </div>
            <?php endforeach;

            foreach ($feesItems as $feesItem) : ?>
            <?php $rowTotal = 0; ?>
        <div class="row">

            <div class="col s12" style="page-break-inside:avoid">
            <h4 style="margin-bottom:2px;margin-top:6px;">Fees</h4>
            <table id="estimateSummaryItems" class="table table-striped table-bordered" style="width: 100%;">
                <thead>
                <tr>
                    <!-- <th width="30%">Type</th>
                    <th width="50%">Item</th>
                    <th width="20%">Quantity</th> -->
                    <th width="20%" >Type</th>
                        <th width="35%">Item</th>

                            <th width="5%"></th>
                            <th width="5%"></th>
                            <th width="5%"></th>

                        <th width="15%" style="text-align:right;">Quantity</th>

                    <!-- <th>Total Price</th> -->
                </tr>
                </thead>
                <tbody>
                <?php foreach ($feesItem['items'] as $lineItem) : ?>
                    <?php /* @var \models\EstimationLineItem $lineItem */
                    $line_item_notes  = $estimationRepository->getEstimateLineItemNotes($lineItem->getId())
                    ?>
                    <tr>
                    <td><?php

                            echo 'Fees';
                            if($lineItem->getNotes() != '' && $lineItem->getWorkOrder() == 1){
                                echo '<br/><strong>Note: </strong>';
                            }
                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        echo '<br/><strong>'. date('m/d/Y', $line_item_note->getAdded()).' '.date('g:i a', $line_item_note->getAdded()).'</strong>';
                                    }
                                }

                            }

                            ?></td>
                        <td>
                        <?php

                                echo $lineItem->getCustomName();

                            if($lineItem->getNotes() != '' && $lineItem->getWorkOrder() == 1){
                                echo '<br/>'.$lineItem->getNotes();
                            }
                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        echo '<br/>'. $line_item_note->getNoteText();
                                    }
                                }
                            }
                        ?>
                        </td>
                        <?php

                                    echo '<td></td><td></td><td></td>';

                                ?>
                        <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                            </span>
                        </td>

                        <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->

                    </tr>
                    <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                <?php endforeach; ?>
                </tbody>

            </table>
            <div class="divider"></div>
            </div>

        </div>
        <?php endforeach;
        foreach ($permitItems as $permitItem) : ?>
            <?php $rowTotal = 0; ?>
        <div class="row">

            <div class="col s12" style="page-break-inside:avoid">
            <h4 style="margin-bottom:2px;margin-top:6px;">Permit</h4>
            <table id="estimateSummaryItems" class="table table-striped table-bordered" style="width: 100%;">
                <thead>
                <tr>
                    <!-- <th width="30%">Type</th>
                    <th width="50%">Item</th>
                    <th width="20%">Quantity</th> -->
                    <th width="20%" >Type</th>
                        <th width="35%">Item</th>

                            <th width="5%"></th>
                            <th width="5%"></th>
                            <th width="5%"></th>

                        <th width="15%" style="text-align:right;">Quantity</th>

                    <!-- <th>Total Price</th> -->
                </tr>
                </thead>
                <tbody>
                <?php foreach ($permitItem['items'] as $lineItem) : ?>
                    <?php /* @var \models\EstimationLineItem $lineItem */
                    $line_item_notes  = $estimationRepository->getEstimateLineItemNotes($lineItem->getId())
                    ?>
                    <tr>
                    <td><?php

                            echo 'Permit';
                            if($lineItem->getNotes() != '' && $lineItem->getWorkOrder() == 1){
                                echo '<br/><strong>Note: </strong>';
                            }
                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        echo '<br/><strong>'. date('m/d/Y', $line_item_note->getAdded()).' '.date('g:i a', $line_item_note->getAdded()).'</strong>';
                                    }
                                }

                            }

                            ?></td>
                        <td>
                        <?php

                                echo $lineItem->getCustomName();

                            if($lineItem->getNotes() != '' && $lineItem->getWorkOrder() == 1){
                                echo '<br/>'.$lineItem->getNotes();
                            }
                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        echo '<br/>'. $line_item_note->getNoteText();
                                    }
                                }
                            }
                        ?>
                        </td>
                        <?php

                                    echo '<td></td><td></td><td></td>';

                                ?>
                        <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                            </span>
                            </td>

                        <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->

                    </tr>
                    <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                <?php endforeach; ?>
                </tbody>

            </table>
            <div class="divider"></div>
            </div>

        </div>
        <?php endforeach;
                foreach ($disposalItems as $disposalItem) : ?>
                    <?php $rowTotal = 0; ?>
                <div class="row">

                    <div class="col s12" style="page-break-inside:avoid">
                    <h4 style="margin-bottom:2px;margin-top:6px;">Disposal Load</h4>
                    <table id="estimateSummaryItems" class="table table-striped table-bordered" style="width: 100%;">
                        <thead>
                        <tr>
                            <!-- <th width="30%">Type</th>
                            <th width="50%">Item</th>
                            <th width="20%">Quantity</th> -->
                            <th width="20%" >Type</th>
                                <th width="35%">Item</th>

                                    <th width="5%"></th>
                                    <th width="5%"></th>
                                    <th width="10%" style="text-align:right;">Quantity</th>

                                <th width="7%" ></th>

                            <!-- <th>Total Price</th> -->
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($disposalItem['items'] as $disposallineItem) : ?>

                            <tr>
                            <td>Disposal</td>
                                <td>
                                <?php echo $disposallineItem->getItem()->getName();?>
                                </td>
                                <?php

                                            echo '<td></td><td></td>';

                                        ?>
                                <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($disposallineItem->getDisposalLoads()); ?>
                                    </span>
                                    </td>
                                    <td style="padding-top: 2px;"><div class="input_div"></div></td>
                                <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->

                            </tr>

                        <?php endforeach; ?>
                        </tbody>

                    </table>
                    <div class="divider"></div>
                    </div>

                </div>
                <?php endforeach;?>
        </div>
        <?php

                        }
        endforeach;
        }
    }else{

        $i =0;
        $j =0;
        $items=[];
        //$templateGroup =false;
        if($templateGroup){
            $sortedItems =  $estimationRepository->getProposalSortedLineItemsNonTemplate($proposal->getClient()->getCompany(),$proposal->getProposalId());
            $templateItems = $estimationRepository->getProposalTemplateSortedLineItems($proposal->getProposalId());
        }else{
            $sortedItems =  $estimationRepository->getProposalSortedLineItemsTotal($proposal->getClient()->getCompany(), $proposal->getProposalId());
            $templateItems = [];
        }
        $subContractorItems = $estimationRepository->getSubContractorProposalSortedLineItems($proposal->getProposalId());
        $feesItems = $estimationRepository->getFeesProposalSortedLineItems($proposal->getProposalId());
        $permitItems =  $estimationRepository->getPermitProposalSortedLineItems($proposal->getProposalId());
        $disposalItems =  $estimationRepository->getDisposalProposalSortedLineItems($proposal->getProposalId());;


        if(count($sortedItems)>0 || count($subContractorItems)>0 || count($templateItems)>0){


            ?>


        <div class="clearfix relative <?= $j;?>" <?php if($j!=0){echo 'style="page-break-before:always"'; }
        $j++;
        ?> >
        <hr style="color:#2c2c2c;border-top:1px;margin-top:4px;margin-bottom:0px;"/>

            <?php


            foreach ($sortedItems as $sortedItem) : ?>
                <?php $rowTotal = 0; ?>
            <div class="row">

                <div class="col s12" style="page-break-inside:avoid">
                <h4 style="margin-bottom:2px;margin-top:6px;"><?php echo $sortedItem['category']->getName(); ?></h4>
                <table id="estimateSummaryItems" class="table table-striped table-bordered" style="width: 100%;">
                    <thead>
                    <tr>
                        <!-- <th width="30%">Type</th>
                        <th width="50%">Item</th>
                        <th width="20%">Quantity</th> -->
                        <th width="2%" ></th>
                        <th width="20%" >Type</th>
                            <th width="30%">Item</th>
                            <?php if($sortedItem['category']->getId() !=1){ ?>
                                <th width="5%">Days</th>
                                <th width="5%">#</th>

                                <th width="5%">Hrs/Day</th>
                            <?php } else{ ?>
                                <th width="12%">Area</th>
                                <th width="7%">Depth</th>
                                <th width="1%"></th>
                            <?php } ?>
                            <th width="10%" style="text-align:right;">Quantity</th>
                            <th width="7%" ></th>
                        <!-- <th>Total Price</th> -->
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($sortedItem['items'] as $lineItem) : ?>
                        <?php /* @var \models\EstimationLineItem $lineItem */

                        $line_item_notes  = $estimationRepository->getEstimateLineItemNotes($lineItem->getId())
                        ?>
                        <tr>
                        <td><div class="checkbox_div"></div></td>
                        <td><?php
                                $saved_values = $lineItem->saved_values;
                                $check_type = $lineItem->item_type_time;
                                echo $lineItem->getItemType()->getName();
                                $notes1 ='';

                                if(count($line_item_notes)>0){
                                    foreach($line_item_notes as $line_item_note){
                                        if($line_item_note->getWorkOrder()==1){
                                            $notes1.= '<br/><strong>'. date('m/d/Y', $line_item_note->getAdded()).' '.date('g:i a', $line_item_note->getAdded()).'</strong>';

                                        }
                                    }
                                }
                                if($lineItem->getNotes() != '' || $notes1 != ''){
                                    echo '<br/><strong>Note: </strong>';
                                    echo $notes1;
                                }

                                ?></td>
                            <td>
                            <?php
                                if ($sortedItem['category']->getId() == \models\EstimationCategory::CUSTOM || $lineItem->getItemId() == '71') {
                                    echo $lineItem->getCustomName();
                                } else {
                                    echo $lineItem->getItem()->getName();
                                }

                                if($lineItem->item_type_trucking ==1){
                                    echo $lineItem->plant_dump_address;
                                }
                                $notes1 ='';

                                if(count($line_item_notes)>0){
                                    foreach($line_item_notes as $line_item_note){
                                        if($line_item_note->getWorkOrder()==1){
                                            $notes1.=  '<br/>'. $line_item_note->getNoteText();
                                        }
                                    }
                                }
                                if($lineItem->getNotes() != '' || $notes1 != ''){
                                    echo '<br/>'.$lineItem->getNotes();
                                    echo $notes1;
                                }
                            ?>
                            </td>
                            <?php
                                    if($sortedItem['category']->getId() != \models\EstimationCategory::MATERIAL){
                                        if($check_type){

                                            echo '<td>'.$lineItem->getDay().'</td><td>'.$lineItem->getNumPeople().'</td><td>'.floatval($lineItem->getHoursPerDay()).'</td>';
                                        }else{
                                            echo '<td></td><td></td><td></td>';
                                        }

                                    }else {
                                        if ($saved_values) {
                                            $saved_values = json_decode($saved_values);
                                            $measurement = '';
                                            $unit = '';
                                            $depth = '';
                                            for ($i = 0; $i < count($saved_values); $i++) {
                                                if ($saved_values[$i]->name == 'measurement' || $saved_values[$i]->name == 'sealcoatArea') {
                                                    $measurement=$saved_values[$i]->value;
                                                }else if ($saved_values[$i]->name == 'measurement_unit' || $saved_values[$i]->name == 'sealcoatUnit') {
                                                    if($saved_values[$i]->value=='Square Yards'){
                                                        $unit = 'Sq. Yd';
                                                    }else{
                                                        $unit = 'Sq. Ft';
                                                    }
                                                }else if ($saved_values[$i]->name == 'depth' ) {
                                                    $depth = $saved_values[$i]->value.' Inch';
                                                }
                                            }
                                            echo '<td>'.$measurement.' '.$unit.'</td><td>'.$depth.'</td><td></td>';
                                        } else {
                                            $saved_values = [];
                                            echo '<td></td><td></td><td></td>';
                                        }
                                    }
                                    ?>
                            <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                    <?php echo $lineItem->getItem()->getUnitModel()->getAbbr(); ?></span>
                                </td>

                            <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->
                            <td style="padding-top: 2px;"><div class="input_div"></div></td>
                        </tr>
                        <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice();

                        ?>
                    <?php endforeach; ?>
                    </tbody>

                </table>
                <div class="divider"></div>
                </div>

            </div>
            <?php endforeach;

        foreach ($templateItems as $key=>$templateSortedItem) : ?>
            <?php $rowTotal = 0; ?>
        <div class="row">

            <div class="col s12" style="page-break-inside:avoid">
            <h4 style="margin-bottom:2px;margin-top:6px;">Assembly - <?=$templateSortedItem['template_name'];?></h4>
            <table id="estimateSummaryItems" class="table table-striped table-bordered" style="width: 100%;">
                <thead>
                <tr>
                    <!-- <th width="30%">Type</th>
                    <th width="50%">Item</th>
                    <th width="20%">Quantity</th> -->
                    <th width="2%" ></th>
                    <th width="10%" >Category</th>
                    <th width="20%" >Type</th>
                        <th width="20%">Item</th>

                            <th width="5%">Days</th>
                            <th width="5%">#</th>

                            <th width="5%">Hrs/Day</th>

                        <th width="10%" style="text-align:right;">Quantity</th>
                        <th width="7%" ></th>
                    <!-- <th>Total Price</th> -->
                </tr>
                </thead>
                <tbody>
                <?php foreach ($templateSortedItem['items'] as $lineItem) : ?>
                    <?php /* @var \models\EstimationLineItem $lineItem */
                    $line_item_notes  = $estimationRepository->getEstimateLineItemNotes($lineItem->getId())
                    ?>
                    <tr>
                    <td><div class="checkbox_div"></div></td>
                    <td><?php echo $lineItem->getItemTypeCategory()->getName()?></td>
                    <td><?php

                            echo $lineItem->getItemType()->getName();
                            $notes1 ='';

                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        $notes1.= '<br/><strong>'. date('m/d/Y', $line_item_note->getAdded()).' '.date('g:i a', $line_item_note->getAdded()).'</strong>';

                                    }
                                }
                            }
                            if($lineItem->getNotes() != '' || $notes1 != ''){
                                echo '<br/><strong>Note: </strong>';
                                echo $notes1;
                            }

                            ?></td>
                        <td>
                        <?php

                                echo $lineItem->getItem()->getName();



                            $notes1 ='';

                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        $notes1.=  '<br/>'. $line_item_note->getNoteText();
                                    }
                                }
                            }
                            if($lineItem->getNotes() != '' || $notes1 != ''){
                                echo '<br/>'.$lineItem->getNotes();
                                echo $notes1;
                            }
                        ?>
                        </td>
                        <?php



                                        echo '<td>'.$lineItem->getDay().'</td><td>'.$lineItem->getNumPeople().'</td><td>'.floatval($lineItem->getHoursPerDay()).'</td>';


                                ?>
                        <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                <?php echo $lineItem->getItem()->getUnitModel()->getAbbr(); ?></span>
                            </td>

                        <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->
                        <td style="padding-top: 2px;"><div class="input_div"></div></td>
                    </tr>
                    <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                <?php endforeach; ?>
                </tbody>

            </table>
            <div class="divider"></div>
            </div>

        </div>
        <?php endforeach;

            foreach ($subContractorItems as $subContractorItem) : ?>
                <?php $rowTotal = 0; ?>
            <div class="row">

                <div class="col s12" style="page-break-inside:avoid">
                <h4 style="margin-bottom:2px;margin-top:6px;">Sub Contractors</h4>
                <table id="estimateSummaryItems" class="table table-striped table-bordered" style="width: 100%;">
                    <thead>
                    <tr>
                        <!-- <th width="30%">Type</th>
                        <th width="50%">Item</th>
                        <th width="20%">Quantity</th> -->

                        <th width="35%">Item</th>
                        <th width="15%" style="text-align:right;">Quantity</th>

                        <!-- <th>Total Price</th> -->
                    </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($subContractorItem['items'] as $lineItem) : ?>
                        <?php /* @var \models\EstimationLineItem $lineItem */ ?>
                        <tr>

                            <td>
                            <?php
                                echo $lineItem->getSubContractor()->getCompanyName();
                            ?>
                            </td>

                            <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                                    QTY
                                </span>
                            </td>

                            <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->

                        </tr>
                        <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                    <?php endforeach; ?>
                    </tbody>

                </table>
                <div class="divider"></div>
                </div>

            </div>
            <?php endforeach;

            foreach ($feesItems as $feesItem) : ?>
            <?php $rowTotal = 0; ?>
        <div class="row">

            <div class="col s12" style="page-break-inside:avoid">
            <h4 style="margin-bottom:2px;margin-top:6px;">Fees</h4>
            <table id="estimateSummaryItems" class="table table-striped table-bordered" style="width: 100%;">
                <thead>
                <tr>
                    <!-- <th width="30%">Type</th>
                    <th width="50%">Item</th>
                    <th width="20%">Quantity</th> -->
                    <th width="20%" >Type</th>
                        <th width="35%">Item</th>

                            <th width="5%"></th>
                            <th width="5%"></th>
                            <th width="5%"></th>

                        <th width="15%" style="text-align:right;">Quantity</th>

                    <!-- <th>Total Price</th> -->
                </tr>
                </thead>
                <tbody>
                <?php foreach ($feesItem['items'] as $lineItem) : ?>
                    <?php /* @var \models\EstimationLineItem $lineItem */
                    $line_item_notes  = $estimationRepository->getEstimateLineItemNotes($lineItem->getId())
                    ?>
                    <tr>
                    <td><?php

                            echo 'Fees';
                            if($lineItem->getNotes() != '' && $lineItem->getWorkOrder() == 1){
                                echo '<br/><strong>Note: </strong>';
                            }
                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        echo '<br/><strong>'. date('m/d/Y', $line_item_note->getAdded()).' '.date('g:i a', $line_item_note->getAdded()).'</strong>';
                                    }
                                }

                            }

                            ?></td>
                        <td>
                        <?php

                                echo $lineItem->getCustomName();

                            if($lineItem->getNotes() != '' && $lineItem->getWorkOrder() == 1){
                                echo '<br/>'.$lineItem->getNotes();
                            }
                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        echo '<br/>'. $line_item_note->getNoteText();
                                    }
                                }
                            }
                        ?>
                        </td>
                        <?php

                                    echo '<td></td><td></td><td></td>';

                                ?>
                        <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                            </span>
                        </td>

                        <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->

                    </tr>
                    <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                <?php endforeach; ?>
                </tbody>

            </table>
            <div class="divider"></div>
            </div>

        </div>
        <?php endforeach;
        foreach ($permitItems as $permitItem) : ?>
            <?php $rowTotal = 0; ?>
        <div class="row">

            <div class="col s12" style="page-break-inside:avoid">
            <h4 style="margin-bottom:2px;margin-top:6px;">Permit</h4>
            <table id="estimateSummaryItems" class="table table-striped table-bordered" style="width: 100%;">
                <thead>
                <tr>
                    <!-- <th width="30%">Type</th>
                    <th width="50%">Item</th>
                    <th width="20%">Quantity</th> -->
                    <th width="20%" >Type</th>
                        <th width="35%">Item</th>

                            <th width="5%"></th>
                            <th width="5%"></th>
                            <th width="5%"></th>

                        <th width="15%" style="text-align:right;">Quantity</th>

                    <!-- <th>Total Price</th> -->
                </tr>
                </thead>
                <tbody>
                <?php foreach ($permitItem['items'] as $lineItem) : ?>
                    <?php /* @var \models\EstimationLineItem $lineItem */
                    $line_item_notes  = $estimationRepository->getEstimateLineItemNotes($lineItem->getId())
                    ?>
                    <tr>
                    <td><?php

                            echo 'Permit';
                            if($lineItem->getNotes() != '' && $lineItem->getWorkOrder() == 1){
                                echo '<br/><strong>Note: </strong>';
                            }
                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        echo '<br/><strong>'. date('m/d/Y', $line_item_note->getAdded()).' '.date('g:i a', $line_item_note->getAdded()).'</strong>';
                                    }
                                }

                            }

                            ?></td>
                        <td>
                        <?php

                                echo $lineItem->getCustomName();

                            if($lineItem->getNotes() != '' && $lineItem->getWorkOrder() == 1){
                                echo '<br/>'.$lineItem->getNotes();
                            }
                            if(count($line_item_notes)>0){
                                foreach($line_item_notes as $line_item_note){
                                    if($line_item_note->getWorkOrder()==1){
                                        echo '<br/>'. $line_item_note->getNoteText();
                                    }
                                }
                            }
                        ?>
                        </td>
                        <?php

                                    echo '<td></td><td></td><td></td>';

                                ?>
                        <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getQuantity()); ?>
                            </span>
                            </td>

                        <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->

                    </tr>
                    <?php $rowTotal = $rowTotal + $lineItem->getTotalPrice(); ?>
                <?php endforeach; ?>
                </tbody>

            </table>
            <div class="divider"></div>
            </div>

        </div>
        <?php endforeach;
                foreach ($disposalItems as $disposalItem) : ?>
                    <?php $rowTotal = 0; ?>
                <div class="row">

                    <div class="col s12" style="page-break-inside:avoid">
                    <h4 style="margin-bottom:2px;margin-top:6px;">Disposal Load</h4>
                    <table id="estimateSummaryItems" class="table table-striped table-bordered" style="width: 100%;">
                        <thead>
                        <tr>
                            <!-- <th width="30%">Type</th>
                            <th width="50%">Item</th>
                            <th width="20%">Quantity</th> -->
                            <th width="20%" >Type</th>
                                <th width="35%">Item</th>

                                    <th width="5%"></th>
                                    <th width="5%"></th>
                                    <th width="10%" style="text-align:right;">Quantity</th>

                                <th width="7%" ></th>

                            <!-- <th>Total Price</th> -->
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($disposalItem['items'] as $disposalLineItem) : ?>

                            <tr>
                            <td>Disposal</td>
                            <td><?php echo $disposalLineItem->getItem()->getName();?>
                                </td>
                                <?php

                                            echo '<td></td><td></td>';

                                        ?>
                                <td style="text-align:right;vertical-align: top;"><span style=""><?php echo trimmedQuantity($lineItem->getDisposalLoads()); ?>
                                    </span>
                                    </td>
                                <td style="padding-top: 2px;"><div class="input_div"></div></td>
                                <!-- <td>$<?php //echo number_format($lineItem->getTotalPrice(), 2, '.', ',' ) ?></td> -->

                            </tr>

                        <?php endforeach; ?>
                        </tbody>

                    </table>
                    <div class="divider"></div>
                    </div>

                </div>
                <?php endforeach;?>
        </div>
        <?php

        }

    }

$subContractors = $estimationRepository->getEstimateProposalSubContractors($proposal->getProposalId());
if (count($subContractors)) {?>
 <div style="page-break-after: always"></div>
 <div class="header-hider"></div>
    <!--Hide Header code end-->
    <h2 class="underlined header_fix" style="z-index: 200; margin-bottom: 20px">Sub Contractor Details</h2>
<?php
    foreach($subContractors as $subContractor){?>
        <h3> <?=$subContractor->getCompanyName();?> </h3>
        <table>
            <tr><th style="text-align:right;">Address:<th><td><?=$subContractor->getAddress().' '.$subContractor->getCity().' '.$subContractor->getState().' '.$subContractor->getZip();?></td></tr>
            <tr><th style="text-align:right;">Website:<th><td><?=$subContractor->getWebsite();?> </td></tr>
            <tr><th style="text-align:right;">Phone:<th><td><?=$subContractor->getPhone();?></td></tr>
        </table>
        <!-- <p style="padding:2px; margin:2px;"><strong>Address: </strong><?=$subContractor->getAddress().' '.$subContractor->getCity().' '.$subContractor->getState().' '.$subContractor->getZip();?> </p>

        <p style="padding:2px; margin:2px;"><strong>Website: </strong><?=$subContractor->getWebsite();?> </p>
        <p style="padding:2px; margin:2px;"><strong>Phone: </strong><?=$subContractor->getPhone();?> </p> -->

    <?php }

}
// Estimate Notes
$estimateNotes = $estimationRepository->getEstimateNotes($proposal->getProposalId());
if (count($estimateNotes)) {
    ?>
    <div style="page-break-after: always"></div>
    <!--Hide Header code start-->

    <div class="header-hider"></div>
    <!--Hide Header code end-->
    <h2 class="underlined header_fix" style="z-index: 200; margin-bottom: 20px">Estimate Notes</h2>

    <table width="100%" style="border-collapse: collapse;"">
        <thead style="border-bottom: 1px solid #000; ">
            <tr style="padding: 3px;">
                <th width="10%" style="text-align: left;">Date</th>
                <th width="10%" style="text-align: left;">Time</th>
                <th width="60%" style="text-align: left;">Note</th>
                <th width="20%" style="text-align: left;">User</th>
            </tr>
        </thead>
        <tbody>
<?php
        $row = 1;
        foreach ($estimateNotes as $estimateNote) {

            if($row&1) {
                $rowClass = 'even';
            } else {
                $rowClass = 'odd';
            }

?>
            <tr class="<?php echo $rowClass; ?>">
                <td style="padding: 5px;"><?php echo date('m/d/Y', $estimateNote->getAdded()); ?></td>
                <td style="padding: 5px;"><?php echo date('g:i a', $estimateNote->getAdded()); ?></td>
                <td style="padding: 5px;"><?php echo $estimateNote->getNoteText(); ?></td>
                <td style="padding: 5px;"><?php echo $estimateNote->getUsername(); ?></td>
            </tr>
<?php
            $row++;
        }
?>
        </tbody>
    </table>

<?php
}

?>
</div>
    </div>
    <?php
}



                $page = 3;

                $images2 = array();
                if (count($images)) {
                    foreach ($images as $k => $image) {
                        if ($images[$k]['image']->getActivewo()) {
                            $img = array();
                            $img['src'] = $images[$k]['websrc'];
                            $img['id'] = $images[$k]['id'];
                            $img['path'] = $images[$k]['path'];
                            $img['work_order'] = $images[$k]['image']->getActivewo();
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
                    $j = 0;


                    ?>
                    <!-- BEGIN INVOICE -->
                    <div id="images">

                        <?php


                        foreach ($images2 as $image) {
                            if($image['work_order']){
                            $image['image_layout'] = 2;
                            $j++;

                            switch ($image['image_layout']) {
                                case 1:


                                    if ($tableOpen) {
                                        if ($old_layout == 2) {
                                            if ($imageCount == 1) {
                                                echo '</div>';
                                            }
                                            if ($imageCount % 2 == 0) {
                                                echo '</div>';
                                            } else {
                                                echo '</div></div>';
                                            }
                                            //    //close tr's if necessary...

                                            echo '</div><div class="row page_number">Page ' . $page++ . '</div></div>';

                                            //close table

                                            $tableOpen = 0;
                                        }
                                    }
                                    //open table
                                    if ($old_layout != 1) {
                                        $imageCount = 0;
                                    }

                                    if (!($imageCount % 2)) {
                                        ?>
                                        <div class="grid invoice pdf-height page_break 1con" data-page-id="images" style="padding-top: 10px;" <?php //if($j==1){echo ' id="images"';}?> >
                                        <div class="grid-body">
                                        <?php if ($j == 1) { ?>
                                            <div class="row ">
                                                <div class="row">
                                                    <h1 class="underlined global_header print_hide ft-s-22">Proposal
                                                        Images</h1>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <div class="row">

                                        <div class="" id="gallery" data-toggle="modal" data-target="#exampleModal">
                                        <?php $tableOpen = 1;
                                    }
                                    //display image
                                    ?>

                                    <div class="col-12 col-sm-12 col-md-12 mg-btm-20 break-before con322">
                                        <h2 class="image_title"><?php echo $image['title'] ?></h2>
                                        <img data-slide="slide-image-<?= $j; ?>" data-bs-toggle="offcanvas"
                                             data-bs-target="#offcanvasRight2" aria-controls="offcanvasRight"
                                             class="<?php echo ($image['orientation'] == 'landscape') ? 'proposalImage_l' : 'proposalImage_p'; ?> img-fluid img-thumbnail img_mobile btn showProposalCarousel"
                                             style="object-fit: cover; height:auto;width:100%;"
                                             data-image-id="<?php echo $image['id']; ?>"
                                             src="<?php echo $image['src']; ?>" alt="">
                                        <h2 style="text-align: center;margin-top: 10px;">Notes:</h2>
                                        <div style="text-align: left;"><?php echo $image['notes']; ?></div>
                                        <br>
                                    </div>
                                    <?php
                                    //increment counter
                                    $imageCount++;
                                    //close table
                                    if ($imageCount % 2 == 0) {
                                        ?>
                                        </div></div></div>
                                        <div class="row page_number">Page <?= $page++ ?></div></div>
                                        <?php
                                        $tableOpen = 0;
                                    }
                                    break;
                                case 2:


                                    if ($tableOpen) {
                                        if ($old_layout == 1) {
                                            if ($imageCount % 2) {
                                                echo '</div></div></div>';
                                            }
                                            //close table
                                            echo '<div class="row page_number">Page ' . $page++ . '</div></div>';
                                            $tableOpen = 0;
                                        } else {

                                        }
                                    }
                                    if ($old_layout != 2) {
                                        $imageCount = 0;
                                    }
                                    // //open table
                                    if (!($imageCount % 4)) {
                                        ?>
                                        <div class="grid invoice pdf-height  page_break_before" data-page-id="images" style="padding-top: 10px;" <?php //if($j==1){echo ' id="images"';}?> >
                                        <div class="grid-body">
                                        <?php if ($j == 1) { ?>
                                            <div class="print_hide ">
                                                <div class="row">
                                                    <h1 class="underlined global_header ft-s-22 proposal_image_heading" style="width: 97%;">
                                                        Proposal Images</h1>
                                                    <div class="logotopright only_show_print"><img class="theLogo"
                                                                                                   style="height: 35px; width: 120px; margin-right: 8px;"
                                                                                                   src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                                                                                                       UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>"
                                                                                                   alt=""></div>
                                                </div>
                                            </div>
                                        <?php } ?>

                                        <div class="row">

                                        <?php
                                        $tableOpen = 1;
                                    }
                                    //display image
                                if ($imageCount == 2) {

                                    // if ($imageCount % 4 == 0) {
                                    // 	echo '</div>';
                                    // }
                                    ?>
                                    </div>
                                    <div class="row">
                                    <?php
                                }

                                    ?>


                                    <div class="col-12 col-sm-8 col-md-8 mg-btm-20 break-after" style="position: relative;">
                                        <?php if ($j == 1) { ?>


                                            <div class="row">

                                                <h1 class="underlined global_header only_show_print"
                                                    style="width: 725px;">
                                                    Proposal:
                                                    <?php echo ($proposal->getJobNumber() ? 'Job #: ' . $proposal->getJobNumber() . "<br />" : ''); ?>
                                                    <?php echo $proposal->getProjectName() ?> </h1>
                                                <div class="logotopright only_show_print"
                                                     style="top: -6px!important;left: 619px!important;"><img
                                                            class="theLogo"
                                                            style="height: 35px; width: 120px; margin-right: 8px;"
                                                            src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                                                                UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>"
                                                            alt=""></div>
                                            </div>
                                        <?php } ?>
                                        <h4 class="image_title"><?php echo $image['title'] ?></h4>
                                        <img data-slide="slide-image-<?= $j; ?>"
                                             data-image-id="<?php echo $image['id']; ?>" data-bs-toggle="offcanvas"
                                             data-bs-target="#offcanvasRight2" aria-controls="offcanvasRight"
                                             class="<?php echo ($image['orientation'] == 'landscape') ? 'proposalImage_l' : 'proposalImage_p'; ?> img-fluid img-thumbnail img_mobile btn showProposalCarousel"
                                             style="object-fit: cover; height:auto; width:100%;"
                                             src="<?php echo $image['src']; ?>" alt="">
                                             <p class="image-section-inlarge-text image-inlarge-text" style="pointer-events: none;right: 25px;">+ Enlarge</p>
                                        <br>
                                    </div>
                                    <div class="col-12 col-sm-4 col-md-4 mg-btm-20 break-after">
                                        <h4 class="image_notes_heading" style="text-align: center;margin-top: 10px;">Notes:</h4>
                                        <div style="text-align: center;"><?php
                                        if($image['notes']){
                                            echo $image['notes'];
                                        }else{
                                            echo 'No Image Notes';
                                        }

                                         ?></div>
                                    </div>
                                    <?php


                                    //if ($imageCount % 2) {
                                    ?>

                                    <?php
                                    //}
                                    //increment counter
                                    $imageCount++;
                                    //close table
                                    if ($imageCount % 4 == 0) {
                                        ?>
                                        </div></div>
                                        <div class="row page_number">Page <?= $page++; ?></div></div>
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
                                                    echo '</div></div></div>';
                                                    $tableOpen = 0;
                                                } else {
                                                    //echo '</div>9';
                                                    $tableOpen = 0;
                                                    if (count($images2) != $j) {
                                                        // echo '</table>';
                                                    }

                                                }

                                            } else if ($old_layout == 1) {
                                                if ($imageCount % 2) {
                                                    echo '</div></div>';
                                                }

                                            }
                                            if ($image['image_layout'] == 0) {
                                                echo '</div>';
                                            }
                                            echo '<div class="row page_number">Page ' . $page++ . '</div></div>';

                                            $tableOpen = 0;
                                            //close table

                                            //echo 'test3';die;
                                        }
                                        //echo '<div style="page-break-after: always"></div>';
                                    }

                                    ?>
                                    <div class="grid invoice pdf-height page_break 1con" data-page-id="images"
                                         style="padding-top: 10px;" <?php //if($j==1){echo ' id="images"';}
                                    ?> >
                                        <div class="grid-body">
                                            <?php if ($j == 1) { ?>
                                                <div class="row">
                                                    <div class="row">
                                                        <h1 class="underlined global_header ft-s-22">Proposal
                                                            Images</h1>
                                                    </div>
                                                </div>
                                            <?php } ?>

                                            <div class="row">

                                                <div class="" id="gallery" data-toggle="modal"
                                                     data-target="#exampleModal">

                                                    <div class="col-12 col-sm-12 col-md-12 mg-btm-20 break-before con234234">
                                                        <h2 class="image_title"><?php echo $image['title'] ?></h2>
                                                        <img data-slide="slide-image-<?= $j; ?>"
                                                             data-bs-toggle="offcanvas"
                                                             data-bs-target="#offcanvasRight2"
                                                             aria-controls="offcanvasRight"
                                                             class="<?php echo ($image['orientation'] == 'landscape') ? 'proposalImage_l' : 'proposalImage_p'; ?> img-fluid img-thumbnail img_mobile btn showProposalCarousel"
                                                             style="object-fit: cover; height:auto; width:100%;"
                                                             src="<?php echo $image['src']; ?>" alt="">
                                                        <h2 style="text-align: center;margin-top: 10px;">Notes:</h2>
                                                        <div style="text-align: left;"><?php echo $image['notes']; ?></div>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row page_number">Page <?= $page++ ?></div>
                                    </div>
                                    <?php
                                    break;
                            }
                            $old_layout = $image['image_layout'];
                            }

                        }//new end

                        if ($tableOpen) {
                            if ($old_layout == 1) {
                                //close table
                                echo '</div></div></div><div class="row page_number">Page ' . $page++ . '</div></div>';
                            } else if ($old_layout == 2) {
                                echo '</div></div><div class="row page_number">Page ' . $page++ . '</div></div>';
                            } else {
                                //close tr's if necessary...
                                if ($imageCount % 2) {
                                    echo '</div></div>';
                                }
                                //close table
                                echo '<div></div></div></div><div class="row page_number">Page ' . $page++ . '</div></div>';
                            }
                        } ?>


                    </div>


                <?php } ?>


                <!-- END INVOICE -->


                <!-- BEGIN Videos -->

                <?php 
                 $videoType = '';
                if (count($work_order_videos)) {
                    $videoCounter = 1;
                    ?>
                    <div class="grid invoice print_hide mg-left-55" style="padding-top: 10px;" id="video" data-page-id="video">
                        <div class="grid-body">
                            <div class="row">

                                <div class="row">
                                    <h1 class="underlined global_header">Proposal <?=  (count($work_order_videos) > 1) ? 'Videos' : 'Video';?></h1>
                                    <div class="logotopright only_show_print"><img class="theLogo"
                                                                                   style="height: 35px; width: 120px; margin-right: 8px;"
                                                                                   src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                                                                                       UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>"
                                                                                   alt=""></div>
                                </div>
                            </div>
                            <div class="row">
                            <?php
                           


                            foreach ($work_order_videos as $video) {
                                $buttonShow = false;
                                $companyThumbImage = false;
                                if($video->getCompanyVideoId() !=0 && $video->getCompanyCoverImage() !=''){
                                    $companyThumbImage = $video->getCompanyCoverImage();
                                }
                                $url = $video->getVideoUrl();
                                if ($video->getEmbedVideoUrl()) {
                                    $finalUrl = $video->getEmbedVideoUrl();
                                } else {
                                    $finalUrl = $url;
                                }
                                $iframVideoClass = '';
                                $videoType = $video->getVideoType();
                                if ($videoType == 'NA') {
                                    $buttonShow = true;
                                } else if ($videoType == 'youtube') {
                                    $iframVideoClass = 'YoutubeIframe';
                                } else if ($videoType == 'vimeo') {

                                    $iframVideoClass = 'VimeoIframe';
                                }
                                $box_size = 'col-lg-6 col-md-6';
                                    if($video->getIsLargePreview()){
                                        $box_size = 'col-lg-12 col-md-12';
                                    }
                                ?>


                                <div class="<?= $box_size;?> col-sm-12" style="margin-bottom:20px;">

                                    <?php if ($buttonShow) { ?>
                                        <h3 class="video_title"><?= $videoCounter; ?>. <?php echo $video->getTitle(); ?></h3>
                                        <p><?php echo $video->getVideoNote(); ?></p>
                                        <a href="<?php echo $url; ?>" class="btn btn-primary"
                                           style="min-width:150px;width: auto;margin: auto;" target="_blank"><i
                                                    class="fa fa-fw fa-play-circle-o"></i>Play: <?php echo $video->getTitle(); ?>
                                        </a>
                                    <?php } else { ?>
                                        <h3 class="video_title"><?= $videoCounter; ?>. <?php echo $video->getTitle(); ?></h3>
                                        <p><?php echo $video->getVideoNote(); ?></p>
                                        <div class="embed-responsive embed-responsive-16by9 video " data-video-id="<?php echo $video->getId(); ?>">
                                            <?php 
                                            $autoplay = '';
                                            if ($videoType == 'youtube') {
                                                $autoplay = '&autoplay=1&rel=0&loop=1&modestbranding=1';

                                            } else if ($videoType == 'vimeo') {
                                                $autoplay = '?autoplay=1';
                                                $iframVideoClass = 'VimeoIfram';
                                            } else if ($videoType == 'screencast') {
                                                $autoplay = '?autoplay=1';
                                            }
                                            
                                            if ($video->getThumbnailImage() || $companyThumbImage) {
                                                if($video->getThumbnailImage()){
                                                     $thumbImageURL = $proposal->getSitePathUploadDir() . '/' . $video->getThumbnailImage();
                                                 }else{
                                                     $thumbImageURL = $companyThumbImage;
                                                }
                                                ?>
                                                <img src="<?= $thumbImageURL; ?>" >
                                                <div class="play-overlay">
                                                    <a href="javascript:void(0)" class="play-icon">
                                                        <i class="fa fa-play-circle"></i>
                                                    </a>
                                                </div>
                                                <!-- <iframe class="embed-responsive-item proposal_video_ifram <?php echo $iframVideoClass; ?>" data-video-type="<?=$videoType;?>" video_id="<?php echo $video->getId(); ?>"  id="embed-responsive-video-<?php echo $video->getId(); ?>" src="<?php echo $finalUrl . $autoplay; ?>"
                                            allowfullscreen loading="lazy" allow="autoplay" onload="popupVideoLoaded" ></iframe> -->
                                            <?php } else { 
                                                $newThumbImageURL = site_url('static/images/video-play-icon-transparent.jpg');
                                                if ($videoType == 'youtube') {
                                                   
                                                    parse_str( parse_url( $url, PHP_URL_QUERY ), $my_array_of_vars );
                                                    if(isset($my_array_of_vars['v'])){
                                                        $video_id = $my_array_of_vars['v'];   
                                                        $newThumbImageURL = "https://img.youtube.com/vi/".$video_id."/0.jpg";
                                                    }else{
                                                        $newThumbImageURL = site_url('static/images/video-play-icon-transparent.jpg');
                                                    }
                                                    
                                                } else if ($videoType == 'vimeo') {
                                                    $urlParts = explode("/", parse_url($url, PHP_URL_PATH));
                                                    $video_id = (int)$urlParts[count($urlParts)-1];
                                                    $newThumbImageURL = "https://vumbnail.com/".$video_id.".jpg";
                                                }else if ($videoType == 'screencast') {
                                                    $newThumbImageURL = str_replace('www', 'content', $url);
                                                    $newThumbImageURL = str_replace('embed', 'FirstFrame.jpg', $newThumbImageURL);

                                                }

                                                
                                                    ?>
                                                <img src="<?=$newThumbImageURL;?>">
                                                <div class="play-overlay">
                                                    <a href="javascript:void(0)" class="play-icon">
                                                        <i class="fa fa-play-circle"></i>
                                                    </a>
                                                </div>
                                                <!-- <iframe class="embed-responsive-item proposal_video_ifram <?php echo $iframVideoClass; ?>" data-video-type="<?=$videoType;?>" video_id="<?php echo $video->getId(); ?>"  id="embed-responsive-video-<?php echo $video->getId(); ?>" src="<?php echo $finalUrl . $autoplay; ?>"
                                            allowfullscreen loading="lazy" allow="autoplay"  onload="popupVideoLoaded" ></iframe> -->
                                                
                                            <?php  }?>
                                        </div>

                                    <?php } ?>
                                </div>
                                <?php
                                $videoCounter++;
                            }
                            ?>
                            </div>
                            
                        </div>
                        <div class="row page_number">Page <?= $page++ ?></div>
                    </div>
                <?php } ?>
                <!-- END Videos -->
                <!-- BEGIN INVOICE -->

                <?php

                if ($proposal->getAuditKey()) {
                    ?>
                    <div class="grid invoice print_hide" style="padding-top: 10px;" id="audit-section"
                         data-page-id="audit">
                        <div class="grid-body">
                            <div class="row">
                                <h1 class="underlined global_header ft-s-22">Property Inspection / Audit</h1>
                            </div>
                            <div style="page-break-inside: avoid">
                                <div class="item-content audit print_hide">
                                    <h2 class="ft-s-22">Property Inspection / Audit</h2>

                                    <table>
                                        <tr>
                                            <td style="text-align: center;width:25%">
                                                <a href="javascript:void(0)" class="openAuditIframe"
                                                   data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight4"
                                                   aria-controls="offcanvasRight"
                                                   style="display: block;float: left;">
                                                    <img id="auditIcon"
                                                         src=" <?php echo site_url('uploads/audit-icon.png'); ?>"/>
                                                </a>
                                                <a href="<?php echo $proposal->getAuditReportUrl(true); ?>"
                                                   id="mobile_openAuditIframe" target="_blank" style="display: none;">Click</a>
                                                <p style="padding-top: 19px;text-align: center; font-weight: bold; font-style: italic;margin-top: 96px;">
                                                    Click to See</p>
                                            </td>
                                            <td style="font-size: 16px; ">
                                                <p style="margin-top: 0px;padding-top: 14px;">We have performed a
                                                    custom site inspection/audit of this site including maps, images
                                                    and more</p>
                                                <p style="padding-top: 4px;margin-top: 0px;"><a
                                                            href="javascript:void(0)" class="openAuditIframe"
                                                            data-bs-toggle="offcanvas"
                                                            data-bs-target="#offcanvasRight4"
                                                            aria-controls="offcanvasRight">View your Custom Site
                                                        Inspection/Audit Report</a></p>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="audit-footer" style="margin-top: 10px;"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                <?php } ?>
                <!-- END INVOICE -->
                <!-- BEGIN INVOICE -->
                <?php
                //proposal attachments
                if ($proposal->getWorkOrderNotes()) {
                    ?>
                    <div class="grid invoice pdf-height" style="padding-top: 10px;" id="notes-section"
                             data-page-id="audit">
                            <div class="grid-body">
                                <div class="row">
                                    <h1 class="underlined global_header ft-s-22">Notes</h1>
                                </div>

                    <?php echo $proposal->getWorkOrderNotes(); ?>
                    </div>
                        </div>
                    <?php
                }?>

                
                <?php 
                if (count($workorder_attachments)) {
                    ?>
                    <div class="grid invoice pdf-height page_break_before mg-left-55" id="attachments"
                         data-page-id="attachments">
                        <div class="grid-body">

                            <div class="row">
                                <h1 class="underlined header_fix attachmentsHead global_header print_hide" >Attachments</h1>
                                <h1 class="underlined global_header only_show_print" style="width: 715px;">
                                    Attachments </h1>
                                <div class="logotopright only_show_print" style="top: 23px!important;"><img
                                            class="theLogo" style="height: 35px; width: 120px; margin-right: 8px;"
                                            src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                                                UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>"
                                            alt=""></div>

                            </div>
                            <!--<p>Please click any of the links below to view and print all documents.</p>-->
                            <div class="row">
                                
                                    <div class="attachmentsTypes">
                                        
                                        <?php
                                        foreach ($workorder_attachments as $attachment) {
                                            $url = site_url('uploads/companies/' . $proposal->getClient()->getCompany()->getCompanyId() . '/proposals/' . $proposal->getProposalId() . '/' . $attachment->getFilePath());
                                            ?>
                                            <h3 
                                                class="attachmentName"><a
                                                        href="<?php echo str_replace(' ', '%20', $url) ?>"
                                                        target="_blank"><?php echo $attachment->getFileName() ?></a>
                                            </h3>
                                            <?php
                                        } ?>
                                    </div>
                                
                                
                            </div>
                            <div class="row page_number">Page <?= $page++ ?></div>

                        </div>
                    </div>
                <?php }
                ?>
            </div>

        </div>


        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <legend class="text-left">Add Signature : <?php echo $proposal->getProposalTitle() ?></legend>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form id="clientSignatureForm" onsubmit="return false;" class="g-3 needs-validation" novalidate>
                    <div class="row">

                        <hr/>
                        <div class="alert alert-primary" role="alert">
                            <i class="fa fa-fw fa-info-circle"></i> Draw or upload your signature below to accept the
                            contract. We will email you a copy of the proposal to confirm.
                        </div>
                        <div class="col-md-6">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="signature_firstname" class="form-label">First Name</label>
                                    <?php
                                    if ($clientSig) {
                                        $client_names = explode(" ", $clientSig->getName());
                                        $client_firstname = @$client_names[0];
                                        $client_lastname = @$client_names[1];
                                    }

                                    ?>
                                    <input type="text" required name="firstname" class="form-control"
                                           value="<?php echo ($clientSig) ? $client_firstname : $proposal->getClient()->getFirstName(); ?>"
                                           id="signature_firstname" placeholder="Enter First Name">
                                    <div class="invalid-feedback"> Please enter First Name</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="signature_lastname" class="form-label">Last Name</label>
                                    <input type="text" required name="lastname" class="form-control"
                                           value="<?php echo ($clientSig) ? $client_lastname : $proposal->getClient()->getLastName(); ?>"
                                           id="signature_lastname" placeholder="Enter Last Name">
                                    <div class="invalid-feedback"> Please enter Last Name</div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="signature_company" class="form-label">Company Name</label>
                                    <input type="text" required name="company" class="form-control"
                                           value="<?php echo ($clientSig) ? $clientSig->getCompanyName() : $proposal->getClient()->getClientAccount()->getName(); ?>"
                                           id="signature_company" placeholder="Enter Company Name">
                                    <div class="invalid-feedback"> Please enter Company Name</div>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="signature_title" class="form-label">Title</label>
                                    <input type="text" required name="signature_title" class="form-control"
                                           value="<?php echo ($clientSig) ? $clientSig->getTitle() : $proposal->getClient()->getTitle(); ?>"
                                           id="signature_title" placeholder="Enter Title">
                                    <div class="invalid-feedback"> Please enter Title</div>
                                    <input type="hidden" id="proposal_id" name="proposal_id"
                                           value="<?= $proposal->getProposalId(); ?>">
                                    <input type="hidden" id="signature_url" name="signature_url" value="">
                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="signature_email" class="form-label">Email</label>
                                <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required
                                       name="email" class="form-control"
                                       value="<?php echo ($clientSig) ? $clientSig->getEmail() : $proposal->getClient()->getEmail(); ?>"
                                       id="signature_email" placeholder="Enter Email">
                                <div class="invalid-feedback"> Please enter a valid Email</div>

                            </div>

                            <div class="mb-3">
                                <label for="signature_comments" class="form-label">Comments</label>
                                <textarea class="form-control" id="signature_comments" rows="3"
                                          placeholder="Enter Comments"></textarea>
                            </div>


                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Signature</label>
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home"
                                            aria-selected="true">Draw
                                    </button>
                                    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-profile" type="button" role="tab"
                                            aria-controls="nav-profile" aria-selected="false">Upload
                                    </button>

                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active" id="nav-home" role="tabpanel"
                                     aria-labelledby="nav-home-tab">
                                    <div id="my_pad">
                                        <div id="signature-pad" class="signature-pad">
                                            <div class="signature-pad--body">
                                                <canvas></canvas>
                                            </div>
                                            <div class="signature-pad--footer">
                                                <div class="description">Sign above</div>

                                                <div class="signature-pad--actions">
                                                    <div>
                                                        <button type="button" class="button clear" data-action="clear">
                                                            Clear
                                                        </button>

                                                        <button type="button" class="button" data-action="undo">Undo
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane fade" id="nav-profile" role="tabpanel"
                                     aria-labelledby="nav-profile-tab">
                                    <div class="input-group" style="margin-top:20px;">
                                        <input type="file" class="form-control" id="signature_file_input"
                                               onchange="previewFile(this);" accept="image/*"
                                               style="border-color:rgb(206, 212, 218);background-image:none">

                                    </div>

                                    <img id="previewImg" src="" class="img-fluid img-thumbnail"
                                         style="max-width:230px;display:none;margin-top:20px;border-color:none;background-image:none">
                                </div>
                                <span class="redhide signature_msg">Please provide a valid Signature</span>
                            </div>

                        </div>
                        <div class="col-md-12 text-right mt-3">
                            <button id="save_signature_btn" type="submit" name="submit" style="float:right"
                                    class="btn btn-primary  pull-right"><i class="fa fa-pencil-square-o"></i> Save
                                Signature
                            </button>
                            <div id="save_signature_loader">
                                <div class="d-flex align-items-center">
                                    <div class="spinner-border text-primary" role="status" aria-hidden="true"></div>
                                    <span class="spinner-text">Saving your signature</span>
                                </div>
                            </div>

                        </div>
                        <!-- <a class="m-btn blue-button complate_job_costing disabled" href="javascript:void(0)" style="position: relative; margin:10px 0px" >Complete Job Costing</a> -->

                    </div>

                </form>
            </div>
        </div>


        <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight2" aria-labelledby="offcanvasRightLabel">
            
            <div class="offcanvas-body" style="border-top:1px solid #ccc">
                <button type="button" class="btn-close text-reset big_close_btn " style="top: 2px;right: 15px;z-index: 9999;" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                <div id="proposalCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                    <div class="carousel-inner" style="width:100%;">
                    <button type="button" class="btn-close text-reset mobile_landscape_image_close_btn" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                        <?php
                        $k = 1;
                        foreach ($images2 as $image) { ?>
                            <div class="carousel-item pd-top-25 slide-image-<?= $k; ?>">
                                <div class="carousel-caption d-md-block pd-top-0-minus ">
                                    <h5><?php echo $image['title'] ?></h5>
                                </div>
                                <img src="<?php echo $image['src']; ?>" data-image-id="<?php echo $image['id']; ?>"
                                     class="d-block w-100 responsive carousel-img" alt="...">
                                <div class="carousel-caption d-md-block bottom-note">
                                    <h5>Image Notes</h5>
                                    <div style="height: 11vh;overflow: auto;"><?php if($image['notes'] !=''){echo $image['notes'];}else{ echo 'No Image Notes';} ?></div>
                                </div>
                            </div>

                            <?php $k++;
                        } ?>
                    </div>

                    <button class="carousel-control-prev" style="margin-top: 25px;height: calc(100vh - 10vh);" type="button" data-bs-target="#proposalCarousel"
                            data-bs-slide="prev">
                        <span class="carousel-control-prev-icon custom-carousel-control-prev-icon"
                              aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" style="margin-top: 25px;height: calc(100vh - 10vh);" type="button" data-bs-target="#proposalCarousel"
                            data-bs-slide="next">
                        <span class="carousel-control-next-icon custom-carousel-control-next-icon"
                              aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>


        <!-- ask question offcanvas-->
        <div class="offcanvas offcanvas-end offcanvas-410" tabindex="-1" id="offcanvasRight3"
             aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <legend class="text-left pave-text-color">Ask Question
                    : <?php echo $proposal->getProposalTitle() ?></legend>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <form id="clientSignatureForm" onsubmit="return false;" class="g-3 needs-validation2" novalidate>
                    <div class="row">

                        <hr/>

                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="ask_question_firstname" class="form-label">First Name</label>
                                    <?php
                                    if ($clientSig) {
                                        $client_names = explode(" ", $clientSig->getName());
                                        $client_firstname = @$client_names[0];
                                        $client_lastname = @$client_names[1];
                                    }

                                    ?>
                                    <input type="text" required name="ask_question_firstname" class="form-control"
                                           value="<?php echo ($clientSig) ? $client_firstname : $proposal->getClient()->getFirstName(); ?>"
                                           id="ask_question_firstname" placeholder="Enter First Name">
                                    <div class="invalid-feedback"> Please enter First Name</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ask_question_lastname" class="form-label">Last Name</label>
                                    <input type="text" required name="lastname" class="form-control"
                                           value="<?php echo ($clientSig) ? $client_lastname : $proposal->getClient()->getLastName(); ?>"
                                           id="ask_question_lastname" placeholder="Enter Last Name">
                                    <div class="invalid-feedback"> Please enter Last Name</div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="ask_question_company" class="form-label">Company Name</label>
                                    <input type="text" required name="ask_question_company" class="form-control"
                                           value="<?php echo ($clientSig) ? $clientSig->getCompanyName() : $proposal->getClient()->getClientAccount()->getName(); ?>"
                                           id="ask_question_company" placeholder="Enter Company Name">
                                    <div class="invalid-feedback"> Please enter Company Name</div>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="ask_question_title" class="form-label">Title</label>
                                    <input type="text" required name="ask_question_title" class="form-control"
                                           value="<?php echo ($clientSig) ? $clientSig->getTitle() : $proposal->getClient()->getTitle(); ?>"
                                           id="ask_question_title" placeholder="Enter Title">
                                    <div class="invalid-feedback"> Please enter Title</div>
                                    <input type="hidden" id="ask_question_proposal_id" name="ask_question_proposal_id"
                                           value="<?= $proposal->getProposalId(); ?>">

                                </div>

                            </div>
                            <div class="mb-3">
                                <label for="ask_question_email" class="form-label">Email</label>
                                <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required
                                       name="ask_question_email" class="form-control"
                                       value="<?php echo ($clientSig) ? $clientSig->getEmail() : $proposal->getClient()->getEmail(); ?>"
                                       id="ask_question_email" placeholder="Enter Email">
                                <div class="invalid-feedback"> Please enter a valid Email</div>

                            </div>
                            <div class="mb-3">
                                <label for="ask_question" class="form-label">Question</label>
                                <textarea class="form-control" id="ask_question" rows="4"
                                          placeholder="Enter Question"></textarea>
                            </div>

                        </div>


                        <div class="col-md-12 text-right mt-3">
                            <button id="ask_question_btn" type="submit" name="submit"
                                    class="btn btn-primary pave-btn pull-right"><i class="fa fa-pencil-square-o"></i>
                                Ask Question
                            </button>
                            <div id="ask_question_loader">
                                <div class="d-flex align-items-center">
                                    <div class="spinner-border text-primary" role="status" aria-hidden="true"></div>
                                    <span class="spinner-text">Sending Question</span>
                                </div>
                            </div>

                        </div>

                    </div>

                </form>
            </div>
        </div>
        <!-- end ask question offcanvas-->


        <!-- ask question offcanvas-->
        <?php
        if ($proposal->getAuditKey()) { ?>
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasRight4"
                 aria-labelledby="offcanvasRightLabel">

                <span class="canvas-back-btn"><button type="button" class="btn btn-primary btn-sm  pave-btn"
                                                      data-bs-dismiss="offcanvas" aria-label="Close"><i
                                class="fa fa-fw fa-chevron-left"></i></button></span>
                <span class="canvas-back-right-btn"><button type="button" class="btn-close text-reset"
                                                            data-bs-dismiss="offcanvas"
                                                            aria-label="Close"></button></span>
                <div class="offcanvas-body pad-top-0">
                    <div class="row">
                        <div id="audit_iframe_loader">
                            <div class="d-flex align-items-center">
                                <div class="spinner-border text-primary" role="status" aria-hidden="true"></div>
                                <span class="spinner-text">Loading </span>
                            </div>
                        </div>
                        <iframe id="auditIframe" class="embed-responsive-item audit-full-height"
                                data-src="<?php echo $proposal->getAuditReportUrl(true); ?>" allowfullscreen></iframe>
                    </div>
                </div>
            </div>
        <?php } ?>
        <!-- end ask question offcanvas-->
        <!-- Service offcanvas-->
        <div class="offcanvas offcanvas-end offcanvas-410" tabindex="-1" id="serviceOffcanvasRight"
             aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <legend class="text-left pave-text-color ServiceNameHead">Project Specification</legend>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
            </div>
            <div class="offcanvas-body service-offcanvas-body">

            </div>
            <div class="offcanvas-footer service-offcanvas-footer">

            </div>
        </div>
        <!-- end service offcanvas-->

        <!-- Info Header offcanvas-->
        <div class="offcanvas offcanvas-end offcanvas-410" tabindex="-1" id="offcanvasInfo"
             aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <legend class="text-left pave-text-color ServiceNameHead">Information</legend>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
            </div>
            <div class="offcanvas-body info-offcanvas-body">
                <div class="col-lg-12">
                    <strong>
                        Please Use Desktop browser for better expireance
                    </strong><br/>


                </div>

            </div>
        </div>
        <!-- end info header offcanvas-->

        <!-- PreProposal offcanvas-->
        <div class="offcanvas offcanvas-end offcanvas-410" tabindex="-1" id="offcanvasPreProposal"
             aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <legend class="text-left pave-text-color ">Information</legend>

            </div>
            <div class="offcanvas-body info-offcanvas-body">


                <div id="carouselExampleDark" class="carousel carousel-dark slide" data-bs-ride="carousel"
                     data-bs-interval="5000">
                    <div class="carousel-indicators">
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="0" class="active"
                                aria-current="true" aria-label="Slide 1"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                        <button type="button" data-bs-target="#carouselExampleDark" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                    </div>
                    <div class="carousel-inner">
                        <div class="carousel-item active">
                            <img src="<?php echo site_url('static/images/snagit2.png') ?>"
                                 class="d-block w-100 pre-popup-img" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>First slide label</h5>
                                <p>Some representative placeholder content for the first slide.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="<?php echo site_url('static/images/snagit3.png') ?>"
                                 class="d-block w-100 pre-popup-img" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Second slide label</h5>
                                <p>Some representative placeholder content for the second slide.</p>
                            </div>
                        </div>
                        <div class="carousel-item">
                            <img src="<?php echo site_url('static/images/snagit2.png') ?>"
                                 class="d-block w-100 pre-popup-img" alt="...">
                            <div class="carousel-caption d-none d-md-block">
                                <h5>Third slide label</h5>
                                <p>Some representative placeholder content for the third slide.</p>
                            </div>
                        </div>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleDark"
                            data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleDark"
                            data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>


            </div>
            <div class="offcanvas-footer preproposal-offcanvas-footer">
                <span><span><input type="checkbox" name="dont_show" id="dont_show_pre_popup" value="1"></span><span
                            style="    margin: 0px 0px 0px 10px;vertical-align: text-top;">Don't show me this again </span></span>
                <span class="canvas-close-ok-btn"><button type="button"
                                                          class="btn btn-primary btn-sm  pave-btn canvas-btn-w-100 close_pre_popup"
                                                          data-bs-dismiss="offcanvas"
                                                          aria-label="Close">Ok</button></span></div>
        </div>
        <!-- end PreProposal offcanvas-->

         <!-- Image-Info offcanvas-->
         <div class="offcanvas offcanvas-none offcanvas-410" tabindex="-1" id="mobileImageInfoNote"
             aria-labelledby="offcanvasRightLabel">
             <div class="offcanvas-header">
                <legend class="text-left pave-text-color mobile-note-image-info-offcanvas-title">Info</legend>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
            </div>
            <div class="offcanvas-body mobile-note-image-info-offcanvas-body ">
                
            </div>
            
        </div>
        <!-- end service offcanvas-->

        
        <!--Service Image offCanvas--->

        <?php 
            foreach ($services as $service) {

                $imagesTest = array();
                if(isset($service_images[$service->getServiceId()])){

                    foreach($service_images[$service->getServiceId()] as $k => $service_image){
                        if ($service_image['image']->getActivewo()) {
                            $img = array();
                            $img['src'] = $service_image['websrc'];
                            $img['id'] = $service_image['id'];
                            $img['path'] = $service_image['path'];
                            if (file_exists($img['path'])) {
                                
                                $img['title'] = $service_image['image']->getTitle();
                                $img['notes'] = $service_image['image']->getNotes();
                                
                                $imagesTest[] = $img;
                            }
                            
                        }
                    }

                    if(count($imagesTest)){
                    
                        
                
        ?>
            <div class="offcanvas offcanvas-none service_image_offcanvas" tabindex="-1" id="service_image_offcanvas_<?=$service->getServiceId();?>" aria-labelledby="offcanvasRightLabel" style="top: 0;overflow-y: scroll;display:block">
            
            <div class="offcanvas-body" style="border-top:1px solid #ccc">
                <button type="button" class="btn-close text-reset big_close_btn " style="top: 2px;right: 15px;z-index: 9999;"  data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>   
                <div id="service_image_carousel_<?=$service->getServiceId();?>" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                    <div class="carousel-inner" style="width:100%;">
                   
                        <?php
                        $k = 1;
                        foreach ($imagesTest as $image) { ?>
                            <div class="carousel-item pd-top-25 slide-image-<?= $k; ?>">
                                <div class="carousel-caption d-md-block pd-top-0-minus ">
                                    <h5><?php echo $image['title'] ?></h5>
                                </div>
                                <img src="<?php echo $image['src']; ?>" data-image-id="<?php echo $image['id']; ?>"
                                     class="d-block w-100 responsive carousel-img" alt="...">
                                <div class="carousel-caption d-md-block bottom-note">
                                    <h5>Image Notes</h5>
                                    <div style="height: 11vh;overflow: auto;"><?php if($image['notes'] !=''){echo $image['notes'];}else{ echo 'No Image Notes';} ?></div>
                                </div>
                            </div>

                            <?php $k++;
                        } ?>
                    </div>

                    <button class="carousel-control-prev" style="margin-top: 25px;height: calc(100vh - 10vh);" type="button" data-bs-target="#service_image_carousel_<?=$service->getServiceId();?>"
                            data-bs-slide="prev">
                        <span class="carousel-control-prev-icon custom-carousel-control-prev-icon"
                              aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" style="margin-top: 25px;height: calc(100vh - 10vh);" type="button" data-bs-target="#service_image_carousel_<?=$service->getServiceId();?>"
                            data-bs-slide="next">
                        <span class="carousel-control-next-icon custom-carousel-control-next-icon"
                              aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
            
            
            
            
            
            
            
            
 
            </div>
        <?php

                        

                    }
                }
            }

        ?>
        <!--End Service Image offCanvas--->


        <!-- Links in Proposal Services Opens here -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="proposalServiceLinks"
             aria-labelledby="offcanvasRightLabel">

            <span class="canvas-back-btn"><button type="button" class="btn btn-primary btn-sm  pave-btn"
                                                  data-bs-dismiss="offcanvas" aria-label="Close"><i
                            class="fa fa-fw fa-chevron-left"></i></button></span>
            <span class="canvas-back-right-btn"><button type="button" class="btn-close text-reset"
                                                        data-bs-dismiss="offcanvas" aria-label="Close"></button></span>
            <div class="offcanvas-body pad-top-0">
                <div class="row">
                    <div id="service_links_iframe_loader">
                        <div class="d-flex align-items-center">
                            <div class="spinner-border text-primary" role="status" aria-hidden="true"></div>
                            <span class="spinner-text">Loading </span>
                        </div>
                    </div>
                    <iframe id="proposalServiceLinksIframe" class="embed-responsive-item full-height-service-link"
                            allowfullscreen></iframe>
                </div>
            </div>
        </div>
        <!--End Links in Proposal Services Opens here -->
        <!-- Proposal Video Opens here -->
        <div class="offcanvas offcanvas-end" tabindex="-1" id="VideoPlayersOffcanvas" aria-labelledby="offcanvasRightLabel">

        <span class="video-close-right-btn close_video_popup">
            <button type="button" class="btn-close text-reset btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </span>

            <div class="offcanvas-body pad-top-0" id="video_player_iframe_body">
                
            </div>
        </div>

        <?php

        foreach ($work_order_videos as $video) {
                                $buttonShow = false;
                                $autoplay = '';
                                $url = $video->getVideoUrl();
                                if ($video->getEmbedVideoUrl()) {
                                    $finalUrl = $video->getEmbedVideoUrl();
                                } else {
                                    $finalUrl = $url;
                                }
                                $iframVideoClass = '';
                                $videoType = $video->getVideoType();
                                if ($videoType == 'NA') {
                                    $buttonShow = true;
                                } else if ($videoType == 'youtube') {
                                    $autoplay = '&rel=0&loop=1&modestbranding=1';
                                    $iframVideoClass = 'YoutubeIframe';
                                } else if ($videoType == 'vimeo') {
                                    //$autoplay = '?autoplay=1';
                                    $iframVideoClass = 'VimeoIframe';
                                }

                                ?>



<?php if (!$buttonShow) { ?>

    <!-- testProposal Video Opens here -->
        <div class="offcanvas offcanvas-end VideoPlayersOffcanvas" tabindex="-1" id="VideoPlayersOffcanvas_<?php echo $video->getId(); ?>" aria-labelledby="offcanvasRightLabel">

<span class="video-close-right-btn close_video_popup" data-video-id="<?php echo $video->getId(); ?>">
    <button type="button" class="btn-close text-reset btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
</span>

    <div class="offcanvas-body pad-top-0 video_player_iframe_body" id="video_player_iframe_body_<?php echo $video->getId(); ?>">
        <div class="videoLoaderDiv"><div class="spinner-border text-primary video-spinner" role="status" aria-hidden="true"></div><span class="spinner-text">Loading </span></div>
        <iframe class="embed-responsive-item proposal_video_ifram <?php echo $iframVideoClass; ?>" data-video-type="<?=$videoType;?>" video_id="<?php echo $video->getId(); ?>"  id="embed-responsive-video-<?php echo $video->getId(); ?>" src="<?php echo $finalUrl . $autoplay; ?>" allowfullscreen loading="lazy" allow="autoplay" ></iframe>
    </div>
</div>
<!--End Proposal Video Opens here -->

<?php
    }
    }
    ?>
        <!--End Proposal Video Opens here -->

        


    </div>
</div>


</div>
</div>

<!--Signature submit Modal popup-->
<div class="modal fade" id="submitSignModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width:33%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Proposal Signed. We will email you a copy of the document</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><i
                            class="fa fa-fw fa-check-circle"></i> Ok
                </button>

            </div>
        </div>
    </div>
</div>

<!--Ask Question Modal popup-->
<div class="modal fade" id="submitAskQuestionModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" style="width:33%">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Your Question successfully sent to User</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><i
                            class="fa fa-fw fa-check-circle"></i> Ok
                </button>

            </div>
        </div>
    </div>
</div>


<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo site_url('static') ?>/js/signature/signature_pad.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="<?php echo site_url('3rdparty/moment/moment.js') ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script type="text/javascript" src="<?php echo site_url('3rdparty/sweetalert/sweetalert2.min.js'); ?>"></script>

<script type="text/javascript">
    var site_url = '<?php echo site_url() ?>';
    var uuid = '<?php echo $uuid;?>';
    var track_activity = '0';
    var showPreProposalPopup = '<?php if (isset($showPreProposalPopup)) {
        if ($showPreProposalPopup == 1) {
            echo 1;
        } else {
            echo 0;
        }
    } else {
        echo 0;
    };?>';

    var updateInterval = <?php echo $_ENV['PROPOSAL_STATS_UPDATE_INTERVAL'];?>;
    var proposalViewId;
    var nosidebar = '1';
    var YTplayer;
    var Vplayer;
    var videoType = '<?php echo $videoType;?>';
    var lastUpdatedTime = moment();
    var lastActionTime = moment();
    var lastUpdateCheckTime = moment();
    var videoPlayingTime = 0;
    var videoPlayertimer;
    var videoPaused = false;
    var is_wo_page = true;
    var currentVideoId = 0;

    videoPlayerCounterFunction = function () {
        video_object[currentVideoIndex].duration++;

        videoPlayertimer = setTimeout(function () {
            videoPlayerCounterFunction();
        }, 1000);
    };


var geocoder;
var map;
var address = "<?=$to;?>";

function initialize() {
  geocoder = new google.maps.Geocoder();
  var latlng = new google.maps.LatLng(-34.397, 150.644);
  var myOptions = {
    zoom: 15,
    center: latlng,
    gestureHandling: 'greedy',
    mapTypeControl: true,
    mapTypeControlOptions: {
      style: google.maps.MapTypeControlStyle.DROPDOWN_MENU
    },
    navigationControl: true,
    mapTypeId: google.maps.MapTypeId.ROADMAP
  };
  map = new google.maps.Map(document.getElementById("map_canvas"), myOptions);
  if (geocoder) {
    geocoder.geocode({
      'address': address
    }, function(results, status) {
      if (status == google.maps.GeocoderStatus.OK) {
        if (status != google.maps.GeocoderStatus.ZERO_RESULTS) {
          map.setCenter(results[0].geometry.location);

          var infowindow = new google.maps.InfoWindow({
            content: '<b>' + address + '</b>',
            size: new google.maps.Size(150, 50)
          });

          var marker = new google.maps.Marker({
            position: results[0].geometry.location,
            map: map,
            title: address
          });
          google.maps.event.addListener(marker, 'click', function() {
            infowindow.open(map, marker);
          });

        } else {
          
          swal('',"Driving directions could not be loaded for this location");
        }
      } else {
        swal('',"Driving directions could not be loaded for this location");
      }
    });
  }
}
google.maps.event.addDomListener(window, 'load', initialize);
function showDiraction(){

var directionsService = new google.maps.DirectionsService();
         var directionsDisplay = new google.maps.DirectionsRenderer();

         var map = new google.maps.Map(document.getElementById('map_canvas'), {
           zoom:7,
           mapTypeId: google.maps.MapTypeId.ROADMAP
         });

         directionsDisplay.setMap(map);
         //directionsDisplay.setPanel(document.getElementById('panel'));

         var request = {
           origin: '<?=$from;?>',
           destination: '<?=$to;?>',
           travelMode: google.maps.DirectionsTravelMode.DRIVING
         };

         directionsService.route(request, function(response, status) {
           if (status == google.maps.DirectionsStatus.OK) {
             directionsDisplay.setDirections(response);
           }
         });
}

$(document).ready( function(){
    $('.btn-toggle2').click( function() {

        var toggleheight = $("#infoHeader2").height() == 35 ? "120px" : "55px";
        console.log(toggleheight);
        $('#infoHeader2').animate({ height: toggleheight });
        var toggleIcon = $('.btn-toggle2').attr('aria-expanded') =='true' ? false : true;
        console.log(toggleIcon);
        $('.btn-toggle2').attr('aria-expanded',toggleIcon);

    });

    $('.btn-toggle3').click( function() {

    var toggleheight = $("#infoHeader2").height() == 25 ? "270px" : "65px";
    console.log(toggleheight);
    $('#infoHeader2').animate({ height: toggleheight });
    var toggleIcon = $('.btn-toggle2').attr('aria-expanded') =='true' ? false : true;
    console.log(toggleIcon);
    $('.btn-toggle2').attr('aria-expanded',toggleIcon);

});
});

<?php 
foreach ($services as $service) {
    if(isset($service_images[$service->getServiceId()])){
    ?>
            
    var serviceImageCanvas<?=$service->getServiceId();?> = document.getElementById('service_image_offcanvas_<?=$service->getServiceId();?>');
    serviceImageCanvas<?=$service->getServiceId();?>.addEventListener('show.bs.offcanvas', function (event) {
        if($('#sizer').find('div:visible').data('size')=='xs'){
            event.stopPropagation();
            event.preventDefault();
        }

    })

<?php } }?>
</script>

<script src="<?php echo site_url('static/js/preview-proposal-video-tracking-youtube.js'); ?>"></script>

<script src="https://player.vimeo.com/api/player.js"></script>
<script src="<?php echo site_url('static/js/preview-proposal-video-tracking-vimeo.js'); ?>"></script>

<script src="<?php echo site_url('static') ?>/js/preview-proposal.js"></script>
</body>
<div class="justify-content-center service_check_loader loader_overlay" style="display:none" ;>
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
</html>
<?php die; ?>