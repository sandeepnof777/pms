<?php $this->load->view('global/header'); ?>


<div id="content" class="clearfix javascript_loaded" style="text-align: center">
    <div class="widthfix">


        <div class="content-box">

            <div class="box-header">
                Connect to QuickBooks
            </div>

            <div class="box-content" style="padding: 20px;">

                <div>
                    <p>You are not currently connected to QuickBooks Online</p><br />
                    <ipp:connectToIntuit></ipp:connectToIntuit>
                </div>
            </div>
        </div>

    </div>
</div>

    <script type="text/javascript">
        intuit.ipp.anywhere.setup({
            menuProxy: '<?php //print($quickbooks_menu_url); ?>',
            grantUrl: '<?php echo site_url('account/quickbooks/oauth'); ?>'
        });
    </script>


<?php $this->load->view('global/footer'); ?>