<style type="text/css">
    #signup {
        width: 1000px;
    }

    .pricing label span {
        color: #000;
    }

    .pricing {
        font-size: 14px;
    }

    #step5 .selector {
        width: 53px;
    }

    #mCC .selector span {
        width: 23px;
    }

    #mCC span {

        width: 60px;
    }

    #mEcheck .selector span {
        width: 60px;
    }

    #mEcheck .selector {
        width: 100px;
    }

    .billingState .selector {
        width: 200px !important;
    }

    .billingState .selector  span {
        width: 140px;
    }

    #wheel {
        width: 300px;
        font-weight: bold;
        font-size: 14px;
    }

    #seatsPrice {
        font-weight: bold;
        font-size: 14px;
    }

    .pricing label {
        width: 88%;

    }

    .seatsNum {
        font-weight: bold;
        color: #444444;
    }

    .seatPrice {
        float: right;
        margin-right: 70px;
        font-weight: bold;
    }

    .pricing > span {
        font-weight: bold;
    }

    .pricing {
        line-height: 28px;
        width: 100% !important;
        text-align: left;
    }

    #totalPrice {
        width: 300px;
        font-weight: bold;
        font-size: 14px;
    }

    .part {
        width: 110px;
        float: left;
        line-height: 28px;
    }

    #ccInfo {
        width: 50%;
        float: right;
    }

    #ccName {
        width: 265px;
    }

    td strong {
        font-size: 14px;
    }

    .expired {
        color: #f00;
    }
</style>
<div style="padding: 100px 0 0;">
<div id="signup">
<div class="content-box">
<div class="box-header">
    <h4>Renew<a href="<?php echo base_url() ?>" id="logo" style="float: right;"></a></h4>
</div>
<div class="box-content">
<?php /*echo form_open('home/signup', array('class' => 'validate big form-validated', 'autocomplete' => 'off')); */?>
<form action="#" method="post" class="validate big form-validated" autocomplete="off">
    <div id="step1">
        <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
            <tr class="even">
                <td colspan="5"><h4>Step 1 - Select what to renew</h4></td>

            </tr>
            <tr>
                <td><strong>#</strong></td>
                <td><strong>Full Name</strong></td>
                <td><strong>Expires</strong></td>
                <td width="200"><strong>New Expiration Date</strong></td>
                <td><strong>Renew</strong></td>
            </tr>
            <?php
            $k = 0;
            foreach ($accounts as $account) {
                $k++;
                ?>
                <tr>
                    <td width="20">
                        <?php echo $k ?>
                    </td>
                    <td class="fulllName">
                        <?php echo $account->getFullName() ?>
                    </td>
                    <td <?php echo ($account->getExpires() < time()) ? 'class="expired"' : ''; ?>>
                        <?php echo ($account->getExpires() < time()) ? 'Expired' : date('m/d/y', $account->getExpires()); ?>
                    </td>
                    <td>
                        <span class="newDate">
                            <?php
                                echo ($account->getExpires() < time()) ? date('m/d/y', time() + (365 * 86400)):date('m/d/y', $account->getExpires() + (365 * 86400));
                            ?>
                        </span>
                    </td>
                    <td>
                        <input type="checkbox" name="<?php echo $account->getAccountId() ?>" class="renewIntem" <?php echo ($account->getExpires() < time()) ? 'checked' : ''; ?>>
                    </td>

                </tr>
                <?php
            }

            ?>
            <tr>
                <td colspan="5">
                    <input type="button" value="Next" class="submit btn goNext" style="float: right;">
                </td>
            </tr>

        </table>

    </div>

</form>

<form action="#" method="post" class="validate big form-validated" autocomplete="off">
<div id="step5">
<table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
<tr class="even">
    <td>
        <h4>Step 2 - Payment</h4>
    </td>
