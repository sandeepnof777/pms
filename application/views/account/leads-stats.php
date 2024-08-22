<div id="headline-stats-leads" class="statTypeContainer">


    <!--ROW 1 START-->
    <div class="statsRow">

        <div class="statBox totalStat">
            <div class="statHeading">
                <a class="statDrilldownLeads" data-base-link="<?php echo site_url('leads/index/filter/status/Active'); ?>" href="<?php echo site_url('leads/index/filter/status/Active'); ?>">Active</a>
            </div>
            <div class="singleValue">
                <span id="leadsActive"></span>
            </div>
        </div>

        <div class="statBox">
            <div class="statHeading">
                <a class="statDrilldownLeads" data-base-link="<?php echo site_url('leads/index/filter/age/new'); ?>" href="<?php echo site_url('leads/index/filter/age/new'); ?>">
                    <span class="push-up">New Leads</span>
                    <span class="sub-title"><2 days old</span>
                </a>
            </div>
            <div class="singleValue">
                <span id="leadsNew"></span>
            </div>
        </div>

        <div class="statBox">
            <div class="statHeading">
                <a class="statDrilldownLeads" data-base-link="<?php echo site_url('leads/index/filter/age/current'); ?>" href="<?php echo site_url('leads/index/filter/age/current'); ?>">
                    <span class="push-up">Current Leads</span>
                    <span class="sub-title">2-7 days old</span>
                </a>
            </div>
            <div class="singleValue">
                <span id="leadsCurrent"></span>
            </div>
        </div>

        <div class="statBox">
            <div class="statHeading">
                <a class="statDrilldownLeads" data-base-link="<?php echo site_url('leads/index/filter/age/old'); ?>" href="<?php echo site_url('leads/index/filter/age/old'); ?>">
                    <span class="push-up">Old Leads</span>
                    <span class="sub-title"><7 days old</span>
                </a>
            </div>
            <div class="singleValue">
                <span id="leadsOld"></span>
            </div>
        </div>
        
    </div><!--ROW 1 END-->

    <!--ROW 2 START-->
    <div class="statsRow">

        <div class="statBox proposalCount">
            <div class="statHeading">
                <a class="statDrilldownLeadsz" data-base-link="#" href="#<?php //echo site_url('leads/index/filter/status/All'); ?>">Added</a>
            </div>
            <div class="singleValue">
                <span id="leadsAdded"></span>
            </div>
        </div>

        <div class="statBox rollover">
            <div class="statHeading">
                <a class="statDrilldownLeads" data-base-link="<?php echo site_url('leads/index/filter/status/Cancelled'); ?>" href="<?php echo site_url('leads/index/filter/status/Cancelled'); ?>">Cancelled</a>
            </div>
            <div class="singleValue">
                <span id="leadsCancelled"></span>
            </div>
        </div>

        <div class="statBox avgStat">
            <div class="statHeading">
                <a class="statDrilldownLeads" data-base-link="<?php echo site_url('leads/index/filter/status/Converted'); ?>" href="<?php echo site_url('leads/index/filter/status/Converted'); ?>">Converted</a>
            </div>
            <div class="singleValue">
                <span id="leadsConverted"></span>
            </div>
        </div>

        <div class="statBox">
            <div class="statHeading">
                Avg. Conv. Days
            </div>
            <div class="singleValue">
                <span id="leadsAvgConversion"></span>
            </div>
        </div>

    </div><!--ROW 2 END-->
</div>

<div class="clearfix"></div>