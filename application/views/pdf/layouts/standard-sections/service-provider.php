<div style="page-break-after: always"></div>
<div class="header-hider"></div>
<div class="logotopright-hider"></div>

<div id="service-provider" >

    <h1 class="title_big2" style="z-index: 200;"><?php echo $proposal->getClient()->getCompany()->getPdfHeader() ?></h1>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td align="center" width="50%"><h2>Company Info</h2></td>
            <td align="center" width="50%"><h2>Contact Person</h2></td>
        </tr>
        <tr>
            <td align="center" width="50%">
                <img class="theLogo" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                    UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>" alt="">

                <p><?php echo $proposal->getClient()->getCompany()->getCompanyName() ?><br>
                    <?php echo $proposal->getOwner()->getAddress() ?><br>
                    <?php echo $proposal->getOwner()->getCity() ?>, <?php echo $proposal->getOwner()->getState() ?> <?php echo $proposal->getOwner()->getZip() ?><br>
                    <br>
                    P: <?php echo $proposal->getOwner()->getOfficePhone() ?><br>
                    <?php if ($proposal->getClient()->getCompany()->getFax() || $proposal->getOwner()->getFax()) { ?>
                        F: <?php echo ($proposal->getOwner()->getFax()) ? $proposal->getOwner()->getFax() : $proposal->getClient()->getCompany()->getFax() ?><br>
                    <?php } ?>
                    <a href="<?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?>"><?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?></a><br>
                </p>
            </td>
            <td align="center" width="50%">
                <p style="padding-top: 0; margin-top: 0;"><?php echo $proposal->getOwner()->getFullName() ?><br>
                    <?php echo $proposal->getOwner()->getTitle() ?><br>
                    <a href="mailto:<?php echo $proposal->getOwner()->getEmail() ?>"><?php echo $proposal->getOwner()->getEmail() ?></a><br>
                    Cell: <?php echo $proposal->getOwner()->getCellPhone() ?><br />
                    Office <?php echo $proposal->getOwner()->getOfficePhoneExt() ? $proposal->getOwner()->getOfficePhone() . ' Ext ' . $proposal->getOwner()->getOfficePhoneExt() : $proposal->getOwner()->getOfficePhone(); ?>
                </p>
            </td>
        </tr>
    </table>
    <h1 class="title_big_aboutus">About Us</h1>
    <!--<p class="aboutus">--><?php //echo preg_replace('!http://([a-zA-Z0-9./-]+[a-zA-Z0-9/-])!i', '<a href="\\0" target="_blank">\\0</a>', nl2br($proposal->getClient()->getCompany()->getAboutCompany())) ?><!--</p>-->
    <p class="aboutus"><?php echo $proposal->getClient()->getCompany()->getAboutCompany() ?></p>
</div>