</tr>
<tr>
    <td>
        <h4>Pricing</h4>

        <div id="extendedPrice">

        </div>

        <!--<p id="wheel" class="pricing">
            <label style="text-align: left">Wheel It Off (one year subscription)</label>
            <span id="wheelPrice">$255</span>
        </p>-->

        <p id="totalPrice" class="pricing" style="border-top: 1px solid black;">
            <label style="text-align: left">Total</label>
            <span id="showTotal"></span>
        </p>

        <div class="method">
            <div class="part">Payment Method</div>
            <div class="part" style="width: 600px;">
                <label style="width: 107px; text-align: left"><input type="radio" class="changeMethod" name="ccType" value="creditCard" id="creditCard" checked="checked">Credit Card</label>

                <label style="width: 163px; text-align: left"><input type="radio" class="changeMethod" name="ccType" value="echeck" id="echeck">Echeck/Account Holder</label>
            </div>

        </div>
    </td>
</tr>
<tr class="even">
    <td class="ccDetails" style="padding: 0 !important;">
        <div id="ccInfo" style="padding: 20px;">
            It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose
            (injected humour and the like).
        </div>
        <div id="mEcheck">
            <table>
                <tr>
                    <td>
                        <label>Name on Check <span>*</span></label>
                        <input type="text" name="eName" id="eName" class="text" style="width: 250px;">
                    </td>
                </tr>
                <tr class="even">
                    <td>
                        <label>Routing Number <span>*</span></label>
                        <input type="text" name="eNumber" id="eNumber" class="text" style="width: 250px;">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Account Number <span>*</span></label>
                        <input type="text" name="eAccNumber" id="eAccNumber" class="text" style="width: 250px;">
                    </td>
                </tr>
                <tr class="even">
                    <td>
                        <label>Type Of Account</label>
                        <select name="eAccType" id="eAccType">
                            <option value="savings">Savings</option>
                            <option value="checking">Checking</option>
                        </select>
                    </td>
                </tr>
                <tr class="even">
                    <td>
                        <label>Holders Account</label>
                        <select name="eHType" id="eHType">
                            <option value="business">Business</option>
                            <option value="personal">Personal</option>
                        </select>
                    </td>
                </tr>
            </table>
        </div>
        <div id="mCC">
            <table>
                <tr class="even">
                    <td>
                        <label>Credit Card Number <span>*</span></label>
                        <input type="text" name="ccNumber" id="ccNumber" class="text" maxlength="16" minlength="16" style="width: 115px;">
                        <span id="charsLeft" style="line-height: 28px;"></span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Expiration Date</label>
                        <select name="expMonth" id="expMonth">
                            <?php
                            for ($i = 1; $i <= 12; $i++) {
                                ?>
                                <option value="<?php echo ($i < 10) ? '0' . $i : $i ?>"><?php echo ($i < 10) ? '0' . $i : $i ?></option>
                                <?php
                            }
                            ?>
                        </select>
                        /
                        <select name="expYear" id="expYear">
                            <?php
                            for ($i = 11; $i <= 18; $i++) {
                                ?>
                                <option value="<?php echo $i ?>"><?php echo $i ?></option>
                                <?php
                            }
                            ?>
                        </select>

                    </td>
                </tr>
                <tr class="even">
                    <td>
                        <label>CVV <span>*</span></label>
                        <input type="text" name="ccCVV" id="ccCVV" class="text" maxlength="3" style="width: 25px;" minlength="3">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Name On Card <span>*</span></label>
                        <input type="text" name="ccName" id="ccName" class="text">

                    </td>
                </tr>
                <tr>
                    <td style="text-align: center">
                        <img src="<?php echo site_url('static/images/discover.jpg') ?>" alt="">
                    </td>
                </tr>
            </table>

        </div>
    </td>
