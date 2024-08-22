<?php
function new_system($time = NULL) {
    if ($time == NULL) {
        $time = time();
    }
    return ($time > 1355408820);
}

function getServiceTotalPrice($proposalId = NULL) {
    $s = array('$', ',');
    $r = array('', '');
    $CI =& get_instance();
    $CI->load->database();
    $query = $CI->db->query('select serviceId,price from proposal_services where proposal=' . $proposalId);
    $total = 0;
    $debug = '|';
    foreach ($query->result() as $service) {
        $total += str_replace($s, $r, $service->price);
        $debug .= $service->serviceId . '|';
    }
    echo $debug;
    return $total;
//    mail('razvan.marian@igeek.ro', 'total price of proposal ' . $proposalId, $total);
}

