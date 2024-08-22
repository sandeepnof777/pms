var iframeLoaded = false;
var viewCreated = false;
var proposalViewId;
var signType;

var setupdateInterval = updateInterval * 1000;
var auditClicked = 0;
var imagesClicked = 0;
var serviceSpecClicked = [];
var signed = 0;
var printed = 0;
var downloaded = 0;
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
    intro_video: 0,
    terms: 0,
    signature: 0,
    price: 0,
    attachments: 0,
    service_section:[],
}

var screenCastPlayPercent = 0;
var currentScreenCastVideoId = 0;
var serviceLinkOpenTime = 0;
var service_text_links = [];
var serviceLink = '';
var currentServiceLinkIndex;
var auditLinkOpenTime = 0;
var auditLinkOpenTimer = 0;
var serviceTextOpenTime = 0;
var view_service_text = [];
var currentServiceTextIndex;
var currentServiceSectionIndex;
var image_object = [];
var video_object = [];
var screencast_video_object = [];
var currentImageIndex;
var currentVideoIndex;
var imageOpenTime = 0;
var section_width_check;
var trackingPointerTopPosition = 315;
var resetZoomChangeTrackingPx = 265;
var zoomChangeTrackingPx = 25;

var sectionFound = false;
var lastSection;
var closePreProposalPopup =false;
var closeVideoPopup = false;
var bsVideoPlayersOffcanvas;
var initialZoomLevel = 0.7;


