var iframeLoaded = false;
var viewCreated = false;

var setupdateInterval = updateInterval * 1000;
var auditClicked = 0;
var imagesClicked = 0;
var serviceSpecClicked = [];
var signed = 0;
var printed = 0;
var videoPlayed = 0;
var videoPlaying = 0;
var oldVideoPlayTime = 0;
var pauseActivity = false;
var totalActivityDuration = 0;
var imagesViewed = [];
var service_section = [];
var videoDetails = {id:1,duration:0,clicks:0};
var YTplayer;
var pageData = {
    cover: 0,
    title: 0,
    audit: 0,
    provider: 0,
    services: 0,
    images: 0,
    video: 0,
    terms: 0,
    signature: 0,
    price: 0,
    attachments: 0,
    service_section:[],
}

var screenCastPlayPercent = 0;
var serviceLinkOpenTime = 0;
var service_text_links = [];
var serviceLink = '';
var currentServiceLinkIndex;
var auditLinkOpenTime = 0;
var auditLinkOpenTimer = 0;
var serviceTextOpenTime = 0;
var view_service_text = [];
var currentServiceTextIndex;
var image_object = [];
var currentImageIndex;
var imageOpenTime = 0;
var section_width_check;

var sectionFound = false;
var lastSection;


$(document).ready(function () {
    document.addEventListener('touchmove', handleTouchMove, false);
    window.scrollTo(0,1);
   
    section_width_check = (document.querySelector('#boxed-section').getBoundingClientRect().right - ((document.querySelector('#boxed-section').getBoundingClientRect().right - document.querySelector('#boxed-section').getBoundingClientRect().left) / 2));

    $( window ).resize(function(){
        
        setSectionWidth();
        
    });

    function viewSize() {
        return $('#sizer').find('div:visible').data('size');
    }

    if(viewSize() == 'xs'){
        var myOffcanvas = document.getElementById('offcanvasInfo');
        var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas)
        bsOffcanvas.show()
    }

    
    $('.openbtn').hide();
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
    


    if (nosidebar==1) {

        close_side_bar();
    }

    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation');
        var forms2 = document.querySelectorAll('.needs-validation2');

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {

                    if (!form.checkValidity()) {

                        event.preventDefault()
                        event.stopPropagation()
                    } else {
                        save_signature(this)
                    }

                    form.classList.add('was-validated')
                }, false)
            })

        Array.prototype.slice.call(forms2)
            .forEach(function (forms2) {
                forms2.addEventListener('submit', function (event) {

                    if (!forms2.checkValidity()) {

                        event.preventDefault()
                        event.stopPropagation()
                    } else {
                        submit_ask_question(this)
                    }

                    forms2.classList.add('was-validated')
                }, false)
            })
    })()


    var sectionIds = $('a.sep-link');
    var position = $(window).scrollTop(); 


    $(document).scroll(function () {

        handleScroll();
        
    });


    function handleScroll(){
        sectionFound = false;
        var scroll = $(window).scrollTop();
        $('.sep-link:focus').blur();
        sectionIds.each(function () {

            var container = $(this).attr('href');
            if (container.startsWith("#")) {
                if ($(container).offset()) {
                    var containerOffset = $(container).offset().top;
                } else {
                    var containerOffset = 0;
                }

                var containerHeight = $(container).outerHeight();
                var containerBottom = containerOffset + containerHeight;
                var scrollPosition = $(document).scrollTop() + 100;

                if (scrollPosition < containerBottom && scrollPosition >= containerOffset) {
                    $(this).addClass('active');
                    lastSection = $(this);
                    sectionFound = true;
                } else {
                    $(this).removeClass('active');
                }
            }
        });
        

        if (!sectionFound) {
            if (lastSection) {
                //$(lastSection).parent().next().find('a.sep-link').addClass('active');

                console.log(lastSection);
                if(scroll > position) {
                    console.log('scrollDown');
                    console.log($(lastSection).parent().next().find('a.sep-link').hasClass('sub_menu'))
                    if(!$(lastSection).closest('div').hasClass('collapse')){
                        if($(lastSection).parent().next().find('a.sep-link').hasClass('sub_menu')){
                            $(lastSection).parent().next().find('a.sep-link.sub_menu:first').addClass('active')
                        }else{
                            $(lastSection).parent().next().find('a.sep-link').addClass('active');
                        }
                    }
                    
                } else if(scroll < position) {
                    console.log('scrollUp');
                    console.log($(lastSection).parent().prev().find('a.sep-link').hasClass('sub_menu'));
                    if(!$(lastSection).closest('div').hasClass('collapse')){
                        if($(lastSection).parent().prev().find('a.sep-link').hasClass('sub_menu')){
                            $(lastSection).parent().prev().find('a.sep-link.sub_menu:last').addClass('active')
                        }else{
                            $(lastSection).parent().prev().find('a.sep-link').addClass('active');
                        }
                    }
                } else {
                    console.log('static');
                }
                position = scroll;
            }
        }

        if($('.sep-link').hasClass('active')){
            if(!$('.sep-link.active').hasClass('sub_menu')){
                console.log('out from tog')
                //closeAllPerentMenu();
                if(!$('.proposal_service_btn').hasClass('collapsed')){
                var myCollapse = document.getElementById('home-collapse')
                        var bsCollapse = new bootstrap.Collapse(myCollapse, {
                            toggle: true
                    })
                }
                
            }else{
                // //closeAllPerentMenu();
                // var parent_menu_class = $('.sep-link.active').attr('data-parent-menu-class');
                // var collapse_id = $('.sep-link.active').closest('div').attr('id');
                if(!$('.sep-link.active').closest('div').hasClass('show')){

               
                    //$('.sep-link.active').closest('.btn-toggle').dropdown('toggle');
                     var myCollapse = document.getElementById('home-collapse')
                         var bsCollapse = new bootstrap.Collapse(myCollapse, {
                         toggle: true
                     })
                    //openParentMenu(parent_menu_class,collapse_id);
                }
                
            }
        }
    }

    function handleTouchMove(){
        console.log('start touch')
        handleScroll();
        //$(document.elementFromPoint(x, y)).trigger('click');
    }

    $(document).on("click", ".closeProposalSignature", function () {
        $('.doc-section').show();
        $('.proposalSignature').hide();
        $('html, body').animate({
            scrollTop: $("#signature").offset().top
        }, 100);

    });

    // Count duration of Images canvas 
    imageCounterFunction = function(){
        // serviceLinkOpenTime++;
        image_object[currentImageIndex].duration++;   
        
        imageOpenTime = setTimeout(function(){
            imageCounterFunction();
        }, 1000);
    };
    
    // Duration of Images canvas
    var imageCanvas = document.getElementById('offcanvasRight2')
    imageCanvas.addEventListener('shown.bs.offcanvas', function () {
        imageCounterFunction();
        
    })
    imageCanvas.addEventListener('hidden.bs.offcanvas', function () {
        clearTimeout(imageOpenTime);
    });


    $(document).on("click", ".showProposalCarousel", function () {
        var slide_id = $(this).attr('data-slide');
        var imageId = String($(this).attr('data-image-id'));
     
        if(jQuery.inArray(imageId, imagesViewed) == -1){
            imagesViewed.push(imageId);
        }
        $('.carousel-item').removeClass('active');
        $('.' + slide_id).addClass('active');
        imagesClicked = 1;

        objIndex = image_object.findIndex((obj => obj.imageId == imageId));
        if(objIndex == -1){
            image_object.push({"imageId": imageId,"duration": 0,"clicks":0})
            objIndex = image_object.findIndex((obj => obj.imageId == imageId));
        }
        
        currentImageIndex = objIndex;
        image_object[currentImageIndex].clicks++; 

    })

    $(document).on("click", ".closeProposalCarousel", function () {
        $('.doc-section').show();
        $('.proposalCarousel').hide();
        $('.closeProposalCarousel').hide();
        $('html, body').animate({
            scrollTop: $("#images").offset().top
        }, 0);
    })

    $(document).on("click", ".closeNav", function () {

        close_side_bar();
        setSectionWidth();
    })

    function close_side_bar() {
        document.getElementById("navbar-example3").style.width = "0";
        document.getElementById("boxed-section").style.width = "100%";
        document.getElementById("followTab").style.left = "20px";
        $('.closeNav').addClass('openNav'); 
        $('.closeNav').removeClass('closeNav'); 

    }
    // $(document).on("click", ".openbtn", function() {
    //     $('#navbar-example3').show("slide", { direction: "left"}, 100);
    //     $('#boxed-section').removeClass('boxed-section-wide'); 
    //     $('#boxed-section').addClass('boxed-section'); 
    //     $('.openbtn').hide();
    //     if($('.boxed-section').width() <= 768) {
    //         $('.button-text').hide();
    //     }
    //     setSectionWidth();

    // });
    $(document).on("click", ".openNav", function() {
        document.getElementById("navbar-example3").style.width = "25%";
        document.getElementById("boxed-section").style.width = "75%";
        document.getElementById("followTab").style.left = "25%";

        $('.openNav').addClass('closeNav'); 
        $('.openNav').removeClass('openNav'); 
        setSectionWidth();
        
    });




    $(document).on("click", "#ask_question_open_canvas_btn", function () {

        $('#ask_question').val('');
        $('#ask_question_loader').hide();

    })


    var wrapper = document.getElementById("signature-pad");
    var clearButton = wrapper.querySelector("[data-action=clear]");
    var changeColorButton = wrapper.querySelector("[data-action=change-color]");
    var undoButton = wrapper.querySelector("[data-action=undo]");
    var savePNGButton = wrapper.querySelector("[data-action=save-png]");
    var saveJPGButton = wrapper.querySelector("[data-action=save-jpg]");
    var saveSVGButton = wrapper.querySelector("[data-action=save-svg]");
    var canvas = wrapper.querySelector("canvas");
    var signaturePad = new SignaturePad(canvas, {
        // It's Necessary to use an opaque color when saving image as JPEG;
        // this option can be omitted if only saving as PNG or SVG
        backgroundColor: 'rgb(255, 255, 255)'
    });

    // Adjust canvas coordinate space taking into account pixel ratio,
    // to make it look crisp on mobile devices.
    // This also causes canvas to be cleared.
    function resizeCanvas() {
        // When zoomed out to less than 100%, for some very strange reason,
        // some browsers report devicePixelRatio as less than 1
        // and only part of the canvas is cleared then.
        var ratio = Math.max(window.devicePixelRatio || 1, 1);
        // This part causes the canvas to be cleared
        canvas.width = canvas.offsetWidth * ratio;
        canvas.height = canvas.offsetHeight * ratio;
        //canvas.height = 150;
        canvas.getContext("2d").scale(ratio, ratio);

        // This library does not listen for canvas changes, so after the canvas is automatically
        // cleared by the browser, SignaturePad#isEmpty might still return false, even though the
        // canvas looks empty, because the internal data of this library wasn't cleared. To make sure
        // that the state of this library is consistent with visual state of the canvas, you
        // have to clear it manually.
        signaturePad.clear();
    }

    // On mobile devices it might make more sense to listen to orientation change,
    // rather than window resize events.
    window.onresize = resizeCanvas;
    resizeCanvas();

    function download(dataURL, filename) {
        if (navigator.userAgent.indexOf("Safari") > -1 && navigator.userAgent.indexOf("Chrome") === -1) {
            window.open(dataURL);
        } else {
            var blob = dataURLToBlob(dataURL);
            var url = window.URL.createObjectURL(blob);

            var a = document.createElement("a");
            a.style = "display: none";
            a.href = url;
            a.download = filename;

            document.body.appendChild(a);
            a.click();

            window.URL.revokeObjectURL(url);
        }
    }

    // One could simply use Canvas#toBlob method instead, but it's just to show
    // that it can be done using result of SignaturePad#toDataURL.
    function dataURLToBlob(dataURL) {
        // Code taken from https://github.com/ebidel/filer.js
        var parts = dataURL.split(';base64,');
        var contentType = parts[0].split(":")[1];
        var raw = window.atob(parts[1]);
        var rawLength = raw.length;
        var uInt8Array = new Uint8Array(rawLength);

        for (var i = 0; i < rawLength; ++i) {
            uInt8Array[i] = raw.charCodeAt(i);
        }

        return new Blob([uInt8Array], {
            type: contentType
        });
    }

    clearButton.addEventListener("click", function (event) {
        signaturePad.clear();
    });

    undoButton.addEventListener("click", function (event) {
        var data = signaturePad.toData();

        if (data) {
            data.pop(); // remove the last dot or line
            signaturePad.fromData(data);
        }
    });
    $("#clientSignatureForm").submit(function (ev) {
        ev.preventDefault();
    });


    function save_signature(e) {
        var dataURL = false;
        if (signaturePad.isEmpty()) {

            if (document.getElementById("signature_file_input").files.length == 0) {
                $('.signature_msg').show();
            } else {
                var dataURL = $('#signature_url').val();
            }

        } else {
            $('.signature_msg').hide();

            var dataURL = signaturePad.toDataURL();
            $('#signature_url').val(dataURL);
        }
        if (dataURL) {
            $('#save_signature_loader').css('display', 'inline-block');
            var signature_title = $('#signature_title').val();
            var signature_firstname = $('#signature_firstname').val();
            var signature_lastname = $('#signature_lastname').val();
            var signature_company = $('#signature_company').val();
            var signature_email = $('#signature_email').val();
            var proposal_id = $('#proposal_id').val();
            var signature_comments = $('#signature_comments').val();


            $.ajax({
                url: site_url + 'ajax/client_signature_form_submit',
                type: "POST",
                data: {
                    "signature": dataURL,
                    "signature_title": signature_title,
                    "signature_firstname": signature_firstname,
                    "signature_lastname": signature_lastname,
                    "signature_company": signature_company,
                    "signature_email": signature_email,
                    "proposal_id": proposal_id,
                    "signature_comments": signature_comments,

                },
                dataType: "json",
                success: function (data) {
                    if (data.success) {

                        $('#submitSignModal').modal('show');
                        //refresh frame
                        $('.client_signature_td').html('');
                        $('.client_signature_td').html('<img style="width: auto; height: 70px;" src="' + data.src + '">')

                        $('#signed_span').html('Signed : ' + data.signed);
                        jQuery('#offcanvasRight').offcanvas('hide');
                        signed = 1;
                    } else {
                        if (data.error) {
                            alert("Error: " + data.error);
                        } else {
                            alert('An error has occurred. Please try again later!')
                        }
                    }
                }
            })
        }
    }

    function submit_ask_question(e) {

        $('#ask_question_loader').css('display', 'inline-block');
        var ask_question_title = $('#ask_question_title').val();
        var ask_question_firstname = $('#ask_question_firstname').val();
        var ask_question_lastname = $('#ask_question_lastname').val();
        var ask_question_company = $('#ask_question_company').val();
        var ask_question_email = $('#ask_question_email').val();
        var ask_question_proposal_id = $('#ask_question_proposal_id').val();
        var ask_question = $('#ask_question').val();


        $.ajax({
            url: site_url + 'ajax/web_proposal_question_form_submit',
            type: "POST",
            data: {
                "ask_question_title": ask_question_title,
                "ask_question_firstname": ask_question_firstname,
                "ask_question_lastname": ask_question_lastname,
                "ask_question_company": ask_question_company,
                "ask_question_email": ask_question_email,
                "proposal_id": ask_question_proposal_id,
                "ask_question": ask_question,

            },
            dataType: "json",
            success: function (data) {
                if (data.success) {

                    $('#submitAskQuestionModal').modal('show');
                    //refresh frame

                    jQuery('#offcanvasRight3').offcanvas('hide');
                } else {
                    if (data.error) {
                        alert("Error: " + data.error);
                    } else {
                        alert('An error has occurred. Please try again later!')
                    }
                }
            }
        });

    }

    var isFirefox = (navigator.userAgent.indexOf('Firefox') !== -1);
    var zoom = 1;
    var hearZoomFix =1;
	var multiplierZoom = 1;	
    $('.zoom').on('click', function(){
        var current_active_section = $('.sep-link.active').attr('href');
        zoom += 0.1;
        hearZoomFix -=0.1;
        $('.doc-section').css('zoom', zoom);
        $('#infoHeader').css('zoom', hearZoomFix);
        
        
        if(isFirefox){
            document.getElementById("doc-section").style.transform = "scale("+zoom+")";
        }
        if(current_active_section){
            var tops = parseInt(45*multiplierZoom);
            console.log(tops);
            window.scrollTo(0,parseInt(($(current_active_section).offset().top)+ tops));
            
        }
        multiplierZoom +=1;
        check_reset_zoom();
    });
    $('.zoom-init').on('click', function(){
        zoom = 1;
        hearZoomFix= 1;
        $('.doc-section').css('zoom', zoom);
        $('#infoHeader').css('zoom', zoom);
        if(isFirefox){
            document.getElementById("doc-section").style.transform = "scale("+zoom+")";
        }

       
        check_reset_zoom();
    });
    $('.zoom-out').on('click', function(){
        var current_active_section = $('.sep-link.active').attr('href');
       
        zoom -= 0.1;
        hearZoomFix +=0.1;
        $('.doc-section').css('zoom', zoom);
        $('#infoHeader').css('zoom', hearZoomFix);
        if(isFirefox){
            document.getElementById("doc-section").style.transform = "scale("+zoom+")";
        }

        if(current_active_section){
            var tops = parseInt(45*multiplierZoom);
            console.log(tops);
            window.scrollTo(0,parseInt(($(current_active_section).offset().top)- tops));
            
        }
        multiplierZoom -=1;
        check_reset_zoom();
    });

    function check_reset_zoom(){
        if(zoom==1){
            $('.zoom-init').hide();
        }else{
            $('.zoom-init').show();
        }
    }



    $("body").on("click scroll wheel touchstart keydown mousedown mousemove", function() {

        lastActionTime = moment();
        pauseActivity = false;
        if(!viewCreated && track_activity==1){
            viewCreated = true;
            $.ajax({
                url: site_url + 'pdf/createPageView',
                type: "POST",
                data: {
                "uuid": uuid,
                },
                dataType: "json",
                success: function (response) {
                    
                    if(response.succes) {
                        proposalViewId = response.proposal_view_id;
                        viewCreated = true;
                        pageData = JSON.parse(response.proposal_view_data);
                        totalActivityDuration = response.proposal_total_duration;
                        
                        if(response.proposal_image_viewed){ 
                            imagesViewed = JSON.parse(response.proposal_image_viewed);
                        }

                        if(response.proposal_video_viewed){
                            var proposal_video_viewed = JSON.parse(response.proposal_video_viewed);
                            
                            if(proposal_video_viewed){
                                videoDetails = proposal_video_viewed;
                                oldVideoPlayTime = proposal_video_viewed.duration;
                               
                            }
                        }

                        if(response.proposal_service_spec_viewed){ 
                            serviceSpecClicked = JSON.parse(response.proposal_service_spec_viewed);
                        }

                        if(response.image_object){ 
                            image_object = JSON.parse(response.image_object);
                        }
                        if(response.view_service_text){ 
                            view_service_text = JSON.parse(response.view_service_text);
                        }
                        if(response.auditLinkOpenTime){
                            auditLinkOpenTimer = response.auditLinkOpenTime;
                        }
                        if(response.service_text_links){ 
                            service_text_links = JSON.parse(response.service_text_links);
                        }
                        if(response.auditClicked){ 
                            auditClicked = response.auditClicked;
                        }

                        
                       
                    }
                }
            })
        }

        

    });

    
    if(track_activity==1){
    
        setInterval(function(){ 
        lastUpdateCheckTime = moment();
        
        if(lastUpdatedTime.isBefore(lastActionTime)){
            pauseActivity = false;
            updatePageData()
            
        }else{
            pauseActivity = true;
        }
    }, setupdateInterval);
}


    function updatePageData(){
        var videoDuration = 0;
     
        if(videoType == 'youtube' && YTplayer.s){
            
            videoDuration = parseInt(YTplayer.getCurrentTime());
        }else if(videoType == 'vimeo' && Vplayer){
           
            videoDuration = parseInt(Vplayer.currentTime);
        }

        if(videoDuration > 0){
            
             videoDetails['duration'] = parseInt(oldVideoPlayTime) + parseInt(videoPlayingTime);
            
        }
      
       
        $.ajax({
            url: site_url + 'ajax/updateProposalPreviewData',
            type: "POST",
            data: {
                "proposalViewId": proposalViewId,
                "lastUpdatedTime" : lastUpdatedTime.format(),
                "lastActionTime" : lastActionTime.format(),
                "lastUpdateCheckTime" : lastUpdateCheckTime.format(),
                "auditClicked" : auditClicked,
                "pageData": pageData,
                "imagesClicked": imagesClicked,
                "serviceSpecClicked" : serviceSpecClicked,
                "signed": signed,
                "printed": printed,
                "videoPlayed": videoDetails,
                "videoDuration" : videoDuration,
                "totalActivityDuration" : totalActivityDuration,
                "imagesViewed" : imagesViewed,
                "videoType" :videoType,
                "screenCastPlayPercent" :screenCastPlayPercent,
                "serviceTextLinks" : service_text_links,
                "auditIframeOpenTime" : auditLinkOpenTimer,
                "viewedImagesData" : image_object,
                "viewServiceText" : view_service_text,

            },
            dataType: "json",
            success: function (response) {
                
                 if(response.success) {
                    lastUpdatedTime = moment();
                   
                 }
                 
                 if(videoPlaying == 1){
                    
                    lastActionTime = moment().add(1, 'seconds');;
                 }
                 


            }
        }) 
    }


    // Open Canvas or in new tab on click(service links)
    $('.service-section a').on('click', function (e){
        e.preventDefault();
        $('.service_check_loader').fadeIn();
    
        serviceLink = $(this).attr('href');
        $.ajax({
            url: site_url + 'ajax/checkXFrameOption',
            type: "POST",
            data: {
            "link": serviceLink,
            },
            dataType: "json",
            success: function (response) {
                
                if(response.success) {
                    objIndex = service_text_links.findIndex((obj => obj.url == serviceLink));
                    if(objIndex == -1){
                        service_text_links.push({"url": serviceLink,"duration": 0,"clicks":1})
                        objIndex = service_text_links.findIndex((obj => obj.url == serviceLink));
                    }else{
                        service_text_links[objIndex].clicks++;   
                    }
                    currentServiceLinkIndex = objIndex;

                    $('#proposalServiceLinksIframe').attr('data-src', serviceLink);
                    $('.service_check_loader').fadeOut();
                    $('#proposalServiceLinks').offcanvas('show');
                    
                        $('#service_links_iframe_loader').show();
                        $("#proposalServiceLinksIframe").hide();
                
                            $("#proposalServiceLinksIframe").attr('src', serviceLink);
                
                            document.getElementById('proposalServiceLinksIframe').onload = function() {
                
                                $("#service_links_iframe_loader").hide();
                                $("#proposalServiceLinksIframe").show();
                                serviceLinksCounterFunction();
                            }
                
                        
                        return false;

                } else {
                    window.open(serviceLink);
                    objIndex = service_text_links.findIndex((obj => obj.url == serviceLink));
                    if(objIndex == -1){
                        service_text_links.push({"url": serviceLink,"duration": -1,"clicks":1})
                        
                    }else{
                        service_text_links[objIndex].clicks++;   
                    }
                    $('.service_check_loader').fadeOut();
                }
            }
        })
        
        
    })




    var proposalServiceLinksOffcanvas = document.getElementById('proposalServiceLinks');
    // proposalServiceLinksOffcanvas.addEventListener('shown.bs.offcanvas', function () {
    //     // do something...
    //     })
    proposalServiceLinksOffcanvas.addEventListener('hidden.bs.offcanvas', function () {
        clearTimeout(serviceLinkOpenTime);
    })

    serviceLinksCounterFunction = function(){
        
        service_text_links[currentServiceLinkIndex].duration++;   
        
        serviceLinkOpenTime = setTimeout(function(){
            serviceLinksCounterFunction();
        }, 1000);
    };


       // Audit canvas total duration
       auditCounterFunction = function(){
        auditLinkOpenTimer++;
         
        
        auditLinkOpenTime = setTimeout(function(){
            auditCounterFunction();
        }, 1000);
    };

    
    
    // Duration of service link canvas
    var openAuditIframe = document.getElementById('offcanvasRight4')
    openAuditIframe.addEventListener('shown.bs.offcanvas', function () {
        if(iframeLoaded){
            auditCounterFunction();
        }
    })
    openAuditIframe.addEventListener('hidden.bs.offcanvas', function () {
        clearTimeout(auditLinkOpenTime);
    });

    //service text canvas view duration 
    serviceTextCounterFunction = function(){
        view_service_text[currentServiceTextIndex].duration++;   
        
        serviceTextOpenTime = setTimeout(function(){
            serviceTextCounterFunction();
        }, 1000);
    };
    
    // Duration of service link canvas
    var serviceOffcanvasRight = document.getElementById('serviceOffcanvasRight')
    serviceOffcanvasRight.addEventListener('shown.bs.offcanvas', function () {
        serviceTextCounterFunction();
    })
    serviceOffcanvasRight.addEventListener('hidden.bs.offcanvas', function () {
        clearTimeout(serviceTextOpenTime);
        
    });



    


      window.onbeforeunload = function(e) {

        var videoDuration = 0;
     
        if(videoType == 'youtube' && YTplayer.s){
            
            videoDuration = parseInt(YTplayer.getCurrentTime());
        }else if(videoType == 'vimeo' && Vplayer){
           
            videoDuration = parseInt(Vplayer.currentTime);
        }

        if(videoDuration > 0){
            
             videoDetails['duration'] = parseInt(oldVideoPlayTime) + parseInt(videoPlayingTime);
            
        }
      
        
            untrackdata = {
                "proposalViewId": proposalViewId,
                "lastUpdatedTime" : lastUpdatedTime.format(),
                "lastActionTime" : lastActionTime.format(),
                "lastUpdateCheckTime" : lastUpdateCheckTime.format(),
                "auditClicked" : auditClicked,
                "pageData": pageData,
                "imagesClicked": imagesClicked,
                "serviceSpecClicked" : serviceSpecClicked,
                "signed": signed,
                "printed": printed,
                "videoPlayed": videoDetails,
                "videoDuration" : videoDuration,
                "totalActivityDuration" : totalActivityDuration,
                "imagesViewed" : imagesViewed,
                "videoType" :videoType,
                "screenCastPlayPercent" :screenCastPlayPercent,
                "serviceTextLinks" : service_text_links,
                "auditIframeOpenTime" : auditLinkOpenTimer,
                "viewedImagesData" : image_object,
                "viewServiceText" : view_service_text,

            };

          
              let headers = {
                type: 'application/json'
              };
              let blob = new Blob([JSON.stringify(untrackdata)], headers);
        navigator.sendBeacon(
            site_url + 'ajax/updateProposalPreviewData',
            blob
        )
  
        // empty return is required to not show popup
        return
      }

      setTimeout(function(){
        $('#audit_iframe_loader').show();
        $("#auditIframe").hide();
    
            var iframeSrc = $("#auditIframe").data('src');
        
            if (!$("#auditIframe").attr('src')) {

                $("#auditIframe").attr('src', iframeSrc);
                document.getElementById('auditIframe').onload = function() {
                    $("#audit_iframe_loader").hide();
                    iframeLoaded = true;
                    $("#auditIframe").show();
                    
                }
                
            }
    }, 1000);

    
});

