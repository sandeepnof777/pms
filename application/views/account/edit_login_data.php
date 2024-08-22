<div id="content" class="clearfix">
    <div class="widthfix">
        <h1>Edit Login Data</h1>
        <h2>&nbsp;</h2>
        <div class="float left clearfix">
            <h2>Update login e-mail</h2>
            <h2>&nbsp;</h2>

            <form action="#" method="post" class="validate small">
                <p class="clearfix">
                    <label>Email:</label>
                    <input type="text" name="email" id="email" class="text required email">
                </p>
                <p class="clearfix">
                    <label>Retype Email:</label>
                    <input type="text" name="email2" id="email2" class="text required email">
                </p>
                <p class="clearfix">
                    <label>&nbsp;</label>
                    <input type="submit" value="Save" class="btn">
                </p>
            </form>
        </div>
        <div class="float right clearfix">
            <h2>Update Password</h2>
            <h2>&nbsp;</h2>

            <form action="#" method="post" class="validate2 small">
                <p class="clearfix">
                    <label>Password:</label>
                    <input type="password" name="password" id="password" class="text required">
                </p>
                <p class="clearfix">
                    <label>Password:</label>
                    <input type="password" name="password2" id="password2" class="text required">
                </p>
                <p class="clearfix">
                    <label>&nbsp;</label>
                    <input type="submit" value="Save" class="btn">
                </p>
            </form>
        </div>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.validate').validate({
                    rules: {
                        email: {
                            remote: '<?php echo site_url('home/checkEmail') ?>'
                        },
                        email2:{
                            equalTo: "#email"
                        }
                    },
                    messages : {
                        email: {
                            remote: "Email already exists in database.!"
                        }
                    }
                });
                $('.validate2').validate({
                    rules: {
                        password2: {
                            equalTo: "#password"
                        },
                        password: {
                            minlength: 5,
                            maxlength:12

                        }
                    },
                    messages: {

                    }
                });
            });
        </script>

    </div>
</div>
<!--#content-->