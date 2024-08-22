var iframeLoaded = false;

$(document).ready(function () {


        $(".pdf-height").each(function(){   
    console.log($(this).height());
    });
    $('.openbtn').hide();
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})
    


    if (nosidebar) {
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

    $(document).scroll(function () {
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
                } else {
                    $(this).removeClass('active');
                }
            }
        });
    });


    $(document).on("click", ".closeProposalSignature", function () {
        $('.doc-section').show();
        $('.proposalSignature').hide();
        $('html, body').animate({
            scrollTop: $("#signature").offset().top
        }, 100);

    })

    $(document).on("click", ".showProposalCarousel", function () {
        var slide_id = $(this).attr('data-slide');
        console.log(slide_id);
        $('.carousel-item').removeClass('active');
        $('.' + slide_id).addClass('active');

    })

    $(document).on("click", ".closeProposalCarousel", function () {
        $('.doc-section').show();
        $('.proposalCarousel').hide();
        $('.closeProposalCarousel').hide();
        $('html, body').animate({
            scrollTop: $("#images").offset().top
        }, 0);
    })

    $(document).on("click", ".sidebar-close", function () {

        close_side_bar();
    })

    function close_side_bar() {
        $('#boxed-section').removeClass('boxed-section'); 
        $('#boxed-section').addClass('boxed-section-wide');
        $('#navbar-example3').hide('slide', {direction: 'left'}, 100);
        $('.openbtn').show();
        $('.button-text').show();

    }
    $(document).on("click", ".openbtn", function() {
        $('#navbar-example3').show("slide", { direction: "left"}, 100);
        $('#boxed-section').removeClass('boxed-section-wide'); 
        $('#boxed-section').addClass('boxed-section'); 
        $('.openbtn').hide();
        if($('.boxed-section').width() <= 768) {
            $('.button-text').hide();
        }
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
		
    $('.zoom').on('click', function(){
        zoom += 0.1;
        $('.doc-section').css('zoom', zoom);
        if (isFirefox) {
            document.getElementById("doc-section").style.transform = "scale("+zoom+")";
        }
        
        check_reset_zoom();
    });
    $('.zoom-init').on('click', function(){
        zoom = 1;
        $('.doc-section').css('zoom', zoom);
        if (isFirefox) {
            document.getElementById("doc-section").style.transform = "scale("+zoom+")";
        }
        check_reset_zoom();
    });
    $('.zoom-out').on('click', function(){
        zoom -= 0.1;
        $('.doc-section').css('zoom', zoom);
        if (isFirefox) {
            document.getElementById("doc-section").style.transform = "scale("+zoom+")";
        }
        check_reset_zoom();
    });

    function check_reset_zoom(){
        if(zoom==1){
            $('.zoom-init').hide();
        }else{
            $('.zoom-init').show();
        }
    }
    
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

$("nav").find("a").click(function (e) {
    e.preventDefault();
    var section = $(this).attr("href");
    $("html, body").animate({
        scrollTop: $(section).offset().top - 100
    });
});

$("a.openAuditIframe").click(function() {

    if(!iframeLoaded){
        var iframeSrc = $("#auditIframe").data('src');
        $('#audit_iframe_loader').show();
        $("#auditIframe").hide();
        if (!$("#auditIframe").attr('src')) {

            $("#auditIframe").attr('src', iframeSrc);

            document.getElementById('auditIframe').onload = function() {

                $("#audit_iframe_loader").hide();
                iframeLoaded = true;
                $("#auditIframe").show();
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
    $('.ServiceNameHead').text(service_title);
    service_html = $(service_object).find('.service_title').remove();
    console.log(badge_html);
    $('.service-offcanvas-body').html("<hr style='margin:0;'>"+badge_html+' '+service_object.html()+'<span class="canvas-close-ok-btn"><button type="button" class="btn btn-primary btn-sm  pave-btn canvas-btn-w-100" data-bs-dismiss="offcanvas" aria-label="Close">Ok</button></span>');
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