<div id="content" class="clearfix">
    <div class="widthfix">
        <h1>Edit <?php echo $userData->email ?></h1>
        <h2>&nbsp;</h2>
        <form action="#" method="post" class="validate big">
            <div class="clearfix">
                <p class="clearfix half left">
                    <label>First Name</label>
                    <input class="text required" type="text" name="firstName" id="firstName" value="<?php echo $userData->firstName ?>">
                </p>
                <p class="clearfix half right">
                    <label>Last Name</label>
                    <input class="text required" type="text" name="lastName" id="lastName" value="<?php echo $userData->lastName ?>">
                </p>
                <p class="clearfix half left">
                    <label>Change Email</label>
                    <input class="text email" type="text" name="email" id="email">
                </p>
                <p class="clearfix half left">
                    <label>Cell Phone</label>
                    <input class="text required" type="text" name="cellPhone" id="cellPhone" value="<?php echo $userData->cellPhone ?>">
                </p>
                <p class="clearfix half right">
                    <label>Address</label>
                    <input class="text" type="text" name="address" id="address" value="<?php echo $userData->address ?>">
                </p>
                <p class="clearfix half left">
                    <label>City</label>
                    <input class="text" type="text" name="city" id="city" value="<?php echo $userData->city ?>">
                </p>
                <p class="clearfix half right">
                    <label>Zip</label>
                    <input class="text" type="text" name="zip" id="zip" value="<?php echo $userData->zip ?>">
                </p>
                <p class="clearfix half left">
                    <label>Country</label>
                    <input class="text" type="text" name="country" id="country" value="<?php echo $userData->country ?>">
                </p>
                <p class="clearfix half left">
                    <label>Change Password</label>
                    <input class="text" type="password" name="password" id="password">
                </p>
                <p class="clearfix half right">
                    <label>Password Again</label>
                    <input class="text" type="password" name="password2" id="password2">
                </p>
                <p class="clearfix half left">
                    <label>Account Type</label>
                    <select name="accountType" id="accountType">
                        <option value="2"<?php if ($userData->accountType == 2) { echo ' selected="selected"'; } ?>>User</option>
                        <option value="3"<?php if ($userData->accountType == 3) { echo ' selected="selected"'; } ?>>User+</option>
                    </select>
                </p>
            </div>
            <p class="clearfix">
                <label>&nbsp;</label><input type="submit" value="Update" class="btn">
            </p>
        </form>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.validate').validate({
                    rules: {
                        email: {
                            remote: '<?php echo site_url('home/checkEmail3') ?>'
                        },
                        password2: {
                            equalTo: "#password"
                        }
                    },
                    messages : {
                        email: {
                            remote: 'Email already exists in the database!'
                        }
                    }
                });
            });
        </script>
    </div>
</div>
<!--#content-->