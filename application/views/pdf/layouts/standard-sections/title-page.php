<!--Hide Header code start-->
<div class="header-hider"></div>
<!--Hide Header code end-->
<div id="title-page">
<table width="100%" border="0">
    <tr>
        <td width="70%">
            <p>
                <?php
                echo date('F d, Y', $proposal->getCreated(false));
                ?>
                <br>
                <br>
                Attn: <?php echo $proposal->getClient()->getFullName() ?>
                <?php if ($proposal->getClient()->getClientAccount()->getName() && ($proposal->getClient()->getClientAccount()->getName() != 'Residential')) { ?>
                    <br>
                    <b><?php echo $proposal->getClient()->getClientAccount()->getName() ?></b>
                <?php } ?>
                <br>
                <?php echo $proposal->getClient()->getAddress() ?>
                <br>
                <?php echo $proposal->getClient()->getCity() ?>
                , <?php echo $proposal->getClient()->getState() ?> <?php echo $proposal->getClient()->getZip() ?>
            </p>
        </td>
        <td width="30%">
            <p style="">
                <br>
                <br>
                <b style="font-size: 12px; display: block; border-bottom: 1px solid #DDD; padding-bottom: 2px; color: #444;">Project
                    Name </b>
                <br>
                <span style="display: block; padding-left: 10px; color: #444;">
                    <?php echo $proposal->getProjectName(); ?>
                    <br>
                    <?php echo $proposal->getProjectAddress() ?>
                    <br>
                    <?php echo $proposal->getProjectCity() ?>, <?php echo $proposal->getProjectState() ?> <?php echo $proposal->getProjectZip() ?>
                </span>
            </p>
        </td>
    </tr>
</table>

    <div id="intro">
        <?php echo $proposal->getClient()->getCompany()->getStandardLayoutIntro() ?>
    </div>
</div>