$(function() {
    var videos = $(".video");

    videos.on("click", function() {
        if($(this).find('img').length){
            var elm = $(this),
                conts = elm.contents(),
                le = conts.length,
                ifr = null;

            for (var i = 0; i < le; i++) {
                if (conts[i].nodeType == 8) ifr = conts[i].textContent;
            }

            elm.addClass("player").html(ifr);
            elm.off("click");

            if(videoType =='vimeo'){
                var iframe = $('#embed-responsive-video');
                startVideoTracking(iframe);
            }else if(videoType == 'youtube'){
                 
                 startVideoTracking();
            }
        }
        videoPlayed = 1;
    });
});



function previewFile(input) {
    var file = $("input[type=file]").get(0).files[0];

    if (file) {
        var reader = new FileReader();

        reader.onload = function () {
            $("#previewImg").attr("src", reader.result);
            $("#signature_url").val(reader.result);
        }
        $("#previewImg").show()
        reader.readAsDataURL(file);
    }
}

$(document).scroll(function () {
    var y = $(this).scrollTop();
    if (y > 300) {
        $('#infoHeader').addClass('sticky');
        $('#infoHeader').show();
    } else {
        $('#infoHeader').removeClass('sticky');
        $('#infoHeader').hide();
    }
});


$("a.openAuditIframe").click(function() {

    auditClicked++;
    if(!iframeLoaded){
        var iframeSrc = $("#auditIframe").data('src');
 
        if (!$("#auditIframe").attr('src')) {
            $('#audit_iframe_loader').show();
            $("#auditIframe").hide();

            $("#auditIframe").attr('src', iframeSrc);
            
            document.getElementById('auditIframe').onload = function() {
                $("#audit_iframe_loader").hide();
                iframeLoaded = true;
                $("#auditIframe").show();
                
                auditCounterFunction();
                
            }

        }
        
        return false;
    }
});

