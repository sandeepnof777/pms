<?php $this->load->view('global/header'); ?>
    <div id="content" class="clearfix">

        <div class="content-box">

            <div class="box-header">
                Stats Table
            </div>

            <div class="box-content">

                <table id="userStatsTable" style="width: 100%">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Proposals</th>
                            <th>Total Bid Amt</th>
                            <th>Total Bid</th>
                            <th>Open Bid Amt</th>
                            <th>Open $</th>
                            <th>Open %</th>
                            <th>Won Bid Amt</th>
                            <th>Won $</th>
                            <th>Won %</th>
                            <th>Lost Bid Amt</th>
                            <th>Lost $</th>
                            <th>Lost %</th>
                            <th>Completed Bid Amt</th>
                            <th>Completed $</th>
                            <th>Completed %</th>
                            <th>Rollover Amt</th>
                            <th>Rollover</th>
                            <th>Magic Number Amt</th>
                            <th>Magic Number</th>
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                </table>
            </div>

        </div>

    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            $("#userStatsTable").dataTable({
                "bAutoWidth" : true,
                "bProcessing": true,
                "sAjaxSource": '<?php echo site_url('ajax/dashboardTable'); ?>',
                "aoColumns": [
                {"sWidth" : "15%"},                     // 0  User
                    null,                               // 1 Num Proposals
                    {"bVisible" : false},               // 2 Int bid value
                    {"iDataSort": 2, "type": "html"},   // 3 Readable bid value
                    {"bVisible" : false},   // 4 Int Open value
                    {"iDataSort": 4},       // 5 Readable Open Value
                    null,                   // 6 Open Bid %
                    {"bVisible" : false},   // 7 Won Bid Amt
                    {"iDataSort": 7},       // 8 Readable Won Amount
                    null,                   // 9 Won Bid %
                    {"bVisible" : false},   // 10 Lost Bid Amt
                    {"iDataSort": 10},      // 11 Readable Won Amt
                    null,                   // 12 Won %
                    {"bVisible" : false},   // 13 Lost Bid Amt
                    {"iDataSort": 13},      // 14 Readable Won Amt
                    null,                   // 15 Won %
                    {"bVisible" : false},   // 16 Rollover Amt
                    {"iDataSort": 16},      // 17 Readable Rollover
                    {"bVisible" : false},   // 18 Rollover Amt
                    {"iDataSort": 18}       // 19 Readable Rollover
                ]
            });

        });
    </script>
<?php $this->load->view('global/footer'); ?>