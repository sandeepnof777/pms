  
<script type="application/javascript">
  $(document).ready(function(){
    var delayTimer;
    var baseUrl = window.location.origin +"/";

    var checkSalesManagerActive = "<?php echo $checkActive; ?>";
    var checkModifyPriceActive = "<?php echo $checkActiveModify;  ?>";

    $('.search-result-card2').hide();
    $(".account-setting-search").on("input", function() {
        clearTimeout(delayTimer);
        delayTimer = setTimeout(function() {
            performSearch();
        }, 300); // Adjust the delay time as needed (300 milliseconds in this example).
    });

    function performSearch() {
       // var search = $(".account-setting-search").val().toLowerCase();
        var search = $(".account-setting-search").val().toLowerCase().trim(); // Trim whitespace


        var arr2 = {
            'Company': {'company info': 'company_info', 'company video': 'company_videos', 'users': 'company_users', 'branches': 'branches', 'reports': 'reports', 'PrositeAudit': 'psa'},
            'Prospect Settings': {'Sources': 'prospect_settings', 'Ratings': 'prospect_rating_settings', 'Status': 'prospect_status_settings'},
            'Work': {'Work Order Addresses': 'company_workorder', 'Work Order Recipients': 'work_order_recipients', 'Scope of Work': 'company_services','Bid Approval': 'bid_approval'},
            'Business': {'Business Type': 'business_type_settings', 'Summary': 'company_info', 'Calendar / Events Settings': 'event_types','Logo': 'company_logo'},
            'Other': {'Legal': 'company_legal', 'Attachments': 'company_attachments', 'Foremen': 'foremen_list','Email Templates': 'company_email_templates','Exports':'export','Saved Filters':'proposal_filters'},
            'Proposal': {'Proposal Links': 'company_proposal_settings7', 'Proposal Statuses': 'company_proposal_statuses', 'Proposal Layout': 'company_proposal_sections','Automatic Re-Send': 'company_proposal_notifications','WorkOrder Layout': 'company_work_order_sections' ,'Layout Settings': 'company_proposal_settings3'},
            'Lead Settings': {'Lead Settings': 'lead_settings','Unassigned Leads Notifications': 'lead_settings','Lead Sources': 'lead_settings2'},
            'Layout Settings': {'Layout Settings': 'company_proposal_settings3', 'WorkOrder Layout': 'company_work_order_sections', 'Automatic Re-Send': 'company_proposal_notifications'},
            'Sales': {'Job': 'company_proposal_settings4','Custom Texts':'company_proposal_details','About Company':'company_proposal_settings2'},
            'Estimating': {'Estimating': 'estimating_settings', 'Estimating Reports': 'estimating_reports', 'Job Cost Reports': 'job_cost_reports',
                           'Estimating Settings': 'estimating_settings','Categories': 'estimating','Types': 'estimating_types','Item': 'estimating_items','Assemblies': 'estimating_templates', 'Plants': 'estimating_plants', 'Dumps': 'estimating_dumps','Subs': 'estimating_subs','Phases': 'estimating_phases'
                          },
            'QuickBooks': {'QuickBooks': 'qbsettings'},
            'Legal': {'Contract Copy': 'company_legal', 'Payment Term': 'company_legal2', 'Payment Default Days':'company_legal3'}, 
            'Email Templates': {'Proposal': 'company_email_templates', 'Lead': 'company_email_templates', 'Prospect':'company_email_templates', 'Client':'company_email_templates'}, 
            'Saved Filters': {'Proposal': 'proposal_filters', 'Client': 'proposal_filters', 'Account':'proposal_filters', 'Lead':'proposal_filters', 'Prospect':'proposal_filters'}, 
            'Layout Settings': {'Standard Layout': 'company_proposal_settings3', 'Cool Layout': 'company_proposal_settings', 'Custom Layout':'company_proposal_settings6', 'Layout Defaults':'company_proposal_settings5'}, 
            'Sales Targets': {'Company Default': 'sales_targets_config', 'User Targets': 'sales_targets_users_config', 'Sales Targets': 'sales_targets_config'}, 
            'Modify Price': {'Modify Price History': 'modify_prices_history', 'Modify Prices': 'modify_prices'}, 
            'Estimating Reports': {'Price Report': 'estimating_price_report','Material Report': 'estimating_material_report','Equipment Report': 'estimating_equipment_report','Labout Report': 'estimating_labor_report','Services Report': 'estimating_services_report' }, 
            'Exports': {'Home': baseUrl+'export#tabs-0','Prospects': baseUrl+'export#tabs-1','Leads': baseUrl+'export#tabs-2','Contacts': baseUrl+'export#tabs-3','Proposals': baseUrl+'export#tabs-4','History': baseUrl+'export#tabs-5','Services': baseUrl+'export#tabs-6','Saved Exports': baseUrl+'export#tabs-8','Account': baseUrl+'export#tabs-9' }, 
        }; 

        function customSearch(object, search) {
            return Object.entries(object).flatMap(function ([key, value]) {
                var matchingSubitems = Object.entries(value).filter(function ([subkey, subvalue]) {
                    return subkey.toLowerCase().includes(search);
                });

                if (matchingSubitems.length > 0) {
                    return [{ key: key, subitems: matchingSubitems }];
                }

                return [];
            });
        }

        var results = customSearch(arr2, search);
        var proposalSettingDiv = $(".filter-setting");
        var gridContainerDiv = $(".grid-container");
        proposalSettingDiv.empty();

        if (search.length > 0) {
            $(".grid-container").css("display", "none");

            if (results.length > 0) {
                 $('.search-result-card2').show();
                $(".filter-setting-error").hide();

                results.forEach(function (result) {
                    var card = $("<div class='card demo-card2' style='height: auto;margin-top:7px;'>");
                    var header = $("<div class='header'>").html("<p>" + result.key + "</p>");
                    var container = $("<ul class='container'>");

                    result.subitems.forEach(function ([subkey, subvalue]) {
                        if((subvalue=="sales_targets_config" && subkey=="Sales Targets" && checkSalesManagerActive==0) || (subvalue=="modify_prices" && subkey=="Modify Prices" && checkModifyPriceActive==0) || (subvalue=="company_proposal_notifications" && subkey=="Automatic Re-Send" && checkSalesManagerActive==0) )
                        {
                            if(subvalue=="modify_prices")
                            {
                                var listItem = $("<li>").html("<a style='opacity:0.6;' class='sales-targets-li modify-price-swal' href=''>" + subkey +"</a>");
                            }else{
                                var listItem = $("<li>").html("<a style='opacity:0.6;' class='sales-targets-li' href=''>" + subkey +"</a>");
                            }

                            if(subvalue=="company_proposal_notifications")
                            {
                                var listItem = $("<li>").html("<a style='opacity:0.6;' class='sales-targets-li modify-price-swal' href=''>" + subkey +"</a>");
                            }else{
                                var listItem = $("<li>").html("<a style='opacity:0.6;' class='sales-targets-li' href=''>" + subkey +"</a>");
                            }
                        }
                        else{
                            var listItem = $("<li>").html("<a target='_blank' href='" + subvalue + "'>" + subkey +"</a>");
                        }
                        
                        container.append(listItem);
                       
                    });

                    card.append(header).append(container);
                    proposalSettingDiv.append(card);
                });
            } else {
                $('.search-result-card2').hide();
                $(".filter-setting-error").show();
                $(".filter-setting-error").css("margin-top", "120px");
                $(".filter-setting-error").text("No matching results found.");
            }

            $('.search-result-card2').css("margin-left", "365px");
 
        } else {
            proposalSettingDiv.empty();
            gridContainerDiv.css("display", "block");
            $('.grid-container').show();
            $(".listResult").css("display", "none");
            $(".proposal-setting .card").css("float", "left");
            $(".proposal-setting .card").css("margin-left", "20px");
            $(".filter-setting-error").css("margin-top", "28px");
            $(".filter-setting-error").text("");
            $(".filter-setting-error").css("display", "block");
            $('.search-result-card2').hide();
           // $(".filter-setting-error").text("No matching results found2.");
        }
 

 $(".automatic-resend-li, .sales-targets-li, .modify-price-swal, .disabled-tab").click(function (e) {
    e.preventDefault();

    if ($(this).hasClass("modify-price-swal")) {
        swal({
            type: 'info',
            title: '<span style="font-size:24px;color:#545454">Modify Price Feature Disabled</span>',
            html: '<p>Please contact <a href="mailto:support@pavementlayers.com">support@pavementlayers.com</a> for the process and costs with activating this amazing feature.</p>',
            showCloseButton: true,
        });
    }
    else if ($(this).hasClass("campaigns")) {
        swal({
            type: 'info',
            title: '<span style="font-size:24px;color:#545454">Campaign Feature Disabled</span>',
            html: '<p>Please contact <a href="mailto:support@pavementlayers.com">support@pavementlayers.com</a> for the process and costs with activating this amazing feature.</p>',
            showCloseButton: true,
        });
    } else {
        swal({
            type: 'info',
            title: '<span style="font-size:24px;color:#545454">Sales Manager Feature Disabled</span>',
            html: '<p>Please contact <a href="mailto:support@pavementlayers.com">support@pavementlayers.com</a> for the process and costs with activating this amazing feature.</p>',
            showCloseButton: true,
        });
    }
});
    }



});



</script>



