<?php $numMatches = count($matches); ?>
<?php
$customerId = str_replace(array('{', '}', '-'), array('','', ''), $customer->getId());

if( $i % 2 == 0){
    $rowClass = 'even';
}
else {
    $rowClass = 'odd';
}
?>
<tr class="<?php echo $rowClass; ?>">
    <td><input type="checkbox" name="mergeRow[<?php echo $i; ?>][status]" class="syncSelect"></td>
    <td>
        <?php echo $customer->getGivenName(); ?> <?php echo $customer->getFamilyName(); ?>
        <input type="hidden" name="mergeRow[<?php echo $i; ?>][qb]" value="<?php echo $customerId; ?>" />
    </td>
    <td><?php echo $customer->getCompanyName(); ?></td>
    <td>

        <?php
        if($client){ ?>
            <p><?php echo $client->getFullName(); ?></p>
            <input type="hidden" name="mergeRow[<?php echo $i; ?>][client]" value="<?php echo $client->getClientId(); ?>" />
        <?php
        }
        else {
            if($numMatches > 0){
                $customerId = str_replace(array('{', '}', '-'), array('','', ''), $customer->getId());
                ?>
                <select name="mergeRow[<?php echo $i; ?>][match]"">
            <?php

                foreach($matches as $match){
                /* @var $match \models\Clients */
                ?>

                    <option value="<?php echo $match->getClientId(); ?>">Sync With: <?php echo $match->getFullName() . ' [' . $match->getCompanyName(); ?>]</option>

            <?php
                }?>
                    <option value="new" selected="selected">Create new client from this QuickBooks customer</option>
                    <option value="0">Do Not Download</option>
                </select>
            <?php
            }
            else { ?>
                <select name="mergeRow[<?php echo $i; ?>][match]"">
                    <option value="new" selected="selected">Create new client from this QuickBooks customer</option>
                    <option value="0">Do Not Download</option>
                </select>
            <?php
            }
        }
        ?>
    </td>
    <td><?php echo $client ? $client->getCompanyName() : ''; ?></td>


</tr>
