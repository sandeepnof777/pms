<?php $this->load->view('global/header-global'); ?>

<div style="padding: 100px 0 0;">
    <div id="login-box">
        <div class="content-box">
            <div class="box-header">
                <h4>Log In<a href="<?php echo base_url() ?>" id="logo" style="float: right;"></a></h4>
            </div>
            <div class="box-content">
                <form id="login-form" action="<?php echo site_url('home/signin') ?>" method="post" class="validate">
                    <table class="boxed-table" cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td>
                                <label>Email:</label>
                                <input type="text" name="email" id="email" class="text required email">
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
                                <label for="remember" style="text-align: left; line-height:20px;">Remember me</label>
                            </td>
                        </tr>
                        <tr class="even">
                            <td>
                                <label>&nbsp;</label>
                                <input type="submit" value="Login" class="submit btn" name="signin">
                            </td>
                        </tr>
                        <tr class="centered">
                            <td><a href="<?php echo site_url('home/recover_password') ?>">Forgot your password?</a></td>
                        </tr>
                        <tr class="even">
                            <td>
                                <div id="logging_in" class="loading dis-none">Checking your credentials...</div>
                                <div id="logging_error" class="error dis-none closeonclick">Error: wrong email/password combination!</div>
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
        $("#login-form").submit(function () {
            $("#logging_in").show();
            $("#logging_error").hide();
            var remember = 0;
            if ($('#remember').attr('checked')) {
                remember = 1;
            }
            var url = '<?php echo site_url('account') ?>';
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
                    if (data.success) {
                        document.location.href = url;
                    } else {
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
