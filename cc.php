<pre>
<?php
    $url = 'https://secure.omegapgateway.com/api/transact.php';
    $transaction_settings = array(
        'username' => 'demo',
        'password' => 'password',
        'type' => 'sale',
        'ccnumber' => '4111111111111111',
        'ccexp' => '0711',
        'cvv' => '999',
        'amount' => '1.50',
    );
    $transaction_settings = array(
        'username' => 'demo',
        'password' => 'password',
        'type' => 'sale',
        'ccnumber' => '4111111111111111',
        'ccexp' => '1011',
        'cvv' => '999',
        'payment' => 'creditcard',
        'ipaddress' => '79.117.149.164',
        'firstname' => 'IPFreely',
        'lastname' => 'Aspacardin',
        'company' => 'iGeekSoftware',
        'address1' => '888',
        'address2' => 'Address2',
        'city' => 'City',
        'state' => 'State',
        'zip' => '77777',
        'country' => 'Romania',
        'phone' => '222222222',
        'email' => 'razvan.marian@igeek.com',
        'amount' => '7455.00'
    );
    $request = $url . '?';
    $k = 0;
    foreach ($transaction_settings as $setting => $value) {
        $k++;
        $request .= $setting . '=' . $value;
        if ($k <> count($transaction_settings)) {
            $request .= '&';
        }
    }
    $response_ampersand = file_get_contents($request);
    $response_array = array();
    parse_str($response_ampersand, $response_array);
    print_r($response_array);
    ?></pre>