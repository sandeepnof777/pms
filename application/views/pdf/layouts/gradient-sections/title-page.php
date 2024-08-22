<!--Hide Header code start-->

<!--Hide Header code end-->
<div id="title-page">
<?php $imagePath = $proposal->getCoverImagePath();?>
<div id="proposalTitleContainer">
    <table id="proposalTitleTable" width="100%">
        <tr>
            <td></td>
            <td style="text-align: center;"><h1 id="projectTitle"><?php echo $proposal->getProposalTitle(); ?></td>
            <td></td>
        </tr>
    </table>
</div>

<div id="proposalContactContainer">
    <table id="proposalContactTable">
        <tr>
            <td></td>
            <td></td>
            <td style="text-align: center;">
                <?php if ($proposal->getClient()->getClientAccount()->getName()) { ?>
                    <h2 class="company_name"><?php echo ($proposal->getClient()->getClientAccount()->getName() == 'Residential') ? 'Residential Proposal' : $proposal->getClient()->getClientAccount()->getName();  ?></h2>
                <?php } ?>
                <h3 class="company_owner"><?php echo $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName()  ?></h3>
            </td>
            <td></td>
            <td></td>
        </tr>
    </table>
</div>


<div id="projectInfoContainer">

    <table id="proposalContactTable">
        <tr>
            <td></td>
            <td style="text-align: center;">
                <h3 class="company_owner" style="text-align: center; font-size: 15px !important; line-height: 17px; margin-bottom: 15px;">Project:</h3>

                <h3 class="company_owner" style="text-align: center; margin-bottom: 0; padding-bottom: 0; line-height: 22px;"><?php echo $proposal->getProjectName()  ?></h3>
                <?php if ($proposal->getProjectAddress()) { ?>
                    <h4 style="text-align: center; margin-top: 0; padding-top: 0; font-weight: normal; font-size: 13px;"><?php echo $proposal->getProjectAddressString(); ?></h4>
                <?php } ?>
            </td>
            <td></td>
        </tr>
    </table>

</div>



<!-- Logo at bottom of page -->
<?php if (($proposal->getIsShowProposalLogo()==NULL && $proposal->getClient()->getCompany()->getIsShowProposalLogo()=='1') || ($proposal->getIsShowProposalLogo()=='1')) { ?>
<div class="issuedby">
    <p class="clearfix" style="line-height: 16px;">
        <img class="theLogo" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . '/clients/logos/' . $proposal->getClient()->getCompany()->getCompanyLogo())); ?>" alt=""><br>
    </p>
</div>
<?php } ?>

<?php if (file_exists($imagePath)) { ?>
    <div class="coverImageContainer" >
        <img class="coverImage" src="data:image/png;base64, <?php echo base64_encode(file_get_contents($imagePath)); ?>" style="width: 820px; height: 1060px;" />
    </div>
<?php } ?>
</div>
