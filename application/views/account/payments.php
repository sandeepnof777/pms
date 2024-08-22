<?php $this->load->view('global/header'); ?>
<style type="text/css">
    .moreInfo {
        height: 100px; padding: 20px; display: none;
        text-align: left;

    }
    .moreInfo p strong {
        text-align: right;
        margin-right: 10px;
        width: 140px;
    }
</style>
<div id="content" class="clearfix">
    <div class="widthfix">
        <div class="content-box">
            <div class="box-header">
                Payment History <a class="box-action" href="<?php echo site_url('account/my_account') ?>">Back</a>
            </div>
            <div class="box-content">
                <table cellpadding="0" cellspacing="0" border="0" class="dataTables display">
                    <thead>
                    <tr>
                        <td>#</td>
                        <td>Date</td>
                        <td>Amount</td>
                        <td>Description</td>
                        <td>Payment Type</td>
                        <td>Payment Status</td>
                        <td>Details</td>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    $k = 0;
                    foreach ($payments as $payment) {
                        $k++;
                        ?>
                    <tr>
                        <td><?php echo $k ?></td>
                        <td><?php echo date('d-m-Y',$payment->getAdded()); ?></td>
                        <td><?php echo $payment->getAmount(); ?></td>
                        <td><?php echo $payment->getOrderDescription(); ?></td>
                        <td><?php echo $payment->getPayment() == 'creditcard' ?  'Credit Card':'Account Holder/E-check'; ?></td>
                        <td><?php echo $payment->getStatus(); ?></td>
                        <td>
                            <a href="#" class="btn-view showDialog" rel="details-<?php echo $payment->getPaymentId(); ?>">#</a>
                            <div id="details-<?php echo $payment->getPaymentId(); ?>" title="Payment Details" class="moreInfo">
                                <p class="clearfix">
                                    <h4 style="color: #fff">Billing Information</h4>
                                </p>
                                <p class="clearfix">
                                    <strong class="fixed-width-strong">CC Number:</strong>
                                    <span><?php echo $payment->getCcnumber(); ?></span>
                                </p>
                                <p class="clearfix">
                                    <strong class="fixed-width-strong">Amount:</strong>
                                    <span><?php echo $payment->getAmount(); ?></span>
                                </p>
                                <p class="clearfix">
                                    <strong class="fixed-width-strong">Payment:</strong>
                                    <span><?php echo $payment->getPayment() == 'creditcard' ?  'Credit Card':'Account Holder/E-check'; ?></span>
                                </p>
                                <p class="clearfix">
                                    <strong class="fixed-width-strong">Order Description:</strong>
                                    <span><?php echo $payment->getOrderDescription(); ?></span>
                                </p>
                                <p class="clearfix">
                                    <strong class="fixed-width-strong">Transaction ID:</strong>
                                    <span><?php echo $payment->getOrderId(); ?></span>
                                </p>
                                <p class="clearfix">
                                    <strong class="fixed-width-strong">First Name:</strong>
                                    <span><?php echo $payment->getFirtstName(); ?></span>
                                </p>
                                <p class="clearfix">
                                    <strong class="fixed-width-strong">Last Name:</strong>
                                    <span><?php echo $payment->getLastName(); ?></span>
                                </p>
                                <p class="clearfix">
                                    <strong class="fixed-width-strong">Company:</strong>
                                    <span><?php echo $payment->getCompany(); ?></span>
                                </p>
                                <p class="clearfix">
                                    <strong class="fixed-width-strong">Address1:</strong>
                                    <span><?php echo $payment->getAddress1(); ?></span>
                                </p>
                                <p class="clearfix">
                                    <strong class="fixed-width-strong">Address2:</strong>
                                    <span><?php echo $payment->getAddress2(); ?></span>
                                </p>
                                <p class="clearfix">
                                    <strong class="fixed-width-strong">City:</strong>
                                    <span><?php echo $payment->getCity(); ?></span>
                                </p>
                                <p class="clearfix">
                                    <strong class="fixed-width-strong">State:</strong>
                                    <span><?php echo $payment->getState(); ?></span>
                                </p>
                                <p class="clearfix">
                                    <strong class="fixed-width-strong">Zip:</strong>
                                    <span><?php echo $payment->getZip(); ?></span>
                                </p>
                                <p class="clearfix">
                                    <strong class="fixed-width-strong">Country:</strong>
                                    <span><?php echo $payment->getCountry(); ?></span>
                                </p>
                                <p class="clearfix">
                                    <strong class="fixed-width-strong">Phone:</strong>
                                    <span><?php echo $payment->getPhone(); ?></span>
                                </p>
                                <p class="clearfix">
                                    <strong class="fixed-width-strong">E-mail:</strong>
                                    <span><?php echo $payment->getEmail(); ?></span>
                                </p>
                                <p class="clearfix">
                                    <strong class="fixed-width-strong">IP Address:</strong>
                                    <span><?php echo $payment->getIpAddress(); ?></span>
                                </p>
                                <p class="clearfix">
                                    <strong class="fixed-width-strong">Details:</strong>
                                    <span><?php echo $payment->getDetails(); ?></span>
                                </p>
                                <p class="clearfix">
                                    <strong class="fixed-width-strong">Status:</strong>
                                    <span><?php echo $payment->getStatus(); ?></span>
                                </p>
                                <p class="clearfix">
                                    <strong class="fixed-width-strong">Added:</strong>
                                    <span><?php echo date('d-m-Y',$payment->getAdded()); ?></span>
                                </p>

                            </div>
                        </td>
                    </tr>
                        <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
        <script type="text/javascript">
            $(document).ready(function () {

            });
        </script>
    </div>
</div>
<!--#content-->
<?php $this->load->view('global/footer'); ?>

<script type="text/javascript">
    $(document).ready(function() {
        $('.btn-view').button({
            icons:{
                primary:"ui-icon-newwin"
            },
            text:false
        });
        $('.showDialog'). click(function() {
            $('#'+$(this).attr('rel')).dialog({
                width:600,
                modal:true,
                buttons:{
                    Ok:function () {
                        $(this).dialog("close");
                    }

                }
            });
        });
    });
</script>