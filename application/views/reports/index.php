<?php $this->load->view('global/header') ?>
<div id="content" class="clearfix">
<div class="widthfix">
<script type="text/javascript">
    function daysInMonth(month, year) {
        var m = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
        if (month != 2) return m[month - 1];
        if (year % 4 != 0) return m[1];
        if (year % 100 == 0 && year % 400 != 0) return m[1];
        return m[1] + 1;
    }
    $(document).ready(function () {
    <?php
    $startDate = $account->getCompany()->getAdministrator()->getCreated(false);
    $startMonth = date('n', $startDate);
    $startMonth--;
    $curMonth = date('n');
    $curMonth--;
    ?>
        var minDate = new Date(2011, <?php echo $startMonth ?>, 1);
        var maxDate = new Date(<?php echo date('Y') ?>, <?php echo $curMonth ?>, 1);
        var dates = $("#from, #to, #statusFrom, #statusTo").datepicker({
            changeDay: true,
            changeMonth:true,
            changeYear:true,
            showButtonPanel:true,
            dateFormat:'m/d/yy',
            onClose:function (dateText, inst) {

            }
        });
    });
</script>

<form action="<?php echo site_url('reports/download_report') ?>" method="post" class="big" target="download_report_frame" name="report_options" id="report_options">
    <div class="content-box">
        <div class="box-header">
            <?php if (help_box(23)) { ?>
                <div class="help right tiptip" title="Help"><?php help_box(23, true) ?></div>
            <?php } ?>
            Reports
