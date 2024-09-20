<!DOCTYPE html>
<html lang="en">
<?php //echo $layout; die;?>
<head>
 
    <?php
    $headerFont = '';
    $bodyFont = '';
    if ($proposal->getLayout() == 'cool') {
        $headerFont = $proposal->getClient()->getCompany()->getCoolHeaderFont();
        $bodyFont = $proposal->getClient()->getCompany()->getCoolTextFont();
    } else if ($proposal->getLayout() == 'standard') {
        $headerFont = $proposal->getClient()->getCompany()->getStandardHeaderFont();
        $bodyFont = $proposal->getClient()->getCompany()->getStandardTextFont();
    } else {
        $headerFont = $proposal->getClient()->getCompany()->getHeaderFont();
        $bodyFont = $proposal->getClient()->getCompany()->getTextFont();

    }

    

        $havetexts = false;
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
                    
                    

    ?>
    <meta charset="utf-8">
    <!--  This file has been downloaded from bootdey.com    @bootdey on twitter -->
    <!--  All snippets are MIT license http://bootdey.com/license -->
    <title><?php echo $proposal->getProjectName() ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="<?php echo site_url('static') ?>/css/signature-pad.css">
    <link rel="stylesheet" href="<?php echo site_url('3rdparty/fontawesome/css/font-awesome.min.css') ?>">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700&family=Hind:wght@400;500&family=Roboto:wght@300;400;500;600;700&display=swap"
          rel="stylesheet">
    
          <link rel="stylesheet" href="<?php echo site_url('static') ?>/css/proposal.css?<?php echo time(); ?>">

    <?php
    if ($nosidebar) {
        ?>

        <style>
             .imageContain
            {
                padding:0px;
                object-fit:cover;
                height:280px;
                width:100%;
           }

            .image-section{
                float:left;
                padding: 0 10px;
                max-height:none!important;
            }

            .img_service_mobile
            {
                object-fit: cover;
                padding-right: 0px;
                padding-left: 0;
                height:150px;
                width: 100%;
            }

            #doc-section {
                font-family: Lato, sans-serif, sans-serif!important;
            }

            @media all and (max-width: 1024px) and (max-height: 768px) {
                .ipad_hide {
                    display: none !important;
                }

                .header_project_name {
                    width: 40% !important;
                }

                .info_header_buttons {
                    width: 35% !important;
                }

                .header-info-btn {
                    display: block !important;
                }

                #infoHeader {
                    z-index: 2 !important;
                }

                #navbar-example3 {
                    z-index: 3 !important;
                }

                            /* show default layout 1 on mobile view */
                .image-section{
                float:none!important;
                } 

                .carousel-img {
                   height:unset!important; 
                   margin-top: 30px!important;
                }

                #proposalCarousel {
                margin: 18% 0px!important;
                }

                #offcanvasRight2 .carousel-control-prev, #offcanvasRight2 .carousel-control-next {
                    margin-top: unset!important; 
                    height: unset!important;
                    }
                  

                   
                    .aboutus span {
                        font-size:15px!important;
                        font-family: Lato, sans-serif, sans-serif!important;

                    }

                    h1.title_big_aboutus {
                        font-size: 34px!important;
                        padding-top: 76px!important;
                    }
 
                    #doc-section {
                        /* font-family:unset!important; */
                        font-family: Lato, sans-serif, sans-serif !important;
                    }
 

                    .company-info-section p{
                        font-family: Lato, sans-serif, sans-serif!important;
                    }
                    .contact-person-section p{
                        font-family: Lato, sans-serif, sans-serif!important;
                    }

                    #doc-section h2 {
                        margin: 15.5px 0px!important;
                    }

                    .html5-video-container {
                    width: 250px!important;
                    }

                    .VideoPlayersOffcanvas {
                width: 100% !important;
            }
        
           
            }

        </style>
    <?php } ?>
    <style type="text/css">
        body {
            /* font-family:
        <?php echo $bodyFont; ?> , sans-serif!important; */
            font-weight: 500;
            background: #41464b;
            position: relative;
            font-size: 13px;
            line-height: 1.1;
            color: #000;
        }
        
        
        <?php
        $i =1;
        $page_counter = 1;
        $layoutArray = array(1,2,4);
        $counterArray = [];
        $currentPageSpace = 0;
        $pageSpaceThreshold = 100;
        $attachments = $proposal->getAttatchments();
            foreach($proposalSections as $proposalSection){

                 echo '#'.$proposalSection->section_code.'{order:'.$i.'!important}
                 ';
                echo 'li[data-page-id="'.$proposalSection->section_code.'"] {order:'.$i.'!important}
                ';
                
                if($i % 2 != 0){
                    
                    echo 'li[data-page-id="'.$proposalSection->section_code.'"] {background: rgba(0, 0, 0, 0.05);}
                    ';
                    
                }
                
                if($proposalSection->p_visible == 0){
                    echo '#'.$proposalSection->section_code.'{display:none!important}
                    ';
                    echo 'li[data-page-id="'.$proposalSection->section_code.'"] {display:none!important}
                    ';
                    
                }else{
                    
                    $counterArray[$proposalSection->section_code] = $page_counter;


                    switch ($proposalSection->section_code) {
                        case 'images':
                            if (count($images)) {
                                $count =  0;
                                foreach ($images as $k => $image) {
                                    if ($images[$k]['image']->getActive()) {
                                        
                                        if (file_exists($images[$k]['path'])) {
                                            
                                            $imgLayout = $layoutArray[$images[$k]['image']->getImageLayout()];
                                            if ($currentPageSpace ==0){
                                               
                                                $count++;
                                            }
                                            $currentPageSpace += (100 / $imgLayout);

                                           
                                            if($currentPageSpace  > 90){
                                                $currentPageSpace = 0;
                                                    
                                               }
                                                  
                                        }
                                    }
                                }
                                
                                $page_counter = $page_counter+$count;
                            }
                            break;
                        case 'map_images':
                            if (count($map_images)) {
                                $page_counter++;
                            }
                            break;
                        case 'audit-section':
                            if ($proposal->getAuditKey()) {
                                $page_counter++;
                            }
                            break;
                        case 'intro_video':
                            if ($proposal_intro_video) {
                                $page_counter++;
                            }
                            break;
                        case 'attachments':
                                if (count($attachments) || count($proposal_attachments)) {
                                    $page_counter++;
                                }
                            break;
                        case 'additional-info-section':
                                if ($havetexts) {
                                    $page_counter++;
                                }
                            break;
                        case 'video':
                                if (count($proposal_videos)) {
                                    $page_counter++;
                                }
                            break;    
                        default:
                                $page_counter++;
                            break;

                    }

                    
                }

                
                $i++;
                
            }

        ?>

.table-responsive {
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}

.cool_table {
    width: 100%;
    border-collapse: collapse;
}

.cool_table td, .cool_table th {
    padding: 8px;
    border: 1px solid #ddd;
}

@media (max-width: 768px) {
    .table-responsive {
        width: 100%;
        overflow-x: scroll;
    }

    .cool_table {
        width: 100%;
        min-width: 600px; /* Set the min-width to enable scrolling */
    }
}


       #submitAskQuestionModal .modal-dialog, #submitSignModal .modal-dialog{
            width:33%;
        }
        #doc-section h1 {
            /* font-size: 24px; */
            font-family: <?php echo $headerFont ?>, Sans-Serif !important;
            font-weight: bold;
            margin: 25.56px 0px;
        }

        #doc-section h2 {
            font-size: 20px;
            font-family: <?php echo $headerFont ?>, sans-serif !important;
            font-weight: bold;
            margin: 25.56px 0px;
        }

        #doc-section h3 {
            font-family: <?php echo $headerFont ?>, sans-serif !important;
            font-size: 17px;
            font-weight: bold;
            margin: 25.56px 0px;
        }

        #doc-section {
            font-family: <?php echo $bodyFont; ?>, sans-serif !important;
            display: flex; flex-flow: wrap;
        }

        #videoURL {
            display: none;
        }

        .only_show_print {
            display: none;
        }


        @media all and (min-width: 320px) and (max-height: 430px) and (orientation: portrait) {
            
            #doc-section {
                        font-family: Lato, sans-serif, sans-serif !important;
                    }

                    #doc-section .title_big_title{
                        font-size:26px!important;
                    }
                   
                    
                    #doc-section h1.service_provider_title {
                        font-size: 30px!important;
                    }
                    #doc-section h1.title_big_aboutus {
                        font-size: 32px!important;
                        padding-top: 76px!important;
                    }

                    #doc-section .aboutus span {
                        font-size: 14px!important;
                     }
 
                     #doc-section h1.title_big{
                        padding-top: 20px !important;
                        font-size:36px!important;
                    }

                    #doc-section h1 {
                        margin: 5px 6px 12px 0px;
                        font-family: Lato, sans-serif, sans-serif !important;
                        font-size:20px!important;
                    }

                    #doc-section h2 {
                        margin: 10.5px 0px 20px 0px;
                        font-family: Lato, sans-serif, sans-serif !important;
                        font-size:18px!important;
                    }

                    #doc-section h3 {
                    margin: 5.5px 0px;
                    font-family: Lato, sans-serif, sans-serif !important;
                    }
            /* show default layout 1 on mobile view */
            .image-section{
                float:none!important;
            } 
           
            .customer-checklist-table .span-data {
                  margin-left: unset!important;  
             }

            td.span-data2 {
                  padding-left: unset!important; 
            }
 
            .customer-checklist-table th, td {
                padding:unset!important;
            }
 
            .customer-checklist-table .span-label {
                width: 172px!important;
            }

            table tr {
                float:left;
                margin-top:5px;
            }

            .customer-checklist-table .billing-email{
               width: 102px !important;
             }

            
                .carousel-img {
                    object-fit: contain;
                    height:unset!important;
                }

                .pdf-height{
                    min-height:unset!important;
                }

                #add_update_checklist {
                    margin-left: 180px !important;
                }

            .new-popup-close-btn {
            top: 22px !important;
            right: 22px !important;
            z-index: 9999;
            }
                        

            
        }
 

        @media all and (min-width: 375px) and (min-height: 667px) and (orientation: portrait) {
            

            #doc-section h1 {
            margin: 5.5px 0px;
            font-size:28px!important;
            }

            #doc-section h2 {
            margin: 5.5px 0px;
            }

            #doc-section h3 {
            margin: 5.5px 0px;
            }
            /* show default layout 1 on mobile view */
            .image-section{
                float:none!important;
            } 
           
            .customer-checklist-table .span-data {
                  margin-left: unset!important;  
             }

            td.span-data2 {
                  padding-left: unset!important; 
            }
 
            /* .customer-checklist-table th, td {
                padding:unset!important;
            } */
 
            .customer-checklist-table .span-label {
                width: 172px!important;
            }

            table tr {
                /* float:left; */
                margin-top:5px;
            }

          

            .customer-checklist-table .billing-email{
               width: 102px !important;
             }

            
                .carousel-img {
                    object-fit: contain;
                    height: calc(100vh - 60vh);
                }

                .pdf-height{
                    min-height:unset!important;
                }
             

            
        }
        @media all and (min-width: 768px) and (min-height: 1024px) and (orientation: portrait) {

            .ipad_hide {
                display: none !important;
            }

            .header-client-name {
                display: block !important;
            }

            .embed-responsive-item.audit-full-height {
                height: calc(100vh - 40px) !important;
            }

            .canvas-back-right-btn {
                right: 10px;
            }

            #followTab2 {
                width: 45px;
            }

            .ftSpan i {
                font-size: 38px !important;
            }

            .embed-responsive-16by9 .play-overlay {
                opacity: 1;
            }

            .VideoPlayersOffcanvas {
                width: 85% !important;
            }

            .sectionChanger {
                display: none !important;
            }

            .mg-left-55 {
                margin-left: 0;
            }

            .info_header_buttons {
                width: 40%
            }

            .header_project_name {
                width: 35%
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
            .play-overlay {
                z-index: 1;
            }

            .video img {
                z-index: 1;
            }

            .proposal_video_ifram {
                min-height: 360px
            }
        }


        @media all and (max-width: 1024px) and (min-height: 768px) and (orientation: landscape) {
            /* .title_big { color: blue; }  */
            .embed-responsive-16by9 .play-overlay {
                opacity: 1;
            }

            .header-client-name {
                display: block !important;
            }

            .canvas-back-right-btn {
                right: 10px;
            }

            .embed-responsive-item.audit-full-height {
                height: calc(100vh - 40px) !important;
            }

            .ipad_hide {
                display: none !important;
            }

            .sectionChanger {
                display: none !important;
            }

            .mg-left-55 {
                margin-left: 0;
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

            .proposal_video_ifram {
                min-height: 285px !important;
            }

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
            #navToggleBtn {
                z-index: 101;
            }

            #navbar-example3 {
                z-index: 100;
            }

            #infoHeader {
                z-index: 99;
            }

            .play-overlay {
                z-index: 1;
            }

            .video img {
                z-index: 1;
            }

            .item-content-texts a
                    {
                        font-size: 0.9em!important;
                    }

                    
        }

        @media all and (max-width: 1024px) and (min-height: 1366px) and (orientation: portrait) {
            #navToggleBtn {
                z-index: 101;
            }

            #navbar-example3 {
                z-index: 100;
            }

            #infoHeader {
                z-index: 99;
            }
        }

        @media all and (max-width: 600px) and (min-height: 1024px) and (orientation: portrait) {
            .ipad_hide {
                display: none !important;
            }

            .header-client-name {
                display: block !important;
            }

            .embed-responsive-item.audit-full-height {
                height: calc(100vh - 40px) !important;
            }

            .canvas-back-right-btn {
                right: 10px;
            }

            #followTab2 {
                width: 45px;
            }

            .ftSpan i {
                font-size: 38px !important;
            }

            .embed-responsive-16by9 .play-overlay {
                opacity: 1;
            }

            .VideoPlayersOffcanvas {
                width: 85% !important;
            }

            .sectionChanger {
                display: none !important;
            }

            .mg-left-55 {
                margin-left: 0;
            }

            .info_header_buttons {
                width: 20%
            }

            .header_project_name {
                width: 50%
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
                width: 40%;
                z-index: 3;
            }

            .sidebar-close {
                left: 35%;
            }

            .closeNav {
                right: 65%
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
                display: contents;
            }

            .button-text {
                display: none;
            }

            .play-overlay {
                z-index: 1;
            }

            .video img {
                z-index: 1;
            }

            .proposal_video_ifram {
                min-height: 360px
            }
        }

        @media all and (max-width: 390px) and (max-height: 844px) and (orientation: portrait) {
            /* #doc-section h1 {
            margin: 5.5px 0px;
            }

            #doc-section h2 {
            margin: 5.5px 0px;
            }

            #doc-section h3 {
            margin: 5.5px 0px;
            } */

            .customer-checklist-table .span-data {
                  margin-left: unset!important;  
             }

            td.span-data2 {
                  padding-left: unset!important; 
            }


            

            .customer-checklist-table th, td {
                padding:unset!important;
            }
               
                span {
                    line-height: unset!important;
             }

             #doc-section {
                        font-family: Lato, sans-serif, sans-serif !important;
                    }

                    #doc-section .title_big_title{
                        font-size:26px!important;
                    }
                   
                    
                    #doc-section h1.service_provider_title {
                        font-size: 30px!important;
                    }
                    #doc-section h1.title_big_aboutus {
                        font-size: 32px!important;
                        padding-top: 76px!important;
                    }

                    #doc-section .aboutus span {
                        font-size: 16px!important;
                     }
 
                     #doc-section h1.title_big{
                        padding-top: 20px !important;
                        font-size:36px!important;
                    }

                    #doc-section h1 {
                        margin: 5px 6px 12px 0px;
                        font-family: Lato, sans-serif, sans-serif !important;
                        font-size:20px!important;
                    }

                    #doc-section h2 {
                        margin: 10.5px 0px 20px 0px;
                        font-family: Lato, sans-serif, sans-serif !important;
                        font-size:18px!important;
                    }

                    #doc-section h3 {
                    margin: 5.5px 0px;
                    font-family: Lato, sans-serif, sans-serif !important;
                    }

        }


        @media all and (max-width: 480px) and (max-height: 932px) and (orientation: portrait) {
            
            .mt2rem{
                margin-top: 0px!important;
                max-height:1050px!important;
                height:450px!important;
            }
             #add_update_checklist {
                margin-left: 246px!important;
            }
            #submitChecklistModal .modal-dialog {
                width: 100%!important;
                margin-left: 50px!important;;
            }
            #submitAskQuestionModal .modal-dialog, #submitSignModal .modal-dialog
            {
                width:100%!important;
                margin-left: 50px!important;;

            }
            .modal {
                top:-100px!important;
            }
            span {
                    line-height: unset!important;
             }

             .customer-checklist-table .span-label {
                 width: 172px !important;
               }

               #doc-section {
                        font-family: Lato, sans-serif, sans-serif !important;
                    }

                    #doc-section .title_big_title{
                        font-size:26px!important;
                    }
                   
                    
                    #doc-section h1.service_provider_title {
                        font-size: 30px!important;
                    }
                    #doc-section h1.title_big_aboutus {
                        font-size: 32px!important;
                        padding-top: 76px!important;
                    }

                    #doc-section .aboutus span {
                        font-size: 14px!important;
                     }
 
                     #doc-section h1.title_big{
                        padding-top: 20px !important;
                        font-size:36px!important;
                    }

                    #doc-section h1 {
                        margin: 5px 6px 12px 0px;
                        font-family: Lato, sans-serif, sans-serif !important;
                        font-size:20px!important;
                    }

                    #doc-section h2 {
                        margin: 10.5px 0px 20px 0px;
                        font-family: Lato, sans-serif, sans-serif !important;
                        font-size:18px!important;
                    }

                    #doc-section h3 {
                    margin: 5.5px 0px;
                    font-family: Lato, sans-serif, sans-serif !important;
                    }


        }

     

        
        @media all and (max-width: 414px) and (max-height: 896px) and (orientation: portrait) {
                    #doc-section {
                        font-family: Lato, sans-serif, sans-serif !important;
                    }

                    #doc-section .title_big_title{
                        font-size:26px!important;
                    }
                   
                    
                    #doc-section h1.service_provider_title {
                        font-size: 30px!important;
                    }
                    #doc-section h1.title_big_aboutus {
                        font-size: 32px!important;
                        padding-top: 76px!important;
                    }

                    #doc-section .aboutus span {
                        font-size: 14px!important;
                     }
 
                     #doc-section h1.title_big{
                        padding-top: 20px !important;
                        font-size:36px!important;
                    }

                    #doc-section h1 {
                        margin: 5px 6px 12px 0px;
                        font-family: Lato, sans-serif, sans-serif !important;
                        font-size:20px!important;
                    }

                    #doc-section h2 {
                        margin: 10.5px 0px 20px 0px;
                        font-family: Lato, sans-serif, sans-serif !important;
                        font-size:18px!important;
                    }

                    #doc-section h3 {
                    margin: 5.5px 0px;
                    font-family: Lato, sans-serif, sans-serif !important;
                    }
          
                    .mt2rem{
                        margin-top: 0px!important;
                        max-height:1050px!important;
                        height:450px!important;
                    }
                    #add_update_checklist {
                        margin-left: 246px!important;
                    }
                    #submitChecklistModal .modal-dialog {
                        width: 100%!important;
                        margin-left: 50px!important;;
                    }
                    #submitAskQuestionModal .modal-dialog, #submitSignModal .modal-dialog
                    {
                        width:100%!important;
                        margin-left: 50px!important;;

                    }
                    .modal {
                        top:-100px!important;
                    }

                    .pdf-height{
                            min-height:unset!important;
                        }

                    #offcanvasRight2 .carousel-control-prev, #offcanvasRight2 .carousel-control-next {
                    margin-top: unset!important;
                    height:unset!important;
                    } 
                    .carousel-caption{
                        position:unset!important;
                    }

                    .company_signature_td {
                    height: unset!important;
                    } 

                    .item-content-texts a
                    {
                        font-size: 0.9em!important;
                    }

                    #doc-section h2.company_name{
                    font-size: 30px !important;
                    }

                    #doc-section  h1#service_provider_title{
                        font-size:34px!important;
                    }

                }

        
        @media all and (max-width: 414px) and (max-height: 823px) and (orientation: portrait) {
            .sectionChanger {
                display: none !important;
               
            }
             

           #submitAskQuestionModal .modal-dialog, #submitSignModal .modal-dialog{
                margin: auto;
                width:100%;
            }

           #submitAskQuestionModal, #submitSignModal {
                width:100%;
            }

            .embed-responsive-16by9 .play-overlay {
                opacity: 1;
            }
            .mt2rem{
                margin-top: 0px!important;
                max-height:900px!important;
                height:230px!important;
            }
             #add_update_checklist {
                margin-left: 210px!important;
            }
            #submitChecklistModal .modal-dialog {
                width: 100%!important;
                margin-left: 50px!important;;
            }
                .customer-checklist-table .span-data {
                  margin-left: unset!important;
                }
                td.span-data2 {
                   padding-left: unset!important;
                }
            .other_signature_td h5{
                font-size: 16px!important;
            }
            .other_signature_td{
                margin-bottom: 20px!important;
                margin-top: 20px!important;
            }
            .company_name{
                font-size: 24px!important;
            }
            .company_owner{
                font-size: 17px!important;
            }
            .company_owner1{
                font-size: 15px!important;
            }
            .company_owner2{
                font-size: 17px!important;
            }
            
            
            .property_heading {
                height: 95px !important;
                text-align: center !important;
                padding-left: 0px !important;
                padding-right: 0px !important;
                padding-bottom: 50px !important;
            }

            .property_heading a {
                right: 38.7% !important;
                top: 150px !important;
            }

            .image-section > div {
                width: 100% !important;
            }

            /* .image-section .showProposalCarousel {
                height: auto !important;
            } */

            /* .image-section-inlarge-text {
                display: none;
            } */

            .image-note-section-info {
                display: none !important;
            }

            .image-section-info {
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

            #mobileImageInfo {
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

            .canvas-back-right-btn {
                right: 10px;
            }

            .embed-responsive-item.audit-full-height {
                height: calc(100vh - 40px) !important;
            }

            .aboutus {
                /* max-height: 150px; */
                margin-bottom: 5px;
                /* overflow: hidden; */
            }

            .fullText {
                max-height: none !important;
            }

            #about_us_read_more {
                display: block;
                margin-left: 75%;
                width: 95px;
            }

            .company-info-section h2 {
                margin-top: 15px;
            }

            .company-info-section img {
                display: none;
            }

            .contact-person-section h2 {
                margin: 20px 0px;
            }

            .info_header_logo {
                width: 33%;
            }

            .header_project_name {
                width: 60%;
                padding-top: 0px;
                display: flex;
                align-items: center;
            }

            .info_header_client_details {
                display: none;
            }

            .info_header_buttons {
                display: none;
            }

            .info_header_logo img {
                width: 100 !important;
            }

            h1.underlined {
                margin-top: 0px;
                margin-bottom: 10px;
            }

            .container-fluid {
                padding-left: 5px;
                padding-right: 5px;
            }

            .ipad_sidebar_space {
                margin-top: 50px !important;
            }

            .doc-section {
                margin-top: 5px;
            }

            #infoHeader.grid {
                width: 100% !important;
                position: sticky;
                z-index: 9 !important;
                padding: 5px 17px !important;
                min-height: 55px;
            }

            .mobile-text-right {
                text-align: right;
            }

            .play-overlay {
                z-index: 0!important;
            }

            .mg-left-55 {
                margin-left: 0;
            }

            /* .title_big { color: yellow; }  */
            .VideoPlayersOffcanvas {
                width: 100% !important;
            }

            .small_device_hide {
                display: none !important;
            }

            .mobile_img {
                display: block;
            }

            .mobile-menu {
                z-index: 99 !important;
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
                display: block!important;
            }

            .phone-potrait-margin-0 {
                margin: 0px;
            }

            #offcanvasRight {
                width: 90%;
                height: 600px !important;
            }

            #offcanvasRight3 {
                width: 90%;
            }

            #offcanvasRight2 {
                width: 100%;
            }

            #offcanvasRight4 {
                width: 90%;
            }

            #serviceOffcanvasRight {
                width: 85%!important;
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

            .proposal_video_ifram {
                min-height: 100% !important;
            }


            /* .show_only_mobile {
                display: inline !important;
            } */

            .table-striped td:nth-child(3) {
                /* display: none; */
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

            .video_title {
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
                padding-bottom: 30px !important;
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
                margin-bottom: 20px;
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
            #inspection_btn{
                margin-top: 2px!important;
                /* right: 2px!important; */
                padding: 3px!important;
            }

            .pdf-height{
                    min-height:unset!important;
                }

                #offcanvasRight2 .carousel-control-prev, #offcanvasRight2 .carousel-control-next {
                margin-top: unset!important;
                height:unset!important;
                }

                .carousel-caption{
                    position:unset!important;
                }

                .company_signature_td {
                 height: unset!important;
                 }

                 #doc-section h1 {
                margin: 5px 6px 12px 0px;
            }

            #doc-section h2 {
                margin: 10.5px 0px 20px 0px;
            }


        }

        @media all and (max-width: 823px) and (max-height: 414px) and (orientation: landscape) {
            /* .title_big { color: red; } */
            .embed-responsive-16by9 .play-overlay {
                opacity: 1;
            }

            .canvas-back-right-btn {
                right: 30px;
            }

            .header-client-name {
                display: block !important;
            }

            .embed-responsive-item.audit-full-height {
                height: calc(100vh - 40px) !important;
            }

            #offcanvasRight2 .offcanvas-header {
                display: none !important;
            }

            #offcanvasRight2 .carousel-caption {
                display: none !important;
            }

            #offcanvasRight2 .offcanvas-body {
                padding-top: 0;
                padding-bottom: 0;
            }

            #offcanvasRight2 .pd-top-25 {
                padding-top: 3px;
            }

            #proposalCarousel {
                margin-top: 0px;
            }

            .mobile_landscape_image_close_btn {
                display: block;
                position: absolute;
                right: 0px;
                font-size: 25px;
                z-index: 999;
            }

            #followTab2 {
                width: 45px;
            }

            .play-overlay {
                z-index: 1;
            }

            .small_device_hide_l {
                display: none !important;
            }

            .ftSpan {
                top: 40% !important;
            }

            .VideoPlayersOffcanvas {
                width: 73% !important;
            }

            .video_player_iframe_body {
                padding-bottom: 44.25% !important;
            }

            .sectionChanger {
                display: none !important;
            }

            .mg-left-55 {
                margin-left: 0;
            }

            .mobile-menu {
                z-index: 2 !important;
            }

            .proposal_video_ifram {
                min-height: 260px !important;
            }

            .info_header_buttons {
                width: 40%;
                padding-left: 0;
                padding-right: 0;
            }

            .header_project_name {
                width: 35%
            }

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
                height: 400px !important;
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
                height: 98vh !important;
            }

            .proposal-details {
                margin-bottom: 20px;
                width: 100%;
            }

            /* #add_signature {
                margin: 0px 40%;
            } */

            #offcanvasRight2 .carousel-control-prev, #offcanvasRight2 .carousel-control-next {
                margin-top: unset!important;
                height:unset!important;
                }

                .carousel-caption{
                    position:unset!important;
                }

                .company_signature_td {
                 height: unset!important;
                 }

        }

        @media print {

            #print_msg {
                display: block !important;
                font-size: 20px;
                font-weight: bold;
                margin: auto;
                text-align: center;
                position: absolute;
                top: 50%;
            }

            #print_msg h1 {
                font-size: 40px;
            }

            .note_print {
                margin-top: 50px;
                font-weight: 100;
                font-size: 35px;
            }

            .boxed-section {
                display: none;
            }

            nav {
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

        .header-client-name {
            display: none;
            margin-bottom: 5px;
        }

        .show_only_mobile {
            display: none;
        }

        .servicePopupImageNote, .image-note-section-info {
            display: block;
            position: absolute;
            bottom: 1px;
            right: 90px;
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

        /*
        .image-pinch-back{
                    display: none;
                    position: absolute;
                    bottom: 1px;
                    right: 2px;
                    color: #fff;
                    background: #000000a3;
                    width: 50px;
                    cursor: pointer;
                    height: 25px;
                    text-align: center;
                    text-decoration: none;
                    font-size: 18px;
                    margin-top: 1px;
                    border-radius: 5px 5px 0px 0px;
                    } */
        .item_note div > .close:after {
            top: -5px;
            right: 0;
            position: absolute;
            font-size: 19px;
            cursor: pointer;
            content: "\00d7";
        }

    

        .image-section-notes > .close:after {
            top: -5px;
            right: 0;
            position: absolute;
            font-size: 19px;
            cursor: pointer;
            content: "\00d7";
        }

        @media all and (max-width: 1300px) {
            .ipad_hide {
                display: none !important;
            }
        }

        @media all and (max-width: 1024px) and (orientation: portrait) {
            #navbar-example3 {
                width: 0%;
            }

            #navToggleBtn {
                right: calc(100%);
            }

            .boxed-section {
                width: 100%;
            }

            .ipad_sidebar_space {
                margin-top: 60px !important;
            }

            #sizer_ipad {
                display: block !important;
            }
        }

        #sizer_ipad {
            display: none;
        }
        /* customer check list css */

        .center-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: left;

         }
        .header_fix {
            z-index: 200;
            font-size: 16px;
           }
     
     
        .customer-checklist-table th, td {
            /* padding: 8px; */
            line-height: 2;
            text-align: left;
 
        }
        .customer-checklist-table .span-label {
            width: 150px;
            float: left;
            font-size: 14px;
        }
        .customer-checklist-table .span-data {
            margin-left: 42px;
            text-align: left;
 
        } 

        td.span-data2 {
            padding-left: 42px;
            text-align: left;
 
        } 

       .heading{
        font-size: 18px;
       }
   
        .boxed-table label span {
        color: #f00!important;
    }

    .boxed-table label {
        width: 140px;
        margin-right: 10px;
        display: block;
        text-align: right;
        font-weight: bold;
        line-height: 28px;
    }
    .ui-widget {
        font-family: Helvetica, Arial, sans-serif;
        font-size: 1.1em;
    }
 

    #submitChecklistModal .modal-dialog {
        width: 33%;
    }
        /*customer check list css close */

           /* CSS for Mobile Devices */
