<?php /* @var $customer QuickBooks_IPP_Object_Customer */ ?>

<div class="contactCard contactCardRight">
    <div class="qbLogo"></div>

    <address>
        <strong><?php echo $customer->getGivenName(); ?> <?php echo $customer->getFamilyName(); ?></strong><br>
        <?php echo $customer->getCompanyName(); ?><br/><br />
        <?php
            if($customer->getBillAddr()){
        ?>
        <?php echo $customer->getBillAddr()->getLine1(); ?><br>
        <?php echo $customer->getBillAddr()->getCity(); ?>, <?php echo $customer->getBillAddr()->getCountrySubDivisionCode(); ?> <?php echo $customer->getBillAddr()->getPostalCode(); ?><br>
        <?php
            }
        ?>

        <abbr title="Business Phone"><strong>Business Phone:</strong></abbr> <?php echo $customer->getPrimaryPhone() ? $customer->getPrimaryPhone()->getFreeFormNumber() : ''; ?><br />
        <abbr title="Cell Phone"><strong>Cell Phone:</strong></abbr> <?php echo $customer->getMobile() ? $customer->getMobile()->getFreeFormNumber() : ''; ?><br />
        <abbr title="Email"><strong>Email:</strong></abbr> <?php echo $customer->getPrimaryEmailAddr() ? $customer->getPrimaryEmailAddr()->getAddress() : ''; ?><br />
        <abbr title="Website"><strong>Website:</strong></abbr> <?php echo $customer->getWebAddr() ? $customer->getWebAddr()->getURI() : ''; ?>

    </address>

</div>