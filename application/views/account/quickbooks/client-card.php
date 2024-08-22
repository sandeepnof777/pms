<?php /* @var $client \models\Clients */ ?>
<div class="contactCard contactCardLeft">
    <div class="layersLogo"></div>
    <address>
        <strong><?php echo $client->getFullName(); ?></strong><br>
        <?php echo $client->getCompanyName(); ?><br><br />
        <?php echo $client->getAddress(); ?><br>
        <?php echo $client->getCity() ?>, <?php echo $client->getState(); ?> <?php echo $client->getZip(); ?><br>
        <abbr title="Cell Phone"><strong>Cell Phone:</strong></abbr> <?php echo $client->getBusinessPhone(); ?><br />
        <abbr title="Business Phone"><strong>Business Phone:</strong></abbr> <?php echo $client->getCellPhone(); ?><br />
        <abbr title="Email"><strong>Email:</strong></abbr> <?php echo $client->getEmail(); ?><br />
        <abbr title="Website"><strong>Web:</strong></abbr> <?php echo $client->getWebsite(); ?><br />
    </address>

</div>