$(".serviceNameList").click(function () {
    var map_area_badge = '';
    var service_optional_badge = '';
    var badge_html = '';
    var service_id = $(this).data('service-id');
    var service_ind_id = String($(this).data('service-ind-id'));
    var service_optional = $(this).data('service-optional');
    var map_area = $(this).data('map-area');
    if(service_optional){
        service_optional_badge = '<span class="badge bg-secondary">Optional Service</span>';
    }
    if(map_area){
        map_area_badge = '<span class="badge bg-secondary " >Map Area: '+map_area+'</span>';
    }    
    if(service_optional_badge !='' || map_area_badge !=''){
        badge_html ='<div class="service-badge-section">'+service_optional_badge+' '+map_area_badge+'</div>';
    }

    var service_object = $('#' +service_id).clone();
    var service_title = $(service_object).find('.service_title').text();
    var service_text_total = $(service_object).find('.service_text_total').text();
    
    $('.ServiceNameHead').text(service_title);
    service_html = $(service_object).find('.service_title').remove();
    service_html = $(service_object).find('.service_text_total').remove();

    $('.service-offcanvas-body').html(badge_html+' '+service_object.html());
    $('.service-offcanvas-footer').html('<span class="service_text_total" style="padding-left: 40px;    float: left; margin-top: 7px;">'+service_text_total+'</span><span class="canvas-close-ok-btn"><button type="button" class="btn btn-primary btn-sm  pave-btn canvas-btn-w-100" data-bs-dismiss="offcanvas" aria-label="Close">Ok</button></span>')

    if(jQuery.inArray(service_ind_id, serviceSpecClicked) == -1){
        serviceSpecClicked.push(service_ind_id);
    }

    objIndex = view_service_text.findIndex((obj => obj.serviceId == service_ind_id));
    if(objIndex == -1){
        view_service_text.push({"serviceId": service_ind_id,"duration": 0})
        objIndex = view_service_text.findIndex((obj => obj.serviceId == service_ind_id));
    }
    currentServiceTextIndex = objIndex;

})

