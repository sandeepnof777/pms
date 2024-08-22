<script type="application/javascript">
    var serviceTypeAssignments = '<?php echo json_encode($serviceTypeAssignments) ?>';
    serviceTypeAssignments = JSON.parse(serviceTypeAssignments);
    var serviceTemplateAssignments = '<?php echo json_encode($serviceTemplateAssignments) ?>';
    serviceTemplateAssignments = JSON.parse(serviceTemplateAssignments);
    var truckingItems = JSON.parse('<?php echo $truckingItems ?>');
    var sandSealerItems = JSON.parse('<?php echo $sandSealerItems ?>');
    var additiveSealerItems = JSON.parse('<?php echo $additiveSealerItems ?>');
    var equipments = <?php echo json_encode($equipments) ?>;
    var laborGroupItems = <?php echo json_encode($laborGroupItems) ?>;
    var mappedFields = [];
    var has_trucking_child = false;
    var oh_pm_type = <?php echo $oh_pm_type ?>;
    service_overhead_rate = '';
    service_profit_rate = '';
    var proposal_service_cost = 0;
    var public_phases = '';
    var head_type_id = '';
    var trucking_type_id = '20';
    var time_type_id = '6';
    var crack_sealer_service ='37';
    var sealcoating_service ='5';
    var striping_service ='2';
    var concrete_service ='49';
    var service_category_id ='5';
    var labor_category_id ='3';
    var equipment_category_id ='2';
    var asphalt_type_id ='1';
    var gravel_type_id ='5';
    var base_asphalt_type_id ='27';
    var excavation_type_id = '29';
    var milling_type_id = '45';
    var excavator_type_id = '6';
    var subcontractors_type_id = '30';
    var seal_sand_type_id = '12';
    var seal_additive_type_id = '11';
    var item_id='';
    var item_price='';
    var item_quantity = '';
    var item_base_price = '';
    var proposal_service_id = '';
    var edit_estimate_fields = false;
    var estimate_calculator_id = '';
    var calculator_form_id = '';
    var total_service = 0;
    var unsaved=false;
    var unsaved_row=false;
    var unsave_cal=false;
    var child_saved_cal=false;
    var temp_count =0;
    var temp_count2 =0;
    var global_type_id = '';
    var overheadRate = '';
    var profitRate ='';
    var overheadPrice = '';
    var profitPrice ='';
    var cal_trucking_oh = '';
    var cal_trucking_pm ='';
    var cal_trucking_oh_Price = '';
    var cal_trucking_pm_Price ='';
    var cal_trucking_total_Price ='';
    var overheadPrice = '';
    var profitPrice ='';
    var taxRate ='';
    var taxPrice = '';
    var calTotalPrice = '';
    var unit_name = '';
    var custom_item_line_id='';
    var unsave_trucking_cal = '';
    var child_lineItemId ='';
    var calculation_id ='';
    var phase_id ='';
    var sep_startLat,sep_startLng,sep_destLat,sep_destLng;
    var child_startLat,child_startLng,child_destLat,child_destLng;
    var est_item_id_for_notes;
    var ItemCategoryName;
    var request_inprogress=false;
    var child_save_done =false;
    var clicked_open_calulator =false;
    var savedData ='';
    var calculateData ='';
    var custom_tr_id ='';
    var custom_price_total =false;
    var saved_custom_price ='0';
    var saved_unit_price ='0';
    var custom_saved_line_id ='0';
    var has_child_items =false;
    var has_custom_total_price_update =false;
    var has_custom_parent_total_price_update =false;
    var has_custom_sep_total_price_update =false;
    var has_sub_sep_total_price_update =false;
    var has_custom_labor_total_price_update =false;
    var has_custom_equipement_total_price_update =false;
    var has_custom_trucking_total_price_update = false;
    var has_custom_custom_total_price_update =false;
    var has_custom_fees_total_price_update =false;
    var edited_base_price = '0';
    var edited_unit_price = '0';
    var edited_total_price = '0';

 $(document).ready(function() {
        // Service Fields Dialog
        $("#estimatingServiceFieldsDialog").dialog({
            modal: true,
            autoOpen: false,
            width: 800,
            buttons: {
                save: {
                    text: 'Save Fields',
                    class: 'blue-button',
                    click: function() {

                        // Serialize the data
                        var postData = $("#estimationFieldsForm").serializeArray();
                        if(hasDupes(postData)){
                            swal('','You Can`t assign multiple unit to same field');
                            return false;
                        }
                        unsave_cal =false;
                        $("#quantity_calculation").dialog('close');
                        // Send the data
                        $.ajax({
                            url: '/ajax/saveCompanyEstimatingServiceFieldsFromEstimate',
                            type: 'post',
                            data: postData,
                            success: function (response) {
                                data = JSON.parse(response);
                                swal(data.message);
                                //$(html).not(':last').remove();
                                $('.service_specifications').not(':last').remove();
                                
                                $('#service_'+proposal_service_id).find('.specification_sep').first().after(data.service_field);
                                if($('#service_'+proposal_service_id).find('.show_service_spec_check i').hasClass('fa-chevron-up')){
                                    $('#service_'+proposal_service_id).find('.show_service_spec_check').click()
                                }
                               
                                $(".open_calculator[data-item-id='" + item_id + "']").trigger('click'); 
                            }
                        });

                        $(this).dialog('close');
                    }
                },
                cancel: {
                    text: 'Cancel',
                    class: 'left',
                    click: function() {
                        $(this).dialog('close')
                    }
                }
            }
        });
        //$('body').attr('onclick',"test2(event)");
        //$.uniform.remove(".time_type_select");
        setInterval(function(){ check_logout_session(); }, 20000);
        $("#equipement_type").select2();
        $("#equipement_item").select2();
        $(".plantSelect").select2();
        $(".dumpSelect").select2();


        $(".selectTruckingStart,.selectTruckingEnd").select2({dropdownCssClass : 'bigdrop',templateResult: formatStartSelect});

        function formatStartSelect(repo){
            if(repo.children || repo.id==''){
            return repo.text;
            }
            var Taddresses;
            var PDName;
            var companyName;
            if($(repo.element).attr('data-job-site') == 1){
                Taddresses = $(repo.element).attr('data-address');
                var $container = $(
                    "<div class='select2-result-repository clearfix'>" +

                    "<div class='select2-result-repository__meta'>" +
                    "<table >"+
                    "<tr><th style='vertical-align: top;'>Job Site:</th><td class='select2-result-repository_jobsite'>"+Taddresses+"</td></tr>"+
                    "</div>" +
                    "</div>"
                );
            }
            else{
                Taddresses = $(repo.element).attr('data-address');
                companyName = $(repo.element).attr('data-company-name');
                PDName = $(repo.element).attr('data-option-name');
                
                var $container = $(
                "<div class='select2-result-repository clearfix'>" +

                "<div class='select2-result-repository__meta'>" +
                "<table >"+
                "<tr><th style='vertical-align: top;'>Company:</th><td class='select2-result-repository_account'>"+companyName+"</td></tr>"+
                "<tr><th style='vertical-align: top;'>Name:</th><td class='select2-result-repository_account'>"+PDName+"</td></tr>"+
                "<tr><th style='vertical-align: top;'>Address:</th><td class='select2-result-repository_address'>"+Taddresses+"</td></tr>"+
                "</div>" +
                "</div>"
            );
            }
            return $container;
        }
        
        main_service=0;
        proposal_service_id =0;
        $('#proposal_services .service').each(function (index, value) {
            total_service = total_service+1;;
            var temp_proposal_service_id = $(value).attr('id');
            temp_proposal_service_id =temp_proposal_service_id.replace(new RegExp("^" + 'service_'), '');

            $.ajax({
                url: '/ajax/getEstimateDetails/'+temp_proposal_service_id,
                type: 'get',

                success: function( data){
                    data = JSON.parse(data);
                   
                    $('.service_total_'+temp_proposal_service_id).val(data.line_item_total?data.line_item_total:0);
                    $('.adjusted_total_'+temp_proposal_service_id).val(data.service_price);
                    if(data.completed==0){
                        $('#service_'+temp_proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                        temp_count = temp_count+1;

                        if(total_service == temp_count){
                            $('.show_pending_est_msg').hide();
                            $('.welcome_msg').show();
                            $('.show_complete_est_msg').hide();
                        }else{
                            var pending =total_service - temp_count;
                            $('.show_pending_est_msg').text('You have '+temp_count+' additional services that you need to Estimate');
                            $('.show_pending_est_msg').show();
                            $('.welcome_msg').hide();
                            $('.show_complete_est_msg').hide();
                        }

                    }else{
                        $('.item_summary_btn').show();
                        $('#service_'+temp_proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                        temp_count2 = temp_count2+1;
                        if(total_service == temp_count2){
                            $('.show_pending_est_msg').hide();
                            $('.welcome_msg').hide();
                            $('.show_complete_est_msg').show();
                        }
                    }
                    if(data.custom_price==1){
                        $('#adjusted_total_'+temp_proposal_service_id).show();
                        $('#adjusted_total_'+temp_proposal_service_id).attr('data-adjusted-price','1');
                        $('.adjusted_total_'+temp_proposal_service_id).val(number_test(data.service_price));
                        $('.span_adjusted_total_'+temp_proposal_service_id).text('$'+addCommas(number_test(data.service_price)));
                        $('.adjusted_total_'+temp_proposal_service_id).hide();
                        $('.span_adjusted_total_'+temp_proposal_service_id).show();
                        $('.remove_adjusted_price_btn_'+temp_proposal_service_id).show();
                    }else{
                        $('.adjusted_total_'+temp_proposal_service_id).val('');
                        $('.span_adjusted_total_'+temp_proposal_service_id).text('$0');
                        $('#adjusted_total_'+temp_proposal_service_id).attr('data-adjusted-price','0');
                        $('.remove_adjusted_price_btn_'+temp_proposal_service_id).hide();

                    }
                    if(data.child_has_updated_flag>0){
                        $('.service_child_has_updated_flag_'+temp_proposal_service_id).show();
                        $('#service_'+temp_proposal_service_id+' .toggle').css('background-color','#ff8b28');

                    }else{
                        $('.service_child_has_updated_flag_'+temp_proposal_service_id).hide();
                        $('#service_'+temp_proposal_service_id+' .toggle').css('background-color','#aeaeae');
                    }
                    
                    //est_checked
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
            });
        });

        
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(get_piechart_data);

        

    });

    $(document).ready(function() {

        //var openTab = localStorage.getItem('selectedTabId');
        var openTab ='';
        var openAccordion = localStorage.getItem('selectedAccordionId');
        get_proposal_breakdown();
        // Set the form
        setDropdowns();

        $("#categoryTabs").tabs({
            active: 0,
            // Activate: This is what happens when the tab is shown
            activate : function(event, ui) {
                // We save the ID into local storage to keep open later
                //var selectedTabId = ui.newPanel.selector
                //localStorage.setItem('selectedTabId', selectedTabId);
            },
            // Before activate: This happens when the tab is clicked but before anything changes
            beforeActivate: function(event, ui) {
                if(unsaved_row){
                    event.preventDefault();
                    // Chrome requires returnValue to be set
                    event.returnValue = '';
                    swal(
                        'You have an unsaved item',
                        'Please save or clear item to continue'
                    );
                }
                // If we're clicking the preview tab, we need to reload the iframe
                if (ui.newPanel.selector == '#previewTab') {

                    // Hide the frame
                    $("#estimate-preview-iframe").hide();
                    // Show the loader
                    $("#loadingFrame").show();
                    // Refresh the iframe - Load event will handle showing the frame and hiding the loader
                    var currSrc = '<?php echo $proposal->getProposalViewUrl(); ?>';
                    $("#estimate-preview-iframe").attr("src", currSrc);
                }

                // If we're clicking the preview tab, we need to reload the iframe
                if (ui.newPanel.selector == '#estimateTab') {


                    // Instantiate datatable if it's not set
                    if (!iTable) {
                        initTable();
                    } else {
                        // Otherwise reload it
                        iTable.ajax.reload();
                    }
                }

                // Summary Tab
                if (ui.newPanel.selector == '#summaryTab') {
                    if(phase_id){
                        $.ajax({
                            type:"POST",
                            url:"<?php echo site_url('ajax/phaseEstimateItems') ?>/"+proposal_service_id+'/'+phase_id,
                            data:[],
                            async:false
                        }).success(function(data) {
                            if($(data).find('table').length >0){
                                $("#serviceItemsSummaryContent").html(data);
                            }else{
                                $("#serviceItemsSummaryContent").html('<p class="adminInfoMessage templateInfoMsg" style="display: block;"><i class="fa fa-fw fa-info-circle"></i> No items added to estimate for this phase.</p>');
                            }
                        });
                    }

                }
                 if (ui.newPanel.selector == '#categoryTab6') {

                    get_custom_items();

                    }

            }
        });

        // Open the last one
        // if (openTab) {
        //     $('#categoryTabs').tabs("select", openTab);

        //     setTimeout(function() {
        //         if (openAccordion) {
        //             $("#" + openAccordion).trigger('click');
        //         }
        //     }, 100);
        // }

        // Accordions
        $(".accordionContainer").accordion({
            collapsible: true,
            active: false,
            autoHeight: false,
            navigation: true,
            header: "h3",
            activate : function (event, ui) {
                if (ui.newHeader[0]) {
                    var selectedAccordionId = ui.newHeader[0].id;
                    if(hasLocalStorage){
                        localStorage.setItem('selectedAccordionId', selectedAccordionId);
                    }
                } else {
                    localStorage.removeItem('selectedAccordionId');
                }
                if(!ui.newPanel.length){
                    $('.item_delete_checkbox').attr('checked',false);
                    $('.item_delete_checkbox').trigger('change'); 
                    $.uniform.update();
                }
                

            },

            beforeActivate: function( event, ui ) {
               
                if(unsaved_row){

                    event.preventDefault();

                    event.returnValue = '';
                    swal(
                        'You have an unsaved item',
                        'Please save or clear item to continue'
                    );
                }
            }
        });

        $( ".accordionContainer2" ).accordion({
            collapsible: true,
            active: false,
            autoHeight: false,
            navigation: true,
            header: "h3",});

        // Sortable tables
        $("table.estimatingItemsTable tbody").sortable({
            helper: fixHelper,
            handle:".handle",
            stop:function () {
                var postData = $(this).sortable("serialize");
                $.ajax({
                    type:"POST",
                    url:"<?php echo site_url('admin/updateEstimationItemsDefaultOrder') ?>",
                    data:postData,
                    async:false
                });
            }
        });


        // Changing category
        $('#categoryId').change(function() {
            // Grab the value
            var categoryId = $(this).val();

            // If there's a value, show/hide the options
            if (categoryId) {
                $("#typeId").prop('disabled', '');

                $("#typeId option").hide();
                $('#typeId option[data-category="' + categoryId + '"]').show();
            }

            // Update the dropdowns
            setDropdowns();
        });

        // Changing Type
        $('#typeId').change(function() {
            // Update the dropdowns
            setDropdowns();
        });

        // Number format on unit price
        $("#unitPrice").keyup(function() {
            $(this).formatCurrency({
                colorize: true,
                negativeFormat: '-%s%n',
                roundToDecimalPlace: -1,
                eventOnDecimalsEntered: true,
                symbol: '$'
            });
        });

        // Number format on tax rate
        $("#tax_rate").keyup(function() {
            $(this).formatCurrency({
                colorize: true,
                negativeFormat: '-%s%n',
                roundToDecimalPlace: -1,
                eventOnDecimalsEntered: true,
                symbol: ''
            });
        });

        // Toggle Taxable checkbox
        $("#taxable").change(function() {
            var isChecked = $(this).is(':checked');

            $("#taxRateRow").toggle(isChecked);
        });

        // Form modal
        $("#estimatingItemModal").dialog({
            modal: true,
            autoOpen: false,
            width: 500,
            draggable: false
        });

        // Open the form
        $(".openForm").click(function() {
            $("#estimatingItemModal").dialog('open');
            return false;
        });

        // Edit item click
        $(".editItem").click(function() {
            var categoryId = $(this).data('category-id');
            var typeId = $(this).data('type-id');
            var unitId = $(this).data('unit-id');
            var itemId = $(this).data('item-id');
            var itemName = $(this).data('item-name');
            var taxable = $(this).data('item-taxable');
            var taxRate = $(this).data('item-tax-rate');
            var unitPrice = $(this).data('item-unit-price');

            // Set the values
            $("#itemId").val(itemId);
            $("#itemName").val(itemName);
            $("#categoryId").val(categoryId);
            $("#typeId").val(typeId);
            $("#unitId").val(unitId);
            $('#taxable').prop('checked', taxable);
            $('#tax_rate').val(taxRate);
            $('#unitPrice').val('$' + unitPrice);

            // Toggle the tax checkbox
            if (taxable) {
                $("#taxRateRow").show();
            } else {
                $("#taxRateRow").hide();
            }

            setDropdowns();
            $.uniform.update();

            $("#estimatingItemModal").dialog('open');
            return false;
        });

        // New Type Form
        $(".addTypeItem").click(function() {
            var categoryId = $(this).data('category-id');
            var typeId = $(this).data('type-id');

            // Reset the ID and name
            $("#itemId").val('');
            $("#itemName").val('');
            // Set the dropdowns
            $("#categoryId").val(categoryId);
            $("#typeId").val(typeId);

            // Open the modal
            $("#estimatingItemModal").dialog('open');
            $.uniform.update();
            setDropdowns();
            return false;
        });

        // Iframe load check
        $('#estimate-preview-iframe').on('load', function(){
            $("#loadingFrame").hide();
            $("#estimate-preview-iframe").show();
        });

        // End Document Ready

        // Datatable
        if ( ! $.fn.DataTable.isDataTable( '#estimateLineItemTable' ) ) {

            $("#estimateLineItemTable").DataTable({
                "order": [[0, "desc"]],
                "bProcessing": true,
                "serverSide": true,
                "scrollCollapse": true,
                "ajax" : {
                    "url": "<?php echo site_url('ajax/proposalEstimateItems'); ?>/" + proposalId,
                    "type": "GET"
                },
                "aoColumns": [
                    {'bVisible': true},
                    {'bSearchable': true},
                    {'bSearchable': true},
                    {'bSearchable': true},
                    {'bSearchable': true},
                    {'bSearchable': true},
                    {'bSearchable': true},
                ],
                "bJQueryUI": true,
                "bAutoWidth": true,
                "sPaginationType": "full_numbers",
                "sDom": 'HtiprF',
            });
        }

    });


    $('.toggle').click(function(e) {
        
        e.preventDefault();
        
        if(!unsaved_row){
            var $this = $(this);
          
            if ($this.next().hasClass('show')) {
                if(!request_inprogress){
                    $(this).closest('li').find('.add_phase_li').hide();
                    get_proposal_breakdown();
                    $this.next().removeClass('show');
                    $this.closest('a').removeClass('text-active-color');
                    $this.closest('a').removeClass('text-active-color2');
                    $this.next().slideUp(350);
                    main_service =0;
                    proposal_service_id =0;
                    $('#categoryTabs').hide();
                    $('#page_load_message').show();
                    $('#addCustomService').show();
                   // $('.service').show();
                    $('.heading_proposal_phase').text('');
                    $('.item_search_btn').hide();
                    $('.switch_check,.if_items_hide').hide();
                    $("#proposal_services .service").sort(function(a, b) {
                        return $(a).data("no") - $(b).data("no");
                    }).appendTo("#proposal_services");
                    $('.toggle').removeClass('reduce_opacity');
                }
               
            } else {
                request_inprogress=true;
                calculate_unit_price();
                $('.set_loader_phase').show();
                $('#page_loading').show();
                $('#page_load_message').hide();
                $('#addCustomService').hide();
                $('#categoryTabs').hide(); 
                $(this).closest('li').prependTo($(this).closest('li').parent());
                //$('.heading_proposal_total').hide();
                //$('.heading_proposal_phase').show();
                $this.parent().parent().find('li .inner').removeClass('show');
                $this.parent().parent().find('a').removeClass('text-active-color');
                $this.parent().parent().find('a').removeClass('text-active-color2');
                $this.parent().parent().find('li .inner').slideUp(350);
                //$('.service').hide();
                $this.parent().show();
                $this.next().toggleClass('show');
                if($($this).find(".service_child_flag").is(":visible")){
                    $this.closest('a').toggleClass('text-active-color2');
                }else{
                    $this.closest('a').toggleClass('text-active-color');
                }
                $('.toggle').addClass('reduce_opacity');
                $this.next().slideToggle(350);

                //$("#proposal_services li:eq(0)").before($this.parent());

                main_service =$this.closest('li').data('val');
                proposal_service_id =$this.closest('li').attr('id');
                edit_estimate_fields = ($this.closest('li').attr('data-edit-fields')==0)? true : false;
                $('.reset_overhead_profit_rate').hide();
                $('.save_adjust_profit_overhead_btn').hide();
                proposal_service_id =proposal_service_id.replace(new RegExp("^" + 'service_'), '');
                var show_service_array = serviceTypeAssignments[main_service];
                var show_template_array = serviceTemplateAssignments[main_service];
                $('.accordionContainer h3').each(function (index, value) {
                    var type_id = $(this).data('type-id');
                    if (jQuery.inArray(type_id, show_service_array)!='-1') {
                        $(this).show();
                        
                    } else {
                        $(this).hide();
                        $(this).next(".ui-accordion-content").hide();
                    }

                });
                
                    $('.accordionContainer2 h3').each(function (index, value) {
                        var template_id = $(this).data('template-id');
                        
                        if (jQuery.inArray(template_id, show_template_array)!='-1') {
                            $(this).show();
                            
                        } else {
                            $(this).hide();
                            $(this).next(".ui-accordion-content").hide();
                        }


                    });
                if(show_template_array.length>0){

                    $('.no_template_msg').hide();
                }else{
                    $('.no_template_msg').show();
                }
                $('#typeHeading0').show();
                
                $.ajax({		
                    url: '/ajax/getProposalServiceLineItems/',		
                    type: 'post',		
                    // data: {		
                    //     'proposalServiceId':proposal_service_id,		
                    // },		
                    data: {		
                        'proposalServiceId':proposal_service_id,		
                    },		
                    success: function( data){		
                        data = JSON.parse(data);
                        
                        //console.log(data.estimate.service_price);
                    $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                    $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                    $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                    if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }  
                        data2 = data.phases;
                        proposal_service_cost = data.totalCost;
                        if(data.settings.profit_rate>0){
                            $('#service_'+proposal_service_id).find('.proposal_service_profit').val(data.settings.profit_rate);
                            service_profit_rate = data.settings.profit_rate;
                            
                        }else{
                            $('#service_'+proposal_service_id).find('.proposal_service_profit').val('<?=$settings->getDefaultProfit();?>');
                            service_profit_rate = '<?=$settings->getDefaultProfit();?>';
                            
                        }
                        
                        if(data.settings.overhead_rate>0){
                            $('#service_'+proposal_service_id).find('.proposal_service_overhead').val(data.settings.overhead_rate);
                            service_overhead_rate = data.settings.overhead_rate;
                            
                        }else{
                            $('#service_'+proposal_service_id).find('.proposal_service_overhead').val('<?=$settings->getDefaultOverhead();?>');
                            service_overhead_rate = '<?=$settings->getDefaultOverhead();?>';
                            
                        }

                        calculate_unit_price();
                        
                        //data = data.lineItems;		
                        var estimate_final_total = 0;		
                        var category_total =[];
                        
                        $('.added_phase_list').remove();
                        $n=0;
                        for($i=0;$i<data2.length;$i++){
                            if(data2[$i].complete==0){
                                var phase_check_hide = 'phase_checked_hide';
                            }else{
                                var phase_check_hide = '';
                            }
                            if(data2[$i].child_updated_count>0){
                                var child_updated_style = "block";
                            }else{
                                var child_updated_style = "none";
                            }
                            $n = $i+1;
                            var temp_item_name =data2[$i].name;
                            var temp_item_name = temp_item_name.replace(/"/g, "&quot;");
                            if($i==0){
                                phase_id =data2[$i].id;
                                get_service_item_list_by_phase_id();
                                get_proposal_breakdown()
                                get_summary_data_by_phase_id();
                                get_sub_contractors_items();
                                check_all_default_saved_template_items();
                                var services_title = $('#service_'+proposal_service_id+' .service_title_name').text();
                                $('.heading_proposal_phase').text(services_title+' | '+data2[$i].name);
                                if(<?php echo $proposal_status_id;?> == '5'){
                                    $('.sortable-phase').append('<li id="ids_'+data2[$i].id+'" class="added_phase_list selected_phase" style="display:block;" ><span class="show_phase_name dbl_click_edit_phase" ><span class="sorting_number" style="margin-left:10px;">'+$n+'. </span>&nbsp;<span class="phase_name phase_name_'+data2[$i].id+' " data-phase-id="'+data2[$i].id+'" style="cursor:pointer">'+data2[$i].name+'</span><i class="fa fa-exclamation-triangle phase_child_flag phase_child_has_updated_flag_'+data2[$i].id+' tiptip" style="margin-right: 2px; display:'+child_updated_style+';" title="This phase has items that need to be checked"></i><span class="phase_checked '+phase_check_hide+'"><i class="fa fa-fw fa-2x fa-check-circle-o small" style="position: relative;top: 3px;padding-right: 2px;"></i></span><span class="phase_edit_option_icon "><i class="fa fa-fw fa-2x fa-cog small tiptipleft" title="Click for Options" style="position: relative;cursor:pointer;top: 3px;padding-right: 2px;"></i></span></span><span class="edit_phase_inputs" style="display:none;width:100%;margin-top:4px;margin-left:4px;vertical-align: middle;"><input type="text" style="float:left;text-align:left;" value="'+temp_item_name+'"  class="text input140 edit_phase_input_field_'+data2[$i].id+'" id="" ><br/><a href="JavaScript:void(0);" style="float: left;margin-left: 2px;" class="delete_phase btn tiptip " title="Delete" data-phase-id="'+data2[$i].id+'" ><i class="fa fa-fw fa-trash"></i></a><a href="javascript:void(0);" style="float: left;margin-left: 2px;" class="btn  tiptip delete_phase_all_items" data-phase-id="'+data2[$i].id+'"  title="Delete all phase items"  ><i class="fa fa-fw fa-1x fa-undo " ></i></a><a href="javascript:void(0);" style="  float: right;margin-right: 8px;margin-left: 2px;"  data-phase-id="'+data2[$i].id+'" class="btn mb-5px  update_phase_btn blue-button" >Save</a><a href="javascript:void(0);" style="float:right;margin-left: 2px;" class="btn  tiptip cancel_edit_phase" data-phase-id="'+data2[$i].id+'"  title="Cancel"  ><i class="fa fa-fw fa-1x fa-close " ></i></a></span></li>');
                                }else{
                                    $('.sortable-phase').append('<li id="ids_'+data2[$i].id+'" class="added_phase_list selected_phase" style="display:block;" ><span class="show_phase_name dbl_click_edit_phase" ><a class="handle"><i class="fa fa-sort"></i></a><span class="sorting_number">'+$n+'. </span>&nbsp;<span class="phase_name phase_name_'+data2[$i].id+' " data-phase-id="'+data2[$i].id+'" style="cursor:pointer">'+data2[$i].name+'</span><i class="fa fa-exclamation-triangle phase_child_flag phase_child_has_updated_flag_'+data2[$i].id+' tiptip" style="margin-right: 2px; display:'+child_updated_style+';" title="This phase has items that need to be checked"></i><span class="phase_checked '+phase_check_hide+'"><i class="fa fa-fw fa-2x fa-check-circle-o small" style="position: relative;top: 3px;padding-right: 2px;"></i></span><span class="phase_edit_option_icon "><i class="fa fa-fw fa-2x fa-cog small tiptipleft" title="Click for Options" style="position: relative;cursor:pointer;top: 3px;padding-right: 2px;"></i></span></span><span class="edit_phase_inputs" style="display:none;width:100%;margin-top:4px;margin-left:4px;vertical-align: middle;"><input type="text" style="float:left;text-align:left;" value="'+temp_item_name+'"  class="text input140 edit_phase_input_field_'+data2[$i].id+'" id="" ><br/><a href="JavaScript:void(0);" style="float: left;margin-left: 2px;" class="delete_phase btn tiptip " title="Delete" data-phase-id="'+data2[$i].id+'" ><i class="fa fa-fw fa-trash"></i></a><a href="javascript:void(0);" style="float: left;margin-left: 2px;" class="btn  tiptip delete_phase_all_items" data-phase-id="'+data2[$i].id+'"  title="Delete all phase items"  ><i class="fa fa-fw fa-1x fa-undo " ></i></a><a href="javascript:void(0);" style=" float: right;margin-right: 8px;margin-left: 2px;" data-phase-id="'+data2[$i].id+'" class="btn mb-5px  update_phase_btn blue-button" >Save</a><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn  tiptip cancel_edit_phase" data-phase-id="'+data2[$i].id+'"  title="Cancel"  ><i class="fa fa-fw fa-1x fa-close " ></i></a></span></li>');
                                }
                            }else{
                                if(<?php echo $proposal_status_id;?> == '5'){
                                    $('.sortable-phase').append('<li id="ids_'+data2[$i].id+'" class="added_phase_list" style="display:block;" ><span class="show_phase_name dbl_click_edit_phase" ><span class="sorting_number" style="margin-left:10px;">'+$n+'. </span>&nbsp;<span class="phase_name phase_name_'+data2[$i].id+' " data-phase-id="'+data2[$i].id+'" style="cursor:pointer">'+data2[$i].name+'</span><i class="fa fa-exclamation-triangle phase_child_flag phase_child_has_updated_flag_'+data2[$i].id+' tiptip" style="margin-right: 2px; display:'+child_updated_style+';" title="This phase has items that need to be checked"></i><span class="phase_checked '+phase_check_hide+'" ><i class="fa fa-fw fa-2x fa-check-circle-o small" style="position: relative;top: 3px;padding-right: 2px;"></i></span><span class="phase_edit_option_icon "><i class="fa fa-fw fa-2x fa-cog small tiptipleft" title="Click for Options" style="position: relative;cursor:pointer;top: 3px;padding-right: 2px;"></i></span></span><span class="edit_phase_inputs" style="display:none;width:100%;margin-top:4px;margin-left:4px;vertical-align: middle;"><input type="text" style="float:left;text-align:left;" value="'+temp_item_name+'"  class="text input140 edit_phase_input_field_'+data2[$i].id+'" id="" ><br/><a href="JavaScript:void(0);" style="float: left;margin-left: 2px;" class="delete_phase btn tiptip " title="Delete" data-phase-id="'+data2[$i].id+'" ><i class="fa fa-fw fa-trash"></i></a><a href="javascript:void(0);" style="float: left;margin-left: 2px;" class="btn  tiptip delete_phase_all_items" data-phase-id="'+data2[$i].id+'"  title="Delete all phase items"  ><i class="fa fa-fw fa-1x fa-undo " ></i></a><a href="javascript:void(0);" style=" float: right;margin-right: 8px;margin-left: 2px;"  data-phase-id="'+data2[$i].id+'" class="btn mb-5px  update_phase_btn blue-button" >Save</a><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn  tiptip cancel_edit_phase" data-phase-id="'+data2[$i].id+'"  title="Cancel"  ><i class="fa fa-fw fa-1x fa-close " ></i></a></span></li>');
                                }else{
                                    $('.sortable-phase').append('<li id="ids_'+data2[$i].id+'" class="added_phase_list" style="display:block;" ><span class="show_phase_name dbl_click_edit_phase" ><a class="handle"><i class="fa fa-sort"></i></a><span class="sorting_number">'+$n+'. </span>&nbsp;<span class="phase_name phase_name_'+data2[$i].id+' " data-phase-id="'+data2[$i].id+'" style="cursor:pointer">'+data2[$i].name+'</span><i class="fa fa-exclamation-triangle phase_child_flag phase_child_has_updated_flag_'+data2[$i].id+' tiptip" style="margin-right: 2px; display:'+child_updated_style+';" title="This phase has items that need to be checked"></i><span class="phase_checked '+phase_check_hide+'"><i class="fa fa-fw fa-2x fa-check-circle-o small" style="position: relative;top: 3px;padding-right: 2px;"></i></span><span class="phase_edit_option_icon "><i class="fa fa-fw fa-2x fa-cog small tiptipleft" title="Click for Options" style="position: relative;cursor:pointer;top: 3px;padding-right: 2px;"></i></span></span><span class="edit_phase_inputs" style="display:none;width:100%;margin-top:4px;margin-left:4px;vertical-align: middle;"><input type="text" style="float:left;text-align:left;" value="'+temp_item_name+'"  class="text input140 edit_phase_input_field_'+data2[$i].id+'" id="" ><br/><a href="JavaScript:void(0);" style="float: left;margin-left: 2px;" class="delete_phase btn tiptip " title="Delete" data-phase-id="'+data2[$i].id+'" ><i class="fa fa-fw fa-trash"></i></a><a href="javascript:void(0);" style="float: left;margin-left: 2px;" class="btn  tiptip delete_phase_all_items" data-phase-id="'+data2[$i].id+'"  title="Delete all phase items"  ><i class="fa fa-fw fa-1x fa-undo " ></i></a><a href="javascript:void(0);" style="  float: right;margin-right: 8px;margin-left: 2px;"  data-phase-id="'+data2[$i].id+'" class="btn mb-5px  update_phase_btn blue-button" >Save</a><a href="javascript:void(0);" style="float:right;margin-left: 2px;" class="btn  tiptip cancel_edit_phase" data-phase-id="'+data2[$i].id+'"  title="Cancel"  ><i class="fa fa-fw fa-1x fa-close " ></i></a></span></li>');
                                    
                                }
                            }
                        
                        }
                        $('.set_loader_phase').hide();
                        initButtons();
                        initTipTip();
                        $('#service_'+proposal_service_id).find('.add_phase_li').css('display','inline-block');
                        
                       
                        
                        // $('.service_total_'+proposal_service_id).val(number_test(estimate_final_total));
                        check_tr_has_class();
                        check_template_tr_has_class();
                    },		                    
                    error: function( jqXhr, textStatus, errorThrown ){		
                        console.log( errorThrown );		
                    }		
                })
                    
            }
        }else{
            swal(
                'You have an unsaved price adjustment!',
                
            );
        }
    });

    $(document).on("keyup",".unit-price",function() {

        var quantity = $(this).closest('tr').find('.quantity').text();
        if(quantity && number_test(quantity)>0)
        {
            var unit_price = $(this).val();
            unit_price = unit_price.replace('$', '');
            unit_price = unit_price.replace(/,/g, '');
            quantity = quantity.replace(/,/g, '');
            item_price =unit_price;

            if(parseInt(unit_price) == unit_price || parseFloat(unit_price) == unit_price){
                var total_price = unit_price * quantity;
                $(this).closest('tr').find(".total-price").text(addCommas(number_test(total_price)));
            }
        }
    });
    $(document).on("focus",".total-price",function(e) {
        var temp_item_line_id = $(this).closest('tr').prop('id')
        if(unsaved_row && temp_item_line_id != item_line_id){
            e.preventDefault();
            $('#'+item_line_id+' .total-price').focus();
            swal(
                'You have an unsaved item',
                'Please save or clear item to continue'
            );


        }
    });
    $(document).on("keyup",".total-price",function(e) {
        var temp_item_line_id = $(this).closest('tr').prop('id')
        if(unsaved_row && temp_item_line_id != item_line_id){
            e.preventDefault();
            swal(
                'You have an unsaved item',
                'Please save or clear item to continue'
            );


        }else{
            var quantity = $(this).closest('tr').find('.quantity').text();
            item_line_id = temp_item_line_id;
            if(quantity && number_test(quantity)>0)
            {
                var total_price = $(this).val();
                total_price = total_price.replace('$', '');
                total_price = total_price.replace(/,/g, '');
                quantity = quantity.replace(/,/g, '');
                if(total_price.charAt(0)=='$'){
                    total_price = total_price.substring(1, total_price.length);
                }

                if(parseInt(total_price) == total_price || parseFloat(total_price) == total_price){
                    var unit_price = total_price / quantity;
                    item_price =unit_price;
                    $(this).closest('tr').find(".unit-price").val('$'+ number_test(unit_price));
                    console.log('check109');
                    $(this).closest('tr').find('.span_unit_price1').text('$'+addCommas(number_test(unit_price)));
                }
            }
        }


    });
    $(document).on("keyup",".quantity",function() {
        var unit_price = $(this).closest('tr').find('.unit-price').val();
        //var total_price = $(this).closest('tr').find(".total-price").val();
        var quantity = $(this).val();
        unit_price = unit_price.replace('$', '');
        unit_price = unit_price.replace(/,/g, '');
        quantity = quantity.replace(/,/g, '');
        item_price =unit_price;

        if(parseInt(unit_price) == unit_price || parseFloat(unit_price) == unit_price && parseInt(quantity) == quantity || parseFloat(quantity) == quantity){
            var total_price = unit_price * quantity;
            $(this).closest('tr').find(".total-price").text(addCommas(number_test(total_price)));
        }

    });

   
    $(document).on("keyup","#time_type_input,#number_of_person,#hour_per_day,.excavator_measurement,.excavator_depth",function() {
        unsave_cal=true;
        custom_price_total = false;
        calculate_time_type();
        overheadRate = cleanNumber($(this).closest('form').find('.cal_overhead').val());
        profitRate = cleanNumber($(this).closest('form').find('.cal_profit').val());
        console.log('check225');
        updateItemPrices(overheadRate,profitRate);
    });
    $(document).on("change",".excavator_measurement_unit",function() {
        unsave_cal=true;  
        custom_price_total = false;
        calculate_time_type();
        overheadRate = cleanNumber($(this).closest('form').find('.cal_overhead').val());
        profitRate = cleanNumber($(this).closest('form').find('.cal_profit').val());
        console.log('check224');
        updateItemPrices(overheadRate,profitRate);
    });
   

    function calculate_time_type(){
        if(head_type_id==excavator_type_id){
            
            var excavator_measuremnt = cleanNumber($(".excavator_measurement").val());
            var excavator_depth = $(".excavator_depth").val();
            if( $(".excavator_measurement_unit").val()=='square feet'){
                excavator_measuremnt = Math.round(excavator_measuremnt / 9) ;
            }
            var temp_quantity = (excavator_measuremnt * (0.055*excavator_depth));
            $('.excavator_item_quantity').text(Math.ceil(temp_quantity));
        }
        calculateData = $("#time_type_form").closest('form').serializeArray();
       
        var time_type_input = $("#time_type_input").val();
        var number_of_person = $("#number_of_person").val();
        var hour_per_day = $("#hour_per_day").val();
        overheadRate = cleanNumber($("#time_type_form").closest('form').find('.cal_overhead').val());
        profitRate = cleanNumber($("#time_type_form").closest('form').find('.cal_profit').val());
       
        time_type_input = time_type_input.replace(/,/g, '');
        number_of_person = number_of_person.replace(/,/g, '');
        hour_per_day = hour_per_day.replace(/,/g, '');

        var total_time = time_type_input*number_of_person;
        if(unit_name=='Hours'){
            total_time =  total_time * hour_per_day;
        }
        item_quantity =total_time;
        console.log('check223');
        updateItemPrices(overheadRate,profitRate,);
        $(".total_time_value").text(addCommas(total_time));
        
        temp_total = item_quantity * item_price;

        taxRate = $('#time_type_form').find('.cal_tax').val();
        taxRate = taxRate.replace('%', '');
        var temptaxPrice = ((temp_total * taxRate) / 100);
        $('#time_type_form').find('.cal_tax_amount').text('$'+addCommas(number_test(temptaxPrice)));
        var temp_total = parseFloat(temp_total) + parseFloat(temptaxPrice);
        taxPrice = temptaxPrice;
        calTotalPrice = temp_total;
        if(custom_price_total){
                calTotalPrice = saved_custom_price;
        }
        $('.time_type_calculation').find('.cal_total_price').text(addCommas(number_test(calTotalPrice)));

        
       
        if(time_type_input && time_type_input>0 && number_of_person && number_of_person >0 && hour_per_day && hour_per_day>0){
            
            $("#continue2").removeClass('ui-state-disabled');
            $("#continue2").attr('disabled',false);
            
            
        }else{
           
            $("#continue2").addClass('ui-state-disabled');
            $("#continue2").attr('disabled',true);
        }
        
            var templ_default_days = $('#'+item_line_id).find('.default_days').text();
            var templ_default_qty = $('#'+item_line_id).find('.default_qty').text();
            var templ_default_hpd = $('#'+item_line_id).find('.default_hpd').text();
        if(savedData){
            var check = compareSavedValue(savedData,calculateData);
        }else{
            // if(time_type_input == templ_default_days && number_of_person ==templ_default_qty && hour_per_day == templ_default_hpd){
            //     check =true;
            // }else{
                check =false;
            //} 
        }
        
        if(check){

            if(custom_price_total || saved_custom_price==0){
                
                $('.if_item_saved').show();
                $('.save_estimation').hide(); 
                unsave_cal=false; 
            }else{
                $('.if_item_saved').hide();
                $('.save_estimation').show();
                $('.item_total_edit_icon').show();
                
                
                unsave_cal=true;
            }   
        }else{
            $('.if_item_saved').hide();
            $('.save_estimation').show();
            $('.item_total_edit_icon').show();
            unsave_cal=true;
        }
        child_save_done =false;
    }

    $(document).on("keyup","#depth,#measurement,#extra_ton",function() {
        custom_price_total = false;
        calculate_measurement();
    });

    $(document).on("change",".measurement_unit,#measurement_lbs",function() {
        if( $(".measurement_unit").val()=='square feet'){
            $('.total_surface_unit_text').text('Sq. Feet');
        }else{
            $('.total_surface_unit_text').text('Sq. Yds.');
        }
        custom_price_total = false;
        calculate_measurement();
    });


    function calculate_measurement(){

        var measuremnt = cleanNumber($("#measurement").val());
        var depth = $("#depth").val();
        

        calculateData = $("#measurement").closest('form').serializeArray();
        if( $(".measurement_unit").val()=='square feet'){
            $('.total_surface_unit_text').text('Sq. Feet');
            $('.total_surface_unit_text2').text('Foot');
        }else{
            $('.total_surface_unit_text').text('Sq. Yds.');
            $('.total_surface_unit_text2').text('Yard');
        }
        overheadRate = cleanNumber($("#measurement").closest('form').find('.cal_overhead').val());
        profitRate = cleanNumber($("#measurement").closest('form').find('.cal_profit').val());
        
        taxRate = $("#measurement").closest('form').find('.cal_tax').val();
        lbs = $("#measurement").closest('form').find('.measurement_lbs').val();
        extra_ton = $("#measurement").closest('form').find('#extra_ton').val();
       
        taxRate = taxRate.replace('%', '');

        depth = depth.replace(/,/g, '');
        if(measuremnt && measuremnt>0){
            $('.total_surface').text(addCommas(measuremnt));

        }else{
            $('.total_surface').text('0');
        }
        
        if(depth && depth>0){
            if( $(".measurement_unit").val()=='square feet'){
                measuremnt = Math.round(measuremnt / 9) ;
            }
            if(extra_ton){
                var quantity = (measuremnt * (lbs*depth)) ;
                quantity =(parseFloat(quantity) + parseFloat(extra_ton))
            }else{
                var quantity = (measuremnt * (lbs*depth));
            }
            
            var material_item_quantity = cleanNumber($('#'+item_line_id).find('.quantity').text());
            has_child_items = $('#'+item_line_id).find('.show_child_icon').is(":visible");
            
            item_quantity = Math.ceil(quantity);
            var temp = addCommas(item_quantity);
            
            $('.custom_unit_base_price_input').val(item_base_price);
            updateItemPrices(overheadRate,profitRate);
            $('.item_quantity').text(temp);
            
            var temp_total = item_quantity * item_price;
            if(measuremnt && measuremnt>0){
            $('.total_surface').text(addCommas(measuremnt));

            }else{
                $('.total_surface').text('0');
            }
            
            var temptaxPrice = ((temp_total * taxRate) / 100);
            if(!custom_price_total){
                $("#measurement").closest('form').find('.cal_tax_amount').text('$'+addCommas(number_test(temptaxPrice)));
            }
            taxPrice = temptaxPrice;
            var temp_total = parseFloat(temp_total) + parseFloat(temptaxPrice);
            
            
            if(head_type_id == excavation_type_id){
                
                    calTotalPrice = temp_total;
               
            }else{
                calTotalPrice = temp_total;
            }
            
            if($(".if_child_parent_total").is(":visible")){ 
                
                var temp_estimate_line_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
                get_child_items_list(temp_estimate_line_id,false,true);
                if(material_item_quantity != Math.ceil(quantity) && has_trucking_child){
                
                    $('.if_trucking_change_show_msg_parent').show();
                }else{
                    
                    $('.if_trucking_change_show_msg_parent').hide();
                
                }
            }
            
                if(custom_price_total){
                    calTotalPrice = saved_custom_price;
                }
            
            $('.asphalt-right').find('.cal_total_price').text(addCommas(number_test(calTotalPrice)));
            
            var tamp_cost_per_unit = calTotalPrice / measuremnt;
            $('.asphalt-right').find('.cost_per_unit').text(addCommas(number_test(tamp_cost_per_unit)));
        }else{
            $('.item_quantity').text('0.00');
        }
        
        if(depth>0 && measuremnt>0){
            $("#continue2").removeClass('ui-state-disabled');
            $("#continue2").attr('disabled',false);
           
           
        }else{
            $("#continue2").addClass('ui-state-disabled');
            $("#continue2").attr('disabled',true);
        }
        
        if(savedData){
            var check = compareSavedValue(savedData,calculateData);
        }else{
            check =false; 
        }
        
        if(check){
            
            if(custom_price_total || saved_custom_price==0){
                
                $('.if_item_saved').show();
                $('.save_estimation').hide(); 
                unsave_cal=false; 
            }else{
                $('.if_item_saved').hide();
                $('.save_estimation').show();
                $('.item_total_edit_icon').show();
                unsave_cal=true;
            }
                    
        }else{
            $('.if_item_saved').hide();
            $('.save_estimation').show();
            $('.item_total_edit_icon').show();
            unsave_cal=true;
        }
        // if(clicked_open_calulator){
            
        //     clicked_open_calulator=false;
        // }
        
        child_save_done =false;
    }

    function getFormData($form){
        var unindexed_array = $form.serializeArray();
        var indexed_array = {};

        $.map(unindexed_array, function(n, i){
            indexed_array[n['name']] = n['value'];
        });

        return indexed_array;
    }
    function test(){
        // var $form = $("#asphalt_form");
        // var data = getFormData($form);
        var old_quantity =$('#'+item_line_id).find('.quantity').text();
        var unit_price = $('#'+item_line_id).find('.unit-price').val();
        var temp_total_price = $('#'+item_line_id).find('.total-price').text();

        temp_total_price = cleanNumber(temp_total_price);


        unit_price = cleanNumber(unit_price);
        old_quantity = old_quantity?old_quantity:0;
        old_quantity = cleanNumber(old_quantity);
        item_quantity = number_test(item_quantity);
        calTotalPrice = number_test(calTotalPrice);

        if(old_quantity != item_quantity || unit_price != item_price || calTotalPrice != temp_total_price){
//if(old_quantity != item_quantity || unit_price != item_price){
            $('#'+item_line_id).closest('tr').addClass('has_value_changed');

            unsaved_row =true;
            //$("*").unbind();
            $('#'+item_line_id).closest('tr').find('.reset_item_line').show();
            var t =$('#'+item_line_id).closest('tbody').find('.save_est_btn:visible').length;
            if(t==0){
                $('#'+item_line_id).closest('tr').find('.save_est_btn').show();
            }
            var reset_save_item =  $('#'+item_line_id).closest('tr').hasClass('has_item_value');
            if(reset_save_item){
                $('#'+item_line_id).closest('tr').find('.undo_item_line').show();
            }
        }
        $('#'+item_line_id).find('.quantity').text(addCommas(number_test(item_quantity)));
        console.log('check110');
        $('#'+item_line_id).find('.span_unit_price1').text('$'+addCommas(number_test(item_price)));
        $('#'+item_line_id).find('.unit-price').val(item_price);

        if(parseInt(item_price) == item_price || parseFloat(item_price) == item_price ){
            // var total_price = item_price * item_quantity;
            //total_price = parseFloat(total_price) + parseFloat(taxPrice);
            $('#'+item_line_id).find(".total-price").text(addCommas(calTotalPrice));
        }
        var form_data = $("#"+calculator_form_id).serializeArray();
        // form_data.push({name: 'cal_profit', value: profitRate});
        // form_data.push({name: 'cal_overhead', value: overheadRate});

        $.ajax({
            url: '/ajax/saveCalculatorValues/',
            type: 'post',
            data: {
                'values':form_data,
                'proposalServiceId':proposal_service_id,
                'itemId':item_id,
                'id':estimate_calculator_id,
            },
            success: function(data){
                revert_adjust_price1();
                unsave_trucking_cal=false;
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }
        });
        $("#quantity_calculation").dialog('close');
    }


    $(".open_calculator").click(function() {
       
        $(".if_child_trucking_check_tax, .if_child_labor_check_tax,.if_child_material_check_tax, .if_child_equipment_check_tax,.if_child_custom_check_tax,.if_child_trucking_check, .if_child_labor_check, .if_child_equipment_check,.if_child_parent_total,.if_child_custom_check,.if_tax_total,.select_template_show,.if_child_default_check,.if_trucking_change_show_msg_parent,.if_item_saved,.if_child_fees_check,.if_child_fees_check_tax,.if_template_item_saved,.if_use_minimum_hours,.extra_ton_tr,.edit_perent_total_hours,.estimateFields,.measurement_lbs_tr,.if_edit_item_unit_price,.edit_sep_round_time,.cancle_edit_sep_round_time,.disposalTotalAmount").hide();
        
        $('.if_fixed_rate_template_calculator_open,.item_unit_edit_icon,cal_overhead_profit_checkbox,.hide_if_edit_item_unit_price,.cal_overhead_profit_checkbox,.round_time').show();
        $('.labor_child_icon,.trucking_child_icon,.equipement_child_icon,.custom_child_icon,.fees_child_icon,.permit_child_icon').removeClass('child_icons_active');
        child_save_done =false;
        clicked_open_calulator =true;
        has_trucking_child =false;
        custom_price_total =false;
        has_child_items =false;
        has_custom_total_price_update =false;
        has_custom_parent_total_price_update =false;
        has_custom_sep_total_price_update =false;
        has_sub_sep_total_price_update =false;
        has_custom_labor_total_price_update =false;
        has_custom_equipement_total_price_update =false;
        has_custom_trucking_total_price_update = false;
        has_custom_custom_total_price_update =false;
        savedData ='';
        edited_unit_price = 0;
        edited_base_price = 0;
        edited_total_price = 0;
        setDropdowns();
       
       var template_type_id = $(this).closest('tr').find('.open_calculator').attr('data-template-type-id');
       var templateHeading =  $(this).closest('table').attr('data-template-id');
       var template_fixed = $('#templateHeading'+templateHeading).attr('data-template-fixed');
       var template_name = $('#templateHeading'+templateHeading).attr('data-template-name');
       
       //if(edit_estimate_fields){
        
      // }
       $('.cal_profit').closest('tr').css('color','#444444');
       $('.cal_profit').css('color','#444444');
       $('.cal_overhead').closest('tr').css('color','#444444');
       $('.cal_overhead').css('color','#444444');
       $('#extra_ton').val('0');
        if(!template_type_id){
            $('.select_template_option').val('');
        }else{
            $('.select_template_option').val(template_type_id);
        }
        var temp_item_line_id = $(this).closest('tr').prop('id');
        $('.child_items_list').html('');
        estimate_calculator_id=null;

        if(unsaved_row){
            swal(
                'You have an unsaved price adjustment!',
               
            );

        }else{
            $("#loading_model").dialog('open');
           
            if(main_service==0){
                alert('please select service first');
                return false;
            }
            reset_trucking_var();
            
            $('.cal_disposal_checkbox').prop("checked", false);
            $('.cal_disposal_input').hide();
            $('.per_load').hide();
            $('.cal_disposal_input').val(0);
            $('.cal_disposal_per_load_input').val(0);
            $('.cal_total_disposal_amount').html('');

            $('.cal_total_price').css('font-weight','bold');
            $(".show_child_item_total").removeClass("show_child_item_total");
            $('.if_error_show_msg_parent').hide();
            $('.if_error_show_msg').hide();
            $('.error').removeClass('error');
            $('.select_box_error').removeClass('select_box_error');
            $('.select2_box_error').removeClass('select2_box_error');
            $('.if_child_items_lable_text').text('Total Price');
            
            $("#quantity_calculation").find('.orange').removeClass("orange");
            item_line_id = $(this).closest('tr').prop('id');
            var unit_type_id = $(this).closest('tr').find('.open_calculator').data('unit-type-id');
            var temp_category_id = $(this).closest('tr').find('.open_calculator').data('category-id');
            var template_item_default_days = $(this).closest('tr').find('.open_calculator').data('template-item-default-days');
            var template_item_default_qty = $(this).closest('tr').find('.open_calculator').data('template-item-default-qty');
            var template_item_default_hpd = $(this).closest('tr').find('.open_calculator').data('template-item-default-hpd');
            var temp_estimate_line_id = $(this).closest('tr').find('.open_calculator').attr('data-estimate-line-id');
            var categoryName = $(this).closest('tr').find('.open_calculator').data('category-name');
            var typeName = $(this).closest('tr').find('.open_calculator').data('type-name');
            var itemName = $(this).closest('tr').find('.open_calculator').attr('data-item-name');
            var unitSingleName = $(this).closest('tr').find('.open_calculator').attr('data-unit-single-name');
            var tempoverheadRate = $(this).closest('tr').find('.open_calculator').attr('data-item-overhead-rate');
            var tempprofitRate =$(this).closest('tr').find('.open_calculator').attr('data-item-profit-rate');
            var is_taxable = $(this).closest('tr').find('.open_calculator').attr('data-item-taxable');
            var item_tax_rate = $(this).closest('tr').find('.open_calculator').attr('data-item-tax-rate');
            var templ_default_days = $(this).closest('tr').find('.default_days').text();
            var templ_default_qty = $(this).closest('tr').find('.default_qty').text();
            var templ_default_hpd = $(this).closest('tr').find('.default_hpd').text();
            saved_custom_price =0;
            saved_unit_price =0;
            $("#quantity_calculation").find('.unit_price_label').text('Unit Price');
            $("#quantity_calculation").find('.total_price_label').text('Total Price');
            $("#quantity_calculation").find('.trucking_unit_price_label').text('Trucking Price');
            $("#quantity_calculation").find('.trucking_total_price_label').text('Trucking Total');
            if($(this).closest('tr').find('.open_calculator').attr('data-custom-total-price')==1){
                
                custom_price_total =true;
                //$("#quantity_calculation").find('.unit_price_label').text('Unit Price*');
                //$("#quantity_calculation").find('.total_price_label').text('Total Price*');
                $("#quantity_calculation").find('.trucking_unit_price_label').text('Trucking Price*');
                $("#quantity_calculation").find('.trucking_total_price_label').text('Trucking Total*');
                saved_custom_price = cleanNumber($(this).closest('tr').find('.open_calculator').attr('data-item-total-price'));
                saved_unit_price = cleanNumber($(this).closest('tr').find('.span_unit_price1').text());
            }else if($(this).closest('tr').find('.open_calculator').attr('data-custom-unit-price')==1){
                custom_price_total =true;
                
                //$("#quantity_calculation").find('.unit_price_label').text('Unit Price*');
                //$("#quantity_calculation").find('.total_price_label').text('Total Price*');
                
                saved_custom_price = cleanNumber($(this).closest('tr').find('.open_calculator').attr('data-item-total-price'));
                saved_unit_price = cleanNumber($(this).closest('tr').find('.span_unit_price1').text());
            }

            if($(this).closest('tr').find('.open_calculator').attr('data-edited-total-price')==1){
                $("#quantity_calculation").find('.total_price_label').text('Total Price*');
            }else if($(this).closest('tr').find('.open_calculator').attr('data-edited-unit-price')==1 || $(this).closest('tr').find('.open_calculator').attr('data-edited-base-price')==1){
                $("#quantity_calculation").find('.unit_price_label').text('Unit Price*');
            }
            // Update the heading in the popup
            //$('.calculator_heading').text(categoryName+' / '+typeName+' / '+itemName + '!!!');
            $('.calculator_heading').find('.calculatorHeadingCategory').text(categoryName);
            $('.calculator_heading').find('.calculatorHeadingType').text(typeName);
            $('.calculator_heading').find('.calculatorHeadingItem').text(itemName);

            head_type_id = $(this).closest('tr').find('.open_calculator').data('type-id');
            item_price = $(this).closest('tr').find('.unit-price ').val();
            // if(oh_pm_type==2){
            //     item_price = $(this).closest('tr').find('.open_calculator').data('item-unit-price');
            // }else{
            //     item_price = $(this).closest('tr').find('.open_calculator').data('item-base-price');
            // }
            //item_price = $(this).closest('tr').find('.open_calculator').data('item-unit-price');
            item_price = item_price.replace('$', '');
            item_price = item_price.replace(/,/g, '');
          
            item_id = $(this).closest('tr').find('.open_calculator').data('item-id');
            //$('.unit_type_name_text').text(unit_name);
            unit_name = $(this).closest('tr').find('.open_calculator').data('unit-name');
            item_base_price = $(this).closest('tr').find('.open_calculator').data('item-base-price');
            var services_html = $('#service_'+proposal_service_id).html();
            $('#service_html_box').html(services_html);
            round_off_masking();
            
            if(temp_estimate_line_id){
                $('#quantity_calculation').find('.estimate_item_notes').show();
            }else{
                $('#quantity_calculation').find('.estimate_item_notes').hide();
            }
            $('#quantity_calculation').find('.cal_tax_checkbox').attr("checked", false);
            $(".cal_overhead_profit_checkbox").find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
            $('.show_child_item_total_check').find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
            $('.show_child_item_total_tax_check').find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');            
            $('.show_overhead_and_profit').hide();
            $('.show_child_item_total,.if_edit_item_total_price,.if_edit_parent_item_total_price,.parent_total_percent,.if_edit_item_unit_price').hide();
            
            $('.if_nochild_items,.if_not_edit_item_total_price,.if_not_edit_parent_item_total_price').show();

            var services_title = $('#service_'+proposal_service_id+' .service_title_name').text();
            var phase_title = $('#service_'+proposal_service_id+' .phase_name_'+phase_id).text();
            if(template_name){
                if(template_fixed==1){
                    $(".if_template_item_saved").attr('title', '[FR] '+template_name);
                }else{
                    $(".if_template_item_saved").attr('title', template_name);
                }
                $(".if_template_item_saved").show();
            }else{
                $(".if_template_item_saved").hide();
            }
            $("#quantity_calculation").dialog('option', 'title', services_title+' | '+phase_title);

            $('#service_html_box').find('a').not('.cancel_field_save').remove();
            $('#service_html_box ul .add_phase_li').remove();
            $('#service_html_box ul .specification_sep').remove();
            $('#service_html_box ul .service_specifications').show();
            $('#service_html_box ul').find('.set_loader_phase').remove();
            $('#service_html_box ul li:last').remove();
            $('#service_html_box ul li:last').remove();
            $('#service_html_box ul li:last').remove();
            $('#service_html_box ul li:last').remove();
            $('#service_html_box ul li:last').remove();
            $('#service_html_box ul li:last').remove();
            $('#service_html_box ul li:last').remove();
            $('#service_html_box ul hr').remove();
            $('#service_html_box ul').addClass('pad0');
            $('.calculator_service_title').text(services_title+' | '+phase_title);
            var temp_type_id = $(this).closest('table').attr('id');
            temp_type_id = temp_type_id.replace('itemsType', '');
            if(head_type_id == trucking_type_id){
                $('.crack_sealer_section').hide();
                $('.sealcoating_section').hide();
                $('.sealcoating_section_right').hide();
                $('.time_type').hide();
                $('.time_type_calculation').hide();
                $('.one-box').hide();
                $('.right-bar').hide();
                $('.asphalt-right').hide();
                $('.striping_section').hide();
                $('#trucking_form').show();
                $('.sep_printoutpanel').hide();
                $('.sep_divMap').hide();
                $('.show_in_asphalt').hide();
                $('.hide_in_asphalt').hide();
                $('.show_in_sealcoating').hide();
                $('.show_in_striping').hide();
                $('.show_in_crack_sealer').hide();
                $('.printoutpanel').hide();
                $('.sep_divMap').hide();
                $('.sep_close_map').hide();
                $('.trucking_box').show();
                $('#concrete_form').hide();
                $('#sealcoating_material_form').hide();
            setDropdowns();
            $.uniform.update();
            $('.selectTruckingStart').select2('val',0);
            $('.selectTruckingEnd').select2('val',0);
            

            sep_trucking_start_add_search();
            sep_trucking_end_add_search();
            $('#trucking_form').find('.total_time_hours').addClass('hide_input_style2');
            $('#trucking_form').find('.total_time_hours').removeClass('text');
            $('#trucking_form').find('.total_time_hours').attr("readonly","readonly");
            $('.hidden_sep_trucking_start_searchBox').val('');
            $('.hidden_sep_trucking_start_searchBox').val('');

            $('.hidden_sep_trip_time').val('');
            $('.hidden_sep_plant_turnaround').val('');
            $('.hidden_sep_site_turnaround').val('');

            $('#sep_trucking_end_lat').val('');
            $('#sep_trucking_end_long').val('');
           
            $('.selectTruckingStart').val('');
            $('.selectTruckingEnd').val('');
            
            $('.sep_site_turnaround').val('');
            $('.sep_plant_turnaround').val('');
            $('.sep_trip_time').val('');
            $('.calculated_round_time').text('0');
            
                calculator_form_id ='trucking_form';
            }else
            if(unit_type_id==time_type_id){
                if(head_type_id == excavator_type_id){
                    $('.if_head_type_excavator').show();
                    
                }else{
                    $('.if_head_type_excavator').hide();
                }
                
                $('.unit_type_name_text').text(unit_name);
                $('.unit_type_name_text2').text(unit_name);
                
                $('.time_type_select').val(unit_name);

                $.uniform.update();
                $('.time_unit_text').text('Total '+unit_name);
                $('.time_type').show();
                $('.time_type_calculation').show();
                $('.one-box').hide();
                $('.right-bar').hide();
                $('.asphalt-right').hide();
                $('.striping_section').hide();
                $('.sealcoating_section').hide();
                $('.sealcoating_section_right').hide();
                $('.crack_sealer_section').hide();
                $('#trucking_form').hide();
                $('.show_in_asphalt').hide();
                $('.hide_in_asphalt').show();
                $('.show_in_sealcoating').hide();
                $('.show_in_striping').hide();
                $('.show_in_crack_sealer').hide();
                $('#concrete_form').hide();
                $('#sealcoating_material_form').hide();
                $('.time_form_show_labor_small').hide();
                $('.time_form_show_labor_big').hide();
                $('.time_form_show_equipment_small').hide();
                $('.time_form_show_equipment_big').hide();
                
                if(temp_category_id == equipment_category_id || temp_category_id == service_category_id){
                    if(head_type_id == excavator_type_id){
                        $('.time_form_show_labor_small').show();
                        
                        $('.first_small_icons').show();
                        $('.time_form_show_labor_big').hide();
                    }else{
                        $('.time_form_show_labor_small').hide();
                        $('.time_form_show_labor_big').show();
                        $('.first_small_icons').hide();
                    }
                    
                    $('.time_form_show_equipment').hide();
                }else if(temp_category_id == labor_category_id){
                    //$('.time_form_show_equipment').show();
                    if(head_type_id == excavator_type_id){
                        $('.time_form_show_equipment_small').show();
                        
                        $('.first_small_icons').show();
                        $('.time_form_show_equipment_big').hide();
                    }else{
                        $('.time_form_show_equipment_small').hide();
                        $('.time_form_show_equipment_big').show();
                        $('.first_small_icons').hide();
                    }
                    $('.time_form_show_labor').hide();
                }else{
                    $('.time_form_show_equipment').hide();
                    $('.time_form_show_labor').hide();
                }
                var select_options = '<option value="">Select</option>';
               
               $.each(truckingItems, function(index,jsonObject){
                   
                   select_options +='<option data-capacity="'+jsonObject.capacity+'" data-unit-price="'+jsonObject.base_price+'" data-profit-rate="'+jsonObject.profit_rate+'" data-overhead-rate="'+jsonObject.overhead_rate+'" data-minimum-hours="'+jsonObject.minimum_hours+'" value="'+jsonObject.id+'">'+jsonObject.name+'</option>';
               });
               round_off_masking();
               $('.trucking_item').html(select_options);
               $('.item_total_edit_icon').show();
               if(!template_type_id){
                
                    $('.second_small_icons').show();
                    $('.select_template_show_btn').show(); 
                    $('.select_template_show').show(); 
                }else{
                    
                    $('.item_total_edit_icon').hide();
                    $('.first_small_icons').hide();
                    $('.second_small_icons').hide();
                    $('.select_template_show_btn').hide(); 
                    $('.select_template_show').hide(); 
                }

                calculator_form_id ='time_type_form';
            }else if(main_service==crack_sealer_service){
                $('.crack_sealer_section').show();
                $('.sealcoating_section').hide();
                $('.sealcoating_section_right').hide();
                $('.time_type').hide();
                $('.time_type_calculation').hide();
                $('.one-box').hide();
                $('.right-bar').hide();
                $('.asphalt-right').hide();
                $('.striping_section').hide();
                $('#trucking_form').hide();
                $('.show_in_asphalt').hide();
                $('.hide_in_asphalt').hide();
                $('.show_in_sealcoating').hide();
                $('.show_in_striping').hide();
                $('.show_in_crack_sealer').show();
                $('#concrete_form').hide();
                $('#sealcoating_material_form').hide();
                $('#service_html_box7').html(services_html);
                $('#service_html_box7').find('a').remove();
                $('#service_html_box7').find('.show_input_span').remove();
                $('#service_html_box7').find('input[type="button"]').remove();
                $('#service_html_box7').find('input').show();
                $('#service_html_box7').find('select').show();
                $('#service_html_box7 ul .add_phase_li').remove();
                $('#service_html_box7 ul .specification_sep').remove();
                $('#service_html_box7 ul .service_specifications').show();
                $('#service_html_box7 ul').find('.set_loader_phase').remove();
                $('#service_html_box7 ul li:last').remove();
                $('#service_html_box7 ul li:last').remove();
                $('#service_html_box7 ul li:last').remove();
                $('#service_html_box7 ul li:last').remove();
                $('#service_html_box7 ul li:last').remove();
                $('#service_html_box7 ul li:last').remove();
                $('#service_html_box7 ul li:last').remove();
                $('#service_html_box7 ul hr').remove();
                $('#service_html_box7 ul').addClass('pad0');
                $('#service_html_box7 ul li').addClass('tr_info_tip2');
                $('#service_html_box7 ul li .tiptip2').addClass('tiptip').removeClass('tiptip2');
                $('#service_html_box7 ul li div').css("float","right");
                $('#service_html_box7 ul li div').css("margin-top","7px");
                round_off_masking();
                calculator_form_id ='crack_sealer_form';
            }else if(head_type_id==seal_sand_type_id || head_type_id==seal_additive_type_id){
                $('.sealcoating_item_price_span').text(item_price);
                $('#sealcoating_material_quantity_unit').text(unit_name);
                $('.sealcoating_section').hide();
                $('.sealcoating_section_right').hide();
                $('.time_type').hide();
                $('.time_type_calculation').hide();
                $('.one-box').hide();
                $('.right-bar').hide();
                $('.asphalt-right').hide();
                $('.crack_sealer_section').hide();
                $('.striping_section').hide();
                $('#trucking_form').hide();
                $('#concrete_form').hide();
                $('#sealcoating_material_form').show();
                $('.show_in_asphalt').hide();
                $('.show_in_concrete').hide();
                $('.hide_in_asphalt').hide();
                $('.show_in_sealcoating').hide();
                $('.show_in_striping').hide();
                $('.show_in_crack_sealer').hide();
                $('#service_html_box9').html(services_html);
                $('#service_html_box9').find('a').remove();
                $('#service_html_box9').find('.show_input_span').remove();
                $('#service_html_box9').find('input[type="button"]').remove();
                $('#service_html_box9').find('input').show();
                $('#service_html_box9').find('select').show();
                $('#service_html_box9 ul .add_phase_li').remove();
                $('#service_html_box9 ul .specification_sep').remove();
                $('#service_html_box9 ul .service_specifications').show();
                $('#service_html_box9 ul').find('.set_loader_phase').remove();
                $('#service_html_box9 ul li:last').remove();
                $('#service_html_box9 ul li:last').remove();
                $('#service_html_box9 ul li:last').remove();
                $('#service_html_box9 ul li:last').remove();
                $('#service_html_box9 ul li:last').remove();
                $('#service_html_box9 ul li:last').remove();
                $('#service_html_box9 ul li:last').remove();
                $('#service_html_box9 ul hr').remove();
                $('#service_html_box9 ul').addClass('pad0');
                $('#service_html_box9 ul li').addClass('tr_info_tip2');
                $('#service_html_box9 ul li .tiptip2').addClass('tiptip').removeClass('tiptip2');
                $('#service_html_box9 ul li div').css("float","right");
                $('#service_html_box9 ul li div').css("margin-top","7px");
                
                round_off_masking();
                calculator_form_id ='sealcoating_material_form';
                
            }else if(main_service==sealcoating_service){
                $('.sealcoating_item_price_span').text(item_price);
                $('.sealcoating_section').show();
                $('.sealcoating_section_right').show();
                $('.time_type').hide();
                $('.time_type_calculation').hide();
                $('.one-box').hide();
                $('.right-bar').hide();
                $('.asphalt-right').hide();
                $('.crack_sealer_section').hide();
                $('.striping_section').hide();
                $('#trucking_form').hide();
                $('#concrete_form').hide();
                $('#sealcoating_material_form').hide();
                $('.show_in_asphalt').hide();
                $('.show_in_concrete').hide();
                $('.hide_in_asphalt').hide();
                $('.show_in_sealcoating').show();
                $('.show_in_striping').hide();
                $('.show_in_crack_sealer').hide();
                $('#service_html_box5').html(services_html);
                $('#service_html_box5').find('a').remove();
                $('#service_html_box5').find('.show_input_span').remove();
                $('#service_html_box5').find('input[type="button"]').remove();
                $('#service_html_box5').find('input').show();
                $('#service_html_box5').find('select').show();
                $('#service_html_box5 ul .add_phase_li').remove();
                $('#service_html_box5 ul .specification_sep').remove();
                $('#service_html_box5 ul .service_specifications').show();
                $('#service_html_box5 ul').find('.set_loader_phase').remove();
                $('#service_html_box5 ul li:last').remove();
                $('#service_html_box5 ul li:last').remove();
                $('#service_html_box5 ul li:last').remove();
                $('#service_html_box5 ul li:last').remove();
                $('#service_html_box5 ul li:last').remove();
                $('#service_html_box5 ul li:last').remove();
                $('#service_html_box5 ul li:last').remove();
                $('#service_html_box5 ul hr').remove();
                $('#service_html_box5 ul').addClass('pad0');
                $('#service_html_box5 ul li').addClass('tr_info_tip2');
                $('#service_html_box5 ul li .tiptip2').addClass('tiptip').removeClass('tiptip2');
                $('#service_html_box5 ul li div').css("float","right");
                $('#service_html_box5 ul li div').css("margin-top","7px");
                // if(head_type_id == 10){
                //     $('.hide_in_sand_additive').show();
                // }else{
                //     $('.hide_in_sand_additive').hide();
                // }
                var select_options = '<option value="">Select</option>';
               
                $.each(sandSealerItems, function(index,jsonObject){
                    
                    select_options +='<option data-unit-base-price="'+jsonObject.unit_base_price+'"  data-unit-price="'+jsonObject.unit_price+'" value="'+jsonObject.id+'">'+jsonObject.name+'</option>';
                });
               
                $('.sand_sealer_item').html(select_options);
                var select_options = '<option value="">Select</option>';
               
                $.each(additiveSealerItems, function(index,jsonObject){
                    
                    select_options +='<option data-unit-base-price="'+jsonObject.unit_base_price+'"  data-unit-price="'+jsonObject.unit_price+'" value="'+jsonObject.id+'">'+jsonObject.name+'</option>';
                });
               
                $('.additive_sealer_item').html(select_options);
                round_off_masking();
                $.uniform.update();
                
                $('#sealcoating_form').find('.if_nochild_items').hide();
                

                $('#sealcoating_form').find('.if_child_parent_total').show();
                $('#sealcoating_form').find('.parent_total_percent').show();
                $('#sealcoating_form').find('.cal_total_price').css('font-weight','400');
                $('#sealcoating_form').find('.if_nochild_items').addClass('show_child_item_total');
                $('#sealcoating_form').find('.if_child_default_check').addClass('show_child_item_total');
                $('#sealcoating_form').find('.if_child_items_lable_text').text('Material Price');
                $('.item_total_edit_icon').hide();
                calculator_form_id ='sealcoating_form';
                $('.estimateFields').show()
            }else if(main_service==striping_service){
                $('.sealcoating_section').hide();
                $('.sealcoating_section_right').hide();
                $('.time_type').hide();
                $('.time_type_calculation').hide();
                $('.one-box').hide();
                $('.right-bar').hide();
                $('.asphalt-right').hide();
                $('.crack_sealer_section').hide();
                $('.striping_section').show();
                $('#trucking_form').hide();
                $('.show_in_asphalt').hide();
                $('.hide_in_asphalt').hide();
                $('.show_in_sealcoating').hide();
                $('.show_in_striping').show();
                $('.show_in_crack_sealer').hide();
                $('#concrete_form').hide();
                $('#sealcoating_material_form').hide();
                $('#service_html_box6').html(services_html);
                $('#service_html_box6').find('a').remove();
                $('#service_html_box6').find('.show_input_span').remove();
                $('#service_html_box6').find('input[type="button"]').remove();
                $('#service_html_box6').find('input').show();
                $('#service_html_box6').find('select').show();
                $('#service_html_box6 ul .add_phase_li').remove();
                $('#service_html_box6 ul .specification_sep').remove();
                $('#service_html_box6 ul .service_specifications').show();
                $('#service_html_box6 ul').find('.set_loader_phase').remove();
                $('#service_html_box6 ul li:last').remove();
                $('#service_html_box6 ul li:last').remove();
                $('#service_html_box6 ul li:last').remove();
                $('#service_html_box6 ul li:last').remove();
                $('#service_html_box6 ul li:last').remove();
                $('#service_html_box6 ul li:last').remove();
                $('#service_html_box6 ul li:last').remove();
                $('#service_html_box6 ul hr').remove();
                $('#service_html_box6 ul').addClass('pad0');
                $('#service_html_box6 ul li').addClass('tr_info_tip2');
                $('#service_html_box6 ul li .tiptip2').addClass('tiptip').removeClass('tiptip2');
                $('#service_html_box6 ul li div').css("float","right");
                $('#service_html_box6 ul li div').css("margin-top","7px");
                round_off_masking();
                calculator_form_id ='striping_form';
                $('.estimateFields').show()
            }else if(main_service==concrete_service){
                $('.sealcoating_section').hide();
                $('.sealcoating_section_right').hide();
                $('.time_type').hide();
                $('.time_type_calculation').hide();
                $('.one-box').hide();
                $('.right-bar').hide();
                $('.asphalt-right').hide();
                $('.crack_sealer_section').hide();
                $('.striping_section').hide();
                $('#trucking_form').hide();
                $('.show_in_asphalt').hide();
                $('.show_in_concrete').show();
                $('.hide_in_asphalt').hide();
                $('.show_in_sealcoating').hide();
                $('.show_in_striping').hide();
                $('.show_in_crack_sealer').hide();
                $('#concrete_form').show();
                $('#sealcoating_material_form').hide();
                $('#service_html_box4').html(services_html);
                $('#service_html_box4').find('a').remove();
                $('#service_html_box4').find('.show_input_span').remove();
                $('#service_html_box4').find('input[type="button"]').remove();
                $('#service_html_box4').find('input').show();
                $('#service_html_box4').find('select').show();
                $('#service_html_box4 ul .add_phase_li').remove();
                $('#service_html_box4 ul .specification_sep').remove();
                $('#service_html_box4 ul .service_specifications').show();
                $('#service_html_box4 ul').find('.set_loader_phase').remove();
                $('#service_html_box4 ul li:last').remove();
                $('#service_html_box4 ul li:last').remove();
                $('#service_html_box4 ul li:last').remove();
                $('#service_html_box4 ul li:last').remove();
                $('#service_html_box4 ul li:last').remove();
                $('#service_html_box4 ul li:last').remove();
                $('#service_html_box4 ul hr').remove();
                $('#service_html_box4 ul').addClass('pad0');
                $('#service_html_box4 ul li').addClass('tr_info_tip2');
                $('#service_html_box4 ul li .tiptip2').addClass('tiptip').removeClass('tiptip2');
                //$('#service_html_box3 ul').append('<li class="if_ast_change"><input type="button" style="padding: 0.22em 0.3em; float: right;" value="Save" class="btn mb-5px blue-button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only save_sidebar_estimate" ></li>');
                $('#service_html_box4 ul li div').css("float","right");
                $('#service_html_box4 ul li div').css("margin-top","7px");
                var select_options = '<option value="">Select</option>';
               
               $.each(truckingItems, function(index,jsonObject){
                   
                   select_options +='<option data-capacity="'+jsonObject.capacity+'" data-unit-price="'+jsonObject.base_price+'" data-profit-rate="'+jsonObject.profit_rate+'" data-overhead-rate="'+jsonObject.overhead_rate+'" data-minimum-hours="'+jsonObject.minimum_hours+'" value="'+jsonObject.id+'">'+jsonObject.name+'</option>';
               });
               round_off_masking();
               $('.trucking_item').html(select_options);
                calculator_form_id ='concrete_form';
                $('.estimateFields').show()
            }else{
                $('.time_type').hide();
                $('.show_in_asphalt').show();
                $('.hide_in_asphalt').hide();
                $('.show_in_sealcoating').hide();
                $('.show_in_striping').hide();
                $('.time_type_calculation').hide();
                $('.one-box').show();
                $('.right-bar').show();
                $('.asphalt-right').show();
                $('.sealcoating_section').hide();
                $('.sealcoating_section_right').hide();
                $('.crack_sealer_section').hide();
                $('.striping_section').hide();
                $('.show_in_crack_sealer').hide();
                $('#trucking_form').hide();
                $('#concrete_form').hide();
                $('#sealcoating_material_form').hide();
                $('#service_html_box3').html(services_html);
                $('#service_html_box3').find('a').remove();
                $('#service_html_box3').find('.show_input_span').remove();
                $('#service_html_box3').find('input[type="button"]').remove();
                $('#service_html_box3').find('input').show();
                $('#service_html_box3').find('select').show();
                $('#service_html_box3 ul .add_phase_li').remove();
                $('#service_html_box3 ul .specification_sep').remove();
                $('#service_html_box3 ul .service_specifications').show();
                $('#service_html_box3 ul').find('.set_loader_phase').remove();
                $('#service_html_box3 ul li:last').remove();
                $('#service_html_box3 ul li:last').remove();
                $('#service_html_box3 ul li:last').remove();
                $('#service_html_box3 ul li:last').remove();
                $('#service_html_box3 ul li:last').remove();
                $('#service_html_box3 ul li:last').remove();
                $('#service_html_box3 ul li:last').remove();
                $('#service_html_box3 ul hr').remove();
                $('#service_html_box3 ul').addClass('pad0');
                $('#service_html_box3 ul li').addClass('tr_info_tip2');
                $('#service_html_box3 ul li .tiptip2').addClass('tiptip').removeClass('tiptip2');
                $('.if_head_type_excavatoin').hide();
                
                if(head_type_id == gravel_type_id){
                    
                    $("#service_html_box3 ul li").find(".depth_field_tiptip").remove();
                    $("#service_html_box3 ul li").find(".base_depth_field_tiptip").remove();
                    $("#service_html_box3 ul li").find(".excavation_depth_field_tiptip").remove();
                }else if(head_type_id == base_asphalt_type_id){
                    
                    $("#service_html_box3 ul li").find(".depth_field_tiptip").remove();
                    $("#service_html_box3 ul li").find(".gravel_depth_field_tiptip").remove();
                    $("#service_html_box3 ul li").find(".excavation_depth_field_tiptip").remove();
                }else if(head_type_id == excavation_type_id ){
                    
                    $("#service_html_box3 ul li").find(".depth_field_tiptip").remove();
                    $("#service_html_box3 ul li").find(".gravel_depth_field_tiptip").remove();
                    $("#service_html_box3 ul li").find(".base_depth_field_tiptip").remove();
                    $('.if_head_type_excavatoin').show();
                }else if(head_type_id == asphalt_type_id ){
                    
                    $("#service_html_box3 ul li").find(".gravel_depth_field_tiptip").remove();
                    $("#service_html_box3 ul li").find(".base_depth_field_tiptip").remove();
                    $("#service_html_box3 ul li").find(".excavation_depth_field_tiptip").remove();
                    $('.measurement_lbs_tr').show();
                }
                else{
                    $("#service_html_box3 ul li").find(".gravel_depth_field_tiptip").remove();
                    $("#service_html_box3 ul li").find(".base_depth_field_tiptip").remove();
                    $("#service_html_box3 ul li").find(".excavation_depth_field_tiptip").remove();
                }
                
                //$('#service_html_box3 ul').append('<li class="if_ast_change"><input type="button" style="padding: 0.22em 0.3em; float: right;" value="Save" class="btn mb-5px blue-button ui-button ui-widget ui-state-default ui-corner-all ui-button-text-only save_sidebar_estimate" ></li>');
                $('#service_html_box3 ul li div').css("float","right");
                $('#service_html_box3 ul li div').css("margin-top","7px");
               
                var select_options = '<option value="">Select</option>';
               
                $.each(truckingItems, function(index,jsonObject){
                    
                    select_options +='<option data-capacity="'+jsonObject.capacity+'" data-unit-price="'+jsonObject.base_price+'" data-profit-rate="'+jsonObject.profit_rate+'" data-overhead-rate="'+jsonObject.overhead_rate+'" data-minimum-hours="'+jsonObject.minimum_hours+'"  value="'+jsonObject.id+'">'+jsonObject.name+'</option>';
                });
                
                $('.trucking_item').html(select_options);
                calculator_form_id ='asphalt_form';
               
                round_off_masking();
                $.uniform.update();
                $('.estimateFields').show()
            }
           
            number_field_masking();
           $(".tiptip").tipTip({ defaultPosition: "top",delay: 0});
           console.log('item_base_price-'+item_base_price)
            $('.cal_unit_price').text(addCommas(item_price));

            $('.cal_unit_single_name').text(' / '+unitSingleName);
            
            if(temp_estimate_line_id){
                
                if(template_type_id && calculator_form_id =='time_type_form'){
                    $('.select_template_show').hide(); 
                }else{
                    $('.select_template_show').show(); 
                }
               
                $('.if_item_saved,.item_total_edit_icon').show(); 
                
                if(template_fixed==1){
                    
                    $('.if_fixed_rate_template_calculator_open').hide();
                }
                $.ajax({
                    url: '/ajax/loadCalculatorValues/'+proposal_service_id+'/'+item_id+'/'+temp_estimate_line_id,
                    type: 'get',

                    success: function( data){
                        data = JSON.parse(data);
                        ItemCategoryName = data.itemDetails.categoryName
                        estimate_calculator_id = data.id;
                        var is_custom_time =false;
                        var is_custom_round_time =false;
                        item_base_price = data.itemDetails.base_price;
                        item_price = data.itemDetails.unit_price;
                        item_quantity = data.itemDetails.quantity;
                        if(data.values){
                            var array = JSON.parse(data.values);
                            savedData = array;
                            var $form = $("#"+calculator_form_id);
                            for($i=0;$i<array.length;$i++){
                                var $field = $form.find('[name=' + array[$i].name + ']');
                                if(array[$i].field_code){
                                    $field.attr('data-field-code',array[$i].field_code);
                                }
                                $field.val(array[$i].value);
                                if($field.attr('type')=='checkbox'){
                                    $field.prop("checked",true);
                                }
                                if(array[$i].name=='extra_ton' && array[$i].value >0){
                                    $('.extra_ton_tr').show();
                                }
                                if(array[$i].name=='perent_custom_total_time' && array[$i].value >0){
                                    is_custom_time =true;
                                }
                                if(array[$i].name=='sep_custom_round_time' && array[$i].value >0){
                                    is_custom_round_time =true;
                                }
                                
                            }
                            
                            if(data.itemDetails.is_custom_price==1){
                                if(parseFloat(data.itemDetails.overhead_price)<0){
                                    var temp_overheadPrice = '-$'+addCommas(number_test(Math.abs(data.itemDetails.overhead_price)));
                                    $('#'+calculator_form_id).find('.cal_overhead').closest('tr').css('color','red');
                                    $('#'+calculator_form_id).find('.cal_overhead').css('color','red');
                                }else{
                                    var temp_overheadPrice = '$'+addCommas(number_test(data.itemDetails.overhead_price));
                                    $('#'+calculator_form_id).find('.cal_overhead').closest('tr').css('color','#444444');
                                    $('#'+calculator_form_id).find('.cal_overhead').css('color','#444444');
                                }

                                if(parseFloat(data.itemDetails.profit_price)<0){
                                    var temp_profitPrice = '-$'+addCommas(number_test(Math.abs(data.itemDetails.profit_price)));
                                    $('#'+calculator_form_id).find('.cal_profit').closest('tr').css('color','red');
                                    $('#'+calculator_form_id).find('.cal_profit').css('color','red');
                                }else{
                                    var temp_profitPrice = '$'+addCommas(number_test(data.itemDetails.profit_price));
                                    $('#'+calculator_form_id).find('.cal_profit').closest('tr').css('color','#444444');
                                $('#'+calculator_form_id).find('.cal_profit').css('color','#444444');
                                }
                                $('#'+calculator_form_id).find('.cal_overhead_price').text(temp_overheadPrice);
                                $('#'+calculator_form_id).find('.cal_profit_price').text(temp_profitPrice);
                                $('#'+calculator_form_id).find('.cal_tax_amount').text('$'+addCommas(number_test(data.itemDetails.tax_price)));
                            }
                           // $('#'+calculator_form_id).find('.cal_profit').val(data.itemDetails.profit_rate);
                           
                           // $('#'+calculator_form_id).find('.cal_unit_price').val(data.itemDetails.unit_price);
                            
                            if(calculator_form_id=='striping_form'){
                                stripingPaintRender();
                                get_child_items_list(temp_estimate_line_id,true);
                               
                            }else if(calculator_form_id=='sealcoating_form'){
                                sealcoatCalculator()
                                get_child_items_list(temp_estimate_line_id,true);
                               
                            }else if(calculator_form_id=='crack_sealer_form'){
                                
                                cracksealCalculator()
                                get_child_items_list(temp_estimate_line_id,true);
                            }else if(calculator_form_id=='asphalt_form'){
                            
                                
                                calculate_measurement();
                                get_child_items_list(temp_estimate_line_id,true);
                                
                            
                            }else if(calculator_form_id=='time_type_form'){
                                calculate_time_type()
                                
                                get_child_items_list(temp_estimate_line_id,true);
                                
                            }else if(calculator_form_id=='trucking_form'){
                                
                                calculate_trucking_type('trucking_form',false,false,false,is_custom_time,is_custom_round_time)
                                $("#loading_model").dialog('close');
                                
                            $("#quantity_calculation").dialog('open');
                            //$('.field_input').focus();
                            //$('.field_input').blur();
                            $('.save_estimation').focus();
                            $('.save_estimation').blur();
                            }else if(calculator_form_id=='concrete_form'){
                                
                                if($('.cal_disposal_checkbox').prop("checked")){
                                    $('.cal_disposal_input').show();
                                    $('.per_load').show();
                                    $('.disposalTotalAmount').show();
                                    calculate_concrete_measurement(true);
                                } else {
                                    $('.cal_disposal_input').hide();
                                    $('.per_load').hide();
                                    $('.disposalTotalAmount').hide();
                                    calculate_concrete_measurement();
                                }
                                
                                
                                get_child_items_list(temp_estimate_line_id,true);
                            }else if(calculator_form_id=='sealcoating_material_form'){
                                sealcoating_material_measurement()
                                get_child_items_list(temp_estimate_line_id,true);
                               
                            }

                            if(taxRate>0){
                                $form.find('.cal_tax_checkbox').prop("checked",true);
                                $form.find('.cal_tax_checkbox_tr div span').addClass('checked');
                                $form.find('.cal_tax').show();
                                $form.find('.cal_tax_amount_row').show();
                            }else{
                                $form.find('.cal_tax_checkbox').prop("checked",false);
                                $form.find('.cal_tax_checkbox_tr div span').removeClass('checked');
                                $form.find('.cal_tax').hide();
                                $form.find('.cal_tax_amount_row').hide();
                            }
                            
                            
                            
                        }else{
                            
                            $("#"+calculator_form_id).trigger("reset");
                            if(oh_pm_type==2){
                                
                                $('#'+calculator_form_id).find('.cal_overhead').val(tempoverheadRate);
                                $('#'+calculator_form_id).find('.cal_profit').val(tempprofitRate);
                            }else{
                                 $('#'+calculator_form_id).find('.cal_overhead').val(service_overhead_rate);
                                $('#'+calculator_form_id).find('.cal_profit').val(service_profit_rate);
                            }
                            
                            $('#'+calculator_form_id).find('.cal_overhead_price').text('');
                            $('#'+calculator_form_id).find('.cal_profit_price').text('');
                            $('#'+calculator_form_id).find('.cal_total_price').text('0');

                            $("#continue2").addClass('ui-state-disabled');
                            $("#continue2").attr('disabled',true);
                            if(calculator_form_id=='striping_form'){
                                $("#stripingMaterialTotal").html(0);
                                $("#stripingTotalQty").html(0);
                                $("#stripingTotalMaterialCost").html(0);
                                $("#stripingMaterialBaseCost").html(0);
                                $('#service_'+proposal_service_id+' ul li').each(function(){
                                    if($(this).attr('data-measurement-field')=='1'){
                                        $('#stripingFeet').val($(this).find('.show_input_span').text());
                                    }
                                    
                                });
                                stripingPaintRender();
                            }else if(calculator_form_id=='sealcoating_form'){
                                $("#sealcoatSealerTotal").html(0);
                                $("#sealcoatWaterTotal").html(0);
                                $("#sealcoatAdditiveTotal").html(0);
                                $("#sealcoatSandTotal").html(0);
                                $(".sealcoatAdditiveTotalInput").val(0);
                                $(".sealcoatSandTotalInput").val(0);
                                $("#sealcoatSandTotalGal").html(0);
                                $("#sealcoatTotal").html(0);
                                $(".cal_child_default_total_price").html(0);
                                $('#sealcoating_form').find(".cal_child_parent_total_price").html(0);
                                $('#sealcoating_form').find(".cost_per_unit").html(0);
                                $('#sealcoating_form').find(".cal_total_price").html(0);
                                $('#sealcoating_form').find(".parent_total_percent").html('0%');
                                $('#sealcoating_form').find(".child_default_total_percent").html('0%');
                                
                                $('#service_'+proposal_service_id+' ul li').each(function(){
                                    if($(this).attr('data-measurement-field')=='1'){
                                        $('#sealcoatArea').val($(this).find('.show_input_span').text());
                                    }
                                    if($(this).attr('data-unit-field')=='1'){
                                        
                                        var text_val = $(this).find('.show_input_span').text();
                                        text_val =  $.trim(text_val);
                                        if(text_val=='square feet'){
                                            $('#sealcoatUnit').val('square feet');
                                            $('.total_surface_unit_text').text('Sq. Feet');
                                            $('.total_surface_unit_text2').text('Foot');
                                        }else{
                                            $('#sealcoatUnit').val('square yard');
                                            $('.total_surface_unit_text').text('Sq. Yds.');
                                            $('.total_surface_unit_text2').text('Yard');
                                        }
                                    }
                                });
                                sealcoatCalculator();
                            }else if(calculator_form_id=='crack_sealer_form'){
                                $("#cracksealTotalMaterial").html(0);
                                $("#cracksealTotalPrice").html(0);
                                $('#service_'+proposal_service_id+' ul li').each(function(){
                                    if($(this).attr('data-measurement-field')=='1'){
                                        $('#crackseakLength').val($(this).find('.show_input_span').text());
                                    }
                                    
                                });
                                cracksealCalculator()
                            }else if(calculator_form_id=='asphalt_form'){
                            
                                $('#service_'+proposal_service_id+' ul li').each(function(){
                                    if($(this).attr('data-measurement-field')=='1'){
                                        $('#measurement').val($(this).find('.show_input_span').text());
                                    }
                                    if(head_type_id == gravel_type_id){
                                    
                                        if($(this).attr('data-gravel-depth-field')=='1'){
                                            $('#depth').val($(this).find('.show_input_span').text());
                                        }
                                    }else if(head_type_id == base_asphalt_type_id){
                                    
                                        if($(this).attr('data-base-depth-field')=='1'){
                                            $('#depth').val($(this).find('.show_input_span').text());
                                        }
                                    }else if(head_type_id == excavation_type_id ){
                                    
                                        if($(this).attr('data-excavation-depth-field')=='1'){
                                            $('#depth').val($(this).find('.show_input_span').text());
                                        }
                                    }else{
                                            if($(this).attr('data-depth-field')=='1'){
                                                $('#depth').val($(this).find('.show_input_span').text());
                                            }
                                        }
                                    
                                    if($(this).attr('data-unit-field')=='1'){
                                        
                                        var text_val = $(this).find('.show_input_span').text();
                                        text_val =  $.trim(text_val);
                                        if(text_val=='square feet'){
                                            $('.measurement_unit').val('square feet');
                                        }else{
                                            $('.measurement_unit').val('square yard');
                                        }
                                    }
                                });
                                var capacity = $('.trucking_item').find(':selected').attr('data-capacity');
                                var minimum_hours = $('.trucking_item').find(':selected').attr('data-minimum-hours');
                                
                                
                                $('#map_model').find('.truck_capacity').val(capacity);
                                $('#map_model').find('.child_minimum_hours').val(number_test2(minimum_hours));
                                $('.total_surface').text('0');
                                $('.item_quantity').text('0.00');
                                $('.cal_trucking_oh_price').text('');
                                $('.cal_trucking_pm_price').text('');
                                $('.cal_trucking_total_price').text('0');
                                $(".if_trucking_check").hide();
                                $.uniform.update();
                                
                                calculate_measurement();
                                
                            }else if(calculator_form_id=='time_type_form'){
                                $(".total_time_value").text(0);
                                $('#service_'+proposal_service_id+' ul li').each(function(){
                                    if($(this).attr('data-measurement-field')=='1'){
                                        $('.excavator_measurement').val($(this).find('.show_input_span').text());
                                    }
                                    
                                    
                                        if($(this).attr('data-excavation-depth-field')=='1'){
                                            $('.excavator_depth').val($(this).find('.show_input_span').text());
                                        }
                                   
                                    
                                    if($(this).attr('data-unit-field')=='1'){
                                        
                                        var text_val = $(this).find('.show_input_span').text();
                                        text_val =  $.trim(text_val);
                                        if(text_val=='square feet'){
                                            $('.excavator_measurement_unit').val('square feet');
                                        }else{
                                            $('.excavator_measurement_unit').val('square yard');
                                        }
                                    }
                                });
                                if($("#categoryTabs .ui-tabs-panel:visible").attr("id") == 'templatesTab'){
                                    
                                    if(template_item_default_days){

                                        //var temp22 =template_item_default_hpd?template_item_default_hpd:0;
                                       
                                        //$('#'+calculator_form_id).find('#time_type_input').val(template_item_default_days);
                                        //$('#'+calculator_form_id).find('#number_of_person').val(template_item_default_qty);
                                        //$('#'+calculator_form_id).find('#hour_per_day').val(template_item_default_hpd);
                                        $('#'+calculator_form_id).find('#time_type_input').val(templ_default_days);
                                        $('#'+calculator_form_id).find('#number_of_person').val(templ_default_qty);
                                        
                                        $('#'+calculator_form_id).find('#hour_per_day').val(templ_default_hpd);
                                        calculate_time_type();
                                    }
                                }
                            }else if(calculator_form_id=='concrete_form'){
                            
                                $('#service_'+proposal_service_id+' ul li').each(function(){
                                    if($(this).attr('data-measurement-field')=='1'){
                                        $('#concrete_measurement').val($(this).find('.show_input_span').text());
                                    }else if($(this).attr('data-depth-field')=='1'){
                                            $('#concrete_depth').val($(this).find('.show_input_span').text());
                                    }else if($(this).attr('data-excavation-depth-field')=='1'){
                                            $('#concrete_depth').val($(this).find('.show_input_span').text());
                                    }
                                    
                                });
                                
                                calculate_concrete_measurement();
                                //get_child_items_list(temp_estimate_line_id,true);
                            }else if(calculator_form_id=='trucking_form'){
                                
                                if(oh_pm_type==2){
                                    $('#'+calculator_form_id).find('.sep_trucking_cal_overhead').val(data.itemDetails.overhead_rate);
                                    $('#'+calculator_form_id).find('.sep_trucking_cal_profit').val(data.itemDetails.profit_rate);
                                }else{
                                    $('#'+calculator_form_id).find('.sep_trucking_cal_overhead').val(service_overhead_rate);
                                    $('#'+calculator_form_id).find('.sep_trucking_cal_profit').val(service_profit_rate );
                                }
                            }
                        
                            $('#'+calculator_form_id).find('.cal_tax_checkbox').prop("checked",false);
                            $('#'+calculator_form_id).find('.cal_tax_checkbox_tr div span').removeClass('checked');
                            $('#'+calculator_form_id).find('.cal_tax').hide();
                            $('#'+calculator_form_id).find('.cal_tax_amount_row').hide();
                        
                            $("#loading_model").dialog('close');
                            
                            $("#quantity_calculation").dialog('open');
                            
                            $('.save_estimation').focus();
                            $('.save_estimation').blur();
                        }
                            
                        setDropdowns();
                $.uniform.update();

                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                });


            }else{
                
            $('.item_total_edit_icon').hide();
            clicked_open_calulator =false;
            $("#"+calculator_form_id).trigger("reset");
                            
            $('#trucking_form').find('.sep_plant_turnaround').val('0.5');
            $('#trucking_form').find('.sep_site_turnaround').val('0.5');
                            if(is_taxable==1){
                                $('#'+calculator_form_id).find('.cal_tax_checkbox').prop("checked",true);
                                $('#'+calculator_form_id).find('.cal_tax_checkbox_tr div span').addClass('checked');
                                $('#'+calculator_form_id).find('.cal_tax').show();
                                $('#'+calculator_form_id).find('.cal_tax').val(item_tax_rate);
                                $('#'+calculator_form_id).find('.cal_tax_amount_row').show();
                            }else{
                                $('#'+calculator_form_id).find('.cal_tax_checkbox').prop("checked",false);
                                $('#'+calculator_form_id).find('.cal_tax_checkbox_tr div span').removeClass('checked');
                                $('#'+calculator_form_id).find('.cal_tax').hide();
                                $('#'+calculator_form_id).find('.cal_tax').val(0);
                                
                                $('#'+calculator_form_id).find('.cal_tax_amount').text('$0.00');
                                $('#'+calculator_form_id).find('.cal_tax_amount_row').hide();
                            }
                            if(oh_pm_type==2){
                                $('#'+calculator_form_id).find('.cal_overhead').val(tempoverheadRate);
                                $('#'+calculator_form_id).find('.cal_profit').val(tempprofitRate);
                            }else{
                                $('#'+calculator_form_id).find('.cal_overhead').val(service_overhead_rate);
                                $('#'+calculator_form_id).find('.cal_profit').val(service_profit_rate);
                            }
                            
                            $('#'+calculator_form_id).find('.cal_overhead_price').text('');
                            $('#'+calculator_form_id).find('.cal_profit_price').text('');
                            $('#'+calculator_form_id).find('.cal_total_price').text('0');
               
                            $("#continue2").addClass('ui-state-disabled');
                            $("#continue2").attr('disabled',true);
                            if(calculator_form_id=='striping_form'){
                                $("#stripingMaterialTotal").html(0);
                                $("#stripingTotalQty").html(0);
                                $("#stripingTotalMaterialCost").html(0);
                                $("#stripingMaterialBaseCost").html(0);
                                $('#service_'+proposal_service_id+' ul li').each(function(){
                                    if($(this).attr('data-measurement-field')=='1'){
                                        $('#stripingFeet').val($(this).find('.show_input_span').text());
                                        $('#stripingFeet').attr('data-field-code',$(this).attr('data-field-code'));
                                    }
                                    
                                });
                                $('.custom_unit_base_price_input').val(item_base_price); 
                                stripingPaintRender();
                            }else if(calculator_form_id=='sealcoating_form'){
                                $("#sealcoatSealerTotal").html(0);
                                $("#sealcoatWaterTotal").html(0);
                                $("#sealcoatAdditiveTotal").html(0);
                                $("#sealcoatSandTotal").html(0);
                                $(".sealcoatAdditiveTotalInput").val(0);
                                $(".sealcoatSandTotalInput").val(0);
                                $("#sealcoatSandTotalGal").html(0);
                                $("#sealcoatTotal").html(0);
                                $(".cal_child_default_total_price").html(0);
                                $('#sealcoating_form').find(".cal_child_parent_total_price").html(0);
                                $('#sealcoating_form').find(".cost_per_unit").html(0);
                                $('#sealcoating_form').find(".cal_total_price").html(0);
                                $('#sealcoating_form').find(".parent_total_percent").html('0%');
                                $('#sealcoating_form').find(".child_default_total_percent").html('0%');
                                $('#service_'+proposal_service_id+' ul li').each(function(){
                                    if($(this).attr('data-measurement-field')=='1'){
                                        $('#sealcoatArea').val($(this).find('.show_input_span').text());
                                        $('#sealcoatArea').attr('data-field-code',$(this).attr('data-field-code'));
                                    }
                                    if($(this).attr('data-unit-field')=='1'){
                                        
                                        var text_val = $(this).find('.show_input_span').text();
                                        $('#sealcoatUnit').attr('data-field-code',$(this).attr('data-field-code'));
                                        text_val =  $.trim(text_val);
                                        if(text_val=='square feet'){
                                            $('#sealcoatUnit').val('square feet');
                                            $('.total_surface_unit_text').text('Sq. Feet');
                                            $('.total_surface_unit_text2').text('Foot');
                                        }else{
                                            $('#sealcoatUnit').val('square yard');
                                            $('.total_surface_unit_text').text('Sq. Yds.');
                                            $('.total_surface_unit_text2').text('Yard');
                                        }
                                    }
                                });
                                $('.custom_unit_base_price_input').val(item_base_price); 
                                sealcoatCalculator();
                            }else if(calculator_form_id=='crack_sealer_form'){
                                $("#cracksealTotalMaterial").html(0);
                                $("#cracksealTotalPrice").html(0);
                                $('#service_'+proposal_service_id+' ul li').each(function(){
                                    if($(this).attr('data-measurement-field')=='1'){
                                        $('#crackseakLength').val($(this).find('.show_input_span').text());
                                        $('#crackseakLength').attr('data-field-code',$(this).attr('data-field-code'));
                                    }
                                    
                                });
                                $('.custom_unit_base_price_input').val(item_base_price); 
                                cracksealCalculator()
                            }else if(calculator_form_id=='asphalt_form'){

                                $('#service_'+proposal_service_id+' ul li').each(function(){
                                    if($(this).attr('data-measurement-field')=='1'){
                                        $('#measurement').val($(this).find('.show_input_span').text());
                                        $('#measurement').attr('data-field-code',$(this).attr('data-field-code'));
                                    }
                                    if(head_type_id == gravel_type_id){
                                    
                                        if($(this).attr('data-gravel-depth-field')=='1'){
                                            $('#depth').val($(this).find('.show_input_span').text());
                                            $('#depth').attr('data-field-code',$(this).attr('data-field-code'));
                                        }
                                    }else if(head_type_id == base_asphalt_type_id){
                                    
                                        if($(this).attr('data-base-depth-field')=='1'){
                                            $('#depth').val($(this).find('.show_input_span').text());
                                            $('#depth').attr('data-field-code',$(this).attr('data-field-code'));
                                        }
                                    }else if(head_type_id == excavation_type_id ){
                                    
                                        if($(this).attr('data-excavation-depth-field')=='1'){
                                            $('#depth').val($(this).find('.show_input_span').text());
                                            $('#depth').attr('data-field-code',$(this).attr('data-field-code'));
                                        }else if($(this).attr('data-depth-field')=='1'){
                                            $('#depth').val($(this).find('.show_input_span').text());
                                            $('#depth').attr('data-field-code',$(this).attr('data-field-code'));
                                        }
                                    }else{
                                        if($(this).attr('data-depth-field')=='1'){
                                            $('#depth').val($(this).find('.show_input_span').text());
                                            $('#depth').attr('data-field-code',$(this).attr('data-field-code'));
                                        }
                                    }
                                    
                                    if($(this).attr('data-unit-field')=='1'){
                                        $('.measurement_unit').attr('data-field-code',$(this).attr('data-field-code'));
                                        var text_val = $(this).find('.show_input_span').text();
                                        text_val =  $.trim(text_val);
                                        if(text_val=='square feet'){
                                            $('.measurement_unit').val('square feet');
                                        }else{
                                            $('.measurement_unit').val('square yard');
                                        }
                                    }
                                });
                                
                                $('.custom_unit_base_price_input').val(item_base_price); 
                                var capacity = $('.trucking_item').find(':selected').attr('data-capacity');
                                var minimum_hours = $('.trucking_item').find(':selected').attr('data-minimum-hours');
                                
                                $('#map_model').find('.child_minimum_hours').val(number_test2(minimum_hours));
                                $('#map_model').find('.truck_capacity').val(capacity);
                                $('.total_surface').text('0');
                                $('.item_quantity').text('0.00');
                                $('.cal_trucking_oh_price').text('');
                                $('.cal_trucking_pm_price').text('');
                                $('.cal_trucking_total_price').text('0');
                                $(".if_trucking_check").hide();
                                $.uniform.update();
                                calculate_measurement();
                                
                            }else if(calculator_form_id=='time_type_form'){
                                $(".total_time_value").text(0);
                                $('#service_'+proposal_service_id+' ul li').each(function(){
                                    if($(this).attr('data-measurement-field')=='1'){
                                        $('.excavator_measurement').val($(this).find('.show_input_span').text());
                                    }
                                    
                                    
                                        if($(this).attr('data-excavation-depth-field')=='1'){
                                            $('.excavator_depth').val($(this).find('.show_input_span').text());
                                        }
                                   
                                    
                                    if($(this).attr('data-unit-field')=='1'){
                                        
                                        var text_val = $(this).find('.show_input_span').text();
                                        text_val =  $.trim(text_val);
                                        if(text_val=='square feet'){
                                            $('.excavator_measurement_unit').val('square feet');
                                        }else{
                                            $('.excavator_measurement_unit').val('square yard');
                                        }
                                    }
                                });
                                if($("#categoryTabs .ui-tabs-panel:visible").attr("id") == 'templatesTab'){

                                    if(template_item_default_days){
                                        //var temp22 =template_item_default_hpd?template_item_default_hpd:0;
                                        //conosle.log(temp22);
                                        $('#'+calculator_form_id).find('#time_type_input').val(template_item_default_days);
                                        $('#'+calculator_form_id).find('#number_of_person').val(template_item_default_qty);
                                        $('#'+calculator_form_id).find('#hour_per_day').val(template_item_default_hpd);
                                        calculate_time_type();
                                    }
                                }
                                calculate_time_type();
                            }else if(calculator_form_id=='concrete_form'){
                            
                                $('#service_'+proposal_service_id+' ul li').each(function(){
                                    if($(this).attr('data-measurement-field')=='1'){
                                        $('#concrete_measurement').val($(this).find('.show_input_span').text());
                                        $('#concrete_measurement').attr('data-field-code',$(this).attr('data-field-code'));
                                    }else if($(this).attr('data-depth-field')=='1'){
                                            $('#concrete_depth').val($(this).find('.show_input_span').text());
                                            $('#concrete_depth').attr('data-field-code',$(this).attr('data-field-code'));
                                    }else if($(this).attr('data-excavation-depth-field')=='1'){
                                            $('#concrete_depth').val($(this).find('.show_input_span').text());
                                            $('#concrete_depth').attr('data-field-code',$(this).attr('data-field-code'));
                                    }
                                    
                                });
                                $('.custom_unit_base_price_input').val(item_base_price); 
                                calculate_concrete_measurement();
                                //get_child_items_list(temp_estimate_line_id,true);
                            }else if(calculator_form_id=='trucking_form'){
                                var sep_truck_capacity = $(this).closest('tr').find('.open_calculator').attr('data-item-capacity');
                                var minimum_hours = $(this).closest('tr').find('.open_calculator').attr('data-item-minimum-hours');
                                $('.sep_truck_capacity').val(sep_truck_capacity);
                                $('.sep_minimum_hours').val(number_test2(minimum_hours));
                                $('.total_trips').val('');
                                $('.round_time').text('');
                                $('.round_per_day').text('');
                                $('.ton_day_per_truck').text('');
                                $('.recommended_trucks').text('');
                                $('.sep_trucking_malerial').val('');
                                $('.sep_tons_per_day').text('');
                                $('.sep_trucking_day').val('1');
                                
                                $('.cal_total_price').text('0');
                                
                                if(oh_pm_type==2){
                                   
                                    
                                    $('#'+calculator_form_id).find('.sep_trucking_cal_overhead').val(tempoverheadRate);
                                    $('#'+calculator_form_id).find('.sep_trucking_cal_profit').val(tempprofitRate);
                                    var temp_cal_trucking_oh_Price = ((item_base_price * tempoverheadRate) / 100);
                                    var temp_cal_trucking_pm_Price = ((item_base_price * tempprofitRate) / 100);
                                
                                        var temp_unit_price = parseFloat(item_base_price) + parseFloat(temp_cal_trucking_oh_Price) + parseFloat(temp_cal_trucking_pm_Price);
                                    $('.cal_trucking_unit_price').text(addCommas(number_test(temp_unit_price)));
                                }else{
                                    
                                    // $('#'+calculator_form_id).find('.sep_trucking_cal_overhead').val(<?=$settings->getDefaultOverhead();?>);
                                    // $('#'+calculator_form_id).find('.sep_trucking_cal_profit').val(<?=$settings->getDefaultProfit();?>);
                                    $('#'+calculator_form_id).find('.sep_trucking_cal_overhead').val(service_overhead_rate);
                                    $('#'+calculator_form_id).find('.sep_trucking_cal_profit').val(service_profit_rate);
                                    var temp_cal_trucking_oh_Price = ((item_base_price * service_overhead_rate) / 100);
                                    var temp_cal_trucking_pm_Price = ((item_base_price * service_profit_rate) / 100);
                                
                                        var temp_unit_price = parseFloat(item_base_price) + parseFloat(temp_cal_trucking_oh_Price) + parseFloat(temp_cal_trucking_pm_Price);
                                    $('.cal_trucking_unit_price').text(addCommas(number_test(temp_unit_price)));
                                }

                            }else if(calculator_form_id=='sealcoating_material_form'){
                                $('.custom_unit_base_price_input').val(item_base_price);
                            }
                        
                               
                $("#loading_model").dialog('close');
                
                $("#quantity_calculation").dialog('open');
                $('.save_estimation').focus();
                $('.save_estimation').blur();
            }

        }
        $.uniform.update();
        
        $('.save_estimation').focus();
        $('.save_estimation').blur();
    });

    /**********************
     * Seal Coat Calculator *
     ************************/
    var sealcoatFields = "#sealcoatOverhead, #sealcoatProffit, #sealcoatHourlyCost, #sealcoatTripHours, #sealcoatMen, #sealcoatTrips, #sealcoatCoats, #sealcoatUnit, #sealcoatArea, #sealcoatWater, #sealcoatAdditive, #sealcoatSand, #sealcoatApplicationRate, #sealcoatSealerCost, #sealcoatSandCost, #sealcoatAdditiveCost,.additive_sealer_item,.sand_sealer_item";
    $(sealcoatFields).live('change keyup', function () {
        unsave_cal=true; 
        custom_price_total = false; 
        sealcoatCalculator();
        
    });
    var requestAuth;

    function sealcoatCalculator() {
        
        if ($("#sealcoatUnit").val() == 'square feet') {
            $("#sealCoatUnitValue2").html('Sq.Feet');
            $('.total_surface_unit_text').text('Sq. Feet');
            $('.total_surface_unit_text2').text('Foot');
            $(".apprate").removeAttr('id');
            $(".apprate2").attr('id', 'sealcoatApplicationRate');
            $(".apprate1_container").hide();
            $(".apprate2_container").show();
        } else {
            $("#sealCoatUnitValue2").html('Sq.Yards');
            $('.total_surface_unit_text').text('Sq. Yds.');
            $('.total_surface_unit_text2').text('Yard');
            $(".apprate").removeAttr('id');
            $(".apprate1").attr('id', 'sealcoatApplicationRate');
            $(".apprate2_container").hide();
            $(".apprate1_container").show();
        }
        overheadRate = cleanNumber($("#sealcoating_form").closest('form').find('.cal_overhead').val());
        profitRate = cleanNumber($("#sealcoating_form").closest('form').find('.cal_profit').val());
        //cal_trucking_oh = cleanNumber($("#sealcoating_form").closest('form').find('.cal_trucking_oh').val());
        //cal_trucking_pm = cleanNumber($("#sealcoating_form").closest('form').find('.cal_trucking_pm').val());
        //updateItemPrices(overheadRate,profitRate);
       
        
        requestAuth = Math.floor((Math.random() * 1000) + 1);
        var request = $.ajax({
            url: "<?php echo site_url('ajax/ajaxCalculators') ?>",
            type: "POST",
            data: {
                "action": "calculator_sealcoat",
                'area': $("#sealcoatArea").val(),
                'applicationRate': $("#sealcoatApplicationRate").val(),
                'water': $("#sealcoatWater").val(),
                'additive': $("#sealcoatAdditive").val(),
                'sand': $("#sealcoatSand").val(),
                'sealerPrice': item_price,
                'sandPrice':$('.sand_sealer_item').find(':selected').attr('data-unit-price'),
                'additivePrice':$('.additive_sealer_item').find(':selected').attr('data-unit-price'),
                'tripCount': 1,
                'tripHours': 0,
                'tripMen': 0,
                'tripHourlyCost': 0,
                'overhead':0,
                'proffit': 0,
                'requestAuth': requestAuth
            },
            dataType: "json",
            async:false,
            success: function (data) {
                if (data.success) {
                    if (data.requestAuth == requestAuth) {
                        item_quantity =number_test(data.sealer);
                        
                        updateItemPrices(overheadRate,profitRate);
                        $("#sealcoatSealerTotal").html(addCommas(number_test(data.sealer)));
                        $("#sealcoatWaterTotal").html(addCommas(number_test(data.water)));
                        $("#sealcoatAdditiveTotal").html(addCommas(number_test(data.additive)));
                        $("#sealcoatSandTotal").html(addCommas(number_test(data.sand)));
                        $(".sealcoatAdditiveTotalInput").val(number_test(data.additive));
                        $(".sealcoatSandTotalInput").val(number_test(data.sand));
                        $("#sealcoatSandTotalGal").html(addCommas(number_test(data.sandInGall)));
                        $("#sealcoatTotal").html(addCommas(number_test(data.totalGallons)));
                        var temp_total = item_quantity * item_price;
                        taxRate = $('#sealcoating_form').find('.cal_tax').val();
                        taxRate = taxRate.replace('%', '');
                        var temptaxPrice = ((temp_total * taxRate) / 100);
                        taxPrice = temptaxPrice;
                        var sealcoatArea =$("#sealcoatArea").val();
                        sealcoatArea = sealcoatArea.replace(/,/g, '');
                        $('#sealcoating_form').find('.cal_tax_amount').text('$'+addCommas(number_test(temptaxPrice)));
                        var temp_total = parseFloat(temp_total) + parseFloat(temptaxPrice);
                        calTotalPrice = temp_total;
                        if(custom_price_total){
                            calTotalPrice = saved_custom_price;
                        }
                        $('.sealcoating_section_right').find('.cal_total_price').text(addCommas(number_test(calTotalPrice)));
                        var tamp_cost_per_unit = parseFloat(calTotalPrice / sealcoatArea);
                        
                        var default_child_total = calculate_sum_defualt_sealcoat_items();
                        var temp_parent_total = parseFloat(calTotalPrice) + parseFloat(default_child_total);
                        $('.sealcoating_section_right').find('.cal_child_default_total_price').text(addCommas(number_test(default_child_total)));
                        $('.sealcoating_section_right').find('.cal_child_parent_total_price').text(addCommas(number_test(temp_parent_total)));
                        $('.sealcoating_section_right').find('.cost_per_unit').text(addCommas(number_test(tamp_cost_per_unit)));
                        if($(".if_child_parent_total").is(":visible")){ 
                            var temp_estimate_line_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
                            
                            if(temp_estimate_line_id){
                                get_child_items_list(temp_estimate_line_id,false,true);
                            }
                        }
                        
                        if(sealcoatArea && sealcoatArea>0){
                            
                            $("#continue2").removeClass('ui-state-disabled');
                            $("#continue2").attr('disabled',false);
                            
                           
                        }else{
                            
                            $("#continue2").addClass('ui-state-disabled');
                            $("#continue2").attr('disabled',true);
                        }
                    }
                } else {
                    alert('error handling request');
                }
            },
            error: function( jqXhr, textStatus, errorThrown ){
                $("#sealcoatSealerTotal").html(0);
                $("#sealcoatWaterTotal").html(0);
                $("#sealcoatAdditiveTotal").html(0);
                $("#sealcoatSandTotal").html(0);
                $(".sealcoatAdditiveTotalInput").val(0);
                $(".sealcoatSandTotalInput").val(0);
                $("#sealcoatSandTotalGal").html(0);
                $("#sealcoatTotal").html(0);
                $(".cal_child_default_total_price").html(0);
                $('#sealcoating_form').find(".cal_child_parent_total_price").html(0);
                $('#sealcoating_form').find(".cost_per_unit").html(0);
                $('#sealcoating_form').find(".cal_total_price").html(0);
                $('#sealcoating_form').find(".parent_total_percent").html('0%');
                $('#sealcoating_form').find(".child_default_total_percent").html('0%');
                $("#continue2").addClass('ui-state-disabled');
                $("#continue2").attr('disabled',true);
            }
        });
        calculateData = $("#sealcoating_form").serializeArray();
        
        if(savedData){
            var check = compareSavedValue(savedData,calculateData);
        }else{
            check =false; 
        }
        
        if(check){
            if(custom_price_total || saved_custom_price==0){

                $('.if_item_saved').show();
                $('.save_estimation').hide(); 
                unsave_cal=false; 
            }else{
                $('.if_item_saved').hide();
                $('.save_estimation').show();
                $('.item_total_edit_icon').show();
                unsave_cal=true;
            }       
        }else{
            $('.if_item_saved').hide();
            $('.save_estimation').show();
            $('.item_total_edit_icon').show();
            unsave_cal=true;
        }
        child_save_done =false;
    }

    /***************************
     * Crack Sealing Calculator *
     ****************************/
    var cracksealFields = "#crackseakLength, #cracksealWidth, #cracksealDepth, #cracksealProduct, #cracksealPackage, #crackseakCost";
    $(cracksealFields).live('change keyup', function () {
        unsave_cal=true;
        custom_price_total = false;  
        cracksealCalculator();
        
      
    });
    var requestAuth;

    function cracksealCalculator() {
        if ($("#cracksealProduct").val() == 1) {
            $("#cracksealUnit, #cracksealUnit2").html('Gal');
            $(".cwidth").removeAttr('id');
            $(".cwidth1").attr("id", 'cracksealWidth');
            $(".cdepth").removeAttr('id');
            $(".cdepth1").attr("id", 'cracksealDepth');
            $(".cwidth1_container").show();
            $(".cwidth2_container").hide();
            $(".cdepth1_container").show();
            $(".cdepth2_container").hide();
        } else {
            $("#cracksealUnit, #cracksealUnit2").html('Lbs');
            $(".cwidth").removeAttr('id').hide();
            $(".cwidth2").attr("id", 'cracksealWidth').show();
            $(".cdepth").removeAttr('id').hide();
            $(".cdepth2").attr("id", 'cracksealDepth').show();
            $(".cwidth2_container").show();
            $(".cwidth1_container").hide();
            $(".cdepth2_container").show();
            $(".cdepth1_container").hide();
        }
        console.log('dfdfdfdfdf')
        overheadRate = cleanNumber($("#crack_sealer_form").closest('form').find('.cal_overhead').val());
        profitRate = cleanNumber($("#crack_sealer_form").closest('form').find('.cal_profit').val());
        //cal_trucking_oh = cleanNumber($("#crack_sealer_form").closest('form').find('.cal_trucking_oh').val());
        //cal_trucking_pm = cleanNumber($("#crack_sealer_form").closest('form').find('.cal_trucking_pm').val());
        calculateData = $('#crack_sealer_form').serializeArray();
        var crackseakLength = $("#crackseakLength").val();
        requestAuth = Math.floor((Math.random() * 1000) + 1);
        var request = $.ajax({
            url: "<?php echo site_url('ajax/ajaxCalculators') ?>",
            type: "POST",
            data: {
                "action": "calculator_crackseal",
                "product": item_id,
                "width": $("#cracksealWidth").val(),
                "depth": $("#cracksealDepth").val(),
                "length": $("#crackseakLength").val(),
                "price": item_price,
                "requestAuth": requestAuth
            },
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    if (data.requestAuth == requestAuth) {
                        item_quantity = number_test(data.material);
                        console.log('check2212');
                        updateItemPrices(overheadRate,profitRate);
                        var temp_total = item_price * item_quantity;
                        taxRate = $('#crack_sealer_form').find('.cal_tax').val();
                        taxRate = taxRate.replace('%', '');
                        var temptaxPrice = ((temp_total * taxRate) / 100);
                        taxPrice = temptaxPrice;
                        
                        $('#crack_sealer_form').find('.cal_tax_amount').text('$'+addCommas(number_test(temptaxPrice)));
                        var temp_total = parseFloat(temp_total) + parseFloat(temptaxPrice);
                        calTotalPrice = temp_total;

                        if(custom_price_total){
                            calTotalPrice = saved_custom_price;
                        }
                        $('.crack_sealer_section').find('.cal_total_price').text(addCommas(number_test(calTotalPrice)));
                        $("#cracksealTotalMaterial").html(addCommas(number_test(data.material)));
                        $("#cracksealTotalPrice").html(addCommas(number_test(data.cost)));
                        if($(".if_child_parent_total").is(":visible")){ 
                            var temp_estimate_line_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
                            get_child_items_list(temp_estimate_line_id,false,true);
                        }
                        
                        if(crackseakLength && number_test(crackseakLength)>0){
                            
                            $("#continue2").removeClass('ui-state-disabled');
                            $("#continue2").attr('disabled',false);
                           
                            
                        }else{
                            
                            $("#continue2").addClass('ui-state-disabled');
                            $("#continue2").attr('disabled',true);
                        }
                    }
                } else {
                    alert('error handling request');
                }
            }
        });
        if(savedData){
            var check = compareSavedValue(savedData,calculateData);
        }else{
            check =false; 
        }
        
        if(check){
            if(custom_price_total || saved_custom_price==0){
                
                $('.if_item_saved').show();
                $('.save_estimation').hide(); 
                unsave_cal=false; 
            }else{
                $('.if_item_saved').hide();
                $('.save_estimation').show();
                $('.item_total_edit_icon').show();
                unsave_cal=true;
            }      
        }else{
            $('.if_item_saved').hide();
            $('.save_estimation').show();
            $('.item_total_edit_icon').show();
            unsave_cal=true;
        }
        child_save_done =false;
    }


    /*******************************
     * Pavement Striping Calculator *
     ********************************/
    var stripingFields = "#stripingFeet, #stripingPailSize, #stripingPailColor, #stripingPailCost";
    $(stripingFields).live('change keyup', function () {
        unsave_cal=true;
        custom_price_total = false;  
        stripingPaintRender();
        
        overheadRate = cleanNumber($(this).closest('form').find('.cal_overhead').val());
        profitRate = cleanNumber($(this).closest('form').find('.cal_profit').val());
        console.log('check2211');
        updateItemPrices(overheadRate,profitRate);
    });
    var requestAuth;

    function stripingPaintRender() {
        var stripingFeet = $("#stripingFeet").val();
        stripingFeet = stripingFeet.replace(/,/g, '');
        overheadRate = cleanNumber($("#striping_form").closest('form').find('.cal_overhead').val());
        profitRate = cleanNumber($("#striping_form").closest('form').find('.cal_profit').val());
       
        var materialTotal = stripingFeet / $("#stripingPailColor").val();
//                $("#stripingMaterialTotal").html(materialTotal.toFixed(2));
        var totalQty = materialTotal / $("#stripingPailSize").val();
//                $("#stripingTotalQty").html(totalQty.toFixed(2));
        var materialTotalCost = totalQty * $("#stripingPailCost").val();
//                $("#stripingTotalMaterialCost").html(materialTotalCost.toFixed(2));
        var materialBaseCost = materialTotalCost / materialTotal;
//                $("#stripingMaterialBaseCost").html(materialBaseCost.toFixed(2));
        calculateData = $("#striping_form").closest('form').serializeArray();
       
        requestAuth = Math.floor((Math.random() * 1000) + 1);
        var request = $.ajax({
            url: "<?php echo site_url('ajax/ajaxCalculators') ?>",
            type: "POST",
            data: {
                "action": "calculator_striping",
                "length": $("#stripingFeet").val(),
                "pail_size": $("#stripingPailSize").val(),
                "color": $("#stripingPailColor").val(),
                "pail_price": item_price,
                "requestAuth": requestAuth
            },
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    if (data.requestAuth == requestAuth) {
                        item_quantity = number_test(data.totalMaterial);
                        console.log('check2210');
                        updateItemPrices(overheadRate,profitRate);
                        $("#stripingMaterialTotal").html(addCommas(number_test(data.totalMaterial)));
                        $("#stripingTotalQty").html(addCommas(number_test(data.totalQty)));
                        $("#stripingTotalMaterialCost").html(addCommas(number_test(data.cost)));
                        $("#stripingMaterialBaseCost").html(addCommas(number_test(data.baseCost)));
                        
                        var temp_total = item_quantity * item_price;
                        
                        taxRate = $('#striping_form').find('.cal_tax').val();
                        taxRate = taxRate.replace('%', '');
                        var temptaxPrice = ((temp_total * taxRate) / 100);
                        taxPrice = temptaxPrice;
                        $('#striping_form').find('.cal_tax_amount').text('$'+addCommas(number_test(temptaxPrice)));
                        var temp_total = parseFloat(temp_total) + parseFloat(temptaxPrice);
                        calTotalPrice = temp_total;
                        if(custom_price_total){
                            calTotalPrice = saved_custom_price;
                        }
                        
                        $(".striping_section").find('.cal_total_price').text(addCommas(number_test(calTotalPrice)));
                        if($(".if_child_parent_total").is(":visible")){ 
                            var temp_estimate_line_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
                            get_child_items_list(temp_estimate_line_id,false,true);
                        }
                        

                        
                        if(stripingFeet && stripingFeet>0){
                            
                            $("#continue2").removeClass('ui-state-disabled');
                            $("#continue2").attr('disabled',false);
                            
                            
                        }else{
                            
                            $("#continue2").addClass('ui-state-disabled');
                            $("#continue2").attr('disabled',true);
                        }
                    }
                } else {
                    alert('error handling request');
                }
            }
        });
        if(savedData){
            var check = compareSavedValue(savedData,calculateData);
        }else{
            check =false; 
        }
        
        if(check){
            if(custom_price_total || saved_custom_price==0){
                
                $('.if_item_saved').show();
                $('.save_estimation').hide(); 
                unsave_cal=false; 
            }else{
                $('.if_item_saved').hide();
                $('.save_estimation').show();
                $('.item_total_edit_icon').show();
                unsave_cal=true;
            }         
        }else{
            $('.if_item_saved').hide();
            $('.save_estimation').show();
            $('.item_total_edit_icon').show();
            unsave_cal=true;
        }
        child_save_done =false;
    }
    

    $(".currency_field").inputmask("decimal",
        {
            "radixPoint": ".",
            "groupSeparator":",",
            "digits":2,
            "prefix":"$",
            "autoGroup":true,
            "showMaskOnHover": false,
            "allowMinus": false,
            "showMaskOnFocus": false,
        });

        $(".currency_span").inputmask("decimal",
        {
            "radixPoint": ".",
            "groupSeparator":",",
            "digits":2,
            "prefix":"$",
            "autoGroup":true,
            "showMaskOnHover": false,
            "allowMinus": false,
            "showMaskOnFocus": false,
        });

    $(".percentFormat").inputmask("decimal",
        {
            "radixPoint": ".",
            "groupSeparator":",",
            "suffix":"%",
            "autoGroup":true,
            "digits": 2,
            "showMaskOnHover": false,
            "allowMinus": false,
            "showMaskOnFocus": false,
        }
    );

    $(".percentFormatN").inputmask("decimal",
        {
            "radixPoint": ".",
            "groupSeparator":",",
            "suffix":"%",
            "autoGroup":true,
            "digits": 2,
            "showMaskOnHover": false,
            "allowMinus": true,
            "showMaskOnFocus": false,
        }
    );

    $(".number_field").inputmask("decimal",
        {
            "radixPoint": ".",
            "groupSeparator":",",
            "digits":2,
            "allowMinus": false,
            "autoGroup":true,
        });
    function number_field_masking(){
        $(".number_field").inputmask("decimal",
        {
            "radixPoint": ".",
            "groupSeparator":",",
            "digits":2,
            "allowMinus": false,
            "autoGroup":true,
        });
    }

    $(".round_off_field").inputmask("decimal",
        {
            "radixPoint": ".",
            "digits":0,
            "groupSeparator":",",
            "allowMinus": false,
            "autoGroup":true,
        });
function round_off_masking(){
    $(".round_off_field").inputmask("decimal",
        {
            "radixPoint": ".",
            "digits":0,
            "groupSeparator":",",
            "allowMinus": false,
            "autoGroup":true,
        });
}
function currency_masking(){
    $(".currency_field").inputmask("decimal",
        {
            "radixPoint": ".",
            "groupSeparator":",",
            "digits":2,
            "prefix":"$",
            "autoGroup":true,
            "showMaskOnHover": false,
            "allowMinus": false,
            "showMaskOnFocus": false,
        });
}

    $(".percentFormat").change(function(){
        var currency = $(this).val();
        currency = currency.replace(/,/g, '');
        $(this).val(number_test(currency));

    });

    $(".percentFormatN").change(function(){
        var currency = $(this).val();
        currency = currency.replace(/,/g, '');
        $(this).val(number_test(currency));

    });

    function number_test(n)
    {
        //var result = (n - Math.floor(n)) !== 0;

        //if (result){
        return parseFloat(n).toFixed(2);
        //  }else{
        // return parseInt(n);
        //}


    }
    function number_test2(n)
    {
        var result = (n - Math.floor(n)) !== 0;

        if (result){
        return parseFloat(n).toFixed(2);
         }else{
        return parseInt(n);
        }


    }
    $(".currency_field").change(function(){
        var currency = $(this).val();
        currency = currency.replace('$', '');
        currency = currency.replace(/,/g, '');
        $(this).val(number_test(currency));
        unsaved = true;
    });

    $(".number_field").change(function(){
        // var currency = $(this).val();
        // currency = currency.replace(/,/g, '');
        // $(this).val(number_test(currency));
        // unsaved = true;
    });

    $('.deleteLineItem').click(function(e) {
           

        if(unsaved_row){
            swal(
                'You have an unsaved item',
                'Please save or clear item to continue'
            );

        }else{
            var lineItemId  = $(this).attr('data-estimate-line-id');

            $this =$(this);
            var unit_price = $this.closest('tr').find(".open_calculator").data('item-unit-price');
            var item_id = $this.closest('tr').find(".open_calculator").data('item-id');
            
            swal({
                title: "Are you sure?",
                text: "Item will be permanently deleted",
                showCancelButton: true,
                confirmButtonText: 'Delete Item',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
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
                    var est_items = [];
                    est_items.push(lineItemId)
                    $.ajax({
                        url: '/ajax/deleteEstimateLineItems',
                        type: "POST",
                        data: {
                            "lineItemIds": est_items,
                            "proposalServiceId": proposal_service_id,
                            'phase_id':phase_id,
                        },

                        success: function( data){
                            try{
                                data = JSON.parse(data);
                            } catch (e) {
                                swal("Error", "An error occurred Please try again");
                                return false;
                            }
                            if(data.estimate.completed==0){
                                $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                                temp_count = temp_count+1;

                                if(total_service == temp_count){
                                    $('.show_pending_est_msg').hide();
                                    $('.welcome_msg').show();
                                    $('.show_complete_est_msg').hide();
                                }else{
                                    var pending =total_service - temp_count;
                                    $('.show_pending_est_msg').text('You have '+temp_count+' additional services that you need to Estimate');
                                    $('.show_pending_est_msg').show();
                                    $('.welcome_msg').hide();
                                    $('.show_complete_est_msg').hide();
                                }

                            }else{
                            
                                $('#service_'+proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                                
                            }
                            if(data.estimate.child_has_updated_flag==0 ){
                                $('.service_child_has_updated_flag_'+proposal_service_id).hide();
                                $('#service_'+proposal_service_id+' .toggle').addClass('text-active-color').removeClass('text-active-color2');
                                $('#service_'+proposal_service_id+' .toggle').css('background-color','#aeaeae');
                            }
                            $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                            $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                            $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                            $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                            $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                            //set old value when cancel 
                                $('.old_total_val_save'+proposal_service_id).val(data.estimate.service_price);
                            // set old value
                            //save_service_estimate_total_price(data.totalPrice);
                            $this.closest('tr').find(".total-price").text('$0');
                            $this.closest('tr').find(".quantity").text('0');
                            //$this.closest('tr').find(".unit-price").val(unit_price);
                            //$this.closest('tr').find(".span_unit_price1").text('$'+addCommas(number_test(unit_price)));
                            $this.closest('tr').removeClass('has_item_value');
                            $this.hide();
                            calculate_unit_price();
                            get_service_item_list_by_phase_id();
                            get_proposal_breakdown();
                            //update_proposal_overhead_profit();
                            swal(
                                'Item Deleted',
                                ''
                            );
                            if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                            $('#estimateLineItemTable').DataTable().ajax.reload();
                            check_tr_has_class();
                            $('.item_delete_checkbox').attr('checked',false);
                            $('.item_delete_checkbox').trigger('change'); 
                            $.uniform.update();
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                            console.log( errorThrown );
                        }
                    })

                    // $.ajax({
                    //     url: '/ajax/deleteCalculatorValues/'+proposal_service_id+'/'+item_id,
                    //     type: 'get',

                    //     success: function( data){
                    //     },
                    //     error: function( jqXhr, textStatus, errorThrown ){
                    //         console.log( errorThrown );
                    //     }
                    // })

                    $('#items_'+item_id).find(".open_calculator").attr('data-estimate-line-id','');
                    $('#template_items_'+item_id).find(".open_calculator").attr('data-estimate-line-id','');
                    $this.closest('tr').find(".open_calculator").attr('data-estimate-line-id','');
                    $('#items_'+item_id).find(".deleteLineItem").attr('data-estimate-line-id','');
                    $('#template_items_'+item_id).find(".deleteLineItem").attr('data-estimate-line-id','');
                    revert_adjust_price();

                } else {
                    swal("Cancelled", "Your Estimation is safe :)", "error");
                }
            });
        }
    });

    $(".service_total_input").change(function(){
        var service_total = $(this).val();
        service_total = service_total.replace('$', '');
        service_total = service_total.replace(/,/g, '');
        var service_total_id = $(this).closest('span').attr('id');
        service_total_id =service_total_id.replace(new RegExp("^" + 'service_total_'), '');
        var estimate_total = $('#estimate_total_'+service_total_id+' input').val();
        if(estimate_total){
            estimate_total = estimate_total.replace('$', '');
            estimate_total = estimate_total.replace(/,/g, '');
            if(service_total == estimate_total){
                $('.apply_btn_'+service_total_id).hide();
                $('#estimate_total_'+service_total_id).closest('li').hide();
            }else{
                $('.apply_btn_'+service_total_id).show();
                $('#estimate_total_'+service_total_id).closest('li').show();
            }
        }

        //save_service_estimate_total_price(currency);

    });

    function check_tr_has_class(){
        $('.items_checkbox').hide();
        $('.category_child_flag').hide();
        $('.estimatingItemsTable').each(function(){
            var $table = $(this);
            var has_item_count = 0;
            var table_idd = $table.attr('id');
            table_idd =table_idd.replace(new RegExp("^" + 'itemsType'), '');
            var rows= $table.find('tr.has_item_value').length;
            var rows2= $table.find('tr.item_has_template').length;
            
            rows = rows-rows2;
            if(rows>1){
                $table.find('tr.has_item_value').each(function(row, tr){
                    //$(tr).find('.items_checkbox').show();
                });
            }
            $('#heading_span_'+table_idd).text(rows);
        });

        $('.cate_tabs').each(function (index, value) {
            var cat_tab_id = $(this).attr('href');
            var temp_ccount = 0;
            var tab_total = 0;
            var cat_child_flag =false;
            $(cat_tab_id+' .accordionContainer h3').each(function (index, value) {

                var type_id = $(this).data('type-id');
                
               
                 if($('.table_child_has_updated_flag_'+type_id).is(":visible")){
                    cat_child_flag=true;
                 }
                temp_ccount = temp_ccount + parseInt($('#heading_span_'+type_id).text());
               
                var cat_ser_id = cat_tab_id.replace(new RegExp("^" + '#categoryTab'), '');
                $('.cat_service_count'+cat_ser_id).text(temp_ccount);

              var acc_total = $('.table_total_'+type_id).text();
             if(acc_total){
                //acc_total = acc_total.replace('Total : ', '');
                acc_total = cleanNumber(acc_total);
                if(acc_total >0){
                    tab_total = parseFloat(tab_total) + parseFloat(acc_total);
                }
                
             }
                $('.cat_service_count'+cat_ser_id).attr('title','$'+addCommas(number_test(tab_total)));
                $('.cat_service_count'+cat_ser_id).attr('data-val',number_test(tab_total));
            });
            
            if(cat_child_flag){
                var cat_ser_id2 = cat_tab_id.replace(new RegExp("^" + '#categoryTab'), '');
                $('.category_child_has_updated_flag_'+cat_ser_id2).show();
            }
        });
        $(".tiptip").tipTip({ defaultPosition: "top",delay: 0});

        check_all_default_saved_template_items();

    }
    
    function check_template_tr_has_class(){
        $('.template_items_checkbox').hide();

        // $('.templateItemsTable').each(function(){
        //                         var $table = $(this);
        //                         var has_item_count = 0;
        //                         var table_idd = $table.attr('id');
        //                         table_idd =table_idd.replace(new RegExp("^" + 'itemsType'), '');
        //                         var rows= $table.find('tr.has_item_value').length;
        //                         if(rows>1){
        //                             $table.find('tr.has_item_value').each(function(row, tr){
        //                                 $(tr).find('.template_items_checkbox').show();
        //                             });
        //                         }
        //                         //$('#heading_span_'+table_idd).text(rows);
        //                     });

        // $('.cate_tabs').each(function (index, value) {
        //     var cat_tab_id = $(this).attr('href');
        //     var temp_ccount = 0;
        //     $(cat_tab_id+' .accordionContainer h3').each(function (index, value) {
        //             var type_id = $(this).data('type-id');
        //             temp_ccount = temp_ccount + parseInt($('#heading_span_'+type_id).text());

        //             var cat_ser_id = cat_tab_id.replace(new RegExp("^" + '#categoryTab'), '');
        //     $('.cat_service_count'+cat_ser_id).text(temp_ccount);
        //     });

        // });
    }
    $(document).on("change",".item_delete_checkbox",function() {

        var temp_item_line_id = $(this).closest('tr').prop('id')
        if(unsaved_row && temp_item_line_id != item_line_id){
            $('.items_checkbox div span').removeClass('checked');
            $('.item_delete_checkbox').attr('checked',false);
            swal(
                'You have an unsaved item',
                'Please save or clear item to continue'
            );

        }else{
            var delete_checkbox_name = $(this).attr('name');

            var items = [];
            $.each($("input[name='"+delete_checkbox_name+"']:checked"), function(){
                items.push($(this).val());
            });
            var delete_checkbox_id = $(this).attr('id');
            delete_checkbox_name =delete_checkbox_name.replace(new RegExp("^" + 'checkbox_name_'), '');
            if(items.length > 0){
                $('#typeHeading'+delete_checkbox_name).find('.delete_estimate_items').css('display','');
            }else{
                $('#typeHeading'+delete_checkbox_name).find('.delete_estimate_items').hide();
            }
        }
    });
    $(document).on("click",".template_item_delete_checkbox",function() {

        var temp_item_line_id = $(this).closest('tr').prop('id')
        if(unsaved_row && temp_item_line_id != item_line_id){
            $('.template_items_checkbox div span').removeClass('checked');
            $('.template_item_delete_checkbox').attr('checked',false);
            swal(
                'You have an unsaved item',
                'Please save or clear item to continue'
            );

        }else{
            var delete_checkbox_name = $(this).attr('name');

            var items = [];
            $.each($("input[name='"+delete_checkbox_name+"']:checked"), function(){
                items.push($(this).val());
            });
            var delete_checkbox_id = $(this).attr('id');
            delete_checkbox_name =delete_checkbox_name.replace(new RegExp("^" + 'template_checkbox_name_'), '');
            var temp_item_table_id = $(this).closest('table').prop('id')
            
            temp_item_table_id =temp_item_table_id.replace(new RegExp("^" + 'template_itemsType'), '');
            if(items.length > 0){
                
                $('#templateHeading'+temp_item_table_id).find('.edit_estimate_items').css('display','');
                $('#templateHeading'+temp_item_table_id).find('.delete_estimate_items').css('display','');
                $('#templateHeading'+temp_item_table_id).find('.edit_estimate_items_price').hide();
                $('#templateHeading'+temp_item_table_id).find('.edit_template_total_price').hide();
                $('#templateHeading'+temp_item_table_id).find('.delete_template_items').hide();
            }else{
                $('#templateHeading'+temp_item_table_id).find('.delete_estimate_items').hide();
                $('#templateHeading'+temp_item_table_id).find('.edit_estimate_items').hide();
                $('#templateHeading'+temp_item_table_id).find('.edit_estimate_items_price').css('display','');
                $('#templateHeading'+temp_item_table_id).find('.edit_template_total_price').css('display','');
                $('#templateHeading'+temp_item_table_id).find('.delete_template_items').css('display','');
                
            }
        }
    });
    function delete_estimated_items(e,element){

        e.stopPropagation();
        var btn_id = $(element).attr('id');

        var checkbox_name = 'checkbox_name_'+btn_id.replace(new RegExp("^" + 'delete_btn_'), '');
        var items = [];
        var est_items = [];
        swal({
            title: "Are you sure?",
            text: "Items will be permanently deleted",
            showCancelButton: true,
            confirmButtonText: 'Delete Items',
            cancelButtonText: "Cancel",
            dangerMode: false
        }).then(function(isConfirm) {
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
                
                $.each($("input[name='"+checkbox_name+"']:checked"), function(){
                    var checkboxid  = $(this).attr('id');
                    checkboxid = checkboxid.replace(new RegExp("^" + 'items_checkbox_'), '');
                    est_items.push($(this).val());
                    items.push(checkboxid);
                });

                $.ajax({
                    url: '/ajax/deleteEstimateLineItems',
                    type: "POST",
                    data: {
                        "lineItemIds": est_items,
                        "proposalServiceId": proposal_service_id,
                        'phase_id':phase_id,
                    },
                    dataType: "json",

                    success: function(data){
                        $(element).hide();
                        
                        $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                        $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                        
                        $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                        $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                        $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                        
                        if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                        var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
                        if(data.estimate.completed==0){
                        $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                        temp_count = temp_count+1;

                        if(total_service == temp_count){
                            $('.show_pending_est_msg').hide();
                            $('.welcome_msg').show();
                            $('.show_complete_est_msg').hide();
                        }else{
                            $('.show_pending_est_msg').text('You have '+temp_count+' additional services that you need to Estimate');
                            $('.show_pending_est_msg').show();
                            $('.welcome_msg').hide();
                            $('.show_complete_est_msg').hide();
                        }

                    }else{
                       
                        $('#service_'+proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                        
                    }
                        if(data.estimate.child_has_updated_flag==0 ){
                            $('.service_child_has_updated_flag_'+proposal_service_id).hide();
                            $('#service_'+proposal_service_id+' .toggle').addClass('text-active-color').removeClass('text-active-color2');
                            $('#service_'+proposal_service_id+' .toggle').css('background-color','#aeaeae');
                        }
                        check_tr_has_class();
                        //get_service_item_list();
                        get_service_item_list_by_phase_id();
                        get_proposal_breakdown();
                        
                        swal(
                            'Items Deleted',
                            ''
                        );

                        for($i=0;$i<items.length;$i++){
                            $('#items_'+items[$i]).find('.deleteLineItem').data('estimate-line-id','');
                            $('#items_'+items[$i]).find('.open_calculator').data('estimate-line-id','');

                            var unit_price = $('#items_'+items[$i]).find(".open_calculator").data('item-unit-price');

                            var item_id = items[$i];
                            $('#items_'+item_id).find(".total-price").text('$0');
                            $('#items_'+item_id).find(".quantity").text('0');
                            //$('#items_'+item_id).find(".unit-price").val(unit_price);
                            //$('#items_'+item_id).find(".span_unit_price1").text('$'+addCommas(number_test(unit_price)));
                            $('#items_'+item_id).removeClass('has_item_value');
                            //$('#items_'+item_id).find('.deleteLineItem').hide();
                            //$('#items_'+item_id).find('.items_checkbox').hide();
                            $('#items_'+item_id).find('.items_checkbox div span').removeClass('checked');
                            $('#items_checkbox_'+item_id).attr('checked',false);

                        }

                    
                    $('#estimateLineItemTable').DataTable().ajax.reload();
                    calculate_unit_price();
                    revert_adjust_price();
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        swal("Error", "An error occurred Please try again");
                        console.log( errorThrown );
                    }
                })
                
            } else {
                swal("Cancelled", "Your Estimation is safe :)", "error");
            }
        });
    }
    
    function edit_templates_items_value(e,element){

        e.stopPropagation();
        var btn_id = $(element).attr('id');
        var template_id =  $(element).closest('h3').attr('data-template-id');
        var template_fixed =  $(element).closest('h3').attr('data-template-fixed');
        // if(template_fixed==1){
        //     $('.if_not_fixed_template').hide();
        // }else{
        //     $('.if_not_fixed_template').show(); 
        // }
        $('.edit_template_value_number_of_person').val('');
        $('.edit_template_value_time_type_input').val('');
        $('.edit_template_value_hour_per_day').val('');
        $('.check_edit_tamplate_days_value').prop('checked', false);
        $('.check_edit_tamplate_quantity_value').prop('checked', false);
        $('.check_edit_tamplate_hpd_value').prop('checked', false);
        // $('.edit_template_value_number_of_person').prop('disabled', false);
        // $('.edit_template_value_time_type_input').prop('disabled', false);
        // $('.edit_template_value_hour_per_day').prop('disabled', false);
        $('.edit_template_value_number_of_person,.edit_template_value_time_type_input,.edit_template_value_hour_per_day').hide();
        
        var checkbox_name = 'template_checkbox_name_'+template_id;
        $('.editTemplateItemsCount').text($("input[name='"+checkbox_name+"']:checked").length);
        $.uniform.update();
        
        $('.edit_template_value_number_of_person,.edit_template_value_time_type_input,.edit_template_value_hour_per_day').removeClass('error');
        $('.if_error_show_msg').hide();
        
        $("#edit_template_item_values_model").dialog('open');
        $("#edit_template_value_template_id").val(template_id);
        $("#edit_template_values_submit").addClass('ui-state-disabled');
        $("#edit_template_values_submit").attr('disabled',true);
        
    }
    

    function edit_template_total_price(e,element){

        e.stopPropagation();
        var btn_id = $(element).attr('id');
        var template_id =  $(element).closest('h3').attr('data-template-id');
        var template_total_price = cleanNumber($(element).closest('h3').find('.template_table_total_'+template_id).text());
        
         $('.edit_standard_template_price').val(template_total_price);
         $('#old_edit_template_price').val(template_total_price);

         $('.edit_standard_template_price').removeClass('error');
         $('.if_error_show_msg').hide();

         $("#edit_standard_template_price_model").dialog('open');
         $("#edit_standard_template_price_template_id").val(template_id);
    }

    $(document).on("focusout blur keyup",".edit_standard_template_price",function(e) {
        if($(this).val()){
            $(this).removeClass('error');
        }else{
          
            $(this).addClass('error');
         
        }
        if($('.error').length>0){
            $('.if_error_show_msg').show();
            $(".save_edit_standard_template_price").addClass('ui-state-disabled');
            $(".save_edit_standard_template_price").attr('disabled',true);
            
        }else{
            $('.if_error_show_msg').hide();
            $(".save_edit_standard_template_price").removeClass('ui-state-disabled');
            $(".save_edit_standard_template_price").attr('disabled',false);
        }
    });

    $(document).on("focusout blur keyup",".edit_template_price",function(e) {
        if($(this).val()){
            $(this).removeClass('error');
        }else{
          
            $(this).addClass('error');
         
        }
        if($('.error').length>0){
            $('.if_error_show_msg').show();
            $(".save_edit_template_price").addClass('ui-state-disabled');
            $(".save_edit_template_price").attr('disabled',true);
        }else{
            $('.if_error_show_msg').hide();
            $(".save_edit_template_price").removeClass('ui-state-disabled');
            $(".save_edit_template_price").attr('disabled',false);
        }
    });
    

    function edit_template_price(e,element){

    e.stopPropagation();
    var btn_id = $(element).attr('id');
    var template_id =  $(element).closest('h3').attr('data-template-id');
    var template_fixed =  $(element).closest('h3').attr('data-template-fixed');
    var template_type =  $(element).closest('h3').attr('data-template-type');
    var template_rate =  $(element).closest('h3').attr('data-template-rate');
    if(template_type==1){
        $('.edit_fixed_template_price_type').text('Day');
    }else{
        $('.edit_fixed_template_price_type').text('Hour');
    }
    $('.edit_template_price').val(template_rate);
   

    $('.edit_template_price').removeClass('error');
    $('.if_error_show_msg').hide();

    $("#edit_template_price_model").dialog('open');
    $("#edit_template_price_template_id").val(template_id);
}
    
    $(document).on("click",".save_fixed_template_values",function(){
        
        var fixed_template_value_time_type_input = $('.fixed_template_value_time_type_input').val();
        var fixed_template_value_hour_per_day = $('.fixed_template_value_hour_per_day').val();
        cal_trucking_pm
        if(fixed_template_value_hour_per_day=='' || fixed_template_value_hour_per_day<1 || fixed_template_value_time_type_input =='' || fixed_template_value_time_type_input<1){
            $('.fixed_template_value_hour_per_day').trigger('keyup');
            $('.fixed_template_value_time_type_input').trigger('keyup');
            
            return false
            
        }
  
        swal({
            title: 'Saving..',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timer: 2000,
            onOpen: () => {
            swal.showLoading();
            }
        });
        
        var template_id =$("#fixed_template_value_template_id").val();
        var empty_template = $("#template_itemsType"+template_id).attr('data-empty-template');
        var proposal_Id = <?php echo $proposal->getProposalId(); ?>;
         
            $.ajax({
                    url: '/ajax/saveFixedTemplatesGroupItems',
                    
                    type: "POST",
                    data: {
                        "proposal_Id": proposal_Id,
                        "proposalServiceId": proposal_service_id,
                        'phase_id':phase_id,
                        'template_id':template_id,
                        'fixed_template_value_time_type_input':fixed_template_value_time_type_input,
                        'fixed_template_value_hour_per_day':fixed_template_value_hour_per_day,
                        
                    },
                    dataType: "json",

                    success: function( data){


                        var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
                        if(empty_template){
                            swal(' Assembly Created');
                        }else{
                            swal(data.item_count+' Items Created');
                        }
                        
                        check_tr_has_class();
                        get_service_item_list_by_phase_id();
                        get_proposal_breakdown();
                        //update_proposal_overhead_profit();
                        $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                        $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                        
                        $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                        $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                        $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                        if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                       
                       
                        $("#fixed_template_item_values_model").dialog('close');
                        var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
                
                if(data.estimate.completed==0){
                    $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                }else{
                    $('#service_'+proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                    if(check_est_completed){
                        $('.item_summary_btn').show();
                        temp_count = temp_count-1;
                        if(temp_count==0){
                            $('.show_pending_est_msg').hide();
                            $('.welcome_msg').hide();
                            $('.show_complete_est_msg').show();
                        }else{

                            $('.show_pending_est_msg').text('You have '+temp_count+' additional services that you need to Estimate');
                            $('.show_pending_est_msg').show();
                            $('.welcome_msg').hide();
                            $('.show_complete_est_msg').hide();
                        }
                    }
                }
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })

        
        
    })

    $(document).on("click",".save_edit_template_values",function(){
        
        swal({
            title: 'Saving..',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timer: 2000,
            onOpen: () => {
            swal.showLoading();
            }
        });
        
        var edit_template_value_number_of_person = $('.edit_template_value_number_of_person').val();
        var edit_template_value_time_type_input = $('.edit_template_value_time_type_input').val();
        var edit_template_value_hour_per_day = $('.edit_template_value_hour_per_day').val();
        var check_edit_tamplate_days_value = $('.check_edit_tamplate_days_value').is(":checked") ? 1 : 0;
        var check_edit_tamplate_quantity_value = $('.check_edit_tamplate_quantity_value').is(":checked") ? 1 : 0;
        var check_edit_tamplate_hpd_value = $('.check_edit_tamplate_hpd_value').is(":checked") ? 1 : 0;
        var form_submit =false;
        var fixed_form_submit =false;
        if(check_edit_tamplate_days_value){
            if(edit_template_value_time_type_input && edit_template_value_time_type_input >0){
                form_submit = true;
            }else{
                form_submit = false;
            }
        }else if(check_edit_tamplate_quantity_value){
            if(edit_template_value_number_of_person && edit_template_value_number_of_person >0){
                form_submit = true;
                fixed_form_submit =true;
            }else{
                form_submit = false;
            }
        }else if(check_edit_tamplate_hpd_value){
            if(edit_template_value_hour_per_day && edit_template_value_hour_per_day >0){
                form_submit = true;
            }else{
                form_submit = false;
            }
        }

        var template_id =$("#edit_template_value_template_id").val();
        if($('#templateHeading'+template_id).data('template-fixed')==1){
            if(form_submit){
                var checkbox_name = 'template_checkbox_name_'+template_id;
                var items = [];
                var est_items = [];
                $.each($("input[name='"+checkbox_name+"']:checked"), function(){
                            var checkboxid  = $(this).attr('id');
                            checkboxid = checkboxid.replace(new RegExp("^" + 'template_items_checkbox_'), '');
                            est_items.push($(this).val());
                            items.push(checkboxid);
                        });
            


            $.ajax({
                    url: '/ajax/updateFixedTemplatesGroupItems',
                    type: "POST",
                    data: {
                        "lineItemIds": est_items,
                        "Items": items,
                        "proposalServiceId": proposal_service_id,
                        "template_id": template_id,
                        'phase_id':phase_id,
                        'edit_template_value_number_of_person':edit_template_value_number_of_person,
                        'edit_template_value_time_type_input':edit_template_value_time_type_input,
                        'edit_template_value_hour_per_day':edit_template_value_hour_per_day,
                        'check_edit_tamplate_days_value':check_edit_tamplate_days_value,
                        'check_edit_tamplate_quantity_value':check_edit_tamplate_quantity_value,
                        'check_edit_tamplate_hpd_value':check_edit_tamplate_hpd_value,

                    },
                    dataType: "json",

                    success: function( data){

                        console.log(data.estimate.service_price);
                        $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                        $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                       
                        check_tr_has_class();
                        //get_service_item_list();
                        get_service_item_list_by_phase_id();
                        get_proposal_breakdown();
                        //update_proposal_overhead_profit();
                        $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                        $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                        
                        $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                        $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                        $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                        if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                        
                        swal(
                            'Items Updated',
                            ''
                        );
                        $('.template_item_delete_checkbox').prop('checked', false);
                        $('.master_template_items_checkbox').prop('checked', false);
                        $('#templateHeading'+template_id).find('.delete_estimate_items').hide();
                        $('#templateHeading'+template_id).find('.edit_estimate_items').hide();
                        $('#templateHeading'+template_id).find('.edit_estimate_items_price').css('display','');
                        $('#templateHeading'+template_id).find('.edit_template_total_price').css('display','');
                        $('#templateHeading'+template_id).find('.delete_template_items').css('display','');
                        
                        $("#edit_template_item_values_model").dialog('close');
                        $.uniform.update();
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })
            }else{
                return false;
            }
        }else if(form_submit){
           
            var checkbox_name = 'template_checkbox_name_'+template_id;
            var items = [];
            var est_items = [];
        $.each($("input[name='"+checkbox_name+"']:checked"), function(){
                    var checkboxid  = $(this).attr('id');
                    checkboxid = checkboxid.replace(new RegExp("^" + 'template_items_checkbox_'), '');
                    est_items.push($(this).val());
                    items.push(checkboxid);
                });
            


            $.ajax({
                    url: '/ajax/saveTemplatesGroupItems',
                    type: "POST",
                    data: {
                        "lineItemIds": est_items,
                        "Items": items,
                        "proposalServiceId": proposal_service_id,
                        'phase_id':phase_id,
                        'edit_template_value_number_of_person':edit_template_value_number_of_person,
                        'edit_template_value_time_type_input':edit_template_value_time_type_input,
                        'edit_template_value_hour_per_day':edit_template_value_hour_per_day,
                        'check_edit_tamplate_days_value':check_edit_tamplate_days_value,
                        'check_edit_tamplate_quantity_value':check_edit_tamplate_quantity_value,
                        'check_edit_tamplate_hpd_value':check_edit_tamplate_hpd_value,

                    },
                    dataType: "json",

                    success: function( data){

                        console.log(data.estimate.service_price);
                        $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                        $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                       
                        check_tr_has_class();
                        //get_service_item_list();
                        get_service_item_list_by_phase_id();
                        get_proposal_breakdown();
                        //update_proposal_overhead_profit();
                        $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                        $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                        
                        $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                        $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                        $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                        if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                        
                        
                        swal(
                            'Items Updated',
                            ''
                        );
                        $('.template_item_delete_checkbox').prop('checked', false);
                        $('.master_template_items_checkbox').prop('checked', false);
                        $('#templateHeading'+template_id).find('.delete_estimate_items').hide();
                        $('#templateHeading'+template_id).find('.edit_estimate_items').hide();
                        $('#templateHeading'+template_id).find('.edit_estimate_items_price').css('display','');
                        $('#templateHeading'+template_id).find('.edit_template_total_price').css('display','');
                        $('#templateHeading'+template_id).find('.delete_template_items').css('display','');
                        $("#edit_template_item_values_model").dialog('close');
                        $.uniform.update();
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })

        }else{
            return false
        }
        
    })

    function delete_templates_items(e,element){
        
        e.stopPropagation();
        var btn_id = $(element).attr('id');
        var template_id =  $(element).closest('h3').attr('data-template-id');

        var checkbox_name = 'template_checkbox_name_'+btn_id.replace(new RegExp("^" + 'delete_btn_'), '');
        var items = [];
        var est_items = [];
        swal({
            title: "Are you sure?",
            text: "Items will be permanently deleted",
            showCancelButton: true,
            confirmButtonText: 'Delete Items',
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function(isConfirm) {
            if (isConfirm) {
                swal({
                    title: 'Deleting..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                    swal.showLoading();
                    }
                });
                $(element).hide();
                $('.edit_estimate_items').hide();
                
                $.each($("input[name='"+checkbox_name+"']:checked"), function(){
                    var checkboxid  = $(this).attr('id');
                    checkboxid = checkboxid.replace(new RegExp("^" + 'template_items_checkbox_'), '');
                    est_items.push($(this).val());
                    $(this).prop('checked',false);
                    items.push(checkboxid);
                });
                $.uniform.update();
                $.ajax({
                    url: '/ajax/deleteEstimateLineItems',
                    type: "POST",
                    data: {
                        "lineItemIds": est_items,
                        "proposalServiceId": proposal_service_id,
                        'phase_id':phase_id,
                        'template_id':template_id,
                    },
                    dataType: "json",

                    success: function( data){
                        
                        $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                        $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                       
                            $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                            $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                            $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                            if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                       
                       
                        var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
                        if(data.estimate.completed==0){
                        $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                        temp_count = temp_count+1;

                        if(total_service == temp_count){
                            $('.show_pending_est_msg').hide();
                            $('.welcome_msg').show();
                            $('.show_complete_est_msg').hide();
                        }else{
                           
                            $('.show_pending_est_msg').text('You have '+temp_count+' additional services that you need to Estimate');
                            $('.show_pending_est_msg').show();
                            $('.welcome_msg').hide();
                            $('.show_complete_est_msg').hide();
                        }

                    }else{
                       
                        $('#service_'+proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                        
                    }
                        if(data.estimate.child_has_updated_flag==0 ){
                            $('.service_child_has_updated_flag_'+proposal_service_id).hide();
                            $('#service_'+proposal_service_id+' .toggle').addClass('text-active-color').removeClass('text-active-color2');
                            $('#service_'+proposal_service_id+' .toggle').css('background-color','#aeaeae');
                        }
                        check_tr_has_class();
                        //get_service_item_list();
                        get_service_item_list_by_phase_id();
                        get_proposal_breakdown();
                       // update_proposal_overhead_profit();

                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })
                check_template_tr_has_class();
                for($i=0;$i<items.length;$i++){
                    $('#template_items_'+template_id+'_'+items[$i]).find('.deleteLineItem').attr('data-estimate-line-id','');
                    $('#template_items_'+template_id+'_'+items[$i]).find('.open_calculator').attr('data-estimate-line-id','');

                    var unit_price = $('#template_items_'+template_id+'_'+items[$i]).find(".open_calculator").data('item-unit-price');

                    var item_id = items[$i];
                    $('#template_items_'+template_id+'_'+item_id).find(".total-price").text('$0');
                    $('#template_items_'+template_id+'_'+item_id).find(".quantity").text('0');
                    $('#template_items_'+template_id+'_'+item_id).find(".unit-price").val(unit_price);
                    $('#template_items_'+template_id+'_'+item_id).find(".span_unit_price1").text('$'+addCommas(number_test(unit_price)));
                    $('#template_items_'+template_id+'_'+item_id).removeClass('has_item_value');
                    //$('#items_'+item_id).find('.deleteLineItem').hide();
                    //$('#items_'+item_id).find('.items_checkbox').hide();
                    $('#template_items_'+template_id+'_'+item_id).find('.template_items_checkbox div span').removeClass('checked');
                    
                    $('#templateHeading'+template_id).find('.fixed_template_rate').text(addCommas(Number($('#templateHeading'+template_id).attr('data-old-template-rate'))));
                    $('#templateHeading'+template_id).attr('data-template-rate',$('#templateHeading'+template_id).attr('data-old-template-rate'));
                    $('#template_value_edit'+template_id).attr('data-template-rate',$('#templateHeading'+template_id).attr('data-old-template-rate'));

                    $('#template_itemsType'+template_id).find('.master_template_items_checkbox').attr('checked',false);
                    $('#template_items_checkbox_'+item_id).attr('checked',false);

                }

                swal(
                    'Items Deleted',
                    ''
                );
                
               
               
               
                $.uniform.update();

                $('#estimateLineItemTable').DataTable().ajax.reload();
                //check_tr_has_class();
                revert_adjust_price();
            } else {
                swal("Cancelled", "Your Estimation is safe :)", "error");
            }
        });
    }


    function delete_template_all_items(e,element){
        
        e.stopPropagation();
        var btn_id = $(element).attr('id');
        var template_id =  $(element).closest('h3').attr('data-template-id');

        var checkbox_name = 'template_checkbox_name_'+btn_id.replace(new RegExp("^" + 'delete_all_items_btn_'), '');
        var items = [];
        var est_items = [];
        swal({
            title: "Are you sure?",
            text: "Items will be permanently deleted",
            showCancelButton: true,
            confirmButtonText: 'Delete Items',
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function(isConfirm) {
            if (isConfirm) {
                swal({
                    title: 'Deleting..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                    swal.showLoading();
                    }
                });
                $(element).hide();
                $('.edit_estimate_items').hide();
                $.each($("input[name='"+checkbox_name+"']"), function(){
                    var checkboxid  = $(this).attr('id');
                    checkboxid = checkboxid.replace(new RegExp("^" + 'template_items_checkbox_'), '');
                    est_items.push($(this).val());
                    $(this).prop('checked',false);
                    items.push(checkboxid);
                });
                
                $.uniform.update();
                $.ajax({
                    url: '/ajax/deleteTemplateEstimateLineItems',
                    type: "POST",
                    data: {
                        "lineItemIds": est_items,
                        "proposalServiceId": proposal_service_id,
                        'phase_id':phase_id,
                        'template_id':template_id,
                    },
                    dataType: "json",

                    success: function( data){
                        
                        $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                        $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                       
                            $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                            $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                            $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                        
                            if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                        var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
                        if(data.estimate.completed==0){
                        $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                        temp_count = temp_count+1;

                        if(total_service == temp_count){
                            $('.show_pending_est_msg').hide();
                            $('.welcome_msg').show();
                            $('.show_complete_est_msg').hide();
                        }else{
                           
                            $('.show_pending_est_msg').text('You have '+temp_count+' additional services that you need to Estimate');
                            $('.show_pending_est_msg').show();
                            $('.welcome_msg').hide();
                            $('.show_complete_est_msg').hide();
                        }

                    }else{
                       
                        $('#service_'+proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                        
                    }
                        if(data.estimate.child_has_updated_flag==0 ){
                            $('.service_child_has_updated_flag_'+proposal_service_id).hide();
                            $('#service_'+proposal_service_id+' .toggle').addClass('text-active-color').removeClass('text-active-color2');
                            $('#service_'+proposal_service_id+' .toggle').css('background-color','#aeaeae');
                        }
                        check_tr_has_class();
                        //get_service_item_list();
                        get_service_item_list_by_phase_id();
                        get_proposal_breakdown();
                       // update_proposal_overhead_profit();

                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })
                check_template_tr_has_class();
                for($i=0;$i<items.length;$i++){
                    $('#template_items_'+template_id+'_'+items[$i]).find('.deleteLineItem').attr('data-estimate-line-id','');
                    $('#template_items_'+template_id+'_'+items[$i]).find('.open_calculator').attr('data-estimate-line-id','');

                    var unit_price = $('#template_items_'+template_id+'_'+items[$i]).find(".open_calculator").data('item-unit-price');

                    var item_id = items[$i];
                    $('#template_items_'+template_id+'_'+item_id).find(".total-price").text('$0');
                    $('#template_items_'+template_id+'_'+item_id).find(".quantity").text('0');
                    $('#template_items_'+template_id+'_'+item_id).find(".unit-price").val(unit_price);
                    $('#template_items_'+template_id+'_'+item_id).find(".span_unit_price1").text('$'+addCommas(number_test(unit_price)));
                    $('#template_items_'+template_id+'_'+item_id).removeClass('has_item_value');
                    //$('#items_'+item_id).find('.deleteLineItem').hide();
                    //$('#items_'+item_id).find('.items_checkbox').hide();
                    $('#template_items_'+template_id+'_'+item_id).find('.template_items_checkbox div span').removeClass('checked');
                    
                    $('#templateHeading'+template_id).find('.fixed_template_rate').text(addCommas(Number($('#templateHeading'+template_id).attr('data-old-template-rate'))));
                    $('#templateHeading'+template_id).attr('data-template-rate',$('#templateHeading'+template_id).attr('data-old-template-rate'));
                    $('#template_value_edit'+template_id).attr('data-template-rate',$('#templateHeading'+template_id).attr('data-old-template-rate'));

                    $('#template_itemsType'+template_id).find('.master_template_items_checkbox').attr('checked',false);
                    $('#template_items_checkbox_'+item_id).attr('checked',false);

                }

                swal(
                    'Items Deleted',
                    ''
                );
                
               
               
               
                $.uniform.update();

                $('#estimateLineItemTable').DataTable().ajax.reload();
                //check_tr_has_class();
                revert_adjust_price();
            } else {
                swal("Cancelled", "Your Estimation is safe :)", "error");
            }
        });
    }


function next_fixed_templates_items(e,element){
    e.stopPropagation();
    $('.error').removeClass('error');
    $('.if_error_show_msg').hide();
    var template_id = $(element).closest('h3').attr('data-template-id');
    var template_name= $(element).closest('h3').attr('data-template-name');
    var template_rate= $(element).closest('h3').attr('data-template-rate');
    var template_type= ($(element).closest('h3').attr('data-template-type')==1)?' / Day':' / Hour';
    var t_days =$('#service_'+proposal_service_id).find('.phase_max_days').text();
    
    if(t_days>0){
        t_days =t_days
    }else{
        t_days=1;
    }
    $("#fixed_template_value_template_id").val(template_id);
    $(".fixed_template_value_time_type_input").val(t_days);
    $(".fixed_template_value_hour_per_day").val(8);
    $('.fixed_template_model_title').text(template_name+' - $'+addCommas(Number(template_rate))+template_type);

    $("#fixed_template_item_values_model").dialog('option','title','Add values');
    
    $("#fixed_template_item_values_model").dialog('open');
}


function edit_fixed_templates_values(e,element){
    
    $('.error').removeClass('error');
    $('.if_error_show_msg').hide();
    var template_id = $(element).attr('data-template-id');
    var template_name= $(element).attr('data-template-name');
    var template_rate= $(element).attr('data-template-rate');
    var template_type= ($(element).attr('data-template-type')==1)?' / Day':' / Hour';
    var t_days =$('#service_'+proposal_service_id).find('.phase_max_days').text();
    
    if(t_days>0){
        t_days =t_days;
    }else{
        t_days=1;
    }
    var saved_days = $(element).closest('.templateInfoMsg').find('#fixed_template_total_day_'+template_id).text();
    var saved_hpd = $(element).closest('.templateInfoMsg').find('#fixed_template_total_hpd_'+template_id).text();
    if(saved_days){
        t_days =saved_days
    }
    $("#fixed_template_value_template_id").val(template_id);
    $(".fixed_template_value_time_type_input").val(t_days);
    $(".fixed_template_value_hour_per_day").val((saved_hpd)?saved_hpd:8);
    $('.fixed_template_model_title').text(template_name+' - $'+addCommas(Number(template_rate))+template_type);

    $("#fixed_template_item_values_model").dialog('option','title','Edit values');
    
    $("#fixed_template_item_values_model").dialog('open');
}


    function next_templates_items(e,element){

        e.stopPropagation();
        var template_id = $(element).closest('h3').attr('data-template-id');
        var proposal_Id = <?php echo $proposal->getProposalId(); ?>;
        var empty_template = $("#template_itemsType"+template_id).attr('data-empty-template');
        
        swal({
            title: 'Saving..',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timer: 2000,
            onOpen: () => {
            swal.showLoading();
            }
        });
        
        $.ajax({
                    url: '/ajax/save_template_items',
                    type: "POST",
                    data: {
                        "templateId": template_id,
                        "proposalServiceId": proposal_service_id,
                        'PhaseId':phase_id,
                        'proposalId':proposal_Id,
                    },
                    dataType: "json",

                    success: function( data){
                        var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
                        if(empty_template){
                            swal(' Assembly Created');
                        }else{
                            swal(data.item_count+' Items Created');
                        }
                        check_tr_has_class();
                        get_service_item_list_by_phase_id();
                        get_proposal_breakdown();
                        //update_proposal_overhead_profit();
                        $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                        $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                        
                        $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                        $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                        if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                        
                        $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                        var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
                
                if(data.estimate.completed==0){
                    $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                }else{
                    $('#service_'+proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                    if(check_est_completed){
                        $('.item_summary_btn').show();
                        temp_count = temp_count-1;
                        if(temp_count==0){
                            $('.show_pending_est_msg').hide();
                            $('.welcome_msg').hide();
                            $('.show_complete_est_msg').show();
                        }else{

                            $('.show_pending_est_msg').text('You have '+temp_count+' additional services that you need to Estimate');
                            $('.show_pending_est_msg').show();
                            $('.welcome_msg').hide();
                            $('.show_complete_est_msg').hide();
                        }
                    }
                }
                    
                    }
        });
        
    };

    $(document).on("change",".unit-price,.quantity,.total-price",function() {
        var unit_price = $(this).closest('tr').find('.unit-price').val();
        var quantity = $(this).closest('tr').find('.quantity').text();
        unit_price = unit_price.replace('$', '');
        unit_price = unit_price.replace(/,/g, '');
        quantity = quantity.replace(/,/g, '');
        if(unit_price && unit_price >0 && quantity && quantity >0){

            $(this).closest('tr').addClass('has_value_changed');
            unsaved_row =true;
            $(this).closest('tr').find('.reset_item_line').show();
            var reset_save_item =  $(this).closest('tr').hasClass('has_item_value');
            if(reset_save_item){
                $(this).closest('tr').find('.undo_item_line').show();
            }
            $(this).closest('tr').find('.unit-price').hide();

            $(this).closest('tr').find('.span_unit_price').text( $(this).closest('tr').find('.unit-price').val());
            $(this).closest('tr').find('.span_unit_price').show();

            var t =$(this).closest('tbody').find('.save_est_btn:visible').length;
            if(t==0){
                $(this).closest('tr').find('.save_est_btn').show();
            }
        }

    });

    $(document).on("focusout",".unit-price",function() {

        $(this).closest('tr').find('.unit-price').hide();

        $(this).closest('tr').find('.span_unit_price').text( $(this).closest('tr').find('.unit-price').val());
        $(this).closest('tr').find('.span_unit_price').show();

    });

    function reset_estimate(){

        swal({
            title: "Are you sure?",
            text: "You will not be able to recover Estimation!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: 'Yes, I am sure!',
            cancelButtonText: "No, cancel it!",
            dangerMode: false,
        }).then(function(isConfirm) {
            if (isConfirm) {
                var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
                $.ajax({
                    url: '/ajax/resetEstimate/'+proposal_service_id,
                    type: 'get',

                    success: function( data){
                        data = JSON.parse(data);
                        console.log(data.estimate.service_price);
                        $('.service_total_'+proposal_service_id).val(data.estimate.service_price);
                        $('.estimate_total_'+proposal_service_id).val(data.estimate.line_item_total);
                        if(!check_est_completed){
                            $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                            temp_count = temp_count+1;
                            if(temp_count==total_service){
                                $('.item_summary_btn').hide();
                                $('.show_pending_est_msg').hide();
                                $('.welcome_msg').show();
                                $('.show_complete_est_msg').hide();
                            }else{

                                $('.show_pending_est_msg').text('You have '+temp_count+' additional services that you need to Estimate');
                                $('.show_pending_est_msg').show();
                                $('.welcome_msg').hide();
                                $('.show_complete_est_msg').hide();
                            }
                        }
                        $('.estimatingItemsTable').each(function(){
                            var $table = $(this);
                            var table_idd = $table.attr('id');
                            table_idd = table_idd.replace(new RegExp("^" + 'itemsType'), '');
                            var rows= $table.find('tr.has_item_value').length;
                            $table.find('tr.has_item_value').each(function(row, tr){
                                var unit_price = $(tr).find(".open_calculator").data('item-unit-price');
                                $(tr).find(".total-price").text('$0');
                                $(tr).find(".quantity").text('0');
                                $(tr).find(".unit-price").val(unit_price);
                                $(tr).find('.span_unit_price1').text('$'+addCommas(number_test(unit_price)));
                                $(tr).removeClass('has_item_value');
                                //$(tr).find('.deleteLineItem').hide();
                                //$(tr).find('.items_checkbox').hide();
                                $(tr).find('.deleteLineItem').data('estimate-line-id','');
                                $(tr).find('.open_calculator').data('estimate-line-id','');

                            });
                            $('#heading_span_'+table_idd).text('0');
                        });

                        swal(
                            'Reset Successfully',
                            'Estimation Reset'
                        );
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })
               
            } else {
                swal("Cancelled", "Your Estimation is safe :)", "error");
            }
        });
        calculate_measurement_unit_price(proposal_service_id)


    }

    function get_service_item_list(){
        $.ajax({
            url: '/ajax/getProposalServiceLineItems/',
            type: 'post',
            data: {
                'proposalServiceId':proposal_service_id,
                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
            },
            success: function( data){
                data = JSON.parse(data);
                var estimate_final_total = 0;
                $('.estimatingItemsTable').each(function(){
                    var $table = $(this);
                    var table_total = 0;
                    $table.find('tr').each(function(row, tr){
                        if(row>0){
                            $(tr).find('.quantity').text('0');
                            $(tr).find('.total-price').text('0');
                            $(tr).find('.open_calculator').attr('data-estimate-line-id','');
                            var tr_item_id = $(tr).attr('id');
                            var tr_item_id = tr_item_id.replace(new RegExp("^" + 'items_'), '');
                            if(data.length){
                                var new_data = data.filter(x => x.item_id == tr_item_id);
                                if(new_data.length){
                                    $(tr).find('#items_checkbox_'+tr_item_id).val(new_data[0].id);
                                    $(tr).find('.quantity').text(addCommas(number_test2(new_data[0].quantity)));
                                    $(tr).find('.unit-price').val(number_test(new_data[0].unit_price));
                                    console.log('check101');
                                    $(tr).find('.span_unit_price1').text('$'+addCommas(number_test(new_data[0].unit_price)));
                                    $(tr).find('.total-price').text(addCommas(number_test(new_data[0].total_price)));
                                    $(tr).find('.open_calculator').attr('data-estimate-line-id',new_data[0].id);
                                    $(tr).find('.open_calculator').data('estimate-line-id', new_data[0].id);
                                    $(tr).find('.deleteLineItem').attr('data-estimate-line-id',new_data[0].id);
                                    //$(tr).find('.deleteLineItem').show();
                                    $(tr).addClass('has_item_value');
                                    table_total = parseFloat(table_total) + parseFloat(new_data[0].total_price)
                                    estimate_final_total = parseFloat(estimate_final_total) + parseFloat(new_data[0].total_price);
                                }else{
                                    $(tr).find('.deleteLineItem').attr('data-estimate-line-id','');
                                    //$(tr).find('.deleteLineItem').hide();
                                    $(tr).removeClass('has_item_value');
                                }

                            }else{
                                $(tr).find('.deleteLineItem').attr('data-estimate-line-id','');
                                // $(tr).find('.deleteLineItem').hide();
                                $(tr).removeClass('has_item_value');
                            }
                        }
                    });
                    var table_id =$table.attr('id');
                    table_id = table_id.replace('itemsType', '');
                    if(table_total>0){
                        $('.table_total_'+table_id).text('$'+addCommas(number_test(table_total)));
                    }else{
                        $('.table_total_'+table_id).text('');
                    }
                });
                $('.templateItemsTable').each(function(){
                    var $table = $(this);
                    var table_total = 0;
                    $table.find('tr').each(function(row, tr){
                        if(row>0){
                            $(tr).find('.quantity').text('0');
                            $(tr).find('.total-price').text('0');
                            $(tr).find('.open_calculator').attr('data-estimate-line-id','');
                            var tr_item_id = $(tr).attr('id');
                            var tr_item_id = tr_item_id.replace(new RegExp("^" + 'template_items_'), '');
                            if(data.length){
                                var new_data = data.filter(x => x.item_id == tr_item_id);
                                if(new_data.length){
                                    $(tr).find('#template_items_checkbox_'+tr_item_id).val(new_data[0].id);
                                    $(tr).find('.quantity').text(addCommas(number_test2(new_data[0].quantity)));
                                    $(tr).find('.unit-price').val(number_test(new_data[0].unit_price));
                                    console.log('check102');
                                    $(tr).find('.span_unit_price1').text('$'+addCommas(number_test(new_data[0].unit_price)));
                                    $(tr).find('.total-price').text(addCommas(number_test(new_data[0].total_price)));
                                    $(tr).find('.open_calculator').attr('data-estimate-line-id',new_data[0].id);
                                    $(tr).find('.deleteLineItem').attr('data-estimate-line-id',new_data[0].id);
                                    //$(tr).find('.deleteLineItem').show();
                                    $(tr).addClass('has_item_value');
                                    table_total = parseFloat(table_total) + parseFloat(new_data[0].total_price);
                                    estimate_final_total = parseFloat(estimate_final_total) + parseFloat(new_data[0].total_price);
                                }else{
                                    $(tr).find('.deleteLineItem').attr('data-estimate-line-id','');
                                    //$(tr).find('.deleteLineItem').hide();
                                    $(tr).removeClass('has_item_value');

                                }

                            }else{
                                $(tr).find('.deleteLineItem').attr('data-estimate-line-id','');
                                //$(tr).find('.deleteLineItem').hide();
                                $(tr).removeClass('has_item_value');
                            }
                            $(tr).removeClass('has_value_changed');
                        }
                    });
                    var table_id =$table.attr('id');
                    table_id = table_id.replace('template_itemsType', '');
                    if(table_total>0){
                        $('.template_table_total_'+table_id).text('$'+addCommas(number_test(table_total)));
                    }else{
                        $('.template_table_total_'+table_id).text('');
                    }
                });
                check_tr_has_class();
                get_custom_items();
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }

        })
    }



    $(".reset_item_line").click(function(){





        var reset_save_item =  $(this).closest('tr').hasClass('has_item_value');
        unsaved_row=false;
        if(reset_save_item){
            var lineItemId  = $(this).closest('tr').find(".open_calculator").attr('data-estimate-line-id');

            $this =$(this);

            var est_items = [];
            est_items.push(lineItemId)
            $.ajax({
                url: '/ajax/deleteEstimateLineItems',
                type: "POST",
                data: {
                    "lineItemIds": est_items,
                    "proposalServiceId": proposal_service_id,
                    'phase_id':phase_id,
                },


                success: function( data){
                    data = JSON.parse(data);
                    if(data.estimate.completed==0){
                        $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                        temp_count = temp_count+1;

                        if(total_service == temp_count){
                            $('.show_pending_est_msg').hide();
                            $('.welcome_msg').show();
                            $('.show_complete_est_msg').hide();
                        }else{
                            $('.show_pending_est_msg').text('You have '+temp_count+' additional services that you need to Estimate');
                            $('.show_pending_est_msg').show();
                            $('.welcome_msg').hide();
                            $('.show_complete_est_msg').hide();
                        }

                    }else{
                       
                        $('#service_'+proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                        
                    }
                    if(data.estimate.child_has_updated_flag==0 ){
                        $('.service_child_has_updated_flag_'+proposal_service_id).hide();
                        $('#service_'+proposal_service_id+' .toggle').addClass('text-active-color').removeClass('text-active-color2');
                        $('#service_'+proposal_service_id+' .toggle').css('background-color','#aeaeae');
                    }
                    
                    $('.service_total_'+proposal_service_id).val(number_test(data.total_price));
                    
                    $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                    $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                    $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                    if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                    $('#estimateLineItemTable').DataTable().ajax.reload();

                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
            })

            // $.ajax({
            //     url: '/ajax/deleteCalculatorValues/'+proposal_service_id+'/'+item_id,
            //     type: 'get',

            //     success: function( data){
            //         //get_service_item_list();
            //         get_service_item_list_by_phase_id();
            //         get_proposal_breakdown();
            //         //update_proposal_overhead_profit();
            //     },
            //     error: function( jqXhr, textStatus, errorThrown ){
            //         console.log( errorThrown );
            //     }
            // })
            $this.closest('tr').find(".open_calculator").data('estimate-line-id','');
            $this.closest('tr').find(".deleteLineItem").data('estimate-line-id','');
        }

        //else{
        var item_unit_price = $(this).closest('tr').find('.open_calculator').data('item-unit-price');
        $(this).closest('tr').find('.unit-price').val(item_unit_price);
        console.log('check103');
        $(this).find('.span_unit_price1').text('$'+addCommas(number_test(item_unit_price)));
        $(this).closest('tr').find('.quantity').text(0);
        $(this).closest('tr').find('.total-price').text('0');
        //}

        $(this).closest('tr').removeClass('has_value_changed');
        $(this).closest('tr').find('.save_est_btn').hide();
        $(this).closest('tr').removeClass('has_item_value');
        $(this).hide();
        $(this).closest('tr').find('.undo_item_line').hide();

    });

    $(".span_unit_price").click(function(){
        var temp_item_line_id = $(this).closest('tr').prop('id')
        if(unsaved_row && temp_item_line_id != item_line_id){

            swal(
                'You have an unsaved item',
                'Please save or clear item to continue'
            );

        }else{
            $(this).closest('tr').find('.unit-price').show();
            $(this).hide();
        }
    });

    function calculate_measurement_unit_price(service_id){

        var measurement = $('#service_'+service_id+' ul > li:first-child span').text();

        if(measurement){
            measurement = measurement.replace(/,/g, '');
            var t_total = $('.service_total_'+service_id).val();
            t_total = t_total.replace('$', '');
            t_total = t_total.replace(/,/g, '');
            var price_per_unit = t_total /measurement ;
            $('#service_price_per_unit_'+service_id).text(price_per_unit.toFixed(2));
        }
    }

    function adjust_price(){
        if(unsaved_row){
            swal(
                'You have an unsaved item',
                'Please save or clear item to continue'
            );
        }else{
            $('.save_adjust_price_btn_'+proposal_service_id).show();
            $('#adjusted_total_'+proposal_service_id).show();
            $('.adjust_price_btn_'+proposal_service_id).hide();
            $('.cancel_adjust_price_btn_'+proposal_service_id).show();
            $('.adjusted_total_'+proposal_service_id).show();
            $('.adjusted_total_'+proposal_service_id).focus();
            $('.span_adjusted_total_'+proposal_service_id).hide();
            $('.remove_adjusted_price_btn_'+proposal_service_id).hide();
            $('.accordionContainer').accordion({
                active: false,
                collapsible: true
            });
            unsaved_row=true;

        }
    }

    function revert_adjust_price(){
        $('.save_adjust_price_btn_'+proposal_service_id).hide();
        var adjusted = $('#adjusted_total_'+proposal_service_id).attr('data-adjusted-price');

        if(adjusted==1){
            $('#adjusted_total_'+proposal_service_id).show();
            $('.adjusted_total_'+proposal_service_id).hide();
            $('.span_adjusted_total_'+proposal_service_id).show();
            $('.remove_adjusted_price_btn_'+proposal_service_id).show();

            $('.adjusted_total_'+proposal_service_id).val($('.span_adjusted_total_'+proposal_service_id).text());
        }else{
            $('#adjusted_total_'+proposal_service_id).hide();
            $('.adjusted_total_'+proposal_service_id).hide();
            $('.adjusted_total_'+proposal_service_id).val('');
            $('.span_adjusted_total_'+proposal_service_id).hide();
            $('.remove_adjusted_price_btn_'+proposal_service_id).hide();
        }

        $('.cancel_adjust_price_btn_'+proposal_service_id).hide();
        $('.adjust_price_btn_'+proposal_service_id).show();
        unsaved_row=false;

    }
    function revert_adjust_price1(){
        $('.save_adjust_price_btn_'+proposal_service_id).hide();
        var adjusted = $('#adjusted_total_'+proposal_service_id).attr('data-adjusted-price');


        $('#adjusted_total_'+proposal_service_id).hide();
        $('.adjusted_total_'+proposal_service_id).hide();

        $('.span_adjusted_total_'+proposal_service_id).hide();
        $('.remove_adjusted_price_btn_'+proposal_service_id).hide();

        $('.cancel_adjust_price_btn_'+proposal_service_id).hide();
        $('.adjust_price_btn_'+proposal_service_id).show();


    }
    function remove_adjusted_price(){
        if(unsaved_row){
            swal(
                'You have an unsaved item',
                'Please save or clear item to continue'
            );
        }else{
            $.ajax({
                url: '/ajax/removeAdjustedPrice/'+proposal_service_id,
                type: 'get',

                success: function(data){
                    data = JSON.parse(data);
                    console.log(data.estimate.line_item_total);
                    $('.service_total_'+proposal_service_id).val(data.line_item_total);
                    $('.adjusted_total_'+proposal_service_id).val('');
                    $('.adjusted_total_'+proposal_service_id).hide();
                    $('.span_adjusted_total_'+proposal_service_id).text('$0');
                    $('#adjusted_total_'+proposal_service_id).hide();
                    swal(
                        'Adjusted Price Removed',
                        ''
                    );

                    $('#adjusted_total_'+proposal_service_id).attr('data-adjusted-price','0');
                    $('.remove_adjusted_price_btn_'+proposal_service_id).hide();


                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
            });
        }
    }
    function save_adjust_price(){
        
        var proposal_price = $('.adjusted_total_'+proposal_service_id).val();
        var service_total = $('.service_total_'+proposal_service_id).val();
        proposal_price = proposal_price.replace('$', '');
        proposal_price = proposal_price.replace(/,/g, '');
        service_total = service_total.replace('$', '');
        service_total = service_total.replace(/,/g, '');
        if(proposal_price && proposal_price >0){

            var percent =  proposal_price * 100 / service_total;
            percent = Math.round(percent);
            if(percent >= 90 && percent <= 110){
                $('.cssloader').show();
                $.ajax({
                    url: '/ajax/applyEstimateProposalPrice/',
                    type: 'post',
                    data: {
                        'proposalServiceId':proposal_service_id,
                        'proposalPrice':proposal_price,
                    },
                    success: function(data){
                        data = JSON.parse(data);
                        unsaved_row=false;
                        console.log(data.estimate.line_item_total);
                        $('.service_total_'+proposal_service_id).val(data.estimate.line_item_total);
                        $('.adjusted_total_'+proposal_service_id).val(data.estimate.total_price);
                        $('.adjusted_total_'+proposal_service_id).hide();
                        $('.span_adjusted_total_'+proposal_service_id).text('$'+addCommas(number_test(data.estimate.total_price)));
                        $('.span_adjusted_total_'+proposal_service_id).show();
                        swal(
                            'Price Adjusted',
                            ''
                        );
                        if(data.estimate.custom_price==1){
                            $('#adjusted_total_'+proposal_service_id).attr('data-adjusted-price','1');
                            $('.remove_adjusted_price_btn_'+proposal_service_id).show();
                        }else{
                            $('#adjusted_total_'+proposal_service_id).attr('data-adjusted-price','0');
                            $('.remove_adjusted_price_btn_'+proposal_service_id).hide();
                        }
                        $('.cssloader').hide();
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                });
                $('.save_adjust_price_btn_'+proposal_service_id).hide();
                $('.cancel_adjust_price_btn_'+proposal_service_id).hide();
                $('.adjust_price_btn_'+proposal_service_id).show();

            }else {
                swal(
                    'Error',
                    'Price cannot be adjusted by more than 10%'
                );
            }
        }else{
            swal(
                'Error',
                'Please enter a valid price'
            );
        }
    }

    $(document).on("change",".adjusted_total_input",function() {
        $('.save_adjust_price_btn_'+proposal_service_id).show();
        $('.cancel_adjust_price_btn_'+proposal_service_id).show();
        $('.adjust_price_btn_'+proposal_service_id).hide();
    });

    $(document).on("click",".accordionHeader",function() {

        var type_id =  $(this).data('type-id');
        var template_id =  $(this).data('template-id');
        if(type_id){
            get_proposal_type_total(type_id);
        }
        if(template_id){
            check_default_saved_template_items(template_id);
        }
    });
    function get_proposal_type_total(type_id){

        $.ajax({
            url: '/ajax/getProposalServiceTypeTotal/'+proposal_service_id+'/'+type_id,
            type: 'get',

            success: function(data){
                data = JSON.parse(data);
              
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }
        });
    }

    $(document).on("click",".undo_item_line",function() {
        var line_item_id = $(this).closest('tr').find(".open_calculator").attr('data-estimate-line-id');
        $this = $(this);
        $.ajax({
            url: '/ajax/getEstimateLineItemDetails/'+line_item_id,
            type: 'get',

            success: function(data){
                data = JSON.parse(data);
                $this.closest('tr').find('.quantity').text(addCommas(number_test2(data.qty)));
                $this.closest('tr').find('.unit-price').val(number_test(data.unitPrice));
                console.log('check104');
                $this.closest('tr').find('.span_unit_price1').text('$'+addCommas(number_test(data.unitPrice)));
                $this.closest('tr').find('.total-price').text(addCommas(number_test(data.totalPrice)));
                $this.closest('tr').removeClass('has_value_changed');
                $this.closest('tr').find('.save_est_btn').hide();
                $this.hide();
                $this.closest('tr').find('.reset_item_line').hide();
                $this.closest('tr').find('.undo_item_line').hide();
                unsaved_row=false;

            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }
        });
    });

    $( "body1" ).click(function(event) {
        if(unsaved_row){
            event.preventDefault();
            alert();
        }

    });
    window.addEventListener('beforeunload', function (e) {
        // Cancel the event
        if(unsaved_row){
            e.preventDefault();
            // Chrome requires returnValue to be set
            e.returnValue = '';
        }
    });

    $(".cal_overhead, .cal_profit,.cal_tax").keyup(function() {
        unsave_cal=true; 
        custom_price_total = false; 
        overheadRate = cleanNumber($(this).closest('tbody').find('.cal_overhead').val());
        profitRate = cleanNumber($(this).closest('tbody').find('.cal_profit').val());
        //cal_trucking_oh = cleanNumber($(this).closest('tbody').find('.cal_trucking_oh').val());
        //cal_trucking_pm = cleanNumber($(this).closest('tbody').find('.cal_trucking_pm').val());
        console.log('check229');
        updateItemPrices(overheadRate,profitRate);
        if($(this).closest('form').attr('id') =='asphalt_form'){
            calculate_measurement();
        }else if($(this).closest('form').attr('id') =='striping_form'){
            stripingPaintRender();
        }else if($(this).closest('form').attr('id') =='crack_sealer_form'){
            cracksealCalculator()
        }else if($(this).closest('form').attr('id')=='sealcoating_form'){
            sealcoatCalculator()
        }else if($(this).closest('form').attr('id')=='time_type_form'){
            calculate_time_type()
        }else if($(this).closest('form').attr('id')=='trucking_form'){
            calculate_trucking_type('trucking_form',false,false,true)
        }else if($(this).closest('form').attr('id')=='concrete_form'){
            calculate_concrete_measurement();
        }else if($(this).closest('form').attr('id')=='sealcoating_material_form'){
            sealcoating_material_measurement();
        }
        var temp_esimate_line_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
        
        if(temp_esimate_line_id){
            get_child_items_list(temp_esimate_line_id,false,true);
        }
        //get_child_items_list(perent_item_id,false);
    });

    function updateItemPrices(overheadRate,profitRate) {
        
        var tempoverheadPrice = ((item_base_price * overheadRate) / 100);
        var tempprofitPrice = ((item_base_price * profitRate) / 100);
        overheadPrice = tempoverheadPrice * item_quantity;
        profitPrice = tempprofitPrice * item_quantity;
        
        var totalPrice = parseFloat(item_base_price) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);
        item_price = totalPrice;
        //$('#'+item_line_id).find('.span_unit_price1').text('$'+addCommas(number_test(item_price)));
        if(parseFloat(overheadPrice)<0){
            var tempoverheadPrice = '-$'+addCommas(number_test(Math.abs(overheadPrice)));
            
        }else{
            var tempoverheadPrice = '$'+addCommas(number_test(overheadPrice));
        }

        if(parseFloat(profitPrice)<0){
            var tempprofitPrice = '-$'+addCommas(number_test(Math.abs(profitPrice)));
            
        }else{
            var tempprofitPrice = '$'+addCommas(number_test(profitPrice));
        }
        
        if(!custom_price_total){
            $(".cal_overhead_price").text(tempoverheadPrice);
            $(".cal_profit_price").text(tempprofitPrice);
        }
        console.log('check111-'+totalPrice)
        
        $(".cal_unit_price").text(addCommas(number_test(totalPrice)));
        

    }
    function cleanNumber(numberString) {
        var number = numberString.replace('$', '');
        number = number.replace(/,/g, '');
        number = number.replace("%", '');
        return number;
    }

    $(document).on('click',".cal_overhead_profit_checkbox",function() {

        if($(this).find('i').hasClass('fa-chevron-down')){
            $(this).closest('tbody').find('.show_overhead_and_profit').show();
            $(this).find('i').addClass('fa-chevron-up').removeClass('fa-chevron-down');
            //$('.labor_cal_tax_amount_row').show();
        }else{
            $(this).closest('tbody').find('.show_overhead_and_profit').hide();
            $(this).find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
        }
    })

    

    $(document).on('click',".show_child_item_total_check",function() {

        if($(this).find('i').hasClass('fa-chevron-down')){
            $(this).closest('tbody').find('.show_child_item_total').show();
            $(this).closest('tbody').find('.disposalTotalAmount').show();
            $(this).find('i').addClass('fa-chevron-up').removeClass('fa-chevron-down');
            console.log('check7');
            $('.if_nochild_items').show();
        }else{
            $(this).closest('tbody').find('.show_child_item_total').hide();
            $(this).closest('tbody').find('.disposalTotalAmount').hide();
            $(this).find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
            $('.if_nochild_items').hide();
        }
    })
    $(document).on('click',".show_child_item_total_tax_check",function() {

        if($(this).find('i').hasClass('fa-chevron-down')){
            $(this).closest('tbody').find('.show_child_item_tax_total').show();
            $(this).find('i').addClass('fa-chevron-up').removeClass('fa-chevron-down');
           
        }else{
            $(this).closest('tbody').find('.show_child_item_tax_total').hide();
            $(this).find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
            
        }
    })
    $(document).on('click',".labor_cal_overhead_profit_checkbox",function() {
        if($(this).find('i').hasClass('fa-chevron-down')){
            $(this).closest('tbody').find('.show_labor_overhead_and_profit').show();
            $(this).find('i').addClass('fa-chevron-up').removeClass('fa-chevron-down');
            //$('.labor_cal_tax_amount_row').show();
        }else{
            
            $(this).closest('tbody').find('.show_labor_overhead_and_profit').hide();
            $(this).find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
            
        }
    })

    $(document).on('click',".subcontractors_cal_overhead_profit_checkbox",function() {
        if($(this).find('i').hasClass('fa-chevron-down')){
            $(this).closest('tbody').find('.show_subcontractors_overhead_and_profit').show();
            $(this).find('i').addClass('fa-chevron-up').removeClass('fa-chevron-down');
            //$('.labor_cal_tax_amount_row').show();
        }else{
            
            $(this).closest('tbody').find('.show_subcontractors_overhead_and_profit').hide();
            $(this).find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
            
        }
    })

    $(document).on('click',".trucking_cal_overhead_profit_checkbox",function() {
        if($(this).find('i').hasClass('fa-chevron-down')){
            $(this).closest('tbody').find('.show_trucking_overhead_and_profit').show();
            $(this).find('i').addClass('fa-chevron-up').removeClass('fa-chevron-down');
            //$('.labor_cal_tax_amount_row').show();
        }else{
            
            $(this).closest('tbody').find('.show_trucking_overhead_and_profit').hide();
            $(this).find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
            
        }
    })
    $(document).on('click',".sep_trucking_cal_overhead_profit_checkbox",function() {
        if($(this).find('i').hasClass('fa-chevron-down')){
            $(this).closest('tbody').find('.show_sep_trucking_overhead_and_profit').show();
            $(this).find('i').addClass('fa-chevron-up').removeClass('fa-chevron-down');
            //$('.labor_cal_tax_amount_row').show();
        }else{
            
            $(this).closest('tbody').find('.show_sep_trucking_overhead_and_profit').hide();
            $(this).find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
            
        }
    })
    $(document).on('click',".equipement_cal_overhead_profit_checkbox",function() {
        if($(this).find('i').hasClass('fa-chevron-down')){
            $(this).closest('tbody').find('.show_equipement_overhead_and_profit').show();
            $(this).find('i').addClass('fa-chevron-up').removeClass('fa-chevron-down');
            //$('.labor_cal_tax_amount_row').show();
        }else{
            
            $(this).closest('tbody').find('.show_equipement_overhead_and_profit').hide();
            $(this).find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
            
        }
    })

    $(document).on('click',".custom_cal_overhead_profit_checkbox",function() {
        if($(this).find('i').hasClass('fa-chevron-down')){
            $(this).closest('tbody').find('.show_custom_overhead_and_profit').show();
            $(this).find('i').addClass('fa-chevron-up').removeClass('fa-chevron-down');
            //$('.labor_cal_tax_amount_row').show();
        }else{
            
            $(this).closest('tbody').find('.show_custom_overhead_and_profit').hide();
            $(this).find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
            
        }
    })

    $(document).on('click',".custom_child_cal_overhead_profit_checkbox",function() {
        if($(this).find('i').hasClass('fa-chevron-down')){
            $(this).closest('tbody').find('.show_custom_child_overhead_and_profit').show();
            $(this).find('i').addClass('fa-chevron-up').removeClass('fa-chevron-down');
            //$('.labor_cal_tax_amount_row').show();
        }else{
            
            $(this).closest('tbody').find('.show_custom_child_overhead_and_profit').hide();
            $(this).find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
            
        }
    })
    
    $(document).on('click',".cal_tax_checkbox",function() {
        if($(this).prop("checked")){
            $('.cal_tax').show();
            $('.cal_tax_amount_row').show();
        }else{
            $('.cal_tax').val(0);
            $('.cal_tax_amount').text(0);
            $('.cal_tax').hide();
            $('.cal_tax_amount_row').hide();
            overheadRate = cleanNumber($(this).closest('tbody').find('.cal_overhead').val());
            profitRate = cleanNumber($(this).closest('tbody').find('.cal_profit').val());
           // cal_trucking_oh = cleanNumber($(this).closest('tbody').find('.cal_trucking_oh').val());
            //cal_trucking_pm = cleanNumber($(this).closest('tbody').find('.cal_trucking_pm').val());
            console.log('check228');
            updateItemPrices(overheadRate,profitRate);
            if($(this).closest('form').attr('id') =='asphalt_form'){
                custom_price_total = false;
                calculate_measurement();
            }else if($(this).closest('form').attr('id') =='striping_form'){
                stripingPaintRender();
            }else if($(this).closest('form').attr('id') =='crack_sealer_form'){
                cracksealCalculator()
            }else if($(this).closest('form').attr('id')=='sealcoating_form'){
                sealcoatCalculator()
            }else if($(this).closest('form').attr('id')=='time_type_form'){
                calculate_time_type()
            }else if($(this).closest('form').attr('id')=='trucking_form'){
                calculate_trucking_type('trucking_form',false,false,true);
            }
            var temp_esimate_line_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
        
            if(temp_esimate_line_id){
                get_child_items_list(temp_esimate_line_id,false,true);
            }
        }
    })

    
    $(document).on("keyup",".sep_truck_per_day",function() {
        unsave_cal=true;  
        custom_price_total = false;
        var form_id = $(this).closest('form').attr('id');
        calculate_trucking_type(form_id,true,false);
       
    });
    $(document).on("keyup",".sep_trucking_day",function() {
        unsave_cal=true; 
        custom_price_total = false; 
        var form_id = $(this).closest('form').attr('id');
        calculate_trucking_type(form_id,false,true);
       
    });
    $(document).on("change",".sep_daily_production_rate",function() {
        unsave_cal=true;
        custom_price_total = false;
        var form_id = $(this).closest('form').attr('id');
        var daily_production_rate = cleanNumber($('#'+form_id).find('.sep_daily_production_rate').val());
        var material = cleanNumber($('#'+form_id).find('.sep_trucking_malerial').val());
       
        if(parseInt(daily_production_rate) > parseInt(material)){
            
            swal('','Production rate cannot exceed the material quantity');
            $('#'+form_id).find('.sep_daily_production_rate').val(material);
        }
        calculate_trucking_type(form_id,false,false);
       
    });

    $(document).on("change",".sep_trucking_malerial",function() {
        unsave_cal=true;  
        var form_id = $(this).closest('form').attr('id');
        //var daily_production_rate = cleanNumber($('#'+form_id).find('.sep_daily_production_rate').val());
        var daily_production_rate = '<?= $settings->getProductionRate();?>';
        var material = cleanNumber($('#'+form_id).find('.sep_trucking_malerial').val());
        if(parseInt(daily_production_rate) > parseInt(material)){
            $('#'+form_id).find('.sep_daily_production_rate').val(material);
        }
        custom_price_total = false;
        calculate_trucking_type(form_id,false,false);
       
    });
    
    $(document).on("keyup",".sep_truck_capacity,.sep_trucking_cal_overhead,.sep_trucking_cal_profit,.sep_truck_capacity,.sep_hours_per_day,.sep_minimum_hours",function() {
        unsave_cal=true; 
        custom_price_total = false; 
        var form_id = $(this).closest('form').attr('id');
        calculate_trucking_type(form_id,false,false);
       
    });
    $(document).on("change",".sep_trucking_item,.sep_custom_round_time",function() {
        var form_id = $(this).closest('form').attr('id');
        unsave_cal=true; 
        custom_price_total = false; 
        $('.sep_show_map').hide();
        calculate_trucking_type(form_id,false,false);
    });
    $(document).on("keyup",".perent_total_time",function() {
        
        var form_id = $(this).closest('form').attr('id');
        calculate_trucking_type(form_id,false,false,false,true);
       
    });
    

    function calculate_trucking_type(form_id,is_sep_truck_per_day,is_sep_trucking_day,is_calculate=false,is_custom_quantity=false){
        
        var material = cleanNumber($('#'+form_id).find('.sep_trucking_malerial').val());
        var truck_capacity = cleanNumber($('.sep_truck_capacity').val());
        var round_time = cleanNumber($('#'+form_id).find('.sep_custom_round_time').val()); 
       // var trip_time = cleanNumber($('#'+form_id).find('.sep_trip_time').val());
       // var plant_turnaround = cleanNumber($('#'+form_id).find('.sep_plant_turnaround').val())
       // var site_turnaround = cleanNumber($('#'+form_id).find('.sep_site_turnaround').val());
        var perent_total_time = cleanNumber($('#'+form_id).find('.total_time_hours').val());
        var hours_per_day = cleanNumber($('#'+form_id).find('.sep_hours_per_day').val());
        var truck_per_day = cleanNumber($('#'+form_id).find('.sep_truck_per_day').val());
        var daily_production_rate = cleanNumber($('#'+form_id).find('.sep_daily_production_rate').val());
        //var truck_per_day =2;
        var temp_unit_price = $('#'+item_line_id).find('.open_calculator').data('item-base-price');
        item_base_price = temp_unit_price;
        
        cal_trucking_oh = cleanNumber($("#"+form_id).find('.sep_trucking_cal_overhead').val());
        cal_trucking_pm = cleanNumber($("#"+form_id).find('.sep_trucking_cal_profit').val());
        var temp_cal_trucking_oh_Price = ((temp_unit_price * cal_trucking_oh) / 100);
        var temp_cal_trucking_pm_Price = ((temp_unit_price * cal_trucking_pm) / 100);
        
        var temp_unit_price = parseFloat(temp_unit_price) + parseFloat(temp_cal_trucking_oh_Price) + parseFloat(temp_cal_trucking_pm_Price);
        if(custom_price_total){
            temp_unit_price = saved_unit_price;
        }
        $('#'+form_id).find('.cal_trucking_unit_price').text(addCommas(number_test(temp_unit_price)));

       if(material && truck_capacity && truck_capacity>0 && round_time && round_time>0 && hours_per_day && hours_per_day>0  ){
            var trips = (material / truck_capacity);
            round_time = round_time * 60;
            trips = Math.ceil(trips);
            console.log(trips);
            //trip_time = (15 * Math.ceil(trip_time / 15));
            // var temp_total_time_hours = parseFloat(trip_time) + parseFloat(plant_turnaround) + parseFloat(site_turnaround);
            // //temp_item_quantity = trips  * temp_total_time_hours;
            // temp_item_quantity = (trips  * temp_total_time_hours)/60;
            // temp_item_quantity = Math.ceil(temp_item_quantity);

        $('#'+form_id).find('.total_trips').val(addCommas(trips));
        //$('.total_time_hours').val(temp_total_time_hours);
        
       // var round_time = Math.ceil(parseFloat(trip_time * 2) + parseFloat(plant_turnaround*60) + parseFloat(site_turnaround*60));
        var round_per_day = Math.floor(hours_per_day / (round_time/60));
        var ton_day_per_truck = Math.ceil(round_per_day * truck_capacity);
        //var recommended_trucks = Math.ceil(material / ton_day_per_truck);
        var recommended_trucks = Math.ceil(material / ton_day_per_truck);
        console.log('recommended_trucks'+recommended_trucks);
        var  temp_total_time_hours = (round_time/60) *trips;
        console.log(temp_total_time_hours);
        //var temp_total = temp_total_time_hours * temp_unit_price;
        item_price = temp_unit_price;
        //var totalPrice = parseFloat(temp_total) + parseFloat(temp_cal_trucking_oh_Price) + parseFloat(temp_cal_trucking_pm_Price);
         //totalPrice = parseFloat(temp_total);
        var sep_trucking_end_searchBox=$('#sep_trucking_end_searchBox').val();
        var sep_trucking_start_searchBox=$('#sep_trucking_start_searchBox').val();
        if(sep_trucking_start_searchBox != '' && sep_trucking_end_searchBox != '') {
            $('.sep_show_map').show();
        }
        
        temp_cal_trucking_oh_Price = temp_cal_trucking_oh_Price * temp_total_time_hours;
        temp_cal_trucking_pm_Price = temp_cal_trucking_pm_Price * temp_total_time_hours;
        
        $('#'+form_id).find('.sep_trucking_cal_overhead_price').text('$'+addCommas(number_test(temp_cal_trucking_oh_Price)));
        $('#'+form_id).find('.sep_trucking_cal_profit_price').text('$'+addCommas(number_test(temp_cal_trucking_pm_Price)));
        //$('#'+form_id).find('.cal_total_price').text(addCommas(number_test(totalPrice)));
        //$('#'+form_id).find('.cal_trucking_total_price').text(addCommas(number_test(totalPrice)));
        overheadRate = cal_trucking_oh;
        profitRate =cal_trucking_pm;
        overheadPrice = temp_cal_trucking_oh_Price;
        profitPrice = temp_cal_trucking_pm_Price;
        //$('.round_time').text(round_time+' Minutes');
        $('.round_per_day').text(round_per_day);
        //$('.ton_day_per_truck').text(ton_day_per_truck);
        $('.recommended_trucks').text(recommended_trucks);
        if(is_sep_truck_per_day){
            
           
            var truck_per_day = $('.sep_truck_per_day').val();
            
            var temp_sep_truck_per_day = Math.floor(daily_production_rate/ton_day_per_truck);
            if(parseInt(temp_sep_truck_per_day) < 1){
                temp_sep_truck_per_day =1;
            }
            if(truck_per_day>temp_sep_truck_per_day){
                swal('','This cannot be higher than '+temp_sep_truck_per_day+' as it would exceed your Production Rate');
                $('#'+form_id).find('.sep_truck_per_day').val(temp_sep_truck_per_day);
                truck_per_day =temp_sep_truck_per_day;
            }
            
            var trucking_days =  Math.ceil(material/(truck_per_day*ton_day_per_truck));
            $('.sep_trucking_day').val(Math.ceil(trucking_days));
        }else if(is_sep_trucking_day){
           
            var trucking_days = $('.sep_trucking_day').val();
            var sep_truck_per_day = Math.ceil((material/trucking_days)/ton_day_per_truck);
            
            if(parseInt(sep_truck_per_day) < 1){
                sep_truck_per_day =1;
            }
            var tons_per_day = Math.ceil(ton_day_per_truck*Math.ceil(sep_truck_per_day));
            
            if(tons_per_day > daily_production_rate){
                swal('','Warning: This puts you over your daily production rate');
            }

           
            //var sep_truck_per_day = daily_production_rate/ton_day_per_truck;
            $('#'+form_id).find('.sep_truck_per_day').val(sep_truck_per_day);





        }else if(!is_calculate){
            var trucking_days = $('.sep_trucking_day').val();
            //var sep_truck_per_day = recommended_trucks/trucking_days;
            // var sep_truck_per_day = Math.ceil(daily_production_rate/ton_day_per_truck);
            //  var tons_per_day = Math.ceil(ton_day_per_truck*Math.ceil(sep_truck_per_day));
            //  var trucking_days = Math.ceil((material/tons_per_day));
            //  if(trucking_days!=$('.sep_trucking_day').val()){
                
            //      var sep_truck_per_day = Math.ceil(recommended_trucks/trucking_days);
                
            //  }

            var trucking_days = Math.ceil((material/daily_production_rate));
           var sep_truck_per_day = Math.ceil((material/trucking_days)/ton_day_per_truck);
             if(parseInt(sep_truck_per_day) < 1){
                 sep_truck_per_day =1;
             }
            $('#'+form_id).find('.sep_truck_per_day').val(Math.ceil(sep_truck_per_day));


        }
        if(!sep_truck_per_day){
            
            sep_truck_per_day = $('#'+form_id).find('.sep_truck_per_day').val();
        }
        if(parseInt(sep_truck_per_day) < 1){
            sep_truck_per_day =1;
        }
        $('.sep_trucking_trucks').text(sep_truck_per_day);
      
       
      //  var temp_in_out_trip = (parseFloat(trip_time)/60);
        
      
        //$('.sep_tons_per_day').text(Math.ceil(ton_day_per_truck*recommended_trucks));
        var sep_tons_per_day = Math.ceil(ton_day_per_truck*Math.floor(sep_truck_per_day));
        $('.sep_tons_per_day').text(sep_tons_per_day);
      
        var temp_total_trucking = Math.ceil(trucking_days) * Math.floor(sep_truck_per_day);
        
       // var reduce_in_out_time = (temp_total_trucking *temp_in_out_trip);
        
        //temp_total_time_hours = temp_total_time_hours -reduce_in_out_time;
       
        // var hours_per_truck = temp_total_time_hours/Math.floor(sep_truck_per_day);
        // $('.sep_hours_per_trucks ').val(parseFloat(hours_per_truck.toFixed(2)));
        var temp_minimum_hours = $('.sep_minimum_hours').val();
        if(temp_total_time_hours<temp_minimum_hours){
            temp_total_time_hours = temp_minimum_hours;
            $('.if_use_minimum_hours').show();
        }else{
            $('.if_use_minimum_hours').hide();
        }
        if(is_custom_quantity){
            var  temp_total_time_hours = perent_total_time;
            $("#"+form_id).find('.perent_custom_total_time').val(1);
        }else{
            $("#"+form_id).find('.perent_custom_total_time').val(0);
        }
        $('.total_time_hours').val(temp_total_time_hours);
        if(!is_sep_trucking_day){
           $('.sep_trucking_day').val(Math.ceil(material/sep_tons_per_day));
        }
        
        item_quantity = temp_total_time_hours;
        var temp_total = temp_total_time_hours * temp_unit_price;
        
         totalPrice = parseFloat(temp_total);
         if(custom_price_total){
            totalPrice = saved_custom_price;
            }
         $('.edit_perent_total_hours').show();
         $('#'+form_id).find('.cal_total_price').text(addCommas(number_test(totalPrice)));
        cal_trucking_total_Price = totalPrice;
        calTotalPrice = totalPrice;
            
            $("#continue2").removeClass('ui-state-disabled');
            $("#continue2").attr('disabled',false);
        
           
        }else{
            
            $('.total_trips').val('');
            $('.round_time').text('');
            $('.round_per_day').text('');
            $('.ton_day_per_truck').text('');
            $('.recommended_trucks').text('');

            $('.trucking_day').text('');
            $('.tons_per_day').text('');

            $('.cal_total_price').text('0');
            $('.total_time_hours').val('0');
            $("#continue2").addClass('ui-state-disabled');
            $("#continue2").attr('disabled',true);
            $('.sep_show_map').hide();
        }
        
        calculateData =$('#'+form_id).serializeArray();
        if(savedData){
            var check = compareSavedValue(savedData,calculateData);
        }else{
            check =false; 
        }
        
        if(check){
            if(custom_price_total || saved_custom_price==0){
                $('.if_item_saved').show();
                $('.save_estimation').hide(); 
                unsave_cal=false; 
            }else{
                $('.if_item_saved').hide();
                $('.save_estimation').show();
                $('.item_total_edit_icon').show();
                unsave_cal=true;
            }         
        }else{
            $('.if_item_saved').hide();
            $('.save_estimation').show();
            $('.item_total_edit_icon').show(); 
            unsave_cal=true;
        }
        child_save_done =false;
        
    }

    
    $(document).on("click",".edit_sep_round_time",function() {

        $('.round_time').hide();
        $('.cancle_edit_sep_round_time').show();
        $('.edit_sep_round_time').hide();
    });
    $(document).on("click",".cancle_edit_sep_round_time",function() {

        $('.round_time').show();
        $('.cancle_edit_sep_round_time').hide();
        $('.edit_sep_round_time').show();
    });
    
    $(document).on("change",".sep_custom_round_time",function() {
        custom_price_total =false;
       
        $('.round_time').text($( ".sep_custom_round_time option:selected" ).text());
        $('.round_time').show();
        $('.cancle_edit_sep_round_time').hide();
        $('.edit_sep_round_time').show();
        var form_id = $(this).closest('form').attr('id');
        calculate_trucking_type(form_id,false,false,false,false,true);
        
    });

    
    $(document).on("click",".round_time_cal_span",function() {
        var hidden_sep_trucking_start_searchBox = $('.hidden_sep_trucking_start_searchBox').val();
        var hidden_sep_trucking_end_searchBox = $('.hidden_sep_trucking_end_searchBox').val();
        var hidden_sep_trip_time = $('.hidden_sep_trip_time').val();
        var hidden_sep_plant_turnaround = $('.hidden_sep_plant_turnaround').val();
        var hidden_sep_site_turnaround = $('.hidden_sep_site_turnaround').val();

        if(hidden_sep_trucking_start_searchBox && hidden_sep_trucking_start_searchBox && hidden_sep_trip_time && hidden_sep_plant_turnaround && hidden_sep_site_turnaround){

            $('#sep_trucking_start_searchBox').val(hidden_sep_trucking_start_searchBox);
            $('#sep_trucking_end_searchBox').val(hidden_sep_trucking_end_searchBox);

            $('.sep_site_turnaround').val(hidden_sep_site_turnaround);
            $('.sep_plant_turnaround').val(hidden_sep_plant_turnaround);
            $('.sep_trip_time').val(hidden_sep_trip_time);
            calculate_trucking_round_time();
        }else{

        
            $('#sep_trucking_start_searchBox').val('');
            $('#sep_trucking_end_searchBox').val('');

            $('#sep_trucking_start_lat').val('');
            $('#sep_trucking_start_lat').val('');

            $('#sep_trucking_end_lat').val('');
            $('#sep_trucking_end_long').val('');
           
            $('.selectTruckingStart').val('');
            $('.selectTruckingEnd').val('');
            $(".selectTruckingStart").select2("val", "");
            $(".selectTruckingEnd").select2("val", "");
            $('.selectTruckingStart').trigger('change');
            $('.selectTruckingEnd').trigger('change');

            $('.sep_site_turnaround').val('');
            $('.sep_plant_turnaround').val('');
            $('.sep_trip_time').val('');
            $('.calculated_round_time').text('0');
            $('.sep_show_map').hide();
        }
            $.uniform.update();
        $('.if_calculated_round_time').hide();
        $('#round_time_calculation_model').dialog('open');
   });

    $(document).on("change",".sep_plant_turnaround,.sep_site_turnaround,.sep_trip_time",function() {
       
        calculate_trucking_round_time();
    });
    $(document).on("keyup",".sep_trip_time",function() {
       
       calculate_trucking_round_time();
   });

    function calculate_trucking_round_time(){
        var trip_time = cleanNumber($('.sep_trip_time').val());
        var plant_turnaround = cleanNumber($('.sep_plant_turnaround').val())
        var site_turnaround = cleanNumber($('.sep_site_turnaround').val());
        if(trip_time && trip_time >0 && plant_turnaround && plant_turnaround >0 && site_turnaround && site_turnaround >0){
            var round_time = Math.ceil(parseFloat(trip_time * 2) + parseFloat(plant_turnaround*60) + parseFloat(site_turnaround*60));
        }else{
            var round_time = 0;
        }
        
        $('.calculated_round_time').text(round_time);
        if(round_time>0){
            $('.if_calculated_round_time').show();
        }
    }
    $(document).on("click",".use_round_time",function() {

        var sep_trucking_end_searchBox=$('#sep_trucking_end_searchBox').val();
        var sep_trucking_start_searchBox=$('#sep_trucking_start_searchBox').val();
        if(sep_trucking_start_searchBox != '' && sep_trucking_end_searchBox != '') {
            $('.sep_show_map').show();
            $('.hidden_sep_trucking_start_searchBox').val(sep_trucking_start_searchBox);
            $('.hidden_sep_trucking_end_searchBox').val(sep_trucking_end_searchBox);
            $('.hidden_sep_trip_time').val($('.sep_trip_time').val());
            $('.hidden_sep_plant_turnaround').val($('.sep_plant_turnaround').val());
            $('.hidden_sep_site_turnaround').val($('.sep_site_turnaround').val());
        }
       
        var round_time = cleanNumber($('.calculated_round_time').text());
        console.log(round_time);
        round_time =  round_time/60;
        console.log(round_time);
        round_time = Math.ceil(round_time*2)/2;
        if(round_time>5){
            round_time = 5;
        }
        $('.sep_custom_round_time').val(round_time);
        
        $('#round_time_calculation_model').dialog('close');
        $.uniform.update();
        $('.sep_custom_round_time').trigger('change');
   });
    


   ////child round time calculate

   $(document).on("click",".child_round_time_cal_span",function() {
        var hidden_child_trucking_start_searchBox = $('.hidden_child_trucking_start_searchBox').val();
        var hidden_child_trucking_plant_select = $('.hidden_child_trucking_plant_select').val();
        var hidden_child_trip_time = $('.hidden_child_trip_time').val();
        var hidden_child_plant_turnaround = $('.hidden_child_plant_turnaround').val();
        var hidden_child_site_turnaround = $('.hidden_child_site_turnaround').val();
        var hidden_child_round_time = $('.hidden_child_round_time').val();
        var hidden_child_trucking_dump_select = $('.hidden_child_trucking_dump_select').val();
        console.log(hidden_child_trucking_start_searchBox)
        if(hidden_child_trip_time && hidden_child_plant_turnaround && hidden_child_site_turnaround){
            child_saved_cal = true;
            $('#child_trucking_start_searchBox').val(hidden_child_trucking_start_searchBox);
            //$('.plantSelect').val(hidden_child_trucking_plant_select);
            $('.child_calculated_round_time').text(hidden_child_round_time);
            $('.site_turnaround').val(hidden_child_site_turnaround);
            $('.site_turnaround2').val(hidden_child_site_turnaround);
            $('.plant_turnaround').val(hidden_child_plant_turnaround);
            $('.plantSelect').select2("val", hidden_child_trucking_plant_select);
            $('.dumpSelect').select2("val", hidden_child_trucking_dump_select);
            $('.trip_time').val(hidden_child_trip_time);
            //calculate_child_trucking_round_time();
        }else{

        

        $('.plantSelect').select2("val", "");
        $('.dumpSelect').select2("val", "");

        $('.trip_time').val('');
        $('.site_turnaround2').val('');
            
        $('#child_trucking_start_searchBox').val('');
        $('.site_turnaround').val('');
        $('.plant_turnaround').val('')
        
        


            
            $('#child_trucking_start_searchBox').val('');
            $('#child_trucking_end_searchBox').val('');

            $('#child_trucking_start_lat').val('');
            $('#child_trucking_start_lat').val('');

            $('#child_trucking_end_lat').val('');
            $('#child_trucking_end_long').val('');
           


            $('.site_turnaround').val('');
            $('.plant_turnaround').val('');
            $('.trip_time').val('');
            $('.child_calculated_round_time').text('0');
            $('.child_show_map').hide();
        }
            $.uniform.update();
        $('.if_calculated_round_time').hide();
        $('#child_round_time_calculation_model').dialog('open');
        child_saved_cal =false;
   });

    $(document).on("change",".plant_turnaround,.site_turnaround,.trip_time",function() {
       
        calculate_child_trucking_round_time();
    });
    $(document).on("keyup",".trip_time",function() {
       
        calculate_child_trucking_round_time();
   });

    function calculate_child_trucking_round_time(){
        var trip_time = cleanNumber($('.trip_time').val());
        var plant_turnaround = cleanNumber($('.plant_turnaround').val())
        if(head_type_id == excavation_type_id || head_type_id == excavator_type_id  || head_type_id == milling_type_id){
            var site_turnaround = cleanNumber($('.site_turnaround2').val());
        }else{
            var site_turnaround = cleanNumber($('.site_turnaround').val());
        }
        //var site_turnaround = cleanNumber($('.site_turnaround').val());
        if(trip_time && trip_time >0 && plant_turnaround && plant_turnaround >0 && site_turnaround && site_turnaround >0){
            var round_time = Math.ceil(parseFloat(trip_time * 2) + parseFloat(plant_turnaround*60) + parseFloat(site_turnaround*60));
        }else{
            var round_time = 0;
        }
        
        $('.child_calculated_round_time').text(round_time);
        if(round_time>0){
            $('.if_calculated_round_time').show();
        }
    }
    $(document).on("click",".child_use_round_time",function() {

 
        var child_trucking_plantselect = $('.plantSelect').val();
        var child_trucking_dumpSelect = $('.dumpSelect').val();
        
        var child_trucking_trip_time = $('.trip_time').val();
        if(head_type_id == excavation_type_id || head_type_id == excavator_type_id  || head_type_id == milling_type_id){
            var site_turnaround = cleanNumber($('.site_turnaround2').val());
            
            var child_trucking_start_searchBox = $('#child_trucking_start_searchBox').val();
        }else{
            var site_turnaround = cleanNumber($('.site_turnaround').val());
            var child_trucking_start_searchBox = '';
        }

        
            $('.show_map').show();
            $('.hidden_child_trucking_plant_select').val(child_trucking_plantselect);
            $('.hidden_child_trucking_dump_select').val(child_trucking_dumpSelect);
            $('.hidden_child_trucking_start_searchBox').val(child_trucking_start_searchBox);
            $('.hidden_child_trip_time').val(child_trucking_trip_time);
            $('.hidden_child_plant_turnaround').val($('.plant_turnaround').val());
            $('.hidden_child_site_turnaround').val(site_turnaround);
            
        
       
        var round_time = cleanNumber($('.child_calculated_round_time').text());
        $('.hidden_child_round_time').val(round_time);
        round_time =  round_time/60;
        round_time = Math.ceil(round_time*2)/2;
        if(round_time>5){
            round_time = 5;
        }
        $('.child_custom_round_time').val(round_time);
        
        $('#child_round_time_calculation_model').dialog('close');
        $.uniform.update();
        $('.child_custom_round_time').trigger('change');
   });

    $(document).on("dblclick",".show_input_span111",function() {
        $('div').removeClass('edit_field_btns'); 
        $('.field_input').hide();
        $('.field_btn').hide();
        $('.cancel_field_save').hide();
        $('.show_input_span').show();
        $(this).next('div').addClass('edit_field_btns'); 
        var field_id =$(this).closest('li').data('field-id');
        $(this).hide()
        $(this).closest('li').find('.field_input').show();
        $(this).closest('li').find('.field_btn').show();
        $(this).closest('li').find('.cancel_field_save').show();

    });

    $(document).on("click",".field_btn",function() {

        //var field_id =$(this).closest('li').data('field-id');
        var field_id = $(this).closest('li').find('.field_input').attr('id');
        
        var field_id = field_id.replace(new RegExp("^" + 'input_'), '');
        var field_new_value = $(this).closest('li').find('.field_input').val();
       $this =$(this);
        $.ajax({
            url: '/ajax/updateFieldValue/',
            type: 'post',
            data: {
                'fieldValue':field_new_value,
                'fieldId':field_id
            },
            success: function(data){
                data = JSON.parse(data);
                $this.closest('li').find('.field_input').hide();
                $this.closest('li').find('.field_btn').hide();
                $this.closest('li').find('.show_input_span').text(field_new_value);
                $this.closest('li').find('.cancel_field_save').hide();
                $('.show_input_span').show();
                $this.closest('div').removeClass('edit_field_btns'); 
                $( "li[data-field-id='"+field_id+"']" ).find('.field_input').val(field_new_value);
                $( "li[data-field-id='"+field_id+"']" ).find('.show_input_span').text(field_new_value);
                






                if(calculator_form_id=='striping_form'){
                            
                                if($this.closest('li').attr('data-measurement-field')=='1'){
                                    $('#stripingFeet').val(field_new_value);
                                }
                            
                            stripingPaintRender();
                        }else if(calculator_form_id=='sealcoating_form'){
                            
                                if($this.closest('li').attr('data-measurement-field')=='1'){
                                    $('#sealcoatArea').val(field_new_value);
                                }
                                if($this.closest('li').attr('data-unit-field')=='1'){
                                    
                                    
                                    if(field_new_value=='square feet'){
                                        $('#sealcoatUnit').val('square feet');
                                        $('.total_surface_unit_text').text('Sq. Feet');
                                        $('.total_surface_unit_text2').text('Foot');
                                    }else{
                                        $('#sealcoatUnit').val('square yard');
                                        $('.total_surface_unit_text').text('Sq. Yds.');
                                        $('.total_surface_unit_text2').text('Yard');
                                    }
                                    setDropdowns();
                                $.uniform.update();
                                }
                            
                            sealcoatCalculator();
                        }else if(calculator_form_id=='crack_sealer_form'){
                            
                                if($this.closest('li').attr('data-measurement-field')=='1'){
                                    $('#crackseakLength').val(field_new_value);
                                }
                         
                            cracksealCalculator()
                        }else if(calculator_form_id=='asphalt_form'){
                    
                            if($this.closest('li').attr('data-measurement-field')=='1'){
                                $('#measurement').val(field_new_value);
                            }
                            if($this.closest('li').attr('data-depth-field')=='1'){
                                $('#depth').val(field_new_value);
                            }
                            if($this.closest('li').attr('data-unit-field')=='1'){
                                
                               
                                
                                if(field_new_value=='square feet'){
                                    $('.measurement_unit').val('square feet');
                                 }else{
                                     $('.measurement_unit').val('square yard');
                                 }
                                
                            }
                            setDropdowns();
                            $.uniform.update();
                           
                            calculate_measurement();
                        }
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }
        });
    });

    $(document).on("click",".cancel_field_save",function(){
        $(this).closest('li').find('.field_input').hide();
        $(this).closest('li').find('.field_btn').hide();
        $(this).closest('li').find('.cancel_field_save').hide();
        $(this).closest('li').find('.show_input_span').show();
        var old = $(this).closest('li').find('.show_input_span').text();
        $(this).closest('li').find('.field_input').val(old);
        $(this).closest('div').removeClass('edit_field_btns'); 
    });


$(document).on("click",".trucking_check",function(){
    if($("#continue2").is("[disabled=disabled]")){
        swal(
                'Please complete calculation to continue',
                ''
            );
    }else{
       
        has_custom_trucking_total_price_update = false;
            $('.save_estimation,.printoutpanel,.divMap,.show_map,.if_error_show_msg_parent,.if_error_show_msg,.close_map,.if_dump_fee_apply,.if_child_use_minimum_hours,.show_marker_map,.edit_child_total_hours,.edit_child_round_time,.cancle_edit_child_round_time').hide();
            
            $('.save_trucking_estimation,.if_trucking_check,.trucking_box,.round_time').show();
           
            $('.if_not_edit_trucking_item_total_price,.save_trucking_estimation,.trucking_form_right_box').show();
            $('.custom_trucking_total_price_input,.if_edit_trucking_item_total_price,.item_trucking_total_edit_icon').hide();
            $('.error').removeClass('error');
            
            $('.cal_trucking_total_price_lable').text('Total Price'); 
            $('#map_model').find('.trucking_cal_profit_price').closest('tr').css('color','#444444');
            $('#map_model').find('.trucking_cal_profit').css('color','#444444');
            $('#map_model').find('.trucking_cal_overhead_price').closest('tr').css('color','#444444');
            $('#map_model').find('.trucking_cal_overhead').css('color','#44444');
            $('#map_model').find('.child_custom_total_time').val(0);

            $('.hidden_child_trucking_plant_select').val('');
            $('.hidden_child_trucking_start_searchBox').val('');
            $('.hidden_child_trip_time').val('');
            $('.hidden_child_plant_turnaround').val('');
            $('.hidden_child_site_turnaround').val('');

            $('.total_time_hours').removeClass('text');
            $('.total_time_hours').addClass('hide_input_style2');
            $('.total_time_hours').attr("readonly","readonly");
            $('.select_box_error').removeClass('select_box_error');
            $('.select2_box_error').removeClass('select2_box_error');
            $('.round_time').text('');
            $('.round_per_day').text('');
            $('.ton_day_per_truck').text('');
            $('.tons_per_day').text('');
            $('.trucking_day').text('');
            $('.recommended_trucks').text('');
            $('.cal_trucking_total_price').text('0');
            $('.trucking_cal_overhead_price').text('0');
            $('.trucking_cal_profit_price').text('0');
            $('.cal_trucking_unit_price').text('0');
           
            $("#temp_trucking_form").trigger("reset");
            $('#temp_trucking_form').find('.plant_turnaround').val('0.5');
            $('#temp_trucking_form').find('.site_turnaround').val('0.5');
            
            $('#map_model').find('.show_trucking_overhead_and_profit').hide();
            $('.trucking_cal_overhead_profit_checkbox').find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
            $(".trucking_cal_overhead").val(service_overhead_rate);
            $(".trucking_cal_profit").val(service_profit_rate);
            $('.dump_fee_apply').attr('checked',false);
           
        if(head_type_id == excavation_type_id || head_type_id == milling_type_id){
            
            child_startLat =destLat;
            child_startLng =destLng;
            $('.dump_fee_apply').attr('checked',true);
            
        }else if(head_type_id == excavator_type_id){
            child_startLat =destLat;
            child_startLng =destLng;
            
            calculate_trucking_type2('time_type_form',false,false,true);
           
        }
            
         var material = cleanNumber($('#'+calculator_form_id).find('.item_quantity').text());
  
        var material = Math.ceil(material);
        $('#map_model').find('.show_material_quat').text(addCommas(material));
        $('.dump_fee_apply').trigger('change');
            setDropdowns();
            $.uniform.update();
            child_lineItemId ='';
            calculation_id ='';
           
        var services_title = $('#service_'+proposal_service_id+' .service_title_name').text();
        var phase_title = $('#service_'+proposal_service_id+' .phase_name_'+phase_id).text();
            //$('.child_item_calculator_heading').text(services_title+' | '+phase_title);
            var categoryName = $('#'+item_line_id).find('.open_calculator').data('category-name');
            var typeName = $('#'+item_line_id).find('.open_calculator').data('type-name');
            var itemName = $('#'+item_line_id).find('.open_calculator').attr('data-item-name');
            //$('.parant_item_name').text(categoryName+' / '+typeName+' / '+itemName);
            $('.parant_item_name').find('.calculatorHeadingCategory').text(categoryName);
            $('.parant_item_name').find('.calculatorHeadingType').text(typeName);
            $('.parant_item_name').find('.calculatorHeadingItem').text(itemName);
            $("#map_model").dialog('option','title',services_title+' | '+phase_title);
            $("#map_model").dialog('open');
            child_trucking_start_add_search();
           //child_trucking_end_add_search();
            if(head_type_id == excavation_type_id || head_type_id == excavator_type_id  || head_type_id == milling_type_id){
                $('.if_excavation').show();
                $('.if_not_excavation').hide();
                $('.plant_time_label').text('Dump Time');
                $('#child_trucking_start_searchBox').val('<?= $proposalRepository->getProjectAddressString($proposal);?>');
                $('#trucking_start_lat').val(destLat);
                $('#trucking_start_long').val(destLng);
                
            }else{
                $('.if_excavation').hide();
                $('.if_not_excavation').show();
                $('.plant_time_label').text('Plant Time');
            }
            $(".save_trucking_estimation").addClass('ui-state-disabled');
            $(".save_trucking_estimation").attr('disabled',true);
            $('.if_excavation_custom').hide();
            $('.dump_rate').val(0);
    }
    
});  

$(document).on("click",".labor_check",function(){
    if($("#continue2").is("[disabled=disabled]")){
        swal(
                'Please complete calculation to continue',
                ''
            );
    }else{
        has_custom_labor_total_price_update =false;
        $('.if_not_edit_labor_item_total_price,.save_labor_estimation').show();
        $('.custom_labor_total_price_input,.if_edit_labor_item_total_price,.item_labor_total_edit_icon').hide();
        $('.save_estimation,.custom_labor_total_price_input,.if_edit_labor_item_total_price').hide();
        $('.if_error_show_msg').hide();
        $('.error').removeClass('error');
        $('.labor_cal_total_price_label').text('Total Price'); 
        $('#time_type_form2').find('.labor_cal_profit_price').closest('tr').css('color','#444444');
        $('#time_type_form2').find('.labor_cal_profit').css('color','#444444');
        $('#time_type_form2').find('.labor_cal_overhead_price').closest('tr').css('color','#444444');
        $('#time_type_form2').find('.labor_cal_overhead').css('color','#44444');
        $('.select_box_error').removeClass('select_box_error');
        $('.select2_box_error').removeClass('select2_box_error');
        $("#time_type_form2").trigger("reset");
        $(".labor_cal_unit_price").text("$0.00");
        $(".labor_total_time_value").text("$0.00");
        $(".labor_cal_total_price").text("0.00");
        $(".labor_cal_overhead_price").text("$0.00");
        $(".labor_cal_profit_price").text("$0.00");
        $(".labor_cal_overhead").val(service_overhead_rate);
        $(".labor_cal_profit").val(service_profit_rate);
        $(".labor_type").select2();
        var select_options = '<option value="">Select Item</option>';
            $('.labor_item').html(select_options);
            $(".labor_item").select2();
        //$(".labor_item").select2();
        setDropdowns();
        $.uniform.update();
        child_lineItemId ='';
        calculation_id ='';
       
        $(".labor_cal_overhead_profit_checkbox").find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
        $('.show_labor_overhead_and_profit').hide();
        $("#labor_submit").addClass('ui-state-disabled');
        $("#labor_submit").attr('disabled',true);
        var services_title = $('#service_'+proposal_service_id+' .service_title_name').text();
        var phase_title = $('#service_'+proposal_service_id+' .phase_name_'+phase_id).text();
        //$('.child_item_calculator_heading').text(services_title+' | '+phase_title);
        var categoryName = $('#'+item_line_id).find('.open_calculator').data('category-name');
        var typeName = $('#'+item_line_id).find('.open_calculator').data('type-name');
        var itemName = $('#'+item_line_id).find('.open_calculator').attr('data-item-name');
        //$('.parant_item_name').text(categoryName+' / '+typeName+' / '+itemName);
        $('.parant_item_name').find('.calculatorHeadingCategory').text(categoryName);
        $('.parant_item_name').find('.calculatorHeadingType').text(typeName);
        $('.parant_item_name').find('.calculatorHeadingItem').text(itemName);
        $("#labor_model").dialog('option','title',services_title+' | '+phase_title);
        $("#labor_model").dialog('open');
    }
        
}); 
$(document).on("click",".equipement_check",function(){
    if($("#continue2").is("[disabled=disabled]")){
        swal(
                'Please complete calculation to continue',
                ''
            );
    }else{
        has_custom_equipement_total_price_update =false;
        $('.save_estimation').hide();
        $('.if_error_show_msg').hide();
        $('.equipement_cal_tax_amount').text('0');
        $('.equipement_cal_tax').hide();
        $('.if_not_edit_equipement_item_total_price,.save_equipement_estimation').show();
        $('.custom_equipement_total_price_input,.if_edit_equipement_item_total_price,.item_equipement_total_edit_icon').hide();
        $('.equipement_cal_total_price_label').text('Total Price'); 
        $('#equipement_model').find('.equipement_cal_profit_price').closest('tr').css('color','#444444');
        $('#equipement_model').find('.equipement_cal_profit').css('color','#444444');
        $('#equipement_model').find('.equipement_cal_overhead_price').closest('tr').css('color','#444444');
        $('#equipement_model').find('.equipement_cal_overhead').css('color','#44444');
        $('.select2_box_error').removeClass('select2_box_error');
            $('.error').removeClass('error');
            $('.select_box_error').removeClass('select_box_error');
        $("#equipement_time_type_form").trigger("reset");
        $(".equipement_cal_unit_price").text("$0.00");
        $(".equipment_total_time_value").text("$0.00");
        $(".equipement_cal_total_price").text("$0.00");
        $(".equipement_cal_overhead_price").text("$0.00");
        $(".equipement_cal_profit_price").text("$0.00");
        $(".equipement_cal_overhead").val(service_overhead_rate);
        $(".equipement_cal_profit").val(service_profit_rate);
        setDropdowns();
        $.uniform.update();
        child_lineItemId ='';
        calculation_id ='';
       
        $(".equipement_cal_overhead_profit_checkbox").find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
        $('.show_equipement_overhead_and_profit').hide();
        $("#equipement_submit").addClass('ui-state-disabled');
            $("#equipement_submit").attr('disabled',true);
        $("#equipement_type").select2();
        $("#equipement_item").select2();
        var services_title = $('#service_'+proposal_service_id+' .service_title_name').text();
        var phase_title = $('#service_'+proposal_service_id+' .phase_name_'+phase_id).text();
        //$('.child_item_calculator_heading').text(services_title+' | '+phase_title);
        var categoryName = $('#'+item_line_id).find('.open_calculator').data('category-name');
        var typeName = $('#'+item_line_id).find('.open_calculator').data('type-name');
        var itemName = $('#'+item_line_id).find('.open_calculator').attr('data-item-name');
        //$('.parant_item_name').text(categoryName+' / '+typeName+' / '+itemName);
        $('.parant_item_name').find('.calculatorHeadingCategory').text(categoryName);
        $('.parant_item_name').find('.calculatorHeadingType').text(typeName);
        $('.parant_item_name').find('.calculatorHeadingItem').text(itemName);
        $("#equipement_model").dialog('option','title',services_title+' | '+phase_title);
        $("#equipement_model").dialog('open');
    }
        
}); 

/////common trucking calculate//////////////
$(document).on("keyup",".truck_per_day",function() {
        unsave_cal=true;  
        
        calculate_trucking_type2(calculator_form_id,true,false);
});





    $(document).on("keyup",".trucking_day",function() {
        unsave_cal=true;  
        calculate_trucking_type2(calculator_form_id,false,true);
       
    });
    $(document).on("change",".daily_production_rate",function() {
        unsave_cal=true;  
       
        var daily_production_rate = cleanNumber($('#map_model').find('.daily_production_rate').val());
        if( head_type_id == excavator_type_id){
            var material = cleanNumber($('#'+calculator_form_id).find('.excavator_item_quantity').text());
        }else{
            var material = cleanNumber($('#'+calculator_form_id).find('.item_quantity').text());
        }
       
        if(parseInt(daily_production_rate) > parseInt(material)){
            
            swal('','Production rate cannot exceed the material quantity');
            $('#map_model').find('.daily_production_rate').val(material);
        }
        calculate_trucking_type2(calculator_form_id,false,false);
       
    });

    // $(document).on("change",".trucking_malerial",function() {
    //     unsave_cal=true;  
    //     var form_id = $(this).closest('form').attr('id');
    //     var daily_production_rate = cleanNumber($('#'+form_id).find('.sep_daily_production_rate').val());
    //     var material = cleanNumber($('#'+form_id).find('.sep_trucking_malerial').val());
    //     if(parseInt(daily_production_rate) > parseInt(material)){
    //         $('#'+form_id).find('.sep_daily_production_rate').val(material);
    //     }
    //     calculate_trucking_type(calculator_form_id,false,false);
       
    // });
    
    $('.trucking_day').on('focusin', function(){
        
        $(this).attr('data-old-val', $(this).val());
        $('#map_model').find('.truck_per_day').attr('data-old-val',$('#map_model').find('.truck_per_day').val());
    });
    $('.truck_per_day').on('focusin', function(){
        $(this).attr('data-old-val', $(this).val());
        
        $('#map_model').find('.trucking_day').attr('data-old-val',$('#map_model').find('.trucking_day').val());
    });


    $(document).on("keyup",".truck_capacity,.trip_time,.hours_per_day,.trucking_cal_overhead,.trucking_cal_profit,.child_minimum_hours",function() {
    //     if(calculator_form_id=='concrete_form'){
         calculate_trucking_type2(calculator_form_id,false,false)
    //    }else{
        unsave_cal=true;  
        //calculate_measurement();
      // }
    });

    $(document).on("keyup",".child_total_time",function() {
   
         calculate_trucking_type2(calculator_form_id,false,false,false,false,true)
    
    });
    
    $(document).on("change",".plant_turnaround,.site_turnaround,.site_turnaround2,.child_custom_round_time",function() {
    //     if(calculator_form_id=='concrete_form'){
        calculate_trucking_type2(calculator_form_id,false,false)
    //    }else{
        unsave_cal=true;  
        //calculate_measurement();
       //}
    });


    $(document).on("change",".trucking_item",function() {
        var capacity = $(this).find(':selected').attr('data-capacity');
        var minimum_hours = $('.trucking_item').find(':selected').attr('data-minimum-hours');
    
        if(oh_pm_type==2){
           
           var temp_item_overhead_rate = $('.trucking_item').find(':selected').data('overhead-rate');
           var temp_item_profit_rate = $('.trucking_item').find(':selected').data('profit-rate');
               $(".trucking_cal_overhead").val(temp_item_overhead_rate);
               $(".trucking_cal_profit").val(temp_item_profit_rate);
           }
        unsave_cal=true;  
        if(capacity && capacity>0 ){
            $('.truck_capacity').val(capacity);
            $('#map_model').find('.child_minimum_hours').val(number_test2(minimum_hours));
            $('.truck_capacity').removeClass('error');
        }
        
        
    //    if(calculator_form_id=='concrete_form'){
calculate_trucking_type2(calculator_form_id,false,false)
    //    }else{
        //calculate_measurement();
       //}
        //calculate_trucking_type2(form_id);
       
    });
    function calculate_trucking_type2(form_id,is_truck_per_day,is_trucking_day,is_calculate=false,is_custom_price=false,is_custom_quantity=false){
        //var material = $("#material").val();
        if( head_type_id == excavator_type_id){
            var material = cleanNumber($('#'+form_id).find('.excavator_item_quantity').text());
        }else{
            var material = cleanNumber($('#'+form_id).find('.item_quantity').text());
        }

        var ty = Math.ceil(material);
        $('#map_model').find('.show_material_quat').text(addCommas(ty));
        var truck_capacity = cleanNumber($('#map_model').find('.truck_capacity').val());
        var round_time = cleanNumber($('#map_model').find('.child_custom_round_time').val());
        
        //var trip_time = cleanNumber($('#map_model').find('.trip_time').val());
        //var plant_turnaround = cleanNumber($('#map_model').find('.plant_turnaround').val());
        var daily_production_rate = cleanNumber($('#map_model').find('.daily_production_rate').val());
        if(ty<daily_production_rate){
            $('#map_model').find('.daily_production_rate').val(ty);
            daily_production_rate= ty;
        }
        // if(head_type_id == excavation_type_id || head_type_id == excavator_type_id  || head_type_id == milling_type_id){
        //     var site_turnaround = cleanNumber($('#map_model').find('.site_turnaround2').val());
        // }else{
        //     var site_turnaround = cleanNumber($('#map_model').find('.site_turnaround').val());
        // }
        var tem =$('#map_model').find('.trucking_item').find(':selected').attr('data-unit-price');
       
        if(tem && tem> 0){
            var temp_unit_price = cleanNumber(tem);
        }else{
            temp_unit_price =0;
        }
        var hours_per_day = cleanNumber($('#map_model').find('.hours_per_day').val());
        cal_trucking_oh = cleanNumber($("#map_model").find('.trucking_cal_overhead').val());
        cal_trucking_pm = cleanNumber($("#map_model").find('.trucking_cal_profit').val());
        var truck_per_day = cleanNumber($("#map_model").find('.truck_per_day').val());
        var org_truck_per_day = cleanNumber($("#map_model").find('.truck_per_day').val());
        var org_trucking_days = cleanNumber($('.trucking_day').val());
        var old_trucking_day = cleanNumber($("#map_model").find('.trucking_day').attr('data-old-val'));
        var old_truck_per_day = cleanNumber($("#map_model").find('.truck_per_day').attr('data-old-val'));
        var child_total_time = cleanNumber($('#map_model').find('.total_time_hours').val());
        var temp_cal_trucking_oh_Price = ((temp_unit_price * cal_trucking_oh) / 100);
        var temp_cal_trucking_pm_Price = ((temp_unit_price * cal_trucking_pm) / 100);
        
        revert_custom_trucking_item_total();
        var temp_unit_price = parseFloat(temp_unit_price) + parseFloat(temp_cal_trucking_oh_Price) + parseFloat(temp_cal_trucking_pm_Price);
        
        $('#map_model').find('.cal_trucking_unit_price').text(addCommas(number_test(temp_unit_price)));
        
       if(material && material>0 && truck_capacity && truck_capacity>0 && round_time && round_time>0 && hours_per_day && hours_per_day>0 ){
        
            var trips = (material / truck_capacity);
            trips = Math.ceil(trips);
            // var temp_total_time_hours = parseFloat(trip_time) + parseFloat(plant_turnaround) + parseFloat(site_turnaround);
            
            // temp_item_quantity = (trips  * temp_total_time_hours)/60;
            // temp_item_quantity = Math.ceil(temp_item_quantity);

           
        
        $('#map_model').find('.total_trips').val(addCommas(trips));
        //$('.total_time_hours').val(temp_total_time_hours);
        
        round_time = parseFloat(round_time*60);
        console.log(hours_per_day)
        var round_per_day = Math.floor(hours_per_day / (round_time/60));
        if(round_per_day < 1){
            round_per_day = 1;
        }
        
        var ton_day_per_truck = Math.ceil(round_per_day * truck_capacity);
        console.log('ton_day_per_truck'+ton_day_per_truck);
        var recommended_trucks = Math.ceil(material / ton_day_per_truck);
        
            var  temp_total_time_hours = (round_time/60) *trips;
        
        
        temp_cal_trucking_oh_Price = temp_cal_trucking_oh_Price * temp_total_time_hours;
        temp_cal_trucking_pm_Price = temp_cal_trucking_pm_Price * temp_total_time_hours;
        //var temp_total = temp_total_time_hours * temp_unit_price;
        
        //var totalPrice = parseFloat(temp_total) + parseFloat(temp_cal_trucking_oh_Price) + parseFloat(temp_cal_trucking_pm_Price);
        //var totalPrice = parseFloat(temp_total);
        $('.show_map').show();
        
        if(!is_custom_price){
            $(".trucking_cal_overhead_price").text('$'+addCommas(number_test(temp_cal_trucking_oh_Price)));
            $(".trucking_cal_profit_price").text('$'+addCommas(number_test(temp_cal_trucking_pm_Price)));
        }
        $('#map_model').find('.cal_trucking_unit_price').text(addCommas(number_test(temp_unit_price)));
        //$('#map_model').find('.cal_trucking_total_price').text(addCommas(number_test(totalPrice)));
        
        $('.round_time').text(round_time+' Minutes');
        $('.round_per_day').text(round_per_day);
        $('.ton_day_per_truck').text(ton_day_per_truck);
        $('.recommended_trucks').text(recommended_trucks);
        $('.total_time_hours').val(temp_total_time_hours);

        $('.edit_child_total_hours').show();
            


            //////////////////////////////////


            if(is_truck_per_day){
            var truck_per_day = $('.truck_per_day').val();
            var trucking_days =  Math.ceil(material/(truck_per_day*ton_day_per_truck));
           
            $('.trucking_day').val(Math.ceil(trucking_days));
        }else if(is_trucking_day){
           
            var trucking_days = $('.trucking_day').val();
            var truck_per_day = Math.ceil((material/trucking_days)/ton_day_per_truck);
            if(parseInt(truck_per_day) < 1){
                truck_per_day =1;
            }
            var tons_per_day = Math.ceil(ton_day_per_truck*Math.ceil(truck_per_day));
            
            if(tons_per_day > daily_production_rate){
                
                swal('','Warning: This puts you over your daily production rate');
            }
           
           $('#map_model').find('.truck_per_day').val(truck_per_day);
        }else if(!is_calculate){
            
        
           var trucking_days = Math.ceil((material/daily_production_rate));
           var truck_per_day = Math.ceil((material/trucking_days)/ton_day_per_truck);

        
            if(parseInt(truck_per_day) < 1){
                truck_per_day =1;
            }
            $('#map_model').find('.truck_per_day').val(truck_per_day);
           // trucking_day
        }
        
        if(!truck_per_day){
            truck_per_day = $('#map_model').find('.truck_per_day').val();
        }
        if(parseInt(truck_per_day) < 1){
                truck_per_day =1;
        }
        
        $('.trucking_trucks').text(truck_per_day);
        $('.truck_per_day').val(truck_per_day);
      
        //var temp_in_out_trip = (parseFloat(trip_time)/60);
      
      
        //$('.sep_tons_per_day').text(Math.ceil(ton_day_per_truck*recommended_trucks));
        console.log('truck_per_day'+truck_per_day);
        var tons_per_day = Math.ceil(ton_day_per_truck*Math.floor(truck_per_day));
        console.log('tons_per_day'+tons_per_day);
        $('.tons_per_day').text(tons_per_day);
        trucking_days =Math.ceil(material/tons_per_day);
        var temp_total_trucking = Math.ceil(trucking_days) * Math.floor(truck_per_day);
        
       // if(round_per_day>=1){
            //var reduce_in_out_time = (temp_total_trucking *temp_in_out_trip);
        // }else{
        //     var reduce_in_out_time = 0;
        // }
        
       // temp_total_time_hours = temp_total_time_hours -reduce_in_out_time;
        var hours_per_truck = temp_total_time_hours/Math.floor(truck_per_day);
        $('.hours_per_trucks ').val(parseFloat(hours_per_truck.toFixed(2)));
        var child_minimum_hours = $('.child_minimum_hours ').val();
        if(child_minimum_hours > temp_total_time_hours){
            temp_total_time_hours = child_minimum_hours;
            $('.if_child_use_minimum_hours').show();
        }else{
            $('.if_child_use_minimum_hours').hide();
        }
       // console.log('is_custom_quantity '+is_custom_quantity)
        if(is_custom_quantity){
            var  temp_total_time_hours = child_total_time;
            $('#map_model').find('.child_custom_total_time').val(1);
        }else{
            $('#map_model').find('.child_custom_total_time').val(0);
        }

        $('.total_time_hours').val(temp_total_time_hours);
        
        if(!is_trucking_day){
            
            $('.trucking_day').val(Math.ceil(material/tons_per_day));
        }
        //item_quantity = temp_total_time_hours;
        var temp_total = temp_total_time_hours * temp_unit_price;
        
         totalPrice = parseFloat(temp_total);
         console.log(totalPrice);
         if(!is_custom_price){
            $('#map_model').find('.cal_trucking_total_price').text(addCommas(number_test(totalPrice)));
         }
         
         
         cal_trucking_oh_Price = temp_cal_trucking_oh_Price;
        cal_trucking_pm_Price = temp_cal_trucking_pm_Price;
        cal_trucking_total_Price = totalPrice;
        $(".save_trucking_estimation").removeClass('ui-state-disabled');
        $(".save_trucking_estimation").attr('disabled',false);

        $('.item_trucking_total_edit_icon').show();


            ///////////////////////////////////
           
        }else{
            $('.round_time').text('');
            $('.round_per_day').text('');
            $('.ton_day_per_truck').text('');
            $('.recommended_trucks').text('');
            $('.cal_trucking_total_price').text('0');
            $('.trucking_cal_overhead_price').text('0');
            $('.trucking_cal_profit_price').text('0');
            //$('.cal_trucking_unit_price').text('0');
            $('#map_model').find('.total_trips').val('');
            $('.total_time_hours').val('');
            $(".save_trucking_estimation").addClass('ui-state-disabled');
            $(".save_trucking_estimation").attr('disabled',true);
            $('.show_map,.item_trucking_total_edit_icon').hide();
        }
        $(".plantSelect").select2();
        $(".dumpSelect").select2(); 
    }


    $(document).on("click",".edit_child_round_time",function() {

        $('.round_time').hide();
        $('.cancle_edit_child_round_time').show();
        $('.edit_child_round_time').hide();
    });
    $(document).on("click",".cancle_edit_child_round_time",function() {

        $('.round_time,.edit_child_round_time').show();
        $('.cancle_edit_child_round_time').hide();
        
    });
    
    $(document).on("change",".child_custom_round_time",function() {
        custom_price_total =false;

        $('.round_time').text($( ".child_custom_round_time option:selected" ).text());
        $('.round_time').show();
        $('.cancle_edit_child_round_time').hide();
        
        calculate_trucking_type2(calculator_form_id,false,false,false,false,false,true);
        
    });

    
    $(".cal_trucking_oh, .cal_trucking_pm").keyup(function() {
        //var form_id = $(this).closest('form').attr('id');
        //calculate_trucking_type2(form_id);
        calculate_measurement();
    })

function reset_trucking_var(){
    cal_trucking_oh='';
    cal_trucking_pm='';
    cal_trucking_oh_Price='';
    cal_trucking_pm_Price='';
    cal_trucking_total_Price='';
}

$(".addCustomItem").click(function() {
    if(unsaved_row){
            swal(
                'You have an unsaved item',
                'Please save or clear item to continue'
            );


    }else{
        has_custom_sep_total_price_update =false;
        $(".custome_item_overhead").val(service_overhead_rate);
        $(".custome_item_profit").val(service_profit_rate);
            $('#custom_item_type').val($(this).data('type-name'));
            if($(this).data('type-name')=='fees'){
                $('.custom_unit_price_label').text('Price');
                $('.add_custom_item_model_title_service').text('Services');
                $('.add_custom_item_model_title_type').text('Fees');
                $('.add_custom_item_model_title_item').text('Fee Item');
                //$('.custom_item_calculator_item_type').text('Services / Fees / Fee Item');
            }else if($(this).data('type-name')=='permit'){
                $('.custom_unit_price_label').text('Price');
                $('.add_custom_item_model_title_service').text('Services');
                $('.add_custom_item_model_title_type').text('Permits');
                $('.add_custom_item_model_title_item').text('Permit Item');
                //$('.custom_item_calculator_item_type').text('Services / Permits / Permit Item');
            }else{
                $('.add_custom_item_model_title_service').text('Custom');
                $('.add_custom_item_model_title_type').text('Custom Items ');
                $('.add_custom_item_model_title_item').text('Custom Item');
                $('.custom_unit_price_label').text('Base Unit Price');
                //$('.custom_item_calculator_item_type').text('Custom / Custom Items / Custom Item');
            }
            $('.if_error_show_msg,.if_edit_custom_item_total_price').hide();
             $('.if_not_edit_custom_item_total_price').show();
            
            $('.error').removeClass('error');
            $('.select_box_error').removeClass('select_box_error');
            $('.select2_box_error').removeClass('select2_box_error');
            $('#custom_item_name').val('');
            $('#custom_item_unit_price').val('');
            $('#custom_item_quantity').val('');
            $('#custom_item_notes').val('');
            $('.custome_item_unit_price_text').text('');
            $('.custome_item_overhead_price').text('');
            $('.custome_item_profit_price').text('');
            $('.custom_item_total_price').text('0');
            $('.custome_tax_amount').text('');
            $('.custome_tax_rate').hide();
            $('.custome_tax_checkbox').prop("checked",false);
            $('#custom_work_order').prop("checked",true);
            $('.custome_tax_checkbox_tr div span').removeClass('checked');
            
            $(".custom_cal_overhead_profit_checkbox").find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
            $('.show_custom_overhead_and_profit').hide();
            $("#continue3").show();
            $('#continue3').attr('onclick','save_custom_item("")');
            $("#continue3").addClass('ui-state-disabled');
            $("#continue3").attr('disabled',true);
            var services_html = $('#service_'+proposal_service_id).html();
            $('#service_html_box2').html(services_html);
            round_off_masking();
            var services_title = $('#service_'+proposal_service_id+' .service_title_name').text();
            var phase_title = $('#service_'+proposal_service_id+' .phase_name_'+phase_id).text();
            $('#service_html_box2').find('a').not('.cancel_field_save').remove();
           // $('#service_html_box2 ul li:last').remove();
           // $('#service_html_box2 ul .add_phase_li').remove();
           // $('#service_html_box2 ul .specification_sep').remove();
            $('#service_html_box2 ul .service_specifications').show();
            // $('#service_html_box2 ul li:last').remove();
            // $('#service_html_box2 ul li:last').remove();
            // $('#service_html_box2 ul li:last').remove();
            // $('#service_html_box2 ul li:last').remove();
            // $('#service_html_box2 ul li:last').remove();
            // $('#service_html_box2 ul li:last').remove();
            $('#service_html_box2 ul hr').remove();

            $( "#service_html_box2 ul li" ).not( ".service_specifications" ).remove();
            
            $('#service_html_box2 ul').addClass('pad0');
            $('#service_html_box2 ul').find('.set_loader_phase').remove();
            
            
            $("#add_custom_item_model").dialog('option','title',services_title+' | '+phase_title).dialog('open');
            $.uniform.update()
            $( ".custom_cal_overhead_profit_checkbox" ).trigger( "click" ); 
            $('.if_custom_item_saved').hide();
    }
});

$(".addSubcontractorsItem").click(function() {
    if(unsaved_row){
            swal(
                'You have an unsaved item',
                'Please save or clear item to continue'
            );


    }else{
            has_sub_sep_total_price_update = false;
            custom_tr_id='';
            $('.if_error_show_msg,.if_custom_item_saved,.if_edit_sub_item_total_price,.custom_sub_name_tr').hide();
           
             $('.if_not_edit_sub_item_total_price').show();
            $('.error').removeClass('error');
            $('.select_box_error').removeClass('select_box_error');
            $('.select2_box_error').removeClass('select2_box_error');
            $('#subcontractors_custom_name').val('');
            $('#subcontractors_item_unit_price').val('');
            $('.subcontractors_id').val(1);
            //$('#custom_item_quantity').val('');
            $('#subcontractors_item_notes').val('');
            if(oh_pm_type==2){
                $('.subcontractors_item_overhead').val(<?=$settings->getDefaultOverhead();?>);
                $('.subcontractors_item_profit').val(<?=$settings->getDefaultProfit();?>);
            }else{
                $('.subcontractors_item_overhead').val(service_overhead_rate);
                $('.subcontractors_item_profit').val(service_profit_rate);
            }
            $('.subcontractors_item_overhead_price').text('');
            $('.subcontractors_item_profit_price').text('');
            $('.subcontractors_item_total_price').text('0');
            $('.subcontractors_tax_amount').text('');
            $('.subcontractors_tax_rate').hide();
            $('.subcontractors_tax_checkbox').prop("checked",false);
            $('.subcontractors_tax_checkbox_tr div span').removeClass('checked');
            var services_title = $('#service_'+proposal_service_id+' .service_title_name').text();
            var phase_title = $('#service_'+proposal_service_id+' .phase_name_'+phase_id).text();
            $("#add_sub_contractors_item_model").dialog('option', 'title', services_title+' | '+phase_title);
            $("#add_sub_contractors_item_model").dialog('open');
            $(".subcontractors_cal_overhead_profit_checkbox").find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
            $('.show_subcontractors_overhead_and_profit').hide();
            $('#savesubcontractors').attr('onclick','save_subcontractors_item("")');
            $("#savesubcontractors").addClass('ui-state-disabled');
            $("#savesubcontractors").attr('disabled',true);
            var services_html = $('#service_'+proposal_service_id).html();
            $('#service_html_box8').html(services_html);
            round_off_masking();
            var services_title = $('#service_'+proposal_service_id+' .service_title_name').text();
            var phase_title = $('#service_'+proposal_service_id+' .phase_name_'+phase_id).text();
            $('#service_html_box8').find('a').not('.cancel_field_save').remove();
            $('#service_html_box8 ul li:last').remove();
            $('#service_html_box8 ul .add_phase_li').remove();
            $('#service_html_box8 ul .specification_sep').remove();
            $('#service_html_box8 ul .service_specifications').show();
            $('#service_html_box8 ul li:last').remove();
            $('#service_html_box8 ul li:last').remove();
            $('#service_html_box8 ul li:last').remove();
            $('#service_html_box8 ul li:last').remove();
            $('#service_html_box8 ul li:last').remove();
            $('#service_html_box8 ul hr').remove();
            $('#service_html_box8 ul').addClass('pad0');
            $('#service_html_box8 ul').find('.set_loader_phase').remove();
            $.uniform.update();
            //$('.custom_item_calculator_heading').text(services_title+' | '+phase_title);
    }
});
$(".custom_child_check").click(function() {
    if($("#continue2").is("[disabled=disabled]")){
        swal(
                'Please complete calculation to continue',
                ''
            );
    }else{
        child_lineItemId ='';
        calculation_id ='';
        has_custom_custom_total_price_update =false;
        $(".custome_child_item_overhead").val(service_overhead_rate);
        $(".custome_child_item_profit").val(service_profit_rate);
        
        
            $('.save_estimation').hide();
            $('.if_error_show_msg').hide();
            $('.error').removeClass('error');
            $('.if_not_edit_custom_item_total_price,.save_custom_estimation').show();
            $('.custom_custom_total_price_input,.if_edit_custom_item_total_price,.item_custom_total_edit_icon').hide();
            $('.cal_trucking_total_price_lable').text('Total Price');
            $('#add_custom_child_item_form').find('.custome_child_item_overhead_price').closest('tr').css('color','#444444');
            $('#add_custom_child_item_form').find('.custome_child_item_overhead').css('color','#444444');
            $('#add_custom_child_item_form').find('.custome_child_item_profit_price').closest('tr').css('color','#444444');
            $('#add_custom_child_item_form').find('.custome_child_item_profit').css('color','#444444');
            $('.select_box_error').removeClass('select_box_error');
            $('.select2_box_error').removeClass('select2_box_error');
            $('#custom_child_item_name').val('');
            $('#custom_child_item_unit_price').val('');
            $('#custom_child_item_quantity').val('');
            $('#custom_child_item_notes').val('');
            $('.custome_child_item_unit_price_text').text('');
            $('.custome_child_item_overhead_price').text('');
            $('.custome_child_item_profit_price').text('');
            $('.custom_child_item_total_price').text('0');
            $('.custome_child_tax_amount').text('');
            $('.custome_child_tax_rate').hide();
            $('.custome_child_tax_checkbox').prop("checked",false);
            $('#child_custom_work_order').prop("checked",true);
            $('.custome_child_tax_checkbox_tr div span').removeClass('checked');
            
            $(".custom_child_cal_overhead_profit_checkbox").find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
            $('.show_custom_child_overhead_and_profit').hide();
           
            $("#custom_child_save_btn").addClass('ui-state-disabled');
            $("#custom_child_save_btn").attr('disabled',true);
            
            round_off_masking();
            $.uniform.update()
            var services_title = $('#service_'+proposal_service_id+' .service_title_name').text();
            var phase_title = $('#service_'+proposal_service_id+' .phase_name_'+phase_id).text();
           
            //$('.custom_child_item_calculator_heading').text(services_title+' | '+phase_title);
            //$('.parant_item_name').find('.calculatorHeadingCategory').text(categoryName);
            //$('.parant_item_name').find('.calculatorHeadingType').text(typeName);
            //$('.parant_item_name').find('.calculatorHeadingItem').text(itemName);
            $("#add_custom_child_item_model").dialog('option','title',services_title+' | '+phase_title);
            $("#add_custom_child_item_model").dialog('open');
            $( ".custom_child_cal_overhead_profit_checkbox" ).trigger( "click" );
    }
});

$(".fees_child_check").click(function() {
    if($("#continue2").is("[disabled=disabled]")){
        swal(
                'Please complete calculation to continue',
                ''
            );
    }else{
        child_lineItemId ='';
        calculation_id ='';
        has_custom_fees_total_price_update =false;
        $(".fees_child_item_overhead").val(service_overhead_rate);
        $(".fees_child_item_profit").val(service_profit_rate);
       
       
        $('.if_not_edit_fees_item_total_price,.save_fees_child_estimation ').show();
        $('.custom_fees_total_price_input,.if_edit_fees_item_total_price,.item_fees_total_edit_icon').hide();
        $('.fees_child_item_total_price_lable').text('Total Price');
            $('.fees_child_item_overhead_price').closest('tr').css('color','#444444');
            $('.fees_child_item_overhead').css('color','#444444');
            $('.fees_child_item_profit_price').closest('tr').css('color','#444444');
            $('.fees_child_item_profit').css('color','#444444');
            $('.save_estimation').hide();
            $('.if_error_show_msg').hide();
            $('.error').removeClass('error');
            $('.select_box_error').removeClass('select_box_error');
            $('.select2_box_error').removeClass('select2_box_error');
            $('#fees_child_item_name').val('');
            $('#fees_child_item_unit_price').val('');
            $('#fees_child_item_quantity').val('1');
            $('#fees_child_item_notes').val('');
            $('.fees_child_item_unit_price_text').text('');
            $('.fees_child_item_overhead_price').text('');
            $('.fees_child_item_profit_price').text('');
            $('.fees_child_item_total_price').text('0');
            $('.fees_child_tax_amount').text('');
            $('.fees_child_tax_rate').hide();
            $('.fees_child_tax_rate').val('0');
            $('.fees_child_tax_checkbox').prop("checked",false);
            $('#child_fees_work_order').prop("checked",true);
            $('.fees_child_tax_checkbox_tr div span').removeClass('checked');
            if($(this).data('type')=='fees'){
                var newTitle = 'Add Fees';
                var temp_it_type = 'Fees Item';
                $('#is_fees_type').val(1); 
            }else{
                var newTitle = 'Add Permit';
                var temp_it_type = 'Permit Item';
                $('#is_fees_type').val(0); 
            }
           
            $(".fees_type_name").text(temp_it_type);
            $(".custom_child_cal_overhead_profit_checkbox").find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
            $('.show_custom_child_overhead_and_profit').hide();
           
            $("#fees_child_save_btn").addClass('ui-state-disabled');
            $("#fees_child_save_btn").attr('disabled',true);
            
            round_off_masking();
            $.uniform.update()
            var services_title = $('#service_'+proposal_service_id+' .service_title_name').text();
            var phase_title = $('#service_'+proposal_service_id+' .phase_name_'+phase_id).text();

            $("#add_fees_child_item_model").dialog('option','title',services_title+' | '+phase_title).dialog('open');
            $( ".custom_child_cal_overhead_profit_checkbox" ).trigger( "click" );
    }
});

$(document).on("keyup",".custome_child_item_profit,.custome_child_item_overhead,.custome_child_tax_rate,#custom_child_item_unit_price,#custom_child_item_quantity,#custom_child_item_name,#custom_child_item_notes",function() {
    unsave_cal=true;  
    var custom_child_item_unit_price = cleanNumber($(this).closest('form').find('#custom_child_item_unit_price').val());
    var custom_child_item_quantity = cleanNumber($(this).closest('form').find('#custom_child_item_quantity').val());
    var custome_child_item_overhead = cleanNumber($(this).closest('form').find('.custome_child_item_overhead').val());
    var custome_child_item_profit = cleanNumber($(this).closest('form').find('.custome_child_item_profit').val());
    var custome_child_tax_rate = cleanNumber($(this).closest('form').find('.custome_child_tax_rate').val());
    var custom_child_item_name = $('#custom_child_item_name').val();
    revert_custom_custom_item_total();
    if(custom_child_item_unit_price && custom_child_item_unit_price>0 && custom_child_item_quantity && custom_child_item_quantity>0 && custom_child_item_name){
                                $("#custom_child_save_btn").removeClass('ui-state-disabled');
                                $("#custom_child_save_btn").attr('disabled',false);
                                $(".item_custom_total_edit_icon").show();
                            
                        }else{
                                $("#custom_child_save_btn").addClass('ui-state-disabled');
                                $("#custom_child_save_btn").attr('disabled',true);
                                $(".item_custom_total_edit_icon").hide();
                        }
    custom_child_item_overhead_profit_calculation(custom_child_item_unit_price,custom_child_item_quantity,custome_child_item_overhead,custome_child_item_profit,custome_child_tax_rate);
        
});
function custom_child_item_overhead_profit_calculation(custom_child_item_unit_price,custom_child_item_quantity,custome_child_item_overhead,custome_child_item_profit,custome_child_tax_rate){
        var tempoverheadPrice = ((custom_child_item_unit_price * custome_child_item_overhead) / 100);
        
        var tempprofitPrice = ((custom_child_item_unit_price * custome_child_item_profit) / 100);
        var custome_child_item_unit_price_text = parseFloat(custom_child_item_unit_price) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);
        if(custome_child_item_unit_price_text>0){
            $('.custome_child_item_unit_price_text').text('$'+addCommas(number_test(custome_child_item_unit_price_text)));
        }else{
            $('.custome_child_item_unit_price_text').text('$0.00');
        }
        
        tempoverheadPrice = tempoverheadPrice * custom_child_item_quantity;
        tempprofitPrice = tempprofitPrice * custom_child_item_quantity;
        var custom_child_total = custom_child_item_unit_price * custom_child_item_quantity;
        
        var totalPrice = parseFloat(custom_child_total) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);
           

        var temptaxPrice = ((totalPrice * custome_child_tax_rate) / 100);

       
        $('.custome_child_tax_amount').text('$'+addCommas(number_test(temptaxPrice)));
            
        totalPrice = parseFloat(totalPrice) + parseFloat(temptaxPrice);
        $(".custome_child_item_overhead_price").text('$'+addCommas(number_test(tempoverheadPrice)));
        $(".custome_child_item_profit_price").text('$'+addCommas(number_test(tempprofitPrice)));
        $(".custom_child_item_total_price").text(addCommas(number_test(totalPrice)));
}

$(document).on("keyup",".fees_child_item_profit,.fees_child_item_overhead,.fees_child_tax_rate,#fees_child_item_unit_price,#fees_child_item_quantity",function() {
    unsave_cal=true;  
    var fees_child_item_unit_price = cleanNumber($(this).closest('form').find('#fees_child_item_unit_price').val());
    var fees_child_item_quantity = cleanNumber($(this).closest('form').find('#fees_child_item_quantity').val());
    var fees_child_item_overhead = cleanNumber($(this).closest('form').find('.fees_child_item_overhead').val());
    var fees_child_item_profit = cleanNumber($(this).closest('form').find('.fees_child_item_profit').val());
    var fees_child_tax_rate = cleanNumber($(this).closest('form').find('.fees_child_tax_rate').val());
    var fees_child_item_name = $('#fees_child_item_name').val();

    //$('.cancel_edit_fees_item_total').trigger('click');
    revert_fees_custom_item_total();
    if(fees_child_item_unit_price && fees_child_item_unit_price>0 && fees_child_item_quantity && fees_child_item_quantity>0 && fees_child_item_name){
                                $("#fees_child_save_btn").removeClass('ui-state-disabled');
                                $("#fees_child_save_btn").attr('disabled',false);
                                $(".item_fees_total_edit_icon").show();
                            
                        }else{
                                $("#fees_child_save_btn").addClass('ui-state-disabled');
                                $("#fees_child_save_btn").attr('disabled',true);
                                $(".item_fees_total_edit_icon").hide();
                        }
    fees_child_item_overhead_profit_calculation(fees_child_item_unit_price,fees_child_item_quantity,fees_child_item_overhead,fees_child_item_profit,fees_child_tax_rate);
        
});
function fees_child_item_overhead_profit_calculation(fees_child_item_unit_price,fees_child_item_quantity,fees_child_item_overhead,fees_child_item_profit,fees_child_tax_rate){
        var tempoverheadPrice = ((fees_child_item_unit_price * fees_child_item_overhead) / 100);
        
        var tempprofitPrice = ((fees_child_item_unit_price * fees_child_item_profit) / 100);
        var fees_child_item_unit_price_text = parseFloat(fees_child_item_unit_price) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);
        if(fees_child_item_unit_price_text>0){
            $('.fees_child_item_unit_price_text').text('$'+addCommas(number_test(fees_child_item_unit_price_text)));
        }else{
            $('.fees_child_item_unit_price_text').text('$0.00');
        }
        
        tempoverheadPrice = tempoverheadPrice * fees_child_item_quantity;
        tempprofitPrice = tempprofitPrice * fees_child_item_quantity;
        var fees_child_total = fees_child_item_unit_price * fees_child_item_quantity;
        
        var totalPrice = parseFloat(fees_child_total) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);
           

        var temptaxPrice = ((totalPrice * fees_child_tax_rate) / 100);

       
        $('.fees_child_tax_amount').text('$'+addCommas(number_test(temptaxPrice)));
            
        totalPrice = parseFloat(totalPrice) + parseFloat(temptaxPrice);
        $(".fees_child_item_overhead_price").text('$'+addCommas(number_test(tempoverheadPrice)));
        $(".fees_child_item_profit_price").text('$'+addCommas(number_test(tempprofitPrice)));
        $(".fees_child_item_total_price").text(addCommas(number_test(totalPrice)));
}

$(document).on("keyup",".custome_item_profit,.custome_item_overhead,.custome_tax_rate,#custom_item_unit_price,#custom_item_quantity,#custom_item_name,#custom_item_notes",function() {
    unsave_cal=true;
    custom_price_total =false;
    var custom_item_unit_price = cleanNumber($(this).closest('form').find('#custom_item_unit_price').val());
    var custom_item_quantity = cleanNumber($(this).closest('form').find('#custom_item_quantity').val());
    var custome_item_overhead = cleanNumber($(this).closest('form').find('.custome_item_overhead').val());
    var custome_item_profit = cleanNumber($(this).closest('form').find('.custome_item_profit').val());
    var custome_tax_rate = cleanNumber($(this).closest('form').find('.custome_tax_rate').val());
    var custom_item_name = $('#custom_item_name').val();
    var custom_item_notes = $('#custom_item_notes').val();

    if(custom_item_unit_price && custom_item_unit_price>0 && custom_item_quantity && custom_item_quantity>0 && custom_item_name){
            $("#continue3").removeClass('ui-state-disabled');
            $("#continue3").attr('disabled',false);
        
    }else{
            $("#continue3").addClass('ui-state-disabled');
            $("#continue3").attr('disabled',true);
    }
                        
    custom_item_overhead_profit_calculation(custom_item_unit_price,custom_item_quantity,custome_item_overhead,custome_item_profit,custome_tax_rate);
        var old_custom_item_quantilty = cleanNumber($('#'+custom_tr_id).find('.edit_custom_item').data('estimate-quantity'));
        var old_custom_item_name = $('#'+custom_tr_id).find('.edit_custom_item').data('estimate-item-name');
        var old_custom_item_price = $('#'+custom_tr_id).find('.edit_custom_item').data('estimate-base-price');
        var old_custom_item_notes = $('#'+custom_tr_id).find('.edit_custom_item').data('estimate-item-notes');
        var old_custom_item_total = $('#'+custom_tr_id).find('.edit_custom_item').data('estimate-total-price');
        var new_total = cleanNumber($(".custom_item_total_price ").text());
        
        if(new_total ==old_custom_item_total && parseFloat(custom_item_unit_price).toFixed(2) == old_custom_item_price && parseFloat(custom_item_quantity).toFixed(2) ==old_custom_item_quantilty && custom_item_name == old_custom_item_name && custom_item_notes ==old_custom_item_notes){
            
             //if(custom_price_total || saved_custom_price==0){
                
                $('.if_custom_item_saved').show();
                $('#continue3').hide();
            //  }else{
                 
            //      $('.if_custom_item_saved').hide();
            //      $('#continue3').show();
            //  }
            
        }else{
            $('.if_custom_item_saved').hide();
            $('#continue3').show();
        }
});

function custom_item_overhead_profit_calculation(custom_item_unit_price,custom_item_quantity,custome_item_overhead,custome_item_profit,custome_tax_rate){
        var tempoverheadPrice = ((custom_item_unit_price * custome_item_overhead) / 100);
        
        var tempprofitPrice = ((custom_item_unit_price * custome_item_profit) / 100);
        var custome_item_unit_price_text = parseFloat(custom_item_unit_price) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);
       if(!custome_item_unit_price_text){
        custome_item_unit_price_text ='0';
       }
        $('.custome_item_unit_price_text').text('$'+addCommas(number_test(custome_item_unit_price_text)));
        tempoverheadPrice = tempoverheadPrice * custom_item_quantity;
        tempprofitPrice = tempprofitPrice * custom_item_quantity;
        var custom_total = custom_item_unit_price * custom_item_quantity;
        
        var totalPrice = parseFloat(custom_total) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);
           

        var temptaxPrice = ((totalPrice * custome_tax_rate) / 100);

       
        $('.custome_tax_amount').text('$'+addCommas(number_test(temptaxPrice)));
            
        totalPrice = parseFloat(totalPrice) + parseFloat(temptaxPrice);
        
        $(".custome_item_overhead_price").text('$'+addCommas(number_test(tempoverheadPrice)));
        $(".custome_item_profit_price").text('$'+addCommas(number_test(tempprofitPrice)));
        $(".custom_item_total_price").text(addCommas(number_test(totalPrice)));
        
        
}


$(document).on("keyup","#subcontractors_id,#subcontractors_item_notes,#subcontractors_item_unit_price,.subcontractors_tax_rate,.subcontractors_item_overhead,.subcontractors_item_profit,#subcontractors_custom_name",function() {
    unsave_cal=true;  
    
    var subcontractors_item_unit_price = cleanNumber($(this).closest('form').find('#subcontractors_item_unit_price').val());
    var subcontractors_item_overhead = cleanNumber($(this).closest('form').find('.subcontractors_item_overhead').val());
    var subcontractors_item_profit = cleanNumber($(this).closest('form').find('.subcontractors_item_profit').val());
    var subcontractors_item_tax_rate = cleanNumber($(this).closest('form').find('.subcontractors_tax_rate').val());
    var custom_sub_id = $(this).closest('form').find('.subcontractors_id').val();
    var custom_item_notes = $(this).closest('form').find('#subcontractors_item_notes').val();

    var sub_name = $(this).closest('form').find('#subcontractors_custom_name').val();
    var sub_check =true;
    if(custom_sub_id==0){
        sub_check =false;
        if(sub_name && sub_name.length>0){
            var sub_check =true;
        }
    }
    if(subcontractors_item_unit_price && subcontractors_item_unit_price>0 && sub_check){
                
                $("#savesubcontractors").removeClass('ui-state-disabled');
                $("#savesubcontractors").attr('disabled',false);
            
        }else{
                $("#savesubcontractors").addClass('ui-state-disabled');
                $("#savesubcontractors").attr('disabled',true);
        }
    subcontractors_item_overhead_profit_calculation(subcontractors_item_unit_price,subcontractors_item_overhead,subcontractors_item_profit,subcontractors_item_tax_rate);

        if(custom_tr_id){
            var old_custom_sub_id = $('#'+custom_tr_id).find('.edit_sub_con_item').data('estimate-sub-id');
            var old_custom_item_price = $('#'+custom_tr_id).find('.edit_sub_con_item').data('estimate-base-price');
            var old_custom_item_notes = $('#'+custom_tr_id).find('.edit_sub_con_item').data('estimate-item-notes');

            var old_custom_item_total = $('#'+custom_tr_id).find('.edit_sub_con_item').data('estimate-total-price');
            var new_total = cleanNumber($(".subcontractors_item_total_price").text());

            if(new_total ==old_custom_item_total && parseFloat(subcontractors_item_unit_price).toFixed(2) == old_custom_item_price && custom_sub_id == old_custom_sub_id && custom_item_notes ==old_custom_item_notes){
            //     console.log('checkccc');
                $('.if_custom_item_saved').show();
                $('#savesubcontractors').hide();
            }else{
                
                $('.if_custom_item_saved').hide();
                $('#savesubcontractors').show();
            }
        }else{
            $('.if_custom_item_saved').hide();
            $('#savesubcontractors').show();
        }
        
});

function subcontractors_item_overhead_profit_calculation(subcontractors_item_unit_price,subcontractors_item_overhead,subcontractors_item_profit,subcontractors_item_tax_rate){
        if(!subcontractors_item_unit_price){
            subcontractors_item_unit_price =0;
        }
        var tempoverheadPrice = ((subcontractors_item_unit_price * subcontractors_item_overhead) / 100);
        
        var tempprofitPrice = ((subcontractors_item_unit_price * subcontractors_item_profit) / 100);
        var custome_item_unit_price_text = parseFloat(subcontractors_item_unit_price) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);
       if(!custome_item_unit_price_text){
        custome_item_unit_price_text ='0';
       }
        $('.subcontractors_item_unit_price_text').text('$'+addCommas(number_test(custome_item_unit_price_text)));
        
        var custom_total = subcontractors_item_unit_price;
        
        var totalPrice = parseFloat(custom_total) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);
           

        var temptaxPrice = ((totalPrice * subcontractors_item_tax_rate) / 100);

       
        $('.subcontractors_tax_amount').text('$'+addCommas(number_test(temptaxPrice)));
            
        totalPrice = parseFloat(totalPrice) + parseFloat(temptaxPrice);
        $(".subcontractors_item_overhead_price").text('$'+addCommas(number_test(tempoverheadPrice)));
        $(".subcontractors_item_profit_price").text('$'+addCommas(number_test(tempprofitPrice)));
        $(".subcontractors_item_total_price").text(addCommas(number_test(totalPrice)));
}

function save_subcontractors_item(estimate_line_id){

    swal({
            title: 'Saving..',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timer: 2000,
            onOpen: () => {
            swal.showLoading();
            }
        });
    var subcontractors_item_unit_price = cleanNumber($('#add_sub_contractors_item_form').find('#subcontractors_item_unit_price').val());
    var subcontractors_item_overhead = cleanNumber($('#add_sub_contractors_item_form').find('.subcontractors_item_overhead').val());
    var subcontractors_item_profit = cleanNumber($('#add_sub_contractors_item_form').find('.subcontractors_item_profit').val());
    var subcontractors_item_tax_rate = cleanNumber($('#add_sub_contractors_item_form').find('.subcontractors_tax_rate').val());
    
    var subcontractors_item_notes = cleanNumber($('#add_sub_contractors_item_form').find('#subcontractors_item_notes').val());
    var subcontractors_tax_amount = cleanNumber($('.subcontractors_tax_amount').text());
    var subcontractors_id = cleanNumber($('#add_sub_contractors_item_form').find('.subcontractors_id').val());
    var is_custom_subcontractor =0;
    var custom_name = '';
    if(subcontractors_id==0){
        is_custom_subcontractor =1;
         custom_name = $('#subcontractors_custom_name').val();
    }
    var subcontractors_item_quantity = 1;
    
    var subcontractors_tax_amount = cleanNumber($('.subcontractors_tax_amount').text());
    //var custom_item_name = $('#custom_item_name').val();
    var subcontractors_item_notes = $('#subcontractors_item_notes').val();
    var tempoverheadPrice = ((subcontractors_item_unit_price * subcontractors_item_overhead) / 100);
    var tempprofitPrice = ((subcontractors_item_unit_price * subcontractors_item_profit) / 100);
    var custome_item_unit_price_text = cleanNumber($('.subcontractors_item_unit_price_text').text());
        //$('.custome_item_unit_price_text').text('$'+addCommas(number_test(custome_item_unit_price_text)));
        tempoverheadPrice = tempoverheadPrice * subcontractors_item_quantity;
        tempprofitPrice = tempprofitPrice * subcontractors_item_quantity;
    var custom_total = subcontractors_item_unit_price * subcontractors_item_quantity;
        
    var totalPrice = parseFloat(custom_total) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice)+ parseFloat(subcontractors_tax_amount);
    var subcontractors_work_order = 0;
    if($('#subcontractors_work_order').prop("checked")){
        subcontractors_work_order = 1;
    }else{
        subcontractors_work_order = 0;
    }
    var lineItems =[];
    lineItems.push({
                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                'customUnitPrice':0,
                'proposalServiceId':proposal_service_id,
                'id':estimate_line_id,
                'itemId':0,
                'PhaseId':phase_id,
                'quantity':subcontractors_item_quantity,
                'unitPrice':custome_item_unit_price_text,
                'totalPrice':totalPrice,
                'overHeadRate':subcontractors_item_overhead,
                'profitRate':subcontractors_item_profit,
                'overHeadPrice':tempoverheadPrice,
                'profitPrice':tempprofitPrice,
                'basePrice':subcontractors_item_unit_price,
                'taxRate':subcontractors_item_tax_rate,
                'taxPrice':subcontractors_tax_amount,
                'truckingOverHeadRate': 0,
                'truckingProfitRate': 0,
                'truckingOverHeadPrice': 0,
                'truckingProfitPrice': 0,
                'truckingTotalPrice': 0,
                'customName':custom_name,
                'notes':subcontractors_item_notes,
                'sub_id':subcontractors_id,
                'is_custom_sub':is_custom_subcontractor,
                'child_material':'0',
                'work_order':subcontractors_work_order
            });

            $.ajax({
            url: '/ajax/saveEstimateLineItems/',
            type: 'post',
            data: {
                'lineItems':lineItems,
                'proposalServiceId':proposal_service_id,
                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                'PhaseId':phase_id,
                'apply':0,
            },
            success: function(data){
                unsave_cal=false;
                try{
                        data = JSON.parse(data);
                    } catch (e) {
                        swal("Error", "An error occurred Please try again");
                        return false;
                    }
                $("#add_sub_contractors_item_model").dialog('close');
                  
                  
                get_sub_contractors_items();
                get_proposal_breakdown();

                
                //update_proposal_overhead_profit();
                
                if(data.estimate.completed==0){
                    $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                }else{
                    $('#service_'+proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                }
                if(data.estimate.child_has_updated_flag==0 ){
                    $('.service_child_has_updated_flag_'+proposal_service_id).hide();
                    $('#service_'+proposal_service_id+' .toggle').addClass('text-active-color').removeClass('text-active-color2');
                    $('#service_'+proposal_service_id+' .toggle').css('background-color','#aeaeae');
                }
                
                $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                
                $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                swal(
                    'Subcontractors Item Saved',
                    ''
                );
                if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }

                if(has_sub_sep_total_price_update){
                    update_sub_itam_total_save('add_sub_contractors_item_model',data.lineItemId);
                }
            }, 
            error: function( jqXhr, textStatus, errorThrown ){
                        swal("Error", "An error occurred Please try again");
                        console.log( errorThrown );
                    }
            });

}


function save_custom_item(estimate_line_id){
    swal({
            title: 'Saving..',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timer: 2000,
            onOpen: () => {
            swal.showLoading();
            }
        });
    var custom_item_unit_price = cleanNumber($('#custom_item_unit_price').val());
    var custom_item_quantity = cleanNumber($('#custom_item_quantity').val());
    var custome_item_overhead = cleanNumber($('.custome_item_overhead').val());
    var custome_item_profit = cleanNumber($('.custome_item_profit').val());
    var custome_tax_rate = cleanNumber($('.custome_tax_rate').val());
    var custom_tax_amount = cleanNumber($('.custome_tax_amount').text());
    var custom_item_name = $('#custom_item_name').val();
    var custom_item_notes = $('#custom_item_notes').val();
    var custom_work_order = 0;
    if($('#custom_work_order').prop("checked")){
         custom_work_order = 1;
    }else{
         custom_work_order = 0;
    }

    var tempoverheadPrice = ((custom_item_unit_price * custome_item_overhead) / 100);
    var tempprofitPrice = ((custom_item_unit_price * custome_item_profit) / 100);
    var custome_item_unit_price_text = parseFloat(custom_item_unit_price) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);
        $('.custome_item_unit_price_text').text('$'+addCommas(number_test(custome_item_unit_price_text)));
        tempoverheadPrice = tempoverheadPrice * custom_item_quantity;
        tempprofitPrice = tempprofitPrice * custom_item_quantity;
    var custom_total = custom_item_unit_price * custom_item_quantity;
        
    var totalPrice = parseFloat(custom_total) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice)+ parseFloat(custom_tax_amount);
    var custom_item_type = $('#custom_item_type').val();
    if(custom_item_type=='fees'){
        var is_fees = 1;
        var is_permit = 0;
        var success_mgs = 'Fees Item Saved';
    }else if(custom_item_type=='permit'){
        var is_fees = 0;
        var is_permit = 1;
        var success_mgs = 'Permit Item Saved';
    }else if(custom_item_type=='custom'){
        var is_fees = 0;
        var is_permit = 0;
        var success_mgs = 'Custom Item Saved';
    }
    var lineItems =[];
    lineItems.push({
                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                'customUnitPrice':0,
                'proposalServiceId':proposal_service_id,
                'id':estimate_line_id,
                'itemId':0,
                'PhaseId':phase_id,
                'quantity':custom_item_quantity,
                'unitPrice':custome_item_unit_price_text,
                'totalPrice':totalPrice,
                'overHeadRate':custome_item_overhead,
                'profitRate':custome_item_profit,
                'overHeadPrice':tempoverheadPrice,
                'profitPrice':tempprofitPrice,
                'basePrice':custom_item_unit_price,
                'taxRate':custome_tax_rate,
                'taxPrice':custom_tax_amount,
                'truckingOverHeadRate': 0,
                'truckingProfitRate': 0,
                'truckingOverHeadPrice': 0,
                'truckingProfitPrice': 0,
                'truckingTotalPrice': 0,
                'customName':custom_item_name,
                'notes':custom_item_notes,
                'sub_id':'0',
                'child_material':'0',
                'fees':is_fees,
                'permit':is_permit,
                'work_order':custom_work_order
            });

            $.ajax({
            url: '/ajax/saveEstimateLineItems/',
            type: 'post',
            data: {
                'lineItems':lineItems,
                'proposalServiceId':proposal_service_id,
                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                'PhaseId':phase_id,
                'apply':0,

            },
            success: function(data){
                try{
                    data = JSON.parse(data);
                } catch (e) {
                    swal("Error", "An error occurred Please try again");
                    return false;
                }
                unsave_cal=false;
                $("#add_custom_item_model").dialog('close');
                  
               get_custom_items();
                if(data.estimate.completed==0){
                    $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                }else{
                    $('#service_'+proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                }
                if(data.estimate.child_has_updated_flag==0 ){
                    $('.service_child_has_updated_flag_'+proposal_service_id).hide();
                    $('#service_'+proposal_service_id+' .toggle').addClass('text-active-color').removeClass('text-active-color2');
                    $('#service_'+proposal_service_id+' .toggle').css('background-color','#aeaeae');
                }
                
                $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                
                $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                swal(
                    success_mgs,
                    ''
                );
                if(has_custom_sep_total_price_update){
                    update_custom_itam_total_save('add_custom_item_form',data.lineItemId);
                }
            },
            error: function( jqXhr, textStatus, errorThrown ){
                swal("Error", "An error occurred Please try again");
                console.log( errorThrown );
                
            }
            });

}

function get_custom_items(){
    if(phase_id){
    var feesRowCount = ($("#fees_item_table tr").length)-1;
    var permitRowCount = ($("#permit_item_table tr").length)-1;
    $("#custom_item_table").find("tr:gt(0)").remove();
    $("#fees_item_table").find("tr:gt(0)").remove();
    $("#permit_item_table").find("tr:gt(0)").remove();
    $.ajax({
            url: '/ajax/getPhaseLineCustomItems',
            type: 'post',
            data: {
                'phaseId':phase_id,
                'proposal_service_id':proposal_service_id,
            },
            
            success: function(data){
                
                    data = JSON.parse(data);
                    check_phase = data.phase_complete;
                    feesLineItems = data.feesLineItems;
                    permitLineItems = data.permitLineItems;
                    data = data.lineItems;
                    var custom_table_total = 0;
                    for($i=0;$i<data.length;$i++){
                        if(parseFloat(data[$i]['profit_rate'])<0  || parseFloat(data[$i]['overhead_rate']) <0){
                            var icon = '<i class="fa fa-exclamation-triangle tiptip" style="margin-right: 2px;" title="This item is priced below cost"></i>';
                            var css = 'color:red';
                        }else{
                           var icon ='';
                           var css = '';
                        }
                        if(<?php echo $proposal_status_id;?> == '5'){
                            var row = '<tr style="border-bottom: 1px solid rgb(255, 255, 255); '+css+'" class="has_item_value" id="custom_est_'+data[$i]['id']+'"><td style="width:20px"><span class="custom_items_checkbox"></span></td><td style="width:5px">'+icon+'</td><td><a class="btn tiptip edit_custom_item" data-item-type="custom" title="Calculate Quantity" data-estimate-item-notes="'+data[$i]['notes']+'" data-estimate-item-name="'+data[$i]['name']+'" data-estimate-quantity="'+data[$i]['quantity']+'"  data-estimate-base-price="'+data[$i]['base_price']+'" data-estimate-line-id="'+data[$i]['id']+'" data-custom-total-price="'+data[$i]['custom_total_price']+'" data-estimate-total-price="'+data[$i]['total_price']+'"><i class="fa fa-fw fa-calculator"></i></a></td><td>'+data[$i]['name']+'</td><td class="custom_item_unit_price">$'+data[$i]['unit_price']+'</td><td class="custom_item_quantity">'+Number(data[$i]['quantity'])+'</td><td style="text-align: right;">$<span class="custom_line_item_total_price" >'+addCommas(number_test(data[$i]['total_price']))+'</span></td><td><a href="JavaScript:void(0);" class="estimate_item_notes btn tiptip" title="Notes" ><i class="fa fa-clipboard"></i></a> <a href="javascript:void(0);" class="btn blue-button tiptip save_est_btn save_custom_item_line" title="Save Estimate"  style="margin-bottom:2px; display:none" >Save</a><a href="JavaScript:void(0);" class="undo_custom_item_line btn tiptip" title="Undo Changes" style="display:none;"><i class="fa fa-fw fa-undo"></i></a></td></tr>'
                        }else{
                            var row = '<tr style="border-bottom: 1px solid rgb(255, 255, 255); '+css+'" class="has_item_value" id="custom_est_'+data[$i]['id']+'"><td style="width:20px"><span class="custom_items_checkbox"><input type="checkbox" class="custom_item_delete_checkbox" name="custom_item_delete_checkbox" value="'+data[$i]['id']+'" id="custom_item_checkbox'+data[$i]['id']+'" /></span></td><td style="width:5px">'+icon+'</td><td><a class="btn tiptip edit_custom_item" data-item-type="custom" title="Calculate Quantity" data-estimate-item-notes="'+data[$i]['notes']+'" data-estimate-item-name="'+data[$i]['name']+'" data-estimate-quantity="'+data[$i]['quantity']+'"  data-estimate-base-price="'+data[$i]['base_price']+'" data-estimate-line-id="'+data[$i]['id']+'" data-custom-total-price="'+data[$i]['custom_total_price']+'" data-estimate-total-price="'+data[$i]['total_price']+'"><i class="fa fa-fw fa-calculator"></i></a></td><td>'+data[$i]['name']+'</td><td class="custom_item_unit_price">$'+data[$i]['unit_price']+'</td><td class="custom_item_quantity">'+Number(data[$i]['quantity'])+'</td><td style="text-align: right;">$<span class="custom_line_item_total_price" >'+addCommas(number_test(data[$i]['total_price']))+'</span></td><td><a href="JavaScript:void(0);" class="estimate_item_notes btn tiptip" title="Notes" ><i class="fa fa-clipboard"></i></a> <a href="JavaScript:void(0);" class="custom_line_item_delete btn tiptip" data-item-type="custom" title="Remove From Estimate"  data-estimate-line-id="'+data[$i]['id']+'"><i class="fa fa-fw fa-trash"></i></a><a href="javascript:void(0);" class="btn blue-button tiptip save_est_btn save_custom_item_line" title="Save Estimate"  style="margin-bottom:2px; display:none" >Save</a><a href="JavaScript:void(0);" class="undo_custom_item_line btn tiptip" title="Undo Changes" style="display:none;"><i class="fa fa-fw fa-undo"></i></a></td></tr>'
                        }
                        $('#custom_item_table tr:last').after(row);
                        custom_table_total = parseFloat(custom_table_total) + parseFloat(data[$i]['total_price'])
                    }
                    $('#custom_item_table').show();
                    $('#custom_heading_span').text(data.length);
                    $('.cat_service_count6').text(data.length);
                    if(custom_table_total>0){
                        $('.custom_table_total').text('$'+addCommas(number_test(custom_table_total)));
                    }else{
                        $('.custom_table_total').text('');
                    }
                    $('.cat_service_count6').attr('title','$'+addCommas(number_test(custom_table_total)));
                    
                    ///fees items
                    data = feesLineItems;
                    var fees_table_total = 0;
                    for($i=0;$i<data.length;$i++){

                        if(parseFloat(data[$i]['profit_rate'])<0  || parseFloat(data[$i]['overhead_rate']) <0){
                            var icon = '<i class="fa fa-exclamation-triangle tiptip" style="margin-right: 2px;" title="This item is priced below cost"></i>';
                            var css = 'color:red';
                        }else{
                           var icon ='';
                           var css = '';
                        }
                        if(<?php echo $proposal_status_id;?> == '5'){
                            var row = '<tr style="border-bottom: 1px solid rgb(255, 255, 255); '+css+'" class="has_item_value" id="custom_est_'+data[$i]['id']+'"><td style="width:20px"><span class="custom_items_checkbox"></span></td><td style="width:5px">'+icon+'</td><td><a class="btn tiptip edit_custom_item" data-item-type="fees" title="Calculate Quantity" data-estimate-item-notes="'+data[$i]['notes']+'" data-estimate-item-name="'+data[$i]['name']+'" data-estimate-quantity="'+data[$i]['quantity']+'"  data-estimate-base-price="'+data[$i]['base_price']+'" data-estimate-line-id="'+data[$i]['id']+'" data-custom-total-price="'+data[$i]['custom_total_price']+'" data-estimate-total-price="'+data[$i]['total_price']+'"><i class="fa fa-fw fa-calculator"></i></a></td><td>'+data[$i]['name']+'</td><td class="custom_item_unit_price">$'+data[$i]['unit_price']+'</td><td class="custom_item_quantity">'+data[$i]['quantity']+'</td><td style="text-align: right;">$<span class="custom_line_item_total_price" >'+addCommas(number_test(data[$i]['total_price']))+'</span></td><td><a href="JavaScript:void(0);" class="estimate_item_notes btn tiptip" title="Notes" ><i class="fa fa-clipboard"></i></a> <a href="javascript:void(0);" class="btn blue-button tiptip save_est_btn save_custom_item_line" title="Save Estimate"  style="margin-bottom:2px; display:none" >Save</a><a href="JavaScript:void(0);" class="undo_custom_item_line btn tiptip" title="Undo Changes" style="display:none;"><i class="fa fa-fw fa-undo"></i></a></td></tr>'
                        }else{
                            var row = '<tr style="border-bottom: 1px solid rgb(255, 255, 255); '+css+'" class="has_item_value" id="custom_est_'+data[$i]['id']+'"><td style="width:20px"><span class="custom_items_checkbox"><input type="checkbox" class="custom_item_delete_checkbox" name="custom_item_delete_checkbox" value="'+data[$i]['id']+'" id="custom_item_checkbox'+data[$i]['id']+'" /></span></td><td style="width:5px">'+icon+'</td><td><a class="btn tiptip edit_custom_item" title="Calculate Quantity" data-item-type="fees" data-estimate-item-notes="'+data[$i]['notes']+'" data-estimate-item-name="'+data[$i]['name']+'" data-estimate-quantity="'+data[$i]['quantity']+'"  data-estimate-base-price="'+data[$i]['base_price']+'" data-estimate-line-id="'+data[$i]['id']+'" data-custom-total-price="'+data[$i]['custom_total_price']+'" data-estimate-total-price="'+data[$i]['total_price']+'"><i class="fa fa-fw fa-calculator"></i></a></td><td>'+data[$i]['name']+'</td><td class="custom_item_unit_price">$'+data[$i]['unit_price']+'</td><td class="custom_item_quantity">'+data[$i]['quantity']+'</td><td style="text-align: right;">$<span class="custom_line_item_total_price" >'+addCommas(number_test(data[$i]['total_price']))+'</span></td><td><a href="JavaScript:void(0);" class="estimate_item_notes btn tiptip" title="Notes" ><i class="fa fa-clipboard"></i></a> <a href="JavaScript:void(0);" class="custom_line_item_delete btn tiptip" data-item-type="fees" title="Remove From Estimate"  data-estimate-line-id="'+data[$i]['id']+'"><i class="fa fa-fw fa-trash"></i></a><a href="javascript:void(0);" class="btn blue-button tiptip save_est_btn save_custom_item_line" title="Save Estimate"  style="margin-bottom:2px; display:none" >Save</a><a href="JavaScript:void(0);" class="undo_custom_item_line btn tiptip" title="Undo Changes" style="display:none;"><i class="fa fa-fw fa-undo"></i></a></td></tr>'
                        }
                        $('#fees_item_table tr:last').after(row);
                        fees_table_total = parseFloat(fees_table_total) + parseFloat(data[$i]['total_price'])
                    }
                    

                    $('#heading_span_41').text(data.length);
                    var tempfeescount = $('.cat_service_count5').text();
                    tempfeescount = parseFloat(tempfeescount) - parseFloat(feesRowCount);
                    tempfeescount = parseFloat(tempfeescount) + parseFloat(data.length);
                    
                    $('.cat_service_count5').text(tempfeescount);
                    var old_fees_table_total = cleanNumber($('.table_total_41').text());
                    if(fees_table_total>0){
                        $('.table_total_41').text('$'+addCommas(number_test(fees_table_total)));
                    }else{
                        $('.table_total_41').text('');
                    }
                    if($('.cat_service_count5').attr('data-val')){
                        var tempcount2 = cleanNumber($('.cat_service_count5').attr('data-val'));
                        if(old_fees_table_total >0){
                             tempcount2 = parseFloat(tempcount2) - parseFloat(old_fees_table_total);
                         }
                    }else{
                        var tempcount2 = 0;
                    }
                   
                    tempcount2 = parseFloat(tempcount2) + parseFloat(fees_table_total);
                    $('.cat_service_count5').attr('title','$'+addCommas(number_test(tempcount2)));
                    $('.cat_service_count5').attr('data-val',number_test(tempcount2));
                    

                    
                    ///permit items
                    data = permitLineItems;
                    var permit_table_total = 0;
                    for($i=0;$i<data.length;$i++){

                        if(parseFloat(data[$i]['profit_rate'])<0  || parseFloat(data[$i]['overhead_rate']) <0){
                            var icon = '<i class="fa fa-exclamation-triangle tiptip" style="margin-right: 2px;" title="This item is priced below cost"></i>';
                            var css = 'color:red';
                        }else{
                           var icon ='';
                           var css = '';
                        }
                        if(<?php echo $proposal_status_id;?> == '5'){
                            var row = '<tr style="border-bottom: 1px solid rgb(255, 255, 255); '+css+'" class="has_item_value" id="custom_est_'+data[$i]['id']+'"><td style="width:20px"><span class="custom_items_checkbox"></span></td><td style="width:5px">'+icon+'</td><td><a class="btn tiptip edit_custom_item" data-item-type="permit" title="Calculate Quantity" data-estimate-item-notes="'+data[$i]['notes']+'" data-estimate-item-name="'+data[$i]['name']+'" data-estimate-quantity="'+data[$i]['quantity']+'"  data-estimate-base-price="'+data[$i]['base_price']+'" data-estimate-line-id="'+data[$i]['id']+'" data-custom-total-price="'+data[$i]['custom_total_price']+'" data-estimate-total-price="'+data[$i]['total_price']+'"><i class="fa fa-fw fa-calculator"></i></a></td><td>'+data[$i]['name']+'</td><td class="custom_item_unit_price">$'+data[$i]['unit_price']+'</td><td class="custom_item_quantity">'+data[$i]['quantity']+'</td><td style="text-align: right;">$<span class="custom_line_item_total_price" >'+addCommas(number_test(data[$i]['total_price']))+'</span></td><td><a href="JavaScript:void(0);" class="estimate_item_notes btn tiptip" title="Notes" ><i class="fa fa-clipboard"></i></a> <a href="javascript:void(0);" class="btn blue-button tiptip save_est_btn save_custom_item_line" title="Save Estimate"  style="margin-bottom:2px; display:none" >Save</a><a href="JavaScript:void(0);" class="undo_custom_item_line btn tiptip" title="Undo Changes" style="display:none;"><i class="fa fa-fw fa-undo"></i></a></td></tr>'
                        }else{
                            var row = '<tr style="border-bottom: 1px solid rgb(255, 255, 255); '+css+'" class="has_item_value" id="custom_est_'+data[$i]['id']+'"><td style="width:20px"><span class="custom_items_checkbox"><input type="checkbox" class="custom_item_delete_checkbox" name="custom_item_delete_checkbox" value="'+data[$i]['id']+'" id="custom_item_checkbox'+data[$i]['id']+'" /></span></td><td style="width:5px">'+icon+'</td><td><a class="btn tiptip edit_custom_item" title="Calculate Quantity" data-item-type="permit" data-estimate-item-notes="'+data[$i]['notes']+'" data-estimate-item-name="'+data[$i]['name']+'" data-estimate-quantity="'+data[$i]['quantity']+'"  data-estimate-base-price="'+data[$i]['base_price']+'" data-estimate-line-id="'+data[$i]['id']+'" data-custom-total-price="'+data[$i]['custom_total_price']+'" data-estimate-total-price="'+data[$i]['total_price']+'"><i class="fa fa-fw fa-calculator"></i></a></td><td>'+data[$i]['name']+'</td><td class="custom_item_unit_price">$'+data[$i]['unit_price']+'</td><td class="custom_item_quantity">'+data[$i]['quantity']+'</td><td style="text-align: right;">$<span class="custom_line_item_total_price" >'+addCommas(number_test(data[$i]['total_price']))+'</span></td><td><a href="JavaScript:void(0);" class="estimate_item_notes btn tiptip" title="Notes" ><i class="fa fa-clipboard"></i></a> <a href="JavaScript:void(0);" class="custom_line_item_delete btn tiptip" data-item-type="permit" title="Remove From Estimate"  data-estimate-line-id="'+data[$i]['id']+'"><i class="fa fa-fw fa-trash"></i></a><a href="javascript:void(0);" class="btn blue-button tiptip save_est_btn save_custom_item_line" title="Save Estimate"  style="margin-bottom:2px; display:none" >Save</a><a href="JavaScript:void(0);" class="undo_custom_item_line btn tiptip" title="Undo Changes" style="display:none;"><i class="fa fa-fw fa-undo"></i></a></td></tr>'
                        }
                        $('#permit_item_table tr:last').after(row);
                        permit_table_total = parseFloat(permit_table_total) + parseFloat(data[$i]['total_price'])
                    }
                    
                    $('#heading_span_40').text(data.length);
                    var temppermitcount = $('.cat_service_count5').text();
                    temppermitcount = parseFloat(temppermitcount) - parseFloat(permitRowCount);
                    temppermitcount = parseFloat(temppermitcount) + parseFloat(data.length);
                    
                    $('.cat_service_count5').text(temppermitcount);
                    var old_permit_table_total = cleanNumber($('.table_total_40').text());
                    if(permit_table_total>0){
                        $('.table_total_40').text('$'+addCommas(number_test(permit_table_total)));
                    }else{
                        $('.table_total_40').text('');
                    }
                    if($('.cat_service_count5').attr('data-val')){
                        var tempcount2 = cleanNumber($('.cat_service_count5').attr('data-val'));
                        if(old_permit_table_total >0){
                             tempcount2 = parseFloat(tempcount2) - parseFloat(old_permit_table_total);
                         }
                    }else{
                        var tempcount2 = 0;
                    }
                   
                    tempcount2 = parseFloat(tempcount2) + parseFloat(permit_table_total);
                    $('.cat_service_count5').attr('title','$'+addCommas(number_test(tempcount2)));
                    $('.cat_service_count5').attr('data-val',number_test(tempcount2));


                    
                    $(".tiptip").tipTip({ defaultPosition: "top",delay: 0});
                    if(check_phase){
                        $('#ids_'+phase_id+' .phase_checked').removeClass('phase_checked_hide');
                    }else{
                       
                        $('#ids_'+phase_id+' .phase_checked').addClass('phase_checked_hide');
                    }
                    if($("#categoryTabs").is(":visible")){

                    }else{
                        $( "#categoryTabs" ).tabs({ active: '0' });
                        $('#categoryTabs').show();
                    }
                    //
                    
                    $('#page_loading').hide();
                    $('.item_search_btn').show();
                    $('.switch_check').show();
                    request_inprogress=false;
                    currency_masking();
                    initButtons();

                
                
                //initTipTip();
            }
            });
    }
}

function get_sub_contractors_items(){
    if(phase_id){
   // var sub_table_acc = $("#subcontract_item_table");
    //var isHidden = document.getElementById("subcontract_item_table").style.display == "none";
    isHidden =false;
    if(isHidden){
        subcontractRowCount = 0
    }else{
        var subcontractRowCount = ($("#subcontract_item_table tr").length)-1;

    }
   
    
    $("#subcontract_item_table").find("tr:gt(0)").remove();
    $.ajax({
            url: '/ajax/getPhaseLineSubContractorsItems',
            type: 'post',
            data: {
                'phaseId':phase_id,
                'proposal_service_id':proposal_service_id,
            },
            
            success: function(data){
                
                    data = JSON.parse(data);
                    check_phase = data.phase_complete;
                    data = data.lineItems;
                    var sub_con_table_total = 0;
                    for($i=0;$i<data.length;$i++){
                        if(parseFloat(data[$i]['profit_rate'])<0  || parseFloat(data[$i]['overhead_rate']) <0){
                            var icon = '<i class="fa fa-exclamation-triangle tiptip" style="margin-right: 2px;" title="This item is priced below cost"></i>';
                            var css = 'color:red';
                        }else{
                           var icon ='';
                           var css = '';
                        }
                        if(<?php echo $proposal_status_id;?> == '5'){
                            var row = '<tr style="border-bottom: 1px solid rgb(255, 255, 255); '+css+'" class="has_item_value" id="custom_est_'+data[$i]['id']+'"><td style="width:20px"><span class="custom_items_checkbox"></span></td><td style="width:5px">'+icon+'</td><td><a class="btn tiptip edit_sub_con_item" title="Calculate Quantity" data-estimate-item-notes="'+data[$i]['notes']+'" data-estimate-sub-id="'+data[$i]['sub_id']+'" data-estimate-quantity="'+data[$i]['quantity']+'"  data-estimate-base-price="'+data[$i]['base_price']+'" data-estimate-line-id="'+data[$i]['id']+'" data-estimate-total-price="'+data[$i]['total_price']+'"><i class="fa fa-fw fa-calculator"></i></a></td><td>'+data[$i]['sub_contractor_name']+'</td><td class="custom_item_unit_price">$'+data[$i]['unit_price']+'</td><td class="custom_item_quantity">'+data[$i]['quantity']+'</td><td style="text-align: right;"><span class="custom_line_item_total_price" >$'+addCommas(number_test(data[$i]['total_price']))+'</span></td><td> <a href="JavaScript:void(0);" class="estimate_item_notes btn tiptip" title="Notes" ><i class="fa fa-clipboard"></i></a> <a href="javascript:void(0);" class="btn blue-button tiptip save_est_btn save_custom_item_line" title="Save Estimate"  style="margin-bottom:2px; display:none" >Save</a><a href="JavaScript:void(0);" class="undo_custom_item_line btn tiptip" title="Undo Changes" style="display:none;"><i class="fa fa-fw fa-undo"></i></a></td></tr>';
                        }else{
                            var row = '<tr style="border-bottom: 1px solid rgb(255, 255, 255); '+css+'" class="has_item_value" id="custom_est_'+data[$i]['id']+'"><td style="width:20px"><span class="custom_items_checkbox"><input type="checkbox" class="custom_item_delete_checkbox" name="custom_item_delete_checkbox" value="'+data[$i]['id']+'" id="custom_item_checkbox'+data[$i]['id']+'" /></span></td><td style="width:5px">'+icon+'</td><td><a class="btn tiptip edit_sub_con_item" title="Calculate Quantity" data-estimate-item-notes="'+data[$i]['notes']+'" data-estimate-sub-id="'+data[$i]['sub_id']+'" data-estimate-quantity="'+data[$i]['quantity']+'"  data-estimate-base-price="'+data[$i]['base_price']+'" data-estimate-line-id="'+data[$i]['id']+'" data-estimate-total-price="'+data[$i]['total_price']+'"><i class="fa fa-fw fa-calculator"></i></a></td><td>'+data[$i]['sub_contractor_name']+'</td><td class="custom_item_unit_price">$'+data[$i]['unit_price']+'</td><td class="custom_item_quantity">'+data[$i]['quantity']+'</td><td style="text-align: right;"><span class="custom_line_item_total_price" >$'+addCommas(number_test(data[$i]['total_price']))+'</span></td><td> <a href="JavaScript:void(0);" class="estimate_item_notes btn tiptip" title="Notes" ><i class="fa fa-clipboard"></i></a> <a href="JavaScript:void(0);" class="custom_line_item_delete btn tiptip" data-item-type="sub_con" title="Remove From Estimate"  data-estimate-line-id="'+data[$i]['id']+'"><i class="fa fa-fw fa-trash"></i></a><a href="javascript:void(0);" class="btn blue-button tiptip save_est_btn save_custom_item_line" title="Save Estimate"  style="margin-bottom:2px; display:none" >Save</a><a href="JavaScript:void(0);" class="undo_custom_item_line btn tiptip" title="Undo Changes" style="display:none;"><i class="fa fa-fw fa-undo"></i></a></td></tr>';
                        }
                        
                        $('#subcontract_item_table tr:last').after(row);
                        sub_con_table_total = parseFloat(sub_con_table_total) + parseFloat(data[$i]['total_price'])
                    }
                    //$('#custom_item_table').show();
                    $('#heading_span_30').text(data.length);
                    var tempcount = $('.cat_service_count5').text();
                    
                    tempcount = parseFloat(tempcount) - parseFloat(subcontractRowCount);
                    
                    tempcount = parseFloat(tempcount) + parseFloat(data.length);
                    
                    $('.cat_service_count5').text(tempcount);
                    var old_sub_con_table_total = cleanNumber($('.table_total_30').text());
                    if(sub_con_table_total>0){
                        $('.table_total_30').text('$'+addCommas(number_test(sub_con_table_total)));
                    }else{
                        $('.table_total_30').text('');
                    }
                   
                    if($('.cat_service_count5').attr('data-val')){
                        var tempcount2 = cleanNumber($('.cat_service_count5').attr('data-val'));
                        
                         if(old_sub_con_table_total >0){
                             tempcount2 = parseFloat(tempcount2) - parseFloat(old_sub_con_table_total);
                         }
                        
                    }else{
                        var tempcount2 = 0;
                    }
                    
                    tempcount2 = parseFloat(tempcount2) + parseFloat(sub_con_table_total);
                    $('.cat_service_count5').attr('title','$'+addCommas(number_test(tempcount2)));
                    $('.cat_service_count5').attr('data-val',number_test(tempcount2));
                    
                    $(".tiptip").tipTip({ defaultPosition: "top",delay: 0});
                    if(check_phase){
                        $('#ids_'+phase_id+' .phase_checked').removeClass('phase_checked_hide');
                        }else{
                            $('#ids_'+phase_id+' .phase_checked').addClass('phase_checked_hide');
                        }
                    currency_masking();
                    initButtons();

                
                
                //initTipTip();
            }
            });
    }
}

$(document).on("click",".custom_line_item_delete",function() {
    if(unsaved_row){
            swal(
                'You have an unsaved item',
                'Please save or clear item to continue'
            );


    }else{
        var lineItemId  = $(this).attr('data-estimate-line-id');

        $this =$(this);

        swal({
            title: "Are you sure?",
            text: "Item will be permanently deleted",
            showCancelButton: true,
            confirmButtonText: 'Delete Item',
            cancelButtonText: "Cancel",
            dangerMode: false,
        }).then(function(isConfirm) {
            if (isConfirm) {
                var custom_item_type = $($this).data('item-type');
                if(custom_item_type=='fees'){
                    var success_mgs = 'Fees Item Deleted';
                }else if(custom_item_type=='permit'){
                    var success_mgs = 'Permit Item Deleted';
                }else if(custom_item_type=='custom'){
                    var success_mgs = 'Custom Item Deleted';
                }else if(custom_item_type=='sub_con'){
                    var success_mgs = 'Sub Contractor Item Deleted';
                }
                var est_items = [];
                est_items.push(lineItemId)
                $.ajax({
                    url: '/ajax/deleteEstimateLineItems',
                    type: "POST",
                    data: {
                        "lineItemIds": est_items,
                        "proposalServiceId": proposal_service_id,
                        'phase_id':phase_id,
                    },

                    success: function(data){
                        try{
                                data = JSON.parse(data);
                            } catch (e) {
                                swal("Error", "An error occurred Please try again");
                                return false;
                            }
                        get_custom_items();
                        get_sub_contractors_items();
                        get_proposal_breakdown();
                        //update_proposal_overhead_profit();
                        if(data.estimate.completed==0){
                        $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                        temp_count = temp_count+1;

                        if(total_service == temp_count){
                            $('.show_pending_est_msg').hide();
                            $('.welcome_msg').show();
                            $('.show_complete_est_msg').hide();
                        }else{
                            $('.show_pending_est_msg').text('You have '+temp_count+' additional services that you need to Estimate');
                            $('.show_pending_est_msg').show();
                            $('.welcome_msg').hide();
                            $('.show_complete_est_msg').hide();
                        }

                    }else{
                       
                        $('#service_'+proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                        
                    }
                        if(data.estimate.child_has_updated_flag==0 ){
                            $('.service_child_has_updated_flag_'+proposal_service_id).hide();
                            $('#service_'+proposal_service_id+' .toggle').addClass('text-active-color').removeClass('text-active-color2');
                            $('#service_'+proposal_service_id+' .toggle').css('background-color','#aeaeae');
                        }
                                $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                                $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                                
                            $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                            $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                            $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));        
                        swal(
                            success_mgs,
                            ''
                        );

                        if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                        $('#estimateLineItemTable').DataTable().ajax.reload();
                        
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        swal("Error", "An error occurred Please try again");
                        console.log( errorThrown );
                    }
                })

            
            
            } else {
                swal("Cancelled", "Your Estimation is safe :)", "error");
            }
        });
    }

});

$(document).on("click",".edit_sub_con_item",function() {

    if(unsaved_row){
            swal(
                'You have an unsaved item',
                'Please save or clear item to continue'
            );


    }else{
            has_sub_sep_total_price_update =false;
            custom_tr_id = $(this).closest('tr').prop('id');
            $('.if_error_show_msg,.if_edit_sub_item_total_price,#savesubcontractors,.custom_sub_name_tr').hide();
           
           $('.if_not_edit_sub_item_total_price,.if_custom_item_saved').show();

           $('.subcontractors_item_overhead_price').closest('tr').css('color','#444444');
            $('.subcontractors_item_overhead_price').css('color','#444444');
            $('.subcontractors_item_profit_price').closest('tr').css('color','#444444');
            $('.subcontractors_item_profit_price').css('color','#444444');

            $('.error').removeClass('error');
            $('.select_box_error').removeClass('select_box_error');
            $('.select2_box_error').removeClass('select2_box_error');
            //$('#custom_item_name').val('');
            $('#subcontractors_item_unit_price').val('');
            //$('#custom_item_quantity').val('');
            $('#subcontractors_item_notes').val('');
            //$('.custome_item_unit_price_text').text('');
            $('.subcontractors_item_overhead_price').text('');
            $('#subcontractors_custom_name').val('');
            $('.subcontractors_item_profit_price').text('');
            $('.subcontractors_item_total_price').text('0');
            $('.subcontractors_tax_amount').text('');
            $('.subcontractors_tax_rate').hide();
            $('.subcontractors_tax_checkbox').prop("checked",false);
            $('.subcontractors_tax_checkbox_tr div span').removeClass('checked');
            var services_title = $('#service_'+proposal_service_id+' .service_title_name').text();
            var phase_title = $('#service_'+proposal_service_id+' .phase_name_'+phase_id).text();
            $("#add_sub_contractors_item_model").dialog('option', 'title', services_title+' | '+phase_title);
            $("#add_sub_contractors_item_model").dialog('open');
            $(".subcontractors_cal_overhead_profit_checkbox").find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
            $('.show_subcontractors_overhead_and_profit').hide();
           // $('#continue3').attr('onclick','save_custom_item("")');
            $("#savesubcontractors").removeClass('ui-state-disabled');
            $("#savesubcontractors").attr('disabled',false);
            var services_html = $('#service_'+proposal_service_id).html();
            $('#service_html_box8').html(services_html);
            round_off_masking();
            var services_title = $('#service_'+proposal_service_id+' .service_title_name').text();
            var phase_title = $('#service_'+proposal_service_id+' .phase_name_'+phase_id).text();
            $('#service_html_box8').find('a').not('.cancel_field_save').remove();
            $('#service_html_box8 ul li:last').remove();
            $('#service_html_box8 ul .add_phase_li').remove();
            $('#service_html_box8 ul .specification_sep').remove();
            $('#service_html_box8 ul .service_specifications').show();
            $('#service_html_box8 ul li:last').remove();
            $('#service_html_box8 ul li:last').remove();
            $('#service_html_box8 ul li:last').remove();
            $('#service_html_box8 ul li:last').remove();
            $('#service_html_box8 ul li:last').remove();
            $('#service_html_box8 ul hr').remove();
            $('#service_html_box8 ul').addClass('pad0');
            $('#service_html_box8 ul').find('.set_loader_phase').remove();
            $('.custom_item_calculator_heading').text(services_title+' | '+phase_title);
            var lineItemId  = $(this).attr('data-estimate-line-id');
    $('#savesubcontractors').attr('onclick','save_subcontractors_item('+lineItemId+')');
    $.ajax({
                url: '/ajax/getCustomEstimateLineItemDetails/'+lineItemId,
                type: "get",
               

                success: function(data){
                    data = JSON.parse(data);
                if(data.sub_id==0){
                    $('.custom_sub_name_tr').show();
                   $('#subcontractors_custom_name').val(data.custom_name);
                }
                $('.subcontractors_id').val(data.sub_id);

                $('#subcontractors_item_unit_price').val(data.basePrice);
                //$('#custom_item_quantity').val(data.qty);
                $('.subcontractors_item_unit_price_text').text('$'+addCommas(number_test(data.unitPrice)));
                $('.subcontractors_item_overhead').val(data.overhead_rate);
                $('.subcontractors_item_overhead_price').text('$'+addCommas(number_test(data.overhead_rate_price)));
                $('.subcontractors_item_profit').val(data.profit_rate);
                
                $('.subcontractors_item_profit_price').text('$'+addCommas(number_test(data.profit_price)));
                $('.subcontractors_item_total_price').text(addCommas(number_test(data.totalPrice)));
                $('#subcontractors_item_notes').val(data.notes);
                $('.subcontractors_tax_rate').val(data.tax_rate);
                $('.subcontractors_tax_amount').text('$'+addCommas(number_test(data.tax_price)));
                
                if(parseFloat(data.overhead_rate_price) < 0){
                    $('.subcontractors_item_overhead_price').closest('tr').css('color','red');
                    $('.subcontractors_item_overhead_price').css('color','red');
                }else{
                    $('.subcontractors_item_overhead_price').closest('tr').css('color','#444444');
                    $('.subcontractors_item_overhead_price').css('color','#444444');
                }

                if(parseFloat(data.profit_price) < 0){
                    $('.subcontractors_item_profit_price').closest('tr').css('color','red');
                    $('.subcontractors_item_profit_price').css('color','red');
                }else{
                    $('.subcontractors_item_profit_price').closest('tr').css('color','#444444');
                    $('.subcontractors_item_profit_price').css('color','#444444');
                }
                
                
                
                if(data.work_order == 1){
                    $('#subcontractors_work_order').prop("checked",true);
                }else{
                    $('#subcontractors_work_order').prop("checked",false);
                }  
                
                    
                setDropdowns();

                if(data.tax_rate>0){
                    
                            $('.subcontractors_tax_checkbox').prop("checked",true);
                            $('.subcontractors_tax_checkbox_tr div span').addClass('checked');
                            $('.subcontractors_tax_rate').show();
                            $('.subcontractors_tax_amount_row').show();
                        }else{
                            $('.subcontractors_tax_checkbox').prop("checked",false);
                            $('.subcontractors_tax_checkbox_tr div span').removeClass('checked');
                            $('.subcontractors_tax_rate').hide();
                            $('.subcontractors_tax_amount_row').hide();
                        }
                
                }
        });
        var services_title = $('#service_'+proposal_service_id+' .service_title_name').text();
            var phase_title = $('#service_'+proposal_service_id+' .phase_name_'+phase_id).text();
            $("#add_sub_contractors_item_model").dialog('option', 'title', services_title+' | '+phase_title);
            
    $("#add_sub_contractors_item_model").dialog('open');
    //$(".custom_cal_overhead_profit_checkbox").find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
            //$('.show_custom_overhead_and_profit').hide();
    
    }
});
$(document).on("click",".edit_custom_item",function() {
    var temp_item_line_id = $(this).closest('tr').prop('id');
    custom_tr_id =temp_item_line_id;
    if(unsaved_row && temp_item_line_id != custom_item_line_id){
    
            swal(
                'You have an unsaved item',
                'Please save or clear item to continue'
            );


    }else{
    //$("#add_custom_item_model").dialog('open');
    has_custom_sep_total_price_update =false;
    if($(this).data('item-type')=='fees'){
                $('.custom_unit_price_label').text('Price');
                $('.add_custom_item_model_title_service').text('Services');
                $('.add_custom_item_model_title_type').text('Fees');
                $('.add_custom_item_model_title_item').text('Fee Item');
                //$('.custom_item_calculator_item_type').text('Services / Fees / Fee Item');
            }else if($(this).data('item-type')=='permit'){
                $('.custom_unit_price_label').text('Price');
                $('.add_custom_item_model_title_service').text('Services');
                $('.add_custom_item_model_title_type').text('Permits');
                $('.add_custom_item_model_title_item').text('Permit Item');
                //$('.custom_item_calculator_item_type').text('Services / Permits / Permit Item');
            }else{
                $('.add_custom_item_model_title_service').text('Custom');
                $('.add_custom_item_model_title_type').text('Custom Items ');
                $('.add_custom_item_model_title_item').text('Custom Item');
                $('.custom_unit_price_label').text('Base Unit Price');
                //$('.custom_item_calculator_item_type').text('Custom / Custom Items / Custom Item');
            }
    // if($(this).data('item-type')=='fees'){
    //             $('.custom_unit_price_label').text('Price');
    //             $('.custom_item_calculator_item_type').text('Services / Fees / Fee Item');
    //         }else if($(this).data('item-type')=='permit'){
    //             $('.custom_unit_price_label').text('Price');
    //             $('.custom_item_calculator_item_type').text('Services / Permits / Permit Item');
    //         }else{
    //             $('.custom_unit_price_label').text('Base Unit Price');
    //             $('.custom_item_calculator_item_type').text('Custom / Custom Items / Custom Item');
    //         }
    $('.if_error_show_msg,.if_edit_custom_item_total_price').hide();
    $('.if_not_edit_custom_item_total_price').show();
            $('.error').removeClass('error');
            $('.select_box_error').removeClass('select_box_error');
            $('.select2_box_error').removeClass('select2_box_error');
    var services_html = $('#service_'+proposal_service_id).html();
            $('#service_html_box2').html(services_html);
            round_off_masking();
            $("#continue3").removeClass('ui-state-disabled');
            $("#continue3").attr('disabled',false);
            var services_title = $('#service_'+proposal_service_id+' .service_title_name').text();
            var phase_title = $('#service_'+proposal_service_id+' .phase_name_'+phase_id).text();
            $('#service_html_box2').find('a').not('.cancel_field_save').remove();
            // $('#service_html_box2 ul .add_phase_li').remove();
            // $('#service_html_box2 ul .specification_sep').remove();
            $('#service_html_box2 ul .service_specifications').show();
            // $('#service_html_box2 ul li:last').remove();
            // $('#service_html_box2 ul li:last').remove();
            // $('#service_html_box2 ul li:last').remove();
            // $('#service_html_box2 ul li:last').remove();
            $( "#service_html_box2 ul li" ).not( ".service_specifications" ).remove();
           // $('#service_html_box2 ul hr').remove();
            $('#service_html_box2 ul').addClass('pad0');
            $('#service_html_box2 ul').find('.set_loader_phase').remove();
            $('.custom_item_calculator_heading').text(services_title+' | '+phase_title);
            
            
            $('#custom_item_type').val($(this).data('item-type'));
    var lineItemId  = $(this).attr('data-estimate-line-id');
    custom_saved_line_id =lineItemId;
    custom_price_total =false;
    saved_custom_price =0;
    $("#add_custom_item_model").find('.unit_price_label').text('Unit Price');
    $("#add_custom_item_model").find('.total_price_label').text('Total Price');
    if($(this).attr('data-custom-total-price')==1){
        console.log('check_custom_113')
                custom_price_total =true;
                $("#add_custom_item_model").find('.unit_price_label').text('Unit Price*');
                console.log('check_121')
                $("#add_custom_item_model").find('.total_price_label').text('Total Price*');
                saved_custom_price = cleanNumber($(this).closest('tr').find('.custom_line_item_total_price').text());
               
    }
    
    $('#continue3').attr('onclick','save_custom_item('+lineItemId+')');
    $.ajax({
                url: '/ajax/getCustomEstimateLineItemDetails/'+lineItemId,
                type: "get",
               

                success: function(data){
                    data = JSON.parse(data);
                $('#custom_item_name').val(data.custom_name);
                $('#custom_item_unit_price').val(data.basePrice);
                $('#custom_item_quantity').val(data.qty);
                $('.custome_item_unit_price_text').text('$'+addCommas(number_test(data.unitPrice)));
                $('.custome_item_overhead').val(data.overhead_rate);
                $('.custome_item_overhead_price').text('$'+addCommas(number_test(data.overhead_rate_price)));
                $('.custome_item_profit').val(data.profit_rate);
                $('.custome_item_profit_price').text('$'+addCommas(number_test(data.profit_price)));
                $('.custom_item_total_price').text(addCommas(number_test(data.totalPrice)));
                $('#custom_item_notes').val(data.notes);
                $('.custome_tax_rate').val(data.tax_rate);
                $('.custome_tax_amount').text('$'+addCommas(number_test(data.tax_price)));
                    if(data.work_order == 1){
                        $('#custom_work_order').prop("checked",true);
                    }else{
                        $('#custom_work_order').prop("checked",false)
                    }
                    if(data.tax_rate>0){
                    
                            $('.custome_tax_checkbox').prop("checked",true);
                            $('.custome_tax_checkbox_tr div span').addClass('checked');
                            $('.custome_tax_rate').show();
                            $('.custome_tax_amount_row').show();
                        }else{
                            $('.custome_tax_checkbox').prop("checked",false);
                            $('.custome_tax_checkbox_tr div span').removeClass('checked');
                            $('.custome_tax_rate').hide();
                            $('.custome_tax_amount_row').hide();
                        }
                    $.uniform.update()
                }
        });
        $("#add_custom_item_model").dialog('open');
        $(".custom_cal_overhead_profit_checkbox").find('i').addClass('fa-chevron-up').removeClass('fa-chevron-down');
        $('.show_custom_overhead_and_profit').show();
        $('.if_custom_item_saved').show();
        $('#continue3').hide();
    }
});

$(document).on("click",".open_custom_child_calculator",function() {
    
    if(unsaved_row ){
    
            swal(
                'You have an unsaved item',
                'Please save or clear item to continue'
            );


    }else{
            has_custom_custom_total_price_update =false;
            child_lineItemId  = $(this).attr('data-child-line-id');
            round_off_masking();
            $("#continue3").removeClass('ui-state-disabled');
            $("#continue3").attr('disabled',false);
            $('.save_estimation').hide();
            $('.cal_trucking_total_price_lable').text('Total Price');
            $('.if_not_edit_custom_item_total_price,.save_custom_estimation').show();
            $('.custom_custom_total_price_input,.if_edit_custom_item_total_price,.item_custom_total_edit_icon').hide();
            $('#add_custom_child_item_form').find('.custome_child_item_overhead_price').closest('tr').css('color','#444444');
            $('#add_custom_child_item_form').find('.custome_child_item_overhead').css('color','#444444');
            $('#add_custom_child_item_form').find('.custome_child_item_profit_price').closest('tr').css('color','#444444');
                                    $('#add_custom_child_item_form').find('.custome_child_item_profit').css('color','#444444');
            $('.if_error_show_msg').hide();
            $('.error').removeClass('error');
            $('.select_box_error').removeClass('select_box_error');
            $('.select2_box_error').removeClass('select2_box_error');
            var services_title = $('#service_'+proposal_service_id+' .service_title_name').text();
            var phase_title = $('#service_'+proposal_service_id+' .phase_name_'+phase_id).text();
            
            $('.custom_child_item_calculator_heading').text(services_title+' | '+phase_title);
           
    var lineItemId  = $(this).attr('data-child-line-id');
    $.ajax({
                url: '/ajax/getCustomEstimateLineItemDetails/'+lineItemId,
                type: "get",
               

                success: function(data){
                    data = JSON.parse(data);
                $('#custom_child_item_name').val(data.custom_name);
                $('#custom_child_item_unit_price').val(data.basePrice);
                $('#custom_child_item_quantity').val(data.qty);
                $('.custome_child_item_unit_price_text').text('$'+addCommas(number_test(data.unitPrice)));
                
                $('.custom_child_item_total_price').text(addCommas(number_test(data.totalPrice)));
                $('#custom_child_item_notes').val(data.notes);
                $('.custome_child_tax_rate').val(data.tax_rate);
                $('.custome_child_tax_amount').text('$'+addCommas(number_test(data.tax_price)));
                    if(data.work_order == 1){
                        $('#child_custom_work_order').prop("checked",true);
                    }else{
                        $('#child_custom_work_order').prop("checked",false)
                    }
                if(data.tax_rate>0){
                    
                            $('.custome_child_tax_checkbox').prop("checked",true);
                            $('.custome_child_tax_checkbox_tr div span').addClass('checked');
                            $('.custome_child_tax_rate').show();
                            $('.custome_child_tax_amount_row').show();
                        }else{
                            $('.custome_child_tax_checkbox').prop("checked",false);
                            $('.custome_child_tax_checkbox_tr div span').removeClass('checked');
                            $('.custome_child_tax_rate').hide();
                            $('.custome_child_tax_amount_row').hide();
                        }


                        if(data.is_custom_price==1){
                            
                            console.log('check_122')

                            $('.cal_trucking_total_price_lable').text('Total Price*');
                        }
                            if(parseFloat(data.overhead_rate_price)<0){
                                    var temp_overheadPrice = '-$'+addCommas(number_test(Math.abs(data.overhead_rate_price)));
                                    $('#add_custom_child_item_form').find('.custome_child_item_overhead_price').closest('tr').css('color','red');
                                    $('#add_custom_child_item_form').find('.custome_child_item_overhead').css('color','red');
                                }else{
                                    var temp_overheadPrice = '$'+addCommas(number_test(data.overhead_rate_price));
                                    $('#add_custom_child_item_form').find('.custome_child_item_overhead_price').closest('tr').css('color','#444444');
                                    $('#add_custom_child_item_form').find('.custome_child_item_overhead').css('color','#444444');
                                }

                                if(parseFloat(data.profit_price)<0){
                                    var temp_profitPrice = '-$'+addCommas(number_test(Math.abs(data.profit_price)));
                                    $('#add_custom_child_item_form').find('.custome_child_item_profit_price').closest('tr').css('color','red');
                                    $('#add_custom_child_item_form').find('.custome_child_item_profit').css('color','red');
                                }else{
                                    var temp_profitPrice = '$'+addCommas(number_test(data.profit_price));
                                    $('#add_custom_child_item_form').find('.custome_child_item_profit_price').closest('tr').css('color','#444444');
                                    $('#add_custom_child_item_form').find('.custome_child_item_profit').css('color','#444444');
                                }

                            $('.custome_child_item_overhead').val(data.overhead_rate);
                            $('.custome_child_item_overhead_price').text(temp_overheadPrice);
                            $('.custome_child_item_profit').val(data.profit_rate);
                            $('.custome_child_item_profit_price').text(temp_profitPrice);
                         
                    $.uniform.update();
                }
        });
    $("#add_custom_child_item_model").dialog('open');
    //$( ".custom_child_cal_overhead_profit_checkbox" ).trigger( "click" );
     $(".custom_child_cal_overhead_profit_checkbox").find('i').addClass('fa-chevron-up').removeClass('fa-chevron-down');
             $('.show_custom_child_overhead_and_profit').show();
     }
   
});

$(document).on("click",".open_fees_child_calculator",function() {
    
    if(unsaved_row ){
    
            swal(
                'You have an unsaved item',
                'Please save or clear item to continue'
            );


    }else{
            child_lineItemId  = $(this).attr('data-child-line-id');
            has_custom_fees_total_price_update =false;
            round_off_masking();
            $("#continue3").removeClass('ui-state-disabled');
            $("#continue3").attr('disabled',false);
            $('.save_estimation').hide();
            $('.if_error_show_msg').hide();
            $('.if_not_edit_fees_item_total_price,.save_fees_child_estimation ').show();
            $('.custom_fees_total_price_input,.if_edit_fees_item_total_price,.item_fees_total_edit_icon').hide();
            $('.fees_child_item_total_price_lable').text('Total Price');
            $('.fees_child_item_overhead_price').closest('tr').css('color','#444444');
            $('.fees_child_item_overhead').css('color','#444444');
            $('.fees_child_item_profit_price').closest('tr').css('color','#444444');
            $('.fees_child_item_profit').css('color','#444444');
            $('.error').removeClass('error');
            $('.select_box_error').removeClass('select_box_error');
            $('.select2_box_error').removeClass('select2_box_error');
            var services_title = $('#service_'+proposal_service_id+' .service_title_name').text();
            var phase_title = $('#service_'+proposal_service_id+' .phase_name_'+phase_id).text();
            
            $('.fees_child_item_calculator_heading').text(services_title+' | '+phase_title);
           
    var lineItemId  = $(this).attr('data-child-line-id');
    $.ajax({
                url: '/ajax/getCustomEstimateLineItemDetails/'+lineItemId,
                type: "get",
               

                success: function(data){
                    data = JSON.parse(data);
                $('#fees_child_item_name').val(data.custom_name);
                $('#fees_child_item_unit_price').val(data.basePrice);
                $('#fees_child_item_quantity').val(data.qty);
                $('.fees_child_item_unit_price_text').text('$'+addCommas(number_test(data.unitPrice)));
                $('.fees_child_item_overhead').val(data.overhead_rate);
                $('.fees_child_item_overhead_price').text('$'+addCommas(number_test(data.overhead_rate_price)));
                $('.fees_child_item_profit').val(data.profit_rate);
                $('.fees_child_item_profit_price').text('$'+addCommas(number_test(data.profit_price)));
                $('.fees_child_item_total_price').text(addCommas(number_test(data.totalPrice)));
                $('#fees_child_item_notes').val(data.notes);
                $('.fees_child_tax_rate').val(data.tax_rate);
                $('.fees_child_tax_amount').text('$'+addCommas(number_test(data.tax_price)));
                if(data.fees==1){
                    $('#is_fees_type').val(1); 
                    var temp_it_type = 'Fees Item';
                }else{
                    var temp_it_type = 'Permit Item';
                    $('#is_fees_type').val(0); 
                }
                
                $(".fees_type_name").text(temp_it_type);
                if(data.work_order == 1){
                    $('#child_fees_work_order').prop("checked",true);
                }else{
                    $('#child_fees_work_order').prop("checked",false)
                }
                if(data.tax_rate>0){
                    
                            $('.fees_child_tax_checkbox').prop("checked",true);
                            $('.fees_child_tax_checkbox_tr div span').addClass('checked');
                            $('.fees_child_tax_rate').show();
                            $('.fees_child_tax_amount_row').show();
                        }else{
                            $('.fees_child_tax_checkbox').prop("checked",false);
                            $('.fees_child_tax_checkbox_tr div span').removeClass('checked');
                            $('.fees_child_tax_rate').hide();
                            $('.fees_child_tax_amount_row').hide();
                        }

                        if(data.is_custom_price==1){
                            console.log('check_123')
                            $('.fees_child_item_total_price_lable').text('Total Price*');
                        }
                            if(parseFloat(data.overhead_rate_price)<0){
                                    var temp_overheadPrice = '-$'+addCommas(number_test(Math.abs(data.overhead_rate_price)));
                                    $('.fees_child_item_overhead_price').closest('tr').css('color','red');
                                    $('.fees_child_item_overhead').css('color','red');
                                }else{
                                    var temp_overheadPrice = '$'+addCommas(number_test(data.overhead_rate_price));
                                    $('.fees_child_item_overhead_price').closest('tr').css('color','#444444');
                                    $('.fees_child_item_overhead').css('color','#444444');
                                }

                                if(parseFloat(data.profit_price)<0){
                                    var temp_profitPrice = '-$'+addCommas(number_test(Math.abs(data.profit_price)));
                                    $('.fees_child_item_profit_price').closest('tr').css('color','red');
                                    $('.fees_child_item_profit').css('color','red');
                                }else{
                                    var temp_profitPrice = '$'+addCommas(number_test(data.profit_price));
                                    $('.fees_child_item_profit_price').closest('tr').css('color','#444444');
                                    $('.fees_child_item_profit').css('color','#444444');
                                }
                            $('.fees_child_item_overhead').val(data.overhead_rate);
                            $('.fees_child_item_overhead_price').text(temp_overheadPrice);
                            $('.fees_child_item_profit').val(data.profit_rate);
                            $('.fees_child_item_profit_price').text(temp_profitPrice);

                        
                    $.uniform.update()
                }
        });
    
        var services_title = $('#service_'+proposal_service_id+' .service_title_name').text();
        var phase_title = $('#service_'+proposal_service_id+' .phase_name_'+phase_id).text();

        $("#add_fees_child_item_model").dialog('option','title',services_title+' | '+phase_title).dialog('open');
    //$( ".custom_child_cal_overhead_profit_checkbox" ).trigger( "click" );
     $(".custom_child_cal_overhead_profit_checkbox").find('i').addClass('fa-chevron-up').removeClass('fa-chevron-down');
     $('.show_custom_child_overhead_and_profit').show();


    }
});

$(document).on("change",".custom_item_total_price",function() {
    
        var unit_price = cleanNumber($(this).closest('tr').find('.custom_item_unit_price').text());
        var quantity = cleanNumber($(this).closest('tr').find('.custom_item_quantity').text());
        
        if(unit_price && unit_price >0 && quantity && quantity >0){

            $(this).closest('tr').addClass('has_value_changed');
            unsaved_row =true;
            $(this).closest('tr').find('.custom_line_item_delete').hide();
            
                $(this).closest('tr').find('.undo_custom_item_line').show();
            
                $(this).closest('tr').find('.save_est_btn').show();
          
        }

    });

    $(document).on("keyup",".custom_item_total_price",function(e) {
        
            var quantity = cleanNumber($(this).closest('tr').find('.custom_item_quantity').text());
            custom_item_line_id = $(this).closest('tr').prop('id')
                var total_price = cleanNumber($(this).val());

                if(parseInt(total_price) == total_price || parseFloat(total_price) == total_price){
                    var unit_price = total_price / quantity;
                    item_price =unit_price;
                    $(this).closest('tr').find(".custom_item_unit_price").text('$'+ number_test(unit_price));
                    //$(this).closest('tr').find('.span_unit_price1').text('$'+addCommas(number_test(unit_price)));
                }
            


    });
    $(document).on("focus",".custom_item_total_price",function(e) {
        var temp_custom_item_line_id = $(this).closest('tr').prop('id')
        if(unsaved_row && temp_custom_item_line_id != custom_item_line_id){
            e.preventDefault();
            $('#'+custom_item_line_id+' .custom_item_total_price').focus();
            swal(
                'You have an unsaved item',
                'Please save or clear item to continue'
            );


        }
    });
$(document).on("click",".undo_custom_item_line",function() {
    get_custom_items();
    unsaved_row =false;
});

$(document).on("click",".save_custom_item_line",function() {
    var temp_estimate_line_id = $(this).closest('tr').find('.edit_custom_item').attr('data-estimate-line-id'); 

    var temp_quantity = cleanNumber($(this).closest('tr').find('.custom_item_quantity').text());
    var temp_total_price = cleanNumber($(this).closest('tr').find('.custom_item_total_price').val()); 
    var temp_unit_price = cleanNumber($(this).closest('tr').find('.custom_item_unit_price').text()); 
   

            $.ajax({
            url: '/ajax/updateEstimateLineItems/',
            type: 'post',
            data: {
                'customUnitPrice':1,
                'proposalServiceId':proposal_service_id,
                'id':temp_estimate_line_id,
                'quantity':temp_quantity,
                'unitPrice':temp_unit_price,
                'totalPrice':temp_total_price,
                'apply':0,
            },
            success: function(data){
                swal(
                    'Custom Item Saved',
                    ''
                );
                get_custom_items();
            }
            });
    unsaved_row =false;
});

$(document).on("click",".custom_item_delete_checkbox",function() {

var temp_item_line_id = $(this).closest('tr').prop('id')
if(unsaved_row && temp_item_line_id != custom_item_line_id){
    $('.custom_item_delete_checkbox div span').removeClass('checked');
    $('.custom_item_delete_checkbox').attr('checked',false);
    swal(
        'You have an unsaved item',
        'Please save or clear item to continue'
    );

}else{
    var delete_checkbox_name = $(this).attr('name');

    var custom_items = [];
    $.each($("input[name='"+delete_checkbox_name+"']:checked"), function(){
        custom_items.push($(this).val());
    });
    if(custom_items.length > 0){
        $('.delete_custom_estimate_items').show();
    }else{
        $('.delete_custom_estimate_items').hide();
    }
}
});


function delete_custom_estimated_items(e,element){

    e.stopPropagation();
var est_items = [];
swal({
    title: "Are you sure?",
    text: "Items will be permanently deleted",
    showCancelButton: true,
    confirmButtonText: 'Delete Items',
    cancelButtonText: "Cancel",
    dangerMode: false,
}).then(function(isConfirm) {
    if (isConfirm) {
        $(element).hide();
        $.each($("input[name='custom_item_delete_checkbox']:checked"), function(){
            
            est_items.push($(this).val());
           
        });

        $.ajax({
            url: '/ajax/deleteEstimateLineItems',
            type: "POST",
            data: {
                "lineItemIds": est_items,
                "proposalServiceId": proposal_service_id,
                'phase_id':phase_id,
            },
            dataType: "json",

            success: function(data){
                
                get_custom_items();
                $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                
                $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                
                if(data.estimate.completed==0){
                        $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                        temp_count = temp_count+1;

                        if(total_service == temp_count){
                            $('.show_pending_est_msg').hide();
                            $('.welcome_msg').show();
                            $('.show_complete_est_msg').hide();
                        }else{
                            
                            $('.show_pending_est_msg').text('You have '+temp_count+' additional services that you need to Estimate');
                            $('.show_pending_est_msg').show();
                            $('.welcome_msg').hide();
                            $('.show_complete_est_msg').hide();
                        }

                    }else{
                       
                        $('#service_'+proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                        
                    }
                if(data.estimate.child_has_updated_flag==0 ){
                    $('.service_child_has_updated_flag_'+proposal_service_id).hide();
                    $('#service_'+proposal_service_id+' .toggle').addClass('text-active-color').removeClass('text-active-color2');
                    $('#service_'+proposal_service_id+' .toggle').css('background-color','#aeaeae');
                }
                
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }
        })
        

        swal(
            'Items Deleted',
            ''
        );
       
    } else {
        swal("Cancelled", "Your Estimation is safe :)", "error");
    }
});
}
$(document).on('click',".subcontractors_tax_checkbox",function() {
        if($(this).prop("checked")){
            $('.subcontractors_tax_rate').show();
            $('.subcontractors_tax_amount_row').show();
        }else{
            $('.subcontractors_tax_rate').val(0);
            $('.subcontractors_tax_amount').text('$0');
            $('.subcontractors_tax_rate').hide();
            $('.subcontractors_tax_amount_row').hide();
            var subcontractors_item_unit_price = cleanNumber($(this).closest('form').find('#subcontractors_item_unit_price').val());
            var subcontractors_item_overhead = cleanNumber($(this).closest('form').find('.subcontractors_item_overhead').val());
            var subcontractors_item_profit = cleanNumber($(this).closest('form').find('.subcontractors_item_profit').val());
            var subcontractors_item_tax_rate = cleanNumber($(this).closest('form').find('.subcontractors_tax_rate').val());

                        
    subcontractors_item_overhead_profit_calculation(subcontractors_item_unit_price,subcontractors_item_overhead,subcontractors_item_profit,subcontractors_item_tax_rate);
    $('.if_custom_item_saved').hide();
    $('#savesubcontractors').show();
        }
    })

$(document).on('click',".custome_tax_checkbox22",function() {
        if($(this).prop("checked")){
            $('.custome_tax_rate').show();
            $('.custome_tax_amount_row').show();
        }else{
            $('.custome_tax_rate').val(0);
            $('.custome_tax_amount').text('$0');
            $('.custome_tax_rate').hide();
            $('.custome_tax_amount_row').hide();
            var custom_item_unit_price = cleanNumber($(this).closest('form').find('#custom_item_unit_price').val());
            var custom_item_quantity = cleanNumber($(this).closest('form').find('#custom_item_quantity').val());
            var custome_item_overhead = cleanNumber($(this).closest('form').find('.custome_item_overhead').val());
            var custome_item_profit = cleanNumber($(this).closest('form').find('.custome_item_profit').val());
            var custome_tax_rate = cleanNumber($(this).closest('form').find('.custome_tax_rate').val());
            custom_item_overhead_profit_calculation(custom_item_unit_price,custom_item_quantity,custome_item_overhead,custome_item_profit,custome_tax_rate);

        }
    })

$(document).on('click',".custome_tax_checkbox",function() {
        if($(this).prop("checked")){
            $('.custome_tax_rate').show();
            $('.custome_tax_amount_row').show();
        }else{
            $('.custome_tax_rate').val(0);
            $('.custome_tax_amount').text('$0');
            $('.custome_tax_rate').hide();
            $('.custome_tax_amount_row').hide();
            var custom_item_unit_price = cleanNumber($(this).closest('form').find('#custom_item_unit_price').val());
            var custom_item_quantity = cleanNumber($(this).closest('form').find('#custom_item_quantity').val());
            var custome_item_overhead = cleanNumber($(this).closest('form').find('.custome_item_overhead').val());
            var custome_item_profit = cleanNumber($(this).closest('form').find('.custome_item_profit').val());
            var custome_tax_rate = cleanNumber($(this).closest('form').find('.custome_tax_rate').val());
            custom_item_overhead_profit_calculation(custom_item_unit_price,custom_item_quantity,custome_item_overhead,custome_item_profit,custome_tax_rate);
            $('.if_custom_item_saved').hide();
                 $('#continue3').show();
        }
    })

    $(document).on('click',".custome_child_tax_checkbox",function() {
        if($(this).prop("checked")){
            $('.custome_child_tax_rate').show();
            //$('.custome_tax_amount_row').show();
        }else{
            $('.custome_child_tax_rate').val(0);
            $('.custome_child_tax_amount').text('$0');
            $('.custome_child_tax_rate').hide();
            //$('.custome_tax_amount_row').hide();
            var custom_item_unit_price = cleanNumber($(this).closest('form').find('#custom_child_item_unit_price').val());
            var custom_item_quantity = cleanNumber($(this).closest('form').find('#custom_child_item_quantity').val());
            var custome_item_overhead = cleanNumber($(this).closest('form').find('.custome_child_item_overhead').val());
            var custome_item_profit = cleanNumber($(this).closest('form').find('.custome_child_item_profit').val());
            var custome_tax_rate = cleanNumber($(this).closest('form').find('.custome_child_tax_rate').val());
            custom_child_item_overhead_profit_calculation(custom_item_unit_price,custom_item_quantity,custome_item_overhead,custome_item_profit,custome_tax_rate);

        }
    })

    $(document).on('click',".fees_child_tax_checkbox",function() {
        if($(this).prop("checked")){
            $('.fees_child_tax_rate').show();
            //$('.custome_tax_amount_row').show();
        }else{
            $('.fees_child_tax_rate').val(0);
            $('.fees_child_tax_amount').text('$0');
            $('.fees_child_tax_rate').hide();
            //$('.custome_tax_amount_row').hide();
            var fees_item_unit_price = cleanNumber($(this).closest('form').find('#fees_child_item_unit_price').val());
            var fees_item_quantity = cleanNumber($(this).closest('form').find('#fees_child_item_quantity').val());
            var fees_item_overhead = cleanNumber($(this).closest('form').find('.fees_child_item_overhead').val());
            var fees_item_profit = cleanNumber($(this).closest('form').find('.fees_child_item_profit').val());
            var fees_tax_rate = cleanNumber($(this).closest('form').find('.fees_child_tax_rate').val());
            fees_child_item_overhead_profit_calculation(fees_item_unit_price,fees_item_quantity,fees_item_overhead,fees_item_profit,fees_tax_rate);

        }
    })
    $(document).on("keyup",".fixed_template_value_hour_per_day,.fixed_template_value_time_type_input",function(e) {
         
        if($(this).val() && $(this).val()>0){
            $(this).removeClass('error');
        }else{
            
            $(this).addClass('error');
        }
        if($('.error').length>0 ){
            $('.if_error_show_msg').show();
        }else{
            $('.if_error_show_msg').hide();
        }
    });

    $(document).on("focusout, blur",".labor_number_of_person,.labor_time_type_input,.labor_hour_per_day",function(e) {
        //$( ".labor_item" ).trigger( "change" );
        if($( ".labor_item" ).val()){
            $( ".labor_item" ).closest('td').find('.select2').removeClass('select2_box_error');
        }else{
            $( ".labor_item" ).closest('td').find('.select2').addClass('select2_box_error');
        }
       
         
        if($(this).val()){
            $(this).removeClass('error');
        }else{
            $(this).addClass('error');
        }
        if($('.error').length>0 || $('.select2_box_error').length>0){
            $('.if_error_show_msg').show();
        }else{
            $('.if_error_show_msg').hide();
        }
    });
    $(document).on("focusout, blur",".equipement_number_of_person,.equipement_time_type_input,.equipement_hour_per_day",function(e) {
        
        if($( ".equipement_item" ).val()){
            $( ".equipement_item" ).closest('td').find('.select2').removeClass('select2_box_error');
        }else{
            $( ".equipement_item" ).closest('td').find('.select2').addClass('select2_box_error');
        }
         
        if($(this).val()){
            $(this).removeClass('error');
        }else{
            $(this).addClass('error');
        }
        if($('.error').length>0 || $('.select2_box_error').length>0){
            $('.if_error_show_msg').show();
        }else{
            $('.if_error_show_msg').hide();
        }
    });
    
    $(document).on("focusout, blur","#custom_item_name,#custom_item_quantity,#custom_item_unit_price,.truck_capacity,.trip_time,.plantSelect,.plant_turnaround,.site_turnaround,.site_turnaround2,.hours_per_day,#custom_child_item_name,#custom_child_item_quantity,#custom_child_item_unit_price,.truck_capacity,.hours_per_day,.trip_time,#fees_child_item_name,#fees_child_item_quantity,#fees_child_item_unit_price,.child_minimum_hours",function(e) {
        
        if($(this).val()){
            $(this).removeClass('error');
        }else{
            $(this).addClass('error');
        }
        if($('.error').length>0 || $('.select_box_error').length>0){
            $('.if_error_show_msg').show();
        }else{
            $('.if_error_show_msg').hide();
        }
    });

    $(document).on("focusout blur keyup",".edit_template_value_time_type_input",function(e) {
        
        check_edit_template_popup_validation();
        if($(this).val()){
            $(this).removeClass('error');
        }else{
            if($('.check_edit_tamplate_days_value').is(":checked")){
                $(this).addClass('error');
            }
            
        }
        if($('.error').length>0){
            $('.if_error_show_msg').show();
        }else{
            $('.if_error_show_msg').hide();
        }
    });
    $(document).on("focusout blur keyup",".edit_template_value_number_of_person",function(e) {
        
        check_edit_template_popup_validation();
        if($(this).val()){
            $(this).removeClass('error');
        }else{
            if($('.check_edit_tamplate_quantity_value').is(":checked")){
                $(this).addClass('error');
            }
            
        }
        if($('.error').length>0){
            $('.if_error_show_msg').show();
        }else{
            $('.if_error_show_msg').hide();
        }
    });
    $(document).on("focusout blur keyup",".edit_template_value_hour_per_day",function(e) {
        check_edit_template_popup_validation();
        if($(this).val()){
            $(this).removeClass('error');
        }else{
            if($('.check_edit_tamplate_hpd_value').is(":checked")){
                $(this).addClass('error');
            }
            
        }
        if($('.error').length>0){
            $('.if_error_show_msg').show();
        }else{
            $('.if_error_show_msg').hide();
        }
    });

    $(document).on("click",".check_edit_tamplate_quantity_value",function(e) {
        check_edit_template_popup_validation();
        if($(this).is(":checked")){
            if(!$('.edit_template_value_number_of_person').val()){
                $('.edit_template_value_number_of_person').focus();
            }
            $('.edit_template_value_number_of_person').show();
        }else{
            $('.edit_template_value_number_of_person').val('');
            $('.edit_template_value_number_of_person').hide();
            //$('.edit_template_value_number_of_person').removeClass('error');
            
            
        }
        
    })

    function check_edit_template_popup_validation(){
        var checkbox_count =0;
        var input_valid =true;
        $('#edit_template_item_values_form table tr').each(function(i,tr){
            
            if($(this).find("input[type='checkbox']").is(":checked")){
                checkbox_count++;
                if(!$(this).find("input[type='text']").val()){
                    input_valid =false;
                }
            }
        });

        if(checkbox_count>0 && input_valid){
            $("#edit_template_values_submit").removeClass('ui-state-disabled');
            $("#edit_template_values_submit").attr('disabled',false);
            
           
        }else{
            $("#edit_template_values_submit").addClass('ui-state-disabled');
            $("#edit_template_values_submit").attr('disabled',true);
        }
    }

    $(document).on("click",".check_edit_tamplate_days_value",function(e) {
        check_edit_template_popup_validation();
        if($(this).is(":checked")){
            if(!$('.edit_template_value_time_type_input').val()){
                $('.edit_template_value_time_type_input').focus();
            }
            //$('.edit_template_value_time_type_input').prop('disabled', false);
            $('.edit_template_value_time_type_input').show();
        }else{
            $('.edit_template_value_time_type_input').val('');
            //$('.edit_template_value_time_type_input').prop('disabled', true);
            $('.edit_template_value_time_type_input').hide();
           // $('.edit_template_value_time_type_input').removeClass('error');
            
        }
        // if($('.error').length>0){
        //     $('.if_error_show_msg').show();
        // }else{
        //     $('.if_error_show_msg').hide();
        // }
    })
    $(document).on("click",".check_edit_tamplate_hpd_value",function(e) {
        check_edit_template_popup_validation();
        if($(this).is(":checked")){
            if(!$('.edit_template_value_hour_per_day').val()){
                $('.edit_template_value_hour_per_day').focus();
            }
            $('.edit_template_value_hour_per_day').show();
        }else{
            $('.edit_template_value_hour_per_day').val('');
            $('.edit_template_value_hour_per_day').hide();
            //$('.edit_template_value_hour_per_day').removeClass('error');
            
        }
        
    })
    $(document).on("change",".dump_rate",function(e) {
        if($('.dump_fee_apply').prop('checked')==true){
            if(cleanNumber($(this).val())>0){
                $(this).removeClass('error');
            }else{
                $(this).addClass('error');
            }
        }else{
                $(this).removeClass('error');
        }
        
        
        if($('.error').length>0 || $('.select_box_error').length>0){
            $('.if_error_show_msg').show();
        }else{
            $('.if_error_show_msg').hide();
        }
    });
    
    $(document).on("change",".truck_capacity,.trip_time,.hours_per_day",function(e) {
        
        if($(this).val()){
            $(this).removeClass('error');
            //$(this).closest('div').removeClass('select_box_error');
        }else{
            $(this).addClass('error');
           // $(this).closest('div').addClass('select_box_error');
        }
        
        if($('.error').length>0 || $('.select_box_error').length>0){
            $('.if_error_show_msg').show();
        }else{
            $('.if_error_show_msg').hide();
        }
    });
    $(document).on("change",".dumpSelect,.plantSelect,.equipement_type,.equipement_item,.labor_type,.labor_item",function(e) {
        if($(this).val()){
            $(this).closest('td').find('.select2').removeClass('select2_box_error');
        }else{
            $(this).closest('td').find('.select2').addClass('select2_box_error');
        }
        if($('.error').length>0 || $('.select2_box_error').length>0){
            $('.if_error_show_msg').show();
        }else{
            $('.if_error_show_msg').hide();
        }
    });
    
    $(document).on("keyup","#custom_item_name,#custom_item_quantity,#custom_item_unit_price,#custom_child_item_name,#custom_child_item_quantity,#custom_child_item_unit_price,.equipement_number_of_person,.equipement_time_type_input,.equipement_hour_per_day,.labor_number_of_person,.labor_time_type_input,.labor_hour_per_day,.truck_capacity,.hours_per_day,.trip_time,#fees_child_item_name,#fees_child_item_quantity,#fees_child_item_unit_price",function(e) {
        var code = e.keyCode || e.which;
        
        if(code!=9){
            if($(this).val()){
            $(this).removeClass('error');
            }else{
                $(this).addClass('error');
            }
            if($('.error').length>0 || $('.select_box_error').length>0 || $('.select2_box_error').length>0){
                $('.if_error_show_msg').show();
            }else{
                $('.if_error_show_msg').hide();
            }
        }
        
    });

    $(document).on("keyup","#number_of_person,#time_type_input,#hour_per_day,.sep_trucking_malerial,.sep_truck_capacity,#sep_trucking_start_searchBox,#sep_trucking_end_searchBox,.sep_trip_time,.sep_hours_per_day,.sep_truck_per_day,#measurement,#depth,#crackseakLength,#sealcoatArea,#stripingFeet,#concrete_measurement,#concrete_depth,.sep_minimum_hours",function(e) {
        var code = e.keyCode || e.which;
        
        if(code!=9){
            if($(this).val()){
                $(this).removeClass('error');
            }else{
                $(this).addClass('error');
            }
            if($('.error').length>0 || $('.select_box_error').length>0){
                $('.if_error_show_msg_parent').show();
            }else{
                $('.if_error_show_msg_parent').hide();
            }
        }
    });



    $(document).on("change",".sep_plant_turnaround,.sep_site_turnaround,.sand_sealer_item,.additive_sealer_item",function(e) {
        
        if($(this).val()){
            $(this).closest('div').removeClass('select_box_error');
        }else{
            $(this).closest('div').addClass('select_box_error');
        }
        if($('.error').length>0 || $('.select_box_error').length>0){
            $('.if_error_show_msg_parent').show();
        }else{
            $('.if_error_show_msg_parent').hide();
        }
    });
    $(document).on("change",".plant_turnaround,.site_turnaround,.site_turnaround2,.trucking_item",function(e) {
        
        if($(this).val()){
            $(this).closest('div').removeClass('select_box_error');
        }else{
            $(this).closest('div').addClass('select_box_error');
        }
        if($('.error').length>0 || $('.select_box_error').length>0){
            $('.if_error_show_msg').show();
        }else{
            $('.if_error_show_msg').hide();
        }
    });


    $(document).on("keyup",".field_input",function() {

        var field_new_value = $(this).val();
        unsave_cal=true;
        var error =false; 
        $this =$(this);

                if(calculator_form_id=='striping_form'){
                    
                        if($this.closest('li').attr('data-measurement-field')=='1'){
                            error =true;
                            $('#stripingFeet').val(field_new_value);
                        }
                    
                    stripingPaintRender();
                }else if(calculator_form_id=='sealcoating_form'){
                    
                        if($this.closest('li').attr('data-measurement-field')=='1'){
                            error =true;
                            $('#sealcoatArea').val(field_new_value);
                        }
                        if($this.closest('li').attr('data-unit-field')=='1'){
                            
                            
                            if(field_new_value=='square feet'){
                                $('#sealcoatUnit').val('square feet');
                                $('.total_surface_unit_text').text('Sq. Feet');
                                $('.total_surface_unit_text2').text('Foot');
                            }else{
                                $('#sealcoatUnit').val('square yard');
                                $('.total_surface_unit_text').text('Sq. Yds.');
                                $('.total_surface_unit_text2').text('Yard');
                            }
                            setDropdowns();
                        $.uniform.update();
                        }
                    
                    sealcoatCalculator();
                }else if(calculator_form_id=='crack_sealer_form'){
                    
                        if($this.closest('li').attr('data-measurement-field')=='1'){
                            error =true;
                            $('#crackseakLength').val(field_new_value);
                        }
                 
                    cracksealCalculator()
                }else if(calculator_form_id=='asphalt_form'){
                    if($this.closest('li').attr('data-measurement-field')=='1'){
                        error =true;
                        $('#measurement').val(field_new_value);
                    }
                    if(head_type_id == gravel_type_id){
                                if($this.closest('li').attr('data-gravel-depth-field')=='1'){
                                    error =true;
                                       $('#depth').val(field_new_value);
                                   }
                    }else if(head_type_id == base_asphalt_type_id){
                        if($this.closest('li').attr('data-base-depth-field')=='1'){
                            error =true;
                            $('#depth').val(field_new_value);
                        }
                    }else if(head_type_id == excavation_type_id){
                        if($this.closest('li').attr('data-excavation-depth-field')=='1'){
                            error =true;
                            $('#depth').val(field_new_value);
                        }
                    }else{
                        if($this.closest('li').attr('data-depth-field')=='1'){
                            error =true;
                            $('#depth').val(field_new_value);
                        }
                    }
                   
                    if($this.closest('li').attr('data-unit-field')=='1'){
                        
                       
                        
                        if(field_new_value=='square feet'){
                              $('.measurement_unit').val('square feet');
                         }else{
                             $('.measurement_unit').val('square yard');
                         }
                        
                    }
                    setDropdowns();
                    $.uniform.update();
                   
                    calculate_measurement();
                }else if(calculator_form_id=='concrete_form'){
                    if($this.closest('li').attr('data-measurement-field')=='1'){
                        error =true;
                        $('#concrete_measurement').val(field_new_value);
                    }
                    
                    if($this.closest('li').attr('data-depth-field')=='1'){
                        error =true;
                        $('#concrete_depth').val(field_new_value);
                    }
                    if($this.closest('li').attr('data-excavation-depth-field')=='1'){
                        error =true;
                        $('#concrete_depth').val(field_new_value);
                    }
                               
                    unsave_cal=true;
                   setDropdowns();
                    $.uniform.update();
                   
                    calculate_concrete_measurement();
                }
                //$('.if_ast_change').show();
                if(error){
                    if($(this).val()){
                        $(this).removeClass('error');
                    }else{
                        $(this).addClass('error');
                    }
                    if($('.error').length>0 || $('.select_box_error').length>0){
                        $('.if_error_show_msg_parent').show();
                    }else{
                        $('.if_error_show_msg_parent').hide();
                    }
                }

    });

$(document).on("click",".field_input",function() {
    var field_new_value = $(this).val();
    $(this).val('');
    $(this).val(field_new_value);
});

$(document).on("focusin",".field_input",function() {

    var field_new_value = $(this).val();
    $this =$(this);
    
        if(calculator_form_id=='striping_form'){
            
                if($this.closest('li').attr('data-measurement-field')=='1'){
                    $('#stripingFeet').closest('td').addClass('orange');
                }
            
            
        }else if(calculator_form_id=='sealcoating_form'){
            
                if($this.closest('li').attr('data-measurement-field')=='1'){
                    $('#sealcoatArea').closest('td').addClass('orange');
                }
                if($this.closest('li').attr('data-unit-field')=='1'){
                    
                    
                    if(field_new_value=='square feet'){
                        $('#sealcoatUnit').closest('td').addClass('orange');
                    }else{
                        $('#sealcoatUnit').closest('td').addClass('orange');
                    }
                
                }
            
        }else if(calculator_form_id=='crack_sealer_form'){
             
                if($this.closest('li').attr('data-measurement-field')=='1'){
                    $('#crackseakLength').closest('td').addClass('orange');
                }
         
            
        }else if(calculator_form_id=='asphalt_form'){
            
            if($this.closest('li').attr('data-measurement-field')=='1'){
               
                $('#measurement').closest('td').addClass('orange');
            }
            if(head_type_id == gravel_type_id){
                           
                if($this.closest('li').attr('data-gravel-depth-field')=='1'){
                    $('#depth').closest('td').addClass('orange');
                }
            }else if(head_type_id == base_asphalt_type_id){
                            
                if($this.closest('li').attr('data-base-depth-field')=='1'){
                    $('#depth').closest('td').addClass('orange');
                }
            }else if(head_type_id == excavation_type_id ){
                        if($this.closest('li').attr('data-excavation-depth-field')=='1'){
                            $('#depth').closest('td').addClass('orange');
                        }
            }else{
                if($this.closest('li').attr('data-depth-field')=='1'){
                    $('#depth').closest('td').addClass('orange');
                }
            }
           
            if($this.closest('li').attr('data-unit-field')=='1'){
                
               
                
                if(field_new_value=='square feet'){
                      $('.measurement_unit').closest('td').addClass('orange');
                 }else{
                     $('.measurement_unit').closest('td').addClass('orange');
                 }
                
            }
        }else if(calculator_form_id=='concrete_form'){
            if($this.closest('li').attr('data-measurement-field')=='1'){
                $('#concrete_measurement').closest('td').addClass('orange');
            }
            
            if($this.closest('li').attr('data-excavation-depth-field')=='1'){
                $('#concrete_depth').closest('td').addClass('orange');
            }
            
        }
         $(this).val('');
         $(this).val(field_new_value);

});

$(document).on("focusout, blur",".field_input",function() {
    var field_new_value = $(this).val();

    $this =$(this);

        if(calculator_form_id=='striping_form'){
            
                if($this.closest('li').attr('data-measurement-field')=='1'){
                    $('#stripingFeet').closest('td').removeClass('orange');
                }
            
            
        }else if(calculator_form_id=='sealcoating_form'){
            
                if($this.closest('li').attr('data-measurement-field')=='1'){
                    $('#sealcoatArea').closest('td').removeClass('orange');
                }
                if($this.closest('li').attr('data-unit-field')=='1'){
                    
                    
                    if(field_new_value=='square feet'){
                        $('#sealcoatUnit').closest('td').removeClass('orange');
                    }else{
                        $('#sealcoatUnit').closest('td').removeClass('orange');
                    }
                
                }
            
        }else if(calculator_form_id=='crack_sealer_form'){
            
                if($this.closest('li').attr('data-measurement-field')=='1'){
                    $('#crackseakLength').closest('td').removeClass('orange');
                }
         
            
        }else if(calculator_form_id=='asphalt_form'){
            if($this.closest('li').attr('data-measurement-field')=='1'){
                $('#measurement').closest('td').removeClass('orange');
            }
            if(head_type_id == gravel_type_id){
                           
                if($this.closest('li').attr('data-gravel-depth-field')=='1'){
                        $('#depth').closest('td').removeClass('orange');
                    }
            }else if(head_type_id == base_asphalt_type_id){
                            
                            if($this.closest('li').attr('data-base-depth-field')=='1'){
                                $('#depth').closest('td').removeClass('orange');
                            }
            }else if(head_type_id == excavation_type_id ){
                if($this.closest('li').attr('data-excavation-depth-field')=='1'){
                    $('#depth').closest('td').removeClass('orange');
                }
            }else{
                if($this.closest('li').attr('data-depth-field')=='1'){
                    $('#depth').closest('td').removeClass('orange');
                }
            }
           
            if($this.closest('li').attr('data-unit-field')=='1'){
                
               
                
                if(field_new_value=='square feet'){
                      $('.measurement_unit').closest('td').removeClass('orange');
                 }else{
                     $('.measurement_unit').closest('td').removeClass('orange');
                 }
                
            }
        }else if(calculator_form_id=='concrete_form'){
            if($this.closest('li').attr('data-measurement-field')=='1'){
                $('#concrete_measurement').closest('td').removeClass('orange');
            }
            
            if($this.closest('li').attr('data-excavation-depth-field')=='1'){
                $('#concrete_depth').closest('td').removeClass('orange');
            }
            
        }

});

    $(document).on("change",".field_input",function() {
        unsave_cal=true; 
    var field_new_value = $(this).val();
    $this =$(this);

         if(calculator_form_id=='asphalt_form'){
    
            
            if($this.closest('li').attr('data-unit-field')=='1'){
                
               
                
                if(field_new_value=='square feet'){
                    $('.measurement_unit').val('square feet');
                 }else{
                     $('.measurement_unit').val('square yard');
                 }
                
            }
            setDropdowns();
            $.uniform.update();
            custom_price_total = false;
            calculate_measurement();
        }else if(calculator_form_id=='sealcoating_form'){
                    
                    if($this.closest('li').attr('data-unit-field')=='1'){
                        
                        
                        if(field_new_value=='square feet'){
                            $('#sealcoatUnit').val('square feet');
                            $('.total_surface_unit_text').text('Sq. Feet');
                            $('.total_surface_unit_text2').text('Foot');
                        }else{
                            $('#sealcoatUnit').val('square yard');
                            $('.total_surface_unit_text').text('Sq. Yds.');
                            $('.total_surface_unit_text2').text('Yard');
                        }
                        setDropdowns();
                    $.uniform.update();
                    }
                
                sealcoatCalculator();
            }
        //$('.if_ast_change').show();

});

    $(document).on("click",".save_sidebar_estimate",function(e) {
        var fields = [];
        //var est_items = [];
        

        $(this).closest('ul').find('li').each(function(i,li){
                            $(li).find('.field_input').val();
                            var li_id = $(li).find('.field_input').attr('id');
                            if(li_id){
                                var li_id = li_id.replace(new RegExp("^" + 'input_'), '');
                                var field_new_value = $(li).find('.field_input').val()
                                fields.push({
                                    'fieldId':li_id,
                                    'fieldValue':field_new_value,
                                });
                            }
                            var field_id =$(li).data('field-id');
        
                $( "li[data-field-id='"+field_id+"']" ).find('.field_input').val(field_new_value);
                $( "li[data-field-id='"+field_id+"']" ).find('.show_input_span').text(field_new_value);
                           
        });
        $.ajax({
            url: '/ajax/updateFieldValues/',
            type: 'post',
            data: {
                'fields':fields
            },
            success: function(data){
                swal(
                        'Estimate values saved',
                        ''
                    );
                   
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }
        });               

    });

    $(document).on("click",".save_estimation",function(e) {

        var estimate_line_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
                

        if(calculator_form_id=='time_type_form' && estimate_line_id && estimate_line_id > 0){
        var days =  $('#time_type_input').val();
        
        $.ajax({
                    url: '/ajax/check_child_parent_days_quantity/',
                    type: 'post',
                    data: {
                        
                        'estimate_line_id':estimate_line_id,
                        'days':days,
                        
                    },
                    success: function(data){
                        data = JSON.parse(data);
                        if(data.success==0){
                            swal({
                                title: "Warning",
                                text: "The <strong>Days</strong> value you entered does not match the days value of related items. <br /><br />Continue?",
                                showCancelButton: true,
                                confirmButtonText: 'Save Item',
                                cancelButtonText: "Cancel",
                                dangerMode: false,
                            }).then(function(isConfirm) {
                                if (isConfirm) {
                                    save_estimation();
                                } else {
                                    return false;
                                }
                            });
                        }else{
                            save_estimation();
                        }
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        swal("Error", "An error occurred Please try again");
                        console.log( errorThrown );
                        
                    }
                })
            }else{
                save_estimation();
            }

    }); 

  function save_estimation(){
    // alert('save2')
        disposal_load_check = 0;
        disposal_loads = 0;
        disposal_unit_price = 0.00;
        swal({
            title: 'Saving..',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timer: 2000,
            onOpen: () => {
            swal.showLoading();
            }
        });

        $('#'+item_line_id).find('.cssloader').show();
        var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
        var fields = [];
        var form_data = $("#"+calculator_form_id).serializeArray(); 
        
        if(calculator_form_id=='asphalt_form'){
            var service_box_id = '#service_html_box3';
        }else if(calculator_form_id=='concrete_form'){
            var service_box_id = '#service_html_box4';
            
            if($('.cal_disposal_checkbox').prop("checked")){
                disposal_load_check = 1;
                disposal_loads = cleanNumber($('.cal_disposal_input').val());
                disposal_unit_price = cleanNumber($('.cal_disposal_per_load_input').val());
            }

        } else if(calculator_form_id=='sealcoating_form'){
            var service_box_id = '#service_html_box5';
        }else if(calculator_form_id=='striping_form'){
            var service_box_id = '#service_html_box6';
        }else if(calculator_form_id=='crack_sealer_form'){
            var service_box_id = '#service_html_box7';
        }
    
    for($i=0;$i<form_data.length;$i++){
       
        var $form = $("#"+calculator_form_id);
                           
        var $field = $form.find('[name=' + form_data[$i].name + ']');
        if($field.attr('data-field-code')){
        form_data[$i].field_code = $field.attr('data-field-code');
        }
    }
       $(service_box_id).find('li').each(function(i,li){
                $(li).find('.field_input').val();
                var li_id = $(li).find('.field_input').attr('id');
                if(li_id){
                    var li_id = li_id.replace(new RegExp("^" + 'input_'), '');
                    var field_new_value = $(li).find('.field_input').val()
                    fields.push({
                        'fieldId':li_id,
                        'fieldValue':field_new_value,
                    });
                }
                            var field_id =$(li).data('field-id');
                if($("li[data-field-id='"+field_id+"']" ).find('.field_input').prop('type') == 'text' ) 
                {
                    $("li[data-field-id='"+field_id+"']" ).find('.field_input').attr('value',field_new_value);
                }else{
                    $("li[data-field-id='"+field_id+"']" ).find('.field_input option').removeAttr('selected').filter('[value="'+field_new_value+'"]').attr('selected', true)
                }          
                
                
                $("li[data-field-id='"+field_id+"']" ).find('.show_input_span').text(field_new_value);
                           
        });
        total_price = cleanNumber($('#'+calculator_form_id).find('.cal_total_price').text());
        //var form_data = $("#"+calculator_form_id).serializeArray();
        var lineItems =[];

        //var unit_price = $('#'+item_line_id).find('.unit-price').val();
        
        item_id = $('#'+item_line_id).find('.open_calculator').data('item-id');
        var template_type_id = $('#'+item_line_id).find('.open_calculator').data('template-type-id');
        
        // var template = $('#'+item_line_id).find('.open_calculator').data('templates');
        // if(template){
        //     var template_type_id = $('.select_template_option').val();
        
        // }else{
        //     var template_type_id = $('#'+item_line_id).find('.open_calculator').data('template-type-id');
        // }
        if(!template_type_id){
            template_type_id = '0';
        }
        var original_unit_price = $('#'+item_line_id).find('.open_calculator').data('item-unit-price');
        var estimate_line_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');

        if (parseFloat(item_price) == parseFloat(original_unit_price) ){
            var customUnitPrice =0;
        } else {
            var customUnitPrice =1;
        }
        
            lineItems.push({
                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                'customUnitPrice':customUnitPrice,
                'proposalServiceId':proposal_service_id,
                'id':estimate_line_id,
                'itemId':item_id,
                'PhaseId':phase_id,
                'quantity':item_quantity,
                'unitPrice':item_price,
                'totalPrice':total_price,
                'overHeadRate':overheadRate,
                'profitRate':profitRate,
                'overHeadPrice':overheadPrice,
                'profitPrice':profitPrice,
                'basePrice':item_base_price,
                'taxRate':taxRate,
                'taxPrice':taxPrice,
                'truckingOverHeadRate': cal_trucking_oh,
                'truckingProfitRate': cal_trucking_pm,
                'truckingOverHeadPrice': cal_trucking_oh_Price,
                'truckingProfitPrice': cal_trucking_pm_Price,
                'truckingTotalPrice': cal_trucking_total_Price,
                'sub_id':'0',
                'template_type_id':template_type_id,
                'edited_unit_price':edited_unit_price,
                'edited_base_price':edited_base_price,
                'edited_total_price':edited_total_price,
                'disposal_load_check':disposal_load_check,
                'disposal_loads':disposal_loads,
                'disposal_unit_price':disposal_unit_price,

            });

        //}


        $.ajax({
            url: '/ajax/saveEstimatorValues/',
            type: 'post',
            data: {
                'lineItems':lineItems,
                'proposalServiceId':proposal_service_id,
                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                'apply':0,
                'PhaseId':phase_id,
                'values':form_data,
                'calculator_name':calculator_form_id,
                'itemId':item_id,
                'calculation_id':estimate_calculator_id,
                'fields':fields
            },
            success: function(data){
                try{
                    data = JSON.parse(data);
                } catch (e) {
                    $('#'+item_line_id).find('.cssloader').hide();
                    swal("Error", "An error occurred Please try again");
                    return false;
                }
                revert_adjust_price1();
                if(calculator_form_id=='sealcoating_form'){
                    if(estimate_line_id){
                        deleteOldSealcoatChildItem(data.lineItemId);
                    }else{
                        
                        sealcoatchilditemadd(data.lineItemId);
                    }
                    
                }else{
                    get_service_item_list_by_phase_id(); 
                }
               
                $('.service_total_'+proposal_service_id).val(data.estimate.service_price);
                $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                
                if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                if(has_custom_total_price_update){
                    update_custom_itam_total(calculator_form_id,data.lineItemId);
                }
               
                if(has_custom_parent_total_price_update){
                    update_custom_parent_itam_total(calculator_form_id,data.lineItemId);
                }

                if(!has_custom_total_price_update && !has_custom_parent_total_price_update){
                    swal(
                        'Estimate Saved',
                        ''
                    );
                }
                //get_all_line_item_data();
                //save_service_estimate_total_price(data.total_price);
                unsaved = false;
                unsave_cal=false;
                unsaved_row = false;
                unsave_trucking_cal=false;
                
                
                //get_service_item_list();
               
                get_proposal_breakdown();
                //update_proposal_overhead_profit();
                revert_adjust_price();
               

                
                $("#quantity_calculation").dialog('close');
                if(data.estimate.completed==0){
                    $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                }else{
                    $('#service_'+proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                    if(check_est_completed){
                        $('.item_summary_btn').show();
                        temp_count = temp_count-1;
                        if(temp_count==0){
                            $('.show_pending_est_msg').hide();
                            $('.welcome_msg').hide();
                            $('.show_complete_est_msg').show();
                        }else{

                            $('.show_pending_est_msg').text('You have '+temp_count+' additional services that you need to Estimate');
                            $('.show_pending_est_msg').show();
                            $('.welcome_msg').hide();
                            $('.show_complete_est_msg').hide();
                        }
                    }
                }

                if(data.estimate.child_has_updated_flag==0 ){
                    $('.service_child_has_updated_flag_'+proposal_service_id).hide();
                    $('#service_'+proposal_service_id+' .toggle').addClass('text-active-color').removeClass('text-active-color2');
                    $('#service_'+proposal_service_id+' .toggle').css('background-color','#aeaeae');
                }
         if(data.estimate.custom_price==0){
                    $('#adjusted_total_'+proposal_service_id).hide();
                    $('.span_adjusted_total_'+proposal_service_id).text('$0');
                    $('.adjusted_total_'+proposal_service_id).val(0);
                    $('#adjusted_total_'+proposal_service_id).attr('data-adjusted-price','0');
                }
                

                $('#estimateLineItemTable').DataTable().ajax.reload();
                $('.cssloader').hide();
                $('.old_total_val_save'+proposal_service_id).val(data.estimate.service_price);
            },
            error: function( jqXhr, textStatus, errorThrown ){
                swal("Error", "An error occurred Please try again");
                console.log( errorThrown );
                
            }
        })
        
    }

function save_trucking_estimation(perent_item_id){
    total_price = calTotalPrice;
    //calculation_id
        var lineItems =[];
        
        var form_data = $("#temp_trucking_form").serializeArray();
        //var unit_price = $('#'+item_line_id).find('.unit-price').val();
        
        var base_unit_price = cleanNumber($('#map_model').find('.trucking_item').find(':selected').attr('data-unit-price'));
        var temp_item_id = $('#map_model').find('.trucking_item').val();
        var dump_rate =$('#map_model').find('.dump_rate').val();
        var dump_fee_apply =$('#map_model').find('.dump_fee_apply').prop("checked")? 1 : 0;
        var temp_unit_price = cleanNumber($('#map_model').find('.cal_trucking_unit_price').text());
        var original_unit_price = $('#'+item_line_id).find('.open_calculator').data('item-unit-price');
        //var perent_item_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
        var total_time_hours = $('#map_model').find('.total_time_hours').val();
        var temp_cal_trucking_total_Price = cleanNumber($('#map_model').find('.cal_trucking_total_price').text());
        var plant_id = $('.plantSelect').val();
        if(parseFloat(item_price) == parseFloat(original_unit_price) ){
            var customUnitPrice =0;
        }else{
            var customUnitPrice =1;
        }
        


            lineItems.push({
                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                'customUnitPrice':customUnitPrice,
                'proposalServiceId':proposal_service_id,
                'parentId':perent_item_id,
                'id':child_lineItemId,
                'itemId':temp_item_id,
                'plantId':plant_id,
                'PhaseId':phase_id,
                'quantity':total_time_hours,
                'unitPrice':temp_unit_price,
                'totalPrice':temp_cal_trucking_total_Price,
                'overHeadRate':cal_trucking_oh,
                'profitRate':cal_trucking_pm,
                'overHeadPrice':cal_trucking_oh_Price,
                'profitPrice':cal_trucking_pm_Price,
                'basePrice':base_unit_price,
                'taxRate':0,
                'taxPrice':0,
                'truckingOverHeadRate': cal_trucking_oh,
                'truckingProfitRate': cal_trucking_pm,
                'truckingOverHeadPrice': cal_trucking_oh_Price,
                'truckingProfitPrice': cal_trucking_pm_Price,
                'truckingTotalPrice': temp_cal_trucking_total_Price,
                'sub_id':'0',
                'dump_rate':dump_rate,
                'dump_fee_apply':dump_fee_apply,
                'edited_unit_price':edited_unit_price,
                'edited_base_price':edited_base_price,
                'edited_total_price':edited_total_price,
            });



            $.ajax({
            url: '/ajax/saveEstimatorValues2/',
            type: 'post',
            data: {
                'lineItems':lineItems,
                'proposalServiceId':proposal_service_id,
                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                'itemId':temp_item_id,
                'values':form_data,
                'PhaseId':phase_id,
                'calculation_id':calculation_id,
                'apply':0,
            },
            success: function(data){
                data = JSON.parse(data);
                unsave_cal=false;  
                
                
                revert_adjust_price1();
                
                //get_service_item_list();
                
                //update_proposal_overhead_profit();
                $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                
                //get_all_line_item_data();
                //save_service_estimate_total_price(data.total_price);
                var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
                unsaved = false;
                unsaved_row = false;
                if(data.estimate.completed==0){
                    $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                }else{
                    $('#service_'+proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                    if(check_est_completed){
                        $('.item_summary_btn').show();
                        temp_count = temp_count-1;
                        if(temp_count==0){
                            $('.show_pending_est_msg').hide();
                            $('.welcome_msg').hide();
                            $('.show_complete_est_msg').show();
                        }else{

                            $('.show_pending_est_msg').text('You have '+temp_count+' additional services that you need to Estimate');
                            $('.show_pending_est_msg').show();
                            $('.welcome_msg').hide();
                            $('.show_complete_est_msg').hide();
                        }
                    }
                }
                if(data.estimate.child_has_updated_flag==0 ){
                    $('.service_child_has_updated_flag_'+proposal_service_id).hide();
                    $('#service_'+proposal_service_id+' .toggle').addClass('text-active-color').removeClass('text-active-color2');
                    $('#service_'+proposal_service_id+' .toggle').css('background-color','#aeaeae');
                }

                $('.service_total_'+proposal_service_id).val(data.estimate.service_price);


                swal(
                    'Estimate Saved',
                    ''
                );

                if(has_custom_trucking_total_price_update){
                    update_custom_trucking_itam_total(data.lineItemId,perent_item_id);

                }else{
                    get_service_item_list_by_phase_id();
                    get_proposal_breakdown();
                    swal('Estimate Saved','');
                    get_child_items_list(perent_item_id,false,true);
                }
                
                
                $('.if_item_saved').show();
                child_save_done =true;
                $("#map_model").dialog('close');
                $('#estimateLineItemTable').DataTable().ajax.reload();
                
            },
            error: function( jqXhr, textStatus, errorThrown ){
                swal("Error", "An error occurred Please try again");
                console.log( errorThrown );
            }
        })
}
    $(document).on("click",".save_trucking_estimation",async function(e) {    
        var estimate_line_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
        var unit_type_id = $('#'+item_line_id).find('.open_calculator').attr('data-unit-type-id');
        var days =  $('.trucking_day').val();
        $(".save_trucking_estimation").addClass('ui-state-disabled');
        $(".save_trucking_estimation").attr('disabled',true);

        // AL - TEmp removed this as it was breaking other trucking
        if($('.dump_fee_apply').prop('checked')==true && cleanNumber($('.dump_rate').val())<1){
            $('.dump_rate').trigger('change');
            return false;
        }
    
        
        
        if(!estimate_line_id){
            if(unit_type_id==time_type_id){
                
                var parent_days =  $('#time_type_input').val();
            
            
            if(days != parent_days){

                swal({
                        title: "Warning",
                        text: "The <strong>Days</strong> value you entered does not match the days value of related items. <br /><br />Continue?",
                        showCancelButton: true,
                        confirmButtonText: 'Save Item',
                        cancelButtonText: "Cancel",
                        dangerMode: false,
                    }).then(function(isConfirm) {
                        if (isConfirm) {
                            after_days_check_save_trucking_estimation();
                        } else {
                            return false;
                        }
                    });
                }else{
                    after_days_check_save_trucking_estimation();
                }
            }else{
                after_days_check_save_trucking_estimation();
            }
        }else{

                    $.ajax({
                                url: '/ajax/check_child_parent_days_quantity/',
                                type: 'post',
                                data: {
                                    'child_line_id':child_lineItemId,
                                    'estimate_line_id':estimate_line_id,
                                    'days':days,
                                    
                                },
                                success: function(data){
                                    data = JSON.parse(data);
                                    if(data.success==0){
                                        swal({
                                            title: "Warning",
                                            text: "The <strong>Days</strong> value you entered does not match the days value of related items. <br /><br />Continue?",
                                            showCancelButton: true,
                                            confirmButtonText: 'Save Item',
                                            cancelButtonText: "Cancel",
                                            dangerMode: false,
                                        }).then(function(isConfirm) {
                                            if (isConfirm) {
                                                after_days_check_save_trucking_estimation();
                                            } else {
                                                return false;
                                            }
                                        });
                                    }else{
                                        after_days_check_save_trucking_estimation();
                                    }
                                },
                                error: function( jqXhr, textStatus, errorThrown ){
                                    swal("Error", "An error occurred Please try again");
                                    console.log( errorThrown );
                                    
                                }
                            })
                        
        }

    });
    
function after_days_check_save_trucking_estimation(){
    swal({
            title: 'Saving..',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timer: 2000,
            onOpen: () => {
            swal.showLoading();
            }
        });
        var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
        var fields = [];
         
       if(calculator_form_id=='asphalt_form'){
           $('#service_html_box3').find('li').each(function(i,li){
                            $(li).find('.field_input').val();
                            var li_id = $(li).find('.field_input').attr('id');
                            if(li_id){
                                var li_id = li_id.replace(new RegExp("^" + 'input_'), '');
                                var field_new_value = $(li).find('.field_input').val()
                                fields.push({
                                    'fieldId':li_id,
                                    'fieldValue':field_new_value,
                                    
                                });
                            }
                            var field_id =$(li).data('field-id');
        
                $( "li[data-field-id='"+field_id+"']" ).find('.field_input').attr('value',field_new_value);
                $( "li[data-field-id='"+field_id+"']" ).find('.show_input_span').text(field_new_value);
                           
        });
       }

       total_price = cleanNumber($('#'+calculator_form_id).find('.cal_total_price').text());
       var form_data = $("#"+calculator_form_id).serializeArray();
       for($i=0;$i<form_data.length;$i++){
       
            var $form = $("#"+calculator_form_id);
                                
            var $field = $form.find('[name=' + form_data[$i].name + ']');
            if($field.attr('data-field-code')){
            form_data[$i].field_code = $field.attr('data-field-code');
            }
        
        }
        var lineItems =[];

        //var unit_price = $('#'+item_line_id).find('.unit-price').val();
        

        item_id = $('#'+item_line_id).find('.open_calculator').data('item-id');
        var template = $('#'+item_line_id).find('.open_calculator').data('templates');
        if(template){
            var template_type_id = $('.select_template_option').val();
        
        }else{
            var template_type_id = $('#'+item_line_id).find('.open_calculator').data('template-type-id');
        }
        if(!template_type_id){
            template_type_id = '0';
        }
        var original_unit_price = $('#'+item_line_id).find('.open_calculator').data('item-unit-price');
        var estimate_line_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
  
        if(parseFloat(item_price) == parseFloat(original_unit_price) ){
            var customUnitPrice =0;
        }else{
            var customUnitPrice =1;
        }
        //if(item_quantity>0 && total_price>0){


            lineItems.push({
                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                'customUnitPrice':customUnitPrice,
                'proposalServiceId':proposal_service_id,
                'id':estimate_line_id,
                'itemId':item_id,
                'PhaseId':phase_id,
                'quantity':item_quantity,
                'unitPrice':item_price,
                'totalPrice':total_price,
                'overHeadRate':overheadRate,
                'profitRate':profitRate,
                'overHeadPrice':overheadPrice,
                'profitPrice':profitPrice,
                'basePrice':item_base_price,
                'taxRate':taxRate,
                'taxPrice':taxPrice,
                'truckingOverHeadRate': cal_trucking_oh,
                'truckingProfitRate': cal_trucking_pm,
                'truckingOverHeadPrice': cal_trucking_oh_Price,
                'truckingProfitPrice': cal_trucking_pm_Price,
                'truckingTotalPrice': cal_trucking_total_Price,
                'sub_id':'0',
                'template_type_id':template_type_id,
                'edited_unit_price':edited_unit_price,
                'edited_base_price':edited_base_price,
                'edited_total_price':edited_total_price,
            });

        //}
        // }

//})
//})

        $.ajax({
            url: '/ajax/saveEstimatorValues/',
            type: 'post',
            data: {
                'lineItems':lineItems,
                'proposalServiceId':proposal_service_id,
                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                'apply':0,
                'values':form_data,
                'itemId':item_id,
                'PhaseId':phase_id,
                'calculator_name':calculator_form_id,
                'calculation_id':estimate_calculator_id,
                'fields':fields
            },
            success: function(data){
                try{
                    data = JSON.parse(data);
                } catch (e) {
                    swal("Error", "An error occurred Please try again");
                    return false;
                }
                
                save_trucking_estimation(data.lineItemId)
            },
            error: function( jqXhr, textStatus, errorThrown ){
                swal("Error", "An error occurred Please try again");
                console.log( errorThrown );
            }
        })
}
    function get_child_items_list(perent_line_item_id,show_popup,if_change_parent=false){
        console.log(perent_line_item_id);
        $('.if_tax_total,#groupAction').hide();
        $('.labor_child_icon,.trucking_child_icon,.equipement_child_icon,.custom_child_icon,.fees_child_icon,.permit_child_icon').removeClass('child_icons_active');
        $.ajax({
            url: '/ajax/getChildItems/'+perent_line_item_id,
            type: 'get',
            success: function(data){
                data = JSON.parse(data);
                
                if(data.length>0){
                    var check_equipment_child = false;
                    var check_trucking_child = false;
                    var check_labor_child = false;
                    var check_custom_child = false;
                    var check_fees_child = false;
                    var check_permit_child = false;
                    var total_equipment_child = 0;
                    var total_equipment_child_tax = 0;
                    var total_trucking_child = 0;
                    var total_trucking_child_tax = 0;
                    var total_labor_child = 0;
                    var total_labor_child_tax = 0;
                    var total_custom_child = 0;
                    var total_custom_child_tax = 0;
                    var total_child_tax = 0;

                    var total_fees_child = 0;
                    var total_fees_child_tax = 0;

                    var total_permit_child = 0;
                    var total_permit_child_tax = 0;
                    has_trucking_child = false;
                    var sealcoat_defualt_child_total =0;
                    var is_sealcoat_defualt=false;
                    has_child_items =true;
                    var html = '<table  class="child_items_table" ><thead><tr><th  class="child_checkbox_pad" ><input style="position: relative;top: 3px;" type="checkbox" class="check_all_childs" ></th><th ></th><th ></th><th >Type</th><th >Item</th><th >Unit Price</th><th >Qty</th><th class="child_checkbox_pad">Days</th><th class="child_checkbox_pad">#</th><th class="child_checkbox_pad">Hrs</th><th >Total Price</th><th></th></tr></thead><tbody>';
                                   for($i=0;$i<data.length;$i++){
                                    var is_hide_delete_btn = '';
                                    var temp_item_type = data[$i].item_type_name;
                                    if(data[$i].item_id==0){
                                        if(data[$i].fees==1){
                                            temp_item_type ='Fees';
                                            var open_class = 'open_fees_child_calculator';
                                            var type_icon ='<span  class="" title="Fees"><i style ="margin-top: 4px;font-size: 1.2em;" class="fa fa-usd fa-fw fa-2x"></i></span>';
                                            check_fees_child = true;
                                            $('.fees_child_icon').addClass('child_icons_active');
                                            total_fees_child =parseFloat(total_fees_child) +parseFloat(data[$i].item_total_price);
                                            total_fees_child_tax =parseFloat(total_fees_child_tax) +parseFloat(data[$i].tax_price);
                                        }else if(data[$i].permit==1){
                                            temp_item_type ='Permit';
                                            var open_class = 'open_fees_child_calculator';
                                            var type_icon ='<span  class="" title="Permit"><i style ="margin-top: 4px;font-size: 1.2em;" class="fa fa-file-text-o fa-fw fa-2x"></i></span>';
                                            check_permit_child = true;
                                            $('.permit_child_icon').addClass('child_icons_active');
                                            total_permit_child =parseFloat(total_permit_child) +parseFloat(data[$i].item_total_price);
                                            total_permit_child_tax =parseFloat(total_permit_child_tax) +parseFloat(data[$i].tax_price);
                                        }else{
                                            var open_class = 'open_custom_child_calculator';
                                            var type_icon ='<span  class="" title="Custom"><i style ="margin-top: 4px;font-size: 1.2em;" class="fa fa-plus-square-o fa-fw fa-2x"></i></span>';
                                            check_custom_child = true;
                                            $('.custom_child_icon').addClass('child_icons_active');
                                            total_custom_child =parseFloat(total_custom_child) +parseFloat(data[$i].item_total_price);
                                            total_custom_child_tax =parseFloat(total_custom_child_tax) +parseFloat(data[$i].tax_price);
                                        }
                                        
                                        
                                        
                                    }else if(data[$i].item_category_id==equipment_category_id){
                                        var open_class = 'open_equipement_calculator';
                                        check_equipment_child = true;
                                        $('.equipement_child_icon').addClass('child_icons_active');
                                        total_equipment_child =parseFloat(total_equipment_child) +parseFloat(data[$i].item_total_price);
                                        total_equipment_child_tax =parseFloat(total_equipment_child_tax) +parseFloat(data[$i].tax_price);
                                        var type_icon ='<span  class="tiptip" title="Equipment"><i style ="margin-top: 4px;font-size: 1.2em;" class="fa fa-wrench fa-fw fa-2x"></i></span>';
                                    }else if(data[$i].item_type_id==trucking_type_id){
                                        var open_class = 'open_trucking_calculator';
                                        check_trucking_child = true;
                                        has_trucking_child = true;
                                        $('.trucking_child_icon').addClass('child_icons_active');
                                        total_trucking_child =parseFloat(total_trucking_child) +parseFloat(data[$i].item_total_price);
                                        total_trucking_child_tax =parseFloat(total_trucking_child_tax) +parseFloat(data[$i].tax_price);
                                        var type_icon ='<span  class="tiptip" title="Trucking"><i style ="margin-top: 4px;font-size: 1.2em;" class="fa fa-truck fa-fw fa-2x"></i></span>';
                                    }else if(data[$i].item_category_id==labor_category_id){
                                        var open_class = 'open_labor_calculator';
                                        check_labor_child = true;
                                        $('.labor_child_icon').addClass('child_icons_active');
                                        total_labor_child =parseFloat(total_labor_child) +parseFloat(data[$i].item_total_price);
                                        total_labor_child_tax =parseFloat(total_labor_child_tax) +parseFloat(data[$i].tax_price);                                        
                                        var type_icon ='<span  class="tiptip" title="Labor"><i style ="margin-top: 4px;font-size: 1.2em;" class="fa fa-male fa-fw fa-2x"></i></span>';
                                    }else{
                                        var open_class = 'hide_calculator';
                                        var is_hide_delete_btn = 'hide_delete_btn';
                                        sealcoat_defualt_child_total = parseFloat(sealcoat_defualt_child_total) +parseFloat(data[$i].item_total_price);
                                         is_sealcoat_defualt = true;
                                        var type_icon ='';
                                    }
                                    if(data[$i].parent_updated=='1'){var parent_updated_class = 'parent_updated'}else{var parent_updated_class = ''}
                                    if(parseFloat(data[$i].overhead_price)<0 || parseFloat(data[$i].profit_price)<0){
                                        var row_color =' table_row_negative_price';
                                    }else{
                                        var row_color ='';
                                    }
                                    

                                    if(<?php echo $proposal_status_id;?> == '5'){
                                        html +='<tr id="items_" class="'+parent_updated_class+row_color+'" style="border-bottom: 1px solid #ffffff;"><td><input type="checkbox" class="child_item_check" data-child-line-id="'+data[$i].item_eli_id+'" ></td><td><i class="fa fa-exclamation-triangle2"></i><a class="btn tiptip '+open_class+'" data-item-type-id="'+data[$i].item_type_id+'" data-calculation-id="'+data[$i].calculation_id+'" data-child-line-id="'+data[$i].item_eli_id+'" title="Recalculate Item"><i class="fa fa-fw fa-calculator"></i></a></td><td style="width:20px" data-sort="'+data[$i].item_category_id+'">'+type_icon+'</td><td style="text-align:left">'+temp_item_type+'</td><td class="" style="text-align:left!important">'+data[$i].item_name+'</td><td  style="text-align:right"><input type="text" class="text currency_field unit-price"  value="'+data[$i].item_unit_price +'" style="width: 80px;display:none"/><span  class="span_unit_price1">$'+addCommas(data[$i].item_unit_price) +' / '+data[$i].unit_single_abbr+'</span></td><td style="text-align: right;" class="" data-sort="'+data[$i].item_quantity+'"><span  class="quantity">'+addCommas(number_test2(data[$i].item_quantity))+' '+data[$i].unit+'</span></td><td>'+data[$i].day+'</td><td>'+data[$i].quantity+'</td><td>'+data[$i].hour_per_day+'</td><td class="child_table_total_price">$'+addCommas(number_test(data[$i].item_total_price))+'</td><td><a href="JavaScript:void(0);" class="estimate_child_item_notes btn tiptip"title="Item Notes"  data-child-line-id="'+data[$i].item_eli_id+'" data-perent-line-id="'+perent_line_item_id+'"><i class="fa  fa-clipboard"></i></a></td></tr>';
                                    }else{
                                        html +='<tr id="items_" class="'+parent_updated_class+row_color+'" style="border-bottom: 1px solid #ffffff;"><td><input type="checkbox" class="child_item_check" data-child-line-id="'+data[$i].item_eli_id+'" ></td><td><i class="fa fa-exclamation-triangle2"></i><a class="btn tiptip '+open_class+'" data-item-type-id="'+data[$i].item_type_id+'" data-calculation-id="'+data[$i].calculation_id+'" data-child-line-id="'+data[$i].item_eli_id+'" title="Recalculate Item"><i class="fa fa-fw fa-calculator"></i></a></td><td style="width:20px" data-sort="'+data[$i].item_category_id+'">'+type_icon+'</td><td style="text-align:left">'+temp_item_type+'</td><td class="" style="text-align:left!important">'+data[$i].item_name+'</td><td  style="text-align:right"><input type="text" class="text currency_field unit-price"  value="'+data[$i].item_unit_price +'" style="width: 80px;display:none"/><span  class="span_unit_price1">$'+addCommas(data[$i].item_unit_price) +' / '+data[$i].unit_single_abbr+'</span></td><td style="text-align: right;" class="" data-sort="'+data[$i].item_quantity+'"><span  class="quantity">'+addCommas(number_test2(data[$i].item_quantity))+' '+data[$i].unit+'</span></td><td>'+data[$i].day+'</td><td>'+data[$i].quantity+'</td><td>'+data[$i].hour_per_day+'</td><td class="child_table_total_price">$'+addCommas(number_test(data[$i].item_total_price))+'</td><td><a href="JavaScript:void(0);" class="estimate_child_item_notes btn tiptip"title="Item Notes"  data-child-line-id="'+data[$i].item_eli_id+'" data-perent-line-id="'+perent_line_item_id+'"><i class="fa  fa-clipboard"></i></a><a href="JavaScript:void(0);" class="delete_child_item btn tiptip '+is_hide_delete_btn+' " title="Delete Item"  data-child-line-id="'+data[$i].item_eli_id+'" data-perent-line-id="'+perent_line_item_id+'"><i class="fa fa-fw fa-trash"></i></a></td></tr>';
                                    }
                                    
                                    
                                    total_child_tax = parseFloat(total_child_tax) +parseFloat(data[$i].tax_price);
                                }
                                        html +='</tbody></table>';
                                        $('.child_items_list').html(html);
                                        initButtons();
                                        initTiptip();
                                        $(".child_items_table").DataTable({
                                            "paging": false,
                                            aoColumns: [{ orderable: false, targets: [0],sWidth: "2%" },
                                            { orderable: false, targets: [1] ,sWidth: "7%"},
                                            { orderable: true, targets: [2] ,sWidth: "3%"},
                                            { orderable: true, targets: [3] ,sWidth: "11%"},
                                            { orderable: true, targets: [4],sWidth: "18%" },
                                            { orderable: true, targets: [5],sWidth: "12%" },
                                            { orderable: true, targets: [6],sWidth: "13%" },
                                            { orderable: false, targets: [7],sWidth: "3%" },
                                            { orderable: false, targets: [8],sWidth: "4%" },
                                            { orderable: false, targets: [9],sWidth: "4%" },
                                            { orderable: true, targets: [10],sWidth: "13%" },
                                            { orderable: false, targets: [11],sWidth: "8%" } ],
                                            "order": [[3, "asc"]],
                                            "bSearching": false,
                                            "sDom": 'lrtp',
                                            "bJQueryUI": true,
                                            "drawCallback":function(){
                                                console.log('table_draw')
                                            }
                                        });
                                        $.uniform.update();
                    if(total_child_tax>0){
                        
                        var parent_tax = cleanNumber($('#'+calculator_form_id).find('.cal_tax_amount').text());
                        total_child_tax = parseFloat(total_child_tax) +parseFloat(parent_tax);
                          $('.if_tax_total').show();
                          $('.cal_material_total_price_tax').text(addCommas(number_test(parent_tax)));
                          $('.if_child_material_check_tax').addClass('show_child_item_tax_total');
                          $('#'+calculator_form_id).find('.cal_total_tax_amount').text(addCommas(number_test(total_child_tax)));
                    }else{
                        $('.if_tax_total').hide();
                    }
                    // if(is_sealcoat_defualt){
                    //     var final_total = parseFloat(sealcoat_defualt_child_total) +parseFloat(cleanNumber($('#'+calculator_form_id).find('.cal_total_price').text()));
                    //     $('#'+calculator_form_id).find('.cal_total_price').text(addCommas(number_test(final_total)));
                    // }else{
                        var final_total = cleanNumber($('#'+calculator_form_id).find('.cal_total_price').text());
                    //}
                    
                    var temp_final_total =final_total;
                        if(check_labor_child){
                           $('.cal_child_labor_total_price').text(addCommas(number_test(total_labor_child)));
                           if(total_labor_child_tax>0){
                            $('.cal_child_labor_total_price_tax').text(addCommas(number_test(total_labor_child_tax)));
                            $('.if_child_labor_check_tax').addClass('show_child_item_tax_total');
                           }
                           final_total =parseFloat(final_total) +parseFloat(total_labor_child);
                           $('.if_child_labor_check').addClass('show_child_item_total');
                           if(!show_popup && !if_change_parent){
                                $('.if_child_labor_check').show()
                           }
                        }else{
                            $('.if_child_labor_check').removeClass('show_child_item_total');
                            $('.if_child_labor_check_tax').removeClass('show_child_item_tax_total');
                            $('.if_child_labor_check').hide();
                            $('.if_child_labor_check_tax').hide();
                        }
                        if(check_trucking_child){
                           $('.cal_child_trucking_total_price').text(addCommas(number_test(total_trucking_child)));
                           if(total_trucking_child_tax>0){
                            $('.cal_child_trucking_total_price_tax').text(addCommas(number_test(total_trucking_child_tax)));
                            $('.if_child_trucking_check_tax').addClass('show_child_item_tax_total');
                           }
                           final_total =parseFloat(final_total) +parseFloat(total_trucking_child);
                           $('.if_child_trucking_check').addClass('show_child_item_total');
                           if(!show_popup && !if_change_parent){
                                $('.if_child_trucking_check').show()
                           }
                        }else{
                            $('.if_child_trucking_check').removeClass('show_child_item_total');
                            $('.if_child_trucking_check_tax').removeClass('show_child_item_tax_total');
                            $('.if_child_trucking_check').hide();
                            $('.if_child_trucking_check_tax').hide();
                        }
                        if(check_equipment_child){
                           $('.cal_child_equipment_total_price').text(addCommas(number_test(total_equipment_child)));
                           if(total_equipment_child_tax>0){
                            $('.cal_child_equipment_total_price_tax').text(addCommas(number_test(total_equipment_child_tax)));
                            $('.if_child_equipment_check_tax').addClass('show_child_item_tax_total');                            
                           }
                           final_total =parseFloat(final_total) +parseFloat(total_equipment_child);
                           $('.if_child_equipment_check').addClass('show_child_item_total');
                           if(!show_popup && !if_change_parent){
                                $('.if_child_equipment_check').show()
                           }
                        }else{
                            $('.if_child_equipment_check').removeClass('show_child_item_total');
                            $('.if_child_equipment_check_tax').removeClass('show_child_item_tax_total');
                            $('.if_child_equipment_check').hide();
                            $('.if_child_equipment_check_tax').hide();
                        }
                        if(check_custom_child){
                           $('.cal_child_custom_total_price').text(addCommas(number_test(total_custom_child)));
                           if(total_custom_child_tax>0){
                            $('.cal_child_custom_total_price_tax').text(addCommas(number_test(total_custom_child_tax)));
                            $('.if_child_custom_check_tax').addClass('show_child_item_tax_total');
                           }
                           final_total =parseFloat(final_total) +parseFloat(total_custom_child);
                           $('.if_child_custom_check').addClass('show_child_item_total');
                           if(!show_popup && !if_change_parent){
                                $('.if_child_custom_check').show()
                           }
                        }else{
                            $('.if_child_custom_check').removeClass('show_child_item_total');
                            $('.if_child_custom_check_tax').removeClass('show_child_item_tax_total');
                            $('.if_child_custom_check').hide();
                            $('.if_child_custom_check_tax').hide();
                        }

                        if(check_fees_child){
                           $('.cal_child_fees_total_price').text(addCommas(number_test(total_fees_child)));
                           if(total_fees_child_tax>0){
                            $('.cal_child_fees_total_price_tax').text(addCommas(number_test(total_fees_child_tax)));
                            $('.if_child_fees_check_tax').addClass('show_child_item_tax_total');
                           }
                           final_total =parseFloat(final_total) +parseFloat(total_fees_child);
                           $('.if_child_fees_check').addClass('show_child_item_total');
                           if(!show_popup && !if_change_parent){
                                $('.if_child_fees_check').show()
                           }
                        }else{
                            $('.if_child_fees_check').removeClass('show_child_item_total');
                            $('.if_child_fees_check_tax').removeClass('show_child_item_tax_total');
                            $('.if_child_fees_check').hide();
                            $('.if_child_fees_check_tax').hide();
                        }

                        if(check_permit_child){
                           $('.cal_child_permit_total_price').text(addCommas(number_test(total_permit_child)));
                           if(total_permit_child_tax>0){
                            $('.cal_child_permit_total_price_tax').text(addCommas(number_test(total_permit_child_tax)));
                            $('.if_child_permit_check_tax').addClass('show_child_item_tax_total');
                           }
                           final_total =parseFloat(final_total) +parseFloat(total_permit_child);
                           $('.if_child_permit_check').addClass('show_child_item_total');
                           if(!show_popup && !if_change_parent){
                                $('.if_child_permit_check').show()
                           }
                        }else{
                            $('.if_child_permit_check').removeClass('show_child_item_total');
                            $('.if_child_permit_check_tax').removeClass('show_child_item_tax_total');
                            $('.if_child_permit_check').hide();
                            $('.if_child_permit_check_tax').hide();
                        }
                        
                        if(is_sealcoat_defualt){
                            if(custom_price_total){
                                $('.cal_child_default_total_price').text(addCommas(number_test(sealcoat_defualt_child_total)));
                            }
                           
                          
                           //final_total =parseFloat(final_total) +parseFloat(sealcoat_defualt_child_total);
                           $('.if_child_default_check').addClass('show_child_item_total');
                           if(!show_popup && !if_change_parent){
                                $('.if_child_default_check').show()
                           }
                        }else{
                            $('.if_child_default_check').removeClass('show_child_item_total');
                            $('.if_child_default_check').hide();
                            
                        }
                        if(check_labor_child || check_trucking_child || check_equipment_child || check_custom_child || check_fees_child || check_permit_child || is_sealcoat_defualt){
                            $('.if_child_parent_total').show();
                            $('.parent_total_percent').show();
                            $('.cal_total_price').css('font-weight','400');
                            $('.if_nochild_items').addClass('show_child_item_total');
                            if(ItemCategoryName){
                                $('.if_child_items_lable_text').text(ItemCategoryName+' Total');
                            }else{
                                $('.if_child_items_lable_text').text('Material Total');
                                
                            }
                            $('.item_total_edit_icon').hide();
                            $('.cal_child_parent_total_price').text(addCommas(number_test(final_total)));
                            
                           
                            
                            if(calculator_form_id=='asphalt_form'){
                               var temp_total_unit = cleanNumber($('#'+calculator_form_id).find('.total_surface').text());  
                               var temp_per_unit =  final_total / temp_total_unit;
                               temp_per_unit = parseFloat(temp_per_unit.toFixed(2));
                               $('#'+calculator_form_id).find('.cost_per_unit').text(addCommas(number_test(temp_per_unit)));
                            }else if(calculator_form_id=='sealcoating_form'){
                                var temp_total_unit = cleanNumber($('#'+calculator_form_id).find('#sealcoatArea').val());
                                var temp_per_unit =  parseFloat(final_total / temp_total_unit);
                                temp_per_unit = parseFloat(temp_per_unit.toFixed(2));
                                var sealcoat_defualt_child_total = cleanNumber($('#'+calculator_form_id).find('.cal_child_default_total_price').text());
                                final_total =parseFloat(final_total) +parseFloat(sealcoat_defualt_child_total);
                                $('.cal_child_parent_total_price').text(addCommas(number_test(final_total)));
                                $('#'+calculator_form_id).find('.cost_per_unit').text(addCommas(number_test(temp_per_unit)));
                            }else if(calculator_form_id=='concrete_form'){
                                var temp_total_unit = cleanNumber($('#'+calculator_form_id).find('#concrete_measurement').val());
                                var temp_per_unit =  parseFloat(final_total / temp_total_unit);
                                temp_per_unit = parseFloat(temp_per_unit.toFixed(2));
                                $('#'+calculator_form_id).find('.cost_per_unit').text(addCommas(number_test(temp_per_unit)));
                            }
                            var temp_final_total =  temp_final_total * 100 / final_total;
                            temp_final_total = parseFloat(temp_final_total.toFixed(1));
                            $('.parent_total_percent').text(temp_final_total+'%');
                            
                            if(total_labor_child>0){
                                var child_labor_total_percent =  total_labor_child * 100 / final_total;
                                child_labor_total_percent = parseFloat(child_labor_total_percent.toFixed(1));
                                $('.child_labor_total_percent').text(child_labor_total_percent+'%');
                            }
                            if(total_trucking_child>0){
                                var child_trucking_total_percent =  total_trucking_child * 100 / final_total;
                                child_trucking_total_percent = parseFloat(child_trucking_total_percent.toFixed(1));
                                $('.child_trucking_total_percent').text(child_trucking_total_percent+'%');
                            }
                            if(total_equipment_child>0){
                                var child_equipment_total_percent =  total_equipment_child * 100 / final_total;
                                child_equipment_total_percent = parseFloat(child_equipment_total_percent.toFixed(1));
                                $('.child_equipment_total_percent').text(child_equipment_total_percent+'%');
                            }
                            if(total_custom_child>0){
                                var child_custom_total_percent =  total_custom_child * 100 / final_total;
                                child_custom_total_percent = parseFloat(child_custom_total_percent.toFixed(1));
                                $('.child_custom_total_percent').text(child_custom_total_percent+'%');
                            }
                            if(total_fees_child>0){
                                var child_fees_total_percent =  total_fees_child * 100 / final_total;
                                child_fees_total_percent = parseFloat(child_fees_total_percent.toFixed(1));
                                $('.child_fees_total_percent').text(child_fees_total_percent+'%');
                            }
                            if(total_permit_child>0){
                                var child_permit_total_percent =  total_permit_child * 100 / final_total;
                                child_permit_total_percent = parseFloat(child_permit_total_percent.toFixed(1));
                                $('.child_permit_total_percent').text(child_permit_total_percent+'%');
                            }
                            if(sealcoat_defualt_child_total>0){
                                var child_defualt_total_percent =  sealcoat_defualt_child_total * 100 / final_total;
                                child_defualt_total_percent = parseFloat(child_defualt_total_percent.toFixed(1));
                                $('.child_default_total_percent').text(child_defualt_total_percent+'%');
                            }
                            

                        }
                        if(show_popup){
                        $("#loading_model").dialog('close');
                        
                        $("#quantity_calculation").dialog('open');
                        //$('.field_input').focus();
                        //$('.field_input').blur();
                        $('.save_estimation').focus();
                        $('.save_estimation').blur();
                        if(!is_sealcoat_defualt){
                            console.log('check4');
                            $('.if_nochild_items').hide();
                        }
                        
                    }else{
                        if(!if_change_parent){
                            console.log('check3');
                            $('.if_nochild_items').show();
                           }
                       
                    }  

                    if($('#'+calculator_form_id+' .show_child_item_total_check').find('i').hasClass('fa-chevron-down')){
                        
                        $('.show_child_item_total_check').closest('tbody').find('.show_child_item_total').hide();
                        
                        //$('.show_child_item_total_check').find('i').addClass('fa-chevron-up').removeClass('fa-chevron-down');
                      
                        $('.if_nochild_items').hide();
                    }else{
                        $('.show_child_item_total_check').closest('tbody').find('.show_child_item_total').show();
                       
                        //$('.show_child_item_total_check').find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
                        
                        $('.if_nochild_items').show();
                    }             
                }else{
                    $('.child_items_list').html('');
                    if(show_popup){
                        $("#loading_model").dialog('close');
                       
                        $("#quantity_calculation").dialog('open');
                        //$('.field_input').focus();
                        //$('.field_input').blur();
                        $('.save_estimation').focus();
                        $('.save_estimation').blur();
                        
                    }
                    //console.log('check5');
                    //if($(".if_fixed_rate_template_calculator_open").is(":visible")){
                        $('.if_nochild_items').show();
                   // }
                    
                    $('.parent_total_percent').hide();
                    $('.if_nochild_items').removeClass('show_child_item_total');
                    $('.if_child_parent_total').hide();
                    $('.cal_total_price').css('font-weight','bold');
                    // if(custom_price_total){

                    //    console.log('check_3301')
                    //     $('.if_child_items_lable_text').text('Total Price*');

                    // }else{
                    //     $('.if_child_items_lable_text').text('Total Price');
                    // }
                    
                           
                }
                
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }

        })

       
            
           
        
    }


    $(document).on("click",".delete_child_item",function(e) {        
            var lineItemId  = $(this).attr('data-child-line-id');
            var perent_lineItemId  = $(this).attr('data-perent-line-id');
            
            $this =$(this);
           
            swal({
                title: "Are you sure?",
                text: "Item will be permanently deleted",
                showCancelButton: true,
                confirmButtonText: 'Delete Item',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
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
                    var est_items = [];
                    est_items.push(lineItemId)
                    $.ajax({
                        url: '/ajax/deleteEstimateLineItems',
                        type: "POST",
                        data: {
                            "lineItemIds": est_items,
                            "proposalServiceId": proposal_service_id,
                            'phase_id':phase_id,
                        },

                        success: function( data){
                            try{
                                data = JSON.parse(data);
                            } catch (e) {
                                swal("Error", "An error occurred Please try again");
                                return false;
                            }
                            get_child_items_list(perent_lineItemId,false)
                            swal(
                                'Item Deleted',
                                ''
                            );

                           
                            $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                            $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                            $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                            $('#estimateLineItemTable').DataTable().ajax.reload();
                            get_service_item_list_by_phase_id();
                            get_proposal_breakdown();
                            //update_proposal_overhead_profit();

                            if(parseInt(data.breakdown.overheadPrice)<0){
                                $('.proposal_service_overhead_price').css('color','red');
                            }else{
                                $('.proposal_service_overhead_price').css('color','#444444');
                            }

                            if(parseInt(data.breakdown.profitPrice)<0){
                                $('.proposal_service_profit_price').css('color','red');
                            }else{
                                $('.proposal_service_profit_price').css('color','#444444');
                            }
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            swal("Error", "An error occurred Please try again");
                            console.log( errorThrown );
                        }
                    })

                   

                } else {
                    swal("Cancelled", "Your Estimation is safe :)", "error");
                }
            });
        
    });
    $(document).on("change",".dumpSelect",function(e) {   
        var selected = $(':selected', this);
    if(selected.closest('optgroup').attr('label')=='Dumps'){
        $('.dump_rate').val($(this).find(":selected").data('price-rate'));
        
    }else{
        $('.dump_rate').val(0);
    }
    //if_dump_type
    });


    $(document).on("click",".open_trucking_calculator",function(e) {  
        has_custom_trucking_total_price_update = false;
        var categoryName = $('#'+item_line_id).find('.open_calculator').data('category-name');
        var typeName = $('#'+item_line_id).find('.open_calculator').data('type-name');
        var itemName = $('#'+item_line_id).find('.open_calculator').attr('data-item-name');
        $('.if_error_show_msg,.save_estimation,.if_child_use_minimum_hours,.show_marker_map,edit_child_round_time,.cancle_edit_child_round_time,.cancle_edit_child_round_time').hide();
        $('.trucking_form_right_box,.round_time,.edit_child_round_time').show();
        $('.parant_item_name').find('.calculatorHeadingCategory').text(categoryName);
        $('.parant_item_name').find('.calculatorHeadingType').text(typeName);
        $('.parant_item_name').find('.calculatorHeadingItem').text(itemName);

        $('.cal_trucking_total_price_lable').text('Total Price');
        $('#temp_trucking_form').find('.trucking_cal_overhead_price').closest('tr').css('color','#444444');
        $('#temp_trucking_form').find('.trucking_cal_overhead').css('color','#44444');
        $('#temp_trucking_form').find('.trucking_cal_profit_price').closest('tr').css('color','#444444');
        $('#temp_trucking_form').find('.trucking_cal_profit').css('color','#444444');


        $("#map_model").dialog('open');
        $("#equipement_type").select2();
        $("#equipement_item").select2();
        $('.error').removeClass('error');
        $('.select_box_error').removeClass('select_box_error');
        $('.select2_box_error').removeClass('select2_box_error');
        $('.dump_fee_apply').attr('checked',false);
         
         child_lineItemId  = $(this).attr('data-child-line-id');
         calculation_id = $(this).attr('data-calculation-id');
$.ajax({
                url: '/ajax/loadItemCalculatorValues2/'+child_lineItemId,
                type: 'get',

                success: function( data){
                    data = JSON.parse(data);
                    if(data.values){
                        var is_custom_time =false;
                        var is_custom_round_time =false;
                        var array = JSON.parse(data.values);

                        var $form = $("#temp_trucking_form");
                        for($i=0;$i<array.length;$i++){
                            var $field = $form.find('[name=' + array[$i].name + ']');
                            $field.val(array[$i].value);
                            if($field.attr('type')=='checkbox'){
                                $field.prop("checked",true);
                            }
                            if(array[$i].name=='child_custom_total_time' && array[$i].value >0){
                                is_custom_time =true;
                            }
                            if(array[$i].name=='child_custom_round_time' && array[$i].value >0){

                                is_custom_round_time =true;
                               // $('#child_custom_round_time').val(array[$i].value);
                            }

                        }

                        $('.dump_fee_apply').trigger('change');
                        if(head_type_id == excavation_type_id || head_type_id == milling_type_id){
                            $('.if_excavation').show();
                            $('.if_not_excavation').hide();
                            $('.plant_time_label').text('Dump Time');
                            //$('.if_dump_type').show();
                           
                             
                        }else{
                            $('.if_excavation').hide();
                            $('.if_not_excavation').show();
                            $('.plant_time_label').text('Plant Time');
                        }
                        if ($(".dumpSelect").val()=='custom') {
                            $('.if_excavation_custom').show();
                        }else{
                            $('.if_excavation_custom').hide();
                        }
                        
                        //$('.trucking_cal_overhead').val(data.itemDetails.overhead_rate);
                        //$('.trucking_cal_profit').val(data.itemDetails.profit_rate);
                        if(data.itemDetails.is_custom_price==1){
                            if(parseFloat(data.itemDetails.overhead_price)<0){
                                    var temp_overheadPrice = '-$'+addCommas(number_test(Math.abs(data.itemDetails.overhead_price)));
                                    $('#temp_trucking_form').find('.trucking_cal_overhead_price').closest('tr').css('color','red');
                                    $('#temp_trucking_form').find('.trucking_cal_overhead').css('color','red');
                                }else{
                                    var temp_overheadPrice = '$'+addCommas(number_test(data.itemDetails.overhead_price));
                                    $('#temp_trucking_form').find('.trucking_cal_overhead_price').closest('tr').css('color','#444444');
                                    $('#temp_trucking_form').find('.trucking_cal_overhead').css('color','#44444');
                                }

                                if(parseFloat(data.itemDetails.profit_price)<0){
                                    var temp_profitPrice = '-$'+addCommas(number_test(Math.abs(data.itemDetails.profit_price)));
                                    $('#temp_trucking_form').find('.trucking_cal_profit_price').closest('tr').css('color','red');
                                    $('#temp_trucking_form').find('.trucking_cal_profit').css('color','red');
                                }else{
                                    var temp_profitPrice = '$'+addCommas(number_test(data.itemDetails.profit_price));
                                    $('#temp_trucking_form').find('.trucking_cal_profit_price').closest('tr').css('color','#444444');
                                    $('#temp_trucking_form').find('.trucking_cal_profit').css('color','#444444');
                                }
                                
                            $('#temp_trucking_form').find('.cal_trucking_total_price').text(addCommas(number_test(data.itemDetails.total_price)));    
                           // $('#temp_trucking_form').find('.equipement_cal_tax_amount').text('$'+addCommas(number_test(data.itemDetails.tax_price)));
                            $('#temp_trucking_form').find('.trucking_cal_overhead_price').text(temp_overheadPrice);
                            $('#temp_trucking_form').find('.trucking_cal_profit_price').text(temp_profitPrice);
                            $('.cal_trucking_total_price_lable').text('Total Price*'); 
                            calculate_trucking_type2(calculator_form_id,false,false,true,true,is_custom_time,is_custom_round_time)

                        }else{
                            calculate_trucking_type2(calculator_form_id,false,false,true,false,is_custom_time,is_custom_round_time)
                        }
                        

                        setDropdowns();
                        //$.uniform.update();
                    }
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
        });
    });

    $(document).on("click",".open_labor_calculator",function(e) {  
        has_custom_labor_total_price_update =false;
        $("#labor_model").dialog('open');
        $('.if_error_show_msg').hide();
        $('.save_estimation').hide();
        $('.if_not_edit_labor_item_total_price,.save_labor_estimation').show();
        $('.custom_labor_total_price_input,.if_edit_labor_item_total_price,.item_labor_total_edit_icon').hide();
        $('.labor_cal_total_price_label').text('Total Price'); 
        $('#time_type_form2').find('.labor_cal_profit_price').closest('tr').css('color','#444444');
        $('#time_type_form2').find('.labor_cal_profit').css('color','#444444');
        $('#time_type_form2').find('.labor_cal_overhead_price').closest('tr').css('color','#444444');
        $('#time_type_form2').find('.labor_cal_overhead').css('color','#44444');
        $('.error').removeClass('error');
        $('.select_box_error').removeClass('select_box_error');
        $('.select2_box_error').removeClass('select2_box_error');
        child_lineItemId  = $(this).attr('data-child-line-id');
        calculation_id = $(this).attr('data-calculation-id');
        var categoryName = $('#'+item_line_id).find('.open_calculator').data('category-name');
        var typeName = $('#'+item_line_id).find('.open_calculator').data('type-name');
        var itemName = $('#'+item_line_id).find('.open_calculator').attr('data-item-name');
        
        $('.parant_item_name').find('.calculatorHeadingCategory').text(categoryName);
        $('.parant_item_name').find('.calculatorHeadingType').text(typeName);
        $('.parant_item_name').find('.calculatorHeadingItem').text(itemName);

$.ajax({
                url: '/ajax/loadItemCalculatorValues2/'+child_lineItemId,
                type: 'get',

                success: function( data){
                    data = JSON.parse(data);
                    if(data.values){
                        var array = JSON.parse(data.values);

                        var $form = $("#time_type_form2");
                        for($i=0;$i<array.length;$i++){

                            if(array[$i].name=='labor_type'){
                               var temp_type_name = array[$i].value;
                                if(temp_type_name){
                                    var new_data = laborGroupItems.filter(x => x.name == temp_type_name);
                                    var select_options = '<option value="">Select Item</option>';
                                    
                                        $.each(new_data[0].items, function(index,jsonObject){
                                        
                                            select_options +='<option data-unit-single-name="'+jsonObject.unit_single_name+'" data-base-unit-price="'+jsonObject.base_price+'" data-profit-rate="'+jsonObject.profit_rate+'" data-overhead-rate="'+jsonObject.overhead_rate+'" value="'+jsonObject.id+'">'+jsonObject.name+'</option>';
                                        });
                                    
                                        $('.labor_item').html(select_options);
                                        
                                        
                                }
                            }

                            var $field = $form.find('[name=' + array[$i].name + ']');
                            $field.val(array[$i].value);
                            if($field.attr('type')=='checkbox'){
                                $field.prop("checked",true);
                            }
                        }
                        if($('.labor_cal_tax_checkbox').is(':checked')){
                            $('.labor_cal_tax').show();
                        }else{
                            $('.labor_cal_tax').hide();
                        }
                        if(data.itemDetails.is_custom_price==1){
                            if(parseFloat(data.itemDetails.overhead_price)<0){
                                    var temp_overheadPrice = '-$'+addCommas(number_test(Math.abs(data.itemDetails.overhead_price)));
                                    $('#time_type_form2').find('.labor_cal_overhead_price').closest('tr').css('color','red');
                                    $('#time_type_form2').find('.labor_cal_overhead').css('color','red');
                                }else{
                                    var temp_overheadPrice = '$'+addCommas(number_test(data.itemDetails.overhead_price));
                                    $('#time_type_form2').find('.labor_cal_overhead_price').closest('tr').css('color','#444444');
                                    $('#time_type_form2').find('.labor_cal_overhead').css('color','#44444');
                                }

                                if(parseFloat(data.itemDetails.profit_price)<0){
                                    var temp_profitPrice = '-$'+addCommas(number_test(Math.abs(data.itemDetails.profit_price)));
                                    $('#time_type_form2').find('.labor_cal_profit_price').closest('tr').css('color','red');
                                    $('#time_type_form2').find('.labor_cal_profit').css('color','red');
                                }else{
                                    var temp_profitPrice = '$'+addCommas(number_test(data.itemDetails.profit_price));
                                    $('#time_type_form2').find('.labor_cal_profit_price').closest('tr').css('color','#444444');
                                    $('#time_type_form2').find('.labor_cal_profit').css('color','#444444');
                                }
                                
                            $('#time_type_form2').find('.labor_cal_total_price').text(addCommas(number_test(data.itemDetails.total_price)));    
                            $('#time_type_form2').find('.labor_cal_tax_amount').text('$'+addCommas(number_test(data.itemDetails.tax_price)));
                            $('#time_type_form2').find('.labor_cal_overhead_price').text(temp_overheadPrice);
                            $('#time_type_form2').find('.labor_cal_profit_price').text(temp_profitPrice);
                            $('.labor_cal_total_price_label').text('Total Price*'); 
                            calculate_labor_time_type(true);

                        }else{
                            calculate_labor_time_type();
                        }
                        //$('.labor_cal_overhead').val(data.itemDetails.overhead_rate);
                        //$('.labor_cal_profit').val(data.itemDetails.profit_rate);
                        
                        $(".labor_item").select2();
                        $(".labor_type").select2();
                        setDropdowns();
            $.uniform.update();
                    }
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
        });
    });

    $(document).on("click",".open_equipement_calculator",function(e) {
        has_custom_equipement_total_price_update =false;
        $("#equipement_model").dialog('open');
        $("#equipement_type").select2();
        $("#equipement_item").select2();
        $('.if_error_show_msg').hide();
        $('.save_estimation').hide();
        $('.if_not_edit_equipement_item_total_price,.save_equipement_estimation').show();
        $('.custom_equipement_total_price_input,.if_edit_equipement_item_total_price,.equipement_total_edit_icon').hide();
        $('.equipement_cal_total_price_label').text('Total Price');
        $('#equipement_time_type_form').find('.equipement_cal_overhead_price').closest('tr').css('color','#444444');
        $('#equipement_time_type_form').find('.equipement_cal_overhead').css('color','#44444');
        $('#equipement_time_type_form').find('.equipement_cal_profit_price').closest('tr').css('color','#444444');
        $('#equipement_time_type_form').find('.equipement_cal_profit').css('color','#444444');
        $('.select2_box_error').removeClass('select2_box_error');
            $('.error').removeClass('error');
            $('.select_box_error').removeClass('select_box_error');
         child_lineItemId  = $(this).attr('data-child-line-id');
         calculation_id = $(this).attr('data-calculation-id');
        var categoryName = $('#'+item_line_id).find('.open_calculator').data('category-name');
        var typeName = $('#'+item_line_id).find('.open_calculator').data('type-name');
        var itemName = $('#'+item_line_id).find('.open_calculator').attr('data-item-name');
        
        $('.parant_item_name').find('.calculatorHeadingCategory').text(categoryName);
        $('.parant_item_name').find('.calculatorHeadingType').text(typeName);
        $('.parant_item_name').find('.calculatorHeadingItem').text(itemName);

$.ajax({
                url: '/ajax/loadItemCalculatorValues2/'+child_lineItemId,
                type: 'get',

                success: function( data){
                    data = JSON.parse(data);
                    if(data.values){
                        var array = JSON.parse(data.values);

                        var $form = $("#equipement_time_type_form");
                        for($i=0;$i<array.length;$i++){
                            if(array[$i].name=='equipement_type'){
                               var temp_type_id =  array[$i].value;
                               if(temp_type_id){
                                var new_data = equipments.filter(x => x.type_id == temp_type_id);
                                var select_options = '<option value="">Select</option>';
                                
                                    $.each(new_data[0].items, function(index,jsonObject){
                                    
                                        select_options +='<option data-unit-single-name="'+jsonObject.unit_single_name+'" data-base-unit-price="'+jsonObject.base_price+'" data-profit-rate="'+jsonObject.profit_rate+'" data-overhead-rate="'+jsonObject.overhead_rate+'" value="'+jsonObject.id+'">'+jsonObject.name+'</option>';
                                    });
                                
                                    $('.equipement_item').html(select_options);
                                    
                                }
                            }
                            
                            var $field = $form.find('[name=' + array[$i].name + ']');
                            $field.val(array[$i].value);
                            if($field.attr('type')=='checkbox'){
                                $field.prop("checked",true);
                            }
                        }
                        
                        if($('.equipement_cal_tax_checkbox').is(':checked')){
                            $('.equipement_cal_tax').show();
                        }else{
                            $('.equipement_cal_tax').hide();
                        }
                        $("#equipement_type").select2();
                        $("#equipement_item").select2();
                        //$('.equipement_cal_overhead').val(data.itemDetails.overhead_rate);
                       // $('.equipement_cal_profit').val(data.itemDetails.profit_rate);


                       if(data.itemDetails.is_custom_price==1){
                            if(parseFloat(data.itemDetails.overhead_price)<0){
                                    var temp_overheadPrice = '-$'+addCommas(number_test(Math.abs(data.itemDetails.overhead_price)));
                                    $('#equipement_time_type_form').find('.equipement_cal_overhead_price').closest('tr').css('color','red');
                                    $('#equipement_time_type_form').find('.equipement_cal_overhead').css('color','red');
                                }else{
                                    var temp_overheadPrice = '$'+addCommas(number_test(data.itemDetails.overhead_price));
                                    $('#equipement_time_type_form').find('.equipement_cal_overhead_price').closest('tr').css('color','#444444');
                                    $('#equipement_time_type_form').find('.equipement_cal_overhead').css('color','#44444');
                                }

                                if(parseFloat(data.itemDetails.profit_price)<0){
                                    var temp_profitPrice = '-$'+addCommas(number_test(Math.abs(data.itemDetails.profit_price)));
                                    $('#equipement_time_type_form').find('.equipement_cal_profit_price').closest('tr').css('color','red');
                                    $('#equipement_time_type_form').find('.equipement_cal_profit').css('color','red');
                                }else{
                                    var temp_profitPrice = '$'+addCommas(number_test(data.itemDetails.profit_price));
                                    $('#equipement_time_type_form').find('.equipement_cal_profit_price').closest('tr').css('color','#444444');
                                    $('#equipement_time_type_form').find('.equipement_cal_profit').css('color','#444444');
                                }
                                
                            $('#equipement_time_type_form').find('.equipement_cal_total_price').text(addCommas(number_test(data.itemDetails.total_price)));    
                            $('#equipement_time_type_form').find('.equipement_cal_tax_amount').text('$'+addCommas(number_test(data.itemDetails.tax_price)));
                            $('#equipement_time_type_form').find('.equipement_cal_overhead_price').text(temp_overheadPrice);
                            $('#equipement_time_type_form').find('.equipement_cal_profit_price').text(temp_profitPrice);
                            $('.equipement_cal_total_price_label').text('Total Price*'); 
                            calculate_equipement_time_type(true);

                        }else{
                            calculate_equipement_time_type();
                        }
                        
                        setDropdowns();
                        $.uniform.update();
                    }
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
        });
    });
    
    $(document).on("change",".labor_item,.labor_type",function(e) {   
        unsave_cal=true;
        if(oh_pm_type==2){
        var temp_item_overhead_rate = $('.labor_item').find(':selected').data('overhead-rate');
        var temp_item_profit_rate = $('.labor_item').find(':selected').data('profit-rate');
            $(".labor_cal_overhead").val(temp_item_overhead_rate);
            $(".labor_cal_profit").val(temp_item_profit_rate);
        }else{
            $(".labor_cal_overhead").val(service_overhead_rate);
            $(".labor_cal_profit").val(service_profit_rate);
            
        }
        calculate_labor_time_type();
    });
    $(document).on("keyup",".labor_number_of_person,.labor_hour_per_day,.labor_time_type_input,.labor_cal_tax,.labor_cal_overhead,.labor_cal_profit",function(e) {   
        unsave_cal=true;  
       calculate_labor_time_type();
       
   });

    function calculate_labor_time_type(is_custom_price =false){
        var time_type_input = $(".labor_time_type_input").val();
        var number_of_person = $(".labor_number_of_person").val();
        var hour_per_day = $(".labor_hour_per_day").val();
        time_type_input = time_type_input.replace(/,/g, '');
        number_of_person = number_of_person.replace(/,/g, '');
        hour_per_day = hour_per_day.replace(/,/g, '');
        
        var temp_item_base_price = $('.labor_item').find(':selected').data('base-unit-price');
        var unit_single_name = $('.labor_item').find(':selected').data('unit-single-name');
        if(unit_single_name){
            $('.labor_cal_unit_single_name').text('/ '+unit_single_name);
        }else{
            $('.labor_cal_unit_single_name').text('');
        }
        
        console.log('check112')
        if(temp_item_base_price){
            $('.labor_cal_unit_price').text('$'+addCommas(number_test(temp_item_base_price)));
        }
        
        var total_time = time_type_input*number_of_person;
        //if(unit_name=='Hours'){
            total_time =  total_time * hour_per_day;
        //}
        $(".labor_total_time_value").text(addCommas(total_time));
        var temp_item_quantity =total_time;
        
            var temp_overheadRate = cleanNumber($("#time_type_form2").closest('form').find('.labor_cal_overhead').val());
            var temp_profitRate = cleanNumber($("#time_type_form2").closest('form').find('.labor_cal_profit').val());
        
        
        if(temp_item_base_price && temp_item_base_price>0 && time_type_input && time_type_input>0 && number_of_person && number_of_person >0 && hour_per_day && hour_per_day>0)
        {
        var tempoverheadPrice = ((temp_item_base_price * temp_overheadRate) / 100);
        var tempprofitPrice = ((temp_item_base_price * temp_profitRate) / 100);
       
        var totalPrice = parseFloat(temp_item_base_price) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);
        //item_price = totalPrice;
        tempoverheadPrice = tempoverheadPrice * temp_item_quantity;
        tempprofitPrice = tempprofitPrice * temp_item_quantity;
        $('.labor_cal_unit_price').text('$'+addCommas(number_test(totalPrice)));
        
        
        temp_total = temp_item_quantity * totalPrice;

        var temp_taxRate = $('#time_type_form2').find('.labor_cal_tax').val();
        temp_taxRate = temp_taxRate.replace('%', '');
        var temptaxPrice = ((temp_total * temp_taxRate) / 100);
        
        var temp_total = parseFloat(temp_total) + parseFloat(temptaxPrice);
        if(!is_custom_price){
            $(".labor_cal_overhead_price").text('$'+addCommas(number_test(tempoverheadPrice)));
            $(".labor_cal_profit_price").text('$'+addCommas(number_test(tempprofitPrice)));
            $('#time_type_form2').find('.labor_cal_tax_amount').text('$'+addCommas(number_test(temptaxPrice)));
            $('.labor_cal_total_price').text(addCommas(number_test(temp_total)));
        }
        //calTotalPrice = temp_total;
        

        }
        var temp_labor_item = $('.labor_item').val();
        var temp_labor_type = $('.labor_type').val();
        
        //$(".labor_cal_unit_price").text(addCommas(number_test(totalPrice)));
        if(temp_labor_type && temp_labor_item && temp_item_base_price && temp_item_base_price>0 && time_type_input && time_type_input>0 && number_of_person && number_of_person >0 && hour_per_day && hour_per_day>0){
            $("#labor_submit").removeClass('ui-state-disabled');
            $("#labor_submit").attr('disabled',false);
            $('.item_labor_total_edit_icon').show();
        }else{
            $("#labor_submit").addClass('ui-state-disabled');
            $("#labor_submit").attr('disabled',true);
            $('.item_labor_total_edit_icon').hide();
        }
    }

    $(document).on('click',".labor_cal_tax_checkbox",function() {
        if($(this).prop("checked")){
            $('.labor_cal_tax').show();
            $('.labor_cal_tax_amount_row').show();
        }else{
            $('.labor_cal_tax').val(0);
            $('.labor_cal_tax_amount').text(0);
            $('.labor_cal_tax').hide();
            $('.labor_cal_tax_amount_row').hide();
            calculate_labor_time_type();
        }
    })


    function save_labor_estimation(perent_item_id,calId){
        var lineItems =[];
        
        var form_data = $("#time_type_form2").serializeArray();
        //var unit_price = $('#'+item_line_id).find('.unit-price').val();
        
        var temp_base_unit_price = cleanNumber($('#labor_model').find('.labor_item').find(':selected').attr('data-base-unit-price'));
        var temp_unit_price = cleanNumber($('#labor_model').find('.labor_cal_unit_price').text());
        var temp_item_id = $('#labor_model').find('.labor_item').val();
        //var original_unit_price = $('#'+item_line_id).find('.open_calculator').data('item-unit-price');
        //var perent_item_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
        var total_time_hours = cleanNumber($('#labor_model').find('.labor_total_time_value').text());
        var temp_cal_labor_total_Price = cleanNumber($('#labor_model').find('.labor_cal_total_price').text());
        
        var temp_overheadRate = cleanNumber($("#time_type_form2").closest('form').find('.labor_cal_overhead').val());
        var temp_profitRate = cleanNumber($("#time_type_form2").closest('form').find('.labor_cal_profit').val());
 
        var temp_overheadPrice =cleanNumber($(".labor_cal_overhead_price").text());
        var temp_profitPrice =cleanNumber($(".labor_cal_profit_price").text());

        var temp_taxRate = cleanNumber($('#time_type_form2').find('.labor_cal_tax').val());
        var temp_taxPrice = cleanNumber($('#time_type_form2').find('.labor_cal_tax_amount').text());

            lineItems.push({
                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                'customUnitPrice':0,
                'proposalServiceId':proposal_service_id,
                'parentId':perent_item_id,
                'id':child_lineItemId,
                'itemId':temp_item_id,
                'PhaseId':phase_id,
                'quantity':total_time_hours,
                'unitPrice':temp_unit_price,
                'totalPrice':temp_cal_labor_total_Price,
                'overHeadRate':temp_overheadRate,
                'profitRate':temp_profitRate,
                'overHeadPrice':temp_overheadPrice,
                'profitPrice':temp_profitPrice,
                'basePrice':temp_base_unit_price,
                'taxRate':temp_taxRate,
                'taxPrice':temp_taxPrice,
                'truckingOverHeadRate': 0,
                'truckingProfitRate': 0,
                'truckingOverHeadPrice': 0,
                'truckingProfitPrice': 0,
                'truckingTotalPrice': 0,
                'sub_id':'0', 
                'edited_unit_price':edited_unit_price,
                'edited_base_price':edited_base_price,
                'edited_total_price':edited_total_price,
            });



            $.ajax({
            url: '/ajax/saveEstimatorValues2/',
            type: 'post',
            data: {
                'lineItems':lineItems,
                'proposalServiceId':proposal_service_id,
                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                'itemId':temp_item_id,
                'values':form_data,
                'PhaseId':phase_id,
                'calculation_id':calculation_id,
                'apply':0,
            },
            success: function(data){
                try{
                    data = JSON.parse(data);
                } catch (e) {
                    swal("Error", "An error occurred Please try again");
                    return false;
                }
                unsave_cal=false;  
                
                
                estimate_calculator_id =calId;
               
                revert_adjust_price1();
                
                //get_service_item_list();
                
                //update_proposal_overhead_profit();
                $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                
                //get_all_line_item_data();
                //save_service_estimate_total_price(data.total_price);
                var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
                unsaved = false;
                unsaved_row = false;
                if(data.estimate.completed==0){
                    $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                }else{
                    $('#service_'+proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                    if(check_est_completed){
                        $('.item_summary_btn').show();
                        temp_count = temp_count-1;
                        if(temp_count==0){
                            $('.show_pending_est_msg').hide();
                            $('.welcome_msg').hide();
                            $('.show_complete_est_msg').show();
                        }else{

                            $('.show_pending_est_msg').text('You have '+temp_count+' additional services that you need to Estimate');
                            $('.show_pending_est_msg').show();
                            $('.welcome_msg').hide();
                            $('.show_complete_est_msg').hide();
                        }
                    }
                }
                if(data.estimate.child_has_updated_flag==0 ){
                    $('.service_child_has_updated_flag_'+proposal_service_id).hide();
                    $('#service_'+proposal_service_id+' .toggle').addClass('text-active-color').removeClass('text-active-color2');
                    $('#service_'+proposal_service_id+' .toggle').css('background-color','#aeaeae');
                }

                $('.service_total_'+proposal_service_id).val(data.estimate.service_price);


                
              
                if(has_custom_labor_total_price_update){
                    update_custom_labor_itam_total(data.lineItemId);

                }else{
                    get_service_item_list_by_phase_id();
                    get_proposal_breakdown();
                    swal('Estimate Saved','');
                }
                get_child_items_list(perent_item_id,false,true);

                $('.if_item_saved').show();
                child_save_done =true;
                $("#labor_model").dialog('close');
                $('#estimateLineItemTable').DataTable().ajax.reload();
                
            },
            error: function( jqXhr, textStatus, errorThrown ){
                swal("Error", "An error occurred Please try again");
                console.log( errorThrown );
            }
        })
}

$(document).on("click",".save_labor_estimation",async function(e) {  
    $(".save_labor_estimation").addClass('ui-state-disabled');
    $(".save_labor_estimation").attr('disabled',true);

    var estimate_line_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
    var days =  $('.labor_time_type_input').val();
    var unit_type_id = $('#'+item_line_id).find('.open_calculator').attr('data-unit-type-id');
    if(!estimate_line_id){
        if(unit_type_id==time_type_id){
        var parent_days =  $('#time_type_input').val();
        if(days != parent_days){

            swal({
                    title: "Warning",
                    text: "The <strong>Days</strong> value you entered does not match the days value of related items. <br /><br />Continue?",
                    showCancelButton: true,
                    confirmButtonText: 'Save Item',
                    cancelButtonText: "Cancel",
                    dangerMode: false,
                }).then(function(isConfirm) {
                    if (isConfirm) {
                        after_days_check_save_labor_estimation();
                    } else {
                        return false;
                    }
                });
            }else{
                after_days_check_save_labor_estimation();
            }
        }else{
                after_days_check_save_labor_estimation();
            }
    }else{

                $.ajax({
                            url: '/ajax/check_child_parent_days_quantity/',
                            type: 'post',
                            data: {
                                'child_line_id':child_lineItemId,
                                'estimate_line_id':estimate_line_id,
                                'days':days,
                                
                            },
                            success: function(data){
                                data = JSON.parse(data);
                                if(data.success==0){
                                    swal({
                                        title: "Warning",
                                        text: "The <strong>Days</strong> value you entered does not match the days value of related items. <br /><br />Continue?",
                                        showCancelButton: true,
                                        confirmButtonText: 'Save Item',
                                        cancelButtonText: "Cancel",
                                        dangerMode: false,
                                    }).then(function(isConfirm) {
                                        if (isConfirm) {
                                            after_days_check_save_labor_estimation();
                                        } else {
                                            return false;
                                        }
                                    });
                                }else{
                                    after_days_check_save_labor_estimation();
                                }
                            },
                            error: function( jqXhr, textStatus, errorThrown ){
                                swal("Error", "An error occurred Please try again");
                                console.log( errorThrown );
                                
                            }
                        })
                    
    }
        
    
   });

function after_days_check_save_labor_estimation(){

    swal({
        title: 'Saving..',
        allowEscapeKey: false,
        allowOutsideClick: false,
        timer: 2000,
        onOpen: () => {
        swal.showLoading();
        }
    });
       var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
       var fields = [];
       
    //$('.save_estimation').show();    
    if(calculator_form_id=='asphalt_form'){
        var service_box_id = '#service_html_box3';
    }else if(calculator_form_id=='concrete_form'){
        var service_box_id = '#service_html_box4';
    } else if(calculator_form_id=='sealcoating_form'){
        var service_box_id = '#service_html_box5';
    }else if(calculator_form_id=='striping_form'){
        var service_box_id = '#service_html_box6';
    }else if(calculator_form_id=='crack_sealer_form'){
        var service_box_id = '#service_html_box7';
    }
       

       $(service_box_id).find('li').each(function(i,li){
                            $(li).find('.field_input').val();
                            var li_id = $(li).find('.field_input').attr('id');
                            if(li_id){
                                var li_id = li_id.replace(new RegExp("^" + 'input_'), '');
                                var field_new_value = $(li).find('.field_input').val()
                                fields.push({
                                    'fieldId':li_id,
                                    'fieldValue':field_new_value,
                                    
                                });
                            }
                            var field_id =$(li).data('field-id');
                if($("li[data-field-id='"+field_id+"']" ).find('.field_input').prop('type') == 'text' ) 
                {
                    $("li[data-field-id='"+field_id+"']" ).find('.field_input').attr('value',field_new_value);
                }else{
                    $("li[data-field-id='"+field_id+"']" ).find('.field_input option').removeAttr('selected').filter('[value="'+field_new_value+'"]').attr('selected', true)
                }          
                
                
                $("li[data-field-id='"+field_id+"']" ).find('.show_input_span').text(field_new_value);
                           
        });
      total_price = cleanNumber($('#'+calculator_form_id).find('.cal_total_price').text());
        //total_price = calTotalPrice;
        var form_data = $("#"+calculator_form_id).serializeArray();
        for($i=0;$i<form_data.length;$i++){
       
            var $form = $("#"+calculator_form_id);
                                
            var $field = $form.find('[name=' + form_data[$i].name + ']');
            if($field.attr('data-field-code')){
            form_data[$i].field_code = $field.attr('data-field-code');
            }
        
        }
        var lineItems =[];

       item_id = $('#'+item_line_id).find('.open_calculator').data('item-id');
    
       var template = $('#'+item_line_id).find('.open_calculator').data('templates');
        if(template){
            var template_type_id = $('.select_template_option').val();
        
        }else{
            var template_type_id = $('#'+item_line_id).find('.open_calculator').data('template-type-id');
        }
        if(!template_type_id){
            template_type_id = '0';
        }
       var original_unit_price = $('#'+item_line_id).find('.open_calculator').data('item-unit-price');
       var estimate_line_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
 
       if(parseFloat(item_price) == parseFloat(original_unit_price) ){
           var customUnitPrice =0;
       }else{
           var customUnitPrice =1;
       }
       //if(item_quantity>0 && total_price>0){


           lineItems.push({
               'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
               'customUnitPrice':customUnitPrice,
               'proposalServiceId':proposal_service_id,
               'id':estimate_line_id,
               'itemId':item_id,
               'PhaseId':phase_id,
               'quantity':item_quantity,
               'unitPrice':item_price,
               'totalPrice':total_price,
               'overHeadRate':overheadRate,
               'profitRate':profitRate,
               'overHeadPrice':overheadPrice,
               'profitPrice':profitPrice,
               'basePrice':item_base_price,
               'taxRate':taxRate,
               'taxPrice':taxPrice,
               'truckingOverHeadRate': cal_trucking_oh,
               'truckingProfitRate': cal_trucking_pm,
               'truckingOverHeadPrice': cal_trucking_oh_Price,
               'truckingProfitPrice': cal_trucking_pm_Price,
               'truckingTotalPrice': cal_trucking_total_Price,
               'sub_id':'0', 
               'template_type_id':template_type_id,
               'edited_unit_price':edited_unit_price,
                'edited_base_price':edited_base_price,
                'edited_total_price':edited_total_price,
           });

       //}
       // }

//})
//})

       $.ajax({
           url: '/ajax/saveEstimatorValues/',
           type: 'post',
           data: {
               'lineItems':lineItems,
               'proposalServiceId':proposal_service_id,
               'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
               'apply':0,
               'values':form_data,
               'itemId':item_id,
               'PhaseId':phase_id,
               'calculator_name':calculator_form_id,
               'calculation_id':estimate_calculator_id,
               'fields':fields
           },
           success: function(data){
                try{
                    data = JSON.parse(data);
                } catch (e) {
                    swal("Error", "An error occurred Please try again");
                    return false;
                }
               if(calculator_form_id=='sealcoating_form'){
                    if(estimate_line_id){
                        deleteOldSealcoatChildItem(data.lineItemId);
                        //sealcoatchilditemadd(data.lineItemId);
                    }else{
                        sealcoatchilditemadd(data.lineItemId);
                    }
                    
                }
               save_labor_estimation(data.lineItemId,data.calId)
           },
           error: function( jqXhr, textStatus, errorThrown ){
                swal("Error", "An error occurred Please try again");
                console.log( errorThrown );
            }
       })

}

   $(document).on("click",".save_custom_child_estimation",async function(e) {    

    $(".save_custom_child_estimation").addClass('ui-state-disabled');
    $(".save_custom_child_estimation").attr('disabled',true);
    swal({
        title: 'Saving..',
        allowEscapeKey: false,
        allowOutsideClick: false,
        timer: 2000,
        onOpen: () => {
        swal.showLoading();
        }
    });
       var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
       var fields = [];
       
    //$('.save_estimation').show();    
    if(calculator_form_id=='asphalt_form'){
        var service_box_id = '#service_html_box3';
    }else if(calculator_form_id=='concrete_form'){
        var service_box_id = '#service_html_box4';
    } else if(calculator_form_id=='sealcoating_form'){
        var service_box_id = '#service_html_box5';
    }else if(calculator_form_id=='striping_form'){
        var service_box_id = '#service_html_box6';
    }else if(calculator_form_id=='crack_sealer_form'){
        var service_box_id = '#service_html_box7';
    }
       

       $(service_box_id).find('li').each(function(i,li){
                            $(li).find('.field_input').val();
                            var li_id = $(li).find('.field_input').attr('id');
                            if(li_id){
                                var li_id = li_id.replace(new RegExp("^" + 'input_'), '');
                                var field_new_value = $(li).find('.field_input').val()
                                fields.push({
                                    'fieldId':li_id,
                                    'fieldValue':field_new_value,
                                    
                                });
                            }
                            var field_id =$(li).data('field-id');
                if($("li[data-field-id='"+field_id+"']" ).find('.field_input').prop('type') == 'text' ) 
                {
                    $("li[data-field-id='"+field_id+"']" ).find('.field_input').attr('value',field_new_value);
                }else{
                    $("li[data-field-id='"+field_id+"']" ).find('.field_input option').removeAttr('selected').filter('[value="'+field_new_value+'"]').attr('selected', true)
                }          
                
                
                $("li[data-field-id='"+field_id+"']" ).find('.show_input_span').text(field_new_value);
                           
        });
      total_price = cleanNumber($('#'+calculator_form_id).find('.cal_total_price').text());
        //total_price = calTotalPrice;
        var form_data = $("#"+calculator_form_id).serializeArray();
        for($i=0;$i<form_data.length;$i++){
       
            var $form = $("#"+calculator_form_id);
                                
            var $field = $form.find('[name=' + form_data[$i].name + ']');
            if($field.attr('data-field-code')){
            form_data[$i].field_code = $field.attr('data-field-code');
            }
        
        }
        var lineItems =[];

       item_id = $('#'+item_line_id).find('.open_calculator').data('item-id');
        
       var template = $('#'+item_line_id).find('.open_calculator').data('templates');
        if(template){
            var template_type_id = $('.select_template_option').val();
        
        }else{
            var template_type_id = $('#'+item_line_id).find('.open_calculator').data('template-type-id');
        }
        if(!template_type_id){
            template_type_id = '0';
        }
       var original_unit_price = $('#'+item_line_id).find('.open_calculator').data('item-unit-price');
       var estimate_line_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
 
       if(parseFloat(item_price) == parseFloat(original_unit_price) ){
           var customUnitPrice =0;
       }else{
           var customUnitPrice =1;
       }
       //if(item_quantity>0 && total_price>0){


           lineItems.push({
               'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
               'customUnitPrice':customUnitPrice,
               'proposalServiceId':proposal_service_id,
               'id':estimate_line_id,
               'itemId':item_id,
               'PhaseId':phase_id,
               'quantity':item_quantity,
               'unitPrice':item_price,
               'totalPrice':total_price,
               'overHeadRate':overheadRate,
               'profitRate':profitRate,
               'overHeadPrice':overheadPrice,
               'profitPrice':profitPrice,
               'basePrice':item_base_price,
               'taxRate':taxRate,
               'taxPrice':taxPrice,
               'truckingOverHeadRate': cal_trucking_oh,
               'truckingProfitRate': cal_trucking_pm,
               'truckingOverHeadPrice': cal_trucking_oh_Price,
               'truckingProfitPrice': cal_trucking_pm_Price,
               'truckingTotalPrice': cal_trucking_total_Price,
               'sub_id':'0', 
               'template_type_id':template_type_id,
               'edited_unit_price':edited_unit_price,
                'edited_base_price':edited_base_price,
                'edited_total_price':edited_total_price,
           });

      // }
       // }

//})
//})

       $.ajax({
           url: '/ajax/saveEstimatorValues/',
           type: 'post',
           data: {
               'lineItems':lineItems,
               'proposalServiceId':proposal_service_id,
               'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
               'apply':0,
               'values':form_data,
               'itemId':item_id,
               'PhaseId':phase_id,
               'calculator_name':calculator_form_id,
               'calculation_id':estimate_calculator_id,
               'fields':fields
           },
           success: function(data){
                    try{
                        data = JSON.parse(data);
                    } catch (e) {
                        swal("Error", "An error occurred Please try again");
                        return false;
                    }
               if(calculator_form_id=='sealcoating_form'){
                    if(estimate_line_id){
                        deleteOldSealcoatChildItem(data.lineItemId);
                        //sealcoatchilditemadd(data.lineItemId);
                    }else{
                        sealcoatchilditemadd(data.lineItemId);
                    }
                    
                }
               save_custom_child_estimation(data.lineItemId,data.calId)
           },
           error: function( jqXhr, textStatus, errorThrown ){
                swal("Error", "An error occurred Please try again");
                console.log( errorThrown );
            }
       })
   });


   function save_custom_child_estimation(perent_item_id,calId){
    var custom_child_item_unit_price = cleanNumber($('#custom_child_item_unit_price').val());
    var custom_child_item_quantity = cleanNumber($('#custom_child_item_quantity').val());
    var custome_child_item_overhead = cleanNumber($('.custome_child_item_overhead').val());
    var custome_child_item_profit = cleanNumber($('.custome_child_item_profit').val());
    var custome_child_tax_rate = cleanNumber($('.custome_child_tax_rate').val());
    var custom_child_tax_amount = cleanNumber($('.custome_child_tax_amount').text());
    var custom_child_item_name = $('#custom_child_item_name').val();
    var custom_child_item_notes = $('#custom_child_item_notes').val();

   var child_custom_work_order = 0;
   if($('#child_custom_work_order').prop("checked")){
       child_custom_work_order = 1;
   }else{
       child_custom_work_order = 0;
   }
    var tempoverheadPrice = ((custom_child_item_unit_price * custome_child_item_overhead) / 100);
    var tempprofitPrice = ((custom_child_item_unit_price * custome_child_item_profit) / 100);
    var custome_child_item_unit_price_text = parseFloat(custom_child_item_unit_price) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);
        $('.custome_child_item_unit_price_text').text('$'+addCommas(number_test(custome_child_item_unit_price_text)));
        tempoverheadPrice = tempoverheadPrice * custom_child_item_quantity;
        tempprofitPrice = tempprofitPrice * custom_child_item_quantity;
    var custom_child_total = custom_child_item_unit_price * custom_child_item_quantity;
        
    var totalPrice = parseFloat(custom_child_total) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice)+ parseFloat(custom_child_tax_amount);

    var lineItems =[];
    lineItems.push({
                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                'customUnitPrice':0,
                'proposalServiceId':proposal_service_id,
                'parentId':perent_item_id,
                'id':child_lineItemId,
                'itemId':0,
                'PhaseId':phase_id,
                'quantity':custom_child_item_quantity,
                'unitPrice':custome_child_item_unit_price_text,
                'totalPrice':totalPrice,
                'overHeadRate':custome_child_item_overhead,
                'profitRate':custome_child_item_profit,
                'overHeadPrice':tempoverheadPrice,
                'profitPrice':tempprofitPrice,
                'basePrice':custom_child_item_unit_price,
                'taxRate':custome_child_tax_rate,
                'taxPrice':custom_child_tax_amount,
                'truckingOverHeadRate': 0,
                'truckingProfitRate': 0,
                'truckingOverHeadPrice': 0,
                'truckingProfitPrice': 0,
                'truckingTotalPrice': 0,
                'customName':custom_child_item_name,
                'notes':custom_child_item_notes,
                'sub_id':'0',
                'child_material':'0',
                'work_order':child_custom_work_order
            });
            $.ajax({
            url: '/ajax/saveEstimateLineItems/',
            type: 'post',
            data: {
                'lineItems':lineItems,
                'proposalServiceId':proposal_service_id,
                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                'PhaseId':phase_id,
                'apply':0,
            },
            success: function(data){
                try{
                    data = JSON.parse(data);
                } catch (e) {
                    swal("Error", "An error occurred Please try again");
                    return false;
                }
                unsave_cal=false;
                
                unsave_cal=false;  
                estimate_calculator_id =calId;
               
                $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
               
                //update_proposal_overhead_profit();
                var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
                unsaved = false;
                unsaved_row = false;
                if(data.estimate.completed==0){
                    $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                }else{
                    $('#service_'+proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                }
                $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                swal(
                    'Custom Item Saved',
                    ''
                );

                if(data.estimate.child_has_updated_flag==0 ){
                    $('.service_child_has_updated_flag_'+proposal_service_id).hide();
                    $('#service_'+proposal_service_id+' .toggle').addClass('text-active-color').removeClass('text-active-color2');
                    $('#service_'+proposal_service_id+' .toggle').css('background-color','#aeaeae');
                }
                $('.service_total_'+proposal_service_id).val(data.estimate.service_price);


                if(has_custom_custom_total_price_update){
                    update_custom_custom_itam_total(data.lineItemId,perent_item_id);

                }else{
                    get_service_item_list_by_phase_id();
                    get_proposal_breakdown();
                    swal('Estimate Saved','');
                    get_child_items_list(perent_item_id,false,true);
                }
                

                
                $('.if_item_saved').show();
                child_save_done =true;
                $("#add_custom_child_item_model").dialog('close');
                $('#estimateLineItemTable').DataTable().ajax.reload();
            },
            error: function( jqXhr, textStatus, errorThrown ){
                swal("Error", "An error occurred Please try again");
                console.log( errorThrown );
            }
            });
}

$(document).on("click",".add_phases_btn",async function(e) {  
    $('.edit_phase_inputs').css('display','none');
    $('.show_phase_name').css('display','flex');
    var len = $(this).closest('ul').find('.added_phase_list').length;
    $(this).closest('li').find('.add_phase_input_field').val('Phase '+(len+1));
    $('.add_phase_input_li').show();
    $(this).closest('li').find('.add_phase_input_field').select();
});
$(document).on("click",".cancel_new_phase",async function(e) {  
    $('.add_phase_input_li').hide();$('.add_phase_input_field').val('');
});

$(document).on("click",".save_new_phase",async function(e) {  
    swal({
            title: 'Saving..',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timer: 2000,
            onOpen: () => {
            swal.showLoading();
            }
        });
    var phaseName = $(this).closest('li').find('.add_phase_input_field').val();
    //alert(phaseName);return false;
    if(!phaseName){
        swal("Warning", "Phase name can not be empty");
        return false;
    }
    $.ajax({
           url: '/ajax/addEstimatingPhase/',
           type: 'post',
           data: {
               'phaseName':phaseName,
               'proposalServiceId':proposal_service_id,
               'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
           },
           success: function(data){
               data = JSON.parse(data);
               $('.add_phase_input_field').val('');
               $('.add_phase_input_li').hide();
               
               
                var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
                
                if(data.estimate==0){
                    $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                    temp_count = temp_count+1;
                    $('.show_pending_est_msg').text('You have '+temp_count+' additional services that you need to Estimate');
                }else{
                    $('#service_'+proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                    temp_count = temp_count-1;
                    $('.show_pending_est_msg').text('You have '+temp_count+' additional services that you need to Estimate');
                    
                }
                get_proposal_service_phases();
                swal(
                                'Phase Created',
                                ''
                            );
            },
           error: function( jqXhr, textStatus, errorThrown ){
               console.log( errorThrown );
           }
       })
       
});

function get_proposal_service_phases(){
    
    $.ajax({
           url: '/ajax/getProposalServicePhases/'+proposal_service_id+'/<?php echo $proposal->getProposalId(); ?>',
           type: 'get',
           
           success: function(data){
               data = JSON.parse(data);
               data2 = data.phases;
             public_phases = data.phases;
               $('.added_phase_list').remove();
               $n=0;
              for($i=0;$i<data.phases.length;$i++){
                    if(data2[$i].complete==0){
                        var phase_check_hide = 'phase_checked_hide';
                    }else{
                        var phase_check_hide = '';
                    }
                    $n = $i+1;
                    var temp_item_name =data2[$i].name;
                    var temp_item_name = temp_item_name.replace(/"/g, "&quot;");
                    if($i==0){
                        phase_id =data2[$i].id;
                        get_service_item_list_by_phase_id();
                        get_proposal_breakdown();
                        //update_proposal_overhead_profit();
                        get_summary_data_by_phase_id();
                            if(<?php echo $proposal_status_id;?> == '5'){
                                $('.sortable-phase').append('<li id="ids_'+data2[$i].id+'" class="added_phase_list selected_phase" style="display:block;" ><span class="show_phase_name dbl_click_edit_phase" ><span class="sorting_number" style="margin-left:10px;">'+$n+'. </span>&nbsp;<span class="phase_name phase_name_'+data2[$i].id+' " data-phase-id="'+data2[$i].id+'" style="cursor:pointer">'+data2[$i].name+'</span><span class="phase_checked '+phase_check_hide+'"><i class="fa fa-fw fa-2x fa-check-circle-o small" style="position: relative;top: 3px;padding-right: 2px;"></i></span><span class="phase_edit_option_icon "><i class="fa fa-fw fa-2x fa-cog small tiptipleft" title="Click for Options" style="position: relative;cursor:pointer;top: 3px;padding-right: 2px;"></i></span></span><span class="edit_phase_inputs" style="display:none;width:100%;margin-top:4px;margin-left:4px;vertical-align: middle;"><input type="text" style="float:left;text-align:left;" value="'+temp_item_name+'"  class="text input140 edit_phase_input_field_'+data2[$i].id+'" id="" ><br/><a href="JavaScript:void(0);" style="float: left;margin-left: 2px;" class="delete_phase btn tiptip " title="Delete" data-phase-id="'+data2[$i].id+'" ><i class="fa fa-fw fa-trash"></i></a><a href="javascript:void(0);" style="float: left;margin-left: 2px;" class="btn  tiptip delete_phase_all_items" data-phase-id="'+data2[$i].id+'"  title="Delete all phase items"  ><i class="fa fa-fw fa-1x fa-undo " ></i></a><a href="javascript:void(0);" style=" float: right;margin-right: 8px;margin-left: 2px;"  data-phase-id="'+data2[$i].id+'" class="btn mb-5px  update_phase_btn blue-button" >Save</a><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn  tiptip cancel_edit_phase" data-phase-id="'+data2[$i].id+'"  title="Cancel"  ><i class="fa fa-fw fa-1x fa-close " ></i></a></span></li>');
                            }else{
                                $('.sortable-phase').append('<li id="ids_'+data2[$i].id+'" class="added_phase_list selected_phase" style="display:block;" ><span class="show_phase_name dbl_click_edit_phase" ><a class="handle"><i class="fa fa-sort"></i></a><span class="sorting_number">'+$n+'. </span>&nbsp;<span class="phase_name phase_name_'+data2[$i].id+' " data-phase-id="'+data2[$i].id+'" style="cursor:pointer">'+data2[$i].name+'</span><span class="phase_checked '+phase_check_hide+'"><i class="fa fa-fw fa-2x fa-check-circle-o small" style="position: relative;top: 3px;padding-right: 2px;"></i></span><span class="phase_edit_option_icon "><i class="fa fa-fw fa-2x fa-cog small tiptipleft" title="Click for Options" style="position: relative;cursor:pointer;top: 3px;padding-right: 2px;"></i></span></span><span class="edit_phase_inputs" style="display:none;width:100%;margin-top:4px;margin-left:4px;vertical-align: middle;"><input type="text" style="float:left;text-align:left;" value="'+temp_item_name+'"  class="text input140 edit_phase_input_field_'+data2[$i].id+'" id="" ><br/><a href="JavaScript:void(0);" style="float: left;margin-left: 2px;" class="delete_phase btn tiptip " title="Delete" data-phase-id="'+data2[$i].id+'" ><i class="fa fa-fw fa-trash"></i></a><a href="javascript:void(0);" style="float: left;margin-left: 2px;" class="btn  tiptip delete_phase_all_items" data-phase-id="'+data2[$i].id+'"  title="Delete all phase items"  ><i class="fa fa-fw fa-1x fa-undo " ></i></a><a href="javascript:void(0);" style=" float: right;margin-right: 8px;margin-left: 2px;"  data-phase-id="'+data2[$i].id+'" class="btn mb-5px  update_phase_btn blue-button">Save</a><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn  tiptip cancel_edit_phase" data-phase-id="'+data2[$i].id+'"  title="Cancel"  ><i class="fa fa-fw fa-1x fa-close " ></i></a></span></li>');
                            }
                        }else{
                                if(<?php echo $proposal_status_id;?> == '5'){
                                    $('.sortable-phase').append('<li id="ids_'+data2[$i].id+'" class="added_phase_list" style="display:block;" ><span class="show_phase_name dbl_click_edit_phase" ><span class="sorting_number" style="margin-left:10px;">'+$n+'. </span>&nbsp;<span class="phase_name phase_name_'+data2[$i].id+' " data-phase-id="'+data2[$i].id+'" style="cursor:pointer">'+data2[$i].name+'</span><span class="phase_checked '+phase_check_hide+'"><i class="fa fa-fw fa-2x fa-check-circle-o small" style="position: relative;top: 3px;padding-right: 2px;"></i></span><span class="phase_edit_option_icon "><i class="fa fa-fw fa-2x fa-cog small tiptipleft" title="Click for Options" style="position: relative;cursor:pointer;top: 3px;padding-right: 2px;"></i></span></span><span class="edit_phase_inputs" style="display:none;width:100%;margin-top:4px;margin-left:4px;vertical-align: middle;"><input type="text" style="float:left;text-align:left;" value="'+temp_item_name+'"  class="text input140 edit_phase_input_field_'+data2[$i].id+'" id="" ><br/><a href="JavaScript:void(0);" style="float: left;margin-left: 2px;" class="delete_phase btn tiptip " title="Delete" data-phase-id="'+data2[$i].id+'" ><i class="fa fa-fw fa-trash"></i></a><a href="javascript:void(0);" style="float: left;margin-left: 2px;" class="btn  tiptip delete_phase_all_items" data-phase-id="'+data2[$i].id+'"  title="Delete all phase items"  ><i class="fa fa-fw fa-1x fa-undo " ></i></a><a href="javascript:void(0);" style=" float: right;margin-right: 8px;margin-left: 2px;"  data-phase-id="'+data2[$i].id+'" class="btn mb-5px  update_phase_btn blue-button" >Save</a><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn  tiptip cancel_edit_phase" data-phase-id="'+data2[$i].id+'"  title="Cancel"  ><i class="fa fa-fw fa-1x fa-close " ></i></a></span></li>');
                                }else{
                                    $('.sortable-phase').append('<li id="ids_'+data2[$i].id+'" class="added_phase_list" style="display:block;" ><span class="show_phase_name dbl_click_edit_phase" ><a class="handle"><i class="fa fa-sort"></i></a><span class="sorting_number">'+$n+'. </span>&nbsp;<span class="phase_name phase_name_'+data2[$i].id+' " data-phase-id="'+data2[$i].id+'" style="cursor:pointer">'+data2[$i].name+'</span><span class="phase_checked '+phase_check_hide+'"><i class="fa fa-fw fa-2x fa-check-circle-o small" style="position: relative;top: 3px;padding-right: 2px;"></i></span><span class="phase_edit_option_icon "><i class="fa fa-fw fa-2x fa-cog small tiptipleft" title="Click for Options" style="position: relative;cursor:pointer;top: 3px;padding-right: 2px;"></i></span></span><span class="edit_phase_inputs" style="display:none;width:100%;margin-top:4px;margin-left:4px;vertical-align: middle;"><input type="text" style="float:left;text-align:left;" value="'+temp_item_name+'"  class="text input140 edit_phase_input_field_'+data2[$i].id+'" id="" ><br/><a href="JavaScript:void(0);" style="float: left;margin-left: 2px;" class="delete_phase btn tiptip " title="Delete" data-phase-id="'+data2[$i].id+'" ><i class="fa fa-fw fa-trash"></i></a><a href="javascript:void(0);" style="float: left;margin-left: 2px;" class="btn  tiptip delete_phase_all_items" data-phase-id="'+data2[$i].id+'"  title="Delete all phase items"  ><i class="fa fa-fw fa-1x fa-undo " ></i></a><a href="javascript:void(0);" style=" float: right;margin-right: 8px;margin-left: 2px;"  data-phase-id="'+data2[$i].id+'" class="btn mb-5px  update_phase_btn blue-button"  >Save</a><a href="javascript:void(0);" style="float: right;margin-left: 2px;" class="btn  tiptip cancel_edit_phase" data-phase-id="'+data2[$i].id+'"  title="Cancel"  ><i class="fa fa-fw fa-1x fa-close " ></i></a></span></li>');
                                    
                                }
                        }
              }
              $('.set_loader_phase').hide();
              initButtons();
              initTipTip();
              $('#service_'+proposal_service_id).find('.add_phase_li').css('display','inline-block');
             
              $(".sortable-phase").sortable( "refresh" );
           },
           error: function( jqXhr, textStatus, errorThrown ){
               console.log( errorThrown );
           }
       })
}
<?php if($proposal_status_id !=5){?>
$(document).on("dblclick",".dbl_click_edit_phase",function(e) {
    $('.edit_phase_inputs').css('display','none');
    $('.show_phase_name').css('display','flex');
    $('.add_phase_input_field').val('');
    $('.add_phase_input_li').hide();
    var total_phase =$(this).closest('.sortable-phase').find('li').length;
    if(total_phase == 2){
         
        $(this).closest('li').find('.delete_phase').css('display','none');
    }
    $(this).closest('li').find('.edit_phase_inputs').css('display','inline-block');
    $(this).closest('li').find('.show_phase_name').css('display','none');
});

$(document).on("click",".phase_edit_option_icon",function(e) {
    $('.edit_phase_inputs').css('display','none');
    $('.show_phase_name').css('display','flex');
    $('.add_phase_input_field').val('');
    $('.add_phase_input_li').hide();
    var total_phase =$(this).closest('.sortable-phase').find('li').length;
    if(total_phase == 2){

        // $(this).closest('li').find('.delete_phase').css('display','none');
        // swal(
        //         'Last phase cannot be deleted of any service',
        //         ''
        //     );
    }
    $(this).closest('li').find('.edit_phase_inputs').css('display','inline-block');
    $(this).closest('li').find('.show_phase_name').css('display','none');
});
<?php }?>
$(document).on("click",".update_phase_btn",function(e) {

    swal({
            title: 'Saving..',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timer: 2000,
            onOpen: () => {
            swal.showLoading();
            }
        });

var temp_phase_id = $(this).attr('data-phase-id');
var phasename = $(this).closest('li').find('.edit_phase_input_field_'+temp_phase_id).val();

$.ajax({
           url: '/ajax/editEstimatingPhase/',
           type: 'post',
           data: {
               'phaseId':temp_phase_id,
               'phaseName':phasename,
               
           },
           success: function(data){
               data = JSON.parse(data);
               //get_proposal_service_phases();
               swal(
                                'Phase Updated',
                                ''
                            );
           },
           error: function( jqXhr, textStatus, errorThrown ){
               console.log( errorThrown );
           }
       })
       
       $('.phase_name_'+temp_phase_id).text(phasename);
       $(this).closest('li').find('.edit_phase_inputs').css('display','none');
       $(this).closest('li').find('.show_phase_name').css('display','flex');   

});
$(document).on("click",".cancel_edit_phase",function(e) {

$(this).closest('li').find('.edit_phase_inputs').css('display','none');
$(this).closest('li').find('.show_phase_name').css('display','flex');
});

$(document).on("click",".delete_phase",function(e) {

$(this).trigger('mouseout');
var total_phase =$(this).closest('.sortable-phase').find('li').length;
    if(total_phase == 2){

        // $(this).closest('li').find('.delete_phase').css('display','none');
        swal(
                '',
                '<p>Service must have at least one phase.</p><br/><p> Last remaining phase may not be deleted</p>'
            );
            return false;
    }
var temp_phase_id = $(this).attr('data-phase-id');
swal({
                title: "Are you sure?",
                text: "Phase will be permanently deleted",
                showCancelButton: true,
                confirmButtonText: 'Delete Phase',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    swal({
                    title: 'Deleting..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                    swal.showLoading();
                    }
                });
                
        $.ajax({
                url: '/ajax/deleteEstimatingPhase/',
                type: 'post',
                data: {
                    'phaseId':temp_phase_id,
                    'proposalServiceId':proposal_service_id,
                },
                success: function(data){
                    data = JSON.parse(data);
                    $('#categoryTabs').hide();
                    $('#page_loading').show();
                    calculate_unit_price();
                    get_proposal_service_phases();
                    $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                        $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                        
                        $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                        $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                        $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                    var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
                     
                    if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                        if(data.estimation==0){
                            $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                            temp_count = temp_count+1;
                            $('.show_pending_est_msg').text('You have '+temp_count+' additional services that you need to Estimate');
                        }else{
                            $('#service_'+proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                            temp_count = temp_count-1;
                            $('.show_pending_est_msg').text('You have '+temp_count+' additional services that you need to Estimate');
                        }
                        if(data.child_has_updated_flag==0 ){
                            $('.service_child_has_updated_flag_'+proposal_service_id).hide();
                            $('#service_'+proposal_service_id+' .toggle').addClass('text-active-color').removeClass('text-active-color2');
                            $('#service_'+proposal_service_id+' .toggle').css('background-color','#aeaeae');
                        }
                        swal(
                                'Phase Deleted',
                                ''
                            );
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
            })
       
    } else {
                    swal("Cancelled", "Your Phase is safe :)", "error");
    }
}); 

});


<?php if($proposal_status_id !=5){?>
    $(".sortable-phase").sortable({
            helper: fixHelper,
            handle:".handle",
            //containment: ".add_phase_li ",
           
            stop:function () {
               
                var postData = $(this).sortable("serialize");
                $.ajax({
                    type:"POST",
                    url:"<?php echo site_url('ajax/orderPhases') ?>",
                    data:postData,
                    async:false
                });

                $('#service_'+proposal_service_id+' .sortable-phase .sorting_number').each(function (i) {
                   
                    var humanNum = i + 1;
                    $(this).html(humanNum + '. ');
                });
            },
           
        });
<?php }?>
            // Return a helper with preserved width of cells
    var fixHelper = function(e, ui) {
        ui.children().each(function() {
            $(this).width($(this).width());
        });
        return ui;
    };
    
    $(document).on("click",".added_phase_list",function(event) {
        if($(this).hasClass("selected_phase")){
            return false;
        }
        
        var temp_phase_id = $(this).attr('id');
        phase_id =temp_phase_id.replace(new RegExp("^" + 'ids_'), '');
        $('.edit_phase_inputs').css('display','none');
        $('.show_phase_name').css('display','flex');
        $(this).closest('ul').find('.selected_phase').removeClass('selected_phase');
        $(this).addClass('selected_phase');
        $('#categoryTabs').hide();
        
        $('#page_loading').show();
        get_service_item_list_by_phase_id();
        get_proposal_breakdown()
        calculate_unit_price();
        get_summary_data_by_phase_id();
        get_sub_contractors_items();
        var services_title = $('#service_'+proposal_service_id+' .service_title_name').text();
        var phase_title = $('#service_'+proposal_service_id+' .phase_name_'+phase_id).text();
            
        $('.heading_proposal_phase').text(services_title+' | '+phase_title);
    
    
    });

    function get_service_item_list_by_phase_id(){
        $('.table_child_flag,.item_has_nagetive_flag,.child_has_updated_flag,.show_child_icon,.is_trucking_child,.is_labor_child,.is_equipment_child,.is_custom_child,.is_fees_child,.is_permit_child,.item_added_template,.remove_template_item_line').hide();
       
                                        $('table tr').css('color','#444444');
        $.ajax({
            url: '/ajax/getPhaseLineItems/',
            type: 'post',
            data: {
                'phaseId':phase_id,
                'proposal_service_id':proposal_service_id,
            },
            success: function( data){
                data = JSON.parse(data);
                check_phase = data.phase_complete;
                var templateTotal = data.templateTotal;
                $('.phase_max_days').text(data.phase_max_days);
                data = data.lineItems;
                var estimate_final_total = 0;
                var phase_child_flag =false;
               
                $('.estimatingItemsTable').each(function(){
                    var $table = $(this);
                    var table_total = 0;
                    var table_child_flag =false;
                    $table.find('tr').each(function(row, tr){
                        if(row>0){
                           
                            $(tr).find('.quantity').text('0');
                            $(tr).find('.total-price').text('0');
                            $(tr).find('.open_calculator').attr('data-estimate-line-id','');
                            $(tr).find('.open_calculator').attr('data-custom-total-price','0');
                            $(tr).find('.open_calculator').attr('data-custom-unit-price','0');
                            $(tr).find('.open_calculator').attr('data-item-total-price','0');
                            $(tr).find('.open_calculator').attr('data-edited-base-price','0');
                            $(tr).find('.open_calculator').attr('data-edited-unit-price','0');
                            $(tr).find('.open_calculator').attr('data-edited-total-price','0');
                            $(tr).find('.edited_unit_price_flag').text('');
                            var tr_item_id = $(tr).attr('id');
                            var tr_item_id = tr_item_id.replace(new RegExp("^" + 'items_'), '');
                            if(data.length){
                                var new_data = data.filter(x => x.item_id == tr_item_id);
                                if(new_data.length){
                                    $(tr).find('#items_checkbox_'+tr_item_id).val(new_data[0].id);
                                    $(tr).find('.quantity').text(addCommas(number_test2(new_data[0].quantity)));
                                    
                                    $(tr).find('.unit-price').val(new_data[0].unit_price);
                                    $(tr).find('.span_unit_price1').text('$'+addCommas(number_test(new_data[0].unit_price)));
                                    if(new_data[0].custom_total_price){
                                        $(tr).find('.total-price').text(addCommas(number_test(new_data[0].total_price))+'*');
                                    }else{
                                        $(tr).find('.total-price').text(addCommas(number_test(new_data[0].total_price))); 
                                    }
                                    if(new_data[0].edited_unit_price==1 || new_data[0].edited_base_price){
                                        $(tr).find('.edited_unit_price_flag').text('*');
                                        $(tr).find('.total-price').text(addCommas(number_test(new_data[0].total_price)));
                                    }
                                    
                                   
                                   
                                    
                                    $(tr).find('.open_calculator').attr('data-estimate-line-id',new_data[0].id);
                                    $(tr).find('.open_calculator').attr('data-custom-total-price',new_data[0].custom_total_price);
                                    $(tr).find('.open_calculator').attr('data-custom-unit-price',new_data[0].custom_unit_price);
                                    $(tr).find('.open_calculator').attr('data-item-total-price', new_data[0].parent_total_price);
                                    $(tr).find('.open_calculator').attr('data-edited-base-price',new_data[0].edited_base_price);
                                    $(tr).find('.open_calculator').attr('data-edited-unit-price',new_data[0].edited_unit_price);
                                    $(tr).find('.open_calculator').attr('data-edited-total-price',new_data[0].edited_total_price);
                                   
                                    $(tr).find('.deleteLineItem').attr('data-estimate-line-id',new_data[0].id);
                                    
                                    // if(new_data[0].notes_count>0){
                                    //     $(tr).find('.estimate_item_notes').css('background','#3c99d270');  
                                    // }else{
                                    //     $(tr).find('.estimate_item_notes').css('background','#f4f4f4');
                                    // }
                                    
                                    //$(tr).find('.deleteLineItem').show();
                                    $(tr).addClass('has_item_value');
                                    if(new_data[0].template_id){
                                        $(tr).find('.open_calculator').attr('data-template-type-id', new_data[0].template_id);
                                        $(tr).addClass('item_has_template');
                                        $(tr).find('.item_added_template').attr('title','This item has been added via '+ new_data[0].template_name +' template');
                                        $(tr).find('.item_added_template').show();
                                        
                                    }else{
                                        $(tr).find('.open_calculator').attr('data-template-type-id', '');
                                        $(tr).removeClass('item_has_template');
                                        table_total = parseFloat(table_total) + parseFloat(new_data[0].total_price)
                                        estimate_final_total = parseFloat(estimate_final_total) + parseFloat(new_data[0].total_price);
                                    }

                                    
                                    var tooltip_msg = 'Child Items Added: <br/><br/>';
                                   
                                    if(new_data[0].is_custom_child>0){
                                        //$(tr).find('.is_custom_child').show();
                                        tooltip_msg = tooltip_msg+'- Custom <br/>';
                                    }
                                    // else{
                                    //     $(tr).find('.is_custom_child').hide();
                                    // }
                                    if(new_data[0].is_equipment_child>0){
                                        //$(tr).find('.is_equipment_child').show();
                                        tooltip_msg = tooltip_msg+'- Equipment <br/>';
                                    }
                                    // else{
                                    //     $(tr).find('.is_equipment_child').hide();
                                    // }
                                    if(new_data[0].is_labor_child>0){
                                        //$(tr).find('.is_labor_child').show();
                                        tooltip_msg = tooltip_msg+'- Labor <br/>';
                                    }
                                    // else{
                                    //     $(tr).find('.is_labor_child').hide();
                                    // }
                                    if(new_data[0].is_trucking_child>0){
                                        //$(tr).find('.is_trucking_child').show();
                                        tooltip_msg = tooltip_msg+'- Trucking <br/>';
                                    }
                                    // else{
                                    //     $(tr).find('.is_trucking_child').hide();
                                    // }
                                    if(new_data[0].is_fees_child>0){
                                        //$(tr).find('.is_fees_child').show();
                                        tooltip_msg = tooltip_msg+'- Fees <br/>';
                                    }
                                    // else{
                                    //     $(tr).find('.is_fees_child').hide();
                                    // }
                                    if(new_data[0].is_permit_child>0){
                                        //$(tr).find('.is_permit_child').show();
                                        tooltip_msg = tooltip_msg+'- Permit <br/>';
                                    }
                                    // else{
                                    //     $(tr).find('.is_permit_child').hide();
                                    // }
  
                                    if(new_data[0].child_count>0){
                                        
                                        $(tr).find('.show_child_icon').attr('title',tooltip_msg);
                                        initTiptip();
                                        $(tr).find('.show_child_icon').show();
                                    }else{
                                        $(tr).find('.show_child_icon').hide();
                                    }
                                    if(new_data[0].is_child_has_updated_flag>0){
                                        $(tr).find('.child_has_updated_flag').show();
                                        table_child_flag= true;
                                        phase_child_flag =true;
                                    }else{
                                        $(tr).find('.child_has_updated_flag').hide();
                                    }
                                    
                                    if(parseFloat(new_data[0].profit_rate)<0  || parseFloat(new_data[0].overhead_rate) <0){
                                        $(tr).find('.item_has_nagetive_flag').show();
                                        $(tr).css('color','red');
                                    }else{
                                        $(tr).find('.item_has_nagetive_flag').hide();
                                        $(tr).css('color','#444444');
                                    }
                                    
                                }else{
                                    $(tr).find('.deleteLineItem').attr('data-estimate-line-id','');
                                    $(tr).find('.open_calculator').attr('data-template-type-id','');
                                    //$(tr).find('.deleteLineItem').hide();
                                    $(tr).removeClass('has_item_value');
                                    $(tr).removeClass('item_has_template');
                                }

                            }else{
                                $(tr).find('.deleteLineItem').attr('data-estimate-line-id','');
                                $(tr).find('.open_calculator').attr('data-template-type-id','');
                                // $(tr).find('.deleteLineItem').hide();
                                $(tr).removeClass('has_item_value');
                                $(tr).removeClass('item_has_template');
                            }
                        }
                    });
                    var table_id =$table.attr('id');
                    table_id = table_id.replace('itemsType', '');
                    if(table_total>0){
                        $('.table_total_'+table_id).text('$'+addCommas(number_test(table_total)));
                    }else{
                        $('.table_total_'+table_id).text('');
                    }
                    
                    if(table_child_flag){
                        $('.table_child_has_updated_flag_'+table_id).show();
                    }else{
                        $('.table_child_has_updated_flag_'+table_id).hide();
                    }
                    
                });
                
                if(check_phase){
                   
                    $('#ids_'+phase_id+' .phase_checked').removeClass('phase_checked_hide');
                    }else{
                       
                        $('#ids_'+phase_id+' .phase_checked').addClass('phase_checked_hide');
                    }
                if(phase_child_flag){
                        $('.phase_child_has_updated_flag_'+phase_id).show();
                        
                }else{
                    $('.phase_child_has_updated_flag_'+phase_id).hide();
                }
                var active_table_count =0;
                $('.templateItemsTable').each(function(){
                    var $table = $(this);
                    var table_total = 0;
                    var total_item = 0;
                    var check_active =false;
                    


                    if($table.attr('data-empty-template')){
                        
                        var table_id = $table.attr('id');
                            table_id = table_id.replace('template_itemsType', '');
                         
                        if(templateTotal.length){
                            
                        var new_template = templateTotal.filter(x => x.template_id == table_id);
                        
                        if(new_template.length){
                            
                         $($table).addClass('has_template_saved_items');
                         check_active =true;
                            $table.find('tbody tr').addClass('has_item_value');
                            $table.find('tbody tr .templateEmptyDayColumn').text(new_template[0].days);
                            $table.find('tbody tr .templateEmptyHrsColumn').text(Math.floor(new_template[0].hours_per_day));
                            $('#templateHeading'+table_id).find('.next_estimate_items').hide();
                            $('#templateHeading'+table_id).find('.edit_estimate_items_price').css('display','');
                            $('#templateHeading'+table_id).find('.edit_template_total_price').css('display','');
                            $('#templateHeading'+table_id).find('.delete_template_items').css('display','');
                        }else{
                                $($table).removeClass('has_template_saved_items');
                                $table.find('tbody tr').removeClass('has_item_value');
                            }
                        }else{
                            $($table).removeClass('has_template_saved_items');
                                $table.find('tbody tr').removeClass('has_item_value');
                        }
                    }else{
                    $table.find('tr').each(function(row, tr){
                        
                        if(row>0){
                            $(tr).find('.quantity').text('0');
                            $(tr).find('.total-price').text('0');

                            $(tr).find('.default_qty').text($(tr).find('.open_calculator').attr('data-template-item-default-qty'));
                            $(tr).find('.default_days').text($(tr).find('.open_calculator').attr('data-template-item-default-days'));
                            $(tr).find('.default_hpd').text($(tr).find('.open_calculator').attr('data-template-item-default-hpd'));
                            
                            var table_id =$table.attr('id');
                            table_id = table_id.replace('template_itemsType', '');
                            var tr_item_id = $(tr).attr('id');
                            if(tr_item_id){
                                var tr_item_id = tr_item_id.replace(new RegExp("^" + 'template_items_'+table_id+'_'), '');
                            }else{
                                var tr_item_id = 0;
                            }
                            if(data.length){
                                
                                var new_data = data.filter(x => x.item_id == tr_item_id && x.template_id == table_id);
                                
                                if(new_data.length){
                                    for($i=0;$i<new_data.length;$i++){
                                        
                                    if(new_data[$i].template_id == table_id){
                                    
                                    total_item++;
                                    $(tr).find('#template_items_checkbox_'+tr_item_id).val(new_data[$i].id);
                                    $(tr).find('.quantity').text(addCommas(number_test2(new_data[$i].quantity)));
                                    $(tr).find('.unit-price').val(number_test(new_data[$i].unit_price));
                                    
                                    $(tr).find('.span_unit_price1').text('$'+addCommas(number_test(new_data[$i].unit_price)));
                                    $(tr).find('.total-price').text(addCommas(number_test(new_data[$i].total_price)));
                                    $(tr).find('.open_calculator').attr('data-estimate-line-id',new_data[$i].id);
                                    $(tr).find('.deleteLineItem').attr('data-estimate-line-id',new_data[$i].id);
                                    $(tr).find('.open_calculator').attr('data-custom-total-price',new_data[$i].custom_total_price);
                                    $(tr).find('.open_calculator').attr('data-item-total-price', new_data[$i].parent_total_price);
                                    $(tr).find('.default_qty').text(new_data[$i].num_people);
                                    $(tr).find('.default_days').text(new_data[$i].days);
                                    $(tr).find('.default_hpd').text(Number(new_data[$i].hours_per_day));
                                    //$(tr).find('.deleteLineItem').show();
                                    $(tr).addClass('has_item_value');
                                    check_active =true;
                                    $(tr).find('.remove_template_item_line').show();
                                    // if(new_data[$i].notes_count>0){
                                    //     $(tr).find('.estimate_item_notes').css('background','#3c99d270');  
                                    // }else{
                                    //     $(tr).find('.estimate_item_notes').css('background','#f4f4f4');
                                    // }
                                    if(new_data[$i].is_custom_child>0){
                                        $(tr).find('.is_custom_child').show();
                                    }else{
                                        $(tr).find('.is_custom_child').hide();
                                    }
                                    if(new_data[$i].is_equipment_child>0){
                                        $(tr).find('.is_equipment_child').show();
                                    }else{
                                        $(tr).find('.is_equipment_child').hide();
                                    }
                                    if(new_data[$i].is_labor_child>0){
                                        $(tr).find('.is_labor_child').show();
                                    }else{
                                        $(tr).find('.is_labor_child').hide();
                                    }
                                    if(new_data[$i].is_trucking_child>0){
                                        $(tr).find('.is_trucking_child').show();
                                    }else{
                                        $(tr).find('.is_trucking_child').hide();
                                    }
                                    if(new_data[$i].is_fees_child>0){
                                        $(tr).find('.is_fees_child').show();
                                    }else{
                                        $(tr).find('.is_fees_child').hide();
                                    }
                                    if(new_data[$i].is_permit_child>0){
                                        $(tr).find('.is_permit_child').show();
                                    }else{
                                        $(tr).find('.is_permit_child').hide();
                                    }
                                    
                                    table_total = parseFloat(table_total) + parseFloat(new_data[$i].total_price);
                                    estimate_final_total = parseFloat(estimate_final_total) + parseFloat(new_data[$i].total_price);
                                    if(new_data[$i].calculator_value){
                                        var temp_saved_value = JSON.parse(new_data[$i].calculator_value);
                                        // for($i=0;$i<temp_saved_value.length;$i++){
                                        //     if(temp_saved_value[$i].name=="number_of_person"){
                                        //         $(tr).find('.default_qty').text(temp_saved_value[$i].value);
                                        //     }else if(temp_saved_value[$i].name=="hour_per_day"){
                                        //         $(tr).find('.default_hpd').text(temp_saved_value[$i].value);

                                        //     }else if(temp_saved_value[$i].name=="time_type_input"){
                                        //         $(tr).find('.default_days').text(temp_saved_value[$i].value);

                                        //     }
                                        // }
                                    }
                                    if(parseFloat(new_data[$i].profit_rate)<0  || parseFloat(new_data[$i].overhead_rate) <0){
                                        $(tr).find('.item_has_nagetive_flag').show();
                                        $(tr).css('color','red');
                                    }else{
                                        $(tr).find('.item_has_nagetive_flag').hide();
                                        $(tr).css('color','#444444');
                                    }
                                }else{
                                    $(tr).removeClass('has_item_value');
                                }
                                }
                                }else{
                                    
                                    $(tr).find('.deleteLineItem').attr('data-estimate-line-id','');
                                    //$(tr).find('.deleteLineItem').hide();
                                    $(tr).removeClass('has_item_value');

                                }
                            }else{
                                $(tr).find('.deleteLineItem').attr('data-estimate-line-id','');
                                //$(tr).find('.deleteLineItem').hide();
                                $(tr).removeClass('has_item_value');

                                
                                
                            }
                            $(tr).removeClass('has_value_changed');
                        }
                    });

                }
                console.log('check_active'+check_active);
                    if(check_active){
                        active_table_count++;
                    }
                   
                    var table_id =$table.attr('id');
                    table_id = table_id.replace('template_itemsType', '');
                   var temp_item_count  = ($table.find('tr').length)-1;
                   
                   if(total_item==temp_item_count && temp_item_count > 0){
                    $('.template_table_item_'+table_id).html('<i class="fa fa-fw fa-2x fa-check-square-o small " style="position: relative;top: 3.3px;"></i>');
                    
                    }else if(total_item>0){
                        $('.template_table_item_'+table_id).text('- ['+total_item+'/'+temp_item_count+']');
                   }else{
                    $('.template_table_item_'+table_id).text('');
                   }
                   var new_template ='';
                   if(templateTotal.length){
                    
                    var new_template = templateTotal.filter(x => x.template_id == table_id);
                    
                   }
                   
                    if(table_total>0){
                        $('.template_table_total_'+table_id).text('$'+addCommas(number_test(table_total)));
                    }else{
                         if(new_template.length){
                             $('.template_table_total_'+table_id).text('$'+addCommas(number_test(new_template[0].total_price)));
                             $('#fixed_template_total_day_'+table_id).text(new_template[0].days);
                             $('#fixed_template_total_hpd_'+table_id).text(Number(new_template[0].hours_per_day));
                             $('#fixed_template_total_hours_'+table_id).text(new_template[0].days * new_template[0].hours_per_day);
                             $('#templateHeading'+table_id).find('.fixed_template_rate').text(addCommas(Number(new_template[0].unit_price)));
                             $('#templateHeading'+table_id).attr('data-template-rate',new_template[0].unit_price);
                             $('#template_value_edit'+table_id).attr('data-template-rate',new_template[0].unit_price);
                             
                         }else{
                            $('.template_table_total_'+table_id).text('');
                            $('#fixed_template_total_day_'+table_id).text('-');
                            $('#fixed_template_total_hpd_'+table_id).text('-');
                            $('#fixed_template_total_hours_'+table_id).text('-');
                        }
                        
                    }
                });
                $('.template_active_table_count').text(active_table_count);
                // $('.service_total_'+proposal_service_id).val(number_test(estimate_final_total));
                check_tr_has_class();
                get_custom_items();
                if(<?php echo $proposal_status_id;?> ==5){
                    hide_all_accordion();
                }
            },
            error: function( jqXhr, textStatus, errorThrown ){
                console.log( errorThrown );
            }

        })
    }

    $(document).on("change",".labor_type",function(e) {

        unsave_cal=true;  
        var temp_type_name = $(".labor_type").val();
        if(temp_type_name){
            var new_data = laborGroupItems.filter(x => x.name == temp_type_name);
            var select_options = '<option value="">Select Item</option>';
            
              if(new_data[0].items){
                    var is_selected = '';
                    if(new_data[0].items.length =='1'){ 
                        is_selected = 'selected';
                        if(oh_pm_type==2){
        
                            $(".labor_cal_overhead").val(new_data[0].items[0].overhead_rate);
                            $(".labor_cal_profit").val(new_data[0].items[0].profit_rate);
                        }else{
                            $(".labor_cal_overhead").val(service_overhead_rate);
                            $(".labor_cal_profit").val(service_profit_rate);
                            
                        }
                    }
                    
                    $.each(new_data[0].items, function(index,jsonObject){
                        select_options +='<option data-base-unit-price="'+jsonObject.base_price+'" data-unit-single-name="'+jsonObject.unit_single_name+'" data-profit-rate="'+jsonObject.profit_rate+'" data-overhead-rate="'+jsonObject.overhead_rate+'" value="'+jsonObject.id+'" '+is_selected+'>'+jsonObject.name+'</option>';
                    });
                    
                   
              }else{
                var select_options = '<option value="">Select Item</option>';
              }
                
               
                $('.labor_item').html(select_options);
                $(".labor_item").select2();
                
        }else{
            var select_options = '<option value="">Select Item</option>';
            $('.labor_item').html(select_options);
            $(".labor_item").select2();
            //$('.equipement_cal_unit_price').text('$0.00');
        }
        //$( ".labor_item" ).trigger( "change" );
       //calculate_equipement_time_type();
   });
    $(document).on("change",".equipement_type",function(e) {  
        unsave_cal=true;  
        var temp_type_id = $(".equipement_type").val();
        if(temp_type_id){
            var new_data = equipments.filter(x => x.type_id == temp_type_id);
            var select_options = '<option value="">Select</option>';
            if(new_data[0].items){
                    var is_selected = '';
                   
                if(new_data[0].items.length =='1'){ 
                    is_selected = 'selected';
                    if(oh_pm_type==2){
    
                        $(".equipement_cal_overhead").val(new_data[0].items[0].overhead_rate);
                        $(".equipement_cal_profit").val(new_data[0].items[0].profit_rate);
                    }else{
                        $(".equipement_cal_overhead").val(service_overhead_rate);
                        $(".equipement_cal_profit").val(service_profit_rate);
                        
                    }
                }
                $.each(new_data[0].items, function(index,jsonObject){
                   
                    select_options +='<option data-unit-single-name="'+jsonObject.unit_single_name+'" data-base-unit-price="'+jsonObject.base_price+'" data-profit-rate="'+jsonObject.profit_rate+'" data-overhead-rate="'+jsonObject.overhead_rate+'" value="'+jsonObject.id+'" '+is_selected+'>'+jsonObject.name+'</option>';
                });
            }else{
                var select_options = '<option value="">Select Item</option>';
              }
                $('.equipement_item').html(select_options);
                $("#equipement_item").select2();
        }else{
            var select_options = '<option value="">Select Item</option>';
            $('.equipement_item').html(select_options);
            $("#equipement_item").select2();
            $('.equipement_cal_unit_price').text('$0.00');
        }
        //$( ".equipement_item" ).trigger( "change" );
       //calculate_equipement_time_type();
   });
   $(document).on("change",".equipement_item,.equipement_type ",function(e) {  
    unsave_cal=true; 
    if(oh_pm_type==2){
            var temp_item_profit_rate = $('.equipement_item').find(':selected').data('profit-rate');
            var temp_item_overhead_rate = $('.equipement_item').find(':selected').data('overhead-rate');
              $(".equipement_cal_overhead").val(temp_item_overhead_rate);
              $(".equipement_cal_profit").val(temp_item_profit_rate);
        }else{
            $(".equipement_cal_overhead").val(service_overhead_rate);
            $(".equipement_cal_profit").val(service_profit_rate);
            
        } 
       calculate_equipement_time_type();
   });
   $(document).on("keyup",".equipement_number_of_person,.equipement_hour_per_day,.equipement_time_type_input,.equipement_cal_tax,.equipement_cal_profit,.equipement_cal_overhead",function(e) {   
    unsave_cal=true;  
    
    
      calculate_equipement_time_type();
  });

  function calculate_equipement_time_type(is_custom_price=false){
        var time_type_input = $(".equipement_time_type_input").val();
        var number_of_person = $(".equipement_number_of_person").val();
        var hour_per_day = $(".equipement_hour_per_day").val();
        time_type_input = time_type_input.replace(/,/g, '');
        number_of_person = number_of_person.replace(/,/g, '');
        hour_per_day = hour_per_day.replace(/,/g, '');
        var temp_item_base_price = $('.equipement_item').find(':selected').data('base-unit-price');
        var unit_single_name = $('.equipement_item').find(':selected').data('unit-single-name');
        if(unit_single_name){
            $('.equipement_cal_unit_single_name').text('/ '+unit_single_name);
        }else{
            $('.equipement_cal_unit_single_name').text('');
        }
        
       
        var total_time = time_type_input*number_of_person;
        
        if(unit_single_name=='Hour'){
            total_time =  total_time * hour_per_day;
        }
        
        $(".equipment_total_time_value").text(addCommas(total_time));
        if(!temp_item_base_price){
            temp_item_base_price =0;
        }
        $('.equipement_cal_unit_price').text('$'+addCommas(number_test(temp_item_base_price)));
        var temp_item_quantity =total_time;
        var temp_overheadRate = cleanNumber($("#equipement_time_type_form").closest('form').find('.equipement_cal_overhead').val());
        var temp_profitRate = cleanNumber($("#equipement_time_type_form").closest('form').find('.equipement_cal_profit').val());
        
        if(temp_item_base_price && temp_item_base_price>0 && time_type_input && time_type_input>0 && number_of_person && number_of_person >0 && hour_per_day && hour_per_day>0)
        {

       
        var tempoverheadPrice = ((temp_item_base_price * temp_overheadRate) / 100);
        
        var tempprofitPrice = ((temp_item_base_price * temp_profitRate) / 100);
       
        var totalPrice = parseFloat(temp_item_base_price) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);
        var temp_item_price = totalPrice;
        tempoverheadPrice = tempoverheadPrice * temp_item_quantity;
        tempprofitPrice = tempprofitPrice * temp_item_quantity;
        $('.equipement_cal_unit_price').text('$'+addCommas(number_test(temp_item_price)));
        
        
        temp_total = temp_item_quantity * temp_item_price;

        var temp_taxRate = $('#equipement_time_type_form').find('.equipement_cal_tax').val();
        temp_taxRate = temp_taxRate.replace('%', '');
        var temptaxPrice = ((temp_total * temp_taxRate) / 100);
       
        var temp_total = parseFloat(temp_total) + parseFloat(temptaxPrice);
        //calTotalPrice = temp_total;
        
        if(!is_custom_price){
            $(".equipement_cal_overhead_price").text('$'+addCommas(number_test(tempoverheadPrice)));
            $(".equipement_cal_profit_price").text('$'+addCommas(number_test(tempprofitPrice)));
            $('#equipement_time_type_form').find('.equipement_cal_tax_amount').text('$'+addCommas(number_test(temptaxPrice)));
            $('.equipement_cal_total_price').text('$'+addCommas(number_test(temp_total)));
        }
    }else{
        $('.equipement_cal_total_price').text('$0.00');
    }
    var temp_equipement_type = $('.equipement_type').val();
        //$(".labor_cal_unit_price").text(addCommas(number_test(totalPrice)));
        if(temp_equipement_type && temp_item_base_price && temp_item_base_price>0 && time_type_input && time_type_input>0 && number_of_person && number_of_person >0 && hour_per_day && hour_per_day>0)
        {    $("#equipement_submit").removeClass('ui-state-disabled');
            $("#equipement_submit").attr('disabled',false);
            $('.item_equipement_total_edit_icon').show();
        }else{
            $("#equipement_submit").addClass('ui-state-disabled');
            $("#equipement_submit").attr('disabled',true);
            $('.item_equipement_total_edit_icon').hide();
        }
    }

    $(document).on('click',".equipement_cal_tax_checkbox",function() {
        if($(this).prop("checked")){
            $('.equipement_cal_tax').show();
        }else{
            $('.equipement_cal_tax').val(0);
            $('.equipement_cal_tax_amount').text(0);
            $('.equipement_cal_tax').hide();
            calculate_equipement_time_type();
        }
    })

    function save_equipement_estimation(perent_item_id){
        var lineItems =[];
        
        var form_data = $("#equipement_time_type_form").serializeArray();
        //var unit_price = $('#'+item_line_id).find('.unit-price').val();
        
        var temp_base_unit_price = cleanNumber($('#equipement_model').find('.equipement_item').find(':selected').attr('data-base-unit-price'));
        var temp_unit_price = cleanNumber($('#equipement_model').find('.equipement_cal_unit_price').text());
        var temp_item_id = $('#equipement_model').find('.equipement_item').val();
        //var original_unit_price = $('#'+item_line_id).find('.open_calculator').data('item-unit-price');
        //var perent_item_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
        var total_time_hours = cleanNumber($('#equipement_model').find('.equipment_total_time_value').text());
        var temp_cal_labor_total_Price = cleanNumber($('#equipement_model').find('.equipement_cal_total_price').text());
        
        var temp_overheadRate = cleanNumber($("#equipement_time_type_form").closest('form').find('.equipement_cal_overhead').val());
        var temp_profitRate = cleanNumber($("#equipement_time_type_form").closest('form').find('.equipement_cal_profit').val());
 
        var temp_overheadPrice =cleanNumber($(".equipement_cal_overhead_price").text());
        var temp_profitPrice =cleanNumber($(".equipement_cal_profit_price").text());

        var temp_taxRate = cleanNumber($('#equipement_time_type_form').find('.equipement_cal_tax').val());
        var temp_taxPrice = cleanNumber($('#equipement_time_type_form').find('.equipement_cal_tax_amount').text());
            lineItems.push({
                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                'customUnitPrice':0,
                'proposalServiceId':proposal_service_id,
                'parentId':perent_item_id,
                'id':child_lineItemId,
                'itemId':temp_item_id,
                'PhaseId':phase_id,
                'quantity':total_time_hours,
                'unitPrice':temp_unit_price,
                'totalPrice':temp_cal_labor_total_Price,
                'overHeadRate':temp_overheadRate,
                'profitRate':temp_profitRate,
                'overHeadPrice':temp_overheadPrice,
                'profitPrice':temp_profitPrice,
                'basePrice':temp_base_unit_price,
                'taxRate':temp_taxRate,
                'taxPrice':temp_taxPrice,
                'truckingOverHeadRate': 0,
                'truckingProfitRate': 0,
                'truckingOverHeadPrice': 0,
                'truckingProfitPrice': 0,
                'truckingTotalPrice': 0,
                'sub_id':'0', 
                'edited_unit_price':edited_unit_price,
                'edited_base_price':edited_base_price,
                'edited_total_price':edited_total_price,
            });

           

            $.ajax({
            url: '/ajax/saveEstimatorValues2/',
            type: 'post',
            data: {
                'lineItems':lineItems,
                'proposalServiceId':proposal_service_id,
                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                'itemId':temp_item_id,
                'values':form_data,
                'PhaseId':phase_id,
                'calculation_id':calculation_id,
                'apply':0,
            },
            success: function(data){
                try{
                    data = JSON.parse(data);
                } catch (e) {
                    swal("Error", "An error occurred Please try again");
                    return false;
                }
                unsave_cal=false;  
               
                
                
                revert_adjust_price1();
                
                //get_service_item_list();
               
                //update_proposal_overhead_profit();
                $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));

                if(parseInt(data.breakdown.overheadPrice)<0){
                    $('.proposal_service_overhead_price').css('color','red');
                }else{
                    $('.proposal_service_overhead_price').css('color','#444444');
                }

                if(parseInt(data.breakdown.profitPrice)<0){
                    $('.proposal_service_profit_price').css('color','red');
                }else{
                    $('.proposal_service_profit_price').css('color','#444444');
                }

                $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                //get_all_line_item_data();
                //save_service_estimate_total_price(data.total_price);
                var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
                unsaved = false;
                unsaved_row = false;
                if(data.estimate.completed==0){
                    $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                }else{
                    $('#service_'+proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                    if(check_est_completed){
                        $('.item_summary_btn').show();
                        temp_count = temp_count-1;
                        if(temp_count==0){
                            $('.show_pending_est_msg').hide();
                            $('.welcome_msg').hide();
                            $('.show_complete_est_msg').show();
                        }else{

                            $('.show_pending_est_msg').text('You have '+temp_count+' additional services that you need to Estimate');
                            $('.show_pending_est_msg').show();
                            $('.welcome_msg').hide();
                            $('.show_complete_est_msg').hide();
                        }
                    }
                }
                if(data.estimate.child_has_updated_flag==0 ){
                    $('.service_child_has_updated_flag_'+proposal_service_id).hide();
                    $('#service_'+proposal_service_id+' .toggle').addClass('text-active-color').removeClass('text-active-color2');
                    $('#service_'+proposal_service_id+' .toggle').css('background-color','#aeaeae');
                }

                $('.service_total_'+proposal_service_id).val(data.estimate.service_price);


                if(has_custom_equipement_total_price_update){
                    update_custom_equipement_itam_total(data.lineItemId);

                }else{
                    get_service_item_list_by_phase_id();
                    get_proposal_breakdown();
                    swal('Estimate Saved','');
                }
                
                get_child_items_list(perent_item_id,false,true);
                $('.if_item_saved').show();
                child_save_done =true;
                $("#equipement_model").dialog('close');
                $('#estimateLineItemTable').DataTable().ajax.reload();
                
            },
            error: function( jqXhr, textStatus, errorThrown ){
                swal("Error", "An error occurred Please try again");
                console.log( errorThrown );
            }
        })
}

$(document).on("click",".save_equipement_estimation",async function(e) {   

    $(".save_equipement_estimation").addClass('ui-state-disabled');
    $(".save_equipement_estimation").attr('disabled',true);
    var estimate_line_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
    var unit_type_id = $('#'+item_line_id).find('.open_calculator').attr('data-unit-type-id');
    var days =  $('.equipement_time_type_input').val();
   
    if(!estimate_line_id){
        if(unit_type_id==time_type_id){
        var parent_days =  $('#time_type_input').val();
        if(days != parent_days){

            swal({
                    title: "Warning",
                    text: "The <strong>Days</strong> value you entered does not match the days value of related items. <br /><br />Continue?",
                    showCancelButton: true,
                    confirmButtonText: 'Save Item',
                    cancelButtonText: "Cancel",
                    dangerMode: false,
                }).then(function(isConfirm) {
                    if (isConfirm) {
                        after_days_check_save_equipement_estimation();
                    } else {
                        return false;
                    }
                });
            }else{
                after_days_check_save_equipement_estimation();
            }
        }else{
                after_days_check_save_equipement_estimation();
            }
    }else{

                $.ajax({
                            url: '/ajax/check_child_parent_days_quantity/',
                            type: 'post',
                            data: {
                                'child_line_id':child_lineItemId,
                                'estimate_line_id':estimate_line_id,
                                'days':days,
                                
                            },
                            success: function(data){
                                data = JSON.parse(data);
                                if(data.success==0){
                                    swal({
                                        title: "Warning",
                                        text: "The <strong>Days</strong> value you entered does not match the days value of related items. <br /><br />Continue?",
                                        showCancelButton: true,
                                        confirmButtonText: 'Save Item',
                                        cancelButtonText: "Cancel",
                                        dangerMode: false,
                                    }).then(function(isConfirm) {
                                        if (isConfirm) {
                                            after_days_check_save_equipement_estimation();
                                        } else {
                                            return false;
                                        }
                                    });
                                }else{
                                    after_days_check_save_equipement_estimation();
                                }
                            },
                            error: function( jqXhr, textStatus, errorThrown ){
                                swal("Error", "An error occurred Please try again");
                                console.log( errorThrown );
                                
                            }
                        })
                    
    }
  
       
   });

function after_days_check_save_equipement_estimation(){
    swal({
            title: 'Saving..',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timer: 2000,
            onOpen: () => {
            swal.showLoading();
            }
        });
       var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
       var fields = [];
    //$('.save_estimation').show();   
    if(calculator_form_id=='asphalt_form'){
        var service_box_id = '#service_html_box3';
    }else if(calculator_form_id=='concrete_form'){
        var service_box_id = '#service_html_box4';
    } else if(calculator_form_id=='sealcoating_form'){
        var service_box_id = '#service_html_box5';
    }else if(calculator_form_id=='striping_form'){
        var service_box_id = '#service_html_box6';
    }else if(calculator_form_id=='crack_sealer_form'){
        var service_box_id = '#service_html_box7';
    }
       

       $(service_box_id).find('li').each(function(i,li){
                            $(li).find('.field_input').val();
                            var li_id = $(li).find('.field_input').attr('id');
                            if(li_id){
                                var li_id = li_id.replace(new RegExp("^" + 'input_'), '');
                                var field_new_value = $(li).find('.field_input').val()
                                fields.push({
                                    'fieldId':li_id,
                                    'fieldValue':field_new_value,
                                    
                                });
                            }
                            var field_id =$(li).data('field-id');
                if($("li[data-field-id='"+field_id+"']" ).find('.field_input').prop('type') == 'text' ) 
                {
                    $("li[data-field-id='"+field_id+"']" ).find('.field_input').attr('value',field_new_value);
                }else{
                    $("li[data-field-id='"+field_id+"']" ).find('.field_input option').removeAttr('selected').filter('[value="'+field_new_value+'"]').attr('selected', true)
                }          
                
                
                $("li[data-field-id='"+field_id+"']" ).find('.show_input_span').text(field_new_value);
                           
        });
      total_price = cleanNumber($('#'+calculator_form_id).find('.cal_total_price').text());
        //total_price = calTotalPrice;
        var form_data = $("#"+calculator_form_id).serializeArray();
        for($i=0;$i<form_data.length;$i++){
       
            var $form = $("#"+calculator_form_id);
                                
            var $field = $form.find('[name=' + form_data[$i].name + ']');
            if($field.attr('data-field-code')){
            form_data[$i].field_code = $field.attr('data-field-code');
            }
        
        }
        var lineItems =[];

       item_id = $('#'+item_line_id).find('.open_calculator').data('item-id');
       var template = $('#'+item_line_id).find('.open_calculator').data('templates');
        if(template){
            var template_type_id = $('.select_template_option').val();
        
        }else{
            var template_type_id = $('#'+item_line_id).find('.open_calculator').data('template-type-id');
        }
        if(!template_type_id){
            template_type_id = '0';
        }
       var original_unit_price = $('#'+item_line_id).find('.open_calculator').data('item-unit-price');
       var estimate_line_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
 
       if(parseFloat(item_price) == parseFloat(original_unit_price) ){
           var customUnitPrice =0;
       }else{
           var customUnitPrice =1;
       }
       //if(item_quantity>0 && total_price>0){


           lineItems.push({
               'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
               'customUnitPrice':customUnitPrice,
               'proposalServiceId':proposal_service_id,
               'id':estimate_line_id,
               'itemId':item_id,
               'PhaseId':phase_id,
               'quantity':item_quantity,
               'unitPrice':item_price,
               'totalPrice':total_price,
               'overHeadRate':overheadRate,
               'profitRate':profitRate,
               'overHeadPrice':overheadPrice,
               'profitPrice':profitPrice,
               'basePrice':item_base_price,
               'taxRate':taxRate,
               'taxPrice':taxPrice,
               'truckingOverHeadRate': cal_trucking_oh,
               'truckingProfitRate': cal_trucking_pm,
               'truckingOverHeadPrice': cal_trucking_oh_Price,
               'truckingProfitPrice': cal_trucking_pm_Price,
               'truckingTotalPrice': cal_trucking_total_Price,
               'sub_id':'0', 
               'template_type_id':template_type_id,
               'edited_unit_price':edited_unit_price,
                'edited_base_price':edited_base_price,
                'edited_total_price':edited_total_price,
           });

      // }
       // }

//})
//})

       $.ajax({
           url: '/ajax/saveEstimatorValues/',
           type: 'post',
           data: {
               'lineItems':lineItems,
               'proposalServiceId':proposal_service_id,
               'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
               'apply':0,
               'values':form_data,
               'itemId':item_id,
               'PhaseId':phase_id,
               'calculator_name':calculator_form_id,
               'calculation_id':estimate_calculator_id,
               'fields':fields
           },
           success: function(data){
                        try{
                                data = JSON.parse(data);
                            } catch (e) {
                                swal("Error", "An error occurred Please try again");
                                return false;
                            }
               if(calculator_form_id=='sealcoating_form'){
                    if(estimate_line_id){
                        deleteOldSealcoatChildItem(data.lineItemId);
                        //sealcoatchilditemadd(data.lineItemId);
                    }else{
                        sealcoatchilditemadd(data.lineItemId);
                    }
                    
                }
               save_equipement_estimation(data.lineItemId)
           },
           error: function( jqXhr, textStatus, errorThrown ){
                swal("Error", "An error occurred Please try again");
                console.log( errorThrown );
            }
       })
}

   function sep_trucking_start_add_search() {
       
        Microsoft.Maps.loadModule('Microsoft.Maps.AutoSuggest', {
            callback: function () {
                var manager = new Microsoft.Maps.AutosuggestManager({
                    placeSuggestions: true
                });
                manager.attachAutosuggest('#sep_trucking_start_searchBox', '#searchBoxContainer1',sep_start_suggestionSelected);
            },
            errorCallback: function(msg){
                alert(msg);
            }
        });
    }

    function sep_trucking_end_add_search() {
        Microsoft.Maps.loadModule('Microsoft.Maps.AutoSuggest', {
            callback: function () {
                var manager = new Microsoft.Maps.AutosuggestManager({
                    placeSuggestions: true,
                    useMapView:true,
                });
                manager.attachAutosuggest('#sep_trucking_end_searchBox', '#searchBoxContainer2',sep_end_suggestionSelected);
            },
            errorCallback: function(msg){
                alert(msg);
            }
        });
    }

    function child_trucking_start_add_search() {
        Microsoft.Maps.loadModule('Microsoft.Maps.AutoSuggest', {
            callback: function () {
                var manager = new Microsoft.Maps.AutosuggestManager({
                    placeSuggestions: true
                });
                manager.attachAutosuggest('#child_trucking_start_searchBox', '#searchBoxContainer3',child_start_suggestionSelected);
            },
            errorCallback: function(msg){
                alert(msg);
            }
        });
    }

    function child_trucking_end_add_search() {
        Microsoft.Maps.loadModule('Microsoft.Maps.AutoSuggest', {
            callback: function () {
                var manager = new Microsoft.Maps.AutosuggestManager({
                    placeSuggestions: true,
                    useMapView:true,
                });
                manager.attachAutosuggest('#child_trucking_end_searchBox', '#searchBoxContainer4',child_end_suggestionSelected);
            },
            errorCallback: function(msg){
                alert(msg);
            }
        });
    }

    function sep_end_suggestionSelected(result) {
       sep_destLat =result.location.latitude;
       sep_destLng =result.location.longitude;
       $('#sep_trucking_end_lat').val(sep_destLat);
       $('#sep_trucking_end_long').val(sep_destLng);
       if(sep_startLat && sep_startLng){
        $('.sep_show_map').show();
        sep_calculateRoute()
       }
    }

    function sep_start_suggestionSelected(result) {
        sep_startLat =result.location.latitude;
        sep_startLng =result.location.longitude;
        $('#sep_trucking_start_lat').val(sep_startLat);
        $('#sep_trucking_start_long').val(sep_startLng);
        if(sep_destLat && sep_destLng){
        $('.sep_show_map').show();
        sep_calculateRoute()
       }
    }
    function child_end_suggestionSelected(result) {
        child_destLat =result.location.latitude;
        child_destLng =result.location.longitude;
        $('#trucking_end_lat').val(child_destLat);
        $('#trucking_end_long').val(child_destLng);
        
       if(child_startLat && child_startLng){
        $('.show_map').show();
        child_calculateRoute()
       }
    }

    function child_start_suggestionSelected(result) {
        child_startLat =result.location.latitude;
        child_startLng =result.location.longitude;
        $('#trucking_start_lat').val(child_startLat);
        $('#trucking_start_long').val(child_startLng);
        if(child_destLat && child_destLng){
        $('.show_map').show();
        child_calculateRoute()
       }
    }
    $(document).on('click',".sep_show_map",function() {
        //$("#map_model").dialog('open');
        $('.sep_printoutpanel').show();
        $('.sep_divMap').show();
        
        //$('.sep_close_map').show();
        $('.save_estimation').hide();
        $('.trucking_box').hide();
        startLat = $(this).closest('.content-box').find(".sep_plantSelect").find(":selected").attr('data-lat')
        startLng = $(this).closest('.content-box').find(".sep_plantSelect").find(":selected").attr('data-lng');
        sep_destLat = $('#sep_trucking_end_lat').val();
        sep_destLng  = $('#sep_trucking_end_long').val();
        sep_startLat = $('#sep_trucking_start_lat').val();
        sep_startLng =$('#sep_trucking_start_long').val();
        sep_GetMap();
            
    })
    function sep_GetMap() {
        
    map = new Microsoft.Maps.Map('#sep_divMap', {
        credentials: bmKey,
        center: new Microsoft.Maps.Location(sep_startLat,sep_startLng),
        showDashboard: false,
        zoom: 12
    });
    Microsoft.Maps.loadModule('Microsoft.Maps.Directions', function () {
                   
                    directionsManager = new Microsoft.Maps.Directions.DirectionsManager(map);
                    directionsManager.setRenderOptions({
               
               waypointPushpinOptions: {
                       title: ''
                   },
               itineraryContainer: '#sep_printoutPanel'
           });
                    directionsManager.setRequestOptions({
                        routeMode: Microsoft.Maps.Directions.RouteMode.truck,
                        vehicleSpec: {
                            dimensionUnit: 'ft',
                            weightUnit: 'lb',
                            vehicleLength: 50,
                            vehicleWeight: 40000,
                            
                        }
                    });
                //Create waypoints to route between.
                
                var seattleWaypoint = new Microsoft.Maps.Directions.Waypoint({  location: new Microsoft.Maps.Location(sep_startLat,sep_startLng) });
                directionsManager.addWaypoint(seattleWaypoint);

                //var workWaypoint = new Microsoft.Maps.Directions.Waypoint({ address: des_position, location: new Microsoft.Maps.Location(destLat,destLng) });
                var workWaypoint = new Microsoft.Maps.Directions.Waypoint({ location: new Microsoft.Maps.Location(sep_destLat,sep_destLng) });
                directionsManager.addWaypoint(workWaypoint);
                
                //directionsManager.setRenderOptions({ itineraryContainer: '#printoutPanel' });
                //Calculate directions.
                map.center=new Microsoft.Maps.Location(sep_startLat,sep_startLng);
                directionsManager.calculateDirections();
               
           
                });
                
    sep_resize();
}
function sep_resize() {
    var mapDiv = document.getElementById("sep_divMap");
    mapDiv.style.height = "500px";
}

function sep_calculateRoute() {
    // if(!sep_destLat || !sep_startLng){
    //     swal('','Job Site could not be mapped. Please enter trip time manually');
    //     return false;
    // }
$('.cssloader').show();
var postData = {
    "waypoints": [{
        "latitude" : sep_startLat,
        "longitude": sep_startLng
    },{
        "latitude": sep_destLat,
        "longitude": sep_destLng
    }],
    "vehicleSpec": {
        "vehicleWeight": 40000,
        "weightUnit": "lb",
        "vehicleLength": 50,
        "dimensionUnit": "ft"
    },
    "routeAttributes": 'routePath',
};

$.ajax({
        type: "post",
        url: "https://dev.virtualearth.net/REST/v1/Routes/Truck?key=AvhgGCWtyecSauMJHutkPO3pTSrfaj3OPNn5U7qsmHD_tZbgOq_47YDjpR7d1DcN",
        data: JSON.stringify(postData),
        success: function( data ) {
            var distance = data.resourceSets[0].resources[0].travelDistance;
        
            var duration = (data.resourceSets[0].resources[0].travelDuration / 60);

            $('#trucking_form').find(".sep_trip_miles").val(distance.toFixed(2));
        
            $(".sep_trip_time").val((5 * Math.ceil(duration / 5)));
            $(".sep_trip_time").removeClass('error');
            calculate_trucking_round_time();
            $('.cssloader').hide();
        },
        error: function(data){
                swal('','error occurred. Please enter trip time manually');
                $('#trucking_form').find(".sep_trip_miles").val('');
        
                $('#trucking_form').find(".sep_trip_time").val(0);
                $('.cssloader').hide();
        }
    })

}


function child_calculateRoute() {
    $('.cssloader').show();
var postData = {
    "waypoints": [{
        "latitude" : child_startLat,
        "longitude": child_startLng
    },{
        "latitude": child_destLat,
        "longitude": child_destLng
    }],
    "vehicleSpec": {
        "vehicleWeight": 40000,
        "weightUnit": "lb",
        "vehicleLength": 50,
        "dimensionUnit": "ft"
    },
    "routeAttributes": 'routePath',
};

    $.ajax({
        type: "post",
        url: "https://dev.virtualearth.net/REST/v1/Routes/Truck?key=AvhgGCWtyecSauMJHutkPO3pTSrfaj3OPNn5U7qsmHD_tZbgOq_47YDjpR7d1DcN",
        data: JSON.stringify(postData)
    })
    .done(function( data ) {
        var distance = data.resourceSets[0].resources[0].travelDistance;
        
        var duration = (data.resourceSets[0].resources[0].travelDuration / 60);
        
        $('#map_model').find(".trip_miles").val(distance.toFixed(2));

        $('#map_model').find(".trip_time").val((15 * Math.ceil(duration / 15)));
        $('#map_model').find(".trip_time").removeClass('error');
        calculate_measurement();
            $('.cssloader').hide();
    }).fail(function(data){
        $('.cssloader').hide();
    });

}

$(document).on('click',".estimate_item_notes",function() {
    $('#inline_work_order_note').prop("checked",true);
    $.uniform.update()
    $("#estimate_item_notes_model").dialog('open');
    est_item_id_for_notes = $(this).closest('tr').find('.open_calculator').attr('data-estimate-line-id');
   
    if(est_item_id_for_notes){
         est_item_id_for_notes = est_item_id_for_notes;
    }else{
        if(typeof item_line_id == 'undefined'){
            est_item_id_for_notes = $(this).closest('tr').find('.edit_custom_item').attr('data-estimate-line-id');
            if(!est_item_id_for_notes){
                 est_item_id_for_notes = $(this).closest('tr').find('.edit_sub_con_item').attr('data-estimate-line-id');
            }
        }else{
            est_item_id_for_notes = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
        }
         
    }
    var estimateId = <?php echo $proposal->getProposalId(); ?>;
    $('#estimate_item_notes_model').find('#estimateId').val(estimateId);
    $('#estimate_item_notes_model').find('#estimateItemId').val(est_item_id_for_notes);
    //account/estimate_item_notes/estimate_line_item/195803/43
    var frameUrl = '<?php echo site_url('account/estimate_item_notes/estimate_line_item/') ?>/' + estimateId+'/'+est_item_id_for_notes;
        $("#estimateItemNotesFrame").attr('src', frameUrl);
});

$(document).on('click',".estimate_child_item_notes",function() {
    $('#inline_work_order_note').prop("checked",true);
    $.uniform.update()
  $("#estimate_item_notes_model").dialog('open');
    est_item_id_for_notes = $(this).attr('data-child-line-id');
    
    var estimateId = <?php echo $proposal->getProposalId(); ?>;
    $('#estimate_item_notes_model').find('#estimateId').val(estimateId);
    $('#estimate_item_notes_model').find('#estimateItemId').val(est_item_id_for_notes);
    //account/estimate_item_notes/estimate_line_item/195803/43
    var frameUrl = '<?php echo site_url('account/estimate_item_notes/estimate_line_item/') ?>/' + estimateId+'/'+est_item_id_for_notes;
        $("#estimateItemNotesFrame").attr('src', frameUrl);
});

// $(document).on('click',".estimate_child_item_notes",function() {
//     $(".estimate_child_item_notes_text").val('');
//     $("#estimate_child_item_notes_model").dialog('open');
//      est_item_id_for_notes = $(this).attr('data-child-line-id');
//     $.ajax({
//             url: '/ajax/loadEstimateLineItemNotes/'+est_item_id_for_notes,
//             type: 'get',
            
//             success: function(data){
//                 data = JSON.parse(data);
//                 $(".estimate_child_item_notes_text").val(data.notes);
//             }
//         });
// });

$(document).on('click',".estimate_child_item_notes_btn",function() {
    var item_note_text = $(".estimate_child_item_notes_text").val();
        $.ajax({
            url: '/ajax/saveEstimateLineItemNotes/'+est_item_id_for_notes,
            type: 'post',
            data: {
                'estimateNotes': item_note_text,
                
            },
            success: function(data){
                $("#estimate_child_item_notes_model").dialog('close');
                swal(
                        'Item note saved',
                        ''
                    );
            }
        });
})

$(document).on('click',".estimate_item_notes_btn",function() {
    var item_note_text = $(".estimate_item_notes_text").val();
        $.ajax({
            url: '/ajax/saveEstimateLineItemNotes/'+est_item_id_for_notes,
            type: 'post',
            data: {
                'estimateNotes': item_note_text,
                
            },
            success: function(data){
                $("#estimate_item_notes_model").dialog('close');
                swal(
                        'Item note saved',
                        ''
                    );
            }
        });
})

$(document).on('keyup',".input140", function (e) {
    
    if (e.keyCode == 13) {
        var temp_phase_id = $(this).closest('span').find('.update_phase_btn').attr('data-phase-id');
var phasename = $(this).closest('li').find('.edit_phase_input_field_'+temp_phase_id).val();

$.ajax({
           url: '/ajax/editEstimatingPhase/',
           type: 'post',
           data: {
               'phaseId':temp_phase_id,
               'phaseName':phasename,
               
           },
           success: function(data){
               data = JSON.parse(data);
              
           },
           error: function( jqXhr, textStatus, errorThrown ){
               console.log( errorThrown );
           }
       })
       
       $('.phase_name_'+temp_phase_id).text(phasename);
       $(this).closest('li').find('.edit_phase_inputs').css('display','none');
       $(this).closest('li').find('.show_phase_name').css('display','flex');
    }
});

$(document).on('keyup',".add_phase_input_field", function (e) {
    
    if (e.keyCode == 13) {
        var phaseName = $(this).closest('li').find('.add_phase_input_field').val();
    //alert(phaseName);return false;
    $.ajax({
           url: '/ajax/addEstimatingPhase/',
           type: 'post',
           data: {
               'phaseName':phaseName,
               'proposalServiceId':proposal_service_id,
               'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
           },
           success: function(data){
               data = JSON.parse(data);
               $('.add_phase_input_field').val('');
               $('.add_phase_input_li').hide();
               
               
                var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
                
                if(data.estimate==0){
                    $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                    temp_count = temp_count+1;
                    $('.show_pending_est_msg').text('You have '+temp_count+' additional services that you need to Estimate');
                }else{
                    $('#service_'+proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                    temp_count = temp_count-1;
                    $('.show_pending_est_msg').text('You have '+temp_count+' additional services that you need to Estimate');
                    
                }
                get_proposal_service_phases();

            },
           error: function( jqXhr, textStatus, errorThrown ){
               console.log( errorThrown );
           }
       })
    }
});

$(document).on('keyup',"#concrete_measurement,#concrete_depth", function (e) {
    custom_price_total = false;
    calculate_concrete_measurement();
    unsave_cal=true;
});

function calculate_concrete_measurement(is_edit_load=false){
        var measuremnt = cleanNumber($("#concrete_measurement").val());
        var depth = cleanNumber($("#concrete_depth").val());

        var temp_item_price = $('#'+item_line_id).find('.open_calculator').data('item-base-price');
       

        calculateData = $("#concrete_form").closest('form').serializeArray();
        if(measuremnt && measuremnt>0 && depth && depth>0){
            depth = depth/12;
            var cubic_feet = depth*measuremnt;
            item_quantity = number_test(cubic_feet*0.037);
            $('#concrete_area').text(addCommas(item_quantity));
            overheadRate = cleanNumber($("#concrete_measurement").closest('form').find('.cal_overhead').val());
            profitRate = cleanNumber($("#concrete_measurement").closest('form').find('.cal_profit').val());
            console.log('check227');
            updateItemPrices(overheadRate,profitRate);
            var disposalLoad  = 0;
            if(is_edit_load == false){
                var disposalLoad  = Math.ceil(item_quantity/5);
                $('.cal_disposal_input').val(disposalLoad);
            }else{
                var disposalLoad = cleanNumber($('.cal_disposal_input').val());
            }

            var temp_total = item_quantity * item_price;
            
            taxRate = cleanNumber($("#concrete_measurement").closest('form').find('.cal_tax').val());
            var temptaxPrice = ((calTotalPrice * taxRate) / 100);
            $("#concrete_measurement").closest('form').find('.cal_tax_amount').text('$'+addCommas(number_test(temptaxPrice)));
            var disposalTotal = 0;
                         // var temp_total = parseFloat(temp_total) + parseFloat(temptaxPrice);
            if($('.cal_disposal_checkbox').prop("checked")){
                var perLoad = cleanNumber($('.cal_disposal_per_load_input').val());
                
                if(disposalLoad > 0 && perLoad > 0){
                   var disposalTotal = perLoad*disposalLoad;
                }
                //var disposalTotal = cleanNumber($('.cal_total_disposal_amount').html());
                
                if(!disposalTotal){
                    var disposalTotal = 0;
                }
            } else {
                var disposalTotal = 0;
            }
            console.log(disposalTotal);
            $('.cal_total_disposal_amount').html(addCommas(number_test(disposalTotal)));
            var temp_total = parseFloat(temp_total) + parseFloat(temptaxPrice) + parseFloat(disposalTotal);
           
            
            calTotalPrice = temp_total;
            if(custom_price_total){
                calTotalPrice = saved_custom_price;
            }
            $("#concrete_measurement").closest('form').find('.cal_total_price').text(addCommas(number_test(calTotalPrice)));
            var tamp_cost_per_unit = parseFloat(calTotalPrice / measuremnt);
            $("#concrete_measurement").closest('form').find('.cost_per_unit').text(addCommas(number_test(tamp_cost_per_unit)));
            if($(".if_child_parent_total").is(":visible")){ 
                var temp_estimate_line_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
                get_child_items_list(temp_estimate_line_id,false,true);
            }
            
            $("#continue2").removeClass('ui-state-disabled');
            $("#continue2").attr('disabled',false);
            if(!$(".cancel_edit_item_unit_price").is(":visible")){
                $('.save_estimation').show();
            }
        }else{
            
            $('#concrete_area').text('0');
            $("#continue2").addClass('ui-state-disabled');
            $("#continue2").attr('disabled',true);
        }
        
        
        if(savedData){
            var check = compareSavedValue(savedData,calculateData);
        }else{
            check =false; 
        }
        
        if(check){
            
           if(custom_price_total || saved_custom_price==0){
           
                $('.if_item_saved').show();
                $('.save_estimation').hide(); 
                unsave_cal=false; 
            }else{
                $('.if_item_saved').hide();
                $('.save_estimation').show();
                $('.item_total_edit_icon').show();
                unsave_cal=true;
            }         
        }else{
            $('.if_item_saved').hide();
            
            if(!$(".cancel_edit_item_unit_price").is(":visible")){
                $('.save_estimation').show();
                $('.item_total_edit_icon').show();
            }
            unsave_cal=true;
        }
        child_save_done =false;
    }

$(document).on('keyup',"#sealcoating_material_quantity", function (e) {
    custom_price_total=false;
    sealcoating_material_measurement();
    unsave_cal=true;
});

function sealcoating_material_measurement(){
        var temp_quantity = cleanNumber($("#sealcoating_material_quantity").val());
        //var temp_item_price = $('#'+item_line_id).find('.open_calculator').data('item-unit-price');
        calculateData = $("#sealcoating_material_form").closest('form').serializeArray();
        var temp_item_price = item_price;
        console.log(item_price);
        if(temp_quantity && temp_quantity>0 ){
            
            item_quantity = temp_quantity;
            $('#sealcoating_material_total_quantity').text(addCommas(item_quantity));
            var temp_total = item_quantity * temp_item_price;
            taxRate = cleanNumber($("#sealcoating_material_quantity").closest('form').find('.cal_tax').val());
            var temptaxPrice = ((temp_total * taxRate) / 100);
            $("#sealcoating_material_quantity").closest('form').find('.cal_tax_amount').text('$'+addCommas(number_test(temptaxPrice)));
            taxPrice = temptaxPrice;
            var temp_total = parseFloat(temp_total) + parseFloat(temptaxPrice);
            overheadRate = cleanNumber($("#sealcoating_material_quantity").closest('form').find('.cal_overhead').val());
            profitRate = cleanNumber($("#sealcoating_material_quantity").closest('form').find('.cal_profit').val());
            var tempoverheadPrice = ((temp_item_price * overheadRate) / 100);
            var tempprofitPrice = ((temp_item_price * profitRate) / 100);
            overheadPrice = tempoverheadPrice * item_quantity;
            profitPrice = tempprofitPrice * item_quantity;
            
            //var totalPrice = parseFloat(temp_item_price) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);
            //item_price = totalPrice;
            //$('#'+item_line_id).find('.span_unit_price1').text('$'+addCommas(number_test(item_price)));
            $(".cal_overhead_price").text('$'+addCommas(number_test(overheadPrice)));
            $(".cal_profit_price").text('$'+addCommas(number_test(profitPrice)));
            console.log('check226');
            updateItemPrices(overheadRate,profitRate);
           // $(".cal_unit_price").text(addCommas(number_test(item_price)));
            calTotalPrice = parseFloat(temp_total) + parseFloat(overheadPrice)+ parseFloat(profitPrice);
            if(custom_price_total){
                    calTotalPrice = saved_custom_price;
                }
            $("#sealcoating_material_quantity").closest('form').find('.cal_total_price').text(addCommas(number_test(calTotalPrice)));
            var tamp_cost_per_unit = parseFloat(calTotalPrice / temp_quantity);
            $("#sealcoating_material_quantity").closest('form').find('.cost_per_unit').text(addCommas(number_test(tamp_cost_per_unit)));
            if($(".if_child_parent_total").is(":visible")){ 
                var temp_estimate_line_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
                get_child_items_list(temp_estimate_line_id,false,true);
            }
            
            $("#continue2").removeClass('ui-state-disabled');
            $("#continue2").attr('disabled',false);
            
            $('.save_estimation').show();
            
        }else{
            
            $('#sealcoating_material_total_quantity').text(0);
            $('.cal_total_price').text(0);
            $("#continue2").addClass('ui-state-disabled');
            $("#continue2").attr('disabled',true);
        }
        // if(clicked_open_calulator){
        //     $('.if_item_saved').show();
        //     $('.save_estimation').hide();
        //     clicked_open_calulator=false;
        // }else{
        //     $('.if_item_saved').hide();
        // }
        if(savedData){
            var check = compareSavedValue(savedData,calculateData);
        }else{
            check =false; 
        }
        
        if(check){
            if(custom_price_total || saved_custom_price==0){
               
                $('.if_item_saved').show();
                $('.save_estimation').hide(); 
                unsave_cal=false; 
            }else{
                $('.if_item_saved').hide();
                $('.save_estimation').show();
                $('.item_total_edit_icon').show();
                unsave_cal=true;
            }
                    
        }else{
            $('.if_item_saved').hide();
            $('.save_estimation').show();
            $('.item_total_edit_icon').show();
            unsave_cal=true;
        }
        
        child_save_done =false;
       
}
$(document).on("focus",".round_off_field",function(e) {
   if($(this).val()=='0'){
    $(this).val('');
   }
});

$("#add-note22").submit(function () {

    var inline_work_order_note = 0;
    if($('#inline_work_order_note').prop("checked")){
        inline_work_order_note = 1;
    }else{
        inline_work_order_note = 0;
    }
        var request = $.ajax({
            url: '<?php echo site_url('ajax/addEstimateItemNote') ?>',
            type: "POST",
            data: {
                "noteText": $("#estimateItemNoteText").val(),
                "noteType": 'estimate_line_item',
                "estimateId": $("#estimateId").val(),
                "eatimateItemId": $("#estimateItemId").val(),
                "inline_work_order_note":inline_work_order_note
            },
            dataType: "json",
            success: function (data) {
                if (data.success) {
                    //refresh frame
                    $("#estimateItemNoteText").val('');
                    $('#estimateItemNotesFrame').attr('src', $('#estimateItemNotesFrame').attr('src'));
                    get_service_item_list_by_phase_id();
                    get_proposal_breakdown();
                    //update_proposal_overhead_profit();
                } else {
                    if (data.error) {
                        alert("Error: " + data.error);
                    } else {
                        alert('An error has occurred. Please try again later!')
                    }
                }
            }
        });
        return false;
    });

    function get_summary_data_by_phase_id(){
        $.ajax({
                    type:"POST",
                    url:"<?php echo site_url('ajax/phaseEstimateItems') ?>/"+proposal_service_id+'/'+phase_id,
                    data:[],
                }).success(function(data) {
                   
                    if($(data).find('table').length >0){
                        $("#serviceItemsSummaryContent").html(data);
                    }else{
                        $("#serviceItemsSummaryContent").html('<p class="adminInfoMessage templateInfoMsg" style="display: block;"><i class="fa fa-fw fa-info-circle"></i> No items added to estimate for this phase.</p>');
                    }
                       
                });
    }
    
    $(document).on("keyup",".proposal_service_profit,.proposal_service_overhead",function() {
    $('#service_'+proposal_service_id).find('.reset_overhead_profit_rate').show();
    $('#service_'+proposal_service_id).find('.save_adjust_profit_overhead_btn').show();
    unsaved_row = true;
        update_proposal_overhead_profit();
    })
function update_proposal_overhead_profit(){
    
    var proposal_service_profit = cleanNumber($('#service_'+proposal_service_id).find('.proposal_service_profit').val());
    var proposal_service_overhead = cleanNumber($('#service_'+proposal_service_id).find('.proposal_service_overhead').val());
    
    $.ajax({
                    type:"POST",
                    url:"<?php echo site_url('ajax/updatePriceInfo') ?>/"+proposal_service_id,
                    data:{		
                        'ohRate':proposal_service_overhead,
                        'pmRate':proposal_service_profit,			
                    },
                }).success(function(data) {
                    data = JSON.parse(data);
                    
                    //console.log(data.estimate.service_price);
                    $('.service_total_'+proposal_service_id).val(data.totalPrice); 
                    //$('.service_total_'+proposal_service_id).val(parseFloat(data.totalPrice).toFixed(2)); 
                    $('.proposal_service_profit_price').text('$'+data.pmAmount);
                    $('.proposal_service_overhead_price').text('$'+data.ohAmount);
                    $('.proposal_service_tax_price').text('$'+data.taxAmount);
                   
                    if(parseInt(data.ohAmount)<0){
                        $('.proposal_service_overhead_price').css('color','red');
                    }else{
                        $('.proposal_service_overhead_price').css('color','#444444');
                    }

                    if(parseInt(data.pmAmount)<0){
                        $('.proposal_service_profit_price').css('color','red');
                    }else{
                        $('.proposal_service_profit_price').css('color','#444444');
                    }
                });
        

}
    $(document).on('click',".proposal_service_estimate_price_check",function() {

    if($(this).find('i').hasClass('fa-chevron-down')){
        $(this).closest('ul').find('.show_proposal_overhead_and_profit').show();
        $(this).find('i').addClass('fa-chevron-up').removeClass('fa-chevron-down');
        //$('.labor_cal_tax_amount_row').show();
    }else{
        if(unsaved_row){
    
            swal(
                '',
                'Price change unsaved. Please save or revert.'
            );

        }else{
                $(this).closest('ul').find('.show_proposal_overhead_and_profit').hide();
                $(this).find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
        }
       // unsaved_row = false;
    }
    })


    jQuery(document).ready(function(){
    // This button will increment the value
    $('[data-quantity="plus"]').click(function(e){
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('data-field');
        // Get its current value
        var currentVal = parseFloat($('#service_'+proposal_service_id).find('input[name='+fieldName+']').val());
        // If is not undefined
        if (!isNaN(currentVal)) {
            // Increment
           $('input[name='+fieldName+']').val(parseFloat(currentVal + 0.10).toFixed(2));
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
        $('#service_'+proposal_service_id).find('.reset_overhead_profit_rate').show();
        $('#service_'+proposal_service_id).find('.save_adjust_profit_overhead_btn').show();
        unsaved_row = true;
        update_proposal_overhead_profit()
    });
    // This button will decrement the value till 0
    $('[data-quantity="minus"]').click(function(e) {
        // Stop acting like a button
        e.preventDefault();
        // Get the field name
        fieldName = $(this).attr('data-field');
        // Get its current value
        var currentVal = parseFloat($('#service_'+proposal_service_id).find('input[name='+fieldName+']').val());
        // If it isn't undefined or its greater than 0
        if (!isNaN(currentVal) && currentVal > 0) {
            // Decrement one
            $('input[name='+fieldName+']').val(parseFloat(currentVal - 0.10).toFixed(2));
        } else {
            // Otherwise put a 0 there
            $('input[name='+fieldName+']').val(0);
        }
        $('#service_'+proposal_service_id).find('.reset_overhead_profit_rate').show();
        $('#service_'+proposal_service_id).find('.save_adjust_profit_overhead_btn').show();
        unsaved_row = true;
        update_proposal_overhead_profit()
    });
});

function get_proposal_breakdown(){
    

    $.ajax({		
                    url: '/ajax/estimateBreakdown/<?php echo $proposal->getProposalId(); ?>',		
                    type: 'get',			
                    success: function( data){		
                        data = JSON.parse(data);	
                            $('.final_table_proposal_cost').text(data.basePrice);
                            $('.final_table_proposal_profit_percent').text(data.profitMargin);
                            $('.final_table_proposal_profit_amount').text(data.profitPrice);
                            $('.final_table_proposal_overhead_percent').text(data.overheadMargin);
                            $('.final_table_proposal_overhead_amount').text(data.overheadPrice);
                            $('.final_table_proposal_total_price').text(data.totalPrice);
                            $('.final_table_proposal_total_tax').text(data.taxPrice);
                            //check_item_summary_btn();
                            
                            if(parseFloat(data.profitMargin)<0){
                                $('.final_table_proposal_profit_percent').css('color','red');
                                $('.final_table_proposal_profit_amount').css('color','red');
                            }else{
                                $('.final_table_proposal_profit_percent').css('color','#444444');
                                $('.final_table_proposal_profit_amount').css('color','#444444');
                            }

                            if(parseFloat(data.overheadMargin)<0){
                                $('.final_table_proposal_overhead_percent').css('color','red');
                                $('.final_table_proposal_overhead_amount').css('color','red');
                            }else{
                                $('.final_table_proposal_overhead_percent').css('color','#444444');
                                $('.final_table_proposal_overhead_amount').css('color','#444444');
                            }

                            if(parseInt(data.item_count)>0){
                                $('.show_item_summary_btn').show();
                            }else{
                                $('.show_item_summary_btn').hide()
                            }
                            check_service_complate_count();
                    }
                });



    get_piechart_data();
    
}

function get_piechart_data(){
   
    $.ajax({		
        url: '/ajax/getPieChartData/<?php echo $proposal->getProposalId(); ?>',		
        type: 'get',			
        success: function( data){
            var test_array =[['title','List'] ];	
            data = JSON.parse(data);
            if(data.length>0){
                $('#piechart').show();
                for($i=0;$i<data.length;$i++){
                
                    test_array.push([data[$i]['name'],parseFloat(data[$i]['value']) ]);
                }
           
                drawChart(test_array);
            }else{
                $('#piechart').hide();
            }
            
        }   
    });
}



function drawChart(chart_data) {

    var data = google.visualization.arrayToDataTable(chart_data);

        var options = {
                    width: 200,
                    height: 200,
                    chartArea: {
                        width: '100%',
                        height: '90%'
                    },
                    sliceVisibilityThreshold: 0,
                    pieSliceText: 'none',
                    pieHole: 0.3,
                    legend: {
                        position: 'none',
                        maxLines: 2,
                        alignment: 'left'
                    },
                    pieSliceText: 'label',
                    animation: {
                        startup: true
                    }
                };
var formatter = new google.visualization.NumberFormat(
                    {prefix: '$', pattern: '#,###,###'});
                formatter.format(data, 1);
        var chart = new google.visualization.PieChart(document.getElementById('piechart'));

        chart.draw(data, options);
        
}

$(document).on('click',".save_adjust_profit_overhead_btn",function() {
    swal({
        title: 'Saving..',
        allowEscapeKey: false,
        allowOutsideClick: false,
        timer: 2000,
        onOpen: () => {
            swal.showLoading();
        }
    });
    var proposal_service_profit = cleanNumber($('#service_'+proposal_service_id).find('.proposal_service_profit').val());
    var proposal_service_overhead = cleanNumber($('#service_'+proposal_service_id).find('.proposal_service_overhead').val());
    var proposal_service_new_price = $('.service_total_'+proposal_service_id).val();
    var proposal_id = $('#ProposalId').val();
    service_profit_rate = proposal_service_profit;
    service_overhead_rate =proposal_service_overhead;
    $('#service_'+proposal_service_id).find('.reset_overhead_profit_rate').hide();
    $('#service_'+proposal_service_id).find('.save_adjust_profit_overhead_btn').hide();
    unsaved_row = false;
    $.ajax({
                type:"POST",
                url:"<?php echo site_url('ajax/saveUpdatedPrice') ?>/"+proposal_service_id,
                data:{		
                    'ohRate':proposal_service_overhead,
                    'pmRate':proposal_service_profit,
                    'NewPrice':proposal_service_new_price,
                    'proposal_id':proposal_id
                                },
                dataType:'json',
            }).success(function(data) {
               if(!data.error){
                swal('Estimate Updated');
                calculate_unit_price();
                get_service_item_list_by_phase_id();
                get_proposal_breakdown()
                get_summary_data_by_phase_id();

               }
                
            });

})

$(document).on('click',".show_service_spec_check",function() {

if($(this).find('i').hasClass('fa-chevron-down')){
    $(this).closest('ul').find('.service_specifications').slideDown(200);
    $(this).find('i').addClass('fa-chevron-up').removeClass('fa-chevron-down');
   
}else{
    $(this).closest('ul').find('.service_specifications').slideUp(200);
    $(this).find('i').addClass('fa-chevron-down').removeClass('fa-chevron-up');
    
}
})



$(document).on('click',".reset_overhead_profit_rate",function() {
    $('#service_'+proposal_service_id).find('.proposal_service_profit').val(service_profit_rate);
    $('#service_'+proposal_service_id).find('.proposal_service_overhead').val(service_overhead_rate);
    get_service_total();
    //update_proposal_overhead_profit();
    $('#service_'+proposal_service_id).find('.reset_overhead_profit_rate').hide();
    $('#service_'+proposal_service_id).find('.save_adjust_profit_overhead_btn').hide();
    unsaved_row = false;
})

$(document).on('click',".delete_phase_all_items",function() {
$this = this;
swal({
                title: "Are you sure?",
                text: "Item will be permanently deleted",
                showCancelButton: true,
                confirmButtonText: 'Delete Item',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    swal({
                        title: 'Saving..',
                        allowEscapeKey: false,
                        allowOutsideClick: false,
                        timer: 2000,
                        onOpen: () => {
                        swal.showLoading();
                        }
                    });
                    $.ajax({
                        url: '/ajax/deletePhaseAllItems',
                        type: "POST",
                        data: {
                            
                            "proposalServiceId": proposal_service_id,
                            'phase_id':phase_id,
                        },

                        success: function( data){
                            data = JSON.parse(data);
                            var items = data.items;
                            
                            if(data.estimation==0){
                                $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                            }else{
                                $('#service_'+proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                            }
                            if(data.estimate.child_has_updated_flag==0 ){
                                $('.service_child_has_updated_flag_'+proposal_service_id).hide();
                                $('#service_'+proposal_service_id+' .toggle').addClass('text-active-color').removeClass('text-active-color2');
                                $('#service_'+proposal_service_id+' .toggle').css('background-color','#aeaeae');
                            }
                            $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                        $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                        
                        $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                        $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));
                        
                        if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }

                        $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                            $('#ids_'+phase_id).find('.phase_checked').addClass('phase_checked_hide');
                            $($this).closest('li').find('.edit_phase_inputs').css('display','none');
                            $($this).closest('li').find('.show_phase_name').css('display','flex');
                            for($i=0;$i<items.length;$i++){
                                var item_id = items[$i].item_id;
                                $('#items_'+item_id).find('.deleteLineItem').data('estimate-line-id','');
                                $('#items_'+item_id).find('.open_calculator').data('estimate-line-id','');

                                var unit_price = $('#items_'+item_id).find(".open_calculator").data('item-unit-price');

                               
                                $('#items_'+item_id).find(".total-price").text('$0');
                                $('#items_'+item_id).find(".quantity").text('0');
                                $('#items_'+item_id).find(".unit-price").val(unit_price);
                                
                                $('#items_'+item_id).find(".span_unit_price1").text('$'+addCommas(number_test(unit_price)));
                                $('#items_'+item_id).removeClass('has_item_value');
                                //$('#items_'+item_id).find('.deleteLineItem').hide();
                                //$('#items_'+item_id).find('.items_checkbox').hide();
                                $('#items_'+item_id).find('.items_checkbox div span').removeClass('checked');
                                $('#items_checkbox_'+item_id).attr('checked',false);

                            }
                            calculate_unit_price();
                            get_service_item_list_by_phase_id();
                            get_sub_contractors_items();
                            get_proposal_breakdown();
                            get_summary_data_by_phase_id()
                            //check_all_default_saved_template_items();
                            $('.delete_template_items').hide();
                            //update_proposal_overhead_profit();
                            swal(
                                'Phase Items Deleted',
                                ''
                            );
                            
                            check_tr_has_class();
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            console.log( errorThrown );
                        }
                    })

                    

                } else {
                    swal("Cancelled", "Your Estimation is safe :)", "error");
                }
            });
})


function sealcoatchilditemadd(perent_item_id){
        

        ////////////////////////////////////////////////////////////////
        
            var sealcoat_child_item_unit_price = $('.additive_sealer_item').find(':selected').data('unit-price');
            var sealcoat_child_item_unit_base_price = $('.additive_sealer_item').find(':selected').data('unit-base-price');
            var sealcoat_child_item_id = cleanNumber($('.additive_sealer_item').val());
            var sealcoat_child_item_quantity = cleanNumber($('#sealcoatAdditiveTotal').text());
            var sealcoat_child_item_overhead = cleanNumber($('#sealcoating_form').find('.cal_overhead').val());
            var sealcoat_child_item_profit = cleanNumber($('#sealcoating_form').find('.cal_profit').val());
            var sealcoat_child_tax_rate = 0;
            var sealcoat_child_tax_amount = 0;
            //var custom_child_item_name = $('#custom_child_item_name').val();
            //var custom_child_item_notes = $('#custom_child_item_notes').val();
            // var tempoverheadPrice = ((sealcoat_child_item_unit_price * sealcoat_child_item_overhead) / 100);
            // var tempprofitPrice = ((sealcoat_child_item_unit_price * sealcoat_child_item_profit) / 100);
            // var sealcoat_child_item_unit_price_text = parseFloat(sealcoat_child_item_unit_price) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);
                
            //     tempoverheadPrice = tempoverheadPrice * sealcoat_child_item_quantity;
            //     tempprofitPrice = tempprofitPrice * sealcoat_child_item_quantity;
            // var sealcoat_child_total = (parseFloat(sealcoat_child_item_unit_price).toFixed(2)) * sealcoat_child_item_quantity;
            if(oh_pm_type){
               
               var tempoverheadPrice = ((sealcoat_child_item_unit_base_price * sealcoat_child_item_overhead) / 100);
           var tempprofitPrice = ((sealcoat_child_item_unit_base_price * sealcoat_child_item_profit) / 100);
           var sealcoat_child_item_unit_price_text = parseFloat(sealcoat_child_item_unit_base_price) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);

           }else{
               var sealcoat_child_item_unit_price_text = sealcoat_child_item_unit_price;
           }
                
           // var totalPrice = parseFloat(sealcoat_child_total) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice)+ parseFloat(sealcoat_child_tax_amount);
           var totalPrice =(parseFloat(sealcoat_child_item_unit_price_text).toFixed(2))*sealcoat_child_item_quantity;
            var lineItems =[];
            lineItems.push({
                        'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                        'customUnitPrice':0,
                        'proposalServiceId':proposal_service_id,
                        'parentId':perent_item_id,
                        'id':'',
                        'itemId':sealcoat_child_item_id,
                        'PhaseId':phase_id,
                        'quantity':sealcoat_child_item_quantity,
                        'unitPrice':sealcoat_child_item_unit_price_text,
                        'totalPrice':totalPrice,
                        'overHeadRate':sealcoat_child_item_overhead,
                        'profitRate':sealcoat_child_item_profit,
                        'overHeadPrice':tempoverheadPrice,
                        'profitPrice':tempprofitPrice,
                        'basePrice':sealcoat_child_item_unit_price,
                        'taxRate':sealcoat_child_tax_rate,
                        'taxPrice':sealcoat_child_tax_amount,
                        'truckingOverHeadRate': 0,
                        'truckingProfitRate': 0,
                        'truckingOverHeadPrice': 0,
                        'truckingProfitPrice': 0,
                        'truckingTotalPrice': 0,
                        'customName':'',
                        'notes':'',
                        'child_material': 1,
                        'sub_id':'0',
                    });
                    $.ajax({
                    url: '/ajax/saveEstimateLineItems/',
                    type: 'post',
                    async: false,
                    data: {
                        'lineItems':lineItems,
                        'proposalServiceId':proposal_service_id,
                        'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                        'PhaseId':phase_id,
                        'apply':0,
                    },
                    success: function(data){
                        
                    }
                    });
                    //////////////////////////////////////////////////////////


            var sealcoat_child_item_unit_price = $('.sand_sealer_item').find(':selected').data('unit-price');
            var sealcoat_child_item_unit_base_price = $('.sand_sealer_item').find(':selected').data('unit-base-price');
            var sealcoat_child_item_id = cleanNumber($('.sand_sealer_item').val());
            var sealcoat_child_item_quantity = cleanNumber($('#sealcoatSandTotal').text());
            var sealcoat_child_item_overhead = cleanNumber($('#sealcoating_form').find('.cal_overhead').val());
            var sealcoat_child_item_profit = cleanNumber($('#sealcoating_form').find('.cal_profit').val());
            var sealcoat_child_tax_rate = 0;
            var sealcoat_child_tax_amount = 0;
            
            if(oh_pm_type){
               
               var tempoverheadPrice = ((sealcoat_child_item_unit_base_price * sealcoat_child_item_overhead) / 100);
           var tempprofitPrice = ((sealcoat_child_item_unit_base_price * sealcoat_child_item_profit) / 100);
           var sealcoat_child_item_unit_price_text = parseFloat(sealcoat_child_item_unit_base_price) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);

           }else{
               var sealcoat_child_item_unit_price_text = sealcoat_child_item_unit_price;
           }
           
            var totalPrice =(parseFloat(sealcoat_child_item_unit_price_text).toFixed(2))*sealcoat_child_item_quantity;
            var lineItems =[];
            lineItems.push({
                        'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                        'customUnitPrice':0,
                        'proposalServiceId':proposal_service_id,
                        'parentId':perent_item_id,
                        'id':'',
                        'itemId':sealcoat_child_item_id,
                        'PhaseId':phase_id,
                        'quantity':sealcoat_child_item_quantity,
                        'unitPrice':sealcoat_child_item_unit_price_text,
                        'totalPrice':totalPrice,
                        'overHeadRate':sealcoat_child_item_overhead,
                        'profitRate':sealcoat_child_item_profit,
                        'overHeadPrice':tempoverheadPrice,
                        'profitPrice':tempprofitPrice,
                        'basePrice':sealcoat_child_item_unit_price,
                        'taxRate':sealcoat_child_tax_rate,
                        'taxPrice':sealcoat_child_tax_amount,
                        'truckingOverHeadRate': 0,
                        'truckingProfitRate': 0,
                        'truckingOverHeadPrice': 0,
                        'truckingProfitPrice': 0,
                        'truckingTotalPrice': 0,
                        'customName':'',
                        'notes':'',
                        'child_material': 1,
                        'sub_id':'0',
                    });
                    $.ajax({
                    url: '/ajax/saveEstimateLineItems/',
                    type: 'post',
                    async:false,
                    data: {
                        'lineItems':lineItems,
                        'proposalServiceId':proposal_service_id,
                        'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                        'PhaseId':phase_id,
                        'apply':0,
                    },
                    success: function(data){
                        get_service_item_list_by_phase_id();
                        console.log('update_item');
                    }
                    });
        
        
        }
function deleteOldSealcoatChildItem(perent_item_id){
    $.ajax({
                    url: '/ajax/clearsealcoatdefualtchild/'+perent_item_id,
                    type: 'get',
                    async: false,
                    success: function(data){
                        sealcoatchilditemadd(perent_item_id);
                    }
                    });
}

function complete_estimation(){

    swal({
                title: "Are you sure?",
                text: "",
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    location.href = "/ajax/complete_estimation/<?php echo $proposal->getProposalId(); ?>";
                } else {
                    swal("Cancelled", "", "error");
                   
                }
            });
    // $.ajax({
    //                 url: '/ajax/complete_estimation/<?php echo $proposal->getProposalId(); ?>',
    //                 type: 'get',
                    
    //                 success: function(data){
    //                     location.href = "/proposals";
    //                 }
    //                 });
}

function lock_estimation(){
    swal({
                title: "Are you sure?",
                text: "",
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    location.href = "/ajax/lock_estimation/<?php echo $proposal->getProposalId(); ?>";
                } else {
                    swal("Cancelled", "", "error");
                   
                }
            });
    
}
function unlock_estimation(){
     swal({
                title: "Are you sure?",
                text: "",
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    location.href = "/ajax/unlock_estimation/<?php echo $proposal->getProposalId(); ?>";
                } else {
                    swal("Cancelled", "", "error");
                   
                }
            });
}

function reset_estimation(){
     swal({
                title: "Are you sure?",
                text: "",
                showCancelButton: true,
                confirmButtonText: 'Save',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    location.href = "/ajax/reset_estimation/<?php echo $proposal->getProposalId(); ?>";
                } else {
                    swal("Cancelled", "", "error");
                   
                }
            });
}
function hide_all_accordion(){
    $('.accordionContainer h3').each(function (index, value) {
                   var type_id = $(this).data('type-id');
                    var numItems = $('#itemsType'+type_id+' .has_item_value').length
                    
                    if (numItems>0) {
                        $(this).show();
                        //$(this).next(".ui-accordion-content").show();
                    } else {
                        $(this).hide();
                        $(this).next(".ui-accordion-content").hide();
                    }


                });
}

function check_logout_session(){
    $.ajax({
            url: '/ajax/check_logout_session/',
            type: 'get',
            success: function(data){
                if(data==0){
                    swal(
                        '',
                        'Session timeout, Please login again..'
                    );
                    setTimeout(function() {
                        location.href = "/account/logout";
                        
                    }, 250);
                }
            },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                }
    })
}


$(document).on("click",".save_fees_child_estimation",async function(e) { 
    $(".save_fees_child_estimation").addClass('ui-state-disabled');
    $(".save_fees_child_estimation").attr('disabled',true);   
    swal({
        title: 'Saving..',
        allowEscapeKey: false,
        allowOutsideClick: false,
        timer: 2000,
        onOpen: () => {
        swal.showLoading();
        }
    });
       var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
       var fields = [];
       
    //$('.save_estimation').show();    
    if(calculator_form_id=='asphalt_form'){
        var service_box_id = '#service_html_box3';
    }else if(calculator_form_id=='concrete_form'){
        var service_box_id = '#service_html_box4';
    } else if(calculator_form_id=='sealcoating_form'){
        var service_box_id = '#service_html_box5';
    }else if(calculator_form_id=='striping_form'){
        var service_box_id = '#service_html_box6';
    }else if(calculator_form_id=='crack_sealer_form'){
        var service_box_id = '#service_html_box7';
    }
       

       $(service_box_id).find('li').each(function(i,li){
                            $(li).find('.field_input').val();
                            var li_id = $(li).find('.field_input').attr('id');
                            if(li_id){
                                var li_id = li_id.replace(new RegExp("^" + 'input_'), '');
                                var field_new_value = $(li).find('.field_input').val()
                                fields.push({
                                    'fieldId':li_id,
                                    'fieldValue':field_new_value,
                                    
                                });
                            }
                            var field_id =$(li).data('field-id');
                if($("li[data-field-id='"+field_id+"']" ).find('.field_input').prop('type') == 'text' ) 
                {
                    $("li[data-field-id='"+field_id+"']" ).find('.field_input').attr('value',field_new_value);
                }else{
                    $("li[data-field-id='"+field_id+"']" ).find('.field_input option').removeAttr('selected').filter('[value="'+field_new_value+'"]').attr('selected', true)
                }          
                
                
                $("li[data-field-id='"+field_id+"']" ).find('.show_input_span').text(field_new_value);
                           
        });
      total_price = cleanNumber($('#'+calculator_form_id).find('.cal_total_price').text());
        //total_price = calTotalPrice;
        var form_data = $("#"+calculator_form_id).serializeArray();
        for($i=0;$i<form_data.length;$i++){
       
            var $form = $("#"+calculator_form_id);
                                
            var $field = $form.find('[name=' + form_data[$i].name + ']');
            if($field.attr('data-field-code')){
            form_data[$i].field_code = $field.attr('data-field-code');
            }
        
        }
        var lineItems =[];

       item_id = $('#'+item_line_id).find('.open_calculator').data('item-id');
       var template = $('#'+item_line_id).find('.open_calculator').data('templates');
        if(template){
            var template_type_id = $('.select_template_option').val();
        
        }else{
            var template_type_id = $('#'+item_line_id).find('.open_calculator').data('template-type-id');
        }
        if(!template_type_id){
            template_type_id = '0';
        }
       var original_unit_price = $('#'+item_line_id).find('.open_calculator').data('item-unit-price');
       var estimate_line_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
 
       if(parseFloat(item_price) == parseFloat(original_unit_price) ){
           var customUnitPrice =0;
       }else{
           var customUnitPrice =1;
       }
      // if(item_quantity>0 && total_price>0){


           lineItems.push({
               'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
               'customUnitPrice':customUnitPrice,
               'proposalServiceId':proposal_service_id,
               'id':estimate_line_id,
               'itemId':item_id,
               'PhaseId':phase_id,
               'quantity':item_quantity,
               'unitPrice':item_price,
               'totalPrice':total_price,
               'overHeadRate':overheadRate,
               'profitRate':profitRate,
               'overHeadPrice':overheadPrice,
               'profitPrice':profitPrice,
               'basePrice':item_base_price,
               'taxRate':taxRate,
               'taxPrice':taxPrice,
               'truckingOverHeadRate': cal_trucking_oh,
               'truckingProfitRate': cal_trucking_pm,
               'truckingOverHeadPrice': cal_trucking_oh_Price,
               'truckingProfitPrice': cal_trucking_pm_Price,
               'truckingTotalPrice': cal_trucking_total_Price,
               'sub_id':'0', 
               'template_type_id':template_type_id,
               'edited_unit_price':edited_unit_price,
                'edited_base_price':edited_base_price,
                'edited_total_price':edited_total_price,
           });

       //}
       // }

//})
//})

       $.ajax({
           url: '/ajax/saveEstimatorValues/',
           type: 'post',
           data: {
               'lineItems':lineItems,
               'proposalServiceId':proposal_service_id,
               'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
               'apply':0,
               'values':form_data,
               'itemId':item_id,
               'PhaseId':phase_id,
               'calculator_name':calculator_form_id,
               'calculation_id':estimate_calculator_id,
               'fields':fields
           },
           success: function(data){
                    try{
                        data = JSON.parse(data);
                    } catch (e) {
                        swal("Error", "An error occurred Please try again1");
                        return false;
                    }
               if(calculator_form_id=='sealcoating_form'){
                    if(estimate_line_id){
                        deleteOldSealcoatChildItem(data.lineItemId);
                        //sealcoatchilditemadd(data.lineItemId);
                    }else{
                        sealcoatchilditemadd(data.lineItemId);
                    }
                    
                }
               save_fees_child_estimation(data.lineItemId,data.calId)
           },
           error: function( jqXhr, textStatus, errorThrown ){
                swal("Error", "An error occurred Please try again2");
                console.log( errorThrown );
            }
       })
   });


   function save_fees_child_estimation(perent_item_id,calId){

       var child_fees_work_order = 0;
       if($('#child_fees_work_order').prop("checked")){
           child_fees_work_order = 1;
       }else{
           child_fees_work_order = 0;
       }
var fees_child_item_unit_price = cleanNumber($('#fees_child_item_unit_price').val());
    var fees_child_item_quantity = cleanNumber($('#fees_child_item_quantity').val());
    var fees_child_item_overhead = cleanNumber($('.fees_child_item_overhead').val());
    var fees_child_item_profit = cleanNumber($('.fees_child_item_profit').val());
    var fees_child_tax_rate = cleanNumber($('.fees_child_tax_rate').val());
    var fees_child_tax_amount = cleanNumber($('.fees_child_tax_amount').text());
    var fees_child_item_name = $('#fees_child_item_name').val();
    var fees_child_item_notes = $('#fees_child_item_notes').val();
    if($('#is_fees_type').val()==1){
        var is_fees = 1;
        var is_permit = 0;
    }else{
        var is_fees = 0;
        var is_permit = 1;
    }
    var tempoverheadPrice = ((fees_child_item_unit_price * fees_child_item_overhead) / 100);
    var tempprofitPrice = ((fees_child_item_unit_price * fees_child_item_profit) / 100);
    var fees_child_item_unit_price_text = parseFloat(fees_child_item_unit_price) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);
        $('.fees_child_item_unit_price_text').text('$'+addCommas(number_test(fees_child_item_unit_price_text)));
        tempoverheadPrice = tempoverheadPrice * fees_child_item_quantity;
        tempprofitPrice = tempprofitPrice * fees_child_item_quantity;
    var fees_child_total = fees_child_item_unit_price * fees_child_item_quantity;
        
    var totalPrice = parseFloat(fees_child_total) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice)+ parseFloat(fees_child_tax_amount);

    var lineItems =[];
    lineItems.push({
                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                'customUnitPrice':0,
                'proposalServiceId':proposal_service_id,
                'parentId':perent_item_id,
                'id':child_lineItemId,
                'itemId':0,
                'PhaseId':phase_id,
                'quantity':fees_child_item_quantity,
                'unitPrice':fees_child_item_unit_price_text,
                'totalPrice':totalPrice,
                'overHeadRate':fees_child_item_overhead,
                'profitRate':fees_child_item_profit,
                'overHeadPrice':tempoverheadPrice,
                'profitPrice':tempprofitPrice,
                'basePrice':fees_child_item_unit_price,
                'taxRate':fees_child_tax_rate,
                'taxPrice':fees_child_tax_amount,
                'truckingOverHeadRate': 0,
                'truckingProfitRate': 0,
                'truckingOverHeadPrice': 0,
                'truckingProfitPrice': 0,
                'truckingTotalPrice': 0,
                'customName':fees_child_item_name,
                'notes':fees_child_item_notes,
                'sub_id':'0',
                'child_material':'0',
                'fees':is_fees,
                'permit':is_permit,
                'work_order':child_fees_work_order
            });
            $.ajax({
            url: '/ajax/saveEstimateLineItems/',
            type: 'post',
            data: {
                'lineItems':lineItems,
                'proposalServiceId':proposal_service_id,
                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
                'PhaseId':phase_id,
                'apply':0,
            },
            success: function(data){
                try{
                    data = JSON.parse(data);
                } catch (e) {
                    swal("Error", "An error occurred Please try again");
                    return false;
                }
                unsave_cal=false;
                
                unsave_cal=false;  
                estimate_calculator_id =calId;
                
                //update_proposal_overhead_profit();
                
                var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
                unsaved = false;
                unsaved_row = false;
                if(data.estimate.completed==0){
                    $('#service_'+proposal_service_id+' a .est_checked').addClass('est_checked_hide');
                }else{
                    $('#service_'+proposal_service_id+' a .est_checked').removeClass('est_checked_hide');
                }
                $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
               
                $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                swal(
                    'Item Saved',
                    ''
                );

                if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                if(data.estimate.child_has_updated_flag==0 ){
                    $('.service_child_has_updated_flag_'+proposal_service_id).hide();
                    $('#service_'+proposal_service_id+' .toggle').addClass('text-active-color').removeClass('text-active-color2');
                    $('#service_'+proposal_service_id+' .toggle').css('background-color','#aeaeae');
                    $('#service_'+proposal_service_id+' .toggle').css('background-color','#aeaeae');
                }
                $('.service_total_'+proposal_service_id).val(data.estimate.service_price);

                if(has_custom_fees_total_price_update){
                    update_custom_fees_itam_total(data.lineItemId,perent_item_id);

                }else{
                    get_service_item_list_by_phase_id();
                    get_proposal_breakdown();
                    swal('Estimate Saved','');
                }
                get_child_items_list(perent_item_id,false,true);
                
                $('.if_item_saved').show();
                child_save_done =true;
                $("#add_fees_child_item_model").dialog('close');
                $('#estimateLineItemTable').DataTable().ajax.reload();
            },
            error: function( jqXhr, textStatus, errorThrown ){
                swal("Error", "An error occurred Please try again");
                console.log( errorThrown );
            }
            });
          
}

$(document).on("click",".remove_template_item_line",function() {
        var line_item_id = $(this).closest('tr').find(".open_calculator").attr('data-estimate-line-id');
        $this = $(this);


        swal({
                title: "Are you sure?",
                text: "Item will be remove from template",
                showCancelButton: true,
                confirmButtonText: 'Remove Item',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
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
                    $this.closest('tr').removeClass('has_item_value');
        $.ajax({
            url: '/ajax/remove_item_from_template_estimate/'+line_item_id,
            type: 'get',

            success: function(data){
                data = JSON.parse(data);
                
                revert_adjust_price1();
                //get_service_item_list();
                get_service_item_list_by_phase_id();
                get_proposal_breakdown();
                //update_proposal_overhead_profit();
                revert_adjust_price();
                swal(
                        'Item Removed',
                        ''
                    );
                            
                },
                error: function( jqXhr, textStatus, errorThrown ){
                    swal("Error", "An error occurred Please try again");
                    console.log( errorThrown );
                }
        });

                } else {
                    swal("Cancelled", "Your Item is safe :)", "error");
                }
            });

});

$(document).on("click",".select_template_show_btn",function() {
 $(this).closest('div').find('.select_template_show').show();
});

function check_default_saved_template_items(template_id){
    $table = $('#template_itemsType'+template_id);
    
    var saved_count = $table.find('.has_item_value').length;
    
    if(saved_count>0){
        $($table).addClass('has_template_saved_items');
    }else{
        $($table).removeClass('has_template_saved_items');
        //$(".check_save_template_items").hide();
    }
}

function check_all_default_saved_template_items(){
    $('.templateItemsTable').each(function (index, table) {

        var table_id = $(table).attr('id');
        var template_id = $(table).attr('data-template-id');
        $table = $('#'+table_id);
            var saved_count = $table.find('.has_item_value').length;
            
            if(saved_count>0){
                $($table).addClass('has_template_saved_items');
                $($table).closest('div').find('.templateInfoMsg').show();
               // $('.next_estimate_items').hide();
                $('#templateHeading'+template_id).find('.next_estimate_items').hide();
                $('#templateHeading'+template_id).find('.edit_estimate_items_price').css('display','');
                $('#templateHeading'+template_id).find('.edit_template_total_price').css('display','');
                $('#templateHeading'+template_id).find('.delete_template_items').css('display','');
                
                
            }else{
                
                $($table).removeClass('has_template_saved_items');
                $($table).closest('div').find('.templateInfoMsg').hide();
                $('#templateHeading'+template_id+'.ui-accordion-header-active').find('.next_estimate_items').css('display','');
                $('#templateHeading'+template_id+'.ui-accordion-header-active').find('.edit_estimate_items_price').hide();
                $('#templateHeading'+template_id+'.ui-accordion-header-active').find('.edit_template_total_price').hide();
                $('#templateHeading'+template_id+'.ui-accordion-header-active').find('.delete_template_items').hide();
                //$(".check_save_template_items").hide();
            }

   
    });
    
}

////////////////////////////////////////////

$(document).on("focusin","#measurement,#sealcoatArea,#concrete_measurement",function() {
    $(".service_specifications").removeClass('orange');
    $(".service_specifications[data-measurement-field='1']").addClass('orange');
});

$(document).on("focusin","#depth",function() {

    $(".service_specifications").removeClass('orange');
    if(head_type_id == gravel_type_id){
        $(".service_specifications[data-gravel-depth-field='1']").addClass('orange');
    }else if(head_type_id == base_asphalt_type_id){
        $(".service_specifications[data-base-depth-field='1']").addClass('orange');
    }else if(head_type_id == excavation_type_id ){
        $(".service_specifications[data-excavation-depth-field='1']").addClass('orange');
    }else{
        $(".service_specifications[data-depth-field='1']").addClass('orange');
    }
});

$(document).on("focusin","#concrete_depth",function() {
    $(".service_specifications").removeClass('orange');
    $(".service_specifications[data-excavation-depth-field='1']").addClass('orange');  
});

$(document).on("focusin",".measurement_unit,#sealcoatUnit",function() {
    $(".service_specifications").removeClass('orange');
    $(".service_specifications[data-unit-field='1']").addClass('orange');
});
$(document).on("focusin","#crackseakLength,#stripingFeet",function() {
    $(".service_specifications").removeClass('orange');
    $(".service_specifications[data-measurement-field='1']").addClass('orange');
});


function validateSpecValues(calcInput, selector, saveButtonClick) {

    var theInput = calcInput;
    var thisVal = theInput.val();
    var mappedInput = $(selector + ":visible").find('.field_input');
    var mappedVal = $(mappedInput).val();

    // Check to see if mapped value is the same or not
    if (mappedVal) {
        if (thisVal != mappedVal) {

            // Popup
            swal({
                title: "",
                text: "Calculator values does not match specification values. <br />Continue?",
                showCancelButton: true,
                confirmButtonText: 'Continue',
                cancelButtonText: '<i class ="fa fa-fw fa-undo"></i> Change it Back',
                dangerMode: false,
            }).then(function(isConfirm) {
                if (saveButtonClick) {
                    // If this is true, click the submit button after
                    $('.save_estimation').trigger('click');
                }
            }).catch(function(reason) {
                $(theInput).val(mappedVal);
                $('.if_trucking_change_show_msg_parent').hide();
                $.uniform.update();
                $(theInput).focus();
            });
        }
    }
}

// Focusout event on main measurement fields
$(document).on("focusout, blur","#measurement,#sealcoatArea,#concrete_measurement",function(e) {

    // Flag for if the save button was clicked
    var saveButtonClick = e.relatedTarget.classList.contains('save_estimation');
    // Selector for this item
    var selector = ".service_specifications[data-measurement-field='1']";
    // Remove the class
    $(selector).removeClass('orange');
    // Validate Spec values
    validateSpecValues($(this), selector, saveButtonClick);
});

$(document).on("focusout, blur","#depth",function(e) {

    // Flag for if the save button was clicked
    var saveButtonClick = e.relatedTarget.classList.contains('save_estimation');
    var selector;

    if(head_type_id == gravel_type_id){
        selector = ".service_specifications[data-gravel-depth-field='1']";
    }else if(head_type_id == base_asphalt_type_id){
        selector = ".service_specifications[data-base-depth-field='1']";
    }else if(head_type_id == excavation_type_id ){
        selector = ".service_specifications[data-excavation-depth-field='1']";
    }else{
        selector = ".service_specifications[data-depth-field='1']";
    }

    $(selector).removeClass('orange');

    // Validate Spec values
    validateSpecValues($(this), selector, saveButtonClick);
});

$(document).on("focusout, blur",".measurement_unit,#sealcoatUnit",function(e) {

    // Flag for if the save button was clicked
    var saveButtonClick = e.relatedTarget.classList.contains('save_estimation');
    var selector = ".service_specifications[data-unit-field='1']";

    $(selector).removeClass('orange');

    // Validate Spec values
    validateSpecValues($(this), selector, saveButtonClick);
});

$(document).on("focusout, blur","#crackseakLength,#stripingFeet",function(e) {
    // Flag for if the save button was clicked
    var saveButtonClick = e.relatedTarget.classList.contains('save_estimation');
    var selector = ".service_specifications[data-measurement-field='1']";
    $(selector).removeClass('orange');

    // Validate Spec values
    validateSpecValues($(this), selector, saveButtonClick);
}); 

$(document).on("focusout, blur","#concrete_depth",function(e) {
    // Flag for if the save button was clicked
    var saveButtonClick = e.relatedTarget.classList.contains('save_estimation');
    var selector = ".service_specifications[data-excavation-depth-field='1']";
    $(selector).removeClass('orange');

    // Validate Spec values
    validateSpecValues($(this), selector, saveButtonClick);
});

$(document).on("click","#quantity_calculation input[type='text']:not(.percentFormat),#map_model input[type='text']:not(.percentFormat),#labor_model input[type='text']:not(.percentFormat),#equipement_model input[type='text']:not(.percentFormat),#add_custom_child_item_model input[type='text']:not(.percentFormat),#add_custom_item_model input[type='text']:not(.percentFormat),#add_fees_child_item_model input[type='text']:not(.percentFormat)",function() {
    var field_new_value = $(this).val();
    $(this).val('');
    $(this).val(field_new_value);
    $(this).select();
    $(this).get(0).setSelectionRange(0,9999);
});

$(".groupAction").click(function () {
        
        // Toggle the buttons
        $(".groupActionsContainer").toggle();
        return false;
    });

 /* Update the number of selected items */
 function updateNumSelected() {
            var num = $(".child_item_check:checked").length;

            // Hide the options if 0 selected
            if (num < 1) {
               // $("#groupActionIntro").show();
                $("#groupAction").hide();
                //$(".groupActionsContainer").hide();
            }
            else {
                //$("#groupActionIntro").hide();
                $("#groupAction").show();
            }

            //$("#numSelected").html(num);
        }

     // Update the counter after each change
     $(".child_item_check").live('change', function () {
         updateNumSelected();
        });

        
        // All
        $(".check_all_childs").live('click', function () {
            if($(this).prop("checked")===true){
               
                $(this).closest('table').find(".child_item_check").prop('checked', true);
            }else{
                
                $(this).closest('table').find(".child_item_check").prop('checked', false);
            }
           
            updateNumSelected();
            $.uniform.update();
            //return false;
        });

        $(".groupSelect").live('change', function () {
            updateNumSelected();
        });

        // Delete Click
        $('.groupDelete').click(function(){
            $("#delete-child-Items").dialog('open');
            $("#deleteNum").html($(".child_item_check:checked").length);
        });

        /* Create an array of the selected IDs */
        function getSelectedIds() {

            var IDs = new Array();

            $(".child_item_check:checked").each(function () {
                IDs.push($(this).data('child-line-id'));
            });

            return IDs;
        }

$(document).on('click','.phasesBtn',function(){
    var cat = $(this).data('val');
    var this_btn =$(this);
    if($('#Section_'+cat).length){
        var section = $('#Section_'+cat).clone();
        
        $('.phaseItemSection').removeClass('highlighted');
        $(section).addClass('highlighted');
        $('#Section_'+cat).remove();
        $(".phaseCategoryLists").prepend(section);
        $('#summaryTab').animate({scrollTop: 0}, 200);
        $('.phaseCategoryStatus').removeClass('phasesBtnActive');
        if(section.length>0){
            $(this).addClass('phasesBtnActive');
        }
    }else{

        $('.assembly_section').find("td.phase_section_item_type").each(function(index){
            if($(this).html()==cat){
                
                var section = $(this).closest('.assembly_section').clone();
        
                $('.phaseItemSection').removeClass('highlighted');
                $(section).addClass('highlighted');
                $(this).closest('.assembly_section').remove();
                $(".phaseCategoryLists").prepend(section);
                $('#summaryTab').animate({scrollTop: 0}, 200);
                $('.phaseCategoryStatus').removeClass('phasesBtnActive');
                if(section.length>0){
                    $(this_btn).addClass('phasesBtnActive');
                }
                return false;
            }
            
        })
        

    } 
    
})


function check_days_in_child_parent(){
    
    swal({
                title: "Warning",
                text: "The <strong>Days</strong> value you entered does not match the days value of related items. <br /><br />Continue?",
                showCancelButton: true,
                confirmButtonText: 'Save Item',
                cancelButtonText: "Cancel",
                dangerMode: false,
            }).then(function(isConfirm) {
                if (isConfirm) {
                    return true;
                } else {
                    return false;
                }
            });
}

function calculate_sum_defualt_sealcoat_items(){

    ////////////////////////////////////////////////////////////////
    
    var sealcoat_child_item_unit_price = $('.additive_sealer_item').find(':selected').data('unit-price');
    var sealcoat_child_item_unit_base_price = $('.additive_sealer_item').find(':selected').data('unit-base-price');
            var sealcoat_child_item_id = cleanNumber($('.additive_sealer_item').val());
            var sealcoat_child_item_quantity = cleanNumber($('#sealcoatAdditiveTotal').text());
            var sealcoat_child_item_overhead = cleanNumber($('#sealcoating_form').find('.cal_overhead').val());
            var sealcoat_child_item_profit = cleanNumber($('#sealcoating_form').find('.cal_profit').val());
            var sealcoat_child_tax_rate = 0;
            var sealcoat_child_tax_amount = 0;
          
            //var custom_child_item_name = $('#custom_child_item_name').val();
            //var custom_child_item_notes = $('#custom_child_item_notes').val();
            if(oh_pm_type){
                
                var tempoverheadPrice = ((sealcoat_child_item_unit_base_price * sealcoat_child_item_overhead) / 100);
            var tempprofitPrice = ((sealcoat_child_item_unit_base_price * sealcoat_child_item_profit) / 100);
            var sealcoat_child_item_unit_price_text = parseFloat(sealcoat_child_item_unit_base_price) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);

            }else{
                var sealcoat_child_item_unit_price_text = sealcoat_child_item_unit_price;
            }
            
            
            var totalPrice1 =(parseFloat(sealcoat_child_item_unit_price_text).toFixed(2))*sealcoat_child_item_quantity;
           
                    
            var sealcoat_child_item_unit_price = $('.sand_sealer_item').find(':selected').data('unit-price');
            var sealcoat_child_item_unit_base_price = $('.sand_sealer_item').find(':selected').data('unit-base-price');
            var sealcoat_child_item_id = cleanNumber($('.sand_sealer_item').val());
            var sealcoat_child_item_quantity = cleanNumber($('#sealcoatSandTotal').text());
            var sealcoat_child_item_overhead = cleanNumber($('#sealcoating_form').find('.cal_overhead').val());
            var sealcoat_child_item_profit = cleanNumber($('#sealcoating_form').find('.cal_profit').val());
            var sealcoat_child_tax_rate = 0;
            var sealcoat_child_tax_amount = 0;
            
            if(oh_pm_type){
               
                var tempoverheadPrice = ((sealcoat_child_item_unit_base_price * sealcoat_child_item_overhead) / 100);
            var tempprofitPrice = ((sealcoat_child_item_unit_base_price * sealcoat_child_item_profit) / 100);
            var sealcoat_child_item_unit_price_text = parseFloat(sealcoat_child_item_unit_base_price) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);

            }else{
                var sealcoat_child_item_unit_price_text = sealcoat_child_item_unit_price;
            }
            var totalPrice2 =(parseFloat(sealcoat_child_item_unit_price_text).toFixed(2))*sealcoat_child_item_quantity;
            var totalPrice = parseFloat(totalPrice1) + parseFloat(totalPrice2);
            
            return totalPrice;
}
function initTipTip () {

$(".tiptipleft").tipTip({ defaultPosition: "left",delay: 0});

}

$( function() {
   
    $( "#item_search" ).autocomplete({
      source: function( request, response ) {
        $.ajax({
          url: "/ajax/itemSearch/",
          dataType: "json",
          type: "post",
          data: {
            'term': request.term,
            'proposal_service_id':proposal_service_id,
          },
          success: function( data ) {
            
            var show_service_array = serviceTypeAssignments[main_service];
           
                var res = $.grep(data, function(v) {
                            return show_service_array.indexOf(parseInt(v.type_id)) != -1;
                });
                           
            response( res );
          }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
        var item_id = ui.item.id;
        //var table_id =$('.open_calculator[data-item-id ='+item_id+']').closest('table').attr('id');
        
        //var tab = $('#'+table_id).parents("div").eq(2).attr("id");
        
        //temp_type_id = table_id.replace('itemsType', '');
       
        var temp_type_id = ui.item.type_id;
        var tab = 'categoryTab'+ui.item.category_id;
        if(item_id!=0){
            if(event.srcElement.className=='auto_complete_search_type'){
                $('#categoryTabs').tabs('select', tab);
                $(".accordionContainer").accordion({"active":"#typeHeading"+temp_type_id});
            }else if(event.srcElement.className=='auto_complete_search_category'){
                $('#categoryTabs').tabs('select', tab);
            }else{
                $('#categoryTabs').tabs('select', tab);
                $(".accordionContainer").accordion({"active":"#typeHeading"+temp_type_id});
                $('.open_calculator[data-item-id ='+item_id+']').closest('tr').effect( "highlight", {color:"#57cdff"}, 2500 );
            }
            
        }else{
            if(event.srcElement.className=='auto_complete_search_category'){
                $('#categoryTabs').tabs('select', tab);
            }else{
                $('#categoryTabs').tabs('select', tab);
                $(".accordionContainer").accordion({"active":"#typeHeading"+temp_type_id});

            }
        }
        
            $(this).closest('.dropdownMenuContainer').hide();
            $(this).closest('.dropdownButton').find('.dropdownToggle').removeClass('open');
            $(this).closest('.dropdownMenuContainer').removeClass('open');
            $('.item_search_btn').removeClass('currentActive');
            $('#item_search').val('');
      }
    }).data( "autocomplete" )._renderItem = function( ul, item ) {
        return $( "<li class='auto_complete_li'></li>" )
            .data( "item.autocomplete", item )
            .append( "<a class='auto_complete_a' ><strong><span class='auto_complete_search_category'>" + item.category_name + "</span> > <span class='auto_complete_search_type' data-val="+item.type_id+">"+item.type_name+"</span></strong> <br/>" + item.label + "</a>" )
            .appendTo( ul );
   };
});


 
$(document).on('click','.item_search_btn a',function(){
    
        $('#item_search').val('');
});


$(document).on('click','.item_search_close',function(){
    $(this).closest('.dropdownMenuContainer').hide();
    $(this).closest('.dropdownButton').find('.dropdownToggle').removeClass('open');
    $(this).closest('.dropdownMenuContainer').removeClass('open');
    $('.item_search_btn').removeClass('currentActive');
    $('#item_search').val('');
});

jQuery(function($) {
 
 function tog(v){return v?'addClass':'removeClass';} 
 
 $(document).on('input', '.clearable', function(){
   $(this)[tog(this.value)]('x');
 }).on('mousemove', '.x', function( e ){
   $(this)[tog(this.offsetWidth-18 < e.clientX-this.getBoundingClientRect().left)]('onX');   
 }).on('click', '.onX', function(){
    $(this).removeClass('x onX').val('');
    $('.ui-autocomplete').hide()
 });
 
});

$(document).on('change','#master_template_items_checkbox',function(){

            var masterChecked = $(this).prop('checked');
            var templateId = $(this).val();
            $(this).closest('table').find('.template_item_delete_checkbox:visible').prop('checked', masterChecked);
            $.uniform.update();

            if(masterChecked){
                $('#templateHeading'+templateId).find('.edit_estimate_items').css('display','');
                $('#templateHeading'+templateId).find('.delete_estimate_items').css('display','');
                $('#templateHeading'+templateId).find('.edit_estimate_items_price').hide();
                $('#templateHeading'+templateId).find('.edit_template_total_price').hide();
                $('#templateHeading'+templateId).find('.delete_template_items').hide();
            }else{
                $('#templateHeading'+templateId).find('.delete_estimate_items').hide();
                $('#templateHeading'+templateId).find('.edit_estimate_items').hide();
                $('#templateHeading'+templateId).find('.edit_estimate_items_price').css('display','');
                $('#templateHeading'+templateId).find('.edit_template_total_price').css('display','');
                $('#templateHeading'+templateId).find('.delete_template_items').css('display','');

            }
});


$(document).on("pagecreate","body",function(){
  $(".according-body").on("tap",function(){
    $(".service_specifications").removeClass('orange');
  });                       
});
$(document).on("change",".dump_fee_apply",function(){
    if($(this).prop("checked") == true){
        $('.if_dump_fee_apply').show();
    }
    else {
        $('.if_dump_fee_apply').hide();
        $('.dump_rate').trigger('change');
    }
    
});
function myTestFunction(e){
 
    $(".service_specifications").removeClass('orange');
  

}

function compareSavedValue(savedData,calculateData){

    if(calculateData.length ==savedData.length){
        for($i=0;$i<calculateData.length;$i++){
        var data = savedData.filter(function (data) { return data.name == calculateData[$i].name });
        
        if(data[0].value != calculateData[$i].value){
            return false;
        }
   
     }
    }else{
        return false;
    }
     
     return true;
}


$(document).on("click",".save_edit_standard_template_price",function(){
        
        swal({
            title: 'Saving..',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timer: 2000,
            onOpen: () => {
            swal.showLoading();
            }
        });
        
        var edit_template_price = $('.edit_standard_template_price').val();
        var old_edit_template_price = $('#old_edit_template_price').val();
        
        
            if(edit_template_price){
           
            var template_id =$("#edit_standard_template_price_template_id").val();
       
            $.ajax({
                    url: '/ajax/saveStandardTemplatesPrice',
                    type: "POST",
                    data: {
                        
                        "proposalServiceId": proposal_service_id,
                        'phase_id':phase_id,
                        'edit_template_price':edit_template_price,
                        'old_edit_template_price':old_edit_template_price,
                        'template_id':template_id,

                    },
                    dataType: "json",

                    success: function( data){


                        $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                        $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                        $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                        $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                        $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                        check_tr_has_class();
                        //get_service_item_list();
                        get_service_item_list_by_phase_id();
                        get_proposal_breakdown();
                        //update_proposal_overhead_profit();
                        swal(
                            'Items Updated',
                            ''
                        );
                        if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                        $('.template_item_delete_checkbox').prop('checked', false);
                        $('.master_template_items_checkbox').prop('checked', false);
                        $('#templateHeading'+template_id).find('.delete_estimate_items').hide();
                        $('#templateHeading'+template_id).find('.edit_estimate_items').hide();
                        $('#templateHeading'+template_id).find('.edit_estimate_items_price').css('display','');
                        $('#templateHeading'+template_id).find('.edit_template_total_price').css('display','');
                        $('#templateHeading'+template_id).find('.delete_template_items').css('display','');
                        $("#edit_standard_template_price_model").dialog('close');
                        $.uniform.update();
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })

        }else{
            return false
        }
        
    })

$(document).on("click",".save_edit_template_price",function(){
        
        swal({
            title: 'Saving..',
            allowEscapeKey: false,
            allowOutsideClick: false,
            timer: 2000,
            onOpen: () => {
            swal.showLoading();
            }
        });
        
        var edit_template_price = $('.edit_template_price').val();
      
        
            if(edit_template_price){
           
            var template_id =$("#edit_template_price_template_id").val();
       
            $.ajax({
                    url: '/ajax/saveTemplatesPrice',
                    type: "POST",
                    data: {
                        
                        "proposalServiceId": proposal_service_id,
                        'phase_id':phase_id,
                        'edit_template_price':edit_template_price,
                        'template_id':template_id,

                    },
                    dataType: "json",

                    success: function( data){


                        $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                        $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                        $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                        $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                        $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                        check_tr_has_class();
                        //get_service_item_list();
                        get_service_item_list_by_phase_id();
                        get_proposal_breakdown();
                        //update_proposal_overhead_profit();
                        swal(
                            'Items Updated',
                            ''
                        );
                        if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                        $('.template_item_delete_checkbox').prop('checked', false);
                        $('.master_template_items_checkbox').prop('checked', false);
                        $('#templateHeading'+template_id).find('.delete_estimate_items').hide();
                        $('#templateHeading'+template_id).find('.edit_estimate_items').hide();
                        $('#templateHeading'+template_id).find('.edit_estimate_items_price').css('display','');
                        $('#templateHeading'+template_id).find('.edit_template_total_price').css('display','');
                        $('#templateHeading'+template_id).find('.delete_template_items').css('display','');
                        $("#edit_template_price_model").dialog('close');
                        $.uniform.update();
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })

        }else{
            return false
        }
        
    })


    var temptimer = null;
$('.custom_labor_total_price_input').keydown(function(){
       clearTimeout(temptimer); 
       temptimer = setTimeout(change_custom_labor_total_price_input, 600)
});

function change_custom_labor_total_price_input(){
    
    var base_unit_price = $('.labor_item').find(':selected').data('base-unit-price');
        
    //var base_unit_price = $('#items_'+item_id).find('.open_calculator').attr('data-item-base-price');
    
    var new_total_price = $('.custom_labor_total_price_input').val();
   
    if(oh_pm_type==2){
        var cal_overhead_rate =  $('.labor_item').find(':selected').data('overhead-rate');
        var cal_profit_rate = $('.labor_item').find(':selected').data('profit-rate');
    }else{
        var cal_overhead_rate =  service_overhead_rate;
        var cal_profit_rate =  service_profit_rate;
    }

    //var cal_profit_price =cleanNumber($('#'+calculator_form_id).find('.cal_profit_price').text());
    var tax_rate =cleanNumber($('.labor_cal_tax').val());
    var temp_item_quantity =cleanNumber($('.labor_total_time_value').text());

    $.ajax({
                    url: '/ajax/checkItemCustomTotalPrice',
                    type: "POST",
                    data: {
                        "cal_overhead_rate": cal_overhead_rate,
                        "cal_profit_rate": cal_profit_rate,
                        "tax_rate": tax_rate,
                        'base_unit_price':base_unit_price,
                        'item_quantity':temp_item_quantity,
                        'total_price':new_total_price,

                    },
                    dataType: "json",

                    success: function( data){


                        if(parseFloat(data.new_oh_total)<0){
                                    var temp_overheadPrice = '-$'+addCommas(number_test(Math.abs(data.new_oh_total)));
                                    $('#time_type_form2').find('.labor_cal_overhead_price').closest('tr').css('color','red');
                                    $('#time_type_form2').find('.labor_cal_overhead').css('color','red');
                                }else{
                                    var temp_overheadPrice = '$'+addCommas(number_test(data.new_oh_total));
                                    $('#time_type_form2').find('.labor_cal_overhead_price').closest('tr').css('color','#444444');
                                    $('#time_type_form2').find('.labor_cal_overhead').css('color','#44444');
                                }

                                if(parseFloat(data.new_pm_total)<0){
                                    var temp_profitPrice = '-$'+addCommas(number_test(Math.abs(data.new_pm_total)));
                                    $('#time_type_form2').find('.labor_cal_profit_price').closest('tr').css('color','red');
                                    $('#time_type_form2').find('.labor_cal_profit').css('color','red');
                                }else{
                                    var temp_profitPrice = '$'+addCommas(number_test(data.new_pm_total));
                                    $('#time_type_form2').find('.labor_cal_profit_price').closest('tr').css('color','#444444');
                                    $('#time_type_form2').find('.labor_cal_profit').css('color','#444444');
                                }
                                
                            $('#time_type_form2').find('.labor_cal_overhead').val(data.oh_percent);
                            $('#time_type_form2').find('.labor_cal_profit').val(data.pm_percent);
                            $('#time_type_form2').find('.labor_cal_tax_amount').text('$'+addCommas(number_test(data.newTaxPrice)));
                            $('#time_type_form2').find('.labor_cal_overhead_price').text(temp_overheadPrice);
                            $('#time_type_form2').find('.labor_cal_profit_price').text(temp_profitPrice);
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })

};


$(document).on("click",".item_labor_total_edit_icon",function(){ 
    var total_price = $(this).closest('td').find('.labor_cal_total_price').text();
    $('.if_not_edit_labor_item_total_price,.save_labor_estimation,.item_labor_total_edit_icon').hide();
    $(this).closest('td').find('input').val(total_price);
    $('.custom_labor_total_price_input,.if_edit_labor_item_total_price').show();
   
});

$(document).on("click",".cancel_edit_labor_item_total",function(){ 
    $('.if_not_edit_labor_item_total_price,.save_labor_estimation,.item_labor_total_edit_icon').show();
    $('.custom_labor_total_price_input,.if_edit_labor_item_total_price').hide();
   
    var total_price = $(this).closest('td').find('.labor_cal_total_price').text();
    $(this).closest('td').find('input').val(total_price);
    change_custom_labor_total_price_input();
    
})
$(document).on("click",".update_labor_itam_total_btn",function(){
    var new_total_price = $(this).closest('td').find('input').val();
   
    has_custom_labor_total_price_update =true;
    
    $('.labor_cal_total_price').text(new_total_price.replace('$', ''));
    $('.if_not_edit_labor_item_total_price,.save_labor_estimation,.item_labor_total_edit_icon').show();
    $('.custom_labor_total_price_input,.if_edit_labor_item_total_price').hide();

});

/////////trucking edit total price/////////////////
var temptruckingtimer = null;
$('.custom_trucking_total_price_input').keydown(function(){
       clearTimeout(temptruckingtimer); 
       temptruckingtimer = setTimeout(change_custom_trucking_total_price_input, 600)
});

function change_custom_trucking_total_price_input(){
    
    var base_unit_price = $('.trucking_item').find(':selected').data('unit-price');
        
    //var base_unit_price = $('#items_'+item_id).find('.open_calculator').attr('data-item-base-price');
    
    var new_total_price = $('.custom_trucking_total_price_input').val();
   
    if(oh_pm_type==2){
        var cal_overhead_rate =  $('.trucking_item').find(':selected').data('overhead-rate');
        var cal_profit_rate = $('.trucking_item').find(':selected').data('profit-rate');
    }else{
        var cal_overhead_rate =  service_overhead_rate;
        var cal_profit_rate =  service_profit_rate;
    }
    //var cal_profit_price =cleanNumber($('#'+calculator_form_id).find('.cal_profit_price').text());
    var tax_rate =0;
    var temp_item_quantity =cleanNumber($('#map_model').find('.total_time_hours').val());

    $.ajax({
                    url: '/ajax/checkItemCustomTotalPrice',
                    type: "POST",
                    data: {
                        "cal_overhead_rate": cal_overhead_rate,
                        "cal_profit_rate": cal_profit_rate,
                        "tax_rate": tax_rate,
                        'base_unit_price':base_unit_price,
                        'item_quantity':temp_item_quantity,
                        'total_price':new_total_price,

                    },
                    dataType: "json",

                    success: function( data){


                        if(parseFloat(data.new_oh_total)<0){
                                    var temp_overheadPrice = '-$'+addCommas(number_test(Math.abs(data.new_oh_total)));
                                    $('#map_model').find('.trucking_cal_overhead_price').closest('tr').css('color','red');
                                    $('#map_model').find('.trucking_cal_overhead').css('color','red');
                                }else{
                                    var temp_overheadPrice = '$'+addCommas(number_test(data.new_oh_total));
                                    $('#map_model').find('.trucking_cal_overhead_price').closest('tr').css('color','#444444');
                                    $('#map_model').find('.trucking_cal_overhead').css('color','#44444');
                                }

                                if(parseFloat(data.new_pm_total)<0){
                                    var temp_profitPrice = '-$'+addCommas(number_test(Math.abs(data.new_pm_total)));
                                    $('#map_model').find('.trucking_cal_profit_price').closest('tr').css('color','red');
                                    $('#map_model').find('.trucking_cal_profit').css('color','red');
                                }else{
                                    var temp_profitPrice = '$'+addCommas(number_test(data.new_pm_total));
                                    $('#map_model').find('.trucking_cal_profit_price').closest('tr').css('color','#444444');
                                    $('#map_model').find('.trucking_cal_profit').css('color','#444444');
                                }
                                
                            $('#map_model').find('.trucking_cal_overhead').val(data.oh_percent);
                            $('#map_model').find('.trucking_cal_profit').val(data.pm_percent);
                            $('#map_model').find('.trucking_cal_tax_amount').text('$'+addCommas(number_test(data.newTaxPrice)));
                            $('#map_model').find('.trucking_cal_overhead_price').text(temp_overheadPrice);
                            $('#map_model').find('.trucking_cal_profit_price').text(temp_profitPrice);
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })

};


$(document).on("click",".item_trucking_total_edit_icon",function(){ 
    var total_price = $(this).closest('td').find('.cal_trucking_total_price').text();
    $('.if_not_edit_trucking_item_total_price,.save_trucking_estimation,.item_trucking_total_edit_icon').hide();
    $(this).closest('td').find('input').val(total_price);
    $('.custom_trucking_total_price_input,.if_edit_trucking_item_total_price').show();
   
});

$(document).on("click",".cancel_edit_trucking_item_total",function(){ 
    $('.if_not_edit_trucking_item_total_price,.save_trucking_estimation,.item_trucking_total_edit_icon').show();
    $('.custom_trucking_total_price_input,.if_edit_trucking_item_total_price').hide();
   
    var total_price = $(this).closest('td').find('.cal_trucking_total_price').text();
    $(this).closest('td').find('input').val(total_price);
    change_custom_trucking_total_price_input();
    
})

function revert_custom_trucking_item_total(){
    $('.if_not_edit_trucking_item_total_price,.save_trucking_estimation,.item_trucking_total_edit_icon').show();
    $('.custom_trucking_total_price_input,.if_edit_trucking_item_total_price').hide();
}
$(document).on("click",".update_trucking_itam_total_btn",function(){
    var new_total_price = addCommas(cleanNumber($(this).closest('td').find('input').val()));
   
    has_custom_trucking_total_price_update =true;
    
    $('.cal_trucking_total_price').text(new_total_price);
    $('.if_not_edit_trucking_item_total_price,.save_trucking_estimation,.item_trucking_total_edit_icon').show();
    $('.custom_trucking_total_price_input,.if_edit_trucking_item_total_price').hide();

});

//////////////////////end edit trucking total price///////////////////////


/////////custom edit total price/////////////////
var tempcustomtimer = null;
$('.custom_custom_total_price_input').keydown(function(){
       clearTimeout(tempcustomtimer); 
       tempcustomtimer = setTimeout(change_custom_custom_total_price_input, 600)
});

function change_custom_custom_total_price_input(){
    
    var base_unit_price = $('#custom_child_item_unit_price').val();
        
    //var base_unit_price = $('#items_'+item_id).find('.open_calculator').attr('data-item-base-price');
    
    var new_total_price = $('.custom_custom_total_price_input').val();
   
    if(oh_pm_type==2){
        // var cal_overhead_rate = $('.custome_child_item_overhead').val();
        // var cal_profit_rate = $('.custome_child_item_profit').val();
        cal_overhead_rate = $('.custome_child_item_overhead').attr('data-old-val');
        
            cal_profit_rate = $('.custome_child_item_profit').attr('data-old-val');
    }else{
        var cal_overhead_rate =  service_overhead_rate;
        var cal_profit_rate =  service_profit_rate;
    }
    
    //var cal_profit_price =cleanNumber($('#'+calculator_form_id).find('.cal_profit_price').text());
    var tax_rate =cleanNumber($('.custome_child_tax_rate').val());
    var temp_item_quantity =cleanNumber($('#custom_child_item_quantity').val());

    $.ajax({
                    url: '/ajax/checkItemCustomTotalPrice',
                    type: "POST",
                    data: {
                        "cal_overhead_rate": cal_overhead_rate,
                        "cal_profit_rate": cal_profit_rate,
                        "tax_rate": tax_rate,
                        'base_unit_price':base_unit_price,
                        'item_quantity':temp_item_quantity,
                        'total_price':new_total_price,

                    },
                    dataType: "json",

                    success: function( data){


                        if(parseFloat(data.new_oh_total)<0){
                                    var temp_overheadPrice = '-$'+addCommas(number_test(Math.abs(data.new_oh_total)));
                                    $('#add_custom_child_item_form').find('.custome_child_item_overhead_price').closest('tr').css('color','red');
                                    $('#add_custom_child_item_form').find('.custome_child_item_overhead').css('color','red');
                                }else{
                                    var temp_overheadPrice = '$'+addCommas(number_test(data.new_oh_total));
                                    $('#add_custom_child_item_form').find('.custome_child_item_overhead_price').closest('tr').css('color','#444444');
                                    $('#add_custom_child_item_form').find('.custome_child_item_overhead').css('color','#44444');
                                }

                                if(parseFloat(data.new_pm_total)<0){
                                    var temp_profitPrice = '-$'+addCommas(number_test(Math.abs(data.new_pm_total)));
                                    $('#add_custom_child_item_form').find('.custome_child_item_profit_price').closest('tr').css('color','red');
                                    $('#add_custom_child_item_form').find('.custome_child_item_profit').css('color','red');
                                }else{
                                    var temp_profitPrice = '$'+addCommas(number_test(data.new_pm_total));
                                    $('#add_custom_child_item_form').find('.custome_child_item_profit_price').closest('tr').css('color','#444444');
                                    $('#add_custom_child_item_form').find('.custome_child_item_profit').css('color','#444444');
                                }
                                
                            $('#add_custom_child_item_form').find('.custome_child_item_overhead').val(data.oh_percent);
                            $('#add_custom_child_item_form').find('.custome_child_item_profit').val(data.pm_percent);
                            $('#add_custom_child_item_form').find('.custome_child_tax_amount').text('$'+addCommas(number_test(data.newTaxPrice)));
                            $('#add_custom_child_item_form').find('.custome_child_item_overhead_price').text(temp_overheadPrice);
                            $('#add_custom_child_item_form').find('.custome_child_item_profit_price').text(temp_profitPrice);
                                
                            custom_child_item_overhead_profit_calculation(cleanNumber(base_unit_price),temp_item_quantity,data.oh_percent,data.pm_percent,tax_rate);
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })

};


$(document).on("click",".item_custom_total_edit_icon",function(){ 
    $('.custome_child_item_overhead').attr('data-old-val',$('.custome_child_item_overhead').val());
    $('.custome_child_item_profit').attr('data-old-val',$('.custome_child_item_profit').val());
    var total_price = $(this).closest('td').find('.custom_child_item_total_price').text();
    $('.if_not_edit_custom_item_total_price,.save_custom_estimation,.item_custom_total_edit_icon').hide();
    $(this).closest('td').find('input').val(total_price);
    $('.custom_custom_total_price_input,.if_edit_custom_item_total_price').show();
   
});

$(document).on("click",".cancel_edit_custom_item_total",function(){ 
    $('.if_not_edit_custom_item_total_price,.save_custom_estimation,.item_custom_total_edit_icon').show();
    $('.custom_custom_total_price_input,.if_edit_custom_item_total_price').hide();
   
    var total_price = $(this).closest('td').find('.custom_child_item_total_price').text();
    $(this).closest('td').find('input').val(total_price);
    change_custom_custom_total_price_input();
    
})

function revert_custom_custom_item_total(){
    $('.if_not_edit_custom_item_total_price,.save_custom_estimation,.item_custom_total_edit_icon').show();
    $('.custom_custom_total_price_input,.if_edit_custom_item_total_price').hide();
}
$(document).on("click",".update_custom_itam_total_btn",function(){
    var new_total_price = addCommas(cleanNumber($(this).closest('td').find('input').val()));
   
    has_custom_custom_total_price_update =true;
    
    $('.custom_child_item_total_price').text(new_total_price);
    $('.if_not_edit_custom_item_total_price,.save_custom_estimation,.item_custom_total_edit_icon').show();
    $('.custom_custom_total_price_input,.if_edit_custom_item_total_price').hide();

});

//////////////////////end edit custom total price///////////////////////
                                    
/////////fees edit total price/////////////////
var tempfeestimer = null;
$('.custom_fees_total_price_input').keydown(function(){
       clearTimeout(tempfeestimer); 
       tempfeestimer = setTimeout(change_custom_fees_total_price_input, 600)
});

function change_custom_fees_total_price_input(){
    
    var base_unit_price = $('#fees_child_item_unit_price').val();
        
    //var base_unit_price = $('#items_'+item_id).find('.open_calculator').attr('data-item-base-price');
    
    var new_total_price = $('.custom_fees_total_price_input').val();
   
    if(oh_pm_type==2){
        // var cal_overhead_rate = $('.fees_child_item_overhead').val();
        // var cal_profit_rate = $('.fees_child_item_profit').val();
        // console.log(cal_overhead_rate);
        // if(cal_overhead_rate=='0.00%'){
        //     console.log('if 0');
            cal_overhead_rate = $('.fees_child_item_overhead').attr('data-old-val');
        // }
        // if(cal_profit_rate=='0.00%'){
            cal_profit_rate = $('.fees_child_item_profit').attr('data-old-val');
        //}
    }else{
        var cal_overhead_rate =  service_overhead_rate;
        var cal_profit_rate =  service_profit_rate;
    }
    // var cal_overhead_price = $('.fees_child_item_overhead_price').text();
    // var cal_profit_price = $('.fees_child_item_profit_price').text();
    //var cal_profit_price =cleanNumber($('#'+calculator_form_id).find('.cal_profit_price').text());
    var tax_rate =cleanNumber($('.fees_child_tax_rate').val());
    var temp_item_quantity =cleanNumber($('#fees_child_item_quantity').val());

    $.ajax({
                    url: '/ajax/checkItemCustomTotalPrice',
                    type: "POST",
                    data: {
                        "cal_overhead_rate": cal_overhead_rate,
                        "cal_profit_rate": cal_profit_rate,
                        "tax_rate": tax_rate,
                        'base_unit_price':base_unit_price,
                        'item_quantity':temp_item_quantity,
                        'total_price':new_total_price,

                    },
                    dataType: "json",

                    success: function( data){


                        if(parseFloat(data.new_oh_total)<0){
                                    var temp_overheadPrice = '-$'+addCommas(number_test(Math.abs(data.new_oh_total)));
                                    $('#add_fees_child_item_form').find('.fees_child_item_overhead_price').closest('tr').css('color','red');
                                    $('#add_fees_child_item_form').find('.fees_child_item_overhead').css('color','red');
                                }else{
                                    var temp_overheadPrice = '$'+addCommas(number_test(data.new_oh_total));
                                    $('#add_fees_child_item_form').find('.fees_child_item_overhead_price').closest('tr').css('color','#444444');
                                    $('#add_fees_child_item_form').find('.fees_child_item_overhead').css('color','#44444');
                                }

                                if(parseFloat(data.new_pm_total)<0){
                                    var temp_profitPrice = '-$'+addCommas(number_test(Math.abs(data.new_pm_total)));
                                    $('#add_fees_child_item_form').find('.fees_child_item_profit_price').closest('tr').css('color','red');
                                    $('#add_fees_child_item_form').find('.fees_child_item_profit').css('color','red');
                                }else{
                                    var temp_profitPrice = '$'+addCommas(number_test(data.new_pm_total));
                                    $('#add_fees_child_item_form').find('.fees_child_item_profit_price').closest('tr').css('color','#444444');
                                    $('#add_fees_child_item_form').find('.fees_child_item_profit').css('color','#444444');
                                }
                                
                            $('#add_fees_child_item_form').find('.fees_child_item_overhead').val(data.oh_percent);
                            $('#add_fees_child_item_form').find('.fees_child_item_profit').val(data.pm_percent);
                            $('#add_fees_child_item_form').find('.fees_child_tax_amount').text('$'+addCommas(number_test(data.newTaxPrice)));
                            $('#add_fees_child_item_form').find('.fees_child_item_overhead_price').text(temp_overheadPrice);
                            $('#add_fees_child_item_form').find('.fees_child_item_profit_price').text(temp_profitPrice);
                    
                            fees_child_item_overhead_profit_calculation(cleanNumber(base_unit_price),temp_item_quantity,data.oh_percent,data.pm_percent,tax_rate);
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })

};


$(document).on("click",".item_fees_total_edit_icon",function(){ 
    var total_price = $(this).closest('td').find('.fees_child_item_total_price').text();
    $('.fees_child_item_overhead').attr('data-old-val',$('.fees_child_item_overhead').val());
    $('.fees_child_item_profit').attr('data-old-val',$('.fees_child_item_profit').val());
    $('.if_not_edit_fees_item_total_price,.save_fees_estimation,.item_fees_total_edit_icon').hide();
    $(this).closest('td').find('input').val(total_price);
    $('.custom_fees_total_price_input,.if_edit_fees_item_total_price').show();
   
});

$(document).on("click",".cancel_edit_fees_item_total",function(){ 
    $('.if_not_edit_fees_item_total_price,.save_custom_estimation,.item_fees_total_edit_icon ').show();
    $('.custom_fees_total_price_input,.if_edit_fees_item_total_price').hide();
   
    var total_price = $(this).closest('td').find('.fees_child_item_total_price').text();
    $(this).closest('td').find('input').val(total_price);
    change_custom_fees_total_price_input();
    
})

function revert_fees_custom_item_total(){
    $('.if_not_edit_fees_item_total_price,.save_custom_estimation,.item_fees_total_edit_icon ').show();
    $('.custom_fees_total_price_input,.if_edit_fees_item_total_price').hide();
}

$(document).on("click",".update_fees_itam_total_btn",function(){
    var new_total_price = addCommas(cleanNumber($(this).closest('td').find('input').val()));
   
    has_custom_fees_total_price_update =true;
    
    $('.fees_child_item_total_price').text(new_total_price);
    $('.if_not_edit_fees_item_total_price,.save_fees_estimation,.item_fees_total_edit_icon ').show();
    $('.custom_fees_total_price_input,.if_edit_fees_item_total_price').hide();

});

//////////////////////end edit fees total price///////////////////////
                                                                                            

/////////equipment edit total price/////////////////
var temptimer = null;
$('.custom_equipement_total_price_input').keydown(function(){
       clearTimeout(temptimer); 
       temptimer = setTimeout(change_custom_equipement_total_price_input, 600)
});

function change_custom_equipement_total_price_input(){
    
    var base_unit_price = $('.equipement_item').find(':selected').data('base-unit-price');
        
    //var base_unit_price = $('#items_'+item_id).find('.open_calculator').attr('data-item-base-price');
    
    var new_total_price = $('.custom_equipement_total_price_input').val();
   
    // var cal_overhead_price = $('.equipement_cal_overhead_price').text();
    // var cal_profit_price = $('.equipement_cal_profit_price').text();
    if(oh_pm_type==2){
        var cal_overhead_rate =  $('.equipement_item').find(':selected').data('overhead-rate');
        var cal_profit_rate = $('.equipement_item').find(':selected').data('profit-rate');
    }else{
        var cal_overhead_rate =  service_overhead_rate;
        var cal_profit_rate =  service_profit_rate;
    }
    //var cal_profit_price =cleanNumber($('#'+calculator_form_id).find('.cal_profit_price').text());
    var tax_rate =cleanNumber($('.equipement_cal_tax').val());
    var temp_item_quantity =cleanNumber($('.equipment_total_time_value').text());

    $.ajax({
                    url: '/ajax/checkItemCustomTotalPrice',
                    type: "POST",
                    data: {
                        "cal_overhead_rate": cal_overhead_rate,
                        "cal_profit_rate": cal_profit_rate,
                        "tax_rate": tax_rate,
                        'base_unit_price':base_unit_price,
                        'item_quantity':temp_item_quantity,
                        'total_price':new_total_price,

                    },
                    dataType: "json",

                    success: function( data){


                        if(parseFloat(data.new_oh_total)<0){
                                    var temp_overheadPrice = '-$'+addCommas(number_test(Math.abs(data.new_oh_total)));
                                    $('#equipement_time_type_form').find('.equipement_cal_overhead_price').closest('tr').css('color','red');
                                    $('#equipement_time_type_form').find('.equipement_cal_overhead').css('color','red');
                                }else{
                                    var temp_overheadPrice = '$'+addCommas(number_test(data.new_oh_total));
                                    $('#equipement_time_type_form').find('.equipement_cal_overhead_price').closest('tr').css('color','#444444');
                                    $('#equipement_time_type_form').find('.equipement_cal_overhead').css('color','#44444');
                                }

                                if(parseFloat(data.new_pm_total)<0){
                                    var temp_profitPrice = '-$'+addCommas(number_test(Math.abs(data.new_pm_total)));
                                    $('#equipement_time_type_form').find('.equipement_cal_profit_price').closest('tr').css('color','red');
                                    $('#equipement_time_type_form').find('.equipement_cal_profit').css('color','red');
                                }else{
                                    var temp_profitPrice = '$'+addCommas(number_test(data.new_pm_total));
                                    $('#equipement_time_type_form').find('.equipement_cal_profit_price').closest('tr').css('color','#444444');
                                    $('#equipement_time_type_form').find('.equipement_cal_profit').css('color','#444444');
                                }
                                
                            $('#equipement_time_type_form').find('.equipement_cal_overhead').val(data.oh_percent);
                            $('#equipement_time_type_form').find('.equipement_cal_profit').val(data.pm_percent);
                            $('#equipement_time_type_form').find('.equipement_cal_tax_amount').text('$'+addCommas(number_test(data.newTaxPrice)));
                            $('#equipement_time_type_form').find('.equipement_cal_overhead_price').text(temp_overheadPrice);
                            $('#equipement_time_type_form').find('.equipement_cal_profit_price').text(temp_profitPrice);
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })

};


$(document).on("click",".item_equipement_total_edit_icon",function(){ 
    var total_price = $(this).closest('td').find('.equipement_cal_total_price').text();
    $('.if_not_edit_equipement_item_total_price,.save_equipement_estimation,.item_equipement_total_edit_icon').hide();
    $(this).closest('td').find('input').val(total_price);
    $('.custom_equipement_total_price_input,.if_edit_equipement_item_total_price').show();
   
});

$(document).on("click",".cancel_edit_equipement_item_total",function(){ 
    $('.if_not_edit_equipement_item_total_price,.save_equipement_estimation,.item_equipement_total_edit_icon').show();
    $('.custom_equipement_total_price_input,.if_edit_equipement_item_total_price').hide();
   
    var total_price = $(this).closest('td').find('.equipement_cal_total_price').text();
    $(this).closest('td').find('input').val(total_price);
    change_custom_equipement_total_price_input();
    
})

$(document).on("click",".update_equipement_itam_total_btn",function(){
    var new_total_price = addCommas($(this).closest('td').find('input').val());
   
    has_custom_equipement_total_price_update =true;
    
    $('.equipement_cal_total_price').text(new_total_price);
    $('.if_not_edit_equipement_item_total_price,.save_equipement_estimation,.item_equipement_total_edit_icon').show();
    $('.custom_equipement_total_price_input,.if_edit_equipement_item_total_price').hide();

});

//////////////////////end edit equipment total price///////////////////////



$(document).on("click",".item_total_edit_icon",function(){ 
    var total_price = $(this).closest('td').find('.cal_total_price').text();
    $('.if_not_edit_item_total_price,.item_unit_edit_icon').hide();
    $(this).closest('td').find('input').val(total_price);
    $('.if_edit_item_total_price').show();
    $('.save_estimation').hide();
})

$(document).on("click",".item_unit_edit_icon",function(){ 
    var total_price = $(this).closest('td').find('.cal_unit_price').text();
    
    $('.item_unit_edit_icon,.cal_overhead_profit_checkbox,.hide_if_edit_item_unit_price,.item_total_edit_icon,.item_parant_total_edit_icon').hide();
    $(this).closest('td').find('input').val(total_price);
   
    
    $('.if_edit_item_unit_price').show();
    $('.save_estimation').hide();
});

$(document).on("click",".cancel_edit_item_unit_price",function(){ 
    $('.item_unit_edit_icon,.cal_overhead_profit_checkbox,.hide_if_edit_item_unit_price,.item_total_edit_icon,.item_parant_total_edit_icon').show();
    $('.if_edit_item_unit_price').hide();
    //console.log($('#quantity_calculation').find('if_item_saved').is(":visible"));
    if(!$('.if_item_saved').is(":visible")){
        $('.save_estimation').show();
    }
    edited_unit_price = 0;
    edited_base_price = 0;
    var item_unit_price = $(this).closest('td').find('.cal_unit_price').text();
    $(this).closest('td').find('.custom_unit_price_input').val(item_unit_price);
    change_custom_unit_price_input();
});

$(document).on("click",".update_itam_unit_price_btn",function(){ 
    $('.item_unit_edit_icon,.cal_overhead_profit_checkbox,.hide_if_edit_item_unit_price,.item_unit_edit_icon,.item_total_edit_icon,.item_parant_total_edit_icon').show();
    $('.if_edit_item_unit_price').hide();
    var item_unit_price = cleanNumber($(this).closest('td').find('.custom_unit_price_input').val());
     $(this).closest('td').find('.cal_unit_price').text(addCommas(number_test(item_unit_price)))
    
        $('.save_estimation').show();
    

})

$(document).on("click",".item_parant_total_edit_icon",function(){ 
    var total_price = $(this).closest('td').find('.cal_child_parent_total_price').text();
    $('.if_not_edit_parent_item_total_price,.item_unit_edit_icon').hide();
    $(this).closest('td').find('input').val(total_price);
    $('.if_edit_parent_item_total_price').show();
})
$(document).on("click",".cancel_edit_parent_item_total",function(){ 
    $('.if_not_edit_parent_item_total_price,.item_unit_edit_icon').show();
    $('.if_edit_parent_item_total_price').hide();
    var total_price = $(this).closest('td').find('.cal_child_parent_total_price').text();
    $(this).closest('td').find('.custom_parent_total_price_input').val(total_price);
    change_custom_parent_total_price_input();
})

$(document).on("click",".cancel_edit_item_total",function(){ 
    $('.if_not_edit_item_total_price,.item_unit_edit_icon').show();
    $('.if_edit_item_total_price').hide();
    
    if(!$('.if_item_saved').is(":visible")){
        $('.save_estimation').show();
    }
    var total_price = $(this).closest('td').find('.cal_total_price').text();
    $(this).closest('td').find('.custom_total_price_input').val(total_price);
    change_custom_total_price_input();
    
})

$(document).on("click",".custom_item_total_edit_icon",function(){ 
    unsave_cal=true;
    var total_price = $(this).closest('td').find('.custom_item_total_price').text();
    $('.if_not_edit_custom_item_total_price,#continue3,.item_unit_edit_icon').hide();
    $(this).closest('td').find('input').val(total_price);
    $('.if_edit_custom_item_total_price').show();
    
})

$(document).on("click",".cancel_edit_custom_item_total",function(){ 
    unsave_cal=false;
    $('.if_not_edit_custom_item_total_price,.item_unit_edit_icon').show();
    $('.if_edit_custom_item_total_price').hide();
    if(!$('.if_custom_item_saved').is(":visible")){
        $('#continue3').show();
    }
})

$(document).on("click",".sub_item_total_edit_icon",function(){ 
    unsave_cal=true;
    var total_price = $(this).closest('td').find('.subcontractors_item_total_price').text();
    $('.if_not_edit_sub_item_total_price,#savesubcontractors').hide();
    $(this).closest('td').find('input').val(total_price);
    $('.if_edit_sub_item_total_price').show();
    
})

$(document).on("click",".cancel_edit_sub_item_total",function(){ 
    unsave_cal=false;
    $('.if_not_edit_sub_item_total_price').show();
    $('.if_edit_sub_item_total_price').hide();
    if(!$('.if_custom_item_saved').is(":visible")){
        $('#savesubcontractors').show();
    }
})

// $(document).on("click",".update_itam_total_btn",function(){ 
//     var new_total_price = $(this).closest('td').find('input').val();
    
//     var temp_estimate_line_id = $('#items_'+item_id).find('.open_calculator').attr('data-estimate-line-id');
//     if(temp_estimate_line_id){

//         $.ajax({
//                         url: '/ajax/updateSaveItemTotalPrice',
//                         type: "POST",
//                         data: {
//                             "proposalServiceId": proposal_service_id,
//                             'phase_id':phase_id,
//                             'estimate_line_id':temp_estimate_line_id,
//                             'total_price':new_total_price,

//                         },
//                         dataType: "json",

//                         success: function( data){


//                             $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
//                             $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                        
//                             check_tr_has_class();
//                             //get_service_item_list();
//                             get_service_item_list_by_phase_id();
//                             get_proposal_breakdown();
//                             update_proposal_overhead_profit();
//                             swal(
//                                 'Items Updated',
//                                 ''
//                             );
//                             $("#quantity_calculation").dialog('close');
//                         },
//                         error: function( jqXhr, textStatus, errorThrown ){
//                             console.log( errorThrown );
//                         }
//                     })
//     }else{

//         swal({
//             title: 'Saving..',
//             allowEscapeKey: false,
//             allowOutsideClick: false,
//             timer: 2000,
//             onOpen: () => {
//             swal.showLoading();
//             }
//         });
//        var check_est_completed = $('#service_'+proposal_service_id+' a .est_checked').hasClass('est_checked_hide');
//        var fields = [];
//     //$('.save_estimation').show();   
//     if(calculator_form_id=='asphalt_form'){
//         var service_box_id = '#service_html_box3';
//     }else if(calculator_form_id=='concrete_form'){
//         var service_box_id = '#service_html_box4';
//     } else if(calculator_form_id=='sealcoating_form'){
//         var service_box_id = '#service_html_box5';
//     }else if(calculator_form_id=='striping_form'){
//         var service_box_id = '#service_html_box6';
//     }else if(calculator_form_id=='crack_sealer_form'){
//         var service_box_id = '#service_html_box7';
//     }
       

//        $(service_box_id).find('li').each(function(i,li){
//                             $(li).find('.field_input').val();
//                             var li_id = $(li).find('.field_input').attr('id');
//                             if(li_id){
//                                 var li_id = li_id.replace(new RegExp("^" + 'input_'), '');
//                                 var field_new_value = $(li).find('.field_input').val()
//                                 fields.push({
//                                     'fieldId':li_id,
//                                     'fieldValue':field_new_value,
                                    
//                                 });
//                             }
//                             var field_id =$(li).data('field-id');
//                 if($("li[data-field-id='"+field_id+"']" ).find('.field_input').prop('type') == 'text' ) 
//                 {
//                     $("li[data-field-id='"+field_id+"']" ).find('.field_input').attr('value',field_new_value);
//                 }else{
//                     $("li[data-field-id='"+field_id+"']" ).find('.field_input option').removeAttr('selected').filter('[value="'+field_new_value+'"]').attr('selected', true)
//                 }          
                
                
//                 $("li[data-field-id='"+field_id+"']" ).find('.show_input_span').text(field_new_value);
                           
//         });
//       total_price = cleanNumber($('#'+calculator_form_id).find('.cal_total_price').text());
//         //total_price = calTotalPrice;
//         var form_data = $("#"+calculator_form_id).serializeArray();
//         for($i=0;$i<form_data.length;$i++){
       
//             var $form = $("#"+calculator_form_id);
                                
//             var $field = $form.find('[name=' + form_data[$i].name + ']');
//             if($field.attr('data-field-code')){
//             form_data[$i].field_code = $field.attr('data-field-code');
//             }
        
//         }
//         var lineItems =[];

//        item_id = $('#'+item_line_id).find('.open_calculator').data('item-id');
//        var template = $('#'+item_line_id).find('.open_calculator').data('templates');
//         if(template){
//             var template_type_id = $('.select_template_option').val();
        
//         }else{
//             var template_type_id = $('#'+item_line_id).find('.open_calculator').data('template-type-id');
//         }
//         if(!template_type_id){
//             template_type_id = '0';
//         }
//        var original_unit_price = $('#'+item_line_id).find('.open_calculator').data('item-unit-price');
//        var estimate_line_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
 
//        if(parseFloat(item_price) == parseFloat(original_unit_price) ){
//            var customUnitPrice =0;
//        }else{
//            var customUnitPrice =1;
//        }
//        //if(item_quantity>0 && total_price>0){


//            lineItems.push({
//                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
//                'customUnitPrice':customUnitPrice,
//                'proposalServiceId':proposal_service_id,
//                'id':estimate_line_id,
//                'itemId':item_id,
//                'PhaseId':phase_id,
//                'quantity':item_quantity,
//                'unitPrice':item_price,
//                'totalPrice':total_price,
//                'overHeadRate':overheadRate,
//                'profitRate':profitRate,
//                'overHeadPrice':overheadPrice,
//                'profitPrice':profitPrice,
//                'basePrice':item_base_price,
//                'taxRate':taxRate,
//                'taxPrice':taxPrice,
//                'truckingOverHeadRate': cal_trucking_oh,
//                'truckingProfitRate': cal_trucking_pm,
//                'truckingOverHeadPrice': cal_trucking_oh_Price,
//                'truckingProfitPrice': cal_trucking_pm_Price,
//                'truckingTotalPrice': cal_trucking_total_Price,
//                'sub_id':'0', 
//                'template_type_id':template_type_id,
//            });

//       // }
//        // }

// //})
// //})

//        $.ajax({
//            url: '/ajax/saveEstimatorValues/',
//            type: 'post',
//            data: {
//                'lineItems':lineItems,
//                'proposalServiceId':proposal_service_id,
//                'proposal_Id':'<?php echo $proposal->getProposalId(); ?>',
//                'apply':0,
//                'values':form_data,
//                'itemId':item_id,
//                'PhaseId':phase_id,
//                'calculator_name':calculator_form_id,
//                'calculation_id':estimate_calculator_id,
//                'fields':fields
//            },
//            success: function(data){
//                         try{
//                                 data = JSON.parse(data);
//                             } catch (e) {
//                                 swal("Error", "An error occurred Please try again");
//                                 return false;
//                             }
//                if(calculator_form_id=='sealcoating_form'){
//                     if(estimate_line_id){
//                         deleteOldSealcoatChildItem(data.lineItemId);
//                         //sealcoatchilditemadd(data.lineItemId);
//                     }else{
//                         sealcoatchilditemadd(data.lineItemId);
//                     }
                    
//                 }
//                 unsave_cal=false;
//                 $.ajax({
//                         url: '/ajax/updateSaveItemTotalPrice',
//                         type: "POST",
//                         data: {
//                             "proposalServiceId": proposal_service_id,
//                             'phase_id':phase_id,
//                             'estimate_line_id':data.lineItemId,
//                             'total_price':new_total_price,

//                         },
//                         dataType: "json",

//                         success: function( data){


//                             $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
//                             $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                        
//                             check_tr_has_class();
//                             //get_service_item_list();
//                             get_service_item_list_by_phase_id();
//                             get_proposal_breakdown();
//                             update_proposal_overhead_profit();
//                             swal(
//                                 'Items Updated',
//                                 ''
//                             );
//                             $("#quantity_calculation").dialog('close');
//                         },
//                         error: function( jqXhr, textStatus, errorThrown ){
//                             console.log( errorThrown );
//                         }
//                     })
//            },
//            error: function( jqXhr, textStatus, errorThrown ){
//                 swal("Error", "An error occurred Please try again");
//                 console.log( errorThrown );
//             }
//        })


//     }

// })

function update_sub_itam_total_save(calculation_form_id,estimate_line_id){
    var new_total_price = $('#'+calculation_form_id).find('.sub_total_price_input_sep').val();
 
    $.ajax({
                    url: '/ajax/updateSaveItemTotalPrice',
                    type: "POST",
                    data: {
                        "proposalServiceId": proposal_service_id,
                        'phase_id':phase_id,
                        'estimate_line_id':estimate_line_id,
                        'total_price':new_total_price,

                    },
                    dataType: "json",

                    success: function( data){
                        

                        $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                        $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                        $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                        $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                        $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                        check_tr_has_class();
                        //get_service_item_list();
                        get_service_item_list_by_phase_id();
                        get_proposal_breakdown();
                        get_sub_contractors_items();
                        if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                        
                        $("#add_sub_contractors_item_model").dialog('close');
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })
}


function update_custom_itam_total_save(calculation_form_id,estimate_line_id){
    var new_total_price = $('#'+calculation_form_id).find('.custom_total_price_input_sep').val();
 
    $.ajax({
                    url: '/ajax/updateSaveItemTotalPrice',
                    type: "POST",
                    data: {
                        "proposalServiceId": proposal_service_id,
                        'phase_id':phase_id,
                        'estimate_line_id':estimate_line_id,
                        'total_price':new_total_price,

                    },
                    dataType: "json",

                    success: function( data){
                        console.log(data.estimate.service_price);

                        $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                        $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                        $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                        $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                        $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                        check_tr_has_class();
                        //get_service_item_list();
                        get_service_item_list_by_phase_id();
                        get_proposal_breakdown();
                        //update_proposal_overhead_profit();
                        
                        if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                        $("#add_custom_item_model").dialog('close');
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })
}

$(document).on("click",".update_custom_itam_total_btn",function(){ 
    unsave_cal=false;
    

    var new_total_price = $(this).closest('td').find('input').val();
    if(new_total_price.replace('$', '') != $(this).closest('td').find('.custom_item_total_price').text()){
        unsave_cal=true;
    }else{
        unsave_cal=false;
    }
    has_custom_sep_total_price_update =true;
    
    $(this).closest('td').find('.custom_item_total_price').text(new_total_price.replace('$', ''));
    $('.if_not_edit_custom_item_total_price').show();
    $('.if_edit_custom_item_total_price').hide();
    $('.if_custom_item_saved').hide();
    $('#continue3').show();
     

})

$(document).on("click",".update_sub_itam_total_btn",function(){ 
    unsave_cal=false;
    

    var new_total_price = $(this).closest('td').find('input').val();
    if(new_total_price.replace('$', '') != $(this).closest('td').find('.subcontractors_item_total_price').text()){
        unsave_cal=true;
    }else{
        unsave_cal=false;
    }
    has_sub_sep_total_price_update =true;
    
    $(this).closest('td').find('.subcontractors_item_total_price').text(new_total_price.replace('$', ''));
    $('.if_not_edit_sub_item_total_price').show();
    $('.if_edit_sub_item_total_price').hide();
    $('.if_sub_item_saved').hide();
    $('#savesubcontractors').show();
     

})

$(document).on("click",".update_itam_total_btn",function(){
    var new_total_price = $(this).closest('td').find('input').val();
    if(new_total_price.replace('$', '') != $(this).closest('td').find('.cal_total_price').text()){
        unsave_cal=true;
    }else{
        unsave_cal=false;
    }
    has_custom_total_price_update =true;
    
    $(this).closest('td').find('.cal_total_price').text(new_total_price.replace('$', ''));
    $('.if_not_edit_item_total_price,.item_unit_edit_icon').show();
    $('.if_edit_item_total_price').hide();
    $('.if_item_saved').hide();
    $('.save_estimation').show();

});

$(document).on("click",".update_parent_itam_total_btn",function(){
    var new_total_price = $(this).closest('td').find('input').val();
    if(new_total_price.replace('$', '') != $(this).closest('td').find('.cal_total_price').text()){
        unsave_cal=true;
    }else{
        unsave_cal=false;
    }
    has_custom_parent_total_price_update =true;
    
    $(this).closest('td').find('.cal_child_parent_total_price').text(new_total_price.replace('$', ''));
    $('.if_not_edit_parent_item_total_price,.item_unit_edit_icon').show();
    $('.if_edit_parent_item_total_price').hide();
    $('.if_item_saved').hide();
    $('.save_estimation').show();

});

function update_custom_itam_total(calculation_form_id,estimate_line_id){
    var new_total_price = $('#'+calculation_form_id).find('.custom_total_price_input').val();
      
    $.ajax({
                    url: '/ajax/updateSaveItemTotalPrice',
                    type: "POST",
                    data: {
                        "proposalServiceId": proposal_service_id,
                        'phase_id':phase_id,
                        'estimate_line_id':estimate_line_id,
                        'total_price':new_total_price,

                    },
                    dataType: "json",

                    success: function( data){

                        console.log(data.estimate.service_price);
                        $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                        $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                        $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                        $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                        $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                        check_tr_has_class();
                        //get_service_item_list();
                        get_service_item_list_by_phase_id();
                        get_proposal_breakdown();
                        //update_proposal_overhead_profit();
                        swal(
                            'Estimate Saved',
                            ''
                        );
                        if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                        $("#add_custom_item_model").dialog('close');
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })

}

var timer = null;
$('.custom_total_price_input').keydown(function(){
    edited_unit_price = 0;
    edited_base_price = 0;
    edited_total_price = 1;
       clearTimeout(timer); 
       timer = setTimeout(change_custom_total_price_input, 600)
});

    function change_custom_total_price_input(){
    
    var base_unit_price = $('#items_'+item_id).find('.open_calculator').attr('data-item-base-price');
    
    var new_total_price = $('#'+calculator_form_id).find('.custom_total_price_input').val();
    var cal_overhead_price =cleanNumber($('#'+calculator_form_id).find('.cal_overhead_price').text());
    
    var cal_profit_price =cleanNumber($('#'+calculator_form_id).find('.cal_profit_price').text());
    var tax_rate =cleanNumber($('#'+calculator_form_id).find('.cal_tax').val());
    $.ajax({
                    url: '/ajax/updateCheckItemTotalPrice',
                    type: "POST",
                    data: {
                        "cal_overhead_price": cal_overhead_price,
                        "cal_profit_price": cal_profit_price,
                        "tax_rate": tax_rate,
                        'base_unit_price':base_unit_price,
                        'item_quantity':item_quantity,
                        'total_price':new_total_price,

                    },
                    dataType: "json",

                    success: function( data){

                        if(parseFloat(data.new_oh_total)<0){
                            var temp_overheadPrice = '-$'+addCommas(number_test(Math.abs(data.new_oh_total)));
                            $('#'+calculator_form_id).find('.cal_overhead').closest('tr').css('color','red');
                            $('#'+calculator_form_id).find('.cal_overhead').css('color','red');
                        }else{
                            var temp_overheadPrice = '$'+addCommas(number_test(data.new_oh_total));
                            $('#'+calculator_form_id).find('.cal_overhead').closest('tr').css('color','#444444');
                            $('#'+calculator_form_id).find('.cal_overhead').css('color','#444444');
                        }

                        if(parseFloat(data.new_pm_total)<0){
                            var temp_profitPrice = '-$'+addCommas(number_test(Math.abs(data.new_pm_total)));
                            $('#'+calculator_form_id).find('.cal_profit').closest('tr').css('color','red');
                            $('#'+calculator_form_id).find('.cal_profit').css('color','red');
                        }else{
                            var temp_profitPrice = '$'+addCommas(number_test(data.new_pm_total));
                            $('#'+calculator_form_id).find('.cal_profit').closest('tr').css('color','#444444');
                            $('#'+calculator_form_id).find('.cal_profit').css('color','#444444');
                        }
                        $('#'+calculator_form_id).find('.cal_overhead').val(data.oh_percent);
                        $('#'+calculator_form_id).find('.cal_profit').val(data.pm_percent);
                        $('#'+calculator_form_id).find('.cal_overhead_price').text(temp_overheadPrice);
                        $('#'+calculator_form_id).find('.cal_profit_price').text(temp_profitPrice);
                        $('#'+calculator_form_id).find('.cal_tax_amount').text('$'+addCommas(number_test(data.newTaxPrice)));
                        $('#'+calculator_form_id).find('.cal_unit_price').text(data.baseUnitPrice);
                        $('#'+calculator_form_id).find('.custom_unit_price_input').val(data.baseUnitPrice);
                        item_price = data.baseUnitPrice;
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })

};

//Keyup For Unit Price Input

$('.custom_unit_price_input').keyup(function(){
    edited_unit_price = 1;
    
    edited_base_price = 0;
    edited_total_price = 0;
    change_custom_unit_price_input();
});

function change_custom_unit_price_input(){

    var unit_price = cleanNumber($('#'+calculator_form_id).find('.custom_unit_price_input').val());
    custom_price_total = false;
    check= true;
    item_price = unit_price;
    var item_quantity = cleanNumber($('#'+calculator_form_id).find('.item_quantity').text());
    var item_overhead_rate = cleanNumber($('#'+calculator_form_id).find('.cal_overhead').val());
    var item_profit_rate = cleanNumber($('#'+calculator_form_id).find('.cal_profit').val());
    var tax_rate =cleanNumber($('#'+calculator_form_id).find('.cal_tax').val());

    var tempoverheadPrice = ((unit_price * item_overhead_rate) / 100);
      
        var tempprofitPrice = ((unit_price * item_profit_rate) / 100);

        var custom_total = unit_price * item_quantity;
        
        var total_overhead_profit_rate = ((parseFloat(item_overhead_rate) + parseFloat(item_profit_rate)) /100) + parseFloat(1);


        var item_base_unit_price = parseFloat(unit_price / total_overhead_profit_rate);
        
        item_base_price = item_base_unit_price;
        $('#'+calculator_form_id).find('.custom_unit_base_price_input').val(item_base_unit_price);

        if(calculator_form_id =='concrete_form'){
            calculate_concrete_measurement();
            return false;
       }else if(calculator_form_id =='sealcoating_form'){
            sealcoatCalculator();
            return false;
       }else if(calculator_form_id =='crack_sealer_form'){
            cracksealCalculator();
            return false;
       }else if(calculator_form_id =='striping_form'){
            stripingPaintRender();
            return false;
       }else if(calculator_form_id =='sealcoating_material_form'){
            sealcoating_material_measurement()
            return false;
       }

        var temptaxPrice = ((custom_total * tax_rate) / 100);
        tempoverheadPrice = tempoverheadPrice * item_quantity;
        tempprofitPrice = tempprofitPrice * item_quantity;
        
       
        
        $('.custome_tax_amount').text('$'+addCommas(number_test(temptaxPrice)));
            
        totalPrice = parseFloat(custom_total) + parseFloat(temptaxPrice);
        
        $('#'+calculator_form_id).find('.cal_overhead_price').text(addCommas(number_test(tempoverheadPrice)));
        $('#'+calculator_form_id).find('.cal_profit_price').text(addCommas(number_test(tempprofitPrice)));
        
        
       
        $('#'+calculator_form_id).find('.custom_total_price_input').val(totalPrice);
        $('#'+calculator_form_id).find('.cal_total_price').text(addCommas(number_test(totalPrice)));

        $('#'+calculator_form_id).find('.custom_parent_total_price_input').val(totalPrice);
        //$('#'+calculator_form_id).find('.cal_child_parent_total_price').text(addCommas(number_test(totalPrice)));
        if($(".if_child_parent_total").is(":visible")){ 
                
                var temp_estimate_line_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
                get_child_items_list(temp_estimate_line_id,false,true);
                
            }
        
};

$('.custom_unit_base_price_input').keyup(function(){
    
    edited_base_price = 1;
    edited_unit_price = 0;
    edited_total_price = 0;
    var base_unit_price = cleanNumber($('#'+calculator_form_id).find('.custom_unit_base_price_input').val());
   // var cal_overhead_price =cleanNumber($('#'+calculator_form_id).find('.cal_overhead_price').text());

   custom_price_total = false;
   check= true;
    var item_quantity = cleanNumber($('#'+calculator_form_id).find('.item_quantity').text());
    var item_overhead = cleanNumber($('#'+calculator_form_id).find('.cal_overhead').val());
    var item_profit = cleanNumber($('#'+calculator_form_id).find('.cal_profit').val());
    
    var tax_rate =cleanNumber($('#'+calculator_form_id).find('.cal_tax').val());


    var tempoverheadPrice = ((base_unit_price * item_overhead) / 100);
        
        var tempprofitPrice = ((base_unit_price * item_profit) / 100);
        var custome_item_unit_price_text = parseFloat(base_unit_price) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);
       if(!custome_item_unit_price_text){
        custome_item_unit_price_text ='0';
       }
        $('.custome_item_unit_price_text').text('$'+addCommas(number_test(custome_item_unit_price_text)));
       
        if(calculator_form_id =='concrete_form'){
        calculate_concrete_measurement();
        return false;
       }else if(calculator_form_id =='sealcoating_form'){
            sealcoatCalculator();
            return false;
       }else if(calculator_form_id =='crack_sealer_form'){
            cracksealCalculator();
            return false;
       }else if(calculator_form_id =='striping_form'){
        stripingPaintRender();
        return false;
       }else if(calculator_form_id =='sealcoating_material_form'){
            sealcoating_material_measurement()
            return false;
       }
       
        tempoverheadPrice = tempoverheadPrice * item_quantity;
        tempprofitPrice = tempprofitPrice * item_quantity;
        var custom_total = base_unit_price * item_quantity;
        
        var totalPrice = parseFloat(custom_total) + parseFloat(tempoverheadPrice) + parseFloat(tempprofitPrice);
         
        var temptaxPrice = ((totalPrice * tax_rate) / 100);
       
        $('.custome_tax_amount').text('$'+addCommas(number_test(temptaxPrice)));
            
        totalPrice = parseFloat(totalPrice) + parseFloat(temptaxPrice);
        $('#'+calculator_form_id).find('.cal_overhead_price').text(addCommas(number_test(tempoverheadPrice)));
        $('#'+calculator_form_id).find('.cal_profit_price').text(addCommas(number_test(tempprofitPrice)));
        item_price = custome_item_unit_price_text;
        item_base_price = base_unit_price;
        $('#'+calculator_form_id).find('.custom_unit_price_input').val(custome_item_unit_price_text);
        $('#'+calculator_form_id).find('.custom_total_price_input').val(totalPrice);
        $('#'+calculator_form_id).find('.cal_total_price').text(addCommas(number_test(totalPrice)));
  
        if($(".if_child_parent_total").is(":visible")){ 
                
                var temp_estimate_line_id = $('#'+item_line_id).find('.open_calculator').attr('data-estimate-line-id');
                if(temp_estimate_line_id){
                    get_child_items_list(temp_estimate_line_id,false,true);
                }
                
            }
    
    

});
//End Keyup Unit price update

$(document).on("click",".update_parent_itam_total_btn22",function(){ 
    var new_total_price = $(this).closest('td').find('input').val();
    
    var temp_estimate_line_id = $('#items_'+item_id).find('.open_calculator').attr('data-estimate-line-id');
    if(temp_estimate_line_id){

        $.ajax({
                        url: '/ajax/updateParentSaveItemTotalPrice',
                        type: "POST",
                        data: {
                            "proposalServiceId": proposal_service_id,
                            'phase_id':phase_id,
                            'estimate_line_id':temp_estimate_line_id,
                            'total_price':new_total_price,

                        },
                        dataType: "json",

                        success: function( data){


                            $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                            $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                            $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                        $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                        $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                            check_tr_has_class();
                            //get_service_item_list();
                            get_service_item_list_by_phase_id();
                            get_proposal_breakdown();
                            //update_proposal_overhead_profit();
                            swal(
                                'Items Updated',
                                ''
                            );
                            if(parseInt(data.breakdown.overheadPrice)<0){
                                $('.proposal_service_overhead_price').css('color','red');
                            }else{
                                $('.proposal_service_overhead_price').css('color','#444444');
                            }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                            $("#quantity_calculation").dialog('close');
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            console.log( errorThrown );
                        }
                    })
        }
    });

var timer = null;
$('.custom_parent_total_price_input').keydown(function(){
        edited_unit_price = 0;
        edited_base_price = 0;
        edited_total_price = 1;
       clearTimeout(timer); 
       timer = setTimeout(change_custom_parent_total_price_input, 600)
});

function change_custom_parent_total_price_input(){
    
    var estimate_line_id = $('#items_'+item_id).find('.open_calculator').attr('data-estimate-line-id');
    
    var new_total_price =   $('#'+calculator_form_id).find('.custom_parent_total_price_input').val();
  
    $.ajax({
                    url: '/ajax/updateParentCheckItemTotalPrice',
                    type: "POST",
                    data: {
                        'estimate_line_id':estimate_line_id,
                        'total_price':new_total_price,

                    },
                    dataType: "json",

                    success: function( data){

                        if(parseFloat(data.new_oh_total)<0){
                            var temp_overheadPrice = '-$'+addCommas(number_test(Math.abs(data.new_oh_total)));
                            $('#'+calculator_form_id).find('.cal_overhead').closest('tr').css('color','red');
                            $('#'+calculator_form_id).find('.cal_overhead').css('color','red');
                        }else{
                            var temp_overheadPrice = '$'+addCommas(number_test(data.new_oh_total));
                            $('#'+calculator_form_id).find('.cal_overhead').closest('tr').css('color','#444444');
                            $('#'+calculator_form_id).find('.cal_overhead').css('color','#444444');
                        }

                        if(parseFloat(data.new_pm_total)<0){
                            var temp_profitPrice = '-$'+addCommas(number_test(Math.abs(data.new_pm_total)));
                            $('#'+calculator_form_id).find('.cal_profit').closest('tr').css('color','red');
                            $('#'+calculator_form_id).find('.cal_profit').css('color','red');
                        }else{
                            var temp_profitPrice = '$'+addCommas(number_test(data.new_pm_total));
                            $('#'+calculator_form_id).find('.cal_profit').closest('tr').css('color','#444444');
                            $('#'+calculator_form_id).find('.cal_profit').css('color','#444444');
                        }
                        $('#'+calculator_form_id).find('.cal_overhead').val(data.oh_percent);
                        $('#'+calculator_form_id).find('.cal_profit').val(data.pm_percent);
                        $('#'+calculator_form_id).find('.cal_overhead_price').text(temp_overheadPrice);
                        $('#'+calculator_form_id).find('.cal_profit_price').text(temp_profitPrice);
                        $('#'+calculator_form_id).find('.cal_tax_amount').text('$'+addCommas(number_test(data.newTaxPrice)));
                      
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })

};

    function update_custom_parent_itam_total(calculation_form_id,estimate_line_id){
        var new_total_price = $('#'+calculation_form_id).find('.custom_parent_total_price_input').val();
        
        //var temp_estimate_line_id = $('#items_'+item_id).find('.open_calculator').attr('data-estimate-line-id');
    if(estimate_line_id){

        $.ajax({
                        url: '/ajax/updateParentSaveItemTotalPrice',
                        type: "POST",
                        data: {
                            "proposalServiceId": proposal_service_id,
                            'phase_id':phase_id,
                            'estimate_line_id':estimate_line_id,
                            'total_price':new_total_price,

                        },
                        dataType: "json",

                        success: function( data){

                            
                            $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                            $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                            $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                            $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                            $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                            check_tr_has_class();
                            //get_service_item_list();
                            get_service_item_list_by_phase_id();
                            get_proposal_breakdown();
                            //update_proposal_overhead_profit();
                            // swal(
                            //     'Items Updated',
                            //     ''
                            // );
                            swal(
                            'Estimate Saved',
                            ''
                            );
                            if(parseInt(data.breakdown.overheadPrice)<0){
                                $('.proposal_service_overhead_price').css('color','red');
                            }else{
                                $('.proposal_service_overhead_price').css('color','#444444');
                            }

                            if(parseInt(data.breakdown.profitPrice)<0){
                                $('.proposal_service_profit_price').css('color','red');
                            }else{
                                $('.proposal_service_profit_price').css('color','#444444');
                            }
                            $("#quantity_calculation").dialog('close');
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            console.log( errorThrown );
                        }
                    })
        }
    };


    function update_custom_labor_itam_total(estimate_line_id){
    var new_total_price = $('.custom_labor_total_price_input').val();
      
    $.ajax({
                    url: '/ajax/updateSaveItemTotalPrice',
                    type: "POST",
                    data: {
                        "proposalServiceId": proposal_service_id,
                        'phase_id':phase_id,
                        'estimate_line_id':estimate_line_id,
                        'total_price':new_total_price,

                    },
                    dataType: "json",

                    success: function( data){

                        has_custom_labor_total_price_update =false;
                        $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                        $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                        $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                        $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                        $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                        check_tr_has_class();
                        //get_service_item_list();
                        get_service_item_list_by_phase_id();
                        get_proposal_breakdown();
                        //update_proposal_overhead_profit();
                        swal(
                            'Estimate Saved',
                            ''
                        );
                        if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                        $("#add_custom_item_model").dialog('close');
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })

}


function update_custom_equipement_itam_total(estimate_line_id){
    var new_total_price = $('.custom_equipement_total_price_input').val();
      
    $.ajax({
                    url: '/ajax/updateSaveItemTotalPrice',
                    type: "POST",
                    data: {
                        "proposalServiceId": proposal_service_id,
                        'phase_id':phase_id,
                        'estimate_line_id':estimate_line_id,
                        'total_price':new_total_price,

                    },
                    dataType: "json",

                    success: function( data){
                        has_custom_equipement_total_price_update =false;
                        
                        $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                        $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                        $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                        $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                        $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                        check_tr_has_class();
                        //get_service_item_list();
                        get_service_item_list_by_phase_id();
                        get_proposal_breakdown();
                        //update_proposal_overhead_profit();
                        swal(
                            'Estimate Saved',
                            ''
                        );
                        if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                        $("#add_custom_item_model").dialog('close');
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })

}


function update_custom_trucking_itam_total(estimate_line_id,perent_item_id){
    var new_total_price = $('.custom_trucking_total_price_input').val();
      
    $.ajax({
                    url: '/ajax/updateSaveItemTotalPrice',
                    type: "POST",
                    data: {
                        "proposalServiceId": proposal_service_id,
                        'phase_id':phase_id,
                        'estimate_line_id':estimate_line_id,
                        'total_price':new_total_price,

                    },
                    dataType: "json",

                    success: function( data){

                        has_custom_trucking_total_price_update = false;
                        $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                        $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                        $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                        $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                        $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                        check_tr_has_class();
                        get_child_items_list(perent_item_id,false,true);
                        get_service_item_list_by_phase_id();
                        get_proposal_breakdown();
                       
                        swal(
                            'Estimate Saved',
                            ''
                        );
                        if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                        $("#add_custom_item_model").dialog('close');
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })

}


function update_custom_custom_itam_total(estimate_line_id,perent_item_id){
    var new_total_price = $('.custom_custom_total_price_input').val();
      
    $.ajax({
                    url: '/ajax/updateSaveItemTotalPrice',
                    type: "POST",
                    data: {
                        "proposalServiceId": proposal_service_id,
                        'phase_id':phase_id,
                        'estimate_line_id':estimate_line_id,
                        'total_price':new_total_price,

                    },
                    dataType: "json",

                    success: function( data){

                        has_custom_custom_total_price_update =false;
                        $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                        $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                        $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                        $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                        $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                        check_tr_has_class();
                        get_child_items_list(perent_item_id,false,true);
                        get_service_item_list_by_phase_id();
                        get_proposal_breakdown();
                        
                        //update_proposal_overhead_profit();
                        swal(
                            'Estimate Saved',
                            ''
                        );
                        if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                        $("#add_custom_item_model").dialog('close');
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })

}

function update_custom_fees_itam_total(estimate_line_id,perent_item_id){
    var new_total_price = $('.custom_fees_total_price_input').val();
      
    $.ajax({
                    url: '/ajax/updateSaveItemTotalPrice',
                    type: "POST",
                    data: {
                        "proposalServiceId": proposal_service_id,
                        'phase_id':phase_id,
                        'estimate_line_id':estimate_line_id,
                        'total_price':new_total_price,

                    },
                    dataType: "json",

                    success: function( data){

                        has_custom_custom_total_price_update =false;
                        $('.service_total_'+proposal_service_id).val(number_test(data.estimate.service_price));
                        $('.estimate_total_'+proposal_service_id).val(number_test(data.estimate.line_item_total));
                        $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                        $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                        $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                        check_tr_has_class();
                        get_child_items_list(perent_item_id,false,true);
                        get_service_item_list_by_phase_id();
                        get_proposal_breakdown();
                        
                        //update_proposal_overhead_profit();
                        swal(
                            'Estimate Saved',
                            ''
                        );
                        if(parseInt(data.breakdown.overheadPrice)<0){
                            $('.proposal_service_overhead_price').css('color','red');
                        }else{
                            $('.proposal_service_overhead_price').css('color','#444444');
                        }

                        if(parseInt(data.breakdown.profitPrice)<0){
                            $('.proposal_service_profit_price').css('color','red');
                        }else{
                            $('.proposal_service_profit_price').css('color','#444444');
                        }
                        $("#add_custom_item_model").dialog('close');
                    },
                    error: function( jqXhr, textStatus, errorThrown ){
                        console.log( errorThrown );
                    }
                })

}

    function get_service_total(){

        $.ajax({
                        url: '/ajax/getServiceTotal',
                        type: "POST",
                        data: {
                            
                            "proposalServiceId": proposal_service_id,
                            
                        },

                        success: function( data){
                            data = JSON.parse(data);
                           
                        $('.service_total_'+proposal_service_id).val(number_test(data.breakdown.totalPrice));
                       
                        $('.proposal_service_profit_price').text('$'+addCommas(number_test(data.breakdown.profitPrice)));
                        $('.proposal_service_overhead_price').text('$'+addCommas(number_test(data.breakdown.overheadPrice)));		
                        $('.proposal_service_tax_price').text('$'+addCommas(number_test(data.breakdown.taxPrice)));
                        
                            if(parseInt(data.breakdown.overheadPrice)<0){
                                $('.proposal_service_overhead_price').css('color','red');
                            }else{
                                $('.proposal_service_overhead_price').css('color','#444444');
                            }

                            if(parseInt(data.breakdown.profitPrice)<0){
                                $('.proposal_service_profit_price').css('color','red');
                            }else{
                                $('.proposal_service_profit_price').css('color','#444444');
                            }
                        },
                        error: function( jqXhr, textStatus, errorThrown ){
                            console.log( errorThrown );
                        }
                    })

    }


function calculate_unit_price(){
    
    if(oh_pm_type==1){
  
    $('.estimatingItemsTable').each(function(){
                    var $table = $(this);
                    var table_total = 0;
                    var table_child_flag =false;
                    $table.find('tr').each(function(row, tr){
                        if(row>0){
                            
                            var item_base_price = $(tr).find('.open_calculator').attr('data-item-base-price');
                            var is_taxable = $(tr).find('.open_calculator').attr('data-item-taxable');
                            var item_tax_rate = $(tr).find('.open_calculator').attr('data-item-tax-rate');
                            var temp_cal_oh_Price = ((item_base_price * service_overhead_rate) / 100);
                            var temp_cal_pm_Price = ((item_base_price * service_profit_rate) / 100);
                                
                            var temp_unit_price = parseFloat(item_base_price) + parseFloat(temp_cal_oh_Price) + parseFloat(temp_cal_pm_Price);
                           
                            $(tr).find('.span_unit_price1').text('$'+addCommas(number_test(temp_unit_price)));
                            $(tr).find('.unit-price').val(number_test(temp_unit_price));
                                
                            
                        }
                    });
                    
                    
                });
    }else{
        $('.estimatingItemsTable').each(function(){
                    var $table = $(this);
                    var table_total = 0;
                    var table_child_flag =false;
                    $table.find('tr').each(function(row, tr){
                        if(row>0){
                            
                            var item_base_price = $(tr).find('.open_calculator').attr('data-item-base-price');
                            var is_taxable = $(tr).find('.open_calculator').attr('data-item-taxable');
                            var overhead_rate = $(tr).find('.open_calculator').attr('data-item-overhead-rate');
                            var profit_rate = $(tr).find('.open_calculator').attr('data-item-profit-rate');
                            var temp_cal_oh_Price = ((item_base_price * overhead_rate) / 100);
                            var temp_cal_pm_Price = ((item_base_price * profit_rate) / 100);
                                
                            var temp_unit_price = parseFloat(item_base_price) + parseFloat(temp_cal_oh_Price) + parseFloat(temp_cal_pm_Price);
                           
                            $(tr).find('.span_unit_price1').text('$'+addCommas(number_test(temp_unit_price)));
                            $(tr).find('.unit-price').val(number_test(temp_unit_price));
                                
                            
                        }
                    });
                    
                    
                });
    }
}


$(document).on("change",".subcontractors_id",function() {
    $('#subcontractors_item_unit_price').trigger('keyup');
    if($(this).val()==0){
        $('.custom_sub_name_tr').show();
    }else{
        $('.custom_sub_name_tr').hide();
    }
});

function check_service_complate_count(){
    var service_count =0;
    var uncompleted_service_count =0;
    $('#proposal_services .service').each(function(i)
    {
        service_count++;
        
        if($(this).find('.est_checked').hasClass('est_checked_hide')){
            uncompleted_service_count++;
        }
    });
    
    $('.show_pending_est_msg').text('You have '+uncompleted_service_count+' additional services that you need to Estimate');
}

$(window).on('load', function() {
    var service_id = localStorage.getItem("service_id");
    
    if(service_id){
        $('#service_'+service_id+' .toggle').trigger('click');
    }
    if(hasLocalStorage){
        localStorage.setItem("service_id",'');
    }
});
$(document).on("click",".add_extra_ton",function() {
   
        $('.extra_ton_tr').show();
    
});

$(document).on("click",".edit_child_total_hours",function() {
    
   $(this).closest('td').find('.total_time_hours').removeClass('hide_input_style2');
   $(this).closest('td').find('.total_time_hours').addClass('text');
   $(this).closest('td').find('.total_time_hours').removeAttr("readonly");
   //$('.extra_ton_tr').show();

});

$(document).on("click",".edit_perent_total_hours",function() {
    
    $(this).closest('td').find('.total_time_hours').removeClass('hide_input_style2');
    $(this).closest('td').find('.total_time_hours').addClass('text');
    $(this).closest('td').find('.total_time_hours').removeAttr("readonly");
    //$('.extra_ton_tr').show();
 
 });

 $(".estimateFields").click(function() {

            // Grab the service ID/name and category
            // var serviceId = $(this).data('service-id');
            // var serviceName = $(this).data('service-name');
            // var categoryId = $(this).data('category-id');

            // Column indexes
            var measurementColumn = 2;
            var unitColumn = 3;
            var excDepthColumn = 4;
            var baseDepthColumn = 5;
            var depthColumn = 6;
            var gravelDepthColumn = 7;
            var areaColumn = 8;
            var qtyColumn = 9;

            var serviceFields = {
                // Paving
                30: [
                    measurementColumn, unitColumn, excDepthColumn, baseDepthColumn, depthColumn, gravelDepthColumn
                ],
                // Asphalt Repair
                7: [
                    measurementColumn, unitColumn, excDepthColumn, baseDepthColumn, depthColumn, gravelDepthColumn
                ],
                // Sealcoating
                5: [
                    measurementColumn, unitColumn
                ],
                // Concrete
                49: [
                    measurementColumn, unitColumn, excDepthColumn
                ],
                // Line Striping
                2: [
                    measurementColumn
                ],
                // Driveway
                17: [
                    measurementColumn, unitColumn, excDepthColumn, baseDepthColumn, depthColumn, gravelDepthColumn
                ],
                // Crack Sealing
                37: [
                    measurementColumn
                ],
                // Curb
                45: [
                    measurementColumn
                ],
                // Drainage
                21: [
                    measurementColumn, unitColumn, baseDepthColumn, depthColumn, gravelDepthColumn
                ],
                // Milling
                54: [
                    measurementColumn, unitColumn, depthColumn
                ],
                // Slurry Seal
                74: [
                    measurementColumn, unitColumn
                ],
            }

            // Set the serviceId input
            
            // Set the service name
           // $("#estimateFieldsServiceName").text(serviceName);
            // Empty any table rows
            $("#estimationFieldsTable tbody").empty();

            // Load the assignments
            $.ajax({
                url: '/ajax/getEstimatingProposalServiceFields',
                type: 'post',
                data: {
                    'ProposalServiceId':proposal_service_id
                },
                success: function(data){
                    // JSON please
                    data = JSON.parse(data);

                    var fields = data.fields;
                    $("#serviceId").val(data.service_id);
                    $("#proposalServiceId").val(proposal_service_id); 
                    var categoryId = data.category_id;
                    $.each(fields, function (idx, field) {

                        $("#estimationFieldsTable tbody").append('<tr>' +
                            '<td>' + field.name + '</td>' +
                            '<td><input type="radio" value="' + field.id + '" name="measurement"' + (field.cesf.measurement ? " checked" : '') +' '+ (field.cesf.measurement ? " data-val='true'" : " data-val='false'") + ' /> </td>' +
                            '<td><input type="radio" value="' + field.id + '" name="unit"' + (field.cesf.unit ? " checked" : '') +' '+ (field.cesf.unit ? " data-val='true'" : " data-val='false'") + ' /> </td>' +
                            '<td><input type="radio" value="' + field.id + '" name="excDepth"' + (field.cesf.exc_depth ? " checked" : '') +' '+ (field.cesf.exc_depth ? " data-val='true'" : " data-val='false'") + ' /> </td>' +
                            '<td><input type="radio" value="' + field.id + '" name="baseDepth"' + (field.cesf.base_depth ? " checked" : '') +' '+ (field.cesf.base_depth ? " data-val='true'" : " data-val='false'") + ' /> </td>' +
                            '<td><input type="radio" value="' + field.id + '" name="depth"' + (field.cesf.depth ? " checked" : '') +' '+ (field.cesf.depth ? " data-val='true'" : " data-val='false'") + ' /> </td>' +
                            '<td><input type="radio" value="' + field.id + '" name="gravelDepth"' + (field.cesf.gravel_depth ? " checked" : '') +' '+ (field.cesf.gravel_depth ? " data-val='true'" : " data-val='false'") + ' /> </td>' +
                            '<td><input type="radio" value="' + field.id + '" name="area"' + (field.cesf.area ? " checked" : '') +' '+ (field.cesf.area ? " data-val='true'" : " data-val='false'") + ' /> </td>' +
                            '<td><input type="radio" value="' + field.id + '" name="qty"' + (field.cesf.qty ? " checked" : '') +' '+ (field.cesf.qty ? " data-val='true'" : " data-val='false'") + ' /> </td>' +
                            '</tr>');
                    });

                    // Hide all headings and data
                    $('#estimationFieldsTable td, #estimationFieldsTable th').hide();

                    // Show the first column (Fields)
                    $('#estimationFieldsTable td:nth-child(1), #estimationFieldsTable th:nth-child(1)').show();

                    // SHow/hide relevant columns
                    $(serviceFields[categoryId]).each(function(idx, columnIndex) {
                        $("#estimationFieldsTable td:nth-child(" + columnIndex + "), #estimationFieldsTable th:nth-child(" + columnIndex + ")").show();
                    });

                    // Now open the dialog
                    $("#estimatingServiceFieldsDialog").dialog('open');

                },
                error: function( jqXhr, textStatus, errorThrown ){
                    console.log( errorThrown );
                },
            });

            return false;
        });

        

        $(document).on("click","#show_only_saved_items",function() {
            console.log('trigger click')
            if(!$(this).is(":checked")){
                
                $('.cate_tabs').each(function (index, value) {
                    var tabId = $(this).attr('href');
                    tabId =tabId.replace(new RegExp("^" + '#categoryTab'), '');
                  
                    if($('.cat_service_count'+tabId).text()>0){
                        $(this).show();
                    }else{
                        $(this).hide();
                        if($(this).closest('li').hasClass('ui-state-active')){
                            $( "#categoryTabs" ).tabs({ active: '0' });
                        }
                        
                    }
                });
                    if($('.template_active_table_count').text()>0){
                      
                        $('[href="#templatesTab"]').closest('li').show();
                    }else{
                       
                        $('[href="#templatesTab"]').closest('li').hide();
                    }
                
                
                $('.accordionContainer h3').each(function (index, value) {
                    var type_id = $(this).data('type-id');
                   
                    if ($('#heading_span_'+type_id).text() > 0) {
                        $(this).show();
                        
                    } else {
                        $(this).hide();
                        $(this).next(".ui-accordion-content").hide();
                    }

                });

                $('.accordionContainer2 h3').each(function (index, value) {
                        var template_id = $(this).data('template-id');
                        console.log($('.template_table_total_'+template_id));
                        if ($('.template_table_total_'+template_id).text()) {
                            $(this).show();
                            
                        } else {
                            $(this).hide();
                            $(this).next(".ui-accordion-content").hide();
                        }


                    });

                    $('.estimatingItemsTable').each(function(){
                    var $table = $(this);
                  
                    $table.find('tr').each(function(row, tr){
                        if(row>0){
                            
                            if(!$(tr).hasClass('has_item_value')){
                                $(tr).hide();
                            }
                                
                            
                        }
                    });
                    
                });

                $('.has_template_saved_items').each(function(){
                    var $table = $(this);
                  
                    $table.find('tr').each(function(row, tr){
                        if(row>0){
                            
                            if(!$(tr).hasClass('has_item_value')){
                                $(tr).hide();
                            }
                                
                            
                        }
                    });
                    
                });

                
            }else{
                $('.cate_tabs').show();
                $('[href="#templatesTab"]').closest('li').show();
                main_service =$('#service_'+proposal_service_id).data('val');
               var show_service_array = serviceTypeAssignments[main_service];
                var show_template_array = serviceTemplateAssignments[main_service];
                $('.accordionContainer h3').each(function (index, value) {
                    var type_id = $(this).data('type-id');
                    if (jQuery.inArray(type_id, show_service_array)!='-1') {
                        $(this).show();
                        
                    } else {
                        $(this).hide();
                        $(this).next(".ui-accordion-content").hide();
                    }

                });
                
                    $('.accordionContainer2 h3').each(function (index, value) {
                        var template_id = $(this).data('template-id');
                        
                        if (jQuery.inArray(template_id, show_template_array)!='-1') {
                            $(this).show();
                            
                        } else {
                            $(this).hide();
                            $(this).next(".ui-accordion-content").hide();
                        }


                    });
                    $('.estimatingItemsTable').each(function(){
                    var $table = $(this);
                  
                    $table.find('tr').each(function(row, tr){
                        if(row>0){
                            
                            if(!$(tr).hasClass('has_item_value')){
                                $(tr).show();
                            }
                                
                            
                        }
                    });
                    
                });

                $('.has_template_saved_items').each(function(){
                    var $table = $(this);
                  
                    $table.find('tr').each(function(row, tr){
                        if(row>0){
                            
                            if(!$(tr).hasClass('has_item_value')){
                                $(tr).show();
                            }
                                
                            
                        }
                    });
                    
                });
            }

        })


        function hasDupes(array) {
                var hash = Object.create(null);
                return array.some(function (a) {
                    return a.value && (hash[a.value] || !(hash[a.value] = true));
                });
            }

$(document).on("click",'#estimationFieldsTable input[type="radio"]',function(event) {
    
    var postData = $("#estimationFieldsForm").serializeArray();
    if(hasDupes(postData)){
        event.preventDefault();
        swal('','This field has already been assigned');
        return false;
    }
});

 $(document).on("click",'#estimationFieldsTable input[type="radio"]',function(event) {

    var previousValue = $(this).data('val');

    if (previousValue) {
    $(this).prop('checked', !previousValue);
    $(this).data('val', !previousValue);
    }
    
    else{
    $(this).data('val', true);
    $("input[type=radio]:not(:checked)").data("val", false);
    }
});

// Disposal load calculation
$(document).on('change',".cal_per_load_checkbox",function() {
        if($(this).prop("checked")){
            $('.cal_per_load_input').show();
            $('.total_load').show();
        } else if($(this).prop("checked", false)){
            $('.cal_per_load_input').hide();
            $('.total_load').hide();
            $('.cal_disposal_load_input').val(0);
            $('.cal_per_load_input').val(0);
            calculate_concrete_measurement();
        } else{
            $('.cal_per_load_input').val(0);
            $('.cal_disposal_load_input').val(0);
        }
    });
$(document).on('keyup', ".cal_per_load_input", function(){
    var preLoad = parseFloat(cleanNumber($('.cal_per_load_input').val()));
    var cubicYard = parseFloat($('#concrete_area').html());
    var disposalTotal = (cubicYard/5)*preLoad;
    $('.cal_disposal_load_input').val(disposalTotal);
    calculate_concrete_measurement();
});
$(document).on('keyup', ".cal_disposal_load_input", function(){
    calculate_concrete_measurement();
});

// Disposal load calculation
$(document).on('change',".cal_disposal_checkbox",function() {
    custom_price_total = false;
        if($(this).prop("checked")){
            $('.cal_disposal_input,.per_load,.disposalTotalAmount').show();
            
        } else{
            $('.cal_disposal_input').hide();
            $('.per_load').hide();
            $('.disposalTotalAmount').hide();
            $('.cal_total_disposal_amount').text(0);
            $('.cal_disposal_per_load_input').val(<?= $settings->getDisposalLoad();?>);
        }
        calculate_concrete_measurement();
    }); 
$(document).on('keyup', ".cal_disposal_input", function(){
    custom_price_total = false;
    var Load = parseFloat($(this).val());
    var perLoad = parseFloat(cleanNumber($('.cal_disposal_per_load_input').val()));
    if(perLoad > 0 && Load > 0){
     
        //$('.cal_total_disposal_amount').html(addCommas(number_test(perLoad*Load)));
        calculate_concrete_measurement(true);
    }
});

$(document).on('keyup', ".cal_disposal_per_load_input", function(){
    custom_price_total = false;
    var perLoad = parseFloat(cleanNumber($(this).val()));
    var Load = parseFloat($('.cal_disposal_input').val());
    if(perLoad > 0 && Load > 0){
        //$('.cal_total_disposal_amount').html(addCommas(number_test(perLoad*Load)));
        calculate_concrete_measurement(true);
    }
});



$('a.update_itam_unit_price_btn').click(function (){
        $('#'+phase_id).find('.cssloader').show();
                swal({
                    title: 'Saving..',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    timer: 2000,
                    onOpen: () => {
                    swal.showLoading();
                    }
                });
                var total_val = $('.service_total_input').val();
                total_val = total_val.replace(/[$,]/g, '');
                var proposal_service_id = $('#get_service_id').val();
                var old_total_val = $('#old_total_val_save').val();
                old_total_val = old_total_val.replace(/[$,]/g, '');
                var difference = Math.abs(total_val-old_total_val);
                var percent = (2/100)*old_total_val;
                var min = 20;
                if(percent > min)
                    {
                        min  = percent;
                    }            
                if(parseInt(min)<=parseInt(difference) || difference==0) {
                  //  console.log("old_total_val11",old_total_val);
                   // console.log("total_val2",'.old_total_val_save'+proposal_service_id);
                    $('.old_total_val_save'+proposal_service_id).val(old_total_val);
                    $('.service_total_'+proposal_service_id).val(old_total_val);
                   swal({
                         title: "Warning",
                         text: "You can not round off more than 2 % off service total"
                        })
                        return false;
                   }
                 else{
                             $.ajax({
                            type: "POST",
                            url: "/ajax/totalRoundOff", 
                            data: {total_val: total_val, old_total_val:old_total_val, proposal_service_id: proposal_service_id, phase_id: phase_id},
                            dataType: "text",  
                            cache:false,
                            success: 
                            function(data){
                                    revert_adjust_price1();
                                    get_service_item_list_by_phase_id(); 
                                    get_proposal_breakdown();
                                    revert_adjust_price();
                                    swal(
                                        'Service Price Updated',
                                        ''
                                    );
                                    // update active tab data
                                        $.ajax({
                                                    type:"POST",
                                                    url:"<?php echo site_url('ajax/phaseEstimateItems') ?>/"+proposal_service_id+'/'+phase_id,
                                                    data:[],
                                                    async:false
                                                }).success(function(data) {
                                                    if($(data).find('table').length >0){
                                                        $("#serviceItemsSummaryContent").html(data);
                                                    }else{
                                                        $("#serviceItemsSummaryContent").html('<p class="adminInfoMessage templateInfoMsg" style="display: block;"><i class="fa fa-fw fa-info-circle"></i> No items added to estimate for this phase.</p>');
                                                    }
                                                    $("#old_total_val_save").val(total_val);
                                                });
                                                //update active tab data close
                                }
                        }); 
                        } 
               return false; 
        });
        
</script>