<?php
//print($this->session->userdata('accFilterFrom'));
//print_r( ($this->session->userdata('accFilterFrom')) ? date('m/d/Y', strtotime($this->session->userdata('accFilterFrom'))) : '');
//die;
$this->load->view('global/header');?>
<style>
    #user_stats_table_wrapper{
        position: relative;
        float: left;
    }
    #user_status_stats_table_wrapper{
        position: relative;
        float: left;
    }
    #user_stats_table_wrapper .fg-toolbar{
        display: none;
    }
    #user_status_stats_table_wrapper .fg-toolbar{
        display: none;
    }
    .business_table_breakdown{color:#000!important}
    .active_section{color:#25AAE1!important}
</style>
<?php /* @var $clientAccount \models\ClientCompany */?>
    <div id="content" class="clearfix">
        <div class="widthfix">

            <h3 style="width:950px; float: left; margin-bottom: 5px;">
                Account Info: <span  style="font-weight:100"><?php echo $clientAccount->getName(); ?></span>
            </h3>

            <?php $this->load->view('templates/accounts/info-filters-new');?>
            <div class=" account-datepickers">

                <select name="preset" id="preset">
                    <option value="ytd">Year to Date (default)</option>
                    <option value="custom">Custom</option>
                    <option value="yesterday">Yesterday</option>
                    <option value="last7d">Last 7 Days</option>
                    <option value="monthtd">Month to Date</option>
                    <option value="prevmonth">Previous Month</option>
                    <option value="prevyear">Previous Year</option>
                    <option value="all">All Time</option>
                </select>

                <input class="text hide is_custom_selected" type="text" name="from" id="from" value="<?php echo ($this->session->userdata('accFilterFrom')) ? date('m/d/Y', strtotime($this->session->userdata('accFilterFrom'))) : '' ?>">
                <input class="text hide is_custom_selected" type="text" name="to" id="to" value="<?php echo ($this->session->userdata('accFilterTo')) ? date('m/d/Y', strtotime($this->session->userdata('accFilterTo'))) : '' ?>">
                <input type="button" value="Apply" id="apply" class="inline-form-button hide is_custom_selected">
                <input type="button" value="Reset" id="reset" class="inline-form-button hide">
                <p style="float:right;font-size:15px;margin-right:15px;margin-top: 4px;font-weight:bold"><i class="fa fa-fw fa-calendar"></i> <span class="show_from_date"><?php echo ($this->session->userdata('accFilterFrom')) ? date('m/d/Y', strtotime($this->session->userdata('accFilterFrom'))) : '' ?></span> - <span class="show_to_date"><?php echo ($this->session->userdata('accFilterTo')) ? date('m/d/Y', strtotime($this->session->userdata('accFilterTo'))) : '' ?></span></p>
            </div>

            <div style="width: 238px; float: right; padding-top: 5px;">
                <input type="hidden" id="accountId" value="<?php echo $clientAccount->getId(); ?>"/>
                <input type="hidden" id="defaultStart" value="<?php echo $time['defaultStart']; ?>"/>
                <input type="hidden" id="defaultFinish" value="<?php echo $time['defaultFinish']; ?>"/>
            </div>



            <div class="clearfix"></div>


            <div id="accountInfoTabs">
            <div id="businessTypesTableLoader" style="width: 150px;top: 8px;position: absolute;margin-left: 750px;display: none;">
                <img src="/static/blue-loader.svg" />
            </div>
            <a href="<?php echo site_url('proposals/stats/' . $clientAccount->getId());?>" style="margin-top: 2px;" class="btn right blue-button view_Account_proposal_btn" >View Account Proposals</a>
                <ul>
                    <li><a href="#stats">Stats</a></li>
                    <li><a href="#timeline">Timeline</a></li>
                    <li><a href="#events">Events</a></li>
                    <li><a href="#user-stats">User Stats</a></li>
                    <li><a href="#business_types">Business Types</a></li>
                    <li><a href="#year_to_year">Year To Year</a></li>
                    <!--<li><a href="#proposals">Proposals</a></li>-->
                </ul>

                <div id="stats">

                    <div id="noPieData" style="display: none;">
                        <p>No data available for this time period!</p>
                    </div>

                    <div style="width: 500px; float: left">
                        <div id="accountInfoPie"></div>
                    </div>

                    <div style="width: 350px; float: right;">

                        <div class="content-box">

                            <div class="box-header">Account Stats</div>

                            <div class="box-content accountStats" style="padding: 10px;">


                            </div>


                        </div>


                    </div>

                    <div class="clearfix"></div>
                </div>

                <div id="timeline">
                    <div style="width: 300px; float: right">
                        <!-- <a class="btn update-button" href="/accounts/proposals/<?php echo $clientAccount->getId(); ?>"
                           style="float: right">View Account Proposals</a> -->
                    </div>
                    <h4 style="width: 600px; float: left;">Account Timeline</h4>

                    <table class="display" id="accountTimelineTable">
                        <thead>
                        <tr>
                            <td>Status</td>
                            <td>< 30 Days Value</td>
                            <td>< 30 Days</td>
                            <td>30 - 60 Days Value</td>
                            <td>30 - 60 Days</td>
                            <td>60 - 90 Days Value</td>
                            <td>60 - 90 Days</td>
                            <td>90+ Days Value</td>
                            <td>90+ Days</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
$statusObject = [];
$i = 0;
foreach ($timelineStatuses as $status) {

    $statusObject[$i]['status_name'] = $status->getText();
    $statusObject[$i]['status_color'] = $status->getColor();
    $i++;
    ?>
                            <tr>
                                <td><?php echo $status->getText(); ?></td>
                                <td><?php echo $statusData[$status->getStatusId()]['under30']['value']; ?></td>
                                <td>
                                    <a href="<?php echo site_url('accounts/timeline/' . $clientAccount->getId() . '/' . $status->getStatusId() . '/under30') ?>">$<?php echo $statusData[$status->getStatusId()]['under30']['readable']; ?></a>
                                </td>
                                <td><?php echo $statusData[$status->getStatusId()]['30to60']['value']; ?></td>
                                <td>
                                    <a href="<?php echo site_url('accounts/timeline/' . $clientAccount->getId() . '/' . $status->getStatusId() . '/30to60') ?>">$<?php echo $statusData[$status->getStatusId()]['30to60']['readable']; ?></a>
                                </td>
                                <td><?php echo $statusData[$status->getStatusId()]['60to90']['value']; ?></td>
                                <td>
                                    <a href="<?php echo site_url('accounts/timeline/' . $clientAccount->getId() . '/' . $status->getStatusId() . '/60to90') ?>">$<?php echo $statusData[$status->getStatusId()]['60to90']['readable']; ?></a>
                                </td>
                                <td><?php echo $statusData[$status->getStatusId()]['over90']['value']; ?></td>
                                <td>
                                    <a href="<?php echo site_url('accounts/timeline/' . $clientAccount->getId() . '/' . $status->getStatusId() . '/over90') ?>">$<?php echo $statusData[$status->getStatusId()]['over90']['readable']; ?></a>
                                </td>
                            </tr>
                        <?php }?>
                        </tbody>
                    </table>

                </div>

                <!--
                <div id="proposals">
                    Proposals Table Here
                </div>
                -->

                <div id="events" style="padding: 10px 0;">
                    <?php $this->load->view('templates/events/table');?>
                </div>

                <div id="user-stats" style="padding: 10px 0;min-height:415px">
                    <div id="selectedUserInfo" style="display: none;">
                        <p style="position: absolute;width: 98%;"><a href="javascript:void(0);" onclick="loadUserStatsPie()" class="btn right"><i class="fa fa-chevron-left"></i> Back </a></p>
                        <input type="hidden" id="selected_user_id" >
                    </div>

                    <div id="noUserStatsPieData" style="display: none;">
                        <p>No data available !</p>
                    </div>


                    <div style="width: 65%; float: left;margin-left: 20px;margin-top: 35px;">
                        <h4 style="margin:0px">User Breakdown</h4>
                        <table id="user_stats_table" class="display " style="border-collapse: collapse!important;display:none;width: 580px; float: left">
                            <thead>
                                <tr>
                                    <th>User Name</th>
                                    <th>Proposals</th>
                                    <th>Amount</th>
                                    <th><a href="javascript:void(0);" class="tiptip" title="Total Value of proposals that have a 'Won' status. This includes Completed, Invoiced etc.<br/><br/>This value excludes duplicate proposals">Won</a></th>
                                    <th><a href="javascript:void(0);" class="tiptip" title="Percentage of Total Amount Bid that was Won.<br/><br/>This value excludes duplicate proposals">Win Rate </a></th>
                                </tr>
                            </thead>
                        </table>
                        <span style="margin-top: 20px;font-weight: bold;font-size: 16px;float: left;display: inline;display: none;" class="selectedUserName"></span>
                        <table id="user_status_stats_table" class="display " style="border-collapse: collapse!important;display:none;width: 580px; float: left">
                            <thead>
                                <tr><th>Status</th><th>Proposals</th><th>Total Bid</th></tr>
                            </thead>
                        </table>
                    </div>
                    <div style="width: 35%; float: left;margin-top: 53px;padding-left: 50px;">
                        <span style="right: 115px;font-weight: bold;position: absolute;top: 81px;font-size: 16px;display: none;" class="selectedUserName"></span>
                        <div id="accountUserStatsPie"></div>
                        <div id="accountAllUserStatsPie"></div>
                    </div>
                </div>

                                    <!-- start business types tab-->

                    <div id="business_types" style="padding-top: 5px;">
                        <div class="box-content">
                        <div style="padding:0px 0px 15px 0px;color:#000">
                            <a href="javascript:void(0);" data-val="table" class="btn update-button business_table_breakdown active_section" style="font-size:12px;width:100px" ><i class="fa fa-fw fa-table"></i> Table</a> 
                            <a href="javascript:void(0);" data-val="breakdown" class="btn business_table_breakdown" style="font-size:12px;width:100px"><i class="fa fa-fw fa-pie-chart"></i> Breakdown</a>
                        </div>
                            
                            <div id="business_types_table">
                                <table cellpadding="0" cellspacing="0" border="0" class="dataTables-business-types display" style="display:none"
                                       id="businessTypesTable">
                                    <thead>
                                    <tr>
                                        <td>Business Type</td>
                                        <td>Proposals</td>
                                        <td>Total Bid</td>
                                        <td>Open </td>
                                        <td><a href="javascript:void(0);" class="tiptip" title="Total Value of proposals that are not Open and have not been Won.<br/><br/>This value excludes duplicate proposals">Other</a></td>
                                        <td><a href="javascript:void(0);" class="tiptip" title="Total Value of proposals that have a 'Won' status. This includes Completed, Invoiced etc.<br/><br/>This value excludes dupliate proposals">Won</a></td>
                                        <td><a href="javascript:void(0);" class="tiptip" title="Percentage of Total Amount Bid that was Won.<br/><br/>This value excludes duplicate proposals<br/><br/>Note: This does not include sales that were bid outside of the selected time period">W/R</a></td>

                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="breakdown_box hide" >

                                <div style="width: 50%;float:left">
                                    <p style="float:left;">Bid Breakdown</p>
                                    <div style="margin-top: 20px;" id="userBusinessTypePie"></div>
                                    <p style="float:left;">Sales Breakdown</p>
                                    <div style="margin-top: 20px;" id="userSalesBusinessTypePie"></div>
                                </div>
                                <div style="width: 50%;float:left" id="table_div">
                                    <p style="float:left;">Breakdown Table</p>
                                    <table id="business_type_breakdown_table" class="display " style="border-collapse: collapse!important;width: 100%; float: left">
                                        <thead>
                                        <tr><th>Business Type</th><th>Bid %</th><th>Bid</th><th>Win %</th><th>Win</th><th>+/-</th></tr>
                                        </thead>
                                    </table>

                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- end business types tab -->

                <div id="year_to_year" style="padding: 10px 0;">






                    <div style="width: 98%; float: left;padding-left: 10px;">
                        <div >
                            <a class="btn right chart_type" id='b2' style="margin-left: 5px;"><i class="fa fa-fw fa-line-chart" ></i> Line</a>
                            <a class="btn right  chart_type" id='b1'><i class="fa fa-fw fa-bar-chart"></i> Column</a>
                        </div>
                        <div id="accountYearToYearstats" style="margin-top: 30px;"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
    var hTable;
    var stTable;
    var btTable;
    var btBreakTable;
        google.charts.load('current', {'packages': ['corechart','bar','line']});
        //google.charts.setOnLoadCallback(loadAccountInfoStats);
        google.charts.setOnLoadCallback(loadYearStatsBar);
        var statusObject = <?=json_encode($statusObject);?>;

        $(document).on('ready', function () {

            var start = moment($("#from").val()).toDate();
            var finish = moment($("#to").val()).toDate();
            
                //dropdown
            $("#preset").on("change", function () {
                setDates();
            });

            $("#reset").on('click', function() {
                $("#preset").val('ytd');
                $.uniform.update();
                setDates();
            });
            $("#accountInfoTabs").tabs({
                activate: function (event, ui) {
                    var selectedTab = ui.newTab.index();
                    if(hasLocalStorage){
                        localStorage.setItem('selectedTab', selectedTab);
                    }
                    if(selectedTab==3){
                        $('#user-stats').css('display','flex')
                    }
                    if(selectedTab==4){
                        if(btTable){
                        btTable.columns.adjust();
                        }
                    }
                    if(selectedTab==5){
                        $('#year_to_year').css('display','flex');
                        $('#b1').trigger('click');
                    }
                }
            });

            // if (localStorage.getItem('selectedTab')) {
            //     $("#accountInfoTabs").tabs('option', 'active', localStorage.getItem('selectedTab'));
            // }

            $("#accountTimelineTable").dataTable({
                "bFilter": false,
                "bStateSave": true,
                "bJQueryUI": true,
                "bPaginate": false,
                "iDisplayLength": -1,
                "aaSorting": [[2, "desc"]],
                "aoColumns": [
                    {"sWidth": "200px"},                        // 0  Status
                    {"bVisible": false, "type": "num"},         // 1 Under 30 value
                    {"sClass": "dtCenter", "iDataSort": 1},     // 2 Under 30 readable
                    {"bVisible": false, "type": "num"},         // 3 30 to 60 value
                    {"sClass": "dtCenter", "iDataSort": 3},                           // 4 30 to 60 readable
                    {"bVisible": false, "type": "num"},         // 5 60 to 90 value
                    {"sClass": "dtCenter", "iDataSort": 5},                           // 6 60 to 90 readable
                    {"bVisible": false, "type": "num"},         // 7 Over 90 value
                    {"sClass": "dtCenter", "iDataSort": 7}                            // 8 Over 90 readable
                ]
            });

            //loadYearStatsBar();

        });   



        function applyAccountInfoFilter() {

            var from = $("#from").val();
            var to = $("#to").val();

            $.ajax({
                type: "POST",
                url: '<?php echo site_url('ajax/setAccountInfoFilter') ?>',
                data: {
                    accInfoFilterFrom: from,
                    accInfoFilterTo: to
                },
                dataType: 'JSON',
                success: function (data) {
                    loadAccountInfoStats();
                }
            });

        }

        function resetAccountInfoFilter() {

            $("#from").val($("#defaultStart").val());
            $("#to").val($("#defaultFinish").val());

            $.ajax({
                type: "POST",
                url: '<?php echo site_url('ajax/resetAccountInfoFilter') ?>',
                data: {},
                dataType: 'JSON',
                success: function (data) {
                    
                    loadAccountInfoStats();
                }
            });
        }

        function loadAccountInfoStats() {
            $("#businessTypesTableLoader").show();
            $(".view_Account_proposal_btn").hide();
            $.ajax({
                type: "POST",
                url: '<?php echo site_url('ajax/accountInfoStatsNew') ?>',
                data: {
                    accountId: $("#accountId").val(),
                    from: $("#from").val(),
                    to: $("#to").val()
                },
                dataType: 'JSON',
                success: function (data) {
                    // accountStats
                    var accountStats = '';
                    for($i=0;$i<data.length;$i++){
                        accountStats += '<div class="accountStatRow">'+
                                            '<div class="accountStatText">'+data[$i][0]+
                                            '</div>'+

                                            '<div class="accountStatPrice">'+data[$i][2]+
                                            '</div>'+

                                            ' <div class="accountStatValue">'+data[$i][1]+
                                            '</div>'+

                                            '<div class="clearfix"></div>'+
                                        '</div>';
                    }

                    //accountStats +='<a class="btn update-button" href="/accounts/proposals/<?php echo $clientAccount->getId(); ?>">View Account Proposals</a>';
                    $('.accountStats').html(accountStats);
                    initButtons();
                    initTiptip();
                   
                }
            });
            loadInfoPie();
            loadUserStatsPie();
            if(hTable){
                    hTable.ajax.reload(null,false );
                }else{
                    initial_load_table();
                }
                
            if(btTable){
               
                btTable.ajax.reload(null,false );
            }else{
                
                initial_bt_table();
            }
                
        }

        function loadInfoPie() {

            var jsonData = $.ajax({
                url: "/ajax/accountInfoPie",
                dataType: "json",
                async: false,
                data: {
                    accountId: $("#accountId").val(),
                    from: $("#from").val(),
                    to: $("#to").val()
                },
                type: 'post',
                cache: false
            }).responseText;

            data = JSON.parse(jsonData);

            if (!data.empty) {
                var Trows = data.table.rows;
                var colorArray = [];
                for($i=0;$i<Trows.length;$i++){
                    var found_color = $.grep(statusObject, function(v) {
                            return v.status_name === Trows[$i].c[0].v;
                        });
                        colorArray.push(found_color[0].status_color);
                }

                $("#noPieData").hide();
                $("#accountInfoPie").show();

                // Create our data table out of JSON data loaded from server.
                var data = new google.visualization.DataTable(data.table);

                var formatter = new google.visualization.NumberFormat(
                    {prefix: '$', pattern: '#,###,###'});
                formatter.format(data, 1); // Apply formatter to second column

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.PieChart(document.getElementById('accountInfoPie'));

                // Pie Chart Options
                var options = {
                    width: 450,
                    height: 400,
                    colors: colorArray,
                    chartArea: {
                        width: '90%',
                        height: '90%'
                    },
                    sliceVisibilityThreshold: 0,
                    pieSliceText: 'none',
                    pieHole: 0.1,
                    legend: {
                        position: 'right',
                        maxLines: 3,
                        alignment: 'center'
                    },
                    animation: {
                        startup: true
                    }

                };

                chart.draw(data, options);
            }
            else {
                $("#accountInfoPie").hide();
                $("#noPieData").show();
            }
        }


        function loadUserStatsPie() {
            $('#selectedUserInfo').hide();
            $('.selectedUserName').hide();
            $('#accountUserStatsPie').hide();
            $('#user_status_stats_table').hide();
            var jsonData = $.ajax({
                url: "/ajax/accountAllUserStatsPie",
                dataType: "json",
                async: false,
                data: {
                    accountId: $("#accountId").val(),
                    from: $("#from").val(),
                    to: $("#to").val()
                },
                type: 'post',
                cache: false
            }).responseText;

                     data = JSON.parse(jsonData);
            if (!data.empty) {
                var Trows = data.table.rows;
                var colorArray = [];
                
                $("#noUserStatsPieData").hide();
                $("#accountAllUserStatsPie").show();



                // Create our data table out of JSON data loaded from server.
                var data = new google.visualization.DataTable(data.table);

                var formatter = new google.visualization.NumberFormat(
                    {prefix: '$', pattern: '#,###,###'});
                formatter.format(data, 1); // Apply formatter to second column

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.PieChart(document.getElementById('accountAllUserStatsPie'));

                // Pie Chart Options
                var options = {
                    width: 260,
                    height: 320,
                    chartArea: {
                        left:10,
                        top:0,
                        width: '90%',
                        height: '82%'

                    },

                    sliceVisibilityThreshold: 0,
                    pieSliceText: 'none',
                    pieHole: 0.1,
                    legend: 'none',
                    animation: {
                        startup: true
                    }
                };

                chart.draw(data, options);
            }
            else {
                $("#accountAllUserStatsPie").hide();
                $("#accountUserStatsPie").hide();
                $("#noUserStatsPieData").show();
            }

        }

function initial_load_table(){


        hTable = $('#user_stats_table').DataTable({
                    "processing": true,
                    "serverSide": true,
                    "searching":false,
                    "lengthChange":false,
                    "paging":false,
                    "info":false,
                    "ajax": {
                            url: "<?php echo site_url('ajax/accountUserStatsTable') ?>",
                            data: function(d) {
                                d.accountId = $("#accountId").val();
                                d.from = $("#from").val();
                                d.to = $("#to").val();
                            }
                        },
                    "sorting": [
                        [2, "desc"]
                    ],
                    "columns": [
                        {width: '30%',class: 'dtLeft',sortable:false},                                            // 3 Branch
                        {width: '15%',class: 'dtCenter'},                                            // 4 Readable status
                        {width: '20%',class: 'dtLeft'},                              // 5 Status Link
                        {width: '17%',class: 'dtLeft'},
                        {width: '18%',class: 'dtLeft'}

                    ],
                    "jQueryUI": true,
                    "autoWidth": true,
                    "stateSave": false,
                    "paginationType": "full_numbers",
                    "dom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop">fl>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"pir>',
                });
                $('#user_stats_table').show();
}

function initial_bt_table(){
    btTable = $('.dataTables-business-types').on('error.dt', function (e, settings, techNote, message) {
            console.log('An error has been reported by DataTables: ', message);
            //$("#datatablesError").dialog('open');

        })
            .on('processing.dt', function (e, settings, processing) {
                if (processing) {
                    //$("#businessTypesTableLoader").show();
                } else {
                    $("#businessTypesTableLoader").hide();
                    $(".view_Account_proposal_btn").show();
                }
            })
            .DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "<?php echo site_url('ajax/ajaxGetAccountBusinessTypes').'/'.$clientAccount->getId(); ?>",
                "columnDefs": [

                    {
                        "targets": [0],
                        "sortable": true,
                        "width":'29%'
                    },

                    {"targets": [1],"width":'8%', "sortable": true,'class': 'dtCenter'},
                    {"targets": [2],"width":'11%', "sortable": true, },
                    {"targets": [3],"width":'10%', "sortable": true,},
                    {"targets": [4],"width":'10%', "sortable": true},
                    {"targets": [5],"width":'10%', "sortable": true},
                    {"targets": [6], "width":'12%',"sortable": true},

                ],
                "sorting": [
                    [2, "desc"]
                ],
                "jQueryUI": true,
                "autoWidth": false,
                "stateSave": true,
                "scrollY": "70vh",
                "scrollCollapse": true,
                "paginationType": "full_numbers",
                "dom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop">fl>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"pir>',
                "lengthMenu": [
                    [10, 25, 50, 100, 200, 500, 1000],
                    [10, 25, 50, 100, 200, 500, 1000]
                ],
                "preDrawCallback": function( settings ) {

                    if ($.fn.DataTable.isDataTable('.dataTables-business-types')) {
                        var dt2 = $('.dataTables-business-types').DataTable();

                        //Abort previous ajax request if it is still in process.
                        var settings = dt2.settings();
                        if (settings[0].jqXHR) {
                            settings[0].jqXHR.abort();
                        }
                    }
                },
                "drawCallback": function(){
                    initTiptip();

                    loadAccountBusinessTypePie();
                    loadAccountSalesBusinessTypePie();
                    
                    //accTable.columns().adjust();
                    if(btTable){
                        btTable.columns.adjust();
                    }
                    if(btBreakTable){
                       
                        btBreakTable.ajax.reload(null,false );
                    }else{
                        initial_business_breakdown_load_table();
                    }
                    

                }


            });
        $('.dataTables-business-types').show();
    

        
}

