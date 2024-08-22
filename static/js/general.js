var tinyMceMenus = {
    email: 'undo redo | fontselect | fontsizeselect | sizeselect |  bold italic underline | forecolor backcolor | numlist bullist | alignleft aligncenter alignright | link | cut copy paste | preview | spellchecker',
    serviceMenu: 'undo redo | bold italic underline | removeformat  | numlist bullist | link ',
    root_attrs : {'style': 'font-size: 14px; font-family: "Arial"'},
};

var logoutUserIds = [1902,3316,3749,911,192,1182,1033,651,2571];
var hasLocalStorage = false;
try {
    localStorage.setItem("checkLocalStorage", 1);
    localStorage.removeItem("checkLocalStorage", '');
    hasLocalStorage = true;
  }
  catch(err) {
    console.log(err);
  }
function addCommas(nStr) {
    nStr += '';
    x = nStr.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}
function initButtons() {
    $('.btn').button();
    $('.btn-edit').button({
        icons: {
            primary: "ui-icon-pencil"
        },
        text: false
    });
    $('.btn-calculator').button({
        icons: {
            primary: "ui-icon-calculator"
        },
        text: false
    });
    $('.btn-restore').button({
        icons: {
            primary: "ui-icon-arrowreturnthick-1-w"
        },
        text: false
    });
    $('.btn-notes').button({
        icons: {
            primary: "ui-icon-note"
        },
        text: false
    });
    $('.btn-users').button({
        icons: {
            primary: "ui-icon-person"
        },
        text: false
    });
    $('.btn-refresh').button({
        icons: {
            primary: "ui-icon-refresh"
        },
        text: false
    });
    $('.btn-add').button({
        icons: {
            primary: "ui-icon-plus"
        },
        text: false
    });
    $('.btn-add-lead').button({
        icons: {
            primary: "ui-icon-contact"
        },
        text: false
    });
    $('.btn-promote').button({
        icons: {
            primary: "ui-icon-arrowthick-1-n"
        },
        text: false
    });
    $('.btn-help').button({
        icons: {
            primary: "ui-icon-help"
        },
        text: false
    });
    $('.btn-settings').button({
        icons: {
            primary: "ui-icon-wrench"
        },
        text: false
    });
    $('.btn-preview').button({
        icons: {
            primary: "ui-icon-search"
        },
        text: false
    });
    $('.btn-delete').button({
        icons: {
            primary: "ui-icon-closethick"
        },
        text: false
    });
    $('.btn-history').button({
        icons: {
            primary: "ui-icon-signal-diag"
        },
        text: false
    });
    $('.btn-reassign').button({
        icons: {
            primary: "ui-icon-transferthick-e-w"
        },
        text: false
    });
    $('.btn-icon').button({
        icons: {
            primary: "ui-icon-tag"
        },
        text: false
    });
    $('.btn-add-proposal').button({
        icons: {
            primary: "ui-icon-document"
        },
        text: false
    });
    $('.btn-view-proposals').button({
        icons: {
            primary: "ui-icon-folder-open"
        },
        text: false
    });
    $('.btn-icon-clock').button({
        icons: {
            primary: "ui-icon-clock"
        },
        text: false
    });
    $('.btn-view').button({
        icons: {
            primary: "ui-icon-newwin"
        },
        text: false
    });
    $('.btn-enabled').button({
        icons: {
            primary: "ui-icon-check"
        },
        text: false
    });
    $('.btn-disabled').button({
        icons: {
            primary: "ui-icon-cancel"
        },
        text: false
    });
    $('.btn-rotate-left').button({
        icons: {
            primary: "ui-icon-arrowstop-1-w"
        },
        text: false
    });
    $('.btn-rotate-right').button({
        icons: {
            primary: "ui-icon-arrowstop-1-e"
        },
        text: false
    });
    $('.track-client').button({
        icons: {
            primary: "ui-icon-volume-on"
        },
        text: false
    });
    $('.btn-duplicate').button({
        icons: {
            primary: "ui-icon-newwin"
        },
        text: false
    });
    $('.btn-calendar').button({
        icons: {
            primary: "ui-icon-calendar"
        },
        text: false
    });
    $('.btn-duplicate-template').button({
        icons: {
            primary: "ui-icon-newwin"
        },
        text: false
    });
    $('.btn-locked-template').button({
        icons: {
            primary: "ui-icon-locked"
        },
        text: false
    });
}
function initTiptip() {
    //TIPS dialog
    $('span.price-tiptip2').tipTip({
        defaultPosition: "left",
        delay: 0,
        maxWidth: '330px;'
    });
    $('span.price-tiptip').tipTip({
        defaultPosition: "top",
        delay: 0,
        maxWidth: '330px;'
    });
    $('span.ajax-price-tiptip').tipTip({
        defaultPosition: "top",
        delay: 0,
        maxWidth: '330px;'
    });
    function returnCallback(value) {
        console.log(value);
        return value;
    }
    $('a.tiptip').tipTip({
        defaultPosition: "top",
        delay: 0,
        maxWidth: '220px'
    });
    $('div.tiptip').tipTip({
        defaultPosition: "top",
        delay: 0,
        maxWidth: '220px'
    });
    $('input.tiptip').tipTip({
        activation: "focus",
        defaultPosition: "right",
        delay: 0,
        maxWidth: '150px'
    });
    $('select.tiptip').tipTip({
        activation: "focus",
        defaultPosition: "right",
        delay: 0,
        maxWidth: '330px'
    });
    $('span.tiptip').tipTip({
        defaultPosition: "top",
        delay: 0,
        maxWidth: '400px'
    });
    $('img.tiptip').tipTip({
        defaultPosition: "top",
        delay: 0,
        maxWidth: '220px'
    });
    $('.tiptipleft').tipTip({
        defaultPosition: "left",
        delay: 0,
        maxWidth: '220px'
    });
    $('.tiptipright').tipTip({
        defaultPosition: "right",
        delay: 0,
        maxWidth: '220px'
    });
    $('.tiptiptop').tipTip({
        defaultPosition: "top",
        delay: 0,
        maxWidth: '220px'
    });
    $('.tiptipleftwide').tipTip({
        defaultPosition: "left",
        delay: 0,
        maxWidth: '500px'
    });
    $('.tiptipwide').tipTip({
        defaultPosition: "top",
        delay: 0,
        maxWidth: '500px'
    });
    $('a.tiptipright').tipTip({
        defaultPosition: "right",
        delay: 0,
        maxWidth: '220px'
    });
    $("a.tiptiptarget").tipTip({
        defaultPosition: "top",
        delay: 0,
        maxWidth: '150px'
    });
    $("a.tiptipnarrow").tipTip({
        defaultPosition: "top",
        delay: 0,
        maxWidth: '150px'
    });
    $("i.tiptip").tipTip({
        defaultPosition: "top",
        delay: 0,
        maxWidth: '150px'
    });
}