function iphoneL() {
    $('.sidebar-close').trigger('click');
}

var bounds = [
    
    {max:823,func:iphoneL}
];

var resizeFn = function(){
    var lastBoundry; // cache the last boundry used
    return function(){
        var width = window.innerWidth;
        var boundry, min, max;
        for(var i=0; i<bounds.length; i++){
            boundry = bounds[i];
            min = boundry.min || Number.MIN_VALUE;
            max = boundry.max || Number.MAX_VALUE;
            if(width > min && width < max 
               && lastBoundry !== boundry){
                lastBoundry = boundry;
                return boundry.func.call(boundry);            
            }
        }
    }
};
$(window).resize(resizeFn());
$(document).ready(function(){
    $(window).trigger('resize');
});

function openParentMenu(parent_menu_class,collapse_id){

    if($('.'+parent_menu_class).hasClass('collapsed')){
        $('.'+parent_menu_class).removeClass('collapsed');
        $('#'+collapse_id).addClass('show');
        $('.'+parent_menu_class).next().slideDown();
        $('.'+parent_menu_class).attr('aria-expanded','true');
    }
}
function closeAllPerentMenu(){

    if(!($('.term_condition_btn').hasClass('collapsed'))){
        $('.term_condition_btn').addClass('collapsed');
        $('#term-collapse').removeClass('show');
        $('.term_condition_btn').next().slideUp();
        $('.term_condition_btn').attr('aria-expanded','false');
    }

    if(!($('.proposal_service_btn').hasClass('collapsed'))){
        $('.proposal_service_btn').addClass('collapsed');
        $('#home-collapse').removeClass('show');
        $('.proposal_service_btn').next().slideUp();
        $('.proposal_service_btn').attr('aria-expanded','false');
    }


    if(!$('.attachments_btn').hasClass('collapsed')){
        $('.attachments_btn').addClass('collapsed');
        $('#attachment-collapse').removeClass('show');
        
        $('.attachments_btn').next().slideUp();
        $('.attachments_btn').attr('aria-expanded','false');
    }
}