</tr>
<tr>
    <td style="padding: 0 !important;">
        <div id="billing-info">
            <table width="100%">
                <tr class="even">
                    <td><h4>Billing Information</h4></td>
                    <td>
                        <span style="color: #f00">*</span> Enter the billing address for the credit card entered above.
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>First Name <span>*</span></label>
                        <input type="text" name="billingFirstName" id="billingFirstName" class="text required">
                    </td>
                    <td>
                        <label>Address <span>*</span></label>
                        <input type="text" name="billingAddress1" id="billingAddress1" class="text required">
                    </td>
                </tr>
                <tr class="even">
                    <td>
                        <label>Last Name <span>*</span></label>
                        <input type="text" name="billingLastName" id="billingLastName" class="text required">
                    </td>
                    <td>
                        <label>Address 2</label>
                        <input type="text" name="billingAddress2" id="billingAddress2" class="text">
                    </td>
                </tr>
                <tr>
                    <td>
                        <label>Phone number <span>*</span></label>
                        <input type="text" name="billingPhone" id="billingPhone" class="text required">
                    </td>
                    <td>
                        <label>City <span>*</span></label>
                        <input type="text" name="billingCity" id="billingCity" class="text required">
                    </td>
                </tr>
                <tr class="even">
                    <td>
                        <label>E-mail <span>*</span></label>
                        <input type="text" name="billingEmail" class="text required" id="billingEmail">
                    </td>
                    <td>
                        <label>State <span>*</span></label>
                        <input type="text" name="billingState" id="billingState" class="text required">
                    </td>

                </tr>
                <tr>
                    <td>
                        <label>Re-type E-mail <span>*</span></label>
                        <input type="text" name="billingReEmail2" id="billingReEmail2" class="text required" equalTo="#billingEmail">
                    </td>
                    <td>
                        <label>Zipcode <span>*</span></label>
                        <input type="text" name="billingZip" id="billingZip" class="text required">
                    </td>
                </tr>
                <tr class="even">
                    <td>
                        <label>Company <span>*</span></label>
                        <input type="text" name="billingCompany" id="billingCompany" class="text required">
                    </td>
                    <td class="billingState">
                        <label>Country <span>*</span></label>
                        <input type="text" id="billingCountry" name="billingCountry" class="text required">

                    </td>
                </tr>
            </table>
        </div>
    </td>
</tr>
<tr class="even">
    <td class="clearfix">
        <input type="button" value="Back" name="back" class="submit btn goBack" style="float: left;">
        <input type="button" value="Finish" name="signup" id="submit" class="submit btn" style="float: right;">
    </td>
</tr>
<tr>
    <td style="text-align: right; color: red;">Please click finish just once to avoid double payments!</td>
</tr>
</table>
</div>

</form>
</div>
</div>
</div>
</div>
<div id="form-error" title="Error" style="height: 100px; text-align: center; padding: 20px;">
    <p id="error-message-popup-text">Something wrong happened</p>
</div>

