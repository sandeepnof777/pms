<div class="header-hider"></div>
<div class="logotopright-hider"></div>
<div id="title-page">
    <h1 class="title_big"><?php echo $proposal->getProposalTitle() ?></h1>

    <div align="center" style="padding-bottom: 35mm;">
        <img src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
            UPLOADPATH . '/separator.jpg')) ?>" width="90%">
    </div>
    <?php if ($proposal->getClient()->getClientAccount()->getName()) { ?>
        <h2 class="company_name" style="text-align: center;"><?php echo ($proposal->getClient()->getClientAccount()->getName() == 'Residential') ? 'Residential Proposal' : $proposal->getClient()->getClientAccount()->getName();  ?></h2>
    <?php } ?>
    <h3 class="company_owner" style="text-align: center; padding-bottom: 100px;"><?php echo $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName()  ?></h3>

    <h3 class="company_owner" style="text-align: center; font-size: 15px !important; line-height: 17px; margin-bottom: 15   px;">Project:</h3>

    <h3 class="company_owner" style="text-align: center; margin-bottom: 0; padding-bottom: 0; line-height: 22px;"><?php echo $proposal->getProjectName()  ?></h3>
    <?php if ($proposal->getProjectAddress()) { ?>
        <h4 style="text-align: center; margin-top: 0; padding-top: 0; font-weight: normal; font-size: 13px;"><?php echo $proposal->getProjectAddress() ?><br><?php echo $proposal->getProjectCity() . ', ' . $proposal->getProjectState() . ' ' . $proposal->getProjectZip() ?></h4>
    <?php } ?>
    <div class="issuedby">
        <p class="clearfix" style="line-height: 16px;">
            <img class="theLogo" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(
                UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())) ?>" alt=""><br>
            <?php echo $proposal->getOwner()->getFullName() ?><br>
            <?php echo $proposal->getOwner()->getTitle() ?>
        </p>
    </div>
</div>