$(document).ready(function () {
    $('#billing_phone').mask('000-000-0000');
    $('#onsite_phone').mask('000-000-0000');
    $('#customer_phone').mask('000-000-0000');
    $('#signature_cell_phone').mask('000-000-0000');
    $('#signature_office_phone').mask('000-000-0000');
    var isiPhone = (navigator.userAgent.toLowerCase().indexOf("iphone") > -1);
    var isiPad =  /iPad/.test(navigator.platform) || (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1);
   // var isiPad = navigator.userAgent.toLowerCase().indexOf("ipad");
    console.log(isiPhone);
    console.log(isiPad);

    $('.service-section a').each(function() {
        if(!$(this).hasClass('not_link')){
            $(this).attr("target","_blank");
        }
    });
    //document.addEventListener('touchmove', handleTouchMove, false);
    //document.addEventListener('touchend', handleTouchEnd, false);
    window.scrollTo(0,1);

    section_width_check = (document.querySelector('#boxed-section').getBoundingClientRect().right - ((document.querySelector('#boxed-section').getBoundingClientRect().right - document.querySelector('#boxed-section').getBoundingClientRect().left) / 2));

    $( window ).resize(function(){

        setSectionWidth();

    });

    function viewSize() {
        return $('#sizer').find('div:visible').data('size');
    }

   

    if(viewSize() == 'xs'){
       if(!is_wo_page){
        // var myOffcanvas = document.getElementById('offcanvasInfo');
        // var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas)
        // bsOffcanvas.show();
       }

            
                
            $( "#about_us_read_more" ).click(function() {
               
                $(".aboutus").addClass('fullText');
                $( "#about_us_read_more" ).hide();
                return false;
                
            });

            
       
    }else{
        //$('.mobile_close_nav').removeClass('mobile_close_nav');
    }

   
         console.log($('#sizer_ipad').is(':visible'));
         if($('#sizer_ipad').is(':visible')){
            close_side_bar();
            setSectionWidth();
         }


    $('.openbtn').hide();
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })



    if (nosidebar==1) {

        //close_side_bar();
    }

    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation');
        var forms2 = document.querySelectorAll('.needs-validation2');
        var forms3 = document.querySelectorAll('.needs-validation-checklist');
 
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

            Array.prototype.slice.call(forms3)
            .forEach(function (forms3) {
                forms3.addEventListener('submit', function (event) {

                    if (!forms3.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    } else {
                         save_checklist(this);
                    }
                    forms3.classList.add('was-validated')
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
                    $('a.sep-link').removeClass('active')
                    $(this).addClass('active');
                    lastSection = $(this);
                    if($(lastSection).closest('div').hasClass('collapse')){
                       
                        $('.proposal_service_btn').addClass('active');
                    }
                    sectionFound = true;
                } else {
                    $(this).removeClass('active');
                }
            }
        });


        if (!sectionFound) {
            if (lastSection) {
                //$(lastSection).parent().next().find('a.sep-link').addClass('active');

                if(scroll > position) {
                    
                    if(!$(lastSection).closest('div').hasClass('collapse')){
                        if($(lastSection).parent().next().find('a.sep-link').hasClass('sub_menu')){
                            $(lastSection).parent().next().find('a.sep-link.sub_menu:first').addClass('active');
                        }else{
                            $(lastSection).parent().next().find('a.sep-link').addClass('active');
                        }
                    }

                } else if(scroll < position) {
                    
                    if(!$(lastSection).closest('div').hasClass('collapse')){
                        if($(lastSection).parent().prev().find('a.sep-link').hasClass('sub_menu')){
                            $(lastSection).parent().prev().find('a.sep-link.sub_menu:last').addClass('active')
                        }else{
                            $(lastSection).parent().prev().find('a.sep-link').addClass('active');
                        }
                    }
                } else {
                   
                }
                position = scroll;
            }
        }

        if($('.sep-link').hasClass('active')){
            if(!$('.sep-link.active').hasClass('sub_menu')){
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
        //handleScroll();
        //$(document.elementFromPoint(x, y)).trigger('click');
    }

    function handleTouchEnd() {
        
        if(window.visualViewport.scale > 1){
            $('.image-section-inlarge-text').hide();
            $('.image-note-section-info').hide();
        }else{
            $('.image-section-inlarge-text').show();
            $('.image-note-section-info').show();
        }
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

    // PreProposal
    var offcanvasPreProposal = document.getElementById('offcanvasPreProposal')
    offcanvasPreProposal.addEventListener('hide.bs.offcanvas', function (event) {
        if(!closePreProposalPopup){
            event.stopPropagation();
            event.preventDefault();
        }

    })

    var bsOffcanvasPreProposal = new bootstrap.Offcanvas(offcanvasPreProposal);
    if(showPreProposalPopup==1 && viewSize() != 'xs'){
        //Remove PreProposal Popup for now
       // bsOffcanvasPreProposal.show();
    }

    $(document).on("click", ".close_pre_popup", function () {
        closePreProposalPopup =true;
        bsOffcanvasPreProposal.hide();
        if ($('#dont_show_pre_popup').prop('checked')==true){
            if(uuid){

                $.ajax({
                    url: site_url + 'ajax/dontShowPreProposalPopup',
                    type: "POST",
                    data: {
                        "uuid": uuid,

                    },
                    dataType: "json",
                    success: function (data) {
                        if (data.success) {


                        }
                    }
                })
            }
        }
    })



    


    $(document).on("click", ".close_video_popup", function () {
       
        closeVideoPopup = true;
        testbsVideoPlayersOffcanvas.hide();
        var video_id = $(this).attr('data-video-id');
        console.log(video_id)
        var video_type = $('#embed-responsive-video-'+video_id).attr('data-video-type');
        if(video_type == 'youtube'){
            YouTubeplayers[parseInt(video_id)].pauseVideo()
        }else if(video_type == 'vimeo'){
            vimeoPlayersObjects[parseInt(video_id)].pause();
        }else{
            var iframe = $('#video_player_iframe_body_'+video_id).html();
            $('#video_player_iframe_body_'+video_id).html(iframe);
        }
        //$('#video_player_iframe_body').html('');
      
    })


    var signatureOffcanvas = document.getElementById('offcanvasRight');
    signatureOffcanvas.addEventListener('show.bs.offcanvas', function (event) {
        
        if(isiPad || isiPhone){

            $(this)
            .css({
                 position: 'absolute',
                 marginTop: $(window).scrollTop() + 'px',
                bottom: 'auto'
            });

        }


    })

    var askOffcanvas = document.getElementById('offcanvasRight3');
    askOffcanvas.addEventListener('show.bs.offcanvas', function (event) {
        if(isiPad || isiPhone){

            $(this)
            .css({
                position: 'absolute',
                marginTop: $(window).scrollTop() + 'px',
                bottom: 'auto'
            });

        }


    })


    // Duration of Images canvas
    var imageCanvas = document.getElementById('offcanvasRight2');
    imageCanvas.addEventListener('show.bs.offcanvas', function (event) {
        if(viewSize()=='xs' || window.visualViewport.scale > 1){
            event.stopPropagation();
            event.preventDefault();
        }
        


    })
    function getDeviceScale() {
        var deviceWidth, landscape = Math.abs(window.orientation) == 90;
        if (landscape) {
          // iPhone OS < 3.2 reports a screen height of 396px
          deviceWidth = Math.max(480, screen.height);
        } else {
          deviceWidth = screen.width;
        }
        return window.innerWidth / deviceWidth;
    }
    
    imageCanvas.addEventListener('shown.bs.offcanvas', function () {
        imageCounterFunction();

    })
    imageCanvas.addEventListener('hidden.bs.offcanvas', function () {
        clearTimeout(imageOpenTime);
    });



    //Signature Offcanvas
    var signatureCanvas = document.getElementById('offcanvasRight');
    signatureCanvas.addEventListener('show.bs.offcanvas', function (event) {
    
       //console.log(signType);
       setTimeout(() => {
        
        if(signType =='company'){
            var clickButton = $('#add_signature_company');
        }else if(signType =='other'){
            var clickButton = $('#add_other_signature');
        }
        else{
            var clickButton = $('#add_signature');
        }

        if(signType !='other'){
            $('#signature_firstname').val(clickButton.attr('data-firstname'));
            $('#signature_lastname').val(clickButton.attr('data-lastname'));
            $('#signature_email').val(clickButton.attr('data-email').toLowerCase());
            $('#signature_title').val(clickButton.attr('data-title'));
            $('#signature_cell_phone').val(clickButton.attr('data-cell-phone'));
            $('#signature_office_phone').val(clickButton.attr('data-office-phone'));
        }else{

            $('#signature_firstname').val('');
            $('#signature_lastname').val('');
            $('#signature_email').val('');
            $('#signature_title').val('');
            $('#signature_cell_phone').val('');
            $('#signature_office_phone').val('');

        }
       
        $('#signature_company').val(clickButton.attr('data-company-name'));
        $('#signature_type').val(signType);
        $('#signature_address').val(clickButton.attr('data-address'));
        $('#signature_city').val(clickButton.attr('data-city'));
        $('#signature_state').val(clickButton.attr('data-state'));
        $('#signature_zip').val(clickButton.attr('data-zip'));
        

        $('#nav-home-tab').tab('show');

        reset_choose_sign();

        signaturePad.clear();


        $('#signature_file_input').val('');
        $('#previewImg').attr('src','');
        $('#signature_url').val('');
        $('#save_signature_loader').hide();
        $('.sign_radio[value="1"]').prop('checked', true);

    }, 50);
    })

    $(document).on("click", "#add_signature_company", function () {
        signType = 'company';
    })

    $(document).on("click", "#add_signature", function () {
        
        signType = 'client';
    })

    $(document).on("click", "#add_other_signature", function () {
        
        signType = 'other';
    })

     
    $(document).on("click", ".servicePopupImage", function () {
        var Image_object = $(this).closest('div').clone();
    

        $(this).closest('.offcanvas').find('.new-popup-close-btn').addClass("servicePopupImageBack");

       
        $(Image_object).find('.service-image-pinch-back').removeClass("service-image-pinch-back");
        
        $(Image_object).find('.image-section-inlarge-text').hide();
        $(Image_object).find('.image-note-section-info').hide();

        $(this).closest('.offcanvas').find('.servicePopupImageBack button').removeAttr("data-bs-dismiss");

       
        $(this).closest('.service-offcanvas-body').find('.item-content').hide();
            
        $(this).closest('.service-offcanvas-body').append('<div class="item_image">'+Image_object.html()+'</div>');
        
    })

    $(document).on("click", ".servicePopupImageNote", function () {
        $(this).closest('.service-offcanvas-body').find('.item_note').remove();
        $('.servicePopupImageNote').show()
        var notes = $(this).closest('div').parent().closest('div').find('.image-section-notes').html();
        var title = $(this).closest('div').parent().closest('div').find('.image_title').html();
        //var img_url = $(this).closest('div').find('.img-thumbnail').attr('src');
        var notes_body = '<p style="font-size:16px;font-weight: bold;margin-bottom: 5px;">'+title+': Notes</p><div style="overflow-y: auto;max-height: 120px;">'+notes+'</div>';
        $(this).closest('.service-offcanvas-body').append('<div class="item_note">'+notes_body+'</div>');
        $(this).hide();


        var scrollPos = $('.item_note').position().top;
        $('#serviceOffcanvasRight').animate({
            scrollTop: scrollPos
        }, 500);
        
    })

    $(document).on("click", ".servicePopupImageBack", function () {
        
        $(this).removeClass("servicePopupImageBack");
        $(this).find('button').attr("data-bs-dismiss","offcanvas");
        $(this).closest('.offcanvas').find('.item-content').show();
        $(this).closest('.offcanvas').find('.item_image').remove();
        
         
    })


    $(document).on("click", ".sign_popup_inputs", function () {
        $this = $(this);
        setTimeout(function(){
           
           $this.focus();
        }, 200);
        
         
    })

   

    $(document).on("click", ".showProposalCarousel", function () {
        var slide_id = $(this).attr('data-slide');
        var imageId = String($(this).attr('data-image-id'));

        if(jQuery.inArray(imageId, imagesViewed) == -1){
            imagesViewed.push(imageId);
        }

        
        var check_service_image = $(this).attr('data-bs-target');
        if(check_service_image.indexOf('#service_image_offcanvas_') != -1 ){
            if(window.visualViewport.scale > 1){
                // $(this).closest('div').parent().closest('div').css('width','auto');
                // $(this).closest('div').parent().closest('div').parent().closest('div').css('max-height','fit-content');
                // $(this).closest('div').parent().closest('div').parent().closest('div').css('width','100%');
                // $(this).css('height','auto');

                $(this).closest('div').parent().closest('div').parent().closest('div').addClass('service_image_large_view');
                

                $(this).closest('div').find('.service-image-pinch-back').show();
                $(this).closest('div').find('.image-section-inlarge-text').hide();
                var scrollTo =$(this).closest('div').offset().top - 80;
   
                $('html, body').animate({
                    scrollTop: scrollTo
                }, 500);
            }
        }
        if(check_service_image == '#offcanvasRight2' ){
            if(window.visualViewport.scale > 1){
                // $(this).closest('div').parent().closest('div').css('width','100%');
                // $(this).closest('div').parent().closest('div').css('max-height','initial');
                // $(this).css('height','auto');
                $(this).closest('div').parent().closest('div').addClass('image_large_view');
                $(this).closest('div').find('.image-pinch-back').show();
                $(this).closest('div').find('.image-section-inlarge-text').hide();
                var scrollTo =$(this).closest('div').offset().top - 80;
   
                $('html, body').animate({
                    scrollTop: scrollTo
                }, 500);
            }
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

    $(document).on("click", ".image-pinch-back", function () {
        // $(this).closest('div').parent().closest('div').css('width','50%');
        // $(this).closest('div').parent().closest('div').css('max-height','355px');
        // $(this).closest('div').find('.showProposalCarousel').css('height','280px');
        $(this).closest('div').parent().closest('div').removeClass('image_large_view')
        $(this).closest('div').find('.image-pinch-back').hide();
        $(this).closest('div').find('.image-section-inlarge-text').show();
        var scrollTo =$(this).closest('div').offset().top - 80;
   
        $('html, body').animate({
            scrollTop: scrollTo
        }, 500);
                
    })

    $(document).on("click", ".service-image-pinch-back", function () {
        // $(this).closest('div').parent().closest('div').css('width','50%');
        // $(this).closest('div').parent().closest('div').parent().closest('div').css('max-height','355px');
        // $(this).closest('div').parent().closest('div').parent().closest('div').css('width','50%');
        // $(this).closest('div').find('.showProposalCarousel').css('height','150px');

        $(this).closest('div').parent().closest('div').parent().closest('div').removeClass('service_image_large_view')

        $(this).closest('div').find('.service-image-pinch-back').hide();
        $(this).closest('div').find('.image-section-inlarge-text').show();
        var scrollTo =$(this).closest('div').offset().top - 80;
   
        $('html, body').animate({
            scrollTop: scrollTo
        }, 500);
                
    })

function isTouchDevice() {
  return (('ontouchstart' in window) ||
     (navigator.maxTouchPoints > 0) ||
     (navigator.msMaxTouchPoints > 0));
}

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
        console.log('close side')
        if($('.openMobileNav').is(':visible')){
            
            document.getElementById("navbar-example3").style.width = "0";
            document.getElementById("navToggleBtn").style.right = "100%";
            $('.openMobileNav').show('0.25');

        }else{
            document.getElementById("navbar-example3").style.width = "0";
            document.getElementById("boxed-section").style.width = "100%";
            //document.getElementById("followTab").style.left = "20px";
            document.getElementById("navToggleBtn").style.right = "calc(100%)";
        }
        if(viewSize() == 'xs' ){
            $('.openMobileNav').show('0.25');
        }

        setTimeout(() => {
            $('.closeNav').addClass('openNav');
            $('.closeNav').removeClass('closeNav');
        }, 250);
        

    }
     $(document).on("click", ".mobile_close_nav", function() {
        document.getElementById("navbar-example3").style.width = "0";
        document.getElementById("navToggleBtn").style.right = "100%";
        $('.openMobileNav').show('0.25');
    
    });
    $(document).on("click", ".openNav", function() {
        console.log(viewSize());
        if(viewSize() == 'sm' ){
            document.getElementById("navbar-example3").style.width = "40%";
            document.getElementById("boxed-section").style.width = "100%";
           
            document.getElementById("navToggleBtn").style.right = "60%";
        }else if(viewSize() == 'md' || viewSize() == 'lg'){
            document.getElementById("navbar-example3").style.width = "35%";
            document.getElementById("boxed-section").style.width = "100%";
           
            document.getElementById("navToggleBtn").style.right = "65%";
           
        }else if(is_wo_page){
            document.getElementById("navbar-example3").style.width = "25%";
            document.getElementById("boxed-section").style.width = "75%";
            //document.getElementById("followTab").style.left = "25%";
            document.getElementById("navToggleBtn").style.right = "75%";
        } else {
            console.log('check the side bar')
            document.getElementById("navbar-example3").style.width = "25%";
            document.getElementById("boxed-section").style.width = "75%";
           // document.getElementById("followTab").style.left = "25%";
            document.getElementById("navToggleBtn").style.right = "75%";
        }

        
        
        $('.openNav').addClass('closeNav');
        $('.openNav').removeClass('openNav');
        
        setSectionWidth();

    });

    $(document).on("click", ".openMobileNav", function() {
        if(document.getElementById("navbar-example3").style.width != "85%"){
            document.getElementById("boxed-section").style.width = "100%";
            document.getElementById("navbar-example3").style.width = "85%";
            $('.openNav').addClass('closeNav');
            $('.openNav').removeClass('openNav');
            document.getElementById("navToggleBtn").style.right = "15%";
            $('.openMobileNav').hide('0.25');
        }else{
            document.getElementById("navbar-example3").style.width = "0";
            document.getElementById("navToggleBtn").style.right = "100%";
        }

        setSectionWidth();

    });

    $(document).on("click", ".mobile_close_nav", function() {

        // $('#navbar-example3').attr('style','display: none !important');
        // $('.mobile_close_nav').attr('style','right: 100%;display: none !important');
        // $('.openMobileNav').attr('style','display: block !important');
       // document.getElementById("navbar-example3").style.width = "0%";
       //// document.getElementById("followTab").style.left = "0%";
       // setSectionWidth();

    });


    $(document).on("click", "#ask_question_open_canvas_btn", function () {

        $('#ask_question').val('');
        $('#ask_question_loader').hide();

    })
    $(document).on("click", "#clientSignatureForm input", function () {

        $(window).off('resize');


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
         var tabId = $('.tab-content .active').attr('id');
    

        if(tabId =='nav-home'){
            if (signaturePad.isEmpty()) {
                $('.signature_msg').show();
            }else{

                $('.signature_msg').hide();

                var dataURL = signaturePad.toDataURL();
                $('#signature_url').val(dataURL);

            }

        }else if(tabId =='nav-profile'){
            console.log('profie tab')
            if (document.getElementById("signature_file_input").files.length == 0){
                console.log('profie tab2')
                $('.signature_msg').show();
            }else{
                console.log('profie tab3')
                var dataURL = $('#signature_url').val();
            }
        }else if(tabId =='nav-choose'){
            if($('.sign_radio').val() && $('#signature_type_input').val()){
                var dataURL = $('#signature_url').val();
            }else {
                $('.signature_msg').show();
            }
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
            var signature_type = $('#signature_type').val();
            var proposal_link_id = $('#proposal_link_id').val();

            var signature_address = $('#signature_address').val();
            var signature_city = $('#signature_city').val();
            var signature_state = $('#signature_state').val();
            var signature_zip = $('#signature_zip').val();
            var signature_cell_phone = $('#signature_cell_phone').val();
            var signature_office_phone = $('#signature_office_phone').val();

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
                    "signature_type" : signature_type,
                    "proposal_link_id" : proposal_link_id,
                    "signature_address": signature_address,
                    "signature_city": signature_city,
                    "signature_state": signature_state,
                    "signature_zip": signature_zip,
                    "signature_cell_phone": signature_cell_phone,
                    "signature_office_phone": signature_office_phone,

                },
                dataType: "json",
                success: function (data) {
                    if (data.success) {
                        if(signature_type=='company'){
                            var add_sign_btn = $('#add_signature_company')[0].outerHTML;
                            $('.company_signature_td').html('');
                            $('.company_signature_td').html('<img style="width: auto; max-height: 70px;" src="' + data.src + '?'+Math.random()+'"><a type="button" class="btn btn-secondary btn-sm"  href="javascript:void(0)" data-company-sign-id="'+ data.sign_id+'" id="deleteCompanySignature"><i class="fa fa-fw fa-trash"></i></a>'+add_sign_btn)
                            $('#add_signature_company').addClass('d-none');
                            //$('.company_signature_td').html('<img style="width: auto; max-height: 70px;" src="' + data.src + '?'+Math.random()+'">')
                           // $('#signed_company_span').html('Signed : ' + data.signed);

                            var signee_data = signature_firstname+' '+signature_lastname+' | '+signature_title+
                                              '<br/>'+signature_company+
                                              '<br/>'+signature_address+
                                              '<br/>'+signature_city+', '+signature_state+' '+signature_zip+
                                              '<br/><a target="_blank" href="mailto:'+signature_email+'">'+signature_email+'</a>'
                                              

                            if(signature_cell_phone){
                                signee_data +='<br/>C: '+signature_cell_phone;
                            }
                            if(signature_office_phone){
                                signee_data +='<br/>P: '+signature_office_phone;
                            }
                            
                            signee_data +='<br/>Signed : ' + data.signed;               
                            $('.signee-details').html(signee_data);
                        }else{
                            //var add_sign_btn = $('#add_signature')[0].outerHTML;
                            var add_sign_btn;
                            try {
                                add_sign_btn = $('#add_signature')[0].outerHTML;
                            } catch (e) {
                                if (e instanceof TypeError) {
                                    console.error('Add signature button is not available.');
                                    add_sign_btn = ''; // Set a default value to prevent further errors
                                } else {
                                    throw e; // Rethrow any unexpected errors
                                }
                            }   

                            $('.client_signature_td').html('');
                           // console.log(showCompanySignatureButton);
                            if(showCompanySignatureButton=='1'){
                                $('.client_signature_td').html('<img style="width: auto; max-height: 70px;" src="' + data.src + '?'+Math.random()+'"><a type="button" class="btn btn-secondary btn-sm"  href="javascript:void(0)" data-client-sign-id="'+ data.sign_id+'" id="deleteClientSignature"><i class="fa fa-fw fa-trash"></i></a>'+add_sign_btn);
                            }else{
                                $('.client_signature_td').html('<img style="width: auto; max-height: 70px;" src="' + data.src + '?'+Math.random()+'">'+add_sign_btn)
                            }
                            
                            $('#add_signature').addClass('d-none');
                            var signee_data = signature_firstname+' '+signature_lastname+' | '+signature_title+
                                              '<br/>'+signature_company+
                                              '<br/>'+signature_address+
                                              '<br/>'+signature_city+', '+signature_state+' '+signature_zip+
                                              '<br/><a target="_blank" href="mailto:'+signature_email+'">'+signature_email+'</a>'
                                              

                            if(signature_cell_phone){
                                signee_data +='<br/>C: '+signature_cell_phone;
                            }
                            if(signature_office_phone){
                                signee_data +='<br/>P: '+signature_office_phone;
                            }
                            
                            signee_data +='<br/>Signed : ' + data.signed;               
                           
                            $('.proposal-details').html(signee_data);


                            //$('#signed_span').html('Signed : ' + data.signed);
                            $('#signed_date').html('&nbsp;  ' + data.signed_date);

                            $('.other_signature_td').hide();
                            
                        }
                        $('#submitSignModal').modal('show');
                        //refresh frame
                        
                        $('.needs-validation').removeClass('was-validated');
                        jQuery('#offcanvasRight').offcanvas('hide');
                        signaturePad.clear();


                        $('#signature_file_input').val('');
                        $('#previewImg').attr('src','');
                        $('#signature_url').val('');
                        $('#save_signature_loader').hide();
                        //form.classList.remove('was-validated')

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
        }else{
            $('.signature_msg').show();
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
                "ask_question_email": ask_question_email.toLowerCase(),
                "proposal_id": ask_question_proposal_id,
                "ask_question": ask_question,

            },
            dataType: "json",
            success: function (data) {
                if (data.success) {

                    $('#submitAskQuestionModal').modal('show');
                    //refresh frame
                    $('.needs-validation2').removeClass('was-validated');
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
        
       // $('.doc-section').css('zoom', zoom);
       // $('#infoHeader').css('zoom', hearZoomFix);


       // if(isFirefox){
            document.getElementById("doc-section").style.transform = "scale("+zoom+")";
            document.getElementById("doc-section").style.transformOrigin = "50% 0";
        //    $('.grid').css('transform',"scale("+zoom+")");
        //    $('.grid').css('transform-origin','0 0');
       // }
       if(zoom < 1){
            $('#doc-section').css('height','500px');
            trackingPointerTopPosition += zoomChangeTrackingPx;
        }else{
            $('#doc-section').css('height','auto');
            trackingPointerTopPosition = 315;
        }

        if(current_active_section){
            if(current_active_section =='#project_specifications'){
               var service_section =  $('.sep-link.active').eq(1).attr('href');
               if(service_section){
                current_active_section = service_section;
               }
            }
                
            var scrollTo = $(current_active_section).offset().top - 65;
            window.scrollTo(0,scrollTo);
            
            
         }
        multiplierZoom +=1;
        check_reset_zoom();
    });
    $('.zoom-init').on('click', function(){
        zoom = initialZoomLevel;
        hearZoomFix= initialZoomLevel;
        trackingPointerTopPosition = resetZoomChangeTrackingPx;
        // $('.doc-section').css('zoom', zoom);
        // $('#infoHeader').css('zoom', zoom);
       // if(isFirefox){
            document.getElementById("doc-section").style.transform = "scale("+initialZoomLevel+")";
        //}
        // $('.sectionChanger').show();
        $('#doc-section').css('height','auto');
        var current_active_section = $('.sep-link.active').attr('href');
        if(current_active_section){
            if(current_active_section =='#project_specifications'){
               var service_section =  $('.sep-link.active').eq(1).attr('href');
               if(service_section){
                current_active_section = service_section;
               }
            }
                
            var scrollTo = $(current_active_section).offset().top - 65;
            window.scrollTo(0,scrollTo);
            
            
         }
        check_reset_zoom();
        
    });
    $('.zoom-out').on('click', function(){
        var current_active_section = $('.sep-link.active').attr('href');

        zoom -= 0.1;
        hearZoomFix +=0.1;
       
        document.getElementById("doc-section").style.transform = "scale("+zoom+")";
        document.getElementById("doc-section").style.transformOrigin = "50% 0";
            
        if(zoom < 1){
            $('#doc-section').css('height','500px');
            trackingPointerTopPosition -= zoomChangeTrackingPx;
        }else{
            $('#doc-section').css('height','auto');
            trackingPointerTopPosition = 315;
        }
        //if(zoom == 1){$('.sectionChanger').show();}else{$('.sectionChanger').hide();}
         if(current_active_section){
            if(current_active_section =='#project_specifications'){
               var service_section =  $('.sep-link.active').eq(1).attr('href');
               if(service_section){
                current_active_section = service_section;
               }
            }
                
            var scrollTo = $(current_active_section).offset().top - 65;
            window.scrollTo(0,scrollTo);
            
            
         }
        multiplierZoom -=1;
        check_reset_zoom();
    });

    function check_reset_zoom(){
        
        if(zoom.toFixed(2)==initialZoomLevel.toFixed(2)){
            $('.zoom-init').hide();
            $('.tooltip').hide();
        }else{
            $('.zoom-init').show();
        }
        
        $('#trackingPointerLine').css('top',trackingPointerTopPosition);
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
                        if(response.video_object){
                            video_object = JSON.parse(response.video_object);
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


        if(videoDuration > 0){

             videoDetails['duration'] = parseInt(oldVideoPlayTime) + parseInt(videoPlayingTime);

        }



       if(proposalViewId){
        pageData['audit'] = auditLinkOpenTimer;
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
                    "downloaded": downloaded,
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
                    "viewedVideosData" : video_object,
                    "screencastViewedData" : screencast_video_object,

                },
                dataType: "json",
                success: function (response) {

                    if(response.success) {
                        lastUpdatedTime = moment();

                    }

                    if(videoPlaying == 1){

                        lastActionTime = moment().add(1, 'seconds');;
                    }

                    printed = 0;
                    downloaded = 0;

                }
            })
        }
    }


    // Open Canvas or in new tab on click(service links)
    $('.service-section').on('click','a', function (e){
        // e.preventDefault();
        // $('.service_check_loader').fadeIn();

        if(!$(this).hasClass('not_link')){
            serviceLink = $(this).attr('href');
            objIndex = service_text_links.findIndex((obj => obj.url == serviceLink));
            if(objIndex == -1){
                service_text_links.push({"url": serviceLink,"duration": 0,"clicks":1})
                objIndex = service_text_links.findIndex((obj => obj.url == serviceLink));
            }else{
                service_text_links[objIndex].clicks++;
            }
            currentServiceLinkIndex = objIndex;
        }

    })

//    $('#deleteSignature').on('click', function (e){
$(document).on("click", "#deleteClientSignature", function (e) {
    var proposal_id = $('#proposal_id').val();
    var client_sign_id = $(this).attr('data-client-sign-id');
    swal({
        title: "Are you sure?",
        text: "This will remove Signature",
        showCancelButton: true,
        confirmButtonText: 'Remove',
        cancelButtonText: "Cancel",
        dangerMode: false,
    }).then(function (isConfirm) {
        if (isConfirm) {

            $.ajax({
                url: site_url + 'ajax/deleteProposalClientSignature',
                type: "POST",
                data: {
                    "proposal_id": proposal_id,
                    "signature_id":client_sign_id
    
                },
                dataType: "json",
                success: function (data) {
                    $('.client_signature_td img').remove();
                    //$('#deleteClientSignature').hide();
                    $('#add_signature').removeClass('d-none');

                    var signee_data = data.first_name+' '+data.last_name+' | '+data.title+
                    '<br/>'+data.company_name+
                    '<br/>'+data.address+
                    '<br/>'+data.city+', '+data.state+' '+data.zip+
                    '<br/>E: <a target="_blank" href="mailto:'+data.email+'">'+data.email+'</a>';
                    if(data.cell_phone){
                        signee_data +='<br/>C: '+data.cell_phone;
                    }
                    if(data.office_phone){
                        signee_data +='<br/>P: '+data.office_phone;
                    }
                    
                    
                    $('.proposal-details').html(signee_data);
                   
                }
            })
        } else {
            swal("Cancelled", "Your Signature is safe :)", "error");
        }
    });
         
 });


 $(document).on("click", "#deleteCompanySignature", function (e) {
    var proposal_id = $('#proposal_id').val();
    var client_sign_id = $(this).attr('data-company-sign-id');
    swal({
        title: "Are you sure?",
        text: "This will remove Signature",
        showCancelButton: true,
        confirmButtonText: 'Remove',
        cancelButtonText: "Cancel",
        dangerMode: false,
    }).then(function (isConfirm) {
        if (isConfirm) {

            $.ajax({
                url: site_url + 'ajax/deleteProposalCompanySignature',
                type: "POST",
                data: {
                    "proposal_id": proposal_id,
                    "signature_id":client_sign_id
    
                },
                dataType: "json",
                success: function (data) {
                    $('.company_signature_td img').remove();
                    $('#add_signature_company').removeClass('d-none');

                    var signee_data = data.first_name+' '+data.last_name+' | '+data.title+
                    '<br/>'+data.company_name+
                    '<br/>'+data.address+
                    '<br/>'+data.city+', '+data.state+' '+data.zip+
                    '<br/>E: <a target="_blank" href="mailto:'+data.email+'">'+data.email+'</a>';
                    if(data.cell_phone){
                        signee_data +='<br/>C: '+data.cell_phone;
                    }
                    if(data.office_phone){
                        signee_data +='<br/>P: '+data.office_phone;
                    }
                    if(data.fax){
                        signee_data +='<br/>F: '+data.fax;
                    }
                    if(data.website){
                        signee_data +='<br/><a target="_blank" href="'+data.website+'">'+data.website+'</a>';
                    }
                    
                    $('.signee-details').html(signee_data);
                   
                }
            })
        } else {
            swal("Cancelled", "Your Signature is safe :)", "error");
        }
    });
         
 });



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
    var openAuditIframe = document.getElementById('offcanvasRight4');
    if(openAuditIframe){

        openAuditIframe.addEventListener('show.bs.offcanvas', function (event) {
            if(viewSize()=='xs' || isTouchDevice()){
                event.stopPropagation();
                event.preventDefault();
                
                $('#mobile_openAuditIframe')[0].click();
            }
    
        })

        openAuditIframe.addEventListener('shown.bs.offcanvas', function () {
            if(iframeLoaded){
                auditCounterFunction();
            }
        })
        openAuditIframe.addEventListener('hidden.bs.offcanvas', function () {
            clearTimeout(auditLinkOpenTime);
        });

    }
    //service text canvas view duration
    serviceTextCounterFunction = function(){
        view_service_text[currentServiceTextIndex].duration++;
        pageData['service_section'][currentServiceSectionIndex].duration++;
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

        if(videoDuration > 0){

             videoDetails['duration'] = parseInt(oldVideoPlayTime) + parseInt(videoPlayingTime);

        }
        if(proposalViewId){

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
                "downloaded":downloaded,
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
                "viewedVideosData" : video_object,
            };

            if(track_activity==1){
              let headers = {
                type: 'application/json'
              };
              let blob = new Blob([JSON.stringify(untrackdata)], headers);
             navigator.sendBeacon(site_url + 'ajax/updateProposalPreviewData',blob)
            }
        }

        // empty return is required to not show popup
        return
      }

      setTimeout(function(){
        if ($("#auditIframe").length){
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
            }
    }, 1000);



     // bact to top button funtionality
     if(viewSize() == 'xs'){
        console.log('back to top');
        var backToTop = $('.back-to-top');

        $(window).scroll(function() {
            if ($(window).scrollTop() > 300) {
                backToTop.show();
            } else {
                backToTop.hide();
            }
        });
        backToTop.on('click', function(e) {
            e.preventDefault();
            $('html, body').animate({scrollTop:0}, '300');
            return false;
        });
    }


    $("nav").find("a").click(function (e) {
        e.preventDefault();

        var section = $(this).attr("href");
        var scrollTo = $(section).offset().top + 25;
        
       // if($('#infoHeader').is(':visible')){
            scrollTo = $(section).offset().top - 65;
       // }


         window.scrollTo(0,scrollTo);
         var viewSize = $('#sizer').find('div:visible').data('size');
         console.log(viewSize);
         if(viewSize == 'md' || viewSize == 'sm' || viewSize == 'xs' || viewSize == 'lg'){
            close_side_bar();
            setSectionWidth();
         }
          if(section =='#project_specifications'){
             $('#home-collapse ul li:first').find('.sub_menu').addClass('active123');
             return false;
          }
          


          ///If service section
          var myArr = section.split("_");
            if(myArr[0]=='#service'){
                if(myArr[1]){
                   var serviceId = myArr[1];
                
                    if(pageData['service_section']){
                        objIndex = pageData['service_section'].findIndex((obj => obj.id == serviceId));

                        if(objIndex !== -1){
                            pageData['service_section'][objIndex].clicks++;
                        }else{
                            pageData['service_section'].push({"id": serviceId,"duration": 0,"clicks": 1})
                        }
                    }else{
                        pageData['service_section'] = [];
                    }
                }
            }
        /////////
    });
    


    $( window ).on( "orientationchange", function( event ) {
        close_side_bar();
      });

      if($('#sizer').find('div:visible').data('size') == 'xl'){
        $('.zoom-out').trigger('click');
        $('.zoom-out').trigger('click');
        $('.zoom-out').trigger('click');
      }




    

});





$(function() {
    var videos = $(".video");

    videos.on("click", function() {
        

        if($(this).find('img').length){
            var testVideoPlayersOffcanvas;
            var video_id = $(this).attr('data-video-id');
            

            testVideoPlayersOffcanvas = document.getElementById('VideoPlayersOffcanvas_'+video_id)
            testbsVideoPlayersOffcanvas = new bootstrap.Offcanvas(testVideoPlayersOffcanvas);
            testVideoPlayersOffcanvas.addEventListener('hide.bs.offcanvas', function (event) {
                console.log(closeVideoPopup);
                
                if(!closeVideoPopup){
                    event.stopPropagation();
                    event.preventDefault();
                }
        
            })

        var video_type = $('#embed-responsive-video-'+video_id).attr('data-video-type');
        if(video_type == 'youtube'){
            YouTubeplayers[parseInt(video_id)].playVideo();
        }else if(video_type == 'vimeo'){
            vimeoPlayersObjects[parseInt(video_id)].play();
        }
            
         //console.log($('#video_player_iframe_body_'+video_id).html());
         //$('.embed-responsive-16by9').html($('#video_player_iframe_body_'+video_id).html());
        // $('#video_player_iframe_body_'+video_id).html('');
             testbsVideoPlayersOffcanvas.show();

            closeVideoPopup =false;
         
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
    if (y > 100) {
        $('#infoHeader').addClass('sticky');
        $('#infoHeader').show();
        $('.sidebarTitle').addClass('ipad_sidebar_space');
        $('.mobile_close_nav').addClass('ipad_sidebar_space');
    } else {
        $('#infoHeader').removeClass('sticky');
        $('#infoHeader').hide();
        $('.sidebarTitle').removeClass('ipad_sidebar_space');
        $('.mobile_close_nav').removeClass('ipad_sidebar_space');
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
    

    var service_object = $('#' +service_id).clone();
    var service_title = $(service_object).find('.service_title').text();
    var service_text_total = $(service_object).find('.service_text_total').html();

    $('.ServiceNameHead').text(service_title);
    service_html = $(service_object).find('.service_image_large_view').removeClass("service_image_large_view");
    service_html = $(service_object).find('.service-image-pinch-back').hide();
    service_html = $(service_object).find('.image-section-inlarge-text').show();
    
    service_html = $(service_object).find('.showProposalCarousel').removeAttr("data-bs-target");
    service_html = $(service_object).find('.showProposalCarousel').removeAttr("data-bs-toggle");
    
    service_html = $(service_object).find('.showProposalCarousel').addClass("servicePopupImage");
    service_html = $(service_object).find('.showProposalCarousel').removeClass("showProposalCarousel");
    
    service_html = $(service_object).find('.image-note-section-info').addClass("servicePopupImageNote");
    service_html = $(service_object).find('.image-note-section-info').removeClass("image-note-section-info");
    service_html = $(service_object).find('.mg-btm-20').removeClass("mg-btm-20");


    
    service_html = $(service_object).find('.service_title').remove();
    service_html = $(service_object).find('.service_text_total').remove();
    
    if(service_optional){
        service_optional_badge = '<span class="badge bg-secondary">Optional Service</span>';
        service_html = $(service_object).find('.optional_service_badge').remove();
    }
    if(map_area){
        map_area_badge = '<span class="badge bg-secondary " >Map Area: '+map_area+'</span>';
    }
    if(service_optional_badge !='' || map_area_badge !=''){
        badge_html ='<div class="service-badge-section">'+service_optional_badge+' '+map_area_badge+'</div>';
    }

    $('.service-offcanvas-body').html(badge_html+' '+service_object.html());
    if(!service_text_total){service_text_total = '';}
    $('.service-offcanvas-footer').html('<span class="service_text_total" style="padding-left: 40px;    float: left; margin-top: 7px;">'+service_text_total+'</span><span class="canvas-close-ok-btn"></span>')

    if(jQuery.inArray(service_ind_id, serviceSpecClicked) == -1){
        serviceSpecClicked.push(service_ind_id);
    }

    objIndex = view_service_text.findIndex((obj => obj.serviceId == service_ind_id));
    if(objIndex == -1){
        view_service_text.push({"serviceId": service_ind_id,"duration": 0})
        objIndex = view_service_text.findIndex((obj => obj.serviceId == service_ind_id));
    }
    currentServiceTextIndex = objIndex;
    

    if(pageData['service_section']){
        objIndex = pageData['service_section'].findIndex((obj => obj.id == service_ind_id));

        if(objIndex !== -1){
            pageData['service_section'][objIndex].clicks++;
        }else{
            pageData['service_section'].push({"id": service_ind_id,"duration": 0,"clicks": 1})
            objIndex = pageData['service_section'].findIndex((obj => obj.id == service_ind_id));
        }
        currentServiceSectionIndex = objIndex;
    }else{
        pageData['service_section'] = [];
        pageData['service_section'].push({"id": service_ind_id,"duration": 0,"clicks": 1})
        objIndex = pageData['service_section'].findIndex((obj => obj.id == service_ind_id));

        currentServiceSectionIndex = objIndex;
    }
})

$(".image-section-info").click(function () {
    var notes = $(this).closest('div').parent().closest('div').find('.image-section-notes').html();
    var title = $(this).closest('div').parent().closest('div').find('.image_title').html();
    var img_url = $(this).closest('div').find('.img-thumbnail').attr('src');
    var notes_body = '<img class="img-fluid img-thumbnail" src="'+img_url+'"><br/><p style="text-align:center;font-size:16px;font-weight: bold;margin-top: 10px;">Notes</p><div style="overflow: auto;height: 40vh;">'+notes+'</div>';
    $('.mobile-image-info-offcanvas-body').html(notes_body);
    $('.mobile-image-info-offcanvas-title').html(title);
});


$(".image-section-notes>.close").click(function () {
    $(this).closest('div').hide();
});


$(document).on("click", ".item_note div>.close", function () {    
    $(this).closest('.item_note').remove();
    $('.servicePopupImageNote').show()
});

//$(".image-note-section-info").click(function () {
    $(document).on("click", ".image-note-section-info", function () {
    if(isTouchDevice()){
        $(this).closest('div').parent().closest('div').find('.image-section-notes').show();
      }else{

    
        var notes = $(this).closest('div').parent().closest('div').find('.image-section-notes').html();
        var title = $(this).closest('div').parent().closest('div').find('.image_title').html();
        //var img_url = $(this).closest('div').find('.img-thumbnail').attr('src');
        var notes_body = '<p style="text-align:center;font-size:16px;font-weight: bold;margin-top: 10px;">Notes</p><div style="overflow: auto;height: 40vh;">'+notes+'</div>';
        $('.mobile-note-image-info-offcanvas-body').html(notes_body);
        $('.mobile-note-image-info-offcanvas-title').html(title);
        var myOffcanvas = document.getElementById('mobileImageInfoNote');
            var bsOffcanvas = new bootstrap.Offcanvas(myOffcanvas)
            bsOffcanvas.show();
     }
});
function isTouchDevice() {
    return (('ontouchstart' in window) ||
       (navigator.maxTouchPoints > 0) ||
       (navigator.msMaxTouchPoints > 0));
  }
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


    //elementMouseIsOver = document.elementFromPoint(section_width_check, 315);
    elementMouseIsOver = document.elementFromPoint(section_width_check, trackingPointerTopPosition);

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
                       // pageData['service_section'][objIndex].duration++;
                    }else{
                        pageData['service_section'].push({"id": serviceId,"duration": 0,"clicks": 0})
                    }
                }else{
                    pageData['service_section'] = [];
                }
            }
            // if($('#sizer').find('div:visible').data('size') == 'xs'){
            //     clearTimeout(imageOpenTime);
            //     currentImageIndex = false;
            // }
            
        }else if(pageId == 'images' && $('#sizer').find('div:visible').data('size') == 'xs'){
           
                if ($(elementMouseIsOver).hasClass('image-section')) {
                    imageElement = $(elementMouseIsOver);
                } else {
                    imageElement = $(elementMouseIsOver).parents('.image-section');
                }
                if (imageElement[0]) {
                    var imageId = imageElement.data('image-id');
                    objIndex = image_object.findIndex((obj => obj.imageId == imageId));
                    if(objIndex !== -1){
                        image_object[objIndex].duration++;
                    }else{
                        image_object.push({"imageId": imageId,"duration": 0,"clicks":1})
                    }
                    
                    
                }
                
            
        }else{
            // if($('#sizer').find('div:visible').data('size') == 'xs'){
            //     clearTimeout(imageOpenTime);
            //     currentImageIndex = false;
            // }
        }


    }


    }
}


