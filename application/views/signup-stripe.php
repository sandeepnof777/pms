<?php $this->load->view('global/header-global'); ?>
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

    #seatsNum {
        font-weight: bold;
        color: #444444;
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
</style>
<div style="padding: 100px 0 0;">
    <div id="signup">
        <div class="content-box">
            <div class="box-header">
                <h4>Sign Up - <span id="box-title">Enter your information</span><a href="<?php echo site_url();?>" id="logo" style="float: right;"></a></h4>
            </div>
            <div class="box-content">
                <form action="#" method="post" class="validate big" id="signup-form">
                    <div id="step1">
                        <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
                            <tr class="even">
                                <td colspan="2">
                                    You are on your way to amazing proposals that will win more work! You have 2 simple steps to this process. #1. Enter your information as the account administrator. #2. Enter your payment information. Thank you!
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Company Name <span>*</span></label>
                                    <input tabindex="1" type="text" name="companyName" id="companyName" class="text required tiptip" title="Please enter your Company Name" value="<?php echo set_value('companyName'); ?>">
                                </td>
                                <td>
                                    <label>Cell Phone <span>*</span></label>
                                    <input tabindex="7" type="text" name="cellPhone" id="cellPhone" class="text required tiptip" title="Please enter your Cell Phone" value="<?php echo set_value('cellPhone'); ?>">
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <label>First Name <span>*</span></label>
                                    <input tabindex="4" type="text" name="firstName" id="firstName" class="text required tiptip" title="Please enter your First Name" value="<?php echo set_value('firstName'); ?>">
                                </td>
                                <td>
                                    <label>Email <span>*</span></label>
                                    <input tabindex="8" type="text" name="email" id="email" class="text required email tiptip" title="Please enter your Email address" value="<?php echo set_value('email'); ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Last Name <span>*</span></label>
                                    <input tabindex="5" type="text" name="lastName" id="lastName" class="text required tiptip" title="Please enter your Last Name" value="<?php echo set_value('lastName'); ?>">
                                </td>
                                <td>
                                    <label style="">Total Payment: </label>
                                    <label style="text-align: left;">$
                                        <input type="text" class="required number text greaterThanZero" id="costInput" style="width: 100px; float: right;" value="0" />
                                        <input type="hidden" class="" id="customCost" style="width: 100px; float: right;" value="0" />
                                    </label>
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <label>Title <span>*</span></label>
                                    <input tabindex="6" type="text" name="title" id="title" class="text required tiptip" title="Please enter your Title" value="<?php echo set_value('title'); ?>">
                                </td>
                                <td>
                                    <label>Website <span>*</span></label>
                                    <input type="text" name="website" id="website" tabindex="28" class="text required tiptip" title="Please enter your website here">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>How did you find us?</label>
                                    <?php
                                    $options = array('Google' => 'Google', 'Trade Show' => 'Trade Show', 'Bing' => 'Bing', 'Yahoo' => 'Yahoo', 'Other' => 'Other');
                                    echo form_dropdown('hearaboutus', $options, $this->input->post('hearaboutus'), 'id="hearaboutus"  tabindex="27"');
                                    ?>
                                </td>
                                <td>
                                    <input tabindex="99" type="checkbox" name="tos" class="required" id="tos">
                                    <label for="tos" style="width: 60%; line-height: 20px; text-align: left;">Accept <a href="<?php echo site_url();?>/terms-of-service/" target="_blank">Terms of Service</a>.</label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div style="position: relative;" class="clearfix">
                                        <div id="validation-error" class="error" style="width: 700px; margin: 0 auto; display: none; position: absolute; top: 0; left: 91px;">Errors occurred. Please fill in all the fields and make sure you accept the Terms of Service by checking the checkbox.</div>
                                        <input type="submit" tabindex="100" value="Next" name="signup" id="submit" class="submit btn" style="float: right;">
                                    </div>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
                <form id="payment-form" action="#" method="post" class="validate big" style="display: none;">
                    <div id="step2">
                        <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
                            <tr class="even">
                                <td width="50%">
                                    <label>Name on card <span>*</span></label>
                                    <input name="name" class="name text required tiptip" title="Name exactly how it is on the card" type="text" tabindex="100">
                                </td>
                                <td>
                                    <label>Card Number <span>*</span></label>
                                    <input name="card-number" type="text" size="20" autocomplete="off" tabindex="150" class="card-number text validateCC tiptip" title="Please enter your valid Credit card number" />
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Address Line 1 <span>*</span></label>
                                    <input name="address_line1" class="address_line1 text required tiptip" title="Please enter your Card Address here" type="text" tabindex="101">
                                </td>
                                <td>
                                    <label>CVC (<a href="#" id="cvv" title="">what's this?</a>)</label>
                                    <input name="card-cvc" type="text" size="4" autocomplete="off" class="card-cvc text validateCVC tiptip" title="Please enter your Card Verification Number" tabindex="151" />
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <label>Address Line 2</label>
                                    <input name="address_line2" class="address_line2 text tiptip" title="Please enter your Address" type="text" tabindex="102">
                                </td>
                                <td>
                                    <label>Expiration Month</label>
                                    <select name="expiry_month" class="card-expiry-month validateExp tiptip" title="Please choose your card's expiration month." tabindex="152">
                                        <option>01</option>
                                        <option>02</option>
                                        <option>03</option>
                                        <option>04</option>
                                        <option>05</option>
                                        <option>06</option>
                                        <option>07</option>
                                        <option>08</option>
                                        <option>09</option>
                                        <option>10</option>
                                        <option>11</option>
                                        <option>12</option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>State <span>*</span></label>
                                    <input name="address_state" class="address_state text required tiptip" title="Please enter your State" type="text" tabindex="103">
                                </td>
                                <td>
                                    <label>Expiration Year</label>
                                    <select name="expiry_year" class="card-expiry-year tiptip" title="Please enter your card's expiration year" tabindex="153">
                                    <?php
                                        $currentYear = date('Y');

                                        for ($i = 0; $i < 9; $i++){
                                           $year =  $currentYear + $i;
                                    ?>
                                        <option><?php echo $year ?></option>
                                    <?php
                                        }
                                    ?>
                                    </select></td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <label>Zip <span>*</span></label>
                                    <input name="address_zip" class="address_zip text required tiptip" title="Please enter your Zip Code" type="text" tabindex="104">
                                </td>
                                <td>
                                    <label style="">You will be charged: </label>
                                    <label style="text-align: left;">$<span class="cost" style="color: #000;"></span></label>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Country <span>*</span></label>
                                    <input name="address_country" class="address_country text required tiptip" title="Please enter your Country" type="text" tabindex="105">
                                </td>
                                <td>
                                    <div style="float: right;">
                                        <div class="g-recaptcha" data-sitekey="6LcGQxETAAAAAM0t6v7KJZi7Q2BItS0L2jtbog4n"></div>
                                    </div>
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <input id="back" type="button" value="Back" class="submit-button submit btn" style="float: left;">
                                </td>
                                <td>
                                    <input style="float: right;" tabindex="154" type="submit" class="submit-button submit btn" id="pay" value="Complete Payment">
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script type="text/javascript" src="https://js.stripe.com/v1/"></script>
<script type="text/javascript">
    Stripe.setPublishableKey('<?php echo STRIPE_PUBLIC_KEY; ?>');
</script>
<div id="form-error" title="Error" style="height: 100px; text-align: center; padding: 20px;">
    <p id="error-message-popup-text">Something wrong happened</p>
</div>

<div id="form-cvv" title="Card Verification Number" style="text-align: center; padding: 10px;">
    <img src="<?php echo site_url();?>/cvv.jpg" alt="">
</div>

<div id="security-error" title="Error" style="height: 100px; text-align: center; padding: 20px;">
    <p>You did not pass the security check. Please try again before submitting.</p>
</div>

<script type="text/javascript" src="<?php echo site_url();?>/3rdparty/jquery.limit-1.2.source.js"></script>

<script type="text/javascript">
    jQuery.validator.addMethod("greaterThanZero", function (value, element) {
        return this.optional(element) || (parseFloat(value) >= 0);
    }, "Must be greater than zero");
    jQuery.validator.addMethod('validateCC', function (value, element) {
        return Stripe.validateCardNumber(value);
    });
    jQuery.validator.addMethod('validateCVC', function (value, element) {
        return Stripe.validateCVC(value);
    });
    jQuery.validator.addMethod('validateExp', function (value, element) {
        var month = $(".card-expiry-month").val();
        var year = $(".card-expiry-year").val();
        if (year == <?php echo date('Y') ?>) {
            if (month<<?php echo date('n') ?>) {
                return false;
            }
        }
        return true;
//        return Stripe.validateExpiry(value, $(".card-expiry-year").val());
    });
    $(document).ready(function () {
        var url = '';
        $("#cvv").click(function () {
            $("#form-cvv").dialog("open");
            return false;
        });
        function addCommas(nStr)
        {
        	nStr += '';
        	x = nStr.split('.');
        	x1 = x[0];
        	x2 = x.length > 1 ? '.' + x[1] : '';
        	var rgx = /(\d+)(\d{3})/;
        	while (rgx.test(x1)) {
        		x1 = x1.replace(rgx, '$1' + ',' + '$2');
        	}
        	return x1 + x2;
        }
        $("#seatsNumber").change(function () {
            var seats = $("#seatsNumber").val();
            var price = 2100;

            if (seats == 0) {
                $("#cost1").hide();
                $("#customCost").show();
                $("#customCost").val('0');
                var cost = 0;
            }
            else {

                $("#cost1").show();
                $("#customCost").hide();

                if (seats > 5) {
                    price = 1900;
                }
                if (seats > 20) {
                    price = 1700;
                }
                var cost = seats * price;
            }
            $(".cost").html(addCommas(cost.toFixed(2)));
        });
        $("#costInput").bind("change paste keyup", function() {


            var costText = $(this).val();
            console.log(costText);
            var replaced = costText.replace(",", "");
            var num = parseFloat(replaced);
            var fixed = num.toFixed(2);
            console.log(fixed);

            $("#customCost").val(fixed);
            $(".cost").html(fixed);

        });
        Stripe.setPublishableKey('<?php echo STRIPE_PUBLIC_KEY; ?>'); //mike live
//        Stripe.setPublishableKey('pk_ELjWG8Nk2DwmKE908pfthSRdmGMQQ'); //chris test
//        Stripe.setPublishableKey('pk_CYt0FsG1cXQ8DCDjWJ3xynxuYeLSC'); //mike test
        function stripeResponseHandler(status, response) {
            if (response.error) {
                $('.submit-button').removeAttr("disabled");
                $("#error-message-popup-text").html('Oops! Something went wrong. Please review the following errors and try again: <br>' + response.error.message);
                $("#form-error").attr('title', 'Error').dialog("open");
                $("#pay").attr("value", "Complete Payment").removeAttr('disabled');
            } else {
                var token = response['id'];
                var request = $.ajax({
                    url:"<?php echo site_url('home/stripe_payment') ?>",
                    type:"POST",
                    data:{
                        "ignoreBots": 1,
                        "stripeToken":token,
                        "custom": $("#customCost").val(),
                        "company":$("#companyName").val(),
                        "name":$("#firstName").val() + ' ' + $("#lastName").val(),
                        "firstName":$("#firstName").val(),
                        "lastName":$("#lastName").val(),
                        "email":$("#email").val(),
                        "title":$("#title").val(),
                        "hearAboutUs":$("#hearaboutus").val(),
                        "cellPhone":$("#cellPhone").val(),
                        "website":$("#website").val()
                    },
                    dataType:"json",
                    success:function (data) {
                        if (data.success) {
                            url = '<?php echo site_url();?>';
                            $("#error-message-popup-text").html('Your payment has been approved! We will contact you in the next 30-60 minutes.');
                            $("#form-error").attr('title', 'Success').dialog("open");
                            $("#pay").attr("value", "Complete Payment").removeAttr('disabled');
                        } else {
                            $("#pay").attr("value", "Complete Payment").removeAttr('disabled');
                            if (data.error) {
                                $("#error-message-popup-text").html('Oops! Something went wrong. Please review the following errors and try again: <br>' + data.error);
                                $("#form-error").attr('title', 'Error').dialog("open");
                            } else {
                                $("#error-message-popup-text").html('Oops! Something went wrong. Please review the information you filled in and try again.');
                                $("#form-error").attr('title', 'Error').dialog("open");
                            }
                        }
                    }
                });
            }
        }

        $("#signup-form").validate({
            submitHandler:function (form) {
                $("#signup-form").hide();
                $("#payment-form").show();
                $("#box-title").html('Payment Information');
                return false;
            }
        });
        $("#back").click(function() {
            $("#signup-form").show();
            $("#payment-form").hide();
            $("#box-title").html('Enter your information');
        });
        $("#payment-form").validate({
            submitHandler:function (form) {

                var reCaptchaVal = grecaptcha.getResponse();
                if (reCaptchaVal.length < 1) {
                    $("#security-error").dialog('open');
                    return false;
                }
                else {
                    $("#pay").attr("value", "Please wait..").attr('disabled', 'disabled');
                    Stripe.createToken({
                        number:$('.card-number').val(),
                        cvc:$('.card-cvc').val(),
                        exp_month:$('.card-expiry-month').val(),
                        exp_year:$('.card-expiry-year').val()
                    }, stripeResponseHandler);
                    return false;
                }
            }
        });

        $("#chooseCustom").click(function() {
            $(".cost").hide();
            $("#customCost").show();
        })

        $("#form-error").dialog({
            width:400,
            modal:true,
            buttons:{
                Ok:function () {
                    $(this).dialog("close");
                }
            },
            autoOpen:false,
            close:function () {
                if (url != '') {
                    document.location.href = url;
                }
            }
        });

        $("#form-cvv").dialog({
            width:400,
            modal:true,
            buttons:{
                Close:function () {
                    $(this).dialog("close");
                }
            },
            autoOpen:false
        });

        $("#security-error").dialog({
            width:400,
            modal:true,
            buttons:{
                Ok:function () {
                    $(this).dialog("close");
                }
            },
            autoOpen:false
        });
    });
</script>
<!--#content-->
<?php $this->load->view('global/footer-global'); ?>