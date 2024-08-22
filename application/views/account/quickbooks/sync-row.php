<?php
    // Things needed for each row

    // Set up input names and values //

    $leftTip = '';
    $rightTip = '';

    // For linked clients
    if($syncRow['matchedCustomer']){
        $inputName = 'linkedClients[' . $syncRow['client']->getClientId() . ']';
        $prioritySelectName = 'matchPriority['. $syncRow['client']->getClientId() . ']';
        $leftTip = 'Update QuickBooks with ' . site_name() . ' client data';
        $rightTip = 'Update ' . site_name() . ' with QuickBooks client data';
        $layersVal = 'layers';
        $qbVal = 'qb';
    }
    else {
        // For client with matches
        if($syncRow['client'] && $syncRow['hasMatches']){
            $inputName = 'matchedClients[' . $syncRow['client']->getClientId() . ']';
            $prioritySelectName = 'priority['. $syncRow['client']->getClientId() . ']';
            $leftTip = 'Update QuickBooks with ' . site_name() . ' client data';
            $rightTip = 'Update ' . site_name() . ' with QuickBooks client data';
            $layersVal = 'layers';
            $qbVal = 'qb';
        }
        else if($syncRow['client'] && !$syncRow['hasMatches']){
            // For client with no matches
            $inputName = 'unmatchedClients[' . $syncRow['client']->getClientId() . ']';
            $prioritySelectName = 'priority['. $syncRow['client']->getClientId() . ']';
            $layersVal = 'layers';
            $qbVal = 'qb';
        }

        else if ($syncRow['unmatchedQb']){
            $id = str_replace(array('{', '}', '-'), array('','', ''), $syncRow['qbCustomer']->getId());

            // For remaining QB customers
            $syncRow['unmatchedQb'] = true;
            $layersInputName = 'unmatchedQb[' . $id . ']';
            $prioritySelectName = '';
            $layersVal = 'layers';
            $qbVal = 'qb';
            $syncRow['showLeftRadio'] = false;
            $syncRow['showRightRadio'] = false;
            $leftTip = 'Import QuickBooks customer as a new ' . site_name() . ' client';
        }
    }

?>

<tr class="syncRow">
    <td class="syncRowContactL" width="45%">

        <?php if($syncRow['client']){

            $client = $syncRow['client'];
            /* @var $client \models\Clients */
            $data['client'] = $client;
            $this->load->view('account/quickbooks/client-card', $data);
        }
        else if($syncRow['unmatchedQb']){

            $data['inputName'] = $layersInputName;
            $this->load->view('account/quickbooks/add-to-layers-card', $data);
        }

        ?>
    </td>

    <td class="syncRowActionL">
        <?php if($syncRow['showLeftRadio']){ ?>
        <input type="radio" name="<?php echo $prioritySelectName; ?>" value="<?php echo $layersVal; ?>" class="syncTip" title="<?php echo $leftTip; ?>" >
        <?php } ?>
    </td>
    <td class="syncRowActionR">
        <?php if($syncRow['showRightRadio']){ ?>
        <input type="radio" name="<?php echo $prioritySelectName; ?>" value="<?php echo $qbVal; ?>" class="syncTip" title="<?php echo $rightTip; ?>">
        <?php } ?>
    </td>
    <td class="syncRowContactR" width="45%">


        <?php
            if($syncRow['matchedCustomer']){
                $customer = $syncRow['matchedCustomer'];
                /* @var $customer QuickBooks_IPP_Object_Customer */
                $data['customer'] = $customer;
                $data['leftTip'] = $leftTip;
                $data['rightTip'] = $rightTip;
                $this->load->view('account/quickbooks/customer-card', $data);
            }
            else if($syncRow['hasMatches']){
                $data['matches'] = $syncRow['matches'];
                $data['inputName'] = $inputName;
                $data['leftTip'] = $leftTip;
                $data['rightTip'] = $rightTip;
                $this->load->view('account/quickbooks/customer-matches-cards', $data);
            }
            else if($syncRow['unmatchedQb']){
                $data['customer'] = $syncRow['qbCustomer'];
                $data['leftTip'] = 'unmqb';
                $data['rightTip'] = $rightTip;
                $this->load->view('account/quickbooks/customer-card', $data);
            }
            else {
                $data['inputName'] = $inputName;
                $data['leftTip'] = $leftTip;
                $data['rightTip'] = $rightTip;
                $this->load->view('account/quickbooks/add-to-quickbooks-card', $data);
            }
        ?>

    </td>
</tr>