function initial_user_status_load_table(){


stTable = $('#user_status_stats_table').DataTable({
            "processing": true,
            "serverSide": true,
            "searching":false,
            "lengthChange":false,
            "paging":false,
            "info":false,
            "ajax": {
                    url: "<?php echo site_url('ajax/accountUserInfoTable') ?>",
                    data: function(d) {
                        d.accountId = $("#accountId").val();
                        d.from = $("#from").val();
                        d.to = $("#to").val();
                        d.user_id = $('#selected_user_id').val()
                    }

                },

            "columns": [
                {width: '40%',class: 'dtLeft'},                                            // 3 Branch
                {width: '35%',class: 'dtCenter'},                                            // 4 Readable status
                {width: '25%',class: 'dtLeft'},                              // 5 Status Link


            ],
            "sorting": [
                        [2, "desc"]
                    ],

            "jQueryUI": true,
            "autoWidth": true,
            "stateSave": false,
            "paginationType": "full_numbers",
            "dom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop">fl>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"pir>',
            "drawCallback": function(){
                initTiptip();
            }

        });

}

$(document).on('click','.user_name_stats',function(){
    $('#selected_user_id').val($(this).data('val'));
    loadUserInfoPie($(this).data('val'));
    $('#selectedUserInfo').show();
    $('.selectedUserName').show();
    $('.selectedUserName').text($(this).text());
    if(stTable){
        stTable.ajax.reload(null,false );
    }else{
        initial_user_status_load_table();
    }
    $('#user_status_stats_table').show();

});