function preUI() {
    $("select:not(.dont-uniform), input:checkbox:not(.dont-uniform), input:radio:not(.dont-uniform), input:file input:text.text").uniform();
    $("select:not(.dont-uniform)").change(function () {
        $.uniform.update('select');
    });
}

function initUI(preUI) {
    $("#javascript_loading").hide();
    $('.javascript_loaded').fadeIn();
    initButtons();
    initTiptip();
    $(".confirm").click(function () {
        return confirm('Are you sure you want to do this?');
    });
    $("#error-message").dialog({
        width: 400,
        modal: true,
        buttons: {
            Close: function () {h
                $(this).dialog("close");
            }
        }
    });
    $("#file_uploading").dialog({
        width: 300,
        modal: true,
        autoOpen: false
    });
    $(".closeonclick").click(function () {
        $(this).fadeOut(300);
    });
    /*Validator initialisation for forms that have the class set*/
    $(".form-validated").each(function () {
        $(this).validate();
    });

    if (!preUI) {
        /*UniFORM*/
        $("select:not(.dont-uniform), input:checkbox:not(.dont-uniform), input:radio:not(.dont-uniform), input:file input:text.text").uniform();
        $("select:not(.dont-uniform)").change(function () {
            $.uniform.update('select:not(.dont-uniform)');
        });
    }
    /*Input formatting, etc*/
    var priceFormat = '.field-priceFormat';
    $(priceFormat).live('keyup', function () {
        $(this).formatCurrency({ colorize: true, negativeFormat: '-%s%n', roundToDecimalPlace: -1, eventOnDecimalsEntered: true });
        $(this).formatCurrency({ colorize: true, negativeFormat: '-%s%n', roundToDecimalPlace: -1, eventOnDecimalsEntered: true });
    });
    var numberFormat = '.field-numberFormat';
    $(numberFormat).live('keyup', function () {
        $(this).formatCurrency({ colorize: true, negativeFormat: '-%s%n', roundToDecimalPlace: -1, eventOnDecimalsEntered: true, symbol: '' });
        $(this).formatCurrency({ colorize: true, negativeFormat: '-%s%n', roundToDecimalPlace: -1, eventOnDecimalsEntered: true, symbol: '' });
    });
    /*Collapsible content boxes*/
    $(".content-box.collapse").each(function () {
        var box = $(this);
        var header = $(this).find('.box-header');
        var content = $(this).find('.box-content');
        //close if not open and add icon
        if (!$(this).hasClass('open')) {
            content.hide();
        }
        header.append('<span class="collapse-button"></span>');
    });
    $('.collapse-button').live('click', function () {
        var box = $(this).parents('.content-box');
        var content = box.find('.box-content');
        var boxState = 'closed';
        if (box.hasClass('open')) {
            box.removeClass('open');
            content.stop().slideUp();
        } else {
            boxState = 'open';
            box.addClass('open');
            content.stop().slideDown();
        }
        $.ajax({
            url: '/account/changeCollapseBoxState',
            type: 'POST',
            data: {
                box: 'box-' + box.attr('id'),
                state: boxState
            }
        });
    });
    //Formattings and stuff
    $(".formatPhone").mask("999-999-9999");
    /*Help buttons*/
    /*var helpBox;
     $(".help").click(function() {
     helpBox = $(this);
     $(this).children('ul').show();
     $(document.body).click(function(){
     if (!box.has(this).length) { // if the click was not within $box
     box.hide();
     }
     });
     });*/
    $(".help ul a").fancybox({
        'width': 900,
        'height': 507,
        'autoScale': false,
        'transitionIn': 'none',
        'transitionOut': 'none',
        'type': 'iframe'
    });

    $(".phoneFormat").mask("999-999-9999");

    /* * * * * * * * * * * * * * * *
     *  Menu Actions Dropdown Code *
     * * * * * * * * * * * * * * * */

    $(".submenu").hide();
    $(".new-buttons.selected").removeClass('selected');
    $('.dropdown-button.activeMenu').removeClass('activeMenu');

    $(".dropdown-button a.dropdownToggle").live('click', function () {

        //try to figure out the count of the row
        var current = $(this).parents('tr');
        var trCounter = 0;
        var trCount = 0;
        $('tr').each(function () {
            trCounter++;
            if ($(this).is(current)) {
                trCount = trCounter;
            }
        });
        var above = false;
        if (trCounter - trCount <= 4) {
            above = true;
        }
        //button code
        var menu = $(this).parents('ul');
        if (menu.hasClass('activeMenu')) {
            menu.removeClass('activeMenu');
            $(".submenu").hide().removeClass('above');
            $(".new-buttons.selected").removeClass('selected');
            $('.dropdown-button.activeMenu').removeClass('activeMenu');
        } else {
            $(".new-buttons.selected").removeClass('selected');
            $('.dropdown-button.activeMenu').removeClass('activeMenu');
            menu.addClass('activeMenu');
            menu.parent().addClass('selected');
            var submenu = menu.find('.submenu');
            submenu.show();
            if (above) {
                submenu.addClass('above');
            }
        }

        if ($(this).hasClass('toggle')) {
            return false;
        }
    });

    $("body").click(function () {
        $(".submenu").hide();
        $(".new-buttons.selected").removeClass('selected');
        $('.dropdown-button.activeMenu').removeClass('activeMenu');
    });
    /*$("body").live('touchstart click', function() {
     if (!flag) {
     flag = true;
     setTimeout(function(){ flag = false; }, 100);
     $(".submenu").hide();
     $(".new-buttons.selected").removeClass('selected');
     $('.dropdown-button.activeMenu').removeClass('activeMenu');
     }
     return false
     });*/
    /* $('body').bind('touchstart click', function(){
     if (!flag) {
     flag = true;
     setTimeout(function(){ flag = false; }, 100);
     $(".submenu").hide();
     $(".new-buttons.selected").removeClass('selected');
     $('.dropdown-button.activeMenu').removeClass('activeMenu');
     }
     return false
     });*/

    /*
     * New Buttons Code
     */
    function toggleButton(button) {
        
        // Height of menu
        var container = button.parent();
        var menu = container.find('.dropdownMenuContainer');
        var menuHeight = menu.height();
        // Distance from top
        var dft = button[0].getBoundingClientRect().bottom;
        var windowHeight = $(window).height();
        var remainingSpace = ((windowHeight - dft) - 20);

        // Default to open below
        var above = false;

        if (menuHeight > remainingSpace) {
            above = true;
        }

        if (button.hasClass('open')) {
            button.removeClass('open');
            menu.removeClass('open').hide();
            $(".dropdownButton.currentActive").removeClass('currentActive');
        } else {
            closeButtons();
            button.addClass('open');
            menu.addClass('open').show();
            if (above) {
                menu.addClass('openAbove');
            }
            container.addClass('currentActive');
        }

        // I hate this but maybe it's the only thing that will save my sanity
        if (button.hasClass('proposalsTableDropdownToggle')) {
            // Reset the overflow to show dropdowns in scrollable table
            $(".dataTables_scrollBody").css('overflow', '');
        }
    }

    $('.dropdownMenuContainer .closeDropdownMenu').live('click', function() {
        $('.dropdownMenuContainer').hide();
        $('.dropdownToggle').removeClass('open');
        return false;
    });

    // Close proposals popup on click
    $(document).on('click', "#newProposalsPopup a", function() {
        console.log('click');
        $("#newProposalsPopup").hide();
    });

    function closeButtons() {
        $(".dropdownButton .dropdownMenuContainer").removeClass('menu').removeClass('openAbove').hide();
        $(".dropdownButton .dropdownMenuContainer").removeClass('menu').removeClass('open').hide();
        $(".dropdownToggle.open").removeClass('open');
        $(".dropdownButton.currentActive").removeClass('currentActive');
    }

    $(".dropdownToggle").live('click', function (e) {
        e.stopImmediatePropagation();
        toggleButton($(this));
        return false;
    });
    $(".dropdownButton").live('click', function (e) {
        e.stopPropagation();
    });
    $(document).click(function () {
        closeButtons();
    });
    //ipad crap clicking out
    $(document).on('touchstart', function (event) {
        if (!$(event.target).closest('.dropdownButton').length) {
            closeButtons();
        }
    });
    $.fn.capitalize = function () {

        //iterate through each of the elements passed in, `$.each()` is faster than `.each()
        $.each(this, function () {

            //split the value of this input by the spaces
            var split = this.value.split(' ');

            //iterate through each of the "words" and capitalize them
            for (var i = 0, len = split.length; i < len; i++) {
                split[i] = split[i].charAt(0).toUpperCase() + split[i].slice(1);
            }

            //re-join the string and set the value of the element
            this.value = split.join(' ');
        });
        return this;
    };
    $(".capitalize").blur(function() {
        $(this).capitalize();
    }).capitalize();
}


