<?php 
 $addrString = $prospect->address;

 if ($prospect->city) {
     $addrString .= ' ' . $prospect->city;
 }

 if ($prospect->state) {
     $addrString .= ' ' . $prospect->state;
 }

 if ($prospect->zip) {
     $addrString .= ' ' . $prospect->zip;
 }
?>

<div class="dropdownButton">
    <a class="dropdownToggle prospectsTableDropdownToggle" href="javascript:void(0);"

        data-prospect-id ="<?=$prospect->prospectId;?>"
        data-prospect-fullname ="<?=$prospect->firstName . ' ' . $prospect->lastName;?>"
        
        data-email="<?= $prospect->email ?>"
        data-account="<?= $prospect->account; ?>"
        data-company-name="<?= $prospect->companyName;?>"
        data-phone="<?= $prospect->businessPhone; ?>"
        data-url="<?php echo urlencode($addrString); ?>"
    >Go</a>

</div>