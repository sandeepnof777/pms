<?php

class ZohoException extends Exception {
}

class Zoho {

    public function __construct($username, $password, $apikey, $extra_auth_params = array(), $auth_url = "https://
    accounts.zoho.com/login") {
        $this->username = $username;
        $this->password = $password;
        $this->apikey = $apikey;
    }


    /**
     * https://crm.zoho.com/crm/private/xml/Leads/insertRecords?newFormat=1&apikey=APIkey&ticket=Ticket
     **/
    public function insertRecords($type = 'Leads', $data, $extra_post_parameters = array()) {
        $xmldata = $this->XMLfy($data, $type);

        $post = array(
            'scope' => 'crmapi',
            'authtoken' => $this->apikey,
            'newFormat' => 1,
            'apikey' => $this->apikey,
            'version' => 2,
            'xmlData' => $xmldata,
            'duplicateCheck' => 2,
            'wfTrigger' => 'true'
        );

        array_merge($post, $extra_post_parameters);

        $q = http_build_query($post);

//        print_r($post);

        $response = openUrl("https://crm.zoho.com/crm/private/xml/{$type}/insertRecords", $q);

//        print_r($response);
        //print_r($xmldata);
        $this->check_successful_xml($response);

        return true;

    }

    public function getRecords($columns = 'leads(Name)') {
        $this->ensure_opened();

        $post = array(
            'newFormat' => 1,
            'apikey' => $this->apikey,
            'version' => 2,
            'selectColumns' => $columns,
        );

        $q = http_build_query($post);
        $response = openUrl("https://crm.zoho.com/crm/private/json/2Leads/getRecords", $q);

        echo $response;

    }

    public function check_successful_xml($response) {
        $html = new DOMDocument();
        $html->loadXML($response);

        if ($err = $html->getElementsByTagName('error')->item(0)) {
            throw new ZohoException($err->getElementsByTagName('message')->item(0)->nodeValue);
        }

        return true;
    }

    public function XMLfy($arr, $type = 'Leads') {
        $xml = "<{$type}>";
        $no = 1;
        foreach ($arr as $a) {
            $xml .= "<row no=\"$no\">";
            foreach ($a as $key => $val) {
                $xml .= "<FL val=\"$key\">$val</FL>";
            }
            $xml .= "</row>";
            $no += 1;
        }
        $xml .= "</{$type}>";
        return $xml;
    }

}

function openUrl($url, $data = null) {
    $ch = curl_init();
    $timeout = 5;

    if ($data) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_VERBOSE, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    curl_close($ch);
    return $data;
}

?>