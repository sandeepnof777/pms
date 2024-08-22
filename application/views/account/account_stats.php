<?php
/** @var $account \models\Accounts */
?>
<?php $this->load->view('global/header'); ?>
<style>
    .ui-widget .dataTable td {font-size: 12px !important;
    }
    #uniform-accountMasterCheck{width:0px;margin-right:0px}
    #uniform-accountMasterCheck span{right: auto;}
    #StatusStatsTable_filter label{float: left;}
    /* #StatusStatsTable_filter input{
        background: #ddd;
        color: #000;
        width: 150px;
        font-size: 12px;
        height: 14px;
        font-weight: 100;
        margin: 0px;
        border: 1px solid #888;
        box-shadow: none;
    } */
   

    table.dataTable tr.odd { background-color: #f9f9f9; }
    table.dataTable tr.even{ background-color: white;}
    div.google-visualization-tooltip { pointer-events: none;width: 160px!important;
    height: 115px!important; }
    #StatusStatsTable tr td:nth-child(2) {
        text-align: center;
    }
    #StatusStatsTable tr td:nth-child(3) {
        text-align: right;
    }
    #StatusStatsTable tr td:nth-child(4) {
        text-align: right;
    }
    #StatusStatsTable tr td:nth-child(5) {
        text-align: right;
    }
    #StatusStatsTable tr td {
       padding:5px;
    }
    #StatusStatsTable tbody tr:last-child() {
        display: none;
    }
    #StatusStatsTable tr th{
       text-align: center;
       font-size: 13px;
    }
