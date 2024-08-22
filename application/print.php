<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>PMS Printable Reports</title>
</head>
<body>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script>
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
<script type="text/javascript">
    $(document).ready(function () {
        var rel = "<?php echo $_POST['reportType'] ?>";
        var url = "<?php echo site_url('account/json_report') ?>/" + rel;
        var graph_settings = {};
        graph_settings.from = "<?php echo $_POST['from'] ?>";
        graph_settings.to = "<?php echo $_POST['to'] ?>";
        graph_settings.service = <?php echo $_POST['service'] ?>;
        var users = new Array();
    <?php
    $users = (is_array(@$_POST['accounts'])) ? $_POST['accounts'] : array();
    foreach ($users as $uid => $name) {
        ?>
        users.push(<?php echo $uid ?>);
        <?php
    }
    ?>
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
        }
        $("#graphTitle").html($("#graphTitle").html() + title + ' - Users: ');
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
        title = title + ' - ' + months[from[0]] + ' ' + from[1] + ' to ' + months[to[0]] + ' ' + to[1] + ' - Users: ';
        graph_settings.users = users;
        latest_graphs = graph_settings;
        $.ajax({
            url:url,
            data:graph_settings,
            type:"POST",
            dataType:"json",
            success:function (data) {
                $("#graphTitle").html($("#graphTitle").html() + data.user_names);
                drawVisualization(data);
            }
        });
        $("#reports-graph").dialog('open');
        $("#ui-dialog-title-reports-graph").html(title);
    });
</script>
<h3 id="graphTitle">Reports Graph - </h3>

<div id="chart_div"></div>

<a href="#" onclick="window.print();return false;">Click to Print</a>
</body>
</html>