<!-- add a back button -->
&nbsp;
<a style="font-size:14px;float:right;color:white;" href="<?php echo site_url('account/my_account') ?>">Back</a>
         </div>
        <div class="box-content">
            <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
                <tr>
                    <td width="180" valign="top">
                        <p class="clearfix">
                            <label style="">User Name</label>
                        </p>
                    </td>
                    <td>
                        <p>
                            <a href="#" id="allUsers">All</a> / <a href="#" id="noUsers">None</a>
                        </p>
                        <p class="clearfix" id="users">
                            <?php
                            if ($account->isAdministrator() || $account->getFullAccess()) {
                                foreach ($account->getCompany()->getAccounts() as $acc) {
                                    ?>
                                    <label style="text-align: left; display: block; width: auto; padding-right: 3px;" for="<?php echo $acc->getAccountId() ?>">
                                        <input type="checkbox" name="accounts[<?php echo $acc->getAccountId() ?>]" id="<?php echo $acc->getAccountId() ?>" class="userCheck" style="margin-top: 0; margin-right: 4px; margin-left: 1px;">
                                        <?php echo $acc->getFullName() ?>
                                    </label>
                                    <?php
                                }
                            } else {
                                ?>
                                <label style="text-align: left; display: block; width: auto; padding-right: 3px;">
                                    <input type="checkbox" name="accounts[<?php echo $account->getAccountId() ?>]"
                                           id="<?php echo $account->getAccountId() ?>"
                                           style="margin-top: 0; margin-right: 4px; margin-left: 1px;"><?php echo $account->getFullName() ?>
                                </label>
                                <?php
                            }
                            ?>
                        </p>
                    </td>
                </tr>
                <tr class="even" style="display: none">
                    <td>
                        <p class="clearfix">
                            <label style="">Service</label>
                        </p>
                    </td>
                    <td>
                        <p class="clearfix">
                            <select name="service" id="service">
                                <option value="0" selected="selected">All</option>
                                <?php
                                foreach ($categories as $cat) {
                                    /* @var $cat \models\Services */
                                    ?>
                                    <optgroup label="<?php echo $cat->getServiceName() ?>">
                                        <?php
                                        if (isset($services[$cat->getServiceId()])) {
                                            foreach ($services[$cat->getServiceId()] as $service) {
                                                ?>
                                                <option value="<?php echo $service->getServiceId() ?>"><?php echo $service->hasCustomTitle($account->getCompany()->getCompanyId()) ? $service->getCustomTitle($account->getCompany()->getCompanyId())->getTitle() : $service->getServiceName(); ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </optgroup>
                                    <?php
                                }
                                ?>
                            </select>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="clearfix">
                            <label style="">Date Selection</label>
                        </p>
                    </td>
                    <td>
                        <p class="clearfix">
                            <label style="width: auto; padding-left: 0px;">From</label> <input size="8" style="margin-top: 4px;" type="text" id="from" class="datepicker" name="from" value="<?php echo $defaultStartDate; ?>">
                            <label style="width: auto; padding-left: 10px;">To</label> <input size="8" style="margin-top: 4px;" type="text" id="to" class="datepicker" name="to"  value="<?php echo $defaultEndDate; ?>">
                            <label style="width: auto; padding-left: 10px;"></label><a id="all" class="btn" href="#" style="margin-left: 10px;">All</a>
                        </p>
                    </td>
                </tr>
                <tr>
                    <td>
                        <p class="clearfix">
                            <label style="">Status Date Change</label>
                        </p>
                    </td>
                    <td>
                        <p class="clearfix">
                            <label style="width: auto; padding-left: 0px;">Apply</label> <input size="8" style="margin-top: 4px;" type="checkbox" id="statusApply" name="statusApply" class="datepicker" >
                            <label style="width: auto; padding-left: 0px;">From</label> <input size="8" style="margin-top: 4px;" type="text" id="statusFrom" class="datepicker" name="statusFrom" value="<?php echo $defaultStartDate; ?>" disabled="disabled">
                            <label style="width: auto; padding-left: 10px;">To</label> <input size="8" style="margin-top: 4px;" type="text" id="statusTo" class="datepicker" name="statusTo" value="<?php echo $defaultEndDate; ?>" disabled="disabled">
                            <label style="width: auto; padding-left: 10px;"></label><a id="statusAll" class="btn" href="#" style="margin-left: 10px;" >All</a>
                        </p>
                    </td>
                </tr>
                <tr class="even">
                    <td colspan="2">
                        <div class="clearfix">
                           <label style="margin-right: 50px;">Report Types</label>

                            <div style="float: left; width: 500px;">

                                <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th>Report Title</th>
                                        <th>Download or View</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Proposal Pipeline</td>
                                            <td><a class="download_csv" href="#" rel="activity">Download CSV</a></td>
                                        </tr>
                                        <tr>
                                            <td>Top 10 Proposals</td>
                                            <td><a class="download_csv" href="#" rel="topten">Download CSV</a></td>
                                        </tr>
                                        <tr>
                                            <td>Contact List</td>
                                            <td><a class="download_csv" href="#" rel="clientlist">Download CSV</a></td>
                                        </tr>
                                        <tr>
                                            <td>Lead Conversion</td>
                                            <td><a class="download_csv" href="#" rel="leadconversion">Download CSV</a></td>
                                        </tr>
                                        <?php
                                            foreach($statuses as $k => $v){
                                                ?>
                                        <tr>
                                            <td><?php echo $v;  ?> Proposals</td>
                                            <td><a class="download_csv" href="#" rel="<?php echo $k; ?>">Download CSV</a></p></td>
                                        </tr>
                                            <?php
                                            }
                                        ?>

                                    </tbody>

                                </table>

                            </div>
                        </div>
                    </td>
                </tr>
            </table>
            <input type="hidden" id="fileType" name="fileType" value="">
            <input type="hidden" id="reportType" name="reportType" value="">
        </div>
    </div>
</form>
<?php
/*

$accounts = $account->getCompany()->getAccounts();
$initialisedPrices = array(0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0);
$proposalPrices = array();
/*$proposalPrices['Open'] = $initialisedPrices;
$proposalPrices['Won'] = $initialisedPrices;
$proposalPrices['Completed'] = $initialisedPrices;
$proposalPrices['Lost'] = $initialisedPrices;
$proposalPrices['Cancelled'] = $initialisedPrices;
$proposalPrices['On Hold'] = $initialisedPrices;


$total = array();

foreach($statuses as $k=>$v){
    $proposalPrices[$k] = $initialisedPrices;
    $total[$k] = 0;
}



//here we calculate for all users...
$proposals = $account->getCompany()->getProposals();
$year = date('Y', time());
$theaccounts = array();
if (is_array(@$_POST['accounts'])) {
    foreach ($_POST['accounts'] as $accId => $on) {
        $theaccounts[] = $accId;
    }
}
foreach ($proposals as $proposal) {
    if ($year == date('Y', $proposal->getCreated(false))) {
        if ((!$_POST) || (in_array($proposal->getClient()->getAccount()->getAccountId(), $theaccounts))) {

            $dateKey = date('n', $proposal->getCreated(false)) - 1;

            // Non set key was causing notice generations
            if (!isset($proposalPrices[$proposal->getStatus()])){
                $proposalPrices[$proposal->getStatus()] = $initialisedPrices;
            }

            if ( !isset($proposalPrices[$proposal->getStatus()][$dateKey])){
                $proposalPrices[$proposal->getStatus()][$dateKey] = 0;
            }

            $proposalPrices[$proposal->getStatus()][$dateKey] += $proposal->getTotalPrice();

            if (!isset($total[$proposal->getStatus()])){
                $total[$proposal->getStatus()] = 0;
            }

            $total[$proposal->getStatus()] += $proposal->getTotalPrice();
        }
    }
}
*/
?>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
    google.load('visualization', '1', {packages:['corechart']});
    function drawVisualization(json_data) {
        // Create and populate the data table.
        var data = new google.visualization.DataTable();
        var raw_data = [];
        //override raw data with data got via ajax request
        raw_data = json_data.raw_data;
        var xLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        //override the X labels
        var xLabels = json_data.xLabels;

        data.addColumn('string', 'Month');
        for (var i = 0; i < raw_data.length; ++i) {
            data.addColumn('number', raw_data[i][0]);
        }

        data.addRows(xLabels.length);

        for (var j = 0; j < xLabels.length; ++j) {
            data.setValue(j, 0, xLabels[j].toString());
        }
        for (var i = 0; i < raw_data.length; ++i) {
            for (var j = 1; j < raw_data[i].length; ++j) {
                data.setValue(j - 1, i + 1, raw_data[i][j]);
            }
        }

        var formatter = new google.visualization.NumberFormat({
            fractionDigits:0,
            prefix:'$'
        });
        for (i = 1; i <= raw_data.length; i++) {
            formatter.format(data, i);
        }
        // Create and draw the visualization.
        new google.visualization.ColumnChart(document.getElementById('chart_div')).
                draw(data, {
                    title:json_data.title,
                    width:942,
                    height:430,
                    hAxis:{title:json_data.h_title/*, slantedText: true*/},
                    vAxis:{title:json_data.v_title, format:'$#,###'},
                    chartArea:{right:0}
                }
        );
    }
</script>
</div>
</div>
<!--#content-->
<script type="text/javascript">
    $(document).ready(function () {
        var latest_graphs;
        $("#reports-graph").dialog({
            autoOpen:false,
            width:980,
            height:530,
            resizable:false,
            modal:true,
            draggable:false,
            onCreate:function () {
            },
            buttons:{
                "Print Graph":function () {
                    var url = "<?php echo site_url('account/print_report') ?>";
                    window.open(url, 'print_report', 'scrollbars=no,menubar=no,height=600,width=960,resizable=yes,toolbar=no,status=no');
                    var oldTarget = $("#report_options").attr('target');
                    var oldAction = $("#report_options").attr('action');
                    $("#report_options").attr('target', 'print_report');
                    $("#report_options").attr('action', url);
                    $("#report_options").submit();
                    $("#report_options").attr('target', oldTarget);
                    $("#report_options").attr('action', oldAction);
                },
                Close:function () {
                    $(this).dialog("close");
                }
            }
        });
        $(".launch_reports").click(function () {
            $("#reportType").val($(this).attr('rel'));
            var rel = $(this).attr('rel');
            $("#reports-graph").html('<div id="chart_div"></div>');
            var url = "<?php echo site_url('ajax/json_report') ?>/" + rel;
            var graph_settings = {};
            graph_settings.from = $("#from").val();
            graph_settings.to = $("#to").val();
            graph_settings.statusApply = $('#statusApply').is(':checked') ? 1 : 0;
            graph_settings.statusFrom = $("#statusFrom").val();
            graph_settings.statusTo = $("#statusTo").val();
            var users = new Array();
            //set up title
            var title = 'Reports Graphs';
            switch (rel) {
                case 'activity':
                    title = 'Activity Total';
                    break;
                case 'open':
                    title = 'Open Proposals';
                    break;
                case 'won':
                    title = 'Won Proposals';
                    break;
                case 'completed':
                    title = 'Completed Proposals';
                    break;
                case 'lost':
                    title = 'Lost Proposals';
                    break;
                case 'cancelled':
                    title = 'Cancelled Proposals';
                    break;
                case 'on_hold':
                    title = 'On Hold Proposals';
                    break;
            }
            var months = [];
            months[1] = "January";
            months[2] = "February";
            months[3] = "March";
            months[4] = "April";
            months[5] = "May";
            months[6] = "June";
            months[7] = "July";
            months[8] = "August";
            months[9] = "September";
            months[10] = "October";
            months[11] = "November";
            months[12] = "December";
            from = graph_settings.from.split('/');
            to = graph_settings.to.split('/');
            //adjust for day ignore
            from[1] = from[2];
            to[1] = to[2];
            title = title + ' - ' + months[from[0]] + ' ' + from[1] + ' to ' + months[to[0]] + ' ' + to[1] + ' - Users: ';
            var userCount = 0;
            $("#users input:checked").each(function () {
                userCount++;
                users.push($(this).attr('id'));
                title = title + $(this).attr('class');
                if (userCount < $("#users input:checked").length) {
                    title = title + ', ';
                }
            });
            graph_settings.users = users;
            graph_settings.service = $("#service").val();
            latest_graphs = graph_settings;
            $.ajax({
                url:url,
                data:graph_settings,
                type:"POST",
                dataType:"json",
                success:function (data) {
                    drawVisualization(data);
                }
            });
            $("#reports-graph").dialog('open');
            $("#ui-dialog-title-reports-graph").html(title);
        });
        $(".download_csv").click(function () {
            if (getNumSelectedUsers() < 1) {
                swal('Please select at least one user');
                return false;
            }
            $("#fileType").val('csv');
            $("#reportType").val($(this).attr('rel'));
            $("#report_options").submit();
        });
        $(".download_pdf").click(function () {
            $("#fileType").val('pdf');
            $("#reportType").val($(this).attr('rel'));
            $("#report_options").submit();
        });
        $("#all").click(function () {
            $("#from").val('<?php echo date('n', $startDate) . '/1/' . date('Y', $startDate); ?>');
            $("#to").val('<?php echo date('n') . '/' . date('j', mktime(0, 0, 0, date('n') + 1, 1, date('Y')) - 100) . '/' . date('Y'); ?>');
            return false;
        });

        $("#statusAll").click(function () {
            $("#statusFrom").val('<?php echo date('n', $startDate) . '/1/' . date('Y', $startDate); ?>');
            $("#statusTo").val('<?php echo date('n') . '/' . date('j', mktime(0, 0, 0, date('n') + 1, 1, date('Y')) - 100) . '/' . date('Y'); ?>');
            return false;
        });

        // Enable / Disable status change date fields based on whether or not they are being applied
        $('#statusApply').change(function(){
            if($(this).is(':checked')){
                $("#statusTo, #statusFrom").attr('disabled', false);
            }
            else {
                $("#statusTo, #statusFrom").attr('disabled', true);
            }
        });

        $("#allUsers").click(function() {
           $('.userCheck').each(function() {
               $(this).prop('checked', true);
               $.uniform.update();
           });
            return false;
        });

        $("#noUsers").click(function() {
            $('.userCheck').each(function() {
                $(this).prop('checked', false);
                $.uniform.update();
            });
            return false;
        });

        function getNumSelectedUsers() {
            return $('.userCheck:checked').length;
        }
    });
</script>
<iframe src="<?php echo site_url('account/blank_page') ?>" frameborder="0" name="download_report_frame" width="1" height="1" style="visibility: hidden; display: none;"></iframe>
<div id="reports-graph" title="Reports Graph">
    <div id="chart_div"></div>
</div>
<?php $this->load->view('global/footer') ?>