function loadUserInfoPie(user_id) {
    $('#accountAllUserStatsPie').hide();
            var jsonData = $.ajax({
                url: "/ajax/accountUserInfoPie",
                dataType: "json",
                async: false,
                data: {
                    accountId: $("#accountId").val(),
                    user_id : user_id,
                    from: $("#from").val(),
                    to: $("#to").val()
                },
                type: 'post',
                cache: false
            }).responseText;

            data = JSON.parse(jsonData);
            if (!data.empty) {
                var Trows = data.table.rows;
                var colorArray = [];
                for($i=0;$i<Trows.length;$i++){
                    var found_color = $.grep(statusObject, function(v) {
                            return v.status_name === Trows[$i].c[0].v;
                        });
                        colorArray.push(found_color[0].status_color);
                }
                $("#noUserStatsPieData").hide();
                $("#accountUserStatsPie").show();



                // Create our data table out of JSON data loaded from server.
                var data = new google.visualization.DataTable(data.table);

                var formatter = new google.visualization.NumberFormat(
                    {prefix: '$', pattern: '#,###,###'});
                formatter.format(data, 1); // Apply formatter to second column

                // Instantiate and draw our chart, passing in some options.
                var chart = new google.visualization.PieChart(document.getElementById('accountUserStatsPie'));

                // Pie Chart Options
                var options = {

                    width: 260,
                    height: 320,
                    chartArea: {
                        left:10,
                        top:0,
                        width: '90%',
                        height: '82%'
                    },

                    colors: colorArray,
                    sliceVisibilityThreshold: 0,
                    pieSliceText: 'none',
                    pieHole: 0.1,
                    legend: 'none',
                    animation: {
                        startup: true
                    }
                };

                chart.draw(data, options);
            }
            else {
                $("#accountUserStatsPie").hide();
                $("#accountAllUserStatsPie").hide();
                $("#noUserStatsPieData").show();
            }

    }

    function loadYearStatsBar() {

        var jsonData = $.ajax({
            url: "/ajax/accountYearStatsBar",
            dataType: "json",
            async: false,
            data: {
                accountId: $("#accountId").val(),
                from: $("#from").val(),
                to: $("#to").val()
            },
            type: 'post',
            cache: false
        }).responseText;

        res = JSON.parse(jsonData);

    if(res){
            $("#noUserStatsPieData").hide();
            $("#accountYearToYearstats").show();

            var data = new google.visualization.DataTable(res.table);

            var formatter = new google.visualization.NumberFormat(
                        {prefix: '$', pattern: '#,###,###'});
                    formatter.format(data, 1);
            var formatter = new google.visualization.NumberFormat(
                        {prefix: '$', pattern: '#,###,###'});
                    formatter.format(data, 2);

            var options = {
                chart: {
                    title: 'Account Performance',
                    subtitle: 'Total Bid, Sold Bid',
                },
            bars: 'vertical',
            height: 400,
            width:930,
            // isStacked: true,
            colors: ['#1b9e77', '#d95f02']
            };

        // var chart = new google.visualization.ColumnChart(document.getElementById('accountYearToYearstats'));

        // chart.draw(data, options);
        if(localStorage.getItem('chart_type') == 'line') {
                drawLine();
                
            }else{
                drawBars();
            }
        
        //chart.setOptions(options);
     var barsButton = document.getElementById('b1');
     var lineButton = document.getElementById('b2');

            function drawBars() {
                var chart = new google.visualization.ColumnChart(document.getElementById('accountYearToYearstats'));
                chart.draw(data, options);
                if(hasLocalStorage){
                    localStorage.setItem('chart_type','bar');
                }
                $('.chart_type').removeClass('blue-button');
                $('#b1').addClass('blue-button');
            }

            function drawLine() {
                var chart = new google.visualization.LineChart(document.getElementById('accountYearToYearstats'));
                chart.draw(data, options);
                if(hasLocalStorage){
                    localStorage.setItem('chart_type','line');
                }
                $('.chart_type').removeClass('blue-button');
                $('#b2').addClass('blue-button');
            }

            barsButton.onclick = function () {
                
                drawBars();
            }

            lineButton.onclick = function () {
                
                drawLine();
            }
            

            }
            

        }

