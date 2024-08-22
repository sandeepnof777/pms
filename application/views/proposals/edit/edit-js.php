<script type="text/javascript" src="/static/js/jquery.fileuploader.min.js"></script>
<script src="<?php echo site_url('/3rdparty/cropper/js/cropper.js') ?>"></script>
<script src="<?php echo site_url('/3rdparty/cropper/js/main_2.js') ?>"></script>
<script>
        function workOrder_ifram_load() {
            $("#loadingFrame2").hide();
            $("#workOrder-preview-iframe").show();
            $("#estimatePreviewDialog").dialog().parent().css('height', '85%');
        }
</script>
<div id="workOrderDialog" title="Preview Work Order" style="display:none;">
<p style="font-weight: bold;width: 700px;position: absolute;font-size: 14px;top: 3px;"><span style="position:absolute"><span style="display: block; float: left;  color: #595959; text-align: left; margin-right: 10px;"><i class="fa fw fa-file-pdf-o"></i> Project: </span><span class="shadowz" style="float:left"><a class="dialog_project_name" href="#" ><?=$proposal->getProjectName();?></a></span></span><br/>
    <span style="position:absolute;left:0px;margin-top:3px" ><span style="display: block;float: left;margin-right:7px;  color: #595959; text-align: left; "><i class="fa fw fa-user"></i> Contact: </span><span style="float:left;"><a style="float:left"   href="#" class="dialog_project_contact_name"><?php echo $proposal->getClient()->getFullName(); ?></a></span></span></p>
    <div style="float: left;">
        <input id="work_order_url_link" type="hidden" >

        <span class="flash_copy_msg" style="margin-left: 380px;display: none;">Link Copied to clipboard</span>
    </div>
<a href="javascript:void(0);"  class="btn right blue-button workorder_link_copy tiptip" title="Copy Work Order Link" style="margin-bottom: 5px;" >
        <i class="fa fa-fw fa-copy" ></i> Copy Link</a>
<a href="javascript:void(0);" download="" class="btn right blue-button workorder_download_btn tiptip" title="Download your Work-Order" style="margin-bottom: 5px;margin-right:5px;" >
<i class="fa fa-fw fa-download" ></i>Download</a>
<a href="javascript:void(0);"  id="workorderpreviewPDF" class="btn right blue-button  tiptip" title="Pdf View" style="margin-bottom: 5px;margin-right:5px;" >
<i class="fa fa-fw fa-download" ></i>PDF/Print</a>
<a href="javascript:void(0);" id="workorderpreviewWEB" class="btn right blue-button  tiptip" title="Web View" style="margin-bottom: 5px;margin-right:5px;" >
<i class="fa fa-fw fa-globe" ></i>Web View</a>
<a href="javascript:void(0);"  class="btn right blue-button workorder_send_btn tiptip" title="Send your Work-Order" style="margin-bottom: 5px; margin-right:5px;" >
<i class="fa fa-fw fa-envelope" ></i>Send</a>
<div style="text-align: center;" id="loadingFrame2">
                    <br />
                    <br />
                    <br />
                    <br />
                    <p><img src="/static/blue-loader.svg" /></p>
                </div>

<iframe id="workOrder-preview-iframe" onload="workOrder_ifram_load()" style="width: 100%; height: 650px;border-top: 1px solid rgb(68, 68, 68);"></iframe>

</div>


<script type="text/javascript">
    var site_url = '<?php echo site_url() ?>';
    var bgColor = new Array();
    var textColor = new Array();
    var show_edit_flag = false;
    var selected_uploading_image_count = 0;
    var image_blob_data;
    var image_blob_data2 = [];
    var fileuploader;
    var fileuploaderApi;
    var mapfileuploader;
    var mapfileuploaderApi;
    var servicefileuploader;
    var servicefileuploaderApi;
    var mapservicefileuploader;
    var mapservicefileuploaderApi;
    var thumbfileuploader;
    var thumbfileuploaderApi;
    var approval_msg;
    var original_service_text;
    var ViewsDatatable;
    var servicefileUploaderImageUploadLimit = 2;
    var mapservicefileUploaderImageUploadLimit = 1;
    var addServiceAndUploadImage = false;
    var email_to_input_count = 1;
    var videoSettingsChanged = false;

    $(document).on('change', "#proposalSettingDate", function () {
        p_create = $(this).val();
        actual_create = '<?php echo date_format(date_create($proposal->getActualCreatedDate()), "m/d/Y"); ?>';
        if (p_create == actual_create) {
            $('#proposalActualDateSpan').hide();
        } else {
            $('#proposalActualDateSpan').show();
        }
    });
    $(document).ready(function () {

        $("#LogoUploadEditor").dialog({
          modal: true,
          autoOpen: false,
          width: 785,
          height:608,
          position: ['center'] 
      });

        $(function () {
            $("#edit_service_tabs").tabs();
            //$("#add_service_tabs").tabs();
        });

        var emailBodyConfig = {
            selector: '.theText',
            menubar: false,
            inline: true,
            plugins: [
                'link',
                'lists',
                'powerpaste',
                'autolink',
                'tinymcespellchecker'
            ],

            toolbar: [
                'undo redo | bold italic underline | fontselect fontsizeselect',
                'forecolor backcolor | alignleft aligncenter alignright alignfull | numlist bullist outdent indent'
            ],

        };

        $('.select2_company_videos').select2({
            placeholder: "Select a Video",
            allowClear: false
        });


        $("#estimatepreviewDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 900
        });
        $('#headerBgColorUndo').hide();
        $('#headerFontColorUndo').hide();

        bgColor.push('<?= $proposal->getHeaderBgColor(); ?>');

        textColor.push('<?= $proposal->getHeaderFontColor(); ?>')

        if ($('#is_show_logo').val() == '0') {
            $('#preview-logo').hide();
        } else {
            $('#preview-logo').show();
        }


        if ($("#select_background_image").val() == 0) {
            $('.upload_image_p').show();
            //$("#previewContainer").hide();
        } else {
            console.log($("#select_background_image").find(':selected').attr('data-val'));
            $('.background_url').val($("#select_background_image").find(':selected').attr('data-val'));
            $('.background_image').val($("#select_background_image").val());

        }


        p_create = '<?php echo $proposal->getCreated(); ?>';
        actual_create = '<?php echo date_format(date_create($proposal->getActualCreatedDate()), "m/d/Y"); ?>';
        if (p_create == actual_create) {
            $('#proposalActualDateSpan').hide();
        } else {
            $('#proposalActualDateSpan').show();
        }
        var newEditPageMessage = true;
        var additional = <?php echo ($additional) ? 'true' : 'false'; ?>;

        if (localStorage.getItem('noEditPageMessage') || additional) {
            newEditPageMessage = false;
        }

        var proposalId = '<?php echo $proposal->getProposalId(); ?>';
        var companyId = '<?php echo $proposal->getOwner()->getCompanyId(); ?>';
        var generalSettingsChanged = false;
        
        var imageUploadLimit = <?php echo IMAGE_UPLOAD_LIMIT; ?>;
        var fileUploaderImageUploadLimit = <?php echo IMAGE_UPLOAD_LIMIT; ?> -numUploadedImages();

        var mapImageUploadLimit = <?php echo MAP_IMAGE_UPLOAD_LIMIT; ?>;
        var fileUploaderMapImageUploadLimit = <?php echo MAP_IMAGE_UPLOAD_LIMIT; ?> -numUploadedMapImages();

        window.onbeforeunload = function () {
            if (generalSettingsChanged) {
                return 'You have not saved your changes!';
            }
            return null;
        };


        toastr.options = {
            "closeButton": true,
            "debug": false,
            "newestOnTop": false,
            "progressBar": false,
            "positionClass": "toast-top-right",
            "preventDuplicates": true,
            "onclick": null,
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        }


        // The vertical tabs
        $("#proposal-tabs").tabs({
            beforeActivate: function (event, ui) {
                if (generalSettingsChanged) {
                    $("#proposal-settings-tabs").tabs("option", "active", 0);

                    swal(
                        'Unsaved Changes',
                        'You still have unchanged <strong>General Settings</strong>'
                    );
                    return false;
                }

                if (videoSettingsChanged) {
                    
                    swal(
                        'Unsaved Changes',
                        'You still have unchanged <strong>Video Settings</strong>'
                    );
                    return false;
                }
            },
            activate: function (event, ui) {
                var panelId = ui.newPanel[0].id;

                switch (panelId) {

                    case 'activity':
                        activityTable.fnReloadAjax();
                        break;
                    case 'proposalView':
                        if (ViewsDatatable) {
                            ViewsDatatable.fnReloadAjax();
                        } else {
                            initViewsDatatable();
                        }

                        break;
                    case 'settings':
                        $("#proposal-settings-tabs").tabs("option", "active", 0);
                        break;
                    case 'images':
                        $("#select_image_none").trigger("click");
                        break;
                    case 'maps':
                        $("#select_image_none").trigger("click");
                        break;
                    case 'docs':
                        $("#proposal-docs-tabs").tabs("option", "active", 0);
                        tinymce.remove();
                        tinymce.init({
                            selector: "#workOrderNotes",
                            menubar: false,
                            elementpath: false,
                            relative_urls: false,
                            remove_script_host: false,
                            convert_urls: true,
                            browser_spellcheck: true,
                            contextmenu: false,
                            height: '320',
                            plugins: "link image code lists paste preview ",
                            toolbar: tinyMceMenus.email,
                            forced_root_block_attrs: tinyMceMenus.root_attrs,
                            fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
                        });
                        break;
                }

            }
        }).addClass("ui-tabs-vertical ui-helper-clearfix");
        $("#proposal-tabs li").removeClass("ui-corner-top").addClass("ui-corner-left");

        // The settings tabs
        $("#proposal-settings-tabs").tabs({
            beforeActivate: function (event, ui) {
                if (generalSettingsChanged) {
                    $("#tabs").tabs("#proposal-settings-tabs", 0);

                    swal(
                        'Unsaved Changes',
                        'You still have unchanged <strong>General Settings</strong>'
                    );
                    return false;
                }
            }
        });
        $("#proposal-docs-tabs").tabs();


        // Dop we need a message in services
        updateProposalServices();

        function toggleGeneralSaveButton() {

            if (generalSettingsChanged) {
                $("#topSaveGeneralSettings").show();
                $("#saveGeneralSettingsRow").show();
            } else {
                $("#topSaveGeneralSettings").hide();
                $("#saveGeneralSettingsRow").hide();
            }
        }

        function clearEditedLabels() {
            $('label').removeClass('editedLabel');
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

        //funky pricing code
        function updatePricingUI() {
            var priceType = $("#pricingType").val();
            var total;
            if ($("#addPrice").length) {
                total = $("#addPrice").val();
            } else {
                total = $("#editPrice").val();
            }
            total = total.replace('$', '');
            total = total.replace(/,/g, '');
            var qty = $("#amountQty").val();
            if (qty) {
                qty = qty.replace(/,/g, '');
            }

            if (qty == '') {
                qty = 0;
            }

            if (total > 0) {
                $("#edit_no_price").prop('checked', false);
            }

            // console.log("total",total);
            // console.log("qty",qty);

            total = addCommas(parseFloat(total) * parseFloat(qty));

            $("#totalCalculated").val('$' + total);
            $(".amount-container").show();
            $("#materials-container").hide();
            switch (priceType) {
                case 'Total':
                    $("#price-label").html('Total Price');
                    $(".amount-container").hide();
                    break;
                case 'Materials':
                    $("#price-label").html('Material Price');
                    $("#materials-container").show();
                    $(".amount-container").hide();
                    break;
                case 'Season':
                    $("#price-label").html('Season Price');
                    //                                $(".amount-container").hide();
                    break;
                case 'Year':
                    $("#price-label").html('Yearly Price');
                    $(".amount-container").hide();
                    break;
                case 'Hour':
                    $("#price-label").html('Hourly Price');
                    $(".amount-container").hide();
                    break;
                case 'Trip':
                    $("#price-label").html('Price/Trip');
                    $("#amount-label").html('# of Trips');
                    break;
                case 'Month':
                    $("#price-label").html('Price/Month');
                    break;
                case 'Hour':
                    $("#price-label").html('Hourly Price');
                    $("#amount-label").html('# of Hours');
                    break;
                case 'Noprice':
                    $(".amount-container").hide();
                    $("#price-container").hide();
                    break;
                default:
                    //failsage
                    $("#price-label").html('Price');
                    break;
            }
        }

        $("#pricingType").live('change', function () {
            updatePricingUI();
        });
        $("#amountQty, #addPrice, #editPrice").live('keyup', function () {
            updatePricingUI();
        });


        $('#serviceCategory option').attr('selected', false);
        <?php
        $js_services = array();
        foreach ($services as $service) {
            if ($service->getParent() > 0) {
                $title = (isset($service_titles[$service->getServiceId()])) ? $service_titles[$service->getServiceId()] : $service->getServiceName();
                $js_services[$service->getParent()][] = array($service->getServiceId(), $title);
            }
        }
        ?>
        var services = <?php echo json_encode($js_services) ?>;

        // Selecting the service category
        $("#selectServiceCategory a").click(function () {

            $("#selectService").html('<img src="/static/loading_animation.gif" /><p>Loading Services...</p>');

            var proceed = false;

            // Is this the snow removal category
            if ($(this).attr('rel') == '105') {

                $.ajax({
                    type: "GET",
                    url: "<?php echo site_url('ajax/proposalServiceTypes') ?>/" + "<?php echo $proposal->getProposalId(); ?>",
                    async: false,
                    dataType: 'json',
                    success: function (data) {

                        // Proposal either has snow, or no other services
                        if (data.snow || !data.serviceCount) {
                            // No problem here, move along
                            proceed = true;
                        } else {
                            $("#snowError").dialog('open');
                        }
                    }
                });
            } else {
                // Non snow related category
                $.ajax({
                    type: "GET",
                    url: "<?php echo site_url('ajax/proposalServiceTypes') ?>/" + "<?php echo $proposal->getProposalId(); ?>",
                    async: false,
                    dataType: 'json',
                    success: function (data) {
                        // Proposal either has snow, or no other services
                        if (data.snow) {
                            $("#snowError").dialog('open');
                        } else {
                            proceed = true;
                        }
                    }
                });
            }

            $("#selectServiceCategory a").removeClass('selected');
            $(this).addClass('selected');

            if (proceed) {

                if (typeof (services[$(this).attr('rel')]) != 'undefined') {
                    $("#selectService").html('');
                    for (var service in services[$(this).attr('rel')]) {
                        $("#selectService").append('<a href="#" rel="' + services[$(this).attr('rel')][service][0] + '" data-parent="' + $(this).attr('rel') + '">' + services[$(this).attr('rel')][service][1] + '</a>');
                    }
                    $("#selectService a:first").addClass('selected');
                } else {
                    $("#selectService").html('<a href="#" rel="0">Empty category</a>');
                }
            } else {
                $("#selectService").html('<a href="#" rel="0">Invalid Category</a>');
            }

            return false;

        });

        $("#selectService a").live('click', function () {
            $("#selectService a").removeClass('selected');
            $(this).addClass('selected');
            return false;
        });
        /////
        $("#addServiceTexts, #editServiceTexts").sortable({
            handle: '.handle'
        });

        function addSnowService(serviceId) {

            $.getJSON('<?php echo site_url('ajax/getSnowServiceDetails') ?>/' + serviceId, function (data) {
                if (data.error == 1) {
                    alert('The service selected was not found. Please refresh the page and try again.');
                } else {
                    //init popup
                    $("#addServiceName").html('');
                    $("#addServiceTexts").html('');
                    $("#addServiceFields").html('');
                    //populate popup
                    $("#addServiceName").html(data.serviceName);
                    //add the texts
                    for (i in data.texts) {
                        $("#addServiceTexts").append('<div class="text clearfix"><span class="handle ui-icon ui-icon-arrowthick-2-n-s"></span><span class="theText" contenteditablez="true">' + data.texts[i] + '</span><span class="remove"><a href="#" class="remove tiptip" title="Remove Line (Irreversible!)">Remove</a></span></div>');
                    }
                    //add the fields
                    for (i in data.fields) {
                        $("#addServiceFields").append(data.fields[i]);
                    }
                    $("#addService").dialog('open');

                    //$( "#add_service_tabs" ).tabs({ active: 0 });
                    tinymce.remove();
                    $("#addServiceTexts").sortable('refresh');
                    $("#addServiceId").val($("#selectService a.selected").attr('rel'));
                    initButtons();
                    updatePricingUI();
                }
            });

            return false;
        }

        $("#addServiceToProposal").click(function () {
            if (($("#selectService a.selected").attr('rel') == 0) || ($("#selectService a.selected").attr('rel') == null)) {
                $("#badService").dialog('open');
            } else {

                // Get the parent category
                category = $("#selectService a.selected").data('parent');

                if (category == 105) {
                    snow = true;
                } else {
                    snow = false
                }

                if (!snow) {
                    $.getJSON('<?php echo site_url('ajax/getServiceDetails') ?>/' + $("#selectService a.selected").attr('rel'), function (data) {

                        if (!data.user_logged_in) {
                            swal(
                                'Error',
                                'You account has been logged out. Please login again.'
                            );
                            setTimeout(function () {
                                window.location.href = "<?php echo site_url('') ?>";
                            }, 2000);

                            return false;
                        }

                        if (data.error == 1) {
                            alert('The service selected was not found. Please refresh the page and try again.');
                        } else {
                            //init popup
                            $("#addServiceName").html('');
                            $("#addServiceTexts").html('');
                            $("#addServiceFields").html('');
                            //populate popup
                            $("#addServiceName").html(data.serviceName);
                            //add the texts
                            for (i in data.texts) {
                                $("#addServiceTexts").append('<div class="text clearfix"><span class="handle ui-icon ui-icon-arrowthick-2-n-s"></span><span class="theText" contenteditablez="true">' + data.texts[i] + '</span><span class="remove"><a href="#" class="remove tiptip" title="Remove Line (Irreversible!)">Remove</a></span></div>');
                            }
                            //add the fields
                            for (i in data.fields) {
                                $("#addServiceFields").append(data.fields[i]);
                            }
                            $("#addService").dialog('open');
                            //$( "#add_service_tabs" ).tabs({ active: 0 });
                            tinymce.remove();
                            $("#addServiceTexts").sortable('refresh');
                            $("#addServiceId").val($("#selectService a.selected").attr('rel'));
                            $("#addServiceAddField").val('');
                            initButtons();
                        }
                    });

                    return false;
                } else {
                    addSnowService($("#selectService a.selected").attr('rel'));
                }
            }
        });
        //Edit Service Name
        $("#addServiceName, #editServiceName").editable('<?php echo site_url('ajax/dummyPost') ?>', {
            cancel: 'Cancel',
            submit: 'OK',
            width: 510,
            height: 100,
            callback: function (value, settings) {
                var json = $.parseJSON(value);
                if (json.status == 0) {
                    swal({
                        title: "",
                        text: "An error occurred. Please log in again.",
                        showCancelButton: false,
                        confirmButtonText: '<i class="fa fa-check-circle "></i> Ok',
                        allowOutsideClick: false,
                        dangerMode: true,

                    }).then(function (result) {
                        document.location.href = '<?php echo site_url('account/logout') ?>';
                    }).catch(swal.noop)
                }
                $(this).html(json.value);
            }
        });
        //Bad service selected
        $("#badService, #badService2").dialog({
            autoOpen: false,
            modal: true,
            width: 400,
            buttons: {
                Close: function () {
                    $(this).dialog('close');
                }
            }
        });
        // Snow Error
        $("#snowError").dialog({
            autoOpen: false,
            modal: true,
            width: 400,
            buttons: {
                Close: function () {
                    $(this).dialog('close');
                }
            }
        });

        // Adding a service
        function addService(redirect) {

            var postData = {};
            //get title
            postData.serviceName = $("#addServiceName").html();
            //get price
            postData.option = $('#optional').prop('checked') ? '1' : 0;
            postData.no_price = $('#no_price').prop('checked') ? '1' : 0;
            postData.is_estimate = $('#add_service_estimate').prop('checked') ? '1' : 0;
            postData.is_hide_proposal = $('#add_hide_from_proposal').prop('checked') ? '1' : 0;

            postData.map_area_data = $("#map_area_data").val();
            postData.price = $("#addPrice").val();
            postData.amountQty = $("#amountQty").val();
            postData.pricingType = $("#pricingType").val();
            postData.material = $("#material").val();
            postData.excludeFromTotals = $('#exclude_total').prop('checked') ? '1' : 0;
            postData.texts = [];
            //get texts
            var k = 0;
            $("#addServiceTexts div.text").each(function () {
                postData.texts[k] = $(this).children('span.theText').html();
                k++;
            });
            //get fields values
            postData.fields = {};
            $("#addServiceFields .field").each(function () {
                postData.fields[$(this).attr('id')] = $(this).val();
            });
            postData.serviceId = $("#addServiceId").val();
            postData.proposal = <?php echo $this->uri->segment(3) ?>;

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('ajax/proposalAddService') ?>",
                data: postData,
                dataType: 'json'
            })
                .done(function (data) {

                    if (!data.id) {
                        swal(
                            'Error',
                            'There was an error saving the information'
                        );
                        return;
                    }

                    var serviceName = $("#addServiceName").text();
                    var serviceNameHtml = '<span class="serviceName" >' + serviceName + '</span></span>';

                    var hide_in_proposal = (data.hideInProposal == 1) ? ' ' : 'display:none';
                    var check_map_area_data = (data.map_area_data != '') ? ' ' : 'display:none';
                    var newServiceItem = '<div class="service clearfix" id="service_' + data.id + '">' +
                        '<span class="handle ui-icon ui-icon-arrowthick-2-n-s"></span>' +
                        '<span class="service' +
                        ((data.noPrice == 1) ? ' noPrice' : '') +
                        ((data.optional == 1) ? ' optional' : '') +
                        ((data.approved == 1) ? '' : 'unapproved') +
                        '">' +
                        '<span class="noPriceTag"><strong>[NP] </strong></span>' +
                        '<span class="optionalTag"><strong>[OS] </strong></span>' +
                        '<span class="unapprovedTag"><strong>[A] </strong></span>' +
                        serviceNameHtml +
                        '<span class="actions">' +
                        '<i class="fa fa-fw fa-eye-slash fa-sm tiptip hide_in_proposal" title="Hide In Proposal" style="color: #7b7a7a;' + hide_in_proposal + '"></i>' +
                        '<a style="color: #7b7a7a;cursor:pointer;' + check_map_area_data + '" class="map_data_icon tiptip" title="' + data.map_area_data + '"  data-title="' + data.map_area_data + '" data-id="' + data.id + '"><i class="fa fa-fw fa-map-o fa-sm "  ></i></a>' +
                        '<a href="javascript:void(0)" style="color: #7b7a7a;"><i class="fa fa-fw fa-image tiptip" title="No Images"></i> <span class="serviceImageCount_'+data.id+'" style="color: red;">0 </span></a>'+
                        '<i class="fa fa-fw fa-lg" style="margin-right: 3px;"></i>' +
                        '<a class="btn-edit tiptip" title="Edit Service" rel="' + data.id + '" data-id="' + data.id + '">Edit</a> ' +
                        '<a class="btn-delete tiptip" title="Delete Service" data-id="' + data.id + '">Delete</a>' +
                        '</span></div>';


                    $("#proposal_services").append(newServiceItem);
                    $("#proposal_services").sortable('refresh');
                    initTiptip();
                    initButtons();
                    $("#service_" + data.id).effect('highlight', {
                        color: '#25AAE1',
                        duration: 1500
                    });

                    // Now we need to reset the categories
                    $("#selectService").html('<a href="#" rel="0">Select a category</a>');
                    $(".selectOptions a").removeClass('selected');

                    if (redirect != 0) {
                        document.location.href = '<?php echo site_url('account/calculators/sealcoating') ?>/' + data.id;
                    }
                    if (data.proposal_approval == 0) {
                        $('.has_email_permission').removeClass('send_proposal_email');
                        $('.has_email_permission').addClass('approval_proposal_email');
                    } else {
                        $('.has_email_permission').addClass('send_proposal_email');
                        $('.has_email_permission').removeClass('approval_proposal_email');
                    }

                    updateProposalServices();
                    if (addServiceAndUploadImage) {
                        $('.btn-edit[data-id="' + data.id + '"').trigger('click');
                    } else {
                        $("#addService").dialog('close');
                    }
                    $( ".select_service_map" ).each(function( index ) {
                        $(this).append($("<option></option>").attr("value", data.id).text(serviceName));
                    });

                    // code start to checked check box 
                               
                              // console.log("dataTextId",data.TextId);

                            // Loop through the TextId array and check the corresponding checkboxes
                          if (data && typeof data.TextId !== 'undefined') {
                            $.each(data.TextId, function(index, value) {
                                value = String(value);  // Ensure value is treated as a string
                                // Check the checkbox by ID
                                var checkboxById = $('#' + value);
                                if (checkboxById.length) {
                                    checkboxById.prop('checked', true);
                                    // Ensure the parent span has the checked class (for some frameworks)
                                    checkboxById.closest('span').addClass('checked');
                                } else {
                                    console.log("Checkbox not found by ID: #" + value);
                                }

                                // Check the checkbox by name prefix
                                var checkboxByName = $('input[name="checkbox_' + value + '"]');
                                if (checkboxByName.length) {
                                    checkboxByName.prop('checked', true);
                                    // Ensure the parent span has the checked class (for some frameworks)
                                    checkboxByName.closest('span').addClass('checked');
                                    //console.log("Checked by Name: checkbox_" + value);
                                } else {
                                    console.log("Checkbox not found by Name: checkbox_" + value);
                                }
                            });
                        }else{console.log("custom text not avilabel for",data.service_id)}

                    // code close to checked check box
 
                    //for category unchecked
                                    if (Object.keys(data.categoryValue).length !== 0){
                                      $.each(data.categoryValue, function(index, value) {
                                    value = String(value);  // Ensure value is treated as a string
                                    if(value=="1"){
                                    // Uncheck the checkbox by ID
                                    var checkboxById = $('#textcat-' + index);
                                    if (checkboxById.length) {
                                        checkboxById.prop('checked', true);
                                        // Ensure the parent span has the unchecked class (for some frameworks)
                                        checkboxById.closest('span').removeClass('unchecked').addClass('checked');
                                       // console.log("checked by ID: #" + index);
                                    } else {
                                        console.log("Checkbox not found by ID: #" + index);
                                    }

                                    // Uncheck the checkbox by name prefix
                                    var checkboxByName = $('input[name="textcat-' + index + '"]');
                                    if (checkboxByName.length) {
                                        checkboxByName.prop('checked', true);
                                        // Ensure the parent span has the unchecked class (for some frameworks)
                                        checkboxByName.closest('span').removeClass('unchecked').addClass('checked');
                                        //console.log("checked by Name: textcat-" + index);
                                    } else {
                                        console.log("Checkbox not found by Name: textcat-" + index);
                                    }
                                }
                                });
                                //for category unchecked close
                           }else{console.log("Category id is not avilabel",data.service_id)}
                       })
                .fail(function (xhr) {
                    swal(
                        'Error',
                        'There was an error saving the information: Error Information: ' + xhr.responseText
                    );
                });
        }

        $(document).on('click', ".map_data_icon", function () {

            var serviceId = $(this).attr('data-id');
            var mapData = $(this).attr('data-title');
            console.log(mapData);
            var serviceName = $('#service_' + serviceId).find('.serviceName').html();
            swal({
                title: 'Edit Service Map Area',
                allowOutsideClick: false,
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: "Cancel",
                dangerMode: false,
                reverseButtons: false,
                html: '<label><strong>Service:</strong> ' + serviceName + '</label><br/><input id="swal-input1-edit-map-area" class="swal2-input" value="' + mapData + '">',
                preConfirm: function () {
                    //if($('#swal-input1-edit-map-area').val()){


                    return new Promise(function (resolve) {

                        resolve(
                            $('#swal-input1-edit-map-area').val()
                        )
                    })
                    // }else{
                    //     alert('Please Enter the Map Area');
                    // }
                },
                onOpen: function () {
                    $('#swal-input1-edit-map-area').focus()
                }
            }).then(function (result) {

                swal('Saving..')
                var mapData = $('#swal-input1-edit-map-area').val();
                $.ajax({
                    url: '/ajax/update_service_map_area_data',
                    type: "POST",
                    dataType: "json",
                    data: {
                        "serviceId": serviceId,
                        "mapData": mapData
                    },

                    success: function (data) {
                        if (!data.error) {
                            swal('Map Area Updated')
                            if (mapData) {
                                $('#service_' + serviceId).find('.map_data_icon').attr('title', result);
                                $('#service_' + serviceId).find('.map_data_icon').attr('data-title', result);
                                initTiptip();
                            } else {
                                $('#service_' + serviceId).find('.map_data_icon').hide()
                            }
                        } else {
                            swal("Error", "An error occurred Please try again");
                            return false;
                        }
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        swal("Error", "An error occurred Please try again");
                        console.log(errorThrown);
                    }
                })
            }).catch(swal.noop)
        });


        $(".addSealcoatingService").live('click', function () {
            addService(1);
        });
        //Add New Service
        $("#addService").dialog({
            autoOpen: false,
            modal: true,
            width: 966,
            draggable: false,
            resizable: false,
            buttons: {
                'Finish': {
                    id: 'addServiceFinish',
                    class: 'addServiceFinish update-button addIcon',
                    text: 'Add Service',
                    click: function () {

                        if (tinymce.activeEditor) {
                            $("#textEditorOpen").dialog('open');
                            return false;
                        } else {
                            $('#addServiceFinish span').text('Sending...');
                            $('#addServiceFinish').prop('disabled', true);
                            addService(0);
                            $('#addServiceFinish span').text('Add Service');
                            $('#addServiceFinish').prop('disabled', false);
                            //$(this).dialog('close');
                        }
                    }
                },
                Cancel: {
                    class: 'closeIcon',
                    text: 'Cancel',
                    click: function () {
                        $(this).dialog('close');
                    }
                },
                'next': {
                    class: 'add_service_next_btn update-button',
                    html: '<i class="fa fa-fw fa-image"></i> Add Images',
                    click: function () {
                        $(this).dialog('close');
                    }
                }
            }
        });
        $("#addServiceAddFieldButton").click(function () {
            if (tinymce.activeEditor) {
                $("#textEditorOpen").dialog('open');
                return false;
            }
            $(".text").removeClass('newText');

            $("#addServiceTexts").append('<div class="text newText clearfix"><span class="handle ui-icon ui-icon-arrowthick-2-n-s"></span><span class="theText" contenteditablez="true">' + $("#addServiceAddField").val() + '</span><span class="remove"><a href="#" class="remove tiptip" title="Remove Line (Irreversible!)">Remove</a></span></div>');
            $("#addServiceAddField").val('');
            $("#addServiceTexts").sortable('refresh');
            var newItem = $(".newText").find('.theText').last();
            //newItem.click();
            setTimeout(function () {
                newItem.dblclick();
                var objDiv = $("#addServiceTexts");
                if (objDiv.length > 0){
                    objDiv[0].scrollTop = objDiv[0].scrollHeight;
                }
            }, 500);

            

            return false;
        });
        $(".remove").live('click', function () {
            $(this).parents('.text').fadeOut('slow').remove();
            return false;
        });


        $(".theText").live('dblclick', function () {
            tinymce.remove();
            $('#temp_editor').attr('id', '')
            original_service_text = $(this).html();
            $(this).attr('id', 'temp_editor');
            $(this).closest('.text').find('.remove').hide();
            $('#mce_set_btn').remove();
            $(this).after('<div id="mce_set_btn" style="margin-left: 30px;padding-top:5px"><a class="btn blue-button" id="set_mce_data"><i class="fa fa-fw fa-check-circle-o"></i> Save Text</a><a class="btn right" id="reset_mce_data"><i class="fa fa-fw fa-times"></i> Cancel</a></div> ')
            tinymce.init({
                selector: "#temp_editor",
                menubar: false,
                elementpath: false,
                relative_urls: false,
                remove_script_host: false,
                convert_urls: true,
                browser_spellcheck: true,
                contextmenu: false,
                paste_as_text: true,
                remove_trailing_brs: false,
                plugins: "link image code lists paste preview ",
                toolbar: tinyMceMenus.serviceMenu,
                forced_root_block_attrs: tinyMceMenus.root_attrs,
                fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px",
                forced_root_block: 'div',
                browser_spellcheck: true,
                paste_as_text: true,
                valid_elements: "*[*]", // Allow all elements
                valid_styles: {
                    '*': 'color,text-decoration' // Allow only color and text-decoration styles
                },
                init_instance_callback: function (editor) {
                    editor.on('BeforeSetContent', function (e) {
                        e.content = e.content.replace(/<div[^>]*style="[^"]*font-size:[^"]*"[^>]*>/g, '<div>');
                    });
                    editor.on('GetContent', function (e) {
                        e.content = e.content.replace(/<div[^>]*style="[^"]*font-size:[^"]*"[^>]*>/g, '<div>');
                    });
                } 


                // setup: function (editor) {
                //   editor.on('GetContent', function (e) {
                //      e.content = e.content.replace(/<p[^>]*>/g, '').replace(/<\/p>/g, '');
                //   });
                // },
            });
            initButtons();

        });

        //$(document).on('focusin', function(e) {
        //console.log($(e.target).closest(".tox-dialog").length)
        //if ($(e.target).closest(".tox-dialog").length) {
        //e.preventDefault();
        //e.stopImmediatePropagation();
        //e.stopPropagation();
        //}
        //});
        $("#set_mce_data").live('click', function () {
            tinymce.remove();
            $('#temp_editor').attr('id', '');

            $(this).closest('.text').find('.remove').show();
            $('#mce_set_btn').remove();
            original_service_text = '';
        })

        $("#reset_mce_data").live('click', function (e) {
            tinymce.remove();

            $('#temp_editor').html(original_service_text);
            if ($('#temp_editor').html() == '') {
                $(this).closest('.text').find('.remove').trigger('click');
            }
            $(this).closest('.text').find('.remove').show();

            $('#temp_editor').attr('id', '');
            $('#mce_set_btn').remove();
            original_service_text = '';
            // console.log($(e).parent('.newText').length);
            // if($(this).closest('.text').hasClass("newText")){
            //     $(this).closest('.text').find('.remove').trigger('click');

            // }

        })

        //Edit Text
        $(".theText22").live('click', function () {

            $(this).editable('<?php echo site_url('ajax/dummyPost') ?>', {
                type: 'ckeditor',
                cancel: 'Cancel',
                submit: 'OK',
                rows: 3,
                width: 510,
                height: 300,
                callback: function (value, settings) {
                    var json = $.parseJSON(value);
                    if (json.status == 0) {
                        swal({
                            title: "",
                            text: "An error occurred. Please log in again.",
                            showCancelButton: false,
                            confirmButtonText: '<i class="fa fa-check-circle "></i> Ok',
                            allowOutsideClick: false,
                            dangerMode: true,

                        }).then(function (result) {
                            document.location.href = '<?php echo site_url('account/logout') ?>';
                        }).catch(swal.noop)
                    }
                    $(this).html(json.value);
                },
                ckeditor: {
                    height: 100,
                    toolbar: [{
                        name: 'basicstyles',
                        items: ['Bold', 'Italic', 'Underline', '-', 'RemoveFormat', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', 'NumberedList', 'BulletedList']
                    },
                        {
                            name: 'links',
                            items: ['Link', 'Unlink']
                        },
                        {
                            name: 'spellcheck',
                            items: ['jQuerySpellChecker']
                        }
                    ]
                },
                onblur: 'ignore'
            });
        });


        tinymce.init({
            selector: ".theText33",
            menubar: false,
            elementpath: false,
            relative_urls: false,
            remove_script_host: false,
            convert_urls: true,
            browser_spellcheck: true,
            contextmenu: false,
            paste_as_text: true,
            inline: true,
            plugins: "link image code lists paste preview ",
            toolbar: tinyMceMenus.serviceMenu,
            forced_root_block_attrs: tinyMceMenus.root_attrs,
            fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
        });

        /*Proposal services stuff*/
        $("#proposal_services").sortable({
            handle: ".handle",
            stop: function () {
                var k = 0;
                saveServicesOrder();
            }
        });

        function saveServicesOrder(rebuild) {
            var rebuildFlag = 1;
            if (rebuild === 0) {
                rebuildFlag = 0;
            }

            var postData = 'rebuild=' + rebuildFlag + '&';
            postData += $("#proposal_services").sortable("serialize");
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('ajax/updateProposalServicesOrder') ?>",
                data: postData,
                async: false
            });
        }

        //services order reset the .ord value initially correct.
        saveServicesOrder(0);
        //Delete Service confirmation
        var deleteServiceURL = '';

        // Delete Service Handler
        $(document).on('click', "#proposal_services .btn-delete", function () {
            var serviceId = $(this).data('id');
            $("#confirmServiceDelete").dialog('open');
            $("#confirmServiceDelete").data('delete-id', serviceId);
            return false;
        });

        $("#confirmServiceDelete").dialog({
            autoOpen: false,
            modal: true,
            width: 400,
            buttons: {
                Confirm: {
                    class: 'update-button deleteIcon',
                    text: ' Delete Service',
                    click: function () {


                        $(this).dialog('close');
                        $("#loading").show();

                        $.ajax({
                            type: "GET",
                            url: "<?php echo site_url('ajax/deleteProposalService') ?>/" + $("#confirmServiceDelete").data('delete-id'),
                            dataType: 'json'
                        })
                            .done(function (data) {

                                $("#loading").hide();

                                if (!data.user_logged_in) {
                                    swal(
                                        'Error',
                                        'You account has been logged out. Please login again.'
                                    );
                                    setTimeout(function () {
                                        window.location.href = "<?php echo site_url('') ?>";
                                    }, 2000);
                                    return false;

                                }
                                if (!data.id) {
                                    swal(
                                        'Error',
                                        'There was an error deleting the service'
                                    );
                                    return;
                                }

                                $("#service_" + data.id).effect('highlight', 'slow').remove();
                                
                                $( ".select_service_map" ).each(function( index ) {
                                    
                                    $(this).find('option[value="'+data.id+'"]').remove();
                                });
                                swal(
                                    'Success',
                                    'Service Deleted'
                                );

                                updateProposalServices();

                                   // code start to checked check box 

                            // Loop through the TextId array and uncheck the corresponding checkboxes
                               if (data && typeof data.TextId !== 'undefined') {
                                $.each(data.TextId, function(index, value) {
                                    value = String(value);  // Ensure value is treated as a string
                                    // Uncheck the checkbox by ID
                                    var checkboxById = $('#' + value);
                                    if (checkboxById.length) {
                                        checkboxById.prop('checked', false);
                                        // Ensure the parent span has the unchecked class (for some frameworks)
                                        checkboxById.closest('span').removeClass('checked').addClass('unchecked');
                                       // console.log("Unchecked by ID: #" + value);
                                    } else {
                                        console.log("Checkbox not found by ID: #" + value);
                                    }

                                    // Uncheck the checkbox by name prefix
                                    var checkboxByName = $('input[name="checkbox_' + value + '"]');
                                    if (checkboxByName.length) {
                                        checkboxByName.prop('checked', false);
                                        // Ensure the parent span has the unchecked class (for some frameworks)
                                        checkboxByName.closest('span').removeClass('checked').addClass('unchecked');
                                       // console.log("Unchecked by Name: checkbox_" + value);
                                    } else {
                                        console.log("Checkbox not found by Name: checkbox_" + value);
                                    }
                                });
                            }else{console.log("custom text not avilabel for this service",data.service_id);}

                                //for category unchecked
                                console.log(data.categoryValue);
                                   if (Object.keys(data.categoryValue).length !== 0){

                                      $.each(data.categoryValue, function(index, value) {
                                            value = String(value);  // Ensure value is treated as a string
                                  
                                    // Uncheck the checkbox by ID
                                        var checkboxById = $('#textcat-' + index);
                                        if (checkboxById.length) {
                                            checkboxById.prop('checked', false);
                                            // Ensure the parent span has the unchecked class (for some frameworks)
                                            if(value=="1"){
                                            checkboxById.closest('span').removeClass('unchecked').addClass('checked');
                                            }else{
                                            checkboxById.closest('span').removeClass('checked').addClass('unchecked');
                                            }
                                           

                                         } else {
                                            console.log("Checkbox not found by ID: #" + index);
                                        }

                                        // Uncheck the checkbox by name prefix
                                        var checkboxByName = $('input[name="textcat-' + index + '"]');
                                        if (checkboxByName.length) {
                                            checkboxByName.prop('checked', false);
                                            // Ensure the parent span has the unchecked class (for some frameworks)
                                           
                                             if(value=="1")
                                             {
                                                checkboxByName.closest('span').removeClass('unchecked').addClass('checked');
                                             }else{
                                                    checkboxByName.closest('span').removeClass('checked').addClass('unchecked');
                                             }
                                         } else {
                                            console.log("Checkbox not found by Name: textcat-" + index);
                                        }
                               
                                });
                             }else{console.log("category id is not avilabel",data.service_id);}
                                //for category unchecked close

                              // code close to unchecked check box
                            })
                            .fail(function (xhr) {
                                $("#loading").hide();

                                swal(
                                    'Error',
                                    'There was an error saving the information: Error Information: ' + xhr.responseText
                                );
                            });
                    }
                },
                Close: {
                    class: 'closeIcon',
                    text: 'Cancel',
                    click: function () {
                        $(this).dialog('close');
                    }
                }
            }
        });

        //Edit Contract Copy
        $("#editContractCopy").dialog({
            autoOpen: false,
            modal: true,
            width: 800,
            draggable: false,
            resizable: false,
            buttons: {
                Save: {
                    class: 'update-button saveIcon',
                    text: 'Save Contract Copy',
                    click: function () {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo site_url('ajax/saveContractCopy') ?>/' + proposalId,
                            data: {
                                text: tinymce.get("contractCopyText").getContent(),
                            }
                        })
                            .done(function (data) {

                                $("#editContractCopy").dialog('close');
                                if (!data.error) {
                                    swal(
                                        'Success',
                                        'Contract Copy Updated'
                                    );
                                    return;
                                } else {
                                    swal(
                                        'Error',
                                        'There was an error saving the contract copy'
                                    );
                                }

                            })
                            .fail(function (xhr) {
                                $("#editContractCopy").dialog('close');
                                swal(
                                    'Error',
                                    'There was an error saving the information: Error Information: ' + xhr.responseText
                                );
                            });
                    }
                },
                Cancel: function () {
                    $(this).dialog('close');
                }
            }
        });
        //ckeditor
        if ($("#contractCopyText").length) {
            // var contractcopy_editor = CKEDITOR.replace('contractCopyText', {
            //     toolbar: 'Minimum'
            // });

        }
        $("#editContractCopyText").click(function () {
            tinymce.init({
                selector: "textarea#contractCopyText",
                menubar: false,
                relative_urls: false,
                elementpath: false,
                remove_script_host: false,
                convert_urls: true,
                browser_spellcheck: true,
                contextmenu: false,
                paste_as_text: true,
                height: '320',
                plugins: "link image code lists paste preview ",
                toolbar: tinyMceMenus.serviceMenu,
                forced_root_block_attrs: tinyMceMenus.root_attrs,
                fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
            });
            $.get('<?php echo site_url('ajax/getContractCopy/' . $this->uri->segment(3)) ?>', function (data) {

                tinymce.get("contractCopyText").setContent(data);
                $("#editContractCopy").dialog('open');
            });
            return false;
        });
        //Edit Payment Term
        $("#editPaymentTerm").dialog({
            autoOpen: false,
            modal: true,
            width: 800,
            draggable: false,
            resizable: false,
            buttons: {
                Save: {
                    class: 'update-button saveIcon',
                    text: 'Save Payment Terms',
                    click: function () {
                        $.ajax({
                            type: 'POST',
                            url: '<?php echo site_url('ajax/savePaymentTermText') ?>/' + proposalId,
                            data: {
                                text: tinymce.get("paymentTermText").getContent(),

                            }
                        })
                            .done(function (data) {

                                $("#editPaymentTerm").dialog('close');
                                if (!data.error) {
                                    swal(
                                        'Success',
                                        'Payment Terms Updated'
                                    );
                                    return;
                                } else {
                                    swal(
                                        'Error',
                                        'There was an error saving the payment terms'
                                    );
                                }

                            })
                            .fail(function (xhr) {
                                $("#editPaymentTerm").dialog('close');
                                swal(
                                    'Error',
                                    'There was an error saving the information: Error Information: ' + xhr.responseText
                                );
                            });
                    }
                },
                Cancel: {
                    class: 'closeIcon',
                    text: 'Cancel',
                    click: function () {
                        $(this).dialog('close');
                    }
                }
            }
        });
        //ckeditor
        if ($("#paymentTermText").length) {
            // var paymenttext_editor = CKEDITOR.replace('paymentTermText', {
            //     toolbar: 'Minimum'
            // });

        }
        $("#editPaymentTermText").click(function () {
            tinymce.init({
                selector: "textarea#paymentTermText",
                menubar: false,
                relative_urls: false,
                elementpath: false,
                remove_script_host: false,
                convert_urls: true,
                browser_spellcheck: true,
                contextmenu: false,
                paste_as_text: true,
                height: '320',
                plugins: "link image code lists paste preview ",
                toolbar: tinyMceMenus.serviceMenu,
                forced_root_block_attrs: tinyMceMenus.root_attrs,
                fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
            });

            $.get('<?php echo site_url('ajax/getPaymentTerm/' . $this->uri->segment(3)) ?>', function (data) {

                tinymce.get("paymentTermText").setContent(data);
                $("#editPaymentTerm").dialog('open');
            });
            return false;
        });

        //Edit Service
        function editService(redirect) {

            var postData = {};
            //get title
            postData.serviceName = $("#editServiceName").html();
            //get price
            postData.noPrice = $('#edit_no_price').prop('checked') ? '1' : 0;
            postData.option = $('#editOptional').prop('checked') ? '1' : 0;
            postData.isEstimate = $('#enable_service_estimate').prop('checked') ? '1' : 0;
            postData.isHideInProposal = $('#hide_from_proposal').prop('checked') ? '1' : 0;
            postData.price = $("#editPrice").val();
            postData.edit_map_area_data = $("#edit_map_area_data").val();
            postData.amountQty = $("#amountQty").val();
            postData.pricingType = $("#pricingType").val();
            postData.material = $("#material").val();
            postData.texts = [];
            postData.text_ids = [];
            postData.images = [];
            //get texts
            var k = 0;
            $("#editServiceTexts div.text").each(function () {
                postData.texts[k] = $(this).children('span.theText').html();
                postData.text_ids[k] = $(this).children('span.theText').attr('data-val');
                k++;
            });

            //get Images data
            var j = 0;
            $('#serviceImages >.image_div').each(function () {
                var image_id = $(this).attr('data-image-id');
                postData.images[j] = {
                    image_id: image_id,
                    image_title: $('#title2_' + image_id).val(),
                    image_proposal_check: $('#active_' + image_id).prop('checked') ? 1 : 0,
                    image_wo_check: $('#activewo_' + image_id).prop('checked') ? 1 : 0,
                }
                j++;
            });

            
            $('#serviceMapImages >.image_div').each(function () {
                var image_id = $(this).attr('data-image-id');
                console.log(image_id);
                postData.images[j] = {
                    image_id: image_id,
                    image_title: $('#title2_' + image_id).val(),
                    image_proposal_check: $('#active_' + image_id).prop('checked') ? 1 : 0,
                    image_wo_check: $('#activewo_' + image_id).prop('checked') ? 1 : 0,
                }
                j++;
            });
            

            //get fields values
            postData.fields = {};
            $("#editServiceFields .field").each(function () {
                postData.fields[$(this).attr('id')] = $(this).val();
            });
            postData.serviceId = $("#editServiceId").val();
            postData.proposal = <?php echo $this->uri->segment(3) ?>;
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('ajax/proposalEditService') ?>",
                data: postData,
                dataType: 'json'
            })
                .done(function (data) {

                    if (!data.id) {
                        swal(
                            'Error',
                            'There was an error saving the information'
                        );
                        return;
                    }

                    if (redirect != 0) {
                        document.location.href = '<?php echo site_url('account/calculators/sealcoating') ?>/' + data.id;
                    } else {

                        var theService = $("#service_" + data.id + " .service");

                        if (data.noPrice == 1) {
                            theService.addClass('noPrice');
                        } else {
                            theService.removeClass('noPrice');
                        }

                        if (data.optional == 1) {
                            theService.addClass('optional');
                        } else {
                            theService.removeClass('optional');
                        }

                        if (data.approved == 0) {
                            theService.addClass('unapproved');
                        } else {
                            theService.removeClass('unapproved');
                        }
                        if (data.hideInProposal == 1) {
                            $("#service_" + data.id + " .hide_in_proposal").show();
                            $("#service_" + data.id).addClass('hide_in_proposal');
                        } else {
                            $("#service_" + data.id + " .hide_in_proposal").hide();
                            $("#service_" + data.id).removeClass('hide_in_proposal');
                        }

                        if (data.proposal_approval == 0) {

                            $('.has_email_permission').removeClass('send_proposal_email');
                            $('.has_email_permission').addClass('approval_proposal_email');
                        } else {
                            $('.has_email_permission').addClass('send_proposal_email');
                            $('.has_email_permission').removeClass('approval_proposal_email');
                        }

                        // Update the Title
                        $("#service_" + data.id + " .service .serviceName").text($("#editServiceName").text());
                        if (data.map_area_data != '') {
                            $('#service_' + data.id).find('.map_data_icon').attr('title', data.map_area_data);
                            $('#service_' + data.id).find('.map_data_icon').attr('data-title', data.map_area_data);
                            $('#service_' + data.id).find('.map_data_icon').show();
                            initTiptip();
                        } else {
                            $('#service_' + data.id).find('.map_data_icon').hide();
                        }

                        $("#editService").dialog('close');
                        $('#editServiceSave span').text('Save');
                        $('#editServiceSave').prop('disabled', false);
                        updateLegends();

                        swal(
                            'Saved',
                            'Service Edited'
                        );
                    }

                })
                .fail(function (xhr) {
                    swal(
                        'Error',
                        'There was an error saving the information: Error Information: ' + xhr.responseText
                    );
                });
        }

        $(".editSealcoatingService").live('click', function () {
            editService(1);
        });
        var edit_msg = '<div id="show_edit_alert" style="float: left;width: 100%;color: red;padding-left: 20px;margin-top: -28px;"><i class="fa fa-fw fa-exclamation-circle" style="margin-right: 5px;"></i>This service has estimated items that may be updated by changing the specification</div>';

        $("#editService").dialog({
            autoOpen: false,
            modal: true,
            width: 966,
            dialogClass: "myDialog",
            draggable: false,
            resizable: false,
            buttons: {
                'Save': {
                    id: 'editServiceSave',
                    class: 'editServiceSaveBtn update-button saveIcon',
                    text: 'Save',
                    click: function () {
                        //tinymce.remove();

                        if (tinymce.activeEditor) {
                            $("#textEditorOpen").dialog('open');
                            return false;
                        } else {
                            $('#editServiceSave span').text('Saving...');
                            $('#editServiceSave').prop('disabled', true);
                            editService(0);
                        }
                    }
                },
                Cancel: {
                    class: 'closeIcon',
                    text: 'Cancel',
                    click: function () {
                        $(this).dialog('close');
                    }
                }
            },
            create: function () {
                $(".myDialog").append(edit_msg);
            }
        });
        $(document).on("click", "#proposal_services .btn-edit", function () {
            var serviceId = $(this).data('id');
            var companyId = '<?php echo $proposal->getOwner()->getCompanyId(); ?>';
            var proposalId = '<?php echo $proposal->getProposalId(); ?>';
            $(this).trigger('mouseout');


            $('.btn-edit').tipTip('destroy');
            $('#show_edit_alert').hide();
            $.getJSON('<?php echo site_url('ajax/getProposalServiceDetails') ?>/' + $(this).attr('rel'), function (data) {

                if (data.error == 1) {
                    $("#badService2").dialog('open');

                } else {
                    //init popup
                    $("#editServiceName").html('');
                    $("#editServiceTexts").html('');
                    $("#editServiceFields").html('');
                    $("#editServiceId").val(data.serviceId);
                    //populate popup
                    $("#editServiceName").html(data.serviceName);
                    //add the texts
                    for (i in data.texts) {
                        $("#editServiceTexts").append('<div class="text clearfix"><span class="handle ui-icon ui-icon-arrowthick-2-n-s"></span><span class="theText" data-val="' + data.text_ids[i] + '" contenteditablez="true">' + data.texts[i] + '</span><span class="remove"><a href="#" class="remove tiptip" title="Remove Line (Irreversible!)">Remove</a></span></div>');
                    }
                    //add the fields
                    for (i in data.fields) {
                        $("#editServiceFields").append(data.fields[i]);
                    }
                    $("#serviceImages").html('');
                    $('.service_image_count').html(data.serviceImageIds.length);

                    for (i in data.serviceImageIds) {

                        var imageId = data.serviceImageIds[i];
                        var imagePath = data.serviceImagePaths[i];
                        var imageTitle = data.serviceImageTitles[i];
                        var imageNote = data.serviceImageNotes[i];
                        var imageActive = (data.serviceImageActives[i]) ? 'checked="checked"' : '';
                        var imageActiveWO = (data.serviceImageWos[i]) ? 'checked="checked"' : '';
                        var newContent = '' +

                            '<div data-image-id="' + imageId + '" id="image_' + imageId + '" class="image_div" style="width: 460px;">' +
                            '<h3>' +
                            '<a href="javascript:void(0)"><span id="title_' + imageId + '">' + imageTitle + '</span></a>' +
                            '</h3>' +
                            '<form class="big update-title-form form-validated imgForm" style="padding: 2px 5px !important;">' +
                            '<div class="clearfix">' +
                            '<div style="width: 153px; float: left">' +
                            '<a href="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + imagePath + '?' + Math.random() +
                            '" class="fancybox">' +
                            '<img id="img_' + imageId + '" style="height: auto; width: 150px;" ' +
                            'src="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + imagePath + '?' + Math.random() +
                            '" alt="" title="Click to enlarge" class="tiptip"></a>' +
                            '</div>' +
                            '<div style="width: 160px; float: left">' +
                            '<p class="clearfix" style="margin-top: 10px;">' +
                            '<label style="width: 40px; margin: 0 5px 0 0; line-height: 20px;">Title</label>' +
                            '<input type="text" name="title" class="required" id="title2_' + imageId + '" ' +
                            'value="' + imageTitle + '" style="width: 122px;">' +
                            '<textarea style="display:none" id="service_image_note_'+imageId+'" class="service_image_note">'+imageNote+'</textarea>'+
                            '</p>' +
                            '<p class="clearfix" style="margin-top:5px;">' +
                            '<input type="checkbox" name="active" id="active_' + imageId + '"  ' + imageActive + '>' +
                            '<label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;vertical-align: text-bottom;"' +
                            'for="active_' + imageId + '">Proposal</label>' +
                            '<span class="clearfix"></span>' +
                            '<input type="checkbox" name="active"' +
                            'id="activewo_' + imageId + '" ' + imageActiveWO + '>' +
                            '<label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;vertical-align: text-bottom;"' +
                            'for="activewo_' + imageId + '">Work Order</label>' +
                            '<div class="clearfix"></div>' +


                            '</p>' +
                            '<p id="updating_' + imageId + '" class="imageUpdating"></p>' +
                            '</div>' +
                            '<div class="clearfix"></div>' +
                            '<div class="clearfix" style="padding: 10px 0 0;">' +
                            '<div style="width: 148px; float: left; text-align: center;">' +
                            '<a style="float: left; margin-left: 45px; font-size: 26px; color: #000;"' +
                            'class="rotateImage rotateLeft tiptip"' +
                            'rel="' + imageId + '" title="Rotate Left" href="#">' +
                            '<i class="fa fa-fw fa-rotate-left"></i>' +
                            '</a>' +
                            '<a style="float: left; font-size: 26px; color: #000;" class="rotateImage rotateRight tiptip"' +
                            'rel="' + imageId + '" title="Rotate Right" href="#">' +
                            '<i class="fa fa-fw fa-rotate-right"></i>' +
                            '</a>' +
                            '</div>' +
                            '<div style="width: 300px; float: left" class="clearfix">' +
                            '<p class="clearfix" style="text-align:center">' +
                            '<a href="#" class="tiptip btn delete-image-button deleteIcon" ' +
                            'data-image-id="' + imageId + '" title="Delete" data-delete-id="' + imageId + '" style="margin-right: 7px; margin-left: 0px;"> Delete Image' +
                            '</a>' +
                            '<a class="btn image-notes notesIcon tiptip" type="button" title="Notes" id="notes-' + imageId + '" style="margin-right: 7px;"> Notes</a>' +
                            '<a href="#" class="tiptip btn image-editor-btn editIcon" ' +
                            'data-imageid="' + imageId + '" data-imagename="'+imagePath+'" data-imageurl="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + imagePath + '" title="Edit Image" id="image-crop-' + imageId + '" data-delete-id="' + imageId + '" style="margin-right: 8px;"> Edit Image' +
                            '</a>' +
                            '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</form></div>';

                        $("#serviceImages").append(newContent);


                    }

                    $("#serviceMapImages").html('');
                    
                    $('.service_image_count').html(data.serviceMapImageIds.length);
                    for (i in data.serviceMapImageIds) {

                        var imageId = data.serviceMapImageIds[i];
                        var imagePath = data.serviceMapImagePaths[i];
                        var imageTitle = data.serviceMapImageTitles[i];
                        var imageNote = data.serviceMapImageNotes[i];
                        var imageActive = (data.serviceMapImageActives[i]) ? 'checked="checked"' : '';
                        var imageActiveWO = (data.serviceMapImageWos[i]) ? 'checked="checked"' : '';
                        var newContent = '' +

                            '<div data-image-id="' + imageId + '" id="image_' + imageId + '" class="image_div" style="width: 460px;">' +
                            '<h3>' +
                            '<a href="javascript:void(0)"><span id="title_' + imageId + '">' + imageTitle + '</span></a>' +
                            '</h3>' +
                            '<form class="big update-title-form form-validated imgForm" style="padding: 2px 5px !important;">' +
                            '<div class="clearfix">' +
                            '<div style="width: 153px; float: left">' +
                            '<a href="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + imagePath + '?' + Math.random() +
                            '" class="fancybox">' +
                            '<img id="img_' + imageId + '" style="height: auto; width: 150px;" ' +
                            'src="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + imagePath + '?' + Math.random() +
                            '" alt="" title="Click to enlarge" class="tiptip"></a>' +
                            '</div>' +
                            '<div style="width: 160px; float: left">' +
                            '<p class="clearfix" style="margin-top: 10px;">' +
                            '<label style="width: 40px; margin: 0 5px 0 0; line-height: 20px;">Title</label>' +
                            '<input type="text" name="title" class="required" id="title2_' + imageId + '" ' +
                            'value="' + imageTitle + '" style="width: 122px;">' +
                            '<textarea style="display:none" id="service_image_note_'+imageId+'" class="service_map_image_note">'+imageNote+'</textarea>'+
                            '</p>' +
                            '<p class="clearfix" style="margin-top:5px;">' +
                            '<input type="checkbox" name="active" id="active_' + imageId + '"  ' + imageActive + '>' +
                            '<label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;vertical-align: text-bottom;"' +
                            'for="active_' + imageId + '">Proposal</label>' +
                            '<span class="clearfix"></span>' +
                            '<input type="checkbox" name="active"' +
                            'id="activewo_' + imageId + '" ' + imageActiveWO + '>' +
                            '<label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;vertical-align: text-bottom;"' +
                            'for="activewo_' + imageId + '">Work Order</label>' +
                            '<div class="clearfix"></div>' +


                            '</p>' +
                            '<p id="updating_' + imageId + '" class="imageUpdating"></p>' +
                            '</div>' +
                            '<div class="clearfix"></div>' +
                            '<div class="clearfix" style="padding: 10px 0 0;">' +
                            '<div style="width: 148px; float: left; text-align: center;">' +
                            '<a style="float: left; margin-left: 45px; font-size: 26px; color: #000;"' +
                            'class="rotateImage rotateLeft tiptip"' +
                            'rel="' + imageId + '" title="Rotate Left" href="#">' +
                            '<i class="fa fa-fw fa-rotate-left"></i>' +
                            '</a>' +
                            '<a style="float: left; font-size: 26px; color: #000;" class="rotateImage rotateRight tiptip"' +
                            'rel="' + imageId + '" title="Rotate Right" href="#">' +
                            '<i class="fa fa-fw fa-rotate-right"></i>' +
                            '</a>' +
                            '</div>' +
                            '<div style="width: 300px; float: left" class="clearfix">' +
                            '<p class="clearfix" style="text-align:center">' +
                            '<a href="#" class="tiptip btn move-image-button " ' +
                            'data-image-id="' + imageId + '" data-service-id="'+serviceId+'" title="Move"  style="margin-right: 8px; margin-left: 0px;">Move to Maps' +
                            '</a>' +
                            '<a href="#" class="tiptip btn delete-image-button deleteIcon" ' +
                            'data-image-id="' + imageId + '" data-service-id="'+serviceId+'" title="Delete" data-delete-id="' + imageId + '" style="margin-right: 8px; margin-left: 0px;">' +
                            '</a>' +
                            '<a class="btn image-notes notesIcon tiptip" type="button" title="Notes" id="notes-' + imageId + '" style="margin-right: 8px;"></a>' +
                            '<a href="#" class="tiptip btn image-editor-btn editIcon" ' +
                            'data-imageid="' + imageId + '" data-imagename="'+imagePath+'" data-imageurl="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + imagePath + '" title="Edit Image" id="image-crop-' + imageId + '" data-delete-id="' + imageId + '" style="margin-right: 8px;">' +
                            '</a>' +
                            '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</form>';

                        $("#serviceMapImages").append(newContent);


                    }
                    $('.proposal_sevice_image_notes_div').hide();
                    $('.proposal_sevice_map_image_notes_div').hide();
                    if (data.serviceImageIds.length == 0) {
                        $("#serviceImages").html('<p style="margin-top: 27px;position: absolute;right: 22%;font-size: 15px;">No Images</p>')
                        
                    }
                    if (data.serviceMapImageIds.length == 0) {
                        
                        $("#serviceMapImages").html('<p style="margin-top: 27px;position: absolute;right: 22%;font-size: 15px;">No Images</p>')
                        
                    }else{
                            //Map Image check
                            var numImages = $("#proposalMapImages > div.map_image_div").length;
                           // Do the upload limit check
                            var mapImageUploadLimit = <?php echo MAP_IMAGE_UPLOAD_LIMIT; ?>;
                            if (numImages < mapImageUploadLimit) {
                                $("#serviceMapImages").find('.move-image-button').show();
                            } else {
                                $("#serviceMapImages").find('.move-image-button').hide();
                            }

                        var service_image_note = $("#serviceMapImages").find('.service_map_image_note');
                        $('.proposal_sevice_map_image_notes_div').show();
                                    console.log($(service_image_note).val());
                        if($(service_image_note).val()){
                            $('.proposal_sevice_map_image_notes').html($(service_image_note).val());
                        }else{
                            $('.proposal_sevice_map_image_notes').html('This image has no notes');
                        }
                    }
                    $("#serviceImages").sortable('refresh');
                    $("#serviceMapImages").sortable('refresh');
                    
                    $("#serviceImages").accordion('destroy').accordion({
                        collapsible: true,
                        active: false,
                        autoHeight: false,
                        navigation: true,
                        header: "> div > h3",
                        

                            beforeActivate: function( event, ui ) {
                                if (ui.newHeader[0]) {
                                    $('.proposal_sevice_image_notes_div').show();
                                    var service_image_note = $(ui.newPanel).find('.service_image_note');
                                    if($(service_image_note).val()){
                                        $('.proposal_sevice_image_notes').html($(service_image_note).val());
                                    }else{
                                        $('.proposal_sevice_image_notes').html('This image has no notes');
                                    }
                                    
                                }else{
                                     $('.proposal_sevice_image_notes_div').hide();
                                }
                                
                                    
                                
                                
                            }
                    });

                    $("#serviceMapImages").accordion('destroy').accordion({
                        collapsible: true,
                        active: 0,
                        autoHeight: false,
                        navigation: true,
                        header: "> div > h3",
                        

                            beforeActivate: function( event, ui ) {
                                if (ui.newHeader[0]) {
                                    $('.proposal_sevice_map_image_notes_div').show();
                                    var service_image_note = $(ui.newPanel).find('.service_map_image_note');
                                    console.log(service_image_note);
                                    if($(service_image_note).val()){
                                        $('.proposal_sevice_map_image_notes').html($(service_image_note).val());
                                    }else{
                                        $('.proposal_sevice_map_image_notes').html('This image has no notes');
                                    }
                                    
                                }else{
                                     $('.proposal_sevice_map_image_notes_div').hide();
                                }

                            }
                    });
                    if (data.estimateItemCount > 0) {
                        $("#editPrice").attr('readonly', 'readonly');
                        $("#editPrice").addClass('hide_input_style2');
                        show_edit_flag = true;
                    } else {
                        $("#editPrice").removeAttr('readonly');
                        $("#editPrice").removeClass('hide_input_style2');
                        show_edit_flag = false;

                    }
                    $("#edit_service_tabs").tabs({active: 0});
                    if (addServiceAndUploadImage) {
                        swal.close()
                        $("#addService").dialog('close');
                        $( "#edit_service_tabs" ).tabs({ active: 1 });
                        addServiceAndUploadImage = false;
                    } else {
                        //$( "#edit_service_tabs" ).tabs({ active: 0 });

                    }

                    $("#editServiceAddField").val('');
                    $("#editService").dialog('open');
                    $("#editServiceTexts").sortable('refresh');
                    updatePricingUI();
                    initButtons();
                    initTiptip();
                    reset_service_uploader();
                    reset_map_service_uploader();
                    tinymce.remove();


                }
            });
            $('#measurement_of_total_area').val('ttt');
            return false;
        });
        $(".editServiceAddText").click(function () {
            if (tinymce.activeEditor) {
                $("#textEditorOpen").dialog('open');
                return false;
            }
            $(".text").removeClass('newText');

            $("#editServiceTexts").append('<div class="text newText clearfix"><span class="handle ui-icon ui-icon-arrowthick-2-n-s"></span><span class="theText" contenteditablez="true">' + $("#editServiceAddField").val() + '</span><span class="remove"><a href="#" class="remove tiptip" title="Remove Line (Irreversible!)">Remove</a></span></div>');
            $("#editServiceAddField").val('');
            $("#editServiceTexts").sortable('refresh');

            var newItem = $(".newText").find('.theText').last();
            //newItem.click();
            setTimeout(function () {
                newItem.dblclick();
                var objDiv = $("#editServiceTexts");
                if (objDiv.length > 0){
                    objDiv[0].scrollTop = objDiv[0].scrollHeight;
                }
            }, 500);

            return false;
        });

        // Uncheck optional service if no price  - add dialog
        $("#no_price").live('change', function () {
            if ($(this).is(':checked')) {
                $("#addPrice").val('$0');
                $("#optional").attr('checked', false);
            }
        });

        // Uncheck no price if options checked - add dialog
        $("#optional").live('change', function () {
            if ($(this).is(':checked')) {
                $("#no_price").attr('checked', false);
            }
        });

        // Uncheck optional service if no price  - edit dialog
        $("#edit_no_price").live('change', function () {
            if ($(this).is(':checked')) {
                $("#editPrice").val('$0');
                $("#editOptional").attr('checked', false);
            }
        });

        // Uncheck no price if options checked - add dialog
        $("#editOptional").live('change', function () {
            if ($(this).is(':checked')) {
                $("#edit_no_price").attr('checked', false);
            }
        });

        //@TODO - once we enable other layouts... redo here
        $("#preview-frame-cached").load(function () {
            $("#loading_preview2").hide();
            $("#preview-frame-cached").removeClass('dis-none').fadeIn();
        });

        //this will go once caching is complete!
        function loading() {
            $("#preview-frame").load(function () {
                $("#loading_preview").hide();
                $("#preview-frame").removeClass('dis-none').fadeIn();
            });
        }

        loading();
        $('.prv').click(function () {
            $("#loading_preview").show();
            loading();
        });
        $(".dataTables_wrapper .fg-toolbar").hide();

        //ckeditor
        if ($("#message").length) {
            var template_editor = CKEDITOR.replace('message', {
                height: 200
            });

        }

        //add tag
        $("#addAtCursor").click(function () {
            CKEDITOR.instances.message.insertText($("#field").val());
        });

        //Add external link to the proposal
        $("#addLinkForm").on('submit', function () {
            if ($("#name").val().length == 0 || $("#url").val().length == 0) {
                alert("Name and URL are required!");
                return false;
            }
        });
        //delete proposal link code
        $(document).on('click', '.deleteLink', function () {
            $("#confirmLinkDelete").data('link-id', $(this).data('id'));
            $("#confirmLinkDelete").dialog('open');
            return false;
        });
        $(document).on('click', '.editLink', function () {
            var id = $(this).data('id');
            $("#proposal-link-" + id).hide();
            $("#editLink-" + id).hide();
            $("#edit-form-" + id).show();
            $("#cancelEditLink-" + id).show();
            return false;
        });
        $(document).on('click', '.cancelEditLink', function () {
            var id = $(this).data('id');
            $("#proposal-link-" + id).show();
            $("#editLink-" + id).show();
            $("#edit-form-" + id).hide();
            $("#cancelEditLink-" + id).hide();
            return false;
        });
        $(document).on('submit', '.editLinkForm', function () {
            var id = $(this).data('id');
            var name = $(this).find(".name").val();
            var url = $(this).find(".url").val();
            if (name.length == 0 || url.length == 0) {
                alert("Name and URL are required!");
                return false;
            }
            var proposal_id = "<?php echo $this->uri->segment(3); ?>";
            $.post('<?php echo site_url('account/updateLinkDetails') ?>', {
                id: id,
                name: name,
                url: url,
                proposal_id:proposal_id
            }, function (data) {
                if (1) {
                    $("#proposal-link-" + id).attr("href", url);
                    $("#proposal-link-" + id).text(name);
                    $("#proposal-link-" + id).show();
                    $("#editLink-" + id).show();
                    $("#edit-form-" + id).hide();
                    $("#cancelEditLink-" + id).hide();
                } else {
                    alert('There was a problem saving the link!');
                }
            });
            return false;
        });
        //tinymce
        //inputs and accordions
        var priceFormat = 'input[name="price"]';
        $(priceFormat).each(function () {
            $(this).formatCurrency({
                colorize: true,
                negativeFormat: '-%s%n',
                roundToDecimalPlace: -1,
                eventOnDecimalsEntered: true
            });
        });
        $(priceFormat).keyup(function () {
            $(this).formatCurrency({
                colorize: true,
                negativeFormat: '-%s%n',
                roundToDecimalPlace: -1,
                eventOnDecimalsEntered: true
            });
        });
        var numberFormat = 'input[name="measurement"],input[name="linelength"],input[name="curblength"],input[name="depth"],input[name="length"],input[name="height"],input[name="handicappedspaces"],input[name="spaces"],input[name="arrownumber"], #sealcoatArea';
        $(numberFormat).each(function () {
            $(this).formatCurrency({
                colorize: true,
                negativeFormat: '-%s%n',
                roundToDecimalPlace: -1,
                eventOnDecimalsEntered: true,
                symbol: ''
            });
        });
        $(numberFormat).keyup(function () {
            $(this).formatCurrency({
                colorize: true,
                negativeFormat: '-%s%n',
                roundToDecimalPlace: -1,
                eventOnDecimalsEntered: true,
                symbol: ''
            });
        });
        $("#p_actions").buttonset();
        $("#accordion").accordion({
            collapsible: true,
            active: false,
            autoHeight: false,
            navigation: true
        });
        var stop = false;
        $("#accordion2 h3, #accordion3 h3, #accordion_texts h3, #accordion4 h3").click(function (event) {
            if (stop) {
                event.stopImmediatePropagation();
                event.preventDefault();
                stop = false;
            }
        });

        function updatetextcatsindb() {
            var postData = $("#accordion_texts").sortable("serialize");
            $(".categoryInclude").each(function () {
                var enabled = 0;
                if ($(this).attr('checked')) {
                    enabled = 1;
                }
                var id = $(this).attr('id');
                id = id.replace('textcat-', '');
                postData = postData + '&category_checked[' + id + ']=' + enabled;
            });
            postData = postData + '&proposal=<?php echo $proposal->getProposalId() ?>';
            //            alert(postData);
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('ajax/updateProposalTextCategories') ?>",
                data: postData,
                async: false
            });
            // Update the icons
            checkCustomTextHeadings();
        }

        $(".categoryInclude").change(function () {
            updatetextcatsindb();
        });
        $("#accordion_texts").accordion({
            collapsible: true,
            active: false,
            autoHeight: false,
            navigation: true,
            header: "> div > h3"
        }).sortable({
            axis: "y",
            handle: "h3",
            stop: function () {
                stop = true;
                updatetextcatsindb();
            }
        });
        $("#accordion2").accordion({
            collapsible: true,
            active: false,
            autoHeight: false,
            navigation: true,
            header: "> div > h3"
        })
            .sortable({
                axis: "y",
                handle: "h3",
                stop: function () {
                    stop = true;
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('ajax/sort_proposals') ?>",
                        data: $("#accordion2").sortable("serialize")
                    });
                }
            });
        $("#accordion3").accordion({
            collapsible: true,
            active: false,
            autoHeight: false,
            navigation: true,
            header: "> div > h3"
        }).sortable({
                axis: "y",
                handle: "h3",
                stop: function () {
                    stop = true;
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('ajax/sort_proposalImages') ?>",
                        data: $("#accordion3").sortable("serialize"),
                        success: function (data) {
                            //                                alert(data);
                        }
                    });
                }
            });

        
        $("#proposalMapImages").accordion({
            collapsible: true,
            active: false,
            autoHeight: false,
            navigation: true,
            header: "> div > h3"
        }).sortable({
                axis: "y",
                handle: "h3",
                stop: function () {
                    stop = true;
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('ajax/sort_proposalImages') ?>",
                        data: $("#proposalMapImages").sortable("serialize"),
                        success: function (data) {
                            //                                alert(data);
                        }
                    });
                }
            });

        $("#serviceImages").accordion({
            collapsible: true,
            active: false,
            autoHeight: false,
            navigation: true,
            header: "> div > h3",
            activate : function (event, ui) {
                                console.log('activate')
                                

                            },

                            beforeActivate: function( event, ui ) {
                            
                                console.log('beforeActivate')
                            }
        }).sortable({
                axis: "y",
                handle: "h3",
                stop: function () {
                    stop = true;
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('ajax/sort_proposalServiceImages') ?>",
                        data: $("#serviceImages").sortable("serialize"),
                        success: function (data) {
                            //                                alert(data);
                        }
                    });
                }
            });

            $("#serviceMapImages").accordion({
            collapsible: true,
            active: 0,
            autoHeight: false,
            navigation: true,
            header: "> div > h3",
            activate : function (event, ui) {
                                console.log('activate')
                                

                            },

                            beforeActivate: function( event, ui ) {
                            
                                if (ui.newHeader[0]) {
                                    $('.proposal_sevice_map_image_notes_div').show();
                                    var service_map_image_note = $(ui.newPanel).find('.service_map_image_note');
                                    if($(service_map_image_note).val()){
                                        $('.proposal_sevice_map_image_notes').html($(service_map_image_note).val());
                                    }else{
                                        $('.proposal_sevice_map_image_notes').html('This image has no notes');
                                    }
                                    
                                }else{
                                     $('.proposal_sevice_map_image_notes_div').hide();
                                }
                            }
        }).sortable({
                axis: "y",
                handle: "h3",
                stop: function () {
                    stop = true;
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('ajax/sort_proposalServiceImages') ?>",
                        data: $("#serviceMapImages").sortable("serialize"),
                        success: function (data) {
                            //                                alert(data);
                        }
                    });
                }
            });


        $("#accordion4").accordion({
            collapsible: true,
            active: false,
            autoHeight: false,
            navigation: true,
            header: "> div > h3"
        })
            .sortable({
                axis: "y",
                handle: "h3",
                stop: function () {
                    stop = true;
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('ajax/sort_proposalAttachments') ?>",
                        data: $("#accordion4").sortable("serialize"),
                        success: function (data) {
                            //                                alert(data);
                        }
                    });
                }
            });

        $("#accordion5").accordion({
            collapsible: true,
            active: false,
            autoHeight: false,
            navigation: true,
            header: "> div > h3",
            beforeActivate: function( event, ui ) {
                console.log(videoSettingsChanged);
                console.log('checked');
                            
                if (videoSettingsChanged) {
                    
                    swal(
                        'Unsaved Changes',
                        'You still have unchanged <strong>Video Settings</strong>'
                    );
                    return false;
                }
            }
        })
            .sortable({
                axis: "y",
                handle: "h3",
                stop: function () {
                    stop = true;
                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('ajax/sort_proposalVideos') ?>",
                        data: $("#accordion5").sortable("serialize"),
                        success: function (data) {
                            //                                alert(data);
                        }
                    });
                }
            });
        $('#accordion, #accordion2').bind('accordionchange', function (event, ui) {
            $.scrollTo(ui.newHeader); // or ui.newContent, if you prefer
        });

        $('.required').each(function (index) {
            $("form.big").each(function () {
                $(this).validate({
                    messages: {
                        required: 'Required'
                    }
                });
            });
        });
        var tabindex = 1;
        $('input,select,textarea').each(function () {
            if (this.type != "hidden") {
                var $input = $(this);
                $input.attr("tabindex", tabindex);
                tabindex++;
            }
        });
        $('.attatchment input').change(function () {
            var checked = false;
            if ($(this).attr('checked') == 'checked') {
                checked = true;
            }
            var url = '';
            var id = $(this).attr('id').split('_')[1];
            if (checked) {
                url = '<?php echo site_url('proposals/edit/' . $this->uri->segment(3) . '/addAttatchment') ?>/' + id;
            } else {
                url = '<?php echo site_url('proposals/edit/' . $this->uri->segment(3) . '/removeAttatchment') ?>/' + id;
            }
            $.get(url);

            var checkboxes = $('.attatchment input:checkbox:checked').length;
            if(checkboxes>0){
                $('.individual_proposal_section_table').find('tr[data-section-code="attachments"]').show();
            }else{
                $('.individual_proposal_section_table').find('tr[data-section-code="attachments"]').hide();
            }
        });


        // Tmeplate change handler
        $('#templateSelect').change(function () {
            loadTemplateContents();
        });

        function loadTemplateContents(templateId) {

            var selectedTemplate = $('#templateSelect option:selected').data('template-id');

            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: {
                    'templateId': selectedTemplate,
                    'proposalId': <?php echo $this->uri->segment(3); ?>
                },
                url: "<?php echo site_url('account/ajaxGetProposalTemplateParsed') ?>?" + Math.floor((Math.random() * 100000) + 1),
                dataType: "JSON"
            }).success(function (data) {
                $("#subject").val(data.templateSubject);
                CKEDITOR.instances.message.setData(data.templateBody);
            });

            $.uniform.update();
        }

        <?php if (!new_system($proposal->getCreated(false))) { ?>
        /******************************
         *  Sealcoat Calculator code  *
         ******************************/
        function getSealcoatCalculatorFields() {
            var formFields = {
                sealcoatSpotPrimerCost: $('#sealcoatSpotPrimerCost').val(),
                sealcoatSpotPrimerGal: $('#sealcoatSpotPrimerGal').val(),
                sealcoatCoats: $('#sealcoatCoats').val(),
                sealcoatArea: $('#sealcoatArea').val(),
                sealcoatUnit: $('#sealcoatUnit').val(),
                sealcoatApplicationRate: $('#sealcoatApplicationRate').val(),
                sealcoatWater: $('#sealcoatWater').val(),
                sealcoatAdditive: $('#sealcoatAdditive').val(),
                sealcoatSand: $('#sealcoatSand').val(),
                sealcoatSealerCost: $('#sealcoatSealerCost').val(),
                sealcoatSandCost: $('#sealcoatSandCost').val(),
                sealcoatAdditiveCost: $('#sealcoatAdditiveCost').val(),
                sealcoatHourlyCost: $('#sealcoatHourlyCost').val(),
                sealcoatTrips: $('#sealcoatTrips').val(),
                sealcoatMen: $('#sealcoatMen').val(),
                sealcoatTripHours: $('#sealcoatTripHours').val(),
                sealcoatOverhead: $('#sealcoatOverhead').val(),
                sealcoatProffit: $('#sealcoatProffit').val()
            };
            return formFields;
        }

        $.printCalc = function (settings) {
            //do some checks
            if (typeof (settings.title) == 'undefined') {
                settings.title = 'No Title';
            }
            if (typeof (settings.project_name) == 'undefined') {
                settings.project_name = 'No Project Name';
            }
            //do post
            var request = $.ajax({
                url: "/calculators.print.php",
                type: "POST",
                dataType: "html",
                data: settings,
                success: function (data) {
                    //new Window
                    printWindow = window.open("/calculators.print.php", '_blank', 'width=800,height=500,scrollbars=1');
                    printWindow.document.write(data);
                    printWindow.print();
                }
            });
        };
        <?php
        $sealerCost = 0;
        $sandCost = 0;
        $additiveCost = 0;
        $hourlyCost = 0;
        $spotCost = 0;
        //Get the dynamic values
        $sc = $this->em->createQuery('SELECT c FROM models\Calculators_values c where (c.company=' . $account->getCompany()->getCompanyId() . ') and (c.fieldName=\'sealcoatSealerCost\') order by c.fieldId desc')->setMaxResults(1)->getResult();
        if (count($sc)) {
            $s = $sc[0];
            $sealerCost = $s->getFieldValue();
        }
        $sc = $this->em->createQuery('SELECT c FROM models\Calculators_values c where (c.company=' . $account->getCompany()->getCompanyId() . ') and (c.fieldName=\'sealcoatSandCost\') order by c.fieldId desc')->setMaxResults(1)->getResult();
        if (count($sc)) {
            $s = $sc[0];
            $sandCost = $s->getFieldValue();
        }
        $sc = $this->em->createQuery('SELECT c FROM models\Calculators_values c where (c.company=' . $account->getCompany()->getCompanyId() . ') and (c.fieldName=\'sealcoatAdditiveCost\') order by c.fieldId desc')->setMaxResults(1)->getResult();
        if (count($sc)) {
            $s = $sc[0];
            $additiveCost = $s->getFieldValue();
        }
        $sc = $this->em->createQuery('SELECT c FROM models\Calculators_values c where (c.company=' . $account->getCompany()->getCompanyId() . ') and (c.fieldName=\'sealcoatHourlyCost\') order by c.fieldId desc')->setMaxResults(1)->getResult();
        if (count($sc)) {
            $s = $sc[0];
            $hourlyCost = $s->getFieldValue();
        }
        $sc = $this->em->createQuery('SELECT c FROM models\Calculators_values c where (c.company=' . $account->getCompany()->getCompanyId() . ') and (c.fieldName=\'sealcoatSpotPrimerCost\') order by c.fieldId desc')->setMaxResults(1)->getResult();
        if (count($sc)) {
            $s = $sc[0];
            $spotCost = $s->getFieldValue();
        }
        ?>
        var sealcoatDefaultFields = {
            sealcoatCoats: 1,
            sealcoatArea: 0,
            sealcoatUnit: 'Sq. Ft',
            sealcoatApplicationRate: 0.013,
            sealcoatWater: 0,
            sealcoatAdditive: 0,
            sealcoatSand: 0,
            sealcoatSealerCost: <?php echo $sealerCost ?>,
            sealcoatSandCost: <?php echo $sandCost ?>,
            sealcoatAdditiveCost: <?php echo $additiveCost ?>,
            sealcoatHourlyCost: <?php echo $hourlyCost ?>,
            sealcoatTrips: 1,
            sealcoatMen: 0,
            sealcoatTripHours: 0,
            sealcoatProffit: 0,
            sealcoatOverhead: 0,
            sealcoatSpotPrimerCost: <?php echo $spotCost ?>,
            sealcoatSpotPrimerGal: 0
        };
        var sealcoat_fields = [];
        sealcoat_fields[0] = sealcoatDefaultFields;
        <?php
        //for each proposal items need to set array indexes of the values already in the database, to populate and update the values
        foreach ($proposalItems as $proposalItem) {
        if ($proposalItem->getItem()->getItemId() == '1') {
        $dbFields = array();
        $itemFields = $this->em->createQuery("select c from models\Calculators_values c where c.itemId = " . $proposalItem->getLinkId())->getResult();
        foreach ($itemFields as $if) {
            $dbFields[$if->getFieldName()] = $if->getFieldValue();
        }
        ?>
        sealcoat_fields['PIF_<?php echo $proposalItem->getLinkId() ?>'] = {
            sealcoatSpotPrimerCost: <?php echo isset($dbFields['sealcoatSpotPrimerCost']) ? $dbFields['sealcoatSpotPrimerCost'] : $spotCost ?>,
            sealcoatSpotPrimerGal: <?php echo isset($dbFields['sealcoatSpotPrimerGal']) ? $dbFields['sealcoatSpotPrimerGal'] : '0' ?>,
            sealcoatCoats: <?php echo isset($dbFields['sealcoatCoats']) ? $dbFields['sealcoatCoats'] : '1' ?>,
            sealcoatArea: '<?php echo isset($dbFields['sealcoatArea']) ? $dbFields['sealcoatArea'] : '0' ?>',
            sealcoatUnit: '<?php echo isset($dbFields['sealcoatUnit']) ? $dbFields['sealcoatUnit'] : 'Sq. Ft' ?>',
            sealcoatApplicationRate: <?php echo isset($dbFields['sealcoatApplicationRate']) ? $dbFields['sealcoatApplicationRate'] : '0.013' ?>,
            sealcoatWater: <?php echo isset($dbFields['sealcoatWater']) ? $dbFields['sealcoatWater'] : '0' ?>,
            sealcoatAdditive: <?php echo isset($dbFields['sealcoatAdditive']) ? $dbFields['sealcoatAdditive'] : '0' ?>,
            sealcoatSand: <?php echo isset($dbFields['sealcoatSand']) ? $dbFields['sealcoatSand'] : '0' ?>,
            sealcoatSealerCost: <?php echo isset($dbFields['sealcoatSealerCost']) ? $dbFields['sealcoatSealerCost'] : $sealerCost ?>,
            sealcoatSandCost: <?php echo isset($dbFields['sealcoatSandCost']) ? $dbFields['sealcoatSandCost'] : $sandCost ?>,
            sealcoatAdditiveCost: <?php echo isset($dbFields['sealcoatAdditiveCost']) ? $dbFields['sealcoatAdditiveCost'] : $additiveCost ?>,
            sealcoatHourlyCost: <?php echo isset($dbFields['sealcoatHourlyCost']) ? $dbFields['sealcoatHourlyCost'] : $hourlyCost ?>,
            sealcoatTrips: <?php echo isset($dbFields['sealcoatTrips']) ? $dbFields['sealcoatTrips'] : '1' ?>,
            sealcoatMen: <?php echo isset($dbFields['sealcoatMen']) ? $dbFields['sealcoatMen'] : '0' ?>,
            sealcoatTripHours: <?php echo isset($dbFields['sealcoatTripHours']) ? $dbFields['sealcoatTripHours'] : '0' ?>,
            sealcoatOverhead: <?php echo isset($dbFields['sealcoatOverhead']) ? $dbFields['sealcoatOverhead'] : '0' ?>,
            sealcoatProffit: <?php echo isset($dbFields['sealcoatProffit']) ? $dbFields['sealcoatProffit'] : '0' ?>
        };
        <?php
        }
        }
        ?>
        var sealcoatLeftFields = sealcoatDefaultFields;
        var sealcoatActiveForm;
        $("#accordion form.form-item-1, #accordion2 form.form-item-1").submit(function () {
            sealcoatActiveForm = $(this);
            var token = Math.floor((Math.random() * 10) + 1);
            //post the seal coat calculator
            var postFields = getSealcoatCalculatorFields();
            sealcoatValuesId = sealcoatActiveForm.attr('id');
            if (!sealcoatValuesId) {
                sealcoatValuesId = 0;
            }
            postFields = sealcoat_fields[sealcoatValuesId];
            var url = '';
            if (sealcoatValuesId == 0) {
                url = "<?php echo site_url('ajax/addProposalCalculatorItems') ?>";
            } else {
                var itemId = sealcoatValuesId.replace(/PIF_/g, '');
                url = "<?php echo site_url('ajax/updateProposalCalculatorItems') ?>/" + itemId;
            }
            var request = $.ajax({
                url: url,
                type: "POST",
                async: false,
                data: postFields,
                dataType: "json",
                success: function (data) {
                    $(".calculatorRequestToken").val(data.token);
                    return true;
                },
                error: function () {
                    alert('An error has occurred. Please try again later.');
                }
            });
            return true;
        });

        function updateCalculatoFields(fields) {
            $.each(fields, function (index, value) {
                $("#" + index).val(value);
            });
        }

        //initialize the form on the left with the default values
        updateCalculatoFields(sealcoatDefaultFields);

        var sealcoatForm = $("#accordion .form-item-1");
        var sealcoatValuesId = '0';
        //to add - when implemented on right side, proper selection and action in the click event
        $(".launchSealcoatCalculator").click(function () {
            var type = $(this).attr('rel');
            sealcoatForm = $(this).parents('form');
            sealcoatValuesId = sealcoatForm.attr('id');
            if (!sealcoatValuesId) {
                sealcoatValuesId = 0;
            }
            //        alert('ID: ' + sealcoat_fields[sealcoatValuesId].sealcoatArea);
            updateCalculatoFields(sealcoat_fields[sealcoatValuesId]);
            sealcoatCalculator();
            $("#sealcoatCalculator").dialog('open');
        });
        $("#sealcoatCalculator").dialog({
            width: 850,
            height: 580,
            modal: true,
            create: function () {
                //            sealcoatCalculator();
            },
            buttons: {
                Apply: function () {
                    var measurement = 'Square Yards';
                    if ($("#sealcoatUnit").val() == 'ft') {
                        measurement = 'Square Feet';
                    }
                    sealcoatForm.find(".field-measurement input").val($("#sealcoatArea").val());
                    sealcoatForm.find(".field-unit select").val(measurement);
                    sealcoatForm.find(".field-coats select").val($("#sealcoatCoats").val());
                    sealcoatForm.find(".field-tripNumber select").val($("#sealcoatTrips").val());
                    sealcoatForm.find(".field-price input").val('$' + $("#sealcoatTotalCost").html());
                    $.uniform.update();
                    sealcoat_fields[sealcoatValuesId] = getSealcoatCalculatorFields();
                    $(this).dialog("close");
                },
                Print: function () {
                    /*Print code from neyra. Praise god if it works with no modifications*/
                    var settings = {
                        "title": "Sealcoating Job Cost Sheet",
                        "project_name": '<?php echo addslashes($proposal->getProjectName()) ?>',
                        "boxes": {
                            left: {
                                0: {
                                    "heading": "Material Costs",
                                    data: new Array(
                                        ['Sealer', '$' + $("#sealcoatSealerCost").val() + '/Gal'],
                                        ['Sand', '$' + $("#sealcoatSandCost").val() + '/100Lb'],
                                        ['Additive', '$' + $("#sealcoatAdditiveCost").val() + '/l'],
                                        ['Spot Primer', '$' + $("#sealcoatSpotPrimerCost").val() + '/l'],
                                        ['Labor Hourly Rate', '$' + $("#sealcoatHourlyCost").val(), '(incl. tax/ins)']
                                    )
                                },
                                1: {
                                    "heading": "Labor for Project",
                                    data: new Array(
                                        ['Trip Count', $("#sealcoatTrips").val()],
                                        ['Men #', $("#sealcoatMen").val()],
                                        ['Hours per Trip', $("#sealcoatTripHours").val()],
                                        ['Overhead', '$' + $("#sealcoatOverhead").val() + '/Trip'],
                                        ['Profit', '$' + $("#sealcoatProffit").val() + '/Trip']
                                    )
                                },
                                2: {
                                    "heading": "Project Costs",
                                    data: new Array(
                                        ['', 'Total Cost', 'Cost/Unit'],
                                        ['Sealer', '$' + $("#sealcoatTotalSealerValue").html(), '$' + $("#sealcoatTotalSealerValuePerArea").html()],
                                        ['Sand', '$' + $("#sealcoatTotalSandValue").html(), '$' + $("#sealcoatTotalSandValuePerArea").html()],
                                        ['Additive', '$' + $("#sealcoatTotalAdditiveValue").html(), '$' + $("#sealcoatTotalAdditiveValuePerArea").html()],
                                        ['Spot Primer', '$' + $("#sealcoatTotalSpotPrimerValue").html(), '$' + $("#sealcoatTotalSpotPrimerValuePerArea").html()],
                                        ['Total Material', '$' + $("#sealcoatMaterialCost").html(), '$' + $("#sealcoatMaterialCostPerArea").html()],
                                        ['Total Labor', '$' + $("#sealcoatLaborCost").html(), '$' + $("#sealcoatLaborCostPerArea").html()],
                                        ['Overhead+Profit', '$' + $("#sealcoatOverheadAndProffit").html(), '$' + $("#sealcoatOverheadAndProffitPerArea").html()],
                                        ['Total Project', '$' + $("#sealcoatTotalCost").html(), '$' + $("#sealcoatTotalCostPerArea").html(), 'black']
                                    )
                                }
                            },
                            right: {
                                0: {
                                    "heading": "Project Specifications",
                                    data: new Array(
                                        ['Number of coats', $("#sealcoatCoats").val()],
                                        ['Area', $("#sealcoatArea").val() + ' Sq.' + $("#sealcoatUnit").val().charAt(0).toUpperCase() + $("#sealcoatUnit").val().slice(1) + '.'],
                                        ['Application Rate', $("#sealcoatApplicationRate").val()],
                                        ['% of Water', $("#sealcoatWater").val()],
                                        ['% of Additive', $("#sealcoatAdditive").val()],
                                        ['Sand', $("#sealcoatSand").val()]
                                    )
                                },
                                1: {
                                    "heading": "Total Material Breakdown",
                                    data: new Array(
                                        ['Total Bulk Sealer', $("#sealcoatSealerTotal").html() + ' Gallons'],
                                        ['Water', $("#sealcoatWaterTotal").html() + ' Gallons'],
                                        ['Additive', $("#sealcoatAdditiveTotal").html() + ' Gallons'],
                                        ['Spot Primer', $("#sealcoatSpotPrimerTotal").html() + ' Gallons'],
                                        ['Sand', $("#sealcoatSandTotal").html() + ' Lb', $("#sealcoatSandTotalGal").html() + ' Gallons'],
                                        ['Total Project Gallons', $("#sealcoatTotal").html() + ' Gallons']
                                    )
                                }
                            }
                        },
                        print_text: '<?php
                            echo str_replace(
                                array("\r", "\n"),
                                '',
                                trim($this->em->getRepository('models\Site_settings')->findOneBy(array('settingName' => 'print_text'))->getSettingValue())
                            );
                            ?>'
                    };
                    $.printCalc(settings);
                },
                Cancel: function () {
                    $(this).dialog("close");
                }
            },
            autoOpen: false
        });

        /**********************
         * Seal Coat Calculator *
         ************************/
        var sealcoatFields = "#sealcoatSpotPrimerCost, #sealcoatSpotPrimerGal, #sealcoatOverhead, #sealcoatProffit, #sealcoatHourlyCost, #sealcoatTripHours, #sealcoatMen, #sealcoatTrips, #sealcoatCoats, #sealcoatUnit, #sealcoatArea, #sealcoatWater, #sealcoatAdditive, #sealcoatSand, #sealcoatApplicationRate, #sealcoatSealerCost, #sealcoatSandCost, #sealcoatAdditiveCost";
        $(sealcoatFields).live('change keyup', function () {
            sealcoatCalculator();
        });
        var requestAuth;

        function sealcoatCalculator() {
            if ($("#sealcoatUnit").val() == 'ft') {
                $("#sealCoatUnitValue2").html('Sq.Feet');
                $(".apprate").removeAttr('id').hide();
                $(".apprate2").show().attr('id', 'sealcoatApplicationRate');
            } else {
                $("#sealCoatUnitValue2").html('Sq.Yards');
                $(".apprate").removeAttr('id').hide();
                $(".apprate1").show().attr('id', 'sealcoatApplicationRate');
            }
            var sealcoatArea = $("#sealcoatArea").val();
            sealcoatArea = Number(sealcoatArea.replace(/,/i, ''));
            //        alert(sealcoatArea);
            var sealerTotalValue = (sealcoatArea * $("#sealcoatApplicationRate").val());
            var waterValue = $("#sealcoatWater").val() * sealerTotalValue / 100;
            var additiveValue = $("#sealcoatAdditive").val() * sealerTotalValue / 100;
            var sealerConcentrate = sealerTotalValue - waterValue - additiveValue;
            var totalSand = $("#sealcoatSand").val() * sealerConcentrate;
            var totalSandInGallons = totalSand / 22;

            var spotPrimerGal = Number($("#sealcoatSpotPrimerGal ").val());
            var spotPrimerCost = Number($("#sealcoatSpotPrimerCost").val());
            var spotPrimerValue = spotPrimerGal * spotPrimerCost;
            var spotPrimerValuePerArea = spotPrimerValue / sealcoatArea;
            if (sealcoatArea == 0) {
                spotPrimerValuePerArea = 0;
            }
            var totalMaterialValue = sealerTotalValue + totalSand + waterValue + totalSandInGallons + additiveValue + spotPrimerGal;
            var sealerCost = $("#sealcoatSealerCost").val();
            var sealerValue = sealerTotalValue * sealerCost;
            var sealerCostPerArea = sealerValue / sealcoatArea;
            if (isNaN(sealerCostPerArea) || sealcoatArea == 0) {
                sealerCostPerArea = 0;
            }
            var sealerSandCost = $("#sealcoatSandCost").val();
            var sandCost = sealerSandCost * totalSand / 100;
            var sandCostPerArea = sandCost / sealcoatArea;
            if (isNaN(sandCostPerArea)) {
                sandCostPerArea = 0;
            }
            var additiveCost = $("#sealcoatAdditiveCost").val();
            var additiveTotalCost = additiveCost * additiveValue;
            var additiveTotalCostPerArea = additiveTotalCost / sealcoatArea;
            if (isNaN(additiveTotalCostPerArea)) {
                additiveTotalCostPerArea = 0;
            }
            var totalCost = sandCost + additiveTotalCost + sealerValue + spotPrimerValue;
            var totalCostPerArea = totalCost / sealcoatArea;
            if (isNaN(totalCostPerArea) || sealcoatArea == 0) {
                totalCostPerArea = 0;
            }
            var laborCost = $("#sealcoatTrips").val() * ($("#sealcoatTripHours").val() * $("#sealcoatMen").val()) * $("#sealcoatHourlyCost").val();
            var laborCostPerArea = laborCost / sealcoatArea;
            if (isNaN(laborCostPerArea)) {
                laborCostPerArea = 0;
            }
            var overheadAndProffit = (parseFloat($("#sealcoatProffit").val()) * $("#sealcoatTrips").val()) + (parseFloat($("#sealcoatOverhead").val()) * $("#sealcoatTrips").val());
            var overheadAndProffitPerArea = overheadAndProffit / sealcoatArea;
            if (isNaN(overheadAndProffitPerArea)) {
                overheadAndProffitPerArea = 0;
            }
            var sealcoatCost = laborCost + totalCost + overheadAndProffit;
            var sealcoatCostPerUnit = sealcoatCost / sealcoatArea;
            if (isNaN(sealcoatCostPerUnit) || sealcoatArea == 0) {
                sealcoatCostPerUnit = 0;
            }

            $("#sealcoatSealerTotal").html(addCommas(sealerTotalValue.toFixed(2)));
            $("#sealcoatWaterTotal").html(addCommas(waterValue.toFixed(2)));
            $("#sealcoatAdditiveTotal").html(addCommas(additiveValue.toFixed(2)));
            $("#sealcoatSandTotal").html(addCommas(totalSand.toFixed(2)));
            $("#sealcoatSandTotalGal").html(addCommas(totalSandInGallons.toFixed(2)));
            $("#sealcoatTotal").html(addCommas(totalMaterialValue.toFixed(2)));
            $("#sealcoatTotalSealerValue").html(addCommas(sealerValue.toFixed(2)));
            $("#sealcoatTotalSealerValuePerArea").html(addCommas(sealerCostPerArea.toFixed(2)));
            $("#sealcoatTotalSandValue").html(addCommas(sandCost.toFixed(2)));
            $("#sealcoatTotalSandValuePerArea").html(addCommas(sandCostPerArea.toFixed(2)));
            $("#sealcoatTotalAdditiveValue").html(addCommas(additiveTotalCost.toFixed(2)));
            $("#sealcoatTotalAdditiveValuePerArea").html(addCommas(additiveTotalCostPerArea.toFixed(2)));
            $("#sealcoatMaterialCost").html(addCommas(totalCost.toFixed(2)));
            $("#sealcoatMaterialCostPerArea").html(addCommas(totalCostPerArea.toFixed(2)));
            $("#sealcoatLaborCost").html(addCommas(laborCost.toFixed(2)));
            $("#sealcoatLaborCostPerArea").html(addCommas(laborCostPerArea.toFixed(2)));
            $("#sealcoatOverheadAndProffit").html(addCommas(overheadAndProffit.toFixed(2)));
            $("#sealcoatOverheadAndProffitPerArea").html(addCommas(overheadAndProffitPerArea.toFixed(2)));
            $("#sealcoatTotalCost").html(addCommas(sealcoatCost.toFixed(0)));
            $("#sealcoatTotalCostPerArea").html(addCommas(sealcoatCostPerUnit.toFixed(2)));
            $("#sealcoatSpotPrimerTotal").html(addCommas(Number(spotPrimerGal).toFixed(2)));
            $("#sealcoatTotalSpotPrimerValue").html(addCommas(spotPrimerValue.toFixed(2)));
            $("#sealcoatTotalSpotPrimerValuePerArea").html(addCommas(spotPrimerValuePerArea.toFixed(2)));

        }

        sealcoatCalculator();


        <?php } ?>

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

        $("#notesSaved").dialog({
            autoOpen: false,
            buttons: {
                Close: function () {
                    $(this).dialog('close');
                }
            }
        });
        ///privileges code
        $(".launchPrivileges").click(function () {
            $("#privileges").dialog('open');
            return false;
        });
        $("#privileges").dialog({
            modal: true,
            width: 700,
            autoOpen: false,
            buttons: {
                Close: function () {
                    $(this).dialog('close');
                }
            }
        });
        //image upload message
        var hash;
        $("#custom-message").dialog({
            modal: true,
            width: 400,
            autoOpen: false,
            buttons: {
                Close: function () {
                    $(this).dialog('close');
                }
            },
            close: function () {
                location.hash = hash;
            }
        });
        $("#unduplicateConfirm").dialog({
            modal: true,
            width: 400,
            autoOpen: false,
            buttons: {
                Continue: function () {
                    var unduplicateUrl = '<?php echo site_url('proposals/unduplicate/' . $proposal->getProposalId()) ?>';
                    window.location.href = unduplicateUrl;
                },
                Close: function () {
                    $(this).dialog('close');
                }
            }
        });


        <?php
        //upload image code
        if ($this->session->flashdata('proposal_images_uploaded')) {
        ?>
        $("#custom-message").html('<?php echo $this->session->flashdata('proposal_images_uploaded'); ?>');
        hash = '#proposal-images';
        $("#custom-message").dialog('open');
        <?php
        }
        //upload attachment code
        if ($this->session->flashdata('project-attachments')) {
        ?>
        $("#custom-message").html('<?php echo $this->session->flashdata('project-attachments'); ?>');
        hash = '#project-attachments';
        $("#custom-message").dialog('open');
        <?php
        }
        ?>

        // Text Editor
        $("#textEditorOpen").dialog({
            autoOpen: false,
            modal: true,
            width: 500,
            buttons: {
                OK: function () {
                    $(this).dialog('close');
                }
            }
        });

        $("#currentImage").css('opacity', $("#hiddenImageOpacity").val());
        $(".preview-heading").css('background-color', hexToRgb('#' + $("#headerBgColor").val()));
        $(".preview-heading").css('color', '#' + $("#headerFontColor").val());

        $("#imageOpacity").change(function () {
            $("#hiddenImageOpacity").val($(this).val());
            $("#currentImage").css('opacity', $("#hiddenImageOpacity").val());
        });

        $("#saveImage").click(function () {
            $("#company_proposal_settings6").submit();
            $("#imageProcessing").dialog('open');
            return true;
        });

        $("#imageProcessing").dialog({
            width: 400,
            modal: true,
            buttons: {},
            autoOpen: false
        });

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function (e) {
                    $('#currentImage').attr('src', e.target.result);
                };
                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#gradientImage").change(function () {
            readURL(this);
            $("#previewContainer").show();
        });

        $("#titleChoices").click(function () {
            $("#choices").dialog('open');
            return false;
        });
        $(".choice").click(function () {
            var id = $(this).attr('rel');
            var text = $(id).html();
            $("#proposalTitle").val(htmlUnescape(text));
            $("#choices").dialog('close');
        });
        $("#choices").dialog({
            modal: true,
            autoOpen: false,
            width: 450,
            buttons: {
                Cancel: function () {
                    $(this).dialog("close");
                }
            }
        });

        // Images
        $("#image").change(function () {

            $('#imageUploadPreview').attr('src', '');
            $('#imageUploadPreview').hide();

            // Limit checks
            var numFiles = this.files.length;
            var numAllowedUploads = numRemainingImages();

            if (numFiles > numAllowedUploads) {
                swal(
                    'Error',
                    'This would take you over the limit of 12 images!'
                );
                return false;
            }

            previewImage(this);
        });

        function previewImage(input) {
            if (input.files && input.files.length < 2) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#imageUploadPreview').attr('src', e.target.result);
                    $('#imageUploadPreview').show();
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                var image_html = '';
                $(".multipleImagePreview").html(image_html);
                $('.multipleImagePreview').css('display', 'table');
                for ($i = 0; $i < input.files.length; $i++) {
                    var reader = new FileReader();

                    reader.onload = function (e) {

                        var image_html = '<div class="multipleImagePreviewColumn"><img src="' + e.target.result + '" style="width:100%"></div>'
                        $(".multipleImagePreview").append(image_html);

                    };
                    reader.readAsDataURL(input.files[$i]);
                }
            }
        }


        // Upload Button
        $("#uploadImage").click(function (e) {
            // Prevent form submit
            e.preventDefault();
            var image_uploaded_count = 0;
            // Do we have images
            var images = $("#image")[0].files;

            if (!images.length) {
                swal(
                    'Error',
                    'There are no images to upload!'
                );
                return false;
            }
            image_blob_data = images;
            // We need a file reader
            selected_uploading_image_count = images.length;
            var check = 0;
            $("#imageUploadNum").text(selected_uploading_image_count);
            $("#imageUploadedNum2").text(selected_uploading_image_count);
            $("#imageUploadedNum").text(0);
            $("#imageUploading").show();
            // var promises = [];
            for (var i = 0, len = images.length; i < len; i++) {
                var reader = new FileReader();
                // Handler for when image is read
                reader.onload = function (e) {
                    image_blob_data2.push(e.target.result);
                    console.log(selected_uploading_image_count)
                    console.log(image_blob_data2.length)
                    if (image_blob_data2.length == selected_uploading_image_count) {

                        image_upload_test2(image_blob_data2[0], 0)
                    }

                };
                reader.readAsDataURL(images[i]);
            }

            console.log(image_blob_data2)
            return false;
            //console.log(image_blob_data[0]);
            //image_blob_data = images;
            $("#imageUploadNum").text(selected_uploading_image_count);
            $("#imageUploadedNum2").text(selected_uploading_image_count);
            $("#imageUploadedNum").text(0);
            $("#imageUploading").show();

            image_upload_test(image_blob_data[0], 0)
            return false;
            for (var i = 0, len = images.length; i < len; i++) {
                console.log('Image: ' + i);

                // Get the source
                var reader = new FileReader();
                // Handler for when image is read
                reader.onload = function (e) {
                    // The image URL
                    var imgUrl = e.target.result;

                    // Build the data
                    var postData = {
                        proposalId: proposalId,
                        imgUrl: imgUrl
                    };

                    $("#imageUploadNum").text(len);
                    $("#imageUploadedNum2").text(len);
                    $("#imageUploadedNum").text(0);
                    $("#imageUploading").show();


                    // setTimeout(function () {
                    $.ajax({
                        async: false,
                        type: "POST",

                        url: "<?php echo site_url('ajax/proposalSaveImage') ?>",
                        data: postData,
                        dataType: 'json',
                        xhr: function () {
                            var xhr = new window.XMLHttpRequest();
                            // Handle progress
                            //Upload progress
                            xhr.upload.addEventListener("progress", function (evt) {
                                if (evt.lengthComputable) {
                                    var percentComplete = Math.floor((evt.loaded / evt.total) * 100);
                                    //Do something with upload progress
                                    console.log('percentComplete');
                                    console.log(percentComplete);
                                    $("#imageUploadPct").text(percentComplete);
                                    if (percentComplete == 100) {
                                        $('#imageUploadProcessing').show();
                                    }
                                }
                            }, false);

                            return xhr;
                        }
                    })
                        .done(function (data) {
                            image_uploaded_count = image_uploaded_count + 1;
                            console.log('Image done: ' + image_uploaded_count);
                            $("#imageUploadedNum").text(image_uploaded_count);
                            if (data.error) {

                                var errMsg = '';
                                if (data.message) {
                                    errMsg = data.message;
                                }

                                $("#imageUploading").hide();
                                swal(
                                    'Error',
                                    'There was an error saving the image [' + errMsg + ']'
                                );
                            } else {
                                // Add the image panel

                                var newContent = '' +

                                    '<div data-image-id="' + data.id + '" id="image_' + data.id + '" class="image_div">' +
                                    '<span class="group_checker"><input type="checkbox" id="checkbox_image_' + data.id + '"  name="images" class="proposal_images" value="' + data.id + '" style="float:left;"></span>' +
                                    '<h3>' +
                                    '<a href="#"><span id="title_' + data.id + '">Image</span></a>' +
                                    '<span title="Show In Work Order" class="superScript grey_b" id="header_span_workorder_' + data.id + '" style="right: 68px;position: absolute;top: 6px;display:block">WO</span>' +
                                    '<span title="Show In Proposal" class="superScript grey_b" id="header_span_proposal_' + data.id + '" style="right: 101px;position: absolute;top: 6px;display:block">P</span>' +
                                    '<span title="1 Image Per Page" class="superScript grey_b tiptip" id="header_span_image_' + data.id + '" style="right: 30px;position: absolute;top: 6px;">1 <i class="fa fa-fw fa-picture-o"></i></span>' +
                                    '<a class="btn-delete close-accordion" href="#">&nbsp;</a>' +
                                    '</h3>' +
                                    '<form class="big update-title-form form-validated imgForm" style="padding: 2px 5px !important;">' +
                                    '<div class="clearfix">' +
                                    '<div style="width: 155px; float: left">' +
                                    '<a href="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + data.path + '?' + Math.random() +
                                    '" class="fancybox">' +
                                    '<img id="img_' + data.id + '" style="height: auto; width: 150px;" ' +
                                    'src="' + imgUrl + '" alt="" title="Click to enlarge" class="tiptip"></a>' +
                                    '</div>' +
                                    '<div style="width: 200px; float: left">' +
                                    '<p class="clearfix" style="margin-top: 10px;">' +
                                    '<label style="width: 40px; margin: 0 5px 0 0; line-height: 20px;">Title</label>' +
                                    '<input type="text" name="title" class="required" id="title2_' + data.id + '" ' +
                                    'value="Image">' +
                                    '</p>' +
                                    '<p class="clearfix">' +
                                    '<label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;"' +
                                    'for="active_' + data.id + '">Proposal</label>' +
                                    '<input type="checkbox" name="active" id="active_' + data.id + '" checked="checked">' +
                                    '<span class="clearfix"></span>' +
                                    '<label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;"' +
                                    'for="activewo_' + data.id + '">Work Order</label>' +
                                    '<input type="checkbox" name="active"' +
                                    'id="activewo_' + data.id + '" checked="checked">' +
                                    '<div class="clearfix"></div>' +
                                    '<select name="images_layout" id="images_layout_' + data.id + '" style="float: left; opacity: 0;" tabindex="7">' +
                                    '<option value="0">1 Image Per Page</option>' +
                                    '<option value="1">2 Images Per Page</option>' +
                                    '<option value="2">4 Images Per Page</option>' +
                                    '</select>' +

                                    '</p>' +
                                    '<p id="updating_' + data.id + '" class="imageUpdating"></p>' +
                                    '</div>' +
                                    '<div class="clearfix"></div>' +
                                    '<div class="clearfix" style="padding: 10px 0 0;">' +
                                    '<div style="width: 150px; float: left; text-align: center;">' +
                                    '<a style="float: left; margin-left: 45px; font-size: 26px; color: #000;"' +
                                    'class="rotateImage rotateLeft tiptip"' +
                                    'rel="' + data.id + '" title="Rotate Left" href="#">' +
                                    '<i class="fa fa-fw fa-rotate-left"></i>' +
                                    '</a>' +
                                    '<a style="float: left; font-size: 26px; color: #000;" class="rotateImage rotateRight tiptip"' +
                                    'rel="' + data.id + '" title="Rotate Right" href="#">' +
                                    '<i class="fa fa-fw fa-rotate-right"></i>' +
                                    '</a>' +
                                    '</div>' +
                                    '<div style="width: 205px; float: left" class="clearfix">' +
                                    '<p class="clearfix">' +
                                    '<a href="#" class="tiptip btn delete-image-button deleteIcon" ' +
                                    'data-image-id="' + data.id + '" title="Delete" data-delete-id="' + data.id + '" style="margin-right: 10px; margin-left: 10px;">' +
                                    '</a>' +
                                    '<a class="btn image-notes notesIcon tiptip" type="button" title="Notes" id="notes-' + data.id + '"></a>' +
                                    '<a href="#" class="btn update-image-button update-button saveIcon" data-image-id="' + data.id + '" style="margin-left: 10px;float:right">' +
                                    'Update' +
                                    '</a>' +
                                    '</p>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</div>' +
                                    '</form>';

                                $("#accordion3").append(newContent);
                                $("#accordion3").sortable('refresh');
                                $("#accordion3").accordion('destroy').accordion({
                                    collapsible: true,
                                    active: -1,
                                    autoHeight: false,
                                    navigation: true,
                                    header: "> div > h3"
                                });
                                if (len == image_uploaded_count) {
                                    $("#imageUploading").hide();
                                }

                                imageCountCheck();
                                initButtons();
                                initTiptip();
                                // $('#accordion3 input:checkbox').uniform();
                                $('#checkbox_image_' + data.id).uniform();
                                $('#images_layout_' + data.id).uniform();
                                //$('#image_' + data.id +' input:checkbox').uniform();

                                //$.uniform.update();

                                // Update the button text
                                $("#uploadImage").val('Upload');
                                // Clear the preview image
                                $("#imageUploadPreview").attr('src', '');
                                $("#imageUploadPreview").hide();
                                // Reset the input
                                $("#image").val('');
                            }
                        })
                        .fail(function (xhr) {
                            $("#imageUploading").hide();
                            swal(
                                'Error',
                                'There was an error saving the image: Error Information: ' + xhr.responseText
                            );
                        });

                    //}, 1000);

                };
                reader.readAsDataURL(images[i]);
            }

            imageCountCheck();

            return false;

        });


        var temp_arry = [];

        function image_upload_test(imageData, count) {
            console.log('image upload test 1');
            // image_blob_data = imageData;
            //array_push(temp_arry,imageData);
            //temp_arry.push(imageData);
            //console.log(image_blob_data)

            // Get the source
            var reader = new FileReader();
            // Handler for when image is read
            reader.onload = function (e) {
                // The image URL
                var imgUrl = e.target.result;

                // Build the data
                var postData = {
                    proposalId: proposalId,
                    imgUrl: imgUrl
                };


                // setTimeout(function () {
                $.ajax({
                    async: false,
                    type: "POST",
                    cache: false,

                    url: "<?php echo site_url('ajax/proposalSaveImage') ?>",
                    data: postData,
                    dataType: 'json',


                    //}).done(function (data) {
                    success: function (data) {

                        console.log('Image done: ' + count);


                        if (data.error) {

                            var errMsg = '';
                            if (data.message) {
                                errMsg = data.message;
                            }

                            $("#imageUploading").hide();
                            swal(
                                'Error',
                                'There was an error saving the image [' + errMsg + ']'
                            );
                        } else {
                            count = count + 1;
                            console.log(selected_uploading_image_count);
                            console.log(count);
                            $("#imageUploadedNum").text(count);
                            if (selected_uploading_image_count > count) {

                                if (image_blob_data[count]) {
                                    console.log('retry1')
                                    image_upload_test(image_blob_data[count], count);
                                } else {
                                    console.log('retry2')
                                    //image_upload_test2(image_blob_data2[count],count);
                                }
                            } else {
                                $("#imageUploading").hide();
                            }


                        }
                        // Add the image panel

                        var newContent = '' +

                            '<div data-image-id="' + data.id + '" id="image_' + data.id + '" class="image_div">' +
                            '<span class="group_checker"><input type="checkbox" id="checkbox_image_' + data.id + '"  name="images" class="proposal_images" value="' + data.id + '" style="float:left;"></span>' +
                            '<h3>' +
                            '<a href="#"><span id="title_' + data.id + '">Image</span></a>' +
                            '<span title="Show In Work Order" class="superScript grey_b" id="header_span_workorder_' + data.id + '" style="right: 68px;position: absolute;top: 6px;display:block">WO</span>' +
                            '<span title="Show In Proposal" class="superScript grey_b" id="header_span_proposal_' + data.id + '" style="right: 101px;position: absolute;top: 6px;display:block">P</span>' +
                            '<span title="1 Image Per Page" class="superScript grey_b tiptip" id="header_span_image_' + data.id + '" style="right: 30px;position: absolute;top: 6px;">1 <i class="fa fa-fw fa-picture-o"></i></span>' +
                            '<a class="btn-delete close-accordion" href="#">&nbsp;</a>' +
                            '</h3>' +
                            '<form class="big update-title-form form-validated imgForm" style="padding: 2px 5px !important;">' +
                            '<div class="clearfix">' +
                            '<div style="width: 155px; float: left">' +
                            '<a href="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + data.path + '?' + Math.random() +
                            '" class="fancybox">' +
                            '<img id="img_' + data.id + '" style="height: auto; width: 150px;" ' +
                            'src="' + imgUrl + '" alt="" title="Click to enlarge" class="tiptip"></a>' +
                            '</div>' +
                            '<div style="width: 200px; float: left">' +
                            '<p class="clearfix" style="margin-top: 10px;">' +
                            '<label style="width: 40px; margin: 0 5px 0 0; line-height: 20px;">Title</label>' +
                            '<input type="text" name="title" class="required" id="title2_' + data.id + '" ' +
                            'value="Image">' +
                            '</p>' +
                            '<p class="clearfix">' +
                            '<label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;"' +
                            'for="active_' + data.id + '">Proposal</label>' +
                            '<input type="checkbox" name="active" id="active_' + data.id + '" checked="checked">' +
                            '<span class="clearfix"></span>' +
                            '<label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;"' +
                            'for="activewo_' + data.id + '">Work Order</label>' +
                            '<input type="checkbox" name="active"' +
                            'id="activewo_' + data.id + '" checked="checked">' +
                            '<div class="clearfix"></div>' +
                            '<select name="images_layout" id="images_layout_' + data.id + '" style="float: left; opacity: 0;" tabindex="7">' +
                            '<option value="0">1 Image Per Page</option>' +
                            '<option value="1">2 Images Per Page</option>' +
                            '<option value="2">4 Images Per Page</option>' +
                            '</select>' +

                            '</p>' +
                            '<p id="updating_' + data.id + '" class="imageUpdating"></p>' +
                            '</div>' +
                            '<div class="clearfix"></div>' +
                            '<div class="clearfix" style="padding: 10px 0 0;">' +
                            '<div style="width: 150px; float: left; text-align: center;">' +
                            '<a style="float: left; margin-left: 45px; font-size: 26px; color: #000;"' +
                            'class="rotateImage rotateLeft tiptip"' +
                            'rel="' + data.id + '" title="Rotate Left" href="#">' +
                            '<i class="fa fa-fw fa-rotate-left"></i>' +
                            '</a>' +
                            '<a style="float: left; font-size: 26px; color: #000;" class="rotateImage rotateRight tiptip"' +
                            'rel="' + data.id + '" title="Rotate Right" href="#">' +
                            '<i class="fa fa-fw fa-rotate-right"></i>' +
                            '</a>' +
                            '</div>' +
                            '<div style="width: 205px; float: left" class="clearfix">' +
                            '<p class="clearfix">' +
                            '<a href="#" class="tiptip btn delete-image-button deleteIcon" ' +
                            'data-image-id="' + data.id + '" title="Delete" data-delete-id="' + data.id + '" style="margin-right: 10px; margin-left: 10px;">' +
                            '</a>' +
                            '<a class="btn image-notes notesIcon tiptip" type="button" title="Notes" id="notes-' + data.id + '"></a>' +
                            '<a href="#" class="btn update-image-button update-button saveIcon" data-image-id="' + data.id + '" style="margin-left: 10px;float:right">' +
                            'Update' +
                            '</a>' +
                            '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</form>';

                        $("#accordion3").append(newContent);
                        $("#accordion3").sortable('refresh');
                        $("#accordion3").accordion('destroy').accordion({
                            collapsible: true,
                            active: -1,
                            autoHeight: false,
                            navigation: true,
                            header: "> div > h3"
                        });
                        // if(len==image_uploaded_count){
                        //     $("#imageUploading").hide();
                        // }

                        imageCountCheck();
                        initButtons();
                        initTiptip();
                        // $('#accordion3 input:checkbox').uniform();
                        $('#checkbox_image_' + data.id).uniform();
                        $('#images_layout_' + data.id).uniform();
                        //$('#image_' + data.id +' input:checkbox').uniform();

                        //$.uniform.update();

                        // Update the button text
                        $("#uploadImage").val('Upload');
                        // Clear the preview image
                        $("#imageUploadPreview").attr('src', '');
                        $("#imageUploadPreview").hide();
                        // Reset the input
                        $("#image").val('');


                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                        $("#imageUploading").hide();
                        swal(
                            'Error',
                            'There was an error saving the image: Error Information: ' + errorThrown
                        );
                    }
                });

                //}, 1000);

            };
            reader.readAsDataURL(imageData);

        }

        function image_upload_test2(imageData, count) {
            console.log('image upload 2');
            // image_blob_data = imageData;
            //array_push(temp_arry,imageData);
            //temp_arry.push(imageData);
            //console.log(image_blob_data)
            //console.log(imageData)
            // Get the source
            //var reader = new FileReader();
            // Handler for when image is read
            //reader.onload = function (e) {
            // The image URL
            var imgUrl = imageData;

            // Build the data
            var postData = {
                proposalId: proposalId,
                imgUrl: imgUrl
            };


            // setTimeout(function () {
            $.ajax({
                async: false,
                type: "POST",

                url: "<?php echo site_url('ajax/proposalSaveImage') ?>",
                data: postData,
                dataType: 'json',

                //}).done(function (data) {
                success: function (data) {
                    count = count + 1;
                    console.log('Image done: ' + count);


                    if (data.error) {

                        var errMsg = '';
                        if (data.message) {
                            errMsg = data.message;
                        }

                        $("#imageUploading").hide();
                        swal(
                            'Error',
                            'There was an error saving the image [' + errMsg + ']'
                        );
                    } else {

                        if (selected_uploading_image_count > count) {

                            console.log(count);
                            image_upload_test2(image_blob_data2[count], count)
                        } else {
                            $("#imageUploading").hide();
                        }
                        $("#imageUploadedNum").text(count);
                        // Add the image panel

                        var newContent = '' +

                            '<div data-image-id="' + data.id + '" id="image_' + data.id + '" class="image_div">' +
                            '<span class="group_checker"><input type="checkbox" id="checkbox_image_' + data.id + '"  name="images" class="proposal_images" value="' + data.id + '" style="float:left;"></span>' +
                            '<h3>' +
                            '<a href="#"><span id="title_' + data.id + '">Image</span></a>' +
                            '<span title="Show In Work Order" class="superScript grey_b" id="header_span_workorder_' + data.id + '" style="right: 68px;position: absolute;top: 6px;display:block">WO</span>' +
                            '<span title="Show In Proposal" class="superScript grey_b" id="header_span_proposal_' + data.id + '" style="right: 101px;position: absolute;top: 6px;display:block">P</span>' +
                            '<span title="1 Image Per Page" class="superScript grey_b tiptip" id="header_span_image_' + data.id + '" style="right: 30px;position: absolute;top: 6px;">1 <i class="fa fa-fw fa-picture-o"></i></span>' +
                            '<a class="btn-delete close-accordion" href="#">&nbsp;</a>' +
                            '</h3>' +
                            '<form class="big update-title-form form-validated imgForm" style="padding: 2px 5px !important;">' +
                            '<div class="clearfix">' +
                            '<div style="width: 155px; float: left">' +
                            '<a href="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + data.path + '?' + Math.random() +
                            '" class="fancybox">' +
                            '<img id="img_' + data.id + '" style="height: auto; width: 150px;" ' +
                            'src="' + imgUrl + '" alt="" title="Click to enlarge" class="tiptip"></a>' +
                            '</div>' +
                            '<div style="width: 200px; float: left">' +
                            '<p class="clearfix" style="margin-top: 10px;">' +
                            '<label style="width: 40px; margin: 0 5px 0 0; line-height: 20px;">Title</label>' +
                            '<input type="text" name="title" class="required" id="title2_' + data.id + '" ' +
                            'value="Image">' +
                            '</p>' +
                            '<p class="clearfix">' +
                            '<label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;"' +
                            'for="active_' + data.id + '">Proposal</label>' +
                            '<input type="checkbox" name="active" id="active_' + data.id + '" checked="checked">' +
                            '<span class="clearfix"></span>' +
                            '<label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;"' +
                            'for="activewo_' + data.id + '">Work Order</label>' +
                            '<input type="checkbox" name="active"' +
                            'id="activewo_' + data.id + '" checked="checked">' +
                            '<div class="clearfix"></div>' +
                            '<select name="images_layout" id="images_layout_' + data.id + '" style="float: left; opacity: 0;" tabindex="7">' +
                            '<option value="0">1 Image Per Page</option>' +
                            '<option value="1">2 Images Per Page</option>' +
                            '<option value="2">4 Images Per Page</option>' +
                            '</select>' +

                            '</p>' +
                            '<p id="updating_' + data.id + '" class="imageUpdating"></p>' +
                            '</div>' +
                            '<div class="clearfix"></div>' +
                            '<div class="clearfix" style="padding: 10px 0 0;">' +
                            '<div style="width: 150px; float: left; text-align: center;">' +
                            '<a style="float: left; margin-left: 45px; font-size: 26px; color: #000;"' +
                            'class="rotateImage rotateLeft tiptip"' +
                            'rel="' + data.id + '" title="Rotate Left" href="#">' +
                            '<i class="fa fa-fw fa-rotate-left"></i>' +
                            '</a>' +
                            '<a style="float: left; font-size: 26px; color: #000;" class="rotateImage rotateRight tiptip"' +
                            'rel="' + data.id + '" title="Rotate Right" href="#">' +
                            '<i class="fa fa-fw fa-rotate-right"></i>' +
                            '</a>' +
                            '</div>' +
                            '<div style="width: 205px; float: left" class="clearfix">' +
                            '<p class="clearfix">' +
                            '<a href="#" class="tiptip btn delete-image-button deleteIcon" ' +
                            'data-image-id="' + data.id + '" title="Delete" data-delete-id="' + data.id + '" style="margin-right: 10px; margin-left: 10px;">' +
                            '</a>' +
                            '<a class="btn image-notes notesIcon tiptip" type="button" title="Notes" id="notes-' + data.id + '"></a>' +
                            '<a href="#" class="btn update-image-button update-button saveIcon" data-image-id="' + data.id + '" style="margin-left: 10px;float:right">' +
                            'Update' +
                            '</a>' +
                            '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</form>';

                        $("#accordion3").append(newContent);
                        $("#accordion3").sortable('refresh');
                        $("#accordion3").accordion('destroy').accordion({
                            collapsible: true,
                            active: -1,
                            autoHeight: false,
                            navigation: true,
                            header: "> div > h3"
                        });
                        // if(len==image_uploaded_count){
                        //     $("#imageUploading").hide();
                        // }

                        imageCountCheck();
                        initButtons();
                        initTiptip();
                        // $('#accordion3 input:checkbox').uniform();
                        $('#checkbox_image_' + data.id).uniform();
                        $('#images_layout_' + data.id).uniform();
                        //$('#image_' + data.id +' input:checkbox').uniform();

                        //$.uniform.update();

                        // Update the button text
                        $("#uploadImage").val('Upload');
                        // Clear the preview image
                        $("#imageUploadPreview").attr('src', '');
                        $("#imageUploadPreview").hide();
                        // Reset the input
                        $("#image").val('');


                    }
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    $("#imageUploading").hide();
                    swal(
                        'Error',
                        'There was an error saving the image: Error Information: ' + errorThrown
                    );
                }
            });

            //}, 1000);

            // };
            // reader.readAsDataURL(imageData);

        }

        imageCountCheck();

        function imageCountCheck() {

            var numImages = numUploadedImages();
            $('.multipleImagePreview').hide();
            // Do the upload limit check
            if (numImages < imageUploadLimit) {
                $("#imageLimitReached").hide();
                $("#imageUploader").show();
            } else {
                $("#imageLimitReached").show();
                $("#imageUploader").hide();
            }

            $("#imageCounter").text(numImages);
            // Update the badge on the tab
            if (numImages < 1) {
                $("#imageCounter").removeClass('blue');
                $("#imageCounter").addClass('red');
                $('.all_images_td').hide();
                $('#editImages').css('width', '50%');
                $('.individual_proposal_section_table').find('tr[data-section-code="images"]').hide();

            } else {
                $('.all_images_td').show();
                $('#editImages').css('width', '100%')
                $("#imageCounter").removeClass('red');
                $("#imageCounter").addClass('blue');
                $('.individual_proposal_section_table').find('tr[data-section-code="images"]').show();
            }
        }

        mapimageCountCheck();

        function mapimageCountCheck() {

            var numImages = numUploadedMapImages();
            $('.multipleImagePreview').hide();
            // Do the upload limit check
            if (numImages < mapImageUploadLimit) {
                $("#mapImageLimitReached").hide();
                $("#imageMapUploader").show();
                $("#proposalMapImageUploader").prop('disabled',false);
            } else {
                $("#mapImageLimitReached").show();
                $("#imageMapUploader").hide();
            }

            $("#mapImageCounter").text(numImages);
            // Update the badge on the tab
            if (numImages < 1) {
                $("#mapImageCounter").removeClass('blue');
                $("#mapImageCounter").addClass('red');
                $('.all_map_images_td').hide();
                $('#editMapImages').css('width', '50%');
                $('.individual_proposal_section_table').find('tr[data-section-code="map_images"]').hide();

            } else {
                $('.all_map_images_td').show();
                $('#editMapImages').css('width', '100%')
                $("#mapImageCounter").removeClass('red');
                $("#mapImageCounter").addClass('blue');
                $('.individual_proposal_section_table').find('tr[data-section-code="map_images"]').show();
            }
        }

        function numUploadedImages() {
            return $("#accordion3 > div.image_div").length;
        }

        function numUploadedMapImages() {
            return $("#proposalMapImages > div.map_image_div").length;
        }


        videoCountCheck();


        function numRemainingImages() {
            return (imageUploadLimit - numUploadedImages());
        }

        $("#saveImagesLayout55").click(function () {
            var imageLayout = $("#images_layout").val();
            var postData = {
                proposalId: proposalId,
                layout: imageLayout
            };

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('ajax/proposalImageLayout') ?>",
                data: postData,
                dataType: 'json'
            })
                .done(function (data) {
                    if (!data.error) {
                        toastr.success('Image Layout Saved');
                    } else {
                        toastr.error('Error Saving Layout');
                    }
                }).fail(function () {
                toastr.error('Error Saving Layout');
            });
        });

        // Delete Image Dialog
        $("#confirmImageDelete").dialog({
            autoOpen: false,
            modal: true,
            width: 400,
            buttons: {
                Confirm: {
                    class: 'update-button deleteIcon',
                    text: ' Delete Image',
                    click: function () {

                        $(this).dialog('close');
                        $("#loading").show();

                        $.ajax({
                            type: "GET",
                            url: "<?php echo site_url('ajax/deleteProposalImage') ?>/" + $("#confirmImageDelete").data('delete-id'),
                            dataType: 'json'
                        })
                            .done(function (data) {

                                $("#loading").hide();

                                if (!data.id) {
                                    swal(
                                        'Error',
                                        'There was an error deleting the image'
                                    );
                                    return;
                                }

                                $("#image_" + data.id).effect('highlight', 'slow').remove();
                                $('#accordion3').accordion('refresh');
                                $('#proposalMapImages').accordion('refresh');
                                $('#serviceImages').accordion('refresh');
                                $('.proposal_sevice_image_notes_div').hide();
                                $('.proposal_sevice_map_image_notes_div').hide();
                                if($("#confirmImageDelete").data('service-id')){
                                    enable_map_service_select($("#confirmImageDelete").data('service-id'));
                                }
                                
                                imageCountCheck();
                                mapimageCountCheck();
                                reset_uploader();
                                reset_map_uploader();
                                reset_service_uploader();
                                reset_map_service_uploader();

                                swal(
                                    'Success',
                                    'Image Deleted'
                                );

                            })
                            .fail(function (xhr) {
                                $("#loading").hide();

                                swal(
                                    'Error',
                                    'There was an error deleting the image: Error Information: ' + xhr.responseText
                                );
                            });
                    }
                },
                Close: {
                    class: 'closeIcon',
                    text: 'Cancel',
                    click: function () {
                        $(this).dialog('close');
                    }
                }
            }
        });


        // Delete Image Click - show confirm popup
        $(document).on('click', ".delete-image-button", function () {
            var imageId = $(this).data('delete-id');
            var serviceId = $(this).data('service-id');
            $("#confirmImageDelete").dialog('open');
            $("#confirmImageDelete").data('delete-id', imageId);
            if(serviceId){
                $("#confirmImageDelete").data('service-id', serviceId);
            }else{
                $("#confirmImageDelete").data('service-id', '');
            }

            return false;
        });

                // Delete Image Dialog
        $("#confirmImageMoveToMaps").dialog({
            autoOpen: false,
            modal: true,
            width: 400,
            buttons: {
                Confirm: {
                    class: 'update-button deleteIcon',
                    text: ' Move Map',
                    click: function () {

                        $(this).dialog('close');
                        $("#loading").show();

                        $.ajax({
                            type: "GET",
                            url: "<?php echo site_url('ajax/moveServiceMapToMaps') ?>/" + $("#confirmImageMoveToMaps").data('image-id'),
                            dataType: 'json'
                        })
                            .done(function (data) {

                                $("#loading").hide();

                                if (!data.id) {
                                    swal(
                                        'Error',
                                        'There was an error deleting the image'
                                    );
                                    return;
                                }

                                $("#image_" + data.id).effect('highlight', 'slow').remove();
                                
                                var service_select_option = '<label style="margin: 0 5px 0 0; line-height: 20px;">Move Map To Service</label><select  class="select_service_map" name="select_service_map" id="select_service_map_' + data.id + '"><option value="" selected>Select Service To Move</option>';
                        <?php
                            foreach ($proposal_services as $service) {
                                if(!in_array($service->getServiceId(),$mapServicesIds)){?>
                                     service_select_option += '<option value="<?=$service->getServiceId();?>"><?=urlencode($service->getServiceName());?></option>';
                                <?php 
                                }else{?>
                                    service_select_option += '<option disabled value="<?=$service->getServiceId();?>"><?=urlencode($service->getServiceName());?></option>';
                                <?php 
                                }
                            }
                        ?>
                    service_select_option += '</select>';
                        var newContent = '' +

                            '<div data-image-id="' + data.id + '" id="image_' + data.id + '" class="map_image_div">' +
                            '<span class="group_checker"><input type="checkbox" id="checkbox_image_' + data.id + '"  name="images" class="proposal_images" value="' + data.id + '" style="float:left;"></span>' +
                            '<h3>' +
                            '<a href="#"><span id="title_' + data.id + '">Site Map</span></a>' +
                            '<span title="Show In Work Order" class="superScript grey_b" id="header_span_workorder_' + data.id + '" style="right: 68px;position: absolute;top: 6px;display:block">WO</span>' +
                            '<span title="Show In Proposal" class="superScript grey_b" id="header_span_proposal_' + data.id + '" style="right: 101px;position: absolute;top: 6px;display:block">P</span>' +
                            '<a class="btn-delete close-accordion" href="#">&nbsp;</a>' +
                            '</h3>' +
                            '<form class="big update-title-form form-validated imgForm" style="padding: 2px 5px !important;">' +
                            '<div class="clearfix">' +
                            '<div style="width: 155px; float: left">' +
                            '<a href="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + data.path + '?' + Math.random() +
                            '" class="fancybox">' +
                            '<img id="img_' + data.id + '" style="height: auto; width: 150px;" ' +
                            'src="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + data.path + '?' + Math.random() +
                            '" alt="" title="Click to enlarge" class="tiptip"></a>' +
                            '</div>' +
                            '<div style="width: 200px; float: left">' +
                            '<p class="clearfix" style="margin-top: 10px;">' +
                            '<label style="width: 40px; margin: 0 5px 0 0; line-height: 20px;">Title</label>' +
                            '<input type="text" name="title" class="required" id="title2_' + data.id + '" ' +
                            'value="Site Map">' +
                            '</p>' +
                            '<p class="clearfix">' +
                            '<label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;"' +
                            'for="active_' + data.id + '">Proposal</label>' +
                            '<input type="checkbox" name="active" id="active_' + data.id + '" checked="checked">' +
                            '<span class="clearfix"></span>' +
                            '<label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;"' +
                            'for="activewo_' + data.id + '">Work Order</label>' +
                            '<input type="checkbox" name="active"' +
                            'id="activewo_' + data.id + '" checked="checked">' +
                            '</p>' +
                            '<p id="updating_' + data.id + '" class="imageUpdating"></p>' +service_select_option+
                            '</div>' +
                            '<div class="clearfix"></div>' +
                            '<div class="clearfix" style="padding: 10px 0 0;">' +
                            '<div style="width: 150px; float: left; text-align: center;">' +
                            '<a style="float: left; margin-left: 45px; font-size: 26px; color: #000;"' +
                            'class="rotateImage rotateLeft tiptip"' +
                            'rel="' + data.id + '" title="Rotate Left" href="#">' +
                            '<i class="fa fa-fw fa-rotate-left"></i>' +
                            '</a>' +
                            '<a style="float: left; font-size: 26px; color: #000;" class="rotateImage rotateRight tiptip"' +
                            'rel="' + data.id + '" title="Rotate Right" href="#">' +
                            '<i class="fa fa-fw fa-rotate-right"></i>' +
                            '</a>' +
                            '</div>' +
                            '<div style="width: 205px; float: left" class="clearfix">' +
                            '<p class="clearfix">' +
                            '<a href="#" class="tiptip btn delete-image-button deleteIcon" ' +
                            'data-image-id="' + data.id + '" title="Delete" data-delete-id="' + data.id + '" style="margin-right: 10px; margin-left: 10px;">' +
                            '</a>' +
                            '<a class="btn image-notes notesIcon tiptip" type="button" title="Notes" id="notes-' + data.id + '"></a>' +
                            '<a href="#" class="btn update-image-button update-button saveIcon" data-image-id="' + data.id + '" style="margin-left: 10px;float:right">' +
                            'Update' +
                            '</a>' +
                            '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</form>';

                        $("#proposalMapImages").append(newContent);
                        $("#proposalMapImages").sortable('refresh');
                        $("#proposalMapImages").accordion('destroy').accordion({
                            collapsible: true,
                            active: -1,
                            autoHeight: false,
                            navigation: true,
                            header: "> div > h3"
                        });
                                
                                imageCountCheck();
                                mapimageCountCheck();
                                reset_uploader();
                                reset_map_uploader();
                                reset_service_uploader();
                                reset_map_service_uploader();
                                initButtons();
                                initTiptip();
                                enable_map_service_select($("#confirmImageMoveToMaps").data('service-id'));
                                $('#select_service_map_' + data.id).uniform();
                                $('.proposal_sevice_map_image_notes_div').hide();
                                swal(
                                    'Success',
                                    'Image Deleted'
                                );

                            })
                            .fail(function (xhr) {
                                $("#loading").hide();

                                swal(
                                    'Error',
                                    'There was an error deleting the image: Error Information: ' + xhr.responseText
                                );
                            });
                    }
                },
                Close: {
                    class: 'closeIcon',
                    text: 'Cancel',
                    click: function () {
                        $(this).dialog('close');
                    }
                }
            }
        });
        // Move Image Click - show confirm popup
        $(document).on('click', ".move-image-button", function () {
            var imageId = $(this).data('image-id');
            var serviceId = $(this).data('service-id');
            $("#confirmImageMoveToMaps").dialog('open');
            $("#confirmImageMoveToMaps").data('image-id', imageId);
            $("#confirmImageMoveToMaps").data('service-id', serviceId);

            return false;
        });

        function disable_map_service_select(service_id){
            $( ".select_service_map" ).each(function( index ) {
                //option[value='Medium']").prop('disabled',true);
                $(this).find('option[value="'+service_id+'"]').prop('disabled',true);
                //$(this).uniform();
            });
            
        }

        function enable_map_service_select(service_id){
            $( ".select_service_map" ).each(function( index ) {
                $(this).find('option[value="'+service_id+'"]').prop('disabled',false);
                //$(this).uniform();
            });
        }
        // Update Image button click
        $(document).on('click', ".update-image-button", function (e) {
            e.preventDefault();

            var imageId = $(this).data('image-id');
            var oldTitle = $("#title_" + imageId);
            var newTitle = $("#title2_" + imageId).val();
            if (!newTitle) {
                swal(
                    'Error',
                    'Please enter Image Title'
                );
                return false;
            }
            var imageHeader = $('#image_' + imageId + ' h3');
            var image_layout = $("#images_layout_" + imageId).val();
            var service_id = $("#select_service_map_" + imageId).val();
            var proposal_id = "<?php echo $this->uri->segment(3); ?>";
            if (image_layout == 0) {

                var image_layout_html = '1 <i class="fa fa-fw fa-picture-o"></i>';
                var image_title = '1 Image Per Page';

            } else if (image_layout == 1) {
                var image_layout_html = '2 <i class="fa fa-fw fa-picture-o"></i>';
                var image_title = '2 Images Per Page';
            } else {
                var image_layout_html = '4 <i class="fa fa-fw fa-picture-o"></i>';
                var image_title = '4 Images Per Page';
            }
            var postData = {
                'title': newTitle,
                'active': $("#active_" + imageId).is(":checked") ? 1 : 0,
                'activewo': $("#activewo_" + imageId).is(":checked") ? 1 : 0,
                'image_layout': $("#images_layout_" + imageId).val(),
                'service_id': service_id,
                'proposal_id':proposal_id,
            };

            $.ajax({
                type: "GET",
                url: "<?php echo site_url('ajax/updateProposalImage') ?>/" + imageId,
                dataType: 'json',
                data: postData
            })
                .done(function (data) {
                    if(!service_id){

                        $("#header_span_image_" + imageId).html(image_layout_html);
                        $("#header_span_image_" + imageId).attr('title', image_title);
                        if ($("#active_" + imageId).is(":checked")) {
                            $("#header_span_proposal_" + imageId).show();
                        } else {
                            $("#header_span_proposal_" + imageId).hide();
                        }

                        if ($("#activewo_" + imageId).is(":checked")) {
                            $("#header_span_workorder_" + imageId).show();
                        } else {
                            $("#header_span_workorder_" + imageId).hide();
                        }
                    }else{
                        $("#image_" + data.id).effect('highlight', 'slow').remove();
                                
                                $('#proposalMapImages').accordion('refresh');
                                var count = parseInt($('.serviceImageCount_'+service_id).html())+1;
                                $('.serviceImageCount_'+service_id).html(count);
                                $('.serviceImageCount_'+service_id).css('color','#7b7a7a')
                                
                                mapimageCountCheck();
                                disable_map_service_select(service_id);
                                reset_map_uploader();
                                
                    }


                    $("#loading").hide();

                    if (!data.id) {
                        swal(
                            'Error',
                            'There was an error updating the image'
                        );
                        return;
                    }
                    swal(
                        'Updated',
                        'Image Updated'
                    );

                    $(imageHeader).trigger('click');

                    oldTitle.text(data.title);
                    initTiptip()
                })
                .fail(function (xhr) {
                    $("#loading").hide();

                    swal(
                        'Error',
                        'There was an error updating the image'
                    );
                });

            return false;
        });

        $("#proposalSettingDate").datepicker({
            maxDate: "+0d"
        });
        $("#proposalSettingChangeDate").datepicker({
            maxDate: "+0d"
        });
        $("#proposalSettingWinDate").datepicker({
            maxDate: "+0d"
        });

        $(document).on('click', '.rotateImage', function () {
            var imageId = $(this).attr('rel');
            var image = '#img_' + $(this).attr('rel');
            var updating = "#updating_" + $(this).attr('rel');
            $(updating).html('Rotating image, please wait...').show();
            var rotation = 'left';
            if ($(this).hasClass('rotateRight')) {
                rotation = 'right';
            }
            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('ajax/rotateImage') ?>',
                dataType: 'json',
                data: {
                    imageId: imageId,
                    rotation: rotation
                }
            })
                .done(function (data) {
                    $(image).attr('src', data.path + '?' + Math.floor((Math.random() * 10000) + 1));
                    $(updating).html('Done!').fadeOut('slow');
                });
            return false;
        });

        // Image notes editor
        if ($("#imageNotes").length) {
            var imageNotes_editor = CKEDITOR.replace('imageNotes', {
                toolbar: 'Medium2NL'
            });
        }

        $(document).on('click', '.image-notes', function () {
            var id = $(this).attr('id');
            id = id.replace(/notes-/i, '');
            $("#editImageNotesId").val(id);
            $.get('<?php echo site_url('ajax/getImageNotes') ?>/' + id, function (data) {
                imageNotes_editor.setData(data);
                $("#editImageNotes").dialog('open');
            });
            return false;
        });
        $("#editImageNotes").dialog({
            width: 700,
            height: 430,
            modal: true,
            autoOpen: false,
            buttons: {
                Confirm: {
                    class: 'update-button saveIcon',
                    text: 'Save',
                    click: function () {

                    var image_id = $("#editImageNotesId").val();
                    $.ajax({
                        type: 'POST',
                        url: '<?php echo site_url('ajax/saveImageNotes') ?>/' + $("#editImageNotesId").val(),
                        data: {
                            notes: imageNotes_editor.getData()
                        },
                        complete: function () {
                            $("#editImageNotes").dialog('close');
                            $(".proposal_sevice_image_notes").html(imageNotes_editor.getData());
                            $("#service_image_note_"+image_id).html(imageNotes_editor.getData());
                            $("#notesSaved").dialog({
                                buttons: {
                                    Close: function () {
                                        $(this).dialog('close');
                                    }
                                }
                            });
                        }
                    });
                }
            },

            
                Cancel: {
                    class: 'closeIcon',
                    text: 'Cancel',
                    click: function () {
                        $(this).dialog('close');
                    }
                }
            }
        });
        $(".update-title-form").submit(function () {
            var id = $(this).attr('action');
            id = id.replace(/#/i, '');
            $("#updating_" + id).html('Updating, please wait...').show();
            if ($("#title2_" + id).val()) {
                var request = $.ajax({
                    url: "<?php echo site_url('ajax/updateProposalImageTitle') ?>/" + id,
                    type: "POST",
                    data: {
                        "title": $("#title2_" + id).val()
                    },
                    dataType: "html",
                    success: function (data) {
                        //                                                            alert(data);
                        $("#updating_" + id).html('Done!').fadeOut();
                    }
                });
                var active = 0;
                if ($("#active_" + id).attr("checked")) {
                    active = 1;
                }
                var activewo = 0;
                if ($("#activewo_" + id).attr("checked")) {
                    activewo = 1;
                }
                var request2 = $.ajax({
                    url: "<?php echo site_url('ajax/updateProposalImageActive') ?>/" + id,
                    type: "POST",
                    data: {
                        "active": active,
                        "activewo": activewo
                    },
                    dataType: "html",
                    success: function (data) {
                        //                                                            alert(data);
                    }
                });
                $("#title_" + id).html($("#title2_" + id).val());
            }
            return false;
        });

        // Unduplicate button
        $("#unduplicate").click(function () {
            // Show the dialog
            $("#unduplicateConfirm").dialog('open');
        });

        <?php if (!new_system($proposal->getCreated(false))) { ?>
        //OLD SYSTEM BELONGING JS CODE HERE DELETE SOON PLEASE
        $(".form-item-7").each(function () {
            var leveling_value = $(this).find(".field-leveling select").val();
            if (leveling_value == 'No') {
                $(this).find(".field-leveling_tons").hide();
            } else {
                $(this).find(".field-leveling_tons").show();
            }
            var tackcoat_value = $(this).find(".field-tack_coat select").val();
            if (tackcoat_value == 'No') {
                $(this).find(".field-tack_coat_quantity").hide();
            } else {
                $(this).find(".field-tack_coat_quantity").show();
            }
            var parkingblocks_value = $(this).find(".field-parking_blocks select").val();
            if (parkingblocks_value == 'No') {
                $(this).find(".field-parking_quantity").hide();
            } else {
                $(this).find(".field-parking_quantity").show();
            }
            var riser_rings_value = $(this).find(".field-riser_rings_setting select").val();
            if (riser_rings_value == 'No') {
                $(this).find(".field-riser_rings").hide();
            } else {
                $(this).find(".field-riser_rings").show();
            }
        });
        $(".form-item-13").each(function () {
            var leveling_value = $(this).find(".field-reinforcement select").val();
            if (leveling_value == 'No') {
                $(this).find(".field-reinforcement_type").hide();
            } else {
                $(this).find(".field-reinforcement_type").show();
            }
        });
        $(".form-item-1").each(function () {
            var product = $(this).find(".field-product select").val();
            if (product != 'Enter Your Own') {
                $(this).find(".field-alternate_product").hide();
                $(this).find(".field-alternate_product input").val('None');
            } else {
                $(this).parents('form').find(".field-alternate_product input").val('');
                $(this).find(".field-alternate_product").show();
            }
        });
        $(".field-product select").change(function () {
            if ($(this).val() != 'Enter Your Own') {
                $(this).parents('form').find(".field-alternate_product input").val('None');
                $(this).parents('form').find(".field-alternate_product").hide();
            } else {
                $(this).parents('form').find(".field-alternate_product input").val('');
                $(this).parents('form').find(".field-alternate_product").show();
            }
        });
        $(".field-reinforcement select").change(function () {
            if ($(this).val() == 'No') {
                $(this).parents('form').find(".field-reinforcement_type input").val('None');
                $(this).parents('form').find(".field-reinforcement_type").hide();
            }
            if ($(this).val() == 'Yes') {
                $(this).parents('form').find(".field-reinforcement_type").show();
            }
        });
        $(".field-leveling select").change(function () {
            if ($(this).val() == 'No') {
                $(this).parents('form').find(".field-leveling_tons").hide();
            }
            if ($(this).val() == 'Yes') {
                $(this).parents('form').find(".field-leveling_tons").show();
            }
        });
        $(".field-tack_coat select").change(function () {
            if ($(this).val() == 'No') {
                $(this).parents('form').find(".field-tack_coat_quantity").hide();
            }
            if ($(this).val() == 'Yes') {
                $(this).parents('form').find(".field-tack_coat_quantity").show();
            }
        });
        $(".field-parking_blocks select").change(function () {
            if ($(this).val() == 'No') {
                $(this).parents('form').find(".field-parking_quantity").hide();
            }
            if ($(this).val() == 'Yes') {
                $(this).parents('form').find(".field-parking_quantity").show();
            }
        });
        $(".field-riser_rings_setting select").change(function () {
            if ($(this).val() == 'No') {
                $(this).parents('form').find(".field-riser_rings").hide();
            }
            if ($(this).val() == 'Yes') {
                $(this).parents('form').find(".field-riser_rings").show();
            }
        });

        function form_14_logic(form) {
            var scope = form.find(".field-type select").val();

            //hide functions
            function hide_sealcoat_fields() {
                form.find(".field-coats").hide();
                form.find(".field-crack_sealing").hide();
                form.find(".field-sealant").hide();
                form.find(".field-crack_sealing select").val('No');
                form.find(".field-application").hide();
                form.find(".field-product").hide();
                form.find(".field-driveway_repair").hide();
                form.find(".field-driveway_repair select").val('No');
                form.find(".field-measurement_driveway_repair").val(0).hide();
                form.find(".field-unit_driveway_repair").hide();
                form.find(".field-depth_driveway_repair").val(0).hide();
                form.find(".field-asphalt_type_driveway_repair").hide();
                form.find(".field-time_of_repair").hide();
                form.find(".field-application select").val('Not Specified');
            }

            function hide_driveway_fields() {
                form.find(".field-new_surface_depth").val(0).hide();
                form.find(".field-machine_install").hide();
                form.find(".field-excavation").hide();
                //                            form.find(".field-excavation_area").val(0).hide();
                //                            form.find(".field-excavation_unit").hide();
                form.find(".field-excavation_depth").val(0).hide();
                form.find(".field-base_gravel").hide();
                form.find(".field-base_gravel_amount").hide();
                form.find(".field-base_asphalt").hide();
                form.find(".field-base_asphalt_measurement").val(0).hide();
                form.find(".field-base_asphalt_unit").hide();
                form.find(".field-base_asphalt_depth").val(0).hide();
                form.find(".field-excavation select").val('No');
            }

            function hide_existing_fields() {
                form.find(".field-remove_existing").hide();
                form.find(".field-remove_existing_depth").val(0).hide();
                form.find(".field-new_surface_depth").val(0).hide();
                form.find(".field-machine_install").hide();
                form.find(".field-base_gravel").hide();
                form.find(".field-base_gravel_amount").hide();
                form.find(".field-base_asphalt").hide();
                form.find(".field-base_asphalt_measurement").val(0).hide();
                form.find(".field-base_asphalt_unit").hide();
                form.find(".field-base_asphalt_depth").val(0).hide();
                form.find(".field-remove_surface").hide();
                form.find(".field-remove_surface select").val('No');
                form.find(".field-remove_existing select").val('No');
            }

            function hide_new_and_existing_commons() {
                form.find(".field-base_gravel select").val('No');
                form.find(".field-base_asphalt select").val('No');
                form.find(".field-machine_install select").val('No');
            }

            //show/logic functions
            function sealcoat() {
                form.find(".field-coats").show();
                form.find(".field-crack_sealing").show();
                form.find(".field-application").show();
                form.find(".field-product").show();
                form.find(".field-driveway_repair").show();
                if (form.find(".field-crack_sealing select").val() != 'No') {
                    form.find(".field-sealant").show();
                } else {
                    form.find(".field-sealant").hide();
                }
                if (form.find(".field-driveway_repair select").val() == 'Yes') {
                    form.find(".field-measurement_driveway_repair").show();
                    form.find(".field-unit_driveway_repair").show();
                    form.find(".field-depth_driveway_repair").show();
                    form.find(".field-asphalt_type_driveway_repair").show();
                    form.find(".field-time_of_repair").show();
                } else {
                    form.find(".field-measurement_driveway_repair").val(0).hide();
                    form.find(".field-unit_driveway_repair").hide();
                    form.find(".field-depth_driveway_repair").val(0).hide();
                    form.find(".field-asphalt_type_driveway_repair").hide();
                    form.find(".field-time_of_repair").hide();
                }
            }

            function new_driveway() {
                form.find(".field-new_surface_depth").show();
                form.find(".field-machine_install").show();
                form.find(".field-excavation").show();
                form.find(".field-base_gravel").show();
                form.find(".field-base_asphalt").show();
                if (form.find(".field-excavation select").val() == 'Yes') {
                    form.find(".field-excavation_area").show();
                    form.find(".field-excavation_unit").show();
                    form.find(".field-excavation_depth").show();
                } else {
                    form.find(".field-excavation_area").val(0).hide();
                    form.find(".field-excavation_unit").hide();
                    form.find(".field-excavation_depth").val(0).hide();
                }
                if (form.find(".field-base_gravel select").val() == 'Yes') {
                    form.find(".field-base_gravel_amount").show();
                } else {
                    form.find(".field-base_gravel_amount").val(0).hide();
                }
                if (form.find(".field-base_asphalt select").val() == 'Yes') {
                    form.find(".field-base_asphalt_measurement").show();
                    form.find(".field-base_asphalt_unit").show();
                    form.find(".field-base_asphalt_depth").show();
                } else {
                    form.find(".field-base_asphalt_measurement").val(0).hide();
                    form.find(".field-base_asphalt_unit").hide();
                    form.find(".field-base_asphalt_depth").val(0).hide();
                }
            }

            function pave_existing() {
                form.find(".field-remove_existing").show();
                form.find(".field-new_surface_depth").show();
                form.find(".field-machine_install").show();
                form.find(".field-base_asphalt").show();
                form.find(".field-base_gravel").show();
                form.find(".field-remove_surface").show();
                if (form.find(".field-remove_existing select").val() == 'Yes') {
                    form.find(".field-remove_existing_depth").show();
                } else {
                    form.find(".field-remove_existing_depth").val(0).hide();
                }
                if (form.find(".field-base_gravel select").val() == 'Yes') {
                    form.find(".field-base_gravel_amount").show();
                } else {
                    form.find(".field-base_gravel_amount").val(0).hide();
                }
                if (form.find(".field-base_asphalt select").val() == 'Yes') {
                    form.find(".field-base_asphalt_measurement").show();
                    form.find(".field-base_asphalt_unit").show();
                    form.find(".field-base_asphalt_depth").show();
                } else {
                    form.find(".field-base_asphalt_measurement").val(0).hide();
                    form.find(".field-base_asphalt_unit").hide();
                    form.find(".field-base_asphalt_depth").val(0).hide();
                }
            }

            switch (scope) {
                case 'Sealcoat':
                    hide_driveway_fields();
                    hide_existing_fields();
                    hide_new_and_existing_commons();
                    sealcoat();
                    break;
                case 'New Driveway':
                    hide_sealcoat_fields();
                    hide_existing_fields();
                    new_driveway();
                    break;
                case 'Pave Existing':
                    hide_sealcoat_fields();
                    hide_driveway_fields();
                    pave_existing();
                    break;
            }
        }

        //initialize
        $(".form-item-14").each(function () {
            var form = $(this);
            form_14_logic(form);
            $(this).find('.field-type select').change(function () {
                form_14_logic(form);
            });
            $(this).find('.field-driveway_repair select').change(function () {
                form_14_logic(form);
            });
            $(this).find('.field-remove_existing select').change(function () {
                form_14_logic(form);
            });
            $(this).find('.field-base_gravel select').change(function () {
                form_14_logic(form);
            });
            $(this).find('.field-base_asphalt select').change(function () {
                form_14_logic(form);
            });
            $(this).find('.field-excavation select').change(function () {
                form_14_logic(form);
            });
            $(this).find('.field-crack_sealing select').change(function () {
                form_14_logic(form);
            });
        });

        function form_2_logic(form) {
            var repair_type = form.find(".field-repair_type select").val();
            if (repair_type == 'Milling') {
                form.find(".field-base_depth").hide();
                if (form.find(".field-base_depth input").val() == '') {
                    form.find(".field-base_depth input").val('0');
                }
                form.find(".field-seal_patch_edges").hide();
                form.find(".field-surface_depth").hide();
                if (form.find(".field-surface_depth input").val() == '') {
                    form.find(".field-surface_depth input").val('0');
                }
                form.find(".field-base_material").hide();
                form.find(".field-base_material select").val('Enter Your Own');
                form.find(".field-custom_base input").val('None');
                form.find(".field-custom_base").hide();
                form.find(".field-surface_material").hide();
                form.find(".field-surface_material select").val('Enter Your Own');
                form.find(".field-your_surface_asphalt input").val('None');
                form.find(".field-your_surface_asphalt").hide();
                form.find(".field-seal_patch_edges select").val('No');
            } else {
                form.find(".field-base_depth").show();
                form.find(".field-seal_patch_edges").show();
                form.find(".field-surface_depth").show();
                form.find(".field-base_material").show();
                var base_material_value = form.find(".field-base_material select").val();
                if (base_material_value == 'Enter Your Own') {
                    if (form.find(".field-custom_base input").val() == 'None') {
                        form.find(".field-custom_base input").val('');
                    }
                    form.find(".field-custom_base").show();
                } else {
                    form.find(".field-custom_base input").val('None');
                    form.find(".field-custom_base").hide();
                }
                form.find(".field-surface_material").show();
                var surface_material_value = form.find(".field-surface_material select").val();
                if (surface_material_value == 'Enter Your Own') {
                    if (form.find(".field-your_surface_asphalt input").val() == 'None') {
                        form.find(".field-your_surface_asphalt input").val('');
                    }
                    form.find(".field-your_surface_asphalt").show();
                } else {
                    form.find(".field-your_surface_asphalt input").val('None');
                    form.find(".field-your_surface_asphalt").hide();
                }
            }
        }

        $(".form-item-2").each(function () {
            var form = $(this);
            form_2_logic(form);
            $(this).find('.field-base_material select').change(function () {
                form_2_logic(form);
            });
            $(this).find('.field-surface_material select').change(function () {
                form_2_logic(form);
            });
            $(this).find('.field-repair_type select').change(function () {
                form_2_logic(form);
            });
        });

        <?php } ?>
        //this is to update uniform selects
        $("select").change(function () {
            $.uniform.update();
        });
        //Automatic resend settings update
        $("#saveResendSettings").on("click", function () {
            if ($("#frequency").val() < 1 || isNaN($("#frequency").val())) {
                $("#frequency").val(1);
            }
            var data = {
                'enabled': $("#automatic_resend").val(),
                'frequency': $("#frequency").val(),
                'template': $("#template").val()
            };
            $("#saveResendSettings").val('Saving...');
            $.ajax({
                type: "POST",
                url: '<?= site_url('proposals/saveResendSettings/' . $proposal->getProposalId()) ?>',
                data: data,
                success: function () {
                    swal(
                        'Settings saved!',
                        'The resend settings saved successfully!'
                    );
                    $("#saveResendSettings").val('Save');
                },
                error: function () {
                    swal(
                        'Error',
                        'There was an error saving the information. Please contact an administration if the problem persists.'
                    );
                    $("#saveResendSettings").val('Save');
                }
            });
        });

        // Proposal Settings
        // Save settings click
        $(".saveGeneralSettings,.saveGeneralSettings1").click(function () {

            var defaultButtonText = 'Save General Settings';

            // Clear validation content
            $('input').removeClass('error');

            $('.saveGeneralSettings').button('option', 'label', 'Saving...');
            $('.saveGeneralSettings1').button('option', 'label', 'Saving...');
           
            var workOrderSetting =$("#workOrderSetting").val();
            var owner = $("#owner").val();
            var resendFrequency = $("#frequency").val();
            var automaticResend = $("#automatic_resend").val();
            var template = $("#template").val();
            var layoutOption = $('.layoutOption').val();
            if (layoutOption) {
                var proposalLayout = $("#proposalLayout").val() + layoutOption;
            } else {
                var proposalLayout = $("#proposalLayout").val();
            }
            var paymentTerm = $("#paymentTerm").val();
            var proposalSettingDate = $("#proposalSettingDate").val();
            var proposalSettingChangeDate = $("#proposalSettingChangeDate").val();
            var proposalSettingWinDate = $("#proposalSettingWinDate").val();
            var hasResend = $("#frequency").length;
            var hidden_proposal_view = ($('#hide_in_view').is(":checked")) ? 1 : 0;
            var resend_exclude = ($('#resend_exclude').is(":checked")) ? 1 : 0;

            if ((hasResend && !resendFrequency) || !paymentTerm || !proposalSettingDate || !proposalSettingChangeDate) {

                if (!resendFrequency) {
                    $("#frequency").addClass('error');
                }

                if (!paymentTerm) {
                    $("#paymentTerm").addClass('error');
                }

                if (!proposalSettingDate) {
                    $("#proposalSettingDate").addClass('error');
                }

                if (!proposalSettingChangeDate) {
                    $("#proposalSettingChangeDate").addClass('error');
                }

                swal(
                    'Error',
                    'Please enter a value for all fields'
                );

                $(".saveGeneralSettings").button('option', 'label', defaultButtonText);
                $('.saveGeneralSettings1').button('option', 'label', 'Save');
                return false;
            }
            var preProposalPopup = 0;
            if ($('#proposalLayout').val() == 'web-cool' || $('#proposalLayout').val() == 'web-standard') {
                preProposalPopup = ($('#preProposalPopup').prop('checked')) ? 1 : 0;
            }

            // if($("#proposalLayout").val() == 'gradient'){
            //     $('.individual_proposal_section_table').find('tr[data-section-code="title-page"]').addClass('unsortable');
            //     $('.individual_proposal_section_table').find('tr[data-section-code="title-page"]').prependTo('table.individual_proposal_section_table');
            // }else{
            //     $('.individual_proposal_section_table').find('tr[data-section-code="title-page"]').removeClass('unsortable');
            // }

            var postData = {
                proposalId: proposalId,
                owner: owner,
                resendFrequency: resendFrequency,
                automaticResend: automaticResend,
                template: template,
                layout: proposalLayout,
                paymentTerm: paymentTerm,
                proposalSettingDate: proposalSettingDate,
                proposalSettingChangeDate: proposalSettingChangeDate,
                proposalSettingWinDate: proposalSettingWinDate,
                hiddenProposalView: hidden_proposal_view,
                resendExclude: resend_exclude,
                preProposalPopup: preProposalPopup,
                workOrderSetting:workOrderSetting

            };

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('ajax/updateProposalSettings') ?>",
                dataType: 'json',
                data: postData
            })
                .done(function (data) {

                    if (data.loginRequired) {
                        //
                        window.onbeforeunload = null;
                        window.location.href = '/';
                        return;
                    }

                    $("#loading").hide();
                    $(".saveGeneralSettings").button('option', 'label', defaultButtonText);
                    $('.saveGeneralSettings1').button('option', 'label', 'Save');
                    if (!data.error) {

                        if($("#proposalLayout").val() != 'standard'){
                            $('.individual_proposal_section_table').find('tr[data-section-code="service-provider"]').show();
                            $('.individual_proposal_section_message').hide();
                        }else{
                            $('.individual_proposal_section_table').find('tr[data-section-code="service-provider"]').hide();
                            $('.individual_proposal_section_message').show();
                        }

                        if($("#proposalLayout").val() == 'gradient'){
                            $('.individual_proposal_section_table').find('.section_layout_name').text('Custom Layout');
                        }else{
                            $('.individual_proposal_section_table').find('.section_layout_name').text($("#proposalLayout").val() + ' Layout');
                        }

                        generalSettingsChanged = false;
                        clearEditedLabels();
                        toggleGeneralSaveButton();
                        initTiptip();
                        swal(
                            'Success',
                            'Settings Saved'
                        );
                        return;
                    }

                    swal(
                        'Error',
                        'There was a problem saving the settings'
                    );
                })
                .fail(function (xhr) {
                    $("#loading").hide();
                    $(".saveGeneralSettings").button('option', 'label', defaultButtonText);
                    $('.saveGeneralSettings1').button('option', 'label', 'Save');
                    swal(
                        'Error',
                        'There was an error saving the settings'
                    );
                });
        });

        // Links
        $("#addLink").click(function () {
            var linkName = $("#link-name").val();
            var linkUrl = $("#link-url").val();

            if (!linkName || !linkUrl) {
                swal(
                    'Error',
                    'Please enter a name and a link'
                );
                return;
            }

            $("#addLInk").button('option', 'label', 'Saving...');

            var postData = {
                proposalId: proposalId,
                linkName: linkName,
                linkUrl: linkUrl
            };

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('ajax/addProposalLink') ?>",
                dataType: 'json',
                data: postData
            })
                .done(function (data) {

                    $("#loading").hide();
                    $(".saveGeneralSettings").button('option', 'label', 'Add Link');
                    $('.saveGeneralSettings1').button('option', 'label', 'Save');

                    if (data.id) {

                        // Add to the table
                        var newContent = '' +
                            '<tr id="linkRow_' + data.id + '">' +
                            '<td>' +
                            '<a id="proposal-link-' + data.id + '" href="' + linkUrl + '" target="_blank">' + linkName + '</a>' +
                            '<div id="edit-form-' + data.id + '" style="display: none;">' +
                            '<form action="#" class="editLinkForm" data-id="' + data.id + '">' +
                            '<table class="boxed-table" width="100%" cellpadding="0" cellspacing="0">' +
                            '<tr>' +
                            '<td><input type="text" name="name" class="name" placeholder="Name" style="width: 97%;"' +
                            'value="' + linkName + '"></td>' +
                            '<td><input type="text" name="url" class="url" placeholder="http://..."' +
                            'style="width: 97%;" value="' + linkUrl + '"></td>' +
                            '<td><input type="submit" value="Save Link" class="btn small" id="saveLink"></td>' +
                            '</tr>' +
                            '</table>' +
                            '</form>' +
                            '</div>' +
                            '</td>' +
                            '<td width="150">' +
                            '<a href="#" class="btn editLink" id="editLink-' + data.id + '"' +
                            'data-id="' + data.id + '">Edit</a>' +
                            '<a href="#" class="btn cancelEditLink" style="display: none;"' +
                            'id="cancelEditLink-' + data.id + '" data-id="' + data.id + '">Cancel</a>' +
                            '<a href="#" class="btn deleteLink" data-id="' + data.id + '">Delete</a>' +
                            '</td>' +
                            '</tr>';

                        $("#linksTable").append(newContent);
                        initButtons();

                        swal(
                            'Success',
                            'Link Saved'
                        );

                        // Clear Inputs
                        $("#link-name").val('');
                        $("#link-url").val('');
                    } else {
                        swal(
                            'Error',
                            'There was a problem saving the link'
                        );
                    }

                })
                .fail(function (xhr) {
                    $("#loading").hide();
                    $(".saveGeneralSettings").button('option', 'label', 'Save Settings');
                    $('.saveGeneralSettings1').button('option', 'label', 'Save');
                    swal(
                        'Error',
                        'There was an error saving the settings'
                    );

                });

        });

        // Delete Link Dialog
        $("#confirmLinkDelete").dialog({
            autoOpen: false,
            modal: true,
            width: 400,
            buttons: {
                Confirm: function () {

                    $(this).dialog('close');
                    $("#loading").show();

                    var postData = {
                        proposalId: proposalId,
                        linkId: $("#confirmLinkDelete").data('link-id')
                    };

                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('ajax/deleteProposalLink') ?>",
                        dataType: 'json',
                        data: postData
                    })
                        .done(function (data) {
                            $("#loading").hide();

                            if (data.error) {
                                swal(
                                    'Error',
                                    'There was an error deleting the link'
                                );
                                return;
                            }

                            $("#linkRow_" + data.id).remove();

                            swal(
                                'Success',
                                'Link Deleted'
                            );
                        })
                        .fail(function (xhr) {
                            $("#loading").hide();

                            swal(
                                'Error',
                                'There was an error deleting the link: Error Information: ' + xhr.responseText
                            );
                        });
                },
                Close: function () {
                    $(this).dialog('close');
                }
            }
        });

        $(document).on("change", "#videoURL", function () {
            var videoUrl = $("#videoURL").val();
            if (videoUrl !== '') {
                var pattern = /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/;
                if (!pattern.test(videoUrl)) {
                    $('#video_link_error_msg').text('Please Enter correct URL');
                    $('#video_link_error_msg').show();
                } else {
                    $('#video_link_error_msg').hide();
                }
            } else {
                $('#video_link_error_msg').text('Please Enter URL');
                $('#video_link_error_msg').show();
            }
        });

        //Save Video
        $("#saveVideo").click(function () {
            var videoUrl = $("#videoURL").val();
            if (videoUrl !== '') {
                var pattern = /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/;
                if (!pattern.test(videoUrl)) {
                    $('#video_link_error_msg').text('Please Enter correct URL');
                    $('#video_link_error_msg').show();
                    return false;
                } else {
                    $('#video_link_error_msg').hide();
                }
            } else {
                $('#video_link_error_msg').text('Please Enter URL');
                $('#video_link_error_msg').show();
                return false;
            }

            swal({
                title: 'Saving..',
                allowEscapeKey: false,
                allowOutsideClick: false,
                timer: 10000,
                onOpen: () => {
                    swal.showLoading();
                }
            })

            var postData = {
                proposalId: proposalId,
                videoUrl: $("#videoURL").val(),
            };

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('ajax/saveProposalVideos') ?>",
                dataType: 'json',
                data: postData
            })
                .done(function (data) {

                    if (data.error) {
                        swal(
                            'Error',
                            'There was an error saving the video'
                        );
                        return;
                    }

                    swal(
                        'Success',
                        'Video Saved'
                    );


                    $("#videoURL").val('');


                    var newContent = '' +

                        '<div  data-video-id="' + data.id + '" id="video_' + data.id + '" class="video_div">' +
                        '<span class="group_checker"><input type="checkbox" id="checkbox_video_' + data.id + '"  name="videos" class="proposal_videos" value="' + data.id + '" style="float:left;"></span>' +
                        '<h3>' +
                        '<a href="#"><span id="title_' + data.id + '">' + data.title + '</span></a>' +
                        '<span title="Show In Work Order" class="superScript grey_b" id="video_header_span_workorder_' + data.id + '" style="right: 40px;position: absolute;top: 8px;display:block">WO</span>' +
                        '<span title="Show In Proposal" class="superScript grey_b" id="video_header_span_proposal_' + data.id + '" style="right: 80px;position: absolute;top: 8px;display:block">P</span>' +
                        '<a class="btn-delete close-accordion" href="#">&nbsp;</a>' +
                        '</h3>' +
                        '<div class="clearfix" style="margin-left: 25px;">' +
                        '<div class="video_left_section" style="width: 370px;margin-top: 15px;float:left;margin-bottom: 15px;">' +
                        '<div class="updateProposalVideoTitle" style="width: 370px;">' +
                        '<label for="updateProposalVideoTitle"><b>Video Title: </b></label>' +
                        '<input type="text" class="text" id="videoTitle_' + data.id + '" value="' + data.title + '" maxlength="50" name="videoTitle" >' +
                        '</div>';
                    if (data.buttonShow == 0) {
                        newContent += '<div class="is_video_added proposalVideoImageUploaderDiv" data-video-id="' + data.id + '" style="width: 350px;float:left;">' +
                            '<input accept="image/*" class="proposalVideoThumbImageUploader" type="file" name="files" data-video-id="' + data.id + '">' +
                            '</div>';
                    } else {
                        newContent += '<div style="height:35px;"></div>';
                    }
                    newContent += '<div><p ><b>Video Note: </b></p>' +
                        '<textarea rows="4" cols="45" class="text" id="video_note_' + data.id + '"></textarea>' +
                        '</div>' +
                        '<div><input type="checkbox" name="is_large_preview" id="is_large_preview_' + data.id + '"  >Use Large Video Player </div>' +
                        '<div style="width: 100%;position:relative;float:left;">' +
                        '<span style="float: left;"><input type="checkbox" name="visible_proposal" id="visible_proposal_' + data.id + '" checked >Proposal</span>' +
                        '<span style="float: right;padding-right: 20px;"><input type="checkbox" name="visible_work_order" id="visible_work_order_' + data.id + '" checked  >Work Order</span>' +
                        '</div>' +
                        '</div>' +
                        '<div class="video_right_section" style="width: 370px;margin-top: 15px;float:left;margin-bottom: 15px;">' +
                        '<div id="thumb-image-preview" class="is_video_added" style="margin-left:5px;box-shadow: rgb(60 64 67 / 30%) 0px 1px 4px 0px;padding: 10px;float:left;width: 350px;margin-bottom: 45px;">' +
                        '<div id="image-area_' + data.id + '" class="image-area" data-final-url="' + data.videoUrl + '" data-video-id="' + data.id + '" data-image-url="" data-button-show="0">';


                    if (data.buttonShow == 1) {
                        newContent += '<a href="' + data.videoUrl + '" class="btn btn-primary" style="width:180px;margin-left: 90px;" target="_blank"><i class="fa fa-fw fa-play-circle-o"></i>Play Proposal Video</a>';
                    } else {
                        newContent += '<p style="margin-top: 100px;margin-bottom: 100px;margin-left: 100px;" class="iframeLoadingImage"><img src="../../static/blue-loader.svg" alt="Loading"></p><iframe id="video-uploaded-iframe" class="embed-responsive-item" src="' + data.videoUrl + '" style="display:none;" onload="removeLoadingImage(this)" allowfullscreen loading="lazy"></iframe>';
                    }

                    newContent += '</div>' +
                        '<a class="remove-image" title="Delete thumb image" onclick="remove_saved_thumb_image(' + data.id + ')" href="javascript:void(0)" >&#215;</a>' +
                        '<a class="back-to-image" onclick="show_saved_thumb_image(this)" href="javascript:void(0)"><i class="fa fa-arrow-left"></i></a>' +
                        '</div>' +
                        '<div style="margin-top: 15px;float: left;width: 370px;position: absolute;bottom: 20px;">' +
                        '<a href="#" class="deleteVideoUrl tiptip btn" title="Delete Video" style="float: left;" data-video-id="' + data.id + '"><i class="fa fa-fw fa-trash"></i>Delete Video</a>' +
                        '<a class="btn blue-button updateVideoTitle" data-video-id="' + data.id + '" style="float: right;"><i class="fa fa-fw fa-save"></i> Update Video</a>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';

                    $("#accordion5").append(newContent);
                    $("#accordion5").sortable('refresh');
                    $("#accordion5").accordion('destroy').accordion({
                        collapsible: true,
                        active: false,
                        autoHeight: false,
                        navigation: true,
                        header: "> div > h3"
                    });

                    $('#accordion5').accordion('option', 'active', parseInt($('#accordion5 .video_div').length - 1))

                    initButtons();

                    resetAllVideoThumbUploader();
                    enable_fileupload_plugin();
                    videoCountCheck();
                    $('#uniform-masterSelect').show();
                    $('#no_videos_section').hide();
                    $('#checkbox_video_' + data.id).uniform();
                    setTimeout(function () {
                            removeLoadingImage();
                        }, 2000);


                })
                .fail(function (xhr) {
                    $("#loading").hide();

                    swal(
                        'Error',
                        'There was an error saving the Video'
                    );
                });

        });


        // Select Company Video
        $("#saveCompanyVideo").click(function () {
            var videoIds = $("#company_video").val();
            if (!videoIds) {

                saveVideoUrl();
                // $('#video_link_error_msg').text('Please Select Video');
                // $('#video_link_error_msg').show();
                return false;
            }

            swal({
                title: 'Saving..',
                allowEscapeKey: false,
                allowOutsideClick: false,
                timer: 10000,
                onOpen: () => {
                    swal.showLoading();
                }
            })

            var postData = {
                proposalId: proposalId,
                videoIds: videoIds,
            };

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('ajax/saveSelectedCompanyProposalVideos') ?>",
                dataType: 'json',
                data: postData
            })
                .done(function (data) {

                    if (data.error) {
                        swal(
                            'Error',
                            'There was an error saving the video'
                        );
                        return;
                    }

                    swal(
                        'Success',
                        'Video Saved'
                    );


                    for ($i = 0; $i < data.videoDetails.length; $i++) {

                        var new_video_id = data.videoDetails[$i].id;
                        var new_video_title = data.videoDetails[$i].title;
                        var buttonShow = data.videoDetails[$i].buttonShow;
                        var new_videoUrl = data.videoDetails[$i].videoUrl;
                        var new_videoThumbImagePath = data.videoDetails[$i].thumbImagePath;
                        var companyVideoId = data.videoDetails[$i].companyVideoId;
                        var videoIsIntro = data.videoDetails[$i].videoIsIntro;
                        var new_video_player_icon_hide = data.videoDetails[$i].player_icon;
                        var display_remove_thumb_icon = '';
                        var checked_intro = '';

                        if(videoIsIntro){
                            checked_intro = 'checked';
                        }

                        var newContent = '' +

                            '<div  data-video-id="' + new_video_id + '" id="video_' + new_video_id + '" class="video_div">' +
                            '<span class="group_checker"><input type="checkbox" id="checkbox_video_' + new_video_id + '"  name="videos" class="proposal_videos" value="' + new_video_id + '" style="float:left;"></span>' +
                            '<h3>' +
                            '<a href="#"><span id="title_' + new_video_id + '">' + new_video_title + '</span></a>' +
                            '<span title="Show In Work Order" class="superScript grey_b tiptip" id="video_header_span_workorder_' + new_video_id + '" style="right: 40px;position: absolute;top: 8px;display:block">WO</span>' +
                            '<span title="Show In Proposal" class="superScript grey_b tiptip" id="video_header_span_proposal_' + new_video_id + '" style="right: 80px;position: absolute;top: 8px;display:block">P</span>' +
                            '<span title="Large Player" class="superScript grey_b tiptip" id="video_header_span_large_player_' + new_video_id + '" style="right: 107px;position: absolute;top: 8px;display:none">Large Player</span>' +
                            '<span title="Intro Video" class="superScript grey_b tiptip intro_badge" id="video_header_span_is_intro_' + new_video_id + '" style="right: 190px;position: absolute;top: 8px;display:none">Intro</span>'+
                            '<a class="btn-delete close-accordion" href="#">&nbsp;</a>' +
                            '</h3>' +
                            '<div class="clearfix" style="margin-left: 25px;">' +
                            '<div class="video_left_section" style="width: 310px;margin-top: 15px;float:left;margin-bottom: 15px;">' +
                            '<div class="updateProposalVideoTitle" style="width: 310px;">' +
                            '<label for="updateProposalVideoTitle"><b>Video Title: </b></label>' +
                            '<input type="text" class="text" id="videoTitle_' + new_video_id + '" value="' + new_video_title + '" maxlength="50" name="videoTitle" >' +
                            '</div>'+
                            '<div style="width: 100%;position:relative;float:left;margin-top: 20px;display: grid;">' +
                            '<label for=""><b>Video Setting: </b></label>'+
                            '<p style="float: left;margin: 5px 0px 5px 13px;"><input type="checkbox" class="is_intro" data-video-id="' + new_video_id + '" name="is_intro" id="is_intro_' + new_video_id + '" '+checked_intro+' ><span style="float: left;margin-top: 2px;width:100px;">Intro Video</span><input type="checkbox" name="visible_proposal" id="visible_proposal_' + new_video_id + '" checked> <span style="float: left;margin-top: 2px;width:100px;">Proposal</span></p>'+
                            '<p style="float: left;margin: 5px 0px 5px 13px;"><input type="checkbox" name="is_large_preview" id="is_large_preview_' + new_video_id + '" '+checked_intro+' ><span style="float: left;margin-top: 2px;width:100px;">Large Player </span><input type="checkbox" name="visible_work_order" id="visible_work_order_' + new_video_id + '" checked><span style="float: left;margin-top: 2px;width:100px;">Work Order</span></p>' +
                            '</div>';

                        if (buttonShow == 0) {
                            newContent += '<div class="is_video_added proposalVideoImageUploaderDiv" data-video-id="' + new_video_id + '" style="width: 120px;float:left;">' +
                                '<input accept="image/*" class="proposalVideoThumbImageUploader" type="file" name="files" data-video-id="' + new_video_id + '">' +
                                '</div>';
                        } else {
                            newContent += '<div style="height:35px;"></div>';
                        }

                        var diaplayPlayerIconDiv = 'none';
                        var diaplayPlayerIconImage = 'block';
                        var checked_player_icon_hide = '';
                        if (new_videoThumbImagePath) {
                            diaplayPlayerIconDiv = 'block';
                            if(new_video_player_icon_hide){
                                 checked_player_icon_hide = 'checked';
                                 diaplayPlayerIconImage = 'none';
                            }
                        }

                        newContent +=   '<div class="playerIconDiv" data-video-id="' + new_video_id + '" style="float:left;width: 100%;display:'+diaplayPlayerIconDiv+';">'+
                                    '<p style="margin-top: 15px;margin-bottom: 7px;"><strong>Player Icon</strong></p>'+
                                    '<input type="checkbox" name="player_icon_hide" class="player_icon_hide" data-video-id="' + new_video_id + '" id="player_icon_hide' + new_video_id + '" '+checked_player_icon_hide+' >Hide'+
                                    '</div>'+
                                    '<div class="playerIconColorDiv" data-video-id="' + new_video_id + '" style="float:left;width: 100%;display:'+diaplayPlayerIconDiv+';">'+
                                    '<p style="margin-top: 15px;margin-bottom: 7px;"><strong>Player Icon Color</strong></p>'+
                                    '<input type="radio" class="dont-uniform " name="player_icon_color_' + new_video_id + '" id="one_label_' + new_video_id + '" value="0" />'+
                                    '<label data-color="0" for="one_label_' + new_video_id + '"><span class="blue"></span></label>'+
                                    '<input type="radio" class="dont-uniform " name="player_icon_color_' + new_video_id + '" id="two_label_' + new_video_id + '" value="1" />'+
                                    '<label data-color="1" for="two_label_' + new_video_id + '"><span class="white"></span></label>'+
                                    '<input type="radio" class="dont-uniform " name="player_icon_color_' + new_video_id + '" id="three_label_' + new_video_id + '" value="2" />'+
                                    '<label data-color="2" for="three_label_' + new_video_id + '"><span class="black"></span></label>'+
                                    '<input type="radio" class="dont-uniform " name="player_icon_color_' + new_video_id + '" id="four_label_' + new_video_id + '" value="3" />'+
                                    '<label data-color="3" for="four_label_' + new_video_id + '"><span class="red"></span></label>'+
                                    '</div>';



                        newContent +=   '</div>' +
                                        '<div class="video_right_section" style="width: 430px;float:left;margin-bottom: 15px;">' +
                                        '<div id="thumb-image-preview" class="is_video_added" style="margin-left:5px;box-shadow: rgb(60 64 67 / 30%) 0px 1px 4px 0px;padding: 10px;float:left;width: 410px;margin-bottom: 45px;">' +
                                        '<div id="image-area_' + new_video_id + '" class="image-area" data-final-url="' + new_videoUrl + '" data-video-id="' + new_video_id + '" data-image-url="" data-button-show="0" data-proposal-thumb-image="" data-company-video-id="' + companyVideoId + '">';


                        if (buttonShow == 1) {
                            newContent += '<a href="' + new_videoUrl + '" class="btn btn-primary" style="width:180px;margin-left: 90px;" target="_blank"><i class="fa fa-fw fa-play-circle-o"></i>Play Proposal Video</a>';
                        } else {
                            if (new_videoThumbImagePath) {


                                newContent += '<img id="thumb_preview_img" src="' + new_videoThumbImagePath + '" style="">' +
                                    '<div class="play-overlay" id="player_overlay'+new_video_id+'" style="display:'+diaplayPlayerIconImage+';">' +
                                    '<a href="javascript:void(0)" class="play-icon">' +
                                    '<img style="width: 70px;" src="<?php echo site_url('static/images/video-player-icon.png') ?>">' +
                                    '</a>' +
                                    '</div>';


                                newContent += '<!-- <iframe class="embed-responsive-item" src="' + new_videoUrl + '?autoplay=1" allowfullscreen loading="lazy" allow="autoplay"></iframe> -->';


                                display_remove_thumb_icon = 'style="display:none;"';


                            } else {


                                newContent += '<p style="margin-top: 100px;margin-bottom: 100px;margin-left: 100px;" class="iframeLoadingImage"><img src="../../static/blue-loader.svg" alt="Loading"></p><iframe id="video-uploaded-iframe" class="embed-responsive-item" src="' + new_videoUrl + '" style="display:none;" onload="removeLoadingImage(this)" allowfullscreen loading="lazy"></iframe>';
                            }

                        }

                        newContent += '</div>' +
                            '<a class="remove-image" title="Delete thumb image" ' + display_remove_thumb_icon + ' onclick="remove_saved_thumb_image(' + new_video_id + ')" href="javascript:void(0)" >&#215;</a>' +
                            '<a class="back-to-image" onclick="show_saved_thumb_image(this)" href="javascript:void(0)"><i class="fa fa-arrow-left"></i></a>' +
                            '</div>' +
                            '<div style="margin-top: 15px;float: left;width: 430px;position: absolute;bottom: 20px;">' +
                            '<a href="#" class="deleteVideoUrl tiptip btn" title="Delete Video" style="float: left;" data-video-id="' + new_video_id + '"><i class="fa fa-fw fa-trash"></i>Delete Video</a>' +
                            '<a href="javascript:void(0)" class="deleteThumbnail tiptip btn" title="Delete thumb image" style="margin-left: 29px;font-size: 13px;float: left;display:none" data-video-id="' + new_video_id + '" onclick="remove_saved_thumb_image(' + new_video_id + ')"><i class="fa fa-fw fa-trash"></i>Delete Thumbnail</a>' +
                            '<a class="btn blue-button updateVideoTitle" data-video-id="' + new_video_id + '" style="float: right;"><i class="fa fa-fw fa-save"></i> Update Video</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>';



                        $("#accordion5").append(newContent);

                        setTimeout(function () {
                            removeLoadingImage();
                        }, 2000);
                        $('#checkbox_video_' + new_video_id).uniform();

                    }

                    $("#accordion5").sortable('refresh');
                    $("#accordion5").accordion('destroy').accordion({
                        collapsible: true,
                        active: false,
                        autoHeight: false,
                        navigation: true,
                        header: "> div > h3"
                    });

                    $('#accordion5').accordion('option', 'active', parseInt($('#accordion5 .video_div').length - 1))

                    initButtons();
                    initTiptip();
                    videoCountCheck();
                    resetAllVideoThumbUploader();
                    enable_fileupload_plugin();
                    $('#uniform-masterSelect').show();
                    $('#no_videos_section').hide();
                    $('.select2_company_videos').val('').trigger('change');

                    $('#is_large_preview_' + new_video_id).uniform();
                    $('#visible_proposal_' + new_video_id).uniform();
                    $('#visible_work_order_' + new_video_id).uniform();
                    $('#is_intro_' + new_video_id).uniform();
                    $('#player_icon_hide' + new_video_id).uniform();

                })
                .fail(function (xhr) {
                    $("#loading").hide();

                    swal(
                        'Error',
                        'There was an error saving the Video'
                    );
                });

        });

        $("#removeVideo").click(function () {
            swal({
                title: "Are you sure?",
                text: "This will remove Video Link",
                showCancelButton: true,
                confirmButtonText: 'Remove',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function (isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Removing..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                            swal.showLoading();
                        }
                    })
                    var postData = {
                        proposalId: proposalId,
                    };

                    $.ajax({
                        type: "POST",
                        url: "<?php echo site_url('ajax/removeProposalVideo') ?>",
                        dataType: 'json',
                        data: postData
                    })
                        .done(function (data) {

                            if (data.error) {
                                swal(
                                    'Error',
                                    'There was an error saving the video'
                                );
                                return;
                            }

                            swal(
                                'Success',
                                'Video Removed'
                            );
                            $("#videoURL").val('');
                            $(".image-area").html('');
                            $('#thumb-image-section').hide();
                            $("#removeVideo").hide();
                            $("#saveVideo").show();
                        })
                        .fail(function (xhr) {
                            $("#loading").hide();

                            swal(
                                'Error',
                                'There was an error saving the Video'
                            );
                        });
                } else {
                    swal("Cancelled", "Your Video is safe :)", "error");
                }
            });

        });

        // Check for changed general settings
        $(".generalSetting").change(function () {

            $(this).closest('tr').find('td:first label').addClass('editedLabel');

            generalSettingsChanged = true;
            toggleGeneralSaveButton();
            toggleCustomLayout();
        });

        // // Check for changed general settings
        // $(".videoLayoutSetting").change(function () {

        //     videoSettingsChanged = true;
            
        // });

        // Activity Datatable
        var activityTable = $("#editProposalActivity").dataTable({
            "order": [
                [1, "desc"]
            ],
            "bProcessing": true,
            "serverSide": true,
            "ajax": {
                "url": "<?php echo site_url('ajax/proposalHistory/' . $proposal->getProposalId()); ?>"
            },
            "aoColumns": [{
                'bVisible': false
            },
                {
                    'bSearchable': false,
                    'iDataSort': 0
                },
                null,
                {
                    'bSortable': false
                },
                {
                    'bSortable': false
                }
            ],
            "bJQueryUI": true,
            "bAutoWidth": true,
            "sPaginationType": "full_numbers",
            "sDom": 'HfltiprF',
            "aLengthMenu": [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ]
        });

        // Custom Texts
        checkCustomTextHeadings();
        toggleCustomLayout();


        // Add a note
        $("#addNote").click(function () {

            var noteText = $("#noteText").val();

            if (!noteText) {
                alert('Please enter your note text');
                return false;
            }

            $.ajax({
                url: '<?php echo site_url('ajax/addNote') ?>',
                type: "POST",
                data: {
                    "noteText": $("#noteText").val(),
                    "noteType": 'proposal',
                    "relationId": proposalId
                },
                dataType: "json",
                success: function (data) {
                    if (data.success) {

                        //refresh frame
                        $("#noteText").val('');
                        $('#notesFrame').attr('src', $('#notesFrame').attr('src'));
                    } else {
                        if (data.error) {
                            alert("Error: " + data.error);
                        } else {
                            alert('An error has occurred. Please try again later!')
                        }
                    }
                }
            });
        });

        // Require form validation
        $("#addFileForm").validate();

        $(document).on('keyup keypress change','.videoLayoutSetting', function (e) {
            videoSettingsChanged = true;
        });

        // Add a project attachment
        $(document).on('submit', '#addFileForm', function (e) {
            e.preventDefault();

            $("#attachmentUploadPct").text('');
            $("#uploadingProjectAttachment").show();

            var formData = new FormData($('#addFileForm')[0]);

            $.ajax({
                type: 'POST',
                url: '<?php echo site_url('ajax/uploadProjectAttachment/' . $proposal->getProposalId()); ?>',
                processData: false,
                contentType: false,
                cache: false,
                data: formData,
                dataType: 'json',
                xhr: function () {
                    var xhr = new window.XMLHttpRequest();
                    // Handle progress
                    xhr.upload.addEventListener("progress", function (evt) {
                        if (evt.lengthComputable) {
                            var percentComplete = Math.floor((evt.loaded / evt.total) * 100);
                            //Do something with upload progress
                            $("#attachmentUploadPct").text(percentComplete);
                        }
                    }, false);
                    return xhr;
                }
            })
                .done(function (data) {
                    if (data.error) {
                        $("#uploadingProjectAttachment").hide();
                        swal(
                            'Error',
                            data.text
                        );
                        return false;
                    } else {
                        // Success, add to accordion
                        var newContent = '' +
                            '<div id="attachment_' + data.id + '">' +
                            '<h3>' +
                            '<a href="#"><span id="attachmentTitle_' + data.id + '">' + data.fileName + '</span></a>' +
                            '<a class="btn-delete close-accordion" href="#">&nbsp;</a>' +
                            '</h3>' +
                            '<div>' +
                            '<form class="big update-attachment-form" action="#' + data.id + '">' +
                            '<p class="clearfix">' +
                            '<label>File Name</label>' +
                            '<input type="text" name="attachment" id="attachmentName_' + data.id + '" value="' + data.fileName + '">' +
                            '</p>' +
                            '<p class="clearfix">' +
                            '<label>Proposal</label>' +
                            '<input type="checkbox" name="input" id="attachmentProposal_' + data.id + '">' +
                            '<span class="clearfix"></span>' +
                            '<label>Work Order</label>' +
                            '<input type="checkbox" name="input" id="attachmentWorkOrder_' + data.id + '">' +
                            '<span class="clearfix"></span>' +
                            '<label>Store</label>' +
                            '<input type="checkbox" name="input" checked="checked">' +
                            '</p>' +
                            '<p class="clearfix">' +
                            '<a class="btn update-button updateIcon update-attachment-button"' +
                            ' style="margin-right: 10px;">Update</a>' +
                            '<a class="btn deleteIcon delete-attachment-button"' +
                            'id="delete' + data.id + '" style="margin-right: 10px;">Delete</a>' +
                            '<a class="btn notesIcon" target="_blank" type="button"' +
                            'href="<?php echo base_url() ?>uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + data.file + '">View File</a>' +
                            '</p>' +
                            '<p id="updating_' + data.id + '" class="clearfix" style="margin: 0 !important;"></p>' +
                            '</form>' +
                            '</div>';

                        $("#accordion4").append(newContent);
                        $("#accordion4").sortable('refresh');
                        $("#accordion4").accordion('destroy').accordion({
                            collapsible: true,
                            active: -1,
                            autoHeight: false,
                            navigation: true,
                            header: "> div > h3"
                        });

                        initButtons();

                        // Reset the form
                        $("#addFileForm")[0].reset();

                        // Hide message
                        $("#uploadingProjectAttachment").hide();

                        // Display Message
                        swal(
                            'Success',
                            'Attachment Uploaded'
                        );
                    }
                })
                .fail(function () {
                    $("#uploadingProjectAttachment").hide();
                    swal(
                        'Error',
                        'There was an error trying to save the attachment'
                    );
                });
        });

        $(document).on('click', '.update-attachment-button', function () {
            var form = $(this).parents('form:first');
            form.submit();
        });

        // Update an attachemnt
        $(document).on('submit', '.update-attachment-form', function (e) {
            e.preventDefault();
            console.log('here');
            var attachmentId = $(this).attr('action').replace('#', '');
            $("#updating_" + attachmentId).html('Please wait, Updating').show();
            var fileName = $("#attachmentName_" + attachmentId).val();
            var proposal = 0;
            if ($("#attachmentProposal_" + attachmentId).attr('checked') == 'checked') {
                proposal = 1;
            }
            var workOrder = 0;
            if ($("#attachmentWorkOrder_" + attachmentId).attr('checked') == 'checked') {
                workOrder = 1;
            }
            $.ajax({
                url: "<?php echo site_url('ajax/updateProposalAttachment') ?>",
                type: "POST",
                data: {
                    "id": attachmentId,
                    "fileName": fileName,
                    "proposal": proposal,
                    "work_order": workOrder
                },
                success: function () {
                    setTimeout(function () {
                        $("#updating_" + attachmentId).html('Updated').fadeOut('slow');
                    }, 1000);
                    $("#attachmentTitle_" + attachmentId).html(fileName);
                }
            });
            return false;
        });


        // Delete an attachment
        $(document).on('click', '.delete-attachment-button', function () {
            var attachmentId = $(this).attr('id').replace('delete', '');
            $("#confirmAttachmentDelete").data('delete-id', attachmentId);
            $("#confirmAttachmentDelete").dialog('open');
            return false;
        });

        // Delete Image Dialog
        $("#confirmAttachmentDelete").dialog({
            autoOpen: false,
            modal: true,
            width: 400,
            buttons: {
                Confirm: {
                    class: 'update-button deleteIcon',
                    text: 'Delete Attachment',
                    click: function () {

                        $(this).dialog('close');

                        $.ajax({
                            type: "GET",
                            url: "<?php echo site_url('ajax/deleteProposalAttachment') ?>/" + $("#confirmAttachmentDelete").data('delete-id'),
                            dataType: 'json'
                        })
                            .done(function (data) {

                                if (data.error) {
                                    swal(
                                        'Error',
                                        'There was an error deleting the attachment'
                                    );
                                    return;
                                } else {
                                    $("#attachment_" + data.id).effect('highlight', 'slow').remove();
                                    $('#accordion4').accordion('refresh');

                                    swal(
                                        'Success',
                                        'Attachment Deleted'
                                    );
                                }
                            })
                            .fail(function () {
                                swal(
                                    'Error',
                                    'There was an error deleting the attachment'
                                );
                            });
                    }
                },
                Close: {
                    class: 'closeIcon',
                    text: 'Cancel',
                    click: function () {
                        $(this).dialog('close');
                    }
                }
            }
        });

        $(".CTCheckNone, .CTCheckAll").click(function () {
            if ($(this).hasClass('CTCheckAll')) {
                $(this).closest('div').find('.customTextCheckbox').attr('checked', 'checked');
            } else {
                $(this).closest('div').find('.customTextCheckbox').removeAttr('checked');
            }
            $(".customTextCheckbox:first").change();
            $.uniform.update();
            return false;
        });

        $(".customTextCheckbox").change(function () {
            var texts = '';
            $(".customTextCheckbox").each(function () {
                if ($(this).attr('checked')) {
                    if (texts != '') {
                        texts = texts + ',';
                    }
                    texts = texts + $(this).attr('id');
                }
            });
            var request = $.ajax({
                url: "<?php echo site_url('ajax/updateProposalTexts') ?>",
                type: "POST",
                async: false,
                data: {
                    "proposal": <?php echo $proposal->getProposalId() ?>,
                    "texts": texts
                },
                dataType: "html",
                success: function (data) {
                },
                error: function () {
                    alert('An error has occurred. Please try again later.');
                }
            });
        });

        // Work Order Notes //

        // Editor
        //var workOrderNotes = CKEDITOR.replace('workOrderNotes');
        tinymce.init({
            selector: "#workOrderNotes",
            menubar: false,
            relative_urls: false,
            elementpath: false,
            remove_script_host: false,
            convert_urls: true,
            browser_spellcheck: true,
            contextmenu: false,
            paste_as_text: true,
            height: '320',
            plugins: "link image code lists paste preview ",
            toolbar: tinyMceMenus.email,
            forced_root_block_attrs: tinyMceMenus.root_attrs,
            fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
        });

        // Saving
        $("#saveWorkOrderNotes").click(function () {

            //var workOrderNotesText = CKEDITOR.instances.workOrderNotes.getData();
            var workOrderNotesText = tinymce.get("workOrderNotes").getContent();

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('ajax/updateProposalWorkOrderNotes') ?>",
                data: {
                    proposalId: proposalId,
                    workOrderNotes: workOrderNotesText
                },
                dataType: 'json'
            })
                .done(function (data) {

                    if (data.error) {
                        swal(
                            'Error',
                            'There was an error saving the notes'
                        );
                        return;
                    } else {
                        swal(
                            'Success',
                            'Notes Saved'
                        );
                    }
                })
                .fail(function () {
                    swal(
                        'Error',
                        'There was an error saving the notes'
                    );
                });

        });

        // Custom signees
        $("#clientSigOfficePhone, #clientSigCellPhone, #companySigOfficePhone, #companySigCellPhone").mask("999-999-9999");

        // $("iframe").each(function() {
        //     //Using closures to capture each one
        //     var iframe = $(this);
        //     iframe.on("load", function() { //Make sure it is fully loaded
        //         iframe.contents().click(function(event) {
        //             iframe.trigger("click");
        //             console.log('click1');
        //         });
        //     });

        //     iframe.click(function() {
        //         //Handle what you need it to do
        //         console.log('click2');
        //     });
        // });

        // enable fileupload plugin
        fileuploader = $('#proposalImageUploader').fileuploader({
            enableApi: true,
            limit: fileUploaderImageUploadLimit,
            maxSize: 60,
            fileMaxSize: 20,
            extensions: ['jpg', 'png', 'jpeg', 'heif', 'heic', 'tiff', 'tif', 'gif'],
            dialogs: {
                // alert dialog
                alert: function (text) {
                    return swal('', text)
                    // alert(text);
                },

                // confirm dialog
                confirm: function (text, callback) {
                    confirm(text) ? callback() : null;
                }
            },
            // Callback fired on selecting and processing a file
            onSelect: function (item, listEl, parentEl, newInputEl, inputEl) {
                // callback will go here
                // console.log(item)
                // console.log(parentEl)
                // console.log(inputEl)
            },
            upload: {
                url: "<?php echo site_url('ajax/proposalSaveImage2') ?>",

                data: null,
                type: 'POST',
                enctype: 'multipart/form-data',
                start: true,
                synchron: true,

                beforeSend: function (item) {

                    item.upload.data.proposalId = '<?= $proposal->getProposalId(); ?>';
                },
                onSuccess: function (result, item) {
                    var companyId = '<?php echo $proposal->getOwner()->getCompanyId(); ?>';
                    var proposalId = '<?php echo $proposal->getProposalId(); ?>';
                    var data = JSON.parse(result),
                        nameWasChanged = false;

                    // get the new file name
                    if (data.isSuccess) {

                        item.html.find('.column-title div').animate({
                            opacity: 0
                        }, 400);
                        item.html.find('.column-actions').append('<a class="fileuploader-action fileuploader-action-remove fileuploader-action-success" title="Remove"><i></i></a>');
                        setTimeout(function () {
                            item.html.find('.column-title div').attr('title', item.name).text(item.name).animate({
                                opacity: 1
                            }, 400);
                            item.html.find('.progress-bar2').fadeOut(400);
                        }, 400);

                        var newContent = '' +

                            '<div data-image-id="' + data.id + '" id="image_' + data.id + '" class="image_div">' +
                            '<span class="group_checker"><input type="checkbox" id="checkbox_image_' + data.id + '"  name="images" class="proposal_images" value="' + data.id + '" style="float:left;"></span>' +
                            '<h3>' +
                            '<a href="#"><span id="title_' + data.id + '">Image</span></a>' +
                            '<span title="Show In Work Order" class="superScript grey_b" id="header_span_workorder_' + data.id + '" style="right: 68px;position: absolute;top: 6px;display:block">WO</span>' +
                            '<span title="Show In Proposal" class="superScript grey_b" id="header_span_proposal_' + data.id + '" style="right: 101px;position: absolute;top: 6px;display:block">P</span>' +
                            '<span title="1 Image Per Page" class="superScript grey_b tiptip" id="header_span_image_' + data.id + '" style="right: 30px;position: absolute;top: 6px;">1 <i class="fa fa-fw fa-picture-o"></i></span>' +
                            '<a class="btn-delete close-accordion" href="#">&nbsp;</a>' +
                            '</h3>' +
                            '<form class="big update-title-form form-validated imgForm" style="padding: 2px 5px !important;">' +
                            '<div class="clearfix">' +
                            '<div style="width: 155px; float: left">' +
                            '<a href="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + data.path + '?' + Math.random() +
                            '" class="fancybox">' +
                            '<img id="img_' + data.id + '" style="height: auto; width: 150px;" ' +
                            'src="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + data.path + '?' + Math.random() +
                            '" alt="" title="Click to enlarge" class="tiptip"></a>' +
                            '</div>' +
                            '<div style="width: 200px; float: left">' +
                            '<p class="clearfix" style="margin-top: 10px;">' +
                            '<label style="width: 40px; margin: 0 5px 0 0; line-height: 20px;">Title</label>' +
                            '<input type="text" name="title" class="required" id="title2_' + data.id + '" ' +
                            'value="Image">' +
                            '</p>' +
                            '<p class="clearfix">' +
                            '<label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;"' +
                            'for="active_' + data.id + '">Proposal</label>' +
                            '<input type="checkbox" name="active" id="active_' + data.id + '" checked="checked">' +
                            '<span class="clearfix"></span>' +
                            '<label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;"' +
                            'for="activewo_' + data.id + '">Work Order</label>' +
                            '<input type="checkbox" name="active"' +
                            'id="activewo_' + data.id + '" checked="checked">' +
                            '<div class="clearfix"></div>' +
                            '<select name="images_layout" id="images_layout_' + data.id + '" style="float: left; opacity: 0;" tabindex="7">' +
                            '<option value="0">1 Image Per Page</option>' +
                            '<option value="1">2 Images Per Page</option>' +
                            '<option value="2">4 Images Per Page</option>' +
                            '</select>' +

                            '</p>' +
                            '<p id="updating_' + data.id + '" class="imageUpdating"></p>' +
                            '</div>' +
                            '<div class="clearfix"></div>' +
                            '<div class="clearfix" style="padding: 10px 0 0;">' +
                            '<div style="width: 150px; float: left; text-align: center;">' +
                            '<a style="float: left; margin-left: 45px; font-size: 26px; color: #000;"' +
                            'class="rotateImage rotateLeft tiptip"' +
                            'rel="' + data.id + '" title="Rotate Left" href="#">' +
                            '<i class="fa fa-fw fa-rotate-left"></i>' +
                            '</a>' +
                            '<a style="float: left; font-size: 26px; color: #000;" class="rotateImage rotateRight tiptip"' +
                            'rel="' + data.id + '" title="Rotate Right" href="#">' +
                            '<i class="fa fa-fw fa-rotate-right"></i>' +
                            '</a>' +
                            '</div>' +
                            '<div style="width: 205px; float: left" class="clearfix">' +
                            '<p class="clearfix">' +
                            '<a href="#" class="tiptip btn delete-image-button deleteIcon" ' +
                            'data-image-id="' + data.id + '" title="Delete" data-delete-id="' + data.id + '" style="margin-right: 8px;margin-left: 10px;">' +
                            '</a>' +
                            '<a class="btn image-notes notesIcon tiptip" type="button" title="Notes" id="notes-' + data.id + '" style="margin-right: 8px;"></a>' +
                            '<a href="#" class="tiptip btn image-editor-btn editIcon" ' +
                            'data-imageid="' + data.id + '" data-imagename="'+data.path+'" data-imageurl="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + data.path + '" title="Edit Image" id="image-crop-' + data.id + '" data-delete-id="' + data.id + '" style="margin-right: 8px;">' +
                            '</a>' +
                            '<a href="#" class="btn update-image-button update-button saveIcon" data-image-id="' + data.id + '" style="margin-left: 10px;float:right">' +
                            'Update' +
                            '</a>' +
                            '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</form>';

                        $("#accordion3").append(newContent);
                        $("#accordion3").sortable('refresh');
                        $("#accordion3").accordion('destroy').accordion({
                            collapsible: true,
                            active: -1,
                            autoHeight: false,
                            navigation: true,
                            header: "> div > h3"
                        });
                        // if(len==image_uploaded_count){
                        //     $("#imageUploading").hide();
                        // }

                        imageCountCheck();
                        initButtons();
                        initTiptip();
                        // $('#accordion3 input:checkbox').uniform();
                        $('#checkbox_image_' + data.id).uniform();
                        $('#images_layout_' + data.id).uniform();
                    } else {
                        console.log(data)
                        if (data.warnings) {
                            swal('', 'File Not Uploaded<br>Error:' + data.warnings[0], "error")
                        }

                        var progressBar = item.html.find('.progress-bar2');

                        // make HTML changes
                        if (progressBar.length > 0) {
                            progressBar.find('span').html(0 + "%");
                            progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
                            item.html.find('.progress-bar2').fadeOut(400);
                        }

                        item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
                            '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
                        ) : null;
                    }
                },
                onError: function (item) {
                    var progressBar = item.html.find('.progress-bar2');

                    // make HTML changes
                    if (progressBar.length > 0) {
                        progressBar.find('span').html(0 + "%");
                        progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
                        item.html.find('.progress-bar2').fadeOut(400);
                    }

                    item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
                        '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
                    ) : null;
                },
                onProgress: function (data, item) {
                    var progressBar = item.html.find('.progress-bar2');

                    // make HTML changes
                    if (progressBar.length > 0) {
                        progressBar.show();
                        progressBar.find('span').html(data.percentage + "%");
                        progressBar.find('.fileuploader-progressbar .bar').width(data.percentage + "%");
                    }
                },
                onComplete: function (listEl, parentEl, newInputEl, inputEl, jqXHR, textStatus) {

                    setTimeout(reset_uploader(), 300);
                },
            },
            onRemove: function (item) {
                // send POST request
                $.post('./php/ajax_remove_file.php', {
                    file: item.name
                });
            },

            captions: $.extend(true, {}, 'Test', {
                feedback: 'Choose file to upload',
                or: '',
                button: 'Add Images'
            })
        });


        // enable fileupload plugin
        mapfileuploader = $('#proposalMapImageUploader').fileuploader({
            enableApi: true,
            limit: fileUploaderMapImageUploadLimit,
            maxSize: 60,
            fileMaxSize: 20,
            extensions: ['jpg', 'png', 'jpeg', 'heif', 'heic', 'tiff', 'tif', 'gif'],
            dialogs: {
                // alert dialog
                alert: function (text) {
                    return swal('', text)
                    // alert(text);
                },

                // confirm dialog
                confirm: function (text, callback) {
                    confirm(text) ? callback() : null;
                }
            },
            // Callback fired on selecting and processing a file
            onSelect: function (item, listEl, parentEl, newInputEl, inputEl) {
                // callback will go here
                // console.log(item)
                // console.log(parentEl)
                // console.log(inputEl)
            },
            upload: {
                url: "<?php echo site_url('ajax/proposalSaveMapImage') ?>",

                data: null,
                type: 'POST',
                enctype: 'multipart/form-data',
                start: true,
                synchron: true,

                beforeSend: function (item) {

                    item.upload.data.proposalId = '<?= $proposal->getProposalId(); ?>';
                },
                onSuccess: function (result, item) {
                    var companyId = '<?php echo $proposal->getOwner()->getCompanyId(); ?>';
                    var proposalId = '<?php echo $proposal->getProposalId(); ?>';
                    var data = JSON.parse(result),
                        nameWasChanged = false;

                    // get the new file name
                    if (data.isSuccess) {

                        item.html.find('.column-title div').animate({
                            opacity: 0
                        }, 400);
                        item.html.find('.column-actions').append('<a class="fileuploader-action fileuploader-action-remove fileuploader-action-success" title="Remove"><i></i></a>');
                        setTimeout(function () {
                            item.html.find('.column-title div').attr('title', item.name).text(item.name).animate({
                                opacity: 1
                            }, 400);
                            item.html.find('.progress-bar2').fadeOut(400);
                        }, 400);

                        var service_select_option = '<label style="margin: 0 5px 0 0; line-height: 20px;">Move Map To Service</label><select  class="select_service_map" name="select_service_map" id="select_service_map_' + data.id + '"><option value="" selected>Select Service To Move</option>';
                        <?php
                            foreach ($proposal_services as $service) {
                                if(!in_array($service->getServiceId(),$mapServicesIds)){?>
                                     service_select_option += '<option value="<?=$service->getServiceId();?>"><?=urlencode($service->getServiceName());?></option>';
                                <?php 
                                }else{?>
                                    service_select_option += '<option disabled value="<?=$service->getServiceId();?>"><?=urlencode($service->getServiceName());?></option>';
                                <?php 
                                }
                            }
                        ?>
                    service_select_option += '</select>';
                        var newContent = '' +

                            '<div data-image-id="' + data.id + '" id="image_' + data.id + '" class="map_image_div">' +
                            '<span class="group_checker"><input type="checkbox" id="checkbox_image_' + data.id + '"  name="images" class="proposal_images" value="' + data.id + '" style="float:left;"></span>' +
                            '<h3>' +
                            '<a href="#"><span id="title_' + data.id + '">Site Map</span></a>' +
                            '<span title="Show In Work Order" class="superScript grey_b" id="header_span_workorder_' + data.id + '" style="right: 68px;position: absolute;top: 6px;display:block">WO</span>' +
                            '<span title="Show In Proposal" class="superScript grey_b" id="header_span_proposal_' + data.id + '" style="right: 101px;position: absolute;top: 6px;display:block">P</span>' +
                            '<a class="btn-delete close-accordion" href="#">&nbsp;</a>' +
                            '</h3>' +
                            '<form class="big update-title-form form-validated imgForm" style="padding: 2px 5px !important;">' +
                            '<div class="clearfix">' +
                            '<div style="width: 155px; float: left">' +
                            '<a href="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + data.path + '?' + Math.random() +
                            '" class="fancybox">' +
                            '<img id="img_' + data.id + '" style="height: auto; width: 150px;" ' +
                            'src="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + data.path + '?' + Math.random() +
                            '" alt="" title="Click to enlarge" class="tiptip"></a>' +
                            '</div>' +
                            '<div style="width: 200px; float: left">' +
                            '<p class="clearfix" style="margin-top: 10px;">' +
                            '<label style="width: 40px; margin: 0 5px 0 0; line-height: 20px;">Title</label>' +
                            '<input type="text" name="title" class="required" id="title2_' + data.id + '" ' +
                            'value="Site Map">' +
                            '</p>' +
                            '<p class="clearfix">' +
                            '<label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;"' +
                            'for="active_' + data.id + '">Proposal</label>' +
                            '<input type="checkbox" name="active" id="active_' + data.id + '" checked="checked">' +
                            '<span class="clearfix"></span>' +
                            '<label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;"' +
                            'for="activewo_' + data.id + '">Work Order</label>' +
                            '<input type="checkbox" name="active"' +
                            'id="activewo_' + data.id + '" checked="checked">' +
                            '</p>' +
                            '<p id="updating_' + data.id + '" class="imageUpdating"></p>' +service_select_option+
                            '</div>' +
                            '<div class="clearfix"></div>' +
                            '<div class="clearfix" style="padding: 10px 0 0;">' +
                            '<div style="width: 150px; float: left; text-align: center;">' +
                            '<a style="float: left; margin-left: 45px; font-size: 26px; color: #000;"' +
                            'class="rotateImage rotateLeft tiptip"' +
                            'rel="' + data.id + '" title="Rotate Left" href="#">' +
                            '<i class="fa fa-fw fa-rotate-left"></i>' +
                            '</a>' +
                            '<a style="float: left; font-size: 26px; color: #000;" class="rotateImage rotateRight tiptip"' +
                            'rel="' + data.id + '" title="Rotate Right" href="#">' +
                            '<i class="fa fa-fw fa-rotate-right"></i>' +
                            '</a>' +
                            '</div>' +
                            '<div style="width: 205px; float: left" class="clearfix">' +
                            '<p class="clearfix">' +
                            '<a href="#" class="tiptip btn delete-image-button deleteIcon" ' +
                            'data-image-id="' + data.id + '" title="Delete" data-delete-id="' + data.id + '" style="margin-right: 10px; margin-left: 10px;">' +
                            '</a>' +
                            '<a class="btn image-notes notesIcon tiptip" type="button" title="Notes" id="notes-' + data.id + '" style="margin-right: 10px;"></a>' +
                            '<a href="#" class="tiptip btn image-editor-btn editIcon" ' +
                            'data-imageid="' + data.id + '" data-imagename="'+data.path+'" data-imageurl="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + data.path + '" title="Edit Image" id="image-crop-' + data.id + '" data-delete-id="' + data.id + '" style="margin-right: 8px;">' +
                            '</a>' +
                            '<a href="#" class="btn update-image-button update-button saveIcon" data-image-id="' + data.id + '" style="margin-left: 5px;float:right">' +
                            'Update' +
                            '</a>' +
                            '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</form>';

                        $("#proposalMapImages").append(newContent);
                        $("#proposalMapImages").sortable('refresh');
                        $("#proposalMapImages").accordion('destroy').accordion({
                            collapsible: true,
                            active: -1,
                            autoHeight: false,
                            navigation: true,
                            header: "> div > h3"
                        });
                        // if(len==image_uploaded_count){
                        //     $("#imageUploading").hide();
                        // }

                        mapimageCountCheck();
                        initButtons();
                        initTiptip();
                        $('#select_service_map_' + data.id).uniform();
                        // $('#accordion3 input:checkbox').uniform();
                        $('#checkbox_image_' + data.id).uniform();
                        $('#images_layout_' + data.id).uniform();
                    } else {
                        console.log(data)
                        if (data.warnings) {
                            swal('', 'File Not Uploaded<br>Error:' + data.warnings[0], "error")
                        }

                        var progressBar = item.html.find('.progress-bar2');

                        // make HTML changes
                        if (progressBar.length > 0) {
                            progressBar.find('span').html(0 + "%");
                            progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
                            item.html.find('.progress-bar2').fadeOut(400);
                        }

                        item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
                            '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
                        ) : null;
                    }
                },
                onError: function (item) {
                    var progressBar = item.html.find('.progress-bar2');

                    // make HTML changes
                    if (progressBar.length > 0) {
                        progressBar.find('span').html(0 + "%");
                        progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
                        item.html.find('.progress-bar2').fadeOut(400);
                    }

                    item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
                        '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
                    ) : null;
                },
                onProgress: function (data, item) {
                    var progressBar = item.html.find('.progress-bar2');

                    // make HTML changes
                    if (progressBar.length > 0) {
                        progressBar.show();
                        progressBar.find('span').html(data.percentage + "%");
                        progressBar.find('.fileuploader-progressbar .bar').width(data.percentage + "%");
                    }
                },
                onComplete: function (listEl, parentEl, newInputEl, inputEl, jqXHR, textStatus) {

                    setTimeout(reset_map_uploader(), 300);
                },
            },
            onRemove: function (item) {
                // send POST request
                $.post('./php/ajax_remove_file.php', {
                    file: item.name
                });
            },

            captions: $.extend(true, {}, 'Test', {
                feedback: 'Choose file to upload',
                or: '',
                button: 'Add Images'
            })
        });

        function initViewsDatatable() {
            // Proposal Views Datatable
            ViewsDatatable = $("#editProposalViews").dataTable({
                "order": [
                    [1, "desc"]
                ],
                "bProcessing": true,
                "serverSide": true,
                "ajax": {
                    "url": "<?php echo site_url('ajax/proposalViews/' . $proposal->getProposalId()); ?>"
                },

                "aoColumns": [{
                    'bSortable': false,
                    'class': 'preview_table_checkbox ',
                    'sWidth': '20'
                },
                    {
                        'bVisible': true,
                        'class': 'dtCenter'
                    },
                    {
                        'bVisible': true
                    },
                    {
                        'bSearchable': false,
                        'iDataSort': 0
                    },
                    {
                        'bSortable': true
                    },
                    {
                        'bSortable': true,
                        'class': 'dtCenter'
                    },
                    {
                        'bSortable': true
                    },
                    {
                        'bSortable': true
                    }
                ],

                "bJQueryUI": true,
                "bAutoWidth": true,
                "sPaginationType": "full_numbers",
                "sDom": 'HfltiprF',
                "aLengthMenu": [
                    [10, 25, 50, 100],
                    [10, 25, 50, 100]
                ],
                "drawCallback": function (settings) {

                    initTiptip();
                    initButtons();
                },
                "createdRow": function( row, data, dataIndex ) {
                    if ( data[8] == 1 ) {
                    $(row).addClass( 'view_expired' );
                    }
                }
            });
        }


        function format(d) {
            console.log(d.length);

            // `d` is the original data object for the row
            var childTable = '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">' +
                '<tr>' +
                '<th>Date Created</th>' +
                '<th>Last Updated</th>' +
                '<th>Last Action</th>' +
                '<th>Audit Viewed</th>' +
                '<th>Images Click</th>' +
                '<th>Total Duration</th>' +
                '</tr>';
            for (let i = 0; i < d.length; i++) {
                var audit = (d[i].audit_viewed == '1') ? 'Viewed' : 'Not';
                var image = (d[i].images_clicked == '1') ? 'Clicked' : 'Not';
                childTable += '<tr>' +
                    '<td>' + d[i].created_at + '</td>' +
                    '<td>' + d[i].updated_at + '</td>' +
                    '<td>' + d[i].updated_at + '</td>' +
                    '<td>' + audit + '</td>' +
                    '<td>' + image + '</td>' +
                    '<td>' + d[i].total_duration + '</td>' +
                    '</tr>';
            }
            childTable += '</table>';
            return childTable;
        }


        $('#proposalLayout').on('change', function () {
            if ($(this).val() == 'web-cool' || $(this).val() == 'web-standard' || $(this).val() == 'web-custom') {
                $('.showPreProposalPopup').show();
            } else {
                $('.showPreProposalPopup').hide();

            }
        })

        enable_fileupload_plugin();


        function updateVideoNumSelected() {
            var num = $(".proposal_videos:checked").length;

            // Hide the options if 0 selected
            if (num < 1) {

                $(".groupVideoAction").hide();
                // $(".groupActionsContainer").hide();
            } else {

                $(".groupVideoAction").show();
                // $(".groupActionsContainer").show();
            }
        }


        // Group Actions Button
        $(document).on("click", "#groupVideoActionsButton", function () {

            // Toggle the buttons
            $(".groupActionsContainer").toggle();
        });


        $(".proposal_videos").live('click', function () {

            $.uniform.update();
            updateVideoNumSelected()

        });


        $("#masterSelect").live('change', function () {
            if ($(this).prop('checked')) {
                $(".proposal_videos").attr('checked', 'checked');
            } else {
                $(".proposal_videos").attr('checked', false);
            }
            $.uniform.update();
            updateVideoNumSelected()
            return false;
        });

        $("#select_video_none").live('click', function () {
            console.log('chchchc')

            $(".proposal_videos").attr('checked', false);
            $("#masterSelect").attr('checked', false);
            $.uniform.update();
            updateVideoNumSelected()
            return false;
        });

        $("#select_video_all").live('click', function () {

            $(".proposal_videos").attr('checked', 'checked');
            $("#masterSelect").attr('checked', 'checked');
            $.uniform.update();
            updateVideoNumSelected()


            return false;
        });

        // All


        function checkVideosSelected() {
            var num = $(".proposal_videos:checked").length;
            if (num > 0) {
                return true;
            }
            $("#no-proposals-selected").dialog('open');
            return false;
        }

        // get a list of the selected IDs /
        function getSelectedVideoIds() {
            var IDs = new Array();
            $(".proposal_videos:checked").each(function () {
                IDs.push($(this).val());
            });
            return IDs;
        }

        // get a list of the selected IDs /
        function getAllVideoIds() {
            var IDs = new Array();
            $(".proposal_videos").each(function () {
                IDs.push($(this).val());
            });
            return IDs;
        }


        $(document).on("click", "#groupVideoDelete", function () {
            var proposal_id = $(this).attr('data-proposal-id');
            swal({
                title: "Are you Sure?",
                text: "This will delete proposal videos",
                showCancelButton: true,
                confirmButtonText: 'Delete',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function (isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'Removing..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                            swal.showLoading();
                        }
                    })

                    $.ajax({
                        url: '/ajax/remove_group_proposal_videos',
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            'videos_ids': getSelectedVideoIds(),
                            'proposal_id': proposal_id
                        },

                        success: function (data) {
                            swal('', 'Proposal Videos Removed');
                            $(".proposal_videos:checked").each(function () {
                                var video_id = $(this).val();
                                $('#video_' + video_id).remove();
                            });
                            updateVideoNumSelected();
                            videoCountCheck();
                            $('#masterSelect').prop('checked', false);
                            $.uniform.update();
                            if ($(".proposal_videos").length == 0) {
                                $('#uniform-masterSelect').hide();
                                $('#no_videos_section').show();
                            }
                        },
                        error: function (jqXhr, textStatus, errorThrown) {
                            swal("Error", "An error occurred. Please try again");
                        }
                    })
                } else {
                    swal("Cancelled", "Your proposal videos not removed :)", "error");
                }
            });

        });


        $(document).on('click', '.groupVideoShowProposal', function () {
            var proposal_id = $(this).attr('data-proposal-id');
            var visible_proposal = $(this).attr('data-visible-proposal');
            if (visible_proposal == '1') {
                var confirm_msg = 'This will add Video(s) from Proposals';
                var confirm_loading = 'Adding..';
                var complete_msg = 'Added';
            } else {
                var confirm_msg = 'This will remove Video(s) from Proposals';
                var confirm_loading = 'Removing..';
                var complete_msg = 'Removed';
            }
            var confirm_msg =
                swal({
                    title: "Are you sure?",
                    text: confirm_msg,
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    cancelButtonText: "Cancel",
                    dangerMode: false,
                }).then(function (isConfirm) {
                    if (isConfirm) {


                        swal({
                            title: confirm_loading,
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 2000,
                            onOpen: () => {
                                swal.showLoading();
                            }
                        })

                        var videoIds = getSelectedVideoIds();
                        $.ajax({
                            type: "POST",
                            url: "<?php echo site_url('ajax/update_proposal_video_proposal_setting') ?>",
                            dataType: 'json',
                            data: {
                                'videos_ids': videoIds,
                                'proposal_id': proposal_id,
                                'visible_proposal': visible_proposal,
                            },
                        })
                            .done(function (data) {

                                if (data.error) {
                                    swal(
                                        'Error',
                                        'There was an error saving the video'
                                    );
                                    return;
                                }

                                $('#masterSelect').prop('checked', false);
                                $('.proposal_videos').prop('checked', false);
                                $('#groupVideoActionsButton').hide();

                                for ($i = 0; $i < videoIds.length; $i++) {
                                    console.log()
                                    if (visible_proposal == '1') {
                                        $('#video_header_span_proposal_' + videoIds[$i]).show();
                                        $('#visible_proposal_' + videoIds[$i]).prop('checked', true);
                                    } else {
                                        $('#video_header_span_proposal_' + videoIds[$i]).hide();
                                        $('#visible_proposal_' + videoIds[$i]).prop('checked', false);
                                    }

                                }

                                $.uniform.update();
                                swal(
                                    'Success',
                                    'Video ' + complete_msg
                                );

                            })
                            .fail(function (xhr) {


                                swal(
                                    'Error',
                                    'There was an error saving the Video'
                                );
                            });
                    } else {
                        swal("Cancelled", "Your Video is safe :)", "error");
                    }
                });

        });


        $(document).on('click', '.groupVideoRemoveWorkOrder', function () {
            var proposal_id = $(this).attr('data-proposal-id');
            var visible_work_order = $(this).attr('data-visible-work-order');
            if (visible_work_order == '1') {
                var confirm_msg = 'This will add Video(s) from Work order';
                var confirm_loading = 'Adding..';
                var complete_msg = 'Added';
            } else {
                var confirm_msg = 'This will remove Video(s) from Work order';
                var confirm_loading = 'Removing..';
                var complete_msg = 'Removed';
            }
            var confirm_msg =
                swal({
                    title: "Are you sure?",
                    text: confirm_msg,
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    cancelButtonText: "Cancel",
                    dangerMode: false,
                }).then(function (isConfirm) {
                    if (isConfirm) {


                        swal({
                            title: confirm_loading,
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 2000,
                            onOpen: () => {
                                swal.showLoading();
                            }
                        })

                        var videoIds = getSelectedVideoIds();
                        $.ajax({
                            type: "POST",
                            url: "<?php echo site_url('ajax/update_proposal_video_work_setting_setting') ?>",
                            dataType: 'json',
                            data: {
                                'videos_ids': videoIds,
                                'proposal_id': proposal_id,
                                'visible_work_order': visible_work_order,
                            },
                        })
                            .done(function (data) {

                                if (data.error) {
                                    swal(
                                        'Error',
                                        'There was an error saving the video'
                                    );
                                    return;
                                }

                                $('#masterSelect').prop('checked', false);
                                $('.proposal_videos').prop('checked', false);
                                $('#groupVideoActionsButton').hide();

                                for ($i = 0; $i < videoIds.length; $i++) {

                                    if (visible_work_order == '1') {
                                        $('#video_header_span_workorder_' + videoIds[$i]).show();
                                        $('#visible_work_order_' + videoIds[$i]).prop('checked', true);
                                    } else {
                                        $('#video_header_span_workorder_' + videoIds[$i]).hide();
                                        $('#visible_work_order_' + videoIds[$i]).prop('checked', false);
                                    }

                                }
                                $.uniform.update();
                                swal(
                                    'Success',
                                    'Work Order ' + complete_msg
                                );

                            })
                            .fail(function (xhr) {


                                swal(
                                    'Error',
                                    'There was an error saving the Video'
                                );
                            });
                    } else {
                        swal("Cancelled", "Your Video is safe :)", "error");
                    }
                });

        });

        $(document).on('click', '.groupVideoEnableDisableLargePlayer', function () {
            var proposal_id = $(this).attr('data-proposal-id');
            var enable_large_player = $(this).attr('data-enable-large-player');
            if (enable_large_player == '1') {
                var confirm_msg = 'This will show Video(s) in large player';
                var confirm_loading = 'saving..';
                var complete_msg = 'Updated';
            } else {
                var confirm_msg = 'This will show Video(s) in small player';
                var confirm_loading = 'saving..';
                var complete_msg = 'Updated';
            }
            var confirm_msg =
                swal({
                    title: "Are you sure?",
                    text: confirm_msg,
                    showCancelButton: true,
                    confirmButtonText: 'Yes',
                    cancelButtonText: "Cancel",
                    dangerMode: false,
                }).then(function (isConfirm) {
                    if (isConfirm) {


                        swal({
                            title: confirm_loading,
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 2000,
                            onOpen: () => {
                                swal.showLoading();
                            }
                        })

                        var videoIds = getSelectedVideoIds();
                        $.ajax({
                            type: "POST",
                            url: "<?php echo site_url('ajax/update_proposal_video_large_player_setting') ?>",
                            dataType: 'json',
                            data: {
                                'videos_ids': videoIds,
                                'proposal_id': proposal_id,
                                'enable_large_player': enable_large_player,
                            },
                        })
                            .done(function (data) {

                                if (data.error) {
                                    swal(
                                        'Error',
                                        'There was an error saving the video'
                                    );
                                    return;
                                }

                                $('#masterSelect').prop('checked', false);
                                $('.proposal_videos').prop('checked', false);
                                $('#groupVideoActionsButton').hide();

                                for ($i = 0; $i < videoIds.length; $i++) {

                                    if (enable_large_player == '1') {
                                        $('#video_header_span_large_player_' + videoIds[$i]).show();
                                        $('#is_large_preview_' + videoIds[$i]).prop('checked', true);
                                    } else {
                                        $('#video_header_span_large_player_' + videoIds[$i]).hide();
                                        $('#is_large_preview_' + videoIds[$i]).prop('checked', false);
                                    }

                                }
                                $.uniform.update();
                                swal(
                                    'Success',
                                    'Video setting ' + complete_msg
                                );

                            })
                            .fail(function (xhr) {


                                swal(
                                    'Error',
                                    'There was an error saving the Video'
                                );
                            });
                    } else {
                        swal("Cancelled", "Your Video is safe :)", "error");
                    }
                });

        });


        $(document).on('click', '.groupVideoPlayerIcon', function () {
            var proposal_id = $(this).attr('data-proposal-id');
            var visible_player_icon = $(this).attr('data-visible-player-icon');
            if (visible_player_icon == '0') {
                var confirm_msg = 'This will show Video(s) Player Icon in Proposals';
                var confirm_loading = 'Saving..';
                var complete_msg = 'Saved';
            } else {
                var confirm_msg = 'This will hide Video(s) Player Icon in Proposals';
                var confirm_loading = 'Saving..';
                var complete_msg = 'Saved';
            }
            var confirm_msg =
                swal({
                    title: "Are you sure?",
                    text: confirm_msg,
                    showCancelButton: true,
                    confirmButtonText: 'Save',
                    cancelButtonText: "Cancel",
                    dangerMode: false,
                }).then(function (isConfirm) {
                    if (isConfirm) {


                        swal({
                            title: confirm_loading,
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 2000,
                            onOpen: () => {
                                swal.showLoading();
                            }
                        })

                        var videoIds = getSelectedVideoIds();
                        $.ajax({
                            type: "POST",
                            url: "<?php echo site_url('ajax/update_proposal_video_player_icon_setting') ?>",
                            dataType: 'json',
                            data: {
                                'videos_ids': videoIds,
                                'proposal_id': proposal_id,
                                'visible_player_icon': visible_player_icon,
                            },
                        })
                            .done(function (data) {

                                if (data.error) {
                                    swal(
                                        'Error',
                                        'There was an error saving the video'
                                    );
                                    return;
                                }

                                $('#masterSelect').prop('checked', false);
                                $('.player_icon_hide').prop('checked', false);
                                $('#groupVideoActionsButton').hide();

                                for ($i = 0; $i < videoIds.length; $i++) {
                                    console.log(videoIds[$i]);
                                    if (visible_player_icon == '1') {
                                       
                                        $('#player_icon_hide' + videoIds[$i]).prop('checked', true);
                                        $('#player_overlay'+videoIds[$i]).hide();
                                    } else {
                                       
                                        $('#player_icon_hide' + videoIds[$i]).prop('checked', false);
                                        $('#player_overlay'+videoIds[$i]).show();
                                    }

                                }

                                $.uniform.update();
                                swal(
                                    'Success',
                                    'Video ' + complete_msg
                                );

                            })
                            .fail(function (xhr) {


                                swal(
                                    'Error',
                                    'There was an error saving the Video'
                                );
                            });
                    } else {
                        swal("Cancelled", "Your Video is safe :)", "error");
                    }
                });

        });


        //Service Image Uploader
        // enable fileuploader plugin
        servicefileuploader = $('#proposalServiceImageUploader').fileuploader({
            enableApi: true,
            limit: servicefileUploaderImageUploadLimit,
            maxSize: 60,
            changeInput: '<div class="fileuploader-input"><div class="fileuploader-input-caption">Maximum 2 Images</div><div class="fileuploader-input-button"><span>${captions.button}</span></div></div>',

            fileMaxSize: 20,
            extensions: ['jpg', 'png', 'jpeg', 'heif', 'heic', 'tiff', 'tif', 'gif'],
            dialogs: {
                // alert dialog
                alert: function (text) {
                    return swal('', text)
                    // alert(text);
                },

                // confirm dialog
                confirm: function (text, callback) {
                    confirm(text) ? callback() : null;
                }
            },
            // Callback fired on selecting and processing a file
            onSelect: function (item, listEl, parentEl, newInputEl, inputEl) {
                // callback will go here
                // console.log(item)
                // console.log(parentEl)
                // console.log(inputEl)
            },
            upload: {
                url: "<?php echo site_url('ajax/proposalServiceSaveImage') ?>",

                data: null,
                type: 'POST',
                enctype: 'multipart/form-data',
                start: true,
                synchron: true,

                beforeSend: function (item) {

                    item.upload.data.proposalId = '<?= $proposal->getProposalId(); ?>';
                    item.upload.data.proposalServiceId = $('#editServiceId').val();
                    item.upload.data.map = 0;
                },
                onSuccess: function (result, item) {
                    var companyId = '<?php echo $proposal->getOwner()->getCompanyId(); ?>';
                    var proposalId = '<?php echo $proposal->getProposalId(); ?>';
                    var data = JSON.parse(result),
                        nameWasChanged = false;

                    // get the new file name
                    if (data.isSuccess) {

                        item.html.find('.column-title div').animate({
                            opacity: 0
                        }, 400);
                        item.html.find('.column-actions').append('<a class="fileuploader-action fileuploader-action-remove fileuploader-action-success" title="Remove"><i></i></a>');
                        setTimeout(function () {
                            item.html.find('.column-title div').attr('title', item.name).text(item.name).animate({
                                opacity: 1
                            }, 400);
                            item.html.find('.progress-bar2').fadeOut(400);
                        }, 400);

                        var newContent = '' +

                            '<div data-image-id="' + data.id + '" id="image_' + data.id + '" class="image_div" style="width: 460px;">' +
                            '<h3>' +
                            '<a href="javascript:void(0)"><span id="title_' + data.id + '">Image</span></a>' +
                            '</h3>' +
                            '<form class="big update-title-form form-validated imgForm" style="padding: 2px 5px !important;">' +
                            '<div class="clearfix">' +
                            '<div style="width: 153px; float: left">' +
                            '<a href="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + data.path + '?' + Math.random() +
                            '" class="fancybox">' +
                            '<img id="img_' + data.id + '" style="height: auto; width: 150px;" ' +
                            'src="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + data.path + '?' + Math.random() +
                            '" alt="" title="Click to enlarge" class="tiptip"></a>' +
                            '</div>' +
                            '<div style="width: 160px; float: left">' +
                            '<p class="clearfix" style="margin-top: 10px;">' +
                            '<label style="width: 40px; margin: 0 5px 0 0; line-height: 20px;">Title</label>' +
                            '<input type="text" name="title" class="required" id="title2_' + data.id + '" ' +
                            'value="Image" style="width: 122px;">' +
                            '</p>' +
                            '<p class="clearfix" style="margin-top:5px;">' +
                            '<input type="checkbox" name="active" id="active_' + data.id + '" checked="checked">' +
                            '<label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;vertical-align: text-bottom;"' +
                            'for="active_' + data.id + '">Proposal</label>' +
                            '<span class="clearfix"></span>' +
                            '<input type="checkbox" name="active"' +
                            'id="activewo_' + data.id + '" checked="checked">' +
                            '<label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;vertical-align: text-bottom;"' +
                            'for="activewo_' + data.id + '">Work Order</label>' +
                            '<div class="clearfix"></div>' +


                            '</p>' +
                            '<p id="updating_' + data.id + '" class="imageUpdating"></p>' +
                            '</div>' +
                            '<div class="clearfix"></div>' +
                            '<div class="clearfix" style="padding: 10px 0 0;">' +
                            '<div style="width: 148px; float: left; text-align: center;">' +
                            '<a style="float: left; margin-left: 45px; font-size: 26px; color: #000;"' +
                            'class="rotateImage rotateLeft tiptip"' +
                            'rel="' + data.id + '" title="Rotate Left" href="#">' +
                            '<i class="fa fa-fw fa-rotate-left"></i>' +
                            '</a>' +
                            '<a style="float: left; font-size: 26px; color: #000;" class="rotateImage rotateRight tiptip"' +
                            'rel="' + data.id + '" title="Rotate Right" href="#">' +
                            '<i class="fa fa-fw fa-rotate-right"></i>' +
                            '</a>' +
                            '</div>' +
                            '<div style="width: 300px; float: left" class="clearfix">' +
                            '<p class="clearfix" style="text-align:center">' +
                            '<a href="#" class="tiptip btn delete-image-button deleteIcon" ' +
                            'data-image-id="' + data.id + '" title="Delete" data-delete-id="' + data.id + '" style="margin-right:7px;margin-left: 0px;"> Delete Image' +
                            '</a>' +
                            '<a class="btn image-notes notesIcon tiptip" type="button" title="Notes" id="notes-' + data.id + '" style="margin-right: 7px;"> Notes</a>' +
                            '<a href="#" class="tiptip btn image-editor-btn editIcon" ' +
                            'data-imageid="' + data.id + '" data-imagename="'+data.path+'" data-imageurl="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + data.path + '" title="Edit Image" id="image-crop-' + data.id + '" data-delete-id="' + data.id + '" style="margin-right: 8px;"> Edit Image' +
                            '</a>' +
                            '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</form>';


                        $("#serviceImages").append(newContent);
                        $("#serviceImages").sortable('refresh');
                        $("#serviceImages").accordion('destroy').accordion({
                            collapsible: true,
                            active: -1,
                            autoHeight: false,
                            navigation: true,
                            header: "> div > h3",
                            activate : function (event, ui) {
                                console.log('activate1')
                                

                            },

                            beforeActivate: function( event, ui ) {
                            
                                console.log('beforeActivate1')
                            }
                        });
                        // if(len==image_uploaded_count){
                        //     $("#imageUploading").hide();
                        // }

                        // imageCountCheck();

                        initButtons();
                        initTiptip();
                        // $('#accordion3 input:checkbox').uniform();
                        $('#checkbox_image_' + data.id).uniform();
                        $('#images_layout_' + data.id).uniform();
                    } else {

                        if (data.warnings) {
                            swal('', 'File Not Uploaded<br>Error:' + data.warnings[0], "error")
                        }

                        var progressBar = item.html.find('.progress-bar2');

                        // make HTML changes
                        if (progressBar.length > 0) {
                            progressBar.find('span').html(0 + "%");
                            progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
                            item.html.find('.progress-bar2').fadeOut(400);
                        }

                        item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
                            '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
                        ) : null;
                    }
                },
                onError: function (item) {
                    var progressBar = item.html.find('.progress-bar2');

                    // make HTML changes
                    if (progressBar.length > 0) {
                        progressBar.find('span').html(0 + "%");
                        progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
                        item.html.find('.progress-bar2').fadeOut(400);
                    }

                    item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
                        '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
                    ) : null;
                },
                onProgress: function (data, item) {
                    var progressBar = item.html.find('.progress-bar2');

                    // make HTML changes
                    if (progressBar.length > 0) {
                        progressBar.show();
                        progressBar.find('span').html(data.percentage + "%");
                        progressBar.find('.fileuploader-progressbar .bar').width(data.percentage + "%");
                    }
                },
                onComplete: function (listEl, parentEl, newInputEl, inputEl, jqXHR, textStatus) {
                    console.log('complete');
                    setTimeout(reset_service_uploader(), 300);
                },
            },
            onRemove: function (item) {
                // send POST request
                $.post('./php/ajax_remove_file.php', {
                    file: item.name
                });
            }
        });


        //Service Map Image Uploader
        // enable fileuploader plugin
        mapservicefileuploader = $('#proposalServiceMapImageUploader').fileuploader({
            enableApi: true,
            limit: mapservicefileUploaderImageUploadLimit,
            maxSize: 60,
            changeInput: '<div class="fileuploader-input"><div class="fileuploader-input-caption">Maximum 1 Image</div><div class="fileuploader-input-button"><span>${captions.button}</span></div></div>',

            fileMaxSize: 20,
            extensions: ['jpg', 'png', 'jpeg', 'heif', 'heic', 'tiff', 'tif', 'gif'],
            dialogs: {
                // alert dialog
                alert: function (text) {
                    return swal('', text)
                    // alert(text);
                },

                // confirm dialog
                confirm: function (text, callback) {
                    confirm(text) ? callback() : null;
                }
            },
            // Callback fired on selecting and processing a file
            onSelect: function (item, listEl, parentEl, newInputEl, inputEl) {
                // callback will go here
                // console.log(item)
                // console.log(parentEl)
                // console.log(inputEl)
            },
            upload: {
                url: "<?php echo site_url('ajax/proposalServiceSaveImage') ?>",

                data: null,
                type: 'POST',
                enctype: 'multipart/form-data',
                start: true,
                synchron: true,

                beforeSend: function (item) {

                    item.upload.data.proposalId = '<?= $proposal->getProposalId(); ?>';
                    item.upload.data.proposalServiceId = $('#editServiceId').val();
                    item.upload.data.map = 1;
                },
                onSuccess: function (result, item) {
                    var companyId = '<?php echo $proposal->getOwner()->getCompanyId(); ?>';
                    var proposalId = '<?php echo $proposal->getProposalId(); ?>';
                    var data = JSON.parse(result),
                        nameWasChanged = false;

                    // get the new file name
                    if (data.isSuccess) {

                        item.html.find('.column-title div').animate({
                            opacity: 0
                        }, 400);
                        item.html.find('.column-actions').append('<a class="fileuploader-action fileuploader-action-remove fileuploader-action-success" title="Remove"><i></i></a>');
                        setTimeout(function () {
                            item.html.find('.column-title div').attr('title', item.name).text(item.name).animate({
                                opacity: 1
                            }, 400);
                            item.html.find('.progress-bar2').fadeOut(400);
                        }, 400);
                        var serviceId = $('#editServiceId').val();
                        var newContent = '' +

                            '<div data-image-id="' + data.id + '" id="image_' + data.id + '" class="image_div" style="width: 460px;">' +
                            '<h3>' +
                            '<a href="javascript:void(0)"><span id="title_' + data.id + '">Site Map</span></a>' +
                            '</h3>' +
                            '<form class="big update-title-form form-validated imgForm" style="padding: 2px 5px !important;">' +
                            '<div class="clearfix">' +
                            '<div style="width: 153px; float: left">' +
                            '<a href="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + data.path + '?' + Math.random() +
                            '" class="fancybox">' +
                            '<img id="img_' + data.id + '" style="height: auto; width: 150px;" ' +
                            'src="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + data.path + '?' + Math.random() +
                            '" alt="" title="Click to enlarge" class="tiptip"></a>' +
                            '</div>' +
                            '<div style="width: 160px; float: left">' +
                            '<p class="clearfix" style="margin-top: 10px;">' +
                            '<label style="width: 40px; margin: 0 5px 0 0; line-height: 20px;">Title</label>' +
                            '<input type="text" name="title" class="required" id="title2_' + data.id + '" ' +
                            'value="Site Map" style="width: 122px;">' +
                            '</p>' +
                            '<p class="clearfix" style="margin-top:5px;">' +
                            '<input type="checkbox" name="active" id="active_' + data.id + '" checked="checked">' +
                            '<label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;vertical-align: text-bottom;"' +
                            'for="active_' + data.id + '">Proposal</label>' +
                            '<span class="clearfix"></span>' +
                            '<input type="checkbox" name="active"' +
                            'id="activewo_' + data.id + '" checked="checked">' +
                            '<label style="width: 80px; margin: 0 5px 0 0; line-height: 20px;vertical-align: text-bottom;"' +
                            'for="activewo_' + data.id + '">Work Order</label>' +
                            '<div class="clearfix"></div>' +
                            '</p>' +
                            '<p id="updating_' + data.id + '" class="imageUpdating"></p>' +
                            '</div>' +
                            '<div class="clearfix"></div>' +
                            '<div class="clearfix" style="padding: 10px 0 0;">' +
                            '<div style="width: 148px; float: left; text-align: center;">' +
                            '<a style="float: left; margin-left: 45px; font-size: 26px; color: #000;"' +
                            'class="rotateImage rotateLeft tiptip"' +
                            'rel="' + data.id + '" title="Rotate Left" href="#">' +
                            '<i class="fa fa-fw fa-rotate-left"></i>' +
                            '</a>' +
                            '<a style="float: left; font-size: 26px; color: #000;" class="rotateImage rotateRight tiptip"' +
                            'rel="' + data.id + '" title="Rotate Right" href="#">' +
                            '<i class="fa fa-fw fa-rotate-right"></i>' +
                            '</a>' +
                            '</div>' +
                            '<div style="width: 300px; float: left" class="clearfix">' +
                            '<p class="clearfix" style="text-align:center">' +
                            '<a href="#" class="tiptip btn move-image-button " ' +
                            'data-image-id="' + data.id + '" data-service-id="'+serviceId+'" title="Move"  style="margin-right: 8px; margin-left: 0px;">Move to Maps' +
                            '</a>' +
                            '<a href="#" class="tiptip btn delete-image-button deleteIcon" ' +
                            'data-image-id="' + data.id + '" data-service-id="'+serviceId+'" title="Delete" data-delete-id="' + data.id + '" style="margin-right: 8px; margin-left: 0px;">' +
                            '</a>' +
                            '<a class="btn image-notes notesIcon tiptip" type="button" title="Notes" id="notes-' + data.id + '" style="margin-right: 8px;"></a>' +
                            '<a href="#" class="tiptip btn image-editor-btn editIcon" ' +
                            'data-imageid="' + data.id + '" data-imagename="'+data.path+'" data-imageurl="/uploads/companies/' + companyId + '/proposals/' + proposalId + '/' + data.path + '" title="Edit Image" id="image-crop-' + data.id + '" data-delete-id="' + data.id + '" style="margin-right: 8px;">' +
                            '</a>' +
                            '</p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</form>';


                        $("#serviceMapImages").html(newContent);
                        //Map Image check
                        var numImages = $("#proposalMapImages > div.map_image_div").length;
                           // Do the upload limit check
                            var mapImageUploadLimit = <?php echo MAP_IMAGE_UPLOAD_LIMIT; ?>;
                            if (numImages < mapImageUploadLimit) {
                                $("#serviceMapImages").find('.move-image-button').show();
                            } else {
                                $("#serviceMapImages").find('.move-image-button').hide();
                            }
                        $("#serviceMapImages").sortable('refresh');
                        $("#serviceMapImages").accordion('destroy').accordion({
                            collapsible: true,
                            active: 1,
                            autoHeight: false,
                            navigation: true,
                            header: "> div > h3",
                            activate : function (event, ui) {
                                console.log('activate1')
                                

                            },

                            beforeActivate: function( event, ui ) {
                            
                                $('.proposal_sevice_map_image_notes_div').show();
                                    var service_map_image_note = $(ui.newPanel).find('.service_map_image_note');
                                    if($(service_map_image_note).val()){
                                        $('.proposal_sevice_map_image_notes').html($(service_map_image_note).val());
                                    }else{
                                        $('.proposal_sevice_map_image_notes').html('This image has no notes');
                                    }
                            }
                        });
                        disable_map_service_select(serviceId);
                        // if(len==image_uploaded_count){
                        //     $("#imageUploading").hide();
                        // }

                        // imageCountCheck();

                        initButtons();
                        initTiptip();
                        // $('#accordion3 input:checkbox').uniform();
                        $('#checkbox_image_' + data.id).uniform();
                        $('#images_layout_' + data.id).uniform();
                    } else {

                        if (data.warnings) {
                            swal('', 'File Not Uploaded<br>Error:' + data.warnings[0], "error")
                        }

                        var progressBar = item.html.find('.progress-bar2');

                        // make HTML changes
                        if (progressBar.length > 0) {
                            progressBar.find('span').html(0 + "%");
                            progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
                            item.html.find('.progress-bar2').fadeOut(400);
                        }

                        item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
                            '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
                        ) : null;
                    }
                },
                onError: function (item) {
                    var progressBar = item.html.find('.progress-bar2');

                    // make HTML changes
                    if (progressBar.length > 0) {
                        progressBar.find('span').html(0 + "%");
                        progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
                        item.html.find('.progress-bar2').fadeOut(400);
                    }

                    item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
                        '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
                    ) : null;
                },
                onProgress: function (data, item) {
                    var progressBar = item.html.find('.progress-bar2');

                    // make HTML changes
                    if (progressBar.length > 0) {
                        progressBar.show();
                        progressBar.find('span').html(data.percentage + "%");
                        progressBar.find('.fileuploader-progressbar .bar').width(data.percentage + "%");
                    }
                },
                onComplete: function (listEl, parentEl, newInputEl, inputEl, jqXHR, textStatus) {
                    console.log('complete');
                    setTimeout(reset_map_service_uploader(), 300);
                },
            },
            onRemove: function (item) {
                // send POST request
                $.post('./php/ajax_remove_file.php', {
                    file: item.name
                });
            }
        });

        $("#proposalPreviewDialog").dialog({
            modal: true,
            autoOpen: false,
            open: function (event, ui) {
                // Reset Dialog Position
                if(isTouchDevice()){
                    $(this).dialog('widget').position({my: "top", at: "top", of: '#help_icon'});
                }else{
                    $(this).dialog('widget').position({my: "center", at: "center", of: window});
                }
                
            },
        });

        $(document).on("click", "a.serviceImagePreview", function () {

            var serviceId = $(this).data('service-id');
            swal('', 'Loading your images');
            swal.showLoading();

            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: {'proposalServiceId': serviceId},
                url: "<?php echo site_url('ajax/getProposalServiceImagePreviewData') ?>",
                dataType: "JSON"
            })
                .success(function (data) {

                    $("#proposalServicePreviewContent").empty();

                    $("#proposalPreviewDialog").dialog('option', 'title', 'Proposal: ' + data.proposal.title)

                    if (data.images.length) {

                        var i = 1;

                        $.each(data.images, function (index, img) {

                            var imgHtml = '<div class="proposalImgPreviewContainer">' +
                                '<p style="font-weight: bold; text-align: center; max-width: 230px; height: 25px; text-overflow: ellipsis; margin-bottom: 3px;">' + i + '. ' + img.title + '</p>' +
                                '<p style="font-weight: bold; text-align: center; max-width: 230px; height: 25px; text-overflow: ellipsis; margin-bottom: 3px;">' + img.serviceName + '</p>' +
                                '<a class="proposalPreviewLink" rel="previewImageGallery" href="' + img.image + '" title="' + img.title + '">' +
                                '<img src="' + img.image + '" class="proposalImgPreview" id="proposaImgPreview' + index + '" style="width: ' + img.width + '; margin-left: ' + img.paddingLeft + 'px; max-height: 200px;"/>' +
                                '</a>';


                            var layoutNum = 1;

                            imgHtml += '<p class="proposalImagePreviewFooter">';

                            if (img.proposal) {
                                imgHtml += '<span class="superScript grey_b tiptip" title="Show in Proposal" style="float: left; border: none; background: #25aae1; padding: 2px 5px; border-radius: 3px; color: #fff; margin-right: 5px;">P</span>';
                            }

                            if (img.work_order) {
                                imgHtml += '<span class="superScript grey_b tiptip" title="Show in Work Order" style="float: left; border: none; background: #25aae1; padding: 2px 5px; border-radius: 3px; color: #fff; margin-right: 5px;">WO</span>';
                            }
                            if (img.layout == 1) {
                                layoutNum = 2;
                            }

                            if (img.layout == 2) {
                                layoutNum = 4;
                            }

                            imgHtml += '<span class="superScript grey_b tiptip" title="' + layoutNum + ' per page" style="float:right; border: none; background: #25aae1; padding: 2px 5px; border-radius: 3px; color: #fff;">' + layoutNum + ' <i class="fa fa-fw fa-picture-o"></i></span>';

                            if (img.notes) {
                                imgHtml += '<span class="superScript grey_b tiptip" title="' + img.notes.replace(/(<([^>]+)>)/gi, "") + '" style="float:right; border: none; background: #25aae1; padding: 2px 5px; border-radius: 3px; color: #fff; margin-right: 5px;"><i class="fa fa-fw fa-file-text-o"></i></span>';
                            }

                            imgHtml += '</p>';
                            imgHtml += '</div>';

                            $("#proposalServicePreviewContent").append(imgHtml);
                            i++;
                        });

                        initTiptip();
                        $("a.proposalPreviewLink").fancybox({
                            openEffect: 'none',
                            closeEffect: 'none',
                            nextEffect: 'fade',
                            prevEffect: 'fade',
                        });


                        if (data.images.length == 1) {
                            $("#proposalPreviewDialog").dialog('option', 'width', 300);
                        }
                        if (data.images.length == 2) {
                            $("#proposalPreviewDialog").dialog('option', 'width', 600);
                        }

                        setTimeout(function () {
                            swal.close();
                            $("#proposalPreviewDialog").dialog('open');
                           // $("#proposalPreviewDialog").dialog("option", "position", "center");
                        }, 1500);
                    }
                });

            return false;
        });

        


    });// end Ready

    function removeLoadingImage() {
            $('.iframeLoadingImage').hide();
            $('.embed-responsive-item').show();
        }

    function reset_uploader() {
        var numImages = $("#accordion3 > div.image_div").length;

        fileUploaderImageUploadLimit = <?php echo IMAGE_UPLOAD_LIMIT; ?> -numImages;
        fileuploaderApi = $.fileuploader.getInstance(fileuploader);
        fileuploaderApi.setOption('limit', fileUploaderImageUploadLimit);
        fileuploaderApi.reset();
    }

    function reset_map_uploader() {
        var numMapImages1 = $("#proposalMapImages > div.map_image_div").length;
        fileUploaderMapImageUploadLimit = <?php echo MAP_IMAGE_UPLOAD_LIMIT; ?> -numMapImages1;
        mapfileuploaderApi = $.fileuploader.getInstance(mapfileuploader);
        mapfileuploaderApi.setOption('limit', fileUploaderMapImageUploadLimit);
        mapfileuploaderApi.reset();
    }


    function reset_service_uploader() {
        var numServiceImages = $("#serviceImages > div.image_div").length;
        var numMapImages = $("#serviceMapImages > div.image_div").length;
        var serviceId = $('#editServiceId').val();
        var elem = $('.serviceImageCount_' + $('#editServiceId').val());
        var parent = $(elem).parent();

        var image_count = parseInt(numServiceImages+ numMapImages);
        $('.service_image_count').html(numServiceImages);
        $(elem).html(image_count);
        
        if (image_count == 0) {
            $(elem).css('color', 'red');
            $(parent).removeClass('serviceImagePreview');
            $(parent).find('.tiptip').tipTip({
                content: 'No Images',
                defaultPosition: 'top'
            });
        } else {
            $(elem).css('color', '#7b7a7a');
            $(parent).addClass('serviceImagePreview');
            $(parent).data('service-id', serviceId);
            $(parent).find('.tiptip').tipTip({
                content: 'Click to See Images',
                defaultPosition: 'top',
            });
        }

        servicefileUploaderImageUploadLimit = 2 - numServiceImages;
        servicefileuploaderApi = $.fileuploader.getInstance(servicefileuploader);
        servicefileuploaderApi.setOption('limit', servicefileUploaderImageUploadLimit);
        servicefileuploaderApi.reset();
    }

    function reset_map_service_uploader() {
        var numMapImages = $("#serviceMapImages > div.image_div").length;
        var numServiceImages = $("#serviceImages > div.image_div").length;
        var serviceId = $('#editServiceId').val();
        var elem = $('.serviceImageCount_' + $('#editServiceId').val());
        var parent = $(elem).parent();

        var image_count = parseInt(numServiceImages+ numMapImages);
        $('.map_image_count').html(numMapImages);
        $(elem).html(image_count);
        if (image_count == 0) {
            $(elem).css('color', 'red');
            $(parent).removeClass('serviceMapImagePreview');
            $(parent).find('.tiptip').tipTip({
                content: 'No Images',
                defaultPosition: 'top'
            });
        } else {
            $(elem).css('color', '#7b7a7a');
            $(parent).addClass('serviceMapImagePreview');
            $(parent).data('service-id', serviceId);
            $(parent).find('.tiptip').tipTip({
                content: 'Click to See Images',
                defaultPosition: 'top',
            });
        }

        mapservicefileUploaderImageUploadLimit = 1 - numMapImages;
        mapservicefileuploaderApi = $.fileuploader.getInstance(mapservicefileuploader);
        mapservicefileuploaderApi.setOption('limit', mapservicefileUploaderImageUploadLimit);
        mapservicefileuploaderApi.reset();
    }


    function updateBgPreview(jscolor) {
        var rgbColor = (jscolor.toRGBString());
        $(".preview-heading").css("background-color", rgbColor);
    }

    function updateHeadingPreview(jscolor) {
        var rgbColor = (jscolor.toRGBString());
        $(".preview-heading").css("color", rgbColor);
    }

    function hexToRgb(hex) {
        hex = hex.toLowerCase();
        if (/^#([a-f0-9]{3}){1,2}$/.test(hex)) {
            if (hex.length == 4) {
                hex = '#' + [hex[1], hex[1], hex[2], hex[2], hex[3], hex[3]].join('');
            }
            var c = '0x' + hex.substring(1);
            return 'rgb(' + [(c >> 16) & 255, (c >> 8) & 255, c & 255].join(',') + ')';
        }
    }

    function htmlUnescape(value) {
        return String(value)
            .replace(/&quot;/g, '"')
            .replace(/&#39;/g, "'")
            .replace(/&lt;/g, '<')
            .replace(/&gt;/g, '>')
            .replace(/&amp;/g, '&');
    }

    function updateProposalServices() {
        var numServices = $("#proposal_services div").length;
        if (numServices > 0) {
            $("#noServices").hide();
            $('.estimate_btn').show();
        } else {
            $("#noServices").show();
            $('.estimate_btn').hide();
        }
        updateLegends();
    }

    function checkCustomTextHeadings() {
        $(".includedTextCategory").html('');

        $(".categoryInclude").each(function () {
            if ($(this).is(':checked')) {
                $(this).closest('.textCategory').find('h3 span.includedTextCategory').html('<i class="fa fa-fw fa-check-square-o"></i>');
            }
        });
    }

    function toggleCustomLayout() {
        if ($("#proposalLayout").val() == 'gradient' || $("#proposalLayout").val() == 'web-custom') {
            $('.customLayoutRow').show();
        } else {
            $('.customLayoutRow').hide();
        }
    }

    function updateLegends() {
        var numNoPrice = $(".service.noPrice").length;
        var numOptional = $(".service.optional").length;
        var numUnapproved = $(".service.unapproved").length;

        // Hide the legend
        $("#noPriceLegend").hide();
        $(".noPriceTag").hide();
        if (numNoPrice > 0) {
            // Show the legend if there are some
            $("#noPriceLegend").show();
            // Prefix the service title
            $(".service.noPrice").each(function () {
                $(this).find('.noPriceTag').show();
            });
        }

        $("#optionalLegend").hide();
        $(".optionalTag").hide();
        if (numOptional > 0) {
            $("#optionalLegend").show();
            // Prefix the service title
            $(".service.optional").each(function () {
                $(this).find('.optionalTag').show();
            });
        }

        $("#approvalLegend").hide();
        $(".unapprovedTag").hide();
        if (numUnapproved > 0) {
            $("#approvalLegend").show();
            // Prefix the service title
            $(".service.unapproved").each(function () {
                $(this).find('.unapprovedTag').show();
            });
        }
    }

    $(document).on("keyup", "#editServiceFields input:not(#editPrice)", function (e) {
        if (show_edit_flag) {
            $('#show_edit_alert').show();
        } else {
            $('#show_edit_alert').hide();
        }
    });
    $(document).on("change", "#unit_of_measurement", function (e) {
        if (show_edit_flag) {
            $('#show_edit_alert').show();
        } else {
            $('#show_edit_alert').hide();
        }
    });

    $(document).on("click", "#add_service_estimate", function () {
        if ($(this).prop("checked") == true) {
            $('.add_price_p').hide();
        } else {
            $('.add_price_p').show();
        }
    });

    $(document).on("click", "#enable_service_estimate", function () {
        if ($(this).prop("checked") == true) {
            $('#price-container').hide();
        } else {
            $('#price-container').show();
        }
    });

    $(document).on("click", "#addServiceCopyButton", function (e) {

        $('#addServiceFinish').click();

    });

    $(document).on("click", "#editServiceCopyButton", function (e) {

        $('#editServiceSave').click();

    });

    $(document).on("click", ".add_service_next_btn", function (e) {
        addServiceAndUploadImage = true;
        $('#addServiceFinish').click();

        swal({
            title: 'Saving..',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timer: 10000,
            onOpen: () => {
                swal.showLoading();
            }
        })

    });

    // All
    $("#select_image_all").live('click', function () {
        var activeTabId = $("#proposal-tabs").tabs("option", "active");
        console.log(activeTabId);
        if (activeTabId == 1) {
            $("#images").find(".proposal_images").attr('checked', 'checked');
        }else if (activeTabId == 3) {
            $("#maps").find(".proposal_images").attr('checked', 'checked');
        }
       
        $.uniform.update();
        updateNumSelected()
        return false;
    });

    // None
    $("#select_image_none").live('click', function () {
        $(".proposal_images").attr('checked', false);
        $.uniform.update();
        updateNumSelected()
        return false;
    });


    $(".proposal_images").live('click', function () {

        $.uniform.update();
        updateNumSelected()

    });

    // Proposal Status Update
    $("#delete-images-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                //oTable.fnDraw();
            }
        },
        autoOpen: false
    });

    $("#show-proposal-images-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                //oTable.fnDraw();
            }
        },
        autoOpen: false
    });

    $("#show-work-order-images-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                //oTable.fnDraw();
            }
        },
        autoOpen: false
    });

    $("#hide-proposal-images-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                //oTable.fnDraw();
            }
        },
        autoOpen: false
    });

    $("#hide-work-order-images-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                //oTable.fnDraw();
            }
        },
        autoOpen: false
    });

    $("#update-image-layout-status").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: function () {
                $(this).dialog('close');
                //oTable.fnDraw();
            }
        },
        autoOpen: false
    });


    //Hide Menu when clicking on a group action item
    $(".groupActionItems a").click(function () {

        $("#groupActionsContainer").hide();
        return false;
    });

    // Group action selected numbers
    function updateNumSelected() {
        var num = $(".proposal_images:checked").length;
        // Hide the options if 0 selected
        if (num < 1) {

            $(".groupAction").hide();
            $(".groupActionsContainer").hide();
        } else {

            $(".groupAction").show();
        }
    }


    /*
    DELETE
    */
    /* Check that at least one proposal has been selected */
    function checkProposalsSelected() {
        var num = $(".proposal_images:checked").length;
        if (num > 0) {
            return true;
        }
        $("#no-proposals-selected").dialog('open');
        return false;
    }

    /* get a list of the selected IDs */
    function getSelectedIds() {
        var IDs = new Array();
        $(".proposal_images:checked").each(function () {
            IDs.push($(this).val());
        });
        return IDs;
    }

    /* get a list of the selected IDs */
    function getAllImagesIds() {
        var IDs = new Array();
        $(".proposal_images").each(function () {
            IDs.push($(this).val());
        });
        return IDs;
    }


    $(document).on("click", "#groupImageDelete", function (e) {

        var proceed = checkProposalsSelected();
        if (proceed) {
            $("#deleteNum").html($(".proposal_images:checked").length);
            $("#delete-images").dialog('open');
        }
        $('.groupActionsContainer').hide();
    });

    $(document).on("click", "#groupShowProposal", function (e) {


        var proceed = checkProposalsSelected();
        console.log(proceed)
        if (proceed) {
            $("#showProposalNum").html($(".proposal_images:checked").length);
            $("#show-proposal-images").dialog('open');
        }
        $('.groupActionsContainer').hide();
    });

    $(document).on("click", "#groupShowWorkOrder", function (e) {

        var proceed = checkProposalsSelected();
        if (proceed) {
            $("#showWorkOrderNum").html($(".proposal_images:checked").length);
            $("#show-work-order-images").dialog('open');
        }
        $('.groupActionsContainer').hide();
    });

    $(document).on("click", "#groupRemoveProposal", function (e) {

        var proceed = checkProposalsSelected();
        if (proceed) {
            $("#hideProposalNum").html($(".proposal_images:checked").length);
            $("#hide-proposal-images").dialog('open');
        }
        $('.groupActionsContainer').hide();
    });

    $(document).on("click", "#groupRemoveWorkOrder", function (e) {

        var proceed = checkProposalsSelected();
        if (proceed) {
            $("#hideWorkOrderNum").html($(".proposal_images:checked").length);
            $("#hide-work-order-images").dialog('open');
        }
        $('.groupActionsContainer').hide();
    });

    $(document).on("click", "#groupImageLayoutUpdate", function (e) {

        var proceed = checkProposalsSelected();
        if (proceed) {
            $("#updateImageLayoutNum").html($(".proposal_images:checked").length);
            $("#update_image_layout").dialog('open');
        }
        $('.groupActionsContainer').hide();
    });

    // Delete dialog
    $("#delete-images").dialog({
        width: 500,
        modal: true,
        buttons: {
            "Delete": {
                text: 'Delete Images',
                'class': 'btn ui-button update-button',
                'id': 'confirmDelete',
                click: function () {

                    var image_ids = getSelectedIds();
                    var proposalId = '<?php echo $proposal->getProposalId(); ?>';
                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'ids': getSelectedIds(),
                            'proposalId': proposalId,
                        },
                        url: "<?php echo site_url('ajax/delete_proposal_images') ?>",
                        dataType: "JSON"
                    })
                        .success(function (data) {

                            if (data.success) {
                                var resendText = data.count + ' Images were deleted';
                            } else {
                                var resendText = 'An error occurred. Please try again';
                            }

                            $("#deleteImagesStatus").html(resendText);

                            $(".groupAction").hide();
                            $(".groupActionsContainer").hide();
                            $("#delete-images-status").dialog('open');
                            for ($j = 0; $j < image_ids.length; $j++) {
                                $('#uniform-checkbox_image_' + image_ids[$j]).remove();
                                $('#image_' + image_ids[$j]).remove()
                            }

                            var numImages = $("#accordion3 > div.image_div").length;

                            var imageUploadLimit = <?php echo IMAGE_UPLOAD_LIMIT; ?>;
                            // Do the upload limit check
                            if (numImages < imageUploadLimit) {
                                $("#imageLimitReached").hide();
                                $("#imageUploader").show();
                            } else {
                                $("#imageLimitReached").show();
                                $("#imageUploader").hide();
                            }

                            $("#imageCounter").text(numImages);
                            // Update the badge on the tab
                            if (numImages < 1) {
                                $("#imageCounter").removeClass('blue');
                                $("#imageCounter").addClass('red');
                                $('.all_images_td').hide();
                                $('#editImages').css('width', '50%')
                            } else {
                                $('.all_images_td').show();
                                $('#editImages').css('width', '100%')
                                $("#imageCounter").removeClass('red');
                                $("#imageCounter").addClass('blue');
                            }


                           //Map Image check
                           var numImages = $("#proposalMapImages > div.map_image_div").length;
                            $('.multipleImagePreview').hide();
                            // Do the upload limit check
                            var mapImageUploadLimit = <?php echo MAP_IMAGE_UPLOAD_LIMIT; ?>;
                            if (numImages < mapImageUploadLimit) {
                                $("#mapImageLimitReached").hide();
                                $("#imageMapUploader").show();
                            } else {
                                $("#mapImageLimitReached").show();
                                $("#imageMapUploader").hide();
                            }

                            $("#mapImageCounter").text(numImages);
                            // Update the badge on the tab
                            if (numImages < 1) {
                                $("#mapImageCounter").removeClass('blue');
                                $("#mapImageCounter").addClass('red');
                                $('.all_map_images_td').hide();
                                $('#editMapImages').css('width', '50%')

                            } else {
                                $('.all_map_images_td').show();
                                $('#editMapImages').css('width', '100%')
                                $("#mapImageCounter").removeClass('red');
                                $("#mapImageCounter").addClass('blue');
                            }

                            reset_uploader();
                            reset_map_uploader();

                        }).error(function (jqXhr, textStatus, errorThrown) {
                        swal("Error", "An error occurred Please try again");
                        $(".groupAction").hide();
                        $(".groupActionsContainer").hide();
                        $(".proposal_images").attr('checked', false);
                        $("#delete-images-status").dialog('close');
                        $.uniform.update();
                    });

                    $(this).dialog('close');
                    $("#deleteImagesStatus").html('Deleting images...<img src="/static/loading.gif" />');
                    $("#delete-images-status").dialog('open');

                }
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false,

    });


    // show-proposal-images
    $("#show-proposal-images").dialog({
        width: 500,
        modal: true,
        buttons: {
            "Save": {
                text: 'Show Proposal',
                'class': 'btn ui-button update-button',
                'id': 'confirmShowProposal',
                click: function () {

                    var image_ids = getSelectedIds();
                    var proposalId = '<?php echo $proposal->getProposalId(); ?>';

                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'ids': getSelectedIds(),
                            'proposalId': proposalId,
                        },
                        url: "<?php echo site_url('ajax/show_proposal_images') ?>",
                        dataType: "JSON"
                    })
                        .success(function (data) {

                            for ($j = 0; $j < image_ids.length; $j++) {
                                $("#active_" + image_ids[$j]).prop('checked', true);
                                $("#header_span_proposal_" + image_ids[$j]).show();
                            }

                            if (data.success) {
                                var resendText = data.count + ' Images were Show in Proposal';
                            } else {
                                var resendText = 'An error occurred. Please try again';
                            }

                            $("#showProposalImagesStatus").html(resendText);

                            $('#select_image_none').trigger('click');
                            $("#show-proposal-images-status").dialog('open');
                            $.uniform.update();

                        });

                    $(this).dialog('close');
                    $("#showProposalImagesStatus").html('Adding images...<img src="/static/loading.gif" />');
                    $("#show-proposal-images-status").dialog('open');

                }
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false,

    });

    // show-work-order-images
    $("#show-work-order-images").dialog({
        width: 500,
        modal: true,
        buttons: {
            "Save": {
                text: 'Show WorkOrder',
                'class': 'btn ui-button update-button',
                'id': 'confirmShowWorkOrder',
                click: function () {

                    var image_ids = getSelectedIds();
                    var proposalId = '<?php echo $proposal->getProposalId(); ?>';
                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'ids': getSelectedIds(),
                            'proposalId': proposalId,
                        },
                        url: "<?php echo site_url('ajax/show_work_order_images') ?>",
                        dataType: "JSON"
                    })
                        .success(function (data) {

                            for ($j = 0; $j < image_ids.length; $j++) {
                                $("#activewo_" + image_ids[$j]).prop('checked', true);
                                $("#header_span_workorder_" + image_ids[$j]).show();
                            }

                            if (data.success) {
                                var resendText = data.count + ' Images were Show in Work Order';
                            } else {
                                var resendText = 'An error occurred. Please try again';
                            }

                            $("#showWorkOrderImagesStatus").html(resendText);

                            $('#select_image_none').trigger('click');
                            $("#show-work-order-images-status").dialog('open');
                            $.uniform.update();

                        });

                    $(this).dialog('close');
                    $("#showWorkOrderImagesStatus").html('Adding images...<img src="/static/loading.gif" />');
                    $("#show-work-order-images-status").dialog('open');

                }
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false,

    });

    // hide-proposal-images
    $("#hide-proposal-images").dialog({
        width: 500,
        modal: true,
        buttons: {
            "Save": {
                text: 'Remove Proposal',
                'class': 'btn ui-button update-button',
                'id': 'confirmRemoveProposal',
                click: function () {

                    var image_ids = getSelectedIds();
                    var proposalId = '<?php echo $proposal->getProposalId(); ?>';
                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'ids': getSelectedIds(),
                            'proposalId': proposalId,
                        },
                        url: "<?php echo site_url('ajax/hide_proposal_images') ?>",
                        dataType: "JSON"
                    })
                        .success(function (data) {
                            for ($j = 0; $j < image_ids.length; $j++) {
                                $("#active_" + image_ids[$j]).prop('checked', false);
                                $("#header_span_proposal_" + image_ids[$j]).hide();

                            }

                            if (data.success) {
                                var resendText = data.count + ' Images were Remove in Proposal';
                            } else {
                                var resendText = 'An error occurred. Please try again';
                            }

                            $("#hideProposalImagesStatus").html(resendText);

                            $('#select_image_none').trigger('click');
                            $("#hide-proposal-images-status").dialog('open');

                            $.uniform.update();
                        });

                    $(this).dialog('close');
                    $("#hideProposalImagesStatus").html('Removing images...<img src="/static/loading.gif" />');
                    $("#hide-proposal-images-status").dialog('open');

                }
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false,

    });

    // hide-work-order-images
    $("#hide-work-order-images").dialog({
        width: 500,
        modal: true,
        buttons: {
            "Save": {
                text: 'Remove WorkOrder',
                'class': 'btn ui-button update-button',
                'id': 'confirmRemoveWorkOrder',
                click: function () {

                    var image_ids = getSelectedIds();
                    var proposalId = '<?php echo $proposal->getProposalId(); ?>';
                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'ids': getSelectedIds(),
                            'proposalId': proposalId,
                        },
                        url: "<?php echo site_url('ajax/hide_work_order_images') ?>",
                        dataType: "JSON"
                    })
                        .success(function (data) {
                            for ($j = 0; $j < image_ids.length; $j++) {
                                $("#activewo_" + image_ids[$j]).prop('checked', false);
                                $("#header_span_workorder_" + image_ids[$j]).hide();
                            }

                            if (data.success) {
                                var resendText = data.count + ' Images were Remove in Work Order';
                            } else {
                                var resendText = 'An error occurred. Please try again';
                            }

                            $("#hideWorkOrderImagesStatus").html(resendText);
                            $('#select_image_none').trigger('click');
                            // $(".groupAction").hide();
                            // $(".groupActionsContainer").hide();
                            $("#hide-work-order-images-status").dialog('open');

                            $.uniform.update();
                        });

                    $(this).dialog('close');
                    $("#hideWorkOrderImagesStatus").html('Removing images...<img src="/static/loading.gif" />');
                    $("#hide-work-order-images-status").dialog('open');

                }
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false,

    });


    $(document).on("change", "#images_layout", function (e) {


        // var image_ids =getAllImagesIds();
        // var proposalId = '<?php echo $proposal->getProposalId(); ?>';
        // var image_layout = $(this).val();
        // if(image_layout==0){

        //     var image_layout_html = '1 <i class="fa fa-fw fa-picture-o"></i>';
        //     var image_title = '1 Image Per Page';

        // }else if(image_layout==1){
        //     var image_layout_html = '2 <i class="fa fa-fw fa-picture-o"></i>';
        //     var image_title = '2 Images Per Page';
        // }
        // else{
        //     var image_layout_html = '4 <i class="fa fa-fw fa-picture-o"></i>';
        //     var image_title = '4 Images Per Page';
        // }

        // $.ajax({
        //             type: "POST",
        //             async: true,
        //             cache: false,
        //             data: {
        //                 'ids': image_ids,
        //                 'proposalId': proposalId,
        //                 'image_layout':image_layout
        //             },
        //             url: "<?php echo site_url('ajax/update_proposal_image_layout') ?>",
        //             dataType: "JSON"
        //         })
        //             .success(function (data) {
        //                 swal(
        //                                 'Success',
        //                                 'Image Layout Upddated'
        //                             );
        //                 for($j=0;$j<image_ids.length;$j++){
        //                     $("#images_layout_"+image_ids[$j]).val(image_layout);
        //                     // $("#header_span_workorder_"+image_ids[$j]).hide();
        //                     $("#header_span_image_"+image_ids[$j]).html(image_layout_html);
        //                     $("#header_span_image_"+image_ids[$j]).attr('title',image_title);
        //                 }


        //                 $.uniform.update();
        //                 initTiptip();
        //             });
    });


    // update_image_layout
    $("#update_image_layout").dialog({
        width: 500,
        modal: true,
        buttons: {
            "Save": {
                text: 'Update Image Layout',
                'class': 'btn ui-button update-button',
                'id': 'confirmupdateLayout',
                click: function () {

                    var image_ids = getSelectedIds();
                    var image_layout = $('#images_layout_popup').val();
                    var proposalId = '<?php echo $proposal->getProposalId(); ?>';
                    if (image_layout == 0) {

                        var image_layout_html = '1 <i class="fa fa-fw fa-picture-o"></i>';
                        var image_title = '1 Image Per Page';

                    } else if (image_layout == 1) {
                        var image_layout_html = '2 <i class="fa fa-fw fa-picture-o"></i>';
                        var image_title = '2 Images Per Page';
                    } else {
                        var image_layout_html = '4 <i class="fa fa-fw fa-picture-o"></i>';
                        var image_title = '4 Images Per Page';
                    }
                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'image_layout': $('#images_layout_popup').val(),
                            'ids': getSelectedIds(),
                            'proposalId': proposalId,
                        },
                        url: "<?php echo site_url('ajax/update_selected_image_layout') ?>",
                        dataType: "JSON"
                    })
                        .success(function (data) {
                            for ($j = 0; $j < image_ids.length; $j++) {
                                $("#images_layout_" + image_ids[$j]).val(image_layout);

                                $("#header_span_image_" + image_ids[$j]).html(image_layout_html);
                                $("#header_span_image_" + image_ids[$j]).attr('title', image_title);
                            }

                            if (data.success) {
                                var resendText = data.count + ' Images Layout updated';
                            } else {
                                var resendText = 'An error occurred. Please try again';
                            }

                            $("#updateLayoutImagesStatus").html(resendText);
                            $('#select_image_none').trigger('click');
                            // $(".groupAction").hide();
                            // $(".groupActionsContainer").hide();
                            $("#update-image-layout-status").dialog('open');

                            $.uniform.update();
                            initTiptip();
                        });

                    $(this).dialog('close');
                    $("#updateLayoutImagesStatus").html('Removing images...<img src="/static/loading.gif" />');
                    $("#update-image-layout-status").dialog('open');

                }
            },
            Cancel: function () {
                $(this).dialog("close");
            }
        },
        autoOpen: false,

    });


    $("#saveImagesLayout").click(function () {
        swal({
            title: "Are you sure?",
            text: "This will update the layout for all images",
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function (isConfirm) {
            if (isConfirm) {

                swal({
                    title: 'Saving..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })
                var image_ids = getAllImagesIds();
                var proposalId = '<?php echo $proposal->getProposalId(); ?>';
                var image_layout = $('#images_layout').val();
                if (image_layout == 0) {

                    var image_layout_html = '1 <i class="fa fa-fw fa-picture-o"></i>';
                    var image_title = '1 Image Per Page';

                } else if (image_layout == 1) {
                    var image_layout_html = '2 <i class="fa fa-fw fa-picture-o"></i>';
                    var image_title = '2 Images Per Page';
                } else {
                    var image_layout_html = '4 <i class="fa fa-fw fa-picture-o"></i>';
                    var image_title = '4 Images Per Page';
                }

                $.ajax({
                    type: "POST",
                    async: true,
                    cache: false,
                    data: {
                        'ids': image_ids,
                        'proposalId': proposalId,
                        'image_layout': image_layout
                    },
                    url: "<?php echo site_url('ajax/update_proposal_image_layout') ?>",
                    dataType: "JSON"
                })
                    .success(function (data) {
                        swal(
                            'Success',
                            'Image Layout Updated'
                        );
                        for ($j = 0; $j < image_ids.length; $j++) {
                            $("#images_layout_" + image_ids[$j]).val(image_layout);
                            // $("#header_span_workorder_"+image_ids[$j]).hide();
                            $("#header_span_image_" + image_ids[$j]).html(image_layout_html);
                            $("#header_span_image_" + image_ids[$j]).attr('title', image_title);
                        }
                        $(".proposal_images").attr('checked', false);


                        $.uniform.update();
                        initTiptip();
                    });


            } else {
                swal("Cancelled", "Your Estimation is safe :)", "error");
            }
        });
    });


    $("#duplicate_service").live('click', function () {
        var postData = {};
        postData.serviceId = $("#editServiceId").val();
        postData.proposal = <?php echo $this->uri->segment(3) ?>;


        $.ajax({
            type: "POST",
            url: "<?php echo site_url('ajax/proposalDuplicateService') ?>",
            data: postData,
            dataType: 'json'
        })
            .done(function (data) {

                if (!data.id) {
                    swal(
                        'Error',
                        'There was an error saving the information'
                    );
                    return;
                }

                var serviceName = data.serviceName;
                var serviceNameHtml = '<span class="serviceName" >' + serviceName + '</span></span>';

                var newServiceItem = '<div class="service clearfix" id="service_' + data.id + '">' +
                    '<span class="handle ui-icon ui-icon-arrowthick-2-n-s"></span>' +
                    '<span class="service' +
                    ((data.noPrice == 1) ? ' noPrice' : '') +
                    ((data.optional == 1) ? ' optional' : '') +
                    ((data.approved == 1) ? '' : 'unapproved') +
                    '">' +
                    '<span class="noPriceTag"><strong>[NP] </strong></span>' +
                    '<span class="optionalTag"><strong>[OS] </strong></span>' +
                    '<span class="unapprovedTag"><strong>[A] </strong></span>' +
                    serviceNameHtml +
                    '<span class="actions">' +
                    // '<a href="#" style="color: #7b7a7a;"><i class="fa fa-fw fa-image tiptip" title="Images"></i> <span class="serviceImageCount_'+data.id+'" style="color: red;">0 </span></a>'+
                    '<a class="btn-edit tiptip" title="Edit Service" rel="' + data.id + '" data-id="' + data.id + '">Edit</a> ' +
                    '<a class="btn-delete tiptip" title="Delete Service" data-id="' + data.id + '">Delete</a>' +
                    '</span></div>';
                $("#proposal_services").append(newServiceItem);
                $("#proposal_services").sortable('refresh');
                initTiptip();
                initButtons();
                $("#service_" + data.id).effect('highlight', {
                    color: '#25AAE1',
                    duration: 1500
                });

                // Now we need to reset the categories
                $("#selectService").html('<a href="#" rel="0">Select a category</a>');
                $(".selectOptions a").removeClass('selected');


                $("#editService").dialog('close');
                updateProposalServices();
                if (data.proposal_approval == 0) {

                    $('.has_email_permission').removeClass('send_proposal_email');
                    $('.has_email_permission').addClass('approval_proposal_email');
                } else {
                    $('.has_email_permission').addClass('send_proposal_email');
                    $('.has_email_permission').removeClass('approval_proposal_email');
                }

                swal(
                    'Saved',
                    'Service Duplicated'
                );


            })
            .fail(function (xhr) {
                swal(
                    'Error',
                    'There was an error saving the information: Error Information: ' + xhr.responseText
                );
            });
    });

    $("#select_background_image").change(function () {
        if ($(this).val() == 0) {
            $('.upload_image_p').show();
            //$("#previewContainer").hide();
        } else {
            $('.upload_image_p').hide();
            $('#currentImage').attr('src', $(this).find(':selected').attr('data-val'));
            $('.background_url').val($(this).find(':selected').attr('data-val'));
            $('.background_image').val($(this).val());

            $("#previewContainer").show();
        }

    });


    $('.show_logo').live('click', function () {
        if ($(this).val() == '0') {
            $('#preview-logo').hide();
        } else {
            $('#preview-logo').show();
        }
    })

    $(document).ready(function () {
        // Group Actions Button
        $("#groupActionsButton").click(function (e) {

            // Toggle the buttons
            //e.preventDefault();
            //e.stopPropagation();
            $(".groupActionsContainer").toggle();
        });

        $("#groupActionsButtonMap").click(function (e) {


            $(".groupActionsContainerMap").toggle();
        });

        $("#eventFilterButton").click(function () {

            $("#newProposalColumnFilters").toggle();

        });
        $('body').click(function (event) {

            var $trigger = $("#groupActionsButton");

            if ($trigger !== event.target && !$trigger.has(event.target).length) {
                $(".groupActionsContainer").hide();
            }

            var $trigger2 = $("#eventFilterButton");

            if ('eventFilterButton' !== event.target.id && !$trigger2.has(event.target).length) {
                $("#newProposalColumnFilters").hide();
            }

            var $trigger3 = $("#groupActionsButtonMap");

            if ($trigger3 !== event.target && !$trigger3.has(event.target).length) {
                $(".groupActionsContainerMap").hide();
            }
            //$('.groupActionsContainer').hide();

        });
    });

    $('#headerBgColor').change(function () {

        bgColor.push($(this).val());
        if (bgColor.length > 1) {
            $('#headerBgColorUndo').show();
        } else {
            $('#headerBgColorUndo').hide();
        }
    });

    $('#headerFontColor').change(function () {

        textColor.push($(this).val());
        if (textColor.length > 0) {
            $('#headerFontColorUndo').show();
        } else {
            $('#headerFontColorUndo').hide();
        }
    });

    $('#headerBgColorUndo').click(function () {

        $('#headerBgColor').val(bgColor[bgColor.length - 2]);
        $('#headerBgColor').css('background-color', '#' + bgColor[bgColor.length - 2])


        if (bgColor.length > 1) {
            bgColor.pop();
        }
        if (bgColor.length > 1) {
            $('#headerBgColorUndo').show();
        } else {

            $('#headerBgColorUndo').hide();
        }

    });

    $('#headerFontColorUndo').click(function () {
        $('#headerFontColor').val(textColor[textColor.length - 2])
        $('#headerFontColor').css('background-color', '#' + textColor[textColor.length - 2])
        if (textColor.length > 1) {
            textColor.pop();
        }

        if (textColor.length > 1) {
            $('#headerFontColorUndo').show();
        } else {

            $('#headerFontColorUndo').hide();
        }

    });


    $(document).on("click", ".send_proposal_email", function (e) {
        var cc_setting = '<?php echo ($account->getProposalEmailCC()) ? TRUE : FALSE; ?>';
        email_to_input_count = 1; 
        var project_id = $(this).attr('data-val');
        var client_id = $(this).attr('data-client-id');
        var project_name = $(this).attr('data-project-name');
        var project_contact_name = $(this).attr('data-client-name');
        tinymce.remove('#email_content');
        swal({
            title: "<i class='fa fw fa-envelope'></i> Send Proposal",
            html: '<p style="font-weight: bold; font-size: 14px;"><span style="position:absolute;left: 0px;"><span style="display: block; float: left;  color: #595959; text-align: left; margin-right: 10px;"><i class="fa fw fa-file-pdf-o"></i> Project: </span><span class="shadowz" style="float:left"><a class="tiptip" href="proposals/edit/' + project_id + '" title="Edit Project Info">' + project_name + '</a></span></span>' +
                '<br/><span style="position:absolute;left:0px;margin-top:3px" ><span style="display: block;float: left;margin-right:7px;  color: #595959; text-align: left; "><i class="fa fw fa-user"></i> Contact: </span><span style="float:left;"><a style="float:left"  href="clients/edit/' + client_id + '/' + project_id + '">' + project_contact_name + '</a></span></span></p><br><hr/>' +
                '<form id="send_proposal_email" >' +
                '<input type="hidden" id="send_proposal_id" name="send_proposal_id" value="' + project_id + '">' +
                '<input type="hidden" class="" name="send_email" value="Send">' +
                '<input type="hidden" name="proposal_id" value="' + project_id + '">' +
                '<table class="boxed-table pl-striped" style="border-bottom:0px"; width="100%" cellpadding="0" cellspacing="0">' +
                '<tr>' +
                '<td><label style="width: 150px;text-align: left;"> Email Template <span>*</span></label><span class="cwidth4_container" style="float: left;"><select style="border-radius: 3px;padding: 0.4em;width: 314px;" id="sendTemplateSelect"><?php foreach ($clientTemplates as $template) { ?><option data-template-id="<?php echo $template->getTemplateId(); ?>"><?php echo str_replace('\'', '\\\'', $template->getTemplateName()); ?></option><?php } ?></select></span></td>' +
                '<td></td>' +
                '</tr>' +
                '<tr>' +
                    '<td colspan="2" class="send_proposal_to_field_td"><label for="" style="width: 150px;text-align: left;"> To <span>*</span></label><div class="send_proposal_to_field_div"><div class="buttonInside"><input type="text" id="popup_email_to" name="to[]" class="text send_to "   style="width: 300px; float: right;" required value=""><button type="button" class="add_email_to tiptiptop" title="Add More Emails"><i class="fa fa-plus" aria-hidden="true"></i></button></div></div></td>' +
                    
                '</tr>'+
                '<tr>' +
                    '<td><label for="" style="width: 150px;text-align: left;"> Subject <span>*</span></label><input type="text" name="subject" required class="text input60 number_field send_subject" title="Separate email addresses by commas" style="width: 300px; float: left;" id="poup_email_subject"  value=""></td>' +
                    '<td></td>' +
                '</tr>' +
                '<tr>' +
                '<td colspan="2"><br/><textarea cols="40" rows="10" id="email_content" name="message">Brief Description here...</textarea></td>' +
                '</tr>' +
                '</table>' +
                '<input type="checkbox" value="1" name="ccIndividualEmail" id="ccIndividualEmail" style="float: left; margin: 10px;"><p style="font-size: 12px;font-weight: bold;padding: 10px 0px 8px 10px;"><span style="float: left;">Send me a copy of this email</span><span class="send_popup_validation_msg" style="display:none;float:right;font-size: 12px;font-weight: bold;padding: 0px 0px 8px 10px;text-align: left;color: #f00;">Please Fill all required fields.</span></p></form>',

            showCancelButton: true,
            width: '950px',
            confirmButtonText: '<i class="fa fw fa-envelope"></i> Send',
            cancelButtonText: "<i class='fa fw fa-times'></i> Cancel",
            dangerMode: false,
            showCloseButton: true,
            onOpen: function () {
                $("#ccIndividualEmail").prop('checked', cc_setting);
                tinymce.init({
                    selector: "#email_content",
                    menubar: false,
                    elementpath: false,
                    relative_urls: false,
                    remove_script_host: false,
                    convert_urls: true,
                    browser_spellcheck: true,
                    contextmenu: false,
                    paste_as_text: true,
                    height: '320',
                    setup: function (ed) {
                        ed.on('keyup', function (e) {
                            check_popup_validation()
                        });
                    },
                    init_instance_callback : "loadTemplateContents",
                    plugins: "link image code lists paste preview ",
                    toolbar: tinyMceMenus.email,
                    forced_root_block_attrs: tinyMceMenus.root_attrs,
                    fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
                });

                //loadTemplateContents();
                $('.swal2-modal').attr('id', 'send_proposal_popup');

                // Tiptip the address inputs
                initTiptip();
                // Uniform the select
                $("#sendTemplateSelect").uniform();
            }
        }).then(function (result) {
            swal({
                title: 'Sending..',
                allowEscapeKey: false,
                allowOutsideClick: false,
                timer: 10000,
                onOpen: () => {
                    swal.showLoading();
                    $('.swal2-modal').attr('id', '')
                }
            })
            var values, index;

            // Get the parameters as an array
            values = $("#send_proposal_email").serializeArray();

            // Find and replace `content` if there
            for (index = 0; index < values.length; ++index) {
                if (values[index].name == "message") {
                    values[index].value = tinymce.get("email_content").getContent();
                    ;
                    break;
                }
            }
            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: values,
                url: "<?php echo site_url('ajax/send_proposal_individual') ?>?" + Math.floor((Math.random() * 100000) + 1),
                dataType: "JSON"
            }).success(function (data) {
                var activeTabId = $("#proposal-tabs").tabs("option", "active");
                if (activeTabId == 6) {
                    ViewsDatatable.fnReloadAjax();
                }


                swal('', 'Email Sent Successfully.');

            });


        });
        return false;
    });

    $(document).on("click",".add_email_to",function(e) {
        if(email_to_input_count < 5){
            $('.send_proposal_to_field_div').append('<div class="buttonInside"><input type="text"  name="to[]" class="text send_to"  style="width: 300px; float: right;" required value=""><button type="button" class="remove_email_to tiptiptop" title="Remove"><i class="fa fa-close" aria-hidden="true"></i></button></div>')
            initTiptip();
            email_to_input_count++;
        }
        
    });

    $(document).on("click",".remove_email_to",function(e) {
        $(this).closest('.buttonInside').remove();
    });
     

    function isValidEmailAddress(emailAddress) {
        var pattern = /^([a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+(\.[a-z\d!#$%&'*+\-\/=?^_`{|}~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]+)*|"((([ \t]*\r\n)?[ \t]+)?([\x01-\x08\x0b\x0c\x0e-\x1f\x7f\x21\x23-\x5b\x5d-\x7e\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|\\[\x01-\x09\x0b\x0c\x0d-\x7f\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))*(([ \t]*\r\n)?[ \t]+)?")@(([a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\d\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.)+([a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]|[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF][a-z\d\-._~\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]*[a-z\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])\.?$/i;
        return pattern.test(emailAddress);
    }

    $(document).on("click", ".approval_proposal_email", function (e) {
        var project_id = $(this).attr('data-val');
        var client_id = $(this).attr('data-client-id');
        var project_name = $(this).attr('data-project-name');
        var project_contact_name = $(this).attr('data-client-name');
        template = $("#approval_email_template").html();

        //window.location.href= '/proposals/edit/' + project_id + '/send';
        //return false;

        template = template.toString()

        swal({
            title: "<i class='fa fw fa-envelope'></i> Send Proposal in Approval Queue",
            html: template,

            showCancelButton: true,
            width: '950px',
            confirmButtonText: '<i class="fa fw fa-envelope"></i> Send',
            cancelButtonText: "<i class='fa fw fa-times'></i> Cancel",
            dangerMode: false,
            showCloseButton: true,
            onOpen: function () {
                //$.uniform.update();
                $('.approval_recipients').uniform();
                $('.swal2-modal').attr('id', 'send_proposal_popup')
            },

        }).then(function (result) {

            var approval_recipients = $('#send_proposal_popup').find('.approval_recipients');
            var recipients = {};
            for ($i = 0; $i < approval_recipients.length; $i++) {
                //console.log('fff')
                if ($(approval_recipients[$i]).is(":checked")) {
                    recipients[$(approval_recipients[$i]).attr('data-val')] = $(approval_recipients[$i]).val()
                }
            }

            approval_msg = $('#send_proposal_popup').find('.approval_email_message').val();

            //return false;
            swal({
                title: 'Sending..',
                allowEscapeKey: false,
                allowOutsideClick: false,
                timer: 10000,
                onOpen: () => {
                    swal.showLoading();
                    $('.swal2-modal').attr('id', '')
                }
            })
            $.ajax({
                type: "POST",
                async: true,
                cache: false,
                data: {
                    'proposal_id': project_id,
                    'message': approval_msg,
                    'recipients': recipients

                },
                url: "<?php echo site_url('ajax/send_proposal_approval_request') ?>?" + Math.floor((Math.random() * 100000) + 1),
                dataType: "JSON"
            }).success(function (data) {
                console.log(data);

                swal('', 'Request Submited.');
                window.location.href = '/proposals';

            });

            return false;


        }).catch(swal.noop);


        return false;
    });


    function get_approval_msg() {
        return $('#send_proposal_popup').find('.approval_email_message').val();
    }

    $(document).on("keyup", "#poup_email_subject,#popup_email_to", function (e) {
        if ($(this).val()) {
            $(this).removeClass('error');

        } else {
            $(this).addClass('error');

        }
        check_popup_validation()

    });

    function check_popup_validation() {
        if (tinymce.get("email_content").getContent() == '' || $('#poup_email_subject').val() == '' || $('#popup_email_to').val() == '') {
            $('.send_popup_validation_msg').show();
            $('#send_proposal_popup .swal2-confirm').attr('disabled', true);
        } else {
            if(isValidEmailAddress($('#popup_email_to').val())){
            $('#popup_email_to').removeClass('error');
                $('.send_popup_validation_msg').hide();
                $('#send_proposal_popup .swal2-confirm').attr('disabled', false);
            }else{
                $('#popup_email_to').addClass('error');
                $('.send_popup_validation_msg').show();
                $('#send_proposal_popup .swal2-confirm').attr('disabled', true);
            }
        }
    }


    // Tmeplate change handler
    $(document).on("change", "#sendTemplateSelect", function (e) {

        loadTemplateContents();
    });

    function loadTemplateContents() {

        var selectedTemplate = $('#sendTemplateSelect option:selected').data('template-id');

        $.ajax({
            type: "POST",
            async: true,
            cache: false,
            data: {
                'templateId': selectedTemplate,
                'proposalId': $('#send_proposal_id').val()
            },
            url: "<?php echo site_url('account/ajaxGetProposalTemplateParsed') ?>?" + Math.floor((Math.random() * 100000) + 1),
            dataType: "JSON"
        }).success(function (data) {
            $(".send_subject").val(data.templateSubject);
            if (!$(".send_to").val()) {
                $(".send_to").val(data.email_to);
            }
            //CKEDITOR.instances.email_content.setData(data.templateBody);
            tinymce.get("email_content").setContent(data.templateBody);

        });

        $.uniform.update();
    }

    $("#estimatepreview").click(function () {

        $("#estimatepreviewDialog").dialog('open');
        $("#estimate-preview-iframe").hide();
        $("#estimatepreviewPDF").show();
        $("#estimatepreviewWEB").hide();
        
        // Show the loader
        $("#loadingFrame").show();
        // Refresh the iframe - Load event will handle showing the frame and hiding the loader
        var currSrc = $(this).data('preview-url');
        $("#estimate-preview-iframe").attr("src", currSrc);
        $("#estimatepreviewDialog").find('.proposal_link_copy').attr("data-proposal-link", currSrc);

    });

    $(document).on("click",".proposal_link_copy",function(e) {

        if($(this).attr('data-action') != 1){
            $('.proposal_link_copy span').html('<i class="fa fa-fw fa-copy"></i> Link Copied');
        }
        const el = document.createElement('textarea');
        el.value = $(this).attr('data-proposal-link');
        document.body.appendChild(el);
        el.select();
        document.execCommand("copy");
        document.body.removeChild(el);
        //$('.flash_copy_msg').fadeIn()
        
        if($(this).attr('data-action') == 1){
            swal('','Proposal Link Copied')
        }else{
            setTimeout(function(){
                $('.proposal_link_copy span').html('<i class="fa fa-fw fa-copy"></i> Copy Link');// or fade, css display however you'd like.
            }, 3000);
        }
        
        return false;
    });

    $("#estimatepreviewWEB").click(function () {

        $("#estimatepreviewDialog").dialog('open');
        $("#estimate-preview-iframe").hide();
        $("#estimatepreviewPDF").show();
        $("#estimatepreviewWEB").hide();
        // Show the loader
        $("#loadingFrame").show();
        // Refresh the iframe - Load event will handle showing the frame and hiding the loader
        var currSrc = $(this).data('preview-url');
        $("#estimate-preview-iframe").attr("src", currSrc);

    });

    $("#estimatepreviewPDF").click(function () {

        $("#estimatepreviewDialog").dialog('open');
        $("#estimate-preview-iframe").hide();
        $("#estimatepreviewPDF").hide();
        $("#estimatepreviewWEB").show();
        // Show the loader
        $("#loadingFrame").show();
        // Refresh the iframe - Load event will handle showing the frame and hiding the loader
        var currSrc = $(this).data('preview-url');
        $("#estimate-preview-iframe").attr("src", currSrc);

    });

    document.getElementById('estimate-preview-iframe').onload = function () {
        $("#loadingFrame").hide();
        $("#estimate-preview-iframe").show();
    }


    $(document).on("click", ".preview_active_inactive", function (e) {
        var proposal_id = $(this).attr('data-proposal-id');
        var is_active = $(this).attr('data-preview-active');
        var preview_id = $(this).attr('data-preview-id');
        var active_msg = (is_active == 1) ? 'disable' : 'enable';
        var active_msg_cap = (is_active == 1) ? 'Disable' : 'Enable';

        swal({
            title: "Are you sure?",
            text: "This will " + active_msg + " this proposal link",
            showCancelButton: true,
            confirmButtonText: active_msg_cap,
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function (isConfirm) {
            if (isConfirm) {

                swal({
                    title: 'Saving..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })

                $.ajax({
                    type: "POST",
                    async: true,
                    cache: false,
                    data: {
                        'proposal_id': proposal_id,
                        'is_active': (is_active == 1) ? 0 : 1,
                        'preview_id': preview_id

                    },
                    url: "<?php echo site_url('ajax/proposal_preview_active_inactive') ?>?" + Math.floor((Math.random() * 100000) + 1),
                    dataType: "JSON"
                }).success(function (data) {
                    console.log(data);

                    swal('', 'Proposal Link Updated');
                    ViewsDatatable.fnReloadAjax();

                });

                return false;
            } else {
                swal("Cancelled", "Your Preview is safe :)", "error");
            }
        });

    });

    $(document).on("click", ".preview_signature_enable_disable", function (e) {
        var proposal_id = $(this).attr('data-proposal-id');
        var is_active = $(this).attr('data-preview-signature');
        var preview_id = $(this).attr('data-preview-id');
        var active_msg = (is_active == 1) ? 'disable' : 'enable';
        var active_msg_cap = (is_active == 1) ? 'Disable' : 'Enable';

        swal({
            title: "Are you sure?",
            text: "This will " + active_msg + " this proposal Signature",
            showCancelButton: true,
            confirmButtonText: active_msg_cap,
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function (isConfirm) {
            if (isConfirm) {

                swal({
                    title: 'Saving..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })

                $.ajax({
                    type: "POST",
                    async: true,
                    cache: false,
                    data: {
                        'proposal_id': proposal_id,
                        'is_active': (is_active == 1) ? 0 : 1,
                        'preview_id': preview_id

                    },
                    url: "<?php echo site_url('ajax/proposal_preview_signature_active_inactive') ?>?" + Math.floor((Math.random() * 100000) + 1),
                    dataType: "JSON"
                }).success(function (data) {
                    console.log(data);

                    swal('', 'Proposal Signature Setting Updated');
                    ViewsDatatable.fnReloadAjax();

                });

                return false;
            } else {
                swal("Cancelled", "Your Preview is safe :)", "error");
            }
        });

    });

    // Creation Date change
    $("#dcDate").datepicker();


    $(document).on("click", ".set_expiry", function (e) {
        $("#expiry_proposal_id").val($(this).attr('data-proposal-id'));
        $("#expiry_preview_id").val($(this).attr('data-preview-id'));
        $("#date-change-confirm").dialog('open');

    });


    $("#date-change-confirm").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: {
                'text': 'Continue',
                'class': 'btn ui-button update-button',
                click: function () {

                    var expiryDate = $("#dcDate").val();
                    var expiry_preview_id = $("#expiry_preview_id").val();

                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'expiry_preview_id': expiry_preview_id,
                            'expiryDate': expiryDate
                        },
                        url: "<?php echo site_url('ajax/set_proposal_preview_expiry') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"
                    })
                        .success(function (data) {

                            if (data.succes) {
                                swal('', 'Preview Expiry Set');
                                ViewsDatatable.fnReloadAjax();
                            } else {
                                swal('', 'An error occurred. Please try again');

                            }

                            $("#date-change-confirm").dialog('close');
                        });

                }
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        },
        autoOpen: false
    });


    $(document).ready(function () {

        // define the form and the file input
        var $form = $('#myform');

        // enable fileuploader plugin
        $form.find('input:file').fileuploader({
            limit: 1,
            maxSize: 50,

            addMore: true,
            changeInput: '<div class="fileuploader-input"><div class="fileuploader-input-caption"><span>${captions.feedback} ${captions.or}</span></div><div class="fileuploader-input-button"><span>${captions.button}</span></div></div>',
            theme: 'onebutton',
            upload: true,
            enableApi: true,
            dialogs: {
                // alert dialog
                alert: function (text) {
                    console.log('ddggg')
                    return swal('', text)
                    // alert(text);
                },

                // confirm dialog
                confirm: function (text, callback) {
                    confirm(text) ? callback() : null;
                }
            },
            onSelect: function (item) {
                item.upload = null;
            },
            onRemove: function (item) {
                if (!item.choosed) {
                    //remove_saved_thumb_image();
                }

            },


            captions: $.extend(true, {}, 'Test', {
                feedback: 'Choose file to upload',
                or: '',
                button: 'Choose File'
            })
        });

        // form submit
        $form.on('submit', function (e) {
            e.preventDefault();

            var formData = new FormData(),
                _fileuploaderFields = [];

            // append inputs to FormData
            $.each($form.serializeArray(), function (key, field) {
                formData.append(field.name, field.value);
            });
            // append file inputs to FormData
            $.each($form.find("input:file"), function (index, input) {
                var $input = $(input),
                    name = $input.attr('name'),
                    files = $input.prop('files'),
                    api = $.fileuploader.getInstance($input);


                // add fileuploader files to the formdata
                if (api) {
                    if ($.inArray(name, _fileuploaderFields) > -1)
                        return;
                    files = api.getChoosedFiles();
                    _fileuploaderFields.push($input);
                }

                for (var i = 0; i < files.length; i++) {
                    formData.append(name, (files[i].file ? files[i].file : files[i]), (files[i].name ? files[i].name : false));
                }
            });

            $.ajax({
                url: $form.attr('action') || '#',
                data: formData,
                type: $form.attr('method') || 'POST',
                enctype: $form.attr('enctype') || 'multipart/form-data',
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function () {
                    $form.find('.form-status').html('<div class="progressbar-holder"><div class="progressbar"></div></div>');
                    $form.find('input[type="submit"]').attr('disabled', 'disabled');
                },
                xhr: function () {
                    var xhr = $.ajaxSettings.xhr();

                    if (xhr.upload) {
                        xhr.upload.addEventListener("progress", this.progress, false);
                    }

                    return xhr;
                },
                success: function (result, textStatus, jqXHR) {
                    // update input values
                    try {
                        var data = JSON.parse(result);

                        for (var key in data) {
                            var field = data[key],
                                api;

                            // if fileuploader input
                            if (field.files) {
                                var input = _fileuploaderFields.filter(function (element) {
                                        return key == element.attr('name').replace('[]', '');
                                    }).shift(),
                                    api = input ? $.fileuploader.getInstance(input) : null;

                                if (field.hasWarnings) {
                                    for (var warning in field.warnings) {
                                        alert(field.warnings[warning]);
                                    }

                                    return this.error ? this.error(jqXHR, textStatus, field.warnings) : null;
                                }

                                if (api) {
                                    // update the fileuploader's file names
                                    for (var i = 0; i < field.files.length; i++) {
                                        $.each(api.getChoosedFiles(), function (index, item) {
                                            if (field.files[i].old_name == item.name) {
                                                item.name = field.files[i].name;
                                                item.html.find('.column-title > div:first-child').text(field.files[i].name).attr('title', field.files[0].name);
                                            }
                                            item.data.uploaded = true;
                                        });
                                    }

                                    api.updateFileList();
                                }
                            } else {
                                $form.find('[name="' + key + '"]:input').val(field);
                            }
                        }
                    } catch (e) {
                    }

                    $form.find('.form-status').html('');
                    swal('', 'Proposal Updated');
                    $form.find('input[type="submit"]').removeAttr('disabled');
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $form.find('.form-status').html('<p class="text-error">Error!</p>');
                    $form.find('input[type="submit"]').removeAttr('disabled');
                },
                progress: function (e) {
                    if (e.lengthComputable) {
                        var t = Math.round(e.loaded * 100 / e.total).toString();

                        $form.find('.form-status .progressbar').css('width', t + '%');
                    }
                }
            });
        });
    });

    function remove_saved_thumb_image(video_id) {
        swal({
            title: "Are you sure?",
            text: "This will Delete the Video Thumb Image",
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function (isConfirm) {
            if (isConfirm) {

                swal({
                    title: 'Deleting..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })
                $.ajax({
                    type: "GET",
                    url: "<?php echo site_url('ajax/remove_proposal_video_thumb_image') ?>/" + video_id,
                    async: false,
                    dataType: 'json',
                    success: function (data) {

                        // Proposal either has snow, or no other services
                        if (data.success) {
                            // No problem here, move along
                            swal('', 'Image deleted');

                            var final_url = $('#video_' + video_id).find('.image-area').attr('data-final-url');
                            var button_show = $('#video_' + video_id).find('.image-area').attr('data-button-show');
                            $('#video_' + video_id).find('.remove-image').hide();
                            $('.proposalVideoImageUploaderDiv[data-video-id="' + video_id + '"]').show();
                            $('.deleteThumbnail[data-video-id="' + video_id + '"]').hide(); 
                            $('.playerIconDiv[data-video-id="' + video_id + '"]').hide(); 
                            $('.playerIconColorDiv[data-video-id="' + video_id + '"]').hide();

                            if (data.defaultThumbImage) {
                                $('#video_' + video_id).find('#thumb_preview_img').attr('src', data.companyThumbImage);
                                $('#video_' + video_id).find('.image-area').attr('data-proposal-thumb-image', '');
                            } else {

                                if (button_show == 1) {
                                    var new_content = '<a href="' + final_url + '" class="btn btn-primary" style="width:150px;" target="_blank">Proposal Video</a>';
                                } else {
                                    var new_content = '<iframe class="embed-responsive-item" src="' + final_url + '" allowfullscreen loading="lazy" allow="autoplay"></iframe>';
                                }
                                initButtons();
                                $('#video_' + video_id).find('.image-area').html(new_content);
                            }
                        } else {
                            swal('', 'image not deleted');
                        }
                    }
                });
            } else {
                swal("Cancelled", "Your Thumb Image is safe :)", "error");
            }
        });
    }

    function resetAllVideoThumbUploader() {


        $(".proposalVideoImageUploaderDiv").each(function () {
            var video_id = $(this).attr('data-video-id');
            $(this).html('<p style="margin-top: 15px;"><strong>Video Thumbnail</strong></p><input accept="image/*" class="proposalVideoThumbImageUploader" type="file" name="files" data-video-id="' + video_id + '">');
        });
    }

    function enable_fileupload_plugin() {
        // enable fileupload plugin
        thumbfileuploader = $('.proposalVideoThumbImageUploader').fileuploader({
            enableApi: true,
            limit: 1,
            maxSize: 60,
            fileMaxSize: 20,
            changeInput: function (options) {
                return '<div class="changed_upload_thumb"><img width="25" src="<?php echo site_url('static/images/add_images.png');?>"><p>Upload Thumbnail</p></div>';
            },
            extensions: ['jpg', 'png', 'jpeg', 'heif', 'heic', 'tiff', 'tif', 'gif'],
            dialogs: {
                // alert dialog
                alert: function (text) {
                    return swal('', text)
                    // alert(text);
                },

                // confirm dialog
                confirm: function (text, callback) {
                    confirm(text) ? callback() : null;
                }
            },
            // Callback fired on selecting and processing a file
            onSelect: function (item, listEl, parentEl, newInputEl, inputEl) {
                // callback will go here
                //console.log(item)
                //console.log(parentEl)
                //console.log(inputEl)
            },
            upload: {
                url: "<?php echo site_url('ajax/proposalVideoThumbImageUpload') ?>",

                data: null,
                type: 'POST',
                enctype: 'multipart/form-data',
                start: true,
                synchron: true,

                beforeSend: function (item, listEl, parentEl, newInputEl, inputEl) {
                    console.log();
                    item.upload.data.proposalId = '<?= $proposal->getProposalId(); ?>';
                    item.upload.data.proposalVideoId = $(inputEl).attr('data-video-id');
                },
                onSuccess: function (result, item) {
                    var companyId = '<?php echo $proposal->getOwner()->getCompanyId(); ?>';
                    var proposalId = '<?php echo $proposal->getProposalId(); ?>';
                    var data = JSON.parse(result),
                        nameWasChanged = false;

                    // get the new file name
                    if (data.isSuccess) {

                        item.html.find('.column-title div').animate({
                            opacity: 0
                        }, 400);
                        item.html.find('.column-actions').append('<a class="fileuploader-action fileuploader-action-remove fileuploader-action-success" title="Remove"><i></i></a>');
                        setTimeout(function () {
                            item.html.find('.column-title div').attr('title', item.name).text(item.name).animate({
                                opacity: 1
                            }, 400);
                            item.html.find('.progress-bar2').fadeOut(400);
                        }, 400);

                        var image_path = '<?php echo $proposal->getSitePathUploadDir(); ?>/';
                        image_path = image_path + data.path;
                        var video_id = data.video_id;

                        var final_url = $('#image-area_' + video_id).attr('data-final-url');
                        var button_show = $('#image-area_' + video_id).attr('data-button-show');
                        $('.deleteThumbnail[data-video-id="' + video_id + '"]').show();

                        var iconDisplay = ($('#player_icon_hide'+video_id).prop('checked')) ?'none':'';

                        var new_content = '<img id="thumb_preview_img" src="' + image_path + '" >' +
                            '<div class="play-overlay" id="player_overlay'+video_id+'" style="display:'+iconDisplay+';">' +
                            '<a href="javascript:void(0)" class="play-icon">' +
                            '<img style="width: 70px;" src="<?php echo site_url('static/images/video-player-icon.png') ?>">' +
                            '</a>' +
                            '</div>';

                        if (button_show == 1) {

                            new_content += '<!-- <a href="' + data.embeded_url + '" class="btn btn-primary" style="width:150px;" target="_blank">Proposal Video</a> -->';
                        } else {

                            new_content += '<!-- <iframe class="embed-responsive-item" src="' + final_url + '?autoplay=1" allowfullscreen loading="lazy" allow="autoplay"></iframe> -->';
                        }
                        initButtons();
                        initTiptip();
                        $('#image-area_' + video_id).closest('.is_video_added').find('.remove-image').show();
                        $('#image-area_' + video_id).html(new_content);
                        $('.proposalVideoImageUploaderDiv[data-video-id="' + video_id + '"]').hide();

                        $('.playerIconDiv[data-video-id="' + video_id + '"]').show();
                        $('.playerIconColorDiv[data-video-id="' + video_id + '"]').show();
                        
                        $('#image-area_' + video_id).attr('data-proposal-thumb-image', image_path);
                        $('#image-area_' + video_id).removeClass('player');


                    } else {

                        if (data.warnings) {
                            swal('', 'File Not Uploaded<br>Error:' + data.warnings[0], "error")
                        }

                        var progressBar = item.html.find('.progress-bar2');

                        // make HTML changes
                        if (progressBar.length > 0) {
                            progressBar.find('span').html(0 + "%");
                            progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
                            item.html.find('.progress-bar2').fadeOut(400);
                        }

                        item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
                            '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
                        ) : null;
                    }
                },
                onError: function (item) {
                    var progressBar = item.html.find('.progress-bar2');

                    // make HTML changes
                    if (progressBar.length > 0) {
                        progressBar.find('span').html(0 + "%");
                        progressBar.find('.fileuploader-progressbar .bar').width(0 + "%");
                        item.html.find('.progress-bar2').fadeOut(400);
                    }

                    item.upload.status != 'cancelled' && item.html.find('.fileuploader-action-retry').length == 0 ? item.html.find('.column-actions').prepend(
                        '<a class="fileuploader-action fileuploader-action-retry" title="Retry"><i></i></a>'
                    ) : null;
                },
                onProgress: function (data, item) {
                    var progressBar = item.html.find('.progress-bar2');

                    // make HTML changes
                    if (progressBar.length > 0) {
                        progressBar.show();
                        progressBar.find('span').html(data.percentage + "%");
                        progressBar.find('.fileuploader-progressbar .bar').width(data.percentage + "%");
                    }
                },
                onComplete: function (listEl, parentEl, newInputEl, inputEl, jqXHR, textStatus) {

                    setTimeout(reset_thumb_uploader(), 300);
                },
            },
            onRemove: function (item) {
                // send POST request
                $.post('./php/ajax_remove_file.php', {
                    file: item.name
                });
            },
            captions: $.extend(true, {}, 'Test', {
                feedback: 'Upload Thumbnail',
                or: '',
                button: 'Add Images'
            })
        });
    }

    function reset_thumb_uploader() {
        // thumbfileuploaderApi = $.fileuploader.getInstance(thumbfileuploader);
        // //thumbfileuploaderApi.destroy();
        // thumbfileuploaderApi.reset();
        //enable_fileupload_plugin
        $('.proposalVideoThumbImageUploader').each(function () {
            var api = $.fileuploader.getInstance(this);

            api.reset();
        })
    }


    $(function () {
        var videos = $(".image-area");
        $(document).on("click", ".image-area", function () {


            if ($(this).find('#thumb_preview_img').length) {
                $(this).attr('data-image-url', $(this).find('#thumb_preview_img').attr('src'));
                var elm = $(this),
                    conts = elm.contents(),
                    le = conts.length,
                    ifr = null;

                for (var i = 0; i < le; i++) {
                    if (conts[i].nodeType == 8) ifr = conts[i].textContent;
                }

                elm.addClass("player").html(ifr);
                elm.off("click");
                $(this).closest('.is_video_added').find('.remove-image').hide();

                $(this).closest('.is_video_added').find('.back-to-image').show();
            }
        });
    });

    function show_saved_thumb_image(e) {

        var image_path = $(e).closest('.is_video_added').find('.image-area').attr('data-image-url');

        var video_id = $(e).closest('.is_video_added').find('.image-area').attr('data-video-id');

        var company_video_id = $(e).closest('.is_video_added').find('.image-area').attr('data-company-video-id');
        var proposal_thumb = $(e).closest('.is_video_added').find('.image-area').attr('data-proposal-thumb-image');

        var final_url = $(e).closest('.is_video_added').find('.image-area').attr('data-final-url');
        var button_show = $(e).closest('.is_video_added').find('.image-area').attr('data-button-show');


        if (proposal_thumb != '') {

            $(e).closest('.is_video_added').find('.remove-image').show();
        }

        console.log(video_id);
        var iconDisplay = ($('#player_icon_hide'+video_id).prop('checked')) ?'none':'';

        var new_content = '<img id="thumb_preview_img" src="' + image_path + '" style="">' +
            '<div class="play-overlay" id="player_overlay'+video_id+'" style="display:'+iconDisplay+';">' +
            '<a href="javascript:void(0)" class="play-icon">' +
            '<img style="width: 70px;" src="<?php echo site_url('static/images/video-player-icon.png') ?>">' +
            '</a>' +
            '</div>';
        if (button_show == 1) {
            new_content += '<!-- <a href="' + final_url + '" class="btn btn-primary" style="width:150px;" target="_blank">Proposal Video</a> -->';
        } else {
            new_content += '<!-- <iframe class="embed-responsive-item" src="' + final_url + '?autoplay=1" allowfullscreen loading="lazy" allow="autoplay"></iframe> -->';
        }
        initButtons();
        $(e).closest('.is_video_added').find('.image-area').html(new_content);
        $(e).closest('.is_video_added').find('.image-area').removeClass('player');
        $(e).hide();
    }


    // Group Actions Button
    $(document).on("click", "#groupActionsButtonPreview", function () {

        // Hide the filter
        $("#newProposalFilters").hide();
        // Toggle the buttons
        $(".groupActionsContainer").toggle();
    });

    //Hide Menu when clicking on a group action item
    $(document).on("click", ".groupActionItemsPreview a", function () {
        $("#groupActionsContainer").hide();
        return false;
    });

    $("#previewMasterCheck").live('change', function () {
        var checked = $(this).is(":checked");
        $(".previewGroupSelect").prop('checked', checked);
        updatePreviewNumSelected();
    });

    // Update the counter after each change
    $(".previewGroupSelect").live('change', function () {
        updatePreviewNumSelected();
    });

    // All / None user master check
    $("#previewMasterCheck").live('change', function () {
        var checked = $(this).is(":checked");
        $(".previewGroupSelect").prop('checked', checked);
        updatePreviewNumSelected();
    });

    function getSelectedPreviewIds() {
        var IDs = new Array();
        $(".previewGroupSelect:checked").each(function () {
            IDs.push($(this).val());
        });
        return IDs;
    }


    // Group action selected numbers
    function updatePreviewNumSelected() {
        var num = $(".previewGroupSelect:checked").length;
        // Hide the options if 0 selected
        if (num < 1) {

            $("#groupActionsButtonPreview").hide();
            $(".groupActionsContainer").hide();
        } else {

            $("#groupActionsButtonPreview").show();
        }
    }

    function uncheckAllPreviewGroupCheckbox() {
        $(".previewGroupSelect").prop('checked', false);
        $("#previewMasterCheck").prop('checked', false);
        $.uniform.update();
        updatePreviewNumSelected();
    }


    $("#groupRemoveExpiry").click(function () {

        var proposal_id = $(this).attr('data-proposal-id');
        swal({
            title: "Are you Sure?",
            text: "Preview Link Expiry Date will removed",
            showCancelButton: true,
            confirmButtonText: 'Remove',
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function (isConfirm) {
            if (isConfirm) {

                swal({
                    title: 'Removing..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })

                $.ajax({
                    url: '/ajax/remove_group_proposal_preview_expiry',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        'preview_ids': getSelectedPreviewIds(),
                        'proposal_id': proposal_id
                    },

                    success: function (data) {
                        swal('', 'Preview Expiry Removed');
                        ViewsDatatable.fnReloadAjax();
                        uncheckAllPreviewGroupCheckbox();
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        swal("Error", "An error occurred. Please try again");
                    }
                })
            } else {
                swal("Cancelled", "Your Preview Link was not changed :)", "error");
            }
        });

    });

    $("#groupdcDate").datepicker();

    $("#groupSetExpriry").click(function () {

        $("#group_expiry_proposal_id").val($(this).attr('data-proposal-id'));
        // $("#expiry_preview_id").val($(this).attr('data-preview-id'));
        $("#group-expiry-date-change-confirm").dialog('open');

    });


    $("#group-expiry-date-change-confirm").dialog({
        width: 500,
        modal: true,
        buttons: {
            OK: {
                'text': 'Continue',
                'class': 'btn ui-button update-button',
                click: function () {

                    var expiryDate = $("#groupdcDate").val();
                    var proposal_id = $("#group_expiry_proposal_id").val();
                    var expiry_preview_ids = getSelectedPreviewIds();

                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'preview_ids': expiry_preview_ids,
                            'expiryDate': expiryDate,
                            'proposal_id': proposal_id
                        },
                        url: "<?php echo site_url('ajax/set_group_proposal_preview_expiry') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"
                    })
                        .success(function (data) {

                            if (data.succes) {
                                swal('', 'Preview Expiry Set');
                                ViewsDatatable.fnReloadAjax();
                                uncheckAllPreviewGroupCheckbox();
                            } else {
                                swal('', 'An error occurred. Please try again');

                            }

                            $("#group-expiry-date-change-confirm").dialog('close');
                        });

                }
            },
            Cancel: function () {
                $(this).dialog('close');
            }
        },
        autoOpen: false
    });

    $(".groupPreviewEnableDisable").click(function () {

        var proposal_id = $(this).attr('data-proposal-id');
        var is_enable = $(this).attr('data-is-enable');
        var msg = 'Enable';
        if (is_enable == 0) {
            var msg = 'Disable';
        }
        swal({
            title: "Are you Sure?",
            text: "Preview Link will " + msg,
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function (isConfirm) {
            if (isConfirm) {

                swal({
                    title: 'Saving..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })

                $.ajax({
                    url: '/ajax/group_enable_disable_proposal_preview',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        'preview_ids': getSelectedPreviewIds(),
                        'proposal_id': proposal_id,
                        'is_enable': is_enable
                    },

                    success: function (data) {
                        swal('', 'Preview Link ' + msg + 'd');
                        ViewsDatatable.fnReloadAjax();
                        uncheckAllPreviewGroupCheckbox();
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        swal("Error", "An error occurred. Please try again");
                    }
                })
            } else {
                swal("Cancelled", "Your Preview Link was not changed :)", "error");
            }
        });

    });

        $(".groupSignatureEnableDisable").click(function () {

        var proposal_id = $(this).attr('data-proposal-id');
        var is_enable = $(this).attr('data-is-enable');
        var msg = 'Enable';
        if (is_enable == 0) {
            var msg = 'Disable';
        }
        swal({
            title: "Are you Sure?",
            text: "Preview Signature will " + msg,
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function (isConfirm) {
            if (isConfirm) {

                swal({
                    title: 'Saving..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })

                $.ajax({
                    url: '/ajax/group_enable_disable_proposal_signature',
                    type: "POST",
                    dataType: "JSON",
                    data: {
                        'preview_ids': getSelectedPreviewIds(),
                        'proposal_id': proposal_id,
                        'is_enable': is_enable
                    },

                    success: function (data) {
                        swal('', 'Preview Signature ' + msg + 'd');
                        ViewsDatatable.fnReloadAjax();
                        uncheckAllPreviewGroupCheckbox();
                    },
                    error: function (jqXhr, textStatus, errorThrown) {
                        swal("Error", "An error occurred. Please try again");
                    }
                })
            } else {
                swal("Cancelled", "Your Preview Signature was not changed :)", "error");
            }
        });

    });

    $(document).on("click", ".updateVideoTitle", function () {
        var id = $(this).data('video-id');
        var videoTitle = $('#videoTitle_' + id).val();
        var videoBigPreview = ($('#is_large_preview_' + id).is(":checked")) ? 1 : 0;
        var visible_work_order = ($('#visible_work_order_' + id).is(":checked")) ? 1 : 0;
        var visible_proposal = ($('#visible_proposal_' + id).is(":checked")) ? 1 : 0;
        var is_intro = ($('#is_intro_' + id).is(":checked")) ? 1 : 0;
        var player_icon_hide = ($('#player_icon_hide' + id).is(":checked")) ? 1 : 0;
        
        var player_icon_color = $('input[name="player_icon_color_' + id+'"]:checked').val();
        var postData = {
            videoId: id,
            videoTitle: videoTitle,
            videoBigPreview: videoBigPreview,
            visible_work_order: visible_work_order,
            visible_proposal: visible_proposal,
            is_intro:is_intro,
            player_icon_hide : player_icon_hide,
            player_icon_color:player_icon_color,
        };
        swal({
                    title: 'Updating..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })
        $.ajax({
            type: "POST",
            url: "<?php echo site_url('ajax/updateProposalVideoTitle') ?>",
            dataType: 'json',
            data: postData
        })
            .done(function (data) {

                if (data.error) {
                    swal(
                        'Error',
                        'There was an error saving the video'
                    );
                    return;
                }

                if (visible_work_order) {
                    $('#video_header_span_workorder_' + id).show();
                } else {
                    $('#video_header_span_workorder_' + id).hide();
                }

                if (visible_proposal) {
                    $('#video_header_span_proposal_' + id).show();
                } else {
                    $('#video_header_span_proposal_' + id).hide();
                }

                if (videoBigPreview) {
                    $('#video_header_span_large_player_' + id).show();
                } else {
                    $('#video_header_span_large_player_' + id).hide();
                }

                if (is_intro) {
                    
                    $("input[name='is_intro']:checkbox").prop('checked',false);
                    $("input[name='is_large_preview']:checkbox").prop('disabled',false);
                    $("input[name='is_large_preview']:checkbox").closest('div').removeClass('disabled');

                    $('#is_intro_' + id).prop('checked',true);
                    $("input[name='is_intro']:checkbox").uniform();
                    $('.intro_badge').hide();
                    $('#video_header_span_is_intro_' + id).show();

                    $('#is_large_preview_'+id).prop('disabled',true);
                    $('#uniform-is_large_preview_'+id).addClass('disabled');

                    $('#visible_proposal_'+id).prop('disabled',true);
                    $('#uniform-visible_proposal_'+id).addClass('disabled');

                } else {
                    $('#video_header_span_is_intro_' + id).hide();
                }

                swal(
                    'Success',
                    'Video Saved'
                );
                $('#title_' + id).html(videoTitle);

                videoSettingsChanged = false;
                
                console.log(videoSettingsChanged);
                // $("#accordion5").accordion('destroy').accordion({
                //     collapsible: true,
                //     active: false,
                //     autoHeight: false,
                //     navigation: true,
                //     header: "> div > h3"
                // });
            })
    })
    $(document).on('click', '.is_intro', function () {
        
        var video_id = $(this).attr('data-video-id');
        if($(this).is(":checked")){
            $('#is_large_preview_'+video_id).closest('span').addClass('checked');
            $('#is_large_preview_'+video_id).prop('checked',true);
            $('#is_large_preview_'+video_id).prop('disabled',true);
            $('#uniform-is_large_preview_'+video_id).addClass('disabled');

            $('#visible_proposal_'+video_id).closest('span').addClass('checked');
            $('#visible_proposal_'+video_id).prop('checked',true);
            $('#visible_proposal_'+video_id).prop('disabled',true);
            $('#uniform-visible_proposal_'+video_id).addClass('disabled');
            
        }else{
            $('#is_large_preview_'+video_id).prop('disabled',false);
            $('#uniform-is_large_preview_'+video_id).removeClass('disabled');

            $('#visible_proposal_'+video_id).prop('disabled',false);
            $('#uniform-visible_proposal_'+video_id).removeClass('disabled');
        }
       // $('#is_large_preview_'+video_id).uniform();
    });
    $(document).on('click', '.deleteVideoUrl', function () {
        var id = $(this).data('video-id');
        swal({
            title: "Are you sure?",
            text: "This will Delete the Video",
            showCancelButton: true,
            confirmButtonText: 'Delete',
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function (isConfirm) {
            if (isConfirm) {
                swal({
                    title: 'Deleting..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                        swal.showLoading();
                    }
                })
                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('ajax/deleteProposalVideo') ?>",
                    dataType: 'json',
                    data: {id: id},
                })
                    .done(function (data) {

                        if (data.error) {
                            swal(
                                'Error',
                                'There was an error Deleting the video'
                            );
                            return;
                        }

                        swal(
                            'Success',
                            'Video Deleted'
                        );
                        $('#video_' + id).remove();
                        videoCountCheck();
                    })
            } else {
                swal("Cancelled", "Your Thumb Image is safe :)", "error");
            }
        });
    });

    $(document).on('click', '.addVideoNotes', function () {
        var id = $(this).data('video-id');
        tinymce.remove('#notes_content');
        swal({
            title: "<i class='fa fw fa-save'></i> Save Notes",
            html: "<div id='notes_content'></div>",
            showCancelButton: true,
            width: '950px',
            confirmButtonText: '<i class="fa fw fa-save"></i> Save',
            cancelButtonText: "<i class='fa fw fa-times'></i> Cancel",
            dangerMode: false,
            showCloseButton: true,
            onOpen: function () {
                tinymce.init({
                    selector: "#notes_content",
                    menubar: false,
                    elementpath: false,
                    relative_urls: false,
                    remove_script_host: false,
                    convert_urls: true,
                    browser_spellcheck: true,
                    contextmenu: false,
                    paste_as_text: true,
                    height: '320',
                    plugins: "link image code lists paste preview ",
                    toolbar: tinyMceMenus.email,
                    forced_root_block_attrs: tinyMceMenus.root_attrs,
                    fontsize_formats: "8px 10px 12px 14px 16px 18px 20px 22px 24px 36px"
                });


                $.ajax({
                    type: "POST",
                    url: "<?php echo site_url('ajax/getProposalVideoNote') ?>",
                    dataType: 'json',
                    data: {id: id}
                })
                    .done(function (data) {
                        if (data.succes) {
                            console.log(data.video_note);
                            tinymce.get("notes_content").setContent(data.video_note);
                        } else if (data.error) {
                            swal(
                                'Error',
                                'There was an error saving the Note'
                            );
                            return;
                        }


                    })


            }
        }).then(function (result) {
            var noteContent = tinymce.get("notes_content").getContent()
            var postData = {content: noteContent, id: id};

            $.ajax({
                type: "POST",
                url: "<?php echo site_url('ajax/saveProposalVideoNote') ?>",
                dataType: 'json',
                data: postData
            })
                .done(function (data) {

                    if (data.error) {
                        swal(
                            'Error',
                            'There was an error saving the Note'
                        );
                        return;
                    }

                    swal(
                        'Success',
                        'Note Saved'
                    );
                })


        })
    });

    $(document).on("click", ".player_icon_hide", function () {

        var video_id = $(this).attr('data-video-id');

        if($(this).is(":checked")){
            $('#player_overlay'+video_id).hide();
        }else{
            $('#player_overlay'+video_id).show();
        }
    });

        $(document).on("click", ".playerIconColorDiv>label", function () {

        var video_id = $(this).closest('.playerIconColorDiv').attr('data-video-id');

        var color_id = $(this).attr('data-color');

        $('#player_overlay'+video_id).find('img').attr('src',site_url+'static/images/video-player-icon_'+color_id+'.png');

    });

    $('.select2_company_videos').on('select2:selecting', function (e) {

        if (e.params.args.data.id == -1) {
            e.preventDefault();
            saveVideoUrl();

        }
    });

    $('.select2_company_videos').on('select2:open', function (e) {
        $(".select2_company_videos option").prop("disabled", false);
        $('.image-area').each(function () {
            var video_id = $(this).attr('data-company-video-id');

            $(".select2_company_videos option[value=" + video_id + "]").attr("disabled", "disabled");
        })
    });


    function saveVideoUrl() {
        swal({
            title: 'Save Video Link',
            allowOutsideClick: false,
            showCancelButton: true,
            confirmButtonText: 'Save',
            cancelButtonText: "Cancel",
            dangerMode: false,
            reverseButtons: false,
            html:
                '<input id="swal-input1" class="swal2-input" value="" Placeholder="Enter Video Link"><br><span id="video_link_error_msg"></span>',

            preConfirm: function () {
                if ($('#swal-input1').val()) {

                    return new Promise(function (resolve) {
                        var videoUrl = $('#swal-input1').val();

                        if (videoUrl !== '') {
                            var pattern = /^(http|https)?:\/\/[a-zA-Z0-9-\.]+\.[a-z]{2,4}/;
                            if (!pattern.test(videoUrl)) {
                                $('#video_link_error_msg').text('Please Enter correct URL');
                                $('#video_link_error_msg').show();
                                $('#swal-input1').addClass("error");
                                return false;
                            } else {
                                resolve(
                                    $('#swal-input1').val()
                                )
                            }
                        } else {
                            $('#video_link_error_msg').text('Please Enter URL');
                            $('#video_link_error_msg').show();
                            $('#swal-input1').addClass("error");
                            return false;
                        }


                    })
                } else {
                    alert('Please Enter the filter Name');
                }
            },
            onOpen: function () {
                $('#swal-input1').focus();

            }
        }).then(function (result) {

            console.log(result);
            var video_url = result;

            swal({
                title: 'Saving..',
                allowEscapeKey: false,
                allowOutsideClick: false,
                timer: 10000,
                onOpen: () => {
                    swal.showLoading();
                }
            })

            console.log(video_url);
            $.ajax({
                type: "POST",
                url: "<?php echo site_url('ajax/saveProposalVideos') ?>",
                dataType: 'json',
                data: {
                    proposalId: <?= $proposal->getProposalId(); ?>,
                    videoUrl: video_url,
                }
            })
                .done(function (data) {

                    if (data.error) {
                        swal(
                            'Error',
                            'There was an error saving the video'
                        );
                        return;
                    }

                    swal(
                        'Success',
                        'Video Saved'
                    );


                    $("#videoURL").val('');

                    var newContent = '' +

                        '<div  data-video-id="' + data.id + '" id="video_' + data.id + '" class="video_div">' +
                        '<span class="group_checker"><input type="checkbox" id="checkbox_video_' + data.id + '"  name="videos" class="proposal_videos" value="' + data.id + '" style="float:left;"></span>' +
                        '<h3>' +
                        '<a href="#"><span id="title_' + data.id + '">' + data.title + '</span></a>' +
                        '<span title="Show In Work Order" class="superScript grey_b tiptip" id="video_header_span_workorder_' + data.id + '" style="right: 40px;position: absolute;top: 8px;display:block">WO</span>' +
                        '<span title="Show In Proposal" class="superScript grey_b tiptip" id="video_header_span_proposal_' + data.id + '" style="right: 80px;position: absolute;top: 8px;display:block">P</span>' +
                        '<span title="Large Player" class="superScript grey_b tiptip" id="video_header_span_large_player_' + data.id + '" style="right: 107px;position: absolute;top: 8px;display:none">Large Player</span>' +
                        '<span title="Intro Video" class="superScript grey_b tiptip intro_badge" id="video_header_span_is_intro_' + data.id + '" style="right: 190px;position: absolute;top: 8px;display:none">Intro</span>'+
                        '<a class="btn-delete close-accordion" href="#">&nbsp;</a>' +
                        '</h3>' +
                        '<div class="clearfix" style="margin-left: 25px;">' +
                        '<div class="video_left_section" style="width: 310px;margin-top: 15px;float:left;margin-bottom: 15px;">' +
                        '<div class="updateProposalVideoTitle" style="width: 310px;">' +
                        '<label for="updateProposalVideoTitle"><b>Video Title: </b></label>' +
                        '<input type="text" class="text" id="videoTitle_' + data.id + '" value="' + data.title + '" maxlength="50" name="videoTitle" >' +
                        '</div>'+
                        '<div style="width: 100%;position:relative;float:left;margin-top: 20px;display: grid;">' +
                        '<label for=""><b>Video Setting: </b></label>'+
                        '<p style="float: left;margin: 5px 0px 5px 13px;"><input type="checkbox" class="is_intro" data-video-id="' + data.id + '" name="is_intro" id="is_intro_' + data.id + '" ><span style="float: left;margin-top: 2px;width: 100px;">Intro Video</span><input type="checkbox" name="visible_proposal" id="visible_proposal_' + data.id + '" checked> <span style="float: left;margin-top: 2px;width: 100px;">Proposal</span></p>'+
                        '<p style="float: left;margin: 5px 0px 5px 13px;"><input type="checkbox" name="is_large_preview" id="is_large_preview_' + data.id + '"  ><span style="float: left;margin-top: 2px;width: 100px;">Large Player </span><input type="checkbox" name="visible_work_order" id="visible_work_order_' + data.id + '" checked><span style="float: left;margin-top: 2px;width: 100px;">Work Order</span></p>' +
                        '</div>';

                    if (data.buttonShow == 0) {
                        newContent += '<div class="is_video_added proposalVideoImageUploaderDiv" data-video-id="' + data.id + '" style="width: 120px;float:left;">' +
                            '<input accept="image/*" class="proposalVideoThumbImageUploader" type="file" name="files" data-video-id="' + data.id + '">' +
                            '</div>';
                    } else {
                        newContent += '<div style="height:35px;"></div>';
                    }
                    
                    newContent +=   '<div class="playerIconDiv" data-video-id="' + data.id + '" style="float:left;width: 100%;display:none;">'+
                                    '<p style="margin-top: 15px;margin-bottom: 7px;"><strong>Player Icon</strong></p>'+
                                    '<input type="checkbox" name="player_icon_hide" class="player_icon_hide" data-video-id="' + data.id + '" id="player_icon_hide' + data.id + '" >Hide'+
                                    '</div>'+
                                    '<div class="playerIconColorDiv" data-video-id="' + data.id + '" style="float:left;width: 100%;display:none;">'+
                                    '<p style="margin-top: 15px;margin-bottom: 7px;"><strong>Player Icon Color</strong></p>'+
                                    '<input type="radio" class="dont-uniform " name="player_icon_color_' + data.id + '" id="one_label_' + data.id + '" value="0" />'+
                                    '<label data-color="0" for="one_label_' + data.id + '"><span class="blue"></span></label>'+
                                    '<input type="radio" class="dont-uniform " name="player_icon_color_' + data.id + '" id="two_label_' + data.id + '" value="1" />'+
                                    '<label data-color="1" for="two_label_' + data.id + '"><span class="white"></span></label>'+
                                    '<input type="radio" class="dont-uniform " name="player_icon_color_' + data.id + '" id="three_label_' + data.id + '" value="2" />'+
                                    '<label data-color="2" for="three_label_' + data.id + '"><span class="black"></span></label>'+
                                    '<input type="radio" class="dont-uniform " name="player_icon_color_' + data.id + '" id="four_label_' + data.id + '" value="3" />'+
                                    '<label data-color="3" for="four_label_' + data.id + '"><span class="red"></span></label>'+
                                    '</div>';


                    newContent += '</div>' +
                        '<div class="video_right_section" style="width: 430px;float:left;margin-bottom: 15px;">' +
                        '<div id="thumb-image-preview" class="is_video_added" style="margin-left:5px;box-shadow: rgb(60 64 67 / 30%) 0px 1px 4px 0px;padding: 10px;float:left;width: 410px;margin-bottom: 45px;">' +
                        '<div id="image-area_' + data.id + '" class="image-area" data-final-url="' + data.videoUrl + '" data-video-id="' + data.id + '" data-image-url="" data-button-show="0" data-company-video-id="0">';


                    if (data.buttonShow == 1) {
                        newContent += '<a href="' + data.videoUrl + '" class="btn btn-primary" style="width:180px;margin-left: 90px;" target="_blank"><i class="fa fa-fw fa-play-circle-o"></i>Play Proposal Video</a>';
                    } else {
                        newContent += '<p style="margin-top: 100px;margin-bottom: 100px;margin-left: 100px;" class="iframeLoadingImage"><img src="../../static/blue-loader.svg" alt="Loading"></p><iframe id="video-uploaded-iframe" class="embed-responsive-item" src="' + data.videoUrl + '" style="display:none;" onload="removeLoadingImage(this)" allowfullscreen loading="lazy"></iframe>';
                    }

                    newContent += '</div>' +
                        '<a class="remove-image tiptip" title="Delete thumb image" onclick="remove_saved_thumb_image(' + data.id + ')" href="javascript:void(0)" >&#215;</a>' +
                        '<a class="back-to-image" onclick="show_saved_thumb_image(this)" href="javascript:void(0)"><i class="fa fa-arrow-left"></i></a>' +
                        '</div>' +
                        '<div style="margin-top: 15px;float: left;width: 430px;position: absolute;bottom: 20px;">' +
                        '<a href="javascript:void(0)" class="deleteVideoUrl tiptip btn" title="Delete Video" style="float: left;" data-video-id="' + data.id + '"><i class="fa fa-fw fa-trash"></i>Delete Video</a>' +
                        '<a href="javascript:void(0)" class="deleteThumbnail tiptip btn" title="Delete thumb image" style="margin-left: 29px;font-size: 13px;float: left;display:none" data-video-id="' + data.id + '" onclick="remove_saved_thumb_image(' + data.id + ')"><i class="fa fa-fw fa-trash"></i>Delete Thumbnail</a>' +
                        '<a class="btn blue-button updateVideoTitle" data-video-id="' + data.id + '" style="float: right;"><i class="fa fa-fw fa-save"></i> Update Video</a>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '</div>';

                    $("#accordion5").append(newContent);
                    $("#accordion5").sortable('refresh');
                    $("#accordion5").accordion('destroy').accordion({
                        collapsible: true,
                        active: false,
                        autoHeight: false,
                        navigation: true,
                        header: "> div > h3"
                    });

                    $('#accordion5').accordion('option', 'active', parseInt($('#accordion5 .video_div').length - 1))

                    initButtons();
                    initTiptip();
                    videoCountCheck();
                    resetAllVideoThumbUploader();
                    enable_fileupload_plugin();
                    $('#uniform-masterSelect').show();
                    $('#no_videos_section').hide();
                    $('#checkbox_video_' + data.id).uniform();
                    $('#is_large_preview_' + data.id).uniform();
                    $('#visible_proposal_' + data.id).uniform();
                    $('#visible_work_order_' + data.id).uniform();
                    $('#is_intro_' + data.id).uniform();
                    $('#player_icon_hide' + data.id).uniform();
                    setTimeout(function () {
                            removeLoadingImage();
                        }, 2000);
                })


        }).catch(swal.noop)
    }

    function videoCountCheck() {

        var numVideos = numUploadedVideos();

        $("#videoSettings").text(numVideos);
        // Update the badge on the tab
        if (numVideos < 1) {
            $("#videoSettings").removeClass('blue');
            $("#videoSettings").addClass('red');
            $('.individual_proposal_section_table').find('tr[data-section-code="video"]').hide();

        } else {

            $("#videoSettings").removeClass('red');
            $("#videoSettings").addClass('blue');
            $('.individual_proposal_section_table').find('tr[data-section-code="video"]').show();
        }

    }

    function numUploadedVideos() {
        return $("#accordion5 > div.video_div").length;
    }

    $(document).on("click",".copy_proposal_link",function(e) {

        $(this).html('<i class="fa fa-fw fa-copy"></i> Link Copied');
        $this =this;
        var temp = $("<input>");
        $("body").append(temp);
        temp.val($(this).attr('data-preview-link')).select();
        document.execCommand("copy");
        temp.remove();


        setTimeout(function(){
                $($this).html('<i class="fa fa-fw fa-copy"></i> Copy Link');// or fade, css display however you'd like.
        }, 3000);
        return false;
    });
    $(document).on("click",".work_order_recipients",function(e) {

        check_work_order_popup_validation();
    });
    $(document).on("keyup",".work_order_additional_emails",function(e) {
        if($(this).val()){
            $(this).removeClass('error');

        }else{
            $(this).addClass('error');

        }
        check_work_order_popup_validation()

    });
    function check_work_order_popup_validation(){


        if($("#send_proposal_popup .work_order_recipients:checkbox:checked").length < 1 && $('#send_proposal_popup .work_order_additional_emails').val() =='' ){

            $('.send_popup_validation_msg').show();
            $('#send_proposal_popup .swal2-confirm').attr('disabled', true);
        }else{

            $('.send_popup_validation_msg').hide();
            $('#send_proposal_popup .swal2-confirm').attr('disabled', false);
        }
    }
    $(document).on("click",".workorder_send_btn",function(e) {
          var project_id = $(this).attr('data-val');
        //  var client_id = $(this).attr('data-client-id');
        //  var project_name = $(this).attr('data-project-name');
        //  var project_contact_name = $(this).attr('data-project-contact');
         template = $("#send_work_order_template").html();
         template = template.toString()

         swal({
            title: "<i class='fa fw fa-envelope'></i> Send Work Order",
            html: template,

            showCancelButton: true,
            width: '950px',
            confirmButtonText: '<i class="fa fw fa-envelope"></i> Send',
            cancelButtonText: "<i class='fa fw fa-times'></i> Cancel",
            dangerMode: false,
            showCloseButton: true,
            onOpen:function() {

                $('.swal2-modal').attr('id','send_proposal_popup')
                check_work_order_popup_validation();
                //initUI();
                $('.work_order_recipients').uniform();
                $('#send_proposal_popup').find('.selector').hide();
                //$.uniform.update();
            }
            }).then(function(){

                var additional_emails = $('#send_proposal_popup').find('.work_order_additional_emails').val();
                console.log(additional_emails);
                   //return false;

                    var work_order_recipients = $('#send_proposal_popup').find('.work_order_recipients');
                    var recipients ={};
                    for($i=0;$i<work_order_recipients.length;$i++){
                        //console.log('fff')
                        if($(work_order_recipients[$i]).is(":checked")){
                            recipients[$(work_order_recipients[$i]).attr('data-val')]=$(work_order_recipients[$i]).val()
                        }
                    }

                    swal({
                        title: 'Sending..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 10000,
                        onOpen: () => {
                        swal.showLoading();
                        //$('.swal2-modal').attr('id','')
                        }
                    })
                    $.ajax({
                        type: "POST",
                        async: true,
                        cache: false,
                        data: {
                            'additional_emails':additional_emails,
                            'proposal_id':project_id,
                            'recipients':recipients
                        },
                        url: "<?php echo site_url('ajax/send_work_order_ajax') ?>?" + Math.floor((Math.random() * 100000) + 1),
                        dataType: "JSON"
                    }).success(function (data) {
                        console.log(data);
                        swal('','Work order email sent to all valid emails entered!');
                    });
            }).catch(swal.noop);

            
     });
     
    $("#workOrderDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 960,
            resizable: false,
            dragStart: function( event, ui ) {$(this).parent().css('transform', 'translateX(0%)');$(this).parent().css('left', '0%');},
            open: function(event, ui) {
                $(this).parent().css('position', 'fixed');
                $(this).parent().css('top', '30px');
                $(this).parent().css('left', '50%');
                $(this).parent().css('height', 'auto');
                $(this).parent().css('max-height', '95%');
                $(this).parent().css('transform', 'translateX(-50%)');
            }
        });

    $(document).on("click",".workorder_link_copy",function(e) {

            $('.workorder_link_copy span').html('<i class="fa fa-fw fa-copy"></i> Link Copied');
            const el = document.createElement('textarea');
            el.value = $('#work_order_url_link').val();
            document.body.appendChild(el);
            el.select();
            document.execCommand("copy");
            document.body.removeChild(el);
            //$('.flash_copy_msg').fadeIn()
            setTimeout(function(){
                $('.workorder_link_copy span').html('<i class="fa fa-fw fa-copy"></i> Copy Link');// or fade, css display however you'd like.
        }, 3000);
            return false;
    });
    $(document).on("click","#workorderpreview",function(e) {
        var temp_base_url ='<?php echo  site_url();?>';
        var access_key = $(this).attr('data-access-key');
        var project_name = $(this).attr('data-project-name');
        var proposal_id = $(this).attr('data-val');
        var send_url = temp_base_url+'proposals/edit/'+proposal_id+'/preview_workorder';
        var currSrc = temp_base_url+'work_order/'+access_key+'/noDownload';
        var downloadCurrSrc = temp_base_url+'proposals/live/view/work_order/'+access_key+'.pdf';

        $(".workorder_download_btn").attr('href',downloadCurrSrc);
        $(".workorder_download_btn").attr('download',project_name.replace(".", ""));
        $("#work_order_url_link").val(downloadCurrSrc);
        $(".workorder_send_btn").attr('data-val',proposal_id);
        $("#workOrderDialog").dialog('open');
        $("#workOrder-preview-iframe").hide();

        $("#workorderpreviewPDF").show();
        $("#workorderpreviewWEB").hide();
        
        $("#workorderpreviewPDF").attr('data-access-key',access_key);
        $("#workorderpreviewPDF").attr('data-val',proposal_id);
        $("#workorderpreviewWEB").attr('data-access-key',access_key);
        $("#workorderpreviewWEB").attr('data-val',proposal_id);
        // Show the loaderm
        $("#loadingFrame2").show();
        // Refresh the iframe - Load event will handle showing the frame and hiding the loader

        $("#workOrder-preview-iframe").attr("src", currSrc);
        return false;
    });

    $(document).on("click","#workorderpreviewPDF",function(e) {
        var temp_base_url ='<?php echo  site_url();?>';
        var access_key = $(this).attr('data-access-key');
        var proposal_id = $(this).attr('data-val');
        var send_url = temp_base_url+'proposals/edit/'+proposal_id+'/preview_workorder';
        var currSrc = temp_base_url+'work_order/'+access_key+'/noDownload';
        var downloadCurrSrc = temp_base_url+'proposals/live/view/work_order/'+access_key+'.pdf';

        $(".workorder_download_btn").attr('href',downloadCurrSrc);
        $("#work_order_url_link").val(downloadCurrSrc);
        $(".workorder_send_btn").attr('data-val',proposal_id);
        $("#workOrderDialog").dialog('open');
        $("#workOrder-preview-iframe").hide();

        $("#workorderpreviewPDF").hide();
        $("#workorderpreviewWEB").show();

        // Show the loaderm
        $("#loadingFrame2").show();
        // Refresh the iframe - Load event will handle showing the frame and hiding the loader

        $("#workOrder-preview-iframe").attr("src", downloadCurrSrc);
        return false;
    });

    $(document).on("click","#workorderpreviewWEB",function(e) {
        var temp_base_url ='<?php echo  site_url();?>';
        var access_key = $(this).attr('data-access-key');
        var proposal_id = $(this).attr('data-val');
        var send_url = temp_base_url+'proposals/edit/'+proposal_id+'/preview_workorder';
        var currSrc = temp_base_url+'work_order/'+access_key+'/noDownload';
        var downloadCurrSrc = temp_base_url+'proposals/live/view/work_order/'+access_key+'.pdf';

        $(".workorder_download_btn").attr('href',downloadCurrSrc);
        $("#work_order_url_link").val(downloadCurrSrc);
        $(".workorder_send_btn").attr('data-val',proposal_id);
        $("#workOrderDialog").dialog('open');
        $("#workOrder-preview-iframe").hide();

        $("#workorderpreviewPDF").show();
        $("#workorderpreviewWEB").hide();
        // Show the loaderm
        $("#loadingFrame2").show();
        // Refresh the iframe - Load event will handle showing the frame and hiding the loader

        $("#workOrder-preview-iframe").attr("src", currSrc);
        return false;
    });

    $(document).on('click', ".showProposalViews", function() {
            var entityType = $(this).attr('data-type');
        
       
            var entityId = $(this).attr('data-entity-id');
        
        
            var projectName = $(this).attr('data-project-name');

            loadProposalViewTable(projectName,entityType,entityId);
            
        });

    $(document).on('change', ".account_users", function () {

        $(this).closest('.nice-label').toggleClass('user_permission_checked',$(this).is(':checked'));

    });



        // Proposal User Permissions
        $(document).on('click', "#user_permission_save", function () {
            
                        swal({
                            title: 'Saving..',
                            allowEscapeKey: false,
                            allowOutsideClick: false,
                            timer: 2000,
                            onOpen: () => {
                            swal.showLoading();
                            }
                        })

                        var permission_users = $('#proposal-user-permission').find('.account_users');
                        var users =[];
                        for($i=0;$i<permission_users.length;$i++){
                            //console.log('fff')
                            if($(permission_users[$i]).is(":checked")){
                                users.push($(permission_users[$i]).val());
                            }
                        }

                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {proposal_id:'<?php echo $proposal->getProposalId(); ?>',permission_users: users},
                            url: "<?php echo site_url('ajax/saveProposalUserPermission') ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        }).success(function (data) {

                            //$("#change-proposal-business-type").dialog('close');
                            swal('','Proposal User Permissions Updated');
                            $("#proposal-user-permission").dialog('close');
                        });
                    
        });

     // Handle Permission User  search
    $('.permissionUsersfilterSearch').on('input', function () {

        var searchVal = $(this).val();
        var parentCol = $(this).parents('#proposal-user-permission');

        if (searchVal.length) {
            console.log(searchVal)
            $(parentCol).find('.nice-label').hide();
            $(parentCol).find(".nice-label:iContains('" + searchVal + "')").show();
            $(parentCol).find(".clearFilterSearch").show();
        } else {
            $(parentCol).find(".nice-label").show();
            $(parentCol).find(".clearFilterSearch").hide();
        }

    });

    $(".clearFilterSearch").click(function () {
        var searchInput = $(this).prev('.permissionUsersfilterSearch');
        $(searchInput).val('');
        $(searchInput).trigger('input');
    });

        // Sortable types
        $('.proposal-section-sortable').sortable({
            handle: '.handle',
            items: "tr:not(.unsortable)",
            stop: function () {
                //if($("#proposalLayout").val() == 'gradient'){
                    var type_id = $('.individual_proposal_section_table').find('tr[data-section-code="title-page"]').attr('id');
                    type_id = type_id.replace('type_', '')
                    var ordered_data = 'type[]='+type_id+'&';
                    ordered_data += $(this).sortable("serialize");
                // }else{
                //     var ordered_data = $(this).sortable("serialize");
                // }
                
                var proposal_id ='<?php echo $proposal->getProposalId(); ?>';
                ordered_data += '&proposal_id='+proposal_id;
                $.ajax({
                    url: '<?php echo site_url('ajax/order_individual_proposal_section') ?>',
                    type: "POST",
                    data: ordered_data,
                    dataType: "json",
                    success: function (data) {
                        console.log(data);

                        if (data.error) {
                            alert(data.error);
                        } else {
//                                document.location.reload();
                        }
                    },
                    error: function () {
                        alert('There was an error processing the request. Please try again later.');
                    }
                });
            }
        });

        $(document).on("click",".section_check",function(e) {
            var section_id = $(this).attr('data-section-id');
            var parent_section_id = $(this).attr('data-parent-section-id');
            var check_box = 0;
            var title = 'Hidden';
            var text = 'Hide';

            $this = $(this);
            if($(this).is(':checked')){
                check_box = 1;
                var title = 'Visible';
                var text = 'Show';
            }           
            swal({
                title: "Are you sure?",
                html:"This section will be "+title,
                showCancelButton: true,
                confirmButtonText: text,
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {

                    swal({
                        title: 'saving..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    })
                    
                    $.ajax({
                        url: '/ajax/hide_show_individual_proposal_section',
                        type: "POST",
                        dataType: "JSON",
                        data: {
                            action: check_box,
                            sectionId : section_id,
                            parentSectionId : parent_section_id,
                            proposal_id:'<?php echo $proposal->getProposalId(); ?>'
                        },

                        success: function( data){

                            swal('','Proposal Section Update');
                            
                            
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                            console.log( errorThrown );
                        }
                    })


                } else {
                    swal("Cancelled", "Your Proposal not hidden :)", "error");
                }
            }, function(dismiss){
                if($this.is(':checked')){
                    $this.prop( "checked", false );
                }else{
                    $this.prop( "checked", true );
                }
                $.uniform.update();
            }).catch(swal.noop);
        
    });

 

</script>


<div id="proposalViews" title="Proposal Views" style="display:none;">
    <h4><span class="proposal_view_project_name" style="color: #3f3f41;"></span>: Proposal Views</h4><a
            href="javascript:void(0)" class="reloadProposalViewTable blue-button btn"
            style="position: absolute;right: 13px;top: 10px;"><i class="fa fa-fw fa-refresh"></i> Reload Table</a>
    <hr/>

    <table id="showProposalViewsTable" class="boxed-table" style="width: 100%">
        <thead>
        <tr>

            <th>Viewer</th>
            <th>Last Viewed</th>
            <th>View Time</th>
            <!-- <th>Status</th> -->
            <th>Details</th>
        </tr>
        </thead>
        <tbody>
        </tbody>
    </table>
</div>

<div id="proposalPreviewDialog" title="Proposal Images">
    <div id="proposalPreviewImageContainer">
        <div id="proposalServicePreviewContent"></div>
    </div>
</div>