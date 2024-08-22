<?php
    echo phpinfo();

    /*
$postdata = http_build_query(array(
    'email' => 'barrettmjb@gmail.com',
    'password' => 'artcd',
    'clientID' => 167
));
$opts = array('http' =>
array(
    'method' => 'POST',
    'header' => 'Content-type: application/x-www-form-urlencoded',
    'content' => $postdata
)
);
$context = stream_context_create($opts);
$response = file_get_contents('http://pms.pavementlayers.com/api/getProposals', false, $context);
echo $response;
*/
?>