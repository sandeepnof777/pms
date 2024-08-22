<!DOCTYPE HTML>
<html lang="en-US">
<head>
<script src='https://www.google.com/recaptcha/api.js' async defer></script>

    <?php if (PROD) { ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $_ENV['GOOGLE_ANALYTICS_KEY']; ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?php echo $_ENV['GOOGLE_ANALYTICS_KEY']; ?>');

        //console.log('Announcements'); Show any announcements


    </script>
    <?php } ?>
    <meta charset="UTF-8">
    <title>Proposal Management System</title>
    <meta name="google-site-verification" content="dPl9nuj-fW8_yJGDA5elNad7ZDychQL21nc-0QQwOs4"/>
    <?php 
    $user_data = $this->session->all_userdata();
    $logoutDateTime = null;
    $globalAccountId = 0;
    if($user_data){
        $time = new DateTime();
        $logOutTime = \Carbon\Carbon::createFromTimestamp($user_data['last_activity']);
        $logOutTime->addSeconds($this->config->item('sess_expiration'));
        $logOutTimeString = $logOutTime->toAtomString();
        if(isset($user_data['accountId'])){
            $globalAccountId = $user_data['accountId'];
        }
        
    }
    ?>
    <script>
        <?php if($logOutTime) {
     ?>
        var logoutCountdown = null;
        var logoutDateTime = new Date('<?= $logOutTime ? $logOutTime->toAtomString() : ''; ?>');
        var globalAccountId = <?=$globalAccountId;?>;
    <?php
        }
    ?>
    var timerInterval = null;
    
    var SITE_URL = '<?php echo site_url();?>';
    </script>
    <?php
    echo $this->html->getHeadCodes();
    ?>

</head>
<body onclick="">
<div class="javascript_loaded"><?php
    if (($this->session->flashdata('error') || $this->session->flashdata('notice') || $this->session->flashdata('success') || validation_errors()) && 0) { //disabled, new system in footer-global
        ?>
        <div id="error-message" title="<?php if ($this->session->flashdata('error')) {
            echo 'Error';
        }
        if ($this->session->flashdata('notice')) {
            echo 'Notice';
        }
        if ($this->session->flashdata('success')) {
            echo 'Success';
        }
        if (validation_errors()) {
            echo 'Error';
        } ?>"><?php
        if ($this->session->flashdata('error')) {
            ?>
            <div class="zerror"><?php echo $this->session->flashdata('error') ?></div><?php
        }
        if ($this->session->flashdata('notice')) {
            ?>
            <div class="znotice"><?php echo $this->session->flashdata('notice') ?></div><?php
        }
        if ($this->session->flashdata('success')) {
            ?>
            <div class="zsuccess"><?php echo $this->session->flashdata('success') ?></div><?php
        }
        if (validation_errors()) {
            ?>
            <div class="zerror"><?php echo validation_errors(); ?></div><?php
        }
        ?>
        </div><?php
    }
    ?></div>