// sidebar submenu behaviour like accordian
$('.attachments_btn').on('click', function () {

    if(!($('.term_condition_btn').hasClass('collapsed'))){
        $('.term_condition_btn').addClass('collapsed');
        $('#term-collapse').removeClass('show');
        $('.term_condition_btn').next().slideUp();
        $('.term_condition_btn').attr('aria-expanded','false');
    }

    if(!($('.proposal_service_btn').hasClass('collapsed'))){
        $('.proposal_service_btn').addClass('collapsed');
        $('#home-collapse').removeClass('show');
        $('.proposal_service_btn').next().slideUp();
        $('.proposal_service_btn').attr('aria-expanded','false');
    }
});
$('.term_condition_btn').on('click', function (){

    if(!($('.attachments_btn').hasClass('collapsed'))){
        $('.attachments_btn').addClass('collapsed');
        $('#attachment-collapse').removeClass('show');
        
        $('.attachments_btn').next().slideUp();
        $('.attachments_btn').attr('aria-expanded','false');
    }

    if(!($('.proposal_service_btn').hasClass('collapsed'))){
        $('.proposal_service_btn').addClass('collapsed');
        $('#home-collapse').removeClass('show');
        $('.proposal_service_btn').next().slideUp();
        $('.proposal_service_btn').attr('aria-expanded','false');
    }
});
$('.proposal_service_btn').on('click', function (){

    if(!($('.term_condition_btn').hasClass('collapsed'))){
        $('.term_condition_btn').addClass('collapsed');
        $('#term-collapse').removeClass('show');
        $('.term_condition_btn').next().slideUp();
        $('.term_condition_btn').attr('aria-expanded','false');
    }

    if(!($('.attachments_btn').hasClass('collapsed'))){
        $('.attachments_btn').addClass('collapsed');
        $('#attachment-collapse').removeClass('show');
        $('.attachments_btn').next().slideUp();
        $('.attachments_btn').attr('aria-expanded','false');
    }
});

