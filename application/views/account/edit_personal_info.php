<div id="content" class="clearfix">
    <div class="widthfix">
        <h1>Edit Personal Info</h1>

        <form action="#" method="post" class="validate small">
            <div class="clearfix">
                <p class="clearfix half left">
                    <label>First Name:</label>
                    <input type="text" name="firstName" id="firstName" class="text required" value="<?php echo $accountInfo->firstName ?>">
                </p>
                <p class="clearfix half right">
                    <label>Last Name:</label>
                    <input type="text" name="lastName" id="lastName" class="text required" value="<?php echo $accountInfo->lastName ?>">
                </p>
                <p class="clearfix half left">
                    <label>City:</label>
                    <input type="text" name="city" id="city" class="text required" value="<?php echo $accountInfo->city ?>">
                </p>
                <p class="clearfix half right">
                    <label>Address:</label>
                    <input type="text" name="address" id="address" class="text required" value="<?php echo $accountInfo->address ?>">
                </p>
                <p class="clearfix half left">
                    <label>Country:</label>
                    <input type="text" name="country" id="country" class="text required" value="<?php echo $accountInfo->country ?>">
                </p>
                <p class="clearfix half right">
                    <label>Zip:</label>
                    <input type="text" name="zip" id="zip" class="text required" value="<?php echo $accountInfo->zip ?>">
                </p>
                <p class="clearfix half left">
                    <label>Cell Phone:</label>
                    <input type="text" name="cellPhone" id="cellPhone" class="text required" value="<?php echo $accountInfo->cellPhone ?>">
                </p>
                <p class="clearfix half right">
                    <label>Business Phone:</label>
                    <input type="text" name="businessPhone" id="businessPhone" class="text" value="<?php echo $accountInfo->businessPhone ?>">
                </p>
                <p class="clearfix half left">
                    <label>Fax:</label>
                    <input type="text" name="fax" id="fax" class="text" value="<?php echo $accountInfo->fax ?>">
                </p>
                <p class="clearfix half right">
                    <label>Timezone:</label>
                    <input type="text" name="timeZone" id="timeZone" class="text required" value="<?php echo $accountInfo->timeZone ?>">
                </p>
            </div>
            <p class="clearfix">
                <label>&nbsp;</label>
                <input type="submit" value="Save" class="btn">
            </p>
        </form>
        <script type="text/javascript">
            $(document).ready(function() {
                $('.validate').validate();
            });
        </script>
    </div>
</div>
<!--#content-->