@media (max-width: 767px) {
    /* Adjust font size and padding for responsiveness */
    .offcanvas-header legend,
    .offcanvas-body h4 {
        font-size: 16px;
        margin: 7px 0px 20px 4px;
    }
    .offcanvas-body .form-label {
        font-size: 14px;
    }
    .offcanvas-body .form-control {
        font-size: 14px;
        padding: .375rem .75rem;
    }
    /* Adjust textarea height for mobile devices */
    .offcanvas-body textarea {
        height: 100px;
    }
}

/* CSS for Adjusting Zooming Level */
@media (max-width: 480px) {
    /* Set initial-scale to adjust zooming level */
    @viewport {
        width: device-width;
        initial-scale: 0.8; /* Adjust this value as needed */
        user-zoom: fixed;
    }
}
    </style>
    <!-- <link rel="stylesheet" href="<?php echo site_url('static') ?>/css/proposal.css?<?php echo time(); ?>"> -->
</head>

<div id="sizer">
    <div class="d-block d-sm-none d-md-none d-lg-none d-xl-none" data-size="xs"></div>
    <div class="d-none d-sm-block d-md-none d-lg-none d-xl-none" data-size="sm"></div>
    <div class="d-none d-sm-none d-md-block d-lg-none d-xl-none" data-size="md"></div>
    <div class="d-none d-sm-none d-md-none d-lg-block d-xl-none" data-size="lg"></div>
    <div class="d-none d-sm-none d-md-none d-lg-none d-xl-block" data-size="xl"></div>
</div>
<div id="sizer_ipad"></div>
<body>
<input type="hidden"  id="cusomterChecklist" value="<?php echo $checkProposalChecklist; ?>">
<div id="print_msg">
    <div><h1>Print Instructions</h1></div>
    <img width="800px" src="<?php echo site_url('static/images/print_guide.png'); ?>">
    <div class="note_print"><p>Please use the print button on the page as shown. <br/><br/>This will generate a secure
            PDF for you to print.</p></div>
</div>
<div id="trackingPointerLine"
     style="display: none; height: 10px; position: fixed; width: 100%; top:315px; background-color: red; z-index: 999999"></div>
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
$print_pdf_url = site_url('proposals/live/preview/' . $print_layout . '/plproposal_' . $proposal->getAccessKey() . '.pdf/print');
?>
<div class="divider">
    <div class="inner"></div>
</div>
<a href="javascript:void(0)" class="mobile-menu openMobileNav"><i class="fa fa-bars" aria-hidden="true"></i></a>
<a href="javascript:void(0)" class="back-to-top print_hide" data-container="body"><i class="fa fa-chevron-up"></i></a>
<a href="javascript:void(0)" class="btn-pause print_hide" data-container="body" data-bs-toggle="tooltip"
   data-bs-placement="left"
   title="Pause All"><i class="fa fa-pause"></i></a>
<a href="javascript:void(0)" class="btn-zoom zoom print_hide small_device_hide ipad_hide small_device_hide_l"
   data-container="body"
   data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom In"><i class="fa fa-plus"></i></a>
<a href="javascript:void(0)" class="btn-zoom zoom-out print_hide small_device_hide ipad_hide small_device_hide_l"
   data-container="body"
   data-bs-toggle="tooltip" data-bs-placement="left" title="Zoom Out"><i class="fa fa-minus"></i></a>
<a href="javascript:void(0)" class="btn-zoom zoom-init print_hide small_device_hide ipad_hide small_device_hide_l"
   data-container="body"
   data-bs-toggle="tooltip" data-bs-placement="left" title="Reset Zoom"><i class="fa fa-undo"></i></a>
<a href="<?= $_SERVER['REQUEST_URI'] . '/print'; ?>" target="_blank"
   class="btn-zoom print-btn print_hide small_device_hide ipad_hide small_device_hide_l" data-container="body"
   data-bs-toggle="tooltip" data-bs-placement="left" title="Print"><i class="fa fa-print"></i></a>
