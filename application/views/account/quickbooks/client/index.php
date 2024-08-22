<?php $this->load->view('global/header'); ?>

    <div id="content" class="clearfix javascript_loaded">
        <div class="widthfix">


            <div class="content-box">

                <div class="box-header">
                    Add Client to Quickbooks
                </div>
                <div class="box-content" style="padding: 20px;">


                    <div style="margin-bottom: 5px;">
                        <p style="font-size: 18px;">Records found that are similar in QuickBooks:  <span style="font-weight: bold;">Similar Records Found = <?php echo $matches; ?></span></p>
                        <br />
                        <p style="font-size: 14px;">We found <strong><?php echo $matches; ?> similar record(s)</strong> in QuickBooks that you will find below. Please choose to either Compare the QuickBooks record and blend with <?php echo site_name(); ?> or Ignore.</p>
                    </div>
                    <div class="clearfix" ></div>
                    <hr />

                    <form method="post">
                        <input type="hidden" name="action" value="matchOrNew" />


                        <div class="qbClientExpanderNoMatch" style="margin-top: 15px;">


                                <input type="submit" name="qbNew" class="btn ui-button update-button" value="Add" style="float: right; width: 80px;" />

                            <p style="font-size: 16px; padding: 5px;"><strong>Ignore</strong> - Create new QuickBooks Customer</p>

                        </div>

                        <?php
                            if($matches){
                                $this->load->view('account/quickbooks/invoice-matches');
                            }
                            else {
                                $this->load->view('account/quickbooks/create-new-qb-customer');
                            }
                        ?>
                        <!-- <button type="submit" class="btn">Confirm</button> -->

                    </form>


                </div>

            </div>



        </div>
    </div>
    <script type="text/javascript">
        $(document).ready(function () {

            $('a.qbClientExpand').click(function(){
                $(this).parent().find('.comparisonContent').slideToggle();
            });
        });
    </script>
<?php $this->load->view('global/footer'); ?>