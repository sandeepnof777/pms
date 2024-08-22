
<div class="dropdownButton">


    <a id="clientsTableDropdownToggle" class="dropdownToggle clientsTableDropdownToggle" href="javascript:void(0);"
        data-client-id ="<?=$clientData->clientId;?>"
        data-client-fullname ="<?=$clientData->fullName;?>"
        data-client-companyname ="<?=$clientData->clientCompanyName;?>"
        data-email="<?= $clientData->email ?>"
        data-account="<?= $clientData->account; ?>"
        data-phone="<?= $clientData->businessPhone ?>"
        data-client-excluded="<?= $clientData->resend_excluded ?>"
        data-client-edit-permission="<?=$permission;?>"
    >Go</a>
    