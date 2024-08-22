<?php $this->load->view('global/header'); ?>
    <div id="content" class="clearfix">

        <h1>Dashboard Statistics / Gauges</h1>

        <h2>User Dashboard - <?php echo $account->getFullName(); ?></h2>



        <div class="statBox">
            <h3>Total Proposals</h3>
            <span class="statInfo">Created This Month</span>
            <hr />
            <div class="statValue"><?php echo $calendarMonthProposalCount; ?></div>
        </div>



        <div class="statBox">
            <h3>Proposals Value</h3>
            <span class="statInfo">of proposals created this month</span>
            <hr />
            <div class="statValue"><?php echo readableValue($calendarMonthProposalPrice); ?></div>
        </div>




        <div class="statBox">
            <h3>Completed</h3>
            <span class="statInfo">Opened and completed this month</span>
            <hr />
            <div class="statValue"><?php echo $calendarMonthProposalsCompletedPct; ?>%</div>

        </div>


        <div class="statBox">
            <h3>Won Proposal Value</h3>
            <span class="statInfo"><?php echo  readableValue($calendarMonthProposalsWonValue); ?></span>
            <hr />
            <div class="statValue"><?php echo $calendarMonthProposalsWonPct; ?>%</div>

        </div>


    </div>
    <script type="text/javascript">
        $(document).ready(function () {


        });
    </script>
<?php $this->load->view('global/footer'); ?>