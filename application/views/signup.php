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
                <h4>Sign Up<a href="<?php echo base_url() ?>" id="logo" style="float: right;"></a></h4>
            </div>
            <div class="box-content">
                <?php /*echo form_open('home/signup', array('class' => 'validate big form-validated', 'autocomplete' => 'off')); */?>
                <form action="<?php echo site_url('home/create_account') ?>" method="post" class="validate big form-validated">
                    <div id="step1">
                        <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
                            <tr class="even">
                                <td colspan="2">
                                    <h4>Step 1 - Enter Account Info</h4>
                                </td>
                            </tr>
                            <tr class="even">
                                <td colspan="2">
                                    To begin your yearly subscription, please enter all of you confidential information below:
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Company Name <span>*</span></label>
                                    <input tabindex="1" type="text" name="companyName" id="companyName" class="text required" value="<?php echo set_value('companyName'); ?>">
                                </td>
                                <td>
                                    <label>City <span>*</span></label>
                                    <input tabindex="21" type="text" name="city" id="city" class="text required" value="<?php echo set_value('city'); ?>">
                                </td>

                            </tr>
                            <tr class="even">
                                <td>
                                    <label>Company Website <span>*</span></label>
                                    <input tabindex="2" type="text" name="companyWebsite" id="companyWebsite" class="text required" value="<?php echo set_value('companyWebsite'); ?>">
                                </td>
                                <td>
                                    <label>State <span>*</span></label>
                                    <input tabindex="22" type="text" name="state" id="state" class="text required" value="<?php echo set_value('state'); ?>">
                                </td>

                            </tr>
                            <tr>
                                <td>
                                    <label>Company Phone <span>*</span></label>
                                    <input tabindex="3" type="text" name="companyPhone" id="companyPhone" class="text required" value="<?php echo set_value('companyPhone'); ?>">
                                </td>
                                <td>
                                    <label>Zip Code <span>*</span></label>
                                    <input tabindex="23" type="text" name="zipCode" id="zipCode" class="text required" value="<?php echo set_value('zipCode'); ?>">
                                </td>

                            </tr>
                            <tr class="even">
                                <td>
                                    <label>First Name <span>*</span></label>
                                    <input tabindex="4" type="text" name="firstName" id="firstName" class="text required" value="<?php echo set_value('firstName'); ?>">
                                </td>
                                <td>
                                    <label>Country <span>*</span></label>
                                    <input tabindex="24" type="text" name="country" id="country" class="text required" value="<?php echo set_value('country'); ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Last Name <span>*</span></label>
                                    <input tabindex="5" type="text" name="lastName" id="lastName" class="text required" value="<?php echo set_value('lastName'); ?>">
                                </td>
                                <td>
                                    <label>Address <span>*</span></label>
                                    <input tabindex="25" type="text" name="address" id="address" class="text required" value="<?php echo set_value('address'); ?>">
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <label>Title <span>*</span></label>
                                    <input tabindex="6" type="text" name="title" id="title" class="text required" value="<?php echo set_value('title'); ?>">
                                </td>
                                <td>
                                    <label>Cell Phone <span>*</span></label>
                                    <input tabindex="26" type="text" name="cellPhone" id="cellPhone" class="text required" value="<?php echo set_value('cellPhone'); ?>">
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Time Zone</label>
                                    <select tabindex="7" name="timeZone" id="timeZone">
                                        <option selected="selected" value="EST">Eastern Time</option>
                                        <option value="CST">Central Time</option>
                                        <option value="MST">Mountain Time</option>
                                        <option value="PST">Pacific Time</option>
                                    </select>
                                </td>
                                <td>
                                    <label>How did you hear about us?</label>
                                    <?php
                                    $options = array('Google' => 'Google', 'Trade Show' => 'Trade Show', 'Bing' => 'Bing', 'Yahoo' => 'Yahoo', 'Other' => 'Other');
                                    echo form_dropdown('hearaboutus', $options, $this->input->post('hearaboutus'), 'id="hearaboutus"  tabindex="27"');
                                    ?>
                                </td>
                            </tr>
                            <tr class="even">
                                <td colspan="2"><h4>Login Information</h4></td>
                            </tr>
                            <tr>
                                <td>
                                    <label>Email <span>*</span></label>
                                    <input tabindex="8" type="text" name="email" id="email" class="text required email" value="<?php echo set_value('email'); ?>">
                                </td>
                                <td>
                                    <label>Password <span>*</span></label>
                                    <input tabindex="28" type="password" name="pass" id="pass" class="text required" value="">
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <label>Re-Type Email <span>*</span></label>
                                    <input tabindex="9" type="text" name="email2" id="email2" equalTo="#email" class="text required email" value="<?php echo set_value('email'); ?>">
                                </td>
                                <td>
                                    <label>Retype Password <span>*</span></label>
                                    <input tabindex="29" type="password" name="passTwo" id="passTwo" class="text required" equalTo="#pass" value="">
                                </td>
                            </tr>

                            <tr>
                                <td></td>
                                <td class="clearfix">
                                    <input type="button" value="Next" name="next" class="submit btn goNext" style="float: right;">
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>


<script type="text/javascript" src="<?php echo site_url();?>/3rdparty/jquery.limit-1.2.source.js"></script>

<script type="text/javascript">
    jQuery.validator.addMethod("greaterThanZero", function (value, element) {
        return this.optional(element) || (parseFloat(value) >= 0);
    }, "Must be greater than zero");

    $(document).ready(function () {
        $("#form-validatedSeats").validate({
            rules:{
                seatsNumber:{
                    required:true,
                    number:true,
                    greaterThanZero:true
                }
            }
        });

    });
</script>
<!--#content-->
<?php $this->load->view('global/footer-global'); ?>