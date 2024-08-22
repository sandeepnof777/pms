<style>
    /* customer check list css */
    
    .header_fix {
        z-index: 200;
        font-size: 16px;
    }
    
    .customer-checklist-container {
        margin-left: 50px;
        font-size: 16px;
    }

    .customer-checklist-label {
        font-weight: strong;
    }

    .customer-checklist-span-label {
        width: 210px;
        float: left;
        font-size: 14px;
    }

    .customer-checklist-data {
        margin-left: 42px;
        text-align: left;
    }

    .customer-checklist-data2 {
        padding-left: 212px;
        text-align: left;
    }

    .heading {
        font-size: 18px;
    }
    span{
         line-height: unset!important;
    }
    /*customer check list css close */
</style>

<!-- START CUSTOMER CHECK LIST -->
 <?php 
 

?>
<div class="grid invoice pdf-height page_break page_break_before mg-left-55" style="padding-top: 10px;" id="signature" data-page-id="signature">
    <div class="grid-body">
        <div class="row">
            <div style="page-break-inside: avoid">
                <div class="customer-checklist-container">
                    <p class="customer-checklist-label" style="font-size:18px;"><h3>Customer Billing Information</h3></p>
                    <br>
                    <span class="customer-checklist-span-label"><strong>Billing Contact:</strong></span>
                    <div class="customer-checklist-data billing_contact">
                        <?php  
                            echo $proposalChecklistData->getBillingContact();
                    ?>
                    </div>
                    <p></p>

                    <div style="padding:0px;">
                        <span class="customer-checklist-span-label" ><strong>Billing Address:</strong></span>
                        <div class="customer-checklist-data2 billing_address" >
                            <?php 
                                echo $proposalChecklistData->getBillingAddress();
                            ?>
                        </div>
                    </div>
                    <p></p>
                    <span class="customer-checklist-span-label"><strong>Phone:</strong></span>
                    <div class="customer-checklist-data billing_phone" style="margin-left:210px;"  >
                        <?php  
                            echo $proposalChecklistData->getBillingPhone();
                        ?>
                    </div>
                    <p></p>
                    <span class="customer-checklist-span-label"><strong>Billing Email:</strong></span>
                    <div class="customer-checklist-data billing_email">
                        <?php 
                            echo $proposalChecklistData->getBillingEmail();
                        ?>
                    </div>
                    <p></p>
                    <span class="customer-checklist-span-label style=white-space:nowrap;"><strong>Property Owner Name:</strong></span>
                    <div class="customer-checklist-data property_owner_name">
                        <?php 
                            echo $proposalChecklistData->getPropertyOwnerName();
                        ?>
                    </div>
                    <p></p>
                    <div style="padding:0px;">
                        <span class="customer-checklist-span-label"><strong>Legal Address:</strong></span>
                        <div class="customer-checklist-data2 legal_address" >
                            <?php  
                                echo $proposalChecklistData->getLegalAddress();
                            ?>
                        </div>
                    </div>
                    <p></p>
                    <span class="customer-checklist-span-label" ><strong>Phone:</strong></span>
                    <div class="customer-checklist-data customer_phone"   style="margin-left:210px;" >
                        <?php  
                            echo $proposalChecklistData->getCustomerPhone();
                        ?>
                    </div>
                    <p></p>
                    <span class="customer-checklist-span-label"><strong>Email:</strong></span>
                    <div class="customer-checklist-data customer_email">
                        <?php  
                            echo $proposalChecklistData->getCustomerEmail();
                        ?>
                    </div>
                    <p></p>
                    <p class="customer-checklist-label" style="font-size:18px;"><h3>Onsite Contact Information</h3></p>
                     <br>
                    <span class="customer-checklist-span-label"><strong>Onsite Contact:</strong></span>
                    <div class="customer-checklist-data onsite_contact">
                        <?php  
                            echo $proposalChecklistData->getOnsiteContact();
                        ?>
                    </div>
                    <p></p>
                    <span class="customer-checklist-span-label"><strong>Phone:</strong></span>
                    <div class="customer-checklist-data onsite_phone">
                        <?php  
                            echo $proposalChecklistData->getOnsitePhone();
                         ?>
                    </div>
                    <p></p>
                    <span class="customer-checklist-span-label"><strong>Email:</strong></span>
                    <div class="customer-checklist-data onsite_email">
                        <?php  
                            echo $proposalChecklistData->getOnsiteEmail();
                         ?>
                    </div>
                    <p></p>
                    <span class="customer-checklist-span-label" ><strong>Invoicing Portal Y/N:</strong></span>
                    <div class="customer-checklist-data invoicing_portal"  style="margin-left:210px;">
                        <?php 
                            echo $proposalChecklistData->getInvoicingPortal();
                      ?>
                    </div>
                    <p></p>
                    <div style="padding:0px;">
                        <span class="customer-checklist-span-label" style="width: 160px; white-space:nowrap;"><strong>Special Instructions:</strong></span>
                        <div class="customer-checklist-data2 special_instructions" >
                            <?php  
                                echo $proposalChecklistData->getSpecialInstructions();
                          ?>
                        </div>
                    </div>
                </div>

                <div width="100%"></div>
            </div>
        </div>
    </div>
</div>
 <!-- CLOSE CUSTOMER CHECK LIST -->