// add a listener to 'scroll' event
document.addEventListener("scroll", function() {
    // get the active element and call blur
    document.activeElement.blur();
});


setInterval(getFocusedPage, 1000);

function getFocusedPage() {
    if(!pauseActivity){
        
    var gridElement;
    var seviceElement;
    
    elementMouseIsOver = document.elementFromPoint(section_width_check, 315);

    if ($(elementMouseIsOver).hasClass('grid')) {
        gridElement = $(elementMouseIsOver);
    } else {
        gridElement = $(elementMouseIsOver).parents('.grid');
    }

    if (gridElement[0]) {
        var pageId = gridElement.data('page-id');

        pageData[pageId]++;
        totalActivityDuration++;
        
        if(pageId == 'services'){
            if ($(elementMouseIsOver).hasClass('service-section')) {
                seviceElement = $(elementMouseIsOver);
            } else {
                seviceElement = $(elementMouseIsOver).parents('.service-section');
            }
            if (seviceElement[0]) {
                
                var serviceId = seviceElement.data('service-id');
                if(pageData['service_section']){
                    objIndex = pageData['service_section'].findIndex((obj => obj.id == serviceId));
                    
                    if(objIndex !== -1){
                        pageData['service_section'][objIndex].duration++;
                    }else{
                        pageData['service_section'].push({"id": serviceId,"duration": 0})
                    }
                }else{
                    pageData['service_section'] = [];
                }
                
               
            }
            
            
        }
    }


    }
}