</style>
<div id="content" class="clearfix">
    <div class="widthfix">
        <div class="content-box">
            <div class="box-header header-blue" style="text-shadow: none !important; color: #fff;">
                <span style="color: #000;">User Statistics:</span>
                <select id="user_account_select" class="dont-uniform" style="margin-top:-5px">
                    <?php
                    foreach ($sortedAccounts as $compAccount) {

                        ?>
                        <option value="<?php echo $compAccount->getAccountId(); ?>" <?php if($account->getAccountId()==$compAccount->getAccountId()){echo 'selected="selected"';}?>><?php echo $compAccount->getFullName(); ?></option>
                        <?php
                    }?>
                </select>


                <!--<span id="loading" class="right" style="color: #fff; font-weight: normal;">Processing... <i class="fa fa-spin fa-spinner" style="margin-top: 2px;"></i></span>-->
            </div>
            <div class="box-content" id="account-stats">

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

                    <input class="text hide is_custom_selected" type="text" name="from" id="from" value="<?= date('01/01/Y') ?>">
                    <input class="text hide is_custom_selected" type="text" name="to" id="to" value="<?= date('m/d/Y') ?>">
                    <input type="button" value="Apply" id="apply" class="inline-form-button hide is_custom_selected">
                    <input type="button" value="Reset" id="reset" class="inline-form-button hide">
                    <p style="float:right;font-size:15px;margin-right:15px;margin-top: 4px;font-weight:bold"><i class="fa fa-fw fa-calendar"></i> <span class="show_from_date"><?= date('01/01/y') ?></span> - <span class="show_to_date"><?= date('m/d/y') ?></span></p>
                </div>

                <div id="userStatTabs">
                    <ul>
                        <li><a href="#proposals">Proposal</a></li>
                        <li><a href="#leads">Leads</a></li>
                        <li><a href="#accounts">Accounts</a></li>
                        <li><a href="#business_types">Business Types</a></li>
                        <li><a href="#year_on_year">Year on Year</a></li>
                        <li><a href="#statusTab">Status</a></li>

                        <!--<li><a href="#statProjections">Projections</a></li>-->
                    </ul>

                    <div id="proposals">
                        <div>
                            <div class="clearfix" style="margin-bottom: 40px;">
                                <div class="left materialize" style="width: 345px; margin-top: 5px;" id="annual-targets">

                                    <div class="row">
                                        <div class="col s12">
                                            <ul class="collection with-header">
                                                <li class="collection-header"><h4>Annual Sales Targets</h4></li>
                                                <li class="collection-item">
                                                    <div>
                                                        Sales Target <span class="secondary-content badge new">$<?= readableValue($config['sales_target']) ?></span>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div>
                                                        Win Rate <span class="secondary-content badge new"><?= readableValue($config['win_rate']) ?>%</span>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div>
                                                        Must Bid <span class="secondary-content badge new">$<?= readableValue($config['bid_target']) ?></span>
                                                    </div>
                                                </li>
                                                <li class="collection-item">
                                                    <div>
                                                        Weeks/Year <span class="secondary-content badge new"><?= readableValue($config['weeks_per_year']) ?></span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>

                                    <!--
                                        <div class="title">Annual Sales Targets</div>


                                        <div class="clearfix statsRow">
                                            <div class="statsBox">
                                                <div class="statHead">Sales Target</div>
                                                <div class="statBody">$<?= readableValue($config['sales_target']) ?></div>
                                            </div>

                                            <div class="statsBox">
                                                <div class="statHead">Win Rate</div>
                                                <div class="statBody"><?= readableValue($config['win_rate']) ?>%</div>
                                            </div>
                                        </div>

                                        <div class="clearfix statsRow">
                                            <div class="statsBox">
                                                <div class="statHead">Must Bid</div>
                                                <div class="statBody">$<?= readableValue($config['bid_target']) ?></div>
                                            </div>

                                            <div class="statsBox">
                                                <div class="statHead">Weeks/Year</div>
                                                <div class="statBody"><?= readableValue($config['weeks_per_year']) ?></div>
                                            </div>
                                        </div>
                                        -->
                                </div>
                                <div class="right" style="width: 530px">
                                    <table width="100%" id="account-stats-table" cellspacing="5">
                                        <thead>
                                        <tr>
                                            <td class="white">&nbsp;</td>
                                            <td width="25%">Target</td>
                                            <td width="25%">Actual</td>
                                            <td width="25%">Difference</td>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td style="text-align: left;">
                                                Win Rate
                                                <i class="fa fa-arrow-up right arrow1 arrow-up" style="display: none;"></i>
                                                <i class="fa fa-arrow-down right arrow1 arrow-down" style="display: none;"></i>
                                            </td>
                                            <td class="stat"><?= $config['win_rate'] ?>%</td>
                                            <td class="stat"><span id="actual_win_rate">Loading...</span></td>
                                            <td class="stat">
                                                <span id="win_rate_difference">%</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left;">
                                                Total Bid
                                                <i class="fa fa-arrow-up right arrow2 arrow-up" style="display: none;"></i>
                                                <i class="fa fa-arrow-down right arrow2 arrow-down" style="display: none;"></i>
                                            </td>
                                            <td class="stat"><span id="amount_bid">Loading...</span></td>
                                            <td class="stat"><a href="<?php echo site_url('proposals/status/all/user/' . $account->getAccountId()); ?>"><span id="actual_amount_bid">Loading...</span></a></td>
                                            <td class="stat">
                                                <span id="amount_bid_difference">$</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left;">
                                                Sales
                                                <i class="fa fa-arrow-up right arrow3 arrow-up" style="display: none;"></i>
                                                <i class="fa fa-arrow-down right arrow3 arrow-down" style="display: none;"></i>
                                            </td>
                                            <td class="stat"><span id="target_sales">Loading...</span></td>
                                            <td class="stat"><a href="<?php echo site_url('proposals/status/sold/user/' . $account->getAccountId()); ?>"><span id="actual_sales">Loading...</span></a></td>
                                            <td class="stat">
                                                <span id="sales_difference">$</span>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>



                    <div id="leads">
                        <div class="materialize" id="leadStats">

                            <div class="row">
                                <div class="col s6">
                                    <ul class="collection">
                                        <li class="collection-item">
                                            <div>
                                                Active <span class="new badge" id="leadsActive"></span>
                                            </div>
                                        </li>
                                        <li class="collection-item">
                                            <div>
                                                New <span class="secondary-content badge new" id="leadsNew"></span>
                                            </div>
                                        </li>
                                        <li class="collection-item">
                                            <div>
                                                Current <span class="new badge" id="leadsCurrent"></span>
                                            </div>
                                        </li>
                                        <li class="collection-item">
                                            <div>
                                                Old <span class="new badge" id="leadsOld"></span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>

                                <div class="col s6">
                                    <ul class="collection">

                                        <li class="collection-item">
                                            <div>
                                                Converted <span class="secondary-content badge new" id="leadsConverted"></span>
                                            </div>
                                        </li>
                                        <li class="collection-item">
                                            <div>
                                                Canceled <span class="new badge" id="leadsCancelled"></span>
                                            </div>
                                        </li>
                                        <li class="collection-item">
                                            <div>
                                                Avg. Conversion Days <span class="secondary-content badge new" id="leadsAvgConversion"></span>
                                            </div>
                                        </li>
                                        <li class="collection-item">
                                            <div>
                                                % Converted <span class="secondary-content badge new" id="leadsConvertedPercent"></span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div id="accounts" style="padding-top: 5px;">
                        <div class="box-content">
                            <div class="materialize" style="height: 30px;">
                                <div class="m-btn groupAction tiptip" style="position: relative;float:left;margin-right: 10px;display:none" title="Carry out actions on selected contacts" id="groupActionsButton">
                                    <i class="fa fa-fw fa-check-square-o"></i> Group Actions
                                    <div class="groupActionsContainer materialize">
                                        <div class="collection groupActionItems" id="clientGroupActions">
                                            <a class="collection-item iconLink groupAction" id="groupMerge"><i class="fa fa-fw fa-compress"></i> Merge</a>

                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="accountsTableLoader" style="width: 150px;top: 8px;position: absolute;margin-left: 750px;display: none;">
                                <img src="/static/blue-loader.svg" />
                            </div>
                            <div id="company_table">
                                <table cellpadding="0" cellspacing="0" border="0" class="dataTables-companies display" style="display:none"
                                       id="accountTable">
                                    <thead>
                                    <tr>
                                        <td><input type="checkbox" id="accountMasterCheck"></td>
                                        <td>Company Name</td>
                                        <td>Contacts</td>
                                        <td>Proposals</td>
                                        <td>Total Bid</td>
                                        <td>Open </td>
                                        <td><a href="javascript:void(0);" class="tiptip" title="Total Value of proposals that are not Open and have not been Won.<br/><br/>This value excludes duplicate proposals">Other</a></td>
                                        <td><a href="javascript:void(0);" class="tiptip" title="Total Value of proposals that have a 'Won' status. This includes Completed, Invoiced etc.<br/><br/>This value excludes dupliate proposals">Won</a></td>
                                        <td><a href="javascript:void(0);" class="tiptip" title="Percentage of Total Amount Bid that was Won.<br/><br/>This value excludes duplicate proposals<br/><br/>Note: This does not include sales that were bid outside of the selected time period">W/R</a></td>
                                        <td>Owner</td>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div id="company_stats" style="display: none;">
                                <div><a href="javascript:void(0);" onclick="showAccounts()" class="btn right"><i class="fa fa-chevron-left"></i> Back </a></div>
                                <p style="width: 100%;font-weight:bold;font-size: 16px;float: left;">Proposals For <span class="account_name"></span></p>
                                <input type="hidden" id="selected_company_id" >

                                <div style="width: 65%; float: left;margin-top: 10px;">

                                    <table id="user_status_stats_table" class="display " style="border-collapse: collapse!important;width: 100%; float: left">
                                        <thead>
                                        <tr><th>Status</th><th>Proposals</th><th>Amount</th></tr>
                                        </thead>
                                    </table>
                                </div>
                                <div style="width: 35%; float: left;">
                                    <div id="noUserStatsPieData" style="display: none;">
                                        <p>No data available !</p>
                                    </div>
                                    <span style="right: 115px;font-weight: bold;position: absolute;top: 81px;font-size: 16px;display: none;" class="selectedUserName"></span>
                                    <div style="padding-left: 40px;" id="accountUserStatsPie"></div>
                                </div>


                                <div style="width: 96%; float: left;margin-top: 5px;padding-left: 10px;">

                                    <div>
                                        <p style="float: left;font-weight:bold">Year on Year Stats</p>
                                        <a class="btn right chart_type" id='b2' style="margin-left: 5px;"><i class="fa fa-fw fa-line-chart" ></i> Line</a>
                                        <a class="btn right blue-button chart_type" id='b1'><i class="fa fa-fw fa-bar-chart"></i> Column</a>
                                    </div>
                                    <div id="accountYearToYearstats" style="float: left;"></div>
                                </div>




                            </div>
                        </div>

                    </div>

                    <!-- start business types tab-->

                    <div id="business_types" style="padding-top: 5px;">
                        <div class="box-content">
                            <div style="padding:0px 0px 15px 0px;color:#000">
                                <a href="javascript:void(0);" data-val="table" class="btn update-button business_table_breakdown active_section" style="font-size:12px;width:100px" ><i class="fa fa-fw fa-table"></i> Table</a> 
                                <a href="javascript:void(0);" data-val="breakdown" class="btn business_table_breakdown" style="font-size:12px;width:100px"><i class="fa fa-fw fa-pie-chart"></i> Breakdown</a>
                            </div>
                            <div id="businessTypesTableLoader" style="width: 150px;top: 8px;position: absolute;margin-left: 750px;display: none;">
                                <img src="/static/blue-loader.svg" />
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
                                    <div style="margin-top: 20px;display:none" id="NodatauserBusinessTypePie">No data Avaialable</div>
                                    <p style="float:left;">Sales Breakdown</p>
                                    <div style="margin-top: 20px;" id="userSalesBusinessTypePie"></div>
                                    <div style="margin-top: 20px;display:none" id="NodatauserSalesBusinessTypePie">No data Avaialable</div>
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
                    <div id="year_on_year">
                        <div>
                            <p style="float: left;font-weight:bold">Year on Year Stats</p>
                            <a class="btn right all_chart_type" id='s2' style="margin-left: 5px;"><i class="fa fa-fw fa-line-chart" ></i> Line</a>
                            <a class="btn right all_chart_type" id='s1'><i class="fa fa-fw fa-bar-chart"></i> Column</a>
                        </div>
                        <div id="YearToYearAllstats" style="float: left;"></div>
                    </div>
                    <!-- end year on year tab -->
                    <div id="statusTab">
                        <div id="statusTableLoader" style="width: 150px;top: 8px;position: absolute;margin-left: 750px;display: none;">
                                <img src="/static/blue-loader.svg" />
                            </div>
                        <div style="float: left;width:100%;" id="statusStats">

                            <div style="float: left;width:100%;">
                                <div style="float: left;width:65%;">
                                    <div id="StatusStatsTableContainer" style="display: none;font-size:13px;">
                                    <div style="position: absolute;top: 53px;right: 350px;z-index: 1;font-size:12px">
                                        <input type="checkbox" value="1" checked="checked" name="hide0value"  id="hide0value"><span style="position: relative;margin-top: 3px;float: right;">Hide 0 Bids</span>
                                    </div>
                                    
                                    
                                        <table id="StatusStatsTable" >
                                            <thead>
                                                    <tr>
                                                        <th >Status</th>
                                                        <th ># Bids</th>
                                                        <th ># %</th>
                                                        <th >$ Value</th>
                                                        <th >$ %</th>
                                                    </tr>
                                            </thead>
                                            <tbody>
                                            </tbody>
                                            <tfoot>
                                                <tr class="Total_row">
                                                    <th ></th>
                                                    <th ></th>
                                                    <th ></th>
                                                    <th ></th>
                                                    <th ></th>
                                                </tr>
                                            </tfoot>    
                                            
                                        </table>
                                        <div class="ifEmailOff" style="border: 1px solid #dddddd;background: #f4f4f4;float: left;text-align: center;font-weight: bold;">
                                            <span style="font-weight: bold;width: 70px;padding: 10px 2px 6px 18px;float: left;">Email Off:</span>
                                            <span style="width: 20px;padding: 10px 10px 6px 0px;float: left;" class="emailOffCount"></span></div>
                                    </div>
                                    
                                </div>

                                <div style="float: right;width:35%;">
                                <div style="padding:0px 0px 15px 0px;color:#000;position: absolute;top: 42px;right: 10px;">
                                    <a href="javascript:void(0);" data-chart-type="value" class="btn update-button status_chart_change tiptipleft" title="Pie Chart Segments based on $ Value" style="padding:0px 8px;font-size:12px;border: 0px;float: left;margin-right: 0;border-radius: 5px 0px 0px 5px;" > $ </a> 
                                    <a href="javascript:void(0);" data-chart-type="count" class="btn status_chart_change tiptipleft" title="Pie Chart Segments based on # Bids"  style="padding:0px 8px;font-size:12px;border: 0px;float: left;border-radius: 0px 5px 5px 0px;"> # </a>
                                </div>
                                    <p style="text-align:center;font-weight:bold">Proposal Statuses</p>
                                    <div id="noPieData" style="display: none; text-align: center">
                                        <p>No data available for this time period!</p>
                                    </div>

                                    <!--Div that will hold the pie chart-->
                                    <div id="dashboardPie"></div>
                                </div>
                            </div>

                        </div>
                        
                        
                    </div>
                    <div class="clearfix"></div>

                </div>
            </div>
        </div>
    </div>