$.extend($.expr[":"], {
    "icontains": function(elem, i, match, array) {
        return (elem.textContent || elem.innerText || "").toLowerCase().indexOf((match[3] || "").toLowerCase()) >= 0;
    }
});

$(document).ready(function () {

    // Allow initUI to be delayed by hidden input. By default, this still shows the content
    if ($("#delayUI").val() != 1) {
        initUI();
    }

    // Hide tips on iPad
    $(document).on('touchstart', function (event) {
        var obj = event.target;
        obj = $(this);

        if (!(obj).hasClass('tiptip')){
            $('#tiptip_holder').hide();
        }
    });

    // Font previews
    $("#exampleHeader").css('font-family', $("#headerFont").val());
    $("#exampleText").css('font-family', $("#textFont").val());
    $(".preview-heading").css('font-family', $("#headerFont").val());
    $(".preview-text").css('font-family', $("#textFont").val());

    $("#headerFont").change(function(){
        $("#exampleHeader").css('font-family', $(this).val());
        $(".preview-heading").css('font-family',$(this).val());
    });

    $("#textFont").change(function(){
        $("#exampleText").css('font-family', $(this).val());
        $(".preview-text").css('font-family', $(this).val());
    });

    $("#currentImage").css('opacity', $("#imageOpacity").val());
    $(".preview-heading").css('background-color', hexToRgb('#' + $("#headerBgColor").val()));
    $(".preview-heading").css('color', '#' + $("#headerFontColor").val());
    $(".preview-text").css('color', '#' + $("#headerFontColor").val());



    function hexToRgb(hex){
        hex = hex.toLowerCase();
        if(/^#([a-f0-9]{3}){1,2}$/.test(hex)){
            if(hex.length== 4){
                hex= '#'+[hex[1], hex[1], hex[2], hex[2], hex[3], hex[3]].join('');
            }
            var c= '0x'+hex.substring(1);
            return 'rgb('+[(c>>16)&255, (c>>8)&255, c&255].join(',')+')';
        }
    }

    // input change notification
    /*
     var inputsChanged = false;
     $(".trackChanges").change(function () {
     inputsChanged = true;
     });

     $('form').each().submit(function () {
     inputsChanged = false;
     });

     function confirmation() {
     if (inputsChanged) {
     var answer = 'Are you sure you want to leave the page? You have unsaved changes!';
     return true;
     } else {
     return false;
     }
     }*/

//    window.onbeforeunload = confirmation;

if(jQuery.inArray(globalAccountId, logoutUserIds) != -1) {
    userLogoutCountdown();
    
}

  

    $(".keepMeLogin").click(function() {

        $.ajax({
            type: "GET",
            async: false,
            cache: false,
            url: "/ajax/refreshLogin",
            dataType: "JSON"
        })
        .success(function (data) {
            if (!data.loggedIn) {
                window.location.href = '/account/logout';
            } else {
                $('#logoutCountdown').countdown('option', {until: new Date(data.session_expiry)});
                logoutDateTime = new Date(data.session_expiry);
                swal('', 'Login Renewed');
            }
        });
    });


});