$(".print-btn").on("click ", function() {
        
    printed = 1;
    
});


var myCarousel = document.getElementById('proposalCarousel')

myCarousel.addEventListener('slide.bs.carousel', function (event) {
    var imageId  = String($(event.relatedTarget).find('img').attr('data-image-id'));
   
    if(jQuery.inArray(imageId, imagesViewed) == -1){
        imagesViewed.push(imageId);
    }
    
    objIndex = image_object.findIndex((obj => obj.imageId == imageId));
    if(objIndex == -1){
        image_object.push({"imageId": imageId,"duration": 0,"clicks":0})
        objIndex = image_object.findIndex((obj => obj.imageId == imageId));
    }
    currentImageIndex = objIndex;
    image_object[currentImageIndex].clicks++; 

})


window.addEventListener('message', function (message) {
    
    if (message.data.customEventData) {
        if (message.data.customEventData.action === 'Video_Percent_Viewed') {
            var fullMessage = message.data.customEventData.label;
            var match = fullMessage.match(/Viewed: (.*) Percent/);
            
            screenCastPlayPercent = match[1];
        }
        if (message.data.customEventData.action === 'Video_Started') {
            
            videoDetails['clicks']++;
        }
    }
});

function setSectionWidth(){
    section_width_check = (document.querySelector('#boxed-section').getBoundingClientRect().right - ((document.querySelector('#boxed-section').getBoundingClientRect().right - document.querySelector('#boxed-section').getBoundingClientRect().left) / 2));
}



$("nav").find("a").click(function (e) {
    e.preventDefault();
    
    var section = $(this).attr("href");
    var scrollTo = $(section).offset().top + 25;
    if($('#infoHeader').is(':visible')){
        scrollTo = $(section).offset().top - 65;
    }
    
    // $("html, body").scrollTo(scrollTo);
     window.scrollTo(0,scrollTo);
     console.log(section);
      if(section =='#project_specifications'){
          console.log('ddfdf')
          console.log($('#home-collapse').find('.sub_menu:first'));
         $('#home-collapse ul li:first').find('.sub_menu').addClass('active123');
         return false;
      }
});