<script type="text/javascript" src="<?php echo site_url('3rdparty/jquery.limit-1.2.source.js'); ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        var seatsNum = 0;
        var users= {};
        $('form').hide();
        $('.form-validated:first').show();

        $('.goNext').click(function () {
            if ($(this).parents('form').valid() == true) {
                var totalPrice = 0;

                $('#extendedPrice').html('');
                $('.renewIntem:checked').each(function () {
                    totalPrice += 1500;
                    seatsNum++;
                    var fullName = $(this).parents('tr').find('.fulllName').html();
                    users[seatsNum] = $(this).attr('name');

                    $('#extendedPrice').append(''+
                        '<p class="pricing">'+
                        '<span class="seatsPrice">1-Year Subscription for '+fullName+'</span>'+
                        '<span class="seatPrice">$1500</span>'+
                        '</p>'+
                    '');
                });
                if (totalPrice > 0) {
                    $(this).parents('form').hide();
                    $(this).parents('form').next().show();
                    $('#showTotal').html('$' + totalPrice);
                    var splus = 's';
                    if (seatsNum == 1) {
                        splus = '';
                    }
//                    $('.seatsNum').html('1-Year Subscription for ' + seatsNum + ' Account' + splus);
                }

            }
        });
        $('.goBack').click(function () {
            $(this).parents('form').hide();
            $(this).parents('form').prev().show();
        });

        $('.newDate').hide();
        $('.renewIntem:checked').each(function () {
            $(this).parents('tr').find('.newDate').show();
        });

        $('.renewIntem').click(function () {
            if ($(this).is(':checked')) {
                $(this).parents('tr').find('.newDate').show();
            } else {
                $(this).parents('tr').find('.newDate').hide();
            }
        });


        $('#ccNumber').addClass('required');
        $('#ccCVV').addClass('required');
        $('#ccName').addClass('required');
        $('#mEcheck').hide();
        $('.changeMethod').click(function () {
            if ($('#creditCard').is(':checked')) {
                $('#mCC').show();
                $('#mEcheck').hide();
                $('#ccNumber').addClass('required');
                $('#ccCVV').addClass('required');
                $('#ccName').addClass('required');

                $('#eNumber').removeClass('required');
                $('#eName').removeClass('required');
                $('#eAccNumber').removeClass('required');
            } else {
                if ($('#echeck').is(':checked')) {
                    $('#mCC').hide();
                    $('#mEcheck').show();
                    $('#ccNumber').removeClass('required');
                    $('#ccCVV').removeClass('required');
                    $('#ccName').removeClass('required');

                    $('#eNumber').addClass('required');
                    $('#eName').addClass('required');
                    $('#eAccNumber').addClass('required');
                }
            }
        });

        $('#submit').click(function () {
            if ($(this).parents('form').valid() == true) {
                $.ajax({
                    type:'POST',
                    data:{
                        "ccNumber":$('#ccNumber').val(),
                        "ccName":$('#ccName').val(),
                        "expMonth":$('#expMonth').val(),
                        "expYear":$('#expYear').val(),
                        "ccCVV":$('#ccCVV').val(),
                        "billingFirstName":$('#billingFirstName').val(),
                        "billingLastName":$('#billingLastName').val(),
                        "billingPhone":$('#billingPhone').val(),
                        "billingEmail":$('#billingEmail').val(),
                        "billingCompany":$('#billingCompany').val(),
                        "billingFranchise":$('#billingFranchise').val(),
                        "billingAddress1":$('#billingAddress1').val(),
                        "billingAddress2":$('#billingAddress2').val(),
                        "billingCity":$('#billingCity').val(),
                        "billingZip":$('#billingZip').val(),
                        "billingCountry":$('#billingCountry').val(),
                        "billingState":$('#billingState').val(),
                        "ccType":$('input[name=ccType]:checked').val(),
                        "eAccType":$('#eAccType').val(),
                        "eHType":$('#eHType').val(),
                        "eAccNumber":$('#eAccNumber').val(),
                        "eNumber":$('#eNumber').val(),
                        "eName":$('#eName').val(),
                        "seatsNumber":seatsNum,
                        "users":users
                    },
                    dataType:"json",
                    url:'/renew/renew_post',
                    error:function (XMLHttpRequest, textStatus, errorThrown) {
                        //$('body').html("XMLHttpRequest=" + XMLHttpRequest.responseText + "\ntextStatus=" + textStatus + "\nerrorThrown=" + errorThrown);
                        console.log(XMLHttpRequest.responseText);
                    },
                    success:function (response) {
                        if (response['success']) {
                            $("#error-message-popup-text").html('The subscription(s) have been added! You will be redirected to your account page in five seconds or you can click <a href="<?php echo site_url('account/my_account') ?>">here</a> to access your account!');
                            $("#form-error").dialog("open");
                            setTimeout(function () {
                                document.location.href = '<?php echo site_url('account/my_account') ?>';
                            }, 5000);
                        } else {
                            $("#error-message-popup-text").html('Your information is incorrect or your payment has been rejected. Please check your information or your credit balance and try again.');
                            $("#form-error").dialog("open");
                        }
                    }
                });
            }
            return false;
        });

        $("#form-error").dialog({
            width:400,
            modal:true,
            buttons:{
                Ok:function () {

                    $(this).dialog("close");
                }

            },
            autoOpen:false
        });

        $('#ccNumber').limit('16', '#charsLeft');

    });
</script>