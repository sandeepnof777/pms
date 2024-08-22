<?php $this->load->view('global/header'); ?>

    <div id="content" class="clearfix javascript_loaded">
        <div class="widthfix">

            <div class="content-box">

                <div class="box-header">
                    Invoice Via QuickBooks
                </div>
                <div class="box-content" style="padding: 20px;">

                    <?php
                        $this->load->view('account/quickbooks/invoice-client-comparison');
                    ?>

                </div>

            </div>



        </div>
    </div>

<?php $this->load->view('global/footer'); ?>