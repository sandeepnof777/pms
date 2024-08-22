<?php $this->load->view('global/header'); ?>

    <div id="content" class="clearfix javascript_loaded">
        <div class="widthfix">

            <div class="content-box">

                <div class="box-header">
                    Invoice Via QuickBooks
                </div>
                <div class="box-content" style="padding: 20px;">

                    <p>In order for an invoice to be generated in QuickBooks, it must be attached to a customer.</p>

                    <p>You can create your <?php echo SITE_NAME;?> client as a new QuickBooks customer, or match them to an existing QuickBooks customer if we can find any matches.</p>

                    <p>Select an option from below.</p>

                    <h3><?php echo $matches; ?> Matching Quickbooks Customers Found for: <?php echo $proposal->getClient()->getFullName(); ?> - <?php echo $proposal->getClient()->getCompanyName(); ?></h3>

                    <form method="post">
                        <input type="hidden" name="action" value="matchOrNew" />

                    <?php
                    if($matches){
                        $this->load->view('account/quickbooks/invoice-matches');
                    }
                    else {
                        $this->load->view('account/quickbooks/create-new-qb-customer');
                    }


                    ?>
                    <button type="submit" class="btn">Confirm</button>

                    </form>

                </div>

            </div>



        </div>
    </div>

<?php $this->load->view('global/footer'); ?>