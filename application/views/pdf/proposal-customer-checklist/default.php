<style type="text/css">
        body {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 13px;
 
         }
        .center-container {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: left;

         }
        .header_fix {
            z-index: 200;
            font-size: 16px;
           }
        table {
              margin-top:50px;
        }
     
        th, td {
            padding: 8px;
            text-align: left;
 
        }
        .span-label {
            width: 150px;
            float: left;
            font-size: 14px;
        }
        .span-data {
            margin-left: 32px;
            text-align: left;
 
        } 
       .heading{
        font-size: 18px;
       }
  
 
    </style>
 
  
<?php  
 /** @var \models\ProposalCustomerCheckList $data */    ?>

 <div class="center-container">
 <p class="heading"  style="margin-left:200pt;" >CUSTOMER CHECKLIST</p>
 <br><br><br><br><br> 
    <p class="header_fix"  style="margin-left:182px;"></p>
    <br><br><br><br><br> 
    <table border="0" cellpadding="0" cellspacing="0"  >
        <tr>
            <td><p class="header_fix"  style="margin-left:180px;">CUSTOMER BILLING INFORMATION</p></td>
        </tr>

        <tr><td colspan="2"> <span class="span-label">Billing Contact:</span>   <span  class="span-data"><?php echo $data->getBillingContact() ?></span></td> </tr>
      
        <tr>
            <td style="padding:0px;">
                <table style="margin:0px;">
                    <tr >
                    <td class="span-label">Billing Address:</td> 
                    <td class="span-data" style="padding-left:20px;"><?php echo $data->getBillingAddress() ?></td>
                    </tr>
               
                </table>
            </td>
        </tr>

        <tr>
            <td colspan="2"><span class="span-label">Phone:</span>  <span class="span-data"><?php echo $data->getBillingPhone() ?></span></td>
         </tr>
        <tr>
            <td colspan="2"><span class="span-label">Billing Email:</span>  <span class="span-data"><?php echo $data->getBillingEmail() ?></span></td>
        </tr>
        <tr>
        <td colspan="2"><span class="span-label">Property Owner Name:</span> <span class="span-data"><?php echo $data->getPropertyOwnerName() ?></span></td>

        </tr>

        <tr>
            <td style="padding:0px;">
                <table style="margin:0px;">
                    <tr >
                    <td class="span-label">Legal Address:</td> 
                    <td class="span-data" style="padding-left:20px;"><?php echo $data->getLegalAddress() ?></td>
                    </tr>
               
                </table>
            </td>
        </tr>

        <tr>
        <td colspan="2"><span class="span-label">Phone:</span> <span class="span-data"> <?php echo $data->getCustomerPhone() ?></span></td>

        </tr>
        <tr>
            <td colspan="2"><span class="span-label">Email:</span>  <span class="span-data"><?php echo $data->getCustomerEmail() ?></span></td>
        </tr>
        <tr>
            <td><p class="header_fix"  style="margin-left:180px;">ONSITE CONTACT INFORMATION</p></td>
        </tr>
        <tr>
        <td colspan="2"><span class="span-label">Onsite Contact:</span>  <span class="span-data"><?php echo $data->getOnsiteContact() ?></span></td>

        </tr>
        <tr>
            <td colspan="2"><span class="span-label">Phone:</span>  <span class="span-data"><?php echo $data->getOnsitePhone() ?></span></td>
        </tr>
        <tr>
        <td colspan="2"><span class="span-label">Email:</span>  <span class="span-data"><?php echo $data->getOnsiteEmail() ?></span></td>

        </tr>
        <tr>
            <td colspan="2"><span class="span-label">Invoicing Portal Y/N:</span>  <span class="span-data"><?php echo $data->getInvoicingPortal() ?></span></td>
        </tr>
        <tr>
        <td colspan="2"><span class="span-label">Special Instructions:</span>  <span class="span-data"><?php echo $data->getSpecialInstructions() ?></span></td>
        </tr>

    </table>
  
 </div>
   
