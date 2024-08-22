
<div id="signature">
<?php if (trim($proposal->getClient()->getCompany()->getContractCopy())) { ?>
    <h2 style="margin-top: 2px; margin-top: 20px;">Authorization to Proceed & Contract</h2>
    <p style="padding: 0; margin: 0;"><?php echo ($proposal->getContractCopy()) ? $proposal->getContractCopy() : $proposal->getClient()->getCompany()->getContractCopy() ?></p>
<?php } ?>

<div style="page-break-inside: avoid">

<h2 style="margin-top: 10px;">Acceptance</h2>

<p style="padding: 0; margin: 0;"><?php echo ($proposal->getPaymentTerm() == 0) ? 'We agree to pay the total sum or balance in full upon completion of this project.' : 'We agree to pay the total sum or balance in full ' . $proposal->getPaymentTerm() . ' days after the completion of work.'; ?></p>

<!--Dynamic Section-->
<?php
echo ($proposal->getPaymentTermText()) ? $proposal->getPaymentTermText() : $proposal->getOwner()->getCompany()->getPaymentTermText();
?>
<!--The signature and stuff-->

<table border="0">
    <tr>
        <td width="30">Date:</td>
        <td width="182" style="border-bottom: 1px solid #000;">&nbsp;<?php if (isset($clientSignature) && ($clientSignature)) {echo  date_format(date_create($clientSignature->getCreatedAt()), "n/d/Y");} ?></td>
    </tr>
</table>


    <?php
    if (!file_exists(UPLOADPATH . '/clients/signatures/signature-' . $proposal->getOwner()->getAccountId() . '.jpg') || $companySig) {
        echo '<br /><br />';
    }
    ?>

