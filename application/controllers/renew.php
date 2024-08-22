<?php

class Renew extends MY_Controller {
    ### Extended CI_Controller /application/core/MY_Controller.php
    /**
     * @var Log_manager
     */
    var $log_manager;

    protected $accountData;

    function  __construct() {
        parent::__construct();
        //verifica daca e userul logat - daca nu, redirect pe home/signin si generezi o eroare (te uiti tu unde sa faci asta)
        if (!$this->session->userdata('logged')) {
            $this->session->set_flashdata('error', 'You must be logged in to view this page!');
            redirect('home/signin');
        }
    }

    protected function account($refresh = FALSE) {
        if (($this->accountData === NULL) || $refresh) {
            $this->accountData = $this->em->find('models\Accounts', $this->session->userdata('accountId'));
            if ($this->session->userdata('sublogin')) {
                $sublogin_account = $this->em->find('models\Accounts', $this->session->userdata('sublogin'));
                if ($sublogin_account) {
                    $this->accountData = $sublogin_account;
                }
            }
        }
        return $this->accountData;
    }

    function index() {
        //aici imi faci formular cu 2 pasi. Pasul 2 va fi exact ca ultimul pas de la signup, si prima pagina, dai titlu "Select what to renew"
        //ar fi super sa am toate astea facute
        $account = $this->account();
        $data['accounts'] = $account->getCompany()->getAccounts();

        $this->load->view('global/header-global');
        $this->load->view('renew', $data);
        $this->load->view('global/footer-global');
    }

