<?php $this->load->view('global/header-global'); ?>

<div style="padding: 100px 0 0;">
    <div id="login-box">
        <div class="content-box">
            <div class="box-header">
                <h4 style="height: 30px;"><a href="<?php echo base_url() ?>" id="logo" style="left: 26%;"></a></h4>
            </div>
          
            <div class="box-content">
                <form id="login-otp-form"  class="validate">
                    <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td>
                                <label>Email:</label>
                                <input type="hidden" name="email" id="email" class="text required email" value="<?= $remember_email; ?>">
                                <div id="email" style="margin-top:6px;"><?= $remember_email; ?></div>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <label>Otp:</label>
                                <input type="text" name="otp" id="otp" class="text required" autocomplete="off" maxlength="6">
                            
                            </td>
                        </tr>
                     
                        <tr class="even">
                            <td>
                                
                                <button type="submit"class="btn blue-button" id="AuthBtn" style="width: 180px;left: 115px;padding: 3px 10px;font-size: 14px;margin: 0;"><i class="fa fa-fw fa-sign-in"></i>Submit</button>
                                <div id="otpResend"><a href="#">Resend OTP</a></div>
                             </td>
                        </tr>
                    
                        <tr class="even">
                            <td>


                                <div style="display:none;" id="logging_in" class="loading">Checking your credentials...</div>
                                <div style="display:none;" id="logging_error" class="error closeonclick">Error: wrong email/password combination!</div>
                                <div style="display:none;" id="msg_error" class="error closeonclick"></div>
                                <div style="display:none;" id="msg_success" class="success closeonclick" style="font-color:green;"></div>


                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
    <div id="suggestion">
        <h3>For the best experience, we recommend the following browsers:</h3>
        <div class="browsers clearfix">
            <a href="http://www.google.com/chrome/" target="_blank">
                <img src="/static/images/browsers/chrome.png" alt=""/>
            </a>
            <a href="http://www.mozilla.org/firefox/" target="_blank">
                <img src="/static/images/browsers/firefox.png" alt=""/>
            </a>
            <a href="http://www.apple.com/safari/" target="_blank">
                <img src="/static/images/browsers/safari.png" alt=""/>
            </a>
            <a href="http://www.opera.com/download" target="_blank">
                <img src="/static/images/browsers/opera.png" alt=""/>
            </a>
        </div>
        <div class="suggestion-footer">
            Other browsers will work as well, however it seems there are more issues users have with updates etc. than the browsers we show above.  Thanks!
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {

        // $("a#loginBtn").click(function(e) {
        //     console.log('here');
        //     e.preventDefault();
        //     $("#login-otp-form").submit();
        //     return false;
        // })
        $("#otpResend").hide();

        $("#logging_error, #logging_in").hide();
        $("#AuthBtn").on("click", function (e) {
            e.preventDefault(); // Prevent default form submission behavior
            $("#logging_in").show();
            $("#logging_error").hide();
            var remember = 0;
            if ($('#remember').attr('checked')) {
                remember = 1;
            }
            var url = '<?php echo site_url('account') ?>';

            var request = $.ajax({
                url:"/ajax/otp_validate",
                type:"POST",
                data:{
                    "email":$("#email").val(),
                    "otp":$("#otp").val()
                },
                dataType:"json",
                success:function (data) {
                    if(data.otp==false){
                        $("#otpResend").show();
                    }else{
                        $("#otpResend").hide();

                    }
                                    
                    if (data.success) {
                        document.location.href = url;
                    } else {
                        if (data.auth) {return false;}
                        $("#logging_in").hide();
                        if (data.error) {
                            $("#logging_error").html(data.error);
                        }
                        $("#logging_error").show();
                        if (data.fail!=true) {
                            $("#otpResend").show();
                            $("#logging_in").hide();
                            $("#logging_error").hide();
                            $("#msg_error").html(data.msg);
                            $("#msg_error").show();

                        }
                    }
                }
            });
            return false;
        });

        //otp resend 
      // OTP Resend
$("#otpResend").on("click", function (e) {
    e.preventDefault(); // Prevent default form submission behavior
    $("#msg_error").hide();
    $("#msg_error").hide();
    $("#logging_error").hide();
    $("#logging_in").show();
    
    var request = $.ajax({
        url: "/ajax/resendOtp",
        type: "POST",
        data: {
            email: $("#email").val(),
        },
        dataType: "json",
        success: function (data) {
            if (data.auth) {
                $("#logging_error").hide();
                $("#logging_in").hide();
                $("#msg_success").html(data.msg);
                $("#msg_success").show();

            } else {
                if (data.fail) {
                    $("#msg_success").hide();
                    $("#logging_error").hide();
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.log("Request failed: " + textStatus + " - " + errorThrown);
            $("#logging_error").html("An error occurred. Please try again.");
        }
    });

    return false;
});

setTimeout(function() {
    $("#msg_error").hide();
    $("#msg_success").fadeOut(); // Hide the message after 5 seconds
    $("#msg_error").fadeOut();
    $("#logging_error").fadeOut();
}, 9000); // 1000 milliseconds = 1 seconds
//otp resend close 
    });
</script>
<?php $this->load->view('global/footer-global'); ?>