</div>
<input type="hidden" id="accountId" value="<?= $account->getAccountId() ?>">

<div id="group-merge-message" title="Confirmation">
    <p>Are you sure you want to merge these account?</p>
    <br/>
    <div id="accountReassign">
        <p>All clients and proposals will be moved to the selected account. The original accounts will be
            deleted.</p>
        <br/>

        <strong>Search Account</strong>
        <select name="groupReassignTo" id="groupReassignTo" class="dont-uniform" data-placeholder="Chose number" data-allow-clear="true" ><option></option></select>


    </div>
</div>

<div id="group-merge-status" title="Confirmation">
    <br/>
    <p id="groupMergeText" style="text-align: center;"></p>
</div>
<!--#content-->
<?php $this->load->view('global/footer'); ?>
<style>
    .business_table_breakdown{color:#000!important}
    .active_section{color:#25AAE1!important}
    .box-header .select2-container {
        width: 150px !important;
        padding: 0;
        margin-top: -3px;
        height: 24px;
    }
    .box-header .select2-selection--single{height: 24px;}
    .box-header .select2-selection__rendered{line-height: 24px!important;}
    .box-header .select2-selection__arrow{line-height: 24px;top: 0px;}
    .select2-container {
        width: 250px !important;
        padding: 0;
    }

</style>

<script type="text/javascript">
    google.charts.load('current', {'packages': ['corechart','bar','line']});
    var last_row_removed = false;
    var last2_row_removed = false;
    var accTable;
    var btTable;
    var btBreakTable;
    var stTable;
    var oStatusTable;
    var statusObject = <?= json_encode($statusObject);?>;
    var initialDateRangeSet = false;

    $(document).ready(function () {

        $('#user_account_select').select2({
            placeholder: "Select User"
        });

        $.fn.dataTable.ext.errMode = 'none';
    });

    function initAccountTable() {
        accTable = $('.dataTables-companies').on('error.dt', function (e, settings, techNote, message) {
            console.log('An error has been reported by DataTables: ', message);
            //$("#datatablesError").dialog('open');

        })
            .on('processing.dt', function (e, settings, processing) {
                if (processing) {
                    $("#accountsTableLoader").show();
                } else {
                    $("#accountsTableLoader").hide();
                }
            })
            .DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "<?php echo site_url('ajax/ajaxGetUserAccounts').'/'.$account->getAccountId(); ?>",
                "columnDefs": [
                    {
                        "targets": [0],
                        "sortable": false,
                        "width": '15px',
                        'class': 'dtCenter'
                    },
                    {
                        "targets": [1],
                        "sortable": true,
                        "width":'29%'
                    },
                    {"targets": [2],"width":'1%', "sortable": true,'visible':false, 'class': 'dtCenter'},
                    {"targets": [3],"width":'8%', "sortable": true,'class': 'dtCenter'},
                    {"targets": [4],"width":'11%', "sortable": true, },
                    {"targets": [5],"width":'10%', "sortable": true,},
                    {"targets": [6],"width":'10%', "sortable": true},
                    {"targets": [7],"width":'10%', "sortable": true},
                    {"targets": [8], "width":'12%',"sortable": true},
                    {"targets": [9], "width":'9%',"sortable": true},
                ],
                "sorting": [
                    [4, "desc"]
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
                    if ($.fn.DataTable.isDataTable('.dataTables-companies')) {
                        var dt = $('.dataTables-companies').DataTable();

                        //Abort previous ajax request if it is still in process.
                        var settings = dt.settings();
                        if (settings[0].jqXHR) {
                            settings[0].jqXHR.abort();
                        }
                    }
                },
                "drawCallback": function(){
                    initTiptip();

                    $("#groupSelectAllTop").html('<span id="numSelected">0</span> selected');
                    $("#accountMasterCheck").prop('checked', false);
                    $('.groupSelect').uniform();
                    //accTable.columns().adjust();
                    if(accTable){
                        accTable.columns.adjust();
                    }

                }


            });
        $('.dataTables-companies').show();


    }

    function initBtTable(){
        
        btTable = $('.dataTables-business-types').on('error.dt', function (e, settings, techNote, message) {
            console.log('An error has been reported by DataTables: ', message);
            //$("#datatablesError").dialog('open');

        })
            .on('processing.dt', function (e, settings, processing) {
                if (processing) {
                    $("#businessTypesTableLoader").show();
                } else {
                    $("#businessTypesTableLoader").hide();
                }
            })
            .DataTable({
                "processing": true,
                "serverSide": true,
                "ajax": "<?php echo site_url('ajax/ajaxGetUserBusinessTypes').'/'.$account->getAccountId(); ?>",
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

                    //accTable.columns().adjust();
                    if(btTable){
                        btTable.columns.adjust();
                    }

                }


            });
        $('.dataTables-business-types').show();
    }

    // function updateTable() {

    //     if ($.fn.DataTable.isDataTable('#accountTable')) {
    //         accTable.ajax.reload();
    //     } else {
    //         initTable();
    //     }

    // }

    // updateTable();

    function initial_user_status_load_table(){

        console.log('init status load table');

        stTable = $('#user_status_stats_table').DataTable({
            "processing": true,
            "serverSide": true,
            "searching":false,
            "lengthChange":false,
            "paging":false,
            "info":false,
            "ajax": {
                url: "<?php echo site_url('ajax/accountUserStatsInfoTable') ?>",
                data: function(d) {
                    d.accountId = $("#selected_company_id").val();
                    d.from = $("#from").val();
                    d.to = $("#to").val();
                    d.user_id = "<?= $account->getAccountId(); ?>"
                }
            },
            "columns": [
                {width: '40%',class: 'dtLeft'},
                {width: '35%',class: 'dtCenter'},
                {width: '25%',class: 'dtLeft'},
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

    $(document).on('click','.account_status_info',function() {

        console.log('here');

        $('#company_stats').show();
        $('#company_table').hide();

        $('#selected_company_id').val($(this).data('val'));

        loadUserInfoPie($(this).data('val'));
        loadYearStatsBar($(this).data('val'));

        $('.account_name').text($(this).text());

        console.log(stTable);

        if(stTable){
            console.log(stTable.ajax);
            stTable.ajax.reload(null,false);
        }else{
            console.log('init table');
            initial_user_status_load_table();
        }
        $('#user_status_stats_table').show();

    });



    function loadYearStatsBar(account_id) {

        var jsonData = $.ajax({
            url: "/ajax/accountUserYearStatsBar",
            dataType: "json",
            async: false,
            data: {
                accountId: account_id,
                user_id : "<?= $account->getAccountId(); ?>",
                from: $("#from").val(),
                to: $("#to").val()
            },
            type: 'post',
            cache: false
        }).responseText;

        res = JSON.parse(jsonData);

        if (res) {

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
                width:900,

                colors: ['#1b9e77', '#d95f02']
            };

            //var chart = new google.visualization.ColumnChart(document.getElementById('accountYearToYearstats'));

            var chart = new google.visualization.ChartWrapper({
                containerId: 'accountYearToYearstats'
            });

            chart.setOptions(options);
            //chart.draw(data, options);

            //chart.setOptions(options);
            var barsButton = document.getElementById('b1');
            var lineButton = document.getElementById('b2');

            if(localStorage.getItem('acc_chart_type') == 'line') {
                drawLine();

            }else{
                drawBars();
            }
            function drawBars() {

                chart.setChartType('ColumnChart');
                chart.setDataTable(data);
                chart.draw();
                if(hasLocalStorage){
                    localStorage.setItem('acc_chart_type','bar');
                }
                $('.chart_type').removeClass('blue-button');
                $('#b1').addClass('blue-button');
            }

            function drawLine() {

                chart.setChartType('LineChart');
                chart.setDataTable(data);
                chart.draw();
                if(hasLocalStorage){
                    localStorage.setItem('acc_chart_type','line');
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
        else {
            //$("#accountUserStatsPie").hide();
            //$("#noUserStatsPieData").show();
        }

    }

    function loadUserInfoPie(account_id) {

        var jsonData = $.ajax({
            url: "/ajax/accountUserInfoPie",
            dataType: "json",
            async: false,
            data: {
                accountId: account_id,
                user_id : "<?= $account->getAccountId(); ?>",
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
                height: 260,
                chartArea: {
                    width: '90%',
                    height: '90%'
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
            $("#noUserStatsPieData").show();
        }

    }

    function showAccounts(){
        $('#company_stats').hide();
        $('#company_table').show();
    }



    $(document).on('click','.all_chart_type',function(){
        $('.all_chart_type').removeClass('blue-button');
        $(this).addClass('blue-button');

    });

    $(document).on('change','#user_account_select',function(){

        window.location.href = "<?= base_url();?>account/stats/"+$('#user_account_select').val();


    });


    function loadYearAllStatsBar() {

        var jsonData = $.ajax({
            url: "/ajax/accountUserYearAllStatsBar",
            dataType: "json",
            async: false,
            data: {
                user_id : "<?= $account->getAccountId(); ?>",
                from: $("#from").val(),
                to: $("#to").val()
            },
            type: 'post',
            cache: false
        }).responseText;

        res = JSON.parse(jsonData);
        if (res) {

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
                width:900,

                colors: ['#1b9e77', '#d95f02']
            };

            var chart = new google.visualization.ChartWrapper({
                containerId: 'YearToYearAllstats'
            });

            chart.setOptions(options);
            //chart.draw(data, options);

            //chart.setOptions(options);
            var barsButton = document.getElementById('s1');
            var lineButton = document.getElementById('s2');
            if(localStorage.getItem('acc_all_chart_type') == 'line') {
                drawLine();

            }else{
                drawBars();
            }


            function drawBars() {

                chart.setChartType('ColumnChart');
                chart.setDataTable(data);
                chart.draw();
                if(hasLocalStorage){
                    localStorage.setItem('acc_all_chart_type','bar');
                }
                $('.chart_type').removeClass('blue-button');
                $('#s1').addClass('blue-button');
            }

            function drawLine() {

                chart.setChartType('LineChart');
                chart.setDataTable(data);
                chart.draw();
                if(hasLocalStorage){
                    localStorage.setItem('acc_all_chart_type','line');
                }
                $('.chart_type').removeClass('blue-button');
                $('#s2').addClass('blue-button');
            }

            barsButton.onclick = function () {
                drawBars();
            }

            lineButton.onclick = function () {
                drawLine();
            }





        }
        else {
            //$("#accountUserStatsPie").hide();
            //$("#noUserStatsPieData").show();
        }

    }

    function setDateRange(callback){
        $.ajax({
            url: "<?php echo site_url('ajax/setDateRange') ?>",
            type: "POST",
            dataType: "JSON",
            data: {
                from: $("#from").val(),
                to: $("#to").val(),
            }
        })
        .success(function (data) {
            if (callback) {
                callback();
            }
            initialDateRangeSet = true;
        });
    }

    function updateGroupButtons() {
        var counter = $(".groupSelect:checked").length;
        if (counter > 0) {
            $("#groupActions").show();
        } else {
            $("#groupActions").hide();
        }

        $("#numSelected, #deleteNum, #changeOwnerNum, #resendNum").html(counter);
    }

    /* Update the number of selected items */
    function updateNumSelected() {
        var num = $(".groupSelect:checked").length;

        // Hide the options if 0 selected
        if (num < 1) {
            //$("#groupSelectAllTop").html('<a href="#" id="selectAll">All</a> / <a href="#" id="selectNone">None</a>&nbsp;&nbsp;&nbsp;<span id="numSelected">0</span> selected');
            $(".groupAction").hide();
        } else {
            //$("#groupSelectAllTop").html('<a href="#" id="selectAll">All</a> / <a href="#" id="selectNone">None</a>&nbsp;&nbsp;&nbsp;<span id="numSelected">0</span> selected');
            $(".groupAction").show();
        }
        $("#numSelected").html(num);
    }

    $("#groupActions").hide();
    $(".groupSelect:checked").removeAttr('checked');

    $(".groupSelect").live('change', function () {
        updateNumSelected();
    });

    $("#accountMasterCheck").change(function () {
        var checked = $(this).is(":checked");
        $(".groupSelect").prop('checked', checked);
        $.uniform.update();
        updateNumSelected();
    });



    // None
    $("#selectNone").live('click', function () {
        $(".groupSelect").attr('checked', false);
        updateNumSelected();
        $.uniform.update();
        return false;
    });

    // Group Actions Button
    $("#groupActionsButton").click(function () {
        // Hide the filter content
        $(".newFilterContainer").hide();
        // Toggle the buttons
        $(".groupActionsContainer").toggle();
    });

    $("#groupMerge").click(function () {


        $("#groupReassignTo").val(null).trigger("change");

        $("#group-merge-message").dialog('open');


    });


    // Merge Dialog
    $("#group-merge-message").dialog({
        width: 400,
        modal: true,
        open: function( event, ui ) {

            $(".saveButtonClass1").button("disable");

        },
        buttons: [

            {
                html: "<i class='fa fw fa-check-circle-o'></i> Merge Accounts",
                "class": 'saveButtonClass1 blue-button',
                click: function() {
                    if ($("#groupReassignTo").val() > 0) {

                        $(this).dialog("close");
                        $("#groupMergeText").html('Merging <img src="/static/loading.gif" />');
                        $("#group-merge-status").dialog('open');

                        // Send the request
                        $.ajax({
                            type: "POST",
                            async: true,
                            cache: false,
                            data: {
                                'ids': getSelectedIds(),
                                'reassignTo': $("#groupReassignTo").val()
                            },
                            url: "<?php echo site_url('ajax/accountGroupMerge') ?>?" + Math.floor((Math.random() * 100000) + 1),
                            dataType: "JSON"
                        })
                            .success(function (data) {
                                // Set the feedback text
                                if (!data.error) {
                                    var mergeStatusText = data.numMerged + " accounts were merged";
                                } else {
                                    var mergeStatusText = "An error occurred. Please try again";
                                }
                                $("#groupMergeText").html(mergeStatusText);
                                accTable.ajax.reload();

                            });
                    }
                }
            },{
                text: "Cancel",
                "class": 'cancelButtonClass',
                click: function() {
                    $(this).dialog("close");
                }
            }
        ],

        autoOpen: false
    });

    // Merge Dialog
    $("#group-merge-status").dialog({
        width: 400,
        modal: true,
        buttons: {
            Ok: function () {
                $(this).dialog("close");
                $('#groupActionsButton').hide();
                accTable.ajax.reload();
            }
        },
        autoOpen: false
    });
    /* Create an array of the selected IDs */
    function getSelectedIds() {

        var IDs = new Array();

        $(".groupSelect:checked").each(function () {
            IDs.push($(this).data('account-id'));
        });

        return IDs;
    }

    //Select2 start

    $("#groupReassignTo").select2({
        ajax: {
            url: '<?php echo site_url('ajax/ajaxSelect2SearchGroupClientsCompany') ?>',
            dataType: 'json',
            delay: 250,

            data: function (params) {
                return {
                    startsWith: params.term, // search term
                    client_ids: getSelectedIds(),
                    page: params.page
                };
            },
            processResults: function (data, params) {
                // parse the results into the format expected by Select2
                // since we are using custom formatting functions we do not need to
                // alter the remote JSON data, except to indicate that infinite
                // scrolling can be used
                params.page = params.page || 1;

                return {
                    results: data.items,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        placeholder: 'Search for a repository',
        allowClear: true,
        debug: true,
        minimumInputLength: 1,
        templateResult: formatRepo,
        templateSelection: formatRepoSelection
    });



    $('#groupReassignTo').on("select2:selecting", function(e) {
        // what you would like to happen
        var select_id = e.params.args.data.id;
        $("#client-group-merge").data('reassign', select_id);
        $(".saveButtonClass1").button("enable");
    });

    $('#groupReassignTo').on('select2:clear', function (e) {
        $(".saveButtonClass1").button("disable");
    });

    function formatRepo (repo) {
        if (repo.loading) {
            return repo.text;
        }

        var $container = $(
            "<div class='select2-result-repository clearfix'>" +

            "<div class='select2-result-repository__meta'>" +
            "<table >"+
            "<tr><th style='vertical-align: top;'>Account:</th><td class='select2-result-repository_account'></td></tr>"+
            "<tr><th style='vertical-align: top;'>Owner:</th><td class='select2-result-repository_contact'></td></tr>"+


            "</div>" +
            "</div>"
        );

        $container.find(".select2-result-repository_account").text(repo.label);
        $container.find(".select2-result-repository_contact").text(repo.contact);

        return $container;
    }

    function formatRepoSelection (repo) {
        return repo.label ;
    }
    //Select2 end

    function loadUserBusinessTypePie() {

        var jsonData = $.ajax({
            url: "/ajax/businessTypeUserInfoPie",
            dataType: "json",
            async: false,
            data: {
                user_id : "<?= $account->getAccountId(); ?>",
                from: $("#from").val(),
                to: $("#to").val()
            },
            type: 'post',
            cache: false
        }).responseText;

        data = JSON.parse(jsonData);
        if (!data.empty) {
            $("#userBusinessTypePie").show();
            $("#NodatauserBusinessTypePie").hide();
            
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
             $("#userBusinessTypePie").hide();
             $("#NodatauserBusinessTypePie").show();
        }

    }

    function loadUserSalesBusinessTypePie() {

        var jsonData = $.ajax({
            url: "/ajax/businessTypeSalesUserInfoPie",
            dataType: "json",
            async: false,
            data: {
                user_id : "<?= $account->getAccountId(); ?>",
                from: $("#from").val(),
                to: $("#to").val()
            },
            type: 'post',
            cache: false
        }).responseText;

        data = JSON.parse(jsonData);
        if (!data.empty) {
            $("#userSalesBusinessTypePie").show();
            $("#NodatauserSalesBusinessTypePie").hide();
            
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
            $("#userSalesBusinessTypePie").hide();
            $("#NodatauserSalesBusinessTypePie").show();
        }

    }

    $(document).on('click','.business_table_breakdown',function(){
        $('.business_table_breakdown').removeClass('update-button');
        $(this).addClass('update-button');
       
        if($(this).attr('data-val')=='table'){
            if(btTable){
                btTable.ajax.reload();
            }else{
                initBtTable();
            }
            $('#business_types_table').show();
            $('.breakdown_box').hide();
        }else{
            loadUserBusinessTypePie();
            loadUserSalesBusinessTypePie();
            if(btBreakTable){
                btBreakTable.ajax.reload();
            }else{
                initial_business_breakdown_load_table();
            }
            $('#business_types_table').hide();
            $('.breakdown_box').show();
        }
    });


    function initial_business_breakdown_load_table(){


        btBreakTable = $('#business_type_breakdown_table').DataTable({
            "processing": true,
            "serverSide": true,
            "searching":false,
            "lengthChange":false,
            "paging":false,
            "info":false,
            "ajax": "<?php echo site_url('ajax/businessTypeBreakdownTable').'/'.$account->getAccountId(); ?>",
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

            function updateStatusTable() {
                
                var type = $('.status_chart_change.update-button').attr('data-chart-type');
                if(type=='count'){
                    drawStatusProposalCountPieChart();
                }else{
                    drawStatusPieChart();
                    
                }
               
                if (oStatusTable) {
                    $.fn.dataTable.ext.search.pop();
                    oStatusTable.ajax.reload();
                    oStatusTable.columns.adjust();
                } else {
                    oStatusTable = $("#StatusStatsTable").on('processing.dt', function (e, settings, processing) {
                            if (processing) {
                               
                               //$("#StatusStatsTableContainer").hide();
                                $("#statusTableLoader").show();
                                last_row_removed = false;
                            } else {
                                $("#statusTableLoader").hide();
                                $("#StatusStatsTableContainer").show();
                                $("#hide0value").trigger('change');
                                
                            }
                        }).DataTable({
                        "jQueryUI": true,
                        "autoWidth": true,
                        "stateSave": true,
                        "scrollY": '40vh',
                        "scrollCollapse": true,
                        "scrollX": true,
                        "bPaginate": false,
                        "iDisplayLength": -1,
                        "searching": true,
                        "bInfo" : false,
                        "order": [],
                        "ajax": {
                            "url": "<?php echo site_url('ajax/userStatusTable').'/'.$account->getAccountId(); ?>",
                            "type": "POST",
                           
                        },
                        
                        "fnInitComplete": function () {
                            
                            $("#StatusStatsTable_wrapper").show();
                            $("#StatusStatsTable").show();
                            $("#dataTables_scrollHeadInner").show();
                        },
                        
                        "fnDrawCallback": function () {
                            $("#statsLoaderSalesTargets").hide();
                            initTiptip();
                           
                        },
                        "footerCallback": function(tfoot, data, start, end, display) {

                           
                            var api = this.api();
                           
                            if(api.ajax.json()){
                                var footer_row = api.ajax.json().footerData[0];
                                $(tfoot).find('th').eq(0).html(footer_row[0]);
                                $(tfoot).find('th').eq(1).html(footer_row[1]);
                                $(tfoot).find('th').eq(2).html(footer_row[2]);
                                $(tfoot).find('th').eq(3).html(footer_row[3]);
                                $(tfoot).find('th').eq(4).html(footer_row[4]);
                                if(api.ajax.json().emailOffData){
                                    var email_off_row = api.ajax.json().emailOffData[0];
                                    $('.emailOffCount').html(email_off_row[1]);
                                    $('.ifEmailOff').show();
                                }else{
                                    $('.ifEmailOff').hide();
                                }
                                
                                
                            }
                           
                           
                            
                        },
                    });
                }
                return false;


            }

           
            $("#hide0value").change(function() {
                if($(this).prop('checked')==true){
                    
                    $.fn.dataTable.ext.search.push(
                    function(settings, data, dataIndex) {
                        return $(oStatusTable.row(dataIndex).node()).children().eq(1).html() != '<span class="" style="cursor: pointer;">0</span>';
                        }
                    );
                    oStatusTable.draw();
                    oStatusTable.columns.adjust();
                }else{
                    $.fn.dataTable.ext.search.pop();
                    oStatusTable.draw(); 
                    oStatusTable.columns.adjust();
                }
            });    
            
            // Set a callback to run when the Google Visualization API is loaded.
            //google.setOnLoadCallback(updateStats());

            function drawStatusPieChart() {
                console.log('show');
                $("#statusTableLoader").show();
       
                var accountId = "<?=$account->getAccountId();?>";
              var type = $('.status_chart_change.update-button').attr('data-chart-type');

                // Get single user / non admin account value
                if (!accountId) {
                    var accountId = $("#statsUser").data('account');
                }
            //if(type=='count'){
            //    var chart_url = "/ajax/userStatsStatusdProposalCountPie";
           // }else{
                var chart_url = "/ajax/userStatsStatusdPie";
           // }
            var jsonData = $.ajax({
                    url: chart_url,
                    dataType: "json",
                    async: false,
                    data: {
                        
                        accountId: accountId,
                       
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
                    $("#dashboardPie").show();
                    var text_url = "<?php echo  site_url('proposals/status/status_id/user/'. $account->getAccountId() )   ;?>";
                    // Create our data table out of JSON data loaded from server.
                    var data = new google.visualization.DataTable(data.table);

                    var formatter = new google.visualization.NumberFormat(
                        {prefix: '$', pattern: '#,###,###'});
                    formatter.format(data, 1); // Apply formatter to second column

                    // Instantiate and draw our chart, passing in some options.
                    var chart = new google.visualization.PieChart(document.getElementById('dashboardPie'));

                    // Pie Chart Options
                    var options = {
                        width: '100%',
                        height: 350,
                        chartArea: {
                            width: '85%',
                            height: '90%'
                        },
                        tooltip: {
                            //trigger: 'selection',
                            isHtml: true
                        },
                        colors: colorArray,
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
                    var container = document.getElementById('dashboardPie');

                    google.visualization.events.addListener(chart, 'onmouseover', function (props) {
                    var count = data.getValue(props.row, 2);
                    

                    var tooltip = container.getElementsByTagName('ul');
                    var tooltipLabel = container.getElementsByTagName('span');
                    if (tooltip.length > 0) {
                       
                        // increase tooltip height
                        tooltip[0].parentNode.style.height = '95px';

                        // add new li element
                        var newLine = tooltip[0].appendChild(document.createElement('li'));
                        newLine.className = 'google-visualization-tooltip-item';

                        // add span for label
                        var lineLabel = newLine.appendChild(document.createElement('span'));
                        lineLabel.style.fontFamily = tooltipLabel[0].style.fontFamily;
                        lineLabel.style.fontSize = tooltipLabel[0].style.fontSize;
                        lineLabel.style.color = tooltipLabel[0].style.color;
                        lineLabel.style.margin = tooltipLabel[0].style.margin;
                        lineLabel.style.textDecoration = tooltipLabel[0].style.textDecoration;
                        lineLabel.innerHTML =  'Proposals : ';

                        // add span for value
                        var lineValue = newLine.appendChild(document.createElement('span'));
                        lineValue.style.fontFamily = tooltipLabel[0].style.fontFamily;
                        lineValue.style.fontSize = tooltipLabel[0].style.fontSize;
                        lineValue.style.fontWeight = tooltipLabel[0].style.fontWeight;
                        lineValue.style.color = tooltipLabel[0].style.color;
                        lineValue.style.margin = tooltipLabel[0].style.margin;
                        lineValue.style.textDecoration = tooltipLabel[0].style.textDecoration;
                        lineValue.innerHTML = count;
                        // add new li element
                        var newLine = tooltip[0].appendChild(document.createElement('li'));
                        newLine.className = 'google-visualization-tooltip-item';

                        // add span for label
                        var lineLabel = newLine.appendChild(document.createElement('span'));
                        lineLabel.style.fontFamily = tooltipLabel[0].style.fontFamily;
                        lineLabel.style.fontSize = tooltipLabel[0].style.fontSize;
                        lineLabel.style.color = tooltipLabel[0].style.color;
                        lineLabel.style.margin = tooltipLabel[0].style.margin;
                        lineLabel.style.textDecoration = tooltipLabel[0].style.textDecoration;
                        lineLabel.innerHTML =  'Click to view proposals';
                        
                    }
                    });
                    google.visualization.events.addListener(chart, 'ready', afterDraw);
                    chart.draw(data, options);
                    //$("#statusTableLoader").hide();
                    google.visualization.events.addListener(chart, 'select', selectHandler);
                    
                   // google.visualization.events.addListener(chart, 'click', clickHandler);
                    function selectHandler(e) {
                        var selection = chart.getSelection();
                        var status_id=data.getFormattedValue(selection[0].row,3);
                        //var district=data.getData(selection[0].row,0);
                        //console.log(selection)
                        
                        status_id = status_id.replace(',', '');
                        text_url_new = text_url.replace('status_id', status_id);
                        
                        window.location.href = text_url_new;
                    }
                    function afterDraw(){
                        console.log('hide')
                        $("#statusTableLoader").hide();
                    }
                } else {
                    $("#dashboardPie").hide();
                    $("#noPieData").show();
                    $("#statusTableLoader").hide();
                }
            }

    $(document).on('click','.status_chart_change',function(){

        $("#statusTableLoader").show();
        $('.status_chart_change').removeClass('update-button');
        $(this).addClass('update-button');
            
        if($(this).attr('data-chart-type')=='count'){
            drawStatusProposalCountPieChart();
        }else{
            drawStatusPieChart();
        }
    });

                function drawStatusProposalCountPieChart() {
                    $("#statusTableLoader").show();
       
                var accountId = "<?=$account->getAccountId();?>";
              var type = $('.status_chart_change.update-button').attr('data-chart-type');

                // Get single user / non admin account value
                if (!accountId) {
                    var accountId = $("#statsUser").data('account');
                }
            //if(type=='count'){
                var chart_url = "/ajax/userStatsStatusdProposalCountPie";
           // }else{
           //     var chart_url = "/ajax/userStatsStatusdPie";
           // }
            var jsonData = $.ajax({
                    url: chart_url,
                    dataType: "json",
                    async: false,
                    data: {
                        
                        accountId: accountId,
                       
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
                    $("#dashboardPie").show();
                    var text_url = "<?php echo  site_url('proposals/status/status_id/user/'. $account->getAccountId() )   ;?>";
                    // Create our data table out of JSON data loaded from server.
                    var data = new google.visualization.DataTable(data.table);

                    var formatter = new google.visualization.NumberFormat(
                        {prefix: 'Proposals: ', pattern: '#######'});
                    formatter.format(data, 1); // Apply formatter to fourth column

                    // Instantiate and draw our chart, passing in some options.
                    var chart = new google.visualization.PieChart(document.getElementById('dashboardPie'));

                    // Pie Chart Options
                    var options = {
                        width: '100%',
                        height: 350,
                        chartArea: {
                            width: '85%',
                            height: '90%'
                        },
                        tooltip: {
                            //trigger: 'selection',
                            isHtml: true
                        },
                        colors: colorArray,
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
                    var container = document.getElementById('dashboardPie');

                    google.visualization.events.addListener(chart, 'onmouseover', function (props) {
                    var count = data.getValue(props.row, 2);
                    

                    var tooltip = container.getElementsByTagName('ul');
                    var tooltipLabel = container.getElementsByTagName('span');
                    if (tooltip.length > 0) {
                       
                        // increase tooltip height
                        tooltip[0].parentNode.style.height = '95px';

                        // add new li element
                        var newLine = tooltip[0].appendChild(document.createElement('li'));
                        newLine.className = 'google-visualization-tooltip-item';

                        // add span for label
                        var lineLabel = newLine.appendChild(document.createElement('span'));
                        lineLabel.style.fontFamily = tooltipLabel[0].style.fontFamily;
                        lineLabel.style.fontSize = tooltipLabel[0].style.fontSize;
                        lineLabel.style.color = tooltipLabel[0].style.color;
                        lineLabel.style.margin = tooltipLabel[0].style.margin;
                        lineLabel.style.textDecoration = tooltipLabel[0].style.textDecoration;
                        lineLabel.innerHTML =  'Value : ';

                        // add span for value
                        var lineValue = newLine.appendChild(document.createElement('span'));
                        lineValue.style.fontFamily = tooltipLabel[0].style.fontFamily;
                        lineValue.style.fontSize = tooltipLabel[0].style.fontSize;
                        lineValue.style.fontWeight = tooltipLabel[0].style.fontWeight;
                        lineValue.style.color = tooltipLabel[0].style.color;
                        lineValue.style.margin = tooltipLabel[0].style.margin;
                        lineValue.style.textDecoration = tooltipLabel[0].style.textDecoration;
                        lineValue.innerHTML = count;

                        // add new li element
                        var newLine = tooltip[0].appendChild(document.createElement('li'));
                        newLine.className = 'google-visualization-tooltip-item';

                        // add span for label
                        var lineLabel = newLine.appendChild(document.createElement('span'));
                        lineLabel.style.fontFamily = tooltipLabel[0].style.fontFamily;
                        lineLabel.style.fontSize = tooltipLabel[0].style.fontSize;
                        lineLabel.style.color = tooltipLabel[0].style.color;
                        lineLabel.style.margin = tooltipLabel[0].style.margin;
                        lineLabel.style.textDecoration = tooltipLabel[0].style.textDecoration;
                        lineLabel.innerHTML =  'Click to view proposals';
                    }
                    });
                    google.visualization.events.addListener(chart, 'ready', afterDraw1);
                    chart.draw(data, options);
                    //$("#statusTableLoader").hide();
                    google.visualization.events.addListener(chart, 'select', selectHandler);
                    
                   // google.visualization.events.addListener(chart, 'click', clickHandler);
                    function selectHandler(e) {
                        var selection = chart.getSelection();
                        var status_id=data.getFormattedValue(selection[0].row,3);
                        //var district=data.getData(selection[0].row,0);
                        //console.log(selection)
                        
                        status_id = status_id.replace(',', '');
                        text_url_new = text_url.replace('status_id', status_id);
                        
                        window.location.href = text_url_new;
                    }

                    
                   
                    function afterDraw1(){
                        console.log('hide1')
                        $("#statusTableLoader").hide();
                    }
                } else {
                    $("#dashboardPie").hide();
                    $("#noPieData").show();
                    $("#statusTableLoader").hide();
                }
            }
</script>