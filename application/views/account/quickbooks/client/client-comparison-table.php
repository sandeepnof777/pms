
    <div style="text-align: center; font-size: 14px;">
        <p>We have noticed that your <?php echo SITE_NAME;?> client data doesn't fully match the QuickBooks customer data.</p>
        <br />
        <p>Choose an option below to sync your client data, or keep any differences.</p>
        <br />
        <hr />
    </div>


    <div style="margin: auto">

        <table id="qbSyncComparison" class="table boxed-table">
            <thead>
                <tr>
                    <th>&nbsp;</th>
                    <th>&nbsp;</th>
                    <th><?php echo SITE_NAME;?></th>
                    <th>QuickBooks</th>
                    <th>Sync Status</th>
                </tr>
            </thead>
            <tbody>

                <?php $syncStatus = (trim($client->getFirstName()) == trim($customer->getGivenName()));  ?>
                <tr class="<?php echo $syncStatus ? 'inSync' : ' outOfSync'; ?>">
                    <td><img src="/3rdparty/icons/<?php echo $syncStatus ? 'tick' : 'cross'; ?>.png" /></td>
                    <td>First Name</td>
                    <td><?php echo $client->getFirstName() ?></td>
                    <td><?php echo $customer->getGivenName(); ?></td>
                    <td><?php echo $syncStatus ? 'OK' : 'Out of Sync'; ?></td>
                </tr>

                <?php $syncStatus = ($client->getLastName() == $customer->getFamilyName());  ?>
                <tr class="<?php echo $syncStatus ? 'inSync' : ' outOfSync'; ?>">
                    <td><img src="/3rdparty/icons/<?php echo $syncStatus ? 'tick' : 'cross'; ?>.png" /></td>
                    <td>Last Name</td>
                    <td><?php echo $client->getLastName() ?></td>
                    <td><?php echo $customer->getFamilyName(); ?></td>
                    <td><?php echo $syncStatus ? 'OK' : 'Out of Sync'; ?></td>
                </tr>

                <?php $syncStatus = ($client->getCompanyName() == $customer->getCompanyName());  ?>
                <tr class="<?php echo $syncStatus ? 'inSync' : ' outOfSync'; ?>">
                    <td><img src="/3rdparty/icons/<?php echo $syncStatus ? 'tick' : 'cross'; ?>.png" /></td>
                    <td>Company Name</td>
                    <td><?php echo $client->getCompanyName(); ?></td>
                    <td><?php echo $customer->getCompanyName(); ?></td>
                    <td><?php echo $syncStatus ? 'OK' : 'Out of Sync'; ?></td>
                </tr>


                <?php

                // Address Fields
                $qbAddr = '';
                $qbCity = '';
                $qbState = '';
                $qbZip = '';

                $customerAddress = $customer->getBillAddr();
                /* @var $customerAddress QuickBooks_IPP_Object_Address */
                if($customerAddress){

                    $qbAddr = $customerAddress->getLine1();
                    $qbCity = $customerAddress->getCity();
                    $qbState = $customerAddress->getCountrySubDivisionCode();
                    $qbZip = $customerAddress->getPostalCode();
                }
                ?>

                <?php $syncStatus = ($client->getAddress() == $qbAddr);  ?>
                <tr class="<?php echo $syncStatus ? 'inSync' : ' outOfSync'; ?>">
                    <td><img src="/3rdparty/icons/<?php echo $syncStatus ? 'tick' : 'cross'; ?>.png" /></td>
                    <td>Address</td>
                    <td><?php echo $client->getAddress(); ?></td>
                    <td><?php echo $qbAddr; ?></td>
                    <td><?php echo $syncStatus ? 'OK' : 'Out of Sync'; ?></td>
                </tr>

                <?php $syncStatus = ($client->getCity() == $qbCity);  ?>
                <tr class="<?php echo $syncStatus ? 'inSync' : ' outOfSync'; ?>">
                    <td><img src="/3rdparty/icons/<?php echo $syncStatus ? 'tick' : 'cross'; ?>.png" /></td>
                    <td>City</td>
                    <td><?php echo $client->getCity(); ?></td>
                    <td><?php echo $qbCity; ?></td>
                    <td><?php echo $syncStatus ? 'OK' : 'Out of Sync'; ?></td>
                </tr>

                <?php $syncStatus = ($client->getState() == $qbState);  ?>
                <tr class="<?php echo $syncStatus ? 'inSync' : ' outOfSync'; ?>">
                    <td><img src="/3rdparty/icons/<?php echo $syncStatus ? 'tick' : 'cross'; ?>.png" /></td>
                    <td>State</td>
                    <td><?php echo $client->getState(); ?></td>
                    <td><?php echo $qbState; ?></td>
                    <td><?php echo $syncStatus ? 'OK' : 'Out of Sync'; ?></td>
                </tr>

                <?php $syncStatus = ($client->getZip() == $qbZip);  ?>
                <tr class="<?php echo $syncStatus ? 'inSync' : ' outOfSync'; ?>">
                    <td><img src="/3rdparty/icons/<?php echo $syncStatus ? 'tick' : 'cross'; ?>.png" /></td>
                    <td>Zip</td>
                    <td><?php echo $client->getZip(); ?></td>
                    <td><?php echo $qbZip; ?></td>
                    <td><?php echo $syncStatus ? 'OK' : 'Out of Sync'; ?></td>
                </tr>

                <?php
                $qbWeb = '';
                $customerWeb = $customer->getWebAddr();
                if($customerWeb){
                    $qbWeb =  $customerWeb->getURI();
                }

                if($client->getWebsite()){
                    if(strstr($client->getWebsite(), 'http://')){
                        $plWeb = $client->getWebsite();
                    }
                    else {
                        $plWeb = 'http://' . $client->getWebsite();
                    }
                }
                else {
                    $plWeb = '';
                }

                $syncStatus = ($plWeb == $qbWeb);  ?>
                <tr class="<?php echo $syncStatus ? 'inSync' : ' outOfSync'; ?>">
                    <td><img src="/3rdparty/icons/<?php echo $syncStatus ? 'tick' : 'cross'; ?>.png" /></td>
                    <td>Website</td>
                    <td><?php echo $plWeb ?></td>
                    <td><?php echo $qbWeb; ?></td>
                    <td><?php echo $syncStatus ? 'OK' : 'Out of Sync'; ?></td>
                </tr>

                <?php
                $qbEmail = '';
                $customerEmail = $customer->getPrimaryEmailAddr();
                /* @var $customerEmail QuickBooks_IPP_Object_PrimaryEmailAddr */
                if($customerEmail){
                    $qbEmail =  $customerEmail->getAddress();
                }
                $syncStatus = ($client->getEmail() == $qbEmail);  ?>
                <tr class="<?php echo $syncStatus ? 'inSync' : ' outOfSync'; ?>">
                    <td><img src="/3rdparty/icons/<?php echo $syncStatus ? 'tick' : 'cross'; ?>.png" /></td>
                    <td>Email</td>
                    <td><?php echo $client->getEmail() ?></td>
                    <td><?php echo $qbEmail; ?></td>
                    <td><?php echo $syncStatus ? 'OK' : 'Out of Sync'; ?></td>
                </tr>

                <?php
                $qbPhone = '';
                $primaryPhone = $customer->getPrimaryPhone();
                if($primaryPhone){
                    $qbPhone = $primaryPhone->getFreeFormNumber();
                }
                $syncStatus = ($client->getBusinessPhone() == $qbPhone);
                ?>
                <tr class="<?php echo $syncStatus ? 'inSync' : ' outOfSync'; ?>">
                    <td><img src="/3rdparty/icons/<?php echo $syncStatus ? 'tick' : 'cross'; ?>.png" /></td>
                    <td>Business Phone</td>
                    <td><?php echo $client->getBusinessPhone() ?></td>
                    <td><?php echo $qbPhone; ?></td>
                    <td><?php echo $syncStatus ? 'OK' : 'Out of Sync'; ?></td>
                </tr>

                <?php
                $qbMobile = '';
                $mobilePhone = $customer->getMobile();
                if($mobilePhone){
                    $qbMobile = $mobilePhone->getFreeFormNumber();
                }
                $syncStatus = ($client->getCellPhone() == $qbMobile);
                ?>
                <tr class="<?php echo $syncStatus ? 'inSync' : ' outOfSync'; ?>">
                    <td><img src="/3rdparty/icons/<?php echo $syncStatus ? 'tick' : 'cross'; ?>.png" /></td>
                    <td>Cell Phone</td>
                    <td><?php echo $client->getCellPhone() ?></td>
                    <td><?php echo $qbMobile; ?></td>
                    <td><?php echo $syncStatus ? 'OK' : 'Out of Sync'; ?></td>
                </tr>
            </tbody>

        </table>

        <div style="width: 500px; margin: auto; padding-left: 30px;">

            <!-- <a class="btn" style="margin-left: 10px; margin-bottom: 20px;" href="<?php echo site_url('clients/edit/' . $client->getClientId()); ?>">Edit Client in <?php echo site_name(); ?></a>-->

            <form method="post" class="form-validated">

                <table class="boxed-table">
                    <tr>
                        <td><input type="radio" name="clientSyncDirection" value="edit"> Edit this client in <?php echo site_name(); ?></td>
                    </tr>
                    <tr>
                        <td><input type="radio" name="clientSyncDirection" value="none"> Make no changes. <?php echo SITE_NAME;?> data is fine.</td>
                    </tr>
                    <tr>
                        <td><input type="radio" name="clientSyncDirection" value="pl" checked="checked"> Use <?php echo site_name(); ?> data to update QuickBooks</td>
                    </tr>
                    <tr>
                        <td><input type="radio" name="clientSyncDirection" value="qb"> Use QuickBooks data to update <?php echo site_name(); ?></td>
                    </tr>
                    <tr>
                        <td><button type="submit" name="qbInvoiceSync" value="1" class="btn ui-button update-button">Confirm</button></td>
                    </tr>
                </table>

            </form>

        </div>

    </div>