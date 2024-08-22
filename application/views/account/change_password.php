<?php $this->load->view('global/header'); ?>
<div id="content" class="clearfix">
    <div class="widthfix">
        <h1>Change Password</h1>
        <h2>&nbsp;</h2>
        <div class="float left clearfix">
            <h2>Update Password</h2>
            <h2>&nbsp;</h2>
            <?php echo form_open('account/change_password', array('class' => 'big', 'autocomplete' => 'off')) ?>
            <p class="clearfix">
                <label>Password:</label>
                <input type="password" name="password" id="password" class="text required">
            </p>
            <p class="clearfix">
                <label>Retype Password:</label>
                <input type="password" name="password2" id="password2" class="text required">
            </p>
            <p class="clearfix">
                <label>&nbsp;</label>
                <input type="submit" value="Change Password" class="btn">
            </p>
            <?php echo form_close() ?>
        </div>
    </div>
</div>
<!--#content-->
<?php $this->load->view('global/footer'); ?>