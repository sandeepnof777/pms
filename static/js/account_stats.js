$(document).ready(function () {
    var run_loadYearAllStatsBar_function = false;
    var date_change = false;
    $("#apply").on("click", function () {
       // refreshStats();
       setDates();
    });
    //initial calculation
   // setDateRange();

    //dropdown pre-select
    $("#preset").val('ytd');
    $.uniform.update();

    //dropdown
    $("#preset").on("change", function () {
        date_change =true;
        if($("#preset").val() !='custom') {
            setDates();
            $(".is_custom_selected").hide();
        }else{
            $(".is_custom_selected").show();
        }

    });

    $("#reset").on('click', function() {
        $("#preset").val('ytd');
        $.uniform.update();
        setDates();
    });

    // Make the date field pickable
    $('#from').datepicker();
    $('#to').datepicker();

    $("#userStatTabs").tabs({
        activate: function (event, ui) {
            var selectedTab = ui.newTab.index();
            if(hasLocalStorage){
                localStorage.setItem('selectedTab', selectedTab);
            }
            setDateRange(function() {
            
                if(selectedTab==4){
                    $(".account-datepickers").css('visibility', 'hidden');
                    if(!run_loadYearAllStatsBar_function){
                        google.charts.setOnLoadCallback(loadYearAllStatsBar);
                        run_loadYearAllStatsBar_function = true;
                    }
                }else{
                    if(selectedTab==2){
                        if(accTable){
                            accTable.ajax.reload();
                        }
                        else{
                            
                                initAccountTable();
                            
                        }
                        
                        //accTable.columns.adjust();
                    }else if(selectedTab==3){
                        if(btTable){
                            btTable.ajax.reload();
                        }
                        else{
                            
                            //if(initialDateRangeSet){
                                initBtTable();
                            //}
                        }
                   // btTable.columns.adjust().draw(false);$($.fn.dataTable.tables(true)).DataTable().columns.adjust();
                    }else if(selectedTab==1){
                        
                            load_lead_data();
                    
                        
                    }else if(selectedTab==0){
                        
                        refreshStats();
                    }else if(selectedTab==5){
                    
                        updateStatusTable();
               
                    }
                    $(".account-datepickers").css('visibility', 'visible');

                }
            });
            }
        
        
        });

    if(localStorage.getItem('selectedTab')) {
        if(localStorage.getItem('selectedTab') != 0){
            $("#userStatTabs").tabs('option', 'active', localStorage.getItem('selectedTab'));
        }else{
            refreshStats(); 
        }
    }else{
        
        refreshStats();
    }

});

function setDates() {
    var change = true;
    var from = moment().startOf('year').format('MM/DD/YYYY');
    var to = moment().format('MM/DD/YYYY');
    $('.account-datepickers p').show();
    switch ($("#preset").val()) {
        case "custom": //custom preset
            //change = false;
            from = $("#from").val();
            to = $("#to").val();
            // $(".is_custom_selected").show();
            break;
        case 'yesterday':
            from = moment().subtract(1, 'days').format('MM/DD/YYYY');
            to = moment().subtract(1, 'days').format('MM/DD/YYYY');
            break;
        case "last7d": //last 7 days
            from = moment().subtract(7, 'd').format('MM/DD/YYYY');
            break;
        case "monthtd": //month to date
            date = new Date(), y = date.getFullYear(), m = date.getMonth();
            var dateFrom = new Date(y, m, 1);
            from = moment(dateFrom).format('MM/DD/YYYY');
            break;
        case "prevmonth": //previous month
            from = moment(dateFrom).subtract(1, 'months').startOf('month').format('MM/DD/YYYY');
            to = moment(dateFrom).subtract(1, 'months').endOf('month').format('MM/DD/YYYY');
            break;
        case "prevyear": //previous year
            from = moment(dateFrom).subtract(1, 'years').startOf('year').format('MM/DD/YYYY');
            to = moment(dateFrom).subtract(1, 'years').endOf('year').format('MM/DD/YYYY');
            break;
        case "all": //All Time
            from = '';
            to ='';
            $('.account-datepickers p').hide();
            break;
    }

    $("#from, #to").on('change', function () {
        //$("#preset").val('custom');
    });

    if (change) {
        $("#from").val(from);
        $("#to").val(to);
       
       // $(".is_custom_selected").hide();
        // var newTo = to.split("/");
        // newTo = newTo[0] + '/' + newTo[1] + '/' + newTo[2].slice(-2);
        // var newFrom = from.split("/");
        // newFrom = newFrom[0] + '/' + newFrom[1] + '/' + newFrom[2].slice(-2);
        $(".show_from_date").text(from);
        $(".show_to_date").text(to);
        
        setDateRange(function() {

            if($("#userStatTabs .ui-tabs-panel:visible").attr("id")=='business_types'){
                
                if($('.business_table_breakdown.update-button').attr('data-val')=='table'){
                     if(btTable){
                         btTable.ajax.reload();
                     }else{
                         initBtTable();
                     }
                }else{
                     loadUserBusinessTypePie();
                     loadUserSalesBusinessTypePie();
                     if(btBreakTable){
                         btBreakTable.ajax.reload();
                     }else{
                         initial_business_breakdown_load_table();
                     }
                }
             }else if($("#userStatTabs .ui-tabs-panel:visible").attr("id")=='accounts'){
                 if(accTable){
                     accTable.ajax.reload();
                 }else{
                     initAccountTable();
                 }
             }else if($("#userStatTabs .ui-tabs-panel:visible").attr("id")=='leads'){
                if(initialDateRangeSet){
                    load_lead_data();
                    
                }
               
            }else if($("#userStatTabs .ui-tabs-panel:visible").attr("id")=='proposals'){
             
            
                refreshStats();
            }else if($("#userStatTabs .ui-tabs-panel:visible").attr("id")=='statusTab'){
             
            
                updateStatusTable();
            }
            
            
        });
    } else{
       // $(".is_custom_selected").show();
        // var temp_date = moment().format('MM/DD/YYYY');
        // $("#from").val(temp_date);
        // $("#to").val(temp_date);
        // $(".show_from_date").text(temp_date);
        // $(".show_to_date").text(temp_date);
    }
}

