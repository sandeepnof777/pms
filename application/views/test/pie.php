

<div id="content" class="clearfix">
    <h2>Pie Chart Test</h2>

    <input type="text" id="chartData" value="">

    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">

        // Load the Visualization API and the piechart package.
        google.load('visualization', '1', {'packages':['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.setOnLoadCallback(drawChart);

        function drawChart() {
            var jsonData = $.ajax({
                url: "/ajax/chartData",
                dataType:"json",
                async: false
            }).responseText;

            data = JSON.parse(jsonData);

            // Create our data table out of JSON data loaded from server.
            var data = new google.visualization.DataTable(data.table);

            var formatter = new google.visualization.NumberFormat(
                {prefix: '$', pattern: '#,###,###'});
            formatter.format(data, 1); // Apply formatter to second column

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, {  width: 600,
                                height: 400,
                                sliceVisibilityThreshold:0,
                                pieSliceText: 'none',
                                pieHole: 0.3});
        }

    </script>



    <!--Div that will hold the pie chart-->
    <div id="chart_div"></div>
</div>