Number.prototype.formatMoney = function (c, d, t) {
    var n = this,
        c = isNaN(c = Math.abs(c)) ? 2 : c,
        d = d == undefined ? "." : d,
        t = t == undefined ? "," : t,
        s = n < 0 ? "-" : "",
        i = String(parseInt(n = Math.abs(Number(n) || 0).toFixed(c))),
        j = (j = i.length) > 3 ? j % 3 : 0;
    return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
};

function padNumber(number, length) {
    var str = '' + number;
    while (str.length < length) {
        str = '0' + str;
    }

    return str;
}

function userLogoutCountdown()
{
    var secondsRemaining;

    
    if (logoutDateTime) {

        logoutCountdown = $('#logoutCountdown').countdown({
            until: logoutDateTime,
            compact: true,
            layout: '{mn}{sep}{snn}',
            onTick: function(timer) {
                var mins = timer[5];
                var seconds = timer[6];
                secondsRemaining = (mins * 60) + seconds;

                seconds = padNumber(seconds, 2);

                if(secondsRemaining <= 301)
                {

                    if (!swal.isVisible()) {
                        swal({
                            title: 'Warning!',
                            html: '<p>You will be logged out in <span id="logoutMins" style="font-weight: bold"></span>:<span id="logoutSecs" style="font-weight: bold"></span></p><br />',
                            confirmButtonText: 'Keep Me Logged In',
                            allowOutsideClick: false
                        }).then((result) =>{
                            $.ajax({
                                type: "GET",
                                async: false,
                                cache: false,
                                url: "/ajax/refreshLogin",
                                dataType: "JSON"
                            })
                            .success(function (data) {
                                if (!data.loggedIn) {
                                    window.location.href = '/account/logout';
                                } else {
                                    $('#logoutCountdown').countdown('option', {until: new Date(data.session_expiry)});
                                    logoutDateTime = new Date(data.session_expiry);
                                    swal('', 'Login Renewed');
                                }
                            });
                        });
                    } else {
                        $("#logoutMins").text(mins);
                        $("#logoutSecs").text(seconds);
                    }

                    if(secondsRemaining <= 120)
                    {
                        $('#logoutMins').css('color','red')
                        $('#logoutSecs').css('color','red')
                    }

                } else{
                    $("#CountdownPanel").hide();
                }
            },
            onExpiry: manuallyLoggedOut
        });
    }
    

}

function manuallyLoggedOut(){
    window.location.href = '/account/logout';
}

placeParser = function(place){
    result = {};
    for(var i = 0; i < place.address_components.length; i++){
        ac = place.address_components[i];
        result[ac.types[0]] = ac.long_name;

        if (ac.types[0] == 'administrative_area_level_1') {
            result.state = ac.long_name;
        }

        if (ac.types[0] == 'administrative_area_level_2') {
            result.state = ac.long_name;
        }

    }
    return result;
};


function isTouchDevice() {
    return (('ontouchstart' in window) ||
       (navigator.maxTouchPoints > 0) ||
       (navigator.msMaxTouchPoints > 0));
  }


