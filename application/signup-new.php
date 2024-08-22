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
                <form action="<?php echo site_url('home/create_account') ?>" method="post" class="validate big" id="signup-form">
                    <div id="step1">
                        <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
                            <tr class="even">
                                <td colspan="2">
                                    Please enter all of you confidential information below. <br>
                                    After you enter your information and submit the form, you will be contacted shortly with payment and set up informtion.
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
                                    <label style="width: 145px;">Total Users<span>*</span></label>
                                    <input tabindex="26" type="text" name="seatsNumber" id="seatsNumber" maxlength="4" class="text required tiptip" title="Please enter the number of users" value="1" style="width: 35px;">
                                </td>
                            </tr>
                            <tr class="even">
                                <td>
                                    <label>Title <span>*</span></label>
                                    <input tabindex="6" type="text" name="title" id="title" class="text required tiptip" title="Please enter your Title" value="<?php echo set_value('title'); ?>">
                                </td>
                                <td>
                                    <label>How did you find us?</label>
                                    <?php
                                    $options = array('Google' => 'Google', 'Trade Show' => 'Trade Show', 'Bing' => 'Bing', 'Yahoo' => 'Yahoo', 'Other' => 'Other');
                                    echo form_dropdown('hearaboutus', $options, $this->input->post('hearaboutus'), 'id="hearaboutus"  tabindex="27"');
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                </td>
                                <td>
                                    <input tabindex="99" type="checkbox" name="tos" class="required" id="tos">
                                    <label for="tos" style="width: 60%; line-height: 20px; text-align: left;">Accept <a href="<?php echo site_url();?>/terms-of-service/">Terms of Service</a>.</label>
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <div style="position: relative;" class="clearfix">
                                        <div id="validation-error" class="error" style="width: 700px; margin: 0 auto; display: none; position: absolute; top: 0; left: 91px;">Errors occurred. Please fill in all the fields and make sure you accept the Terms of Service by checking the checkbox.</div>
                                        <input type="submit" tabindex="100" value="Finish" name="signup" id="submit" class="submit btn" style="float: right;">
                                    </div>
                                </td>
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

<script type="text/javascript" src="<?php echo site_url();?>/3rdparty/jquery.limit-1.2.source.js"></script>

<script type="text/javascript">
    jQuery.validator.addMethod("greaterThanZero", function (value, element) {
        return this.optional(element) || (parseFloat(value) >= 0);
    }, "Must be greater than zero");

    $(document).ready(function () {

        $("#signup-form").validate({
            /*invalidHandler:function (form, validator) {
                $("#validation-error").show();
            },
            submitHandler:function (form) {
//                $(form).submit();
            }*/
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

    });
</script>
<!--#content-->
<?php $this->load->view('global/footer-global'); ?>