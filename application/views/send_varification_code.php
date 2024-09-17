<?php $this->load->view('global/header-global'); ?>

<style>
    .radio-option {
        display: flex;
        align-items: center;
         margin-left:15px;

    }

    .radio-option label {
        margin-left: 10px; /* Space between the radio button and label */
        min-width: 190px; /* Ensures labels align consistently */
    }

    .boxed-table label {
     text-align: left!important; 
 }

 div.error, div.success{
 
    width: 300px!important;
    margin-left:5px!important;
}
#login-box label {
    width: 110px!important;
}

#login-box .text {
    width: 170px!important;
}
div.warning{
    background: #fff3cd;
    color: #856404;
    font-size: 11px;
    border: 2px solid #bfb9a8;
    padding: 5px 10px;
    text-align: center;
    margin: 5px 0;
    font-size: 11px;
    line-height: 17px;
    font-weight: 700;
}
 
</style>
<div style="padding: 100px 0 0;">
    <div id="login-box">
        <div class="content-box">
            <div class="box-header">
                <h4>Verification Code<a href="<?php echo base_url() ?>" id="logo" style="float: right;"></a></h4>
            </div>
            <div class="box-content">
                <form action="#" method="post" class="validate big">
                    <table class="boxed-table send_varification_code" cellpadding="0" cellspacing="0" width="100%">
                        <tr class="even">
                            <td>
                                <p class="text-center">Resetting your password requires 2-Step Verification. Please
                                choose where you would like your Verification Code sent.</p>
                            </td>
                        </tr>
                        <tr>
                        <td>
                            <div class="radio-option">
                                <!-- <input type="radio" class="radioButton" id="auth_email" name="2way_auth" value="email" checked>
                                <label for="auth_email"><?php if($remember_email){echo $remember_email;} ?></label> -->
                                <input type="radio" class="radioButton" id="auth_email" name="2way_auth" value="email" 
                                <?php echo isset($remember_email) ? 'checked' : ''; ?>>
                                <label for="auth_email"><?php if($remember_email){ echo $remember_email; } ?></label>


                            </div>
                        </td>
                         </tr>
                        <tr>
                            <td>
                                <div class="radio-option">
                                    <input type="radio" class="radioButton" id="auth_mobile" name="2way_auth" value="mobile">
                                    <label for="auth_mobile"><?php  if($cellphone){echo $cellphone;} ?></label>
                                </div>
                            </td>
                        </tr>


                        <tr class="even">
                            <td>
                                <label>&nbsp;</label>
                                <input style="margin-left:40px;" type="submit" id="otpResend" value="Send" class="submit btn update-button" name="recover">
                            
                            </td>
                        </tr>  
                    </table>
                    <!--otp box start-->
                    <table  class="boxed-table Otp_box" cellpadding="0" cellspacing="0" width="100%">
                        <tr class="even">
                            <td>
                                <label>Verification Code:</label>
                                <input type="text" name="otp" id="otp" class="text required" autocomplete="off" maxlength="6">
                            
                            </td>
                        </tr>
                     
                        <tr class="even">
                            <td>
                                
                                <button type="submit"class="btn blue-button" id="AuthBtn" style="width: 180px;left: 120px;padding: 3px 10px;font-size: 14px;margin: 0;"><i class="fa fa-fw fa-sign-in"></i>Submit</button>
                                <div class="otpResend" id="otpResend" style="margin-top:12px;"><a href="#">Resend Verification Code</a></div>

                             </td>
                        </tr>
                    
                       
                    </table>
                    
                    <!--otp box close-->
                    <table>
                    <tr class="even">
                            <td>
                                <div  style="width:280px;display:none;margin-left:2px;" id="logging_in" class="loading">Checking your credentials...</div>
                                <div style="display:none;" id="logging_error" class="error closeonclick"></div>
                                <div style="display:none;" id="msg_error" class="error closeonclick"></div>
                                <div style="display:none;" id="msg_success" class="success closeonclick" style="font-color:green;"></div>
                                <div id="timer_count" class="warning">Too many failed attempts. Please wait, You are blocked for: <span id="timer"></span> </div>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
 
    $(document).ready(function () {
   

        $(document).on("keypress", function (e) {
        if (e.which == 13) {  // 13 is the keycode for the "Enter" key
            e.preventDefault(); // Prevent the default form submission
        }
    });
        $(".Otp_box").hide();  
       // $("#logging_error, #logging_in").hide();
        $("#otp-label, #otp-input, #msg_success, #msg_error, #timer_count").hide();
        $("#AuthBtn").on("click", function (e) {
            e.preventDefault(); // Prevent default form submission behavior
            $("#logging_in").show();
            $("#logging_error").hide();
            var remember = 0;
            if ($('#remember').attr('checked')) {
                remember = 1;
            }
            var url = '<?php echo site_url('account/logout') ?>';
            var request = $.ajax({
                url:"/ajax/otp_validate2",
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
                        $(".loading").hide();                        
                        $("#logging_error").hide();
                        swal({
                            title: 'Success',
                            html: 'We have emailed you instructions for resetting your password. Please check your email.',
                            showCloseButton: true,
                        }).then(function() {
                            document.location.href = url;
                            });
                     } else {
                        if (data.auth) {return false;}
                        $("#logging_in").hide();
                        if (data.error) {
                            $("#logging_error").html(data.error);
                        }
                        $("#logging_error").show();
                        if (data.fail=="false" || data.fail==false) {
                            $("#otpResend").show();
                            $("#msg_success").hide();
                            $("#logging_in").hide();
                            $("#logging_error").hide();
                            $("#msg_error").html(data.msg);
                            $("#msg_error").show();
                            if(data.time){
                            $("#msg_error").hide();
                            $("#timer_count").show();
                            $("#msg_success").hide();                            
                            startTimer(data.time); // Start the countdown timer
                            }
                        }
                    }
                }
            });
            return false;
        });

        function startTimer(time) {
            var timerInterval = setInterval(function () {
                if (time >= 0) {
                    $("#otpResend").prop('disabled', true).addClass('ui-state-disabled').removeClass('ui-state-default');
                    $('#timer').text(time + " seconds then try again."); // Update the timer display
                    time--;  // Decrease time                
                } else {
                    $("#timer_count").hide();
                    $('#timer').text("You can try again now.");  // Show when the time is up
                    clearInterval(timerInterval);  // Stop the timer
                    $("#otpResend").prop('disabled', false).removeClass('ui-state-disabled ui-button-disabled').addClass('ui-state-default')
                    .attr('aria-disabled', 'false');
                    $("#sendPasswordEmailHelp form")[0].reset();  // Reset the form if there's one
                    var otpResendButton = $("#otpResend");
                    if (otpResendButton.length) {
                    otpResendButton.css("display", "block");  // Use jQuery to set the display to block
            }

                }
            }, 1000);  // Update every second
        }
      // OTP Resend
 
    $(document).on("click", ".otpResend, #otpResend", function (e) {
     e.preventDefault(); // Prevent default form submission behavior
    $("#msg_error").hide();
    $("#logging_error").hide();
    $("#logging_in").show();
    $(".Otp_box").hide();
    if ($(this).hasClass('otpResend')) {
             $(".Otp_box").show();
             $(".send_varification_code").hide();
        console.log('Class otpResend clicked');
    } else if ($(this).attr('id') === 'otpResend') {
        // Click triggered by element with the ID 'otpResend'
        console.log('ID otpResend clicked');
    }
   // $(".Otp_box").show();
    var method = $("input[name='2way_auth']:checked").val();
    if (!$("input[name='2way_auth']:checked").val()) {
            event.preventDefault(); // Prevent form submission
             $("#msg_error").html("'Please select where you would like the Verification Code sent.");
             $("#msg_error").show();        
    }else{
        var request = $.ajax({
        url: "/ajax/resendOtp2",
        type: "POST",
        data: {
            email: $("#email").val(),
            method:method
        },
        dataType: "json",
        success: function (data) {
            if (data.auth) {
                $(".Otp_box").show();
                $(".send_varification_code").hide();

                 $("#logging_error").hide();
                $("#logging_in").hide();
                $("#msg_success").html(data.msg);
                $("#msg_success").show();

            } else {
                if (!data.fail) {
                     //$("#msg_success").hide();
                     $("#msg_error").text(data.msg);
                     $("#msg_error").show();
                     $("#logging_error").hide();
                     $("#logging_in").hide();
                    if(data.time){
                            $("#msg_error").hide();
                            $("#timer_count").show();
                            $("#msg_success").hide();                            
                            startTimer(data.time); // Start the countdown timer
                         }
                    
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            $("#logging_error").html("An error occurred. Please try again.");
        }
    });

    } 
    return false;
});  
    });

    
</script>
<!--#content-->  <?php $this->load->view('global/footer-global'); ?>