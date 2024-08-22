<?php
foreach($matchedCustomers as $QbCustomer){
    $viewData = array();

    $customer = $QbCustomer['customer'];
    $customerId = str_replace(array('{', '}', '-'), array('','', ''), $customer->getId());

    $viewData['customer'] = $customer;
    $viewData['customerId'] = $customerId;

    $this->load->view('account/quickbooks/client/client-matches-table', $viewData);
}
?>
<!--
    <tr style="padding-top: 10px;">
        <td><input type="radio" name="qbLinkId" value="new" /></td>
        <td>Create a new QuickBooks customer</td>
    </tr>
-->
