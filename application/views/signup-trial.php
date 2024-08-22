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

        .billingState .selector span {
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
        .captcha-code{
            margin-left:145px;
            float:left;
        }
    </style>
    <div style="padding: 20px 0 0;">
        <div id="signup">
            <div class="content-box">
                <div class="box-header">
                    <h4>14-Day Free Trial Sign Up <a href="<?php echo site_url();?>" id="logo"
                                                     title="Go back to <?php echo SITE_NAME;?>" style="float: right;"></a></h4>
                                                     <?php
                if($this->session->flashdata('message'))
                {
                ?>
                    <div class="alert alert-danger">
                        <?php
                        echo $this->session->flashdata('message');
                        ?>
                    </div>
                <?php
                }

                if($this->session->flashdata('success_message'))
                {
                ?>
                    <div class="alert alert-success">
                        <?php
                        echo $this->session->flashdata('success_message');
                        ?>
                    </div>
                <?php
                }
                ?>
                </div>
                <div class="box-content">
                    <form action="#" method="post" class="validate big" id="signup-form">
                        <div id="step1">
                            <table cellpadding="0" cellspacing="0" width="100%">
                                <tr>
                                    <td width="50%" valign="top">
                                        <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
                                            <tr class="even">
                                                <td>
                                                    <label>First Name <span>*</span></label>
                                                    <input tabindex="4" type="text" name="firstName" id="firstName"
                                                           class="text required tiptip"
                                                           title="Please enter your First Name"
                                                           value="<?php echo set_value('firstName'); ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Last Name <span>*</span></label>
                                                    <input tabindex="5" type="text" name="lastName" id="lastName"
                                                           class="text required tiptip"
                                                           title="Please enter your Last Name"
                                                           value="<?php echo set_value('lastName'); ?>">
                                                </td>
                                            </tr>
                                            <tr class="even">
                                                <td>
                                                    <label>Title <span>*</span></label>
                                                    <input tabindex="6" type="text" name="title" id="title"
                                                           class="text required tiptip" title="Please enter your Title"
                                                           value="<?php echo set_value('title'); ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Cell Phone <span>*</span></label>
                                                    <input tabindex="7" type="text" name="cellPhone" id="cellPhone"
                                                           class="text formatPhone required tiptip"
                                                           title="Please enter your Cell Phone"
                                                           value="<?php echo set_value('cellPhone'); ?>">
                                                </td>
                                            </tr>
                                            <tr class="even">
                                                <td>
                                                    <label>Company Phone <span>*</span></label>
                                                    <input tabindex="8" type="text" name="companyPhone"
                                                           id="companyPhone" class="text formatPhone required tiptip"
                                                           title="Please enter your Company Phone"
                                                           value="<?php echo set_value('companyPhone'); ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Company Fax</label>
                                                    <input tabindex="9" type="text" name="companyFax" id="companyFax"
                                                           class="text formatPhone tiptip"
                                                           title="Please enter your Company Fax"
                                                           value="<?php echo set_value('companyFax'); ?>">
                                                </td>
                                            </tr>
                                            <tr class="even">
                                                <td>
                                                    <label>Email <span>*</span></label>
                                                    <input tabindex="10" type="text" name="email" id="email"
                                                           class="text required email tiptip validEmail"
                                                           title="Please enter your Email address"
                                                           value="<?php echo set_value('email'); ?>">
                                                </td>
                                            </tr>
                                            <tr class="">
                                                <td>
                                                    <label>Website <span>*</span></label>
                                                    <input tabindex="11" type="text" name="website" id="website"
                                                           class="text required tiptip"
                                                           title="Please enter your Web Address"
                                                           value="<?php echo set_value('website'); ?>">
                                                </td>
                                            </tr>
                                            <tr class="even">
                                                <td>
                                                    <label>Company Name <span>*</span></label>
                                                    <input tabindex="12" type="text" name="companyName" id="companyName"
                                                           class="text required tiptip"
                                                           title="Please enter your Company Name"
                                                           value="<?php echo set_value('companyName'); ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Company Address <span>*</span></label>
                                                    <input tabindex="13" type="text" name="companyAddress"
                                                           id="companyAddress" class="text required tiptip"
                                                           title="Please enter your Company Address"
                                                           placeholder="Start typing your address"
                                                           value="<?php echo set_value('companyAddress'); ?>">
                                                </td>
                                            </tr>
                                            <tr class="even">
                                                <td>
                                                    <label>Company City <span>*</span></label>
                                                    <input tabindex="14" type="text" name="companyCity" id="companyCity"
                                                           class="text required tiptip"
                                                           title="Please enter your Company City"
                                                           value="<?php echo set_value('companyCity'); ?>">
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                                    <label>Company State <span>*</span></label>
                                                    <input tabindex="15" type="text" name="companyState"
                                                           id="companyState" class="text required tiptip"
                                                           title="Please enter your Company State"
                                                           value="<?php echo set_value('companyState'); ?>">
                                                </td>
                                            </tr>
                                            <tr class="even">
                                                <td>
                                                    <label>Company Zip <span>*</span></label>
                                                    <input tabindex="16" type="text" name="companyZip" id="companyZip"
                                                           class="text required tiptip"
                                                           title="Please enter your Company Zip Code"
                                                           value="<?php echo set_value('companyZip'); ?>">
                                                </td>
                                            </tr>
                                            <tr><td> <div class="form-group captcha-code">
                                                    <div class="g-recaptcha" data-sitekey="6LfMFiApAAAAAPrCm5X09BBqrSWyUdCrErPI8aTV"></div>
                                                    <!-- <div class="g-recaptcha" data-sitekey="6LcGQxETAAAAAM0t6v7KJZi7Q2BItS0L2jtbog4n"></div> -->

                                                     </div>
                                                     <div id="security-error" title="Error" style="height: 100px; text-align: center; padding: 20px;">
    <p>You did not pass the security check. Please try again before submitting.</p>
</div>
                                                    </td></tr>
                                            <tr>
                                                <td>
                                               
                                                    <label>&nbsp;</label>
                                                    <input tabindex="99" type="checkbox" name="tos" class="required"
                                                           id="tos">
                                                    <label for="tos"
                                                           style="width: 60%; line-height: 20px; text-align: left;">
                                                        Accept
                                                        <a href="<?php echo site_url();?>/terms-of-service/"
                                                           target="_blank">Terms of Service</a>.</label>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>
                                              

                                                    <div style="position: relative;" class="clearfix">
                                                        <label>&nbsp;</label>
                                                        <input type="submit" tabindex="100" value="Create Trial Account"
                                                               name="signup" id="submit" class="submit btn"
                                                               style="float: left; margin-left: 55px;">
                                                    </div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td valign="top" style="background: #fefefe; border-left: 1px solid #eee;">
                                        <div style="padding: 0 30px;">
                                            <h4 style="text-align: center;">No downloads. No software to install. Win
                                                More Work!</h4>
                                            <p style="font-size: 14px;">Register now and for <b>14 days</b> you’ll have
                                                access to a trial set of top features and capabilities of easiest way to
                                                create, manage & track your proposals in the pavement industry. See for
                                                yourself how to create proposals 90% faster and increase win rates by
                                                more than 40%.</p>
                                            <p>&nbsp;</p>
                                            <p style="text-align: center; padding-bottom: 10px;">
                                                <img src="<?php site_url() ?>/static/images/pms-screen.jpg" alt=""
                                                     class="shadowed" style="width: 300px; height: auto;">
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
                submitHandler: function (form) {

                var reCaptchaVal = grecaptcha.getResponse();
                    if (reCaptchaVal.length < 1) {
                        $("#security-error").dialog('open');
                        return false;
                    }else{
                    $("#submit").val('Please wait...').attr('disabled', 'disabled');
                    
                    var request = $.ajax({
                        url: "<?php echo site_url('home/create_trial_account') ?>",
                        type: "POST",
                        data: {
                            "company": $("#companyName").val(),
                            "firstName": $("#firstName").val(),
                            "lastName": $("#lastName").val(),
                            "email": $("#email").val(),
                            "title": $("#title").val(),
                            "cellPhone": $("#cellPhone").val(),
                            "website": $("#website").val(),
                            "companyPhone": $("#companyPhone").val(),
                            "companyFax": $("#companyFax").val(),
                            "companyAddress": $("#companyAddress").val(),
                            "companyCity": $("#companyCity").val(),
                            "companyState": $("#companyState").val(),
                            "companyZip": $("#companyZip").val(),
                            "g-recaptcha-response": $("#g-recaptcha-response").val()

                        },
                        dataType: "json",
                        success: function (data) {
                            if (data.success) {
                                url = '<?php echo site_url();?>';
                                console.log("data",data);
                                console.log("url",url);
                               
                                $("#error-message-popup-text").html('<p style="text-align: left; margin-bottom: 15px;">Thanks.  Your Trial Account is created and you will get an email in a couple of seconds with login details.</p>' +
                                    '<p style="text-align: left; margin-bottom: 15px;">You also will get 2 additional example emails showing off how we can send "Leads" & "A New New Proposal"</p>' +
                                    '<p style="text-align: left;">If you have any questions, please contact us at <a href="mailto:support@<?php echo SITE_EMAIL_DOMAIN;?>">support@<?php echo SITE_EMAIL_DOMAIN;?></a> at any time!</p>');
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
                }
                    return false;
                }
            });
            $("#form-error").dialog({
                width: 550,
                modal: true,
                buttons: {
                    Ok: function () {
                        $(this).dialog("close");
                    }
                },
                autoOpen: false,
                close: function () {
                    if (url != '') {
                        document.location.href = url;
                    }
                }
            });

            initAutocomplete();

            function initAutocomplete() {
                // Create the autocomplete object, restricting the search to geographical
                // location types.
                autocomplete = new google.maps.places.Autocomplete(
                    /** @type {!HTMLInputElement} */(document.getElementById('companyAddress')),
                    {
                        fields: ["name", "address_component"]
                    });

                google.maps.event.addListener(autocomplete, 'place_changed', function () {

                    var place = autocomplete.getPlace();
                    var parsedPlace = placeParser(place);

                    $("#companyAddress").val(place.name);
                    $("#companyCity").val(parsedPlace.locality);
                    $("#companyState").val(parsedPlace.state);
                    $("#companyZip").val(parsedPlace.postal_code);
                });
            }

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
    <script src='https://www.google.com/recaptcha/api.js' async defer></script>

<?php $this->load->view('global/footer-global'); ?>