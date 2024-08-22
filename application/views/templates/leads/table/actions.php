<div class="dropdownButton">
    <?php 
    $lead_converted =0;
    $audit_url =0;
    if($lead->convertedTo){
        $lead_converted =1;
    }
    
    if($lead->psa_audit_url){
        $audit_url =1;
    }
    $addrString = $lead->projectAddress;

        if ($lead->projectCity) {
            $addrString .= ' ' . $lead->projectCity;
        }

        if ($lead->projectState) {
            $addrString .= ' ' . $lead->projectState;
        }

        if ($lead->projectState) {
            $addrString .= ' ' . $lead->projectZip;
        }

       
    ?>
    <a class="dropdownToggle leadsTableDropdownToggle" href="javascript:void(0);"
        data-lead-id ="<?=$lead->leadId;?>"
        data-lead-fullname ="<?=$lead->firstName . ' ' . $lead->lastName;?>"
        data-lead-project-name ="<?=$lead->projectName;?>"
        data-email="<?= $lead->email ?>"
        data-account="<?= $lead->account; ?>"
        data-company-name="<?= $lead->companyName ? $lead->companyName : 'Residential'; ?>"
        data-converted="<?=$lead_converted;?>"
        data-audit-url="<?=$audit_url;?>"
        data-audit-link="<?=$lead->psa_audit_url;?>"
        data-url="<?php echo urlencode($addrString); ?>"
    >Go</a>

</div>