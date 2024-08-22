<?php $this->load->view('global/header-admin'); ?>
<style type="text/css">
    h2 {font-size: 26px; color: #84868e; line-height: 40px; margin: 0 0 15px 0; font-weight: normal; text-shadow: none;}
    .admin-stat {width: 150px; margin-right: 50px; float: left; border: 1px solid #ddd; padding: 15px 18px; border-radius: 3px; margin-bottom: 25px; box-shadow: 1px 1px 1px rgba(0,0,0,0.04);}
    .admin-stat.last {margin-right: 0;}
    .admin-stat .stat-heading {font-size: 24px; color: #85868d; display: block; text-align: center;}
    .chart {width: 110px; height: 110px; margin: 0 auto;}
</style>
<div id="content" class="clearfix">
    <div class="widthfix">
        <div id="admin-dashboard" class="clearfix">
            <div class="clearfix">
                <h2>Companies (<?php echo $companiesstats ?> Total) <a href="<?php echo site_url('admin') ?>">[Manage Companies]</a></h2>
                <div class="admin-stat">
                    <div class="chart" data-percent="73">

                    </div>
                    <span class="stat-heading">
                        Active
                        <span class="right"><?php echo $companiesActive ?></span>
                    </span>
                </div>
                <div class="admin-stat">
                    <div class="chart" data-percent="73">73%</div>
                    <span class="stat-heading">
                        Trial
                        <span class="right"><?php echo $companiesTrial ?></span>
                    </span>
                </div>
                <div class="admin-stat">
                    <div class="chart" data-percent="73">73%</div>
                    <span class="stat-heading">
                        Inactive
                        <span class="right"><?php echo $companiesInactive ?></span>
                    </span>
                </div>
                <div class="admin-stat last">
                    <div class="chart" data-percent="73">73%</div>
                    <span class="stat-heading">
                        Test
                        <span class="right"><?php echo $companiesTest ?></span>
                    </span>
                </div>
            </div>
            <div class="clearfix">
                <h2>Users (<?php echo $accounts ?> Total)</h2>
            </div>
        </div>


        <script>
            $(document).ready(function() {
                $('.chart').easyPieChart({
                    //your configuration goes here
                });
            });
        </script>


    </div>
</div>
<?php $this->load->view('global/footer'); ?>