    function renew_post() {
        //omega payment URL
        $url = 'https://secure.omegapgateway.com/api/transact.php';
        //Setup transaction data
        $transaction_settings = array();
        $transaction_settings['username'] = 'demo';
        $transaction_settings['password'] = 'password';
        $transaction_settings['type'] = 'sale';
        if ($this->input->post('ccType') == 'creditCard') {
            $transaction_settings['ccnumber'] = $this->input->post('ccNumber');
            $transaction_settings['ccexp'] = $this->input->post('expMonth') . $this->input->post('expYear');
            $transaction_settings['cvv'] = $this->input->post('ccCVV');
            $transaction_settings['payment'] = 'creditcard';
            $transaction_settings['status'] = 'Aprooved';
        } else {
            $transaction_settings['account_holder_type'] = $this->input->post('eHType');
            $transaction_settings['account_type'] = $this->input->post('eAccType');
            $transaction_settings['checkaccount'] = $this->input->post('eAccNumber');
            $transaction_settings['checkname'] = $this->input->post('eName');
            $transaction_settings['checkaba'] = $this->input->post('eNumber');
            $transaction_settings['payment'] = 'check';
            $transaction_settings['status'] = 'Pending';
        }

        $transaction_settings['ipaddress'] = $_SERVER['REMOTE_ADDR'];
        $transaction_settings['firstname'] = $this->input->post('billingFirstName');
        $transaction_settings['lastname'] = $this->input->post('billingLastName');
        $transaction_settings['company'] = $this->input->post('billingCompany');
        $transaction_settings['address1'] = $this->input->post('billingAddress1');
        $transaction_settings['address2'] = $this->input->post('billingAddress2');
        $transaction_settings['city'] = $this->input->post('billingCity');
        $transaction_settings['state'] = $this->input->post('billingState');
        $transaction_settings['zip'] = $this->input->post('billingZip');
        $transaction_settings['country'] = $this->input->post('billingCountry');
        $transaction_settings['phone'] = $this->input->post('billingPhone');
        $transaction_settings['email'] = $this->input->post('billingEmail');
        //calculate price
        $price = 0;
        $seats = $this->input->post('seatsNumber');

        $price += 1500 * $seats;

        $transaction_settings['amount'] = $price . '.00';
        //setup request
        $request = $url . '?';
        $k = 0;
        foreach ($transaction_settings as $setting => $value) {
            $k++;
            $request .= $setting . '=' . urlencode($value);
            if ($k <> count($transaction_settings)) {
                $request .= '&';
            }
        }
        //get response
        $response_ampersand = file_get_contents($request);
        $response_array = array();
        parse_str($response_ampersand, $response_array);
        mail('chris@rapidinjection.com', 'PMS - Renewal', 'Transaction Settings: ' . print_r($transaction_settings, true) . "\nResponse:" . ($response_ampersand) . "\nResponse array: " . print_r($response_array, true) . "\nPOST: " . print_r($_POST, true));
        //mail('pow3ron@gmail.com', 'debug - pms payments', 'Transaction Settings: ' . print_r($transaction_settings, true) . "\nResponse:" . ($response_ampersand) . "\nResponse array: " . print_r($response_array, true) . "\nPOST: " . print_r($_POST, true));
        $accounts = array();
        $k = 0;
        $userString = '';
        foreach ($this->input->post('users') as $userId) {
            $k++;
            $account = $this->em->find('models\Accounts', $userId);
            if ($account->getExpires() < time()) {
                $account->setExpires(time() + (365 * 86400));
            } else {
                $account->setExpires($account->getExpires() + (365 * 86400));
            }
            $accounts[$k] = $account;
            $this->em->persist($accounts[$k]);
            $userString .= $account->getFullName() . ' ';
        }
        $this->em->flush();
        $this->em->clear();

        if ($response_array['response'] != 1) {
            echo json_encode(array('error' => 'Transaction Failed!'));
        } else {
            $transaction_settings['details'] = '1 Year Subscription for ' . $seats . ' user accounts';

            $transaction_settings['description'] = 'New Subscription for the following user accounts: ' . $userString;
            $payment = new \models\Payments();
            $payment->setAmount($transaction_settings['amount']);
            if (isset($transaction_settings['ccnumber'])) {
                $payment->setCcnumber('************' . substr($transaction_settings['ccnumber'], -4));
            }
            if (isset($transaction_settings['ccexp'])) {
                $payment->setCcexp($transaction_settings['ccexp']);
            }
            if (isset($transaction_settings['cvv'])) {
                $payment->setCcv($transaction_settings['cvv']);
            }
            if (isset($transaction_settings['payment'])) {
                $payment->setPayment($transaction_settings['payment']);
            }
            if (isset($transaction_settings['account_holder_type'])) {
                $payment->setAccountHolderType($transaction_settings['account_holder_type']);
            }
            if (isset($transaction_settings['account_type'])) {
                $payment->setAccountType($transaction_settings['account_type']);
            }
            if (isset($transaction_settings['checkaccount'])) {
                $payment->setCheckaccount($transaction_settings['checkaccount']);
            }
            if (isset($transaction_settings['checkaba'])) {
                $payment->setCheckaba($transaction_settings['checkaba']);
            }
            //create payment entry
            $payment->setIpAddress($transaction_settings['ipaddress']);
            $payment->setFirtstName($transaction_settings['firstname']);
            $payment->setLastName($transaction_settings['lastname']);
            $payment->setCompany($transaction_settings['company']);
            $payment->setAddress1($transaction_settings['address1']);
            $payment->setAddress2($transaction_settings['address2']);
            $payment->setCity($transaction_settings['city']);
            $payment->setState($transaction_settings['state']);
            $payment->setZip($transaction_settings['zip']);
            $payment->setCountry($transaction_settings['country']);
            $payment->setPhone($transaction_settings['phone']);
            $payment->setEmail($transaction_settings['email']);
            $payment->setOrderDescription($transaction_settings['description']);
            $payment->setStatus($transaction_settings['status']);
            $payment->setDetails($transaction_settings['details']);
            $payment->setOrderId($response_array['transactionid']);
            $payment->setCompanyId($account->getCompany()->getCompanyId());

            echo json_encode(array('success' => 'Transaction Aprooved'));
        }
    }
}