$(document).on('click','.chart_type22',function(){
    $('.chart_type').removeClass('blue-button');
    $(this).addClass('blue-button');

});
$(document).on('click','.business_table_breakdown',function(){
       $('.business_table_breakdown').removeClass('update-button');
           
            $(this).addClass('update-button');
        if($(this).attr('data-val')=='table'){
            $('#business_types_table').show();
            $('.breakdown_box').hide();
            btTable.columns.adjust();
        }else{
            $('#business_types_table').hide();
            $('.breakdown_box').css('display','flex');
        }
    });



function setDates() {
    var change = true;
    var from = moment().startOf('year').format('MM/DD/YYYY');
    var to = moment().format('MM/DD/YYYY');
    $('.account-datepickers p').show();
    switch ($("#preset").val()) {
        case "custom": //custom preset
            change = false;
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


    if (change) {
        $("#from").val(from);
        $("#to").val(to);
       
        $(".is_custom_selected").hide();

        $(".show_from_date").text(from);
        $(".show_to_date").text(to);

       ///add functions to refresh
       
    }else{
        $(".is_custom_selected").show();
        var temp_date = moment().format('MM/DD/YYYY');
        $("#from").val(temp_date);
        $("#to").val(temp_date);
        $(".show_from_date").text(temp_date);
        $(".show_to_date").text(temp_date);
    }
}

    function initial_business_breakdown_load_table(){


        btBreakTable = $('#business_type_breakdown_table').DataTable({
            "processing": true,
            "serverSide": true,
            "searching":false,
            "lengthChange":false,
            "paging":false,
            "info":false,
            "ajax": "<?php echo site_url('ajax/accountBusinessTypeBreakdownTable').'/'.$clientAccount->getId(); ?>",
            "columns": [
                {width: '30%',class: 'dtLeft'},                                            // 3 Branch
                {width: '25%',class: 'dtCenter',"iDataSort": 2},
                {width: '1%',class: 'dtCenter','visible':false}, //hide                                    // 4 Readable status
                {width: '25%',class: 'dtLeft',"iDataSort": 4},
                {width: '1%',class: 'dtLeft','visible':false,},//hide                           // 5 Status Link
                {width: '20%',class: 'dtLeft'},
            ],
            "sorting": [
                [2, "desc"]
            ],
            "jQueryUI": true,
            "autoWidth": true,
            "stateSave": false,
            "paginationType": "full_numbers",
            "dom": 'T<"clear"><"fg-toolbar ui-toolbar ui-widget-header ui-corner-tl ui-corner-tr ui-helper-clearfix"<"#groupSelectAllTop">fl>t<"fg-toolbar ui-toolbar ui-widget-header ui-corner-bl ui-corner-br ui-helper-clearfix"pir>',
            "drawCallback": function(){
                initTiptip();
            }
        });

    }

    function loadAccountBusinessTypePie() {

        var jsonData = $.ajax({
            url: "/ajax/businessTypeAccountInfoPie",
            dataType: "json",
            async: false,
            data: {
                accountId : "<?= $clientAccount->getId(); ?>",
                from: $("#from").val(),
                to: $("#to").val()
            },
            type: 'post',
            cache: false
        }).responseText;

        data = JSON.parse(jsonData);
        if (!data.empty) {
            var Trows = data.table.rows;



            // Create our data table out of JSON data loaded from server.
            var data = new google.visualization.DataTable(data.table);

            var formatter = new google.visualization.NumberFormat(
                {prefix: '$', pattern: '#,###,###'});
            formatter.format(data, 1); // Apply formatter to second column

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('userBusinessTypePie'));

            // Pie Chart Options
            var options = {

                width: 260,
                height: 260,
                chartArea: {
                    width: '90%',
                    height: '90%'
                },

                sliceVisibilityThreshold: 0,
                pieSliceText: 'none',
                pieHole: 0.1,
                legend: 'none',
                animation: {
                    startup: true
                }
            };

            chart.draw(data, options);
        }
        else {
            // $("#accountUserStatsPie").hide();
            // $("#noUserStatsPieData").show();
        }

    }

    function loadAccountSalesBusinessTypePie() {

        var jsonData = $.ajax({
            url: "/ajax/businessTypeSalesAccountInfoPie",
            dataType: "json",
            async: false,
            data: {
                accountId : "<?= $clientAccount->getId(); ?>",
                from: $("#from").val(),
                to: $("#to").val()
            },
            type: 'post',
            cache: false
        }).responseText;

        data = JSON.parse(jsonData);
        if (!data.empty) {
            var Trows = data.table.rows;



            // Create our data table out of JSON data loaded from server.
            var data = new google.visualization.DataTable(data.table);

            var formatter = new google.visualization.NumberFormat(
                {prefix: '$', pattern: '#,###,###'});
            formatter.format(data, 1); // Apply formatter to second column

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('userSalesBusinessTypePie'));

            // Pie Chart Options
            var options = {

                width: 260,
                height: 260,
                chartArea: {
                    width: '90%',
                    height: '90%'
                },

                sliceVisibilityThreshold: 0,
                pieSliceText: 'none',
                pieHole: 0.1,
                legend: 'none',
                animation: {
                    startup: true
                }
            };

            chart.draw(data, options);
        }
        else {
            // $("#accountUserStatsPie").hide();
            // $("#noUserStatsPieData").show();
        }

    }
    </script>

<?php $this->load->view('global/footer');?>
