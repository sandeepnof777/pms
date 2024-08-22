<div id="content" class="clearfix">
    <div class="widthfix">
        <h1>Add Company Account</h1>
        <h2>&nbsp;</h2>

        <form action="#" method="post" class="validate big">
            <div class="clearfix">
                <p class="clearfix half left">
                    <label>First Name</label>
                    <input class="text required" type="text" name="firstName" id="firstName">
                </p>
                <p class="clearfix half right">
                    <label>Last Name</label>
                    <input class="text required" type="text" name="lastName" id="lastName">
                </p>
                <p class="clearfix half left">
                    <label>Email</label>
                    <input class="text required email" type="text" name="email" id="email">
                </p>
                <p class="clearfix half left">
                    <label>Cell Phone</label>
                    <input class="text required" type="text" name="cellPhone" id="cellPhone">
                </p>
                <p class="clearfix half right">
                    <label>Address</label>
                    <input class="text" type="text" name="address" id="address">
                </p>
                <p class="clearfix half left">
                    <label>City</label>
                    <input class="text" type="text" name="city" id="city">
                </p>
                <p class="clearfix half right">
                    <label>Zip</label>
                    <input class="text" type="text" name="zip" id="zip">
                </p>
                <p class="clearfix half left">
                    <label>Country</label>
                    <input class="text" type="text" name="country" id="country">
                </p>
                <p class="clearfix half left">
                    <label>Password</label>
                    <input class="text required" type="password" name="password" id="password">
                </p>
                <p class="clearfix half right">
                    <label>Password Again</label>
                    <input class="text required" type="password" name="password2" id="password2">
                </p>
                <p class="clearfix half left">
                    <label>Account Type</label>
                    <select name="accountType" id="accountType">
                        <option value="2">User</option>
                        <option value="3">User+</option>
                    </select>
                </p>
            </div>
            <p class="clearfix">
                <label>&nbsp;</label><input type="submit" value="Create" class="btn">
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