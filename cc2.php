<pre>
<?php
    $url = 'https://secure.omegapgateway.com/api/transact.php';
    $transaction_settings = array(
        'username' => 'demo',
        'password' => 'password',
        'type' => 'sale',
        'account_holder_type' => 'business',
        'account_type' => 'checking',
        'checkaccount' => '123123123',
        'checkaba' => '123123123',
        'checkname' => 'adrian',
        'amount' => '3855.00',
        'payment' => 'check'
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