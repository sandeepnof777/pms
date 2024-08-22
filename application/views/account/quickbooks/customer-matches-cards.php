<?php
    foreach($matches as $match){
        $data['customer'] = $match;
        $this->load->view('account/quickbooks/customer-card', $data);

        $id = str_replace(array('{', '}', '-'), array('','', ''), $match->getId());
?>

        <div class="matchedContactRadio">
            <input type="radio" name="<?php echo $inputName; ?>" value="<?php echo $id; ?>" class="syncTip" title="Match with this QuickBooks client">
        </div>

<?php
    }
    $data['inputName'] = $inputName;
    $this->load->view('account/quickbooks/add-to-quickbooks-card');
?>



