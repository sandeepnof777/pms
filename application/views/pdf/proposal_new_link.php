<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <meta charset="UTF-8">
    <title>New Proposal Sent</title>
    <style type="text/css">
        body {
            padding: 0;
            margin: 0;
            background: url("/static/images/bg.png") repeat-x scroll 0 0 #777777;
            font-family: Arial, Helvetica, sans-serif;
            font-size: 16px;
            color: #444444;
        }

        * {
            padding: 0;
            margin: 0;
        }

        .padding {
            padding: 200px 0;
        }

        .notice {
            width: 600px;
            margin: 0 auto;
            padding: 10px;
            box-shadow: 2px 2px 3px rgba(0, 0, 0, 0.5);
            background: #f4f4f4;
            background: -moz-linear-gradient(center top, #f4f4f4, #eaeaea) repeat scroll 0 0 transparent;
            background: -webkit-gradient(linear, left top, left bottom, from(#fafafa), to(#f2f2f2));
            border-radius: 5px;
        }

        .notice-content {
            /*border-left: 1px dashed #333;*/
            /*border-right: 1px dashed #333;*/
            padding: 0 10px;
        }

        .notice-top {
            height: 10px;
            /*border-top: 1px dashed #333;*/
            margin: 0 10px;
        }

        .notice-bottom {
            height: 10px;
            /*border-bottom: 1px dashed #333;*/
            margin: 0 10px;
        }

        h1 {
            color: #25AAE1;
            font-size: 30px;
            line-height: 48px;
            text-shadow: 1px 1px 1px rgba(0, 0, 0, 0.4);
        }
    </style>
</head>
<body>
<div class="padding">
    <div class="notice">
        <div class="notice-top"></div>
        <div class="notice-content" style="text-align: center;">

            <h1>Hello!</h1>
            <p>We have upgraded our system with sending proposals. To see your proposal for <strong><?php echo $proposal->getProjectName(); ?></strong>,
                please <a href="mailto:<?php echo $proposal->getClient()->getAccount()->getEmail(); ?>?subject=Please send me the proposal for <?php echo $proposal->getProjectName(); ?>">click here</a>.</p>

            <p style="font-size: 0.6em; margin-top: 10px; text-align: center">
                <img width="210" height="70" src="<?php echo site_url('uploads/clients/logos/' . $account->getCompany()->getCompanyLogo() . '?' . rand(100000, 999999)) ?>" alt="Company Logo">
            </p>

        </div>
        <div class="notice-bottom"></div>
    </div>
</div>
<script type="text/javascript" src="/static/js/jquery.min.js"></script>
<script type="text/javascript">

    $(document).ready(function() {

        $("#email1").on('input', function() {
           checkEmailMatch();
        });

        $("#email2").on('input', function() {
            checkEmailMatch();
        });


        function checkEmailMatch() {

            if (validateEmail($('#email1').val())) {
                console.log('valid email');

                if ($("#email1").val() == $("#email2").val()) {
                    $("#matchInfo").html('Email addresses valid!');
                    $("#confirm").prop('disabled', false);
                }
                else {
                    $("#matchInfo").html('Please make sure that the email addresses match!');
                }
            }
            else {
                $("#matchInfo").html('Please enter a valid email address');
            }

        }

        function validateEmail($email) {
            var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
            return emailReg.test( $email );
        }
    });

</script>
</body>
</html>