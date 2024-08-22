<?php
function showTables($boxes) {
    foreach ($boxes as $table) {
        ?>
    <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
            <td class="head" colspan="3"><?php echo ($table['heading']) ?></td>
        </tr>
        <?php
        $k = 0;
        foreach ($table['data'] as $row) {
            $k++;
            ?>
            <tr class="<?php echo ($k % 1) ? 'alternate' : ''; ?> <?php echo @$row[3] ?>">
                <td <?php if ($k == 1) { ?>width="50%" <?php } ?>><?php echo @$row[0] ?></td>
                <td <?php if ($k == 1) { ?>width="25%" <?php } ?>><?php echo @$row[1] ?></td>
                <td <?php if ($k == 1) { ?>width="25%" <?php } ?>><?php echo @$row[2] ?></td>
            </tr>
            <?php
        }
        ?>
    </table>
    <?php
    }
}

function neyraLogo() {
    ?>
<div style="text-align: center;">
    <img src="/static/images/logo.png" alt="" id="logo">
    <div>
        <?php echo @$_POST['print_text']; ?>
    </div>
</div>
    <?php
}

?><!DOCTYPE HTML>
<html lang="en-US">
<head>
<meta charset="UTF-8">
<title><?php echo stripslashes(@$_POST['title']) ?></title>
<style type="text/css">
    .clearfix:after {
        clear: both;
        content: ".";
        display: block;
        font-size: 0;
        height: 0;
        line-height: 0;
        visibility: hidden
    }

    .clearfix {
        display: block;
        zoom: 1
    }

    .clearfix {
        display: inline-block;
    }

        /* Hide from IE Mac \*/
    .clearfix {
        display: block;
    }

        /* End hide from IE Mac */

    body {
        font-family: Arial;
        font-size: 13px;
    }

    h1 {
        font-size: 20px;
        text-align: center;
    }

    h2 {
        text-decoration: underline;
        text-align: center;
        font-weight: normal;
        font-size: 17px;
    }

    h3 {
        font-weight: normal;
    }

    .half {
        width: 48%;
    }

    .left {
        float: left;
    }

    .right {
        float: right;
    }

    .alternate {
        background: #f5f5f5;
    }

    .head {
        background: #eee;
        color: #000;
        text-align: center;
        padding: 3px 0;
        font-weight: bold;
        font-size: 16px;
    }

    table {
        border-top: 1px solid #999;
        border-left: 1px solid #999;
        margin-bottom: 10px;
    }

    td {
        border-bottom: 1px solid #999;
        padding: 2px 5px;
    }

    tr td:last-child {
        border-right: 1px solid #999;
    }

    .black {
        background: #000;
        color: #FFF;
        font-weight: bold;
    }

    #logos {
        width: 100%;
        height: auto;
    }

    #logo {
        width: 200px;
        height: auto;
    }
</style>
</head>
<body>
<h1><?php echo stripslashes(@$_POST['title']) ?></h1>
<h2>Project Name: <strong><?php echo stripslashes(@$_POST['project_name']) ?></strong></h2>
<div class="clearfix">
    <div class="half left">
        <?php
        if (is_array($_POST['boxes']['left'])) {
            showTables($_POST['boxes']['left']);
        }
        if (@$_POST['logo_position'] == 'left') {
            neyraLogo();
        }
        ?>
    </div>
    <div class="half right">
        <?php
        if (is_array($_POST['boxes']['right'])) {
            showTables($_POST['boxes']['right']);
        }
        if (@$_POST['logo_position'] != 'left') {
            neyraLogo();
        }
        ?>
    </div>
</div>
<img id="logos" src="/wp-content/themes/rapid2/images/logos.jpg" alt="">
</body>
</html>