<div class="container-fluid">
    <button type="button" class="btn btn-dark  print_hide  <?php if ($nosidebar) {
        echo 'openNav';
    } else {
        echo 'closeNav';
    } ?>" id="navToggleBtn" <?php if ($nosidebar) {
        echo 'style="right:calc(100%)"';
    } ?> aria-label="Close"><i
                class="fa fa-chevron-left sidebar-btn-icon"></i></button>
    <ul id="followTab2" class="<?php if ($nosidebar) {
        echo 'openNav';
    } else {
        echo 'closeNav';
    } ?> print_hide small_device_hide">
        <span class="ftSpan">
            <i class="fa fa-fw fa-chevron-right"></i>
        </span>
    </ul>

    <div class="row phone-potrait-margin-0">

        <nav class="col-md-3 nav " id="navbar-example3" <?php if ($nosidebar) {
            echo 'style="width:0"';
        } ?>>
            <!-- <button type="button" class="btn btn-dark sidebar-close small_device_hide" aria-label="Close"><i class="fa fa-chevron-left sidebar-btn-icon"></i></button>
				<ul id="followTab" class="sidebar-close small_device_hide"></ul> -->
            <div class="flex-shrink-0 p-3 bg-white sticky-sidebar scrollbar-primary">
                <button type="button" class="btn-close mobile_close_nav"></button>
                <a href="#"
                   class="d-flex align-items-center pb-3 sidebarTitle link-dark text-decoration-none border-bottom">
                    <span class="fs-5 fw-semibold">Table of Contents</span>
                </a>


                <ul class="list-unstyled ps-0 list-group-striped" style="display: flex;flex-direction: column;">
                    <?php if ($template == 'web-cool' || $template == 'web-custom'){ ?>
                        <li class="mb-1" data-page-id="title-page"><a href="#title-page" class="btn sep-link align-items-center rounded">
                                <i class="fa fa-fw fa-file-o"></i>&nbsp;&nbsp;Cover Page</a>
                        </li>
                        <li class="mb-1" data-page-id="service-provider"><a href="#service-provider" class="btn sep-link align-items-center rounded">
                                <i class="fa fa-fw fa-file-text-o"></i>&nbsp;&nbsp;Service Provider Information</a>
                        </li>

                    <?php } else { ?>
                    <li class="mb-1" data-page-id="title-page"><a href="#title-page" class="btn sep-link align-items-center rounded">
                            <i class="fa fa-fw fa-file-o"></i>&nbsp;&nbsp;Cover Page</a>
                    <?php } ?>
                    <?php
                    if ($proposal_intro_video) { ?>
                     <li class="mb-1" data-page-id="intro_video"><a href="#intro_video" class="btn sep-link align-items-center rounded">
                            <i class="fa fa-fw fa-file-video-o"></i>&nbsp;&nbsp;Intro Video</a></li>
                    <?php }
                        if ($proposal->getAuditKey()) { ?>
                    <li class="mb-1" data-page-id="audit-section"><a href="#audit-section" class="btn sep-link align-items-center rounded">
                            <i class="fa fa-fw fa-map-marker"></i>&nbsp;&nbsp;Property Inspection/Audit</a></li>
                <?php } ?>
                    <li class="mb-1 " data-page-id="project_specifications">
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
                    if (count($map_images)) { ?>
                        <li class="mb-1" data-page-id="map_images"><a href="#map_images"
                                            class=" btn sep-link align-items-center rounded">
                                <i class="fa fa-fw fa-map"></i>&nbsp;&nbsp;Proposal Maps</a>
                        </li>

                        <?php
                    }
                    
                    if (count($images)) { ?>
                        <li class="mb-1" data-page-id="images"><a href="#images"
                                            class="image_section_btn btn sep-link align-items-center rounded">
                                <i class="fa fa-fw fa-picture-o"></i>&nbsp;&nbsp;Proposal Images</a>
                        </li>

                        <?php
                    }

                    if (count($proposal_videos)) {
                        ?>

                        <li class="mb-1" data-page-id="video"><a href="#video"
                                            class="video_section_btn btn sep-link align-items-center rounded">
                                <i class="fa fa-fw fa-video-camera"></i>&nbsp;&nbsp;Proposal <?= (count($proposal_videos) > 1) ? 'Videos' : 'Video'; ?>
                            </a>
                        </li>
                    <?php } ?>
                    <li class="mb-1" data-page-id="price-breakdown">
                        <a href="#price-breakdown" class="btn sep-link align-items-center rounded">
                            <i class="fa fa-fw fa-usd"></i>&nbsp;&nbsp;Price Breakdown
                        </a>
                    </li>
                    <li class="mb-1" data-page-id="signature"><a href="#signature" class="btn sep-link align-items-center rounded">
                            <i class="fa fa-fw fa-money"></i>&nbsp;&nbsp;Auth / Signature</a></li>


                    





                    <?php
                    if ($havetexts) { ?>
                        <li class="mb-1 " data-page-id="additional-info-section">
                            <a href="#additional-info-section" class="btn sep-link align-items-center rounded">
                                <i class="fa fa-fw fa-list-ul"></i>&nbsp;&nbsp;Terms & Conditions
                            </a>
                            <!-- <a href="#additional-info-section" class="btn btn-toggle align-items-center rounded collapsed term_condition_btn" data-bs-toggle="collapse" data-bs-target="#term-collapse" aria-expanded="false">
                                    <i class="fa fa-fw fa-list-ul"></i>&nbsp;&nbsp;Term & Conditions
								</a>

								<div class="collapse " id="term-collapse">
									<ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
										<?php
                            foreach ($proposal_categories as $catId => $on) {
                                if ($on && isset($categories[$catId])) {
                                    $cat = $categories[$catId];
                                    if (count($cat['texts'])) {
                                        ?>

													<li><a href="#custom_text_<?= $catId; ?>"   data-parent-menu-class="term_condition_btn" class="btn sep-link rounded sub_menu"><?php echo $cat['name'] ?></a></li>

										<?php
                                    }
                                }
                            } ?>


									</ul>
								</div> -->
                        </li>
                    <?php } ?>




                    <?php
                    
                    if (count($attachments) || count($proposal_attachments)) { ?>
                        <!-- BEGIN INVOICE -->

                        <li class="mb-1 " data-page-id="attachments">
                            <a href="#attachments" class="btn sep-link align-items-center rounded">
                                <i class="fa fa-fw fa-paperclip"></i>&nbsp;&nbsp;Attachments
                            </a>
                            <!-- <a href="#attachments" class="btn btn-toggle align-items-center rounded collapsed attachments_btn" data-bs-toggle="collapse" data-bs-target="#attachment-collapse" aria-expanded="false">
                                    <i class="fa fa-fw fa-paperclip"></i>&nbsp;&nbsp;Attachments
								</a>

								<div class="collapse " id="attachment-collapse">
									<ul class="btn-toggle-nav list-unstyled fw-normal pb-1 small">
										<?php
                            if (count($attachments)) {
                                ?>

											<?php
                                foreach ($attachments as $attachment) {
                                    $url = site_url('attachments/' . $proposal->getClient()->getCompany()->getCompanyId()) . '/' . $attachment->getFilePath();
                                    ?>
												<li><a href="#AttachFile<?= $attachment->getAttatchmentId(); ?>" data-parent-menu-class="attachments_btn" class="btn sep-link rounded sub_menu"><?php echo $attachment->getFileName() ?></a></li>

											<?php
                                }
                            }
                            if (count($proposal_attachments)) {
                                ?>

											<?php
                                foreach ($proposal_attachments as $attachment) {
                                    $url = site_url('uploads/companies/' . $proposal->getClient()->getCompany()->getCompanyId() . '/proposals/' . $proposal->getProposalId() . '/' . $attachment->getFilePath());
                                    ?>
												<li><a href="<?php echo str_replace(' ', '%20', $url) ?>" data-parent-menu-class="attachment-collapse" class="btn sep-link rounded sub_menu"><?php echo $attachment->getFileName() ?></a></li>
										<?php
                                }
                            } ?>

									</ul>
								</div> -->
                        </li>
                        <?php
                    } ?>


                </ul>


            </div>


        </nav>


        <!-- BEGIN INVOICE -->
        <div class="boxed-section" id="boxed-section" <?php if ($nosidebar) {
            echo 'style="right:100%;width:100%"';
        } ?>>
            <?php
            $page = 1;

            $pdf_url = site_url('proposals/live/preview/' . $pdf_layout . '/plproposal_' . $proposal->getAccessKey() . '.pdf');
            ?>

            <div class="header grid invoice print_hide" id="infoHeader" style="display:none;">
                <div class="grid-body">
                    <div class="row">
                        <div class="col-lg-2 col-md-3 col-sm-3 ipad2 pd-t-5 pd-l-0 info_header_logo">
                            <img class="mg-left--4"
                                 src="<?php echo site_url('uploads/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo().'?'.time()); ?>"
                                 width="125px" height="auto" alt="">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 pd-t-10 small_device_hide_l ipad_hide mobile-hide info_header_client_details">
                            <strong>
                                <?php echo ($proposal->getClient()->getClientAccount()->getName() == 'Residential') ? 'Residential Proposal' : $proposal->getClient()->getClientAccount()->getName(); ?>
                            </strong><br/>
                            <span class="second_line"><?php echo $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName() ?></span>

                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-3 ipad2 pd-t-10 header_project_name">
                            <p class="header-client-name"><?php echo ($proposal->getClient()->getClientAccount()->getName() == 'Residential') ? 'Residential Proposal' : $proposal->getClient()->getClientAccount()->getName(); ?></p>
                            <strong class="header-project-name"><?php echo strlen($proposal->getProjectName()) > 50 ? substr($proposal->getProjectName(), 0, 50) . "..." : $proposal->getProjectName(); ?></strong>
                        </div>

                        <div class="col-lg-4 col-md-6 col-sm-6 ipad3 pd-t-10 pull-right-md info_header_buttons">

                            <?php if ($track_activity) { ?>
                                <button type="button" id="ask_question_open_canvas_btn" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasRight3" aria-controls="offcanvasRight"
                                        class="btn btn-primary btn-sm  pave-btn tiptip" title="Ask Question"><i
                                            class="fa fa-fw fa-question-circle"></i> <span class="button-text">Ask Question</span>
                                </button>
                                <a href="<?= $_SERVER['REQUEST_URI'] . '/download'; ?>"
                                   download="<?= $proposal->getProjectName(); ?>"
                                   class="download-btn btn btn-primary btn-sm mg-l-10 pave-btn tiptip" title="Download"><i
                                            class="fa fa-fw fa-download"></i> <span class="button-text">Download</span></a>
                                <button class="btn btn-toggle2 align-items-center rounded collapsed header-info-btn"
                                        data-bs-toggle="collapse" data-bs-target="#info-collapse" aria-expanded="false">
                                </button>
                            <?php } ?>

                        </div>
                    </div>
                </div>
                <div class="collapse" id="info-collapse">
                    <div class="row grid info-collapse" style="position: absolute;top: 60px;right: 12px;">

                        <div class="col-md-6 col-sm-6 sticky_header_expanded">
                            <strong>
                                <?php echo ($proposal->getClient()->getClientAccount()->getName() == 'Residential') ? 'Residential Proposal' : $proposal->getClient()->getClientAccount()->getName(); ?>
                            </strong><br/>
                            <span><?php echo $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName() ?></span>
                        </div>
                        <div class="col-md-6 col-sm-6 sticky_header_expanded">
                            <strong><?php echo $proposal->getProjectName() ?></strong></br>
                            <span><?php echo $proposal->getProjectAddress() ?><?php echo trim($proposal->getProjectCity()) . ', ' . $proposal->getProjectState() . ' ' . $proposal->getProjectZip() ?></span>
                        </div>


                    </div>
                </div>
            </div>
            <!-- start Doc section-->

            <div class="doc-section" id="doc-section">
                <button type="button" class="btn btn-newgrey print_hide sectionChanger preSection" aria-label="Close">
                    <span class="carousel-control-prev-icon custom-page-control-prev-icon" aria-hidden="true"></span>
                </button>


                <div id="print_header" style="display:none;">
                    <h1 class="underlined global_header" style="position: fixed;">
                        Proposal: <?php echo $proposal->getProjectName() ?></h1>
                    <div class="logotopright"><img class="theLogo" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                                                       UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>"
                                                   alt=""></div>


                </div>
                <?php if ($template == 'web-cool' || $template == 'web-custom') {
                    if ($template == 'web-cool') {
                        ?>
                        <div id="title-page" class="grid invoice page_break no-header-element pdf-height mg-left-55 "
                             data-page-id="cover">
                            <div class="grid-body">
                                <div class="invoice-title avoid-break" >
                                    <div class="row">

                                        <div class="col-md-12">
                                            <h1 class="title_big ft-s-28"><?php echo $proposal->getProposalTitle() ?></h1>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row coverHr">
                                        <div class="col-md-12">
                                            <img src="<?php echo site_url('uploads/separator.jpg'); ?>" width="100%">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php if ($proposal->getClient()->getClientAccount()->getName()) { ?>
                                                <h2 class="company_name"
                                                    style="text-align: center;"><?php echo ($proposal->getClient()->getClientAccount()->getName() == 'Residential') ? 'Residential Proposal' : $proposal->getClient()->getClientAccount()->getName(); ?></h2>
                                            <?php } ?>
                                            <h3 class="company_owner" style="margin-top:6px!important;"><?php echo $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName() ?></h3>

                                            <h3 class="company_owner1">Project:</h3>

                                            <h3 style="margin-top:22px!important;" class="company_owner2"><?php echo $proposal->getProjectName() ?></h3>
                                            <?php if ($proposal->getProjectAddress()) { ?>
                                                <h4 style="text-align: center; margin-top: 5px; padding-top: 0; font-weight: normal; font-size: 14px;"><?php echo $proposal->getProjectAddress() ?>
                                                    <br><?php echo $proposal->getProjectCity() . ', ' . $proposal->getProjectState() . ' ' . $proposal->getProjectZip() ?>
                                                </h4>
                                            <?php } ?>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="issuedby pull-right">
                                                <p class="clearfix" style="line-height: 16px;">
                                                    <img class=""
                                                         src="<?php echo site_url('uploads/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo().'?'.time()); ?>"
                                                         alt=""><br>
                                                    <?php echo $proposal->getOwner()->getFullName() ?><br>
                                                    <?php echo $proposal->getOwner()->getTitle() ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                </div>


                            </div>
                            <div class="row page_number">Page <?= $counterArray['title-page']; ?></div>

                        </div>
                        <!-- END INVOICE -->
                    <?php } else {
                        ?>
                        <div id="title-page" class="grid invoice page_break no-header-element pdf-height mg-left-55 custom-background"
                             style="background-image: url('<?= $proposal->getCoverImageSrc('-orig'); ?>');"
                             data-page-id="cover">
                            <div class="grid-body">
                                <div class="invoice-title avoid-break" >
                                    <div class="row">

                                        <div class="col-md-12">
                                            <h1 class="title_big ft-s-28 custom_title_big"
                                                style="border-radius: 10px;padding-top:0px;width: 90%;background-color: #<?= $proposal->getHeaderBgColor(); ?>;color: #<?= $proposal->getHeaderFontColor(); ?>;margin-top: 180px;"><?php echo $proposal->getProposalTitle() ?></h1>
                                        </div>
                                    </div>
                                    <br>
                                    <div class="row coverHr">
                                        <div class="col-md-12">

                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 offset-md-3">
                                            <div style="border-radius: 10px;background-color: #<?= $proposal->getHeaderBgColor(); ?>;color: #<?= $proposal->getHeaderFontColor(); ?>;">
                                                <?php if ($proposal->getClient()->getClientAccount()->getName()) { ?>
                                                    <h2 class="company_name"
                                                        style="text-align: center;"><?php echo ($proposal->getClient()->getClientAccount()->getName() == 'Residential') ? 'Residential Proposal' : $proposal->getClient()->getClientAccount()->getName(); ?></h2>
                                                <?php } ?>
                                                <h3 class="company_owner"><?php echo $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName() ?></h3>
                                            </div>
                                        </div>
                                        <div class="col-md-5 " style="margin: auto;">
                                            <div style="margin-top:80px;border-radius: 10px;background-color: #<?= $proposal->getHeaderBgColor(); ?>;color: #<?= $proposal->getHeaderFontColor(); ?>;">
                                                <h3 class="company_owner1" style="padding-top: 15px;">Project:</h3>

                                                <h3 class="company_owner2"
                                                    style="margin-top: 15px;"><?php echo $proposal->getProjectName() ?></h3>
                                                <?php if ($proposal->getProjectAddress()) { ?>
                                                    <h4 style="padding-bottom: 15px;text-align: center; margin-top: 0; padding-top: 0; font-weight: normal; font-size: 13px;"><?php echo $proposal->getProjectAddress() ?>
                                                        <br><?php echo $proposal->getProjectCity() . ', ' . $proposal->getProjectState() . ' ' . $proposal->getProjectZip() ?>
                                                    </h4>
                                                <?php } ?>
                                            </div>
                                        </div>
                                    </div>
                                    <?php if (($proposal->getIsShowProposalLogo() == NULL && $proposal->getClient()->getCompany()->getIsShowProposalLogo() == '1') || ($proposal->getIsShowProposalLogo() == '1')) { ?>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="issuedby pull-right" style="margin-top: 165px;">
                                                    <p class="clearfix" style="line-height: 16px;">
                                                        <img class=""
                                                             src="<?php echo site_url('uploads/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo().'?'.time()); ?>"
                                                             alt=""><br>
                                                        <?php echo $proposal->getOwner()->getFullName() ?><br>
                                                        <?php echo $proposal->getOwner()->getTitle() ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>


                            </div>
                            <div class="row page_number">Page <?= $counterArray['title-page']; ?></div>

                        </div>
                        <!-- END INVOICE -->
                    <?php } ?>

                    <!-- BEGIN INVOICE -->

                    <div class="grid invoice page_break no-header-element pdf-height mg-left-55" id="service-provider"
                         data-page-id="provider">
                        <div>

                            <div class="row">
                                <div class="col-md-12">
                                    <h1 id="service_provider_title" class="ft-s-28"
                                        style="z-index: 200;text-align:center"><?php echo $proposal->getClient()->getCompany()->getPdfHeader() ?></h1>
                                </div>
                            </div>
                            <br>
                            <div class="row company_info_row ">
                                <div class="col-md-6 company-info-section" style="text-align:center">
                                    <h2 style="margin-bottom: 19px;">Company Info</h2>
                                    <img class="theLogo"
                                         src="<?php echo site_url('uploads/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo().'?'.time()) ?>"
                                         alt="">
                                    <p style="margin-block-start: 22px;"><?php echo $proposal->getClient()->getCompany()->getCompanyName() ?>
                                        <br>
                                        <?php echo $proposal->getOwner()->getAddress() ?><br>
                                        <?php echo $proposal->getOwner()->getCity() ?>
                                        , <?php echo $proposal->getOwner()->getState() ?> <?php echo $proposal->getOwner()->getZip() ?>
                                        <br>
                                        <br>
                                        P: <?php echo $proposal->getOwner()->getOfficePhone() ?><br>
                                        <?php if ($proposal->getClient()->getCompany()->getFax() || $proposal->getOwner()->getFax()) { ?>
                                            F: <?php echo ($proposal->getOwner()->getFax()) ? $proposal->getOwner()->getFax() : $proposal->getClient()->getCompany()->getFax() ?>
                                            <br>
                                        <?php } ?>
                                        <a style="font-size: 14px;" target="_blank"
                                           href="<?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?>"><?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?></a><br>
                                    </p>
                                </div>
                                <div class="col-md-6 contact-person-section" style="text-align:center">
                                    <h2>Contact Person</h2>
                                    <p style="padding-top: 0; margin-top: 0;"><?php echo $proposal->getOwner()->getFullName() ?>
                                        <br>
                                        <?php echo $proposal->getOwner()->getTitle() ?><br>
                                        <a href="mailto:<?php echo $proposal->getOwner()->getEmail() ?>"><?php echo $proposal->getOwner()->getEmail() ?></a><br>
                                        Cell: <?php echo $proposal->getOwner()->getCellPhone() ?><br/>
                                        Office <?php echo $proposal->getOwner()->getOfficePhoneExt() ? $proposal->getOwner()->getOfficePhone() . ' Ext ' . $proposal->getOwner()->getOfficePhoneExt() : $proposal->getOwner()->getOfficePhone(); ?>
                                    </p>
                                </div>
                            </div>
                            <div class="row about_us_section">
                                <h1 class="title_big_aboutus ft-s-28">About Us</h1>

                                <div class="aboutus"><?php echo $proposal->getClient()->getCompany()->getAboutCompany() ?></div>
                                <a href="javascript:void(0)" id="about_us_read_more">Read More</a>

                            </div>
                        </div>
                        <div class="row page_number">Page <?= $counterArray['service-provider']; ?></div>
                    </div>
                <?php } else { ?>
                    <div class="grid invoice mg-left-55" id="title-page" data-page-id="title">
                        <div class="grid-body">
                            <div class="logotopright " ><img
                                            class="theLogo" 
                                            src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                                                UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>"
                                            alt=""></div>
                            <div class="row">
                                <div class="col-md-6 ">
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

                                </div>
                                <div class="col-md-6">
                                    <p style="">
                                        <br>
                                        <br>
                                        <b class="projectName">Project
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
                                </div>
                            </div>
                            <br/>
                            <br/>
                            <br/>
                            <div id="intro">
                                <?php echo $proposal->getClient()->getCompany()->getStandardLayoutIntro() ?>
                            </div>


                            <?php if (count($proposal_videos)) {
                                ?>
                                <div id="videoURL" width="100%">
                                    <?php foreach ($proposal_videos as $video) { ?>
                                        <label><?php $video->getTitle(); ?></label>
                                        <a href="<?php echo $video->getVideoUrl() ?>" target="_blank"><img
                                                    src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . '/proposal-video.jpg')); ?>"
                                                    width="90%"></a>

                                        <?php
                                    }
                                    ?>
                                </div>
                                <?php
                            }


                            if ($proposal->getAuditKey()) {
                                ?>

                                <div style="page-break-inside: avoid;position: relative; " id="audit-section">

                                    <div style="page-break-inside: avoid">
                                        <div class="item-content audit print_hide">
                                            <h2 class="property_heading" style="text-align: left;margin-top:0px;">Your
                                                Customized Inspection
                                                <a href="javascript:void(0)" class="btn btn-primary openAuditIframe"
                                                   id="inspection_btn" style="top:6px" data-bs-toggle="offcanvas"
                                                   data-bs-target="#offcanvasRight4" aria-controls="offcanvasRight">Click
                                                    Here</a>
                                                <a href="<?php echo $proposal->getAuditReportUrl(true); ?>"
                                                   id="mobile_openAuditIframe" target="_blank" style="display: none;">Click</a>
                                            </h2>

                                            <!-- <a href="javascript:void(0)" class="openAuditIframe" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight4" aria-controls="offcanvasRight">
                                            <img src="<?= site_url('static/images/property_section.png'); ?>" class="mobile_img"  style="width: 100%; height:auto;"/>
                                            <img src="<?= site_url('static/images/property_section2.png'); ?>" class="small_device_hide"  style="width: 100%; height:auto;"/>
                                        </a> -->
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <a href="javascript:void(0)" class="openAuditIframe"
                                                       data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight4"
                                                       aria-controls="offcanvasRight">
                                                        <!-- <img src="<?= site_url('static/images/property_section.png'); ?>" class="mobile_img"  style="width: 100%; height:auto;"/> -->
                                                        <img src="<?= site_url('static/images/psa.gif'); ?>" class=""
                                                             style="width: 100%; height:auto;"/>
                                                    </a>
                                                </div>
                                                <div class="col-md-6 small_device_hide">
                                                    <h4 style="text-align: center;">Inspection Report</h5>
                                                        <p>Click to see your dynamic property inspection</p>
                                                </div>
                                            </div>
                                            <div class="audit-footer" style="margin-top: 10px;"></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- <div style="page-break-inside: avoid " id="audit-section">
                                    <div class="item-content audit print_hide">
                                        <h2  style="text-align: left;font-size: 26px;">Property Inspection
                                            
                                        </h2>

                                        <table>
                                            <tr>
                                                <td style="text-align: center;width:25%">
                                                    <a href="javascript:void(0)" class="openAuditIframe" data-bs-toggle="offcanvas"
                                                       data-bs-target="#offcanvasRight4" aria-controls="offcanvasRight"
                                                       style="display: block;float: left;">
                                                        <img id="auditIcon"
                                                             src=" <?php //echo site_url('uploads/audit-icon.png'); ?>"/>
                                                    </a>
                                                    <p style="text-align: center; font-weight: bold; font-style: italic;">
                                                        Click to See</p>
                                                </td>
                                                <td style="font-size: 16px;">
                                                    <p>We have performed a custom site inspection/audit of this site
                                                        including maps, images and more</p>
                                                    <p><a href="javascript:void(0)" class="openAuditIframe" data-bs-toggle="offcanvas"
                                                          data-bs-target="#offcanvasRight4"
                                                          aria-controls="offcanvasRight">View your Custom Site
                                                            Inspection/Audit Report</a></p>
                                                </td>
                                            </tr>
                                        </table>
                                        <div class="audit-footer"></div>
                                    </div>
                                </div> -->
                            <?php } ?>
                        </div>
                        <div class="row page_number">Page <?= $counterArray['title-page']; ?></div>

                    </div>
                <?php } ?>
                <!-- END INVOICE -->

                <!-- BEGIN Intro Video -->
            <?php
                $introVideoType = '';
                if ($proposal_intro_video) {
                    ?>
                    <div class="grid invoice print_hide mg-left-55" style="padding-top: 10px;" id="intro_video" data-page-id="intro_video">
                        <div class="grid-body">
                            <div class="row">

                                <div class="row" style="margin-left:0px">
                                    <h1 class="underlined global_header" style="text-align: left;"> <?php echo $proposal_intro_video->getTitle(); ?></h1>
                                    <div class="logotopright small_device_hide">
                                        <img class="theLogo" style="height: 35px; width: 120px; margin-right: 8px;" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>" alt="">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <?php

                                    $buttonShow = false;
                                    $companyThumbImage = false;
                                    if ($proposal_intro_video->getCompanyVideoId() != 0 && $proposal_intro_video->getCompanyCoverImage() != '') {
                                        $companyThumbImage = $proposal_intro_video->getCompanyCoverImage();
                                    }
                                    $url = $proposal_intro_video->getVideoUrl();
                                    if ($proposal_intro_video->getEmbedVideoUrl()) {
                                        $finalUrl = $proposal_intro_video->getEmbedVideoUrl();
                                    } else {
                                        $finalUrl = $url;
                                    }
                                    $iframVideoClass = '';
                                    $videoType = $proposal_intro_video->getVideoType();
                                    if ($videoType == 'NA') {
                                        $buttonShow = true;
                                    } else if ($videoType == 'youtube') {
                                        $iframVideoClass = 'YoutubeIframe';
                                    } else if ($videoType == 'vimeo') {

                                        $iframVideoClass = 'VimeoIframe';
                                    }
                                   
                                    $box_size = 'col-lg-6 col-md-6';
                                    if ($proposal_intro_video->getIsLargePreview()) {
                                        $box_size = 'col-lg-12 col-md-12';
                                    }
                                    
                                    ?>


                                    <div class="<?= $box_size; ?> col-sm-12 text-center" style="margin-bottom:20px;">

                                        <?php if ($buttonShow) { ?>
                                            <!-- <h3 class="video_title"><?php //echo $proposal_intro_video->getTitle(); ?></h3> -->

                                            <a href="<?php echo $url; ?>" class="btn btn-primary"
                                               style="min-width:150px;width: auto;margin: auto;" target="_blank"><i
                                                        class="fa fa-fw fa-play-circle-o"></i>Play: <?php echo $proposal_intro_video->getTitle(); ?>
                                            </a>
                                        <?php } else { ?>
                                            <!-- <h3 class="video_title"><?php //echo $proposal_intro_video->getTitle(); ?></h3> -->

                                            <div class="embed-responsive embed-responsive-16by9 video"
                                                 data-video-id="<?php echo $proposal_intro_video->getId(); ?>">
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

                                                if ($proposal_intro_video->getThumbnailImage() || $companyThumbImage) {
                                                    if ($proposal_intro_video->getThumbnailImage()) {
                                                        $thumbImageURL = $proposal->getSitePathUploadDir() . '/' . $proposal_intro_video->getThumbnailImage();
                                                    } else {
                                                        $thumbImageURL = $companyThumbImage;
                                                    }
                                                    ?>
                                                    <img src="<?= $thumbImageURL; ?>">
                                                    <?php if(!$proposal_intro_video->getPlayerIconHide()){?>

                                                    
                                                        <div class="play-overlay">
                                                            <a href="javascript:void(0)" class="play-icon">
                                                                <img style="width: 70px;height: 70px;position: relative;" src="<?php echo site_url('static\images').'\video-player-icon_'.$proposal_intro_video->getPlayerIconColor().'.png'; ?>" >
                                                            </a>
                                                        </div>
                                                    <?php } ?>
                                                    <!-- <iframe class="embed-responsive-item proposal_video_ifram <?php echo $iframVideoClass; ?>" data-video-type="<?= $videoType; ?>" video_id="<?php echo $proposal_intro_video->getId(); ?>"  id="embed-responsive-video-<?php echo $proposal_intro_video->getId(); ?>" src="<?php echo $finalUrl . $autoplay; ?>"
                                            allowfullscreen loading="lazy" allow="autoplay" onload="popupVideoLoaded" ></iframe> -->
                                                <?php } else {
                                                    $newThumbImageURL = site_url('static/images/video_play.png');
                                                    // if ($videoType == 'youtube') {

                                                    //     parse_str(parse_url($url, PHP_URL_QUERY), $my_array_of_vars);
                                                    //     if (isset($my_array_of_vars['v'])) {
                                                    //         $video_id = $my_array_of_vars['v'];
                                                    //         $newThumbImageURL = "https://img.youtube.com/vi/" . $video_id . "/0.jpg";
                                                    //     } else {
                                                    //         $newThumbImageURL = site_url('static/images/video_play.png');
                                                    //     }

                                                    // } else if ($videoType == 'vimeo') {
                                                    //     $urlParts = explode("/", parse_url($url, PHP_URL_PATH));
                                                    //     $video_id = (int)$urlParts[count($urlParts) - 1];
                                                    //     $newThumbImageURL = "https://vumbnail.com/" . $video_id . ".jpg";
                                                    // } else if ($videoType == 'screencast') {
                                                    //     $newThumbImageURL = str_replace('www', 'content', $url);
                                                    //     $newThumbImageURL = str_replace('embed', 'FirstFrame.jpg', $newThumbImageURL);

                                                    // }


                                                    ?>
                                                    <img src="<?= $newThumbImageURL; ?>">
                                                    <?php if(!$proposal_intro_video->getPlayerIconHide()){?>
                                                        <!-- <div class="play-overlay">
                                                            <a href="javascript:void(0)" class="play-icon">
                                                                <img style="width: 70px;height: 70px;position: relative;" src="<?php echo site_url('static\images').'\video-player-icon_'.$proposal_intro_video->getPlayerIconColor().'.png'; ?>" >
                                                            </a>
                                                        </div> -->
                                                    <?php } ?>
                                                    <!-- <iframe class="embed-responsive-item proposal_video_ifram <?php echo $iframVideoClass; ?>" data-video-type="<?= $videoType; ?>" video_id="<?php echo $proposal_intro_video->getId(); ?>"  id="embed-responsive-video-<?php echo $proposal_intro_video->getId(); ?>" src="<?php echo $finalUrl . $autoplay; ?>"
                                            allowfullscreen loading="lazy" allow="autoplay"  onload="popupVideoLoaded" ></iframe> -->

                                                <?php } ?>
                                            </div>

                                        <?php } ?>
                                    </div>
                                   
                            </div>

                        </div>
                        <div class="row page_number">Page <?= $counterArray['intro_video']; ?></div>
                    </div>
                <?php } ?>
                <!-- END Intro Video -->
                
                <!-- BEGIN INVOICE -->
                <?php
                if ($template == 'web-cool' || $template == 'web-custom') {
                    if ($proposal->getAuditKey()) {
                        ?>
                        <div class="grid invoice print_hide mg-left-55" style="padding-top: 10px;" id="audit-section"
                             data-page-id="audit">
                            <div class="grid-body">
                                <div class="row">
                                    <h1 class="underlined global_header ft-s-22">Property Inspection / Audit</h1>
                                    <div class="logotopright small_device_hide"><img class="theLogo"
                                                                               style="height: 35px; width: 120px; margin-right: 8px;"
                                                                               src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                                                                                   UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>"
                                                                               alt=""></div>
                                </div>
                                <div style="page-break-inside: avoid">
                                    <div class="item-content audit print_hide">
                                        <h2 class="property_heading" style="text-align: left;margin-top:0px;">Your
                                            Customized Inspection
                                            <a href="javascript:void(0)" class="btn btn-primary openAuditIframe"
                                               id="inspection_btn" data-bs-toggle="offcanvas"
                                               data-bs-target="#offcanvasRight4" aria-controls="offcanvasRight">Click
                                                Here</a>
                                            <a href="<?php echo $proposal->getAuditReportUrl(true); ?>"
                                               id="mobile_openAuditIframe" target="_blank"
                                               style="display: none;">Click</a>
                                        </h2>

                                        <!-- <a href="javascript:void(0)" class="openAuditIframe" data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight4" aria-controls="offcanvasRight">
                                            <img src="<?= site_url('static/images/property_section.png'); ?>" class="mobile_img"  style="width: 100%; height:auto;"/>
                                            <img src="<?= site_url('static/images/property_section2.png'); ?>" class="small_device_hide"  style="width: 100%; height:auto;"/>
                                        </a> -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <a href="javascript:void(0)" class="openAuditIframe"
                                                   data-bs-toggle="offcanvas" data-bs-target="#offcanvasRight4"
                                                   aria-controls="offcanvasRight">
                                                    <!-- <img src="<?= site_url('static/images/property_section.png'); ?>" class="mobile_img"  style="width: 100%; height:auto;"/> -->
                                                    <img src="<?= site_url('static/images/psa.gif'); ?>" class=""
                                                         style="width: 100%; height:auto;"/>
                                                </a>
                                            </div>
                                            <div class="col-md-6 small_device_hide">
                                                <h4 style="text-align: center;">Inspection Report</h5>
                                                    <p>Click to see your dynamic property inspection</p>
                                            </div>
                                        </div>
                                        <div class="audit-footer" style="margin-top: 10px;"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="row page_number">Page <?= $counterArray['audit-section']; ?></div>
                        </div>

                    <?php }
                } ?>
                <!-- END INVOICE -->
                <!-- BEGIN INVOICE -->

                <div class="grid invoice pdf-height page_break page_break_before mg-left-55" style="padding-top: 10px;"
                     data-page-id="services" id="project_specifications">
                    <div class="grid-body">
                        <div class="row">
                            <div class="row">
                                <h1 class="underlined global_header print_hide">Project Specifications </h1>
                                <h1 class="underlined global_header only_show_print">
                                    Proposal: <?php echo $proposal->getProjectName() ?> </h1>
                                <div class="logotopright small_device_hide"><img class="theLogo"
                                                                               style="height: 35px; width: 120px; margin-right: 8px;"
                                                                               src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                                                                                   UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>"
                                                                               alt=""></div>
                            </div>
                        </div>
                        <div class="row">
                            <?php if (count($proposal_videos)) {
                                ?>
                                <div id="videoURL" width="100%">
                                    <?php foreach ($proposal_videos as $video) { ?>
                                        <label><?php $video->getTitle(); ?></label>
                                        <a href="<?php echo $video->getVideoUrl() ?>" target="_blank"><img
                                                    src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . '/proposal-video.jpg')); ?>"
                                                    width="90%"></a>

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
                                         style="float: left;"
                                         id="service_<?php echo $service->getServiceId() ?>"
                                         data-service-id="<?php echo $service->getServiceId() ?>">
                                        <div style="position: relative;"
                                             class="item-content<?php echo ($service->isNoPrice()) ? ' no-price' : ''; ?> ">
                                            <h2 class="service_title pave-text-color"><?php echo $service->getServiceName() ?> 
                                            <a href="javascript:void(0)" class="serviceNameList not_link" style="color: #25AAE1;"
                                                data-service-optional="0" data-bs-toggle="offcanvas"
                                                data-bs-target="#serviceOffcanvasRight"
                                                aria-controls="offcanvasRight"
                                                data-service-id="service_<?php echo $service->getServiceId() ?>"
                                                data-service-ind-id="<?php echo $service->getServiceId() ?>"
                                                data-map-area="<?php echo $service->getMapAreaData();?>"> 
                                                <i  data-bs-placement="right" data-container="body" data-bs-toggle="tooltip" title="View Service Details" class="fa fa-fw fa-external-link"></i></a></h2>
                                            <?php
                                            if ($service->isOptional()) {
                                                ?>
                                                <span class="optional_service_badge badge bg-secondary"
                                                      style="position: absolute;right: 10px;top:-22px;font-size: 12px;background-color:#25aae1!important">Optional Service</span>
                                            <?php } ?>
                                            <div class="item-content-texts">
                                                <?php echo $services_texts[$service->getServiceId()]; ?>
                                            </div>
                                            <?php if (!$lumpSum && !$service->isNoPrice()) {
                                                $price = (float)str_replace($s, $r, $service->getPrice());
                                                $taxprice = (float)str_replace($s, $r, $service->getTaxPrice());
                                                ?>

                                                <span class="service_text_total" style="width:100%;float:left;text-align:center;margin-top: 7px;"><strong>Total Price:</strong> <?php echo '$' . number_format(($price - $taxprice), 2); ?></span>

                                            <?php } ?>

                                            <?php
                                            $imagesTest = array();
                                            if (isset($service_images[$service->getServiceId()])) {

                                                foreach ($service_images[$service->getServiceId()] as $k => $service_image) {
                                                    if ($service_image['image']->getActive()) {
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
                                            <h2 class="service_title pave-text-color"><?php echo $service->getServiceName() ?></h2>
                                            <?php echo $services_texts[$service->getServiceId()]; ?>
                                            <?php if ($service->getPricingType() != 'Noprice') {
                                                switch ($service->getPricingType()) {
                                                    case 'Trip':
                                                        ?>
                                                        <p style="padding-left: 40px;">Price Per
                                                            Trip: <?php echo $service->getFormattedPrice() ?></p>
                                                        <?php
                                                        break;
                                                    case 'Season':
                                                        ?>
                                                        <p style="padding-left: 40px;">Total Seasonal Price for this
                                                            item: <?php echo $service->getFormattedPrice() ?></p>
                                                        <?php
                                                        break;
                                                    case 'Year':
                                                        ?>
                                                        <p style="padding-left: 40px;">Total Yearly Price for this
                                                            item: <?php echo $service->getFormattedPrice() ?></p>
                                                        <?php
                                                        break;
                                                    case 'Month':
                                                        ?>
                                                        <p style="padding-left: 40px;">Total Monthly Price for this
                                                            item: <?php echo $service->getFormattedPrice() ?></p>
                                                        <?php
                                                        break;
                                                    case 'Hour':
                                                        ?>
                                                        <p style="padding-left: 40px;">This item has
                                                            a <?php echo $service->getFormattedPrice() ?> hourly
                                                            price</p>
                                                        <?php
                                                        break;
                                                    case 'Materials':
                                                        ?>
                                                        <p style="padding-left: 40px;">This item is
                                                            priced <?php echo $service->getFormattedPrice() ?>
                                                            Per <?php echo $service->getMaterial() ?></p>
                                                        <?php
                                                        break;
                                                    default:
                                                        //total and new one
                                                        ?>
                                                        <p style="padding-left: 40px;">Total Price for this
                                                            item: <?php echo $service->getFormattedPrice() ?></p>
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
                    </div>
                    <div class="row page_number">Page <?= $counterArray['project_specifications']; ?></div>

                </div>

                <!--Map Image Show-->
                <?php

                $new_map_images = array();
                if (count($map_images)) {
                    foreach ($map_images as $k => $image) {
                        if ($map_images[$k]['image']->getActive()) {
                            $img = array();
                            $img['src'] = $map_images[$k]['websrc'];
                            $img['id'] = $map_images[$k]['id'];
                            $img['path'] = $map_images[$k]['path'];
                            if (file_exists($img['path'])) {
                                $img['orientation'] = $map_images[$k]['orientation'];
                                $img['title'] = $map_images[$k]['image']->getTitle();
                                $img['notes'] = $map_images[$k]['image']->getNotes();
                                $img['image_layout'] = $map_images[$k]['image']->getImageLayout();
                                $new_map_images[] = $img;
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
                    <div id="map_images" style="width:100%">

                        <?php


                        foreach ($new_map_images as $image) {
                            $j++;
                            $image['image_layout'] = 2;

                            

                                    if ($tableOpen) {
                                        if ($old_layout == 1) {
                                            if ($imageCount % 2) {
                                                echo '</div></div></div>';
                                            }
                                            //close table
                                            echo '<div class="row page_number">Page ' . $counterArray['map_images']++ . '</div></div>';
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
                                        <div class="grid invoice pdf-height  page_break_before mg-left-55" data-page-id="images" style="padding-top: 10px;" <?php //if($j==1){echo ' id="images"';}?> >
                                        <div class="grid-body">
                                        <?php if ($j == 1) { ?>
                                            <div class="print_hide ">
                                                <div class="row">
                                                    <h1 class="underlined global_header ft-s-22" style="width: 97%;">
                                                        Proposal Maps</h1>
                                                    <div class="logotopright small_device_hide"><img class="theLogo"
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


                                    <div class="col-12 col-sm-6 col-md-6 mg-btm-20 break-after image-section"
                                         data-image-id="<?php echo $image['id']; ?>">
                                        <?php if ($j == 1) { ?>


                                            <div class="row">

                                                <h1 class="underlined global_header only_show_print"
                                                    style="width: 725px;">
                                                    Proposal: <?php echo $proposal->getProjectName() ?> </h1>
                                                <div class="logotopright only_show_print"
                                                     style="top: -6px!important;left: 619px!important;"><img
                                                            class="theLogo"
                                                            style="height: 35px; width: 120px; margin-right: 8px;"
                                                            src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                                                                UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>"
                                                            alt=""></div>
                                            </div>
                                        <?php } ?>
                                        <div style="position: relative;">
                                            <h2 class="image_title"><?php echo $image['title'] ?></h2>
                                            <?php

                                            $notes_icon = '';
                                            if ($image['notes']) {
                                                $notes_icon = ' <i class="fa fa-info-circle"></i>';
                                                ?>
                                                <a href="javascript:void(0)"
                                                   data-bs-toggle="offcanvas"
                                                   data-bs-target="#mobileImageInfo"
                                                   aria-controls="offcanvasRight"
                                                   class="image-section-info"
                                                   style="margin-top: 1px;border-radius: 0px 5px 0px 5px;">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>


                                            <?php } ?>
                                            <span class="image-pinch-back" style="top: 30px;">
                                                    <button type="button" class="btn-close text-reset btn-close-white"
                                                            data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                </span>
                                            <img data-slide="slide-image-<?= $j; ?>"
                                                 data-image-id="<?php echo $image['id']; ?>" data-bs-toggle="offcanvas"
                                                 data-bs-target="#offcanvasMapImage" aria-controls="offcanvasRight"
                                                 class="<?php echo ($image['orientation'] == 'landscape') ? 'proposalImage_l' : 'proposalImage_p'; ?> img-fluid img-thumbnail  btn showProposalCarousel imageContain"
                                                 
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
                                                   class="image-note-section-info "
                                                >
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            <?php } ?>

                                            <p class="image-section-inlarge-text"
                                               style="bottom: -15px;pointer-events: none;"><i class="fa fa-plus"></i>
                                                Enlarge</p>
                                        </div>
                                        <div class="image-section-notes"
                                             style="display: none;position: relative;padding: 5px;width: 100%;border-radius: 5px;border: 1px solid #939090;max-height: 100px;overflow-y: auto;"><?= $image['notes']; ?>
                                            <span class="close"></span></div>
                                        <br>
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
                                        <div class="row page_number">Page <?= $counterArray['map_images']++; ?></div></div>
                                        <?php
                                        $tableOpen = 0;
                                    }
                                   
                            
                            $old_layout = $image['image_layout'];


                        }//new end

                        if ($tableOpen) {
                            if ($old_layout == 1) {
                                //close table
                                echo '</div></div></div><div class="row page_number">Page ' . $counterArray['map_images']++ . '</div></div>';
                            } else if ($old_layout == 2) {
                                echo '</div></div><div class="row page_number">Page ' . $counterArray['map_images']++ . '</div></div>';
                            } else {
                                //close tr's if necessary...
                                if ($imageCount % 2) {
                                    echo '</div></div>';
                                }
                                //close table
                                echo '<div></div></div></div><div class="row page_number">Page ' . $counterArray['map_images']++ . '</div></div>';
                            }
                        } ?>


                    </div>


                <?php } ?>

                <!-- END Map Images -->

                <?php
 
                $images2 = array();
                if (count($images)) {
                    foreach ($images as $k => $image) {
                        if ($images[$k]['image']->getActive()) {
                            $img = array();
                            $img['src'] = $images[$k]['websrc'];
                            $img['id'] = $images[$k]['id'];
                            $img['path'] = $images[$k]['path'];
                            if (file_exists($img['path'])) {
                                $img['orientation'] = $images[$k]['orientation'];
                                $img['title'] = $images[$k]['image']->getTitle();
                                $img['notes'] = $images[$k]['image']->getNotes();
                                $img['image_layout'] = $layoutArray[$images[$k]['image']->getImageLayout()];
                                $img['image_layout2'] = $images[$k]['image']->getImageLayout();
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
                    <div id="images" style="width:100%">

                            <?php
                            // Space threshold for each page
                            $pageSpaceThreshold = 100;
                            $cssForCol = '';

                            // Initialize variables to track space on each page and displayed images
                            $currentPageSpace = 0;
                            //$displayedImages = array();

                        $pageOpen = false;
                        foreach ($images2 as $image) { 
                            
                            if($image['image_layout']==4){
                                $cssForCol = 'col-sm-6 col-md-6';
                                $imgHeight = '280px';
                            }else if($image['image_layout']==2){
                                $cssForCol = 'col-sm-12 col-md-12';
                                $imgHeight = '350px';
                            }else{
                                $cssForCol = 'col-sm-12 col-md-12';
                                $imgHeight = '450px';
                            }

                            
                            //$image['image_layout'] = 2;
                            $j++;
                           // echo ($currentPageSpace + (100 / $image['image_layout']));
                           if($currentPageSpace + (100 / $image['image_layout']) > $pageSpaceThreshold){
                            $currentPageSpace = 0;
                                if($pageOpen){
                                    $pageOpen =false;
                                    ?>
                                    </div>
                                        <div class="row page_number">Page <?= $counterArray['images']++; ?></div></div>
                            <?php } 
                           }
                        if ($currentPageSpace ==0 || $j == 1) {

                            if($pageOpen){?>
                                </div>
                                        <div class="row page_number">Page <?= $counterArray['images']++; ?></div></div>
                            <?php } 
                            ?>
                            
<div class="grid invoice pdf-height  page_break_before mg-left-55" data-page-id="images" style="padding-top: 10px;" <?php //if($j==1){echo ' id="images"';}?> >
                                        <div class="grid-body">

                                        <?php if ($j == 1) { ?>
                                            <div class="print_hide ">
                                                <div class="row">
                                                    <h1 class="underlined global_header ft-s-22" style="width: 97%;">
                                                        Proposal Images</h1>
                                                    <div class="logotopright small_device_hide"><img class="theLogo"
                                                                                                   style="height: 35px; width: 120px; margin-right: 8px;"
                                                                                                   src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                                                                                                       UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>"
                                                                                                   alt=""></div>
                                                </div>
                                            </div>
                                        <?php } } $pageOpen =true;?>



                                        <div class="col-12  mg-btm-20 break-after image-section <?php echo $cssForCol;?>"
                                         data-image-id="<?php echo $image['id']; ?>" >

                                        <div style="position: relative;" class="imageTitle">
                                            <h2 class="image_title"><?php echo $image['title'] ?></h2>
                                            <?php

                                            $notes_icon = '';
                                            if ($image['notes']) {
                                                $notes_icon = ' <i class="fa fa-info-circle"></i>';
                                                ?>
                                                <a href="javascript:void(0)"
                                                   data-bs-toggle="offcanvas"
                                                   data-bs-target="#mobileImageInfo"
                                                   aria-controls="offcanvasRight"
                                                   class="image-section-info"
                                                   style="margin-top: 1px;border-radius: 0px 5px 0px 5px;">
                                                    <i class="fa fa-info-circle"></i>
                                                </a>


                                            <?php } ?>
                                            <span class="image-pinch-back" style="top: 30px;">
                                                    <button type="button" class="btn-close text-reset btn-close-white"
                                                            data-bs-dismiss="offcanvas" aria-label="Close"></button>
                                                </span>
                                            <img data-slide="slide-image-<?= $j; ?>"
                                                 data-image-id="<?php echo $image['id']; ?>" data-bs-toggle="offcanvas"
                                                 data-bs-target="#offcanvasRight2" aria-controls="offcanvasRight"
                                                 class="<?php echo ($image['orientation'] == 'landscape') ? 'proposalImage_l' : 'proposalImage_p'; ?> img-fluid img-thumbnail  btn showProposalCarousel"
                                                 style="padding:0px;object-fit:cover; height:<?php echo $imgHeight;?>; width:100%;"
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
                                                   class="image-note-section-info "
                                                >
                                                    <i class="fa fa-info-circle"></i>
                                                </a>
                                            <?php } ?>

                                            <p class="image-section-inlarge-text"
                                               style="bottom: -15px;pointer-events: none;"><i class="fa fa-plus"></i>
                                                Enlarge</p>
                                        </div>
                                        <div class="image-section-notes"
                                             style="display: none;position: relative;padding: 5px;width: 100%;border-radius: 5px;border: 1px solid #939090;max-height: 100px;overflow-y: auto;"><?= $image['notes']; ?>
                                            <span class="close"></span></div>
                                        <br>
                                    </div>

                                <?php

                                $currentPageSpace += (100 / $image['image_layout']);
                                if($image['image_layout']==2 && $currentPageSpace>74){
                                    $currentPageSpace=100;
                                }

                                if ($currentPageSpace > 90) {
                                    $currentPageSpace = 0;
                                    $pageOpen = false;
                                ?>

                    </div>
                                        <div class="row page_number">Page <?= $counterArray['images']++; ?></div></div>

                        <?php
}
                    
                    }                   
                    
                    if($pageOpen){?>
                        </div>
                                <div class="row page_number">Page <?= $counterArray['images']++; ?></div></div>
                    <?php } 
                    ?>
                    </div>  
                <?php } ?>


                <!-- END INVOICE -->


                <!-- BEGIN Videos -->

                <?php
                $videoType = '';
                if (count($proposal_videos)) {
                    $videoCounter = 1;
                    ?>
                    <div class="grid invoice print_hide mg-left-55" style="padding-top: 10px;" id="video"
                         data-page-id="video">
                        <div class="grid-body">
                            <div class="row">

                                <div class="row">
                                    <h1 class="underlined global_header">
                                        Proposal <?= (count($proposal_videos) > 1) ? 'Videos' : 'Video'; ?></h1>
                                    <div class="logotopright small_device_hide"><img class="theLogo"
                                                                                   style="height: 35px; width: 120px; margin-right: 8px;"
                                                                                   src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                                                                                       UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>"
                                                                                   alt=""></div>
                                </div>
                            </div>
                            <div class="row">
                                <?php


                                foreach ($proposal_videos as $video) {
                                    $buttonShow = false;
                                    $companyThumbImage = false;
                                    if ($video->getCompanyVideoId() != 0 && $video->getCompanyCoverImage() != '') {
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
                                    if ($video->getIsLargePreview()) {
                                        $box_size = 'col-lg-12 col-md-12';
                                    }
                                    ?>


                                    <div class="<?= $box_size; ?> col-sm-12" style="margin-bottom:20px;">

                                        <?php if ($buttonShow) { ?>
                                            <h3 class="video_title"><?= $videoCounter; ?>
                                                . <?php echo $video->getTitle(); ?></h3>

                                            <a href="<?php echo $url; ?>" class="btn btn-primary"
                                               style="min-width:150px;width: auto;margin: auto;" target="_blank"><i
                                                        class="fa fa-fw fa-play-circle-o"></i>Play: <?php echo $video->getTitle(); ?>
                                            </a>
                                        <?php } else { ?>
                                            <h3 class="video_title"><?= $videoCounter; ?>
                                                . <?php echo $video->getTitle(); ?></h3>

                                            <div class="embed-responsive embed-responsive-16by9 video"
                                                 data-video-id="<?php echo $video->getId(); ?>">
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
                                                    if ($video->getThumbnailImage()) {
                                                        $thumbImageURL = $proposal->getSitePathUploadDir() . '/' . $video->getThumbnailImage();
                                                    } else {
                                                        $thumbImageURL = $companyThumbImage;
                                                    }
                                                    ?>
                                                    <img src="<?= $thumbImageURL; ?>">
                                                    <?php if(!$video->getPlayerIconHide()){?>
                                                        <div class="play-overlay">
                                                            <a href="javascript:void(0)" class="play-icon">
                                                                <img style="width: 70px;height: 70px;position: relative;" src="<?php echo site_url('static\images').'\video-player-icon_'.$video->getPlayerIconColor().'.png'; ?>" >
                                                            </a>
                                                        </div>
                                                    <?php } ?>
                                                    <!-- <iframe class="embed-responsive-item proposal_video_ifram <?php echo $iframVideoClass; ?>" data-video-type="<?= $videoType; ?>" video_id="<?php echo $video->getId(); ?>"  id="embed-responsive-video-<?php echo $video->getId(); ?>" src="<?php echo $finalUrl . $autoplay; ?>"
                                            allowfullscreen loading="lazy" allow="autoplay" onload="popupVideoLoaded" ></iframe> -->
                                                <?php } else {
                                                    $newThumbImageURL = site_url('static/images/video_play.png');
                                                    $showPlayerIcon = false;
                                                    

                                                    ?>
                                                    <img src="<?= $newThumbImageURL; ?>">
                                                    <?php if(!$video->getPlayerIconHide()  && $showPlayerIcon){?>
                                                        <div class="play-overlay">
                                                            <a href="javascript:void(0)" class="play-icon">
                                                                <img style="width: 70px;height: 70px;position: relative;" src="<?php echo site_url('static\images').'\video-player-icon_'.$video->getPlayerIconColor().'.png'; ?>" >
                                                            </a>
                                                        </div>
                                                    <?php } ?>
                                                    <!-- <iframe class="embed-responsive-item proposal_video_ifram <?php echo $iframVideoClass; ?>" data-video-type="<?= $videoType; ?>" video_id="<?php echo $video->getId(); ?>"  id="embed-responsive-video-<?php echo $video->getId(); ?>" src="<?php echo $finalUrl . $autoplay; ?>"
                                            allowfullscreen loading="lazy" allow="autoplay"  onload="popupVideoLoaded" ></iframe> -->

                                                <?php } ?>
                                            </div>

                                        <?php } ?>
                                    </div>
                                    <?php
                                    $videoCounter++;
                                }
                                ?>
                            </div>

                        </div>
                        <div class="row page_number">Page <?= $counterArray['video']; ?></div>
                    </div>
                <?php } ?>
                <!-- END Videos -->
                <!-- BEGIN INVOICE -->
                <div class="grid invoice pdf-height page_break page_break_before mg-left-55" style="padding-top: 10px;"
                     id="price-breakdown" data-page-id="price">
                    <div class="grid-body">
                        <div class="row">

                            <div class="row">
                                <h1 class="underlined global_header print_hide">Price Breakdown</h1>
                                <h1 class="underlined global_header only_show_print">Price
                                    Breakdown: <?php echo $proposal->getProjectName() ?> </h1>
                                <div class="logotopright small_device_hide"><img class="theLogo"
                                                                               style="height: 35px; width: 120px; margin-right: 8px;"
                                                                               src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                                                                                   UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>"
                                                                               alt=""></div>

                            </div>
                        </div>
                        <div class="row">
                            <p>Please find the following breakdown of all services we have provided in this
                                proposal.</p>
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
                            $isMapDataAdded = false;
                            $isMapDataAddedOS = false;
                            foreach ($services as $k => $serviceItem) {
                                if ($serviceItem->isOptional()) {
                                    unset($services[$k]);
                                    $optionalServices[] = $serviceItem;
                                    if ($serviceItem->getMapAreaData() != '') {
                                        $isMapDataAddedOS = true;
                                    }
                                } else {
                                    if ($serviceItem->getMapAreaData() != '') {
                                        $isMapDataAdded = true;
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


                            // Use standard layout for non-snow
                            if (!$proposal->hasSnow()) {


                                ?>
                                <div class="table-container ">
                                    <table width="100%" class="table mytable table-striped table-sm" border="0">
                                        <thead>
                                        <tr>
                                            <td width="10%"><strong>Item</strong></td>
                                            <td width="45%"><strong>Description</strong></td>
                                            <?php if ($isMapDataAdded) { ?>
                                                <td width="25%"><strong>Map Area</strong></td> <?php } ?>
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
                                            $taxprice = (float)str_replace($s, $r, $service->getTaxPrice());
                                            ?>
                                            <tr>
                                                <td <?php if ($k % 2) {
                                                    echo 'class="odd"';
                                                } ?>><?php echo $k; ?>.
                                                </td>
                                                <td <?php if ($k % 2) {
                                                    echo 'class="odd"';
                                                } ?> ><a href="javascript:void(0)" class="serviceNameList"
                                                         data-service-optional="0" data-bs-toggle="offcanvas"
                                                         data-bs-target="#serviceOffcanvasRight"
                                                         aria-controls="offcanvasRight"
                                                         data-service-id="service_<?php echo $service->getServiceId() ?>"
                                                         data-service-ind-id="<?php echo $service->getServiceId() ?>"
                                                         data-map-area="<?php if ($isMapDataAdded) {
                                                             echo $service->getMapAreaData();
                                                         } ?>"> <?php
                                                        if ($taxprice > 0) {
                                                            echo '<span style="font-weight:bold;vertical-align: sub;">* </span>';
                                                            $isTaxApplied = true;
                                                        }
                                                        //fix for the price breakdown to show service name instead of Additional Service
                                                        echo $service->getServiceName();
                                                        ?></a></td>

                                                <?php if ($isMapDataAdded) { ?>
                                                <td <?php if ($k % 2) {
                                                    echo 'class="odd"';
                                                } ?>> <?php echo $service->getMapAreaData(); ?></td><?php } ?>

                                                <td <?php echo ($k % 2) ? ' class="odd"' : ''; ?>
                                                        style="text-align: right">
                                                    <?php
                                                    // Price required for calculations
                                                    $price = (float)str_replace($s, $r, $service->getPrice());


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
                                                    <?php if ($isMapDataAdded) { ?>
                                                        <td></td> <?php } ?>
                                                    <td align="right">Subtotal:</td>
                                                    <td style="text-align: right">
                                                        $<?php echo number_format($total, 2) ?></td>
                                                </tr>
                                                <?php
                                                foreach ($taxServices as $taxService) {
                                                    $taxTotal += $taxService->getPrice(true);
                                                }
                                                ?>
                                                <tr>
                                                    <td></td>
                                                    <?php if ($isMapDataAdded) { ?>
                                                        <td></td> <?php } ?>
                                                    <td align="right">Tax:</td>
                                                    <td style="text-align: right">
                                                        $<?php echo number_format($taxTotal, 2) ?></td>
                                                </tr>
                                            <?php } ?>
                                            <?php if ($taxSubTotal > 0) { ?>
                                                <tr>
                                                    <td></td>
                                                    <?php if ($isMapDataAdded) { ?>
                                                        <td></td> <?php } ?>
                                                    <td align="right"><strong>Tax:</strong></td>
                                                    <td style="text-align: right">
                                                        $<?php echo number_format($taxSubTotal, 2) ?></td>
                                                </tr>
                                            <?php } ?>
                                            <tr>
                                                <td></td>
                                                <?php if ($isMapDataAdded) { ?>
                                                    <td></td> <?php } ?>
                                                <td style="text-align: right"><strong>Total: <span
                                                                class="show_only_mobile">$<?php echo number_format($total + $taxTotal, 2) ?></span></strong>
                                                </td>
                                                <td style="text-align: right">
                                                    <strong>$<?php echo number_format($total + $taxTotal, 2) ?></strong>
                                                </td>
                                            </tr>
                                            </tfoot>
                                            <?php
                                        } ?>
                                    </table>
                                </div>
                                <?php
                                if (count($optionalServices)) {
                                    ?>
                                    <h2 class="mg-t-4">Optional Services:</h2>
                                    <div class="table-container ">
                                        <table width="100%" class="table mytable table-striped table-sm" border="0">
                                            <thead>
                                            <tr>
                                                <td width="10%"><strong>Item</strong></td>
                                                <td width="45%"><strong>Description</strong></td>
                                                <?php if ($isMapDataAddedOS) { ?>
                                                    <td width="25%"><strong>Map Area</strong></td> <?php } ?>
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
                                                $taxPrice = 0;
                                                if ($service->getTaxPrice()) {
                                                    $taxprice = (float)str_replace($s, $r, $service->getTaxPrice());
                                                }
                                                ?>
                                                <tr>
                                                    <td <?php if ($k % 2) {
                                                        echo 'class="odd"';
                                                    } ?>><?php echo $k; ?>.
                                                    </td>

                                                    <td <?php if ($k % 2) {
                                                        echo 'class="odd"';
                                                    } ?> ><a href="javascript:void(0)" class="serviceNameList"
                                                             data-service-optional="1" data-bs-toggle="offcanvas"
                                                             data-bs-target="#serviceOffcanvasRight"
                                                             aria-controls="offcanvasRight"
                                                             data-service-id="service_<?php echo $service->getServiceId() ?>"
                                                             data-service-ind-id="<?php echo $service->getServiceId() ?>"
                                                             data-map-area="<?php if ($isMapDataAdded) {
                                                                 echo $service->getMapAreaData();
                                                             } ?>"> <?php
                                                            if ($taxprice > 0) {
                                                                echo '<span style="font-weight:bold;vertical-align: sub;">* </span>';
                                                                $isTaxApplied = true;
                                                            }
                                                            //fix for the price breakdown to show service name instead of Additional Service
                                                            echo $service->getServiceName();
                                                            ?></a></td>
                                                    <?php if ($isMapDataAddedOS) { ?>
                                                    <td <?php if ($k % 2) {
                                                        echo 'class="odd"';
                                                    } ?>> <?php echo $service->getMapAreaData(); ?></td><?php } ?>
                                                    <td <?php echo ($k % 2) ? ' class="odd"' : ''; ?>
                                                            style="text-align: right">
                                                        <?php
                                                        // Price required for calculations
                                                        $price = (float)str_replace($s, $r, $service->getPrice());

                                                        //echo $service->getFormattedPrice();
                                                        echo '$' . number_format(($price - $taxprice), 2);
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
                                                <?php if ($taxSubTotal > 0) { ?>
                                                    <tr>
                                                        <td></td>
                                                        <?php if ($isMapDataAddedOS) { ?>
                                                            <td></td> <?php } ?>
                                                        <td align="right"><strong>Tax:</strong></td>
                                                        <td style="text-align: right">
                                                            $<?php echo number_format($taxSubTotal, 2) ?></td>
                                                    </tr>
                                                <?php } ?>

                                                </tfoot>
                                            <?php } ?>
                                        </table>
                                    </div>
                                    <?php
                                }
                            } else {
                                // Snow proposal
                                ?>
                                <div class="table-container table_mg-t-2 table-responsive">
                                    <h4 style="margin-top: 0; padding-top: 0; margin-bottom: 0; padding-bottom: 0; font-size:15px">
                                        Service Pricing</h4>
                                    <table width="100%" class="table cool_table" border="0" style="margin-bottom: 0;">
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
                                                        $price = (float)str_replace($s, $r, $service->getPrice());
                                                        echo @number_format($price, 2);
                                                        ?></td>
                                                    <td class="<?php echo $class; ?>" align="right"><?php
                                                        if (!in_array($service->getPricingType(), $hiddenPrices)) {
                                                            if (in_array($service->getPricingType(), $fixedPrices)) {
                                                                $amountQty = 1;
                                                            }
                                                            $partialTotal = ((float)str_replace($s, $r, $price) * $amountQty);
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
                                        <h4 style="margin-top: 0; padding-top: 0; margin-bottom: 0; padding-bottom: 0; font-size: 15px">
                                            Time & Material Items</h4>
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
                                                            $price = (float)str_replace($s, $r, $service->getPrice());
                                                            echo @number_format($price, 2);
                                                            ?></td>
                                                        <td align="right" class="<?php echo $class; ?>">
                                                            Per <?php echo ($service->getPricingType() != 'Materials') ? $service->getPricingType() : $service->getMaterial(); ?></td>
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
                                // Optional Services for Snow Case 
                                 if (count($optionalServices)) {
                                    ?>
                                    <h2 class="mg-t-4">Optional Services:</h2>
                                    <div class="table-container ">
                                        <table width="100%" class="table mytable table-striped table-sm" border="0">
                                            <thead>
                                            <tr>
                                                <td width="10%"><strong>Item</strong></td>
                                                <td width="45%"><strong>Description</strong></td>
                                                <?php if ($isMapDataAddedOS) { ?>
                                                    <td width="25%"><strong>Map Area</strong></td> <?php } ?>
                                                <td width="20%" style="text-align: right"><strong>Cost</strong></td>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            <?php
                                            $k = 0;
                                            $total = 0;
                                            $taxSubTotal = 0;
                                            $isTaxApplied = false;
                                            $taxPrice = 0;
                                            foreach ($optionalServices as $service) {
                                                $k++;
                                                 if ($service->getTaxPrice()) {
                                                    $taxprice = (float)str_replace($s, $r, $service->getTaxPrice());
                                                }else
                                                {
                                                    $taxprice=0;
                                                }
                                                ?>
                                                <tr>
                                                    <td <?php if ($k % 2) {
                                                        echo 'class="odd"';
                                                    } ?>><?php echo $k; ?>.
                                                    </td>

                                                    <td <?php if ($k % 2) {
                                                        echo 'class="odd"';
                                                    } ?> ><a href="javascript:void(0)" class="serviceNameList"
                                                             data-service-optional="1" data-bs-toggle="offcanvas"
                                                             data-bs-target="#serviceOffcanvasRight"
                                                             aria-controls="offcanvasRight"
                                                             data-service-id="service_<?php echo $service->getServiceId() ?>"
                                                             data-service-ind-id="<?php echo $service->getServiceId() ?>"
                                                             data-map-area="<?php if ($isMapDataAdded) {
                                                                 echo $service->getMapAreaData();
                                                             } ?>"> <?php
                                                            if (isset($taxprice) & $taxprice > 0) {
                                                                echo '<span style="font-weight:bold;vertical-align: sub;">* </span>';
                                                                $isTaxApplied = true;
                                                            }
                                                            //fix for the price breakdown to show service name instead of Additional Service
                                                            echo $service->getServiceName();
                                                            ?></a></td>
                                                    <?php if ($isMapDataAddedOS) { ?>
                                                    <td <?php if ($k % 2) {
                                                        echo 'class="odd"';
                                                    } ?>> <?php echo $service->getMapAreaData(); ?></td><?php } ?>
                                                    <td <?php echo ($k % 2) ? ' class="odd"' : ''; ?>
                                                            style="text-align: right">
                                                        <?php
                                                        // Price required for calculations
                                                        $price = (float)str_replace($s, $r, $service->getPrice());

                                                        //echo $service->getFormattedPrice();
                                                        echo '$' . number_format(($price - $taxprice), 2);
                                                        ?>
                                                    </td>
                                                </tr>
                                                <?php
                                                $total += $price;
                                               // $taxSubTotal += $taxprice;
                                                $taxSubTotal += isset($taxprice) ? $taxprice : 0;

                                            }
                                            ?>
                                            </tbody>
                                            <?php if (!isset($hideTotalPrice) || !$hideTotalPrice) { ?>
                                                <tfoot>
                                                <?php if ($taxSubTotal > 0) { ?>
                                                    <tr>
                                                        <td></td>
                                                        <?php if ($isMapDataAddedOS) { ?>
                                                            <td></td> <?php } ?>
                                                        <td align="right"><strong>Tax:</strong></td>
                                                        <td style="text-align: right">
                                                            $<?php echo number_format($taxSubTotal, 2) ?></td>
                                                    </tr>
                                                <?php } ?>

                                                </tfoot>
                                            <?php } ?>
                                        </table>
                                    </div>
                                    <?php
                                }
                                 // Optional Services for Snow Case 
                             }

                            ?>
                        </div>
                    </div>
                    <div class="row page_number">Page <?= $counterArray['price-breakdown'] ?></div>
                </div>

                <!-- END INVOICE -->
                <!-- BEGIN INVOICE -->

                <div class="grid invoice pdf-height page_break page_break_before mg-left-55" style="padding-top: 10px;"
                     id="signature" data-page-id="signature">
                    <div class="grid-body">
                        <div class="row">

                            <div class="row">
                                <h1 class="underlined global_header print_hide">Auth / Signature</h1>
                                <h1 class="underlined global_header only_show_print">Payment
                                    Terms: <?php echo $proposal->getProjectName() ?> </h1>
                                <div class="logotopright small_device_hide"><img class="theLogo"
                                                                               style="height: 35px; width: 120px; margin-right: 8px;"
                                                                               src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                                                                                   UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>"
                                                                               alt=""></div>

                            </div>
                        </div>
                        <div class="row">

                            <?php
                            if (trim($proposal->getClient()->getCompany()->getContractCopy())) { ?>
                                <h2 style="margin: 7px 0px 17px 0px">Authorization to Proceed & Contract</h2>
                                <p style="padding: 0; margin: 0;"><?php echo ($proposal->getContractCopy()) ? $proposal->getContractCopy() : $proposal->getClient()->getCompany()->getContractCopy() ?></p>
                            <?php } ?>

                            <h2 style="margin: 7px 0px 17px 0px">Acceptance</h2>
                            <div style="page-break-inside: avoid">


                                <p style="padding: 0; margin: 0;"><?php echo ($proposal->getPaymentTerm() == 0) ? 'We agree to pay the total sum or balance in full upon completion of this project.' : 'We agree to pay the total sum or balance in full ' . $proposal->getPaymentTerm() . ' days after the completion of work.'; ?></p>
                                <br/>

                                <!--Dynamic Section-->
                                <?php
                                echo ($proposal->getPaymentTermText()) ? $proposal->getPaymentTermText() : $proposal->getOwner()->getCompany()->getPaymentTermText();
                                ?>
                                <!--The signature and stuff-->

                                <table border="0" class="mg-t-22 ">
                                    <tr>
                                        <td width="30">Date:</td>
                                        <td width="120" id="signed_date" style="border-bottom: 1px solid #000;">
                                            &nbsp; <?php if ($clientSignature) {
                                                echo date_format(date_create($clientSignature->getCreatedAt()), "n/d/Y");
                                            } ?></span>
                                        </td>
                                    </tr>
                                </table>
                                <!-- <a type="button"  href="javascript:void(0)" id="deleteSignature">Delete signature</a> -->

                                <?php
                                if (!file_exists(UPLOADPATH . '/clients/signatures/signature-' . $proposal->getOwner()->getAccountId() . '.jpg') || $companySig) {
                                    echo '<br />';
                                }
                                ?>
                                <div class="row">
                                    <div class="col-md-6 col-lg-6 ">
                                        <div class="client_signature_td">
                                            <?php
                                            $show_client_sign_btn = 'show';
                                            if ($clientSignature) {
                                                $show_client_sign_btn = 'd-none';
                                                if (file_exists(UPLOADPATH . '/proposal_signature/' . $proposal->getProposalId() . '/' . $clientSignature->getSignatureFile())) { ?>
                                                    <img style="width: auto; max-height: 70px;"
                                                         src="<?php echo site_url('uploads/proposal_signature/' . $proposal->getProposalId() . '/' . $clientSignature->getSignatureFile() . '?') . mt_rand(0, 1000); ?>"
                                                         alt="">
                                                <?php }
                                                //Check signee view id
                                                if ($showCompanySignatureButton) {
                                                    ?>
                                                    <a type="button" class="btn btn-secondary btn-sm"
                                                       data-client-sign-id="<?= $clientSignature->getId(); ?>"
                                                       href="javascript:void(0)" id="deleteClientSignature"><i
                                                                class="fa fa-fw fa-trash"></i></a>
                                                <?php }

                                            }

                                            ?>
                                            <?php
                                            if ($proposal_preview_signature_link || $showCompanySignatureButton) {
                                                if ($clientSig) {
                                                    $client_names = explode(" ", $clientSig->getName());
                                                    $client_firstname = @$client_names[0];
                                                    $client_lastname = @$client_names[1];
                                                }

                                            ?>

                                            <button type="button" id="add_signature"
                                                    data-firstname="<?php echo ($clientSig) ? $client_firstname : $proposal->getClient()->getFirstName(); ?>"
                                                    data-lastname="<?php echo ($clientSig) ? $client_lastname : $proposal->getClient()->getLastName(); ?>"
                                                    data-company-name="<?php echo ($clientSig) ? $clientSig->getCompanyName() : $proposal->getClient()->getClientAccount()->getName(); ?>"
                                                    data-title="<?php echo ($clientSig) ? $clientSig->getTitle() : $proposal->getClient()->getTitle(); ?>"
                                                    data-email="<?php echo ($clientSig) ? $clientSig->getEmail() : $proposal->getClient()->getEmail(); ?>"

                                                    data-address="<?php echo ($clientSig) ? $clientSig->getAddress() : $proposal->getClient()->getAddress(); ?>"
                                                    data-city="<?php echo ($clientSig) ? $clientSig->getCity() : $proposal->getClient()->getCity(); ?>"
                                                    data-state="<?php echo ($clientSig) ? $clientSig->getState() : $proposal->getClient()->getState(); ?>"
                                                    data-zip="<?php echo ($clientSig) ? $clientSig->getZip() : $proposal->getClient()->getZip(); ?>"
                                                    data-cell-phone="<?php echo ($clientSig) ? $clientSig->getCellPhone() : $proposal->getClient()->getCellPhone(); ?>"
                                                    data-office-phone="<?php echo ($clientSig) ? $clientSig->getOfficePhone() : $proposal->getClient()->getBusinessPhone(true); ?>"

                                                    data-type="client" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"
                                                    class="btn btn-secondary btn-sm print_hide <?= $show_client_sign_btn; ?>">
                                                Sign
                                            </button>

                                            <?php }?>

                                        </div>
                                        <div valign="top" class="proposal-details">
                                            <?php
                                            if ($clientSignature) {
                                                ?>

                                                <?php echo $clientSignature->getFirstName() . ' ' . $clientSignature->getLastName() . ' | ' . $clientSignature->getTitle(); ?>
                                                <br/>
                                                <?php echo $clientSignature->getCompany() ?><br/>
                                                <?php echo $clientSignature->getAddress() ?><br/>
                                                <?php echo $clientSignature->getCity() ?>, <?php echo $clientSignature->getState(); ?><?php echo $clientSignature->getZip() ?>
                                                <br/>
                                                <a target="_blank"
                                                   href="mailto:<?php echo $clientSignature->getEmail(); ?>"><?php echo $clientSignature->getEmail(); ?></a>
                                                <br/>
                                                <?php

                                                if ($clientSignature->getCellPhone()) {
                                                    ?>
                                                    C: <?php echo $clientSignature->getCellPhone(); ?><br/>
                                                    <?php
                                                }
                                                ?>
                                                <?php
                                                if ($clientSignature->getOfficePhone()) {
                                                    ?>
                                                    O: <?php echo $clientSignature->getOfficePhone(); ?><br/>
                                                    <?php
                                                }


                                            } else if ($clientSig) {
                                                ?>

                                                <?php echo $clientSig->getName() . ' | ' . $clientSig->getTitle(); ?>
                                                <br/>
                                                <?php echo $clientSig->getCompanyName() ?><br/>
                                                <?php echo $clientSig->getAddress() ?><br/>
                                                <?php echo $clientSig->getCity() ?>, <?php echo $clientSig->getState(); ?><?php echo $clientSig->getZip() ?>
                                                <br/>
                                                <?php
                                                if ($clientSig->getEmail()) {
                                                    ?>
                                                    <a target="_blank"
                                                       href="mailto:<?php echo $clientSig->getEmail(); ?>"><?php echo $clientSig->getEmail(); ?></a>
                                                    <br/>
                                                    <?php
                                                }

                                                if ($clientSig->getCellPhone()) {
                                                    ?>
                                                    C: <?php echo $clientSig->getCellPhone(); ?><br/>
                                                    <?php
                                                }

                                                if ($clientSig->getOfficePhone()) {
                                                    ?>
                                                    O: <?php echo $clientSig->getOfficePhone(); ?><br/>
                                                    <?php
                                                }


                                            } else {
                                                echo $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName();
                                                if ($proposal->getClient()->getTitle()) {
                                                    echo ' | ' . $proposal->getClient()->getTitle();
                                                }
                                                ?> <br>
                                                <?php echo $proposal->getClient()->getClientAccount()->getName() ?><br>
                                                <?php echo $proposal->getClient()->getAddress() ?><br>
                                                <?php echo $proposal->getClient()->getCity() . ', ' . $proposal->getClient()->getState() . ' ' . $proposal->getClient()->getZip() ?>
                                                <br>
                                                <a target="_blank"
                                                   href="mailto:<?php echo $proposal->getClient()->getEmail() ?>">
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
                                            if ($clientSignature) {
                                                ?>
                                                <span id="signed_span">Signed : <?= date_format(date_create($clientSignature->getCreatedAt()), "m/d/y g:i A"); ?></span>
                                                <?php
                                            } else {
                                                echo '<br><span id="signed_span"></span>';
                                            }
                                            ?><br>
                                        </div>

                                    </div>
                                    <div class="col-md-6 col-lg-6 ">
                                        <div class="company_signature_td">
                                            <?php
                                            $show_company_sign_btn = 'show';
                                            if (file_exists(UPLOADPATH . '/clients/signatures/signature-' . $proposal->getOwner()->getAccountId() . '.jpg') && !$companySig) {
                                                $show_company_sign_btn = 'd-none';
                                               ?>
                                                <img style="width: auto; height: 70px;" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . '/clients/signatures/signature-' . $proposal->getOwner()->getAccountId() . '.jpg')) ?>" alt="">
                                            <?php
                                            }else  if ($companySignature) {
                                                $show_company_sign_btn = 'd-none';
                                                if (file_exists(UPLOADPATH . '/proposal_signature/' . $proposal->getProposalId() . '/' . $companySignature->getSignatureFile())) { ?>
                                                    <img style="width: auto; max-height: 70px;"
                                                         src="<?php echo site_url('uploads/proposal_signature/' . $proposal->getProposalId() . '/' . $companySignature->getSignatureFile() . '?') . mt_rand(0, 1000); ?>"
                                                         alt="">
                                                <?php }
                                                //Check signee view id
                                                if ($showCompanySignatureButton) {
                                                    ?>
                                                    <a type="button" class="btn btn-secondary btn-sm"
                                                       data-company-sign-id="<?= $companySignature->getId(); ?>"
                                                       href="javascript:void(0)" id="deleteCompanySignature"><i class="fa fa-fw fa-trash"></i></a>
                                                <?php }

                                            } else if (file_exists(UPLOADPATH . '/proposal_signature/' . $proposal->getProposalId() . '/company_signature.png')) {
                                                $show_company_sign_btn = 'd-none';
                                                ?>
                                                <img style="width: auto; max-height: 70px;"
                                                     src="<?php echo site_url('uploads/proposal_signature/' . $proposal->getProposalId() . '/company_signature.png?') . mt_rand(0, 1000); ?>"
                                                     alt="">
                                            <?php }
                                        if ($showCompanySignatureButton) {
                                            if ($companySig) {
                                                $company_firstname = $companySig->getFirstName();
                                                $company_lastname = $companySig->getLastName();
                                            }
                                            ?>

                                            <button type="button" id="add_signature_company"
                                                    data-firstname="<?php echo ($companySig) ? $company_firstname : $proposal->getOwner()->getFirstName(); ?>"
                                                    data-lastname="<?php echo ($companySig) ? $company_lastname : $proposal->getOwner()->getLastName(); ?>"
                                                    data-company-name="<?php echo ($companySig) ? $companySig->getCompanyName() : $proposal->getOwner()->getCompany()->getCompanyName(); ?>"
                                                    data-title="<?php echo ($companySig) ? $companySig->getTitle() : $proposal->getOwner()->getTitle(); ?>"
                                                    data-email="<?php echo ($companySig) ? $companySig->getEmail() : $proposal->getOwner()->getEmail(); ?>"

                                                    data-address="<?php echo ($companySig) ? $companySig->getAddress() : $proposal->getOwner()->getAddress(); ?>"
                                                    data-city="<?php echo ($companySig) ? $companySig->getCity() : $proposal->getOwner()->getCity(); ?>"
                                                    data-state="<?php echo ($companySig) ? $companySig->getState() : $proposal->getOwner()->getState(); ?>"
                                                    data-zip="<?php echo ($companySig) ? $companySig->getZip() : $proposal->getOwner()->getZip(); ?>"
                                                    data-cell-phone="<?php echo ($companySig) ? $companySig->getCellPhone() : $proposal->getOwner()->getCellPhone(); ?>"
                                                    data-office-phone="<?php echo ($companySig) ? $companySig->getOfficePhone() : ''; ?>"


                                                    data-type="company" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"
                                                    class="btn btn-secondary btn-sm print_hide <?= $show_company_sign_btn; ?>">
                                                Sign
                                            </button>

                                            <?php }?>
                                        </div>


                                        <div class="signee-details">

                                            <?php
                                            if ($companySignature) {
                                                ?>

                                                <?php echo $companySignature->getFirstName() . ' ' . $companySignature->getLastName() . ' | ' . $companySignature->getTitle(); ?>
                                                <br/>
                                                <?php echo $companySignature->getCompany() ?><br/>
                                                <?php echo $companySignature->getAddress() ?><br/>
                                                <?php echo $companySignature->getCity() ?>, <?php echo $companySignature->getState(); ?><?php echo $companySignature->getZip() ?>
                                                <br/>
                                                <a target="_blank"
                                                   href="mailto:<?php echo $companySignature->getEmail(); ?>"><?php echo $companySignature->getEmail(); ?></a>
                                                <br/>
                                                <?php
                                                if ($companySignature->getCellPhone()) {
                                                    ?>
                                                    C: <?php echo $companySignature->getCellPhone(); ?><br/>
                                                    <?php
                                                }

                                                if ($companySignature->getOfficePhone()) {
                                                    ?>
                                                    O: <?php echo $companySignature->getOfficePhone(); ?><br/>
                                                    <?php
                                                }

                                            } else if ($companySig) {
                                                ?>
                                                <?php echo $companySig->getName() . ' | ' . $companySig->getTitle(); ?>
                                                <br/>
                                                <?php echo $companySig->getCompanyName() ?><br/>
                                                <?php echo $companySig->getAddress() ?><br/>
                                                <?php echo $companySig->getCity() ?>, <?php echo $companySig->getState(); ?> <?php echo $companySig->getZip() ?>
                                                <br/>
                                                <?php
                                                if ($companySig->getEmail()) {
                                                    ?>
                                                    <a target="_blank"
                                                       href="mailto:<?php echo $companySig->getEmail(); ?>"><?php echo $companySig->getEmail(); ?></a>
                                                    <br/>
                                                    <?php
                                                }

                                                if ($companySig->getCellPhone()) {
                                                    ?>
                                                    C: <?php echo $companySig->getCellPhone(); ?><br/>
                                                    <?php
                                                }

                                                if ($companySig->getOfficePhone()) {
                                                    ?>
                                                    O: <?php echo $companySig->getOfficePhone(); ?><br/>
                                                    <?php
                                                }
                                                ?>
                                            <?php } else { ?>
                                                <?php echo $proposal->getOwner()->getFirstName() . ' ' . $proposal->getOwner()->getLastName() . ' | ' . $proposal->getOwner()->getTitle(); ?>
                                                <br>
                                                <?php echo $proposal->getOwner()->getCompany()->getCompanyName(); ?>
                                                <br>
                                                <?php echo $proposal->getOwner()->getAddress() ?><br>
                                                <?php echo $proposal->getOwner()->getCity() ?>, <?php echo $proposal->getOwner()->getState() ?><?php echo $proposal->getOwner()->getZip() ?>
                                                <br>
                                                E: <a target="_blank"
                                                      href="mailto:<?php echo $proposal->getOwner()->getEmail() ?>"><?php echo $proposal->getOwner()->getEmail() ?></a>
                                                <br>
                                                C: <?php echo $proposal->getOwner()->getCellPhone() ?><br/>
                                                P: <?php echo $proposal->getOwner()->getOfficePhoneExt() ? $proposal->getOwner()->getOfficePhone() . ' Ext ' . $proposal->getOwner()->getOfficePhoneExt() : $proposal->getOwner()->getOfficePhone(); ?>
                                                <br>
                                                <?php if ($proposal->getClient()->getCompany()->getFax() || $proposal->getOwner()->getFax()) { ?>
                                                    F: <?php echo ($proposal->getOwner()->getFax()) ? $proposal->getOwner()->getFax() : $proposal->getClient()->getCompany()->getFax() ?>
                                                    <br>
                                                <?php } ?>
                                                <a target="_blank"
                                                   href="<?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?>"><?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?></a>
                                            <?php } ?>
                                            <?php
                                            if ($companySignature) {

                                                ?>
                                                <span id="signed_company_span">Signed : <?= date_format(date_create($companySignature->getCreatedAt()), "m/d/y g:i A"); ?></span>
                                                <?php
                                            } else {
                                                echo '<br><span id="signed_company_span"></span>';
                                            }
                                            ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                        <div class="col-md-6 col-lg-6 ">
                                            <div class="other_signature_td <?= $show_client_sign_btn; ?>" style="border-bottom: 1px solid;position: relative;">
                                                <h5 style="font-weight:bold;width: 87%;font-size: 18px;text-align: center;">Click here if authorized signature <br/> is different than above</h5>
                                                <?php if ($clientSig) {
                                                    $client_names = explode(" ", $clientSig->getName());
                                                    $client_firstname = @$client_names[0];
                                                    $client_lastname = @$client_names[1];
                                                }?>
                                                <button type="button" id="add_other_signature"
                                                    data-firstname="<?php echo ($clientSig) ? $client_firstname : $proposal->getClient()->getFirstName(); ?>"
                                                    data-lastname="<?php echo ($clientSig) ? $client_lastname : $proposal->getClient()->getLastName(); ?>"
                                                    data-company-name="<?php echo ($clientSig) ? $clientSig->getCompanyName() : $proposal->getClient()->getClientAccount()->getName(); ?>"
                                                    data-title="<?php echo ($clientSig) ? $clientSig->getTitle() : $proposal->getClient()->getTitle(); ?>"
                                                    data-email="<?php echo ($clientSig) ? $clientSig->getEmail() : $proposal->getClient()->getEmail(); ?>"

                                                    data-address="<?php echo ($clientSig) ? $clientSig->getAddress() : $proposal->getClient()->getAddress(); ?>"
                                                    data-city="<?php echo ($clientSig) ? $clientSig->getCity() : $proposal->getClient()->getCity(); ?>"
                                                    data-state="<?php echo ($clientSig) ? $clientSig->getState() : $proposal->getClient()->getState(); ?>"
                                                    data-zip="<?php echo ($clientSig) ? $clientSig->getZip() : $proposal->getClient()->getZip(); ?>"
                                                    data-cell-phone="<?php echo ($clientSig) ? $clientSig->getCellPhone() : $proposal->getClient()->getCellPhone(); ?>"
                                                    data-office-phone="<?php echo ($clientSig) ? $clientSig->getOfficePhone() : ''; ?>"

                                                    data-type="other" data-bs-toggle="offcanvas"
                                                    data-bs-target="#offcanvasRight" aria-controls="offcanvasRight"
                                                    class="btn btn-secondary btn-sm print_hide ">
                                                    Sign
                                                </button>
                                            </div>    
                                        </div>
                                </div>

                                <div width="100%">

                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="row page_number">Page <?= $counterArray['signature']++ ?></div>
                </div>
                <!-- END INVOICE -->

                <!-- START CUSTOMER CHECK LIST -->
                <?php if($checkProposalChecklist==1) {?>
                 
                 <div class="grid invoice pdf-height page_break page_break_before mg-left-55" style="padding-top: 10px;"
                   id="signature" data-page-id="signature">
                  <div class="grid-body">
                      <div class="row">
                          <div class="row">
                              <h1 class="underlined global_header print_hide">Customer Checklist</h1>
                              <div class="logotopright small_device_hide">
                                      <img class="theLogo"
                                      style="height: 35px; width: 120px; margin-right: 8px;"
                                      src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                                      UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>"
                                      alt="">
                              </div>
                          </div>
                      </div>
                      <div class="row">
                       <div style="page-break-inside: avoid">
                             <div class="col-md-6 col-lg-6 ">

                                      <a href="#"   id="add_update_checklist"                                         
                                      data-type="client" data-bs-toggle="offcanvas"
                                      data-bs-target="#offcanvasChecklist" aria-controls="offcanvasRight"
                                      class="print_hide" style="text-decoration: none;font-size:18px;">
                                        Add/Edit
                                      </a>
                                 </div> 

                                      <input type="hidden" id="billing_proposal_id" name="billing_proposal_id"
                                         value="<?php echo $proposal->getProposalId(); ?>">
                                      <br>
                                      <table border="0" cellpadding="0" cellspacing="0" class="customer-checklist-table" >
                                          <tr>
                                              <td><p class="header_fix"  style="font-size:18px;margin-left:180px;">
                                              <h3>Customer Billing Information</h3></p></td>
                                          </tr>

                                          <tr><td colspan="2"> <span class="span-label"><strong>Billing Contact:</strong></span>  
                                          <span  class="span-data billing_contact">
                                              <?php if(isset($proposalChecklistData)){ echo $proposalChecklistData->getBillingContact();} ?></span></td> </tr>
                                      
                                          <tr>
                                              <td style="padding:0px;">
                                                  <table style="margin:0px;" class="customer-checklist-table2">
                                                      <tr >
                                                      <td class="span-label"><strong> Billing Address:</strong></td> 
                                                      <td class="span-data2 billing_address">
                                                      <?php if(isset($proposalChecklistData)){echo $proposalChecklistData->getBillingAddress(); }?></td>
                                                      </tr>
                                              
                                                  </table>
                                              </td>
                                          </tr>

                                          <tr>
                                              <td colspan="2"><span class="span-label"><strong>Phone:</strong></span>
                                              <span class="span-data billing_phone">
                                                  <?php if(isset($proposalChecklistData)){echo $proposalChecklistData->getBillingPhone();} ?>
                                              </span>
                                              </td>
                                          </tr>
                                          <tr>
                                              <td colspan="2"><span class="span-label billing-email"><strong>Billing Email:</strong></span>
                                              <span class="span-data billing_email"><?php if(isset($proposalChecklistData)){ echo $proposalChecklistData->getBillingEmail();} ?></span>
                                          </td>
                                          </tr>
                                          <tr>
                                          <td colspan="2"><span class="span-label "><strong>Property Owner Name:</strong></span>
                                          <span class="span-data property_owner_name">
                                              <?php  if(isset($proposalChecklistData)){echo $proposalChecklistData->getPropertyOwnerName(); }?></span>
                                          </td>

                                          </tr>

                                          <tr>
                                              <td style="padding:0px;">
                                                  <table style="margin:0px;" class="customer-checklist-table2">
                                                      <tr >
                                                      <td class="span-label"><strong> Address:</strong></td> 
                                                      <td class="span-data2 legal_address">
                                                          <?php  if(isset($proposalChecklistData)){echo $proposalChecklistData->getLegalAddress();} ?></td>
                                                      </tr>
                                              
                                                  </table>
                                              </td>
                                          </tr>

                                          <tr>
                                          <td colspan="2"><span class="span-label"><strong>Phone:</strong></span> 
                                          <span class="span-data customer_phone">
                                              <?php  if(isset($proposalChecklistData)) {echo $proposalChecklistData->getCustomerPhone();} ?></span>
                                              </td>

                                          </tr>
                                          <tr>
                                              <td colspan="2"><span class="span-label"><strong>Email:</strong></span>  
                                              <span class="span-data customer_email">
                                                  <?php if(isset($proposalChecklistData)) {echo $proposalChecklistData->getCustomerEmail();} ?></span></td>
                                          </tr>
                                          <tr>
                                              <td><p class="header_fix"  style="font-size:18px;margin-left:180px;">
                                              <h3>Onsite Contact Information</h3></p></td>
                                          </tr>
                                          <tr>
                                          <td colspan="2"><span class="span-label"><strong>Onsite Contact:</strong></span> 
                                          <span class="span-data onsite_contact">
                                              <?php if(isset($proposalChecklistData)) {echo $proposalChecklistData->getOnsiteContact();} ?></span></td>

                                          </tr>
                                          <tr>
                                              <td colspan="2"><span class="span-label"><strong>Phone:</strong></span> 
                                              <span class="span-data onsite_phone">
                                                  <?php  if(isset($proposalChecklistData)){echo $proposalChecklistData->getOnsitePhone(); }?></span></td>
                                          </tr>
                                          <tr>
                                          <td colspan="2"><span class="span-label"><strong>Email:</strong></span> 
                                          <span class="span-data onsite_email">
                                              <?php  if(isset($proposalChecklistData)) {echo $proposalChecklistData->getOnsiteEmail();} ?></span></td>

                                          </tr>
                                          <tr>
                                              <td colspan="2"><span class="span-label"><strong> Invoicing Portal Y/N:</strong></span>
                                              <span class="span-data invoicing_portal">
                                                  <?php  if(isset($proposalChecklistData)) {echo $proposalChecklistData->getInvoicingPortal();} ?></span></td>
                                          </tr>
                                          <tr>
                                          <td style="padding:0px;"> 
                                              <table style="margin:0px;" class="customer-checklist-table2">
                                                      <tr >
                                                      <td class="span-label"><strong>Special Instructions:</strong></td> 
                                                      <td class="span-data2 special_instruction">
                                                      <?php if(isset($proposalChecklistData)){echo $proposalChecklistData->getSpecialInstructions(); }?></td>
                                                      </tr>
                                              
                                                  </table>
                                          
                                          </td>
                                          </tr>

                                      </table>

                              <div width="100%">

                              </div>
                          </div>
                      </div>

                  </div>
                  <div class="row page_number">Page <?= $counterArray['signature'] ?></div>
                 </div>
                 <?php } ?>
               <!-- CLOSE CUSTOMER CHECK LIST-->

                <?php

                if (count($specs)) { ?>
                    <!-- BEGIN INVOICE -->

                    <div class="grid invoice pdf-height page_break mg-left-55" style="padding-top: 10px;">
                        <div class="grid-body">
                            <div class="row">


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
                                } ?>
                            </div>

                        </div>
                        <div class="row page_number">Page <?= $page++ ?></div>
                    </div>
                <?php } ?>

                <!-- END INVOICE -->


                <?php
                if ($havetexts) { ?>
                    <!-- BEGIN INVOICE -->

                    <div class="grid invoice pdf-height page_break page_break_before mg-left-55"
                         id="additional-info-section"
                         style="padding-top: 10px;min-height: auto;" data-page-id="terms">
                        <div class="grid-body">
                            <div class="row">

                                <div class="row">
                                    <h1 class="underlined global_header print_hide">Terms & Conditions</h1>
                                    <h1 class="underlined global_header only_show_print">Additional
                                        Info: <?php echo $proposal->getProjectName() ?> </h1>
                                    <div class="logotopright small_device_hide"><img class="theLogo"
                                                                                   style="height: 35px; width: 120px; margin-right: 8px;"
                                                                                   src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                                                                                       UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>"
                                                                                   alt=""></div>

                                </div>
                            </div>
                            <div class="row">
                                <?php
                                foreach ($proposal_categories as $catId => $on) {
                                    if ($on && isset($categories[$catId])) {
                                        $cat = $categories[$catId];
                                        if (count($cat['texts'])) {
                                            ?>
                                            <div class="avoid-break service-section" id="custom_text_<?= $catId; ?>">
                                                <h2 class="terms-header"><?php echo $cat['name'] ?></h2>
                                                <ol class="margin-bottom-10 li-m-b-6 terms-texts">
                                                    <?php
                                                    foreach ($cat['texts'] as $text) {
                                                        ?>
                                                        <li><?php echo $text; ?></li><?php
                                                    }
                                                    ?>
                                                </ol>
                                            </div>
                                            <?php
                                        }
                                    }
                                } ?>
                            </div>

                        </div>
                        <div class="row page_number">Page <?= $counterArray['additional-info-section'] ?></div>
                    </div>
                <?php } ?>
                <!-- END INVOICE -->
                <?php
                if ($proposal->getInventoryReportUrl()) { ?>
                    <!-- BEGIN INVOICE -->

                    <div class="grid invoice pdf-height page_break mg-left-55" style="padding-top: 10px;">
                        <div class="grid-body">
                            <div class="row">
                                <div class="item-content audit">
                                    <h2>Property Inventory Details</h2>

                                    <table>
                                        <tr>
                                            <td style="text-align: center">
                                                <a href="https://local.psa/location/inventory/report/<?php echo $proposal->getInventoryReportUrl() ?>"
                                                   target="_blank" style="display: block">
                                                    <img id="auditIcon"
                                                         src="<?php echo site_url('uploads/audit-icon.png'); ?>"/>
                                                </a>
                                                <p style="text-align: center; font-weight: bold; font-style: italic;">
                                                    Click to See</p>
                                            </td>
                                            <td style="font-size: 16px;">
                                                <p>We have performed an inventory of your site</p>
                                                <p>
                                                    <a href="https://local.psa/location/inventory/report/<?php echo $proposal->getInventoryReportUrl() ?>"
                                                       target="_blank">View your
                                                        Custom Site Inventory Report</a></p>
                                            </td>
                                        </tr>
                                    </table>
                                    <div class="audit-footer"></div>
                                </div>
                            </div>

                        </div>
                        <div class="row page_number">Page <?= $page++ ?></div>
                    </div>
                    <!-- END INVOICE -->
                    <?php
                    // Do we have inventory Data
                    if ($inventoryData) {
                        if (count($inventoryData->data->breakdown)) { ?>
                            <!-- BEGIN INVOICE -->

                            <div class="grid invoice pdf-height page_break mg-left-55" style="padding-top: 10px;">
                                <div class="grid-body">
                                    <div class="row">
                                        <div style="padding-top: 30px; page-break-inside: avoid;">
                                            <h3>Inventory Breakdown</h3>

                                            <table class="table mytable inventoryTable" style="width: 100%;"
                                                   border="none"
                                                   cellspacing="0">
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

                                </div>
                                <div class="row page_number">Page <?= $page++ ?></div>
                            </div>
                            <?php
                        } ?>
                        <!-- END INVOICE -->
                        <?php if (count($inventoryData->data->totals)) { ?>
                            <!-- BEGIN INVOICE -->

                            <div class="grid invoice pdf-height page_break mg-left-55" style="padding-top: 10px;">
                                <div class="grid-body">
                                    <div class="row">
                                        <div style="padding-top: 30px; page-break-inside: avoid;">
                                            <h3>Inventory Totals</h3>

                                            <table class="table mytable inventoryTable" style="width: 100%;"
                                                   border="none"
                                                   cellspacing="0">
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

                                </div>
                                <div class="row page_number">Page <?= $page++ ?></div>
                            </div>
                            <?php
                        } ?>
                        <!-- END INVOICE -->
                        <?php if (count($inventoryData->data->zoneItems)) { ?>
                            <!-- BEGIN INVOICE -->

                            <div class="grid invoice pdf-height page_break mg-left-55" style="padding-top: 10px;">
                                <div class="grid-body">
                                    <div class="row">
                                        <div style="padding-top: 30px; page-break-inside: avoid;">
                                            <h3>Inventory Zone Items Breakdown</h3>

                                            <table class="table mytable inventoryTable" style="width: 100%;"
                                                   border="none"
                                                   cellspacing="0">
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

                                </div>
                                <div class="row page_number">Page <?= $page++ ?></div>
                            </div>
                            <?php
                        } ?>
                        <!-- END INVOICE -->
                        <?php if (count($inventoryData->data->zoneItemTotals)) {
                            ?>
                            <!-- BEGIN INVOICE -->

                            <div class="grid invoice pdf-height page_break mg-left-55" style="padding-top: 10px;">
                                <div class="grid-body">
                                    <div class="row">
                                        <div style="padding-top: 30px; page-break-inside: avoid;">
                                            <h3>Inventory Zone Item Totals</h3>

                                            <table class="table mytable inventoryTable" style="width: 100%;"
                                                   border="none"
                                                   cellspacing="0">
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

                                </div>
                                <div class="row page_number">Page <?= $page++ ?></div>
                            </div>
                            <?php
                        }
                    }
                }
                ?>
                <!-- END INVOICE -->

                <?php $attachments = $proposal->getAttatchments();
                if (count($attachments) || count($proposal_attachments)) {
                    ?>
                    <div class="grid invoice pdf-height page_break_before mg-left-55" id="attachments"
                         data-page-id="attachments">
                        <div class="grid-body">

                            <div class="row">
                                <h1 class="underlined header_fix attachmentsHead global_header print_hide" >Attachments</h1>
                                <h1 class="underlined global_header only_show_print" style="width: 715px;">
                                    Attachments </h1>
                                <div class="logotopright small_device_hide" style="top: 45px!important;"><img
                                            class="theLogo" style="height: 35px; width: 120px; margin-right: 8px;"
                                            src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                                                UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>"
                                            alt=""></div>

                            </div>
                            <!--<p>Please click any of the links below to view and print all documents.</p>-->
                            <div class="row">
                                <?php
                                if (count($attachments)) {
                                    ?>
                                    <div class="attachmentsTypes">
                                        <h2 class="attachmentsTypeHead">Company Attachments</h2>
                                        <?php
                                        foreach ($attachments as $attachment) {
                                            $url = site_url('attachments/' . $proposal->getClient()->getCompany()->getCompanyId()) . '/' . $attachment->getFilePath();
                                            ?>
                                            <h3 id="AttachFile<?= $attachment->getAttatchmentId(); ?>"
                                                class="attachmentName"><a
                                                        href="<?php echo str_replace(' ', '%20', $url) ?>"
                                                        target="_blank"><?php echo $attachment->getFileName() ?></a>
                                            </h3>
                                            <?php
                                        } ?>
                                    </div>
                                <?php }
                                if (count($proposal_attachments)) {
                                    ?>
                                    <div class="attachmentsTypes">
                                        <h2 class="attachmentsTypeHead">Project Attachments</h2>
                                        <?php
                                        foreach ($proposal_attachments as $attachment) {
                                            $url = site_url('uploads/companies/' . $proposal->getClient()->getCompany()->getCompanyId() . '/proposals/' . $proposal->getProposalId() . '/' . $attachment->getFilePath());
                                            ?>
                                            <h3 class="attachmentName"><a
                                                        href="<?php echo str_replace(' ', '%20', $url) ?>"
                                                        target="_blank"><?php echo $attachment->getFileName() ?></a>
                                            </h3>
                                            <?php
                                        } ?>
                                    </div>
                                <?php } ?>
                            </div>
                            <div class="row page_number">Page <?= $counterArray['attachments'];?></div>

                        </div>
                    </div>
                <?php }
                ?>


                <button type="button" class="btn btn-newgrey mg-left-870 print_hide sectionChanger nextSection"
                        aria-label="Close">
                    <span class="carousel-control-next-icon custom-page-control-next-icon" aria-hidden="true"></span>
                </button>
            </div>

            <!-- End Doc section-->

        </div>

        <!--Client Canvas-->
        <div class="offcanvas offcanvas-none" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <legend class="text-left">Add Signature : <?php echo $proposal->getProposalTitle() ?></legend>
                <span class="new-popup-close-btn"><button type="button" class="btn-close text-reset btn-close-white"
                                                          data-bs-dismiss="offcanvas"
                                                          aria-label="Close"></button></span>
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
                                        $client_firstname = $clientSig->getFirstName();
                                        $client_lastname = $clientSig->getLastName();
                                    }

                                    ?>
                                    <input type="text" required name="firstname" class="form-control sign_popup_inputs"
                                           value=""
                                           id="signature_firstname" placeholder="Enter First Name">
                                    <input type="hidden" id="signature_type">
                                    <div class="invalid-feedback"> Please enter First Name</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="signature_lastname" class="form-label">Last Name</label>
                                    <input type="text" required name="lastname" class="form-control sign_popup_inputs"
                                           value=""
                                           id="signature_lastname" placeholder="Enter Last Name">
                                    <div class="invalid-feedback"> Please enter Last Name</div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="signature_company" class="form-label">Company Name</label>
                                    <input type="text" required name="company" class="form-control sign_popup_inputs"
                                           value=""
                                           id="signature_company" placeholder="Enter Company Name">
                                    <div class="invalid-feedback"> Please enter Company Name</div>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="signature_title" class="form-label">Title</label>
                                    <input type="text" required name="signature_title"
                                           class="form-control sign_popup_inputs"
                                           value=""
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
                                       name="email" class="form-control sign_popup_inputs"
                                       value=""
                                       id="signature_email" placeholder="Enter Email">
                                <input type="hidden" id="proposal_link_id" value="<?= $proposal_preview_link_id; ?>">
                                <div class="invalid-feedback"> Please enter a valid Email</div>

                            </div>


                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="signature_address" class="form-label">Address</label>

                                    <input type="text" required name="signature_address"
                                           class="form-control sign_popup_inputs"
                                           value=""
                                           id="signature_address" placeholder="Enter Address">

                                    <div class="invalid-feedback"> Please enter Address</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="signature_city" class="form-label">City</label>
                                    <input type="text" required name="signature_city"
                                           class="form-control sign_popup_inputs"
                                           value=""
                                           id="signature_city" placeholder="Enter City">
                                    <div class="invalid-feedback"> Please enter City</div>

                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="signature_state" class="form-label">State</label>
                                    <input type="text" required name="signature_state"
                                           class="form-control sign_popup_inputs"
                                           value=""
                                           id="signature_state" placeholder="Enter State">
                                    <div class="invalid-feedback"> Please enter State</div>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="signature_zip" class="form-label">Zip</label>
                                    <input type="text" required name="signature_zip"
                                           class="form-control sign_popup_inputs"
                                           value=""
                                           id="signature_zip" placeholder="Enter Zip">
                                    <div class="invalid-feedback"> Please enter Zip</div>

                                </div>

                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="signature_cell_phone" class="form-label">Cell Phone</label>
                                    <input type="text" required name="signature_cell_phone" pattern="^\d{3}-\d{3}-\d{4}$"
                                           class="form-control sign_popup_inputs"
                                           value=""
                                           id="signature_cell_phone" placeholder="Enter Cell Phone">
                                    <div class="invalid-feedback"> Please enter Cell Phone</div>

                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="signature_office_phone" class="form-label">Office Phone</label>
                                    <input type="text" required name="signature_office_phone"
                                           class="form-control sign_popup_inputs" pattern="^\d{3}-\d{3}-\d{4}$"
                                           value=""
                                           id="signature_office_phone" placeholder="Enter Office Phone">
                                    <div class="invalid-feedback"> Please enter Office Phone</div>

                                </div>

                            </div>

                            <div class="mb-3">
                                <label for="signature_comments" class="form-label">Comments</label>
                                <textarea class="form-control sign_popup_inputs" id="signature_comments" rows="3"
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
                                    <button class="nav-link" id="nav-choose-tab" data-bs-toggle="tab"
                                            data-bs-target="#nav-choose" type="button" role="tab"
                                            aria-controls="nav-choose" aria-selected="false">Type
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
                                <div class="tab-pane fade" id="nav-choose" role="tabpanel"
                                     aria-labelledby="nav-choose-tab">
                                    <div class="input-group" style="margin-top:20px;">
                                        <input type="text" placeholder="Type your name to sign" class="form-control"
                                               id="signature_type_input">

                                    </div>
                                    <div class="type_preview_box">
                                        <div class="choose_sign_option1 choose_sign_div">
                                            <input type="radio" class="sign_radio" id="choose_sign_option1" value="1"
                                                   name="choose_sign_radio"/>
                                            <input type="hidden" id="choose_sign_data_url_option1"
                                                   name="choose_sign_data_url_option1"/>
                                            <canvas id="choose_sign_canvas_option1" width="380" height="80"></canvas>

                                        </div>
                                        <div class="choose_sign_option2 choose_sign_div">
                                            <input type="radio" class="sign_radio" id="choose_sign_option2" value="2"
                                                   name="choose_sign_radio"/>
                                            <input type="hidden" id="choose_sign_data_url_option2"
                                                   name="choose_sign_data_url_option2"/>
                                            <canvas id="choose_sign_canvas_option2" width="380" height="80"></canvas>

                                        </div>
                                        <div class="choose_sign_option3 choose_sign_div">
                                            <input type="radio" class="sign_radio" id="choose_sign_option3" value="3"
                                                   name="choose_sign_radio"/>
                                            <input type="hidden" id="choose_sign_data_url_option3"
                                                   name="choose_sign_data_url_option3"/>
                                            <canvas id="choose_sign_canvas_option3" width="380" height="80"></canvas>

                                        </div>

                                    </div>

                                </div>
                                <span class="redhide signature_msg">Please provide a valid Signature</span>
                            </div>

                            <div class="col-md-12 text-right mt2rem">
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

                        </div>
                        
                        <!-- <a class="m-btn blue-button complate_job_costing disabled" href="javascript:void(0)" style="position: relative; margin:10px 0px" >Complete Job Costing</a> -->

                    </div>

                </form>
            </div>
        </div>
        <!--end Client Signature--->


        <div class="offcanvas offcanvas-none" tabindex="-1" id="offcanvasRight2" aria-labelledby="offcanvasRightLabel">

            <div class="offcanvas-body" style="border-top:1px solid #ccc">
                <span class="new-popup-close-btn"><button type="button" class="btn-close text-reset btn-close-white"
                                                          data-bs-dismiss="offcanvas"
                                                          aria-label="Close"></button></span>
                <!-- <button type="button" class="btn-close text-reset big_close_btn " style="top: 2px;right: 15px;"  data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>                    -->
                <div id="proposalCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                    <div class="carousel-inner" style="width:100%;">

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
                                    <div style="height: 11vh;overflow: auto;"><?php if ($image['notes'] != '') {
                                            echo $image['notes'];
                                        } else {
                                            echo 'No Image Notes';
                                        } ?></div>
                                </div>
                            </div>

                            <?php $k++;
                        } ?>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#proposalCarousel"
                            data-bs-slide="prev">
                        <span class="carousel-control-prev-icon custom-carousel-control-prev-icon"
                              aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#proposalCarousel"
                            data-bs-slide="next">
                        <span class="carousel-control-next-icon custom-carousel-control-next-icon"
                              aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>

<!--Map Image Offcanvas-->



        <div class="offcanvas offcanvas-none" tabindex="-1" id="offcanvasMapImage" aria-labelledby="offcanvasRightLabel">

            <div class="offcanvas-body" style="border-top:1px solid #ccc">
                <span class="new-popup-close-btn"><button type="button" class="btn-close text-reset btn-close-white"
                                                          data-bs-dismiss="offcanvas"
                                                          aria-label="Close"></button></span>
                <!-- <button type="button" class="btn-close text-reset big_close_btn " style="top: 2px;right: 15px;"  data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>                    -->
                <div id="proposalMapCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="false">
                    <div class="carousel-inner" style="width:100%;">

                        <?php
                        $k = 1;
                        foreach ($new_map_images as $image) { ?>
                            <div class="carousel-item pd-top-25 slide-image-<?= $k; ?>">
                                <div class="carousel-caption d-md-block pd-top-0-minus ">
                                    <h5><?php echo $image['title'] ?></h5>
                                </div>
                                <img src="<?php echo $image['src']; ?>" data-image-id="<?php echo $image['id']; ?>"
                                     class="d-block w-100 responsive carousel-img" alt="...">
                                <div class="carousel-caption d-md-block bottom-note">
                                    <h5>Image Notes</h5>
                                    <div style="height: 11vh;overflow: auto;"><?php if ($image['notes'] != '') {
                                            echo $image['notes'];
                                        } else {
                                            echo 'No Image Notes';
                                        } ?></div>
                                </div>
                            </div>

                            <?php $k++;
                        } ?>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#proposalMapCarousel"
                            data-bs-slide="prev">
                        <span class="carousel-control-prev-icon custom-carousel-control-prev-icon"
                              aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#proposalMapCarousel"
                            data-bs-slide="next">
                        <span class="carousel-control-next-icon custom-carousel-control-next-icon"
                              aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>
        </div>
        <!--End map image Offcanvas--> 
        <!-- ask question offcanvas-->
        <div class="offcanvas offcanvas-none offcanvas-410" tabindex="-1" id="offcanvasRight3"
             aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <legend class="text-left pave-text-color">Ask Question
                    : <?php echo $proposal->getProposalTitle() ?></legend>
                <span class="new-popup-close-btn"><button type="button" class="btn-close text-reset btn-close-white"
                                                          data-bs-dismiss="offcanvas"
                                                          aria-label="Close"></button></span>
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
                                <textarea class="form-control" id="ask_question" rows="4" minlength="20"
                                          required placeholder="Enter Question"></textarea>
                                <div class="invalid-feedback">Minimum 20 characters</div>
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
            <div class="offcanvas offcanvas-none" tabindex="-1" id="offcanvasRight4"
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
        <div class="offcanvas offcanvas-none offcanvas-410" tabindex="-1" id="serviceOffcanvasRight"
             aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <legend class="text-left pave-text-color ServiceNameHead">Project Specifications</legend>

                <span class="new-popup-close-btn"><button type="button" class="btn-close text-reset btn-close-white"
                                                          data-bs-dismiss="offcanvas"
                                                          aria-label="Close"></button></span>
            </div>
            <div class="offcanvas-body service-offcanvas-body service-section">

            </div>
            <div class="offcanvas-footer service-offcanvas-footer">

            </div>
        </div>
        <!-- end service offcanvas-->

        <!-- Image-Info offcanvas-->
        <div class="offcanvas offcanvas-none offcanvas-410" tabindex="-1" id="mobileImageInfo"
             aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <legend class="text-left pave-text-color mobile-image-info-offcanvas-title">Info</legend>
                <span class="new-popup-close-btn"><button type="button" class="btn-close text-reset btn-close-white"
                                                          data-bs-dismiss="offcanvas"
                                                          aria-label="Close"></button></span>
            </div>
            <div class="offcanvas-body mobile-image-info-offcanvas-body ">

            </div>

        </div>
        <!-- end service offcanvas-->
        <!-- Image-Info offcanvas-->
        <div class="offcanvas offcanvas-none offcanvas-410" tabindex="-1" id="mobileImageInfoNote"
             aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <legend class="text-left pave-text-color mobile-note-image-info-offcanvas-title">Info</legend>
                <span class="new-popup-close-btn"><button type="button" class="btn-close text-reset btn-close-white"
                                                          data-bs-dismiss="offcanvas"
                                                          aria-label="Close"></button></span>
            </div>
            <div class="offcanvas-body mobile-note-image-info-offcanvas-body ">

            </div>

        </div>
        <!-- end service offcanvas-->

        <!-- Info Header offcanvas-->
        <div class="offcanvas offcanvas-none offcanvas-410" tabindex="-1" id="offcanvasInfo"
             aria-labelledby="offcanvasRightLabel">
            <div class="offcanvas-header">
                <legend class="text-left pave-text-color ServiceNameHead">Information</legend>
                <span class="new-popup-close-btn"><button type="button" class="btn-close text-reset btn-close-white"
                                                          data-bs-dismiss="offcanvas"
                                                          aria-label="Close"></button></span>
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
        <div class="offcanvas offcanvas-none offcanvas-410" tabindex="-1" id="offcanvasPreProposal"
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


        <!-- Links in Proposal Services Opens here -->
        <div class="offcanvas offcanvas-none" tabindex="-1" id="proposalServiceLinks"
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


        <?php

        foreach ($proposal_videos as $video) {
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
                <div class="offcanvas  VideoPlayersOffcanvas" tabindex="-1"
                     id="VideoPlayersOffcanvas_<?php echo $video->getId(); ?>" aria-labelledby="offcanvasRightLabel">

            <span class="video-close-right-btn close_video_popup" data-video-id="<?php echo $video->getId(); ?>">
                <button type="button" class="btn-close text-reset btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
            </span>

                    <div class="offcanvas-body pad-top-0 video_player_iframe_body"
                         id="video_player_iframe_body_<?php echo $video->getId(); ?>">
                        <!-- <div class="videoLoaderDiv"><div class="spinner-border text-primary video-spinner" role="status" aria-hidden="true"></div><span class="spinner-text">Loading </span></div> -->
                        <iframe class="embed-responsive-item proposal_video_ifram <?php echo $iframVideoClass; ?>"
                                data-video-type="<?= $videoType; ?>" video_id="<?php echo $video->getId(); ?>"
                                id="embed-responsive-video-<?php echo $video->getId(); ?>"
                                src="<?php echo $finalUrl . $autoplay; ?>" style="-webkit-overflow-scrolling:touch;"
                                allowfullscreen allow="autoplay"></iframe>
                    </div>
                </div>
                <!--End Proposal Video Opens here -->

                <?php
            }
        }
        ?>

        <?php

        if($proposal_intro_video) {
            $buttonShow = false;
            $autoplay = '';
            $url = $proposal_intro_video->getVideoUrl();
            if ($proposal_intro_video->getEmbedVideoUrl()) {
                $finalUrl = $proposal_intro_video->getEmbedVideoUrl();
            } else {
                $finalUrl = $url;
            }
            $iframVideoClass = '';
            $videoType = $proposal_intro_video->getVideoType();
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
                <div class="offcanvas  VideoPlayersOffcanvas" tabindex="-1"
                     id="VideoPlayersOffcanvas_<?php echo $proposal_intro_video->getId(); ?>" aria-labelledby="offcanvasRightLabel">

            <span class="video-close-right-btn close_video_popup" data-video-id="<?php echo $proposal_intro_video->getId(); ?>">
                <button type="button" class="btn-close text-reset btn-close-white" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
            </span>

                    <div class="offcanvas-body pad-top-0 video_player_iframe_body"
                         id="video_player_iframe_body_<?php echo $proposal_intro_video->getId(); ?>">
                        <!-- <div class="videoLoaderDiv"><div class="spinner-border text-primary video-spinner" role="status" aria-hidden="true"></div><span class="spinner-text">Loading </span></div> -->
                        <iframe class="embed-responsive-item proposal_video_ifram <?php echo $iframVideoClass; ?>"
                                data-video-type="<?= $videoType; ?>" video_id="<?php echo $proposal_intro_video->getId(); ?>"
                                id="embed-responsive-video-<?php echo $proposal_intro_video->getId(); ?>"
                                src="<?php echo $finalUrl . $autoplay; ?>" style="-webkit-overflow-scrolling:touch;"
                                allowfullscreen allow="autoplay"></iframe>
                    </div>
                </div>
                <!--End Proposal Video Opens here -->

                <?php
            }
        }
        ?>


        <!--Service Image offCanvas--->

        <?php


        foreach ($services_org as $service) {

            $imagesTest = array();
            if (isset($service_images[$service->getServiceId()])) {

                foreach ($service_images[$service->getServiceId()] as $k => $service_image) {
                    if ($service_image['image']->getActive()) {
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

                if (count($imagesTest)) {


                    ?>
                    <div class="offcanvas offcanvas-none" tabindex="-1"
                         id="service_image_offcanvas_<?= $service->getServiceId(); ?>"
                         aria-labelledby="offcanvasRightLabel" style="top: 0;overflow-y: scroll;display:block">

                        <div class="offcanvas-body" style="border-top:1px solid #ccc">
                            <span class="new-popup-close-btn"><button type="button"
                                                                      class="btn-close text-reset btn-close-white"
                                                                      data-bs-dismiss="offcanvas"
                                                                      aria-label="Close"></button></span>
                            <!-- <button type="button" class="btn-close text-reset big_close_btn " style="top: 2px;right: 15px;z-index: 9999;"  data-bs-dismiss="offcanvas"
                                        aria-label="Close"></button>    -->
                            <div id="service_image_carousel_<?= $service->getServiceId(); ?>" class="carousel slide"
                                 data-bs-ride="carousel" data-bs-interval="false" data-bs-wrap="false">
                                <div class="carousel-inner" style="width:100%;">

                                    <?php
                                    $k = 1;
                                    foreach ($imagesTest as $image) { ?>
                                        <div class="carousel-item pd-top-25 slide-image-<?= $k; ?>">
                                            <div class="carousel-caption d-md-block pd-top-0-minus ">
                                                <h5><?php echo $image['title'] ?></h5>
                                            </div>
                                            <img src="<?php echo $image['src']; ?>"
                                                 data-image-id="<?php echo $image['id']; ?>"
                                                 class="d-block w-100 responsive carousel-img" alt="...">
                                            <div class="carousel-caption d-md-block bottom-note">
                                                <h5>Image Notes</h5>
                                                <div style="height: 11vh;overflow: auto;"><?php if ($image['notes'] != '') {
                                                        echo $image['notes'];
                                                    } else {
                                                        echo 'No Image Notes';
                                                    } ?></div>
                                            </div>
                                        </div>

                                        <?php $k++;
                                    } ?>
                                </div>

                                <button class="carousel-control-prev"
                                        style="margin-top: 30px;height: calc(100vh - 12vh);" type="button"
                                        data-bs-target="#service_image_carousel_<?= $service->getServiceId(); ?>"
                                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon custom-carousel-control-prev-icon"
                              aria-hidden="true"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next"
                                        style="margin-top: 30px;height: calc(100vh - 12vh);" type="button"
                                        data-bs-target="#service_image_carousel_<?= $service->getServiceId(); ?>"
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


    </div>
</div>


</div>
</div>



<!--Signature submit Modal popup-->
<div class="modal fade" id="submitSignModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" >
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
    <div class="modal-dialog modal-dialog-centered" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Your question has been submitted</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><i
                            class="fa fa-fw fa-check-circle"></i> Ok
                </button>

            </div>
        </div>
    </div>
</div>


<!--start Customer check list  submit Modal popup-->
<div class="modal fade" id="submitChecklistModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" >
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Success</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Proposal Custtomer Checklist data saved.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal"><i
                            class="fa fa-fw fa-check-circle"></i> Ok
                </button>

            </div>
        </div>
    </div>
</div>
<!--end Customer check list  submit Modal popup-->
<!--Start Customer Checklist Popup -->
<div tabindex="-1" class="offcanvas offcanvas-none  offcanvasChecklist" id="offcanvasChecklist" aria-labelledby="offcanvasRightLabel" style="top: 0;overflow-y: scroll;display:block">
           <input type="hidden" value="<?php if(isset($proposalChecklistData) && $proposalChecklistData){echo "1";}else{echo "0";}  ?>" id="checkCustomerChecklistData">
        <div class="offcanvas-header">
                <legend class="text-left">Customer Checklist</legend>
                <span class="new-popup-close-btn"><button type="button" class="btn-close text-reset btn-close-white"
                                                          data-bs-dismiss="offcanvas"
                                                          aria-label="Close"></button></span>
            </div>
            <div class="offcanvas-body">
                <form id="clientSignatureForm" onsubmit="return false;" class="g-3 needs-validation-checklist" novalidate>
                    <div class="row">
                    <input type="hidden" name="proposal_id" id="proposal_id" value="<?php echo $proposal->getProposalId(); ?>">

                        <hr/>
                        <!-- <div class="alert alert-primary" role="alert">
                            <i class="fa fa-fw fa-info-circle"></i> Draw or upload your signature below to accept the
                            contract. We will email you a copy of the proposal to confirm...........
                        </div> -->
                        <div class="col-md-6">
                            <h4 style="margin: 7px 0px 35px 4px;font-size:18px;"><strong>Customer Billing Information</strong></h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="billing_contact" class="form-label">Billing Contact</label>
                                    
                                <input type="text" required name="billing_contact" value="<?php if(isset($proposalChecklistData)){ echo $proposalChecklistData->getBillingContact();}else{ echo $proposal->getClient()->getFirstName()." ".$proposal->getClient()->getLastName();} ?>" class="form-control" id="billing_contact" placeholder="Enter Billing Contact">
                                    <div class="invalid-feedback"> Please enter Billing Contact</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="billing_phone" class="form-label">Phone</label>
                                        <input type="text" required name="billing_phone" pattern="^\d{3}-\d{3}-\d{4}$"
                                        class="form-control sign_popup_inputs" id="billing_phone" placeholder="Enter Phone" value="<?php if(isset($proposalChecklistData)){echo $proposalChecklistData->getBillingPhone();}else{ echo $proposal->getClient()->getBillingBusinessPhone();} ?>">
                                    <div class="invalid-feedback"> Please enter Phone</div>

                                </div>
                              
                            </div>
                            <div class="row">
                               
                                <div class="col-md-12 mb-3">
                                        <label for="billing_email" class="form-label">Billing Email</label>
                                        <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required
                                            name="billing_email" class="form-control sign_popup_inputs"
                                            value="<?php if(isset($proposalChecklistData)){ echo $proposalChecklistData->getBillingEmail();}else{ echo $proposal->getClient()->getBillingEmail();} ?>"
                                            id="billing_email" placeholder="Enter Billing Email">
                                        <input type="hidden" id="billing_email" name="billing_email" value="<?= $proposal_preview_link_id; ?>">
                                        <div class="invalid-feedback"> Please enter a valid Billing Email</div>
                                        </div>

                            </div>

                            <div class="row">
                            <div class="col-md-12 mb-3">
                                    <label for="billing_address" class="form-label">Billing Address</label>
                                    <textarea class="form-control sign_popup_inputs" name="billing_address" id="billing_address" rows="3"
                                          placeholder=" Please Billing Address"><?php if(isset($proposalChecklistData)){echo $proposalChecklistData->getBillingAddress(); }
                                          else{ echo $proposal->getClient()->getBillingAddress().", ".$proposal->getClient()->getBillingCity().", ".$proposal->getClient()->getBillingState().", ".$proposal->getClient()->getBillingZip();}?></textarea>
                                    <div class="invalid-feedback"> Please enter Billing Address</div>

                                </div>
                            </div>
                            

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="signature_address" class="form-label">Property Owner Name</label>

                                    <input type="text" required name="property_owner_name"
                                           class="form-control sign_popup_inputs"
                                           value="<?php  if(isset($proposalChecklistData)){echo $proposalChecklistData->getPropertyOwnerName(); }?>"
                                           id="property_owner_name" placeholder="Enter Property Owner Name">

                                    <div class="invalid-feedback"> Please enter Property Owner Name</div>
                                </div>

                                <div class="col-md-6 mb-3">
                                        <label for="signature_cell_phone" class="form-label">Phone</label>
                                        <input type="text" required name="customer_phone" pattern="^\d{3}-\d{3}-\d{4}$"
                                            class="form-control sign_popup_inputs"
                                            value="<?php  if(isset($proposalChecklistData)) {echo $proposalChecklistData->getCustomerPhone();} ?>"
                                            id="customer_phone" placeholder="Enter Phone">
                                        <div class="invalid-feedback"> Please enter Phone</div>

                                    </div>
                            </div>
                            <div class="row">
                            <div class="col-md-12 mb-3">
                                            <label for="signature_email" class="form-label">Email</label>
                                            <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required
                                                name="customer_email" class="form-control sign_popup_inputs"
                                                value="<?php if(isset($proposalChecklistData)) {echo $proposalChecklistData->getCustomerEmail();} ?>"
                                                id="customer_email" placeholder="Enter Email">
                                            <input type="hidden" id="proposal_link_id" value="<?= $proposal_preview_link_id; ?>">
                                            <div class="invalid-feedback"> Please enter a valid Email</div>
                                    </div>
                            </div>
                            <div class="row">
                            <div class="col-md-12 mb-3">
                                    <label for="signature_city" class="form-label">Legal Address</label>
                                    <textarea class="form-control sign_popup_inputs" id="legal_address" name="legal_address" rows="3"
                                          placeholder=" Please Legal Address"> <?php  if(isset($proposalChecklistData)){echo $proposalChecklistData->getLegalAddress();} ?> </textarea>
                                    <div class="invalid-feedback"> Please Legal Address</div>

                                </div>
                                  

                            </div> 

                        </div>
                        <div class="col-md-6">
                        <h4 style="margin: 7px 0px 35px 4px;font-size:18px;"><strong>Onsite Contact Information</strong></h4>

                        <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="signature_firstname" class="form-label">Onsite Contact</label>
                                    
                                    <input type="text" required name="onsite_contact" class="form-control sign_popup_inputs"
                                           value="<?php if(isset($proposalChecklistData)) {echo $proposalChecklistData->getOnsiteContact();} ?>"
                                           id="onsite_contact" placeholder="Enter Onsite Contact">
                                    <input type="hidden" id="signature_type">
                                    <div class="invalid-feedback"> Please enter Onsite Contact</div>
                                </div>
                                <div class="col-md-6 mb-3">
                                        <label for="signature_cell_phone" class="form-label">Phone</label>
                                        <input type="text" required name="onsite_phone" pattern="^\d{3}-\d{3}-\d{4}$"
                                            class="form-control sign_popup_inputs"
                                            value="<?php  if(isset($proposalChecklistData)){echo $proposalChecklistData->getOnsitePhone(); }?>"
                                            id="onsite_phone" placeholder="Enter Phone">
                                        <div class="invalid-feedback"> Please enter Phone</div>

                                    </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                        <label for="signature_email" class="form-label">Email</label>
                                        <input type="email" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$" required
                                            name="onsite_email" class="form-control sign_popup_inputs"
                                            value="<?php  if(isset($proposalChecklistData)) {echo $proposalChecklistData->getOnsiteEmail();} ?>"
                                            id="onsite_email" placeholder="Enter  Email">
                                        <input type="hidden"  id="onsite_email" value="<?php  if(isset($proposalChecklistData)) {echo $proposalChecklistData->getOnsiteEmail();} ?>">
                                        <div class="invalid-feedback"> Please enter a valid Email</div>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="invoicing_portal" class="form-label">Invoicing Portal Y/N</label><br>
                                    <input  type="radio" class="invoicing_portal" id="invoicing_portal_yes" name="invoicing_portal" value="Yes" <?php if(isset($proposalChecklistData)) { echo ($proposalChecklistData->getInvoicingPortal()=="Yes")?"checked":"unchecked";} ?> > Yes &nbsp;
                                    <input  type="radio" class="invoicing_portal" checked id="invoicing_portal_no" name="invoicing_portal" value="No"  <?php if(isset($proposalChecklistData)) { echo ($proposalChecklistData->getInvoicingPortal()=="No")?"checked":"unchecked";} ?>> No
                                    <input type="hidden" id="invoicing_portal" value="">
                                    <div class="invalid-feedback"> Please enter Invoicing Portal Y/N</div>
                                </div>

                            </div> 
                            

                            <div class="row">
                               
                                <div class="col-md-12 mb-3">
                                    <label for="signature_city" class="form-label">Special Instructions</label>
                                    <textarea name="special_instruction" class="form-control sign_popup_inputs" id="special_instruction" rows="3"
                                          placeholder=" Please Special Instructions"><?php  if(isset($proposalChecklistData)) {echo $proposalChecklistData->getSpecialInstructions();} ?>
                                        </textarea>
                                    <div class="invalid-feedback"> Please Special Instructions</div>

                                </div>
                            </div> 

                            <div class="col-md-12 text-right mt2rem">
                                <button id="save_checklist_btn" type="submit" name="submit" style="float:right"
                                        class="btn btn-primary  pull-right"><i class="fa fa-pencil-square-o"></i>Save
                                    
                                </button>
                                <div id="save_signature_loader">
                                    <div class="d-flex align-items-center">
                                        <div class="spinner-border text-primary" role="status" aria-hidden="true"></div>
                                        <span class="spinner-text">Please Save</span>
                                    </div>
                                </div>

                            </div>

                        </div>
                        
                        <!-- <a class="m-btn blue-button complate_job_costing disabled" href="javascript:void(0)" style="position: relative; margin:10px 0px" >Complete Job Costing</a> -->

                    </div>

                </form>
            </div>
  </div>

<!--End Customer Checklist Popup -->
<script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="<?php echo site_url('static') ?>/js/signature/signature_pad.umd.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.15/jquery.mask.min.js"></script>
<script src="<?php echo site_url('3rdparty/moment/moment.js') ?>"></script>
<script type="text/javascript">
    var site_url = '<?php echo site_url() ?>';
    var uuid = '<?php echo $uuid;?>';
    var showCompanySignatureButton = '<?=$showCompanySignatureButton;?>';
    var track_activity = '<?php echo $track_activity;?>';
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
    var nosidebar = '<?php echo $nosidebar;?>';
    var device = '<?php echo $device;?>';
    var YTplayer;
    var Vplayer;
    var videoType = '<?php echo $videoType;?>';
    var lastUpdatedTime = moment();
    var lastActionTime = moment();
    var lastUpdateCheckTime = moment();
    var videoPlayingTime = 0;
    var videoPlayertimer;
    var videoPaused = false;
    var currentVideoId = 0;
    var is_wo_page = false;

    videoPlayerCounterFunction = function () {
        video_object[currentVideoIndex].duration++;

        videoPlayertimer = setTimeout(function () {
            videoPlayerCounterFunction();
        }, 1000);
    };

    <?php
    foreach ($services_org as $service) {
    if(isset($service_images[$service->getServiceId()])){
    ?>
    if($('#service_image_offcanvas_<?=$service->getServiceId();?>').length){
        var serviceImageCanvas<?=$service->getServiceId();?> = document.getElementById('service_image_offcanvas_<?=$service->getServiceId();?>');
        serviceImageCanvas<?=$service->getServiceId();?>.addEventListener('show.bs.offcanvas', function (event) {

            if ($('#sizer').find('div:visible').data('size') == 'xs' || window.visualViewport.scale > 1) {
                event.stopPropagation();
                event.preventDefault();
            }

        })
    }

    <?php } }?> 

</script>

<script type="text/javascript" src="<?php echo site_url('3rdparty/sweetalert/sweetalert2.min.js'); ?>"></script>
<link rel="stylesheet" type="text/css" href="<?php echo site_url('3rdparty/sweetalert/sweetalert2.min.css'); ?>" media="all">
<script src="<?php echo site_url('static/js/preview-proposal-video-tracking-youtube.js'); ?>"></script>

<script src="https://player.vimeo.com/api/player.js"></script>
<script src="<?php echo site_url('static/js/preview-proposal-video-tracking-vimeo.js'); ?>"></script>

<script src="<?php echo site_url('static') ?>/js/preview-proposal.js?<?php echo time(); ?>"></script>

</body>
<div class="justify-content-center service_check_loader loader_overlay" style="display:none" ;>
    <div class="spinner-border text-primary" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
</div>
 
  <script>
    $(document).ready(function () {
        var offcanvasChecklist = $('#offcanvasChecklist');
        var pdfHeight = $('.pdf-height');

        // Event handler for when the offcanvas checklist is opened
        offcanvasChecklist.on('shown.bs.offcanvas', function () {
            // Hide the .pdf-height element
            pdfHeight.css('display', 'none');
        });

        // Event handler for when the offcanvas checklist is closed
        offcanvasChecklist.on('hidden.bs.offcanvas', function () {
            // Show the .pdf-height element
            pdfHeight.css('display', 'block');
        });


            //For handle check box of proposal checklist
            $('.invoicing_portal').on('change', function(){
            var invoicing_portal = $('.invoicing_portal:checked').val();
            $("#invoicing_portal").val(invoicing_portal);
        });

              //add_signature 

        $('#add_signature').on('click', function(){
        var data = $("#checkCustomerChecklistData").val();
        var checkProposalChecklist = $("#cusomterChecklist").val();
        if(data==0 && checkProposalChecklist==1 ){  
            $("#offcanvasRight").hide();
            $(".modal-backdrop").hide();
                swal({
                    type: 'info',
                    title: 'Disable ',
                    html: '<p>Please Fill the Customer Checklist Form Before Sign</p>',
                    showCloseButton: true,
                    onClose: () => {
                        // Add scrollbar to body when modal is closed
                        document.body.style.overflow = 'auto';
                    }
                });
        } else {  
            $("#offcanvasRight").show();
        }  
    }); 

    //add code for proposal slider on mobile view 
        // Event listener for images with class 'showProposalCarousel'
        $(document).on("click", ".showProposalCarousel", function() {
        // Add class 'show' and set visibility to 'visible' for #offcanvasRight2
        $("#offcanvasRight2").addClass("show").css("visibility", "visible");
    });

    $(document).on("click", ".proposal-slider-close, .new-popup-close-btn", function() {
        // Remove class 'show' and set visibility to 'hidden' for #offcanvasRight2
        $("#offcanvasRight2").removeClass("show").css("visibility", "hidden");
    });
 

});

</script>
<!-- End Customer Checklist Popup -->
</html>
<?php //die; ?>