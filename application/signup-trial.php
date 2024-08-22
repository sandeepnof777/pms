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
                <h4>Trial Sign Up <a href="<?php echo site_url();?>" id="logo" title="Go back to <?php echo SITE_NAME;?>" style="float: right;"></a></h4>
            </div>
            <div class="box-content">
                <form action="#" method="post" class="validate big" id="signup-form">
                    <div id="step1">
                        <table cellpadding="0" cellspacing="0" width="100%">
                            <tr>
                                <td width="50%" valign="top">
                                    <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
                                        <tr>
                                            <td>
                                                <label>Company Name <span>*</span></label>
                                                <input tabindex="1" type="text" name="companyName" id="companyName" class="text required tiptip" title="Please enter your Company Name" value="<?php echo set_value('companyName'); ?>">
                                            </td>
                                        </tr>
                                        <tr class="even">
                                            <td>
                                                <label>First Name <span>*</span></label>
                                                <input tabindex="4" type="text" name="firstName" id="firstName" class="text required tiptip" title="Please enter your First Name" value="<?php echo set_value('firstName'); ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>Last Name <span>*</span></label>
                                                <input tabindex="5" type="text" name="lastName" id="lastName" class="text required tiptip" title="Please enter your Last Name" value="<?php echo set_value('lastName'); ?>">
                                            </td>
                                        </tr>
                                        <tr class="even">
                                            <td>
                                                <label>Title <span>*</span></label>
                                                <input tabindex="6" type="text" name="title" id="title" class="text required tiptip" title="Please enter your Title" value="<?php echo set_value('title'); ?>">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <label>Cell Phone <span>*</span></label>
                                                <input tabindex="7" type="text" name="cellPhone" id="cellPhone" class="text required tiptip" title="Please enter your Cell Phone" value="<?php echo set_value('cellPhone'); ?>">
                                            </td>
                                        </tr>
                                        <tr class="even">
                                            <td>
                                                <label>Email <span>*</span></label>
                                                <input tabindex="8" type="text" name="email" id="email" class="text required email tiptip validEmail" title="Please enter your Email address" value="<?php echo set_value('email'); ?>">
                                            </td>
                                        </tr>
                                        <tr class="">
                                            <td>
                                                <label>&nbsp;</label>
                                                <input tabindex="99" type="checkbox" name="tos" class="required" id="tos">
                                                <label for="tos" style="width: 60%; line-height: 20px; text-align: left;">Accept <a href="<?php echo site_url();?>/terms-of-service/" target="_blank">Terms of Service</a>.</label>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>
                                                <div style="position: relative;" class="clearfix">
                                                    <label>&nbsp;</label>
                                                    <input type="submit" tabindex="100" value="Create Trial Account" name="signup" id="submit" class="submit btn" style="float: left; margin-left: 55px;">
                                                </div>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                                <td valign="top" style="background: #fefefe; border-left: 1px solid #eee;">
                                    <div style="padding: 0 30px;">
                                        <h4 style="text-align: center;">No downloads. No software to install. Win More Work!</h4>
                                        <p style="font-size: 14px;">Register now and for 14 days you’ll have access to a trial set of top features and capabilities of easiest way to create, manage & track your proposals in the pavement industry.  See for yourself how to create proposals 90% faster and increase win rates by more than 40%.</p>
                                        <p>&nbsp;</p>
                                        <p style="text-align: center; padding-bottom: 10px;">
                                            <img src="<?php site_url() ?>/static/images/pms-screen.jpg" alt="" class="shadowed" style="width: 300px; height: auto;">
                                        </p>
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
<div id="form-error" title="Notice" style="height: 100px; text-align: center; padding: 20px;">
    <p id="error-message-popup-text">Something wrong happened</p>
</div>

<script type="text/javascript" src="<?php echo site_url();?>/3rdparty/jquery.limit-1.2.source.js"></script>

<script type="text/javascript">
    jQuery.validator.addMethod("greaterThanZero", function (value, element) {
        return this.optional(element) || (parseFloat(value) >= 0);
    }, "Must be greater than zero");
    $(document).ready(function () {
        var url = '';
        $("#signup-form").validate({
            submitHandler:function (form) {
                $("#submit").val('Please wait...').attr('disabled', 'disabled');
                var request = $.ajax({
                    url:"<?php echo site_url('home/create_trial_account') ?>",
                    type:"POST",
                    data:{
                        "company":$("#companyName").val(),
                        "firstName":$("#firstName").val(),
                        "lastName":$("#lastName").val(),
                        "email":$("#email").val(),
                        "title":$("#title").val(),
                        "cellPhone":$("#cellPhone").val()
                    },
                    dataType:"json",
                    success:function (data) {
                        if (data.success) {
                            url = '<?php echo site_url();?>';
                            $("#error-message-popup-text").html('Get Ready for Simple!  <br>Your Trial Account is created and you will get an email in a couple of seconds with login details.<br>You also will get 2 additional example emails showing off how we can send "Leads" & "A New New Proposal"  If you have any questions, please contact us at <a href="mailto:support@<?php echo SITE_EMAIL_DOMAIN;?>">support@<?php echo SITE_EMAIL_DOMAIN;?></a> at any time!');
                            $("#form-error").attr('title', 'Success').dialog("open");
                        } else {
                            if (data.error) {
                                $("#error-message-popup-text").html('Oops! Something went wrong. Please review the following errors and try again: <br>' + data.error);
                                $("#form-error").attr('title', 'Error').dialog("open");
                            } else {
                                $("#error-message-popup-text").html('Oops! Something went wrong. Please review the information you filled in and try again or contact us at <a href="mailto:contact@<?php echo SITE_EMAIL_DOMAIN;?>">contact@<?php echo SITE_EMAIL_DOMAIN;?></a> if you have difficulties in creating your trial account.');
                                $("#form-error").attr('title', 'Error').dialog("open");
                            }
                        }
                        $("#submit").val('Create Trial Account').removeAttr('disabled');
                    }
                });
                return false;
            }
        });
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
    });
</script>
<!--#content-->
<?php $this->load->view('global/footer-global'); ?>