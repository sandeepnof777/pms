<?php
    // Don't show matched client
    if(!in_array($client->getClientId(), $matchedClients)){
?>
<tr>
    <td><input type="checkbox" name="mergeRow[<?php echo $i; ?>][status]" class="syncSelect"></td>
    <td></td>
    <td></td>
    <td>
        <?php echo $client->getFullName(); ?>
        <input type="hidden" name="mergeRow[<?php echo $i; ?>][client]" value="<?php echo $client->getClientId(); ?>" />
    </td>
    <td><?php echo $client->getCompanyName(); ?></td>
</tr>
<?php
    }
?>