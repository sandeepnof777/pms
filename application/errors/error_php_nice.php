<html>
    <head>
        <title>Error</title>

        <style type="text/css">

            /*font-family: 'Ubuntu', sans-serif;*/
            body {font-family: Arial, sans-serif; margin: 0.5em 0; color: #3f3f41; background-color: #eee;}
            h1 span, h2 span, h4 span, h5 span, h6 span {color: #25AAE1;}
            h1 {font-size: 32px;}

            li { padding: 10px;}

        </style>
    </head>

    <body>



        <div style="width: 600px; margin: auto; padding: 30px; background-color: #ddd; border-radius: 10px; border: 1px solid #777">

            <h1 style="text-align: center">Oops! Seems like we have an issue</h1>

            <ul>
                <li>Please do not use Internet Explorer</li>
                <li>Hit 'refresh' and try again</li>
                <li>If this keeps happening, <a href="mailto:support@<?php echo SITE_EMAIL_DOMAIN;?>?subject=We%20Need%20Help:%20Error [<?php echo date('m/d/Y h:i:s A'); ?>]">Contact Support</a></li>
            </ul>

            <div style="text-align: center;">
                <p><img src="/static/home_logo.png" width="200px" /></p>
            </div>

        </div>



    </body>

</html>