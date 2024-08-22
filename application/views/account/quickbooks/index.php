<?php $this->load->view('global/header'); ?>

    <div id="content" class="clearfix javascript_loaded" style="text-align: center">
        <div class="widthfix">

            <script type="text/javascript">
                intuit.ipp.anywhere.setup({
                    menuProxy: '<?php echo QBModel::MENU_URL; ?>'
                });
            </script>


            <ipp:blueDot></ipp:blueDot>

            <?php $this->load->view('account/quickbooks/disconnect'); ?>


        </div>
    </div>

<?php $this->load->view('global/footer'); ?>