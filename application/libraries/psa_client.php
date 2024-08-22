<?php

class PSA_Client
{

    /* @var \models\Accounts */
    private $account;

    /* @var String */
    private $email;

    /* @var String */
    private $password;

    /* @var String */
    private $baseUri;

    function __construct(Array $params)
    {
        if (!isset($params['public'])) {
            $this->account = $params['account'];
            $this->email = $this->account->getPsaEmail();
            $this->password = $this->account->getPsaPassword();
        }
        $this->baseUri = get_instance()->config->item('psa_endpoint');
    }

    public function checkCredentials()
    {
        $responseObj = $this->request('checkCredentials');
        return $responseObj;
    }

    /**
     * @param $endPoint
     * @param array $params
     * @param string $method
     * @return mixed
     */
    private function request($endPoint, Array $params = [], $method = 'POST')
    {
        $client = new \GuzzleHttp\Client(['base_uri' => $this->baseUri, 'verify' => false]);

        $allParams = [
            'query' => [
                'email' => $this->email,
                'password' => $this->password
            ]
        ];

        $queryParams = array_merge($allParams['query'], $params);
        $allParams['query'] = $queryParams;

        $response = $client->request($method, $endPoint, $allParams);

        $responseText = (string)$response->getBody();
        $responseObj = \GuzzleHttp\json_decode($responseText);

        return $responseObj;
    }

    /**
     * Returns an array of the audit types in use for the user's company
     * @return mixed
     */
    public function getAuditTypes()
    {
        $responseObj = $this->request('getAuditTypes');
        return $responseObj;
    }

    /**
     * Adds a location to the user's company
     * @param $params
     * @return mixed
     */
    public function addLocation($params)
    {
        $responseObj = $this->request('location/add', $params);
        return $responseObj;
    }

    /**
     * @param $params
     * @return mixed
     */
    public function createAudit($params)
    {
        $responseObj = $this->request('audit/create', $params);
        return $responseObj;
    }

    /**
     * @param $params
     * @return mixed
     */
    public function reassignLeadAudit($params)
    {
        $responseObj = $this->request('lead/reassign', $params);
        return $responseObj;
    }

    public function inventoryData($params)
    {
        $responseObj = $this->request('inventoryTables', $params, 'POST');
        return $responseObj;
    }
}