function refreshStats() {
    
    $("#loading").show();
    $(".arrow1, .arrow2, .arrow3").hide();
    $(".show_from_date").text($("#from").val());
    $(".show_to_date").text($("#to").val());
    $.ajax({
        url: "/account/ajaxStats",
        type: "POST",
        dataType: "JSON",
        data: {
            from: $("#from").val(),
            to: $("#to").val(),
            accountId: $("#accountId").val()
        },
        success: function (data) {
            $("#loading").hide();
            $("#actual_win_rate").html(data.win_rate_readable + "%");
            $("#actual_amount_bid").html("$" + data.total_bid_readable);
            $("#win_rate_difference").html(data.win_rate_difference_readable + "%");
            $("#amount_bid").html("$" + data.amount_bid_readable);
            $("#amount_bid_difference").html("$" + data.amount_bid_difference_readable);
            $("#target_sales").html("$" + data.sales_target_readable);
            $("#actual_sales").html("$" + data.wonCompletedProposals_readable);
            $("#sales_difference").html("$" + data.wonCompletedProposals_difference_readable);
            /*Projections*/
            $("#projected_sales").html("$" + data.projected_sales);
            $("#required_win_rate").html(data.required_win_rate + "%");
            $("#proposals_per_week_current_levels").html("$" + data.proposals_per_week_current_levels);

            if (data.win_rate_difference >= 0) {
                $(".arrow1.arrow-up").show();
            } else {
                $(".arrow1.arrow-down").show();
            }
            if (data.amount_bid_difference >= 0) {
                $(".arrow2.arrow-up").show();
            } else {
                $(".arrow2.arrow-down").show();
            }
            if (data.wonCompletedProposals_difference >= 0) {
                $(".arrow3.arrow-up").show();
            } else {
                $(".arrow3.arrow-down").show();
            }


   

        }
    });

    
}

function load_lead_data(){
    //Leads stuff
    $.ajax({
        url: '/ajax/dashboardUserStats/leads',
        type: 'POST',
        dataType: 'JSON',
        data: {
            range: 'custom',
            user: 'user',
            customFrom: $("#from").val(),
            customTo: $("#to").val(),
            accountId: $("#accountId").val()
        }
    })
        .success(function (data) {
            
            /*Leads data*/
            $("#leadsCount").html(data.leadsCount);
            $("#leadsActive").html(data.leadsActive);
            $("#leadsConverted").html(data.leadsConverted);
            $("#leadsConvertedPercent").html(data.leadsConvertedPercent + '%');
            $("#leadsCancelled").html(data.leadsCancelled);
            $("#leadsNew").html(data.leadsNew);
            $("#leadsCurrent").html(data.leadsCurrent);
            $("#leadsOld").html(data.leadsOld);
            $("#leadsAvgConversion").html(data.leadsAvgConversion);

            $("#statsLoader").hide();
            initialDateRangeSet = true;
        });
}