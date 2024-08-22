<?php $this->load->view('global/header-global'); ?>

<div style="padding: 100px 0 0;">
    <div id="login-box">
        <div class="content-box">
            <div class="box-header">
                <h4 style="height: 30px;"><a href="<?php echo base_url() ?>" id="logo" style="left: 26%;"></a></h4>
            </div>
            <div class="box-content">
                <form id="login-form" action="<?php echo site_url('home/signin') ?>" method="post" class="validate">
                    <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td>
                                <label>Email:</label>
                                <input type="text" name="email" id="email" class="text required email" value="<?= $remember_email; ?>">
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <label>Password:</label>
                                <input type="password" name="password" id="password" class="text required" autocomplete="off">
                            </td>
                        </tr>
                        <tr>
                            <td>
                                <label style="line-height:20px;">&nbsp;</label>
                                <input type="checkbox" name="remember" id="remember" value="1" style="margin-top: 8px;">
                                <label for="remember" style="text-align: left;">Remember me</label>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <!--<label>&nbsp;</label>
                                <input type="submit" value="Login" class="submit btn" name="signin">-->
                                <button type="submit"class="btn blue-button" id="loginBtn" style="width: 180px;left: 115px;padding: 3px 10px;font-size: 14px;margin: 0;"><i class="fa fa-fw fa-sign-in"></i> Login</button>
                                <!-- <a href="#" class="btn blue-button" id="loginBtn" style="width: 165px; float: right; padding: 5px 20px; font-size: 15px; margin-right: 16px"><i class="fa fa-fw fa-sign-in"></i> Login</a> -->
                            </td>
                        </tr>
                        <tr class="centered">
                            <td><a href="<?php echo site_url('home/recover_password') ?>" style="left: 40px;position: relative;">Forgot your password?</a></td>
                        </tr>
                        <tr class="even">
                            <td>
                                <div id="logging_in" class="loading">Checking your credentials...</div>
                                <div id="logging_error" class="error closeonclick">Error: wrong email/password combination!</div>
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
    $(window).on('pageshow', function() {
  $('#logging_in').css('display', 'none');
});

    $(document).ready(function () {
  
        $("a#loginBtn").click(function(e) {
            console.log('here');
            e.preventDefault();
            $("#login-form").submit();
            return false;
        })

        $("#logging_error, #logging_in").hide();
        $("#login-form").submit(function () {
            $("#logging_in").show();
            $("#logging_error").hide();
            var remember = 0;
            if ($('#remember').attr('checked')) {
                remember = 1;
            }
            var url = '<?php echo site_url('account') ?>';
            var url2 = '<?php echo site_url('home/auth') ?>';

            var request = $.ajax({
                url:"/ajax/checkLogin",
                type:"POST",
                data:{
                    "email":$("#email").val(),
                    "password":$("#password").val(),
                    "remember":remember
                },
                dataType:"json",
                success:function (data) {
                    if (data.auth) {
                        document.location.href = url2;                        
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
                    }
                }
            });
            return false;
        });
    });
</script>
<?php $this->load->view('global/footer-global'); ?>