$(".print-btn").on("click ", function() {

    printed = 1;

});

$(".download-btn").on("click ", function() {

    downloaded = 1;

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

var mapCarousel = document.getElementById('proposalMapCarousel')
if(mapCarousel){
    mapCarousel.addEventListener('slide.bs.carousel', function (event) {
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
}


window.addEventListener('message', function (message) {

    if (message.data.customEventData) {
        if (message.data.customEventData.action === 'Video_Percent_Viewed') {
            var fullMessage = message.data.customEventData.label;
            var match = fullMessage.match(/Viewed: (.*) Percent/);

            screenCastPlayPercent = match[1];
            objIndex = screencast_video_object.findIndex((obj => obj.videoId == currentScreenCastVideoId));

        if(objIndex == -1){
            screencast_video_object.push({"videoId": currentScreenCastVideoId,"percent": 0})
            objIndex = screencast_video_object.findIndex((obj => obj.videoId == currentScreenCastVideoId));
        }

        screencast_video_object[objIndex].percent = screenCastPlayPercent;

        }
        if (message.data.customEventData.action === 'Video_Started') {
            var fullMessage = message.data.customEventData.label;

           var mySubString = fullMessage.substring(
                fullMessage.lastIndexOf("/media/") + 7,
                fullMessage.lastIndexOf("/")
            );
            if(mySubString){
                currentScreenCastVideoId = mySubString;
            }
            console.log(mySubString)
            videoDetails['clicks']++;
        }
    }
});

function setSectionWidth(){
    section_width_check = (document.querySelector('#boxed-section').getBoundingClientRect().right - ((document.querySelector('#boxed-section').getBoundingClientRect().right - document.querySelector('#boxed-section').getBoundingClientRect().left) / 2));
}



var tag = document.createElement('script');
tag.id = 'iframe-demo';
tag.src = 'https://www.youtube.com/iframe_api';
var firstScriptTag = document.getElementsByTagName('script')[0];
firstScriptTag.parentNode.insertBefore(tag, firstScriptTag);
var playerIframes = document.querySelectorAll(".YoutubeIframe");

var playerIframesArr = [].slice.call(playerIframes);
var YouTubeplayers = [];
var players = new Array(playerIframesArr.length);
var waypoints = new Array(playerIframesArr.length);

function updateYoutubeIframe(){
    playerIframes = document.querySelectorAll(".YoutubeIframe");
    playerIframesArr = [].slice.call(playerIframes);
YouTubeplayers = [];
players = new Array(playerIframesArr.length);
waypoints = new Array(playerIframesArr.length);
}

function onYouTubeIframeAPIReady() {

  playerIframesArr.forEach(function(e, i) { // forEach ...
   var video_id = $(playerIframes[i]).attr('video_id');
   
   YouTubeplayers[video_id] = new YT.Player(e.id, {
      events: {

             'onStateChange': onPlayerStateChange
             }
    })
  })

}


function onPlayerStateChange(event) {
if(event.data ==1){

      currentVideoId = $(event.target.h).attr('video_id');

      objIndex = video_object.findIndex((obj => obj.videoId == currentVideoId));
      if(objIndex == -1){
          video_object.push({"videoId": currentVideoId,"duration": 0,"clicks":0})
          objIndex = video_object.findIndex((obj => obj.videoId == currentVideoId));
      }

      currentVideoIndex = objIndex;
     // pauseAllVideo();

      // if(videoPlayed == 0){
        video_object[currentVideoIndex].clicks++;
      //}
      videoPlayed =1;
      lastActionTime = moment();
      videoPlayerCounterFunction();
      $('.btn-pause').show();
      videoPlaying = 1;
  }else if(event.data ==2){
    $('.btn-pause').hide();
      //pause video;
      clearTimeout(videoPlayertimer);
      videoPlaying = 0;
  }else if(event.data ==0){
    $('.btn-pause').hide();
      //end video;
      clearTimeout(videoPlayertimer);
      videoPlaying = 0;
  }

}


var vimeoPlayerIframes = document.querySelectorAll(".VimeoIframe");

var vimeoPlayerIframesArr = [].slice.call(vimeoPlayerIframes);
var vimeoPlayersObjects = [];
var vimeoPlayers = new Array(vimeoPlayerIframesArr.length);
var waypoints = new Array(vimeoPlayerIframesArr.length);

$(document).ready(function(){

    // var iframe = $('#embed-responsive-video');
    // console.log(iframe);
    // if(iframe.length){
    //     startVideoTracking(iframe);
    // }



  vimeoPlayerIframesArr.forEach(function(e, i) { // forEach ...
    var video_id = $(vimeoPlayerIframes[i]).attr('video_id');
    // vimeoPlayersObjects[video_id] = new YT.Player(e.id, {
    //    events: {

    //           'onStateChange': onPlayerStateChange
    //           }
    //  })
    startVideoTracking(e.id,video_id);

   })




function startVideoTracking(iframe,video_id){

    vimeoPlayersObjects[video_id] = new Vimeo.Player(iframe);

    vimeoPlayersObjects[video_id].on('ended', function() {
            clearTimeout(videoPlayertimer);
            console.log('Finished.');
            $('.btn-pause').hide();
            videoPlaying = 0;
        });

        vimeoPlayersObjects[video_id].on('pause', function() {
            console.log('pause.');
            $('.btn-pause').hide();
            clearTimeout(videoPlayertimer);
            videoPlaying = 0;
        });



        vimeoPlayersObjects[video_id].on('play', function(data) {

            $('.btn-pause').show();
            if(videoPlayed == 0){
                videoDetails['clicks']++;
            }
            videoPlayed =1;
            videoPlaying = 1;
            currentVideoId = video_id;
            pauseAllVideo();


        objIndex = video_object.findIndex((obj => obj.videoId == currentVideoId));
        if(objIndex == -1){
            video_object.push({"videoId": currentVideoId,"duration": 0,"clicks":0})
            objIndex = video_object.findIndex((obj => obj.videoId == currentVideoId));
        }

        currentVideoIndex = objIndex;

        // if(videoPlayed == 0){
          video_object[currentVideoIndex].clicks++;


            videoPlayerCounterFunction();
            lastActionTime = moment();

        });
        vimeoPlayersObjects[video_id].on('timeupdate', function(data) {
            vimeoPlayersObjects[video_id].currentTime  = data.seconds;
            lastActionTime = moment();

        });

}



});

function pauseYoutube(){
    YouTubeplayers.forEach(function(e, i) {
        if(parseInt(currentVideoId) != parseInt(i)){
          YouTubeplayers[parseInt(i)].pauseVideo();
        }
      })
}


function pauseVimeo(){
    vimeoPlayersObjects.forEach(function(e, i) {

        if(parseInt(currentVideoId) != i){

            vimeoPlayersObjects[i].pause();
        }
      })
}

function pauseAllVideo(){
    pauseYoutube();
    pauseVimeo();
}


$('.btn-pause').on('click', function (){
    // pause all vimew videos
    vimeoPlayersObjects.forEach(function(e, i) {
            vimeoPlayersObjects[i].pause();
      });
    // pause all youtube videos
    YouTubeplayers.forEach(function(e, i) {
        YouTubeplayers[i].pauseVideo();
    });
    $('.btn-pause').hide();
})

$(document).on("click", ".preSection", function () {
    
    var current_active_section =  $('.sep-link.active').parent().prev().find('a.sep-link').attr('href');
    

    var scrollTo = $(current_active_section).offset().top - 65;
    //window.scrollTo(0,scrollTo);
    //window.animate({scrollTop:scrollTo},250);
    $('html, body').animate({
        scrollTop: scrollTo
     }, 500);
})

$(document).on("click", ".nextSection", function () {
    
    var current_active_section =  $('.sep-link.active').parent().next().find('a.sep-link').attr('href');
    

    var scrollTo = $(current_active_section).offset().top - 65;
    //window.scrollTo(0,scrollTo);
    //window.animate({scrollTop:scrollTo},250);
    $('html, body').animate({
        scrollTop: scrollTo
     }, 500);
})

$('.serviceNameList').click(function () {
    
    $(this).blur(); // or $(this).blur();
    //...  
  });

  $('.img_mobile').click(function (e) {
    console.log('dddfffgg')
    e.preventDefault();
    //...  
  });


  $(document).on("keyup", "#signature_type_input", function () {

    if($('#signature_type_input').val()){
        var canvas1 = document.getElementById("choose_sign_canvas_option1");
        var ctx = canvas1.getContext("2d");
        var text = $('#signature_type_input').val();

        ctx.clearRect(0, 0, canvas1.width, canvas1.height);
        ctx.fillStyle = "#3e3e3e";
        ctx.font = "40px autography";
        ctx.fillText(text, 20, canvas1.height - 25);
        
        
        var resizedCanvas = document.createElement("canvas");
        var resizedContext = resizedCanvas.getContext("2d");

        resizedCanvas.height = "100";
        resizedContext.drawImage(canvas1, 0, 0, 280, 100);
        var myResizedData = resizedCanvas.toDataURL();


        
        $('#choose_sign_data_url_option1').val(myResizedData);
        

        var canvas2 = document.getElementById("choose_sign_canvas_option2");
        var ctx = canvas2.getContext("2d");
        var text = $('#signature_type_input').val();

        ctx.clearRect(0, 0, canvas2.width, canvas2.height);
        ctx.fillStyle = "#3e3e3e";
        ctx.font = "40px autosignature";
        ctx.fillText(text, 20, canvas2.height - 25);
        var dataurl2 = canvas2.toDataURL();

        var resizedCanvas = document.createElement("canvas");
        var resizedContext = resizedCanvas.getContext("2d");

        resizedCanvas.height = "100";
        resizedContext.drawImage(canvas2, 0, 0, 280, 100);
        var myResizedData = resizedCanvas.toDataURL();

        $('#choose_sign_data_url_option2').val(myResizedData);
        
        var canvas3 = document.getElementById("choose_sign_canvas_option3");
        var ctx = canvas3.getContext("2d");
        var text = $('#signature_type_input').val();

        ctx.clearRect(0, 0, canvas3.width, canvas3.height);
        ctx.fillStyle = "#3e3e3e";
        ctx.font = "40px BrothersideSignature";
        ctx.fillText(text, 20, canvas3.height - 25);
        var dataurl3 = canvas3.toDataURL();

        var resizedCanvas = document.createElement("canvas");
        var resizedContext = resizedCanvas.getContext("2d");

        resizedCanvas.height = "100";
        resizedContext.drawImage(canvas3, 0, 0, 280, 100);
        var myResizedData = resizedCanvas.toDataURL();

        $('#choose_sign_data_url_option3').val(myResizedData);
        $('.sign_radio').show();
        var sign_option = $('.sign_radio:checked').val();
        
        if(sign_option){
            $('.signature_msg').hide();
            $('#signature_url').val( $('#choose_sign_data_url_option'+sign_option).val());
        }
        
    }else{
        clear_sign_canvas();
    }
        
  })

$(document).on("change", ".sign_radio", function () {
    $('.signature_msg').hide();
    var choose_option_id = $(this).val();
    var image_data_url = $('#choose_sign_data_url_option'+choose_option_id).val();
    $('#signature_url').val(image_data_url);
});

function reset_choose_sign(){
    $('#signature_type_input').val('');
    clear_sign_canvas();
    
}
 function clear_sign_canvas(){
    $('.sign_radio').hide();
    $('.signature_msg').hide();
    $('#signature_url').val('');
    var text = 'Your Name';
    var canvas1 = document.getElementById("choose_sign_canvas_option1");
    var ctx = canvas1.getContext('2d');
    ctx.clearRect(0, 0, canvas1.width, canvas1.height);
    ctx.fillStyle = "#3e3e3e";
    ctx.font = "40px autography";
    ctx.fillText(text, 20, canvas1.height - 25);
    
    var canvas2 = document.getElementById("choose_sign_canvas_option2");
    var ctx = canvas2.getContext('2d');
    ctx.clearRect(0, 0, canvas2.width, canvas2.height);
    ctx.fillStyle = "#3e3e3e";
    ctx.font = "40px autosignature";
    ctx.fillText(text, 20, canvas2.height - 25);

    var canvas3 = document.getElementById("choose_sign_canvas_option3");
    var ctx = canvas3.getContext('2d');
    ctx.clearRect(0, 0, canvas3.width, canvas3.height);
    ctx.fillStyle = "#3e3e3e";
    ctx.font = "40px BrothersideSignature";
    ctx.fillText(text, 20, canvas3.height - 25);
 }



  document.fonts.load('1rem "autography"').then(() => { console.log('font loaded')})
  document.fonts.load('1rem "autosignature"').then(() => { console.log('font loaded')})
  document.fonts.load('1rem "BrothersideSignature"').then(() => { console.log('font loaded')})
  
 

  function save_checklist(e) {
      var dataURL = true; 

    if (dataURL) {
        $('#save_signature_loader').css('display', 'inline-block');
    
       var proposal_id =  $('#proposal_id').val();
       var billing_contact =  $('#billing_contact').val();
       var billing_address =  $('#billing_address').val();
       var billing_phone =  $('#billing_phone').val();
       var billing_email =  $('#billing_email').val();
       var property_owner_name =  $('#property_owner_name').val();
       var legal_address =  $('#legal_address').val();
       var customer_phone =  $('#customer_phone').val();
       var customer_email =  $('#customer_email').val();
       var onsite_contact =  $('#onsite_contact').val();
       var onsite_phone =  $('#onsite_phone').val();
       var onsite_email =  $('#onsite_email').val();
       var invoicing_portal =  $('#invoicing_portal').val();
        var special_instruction =  $('#special_instruction').val();  
    
        $.ajax({
            url: site_url + 'ajax/customer_billing_information',
            type: "POST",
            data: {
                "proposal_id": proposal_id,
                "billing_contact": billing_contact,
                "billing_phone": billing_phone,
                "billing_address": billing_address,
                "billing_email": billing_email,
                "property_owner_name": property_owner_name,
                "legal_address": legal_address,
                "customer_phone": customer_phone,
                "customer_email": customer_email,
                "onsite_contact": onsite_contact,
                "onsite_phone": onsite_phone,
                "onsite_email": onsite_email,
                "invoicing_portal": invoicing_portal,
                "special_instruction": special_instruction,

            },
            dataType: "json",
            success: function (data) {

                if (data.success) {
                    $(".billing_contact").text(billing_contact);
                    $(".billing_phone").text(billing_phone);
                    $(".billing_address").text(billing_address);
                    $(".billing_email").text(billing_email);
                    $(".property_owner_name").text(property_owner_name);
                    $(".legal_address").text(legal_address);
                    $(".customer_phone").text(customer_phone);
                    $(".customer_email").text(customer_email);
                    $(".onsite_contact").text(onsite_contact);
                    $(".onsite_phone").text(onsite_phone);
                    $(".onsite_email").text(onsite_email);
                    $(".invoicing_portal").text(invoicing_portal);
                    $(".special_instruction").text(special_instruction);
                    $('#submitChecklistModal').modal('show');
                    //refresh frame
                    $('.needs-validation').removeClass('was-validated');
                    jQuery('#offcanvasChecklist').offcanvas('hide'); 
                    $('#signature_file_input').val('');
                    $("#checkCustomerChecklistData").val(1);//For swal popup
                } else {
                    if (data.error) {
                        alert("Error: " + data.error);
                    } else {
                        alert('An error has occurred. Please try again later!')
                    }
                }
            }
        })
    }else{
        $('.signature_msg').show();
    }
}

 