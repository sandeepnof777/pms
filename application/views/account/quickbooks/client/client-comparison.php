<?php $this->load->view('global/header'); ?>

    <div id="content" class="clearfix javascript_loaded">
        <div class="widthfix">


            <div class="content-box">

                <div class="box-header">
                    Client Comparison
                </div>
                <div class="box-content" style="padding: 20px;">

                <?php
                    if($customer){
                        $this->load->view('account/quickbooks/client/client-comparison-table');
                    }
                    else {
                        echo '<p>The customer data from QuickBooks could not be loaded. If this error persists, please check the customer details on QuickBooks Online</p>';
                    }

                     ?>


                </div>

            </div>



        </div>
    </div>

<?php $this->load->view('global/footer'); ?>