<table border="0">
    <tr>
        <td width="230" style="border-bottom: 1px solid #000; padding: 0 0 2px 0;">
        <?php if (file_exists(UPLOADPATH . '/proposal_signature/' . $proposal->getProposalId() . '/client_signature.png')) { ?>
				<img style="width: auto; height: 70px;" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . '/proposal_signature/' . $proposal->getProposalId() . '/client_signature.png')) ?>"  alt="">
		<?php }else if ($clientSignature) {
             if (file_exists(UPLOADPATH . '/proposal_signature/' . $proposal->getProposalId() . '/' . $clientSignature->getSignatureFile())) { ?>
                <img style="width: auto; max-height: 70px;" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . '/proposal_signature/' . $proposal->getProposalId() . '/' . $clientSignature->getSignatureFile())); ?>"  alt="">
        <?php }}?>
        </td>
        <td width="65" style="padding: 0;">&nbsp;</td>
        <td width="230" style="border-bottom: 1px solid #000; padding: 0 0 2px 0;"><?php
            if (file_exists(UPLOADPATH . '/clients/signatures/signature-' . $proposal->getOwner()->getAccountId() . '.jpg') && !$companySig) {
                ?>
                <img style="width: auto; height: 70px;" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . '/clients/signatures/signature-' . $proposal->getOwner()->getAccountId() . '.jpg')) ?>" alt="">
            <?php
            }else if ($companySignature) {
                if (file_exists(UPLOADPATH . '/proposal_signature/' . $proposal->getProposalId() . '/' . $companySignature->getSignatureFile())) { ?>
                    <img style="width: auto; max-height: 70px;" src="data:image/png;base64, <?php echo base64_encode(file_get_contents(UPLOADPATH . '/proposal_signature/' . $proposal->getProposalId(). '/' . $companySignature->getSignatureFile())); ?>" alt="">
            <?php }}?>
        </td>
    </tr>
    <tr>
        <td valign="top" width="220" style="line-height: 1.3">
            <?php
           if ($clientSignature) {
            ?>

            <?php echo $clientSignature->getFirstName() . ' ' . $clientSignature->getLastName() . ' | ' . $clientSignature->getTitle(); ?>
            <br/>
            <?php echo $clientSignature->getCompany() ?><br/>
            <?php echo $clientSignature->getAddress() ?><br/>
            <?php echo $clientSignature->getCity() ?>, <?php echo $clientSignature->getState(); ?><?php echo $clientSignature->getZip() ?>
            <br/>
            <a target="_blank"
                href="mailto:<?php echo $clientSignature->getEmail(); ?>"><?php echo $clientSignature->getEmail(); ?></a>
            <br/>
            <?php

            if ($clientSignature->getCellPhone()) {
                ?>
                C: <?php echo $clientSignature->getCellPhone(); ?><br/>
                <?php
            }
            ?>
            <?php
            if ($clientSignature->getOfficePhone()) {
                ?>
                O: <?php echo $clientSignature->getOfficePhone(); ?><br/>
                <?php
            }


        }else if ($clientSig) {
            ?>
                <?php echo $clientSig->getName() . ' | ' . $clientSig->getTitle(); ?><br />
                <?php echo $clientSig->getCompanyName() ?><br />
                <?php echo $clientSig->getAddress() ?><br />
                <?php echo $clientSig->getCity() ?> <?php echo $clientSig->getState(); ?> <?php echo $clientSig->getZip() ?><br />
                <?php
                    if ($clientSig->getEmail()) {
                ?>
                    <a href="mailto:<?php echo $clientSig->getEmail(); ?>"><?php echo $clientSig->getEmail(); ?></a><br />
                <?php
                    }
                ?>
                <?php
                if ($clientSig->getCellPhone()) {
                    ?>
                    C: <?php echo $clientSig->getCellPhone(); ?><br />
                    <?php
                }
                ?>
                <?php
                if ($clientSig->getOfficePhone()) {
                    ?>
                    O: <?php echo $clientSig->getOfficePhone(); ?><br />
                    <?php
                }
                
                ?>
            <?php
            }
            else {
                echo $proposal->getClient()->getFirstName() . ' ' . $proposal->getClient()->getLastName();
                if ($proposal->getClient()->getTitle()) {
                    echo ' | ' . $proposal->getClient()->getTitle();
                }
                ?>  <br>
                <?php echo $proposal->getClient()->getClientAccount()->getName() ?><br>
                <?php echo $proposal->getClient()->getAddress() ?><br>
                <?php echo $proposal->getClient()->getCity() . ', ' . $proposal->getClient()->getState() . ' ' . $proposal->getClient()->getZip() ?>
                <br>
                <a href="mailto:<?php echo $proposal->getClient()->getEmail() ?>">
                    <?php echo $proposal->getClient()->getEmail() ?></a><br>
                <?php
                $ph = 0;
                if ($proposal->getClient()->getCellPhone()) {
                    echo 'C: ' . $proposal->getClient()->getCellPhone();
                    $ph = 1;
                }
                if ($proposal->getClient()->getBusinessPhone()) {
                    if ($ph) {
                        echo '<br>';
                    }
                    echo 'O: ' . $proposal->getClient()->getBusinessPhone(true);
                }
            }
            if (isset($clientSignature) && ($clientSignature)) {
                echo '<br>';
                ?>
                <span id="signed_span">Signed : <?= date_format(date_create($clientSignature->getCreatedAt()), "m/d/y g:i A"); ?></span>
            <?php
            }
            
            ?><br>
        </td>
        <td width="65"></td>
        <td valign="top" width="220" style="line-height: 1.3">

            <?php
            if ($companySig) {
            ?>
                <?php echo $companySig->getName() . ' | ' . $companySig->getTitle(); ?><br />
                <?php echo $companySig->getCompanyName() ?><br />
                <?php echo $companySig->getAddress() ?><br />
                <?php echo $companySig->getCity() ?> <?php echo $companySig->getState(); ?> <?php echo $companySig->getZip() ?><br />
                <?php
                if ($companySig->getEmail()) {
                    ?>
                    <a href="mailto:<?php echo $companySig->getEmail(); ?>"><?php echo $companySig->getEmail(); ?></a><br />
                    <?php
                }
                ?>
                <?php
                if ($companySig->getCellPhone()) {
                    ?>
                    C: <?php echo $companySig->getCellPhone(); ?><br />
                    <?php
                }
                ?>
                <?php
                if ($companySig->getOfficePhone()) {
                    ?>
                    O: <?php echo $companySig->getOfficePhone(); ?><br />
                    <?php
                }
                ?>
            <?php } else { ?>
                <?php echo $proposal->getOwner()->getFirstName() . ' ' . $proposal->getOwner()->getLastName() . ' | ' . $proposal->getOwner()->getTitle();?>
                <br>
                <?php echo $proposal->getOwner()->getCompany()->getCompanyName(); ?>
                <br>
                <?php echo $proposal->getOwner()->getAddress() ?><br>
                <?php echo $proposal->getOwner()->getCity() ?>, <?php echo $proposal->getOwner()->getState() ?> <?php echo $proposal->getOwner()->getZip() ?><br>
                E: <a href="mailto:<?php echo $proposal->getOwner()->getEmail() ?>"><?php echo $proposal->getOwner()->getEmail() ?></a><br>
                C: <?php echo $proposal->getOwner()->getCellPhone() ?><br />
                P: <?php echo $proposal->getOwner()->getOfficePhoneExt() ? $proposal->getOwner()->getOfficePhone() . ' Ext ' . $proposal->getOwner()->getOfficePhoneExt() : $proposal->getOwner()->getOfficePhone(); ?><br>
                <?php if ($proposal->getClient()->getCompany()->getFax() || $proposal->getOwner()->getFax()) { ?>
                F: <?php echo ($proposal->getOwner()->getFax()) ? $proposal->getOwner()->getFax() : $proposal->getClient()->getCompany()->getFax() ?><br>
                <?php } ?>
                <a href="<?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?>"><?php echo $proposal->getClient()->getCompany()->getCompanyWebsite() ?></a>
            <?php } ?>
        </td>
    </tr>
</table>
</div>
</div>
